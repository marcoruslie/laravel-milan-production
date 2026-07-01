# Efficient Pooled Import + Live Progress — Design

Date: 2026-07-01
Area: `app/Http/Controllers/admin/adminHomeController.php`, `routes/api.php`, `resources/views/masters/importData.blade.php`

## Problem

The two data-import actions are slow and give the user no feedback beyond a spinner:

- `add()` (Sortir) and `addHasilKiln()` (Kiln) each make **one blocking HTTP call** to the legacy SAP REST server at `http://172.31.3.13/ci-milan-restserver/...` for the entire date range, then loop every returned record doing a **`SELECT ... first()` per record** followed by an individual `insert`/`update` (classic N+1).
- The UI (`importData.blade.php`) fires one `fetch` and shows only an indeterminate spinner. It never awaits `.json()` and `alert`s a raw `Response` object.
- `getProgress()` reads `Session::get('progress')`, but nothing ever writes that value — it is dead scaffolding.

## Goals

1. Make the fetch efficient using concurrency (`Http::pool`).
2. Eliminate the N+1 write pattern.
3. Give the UI a real **0–100%** progress bar.

Non-goals: queues/workers, websockets, changing DB schema, changing import business semantics.

## Decisions (confirmed with user)

- **Progress transport:** Cache + polling. Client generates a `jobId`; controller writes progress into the **file cache** (current default driver); UI polls a small endpoint.
- **DB strategy:** In-memory diff + bulk insert/update. No schema change, no risk to existing duplicate rows.
- **Old `getProgress()`:** Remove it and its route.
- **Pool size:** 5 concurrent requests in flight.
- **Kiln additive semantics:** Preserve exactly (see Risk below).

## Architecture / Data Flow

```
importData.blade.php ──POST {date_start, date_end, jobId}──▶ add() / addHasilKiln()
        │                                                         │ Cache::put("import:{jobId}", {progress, phase, message}, ttl)
        └── poll every 800ms ─▶ GET importProgress/{jobId} ◀──────┘ Cache::get(...)
```

- Progress is a single JSON blob per job in the file cache, key `import:{jobId}`, TTL ~10 min.
- Phases and their progress bands:
  - `fetching` — 0 → 40%, advanced as each pooled daily response returns.
  - `saving` — 40 → 95%, advanced per write chunk.
  - `done` — 100%, with a summary message (inserted / updated counts).
  - `error` — carries the error message.
- On POST resolution the UI forces the bar to 100% (or shows the error) and stops polling. The cache key is left to expire (or cleared on `done`).

## Component 1 — Controller: pooled fetch helper

A private helper builds the list of per-day query param sets for `[date_start, date_end]` (dates are `Ymd` strings as today), then fetches them concurrently:

- Use `Http::pool(fn ($pool) => [...])` with the daily requests.
- Cap concurrency at **5** by chunking the day list into groups of 5 and pooling each group sequentially (Laravel's `Http::pool` fires all passed requests at once, so batching the day-array in slices of 5 enforces the cap).
- After each batch, update the `fetching` progress: `progress = round(daysDone / totalDays * 40)`.
- Merge every response body (`json_decode`) into one flat `$items` array. Empty/failed day responses contribute nothing but are logged.

This helper is shared in spirit by both actions (each passes its own base URL + fixed params: Sortir sends `prdplant=5011`, Kiln does not).

## Component 2 — Controller: bulk persist (no N+1)

For each action, after `$items` is assembled:

1. **Build the incoming key → row map.** Composite key:
   - Sortir: `AUFNR|MATNR|MBLNR|MJAHR`
   - Kiln: `order_id|kode_material|mesin_id` where `order_id=intval(AUFNR)`, `kode_material=intval(MATNR)`, `mesin_id='RK '.substr(VERID,-2)`
2. **One query loads existing rows** for those keys into a map (chunk the `whereIn`/composite lookup if the key set is large; for the composite, load by the natural range or by the set of keys present).
3. **Diff in memory** using the same `$fieldsToCompare` logic that exists today, producing `$toInsert` and `$toUpdate`.
4. **Write in a transaction:**
   - `DB::table(t)->insert($chunk)` for new rows, chunked at ~500.
   - Batched updates for changed rows (per-row `update` by id inside the transaction, or a `CASE`-based bulk update; per-row-by-id is acceptable and still far fewer round-trips than the old per-record `SELECT`+write).
   - Update `saving` progress per chunk.
5. Return `{ status: 'completed', inserted: n, updated: m, fetched: total }` and write the `done` progress blob.

### Sortir specifics
Fields inserted/compared: `AUFNR, MATNR, WERKS, LGORT, BWART, MENGE, ERFMG, ERFME, MAKTX, MBLNR, MJAHR, BUDAT, WRHZET, ARBPL, MVGR4, IDNRK` (unchanged from current code). Idempotent: re-running the same range inserts nothing new.

### Kiln specifics
Insert defaults unchanged (`shift_id=1, user_id=10, lane='', from='Car', no='3', outKiln='0', start/stop='00:00', menit='0 Menit'`, `created_at` from `BUDAT` via `Carbon::createFromFormat('Ymd', ...)`). Update sets `size, jenis, jumlah = existing.jumlah + MENGE, created_at, updated_at=now()`. **Additive `jumlah` behavior is preserved exactly**, including accumulation across duplicate incoming rows that share a key (matching the current sequential re-fetch behavior).

## Component 3 — New endpoint

`GET /api/home/importProgress/{jobId}` → returns `Cache::get("import:{jobId}", {progress:0, phase:'pending', message:''})`.

Route added in `routes/api.php`; the old `POST`/`GET` for `getProgress` and the `getProgress()` method are removed.

## Component 4 — UI rewrite (`importData.blade.php`)

For each of the two panels (Sortir, Kiln):

- Replace the spinner with a Bootstrap **progress bar** (`0%` width, striped+animated while running), a phase label ("Fetching… / Saving…"), a numeric percent, and a result line ("Inserted X, updated Y of Z").
- On click:
  1. `const jobId = crypto.randomUUID();`
  2. Disable inputs + button.
  3. Start a **poll loop** (`setInterval` ~800ms) hitting `importProgress/{jobId}`, updating bar width/label from the JSON.
  4. `await fetch(POST, {jobId, date_start, date_end[, user_id]})`; **check `res.ok` and `await res.json()`** (fixes the current raw-Response bug).
  5. On resolve: stop polling, bar → 100%, show summary from the JSON; on error/`!res.ok`: stop polling, show error state (red bar).
  6. `finally`: re-enable inputs.
- Keep the two independent panels; they can run independently with distinct jobIds.

## Error Handling

- Controller wraps work in try/catch; on exception writes `error` phase blob to cache and returns `{status:'error', message}` with a non-2xx code so the UI branch triggers.
- Pooled per-day request failures are tolerated (logged, skipped) so one bad day does not abort the whole import.
- Transaction rollback on write failure; progress blob set to `error`.

## Testing

- **Manual (primary):** run each import on a small (1–3 day) range; confirm bar animates 0→40 (fetch) →100 (save), and the summary counts are correct.
- **Equivalence:** for a sample range, confirm the pooled+merged dataset equals what the single legacy call returned (same record count).
- **Idempotency (Sortir):** re-run same range → `inserted:0`, no duplicate rows.
- **Progress endpoint:** poll returns increasing `progress` and terminal `done`.

## Risks / Follow-ups

- **Kiln double-counting:** the preserved additive `jumlah` logic means re-importing an already-imported range inflates totals. Left unchanged by request; flagged as a candidate future fix (e.g. store per-source quantity and recompute).
- **File cache concurrency:** two simultaneous imports use distinct jobIds, so no collision. File cache is adequate for this internal LAN tool.
- **No unique DB index:** idempotency relies on the in-memory diff, not a DB constraint. Acceptable for this scope; a unique-index + `upsert` path remains a possible future optimization.

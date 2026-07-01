# Efficient Pooled Import + Live Progress — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make the Sortir/Kiln imports fetch concurrently and write in bulk (no N+1), and give the UI a real 0–100% progress bar.

**Architecture:** Pure diff/date logic is extracted into a unit-tested `App\Support\ImportSupport` helper. The controller adds a pooled fetch method (`Http::pool`, 5 concurrent), builds an existing-row map in one query, diffs in memory, and writes inserts/updates in a transaction while publishing progress to the file cache under a client `jobId`. A new `importProgress/{jobId}` endpoint returns that progress; the Blade page polls it and animates a progress bar.

**Tech Stack:** Laravel 9.19, PHP 8.0+, Carbon, `Http::pool`, file cache, Bootstrap progress bar, vanilla JS `fetch` + `crypto.randomUUID`.

## Global Constraints

- Laravel framework `^9.19`; PHP `^8.0.2`. Use only APIs available there (`Http::pool` is available).
- External API base: `http://172.31.3.13/ci-milan-restserver/index.php/HasilSortir` (params include `prdplant=5011`) and `.../HasilKiln` (no `prdplant`). Date params are `tgll` (start) and `tglh` (end) in `Ymd` string format.
- Pooled fetch concurrency cap: **5** requests in flight.
- Progress cache key format: `import:{jobId}`, TTL 10 minutes, value shape `['progress' => int, 'phase' => string, 'message' => string]`. Phases: `pending`, `fetching` (0–40%), `saving` (40–95%), `done` (100%), `error`.
- Preserve existing business semantics exactly, including Kiln's additive `jumlah = existing + MENGE` (double-counts on re-import — intentional, per spec).
- Sortir table `hasil_sortir_apis`; compare fields: `WERKS, LGORT, BWART, MENGE, ERFMG, ERFME, MAKTX, BUDAT, WRHZET, ARBPL, MVGR4, IDNRK`; identity key: `AUFNR|MATNR|MBLNR|MJAHR`.
- Kiln table `rk_hasil_produksis`; insert defaults: `shift_id=1, user_id=10, lane='', from='Car', no='3', outKiln='0', start='00:00', stop='00:00', menit='0 Menit'`; identity key: `order_id|kode_material|mesin_id` where `order_id=intval(AUFNR)`, `kode_material=intval(MATNR)`, `mesin_id='RK '.substr(VERID,-2)`.
- No DB schema changes. Idempotency (Sortir) comes from the in-memory diff, not a DB constraint.

## File Structure

- **Create** `app/Support/ImportSupport.php` — pure static helpers: `dayRanges()`, `sortirKey()`, `diffSortir()`, `kilnKeyParts()`, `kilnKey()`, `diffKiln()`. No I/O; fully unit-testable.
- **Create** `tests/Unit/ImportSupportTest.php` — unit tests for the helper.
- **Create** `tests/Feature/ImportProgressTest.php` — feature tests for the progress endpoint (uses array cache driver, no DB/HTTP).
- **Modify** `app/Http/Controllers/admin/adminHomeController.php` — add `setProgress()`, `importProgress()`, `fetchPooled()`; rewrite `add()` and `addHasilKiln()`; remove `getProgress()`; add imports.
- **Modify** `routes/api.php` — add `importProgress` route.
- **Modify** `resources/views/masters/importData.blade.php` — progress bars + polling JS.

---

### Task 1: `ImportSupport::dayRanges()` — split a date range into per-day `Ymd` strings

**Files:**
- Create: `app/Support/ImportSupport.php`
- Test: `tests/Unit/ImportSupportTest.php`

**Interfaces:**
- Produces: `App\Support\ImportSupport::dayRanges(string $start, string $end): array` — inclusive list of `Ymd` day strings; `[]` when `end < start`.

- [ ] **Step 1: Write the failing test**

Create `tests/Unit/ImportSupportTest.php`:

```php
<?php

namespace Tests\Unit;

use App\Support\ImportSupport;
use PHPUnit\Framework\TestCase;

class ImportSupportTest extends TestCase
{
    public function test_day_ranges_lists_each_day_inclusive()
    {
        $this->assertSame(
            ['20260701', '20260702', '20260703'],
            ImportSupport::dayRanges('20260701', '20260703')
        );
    }

    public function test_day_ranges_single_day()
    {
        $this->assertSame(['20260701'], ImportSupport::dayRanges('20260701', '20260701'));
    }

    public function test_day_ranges_returns_empty_when_end_before_start()
    {
        $this->assertSame([], ImportSupport::dayRanges('20260703', '20260701'));
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --filter=ImportSupportTest`
Expected: FAIL — class `App\Support\ImportSupport` not found.

- [ ] **Step 3: Write minimal implementation**

Create `app/Support/ImportSupport.php`:

```php
<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Str;

class ImportSupport
{
    /**
     * Inclusive list of Ymd day strings between $start and $end (Ymd format).
     */
    public static function dayRanges(string $start, string $end): array
    {
        $startDate = Carbon::createFromFormat('Ymd', $start)->startOfDay();
        $endDate = Carbon::createFromFormat('Ymd', $end)->startOfDay();

        if ($endDate->lt($startDate)) {
            return [];
        }

        $days = [];
        for ($d = $startDate->copy(); $d->lte($endDate); $d->addDay()) {
            $days[] = $d->format('Ymd');
        }

        return $days;
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=ImportSupportTest`
Expected: PASS (3 tests).

- [ ] **Step 5: Commit**

```bash
git add app/Support/ImportSupport.php tests/Unit/ImportSupportTest.php
git commit -m "feat: add ImportSupport::dayRanges for pooled fetch splitting"
```

---

### Task 2: `ImportSupport::diffSortir()` — in-memory insert/update diff for Sortir

**Files:**
- Modify: `app/Support/ImportSupport.php`
- Test: `tests/Unit/ImportSupportTest.php`

**Interfaces:**
- Consumes: incoming items are stdClass objects (decoded API rows) with string properties `AUFNR, MATNR, WERKS, LGORT, BWART, MENGE, ERFMG, ERFME, MAKTX, MBLNR, MJAHR, BUDAT, WRHZET, ARBPL, MVGR4, IDNRK`. `$existingByKey` maps `sortirKey` → associative array of the existing DB row (includes `id` and the compared fields).
- Produces:
  - `ImportSupport::sortirKey($item): string` — `AUFNR|MATNR|MBLNR|MJAHR`.
  - `ImportSupport::diffSortir(array $incoming, array $existingByKey): array` — `['insert' => array<assoc row incl created_at/updated_at>, 'update' => array<['id'=>int,'data'=>assoc changed fields incl updated_at]>]`. Duplicate incoming keys: first wins.

- [ ] **Step 1: Write the failing test**

Append to `tests/Unit/ImportSupportTest.php` (inside the class):

```php
    private function sortirItem(array $overrides = []): object
    {
        return (object) array_merge([
            'AUFNR' => '1', 'MATNR' => '2', 'MBLNR' => '3', 'MJAHR' => '2026',
            'WERKS' => 'W', 'LGORT' => 'L', 'BWART' => 'B', 'MENGE' => '10',
            'ERFMG' => '1', 'ERFME' => 'BOX', 'MAKTX' => 'TILE', 'BUDAT' => '20260701',
            'WRHZET' => 'Z', 'ARBPL' => 'A', 'MVGR4' => 'Q01', 'IDNRK' => '99',
        ], $overrides);
    }

    public function test_diff_sortir_inserts_new_row()
    {
        $diff = ImportSupport::diffSortir([$this->sortirItem()], []);

        $this->assertCount(1, $diff['insert']);
        $this->assertCount(0, $diff['update']);
        $this->assertSame('10', $diff['insert'][0]['MENGE']);
        $this->assertArrayHasKey('created_at', $diff['insert'][0]);
    }

    public function test_diff_sortir_no_change_when_identical()
    {
        $existing = ['id' => 5, 'AUFNR' => '1', 'MATNR' => '2', 'MBLNR' => '3', 'MJAHR' => '2026',
            'WERKS' => 'W', 'LGORT' => 'L', 'BWART' => 'B', 'MENGE' => '10', 'ERFMG' => '1',
            'ERFME' => 'BOX', 'MAKTX' => 'TILE', 'BUDAT' => '20260701', 'WRHZET' => 'Z',
            'ARBPL' => 'A', 'MVGR4' => 'Q01', 'IDNRK' => '99'];
        $diff = ImportSupport::diffSortir([$this->sortirItem()], ['1|2|3|2026' => $existing]);

        $this->assertCount(0, $diff['insert']);
        $this->assertCount(0, $diff['update']);
    }

    public function test_diff_sortir_updates_changed_fields()
    {
        $existing = ['id' => 5, 'AUFNR' => '1', 'MATNR' => '2', 'MBLNR' => '3', 'MJAHR' => '2026',
            'WERKS' => 'W', 'LGORT' => 'L', 'BWART' => 'B', 'MENGE' => '10', 'ERFMG' => '1',
            'ERFME' => 'BOX', 'MAKTX' => 'TILE', 'BUDAT' => '20260701', 'WRHZET' => 'Z',
            'ARBPL' => 'A', 'MVGR4' => 'Q01', 'IDNRK' => '99'];
        $diff = ImportSupport::diffSortir([$this->sortirItem(['MENGE' => '20'])], ['1|2|3|2026' => $existing]);

        $this->assertCount(0, $diff['insert']);
        $this->assertCount(1, $diff['update']);
        $this->assertSame(5, $diff['update'][0]['id']);
        $this->assertSame('20', $diff['update'][0]['data']['MENGE']);
    }

    public function test_diff_sortir_dedupes_incoming_first_wins()
    {
        $diff = ImportSupport::diffSortir([$this->sortirItem(), $this->sortirItem(['MENGE' => '99'])], []);

        $this->assertCount(1, $diff['insert']);
        $this->assertSame('10', $diff['insert'][0]['MENGE']);
    }
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --filter=ImportSupportTest`
Expected: FAIL — `Call to undefined method App\Support\ImportSupport::diffSortir()`.

- [ ] **Step 3: Write minimal implementation**

Add to `app/Support/ImportSupport.php` (inside the class):

```php
    public const SORTIR_KEYS = ['AUFNR', 'MATNR', 'MBLNR', 'MJAHR'];

    public const SORTIR_COMPARE = [
        'WERKS', 'LGORT', 'BWART', 'MENGE', 'ERFMG', 'ERFME',
        'MAKTX', 'BUDAT', 'WRHZET', 'ARBPL', 'MVGR4', 'IDNRK',
    ];

    public static function sortirKey(object $item): string
    {
        return implode('|', [$item->AUFNR, $item->MATNR, $item->MBLNR, $item->MJAHR]);
    }

    public static function diffSortir(array $incoming, array $existingByKey): array
    {
        $insert = [];
        $update = [];
        $seen = [];
        $now = Carbon::now()->toDateTimeString();

        foreach ($incoming as $item) {
            $key = self::sortirKey($item);
            if (isset($seen[$key])) {
                continue; // duplicate incoming row, first wins
            }
            $seen[$key] = true;

            if (isset($existingByKey[$key])) {
                $existing = $existingByKey[$key];
                $changed = [];
                foreach (self::SORTIR_COMPARE as $field) {
                    if ((string) ($existing[$field] ?? '') !== (string) ($item->$field ?? '')) {
                        $changed[$field] = $item->$field;
                    }
                }
                if (! empty($changed)) {
                    $changed['updated_at'] = $now;
                    $update[] = ['id' => $existing['id'], 'data' => $changed];
                }
            } else {
                $insert[] = [
                    'AUFNR' => $item->AUFNR, 'MATNR' => $item->MATNR, 'WERKS' => $item->WERKS,
                    'LGORT' => $item->LGORT, 'BWART' => $item->BWART, 'MENGE' => $item->MENGE,
                    'ERFMG' => $item->ERFMG, 'ERFME' => $item->ERFME, 'MAKTX' => $item->MAKTX,
                    'MBLNR' => $item->MBLNR, 'MJAHR' => $item->MJAHR, 'BUDAT' => $item->BUDAT,
                    'WRHZET' => $item->WRHZET, 'ARBPL' => $item->ARBPL, 'MVGR4' => $item->MVGR4,
                    'IDNRK' => $item->IDNRK,
                    'created_at' => $now, 'updated_at' => $now,
                ];
            }
        }

        return ['insert' => $insert, 'update' => $update];
    }
```

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=ImportSupportTest`
Expected: PASS (7 tests total).

- [ ] **Step 5: Commit**

```bash
git add app/Support/ImportSupport.php tests/Unit/ImportSupportTest.php
git commit -m "feat: add ImportSupport::diffSortir in-memory diff"
```

---

### Task 3: `ImportSupport::diffKiln()` — additive in-memory diff for Kiln

**Files:**
- Modify: `app/Support/ImportSupport.php`
- Test: `tests/Unit/ImportSupportTest.php`

**Interfaces:**
- Consumes: incoming stdClass rows with `AUFNR, MATNR, VERID, BEZEI5 (size), BEZEI1 (jenis), MENGE, BUDAT (Ymd)`. `$existingByKey` maps `kilnKey` → assoc existing row (includes `id, size, jenis, jumlah, created_at`).
- Produces:
  - `ImportSupport::kilnKeyParts(object $item): array` — `['order_id'=>int,'kode_material'=>int,'mesin_id'=>string]`.
  - `ImportSupport::kilnKey(object $item): string` — `order_id|kode_material|mesin_id`.
  - `ImportSupport::diffKiln(array $incoming, array $existingByKey): array` — `['insert' => array<full assoc insert row incl created_at>, 'update' => array<['id'=>int,'data'=>['size','jenis','jumlah','created_at','updated_at']]>]`. `jumlah` is additive: existing DB value plus every matching incoming `MENGE` (accumulates across duplicate incoming rows too).

- [ ] **Step 1: Write the failing test**

Append to `tests/Unit/ImportSupportTest.php` (inside the class):

```php
    private function kilnItem(array $overrides = []): object
    {
        return (object) array_merge([
            'AUFNR' => '1001', 'MATNR' => '2002', 'VERID' => 'XX03',
            'BEZEI5' => '30X60', 'BEZEI1' => 'GLOSSY', 'MENGE' => '5', 'BUDAT' => '20260701',
        ], $overrides);
    }

    public function test_diff_kiln_inserts_new_with_menge_as_jumlah()
    {
        $diff = ImportSupport::diffKiln([$this->kilnItem()], []);

        $this->assertCount(1, $diff['insert']);
        $this->assertCount(0, $diff['update']);
        $this->assertSame(1001, $diff['insert'][0]['order_id']);
        $this->assertSame('RK 03', $diff['insert'][0]['mesin_id']);
        $this->assertEquals(5, $diff['insert'][0]['jumlah']);
        $this->assertSame(1, $diff['insert'][0]['shift_id']);
    }

    public function test_diff_kiln_accumulates_duplicate_incoming()
    {
        $diff = ImportSupport::diffKiln(
            [$this->kilnItem(['MENGE' => '5']), $this->kilnItem(['MENGE' => '7'])],
            []
        );

        $this->assertCount(1, $diff['insert']);
        $this->assertEquals(12, $diff['insert'][0]['jumlah']);
    }

    public function test_diff_kiln_adds_to_existing_jumlah()
    {
        $existing = ['id' => 9, 'size' => '30X60', 'jenis' => 'GLOSSY', 'jumlah' => '10',
            'created_at' => '2026-07-01 00:00:00'];
        $diff = ImportSupport::diffKiln([$this->kilnItem(['MENGE' => '5'])], ['1001|2002|RK 03' => $existing]);

        $this->assertCount(0, $diff['insert']);
        $this->assertCount(1, $diff['update']);
        $this->assertSame(9, $diff['update'][0]['id']);
        $this->assertEquals(15, $diff['update'][0]['data']['jumlah']);
    }
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --filter=ImportSupportTest`
Expected: FAIL — `Call to undefined method App\Support\ImportSupport::diffKiln()`.

- [ ] **Step 3: Write minimal implementation**

Add to `app/Support/ImportSupport.php` (inside the class):

```php
    public static function kilnKeyParts(object $item): array
    {
        return [
            'order_id' => intval($item->AUFNR),
            'kode_material' => intval($item->MATNR),
            'mesin_id' => 'RK ' . Str::substr($item->VERID, -2),
        ];
    }

    public static function kilnKey(object $item): string
    {
        $p = self::kilnKeyParts($item);

        return $p['order_id'] . '|' . $p['kode_material'] . '|' . $p['mesin_id'];
    }

    public static function diffKiln(array $incoming, array $existingByKey): array
    {
        $now = Carbon::now()->toDateTimeString();
        $work = [];    // key => working row
        $origin = [];  // key => 'db' | 'new'

        foreach ($incoming as $item) {
            $key = self::kilnKey($item);
            $parts = self::kilnKeyParts($item);
            $menge = (float) $item->MENGE;
            $createdAt = Carbon::createFromFormat('Ymd', $item->BUDAT)->toDateTimeString();

            if (isset($work[$key])) {
                $work[$key]['jumlah'] = (float) $work[$key]['jumlah'] + $menge;
                $work[$key]['size'] = $item->BEZEI5;
                $work[$key]['jenis'] = $item->BEZEI1;
                $work[$key]['created_at'] = $createdAt;
            } elseif (isset($existingByKey[$key])) {
                $existing = $existingByKey[$key];
                $work[$key] = [
                    'id' => $existing['id'],
                    'order_id' => $parts['order_id'],
                    'kode_material' => $parts['kode_material'],
                    'mesin_id' => $parts['mesin_id'],
                    'size' => $item->BEZEI5,
                    'jenis' => $item->BEZEI1,
                    'jumlah' => (float) $existing['jumlah'] + $menge,
                    'created_at' => $createdAt,
                ];
                $origin[$key] = 'db';
            } else {
                $work[$key] = [
                    'order_id' => $parts['order_id'],
                    'kode_material' => $parts['kode_material'],
                    'mesin_id' => $parts['mesin_id'],
                    'size' => $item->BEZEI5,
                    'jenis' => $item->BEZEI1,
                    'jumlah' => $menge,
                    'created_at' => $createdAt,
                ];
                $origin[$key] = 'new';
            }
        }

        $insert = [];
        $update = [];

        foreach ($work as $key => $row) {
            if (($origin[$key] ?? 'new') === 'db') {
                $update[] = ['id' => $row['id'], 'data' => [
                    'size' => $row['size'],
                    'jenis' => $row['jenis'],
                    'jumlah' => $row['jumlah'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $now,
                ]];
            } else {
                $insert[] = [
                    'shift_id' => 1,
                    'order_id' => $row['order_id'],
                    'user_id' => 10,
                    'kode_material' => $row['kode_material'],
                    'mesin_id' => $row['mesin_id'],
                    'lane' => '',
                    'size' => $row['size'],
                    'jenis' => $row['jenis'],
                    'from' => 'Car',
                    'no' => '3',
                    'outKiln' => '0',
                    'start' => '00:00',
                    'stop' => '00:00',
                    'menit' => '0 Menit',
                    'jumlah' => $row['jumlah'],
                    'created_at' => $row['created_at'],
                ];
            }
        }

        return ['insert' => $insert, 'update' => $update];
    }
```

> Note: any existing key touched by an incoming row is emitted as an update (its `jumlah` always changes because it is additive). This intentionally preserves the legacy re-import double-count behavior.

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=ImportSupportTest`
Expected: PASS (10 tests total).

- [ ] **Step 5: Commit**

```bash
git add app/Support/ImportSupport.php tests/Unit/ImportSupportTest.php
git commit -m "feat: add ImportSupport::diffKiln additive in-memory diff"
```

---

### Task 4: Progress endpoint + cache helper; remove dead `getProgress`

**Files:**
- Modify: `app/Http/Controllers/admin/adminHomeController.php` (add `setProgress`, `importProgress`; remove `getProgress` at lines 213-217)
- Modify: `routes/api.php:31` (add route after the addData routes)
- Test: `tests/Feature/ImportProgressTest.php`

**Interfaces:**
- Produces:
  - `adminHomeController::setProgress(?string $jobId, int $progress, string $phase, string $message = ''): void` — writes `['progress','phase','message']` to `Cache` key `import:{jobId}` (TTL 10 min); no-op when `$jobId` is null/empty.
  - `adminHomeController::importProgress(string $jobId): JsonResponse` — returns the cached blob or `['progress'=>0,'phase'=>'pending','message'=>'']`.
  - Route: `GET /api/home/importProgress/{jobId}`.

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/ImportProgressTest.php`:

```php
<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ImportProgressTest extends TestCase
{
    public function test_returns_pending_when_no_progress_stored()
    {
        $this->getJson('/api/home/importProgress/does-not-exist')
            ->assertOk()
            ->assertJson(['progress' => 0, 'phase' => 'pending', 'message' => '']);
    }

    public function test_returns_stored_progress()
    {
        Cache::put('import:job-123', ['progress' => 42, 'phase' => 'saving', 'message' => 'Saving 5/10'], now()->addMinutes(5));

        $this->getJson('/api/home/importProgress/job-123')
            ->assertOk()
            ->assertJson(['progress' => 42, 'phase' => 'saving', 'message' => 'Saving 5/10']);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --filter=ImportProgressTest`
Expected: FAIL — 404 / route `importProgress` not defined.

- [ ] **Step 3a: Add the route**

In `routes/api.php`, immediately after line 30 (`addDataKiln`), add:

```php
Route::get('/home/importProgress/{jobId}', [adminHomeController::class, 'importProgress']);
```

- [ ] **Step 3b: Add helper + endpoint, remove dead method**

In `app/Http/Controllers/admin/adminHomeController.php`, delete the existing `getProgress()` method (currently lines 213-217):

```php
    public function getProgress()
    {

        return response()->json(['progress' => Session::get('progress', 0)]);
    }
```

Replace it with:

```php
    private function setProgress(?string $jobId, int $progress, string $phase, string $message = ''): void
    {
        if (empty($jobId)) {
            return;
        }

        Cache::put("import:{$jobId}", [
            'progress' => $progress,
            'phase' => $phase,
            'message' => $message,
        ], now()->addMinutes(10));
    }

    public function importProgress(string $jobId)
    {
        return response()->json(Cache::get("import:{$jobId}", [
            'progress' => 0,
            'phase' => 'pending',
            'message' => '',
        ]));
    }
```

(`Cache` is already imported at line 18. Leave the `Session` import in place — it is used elsewhere in the file.)

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=ImportProgressTest`
Expected: PASS (2 tests).

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/admin/adminHomeController.php routes/api.php tests/Feature/ImportProgressTest.php
git commit -m "feat: add cache-based import progress endpoint, remove dead getProgress"
```

---

### Task 5: Pooled fetch + bulk persist rewrite of `add()` (Sortir)

**Files:**
- Modify: `app/Http/Controllers/admin/adminHomeController.php` (add imports; add `fetchPooled`; replace `add()` body, lines 31-132)

**Interfaces:**
- Consumes: `ImportSupport::dayRanges`, `ImportSupport::diffSortir`, `setProgress` (Task 4).
- Produces:
  - `adminHomeController::fetchPooled(string $url, array $baseParams, array $days, ?string $jobId): array` — concurrently (5 at a time) GETs one request per day (`tgll=tglh=day`), merges decoded array bodies, advances `fetching` progress 0→40%. Failed day requests are logged and skipped.
  - `add()` returns JSON `['status'=>'completed','fetched'=>int,'inserted'=>int,'updated'=>int]` on success, or `['status'=>'error','message'=>...]` with HTTP 500.

This task has no automated test (it calls the live SAP API and writes the real DB); verify manually per the steps below.

- [ ] **Step 1: Add imports**

At the top of `app/Http/Controllers/admin/adminHomeController.php`, add to the `use` block:

```php
use App\Support\ImportSupport;
use Illuminate\Support\Facades\Log;
```

- [ ] **Step 2: Add the `fetchPooled` helper**

Add this method to the controller (e.g. just above `add()`):

```php
    private function fetchPooled(string $url, array $baseParams, array $days, ?string $jobId): array
    {
        $items = [];
        $total = max(count($days), 1);
        $done = 0;

        foreach (array_chunk($days, 5) as $batch) {
            $responses = Http::pool(function ($pool) use ($batch, $url, $baseParams) {
                $requests = [];
                foreach ($batch as $day) {
                    $requests[] = $pool->timeout(120)->get($url, array_merge($baseParams, [
                        'tgll' => $day,
                        'tglh' => $day,
                    ]));
                }

                return $requests;
            });

            foreach ($responses as $response) {
                try {
                    if (is_object($response) && method_exists($response, 'ok') && $response->ok()) {
                        $decoded = json_decode($response->body());
                        if (is_array($decoded)) {
                            foreach ($decoded as $row) {
                                $items[] = $row;
                            }
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning('Pooled import fetch failed: ' . $e->getMessage());
                }
            }

            $done += count($batch);
            $this->setProgress($jobId, (int) round($done / $total * 40), 'fetching', "Fetching {$done}/{$total} days");
        }

        return $items;
    }
```

- [ ] **Step 3: Replace the `add()` method**

Replace the entire existing `add()` method (lines 31-132) with:

```php
    public function add(Request $request)
    {
        set_time_limit(360000);
        ini_set('max_execution_time', 360000);

        $jobId = $request->input('jobId');

        try {
            $this->setProgress($jobId, 0, 'fetching', 'Starting');

            $days = ImportSupport::dayRanges($request->date_start, $request->date_end);
            $items = $this->fetchPooled(
                'http://172.31.3.13/ci-milan-restserver/index.php/HasilSortir',
                ['prdplant' => '5011'],
                $days,
                $jobId
            );

            $this->setProgress($jobId, 40, 'saving', 'Preparing');

            $existingByKey = [];
            $aufnrs = array_values(array_unique(array_map(fn ($i) => $i->AUFNR, $items)));
            foreach (array_chunk($aufnrs, 500) as $chunk) {
                hasil_sortir_api::whereIn('AUFNR', $chunk)->get()->each(function ($row) use (&$existingByKey) {
                    $key = implode('|', [$row->AUFNR, $row->MATNR, $row->MBLNR, $row->MJAHR]);
                    $existingByKey[$key] = $row->toArray();
                });
            }

            $diff = ImportSupport::diffSortir($items, $existingByKey);

            DB::transaction(function () use ($diff, $jobId) {
                $totalWrite = max(count($diff['insert']) + count($diff['update']), 1);
                $written = 0;

                foreach (array_chunk($diff['insert'], 500) as $chunk) {
                    DB::table('hasil_sortir_apis')->insert($chunk);
                    $written += count($chunk);
                    $this->setProgress($jobId, 40 + (int) round($written / $totalWrite * 55), 'saving', "Saving {$written}/{$totalWrite}");
                }

                foreach ($diff['update'] as $u) {
                    DB::table('hasil_sortir_apis')->where('id', $u['id'])->update($u['data']);
                    $written++;
                    if ($written % 100 === 0) {
                        $this->setProgress($jobId, 40 + (int) round($written / $totalWrite * 55), 'saving', "Saving {$written}/{$totalWrite}");
                    }
                }
            });

            $this->setProgress($jobId, 100, 'done', 'Completed');

            return response()->json([
                'status' => 'completed',
                'fetched' => count($items),
                'inserted' => count($diff['insert']),
                'updated' => count($diff['update']),
            ]);
        } catch (Exception $e) {
            $this->setProgress($jobId, 100, 'error', $e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
```

- [ ] **Step 4: Verify it compiles**

Run: `php -l app/Http/Controllers/admin/adminHomeController.php`
Expected: `No syntax errors detected`.

- [ ] **Step 5: Manual verification**

Start the app (`php artisan serve`), open the Import Data page, pick a small 1–2 day Sortir range, click import. Confirm:
- The request returns `{status:'completed', fetched, inserted, updated}`.
- Re-running the same range returns `inserted: 0` (idempotent) and creates no duplicate `hasil_sortir_apis` rows (`SELECT AUFNR,MATNR,MBLNR,MJAHR,COUNT(*) ... GROUP BY ... HAVING COUNT(*)>1` returns nothing).
- While running, `GET /api/home/importProgress/{sameJobId}` returns rising `progress`. (Task 7 wires the UI; for now you can pass a `jobId` manually via curl/Postman.)

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/admin/adminHomeController.php
git commit -m "feat: pooled fetch + bulk diff persist for Sortir import"
```

---

### Task 6: Pooled fetch + bulk persist rewrite of `addHasilKiln()` (Kiln)

**Files:**
- Modify: `app/Http/Controllers/admin/adminHomeController.php` (replace `addHasilKiln()`, lines 133-211)

**Interfaces:**
- Consumes: `fetchPooled` (Task 5), `ImportSupport::dayRanges`, `ImportSupport::diffKiln`, `setProgress`.
- Produces: `addHasilKiln()` returns JSON `['status'=>'completed','fetched'=>int,'inserted'=>int,'updated'=>int]` on success or `['status'=>'error','message'=>...]` HTTP 500.

No automated test (live API + real DB); verify manually.

- [ ] **Step 1: Replace the `addHasilKiln()` method**

Replace the entire existing `addHasilKiln()` method (lines 133-211) with:

```php
    public function addHasilKiln(Request $request)
    {
        set_time_limit(36000);
        ini_set('max_execution_time', 36000);

        $jobId = $request->input('jobId');

        try {
            $this->setProgress($jobId, 0, 'fetching', 'Starting');

            $days = ImportSupport::dayRanges($request->date_start, $request->date_end);
            $items = $this->fetchPooled(
                'http://172.31.3.13/ci-milan-restserver/index.php/HasilKiln',
                [],
                $days,
                $jobId
            );

            $this->setProgress($jobId, 40, 'saving', 'Preparing');

            $existingByKey = [];
            $orderIds = array_values(array_unique(array_map(fn ($i) => intval($i->AUFNR), $items)));
            foreach (array_chunk($orderIds, 500) as $chunk) {
                rk_hasil_produksi::whereIn('order_id', $chunk)->get()->each(function ($row) use (&$existingByKey) {
                    $key = $row->order_id . '|' . $row->kode_material . '|' . $row->mesin_id;
                    $existingByKey[$key] = $row->toArray();
                });
            }

            $diff = ImportSupport::diffKiln($items, $existingByKey);

            DB::transaction(function () use ($diff, $jobId) {
                $totalWrite = max(count($diff['insert']) + count($diff['update']), 1);
                $written = 0;

                foreach (array_chunk($diff['insert'], 500) as $chunk) {
                    DB::table('rk_hasil_produksis')->insert($chunk);
                    $written += count($chunk);
                    $this->setProgress($jobId, 40 + (int) round($written / $totalWrite * 55), 'saving', "Saving {$written}/{$totalWrite}");
                }

                foreach ($diff['update'] as $u) {
                    DB::table('rk_hasil_produksis')->where('id', $u['id'])->update($u['data']);
                    $written++;
                    if ($written % 100 === 0) {
                        $this->setProgress($jobId, 40 + (int) round($written / $totalWrite * 55), 'saving', "Saving {$written}/{$totalWrite}");
                    }
                }
            });

            $this->setProgress($jobId, 100, 'done', 'Completed');

            return response()->json([
                'status' => 'completed',
                'fetched' => count($items),
                'inserted' => count($diff['insert']),
                'updated' => count($diff['update']),
            ]);
        } catch (Exception $e) {
            $this->setProgress($jobId, 100, 'error', $e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
```

- [ ] **Step 2: Verify it compiles**

Run: `php -l app/Http/Controllers/admin/adminHomeController.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Manual verification**

Import a small 1–2 day Kiln range. Confirm `{status:'completed', ...}` and that `rk_hasil_produksis` rows appear with `mesin_id` like `RK 03`, `shift_id=1`, `user_id=10`. Note (expected, unchanged): re-importing the same range increases `jumlah` again — this is the preserved additive behavior.

- [ ] **Step 4: Commit**

```bash
git add app/Http/Controllers/admin/adminHomeController.php
git commit -m "feat: pooled fetch + bulk diff persist for Kiln import"
```

---

### Task 7: UI — progress bars + polling in `importData.blade.php`

**Files:**
- Modify: `resources/views/masters/importData.blade.php` (full rewrite)

**Interfaces:**
- Consumes: `POST /api/home/addDataSortir` and `/api/home/addDataKiln` (body includes `jobId`), `GET /api/home/importProgress/{jobId}`.

No automated test; verify manually in the browser.

- [ ] **Step 1: Replace the view**

Replace the entire contents of `resources/views/masters/importData.blade.php` with:

```blade
@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Import Data SORTIR</h1>

    <div class="form-group">
        <label for="start_date_sortir">Start Date</label>
        <input type="date" name="start_date_sortir" id="start_date_sortir" class="form-control" value="{{ date('Y-m-d') }}">
    </div>
    <div class="form-group">
        <label for="end_date_sortir">End Date</label>
        <input type="date" name="end_date_sortir" id="end_date_sortir" class="form-control" value="{{ date('Y-m-d') }}">
    </div>
    <button id="sortir-button" class="btn btn-primary">Start Import Data Sortir</button>

    <div class="mt-2">
        <div class="progress" style="height: 22px;">
            <div id="sortir-bar" class="progress-bar progress-bar-striped" role="progressbar"
                 style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
        <small id="sortir-status" class="text-muted"></small>
    </div>

    <br>
    <h1>Import Data KILN</h1>

    <div class="form-group">
        <label for="start_date_kiln">Start Date</label>
        <input type="date" name="start_date_kiln" id="start_date_kiln" class="form-control" value="{{ date('Y-m-d') }}">
    </div>
    <div class="form-group">
        <label for="end_date_kiln">End Date</label>
        <input type="date" name="end_date_kiln" id="end_date_kiln" class="form-control" value="{{ date('Y-m-d') }}">
    </div>
    <button id="kiln-button" class="btn btn-primary">Start Import Data Kiln</button>

    <div class="mt-2">
        <div class="progress" style="height: 22px;">
            <div id="kiln-bar" class="progress-bar progress-bar-striped" role="progressbar"
                 style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
        <small id="kiln-status" class="text-muted"></small>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    function setBar(bar, pct, { error = false, done = false } = {}) {
        pct = Math.max(0, Math.min(100, Math.round(pct)));
        bar.style.width = pct + '%';
        bar.setAttribute('aria-valuenow', pct);
        bar.textContent = pct + '%';
        bar.classList.toggle('progress-bar-animated', !error && !done);
        bar.classList.toggle('bg-danger', error);
        bar.classList.toggle('bg-success', done && !error);
    }

    async function runImport(config) {
        const button = document.getElementById(config.buttonId);
        const bar = document.getElementById(config.barId);
        const status = document.getElementById(config.statusId);
        const inputs = config.inputIds.map(id => document.getElementById(id));

        const jobId = (crypto.randomUUID && crypto.randomUUID()) ||
            ('job-' + Date.now() + '-' + Math.random().toString(16).slice(2));

        const start = document.getElementById(config.startId).value.split('-').join('');
        const end = document.getElementById(config.endId).value.split('-').join('');

        button.disabled = true;
        inputs.forEach(i => i.disabled = true);
        bar.classList.remove('bg-danger', 'bg-success');
        setBar(bar, 0);
        status.textContent = 'Starting...';

        let polling = true;
        const poll = async () => {
            while (polling) {
                try {
                    const res = await fetch(`/api/home/importProgress/${jobId}`);
                    if (res.ok) {
                        const p = await res.json();
                        if (polling && p.phase !== 'done' && p.phase !== 'error') {
                            setBar(bar, p.progress || 0);
                            status.textContent = `${p.phase}: ${p.message || ''}`;
                        }
                    }
                } catch (e) { /* ignore transient poll errors */ }
                await new Promise(r => setTimeout(r, 800));
            }
        };
        poll();

        try {
            const body = { date_start: start, date_end: end, jobId };
            if (config.extraBody) Object.assign(body, config.extraBody);

            const res = await fetch(config.url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(body)
            });

            const data = await res.json().catch(() => ({}));

            if (!res.ok || data.status === 'error') {
                throw new Error(data.message || `HTTP ${res.status}`);
            }

            setBar(bar, 100, { done: true });
            status.textContent = `Completed — fetched ${data.fetched}, inserted ${data.inserted}, updated ${data.updated}.`;
        } catch (error) {
            console.error('Import error:', error);
            setBar(bar, 100, { error: true });
            status.textContent = 'Error: ' + error.message;
        } finally {
            polling = false;
            button.disabled = false;
            inputs.forEach(i => i.disabled = false);
        }
    }

    document.getElementById('sortir-button').addEventListener('click', () => runImport({
        buttonId: 'sortir-button', barId: 'sortir-bar', statusId: 'sortir-status',
        startId: 'start_date_sortir', endId: 'end_date_sortir',
        inputIds: ['start_date_sortir', 'end_date_sortir'],
        url: '/api/home/addDataSortir',
        extraBody: { user_id: {{ Auth::user()->id }} }
    }));

    document.getElementById('kiln-button').addEventListener('click', () => runImport({
        buttonId: 'kiln-button', barId: 'kiln-bar', statusId: 'kiln-status',
        startId: 'start_date_kiln', endId: 'end_date_kiln',
        inputIds: ['start_date_kiln', 'end_date_kiln'],
        url: '/api/home/addDataKiln'
    }));
});
</script>
```

- [ ] **Step 2: Manual verification**

Open the Import Data page in a browser. For each panel:
- Click the button with a small date range.
- Confirm the bar animates from 0% up through the fetch phase (~40%) into the save phase and finishes green at 100%.
- Confirm the status line ends with `Completed — fetched X, inserted Y, updated Z.`
- Force an error (e.g. temporarily unreachable API) and confirm the bar turns red with an error message, and the button re-enables.

- [ ] **Step 3: Commit**

```bash
git add resources/views/masters/importData.blade.php
git commit -m "feat: progress-bar UI with live polling for data imports"
```

---

## Self-Review

**Spec coverage:**
- Pooled/concurrent fetch (cap 5) → Task 5 `fetchPooled` (reused by Task 6). ✓
- Eliminate N+1 (one existing-rows query + in-memory diff + bulk writes) → Tasks 2, 3, 5, 6. ✓
- Cache + polling progress transport → Task 4 (endpoint/helper), Tasks 5/6 (writes), Task 7 (poll). ✓
- Remove dead `getProgress` → Task 4. ✓
- UI 0–100% progress bar + fixed Response/JSON handling → Task 7. ✓
- Kiln additive semantics preserved → Task 3 + note. ✓
- No schema change → confirmed; idempotency via in-memory diff. ✓
- Testing: unit (dayRanges/diffs) + feature (progress endpoint) automated; controller wiring + UI manual, matching the spec's "Manual (primary)" approach. ✓

**Placeholder scan:** No TBD/TODO/"handle edge cases"; every code step contains complete code. ✓

**Type consistency:** `dayRanges`, `sortirKey`, `diffSortir`, `kilnKey`, `kilnKeyParts`, `diffKiln`, `fetchPooled`, `setProgress`, `importProgress` names and shapes match across producing and consuming tasks. Diff return shape `['insert'=>[], 'update'=>[['id','data']]]` is consistent between Tasks 2/3 and their consumers in Tasks 5/6. ✓

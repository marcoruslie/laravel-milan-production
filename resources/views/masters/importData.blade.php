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

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
        <button id="sortir-button" class="btn btn-primary">
            <span id="sortir-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <span id="sortir-button-text">Start Import Data Sortir</span>
        </button>

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
        <button id="kiln-button" class="btn btn-primary">
            <span id="kiln-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <span id="kiln-button-text">Start Import Data Kiln</span>
        </button>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    const startButtonKiln = document.getElementById('kiln-button');
    const spinnerKiln = document.getElementById('kiln-spinner');
    const buttonTextKiln = document.getElementById('kiln-button-text');
    const startButtonSortir = document.getElementById('sortir-button');
    const spinnerSortir = document.getElementById('sortir-spinner');
    const buttonTextSortir = document.getElementById('sortir-button-text');

    startButtonKiln.addEventListener('click', async () => {
        startButtonKiln.disabled = true;
        spinnerKiln.classList.remove('d-none');
        buttonTextKiln.textContent = "Importing Data Kiln...";
        // Get the start and end dates from input field
        const startDateKiln = document.getElementById('start_date_kiln').value;
        const endDateKiln = document.getElementById('end_date_kiln').value;
        // Change format date to yyyymmdd
        const startDateKilnFormat = startDateKiln.split('-').join('');
        const endDateKilnFormat = endDateKiln.split('-').join('');
        console.log(startDateKilnFormat, endDateKilnFormat);
        try {
            const result = await fetch('/api/home/addDataKiln', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' // Ensure the server knows you're sending JSON
                },
                body: JSON.stringify({
                    'date_start': startDateKilnFormat,
                    'date_end': endDateKilnFormat
                })
            });
            alert('Data import completed successfully!');
        } catch (error) {
            console.error('Error during import:', error);
            alert('An error occurred during the import process.');
        } finally {
            startButtonKiln.disabled = false; // Re-enable the button
            spinnerKiln.classList.add('d-none'); // Hide the spinner
            buttonTextKiln.textContent = "Start Import Data Kiln"; // Reset the button text
        }
    });
    startButtonSortir.addEventListener('click', async () => {
        startButtonSortir.disabled = true; // Disable the button during the import process
        spinnerSortir.classList.remove('d-none'); // Show the spinner
        buttonTextSortir.textContent = "Importing Data Sortir..."; // Change the button text
        // Get the start and end dates from input field
        const startDateSortir = document.getElementById('start_date_sortir').value;
        const endDateSortir = document.getElementById('end_date_sortir').value;
        // Change format date to yyyymmdd
        const startDateSortirFormat = startDateSortir.split('-').join('');
        const endDateSortirFormat = endDateSortir.split('-').join('');
        console.log(startDateSortirFormat, endDateSortirFormat);
        try {
            const result = await fetch('/api/home/addDataSortir', {
                method: 'POST' ,
                headers: {
                    'Content-Type': 'application/json' // Ensure the server knows you're sending JSON
                },
                body: JSON.stringify({
                    'date_start':startDateSortirFormat,
                    'date_end':endDateSortirFormat,
                    'user_id':{{ Auth::user()->id}}
                })
                });
            alert(JSON.stringify(result));
            alert('Data import completed successfully!');
        } catch (error) {
            console.error('Error during import:', error);
            alert('An error occurred during the import process.');
        } finally {
            startButtonSortir.disabled = false; // Re-enable the button
            spinnerSortir.classList.add('d-none'); // Hide the spinner
            buttonTextSortir.textContent = "Start Import Data Sortir"; // Reset the button text
        }
    });
});
</script>

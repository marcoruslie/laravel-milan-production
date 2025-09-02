<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Labels</title>
    <!-- Include Chart.js v2.9.4 -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    <!-- Include Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('milan.ico') }}">
</head>

<body>
        <button id="start-button" class="btn btn-primary">
            <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <span id="button-text">Start Import</span>
        </button>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startButton = document.getElementById('start-button');
            const spinner = document.getElementById('spinner');
            const buttonText = document.getElementById('button-text');

            startButton.addEventListener('click', async () => {
                startButton.disabled = true; // Disable the button during the import process
                spinner.classList.remove('d-none'); // Show the spinner
                buttonText.textContent = "Importing..."; // Change the button text

                try {
                    await fetch('/api/home/addData', { method: 'POST' });
                    alert('Import completed successfully!');
                } catch (error) {
                    console.error('Error during import:', error);
                    alert('An error occurred during the import process.');
                } finally {
                    startButton.disabled = false; // Re-enable the button
                    spinner.classList.add('d-none'); // Hide the spinner
                    buttonText.textContent = "Start Import"; // Reset the button text
                }
            });
        });
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
</body>

<style>
    .progress {
        margin-top: 20px;
        height: 25px;
        background-color: #f3f3f3;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        background-color: #007bff;
        color: #fff;
        text-align: center;
        transition: width 0.5s;
    }
</style>

</html>

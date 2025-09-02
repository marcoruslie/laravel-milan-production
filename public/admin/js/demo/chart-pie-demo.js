// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: "doughnut",
    data: {
        labels: ["Teknis", "NonTeknis", "Operational", "Finance", "Others"], // 5 labels
        datasets: [
            {
                data: [40, 10, 20, 10, 20], // Data for the labels
                backgroundColor: [
                    "#4e73df",
                    "#1cc88a",
                    "#36b9cc",
                    "#f6c23e",
                    "#e74a3b",
                ], // 5 distinct colors
                hoverBackgroundColor: [
                    "#2e59d9",
                    "#17a673",
                    "#2c9faf",
                    "#dda20a",
                    "#d62c1a",
                ], // Hover colors for each
                hoverBorderColor: "rgba(234, 236, 244, 1)", // Border color on hover
            },
        ],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false, // Hide default legend
        },
        cutoutPercentage: 80, // Doughnut hole size
    },
});

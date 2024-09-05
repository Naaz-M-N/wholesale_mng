<?php
    session_start(); 
    if(!isset($_SESSION['loginUser'])){
        header("Location:logout.php");
    }

    // Check if a CSV file is uploaded
    if(isset($_FILES['salesFile']) && $_FILES['salesFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['salesFile']['tmp_name'];
        $fileName = $_FILES['salesFile']['name'];

        // Process the CSV file
        $salesDataCOD = []; // Array to store COD sales data
        $salesDataOnline = []; // Array to store online sales data

        $handle = fopen($fileTmpPath, 'r');
        if($handle !== false) {
            // Skip the header row if needed
            fgetcsv($handle); // Skip the header row
            while(($row = fgetcsv($handle)) !== false) {
                // Assuming the month is in the seventh column, the amount is in the third column, and payment mode is in the fourth column
                $date = $row[6]; // Get the date from the seventh column
                $month = date('n', strtotime($date)); // Extract the month (1-12) from the date
                $amount = (float) $row[2]; // Convert amount to float
                $paymentMode = $row[3];

                // Group sales data by payment mode and month
                if($paymentMode === 'COD') {
                    if(isset($salesDataCOD[$month])) {
                        $salesDataCOD[$month] += $amount;
                    } else {
                        $salesDataCOD[$month] = $amount;
                    }
                } elseif($paymentMode === 'online') {
                    if(isset($salesDataOnline[$month])) {
                        $salesDataOnline[$month] += $amount;
                    } else {
                        $salesDataOnline[$month] = $amount;
                    }
                }
            }
            fclose($handle);

            // Now you have sales data grouped by payment mode and month
            // Prepare data for chart
            $months = range(1, 12); // Array of all 12 months
            $totalSalesCOD = [];
            $totalSalesOnline = [];
            foreach($months as $month) {
                // Set sales amount for COD and online for each month
                $totalSalesCOD[] = isset($salesDataCOD[$month]) ? $salesDataCOD[$month] : 0;
                $totalSalesOnline[] = isset($salesDataOnline[$month]) ? $salesDataOnline[$month] : 0;
            }
        } else {
            echo "Error opening file.";
        }
    } else {
        echo "No file uploaded or error occurred.";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Data Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js library -->
    <link rel='stylesheet' href="css/style.css">
</head>
<body>
    <div class="topStyle">
        <h2>Wholesale Database Management</h2>
        <a class='userNameDisplay'><?php echo $_SESSION['loginUser']; ?></a>
    </div>
    <div class='container'>
        <h3>Sales Data Chart</h3>
        <canvas id="salesChart" width="800" height="400"></canvas> <!-- Create a canvas element for the chart -->
    </div>
    <script>
        // Initialize Chart.js and create the chart
        var ctx = document.getElementById('salesChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // Choose the type of chart (bar chart in this case)
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Array of month names
                datasets: [{
                    label: 'COD Sales', // Label for COD sales data
                    data: <?php echo json_encode($totalSalesCOD); ?>, // Use PHP to pass COD sales data
                    backgroundColor: 'rgba(255, 99, 132, 0.5)', // Color for COD sales bars with transparency
                    borderColor: 'rgba(255, 99, 132, 1)', // Border color for COD sales bars
                    borderWidth: 1
                }, {
                    label: 'Online Sales', // Label for online sales data
                    data: <?php echo json_encode($totalSalesOnline); ?>, // Use PHP to pass online sales data
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Color for online sales bars with transparency
                    borderColor: 'rgba(54, 162, 235, 1)', // Border color for online sales bars
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>

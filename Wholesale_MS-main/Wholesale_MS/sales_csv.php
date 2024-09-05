<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "wholesale");

// Check if connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from transaction table
$query = "SELECT * FROM `transaction`";
$result = mysqli_query($conn, $query);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Define CSV filename and headers
    $filename = 'sales_data.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Output CSV headers
    fputcsv($output, array('Transaction ID', 'Customer ID', 'Transaction Amount', 'Payment', 'Phone', 'Address', 'Date'));

    // Output each row of data
    while ($row = mysqli_fetch_assoc($result)) {
        // Extract date from MySQL datetime format to just the date
        $row['date'] = date('Y-m-d', strtotime($row['date']));
        // Output row data to CSV
        fputcsv($output, $row);
    }

    // Close the file pointer
    fclose($output);
} else {
    echo "No data found in the transaction table.";
}

// Close the database connection
mysqli_close($conn);
?>

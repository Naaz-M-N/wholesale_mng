<?php
session_start();

// Check if supplier is not logged in, redirect to login page
if (!isset($_SESSION['supplier_id'])) {
    header("Location: supplier.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "wholesale");

// Check if connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch supplier details
$supplier_id = $_SESSION['supplier_id'];
$query = "SELECT * FROM Suppliers WHERE supplier_id = $supplier_id";
$result = mysqli_query($conn, $query);
$supplier = mysqli_fetch_assoc($result);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch and sanitize form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);

    // Update supplier details in the database
    $update_query = "UPDATE Suppliers SET username='$username', company='$company', email='$email', address='$address', experience='$experience' WHERE supplier_id = $supplier_id";
    if (mysqli_query($conn, $update_query)) {
        // Redirect to supplier dashboard
        header("Location: supplier_dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

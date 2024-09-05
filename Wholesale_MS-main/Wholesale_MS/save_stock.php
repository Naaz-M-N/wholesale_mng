<?php
    session_start();

    // Check if supplier is not logged in, redirect to login page
    if (!isset($_SESSION['supplier_id'])) {
        header("Location: supplier.php");
        exit();
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection
        $conn = mysqli_connect("localhost", "root", "", "wholesale");

        // Check if connection is successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve form data
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Get the original price of the product
        $query = "SELECT price FROM products WHERE product_id = $product_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $original_price = $row['price'];

        // If the entered price is less than the original price, update the price
        if ($price < $original_price) {
            $query = "UPDATE products SET quantity = $quantity, price = $price WHERE product_id = $product_id";
        } else {
            $query = "UPDATE products SET quantity = $quantity WHERE product_id = $product_id";
        }

        if (mysqli_query($conn, $query)) {
            // Stock added successfully
            echo "<script>alert('Stock added successfully.'); window.location.href = 'add_stock.php';</script>";
        } else {
            // Error adding stock
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        // Redirect to add stock page if accessed directly without form submission
        header("Location: add_stock.php");
        exit();
    }
?>

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
    
    // Fetch product details from the form
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    
    // Insert new product into the products table
    $query = "INSERT INTO products (product_name, category_id, price) VALUES ('$product_name', '$category_id', '$price')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Product added successfully.');</script>";
        echo "<script>window.location.href = 'add_products.php';</script>"; // Redirect to the add products page
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);
?>

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
    $query = "SELECT * FROM suppliers WHERE supplier_id = $supplier_id";
    $result = mysqli_query($conn, $query);
    $supplier = mysqli_fetch_assoc($result);

    // Fetch products with their respective categories from database
    $query = "SELECT p.*, c.category_name FROM products p INNER JOIN categories c ON p.category_id = c.category_id";
    $result = mysqli_query($conn, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the database connection
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Stock</title>
    <link rel='stylesheet' href="css/style.css">
    <style>
        /* Additional styles for the sidebar */
        .sidebar {
            float: right;
            width: 20%;
            background-color: #f2f2f2;
            padding: 20px;
            margin-top: 20px;
            height: 100vh; /* Make sidebar full height */
        }

        .sidebar a {
            display: block;
            color: black;
            padding: 16px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #555;
            color: white;
        }

      .content {
    margin-left: 250px;
    padding: 20px;
    margin-top: 50px;
    background-image: url('bg_img2.jpg');
    background-size: cover; /* Ensure image covers the entire container */
    background-repeat: no-repeat; /* Prevent image from repeating */
    background-position: center; /* Center the image */
    color: black;
    width: 100%;
    height: 100vh; /* Set the height to match the viewport height */
    overflow: hidden; /* Hide any overflow content */
}



    </style>
</head>
<body>
    <div class="topStyle">
        <h2>Welcome, Supplier!</h2>
    </div>
    <div class="sidebar">
        <br><br><a href="supplier_dashboard.php" class="btn">Dashboard</a><br><br>
        <a href="add_profile.php" class="btn">Add Profile</a><br><br>
        <a href="add_products.php" class="btn">Add Products</a><br><br>
        <a href="logout.php" class="btn">Logout</a><br>
    </div>
    <div class="content">
    <div class="container">
            <h3>Add Stock</h3>
            <!-- Form to add stock -->
            <form method='post' action='save_stock.php'>
                <label>Product:</label>
                <select name="product_id">
                    <?php foreach($products as $product): ?>
                        <option value="<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?> (<?php echo $product['category_name']; ?>)</option>
                    <?php endforeach; ?>
                </select><br>
                <label>Quantity:</label>
                <input type="number" name="quantity" min="1" required><br>
                <label>Discounted Price:</label>
                <input type="number" name="price" min="0.01" step="0.01" required><br><br>
                <input type="submit" value="Add Stock" class="btn">
            </form>
        </div>
    </div>
</body>
</html>

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

    // Fetch product categories from admin table
    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the database connection
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Products</title>
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
        <a href="add_stock.php" class="btn">Add Stock</a><br><br>
        <a href="logout.php" class="btn">Logout</a><br>
    </div>
    <div class="content">
        <div class="container">
            <h3>Add Products</h3>
            <!-- Form to add products -->
            <form method='post' action='save_product.php'>
                <label>Product Name:</label>
                <input type="text" name="product_name" placeholder="Enter product name" required><br>
                <label>Category:</label>
                <select name="category_id">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                    <?php endforeach; ?>
                </select><br>
                <label>Price:</label>
                <input type="number" name="price" placeholder="Enter product price" min="0.01" step="0.01" required><br>
                <input type="submit" value="Add Product" class="btn">
            </form>
        </div>
    </div>
</body>
</html>

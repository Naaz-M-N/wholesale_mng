<?php
    session_start();

    // Check if supplier is not logged in, redirect to login page
    if(!isset($_SESSION['supplier_id'])) {
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

    // Close the database connection
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Profile</title>
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
    background-image: url('bg_img1.png');
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
        <h2>Welcome, <?php echo $supplier['username']; ?>!</h2>
    </div>
    <div class="sidebar">
        <br><br><a href="supplier_dashboard.php" class="btn">Dashboard</a><br><br>
        <a href="add_products.php" class="btn">Add Products</a><br><br>
        <a href="add_stock.php" class="btn">Add Stock</a><br><br>
        <a href="logout.php" class="btn">Logout</a><br>
    </div>
    <div class="content">
        <div class="container">
            <h3>Add Profile</h3>
            <!-- Form to add or update profile details -->
            <form method='post' action='save_profile.php'>
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo $supplier['username']; ?>" required><br>
                <label>Company:</label>
                <input type="text" name="company" value="<?php echo $supplier['company']; ?>" required><br>
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $supplier['email']; ?>"><br>
                <label>Address:</label>
                <input type="text" name="address" value="<?php echo $supplier['address']; ?>"><br>
                <label>Experience:</label>
                <input type="number" name="experience" value="<?php echo $supplier['experience']; ?>"><br><br>
                <input type="submit" value="Save" class="btn">
            </form>
        </div>
    </div>
</body>
</html>

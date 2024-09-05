<?php
session_start(); 
if (!isset($_SESSION['loginUser'])) {
    header("Location:logout.php");
}

// Check if transaction ID is set
if (!isset($_GET['transaction_id'])) {
    echo "Transaction ID is not set.";
    exit;
}

$transaction_id = $_GET['transaction_id'];

// Database connection
$conn = mysqli_connect("localhost", "root", "", "wholesale");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Details</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="topStyle">
        <h2 style="color:white;">Wholesale DataBase Management</h2>
        <a class='userNameDisplay'><?php echo $_SESSION['loginUser']; ?></a>
    </div>
    <div class='sidebar'>
        <button onclick="location.href='customerHome.php'">Home</button>
        <button onclick="location.href='viewProductsCustomer.php'">View Products</button>
        <button onclick="location.href='order.php'">Order</button>
        <button onclick="location.href='cart.php'">Cart</button>
        <button onclick="location.href='customerViewTransactions.php'">My Transactions</button>
        <button onclick="location.href='logout.php'">Logout</button>
    </div>
    <div class='container'>
        <h3>Order Details</h3>
        <table class='tableLarge'>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php
            // Retrieve order details from database
            $sql = "SELECT product_name, quantity, price FROM transaction_products WHERE transaction_id = $transaction_id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>" . $row['product_name'] . "</td>
                            <td>" . $row['quantity'] . "</td>
                            <td>" . $row['price'] . "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No products found for this transaction.</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </table>
    </div>
</body>
</html>

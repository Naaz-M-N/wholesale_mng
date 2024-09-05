<?php
    session_start(); 
    if(!isset($_SESSION['loginUser'])){
        header("Location:logout.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Collection</title>
    <link rel='stylesheet' href="css/style.css">
</head>
<body>
    <div class="topStyle">
        <h2>Wholesale Database Management</h2>
        <a class='userNameDisplay'><?php echo $_SESSION['loginUser']; ?></a>
    </div>
    <div class='sidebar'>
        <button onclick="location.href='adminHome.php'">Home</button>
        <button onclick="location.href='viewProducts.php'">View Products</button>
        <button onclick="location.href='addStock.php'">Add Stock</button>
        <button onclick="location.href='addProduct.php'">Add New Product</button>
        <button onclick="location.href='add_categories.php'">Add Category</button>
        <button onclick="location.href='depleted.php'">Depleted Products</button>
        <button onclick="location.href='customers.php'">Customers</button>
        <button onclick="location.href='transactions.php'">Transactions</button>
        <button onclick="location.href='logout.php'">Logout</button>
    </div>
    <div class='container'>
        <fieldset>
            <legend><b>Data Collection</b></legend>
            <form method="post" action="processData.php" enctype="multipart/form-data">
                <label for="salesFile">Import Sales Data (CSV format):</label>
                <input type="file" id="salesFile" name="salesFile" accept=".csv" required><br><br>
                <input type="submit" value="Submit" class="btn">
            </form>
        </fieldset>
    </div>
</body>
</html>

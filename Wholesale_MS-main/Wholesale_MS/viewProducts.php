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
    <title>View Products</title>
    <link rel='stylesheet' href="css/style.css">
</head> 
<body>
    <div class="topStyle">
        <h2 style="color:white;">Wholesale DataBase Management</h2>
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
        <button onclick="location.href='sales_csv.php'">Generate Sales</button>
        <button onclick="location.href='dataCollection.php'">Sales Data</button>
        <button onclick="location.href='logout.php'">Logout</button>
    </div>
    <div class='container'>
        <fieldset><legend><b>Categories</b></legend>
            <table><tr><th>Category ID</th><th>Category Name</th></tr>
            <?php 
                $conn=mysqli_connect("localhost","root","","wholesale");
                $sql="select * from categories";
                $result=mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($result)){
                    echo "<tr><td>".$row['category_id']."</td><td>".$row['category_name']."</td></tr>";
                }
                echo "</table><br>";
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='get'>
                <input class='formInputItem' type=text name="catID" placeholder="Enter Category ID" required><input class='btn' type=submit name='submit' value='Go'>
            </form><br><br>
        </fieldset>
        <?php 
            if(isset($_GET['submit'])){
                $catID=$_GET['catID'];
                $sql="select * from products where category_id='$catID'";
                $result=mysqli_query($conn,$sql);
                echo "<fieldset><legend><b>Products</b></legend>
                    <table><tr><th>Product ID</th><th>Product Name</th><th>Price</th><th>Stock Left</th></tr>";
                while($row=mysqli_fetch_assoc($result)){
                    echo "<tr><td>".$row['product_id']."</td><td>".$row['product_name']."</td><td>".$row['price']."</td><td>";
                    if ($row['quantity'] === null || $row['quantity'] === '0') {
                        echo "Not available";
                    } else {
                        echo $row['quantity'];
                    }
                    echo "</td></tr>";
                }
                echo "</table></fieldset><br>";
            }
        ?>
    </div>
</body>
</html>

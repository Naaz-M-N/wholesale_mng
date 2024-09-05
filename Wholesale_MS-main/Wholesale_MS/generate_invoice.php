<?php
    session_start(); 
    if (!isset($_SESSION['loginUser'])) {
        header("Location:logout.php");
    }
    
    // Check if transaction ID is provided in the URL
    if(isset($_GET['transaction_id'])) {
        $transaction_id = $_GET['transaction_id'];
        
        // Connect to the database
        $conn=mysqli_connect("localhost","root","","wholesale");
        
        // Retrieve transaction details
        $sql_transaction = "SELECT * FROM transaction WHERE transaction_id='$transaction_id'";
        $result_transaction = mysqli_query($conn, $sql_transaction);
        
        // Check if transaction exists
        if(mysqli_num_rows($result_transaction) > 0) {
            $row_transaction = mysqli_fetch_assoc($result_transaction);
            
            // Retrieve product details for the transaction
            $sql_products = "SELECT * FROM transaction_products WHERE transaction_id='$transaction_id'";
            $result_products = mysqli_query($conn, $sql_products);
        } else {
            echo "Transaction not found.";
            exit;
        }
    } else {
        echo "Transaction ID is not provided.";
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
</head>
<body>
    <div class="topStyle">
        <h2 style="color:white;">Invoice</h2>
    </div>
    <div class='container'>
        <fieldset>
            <legend><b>Transaction Details</b></legend>
            <p><strong>Transaction ID:</strong> <?php echo $row_transaction['transaction_id']; ?></p>
            <p><strong>Amount:</strong> <?php echo $row_transaction['transaction_amount']; ?></p>
            <p><strong>Payment Mode:</strong> <?php echo $row_transaction['payment']; ?></p>
            <p><strong>Phone:</strong> <?php echo $row_transaction['phone']; ?></p>
            <p><strong>Address:</strong> <?php echo $row_transaction['address']; ?></p>
            <p><strong>Date:</strong> <?php echo $row_transaction['date']; ?></p>
        </fieldset>
        <fieldset>
            <legend><b>Products</b></legend>
            <table>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                </tr>
                <?php 
                    // Loop through each product and display its details
                    while($row_product = mysqli_fetch_assoc($result_products)) {
                        echo "<tr>
                                <td>".$row_product['product_id']."</td>
                                <td>".$row_product['product_name']."</td>
                                <td>".$row_product['price']."</td>
                            </tr>";
                    }
                ?>
            </table>
        </fieldset>
    </div>
</body>
</html>

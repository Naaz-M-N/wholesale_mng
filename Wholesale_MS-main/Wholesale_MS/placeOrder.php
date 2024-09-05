<?php
	session_start(); 
	if(!isset($_SESSION['loginUser'])){
		header("Location:logout.php");
	}
	$conn=mysqli_connect("localhost","root","","wholesale");
	$totalPrice=$_GET['totalPrice'];
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<link rel='stylesheet' href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>Place Order</title>
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
		<fieldset>
			<legend><b>Order Details</b></legend>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='get'>
				<label for='textarea'>Address: </label><textarea id='textarea' name='address' required></textarea><br>
				<label for='phone'>Phone: </label><input type=text name='phone' class='formInputItem' required><br>
				<label for='payment'>Payment: </label><input type=radio name='payment' value='online' required> Online
				 								<input type=radio name='payment' value='COD' required> Cash On Delivery<br>
				<p>Total Amount:   <?php echo $totalPrice."&#8377;</p>"; ?>
				<input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
				<button style='width:250px;height:5em;' type='submit' class='btn' name='submit'>Place Order</button>
			</form>	
		</fieldset>
		<?php
			if(isset($_GET['submit'])){
				$totalPrice=$_GET['totalPrice'];
				$address=$_GET['address'];
				$phone=$_GET['phone'];
				$payment=$_GET['payment'];
				$custID=$_SESSION['loginUser'];
				
				// Retrieve the highest transaction ID
				$sql_max = "SELECT MAX(transaction_id) AS max_id FROM transaction";
				$result_max = mysqli_query($conn, $sql_max);
				$row_max = mysqli_fetch_assoc($result_max);
				$max_id = $row_max['max_id'];
				
				// Increment the transaction ID to ensure uniqueness
				$new_transaction_id = $max_id + 1;

				// Insert into transaction table
				$sql="INSERT INTO transaction(transaction_id, transaction_amount, customer_id, phone, address, payment, date) 
					  VALUES ('$new_transaction_id', '$totalPrice', '$custID', '$phone', '$address', '$payment', current_date())";
				$result=mysqli_query($conn,$sql);

				// Retrieve cart items
				$sql_cart = "SELECT * FROM cart WHERE customer_id = '$custID'";
				$result_cart = mysqli_query($conn, $sql_cart);

				// Insert into transaction_details table
				while ($row_cart = mysqli_fetch_assoc($result_cart)) {
					$product_id = $row_cart['product_id'];
					$quantity = $row_cart['quantity'];

					// Retrieve the price of the product
					$sql_price = "SELECT price FROM products WHERE product_id = '$product_id'";
					$result_price = mysqli_query($conn, $sql_price);
					$row_price = mysqli_fetch_assoc($result_price);
					$price = $row_price['price'];

					$sql_insert = "INSERT INTO transaction_details(transaction_id, product_id, quantity, price) 
								   VALUES ('$new_transaction_id', '$product_id', '$quantity', '$price')";
					$result_insert = mysqli_query($conn, $sql_insert);
				}

				// Clear cart after placing order
				$sql_clear_cart = "DELETE FROM cart WHERE customer_id='$custID'";
				$result_clear_cart = mysqli_query($conn, $sql_clear_cart);
				
				echo "<script>alert('Order placed.\\nThe products will be delivered within 5 hours.');</script>";
				header("refresh:0;url=order.php");
			}
			else{
				if($totalPrice==0){
					echo "<script>alert('Cart is empty!');</script>";
					header("refresh:0;url=cart.php");
				}
			}
		?>
	</div>
</body>
</html>

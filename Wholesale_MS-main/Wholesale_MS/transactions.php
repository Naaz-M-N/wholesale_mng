<?php
	session_start(); 
	if(!isset($_SESSION['loginUser'])){
		header("Location:logout.php");
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$conn = mysqli_connect("localhost", "root", "", "wholesale");
		$customer_id = $_POST['customer_id'];
		$transaction_amount = $_POST['transaction_amount'];
		$payment = $_POST['payment'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$date = $_POST['date'];

		// Check if transaction amount is empty or 0
		if (empty($transaction_amount) || $transaction_amount == 0) {
			echo "<script>alert('Transaction amount cannot be empty or zero.');</script>";
		} else {
			// Insert the new transaction
			$sql_insert = "INSERT INTO `transaction` (customer_id, transaction_amount, payment, phone, address, date) 
						   VALUES ('$customer_id', '$transaction_amount', '$payment', '$phone', '$address', '$date')";
			if (mysqli_query($conn, $sql_insert)) {
				// Redirect to prevent duplicate entries
				header("Location: " . $_SERVER['REQUEST_URI']);
				exit();
			} else {
				echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
			}
		}
		mysqli_close($conn);
	}
?>


<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<link rel='stylesheet' href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>View Transactions</title>
<style>
.containr {
  position: absolute;
  margin-top: 70px;
  margin-left: 200px;
  margin-right: 0;
  padding: 30px 20px 20px 20px;
  z-index: 1;
  background-color: white;
}
.containr form{
	line-height: 2em;
	display: block;
}
.containr table{
	text-align:left;
	font-style:normal;
}
.containr table td{
	vertical-align:top;
}
.containr table tr:nth-child(odd){
	background-color: #a3a5a8;
}
.containr table tr:nth-child(even){
	background-color: #e0e3e5;
}
.containr table th{
	min-width:13em;
	color:#fcfcfc;
	background-color: #303030;
}
.containr .tableLarge th{
	min-width: 7em;
}
.containr fieldset{
	min-height: 200px;
	min-width:30em;
	font-size: 20px;
	font-style:italic;
	line-height: 1.7em;
	border-left:none;
	border-right:none;
	border-bottom:none;
}
.containr fieldset legend{
	font-size: 25px;
	color:brown;
	font-style:normal;
}
.containr fieldset p{
	white-space: pre-wrap;
}
</style>
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
	<div class='containr'>
		<fieldset>
			<legend><b>Add Transaction</b></legend>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			    

				<label for="customer_id">Customer ID:</label>
				<input type="text" id="customer_id" name="customer_id"><br><br>

				<label for="transaction_amount">Transaction Amount:</label>
				<input type="text" id="transaction_amount" name="transaction_amount"><br><br>

				<label for="payment">Payment Mode:</label>
				<input type="text" id="payment" name="payment"><br><br>

				<label for="phone">Phone:</label>
				<input type="text" id="phone" name="phone"><br><br>

				<label for="address">Address:</label>
				<input type="text" id="address" name="address"><br><br>

				<label for="date">Date:</label>
				<input type="text" id="date" name="date"><br><br>

				<label for='submit'></label><input class='btn' type=submit name='submit' value='Submit'>
			</form>
		</fieldset>
		<br>

		<fieldset>
			<legend><b>Transactions</b></legend>
			<table class='tableLarge'>
				<tr>
					<th>Transaction ID</th>
					<th>Customer ID</th>
					<th>Amount</th>
					<th>Payment Mode</th>
					<th>Phone</th>
					<th>Address</th>
					<th>Date</th>
				</tr>
				 <?php 
					$conn = mysqli_connect("localhost", "root", "", "wholesale");
					$sql = "SELECT * FROM transaction";
					$result = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_assoc($result)) {
						echo "<tr>
								<td>".$row['transaction_id']."</td>
								<td>".$row['customer_id']."</td>
								<td>".$row['transaction_amount']."</td>
								<td>".$row['payment']."</td>
								<td>".$row['phone']."</td>
								<td>".$row['address']."</td>
								<td>".$row['date']."</td>
								
							</tr>";
					}
					echo "</table><br>";
					mysqli_close($conn);
				?>
		</fieldset>
	</div>
</body>
</html>

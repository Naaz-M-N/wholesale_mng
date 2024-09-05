<?php
	session_start(); 
	if(!isset($_SESSION['loginUser'])){
		header("Location:logout.php");
	}

	if(!isset($_GET['transaction_id'])) {
		// Redirect or handle error if transaction_id is not set
		// For example:
		header("Location: customerViewTransactions.php");
		exit();
	}

	$transaction_id = $_GET['transaction_id'];

	// Connect to the database
	$conn = mysqli_connect("localhost", "root", "", "wholesale");

	// Check if connection is successful
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// Fetch products ordered in the transaction
	$sql = "SELECT * FROM transaction_products WHERE transaction_id = $transaction_id";
	$result = mysqli_query($conn, $sql);

	// Check if any products are found for the transaction
	if (mysqli_num_rows($result) > 0) {
		// Initialize an array to store product data
		$product_data = array();

		// Fetch product data and store it in the array
		while ($row = mysqli_fetch_assoc($result)) {
			$product_data[] = $row;
		}
	} else {
		// No products found for the transaction
		$product_data = null;
	}

	// Close the database connection
	mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<link rel='stylesheet' href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>View Products Ordered</title>
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
		<button onclick="location.href='depleted.php'">Depleted Products</button>
		<button onclick="location.href='customers.php'">Customers</button>
		<button onclick="location.href='transactions.php'">Transactions</button>
		<button onclick="location.href='logout.php'">Logout</button>
	</div>
	<div class='container'>
		<fieldset>
			<legend><b>Products Ordered</b></legend>
			<?php if ($product_data): ?>
				<table class='tableLarge'>
					<tr>
						<th>Product ID</th>
						<th>Product Name</th>
						<th>Quantity</th>
					</tr>
					<?php foreach ($product_data as $product): ?>
						<tr>
							<td><?php echo $product['product_id']; ?></td>
							<td><?php echo $product['product_name']; ?></td>
							<td><?php echo $product['quantity']; ?></td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<p>No products ordered for this transaction.</p>
			<?php endif; ?>
		</fieldset>
	</div>
</body>
</html>

<?php
	session_start(); 
	if(!isset($_SESSION['loginUser'])){
		header("Location:logout.php");
	}
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<link rel='stylesheet' href="css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>Admin Home</title>

<style>
.container {
  position: absolute;
  margin-top: 70px;
  margin-right: 0;
  padding: 30px 20px 20px 220px; /* Adjust the padding to accommodate the sidebar width */
  z-index: 1;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  overflow: auto;
  display: flex;
  flex-direction: column;
}

.container fieldset {
  flex-grow: 1;
  min-height: 0;
  font-size: 20px;
  font-style: italic;
  line-height: 1.7em;
  border-left: none;
  border-right: none;
  border-bottom: none;
}

.container fieldset legend {
  font-size: 25px;
  color: brown;
  font-style: normal;
}

.container fieldset p {
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
<div class='container'>

	<fieldset><legend><b>Customers</b></legend>
		<table><tr><th>Username</th><th>Customer Name</th><th>E-mail</th><th>password</th></tr>
		<?php 
			$conn=mysqli_connect("localhost","root","","wholesale");
			$sql="select * from customer";
			$result=mysqli_query($conn,$sql);
			while($row=mysqli_fetch_assoc($result)){
				echo "<tr><td>".$row['cust_id']."</td><td>".$row['cust_name']."</td><td>".$row['email_id']."</td><td>".$row['password']."</td></tr>";
			}
			echo "</table><br>";
		?>
	</fieldset>



</div>
</body>
</html>
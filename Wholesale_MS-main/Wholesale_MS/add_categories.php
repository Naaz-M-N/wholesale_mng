<?php
    session_start(); 
    if(!isset($_SESSION['loginUser'])){
        header("Location:logout.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Add Category</title>

</head>
<body>
    <div class="topStyle">
        <h2 style="color:white">Wholesale DataBase Management</h2>
        <a class="userNameDisplay"><?php echo $_SESSION['loginUser']; ?></a>
    </div>
    <div class="sidebar">
        <!-- Sidebar buttons -->
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
    <div class="container">
        <fieldset><legend><b>Add New Category</b></legend><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
           <label for='category_name' style="display: inline-block; width: 150px;"> Category Name: </label><input id='category_name' type=text class='formInputItem' name='category_name' required><br><br><br>

            <label for='submit'></label><input class='btn' type=submit name='submit' value='Add Category'>
        </form>
</fieldset>
        <?php
        // Database connection
        $conn = mysqli_connect("localhost", "root", "", "wholesale");

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

            // Get the current maximum category_id
            $max_category_id_query = "SELECT MAX(category_id) AS max_id FROM categories";
            $max_category_id_result = mysqli_query($conn, $max_category_id_query);
            $row = mysqli_fetch_assoc($max_category_id_result);
            $max_category_id = $row['max_id'];

            // Increment the category_id by 1
            $next_category_id = $max_category_id + 1;

            // Insert new category into categories table with the incremented category_id
            $sql = "INSERT INTO categories (category_id, category_name) VALUES ('$next_category_id', '$category_name')";
            if (mysqli_query($conn, $sql)) {
                echo "Category added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>

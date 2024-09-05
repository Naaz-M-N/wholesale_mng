<?php
    session_start();

    if(isset($_SESSION['supplier_id'])) {
        // If supplier is already logged in, redirect to dashboard
        header("Location: supplier_dashboard.php");
        exit();
    }

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "wholesale");

    // Check if connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if(isset($_POST['login_user']) && isset($_POST['login_pass']) && isset($_POST['login_company'])) {
        // Supplier login
        $username = $_POST['login_user'];
        $password = $_POST['login_pass'];
        $company = $_POST['login_company'];

        // Check if supplier exists
        $query = "SELECT * FROM suppliers WHERE username='$username' AND password='$password' AND company='$company'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['supplier_id'] = $row['supplier_id'];
            header("Location: supplier_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid username, password, or company. Please try again.');</script>";
        }
    } elseif(isset($_POST['register_user']) && isset($_POST['register_pass']) && isset($_POST['register_company'])) {
        // Supplier registration
        $username = $_POST['register_user'];
        $password = $_POST['register_pass'];
        $company = $_POST['register_company'];

        // Check if username is already taken
        $check_query = "SELECT * FROM suppliers WHERE username='$username'";
        $check_result = mysqli_query($conn, $check_query);

        if(mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Username already exists. Please choose a different username.');</script>";
        } else {
            // Insert new supplier into database
            $insert_query = "INSERT INTO suppliers (username, password, company) VALUES ('$username', '$password', '$company')";
            if(mysqli_query($conn, $insert_query)) {
                echo "<script>alert('Account created successfully. You can now login.');</script>";
            } else {
                echo "<script>alert('Error creating account. Please try again.');</script>";
            }
        }
    }

    // Close the database connection
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Supplier Login</title>
    <link rel='stylesheet' href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        /* Additional styles for Supplier Login page */
        .loginBody {
            background-color: #6c757d; /* Grayish blue color */
            background-image: url('jumbotron.jpg');
        }

        .supplier-btn {
            margin-top: 20px;
            text-decoration: underline;
            font-weight: bold;
            cursor: pointer;
        }

        .supplier-btn:hover {
            color: #28a745; /* Green color */
        }
    </style>
</head>
<body class='loginBody'>
    <div class="topStyle">
        <h2 style="color:white;">Wholesale DataBase Management</h2>
        <button id='userLogin' class='btn'>Login</button>&nbsp
        <button id='createAccount' class='btn'>Create New Account</button>
    </div>
    <div class="mybox" style="display:inline-block;">
        <div id="userPrompt" style="display:block;">
            <!-- Supplier login form -->
            <form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                <h3>Supplier Login</h3>
                <input class="inputItem" type="text" name="login_user" placeholder="Username" required><br>
                <input class="inputItem" type="password" name="login_pass" placeholder="Password" required><br>
                <input class="inputItem" type="text" name="login_company" placeholder="Company" required><br>
                <input type="submit" value="Login" class="btn">
            </form>    
        </div>
        <!-- Supplier registration form -->
        <div id="createAccountPrompt" style="display:none;">
            <form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                <h3>Create A New Account</h3>
                <input class="inputItem" type="text" name="register_user" placeholder="Username" required><br>
                <input class="inputItem" type="password" name="register_pass" placeholder="Password" required><br>
                <input class="inputItem" type="password" name="confirm_pass" placeholder="Confirm Password" required><br>
                <input class="inputItem" type="text" name="register_company" placeholder="Company" required><br>
                <input type="submit" value="Create" class="btn">
            </form>    
        </div>
        <!-- Link to return to customer login -->
        <p>Are you a Customer?
        <a href="loginPage.php" class="supplier-btn">Click here</a></p>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#userLogin').click(function(){
                $('#userPrompt').slideDown();
                $('#createAccountPrompt').css("display","none");
            });
            $('#createAccount').click(function(){
                $('#userPrompt').css("display","none");
                $('#createAccountPrompt').slideDown();
            }); 
        });
    </script>
</body>
</html>

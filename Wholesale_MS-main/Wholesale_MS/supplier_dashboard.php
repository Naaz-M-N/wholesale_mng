<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Add your additional CSS styles here */
        /* Sidebar */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: #444;
        }

        /* Content */
     .content {
    margin-left: 250px;
    padding: 20px;
    margin-top: 50px;
    background-image: url('WMS_DB.png');
    background-size: cover; /* Ensure image covers the entire container */
    background-repeat: no-repeat; /* Prevent image from repeating */
    background-position: center; /* Center the image */
    color: white;
    width: 100%;
    height: 100vh; /* Set the height to match the viewport height */
    overflow: hidden; /* Hide any overflow content */
}



        /* TopStyle */
        .topStyle {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #333; /* Change the background color */
            padding: 2px 13px; /* Adjust padding as needed */
            box-sizing: border-box;
        }

    </style>
</head>
<body>

    <!-- Top style -->
    <div class="topStyle">
        <h2 style="color:white;">Wholesale DataBase Management</h2>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="add_profile.php">Home</a>
    </div>

    <!-- Page content -->
    <div class="content"><br>
        <h2>Welcome to Supplier Dashboard</h2>

    </div>

</body>
</html>

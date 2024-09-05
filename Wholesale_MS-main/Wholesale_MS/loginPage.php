<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<link rel='stylesheet' href="css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>Login</title>
<style>
/* Apply styles to the body */

.loginBody {
  top: 0;
  left: 0;
  font-family: sans-serif;
  line-height: 1.5em;
  background-color: #6c757d; /* Grayish blue color */
  margin: 0; /* Remove default margin */
  padding: 0; /* Remove default padding */
  background-image: url('jumbotron.jpg'); /* Set background image
 /* Center the background image */
  .loginBody {
  background-size: contain; /* Fit the entire image within the container */
  background-repeat: no-repeat; /* Prevent the image from repeating */
  background-position: center; /* Center the background image */
}

}

/* Style for the image */
.login-bg {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover; /* Make sure the image covers the entire viewport */
  z-index: -1; /* Send the image behind other content */
}


   .btn-supplier {
            display: block;
            text-align: center;
            margin-top: 10px; /* Adjust top margin as needed */
        }

        .btn-supplier a {
            text-decoration: none;
            color: #fff;
            font-weight: bold; /* Make the text bold */
            text-decoration: underline; /* Underline the text */
            color: black;
        }

        .btn-supplier a:hover {
            text-decoration: none; /* Remove underline on hover */
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
			<form method='post' action='login.php'>
				<h3>Login</h3>
				<input class="inputItem" type=text name='user' placeholder="Username" required><br><input class="inputItem" type=password name='pass' placeholder="Password" required><br><input type="submit" value="Login" class="btn">
<div class="btn-supplier">
                Are you a supplier? <a href="supplier.php">Click here</a>
            </div>
			</form>	
		</div>

		<div id="createAccountPrompt" style="display:none;">
			<form id='createAccountForm' method='post' action='createAccount.php'>
				<h3>Create A New Account</h3>
				<input id='newUserUserName' class="inputItem" type=text name='newUserName' placeholder="Pick a Username" required><br>
				<input id='newUserName' class="inputItem" type=text name='newName' placeholder="Name" required><br>
				<input id='newUserEmail' class="inputItem" type=text name='newEmail' placeholder="Email-ID" required><br>
				<input id='newUserPassword' class="inputItem" type=password name='newPass' placeholder="New Password" required>
				<br><input id="newUserConfirmPassword" class="inputItem" type=password name='newConfirmPass' placeholder="Confirm Password" required><br><input type="submit" value="Create" class="btn">

			</form>	
		</div>
	</div>

</body>
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
</html>


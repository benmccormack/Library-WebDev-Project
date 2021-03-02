<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="Assets/CSS/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<?php
		//inserting the common header
		require_once "header.php";
	?>
		

	<div id="white">
		<?php
			session_start();
			require_once "db.php";

			//check if user is already logged in
			if (isset($_SESSION["username"])) {

				//redirect to home page
				header("Location: index.php");

			} else {

				if (isset($_POST['username']) && isset($_POST['password']))
				{
					$username = mysqli_escape_string($db,($_POST['username']));
					$password = mysqli_escape_string($db,($_POST['password']));

					//sql query to searcg the database for the username and password entered in the form
					$sql = "SELECT * FROM users WHERE Username ='$username' AND password = '$password'";
					$result = mysqli_query($db,$sql);

					//Checking if the credentials exist within the database
					if (mysqli_num_rows($result)==1) {

						//if the credentials do exist redirect to the search page
						header("Location: index.php");

						//putting the username variable into a global session variable
						$_SESSION["username"] = $username;

					}else{
						//if the credentials do not exist this error is displayed.
						echo "<p>Invalid credentials entered. Please try again.</p>";
					}
				}
			}
		?>

		<h2>Login</h2>
		<form method="post">
			<p>Username: <input type="text" name="username"></p>
			<p>Password: <input type="password" name="password"></p>
			<input type="Submit" value="Login">
			<p>Don't have an account? <a href = "register.php">Register here</p></a>
		</form>
	</div>

	<?php
		//inserting the common footer
		require_once "footer.php";
	?>
</body>

</html>
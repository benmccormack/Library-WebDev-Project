<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" href="Assets/CSS/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<?php
		//starting session
		session_start();

		//inserting the common header
		require_once "header.php";
		
		//making the connection to the database
		require_once"db.php";


		//check if user is already logged in
			if (isset($_SESSION["username"])) {

				//redirect to home page
				header("Location: index.php");

			} else {

			if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmPassword']) &&isset($_POST['firstName']) && isset($_POST['surname']) && isset($_POST['address1']) && isset($_POST['address2']) && isset($_POST['city']) && isset($_POST['telephone']) && isset($_POST['mobile'])) {
				
				//delcaring variables from form input
				$username = mysqli_escape_string($db,($_POST['username']));
				$password = mysqli_escape_string($db,($_POST['password']));
				$confirmPassword = mysqli_escape_string($db,($_POST['confirmPassword']));
				$firstName= mysqli_escape_string($db,($_POST['firstName']));
				$surname = mysqli_escape_string($db,($_POST['surname']));
				$address1 = mysqli_escape_string($db,($_POST['address1']));
				$address2 = mysqli_escape_string($db,($_POST['address2']));
				$city = mysqli_escape_string($db,($_POST['city']));
				$telephone = mysqli_escape_string($db,($_POST['telephone']));
				$mobile = mysqli_escape_string($db,($_POST['mobile']));

				//search the database for the username the user wants to register and check if it exists
				$sql = $sql = "SELECT * FROM users WHERE Username ='$username'";
				$result = mysqli_query($db,$sql);

				//if statement to check if the username already exists
				if (mysqli_num_rows($result)==1) {
					echo "Error: username already exists";
				} else
				{
					//if statement to ensure the password is 6 characters long and password field matches confirm password field
					if ( strlen($password) == 6 && $password == $confirmPassword) {
						//password is ok - proceed 

						//if statement to check telephone number is 7 digits and is numeric
						if (strlen($telephone)==7 && is_numeric($telephone)) {
							//telephone is ok - proceed

							//if statement to check mobile number is 10 digits long and is numeric
							if (strlen($mobile)==10 && is_numeric($mobile)) {
								//if all error checks are passed, the information is inserted into database
								$sql = "INSERT INTO users(Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) VALUES ('$username','$password', '$firstName','$surname','$address1','$address2','$city','$telephone','$mobile')";

								mysqli_query($db,$sql);
								
								echo "Registration Successful";
							} 
							else {
								//error message if mobile number entered does not meet requirements
								echo "Mobile phone number invalid. Please ensure it's numeric and 10 numbers in length";
							} //end mobile if else
						}
						else {
							//error message if telephone number entered does not meet the requirements
							echo "Telephone number invalid. Please ensure it's numeric and 7 numbers in length";
						} //end telephone if else
						
						
					}else{
						//error message if the passwords do not match or are not 6 characters in length
						echo "Error: Passwords either do match or password is not 6 characters. Please try again.";
					} //end password if else
				} //end if statement
			}
		}
	?>

	<div id="white">
		<h2>Create An Account</h2>
		<div id="registerLeft">
			<form method="post">
				<p>Username: <input type="text" name="username"></p>
				<p>Password: <input type="password" name="password"></p>
				<p>Confirm Password: <input type="password" name="confirmPassword"></p>
				<p>First Name: <input type="text" name="firstName"></p>
				<p>Surname: <input type="text" name="surname"></p>
		</div>
		<div id="registerRight">
				<p>Address Line 1: <input type="text" name="address1"></p>
				<p>Address Line 2: <input type="text" name="address2"></p>
				<p>City: <input type="text" name="city"></p>
				<p>Telephone: <input type="text" name="telephone"></p>
				<p>Mobile: <input type="text" name="mobile"></p>
		</div>
				<br><input type="Submit" value="Create Account"><br>
				<p>Already have an account? <a href = "login.php">Login here</p></a>
			</form>
	</div>
		
	<?php
		//inserting the common footer
		require_once "footer.php";
	?>

</body>
</html>
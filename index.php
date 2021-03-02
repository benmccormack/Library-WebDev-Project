<?php 
	//starting the session
	session_start() ;
	
	//checking if the user is logged in and returning them to the home page if they aren't
	if (!isset($_SESSION["username"])) {
		header("Location: login.php");
	} else {
		$username = $_SESSION["username"];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Search</title>
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
			<a href="search.php">
				<h2>Search Books</h2>
				<p>Search the library for books</p>
			</a>
		</div>
		
		<br><br>
		
		<div id="white">
			<a href="reservations.php">
				<h2>View Reservations</h2>
				<p>View your current reservations</p>
			</a>
		</div>
		
		<?php
			//inserting the common footer
			require_once "footer.php";
		?>
	</body>

</html>
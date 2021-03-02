<html>
<head>
	<title>Reservation</title>
	<link rel="stylesheet" href="Assets/CSS/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<?php
		//starting the session
		session_start();

		//making the connection to the database
		require_once "db.php";

		//inserting the common header
		require_once "header.php";

		//if the user is not logged in they are redirected to the login page
		if (! isset($_SESSION['username'])) {
			header("Location: login.php");

		} else {
			//carrying the ISBN across with a superglobal
			$isbn = $_GET['isbn'];

			//deleting the reservation from the table
			$sql = "DELETE FROM reservations WHERE ISBN = '$isbn'";
			$removeReservation = mysqli_query($db, $sql);

			//updating the books table so the book is available for reservation again
			$sql = "UPDATE books SET Reserved = 'N' WHERE ISBN ='$isbn'";
			$updateBooks = mysqli_query($db,$sql);
		}
	?>

	<div id="white">
		<h2>Return Successful!</h2>
		<p>You have successfully returned your selected book.</p>
		
		<button><a href="index.php">Continue</a></button>
		<button><a href="search.php">Search Books</a></button>
	</div>
	
	<?php
		//inserting the common footer
		require_once "footer.php";
	?>

</body>
</html>
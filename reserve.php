<html>
<head>
	<title>Reservation</title>
	<link rel="stylesheet" href="Assets/CSS/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
	<?php
		//starting session
		session_start();

		//establishing connection to the database
		require_once "db.php";

		//inserting the common header
		require_once "header.php";

		//printing username to ensure session functionality is functioning
		$username =  $_SESSION['username'];

		//setiing the current date
		$date = strval(date('Y-m-d'));
		
		//reserved variable
		$reserved = 'Y';
		
		//carry isbn across to document with superglobal
		$isbn = $_GET['isbn'];

		//selecting the column where the ISBN matches the isbn vairable
		$result = mysqli_query($db,"SELECT ISBN, BookTitle, Author, Edition, Year, CategoryCode, Reserved FROM books WHERE ISBN = '$isbn'");

		//Updating the books table to say the book has been reserved and is no longer available for reservation
		$updateBooks = "UPDATE books SET Reserved = '$reserved' WHERE ISBN ='$isbn'";
		mysqli_query($db,$updateBooks);

		//Placing the new reservation into the reservations table
		$reservationNew = "INSERT INTO reservations (ISBN, Username, ReservedDate) VALUES ('$isbn', '$username', '$date')";
		mysqli_query($db,$reservationNew);
	?>

	<div id="white">
		<h2>Reservation Successful!</h2>
		<p>You have successfully reserved your selected book.</p>
		<p>Your reservation has been added to the "My Reservations" page.</p>

		<button><a href="index.php">Continue</a></button>
		<button><a href="reservations.php">View Reservations</a></button>
	</div>
	
	<?php
		//inserting the common footer
		require_once "footer.php";
	?>
</body>
</html>

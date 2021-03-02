<?php session_start() ?>
<html>
	<head>
		<title>Reservations</title>
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
			<h2>Your Reservations</h2>
			<p>If you have any reservations, they will appear here</p>

			<?php
				//creating the connction to the database
				require_once "db.php";

				//if the user is not logged in they are redirected to the login page
				if (! isset($_SESSION['username'])) {
					header("Location: login.php");

				} else {
					//assigning the session username to a variable
					$username =  $_SESSION['username'];

					//amount of results per page
					$page_results = 5;

					//sql statement to retrieve entries from the database with the logged in username
					$sql = "SELECT ISBN,BookTitle,Username, ReservedDate FROM reservations JOIN books USING(ISBN) WHERE Username = '$username'";

					//the sql query
					$result = mysqli_query($db,$sql);
					$number_of_results = mysqli_num_rows($result);

					//find the total number of pages
					$number_of_pages = ceil($number_of_results / $page_results);

					//display what page the user is currently on
					if (!isset($_GET['page'])) {
						$page = 1;
					} else {
						$page = $_GET['page'];
					}

					//find the sql LIMIT starting for the results on the displaying page
					$this_page_first_result = ($page-1)*$page_results;


					$sql = "SELECT ISBN,BookTitle,Username, ReservedDate FROM reservations JOIN books USING(ISBN) WHERE Username = '$username'LIMIT " . $this_page_first_result. ','  .$page_results;

					//the sql query
					$result = mysqli_query($db,$sql);

					//printing the reservations
					echo '<table border="1">'."\n";
							//printing table headers
							echo"<th>ISBN</th>";
							echo"<th>Book Name</th>";
							echo"<th>Username</th>";
							echo"<th>Reserved Date</th></tr>";
							//printing table rows
							while ($row = mysqli_fetch_row($result)) {
								echo "<td>";
								echo (htmlentities($row[0]));
								echo "</td><td>";
								echo(htmlentities($row[1]));
								echo("</td><td>");
								echo(htmlentities($row[2]));
								echo("</td><td>");
								echo(htmlentities($row[3]));
								echo("</td><td>");
								echo('<a href="return.php?isbn='.htmlentities($row[0]).'">Return</a>');
								echo "</td><tr>";
							}
						echo "</table>";

						//display the links to the pages
						for($page=1;$page<=$number_of_pages;$page++){
							echo'<a href="reservations.php?page=' . $page . '">' . $page . '</a> ';
						}
					}
				?>
		</div>

		<?php
		//inserting the common footer
		require_once "footer.php";
		?>

	</body>
</html>
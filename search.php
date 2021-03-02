<?php 
		//creating the connection to the database
		require_once "db.php";

		//starting the session
		session_start() ;

		//checking if the user is logged in. Redirecting them to the home page if not
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
		<p>Currently logged in as: <?php echo "$username"; ?></p>
		<h2>Search For A Book</h2>

		<form method="post">
			<p>Search by Author or Book Name: 
				<input type="text" name="bookOrAuthor">
				<input type="Submit" value="Search">
			</p>
		</form>
		<br>
		<form method="post">
			<p>Search by Category: 
				<select name="categoryCode">
					<?php
						//setting the default to zero. Initially nothing selected
						$categoryCode = 0;
						//default acts as a placeholder in the dropdown
						$default = "Choose an option";
						//sql query to select all cetegories from database
						$sql= "SELECT * FROM category";
						//executing query
						$result = mysqli_query($db, $sql);
						//default option
						echo '<option value=".$categoryCode">'.$default.'</option>';
						//generating the drop down menu
						while ($row = mysqli_fetch_array($result)) {
							echo '<option value="'.$row['CategoryID'].'">'.$row['CategoryDesc'].'</option>';
						}
					?>
				</select>
				<input type="Submit" value="Search">
			</p>
		</form>

	<?php
		//search by author ot title including partial search
		if (isset($_POST['bookOrAuthor'])) {
			$bookOrAuthor = mysqli_escape_string($db,($_POST['bookOrAuthor']));

			//amount of results per page
			$page_results = 5;

			//find out the number of results stored in the database
			$bookOrAuthorSearch = "SELECT * FROM books WHERE Author LIKE '%$bookOrAuthor%' OR BookTitle LIKE '%$bookOrAuthor%' ";

			$result = mysqli_query($db,$bookOrAuthorSearch);
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

			//retrieve selected results from database and display them on page
			$sql = "SELECT * FROM books WHERE Author LIKE '%$bookOrAuthor%' OR BookTitle LIKE '%$bookOrAuthor%' LIMIT " . $this_page_first_result. ','  .$page_results;

			$result = mysqli_query($db,$sql);

			echo '<table border="1">'."\n";
				echo"<th>ISBN</th>";
				echo"<th>Book Name</th>";
				echo"<th>Author</th>";
				echo"<th>Edition</th>";
				echo"<th>Year</th>";
				echo"<th>Category Code</th>";
				echo"<th>Reserved</th></tr>";
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
					echo(htmlentities($row[4]));
					echo("</td><td>");
					echo(htmlentities($row[5]));
					echo("</td><td>");
					echo(htmlentities($row[6]));
					echo "</td><td>";
					if ($row[6] == 'N') {
						echo('<a href="reserve.php?isbn='.htmlentities($row[0]).'">Reserve</a>');
					}
					echo "</td><tr>";
				}
			echo "</table>";

			//display the links to the pages
			for($page=1;$page<=$number_of_pages;$page++){
				echo'<a href="search.php?page=' . $page . '">' . $page . '</a> ';
			}
		}	
			


		//search by category
		if (isset($_POST['categoryCode'])) {

			//assigning the category code
			$categoryCode = ($_POST['categoryCode']);

			//amount of results per page
			$page_results = 5;

			//category search query
			$sql = "SELECT * FROM books WHERE CategoryCode = '$categoryCode'";
			
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


			$sql = "SELECT * FROM books WHERE CategoryCode = '$categoryCode' LIMIT " . $this_page_first_result. ','  .$page_results;;

			//the sql query
			$categoryResult = mysqli_query($db,$sql);

			//printing the reseults
			echo '<table border="1">'."\n";
				echo"<th>ISBN</th>";
				echo"<th>Book Name</th>";
				echo"<th>Author</th>";
				echo"<th>Edition</th>";
				echo"<th>Year</th>";
				echo"<th>Category Code</th>";
				echo"<th>Reserved</th></tr>";
				while ($row = mysqli_fetch_row($categoryResult)) {
					echo "<td>";
					echo (htmlentities($row[0]));
					echo "</td><td>";
					echo(htmlentities($row[1]));
					echo("</td><td>");
					echo(htmlentities($row[2]));
					echo("</td><td>");
					echo(htmlentities($row[3]));
					echo("</td><td>");
					echo(htmlentities($row[4]));
					echo("</td><td>");
					echo(htmlentities($row[5]));
					echo("</td><td>");
					echo(htmlentities($row[6]));
					echo "</td><td>";
					if ($row[6] == 'N') {
						echo('<a href="reserve.php?isbn='.htmlentities($row[0]).'">Reserve</a>');
					}
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
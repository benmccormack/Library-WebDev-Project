<?php
	//start session
	session_start();
	//destroy session and redirect the user to the login page
	session_destroy();
	header("Location: login.php");
?>
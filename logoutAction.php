<?php
	session_start();
	
	// Use $HTTP_SESSION_VARS with PHP 4.0.6 or less
	unset($_SESSION['user']);

	// Redirecting to the logged page.
	header("Location: login.php");
?>

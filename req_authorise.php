<?php
	// redirect if the 'user' session variable is not set (not authorised)
	if(!isset($_SESSION['user'])){
		header("Location: notAuthorised.php");
		$authorised = FALSE;
	} else{	$authorised = TRUE; $user = $_SESSION['user']; }
	
?>
<?php
	// redirect if the user is not an admin
	if(isset($_SESSION['user'])){
		if($_SESSION['user'] != 'clv219' && $_SESSION['user'] != 'admin'){
			header("Location: notAuthorised.php");
			$authorised = FALSE;
		}
	} else {$authorised = TRUE;}
	
?>
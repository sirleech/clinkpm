<?php

session_start();
require_once 'req_authorise.php';
//extra security, only admins can delete
require_once 'req_authorise_admin.php';
require_once 'req_connect.php';
require_once 'req_constants.php';

if ($authorised) {

	// $startDate = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
	// $endDate = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";
	$username = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";

	$query = 'delete from users WHERE user_name=\''.$username.'\'';
	
	//EDIT: cannot delete user "admin"
	if ($username == 'admin') {
		$_SESSION['messageError'] = 'User '.$username.' cannot be deleted.';
	//EDIT: cannot delete the current logged in user (myself)
	} elseif ($user == $username) {
		$_SESSION['messageError'] = 'You cannot delete yourself.';
	// Successful delete
	} else {
		$result = mysql_query($query) or die('Query failed : ' . mysql_error());
		$_SESSION['messageSuccess'] = 'User '.$username.' deleted successfully.';
	}

	$header = 'Location: users.php' ;
	header($header);

}
	  
		  
?> 
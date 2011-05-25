<?php
	session_start();
	
	require_once 'req_topNav.php';
	$_SESSION['messageError'] = 'You are not authorised to perform this action.';
	require_once 'req_messages.php';
	

?>	
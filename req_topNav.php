<html>
<head><title>Families IT</title>
<LINK href="styles.css" rel="stylesheet" type="text/css" media="screen">
<LINK href="styles_print.css" rel="stylesheet" type="text/css" media="print">
<script language="javascript" src="calendar.js"></script>
</head>
<body>
<div class="page">
<?php

//debug for session variables
require_once 'req_session_debug.php';
require_once 'req_functions.php';


echo '<b>FAO 2.0</b> | ';

if(!isset($_SESSION['user'])){
	echo '<a href="login.php">Log In</a>';
} else {
    echo ' <a href="logoutAction.php">Log Out</a> | ';
	$user = $_SESSION['user'];
    echo 'Hello '.getUserFullName($user).' | <a href="user.php">My Account </a>';
}	
echo '<span class="breadcrumb">| <a href="index.php">Home ></a></span>';

?>


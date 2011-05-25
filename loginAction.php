<?php

session_start();
require 'req_connect.php';
require 'req_constants.php';

/* Perform SQL query */
$query = 'SELECT * FROM '.USER_TABLE;
$result = mysql_query($query)
or die('Query failed : ' . mysql_error());

$authenticated = FALSE;

if(isset($_REQUEST['username']) && isset($_REQUEST['password']))
{
	$user = trim($_REQUEST['username']);
	$pass = trim($_REQUEST['password']);
	
	while ($row = mysql_fetch_assoc($result)) 
	{
		if ($user == $row['user_name'] && $pass == $row['password'])
		{
			$authenticated = TRUE;
		}
	}
	
	if($authenticated)
	{
		session_start();
		$_SESSION['user'] = $user;		   
		$_SESSION['messageSuccess'] = 'Welcome! You are now logged in.';
		header("Location: index.php");
	}
	else
	{
		//echo 'Wrong username or Password. Show error here.';		   
		$_SESSION['messageError'] = 'Wrong username or Password.';
		header("Location: login.php");
		
	}	   
	
}

require 'req_freeAndDisconnect.php';

?> 
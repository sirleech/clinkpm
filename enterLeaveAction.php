<?php

session_start();
require_once 'req_connect.php';
require_once 'req_constants.php';

$startDate = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
$endDate = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";
$userName = isset($_REQUEST["username"]) ? $_REQUEST["username"] : "";
$leaveType = isset($_REQUEST["leaveType"]) ? $_REQUEST["leaveType"] : "";
$estimate = isset($_REQUEST["estimate"]) ? $_REQUEST["estimate"] : "";

//$estimate = 1;

// Check for valid user
$query = 'select * from '.USER_TABLE.' where user_name = \''.$userName.'\'';
$result = mysql_query($query) or die('Query failed : ' . mysql_error());
$userValid = false;

while ($row = mysql_fetch_assoc($result)) {
	$userValid = true;
}
if ($userValid) {
	$query = 'insert into '.LEAVE_PLAN_TABLE.
			 ' values (\'\',\''.$userName.'\',\''.$startDate.'\',\''.$endDate.'\',\''.$leaveType.'\','.$estimate.')';
	$result = mysql_query($query) or die('Query failed : ' . mysql_error());		  
	$_SESSION['messageSuccess'] = 'Leave plan added successfully.';
	
	//redirect back to leave calendar
	$year = $_SESSION['year'];
	$team = $_SESSION['team'];
	$header = 'Location: leaveCalendar.php?year='.$year.'&team='.$team; 
	header($header);

} else {
	$_SESSION['messageError'] = 'That username does not exist.';
	header("Location: enterLeave.php");
}
	  
		  
?> 
<?php

session_start();
require_once 'req_authorise.php';
require_once 'req_connect.php';
require_once 'req_constants.php';

// $startDate = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
// $endDate = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";
$leaveId = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";

// sample delete query
// delete from leave_plans where leave_id = '20';

$query = 'delete from '.LEAVE_PLAN_TABLE.' WHERE leave_id=\''.$leaveId.'\'';
$result = mysql_query($query) or die('Query failed : ' . mysql_error());

$_SESSION['messageSuccess'] = 'Leave plan '.$leaveId.' deleted successfully.';

//redirect back to leave calendar
$year = $_SESSION['year'];
$team = $_SESSION['team'];
$header = 'Location: leaveCalendar.php?year='.$year.'&team='.$team; 
header($header);
	  
		  
?> 
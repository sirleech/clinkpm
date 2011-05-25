<?php

session_start();
require_once 'req_authorise.php';
require_once 'req_connect.php';
require_once 'req_constants.php';

if ($authorised) {

	$startDate = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
	$endDate = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";
	$leaveId = isset($_REQUEST["leaveId"]) ? $_REQUEST["leaveId"] : "";
	$leaveType = isset($_REQUEST["leaveType"]) ? $_REQUEST["leaveType"] : "";
	$estimate = isset($_REQUEST["estimate"]) ? $_REQUEST["estimate"] : "";

	// sample edit query
	// update leave_plans SET start_date='2011-01-15', end_date='2011-01-18' WHERE leave_id='22';

	$query = 'update '.LEAVE_PLAN_TABLE.' SET 
			 start_date=\''.$startDate.'\', 
			 end_date=\''.$endDate.'\', 
			 leave_type=\''.$leaveType.'\',
			 estimate=\''.$estimate.'\'
			 WHERE leave_id=\''.$leaveId.'\'';
			 
	$result = mysql_query($query) or die('Query failed : ' . mysql_error());

	$msg = 'Leave plan edited successfully.';
	//debug
	//$msg = $msg.' Leave ID = '.$leaveId.' Leave Type = '.$leaveType;

	$_SESSION['messageSuccess'] = $msg;

	//redirect back to leave calendar
	$year = $_SESSION['year'];
	$team = $_SESSION['team'];
	$header = 'Location: leaveCalendar.php?year='.$year.'&team='.$team; 
	header($header);

}
	  
		  
?> 
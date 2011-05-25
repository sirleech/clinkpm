<?php

session_start();
require_once 'req_authorise.php';
require_once 'req_connect.php';
require_once 'req_constants.php';

$username = isset($_REQUEST["username"]) ? $_REQUEST["username"] : "";
$firstName = isset($_REQUEST["firstName"]) ? $_REQUEST["firstName"] : "";
$surName = isset($_REQUEST["surName"]) ? $_REQUEST["surName"] : "";
$team = isset($_REQUEST["team"]) ? $_REQUEST["team"] : "";
$role = isset($_REQUEST["role"]) ? $_REQUEST["role"] : "";
$emailAddress = isset($_REQUEST["emailAddress"]) ? $_REQUEST["emailAddress"] : "";
$areaCode = isset($_REQUEST["areaCode"]) ? $_REQUEST["areaCode"] : "";
$phoneNumber = isset($_REQUEST["phoneNumber"]) ? $_REQUEST["phoneNumber"] : "";

// sample edit query
// update leave_plans SET start_date='2011-01-15', end_date='2011-01-18' WHERE leave_id='22';

$query = 'update users SET 
         first_name =\''.$firstName.'\', 
		 sur_name =\''.$surName.'\', 
		 team =\''.$team.'\',
		 role =\''.$role.'\',
		 email_address =\''.$emailAddress.'\',
		 area_code =\''.$areaCode.'\',
		 phone_number =\''.$phoneNumber.'\'
		 WHERE user_name =\''.$username.'\'';
		 
$result = mysql_query($query) or die('Query failed : ' . mysql_error());

$msg = 'User details edited successfully.';
//debug
// $msg = $msg.' username='.$username.',firstName='.$firstName.',surName='.$surName.',team='.$team.'<br/>'
       // .',role='.$role.',emailAddress='.$emailAddress.',areaCode='.$areaCode.',phoneNumber='.$phoneNumber;

$_SESSION['messageSuccess'] = $msg;

//redirect back to leave calendar
//$selectedUser = $_SESSION['selectedUser'];

$header = 'Location: user.php?username='.$username; 
header($header);
	  
		  
?> 
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
$password = '';

$query = 'INSERT INTO users VALUES 
         (\''.$username.'\',\''.$password.'\',\''.$firstName.'\',\''.$surName.'\',\''.$team.'\',\''.$role.'\',\''.$emailAddress.'\',\''.$phoneNumber.'\',\''.$areaCode.'\')';

$msg = 'User added successfully.';
//debug
// $msg = $msg.' username='.$username.',firstName='.$firstName.',surName='.$surName.',team='.$team.'<br/>'
       // .',role='.$role.',emailAddress='.$emailAddress.',areaCode='.$areaCode.',phoneNumber='.$phoneNumber;



// EDIT: user already exists

// EDIT: no username, team or role
if ($username == '') {
	$_SESSION['messageError'] = 'Logon Id cannot be blank';
	$header = 'Location: addUser.php';
}elseif ($team == '') {
	$_SESSION['messageError'] = 'Team cannot be blank';
	$header = 'Location: addUser.php';	
}elseif ($role == '') {
	$_SESSION['messageError'] = 'Role cannot be blank';
	$header = 'Location: addUser.php';	
//Good update, add user	
} else {  
	$_SESSION['messageSuccess'] = $msg;
	$result = mysql_query($query) or die('Query failed : ' . mysql_error());
	$header = 'Location: user.php?username='.$username;
}

//redirect back to leave calendar
//$selectedUser = $_SESSION['selectedUser'];
 
header($header);
	  
		  
?> 
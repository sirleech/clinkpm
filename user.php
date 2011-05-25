<?php
//user.php?userid=clv219
// Read-only screen to show a list of users

session_start();

if (isset($_GET["username"])){
	$username = htmlspecialchars($_GET["username"]);
} else {
	$username = $_SESSION['user'];
}

// Set the selected user session var
$_SESSION['selectedUser'] = $username;

require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_functions.php';
require_once('classes/User.php');

require_once 'req_topNav.php';	
echo '|  <span class="breadcrumb"><a href="users.php">Staff List</a> > User Details </span><br/>';
require_once 'req_messages.php';
echo '<span class="secondLevelNav"><a class="noline" href="editUser.php?username='.$username.'">Edit User Details</a></span>';

$user = new User($username);

echo '<h1>Staff Details for '.$user->firstName.' '.$user->surName.'</h1>';

echo '<table border=1>';
echo ' <tr><td class="tableHeaderTd">Logon Id</td><td>'.$user->userName.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">First Name</td><td>'.$user->firstName.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">Surname</td><td>'.$user->surName.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">Team</td><td>'.$user->team.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">Role</td><td>'.$user->role.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">Email</td><td>'.$user->emailAddress.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">Area Code</td><td>'.$user->areaCode.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">Phone Number</td><td>'.$user->phoneNumber.'</td></tr>';
echo '</table>';


?>
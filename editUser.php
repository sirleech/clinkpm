<?php
//editUser.php?userid=clv219


session_start();

if (isset($_GET["username"])){
	$username = htmlspecialchars($_GET["username"]);
} else {
	$username = $_SESSION['user'];
}

// Set the selected user session var
$_SESSION['selectedUser'] = $username;

require_once 'req_connect.php';
require_once 'req_authorise.php';
require_once 'req_constants.php';
require_once 'req_functions.php';
require_once('classes/User.php');

require_once 'req_topNav.php';	
echo '|  <span class="breadcrumb"><a href="users.php">Staff List</a> > Edit User Details </span>';
require_once 'req_messages.php';

$user = new User($username);
$fc1Checked = '';
$fc3Checked = '';
$fc4Checked = '';
$mgtChecked = '';

switch ($user->team) {
case 'fc1':
	$fc1Checked = 'checked';
	break;
case 'fc3':
	$fc3Checked = 'checked';
	break;
case 'fc4':
	$fc4Checked = 'checked';
	break;	
case 'mgt':
	$mgtChecked = 'checked';
	break;		
}

$techoChecked = '';
$baChecked = '';
$teamleaderChecked = '';
$designerChecked = '';
$otherChecked = '';

switch ($user->role) {
case 'techo':
	$techoChecked = 'checked';
	break;
case 'ba':
	$baChecked = 'checked';
	break;
case 'designer':
	$designerChecked = 'checked';
	break;	
case 'teamleader':
	$teamleaderChecked = 'checked';
	break;		
case 'other':
	$otherChecked = 'checked';
	break;			
}

echo '<h1>Edit User Details for '.$user->firstName.' '.$user->surName.'</h1>';
echo '<form action="editUserAction.php" method="post" name="editUserForm">';

echo '<table border=1>';
echo ' <tr><td class="tableHeaderTd">Logon Id</td><td>'.$user->userName.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">First Name</td><td><input name="firstName" type="text" value="'.$user->firstName.'"></td></tr>';
echo ' <tr><td class="tableHeaderTd">Surname</td><td><input name="surName" "type="text" value="'.$user->surName.'"></td></tr>';
echo ' <tr><td class="tableHeaderTd">Team</td><td>';
echo '<input type="radio" name="team" value="fc1" '.$fc1Checked.'/>FC1
	  <input type="radio" name="team" value="fc3" '.$fc3Checked.'/>FC3 
	  <input type="radio" name="team" value="fc4" '.$fc4Checked.'/>FC4
	  <input type="radio" name="team" value="mgt" '.$mgtChecked.'/>Management</td></tr>';
echo ' <tr><td class="tableHeaderTd">Role</td><td>';
echo '<input type="radio" name="role" value="techo" '.$techoChecked.'/>Techo
	  <input type="radio" name="role" value="ba" '.$baChecked.'/>BA
	  <input type="radio" name="role" value="teamleader" '.$teamleaderChecked.'/>Teamleader
	  <input type="radio" name="role" value="designer" '.$designerChecked.'/>Designer
	  <input type="radio" name="role" value="other" '.$otherChecked.'/>Other</td></tr>';
echo ' <tr><td class="tableHeaderTd">Email</td><td><input name="emailAddress" type="text" size="40" value="'.$user->emailAddress.'"></td></tr>';
echo ' <tr><td class="tableHeaderTd">Area Code</td><td><input name="areaCode" type="text" value="'.$user->areaCode.'"></td></tr>';
echo ' <tr><td class="tableHeaderTd">Phone Number</td><td><input name="phoneNumber" type="text" value="'.$user->phoneNumber.'"></td></tr>';
echo '</table>';

echo '<input type="submit" value="Submit"/>';
echo '<input type="text" class="formHidden" name="username" value="'.$username.'">';
echo '</form>';

echo '<h3><a href="deleteConfirm.php?action=deleteUserAction&id='.$username.'">Delete User</a></h3>';	  

require_once 'req_bottom.php';	


?>
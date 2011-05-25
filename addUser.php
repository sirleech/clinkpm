<?php

session_start();

require_once 'req_authorise.php';
require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_functions.php';

require_once 'req_topNav.php';	
echo '|  <span class="breadcrumb"><a href="users.php">Staff List</a> > Add A User </span>';
require_once 'req_messages.php';

echo '<h1>Add A User</h1>';
echo '<form action="addUserAction.php" method="post">';

echo '<table border=1>';
echo ' <tr><td class="tableHeaderTd">Logon Id</td><td><input name="username" type="text">'.$reqAsterix.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">First Name</td><td><input name="firstName" type="text"></td></tr>';
echo ' <tr><td class="tableHeaderTd">Surname</td><td><input name="surName" "type="text"></td></tr>';
echo ' <tr><td class="tableHeaderTd">Team</td><td>';
echo '<input type="radio" name="team" value="fc1"/>FC1
	  <input type="radio" name="team" value="fc3"/>FC3 
	  <input type="radio" name="team" value="fc4"/>FC4
	  <input type="radio" name="team" value="mgt"/>Management'.$reqAsterix.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">Role</td><td>';
echo '<input type="radio" name="role" value="techo"/>Techo
	  <input type="radio" name="role" value="ba"/>BA
	  <input type="radio" name="role" value="teamleader"/>Teamleader
	  <input type="radio" name="role" value="designer"/>Designer
	  <input type="radio" name="role" value="other"/>Other'.$reqAsterix.'</td></tr>';
echo ' <tr><td class="tableHeaderTd">Email</td><td><input name="emailAddress" type="text" size="40"></td></tr>';
echo ' <tr><td class="tableHeaderTd">Area Code</td><td><input name="areaCode" type="text"></td></tr>';
echo ' <tr><td class="tableHeaderTd">Phone Number</td><td><input name="phoneNumber" type="text"></td></tr>';
echo '</table>';

echo $reqKey;

echo '<input type="submit" value="Submit"/>';


require_once 'req_bottom.php';	


?>
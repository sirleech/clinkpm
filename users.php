<?php
session_start();
//require_once 'req_authorise.php';
require_once 'req_constants.php';

require_once 'req_topNav.php';
echo '|  <span class="breadcrumb">Staff List </span>';
require_once 'req_messages.php';
echo '<br/><span class="secondLevelNav"><a class="noline" href="addUser.php">Add A User</a></span>';

echo '<h1>Staff List</h1>';		

function printTeamList($team) {
	require_once 'req_connect.php';
	$query = 'SELECT * FROM users WHERE team=\''.$team.'\' order by role';
	$result = mysql_query($query) or die('Query failed : ' . mysql_error());

	echo '<h3>'.$team.'</h3>';
	echo '<table border="1">
			<tr>
				<td class="tableHeaderTd">Staff Member</td>
				<td class="tableHeaderTd">Logon Id</td>
				<td class="tableHeaderTd">Role</td>
			</tr>';
	while ($row = mysql_fetch_assoc($result)) {
		$fullname = $row['first_name'].' '.$row['sur_name'];
		$username = $row['user_name'];
		echo '<tr>';
		echo '<td><a href="user.php?username='.$username.'">'.$fullname.'</a></td> ';
		echo '<td>'.$username.'</td>';
		echo '<td>'.$row['role'].'</td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<table>
        <tr>
		  <td valign=top>';printTeamList('fc1');echo '</td>';
echo '    <td valign=top>';printTeamList('fc3');echo '</td>';
echo '    <td valign=top>';printTeamList('fc4');echo '</td>';
echo '    <td valign=top>';printTeamList('mgt');echo '</td>';
echo '  </tr>
      </table>';		  


?>

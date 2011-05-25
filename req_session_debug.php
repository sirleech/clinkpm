<?php

//Show session variables on the top of the screen

$debug = false;
$user = '';

if (isset($_SESSION['user'])) {
	$user = $_SESSION['user'];
}

if ($debug) {

echo '<table><tr><td bgcolor=green><font color=white>';
echo '<b>SESSION VARS: </b>';
echo 'user='.$_SESSION['user'].' | ';
echo 'team='.$_SESSION['team'].' | ';
echo 'year='.$_SESSION['year'].' | ';
echo 'selectedUser='.$_SESSION['selectedUser'].' | ';
echo '</font></td></tr></table>';

}
?>
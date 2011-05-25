<?php
session_start();
require_once 'req_authorise.php';	
require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_functions.php';
require_once('classes/tc_calendar.php');

require_once 'req_topNav.php';	
echo '| <span class="breadcrumb"><a href="leaveCalendar.php">Leave Calendar ></a> Enter Leave Plan</span>';
require_once 'req_messages.php';

$user = $_SESSION['user'];

echo '<h1>Enter Leave Plan</h1>
      <form action="enterLeaveAction.php" method="post" name="form1">
      <p>User name <input type="text" name="username" value="'.$user.'"/>'.$reqAsterix.'</p>';


echo '<h4>Leave type?'.$reqAsterix.'</h4>';
echo '<input type="radio" name="leaveType" value="rec" checked/>Recreation<br/>
	  <input type="radio" name="leaveType" value="training" />Training <br/>
	  <input type="radio" name="leaveType" value="maternity" />Maternity';

echo '<h4>Is this an estimate?'.$reqAsterix.'</h4>';
echo '<input type="radio" name="estimate" value="0" checked/>No<br/>
	  <input type="radio" name="estimate" value="1" />Yes';	  

echo '<table><tr>';

echo '<h4>Leave Dates?'.$reqAsterix.'</h4>';
echo '<td>Start Date';

//instantiate class and set properties
$myCalendar = new tc_calendar("date1", true);
$myCalendar->setIcon("images/iconCalendar.gif");
$myCalendar->setDate(1, 1, 2011);

//output the calendar
$myCalendar->writeScript();	  

echo '</td><td>End Date';
//instantiate class and set properties
$myCalendar2 = new tc_calendar("date2", true);
$myCalendar2->setIcon("images/iconCalendar.gif");
$myCalendar2->setDate(1, 1, 2011);

//output the calendar
$myCalendar2->writeScript();	 

echo '</td></tr></table>';

echo $reqKey;

?>

<input type="submit" value="Enter Leave Plan"/>
</form>

<?php require_once 'req_bottom.php';	?>
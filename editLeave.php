<?php
session_start();
//require_once 'req_authorise.php';	
require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_functions.php';
require_once('classes/LeavePlanDto.php');
require_once('classes/tc_calendar.php');

require_once 'req_topNav.php';	
echo '| <span class="breadcrumb"><a href="leaveCalendar.php">Leave Calendar ></a> Edit Leave Plan</span>';
require_once 'req_messages.php';

if (isset($_GET["leaveId"])){
	$leaveId = htmlspecialchars($_GET["leaveId"]);
}

// query to retrieve the leave for $leaveId
$query = 'select * from '.LEAVE_PLAN_TABLE.' where leave_id = \''.$leaveId.'\'';
$result = mysql_query($query) or die('Query failed : ' . mysql_error());

while ($row = mysql_fetch_assoc($result)) {
	$leavePlan = new LeavePlanDto();
	$leavePlan->leaveId = $row['leave_id'];
	$leavePlan->userName = $row['user_name'];
	$leavePlan->startDate = $row['start_date'];
	$leavePlan->endDate = $row['end_date'];
	$leavePlan->leaveType = $row['leave_type'];
	if ($row['estimate']){
		$leavePlan->estimate = 'Yes';
	} else {
		$leavePlan->estimate = 'No';
	}
}

$startDate = new DateTime($leavePlan->startDate);
$endDate = new DateTime($leavePlan->endDate);


echo '<h1>Edit Leave Plan</h1>';
echo '<form action="editLeaveAction.php" method="post" name="editLeaveForm">';
echo '<input type="text" class="formHidden" name="leaveId" value="'.$leaveId.'">';

echo '<font size=4>';
echo '<b>Staff Member:</b> '.getUserFullName($leavePlan->userName).'<br>';
echo '<b>Leave Plan:</b> '.$startDate->format('D d M, Y').' to '.$endDate->format('D d M, Y').'<br>';
echo '<b>Leave Type:</b> '.$leavePlan->leaveType.'<br>';
echo '<b>Estimate?:</b> '.$leavePlan->estimate.'<br>';
echo '<b>Leave Duration: </b>'.$leavePlan->leaveDaysCount().' days';
echo '</font>';

echo '<h3>Enter New Leave Plan Details:</h3>';

//pre populate the leave radio buttons
$recChecked = '';
$trainingChecked = '';
$maternityChecked = '';
$noChecked = '';
$yesChecked = '';

switch ($leavePlan->leaveType) {
case 'rec':
	$recChecked = 'checked';
	break;
case 'training':
	$trainingChecked = 'checked';
	break;
case 'maternity':
	$maternityChecked = 'checked';
	break;	
}

switch ($leavePlan->estimate) {
case 'Yes':
	$yesChecked = 'checked';
	break;
case 'No':
	$noChecked = 'checked';
	break;
}

echo '<h4>Leave Type?</h4>';
echo '<input type="radio" name="leaveType" value="rec" '.$recChecked.'/>Recreation<br/>
	  <input type="radio" name="leaveType" value="training" '.$trainingChecked.'/>Training <br/>
	  <input type="radio" name="leaveType" value="maternity" '.$maternityChecked.'/>Maternity';

echo '<h4>Is this an estimate?</h4>';
echo '<input type="radio" name="estimate" value="0" '.$noChecked.'/>No<br/>
	  <input type="radio" name="estimate" value="1" '.$yesChecked.'/>Yes';	  	  
	  
echo '<table><tr>';

echo '<h4>Leave Dates?</h4>';
echo '<td>Start Date';

//instantiate class and set properties

$myCalendar = new tc_calendar("date1", true);
$myCalendar->setIcon("images/iconCalendar.gif");
$myCalendar->setDate($startDate->format('d'), $startDate->format('m'),$startDate->format('Y'));

//output the calendar
$myCalendar->writeScript();	  

echo '</td><td>End Date';
//instantiate class and set properties
$myCalendar2 = new tc_calendar("date2", true);
$myCalendar2->setIcon("images/iconCalendar.gif");
$myCalendar2->setDate($endDate->format('d'), $endDate->format('m'),$endDate->format('Y'));

//output the calendar
$myCalendar2->writeScript();	 

echo '</td></tr></table>';

echo '<input type="submit" value="Submit"/>
	  </form>';
	  
echo '<h3><a href="deleteConfirm.php?action=deleteLeaveAction&id='.$leaveId.'">Delete Leave Plan</a></h3>';	  

require_once 'req_bottom.php';	
?>
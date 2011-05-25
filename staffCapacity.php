<?php
session_start();
require_once 'req_topNav.php';	
require_once 'req_messages.php';
require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_functions.php';
require_once 'classes/LeavePlanDto.php';
require_once 'classes/StaffLeavePlanDto.php';

if (isset($_GET["release"])){$releaseId = htmlspecialchars($_GET["release"]);}
$team = 'all';
if (isset($_GET["team"])){	$team = htmlspecialchars($_GET["team"]);}

$query = 'SELECT * from '.RELEASES_TABLE.' WHERE release_id = \''.$releaseId.'\'';
$result = mysql_query($query) or die('Query failed : ' . mysql_error());
while ($row = mysql_fetch_assoc($result)) {
	$releaseLetter = $row['letter'];
	$releaseStartDate = new DateTime($row['start_date']);
	$releaseEndDate = new DateTime($row['end_date']);
}

echo '<h1>Staff Capacity: '.$releaseEndDate->format('d M, Y').' ('.$releaseLetter.')-'.$team.'</h1>';
$workingDays = countWorkingDays($releaseStartDate,$releaseEndDate);
$weeks = $workingDays/5.0;

//Release duration (weeks) = All working days/5
echo 'Release Duration: '.$workingDays.' working days/5 = '.$weeks.' working weeks. *';

//--------------------------------------------
//Get all Ba's to make a table
//--------------------------------------------

echo '<h2>BA Capacity</h2>';
$query = 'select * from '.USER_TABLE.' WHERE team = \''.$team.'\' AND role=\'ba\' order by first_name';

$staffResult = mysql_query($query) or die('Query failed : ' . mysql_error());


echo '<table border="1">
		<tr>
			<td class="tableHeaderTd">Staff Member</td>
			<td class="tableHeaderTd">Leave (days)*</td>
			<td class="tableHeaderTd">Leave (weeks)</td>
			<td class="tableHeaderTd">Net Capacity (weeks)</td>
		</tr>';

$totalNetCapacity = 0;		
while ($row = mysql_fetch_assoc($staffResult)) {
	$fullname = $row['first_name'].' '.$row['sur_name'];
	$userName = $row['user_name'];
	$leaveDaysCount = getDaysLeave($userName,$releaseStartDate->format('Y-m-d'),$releaseEndDate->format('Y-m-d'));

    $leaveWeeks	= $leaveDaysCount/5;
	$netCapacityWeeks = ($workingDays - $leaveDaysCount)/5;
	$totalNetCapacity = $totalNetCapacity + $netCapacityWeeks;
	echo '<tr>
			<td>'
			.$fullname.
	       '</td>  
		   <td>'
		     .$leaveDaysCount.
		   '</td>
		   <td>'
		     .$leaveWeeks.
		   '</td>		   
		   <td>'
		     .$netCapacityWeeks.
		   '</td>			   	   
		  </tr>';
} 

echo '</table>';
echo '<h3>Total Net Capacity: '.$totalNetCapacity.' weeks</h3>';

//--------------------------------------------
//Get all Techs's to make a table
//--------------------------------------------

echo '<h2>Technical Capacity</h2>';
$query = 'select * from '.USER_TABLE.' WHERE team = \''.$team.'\' AND role=\'techo\' order by first_name';

$staffResult = mysql_query($query) or die('Query failed : ' . mysql_error());


echo '<table border="1">
		<tr>
			<td class="tableHeaderTd">Staff Member</td>
			<td class="tableHeaderTd">Leave (days)*</td>
			<td class="tableHeaderTd">Leave (weeks)</td>
			<td class="tableHeaderTd">Net Capacity (weeks)</td>
		</tr>';

$totalNetCapacity = 0;		
while ($row = mysql_fetch_assoc($staffResult)) {
	$fullname = $row['first_name'].' '.$row['sur_name'];
	$userName = $row['user_name'];
	$leaveDaysCount = getDaysLeave($userName,$releaseStartDate->format('Y-m-d'),$releaseEndDate->format('Y-m-d'));

    $leaveWeeks	= $leaveDaysCount/5;
	$netCapacityWeeks = ($workingDays - $leaveDaysCount)/5;
	$totalNetCapacity = $totalNetCapacity + $netCapacityWeeks;
	echo '<tr>
			<td>'
			.$fullname.
	       '</td>   
		   <td>'
		     .$leaveDaysCount.
		   '</td>
		   <td>'
		     .$leaveWeeks.
		   '</td>		   
		   <td>'
		     .$netCapacityWeeks.
		   '</td>			   	   
		  </tr>';
} 

echo '</table>';
echo '<h3>Total Net Capacity: '.$totalNetCapacity.' weeks</h3>';

//--------------------------------------------
//Get all Teamleads's to make a table
//--------------------------------------------

echo '<h2>Teamleader Capacity</h2>';
$query = 'select * from '.USER_TABLE.' WHERE team = \''.$team.'\' AND role=\'teamleader\' order by first_name';

$staffResult = mysql_query($query) or die('Query failed : ' . mysql_error());


echo '<table border="1">
		<tr>
			<td class="tableHeaderTd">Staff Member</td>
			<td class="tableHeaderTd">Leave (days)*</td>
			<td class="tableHeaderTd">Leave (weeks)</td>
			<td class="tableHeaderTd">Net Capacity (weeks)</td>
		</tr>';

$totalNetCapacity = 0;		
while ($row = mysql_fetch_assoc($staffResult)) {
	$fullname = $row['first_name'].' '.$row['sur_name'];
	$userName = $row['user_name'];
	$leaveDaysCount = getDaysLeave($userName,$releaseStartDate->format('Y-m-d'),$releaseEndDate->format('Y-m-d'));

    $leaveWeeks	= $leaveDaysCount/5;
	$netCapacityWeeks = ($workingDays - $leaveDaysCount)/5;
	$totalNetCapacity = $totalNetCapacity + $netCapacityWeeks;
	echo '<tr>
			<td>'
			.$fullname.
	       '</td>   
		   <td>'
		     .$leaveDaysCount.
		   '</td>
		   <td>'
		     .$leaveWeeks.
		   '</td>		   
		   <td>'
		     .$netCapacityWeeks.
		   '</td>			   	   
		  </tr>';
} 

echo '</table>';
echo '<h3>Total Net Capacity: '.$totalNetCapacity.' weeks</h3>';

echo '<small>*Not including weekends or public holidays.</small>';




?>
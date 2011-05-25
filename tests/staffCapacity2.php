<?php
session_start();
require_once 'req_topNav.php';	
require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_functions.php';
require_once 'classes/LeavePlanDto.php';
require_once 'classes/StaffLeavePlanDto.php';

$releaseId = '3';

if (isset($_GET["release"])){
	$releaseId = htmlspecialchars($_GET["release"]);
}

$query = 'SELECT * from '.RELEASES_TABLE.' WHERE release_id = \''.$releaseId.'\'';
$result = mysql_query($query) or die('Query failed : ' . mysql_error());
while ($row = mysql_fetch_assoc($result)) {
	$releaseLetter = $row['letter'];
	$startDate = $row['start_date'];
	$releaseStartDate = new DateTime($startDate);
	$releaseEndDate = new DateTime($row['end_date']);
}

$interval = $releaseEndDate->diff($releaseStartDate);
$duration = $interval->format('%m months %d days');


echo '<h1>Staff Capacity: '.$releaseEndDate->format('Y-m-d').' ('.$releaseLetter.')</h1>';
$days = countWorkingDays($releaseStartDate,$releaseEndDate);
									 
echo '$releaseStartDate: ';echo DateTimeToMysql($releaseStartDate);		
echo '<br>';							 
echo '$releaseEndDate: ';echo DateTimeToMysql($releaseEndDate);


//2)
// foreach(day in the release period)
    //if (that day is leave){
	//   Increment the $StaffLeavePlanDto->daysLeave for each day that is leave
    //}

echo '<table border="1">
		<tr>
			<td class="tableHeaderTd">Staff Member</td>
		</tr>';

//$result = getLeavePlans($start_date,$end_date);	

echo '</table>';




?>
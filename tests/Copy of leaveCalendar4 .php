<?php
session_start();

require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_functions.php';
require_once 'classes/LeavePlanDto.php';
require_once 'classes/StaffLeavePlanDto.php';

require_once 'req_topNav.php';	
echo '|  <span class="breadcrumb">Leave Calendar > <a href="enterLeave.php">Enter Leave Plan</a></span>';
require_once 'req_messages.php';

$year = '2011';

if (isset($_GET["year"])){
	$year = htmlspecialchars($_GET["year"]);
}

//echo getUserFullName('clv219');
echo '<h1>'.$year.' Leave Roster</h1>';

//For each $month (1-12)
for ($month = 1; $month <= 12; $month++) {
	
	// all leave plans that fall within the month
	$leavePlans = array();
	
	// a array of staff and their leave plans(a staff member can have 0..m leave plans that fall in one month)
	$staffLeavePlans = array();
	
	echo '<h3>'.$month.'/'.$year.'</h3>';
	$daysCount = cal_days_in_month(CAL_JULIAN, $month, $year);
	$monthStartDate = $year.'-'.$month.'-'.'1';
	$monthEndDate   = $year.'-'.$month.'-'.$daysCount;

	//Select all leave plans within the current $month
	$leavePlansInThisMonth = getLeavePlansDateRange($monthStartDate,$monthEndDate);
	
	echo '<table border="1" class="leaveCalendarTable">';
	echo '<tr>';
	echo '<td class="leaveCalendarDayNameTd">Staff Member</td>';
	
	//For each $day of the month
	for ($day = 1; $day <= $daysCount; $day++) {
		$dayOfWeek = englishDayFromDate($year,$month,$day,'1');		
		echo '<td>
		       <table>
			     <tr>
				    <td class="leaveCalendarDayNameTd">'.$dayOfWeek.'</td>
				 </tr>
			     <tr>
				    <td class="leaveCalendarDayNumberTd">'.$day.'</td>
				 </tr>
			   </table>
			  </td>';
	}
	echo '</tr>';
	
	//BUG: two leave plans for one staff during the same month results in two rows-- consolidate the plans into one table row.
	
	//For each leave plan falls in the current month put it into an array of leavePlanDto
	while ($row = mysql_fetch_assoc($leavePlansInThisMonth)) {
		$leavePlan = new LeavePlanDto();
		$leavePlan->userName = $row['user_name'];
		$leavePlan->startDate = $row['start_date'];
		$leavePlan->endDate = $row['end_date'];
		array_push($leavePlans,$leavePlan);
		$staffLeavePlans[$row['user_name']] = new StaffLeavePlanDto();
	}
	
	// For each staff member accumulate leave plans that belong to them	
	foreach($staffLeavePlans as $i => $value)
	{
		foreach($leavePlans as $j => $value)
		{			
			if ($i == $leavePlans[$j]->userName) {
				array_push($staffLeavePlans[$i]->leavePlans,$leavePlans[$j]);
			}
		}
	}
	
	foreach($leavePlans as $i => $value){
		$staffName = getUserFullName($leavePlans[$i]->userName);
		//$leaveStartDate = $leavePlans[$i]->startDate;
		//$leaveEndDate = $leavePlans[$i]->endDate;
		echo '<tr><td class="leaveCalendarStaffNameTd">'.$staffName.'</td>';
		
		//for each day of the month 
		for ($day = 1; $day <= $daysCount; $day++) 
		{
			$dayOfWeek = englishDayFromDate($year,$month,$day,'1');		
			
			echo '<td align="center"';
			//check if this day is within the Staff's leave end and start date'
			$date = $year.'-'.$month.'-'.$day;
			$holiday = isDatePublicHoliday($date);
			$inRange = $leavePlans[$i]->isThisDayLeave($date);
			if ($dayOfWeek == 'Sat' || $dayOfWeek == 'Sun'){
				$isWeekend = TRUE;
			} else {
				$isWeekend = FALSE;
			}
			if ($isWeekend) {
				echo ' bgcolor="gray">';
			} elseif ($holiday) {
				echo ' bgcolor="yellow" class="leaveCalendarPhTd">PH';
			} else {
				if ($inRange){
					echo ' class="leaveCalendarCrossTd">X';
				} else {
					echo '>&nbsp;';
				}
			}			
			echo '</td>';
		}
		echo '</tr>';
	}	
	echo '</table>';
}

require_once 'req_bottom.php';	
//require 'req_freeAndDisconnect.php';
?>
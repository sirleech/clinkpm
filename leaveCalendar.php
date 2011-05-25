<?php
session_start();

//TODO: replace with the current year, not hard code
$year = '2011';
if (isset($_GET["year"])){$year = htmlspecialchars($_GET["year"]);}
$team = 'all';
if (isset($_GET["team"])){	$team = htmlspecialchars($_GET["team"]);}

// set the session Team and Year variables
$_SESSION['year'] = $year;
$_SESSION['team'] = $team;		

require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_functions.php';
require_once 'classes/LeavePlanDto.php';
require_once 'classes/StaffLeavePlanDto.php';

require_once 'req_topNav.php';	
echo '|  <span class="breadcrumb">Leave Calendar </span>';
require_once 'req_messages.php';

echo '<br><span class="secondLevelNav"><a class="noline" href="enterLeave.php">Enter Leave Plan</a></span>';

echo '<h1>'.$year.' Leave Calendar- '.$team.'</h1>';

//For each $month (1-12)
for ($month = 1; $month <= 12; $month++) 
{
	echo '<h3>'.getMonthName($month).' '.$year.'</h3>';
	$daysCount = cal_days_in_month(CAL_JULIAN, $month, $year);
	$monthStartDate = $year.'-'.$month.'-'.'1';
	$monthEndDate   = $year.'-'.$month.'-'.$daysCount;
	
	echo '<table border="0" class="clinkTable">';
	echo '<tr>';
	echo '<td class="leaveCalendarDayNameTd">Staff Member</td>';
	
	//For each $day of the month
	for ($day = 1; $day <= $daysCount; $day++) {
	    $date = $year.'-'.$month.'-'.$day;	
		$dayOfWeek = getDayName($year,$month,$day,'1');		
		$td_atts = '';
		// TODO: replace this with isTodayRelease($date) function
		//       that queries the "releases" table for a major release
		if ($date == '2011-3-5' || $date == '2011-6-18'){ 
			$td_atts = 'bgcolor="orange"'; 
		}
		echo '<td '.$td_atts.' >
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
	
	// an array of StaffLeavePlanDto's indexed by user name
	$staffLeavePlans = getTeamLeavePlans($monthStartDate,$monthEndDate,$team);
	
	foreach($staffLeavePlans as $i => $value){
		$staffName = getUserFullName($i);
		echo '<tr><td class="leaveCalendarStaffNameTd">'.$staffName.'</td>';
	
		//for each day of the month 
		for ($day = 1; $day <= $daysCount; $day++) 
		{	

			$date = $year.'-'.$month.'-'.$day;			
			$DateTime = new DateTime($date);	
			$isHoliday = isDatePublicHoliday($DateTime);			
			$isWeekend = isDateWeekend($DateTime);
			$td_atts = ''; $td_content = '';$td_content2 = '';
			$staffLeavePlan = $staffLeavePlans[$i];
			
			if ($isWeekend) {
				$td_atts = ' bgcolor="gray"';
			} elseif ($isHoliday) {
				$td_atts = ' bgcolor="yellow" class="leaveCalendarPhTd"';
				$td_content = 'PH';
			} elseif ($staffLeavePlan->isThisDayLeave($date)){
				$leaveId = $staffLeavePlan->getLeaveIdForDay($date);
				$td_atts = 'class="leaveCalendarCrossTd"';
				if ($staffLeavePlan->isThisDayEstimate($date)){
					$td_content2 = 'e';
				} 
				$td_content = '<a class="leaveLink" href="editLeave.php?leaveId='.$leaveId.'">X</a>';
			} else {
				$td_content = '&nbsp;';
			}
			
			echo '<td align="center" '.$td_atts.'>'.$td_content.$td_content2.'</td>';
			
			
			
			echo '</td>';
		}
		echo '</tr>';
	}	
	echo '</table>';
}

require_once 'req_bottom.php';	
//require 'req_freeAndDisconnect.php';
?>
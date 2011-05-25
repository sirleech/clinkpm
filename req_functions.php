<?php
require_once 'req_connect.php';
require_once 'req_constants.php';

//*************************************
// TO DO:
//*************************************

// x) Major release indicators on Leave Calendar

//=============================================================
//
// Leave Plan Functions
//
//=============================================================

// Get a staff's days of leave for a given period
// returns: INT number in days that  staff member is on leave (not including weekends & holidays)
function getDaysLeave($user_name,$start_date,$end_date)
{
	$daysLeave = 0;
	$result = getLeavePlansForUser($user_name,$start_date,$end_date);
	
	//For each leave plan falls in period add it to $leavePlan array 
	$staffLeavePlanDto = new StaffLeavePlanDto();
	$staffLeavePlanDto->leavePlans = array();
	
	while ($row = mysql_fetch_assoc($result)) {
		$leavePlan = new LeavePlanDto();
		$leavePlan->leaveId = $row['leave_id'];
		$leavePlan->userName = $row['user_name'];
		$leavePlan->startDate = $row['start_date'];
		$leavePlan->endDate = $row['end_date'];
		array_push($staffLeavePlanDto->leavePlans,$leavePlan);
	}
	
	//count the leaveDays in StaffLeavePlanDto (logic from staffCapacity.php)
	$iDate = new DateTime($start_date);
	$leaveDaysCount = '0';
	$endDate = new DateTime($end_date);
	// Count the leave days in the StaffLeavePlanDto
	while($iDate <= $endDate)
	{
		//add one day
		if ($staffLeavePlanDto->IsThisDayLeave($iDate->format('Y-m-d'))){
			$leaveDaysCount++;
		}
		$iDate->add(new DateInterval('P1D'));
	}	
	
	return $leaveDaysCount;
}

// Get a team's leave plans for a given period
// returns: an array of StaffLeavePlanDto's indexed by user_name
// team:[fc1,fc3,fc4,all]
function getTeamLeavePlans($start_date,$end_date,$team)
{
	// all leave plans that fall within the month
	$leavePlans = array();
	
	// a array of staff and their leave plans(a staff member can have 0..m leave plans that fall in one month)
	// indexed by username
	$staffLeavePlans = array();
	
	//Select all leave plans within period
	$result = getAllLeavePlans($start_date,$end_date,$team);	
	
	//For each leave plan falls in period add it to $leavePlan array and initialise the $staffLeavePlans array
	while ($row = mysql_fetch_assoc($result)) {
		$leavePlan = new LeavePlanDto();
		$leavePlan->leaveId = $row['leave_id'];
		$leavePlan->userName = $row['user_name'];
		$leavePlan->startDate = $row['start_date'];
		$leavePlan->endDate = $row['end_date'];
		$leavePlan->estimate = $row['estimate'];
		
		array_push($leavePlans,$leavePlan);
		//initialise staffLeavePlans array 
		$userName = $row['user_name'];
		$staffLeavePlans[$userName] = new StaffLeavePlanDto();
		$staffLeavePlans[$userName]->userName = $userName;
	}
	
	// For each staff member accumulate leave plans that belong to them
	// (consolidate multiple leave plans for one user into the single StaffLeavePlanDto)
	foreach($staffLeavePlans as $i => $value)
	{
		foreach($leavePlans as $j => $value)
		{			
			if ($i == $leavePlans[$j]->userName) {
				array_push($staffLeavePlans[$i]->leavePlans,$leavePlans[$j]);
			}
		}
	}
	
	return $staffLeavePlans;
}

// Return all leave plans that fall within a given date range for a given user
// returns: a mysql result from leave_plans table
function getLeavePlansForUser($user_name,$start_date,$end_date)
{
	$query = '
			 SELECT leave_plans.leave_id,leave_plans.user_name,leave_plans.start_date,leave_plans.end_date,leave_plans.leave_type,leave_plans.estimate
			 FROM leave_plans INNER JOIN users
			 ON leave_plans.user_name = users.user_name
			 WHERE
			(
				(leave_plans.start_date >= \''.$start_date.'\' AND leave_plans.start_date <=  \''.$end_date.'\')
				AND
				(leave_plans.end_date >=\''.$start_date.'\' AND leave_plans.end_date <= \''.$end_date.'\')
				AND
				(users.user_name = \''.$user_name.'\')
			) OR
			(
				(leave_plans.start_date < \''.$start_date.'\')
				AND
				(leave_plans.end_date >= \''.$start_date.'\' AND leave_plans.end_date <= \''.$end_date.'\')
				AND
				(users.user_name = \''.$user_name.'\')
			) OR
				(
				(leave_plans.start_date >= \''.$start_date.'\' AND leave_plans.start_date <= \''.$end_date.'\')
				AND
				(leave_plans.end_date > \''.$end_date.'\')
				AND
				(users.user_name = \''.$user_name.'\')
			) OR
			(
				(leave_plans.start_date < \''.$start_date.'\' AND leave_plans.end_date > \''.$end_date.'\')
				AND
				(users.user_name = \''.$user_name.'\')
			)			
			';
    $result = mysql_query($query) or die('Query failed : ' . mysql_error());
	return $result;
}

//Return all leave plans that fall within a given date range
//date format YYYY-MM-DD
//returns: a mysql result from leave_plans table
// team:[fc1,fc3,fc4,all]

function getAllLeavePlans($start_date,$end_date,$team)
{
	// the entire section, all teams
	if ($team == 'all') {
		//qry001
		$query = '
				SELECT leave_plans.leave_id,leave_plans.user_name,leave_plans.start_date,leave_plans.end_date,leave_plans.leave_type,leave_plans.estimate 
				FROM leave_plans INNER JOIN users
				ON leave_plans.user_name = users.user_name
				WHERE
				(
					(start_date >= \''.$start_date.'\' AND start_date <=  \''.$end_date.'\')
					AND
					(end_date >=\''.$start_date.'\' AND end_date <= \''.$end_date.'\')
				) OR
				(
					(start_date < \''.$start_date.'\')
					AND
					(end_date >= \''.$start_date.'\' AND end_date <= \''.$end_date.'\')
				) OR
				(
					(start_date >= \''.$start_date.'\' AND start_date <= \''.$end_date.'\')
					AND
					(end_date > \''.$end_date.'\')
				) OR
				(
					start_date < \''.$start_date.'\' AND end_date > \''.$end_date.'\'
				)
				order by users.first_name
				';	

    } else {
		// qry002- filter by FCX team
		$query = '
				 SELECT leave_plans.leave_id,leave_plans.user_name,leave_plans.start_date,leave_plans.end_date,leave_plans.leave_type,leave_plans.estimate
		         FROM leave_plans INNER JOIN users
				 ON leave_plans.user_name = users.user_name
				 WHERE
				(
					(leave_plans.start_date >= \''.$start_date.'\' AND leave_plans.start_date <=  \''.$end_date.'\')
					AND
					(leave_plans.end_date >=\''.$start_date.'\' AND leave_plans.end_date <= \''.$end_date.'\')
					AND
					(users.team = \''.$team.'\')
				) OR
				(
					(leave_plans.start_date < \''.$start_date.'\')
					AND
					(leave_plans.end_date >= \''.$start_date.'\' AND leave_plans.end_date <= \''.$end_date.'\')
					AND
					(users.team = \''.$team.'\')
				) OR
					(
					(leave_plans.start_date >= \''.$start_date.'\' AND leave_plans.start_date <= \''.$end_date.'\')
					AND
					(leave_plans.end_date > \''.$end_date.'\')
					AND
					(users.team = \''.$team.'\')
				) OR
				(
					(leave_plans.start_date < \''.$start_date.'\' AND leave_plans.end_date > \''.$end_date.'\')
					AND
					(users.team = \''.$team.'\')
				)
				order by users.first_name
				';
	}
	
    $result = mysql_query($query) or die('Query failed : ' . mysql_error());
	return $result;
}

//=============================================================
//
// Date Functions
//
//=============================================================

//Check if date is within a date range date format YYYY-MM-DD
function check_in_range($start_date, $end_date, $date_from_user)
{
  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $user_ts = strtotime($date_from_user);

  // Check that user date is between start & end
  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

//get the english day name e.g. "Monday" date format 2011-12-25

function getDayName($year,$month,$day,$mode)
{
	$julianDayCount = cal_to_jd(CAL_JULIAN,$month,$day,$year); 
	$dayOfWeek = jddayofweek($julianDayCount + 1,2);
	return $dayOfWeek;
}

function getMonthName($monthNumber)
{
	switch ($monthNumber) {
    case 1:
        $monthStr = 'January';
        break;
    case 2:
        $monthStr = 'February';
        break;
    case 3:
        $monthStr = 'March';
        break;
    case 4:
        $monthStr = 'April';
        break;
    case 5:
        $monthStr = 'May';
        break;
    case 6:
        $monthStr = 'June';
        break;
    case 7:
        $monthStr = 'July';
        break;
    case 8:
        $monthStr = 'August';
        break;
    case 9:
        $monthStr = 'September';
        break;
    case 10:
        $monthStr = 'October';
        break;
    case 11:
        $monthStr = 'November';
        break;		
    case 12:
        $monthStr = 'December';
        break;		
	}
	return $monthStr;
}

function isDateWeekend($DateTime)
{
	$year = $DateTime->format('Y');
	$month = $DateTime->format('m');
	$day = $DateTime->format('d');
	$dayOfWeek = getDayName($year,$month,$day,'1');		
	if ($dayOfWeek == 'Sat' || $dayOfWeek == 'Sun'){
		return TRUE;
	} else {
		return FALSE;
	}	
}

function isDatePublicHoliday($DateTime)
{
	$date = DateTimeToMysql($DateTime);
	$holiday = FALSE;
	$query = 'SELECT * from '.PUBLIC_HOLIDAYS_TABLE.' WHERE date = \''.$date.'\'';
	$result = mysql_query($query) or die('Query failed : ' . mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		//return $row['first_name'].' '.$row['sur_name'];
		$holiday = TRUE;
	}
	return $holiday;
}

function DateTimeToMysql($DateTime)
{
	$year = $DateTime->format('Y');
	$month = $DateTime->format('m');
	$day = $DateTime->format('d');
	$dash = '-';
	return $year.$dash.$month.$dash.$day;
}

// $startDate is DateTime
// $endDate is DateTime

function countDays($startDateTime,$endDateTime)
{
	$iDate = $startDateTime;
	$daysCount = 0;
	while($iDate <= $endDateTime)
	{
		$daysCount++;
		// add one day
		$iDate->add(new DateInterval('P1D'));
	}
	return $daysCount;
}

function countWorkingDays($startDateTime,$endDateTime)
{
	$iDate = new DateTime($startDateTime->format('Y-m-d'));
	$daysCount = 0;
	while($iDate <= $endDateTime)
	{
		$isWeekend = isDateWeekend($iDate);
		$isHoliday = isDatePublicHoliday($iDate);
		if (!$isWeekend && !$isHoliday){	$daysCount++;}
		// add one day
		$iDate->add(new DateInterval('P1D'));
	}
	return $daysCount;
}

//=============================================================
//
// Other Functions
//
//=============================================================

function getUserFullName($userName)
{
	//require_once 'req_connect.php';
	$query = 'SELECT * from '.USER_TABLE.' WHERE user_name = \''.$userName.'\'';
	$result = mysql_query($query) or die('Query failed : ' . mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		return $row['first_name'].' '.$row['sur_name'];
	}
}

function getReleaseLetter($releaseId)
{
	//require_once 'req_connect.php';
	$query = 'SELECT * from '.RELEASES_TABLE.' WHERE release_id = \''.$releaseId.'\'';
	$result = mysql_query($query) or die('Query failed : ' . mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		return $row['letter'];
	}	
}

?>
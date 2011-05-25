<?php
	session_start();
	
	require_once 'req_topNav.php';
	require_once 'req_messages.php';

	echo '<hr/>';
	echo '<h1>June (6) 2011 Major Release</h1>';
	//echo '<h2>Release Tasks - 
	//      <a href="releaseTasks.php?release=4&team=fc1">FC1</a>
	//	  </h2>';
		  
	echo '<h2>Staff Capacity -
	      <a href="staffCapacity.php?release=4&team=fc1">FC1</a>
		  <a href="staffCapacity.php?release=4&team=fc3">FC3</a>
		  <a href="staffCapacity.php?release=4&team=fc4">FC4</a>
		  </h2>
		  <hr/>';		  
	
	echo '<h1>March (F) 2011 Major Release</h1>';
	echo '<h2>Staff Capacity -
	      <a href="staffCapacity.php?release=3&team=fc1">FC1</a>
		  <a href="staffCapacity.php?release=3&team=fc3">FC3</a>
		  <a href="staffCapacity.php?release=3&team=fc4">FC4</a>
		  </h2>
		  <hr/>';
		  
	echo '<h1>Leave Calendar 2011</h1>
		 <h2>
	     <a href="leaveCalendar.php?year=2011&team=fc1">FC1</a>
		 <a href="leaveCalendar.php?year=2011&team=fc3">FC3</a>
		 <a href="leaveCalendar.php?year=2011&team=fc4">FC4</a>
		 <a href="leaveCalendar.php?year=2011&team=mgt">Management</a>
		 <a href="leaveCalendar.php?year=2011&team=all">Section</a>
		 </h2>
		 <hr/>';

	echo '<h1>Staff Lists</h1>
		 <h2>
	     <a href="users.php">Section</a>
		 </h2>';		 
    
	// UNIT test
	 require_once 'req_constants.php';
	 require_once 'req_functions.php';
	 require_once 'classes/LeavePlanDto.php';
	 require_once 'classes/StaffLeavePlanDto.php';
	 // echo getDaysLeave('o78','2010-12-06','2011-03-05');
	// $result = getLeavePlansForUser('o78','2010-12-06','2011-03-05');
	// while ($row = mysql_fetch_assoc($result)) {
		// $leavePlan = new LeavePlanDto();
		// $leavePlan->leaveId = $row['leave_id'];
		// $leavePlan->userName = $row['user_name'];
		// $leavePlan->startDate = $row['start_date'];
		// $leavePlan->endDate = $row['end_date'];
		// echo $leavePlan->toString();
	// }
	// end unit test
	
?>


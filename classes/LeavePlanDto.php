<?php
require_once 'req_functions.php';

class LeavePlanDto
{
	public $leaveId = 0;
	public $userName = '';
	public $startDate = '';
	public $endDate = '';
	public $leaveType = '';
	public $estimate = FALSE;
	
	public function toString() {
		return $this->userName.','.$this->startDate.','.$this->endDate; 
	}
	
	public function leaveDaysCount() {
		$iDate = new DateTime($this->startDate);
		$leaveDaysCount = '0';
		$endDate = new DateTime($this->endDate);
		// Count the leave days in the StaffLeavePlanDto
		while($iDate <= $endDate)
		{
			//add one day
			if ($this->IsThisDayLeave($iDate->format('Y-m-d'))){
				$leaveDaysCount++;
			}
			$iDate->add(new DateInterval('P1D'));
		}	
		
		return $leaveDaysCount;
	}
	
	public function isThisDayLeave($date) 
	{
		$isLeave = check_in_range($this->startDate, $this->endDate, $date);
		$isWeekend = isDateWeekend(new DateTime($date));
		$isHoliday = isDatePublicHoliday(new DateTime($date));
		if ($isLeave && !$isWeekend && !$isHoliday){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function isThisDayEstimate($date) 
	{
		$isLeave = check_in_range($this->startDate, $this->endDate, $date);
		$isWeekend = isDateWeekend(new DateTime($date));
		$isHoliday = isDatePublicHoliday(new DateTime($date));
		if ($isLeave && !$isWeekend && !$isHoliday && $this->estimate){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

?>
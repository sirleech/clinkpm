<?php
	class StaffLeavePlanDto {
		
		// an array of LeavePlanDto 
		// a staff leave plan can contain multiple leave plans
		public $leavePlans = array();
		public $userName = '';
	
		public function isThisDayLeave($date) {
			$leaveDaysMatched = 0;
			foreach($this->leavePlans as $i => $value) {
				if ($this->leavePlans[$i]->isThisDayLeave($date)) {
					$leaveDaysMatched ++;
				}
			}
			if ($leaveDaysMatched > 0){
				return true;
			} else { 
				return false; 
			}
		}
		
		public function isThisDayEstimate($date) {
			$leaveDaysMatched = 0;
			foreach($this->leavePlans as $i => $value) {
				if ($this->leavePlans[$i]->isThisDayEstimate($date)) {
					$leaveDaysMatched ++;
				}
			}
			if ($leaveDaysMatched > 0){
				return true;
			} else { 
				return false; 
			}
		}		
		
		public function getLeaveIdForDay($date)	{
			foreach($this->leavePlans as $i => $value) 
			{
				if ($this->leavePlans[$i]->isThisDayLeave($date)){
					$leaveId = $this->leavePlans[$i]->leaveId;
				}
			}
			return $leaveId;
		}
	}
?>
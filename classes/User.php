<?php

class User {

	public $userName = '';
	public $firstName = '';
	public $surName = '';
	public $team = '';
	public $role = '';
	public $emailAddress = '';
	public $phoneNumber = '';
	public $areaCode = '';
	
	function User($userName) {
		$this->userName = $userName;
		require_once ('req_connect.php');
		$query = 'SELECT * FROM users WHERE user_name=\''.$userName.'\'';
		$result = mysql_query($query) or die('Query failed : ' . mysql_error());
		
		while ($row = mysql_fetch_assoc($result)) {
			$this->firstName = $row['first_name'];
			$this->surName = $row['sur_name'];
			$this->team = $row['team'];
			$this->role = $row['role'];
			$this->emailAddress = $row['email_address'];
			$this->phoneNumber = $row['phone_number'];
			$this->areaCode = $row['area_code'];
		}
	}
}

?>
<?php
	session_start();
	
	require_once 'req_topNav.php';
	require_once 'req_messages.php';

	if(isset($_SESSION['user']))
	{
		echo '<p>You Are Already Logged In.';	
	} else {

	  echo 
	  ' <form action="loginAction.php" method="post">
		  <p>Logon Id <input type="text" name="username" /></p>
		  <p>Password <input type="password" name="password" /></p>
		  <p><input type="submit" /></p>
	    </form>';			
	}
?>
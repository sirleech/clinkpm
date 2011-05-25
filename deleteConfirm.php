<?php

//Generic Deletion Confirmation screen
// deleteLeaveConfirm.php?action=deleteLeaveAction&id=23

session_start();

require_once 'req_authorise.php';
require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_topNav.php';	

$id = isset($_GET["id"]) ? $_GET["id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "";

$_SESSION['messageError'] = 'Are you sure want to delete the item? This action cannot be undone.';
require_once 'req_messages.php';

echo '<form action="'.$action.'.php" method="post"">';	  
echo '<input type="submit" value="Yes- Delete Item"/>';
echo '<input type="text" class="formHidden" name="id" value="'.$id.'">
	  </form>';

$prevUrl = htmlspecialchars($_SERVER['HTTP_REFERER']);	  
echo '<a href="'.$prevUrl.'"><h3>Cancel</h3></a>';	  
	  
		  
?> 
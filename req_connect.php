<?php
    /* Connect to database */
	
    $link = mysql_connect("localhost", "root", "")
        or die("Could not connect : " . mysql_error());
    
	//print "connect.php: Connected successfully to Mysql DB.<br/>";
    
	mysql_select_db("clinkpm") or die("Could not select database");
	
?>
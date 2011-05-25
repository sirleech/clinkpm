<?php	
	// Free the resources associated with the result set
	// This is done automatically at the end of the script
	mysql_free_result($result);
    /* Close connection */
    mysql_close($link);
	//print "freeAndDisconnect.php: Freed result and closed connection to mysql DB.<br/>";
?>	
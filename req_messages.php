<?php

//echo '<br/><br/>';
// Messages
if(isset($_SESSION['messageSuccess'])){
	echo '<table width="90%"><tr><td bgcolor=green><font color=white><h3>&nbsp;'.$_SESSION['messageSuccess'].'</h3></font></td></tr></table>';
	unset($_SESSION['messageSuccess']);
}
if(isset($_SESSION['messageError'])){
	echo '<table width="90%"><tr><td bgcolor=red><font color=white><h3>&nbsp; '.$_SESSION['messageError'].'</h3></font></td></tr></table>';
	unset($_SESSION['messageError']);
}
?>
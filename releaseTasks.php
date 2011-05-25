<?php

session_start();
require_once 'req_topNav.php';
require_once 'req_messages.php';
require_once 'req_connect.php';
require_once 'req_constants.php';
require_once 'req_functions.php';

if (isset($_GET["release"])){$releaseId = htmlspecialchars($_GET["release"]);}
$team = 'all';
if (isset($_GET["team"])){	$team = htmlspecialchars($_GET["team"]);}

$query = 'SELECT * from '.RELEASES_TABLE.' WHERE release_id = \''.$releaseId.'\'';
$result = mysql_query($query) or die('Query failed : ' . mysql_error());
while ($row = mysql_fetch_assoc($result)) {
	$releaseLetter = $row['letter'];
	$releaseStartDate = new DateTime($row['start_date']);
	$releaseEndDate = new DateTime($row['end_date']);
}

echo '<h1>Release Tasks: '.$releaseEndDate->format('d M, Y').' ('.$releaseLetter.')-'.$team.'</h1>';

?>
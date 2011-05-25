<?php
// Starting the session
session_start();


if(isset($_SESSION['user']))
    {
        // Code for Logged members

        // Identifying the user
        $user = $_SESSION['user'];
				
        echo "You are now logged in and can view Secret stuff";
        // Information for the user.
		echo "<br/><a href='logout.php'>Log Out</a>";
		
    }
else
    {
        // Code to show Guests
        echo "You are logged out and can only view Guest stuff";
    }
?>


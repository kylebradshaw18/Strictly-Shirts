<?php 
    /* This page logs the user out then sends them back to the sign in page*/

	// Start the session
	session_start();
	
	//Remove the session variable
	unset($_SESSION['personId']);
	
	//Go to the sign in page
	header('Location: signin.php');
?>
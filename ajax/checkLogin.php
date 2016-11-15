<?php
    /**
    * This page serves as the call from the password modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
	$returnValue = 0;
	if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])) {
		$returnValue = $_SESSION['personId'];
	}
    //return array
    echo json_encode($returnValue);
?>
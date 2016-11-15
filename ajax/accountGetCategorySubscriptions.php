<?php
    /**
    * This page serves as the call from the password modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call

    //Use this to link to the connections page for the database functions
    require_once('../Globals/connection.php');
    
    $results = $conn->query("SELECT DISTINCT `category` FROM `categories` ORDER BY `category`");
    
    while($row = $results->fetch_assoc()) {
        $returnValue[] = $row;
    }
    //return array
    echo json_encode($returnValue);
?>
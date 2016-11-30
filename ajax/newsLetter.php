<?php

    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call
    
    if(!empty($_POST)){ //Check that we are in a postback
        $email = trim($_POST['email']);
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        
        if(strlen($email) < 0){ array_push($returnValue, "Email can not be blank"); } else if(strlen($email) > 75){ array_push($returnValue, "Email is too long"); }
        
        //first update the quantity in the inventory table
        $results = $conn->query("SELECT * FROM `newsletter` WHERE `email` = '".$email."'");
        if(!$results){ //Something Went wrong on the update
            array_push($returnValue, "ERROR: Connection issue, Please call support");
        }
        if($results ->num_rows < 1 && count($returnValue) < 2){ 
            $results = $conn->query("INSERT INTO `newsletter` (`email`) VALUES ('".$email."')");
            if(!$results){
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            }
        }
    } else { //for some reason not in postback so send error
        array_push($returnValue, "ERROR: Connection issue, Please call support");
    }
    
    //if everything worked correctly then the array should have just an empty string
    echo json_encode($returnValue);
?>
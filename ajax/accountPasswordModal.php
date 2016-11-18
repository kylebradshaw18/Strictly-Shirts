<?php
    /**
    * This page serves as the call from the password modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call

    if(!empty($_POST)){ //Check that we are in a postback
    
        $currentPassword = trim($_POST['currentPassword']);
        $newPassword = trim($_POST['newPassword']);
        $confirmPassword = trim($_POST['confirmPassword']);
        
        //first check the form data
        if(strlen($currentPassword) < 1){ array_push($returnValue, "Invalid Password");} 
        if(strlen($newPassword) < 1){ array_push($returnValue, "Invalid Current Password");} else if(strlen($newPassword) > 25){ array_push($returnValue, "New Password is too long");} 
        if($confirmPassword !== $newPassword){ array_push($returnValue, "Passwords do not match");} 
        if($currentPassword === $newPassword){ array_push($returnValue, "Current password and new password are the same");} 
        
        
        if(count($returnValue) > 1){ //Initialized array with empty string so any more than one is an error
            echo json_encode($returnValue);
            exit();
        }
        
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        
        //First check if the current password is correct
        $sql = "SELECT `personId` FROM `people` WHERE `personId` = ".$_SESSION['personId']." AND `password` = ENCRYPT('".$currentPassword."','password') LIMIT 1";
        $results = $conn->query($sql);
        if(!$results){ //Something Went wrong on the update
            array_push($returnValue, "ERROR: Connection issue, Please call support");
        }
        
        if($results ->num_rows > 0){ //got a row so now update the password
            $updateSQL =  "UPDATE `people` SET `password` = ENCRYPT('".$newPassword."','password') WHERE `personId` = ".$_SESSION['personId'];
            $results = $conn->query($updateSQL);
            if(!results){ //Something Went wrong on the update
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            }
        } else { //no rows so invalid password
            array_push($returnValue, "Current password is incorrect");
        }
        
    } else { //for some reason not in postback so send error
        array_push($returnValue, "ERROR: Connection issue, Please call support");
    }
    
    //if everything worked correctly then the array should have just an empty string
    echo json_encode($returnValue);
?>
<?php
    /**
    * This page serves as the call from the password modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call

    if(!empty($_POST)){ //Check that we are in a postback
        $Id = trim($_POST['Id']);
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        //First Check if the user already has that subscription
        $results = $conn->query("SELECT `subscriptionId` FROM `subscriptions` WHERE `personId` = ".$_SESSION['personId']." AND `categoryId` = ".$Id);
        if(!results){ //Something Went wrong on the update
            array_push($returnValue, "ERROR: Connection issue, Please call support");
        }
        
        if($results ->num_rows > 0){
            array_push($returnValue, "You are already subscribed to this category");
        } else { //no rows so now insert it into the database
        
            //Get the users primary address
            $results = $conn->query("SELECT `addrId`, `isPrimaryAddress`, `state`, `city` FROM `addresses` WHERE `personId` = ".$_SESSION['personId']." ORDER BY `isPrimaryAddress` DESC, `state`, `city` LIMIT 1");
            if(!results){ //Something Went wrong on the update
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            }
            
            //If the user does not have a primary address then stop them
            if($results ->num_rows < 1){
                array_push($returnValue, "You must have an address before subscribing");
            } else { //have a row so grab it
                $addrId = 0;
                while($row = $results->fetch_assoc()) {
                    $addrId = $row["addrId"]; //grab the address id
                }
                
                //Insert row into subscriptions
                $insertSQL =  "INSERT INTO `subscriptions` (`personId`,`categoryId`,`addrId`,`date`) VALUES ('".$_SESSION['personId']."', '".$Id."', '".$addrId."', CURRENT_TIMESTAMP)";
                $results = $conn->query($insertSQL);
    			if(!$results){ //Something went wrong
    				array_push($returnValue, "ERROR: Connection issue, Please call support");
    			}
            }
        }
    } else { //for some reason not in postback so send error
        array_push($returnValue, "ERROR: Connection issue, Please call support");
    }
    
    //if everything worked correctly then the array should have just an empty string
    echo json_encode($returnValue);
?>
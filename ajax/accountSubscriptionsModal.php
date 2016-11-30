<?php
    /**
    * This page serves as the call from the password modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call

    if(!empty($_POST)){ //Check that we are in a postback
        $subscriptionId = trim($_POST['subscriptionId']);
        $addressId = trim($_POST['addressId']);
        $categoryId = trim($_POST['categoryId']); //On add its the id on edit its the text value
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        
        
        $results = $conn->query("SELECT `categoryId` FROM `categories` WHERE `category` = '".$categoryId. "'");
        if(!$results){ //Something Went wrong on the update
            array_push($returnValue, "ERROR: Connection issue, Please call support");
        }
        
        //Have a row so set the id if not then the id is already set
        if($results ->num_rows > 0){
            $categoryId = $results->fetch_assoc()['categoryId'];
        }
        
        
        //Check if the user has a address
        $results = $conn->query("SELECT `addrId` FROM `addresses` WHERE `personId` = ".$_SESSION['personId']." AND addrId = ".$addressId);
        if(!$results){ //Something Went wrong on the update
            array_push($returnValue, "ERROR: Connection issue, Please call support");
        }
        
        //If the user does not have a primary address then stop them
        if($results ->num_rows < 1){
            array_push($returnValue, "You must select an address before subscribing");
        } else { //have a row so grab it
            //Check if user already has that same subscription
            $results = $conn->query("SELECT `subscriptionId` FROM `subscriptions` WHERE `personId` = ".$_SESSION['personId']." AND `categoryId` = ".$categoryId. " AND `addrId` = ".$addressId);
            if(!$results){ //Something Went wrong on the update
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            }
            
            //If the user does not have a primary address then stop them
            if($results ->num_rows > 0){
                array_push($returnValue, "You already have this subscription with the same address");
            } else { //In the clear either update or insert row
        
                if($subscriptionId < 1){ //Add(insert)
                     //Insert row into subscriptions
                    $insertSQL =  "INSERT INTO `subscriptions` (`personId`,`categoryId`,`addrId`,`date`) VALUES ('".$_SESSION['personId']."', '".$categoryId."', '".$addressId."', CURRENT_TIMESTAMP)";
                    $results = $conn->query($insertSQL);
        			if(!$results){ //Something went wrong
        				array_push($returnValue, "ERROR: Connection issue, Please call support");
        			}
                    
                } else { //Edit (update)
                    //Update the row
                    $sql =  "UPDATE `subscriptions` SET `categoryId` = '".$categoryId."', `addrId` = '".$addressId."' ,`date` = CURRENT_TIMESTAMP WHERE `personId` = ".$_SESSION['personId'];
                    $results = $conn->query($sql);
        			if(!$results){ //Something went wrong
        				array_push($returnValue, "ERROR: Connection issue, Please call support");
        			}
                }
            }
        }
    } else { //for some reason not in postback so send error
        array_push($returnValue, "ERROR: Connection issue, Please call support");
    }
    
    //if everything worked correctly then the array should have just an empty string
    echo json_encode($returnValue);
?>
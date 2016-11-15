<?php
    /**
    * This page serves as the call from the password modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call

    if(!empty($_POST)){ //Check that we are in a postback
    
        $address = trim($_POST['address']);
        $apartment = trim($_POST['apartment']);
        $city = trim($_POST['city']);
        $state = trim($_POST['state']);
        $zip = trim($_POST['zip']);
        $primary = trim($_POST['primary']);
        $call = trim($_POST['call']);
        $addressId = trim($_POST['addressId']);
        
        //first check the form data
        if(strlen($address) < 1){ array_push($returnValue, "Address is required");} else if(strlen($address) > 75){ array_push($returnValue, "Address is too long");} 
        if(strlen($apartment) < 1){ $apartment = null;} else if(strlen($apartment) > 25){ array_push($returnValue, "Apartment is too long");} 
        if(strlen($city) < 1){ array_push($returnValue, "City is required");} else if(strlen($city) > 50){ array_push($returnValue, "City is too long");} 
        if(strlen($zip) !== 5){ array_push($returnValue, "Invalid zip code");}
        if($primary === "Yes"){$primary = 1;} else {$primary = 0;}
        
        
        if(count($returnValue) > 1){ //Initialized array with empty string so any more than one is an error
            echo json_encode($returnValue);
            exit();
        }
        
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        if($call === "add"){
            //First check if the user already has that address
            $sql =  "SELECT `addrId` FROM `addresses` WHERE `personId` = ".$_SESSION['personId']." AND `addressLine1` = '".$address."' ";
            $sql .= " AND `city` = '".$city."' AND  `state` = '".$state."' AND `zipcode` = '".$zip."'";
            $results = $conn->query($sql);
            if(!$results){ //Something Went wrong on the update
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            }
            
            if($results ->num_rows > 0){ //got a row so tell the user the row already exists
                array_push($returnValue, "This address already exists");
            } else { //no rows so now insert it into the database
            
                $insertSQL =  "INSERT INTO `addresses` (`personId`, `addressLine1`, `apartmentNumber`, `city`, `state`, `zipcode`, `isPrimaryAddress`) ";
                $insertSQL .= "VALUES ('".$_SESSION['personId']."', '".$address."', '".$apartment."', '".$city."', '".$state."', '".$zip."', '".$primary."') ";
                
                $results = $conn->query($insertSQL);
    			if(!$results){ //Something went wrong
    				array_push($returnValue, "ERROR: Connection issue, Please call support");
    			}
    			
    			//Gets the id from the row that was just inserted
    			$addressId = $conn->insert_id;
    			array_push($returnValue, $addressId);
            }
        } else { //edit
            //First check if the user already has that address
            $sql  =  "UPDATE `addresses` SET  `addressLine1` = '".$address."', `apartmentNumber` = '".$apartment."', ";
            $sql .=  " `city` = '".$city."', `state` = '".$state."', `zipcode` = '".$zip."', `isPrimaryAddress` = ".$primary;
            $sql .=  " WHERE `personId` = ".$_SESSION['personId']." AND `addrId` = ".$addressId;
            
            $results = $conn->query($sql);
            if(!results){ //Something Went wrong on the update
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            }
        }
        
        //New Primary Address So update the rest
	    if($primary === 1){
	        $SQL = "UPDATE `addresses` set `isPrimaryAddress` = 0 WHERE `personId` = ".$_SESSION['personId']." AND  `addrId` <> ".$addressId;
	        $results = $conn->query($SQL);
	        if(!$results){ //Something went wrong
				array_push($returnValue, "ERROR: Connection issue, Please call support");
			}
	    }
    
    } else { //for some reason not in postback so send error
        array_push($returnValue, "ERROR: Connection issue, Please call support");
    }
    
    //if everything worked correctly then the array should have just an empty string
    echo json_encode($returnValue);
?>
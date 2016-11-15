<?php
    /**
    * This page serves as the call from the password modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call

    if(!empty($_POST)){ //Check that we are in a postback
        $nameCard = trim($_POST['nameCard']);
        $cardType = trim($_POST['cardType']);
        $cardNumber = trim($_POST['cardNumber']);
        $security = trim($_POST['security']);
        $expirationMonth = trim($_POST['expirationMonth']);
        $expirationYear = trim($_POST['expirationYear']);
        $primary= trim($_POST['primary']);
        $call= trim($_POST['call']);
        $payId = trim($_POST['paymentId']);
        
        //first check the form data
        if(strlen($nameCard) < 1){ array_push($returnValue, "Name is required");} else if(strlen($nameCard) > 45){ array_push($returnValue, "Name is too long");} 
        //Can do more checks here in the future for card number
        if(strlen($cardNumber) < 1){ array_push($returnValue, "Number is required");} else if(strlen($cardNumber) > 20){ array_push($returnValue, "Invalid card");} 
        if(strlen($security) < 3){ array_push($returnValue, "Invalid card");} else if(strlen($security) > 4){ array_push($returnValue, "Invalid card");} 
        if($primary === "Yes"){$primary = 1;} else {$primary = 0;}
        
        if(count($returnValue) > 1){ //Initialized array with empty string so any more than one is an error
            echo json_encode($returnValue);
            exit();
        }
        
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        if($call === "add"){
            //First check if the user already has that payment option
            $sql =  "SELECT `payId` FROM `paymentmethods` WHERE `personId` = ".$_SESSION['personId']." AND";
            $sql .= " `cardNum` = '".$cardNumber."'";
            
            $results = $conn->query($sql);
            if(!results){ //Something Went wrong on the update
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            }
            
            if($results ->num_rows > 0){ //got a row so tell the user the row already exists
                array_push($returnValue, "This card already exists");
            } else { //no rows so now insert it into the database
            
                $insertSQL =  "INSERT INTO `paymentmethods` (`personId`, `cardNum`, `csc`, `type`, `isPrimaryPayment`, `expirationMonth`, `expirationYear`, `nameOnCard`) ";
                $insertSQL .= "VALUES ('".$_SESSION['personId']."', '".$cardNumber."', '".$security."', '".$cardType."', '".$primary."', '".$expirationMonth."', '".$expirationYear."', '".$nameCard."') ";
                $results = $conn->query($insertSQL);
    			if(!$results){ //Something went wrong
    				array_push($returnValue, "ERROR: Connection issue, Please call support");
    			}
    			
    			//Gets the id from the row that was just inserted
    			$payId = $conn->insert_id;
            }
        } else { //edit
            $sql  =  "UPDATE `paymentmethods` SET  `cardNum` = '".$cardNumber."', `csc` = '".$security."', ";
            $sql .=  " `type` = '".$cardType."', `isPrimaryPayment` = '".$primary."', `expirationMonth` = '".$expirationMonth."', `expirationYear` = '".$expirationYear."', ";
            $sql .=  " `nameOnCard` = '".$nameCard."' "; 
            $sql .=  " WHERE `personId` = ".$_SESSION['personId']." AND `payId` = ".$payId;
            
            $results = $conn->query($sql);
            if(!results){ //Something Went wrong on the update
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            }
        }
        
        //New Primary Address So update the rest
	    if($primary === 1){
	        $SQL = "UPDATE `paymentmethods` SET `isPrimaryPayment` = 0 WHERE `personId` = ".$_SESSION['personId']." AND  `payId` <> ".$payId;
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
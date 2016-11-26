<?php

    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call

    if(!empty($_POST)){ //Check that we are in a postback
        $productId = trim($_POST['productId']);
        $quantity = trim($_POST['quantity']);
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        //First Check if the user already has that subscription
        $results = $conn->query("SELECT `cartId` FROM `carts` WHERE `personId` = ".$_SESSION['personId']." AND `productId` = ".$productId);
        if(!$results){ //Something Went wrong on the update
            array_push($returnValue, "ERROR: Connection issue, Please call support");
        }
        
        if($results ->num_rows > 0){
            //add to quantity of items currently in cart
            $currentCartData = mysqli_fetch_array($results, MYSQLI_ASSOC);
            $updateSQL = "UPDATE `carts` SET `quantity` =". $currentCartData['quantity'] + $quantity."WHERE `personId` = ".$_SESSION['personId']." AND `productId` = ".$productId;
            $results = $conn->query($updateSQL);
    			if(!$results){ //Something went wrong
    				array_push($returnValue, "ERROR: Connection issue, Please call support");
    			}
        } else { 
            //Insert row into carts
            $insertSQL =  "INSERT INTO `carts` (`personId`,`productId`,`quantity`) VALUES ('".$_SESSION['personId']."', '".$productId."', '".$quantity.")";
            $results = $conn->query($insertSQL);
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
<?php

    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call
    
    //Check if session variable is set  if not then go to sign in page
	if(!isset($_SESSION['personId']) || empty($_SESSION['personId'])) {
		array_push($returnValue, "Please sign in first");
	}

    if(!empty($_POST)){ //Check that we are in a postback
        $cartId = trim($_POST['cartId']);
        $quantity = trim($_POST['quantity']);
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        
        if(!$cartId > 0){ array_push($returnValue, "Something went wrong please contact support"); }
        if(!$quantity > 0){ array_push($returnValue, "Quantity must be greater than zero"); }
        
        if(count($returnValue) < 2){
            
            //delete the product from cart table
             $results = $conn->query("DELETE FROM `carts` WHERE `cartId` = ".$cartId);
            
            $results = $conn->query($sql);
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
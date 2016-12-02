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
        $inventoryId = trim($_POST['inventoryId']);
        $quantity = trim($_POST['quantity']);
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        
        if(!$inventoryId > 0){ array_push($returnValue, "Something went wrong please contact support"); }
        if(!$quantity > 0){ array_push($returnValue, "Quantity must be greater than zero"); }
        
        if(count($returnValue) < 2){
            $inventoryQuantity = 0;
            
            //first update the quantity in the inventory table
            $results = $conn->query("SELECT * FROM `inventory` WHERE `inventoryId` = ".$inventoryId);
            while($row = $results->fetch_assoc()){
            	//Set the variables for the page
                $inventoryQuantity = $row["quantity"];
    	    }
    	    
<<<<<<< HEAD
    	    //Have less products than they want so only give them what we have left
=======
    	    //Have less products than they want so only give them what we haev left
>>>>>>> 9009bb614a53eea711efb815e82699fa78567079
    	    if($inventoryQuantity < $quantity){
    	        $quantity = $inventoryQuantity;
    	        $inventoryQuantity = 0;
    	    } else {
    	        $inventoryQuantity -= $quantity;    
    	    }
    	    
    	    //Update the quantity
    	    $results = $conn->query("UPDATE `inventory` SET `quantity` = ".$inventoryQuantity." WHERE `inventoryId` = ".$inventoryId);
        
            //First Check if the user already has that subscription
            $results = $conn->query("SELECT `cartId`, `quantity` FROM `carts` WHERE `personId` = ".$_SESSION['personId']." AND `inventoryId` = ".$inventoryId);
            if(!$results){ //Something Went wrong on the update
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            }
            $sql = "";
            if($results ->num_rows > 0){ //Already has this product in the cart so do an update
                $cartId = 0;
                $cartQuantity = 0;
                while($row = $results->fetch_assoc()){
                    $cartId = $row["cartId"];
                    $cartQuantity = $row["quantity"];
        	    }
        	    $total = $cartQuantity + $quantity;
                $sql = "UPDATE `carts` SET `quantity` = ".$total." WHERE `personId` = ".$_SESSION['personId']." AND `inventoryId` = ".$inventoryId;
            } else {  //Insert row into carts
                $sql =  "INSERT INTO `carts` (`personId`,`inventoryId`,`quantity`) VALUES (".$_SESSION['personId'].", ".$inventoryId.", ".$quantity.")";
            }
            
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
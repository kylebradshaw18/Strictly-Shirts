<?php
    /**
    * This page serves as the call from the address delete modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    $returnValue = array("");  //return value for the call

    if(!empty($_POST)){ //Check that we are in a postback
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        
        //First check if the user already has that address
        $sql =  "UPDATE `addresses` SET `status` = 'DELETED' WHERE `addrId` = ".trim($_POST['addressId']);
        $results = $conn->query($sql);
        if(!$results){ //Something Went wrong on the update
            array_push($returnValue, "ERROR: Connection issue, Please call support");
        }
            
    } else { //for some reason not in postback so send error
        array_push($returnValue, "ERROR: Connection issue, Please call support");
    }
    
    //if everything worked correctly then the array should have just an empty string
    echo json_encode($returnValue);
?>
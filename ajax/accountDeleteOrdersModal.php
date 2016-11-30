<?php
    /**
    * This page serves as the call from the orders delete modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    $returnValue = array("");  //return value for the call

    if(!empty($_POST)){ //Check that we are in a postback
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        
        //First Update the inventory table quantity because if they can delete that means they are returning
        $sql = "SELECT `orderdetails`.`quantity` AS `orderQuantity`, `orderdetails`.`inventoryId`, `inventory`.`quantity` AS `inventoryQuantity`  FROM `orderdetails` INNER JOIN `inventory` ON `orderdetails`.`inventoryId` = `inventory`.`inventoryId` WHERE `orderId` = ".$_POST['orderId'];
        if($_POST['inventoryId'] > 0){
            $sql .= " AND `orderdetails`.`inventoryId` = ".$_POST['inventoryId'];
        }
        
        $results = $conn->query($sql);
        while($row = $results->fetch_assoc()) {
            //Update the quantity
            $quantity = $row['orderQuantity'] + $row['inventoryQuantity'];
            $updateResult = $conn->query("UPDATE `inventory` SET `quantity` = ".$quantity." WHERE `inventoryId` = ".$row['inventoryId']);
        }
        
        //Then delete from the orders details table
        $sql = "DELETE FROM `orderdetails` WHERE `orderId` = ".$_POST['orderId'];
        if($_POST['inventoryId'] > 0){
            $sql .= " AND `inventoryId` = ".$_POST['inventoryId'];
        }
        
        $results = $conn->query($sql);
        if(!$results){ //Something Went wrong on the update
            array_push($returnValue, "ERROR: Connection issue, Please call support");
        } else {
            $results = $conn->query("SELECT * FROM `orderdetails` WHERE `orderId` = ".$_POST['orderId']);
            if(!$results){ //Something Went wrong on the update
                array_push($returnValue, "ERROR: Connection issue, Please call support");
            } else {
                if($results ->num_rows < 1){
                    //No rows in the orderdetails table so no delete from the order master table
                    $results = $conn->query("DELETE FROM `ordersmaster` WHERE `orderId` = ".$_POST['orderId']);
                    if(!$results){ //Something Went wrong on the update
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
<?php
    /**
    * This page serves as the call from the subscriptions modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call
    $subscriptionsValue = array("");  //return value for the call
    $addressValue = array("");  //return value for the call

    //Use this to link to the connections page for the database functions
    require_once('../Globals/connection.php');
    $sql =  "SELECT `category`, `categories`.`categoryId`, `subscriptionId`, DATE_FORMAT(`date`,'%m/%d/%Y') AS `date`, ";
	$sql .= " addresses.addrId, `addressLine1`, `city`, `state`, `zipcode`";
	$sql .= " FROM `subscriptions` INNER JOIN `categories` ON `subscriptions`.`categoryId`  = `categories`.`categoryId` ";
	$sql .= " INNER JOIN `addresses`  ON `subscriptions`.`addrId`  = `addresses`.`addrId` ";
    $sql .= " WHERE `subscriptions`.`personId` = ".$_SESSION['personId'];
    $sql .= " AND `addresses`.`status` = 'ACTIVE'";
    $sql .= " AND `category` <> 'Custom Order'";
    $sql .= " ORDER BY `category`, `date`";
    $results = $conn->query($sql);
    while($row = $results->fetch_assoc()) {
        $subscriptionsValue[] = $row;
    }
    $returnValue[] = $subscriptionsValue;
    
    $sql =  "SELECT `addrId`, `addressLine1`, `city`, `state`, `zipcode`, `isPrimaryAddress` FROM `addresses` WHERE `status` = 'ACTIVE' AND `personId` = ". $_SESSION['personId'] ." ORDER BY `isPrimaryAddress` DESC, `state`, `city`, `zipcode`";
    $results = $conn->query($sql);
    while($row = $results->fetch_assoc()) {
        $addressValue[] = $row;
    }
    $returnValue[] = $addressValue;
    //return array
    echo json_encode($returnValue);
?>
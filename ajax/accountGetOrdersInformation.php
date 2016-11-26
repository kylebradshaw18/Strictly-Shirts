<?php
    /**
    * This page serves as the call from the subscriptions modal on the accounts page
    */
    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array("");  //return value for the call
    $mainLoopValue = array(""); 
    $innerLoopValue = array("");  

    //Use this to link to the connections page for the database functions
    require_once('../Globals/connection.php');
    
    //Main Sql Statement
    $mainSql =  " SELECT `orderId`, DATE_FORMAT(`date`,'%m/%d/%Y') AS `date`, 'false' AS `showDelete`, ";
    $mainSql .= "         `cardNum`, `type`, `addressLine1`, `apartmentNumber`, `city`, `state`, `zipcode` "; 
    $mainSql .= " FROM  `ordersmaster` INNER JOIN `addresses` ON `ordersmaster`.`addrId` = `addresses`.`addrId` "; 
    $mainSql .= "                      INNER JOIN `paymentmethods` ON `ordersmaster`.`payId` = `paymentmethods`.`payId` "; 
    $mainSql .= " WHERE  `ordersmaster`.`personId` = ".$_SESSION['personId'];
    $mainSql .= " ORDER BY  `orderId` DESC ";
    
    $mainResults = $conn->query($mainSql);
    while($mainSqlRow = $mainResults->fetch_assoc()) {  
        
        
        //Need to get the min ship date need to run another query
        $minShipDateQuery  = " SELECT MIN(`mindays`) AS `minShip` ";
        $minShipDateQuery .= " FROM (SELECT CASE WHEN `priority` = 'First Class' THEN 1 WHEN `priority` = 'Standard' THEN 5 ELSE 2 END AS `mindays` ";
        $minShipDateQuery .= "     	 FROM `priorities` INNER JOIN `orderdetails` ON `priorities`.`priorityId` = `orderdetails`.`priorityId` ";
        $minShipDateQuery .= "       WHERE `orderId` = ".$mainSqlRow['orderId'].") AS `t` " ;
        
        $minShipDateResults = $conn->query($minShipDateQuery);
        $minShipDate = $minShipDateResults->fetch_assoc()['minShip'];
        
        if(floor(abs(time() - strtotime($mainSqlRow['date'])) / (60 * 60 * 24)) <= $minShipDate){
            $mainSqlRow['showDelete'] = true;    
        } else {
            $mainSqlRow['showDelete'] = false;    
        }
        $mainLoopValue[] = $mainSqlRow;
        
        $innerSql =  " SELECT `products`.`productId`, `orderdetails`.`quantity`, `designs`.`design`, `orderdetails`.`price`, `categories`.`category`, `types`.`type`, `sizes`.`size`, `priorities`.`price` AS `shippingCost`, ";
        $innerSql .= "        `priorities`.`priority` AS `shipping`, `inventory`.`inventoryId`, DATE_FORMAT(`ordersmaster`.`date`,'%m/%d/%Y') AS `date`, `orderdetails`.`orderId`, 'false' AS `showDelete`, ";
        $innerSql .= "              CASE ";
        $innerSql .= "                   WHEN `priority` = 'First Class' THEN 1";
        $innerSql .= "                   WHEN `priority` = 'Standard' THEN 5";
        $innerSql .= "                   ELSE 2 ";
        $innerSql .= "             END AS `minDays` ";
        $innerSql .= " FROM  `orderdetails` INNER JOIN  `inventory` ON  `orderdetails`.`inventoryId` =  `inventory`.`inventoryId` ";
        $innerSql .= "                      INNER JOIN  `products` ON  `inventory`.`productId` =  `products`.`productId` ";
        $innerSql .= "                      INNER JOIN  `designs` ON  `products`.`designId` =  `designs`.`designId` ";
        $innerSql .= "                      INNER JOIN  `categories` ON  `products`.`categoryId` =  `categories`.`categoryId` ";
        $innerSql .= "                      INNER JOIN  `sizes` ON  `inventory`.`sizeId` =  `sizes`.`sizeId` ";
        $innerSql .= "                      INNER JOIN  `colors` ON  `inventory`.`colorId` =  `colors`.`colorId` ";
        $innerSql .= "                      INNER JOIN  `types` ON  `inventory`.`typeId` =  `types`.`typeId` ";
        $innerSql .= "                      INNER JOIN  `priorities` ON `priorities`.`priorityId` = `orderdetails`.`priorityId`";
        $innerSql .= "                      INNER JOIN  `ordersmaster` ON `orderdetails`.`orderId` = `ordersmaster`.`orderId`";
        $innerSql .= " WHERE  `orderdetails`.`orderId` = ".$mainSqlRow['orderId'];
        $innerSql .= " ORDER BY `minDays` DESC, `productId` DESC ";
        
        $innerResults = $conn->query($innerSql);
        //loop through results
        while($innerSqlRow = $innerResults->fetch_assoc()) { 
            if(floor(abs(time() - strtotime($innerSqlRow['date'])) / (60 * 60 * 24)) <= $innerSqlRow['minDays']){
                $innerSqlRow['showDelete'] = true;    
            } else {
                $innerSqlRow['showDelete'] = false;    
            }
            $innerLoopValue[] = $innerSqlRow;
        }
        
    }
    //Add arrays to return array
    $returnValue[] = $mainLoopValue;
    $returnValue[] = $innerLoopValue;
    
    //return array
    echo json_encode($returnValue);
?>
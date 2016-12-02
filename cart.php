<?php 
  // Start the session
  session_start();
  require_once('Globals/connection.php');
  require_once('Globals/buildHTML.php');
  require_once('Globals/globalFunctions.php');
  
  //Check if session variable is set  if not then go to sign in page
	if(!isset($_SESSION['personId']) || empty($_SESSION['personId'])) {
		header('Location: signin.php?navigation='.substr($_SERVER['REQUEST_URI'],1,strlen($_SERVER['REQUEST_URI']) - 1));
	}
	$errorHtml = "";
	if(isset($_GET['cart']) && !empty($_GET['cart'])){
	  
	  //First get the quantity of shirts in the users cart
	  $quantity = 0;
	  $inventoryId = 0;
	  $results = $conn->query("SELECT `carts`.`quantity` AS `cartQuantity`, `inventory`.`quantity` AS `inventoryQuantity`, `inventory`.`inventoryId` FROM `carts` INNER JOIN `inventory` ON `carts`.`inventoryId` = `inventory`.`inventoryId` WHERE `cartId` = ".$_GET['cart']);
	  if($results->num_rows > 0) {
      while($row = $results->fetch_assoc()){
        $quantity = $row['cartQuantity'] + $row['inventoryQuantity'];
        $inventoryId = $row['inventoryId'];
      }
	  
	    //Have the new quantity for the inventory table
	    $results = $conn->query("UPDATE `inventory` SET `quantity` = ".$quantity." WHERE `inventoryId` = ".$inventoryId);
      $results = $conn->query("DELETE FROM `carts` WHERE `cartId` = ".$_GET['cart']);
      if(!$results){ //Something Went wrong on the update
          $errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
      }
    }
	}
	
  buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
  buildHeader(); //Builds the Header and Navigation Bar ?>
  <div class='container'>
    <div class='check-out'>
      <h2 class="cart-header">Cart</h2>
      <!-- Cart Alert Area -->
      <div id="cartAlert"><?php echo $errorHtml; ?></div>
      
      <?php //Check if the users cart is empty
        $sql  = " SELECT DISTINCT `products`.`productId`, `categories`.`category`, `designs`.`design` ";
        $sql .= " FROM `carts` INNER JOIN `inventory` ON `carts`.`inventoryId` = `inventory`.`inventoryId` ";
        $sql .= "              INNER JOIN `products` ON `inventory`.`productId` = `products`.`productId` ";
        $sql .= "              INNER JOIN `categories` ON `products`.`categoryId` = `categories`.`categoryId` ";
        $sql .= "              INNER JOIN `designs` ON `products`.`designId` = `designs`.`designId` ";
        $sql .= " WHERE `personId` = ".$_SESSION['personId'];
        $sql .= " ORDER BY `products`.`productId`, `categories`.`category`, `designs`.`design`";
        
        $imageResults = $conn->query($sql);
        if($imageResults ->num_rows < 1){ // There are no items in cart ?>
          <div class="text-center"><h3>Your cart is empty <hr style="width:18%;"></h3></div>
      <?php } else{  
        $grandTotal= 0;
      ?>
          <table>
            <thead>
              <tr>
                <th>Item</th>
                <th>Sizes</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Action</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <form action="cart.php" method="get">
      <?php //Loop through the users cart
    	    while ($imageRow = $imageResults->fetch_assoc()) { 
    	?>
    	      <tr>
              <td class="ring-in">
                <a href="#" class="at-in">
                  <img src="images/productsImages/<?php echo $imageRow['productId'];?>.jpg" class="img-responsive" alt="<?php echo $imageRow['design'];?>">
                </a>
                <div class="sed">
                  <h5><?php echo $imageRow['category'];?></h5>
                </div>
                <br/>
                <div class="sed">
                  <h5><?php echo $imageRow['design'];?></h5>
                </div>
                <div class='clearfix'> </div>
              </td>
              <?php
                //Build size column, quantity and price
                $sizeColumn = "<td>";
                $quantityColumn = "<td>";
                $priceColumn = "<td>";
                $actionColumn = "<td>";
                $subTotal = 0;
              
                $innerSql  = " SELECT `sizes`.`size`, `sizes`.`sizeId`, `carts`.`cartId`, `carts`.`quantity`, `inventory`.`price` ";
                $innerSql .= " FROM `sizes` INNER JOIN `inventory` ON `inventory`.`sizeId` = `sizes`.`sizeId` ";
                $innerSql .= "              INNER JOIN `products` ON `inventory`.`productId` = `products`.`productId` ";
                $innerSql .= "              INNER JOIN `carts` ON `carts`.`inventoryId` = `inventory`.`inventoryId` ";
                $innerSql .= " WHERE `carts`.`personId` = ".$_SESSION['personId'];
                $innerSql .= "   AND `products`.`productId` = ".$imageRow['productId'];
                $innerSql .= " ORDER BY `sizes`.`sizeId`";
                $innerResults = $conn->query($innerSql);
                while($innerRow = $innerResults->fetch_assoc()){
                  $sizeColumn .= "<div>".$innerRow['size']."</div>";
                  $quantityColumn .= "<div>".$innerRow['quantity']."</div>";
                  $priceColumn .= "<div>$".number_format((float)$innerRow['price'], 2, '.', '')."</div>";
                  $actionColumn .= "<div><a href=\"cart.php?cart=".$innerRow['cartId']."\" class=\"btn btn-danger btn-xs button\">Remove Item</a></div>";
                  $subTotal += ($innerRow['price'] * $innerRow['quantity']);
                }
                $grandTotal += $subTotal;
                $sizeColumn .= "</td>";
                $quantityColumn .= "</td>";
                $priceColumn .= "</td>";
                $actionColumn .= "</td>";
                echo $sizeColumn.$quantityColumn.$priceColumn.$actionColumn."<td>$".number_format((float)$subTotal, 2, '.', '')."</td>";
              ?>
              </tr>
    	    <?php }?>
    	        </form>
            </tbody>
            <tfoot>
              <tr>
                <td colspan= "4"></td>
                <td><a href="checkout.php" class="to-buy">Check Out</a></td>
                <td>$<?php echo number_format((float)$grandTotal, 2, '.', ''); ?></td>
              </tr>
            </tfoot>
        	</table>
    	     <?php 	} ?>
  </div>
</div>
<?php  buildFooter(false); //Builds the Footer ?>
<?php 
  // Start the session
  session_start();
  require_once('Globals/connection.php');
  require_once('Globals/buildHTML.php');
  require_once('Globals/globalFunctions.php');
  
<<<<<<< HEAD
  //Check if session variable is set  if not then go to sign in page
	if(!isset($_SESSION['personId']) || empty($_SESSION['personId'])) {
		header('Location: signin.php?navigation='.substr($_SERVER['REQUEST_URI'],1,strlen($_SERVER['REQUEST_URI']) - 1));
	}
	$errorHtml = "";
=======
  //Use this to link to the global function page
  require 'Globals/buildHTML.php';

  //Use this to link to the conenctions page for the database functions
  require 'Globals/connection.php';
  
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar
  
  //Check the user is logged in
  if ($_SESSION['personId']){
      //Query the database for the user's cart
      $cartQuery = "SELECT `cartId`, `productId`, `quantity` FROM `carts` WHERE peresonId = '".$_SESSION['personId']."'";
      $productQuery = "SELECT `productId`, `price` FROM `products`";
      $cartResults = mysqli_query($conn, $cartQuery);
      $productResults = mysqli_query($conn, $productQuery);
  } 
    


    /**
    Here is where we will build the properties for the each page
    */

    ?>
    
    <div class='container'>
	<div class='check-out'>

          <?php
            
             if($cartResults){
                echo "<h2>Checkout</h2>";
                echo "<table>";
                echo "<tr>";
                echo "<th>Item</th>";
                echo "<th>Qty</th>";
                echo "<th>Price</th>";
                echo "<th>Subtotal</th>";
                echo "</tr>";          
          
                while($row = mysqli_fetch_array($cartResults, MYSQLI_ASSOC)){
                    
                    $lookingForProduct = true;
                    
                    while($lookingForProduct && $productRow = mysqli_fetch_array($productResults, MYSQLI_ASSOC)){
                      if($productRow['productId'] == $row['productId']){
                        $associatedProduct = $productRow;
                        $productPrice = $associatedProduct['price'];
                        $lookingForProduct = false;
                      }
                    }
                    
                    
                    echo "<tr>";
                    echo "<td class='ring-in'><a href='#' class='at-in'><img src='images/productsImages/". $associatedProduct['productId'].".jpg' class='img-responsive' alt=''></a>";
                    echo "<div class='sed'>";
                    echo "<h5> Shirt ". $associatedProduct['productId']."</h5>";
                    echo "<p>A very cool shirt. It will grant you many friends. </p>";
                    echo "</div>";
                    echo "<div class='clearfix'> </div></td>";
                    echo "<td class='check'><input id='quantity-".$row['cartId'] . "' type='text' value='" . $row['quantity'] . "' onfocus=\"this.value='';\" onblur=\"updateSubtotal(".$row['cartId'].",".$associatedProduct['price']."); \"></td>";		
                    echo "<td>$ ".$associatedProduct['price'].".00</td>";
                    echo "<td id='subTotal-".$row['cartId'] ."'>$ ".($associatedProduct['price'] * $row['quantity']) .".00 </td>";
                    echo "</tr>";
                }
                	echo "</table>";
                	echo "<a href='#' class=' to-buy'>PROCEED TO BUY</a>";
                	echo "<div class='clearfix'> </div>";
            } else {
                  echo "<p> Your cart is empty!</p>";
            }
          ?>
          
>>>>>>> 9009bb614a53eea711efb815e82699fa78567079
	
  buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
  buildHeader(); //Builds the Header and Navigation Bar?>
  <script src="./Page Functions/cart.js"></script>
  <div class='container'>
    <div class='check-out'>
      <h2 class="cart-header">Check Out</h2>
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
                <td colspan="4"></td>
                <td><a href="checkout.php" class="to-buy">Check Out</a></td>
                <td>$<?php echo number_format((float)$grandTotal, 2, '.', ''); ?></td>
              </tr>
            </tfoot>
        	</table>
    	     <?php 	} ?>
  </div>
</div>
<?php  buildFooter(false); //Builds the Footer ?>
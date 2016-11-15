<?php 
  // Start the session
  session_start();
  
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
                    //We should probably add a name and description to shirts in the database.
                    echo "<h5> Shirt ". $associatedProduct['productId']."</h5>";
                    echo "<p>A very cool shirt. It will grant you many friends. </p>";
                    echo "</div>";
                    echo "<div class='clearfix'> </div></td>";
                    echo "<td class='check'><input id='quantity-".$row['cartId'] . "' type='text' value='" . $row['quantity'] . "' onfocus=\"this.value='';\" onblur=\"updateSubtotal(".$row['cartId'].",".$associatedProduct['price']."); \"></td>";		
                    //Also maybe we should change the format of stored prices?
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
          
	
	
	
    </div>
</div>

<script type="text/javascript" src="">
  function updateSubtotal(id, price){
    document.getElementById("subtotal-" + id).innerHTML = price * parseInt(document.getElementById("quantity-" + id).value);
  }
</script>

<?php  buildFooter(false); //Builds the Footer ?>
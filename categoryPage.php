<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
?>
<?php 
//TO DO : Connect to database
// Start the session
	session_start();
	//Use this to link to the global function page
	require 'Globals/buildHTML.php';
	
	
	
	buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
	buildHeader(); //Builds the Header and Navigation Bar

if (isset($_GET['id'])) {

	$id = preg_replace('#[^0-9]#i', '', $_GET['id']);
	
	//Use this to link to the conenctions page for the database functions
	require 'Globals/connection.php';
	
	$results = $conn->query("SELECT `sizeId`, `size` FROM `sizes` ORDER BY `sizeId`");
    while($row = $results->fetch_assoc()) {
        $size .= "<option value=\"". $row['sizeId'] ."\">". $row['size'] ."</option>";
    }
    
	?>
	
	<script src="./Page Functions/categoryPage.js"></script>
    <div class="container">
    <!-- Selection Bar -->
    <div class="col-md-2" id="leftCol">
       <form action="categoryPage.php" method="get">
        <ul class="nav nav-stacked text-center" id="sidebar">
          <li>
            <div class="form-group">
              <label for="productsSelectCategory">Categories</label>
              <select class="form-control" id="productsSelectCategory" name="id"> 
              <?php   //Query to build cateories
                      $results = $conn->query("SELECT `categoryId`, `category` FROM `categories` ORDER BY `category`");
                        while($row = $results->fetch_assoc()) { ?>
                         <option value = "<?php echo $row['categoryId'];?>"><?php echo $row['category'];?></option>
              <?php } ?>
              </select>
            </div>
          </li>
          <li>
              <button type="submit" class="btn btn-sm btn-info" onclick="updateProductsGrid();" value="Search" title="Search For Shirts">Search</button>
          </li>
        </ul>
       </form>
      </div>
      
      <!--Start of Grid-->
    <div class="container col-md-9" id="productsGridInformation">
      
      

    <?php
    //Dont need the catregories table since we already have the id just use the products table
    //also join the design table so we can get the name of the design so we can display it on the modal.
    //If we decide to do a page with all of the products then just have an if the query and remove the where clause where we are checking the category id.
    
    //Order them by design
    //Then inside of this main loop of products after we display the image and name on the grid 
    //after this write another query so that we can get evrything else from the inventory table and loop through this and display them in hidden input tags
    //Can create a string of all of the values from that row. use !@!# to split them make sure we do not have spaces ex. color-red,1!@!#type-Oneck,1!@!#small-small,1!@!#Quantity,12!@!#Price,14.95
    //Do this for every row in the inventory table so we have the information on the screen (We can get away with this approach because we are not amazon and do not have alot of traffic.)
    
    //Then in javascript we need to pull this information and show it on the modal
    //Create onchange function calls to update the values when the user changes the the size.
    
    
    //TODO if feeling good
    //On the product grid the way we have it is that a small giants shirt can be more than an extra small. (price)
    //Write query to pull max and min values and if they are not the same then display them like this on the products grid ($12.95 - $19.89) 'JUST LIKE AMAZON'
    
    
    $sql =   "SELECT * FROM `products`,`categories` 
                        WHERE products.categoryId = categories.categoryId 
                        AND categories.categoryId = '$id'";
                
                $result = $conn->query($sql);
                $c = 0;
                $n = 4; // Each Nth iteration would be a new table row
                while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                     $productId = $row["productId"];
                     $designId = $row["designId"];
	        		 

    //get the design for a particular product
    $queryDesign =   "SELECT designs.design ".
                        "FROM products,designs ".
                        "WHERE products.designId = designs.designId ".
                        "AND products.productId = '$productId'";

    $resDesign = $conn->query($queryDesign);
                      $rowDesign = mysqli_fetch_array($resDesign);
                      $design = $rowDesign["design"];
    

    //get the category for a particular product
    $queryCategory =   "SELECT categories.category ".
                        "FROM products,categories ".
                        "WHERE products.categoryId = categories.categoryId ".
                        "AND products.productId = '$productId'";

    $resCategory = $conn->query($queryCategory);
                      $rowCategory = mysqli_fetch_array($resCategory);
                      $category = $rowCategory["category"];
                      
    
     //get details for a particular product
     $queryDetails = "SELECT inventory.quantity, inventory.price ".
                     "FROM inventory,products ".
                     "WHERE inventory.productId = '$productId' ORDER BY inventory.sizeId LIMIT 1";
                     $resDetails = $conn->query($queryDetails);
                     $rowDetails = mysqli_fetch_array($resDetails, MYSQL_ASSOC);
                     $quantity = $rowDetails["quantity"];
                     $price = $rowDetails["price"];
                     

                    if ($c % $n == 0 && $c != 0) { // If $c is divisible by $n...
                        echo '<div class="row"></div>';
                        
                    }

                    $c++;
                    ?>
                    
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(<?php echo $productId ?>)" data-target="#productModal<?php echo $productId ?>" href="#">
            <img class="img-responsive" src="images/productsImages/<?php echo $productId ?>.jpg" alt="" />
          </a>
          <h3><a href="#"><?php echo $design ?></a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice"><?php echo number_format($price, 2) ?></span></h5>
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(<?php echo $productId ?>)" data-target="#productModal<?php echo $productId ?>" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>

<!-- Product Modal -->
<div id="productModal<?php echo $productId ?>" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3><span id="productModalHeaderText">Product</span><span class="extra-title muted"></span></h3>
            </div>
            <div class="modal-body">
                
                <!--Modal Alert Area -->
                <div id="productsModalAlert"></div>
                
                <div class="media-left pull-left text-center">
                    <img class="media-object" id="productsModalImage" src="images/productsImages/<?php echo $productId ?>.jpg" alt="Generic placeholder image">
                </div>
                <div class="media-body media-bottom">
                    <div class="modal-body form-horizontal">
                    
                        <div class="form-group">
                            <label for="productModalDesign" class="col-xs-4 control-label">Design:</label>
                            <div class="col-xs-5">
                                <div class="list-group-item" id="productModalDesign" name="productModalDesign"><?php echo $design ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productModalSize" class="col-xs-4 control-label">Size:</label>
                            <div class="col-xs-5">
                                <select class="form-control" id="productModalSize" name="productModalSize">
                                  <?php echo $size; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantityLeftModal" class="col-xs-4 control-label">Quantity Left:</label>
                            <div class="col-xs-5">
                                <div class="list-group-item" id="quantityLeft" name="quantityLeft"><?php echo $quantity ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ProductPrice" class="col-xs-4 control-label">Price:</label>
                            <div class="col-xs-5">
                                <div class="list-group-item" id="accountOrderPrice" name="accountOrderPrice"><?php echo "$".number_format($price, 2) ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productModalQuantity" class="col-xs-4 control-label">Quantity:</label>
                            <div class="col-xs-5 input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" onclick="productModalQuantity('minus')" id="productModalQuantityValueMinus" disabled="disabled"><span class="glyphicon glyphicon-minus"></span></button>
                                </span>
                                <input type="text" class="form-control" name="productModalQuantityValue" id="productModalQuantityValue" value="1" disabled="disabled">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" onclick="productModalQuantity('add')" type="button" id="productModalQuantityValueAdd" disabled="disabled"><span class="glyphicon glyphicon-plus"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button href="#" class="btn btn-primary" onclick="addToCart()" id="productModalAddToCart" disabled="disabled" hidden>Add to Cart</button>
                <button href="signin.php" class="btn btn-primary" id="productModalSignIn" disabled="disabled" hidden>Sign In</button>
                <button href="#" class="btn" data-dismiss="modal" id="productModalAddToCartClose" aria-hidden="true">Close</button>
                </div>
        </div>
    </div>
</div>


      <?php 
    }

} else {
	echo "Data to render this page is missing.";
	exit();
}

?>
    </div>
</div>
</div>
<input type="hidden" name="userLoggedIn" id="userLoggedIn" value="<?php echo $personId;?>" disabled="disabled">

<?php  buildFooter(false); //Builds the Footer ?>
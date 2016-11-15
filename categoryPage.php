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
	?>
	<script src="./Page Functions/categoryPage.js"></script>
    <div class="container">
    <!-- Selection Bar -->
    <div class="col-md-2" id="leftCol">
        <ul class="nav nav-stacked text-center" id="sidebar">
          <li>
            <div class="form-group">
              <label for="productsSelectCategory">Categories</label>
              <select class="form-control" id="productsSelectCategory"> <?php echo $categories; ?></select>
            </div>
          </li>
          <li><button type="button" class="btn btn-sm btn-info" onclick="updateProductsGrid();" value="Search" title="Search For Shirts">Search</button></li>
        </ul>
      </div>
      
      <!--Start of Grid-->
    <div class="container col-md-9" id="productsGridInformation">
      
      

    <?php
    $sql =   "SELECT * FROM `products`,`categories` 
                        WHERE products.categoryId = categories.categoryId 
                        AND categories.categoryId = '$id'";
                
                $result = $conn->query($sql);
                $c = 0;
                $n = 3; // Each Nth iteration would be a new table row
                while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                     $productId = $row["productId"];
                     $typeId = $row["typeId"];
                     $colorId = $row["color"];
                     $sizeId = $row["sizeId"];
                     $designId = $row["designId"];
                     $supplierId = $row["supplierId"];
                     $quantity = $row["quantity"];
	        		 $price = $row["price"];
	        		 
                    
                    //get the type for a particular product
    $queryType =   "SELECT types.type ".
                        "FROM products,types ".
                        "WHERE products.typeId = types.typeId ".
                        "AND products.productId = '$productId'";

    $resType = $conn->query($queryType) or die(mysqli_error());
    while ($rowType = mysqli_fetch_array($resType)) {
          $type = $rowType["type"];

    }


    //get the color for a particular product
    $queryCol =   "SELECT colors.color ".
                        "FROM products,colors ".
                        "WHERE products.colorId = colors.colorId ".
                        "AND products.productId = '$productId'";

    $resCol = $conn->query($queryCol) or die(mysqli_error());
    while ($rowCol = mysqli_fetch_array($resCol)) {
          $color = $rowCol["color"];

    }

    //get the size for a particular product
    $querySize =   "SELECT sizes.size ".
                        "FROM products,sizes ".
                        "WHERE products.sizeId = sizes.sizeId ".
                        "AND products.productId = '$productId'";

    $resSize = $conn->query($querySize) or die(mysqli_error());
    while ($rowSize = mysqli_fetch_array($resSize)) {
          $size = $rowSize["size"];

    }
    

    //get the design for a particular product
    $queryDesign =   "SELECT designs.design ".
                        "FROM products,designs ".
                        "WHERE products.designId = designs.designId ".
                        "AND products.productId = '$productId'";

    $resDesign = $conn->query($queryDesign) or die(mysqli_error());
    
    while ($rowDesign = mysqli_fetch_array($resDesign)) {
          $design = $rowDesign["design"];

    }
    

    //get the category for a particular product
    $queryCategory =   "SELECT categories.category ".
                        "FROM products,categories ".
                        "WHERE products.categoryId = categories.categoryId ".
                        "AND products.productId = '$productId'";

    $resCategory = $conn->query($queryCategory) or die(mysqli_error());
    while ($rowCategory = mysqli_fetch_array($resCategory)) {
          $category = $rowCategory["category"];

    }
                    if ($c % $n == 0 && $c != 0) { // If $c is divisible by $n...
                        echo '<div class="row"</div>';
                        
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
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
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
                            <label for="accountOrderType" class="col-xs-4 control-label">Type:</label>
                            <div class="col-xs-5">
                                <select class="form-control" id="productModalType" name="productModalType">
                                  <?php echo $type; ?>
                                </select>
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
                            <label for="productModalColor" class="col-xs-4 control-label">Color:</label>
                            <div class="col-xs-5">
                                <select class="form-control" id="productModalColor" name="productModalColor">
                                  <?php echo $color; ?>
                                </select>
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
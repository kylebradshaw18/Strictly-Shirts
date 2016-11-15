<?php 
    // Start the session
    session_start();
  
    $personId = 0;
    //Check if session variable is set  if it is then set hidden value
  	if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])) {
      $personId = $_SESSION['personId'];
  	}
  

    //Use this to link to the conenctions page for the database functions
    require 'Globals/connection.php';
    $productsGrid = "";
    $categories = "";
    $size = "";
    $color = "";
    $type = "";
    
    $results = $conn->query("SELECT `categoryId`, `category` FROM `categories` ORDER BY `category`");
    while($row = $results->fetch_assoc()) {
        $categories .= "<option value=\"". $row['categoryId'] ."\">". $row['category'] ."</option>";
    }
    
    $results = $conn->query("SELECT `sizeId`, `size` FROM `sizes` ORDER BY `sizeId`");
    while($row = $results->fetch_assoc()) {
        $size .= "<option value=\"". $row['sizeId'] ."\">". $row['size'] ."</option>";
    }
    
    $results = $conn->query("SELECT `colorId`, `color` FROM `colors` ORDER BY `color`");
    while($row = $results->fetch_assoc()) {
        $color .= "<option value=\"". $row['colorId'] ."\">". $row['color'] ."</option>";
    }
    
    $results = $conn->query("SELECT `typeId`, `type` FROM `types` ORDER BY `type`");
    while($row = $results->fetch_assoc()) {
        $type .= "<option value=\"". $row['typeId'] ."\">". $row['type'] ."</option>";
    }
    
  
    //Use this to link to the global function page
    require 'Globals/buildHTML.php';
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar


    //Builds the breadcrumbs dynamically
    //Need to put this on the other pages remove from this page
//    $array = array(
//        array("products.php","Products") );
//    buildBreadCrumbs($array);
?>
<script src="./Page Functions/products.js"></script>
<div class="container">
  <div class="row">
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
      
      <?php //run query to rull all of the shirts
      
        $mainSQL = "";
        
      ?>
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
      
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
      
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
      
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
      
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
      
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
      
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
      
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
      
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
      
      <!-- Item -->
      <div class="col-md-3 col-sm-12 productsSpace">
        <div class="col-md1 simpleCart_shelfItem">
          <a data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" href="#">
            <img class="img-responsive" src="images/productsImages/1.jpg" alt="" />
          </a>
          <h3><a href="#">Design Name</a></h3>
          <div class="price">
            <h5 class="productPrice">$<span id="productPrice">23.95</span></h5>
            <input type="hidden" name="ShirtName" value="Shirt6">
            <input type="hidden" name="price" value="300">
            <input type="hidden" name="img-file" value="pi8.png">
            <input type="hidden" name="detail" value="Green  shirt">
            <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(1)" data-target="#productModal" value="Search" title="View Product">View Product</button>
          </div>
        </div>
      </div>
      
      
    
    
    
    </div>
  </div>
</div>
<input type="hidden" name="userLoggedIn" id="userLoggedIn" value="<?php echo $personId;?>" disabled="disabled">


<!-- Product Modal -->
<div id="productModal" class="modal fade" role="dialog">
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
                    <img class="media-object" id="productsModalImage" src="images/productsImages/1.jpg" alt="Generic placeholder image">
                </div>
                <div class="media-body media-bottom">
                    <div class="modal-body form-horizontal">
                    
                        <div class="form-group">
                            <label for="productModalDesign" class="col-xs-4 control-label">Design:</label>
                            <div class="col-xs-5">
                                <div class="list-group-item" id="productModalDesign" name="productModalDesign">Special2</div>
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
                                <div class="list-group-item" id="accountOrderPrice" name="accountOrderPrice">$10.20</div>
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

<?php buildFooter(); //Builds the Footer ?>
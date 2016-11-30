<?php 
    // Start the session
    session_start();
    require_once('Globals/connection.php');
    require_once('Globals/buildHTML.php');
 
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar
    
    $categoryId = 1; //This variable is used for the category select on the left side of the screen
    
    //Builds the breadcrumbs dynamically
    //  $array = array( array("products.php","Products") );
    //  buildBreadCrumbs($array);?>
      
<script src="./Page Functions/products.js"></script>
<div class="container">
    <!-- Selection Bar -->
    <div class="col-md-2" id="leftCol">
        <form action="products.php" method="get">
            <ul class="nav nav-stacked text-center" id="sidebar">
                <li>
                    <div class="form-group">
                        <label for="productsSelectCategory">Category</label>
                        <select class="form-control" id="productsSelectCategory" name="category"> 
                            <?php   //Query to build cateories
                                $results = $conn->query("SELECT `categoryId`, `category` FROM `categories` WHERE `category` <> 'Custom Order' ORDER BY `category`");
                                while($row = $results->fetch_assoc()) { ?>
                                <option value = "<?php echo $row['categoryId'];?>"><?php echo $row['category'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </li>
                <li>
                    <button type="submit" class="btn btn-sm btn-info" value="Search" title="Search For Shirts" name="searchButton">Search</button>
                </li>
            </ul>
        </form>
    </div>
    <!--Start of Grid-->
    <div class="container col-md-9" id="productsGridInformation">
      
    <?php //run main query and loop through them
        $mainSql  = " SELECT `products`.`productId`, `products`.`designId`, `products`.`categoryId`, `designs`.`design`, `categories`.`category` ";
        $mainSql .= " FROM `products` INNER JOIN `designs` ON `products`.`designId` = `designs`.`designId` ";
        $mainSql .= "                 INNER JOIN `categories` ON `products`.`categoryId` = `categories`.`categoryId` ";
        $mainSql .= " WHERE 1 = 1 ";
        if(isset($_GET['category'])){ 
            $mainSql .= " AND `categories`.`categoryId` = ".$_GET['category'];
        }
        if(isset($_GET['design'])){ 
            $mainSql .= " AND `designs`.`designId` = ".$_GET['design'];
        }
        $mainSql .= " ORDER BY `categories`.`category`, `designs`.`design` "; 
        
        $mainResults = $conn->query($mainSql);
    	if(!$mainResults || $mainResults ->num_rows < 1){ //Something went wrong or have no products in that category ?>
    		<div class="col-md-11 text-center" style="padding-top:5%;"><h3>No Products Found<hr style="width:25%;"></h3></div>
    	<?php } else{
    	    while($mainRow = $mainResults->fetch_assoc()){ 
            //Loop through main results for the product grid
            $categoryId = $mainRow['categoryId'];
    ?>
    	        <!-- Item -->
                <div class="col-md-3 col-sm-12 productsSpace">
                    <div class="col-md1 simpleCart_shelfItem">
                        <a data-toggle="modal" onclick="setModalValues(<?php echo $mainRow['productId'];?>)" data-target="#productModal" href="#">
                            <img class="img-responsive" id="productInformationImage_<?php echo $mainRow['productId'];?>" src="images/productsImages/<?php echo $mainRow['productId'];?>.jpg" alt="<?php echo $mainRow['design'];?>" style="width:128px;height:150px;"/>
                        </a>
                        <h3 style="height:36px;"><?php echo $mainRow['design'];?></h3>
                        <div class="price">
                            <?php //Now loop through inventory table and get all the rows for that inventory all of the information
                                $price = "0.00";
                                $priceSql  = " SELECT MAX(`inventory`.`price`) AS `inventoryPriceMax`, MIN(`inventory`.`price`) AS `inventoryPriceMin` ";
                                $priceSql .= " FROM `inventory` WHERE `productId` = ".$mainRow['productId'];
                                $priceResult = $conn->query($priceSql);
                            	while($priceRow = $priceResult->fetch_assoc()){ 
                            	    if($priceRow['inventoryPriceMax'] !== $priceRow['inventoryPriceMin']){
                            	        $price = "".number_format((float)$priceRow['inventoryPriceMin'], 2, '.', '')." - $".number_format((float)$priceRow['inventoryPriceMax'], 2, '.', '');
                            	    } else {
                            	        $price = "".number_format((float)$priceRow['inventoryPriceMin'], 2, '.', '');
                            	    }
                            	}
                            ?>
                            <h5 class="productPrice">$<span id="productPrice_<?php echo $mainRow['productId'];?>"><?php echo $price;?></span></h5>
                            <button class="form-control btn btn-sm btn-primary" data-toggle="modal" onclick="setModalValues(<?php echo $mainRow['productId'];?>)" data-target="#productModal" value="Search" title="View Product">View Product</button>
                        </div>
                        <?php
                            //Loop through inventory with product Id to get the information on that product
                            $productInformationArray = array();
                            $inventorySql  = " SELECT `inventory`.`inventoryId`, `inventory`.`colorId`, `inventory`.`sizeId`, ";
                            $inventorySql .= "        `inventory`.`typeId`, `inventory`.`price`, `inventory`.`quantity`, '".$mainRow['design']."' AS `design`  ";
                            $inventorySql .= " FROM `inventory` ";
                            $inventorySql .= " WHERE `inventory`.`productId` = ".$mainRow['productId'];
                            $inventorySql .= " ORDER BY `inventory`.`inventoryId`, `inventory`.`sizeId`, `inventory`.`colorId`, `inventory`.`typeId`";
                            $inventoryResult = $conn->query($inventorySql);
                            while($inventoryRow = $inventoryResult->fetch_assoc()){ 
                        	    $productInformationArray[] = $inventoryRow;
                        	}
                        ?>
                        <input type="hidden" name="productInformationHiddenInfo" id="productsHiddenInfo_<?php echo $mainRow['productId'];?>" value="<?php echo htmlspecialchars(json_encode($productInformationArray));?>" disabled="disabled">
                    </div>
                </div>
    	    <?php } // end of main loop
    	} //end of num rows
    ?>
    </div>
</div>

<!-- Product Modal =============================================================-->
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
                    <img class="media-object" id="productsModalImage" src="" alt="Generic placeholder image">
                </div>
                <div class="media-body media-bottom">
                    <div class="modal-body form-horizontal">
                    
                        <div class="form-group">
                            <label for="productModalDesign" class="col-xs-4 control-label">Design:</label>
                            <div class="col-xs-5">
                                <div class="list-group-item" id="productModalDesign" name="productModalDesign"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productModalType" class="col-xs-4 control-label">Type:</label>
                            <div class="col-xs-5">
                                <select class="form-control" id="productModalType" name="productModalType" onchange="valuesChange(this)">
                                    <?php //Build Type select
                                        $results = $conn->query("SELECT `typeId`, `type` FROM `types` ORDER BY `typeId`");
                                        while($row = $results->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['typeId']; ?>"><?php echo $row['type']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productModalColor" class="col-xs-4 control-label">Color:</label>
                            <div class="col-xs-5">
                                <select class="form-control" id="productModalColor" name="productModalColor" onchange="valuesChange(this)">
                                    <?php //Build Color select
                                        $results = $conn->query("SELECT `colorId`, `color` FROM `colors` ORDER BY `color`");
                                        while($row = $results->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['colorId']; ?>"><?php echo $row['color']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productModalSize" class="col-xs-4 control-label">Size:</label>
                            <div class="col-xs-5">
                                <select class="form-control" id="productModalSize" name="productModalSize" onchange="valuesChange(this)">
                                    <?php //Build Size select
                                        $results = $conn->query("SELECT `sizeId`, `size` FROM `sizes` ORDER BY `sizeId`");
                                        while($row = $results->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['sizeId']; ?>"><?php echo $row['size']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ProductPrice" class="col-xs-4 control-label">Price:</label>
                            <div class="col-xs-5">
                                <div class="list-group-item">$<span id="productModalPrice"></span></div>
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
                        <div class="form-group">
                            <label for="productModalInStock" class="col-xs-4 control-label">In Stock:</label>
                            <div class="col-xs-5">
                                <input type="text" class="form-control" name="productModalInStock" id="productModalInStock" value="1" disabled="disabled">
                            </div>
                        </div>
                        <input type="hidden" name="productModalInformationHiddenInfo" id="productsModalHiddenInfo" value="" disabled="disabled">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])) { ?>
                    <button class="btn btn-primary" onclick="addToCart()" id="productModalAddToCart">Add to Cart</button>
                <?php } else { ?>
                    <a href="signin.php" class="button btn btn-primary" id="productModalSignIn">Sign In</a>
                <?php } ?>
                <button class="btn" data-dismiss="modal" id="productModalAddToCartClose" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"> $('#productsSelectCategory').val(<?php echo $categoryId; ?>); </script>
<?php buildFooter(true); //Builds the Footer ?>
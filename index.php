<?php 
	// Start the session
	session_start();
	require_once('Globals/connection.php');
	
	
	require_once('Globals/buildHTML.php');
    buildHTMLHeadLinks('false');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar ?>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<!--banner-->
<div class="banner">
	<div class="matter-banner">
	 	<div class="slider">
	    	<div class="callbacks_container">
	      		<ul class="rslides" id="slider">
	      		    <?php 
                        $images = glob("images/sliderImages/*.jpg");
                        foreach( $images as $image ){ ?>
                            <li>
                                <img src="<?php echo $image; ?>" height="60">
                            </li>
                    <?php } ?>
	      		</ul>
	 	 	</div>
		</div>
	</div>
	<div class="clearfix"> </div>
</div>
<div class="content">
	<div class="container">
		<div class="content-top">
			<div class="content-top1">
				<div class="col-md-6">
					<a class="twitter-timeline" href="https://twitter.com/maristshirts">Tweets by maristshirts</a>
				</div>
				<?php //Grab the top 10 designs 
                    $sql  = " SELECT COUNT(`designs`.`designId`) AS `total`, `designs`.`design`, `designs`.`designId`, `products`.`productId` ";
                    $sql .= " FROM `designs` INNER JOIN `products` ON `designs`.`designId` = `products`.`designId` ";
                    $sql .= "                INNER JOIN `inventory` ON `products`.`productId` = `inventory`.`productId` ";
                    $sql .= "                INNER JOIN `orderdetails` ON `inventory`.`inventoryId` = `orderdetails`.`inventoryId` ";
                    $sql .= " GROUP BY `designs`.`design`, `designs`.`designId`, `products`.`productId` ";
                    $sql .= " ORDER BY `total` DESC, `designs`.`design` ";
                    $sql .= " LIMIT 10";
                    $results = $conn->query($sql);
                    while($row = $results->fetch_assoc()) { 
                    ?>
                    <div class="col-md-3 col-md2 productsSpace">
    					<div class="col-md1 simpleCart_shelfItem">
    						<a href="products.php?design=<?php echo $row['designId']; ?>">
    							<img class="img-responsive" src="images/productsImages/<?php echo $row['productId'];?>.jpg" alt="<?php echo $row['design']; ?>" />
    						</a>
    						<h3><?php echo $row['design']; ?></h3>
    						<div class="price">
    						    <?php //Now loop through inventory table and get all the rows for that inventory all of the information
                                    $price = "0.00";
                                    $priceSql  = " SELECT MAX(`inventory`.`price`) AS `inventoryPriceMax`, MIN(`inventory`.`price`) AS `inventoryPriceMin` ";
                                    $priceSql .= " FROM `inventory` WHERE `productId` = ".$row['productId'];
                                    $priceResult = $conn->query($priceSql);
                                	while($priceRow = $priceResult->fetch_assoc()){ 
                                	    if($priceRow['inventoryPriceMax'] !== $priceRow['inventoryPriceMin']){
                                	        $price = "$".number_format((float)$priceRow['inventoryPriceMin'], 2, '.', '')." - $".number_format((float)$priceRow['inventoryPriceMax'], 2, '.', '');
                                	    } else {
                                	        $price = "$".number_format((float)$priceRow['inventoryPriceMin'], 2, '.', '');
                                	    }
                                	}
                                ?>
								<h5 class="item_price"><?php echo $price; ?></h5>
								<a href="products.php?design=<?php echo $row['designId']; ?>" class="item_add">View Product</a>
								<div class="clearfix"> </div>
    						</div>
    					</div>
    				</div>
                <?php } ?>
			    <div class="clearfix"> </div>
			</div>			
		</div>
	</div>
</div>
<?php buildFooter(true); //Builds the Footer ?>
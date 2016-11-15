<?php 
//TO DO : Connect to database
// Start the session
	session_start();
	//Use this to link to the global function page
	require 'Globals/buildHTML.php';
	
	//Use this to link to the conenctions page for the database functions
	require 'Globals/connection.php';

// Check to see the URL variable is set and that it exists in the database
if (isset($_GET['id'])) {
	// Connect to the mysqli database  
    //include "storescripts/connect_to_mysqli.php"; 
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
	// Use this var to check to see if this ID exists, if yes then get the product 
	// details, if no then exit this script and give message why
	$sql = $conn->query("SELECT * FROM products WHERE productId='$id' LIMIT 1");
	$productCount = mysqli_num_rows($sql); // count the output amount
    if ($productCount > 0) {
		// get all the product details
		while($row = mysqli_fetch_array($sql, MYSQL_ASSOC)){ 
			 $typeId = $row["typeId"];
       $colorId = $row["color"];
       $sizeId = $row["sizeId"];
       $designId = $row["designId"];
       $categoryId = $row["categoryId"];
       $supplierId = $row["supplierId"];
       $quantity = $row["quantity"];
			 $price = $row["price"];
         }
    
    //get the type for a particular product
    $queryType =   "SELECT types.type ".
                        "FROM products,types ".
                        "WHERE products.typeId = types.typeId ".
                        "AND products.productId = '$id'";

    $resType = $conn->query($queryType) or die(mysqli_error());
    while ($rowType = mysqli_fetch_array($resType)) {
          $type = $rowType["type"];

    }


    //get the color for a particular product
    $queryCol =   "SELECT colors.color ".
                        "FROM products,colors ".
                        "WHERE products.colorId = colors.colorId ".
                        "AND products.productId = '$id'";

    $resCol = $conn->query($queryCol) or die(mysqli_error());
    while ($rowCol = mysqli_fetch_array($resCol)) {
          $color = $rowCol["color"];

    }

    //get the size for a particular product
    $querySize =   "SELECT sizes.size ".
                        "FROM products,sizes ".
                        "WHERE products.sizeId = sizes.sizeId ".
                        "AND products.productId = '$id'";

    $resSize = $conn->query($querySize) or die(mysqli_error());
    while ($rowSize = mysqli_fetch_array($resSize)) {
          $size = $rowSize["size"];

    }
    

    //get the design for a particular product
    $queryDesign =   "SELECT designs.design ".
                        "FROM products,designs ".
                        "WHERE products.designId = designs.designId ".
                        "AND products.productId = '$id'";

    $resDesign = $conn->query($queryDesign) or die(mysqli_error());
    
    while ($rowDesign = mysqli_fetch_array($resDesign)) {
          $design = $rowDesign["design"];

    }
    

    //get the category for a particular product
    $queryCategory =   "SELECT categories.category ".
                        "FROM products,categories ".
                        "WHERE products.categoryId = categories.categoryId ".
                        "AND products.productId = '$id'";

    $resCategory = $conn->query($queryCategory) or die(mysqli_error());
    while ($rowCategory = mysqli_fetch_array($resCategory)) {
          $category = $rowDesign["category"];

    }



	} else {
		echo "That item does not exist.";
	    exit();
	}
		
} else {
	echo "Data to render this page is missing.";
	exit();
}

  buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
	buildHeader(); //Builds the Header and Navigation Bar
?>

<div style="margin-left: 400px" align="center" id="mainWrapper">
  <div id="pageContent">
  <table width="100%" border="0" cellspacing="0" cellpadding="15">
  <tr>
    <!-- way to store images in database and query them .. Using placeholder image for now-->
    <td width="19%" valign="top"><img src="images/productsImages/<?php echo $id ?>.jpg" /><br />
    <td width="81%" valign="top"><h3><?php echo $category." ". $type; ?></h3>
      <p><?php echo "Price     $".$price; ?><br />
        <br />
        <?php echo "Color     ".$color; ?> <br />
      <br />
      <?php echo "Size     ".$size; ?> <br />
      <br />
        <?php echo "Design     ".$design; ?>
     <br />
        </p>
      <form id="form1" name="form1" method="post" action="cart.php"> <!-- reference cart action -->
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
        <input class="btn btn-primary" type="submit" name="button" id="button" value="Add to Cart" />
      </form>
      </td>
    </tr>
</table>
  </div>
</div>



<?php  buildFooter(false); //Builds the Footer ?>

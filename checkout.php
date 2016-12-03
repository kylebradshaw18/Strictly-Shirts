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
	$personId = $_SESSION['personId'];
	
  buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
  buildHeader(); //Builds the Header and Navigation Bar
  
  
  $sql =   "SELECT * FROM `addresses` WHERE personId = '$personId' ORDER BY `isPrimaryAddress` LIMIT 1";
                
  $result = $conn->query($sql);
  echo("Error description: " . mysqli_error($conn));
  
  echo "One";
  while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        $addressLine1 = $row["addressLine1"];
        $apartmentNumber = $row["apartmentNumber"];
        $city = $row["city"];
        $state = $row["state"];
        $zipcode = $row["zipcode"];
        
        echo "Address ".$addressLine1;
        
  }
  echo "Two";
  
  $sql = "SELECT cardNum FROM `paymentmethods`WHERE personId = '$personId' ORDER BY `isPrimaryPayment` LIMIT 1" ;
                
  $result = $conn->query($sql);
  echo("Error description: " . mysqli_error($conn));
  
  echo "PersonId ".$personId ;
  
  while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        $cardNum = $row["cardNum"];
        
  }
  $lastFour = substr($cardNum, -4);
  
  ?>
  
  <div class="row" style="margin-left: 4px;" >
    <div class="col-md-3 col-sm-12 productsSpace">
      <h3>Shipping Address</h3>
    </div> 
    
    <div class="col-md-3 col-sm-12 productsSpace">
      <p><?php echo $addressLine1." ".$apartmentNumber ?> </p>
      <p> <?php echo $city." ".$state ?></p>
      <p> <?php echo $zipcode ?></p>
    </div> 
    
    <div class="col-md-3 col-sm-12 productsSpace">
    <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" data-target="#productModal" value="Search">Add Address</button>
    </div> 
    
  </div>
  
   <div class="row" style="margin-left: 4px;" >
    <div class="col-md-3 col-sm-12 productsSpace">
      <h3>Payment Method </h3>
    </div> 
    
    <div class="col-md-3 col-sm-12 productsSpace">
      <h1>Use card endig <?php echo $carNum ?> </h1> 
    </div> 
    
     <div class="col-md-3 col-sm-12 productsSpace">
     <button type="button" class="form-control btn btn-sm btn-primary" data-toggle="modal" data-target="#productModal" value="Search">Add Card</button>
     </div>  
      
  </div>
  
  
<?php  buildFooter(false); //Builds the Footer ?>
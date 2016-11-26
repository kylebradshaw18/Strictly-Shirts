<?php 
    // Start the session
    session_start();
    //Set global variable for alerts
	$errorHtml = "";
	require_once('Globals/globalFunctions.php');
	require_once('Globals/buildHTML.php');
	require_once('Globals/connection.php');
	
	//Initialize the global variables
	$name;
	$phone;
	$email;
	$message;
	
	//Check if session variable is set  if not then go to sign in page
	if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])) {
		//If the user is signed in grab there information to make it easier to fill out the form
		$results = $conn->query("SELECT * FROM `people` WHERE `personId` = ".$_SESSION['personId']." LIMIT 1");
	    while($row = $results->fetch_assoc()){
	    	//Set the variables for the page
	      $name = $row["firstName"] . " " . $row["lastName"];
	      $email = $row["email"];
	      $phone = $row["phone"];
	    }
	}
	
	//Postback
	if(!empty($_POST)){
		$name = trim($_POST["name"]);
		$email = trim($_POST["email"]);
		$phone = trim($_POST["phone"]);
		$message = trim($_POST["message"]);
		
	  	//These are the checks for the required field
	  	if(strlen($name) < 1){ $errorHtml.= addAlert("Name is required","danger");} else if (strlen($firstname) > 150) {$errorHtml.= addAlert("Name is too long","danger");}
	  	if(strlen($email) < 1){ $errorHtml.= addAlert("Invalid Email Address","danger"); }  else if (strlen($email) > 75) {$errorHtml.= addAlert("Email Address too long","danger");}
	  	if(strlen($phone) !== 14){ $errorHtml.= addAlert("Invalid Phone Number","danger"); } 
	  	if(strlen($message) < 1){ $errorHtml.= addAlert("Message is required","danger"); }  else if (strlen($email) > 255) {$errorHtml.= addAlert("Message is too long","danger");}
	  	
		//Insert row into database
		if(strlen(trim($errorHtml)) < 1){
			//Insert row  and display success message
		    $results = $conn->query("INSERT INTO `contact` (`name`, `email`, `phone`, `message`) VALUES ('".$name."', '".$email."', '".$phone."', '".$message."')");
		    if(!$results){ //Something Went wrong on the update
	        $errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
		    } else {
		    	$errorHtml.= addAlert("Your information has been recieved","success");
		    	//Clear the message value 
				$message = "";
		    }
		}
	} 
	  
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar ?>
    
    <script src="./Page Functions/contact.js"></script>
    <div class="contact">
		<div class="container">
			<h3>Contact</h3>
			<div class="contact-grids">
				<div class="contact-form">
					<!-- Alert Area -->
        			<div id="contactAlert"><?php echo $errorHtml; ?></div>
					<form action="contact.php" method="post" onsubmit="return validateContactForm();">
						<div class="contact-bottom">
							<div class="col-md-4 in-contact">
								<label for="contactName">Name <font color="red">*</font></label>
								<input type="text" 
											 value="<?php echo $name;?>"
											 name="name" 
											 title="Full Name"
											 placeholder="Johnny Question"
											 id="contactName"
											 maxlength="150"
											 required>
							</div>
							<div class="col-md-4 in-contact">
								<label for="contactEmail">Email <font color="red">*</font></label>
								<input type="email" 
										   value="<?php echo $email;?>"
											 name="email" 
											 title="Email Address"
											 placeholder="strictlyShirts@gmail.com"
											 id="contactEmail"
											 maxlength="75"
											 required>
							</div>
							<div class="col-md-4 in-contact">
								<label for="contactPhone">Phone <font color="red">*</font></label>
								<input type="text"
								       name="phone" 
								       value="<?php echo $phone;?>"
								       title="Phone Number"
											 placeholder="(845)223-2323"
											 id="contactPhone"
											 maxlength="14"
								       required>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="contact-bottom-top">
							<label for="contactMessage">Message <font color="red">*</font></label>
							<textarea  name="message" 
							           id="contactMessage"
							           placeholder="Message..."
							           title="Message"
							           maxlength="255"
							           required><?php echo $message;?></textarea>								
						</div>
						<input type="submit" value="Send">
					</form>
				</div>
			</div>
		</div>
	</div>
    
<?php buildFooter(); //Builds the Footer ?>
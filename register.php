<?php 
	/** This page is where they can create a new account */
	
	// Start the session
	session_start();
	
	//Everytime we get an error call global function to append to empty string
	$errorHtml = "";
	
	//Check that we on in a post back
	if(!empty($_POST)){
		//Set form values to local variables
		$firstname = trim($_POST["firstname"]);
		$lastname = trim($_POST["lastname"]);
		$email = trim($_POST["email"]);
		$phone = trim($_POST["phone"]);
		$password = trim($_POST["password"]);
		$passwordconfirm = trim($_POST["passwordconfirm"]);
		
		require_once('Globals/globalFunctions.php'); //Page for global function
		
		//These are the checks for the required field
		if(strlen($firstname) < 1){ $errorHtml.= addAlert("Invalid First Name","danger");} else if (strlen($firstname) > 50) {$errorHtml.= addAlert("First Name too long","danger");}
		if(strlen($lastname) < 1){ $errorHtml.= addAlert("Invalid Last Name","danger"); }  else if (strlen($lastname) > 50) {$errorHtml.= addAlert("Last Name too long","danger");}
		if(strlen($email) < 1){ $errorHtml.= addAlert("Invalid Email Address","danger"); }  else if (strlen($email) > 75) {$errorHtml.= addAlert("Email Address too long","danger");}
		if(strlen($phone) !== 14){ $errorHtml.= addAlert("Invalid Phone Number","danger"); } 
		if(strlen($password) < 1){ $errorHtml.= addAlert("Invalid Password","danger"); }  else if (strlen($password) > 25) {$errorHtml.= addAlert("Password is too long","danger");}
		if($password !== $passwordconfirm){ $errorHtml.= addAlert("Verify Password does not match","danger"); }
		
		//no errors so now check credentials
		if(strlen(trim($errorHtml)) < 1){
			require_once('Globals/connection.php'); //Connection Page
			//Check if that email address already exists
			$results = $conn->query("SELECT `personId` FROM `people` WHERE email = '".$_POST["email"]."'");
			//if we have a row then the email or username is already taken
			if($results ->num_rows > 0){
				$errorHtml.= addAlert("Sorry, that username is already taken.","danger");
			} else { //Query did not grab any results so we are good (Insert into the database)
				//Query to insert into people table
				$results = $conn->query("INSERT INTO `people` (`firstName`, `lastName`, `password`, `email`, `phone`) VALUES ('".$firstname."', '".$lastname."', ENCRYPT('".$password."','password'), '".$email."', '".$phone."')");
				if(!$results){ //Something went wrong
					$errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
				}
				//Gets the id from the row that was just inserted and sets the session variable
				$peopleId = $conn->insert_id;
				$_SESSION['personId'] = $peopleId;
			}
		} 
		
		//Passed all checks now bring them to the account page
		if(strlen(trim($errorHtml)) < 1){
			//navigate to the users account
			header('Location: account.php');
		} 
	}
	require_once('Globals/buildHTML.php');
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar
?>
<!--This javascript page checks all of the users information on the client side-->
<script src="./Page Functions/register.js"></script>
<form action="register.php" method="post" onsubmit="return validateForm();">
	<div class="container">
		<div class="register">
			<h2>Register</h2>
				<!-- Alert Area -->
				<div id="registeralert"><?php echo $errorHtml; ?></div>
				<!-- Left (top on mobile) Column -->
				<div class="col-md-6  register-top-grid">
					<div class="mation">
						<!-- First Name -->
						<label for="registerfirstname">First Name <font color="red">*</font></label>
						<input  type="text" 
								placeholder="Enter First Name"
								title="Please enter a first name"
								value="<?php echo $_POST["firstname"];?>" 
								name="firstname"
								id="registerfirstname"
								maxlength="50"
								required> 
						<br><br>
						<!-- Last Name -->
						<label for="registerlastname">Last Name <font color="red">*</font></label>
						<input  type="text" 
								placeholder="Enter Last Name"
								title="Please enter a last name"
								value="<?php echo $_POST["lastname"];?>" 
								name="lastname"
								id="registerlastname"
								maxlength="50"
								required> 
						<br><br>
						<!-- Phone -->
						<label for="registerphone">Phone Number <font color="red">*</font></label>
						<input  type="tel" 
								placeholder="(555) 555-5555"
								title="Please enter a phone number"
								value="<?php echo $_POST["phone"];?>" 
								name="phone"
								id="registerphone"
								required>
					</div>
					<div class="clearfix"></div>
				</div>
				<!-- Right (bottom on mobile) Column -->
				<div class="col-md-6 register-bottom-grid">
					<div class="mation">
						<!-- Email -->
						<label for="registeremail">Email Address <font color="red">*</font></label>
						<input  type="email" 
								value="<?php echo $_POST["email"];?>" 
								title="Please enter an email address"
								placeholder="Email Address"
								name="email"
								id="registeremail"
								maxlength="100"
								required> 
						<br><br>
						<!-- Password -->
						<label for="registerpassword">Password <font color="red">*</font></label>
						<input  type="password" 
								placeholder="Enter Password" 
								title="Please enter a password"
								name="password"
								id="registerpassword"
								maxlength="25"
								required>
						<br><br>
						<!-- Confirm Password -->
						<label for="registerpasswordconfirm">Confirm Password <font color="red">*</font></label>
						<input  type="password" 
								placeholder="Confirm Password" 
								title="Please confirm your password"
								name="passwordconfirm"
								id="registerpasswordconfirm"
								maxlength="25"
								required>
					</div>
					<div class="clearfix"></div>
				</div>
			<!-- Submit Area -->
			<div class="register-but" align=center>
				<input type="submit" value="Create User">
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</form>
<?php  buildFooter(false); //Builds the Footer ?>
<?php 
/**
 * This page is the sign in page where the user has to provide an email
 * and password with will bring them to the account page and set the session variable
 */
 
	// Start the session
	session_start();
	
	//Check if session variable is set  if it is then go to the account page
	if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])) {
		//navigate to the users account
		header('Location: account.php');
	}
	
	require_once('Globals/globalFunctions.php'); //Page for global function
	require_once('Globals/connection.php'); //Connection Page
	
	//Everytime we find an error add it to the string
	$errorHtml = "";
	$email = "";
	$temporaryPassword;
	
	//Check if we hit the submit button and are on a post back
	if (!empty($_POST['password']) && !empty($_POST['email'])){
		$email = $_POST["email"];
		$temporaryPassword = $_POST["temporaryPassword"];
		$password = $_POST['password'];
		
		//On forgot password we create a temporary password so we need to check if it is set and they match
		if(isset($temporaryPassword)){ //Temporary password was showing check it
			if($temporaryPassword == $_POST["signInTemporaryPassword"]){
				//check new password length
				if(strlen($password) < 1){$errorHtml.= addAlert("Password is required","danger");}
				else if(strlen($password) > 25){$errorHtml.= addAlert("New Password is too long","danger");}
				//They match so update the password with the new password
				if(strlen($errorHtml) < 2){//Passed checks now search for email
					//First check if the username is in the database
					$results = $conn->query("SELECT `personId` FROM `people` WHERE `email` = '".$email."' AND `status` = 'ACTIVE'  LIMIT 1 ");
					if(!$results){ //If true then there is an error with connection or query
						$errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
					}
					//if we have a row then set the session variable for the customer id
					if($results ->num_rows > 0){
						//have to use local variable because if we set the session variable it will set it off as the user is signed in
						$personId = $results->fetch_assoc()['personId'];
						//Update the new password
						$results = $conn->query("UPDATE `people` SET `password` = ENCRYPT('".$password."','password')  WHERE `personId` = ".$personId);
						if(!$results){ //If true then there is an error with connection or query
							$errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
						}
					} else { //Query did not grab any results show alert
						$errorHtml .= addAlert("Sorry, that username does not match our records", "danger");
					}
				}
			} else { //dont match stop them
				$errorHtml.= addAlert("Temporary password does not match","danger");
			}
		}
		
		if(strlen($errorHtml) < 2){ //Check for errors before signing in the user
			//Get the results from the query (Grabs only one row)
			$results = $conn->query("SELECT `personId` FROM `people` WHERE `email` = '".$email."' AND `password` = ENCRYPT('".$password."','password') AND `status` = 'ACTIVE'  LIMIT 1 ");
			if(!$results){ //If true then there is an error with connection or query
				$errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
			}
			//if we have a row then set the session variable for the customer id
			if($results ->num_rows > 0){ //Make sure we have no errors
				//set the session person id variable to be used on other pages to what was returned
				$_SESSION['personId'] = $results->fetch_assoc()['personId'];
				//navigate to the users account
				header('Location: account.php');
			} else { //Query did not grab any results show alert
				$errorHtml .= addAlert("Sorry, the username/password is incorrect", "danger");
			}
		}
	} else if (!empty($_GET['forgotPasswordEmail'])){ //forgot password was clicked
		$personId = 0;
		$email = $_GET['forgotPasswordEmail'];
		
		//First check if the username is in the database
		$results = $conn->query("SELECT `personId` FROM `people` WHERE `email` = '".$email."' AND `status` = 'ACTIVE'  LIMIT 1 ");
		if(!$results){ //If true then there is an error with connection or query
			$errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
		}
		//if we have a row then set the session variable for the customer id
		if($results ->num_rows > 0){
			//have to use local variable because if we set the session variable it will set it off as the user is signed in
			$personId = $results->fetch_assoc()['personId'];
			
		} else { //Query did not grab any results show alert
			$errorHtml .= addAlert("Sorry, that username does not match our records", "danger");
		}
		
		if(strlen($errorHtml) < 2){ //Have persons id now do the update
			//Create a temporary password
			$len = 10; //length of the password
			$word = array_merge(range('a', 'z'), range('A', 'Z'));
		    shuffle($word);
		    $temporaryPassword = substr(implode($word), 0, $len);
			$errorHtml.= addAlert("Temporary password is ".$temporaryPassword,"info");
		}
	}
	
	
	require_once('Globals/buildHTML.php');
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar
?>
	<script type="text/javascript">
		//Function to set the href before doing a postback
		function forgotPasswordEmail(){
			$('#signInForgotPasswordLink').attr('href','signin.php?forgotPasswordEmail=' + $('#signInEmail').val().trim());
		}
	</script>
	
		<div class="account">
			<div class="container">
				<h2>Sign In</h2>
					<div class="account_grid">
						<div class="col-md-6 login-right">
							<form action="signin.php" method="post" name="signIn">
								<!-- Alert Div -->
								<div id="signInalert"><?php echo $errorHtml; ?></div>
								
								<!--Email Section -->
								<label for="signInEmail">Email Address</label>
								<input  type="email" 
										title="Please enter your email address"
										id="signInEmail" 
										placeholder="Email Address" 
										value="<?php echo $email;?>"
										name="email" 
										maxlength="100" 
										required> 
								<br><br>
								
							<?php 
								$passwordLabel = "";
							if(isset($temporaryPassword)){ 
								$passwordLabel = "New ";?>
								<!--Temporary Password Section -->
								<label for="signInTemporaryPassword">Temporary Password</label>
								<input type="password" 
									   title="Please enter your Temporary password"
									   placeholder="Temporary Password"
									   id="signInTemporaryPassword" 
									   name="signInTemporaryPassword" 
									   maxlength="10" 
									   required> 
								<br><br>
							<?php }?>
								
								<!--Password Section -->
								<label for="signInPassword"><?php echo $passwordLabel;?>Password</label>
								<input type="password" 
									   title="Please enter your password"
									   placeholder="Password"
									   id="signInPassword" 
									   name="password" 
									   maxlength="25" 
									   required> 
								
								<input type="password"  id="temporaryPassword" name="temporaryPassword" value="<?php echo $temporaryPassword; ?>" hidden>
								
								<!--If we have time try to implement a remember me checkbox here -->
								
								<div class="word-in">
									<a class="forgot" id="signInForgotPasswordLink" onclick="forgotPasswordEmail();">Forgot Your Password?</a>
									<input type="submit" id="signIn" value="Login">
								</div>
							
							</form>
							
						</div>	
						<div class="col-md-6 login-left">
							<h4>NEW CUSTOMERS</h4>
							<p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
							<a class="acount-btn" href="register.php">Create an Account</a>
						</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>

<?php  buildFooter(false); //Builds the Footer ?>
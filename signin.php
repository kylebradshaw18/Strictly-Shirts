<?php 
/**
 * This page is the sign in page where the user has to provide an email
 * and password with will bring them to the account page and set the session variable
 */
 
	// Start the session
	session_start();
	
	//Everytime we find an error add it to the string
	$errorHtml = "";
	
	//Check if we hit the submit button and are on a post back
	if(!empty($_POST)){
		require_once('Globals/globalFunctions.php'); //Page for global function
		require_once('Globals/connection.php'); //Connection Page
		//Get the results from the query (Grabs only one row)
		$results = $conn->query("SELECT `personId` FROM `people` WHERE `email` = '".$_POST["email"]."' AND `password` = ENCRYPT('".$_POST["password"]."','password')  LIMIT 1 ");
		if(!$results){ //If true then there is an error with connection or query
			$errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
		}
		//if we have a row then set the session variable for the customer id
		if($results ->num_rows > 0){
			//set the session person id variable to be used on other pages to what was returned
			$_SESSION['personId'] = $results->fetch_assoc()['personId'];
			//navigate to the users account
			header('Location: account.php');
		} else { //Query did not grab any results show alert
			$errorHtml .= addAlert("Sorry, the username/password is incorrect", "danger");
		}
	}
	require_once('Globals/buildHTML.php');
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar
?>
	 <form action="signin.php" method="post">
		<div class="account">
			<div class="container">
				<h2>Sign In</h2>
					<div class="account_grid">
						<div class="col-md-6 login-right">
							
							<!-- Alert Div -->
							<div id="registeralert"><?php echo $errorHtml; ?></div>
							
							<!--Email Section -->
							<label for="signInEmail">Email Address</label>
							<input  type="email" 
									title="Please enter your email address"
									id="signInEmail" 
									placeholder="Email Address" 
									value="<?php echo $_POST["email"];?>"
									name="email" 
									maxlength="100" 
									required> 
							<br><br>
							<!--Password Section -->
							<label for="signInPassword">Password</label>
							<input type="password" 
								   title="Please enter your password"
								   placeholder="Password"
								   id="signInPassword" 
								   name="password" 
								   maxlength="25" 
								   required> 
							
							<!--If we have time try to implement a remember me checkbox here -->
							
							<div class="word-in">
								<a class="forgot" href="#">Forgot Your Password?</a>
								<input type="submit" id="signInSubmit"value="Login">
							</div>
							
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
	</form>

<?php  buildFooter(false); //Builds the Footer ?>
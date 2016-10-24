<?php 
	// Start the session
	session_start();
	//Use this to link to the global function page
	require 'Globals/buildHTML.php';
	
	//Use this to link to the conenctions page for the database functions
	require 'Globals/connection.php';
	
	//Use this to link to the conenctions page for the database functions
	//require 'Page Functions/signin.php';
	
	//Default Error to false will show red alert when set to yes
	$error = false;
	
	//Check if we hit the submit button and are on a post back
	if(!empty($_POST)){
		//Get the results from the query (Grabs only one row)
		$results = $conn->query("SELECT `personId` FROM `people` WHERE userName = '".$_POST["email"]."' AND password = '".$_POST["password"]."'  LIMIT 1 ");
		//if we have a row then set the session variable for the customer id
		if($results ->num_rows > 0){
			//no errors
			$error = false;
			//set the session person id variable to be used on other pages to what was returned
			$_SESSION['personId'] = $results->fetch_assoc()['personId'];
			//navigate to the products.php oage
			header('Location: account.php');
		} else { //Query did not grab any results
			//Set the error to true to show the alert
			$error = true;
		}
	}
	
	buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
	buildHeader(); //Builds the Header and Navigation Bar

  /**
   * Here is where we will build the properties for the each page
   * 
   * HTML 5 is awesome instead of using jquery to check password lengths before submitting form
   * use the required keyword and it will prevent submitting form so it will make the page look more responsive
  */
?>
	 <form action="signin.php" method="post">
		<div class="account">
			<div class="container">
				<h2>Account</h2>
					<div class="account_grid">
						<div class="col-md-6 login-right">
							<form action="#" method="post">
								<?php 
								//This php tag will display an error message if the credentials do not match the ones in the database
								if($error){echo "<div class=\"alert alert-danger\"> Sorry, the username/password is incorrect </div>";}
								?>
								
								<!--Email Section -->
								<span>Email Address</span>
								<input type="email" id="signInEmail" placeholder="Email Address" 
											 value="<?php echo $_POST["email"];?>"
											 name="email" maxlength="100" required> 
								
								<br><br>
								
								<!--Password Section -->
								<span>Password</span>
								<input type="password" id="signInPassword" name="password" maxlength="25" required> 
								
								<!--If we have time try to implement a remember me checkbox here -->
								
								<div class="word-in">
									<a class="forgot" href="#">Forgot Your Password?</a>
									<input type="submit" id="signInSubmit"value="Login">
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
	</form>

<?php  buildFooter(false); //Builds the Footer ?>
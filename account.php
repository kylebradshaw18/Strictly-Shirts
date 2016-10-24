<?php 
  // Start the session
  session_start();
  //Use this to link to the global function page
  require 'Globals/buildHTML.php';

  //Use this to link to the conenctions page for the database functions
  require 'Globals/connection.php';
  
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    echo "<script src=\"Page Functions/signin.js\"></script>"; //link the javascript to show and hide submit button so we do not have to do a page refresh
    buildHeader(); //Builds the Header and Navigation Bar



    /**
    Here is where we will build the properties for the each page
    */
    ?>
    Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?>

    <form action="signin.php" method="post">
		<div class="account">
			<div class="container">
				<h2>Account</h2>
					<div class="account_grid">
						<div class="col-md-6 login-right">
							<form action="#" method="post">
			
								<span>Email Address</span>
								<input type="email" id="signInEmail" name="email"> 
			
								<span>Password</span>
								<input type="password" id="signInPassword" name="password"> 
								<div class="word-in">
									<a class="forgot" href="#">Forgot Your Password?</a>
									<input type="submit" id="signInSubmit" value="Login">
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
    
    
    
    <?php



    buildFooter(false); //Builds the Footer

    ?>
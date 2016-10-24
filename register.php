<?php 
/**
 * This page is where they can create a new account
 */
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
	//we have to do the checks before we echo out the html
	//It was giving me an error if you do this after builing the header
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
	echo " <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->";
	echo "<link rel=\"stylesheet\" href=\"https://formden.com/static/cdn/bootstrap-iso.css\" />"; 

	echo "<!-- Inline CSS based on choices in \"Settings\" tab -->";
	echo "<style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: #000000}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: #ffffff !important;} .asteriskField{color: red;}</style>";
	buildHeader(); //Builds the Header and Navigation Bar

  /**
   * Here is where we will build the properties for the each page
   * 
   * HTML 5 is awesome instead of using jquery to check password lengths before submitting form
   * use the required keyword and it will prevent submitting form so it will make the page look more responsive
  */
?>
<div class="container">
	<!-- HTML Form (wrapped in a .bootstrap-iso div) -->
	<div class="bootstrap-isor">
	 <div class="container-fluid">
	  <div class="row">
	   <div class="col-md-6 col-sm-6 col-xs-12">
	    <div class="formden_header">
	     <h2>
	      Register
	     </h2>
	     <p>
	     </p>
	    </div>
	    <form action="register.php" method="post">
	     <div class="form-group ">
	      <label class="control-label requiredField" for="name">
	       First Name
	       <span class="asteriskField">
	        *
	       </span>
	      </label>
	      <input class="form-control" id="name" name="name" placeholder="Enter First Name" type="text" required/>
	      <span class="help-block" id="hint_name">
	       Please Enter a First Name
	      </span>
	     </div>
	     <div class="form-group ">
	      <label class="control-label requiredField" for="name1">
	       Last Name
	       <span class="asteriskField">
	        *
	       </span>
	      </label>
	      <input class="form-control" id="name1" name="name1" placeholder="Enter Last Name" type="text" required/>
	      <span class="help-block" id="hint_name1">
	       Please Enter a Last Name
	      </span>
	     </div>
	     <div class="form-group ">
	      <label class="control-label requiredField" for="registerEmail">
	       Email Address
	       <span class="asteriskField">
	        *
	       </span>
	      </label>
	      <input class="form-control" id="registerEmail" name="registerEmail" placeholder="Enter Email Address" type="text" required/>
	      <span class="help-block" id="hint_registerEmail">
	       Please Enter a Valid Email Address
	      </span>
	     </div>
	     <div class="form-group">
	      <div>
	       <button class="btn btn-primary " name="submit" type="submit">
	        Submit
	       </button>
	      </div>
	     </div>
	    </form>
	   </div>
	  </div>
	 </div>
	</div>
</div>

<?php  buildFooter(false); //Builds the Footer ?>
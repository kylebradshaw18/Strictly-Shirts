<?php 
    
  // Start the session
  session_start();
  require_once('Globals/globalFunctions.php');
  require_once('Globals/connection.php');
  require_once('Globals/buildHTML.php');

  buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
  buildHeader(); //Builds the Header and Navigation Bar


  //Builds the breadcrumbs dynamically
  //$array = array( array("about.php","About Us") );
  //buildBreadCrumbs($array); ?>
  <div class="contact">
		<div class="container">
			<h3>About Us</h3>
			<p>Place introduction here in details.</p>

		</div>
	</div>
<?php buildFooter(true); //Builds the Footer ?>
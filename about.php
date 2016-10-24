<?php 
    
  // Start the session
  session_start();
    
  //Use this to link to the global function page
  require 'Globals/buildHTML.php';

  //Use this to link to the conenctions page for the database functions
  require 'Globals/connection.php';

    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar


    //Builds the breadcrumbs dynamically
    $array = array(
        array("about.php","About Us") );
    buildBreadCrumbs($array);


    /**
    Here is where we will build the properties for the each page
    */
    ?>
    <div class="contact">
			<div class="container">
				<h3>About Us</h3>
				<p>Place introduction here in details.</p>

			</div>
		</div>
	</div>
    <?php




    buildFooter(false); //Builds the Footer

    ?>
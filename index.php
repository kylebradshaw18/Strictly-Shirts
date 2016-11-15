<?php 
	// Start the session
	session_start();
	require_once('Globals/connection.php');
	
	
	require_once('Globals/buildHTML.php');
    buildHTMLHeadLinks('false');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar

    ?>
    
    
    
<?php buildFooter(true); //Builds the Footer ?>
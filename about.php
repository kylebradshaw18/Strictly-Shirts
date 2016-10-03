<?php 
    
  //Use this to link to the global function page
  require 'Globals/globalFunctions.php';

  //Use this to link to the conenctions page for the database functions
  //require 'Globals/connections.php';
//
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar


    //Builds the breadcrumbs dynamically
    //Need to put this on the other pages remove from this page
    $array = array(
        array("about.php","About Us") );
    buildBreadCrumbs($array);


    /**
    Here is where we will build the properties for the each page
    */





    buildFooter(); //Builds the Footer

    ?>
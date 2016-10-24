<?php 
  // Start the session
  session_start();
  //Use this to link to the global function page
  require 'Globals/buildHTML.php';

  //Use this to link to the conenctions page for the database functions
  require 'Globals/connection.php';
//
    buildHTMLHeadLinks('false');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar


    /**
    Here is where we will build the properties for the each page
    */
  


    buildFooter(true); //Builds the Footer

    ?>
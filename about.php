<?php 
    
  // Start the session
  session_start();
<<<<<<< HEAD
  require_once('Globals/buildHTML.php');
  buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
  buildHeader(); //Builds the Header and Navigation Bar ?>
  <div class="contact">
		<div class="container">
			<h3>About Us</h3>
			<p>Strictly Shirts was born in 2016 with a simple vision: to sell quality t-shirts online. We are a company that believes in delivering quality products to your doorstep at an affordable cost. Our website is designed to provide users with wide variety of t-shirts to choose from in various different categories. These categories include Marvel, Sports, Music, Video Games and many others. Users also have the option to place custom orders, where they can have their own design printed on a t-shirt of their choice.</p>
      <br>
      <p>We believe that the key being successful in this competitive market is through flawless user experience. Our team is dedicated to helping our user have the best online shopping experience.</p>
      <br>
      <p>For more information, please <a href="contact.php">contact us</a>.</p>
=======
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

>>>>>>> 9009bb614a53eea711efb815e82699fa78567079
		</div>
	</div>
<?php buildFooter(true); //Builds the Footer ?>
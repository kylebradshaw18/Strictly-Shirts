<?php
    //Need to start the session to use the session variable
    session_start();
    
    //Database Connection for this page
    //$htmlConn = new mysqli("localhost","strictlyShirts","strictlyShirts","strictly_shirts");

    function buildHTMLHeadLinks($autoSlider = 'true'){
        $returnString =  " <!DOCTYPE html>";
        $returnString .= " <html>";
        $returnString .= " <head>";
        $returnString .= " <title>Stictly Shirts</title>";
        $returnString .= " <link href=\"css/bootstrap-3.1.1.min.css\" rel='stylesheet' type='text/css' />";
        $returnString .= " <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->";
        $returnString .= " <script src=\"js/jquery.min.js\"></script>";
        $returnString .= " <!-- Custom Theme files -->";
        $returnString .= " <!--theme-style-->";
        $returnString .= " <link href=\"css/style.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />  ";
        $returnString .= " <!--//theme-style-->";
        $returnString .= " <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
        $returnString .= " <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
        $returnString .= " <meta name=\"keywords\" content=\"Strictly Shirts\" />";
        $returnString .= " <script type=\"application/x-javascript\"> addEventListener(\"load\", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>";
        $returnString .= " <link href='//fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>";
        $returnString .= " <link href='//fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>";
        $returnString .= " <!-- start menu -->";
        $returnString .= " <script src=\"js/bootstrap.min.js\"></script>";
        $returnString .= " <script src=\"js/simpleCart.min.js\"> </script>";
        $returnString .= " <script src=\"js/jquery.mask.js\"> </script>";
        $returnString .= " <script src=\"Globals/globalFunctionsJavascript.js\"></script>"; //Link the global javascript functions page
        $returnString .= " <!-- slide -->";
        //$returnString .= " <script src=\"js/responsiveslides.min.js\"></script>";
        /*$returnString .= " <script>";
        $returnString .= "   $(function () {";
        $returnString .= "       $(\"#slider\").responsiveSlides({";
        $returnString .= "                       auto: ".$autoSlider.",";
        $returnString .= "                       speed: 500,";
        $returnString .= "                       namespace: \"callbacks\",";
        $returnString .= "                       pager: true";
        $returnString .= "       });";
        $returnString .= "   });";
        $returnString .= " </script>";
        $returnString .= " <!-- animation-effect -->";
        $returnString .= " <link href=\"css/animate.min.css\" rel=\"stylesheet\">"; 
        $returnString .= " <script src=\"js/wow.min.js\"></script>";
        $returnString .= " <script>";
        $returnString .= " new WOW().init();";
        $returnString .= " </script>";
        $returnString .= " <!-- //animation-effect -->";
        */
        $returnString .= " <script>";
        $returnString .= "   $(document).ready(function(){ $('#loadingDiv').hide(); });";
        $returnString .= "   $(document).ajaxStart(function() { $('#loadingDiv').show();})";
        $returnString .= "              .ajaxStop(function() { $('#loadingDiv').hide();});";
        $returnString .= " </script>";
        $returnString .= " </head>";
        echo $returnString;
    }

    function buildHeader(){

        /**
        This function will build the header and navigation bar that will be displayed on almost every page

        */

        $returnString = "<body>";
        $returnString .=  "<!--header-->";
        $returnString .=  "<div id=\"loadingDiv\"></div>";
        $returnString .=  "<div class=\"header\">";
        $returnString .=  "    <div class=\"header-top\">";
        $returnString .=  "        <div class=\"container\">";
        $returnString .=  "               <div class=\"col-sm-4 logo animated wow fadeInLeft\" data-wow-delay=\".5s\">";
        $returnString .=  "                    <h1><a href=\"index.php\"><img src=\"images/logo2.png\" class=\"img-responsive\"></a></h1>";
        $returnString .=  "                </div>";
        $returnString .=  "            <div class=\"col-sm-4 world animated wow fadeInRight\" data-wow-delay=\".5s\">";
        $returnString .=  "                    <div class=\"cart box_1\">";
        $returnString .=  "                        <a href=\"checkout.php\">";
        $returnString .=  "                        <h3> <div class=\"total\">";
        $returnString .=  "                            <span class=\"simpleCart_total\"></span></div>";
        $returnString .=  "                            <img src=\"images/cart.png\" alt=\"\"/></h3>";
        $returnString .=  "                        </a>";
        $returnString .=  "                        <p><a href=\"javascript:;\" class=\"simpleCart_empty\">Empty Cart</a></p>";
        $returnString .=  "                    </div>";
        $returnString .=  "            </div>";
        //$returnString .=  "            <div class=\"col-sm-2 number animated wow fadeInRight\" data-wow-delay=\".5s\">";
        //$returnString .=  "                    <span><i class=\"glyphicon glyphicon-phone\"></i>085 596 234</span>";
        //$returnString .=  "                    <p>Call me</p>";
        //$returnString .=  "                </div>";
        $returnString .=  "            <div class=\"col-sm-2 search animated wow fadeInRight\" data-wow-delay=\".5s\">";		
        $returnString .=  "                <a class=\"play-icon popup-with-zoom-anim\" href=\"#small-dialog\"><i class=\"glyphicon glyphicon-search\"> </i> </a>";
        $returnString .=  "            </div>";
        $returnString .=  "                <div class=\"clearfix\"> </div>";
        $returnString .=  "        </div>";
        $returnString .=  "    </div>";
        $returnString .=  "        <div class=\"container\">";
        $returnString .=  "            <div class=\"head-top\">";
        $returnString .=  "            <div class=\"n-avigation\">    ";
        $returnString .=  "                <nav class=\"navbar nav_bottom\" role=\"navigation\">          ";      
        $returnString .=  "                <!-- Brand and toggle get grouped for better mobile display -->";
        $returnString .=  "                <div class=\"navbar-header nav_2\">";
        $returnString .=  "                    <button type=\"button\" class=\"navbar-toggle collapsed navbar-toggle1\" data-toggle=\"collapse\" data-target=\"#bs-megadropdown-tabs\">";
        $returnString .=  "                        <span class=\"sr-only\">Toggle navigation</span>";
        $returnString .=  "                        <span class=\"icon-bar\"></span>";
        $returnString .=  "                        <span class=\"icon-bar\"></span>";
        $returnString .=  "                        <span class=\"icon-bar\"></span>";
        $returnString .=  "                    </button>";
        $returnString .=  "                    <a class=\"navbar-brand\" href=\"#\"></a>";
        $returnString .=  "                </div> ";
        $returnString .=  "                <!-- Collect the nav links, forms, and other content for toggling -->";
        $returnString .=  "                    <div class=\"collapse navbar-collapse\" id=\"bs-megadropdown-tabs\">";
        $returnString .=  "                       <ul class=\"nav navbar-nav nav_1\">";
        $returnString .=  "                            <li><a href=\"index.php\">Home</a></li>";
        $returnString .=  "                            <li><a href=\"about.php\">About</a></li>";
        $returnString .=  "                            <li class=\"dropdown mega-dropdown active\">";
        $returnString .=  "                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Products<span class=\"caret\"></span></a>";
        $returnString .=  "                                <div class=\"dropdown-menu mega-dropdown-menu\">";
        $returnString .=  "                                    <div class=\"container-fluid\">";
        $returnString .=  "                                       <!-- Tab panes -->";
        $returnString .=  "                                        <div class=\"tab-content\">";
        $returnString .=  "                                            <div class=\"tab-pane active\" id=\"men\">";
        $returnString .=  "                                                <ul class=\"nav-list list-inline\">";
        $returnString .=  "                                                    <li><a href=\"products.php\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=All&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString .=  "                                                    <li><a href=\"categoryPage.php?id=1\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Marvel&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString .=  "                                                    <li><a href=\"categoryPage.php?id=2\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Sports&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString .=  "                                                    <li><a href=\"categoryPage.php?id=3\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Video Games&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString .=  "                                                    <li><a href=\"categoryPage.php?id=4\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Music&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString .=  "                                                    <li><a href=\"categoryPage.php?id=5\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Custom Order&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString .=  "                                                    <li><a href=\"categoryPage.php?id=6\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Memes&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString .=  "                                                </ul>";
        $returnString .=  "                                           </div>";
        $returnString .=  "                                        </div>";
        $returnString .=  "                                    </div>";
        $returnString .=  "                                    <!-- Nav tabs -->";
        $returnString .=  "                                </div>";
        $returnString .=  "                            </li>";
        
        if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])) {
            $returnString .=  "                            <li><a href=\"account.php\">Account</a></li>";
            $returnString .=  "                            <li><a href=\"logout.php\">Log Out</a></li>";
        } else { //Else show the sign in link
            $returnString .=  "                            <li><a href=\"signin.php\">Sign In</a></li>";
        }
        
        $returnString .=  "                            <li class=\"last\"><a href=\"contact.php\">Contact</a></li>";
        $returnString .=  "                        </ul>";
        $returnString .=  "                    </div><!-- /.navbar-collapse -->";
        $returnString .=  "                </nav>";
        $returnString .=  "            </div>";
                    
                        
        $returnString .=  "        <div class=\"clearfix\"> </div>";
        $returnString .=  "            <!---pop-up-box---->   ";
        $returnString .=  "                    <link href=\"css/popuo-box.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\"/>";
        $returnString .=  "                    <script src=\"js/jquery.magnific-popup.js\" type=\"text/javascript\"></script>";
        $returnString .=  "                    <!---//pop-up-box---->";
        $returnString .=  "                <div id=\"small-dialog\" class=\"mfp-hide\">";
        $returnString .=  "                <div class=\"search-top\">";
        $returnString .=  "                        <div class=\"login\">";
        $returnString .=  "                            <form action=\"#\" method=\"post\">";
        $returnString .=  "                                <input type=\"submit\" value=\"\">";
        $returnString .=  "                                <input type=\"text\" name=\"search\" value=\"Type something...\" onfocus=\"this.value = '';\" onblur=\"if (this.value == '') {this.value = '';}\">		";
        $returnString .=  "                           </form>";
        $returnString .=  "                        </div>";
        $returnString .=  "                        <p>	Shopping</p>";
        $returnString .=  "                    </div>";				
        $returnString .=  "                </div>";
        $returnString .=  "                <script>";
        $returnString .=  "                        $(document).ready(function() {";
        $returnString .=  "                        $('.popup-with-zoom-anim').magnificPopup({";
        $returnString .=  "                            type: 'inline',";
        $returnString .=  "                            fixedContentPos: false,";
        $returnString .=  "                            fixedBgPos: true,";
        $returnString .=  "                           overflowY: 'auto',";
        $returnString .=  "                            closeBtnInside: true,";
        $returnString .=  "                            preloader: false,";
        $returnString .=  "                            midClick: true,";
        $returnString .=  "                            removalDelay: 300,";
        $returnString .=  "                            mainClass: 'my-mfp-zoom-in'";
        $returnString .=  "                        });";
                                                                                                
        $returnString .=  "                        });";
        $returnString .=  "                </script>";			
        $returnString .=  "    <!---->		";
        $returnString .=  "        </div>";
        $returnString .=  "    </div>";
        $returnString .=  "</div>";

        echo $returnString;
    }


    function buildFooter($showSubscribe = false){

        /**
        This function will build the footer that will be displayed on almost every page

        */


        $returnString = "";
        $returnString .=  "<!--footer-->";
        $returnString .=  "<div class=\"footer\">";
            $returnString .=  "<div class=\"container\">";

            if($showSubscribe){
                    $returnString .=  "<div class=\"footer-top\">";
                        $returnString .=  "<div class=\"col-md-6 top-footer animated wow fadeInLeft\" data-wow-delay=\".5s\">";
                            $returnString .=  "<h3>Follow Us On</h3>";
                            $returnString .=  "<div class=\"social-icons\">";
                                $returnString .=  "<ul class=\"social\">";
                                    $returnString .=  "<li><a href=\"#\"><i></i></a> </li>";
                                    $returnString .=  "<li><a href=\"#\"><i class=\"facebook\"></i></a></li>	";
                                    $returnString .=  "<li><a href=\"#\"><i class=\"google\"></i> </a></li>";
                                    $returnString .=  "<li><a href=\"#\"><i class=\"linked\"></i> </a></li>		";				
                                $returnString .=  "</ul>";
                                    $returnString .=  "<div class=\"clearfix\"></div>";
                            $returnString .=  "</div>";
                        $returnString .=  "</div>";
                        $returnString .=  "<div class=\"col-md-6 top-footer1 animated wow fadeInRight\" data-wow-delay=\".5s\">";
                            $returnString .=  "<h3>Newsletter</h3>";
                                $returnString .=  "<form action=\"#\" method=\"post\">";
                                    $returnString .=  "<input type=\"text\" name=\"email\" value=\"\" onfocus=\"this.value='';\" onblur=\"if (this.value == '') {this.value ='';}\">";
                                    $returnString .=  "<input type=\"submit\" value=\"SUBSCRIBE\">";
                                $returnString .=  "</form>";
                        $returnString .=  "</div>";
                        $returnString .=  "<div class=\"clearfix\"> </div>	";
                    $returnString .=  "</div>	";
                //$returnString .=  "</div>";
            }

                $returnString .=  "<div class=\"footer-bottom\">";
                $returnString .=  "<div class=\"container\">";
                        $returnString .=  "<div class=\"col-md-3 footer-bottom-cate animated wow fadeInLeft\" data-wow-delay=\".5s\">";
                            $returnString .=  "<h6>Categories</h6>";
                            $returnString .=  "<ul>";
                                $returnString .=  "<li><a href=\"#\">Men Shirts</a></li>";
                                $returnString .=  "<li><a href=\"#\">Women Shirts</a></li>";
                                $returnString .=  "<li><a href=\"#\">Kids Shirts</a></li>";
                            $returnString .=  "</ul>";
                        $returnString .=  "</div>";
                        $returnString .=  "<div class=\"col-md-3 footer-bottom-cate animated wow fadeInLeft\" data-wow-delay=\".5s\">";
                            $returnString .=  "<h6>Feature Projects</h6>";
                            $returnString .=  "<ul>";
                                $returnString .=  "<li><a href=\"#\">Dignissim purus</a></li>";
                                $returnString .=  "<li><a href=\"#\">Curabitur sapien</a></li>";
                                $returnString .=  "<li><a href=\"#\">Tempus pretium</a></li>";
                            $returnString .=  "</ul>";
                        $returnString .=  "</div>";
                        $returnString .=  "<div class=\"col-md-3 footer-bottom-cate animated wow fadeInRight\" data-wow-delay=\".5s\">";
                            $returnString .=  "<h6>Top Brands</h6>";
                            $returnString .=  "<ul>";
                                $returnString .=  "<li><a href=\"#\">Tempus pretium</a></li>";
                                $returnString .=  "<li><a href=\"#\">Curabitur sapien</a></li>";
                                $returnString .=  "<li><a href=\"#\">Dignissim purus</a></li>";
                            $returnString .=  "</ul>";
                        $returnString .=  "</div>";
                        $returnString .=  "<div class=\"col-md-3 footer-bottom-cate cate-bottom animated wow fadeInRight\" data-wow-delay=\".5s\">";
                            $returnString .=  "<h6>Our Address</h6>";
                            $returnString .=  "<ul>";
                                $returnString .=  "<li><a href=\"https://www.google.com/maps/place/Marist/@41.7224565,-73.9363091,17z/data=!3m1!4b1!4m5!3m4!1s0x89dd3dfdfc580a91:0x6db18d47ff70fe6c!8m2!3d41.7224565!4d-73.9341204\"  target=\"_blank\"><i class=\"glyphicon glyphicon-map-marker\" aria-hidden=\"true\"></i>Address : 3399 North Road, Poughkeepsie, NY 12601</a></li>";
                                $returnString .=  "<li><a href=\"mailto:StrictlyShirtsMarist@gmail.com\"><i class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></i>Email : StrictlyShirtsMarist@gmail.com</a></li>";
                                $returnString .=  "<li><a href=\"tel:+1-845-575-3000\"><i class=\"glyphicon glyphicon-earphone\" aria-hidden=\"true\"></i>Phone : (845) 575-3000</a></li>";
                            $returnString .=  "</ul>";
                        $returnString .=  "</div>";
                        $returnString .=  "<div class=\"clearfix\"> </div>";
                        
                    $returnString .=  "</div>";
            $returnString .=  "</div>";
        $returnString .=  "</div>";
        $returnString .=  "<!--footer-->";
        $returnString .=  "</body>";
        $returnString .=  "</html>";

        echo $returnString;
    }
    
    
    function buildFooter1($showSubscribe = false){
    //This function will build the footer that will be displayed on almost every page ?>
                <!--Start Footer-->
                <div class="footer">
                    <div class="container">
                    
            <?php if($showSubscribe){  //Start Show Subscribe If ?>
                        <div class="footer-top">
                            <div class="col-md-6 top-footer animated wow fadeInLeft" data-wow-delay=".5s">
                                <h3>Follow Us On</h3>
                                <div class="social-icons">
                                    <ul class="social">
                                        <li><a href="#"><i></i></a> </li>
                                        <li><a href="#"><i class="facebook"></i></a></li>	
                                        <li><a href="#"><i class="google"></i> </a></li>
                                        <li><a href="#"><i class="linked"></i> </a></li>						
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                                <div class="col-md-6 top-footer1 animated wow fadeInRight" data-wow-delay=".5s">
                                    <h3>Newsletter</h3>
                                    <form action="#" method="post">
                                    <input type="text" name="email" value="" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='';}">
                                    <input type="submit" value="SUBSCRIBE">
                                    </form>
                                </div>
                                <div class="clearfix"> </div>	
                            </div>	
                        </div>
            <?php } //End Show Subscribe If ?>
                    
                    <div class="footer-bottom">
                        <div class="container">
                        <div class="col-md-3 footer-bottom-cate animated wow fadeInLeft" data-wow-delay=".5s">
                        <h6>Categories</h6>
                        <ul>
                        <li><a href="#">Men Shirts</a></li>
                        <li><a href="#">Women Shirts</a></li>
                        <li><a href="#">Kids Shirts</a></li>
                        </ul>
                        </div>
                        <div class="col-md-3 footer-bottom-cate animated wow fadeInLeft" data-wow-delay=".5s">
                        <h6>Feature Projects</h6>
                        <ul>
                        <li><a href="#">Dignissim purus</a></li>
                        <li><a href="#">Curabitur sapien</a></li>
                        <li><a href="#">Tempus pretium</a></li>
                        </ul>
                        </div>
                        <div class="col-md-3 footer-bottom-cate animated wow fadeInRight" data-wow-delay=".5s">
                        <h6>Top Brands</h6>
                        <ul>
                        <li><a href="#">Tempus pretium</a></li>
                        <li><a href="#">Curabitur sapien</a></li>
                        <li><a href="#">Dignissim purus</a></li>
                        </ul>
                        </div>
                        <div class="col-md-3 footer-bottom-cate cate-bottom animated wow fadeInRight" data-wow-delay=".5s">
                        <h6>Our Address</h6>
                        <ul>
                        <li><a href="https://www.google.com/maps/place/Marist/@41.7224565,-73.9363091,17z/data=!3m1!4b1!4m5!3m4!1s0x89dd3dfdfc580a91:0x6db18d47ff70fe6c!8m2!3d41.7224565!4d-73.9341204"  target="_blank"><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>Address : 3399 North Road, Poughkeepsie, NY 12601</a></li>
                        <li><a href="mailto:StrictlyShirtsMarist@gmail.com"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>Email : StrictlyShirtsMarist@gmail.com</a></li>
                        <li><a href="tel:+1-845-575-3000"><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>Phone : (845) 575-3000</a></li>
                        </ul>
                        </div>
                        <div class="clearfix"> </div>
                        
                        </div>
                    </div>
                </div>
                <!--End Footer-->
            </body>
        </html>

<?php }
    
    function buildBreadCrumbs(&$pageInformationArray){
        //Takes in a multi dimensional array the first is the the page location, the second is the label
        //This Function builds the breadcrumbs on every page except the home page
        if (!(Count($pageInformationArray) > 0)){
            return;
        }


        $returnString = "";
        $returnString .= "<div class=\"breadcrumbs\">";
        $returnString .= "<div class=\"container\">";
        $returnString .= "    <ol class=\"breadcrumb breadcrumb1 animated wow slideInLeft animated\" data-wow-delay=\".5s\" style=\"visibility: visible; animation-delay: 0.5s; animation-name: slideInLeft;\">";
        $returnString .= "        <li><a href=\"index.php\"><span class=\"glyphicon glyphicon-home\" aria-hidden=\"true\"></span>Home</a></li>";

        //Loop through array passed in which will create the multiple breadcrumbs
        for($index = 0; $index < Count($pageInformationArray); $index++){
            if( $index < (Count($pageInformationArray) - 1)){
                $returnString .= " <li><a href=\"". $pageInformationArray[$index][0] ."\">". $pageInformationArray[$index][1] ."</a></li>";
            } else{
                $returnString .= "<li class=\"active\">". $pageInformationArray[$index][1] ."</li>";
            }
        }

        $returnString .= "    </ol>";
        $returnString .= "</div>";
        $returnString .= "</div>";

        echo $returnString;
    }

?>
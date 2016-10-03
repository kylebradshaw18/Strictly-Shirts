<?php


    function buildHTMLHeadLinks($autoSlider = 'true'){

        $returnString = "";
        $returnString = $returnString . "<!DOCTYPE html>";
        $returnString = $returnString . "<html>";
        $returnString = $returnString . "<head>";
        $returnString = $returnString . "<title>Stictly Shirts</title>";
        $returnString = $returnString . "<link href=\"css/bootstrap-3.1.1.min.css\" rel='stylesheet' type='text/css' />";
        $returnString = $returnString . "<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->";
        $returnString = $returnString . "<script src=\"js/jquery.min.js\"></script>";
        $returnString = $returnString . "<!-- Custom Theme files -->";
        $returnString = $returnString . "<!--theme-style-->";
        $returnString = $returnString . "<link href=\"css/style.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />  ";
        $returnString = $returnString . "<!--//theme-style-->";
        $returnString = $returnString . "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
        $returnString = $returnString . "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
        $returnString = $returnString . "<meta name=\"keywords\" content=\"Strictly Shirts\" />";
        $returnString = $returnString . "<script type=\"application/x-javascript\"> addEventListener(\"load\", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>";
        $returnString = $returnString . "<link href='//fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>";
        $returnString = $returnString . "<link href='//fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>";
        $returnString = $returnString . "<!-- start menu -->";
        $returnString = $returnString . "<script src=\"js/bootstrap.min.js\"></script>";
        $returnString = $returnString . "<script src=\"js/simpleCart.min.js\"> </script>";
        $returnString = $returnString . "<!-- slide -->";
        $returnString = $returnString . "<script src=\"js/responsiveslides.min.js\"></script>";
           $returnString = $returnString . "<script>";
            $returnString = $returnString . "$(function () {";
              $returnString = $returnString . "$(\"#slider\").responsiveSlides({";
                $returnString = $returnString . "auto: ".$autoSlider.",";
                $returnString = $returnString . "speed: 500,";
                $returnString = $returnString . "namespace: \"callbacks\",";
                $returnString = $returnString . "pager: true,";
              $returnString = $returnString . "});";
            $returnString = $returnString . "});";
          $returnString = $returnString . "</script>";
          $returnString = $returnString . "<!-- animation-effect -->";
        $returnString = $returnString . "<link href=\"css/animate.min.css\" rel=\"stylesheet\">"; 
        $returnString = $returnString . "<script src=\"js/wow.min.js\"></script>";
        $returnString = $returnString . "<script>";
         $returnString = $returnString . "new WOW().init();";
        $returnString = $returnString . "</script>";
        $returnString = $returnString . "<!-- //animation-effect -->";
        $returnString = $returnString . "</head>";
        echo $returnString;
    }

    function buildHeader(){

        /**
        This function will build the header and navigation bar that will be displayed on almost every page

        */

        $returnString = "<body>";
        $returnString = $returnString .  "<!--header-->";
        $returnString = $returnString .  "<div class=\"header\">";
        $returnString = $returnString .  "    <div class=\"header-top\">";
        $returnString = $returnString .  "        <div class=\"container\">";
        $returnString = $returnString .  "               <div class=\"col-sm-4 logo animated wow fadeInLeft\" data-wow-delay=\".5s\">";
        $returnString = $returnString .  "                    <h1><a href=\"index.php\"><img src=\"images/logo2.png\" class=\"img-responsive\"></a></h1>";
        $returnString = $returnString .  "                </div>";
        $returnString = $returnString .  "            <div class=\"col-sm-4 world animated wow fadeInRight\" data-wow-delay=\".5s\">";
        $returnString = $returnString .  "                    <div class=\"cart box_1\">";
        $returnString = $returnString .  "                        <a href=\"checkout.html\">";
        $returnString = $returnString .  "                        <h3> <div class=\"total\">";
        $returnString = $returnString .  "                            <span class=\"simpleCart_total\"></span></div>";
        $returnString = $returnString .  "                            <img src=\"images/cart.png\" alt=\"\"/></h3>";
        $returnString = $returnString .  "                        </a>";
        $returnString = $returnString .  "                        <p><a href=\"javascript:;\" class=\"simpleCart_empty\">Empty Cart</a></p>";
        $returnString = $returnString .  "                    </div>";
        $returnString = $returnString .  "            </div>";
        $returnString = $returnString .  "            <div class=\"col-sm-2 number animated wow fadeInRight\" data-wow-delay=\".5s\">";
        $returnString = $returnString .  "                    <span><i class=\"glyphicon glyphicon-phone\"></i>085 596 234</span>";
        $returnString = $returnString .  "                    <p>Call me</p>";
        $returnString = $returnString .  "                </div>";
        $returnString = $returnString .  "            <div class=\"col-sm-2 search animated wow fadeInRight\" data-wow-delay=\".5s\">";		
        $returnString = $returnString .  "                <a class=\"play-icon popup-with-zoom-anim\" href=\"#small-dialog\"><i class=\"glyphicon glyphicon-search\"> </i> </a>";
        $returnString = $returnString .  "            </div>";
        $returnString = $returnString .  "                <div class=\"clearfix\"> </div>";
        $returnString = $returnString .  "        </div>";
        $returnString = $returnString .  "    </div>";
        $returnString = $returnString .  "        <div class=\"container\">";
        $returnString = $returnString .  "            <div class=\"head-top\">";
        $returnString = $returnString .  "            <div class=\"n-avigation\">    ";
        $returnString = $returnString .  "                <nav class=\"navbar nav_bottom\" role=\"navigation\">          ";      
        $returnString = $returnString .  "                <!-- Brand and toggle get grouped for better mobile display -->";
        $returnString = $returnString .  "                <div class=\"navbar-header nav_2\">";
        $returnString = $returnString .  "                    <button type=\"button\" class=\"navbar-toggle collapsed navbar-toggle1\" data-toggle=\"collapse\" data-target=\"#bs-megadropdown-tabs\">";
        $returnString = $returnString .  "                        <span class=\"sr-only\">Toggle navigation</span>";
        $returnString = $returnString .  "                        <span class=\"icon-bar\"></span>";
        $returnString = $returnString .  "                        <span class=\"icon-bar\"></span>";
        $returnString = $returnString .  "                        <span class=\"icon-bar\"></span>";
        $returnString = $returnString .  "                    </button>";
        $returnString = $returnString .  "                    <a class=\"navbar-brand\" href=\"#\"></a>";
        $returnString = $returnString .  "                </div> ";
        $returnString = $returnString .  "                <!-- Collect the nav links, forms, and other content for toggling -->";
        $returnString = $returnString .  "                    <div class=\"collapse navbar-collapse\" id=\"bs-megadropdown-tabs\">";
        $returnString = $returnString .  "                       <ul class=\"nav navbar-nav nav_1\">";
        $returnString = $returnString .  "                            <li><a href=\"index.php\">Home</a></li>";
        $returnString = $returnString .  "                            <li><a href=\"about.php\">About</a></li>";
        $returnString = $returnString .  "                            <li class=\"dropdown mega-dropdown active\">";
        $returnString = $returnString .  "                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Products<span class=\"caret\"></span></a>";
        $returnString = $returnString .  "                                <div class=\"dropdown-menu mega-dropdown-menu\">";
        $returnString = $returnString .  "                                    <div class=\"container-fluid\">";
        $returnString = $returnString .  "                                       <!-- Tab panes -->";
        $returnString = $returnString .  "                                        <div class=\"tab-content\">";
        $returnString = $returnString .  "                                            <div class=\"tab-pane active\" id=\"men\">";
        $returnString = $returnString .  "                                                <ul class=\"nav-list list-inline\">";
        $returnString = $returnString .  "                                                    <li><a href=\"products.html\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Category%201&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString = $returnString .  "                                                    <li><a href=\"products.html\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Category%202&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString = $returnString .  "                                                    <li><a href=\"products.html\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Category%203&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString = $returnString .  "                                                    <li><a href=\"products.html\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Category%204&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString = $returnString .  "                                                    <li><a href=\"products.html\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Category%205&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString = $returnString .  "                                                    <li><a href=\"products.html\"><img src=\"https://placeholdit.imgix.net/~text?txtsize=30&txt=Category%206&w=150&h=132\" class=\"img-responsive\" alt=\"\"/></a></li>";
        $returnString = $returnString .  "                                                </ul>";
        $returnString = $returnString .  "                                           </div>";
        $returnString = $returnString .  "                                        </div>";
        $returnString = $returnString .  "                                    </div>";
        $returnString = $returnString .  "                                    <!-- Nav tabs -->";
        $returnString = $returnString .  "                                </div>";
        $returnString = $returnString .  "                            </li>";
        $returnString = $returnString .  "                            <li><a href=\"account.html\">Sign In</a></li>";
        $returnString = $returnString .  "                            <li class=\"last\"><a href=\"contact.html\">Contact</a></li>";
        $returnString = $returnString .  "                        </ul>";
        $returnString = $returnString .  "                    </div><!-- /.navbar-collapse -->";
        $returnString = $returnString .  "                </nav>";
        $returnString = $returnString .  "            </div>";
                    
                        
        $returnString = $returnString .  "        <div class=\"clearfix\"> </div>";
        $returnString = $returnString .  "            <!---pop-up-box---->   ";
        $returnString = $returnString .  "                    <link href=\"css/popuo-box.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\"/>";
        $returnString = $returnString .  "                    <script src=\"js/jquery.magnific-popup.js\" type=\"text/javascript\"></script>";
        $returnString = $returnString .  "                    <!---//pop-up-box---->";
        $returnString = $returnString .  "                <div id=\"small-dialog\" class=\"mfp-hide\">";
        $returnString = $returnString .  "                <div class=\"search-top\">";
        $returnString = $returnString .  "                        <div class=\"login\">";
        $returnString = $returnString .  "                            <form action=\"#\" method=\"post\">";
        $returnString = $returnString .  "                                <input type=\"submit\" value=\"\">";
        $returnString = $returnString .  "                                <input type=\"text\" name=\"search\" value=\"Type something...\" onfocus=\"this.value = '';\" onblur=\"if (this.value == '') {this.value = '';}\">		";
        $returnString = $returnString .  "                           </form>";
        $returnString = $returnString .  "                        </div>";
        $returnString = $returnString .  "                        <p>	Shopping</p>";
        $returnString = $returnString .  "                    </div>";				
        $returnString = $returnString .  "                </div>";
        $returnString = $returnString .  "                <script>";
        $returnString = $returnString .  "                        $(document).ready(function() {";
        $returnString = $returnString .  "                        $('.popup-with-zoom-anim').magnificPopup({";
        $returnString = $returnString .  "                            type: 'inline',";
        $returnString = $returnString .  "                            fixedContentPos: false,";
        $returnString = $returnString .  "                            fixedBgPos: true,";
        $returnString = $returnString .  "                           overflowY: 'auto',";
        $returnString = $returnString .  "                            closeBtnInside: true,";
        $returnString = $returnString .  "                            preloader: false,";
        $returnString = $returnString .  "                            midClick: true,";
        $returnString = $returnString .  "                            removalDelay: 300,";
        $returnString = $returnString .  "                            mainClass: 'my-mfp-zoom-in'";
        $returnString = $returnString .  "                        });";
                                                                                                
        $returnString = $returnString .  "                        });";
        $returnString = $returnString .  "                </script>";			
        $returnString = $returnString .  "    <!---->		";
        $returnString = $returnString .  "        </div>";
        $returnString = $returnString .  "    </div>";
        $returnString = $returnString .  "</div>";

        echo $returnString;
    }


    function buildFooter(){

        /**
        This function will build the footer that will be displayed on almost every page

        */


        $returnString = "";
        $returnString = $returnString .  "<!--footer-->";
        $returnString = $returnString .  "<div class=\"footer\">";
            $returnString = $returnString .  "<div class=\"container\">";
                $returnString = $returnString .  "<div class=\"footer-top\">";
                    $returnString = $returnString .  "<div class=\"col-md-6 top-footer animated wow fadeInLeft\" data-wow-delay=\".5s\">";
                        $returnString = $returnString .  "<h3>Follow Us On</h3>";
                        $returnString = $returnString .  "<div class=\"social-icons\">";
                            $returnString = $returnString .  "<ul class=\"social\">";
                                $returnString = $returnString .  "<li><a href=\"#\"><i></i></a> </li>";
                                $returnString = $returnString .  "<li><a href=\"#\"><i class=\"facebook\"></i></a></li>	";
                                $returnString = $returnString .  "<li><a href=\"#\"><i class=\"google\"></i> </a></li>";
                                $returnString = $returnString .  "<li><a href=\"#\"><i class=\"linked\"></i> </a></li>		";				
                            $returnString = $returnString .  "</ul>";
                                $returnString = $returnString .  "<div class=\"clearfix\"></div>";
                        $returnString = $returnString .  "</div>";
                    $returnString = $returnString .  "</div>";
                    $returnString = $returnString .  "<div class=\"col-md-6 top-footer1 animated wow fadeInRight\" data-wow-delay=\".5s\">";
                        $returnString = $returnString .  "<h3>Newsletter</h3>";
                            $returnString = $returnString .  "<form action=\"#\" method=\"post\">";
                                $returnString = $returnString .  "<input type=\"text\" name=\"email\" value=\"\" onfocus=\"this.value='';\" onblur=\"if (this.value == '') {this.value ='';}\">";
                                $returnString = $returnString .  "<input type=\"submit\" value=\"SUBSCRIBE\">";
                            $returnString = $returnString .  "</form>";
                    $returnString = $returnString .  "</div>";
                    $returnString = $returnString .  "<div class=\"clearfix\"> </div>	";
                $returnString = $returnString .  "</div>	";
            $returnString = $returnString .  "</div>";
                $returnString = $returnString .  "<div class=\"footer-bottom\">";
                $returnString = $returnString .  "<div class=\"container\">";
                        $returnString = $returnString .  "<div class=\"col-md-3 footer-bottom-cate animated wow fadeInLeft\" data-wow-delay=\".5s\">";
                            $returnString = $returnString .  "<h6>Categories</h6>";
                            $returnString = $returnString .  "<ul>";
                                $returnString = $returnString .  "<li><a href=\"#\">Men Shirts</a></li>";
                                $returnString = $returnString .  "<li><a href=\"#\">Women Shirts</a></li>";
                                $returnString = $returnString .  "<li><a href=\"#\">Kids Shirts</a></li>";
                            $returnString = $returnString .  "</ul>";
                        $returnString = $returnString .  "</div>";
                        $returnString = $returnString .  "<div class=\"col-md-3 footer-bottom-cate animated wow fadeInLeft\" data-wow-delay=\".5s\">";
                            $returnString = $returnString .  "<h6>Feature Projects</h6>";
                            $returnString = $returnString .  "<ul>";
                                $returnString = $returnString .  "<li><a href=\"#\">Dignissim purus</a></li>";
                                $returnString = $returnString .  "<li><a href=\"#\">Curabitur sapien</a></li>";
                                $returnString = $returnString .  "<li><a href=\"#\">Tempus pretium</a></li>";
                            $returnString = $returnString .  "</ul>";
                        $returnString = $returnString .  "</div>";
                        $returnString = $returnString .  "<div class=\"col-md-3 footer-bottom-cate animated wow fadeInRight\" data-wow-delay=\".5s\">";
                            $returnString = $returnString .  "<h6>Top Brands</h6>";
                            $returnString = $returnString .  "<ul>";
                                $returnString = $returnString .  "<li><a href=\"#\">Tempus pretium</a></li>";
                                $returnString = $returnString .  "<li><a href=\"#\">Curabitur sapien</a></li>";
                                $returnString = $returnString .  "<li><a href=\"#\">Dignissim purus</a></li>";
                            $returnString = $returnString .  "</ul>";
                        $returnString = $returnString .  "</div>";
                        $returnString = $returnString .  "<div class=\"col-md-3 footer-bottom-cate cate-bottom animated wow fadeInRight\" data-wow-delay=\".5s\">";
                            $returnString = $returnString .  "<h6>Our Address</h6>";
                            $returnString = $returnString .  "<ul>";
                                $returnString = $returnString .  "<li><i class=\"glyphicon glyphicon-map-marker\" aria-hidden=\"true\"></i>Address : 12th Avenue, 5th block, XYZ</li>";
                                $returnString = $returnString .  "<li><i class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></i>Email : <a href=\"mailto:info@example.com\">info@example.com</a></li>";
                                $returnString = $returnString .  "<li><i class=\"glyphicon glyphicon-earphone\" aria-hidden=\"true\"></i>Phone : +1234 567 567</li>";
                            $returnString = $returnString .  "</ul>";
                        $returnString = $returnString .  "</div>";
                        $returnString = $returnString .  "<div class=\"clearfix\"> </div>";
                        
                    $returnString = $returnString .  "</div>";
            $returnString = $returnString .  "</div>";
        $returnString = $returnString .  "</div>";
        $returnString = $returnString .  "<!--footer-->";
        $returnString = $returnString .  "</body>";
        $returnString = $returnString .  "</html>";

        echo $returnString;
    }

    function buildBreadCrumbs(&$pageInformationArray){
        //Takes in a multi dimensional array the first is the 
        //This Function builds the breadcrumbs on every page except the home page
        if (!(Count($pageInformationArray) > 0)){
            return;
        }


        $returnString = "";
        $returnString = $returnString . "<div class=\"breadcrumbs\">";
        $returnString = $returnString . "<div class=\"container\">";
        $returnString = $returnString . "    <ol class=\"breadcrumb breadcrumb1 animated wow slideInLeft animated\" data-wow-delay=\".5s\" style=\"visibility: visible; animation-delay: 0.5s; animation-name: slideInLeft;\">";
        $returnString = $returnString . "        <li><a href=\"index.php\"><span class=\"glyphicon glyphicon-home\" aria-hidden=\"true\"></span>Home</a></li>";

        //Loop through array passed in which will create the multiple breadcrumbs
        for($index = 0; $index < Count($pageInformationArray); $index++){
            if( $index < (Count($pageInformationArray) - 1)){
                $returnString = $returnString . " <li><a href=\"". $pageInformationArray[$index][0] ."\">Home</a></li>";
            } else{
                $returnString = $returnString . "<li class=\"active\">". $pageInformationArray[$index][1] ."</li>";
            }
        }

        $returnString = $returnString . "    </ol>";
        $returnString = $returnString . "</div>";
        $returnString = $returnString . "</div>";

        echo $returnString;
    }

?>
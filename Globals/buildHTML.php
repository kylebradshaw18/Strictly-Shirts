<?php
    //Need to start the session to use the session variable
    session_start();
    require_once('globalFunctions.php');

    function buildHTMLHeadLinks($autoSlider = 'true'){ ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>Stictly Shirts</title>
                <link href="css/bootstrap-3.1.1.min.css" rel='stylesheet' type='text/css' />
                <script src="js/jquery.min.js"></script>
                <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />  
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="keywords" content="Strictly Shirts" />
                <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
                <link href='//fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
                <link href='//fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/simpleCart.min.js"> </script>
                <script src="js/jquery.mask.js"> </script>
                <script src="Globals/globalFunctionsJavascript.js"></script>
                <!-- Slide -->
                <script src="js/responsiveslides.min.js"></script>
                <script>
                    $(function () {
                        $("#slider").responsiveSlides({
                            auto: "<?php echo $autoSlider;?>",
                            speed: 500,
                            namespace: "callbacks",
                            pager: true
                        });
                    });
                </script>
            <?php if(1 === 0){?>
                <!-- Start Animation-Effect -->
                <link href="css/animate.min.css" rel="stylesheet"> 
                <script src="js/wow.min.js"></script>
                <script> new WOW().init(); </script>
                <!-- End Animation-Effect -->
            <?php } ?>
                <script>
                    $(document).ready(function(){ $('#loadingDiv').hide(); });
                    $(document).ajaxStart(function() { $('#loadingDiv').show();})
                               .ajaxStop(function() { $('#loadingDiv').hide();});
                </script>
            </head>
<?php }

    function buildHeader(){
        //This function will build the header and navigation bar that will be displayed on almost every page ?>

        <body>
            <!--Start Header-->
            <div id="loadingDiv"></div>
            <div class="header">
                <div class="header-top">
                    <div class="container">
                        <div class="col-sm-4 logo animated wow fadeInLeft" data-wow-delay=".5s">
                            <h1>
                                <a href="index.php">
                                    <img src="images/logo2.png" class="img-responsive">
                                </a>
                            </h1>
                        </div>
                        <div class="col-sm-4 world animated wow fadeInRight" data-wow-delay=".5s">
                            <div class="cart box_1">
                                <h3> 
                                    <div class="total">
                                <?php //Get the current total of what is in the cart
                                    $cartTotal = 0;
                                    $personId = 0;
                                    if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])){
                                        $personId = $_SESSION['personId'];
                                    }
                                    $cartTotal = getCartSum($personId);
                                ?>
                                        $ <?php echo number_format((float)$cartTotal, 2, '.', '');?>
                                    </div>
                                    <a href="cart.php">
                                        <img  src="images/cart.png" alt="View Cart"/>
                                    </a>
                                </h3>
                                <a href="checkout.php">
                                    <p>View Cart</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-2 number animated wow fadeInRight" data-wow-delay=".5s">
                            <span>
            <?php if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])){ ?>
                                <a href="logout.php" title="Log Out"><i class="glyphicon glyphicon-log-out"></i> Log Out </a>
            <?php } ?>
                            </span>
                        </div>
                        <div class="col-sm-2 search animated wow fadeInRight" data-wow-delay=".5s">		
                            <a class="play-icon popup-with-zoom-anim" href="#small-dialog">
                                <i class="glyphicon glyphicon-search"> </i> 
                            </a>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="container">
                    <div class="head-top">
                        <div class="n-avigation">    
                            <nav class="navbar nav_bottom" role="navigation">                
                                <div class="navbar-header nav_2">
                                    <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="#"></a>
                                </div> 
                                <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
                                   <ul class="nav navbar-nav nav_1">
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="about.php">About</a></li>
                                        <li class="dropdown mega-dropdown active">
                                            <a href="products.php" class="dropdown-toggle" data-toggle="dropdown">Products<span class="caret"></span></a>
                                            <div class="dropdown-menu mega-dropdown-menu">
                                                <div class="container-fluid">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="men">
                                                            <ul class="nav-list list-inline">
                                                                <li><a href="products.php"><img src="https://placeholdit.imgix.net/~text?txtsize=30&txt=All&w=150&h=132" class="img-responsive" alt="All Categories"/></a></li>
                                                                <?php //get the top 6 categories for the products page
                                                                    $globalFunctionsConn = openDBConnection();
                                                                    $results = $globalFunctionsConn->query("SELECT `category`, `categoryId` FROM `categories` WHERE `category` <> 'Custom Order'  ORDER BY `category` LIMIT 5");
                                                                    while($row = $results->fetch_assoc()) { ?>
                                                                        <li>
                                                                            <a href="products.php?category=<?php echo $row['categoryId']; ?>">
                                                                                <img src="https://placeholdit.imgix.net/~text?txtsize=30&txt=<?php echo $row['category']; ?>&w=150&h=132" class="img-responsive" alt=""/>
                                                                            </a>
                                                                        </li>
                                                                <?php } ?>
                                                            </ul>
                                                       </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
            
    <?php if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])) { ?>
                                        <li><a href="account.php">Account</a></li>
    <?php } else { //Else show the sign in link ?>
                                        <li><a href="signin.php">Sign In</a></li>
    <?php } ?>
                                        <li class="last"><a href="contact.php">Contact</a></li>
                                    </ul>
                                </div><!-- /class="collapse navbar-collapse" id="bs-megadropdown-tabs -->
                            </nav>
                        </div>
                        <div class="clearfix"> </div>
                        <!---pop-up-box---->   
                        <link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all"/>
                        <script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
                        <!---//pop-up-box---->
                        <div id="small-dialog" class="mfp-hide">
                            <div class="search-top">
                                <div class="login">
                                    <input type="text" size="60" onkeyup="showResult(this.value)" name="search" value="" placeholder="Search Something....." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}">	
                                </div>
                                <div id="showResultList" style="padding-top:2%;"></div>
                            </div>				
                        </div>
                        <script>
                            <?php //Build javascript array for the search
                                $sql  = " SELECT 'category' AS `type`, `categoryId` AS `id`, `category` AS `name` FROM `categories` WHERE `category` <> 'Custom Order' ";
                                $sql .= " UNION ";
                                $sql .= " SELECT 'design' AS `type`, `designId` AS `id`, `design` AS `name` FROM `designs` ORDER BY `type`, `name`, `id` ";
                                $searchArray = array();
                                $results = $globalFunctionsConn->query($sql);
                                while($row = $results->fetch_assoc()) { 
                                    $searchArray[] = $row;
                                }
                            ?>
                            var searchList = <?php echo json_encode($searchArray); ?>;
                            
                            $(document).ready(function() {
                                $('.popup-with-zoom-anim').magnificPopup({
                                    type: 'inline',
                                    fixedContentPos: false,
                                    fixedBgPos: true,
                                    overflowY: 'auto',
                                    closeBtnInside: true,
                                    preloader: false,
                                    midClick: true,
                                    removalDelay: 300,
                                    mainClass: 'my-mfp-zoom-in'
                                });                                                        
                            });
                            
                            function showResult(value){
                                var searchResultHtmlString = "";
                                value = value.trim().toLocaleLowerCase();
                                if(value.length > 0){
                                    //loop through searchs
                                    for(var index = 0; index < searchList.length; index++){
                                        //If they match then show it
                                        if(searchList[index].name.toLocaleLowerCase().includes(value)){
                                            searchResultHtmlString += buildSearchList(searchList[index]);
                                        }
                                    }
                                }
                                $('#showResultList').html(searchResultHtmlString);
                            }
                            
                            function buildSearchList(row){
                                return "<a href=\"products.php?"+row.type+"="+row.id+"\">"+row.name+"</a><br>";
                            }
                        </script>		
                    </div>
                </div>
            </div>
<?php }

    function buildFooter($showSubscribe = false){
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
                                        <li><a href="https://www.facebook.com/strictlyShirtsMarist/" target="_blank"><i></i></a> </li>
                                        <li><a href="#"><i class="facebook"></i></a></li>	
                                        <li><a href="#"><i class="google"></i> </a></li>
                                        <li><a href="#"><i class="linked"></i> </a></li>						
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-6 top-footer1 animated wow fadeInRight" data-wow-delay=".5s">
                                <div id="newsLetterAlert"></div>
                                <h3>Newsletter</h3>
                                <?php //if signed in get the users email address
                                    $newsLetterEmail = "";
                                    if(isset($_SESSION['personId']) && !empty($_SESSION['personId'])) {
                                        $globalFunctionsConn = openDBConnection();
                                        $results = $globalFunctionsConn->query("SELECT `email` FROM `people` WHERE `personId` = ".$_SESSION['personId']);
                                        if($results ->num_rows > 0){
                                            $newsLetterEmail = $results->fetch_assoc()['email'];
                                    	}
                                    }
                                ?>
                                <input type="email" name="email" value="<?php echo $newsLetterEmail; ?>" id="newsLetterEmail" maxlength="75" placeholder="Email Address" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='';}">
                                <input type="submit" onclick="subscribe();" value="SUBSCRIBE">
                            </div>
                            <div class="clearfix"> </div>	
                            </div>	
                        </div>
            <?php } //End Show Subscribe If ?>
                    
                    <div class="footer-bottom">
                        <div class="container text-centered">
                            <div class="col-md-2 footer-bottom-cate animated wow fadeInLeft" data-wow-delay=".5s">
                            </div>
                            <div class="col-md-3 footer-bottom-cate animated wow fadeInLeft" data-wow-delay=".5s">
                                <h6>Top Categories</h6>
                                <ul>
                                <?php //Grab the top 4 categories 
                                    $globalFunctionsConn = openDBConnection();
                                    $sql  = " SELECT COUNT(`categories`.`categoryId`) AS `total`, `categories`.`category`, `categories`.`categoryId` ";
                                    $sql .= " FROM `categories` INNER JOIN `products` ON `categories`.`categoryId` = `products`.`categoryId` ";
                                    $sql .= "                   INNER JOIN `inventory` ON `products`.`productId` = `inventory`.`productId` ";
                                    $sql .= "                   INNER JOIN `orderdetails` ON `inventory`.`inventoryId` = `orderdetails`.`inventoryId` ";
                                    $sql .= " WHERE `category` <> 'Custom Order' ";
                                    $sql .= " GROUP BY `categories`.`category`, `categories`.`categoryId` ";
                                    $sql .= " ORDER BY `total` DESC, `categories`.`category` ";
                                    $sql .= " LIMIT 4 ";
                                    $results = $globalFunctionsConn->query($sql);
                                    while($row = $results->fetch_assoc()) { 
                                ?>
                                    <li><a href="products.php?category=<?php echo $row['categoryId']; ?>"><?php echo $row['category']; ?></a></li>
                                <?php } ?>
                                </ul>
                            </div>
                            <div class="col-md-3 footer-bottom-cate animated wow fadeInRight" data-wow-delay=".5s">
                                <h6>Top Designs</h6>
                                <ul>
                                <?php //Grab the top 3 designs 
                                    $sql  = " SELECT COUNT(`designs`.`designId`) AS `total`, `designs`.`design`, `designs`.`designId` ";
                                    $sql .= " FROM `designs` INNER JOIN `products` ON `designs`.`designId` = `products`.`designId` ";
                                    $sql .= "                INNER JOIN `inventory` ON `products`.`productId` = `inventory`.`productId` ";
                                    $sql .= "                INNER JOIN `orderdetails` ON `inventory`.`inventoryId` = `orderdetails`.`inventoryId` ";
                                    $sql .= " GROUP BY `designs`.`design`, `designs`.`designId` ";
                                    $sql .= " ORDER BY `total` DESC, `designs`.`design` ";
                                    $sql .= " LIMIT 4 ";
                                    $results = $globalFunctionsConn->query($sql);
                                    while($row = $results->fetch_assoc()) { 
                                    ?>
                                        <li><a href="products.php?design=<?php echo $row['designId']; ?>"><?php echo $row['design']; ?></a></li>
                                <?php } ?>
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
                            <div class="col-md-1 footer-bottom-cate animated wow fadeInLeft" data-wow-delay=".5s">
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
        } ?>

        <div class="breadcrumbs">
            <div class="container">
                <ol class="breadcrumb breadcrumb1 animated wow slideInLeft animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: slideInLeft;">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
<?php //Loop through array passed in which will create the multiple breadcrumbs
        for($index = 0; $index < Count($pageInformationArray); $index++){
            if( $index < (Count($pageInformationArray) - 1)){ ?>
                     <li><a href="<?php echo $pageInformationArray[$index][0];?>"><?php echo $pageInformationArray[$index][1];?></a></li>
    <?php   } else{ ?>
                    <li class="active"><?php echo $pageInformationArray[$index][1];?></li>
    <?php   } 
        } ?>
                </ol>
            </div>
        </div>
<?php } ?>
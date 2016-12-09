<?php 
    // Start the session
    session_start();
    require_once('Globals/connection.php');
    require_once('Globals/buildHTML.php');
    require_once('Globals/globalFunctions.php');
    
    //Check if session variable is set  if not then go to sign in page
    if(!isset($_SESSION['personId']) || empty($_SESSION['personId'])) {
        header('Location: signin.php?navigation='.substr($_SERVER['REQUEST_URI'],1,strlen($_SERVER['REQUEST_URI']) - 1));
    }
    
    //Check if the user has anything in there cart if not then send them to the cart page
	$results = $conn->query("SELECT * FROM `carts` WHERE `personId` = ".$_SESSION['personId']);
    if($results ->num_rows < 1){
        header('Location: cart.php');
    }
	$errorHtml = "";
    if(isset($_POST['placeOrder'])){
        $addressId = $_POST['checkoutAddress'];
        $payId = $_POST['checkoutShipPriority'];
        $priorityId = $_POST['checkoutShipPriority'];
        //Check to make sure the Ids are greater than 0
		if($addressId < 1){ $errorHtml.= addAlert("Please Add An Address","danger");}
		if($payId < 1){ $errorHtml .= addAlert("Please Add A Card","danger"); }
		
		if(strlen($errorHtml) < 1){ //Passed checks so now 
		    $results = $conn->query("INSERT INTO ordersmaster (personId, addrId, payId) VALUES (".$_SESSION['personId'].", ". $addressId.", ". $payId.")");
        
            if (!$results) {
                $errorHtml .= addAlert("ERROR: Connection issue, Please call support","danger");
            } else { 
                $orderId = $conn->insert_id;
                $sql = "SELECT `inventory`.`inventoryId`, `carts`.`quantity`, `inventory`.`price` FROM `carts` INNER JOIN `inventory` ON `carts`.`inventoryId` = `inventory`.`inventoryId` WHERE `personId` = ".$_SESSION['personId'];
                
                $results = $conn->query($sql);
                //Now loop through everything in users cart and get the total price and insert into order details
                while (($row = $results->fetch_assoc()) && (strlen($errorHtml) < 1)) {
                    $total = $row["quantity"] * $row["price"];
                    $orderDetailSQL = "INSERT INTO orderdetails (orderId, inventoryId, priorityId, quantity, price) VALUES (".$orderId.", ". $row["inventoryId"].", ". $priorityId.", ".$row["quantity"]." , ". $total.")";
                    $orderDetailResults = $conn->query($orderDetailSQL);
                    //Check if there was a problem inserting
                    if (!$results) {
                        $errorHtml .= addAlert("ERROR: Connection issue, Please call support","danger");
                    } else {
                        //Delete that item from the cart
                        $cartResult = $conn->query("DELETE FROM `carts` WHERE `personId` = ".$_SESSION['personId']." AND `inventoryId` = ".$row['inventoryId']);
                        if (!$cartResult) {
                            $errorHtml .= addAlert("ERROR: Connection issue, Please call support","danger");
                        }
                    }
                }
                //No errors so go to the account page
                if(strlen($errorHtml) < 1){
                    header('Location: account.php');            
                }
            }
		}
    }
    
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar
?>
<script src="./Page Functions/checkout.js"></script>
<div class="container centerCheckOut">
    <div class="check-out centerCheckOut">
        <h2 class="cart-header">Check Out</h2>
        <!-- Check Out Alert Area -->
        <div id="checkoutAlert"><?php echo $errorHtml; ?> </div>
  
        <form class="form-horizontal" role="form" action="checkout.php" method="post" onsubmit="return validateOrderInformationForm();">                           
            <div class="form-group productsSpace">
                <label class="col-lg-3 control-label" for="checkoutShipping">Shipping Address:</label>
                <div class="col-lg-5">
                    <select class="form-control" id="checkoutAddress" name="checkoutAddress" > 
                        <?php   //Query to build priorities
                            $results = $conn->query("SELECT * FROM `addresses` WHERE personId = ".$_SESSION['personId']." AND status = 'ACTIVE' ORDER BY `isPrimaryAddress` DESC");
			                if($results ->num_rows > 0){ 
                                while($row = $results->fetch_assoc()) { ?>
                            <option value = "<?php echo $row['addrId'];?>"><?php echo $row['addressLine1']." ".$row["city"]." ".$row["state"]." ".$row["zipcode"]; ;?></option>
                        <?php }
                            } else { ?>
                                <option value = "0">Please Add An Address</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-2">
                    <button type="button" class="form-control btn btn-xs btn-primary" data-toggle="modal" data-target="#checkoutAddressModal" onclick="resetModal('address')" value="Add Address">Add Address</button>
                </div> 
            </div>
            <div class="form-group productsSpace">
                <label class="col-lg-3 control-label" for="checkoutPaymentMethod">Payment Method:</label>
                <div class="col-lg-5">
                    <select class="form-control" id="checkoutPaymentMethod" name="checkoutPaymentMethod" > 
                        <?php   //Query to build priorities
                            $results = $conn->query("SELECT payId,cardNum,type FROM `paymentmethods`WHERE personId = ".$_SESSION['personId']." AND status='ACTIVE' ORDER BY `isPrimaryPayment` DESC");
                            if($results ->num_rows > 0){ 
                                while($row = $results->fetch_assoc()) { ?>
                                    <option value = "<?php echo $row['payId'];?>"><?php echo $row['type']." ending ****".substr($row["cardNum"], -4);?></option>
                        <?php }
                            } else { ?>
                                <option value = "0">Please Add A Payment Option</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-2">
                    <button type="button" class="form-control btn btn-xs btn-primary" data-toggle="modal" data-target="#checkoutPaymentOptionsModal" onclick="resetModal('payment')" value="Add Card">Add Card</button>
                </div> 
            </div>
            <div class="form-group productsSpace">
                <label class="col-lg-3 control-label" for="checkoutShipPriority">Shipping Priority:</label>
                <div class="col-lg-5">
                    <select class="form-control" id="checkoutShipPriority" name="checkoutShipPriority" > 
                        <?php   //Query to build priorities
                            $results = $conn->query("SELECT `priorityId`,`priority` FROM `priorities` ORDER BY `priorityId`");
                            while($row = $results->fetch_assoc()) { ?>
                            <option value = "<?php echo $row['priorityId'];?>"><?php echo $row['priority'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-2"></div> 
            </div>
            <div class="form-group productsSpace">
                <div class="col-md-5"></div>
                <div class="col-md-2 col-sm-2">
                    <input type="submit" class="btn btn-success" value="Place Order" name="placeOrder">
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Address Modal -->
<!--Address Modal============================================================-->
<div id="checkoutAddressModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3>Address <span class="extra-title muted"></span></h3>
            </div>
            <div class="modal-body form-horizontal">
                
                <!--Modal Alert Area -->
                <div id="checkoutAddressModalAlert"></div>
                
                <div class="form-group">
                    <label for="checkoutModalAddresss" class="col-lg-4 control-label">Address:</label>
                    <div class="col-lg-5">
                        <input type="text" 
                               class="form-control" 
                               name="checkoutModalAddresss"
                               id="checkoutAddressModalAddress"
                               title="Enter Address"
                               placeholder="234 Main Street"
                               maxlength="75">
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalApartmentNumber" class="col-lg-4 control-label">Address Line 2:</label>
                    <div class="col-lg-5">
                        <input type="text"  
                               class="form-control" 
                               name="checkoutModalApartmentNumber"
                               id="checkoutAddressModalApartment"
                               title="Address Line 2"
                               placeholder="Apartment 42"
                               maxlength="25">
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalCity" class="col-lg-4 control-label">City:</label>
                    <div class="col-lg-5">
                        <input type="text"  
                               class="form-control" 
                               name="checkoutModalCity"
                               id="checkoutAddressModalCity"
                               title="City"
                               placeholder="Pouhgkeepsie"
                               maxlength="50">
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalState" class="col-lg-4 control-label">State:</label>
                    <div class="col-lg-5">
                        <select class="form-control" id="checkoutAddressModalState" name="checkoutModalState">
                			<option value="AK">Alaska</option>
                			<option value="AL">Alabama</option>
                			<option value="AR">Arkansas</option>
                			<option value="AZ">Arizona</option>
                			<option value="CA">California</option>
                			<option value="CO">Colorado</option>
                			<option value="CT">Connecticut</option>
                			<option value="DC">District of Columbia</option>
                			<option value="DE">Delaware</option>
                			<option value="FL">Florida</option>
                			<option value="GA">Georgia</option>
                			<option value="HI">Hawaii</option>
                			<option value="IA">Iowa</option>
                			<option value="ID">Idaho</option>
                			<option value="IL">Illinois</option>
                			<option value="IN">Indiana</option>
                			<option value="KS">Kansas</option>
                			<option value="KY">Kentucky</option>
                			<option value="LA">Louisiana</option>
                			<option value="MA">Massachusetts</option>
                			<option value="MD">Maryland</option>
                			<option value="ME">Maine</option>
                			<option value="MI">Michigan</option>
                			<option value="MN">Minnesota</option>
                			<option value="MO">Missouri</option>
                			<option value="MS">Mississippi</option>
                			<option value="MT">Montana</option>
                			<option value="NC">North Carolina</option>
                			<option value="ND">North Dakota</option>
                			<option value="NE">Nebraska</option>
                			<option value="NH">New Hampshire</option>
                			<option value="NJ">New Jersey</option>
                			<option value="NM">New Mexico</option>
                			<option value="NV">Nevada</option>
                			<option value="NY">New York</option>
                			<option value="OH">Ohio</option>
                			<option value="OK">Oklahoma</option>
                			<option value="OR">Oregon</option>
                			<option value="PA">Pennsylvania</option>
                			<option value="PR">Puerto Rico</option>
                			<option value="RI">Rhode Island</option>
                			<option value="SC">South Carolina</option>
                			<option value="SD">South Dakota</option>
                			<option value="TN">Tennessee</option>
                			<option value="TX">Texas</option>
                			<option value="UT">Utah</option>
                			<option value="VA">Virginia</option>
                			<option value="VT">Vermont</option>
                			<option value="WA">Washington</option>
                			<option value="WI">Wisconsin</option>
                			<option value="WV">West Virginia</option>
                			<option value="WY">Wyoming</option>
                		</select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalZipCode" class="col-lg-4 control-label">Zip Code:</label>
                    <div class="col-lg-5">
                        <input type="text"  
                               class="form-control" 
                               name="checkoutModalZipCode"
                               id="checkoutAddressModalZip"
                               title="Zip Code"
                               placeholder="56142"
                               maxlength="5">
                    </div>
                </div>     
                <div class="form-group">
                    <label for="checkoutModalPrimaryAddress" class="col-lg-4 control-label">Primary Address:</label>
                    <div class="col-lg-5">
                        <select class="form-control" id="checkoutAddressModalPrimaryAddress" name="checkoutModalPrimaryAddress">
                			<option value="Yes">Yes</option>
                			<option value="No">No</option>
                		</select>
                    </div>
                </div>
                
                <input type="text" id="checkoutAddressModalAddressID" disabled="disabled" value="-1" hidden>
                
            </div>
            <div class="modal-footer">
                <button href="#" class="btn btn-primary" id="checkoutModalAddressSave" onclick="checkoutModalAddress()">Submit</button>
                <button href="#" class="btn" data-dismiss="modal" id="checkoutModalAddressClose" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>

<!--Address Modal========================================================-->


<!--Payment Options Modal============================================================-->
<div id="checkoutPaymentOptionsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3>Payment <span class="extra-title muted"></span></h3>
            </div>
            <div class="modal-body form-horizontal">
                
                <!--Modal Alert Area -->
                <div id="checkoutPaymentOptionsModalAlert"></div>
                
                <div class="form-group">
                    <label for="checkoutModalNameCard" class="col-lg-4 control-label">Name on Card:</label>
                    <div class="col-lg-5">
                        <input type="text" 
                               class="form-control" 
                               name="checkoutModalNameCard"
                               id="checkoutPaymentOptionsModalNameCard"
                               title="Please enter the card holders name"
                               placeholder="Johnny Buys"
                               maxlength="45">
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalCardType" class="col-lg-4 control-label">Type:</label>
                    <div class="col-lg-5">
                        <select class="form-control" id="checkoutPaymentOptionsModalCardType" name="checkoutModalCardType">
                            <option value="American Express">American Express</option>
                			<option value="Discover">Discover</option>
                			<option value="Master Card">Master Card</option>
                			<option value="Visa">Visa</option>
                		</select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalCardNumber" class="col-lg-4 control-label">Number:</label>
                    <div class="col-lg-5">
                        <input type="text" 
                               class="form-control" 
                               name="checkoutModalCardNumber"
                               id="checkoutPaymentOptionsModalCardNumber"
                               title="Please enter the card number"
                               placeholder="564315754328155"
                               maxlength="20">
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalSecurityCode" class="col-lg-4 control-label">Security Code:</label>
                    <div class="col-lg-5">
                        <input type="text" 
                               class="form-control" 
                               name="checkoutModalSecurityCode"
                               id="checkoutPaymentOptionsModalSecurityCode"
                               title="Please enter the cards security code"
                               placeholder="5674"
                               maxlength="4">
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalExpirationMonth" class="col-lg-4 control-label">Expiration Month:</label>
                    <div class="col-lg-5">
                        <select class="form-control" id="checkoutPaymentOptionsModalExpirationMonth" name="checkoutModalExpirationMonth">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                		</select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalExpirationYear" class="col-lg-4 control-label">Expiration Year:</label>
                    <div class="col-lg-5">
                        <select class="form-control" id="checkoutPaymentOptionsModalExpirationYear" name="checkoutModalExpirationYear">
                            <?php //Expiration Year select
                                $currentYear = date("Y");
                                $startYear = $currentYear - 3;
                                $endYear = $currentYear + 5;
                            	for($year = $startYear; $year < $endYear; $year++) { //Loop through years ?>
                                    <option value="<?php echo $year;?>"><?php echo $year;?></option>
                            <?php }?>
                		</select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkoutModalPrimaryPaymentOption" class="col-lg-4 control-label">Primary Card:</label>
                    <div class="col-lg-5">
                        <select class="form-control" id="checkoutPaymentOptionsModalPrimaryPaymentOption" name="checkoutModalPrimaryPaymentOption">
                			<option value="Yes">Yes</option>
                			<option value="No">No</option>
                		</select>
                    </div>
                </div>
                <input type="text" id="checkoutPaymentOptionsModalPaymentID" disabled="disabled" value="-1" hidden>
            </div>
            <div class="modal-footer">
                <button href="#" class="btn btn-primary" id="checkoutModalUpdatePaymentOptionsSave" onclick="checkoutModalPaymentOptions()">Submit</button>
                <button href="#" class="btn" data-dismiss="modal" id="checkoutModalPaymentOptionsClose" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>
<!--Payment Options  Modal========================================================-->
<?php  buildFooter(false); //Builds the Footer ?>
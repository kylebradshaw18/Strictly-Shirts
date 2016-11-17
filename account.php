<?php 
	// Start the session
	session_start();
	
	//Check if session variable is set  if not then go to sign in page
	if(!isset($_SESSION['personId']) || empty($_SESSION['personId'])) {
		//navigate to the users account
		header('Location: signin.php');
	}
	
	//Set global variable for alerts
	$errorHtml = "";
	require_once('Globals/globalFunctions.php');
	
	//Use this to link to the connections page for the database functions
	require_once('Globals/connection.php');
	
	
	//Initialize the global variables
	$firstName;
	$lastName;
	$phone;
	$email;
	
	//Postback for the account tab
	if(isset($_POST['tabAccountDefaultSubmit'])){ //Postback Submit button was pressed check user input and update columns in people table
	    $firstname = trim($_POST["firstname"]);
		$lastname = trim($_POST["lastname"]);
		$email = trim($_POST["email"]);
		$phone = trim($_POST["phone"]);
		
		//These are the checks for the required field
		if(strlen($firstname) < 1){ $errorHtml.= addAlert("Invalid First Name","danger");} else if (strlen($firstname) > 50) {$errorHtml.= addAlert("First Name too long","danger");}
		if(strlen($lastname) < 1){ $errorHtml.= addAlert("Invalid Last Name","danger"); }  else if (strlen($lastname) > 50) {$errorHtml.= addAlert("Last Name too long","danger");}
		if(strlen($email) < 1){ $errorHtml.= addAlert("Invalid Email Address","danger"); }  else if (strlen($email) > 75) {$errorHtml.= addAlert("Email Address too long","danger");}
		if(strlen($phone) !== 14){ $errorHtml.= addAlert("Invalid Phone Number","danger"); } 
		
		//Update Row in database if no errors are found
		if(strlen(trim($errorHtml)) < 1){
		    $updateSQL =  "UPDATE `people` SET `firstName` =  '".$firstname."', `lastName` =  '".$lastname."',";
		    $updateSQL .= " `email` =  '".$email."', `phone` =  '".$phone."' WHERE `personId` = ".$_SESSION['personId'];
		    $results = $conn->query($updateSQL);
		    if(!results){ //Something Went wrong on the update
		        $errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
		    }
		}
		
	} 
	
	//Since we already updated the row now get everything from the database 
	//Not the best performance but it works and it will prevent bugs
	$results = $conn->query("SELECT `firstName`, `lastName`, `email`, `phone` FROM `people` WHERE `personId` = ".$_SESSION['personId'] ." LIMIT 1");
	if(!$results || $results ->num_rows < 1){ //Something went wrong
		$errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
	} else{
    	//Set the variables for the page
    	while($row = $results->fetch_assoc()) {
            $firstName = $row["firstName"];
            $lastName = $row["lastName"];
            $email = $row["email"];
            $phone = $row["phone"];
        }
	}
	
    //Use this to link to the global function page
	require_once('Globals/buildHTML.php');
    buildHTMLHeadLinks('true');// Builds all of the links takes in parameter for the auto slider needs to be a string
    buildHeader(); //Builds the Header and Navigation Bar
?>
<script src="./Page Functions/account.js"></script>
<div class="container">
    <div class="page-header">
        <h2>Account Information</h2>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabAccountDefault" data-toggle="tab" title="Account" onclick="removeAlerts('accountPersonalInformationTabAlert')"><i class="glyphicon glyphicon-user"></i> Account </a></li>
                        <li><a href="#tabAddressDefault" data-toggle="tab" title="Address" onclick="removeAlerts('accountAddressAlert');"><i class="glyphicon glyphicon-road"></i> Address</a></li>
                        <li><a href="#tabPaymentOptionsDefault" data-toggle="tab" title="Payment Options" onclick="removeAlerts('accountPaymentOptionsAlert');"><i class="glyphicon glyphicon-credit-card"></i> Payment Options</a></li>
                        <li><a href="#tabOrdersDefault" data-toggle="tab" title="Orders" onclick="removeAlerts('accountOrdersTabAlert')"><i class="glyphicon glyphicon-shopping-cart"></i> Orders</a></li>
                        <li><a href="#tabSubscriptionsDefault" data-toggle="tab" title="Subscriptions" onclick="removeAlerts('accountSubscriptionsAlert')"><i class="glyphicon glyphicon-heart"></i> Subscriptions</a></li>
                    </ul>
                    <ul class="nav nav-tabs navbar-right">
                        <li><a href="logout.php" title="Log Out"><i class="glyphicon glyphicon-log-out"></i> Log Out </a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <!-- Alert Area -->
                        <div id="accountalert"><?php echo $errorHtml; ?></div>


<!-- Account Tab     ================================================================================================================================= -->
                        <div class="tab-pane fade in active" id="tabAccountDefault">
                            <div class="container">
                                <div class="row">
                                    <!-- Alert Area -->
                                    <div class="col-md-11" id="accountPersonalInformationTabAlert"></div>
                                    
                                    <!-- edit form column -->
                                    <div class="col-md-12 personal-info">
                                        <h2>Personal Information</h2>
                                        <hr class="col-md-11">
                        
                                        <form class="form-horizontal" role="form" title="Edit the fields to change your information" 
                                                action="account.php" method="post" onsubmit="return validatePersonalInformationForm();">
                                            
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">First Name:</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control" 
                                                           type="text" 
                                                           value="<?php echo $firstName;?>"
                                                           name="firstname"
                                                           id="accountFirstName"
                                                           title="First Name"
                                                           placeholder="Johnny"
                                                           maxlength="50"
                                                           required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Last Name:</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control" 
                                                           type="text" 
                                                           value="<?php echo $lastName;?>"
                                                           id="accountLastName"
                                                           title="Last Name"
                                                           placeholder="Buys"
                                                           name="lastname"
                                                           maxlength="50"
                                                           required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Phone Number:</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control" 
                                                           type="tel" 
                                                           value="<?php echo $phone;?>"
                                                           id="accountPhone"
                                                           title="Phone Number"
                                                           placeholder="(877)845-3323"
                                                           name="phone"
                                                           required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Email:</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control" 
                                                           type="email" 
                                                           value="<?php echo $email;?>"
                                                           id="accountEmail"
                                                           title="Email Address"
                                                           placeholder="shirts@gmail.com"
                                                           name="email"
                                                           required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Password:</label>
                                                <div class="col-md-7">
                                                    <input type="button" class="btn btn-info" data-toggle="modal" data-target="#changePasswordModal" onclick="resetModalValues('password')" value="Change Password"/>
                                                    <span></span>
                                                    <!--<input type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal"  value="Delete Account"/>-->
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label"></label>
                                                <div class="col-md-6">
                                                    <input type="submit" class="btn btn-success" value="Update Information" name="tabAccountDefaultSubmit">
                                                    <span></span>
                                                    <input type="reset" class="btn btn-default" value="Cancel">
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--Change Password Modal============================================================-->
                        
                        <!-- Modal -->
                        <div id="changePasswordModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h3>Change Password <span class="extra-title muted"></span></h3>
                                    </div>
                                    <div class="modal-body form-horizontal">
                                        
                                        <!--Modal Alert Area -->
                                        <div id="accountChangePasswordModalAlert"></div>
                                        
                                        <div class="form-group">
                                            <label for="accountChangePasswordModalCurrentPassword" class="col-lg-4 control-label">Current Password:</label>
                                            <div class="col-lg-5">
                                                <input type="password" 
                                                       class="form-control" 
                                                       name="accountChangePasswordModalCurrentPassword"
                                                       id="accountChangePasswordModalCurrentPassword"
                                                       title="Current Password"
                                                       placeholder="Enter Password"
                                                       maxlength="25">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="accountChangePasswordModalNewPassword" class="col-lg-4 control-label">New Password</label>
                                            <div class="col-lg-5">
                                                <input type="password"  
                                                       class="form-control" 
                                                       name="accountChangePasswordModalNewPassword"
                                                       id="accountChangePasswordModalNewPassword"
                                                       title="New Password"
                                                       placeholder="Enter New Password"
                                                       maxlength="25">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="accountChangePasswordModalConfirmPassword" class="col-lg-4 control-label">Confirm Password</label>
                                            <div class="col-lg-5">
                                                <input type="password"  
                                                       class="form-control" 
                                                       name="accountChangePasswordModalConfirmPassword"
                                                       id="accountChangePasswordModalConfirmPassword"
                                                       title="Confirm New Password"
                                                       placeholder="Enter Confirm Password"
                                                       maxlength="25">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="modal-footer">
                                        <button href="#" class="btn btn-primary" onclick="updateAccountModalPasword()" id="password_modal_save">Update Password</button>
                                        <button href="#" class="btn" data-dismiss="modal" id="password_modal_close" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--End Change Password Modal========================================================-->
                        
                        
                        <!--Delete Account Modal============================================================-->
                        
                            
                            <div id="deleteAccountModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3>Delete Address <span class="extra-title muted"></span></h3>
                                        </div>
                                        <div class="modal-body form-horizontal">
                                            
                                            <!--Modal Alert Area -->
                                            <div id="accountDeleteAccountModalAlert"></div>
                                            
                                            <div class="form-group">
                                                <label for="accountDeleteAccountModalAccountID" class="col-lg-8 control-label">Are you sure you want to delete this account?</label>
                                                <div class="col-lg-2">
                                                    <input type="text" id="accountDeleteAccountModalAccountID" name="accountDeleteAccountModalAccountID" disabled="disabled" hidden>
                                                </div>
                                            </div>
                            
                                        </div>
                                        <div class="modal-footer">
                                            <button href="#" class="btn btn-danger" onclick="accountModalDeleteAccount()" id="accountModalDeleteAccountDelete"> Delete</button>
                                            <button href="#" class="btn" data-dismiss="modal" id="accountModalDeleteAccountClose" aria-hidden="true">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <!--End Delete Account Modal========================================================-->
                        
                        
<!-- End Account Tab    ================================================================================================================================= -->


<!-- Address Tab         =================================================================================================================================-->
                        <div class="tab-pane fade" id="tabAddressDefault">
                            
                            <div class="container">
                                <div class="row">
                                
                                    <div class="col-md-10 col-md-offset-1">
                            
                                        <div class="panel panel-default panel-table">
                                          <div class="panel-heading">
                                            <div class="row">
                                              <div class="col col-xs-6">
                                                <h2>Address Information</h2>
                                              </div>
                                              <div class="col col-xs-6 text-right">
                                                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#accountAddressModal" value="Add Address" title="Add Address">Add Address</button>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="panel-body">
                                            <!--Modal Alert Area -->
                                            <div id="accountAddressAlert"></div>
                                            
                                            <table class="table table-striped table-bordered table-list table-hover table-responsive" id="accountAddressTabTable">
                                              <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Zip</th>
                                                    <th>Apartment</th>
                                                    <th>Primary Address</th>
                                                </tr> 
                                              </thead>
                                              <tbody id="accountAddressTable">
                                                <?php //Address Query and table
                                                	$sql =  "SELECT `addrId`, `addressLine1`, `apartmentNumber`, `city`, `state`, `zipcode`, `isPrimaryAddress` FROM `addresses` ";
                                                    $sql .= " WHERE `personId` = ".$_SESSION['personId']. " ORDER BY `isPrimaryAddress` DESC, `state`, `city`, `zipcode`, `addressLine1`";
                                                    $results = $conn->query($sql);
                                                    
                                                    if($results ->num_rows > 0){
                                                        while($row = $results->fetch_assoc()) { //loop through addresses ?>
                                                            <tr id="actionAddressRow_<?php echo $row['addrId'];?>">
                                                                <td class="text-center">
                                                                    <input type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#accountAddressModal" value="Edit" data-id="<?php echo $row['addrId'];?>"/>
                                                                    <span> </span>
                                                                    <input type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteAddressModal" value="Delete"data-id="<?php echo $row['addrId'];?>"/>
                                                                    <span hidden><?php echo $row['addrId'];?></span>
                                                                </td>
                                                                <td name="addressColumn"><?php echo $row['addressLine1'];?></td>
                                                                <td name="cityColumn"><?php echo $row['city'];?></td>
                                                                <td name="stateColumn"><?php echo $row['state'];?></td>
                                                                <td name="zipColumn"><?php echo $row['zipcode'];?></td>
                                                                <td name="apartmentColumn"><?php echo $row['apartmentNumber'];?></td>
                                                                <?php if($row['isPrimaryAddress'] === "0"){ //If False Show Empty star?>
                                                                    <td name="primaryColumn"><i class="glyphicon glyphicon-star-empty"></i></td>
                                                                <?php } else {?>
                                                                    <td name="primaryColumn"><i class="glyphicon glyphicon-star"></i></td>
                                                                <?php } ?>
                                                            <tr>
                                                    <?php } //end of main loop
                                                	} else {  //No rows so show no rows?>
                                                	    <tr><td colspan="7" class="text-center">No Addresses Found</td></tr>
                                                <?php } //End Address Table?>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--Address Modal============================================================-->
                            
                            <div id="accountAddressModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3>Address <span class="extra-title muted"></span></h3>
                                        </div>
                                        <div class="modal-body form-horizontal">
                                            
                                            <!--Modal Alert Area -->
                                            <div id="accountAddressModalAlert"></div>
                                            
                                            <div class="form-group">
                                                <label for="accountModalAddresss" class="col-lg-4 control-label">Address:</label>
                                                <div class="col-lg-5">
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="accountModalAddresss"
                                                           id="accountAddressModalAddress"
                                                           title="Enter Address"
                                                           placeholder="234 Main Street"
                                                           maxlength="75">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="accountModalApartmentNumber" class="col-lg-4 control-label">Address Line 2:</label>
                                                <div class="col-lg-5">
                                                    <input type="text"  
                                                           class="form-control" 
                                                           name="accountModalApartmentNumber"
                                                           id="accountAddressModalApartment"
                                                           title="Address Line 2"
                                                           placeholder="Apartment 42"
                                                           maxlength="25">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="accountModalCity" class="col-lg-4 control-label">City:</label>
                                                <div class="col-lg-5">
                                                    <input type="text"  
                                                           class="form-control" 
                                                           name="accountModalCity"
                                                           id="accountAddressModalCity"
                                                           title="City"
                                                           placeholder="Pouhgkeepsie"
                                                           maxlength="50">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="accountModalState" class="col-lg-4 control-label">State:</label>
                                                <div class="col-lg-5">
                                                    <select class="form-control" id="accountAddressModalState" name="accountModalState">
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
                                                <label for="accountModalZipCode" class="col-lg-4 control-label">Zip Code:</label>
                                                <div class="col-lg-5">
                                                    <input type="text"  
                                                           class="form-control" 
                                                           name="accountModalZipCode"
                                                           id="accountAddressModalZip"
                                                           title="Zip Code"
                                                           placeholder="56142"
                                                           maxlength="5">
                                                </div>
                                            </div>     
                                            <div class="form-group">
                                                <label for="accountModalPrimaryAddress" class="col-lg-4 control-label">Primary Address:</label>
                                                <div class="col-lg-5">
                                                    <select class="form-control" id="accountAddressModalPrimaryAddress" name="accountModalPrimaryAddress">
                                            			<option value="Yes">Yes</option>
                                            			<option value="No">No</option>
                                            		</select>
                                                </div>
                                            </div>
                                            
                                            <input type="text" id="accountAddressModalAddressID" disabled="disabled" hidden>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button href="#" class="btn btn-primary" id="accountModalAddressSave" onclick="accountModalAddress()">Submit</button>
                                            <button href="#" class="btn" data-dismiss="modal" id="accountModalAddressClose" aria-hidden="true">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--Address Modal========================================================-->
                            
                            <!-- Address Delete Dialog ==============================================-->
                            
                            <div id="deleteAddressModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3>Delete Address <span class="extra-title muted"></span></h3>
                                        </div>
                                        <div class="modal-body form-horizontal">
                                            
                                            <!--Modal Alert Area -->
                                            <div id="accountDeleteAddressModalAlert"></div>
                                            
                                            <div class="form-group">
                                                <label for="accountDeleteAddressModalAddressID" class="col-lg-8 control-label">Are you sure you want to delete this address?</label>
                                                <div class="col-lg-2">
                                                    <input type="text" id="accountDeleteAddressModalAddressID" name="accountDeleteAddressModalAddressID" disabled="disabled" hidden>
                                                </div>
                                            </div>
                            
                                        </div>
                                        <div class="modal-footer">
                                            <button href="#" class="btn btn-primary" onclick="accountModalDeleteAddress()" id="accountModalDeleteAddressDelete"> Delete</button>
                                            <button href="#" class="btn" data-dismiss="modal" id="accountModalDeleteAddressClose" aria-hidden="true">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        
<!--End Address Tab===============================================================================================================================-->




<!-- Payment Information Tab=========================================================================================================================-->
                        <div class="tab-pane fade" id="tabPaymentOptionsDefault">
                            
                            <div class="container">
                                <div class="row">
                                
                                    <div class="col-md-10 col-md-offset-1">
                            
                                        <div class="panel panel-default panel-table">
                                          <div class="panel-heading">
                                            <div class="row">
                                              <div class="col col-xs-6">
                                                <h2>Payment Information</h2>
                                              </div>
                                              <div class="col col-xs-6 text-right">
                                                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#accountPaymentOptionsModal" value="Add Card" title="Add Card">Add Card</button>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="panel-body">
                                            <!--Modal Alert Area -->
                                            <div id="accountPaymentOptionsAlert"></div>
                                            
                                            <table class="table table-striped table-bordered table-list table-hover table-responsive" id="accountPaymentOptionsTabTable">
                                              <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Name On Card</th>
                                                    <th>Type</th>
                                                    <th>Card Number</th>
                                                    <th>Security Code</th>
                                                    <th>Expires</th>
                                                    <th>Primary Payment</th>
                                                </tr> 
                                              </thead>
                                              <tbody id="accountPaymentOptionsTable">
                                                <?php //Payment Options Query and table
                                                	$sql =  "SELECT `payId`, `personId`, `cardNum`, `csc`, `type`, `isPrimaryPayment`, `expirationMonth`, `expirationYear`, `nameOnCard` FROM `paymentmethods` ";
                                                    $sql .= " WHERE `personId` = ".$_SESSION['personId']. " ORDER BY `isPrimaryPayment` DESC, `type`, `expirationYear` DESC, `expirationMonth` DESC, `cardNum`";
                                                    $results = $conn->query($sql);
                                                    
                                                    if($results ->num_rows > 0){
                                                        while($row = $results->fetch_assoc()) { ?>
                                                            <tr id="actionPaymentRow_<?php echo $row['payId'];?>">
                                                                <td class="text-center" >
                                                                    <input type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#updatePaymentOptionsModal" value="Edit" data-id="<?php echo $row['payId'];?>"/>
                                                                    <span> </span>
                                                                    <input type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deletePaymentOptionsModal" value="Delete"data-id="<?php echo $row['payId'];?>"/>
                                                                    <span hidden><?php echo $row['payId'];?></span>
                                                                </td>
                                                                <td name="cardNameColumn"><?php echo $row['nameOnCard'];?></td>
                                                                <td name="cardTypeColumn"><?php echo $row['type'];?></td>
                                                                <td name="cardNumberColumn"><?php echo $row['cardNum'];?></td>
                                                                <td name="cardSecurityColumn"><?php echo $row['csc'];?></td>
                                                                <td name="cardExpirationColumn"><?php echo $row['expirationMonth']. "/" .$row['expirationYear'];?></td>
                                                                <?php if($row['isPrimaryPayment'] === "0"){ //If False Show Empty star?>
                                                                    <td name="primaryColumn"><i class="glyphicon glyphicon-star-empty"></i></td>
                                                                <?php } else { ?>
                                                                    <td name="primaryColumn"><i class="glyphicon glyphicon-star"></i></td>
                                                                <?php } ?>
                                                            <tr>
                                                    <?php } 
                                                    } else { //No Rows so show message?>
                                                        <tr><td colspan="7" class="text-center">No Cards Found</td></tr>
                                                <?php }?>
                                              </tbody>
                                            </table>
                                        
                                          </div>
                                        </div>
                            
                                    </div>
                                </div>
                            </div>
                            
                            <!--Payment Options Modal============================================================-->
                            
                            <div id="accountPaymentOptionsModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3>Payment <span class="extra-title muted"></span></h3>
                                        </div>
                                        <div class="modal-body form-horizontal">
                                            
                                            <!--Modal Alert Area -->
                                            <div id="accountPaymentOptionsModalAlert"></div>
                                            
                                            <div class="form-group">
                                                <label for="accountModalNameCard" class="col-lg-4 control-label">Name on Card:</label>
                                                <div class="col-lg-5">
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="accountModalNameCard"
                                                           id="accountPaymentOptionsModalNameCard"
                                                           title="Please enter the card holders name"
                                                           placeholder="Johnny Buys"
                                                           maxlength="45">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="accountModalCardType" class="col-lg-4 control-label">Type:</label>
                                                <div class="col-lg-5">
                                                    <select class="form-control" id="accountPaymentOptionsModalCardType" name="accountModalCardType">
                                                        <option value="American Express">American Express</option>
                                            			<option value="Discover">Discover</option>
                                            			<option value="Master Card">Master Card</option>
                                            			<option value="Visa">Visa</option>
                                            		</select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="accountModalCardNumber" class="col-lg-4 control-label">Number:</label>
                                                <div class="col-lg-5">
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="accountModalCardNumber"
                                                           id="accountPaymentOptionsModalCardNumber"
                                                           title="Please enter the card number"
                                                           placeholder="564315754328155"
                                                           maxlength="20">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="accountModalSecurityCode" class="col-lg-4 control-label">Security Code:</label>
                                                <div class="col-lg-5">
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="accountModalSecurityCode"
                                                           id="accountPaymentOptionsModalSecurityCode"
                                                           title="Please enter the cards security code"
                                                           placeholder="5674"
                                                           maxlength="4">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="accountModalExpirationMonth" class="col-lg-4 control-label">Expiration Month:</label>
                                                <div class="col-lg-5">
                                                    <select class="form-control" id="accountPaymentOptionsModalExpirationMonth" name="accountModalExpirationMonth">
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
                                                <label for="accountModalExpirationYear" class="col-lg-4 control-label">Expiration Year:</label>
                                                <div class="col-lg-5">
                                                    <select class="form-control" id="accountPaymentOptionsModalExpirationYear" name="accountModalExpirationYear">
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
                                                <label for="accountModalPrimaryPaymentOption" class="col-lg-4 control-label">Primary Card:</label>
                                                <div class="col-lg-5">
                                                    <select class="form-control" id="accountPaymentOptionsModalPrimaryPaymentOption" name="accountModalPrimaryPaymentOption">
                                            			<option value="Yes">Yes</option>
                                            			<option value="No">No</option>
                                            		</select>
                                                </div>
                                            </div>
                                            <input type="text" id="accountPaymentOptionsModalPaymentID" disabled="disabled" hidden>
                                        </div>
                                        <div class="modal-footer">
                                            <button href="#" class="btn btn-primary" id="accountModalUpdatePaymentOptionsSave" onclick="accountModalPaymentOptions()">Update Card</button>
                                            <button href="#" class="btn" data-dismiss="modal" id="accountModalPaymentOptionsClose" aria-hidden="true">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--Payment Options  Modal========================================================-->
                            
                            
                            <!-- Payment Options Delete Dialog ==============================================-->
                            
                            <div id="deletePaymentOptionsModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3>Delete Card <span class="extra-title muted"></span></h3>
                                        </div>
                                        <div class="modal-body form-horizontal">
                                            
                                            <!--Modal Alert Area -->
                                            <div id="accountDeletePaymentOptionsModalAlert"></div>
                                            
                                            <div class="form-group">
                                                <label for="accountDeletePaymentOptionsModalAddressID" class="col-lg-8 control-label">Are you sure you want to delete this card?</label>
                                                <div class="col-lg-2">
                                                    <input type="text" id="accountDeletePrimaryAddressModalAddressID" name="accountDeletePrimaryAddressModalPaymentID" disabled="disabled" hidden>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button href="#" class="btn btn-primary" onclick="accountModalDeletePaymentOptions()" id="accountModalDeletePaymentOptionsDelete"> Delete</button>
                                            <button href="#" class="btn" data-dismiss="modal" id="accountModalDeletePaymentOptionsClose" aria-hidden="true">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

<!-- End Payment Information Tab=========================================================================================================================-->



<!-- Orders Tab =========================================================================================================================-->
                        <div class="tab-pane fade" id="tabOrdersDefault">
                            <div class="container">
                                <div class="row">
                                    <!-- Alert Area -->
                                    <div class="col-md-11" id="accountOrdersTabAlert"></div>
                                    
                                    <div class="col-md-12 personal-info">
                                        <h2>Orders</h2>
                                        <hr class="col-md-11">
                                        <div class="panel-group col-md-10 col-md-offset-1" id="accountOrdersPanel">
                                        
                                        
                                            <div class="panel panel-default">  <!-- Start of Order -->
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col col-xs-4" style="padding-left:5%;">
                                                            Ref Number: 232442
                                                        </div>
                                                        <div class="col col-xs-4 text-center">
                                                            Date Ordered: 12/12/2012
                                                        </div>
                                                        <div class="col col-xs-4 text-right" style="vertical-align:middle; padding-right:5%;">
                                                            <button type="button" class="btn btn-sm btn-danger btn-create" data-toggle="modal"  onclick="setDeleteOrdersModalValues(2,'order');" data-target="#deleteOrdersModal" value="Delete Order Item" title="Delete Order">Delete Order</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                
                                                    <ul class="media-list">
                                                        <li class="media">
                                                            <div class="media-left pull-left text-center">
                                                                <img class="media-object" src="images/productsImages/1.jpg" alt="Generic placeholder image">
                                                                <button type="button" class="btn btn-sm btn-danger btn-create" data-toggle="modal" data-target="#deleteOrdersModal" onclick="setDeleteOrdersModalValues(4,'item');" value="Delete Order Item" title="Delete Item">Delete Item</button>
                                                            </div>
                                                            <div class="media-body media-bottom">
                                                                <div class="modal-body form-horizontal">
                                                                
                                                                    <div class="form-group">
                                                                        <label for="accountOrderCategory" class="col-xs-2 control-label">Category:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderCategory" name="accountOrderCategory">Strictly Shirts</div>
                                                                        </div>
                                                                        <div class="col-xs-1"></div>
                                                                        <label for="accountOrderDesign" class="col-xs-2 control-label">Design:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderDesign" name="accountOrderDesign">Special</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="accountOrderType" class="col-xs-2 control-label">Type:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderType" name="accountOrderType">V Neck</div>
                                                                        </div>
                                                                        <div class="col-xs-1"></div>
                                                                        <label for="accountOrderSize" class="col-xs-2 control-label">Size:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderSize" name="accountOrderSize">Large</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="accountOrderQuantity" class="col-xs-2 control-label">Quantity:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderQuantity" name="accountOrderQuantity">30</div>
                                                                        </div>
                                                                        <div class="col-xs-1"></div>
                                                                        <label for="accountOrderPrice" class="col-xs-2 control-label">Price:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderPrice" name="accountOrderPrice">$10.20</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <hr>
                                                        <li class="media">
                                                            <div class="media-left pull-left text-center">
                                                                <img class="media-object" src="images/productsImages/1.jpg" alt="Generic placeholder image">
                                                                <button type="button" class="btn btn-sm btn-danger btn-create" data-toggle="modal" data-target="#deleteOrdersModal" onclick="setDeleteOrdersModalValues(4,'item');" value="Delete Order Item" title="Delete Item">Delete Item</button>
                                                            </div>
                                                            <div class="media-body media-bottom">
                                                                <div class="modal-body form-horizontal">
                                                                
                                                                    <div class="form-group">
                                                                        <label for="accountOrderCategory" class="col-xs-2 control-label">Category:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderCategory" name="accountOrderCategory">Strictly Shirts</div>
                                                                        </div>
                                                                        <div class="col-xs-1"></div>
                                                                        <label for="accountOrderDesign" class="col-xs-2 control-label">Design:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderDesign" name="accountOrderDesign">Special</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="accountOrderType" class="col-xs-2 control-label">Type:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderType" name="accountOrderType">V Neck</div>
                                                                        </div>
                                                                        <div class="col-xs-1"></div>
                                                                        <label for="accountOrderSize" class="col-xs-2 control-label">Size:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderSize" name="accountOrderSize">Large</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="accountOrderQuantity" class="col-xs-2 control-label">Quantity:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderQuantity" name="accountOrderQuantity">30</div>
                                                                        </div>
                                                                        <div class="col-xs-1"></div>
                                                                        <label for="accountOrderPrice" class="col-xs-2 control-label">Price:</label>
                                                                        <div class="col-xs-3">
                                                                            <div class="list-group-item" id="accountOrderPrice" name="accountOrderPrice">$10.20</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="panel-footer text-right row text-right" style="padding-right:5%;">
                                                    Total: $10.40
                                                </div>
                                                
                                            </div>
                                            
                                            <br> <!-- End Of Order-->
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <!-- Orders Delete Dialog ==============================================-->
                                                        
                            <div id="deleteOrdersModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3>Delete Order <span class="extra-title muted"></span></h3>
                                        </div>
                                        <div class="modal-body form-horizontal">
                                            
                                            <!--Modal Alert Area -->
                                            <div id="accountDeletePaymentOptionsModalAlert"></div>
                                            
                                            <div class="form-group">
                                                <label for="accountDeleteOrderID" class="col-lg-8 control-label">Are you sure you want to delete this order?</label>
                                                <div class="col-lg-2">
                                                    <input type="text" id="accountDeleteOrderID" name="accountDeleteOrderID" disabled="disabled" hidden>
                                                </div>
                                            </div>
                                            <input type="text" id="accountDeleteOrderType" name="accountDeleteOrderType" disabled="disabled" hidden>
                                        </div>
                                        <div class="modal-footer">
                                            <button href="#" class="btn btn-primary" onclick="accountModalDeleteOrder()" id="accountModalDeleteOrderDelete"> Delete</button>
                                            <button href="#" class="btn" data-dismiss="modal" id="accountModalDeleteOrderClose" aria-hidden="true">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- END ORDERS TAB =============================================================================================================================================-->


<!-- Subscriptions Tab =============================================================================================================================================-->
                        <div class="tab-pane fade" id="tabSubscriptionsDefault">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="panel panel-default panel-table">
                                          <div class="panel-heading">
                                            <div class="row">
                                              <div class="col col-xs-6">
                                                <h2>Subscriptions</h2>
                                              </div>
                                              <div class="col col-xs-6 text-right">
                                                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#accountSubscriptionsModal" value="Add Subscription" title="Add Subscription">Add Subscription</button>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="panel-body">
                                            <!--Modal Alert Area -->
                                            <div id="accountSubscriptionsAlert"></div>
                                            
                                            <table class="table table-striped table-bordered table-list table-hover table-responsive" id="accountSubscriptionsTabTable">
                                              <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Subscription</th>
                                                    <th>Start Date</th>
                                                </tr> 
                                              </thead>
                                              <tbody id="accountSubscriptionsTable">
                                                <?php //Subscriptions Query and table
                                                	$sql =  "SELECT `category`, `subscriptionId`, DATE_FORMAT(`date`,'%m-%d-%Y') AS `date` FROM `subscriptions` INNER JOIN `categories` ON subscriptions.categoryId  = categories.categoryId ";
                                                    $sql .= " WHERE `personId` = ".$_SESSION['personId']. " ORDER BY `category`, `date`";
                                                    $results = $conn->query($sql);
                                                    
                                                    if($results ->num_rows > 0){
                                                        while($row = $results->fetch_assoc()) { //Main loop for the subscriptions table ?>
                                                            <tr id="actionSubscriptionRow_<?php echo $row['subscriptionId'];?>">
                                                                <td class="text-center" >
                                                                    <input type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteSubscriptionsModal" value="Delete"data-id="<?php echo $row['subscriptionId'];?>"/>
                                                                    <span hidden><?php echo $row['subscriptionId'];?></span>
                                                                </td>
                                                                <td name="subscriptionColumn"><?php echo $row['category'];?></td>
                                                                <td name="dateColumn"><?php echo $row['date']?></td>
                                                            <tr>
                                                    <?php }
                                                    } else { //No Rows So display the row ?>
                                                        <tr><td colspan="3" class="text-center">No Subscriptions Found</td></tr>
                                                <?php } ?>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                            <!--Delete Subscriptions Modal============================================================-->
                            <div id="accountDeleteSubscriptionsModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3>Delete Subscription <span class="extra-title muted"></span></h3>
                                        </div>
                                        <div class="modal-body form-horizontal">
                                            
                                            <!--Modal Alert Area -->
                                            <div id="accountDeleteSubscriptionsModalAlert"></div>
                                            
                                            <div class="form-group">
                                                <label for="accountDeleteSubscriptionID" class="col-lg-8 control-label">Are you sure you want to delete this subscription?</label>
                                                <div class="col-lg-2">
                                                    <input type="text" id="accountDeleteSubscriptionID" name="accountDeleteSubscriptionID" disabled="disabled" hidden>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button href="#" class="btn btn-primary" onclick="accountModalDeleteSubscription()" id="accountModalDeleteSubscriptionDelete"> Delete</button>
                                            <button href="#" class="btn" data-dismiss="modal" id="accountModalDeleteSubscriptionClose" aria-hidden="true">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <!--Subscriptions Modal============================================================-->
                            <div id="accountSubscriptionsModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3>Categories <span class="extra-title muted"></span></h3>
                                        </div>
                                        <div class="modal-body form-horizontal">
                                            
                                            <!--Modal Alert Area -->
                                            <div id="accountSubscriptionsModalAlert"></div>
                                            
                                            <div class="form-group">
                                                <label for="accountModalSubscriptionCategory" class="col-lg-4 control-label">Expiration Month:</label>
                                                <div class="col-lg-5">
                                                    <select class="form-control" id="accountSubscriptionModalSubscriptionCategory" name="accountSubscriptionModalSubscriptionCategory">
                                                        <?php //subscriptions select
                                                        	$results = $conn->query("SELECT `categoryId`, `category` FROM `categories` ORDER BY `category`");
                                                            while($row = $results->fetch_assoc()) { //Loop through categories ?>
                                                                <option value="<?php echo $row['categoryId'];?>"><?php echo $row['category'];?></option>
                                                        <?php }?>
                                            		</select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button href="#" class="btn btn-primary" id="accountModalUpdateSubscriptionsSave" onclick="accountModalSubscriptions()">Update Card</button>
                                            <button href="#" class="btn" data-dismiss="modal" id="accountModalSubscriptionsClose" aria-hidden="true">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Subscriptions  Modal========================================================-->
                        </div> 
<!-- End Subscriptions Tab ================================================================================================================================= -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php buildFooter(false); //Builds the Footer?>
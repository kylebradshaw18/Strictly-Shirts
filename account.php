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
		$updateSQL; //Use this for the query to update the user
		
		if(isset($_POST['deleteAccountValue']) && $_POST['deleteAccountValue'] == "Yes"){ 
		    $updateSQL = "UPDATE `people` SET `status` =  'DELETED' WHERE `personId` = ".$_SESSION['personId'];
		} else {
    		//These are the checks for the required field
    		if(strlen($firstname) < 1){ $errorHtml.= addAlert("Invalid First Name","danger");} else if (strlen($firstname) > 50) {$errorHtml.= addAlert("First Name too long","danger");}
    		if(strlen($lastname) < 1){ $errorHtml.= addAlert("Invalid Last Name","danger"); }  else if (strlen($lastname) > 50) {$errorHtml.= addAlert("Last Name too long","danger");}
    		if(strlen($email) < 1){ $errorHtml.= addAlert("Invalid Email Address","danger"); }  else if (strlen($email) > 75) {$errorHtml.= addAlert("Email Address too long","danger");}
    		if(strlen($phone) !== 14){ $errorHtml.= addAlert("Invalid Phone Number","danger"); } 
    		
    		//Want to have a distinct email address so check before updating row
    		$results = $conn->query("SELECT * FROM `people` WHERE `email` = '".$email."' AND `email` <> (SELECT `email` FROM `people` WHERE `personId` = ".$_SESSION['personId'].")");
		    if($results ->num_rows > 0){
		        $errorHtml.= addAlert("Sorry that email address is already taken", "danger");
		    }
    		
    		//Set the update script
    		$updateSQL =  "UPDATE `people` SET `firstName` =  '".$firstname."', `lastName` =  '".$lastname."',";
		    $updateSQL .= " `email` =  '".$email."', `phone` =  '".$phone."' WHERE `personId` = ".$_SESSION['personId'];
		}
		
		//Update Row in database if no errors are found
		if(strlen(trim($errorHtml)) < 1){
		    $results = $conn->query($updateSQL);
		    if(!$results){ //Something Went wrong on the update
		        $errorHtml.= addAlert("ERROR: Connection issue, Please call support","danger");
		    }
		}
	} 
	
	//Since we already updated the row now get everything from the database 
	//Not the best performance but it works and it will prevent bugs
	$results = $conn->query("SELECT `firstName`, `lastName`, `email`, `phone` FROM `people` WHERE `personId` = ".$_SESSION['personId'] ." AND `status` = 'ACTIVE' LIMIT 1");
	if(!$results || $results ->num_rows < 1){ //Something went wrong
		//User Deleted the account send them back to the sign in page
	    header('Location: logout.php');
	} else{
	    while($row = $results->fetch_assoc()){
        	//Set the variables for the page
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
                                                        <span> </span>
                                                        <input type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal"  value="Delete Account"/>
                                                    </div>
                                                </div>
                                                <input type="password"  id="deleteAccountValue" name="deleteAccountValue" value="No" hidden>
                                                
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"></label>
                                                    <div class="col-md-6">
                                                        <!-- name="tabAccountDefaultSubmit" id="tabAccountDefaultSubmit"-->
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
                                            <div class="form-group">
                                                <label for="accountDeleteAccountModalAccountID" class="col-lg-8 control-label">Are you sure you want to delete this account?</label>
                                                <div class="col-lg-2">
                                                    <input type="text" id="accountDeleteAccountModalAccountID" name="accountDeleteAccountModalAccountID" disabled="disabled" hidden>
                                                </div>
                                            </div>
                            
                                        </div>
                                        <div class="modal-footer">
                                            <button href="#" class="btn btn-danger" onclick="deleteAccount()" id="accountModalDeleteAccountDelete"> Delete</button>
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
                                                        $sql .= " WHERE `personId` = ".$_SESSION['personId']." AND `status` = 'ACTIVE' ORDER BY `isPrimaryAddress` DESC, `state`, `city`, `zipcode`, `addressLine1`";
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
                                                        $sql .= " WHERE `personId` = ".$_SESSION['personId']." AND `status` = 'ACTIVE' ORDER BY `isPrimaryPayment` DESC, `type`, `expirationYear` DESC, `expirationMonth` DESC, `cardNum`";
                                                        $results = $conn->query($sql);
                                                        
                                                        if($results ->num_rows > 0){
                                                            while($row = $results->fetch_assoc()) { ?>
                                                                <tr id="actionPaymentRow_<?php echo $row['payId'];?>">
                                                                    <td class="text-center" >
                                                                        <input type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#accountPaymentOptionsModal" value="Edit" data-id="<?php echo $row['payId'];?>"/>
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
                                                <button href="#" class="btn btn-primary" id="accountModalUpdatePaymentOptionsSave" onclick="accountModalPaymentOptions()">Submit</button>
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
                                            
                                                <?php //Order Information
                                                
                                                    /**
                                                     * Break Down of this area
                                                     * 
                                                     * First loop through ordersmaster 
                                                     * Then get the minimum shipping date from the query
                                                     * And Loop through the order details
                                                     */
                                                                 
                                                    //Main Sql Statement
                                                    $mainSql =  " SELECT `orderId`, DATE_FORMAT(`date`,'%m/%d/%Y') AS `date`,   ";
                                                    $mainSql .= "         `cardNum`, `type`, `addressLine1`, `apartmentNumber`, `city`, `state`, `zipcode` "; 
                                                    $mainSql .= " FROM  `ordersmaster` INNER JOIN `addresses` ON `ordersmaster`.`addrId` = `addresses`.`addrId` "; 
                                                    $mainSql .= "                      INNER JOIN `paymentmethods` ON `ordersmaster`.`payId` = `paymentmethods`.`payId` "; 
                                                    $mainSql .= " WHERE  `ordersmaster`.`personId` = ".$_SESSION['personId'];
                                                    $mainSql .= " ORDER BY  `orderId` DESC ";
                                                    
                                                    $mainResults = $conn->query($mainSql);
                                                    if($mainResults ->num_rows > 0){ //Num of Rows
                                                        while($mainSqlRow = $mainResults->fetch_assoc()) {  
                                                        
                                                            //Need to get the min ship date need to run another query
                                                            $minShipDateQuery  = " SELECT MIN(`mindays`) AS `minShip` ";
                                                            $minShipDateQuery .= " FROM (SELECT CASE WHEN `priority` = 'First Class' THEN 1 WHEN `priority` = 'Standard' THEN 5 ELSE 2 END AS `mindays` ";
                                                            $minShipDateQuery .= "     	 FROM `priorities` INNER JOIN `orderdetails` ON `priorities`.`priorityId` = `orderdetails`.`priorityId` ";
                                                            $minShipDateQuery .= "       WHERE `orderId` = ".$mainSqlRow['orderId'].") AS `t` " ;
                                                            
                                                            $minShipDateResults = $conn->query($minShipDateQuery);
                                                    		$minShipDate = $minShipDateResults->fetch_assoc()['minShip'];
                                                        ?>
                                                                <div class="panel panel-default">  <!-- Start of Order -->
                                                                    <div class="panel-heading form-horizontal" style="padding-bottom:1%;">
                                                                        <div class="row">
                                                                            <div class="col col-xs-4 text-left" style="padding-left:5%;">
                                                                                <label for="accountOrderNumberPanelHeading" class="control-label">Ref Number:</label>
                                                                                <span id="accountOrderNumberPanelHeading" name="accountOrderNumberPanelHeading"><?php echo $mainSqlRow['orderId'];?></span>
                                                                            </div>
                                                                            <div class="col col-xs-4 text-center">
                                                                                <label for="accountOrderDatePanelHeading" class="control-label">Date Ordered:</label>
                                                                                <span id="accountOrderDatePanelHeading" name="accountOrderDatePanelHeading"><?php echo $mainSqlRow['date'];?></span>
                                                                            </div>
                                                                            <div class="col col-xs-4 text-right" style="padding-right:5%;">
                                                                                <?php //Check date to show or hide the button to delete the order (shipping)
                                                                                    if(floor(abs(time() - strtotime($mainSqlRow['date'])) / (60 * 60 * 24)) <= $minShipDate){ ?>
                                                                                <button type="button" class="btn btn-sm btn-danger btn-create" data-toggle="modal"  onclick="setDeleteOrdersModalValues(<?php echo $mainSqlRow['orderId'];?>, -1);" data-target="#deleteOrdersModal" value="Delete Order Item" title="Delete Order">Delete Order</button>
                                                                                <?php } //end if ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <ul class="media-list">
                                                            <?php //Start of inner loop 
                                                            
                                                                $sumOfTotal = 0.00;
                                                                $originalShippingCost = 0;
                                                            
                                                                $innerSql =  " SELECT `products`.`productId`, `orderdetails`.`quantity`, `designs`.`design`, `orderdetails`.`price`, `categories`.`category`, `types`.`type`, `sizes`.`size`, `priorities`.`price` AS `shippingCost`, ";
                                                                $innerSql .= "        `priorities`.`priority` AS `shipping`, `inventory`.`inventoryId`, DATE_FORMAT(`ordersmaster`.`date`,'%m/%d/%Y') AS `date`,  ";
                                                                $innerSql .= "              CASE ";
                                                                $innerSql .= "                   WHEN `priority` = 'First Class' THEN 1";
                                                                $innerSql .= "                   WHEN `priority` = 'Standard' THEN 5";
                                                                $innerSql .= "                   ELSE 2 ";
                                                                $innerSql .= "             END AS `minDays` ";
                                                                $innerSql .= " FROM  `orderdetails` INNER JOIN  `inventory` ON  `orderdetails`.`inventoryId` =  `inventory`.`inventoryId` ";
                                                                $innerSql .= "                      INNER JOIN  `products` ON  `inventory`.`productId` =  `products`.`productId` ";
                                                                $innerSql .= "                      INNER JOIN  `designs` ON  `products`.`designId` =  `designs`.`designId` ";
                                                                $innerSql .= "                      INNER JOIN  `categories` ON  `products`.`categoryId` =  `categories`.`categoryId` ";
                                                                $innerSql .= "                      INNER JOIN  `sizes` ON  `inventory`.`sizeId` =  `sizes`.`sizeId` ";
                                                                $innerSql .= "                      INNER JOIN  `colors` ON  `inventory`.`colorId` =  `colors`.`colorId` ";
                                                                $innerSql .= "                      INNER JOIN  `types` ON  `inventory`.`typeId` =  `types`.`typeId` ";
                                                                $innerSql .= "                      INNER JOIN  `priorities` ON `priorities`.`priorityId` = `orderdetails`.`priorityId`";
                                                                $innerSql .= "                      INNER JOIN  `ordersmaster` ON `orderdetails`.`orderId` = `ordersmaster`.`orderId`";
                                                                $innerSql .= " WHERE  `orderdetails`.`orderId` = ".$mainSqlRow['orderId'];
                                                                $innerSql .= " ORDER BY `minDays` DESC, `productId` DESC ";
                                                                
                                                                $innerResults = $conn->query($innerSql);
                                                                //loop through results
                                                                while($innerSqlRow = $innerResults->fetch_assoc()) {  
                                                                    //Increment the sum
                                                                    $sumOfTotal += ($innerSqlRow['price'] * $innerSqlRow['quantity']);
                                                                    
                                                                    //If shipping cost does not equal the original then add it
                                                                    if($originalShippingCost !== $innerSqlRow['shippingCost']){
                                                                        $sumOfTotal += $innerSqlRow['shippingCost'];
                                                                    }
                                                                ?>
                                                                            <li class="media">
                                                                                <div class="media-left pull-left text-center">
                                                                                    <img class="media-object" src="images/productsImages/<?php echo $innerSqlRow['productId'];?>.jpg" alt="<?php echo $innerSqlRow['design'];?>">
                                                                                    <?php //Check date to show or hide the button to delete the order (shipping)
                                                                                        if(floor(abs(time() - strtotime($innerSqlRow['date'])) / (60 * 60 * 24)) <= $innerSqlRow['minDays']){  ?>
                                                                                    <button type="button" class="btn btn-sm btn-danger btn-create" data-toggle="modal" data-target="#deleteOrdersModal" onclick="setDeleteOrdersModalValues(<?php echo $mainSqlRow['orderId'];?>,<?php echo $innerSqlRow['inventoryId'];?>);" value="Delete Order Item" title="Delete Item">Delete Item</button>
                                                                                    <?php } //end if ?>
                                                                                </div>
                                                                                <div class="media-body media-bottom">
                                                                                    <div class="modal-body form-horizontal">
                                                                                        <div class="form-group">
                                                                                            <label for="accountOrderCategory" class="col-xs-2 control-label">Category:</label>
                                                                                            <div class="col-xs-3">
                                                                                                <div class="list-group-item" id="accountOrderCategory" name="accountOrderCategory"><?php echo $innerSqlRow['category'];?></div>
                                                                                            </div>
                                                                                            <div class="col-xs-1"></div>
                                                                                            <label for="accountOrderDesign" class="col-xs-3 control-label">Design:</label>
                                                                                            <div class="col-xs-3">
                                                                                                <div class="list-group-item" id="accountOrderDesign" name="accountOrderDesign"><?php echo $innerSqlRow['design'];?></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="accountOrderType" class="col-xs-2 control-label">Type:</label>
                                                                                            <div class="col-xs-3">
                                                                                                <div class="list-group-item" id="accountOrderType" name="accountOrderType"><?php echo $innerSqlRow['type'];?></div>
                                                                                            </div>
                                                                                            <div class="col-xs-1"></div>
                                                                                            <label for="accountOrderSize" class="col-xs-3 control-label">Size:</label>
                                                                                            <div class="col-xs-3">
                                                                                                <div class="list-group-item" id="accountOrderSize" name="accountOrderSize"><?php echo $innerSqlRow['size'];?></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="accountOrderQuantity" class="col-xs-2 control-label">Quantity:</label>
                                                                                            <div class="col-xs-3">
                                                                                                <div class="list-group-item" id="accountOrderQuantity" name="accountOrderQuantity"><?php echo $innerSqlRow['quantity'];?></div>
                                                                                            </div>
                                                                                            <div class="col-xs-1"></div>
                                                                                            <label for="accountOrderPrice" class="col-xs-3 control-label">Price:</label>
                                                                                            <div class="col-xs-3">
                                                                                                <div class="list-group-item" id="accountOrderPrice" name="accountOrderPrice">$<?php echo number_format((float)$innerSqlRow['price'], 2, '.', '');?></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="accountOrderPrice" class="col-xs-2 control-label">Shipping:</label>
                                                                                            <div class="col-xs-3">
                                                                                                <div class="list-group-item" id="accountOrderPrice" name="accountOrderPrice"><?php echo $innerSqlRow['shipping'];?></div>
                                                                                            </div>
                                                                                            <div class="col-xs-1"></div>
                                                                                            <label for="accountOrderShipping" class="col-xs-3 control-label">Shipping Cost:</label>
                                                                                            <div class="col-xs-3">
                                                                                                <div class="list-group-item" id="accountOrderShipping" name="accountOrderShipping">$<?php echo number_format((float)$innerSqlRow['shippingCost'], 2, '.', '');?></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                            <hr>
                                                            <?php  } //End of $innerSqlRow = $innerResults->fetch_assoc() ?>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="panel-footer form-horizontal text-right row" style="padding-right:5%;padding-top:2%;">
                                                                        <div class="form-group text-center">
                                                                            <label for="accountOrderAddress" class="col-xs-3 control-label">Shipping Address:</label>
                                                                            <div class="col-xs-3">
                                                                                <div class="list-group-item" id="accountOrderAddress" name="accountOrderAddress"><?php echo $mainSqlRow['addressLine1'] ." ".$mainSqlRow['apartmentNumber'];?> <br><?php echo $mainSqlRow['city'] .", ".$mainSqlRow['state']." ".$mainSqlRow['zipcode'];?></div>
                                                                            </div>
                                                                            <label for="accountOrderPaymentOption" class="col-xs-3 control-label">Payment Option:</label>
                                                                            <div class="col-xs-3">
                                                                                <div class="list-group-item" id="accountOrderPaymentOption" name="accountOrderPaymentOption"><?php echo $mainSqlRow['type'];?> <br><?php echo maskCard($mainSqlRow['cardNum']);?></div>
                                                                            </div>
                                                                        </div>
                                                                        <label for="accountOrderTotalPanelFooter" class="control-label">Total:</label>
                                                                        <span id="accountOrderTotalPanelFooter" name="accountOrderTotalPanelFooter">$<?php echo number_format((float)$sumOfTotal, 2, '.', '');?></span>
                                                                    </div>
                                                                </div>
                                                                <br> <!-- End Of Order-->
                                                        <?php } //end while $mainSqlRow = $mainResults->fetch_assoc()
                                                    } else { //Num of rows ?>
                                                        <br><div class="text-center"><h3>No Orders Found<hr style="width:25%;"></h3></div>
                                                    <?php } //Num of rows ?>
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
                                                <div id="accountDeleteOrdersModalAlert"></div>
                                                
                                                <div class="form-group">
                                                    <label for="accountDeleteOrderID" class="col-lg-8 control-label">Are you sure you want to delete this <span id="accountDeleteOrderItem">order</span>?</label>
                                                    <div class="col-lg-2">
                                                        <input type="text" id="accountDeleteOrderID" name="accountDeleteOrderID" disabled="disabled" hidden>
                                                    </div>
                                                </div>
                                                <input type="text" id="accountDeleteOrderInventoryId" name="accountDeleteOrderInventoryId" disabled="disabled" hidden>
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
                                                        <th>Address</th>
                                                        <th>Start Date</th>
                                                    </tr> 
                                                  </thead>
                                                  <tbody id="accountSubscriptionsTable">
                                                    <?php //Subscriptions Query and table
                                                    	$sql =  "SELECT `category`, `categories`.`categoryId`, `subscriptionId`, DATE_FORMAT(`date`,'%m/%d/%Y') AS `date`, ";
                                                    	$sql .= " addresses.addrId, `addressLine1`, `city`, `state`, `zipcode`";
                                                    	$sql .= " FROM `subscriptions` INNER JOIN `categories` ON `subscriptions`.`categoryId`  = `categories`.`categoryId` ";
                                                    	$sql .= " INNER JOIN `addresses`  ON `subscriptions`.`addrId`  = `addresses`.`addrId` ";
                                                        $sql .= " WHERE `subscriptions`.`personId` = ".$_SESSION['personId'];
                                                        $sql .= " AND `addresses`.`status` = 'ACTIVE'";
                                                        $sql .= " AND `category` <> 'Custom Order'";
                                                        $sql .= " ORDER BY `category`, `date`";
                                                        $results = $conn->query($sql);
                                                        
                                                        if($results ->num_rows > 0){
                                                            while($row = $results->fetch_assoc()) { //Main loop for the subscriptions table ?>
                                                                <tr id="actionSubscriptionRow_<?php echo $row['subscriptionId'];?>">
                                                                    <td class="text-center" >
                                                                        <input type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#accountSubscriptionsModal" value="Edit" data-id="<?php echo $row['subscriptionId'];?>"/>
                                                                        <span> </span>
                                                                        <input type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#accountDeleteSubscriptionsModal" value="Delete" data-id="<?php echo $row['subscriptionId'];?>"/>
                                                                        <span hidden><?php echo $row['subscriptionId'];?></span>
                                                                    </td>
                                                                    <td name="subscriptionColumn"><?php echo $row['category'];?></td>
                                                                    <td name="addressColumn"><?php echo $row['addressLine1'];?><br><?php echo $row['city']. ", ".$row['state']. " " .$row['zipcode'];?>
                                                                        <span hidden><?php echo $row['addrId'];?></span>
                                                                    </td>
                                                                    <td name="dateColumn"><?php echo $row['date']?></td>
                                                                <tr>
                                                        <?php }
                                                        } else { //No Rows So display the row ?>
                                                            <tr><td colspan="4" class="text-center">No Subscriptions Found</td></tr>
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
                                                <button href="#" class="btn btn-primary" onclick="accountModalDeleteSubscription()" id="accountModalDeleteSubscriptionDelete">Delete</button>
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
                                                
                                                <!-- Depending on which button add or edit either show the select of the categories or a list object of the category -->
                                                <div class="form-group" id="accountSubscriptionsModalCategorySelectShow"> 
                                                    <label for="accountSubscriptionModalSubscriptionCategorySelect" class="col-lg-4 control-label">Category:</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" id="accountSubscriptionModalSubscriptionCategorySelect" name="accountSubscriptionModalSubscriptionCategorySelect">
                                                            <?php //subscriptions select
                                                            	$results = $conn->query("SELECT `categoryId`, `category` FROM `categories` WHERE category <> 'Custom Order' ORDER BY `category`");
                                                                while($row = $results->fetch_assoc()) { //Loop through categories ?>
                                                                    <option value="<?php echo $row['categoryId'];?>"><?php echo $row['category'];?></option>
                                                            <?php }?>
                                                		</select>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="accountSubscriptionsModalCategorySingleShow"> 
                                                    <label for="accountSubscriptionModalSubscriptionCategorySingle" class="col-lg-4 control-label">Category:</label>
                                                    <div class="col-lg-6">
                                                        <div class="list-group-item" id="accountSubscriptionModalSubscriptionCategorySingle" name="accountSubscriptionModalSubscriptionCategorySingle">Sports</div>
                                                    </div>
                                                </div>
                                                <div class="form-group"> 
                                                    <label for="accountSubscriptionModalSubscriptionAddress" class="col-lg-4 control-label">Address:</label>
                                                    <div class="col-lg-6" id="accountSubscriptionsModalAddressSelect">
                                                        <select class="form-control" id="accountSubscriptionModalSubscriptionAddress" name="accountSubscriptionModalSubscriptionAddress">
                                                            <?php //address select
                                                            	$results = $conn->query("SELECT `addrId`, `addressLine1`, `city`, `state`, `zipcode`, `isPrimaryAddress` FROM `addresses` WHERE `status` = 'ACTIVE' AND `personId` = ". $_SESSION['personId'] ." ORDER BY `isPrimaryAddress` DESC, `state`, `city`, `zipcode`");
                                                                while($row = $results->fetch_assoc()) { //Loop through categories ?>
                                                                    <option value="<?php echo $row['addrId'];?>"><?php echo $row['addressLine1']."  ".$row['city']. ",  ".$row['state']. "  " .$row['zipcode'];?></option>
                                                            <?php }?>
                                                		</select>
                                                    </div>
                                                </div>
                                                <input type="text" id="accountSubscriptionModalSubscriptionId" name="accountSubscriptionModalSubscriptionId" disabled="disabled" hidden>
                                            </div>
                                            <div class="modal-footer">
                                                <button href="#" class="btn btn-primary" id="accountModalUpdateSubscriptionsSave" onclick="accountModalSubscriptions()">Submit</button>
                                                <button href="#" class="btn" data-dismiss="modal" id="accountModalSubscriptionsClose" aria-hidden="true">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Subscriptions  Modal========================================================-->
                            </div> 
                        </div>
<!-- End Subscriptions Tab ================================================================================================================================= -->

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php buildFooter(false); //Builds the Footer?>
//Creates a mask for the phone number
$(document).ready(function(){
    //Mask phone number 
    $("#accountPhone").mask("(999) 999-9999");
    
    
    //Reset the values in the modal and set if edit
    $('#accountAddressModal').on('show.bs.modal', function(e) {
        //First clear or set the values in the modal to defaults
        resetModalValues("address");
        
        var addressId = e.relatedTarget.dataset.id; //get the id for that row
        if(addressId > 0){
            //Set the values of the address mode we are in edit
            var rowId = $("#actionAddressRow_"+ addressId);
            var primary = ($(rowId).find('td').eq(6).find('i').attr('class') === "glyphicon glyphicon-star")?"Yes": "No";
    
            //Set the values of the row
            $('#accountAddressModalAddress').val($(rowId).find('td').eq(1).text());
            $('#accountAddressModalCity').val($(rowId).find('td').eq(2).text());
            $('#accountAddressModalState').val($(rowId).find('td').eq(3).text());
            $('#accountAddressModalZip').val($(rowId).find('td').eq(4).text());
            $('#accountAddressModalApartment').val($(rowId).find('td').eq(5).text());
            $('#accountAddressModalPrimaryAddress').val(primary);
            $('#accountAddressModalAddressID').val(addressId);
        } 
    });
    
    //Reset the values in the modal and set if edit
    $('#accountPaymentOptionsModal').on('show.bs.modal', function(e) {
        //First clear or set the values in the modal to defaults
        resetModalValues("paymentoption");
        
        var paymentId = e.relatedTarget.dataset.id; //get the id for that row
        if(paymentId > 0){
            //Set the values of the address mode we are in edit
            var rowId = $("#actionPaymentRow_"+ paymentId);
            var primary = ($(rowId).find('td').eq(6).find('i').attr('class') === "glyphicon glyphicon-star")?"Yes": "No";
            var fullExpiration = $(rowId).find('td').eq(5).text();
            var expirationArray = fullExpiration.split('/');
            var expirationMonth = expirationArray[0].trim();
            var expirationYear = expirationArray[1].trim();
            
            //Set the values on the modal
            $('#accountPaymentOptionsModalNameCard').val($(rowId).find('td').eq(1).text());
            $('#accountPaymentOptionsModalCardType').val($(rowId).find('td').eq(2).text());
            $('#accountPaymentOptionsModalCardNumber').val($(rowId).find('td').eq(3).text());
            $('#accountPaymentOptionsModalSecurityCode').val($(rowId).find('td').eq(4).text());
            $('#accountPaymentOptionsModalExpirationMonth').val(expirationMonth);
            $('#accountPaymentOptionsModalExpirationYear').val(expirationYear);
            $('#accountPaymentOptionsModalPrimaryPaymentOption').val(primary);
            $('#accountPaymentOptionsModalPaymentID').val(paymentId);
        } 
    });
    
    
    //Reset the values in the modal and set if edit
    $('#accountSubscriptionsModal').on('show.bs.modal', function(e) {
        //Clear Alerts There is no edit only delete and add modal
        removeAlerts('accountSubscriptionsModalAlert');
        removeAlerts('accountSubscriptionsAlert');
    });
    
    
    
    //DELETE MODALS
    //Address
     $('#deleteAddressModal').on('show.bs.modal', function(e) {
        //Gets all of the attributes from the selected row
        $('#accountDeleteAddressModalAddressID').val(e.relatedTarget.dataset.id); //set hidden id value
    });
    //Payment Options
     $('#deletePaymentOptionsModal').on('show.bs.modal', function(e) {
        //Gets all of the attributes from the selected row
        $('#accountDeletePrimaryAddressModalAddressID').val(e.relatedTarget.dataset.id); //set hidden id value
    });
    
    //Subscription
     $('#accountDeleteSubscriptionsModal').on('show.bs.modal', function(e) {
        //Remove Alerts and grab id
        removeAlerts('accountDeleteSubscriptionsModalAlert');
        removeAlerts('accountSubscriptionsAlert');
        $('#accountDeleteSubscriptionID').val(e.relatedTarget.dataset.id); //set hidden id value
    });
    
});

/**
 * Function for account modal password change  send ajax call
 */
function updateAccountModalPasword(){
    var alertString = "";
    //Clear alerts on modal
    removeAlerts('accountPersonalInformationTabAlert');
    
    //Global Variables
    var currentPassword = $("#accountChangePasswordModalCurrentPassword").val().trim();
    var newPassword = $("#accountChangePasswordModalNewPassword").val().trim();
    var confirmPassword = $("#accountChangePasswordModalConfirmPassword").val().trim();
    
    //Grabbed the values now reset the modal
    resetModalValues("password");
    
    //Current Password
    if(currentPassword.length < 1){
        alertString += addAlert("Password is required","danger");
    } else if(currentPassword.length > 25){
        alertString += addAlert("Incorrect password","danger");
    }
    
    //New Password
    if(newPassword.length < 1){
        alertString += addAlert("Password is required","danger");
    } else if(newPassword.length > 25){
        alertString += addAlert("New password is too long","danger");
    }
    
    //Confirm Password
    if(confirmPassword !== newPassword){
        alertString += addAlert("Passwords do not match","danger");
    } 
    
    //Check if current and new password are the same
    if(currentPassword === newPassword){
        alertString += addAlert("Current password and new password are the same","danger");
    } 
    
    //If no errors make ajax call else show alerts
    if(alertString.trim().length < 1){
        $.ajax(
          {
            url : "ajax/accountPasswordModal.php",
            type: "POST",
            data : {currentPassword: currentPassword, newPassword: newPassword, confirmPassword: confirmPassword},
            async: false,
            success: function(response) {
                try{
                    //get array from ajax call
                    response = JSON.parse(response);
                
                    //Loop through response and create alerts set the index t one because the first is an empty string
                    for(var index = 1; index < response.length;index++){
                        alertString += addAlert(response[index],"danger");
                    }
                } catch(error) {
                    console.log(response);
                    console.log(error);
                    alertString += addAlert(response,"danger");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log(errorThrown);
                console.log(textStatus);
                alertString += addAlert(errorThrown,"danger");
            }
          });
    }
    
    $("#accountChangePasswordModalAlert").html(alertString); //add alerts to modal
    
    //If no errors then close modal
    if(alertString.trim().length < 1){
        //Close modal by triggering a click on the close button
        $('#password_modal_close').trigger('click');
        //Show successful alert that the password was changed
        $("#accountPersonalInformationTabAlert").html(addAlert("Password has been updated","success"));
    }
    
}

function deleteAccount(){
    //Set the value on the form to delete the account
    $('#deleteAccountValue').val("Yes");
    $('#tabAccountDefaultSubmit').trigger('click');
}


//Function to clear the values in the model
function resetModalValues(modal){
    switch(modal.toLocaleLowerCase()){
        case "address":
            removeAlerts('accountAddressAlert');
            removeAlerts('accountAddressModalAlert');
            removeAlerts('accountDeleteAddressModalAlert');
            $("#accountAddressModalAddress").val("");
            $("#accountAddressModalApartment").val("");
            $("#accountAddressModalCity").val("");
            $("#accountAddressModalState").val("AK");
            $("#accountAddressModalZip").val("");
            $("#accountAddressModalPrimary").val("Yes");
            $("#accountAddressModalAddressID").val("-1");
            $("#accountAddressModalAlert").html("");
            $("#accountAddressModalZip").mask("99999");
            //Sets the focus to the first input on modal
            $("#accountAddressModalAddress").focus();
            break;
            
        case "paymentoption":
            removeAlerts('accountPaymentOptionsAlert');
            removeAlerts('accountPaymentOptionsModalAlert');
            removeAlerts('accountDeletePaymentOptionsModalAlert');
            
            $("#accountPaymentOptionsModalNameCard").val("");
            $("#accountPaymentOptionsModalCardType").val("American Express");
            $("#accountPaymentOptionsModalCardNumber").val("");
            $("#accountAddressModalZip").mask("9999999999999999");
            $("#accountAddressModalZip").val("");
            $("#accountPaymentOptionsModalSecurityCode").val("");
            $("#accountPaymentOptionsModalSecurityCode").mask("99999");
            var date = new Date();
            $("#accountPaymentOptionsModalExpirationMonth").val(date.getMonth().toString());
            $("#accountPaymentOptionsModalExpirationYear").val(date.getFullYear().toString());
            $("#accountPaymentOptionsModalPrimaryPaymentOption").val("Yes");
            $('#accountPaymentOptionsModalPaymentID').val("-1");
            
            //Sets the focus to the first input on modal
            $("#accountPaymentOptionsModalNameCard").focus();
            break;
            
        case "password":
            removeAlerts('accountChangePasswordModalAlert');
            removeAlerts('accountDeleteAccountModalAlert');
            $("#accountChangePasswordModalCurrentPassword").val("");
            $("#accountChangePasswordModalNewPassword").val("");
            $("#accountChangePasswordModalConfirmPassword").val("");
            $("#accountChangePasswordModalCurrentPassword").focus();
            break;
            
        case "order":
            removeAlerts('accountOrdersTabAlert');
            setOrdersDeleteModalValues(-1,"item");
            break;
    }
    
}

//Function that removes alerts
function removeAlerts(id){
    $("#" + id).html("");
    $('#accountalert').html("");
}

//Function to set the values of the modal for the orders delete
function setOrdersDeleteModalValues(id, type){
    $("#accountDeleteOrderID").val(id);
    $("#accountDeleteOrderType").val(type);
}


/**
 * Function that is called when the submit button is clicked it will validate 
 * the information before sending it to the server
 */
function validatePersonalInformationForm(){
    var alertString = "";
    
    //First Name
    if($("#accountFirstName").val().trim().length < 1){
        alertString += addAlert("First name can not be empty","danger");
    } else if($("#accountFirstName").val().trim().length > 50){
        alertString += addAlert("First name is too long","danger");
    }

    //Last Name
    if($("#accountLastName").val().trim().length < 1){
        alertString += addAlert("Last name can not be empty","danger");
    } else if($("#accountLastName").val().trim().length > 50){
        alertString += addAlert("Last name is too long","danger");
    }
    
    //validate phone
    //With the phone mask the length can only be 14 characters
    if($("#accountPhone").val().length !== 14){
        alertString += addAlert("Invalid Phone Number","danger");
    }
    
    //Add the alerts to the div
    //I defaulted the value above to empty string so set the inner html to the alerts
    //Alerts will not show if the string is empty
    $("#accountalert").html(alertString);
    if(alertString.trim().length > 0){ return false; } 
    return true;
}


//function to validate address information from add address modal
function accountModalAddress(){
    var alertString = "";
    
    //Global Variables
    var call = "add",address,apartment,city,state,zip,primary,addressId = $('#accountAddressModalAddressID').val().trim();
    
    if(parseInt(addressId) > 0){
        call = "edit";
    }
    
    address = $("#accountAddressModalAddress").val().trim();
    apartment = $("#accountAddressModalApartment").val().trim();
    city = $("#accountAddressModalCity").val().trim();
    state = $("#accountAddressModalState").val().trim();
    zip = $("#accountAddressModalZip").val().trim();
    primary = $("#accountAddressModalPrimaryAddress").val().trim();
    
    //Address
    if(address.length < 1){
        alertString += addAlert("Address is required","danger");
    } else if(address.length > 75){
        alertString += addAlert("Address is too long","danger");
    }
    
    //City
    if(city.length < 1){
        alertString += addAlert("City is required","danger");
    } else if(city.length > 50){
        alertString += addAlert("City is too long","danger");
    }
    
    //Zip Code
    if(zip.length !== 5){
        alertString += addAlert("Invalid zip code","danger");
    }
    
    //Apartment
    if(apartment.length > 25){
        alertString += addAlert("Apartment is to long","danger");
    }
    
    
    if(alertString.trim().length < 1){  //no errors now make ajax call
        $.ajax(
          {
            url : "ajax/accountAddressModal.php",
            type: "POST",
            data : {address: address, apartment:apartment, city: city, state: state, zip:zip, primary:primary, addressId:addressId, call:call},
            async: false,
            success: function(response) {
                try{
                    debugger;
                    //get array from ajax call
                    response = JSON.parse(response);
                    if(response.length > 1){
                        //Loop through response and create alerts set the index t one because the first is an empty string
                        for(var index = 1; index < response.length;index++){
                            alertString += addAlert(response[index],"danger");
                        }
                    } 
                } catch(error) {
                    console.log(response);
                    console.log(error);
                    alertString += addAlert(response,"danger");
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(errorThrown);
                console.log(textStatus);
                alertString += addAlert(errorThrown,"danger");
            }
          });
    }
        
    $("#accountAddressModalAlert").html(alertString);
    
    //If no errors then close modal
    if(alertString.trim().length < 1){
        //Update the HTML Table 
        updateAddressTabTable();
        //Close modal by triggering a click on the close button
        $('#accountModalAddressClose').trigger('click');
    }
}





//function to delete address from table
function accountModalDeleteAddress(){
    var alertString = "";
    
    //Global Variables
    var addressId = $('#accountDeleteAddressModalAddressID').val();
    //Add the alerts to the div
    //I defaulted the value above to empty string so set the inner html to the alerts
    //Alerts will not show if the string is empty
    var informationChanged = false;
    $.ajax(
      {
        url : "ajax/accountDeleteAddressModal.php",
        type: "POST",
        data : {addressId:addressId},
        async: false,
        success: function(response) {
            try{
                
                //get array from ajax call
                response = JSON.parse(response);
                if(response.length > 1){
                    //Loop through response and create alerts set the index t one because the first is an empty string
                    for(var index = 1; index < response.length;index++){
                        alertString += addAlert(response[index],"danger");
                    }
                } else { //No Errors so row was inserted now update the address table
                    informationChanged = true;
                }
            } catch(error) {
                console.log(response);
                console.log(error);
                alertString += addAlert(response,"danger");
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            console.log(errorThrown);
            console.log(textStatus);
            alertString += addAlert(errorThrown,"danger");
        }
      });
    
    //If no errors then close modal
    if(alertString.trim().length < 1){
        //Close modal by triggering a click on the close button
        $('#accountModalDeleteAddressClose').trigger('click');
    } else { //show alert
        $("#accountDeleteAddressModalAlert").html(alertString);
    }
    
    //Update the html table with the new information
    //Calling it down here because it is bad practice to use nested ajax calls
    if(informationChanged){
        updateAddressTabTable();
    }
}

//function to delete address from table
function accountModalDeletePaymentOptions(){
    var alertString = "";
    
    //Global Variables
    var paymentId = $('#accountDeletePrimaryAddressModalAddressID').val();
    //Add the alerts to the div
    //I defaulted the value above to empty string so set the inner html to the alerts
    //Alerts will not show if the string is empty
    $.ajax(
      {
        url : "ajax/accountDeletePaymentOptionsModal.php",
        type: "POST",
        data : {paymentId:paymentId},
        async: false,
        success: function(response) {
            try{
                //get array from ajax call
                response = JSON.parse(response);
                if(response.length > 1){
                    //Loop through response and create alerts set the index t one because the first is an empty string
                    for(var index = 1; index < response.length;index++){
                        alertString += addAlert(response[index],"danger");
                    }
                }
            } catch(error) {
                console.log(response);
                console.log(error);
                alertString += addAlert(response,"danger");
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            console.log(errorThrown);
            console.log(textStatus);
            alertString += addAlert(errorThrown,"danger");
        }
      });
    
    //If no errors then close modal
    if(alertString.trim().length < 1){
        //Close modal by triggering a click on the close button
        $('#accountModalDeletePrimaryOptionsClose').trigger('click');
        updatePaymentOptionsTabTable();
    } else { //show alert
        $("#accountDeletePaymentOptionsModalAlert").html(alertString);
    }
}




//function to validate address information from payment modal
function accountModalPaymentOptions(){
    var alertString = "";
    
    //Global Variables
    var nameCard, cardType, cardNumber, security, expirationMonth, expirationYear, primary, call = "add", paymentId = -1;
    
    nameCard = $("#accountPaymentOptionsModalNameCard").val().trim();
    cardType = $("#accountPaymentOptionsModalCardType").val().trim();
    cardNumber = $("#accountPaymentOptionsModalCardNumber").val().trim();
    security = $("#accountPaymentOptionsModalSecurityCode").val().trim();
    expirationMonth = $("#accountPaymentOptionsModalExpirationMonth").val().trim();
    expirationYear = $("#accountPaymentOptionsModalExpirationYear").val().trim();
    primary = $("#accountPaymentOptionsModalPrimaryPaymentOption").val().trim();
    paymentId = $('#accountPaymentOptionsModalPaymentID').val();
    
    if(parseInt(paymentId) > 0){
        call = "edit";
    }
    
    //Name on Card
    if(nameCard.length < 1){
        alertString += addAlert("Name on card is required","danger");
    } else if(nameCard.length > 45){
        alertString += addAlert("Name is too long","danger");
    }
    
    //Depending on card type check for different validation characters
    //Card Number
    
    if(cardNumber.length < 1){
        alertString += addAlert("Card number is required","danger");
    } else if(cardNumber.length > 20){
        alertString += addAlert("Invalid card","danger");
    } 
    //Security Checks
    //https://www.cybersource.com/developers/getting_started/test_and_manage/best_practices/card_type_id/
    
    //security code
    if(security.length !== 3 && security.length !== 4){
        alertString += addAlert("Invalid card","danger");
    } 
    
    //Add the alerts to the div
    //I defaulted the value above to empty string so set the inner html to the alerts
    //Alerts will not show if the string is empty
    if(alertString.trim().length < 1){  //no errors now make ajax call
    
        $.ajax(
          {
            url : "ajax/accountPaymentOptionsModal.php",
            type: "POST",
            data : {nameCard: nameCard, cardType:cardType, cardNumber: cardNumber, security: security, expirationMonth:expirationMonth, expirationYear:expirationYear, primary:primary, paymentId:paymentId, call:call},
            async: false,
            success: function(response) {
                try{
                    //get array from ajax call
                    response = JSON.parse(response);
                    if(response.length > 1){
                        //Loop through response and create alerts set the index t one because the first is an empty string
                        for(var index = 1; index < response.length;index++){
                            alertString += addAlert(response[index],"danger");
                        }
                    }
                } catch(error) {
                    console.log(response);
                    console.log(error);
                    alertString += addAlert(response,"danger");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log(errorThrown);
                console.log(textStatus);
                alertString += addAlert(errorThrown,"danger");
            }
          });
    }
    
    $("#accountPaymentOptionsModalAlert").html(alertString);
    
    //If no errors then close modal
    if(alertString.trim().length < 1){
        //Update Table
        updatePaymentOptionsTabTable();
        //Close modal by triggering a click on the close button
        $('#accountModalPaymentOptionsClose').trigger('click');
    }
}


//function to validate address information from payment modal
function accountModalSubscriptions(){
    var alertString = "";
    
    //Global Variables
    var Id = $('#accountSubscriptionModalSubscriptionCategory').val();
    $.ajax(
      {
        url : "ajax/accountSubscriptionsModal.php",
        type: "POST",
        data : {Id:Id},
        async: false,
        success: function(response) {
            try{
                //get array from ajax call
                response = JSON.parse(response);
                if(response.length > 1){
                    //Loop through response and create alerts set the index t one because the first is an empty string
                    for(var index = 1; index < response.length;index++){
                        alertString += addAlert(response[index],"danger");
                    }
                }
            } catch(error) {
                console.log(response);
                console.log(error);
                alertString += addAlert(response,"danger");
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(textStatus);
            alertString += addAlert(errorThrown,"danger");
        }
      });
    
    $("#accountSubscriptionsModalAlert").html(alertString);
    
    //If no errors then close modal
    if(alertString.trim().length < 1){
        //Update Table
        updateSubscriptionsTabTable();
        //Close modal by triggering a click on the close button
        $('#accountModalSubscriptionsClose').trigger('click');
    }
}


//This function updates the html address table
function updateAddressTabTable(){
    var innerHtml = "<tr><td colspan=\"7\" class=\"text-center\">No Addresses Found</td></tr>";
    
    $.ajax(
      {
        url : "ajax/accountGetAddressTableInformation.php",
        type: "GET",
        async: false,
        success: function(response) {
            try{
                //get array from ajax call
                response = $.parseJSON(response);
                
                if(response.length > 1){ //we have rows so loop and show them
                    innerHtml = ""; //reset to empty string
                    for(var index = 1; index < response.length; index++){
                        
                        innerHtml += "<tr id=\"actionAddressRow_"+ response[index].addrId +"\">"
                            innerHtml += "<td class=\"text-center\" >";
                                innerHtml += "<input type=\"button\" class=\"btn btn-info btn-xs\" data-toggle=\"modal\" data-target=\"#accountAddressModal\" value=\"Edit\" data-id=\""+response[index].addrId+"\"/>";
                                innerHtml += "<span> </span>"; //This serves as a spacer between the buttons
                                innerHtml += "<input type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#deleteAddressModal\" value=\"Delete\"data-id=\""+response[index].addrId+"\"/>";
                                innerHtml += "<span hidden>"+response[index].addrId+"</span>";
                            innerHtml += "</td>";
                            innerHtml += "<td name=\"addressColumn\">" + response[index].addressLine1 + "</td>";
                            innerHtml += "<td name=\"cityColumn\">" + response[index].city + "</td>";
                            innerHtml += "<td name=\"stateColumn\">" + response[index].state + "</td>";
                            innerHtml += "<td name=\"zipColumn\">" + response[index].zipcode + "</td>";
                            innerHtml += "<td name=\"apartmentColumn\">" + response[index].apartmentNumber + "</td>";
                            
                            //primary column
                            innerHtml += "<td name=\"primaryColumn\"><i class=\"glyphicon glyphicon-star";
                            if(response[index].isPrimaryAddress === "0"){ //If False Show Empty star
                                innerHtml += "-empty";
                            }
                            innerHtml += "\"></i></td>";
                        innerHtml += "</tr>";
                        
                    }
                    
                }
            } catch(error) {
                console.log(error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            console.log(errorThrown);
            console.log(textStatus);
        }
      });
      
      //Update the table
      $("#accountAddressTable").html(innerHtml);
}

//This function updates the html payment options table
function updatePaymentOptionsTabTable(){
    var innerHtml = "<tr><td colspan=\"7\" class=\"text-center\">No Cards Found</td></tr>";
    
    $.ajax(
      {
        url : "ajax/accountGetPaymentOptionsTableInformation.php",
        type: "GET",
        async: false,
        success: function(response) {
            try{
                //get array from ajax call
                response = $.parseJSON(response);
                
                if(response.length > 1){ //we have rows so loop and show them
                    innerHtml = ""; //reset to empty string
                    for(var index = 1; index < response.length; index++){
                        innerHtml += "<tr id=\"actionPaymentRow_"+ response[index].payId +"\">"
                            innerHtml += "<td class=\"text-center\" >";
                                innerHtml += "<input type=\"button\" class=\"btn btn-info btn-xs\" data-toggle=\"modal\" data-target=\"#updatePaymentOptionsModal\" value=\"Edit\" data-id=\""+response[index].payId+"\"/>";
                                innerHtml += "<span> </span>"; //This serves as a spacer between the buttons
                                innerHtml += "<input type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#deletePaymentOptionsModal\" value=\"Delete\"data-id=\""+response[index].payId+"\"/>";
                                innerHtml += "<span hidden>"+response[index].payId+"</span>";
                            innerHtml += "</td>";
                            innerHtml += "<td name=\"cardNameColumn\">" + response[index].nameOnCard + "</td>";
                            innerHtml += "<td name=\"cardTypeColumn\">" + response[index].type + "</td>";
                            innerHtml += "<td name=\"cardNumberColumn\">" + response[index].cardNum + "</td>";
                            innerHtml += "<td name=\"cardSecurityColumn\">" + response[index].csc + "</td>";
                            innerHtml += "<td name=\"cardExpirationColumn\">" + response[index].expirationMonth + "/" + response[index].expirationYear + "</td>";
                            
                            //primary column
                            innerHtml += "<td name=\"primaryColumn\"><i class=\"glyphicon glyphicon-star";
                            if(response[index].isPrimaryPayment === "0"){ //If False Show Empty star
                                innerHtml += "-empty";
                            }
                            innerHtml += "\"></i></td>";
                        innerHtml += "</tr>";
                    }
                }
            } catch(error) {
                console.log(response);
                console.log(error);
                alertString += addAlert(response,"danger");
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(textStatus);
        }
      });
      
      //Update the table
      $("#accountPaymentOptionsTable").html(innerHtml);
}


//This function updates the html subscriptions table
function updateSubscriptionsTabTable(){
    var innerHtml = "<tr><td colspan=\"3\" class=\"text-center\">No Subscriptions Found</td></tr>";
    
    $.ajax(
      {
        url : "ajax/accountGetSubscriptionsTableInformation.php",
        type: "GET",
        async: false,
        success: function(response) {
            try{
                //get array from ajax call
                response = $.parseJSON(response);
                
                if(response.length > 1){ //we have rows so loop and show them
                    innerHtml = ""; //reset to empty string
                    for(var index = 1; index < response.length; index++){
                        innerHtml += "<tr id=\"actionSubscriptionRow_"+ response[index].subscriptionId +"\">"
                            innerHtml += "<td class=\"text-center\">";
                                innerHtml += "<input type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#deleteSubscriptionsModal\" value=\"Delete\" data-id=\""+response[index].subscriptionId+"\"/>";
                                innerHtml += "<span hidden>"+response[index].subscriptionId+"</span>";
                            innerHtml += "</td>";
                            innerHtml += "<td name=\"subscriptionColumn\">" + response[index].category + "</td>";
                            innerHtml += "<td name=\"dateColumn\">" + response[index].date + "</td>";
                        innerHtml += "</tr>";
                    }
                }
            } catch(error) {
                console.log(response);
                console.log(error);
                alertString += addAlert(response,"danger");
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(textStatus);
        }
      });
      
      //Update the table
      $("#accountSubscriptionsTable").html(innerHtml);
}


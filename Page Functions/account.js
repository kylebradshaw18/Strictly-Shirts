$(document).ready(function(){
    //Mask phone number 
    $("#accountPhone").mask("(999) 999-9999");
    
    //Remove the last hr from the orders panel in every order
    $('.media-list hr:last-child').remove();
    
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
        //First clear or set the values in the modal to defaults
        resetModalValues("subscription");
        
        var subscriptionId = e.relatedTarget.dataset.id; //get the id for that row
        if(subscriptionId > 0){
            //Show or hide the options depending if it is edit or add
            $("#accountSubscriptionsModalCategorySelectShow").hide();
            $("#accountSubscriptionsModalCategorySingleShow").show();
            
            //Set the value of the id
            $("#accountSubscriptionModalSubscriptionId").val(subscriptionId);
            //Set the values of the address mode we are in edit
            var rowId = $("#actionSubscriptionRow_"+ subscriptionId);
            $("#accountSubscriptionModalSubscriptionAddress").val($(rowId).find('td span').eq(2).text());
            $("#accountSubscriptionModalSubscriptionCategorySingle").html($(rowId).find('td').eq(1).text());
        } 
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
    $('input[name=\'tabAccountDefaultSubmit\']').trigger('click');
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
            $("#accountPaymentOptionsModalSecurityCode").mask("9999");
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
            
        case "subscription":
            //Clear Alerts There is no edit only delete and add modal
            removeAlerts('accountSubscriptionsModalAlert');
            removeAlerts('accountSubscriptionsAlert');
            $("#accountSubscriptionsModalCategorySelectShow").show();
            $("#accountSubscriptionsModalCategorySingleShow").hide();
            $("#accountSubscriptionModalSubscriptionId").val("-1");
            $("#accountSubscriptionModalSubscriptionCategorySelect").val($("#accountSubscriptionModalSubscriptionCategorySelect option:first").val());
            $("#accountSubscriptionModalSubscriptionAddress").val($("#accountSubscriptionModalSubscriptionAddress option:first").val());
            break;
            
            
    }
    
}

//Function that removes alerts
function removeAlerts(id){
    $("#" + id).html("");
    $('#accountalert').html("");
}

//Function to set the values of the modal for the orders delete
function setDeleteOrdersModalValues(id, invId){
    
    removeAlerts('accountDeletePaymentOptionsModalAlert');
    removeAlerts('accountOrdersTabAlert');
    
    $("#accountDeleteOrderID").val(id);
    $("#accountDeleteOrderInventoryId").val(invId);
    
    //have inventory id so change label to item
    if(invId > 0){
        $('#accountDeleteOrderItem').text("item");
    } else {
        $('#accountDeleteOrderItem').text("order");
    }
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
        $('#accountModalDeletePaymentOptionsClose').trigger('click');
        updatePaymentOptionsTabTable();
    } else { //show alert
        $("#accountDeletePaymentOptionsModalAlert").html(alertString);
    }
}

//function to delete order
function accountModalDeleteOrder(){
    var alertString = "";
    
    //Global Variables
    var orderId = $('#accountDeleteOrderID').val(), inventoryId = $('#accountDeleteOrderInventoryId').val();
    
    $.ajax(
      {
        url : "ajax/accountDeleteOrdersModal.php",
        type: "POST",
        data : {orderId:orderId, inventoryId:inventoryId},
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
        updateOrdersTab();
        //Close modal by triggering a click on the close button
        $('#accountModalDeleteOrderClose').trigger('click');
    } else { //show alert
        $("#accountDeleteOrdersModalAlert").html(alertString);
    }
}



//function to delete address from table
function accountModalDeleteSubscription(){
    var alertString = "";
    
    //Global Variables
    var subscriptionId = $('#accountDeleteSubscriptionID').val();
    $.ajax(
      {
        url : "ajax/accountDeleteSubscriptionsModal.php",
        type: "POST",
        data : {subscriptionId:subscriptionId},
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
        $('#accountModalDeletePaymentOptionsClose').trigger('click');
        updateSubscriptionsTabTable();
    } else { //show alert
        $("#accountDeleteSubscriptionsModalAlert").html(alertString);
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
    var subscriptionId = $('#accountSubscriptionModalSubscriptionId').val();
    var categoryId;
    var addressId = $('#accountSubscriptionModalSubscriptionAddress').val();
    if(subscriptionId > 0){ //edit
        categoryId = $("#accountSubscriptionModalSubscriptionCategorySingle").text();
        
    } else { //add
        categoryId = $("#accountSubscriptionModalSubscriptionCategorySelect").val();
    }
    
    if(!addressId > 0){ //if not greater than 0 address is not select or do not have one
        alertString += addAlert("You must select an address before subscribing","danger");
    }
    
    if(alertString < 1){ //passed checks now make call
        $.ajax(
          {
            url : "ajax/accountSubscriptionsModal.php",
            type: "POST",
            data : {subscriptionId:subscriptionId, categoryId:categoryId, addressId:addressId},
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
    }
    
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
      
      //Update the subscriptions table because we want them to be consistant
       updateSubscriptionsTabTable();
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


//This function updates the html orders tab
function updateOrdersTab(){
    var innerHtml = "<br><div class=\"text-center\"><h3>No Orders Found<hr style=\"width:25%;\"></h3></div>";
    var alertString = "";
    
    $.ajax(
      {
        url : "ajax/accountGetOrdersInformation.php",
        type: "GET",
        async: false,
        success: function(response) {
            try{
                //get array from ajax call
                response = $.parseJSON(response);
                
                if(response[1].length > 1){ //we have rows so loop and show them
                    innerHtml = ""; //reset to empty string
                    for(var index = 1; index < response[1].length; index++){ //Loop through order master
                        innerHtml += "<div class=\"panel panel-default\">  <!-- Start of Order -->";
                        innerHtml += "    <div class=\"panel-heading form-horizontal\" style=\"padding-bottom:1%;\">";
                        innerHtml += "        <div class=\"row\">";
                        innerHtml += "            <div class=\"col col-xs-4 text-left\" style=\"padding-left:5%;\">";
                        innerHtml += "                <label for=\"accountOrderNumberPanelHeading\" class=\"control-label\">Ref Number:</label>";
                        innerHtml += "                <span id=\"accountOrderNumberPanelHeading\" name=\"accountOrderNumberPanelHeading\">"+ response[1][index].orderId +"</span>";
                        innerHtml += "            </div>";
                        innerHtml += "            <div class=\"col col-xs-4 text-center\">";
                        innerHtml += "                <label for=\"accountOrderDatePanelHeading\" class=\"control-label\">Date Ordered:</label>";
                        innerHtml += "                <span id=\"accountOrderDatePanelHeading\" name=\"accountOrderDatePanelHeading\">"+ response[1][index].date +"</span>";
                        innerHtml += "            </div>";
                        innerHtml += "            <div class=\"col col-xs-4 text-right\" style=\"padding-right:5%;\">";
                        
                        if(response[1][index].showDelete){
                            innerHtml += "                <button type=\"button\" class=\"btn btn-sm btn-danger btn-create\" data-toggle=\"modal\"  onclick=\"setDeleteOrdersModalValues("+ response[1][index].orderId +", -1);\" data-target=\"#deleteOrdersModal\" value=\"Delete Order Item\" title=\"Delete Order\">Delete Order</button>";
                        }
                        
                        innerHtml += "            </div>";
                        innerHtml += "        </div>";
                        innerHtml += "    </div>";
                        innerHtml += "    <div class=\"panel-body\">";
                        innerHtml += "        <ul class=\"media-list\">";
                        
                        var sum = 0, originalShippingCost = 0;
                        
                        for(var innerIndex = 1; innerIndex < response[2].length; innerIndex++){
                            //Make sure we are on the same order
                            if(response[2][innerIndex].orderId !== response[1][index].orderId){
                                continue;
                            }
                            sum += (parseFloat(response[2][innerIndex].price) * parseFloat(response[2][innerIndex].quantity));
                            if(originalShippingCost !== response[2][innerIndex].shippingCost){
                                originalShippingCost = parseFloat(response[2][innerIndex].shippingCost);
                                sum += originalShippingCost;
                            }
                        
                            innerHtml += "            <li class=\"media\">";
                            innerHtml += "                <div class=\"media-left pull-left text-center\">";
                            innerHtml += "                    <img class=\"media-object\" src=\"images/productsImages/"+ response[2][innerIndex].productId+".jpg\" alt=\""+ response[2][innerIndex].design+"\">";
                                if(response[2][innerIndex].showDelete){
                                    innerHtml += "                    <button type=\"button\" class=\"btn btn-sm btn-danger btn-create\" data-toggle=\"modal\" data-target=\"#deleteOrdersModal\" onclick=\"setDeleteOrdersModalValues("+ response[2][innerIndex].orderId +","+ response[2][innerIndex].inventoryId +");\" value=\"Delete Order Item\" title=\"Delete Item\">Delete Item</button>";
                                }
                            innerHtml += "                </div>";
                            innerHtml += "                <div class=\"media-body media-bottom\">";
                            innerHtml += "                    <div class=\"modal-body form-horizontal\">";
                            innerHtml += "                        <div class=\"form-group\">";
                            innerHtml += "                            <label for=\"accountOrderCategory\" class=\"col-xs-2 control-label\">Category:</label>";
                            innerHtml += "                            <div class=\"col-xs-3\">";
                            innerHtml += "                                <div class=\"list-group-item\" id=\"accountOrderCategory\" name=\"accountOrderCategory\">"+ response[2][innerIndex].category+"</div>";
                            innerHtml += "                            </div>";
                            innerHtml += "                            <div class=\"col-xs-1\"></div>";
                            innerHtml += "                            <label for=\"accountOrderDesign\" class=\"col-xs-3 control-label\">Design:</label>";
                            innerHtml += "                            <div class=\"col-xs-3\">";
                            innerHtml += "                                <div class=\"list-group-item\" id=\"accountOrderDesign\" name=\"accountOrderDesign\">"+ response[2][innerIndex].design+"</div>";
                            innerHtml += "                            </div>";
                            innerHtml += "                        </div>";
                            innerHtml += "                        <div class=\"form-group\">";
                            innerHtml += "                            <label for=\"accountOrderType\" class=\"col-xs-2 control-label\">Type:</label>";
                            innerHtml += "                            <div class=\"col-xs-3\">";
                            innerHtml += "                                <div class=\"list-group-item\" id=\"accountOrderType\" name=\"accountOrderType\">"+ response[2][innerIndex].type+"</div>";
                            innerHtml += "                            </div>";
                            innerHtml += "                            <div class=\"col-xs-1\"></div>";
                            innerHtml += "                            <label for=\"accountOrderSize\" class=\"col-xs-3 control-label\">Size:</label>";
                            innerHtml += "                            <div class=\"col-xs-3\">";
                            innerHtml += "                                <div class=\"list-group-item\" id=\"accountOrderSize\" name=\"accountOrderSize\">"+ response[2][innerIndex].size+"</div>";
                            innerHtml += "                            </div>";
                            innerHtml += "                        </div>";
                            innerHtml += "                        <div class=\"form-group\">";
                            innerHtml += "                            <label for=\"accountOrderQuantity\" class=\"col-xs-2 control-label\">Quantity:</label>";
                            innerHtml += "                            <div class=\"col-xs-3\">";
                            innerHtml += "                                <div class=\"list-group-item\" id=\"accountOrderQuantity\" name=\"accountOrderQuantity\">"+ response[2][innerIndex].quantity+"</div>";
                            innerHtml += "                            </div>";
                            innerHtml += "                            <div class=\"col-xs-1\"></div>";
                            innerHtml += "                            <label for=\"accountOrderPrice\" class=\"col-xs-3 control-label\">Price:</label>";
                            innerHtml += "                            <div class=\"col-xs-3\">";
                            innerHtml += "                                <div class=\"list-group-item\" id=\"accountOrderPrice\" name=\"accountOrderPrice\">$"+ parseFloat(response[2][innerIndex].price).toFixed(2)+"</div>";
                            innerHtml += "                            </div>";
                            innerHtml += "                        </div>";
                            innerHtml += "                        <div class=\"form-group\">";
                            innerHtml += "                            <label for=\"accountOrderPrice\" class=\"col-xs-2 control-label\">Shipping:</label>";
                            innerHtml += "                            <div class=\"col-xs-3\">";
                            innerHtml += "                                <div class=\"list-group-item\" id=\"accountOrderPrice\" name=\"accountOrderPrice\">"+ response[2][innerIndex].shipping+"</div>";
                            innerHtml += "                            </div>";
                            innerHtml += "                            <div class=\"col-xs-1\"></div>";
                            innerHtml += "                            <label for=\"accountOrderShipping\" class=\"col-xs-3 control-label\">Shipping Cost:</label>";
                            innerHtml += "                            <div class=\"col-xs-3\">";
                            innerHtml += "                                <div class=\"list-group-item\" id=\"accountOrderShipping\" name=\"accountOrderShipping\">$"+parseFloat(response[2][innerIndex].shippingCost).toFixed(2)+"</div>";
                            innerHtml += "                            </div>";
                            innerHtml += "                        </div>";
                            innerHtml += "                   </div>";
                            innerHtml += "                </div>";
                            innerHtml += "            </li>";
                            innerHtml += "            <hr>";
                            
                            } //End Inner Index
                            
                        innerHtml += "        </ul>";
                        innerHtml += "    </div>";
                        innerHtml += "    <div class=\"panel-footer form-horizontal text-right row\" style=\"padding-right:5%;padding-top:2%;\">";
                        innerHtml += "        <div class=\"form-group text-center\">";
                        innerHtml += "            <label for=\"accountOrderAddress\" class=\"col-xs-3 control-label\">Shipping Address:</label>";
                        innerHtml += "            <div class=\"col-xs-3\">";
                        innerHtml += "                <div class=\"list-group-item\" id=\"accountOrderAddress\" name=\"accountOrderAddress\">"+ response[1][index].addressLine1+" "+ response[1][index].apartmentNumber+"<br>"+ response[1][index].city+", "+ response[1][index].state+" "+ response[1][index].zipcode+"</div>";
                        innerHtml += "            </div>";
                        innerHtml += "            <label for=\"accountOrderPaymentOption\" class=\"col-xs-3 control-label\">Payment Option:</label>";
                        innerHtml += "            <div class=\"col-xs-3\">";
                        innerHtml += "                <div class=\"list-group-item\" id=\"accountOrderPaymentOption\" name=\"accountOrderPaymentOption\">"+ response[1][index].type+"<br>"+maskCard(response[1][index].cardNum)+"</div>";
                        innerHtml += "            </div>";
                        innerHtml += "        </div>";
                        innerHtml += "        <label for=\"accountOrderTotalPanelFooter\" class=\"control-label\">Total:</label>";
                        innerHtml += "        <span id=\"accountOrderTotalPanelFooter\" name=\"accountOrderTotalPanelFooter\">$"+sum.toFixed(2)+"</span>";
                        innerHtml += "    </div>";
                        innerHtml += "</div>";
                        innerHtml += "<br> <!-- End Of Order-->";
                    } //end master loop
                }
            } catch(error) {
                console.log(response);
                console.log(error);
                alertString += addAlert(error,"danger");
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(textStatus);
        }
      });
      
      //Update the table
      $("#accountOrdersPanel").html(innerHtml);
      
      //Remove the last hr
      $('.media-list hr:last-child').remove();
}




//This function updates the html subscriptions table
function updateSubscriptionsTabTable(){
    var innerHtml = "<tr><td colspan=\"4\" class=\"text-center\">No Subscriptions Found</td></tr>";
    var addressHtml = "";
    
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
                    //This loop is special returns a multi dimensional array
                    for(var index = 1; index < response[1].length; index++){
                        innerHtml += "<tr id=\"actionSubscriptionRow_"+ response[1][index].subscriptionId +"\">"
                            innerHtml += "<td class=\"text-center\">";
                                innerHtml += "<input type=\"button\" class=\"btn btn-info btn-xs\" data-toggle=\"modal\" data-target=\"#accountSubscriptionsModal\" value=\"Edit \"data-id=\""+response[1][index].subscriptionId+"\"/>";
                                innerHtml += "<span> </span>";
                                innerHtml += "<input type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#accountDeleteSubscriptionsModal\" value=\"Delete\" data-id=\""+response[1][index].subscriptionId+"\"/>";
                                innerHtml += "<span hidden>"+response[1][index].subscriptionId+"</span>";
                            innerHtml += "</td>";
                            innerHtml += "<td name=\"subscriptionColumn\">" + response[1][index].category + "</td>";
                            innerHtml += "<td name=\"addressColumn\">"+response[1][index].addressLine1 + "<br>"+response[1][index].city+", "+response[1][index].state+"  "+response[1][index].zipcode;
                                innerHtml += "<span hidden>"+response[1][index].addrId+"</span>";
                            innerHtml += "</td>";
                            innerHtml += "<td name=\"dateColumn\">" + response[1][index].date + "</td>";
                        innerHtml += "</tr>";
                    }
                    //Loop through addresses
                    for(var index = 1; index < response[2].length; index++){
                        addressHtml += "<option value="+response[2][index].addrId+">"+response[2][index].addressLine1+"  "+response[2][index].city+",  "+response[2][index].state+"  "+response[2][index].zipcode+"</option>";
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
      $("#accountSubscriptionModalSubscriptionAddress").html(addressHtml);
}
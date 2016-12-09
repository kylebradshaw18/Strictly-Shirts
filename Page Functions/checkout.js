//Function to clear the values in the model
function resetModal(modal){
    switch(modal.toLocaleLowerCase()){
        case "address":
            removeAlerts('checkoutAddressModalAlert');
            $("#checkoutAddressModalAddress").val("");
            $("#checkoutAddressModalApartment").val("");
            $("#checkoutAddressModalCity").val("");
            $("#checkoutAddressModalState").val("AK");
            $("#checkoutAddressModalZip").val("");
            $("#checkoutAddressModalPrimary").val("Yes");
            $("#checkoutAddressModalAddressID").val("-1");
            $("#checkoutAddressModalAlert").html("");
            $("#checkoutAddressModalZip").mask("99999");
            //Sets the focus to the first input on modal
            $("#checkoutAddressModalAddress").focus();
            break;
            
        case "payment":
            removeAlerts('checkoutPaymentOptionsModalAlert');
            
            $("#checkoutPaymentOptionsModalNameCard").val("");
            $("#checkoutPaymentOptionsModalCardType").val("American Express");
            $("#checkoutPaymentOptionsModalCardNumber").val("");
            $("#checkoutAddressModalZip").mask("9999999999999999");
            $("#checkoutAddressModalZip").val("");
            $("#checkoutPaymentOptionsModalSecurityCode").val("");
            $("#checkoutPaymentOptionsModalSecurityCode").mask("9999");
            var date = new Date();
            $("#checkoutPaymentOptionsModalExpirationMonth").val(date.getMonth().toString());
            $("#checkoutPaymentOptionsModalExpirationYear").val(date.getFullYear().toString());
            $("#checkoutPaymentOptionsModalPrimaryPaymentOption").val("Yes");
            $('#checkoutPaymentOptionsModalPaymentID').val("-1");
            
            //Sets the focus to the first input on modal
            $("#checkoutPaymentOptionsModalNameCard").focus();
            break;
    }
    
}

//Function that removes alerts
function removeAlerts(id){
    $("#" + id).html("");
    $('#checkoutAlert').html("");
}

/**
 * Function that is called when the submit button is clicked it will validate 
 * the information before sending it to the server
 */
function validateOrderInformationForm(){
    var alertString = "";
    var addressId = parseInt($("#checkoutAddress").val().trim());
    var payId = parseInt($("#checkoutPaymentMethod").val().trim());
    var shipId = parseInt($("#checkoutShipPriority").val().trim());
    
    //Address
    if(addressId < 1){
        alertString += addAlert("Please Add An Address","danger");
    }
    //Payment
    if(addressId < 1){
        alertString += addAlert("Please Add A Payment Method","danger");
    }
    
    //Add the alerts to the div
    //I defaulted the value above to empty string so set the inner html to the alerts
    //Alerts will not show if the string is empty
    $("#checkoutAlert").html(alertString);
    if(alertString.trim().length > 0){ return false; } 
    return true;
}


//function to validate address information from add address modal
function checkoutModalAddress(){
    var alertString = "";
    
    //Global Variables
    var call = "add",address,apartment,city,state,zip,primary,addressId = $('#checkoutAddressModalAddressID').val().trim();
    
    address = $("#checkoutAddressModalAddress").val().trim();
    apartment = $("#checkoutAddressModalApartment").val().trim();
    city = $("#checkoutAddressModalCity").val().trim();
    state = $("#checkoutAddressModalState").val().trim();
    zip = $("#checkoutAddressModalZip").val().trim();
    primary = $("#checkoutAddressModalPrimaryAddress").val().trim();
    
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
    
    //If no errors then close modal
    if(alertString.trim().length < 1){
        //Reload the page will use the url to call the server so it will update all of the quantities
        window.location.reload(true);
    } else {
        $("#checkoutAddressModalAlert").html(alertString);
    }
}

//function to validate payment information from payment modal
function checkoutModalPaymentOptions(){
    var alertString = "";
    
    //Global Variables
    var nameCard, cardType, cardNumber, security, expirationMonth, expirationYear, primary, call = "add", paymentId = -1;
    
    nameCard = $("#checkoutPaymentOptionsModalNameCard").val().trim();
    cardType = $("#checkoutPaymentOptionsModalCardType").val().trim();
    cardNumber = $("#checkoutPaymentOptionsModalCardNumber").val().trim();
    security = $("#checkoutPaymentOptionsModalSecurityCode").val().trim();
    expirationMonth = $("#checkoutPaymentOptionsModalExpirationMonth").val().trim();
    expirationYear = $("#checkoutPaymentOptionsModalExpirationYear").val().trim();
    primary = $("#checkoutPaymentOptionsModalPrimaryPaymentOption").val().trim();
    paymentId = $('#checkoutPaymentOptionsModalPaymentID').val();
    
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
    
    //If no errors then close modal
    if(alertString.trim().length < 1){
        //Reload the page will use the url to call the server so it will update all of the quantities
        window.location.reload(true);
    } else {
        $("#checkoutPaymentOptionsModalAlert").html(alertString);
    }
}
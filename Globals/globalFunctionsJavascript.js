/**
 * This function creates the HTML for a closable bootstrap alert
     * Takes in the message and type of alert by default it sets it to danger
     * 
     * TYPES OF alerts
     * 
     * success = Green
     * info = Blue
     * warning = Yellow
     * danger = red
     */
function addAlert(stringAlert, type){
    var returnString = "";
    if( (type === undefined)       ||
        (type.trim() !== "success" &&
         type.trim() !== "info"    &&
         type.trim() !== "warning") ){ //Default type to danger if not specified
        
        type = "danger";
    }
    if(stringAlert.trim().length > 0){
        return "<div class=\"alert alert-"+ type.trim().toLocaleLowerCase() +"\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>" + stringAlert + " </div>";
    }
    return returnString;
}

/**
 * This function masks a card number so only the last 4 digits are visible
 */
function maskCard(cardNumber){
    var lengthCardNumber = cardNumber.length;
    var lengthCardNumberMask = lengthCardNumber - 4;
    var lastDigits = cardNumber.substring(lengthCardNumberMask, lengthCardNumber);
    var newCardNumber = "";
    for(var index = 0; index < lengthCardNumberMask; index++){
        newCardNumber += "*";
    }
    newCardNumber += lastDigits;
    return newCardNumber;
}


function subscribe(value){
    var value = $('#newsLetterEmail').val();
    var alertString = "";
    if(value.trim().length > 0){
        $.ajax(
          {
            url : "ajax/newsLetter.php",
            type: "POST",
            data : {email:value},
            async: true,
            success: function(response) {
                //get array from ajax call
                response = JSON.parse(response);
                if(response.length > 1){
                    //Loop through response and create alerts set the index t one because the first is an empty string
                    for(var index = 1; index < response.length;index++){
                        alertString += addAlert(response[index],"danger");
                    }
                } 
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log(errorThrown);
                console.log(textStatus);
            }
          });
    } else {
        alertString += (addAlert("Email can not be blank","danger"));
    }
    
    $('#newsLetterAlert').html(alertString);
}
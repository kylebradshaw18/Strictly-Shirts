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


/** Function that gets the users ID
 * If no id then it returns 0
 */
function getUserId(){
    var returnValue = 0;
    $.ajax(
      {
        url : "ajax/checkLogin.php",
        type: "GET",
        async: false,
        success: function(response) {
            //get array from ajax call
            response = JSON.parse(response);
            if(response > 0){
                returnValue = response;
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            console.log(errorThrown);
            console.log(textStatus);
        }
      });
    
    return returnValue;
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
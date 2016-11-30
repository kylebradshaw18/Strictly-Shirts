$(document).ready(function(){
    //Mask phone number 
    $("#contactPhone").mask("(999) 999-9999");
});
/**
 * Function that is called when the submit button is clicked it will validate 
 * the information before sending it to the server
 */
function validateContactForm(){
    var alertString = "";
    //Removes the alerts First
    $("#contactAlert").html(alertString);
    //Name
    if($("#contactName").val().trim().length < 1){
        alertString += addAlert("Name can not be empty","danger");
    } else if($("#contactName").val().trim().length > 150){
        alertString += addAlert("Name is too long","danger");
    }

    //Email
    if($("#contactEmail").val().trim().length < 3){
        alertString += addAlert("Invalid Email Address","danger");
    } else if($("#contactEmail").val().trim().length > 75){
        alertString += addAlert("Email address is too long","danger");
    }
    
    //validate phone
    //With the phone mask the length can only be 14 characters
    if($("#contactPhone").val().length !== 14){
        alertString += addAlert("Invalid Phone Number","danger");
    }
    
    //Email
    if($("#contactMessage").val().trim().length < 1){
        alertString += addAlert("Message is required","danger");
    } else if($("#contactMessage").val().trim().length > 255){
        alertString += addAlert("Message is too long","danger");
    }
    
    //Add the alerts to the div
    //I defaulted the value above to empty string so set the inner html to the alerts
    //Alerts will not show if the string is empty
    $("#contactAlert").html(alertString);
    if(alertString.trim().length > 0){ return false; } 
    return true;
}
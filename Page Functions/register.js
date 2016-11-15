//Creates a mask for the phone number
$(document).ready(function(){
    //found this phone mask to make sure we have consistant data    
    $("#registerphone").mask("(999) 999-9999");
});


/**
 * Function that is called when the submit button is clicked it will validate 
 * the information before sending it to the server
 */

function validateForm(){
    var alertString = "";
    
    //First Name
    if($("#registerfirstname").val().trim().length < 1){
        alertString += addAlert("First name can not be empty","danger");
    } else if($("#registerfirstname").val().trim().length > 50){
        alertString += addAlert("First name is too long","danger");
    }

    //Last Name
    if($("#registerlastname").val().trim().length < 1){
        alertString += addAlert("Last name can not be empty","danger");
    } else if($("#registerlastname").val().trim().length > 50){
        alertString += addAlert("Last name is too long","danger");
    }
    
    //validate phone
    //With the phone mask the length can only be 14 characters
    if($("#registerphone").val().length !== 14){
        alertString += addAlert("Invalid Phone Number","danger");
    }
    
    //validate password
    if($("#registerpassword").val().length < 1){
        alertString += addAlert("Password can not be empty","danger");
    } else if($("#registerpassword").val().length > 25){
        alertString += addAlert("Password is too long","danger");
    }
    
    //validate passwords
    if($("#registerpassword").val() !== $("#registerpasswordconfirm").val()){
        alertString += addAlert("The passwords do not match","danger");
    }
    
    //Add the alerts to the div
    //I defaulted the value above to empty string so set the inner html to the alerts
    //Alerts will not show if the string is empty
    $("#registeralert").html(alertString);
    if(alertString.trim().length > 0){ return false; } 
    return true;
}
function removeFromCart(cartId, quantity){
    var alertString = "";
   
    if(!cartId > 0){
        alertString += addAlert("Something went wrong please contact support","danger");
    }
    
    if(!quantity > 0){
        alertString += addAlert("Quantity must be greater than zero","danger");
    }
    
    if(alertString.trim().length < 1){
        $.ajax(
          {
            url : "ajax/removeFromCart.php",
            type: "POST",
            data : {cartId: cartId, quantity:quantity},
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
    debugger;
    if(alertString.trim().length < 1){
        //Reload the page will use the url to call the server so it will update the cart table and page
        window.location.reload(true);
    } else {
        //TO DO if alert string is less than one 
    }
}
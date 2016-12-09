var htmlIdArray = ['productModalType', 'productModalColor', 'productModalSize'];
$(document).ready(function(){
    //Reset the values in the modal and set if edit
    $('#productModal').on('show.bs.modal', function(e) {
        //First hide the add to cart and sign in buttons
        $('#productModalAddToCart').hide();
        $('#productModalSignIn').hide();
        //If the personid is greater than 0 show add to cart else show sign in
        var personid = $('#userLoggedIn').val();
        if(parseInt(personid) > 0){
            $('#productModalAddToCart').show();
        } else {
            $('#productModalSignIn').show();
            $('#userLoggedIn').val(0)
        }
    });
});

function setModalValues(id){
    var alertString = "";
    $("#productsModalAlert").html(alertString);
    $("#productModalHeaderText").html("Shirt");
    $('#productsModalHiddenInfo').val("");
    $("#productsModalImage").attr("src",$('#productInformationImage_'+id).attr('src'));
    //Reset the quantity
    $("#productModalQuantityValue").val(0);
    $("#productModalQuantityValueAdd").attr('disabled',true);
    $("#productModalQuantityValueMinus").attr('disabled',true);
    
    for(var index = 0;index < htmlIdArray.length; index++){
        resetDropdowns(htmlIdArray[index]);
    }
    
    var informationValue = JSON.parse($("#productsHiddenInfo_"+id).val());
    
    if(!informationValue > 0){
        alertString += addAlert("Something went wrong please contact support","danger");
    } else { //Have information so we are set
        $("#productsModalHiddenInfo").val(JSON.stringify(informationValue));
        var colorSet = false, sizeSet = false;
        //Loop through values
        for(var index = 0; index < informationValue.length; index++){
            //Enable all the options for type that we have
            enableOptions(htmlIdArray[0], informationValue[index].typeId);
            //Set the first one as selected
            setSelected(htmlIdArray[0]);
            //Only enable the colors that we have for this type
            if($("#"+htmlIdArray[0]).val() === informationValue[index].typeId){
                enableOptions(htmlIdArray[1], informationValue[index].colorId);
                if(!colorSet){
                    setSelected(htmlIdArray[1]);
                    colorSet = true;
                }
                if($("#"+htmlIdArray[1]).val() === informationValue[index].colorId){
                    enableOptions(htmlIdArray[2], informationValue[index].sizeId);
                    if(!sizeSet){
                        setSelected(htmlIdArray[2]);
                        sizeSet = true;
                    }
                }
            }
        }
        
        setModal(informationValue[0]);
    }
    $("#productsModalAlert").html(alertString);
}

function resetDropdowns(id){
    $("#"+id+" option").each(function(i){
        $(this).attr('disabled',true);
    });
}

function enableOptions(id, value){
    $('#'+id+' option[value="'+value+'"]').attr('disabled',false);
}

function setSelected(id){
    $('#'+id).children('option:enabled').eq(0).prop('selected',true);
}

function setModal(inventory){
    $("#productModalHeaderText").html(inventory.design);
    $("#productModalDesign").html(inventory.design);
    $("#productModalPrice").html(parseFloat(inventory.price).toFixed(2));
    $("#productModalInStock").val(inventory.quantity);
    $("#productModalType").val(inventory.typeId);
    $("#productModalSize").val(inventory.sizeId);
    $("#productModalColor").val(inventory.colorId);
    
    var qu = 0;
    $("#productModalQuantityValueMinus").attr('disabled',true);
    $("#productModalQuantityValueAdd").attr('disabled',true);
    if(inventory.quantity > 0){
        qu = 1;
        $("#productModalQuantityValueAdd").attr('disabled',false);
    }
    
    $("#productModalQuantityValue").val(qu);
}

//Function that when it is called it will reset all of the options
function valuesChange(elem){
    var id = $(elem).attr("id");
    var value = $(id).val();
    var informationValue = JSON.parse($("#productsModalHiddenInfo").val());
    
    //type and color we reset all value 
    //for size we do not have to 
    switch(id){
        case htmlIdArray[0]: //Reset Color and size
            //Reset colors and size
            for(var index = 1;index < htmlIdArray.length; index++){
                resetDropdowns(htmlIdArray[index]);
            }
            
            var colorSet = false;
            for(var index = 0; index < informationValue.length; index++){
                //Only enable the colors that we have for this type
                if(value === informationValue[index].typeId){
                    enableOptions(htmlIdArray[1], informationValue[index].colorId);
                    if(!colorSet){
                        setSelected(htmlIdArray[1]);
                        colorSet = true;
                    }
                    if($("#"+htmlIdArray[2]).val() === informationValue[index].colorId){
                        enableOptions(htmlIdArray[2], informationValue[index].sizeId);
                    }
                }
            }
            
            //Set the size to the first option
            setSelected(htmlIdArray[2]);
            break;
            
        case htmlIdArray[1]:
            //Reset size
            resetDropdowns(htmlIdArray[2]);
            
            for(var index = 0; index < informationValue.length; index++){
                if(value === informationValue[index].colorId){
                    enableOptions(id, informationValue[index].sizeId);
                }
            }
            setSelected(htmlIdArray[2]);
            break;
    }
    setModal(getCurrentInventory());
}

//Find the current
function getCurrentInventory(){
    var informationValue = JSON.parse($("#productsModalHiddenInfo").val());
    
    //loop through results and get the current product they are on
    for(var index = 0; index < informationValue.length; index++){
        if(($('#'+htmlIdArray[0]).val() === informationValue[index].typeId) &&
           ($('#'+htmlIdArray[1]).val() === informationValue[index].colorId) &&
           ($('#'+htmlIdArray[2]).val() === informationValue[index].sizeId) ){
               return informationValue[index];
        }
    }
    return informationValue[0];
}


//function that increments or decrements the quantity value
function productModalQuantity(type){
    var inputValue = $("#productModalQuantityValue").val();
    inputValue = parseInt(inputValue);
    if(type === "minus"){
        if(inputValue < 2){
            $("#productModalQuantityValue").val(1);
            //Disable the minus button
            $("#productModalQuantityValueMinus").attr('disabled',true);
            $("#productModalQuantityValueAdd").attr('disabled',false);
        } else {
            //Enable the minus button
            $("#productModalQuantityValueMinus").attr('disabled',false);
            $("#productModalQuantityValueAdd").attr('disabled',false);
            $("#productModalQuantityValue").val(--inputValue);
        }
    } else { //add
        //var maxNumber = getMaxQuantity(1);
        var current = getCurrentInventory();
        var maxNumber = current.quantity;
        maxNumber = parseInt(maxNumber);
        if(inputValue < maxNumber){
            //enable the minus button
            $("#productModalQuantityValueMinus").attr('disabled',false);
            $("#productModalQuantityValueAdd").attr('disabled',false);
            $("#productModalQuantityValue").val(++inputValue);
        } else {
            //disable the add button
            $("#productModalQuantityValueAdd").attr('disabled',true);
            $("#productModalQuantityValueMinus").attr('disabled',false);
            $("#productModalQuantityValue").val(maxNumber);
        }
    }
    
}


function addToCart(productId, quantity){
    var alertString = "", current = getCurrentInventory();
    var inventoryId = parseInt(current.inventoryId), quantity = parseInt($("#productModalQuantityValue").val());
    
    if(!inventoryId > 0){
        alertString += addAlert("Something went wrong please contact support","danger");
    }
    
    if(!quantity > 0){
        alertString += addAlert("Quantity must be greater than zero","danger");
    }
    
    if(alertString.trim().length < 1){
        $.ajax(
          {
            url : "ajax/addToCart.php",
            type: "POST",
            data : {inventoryId: inventoryId, quantity:quantity},
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
    
    if(alertString.trim().length < 1){
        //Reload the page will use the url to call the server so it will update all of the quantities
        window.location.reload(true);
    } else {
        $("#productsModalAlert").html(alertString);
    }
}

function signIn(){
    //Close the product modal then show the sign in modal
    $('#productModalAddToCartClose').trigger('click');
}

function signInModal(){
    //Function used to make an ajax call then 
    var alertString = "", email = $("#signInModalEmail").val(), password = $("#signInModalPassword").val();
    
    if(!email.trim().length > 0){
        alertString += addAlert("Please enter email address","danger");
    }
    
    if(!password.trim().length > 0){
        alertString += addAlert("Please enter password","danger");
    }
    
    if(alertString.trim().length < 1){
        $.ajax(
          {
            url : "ajax/signIn.php",
            type: "POST",
            data : {email:email, password:password},
            async: false,
            success: function(response) {
                try{
                    //get array from ajax call
                    response = JSON.parse(response);
                    //Update the personId hidden input
                    $('#userLoggedIn').val(response[0]);
                    if(response.length > 1){ //Found an error
                        //Loop through response and create alerts set the index t one because the first is an empty string
                        for(var index = 1; index < response.length;index++){
                            alertString += addAlert(response[index],"danger");
                        }
                        //Reset the password everytime
                        $("#signInModalPassword").val("");
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
    
    if(alertString.trim().length < 1){
        //No errors so the user is now logged in
        
        $('#signInModal').modal('hide');
        $('#productModal').modal('show');
    } else {
        $("#signInModalAlert").html(alertString);
    }
}
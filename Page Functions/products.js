function productModalQuantity(type){
    var value = 1;
}

function setModalValues(id){
    //first reset alerts on the modal
    $("#productsModalAlert").html("");
    //Disable and hide button then show if user is logged in
    $('#productModalAddToCart').attr('disabled',true);
    $('#productModalSignIn').attr('disabled',true);
    $("#productModalSignIn").hide();
    $("#productModalAddToCart").hide();
    //Reset the quantity
    $("#productModalQuantityValue").val(1);
    $("#productModalQuantityValueAdd").attr('disabled',false);
    $("#productModalQuantityValueMinus").attr('disabled',true);
    
    
    //Check if user is signed in
    if(parseInt(getUserId()) < 1){
        //Tell the user they must log in first before adding items to cart
        $("#productsModalAlert").html(addAlert("You must be signed in to add items to your cart","info"));
        $('#productModalSignIn').attr('disabled',false);
        $("#productModalSignIn").show();
        
    } else {
        //User is logged in so we can 
        //show add to cart button
        $('#productModalAddToCart').attr('disabled',false);
        $("#productModalAddToCart").show();
    }
    
}

//function that increments or decrements the quantity value
function productModalQuantity(type){
    debugger;
    var inputValue = $("#productModalQuantityValue").val();
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
        var maxNumber = getMaxQuantity(1);
        //var maxNumber = 10;
        if(inputValue < maxNumber){
            //enable the minus button
            $("#productModalQuantityValueMinus").attr('disabled',false);
            $("#productModalQuantityValue").val(++inputValue);
        } else {
            //disable the add button
            $("#productModalQuantityValueAdd").attr('disabled',true);
            $("#productModalQuantityValueMinus").attr('disabled',false);
            $("#productModalQuantityValue").val(maxNumber);
        }
    }
    
}


function getMaxQuantity(id){
    var returnValue = 0;
    $.ajax(
      {
        url : "ajax/productQuantity.php",
        type: "GET",
        date:{id:id},
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
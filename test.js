function productModalQuantity(type){
    var value = 1;
}


function setModalValues(){
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
        if(inputValue < 1){
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
        var maxNumber = 10;
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
        data:{id:id},
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

function signIn(){
    alert("Signing In");
    var btn = document.getElementById('productModalSignIn');
    btn.addEventListener('click', function() {
    document.location.href = 'signin.php';
    });
}

function addToCart(productId, quantity){
    var alertString = "";
     $.ajax(
          {
            url : "ajax/addToCart.php",
            type: "POST",
            data : {productId: productId, quantity:quantity},
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
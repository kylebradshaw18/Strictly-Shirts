function setModalValues(id){
    
    var alertString = "";
    //first reset alerts on the modal
    $("#productsModalAlert").html(alertString);
    $("#productModalHeaderText").html("Shirt");
    $('#productsModalHiddenInfo').val("");
    $("#productsModalImage").attr("src",$('#productInformationImage_'+id).attr('src'));
    //Reset the quantity
    $("#productModalQuantityValue").val(0);
    $("#productModalQuantityValueAdd").attr('disabled',true);
    $("#productModalQuantityValueMinus").attr('disabled',true);
    
    var htmlIdArray = ['productModalType', 'productModalSize', 'productModalColor'];
    for(var index = 0;index < htmlIdArray.length; index++){
        resetDropdowns(htmlIdArray[index]);
    }
    
    var informationValue = JSON.parse($("#productsHiddenInfo_"+id).val());
    console.log(informationValue);
    
    if(!informationValue > 0){
        alertString += addAlert("Something went wrong please contact support","danger");
    } else { //Have information so we are set
        
        //Now enable all of the options that we get from the information
        //Type
        for(var index = 0; index < informationValue.length; index++){
            enableOptions(htmlIdArray[0], informationValue[index].typeId);
        }
        //Size
        for(var index = 0; index < informationValue.length; index++){
            enableOptions(htmlIdArray[1], informationValue[index].sizeId);
        }
        //Color
        for(var index = 0; index < informationValue.length; index++){
            enableOptions(htmlIdArray[2], informationValue[index].colorId);
        }
        
        
        $("#productsModalHiddenInfo").val(JSON.stringify(informationValue));
        setModal(informationValue[0]);
        
    }
    
    
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
    if(inventory.quantity > 0){
        qu = 1;
    } else {
        
    }
    
    $("#productModalQuantityValue").val(qu);
}

//Function that when it is called it will reset all of the options
function valuesChange(elem){
    var id = $(elem).attr("id");
    var informationValue = JSON.parse($("#productsModalHiddenInfo").val());
    alert($('#productModalSize').val());
    
    switch(id){
        case"productModalType":
            break;
        case"productModalColor":
            break;
        case"productModalSize": //for size we can just change the price
            break;
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
function addScript(  preference ) {
    scr = '<script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js" data-preference-id="' + preference +'" data-button-label="Comprar com Mercado Pago"></script>';
    //$('.wallet ').html( scr );
    $('.wallet ').load( "/btnmp.php?preference="+ preference);
}

let typepay = "credit_card";
let formvalid = false;

$(function(){
    typepay = ($( "#forma_pagamento option:selected" ).val());

    $("input").on("change", function(){
        if( !$(this).val() ) {                      //if it is blank. 
            alert('empty');    
       }
        validforms();
    });
    $("input").on("focusout", function(){
        if( !$(this).val() ) {                      //if it is blank. 
            alert('empty');    
       }
        validforms();
    });
    validforms();
    function validforms(){
        console.log(typepay);
        err = true;
        if( !$("#first_name").val()){
            err = false;
            //alert("Preencha o nome");
        }
        if( !$("#last_name").val()){
            err = false;
            //alert("Preencha o sobrenome");
        }
        if( !$("#docNumber").val()){
            err = false;
            //alert("Preencha o CPF");
        }
        if( !$("#email").val()){
            err = false;
            //alert("Preencha o email");
        }

        if(err){
            getPreference();         
        }
    }

    function getPreference(){
        let data = $("#pay").serialize();
       // console.log(JSON.stringify(items));
        data += "&item="+JSON.stringify(items);
        
        console.log(data);

        $.post("https://checkoutpro.mercado8.com.br/preorder.php", data, function(ret){
            console.log(ret);
           // addScript( preference );
            addScript(ret);
        });
    }

    function validpixform(){

    }

    $( "#forma_pagamento" ).on("change", function(){
        typepay = ($( "#forma_pagamento option:selected" ).val());
        validforms();
    });

    
});
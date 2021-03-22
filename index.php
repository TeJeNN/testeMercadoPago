<?php 
	require_once "header.php"; 

    function criarpreferencia(){
        
            $env = json_decode(file_get_contents("env.json"));
	
        	require __DIR__ .  '/vendor/autoload.php';
            // Configura credenciais
            MercadoPago\SDK::setAccessToken($env->access_token);
            MercadoPago\SDK::setIntegratorId("dev_24c65fb163bf11ea96500242ac130004");
            
            // Cria um objeto de preferência
            $preference = new MercadoPago\Preference();
            
            // webhook //
            $preference->back_urls = array(
                "success" => $env->back_urls->success,
                "failure" => $env->back_urls->failure,
                "pending" => $env->back_urls->pending
                
            );
            $preference->auto_return = "approved";
            
            // payer //
            $payer = new MercadoPago\Payer();
            $payer->name = "Lalo";
            $payer->surname = "Landa";
            $payer->email = 'test_user_92801501@testuser.com';
            $payer->date_created = date("Y-m-d\TH:i:s.u");
            $payer->phone = array(
                "area_code" => '55',
                "number" => '98529-8743'
            );
                
            $payer->identification = array(
                "type" => "CPF",
                "number" => '19119119100'
            );
                
            $payer->address = array(
                "street_name" => 'Rua de teste',
                "street_number" => '1010',
                "zip_code" => '78134-190'
            );

            $preference->payer = $payer;
            
            // allow payments //
            
            $preference->payment_methods = array(
              "excluded_payment_methods" => array(
                array("id" => "amex")
              ),
              "excluded_payment_types" => array(
                array("id" => "ticket")
              ),
              "installments" => $env->limit_installment
            );
            $preference->notification_url = 'https://checkoutpro.mercado8.com.br/retornomp.php';
            $preference->statement_descriptor =  "Tienda E-commerce";
            $preference->external_reference =  "oERDER_1234m8";
            $preference->expires =  FALSE;
            //$preference->collector_id =  725736327;
            
            $ls = json_decode($_REQUEST['item']);
           $items = [];
           
            // Cria um item na preferência
            $item = new MercadoPago\Item();
            $item->title = 'Celular';
            $item->quantity =  1;
            $item->unit_price =  '1000.00';
            $item->currency_id = "BRL";
            $item->picture_url = "https://afenix.com.br/mercadopago/images/celular1-2.webp";
            $item->description = "Descrição do Item";
            $item->category_id = "art";
            array_push($items, $item);
            
            $preference->items = ($items);
            $preference->save();
            echo '<pre>';
            echo '</pre>';
            echo '<script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js" data-preference-id="'.$preference->id.'" data-button-label="Comprar com Mercado Pago"></script>';
              
        //}

    }
    
    //criarpreferencia();
    
?>

<div class="cart-items col-lg-6 col-12">
	<div class="container">
		<h3 class="wow fadeInUp animated" data-wow-delay=".5s">My Shopping Cart(1)</h3>
		
		<div class="cart-header1 wow fadeInUp animated" data-wow-delay=".7s">
			<div class="alert-close1"> </div>
			<div class="cart-sec simpleCart_shelfItem">
				<div class="cart-item cyc">
					<a href="single.php"><img src="images/celular1-2.webp" class="img-responsive" alt=""></a>
				</div>
				<div class="cart-item-info">
					<h4><a href="single.php"> Celular de Tienda e-commerce </a></h4>
					<div class="delivery">
					<p>Valor : </p>
                    <h4><a id="subamount"> R$1000,00 </a></h4>
					<div class="clearfix"></div>
				</div>	
			   </div>
			   <div class="clearfix"></div>
				
			</div>
		</div>
				
	</div>
</div>
	<section>
    	<fieldset class="panel panel-primary col-lg-6 col-12">
    	<legend class="panel-heading"> Pagamento </legend>
    	   <div class="col-xs-12">
        	   <div class="">
    
    
                    <!-- CREDIT CARD FORM STARTS HERE -->
                    <div class=" credit-card-box ">
                        
                        <div class="panel-body">
                            <form role="form" id="pay" name="pay" method="POST" action="/status">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="payment_method">Forma de Pagamento</label>
                                            <div class="input-group">
                                                <select id="forma_pagamento">
                                                    <option id="credit_card" value="credit_card">Cartão</option>
                                                    <option id="pix"  value="pix">PIX</option>
                                                  </select>
                                                <!-- <input class="form-control" id="email" name="email" type="email" placeholder="Seu email" /> -->
                                                <!-- <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span> -->
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="email">EMAIL</label>
                                            <div class="input-group">
                                                <input class="form-control" require id="email" name="email" type="email" placeholder="Seu email">
                                                <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="first_name">Nome</label>
                                            <div class="input-group">
                                                <input class="form-control" require id="first_name" name="first_name" type="text" placeholder="Seu Nome">
                                                <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="last_name">Sobrenome</label>
                                            <div class="input-group">
                                                <input class="form-control" require id="last_name" name="last_name" type="text" placeholder="Seu Sobrenome">
                                                <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="docNumber">NUMERO DO DOCUMENTO</label>
                                            <div class="input-group">
                                                <input class="form-control" require type="text" name="docNumber" id="docNumber" data-checkout="docNumber" placeholder="19119119100">
                                                <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                                <input data-checkout="docType" type="hidden" value="CPF">
                                                <input data-checkout="siteId" type="hidden" value="MLB">
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="phone">Telefone</label>
                                            <div class="input-group">
                                                <input class="form-control" require type="text" name="dd" id="dd" placeholder="11">
                                                <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                                
                                                <input class="form-control" require type="text" name="phone" id="phone" placeholder="99999-9999">
                                                <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                                
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="phone">Endereco</label>
                                            <div class="input-group">
                                                <input class="form-control" require type="text" name="street" id="street" placeholder="Rua">
                                                <input class="form-control" require type="text" name="numend" id="numend" placeholder="Número">
                                                <input class="form-control" require type="text" name="zip" id="zip" placeholder="Código">
                                                
                                            </div>
                                        </div>
    
                                    </div>
                                </div>
    
                                <div class="row">
                                   
                                </div>
                                
                               
                                <div class="row" style="display:none;">
                                    <div class="col-xs-12">
                                        <p class="payment-errors"></p>
                                    </div>
                                </div>
                                <input type="hidden" id="deviceId">
                                <?php criarpreferencia(); ?>
                            </form>
                        </div>
                        </div>
                </div>
            </div>
</section>
                        
<?php require_once "footer.php"; ?>
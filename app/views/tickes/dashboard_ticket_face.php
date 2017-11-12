<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php  $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
<?php 


	if (!isset($retorno)) {
      	$retorno ="registro_ticket";
    }

 $attr = array('class' => 'form-horizontal', 'id'=>'form_participantes','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
 echo form_open('/validar_tickets', $attr);
?>		
<div class="container">
	
	<div class="row">
		
			<div class="panel-body">

				<div class="col-lg-6 col-lg-offset-2 col-md-9 col-sm-9 col-xs-12">
					<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12">
						<h2 class="text-center">REGISTRO DE TICKETS</h2>
					</div>
					<div class="form-group">
						<label for="tienda" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Núm. Tienda</label>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<input type="text" class="form-control" id="tienda" name="tienda" placeholder="tienda">
							<span class="help-block" style="color:white;" id="msg_tienda"> </span> 
						</div>
					</div>

					<div class="form-group">
						<label for="ticket" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Núm. Ticket</label>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<input type="text" class="form-control" id="ticket" name="ticket" value="<?php echo $this->session->userdata('num_ticket_participante') ?>" placeholder="ticket">
							 <span class="help-block" style="color:white;" id="msg_ticket"> </span> 
						</div>
					</div>
					
					<div class="form-group">
						<label for="transaccion" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Núm. Transacción</label>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<input type="text" class="form-control" id="transaccion" name="transaccion" placeholder="transacción">
							<span class="help-block" style="color:white;" id="msg_transaccion"> </span> 
						</div>
					</div>

					<div class="form-group" style="display:none;">
						<label for="clave_producto" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Clave de producto</label>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<input type="text" class="form-control" id="clave_producto" name="clave_producto" value="1234512345111" placeholder="clave producto">
							<span class="help-block" style="color:white;" id="msg_clave_producto"> </span> 
						</div>
					</div>					
							
				
					<div class="form-group">
						<label for="compra" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Fecha de compra</label>
						<div class="input-group date compra col-lg-9 col-md-9 col-sm-9 col-xs-9">
						  <input id="compra" name="compra" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span> 
						</div>
						<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-9 col-xs-offset-3">
							<span class="help-block" style="color:white;" id="msg_compra"> </span>
						</div>
					</div>


					<div class="form-group" style="display:none;">
						<label for="id_litraje" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Litraje</label>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
									<select name="id_litraje" id="id_litraje" class="form-control">
											<?php foreach ( $estados as $estado ){ ?>
													<option value="<?php echo $estado->id; ?>"><?php echo $estado->nombre; ?></option>
											<?php } ?>
									</select>
						</div>
					</div>

					<div class="form-group" style="display:none;">
						<label for="cantidad" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Cantidad</label>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<input type="text" class="form-control" id="cantidad" name="cantidad" value="1" placeholder="Cantidad">
							<span class="help-block" style="color:white;" id="msg_cantidad"> </span> 
						</div>
					</div>
					
					<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12">
						<button type="submit" class="btn btn-info" value="REGISTRARME"/>
								<img src="<?php echo base_url().$this->session->userdata('c13'); ?>">
						</button>
					</div>

				</div>
				
				<div class="lata reg-t col-lg-2 col-md-3 col-sm-3 col-xs-12">
					<img src="<?php echo base_url().$this->session->userdata('c11'); ?>" class="img-responsive">
				</div>
		
		</div>
		
	</div>
</div>


<?php echo form_close(); ?>


<button onclick="myFacebookLogin()">Login with Facebook</button>





 <script type="text/javascript">
   
    window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '379085212491844',
	      channelUrl : '//192.241.172.17/',
	      cookie     : false, 
	      status     : true,
	      version    : 'v2.8' // use graph api version 2.8
	    });


	    FB.getLoginStatus(function(response) {
		    if (response.status === 'connected') {
			     var uid = response.authResponse.userID;
			     var accessToken = response.authResponse.accessToken;
		     
				FB.ui(
				       {
					      method: 'feed',
					      name: 'Pepsi en la Web',
					      link: 'https://carlitoxenlaweb.blogspot.com/',
					      picture: 'https://192.241.172.17/img/lata_pepsi.png',
					      caption: 'El titulo de xxxxxxx',
					      description: 'Aqui esta toda la descripción de lo que tengo que publicar.'
				       },

				       function(response) {
					      if (response && response.post_id) {
					         // El usuario publico en el muro
				    		 console.log('El usuario publico en el muro');
					      } else {
					         // El usuario cancelo y no publico nada
						     console.log('El usuario cancelo y no publico nada');
					      }
				       }
				);

			    FB.api('/me', function(response) {
			       $("#response").html("Bienvenido "+ response.name +", has iniciado sesión en facebook");
			    });

     		} else if (response.status === 'not_authorized') {
			     
			     $("#response").html("Existe una sesión abierta pero no ha aceptado el APP");
			      console.log('Existe una sesión abierta pero no ha aceptado el APP');
			     FB.login(function(response) {

					if (response && response.post_id) {
				        // El usuario publico en el muro
							console.log('El usuario publico en el muro');
				    } else {
				        // El usuario cancelo y no publico nada
						console.log('El usuario cancelo y no publico nada');
				    }


			      // Aqui solicitamos los permisos al usuario para utilizar el app con su cuenta
			     }, {}); //scope: 'publish_stream'


			} else {
     			$("#response").html("No hay sesión iniciada en facebook");

				 FB.ui(
				       {
				      method: 'feed',
				      name: 'Pepsi en la Web',
				      link: 'https://carlitoxenlaweb.blogspot.com/',
				      picture: 'https://192.241.172.17/img/lata_pepsi.png',
				      caption: 'El titulo de xxxxxxx',
				      description: 'Aqui esta toda la descripción de lo que tengo que publicar.'
				       },
				       function(response) {
				      if (response && response.post_id) {
				        // El usuario publico en el muro
					console.log('El usuario publico en el muro');
				      } else {
				        // El usuario cancelo y no publico nada
					console.log('El usuario cancelo y no publico nada');
				      }
				       }
				     );


    		}

     	}); //fin de FB.getLoginStatus(function(response) {
    }; //fin de window.fbAsyncInit = function() {
 
 	function myFacebookLogin() {  
	     (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/es_LA/all.js";
	     fjs.parentNode.insertBefore(js, fjs);
	      }(document, 'script', 'facebook-jssdk'));

	}     

   
  </script>









<?php $this->load->view('footer'); ?>


<div class="modal fade bs-example-modal-lg" id="modalMessage" ventana="redi_ticket" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
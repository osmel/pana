<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
 $cantidad_puntos="100";

 ?>

	<div class="modal-header felicidadesmodal">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body felicidadessi" style="background-image:url('<?php echo base_url()?>img/felicidades1.png');    background-size: cover;">
				
				<h1 class="felic">FELICIDADES</h1>
				<?php 
				echo '<h4 class="text-center puntos-ganados">';
					echo 'GANA 100 PUNTOS solo por compartir';
				echo '</h4>';
				?>

				
				 <button onclick="myFacebookLogin()" style="background-color: transparent; border: none; margin: 0 auto; display: block;">
					<img src="<?php echo base_url().$this->session->userdata('c22'); ?>" class="img-responsive" style="margin:3px auto">
				</button> 
			
		<div class="alert" id="messagesModal"></div>
	</div>
	<div class="modal-footer">
		
	</div>



<script type="text/javascript">

   

   window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '469450303424001',
			//	      channelUrl : '//165.227.77.136/',
			//xfbml      : true,
	      cookie     : false, 
	      status     : true,
	      version    : 'v2.8' // use graph api version 2.8
	    });


	    FB.getLoginStatus(function(response) {
			
		    if (response.status === 'connected') {  //cuando esta conectado
			    var uid = response.authResponse.userID;
			    var accessToken = response.authResponse.accessToken;
		     		
				FB.ui({
				      method: 'feed',
				      name: 'Vamonos a españa con Calimax',
				      link: 'https://www.vamonosaespanaconcalimax.com',
				      picture: 'https://www.vamonosaespanaconcalimax.com/img/pepsi_fbshare.jpg',
				      caption: 'Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017',
				      description: 'Gana uno de los 3 viajes dobles a Madrid'
				    },
				    function(response) {
						if (response !=null) { 	
					        // El usuario publico en el muro
							console.log('El usuario publico en el muro');
							window.location.href = 'registrar_facebook/'+($cantidad_puntos);
					      } else {
					        // El usuario cancelo y no publico nada
							console.log('El usuario cancelo y no publico nada');
							window.location.href = 'registrar_facebook/'+"0";
					      }
				     }
			    );

			    FB.api('/me', function(response) {
			       $("#response").html("Bienvenido "+ response.name +", has iniciado sesión en facebook");
			    });

     		} else if (response.status === 'not_authorized') { //cuando esta conectado pero no por la app
				FB.ui({
					      method: 'feed',
					      name: 'Vamonos a españa con Calimax',
					      link: 'https://www.vamonosaespanaconcalimax.com',
					      picture: 'https://www.vamonosaespanaconcalimax.com/img/pepsi_fbshare.jpg',
					      caption: 'Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017',
					      description: 'Gana uno de los 3 viajes dobles a Madrid'
				       },
				       function(response) {
							if (response !=null) { 	
						        // El usuario publico en el muro
								console.log('El usuario publico en el muro');
								window.location.href = 'registrar_facebook/'+($cantidad_puntos);
						    } else {
						        // El usuario cancelo y no publico nada
								console.log('El usuario cancelo y no publico nada');
								window.location.href = 'registrar_facebook/'+"0";
						    }
					    }
				);
			} else {
     			$("#response").html("No hay sesión iniciada en facebook");
				FB.ui({
					      method: 'feed',
					      name: 'Vamonos a españa con Calimax',
					      link: 'https://www.vamonosaespanaconcalimax.com',
					      picture: 'https://www.vamonosaespanaconcalimax.com/img/pepsi_fbshare.jpg',
					      caption: 'Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017',
					      description: 'Gana uno de los 3 viajes dobles a Madrid'
				      },
				      function(response) {
							if (response !=null) { 	
						        // El usuario publico en el muro
								console.log('El usuario publico en el muro');
								window.location.href = 'registrar_facebook/'+($cantidad_puntos);
						      } else {
						        // El usuario cancelo y no publico nada
								console.log('El usuario cancelo y no publico nada');
								window.location.href = 'registrar_facebook/'+"0";
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



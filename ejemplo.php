<!DOCTYPE html>
<html lang="es_MX">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>probando facebook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta property="og:url" content="https://www.vamonosaespanaconcalimax.com/ejemplo.php" />
	<meta property="fb:app_id" content="1498307526873111" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017" />
	<meta property="og:description" content="Gana uno de los 3 viajes dobles a Madrid" />
	<meta property="og:image" content="https://www.vamonosaespanaconcalimax.com/img/logo.png"  /> 
	<meta property="og:image:alt" content="image"  /> 

	
	
</head>
<body>

	<fb:login-button 
	  
	  onlogin="checkLoginState();">
	</fb:login-button>
</body>
</html>


<script>


  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1498307526873111',
      cookie     : false,
      xfbml      : true,
      version    : 'v2.8'
    });

//scope="public_profile,email"









	    FB.getLoginStatus(function(response) {
			//alert("1 "+response);
		    if (response.status === 'connected') {
			     var uid = response.authResponse.userID;
			     var accessToken = response.authResponse.accessToken;

		     		
				FB.ui(
				       {
				      method: 'feed',
				      name: 'Vamonos a españa con Calimax',
				      link: 'https://www.vamonosaespanaconcalimax.com',
				      picture: 'https://www.vamonosaespanaconcalimax.com/img/pepsi_fbshare.jpg',
				      caption: 'Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017',
				      description: 'Gana uno de los 3 viajes dobles a Madrid'
				       },
				       function(response2) {
					console.log(response2);					
					
				      //if (response && response.post_id) {
				      if (response =="undefined") {	
				        // El usuario publico en el muro
						console.log('El usuario publico en el muro1');
						
				      } else {
				        // El usuario cancelo y no publico nada
						console.log('El usuario cancelo y no publico nada1');
						
				      }
				       }
				     );

				    FB.api('/me', function(response) {
				      
				      console.log(response);					
				      console.log('has iniciado session con facebook');
				    });

     		} else if (response.status === 'not_authorized') {
			     
			     //$("#response").html("Existe una sesión abierta pero no ha aceptado el APP");
			      //console.log('Existe una sesión abierta pero no ha aceptado el APP');
				 FB.ui(
				       {
				      method: 'feed',
				     name: 'Vamonos a españa con Calimax',
				      link: 'https://www.vamonosaespanaconcalimax.com',
				      picture: 'https://www.vamonosaespanaconcalimax.com/img/pepsi_fbshare.jpg',
				      caption: 'Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017',
				      description: 'Gana uno de los 3 viajes dobles a Madrid'
				       },
				       function(response) {
					//alert("3 "+response);
				      //if (response && response.post_id) {
				      	if (response !=null) {
				        // El usuario publico en el muro
						console.log('El usuario publico en el muro2');
					
				      } else {
				        // El usuario cancelo y no publico nada
						console.log('El usuario cancelo y no publico nada2');
						
				      }
				       }
				     );




			} else {
     			
     			console.log('No hay sesión iniciada en facebook');

				FB.ui(
				       {
				      method: 'feed',
				      link: 'https://www.vamonosaespanaconcalimax.com/ejemplo.php',
				      caption: 'Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017',
				      /*
				      name: 'Vamonos a españa con Calimax',
				      	picture: 'https://www.vamonosaespanaconcalimax.com/img/pepsi_fbshare.jpg',
				      	description: 'Gana uno de los 3 viajes dobles a Madrid'
				      	*/
				       },
				       function(response) {
					
					   console.log(response);
				    
				     if (response !=null) { 	
				    
						console.log('El usuario publico en el muro3');
					
				      } else {
				    
						console.log('El usuario cancelo y no publico nada3');
					
				      }
				       }
				     );


    		}

     	}); //fin de FB.getLoginStatus(function(response) {
    }; //fin de window.fbAsyncInit = function() {



	  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));










    //FB.AppEvents.logPageView();   
//  };




function checkLoginState() {




  /*
  FB.getLoginStatus(function(response) {
  	console.log(response);
    //statusChangeCallback(response);
  });
*/

}

</script>


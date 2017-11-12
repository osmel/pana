jQuery(document).ready(function($) {

	var opts = {
		lines: 13, 
		length: 20, 
		width: 10, 
		radius: 30, 
		corners: 1, 
		rotate: 0, 
		direction: 1, 
		color: '#E8192C',
		speed: 1, 
		trail: 60,
		shadow: false,
		hwaccel: false,
		className: 'spinner',
		zIndex: 2e9, 
		top: '50%', // Top position relative to parent
		left: '50%' // Left position relative to parent		
	};


	
        jQuery('.icheck1').each(function() {
            var checkboxClass = jQuery(this).attr('data-checkbox') ? jQuery(this).attr('data-checkbox') : 'icheckbox_minimal-grey';
            var radioClass = jQuery(this).attr('data-radio') ? jQuery(this).attr('data-radio') : 'iradio_minimal-grey';

            if (checkboxClass.indexOf('_line') > -1 || radioClass.indexOf('_line') > -1) {
                jQuery(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass,
                    insert: '<div class="icheck_line-icon"></div>' + jQuery(this).attr("data-label")
                });
            } else {
                jQuery(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass
                });
            }
        });

	
	jQuery(".navigacion").change(function()	{
	    document.location.href = jQuery(this).val();
	});

   	var target = document.getElementById('foo');


		jQuery("#fecha_nac").dateDropdowns({
					submitFieldName: 'fecha_nac', //Especificar el "atributo name" para el campo que esta oculto
					submitFormat: "dd-mm-yyyy", //Especificar el formato que la fecha tendra para enviar
					displayFormat:"dmy", //orden en que deben ser prestados los campos desplegables. "dia, mes, año"
					//initialDayMonthYearValues:['Día', 'Mes', 'Año'],
					yearLabel: 'Año', //Identifica el menú desplegable "Año"
					monthLabel: 'Mes', //Identifica el menú desplegable "Mes"
					dayLabel: 'Día', //Identifica el menú desplegable "Día"
					monthLongValues: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					monthShortValues: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					daySuffixes: false,  //que no tengan sufijo
					minAge:18, //edad minima
					maxAge:150, //edad maxima

				});

   	//https://github.com/IckleChris/jquery-date-dropdowns
/*
	jQuery('.input-group.date.nac').datepicker({
		//startView: 2,
		format: "dd-mm-yyyy",
	    language: "es",
	    autoclose: true,
	    todayHighlight: true

	});

	jQuery("#fecha_nac").inputmask("99-99-9999", {
            "placeholder": "dd-mm-yyyy",
            //clearMaskOnLostFocus: true
            //'autoUnmask' : true
    });*/

    //Inputmask.unmask("23/03/1973", { alias: "dd/mm/yyyy"}); //23031973



	jQuery('.input-group.date.compra').datepicker({
		//startView: 2,
		
		format: "mm/dd/yy",
		startDate: "03/15/2017", //"-2d"
		endDate: "+0d", 
	    language: "es",
	    autoclose: true,
	    todayHighlight: true

	});



	//gestion de usuarios (crear, editar y eliminar )
	jQuery('body').on('submit','#form_participantes', function (e) {	


		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);

		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				if(data != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					
					jQuery('#msg_tienda').html(data.tienda);
					jQuery('#msg_ticket').html(data.ticket);
					jQuery('#msg_transaccion').html(data.transaccion);
					jQuery('#msg_clave_producto').html(data.clave_producto);
					jQuery('#msg_compra').html(data.compra);
					jQuery('#msg_id_litraje').html(data.id_litraje);
					jQuery('#msg_cantidad').html(data.cantidad);					
  				    jQuery('#msg_general').html(data.general);
				


				}else{


						spinner.stop();
						jQuery('#foo').css('display','none');

						var url = "/proc_modal_instrucciones";
						jQuery('#modalMessage').modal({
						  	show:'true',
							remote:url,
						}); 	

						/*
						$catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/'+$catalogo;				
						*/






				}
			} 
		});
		return false;
	});	

jQuery("body").on('hide.bs.modal','#modalMessage[ventana="redi_ticket"]',function(e){	
	//alert('asdasdasdas');
	$catalogo = jQuery(this).attr('valor'); //e.target.name;
	window.location.href = '/'+$catalogo;						    
});





	//gestion de usuarios (crear, editar y eliminar )
	jQuery('body').on('submit','#form_reg_participantes', function (e) {	


		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);

		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				if(data != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					
					jQuery('#msg_nombre').html(data.nombre);
					jQuery('#msg_apellidos').html(data.apellidos);
					jQuery('#msg_nick').html(data.nick);
					jQuery('#msg_email').html(data.email);
					jQuery('#msg_calle').html(data.calle);
					jQuery('#msg_numero').html(data.numero);
					jQuery('#msg_colonia').html(data.colonia);
					jQuery('#msg_municipio').html(data.municipio);
					jQuery('#msg_cp').html(data.cp);
					jQuery('#msg_ciudad').html(data.ciudad);

					//jQuery('#msg_id_estado').html(data.id_estado);
					jQuery('#msg_pass_1').html(data.pass_1);
					jQuery('#msg_pass_2').html(data.pass_2);					

					jQuery('#msg_celular').html(data.celular);					
					jQuery('#msg_telefono').html(data.telefono);					
					jQuery('#msg_coleccion_id_aviso').html(data.coleccion_id_aviso);					
					jQuery('#msg_coleccion_id_base').html(data.coleccion_id_base);					
					jQuery('#msg_fecha_nac').html(data.fecha_nac);					
					jQuery('#msg_general').html(data.general);
				

				}else{
						$catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/'+$catalogo;				
				}
			} 
		});
		return false;
	});	



  	jQuery("#ticket").inputmask("9999 9999 9999 9999 9999", {
            placeholder: " ",
            clearMaskOnLostFocus: true
    });

 	

	jQuery('body').on('submit','#form_registrar_ticket', function (e) {	


		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);

		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				if(data != true){

					
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#msg_general').html(data.general);
					/*
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);*/
				}else{
					
						$catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/'+$catalogo;				
				}
			} 
		});
		return false;
	});	


//logueo y recuperar contraseña
	jQuery("#form_logueo_participante").submit(function(e){
		jQuery('#foo').css('display','block');

		var spinner = new Spinner(opts).spin(target);

		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				
				if(data != true){
					spinner.stop();
					jQuery('#foo').css('display','none');

		
					jQuery('#msg_email').html(data.email);
					jQuery('#msg_contrasena').html(data.contrasena);
  				    jQuery('#msg_general').html(data.general);
				

					
				}else{
						$catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/'+$catalogo;				
				}
			} 
		});
		return false;
	});






var hash_url = window.location.pathname;


//http://yises.com/blog/2015/06/25/problema-con-el-localstorage-y-modo-incognito-en-safari/
//https://fernetjs.com/2012/12/almacenando-en-el-cliente-localstorage-sessionstorage-y-cookies/

//if (window.localStorage) 
//https://developers.facebook.com/docs/facebook-login/web
//https://developers.facebook.com/docs/javascript/advanced-setup
//https://www.facebook.com/sharer/sharer.php?u=http://67.205.182.175/

{
				if  (hash_url=="/registro_ticket") { //registro ticket
					var started =0;
						jQuery.ajax({
							        url : '/num_conteo',
							        data : { 
							        	//started: started,
							        },
							        type : 'POST',
							        dataType : 'json',
							        success : function(data) {	

							        	started = data.num;
							        	//console.log(started);

									    if   (  (data.registro_ticket==true) )  {  //validar si le toca jugar o registrar ticket 	 	        	

										        	//console.log(localStorage.getItem('miTiempo'));

										        	//timer2 = (localStorage.getItem('miTiempo') !=0) ?  localStorage.getItem('miTiempo') : "5:00";

									        	if (data.tiempo != "0:00") { //es la primera vez que entra es decir es igual a 5:00
									        		localStorage.setItem('miTiempo',  data.tiempo_comienzo );
									        	} 

							        			var timer2 = localStorage.getItem('miTiempo');	
							        	
										
												var interval = setInterval(function() {


													  var timer = timer2.split(':');
													  //by parsing integer, I avoid all extra string processing
													  var minutes = parseInt(timer[0], 10);
													  var seconds = parseInt(timer[1], 10);
													  --seconds;
													  minutes = (seconds < 0) ? --minutes : minutes;
													  if (minutes < 0) clearInterval(interval);
													  seconds = (seconds < 0) ? 59 : seconds;
													  seconds = (seconds < 10) ? '0' + seconds : seconds;
													  //minutes = (minutes < 10) ?  minutes : minutes;
													  if (localStorage.getItem('miTiempo').substring(0, 1) !="-"){
														  $('.countdown').html(minutes + ':' + seconds);
													  } else {
													  	  $('.countdown').html('0:00');
													  }	

													  timer2 = minutes + ':' + seconds;
													  localStorage.setItem('miTiempo', minutes + ':' + seconds);

													  if (localStorage.getItem('miTiempo').substring(0, 1) =="-"){
													  	  $('.countdown').html('0:00');
													  }	





													  	if (localStorage.getItem('miTiempo') =="0:00"){
																machine4.stop();
																machine5.stop();
																machine6.stop();
																started=0;

																jQuery.ajax({ //guardar en la cookie el conteo
																        url : '/num_conteo',
																        data : { 
																        	started: started,
																        },
																        type : 'POST',
																        dataType : 'json',
																        success : function(data) {	

																        	started = data.num;

															        	    var url = "/proc_modal_ticket/"+jQuery.base64.encode(minutes + ':' + seconds)+'/'+jQuery.base64.encode(1);
																			jQuery('#modalMessage').modal({
																				  show:'true',
																				remote:url,
																			}); 									        	

																			
																        	
																        }
																});	

														}

												}, 1000)  //fin del tiempo interval



											//jQuery('body').on('click','#deleteUserSubmit[name="procesando_confirmar_pedido"]', function (e) {
											jQuery('body').on('click','#deleteUserSubmit', function (e) {	
												$catalogo = e.target.name;
												window.location.href = '/'+$catalogo;	
											});


											jQuery("body").on('hide.bs.modal','#modalMessage[ventana="redireccion"]',function(e){	
												$catalogo = jQuery(this).attr('valor'); //e.target.name;
												window.location.href = '/'+$catalogo;						    
											});	

											
											jQuery('body').on('submit','#form_sino', function (e) {	
												jQuery('#foo').css('display','block');

												var spinner = new Spinner(opts).spin(target);

												jQuery(this).ajaxSubmit({
													success: function(data){
														
														if(data != true){
															spinner.stop();
															jQuery('#foo').css('display','none');
															jQuery('#messages').css('display','block');
															jQuery('#messages').addClass('alert-danger');
															jQuery('#messages').html(data);
															jQuery('html,body').animate({
																'scrollTop': jQuery('#messages').offset().top
															}, 1000);
														}else{
																$catalogo = e.target.name;
																spinner.stop();
																jQuery('#foo').css('display','none');
																window.location.href = '/'+$catalogo;				
														}
													} 
												});
												return false;
											});



											var machine4 = $("#casino1").slotMachine({
												active	: (started == 3) ? 0 : Math.trunc(parseInt( jQuery.base64.decode(jQuery("#cripto").val())   )/100  ) ,
												delay	: 500,
												randomize: function(index){
													return  isNaN(jQuery.base64.decode(jQuery("#cripto").val()) ) ? 0 : Math.trunc(parseInt( jQuery.base64.decode(jQuery("#cripto").val())   )/100  ) -1; 
												} 

											});

											var machine5 = $("#casino2").slotMachine({
												active	: (started >= 2) ? 1 : Math.trunc( (parseInt( jQuery.base64.decode(jQuery("#cripto").val())   ) % 100  ) /10 ),
												delay	: 500,
												randomize: function(index){
													return  isNaN(jQuery.base64.decode(jQuery("#cripto").val()) ) ? 1 : Math.trunc( (parseInt( jQuery.base64.decode(jQuery("#cripto").val())   ) % 100  ) /10 ) -1; 
												} 

												 
											});

											machine6 = $("#casino3").slotMachine({
												active	: (started >= 1) ? 2 : Math.trunc( (parseInt( jQuery.base64.decode(jQuery("#cripto").val())   ) % 100  ) % 10 ),
												delay	: 500,
												randomize: function(index){
													return  isNaN(jQuery.base64.decode(jQuery("#cripto").val()) ) ? 2 : Math.trunc( (parseInt( jQuery.base64.decode(jQuery("#cripto").val())   ) % 100  ) % 10 ) -1 ; 
												} 

											});

											

											//$("#botonBaraja").click(function(){
												
												//console.log(started);

												switch (parseInt(started) ){
													case 3:
														machine4.shuffle();
														machine5.shuffle();
														machine6.shuffle();
														break;
													case 2:
														machine5.shuffle();
														machine6.shuffle();
														break;
													case 1:
														machine6.shuffle();
														break;
												}





											//});

											$("#botonParar").click(function(){
												switch (parseInt(started) ){
													case 3:
														machine4.stop();
														break;
													case 2:
														machine5.stop();
														break;
													case 1:
														machine6.stop();
														break;
												}
												started--;



												jQuery.ajax({ //guardar en la cookie el conteo
												        url : '/num_conteo',
												        data : { 
												        	started: started,
												        },
												        type : 'POST',
												        dataType : 'json',
												        success : function(data) {	

												        	started = data.num;

												        		if (started==0){
													        		var url = "/proc_modal_ticket/"+jQuery.base64.encode(localStorage.getItem('miTiempo'))+'/'+jQuery.base64.encode(1);
																		jQuery('#modalMessage').modal({
																			  show:'true',
																			remote:url,
																		}); 									        	
																}





												        	
												        }
												});	


											});  //fin de boton parar



										}  // aqui termina modulo de juego			
							        	
							        } //fin del success
						});	 // fin jQuery.ajax
				}  //fin de registro de ticket



}
/*
else {
  throw new Error('Tu Browser no soporta LocalStorage!');
}*/


		

		


/*
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

//var Base64={_keyStr:"eTkFHqausC34vmldkSrLkMwX13kqpDg1CYOd",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}


// Define the string
var string = 'Hello World!';

// Encode the String
var encodedString = Base64.encode(string);
console.log(encodedString); // Outputs: "SGVsbG8gV29ybGQh"

// Decode the String
var decodedString = Base64.decode(encodedString);
console.log(decodedString); // Outputs: "Hello World!"

https://www.codejobs.biz/es/blog/2014/02/18/tipos-de-cifrados-en-php-md5-sha1-y-salt

https://donnierock.com/2012/08/23/libreria-para-usar-md5-y-sha-1-en-javascript/
http://jquery-manual.blogspot.mx/2014/01/criptografia-en-javascript-cryptojs.html
http://pajhome.org.uk/crypt/md5/
http://cryptojs.altervista.org/api/

*/


});	
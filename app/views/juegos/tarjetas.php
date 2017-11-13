<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>

<?php 
//        print_r("osmel".$this->session->userdata('tarjeta_participante')."aaa");die;
        ?>

<div class="container mecanica">
<br><br><br><br><br><br><br>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center">
	<div id="card1"> 
	  <div class="front" carta="1" valor="150"> 
        <?php 

        $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'1+')>=1) ? '' : 'data-target="#lightbox"'; 
            $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'1+')>=1) ? 'card11.png' : 'card1.png';
        ?>
	  	<a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/cartas/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
    	   <img src="<?php echo base_url()?>img/cartas/card11.png">
	  </div> 
	</div>		
</div>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center">
	<div id="card2"> 
	  <div class="front" carta="2" valor="100"> 
	  	        <?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'2+')>=1) ? '' : 'data-target="#lightbox2"'; 
                $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'2+')>=1) ? 'card22.png' : 'card1.png';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/cartas/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
	    <img src="<?php echo base_url()?>img/cartas/card22.png">
	  </div> 
	</div>		
</div>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center">
	<div id="card3"> 
	  <div class="front" carta="3" valor="75">
	  	<?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'3+')>=1) ? '' : 'data-target="#lightbox3"'; 
        $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'3+')>=1) ? 'card33.png' : 'card1.png';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/cartas/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
	    <img src="<?php echo base_url()?>img/cartas/card33.png">
	  </div> 
	</div>		
</div>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center">
	<div id="card4"> 
	  <div class="front" carta="4" valor="50"> 
	  	<?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'4+')>=1) ? '' : 'data-target="#lightbox4"'; 
        $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'4+')>=1) ? 'card44.png' : 'card1.png';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/cartas/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
	    <img src="<?php echo base_url()?>img/cartas/card44.png">
	  </div> 
	</div>		
</div>



<!--imagen 1 -->
<div id="pregunta" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-md-7 text-center contenedorpregu">
        	<span class="titulopop">
        		Verdadera Identidad de CYBORG
        	</span>
        	<ul class="listapop">
        		<li>A) Victor stone</li>
        		<li>B) Barry Allen</li>
        		<li>C) Bruce Wayne</li>
        	</ul>
        	<div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="1" resp="1"><img src="<?php echo base_url()?>img/cartas/btn1.png"></button>
        	</div>
        	<div class="col-md-4 text-center">
        		<button class="btn_respuesta" fig="1" resp="2"><img src="<?php echo base_url()?>img/cartas/btn2.png"></button>
        	</div>
        	<div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="1" resp="3"><img src="<?php echo base_url()?>img/cartas/btn3.png"></button>
        	</div>
        	<div class="col-md-12 text-center">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i><span class="r1"></span></span>
	        </div>
        </div>
        <div class="col-md-5">
        	<img src="<?php echo base_url()?>img/cartas/card11.png">
        </div>

    </div> 
</div>

</div>
<script>

//https://nnattawat.github.io/flip/
    jQuery(document).ready(function($) {
        //si es la primera vez entonces
        /*
        if (!(localStorage.getItem('fondo'))) {
            localStorage.setItem('fondo',  'nada' );
        }
        
        if (!(localStorage.getItem('tiempo_fondo'))) {
            
            localStorage.setItem('tiempo_fondo', '00:00:00' );
            $('span.r1').html(localStorage.getItem('tiempo_fondo'));
        }*/

        if (!(localStorage.getItem('virada'))) {
            localStorage.setItem('virada',  0 );
        }

        jQuery("#card1,#card2,#card3,#card4").flip({
           trigger: 'manual'
        });
        
        
        //jQuery(localStorage.getItem('fondo')).trigger('click');
        
        //cuando da click encima de las imagenes
        jQuery('body').on('click','a[data-toggle="modal"]', function (e) {   
            /*
            localStorage.setItem('tiempo_fondo', '00:00:00' );
             $('span.r1').html(localStorage.getItem('tiempo_fondo'));
            localStorage.setItem('fondo', ('#'+$(this).parent().parent().attr('id')+' [data-target="'+$(this).attr('data-target')+'"]'));
            */

            //localStorage.clear();
            

                        var este= $(this);

             
                         
                        jQuery.ajax({ //guardar en la cookie el conteo
                                url : '/respuesta_tarjeta',
                                data : { 
                                       figura: $(this).parent().attr('carta'),
                                       valor: $(this).parent().attr('valor'),
                                },
                                type : 'POST',
                                dataType : 'json',
                                success : function(data) {  

                                       //window.location.href = '/'+data.redireccion;        
                                       //console.log(data);
                                       /* 
                                        localStorage.setItem('virada',  parseInt(localStorage.getItem('virada'))+1 );
                                        if ( parseInt(localStorage.getItem('virada')) >=2) {
                                            console.log( este.attr('data-target').substr(1) );
                                            $('#pregunta').attr('id',este.attr("data-target").substr(1));

                                        }
                                        */

                                        localStorage.setItem('virada',  parseInt(localStorage.getItem('virada'))+1 );
                                        if ( parseInt(localStorage.getItem('virada')) >=2) {
                                            //console.log( este.attr('data-target').substr(1) );
                                            //$('#pregunta').attr('id',este.attr("data-target").substr(1));

                                            localStorage.setItem('virada',  0 );
                                            var url = "/proc_modal_juego";  
                                            
                                            jQuery('#modalMessage').modal({
                                                show:'true',
                                                remote:url,
                                            });

                                        }



                                      return false;

                                }

                        }); 
            

            jQuery('body').on('click','.btn_respuesta', function (e) {  
                  e.preventDefault();
            //alert('aa')             ;
             //jQuery("#card4").flip(true);
             //console.log( $(this).attr('fig') );
             //console.log( $(this).attr('resp') );
                     
                    jQuery.ajax({ //guardar en la cookie el conteo
                            url : '/respuesta_juego',
                            data : { 
                                   figura: $(this).attr('fig'),
                                respuesta: $(this).attr('resp'),
                                
                            },
                            type : 'POST',
                            dataType : 'json',
                            success : function(data) {  
                                //localStorage.setItem('fondo',  'nada' );
                                //localStorage.setItem('tiempo_fondo', '00:00:00');
                                //localStorage.clear();

                                  window.location.href = '/'+data.redireccion;        
                                  //console.log(data);
                                  return false;

                            }

                    }); 
            });
                

            
                /*//jQuery('body').on('submit','#form_sino', function (e) { 
                jQuery('body').on('click','.btn_respuesta', function (e) {                   
                    jQuery('#foo').css('display','block');
                    console.log(e);
                    //alert('aaa');
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
                });*/



             /*
            */

              //console.log("a->"+localStorage.getItem('virada'));
        });            
        
        //console.log("a->"+localStorage.getItem('virada'));


        jQuery('body').on('click','#card1 [data-target="#lightbox"]', function (e) {               
          jQuery("#card1").flip(true);          //jQuery("#card").off('flip'); //no flipear
        });
        jQuery('body').on('click','#card2 [data-target="#lightbox2"]', function (e) {       
        
          jQuery('#card2').flip(true);
        });
        jQuery('body').on('click','#card3 [data-target="#lightbox3"]', function (e) {               
          jQuery("#card3").flip(true);
        });
        jQuery('body').on('click','#card4 [data-target="#lightbox4"]', function (e) {               
          jQuery("#card4").flip(true);
        });




        /*


        jQuery('body').on('click','.btn_respuesta', function (e) {               
             //jQuery("#card4").flip(true);
             //console.log( $(this).attr('fig') );
             //console.log( $(this).attr('resp') );
             
            jQuery.ajax({ //guardar en la cookie el conteo
                    url : '/respuesta_tarjeta',
                    data : { 
                           figura: $(this).attr('fig'),
                        respuesta: $(this).attr('resp'),
                        tiempo: $('span.r1').html(), //'0:09', //$(this).attr('resp'),
                    },
                    type : 'POST',
                    dataType : 'json',
                    success : function(data) {  
                        //localStorage.setItem('fondo',  'nada' );
                        //localStorage.setItem('tiempo_fondo', '00:00:00');
                        localStorage.clear();

                          window.location.href = '/'+data.redireccion;        
                          //console.log(data);
                          return false;

                    }

            }); 
        });





        var interval = setInterval(function() {
           $('span.r1').html(localStorage.getItem('tiempo_fondo'));
            var timer = $('span.r1').html();

            timer = timer.split(':');
            var hours = parseInt(timer[0], 10);
            var minutes = parseInt(timer[1], 10);
            var seconds = parseInt(timer[2], 10);
            seconds += 1;
            if (seconds > 59) {
                minutes += 1;
                seconds = 00;
                if (minutes > 59) {
                    hours += 1;
                    minutes = 00;
                }
            }
            if (hours < 10 && hours.length != 2) hours = '0' + hours;
            if (minutes < 10 && minutes.length != 2) minutes = '0' + minutes;
            if (seconds < 10 && seconds.length != 2) seconds = '0' + seconds;
            $('span.r1').html(hours + ':' + minutes + ':' + seconds);
            localStorage.setItem('tiempo_fondo',  hours + ':' + minutes + ':' + seconds );

            //console.log(localStorage.getItem('tiempo_fondo'));

            if (hours == 0 && minutes == 0 && seconds == 0)
                clearInterval(interval);
        }, 1000);
        */

    });
</script>

<?php $this->load->view( 'footer' ); ?>

<div class="modal fade bs-example-modal-lg" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>  
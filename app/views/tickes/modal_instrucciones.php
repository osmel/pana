<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	$retorno ="registro_ticket";
    }
 $hidden = array('nada'=>'nada'); 

 ?>
<?php //echo form_open('validar_confirmar_juego', array('class' => 'form-horizontal','id'=>'form_sino','name'=>$retorno, 'method' => 'POST', 'role' => 'form', 'autocomplete' => 'off' ) ,   $hidden ); ?>
	<div class="modal-header">
		<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->		
	</div>
	<div class="modal-body">
		

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
        	
        </div>
        <!--
	        <div class="col-md-5">
	        	<img src="<?php echo base_url()?>img/cartas/card11.png">
	        </div> 
	     -->

    </div> 

	</div>
	<div class="modal-footer">
		<div class="cont">
			<!--<button type="button" class="close continuar ingresar" data-dismiss="modal" aria-label="Close">
				
					CONTINUAR
				
			</button> -->
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
	</div>





	
	
<?php //echo form_close(); ?>

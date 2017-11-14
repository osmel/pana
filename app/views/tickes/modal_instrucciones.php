<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	$retorno ="registro_ticket";
    }
 $hidden = array('nada'=>'nada'); 

 ?>
  
<?php //echo form_open('validar_confirmar_juego', array('class' => 'form-horizontal','id'=>'form_sino','name'=>$retorno, 'method' => 'POST', 'role' => 'form', 'autocomplete' => 'off' ) ,   $hidden ); ?>
	
		

<div class="preguntas">
        <div class="col-md-12 text-center">
        	<span class="titular1">
        		RESPONDE A LA SIGUIENTE TRIVIA PARA OBTENER TUS PUNTOS
        	</span>
        	<span class="pregunta">
        		Verdadera Identidad de CYBORG
        	</span>
        	<ul class="opcionesrespuesta">
        		<li>A) Victor stone</li>
        		<li>B) Barry Allen</li>
        		<li>C) Bruce Wayne</li>
        	</ul>
        	
        </div>
</div> 



	</div>
	<div class="modal-footer">
		<div class="cont">
			<!--<button type="button" class="close continuar ingresar" data-dismiss="modal" aria-label="Close">
				
					CONTINUAR
				
			</button> -->
			<div class="col-md-6 text-center">
                <button class="btn_respuesta" fig="1" resp="1">A)</button>
        	</div>
        	<div class="col-md-6 text-center">
        		<button class="btn_respuesta" fig="1" resp="2">B)</button>
        	</div>
        	<!-- <div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="1" resp="3"><img src="<?php echo base_url()?>img/cartas/btn3.png"></button>
        	</div>
        	<div class="col-md-12 text-center">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i><span class="r1"></span></span>
	        </div> -->
		</div>
	</div>





	
	
<?php //echo form_close(); ?>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	$retorno ="registro_ticket";
    }
 $hidden = array('nada'=>'nada'); 

 ?>
<?php echo form_open('validar_confirmar_juego', array('class' => 'form-horizontal','id'=>'form_sino','name'=>$retorno, 'method' => 'POST', 'role' => 'form', 'autocomplete' => 'off' ) ,   $hidden ); ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>		
	</div>
	<div class="modal-body">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="inst text-center">¡GRACIAS POR REGISTRAR TU TICKET!</h2>
			<p class="instrucciones text-center">
				Ahora aparecerán tres imágenes en movimiento.
			</p>
			<p class="instrucciones text-center">
Oprime el botón para detener el juego cuando lo creas conveniente, para hacer coincidir 3 figuras iguales en posición horizontal.
			</p>
			<p class="instrucciones text-center">
Podrás acumular puntos de la siguiente forma:
			</p>
			<p class="instrucciones text-left amarillo">
				- 50 Pts. Si haces coincidir las tres imágenes.<br>
				- 25 Pts. Si NO logras hacer coincidir las imágenes.<br>
				- Además podrás acumular 50 Pts. Extra si oprimes el botón de compartir en Facebook tu participación.
			</p>
		</div>
	</div>
	<div class="modal-footer">
		<div class="cont">
			<button type="button" class="close continuar ingresar" data-dismiss="modal" aria-label="Close">
				
					CONTINUAR
				
			</button>
		</div>
	</div>




	
	
<?php echo form_close(); ?>

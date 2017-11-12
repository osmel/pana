<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	//$retorno ="registro_ticket";
      	$retorno ="record"."/".$this->session->userdata('id_participante');
    }
 $hidden = array('nada'=>'nada'); 

 ?>
<?php echo form_open('validar_confirmar_juego', array('class' => 'form-horizontal','id'=>'cero_puntos','name'=>$retorno, 'method' => 'POST', 'role' => 'form', 'autocomplete' => 'off' ) ,   $hidden ); ?>
	
	<div class="modal-header felicidadesmodal">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		
	</div>
	<div class="modal-body felicidadessi" style="background-image:url('<?php echo base_url()?>img/felicidades1.png');    background-size: cover;">
				
				
				<h1 class="felic">FELICIDADES</h1>
				<?php 
					
				echo '<h4 class="text-center puntos-ganados">';
					echo 'tu ticket ha sido registrado';
				echo '</h4>';
				?>

			
		<div class="alert" id="messagesModal"></div>
	</div>
	<div class="modal-footer">
		
	</div>
	
<?php echo form_close(); ?>
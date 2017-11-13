<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
 
 <?php 

	if (!isset($retorno)) {
      	$retorno ="tarjetas";
    }
 ?>   

	<div class="container ingresar">

		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h2 class="text-center">Entrar a mi cuenta</h2>
			</div>
		</div>
		
		<div class="row">
			
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 transparenciaformularios" style="float:none;margin:0px auto;">				
				
				<div class="formulario-fondos">

					<?php
 					 $attr = array( 'id' => 'form_logueo_participante','name'=>$retorno, 'class' => 'form-horizontal', 'method' => 'POST', 'autocomplete' => 'off', 'role' => 'form' );
					 echo form_open('validar_login_participante', $attr);
					?>
						 <div class="form-group">
							
							
								<hr>
								<input type="email" class="form-control" id="email" name="email" placeholder="CORREO ELECTRÓNICO">
								<span class="help-block" style="color:white;" id="msg_email"> </span> 
						
						</div>
					
						<div class="form-group">
							
								<input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="CONTRASEÑA">
								<span class="help-block" style="color:white;" id="msg_contrasena"> </span> 
								
								
<hr>
							
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				           <span class="help-block" style="color:white;" id="msg_general"> </span>
				        </div>						
						<div class="form-group">

							
							
							<div class="col-md-6 text-center">
								<a href="<?php echo base_url(); ?>registro_usuario" class="ingresar">NO TENGO CUENTA</a>
							</div>
							<div class="col-md-6 text-center">								
								<button type="submit" class="ingresar">INGRESAR</button>
							</div>
							<div class="col-md-12 text-center" style="margin-top:20px;">
								<a href="<?php echo base_url(); ?>recuperar_participante">¿Olvidaste tu contraseña?</a>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
<?php $this->load->view( 'footer' ); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
 
 <?php 

	if (!isset($retorno)) {
      	$retorno ="registro_ticket"; //ya no se ocupa
    }

 $attr = array('class' => 'form-horizontal', 'id'=>'form_reg_participantes','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
 echo form_open('validar_registros', $attr);
?>		
<div class="container">	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="text-center">REGISTRO DE CUENTA</h2>
		</div>
	</div>

	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 transparenciaformularios" style="float:none;margin:0px auto;">
		
			<div class="panel-body">
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

					<div class="form-group">
						<label for="nombre" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Nombre (s):</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="nombre" name="nombre">
							<span class="help-block" style="color:white;" id="msg_nombre"> </span> 
						</div>
					</div>

					<div class="form-group">
						<label for="apellidos" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Apellidos:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="apellidos" name="apellidos">
							<span class="help-block" style="color:white;" id="msg_apellidos"> </span> 
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Correo electrónico:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="email" class="form-control" id="email" name="email">
							<span class="help-block" style="color:white;" id="msg_email"> </span> 
						</div>
					</div>

					<div class="form-group">

						<label for="fecha_nac" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Fecha de nacimiento:</label>
						<div class="fecha_nac col-lg-8 col-md-8 col-sm-8 col-xs-12">
						  <input type="hidden" id="fecha_nac"  class="form-control">
						</div>
						<div class="col-lg-8 col-lg-offset-4 col-md-8 col-md-offset-4 col-sm-8 col-sm-offset-4 col-xs-8 col-xs-offset-4">
							<span class="help-block" style="color:white;" id="msg_fecha_nac"> </span>
						</div>
					</div>


					<div class="form-group">
						<label for="calle" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">CALLE:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="calle" name="calle">
							<span class="help-block" style="color:white;" id="msg_calle"> </span> 
						</div>
					</div>		

					<div class="form-group">
						<label for="numero" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">NÚMERO:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="numero" name="numero">
							<span class="help-block" style="color:white;" id="msg_numero"> </span> 
						</div>
					</div>	

					<div class="form-group">
						<label for="colonia" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Colonia:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="colonia" name="colonia">
							<span class="help-block" style="color:white;" id="msg_colonia"> </span> 
						</div>
					</div>	
					
					<div class="form-group">
						<label for="municipio" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Municipio:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="municipio" name="municipio">
							<span class="help-block" style="color:white;" id="msg_municipio"> </span> 
						</div>
					</div>		








						
					
				</div>


				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

			
					
					<!--<div class="form-group">
						<label for="fecha_nac" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Fecha de nacimiento:</label>
						<div class="input-group date nac col-lg-9 col-md-9 col-sm-9 col-xs-9">
						  <input id="fecha_nac" name="fecha_nac" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span> 
						</div>
						<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-9 col-xs-offset-3">
							<span class="help-block" style="color:white;" id="msg_fecha_nac"> </span>
						</div>
					</div>-->


					<div class="form-group">
						<label for="cp" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">CÓDIGO POSTAL:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="cp" name="cp">
							<span class="help-block" style="color:white;" id="msg_cp"> </span> 
						</div>
					</div>	
					
					<div class="form-group">
						<label for="ciudad" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Ciudad:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="ciudad" name="ciudad">
							<span class="help-block" style="color:white;" id="msg_ciudad"> </span> 
						</div>
					</div>		


						
					<div class="form-group">
						<label for="celular" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Teléfono celular:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="celular" name="celular">
							<span class="help-block" style="color:white;" id="msg_celular"> </span> 
						</div>
					</div>

					<div class="form-group">
						<label for="telefono" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Teléfono fijo:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="telefono" name="telefono">
							<span class="help-block" style="color:white;" id="msg_telefono"> </span> 
						</div>
					</div>		

					<div class="form-group">
						<label for="direccion" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Ciudad donde hizo la compra:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="direccion" name="direccion">
							<span class="help-block" style="color:white;" id="msg_direccion"> </span> 
						</div>
					</div>		

					<!-- <div class="form-group">
						<label for="id_estado" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Estado:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
							<select name="id_estado" id="id_estado" class="form-control">
									<?php foreach ( $estados as $estado ){ ?>
											<option value="<?php echo $estado->id; ?>"><?php echo $estado->nombre; ?></option>
											
									<?php } ?>
							</select>
							
						</div>
					</div>
 -->


					<div class="form-group">
						<label for="nick" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Nombre de usuario:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="nick" name="nick">
							<span class="help-block" style="color:white;" id="msg_nick"> </span> 
						</div>
					</div>

					

					<div class="form-group">
						<label for="pass_1" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Contraseña:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="password" class="form-control" id="pass_1" name="pass_1">
							<span class="help-block" style="color:white;" id="msg_pass_1"> </span> 
						</div>
					</div>

					<div class="form-group">
						<label for="pass_2" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label">Confirmar Contraseña:</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="password" class="form-control" id="pass_2" name="pass_2">
							<span class="help-block" style="color:white;" id="msg_pass_2"> </span> 
						</div>
					</div>			



					


							




				
				</div>
			

									









					

 		  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8 legales tex-center" style="margin: 0px auto;
    float: none;
    clear: both;">	

 		  	<p>He leído y aceptado los siguientes documentos</p>	

              <input style="float:left;width:20px;" type="checkbox" id="coleccion_id_aviso" value="1"  name="coleccion_id_aviso" />
              <label >
              		<a href="<?php echo base_url().'aviso'; ?>" class="linkaviso" target="_blank">Aviso de privacidad</a>
              </label>
              <span class="help-block" id="msg_coleccion_id_aviso"> </span> 


			  <input style="float:left;width:20px;" type="checkbox" id="coleccion_id_base" value="1"  name="coleccion_id_base" />
              <label >
              		<a href="<?php echo base_url().'aviso'; ?>" class="linkaviso" target="_blank">Bases legales</a>
              </label>                      
              <span class="help-block" id="msg_coleccion_id_base"> </span> 
          </div>   
		
		<div class="col-lg-4 col-lg-offset-5 col-md-4 col-md-offset-5 col-sm-12 col-xs-12">
           <span class="help-block" style="color:white;" id="msg_general"> </span>
        </div>
		
		
		
		
		</div>

		
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
				<button type="submit" class="btn btn-info" value="REGISTRARME"/>
					<img src="<?php echo base_url()?>img/registrarme.png">
				</button>
		</div>
</div>

<?php echo form_close(); ?>
<?php $this->load->view('footer'); ?>

<div class="modal fade bs-example-modal-lg" id="modalMessage" ventana="facebook" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
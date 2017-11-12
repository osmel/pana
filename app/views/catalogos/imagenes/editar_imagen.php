<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/header'); ?>
<?php $this->load->view( 'admin/navbar' ); ?>

<?php 

 	if (!isset($retorno)) {
      	$retorno ="imagenes";
    }

  $hidden = array('id'=>$id);
  $attr = array('class' => 'form-horizontal', 'id'=>'form_catalogos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
  echo form_open('validacion_edicion_imagen', $attr,$hidden);
?>	
<div class="container">
		<br>
	<div class="row">
		<div class="col-sm-8 col-md-8"><h4>Edición de imagen</h4></div>
	</div>
	<br>
	<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Datos de imagen</div>
			<div class="panel-body">
				<div class="col-sm-8 col-md-6">
					<div class="form-group">
						<label for="imagen" class="col-sm-3 col-md-2 control-label">imagen</label>
						<div class="col-sm-9 col-md-10">
							<?php 
								$nomb_nom='';
								if (isset($imagen ->imagen )) 
								 {	$nomb_nom = $imagen ->imagen ;}
							?>
							<input value="<?php echo  set_value('imagen',$nomb_nom); ?>" type="text" class="form-control" name="imagen" placeholder="imagen">
						</div>
					</div>


					<div class="form-group">
						<label for="puntos" class="col-sm-3 col-md-2 control-label">Puntos</label>
						<div class="col-sm-9 col-md-10">
							<?php 
								$nomb_nom='';
								if (isset($imagen ->puntos )) 
								 {	$nomb_nom = $imagen ->puntos ;}
							?>
							<input value="<?php echo  set_value('puntos',$nomb_nom); ?>" type="text" class="form-control" name="puntos" placeholder="puntos">
						</div>
					</div>





					
					<!-- Imagen-->	
					<div class="form-group">
						<div class="col-sm-12 col-md-12">
							<div class="panel-heading">
								<h4 class="azul bloque-informacion-azul">Imagen</h4>
							</div>
							<div class="panel-body">

									<?php
									if  ($total_archivos->cantidad==0) {
										print "Usted no tiene imagen adjunta. Desea agregarla?";
									} else  { ?>	
 									   Su imagen adjunta actual es: 
	


		 									 <?php  
				                        				$nombre_fichero =$imagen->valor;

				                        				if (file_exists($nombre_fichero)) {
				                        				  echo '<a target="_blank" href="'.base_url().$nombre_fichero.'" type="button">';
				                            			  		echo '<img src="'.base_url().$nombre_fichero.'" border="0" width="50" height="50">';
								                          echo '</a>';	
								                        } else {
								                            
				                        				  echo '<a target="_blank" href="'.base_url().'img/premios/sinimagen.png'.'" type="button">';
				                            			  		echo '<img src="'.base_url().'img/premios/sinimagen.png'.'" border="0" width="50" height="50">';
				                            			  echo '</a>';		
								                        }
						                        ?>



 									     <br/>Desea reemplazarlo por un archivo diferente?
 									<?php     
									}   
									print '<br/>';
									 ?>	
								<input type="file" name="archivo_imagen" id="archivo_imagen" class="ttip" title="Archivo .jpg, .png, .gif." size="20">
							</div>
						</div>
					</div>

		
					<!-- -->					
					



				</div>
			</div>
		</div>
		
		

		<div class="row">
			<div class="col-sm-4 col-md-4"></div>
			<div class="col-sm-4 col-md-4 marginbuttom">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" type="button" class="btn btn-danger btn-block">Cancelar</a>
			</div>
			<div class="col-sm-4 col-md-4">
				<input type="submit" class="btn btn-success btn-block" value="Guardar"/>
			</div>
		</div>
		<br>
	</div></div>
  <?php echo form_close(); ?>
<?php $this->load->view('admin/footer'); ?>


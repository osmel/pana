<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/header'); ?>
<?php $this->load->view( 'admin/navbar' ); ?>

<?php 
 	if (!isset($retorno)) {
      	$retorno ="imagenes";
    }
 $attr = array('class' => 'form-horizontal', 'id'=>'form_catalogos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
 echo form_open('validar_nuevo_imagen', $attr);
?>		
<div class="container">
		<br>	
	<div class="row">
		<div class="col-sm-8 col-md-8"><h4>Nueva imagen</h4></div>
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
							<input type="text" class="form-control" id="imagen" name="imagen" placeholder="imagen">
						</div>
					</div>

					<div class="form-group">
						<label for="puntos" class="col-sm-3 col-md-2 control-label">Puntos</label>
						<div class="col-sm-9 col-md-10">
							<input type="text" class="form-control" id="puntos" name="puntos" placeholder="puntos">
						</div>
					</div>

					<!-- Imagen-->	
					<div class="form-group">
						<div class="col-sm-12 col-md-12">
							<div class="panel-heading">
								<h4 class="azul bloque-informacion-azul">Imagen</h4>
							</div>
							<div class="panel-body">
								<input type="file" class="ttip" title="Archivo .jpg, .png, .gif." name="archivo_imagen" id="archivo_imagen" size="20">
							</div>
						</div>
					</div>	

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
		<br/>
	</div>
</div>
<?php echo form_close(); ?>
<?php $this->load->view('admin/footer'); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view( 'admin/header' ); ?>
<?php $this->load->view( 'admin/navbar' ); ?>

	<!-- Aseguradoras-->
<?php 

	if (!isset($retorno)) {
      	$retorno ="admin";
    }


	  $perfil= $this->session->userdata('id_perfil'); 
	  $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
	  
	  if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) )  {
	  			$coleccion_id_operaciones = array();
	  } 	

?>	

<div class="container margenes">
			<div class="panel panel-primary">
			<div class="panel-heading">Catálogos</div>
			<div class="panel-body">	

					

				<?php if ( ( $perfil == 1 ) || (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones)) ) { ?>
					<div class="row">
						<div class="col-md-3"></div>
							<div class="col-md-6">
								<a href="<?php echo base_url(); ?>litrajes" type="button" class="btn btn-primary btn-lg btn-block" >Litrajes</a>
							</div>
						<div class="col-md-3"></div>
					</div>
					
					<div class="row">
						<div class="col-md-3"></div>
							<div class="col-md-6">
								<a href="<?php echo base_url(); ?>imagenes" type="button" class="btn btn-primary btn-lg btn-block" >Imágenes</a>
							</div>
						<div class="col-md-3"></div>
					</div>
				
				
					<div class="row">
						<div class="col-md-3"></div>
							<div class="col-md-6">
								<a href="<?php echo base_url(); ?>estados" type="button" class="btn btn-primary btn-lg btn-block" >Estados</a>
							</div>
						<div class="col-md-3"></div>
					</div>	


					<div class="row">
						<div class="col-md-3"></div>
							<div class="col-md-6">
								<a href="<?php echo base_url(); ?>premios" type="button" class="btn btn-primary btn-lg btn-block" >Premios</a>
							</div>
						<div class="col-md-3"></div>
					</div>	

				
				<?php } ?>		



					
				
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" type="button" class="btn btn-danger btn-lg btn-block"><i class="glyphicon glyphicon-backward"></i> Regresar 

						</a>
					</div>
					<div class="col-md-3"></div>
				</div>	
			</div>
		</div>
	</div>

<?php $this->load->view('admin/footer'); ?>
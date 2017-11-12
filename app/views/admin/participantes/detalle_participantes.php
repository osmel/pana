<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/header'); ?>
<?php $this->load->view( 'admin/navbar' ); ?>

	<?php
	 	if (!isset($retorno)) {
	      	$retorno ="participantes";
	    }
	?>    


	<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">

	<div class="container">

		
		<div class="row">

			<br>
			<div class="col-xs-12 col-sm-12 col-md-12 marginbuttom">
				<div class="col-xs-12 col-sm-12 col-md-12"><h4>Detalle</h4></div>
			</div>	
		
		</div>
		<br>
		<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Listado</div>
			<div class="panel-body">
			<div class="col-md-12">
				
				<div class="table-responsive">

					<section>
						<table id="tabla_detalle_participantes" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th class="text-center " width="10%"><strong>Puntos</strong></th>
									<th class="text-center cursora" width="10%">Resultados</th>
									<th class="text-center cursora" width="5%">Monto</th>
									<th class="text-center cursora" width="20%">Ticket</th>
									<th class="text-center cursora" width="10%">Transacción </th>
									<th class="text-center cursora" width="10%">Fecha Compra </th>
									<th class="text-center cursora" width="5%">Compartir en Facebook </th>
									<th class="text-center cursora" width="20%">Hora de registro </th>
									<!--<th class="text-center cursora" width="10%">Clave de producto</th>
									<th class="text-center cursora" width="10%">Litraje </th>
									<th class="text-center cursora" width="10%">Cantidad</th>
									-->
								</tr>
							</thead>
						</table>
					</section>
				</div>
			</div>
		</div>
		</div>
		
		<div class="row">

			<div class="col-sm-8 col-md-9"></div>
			<div class="col-sm-4 col-md-3">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" class="btn btn-danger btn-block"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
			</div>

		</div>
		<br/>
	</div>

<?php $this->load->view('admin/footer'); ?>


<div class="modal fade bs-example-modal-lg" id="modalMessage2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	
	

<div class="modal fade bs-example-modal-lg" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	
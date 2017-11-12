<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>

 <?php 

	if (!isset($retorno)) {
      	$retorno ="";
    }

 $attr = array('class' => 'form-horizontal', 'id'=>'form_participantes','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
 echo form_open('/validar_premios', $attr);
?>	

 <div class="container margenes">
	<div class="panel panel-primary">
		<div class="container">	
				<?php if ( isset($premios) && !empty($premios) ) { ?>
					<div class="col-md-12"><h1 class="text-center">Señale su premio</h1></div>
					<div class="row">

						
							<?php $cantidad = count($premios); 
								$cantidad = 12/$cantidad;
							?>
		 					<?php foreach ( $premios as $premio ){ ?>
			 					<div class="col-sm-4 col-md-<?php echo $cantidad; ?> text-center">
									<button type="submit" valor="<?php echo $premio->id; ?>" class="sincita btn btn-info btn-block btn-lg btn-si-no">
										<img src="<?php echo base_url(); ?><?php echo $premio->valor; ?>" border="0" width="150" height="150" />';
									</button>
				                </div>
				            <?php } ?>    
				        
								
					</div>

				<?php } ?>

			</div> 	
		</div> 	
	</div> 	
</div> 			
<?php echo form_close(); ?>

<?php $this->load->view( 'footer' ); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>



<div class="container intro">
	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="text-center">TOP 10</h2>
		</div>
	</div>
			
	<div class="">								
		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12 mimarcador tablagral">
					
			<!-- <h1 style="color:#ffffff">TABLA DE RECORD <?php echo $this->session->userdata('c2'); ?></h1> -->
							
			<?php if ( $this->session->userdata( 'session_participante' ) == TRUE ){ ?>
				<a class="color-blanco" href="<?php echo base_url(); ?>record/<?php echo $this->session->userdata('id_participante'); ?>" >
                       <i class="icon-user"></i> VER MI MARCADOR
                </a>

			<?php  }	?>

			<div class="scroll">							
			<?php if ( isset($records) && !empty($records) ): ?>
				<?php foreach( $records as $record ): ?>
					<p class="datos"><?php echo '@'.$record->nick; ?></p>
					<hr>
				<?php endforeach; ?>
			<?php else : ?>
					<p>
						No hay record todavía
					</p>
			<?php endif; ?>
				
			</div>		

		</div>
	</div>

</div>


<?php $this->load->view( 'footer' ); ?>
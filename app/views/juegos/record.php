<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); 


?>



<div class="container intro">

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="text-center">MI MARCADOR</h2>
		</div>
	</div>

	<div class="">								
		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12 mimarcador transparenciaformularios">
			<?php 

			echo 'Tickets registrados: '.$cantidad.'<br/>';	

			//LOCATE()
			echo 'Tickets registrados: '.$total_iguales.'<br/>';	
			

			
			?>

		</div>
	</div>	

</div>


<?php $this->load->view( 'footer' ); ?>
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
		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12" style="margin-top:50px">
			<?php 

			echo '<div class="col-md-6 text-center"><span class="titulosmarcador">Tickets registrados: </span></div><div class="col-md-6"><div class="puntoscontenedor">'.$cantidad.'</div></div>';	

			//LOCATE()
			echo '<div class="col-md-6 text-center"><span class="titulosmarcador">Puntos acumulados: </span></div><div class="col-md-6"><div class="puntoscontenedor">'.$total_iguales.'</div></div>';	
			

			
			?>

		</div>
	</div>	

</div>


<?php $this->load->view( 'footer' ); ?>
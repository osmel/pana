<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>



<div class="container intro">

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="text-center">MI MARCADOR</h2>
		</div>
	</div>

	<div class="">								
		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12 mimarcador transparenciaformularios">
			<!-- <img src="<?php echo "/".$this->session->userdata('c4'); ?>" class="img-responsive"> -->
			<!-- <h1 style="color:#ffffff">TABLA DE RECORD <?php echo $this->session->userdata('c2'); ?></h1> -->
			
			<!-- <h4 class="nom_usuario"><?php echo '@'.$record->nick; ?><h4> -->
			<!-- <a href="<?php echo base_url(); ?>tabla_general" class="color-blanco">VER TABLA GENERAL</a> -->



			<p class="datos"><span class="textosdatos">TICKETS REGISTRADOS: </span><span><?php echo $record->cantidad- ($record->ptoface==100); ?></span></p>


			<p class="datos"><span class="textosdatos">PUNTOS OBTENIDOS DE LA COMPRA: </span><span><?php echo $record->transaccion; ?></span></p>
			
			
			<p class="datos"><span class="textosdatos">PUNTOS OBTENIDOS DEL JUEGO: </span><span><?php echo $record->total- ($record->ptoface==100)*100; ?></span></p>

			<!-- <p class="datos"><span class="textosdatos">mio: </span><span><?php echo $record->c1.' '.$record->c2.' '.$record->c3.' '.$record->igual  ; ?></span></p>   -->



			<p class="datos"><span class="textosdatos">TOTAL DE PUNTOS DE FACEBOOK: </span><span><?php echo $record->ptoface; ?></span></p>

			
			<p class="datos"><span class="textosdatos">TOTAL DE PUNTOS ACUMULADOS: </span><span><?php echo $record->total+$record->transaccion; ?></span></p>
			   <!--facebook+SUMA(ptoCompra)+SUMA(PtoJuego)  -->
		</div>
	</div>	

</div>


<?php $this->load->view( 'footer' ); ?>
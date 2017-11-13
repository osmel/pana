<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php  $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>

<?php
 	if (!isset($retorno)) {
      	$retorno ="record"."/".$this->session->userdata('id_participante');
    }
?>   

<input type="hidden" id="cripto" name="cripto" value="<?php echo $this->session->userdata('cripto'); ?>">


<div class="container intro">

			<div class="row">								
				<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-12">

					<div class="countdown"></div>

					<!-- tragamon machine example -->
					<div id="casino" style="padding-top:1px;">
						<div class="content">
							
							<div>
								<div id="casino1" class="barajapc" style="">
									<?php 
										$cantImg = $this->session->userdata('cantimagen'); 
										for ($i=1; $i <= $cantImg  ; $i++) { 
									?>
										<div class="tragamon" style="background-image: url(<?php echo $this->session->userdata('i'.$i); ?>);" ></div> 
									<?php 	
										}
									?>	

								</div>

								<div id="casino2" class="barajapc">
									<?php 
										
										for ($i=1; $i <= $cantImg  ; $i++) { 
									?>
										<div class="tragamon" style="background-image: url(<?php echo $this->session->userdata('i'.$i); ?>);" ></div> 
									<?php 	
										}
									?>								
								</div>

								<div id="casino3" class="barajapc">
									<?php 
										 
										for ($i=1; $i <= $cantImg  ; $i++) { 
									?>
										<div class="tragamon" style="background-image: url(<?php echo $this->session->userdata('i'.$i); ?>);" ></div> 
									<?php 	
										}
									?>							
									
								</div>

								<div class="btn-group btn-group-justified btn-group-casino" role="group">									
									<!-- <div id="botonParar" type="button" class="btn btn-primary btn-lg">Parar</div> -->
									<div id="botonParar" type="button"><img src="<?php echo base_url().$this->session->userdata('c18'); ?>" ></div>
								</div>
							</div>

						</div>
						<!--<div class="plecajuego">
							<img src="<?php echo base_url().$this->session->userdata('c19'); ?>" class="img-responsive">
						</div>-->
						<div class="clearfix"></div>
					</div>


				</div>
			</div>	<!-- row -->			  

</div> <!-- container -->


<?php $this->load->view( 'footer' ); ?>


<div class="modal fade bs-example-modal-lg" id="modalMessage" ventana="juegos" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<script type="text/javascript">
   //http://josex2r.github.io/jQuery-SlotMachine/

	$(document).ready(function() {
		function ajuste(){
			ancho = $('.barajapc .tragamon').width();
			$('.barajapc, .barajapc .tragamon').css({'height': ancho});
		}
		ajuste();

		$(window).resize(function(event) {
			ajuste();
		});

	});
</script>

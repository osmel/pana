<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
<style>
.logoderecha{
	display: none;
}
body {
  background-image: url('img/back.jpg'); 
}
</style>
 <?php 
	 if ($this->session->userdata('session_participante') == true) { 
      	$retorno ="registro_ticket";
    } else {
        $retorno ="registro_usuario";
    }


 $attr = array('class' => 'form-horizontal', 'id'=>'form_registrar_ticket','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
 echo form_open('/validar_registrar_ticket', $attr);
?>	

		<div class="container intro" style="">

			<div class="row">								
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="ganar col-lg-7 col-md-7 col-sm-7 col-xs-12 siniz">
							<!-- <img src="<?php echo $this->session->userdata('c10'); ?>" class="img-responsive"> -->
							<img src="<?php echo base_url()?>img/lateralizquierdo.png" class="img-responsive sinizquierdo">
							
						</div>
						<div class="ganar col-lg-5 col-md-5 col-sm-5 col-xs-12">
							<!-- <img src="<?php echo $this->session->userdata('c10'); ?>" class="img-responsive"> -->
							<img src="<?php echo base_url()?>img/lateralderecho.png" class="img-responsive sinizquierdo" style="margin-top: 45px;">
						</div>
						<!-- <div class="lata col-lg-2 col-md-3 col-sm-3 col-xs-4">
							<img src="<?php echo $this->session->userdata('c12'); ?>" class="avion">
							<img src="<?php echo $this->session->userdata('c11'); ?>" class="img-responsive lp">
						</div> -->
						<!-- <div class="registra col-lg-4 col-md-4 col-sm-4 col-xs-8">
							<form id="registra">
								<label>PARTICIPA YA:</label>
								<div class="form-group">
									<input type="text" class="form-control" id="ticket" name="ticket" placeholder="REGISTRA TU TICKET">
									 <span class="help-block" style="color:white;" id="msg_general"> </span> 
								</div>
								<button type="submit" class="btn btn-default registrar">
									<img src="<?php echo $this->session->userdata('c13'); ?>">
								</button>
							</form>
						</div> -->
					</div>
					<!-- <div class="row">
						<div class="col-lg-8 col-md-8 col-sm-10 col-xs-12" style="margin:0px auto;float:none">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 btnshojme">
								<a href="<?php echo base_url(); ?>registro_usuario" class="">
									<img src="<?php echo base_url()?>img/btn_crear.png">
								</a>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 btnshojme">
								<a href="<?php echo base_url(); ?>registro_ticket" class="">
									<img src="<?php echo base_url()?>img/btn_iniciar.png">
								</a>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 btnshojme">
								<a class="ver-ticket">
									<img src="<?php echo base_url()?>img/btn_conoce.png">
								</a>
							</div>
						</div>
					</div> -->
				</div>
			</div>				  
		</div>



<?php echo form_close(); ?>




<?php $this->load->view( 'footer' ); ?>



<div class="modal fade bs-example-modal-lg" id="modalMessage"  ventana="redi_ticket" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<div class="ventana-ejemplos">
	<div class="close">
		<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
	</div>
	<div class="marcas col-md-12 text-center"> 
	<h1 style="color:#ffffff;margin-bottom:40px">MARCAS PARTICIPANTES</h1>
	</div>
	<img style="    padding: 39px;
    width: 100%;" src="<?php echo base_url()?>img/marcas.png">
	<!-- <div class="marcas col-md-8 text-center ocultarchico" style="    float: none;
    margin: 0px auto;
    padding-bottom: 50px;
    display: table;">
		<div class="logo col-md-4">
			<img src="<?php echo base_url()?>img/marcas/HeadS-White[3].png">
		</div>
		<div class="logo col-md-4">
			<img src="<?php echo base_url()?>img/marcas/Nescafe-White[3].png">
		</div>
		<div class="logo col-md-4">
			<img src="<?php echo base_url()?>img/marcas/Coffee-Mate-white[3].png">
		</div>
	</div>
	<div class="marcas col-md-12 text-center ocultarchico">
		<div class="logo col-md-1">
			
		</div>
		<div class="logo col-md-2">
			<img src="<?php echo base_url()?>img/marcas/Cereales-White[3].png">
		</div>
		<div class="logo col-md-2">
			<img src="<?php echo base_url()?>img/marcas/BestFoods-Logo[5].png">
		</div>
		<div class="logo col-md-2">
			<img src="<?php echo base_url()?>img/marcas/logo_KNORR1TintaColor[3].png">
		</div>
		<div class="logo col-md-2">
			<img src="<?php echo base_url()?>img/marcas/Old_Spice-White[3].png">
		</div>
		<div class="logo col-md-2">
			<img src="<?php echo base_url()?>img/marcas/suavitel-white[5].png">
		</div>
		<div class="logo col-md-2">
			
		</div>
	</div>
	<div class="marcas col-md-10 ocultarchico" style="float: none;
    margin: 0px auto;
    padding-top: 50px;
    display: table;">
		<div class="logo col-md-3 text-center">
			<div class="logo col-md-6">
				<img src="<?php echo base_url()?>img/marcas/DelFuerte[3].png">
			</div>
			<div class="logo col-md-6">
				<img src="<?php echo base_url()?>img/marcas/Buffalo[5].png">
			</div>
		</div>
		<div class="logo col-md-3 text-center">
			<div class="logo col-md-6">
				<img src="<?php echo base_url()?>img/marcas/Chokis-White[3].png">
			</div>
			<div class="logo col-md-6">
				<img src="<?php echo base_url()?>img/marcas/Cremax[3].png">
			</div>
		</div>
		<div class="logo col-md-3 text-center">
			<div class="logo col-md-6">
				<img src="<?php echo base_url()?>img/marcas/Lechera-White2[3].png">
			</div>
			<div class="logo col-md-6">
				<img src="<?php echo base_url()?>img/marcas/Maravillas[3].png">
			</div>
		</div>
		<div class="logo col-md-3 text-center">
			<div class="logo col-md-6">
				<img src="<?php echo base_url()?>img/marcas/OceanSpray[3].png">
			</div>
			<div class="logo col-md-6">
				<img src="<?php echo base_url()?>img/marcas/eficaz[3].png">
			</div>
		</div>
		
	</div>
	<div class="logoschicos">
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/HeadS-White[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/Nescafe-White[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/Coffee-Mate-white[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/Cereales-White[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/BestFoods-Logo[5].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/logo_KNORR1TintaColor[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/Old_Spice-White[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/suavitel-white[5].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/DelFuerte[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/Buffalo[5].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/Chokis-White[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/Cremax[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/Lechera-White2[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/Maravillas[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/OceanSpray[3].png">
		</div>
		<div class="logo col-sm-3 col-xs-6 text-center">
			<img src="<?php echo base_url()?>img/marcas/eficaz[3].png">
		</div>
	</div> -->
	
	
</div>

<script type="text/javascript">
ya=0;
function tickets(){
$(".slider").slick({
        dots: false,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        autoplay: true,
  		autoplaySpeed: 5500,
        responsive: [
        	{
        		breakpoint:768,
        		settings: {
        			dots: false,
			        infinite: false,
			        slidesToShow: 2,
			        slidesToScroll: 1,
			        arrows: true,
			        autoplay: true,
  					autoplaySpeed: 5500,
        		}
        	},
        	{
        		breakpoint:481,
        		settings: {
        			dots: false,
			        infinite: false,
			        slidesToShow: 1,
			        slidesToScroll: 1,
			        arrows: true,
			        autoplay: true,
  					autoplaySpeed: 5500,
        		}
        	},
        	{
        		breakpoint:361,
        		settings: {
        			dots: false,
			        infinite: false,
			        slidesToShow: 1,
			        slidesToScroll: 1,
			        arrows: true,
			        autoplay: true,
  					autoplaySpeed: 5500,
        		}
        	}
        ]
      });
ya=1;
}
function cerrar(){	
	$('.ventana-ejemplos').animate({'opacity':0}, 1000, function(){
		$('.ventana-ejemplos').css({'z-index':'-100'});
	});
}
function abrir() {
	$('.ventana-ejemplos').css({'z-index':'1000'});
	$('.ventana-ejemplos').animate({'opacity':1}, 1000, function(){
		if (ya == 0) {
			tickets();
		};		
	});
}

$('a.ver-ticket').click(function() {
	abrir();
});

$('.ventana-ejemplos .close').click(function() {
	cerrar();
});

$(document).ready(function() {
	tickets();
});

</script>
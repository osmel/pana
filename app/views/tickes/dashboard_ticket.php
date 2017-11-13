<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php  $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
<?php 

	if (!isset($retorno)) {
      	$retorno ="tarjetas";
    }

  


 $attr = array('class' => 'form-horizontal', 'id'=>'form_participantes','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
 echo form_open('/validar_tickets', $attr);
?>		

<input type="hidden" id="id_par" name="id_par" value="<?php echo $this->session->userdata('id_participante'); ?>">

<div class="container mecanica">

		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- <h3 class="text-center"><strong><?php echo $this->session->userdata('c2'); ?></strong></h3> -->
				<h2 class="text-center">Registro de ticket</h2>
			</div>
		</div>
		
		<div class="row">
			
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 transparenciaformularios registrof" style="float:none;margin:0px auto;padding: 32px 100px;">	
					
					
					<div class="form-group"  style="margin-bottom:0px">
						<label for="ticket" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">Número de Ticket</label>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" id="ticket" name="ticket" value="<?php echo $this->session->userdata('num_ticket_participante') ?>">
							 <span class="help-block" style="color:white;" id="msg_ticket"> </span> 
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right" style="margin-bottom:15px">
						<a class="ver-ticket">Ver ejemplo de ticket</a>
					</div>

					<div class="form-group">
						<label for="compra" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">Fecha de compra</label>
						<div class="input-group date compra col-lg-9 col-md-9 col-sm-9 col-xs-12">
						  <input id="compra" name="compra" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span> 
						</div>
						<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-9 col-xs-offset-3">
							<span class="help-block" style="color:white;" id="msg_compra"> </span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="monto" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">Monto de la compra</label>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" id="monto" name="monto">
							<span class="help-block" style="color:white;" id="msg_monto"> </span> 
						</div>
					</div>

					<!--<div class="form-group" style="display: none;">
						<label for="transaccion" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">Puntos obtenidos en la compra</label>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" id="transaccion" name="transaccion" value="1">
							<span class="help-block" style="color:white;" id="msg_transaccion"> </span> 
						</div>
					</div>
					-->

					

		<div class="col-lg-4 col-lg-offset-5 col-md-4 col-md-offset-5 col-sm-12 col-xs-12">
           <span class="help-block" style="color:white;" id="msg_general"> </span>
        </div>
					
					
					

				</div>
				
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: -12px;">
						<button type="submit" class="btn btn-info ingresar" value="REGISTRARME"/>
								REGISTRAR
						</button>
					</div>	
		
		</div>
		
	</div>
</div> 
<?php echo form_close(); ?>
<?php $this->load->view('footer'); ?>


<div class="modal fade bs-example-modal-lg" id="modalMessage"  ventana="redi_ticket" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<div class="ventana-ejemplos">
	<div class="close">
		<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
	</div>
	<div class="col-md-2 col-sm-1">
	</div>
	<div class="col-xs-6 col-sm-5 col-md-4 text-center ticketcon">
		<img src="<?php echo base_url()?>img/ticket.png" style="max-width:300px;">
		<!-- <div>
			<img src="<?php echo base_url().$this->session->userdata('c27'); ?>">
		</div>
		<div>
			<img src="<?php echo base_url().$this->session->userdata('c28'); ?>">
		</div>
		<div>
			<img src="<?php echo base_url().$this->session->userdata('c29'); ?>">
		</div> -->
	</div>
	<div class="col-xs-6 col-sm-5 col-md-4 text-center ticketcon">
		<img src="<?php echo base_url()?>img/coloresticket.png" class="textotickets" style="max-width:300px;">
	</div>
	<div class="col-md-2 col-sm-1">
	</div>
	
	<!-- <div class="text-center exp">
		<span>Número de Ticket</span>  <span>Número de Tienda</span>  <span>Número de Compra</span> <span>Número de Transacción</span>
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

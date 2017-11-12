<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
<style>
.logoderecha{
	display: none;
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
						<div class="ganar col-lg-6 col-md-6 col-sm-6 col-xs-12 siniz">
							<!-- <img src="<?php echo $this->session->userdata('c10'); ?>" class="img-responsive"> -->
							<img src="<?php echo base_url()?>img/lateralizquierdo.png" class="img-responsive sinizquierdo" style="    width: 80%;
    margin: 0px auto;">
							<a href="<?php echo base_url(); ?>registro_ticket" class=""><img src="<?php echo base_url()?>img/ganarhome.png" class="img-responsive sinizquierdo" style="margin-top:40px;"></a>
						</div>
						<div class="ganar col-lg-6 col-md-6 col-sm-6 col-xs-12 sinde">
							<!-- <img src="<?php echo $this->session->userdata('c10'); ?>" class="img-responsive"> -->
							<img src="<?php echo base_url()?>img/lateralderecho.png" class="img-responsive sinizquierdo">
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
				</div>
			</div>				  
		</div>



<?php echo form_close(); ?>




<?php $this->load->view( 'footer' ); ?>
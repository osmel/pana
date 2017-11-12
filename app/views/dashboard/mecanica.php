<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>


 <!-- contenido-->
<div class="container mecanica">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="text-center">Como participar</h2>
		</div>
		
		<!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
			<img src="<?php echo base_url().$this->session->userdata('c24'); ?>" class="img-responsive img-center">
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
			<img src="<?php echo base_url().$this->session->userdata('c25'); ?>" class="img-responsive img-center">
		</div> -->
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
			<img src="<?php echo base_url()?>img/mecanica1.png" style="margin: 0px auto;" class="img-responsive sinizquierdo">
		</div>	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
			<img src="<?php echo base_url()?>img/mecanica2.png" style="margin: 0px auto;" class="img-responsive sinizquierdo">
		</div>	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
			<img src="<?php echo base_url()?>img/mecanica3.png" style="margin: 0px auto;" class="img-responsive sinizquierdo">
		</div>	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
			<img src="<?php echo base_url()?>img/mecanica4.png" style="margin-top:60px" class="img-responsive">
		</div>	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
			<img src="<?php echo base_url()?>img/mecanica5.png" style="margin-top:60px"	 class="img-responsive">
		</div>	
	</div>
</div>



<?php $this->load->view( 'footer' ); ?>
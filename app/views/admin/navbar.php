<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row-fluid">
	<div class="navbar navbar-default navbar-custom" role="navigation">
		<div class="container">			
	 
				<div class="navbar-brand">
					<a href="<?php echo base_url(); ?>admin" style="color: #ffffff;"><i class="glyphicon glyphicon-home"></i></a>
				</div>

				<div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			    </div>

					<?php 
						  $perfil= $this->session->userdata('id_perfil'); 
						  $especial= $this->session->userdata('especial'); 

					 ?>	
					
			
				<div class="collapse navbar-collapse" id="main-navbar">
					<ul class="nav navbar-nav navbar-left" id="menu_opciones">
					
								


							<?php if  ( ($especial!=3) ) { ?>	

								<li>
									<a href="<?php echo base_url(); ?>participantes" class="color-blanco">Participantes</a> 
									
								</li>

							<?php } ?>					


				



							<?php if  ( (  $perfil == 1  ) AND ($especial!=3) ) { ?>	
								<li>
									<a href="<?php echo base_url(); ?>usuarios" class="color-blanco">Usuarios</a>
								</li>

							<?php } ?>					



						<?php  if ($this->session->userdata('session')) {  ?>	 
							<li>
								<a href="<?php echo base_url(); ?>salir" class="color-blanco">Salir <i class="glyphicon glyphicon-log-out"></i></a>
							</li>
						<?php } ?>						

					</ul>
				</div>
	 
		</div>
	</div>
</div>
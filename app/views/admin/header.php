<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es_MX">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cerremos con broche de oro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <?php echo link_tag('css/reset.css'); ?>
    <?php echo link_tag('css/estilo.css'); ?>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Raleway:700,400' rel='stylesheet' type='text/css'>
	<?php echo link_tag('css/sistema.css'); ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
</head>
<body>
	<div class="container-fluid1">
		<div id="foo">
			<p id="spin_label" style="position:absolute; width: 100%; top: 50%; margin-top: 60px; text-align: center;">
            </p>
		</div>
		
		<div class="row-fluid1" id="wrapper1">
			<div class="alert" id="messages"></div>

			<div class="container header-content">
						<div class="col-md-6 col-lg-6 col-sm-6 col-xs-3">
							<a href="<?php echo base_url(); ?>">
								<!-- <div class="header-logo col-md-1" style="background: url(<?php echo "/".$this->session->userdata('c4'); ?>);"></div> -->
							</a>
						</div>
						
						<div class="col-md-6 col-lg-6 col-sm-6 col-xs-9">
							<div class="header-titulo text-right">Cerremos con broche de oro</div>
							<div class="text-right" style="color:#104A5A !important"> Bienvenid@: <a href="<?php echo base_url(); ?>actualizar_perfil" style="#104A5A"><?php echo $this->session->userdata( 'nombre_completo' ); ?></a>
						    </div>
					   </div>
					   	 
							<div class="col-md-offset-11" id="bar_salir">
								<a title="" href="<?php echo base_url(); ?>salir" class="ttip color-blanco">Salir <i class="glyphicon glyphicon-log-out"></i></a>
							</div>

				</div>

    <!-- Inicia Formulario -->

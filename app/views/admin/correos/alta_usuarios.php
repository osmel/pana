<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "https://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $this->session->userdata('c2'); ?></title>
</head>
<body style="background:#e9e9e9">
<?php 
	if (!isset($retorno)) {
      	$retorno ="";
    }
 ?> 

	<table border="0" cellspacing="0" cellpadding="0" style="margin:30px auto; padding:0px; max-width:580px; width:100%">
	  <tr>
	   	 <td scope="row" style=" height:45px;">
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81; text-align:center">
	    	 <div style="color:#902227; text-align:center;font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:24px;padding:0 0 30px 0">
	    	 <h1>Nuevo usuario registrado con los siguientes datos:</h1><br>
	    	 NICK: <b><?php echo $nick; ?></b><br>
	    	 EMAIL: <b><?php echo $email; ?></b><br>
	    	 CONTRASEÑA: <b><?php echo $contrasena; ?></b>
	    	 NOMBRE: <b><?php echo $nombre; ?></b><br>
	    	 APELLIDOS: <b><?php echo $apellidos; ?></b>
	    	 CELULAR: <b><?php echo $celular; ?></b><br>
	    	 TELÉFONO: <b><?php echo $telefono; ?></b>
	    	 </div>
	    	</p>
	   	 </td>
	  </tr>

	  
	  
	</table>
	

</body>
</html>
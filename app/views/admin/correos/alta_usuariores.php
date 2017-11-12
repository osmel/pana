<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "https://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Calimax</title>
</head>
<body style="background:#e9e9e9">
<?php 
	if (!isset($retorno)) {
      	$retorno ="";
    }
 ?> 

	<table border="0" cellspacing="0" cellpadding="0" style="margin:30px auto; background-color:white; padding:0px; max-width:580px; width:100%">
	  <tr style="background-color: #122145;">
	   	 <td scope="row" style="border-bottom:5px solid #ebbb34; height:45px; padding: 15px;">
	   	 	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; color:#5e6d81; font-size:18px; font-weight:bold">Estimado usuario:</b></p>
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81">
	    	Has sido dado de alta con el siguiente email: <b><?php echo $email; ?></b>
	    	 y tu contraseña es <b><?php echo $contrasena; ?></b>
	    	</p>
	   	 </td>
	  </tr>
	  <tr>
	    <td scope="row" style="">
	    
			<img alt="pepsiestasenlafinal" src="<?php echo base_url(); ?><?php echo $this->session->userdata('c30'); ?>" style="width:100%; height:auto;"> 

	    </td>
	  </tr>
	  <tr style="background-color:#122145;">
	    <td scope="row" style="border-top:5px solid #ebbb34; padding: 15px;">
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81">		
			Si requieres ayuda o tienes alguna duda contáctanos:
			</p>
			<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81">			
					Correo electrónico: <b><?php echo $this->session->userdata('c1'); ?> </b><br/>
					<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81">		
					    Atención al cliente Ciudad de México: <b>21 55 97 19 </b></p> 
					<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81">		
					Atención al cliente resto de la república: <b>01800 890 98 59</b></p>
									
			</p>
			<br/>


			<p>			
			<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" name="boton" style="background:#ebbb34; font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:18px; color:#122145; padding:10px; border:none; text-decoration:none;">
				IR AL JUEGO
			</a>
			</p>
	    </td>
	  </tr>	  
	  
	</table>
	

</body>
</html>





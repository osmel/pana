<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




$route['default_controller']   = 'home/index';
$route['404_override'] 		   = '';


//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////Registro de usuarios//////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////

$route['registro_usuario']        = 'registro/nuevo_registro';
$route['validar_registros']        = 'registro/validar_registros';

$route['ingresar_usuario']        = 'registro/ingresar_usuario';
$route['validar_login_participante']        = 'registro/validar_login_participante';

$route['recuperar_participante']			= 'registro/recuperar_participante';
$route['validar_recuperar_participante']	= 'registro/validar_recuperar_participante';

$route['desconectar']							= 'registro/desconectar_participante';



$route['registro_ticket']        = 'registro/registro_ticket';
$route['validar_tickets']	= 'registro/validar_tickets';

$route['proc_modal_juego']							= 'registro/proc_modal_juego';

//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////Juegos//////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////

//
$route['tarjetas']								    = 'home/tarjetas';
$route['respuesta_tarjeta']							= 'home/respuesta_tarjeta';

$route['juegos']								    = 'home/juegos';
$route['respuesta_juego']							= 'home/respuesta_juego';


$route['record/(:any)']								= 'home/record/$1';



////////////////////////////////////////////////////////////////////




$route['mecanica']							= 'home/mecanica';
$route['facebook']							= 'home/facebook';

$route['aviso']							= 'home/aviso';
$route['legales']							= 'home/legales';
$route['eleccion_premio']							= 'home/eleccion_premio';


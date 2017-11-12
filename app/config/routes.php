<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

/*
$route['default_controller'] = "aspirantes/index";
$route['404_override'] 		 = '';
*/


$route['default_controller']   = 'home/index';
$route['404_override'] 		   = '';


$route['compartir_imagen']              = 'registro/compartir_imagen';



$route['mecanica']							= 'home/mecanica';
$route['facebook']							= 'home/facebook';

$route['aviso']							= 'home/aviso';
$route['legales']							= 'home/legales';
$route['eleccion_premio']							= 'home/eleccion_premio';

//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////Administracion//////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////

$route['admin']							= 'main/index';
$route['login']							= 'main/login';


$route['usuarios']						= 'main/listado_usuarios';
$route['procesando_usuarios']			= 'main/procesando_usuarios';


	/* necesita server de correo, para que notifique quien se da de alta*/
$route['nuevo_usuario']                 = 'main/nuevo_usuario';
$route['validar_nuevo_usuario']         = 'main/validar_nuevo_usuario';

$route['actualizar_perfil']		         = 'main/actualizar_perfil';
$route['editar_usuario/(:any)']			= 'main/actualizar_perfil/$1';
$route['validacion_edicion_usuario']    = 'main/validacion_edicion_usuario';

$route['eliminar_usuario/(:any)']		= 'main/eliminar_usuario/$1';
$route['validar_eliminar_usuario']    = 'main/validar_eliminar_usuario';

$route['exportar_reportes']    = 'exportar_reportes/exportar';


$route['salir']							= 'main/logout';

$route['validar_login']					= 'main/validar_login';


//recuperar contraseña /* necesita server de correo*/
$route['recuperar_contrasena']			= 'main/recuperar_contrasena';
$route['validar_recuperar_password']	= 'main/validar_recuperar_password';

//historicos de accesos
$route['historico_accesos']                 = 'main/historico_accesos';
$route['procesando_historico_accesos']      = 'main/procesando_historico_accesos';

	//solo faltan este modulo			
			//respaldar informacion	
			$route['respaldar']					= 'respaldo/respaldar';




//participantes
$route['participantes']						= 'main/listado_participantes';
$route['procesando_participantes']			= 'main/procesando_participantes';

//detalle de los participantes
$route['detalle_participante/(:any)']			    = 'main/detalle_participante/$1';
$route['procesando_detalle_participantes']			= 'main/procesando_detalle_participantes';


//historicos de participantes
$route['historico_participantes']                 = 'main/historico_participantes';
$route['procesando_historico_participantes']      = 'main/procesando_historico_participantes';


//historicos de participantes
$route['listado_completo']                 = 'main/listado_completo';
$route['procesando_listado_completo']      = 'main/procesando_listado_completo';




//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////Registro de usuarios//////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////

$route['registro_usuario']        = 'registro/nuevo_registro';
$route['validar_registros']        = 'registro/validar_registros';
$route['desconectar']							= 'registro/desconectar_participante';

$route['validar_login_participante']        = 'registro/validar_login_participante';




$route['registro_ticket']        = 'registro/registro_ticket';
$route['validar_tickets']	= 'registro/validar_tickets';
$route['validar_premios']	= 'registro/validar_premios';

$route['validar_registrar_ticket']	= 'registro/validar_registrar_ticket';




$route['recuperar_participante']			= 'registro/recuperar_participante';
$route['validar_recuperar_participante']	= 'registro/validar_recuperar_participante';



//$route['registro_juego']	= 'registro/registro_juego';




$route['record/(:any)']			= 'registro/record/$1';
$route['publico/(:any)']			= 'registro/publico/$1';

//new ok
$route['registrar_facebook/(:any)']			= 'registro/registrar_facebook/$1';
$route['proc_modal_facebook']		= 'registro/proc_modal_facebook';



//número de conteo del juego
$route['num_conteo']      = 'registro/num_conteo';

$route['proc_modal_ticket/(:any)/(:any)']		= 'registro/proc_modal_ticket/$1/$2';



$route['tabla_general']      = 'registro/tabla_general';




$route['proc_modal_instrucciones']		= 'registro/proc_modal_instrucciones';

$route['proc_modal_cero_puntos']		= 'registro/proc_modal_cero_puntos';

///////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////Catalogos///////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
$route['catalogos']						= 'catalogos/listado_catalogos';



//imagen
$route['imagenes']              = 'catalogos/listado_imagenes';
$route['procesando_cat_imagenes']    = 'catalogos/procesando_cat_imagenes';

$route['nuevo_imagen']                  = 'catalogos/nuevo_imagen';
$route['validar_nuevo_imagen']          = 'catalogos/validar_nuevo_imagen';

$route['editar_imagen/(:any)']      = 'catalogos/editar_imagen/$1';
$route['validacion_edicion_imagen']     = 'catalogos/validacion_edicion_imagen';

$route['eliminar_imagen/(:any)/(:any)'] = 'catalogos/eliminar_imagen/$1/$2';
$route['validar_eliminar_imagen']       = 'catalogos/validar_eliminar_imagen';


//premio
$route['premios']              = 'catalogos/listado_premios';
$route['procesando_cat_premios']    = 'catalogos/procesando_cat_premios';

$route['nuevo_premio']                  = 'catalogos/nuevo_premio';
$route['validar_nuevo_premio']          = 'catalogos/validar_nuevo_premio';

$route['editar_premio/(:any)']      = 'catalogos/editar_premio/$1';
$route['validacion_edicion_premio']     = 'catalogos/validacion_edicion_premio';

$route['eliminar_premio/(:any)/(:any)'] = 'catalogos/eliminar_premio/$1/$2';
$route['validar_eliminar_premio']       = 'catalogos/validar_eliminar_premio';




//estado
$route['estados']              = 'catalogos/listado_estados';
$route['procesando_cat_estados']    = 'catalogos/procesando_cat_estados';

$route['nuevo_estado']                  = 'catalogos/nuevo_estado';
$route['validar_nuevo_estado']          = 'catalogos/validar_nuevo_estado';

$route['editar_estado/(:any)']      = 'catalogos/editar_estado/$1';
$route['validacion_edicion_estado']     = 'catalogos/validacion_edicion_estado';

$route['eliminar_estado/(:any)/(:any)'] = 'catalogos/eliminar_estado/$1/$2';
$route['validar_eliminar_estado']       = 'catalogos/validar_eliminar_estado';


//litraje
$route['litrajes']              = 'catalogos/listado_litrajes';
$route['procesando_cat_litrajes']    = 'catalogos/procesando_cat_litrajes';

$route['nuevo_litraje']                  = 'catalogos/nuevo_litraje';
$route['validar_nuevo_litraje']          = 'catalogos/validar_nuevo_litraje';

$route['editar_litraje/(:any)']      = 'catalogos/editar_litraje/$1';
$route['validacion_edicion_litraje']     = 'catalogos/validacion_edicion_litraje';

$route['eliminar_litraje/(:any)/(:any)'] = 'catalogos/eliminar_litraje/$1/$2';
$route['validar_eliminar_litraje']       = 'catalogos/validar_eliminar_litraje';



//configuracion
$route['configuraciones']					     = 'catalogos/listado_configuraciones';

$route['nuevo_configuracion']                  = 'catalogos/nuevo_configuracion';
$route['validar_nuevo_configuracion']          = 'catalogos/validar_nuevo_configuracion';

$route['editar_configuracion/(:any)']			 = 'catalogos/editar_configuracion/$1';
$route['validacion_edicion_configuracion']     = 'catalogos/validacion_edicion_configuracion';

$route['eliminar_configuracion/(:any)/(:any)'] = 'catalogos/eliminar_configuracion/$1/$2';
$route['validar_eliminar_configuracion']    	 = 'catalogos/validar_eliminar_configuracion';
$route['procesando_cat_configuraciones']    = 'catalogos/procesando_cat_configuraciones';

$route['participantes_unico']						= 'main/listado_participantes_unico';
$route['procesando_participantes_unico']			= 'main/procesando_participantes_unico';

$route['exportar_reportes2']    = 'exportar_reportes/exportar';
/* End of file routes.php */
/* Location: ./application/config/routes.php */
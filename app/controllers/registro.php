<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro extends CI_Controller {

	public function __construct(){ 
		parent::__construct();

		$this->load->model('admin/modelo', 'modelo'); 
		$this->load->model('registros', 'modelo_registro'); 
		$this->load->model('admin/catalogo', 'catalogo');  
		$this->load->library(array('email')); 
	
		$this->tiempo_comienzo      = "00:10";
	}




//new ok
function registrar_facebook($puntos){ //nuevo
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		
		$ticket['total'] = (int) ($puntos);
		if  ($ticket['total']>0) { //si compartio el total>0

			$ticket['ticket']			=	'fac-'.$this->session->userdata('id_participante');
			$ticket['compra']   			= "08/24/17";
			$ticket['cantidad']   			= 0;
			$ticket['monto']				= $ticket['total']; //cantidad
			$ticket['transaccion']			= 0;
			$ticket['clave_producto']		= 0;
			$uno = mt_rand(1, 1);
			$ticket['puntos'] = base64_encode($uno. $uno. $uno);
			$ticket['total'] = $ticket['total'];	
			$ticket 						= $this->security->xss_clean( $ticket );
			$guardar 						= $this->modelo_registro->anadir_tickets( $ticket );        	
		} 
		 redirect('/registro_ticket');  //comparta o no va a ir al registro de ticket
	}	

}

//new ok
 public function proc_modal_facebook(){ //nuevo
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
               $this->load->view( 'registros/modal_face' );
		   }   			
}



 public function compartir_imagen(){


	
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      
               $this->load->view( 'imagen/imagen' );
		   }   			

}


 public function proc_modal_instrucciones(){


	
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      
               $this->load->view( 'tickes/modal_instrucciones' );
		   }   			

}


 public function proc_modal_cero_puntos(){
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		    	//indicar que ya concluyo tarea con su ticket

		    	//actualizar ticket
				$data["num_ticket_participante"] =	$this->session->userdata( 'num_ticket_participante' );
				        $data["id_participante"] = $this->session->userdata( 'id_participante' );
				$data['total'] = 0;

				$data 						= $this->security->xss_clean( $data );
				$guardar 				    = $this->modelo_registro->actualizar_tickets( $data );

				//indicar que ya concluyo tarea con su ticket
		       $this->session->set_userdata('registro_ticket', false );
               $this->load->view( 'tickes/modal_cero_puntos' );
		   }   			
}


/*


function publico($puntos){
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		
		$data["num_ticket_participante"] =	$this->session->userdata( 'num_ticket_participante' );
		        $data["id_participante"] = $this->session->userdata( 'id_participante' );
		$data['total'] = (int) ($puntos) ;

		$data 						= $this->security->xss_clean( $data );
		$guardar 				    = $this->modelo_registro->actualizar_tickets( $data );

		
        
		redirect('/record/'.$data["id_participante"]);
	}	

}	


*/




 // Creación de especialista o Administrador (Nuevo Colaborador)
	function nuevo_registro(){
		if($this->session->userdata('session_participante') === TRUE ){   //si esta logueado inhabilitar session
				  redirect('');
		} else {  //nuevo registro
			  $data['premios']   = $this->catalogo->listado_premios();
			  $data['estados']   = $this->modelo_registro->listado_estados();
			  $this->load->view( 'registros/registro',$data );   
		}    
	}


	function cadena_noacepta( $str ){
		$regex = "/(uefa|pepsi|champio)/i";
		if ( preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'cadena_noacepta',"<b class='requerido'>*</b> La información introducida en <b>%s</b> no está permitida." );
			return FALSE;
		} else {
			return TRUE;
		}
	}

   function validar_registros23333(){

						$usuario['nombre']   			= "osmel"; 
						$usuario['apellidos']   		= "calderon"; 
						$usuario['nick']   				= "minick";

						$usuario['email']   			= 'osmel.calderon@gmail.com';
						$usuario['contrasena']			= 'contrasena';

						$dato['email']   			    = 'osmel.calderon@gmail.com';
						$dato['contrasena']				= 'contrasena';				
						//envio de correo para notificar alta en usuarios del sistema
						$desde = $this->session->userdata('c1');
						$esp_nuevo = $usuario['email'];
						$this->load->view('admin/correos/alta_usuario', $dato );

   }


	function validar_registros(){
		if ($this->session->userdata('session_participante') == TRUE) {
			redirect('');
		} else {

			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'nick', 'NickName', 'trim|required|min_length[3]|max_length[50]|callback_cadena_noacepta|xss_clean');
			$this->form_validation->set_rules( 'email', 'Correo', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('id_estado', 'Ciudad de compra', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'pass_1', 'La contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'celular', 'Celular', 'trim|required|numeric|min_length[10]|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules( 'telefono', 'Teléfono', 'trim|required|numeric|min_length[8]|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules('coleccion_id_aviso', 'Aviso de privacidad', 'callback_accept_terms[coleccion_id_aviso]');	
			$this->form_validation->set_rules('coleccion_id_base', 'Bases legales', 'callback_accept_terms[coleccion_id_base]');	
			$this->form_validation->set_rules( 'fecha_nac', 'Fecha de Nacimiento', 'trim|required|callback_valid_nacimiento[fecha_nac]|xss_clean');
			$this->form_validation->set_rules( 'calle', 'Calle', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'numero', 'El número', 'trim|required|min_length[1]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'colonia', 'Colonia', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'municipio', 'Municipio', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'cp', 'CP', 'trim|required|min_length[2]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'ciudad', 'Ciudad', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			
			$mis_errores=array(
					    "nombre" =>  '',
					    "apellidos" =>  '',
					    "nick" =>  '',
					    "email" =>  '',
					    "id_estado" =>  '',
					    'pass_1'=> '',
					    'pass_2'=>  '',
					    "celular" =>  '',
					    "telefono" =>  '',
					    "coleccion_id_aviso" =>  '',
					    "coleccion_id_base" =>  '',
					    "fecha_nac" =>  '',
					     "general" => '',
				    	"calle" =>  '',
				    	"numero" =>  '',
				    	"colonia" =>  '',
				    	"municipio" =>  '',
				    	"cp" =>  '',
				    	"ciudad" =>  '',

						);
			

			if ($this->form_validation->run() === TRUE){
				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$data['email']			=	$this->input->post('email');
					$data['contrasena']		=	$this->input->post('pass_1');
					$data 				= 	$this->security->xss_clean($data);  
					$login_check = $this->modelo_registro->check_correo_existente($data);

					if ( $login_check != FALSE ){		
						$usuario['nombre']   			= $this->input->post( 'nombre' );
						$usuario['apellidos']   		= $this->input->post( 'apellidos' );
						$usuario['nick']   				= $this->input->post( 'nick' );

						$usuario['email']   			= $this->input->post( 'email' );
						$usuario['calle']   			= $this->input->post( 'calle' );
						$usuario['numero']   			= $this->input->post( 'numero' );
						$usuario['colonia']   			= $this->input->post( 'colonia' );
						$usuario['municipio']   		= $this->input->post( 'municipio' );
						$usuario['cp']   			= $this->input->post( 'cp' );
						$usuario['ciudad']   			= $this->input->post( 'ciudad' );

						$usuario['contrasena']				= $this->input->post( 'pass_1' );
						
						$usuario['fecha_nac']   		= $this->input->post( 'fecha_nac' );
						$usuario['id_estado']   		= $this->input->post( 'id_estado' );

						$usuario['celular']   		= $this->input->post( 'celular' );
						$usuario['telefono']   		= $this->input->post( 'telefono' );
						
						
						$usuario['id_perfil']   		= 3; //significa participante

						$usuario['id_premio']   		= $this->input->post( 'id_premio' );

						

						$usuario 						= $this->security->xss_clean( $usuario );
						$guardar 						= $this->modelo_registro->anadir_registro( $usuario );

						
						if ( $guardar !== FALSE ){  

									
									$dato['email']   			    = $usuario['email'];   			
									$dato['contrasena']				= $usuario['contrasena'];				

									
									//envio de correo para notificar alta en usuarios del sistema
									$desde = $this->session->userdata('c1');
									$esp_nuevo = $usuario['email'];
									$this->email->from('admin@promoscasaley.com.mx', 'Promos Casa Ley');
									$this->email->to( $esp_nuevo );
									$this->email->subject('Cerremos con Broche de Oro'); //.$this->session->userdata('c2')
									$this->email->message( $this->load->view('admin/correos/alta_usuario', $dato, TRUE ) );

										 
									if ($this->email->send()) {	
									$dato['email']   			    = $usuario['email'];   			
										$dato['contrasena']				= $usuario['contrasena'];				
										$dato['nombre']   			    = $usuario['nombre'];   			
										$dato['apellidos']				= $usuario['apellidos'];
										$dato['celular']   			    = $usuario['celular'];   			
										$dato['telefono']				= $usuario['telefono'];
										$dato['nick']   			    = $usuario['nick'];  

											
									$this->load->library('email');
									$this->email->from('admin@promoscasaley.com.mx', 'Promos Casa Ley');
									$this->email->to('guerreroadrian1111@gmail.com');	

									$this->email->subject('Nuevo usuario en Cerremos con Broche de Oro');
									$this->email->message( $this->load->view('admin/correos/alta_usuarios', $dato, TRUE ) );
									$this->email->send();

									
									$login_checkeo = $this->modelo_registro->check_login($usuario);
									$this->modelo_registro->anadir_historico_acceso($login_checkeo[0]);  //agrega al historico de acceso de participantes

									$this->session->set_userdata('session_participante', TRUE);
									$this->session->set_userdata('email_participante', $usuario['email']);

									
									if (is_array($login_checkeo))
										foreach ($login_checkeo as $element) {
											$this->session->set_userdata('premiado_participante', $element->premiado);
											$this->session->set_userdata('id_premio_participante', $element->id_premio);
											
											$this->session->set_userdata('id_participante', $element->id);
											$this->session->set_userdata('nombre_participante', $element->nombre.' '.$element->apellidos);
											$this->session->set_userdata('nick_participante', $element->nick);
										}
									

										$mis_errores = true;
								
									} else {
										 $mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo participante no pudo ser agregado</span>';
									}
									

						} else {
							
							 	 $mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo participante no pudo ser agregado</span>';
							 
						}
					} else {
						
							 	 $mis_errores["general"] = '<span class="error">El <b>Correo electrónico</b> ya se encuentra registrado.</span>';
							 
						
					}
				} else {
					
							 	$mis_errores["general"] = '<span class="error">No coinciden la Contraseña </b> y su <b>Confirmación</b> </span>';
							 
						
					
				}
			} else {			
				
				//tratamiento de errores
				$error = validation_errors();
				
				$errores = explode("<b class='requerido'>*</b>", $error);
				$campos = array(
				    "nombre" => 'Nombre',
				    "apellidos" => 'Apellido(s)',
				    "nick" => 'NickName',
				    "email" => 'Correo',
				    "calle" => 'Calle',
				    "numero" => 'El número',
				    "colonia" => 'Colonia',
				    "municipio" => 'Municipio',
				    "cp" => 'CP',
				    "ciudad" => 'Ciudad',
				    "id_estado" => 'Ciudad de compra',
				    'pass_1'=>'La Contraseña',
				    'pass_2'=>'Confirmación',
				    "celular" => 'Celular',
				    "telefono" => 'Teléfono',
				    "coleccion_id_aviso" => 'Aviso de privacidad',
				    "coleccion_id_base" => 'Bases legales',
				    "fecha_nac" => 'Fecha de Nacimiento',
				);

				    foreach ($errores as $elemento) {
				    	//echo $elemento.'<br/>';
						foreach ($campos as $clave => $valor) {
								
						        if (stripos($elemento, $valor) !== false) {
						        	if  ($valor=="requerido") {
						         		$mis_errores[$clave] = $elemento; //condiciones
						        	} else {
						        		$mis_errores[$clave] = '*';
						        	}						

						        	$mis_errores[$clave] = substr($elemento, 0, -5);   //condiciones 	
						        }
						}    	
				    }
				    
			}

			echo json_encode($mis_errores);


		}
	}






	public function configuraciones(){
			    $configuraciones = $this->modelo->listado_configuraciones();
				
				if ( $configuraciones != FALSE ){

					if (is_array($configuraciones))
						foreach ($configuraciones as $configuracion) {
							$this->session->set_userdata('c'.$configuracion->id, $configuracion->valor); 
							$this->session->set_userdata('a'.$configuracion->id, $configuracion->activo);
						}
					
				} 

	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function configuraciones_imagenes(){
			    $configuraciones = $this->modelo_registro->listado_imagenes();
				
				if ( $configuraciones != FALSE ){

					if (is_array($configuraciones)){
						$this->session->set_userdata('cantimagen', count($configuraciones) ) ;	
						foreach ($configuraciones as $configuracion) {
							$this->session->set_userdata('i'.$configuracion->id, $configuracion->valor);
							$this->session->set_userdata('ip'.$configuracion->id, $configuracion->puntos);
						}

					}
						

					
				} 

	}






  public function login_participante(){
		$this->load->view( 'registros/login' );
	}



	function validar_login_participanteporemail(){
		
		
				$mis_errores=array(
				    "email" => '',
				    "contrasena" => '',
				    'general'=> '',
				);

		$this->form_validation->set_rules( 'email', 'Correo', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules( 'contrasena', 'Contraseña', 'required|trim|min_length[8]|xss_clean');




		if ( $this->form_validation->run() == TRUE ){
				$data['email']		=	$this->input->post('email');
				$data['contrasena']		=	$this->input->post('contrasena');
				$data 				= 	$this->security->xss_clean($data);  

				$login_check = $this->modelo_registro->check_login($data);
				
				if ( $login_check != FALSE ){

					
					$this->modelo_registro->anadir_historico_acceso($login_check[0]);  //agrega al historico de acceso de participantes

					$this->session->set_userdata('session_participante', TRUE);
					$this->session->set_userdata('email_participante', $data['email']);

					
					

					
					if (is_array($login_check))
						foreach ($login_check as $login_element) {
							$this->session->set_userdata('premiado_participante', $login_element->premiado);
							$this->session->set_userdata('id_premio_participante', $login_element->id_premio);
							$this->session->set_userdata('id_participante', $login_element->id);
							$this->session->set_userdata('nombre_participante', $login_element->nombre.' '.$login_element->apellidos);
							$this->session->set_userdata('nick_participante', $login_element->nick);
						}
					$mis_errores = true;	
				} else {
					$mis_errores["general"] = '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
		} else {		

			//echo validation_errors('<span class="error">','</span>');


						
				//tratamiento de errores
				$error = validation_errors();
				$errores = explode("<b class='requerido'>*</b>", $error);
				$campos = array(
				    "email" => 'Correo',
				    "contrasena" => 'Contraseña',
				);
				    foreach ($errores as $elemento) {

						foreach ($campos as $clave => $valor) {
							
						        if (stripos($elemento, $valor) !== false) {
						        	if  ($valor=="Requerido") {
						         		$mis_errores[$clave] = $elemento; //condiciones
						        	} else {
						        		$mis_errores[$clave] = '*';
						        	}						

						        	$mis_errores[$clave] = substr($elemento, 0, -5);   //condiciones 	
						        }
						}    	
				    }

		}	

		echo json_encode($mis_errores);



	}	


	function validar_login_participante(){

		$mis_errores=array(
		    "nick" => '',
		    "contrasena" => '',
		    'general'=> '',
		);

		//$this->form_validation->set_rules( 'email', 'Correo', 'trim|required|valid_email|xss_clean');
		//$this->form_validation->set_rules( 'nick', 'Nick', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules( 'nick', 'Usuario', 'trim|required|min_length[3]|max_length[50]|callback_cadena_noacepta|xss_clean');
		$this->form_validation->set_rules( 'contrasena', 'Contraseña', 'required|trim|min_length[8]|xss_clean');

		if ( $this->form_validation->run() == TRUE ){
				$data['nick']		=	$this->input->post('nick');
				$data['contrasena']		=	$this->input->post('contrasena');
				$data 				= 	$this->security->xss_clean($data);  

				$login_check = $this->modelo_registro->check_login($data);
				
				if ( $login_check != FALSE ){

					$this->modelo_registro->anadir_historico_acceso($login_check[0]);  //agrega al historico de acceso de participantes
					$this->session->set_userdata('session_participante', TRUE);
					
					
					if (is_array($login_check))
						foreach ($login_check as $login_element) {
							$this->session->set_userdata('premiado_participante', $login_element->premiado);
							$this->session->set_userdata('id_premio_participante', $login_element->id_premio);
							$this->session->set_userdata('id_participante', $login_element->id);
							$this->session->set_userdata('nombre_participante', $login_element->nombre.' '.$login_element->apellidos);
							$this->session->set_userdata('nick_participante', $login_element->nick);
						}
					$mis_errores = true;	
				} else {
					$mis_errores["general"] = '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
		} else {		
					
				//tratamiento de errores
				$error = validation_errors();
				$errores = explode("<b class='requerido'>*</b>", $error);
				$campos = array(
				    "nick" => 'Usuario',
				    "contrasena" => 'Contraseña',
				);
				    foreach ($errores as $elemento) {

						foreach ($campos as $clave => $valor) {
							
						        if (stripos($elemento, $valor) !== false) {
						        	if  ($valor=="Requerido") {
						         		$mis_errores[$clave] = $elemento; //condiciones
						        	} else {
						        		$mis_errores[$clave] = '*';
						        	}						

						        	$mis_errores[$clave] = substr($elemento, 0, -5);   //condiciones 	
						        }
						}    	
				    }

		}	

		echo json_encode($mis_errores);

	}	



   function registro_ticket(){

		if ( $this->session->userdata( 'session_participante' ) !== TRUE ){
			self::configuraciones();
			$this->login_participante();
		} else {
			self::configuraciones_imagenes();  //las imagenes
			

 			if ($this->session->userdata('registro_ticket') !=true ){ 
				$this->dashboard_participante();
			} else {
				$this->registro_juego();
			}	
		  


		}

	}


	function dashboard_participante(){  //este es el del juego
		if($this->session->userdata('session_participante') === TRUE ){
		  $data['estados']   = $this->modelo_registro->listado_litraje();
		  $this->load->view( 'tickes/dashboard_ticket',$data );
		}
		else { 
		  redirect('');
		}	
	}	



	function valid_fecha( $str, $campo ){
		if ($this->input->post($campo)){
			
			
			$fecha_inicial =  strtotime( date("Y-m-d", strtotime("03/15/2017") ) );
		    $fecha_compra  =  strtotime( date("Y-m-d", strtotime($this->input->post($campo)) ) );
			          $hoy =   strtotime(date("Y-m-d") );
			if ( ($fecha_compra>=$fecha_inicial) && ($fecha_compra<=$hoy) ) {
				return true;
			} else {
				$this->form_validation->set_message( 'valid_fecha',"<b class='requerido'>*</b> Su <b>%s</b> es incorrecta." );	
				return false;
			}

		} else {
			$this->form_validation->set_message( 'valid_fecha',"<b class='requerido'>*</b> Es obligatorio <b>%s</b>." );
			return false;
		}	

	}


function validar_registrar_ticket(){
		$mis_errores=array(
				    'general'=> '',
		);
	$this->form_validation->set_rules( 'ticket', 'Núm de Ticket', 'trim|required|min_length[29]|max_length[29]|xss_clean');	//numeric|
	if ($this->form_validation->run() === TRUE){						
		$ticket['ticket']			=	$this->input->post('ticket');			
		$this->session->set_userdata('num_ticket_participante', $ticket['ticket']);
    	$mis_errores =  true;
	} else {
		$mis_errores["general"] =  '<span class="error">Su ticket no es <b>válido</b> </span>';
	}

	echo json_encode($mis_errores);



}	



function validar_premios(){
   echo true;
}	

function validar_tickets(){
		

		if ($this->session->userdata('session_participante') != TRUE) {
			redirect('');
		} else {


		    
					$mis_errores=array(
				    "monto" => '',
				    "ticket" => '',
				    "transaccion" => '',
				    //"clave_producto" => '',
				    "compra" => '',
				    //'id_litraje'=>'',
				    //'cantidad'=> '',
				    'general'=> '',

						);


			
			
			$this->form_validation->set_rules( 'monto', 'Monto de la compra', 'trim|required|numeric|min_length[1]|max_length[20]|xss_clean|greater_than[3]|less_than[3000]');										
			$this->form_validation->set_rules( 'ticket', 'Núm de Ticket', 'trim|required|min_length[29]|min_length[29]|xss_clean');	//numeric|
			$this->form_validation->set_rules( 'transaccion', 'Puntos obtenidos en la compra', 'trim|required|numeric|min_length[1]|max_length[15]|greater_than[3]|xss_clean');								
			//$this->form_validation->set_rules( 'clave_producto', 'Clave de producto', 'trim|required|numeric|min_length[13]|max_length[13]|xss_clean');										
			$this->form_validation->set_rules( 'compra', 'Fecha de Compra', 'trim|required|callback_valid_fecha[compra]|xss_clean');
			//$this->form_validation->set_rules('id_litraje', 'Litraje', 'required|callback_valid_option|xss_clean');
			
			$this->form_validation->set_rules( 'cantidad', 'Cantidad', 'trim|required|numeric|xss_clean');										
		
			$ticket['monto']				    = $this->input->post('monto');
			$ticket['transaccion']				    = $this->input->post('transaccion');

			if 	($ticket['transaccion']>$ticket['monto']) {
					$mis_errores["transaccion"] ="Puntos deben ser menores que el monto de la compra";
			}
	
			if ( ($this->form_validation->run() === TRUE) && ($ticket['transaccion']<=$ticket['monto']) ) {

				$validacion_tickets =true;
				if ($validacion_tickets){ //validacion de la tarjeta
					$ticket['ticket']			=	$this->input->post('ticket');
					
					$ticket 				= 	$this->security->xss_clean($ticket);  
					$ticket_check = $this->modelo_registro->check_tickets_existente($ticket);

					if ( $ticket_check != FALSE ){		
						$ticket['compra']   			= $this->input->post( 'compra' );
						//$ticket['id_litraje']   		= $this->input->post( 'id_litraje' );
						$ticket['cantidad']   			= $this->input->post( 'cantidad' );
						$ticket['clave_producto']				    = $this->input->post('clave_producto');
						//cuando entra sacar el aleatorio
						$uno =1; //mt_rand(1, $this->session->userdata('cantimagen'));
						$dos =1; //mt_rand(1, $this->session->userdata('cantimagen'));
						$tres =1; // mt_rand(1, $this->session->userdata('cantimagen'));

						$uno =mt_rand(1, $this->session->userdata('cantimagen'));
						$dos =mt_rand(1, $this->session->userdata('cantimagen'));
						$tres =mt_rand(1, $this->session->userdata('cantimagen'));
						

						$ticket['puntos'] = base64_encode($uno. $dos. $tres);

						$this->session->set_userdata('cripto', $ticket['puntos'] );


						if (($uno==$dos) and ($dos==$tres)) { //si las 3 son iguales

							$ticket['total'] =  ((  $this->session->userdata("ip".$uno) ) !=0) ? (  $this->session->userdata("ip".$uno) ) : 25 ;	
						} else {
							$ticket['total'] = 25;	
						}
						
						if ($ticket['transaccion']<100) {
							$ticket['puntos'] = base64_encode('000');							
							$ticket['total'] = 0;		
						}

						

						$ticket 						= $this->security->xss_clean( $ticket );
						$guardar 						= $this->modelo_registro->anadir_tickets( $ticket );



						
						if ( $guardar !== FALSE ){  

									
									//$dato['email']   			    = $ticket['email'];   			
									//$dato['contrasena']				= $ticket['contrasena'];				

									/* 
									//envio de correo para notificar alta en usuarios del sistema
									$desde = $this->session->userdata('c1');
									$esp_nuevo = $ticket['email'];
									$this->email->from($desde, $this->session->userdata('c2'));
									$this->email->to( $esp_nuevo );
									$this->email->subject('Has sido dado de alta en '.$this->session->userdata('c2'));
									$this->email->message( $this->load->view('admin/correos/alta_usuario', $dato, TRUE ) );

										 
									if ($this->email->send()) {	
										echo TRUE;
									} else {
										echo '<span class="error"><b>E01</b> - El nuevo usuario no pudo ser agregado</span>';
									}
									*/

									//$this->session->set_userdata('session_participante', TRUE);
									//$this->session->set_userdata('nombre_participante', $ticket['nombre'].' '.$ticket['apellidos']);
									//$this->session->set_userdata('email_participante', $ticket['email']);
									//$this->session->set_userdata('id_participante', $login_element->id);


									
									//indicar numero de ticket registrado															
									
									$this->session->set_userdata('num_ticket_participante', $ticket['ticket']);
									$this->session->set_userdata('num_transacion', $ticket['transaccion']);

									//indicar que ya registro su ticket						
									$this->session->set_userdata('registro_ticket', true );

									//cuando entra 3 posibilidades de barajear
									$this->session->set_userdata('numImage', 3 );
									
									
									//tiempo comienzo
									$this->session->set_userdata('tiempo', $this->tiempo_comienzo);


									$mis_errores = true;	

						} else {
							$mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo participante no pudo ser agregado</span>';
						}
					} else {
						$mis_errores["general"] = '<span class="error">El <b>tickets</b> ya se encuentra registrado.</span>';
					}
				} else {
					$mis_errores["general"] = '<span class="error">Su tickets no es válido</b> y su <b>Confirmación</b> </span>';
				}
			} else {			
				//echo validation_errors('<span class="error">','</span>');

	//tratamiento de errores
				$error = validation_errors();
				$errores = explode("<b class='requerido'>*</b>", $error);
				$campos = array(
				    "monto" => 'Monto de la compra',
				    "ticket" => 'Núm de Ticket',
				    "transaccion" => 'Puntos obtenidos en la compra',
				    "clave_producto" => 'Clave de producto',
				    "compra" => 'Fecha de Compra',
				    'id_litraje'=>'Litraje',
				    'cantidad'=>'Cantidad',
				);



				    foreach ($errores as $elemento) {

						foreach ($campos as $clave => $valor) {
							
						        if (stripos($elemento, $valor) !== false) {
						        	if  ($valor=="Requerido") {
						         		$mis_errores[$clave] = $elemento; //condiciones
						        	} else {
						        		$mis_errores[$clave] = '*';
						        	}						

						        	$mis_errores[$clave] = substr($elemento, 0, -5);   //condiciones 	
						        }
						}    	
				    }

				    if ($mis_errores["ticket"] !='') {
				    	$mis_errores["ticket"] =  '<span class="error">Su ticket no es <b>válido</b> </span>';	
				    }
				    
				    

			}
			echo json_encode($mis_errores);
		}
	}









	function registro_juego(){  //este es el del juego
		
		$data["cripto"] = $this->session->userdata('cripto');

		if($this->session->userdata('session_participante') === TRUE ){
		  $data['nodefinido_todavia']        = '';
		  $this->load->view( 'tickes/dashboard',$data );
		}
		else { 
		  redirect('');
		}	

	}
	




		public function num_conteo(){
		   if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		   		$data['started']		=	$this->input->post('started');
		   		if  ( isset($_POST["started"]) ) {
		   			$this->session->set_userdata('numImage', $this->input->post('started') );
		   		} else {

		   			//no se establece 	numImage
		   		}

		   		$data['tiempo'] = 	$this->session->userdata('tiempo'); 
		   		$data['tiempo_comienzo'] = $this->tiempo_comienzo; 
			   	$data['num'] = $this->session->userdata('numImage'); 

			   	$data['registro_ticket'] = $this->session->userdata('registro_ticket'); 
			   	$this->session->set_userdata('tiempo', "0:00");
			   	echo  json_encode($data);

		   }	

			
		}	
  



 public function proc_modal_ticket($tiempo, $redes){


	
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      $basede = base_url();
		       
		       //indicar que ya concluyo tarea con su ticket
		       $this->session->set_userdata('registro_ticket', false );

		       $data['tiempo'] 			= base64_decode($tiempo);	//tiempo restante
		       $data['redes'] 			= base64_decode($redes);   //redes
 			   $data['ptos'] 			= base64_decode($this->session->userdata('cripto'));	 //ptos

 			   $objeto = $this->modelo->listado_imagenes();

                        $c1 =  (int) ($data['ptos'] / 100);
                        $c2 =   (int) (($data['ptos'] % 100) / 10 );
                        $c3 =   (int) (($data['ptos'] % 10)  );
 
                     $data["total_puntos"] = 25;
                    foreach ($objeto as $llave => $valor) {  
                    	if   (($c1==$c2) and ($c1==$c3)) { //si los 3 son iguales
                            if ($valor->id == $c1) {
                                 //$data["total_puntos"] = ($valor->puntos!=0) ? $valor->puntos : 25;
                            	$data["total_puntos"] = ($valor->puntos!=0) ? $this->session->userdata('num_transacion') : 25;
                            	
                            }

                        }



                        if ($c1 == $valor->id) {
                            $data["imagen1"] ='<img src="'.$basede.'/'.$valor->valor.'" border="0" width="25" height="25">';
                        }
                        if ($c2 == $valor->id) {
                            $data["imagen2"] ='<img src="'.$basede.'/'.$valor->valor.'" border="0" width="25" height="25">';
                        }
                        if ($c3 == $valor->id) {
                            $data["imagen3"] ='<img src="'.$basede.'/'.$valor->valor.'" border="0" width="25" height="25">';
                        }
                    }








               $this->load->view( 'tickes/modal',$data );
		   }   			

}



function record($id_participante){
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		$data["id_participante"] =$id_participante;
		$data["record"] 		=   $this->modelo_registro->record_personal($data);
		
		$this->session->set_userdata('num_ticket_participante', '');

		$this->load->view( 'tickes/record',$data );
	}	

}	


function publico($puntos){
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		
		$data["num_ticket_participante"] =	$this->session->userdata( 'num_ticket_participante' );
		        $data["id_participante"] = $this->session->userdata( 'id_participante' );

		$data['total'] = (int) ($puntos) ;

		$data 						= $this->security->xss_clean( $data );
		$guardar 				    = $this->modelo_registro->actualizar_tickets( $data );

		
        
		redirect('/record/'.$data["id_participante"]);
	}	

}	



function tabla_general(){
	
		$data["records"] 		=  $this->modelo_registro->record_general();
		$this->load->view( 'dashboard/tabla_general',$data );

}	




	//recuperar constraseña OK
	function recuperar_participante(){ //NO FUNCIONA ERA PARA RECUPERAR CONTRASEÑA
		$this->load->view('registros/recuperar_password');
	}
	
	
	function validar_recuperar_participante(){  //NO FUNCIONA ERA PARA RECUPERAR CONTRASEÑA
		$mis_errores=array(
				    'general'=> '',
		);

		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');

		if ( $this->form_validation->run() == FALSE ){
			$mis_errores["general"] =  validation_errors('<span class="error">','</span>');

		} else {
				$data['email']		=	$this->input->post('email');
				$correo_enviar      =   $data['email'];
				$data 				= 	$this->security->xss_clean($data);  
				$usuario_check 		=   $this->modelo_registro->recuperar_contrasena($data);

				if ( $usuario_check != FALSE ){
						$data= $usuario_check[0]; 	
						$desde = $this->session->userdata('c1');
						$this->email->from($desde,$this->session->userdata('c2'));
						$this->email->to($correo_enviar);
						$this->email->subject('Recuperación de contraseña de '.$this->session->userdata('c2'));
						$this->email->message($this->load->view('registros/correos/envio_contrasena', $data, true));
						
						if ($this->email->send()) {
						
							$mis_errores = true;					
						} else 
							//$mis_errores = false;
							$mis_errores["general"] = '<span class="error">Su correo no ha podido salir, error conexión.</span>';
				} else {
					//echo '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
					$mis_errores["general"] = '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
		}

		echo json_encode($mis_errores);
	}		









	public function desconectar_participante(){
		$this->session->sess_destroy();
		redirect('');
	}	



/////////////////validaciones/////////////////////////////////////////	




	function accept_terms($str,$campo) {
        if ($this->input->post($campo)){
			return TRUE;
		} else {
			$this->form_validation->set_message( 'accept_terms',"<b class='requerido'>*</b> Favor lee y acepta tu <b>%s</b>." );
			return FALSE;
		}
	}

	function valid_phone( $str ){
		if ( $str ) {
			if ( ! preg_match( '/\([0-9]\)| |[0-9]/', $str ) ){
				$this->form_validation->set_message( 'valid_phone', "<b class='requerido'>*</b> El <b>%s</b> no tiene un formato válido." );
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	function valid_nacimiento( $str, $campo ){
		if ($this->input->post($campo)){
			$hoy =  new DateTime (date("Y-m-d", strtotime(date("d-m-Y"))) );
			$fecha_nac = new DateTime ( date("Y-m-d", strtotime($this->input->post($campo)) ) );
			$fecha = date_diff($hoy, $fecha_nac);
			if ( ($fecha->y>=18) && ($fecha->y<=150) ) {
				return true;
			} else {
				$this->form_validation->set_message( 'valid_nacimiento',"<b class='requerido'>*</b> Su <b>%s</b> debe ser mayor a 18 años." );	
				return false;
			}

		} else {
			$this->form_validation->set_message( 'valid_nacimiento',"<b class='requerido'>*</b> Es obligatorio <b>%s</b>." );
			return false;
		}	

	}



	public function valid_cero($str) {
		return (  preg_match("/^(0)$/ix", $str)) ? FALSE : TRUE;
	}

	function nombre_valido( $str ){
		 $regex = "/^([A-Za-z ñáéíóúÑÁÉÍÓÚ]{2,60})$/i";
		//if ( ! preg_match( '/^[A-Za-zÁÉÍÓÚáéíóúÑñ \s]/', $str ) ){
		if ( ! preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'nombre_valido',"<b class='requerido'>*</b> La información introducida en <b>%s</b> no es válida." );
			return FALSE;
		} else {
			return TRUE;
		}
	}



	function valid_option( $str ){
		if ($str == 0) {
			$this->form_validation->set_message('valid_option', "<b class='requerido'>*</b> Es necesario que selecciones una <b>%s</b>.");
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_date( $str ){

		$arr = explode('-', $str);
		if ( count($arr) == 3 ){
			$d = $arr[0];
			$m = $arr[1];
			$y = $arr[2];
			if ( is_numeric( $m ) && is_numeric( $d ) && is_numeric( $y ) ){
				return checkdate($m, $d, $y);
			} else {
				$this->form_validation->set_message('valid_date', "<b class='requerido'>*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.");
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('valid_date', "<b class='requerido'>*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD/MM/YYYY.");
			return FALSE;
		}
	}

	public function valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

	////Agregado por implementacion de registro insitu para evento/////
	public function opcion_valida( $str ){
		if ( $str == '0' ){
			$this->form_validation->set_message('opcion_valida',"<b class='requerido'>*</b>  Selección <b>%s</b>.");
			return FALSE;
		} else {
			return TRUE;
		}
	}


}

/* End of file main.php */
/* Location: ./app/controllers/main.php */
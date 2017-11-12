<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){ 
		parent::__construct();

		$this->load->model('admin/modelo', 'modelo'); 
		$this->load->library(array('email')); 
	}


	public function index(){

		
		if ( $this->session->userdata( 'session' ) !== TRUE ){
			self::configuraciones();
			$this->login();
		} else {
			$this->dashboard_usuario();
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


	public function login(){
		$this->load->view( 'admin/login' );
	}


	function validar_login(){
		
		
		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules( 'contrasena', 'Contraseña', 'required|trim|min_length[8]|xss_clean');


		if ( $this->form_validation->run() == FALSE ){
				echo validation_errors('<span class="error">','</span>');
			} else {
				$data['email']		=	$this->input->post('email');
				$data['contrasena']		=	$this->input->post('contrasena');
				$data 				= 	$this->security->xss_clean($data);  

				$login_check = $this->modelo->check_login($data);
				
				if ( $login_check != FALSE ){

					$usuario_historico = $this->modelo->anadir_historico_acceso($login_check[0]);

					$this->session->set_userdata('session', TRUE);
					$this->session->set_userdata('email', $data['email']);
					
					if (is_array($login_check))
						foreach ($login_check as $login_element) {
							$this->session->set_userdata('id', $login_element->id);
							$this->session->set_userdata('id_perfil', $login_element->id_perfil);
							$this->session->set_userdata('especial', $login_element->especial);
							$this->session->set_userdata('perfil', $login_element->perfil);
							$this->session->set_userdata('operacion', $login_element->operacion);
							
							
							$this->session->set_userdata('nombre_completo', $login_element->nombre.' '.$login_element->apellidos);
						}
					echo TRUE;
				} else {
					echo '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
			}
	}	



	

	//lista de todos los usuarios 

  
  public function listado_usuarios(){
  
   $id_session = $this->session->userdata('id');
   //print_r($id_session);
   //die;

   if ( $this->session->userdata('session') !== TRUE ) {
        redirect('login');
    } else {
        $id_perfil=$this->session->userdata('id_perfil');


        $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
        if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
              $coleccion_id_operaciones = array();
         }   

      //$html = $this->load->view( 'catalogos/colores',$data ,true);   
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'admin/usuarios');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'admin/usuarios');
              }  else  {
                redirect('');
              } 
          break;


        default:  
          redirect('');
          break;
      }

    }    
    
  }


  public function procesando_usuarios(){

    $data=$_POST;
    $busqueda = $this->modelo->buscador_usuarios($data);
    echo $busqueda;
  } 


   // Creación de especialista o Administrador (Nuevo Colaborador)
	function nuevo_usuario(){
	if($this->session->userdata('session') === TRUE ){
		  $id_perfil=$this->session->userdata('id_perfil');
		  
		  $data['perfiles']   = $this->modelo->coger_catalogo_perfiles();
		  

		  switch ($id_perfil) {    
			case 1:
				  $this->load->view( 'admin/usuarios/nuevo_usuario', $data );   
					
			  break;
			case 2:
			case 3:
					$this->load->view( 'admin/usuarios/nuevo_usuario', $data );   
			  break;


			default:  
			  redirect('');
			  break;
		  }
		}
		else{ 
		  redirect('index');
		}    

	}

	function validar_nuevo_usuario(){
		if ($this->session->userdata('session') !== TRUE) {
			redirect('');
		} else {

			

			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules( 'telefono', 'Teléfono', 'trim|numeric|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules('id_perfil', 'Rol de usuario', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'pass_1', 'Contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');

			

			if ($this->form_validation->run() === TRUE){
				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$data['email']		=	$this->input->post('email');
					$data['contrasena']		=	$this->input->post('pass_1');
					$data 				= 	$this->security->xss_clean($data);  
					$login_check = $this->modelo->check_correo_existente($data);

					if ( $login_check != FALSE ){		
						$usuario['nombre']   			= $this->input->post( 'nombre' );
						$usuario['apellidos']   		= $this->input->post( 'apellidos' );
						$usuario['email']   			= $this->input->post( 'email' );
						$usuario['contrasena']				= $this->input->post( 'pass_1' );
						$usuario['telefono']   		= $this->input->post( 'telefono' );
						$usuario['id_perfil']   		= $this->input->post( 'id_perfil' );
						

						$usuario 						= $this->security->xss_clean( $usuario );
						$guardar 						= $this->modelo->anadir_usuario( $usuario );

						
						if ( $guardar !== FALSE ){  

									
									$dato['email']   			    = $usuario['email'];   			
									$dato['contrasena']				= $usuario['contrasena'];				

									/* 
									//envio de correo para notificar alta en usuarios del sistema
									$desde = $this->session->userdata('c1');
									$esp_nuevo = $usuario['email'];
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



									echo true;	

						} else {
							echo '<span class="error"><b>E01</b> - El nuevo usuario no pudo ser agregado</span>';
						}
					} else {
						echo '<span class="error">El <b>Correo electrónico</b> ya se encuentra asignado a una cuenta.</span>';
					}
				} else {
					echo '<span class="error">No coinciden la Contraseña </b> y su <b>Confirmación</b> </span>';
				}
			} else {			
				echo validation_errors('<span class="error">','</span>');
			}
		}
	}



	//edicion del especialista o el perfil del especialista o administrador activo
	function actualizar_perfil( $uid = '' ){

	$id=$this->session->userdata('id');

		if ($uid=='') {
			$uid= $id;
			$data['retorno'] = 'admin';
		} else {
			$uid = base64_decode($uid);
		}
  


		$id_perfil=$this->session->userdata('id_perfil');
		
	//Administrador con permiso a todo ($id_perfil==1)
	//usuario solo viendo su PERFIL  OR (($id_perfil!=1) and ($id==$uid) )
		if	( ($id_perfil==1) OR (($id_perfil!=1) and ($id==$uid) ) ) {
			$data['perfiles']		= $this->modelo->coger_catalogo_perfiles();
			$data['usuario'] = $this->modelo->coger_catalogo_usuario( $uid );

			$data['id']  = $uid;
			if ( $data['usuario'] !== FALSE ){
					$this->load->view('admin/usuarios/editar_usuario',$data);
			} else {
						redirect('');
			}
		} else
		{
			 redirect('');
		}	
	}
	
	function validacion_edicion_usuario(){
		
		if ( $this->session->userdata('session') !== TRUE ) {
			redirect('');
		} else {
			
			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules( 'telefono', 'Teléfono', 'trim|numeric|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules('id_perfil', 'Rol de usuario', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'pass_1', 'Contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');

	  //si el usuario no es un administrador entonces q sea obligatorio asociarlo a operaciones 
	  //Esto YA NO HACE FALTA
	  if ($this->input->post('id_perfil')!=1) {
		
		
	  } 


			if ( $this->form_validation->run() === TRUE ){
				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$uid 				=   $this->input->post( 'id_p' ); 
					$data['id']							= $uid;
					$data['email']		=	$this->input->post('email');
					$data 				= 	$this->security->xss_clean($data);  
					$login_check = $this->modelo->check_usuario_existente($data);
					if ( $login_check === TRUE ){
						$usuario['nombre']   					= $this->input->post( 'nombre' );
						$usuario['apellidos']   				= $this->input->post( 'apellidos' );
						$usuario['email']   					= $this->input->post( 'email' );
						$usuario['contrasena']						= $this->input->post( 'pass_1' );
						$usuario['telefono']   				= $this->input->post( 'telefono' );
						$usuario['id_perfil']   				= $this->input->post( 'id_perfil' );

						

						
						$usuario['id']							= $uid;
						$usuario 								= $this->security->xss_clean( $usuario );
						$guardar 									= $this->modelo->edicion_usuario( $usuario );
						if ( $guardar !== FALSE ){
							echo TRUE;
						} else {
							echo '<span class="error"><b>E02</b> - La información del usuario no puedo ser actualizada no hubo cambios</span>';
						}
					} else {
						echo '<span class="error">El <b>Correo electrónico</b> ya se encuentra asignado a una cuenta.</span>';
					}
				} else {
					echo '<span class="error">La <b>Contraseña</b> y la <b>Confirmación</b> no coinciden, verificalas.</span>';
				}
			} else {			
				echo validation_errors('<span class="error">','</span>');
			}
		}
	}	
	

	function eliminar_usuario($uid = '', $nombrecompleto=''){

	if($this->session->userdata('session') === TRUE ){
		  $id_perfil=$this->session->userdata('id_perfil');

		  if ($uid=='') {
			  $uid= $this->session->userdata('id');
		  } else {
		  		$uid = base64_decode($uid);
		  }   
		  $data['nombrecompleto']   = base64_decode($nombrecompleto);
		  $data['uid']        = $uid;


		  switch ($id_perfil) {    
			case 1:
					  $this->load->view( 'admin/usuarios/eliminar_usuario', $data );                
			  break;
			case 2:
			case 3:					  
					  $this->load->view( 'admin/usuarios/eliminar_usuario', $data );

			  break;


			default:  
			  redirect('');
			  break;
		  }
		}
		else{ 
		  redirect('');
		}
		
	}


	function validar_eliminar_usuario(){
		
		$uid = $this->input->post( 'uid_retorno' ); 

		$eliminado = $this->modelo->borrar_usuario(  $uid );
		if ( $eliminado !== FALSE ){
			echo TRUE;
		} else {
			echo '<span class="error">No se ha podido eliminar al usuario</span>';
		}
	}

	/////////////hasta aqui registro de usuario////////////	

	/////////////presentacion, filtro y paginador////////////	
	function dashboard_usuario(){ 
	if($this->session->userdata('session') === TRUE ){
		  $id_perfil=$this->session->userdata('id_perfil');

		  $data['nodefinido_todavia']        = '';
		  switch ($id_perfil) {    
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
				$this->load->view( 'admin/principal/dashboard_usuario',$data );
			  break;

			default:  
			  redirect('');
			  break;
		  }
		}
		else{ 
		  redirect('');
		}	

	}



	//recuperar constraseña
	function recuperar_contrasena(){
		$this->load->view('admin/recuperar_password');
	}
	
	
	function validar_recuperar_password(){
		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');

		if ( $this->form_validation->run() == FALSE ){
			echo validation_errors('<span class="error">','</span>');
		} else {
				$data['email']		=	$this->input->post('email');
				$correo_enviar      =   $data['email'];
				$data 				= 	$this->security->xss_clean($data);  
				$usuario_check 		=   $this->modelo->recuperar_contrasena($data);

				if ( $usuario_check != FALSE ){
						$data= $usuario_check[0]; 	
						$desde = $this->session->userdata('c1');
						$this->email->from($desde,$this->session->userdata('c2'));
						$this->email->to($correo_enviar);
						$this->email->subject('Recuperación de contraseña de '.$this->session->userdata('c2'));
						$this->email->message($this->load->view('admin/correos/envio_contrasena', $data, true));
						if ($this->email->send()) {
							echo TRUE;						
						} else 
							echo false;	
				} else {
					echo '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
		}
	}		




  public function historico_accesos(){

  
   $id_session = $this->session->userdata('id');
   //print_r($id_session);
   //die;

   if ( $this->session->userdata('session') !== TRUE ) {
        redirect('login');
    } else {
        $id_perfil=$this->session->userdata('id_perfil');


        $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
        if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
              $coleccion_id_operaciones = array();
         }   

      //$html = $this->load->view( 'catalogos/colores',$data ,true);   
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'admin/historico_accesos/historico_accesos');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'admin/historico_accesos/historico_accesos');
              }  else  {
                redirect('');
              } 
          break;


        default:  
          redirect('');
          break;
      }

    }    
    
  }


  public function procesando_historico_accesos(){

    $data=$_POST;
    $busqueda = $this->modelo->historico_acceso($data);
    echo $busqueda;
  } 



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////  

//listado de los participantes

 public function listado_participantes(){
  
   $id_session = $this->session->userdata('id');

   if ( $this->session->userdata('session') !== TRUE ) {
        redirect('login');
    } else {
        $id_perfil=$this->session->userdata('id_perfil');


        $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
        if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
              $coleccion_id_operaciones = array();
         }   

      //$html = $this->load->view( 'catalogos/colores',$data ,true);   
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'admin/participantes/participantes');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'admin/participantes/participantes');
              }  else  {
                redirect('');
              } 
          break;


        default:  
          redirect('');
          break;
      }

    }    
    
  }


  public function procesando_participantes(){

    $data=$_POST;
    $busqueda = $this->modelo->buscador_participantes($data);
    echo $busqueda;
  } 

public function listado_participantes_unico(){
  
   $id_session = $this->session->userdata('id');

   if ( $this->session->userdata('session') !== TRUE ) {
        redirect('login');
    } else {
        $id_perfil=$this->session->userdata('id_perfil');


        $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
        if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
              $coleccion_id_operaciones = array();
         }   

      //$html = $this->load->view( 'catalogos/colores',$data ,true);   
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'admin/participantes/participantes_unicos');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'admin/participantes/participantes_unicos');
              }  else  {
                redirect('');
              } 
          break;


        default:  
          redirect('');
          break;
      }

    }    
    
  }


  public function procesando_participantes_unico(){

    $data=$_POST;
    $busqueda = $this->modelo->buscador_listado_completo($data);
    echo $busqueda;
  }   



public function listado_completo(){
  
   $id_session = $this->session->userdata('id');

   if ( $this->session->userdata('session') !== TRUE ) {
        redirect('login');
    } else {
        $id_perfil=$this->session->userdata('id_perfil');


        $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
        if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
              $coleccion_id_operaciones = array();
         }   

      //$html = $this->load->view( 'catalogos/colores',$data ,true);   
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'admin/listado/participantes_unicos');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'admin/listado/participantes_unicos');
              }  else  {
                redirect('');
              } 
          break;


        default:  
          redirect('');
          break;
      }

    }    
    
  }


  public function procesando_listado_completo(){

    $data=$_POST;
    $busqueda = $this->modelo->buscador_listado_completo($data);
    echo $busqueda;
  }   




//listado de los detalles de los participantes

 public function detalle_participante($id_participantes){
  
   $id_session = $this->session->userdata('id');

   if ( $this->session->userdata('session') !== TRUE ) {
        redirect('login');
    } else {
        $id_perfil=$this->session->userdata('id_perfil');


        $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
        if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
              $coleccion_id_operaciones = array();
         }   

  
         $data["id"] = base64_decode($id_participantes);

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'admin/participantes/detalle_participantes',$data);
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'admin/participantes/detalle_participantes',$data);
              }  else  {
                redirect('');
              } 
          break;


        default:  
          redirect('');
          break;
      }

    }    


    
  }


  public function procesando_detalle_participantes(){

    $data=$_POST;
    $busqueda = $this->modelo->buscador_detalle_participantes($data);
    echo $busqueda;
  } 


//historico participantes

public function historico_participantes(){

  
   $id_session = $this->session->userdata('id');

   if ( $this->session->userdata('session') !== TRUE ) {
        redirect('login');
    } else {
        $id_perfil=$this->session->userdata('id_perfil');


        $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
        if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
              $coleccion_id_operaciones = array();
         }   

      
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'admin/participantes/historico_participantes');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'admin/participantes/historico_participantes');
              }  else  {
                redirect('');
              } 
          break;


        default:  
          redirect('');
          break;
      }

    }    
    
  }


  public function procesando_historico_participantes(){

    $data=$_POST;
    $busqueda = $this->modelo->bitacora_participantes($data);
    echo $busqueda;
  } 



////////////////////////////////////////////////////////////////
	//salida del sistema
	public function logout(){
		$this->session->sess_destroy();
		redirect('admin');
	}	






/////////////////validaciones/////////////////////////////////////////	


	public function valid_cero($str)
	{
		return (  preg_match("/^(0)$/ix", $str)) ? FALSE : TRUE;
	}

	function nombre_valido( $str ){
		 $regex = "/^([A-Za-z ñáéíóúÑÁÉÍÓÚ]{2,60})$/i";
		//if ( ! preg_match( '/^[A-Za-zÁÉÍÓÚáéíóúÑñ \s]/', $str ) ){
		if ( ! preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'nombre_valido','<b class="requerido">*</b> La información introducida en <b>%s</b> no es válida.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_phone( $str ){
		if ( $str ) {
			if ( ! preg_match( '/\([0-9]\)| |[0-9]/', $str ) ){
				$this->form_validation->set_message( 'valid_phone', '<b class="requerido">*</b> El <b>%s</b> no tiene un formato válido.' );
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	function valid_option( $str ){
		if ($str == 0) {
			$this->form_validation->set_message('valid_option', '<b class="requerido">*</b> Es necesario que selecciones una <b>%s</b>.');
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
				$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.');
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD/MM/YYYY.');
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
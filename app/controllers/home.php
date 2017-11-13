<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){ 
		parent::__construct();

		$this->load->model('admin/modelo', 'modelo'); 
		$this->load->model('registros', 'modelo_registro'); 
		$this->load->model('admin/catalogo', 'catalogo');  
		$this->load->library(array('email')); 
	}



///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////juego//////////////////////
   function tarjetas(){
   	$this->load->view( 'juegos/tarjetas');
/*
		if ( ($this->session->userdata( 'session_participante' ) !== TRUE ) ||  ( substr_count($this->session->userdata('tarjeta_participante'),';')>=4) )   { //(no registrado) o (registrado y completado)
			 //redirect('');
			 $this->load->view( 'juegos/tarjetas');
		} else {
			 $this->load->view( 'juegos/tarjetas');
		}
*/
	}


	function respuesta_tarjeta(){ 
		
		$figura =  $this->input->post( 'figura' );
		$valor =  $this->input->post( 'valor' );

		
		//$data['formato'] = $this->session->userdata('tarjeta_participante').$figura.'+'.';';
		$data['formato'] = $this->session->userdata('tarjeta_participante').$figura.'+'.$valor.'-'.';';


		//if guarda bien entonces
		$data 		  		= $this->security->xss_clean( $data );
		$guardar	 		= $this->modelo_registro->actualizar_respuesta_tarjeta( $data );
			//print_r($this->session->userdata('tarjeta_participante')."aaa");
			//print_r($this->session->userdata('num_ticket_participante'));
		
			//print_r($data['formato']);die;
		if ( $guardar !== FALSE ){  
			$this->session->set_userdata('tarjeta_participante', $data['formato']);
		}	

		/*
		if  ( substr_count($this->session->userdata('tarjeta_participante'),';')<4) {
				$data['redireccion']='tarjetas';
		} else if ( strlen($this->session->userdata('juego_participante'))!=3) {
				$data['redireccion']= 'juegos';		
				//$data['redireccion']= 'modal_tarjeta';		que esta redireccionará al juego
		} else {
				$data['redireccion'] = '';	
		}	
		*/
		
		
		echo json_encode($data);        
                            
	}


/*

SELECT
AES_DECRYPT(juego, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS juego,
AES_DECRYPT(tarjeta, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS tarjeta,


   FROM calimax_registro_participantes

*/

	//formato  fig+resp-tiempo;
	function respuesta_juego(){ 
		//$this->load->view( 'dashboard/tarjetas' );
		$figura =  $this->input->post( 'figura' );
		$respuesta =  $this->input->post( 'respuesta' );
		


		$data['formato'] = $this->session->userdata('juego_participante').$figura.'+'.$respuesta.'-'.';';
		
		//print_r($data['formato']);


		//if guarda bien entonces
		$data 		  		= $this->security->xss_clean( $data );
		$guardar	 		= $this->modelo_registro->actualizar_respuesta_juego( $data );
			
		if ( $guardar !== FALSE ){  
			$this->session->set_userdata('juego_participante', $data['formato']);
		}	

		//limpiar nuevamente
		$this->session->set_userdata('tarjeta_participante', '');
		$this->session->set_userdata('juego_participante', '');
		$this->session->set_userdata('num_ticket_participante', '');
		$this->session->set_userdata('registro_ticket', false );

		$data['redireccion'] = 'record/'.$this->session->userdata('id_participante');	
		echo json_encode($data);        
                            
	}


	function record($id_participante){
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		$data["id_participante"] = $id_participante;
		$dato 		=   $this->modelo_registro->record_personal($data);


 		//$objeto = $this->modelo->listado_imagenes();


					/*
				$dato->c1 =  (int) ($dato->juego / 100);
                $dato->c2 =   (int) (($dato->juego % 100) / 10 );
                $dato->c3 =   (int) (($dato->juego % 10)  );
                */
		$this->load->view( 'juegos/record',$dato );
	}	
}	


	////////////////////////////////////

	public function index(){
		$this->dashboard();
	}


	/////////////presentacion, filtro y paginador////////////	
	function dashboard(){ 
		//print_r($this->session->userdata( 'id_participante' ));die;
		self::configuraciones();
		$data['nodefinido_todavia']        = '';
		$this->load->view( 'dashboard/dashboard',$data );

	}


	function mecanica(){ 
		
		$this->load->view( 'dashboard/mecanica' );

	}

	function facebook(){ 
		
		$this->load->view( 'facebook' );

	}


	function aviso(){ 
		
		$this->load->view( 'dashboard/aviso' );

	}	
function legales(){ 
		
		$this->load->view( 'dashboard/legales' );

	}	

	function eleccion_premio(){ 
		if (( $this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata('premiado_participante') == 1)  && ($this->session->userdata('id_premio_participante') == 0) ) {

			$data['premios']   = $this->catalogo->listado_premios();
			

			$this->load->view( 'premios/premios' ,$data);
		}	else {
			redirect('');
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
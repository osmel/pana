<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class modelo extends CI_Model{
		
		private $key_hash;
		private $timezone;

		function __construct(){
			parent::__construct();
			$this->load->database("default");
			$this->key_hash    = $_SERVER['HASH_ENCRYPT'];
			$this->timezone    = 'UM1';

				//usuarios
		      $this->usuarios             = $this->db->dbprefix('usuarios');
          $this->perfiles             = $this->db->dbprefix('perfiles');

          $this->configuraciones      = $this->db->dbprefix('catalogo_configuraciones');
          
          $this->proveedores          = $this->db->dbprefix('catalogo_empresas');
          $this->historico_acceso     = $this->db->dbprefix('historico_acceso');

          $this->catalogo_estados      = $this->db->dbprefix('catalogo_estados');
          $this->participantes      = $this->db->dbprefix('participantes');
          $this->bitacora_participante      = $this->db->dbprefix('bitacora_participante');

          $this->registro_participantes         = $this->db->dbprefix('registro_participantes');
          $this->catalogo_litraje      = $this->db->dbprefix('catalogo_litraje');

          $this->catalogo_imagenes         = $this->db->dbprefix('catalogo_imagenes');
          $this->catalogo_premios      = $this->db->dbprefix('catalogo_premios');



		}



        public function listado_configuraciones(){

            $this->db->select('c.id, c.configuracion, c.valor, c.activo');
            $this->db->from($this->configuraciones.' as c');
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }     




        public function listado_usuarios_correo( $id_perfil ){

            $this->db->select($this->usuarios.'.id, nombre,  apellidos');
            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->from($this->usuarios);
            $this->db->join($this->perfiles, $this->usuarios.'.id_perfil = '.$this->perfiles.'.id_perfil');

           // $this->db->where($this->usuarios.'.especial !=', 2);  //quitar en caso de no super-administrador
            //$this->db->where($this->usuarios.'.id_perfil', $id_perfil+1);
            //$this->db->or_where($this->usuarios.'.id_perfil', 1);  //quitar en caso de no super-administrador
            


          $where = '(
                     (
                        ('.$this->usuarios.'.especial <> 2 ) AND ('.$this->usuarios.'.especial <> 3 ) AND ('.$this->usuarios.'.id_perfil='.($id_perfil+1).')
                     ) OR ('.$this->usuarios.'.id_perfil=1)
            )';   
            


          $this->db->where($where);






            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }     



		//login
		public function check_login($data){
			$this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);			
			$this->db->select("AES_DECRYPT(contrasena,'{$this->key_hash}') AS contrasena", FALSE);			
			$this->db->select($this->usuarios.'.nombre,'.$this->usuarios.'.apellidos');			
			$this->db->select($this->usuarios.'.id,'.$this->perfiles.'.id_perfil,'.$this->perfiles.'.perfil,'.$this->perfiles.'.operacion');
            $this->db->select($this->usuarios.'.especial');         

                
			$this->db->from($this->usuarios);
			$this->db->join($this->perfiles, $this->usuarios.'.id_perfil = '.$this->perfiles.'.id_perfil');
			$this->db->where('contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
			$this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);


			$login = $this->db->get();

			if ($login->num_rows() > 0)
				return $login->result();
			else 
				return FALSE;
			$login->free_result();
		}

        //anadir al historico de acceso
        public function anadir_historico_acceso($data){

            $timestamp = time();
            $ip_address = $this->input->ip_address();
            $user_agent= $this->input->user_agent();

            $this->db->set( 'email', "AES_ENCRYPT('{$data->email}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_perfil', $data->id_perfil);

            $this->db->set( 'id_usuario', $data->id);
            $this->db->set( 'fecha',  gmt_to_local( $timestamp, 'UM1', TRUE) );
            $this->db->set( 'ip_address',  $ip_address, TRUE );
            $this->db->set( 'user_agent',  $user_agent, TRUE );
            

            $this->db->insert($this->historico_acceso );

            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();

        }

       public function total_acceso($limit=-1, $offset=-1){

            $fecha = date_create(date('Y-m-j'));
            date_add($fecha, date_interval_create_from_date_string('-1 month'));
            $data['fecha_inicial'] = date_format($fecha, 'm');
            $data['fecha_final'] = $data['fecha_final'] = (date('m'));


            $this->db->from($this->historico_acceso.' As h');
            $this->db->join($this->usuarios.' As u' , 'u.id = h.id_usuario','LEFT');
            $this->db->join($this->perfiles.' As p', 'u.id_perfil = p.id_perfil','LEFT');

            if  (($data['fecha_inicial']) and ($data['fecha_final'])) {
                $this->db->where( "( CASE WHEN h.fecha = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(h.fecha),'%m') END ) = ", $data['fecha_inicial'] );
                $this->db->or_where( "( CASE WHEN h.fecha = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(h.fecha),'%m') END ) = ", $data['fecha_final'] );
            } 

              

           $unidades = $this->db->get();            
           return $unidades->num_rows();
        }

       


		
		//Recuperar contraseña		
	    public function recuperar_contrasena($data){
			$this->db->select("AES_DECRYPT(u.email,'{$this->key_hash}') AS email", FALSE);						
			$this->db->select('u.nombre,u.apellidos');
			$this->db->select("AES_DECRYPT(u.telefono,'{$this->key_hash}') AS telefono", FALSE);			
			$this->db->select("AES_DECRYPT(u.contrasena,'{$this->key_hash}') AS contrasena", FALSE);
			$this->db->from($this->usuarios.' as u');
			$this->db->where('u.email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
			$login = $this->db->get();
			if ($login->num_rows() > 0)
				return $login->result();
			else 
				return FALSE;
			$login->free_result();		
	    }	

	
	
   
        public function coger_usuarios($limit=-1, $offset=-1, $uid ){

            $especial=$this->session->userdata('especial');

		    $this->db->select($this->usuarios.'.id, nombre,  apellidos');
            

            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );
			$this->db->select($this->perfiles.'.id_perfil,'.$this->perfiles.'.perfil,'.$this->perfiles.'.operacion');
			$this->db->from($this->usuarios);
			$this->db->join($this->perfiles, $this->usuarios.'.id_perfil = '.$this->perfiles.'.id_perfil');
			$this->db->where( $this->usuarios.'.id !=', $uid );
            if ($especial==3) {
                $this->db->where( $this->usuarios.'.especial =3' );
            }


            if ($limit!=-1) {
                $this->db->limit($limit, $offset); 
            } 
             

			$result = $this->db->get();
			
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        

        //eliminar usuarios
        public function borrar_usuario( $uid ){
            $this->db->delete( $this->usuarios, array( 'id' => $uid ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }



        //editar	
        public function coger_catalogo_usuario( $uid ){
            $this->db->select('id, nombre, apellidos, id_perfil');
            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );
            $this->db->select( "AES_DECRYPT( contrasena,'{$this->key_hash}') AS contrasena", FALSE );
            $this->db->where('id', $uid);
            $result = $this->db->get($this->usuarios );
            if ($result->num_rows() > 0)
            	return $result->row();
            else 
            	return FALSE;
            $result->free_result();
        }  


		public function check_correo_existente($data){
			$this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);			
			$this->db->from($this->usuarios);
			$this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
			$login = $this->db->get();
			if ($login->num_rows() > 0)
				return FALSE;
			else
				return TRUE;
			$login->free_result();
		}

		public function anadir_usuario( $data ){
            $timestamp = time();

            $id_session = $this->session->userdata('id');
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->set( 'id_usuario',  $id_session );

            $this->db->set( 'id', "UUID()", FALSE);
			$this->db->set( 'nombre', $data['nombre'] );
            $this->db->set( 'apellidos', $data['apellidos'] );
            $this->db->set( 'email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'telefono', "AES_ENCRYPT('{$data['telefono']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_perfil', $data['id_perfil']);
            

            $this->db->set( 'contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'creacion',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->insert($this->usuarios );

            if ($this->db->affected_rows() > 0){
            		return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }

		public function check_usuario_existente($data){
			
			$this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);			
			$this->db->from($this->usuarios);
			$this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
			$this->db->where('id !=',$data['id']);
			$login = $this->db->get();
			if ($login->num_rows() > 0)
				return FALSE;
			else
				return TRUE;
			$login->free_result();
		}        


        public function edicion_usuario( $data ){

            $timestamp = time();

            $id_session = $this->session->userdata('id');
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->set( 'id_usuario',  $id_session );

			$this->db->set( 'nombre', $data['nombre'] );
            $this->db->set( 'apellidos', $data['apellidos'] );
            $this->db->set( 'email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'telefono', "AES_ENCRYPT('{$data['telefono']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_perfil', $data['id_perfil']);
            
            
            $this->db->set( 'contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE );
            $this->db->where('id', $data['id'] );
            $this->db->update($this->usuarios );
            if ($this->db->affected_rows() > 0) {
				return TRUE;
			}  else
				 return FALSE;
        }		

//----------------**************catalogos-------------------************------------------
        public function coger_catalogo_perfiles(){
            $this->db->select( 'id_perfil, perfil, operacion' );
            $perfiles = $this->db->get($this->perfiles );
            if ($perfiles->num_rows() > 0 )
            	 return $perfiles->result();
            else
            	 return FALSE;
            $perfiles->free_result();
        }	    	

   			    


      public function buscador_usuarios($data){
          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];


          switch ($columa_order) {
                   case '0':
                        $columna = 'u.nombre';
                     break;
                   case '1':
                        $columna = 'p.perfil';
                     break;
                   case '2':
                        $columna = 'email';
                     break;
                     
                   
                   default:
                        $columna = 'u.nombre';
                     break;
                 }                 

                                      

          //$id_session = $this->db->escape($this->session->userdata('id'));
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          

          $this->db->select('u.id, u.nombre, u.apellidos, u.id_perfil');
          $this->db->select( "AES_DECRYPT( u.email,'{$this->key_hash}') AS email", FALSE );
          $this->db->select( "AES_DECRYPT( u.telefono,'{$this->key_hash}') AS telefono", FALSE );
          $this->db->select( "AES_DECRYPT( u.contrasena,'{$this->key_hash}') AS contrasena", FALSE );
          $this->db->select('p.perfil');

          $this->db->from($this->usuarios.' as u');
          $this->db->join($this->perfiles.' as p', 'u.id_perfil = p.id_perfil');
          $this->db->where( 'u.id !=', $id_session);
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( u.nombre LIKE  "%'.$cadena.'%" ) OR (u.apellidos LIKE  "%'.$cadena.'%") OR (p.perfil LIKE  "%'.$cadena.'%") 
                        OR (  AES_DECRYPT( u.email,"{$this->key_hash}")  LIKE  "%'.$cadena.'%") 
                        
                       )
            )';   



  
          $this->db->where($where);
    
          //ordenacion
          $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->perfil,
                                      2=>$row->nombre,
                                      3=>$row->apellidos,
                                      4=>$row->email,
                                      5=>$row->telefono,
                                      
                                      
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_usuarios() ), 
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      



        public function total_usuarios(){
            $id_session = $this->session->userdata('id');

            $especial=$this->session->userdata('especial');

            $this->db->from($this->usuarios.' as u');
            $this->db->join($this->perfiles.' as p', 'u.id_perfil = p.id_perfil');

            $this->db->where( 'u.id !=', $id_session );
                           
            
           $total = $this->db->get();            
           return $total->num_rows();
            
        }       






      public function historico_acceso($data){
          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];


          switch ($columa_order) {
                  case '0':
                        $columna = 'u.nombre';
                     break;
                  case '1':
                        $columna = 'p.perfil';
                     break;
                  case '2':
                        $columna = 'h.email';
                     break;
                  case '3':
                        $columna = 'h.fecha';
                     break;  
                  case '4':
                        $columna = 'h.ip_address';
                     break;  
                  case '5':
                        $columna = 'h.user_agent';
                     break;                      
                   
                   default:
                        $columna = 'u.nombre';
                     break;
                 }                 

                                      

          //$id_session = $this->db->escape($this->session->userdata('id'));
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          




            $this->db->select("AES_DECRYPT(h.email,'{$this->key_hash}') AS email", FALSE);            
            $this->db->select('p.id_perfil, p.perfil, p.operacion');
            $this->db->select('u.nombre,u.apellidos');         
            $this->db->select('h.ip_address, h.user_agent, h.id_usuario');
            $this->db->select("( CASE WHEN h.fecha = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(h.fecha),'%d-%m-%Y %H:%i:%s') END ) AS fecha", FALSE);  

            $this->db->from($this->historico_acceso.' As h');
            $this->db->join($this->usuarios.' As u' , 'u.id = h.id_usuario');
            $this->db->join($this->perfiles.' As p', 'u.id_perfil = p.id_perfil','LEFT');
          
          //filtro de busqueda
       
       
          $where = '(

                      (
                        ( u.nombre LIKE  "%'.$cadena.'%" ) OR (u.apellidos LIKE  "%'.$cadena.'%") OR (p.perfil LIKE  "%'.$cadena.'%") 
                        OR (  AES_DECRYPT( h.email,"{$this->key_hash}")  LIKE  "%'.$cadena.'%") 
                        OR (  DATE_FORMAT(FROM_UNIXTIME(h.fecha),"%d-%m-%Y %H:%i:%s")     LIKE  "%'.$cadena.'%") 
                        OR (h.ip_address LIKE  "%'.$cadena.'%")
                        OR (h.user_agent LIKE  "%'.$cadena.'%")
                       )
            )';   


        

  
  
          $this->db->where($where);
      

          //ordenacion
         $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

         

              if ( $result->num_rows() > 0 ) {
                
                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);
                    

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                               $dato[]= array(
                                     
                                      0=>$row->nombre,
                                      1=>$row->apellidos,
                                      2=>$row->perfil,
                                      3=>$row->email,
                                      4=>$row->fecha,
                                      5=>$row->ip_address,
                                      6=>$row->user_agent,
                                      
                                      
                                      
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_historico_acceso() ), 
                        "recordsFiltered" =>  $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      



        public function total_historico_acceso(){
            $id_session = $this->session->userdata('id');

            $especial=$this->session->userdata('especial');

            $this->db->from($this->historico_acceso.' As h');
            $this->db->join($this->usuarios.' As u' , 'u.id = h.id_usuario');
            $this->db->join($this->perfiles.' As p', 'u.id_perfil = p.id_perfil','LEFT');
          

            //$this->db->where( 'u.id !=', $id_session );
                           
            
           $total = $this->db->get();            
           return $total->num_rows();
            
        }       

     



      public function buscador_participantes($data){
          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];


          switch ($columa_order) {
                   case '0':
                        $columna = 'fecha';
                     break;
                   case '1':
                        $columna = 'nomb';
                     break;
                  case '2':
                        $columna = 'nick';  
                     break;                     
                  case '3':
                        $columna = 'puntos';  
                     break;                     

                  case '4':
                        $columna = 'email';  
                     break;                     
                  case '5':
                        $columna = 'telefono';
                     break;                     
                                                                                                    
                  case '6':
                        $columna = 'premio';  
                     break;                                                                                   
                   
                   default:
                        $columna = 'puntos'; //por defecto los ṕuntos
                     break;
                 }                 

                                      

          //$id_session = $this->db->escape($this->session->userdata('id'));
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          

          $this->db->select("p.id", FALSE);           
          $this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);            
          $this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nomb", FALSE);      
          $this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
          $this->db->select("AES_DECRYPT(p.nick,'{$this->key_hash}') AS nick", FALSE);      
          $this->db->select("AES_DECRYPT(p.telefono,'{$this->key_hash}') AS telefono", FALSE);      
          $this->db->select("AES_DECRYPT(p.contrasena,'{$this->key_hash}') AS contrasena", FALSE);
          $this->db->select("CONVERT(AES_DECRYPT(p.total,'{$this->key_hash}'),decimal) AS puntos", FALSE);
          $this->db->select("( CASE WHEN p.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc),'%d-%m-%Y %h:%i:%s %A') END ) AS fecha", FALSE);  
          //$this->db->select("c.nombre estado", FALSE);           
          //$this->db->select("pr.nombre premio", FALSE);      

          $this->db->from($this->participantes.' as p');
          //$this->db->join($this->catalogo_estados.' as c', 'c.id = p.id_estado');
          //$this->db->join($this->catalogo_premios.' as pr', 'pr.id = p.id_premio');
          
          //filtro de busqueda
            $where = "(

                      (
                        (  CONCAT( AES_DECRYPT(p.nombre,'{$this->key_hash}'),' ',AES_DECRYPT(p.apellidos,'{$this->key_hash}') ) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(p.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( AES_DECRYPT(p.telefono,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc),'%d-%m-%Y') LIKE  '%".$cadena."%' )                         
                        OR ( CONCAT('@',AES_DECRYPT(p.nick,'{$this->key_hash}') )LIKE  '%".$cadena."%' ) 
                        
                        
                       )
            )";              

  
          $this->db->where($where);
    
          //ordenacion
          $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                               $dato[]= array(
                                      0=>$row->id,
                                      //1=>$row->estado,
                                      2=>$row->nomb,
                                      3=>$row->apellidos,
                                      4=>$row->nick,
                                      5=>$row->email,
                                      6=>$row->telefono,
                                      7=>$row->fecha,
                                      8=>$row->puntos,
                                      //9=>$row->premio,
                                      
                                      
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_participantes() ), 
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      



        public function total_participantes(){
            

          $this->db->from($this->participantes.' as p');
          $this->db->join($this->catalogo_estados.' as c', 'c.id = p.id_estado');
          $this->db->join($this->catalogo_premios.' as pr', 'pr.id = p.id_premio');

            
           $total = $this->db->get();            
           return $total->num_rows();
            
        }       




//detalles del participantes

          public function listado_imagenes(){

            $this->db->select('c.id, c.nombre, c.valor, c.activo, c.puntos');
            $this->db->from($this->catalogo_imagenes.' as c');
            $this->db->where('c.activo',0);
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }   

      public function buscador_detalle_participantes($data){

        $objeto = self::listado_imagenes();


          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];


          switch ($columa_order) {
                  case '2':
                        $columna = 'monto';  
                     break;                     
                 case '3':
                        $columna = 'ticket';  
                     break;                     
                 case '4':
                        $columna = 'transaccion';  
                     break;                     
                 /*case '5':
                        $columna = 'clave_producto';  
                     break;                     */
                  case '5':
                        $columna = 'compra';
                     break;
                  case '6':
                        $columna = 'redes';
                     break;
                  
                  /*case '7':
                        $columna = 'litraje';
                     break;  
                  case '8':
                        $columna = 'cantidad';
                     break;  */

                   default:
                        $columna = 'fecha_pc_compra'; //por defecto los ṕuntos
                     break;
                 }                 

          
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          

          $this->db->select("p.id", FALSE);           
          $this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);            
          $this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nomb", FALSE);      
          $this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
          $this->db->select("AES_DECRYPT(p.telefono,'{$this->key_hash}') AS telefono", FALSE);      
          $this->db->select("AES_DECRYPT(p.total,'{$this->key_hash}') AS total", FALSE);
          $this->db->select("( CASE WHEN p.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(p.fecha_pc),'%d-%m-%Y') END ) AS fecha_registro", FALSE);  
            
            $this->db->select("AES_DECRYPT(r.monto,'{$this->key_hash}') AS monto", FALSE);      
            $this->db->select("AES_DECRYPT(r.ticket,'{$this->key_hash}') AS ticket", FALSE);      
            
            $this->db->select("AES_DECRYPT(r.transaccion,'{$this->key_hash}') AS transaccion", FALSE);      
            //$this->db->select("AES_DECRYPT(r.clave_producto,'{$this->key_hash}') AS clave_producto", FALSE);      

            $this->db->select("AES_DECRYPT(r.puntos,'{$this->key_hash}') AS puntos", FALSE);      
            $this->db->select("( CASE WHEN r.compra = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(r.compra),'%d-%m-%Y') END ) AS compra", FALSE);  
            $this->db->select("( CASE WHEN r.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(r.fecha_pc),'%d-%m-%Y %h:%i:%s %A') END ) AS fecha_pc_compra", FALSE);  
            //$this->db->select("r.id_litraje", FALSE);      
            $this->db->select("r.cantidad", FALSE);      
            //$this->db->select("l.nombre litraje", FALSE);      
            $this->db->select("( CASE WHEN r.redes = 0 THEN 'No' ELSE 'Si' END ) AS redes", FALSE);  

          $this->db->from($this->participantes.' as p');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');
          //$this->db->join($this->catalogo_litraje.' as l', 'r.id_litraje = l.id');

          
          //filtro de busqueda
       

          $where = "( (p.id='".$data['id']."') ) AND   
                  (
                         ( AES_DECRYPT(r.ticket,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                         OR ( AES_DECRYPT(r.monto,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                         
                         OR ( DATE_FORMAT(FROM_UNIXTIME(r.compra),'%d-%m-%Y') LIKE  '%".$cadena."%' ) 

                         OR ( AES_DECRYPT(r.transaccion,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 


                   )     


           ";      

           /*
                OR ( AES_DECRYPT(r.clave_producto,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                         OR ( l.nombre LIKE  '%".$cadena."%' ) 
                         OR ( r.cantidad LIKE  '%".$cadena."%' ) 

           */

          $this->db->where($where);
    
          //ordenacion
          $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 

          $basede = base_url();
          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {

                    //imagenes
                      $total_puntos = 25;

                       $caritas = base64_decode($row->puntos);
                            $c1 =  (int) ($caritas / 100);
                            $c2 =   (int) (($caritas % 100) / 10 );
                            $c3 =   (int) (($caritas % 10)  );

                    foreach ($objeto as $llave => $valor) {  
                      
                        
                       
                        
                        if   (($c1==$c2) and ($c1==$c3)) { //si los 3 son iguales
                            if ($valor->id == $c1) {
                                 $total_puntos = ($valor->puntos!=0) ? $valor->puntos : 25;
                            }

                        }

                        if ($c1 == $valor->id) {
                            $imagen1 ='<img src="'.$basede.'/'.$valor->valor.'" border="0" width="25" height="25">';
                        }

                        if ($c2 == $valor->id) {
                            $imagen2 ='<img src="'.$basede.'/'.$valor->valor.'" border="0" width="25" height="25">';
                        }

                        if ($c3 == $valor->id) {
                            $imagen3 ='<img src="'.$basede.'/'.$valor->valor.'" border="0" width="25" height="25">';
                        }



                    }


                               $dato[]= array(
                                      0=>$row->id,
                                      1=> $total_puntos, // $row->total,
                                      2=>$imagen1.$imagen2.$imagen3,  //base64_decode($row->puntos),
                                      3=>$row->monto,
                                      4=>$row->ticket,
                                      5=>$row->transaccion,
                                      //6=>$row->clave_producto,
                                      7=>$row->compra,
                                      //8=>$row->litraje,
                                      9=>$row->cantidad,
                                      10=>$row->redes,
                                      11=>$row->fecha_pc_compra,
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_detalle_participantes($data) ), 
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      



        public function total_detalle_participantes($data){
            

             $this->db->from($this->participantes.' as p');
            $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante');
            $this->db->join($this->catalogo_litraje.' as l', 'r.id_litraje = l.id');
            $where = "( (p.id='".$data['id']."') )";      

            $this->db->where($where);
            
           $total = $this->db->get();            
           return $total->num_rows();
            
        }       






        //historico participantes

 public function bitacora_participantes($data){
          
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];



              switch ($columa_order) {
                   case '0':
                        $columna = 'nomb';
                     break;
                   case '1':
                        $columna = 'nick';
                     break;                     
                  case '2':
                        $columna = 'correo';  
                     break;                     
                  case '3':
                        $columna = 'fecha';
                     break;                     
                  
                  case '4':
                        $columna = 'ip_address';
                     break;  
                  case '5':
                        $columna = 'user_agent';
                     break;                                                                                                       
                   
                   default:
                        $columna = 'fecha'; //por defecto los ṕuntos
                     break;
              }        









                                      

          //$id_session = $this->db->escape($this->session->userdata('id'));
           $id_session = $this->session->userdata('id');

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          



            $this->db->select("h.id", FALSE);            
            $this->db->select("AES_DECRYPT(h.email,'{$this->key_hash}') AS correo", FALSE);            
            $this->db->select("AES_DECRYPT(u.nombre,'{$this->key_hash}') AS nomb", FALSE);      
            $this->db->select("AES_DECRYPT(u.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
            $this->db->select("AES_DECRYPT(u.nick,'{$this->key_hash}') AS nick", FALSE);      
            $this->db->select('h.ip_address, h.user_agent, h.id_usuario');
            $this->db->select("( CASE WHEN h.fecha_pc = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(h.fecha_pc),'%d-%m-%Y %H:%i:%s') END ) AS fecha", FALSE);  

            $this->db->from($this->bitacora_participante.' As h');
            $this->db->join($this->participantes.' As u' , 'u.id = h.id_usuario');
          
          //filtro de busqueda
       
       

        $where = "(

                      (
                        (  CONCAT( AES_DECRYPT(u.nombre,'{$this->key_hash}'),' ',AES_DECRYPT(u.apellidos,'{$this->key_hash}') ) LIKE  '%".$cadena."%' )
                        OR ( AES_DECRYPT(h.email,'{$this->key_hash}') LIKE  '%".$cadena."%' ) 
                        OR ( DATE_FORMAT(FROM_UNIXTIME(h.fecha_pc),'%d-%m-%Y %H:%i:%s') LIKE  '%".$cadena."%' ) 
                        OR (h.ip_address LIKE  '%".$cadena."%' ) 
                        OR (h.user_agent LIKE  '%".$cadena."%' ) 
                        OR ( CONCAT('@',AES_DECRYPT(u.nick,'{$this->key_hash}') )LIKE  '%".$cadena."%' ) 
                        
                       )
            )";   

       
  
          $this->db->where($where);
          
      

          //ordenacion
         $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

         

              if ( $result->num_rows() > 0 ) {
                
                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);
                    

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                               $dato[]= array(
                                     
                                      0=>$row->id,
                                      1=>$row->nomb,
                                      2=>$row->apellidos,
                                      3=>$row->nick,
                                      4=>$row->correo,
                                      5=>$row->fecha,
                                      6=>$row->ip_address,
                                      7=>$row->user_agent,
                                      
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_bitacora_participantes() ), 
                        "recordsFiltered" =>  $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      



        public function total_bitacora_participantes(){
            $this->db->from($this->bitacora_participante.' As h');
            $this->db->join($this->participantes.' As u' , 'u.id = h.id_usuario');
            
           $total = $this->db->get();            
           return $total->num_rows();
            
        }               


	} 
?>
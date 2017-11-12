<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class catalogo extends CI_Model {
		
		private $key_hash;
		private $timezone;

		function __construct(){

			parent::__construct();
			$this->load->database("default");
			$this->key_hash    = $_SERVER['HASH_ENCRYPT'];
			$this->timezone    = 'UM1';

      
				  $this->usuarios             = $this->db->dbprefix('usuarios');
          $this->perfiles             = $this->db->dbprefix('perfiles');

         
          
          $this->proveedores          = $this->db->dbprefix('catalogo_empresas');
          $this->historico_acceso     = $this->db->dbprefix('historico_acceso');

      
          $this->participantes      = $this->db->dbprefix('participantes');
          $this->bitacora_participante      = $this->db->dbprefix('bitacora_participante');

          $this->registro_participantes         = $this->db->dbprefix('registro_participantes');
          $this->catalogo_litrajes      = $this->db->dbprefix('catalogo_litraje');

         
         $this->configuraciones      = $this->db->dbprefix('catalogo_configuraciones');
         $this->catalogo_imagenes         = $this->db->dbprefix('catalogo_imagenes');
         $this->catalogo_estados      = $this->db->dbprefix('catalogo_estados');

         $this->catalogo_premios      = $this->db->dbprefix('catalogo_premios');
      
      

    
    }

   
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////********premios*****************/////////////////////////////       
/////////////////////////////////////////////////////////////////////////////////////////////////

    public function total_archivos($data){

        $this->db->select("( CASE WHEN valor = '' THEN 0 ELSE 1 END ) AS cantidad", FALSE);
        $this->db->select('valor archivo');
        
        $this->db->where('id', $data['id'] );

        $result = $this->db->get( $this->db->dbprefix($data['tabla']) );
        return $result->row();
        $result->free_result();
    }



    public function listado_premios(){

            $this->db->select('c.id, c.nombre, c.valor, c.activo, c.cantidad');
            $this->db->from($this->catalogo_premios.' as c');
            $where = '(
                         ( c.activo = 0 ) AND
                         ( c.usado < c.cantidad   )
                      )';  

            $this->db->where($where);          

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }     


 public function buscador_cat_premios($data){

          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

           if ($data['draw'] ==1) { //que se ordene por el ultimo
                 $columa_order ='-1';
                 $order = 'desc';
           } 



          switch ($columa_order) {
                   case '0':
                        $columna = 'c.nombre';
                     break;
                   case '2':
                        $columna = 'c.cantidad';
                     break;

                   default:
                        $columna = 'c.id';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id, c.nombre premio, c.valor, c.cantidad');

          $this->db->from($this->catalogo_premios.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) 
                        OR (c.nombre LIKE  "%'.$cadena.'%")
                        OR (c.cantidad LIKE  "%'.$cadena.'%")
                        
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
                                      1=>$row->premio,
                                      2=>'<img src="/'.$row->valor.'" border="0" width="50" height="50">', //esta es la premio
                                      3=>$row->cantidad,
                                      4=>0, //self::premios_en_uso($row->id),
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_premios() ), 
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

      public function total_cat_premios(){
              $id_session = $this->session->userdata('id');

              $this->db->from($this->catalogo_premios.' as c');


              //$this->db->where($where);
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }   
       

//checar si el premio ya existe
    public function check_existente_premio($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_premios);
            $this->db->where('nombre',$data['premio']);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 

      //crear
        public function anadir_premio( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'nombre', $data['premio'] );  
          $this->db->set( 'cantidad', $data['cantidad'] );  
          


          if  (isset($data['archivo_premio'])) {
            $this->db->set( 'valor', 'img/premios/'.$data['archivo_premio']['file_name']);          
          }  


            $this->db->insert($this->catalogo_premios );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }      

      public function coger_premio( $data ){
              
            $this->db->select("c.id, c.nombre premio, c.cantidad, c.valor");         
            $this->db->from($this->catalogo_premios.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

     


        //editar
        public function editar_premio( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'nombre', $data['premio'] );  
          $this->db->set( 'cantidad', $data['cantidad'] );  
          


          if  (isset($data['archivo_premio'])) {
            $this->db->set( 'valor', 'img/premios/'.$data['archivo_premio']['file_name']);          
          }  


          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_premios );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return true;
                $result->free_result();
        }   


        //eliminar premio
        public function eliminar_premio( $data ){
            $this->db->delete( $this->catalogo_premios, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        } 

    
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////********imagenes*****************/////////////////////////////       
/////////////////////////////////////////////////////////////////////////////////////////////////

 public function buscador_cat_imagenes($data){

          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

           if ($data['draw'] ==1) { //que se ordene por el ultimo
                 $columa_order ='-1';
                 $order = 'desc';
           } 



          switch ($columa_order) {
                   case '0':
                        $columna = 'c.nombre';
                     break;
                   case '2':
                        $columna = 'c.puntos';
                     break;

                   default:
                        $columna = 'c.id';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id, c.nombre imagen, c.valor, c.puntos');

          $this->db->from($this->catalogo_imagenes.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) 
                        OR (c.nombre LIKE  "%'.$cadena.'%")
                        OR (c.puntos LIKE  "%'.$cadena.'%")
                        
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
                                      1=>$row->imagen,
                                      2=>'<img src="/'.$row->valor.'" border="0" width="50" height="50">', //esta es la imagen
                                      3=>$row->puntos,
                                      4=>0, //self::imagenes_en_uso($row->id),
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_imagenes() ), 
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

      public function total_cat_imagenes(){
              $id_session = $this->session->userdata('id');

              $this->db->from($this->catalogo_imagenes.' as c');


              //$this->db->where($where);
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }   
       

//checar si el imagen ya existe
    public function check_existente_imagen($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_imagenes);
            $this->db->where('nombre',$data['imagen']);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 

      //crear
        public function anadir_imagen( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'nombre', $data['imagen'] );  
          $this->db->set( 'puntos', $data['puntos'] );  
          


          if  (isset($data['archivo_imagen'])) {
            $this->db->set( 'valor', 'img/juego/'.$data['archivo_imagen']['file_name']);          
          }  


            $this->db->insert($this->catalogo_imagenes );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }      

      public function coger_imagen( $data ){
              
            $this->db->select("c.id, c.nombre imagen,c.puntos, c.valor");         
            $this->db->from($this->catalogo_imagenes.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

     


        //editar
        public function editar_imagen( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'nombre', $data['imagen'] ); 
          $this->db->set( 'puntos', $data['puntos'] );  
          


          if  (isset($data['archivo_imagen'])) {
            $this->db->set( 'valor', 'img/juego/'.$data['archivo_imagen']['file_name']);          
          }  

          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_imagenes );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return true;
                $result->free_result();
        }   


        //eliminar imagen
        public function eliminar_imagen( $data ){
            $this->db->delete( $this->catalogo_imagenes, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     

    
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////********Litrajes*****************/////////////////////////////       
/////////////////////////////////////////////////////////////////////////////////////////////////

 public function buscador_cat_litrajes($data){

          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

           if ($data['draw'] ==1) { //que se ordene por el ultimo
                 $columa_order ='-1';
                 $order = 'desc';
           } 



          switch ($columa_order) {
                   case '0':
                        $columna = 'c.nombre';
                     break;
                   
                   default:
                        $columna = 'c.id';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id, c.nombre litraje');

          $this->db->from($this->catalogo_litrajes.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) OR (c.nombre LIKE  "%'.$cadena.'%")
                        
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
                                      1=>$row->litraje,
                                      2=>0, //self::litrajes_en_uso($row->id),
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_litrajes() ), 
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

      public function total_cat_litrajes(){
              $id_session = $this->session->userdata('id');

              $this->db->from($this->catalogo_litrajes.' as c');


              //$this->db->where($where);
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }   
       

//checar si el litraje ya existe
    public function check_existente_litraje($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_litrajes);
            $this->db->where('nombre',$data['litraje']);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 

      //crear
        public function anadir_litraje( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'nombre', $data['litraje'] );  

            $this->db->insert($this->catalogo_litrajes );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }      

      public function coger_litraje( $data ){
              
            $this->db->select("c.id, c.nombre litraje");         
            $this->db->from($this->catalogo_litrajes.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

     


        //editar
        public function editar_litraje( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          $this->db->set( 'nombre', $data['litraje'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_litrajes );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar litraje
        public function eliminar_litraje( $data ){
            $this->db->delete( $this->catalogo_litrajes, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     
      

    
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////********estados*****************/////////////////////////////       
/////////////////////////////////////////////////////////////////////////////////////////////////

 public function buscador_cat_estados($data){

          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

           if ($data['draw'] ==1) { //que se ordene por el ultimo
                 $columa_order ='-1';
                 $order = 'desc';
           } 



          switch ($columa_order) {
                   case '0':
                        $columna = 'c.nombre';
                     break;
                   
                   default:
                        $columna = 'c.id';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id, c.nombre estado');

          $this->db->from($this->catalogo_estados.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) OR (c.nombre LIKE  "%'.$cadena.'%")
                        
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
                                      1=>$row->estado,
                                      2=>0, //self::estados_en_uso($row->id),
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_estados() ), 
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

      public function total_cat_estados(){
              $id_session = $this->session->userdata('id');

              $this->db->from($this->catalogo_estados.' as c');


              //$this->db->where($where);
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }   
       

//checar si el estado ya existe
    public function check_existente_estado($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_estados);
            $this->db->where('nombre',$data['estado']);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 

      //crear
        public function anadir_estado( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'nombre', $data['estado'] );  

            $this->db->insert($this->catalogo_estados );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }      

      public function coger_estado( $data ){
              
            $this->db->select("c.id, c.nombre estado");         
            $this->db->from($this->catalogo_estados.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

     


        //editar
        public function editar_estado( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          $this->db->set( 'nombre', $data['estado'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_estados );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar estado
        public function eliminar_estado( $data ){
            $this->db->delete( $this->catalogo_estados, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     
      


    
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////********CONFIGURACIONES*****************/////////////////////////////       
/////////////////////////////////////////////////////////////////////////////////////////////////



  public function buscador_cat_configuraciones($data){

          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

           if ($data['draw'] ==1) { //que se ordene por el ultimo
                 $columa_order ='-1';
                 $order = 'desc';
           } 



          switch ($columa_order) {
                   case '0':
                        $columna = 'c.configuracion';
                     break;
                   case '1':
                        $columna = 'c.valor';
                     break;

                   case '2':
                        $columna = 'c.activo';
                     break;

                   default:
                        $columna = 'c.id';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id, c.configuracion,c.valor,c.activo');

          $this->db->from($this->configuraciones.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) OR (c.configuracion LIKE  "%'.$cadena.'%")
                        OR (c.activo LIKE  "%'.$cadena.'%") OR (c.valor LIKE  "%'.$cadena.'%")
                        
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
                                      1=>$row->configuracion,
                                      2=>$row->activo,
                                      3=>$row->valor,
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_configuraciones() ), 
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


  public function total_cat_configuraciones(){
              $id_session = $this->session->userdata('id');

              $this->db->from($this->configuraciones.' as c');

              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }     


  //crear
        public function anadir_configuracion( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'configuracion', $data['configuracion'] );  
          $this->db->set( 'activo', $data['activo'] );  
          $this->db->set( 'valor', $data['valor'] );  


            $this->db->insert($this->configuraciones );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          
   public function coger_configuracion( $data ){
              
            $this->db->select("c.id, c.configuracion,c.activo,c.valor");         
            $this->db->from($this->configuraciones.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //editar
        public function editar_configuracion( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'configuracion', $data['configuracion'] );  
          $this->db->set( 'activo', $data['activo'] );  
          $this->db->set( 'valor', $data['valor'] );  


          $this->db->where('id', $data['id'] );
          $this->db->update($this->configuraciones );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


 //eliminar configuracion
        public function eliminar_configuracion( $data ){
            $this->db->delete( $this->configuraciones, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }   






       

      






	} 


?>

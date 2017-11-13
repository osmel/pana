<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

  class registros extends CI_Model{
    
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
          $this->catalogo_litraje      = $this->db->dbprefix('catalogo_litraje');

          $this->participantes      = $this->db->dbprefix('participantes');
          $this->bitacora_participante     = $this->db->dbprefix('bitacora_participante');
          $this->catalogo_imagenes         = $this->db->dbprefix('catalogo_imagenes');
          
          $this->registro_participantes         = $this->db->dbprefix('registro_participantes');
          

    }


        //checar si el correo ya fue registrado
    public function check_correo_existente($data){
      $this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->from($this->participantes);
      $this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
      $login = $this->db->get();
      if ($login->num_rows() > 0)
        return FALSE;
      else
        return TRUE;
      $login->free_result();
    }

       //agregar participante
    public function anadir_registro( $data ){
            $timestamp = time();

            
            $this->db->set( 'total', "AES_ENCRYPT(0,'{$this->key_hash}')", FALSE );  //total comienza en 0
            $this->db->set( 'tarjeta', "AES_ENCRYPT('','{$this->key_hash}')", FALSE );  //total comienza en 0
            $this->db->set( 'juego', "AES_ENCRYPT('','{$this->key_hash}')", FALSE );  //total comienza en 0

            $this->db->set( 'id_perfil', $data['id_perfil']);
            $this->db->set( 'creacion',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            $this->db->set( 'id', "UUID()", FALSE); //id

            $this->db->set( 'nombre', "AES_ENCRYPT('{$data['nombre']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'apellidos', "AES_ENCRYPT('{$data['apellidos']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'fecha_nac', strtotime(date( "d-m-Y", strtotime($data['fecha_nac']) )) ,false);


            $this->db->set( 'id_estado', $data['id_estado']);
            $this->db->set( 'celular', "AES_ENCRYPT('{$data['celular']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE );

            $this->db->insert($this->participantes );

            if ($this->db->affected_rows() > 0){
                  return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }


     //checar el login del participante
        public function check_login($data){
          $this->db->select("id", FALSE);           
          $this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);      
          $this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nombre", FALSE);      
          $this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
          $this->db->select("AES_DECRYPT(p.celular,'{$this->key_hash}') AS celular", FALSE);      
          $this->db->select("AES_DECRYPT(p.contrasena,'{$this->key_hash}') AS contrasena", FALSE);

          $this->db->select("AES_DECRYPT(p.tarjeta,'{$this->key_hash}') AS tarjeta", FALSE);
          $this->db->select("AES_DECRYPT(p.juego,'{$this->key_hash}') AS juego", FALSE);

          $this->db->from($this->participantes.' as p');
            
          $this->db->where('p.email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE); 
          $this->db->where('p.contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
          $login = $this->db->get();

          if ($login->num_rows() > 0)
            return $login->result();
          else 
            return FALSE;
          $login->free_result();
        }        



      //agregar a la bitacora de participante sus accesos  
       public function anadir_historico_acceso($data){
            $timestamp = time();
            $ip_address = $this->input->ip_address();
            $user_agent= $this->input->user_agent();

            $this->db->set( 'id_usuario', $data->id); // luego esta se compara con la tabla participante
            $this->db->set( 'email', "AES_ENCRYPT('{$data->email}','{$this->key_hash}')", FALSE );
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            $this->db->set( 'ip_address',  $ip_address, TRUE );
            $this->db->set( 'user_agent',  $user_agent, TRUE );
            $this->db->insert($this->bitacora_participante );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();

        }




 //----------------**************catalogos-------------------************------------------
        public function listado_estados(){
            $this->db->select( 'id, nombre' );
            $estados = $this->db->get($this->catalogo_estados );
            if ($estados->num_rows() > 0 )
               return $estados->result();
            else
               return FALSE;
            $estados->free_result();
        }   



        /////////////////////ticket//////////////////////////


        //checar si el tickets ya fue registrado
        public function check_tickets_existente($data){
            $this->db->select("AES_DECRYPT(tarjeta,'{$this->key_hash}') AS tarjeta", FALSE);
            $this->db->select("AES_DECRYPT(juego,'{$this->key_hash}') AS juego", FALSE);
            $this->db->from($this->registro_participantes);
            $this->db->where('ticket',"AES_ENCRYPT('{$data['ticket']}','{$this->key_hash}')",FALSE);
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return false; // $login->row();
            else
                return TRUE;
            $login->free_result();
        }





            //agregar participante
        public function anadir_tickets( $data ){
            $timestamp = time();

            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            
            $id_participante = $this->session->userdata('id_participante');
            $this->db->set( 'id_participante', '"'.$id_participante.'"',false); // id del usuario que se registro
            $this->db->set( 'ticket', "AES_ENCRYPT('{$data['ticket']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'monto', "AES_ENCRYPT('{$data['monto']}','{$this->key_hash}')", FALSE );
            
            $this->db->set( 'compra', strtotime(date( "d-m-Y", strtotime($data['compra']) )) ,false);
            //el orden de las cartas
            $this->db->set( 'puntos', "AES_ENCRYPT('{$data['puntos']}','{$this->key_hash}')", FALSE );
            //tarjeta vacia inicialmente
            $this->db->set( 'tarjeta', "AES_ENCRYPT('','{$this->key_hash}')", FALSE );  //total comienza en 0
            $this->db->set( 'juego', "AES_ENCRYPT('','{$this->key_hash}')", FALSE );  //total comienza en 0
            $this->db->insert($this->registro_participantes );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }   


         public function actualizar_respuesta_tarjeta($data){
            $this->db->set( 'tarjeta', "AES_ENCRYPT('{$data['formato']}','{$this->key_hash}')", FALSE );
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('num_ticket_participante')}','{$this->key_hash}')",FALSE);
             $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();

        }

        public function actualizar_respuesta_juego($data){

            $this->db->set( 'juego', "AES_ENCRYPT('{$data['formato']}','{$this->key_hash}')", FALSE );
            $this->db->where("id_participante", '"'.$this->session->userdata('id_participante').'"',false);  
            $this->db->where('ticket',"AES_ENCRYPT('{$this->session->userdata('num_ticket_participante')}','{$this->key_hash}')",FALSE);
             $this->db->update($this->registro_participantes );
  
              if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();

        }



        public function record_personal($data){
             $this->db->select("COUNT(r.id_participante) as 'cantidad'");

             $this->db->select("
             sum(

                (
                  ((SUBSTR(AES_DECRYPT( r.juego,  '{$this->key_hash}' ), 1, 
                  LOCATE(  '+', AES_DECRYPT( r.juego,  '{$this->key_hash}' ) )-1
                  ) = '1') AND 
                (SUBSTR(AES_DECRYPT( r.juego,  '{$this->key_hash}' ), 
                  LOCATE(  '+', AES_DECRYPT( r.juego,  '{$this->key_hash}' ) )+1,
                  LOCATE(  '+', AES_DECRYPT( r.juego,  '{$this->key_hash}' ) )-1
                )='3'))* (  SUBSTRING_INDEX
                    (             SUBSTRING_INDEX(AES_DECRYPT( r.tarjeta,  '{$this->key_hash}'),'-;',1),'+',-1

                    ) + 

                    SUBSTRING_INDEX
                     (
                    SUBSTRING_INDEX(AES_DECRYPT( r.tarjeta,  '{$this->key_hash}'),'+',-1)
                    ,'-;',1

                    )) 
                )    +


                (
                  ((SUBSTR(AES_DECRYPT( r.juego,  '{$this->key_hash}' ), 1, 
                  LOCATE(  '+', AES_DECRYPT( r.juego,  '{$this->key_hash}' ) )-1
                  ) <> '1') or 
                (SUBSTR(AES_DECRYPT( r.juego,  '{$this->key_hash}' ), 
                  LOCATE(  '+', AES_DECRYPT( r.juego,  '{$this->key_hash}' ) )+1,
                  LOCATE(  '+', AES_DECRYPT( r.juego,  '{$this->key_hash}' ) )-1
                )<>'3'))* 25
                )


               ) AS total_iguales

              ",false );


            
          $this->db->select("AES_DECRYPT(r.tarjeta,'{$this->key_hash}') AS tarjeta", FALSE);
          $this->db->select("AES_DECRYPT(r.juego,'{$this->key_hash}') AS juego", FALSE);
          $this->db->from($this->participantes.' as p');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante','left');
          $where = "( (p.id='".$data['id_participante']."') ) ";      
          $this->db->where($where);
          //$this->db->group_by("p.id");

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->row();
            else
               return False;
            $result->free_result();


         } 
      
}
?>       
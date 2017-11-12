//-----------composiciones------------------

        public function total_composiciones(){
           $this->db->from($this->composiciones);
           $composiciones = $this->db->get();            
           return $composiciones->num_rows();
        }

        public function listado_composiciones($limit=-1, $offset=-1){

          $this->db->select('c.id, c.composicion');
          $this->db->from($this->composiciones.' as c');
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();


            if ( $result->num_rows() > 0 ) {
                foreach ($result->result() as $row)  {
                         $row->uso = self::composiciones_en_uso($row->id);
                 }                 
               return $result->result();
            }             
            else
               return False;
            $result->free_result();
        }        



      public function buscador_composiciones($data){
            $this->db->select( 'id' );
            $this->db->select("composicion", FALSE);  
            $this->db->from($this->composiciones);
            $this->db->like("composicion" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array("value"=>$row->composicion,
                                       "key"=>$row->id
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    

    
   

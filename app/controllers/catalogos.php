<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Catalogos extends CI_Controller {

  public function __construct(){
    parent::__construct();
    

    $this->load->model('admin/modelo', 'modelo'); 
    $this->load->model('registros', 'modelo_registro'); 
    $this->load->library(array('email')); 

    $this->load->model('admin/catalogo', 'catalogo');  
  }





//***********************Todos los catalogos**********************************//
  public function listado_catalogos(){

    if ( $this->session->userdata('session') !== TRUE ) {
      redirect('');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   
      switch ($id_perfil) {    
        case 1:
              $this->load->view( 'catalogos/catalogos' );
          break;
        case 2:
        case 3:
        case 4:
             if   ((in_array(8, $coleccion_id_operaciones)) 
                  || (in_array(11, $coleccion_id_operaciones)) || (in_array(12, $coleccion_id_operaciones)) 
                  || (in_array(13, $coleccion_id_operaciones)) || (in_array(14, $coleccion_id_operaciones)) 
                  || (in_array(15, $coleccion_id_operaciones)) || (in_array(16, $coleccion_id_operaciones)) 
                  || (in_array(17, $coleccion_id_operaciones)) || (in_array(18, $coleccion_id_operaciones)) 
                  || (in_array(19, $coleccion_id_operaciones)) || (in_array(20, $coleccion_id_operaciones)) 
                  || (in_array(21, $coleccion_id_operaciones)) || (in_array(22, $coleccion_id_operaciones)) 
              )


               { 
                  $this->load->view( 'catalogos/catalogos' );
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


//***********************premios**********************************//

  

  
  public function listado_premios(){
  

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
            $this->load->view( 'catalogos/premios');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'catalogos/premios');
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

 
 public function procesando_cat_premios(){

    $data=$_POST;
    $busqueda = $this->catalogo->buscador_cat_premios($data);
    echo $busqueda;
  } 

    // crear
  function nuevo_premio(){
if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/premios/nuevo_premio');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $this->load->view( 'catalogos/premios/nuevo_premio');
              }   
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

  function validar_nuevo_premio(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('premio', 'premio', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
    //  $this->form_validation->set_rules('archivo_premio', 'archivo', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          $data['premio']   = $this->input->post('premio');
          $data['cantidad']   = $this->input->post('cantidad');

         $existe            =  $this->catalogo->check_existente_premio( $data );
         if ( $existe !== TRUE ){






     


                $config_adjunto['upload_path']    = './img/juego/original/';
                $config_adjunto['allowed_types']  = 'jpg|png|gif|jpeg';
                $config_adjunto['max_size']     = '20480';
                $config_adjunto['file_name']    = 'premio_'.$data['premio'];
                $config_adjunto['overwrite']    = true;             

                $this->load->library('upload', $config_adjunto);

                $this->upload->do_upload('archivo_premio'); 
                $errors = $this->upload->display_errors();

                  //print_r($errors); die;
                
                //if (!(($errors=='') || ($errors=='<p>No ha seleccionado ningún archivo para subir</p>'))) {
                if ($errors=='<p>No ha seleccionado ningún archivo para subir</p>') {  
                  echo $this->upload->display_errors('<span class="error">', '</span>');
                  //echo '<span class="error"><b>E01</b> - La nueva premio no pudo ser agregada</span>';
                  //echo validation_errors('<span class="error">','</span>');
                } else {
                    if ($errors=='') 
                    {
                      $data['archivo_premio'] = $this->upload->data();
                    } 

                    if  (isset($data['archivo_premio'])) {
                       //este es el thumbnail 

                        /////////////THUMBNAIL///////////////////
                         $this->load->library('image_lib');

                         //este es el thumbnail 
                         $config1 = array(
                            'image_library' => 'GD2',
                            'source_image' => $data['archivo_premio']['full_path'],
                            'new_image' => './img/premios/',
                            //'create_thumb' => TRUE,
                            'maintain_ratio' => true,
                            //'width' => 200,
                            //'height' => 200
                          );


                          $this->image_lib->clear();
                          $this->image_lib->initialize($config1);
                          //$this->image_lib->resize();
                          $this->image_lib->crop();

                          /////////////fin del THUMBNAIL///////////////////

                    }    
 



                  $data         =   $this->security->xss_clean($data);  
                  $guardar            = $this->catalogo->anadir_premio( $data );
                  if ( $guardar !== FALSE ){
                    echo true;
                  } else {
                    echo '<span class="error"><b>E01</b> - El nuevo premio no pudo ser agregada</span>';
                  }

              }  


         } else {
            echo '<span class="error"><b>E01</b> - La composición que desea agregar ya existe. No es posible agregar dos premios iguales.</span>';
         }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_premio( $id = '' ){
     
      if($this->session->userdata('session') === TRUE ){
            $id_perfil=$this->session->userdata('id_perfil');

            $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
            if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                  $coleccion_id_operaciones = array();
             }   




              $data['id']  = base64_decode($id);

              $data['tabla'] = "catalogo_premios";
              $data['total_archivos']  = $this->catalogo->total_archivos( $data );
              $data['premio'] = $this->catalogo->coger_premio($data);

            switch ($id_perfil) {    
              case 1:
                    
                    if ( $data['premio'] !== FALSE ){
                        $this->load->view( 'catalogos/premios/editar_premio', $data );
                    } else {
                          redirect('');
                    }               
                break;
              case 2:
              case 3:
              case 4:
                   if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                      if ( $data['premio'] !== FALSE ){
                          $this->load->view( 'catalogos/premios/editar_premio', $data );
                      } else {
                            redirect('');
                      }       
                   }   
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


function validacion_edicion_premio(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'premio', 'premio', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['premio']         = $this->input->post('premio');
          $data['cantidad']         = $this->input->post('cantidad');
          
          //$existe            =  $this->catalogo->check_existente_premio( $data );
          if ( TRUE ){ //( $existe !== TRUE ){


                $config_adjunto['upload_path']    = './img/juego/original/';
                $config_adjunto['allowed_types']  = 'jpg|png|gif|jpeg';
                $config_adjunto['max_size']     = '20480';
                $config_adjunto['file_name']    = 'premio_'.$data['premio'];
                $config_adjunto['overwrite']    = true;             

                $this->load->library('upload', $config_adjunto);

                $this->upload->do_upload('archivo_premio'); 
                $errors = $this->upload->display_errors();

                  //print_r($errors); die;
                
                //if (!(($errors=='') || ($errors=='<p>No ha seleccionado ningún archivo para subir</p>'))) {
                if ($errors=='<p>No ha seleccionado ningún archivo para subir</p>') {  
                  echo $this->upload->display_errors('<span class="error">', '</span>');
                  //echo '<span class="error"><b>E01</b> - La nueva premio no pudo ser agregada</span>';
                  //echo validation_errors('<span class="error">','</span>');
                } else {
                    if ($errors=='') 
                    {
                      $data['archivo_premio'] = $this->upload->data();
                    } 

                    if  (isset($data['archivo_premio'])) {
                       //este es el thumbnail 

                        /////////////THUMBNAIL///////////////////
                         $this->load->library('image_lib');

                         //este es el thumbnail 
                         $config1 = array(
                            'image_library' => 'GD2',
                            'source_image' => $data['archivo_premio']['full_path'],
                            'new_image' => './img/premios/',
                            //'create_thumb' => TRUE,
                            'maintain_ratio' => true,
                            //'width' => 200,
                            //'height' => 200
                          );


                          $this->image_lib->clear();
                          $this->image_lib->initialize($config1);
                          //$this->image_lib->resize();
                          $this->image_lib->crop();

                          /////////////fin del THUMBNAIL///////////////////

                    }    
 




                  $data               = $this->security->xss_clean($data);  
                  $guardar            = $this->catalogo->editar_premio( $data );

                  if ( $guardar !== FALSE ){
                    echo true;

                  } else {
                    echo '<span class="error"><b>E01</b> - La nueva  premio no pudo ser agregada</span>';
                  }
         }   
         } else {
            echo '<span class="error"><b>E01</b> - El nuevo premio que desea agregar ya existe. No es posible agregar dos premios iguales.</span>';
         }  


      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_premio($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['nombrecompleto']   = base64_decode($nombrecompleto);
            $data['id']  = base64_decode($id);

      switch ($id_perfil) {    
        case 1:
            
            $this->load->view( 'catalogos/premios/eliminar_premio', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                
                $this->load->view( 'catalogos/premios/eliminar_premio', $data );
             }   
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


  function validar_eliminar_premio(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_premio(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la premio</span>';
    }
  }   
   


//***********************imagenes**********************************//

  

  
  public function listado_imagenes(){
  

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
            $this->load->view( 'catalogos/imagenes');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'catalogos/imagenes');
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

 
 public function procesando_cat_imagenes(){

    $data=$_POST;
    $busqueda = $this->catalogo->buscador_cat_imagenes($data);
    echo $busqueda;
  } 

    // crear
  function nuevo_imagen(){
if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/imagenes/nuevo_imagen');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $this->load->view( 'catalogos/imagenes/nuevo_imagen');
              }   
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

  function validar_nuevo_imagen(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('imagen', 'imagen', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
    //  $this->form_validation->set_rules('archivo_imagen', 'archivo', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          $data['imagen']   = $this->input->post('imagen');
          $data['puntos']   = $this->input->post('puntos');

         $existe            =  $this->catalogo->check_existente_imagen( $data );
         if ( $existe !== TRUE ){






     


                $config_adjunto['upload_path']    = './img/juego/original/';
                $config_adjunto['allowed_types']  = 'jpg|png|gif|jpeg';
                $config_adjunto['max_size']     = '20480';
                $config_adjunto['file_name']    = 'img_'.$data['imagen'];
                $config_adjunto['overwrite']    = true;             

                $this->load->library('upload', $config_adjunto);

                $this->upload->do_upload('archivo_imagen'); 
                $errors = $this->upload->display_errors();

                  //print_r($errors); die;
                
                //if (!(($errors=='') || ($errors=='<p>No ha seleccionado ningún archivo para subir</p>'))) {
                if ($errors=='<p>No ha seleccionado ningún archivo para subir</p>') {  
                  echo $this->upload->display_errors('<span class="error">', '</span>');
                  //echo '<span class="error"><b>E01</b> - La nueva imagen no pudo ser agregada</span>';
                  //echo validation_errors('<span class="error">','</span>');
                } else {
                    if ($errors=='') 
                    {
                      $data['archivo_imagen'] = $this->upload->data();
                    } 

                    if  (isset($data['archivo_imagen'])) {
                       //este es el thumbnail 

                        /////////////THUMBNAIL///////////////////
                         $this->load->library('image_lib');

                         //este es el thumbnail 
                         $config1 = array(
                            'image_library' => 'GD2',
                            'source_image' => $data['archivo_imagen']['full_path'],
                            'new_image' => './img/juego/',
                            //'create_thumb' => TRUE,
                            'maintain_ratio' => true,
                           // 'width' => 150,
                           // 'height' => 147
                          );


                          $this->image_lib->clear();
                          $this->image_lib->initialize($config1);
                          //$this->image_lib->resize();
                          $this->image_lib->crop();

                          /////////////fin del THUMBNAIL///////////////////

                    }    
 








              $data         =   $this->security->xss_clean($data);  
              $guardar            = $this->catalogo->anadir_imagen( $data );
              if ( $guardar !== FALSE ){
                echo true;
              } else {
                echo '<span class="error"><b>E01</b> - La nueva imagen no pudo ser agregada</span>';
              }

               }  


         } else {
            echo '<span class="error"><b>E01</b> - La composición que desea agregar ya existe. No es posible agregar dos imagenes iguales.</span>';
         }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_imagen( $id = '' ){
     
      if($this->session->userdata('session') === TRUE ){
            $id_perfil=$this->session->userdata('id_perfil');

            $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
            if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                  $coleccion_id_operaciones = array();
             }   


              $data['id']  = $id;

              $data['tabla'] = "catalogo_imagenes";
              $data['total_archivos']  = $this->catalogo->total_archivos( $data );
              $data['imagen'] = $this->catalogo->coger_imagen($data);


            switch ($id_perfil) {    
              case 1:
                    
                    if ( $data['imagen'] !== FALSE ){
                        $this->load->view( 'catalogos/imagenes/editar_imagen', $data );
                    } else {
                          redirect('');
                    }               
                break;
              case 2:
              case 3:
              case 4:
                   if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                      
                      if ( $data['imagen'] !== FALSE ){
                          $this->load->view( 'catalogos/imagenes/editar_imagen', $data );
                      } else {
                            redirect('');
                      }       
                   }   
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


function validacion_edicion_imagen(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'imagen', 'imagen', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['imagen']         = $this->input->post('imagen');
          $data['puntos']         = $this->input->post('puntos');
          
          //$existe            =  $this->catalogo->check_existente_imagen( $data );
          if ( TRUE ){ //( $existe !== TRUE ){



     


                $config_adjunto['upload_path']    = './img/juego/original/';
                $config_adjunto['allowed_types']  = 'jpg|png|gif|jpeg';
                $config_adjunto['max_size']     = '20480';
                $config_adjunto['file_name']    = 'img_'.$data['imagen'];
                $config_adjunto['overwrite']    = true;             

                $this->load->library('upload', $config_adjunto);

                $this->upload->do_upload('archivo_imagen'); 
                $errors = $this->upload->display_errors();

                  //print_r($errors); die;
                
                //if (!(($errors=='') || ($errors=='<p>No ha seleccionado ningún archivo para subir</p>'))) {
                if ($errors=='<p>No ha seleccionado ningún archivo para subir</p>') {  
                  echo $this->upload->display_errors('<span class="error">', '</span>');
                  //echo '<span class="error"><b>E01</b> - La nueva imagen no pudo ser agregada</span>';
                  //echo validation_errors('<span class="error">','</span>');
                } else {
                    if ($errors=='') 
                    {
                      $data['archivo_imagen'] = $this->upload->data();
                    } 

                    if  (isset($data['archivo_imagen'])) {
                       //este es el thumbnail 

                        /////////////THUMBNAIL///////////////////
                         $this->load->library('image_lib');

                         //este es el thumbnail 
                         $config1 = array(
                            'image_library' => 'GD2',
                            'source_image' => $data['archivo_imagen']['full_path'],
                            'new_image' => './img/juego/',
                            //'create_thumb' => TRUE,
                            'maintain_ratio' => true,
                           // 'width' => 150,
                           // 'height' => 147
                          );


                          $this->image_lib->clear();
                          $this->image_lib->initialize($config1);
                          //$this->image_lib->resize();
                          $this->image_lib->crop();

                          /////////////fin del THUMBNAIL///////////////////

                    }    
 



            $data               = $this->security->xss_clean($data);  
            $guardar            = $this->catalogo->editar_imagen( $data );

            if ( $guardar !== FALSE ){
              echo true;

            } else {
              echo '<span class="error"><b>E01</b> - La nueva  imagen no pudo ser agregada</span>';
            }

         }   
         } else {
            echo '<span class="error"><b>E01</b> - La composición que desea agregar ya existe. No es posible agregar dos imagenes iguales.</span>';
         }  


      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_imagen($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['nombrecompleto']   = base64_decode($nombrecompleto);

      switch ($id_perfil) {    
        case 1:
            $data['id']         = $id;
            $this->load->view( 'catalogos/imagenes/eliminar_imagen', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $data['id']         = $id;
                $this->load->view( 'catalogos/imagenes/eliminar_imagen', $data );
             }   
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


  function validar_eliminar_imagen(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_imagen(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la imagen</span>';
    }
  }   
   


//***********************litrajes**********************************//

  

  
  public function listado_litrajes(){
  

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
            $this->load->view( 'catalogos/litrajes');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'catalogos/litrajes');
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

 
 public function procesando_cat_litrajes(){

    $data=$_POST;
    $busqueda = $this->catalogo->buscador_cat_litrajes($data);
    echo $busqueda;
  } 

    // crear
  function nuevo_litraje(){
if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/litrajes/nuevo_litraje');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $this->load->view( 'catalogos/litrajes/nuevo_litraje');
              }   
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

  function validar_nuevo_litraje(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('litraje', 'litraje', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['litraje']   = $this->input->post('litraje');

         $existe            =  $this->catalogo->check_existente_litraje( $data );
         if ( $existe !== TRUE ){

              $data         =   $this->security->xss_clean($data);  
              $guardar            = $this->catalogo->anadir_litraje( $data );
              if ( $guardar !== FALSE ){
                echo true;
              } else {
                echo '<span class="error"><b>E01</b> - La nueva litraje no pudo ser agregada</span>';
              }
         } else {
            echo '<span class="error"><b>E01</b> - La composición que desea agregar ya existe. No es posible agregar dos litrajes iguales.</span>';
         }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_litraje( $id = '' ){
     
      if($this->session->userdata('session') === TRUE ){
            $id_perfil=$this->session->userdata('id_perfil');

            $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
            if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                  $coleccion_id_operaciones = array();
             }   


              $data['id']  = $id;
            switch ($id_perfil) {    
              case 1:
                    $data['litraje'] = $this->catalogo->coger_litraje($data);
                    if ( $data['litraje'] !== FALSE ){
                        $this->load->view( 'catalogos/litrajes/editar_litraje', $data );
                    } else {
                          redirect('');
                    }               
                break;
              case 2:
              case 3:
              case 4:
                   if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                      $data['litraje'] = $this->catalogo->coger_litraje($data);
                      if ( $data['litraje'] !== FALSE ){
                          $this->load->view( 'catalogos/litrajes/editar_litraje', $data );
                      } else {
                            redirect('');
                      }       
                   }   
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


function validacion_edicion_litraje(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'litraje', 'litraje', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['litraje']         = $this->input->post('litraje');
          
          $existe            =  $this->catalogo->check_existente_litraje( $data );
          if ( $existe !== TRUE ){

            $data               = $this->security->xss_clean($data);  
            $guardar            = $this->catalogo->editar_litraje( $data );

            if ( $guardar !== FALSE ){
              echo true;

            } else {
              echo '<span class="error"><b>E01</b> - La nueva  litraje no pudo ser agregada</span>';
            }

         } else {
            echo '<span class="error"><b>E01</b> - La composición que desea agregar ya existe. No es posible agregar dos litrajes iguales.</span>';
         }  


      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_litraje($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['nombrecompleto']   = base64_decode($nombrecompleto);

      switch ($id_perfil) {    
        case 1:
            $data['id']         = $id;
            $this->load->view( 'catalogos/litrajes/eliminar_litraje', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $data['id']         = $id;
                $this->load->view( 'catalogos/litrajes/eliminar_litraje', $data );
             }   
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


  function validar_eliminar_litraje(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_litraje(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la litraje</span>';
    }
  }   
   


//***********************estados**********************************//

  

  
  public function listado_estados(){
  

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
            $this->load->view( 'catalogos/estados');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'catalogos/estados');
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

 
 public function procesando_cat_estados(){

    $data=$_POST;
    $busqueda = $this->catalogo->buscador_cat_estados($data);
    echo $busqueda;
  } 

    // crear
  function nuevo_estado(){
if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/estados/nuevo_estado');
          break;
        case 2:
        case 3:
        case 4:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $this->load->view( 'catalogos/estados/nuevo_estado');
              }   
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

  function validar_nuevo_estado(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('estado', 'estado', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['estado']   = $this->input->post('estado');

         $existe            =  $this->catalogo->check_existente_estado( $data );
         if ( $existe !== TRUE ){

              $data         =   $this->security->xss_clean($data);  
              $guardar            = $this->catalogo->anadir_estado( $data );
              if ( $guardar !== FALSE ){
                echo true;
              } else {
                echo '<span class="error"><b>E01</b> - La nueva estado no pudo ser agregada</span>';
              }
         } else {
            echo '<span class="error"><b>E01</b> - La composición que desea agregar ya existe. No es posible agregar dos estados iguales.</span>';
         }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_estado( $id = '' ){
     
      if($this->session->userdata('session') === TRUE ){
            $id_perfil=$this->session->userdata('id_perfil');

            $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
            if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                  $coleccion_id_operaciones = array();
             }   


              $data['id']  = $id;
            switch ($id_perfil) {    
              case 1:
                    $data['estado'] = $this->catalogo->coger_estado($data);
                    if ( $data['estado'] !== FALSE ){
                        $this->load->view( 'catalogos/estados/editar_estado', $data );
                    } else {
                          redirect('');
                    }               
                break;
              case 2:
              case 3:
              case 4:
                   if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                      $data['estado'] = $this->catalogo->coger_estado($data);
                      if ( $data['estado'] !== FALSE ){
                          $this->load->view( 'catalogos/estados/editar_estado', $data );
                      } else {
                            redirect('');
                      }       
                   }   
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


function validacion_edicion_estado(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'estado', 'estado', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['estado']         = $this->input->post('estado');
          
          $existe            =  $this->catalogo->check_existente_estado( $data );
          if ( $existe !== TRUE ){

            $data               = $this->security->xss_clean($data);  
            $guardar            = $this->catalogo->editar_estado( $data );

            if ( $guardar !== FALSE ){
              echo true;

            } else {
              echo '<span class="error"><b>E01</b> - La nueva  estado no pudo ser agregada</span>';
            }

         } else {
            echo '<span class="error"><b>E01</b> - La composición que desea agregar ya existe. No es posible agregar dos estados iguales.</span>';
         }  


      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_estado($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['nombrecompleto']   = base64_decode($nombrecompleto);

      switch ($id_perfil) {    
        case 1:
            $data['id']         = $id;
            $this->load->view( 'catalogos/estados/eliminar_estado', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $data['id']         = $id;
                $this->load->view( 'catalogos/estados/eliminar_estado', $data );
             }   
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


  function validar_eliminar_estado(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_estado(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la estado</span>';
    }
  }   
   


//***********************configuraciones **********************************//





  public function listado_configuraciones(){
  

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
              $this->load->view( 'catalogos/configuraciones');            
          break;
        case 2:
        case 3:
        case 4:
                if ( ( $id_perfil == 1 ) && ($this->session->userdata('especial') ==1 ) ) {
                  $this->load->view( 'catalogos/configuraciones');
                } else {
                        redirect('');
                } 
          break;


        default:  
          redirect('');
          break;
      }



    }    
    
  }

   public function procesando_cat_configuraciones(){
    $data=$_POST;
    $busqueda = $this->catalogo->buscador_cat_configuraciones($data);
    echo $busqueda;
  } 


    // crear
  function nuevo_configuracion(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   

          switch ($id_perfil) {    
            case 1:
                if ( ( $id_perfil == 1 ) && ($this->session->userdata('especial') ==1 ) ) {
                  $this->load->view( 'catalogos/configuraciones/nuevo_configuracion');
                } else {
                        redirect('');
                }       
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

  function validar_nuevo_configuracion(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('configuracion', 'configuracion', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['configuracion']   = $this->input->post('configuracion');
          $data['valor']         = $this->input->post('valor');
          $data['activo']         = $this->input->post('activo');

          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->anadir_configuracion( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - La nueva  configuracion no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_configuracion( $id = '' ){

if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = $id;

      switch ($id_perfil) {    
        case 1:
              if ( ( $id_perfil == 1 ) && ($this->session->userdata('especial') ==1 ) ) {
                  $data['configuracion'] = $this->catalogo->coger_configuracion($data);
                  if ( $data['configuracion'] !== FALSE ){
                      $this->load->view( 'catalogos/configuraciones/editar_configuracion', $data );
                  } else {
                        redirect('');
                  }       
                } else {
                      redirect('');
                }       

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


function validacion_edicion_configuracion(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'configuracion', 'configuracion', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['configuracion']         = $this->input->post('configuracion');
          $data['valor']         = $this->input->post('valor');
          $data['activo']         = $this->input->post('activo');

          $data               = $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->editar_configuracion( $data );

          if ( $guardar !== FALSE ){
            echo true;

          } else {
            echo '<span class="error"><b>E01</b> - La nueva  configuracion no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_configuracion($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['nombrecompleto']   = base64_decode($nombrecompleto);
      $data['id']         = $id;
      
      switch ($id_perfil) {    
        case 1:            
              if ( ( $id_perfil == 1 ) && ($this->session->userdata('especial') ==1 ) ) {
                $this->load->view( 'catalogos/configuraciones/eliminar_configuracion', $data );
              } else {
                      redirect('');
              }       

                    
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


  function validar_eliminar_configuracion(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_configuracion(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la configuracion</span>';
    }
  }   
  









/////////////////validaciones/////////////////////////////////////////  


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
      $this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.');
      return FALSE;
    }
  }

  public function valid_email($str)
  {
    return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
  } 


}

/* End of file nucleo.php */
/* Location: ./app/controllers/nucleo.php */
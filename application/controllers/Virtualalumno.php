<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Virtualalumno extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('mvirtualalumno');
        $this->load->model('mvirtual');
        $this->load->model('mcargasubseccion');

    }

    public function vw_virtual_archivos($idmat,$iddet)
    {
        $idmat=base64url_decode($idmat);
        $iddet=base64url_decode($iddet);
        $fila=$this->mvirtualalumno->m_get_detalle_x_tarea(array($idmat,$iddet));

        if (isset($fila->nombre)){
            $fileName = $fila->link;
            $filePath = 'upload/'.$fileName;
            $partes_ruta = pathinfo($fila->nombre);

            $nombre=url_clear($partes_ruta['filename']).".".$partes_ruta['extension'];
            if(!empty($fileName) && file_exists($filePath)){
                // Define headers
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Type: $fila->tipo");
                header("Content-Disposition: attachment; filename=$nombre");
                //header("Content-Type: application/zip");$fila->nombre
                
                header("Content-Transfer-Encoding: binary");
                //header("Content-Disposition: attachment; filename=$nombre;");
                //Read the file
                readfile($filePath);
                exit;
            }
            else{
                header("Location: ".base_url()."errors/no-encontrado");
            }
        }
        else{
            header("Location: ".base_url()."errors/no-encontrado");
        }
    }

    
    
    public function vw_cursos_visibles_x_carnet(){
        $ahead= array('page_title' =>'Mis cursos | IESTWEB'  );
        $asidebar= array('menu_padre' =>'aluvirtual');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);
        $coddocente=$_SESSION['userActivo']->usuario;
        $mcursos= $this->mvirtualalumno->m_get_cursos_visibles_x_carnet(array($coddocente));
        $arraymc['matriculas']=array();
        foreach ($mcursos as $key => $mc) {
            $arraymc['matriculas'] = $this->mvirtualalumno->m_get_matricula_x_carne_periodo(array($coddocente,$mc->codperiodo));
        }
        $arraymc['miscursos'] =$mcursos;
        $this->load->view('virtual/alumno/vw_miscursos',$arraymc);
        $this->load->view('footer');
    }

    public function vw_virtual($codcarga,$division,$codmiembro)
    {
        $codcarga=base64url_decode($codcarga);
        $division=base64url_decode($division);
        if ($_SESSION['userActivo']->tipo=="AL"){
            $this->load->model('mmiembros');
            $codm = $this->mmiembros->m_comprobar_miembro_codigo(array($codcarga,$division,base64url_decode($codmiembro)));
            
            if ($codm=="0"){
                $ahead= array('page_title' =>'No autorizado | IESTWEB'  );
                $asidebar= array('menu_padre' =>'aluvirtual');
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $this->load->view('sidebar',$asidebar);
                $this->load->view('errors/sin-permisos');
                $this->load->view('footer');
            }
            else{

                $ahead= array('page_title' =>'Admisión | IESTWEB'  );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $arraymc['varchivos'] =$this->mvirtual->m_get_detalles(array($codcarga,$division));

                $arsb['menu_padre']='alaulavirtual';
                
                $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
                $arraymc['vcodmiembro'] = $codmiembro;
                $arraymc['material'] = $this->mvirtual->m_get_materiales(array($codcarga,$division));
                $this->load->view('sidebar_alumno',$arsb);
                $this->load->view('virtual/alumno/vw_aula', $arraymc);
                $this->load->view('footer');
                 }
       
        }
        else{
            $ahead= array('page_title' =>'No autorizado | IESTWEB'  );
            $asidebar= array('menu_padre' =>'aluvirtual');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar',$asidebar);
            $this->load->view('errors/sin-permisos-personalizado', array('mensaje' => 'Enlace habilitado solo para estudiantes' ));
            $this->load->view('footer');
        }
    }



    //funciones de ynga REVISAR

    public function vw_foro_virtual($codcarga, $division, $codvirtual,$codmiembro){

        $codcarga=base64url_decode($codcarga);
        $division=base64url_decode($division);
        if ($_SESSION['userActivo']->tipo=="AL"){
            $this->load->model('mmiembros');
            $codm = $this->mmiembros->m_comprobar_miembro_codigo(array($codcarga,$division,base64url_decode($codmiembro)));
            
            if ($codm=="0"){
                $ahead= array('page_title' =>'No autorizado | IESTWEB'  );
                $asidebar= array('menu_padre' =>'aluvirtual');
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $this->load->view('sidebar',$asidebar);
                $this->load->view('errors/sin-permisos');
                $this->load->view('footer');
            }
            else{
                $ahead= array('page_title' =>'Foro Virtual | IESTWEB'  );
                $asidebar= array('menu_padre' =>'aluvirtual');
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                //$this->load->view('sidebar',$asidebar);
                
                $codvirtual = base64url_decode($codvirtual);
                $arraymc['miembro'] = $codmiembro;
                //$codmiembro = base64url_decode($codmiembro);
                //$codalumno = $_SESSION['userActivo']->usuario;
                $arsb['vcarga']=$codcarga;
                $arsb['vdivision']=$division;
                $arsb['menu_padre']='docconfiguracion';
                $arraymc['mat'] = $this->mvirtual->m_get_material(array($codvirtual));
                $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codvirtual));
                $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
                
                $arraymc['comment'] = $this->mvirtual->lstcomentariosxforo(array($codvirtual));
                //$arraymc['commentwo'] = $this->mvirtual->lstcomentariosxforo_respuesta(array($codvirtual));
                $this->load->view('sidebar',array('vcarga'=>$codcarga,'vdivision'=>$division,'menu_padre' =>'aluvirtual'));

                $this->load->view('virtual/alumno/vw_aula_foro', $arraymc);
                $this->load->view('footer');
            }
       
        }
        else{
            $ahead= array('page_title' =>'No autorizado | IESTWEB'  );
            $asidebar= array('menu_padre' =>'aluvirtual');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar',$asidebar);
            $this->load->view('errors/sin-permisos-personalizado', array('mensaje' => 'Enlace habilitado solo para estudiantes' ));
            $this->load->view('footer');
        }

    }

    public function uploadimages(){
        if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(Rand(100, 200));
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . $ext[1];
                $destination = 'upload/foro_upload/' . $filename; //cambiar este directorio
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                echo 'upload/foro_upload/' . $filename;
            } else {
              echo  $message = 'Se ha producido el siguiente error:  '.$_FILES['file']['error'];
            }
        }
    }

    public function delete_file()
    {
        $src = $this->input->post('src'); 
        // $src = $_POST['src']; 
        $file_name = str_replace(base_url(), '', $src); 
        
        if(unlink($file_name)) { 
            echo 'imagen eliminada correctamente'; 
        }
    }

    public function fn_insert_comentario()
    {
        $this->form_validation->set_message('required', '*%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
        
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            
            $this->form_validation->set_rules('codigosubmi','codigo miembro','trim|required');
            $this->form_validation->set_rules('codigoforo','codigo foro','trim|required');
            $this->form_validation->set_rules('codigopadre','codigo padre','trim|required');
            $this->form_validation->set_rules('txtrespuesta','comentario','trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $dataex['errimg'] = 'No hay archivo seleccionado';
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            }
            else
            {
                $dataex['status'] =FALSE;
                $codigosubmi= base64url_decode($this->input->post('codigosubmi'));
                $codigoforo = $this->input->post('codigoforo');
                $codigopadre=$this->input->post('codigopadre');
                $txtrespuesta=$this->input->post('txtrespuesta');
                $comentador=$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres;
                $foto=$_SESSION['userActivo']->foto;
                $rpta=$this->mvirtual->m_insert_comentario(array($codigosubmi, $codigoforo, $codigopadre, $txtrespuesta,$comentador,$foto));
                if ($rpta > 0){
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="Su respuesta ha sido registrada correctamente";
                    
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


    public function uploadfile()
    {
        $dataex['link']="";
        $fileTmpLoc   = $_FILES["file"]["tmp_name"]; // File in the PHP tmp folder
        $fileType     = $_FILES["file"]["type"]; // The type of file it is
        $fileSize     = $_FILES["file"]["size"]; // File size in bytes
        $fileErrorMsg = $_FILES["file"]["error"]; // 0 for false... and 1 for true
        $fileNameExt  = $_FILES["file"]["name"];
        $ext          = explode(".", $fileNameExt);
        $extension    = end($ext);
        $NewfileName  = "al".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . $_SESSION['userActivo']->codpersona;
        $arc_temp = pathinfo($fileTmpLoc);

        
        $nomb_temp=url_clear($arc_temp['filename']);
        $nro_rand=rand(0,9);
        $link=$NewfileName.$nomb_temp.$nro_rand.".".$extension;
        $dataex['link'] = "";
        $dataex['temp'] = "";
        if (move_uploaded_file($fileTmpLoc, "upload/$link")) {
            $dataex['link'] = $link;
            $dataex['temp'] = $fileTmpLoc;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    

}
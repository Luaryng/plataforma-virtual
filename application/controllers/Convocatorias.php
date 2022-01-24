<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';

class Convocatorias extends Error_views{

	function __construct(){
		parent::__construct();
		$this->load->helper("url");
        $this->load->model('mconvocatorias');
        $this->load->model('mconvocatorias_tipo');
        $this->load->model('mauditoria');
		
	}

    public function vw_convocatoria_archivos($id)
    {
        $id=base64url_decode($id);
        $fila=$this->mconvocatorias->m_get_con_archivosxcodigo(array($id));
        // var_dump($fila);
        if (isset($fila->ruta)){
            $fileName = $fila->ruta;
            $filePath = 'upload/convocatorias/'.$fileName;
            $partes_ruta = pathinfo($fila->ruta);

            $nombre=url_clear($fila->titulo).".".$partes_ruta['extension'];
            if(!empty($fileName) && file_exists($filePath)){
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$nombre");
                header("Content-Type: fila->tipo");
                header("Content-Transfer-Encoding: binary");
                readfile($filePath);
                exit;
            }
            else{
                header("Location: ".base_url()."no-encontrado");
            }
        }
        else{
            header("Location: ".base_url()."no-encontrado2");
        } 
    }

    public function vw_principal()
    {
        if (getPermitido("77")=='SI'){
            $tipo=$this->input->get('tp');
            $ahead= array('page_title' =>'Convocatorias | ERP'  );
            $asidebar= array('menu_padre' =>'convocatorias', 'menu_hijo' =>'convocatoria');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar_portal',$asidebar);
            $items = $this->mconvocatorias->m_get_items_conv();
            $this->load->view('convocatorias/index', array('items' => $items ));
            $this->load->view('footer');
        }
        else{
             $this->vwh_nopermitido("NO AUTORIZADO - ERP");
        }
    }

    public function vw_agregar()
    {
        if (getPermitido("78")=='SI'){
            $ahead= array('page_title' =>'Convocatorias - Agregar | ERP'  );
            $asidebar= array('menu_padre' =>'convocatorias', 'menu_hijo' =>'convocatoria');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar_portal',$asidebar);
            $file['varchivos'] =array();
            $file['tipos'] = $this->mconvocatorias_tipo->m_get_items_convt_Activo();
            $this->load->view('convocatorias/vw_convocatoria_add', $file);
            $this->load->view('footer');
        }
        else{
             $this->vwh_nopermitido("NO AUTORIZADO - ERP");
        }
    }

    public function vw_editar($id)
    {
        
        if (getPermitido("79")=='SI'){
            $id=base64url_decode($id);
            $ahead= array('page_title' =>'Convocatorias - Editar | ERP'  );
            $asidebar= array('menu_padre' =>'convocatorias', 'menu_hijo' =>'convocatoria');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar_portal',$asidebar);
            $fila['varchivos'] =array();
            $fila['convocatoria'] = $this->mconvocatorias->m_get_items_con_id(array($id));
            $fila['varchivos'] = $this->mconvocatorias->m_get_con_archivos(array($id));
            $fila['tipos'] = $this->mconvocatorias_tipo->m_get_items_convt_Activo();
            $this->load->view('convocatorias/vw_convocatoria_add', $fila);
            $this->load->view('footer');
        }
        else{
             $this->vwh_nopermitido("NO AUTORIZADO - ERP");
        }
    }

    public function fn_insert_update(){
        $dataex['status'] = false;
        $dataex['msg']    = '¿Qué intentas?';
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $dataex['status'] = false;
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('vw_pw_bt_ad_fictxttitulo', 'Titulo', 'trim|required');
                $this->form_validation->set_rules('vw_pw_bt_ad_fictxttipo', 'Tipo', 'trim|required');
                $this->form_validation->set_rules('vw_pw_bt_ad_fictxtanio', 'Año', 'trim|required');
                $this->form_validation->set_rules('vw_pw_bt_ad_fictxtdesc', 'Detalle', 'trim|required');
                $this->form_validation->set_rules('vw_pw_bt_ad_fictxtestado', 'Estado', 'trim|required');
                $this->form_validation->set_rules('vw_pw_bt_ad_fictxtpublicado', 'Fecha', 'trim|required');

                $errors = array();
                $dataex['errors']= array();
                if ($this->form_validation->run() == false) {
                    //$dataex['msg'] = validation_errors();
                    $dataex['msg'] = "Existe error en los campos";
                    
                    foreach ($this->input->post() as $key => $value){
                        $errors[$key] = form_error($key);
                    }
                    $dataex['errors'] = array_filter($errors);
                } 
                else {
                    
                    $errors=array();
                    $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                    $vcodigo = $this->input->post('vw_pw_bt_ad_fictxtcodigo');
                    $vtitulo = $this->input->post('vw_pw_bt_ad_fictxttitulo');
                    $vtipo = $this->input->post('vw_pw_bt_ad_fictxttipo');
                    $vanio = $this->input->post('vw_pw_bt_ad_fictxtanio');
                    $vdetalle = $this->input->post('vw_pw_bt_ad_fictxtdesc');
                    $vestado = $this->input->post('vw_pw_bt_ad_fictxtestado');
                    $vpublicado = $this->input->post('vw_pw_bt_ad_fictxtpublicado');
                    $resumen = substr(strip_tags($vdetalle), 0, 150);

                    $link="";
                    $name="";
                    $peso="";
                    $tipofile="";
                    $vid = 0;
                    $validar=false;

                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    
                    $rpta=0;
                    
                    if ($vcodigo=="0"){

                        $rpta = $this->mconvocatorias->m_insert_conv(array($vtitulo, $vdetalle, $resumen, $vtipo, $vanio, $vestado, $vpublicado));
                        $accion = "INSERTAR";
                        // $dataex['msg2'] = $rpta;
                        $vid = $rpta->nid;
                        $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando una convocatoria en la tabla TB_CONVOCATORIAS COD.".$rpta->nid;
                    }
                    else{
                        $vid = base64url_decode($vcodigo);
                        $rpta = $this->mconvocatorias->m_update_conv(array($vid,$vtitulo, $vdetalle, $resumen, $vtipo, $vanio, $vestado, $vpublicado));
                        $accion = "EDITAR";
                        // $dataex['msg2'] = $rpta;
                        
                        $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una convocatoria en la tabla TB_CONVOCATORIAS COD.".$vid;
                    }

                    if ($rpta->salida==1){
                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));

                        $data = json_decode($_POST['vw_mpc_archivos']);

                        $pathtodir =  getcwd() ; 

                        $filesnoup=array();

                        foreach ($data as $value) {
                            // if ($value[4]==0){ //si no hay id de detalle
                                if (trim($value[0])==""){
                                    // $filesnoup[]=$value[1];
                                }
                                else{
                                    if (file_exists ("upload/convocatorias/".$value[0])){
                                        $rpta2 = $this->mconvocatorias->m_insert_detalle_conv(array($vid,$value[4],$value[1],$value[0],$value[2],$value[3]));
                                        if ($rpta2->salida==1) {
                                            $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando un archivo en la tabla TB_CONVOCATORIA_DETALLE COD.".$rpta2->nid;
                                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, "INSERTAR", $contenido, $sede));
                                            
                                        }
                                    }else{
                                        $filesnoup[]=$value[1];
                                    }
                                }    
                            // }
                        }
                        $dataex['status'] =TRUE;
                        $dataex['msg'] ="Datos registrados correctamente";
                        $dataex['redirect'] =base_url()."portal-web/convocatorias";
                            
                    }

                    $dataex['errors'] = $errors;
                }
            }
            else{
                $dataex['msg']    = 'No tienes autorización';
            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_delete(){
        $dataex['status'] = false;
        $dataex['msg']    = '¿Qué intentas?';
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('codigo', 'Codigo', 'trim|required');
                
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } else {
                    $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                    $codindicador    = base64url_decode($this->input->post('codigo'));
                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    $accion = "ELIMINAR";
                    
                    $rpta=0;
                    $data=array($codindicador);

                    //ELIMINAR DETALLE
                    
                    $varchivos = $this->mconvocatorias->m_get_con_archivos($data);
                    // $dataex['msg2'] = $varchivos;
                    $ndetalles = count($varchivos);
                    foreach ($varchivos as $key => $archivo) {
                        $contenido2 = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un archivo en la tabla TB_CONVOCATORIA_DETALLE COD.".$archivo->coddetalle;
                        $rptadt = $this->mconvocatorias->m_delete_detalle($archivo->coddetalle);
                        if ($rptadt == 1){
                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido2, $sede));
                            $pathtodir =  getcwd() ; 
                            unlink($pathtodir."/upload/convocatorias/".$archivo->ruta );
                            $ndetalles--;    
                        }
                    }
                    if ($ndetalles==0){
                        $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una convocatoria en la tabla TB_CONVOCATORIAS COD.".$codindicador;

                        //ELIMINAR CONVOCATORIA
                        $rpdeleteconvocatoria = $this->mconvocatorias->m_delete_conv($data);
                        if ($rpdeleteconvocatoria > 0){
                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                            $dataex['status'] =true;
                        }
                        
                        
                    }
                    

                }
            }
            else{
                $dataex['msg']    = 'No estas autorizado';
            }
        }
        $dataex['destino'] = $urlRef;
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_upload_file_conv(){
        
        if ($_FILES['vw_mpc_file']['name']) {
            if (!$_FILES['vw_mpc_file']['error']) {
                $name = $_FILES['vw_mpc_file']['name'];//md5(Rand(100, 200));
                $ext = explode('.', $_FILES['vw_mpc_file']['name']);
                $ult=count($ext);
                $nro_rand=rand(0,9);
                $NewfileName  = "cvt_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$_SESSION['userActivo']->codpersona;
                $filename = $NewfileName.".".$ext[$ult-1];//. '.' . $ext[1];
                $directorio = "./upload/convocatorias";
                if (!file_exists($directorio)) {

                    mkdir($directorio, 0755);

                }
                $destination = './upload/convocatorias/' .$filename ; //change this directory
                $location = $_FILES["vw_mpc_file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                
                $dataex['msg'] = 'Archivo subido correctamente';
                $dataex['link'] = $filename;

                
            }
            else {
                $dataex['msg'] = 'Se ha producido el siguiente error:  '.$_FILES['vw_mpc_file']['error'];
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }
   

    public function fn_delete_file(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $dataex['status'] = false;
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
              
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $codindicador    = $this->input->post('coddetalle');
                if ("0" !==$codindicador ){
                    $codindicador    = base64url_decode($this->input->post('coddetalle'));
                    $link    = $this->input->post('link');
                    $rpta=0;
                    $data=array($codindicador);
                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    $accion = "ELIMINAR";
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un archivo en la tabla TB_CONVOCATORIA_DETALLE COD.".$codindicador;
                    if ($codindicador>0){
                        $rpta = $this->mconvocatorias->m_delete_detalle($data);
                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                        $pathtodir =  getcwd() ; 
                        unlink($pathtodir."/upload/convocatorias/".$link );
                        $dataex['status'] =true;
                    }
                }
                else{
                    if ("" !== $this->input->post('link')){
                        $link    = $this->input->post('link');
                        $pathtodir =  getcwd() ; 
                        unlink($pathtodir."/upload/convocatorias/".$link );
                        $dataex['status'] =true;
                    }
                    else{
                        $dataex['status'] =true;
                    }
                }
            }
            else{
                $dataex['msg']    = 'No estas autorizado';
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
        
    }


}
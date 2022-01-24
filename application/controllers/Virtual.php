<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Virtual extends Error_views{
	function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('mvirtual');
        $this->load->model('mauditoria');
		
	}

    public function vw_virtual($codcarga,$division)
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $this->load->model('mcargasubseccion');
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            if (isset($arraymc['curso']->codcarga)){
                 $ahead= array('page_title' =>'Aula Virtual | '.$arraymc['curso']->unidad  );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $arraymc['varchivos'] =$this->mvirtual->m_get_detalles(array($codcarga,$division));
                $arsb['vcarga']=$codcarga;
                $arsb['vdivision']=$division;
                $arsb['menu_padre']='docconfiguracion';
                
                $arraymc['material'] = $this->mvirtual->m_get_materiales(array($codcarga,$division));
                $this->load->view('docentes/sidebar_curso',array('vcarga'=>$codcarga,'vdivision'=>$division));
                $this->load->view('virtual/vw_aula', $arraymc);
                $this->load->view('footer');
            }
            else{
                $this->vwh_error_personalizado("Curso no encontrado","CURSO NO ENCONTRADO","El curso que buscas no existe o fue eliminado");
            }
        }
        else{
            $this->vwh_nopermitido("CURSO - NO AUTORIZADO");
        }
    }


    public function fn_get_recursos_calificables()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('division', 'División', 'trim|required');
            $this->form_validation->set_rules('codcarga', 'Carga', 'trim|required');

            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['status'] = true;
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $division64          = $this->input->post('division');
                $codcarga64          = $this->input->post('codcarga');
                $division         = base64url_decode($division64);
                $codcarga         = base64url_decode($codcarga64);
                $materiales= $this->mvirtual->m_get_materiales_calificables(array($codcarga,$division));
                foreach ($materiales as $key => $value) {
                    $materiales[$key]->codigo64=base64url_encode($materiales[$key]->codigo);
                    if ($materiales[$key]->tipo=="V"){
                        $materiales[$key]->tiponombre="Evaluación";
                    }
                    elseif ($materiales[$key]->tipo=="T"){
                        $materiales[$key]->tiponombre="Tarea";
                    }
                    elseif ($materiales[$key]->tipo=="F"){
                        $materiales[$key]->tiponombre="Foro";
                    }
                    
                    $materiales[$key]->codevalhead64=base64url_encode($materiales[$key]->codevalhead);
                }
                $dataex['materiales'] =$materiales;
            }
            
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function fn_update_enlazar_aula_evaluacion()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('codmaterial', 'Material', 'trim|required');
            $this->form_validation->set_rules('codheadeval', 'Encabezado', 'trim|required');

            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['status'] = true;
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $codmaterial64          = $this->input->post('codmaterial');
                $codheadeval64          = $this->input->post('codheadeval');
                $codmaterial         = base64url_decode($codmaterial64);
                if ($codheadeval64 =="---"){
                    $codheadeval         = null;
                }
                else{
                    $codheadeval         = base64url_decode($codheadeval64);
                }
                
                $valor= $this->mvirtual->m_enlazar_update_aula_evaluacion(array($codheadeval,$codmaterial));
                $dataex['status'] =true;
            }
            
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    

    public function vw_foro_virtual($codcarga, $division, $codvirtual){

        if ($_SESSION['userActivo']->tipo != 'AL'){
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $this->load->model('mcargasubseccion');
            $this->load->model('mmiembros');
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            if (isset($arraymc['curso']->codcarga)){
                $ahead= array('page_title' =>'Foro Virtual | IESTWEB'  );
                $asidebar= array('menu_padre' =>'docaulavirtual');
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                
                $codvirtual = base64url_decode($codvirtual);
                $arraymc['miembro'] = "";

                $arsb['vcarga']=$codcarga;
                $arsb['vdivision']=$division;
                $arraymc['miembros'] = $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $arsb['menu_padre']='docconfiguracion';
                $arraymc['mat'] = $this->mvirtual->m_get_material(array($codvirtual));
                $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codvirtual));         
                $arraymc['comment'] = $this->mvirtual->lstcomentariosxforo(array($codvirtual));
                $asidebar['vcarga']=$codcarga;
                $asidebar['vdivision']=$division;
                $this->load->view('docentes/sidebar_curso',$asidebar);

                $this->load->view('virtual/vw_aula_foro', $arraymc);
                $this->load->view('footer');
            }
            else{
                $this->vwh_error_personalizado("Curso no encontrado","CURSO NO ENCONTRADO","El curso que buscas no existe o fue eliminado");
            }
        }
        else{
            $this->vwh_nopermitido("CURSO - NO AUTORIZADO");
        }
    }

    public function vw_virtual_archivos($idmat,$iddet)
    {
        $idmat=base64url_decode($idmat);
        $iddet=base64url_decode($iddet);
        $fila=$this->mvirtual->m_get_detalle(array($idmat,$iddet));

        if (isset($fila->nombre)){
            $fileName = $fila->link;
            $filePath = 'upload/'.$fileName;
            $partes_ruta = pathinfo($fila->nombre);

            $nombre=url_clear($partes_ruta['filename']).".".$partes_ruta['extension'];
            if(!empty($fileName) && file_exists($filePath)){
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$nombre");
                header("Content-Type: $fila->tipo");
                header("Content-Transfer-Encoding: binary");
                readfile($filePath);
                exit;
            }
            else{
                header("Location: ".base_url()."no-encontrado");
            }
        }
        else{
            header("Location: ".base_url()."no-encontrado");
        } 
    }
 

    public function fn_update_title(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
            $this->form_validation->set_rules('vid', 'codigo', 'trim|required');
            $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $nombre          = $this->input->post('nombre');
                $codigo          = $this->input->post('vid');
                $tipo          = $this->input->post('tipo');

                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;
                
                if ($tipo != "E") {
                    $rpta = $this->mvirtual->m_update_virtual_data(array($codigo, $nombre, $tipo));
                }
                
                if ($rpta > 0){
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando titulo de un recurso en la tabla TB_VIRTUAL_MATERIAL COD.".$codigo;
                    $fictxtaccion = 'EDITAR';
                    $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] =true;
                    $dataex['newid'] =$rpta;
                }
            }
            
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function fn_update_files(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
            $this->form_validation->set_rules('vid', 'codigo', 'trim|required');
            $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
            $this->form_validation->set_rules('videta', 'codigo detalle', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $nombre          = $this->input->post('nombre');
                $codigo          = $this->input->post('vid');
                $tipo          = $this->input->post('tipo');
                $iddetalle          = base64url_decode($this->input->post('videta'));

                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando titulo de un archivo en la tabla TB_VIRTUAL_DETALLE COD.".$iddetalle;
                $fictxtaccion = 'EDITAR';
                
                $rpta = $this->mvirtual->m_update_virtual_file(array($iddetalle, $codigo, $nombre));
                
                if ($rpta>0){
                    $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] =true;
                    $dataex['newid'] =$rpta;
                }
            }
            
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function vw_virtual_add_etiqueta($codcarga,$division)
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            $arraymc['vcarga']=$codcarga;
            $arraymc['vdivision']=$division;
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $this->load->model('mcargasubseccion');
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            if (isset($arraymc['curso']->codcarga)){
                $ahead= array('page_title' =>'Aula Virtual - Agregar Recurso | IESTWEB'  );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                
                $tipo=$this->input->get('type');
                $arsb['vcarga']=$codcarga;
                $arsb['vdivision']=$division;
                
                $this->load->model('mcargasubseccion');
                $arraymc['varchivos'] =array();
                
                switch ($tipo) {
                    case 'Y': // YOUTUBE
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_youtube',array(),true);
                        break;
                    case 'L': //URL O LINK
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_link',array(),true);
                        break;
                    case 'A': //ARCHIVO
                        $arraymc['varchivos'] =array();
                        $this->load->helper('aula_virtual_helper');
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_archivo',array(),true);
                        break;
                    case 'V': //EVALUACIÓN
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_evaluacion',array(),true);
                        break;
                    case 'T': //TAREA
                        $arraymc['varchivos'] =array();
                        $this->load->helper('aula_virtual_helper');
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_tarea',array(),true);
                        break;
                    case 'F'://FORO
                        $arraymc['varchivos'] =array();
                        $this->load->helper('aula_virtual_helper');
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_foro',array(),true);
                        break;
                    default:
                         $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_etiqueta',array(),true);
                        break;
                }
                $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));

                $arsb['menu_padre']='docaulavirtual';
                $arsb['vcarga']=$codcarga;
                $arsb['vdivision']=$division;
                $this->load->view('docentes/sidebar_curso',$arsb);

                $this->load->view('virtual/vw_aula_add', $arraymc);
                $this->load->view('footer');
            }
            else{
                $this->vwh_error_personalizado("Curso no encontrado","CURSO NO ENCONTRADO","El curso que buscas no existe o fue eliminado");
            }
        }
        else{
            $this->vwh_nopermitido("CURSO - NO AUTORIZADO");
        }
    }

    public function vw_virtual_edit_etiqueta($codcarga,$division,$codmaterial)
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            $arraymc['vcarga']=$codcarga;
            $arraymc['vdivision']=$division;
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $this->load->model('mcargasubseccion');
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            if (isset($arraymc['curso']->codcarga)){
                $ahead= array('page_title' =>'Aula Virtual | ERP'  );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $codmaterial=base64url_decode($codmaterial);
                $tipo=$this->input->get('type');
                $this->load->model('mcargasubseccion');
                $arraymt['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
                $arraymc['varchivos'] =array();
                switch ($tipo) {
                    case 'Y':
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_youtube',$arraymt,true);
                        break;
                    case 'A':
                        $this->load->helper('aula_virtual_helper');
                        $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_archivo',$arraymt,true);
                        break;
                    case 'T':
                        $this->load->helper('aula_virtual_helper');
                        $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_tarea',$arraymt,true);
                        break;
                     case 'F':
                        $this->load->helper('aula_virtual_helper');
                        $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_foro',$arraymt,true);
                        break;
                    case 'L':
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_link',$arraymt,true);
                        break;
                    case 'V':
                        $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_evaluacion',$arraymt,true);
                        break;
                    default:
                         $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_etiqueta',$arraymt,true);
                        break;
                }
                $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
                
                $arsb['menu_padre']='docaulavirtual';
                $arsb['vcarga']=$codcarga;
                $arsb['vdivision']=$division;
                $this->load->view('docentes/sidebar_curso',$arsb);

                $this->load->view('virtual/vw_aula_add', $arraymc);
                $this->load->view('footer');
            }
            else{
                $this->vwh_error_personalizado("Curso no encontrado","CURSO NO ENCONTRADO","El curso que buscas no existe o fue eliminado");
            }
        }
        else{
            $this->vwh_nopermitido("CURSO - NO AUTORIZADO");
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

                $this->form_validation->set_rules('vdivision', 'División', 'trim|required');
                $this->form_validation->set_rules('vidcurso', 'Carga', 'trim|required');
                $this->form_validation->set_rules('vtipo', 'Tipo', 'trim|required');

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
                     //@vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion
                    $errors=array();
                    $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                    $vdivision=$this->input->post('vdivision');
                    $vidcurso=$this->input->post('vidcurso');

                    $vidcurso=base64url_decode($vidcurso);
                    $vdivision=base64url_decode($vdivision);
                    $vnombre          = null;
                    $vtipo          = "E";
                    $vidpadre          = 0;
                    $vlink          = null;
                    $vdetalle          = null;
                    $vorden          = 1;
                    $vid          = 0;
                    $vnrofiles= 1;
                    $vcheckopen="0";
                    $vinicia=null;
                    $vcheckclose="0";
                    $vvence          = null;
                    $checkretraso="0";
                    $vretraso=  null;
                    $vchecklimite="0";
                    $vlimite=0;
                    $vcheckmostrardt="NO";
                    $vcheckopcion1="NO";
                    $vcheckopcion2="NO";
                    $vcheckopcion3="NO";
                    $vcheckopcion4="NO";
                    $vcheckopcion5="NO";
                    

                    if ($this->input->post('vnombre')!==null){
                         $vnombre          = $this->input->post('vnombre');
                    }
                    if ($this->input->post('vtipo')!==null){
                         $vtipo          = $this->input->post('vtipo');
                     }
                    if ($this->input->post('vidpadre')!==null){
                         $vidpadre          = $this->input->post('vidpadre');
                     }
                    if ($this->input->post('vlink')!==null){
                         $vlink          = $this->input->post('vlink');
                    }

                    if ($this->input->post('textdetalle')!==null){
                         $vdetalle          = $this->input->post('textdetalle');
                     }
                    if ($this->input->post('vorden')!==null){
                         $vorden          = $this->input->post('vorden');
                     }
                    if ($this->input->post('vid')!==null){
                         $vid          = $this->input->post('vid');
                    }
                    //CAMPO ABRIR
                    if ($this->input->post('checkopen')!==null){
                        $vcheckopen       = $this->input->post('checkopen');
                    }
                    if ($vcheckopen=="SI"){
                        if (($this->input->post('txtopenfecha')!==null) && ($this->input->post('txtopenhora')!==null)){
                         $vinicia         = $this->input->post('txtopenfecha')."  ".$this->input->post('txtopenhora') ;
                        }
                    }
                    //CAMPO VENCE
                    if ($this->input->post('checkclose')!==null){
                        $vcheckclose          = $this->input->post('checkclose');
                    }
                    if ($vcheckclose=="SI"){
                        if (($this->input->post('txtclosefecha')!==null) && ($this->input->post('txtclosehora')!==null)){
                         $vvence          = $this->input->post('txtclosefecha')."  ".$this->input->post('txtclosehora') ;
                        }
                    }
                    //CAMPO RETRASO
                    if ($this->input->post('checkretraso')!==null){
                        $checkretraso          = $this->input->post('checkretraso');
                    }
                    if ($checkretraso=="SI"){
                        if (($this->input->post('txtfecharetraso')!==null) && ($this->input->post('txthoraretraso')!==null)){
                            $vretraso          = $this->input->post('txtfecharetraso')."  ".$this->input->post('txthoraretraso') ;
                        }
                    }
                    //CAMPO MOSTRAR DETALLE
                    if ($this->input->post('checkmostrardt')!==null){
                        $vcheckmostrardt          = $this->input->post('checkmostrardt');
                    }
                    //CAMPO LIMITE_TIEMPO
                    if ($this->input->post('checklimite')!==null){
                        $vchecklimite          = $this->input->post('checklimite');
                    }
                    if ($vchecklimite=="SI"){
                        if ($this->input->post('txtlimitnumero')!==null){
                            $vlimite          = $this->input->post('txtlimitnumero');
                        }
                    }
                    if ($this->input->post('cbnroarchivos')!==null){
                        $vnrofiles          = $this->input->post('cbnroarchivos');
                    }
                    //CAMPO OPCION 1
                    if ($this->input->post('checkopcion1')!==null){
                        $vcheckopcion1          = $this->input->post('checkopcion1');
                    }
                    //CAMPO OPCION 2
                    if ($this->input->post('checkopcion2')!==null){
                        $vcheckopcion2         = $this->input->post('checkopcion2');
                    }
                    //CAMPO OPCION 3
                    if ($this->input->post('checkopcion3')!==null){
                        $vcheckopcion3          = $this->input->post('checkopcion3');
                    }
                    //CAMPO OPCION 4
                    if ($this->input->post('checkopcion4')!==null){
                        $vcheckopcion4         = $this->input->post('checkopcion4');
                    }
                    //CAMPO OPCION 5
                    if ($this->input->post('checkopcion5')!==null){
                        $vcheckopcion5          = $this->input->post('checkopcion5');
                    }

                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    
                    $vnomcurso= $this->input->post('vnomcurso');
                    $vf2=true;
                    if (($vtipo=="A") || ($vtipo=="T")|| ($vtipo=="F")|| ($vtipo=="Y")){
                        if (trim($vnombre)==""){
                            $errors['vnombre']="Se requiere un nombre para el archivo"; 
                            $dataex['msg'] = "Datos incompletos";
                            $dataex['status']=false;
                            $vf2=false;
                        }
                    }
                    if (($vtipo=="L")|| ($vtipo=="Y")){
                        if (trim($vlink)==""){
                            $errors['vlink']="Se requiere un Link / URL"; 
                            $dataex['msg'] = "Datos incompletos";
                            $dataex['status']=false;
                            $vf2=false;
                        }
                    }

                    switch ($vtipo) {
                        case 'A':
                            $textauditoria = 'un archivo(s)';
                            break;
                        case 'E':
                            $textauditoria = 'un mensaje';
                            break;
                        case 'Y':
                            $textauditoria = 'un video de YouTube';
                            break;
                        case 'T':
                            $textauditoria = 'una tarea';
                            break;
                         case 'F':
                            $textauditoria = 'un foro';
                            break;
                        case 'V':
                            $textauditoria = 'una evaluación';
                            break;
                        case 'L':
                            $textauditoria = 'un enlace';
                            break;
                        default:
                            # code...
                    }

                    $validfecha = true;

                    if ($vinicia != null && $vvence != null) {
                        if ($vvence < $vinicia) {
                            $validfecha = false;
                            $msgfiff = 'La fecha culmina no puede ser inferior a la fecha inicial de entrega';
                        } else {
                            $validfecha = true;
                        }
                    }

                    if ($vretraso != null) {
                        if ($vretraso < $vvence) {
                            $validfecha = false;
                            $msgfiff = 'La Fecha fuera de plazo no puede ser inferior a fecha de entrega';
                        } else {
                            $validfecha = true;
                        }
                    }

                    if ($validfecha == true) {
                        if ($vf2==true){
                            $notificar=true;
                            $rpta=0;
                            $filesnoup=array();
                            if ($vid<1){
                                //insert
                                $data=array($vnombre,$vtipo,$vidpadre,$vlink,$vvence,$vdetalle,$vorden,$vidcurso,$vdivision,$vnrofiles,$vretraso,$vinicia,$vcheckmostrardt,$vlimite,$vcheckopcion1,$vcheckopcion2,$vcheckopcion3,$vcheckopcion4,$vcheckopcion5);
                                $rpta = $this->mvirtual->m_insert($data);

                                $not_link=base_url()."alumno/curso/virtual/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision');

                                $vuser=$_SESSION['userActivo'];

                                $nombres=explode(" ",$_SESSION['userActivo']->nombres);
                                $creador=$nombres[0]." ".$_SESSION['userActivo']->paterno;

                                switch ($vtipo) {
                                    case 'A':
                                        $not_detalle=$creador." agregó archivo(s) en ".$vnomcurso."<br><b>".$vnombre."</b>";
                                        break;
                                    case 'E':
                                        $not_detalle=$creador." agregó un mensaje en ".$vnomcurso;
                                        if ($vcheckmostrardt=="SI") $notificar=false;
                                        break;
                                    case 'Y':
                                        $not_detalle=$creador." compartió un vídeo de Youtube en ".$vnomcurso."<br><b>".$vnombre."</b>";
                                        break;
                                    case 'T':
                                        $not_link=base_url()."alumno/curso/virtual/tarea/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision').'/'.base64url_encode($rpta->newcode);
                                        $not_detalle=$creador." agregó una tarea en ".$vnomcurso."<br><b>".$vnombre."</b>";
                                        break;
                                     case 'F':
                                        //$codcarga, $division, $codvirtual,$codmiembro
                                        $not_link=base_url()."alumno/curso/virtual/foro/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision').'/'.base64url_encode($rpta->newcode);
                                        $not_detalle=$creador." agregó un foro en ".$vnomcurso."<br><b>".$vnombre."</b>";
                                        break;
                                    case 'V':
                                        $not_detalle=$creador." agregó una evaluación en línea en ".$vnomcurso."<br><b>".$vnombre."</b>";
                                        break;
                                    case 'L':
                                        $not_detalle=$creador." compartió un enlace en ".$vnomcurso."<br><b>".$vnombre."</b>";
                                        break;
                                    default:
                                        # code...
                                }

                                if ($rpta->salida=='1'){
                                    if ($notificar==true){
                                        //CALL ``( @vcarga, @vsubseccion, @vdetalle, @vlink, @vusuario, @`s`);
                                        $this->load->model('musuario');
                                        $datanotifica=array($vidcurso,$vdivision,$not_detalle,$not_link);
                                        $this->musuario->m_insert_notificacion($datanotifica);
                                    }
                                    $dataex['status'] =true;
                                    $dataex['newid'] =$rpta->newcode;
                                    $vid=$rpta->newcode;
                                    //http://localhost/sisweb/curso/virtual/evaluacion/NTc-/MQ--/MzE3
                                    $dataex['redirect']=base_url()."curso/virtual/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision');
                                }

                                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando ".$textauditoria." en la tabla TB_VIRTUAL_MATERIAL COD.".$rpta->newcode;

                                $fictxtaccion = 'INSERTAR';
                                $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                            }
                            else{
                                //update
                                $data=array($vid,$vnombre,$vtipo,$vidpadre,$vlink,$vvence,$vdetalle,$vorden,$vidcurso,$vdivision,$vnrofiles,$vretraso,$vinicia,$vcheckmostrardt,$vlimite,$vcheckopcion1,$vcheckopcion2,$vcheckopcion3,$vcheckopcion4,$vcheckopcion5);
                                $rpta = $this->mvirtual->m_update($data);
                                
                                if ($rpta->salida=='1'){
                                    $dataex['status'] =true;
                                    $dataex['newid'] =$vid;
                                    $dataex['redirect']=base_url()."curso/virtual/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision');
                                }

                                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando ".$textauditoria." en la tabla TB_VIRTUAL_MATERIAL COD.".$vid;

                                $fictxtaccion = 'EDITAR';
                                $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                            }
                            if ($dataex['status']==true){
                                if (($vtipo=="A") || ($vtipo=="T") || ($vtipo=="F")){
                                    $datafile= json_decode($_POST['afiles']);
                                    foreach ($datafile as $value) {
                                        if ($value[4]==0){ //si no hay id de detalle
                                            if (trim($value[0])==""){
                                                $filesnoup[]=$value[1];
                                            }
                                            else{
                                                if (file_exists ("upload/".$value[0])){
                                                    $rpta2 = $this->mvirtual->m_insert_detalle(array($vid,$value[0],$value[1],$value[2],$value[3],$vidcurso,$vdivision));
                                                }else{
                                                    $filesnoup[]=$value[1];
                                                }
                                            }    
                                        }
                                    }
                                }
                                if ($vtipo=="V"){
                                    $dataex['redirect']=base_url()."curso/virtual/evaluacion/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision').'/'.base64url_encode($vid);
                                }

                            }
                            $dataex['filesnoup'] = $filesnoup;
                            if ((count($filesnoup)>0) && ($dataex['status']==true)){
                                $dataex['redirect']=base_url()."curso/virtual/editar/".$this->input->post('vidcurso').'/'.$this->input->post('vdivision').'/'.base64url_encode($dataex['newid'])."?type=".$vtipo;
                            }

                        }
                        $dataex['errors'] = $errors;
                    } else {
                        $dataex['msg']    = $msgfiff;
                    }
                }
            }
            else{
                $dataex['msg']    = 'No tienes autorización';
            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
   
    public function f_ordenar()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('vcca', 'Carga académica', 'trim|required');
            $this->form_validation->set_rules('vssc', 'Subsección', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error al intentar generar la nueva fecha</a>";
                $vcca          = $this->input->post('vcca');
                $vssc          = $this->input->post('vssc');
                $data          = json_decode($_POST['filas']);
                $dataUpdate    = array();
                foreach ($data as $value) {
                    if ($value[1] > 0) {
                        $dataUpdate[] = array($value[0],$value[1]);
                    }
                }
                $rpta = $this->mvirtual->m_ordenar($dataUpdate);
                //var_dump($dataex['ids']);
                $dataex['status'] = true;

            }
            $dataex['destino'] = $urlRef;
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function fn_delete(){
        $dataex['status'] = false;
        $dataex['msg']    = '¿Qué intentas?';
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('codvirtual', 'Material', 'trim|required');
                $this->form_validation->set_rules('vtipo', 'Tipo', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } else {
                    $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                    $codindicador    = $this->input->post('codvirtual');
                    $vtipo    = $this->input->post('vtipo');
                    $rpta=0;
                    $data=array($codindicador);

                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    $fictxtaccion = 'ELIMINAR';

                    switch ($vtipo) {
                        case 'A':
                            $textauditoria = 'un archivo(s)';
                            break;
                        case 'E':
                            $textauditoria = 'un mensaje';
                            break;
                        case 'Y':
                            $textauditoria = 'un video de YouTube';
                            break;
                        case 'T':
                            $textauditoria = 'una tarea';
                            break;
                         case 'F':
                            $textauditoria = 'un foro';
                            break;
                        case 'V':
                            $textauditoria = 'una evaluación';
                            break;
                        case 'L':
                            $textauditoria = 'un enlace';
                            break;
                        default:
                            # code...
                    }

                    //ELIMINAR DETALLE
                    if (($vtipo=="T") || ($vtipo=="F") || ($vtipo=="A") || ($vtipo=="V")){
                        $varchivos =$this->mvirtual->m_get_detalle_x_material($data);
                        $ndetalles=count($varchivos);
                        foreach ($varchivos as $key => $archivo) {
                            $rptadt = $this->mvirtual->m_delete_detalle($archivo->coddetalle);
                            if ($rptadt==1){
                                $pathtodir =  getcwd() ; 
                                unlink($pathtodir."/upload/".$archivo->link );
                                $ndetalles--;    
                            }
                        }
                        if ($ndetalles==0){
                            if ($vtipo=="T"){
                                //ELIMINAR TAREAS ENTREGADAS ANTES DE ELIMINAR EL MATERIAL
                                $this->load->model('mvirtualtarea');
                                //$tareas_material = $this->mvirtualalumno->m_get_tareas_entregadas($codindicador);
                                $detalles_tareas = $this->mvirtualtarea->m_get_detalles_x_material($codindicador);
                                
                                foreach ($detalles_tareas as $key => $detalle_tarea) {
                                    $rpta = $this->mvirtualtarea->m_tarea_entregada_delete_detalle(array($detalle_tarea->coddetalle));
                                    $pathtodir =  getcwd() ; 
                                    unlink($pathtodir."/upload/".$detalle_tarea->link );
                                    $dataex['status'] =true;
                                }

                            }
                            //ELIMINAR MATERIAL
                            $rpdeletematerial = $this->mvirtual->m_delete($data);
                            if ($rpdeletematerial>0){
                                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando ".$textauditoria." en la tabla TB_VIRTUAL_MATERIAL COD.".$codindicador;
                                $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                                $dataex['status'] =true;
                            }
                            
                            
                        }
                    }elseif (($vtipo=="E") || ($vtipo=="Y") || ($vtipo=="L") ) {
                        $rpdeletematerial = $this->mvirtual->m_delete($data);
                            if ($rpdeletematerial>0){
                                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando ".$textauditoria." en la tabla TB_VIRTUAL_MATERIAL COD.".$codindicador;
                                $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
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

    public function fn_delete_detalle(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $dataex['status'] = false;
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
              
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $codindicador    = ($this->input->post('coddetalle') =="0")?"":$this->input->post('coddetalle');
                if ("" !==$codindicador ){
                    $codindicador    = $this->input->post('coddetalle');
                    $link    = $this->input->post('link');
                    $rpta=0;
                    $data=array($codindicador);
                    if ($codindicador>0){
                        $rpta = $this->mvirtual->m_delete_detalle($data);
                        $pathtodir =  getcwd() ; 
                        unlink($pathtodir."/upload/".$link );
                        $dataex['status'] =true;
                    }
                }
                else{
                    if ("" !== $this->input->post('link')){
                        $link    = $this->input->post('link');
                        $pathtodir =  getcwd() ; 
                        unlink($pathtodir."/upload/".$link );
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

    public function fn_espaciar(){
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $dataex['status'] = false;
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('txtidvirtual', 'Material', 'trim|required');
                $this->form_validation->set_rules('txtespacio', 'Material', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } else {
                    $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                    $codindicador    = $this->input->post('txtidvirtual');
                    $txtespacio    = $this->input->post('txtespacio');
                    $rpta=0;
                    $data=array($codindicador,$txtespacio);
                    $rpta = $this->mvirtual->m_update_espacio($data);

                    if ($rpta>0){
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
            
            //$this->form_validation->set_rules('codigosubmi','codigo miembro','trim|required');
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
                $codigosubmi= "";//base64url_decode($this->input->post('codigosubmi'));
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

    public function fn_duplicar(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('txtidvirtual', 'Material', 'trim|required');
            $this->form_validation->set_rules('txtnorden', 'Orden', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                $codindicador    = $this->input->post('txtidvirtual');
                $txtespacio    = $this->input->post('txtnorden');
                $rpta=0;
                $data=array($codindicador,$txtespacio);
                $rpta = $this->mvirtual->m_insert_duplicar($data);

                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;
                $fictxtaccion = 'INSERTAR';

                if ($rpta>0){
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está duplicando un recurso en la tabla TB_VIRTUAL_MATERIAL COD.".$codindicador;
                    $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

                    $dataex['status'] =true;
                    $dataex['newcod'] =$rpta;
                }
            }
            $dataex['destino'] = $urlRef;
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function uploadfile(){
        $dataex['link']="";
        $fileTmpLoc   = $_FILES["file"]["tmp_name"]; // File in the PHP tmp folder
        $fileType     = $_FILES["file"]["type"]; // The type of file it is
        $fileSize     = $_FILES["file"]["size"]; // File size in bytes
        $fileErrorMsg = $_FILES["file"]["error"]; // 0 for false... and 1 for true
        $fileNameExt  = $_FILES["file"]["name"];
        $ext          = explode(".", $fileNameExt);
        $extension    = end($ext);
        $NewfileName  = "t".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . $_SESSION['userActivo']->codpersona;
        $arc_temp = pathinfo($fileTmpLoc);

        
        $nomb_temp=url_clear($arc_temp['filename']);
        $nro_rand=rand(0,9);
        $link="av".$NewfileName.$nomb_temp.$nro_rand.".".$extension;
        $dataex['link'] = "";
        $dataex['temp'] = "";
        if (move_uploaded_file($fileTmpLoc, "upload/$link")) {
            $dataex['link'] = $link;
            $dataex['temp'] = $fileTmpLoc;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_summer_upload_images(){
        if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = "sm".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . $_SESSION['userActivo']->codpersona.Rand(100, 200);
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . $ext[count($ext)-1];
                $destination = 'upload/summer/' . $filename; //cambiar este directorio
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                echo 'upload/summer/' . $filename;
            } else {
              echo  $message = 'Se ha producido el siguiente error:  '.$_FILES['file']['error'];
            }
        }
    }

    public function fn_summer_delete_images()
    {
        $src = $this->input->post('src'); 
        // $src = $_POST['src']; 
        $file_name = str_replace(base_url(), '', $src); 
        
        if(unlink($file_name)) { 
            echo 'imagen eliminada correctamente'; 
        }
    }

    public function fn_update_mostrar_ocultar(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('txtidvirtual', 'codigo', 'trim|required');
            $this->form_validation->set_rules('txtstatus', 'estado', 'trim|required');
            
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                
                $codigo = $this->input->post('txtidvirtual');
                $estado = $this->input->post('txtstatus');
                
                $rpta = $this->mvirtual->m_update_mostrar_ocultar(array($estado, NULL, $codigo));
                
                if ($rpta>0){
                    $dataex['status'] =true;
                    
                }
            }
            
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function fn_programar_recurso()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
        
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            
            $this->form_validation->set_rules('fictxtidvirtual','codigo','trim|required');
            $this->form_validation->set_rules('fictxtfechavirt_prog','fecha','trim|required');
            $this->form_validation->set_rules('fictxthoravirt_prog','hora','trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            }
            else
            {
                $dataex['status'] =FALSE;
                
                $codigo = $this->input->post('fictxtidvirtual');
                $fecha = $this->input->post('fictxtfechavirt_prog');
                $hora = $this->input->post('fictxthoravirt_prog');
                $time_visible = $fecha.' '.$hora;
                date_default_timezone_set('America/Lima');
                $timelocal=time();
                if (strtotime($time_visible)<$timelocal) {
                    $dataex['status'] = False;
                    $dataex['statfec'] = False;
                    $dataex['msg'] = "La fecha y hora ingresada debe ser mayor que la fecha y hora actual";
                } else {

                    $rpta=$this->mvirtual->m_update_programar_status(array("Auto", $time_visible, $codigo));
                    if ($rpta > 0){
                        // $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una área en la tabla TB_AREA COD.".$rpta;
                        // $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        $dataex['status'] =TRUE;
                        $dataex['codigo'] = $codigo;
                        $dataex['msg'] ="<i class='far fa-clock'></i> ".date("d-m-Y h:i A", strtotime($time_visible));
                        $dataex['fechadata'] = $time_visible;
                        
                    }
                }
                
            }
        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


}
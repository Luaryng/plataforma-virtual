<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'controllers/Sendmail.php';
class Mesa_partes  extends Sendmail
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("mmesa_partes");
    }
    public function vw_administrativo_mesa()
    {
        $ahead = array('page_title' => 'ERP | MESA DE PARTES');
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        $vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        $asidebar = array('menu_padre' => 'mn_tramites', 'menu_hijo' => 'mn_mesa');
        $this->load->view($vsidebar, $asidebar);
        
        $this->load->model("musuario");
        date_default_timezone_set('America/Lima');
        $array['administrativos']=$this->musuario->m_get_usuarios_administrativos();    
        $this->load->model("marea");
        $array['areas']=$this->marea->m_get_areas_activas(array($_SESSION['userActivo']->idsede)); 

        $array['tipos'] = $this->mmesa_partes->m_lts_tipo_tramite();

        $codtipo = "%";
        $situacion = "PENDIENTE";
        $busqueda = "%";
        if ($this->input->get('tpt')!==NULL) $codtipo = base64url_decode($this->input->get('tpt'));
        if ($this->input->get('stt')!==NULL) $situacion = $this->input->get('stt');
        if ($this->input->get('qry')!==NULL) $busqueda = "%".$this->input->get('qry')."%";
        if (getPermitido("68")=="SI"){
            $mis_solicitudes = $this->mmesa_partes->m_solicitudes_to_mesa_partes(array($codtipo,$busqueda,$situacion)); 
            $array['solicitudes']= $mis_solicitudes;
            $this->load->view('tramites/mesa_partes/vw_administrativo_mesa_receptor', $array);
        }
        else{
            $mis_solicitudes = $this->mmesa_partes->m_solicitudes_x_area_destino(array($_SESSION['userActivo']->idarea,$_SESSION['userActivo']->idusuario,$codtipo,$busqueda,$situacion));
            $array['solicitudes']= $mis_solicitudes;
            $this->load->view('tramites/mesa_partes/vw_administrativo_mesa', $array);
        }
        
        $this->load->view('footer');
    }

    /*public function vw_administrativo_mesa()
    {
        $ahead = array('page_title' => 'ERP | MESA DE PARTES');
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        $vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        $asidebar = array('menu_padre' => 'mn_tramites', 'menu_hijo' => 'mn_mesa');
        $this->load->view($vsidebar, $asidebar);
        
        $this->load->model("musuario");
        date_default_timezone_set('America/Lima');
        $array['administrativos']=$this->musuario->m_get_usuarios_administrativos();    
        $array['areas']=$this->musuario->m_get_areas(); 
        $array['tipos'] = $this->mmesa_partes->m_lts_tipo_tramite();

        $codtipo = "%";
        $situacion = "PENDIENTE";
        $busqueda = "%";
        if ($this->input->get('tpt')!==NULL) $codtipo = base64url_decode($this->input->get('tpt'));
        if ($this->input->get('stt')!==NULL) $situacion = $this->input->get('stt');
        if ($this->input->get('qry')!==NULL) $busqueda = "%".$this->input->get('qry')."%";
        if (getPermitido("68")=="SI"){
            $mis_solicitudes = $this->mmesa_partes->m_solicitudes_to_mesa_partes(array($_SESSION['userActivo']->idarea,$situacion,$codtipo,$busqueda)); 
        }
        else{
            $mis_solicitudes = $this->mmesa_partes->m_solicitudes_x_area_destino(array($_SESSION['userActivo']->idarea,$situacion,$codtipo,$busqueda));
        }
        $array['solicitudes']= $mis_solicitudes;
        
        $this->load->view('tramites/mesa_partes/vw_administrativo_mesa', $array);
        $this->load->view('footer');
    }*/


    public function vw_administrativo_solicitud_detalle()
    {
        $ahead = array('page_title' => 'IESTWEB | MESA DE PARTES');
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        $asidebar = array('menu_padre' => 'mn_tramites', 'menu_hijo' => 'mn_mesa');
        $vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        $this->load->view($vsidebar, $asidebar);
        $cod = base64url_decode($this->input->get('cmp'));
        $arraytip = $this->mmesa_partes->m_solicitud_x_codigo($cod);
        $this->load->view('tramites/mesa_partes/vw_administrativo_solicitud_detalle', $arraytip);
        $this->load->view('footer');
    }

    public function vw_administrativo_ajax_solicitud_detalle()
    {
    	$dataex['status'] = false;
        $dataex['msg']    = "No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

        if ($this->input->is_ajax_request()) {
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('seguimiento', 'Cod. Seguimiento', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } 
            else {
                $seg = base64url_decode($this->input->post('seguimiento'));
                $dataex['status'] = true;
                $arraytip = $this->mmesa_partes->m_solicitud_x_codigo($seg);
                $dataex['datos']      = $this->load->view('tramites/mesa_partes/vw_administrativo_solicitud_detalle_ajax', $arraytip, true);
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
    public function vw_administrativo_ajax_solicitud_ruta()
    {
    	$dataex['status'] = false;
        $dataex['msg']    = "No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

        if ($this->input->is_ajax_request()) {
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('seguimiento', 'Cod. Seguimiento', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } 
            else {
                $seg = base64url_decode($this->input->post('seguimiento'));
                $dataex['status'] = true;
                $arraytip = $this->mmesa_partes->m_solicitud_ruta_x_codigo($seg);
                 if (($_SESSION['userActivo']->tipo=="AD") || ($_SESSION['userActivo']->tipo=="DA")){
                	$dataex['datos']      = $this->load->view('tramites/mesa_partes/vw_administrativo_solicitud_ruta_ajax', $arraytip, true);
                }
                else{
                	$dataex['datos']      = $this->load->view('tramites/mesa_partes/vw_solicitud_ruta_ajax', $arraytip, true);
                }
                
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_administrativo_ejecutar()
    {
    	$dataex['status'] = false;
        $dataex['msg']    = "No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

        if ($this->input->is_ajax_request()) {
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('vw_mpae_txt_seguimiento', 'Cod. Seguimiento', 'trim|required');
            $this->form_validation->set_rules('vw_mpae_txt_ruta', 'Cod. Ruta', 'trim|required');
            $this->form_validation->set_rules('vw_mpae_cb_ejecutar', 'Acción', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } 
            else {
            	date_default_timezone_set ('America/Lima');
                $seg = base64url_decode($this->input->post('vw_mpae_txt_seguimiento'));
                $rut = base64url_decode($this->input->post('vw_mpae_txt_ruta'));
                $acto = $this->input->post('vw_mpae_cb_ejecutar');


                $descp = $this->input->post('vw_mpae_txt_descripcion');
                $idarea = base64url_decode($this->input->post('vw_mpa_lista_cb_area'));
                $idadmin = base64url_decode($this->input->post('vw_mpa_lista_cb_usuario'));

                $d_asunto="";
                $enviar_mail=false;
                if ($acto=="RECIBIDO"){
                	$rpta=$this->mmesa_partes->m_ruta_recibir(array($_SESSION['userActivo']->idusuario,$seg,$rut,date('Y-m-d H:i:s'),$descp));
                	//if ($rpta->salida=="1") $dataex['status'] = true;
                }
                elseif ($acto=="RECHAZADO") {
                	//CALL `sp_tb_mesa_partes_rechazar`( @vid_usuario, @vmpt_id, @vmpr_id, @vmpr_fecha_procesado, @s);
                	$rpta=$this->mmesa_partes->m_ruta_rechazar(array($_SESSION['userActivo']->idusuario,$seg,$rut,date('Y-m-d H:i:s'),$descp));
                    $enviar_mail=true;
                    $d_asunto="Su trámite COD: $idceros fue RECHAZADO.";
                	//if ($rpta->salida=="1") $dataex['status'] = true;
                }
                elseif ($acto=="DERIVADO") {
                    $rpta=$this->mmesa_partes->m_ruta_derivar(array($_SESSION['userActivo']->idusuario,$seg,$rut,date('Y-m-d H:i:s'),$descp,$idarea,$idadmin,$_SESSION['userActivo']->idarea));
                    if ($rpta->salida=="1"){
                        $rut =$rpta->nid;
                    } 
                }
                elseif ($acto=="FINALIZADO") {
                    $rpta=$this->mmesa_partes->m_ruta_finalizar(array($_SESSION['userActivo']->idusuario,$seg,$rut,date('Y-m-d H:i:s'),$descp,$idarea,$idadmin,$_SESSION['userActivo']->idarea));
                    $enviar_mail=true;
                    $d_asunto="Su trámite COD: $idceros fue completado.";
                }
            }
                //$dataex['status2'] = $rpta;
            if ($rpta->salida=="1"){
                $data          = json_decode($_POST['vw_mpc_archivos']);
                $pathtodir =  getcwd() ; 
                $allfiles=true;
                foreach ($data as $key => $fl) {
                    $rptafil = $this->mmesa_partes->insert_archivos_mesa_partes(array($seg,$rut,$fl[4],$fl[0],$fl[1],$fl[2],$fl[3]));
                    
                    if ($rptafil=="1"){
                        
                        $link=$fl[0];
                        $copied = copy($pathtodir."/upload/tramites/tmp/".$link  , $pathtodir."/upload/tramites/".$link);
                        
                        if ((!$copied)) 
                        { 
                            $allfiles=false;
                        }

                    }
                }
                if ($enviar_mail==true){
                    $this->load->model('miestp');
                    $iestp=$this->miestp->m_get_datos();
                    $solicitud = $this->mmesa_partes->m_solo_solicitud_x_codigo($seg);
                    
                    $rut =$rpta->nid;

                    $d_destino=array();
                    $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                    //$d_destino=array($iestp->email);
                    $correo=trim($solicitud->email_personal);
                    if ($correo!=""){
                        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                            $d_destino[]=$correo;
                            //$r_respondera=array($correo,$nombres);
                        }
                    }
                    $correo=trim($solicitud->email_corporativo);
                    if ($correo!=""){
                        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                            $d_destino[]=$correo;
                            //$r_respondera=array($correo,$nombres);
                        }
                    }

                    $r_respondera=array();
                    if (count($d_destino)>0){
                        //$d_destino=array($_SESSION['userActivo']->ecorporativo,"istpublicohuarmaca@hotmail.com");
                        
                        $d_mensaje=$this->load->view('emails/vw_notificar_tramite', array('ies'=> $iestp,'mensaje'=>$descp ),true);
                        
                         foreach ($data as $key => $fl) {
                            /*,$('#vw_mpc_txt_filename').html(),1
                            $('#vw_mpc_txt_size').html(),2
                            $('#vw_mpc_txt_type').html(),3
                            $('#vw_mpc_txt_titulo').val()]4*/
                           $pruebas_email[]=array($pathtodir."/upload/tramites/".$fl[0]  , 'attachment',$fl[1]);    
                        }
                    }
                    //$rsp_denunciante=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email);
                    //sleep(5);
                    $rsp_iesap=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email,$r_respondera);
                    /*foreach ($data as $key => $fl) {
                        $link=$fl[0];
                        unlink($pathtodir."/upload/tramites/tmp/".$link );
                    };*/
                    $dataex['msg']="Su Trámite fue enviado con éxito";
                    //$dataex['status'] =true;
                }

                if ($allfiles==true){
                    $dataex['status'] = true;
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }



    public function vw_mi_mesa()
    {
        $ahead = array('page_title' => 'ERP | MESA DE PARTES');
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        $vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        $asidebar = array('menu_padre' => 'mn_tramites', 'menu_hijo' => 'mn_mesa');
        $this->load->view($vsidebar, $asidebar);
        $mis_solicitudes = $this->mmesa_partes->m_solicitudes_x_user($_SESSION['userActivo']->idusuario);
        $this->load->view('tramites/mesa_partes/vw_mi_mesa', array('solicitudes' => $mis_solicitudes));
        $this->load->view('footer');
    }
    
    public function vw_crear_propio()
    {
        $ahead = array('page_title' => 'IESTWEB | MESA DE PARTES');
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        $asidebar = array('menu_padre' => 'mn_tramites', 'menu_hijo' => 'mn_mesa');
        $vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        
        $this->load->view($vsidebar, $asidebar);
        $this->load->model("musuario");
        $arraytip = $this->musuario->m_perfil($_SESSION['userActivo']->codpersona);
        $arraytip['tipos'] = $this->mmesa_partes->m_lts_tipo_tramite();
        
        if (getPermitido("68")=="SI"){
            $this->load->view('tramites/mesa_partes/vw_crear_receptor', $arraytip);    
        }
        else{
            $this->load->view('tramites/mesa_partes/vw_crear', $arraytip);
        }
        
        
        $this->load->view('footer');
    }

    public function vw_crear_externo()
    {
        // $ahead= array('page_title' =>'ERP | MESA DE PARTES'  );
        // $this->load->view('head',$ahead);
        // $this->load->view('nav');
        // $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        // $asidebar= array('menu_padre' =>'mn_tramites','menu_hijo' =>'mn_mesa');
        // $this->load->view($vsidebar,$asidebar);
        $arraytip['tipos'] = $this->mmesa_partes->m_lts_tipo_tramite();
        $this->load->view('tramites/mesa_partes/vw_crear_externo', $arraytip);
        // $this->load->view('footer');
    }

    public function vw_solicitud_detalle()
    {
        $ahead = array('page_title' => 'IESTWEB | MESA DE PARTES');
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        $asidebar = array('menu_padre' => 'mn_tramites', 'menu_hijo' => 'mn_mesa');
        $vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        $this->load->view($vsidebar, $asidebar);
        $cod = base64url_decode($this->input->get('cmp'));
        $arraytip = $this->mmesa_partes->m_solicitud_x_codigo($cod);
        $this->load->view('tramites/mesa_partes/vw_solicitud_detalle', $arraytip);
        $this->load->view('footer');
    }

    public function vwasignar_files()
    {
        $dataex['status'] = false;
        $dataex['msg']    = "No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
        if ($this->input->is_ajax_request()) {

            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtnro', 'cantidad', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $nrofiles = $this->input->post('txtnro');
                if ($nrofiles != "") {
                    $dataex['status']     = true;
                    $arrayinc['nrofiles'] = $nrofiles;
                    $dataex['vdata']      = $this->load->view('tramites/mesa_partes/add_file_mesa', $arrayinc, true);
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
    
    public function fn_insert()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

        $dataex['status'] = false;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request()) {
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('vw_mp_cb_tramite', 'Tipo trámite', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_asunto', 'Asunto solicitud', 'trim|required');
            $this->form_validation->set_rules('vw_mp_cb_tdoc', 'Tipo documento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_nro_doc', 'N° documento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_apelnom', 'Apellidos y nombres', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_folios', 'N° Folios', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_ndocument', 'N° Documento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_tippersona', 'Tipo Persona', 'trim|required');
            //$this->form_validation->set_rules('vw_mp_txt_contenido', 'Detalle', 'trim|required');
            //$this->form_validation->set_rules('vw_mp_txt_domicilio', 'domicilio', 'trim|required');
            //$this->form_validation->set_rules('vw_mp_txt_celular', 'Teléfono', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = "Existen errores en los campos";
                $errors        = array();
                foreach ($this->input->post() as $key => $value) {
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            } else {
                $dataex['status'] = false;
                date_default_timezone_set('America/Lima');
                $propio   = $this->input->post('vw_mp_chc_propio');
                $user      = $_SESSION['userActivo']->idusuario;
                $tramite   = $this->input->post('vw_mp_cb_tramite');
                $asunto    = $this->input->post('vw_mp_txt_asunto');
                $tipdoc    = $this->input->post('vw_mp_cb_tdoc');
                $nro_documento = $this->input->post('vw_mp_txt_nro_doc');
                $nombres   = $this->input->post('vw_mp_txt_apelnom');
                $detalle   = $this->input->post('vw_mp_txt_contenido');
                $domicilio = $this->input->post('vw_mp_txt_domicilio');
                $telefono  = $this->input->post('vw_mp_txt_celular');
                $correo    = $this->input->post('vw_mp_txt_email');

                $folios = $this->input->post('vw_mp_txt_folios');
                $nrodocumento = $this->input->post('vw_mp_txt_ndocument');
                $tipersona = $this->input->post('vw_mp_txt_tippersona');

                $anio=date("Y");
                if (getPermitido("68")=="SI"){
                    $vlugar="MP";
                }
                else{
                    $vlugar="MV";
                }
                $vccorporativo="";
                $varea=null;
                if (isset($propio)) {
                    $vlugar="MP";
                    $vccorporativo=$_SESSION['userActivo']->ecorporativo;
                    $$varea=$_SESSION['userActivo']->idarea;
                }
               

                

                $rpta = $this->mmesa_partes->insert_datos_mesa_partes(array($user, $tramite, $asunto, $folios, $nrodocumento, $tipersona, $tipdoc, $nro_documento, $nombres, $detalle, $domicilio, $telefono, $correo, $vccorporativo,$varea,$anio,$vlugar));
                 $dataex['status1'] =$rpta;
                if ($rpta->salida=="1"){
                    $data          = json_decode($_POST['vw_mpc_archivos']);
                    $pathtodir =  getcwd() ; 
                    $allfiles=true;
                    $pruebas=array();
                    $pruebas_email=array();
                    foreach ($data as $key => $fl) {
                        /*[data.link0
                        ,$('#vw_mpc_txt_filename').html(),1
                        $('#vw_mpc_txt_size').html(),2
                        $('#vw_mpc_txt_type').html(),3
                        $('#vw_mpc_txt_titulo').val()]4*/
                        // @vinc_id, @vincp_titulo, @vincp_link, @vincp_archivo, @vincp_peso, @vincp_tipo*/
                        $rptafil = $this->mmesa_partes->insert_archivos_mesa_partes(array($rpta->nid,NULL,$fl[4],$fl[0],$fl[1],$fl[2],$fl[3]));
                        
                        if ($rptafil=="1"){
                            
                            $link=$fl[0];
                            $copied = copy($pathtodir."/upload/tramites/tmp/".$link  , $pathtodir."/upload/tramites/".$link);
                            $a_ppdf = new stdClass;
                            $pruebas[]=$a_ppdf;
                            $pruebas_email[]=array($pathtodir."/upload/tramites/".$link, 'attachment',$fl[1]);
                            $a_ppdf->titulo=$fl[4];
                            
                            if ((!$copied)) 
                            { 
                                $allfiles=false;
                            }

                        }
                    }
                    if ($allfiles==true){


                        
                        /*$a_pdf = new stdClass;
                        
                        $a_pdf->id=$rpta->nid;
                        $a_pdf->usuario=$user;
                        $a_pdf->nombres=$apellidos;
                        $a_pdf->documento=$nro_documento;
                        $a_pdf->tipodoc=$tipodoc;
                        $a_pdf->domicilio=$domicilio;
                        $a_pdf->distrito=$distrito;
                        $a_pdf->asunto=$incidencia;
                        $a_pdf->detalle=$detalle;
                        $a_pdf->declara=$txtdecla;
                        $a_pdf->estado="";
                        $a_pdf->fecha=date("Y-m-d H:i:s"); 
                       
                        $this->load->model('miestp');
                        $iestp=$this->miestp->m_get_datos();
                        $arrayinc['incidencia'] = $a_pdf;
                        $arrayinc['ies'] = $iestp;
                        $arrayinc['pruebas'] = $pruebas;

                        
                        $htmlnt      = $this->load->view('tramites/incidencias/pdf_formato', $arrayinc,true);

                        $pdfFilePath = "INCIDENCIA IESTWEB" . ".pdf";
                        $this->load->library('M_pdf');
                        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
                        $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.2,array(50, 80),'P');
                        $mpdf->showWatermarkImage = true;
                        
                        $mpdf->WriteHTML($htmlnt);
                        $pdfdoc = $mpdf->Output('','S');
                        $idceros=str_pad($rpta->nid, 4, "0", STR_PAD_LEFT);
                        $pruebas_email[]=array($pdfdoc, 'attachment',"Denuncia Nro".$idceros.".pdf","application/pdf");
                        //==================================
                        //FIN PDF A ENVIAR
                        //==================================
                        //ENVIAR CONSTANCIA A ALUMNO
                        $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                        //$d_destino=array($_SESSION['userActivo']->ecorporativo,"janiorjimenezh@gmail.com");
                        $d_destino=array($_SESSION['userActivo']->ecorporativo,"istpublicohuarmaca@hotmail.com");
                        $d_asunto="Denuncia  Nro: DN".$idceros." reportada con éxito";
                        $d_mensaje=$this->load->view('emails/vw_notificar_denuncia', array('incidencia' => $a_pdf,'ies'=> $iestp ),true);
                        $r_respondera=array($_SESSION['userActivo']->ecorporativo,$apellidos);
                        
                        
                         //fsendmail_adjunta($correo_destino,$asunto,$correo_envia,$nombre_envia,$mensaje,$adjunto)
                        // $enviador = array($vuser->ecorporativo,$vuser->paterno." ".$vuser->materno." ".$vuser->nombres);
                        //$rsp_denunciante=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email);
                        //sleep(5);
                        $rsp_iesap=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email,$r_respondera);
                        foreach ($data as $key => $fl) {
                            $link=$fl[0];
                            unlink($pathtodir."/upload/tramites/tmp/".$link );
                        };*/
                        $dataex['msg']="Su reporte fue enviado correctamente";
                        $dataex['status'] =true;
                        $dataex['codseg'] =$rpta->codseg;
                        
                        $dataex['linkpdf']=base_url()."tramites/mesa-de-partes/constancia-pdf?cinc=".base64url_encode($rpta->nid);
                        
                        //$dataex['rsm_iesap']=$rsp_iesap
                    }
                    else{
                        $dataex['msg']="Ocurio un error, comuniquese con el administrador";
                        $dataex['status'] =false;
                        $dataex['linkpdf']="";
                    }

                }
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }
    
    public function fn_insert_externo()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

        $dataex['status'] = false;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request()) {
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('vw_mp_cb_tramite', 'Tipo trámite', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_asunto', 'Asunto solicitud', 'trim|required');
            $this->form_validation->set_rules('vw_mp_cb_tdoc', 'Tipo documento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_nro_doc', 'N° documento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_apelnom', 'Apellidos y nombres', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_contenido', 'Detalle', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_domicilio', 'domicilio', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_celular', 'Teléfono', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_folios', 'N° Folios', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_ndocument', 'N° Documento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_tippersona', 'Tipo Persona', 'trim|required');

            if ($this->form_validation->run() == false) {
                $dataex['msg'] = "Existen errores en los campos";
                $errors        = array();
                foreach ($this->input->post() as $key => $value) {
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            } 
            else {
                $dataex['status'] = false;
                date_default_timezone_set('America/Lima');
                $user      = NULL;
                $tramite   = $this->input->post('vw_mp_cb_tramite');
                $asunto    = $this->input->post('vw_mp_txt_asunto');
                $tipdoc    = $this->input->post('vw_mp_cb_tdoc');
                $nro_documento = $this->input->post('vw_mp_txt_nro_doc');
                $nombres   = $this->input->post('vw_mp_txt_apelnom');
                $detalle   = $this->input->post('vw_mp_txt_contenido');
                $domicilio = $this->input->post('vw_mp_txt_domicilio');
                $telefono  = $this->input->post('vw_mp_txt_celular');
                $correo    = $this->input->post('vw_mp_txt_email');

                $folios = $this->input->post('vw_mp_txt_folios');
                $nrodocumento = $this->input->post('vw_mp_txt_ndocument');
                $tipersona = $this->input->post('vw_mp_txt_tippersona');

                $anio=date("Y");
                
                $vlugar="MV";
                
                $vccorporativo="";
             
                


                $rpta = $this->mmesa_partes->insert_datos_mesa_partes(array($user, $tramite, $asunto, $folios, $nrodocumento, $tipersona, $tipdoc, $nro_documento, $nombres, $detalle, $domicilio, $telefono, $correo, $vccorporativo,2,$anio,$vlugar));
                 $dataex['status1'] =$rpta;
                if ($rpta->salida=="1"){
                    $idceros="MV".str_pad($rpta->nid, 4, "0", STR_PAD_LEFT);
                    $data          = json_decode($_POST['vw_mpc_archivos']);
                    $pathtodir =  getcwd() ; 
                    $allfiles=true;
                    $pruebas=array();
                    $pruebas_email=array();
                    foreach ($data as $key => $fl) {
                        $rptafil = $this->mmesa_partes->insert_archivos_mesa_partes(array($rpta->nid,NULL,$fl[4],$fl[0],$fl[1],$fl[2],$fl[3]));
                        
                        if ($rptafil=="1"){
                            $copied=false;
                            $link=$fl[0];
                            $existefile=is_file($pathtodir."/upload/tramites/tmp/".$link);
                            if ($existefile==true){
                                $copied = copy($pathtodir."/upload/tramites/tmp/".$link  , $pathtodir."/upload/tramites/".$link);
                                /*$a_ppdf = new stdClass;
                                $pruebas[]=$a_ppdf;
                                $pruebas_email[]=array($pathtodir."/upload/tramites/".$link, 'attachment',$fl[1]);
                                $a_ppdf->titulo=$fl[4];*/
                            }
                           
                            
                            
                            if ((!$copied)) 
                            { 
                                $allfiles=false;
                            }

                        }
                    }
                    if ($allfiles==true){


                        $a_pdf = new stdClass;
                        
                        $a_pdf->id=$rpta->nid;
                        $a_pdf->codseg=$idceros;
                        $a_pdf->fecha=date("Y-m-d H:i:s"); 

                        /*$a_pdf->usuario=$user;
                        $a_pdf->nombres=$apellidos;
                        $a_pdf->documento=$nro_documento;
                        $a_pdf->tipodoc=$tipodoc;
                        $a_pdf->domicilio=$domicilio;
                        $a_pdf->distrito=$distrito;
                        $a_pdf->asunto=$incidencia;
                        $a_pdf->detalle=$detalle;
                        $a_pdf->declara=$txtdecla;
                        $a_pdf->estado="";

                        $arrayinc['incidencia'] = $a_pdf;
                        $arrayinc['ies'] = $iestp;
                        $arrayinc['pruebas'] = $pruebas;

                        $htmlnt      = $this->load->view('tramites/incidencias/pdf_formato', $arrayinc,true);

                        $pdfFilePath = "INCIDENCIA IESTWEB" . ".pdf";
                        $this->load->library('M_pdf');
                        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
                        $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.2,array(50, 80),'P');
                        $mpdf->showWatermarkImage = true;
                        
                        $mpdf->WriteHTML($htmlnt);
                        $pdfdoc = $mpdf->Output('','S');
                        
                        $pruebas_email[]=array($pdfdoc, 'attachment',"Denuncia Nro".$idceros.".pdf","application/pdf");
                        //==================================
                        //FIN PDF A ENVIAR
                        //==================================*/
                        //ENVIAR CONSTANCIA A ALUMNO
                        
                        $this->load->model('miestp');
                        $iestp=$this->miestp->m_get_datos();
                        $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                        $d_destino=array($iestp->email);
                        $correo=trim($correo);
                        if ($correo!=""){
                            if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                                $d_destino[]=$correo;
                                $r_respondera=array($correo,$nombres);
                            }
                        }

                        //$d_destino=array($_SESSION['userActivo']->ecorporativo,"istpublicohuarmaca@hotmail.com");
                        $d_asunto="Trámite COD: $idceros enviado con éxito";
                        $d_mensaje=$this->load->view('emails/vw_notificar_envio_tramite', array('tmt' => $a_pdf,'ies'=> $iestp ),true);
                        //$r_respondera=array($_SESSION['userActivo']->ecorporativo,$nombres);
                        
                        
                         //fsendmail_adjunta($correo_destino,$asunto,$correo_envia,$nombre_envia,$mensaje,$adjunto)
                        // $enviador = array($vuser->ecorporativo,$vuser->paterno." ".$vuser->materno." ".$vuser->nombres);
                        //$rsp_denunciante=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email);
                        //sleep(5);
                        $rsp_iesap=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email,$r_respondera);
                        /*foreach ($data as $key => $fl) {
                            $link=$fl[0];
                            unlink($pathtodir."/upload/tramites/tmp/".$link );
                        };*/
                        $dataex['msg']="Su Trámite fue enviado con éxito";
                        $dataex['status'] =true;
                        $dataex['nid']=$idceros;
                        //$dataex['linkpdf']=base_url()."tramites/mesa-de-partes/constancia-pdf?cinc=".base64url_encode($rpta->nid);
                        
                        //$dataex['rsm_iesap']=$rsp_iesap
                    }
                    else{
                        $dataex['msg']="Ocurio un error, comuniquese con el administrador";
                        $dataex['status'] =false;
                        $dataex['linkpdf']="";
                    }
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_upload_file_logeado(){
        
        if ($_FILES['vw_mpc_file']['name']) {
            if (!$_FILES['vw_mpc_file']['error']) {
                $name = $_FILES['vw_mpc_file']['name'];//md5(Rand(100, 200));
                $ext = explode('.', $_FILES['vw_mpc_file']['name']);
                $ult=count($ext);
                $nro_rand=rand(0,9);
                $NewfileName  = "mp_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$_SESSION['userActivo']->codpersona;
                $filename = $NewfileName.".".$ext[$ult-1];//. '.' . $ext[1];
                
                $destination = './upload/tramites/tmp/' .$filename ; //change this directory
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

    public function fn_upload_file_externo(){
        
        if ($_FILES['vw_mpc_file']['name']) {
            if (!$_FILES['vw_mpc_file']['error']) {
                $name = $_FILES['vw_mpc_file']['name'];//md5(Rand(100, 200));
                $ext = explode('.', $_FILES['vw_mpc_file']['name']);
                $ult=count($ext);
                $nro_rand=rand(0,9);
                $nro_rand2=rand(0,100);
                $NewfileName  = "mpe_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$nro_rand2;
                $filename = $NewfileName.".".$ext[$ult-1];//. '.' . $ext[1];
                
                $destination = './upload/tramites/tmp/' .$filename ; //change this directory
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

    
}

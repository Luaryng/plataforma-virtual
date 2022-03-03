<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'controllers/Sendmail.php';
class Mesa_partes  extends Sendmail
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("mmesa_partes");
        $this->load->model("msede");
        $this->load->model('mcorreos');
        $this->load->model("mtemporal");
        $this->load->model('mperiodo');
        $this->load->model('mcarrera');
    }

    public function vw_administrativo_mesa()
    {
        $ahead = array('page_title' => 'Mesa de Partes | Plataforma Virtual');
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        //$vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        $vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
        $asidebar = array('menu_padre' => 'mn_mesa', 'menu_hijo' => 'mn_mesa');
        $this->load->view($vsidebar, $asidebar);

        date_default_timezone_set('America/Lima');
        //CARGAR TABLAS MAESTRAS
        $this->load->model("musuario");
        $array['administrativos']=$this->musuario->m_get_usuarios_administrativos();    
        $this->load->model("marea");
        $array['areas']=$this->marea->m_get_areas_activas(array($_SESSION['userActivo']->idsede)); 
        $array['tipos'] = $this->mmesa_partes->m_lts_tipo_tramite();
        // FIN CARGAR TABLAS MAESTRAS

        $codtipo = "%";
        $situacion = "PENDIENTE";
        $busqueda = "%";
        $sede = $_SESSION['userActivo']->idsede;
        if ($this->input->get('tpt')!==NULL) $codtipo = base64url_decode($this->input->get('tpt'));
        if ($this->input->get('stt')!==NULL) $situacion = $this->input->get('stt');
        if ($this->input->get('qry')!==NULL) $busqueda = "%".$this->input->get('qry')."%";

        if (getPermitido("68")=="SI"){
            //TIENE PERMISO PARA RECEPCIONAR
            
            $this->load->view('tramites/mesa_partes/vw_administrativo_mesa_receptor', $array);
        }
        else{
            
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
                $arraytip['rutas'] = $this->mmesa_partes->m_solicitud_ruta_x_codigo($seg);
                $dataex['datos']      = $this->load->view('tramites/mesa_partes/vw_administrativo_solicitud_detalle_ajax', $arraytip, true);
                $solicitud=$arraytip['solicitud'];
                $solicitante="$solicitud->tipodoc - $solicitud->nrodoc / $solicitud->solicitante ";
                $dataex['codseguim'] = $solicitud->codseg;
                $dataex['solicitante'] = $solicitante;

                //$dataex['asunto'] = $solicitud->asunto;
                /*$datereg =  new DateTime($solicitud->fecha);
                $dataex['fecha'] = $datereg->format('d/m/Y h:i a');*/
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

                $solicitud=$arraytip['solicitud'];
                $solicitante="$solicitud->tipodoc - $solicitud->nrodoc / $solicitud->solicitante ";
                $dataex['codseguim'] = $solicitud->codseg;
                $dataex['solicitante'] = $solicitante;
                $dataex['asunto'] = $solicitud->asunto;

                /*$dataex['codseguim'] = $arraytip['solicitud']->codseg;
                $dataex['solicitante'] = $arraytip['solicitud']->solicitante;
                $dataex['asunto'] = $arraytip['solicitud']->asunto;*/
                /*$datereg =  new DateTime($arraytip['solicitud']->fecha);
                $dataex['fecha'] = $datereg->format('d/m/Y h:i a');*/
                
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
            $this->form_validation->set_rules('vw_mpa_lista_cb_area', 'Acción', 'trim|required');
            $this->form_validation->set_rules('vw_mpa_lista_cb_usuario', 'Acción', 'trim|required');
            

            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } 
            else {
                date_default_timezone_set ('America/Lima');
                $validar=true;
                $seg = base64url_decode($this->input->post('vw_mpae_txt_seguimiento'));
                $rut = base64url_decode($this->input->post('vw_mpae_txt_ruta'));
                $idarea = $this->input->post('vw_mpa_lista_cb_area');
                $idadmin = $this->input->post('vw_mpa_lista_cb_usuario');

                $acto = $this->input->post('vw_mpae_cb_ejecutar');
                $e_mensaje="";
                

                $descp = $this->input->post('vw_mpae_txt_descripcion');

                //PARA ENVIO DE CORREO
                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();
                $solicitud = $this->mmesa_partes->m_solo_solicitud_x_codigo($seg);
                $idceros = $solicitud->codseg;
                $ruta_tramite=$rut;
                $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                $d_destino=array();
                $d_copia=array();
                $d_oculto=array();
                $d_responder=$d_enviador;
                $d_asunto="";
                $d_estado = $acto;
                $d_mensaje = "";
                $nombreuser=explode(" ",$_SESSION['userActivo']->nombres);
                $d_asunto ="PLATAFORMA: ".$nombreuser[0]." ".$_SESSION['userActivo']->paterno." ha $d_estado el documento ".$idceros;
                $d_cuerpo = $_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres." ha $d_estado el documento ".$idceros;
                $d_mensajefoot = "Para verificar el estado del mismo puede visitar nuestra página.<br>
                        <a href='".base_url()."tramites/consultar/expediente'>Consultar Estado</a>.";

                $pruebas_email=array();
                if ($acto=="RECIBIDO"){
                    $rpta=$this->mmesa_partes->m_ruta_recibir(array($_SESSION['userActivo']->idusuario,$seg,$rut,date('Y-m-d H:i:s'),$descp));
                    

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
                    $correo=trim($solicitud->corporativo_email);
                    if ($correo!=""){
                        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                            $d_destino[]=$correo;
                        }
                    } 
                        
                }
                elseif ($acto=="RECHAZADO") {
                    //CALL `sp_tb_mesa_partes_rechazar`( @vid_usuario, @vmpt_id, @vmpr_id, @vmpr_fecha_procesado, @s);
                    $rpta=$this->mmesa_partes->m_ruta_rechazar(array($_SESSION['userActivo']->idusuario,$seg,$rut,date('Y-m-d H:i:s'),$descp));

                    $emailenviador = $_SESSION['userActivo']->ecorporativo;
                    $nomenviador = $_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres;
                    $d_enviador = array($emailenviador,$nomenviador,$emailenviador);
                    $d_responder=array($emailenviador,$nomenviador);
                    //$enviar_mail=true;
                    // $d_asunto="Su trámite COD: $idceros fue RECHAZADO.";
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
                    $correo=trim($solicitud->corporativo_email);
                    if ($correo!=""){
                        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                            $d_destino[]=$correo;
                        }
                    }   
                    $d_cuerpo = $solicitud->solicitante."<br>El documento N° $idceros fue RECHAZADO por ".$_SESSION['userActivo']->nombres." ".$_SESSION['userActivo']->paterno;
                    $d_mensaje = "<b>Mensaje: </b>".$descp;

                    //if ($rpta->salida=="1") $dataex['status'] = true;
                }
                elseif ($acto=="DERIVADO") {
                    
                    if ((trim($idadmin)=="") || ($idadmin=="0")){
                        $validar=false;
                        $dataex['msg']    = "Debes seleccionar el USUARIO a quien va dirigido";
                    }
                    if ((trim($idarea)=="") || ($idarea=="0")){
                        $validar=false;
                        $dataex['msg']    = "Debes seleccionar el ÁREA a donde va dirigido";
                    }
                    if ($validar==true){
                        $idarea = base64url_decode($idarea);
                        $idadmin = base64url_decode($idadmin);
                        $emailenviador = $_SESSION['userActivo']->ecorporativo;
                        $nomenviador = $_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres;
                        $d_enviador = array($emailenviador,$nomenviador,$emailenviador);
                        $emaildestino = $this->mmesa_partes->getusuarioxcodigo(array($idadmin));
                        $nomdestino="";
                        if (isset($emaildestino->emailus)){
                            $correo=trim($emaildestino->emailus);
                            if ($correo!=""){
                                if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                                    $d_destino[]=$correo;
                                    $nomdestino="Estimado(a) $emaildestino->nombres $emaildestino->paterno <br>";
                                    //$r_respondera=array($correo,$nombres);
                                }
                            }
                        }
                        

                        
                        $mpremail = "";
                        if (isset($_POST['vw_mpc_email_cc'])) {
                            $d_copia = json_decode($_POST['vw_mpc_email_cc']);
                            $rptampr = implode(",",$d_copia);
                            $mpremail = $rptampr;
                        }
                        
                        $rpta=$this->mmesa_partes->m_ruta_derivar(array($_SESSION['userActivo']->idusuario,$seg,$rut,date('Y-m-d H:i:s'),$descp,$idarea,$idadmin,$_SESSION['userActivo']->idarea, $mpremail));
                        if ($rpta->salida=="1"){
                            $ruta_tramite =$rpta->nid;
                            $rut =$rpta->nid;
                        }
                        //$enviar_mail=true;
                        $d_asunto = "PLATAFORMA: ".$nombreuser[0]." ".$_SESSION['userActivo']->paterno." ha derivado el documento ".$idceros;
                        $d_cuerpo = $nomdestino.$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres." le ha derivado el documento ".$idceros;
                        $d_mensaje = "<b>Mensaje: </b>".$descp;
                        $d_mensajefoot = "Puedes verificar el trámite en MESA DE PARTES de la Plataforma Virtual.";
                    }
                }
                elseif ($acto=="FINALIZADO") {
                    $idarea = base64url_decode($idarea);
                    $idadmin = base64url_decode($idadmin);

                    $emailenviador = $_SESSION['userActivo']->ecorporativo;
                    $nomenviador = $_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres;
                    $d_enviador = array($emailenviador,$nomenviador,$emailenviador);
                    $d_responder=array($emailenviador,$nomenviador);
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
                    $correo=trim($solicitud->corporativo_email);
                    if ($correo!=""){
                        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                            $d_destino[]=$correo;
                        }
                    }  

                    $mpremail = "";
                    if (isset($_POST['vw_mpc_email_cc'])) {
                        $d_copia = json_decode($_POST['vw_mpc_email_cc']);

                        $rptampr = implode(",",$d_copia);
                        $mpremail = $rptampr;
                    }

                    $rpta=$this->mmesa_partes->m_ruta_finalizar(array($_SESSION['userActivo']->idusuario,$seg,$rut,date('Y-m-d H:i:s'),$descp,$idarea,$idadmin,$_SESSION['userActivo']->idarea, $mpremail));
                    if ($rpta->salida=="1"){
                        $ruta_tramite =$rpta->nid;
                        $rut =$rpta->nid;
                    }   
                    //$enviar_mail=true;
                    
                    
                    $d_cuerpo = $solicitud->solicitante."<br>El documento N° $idceros fue completado por ".$_SESSION['userActivo']->nombres." ".$_SESSION['userActivo']->paterno;
                    $d_mensaje = "<b>Mensaje: </b>".$descp;
                    
                    $d_mensajefoot = "Para verificar el estado del mismo puede visitar nuestra pagina.<br>
                    <a href='".base_url()."tramites/consultar/expediente'>Consultar Estado</a>.";
                }
                if ($validar==true){
                    if ($rpta->salida=="1"){
                        $data          = json_decode($_POST['vw_mpc_archivos']);
                        $pathtodir =  getcwd() ; 
                        $allfiles=true;
                        foreach ($data as $key => $fl) {
                            $rptafil = $this->mmesa_partes->insert_archivos_mesa_partes(array($seg,$rut,$fl[4],$fl[0],$fl[1],$fl[2],$fl[3]));
                            if ($rptafil=="1"){
                                
                                $link=$fl[0];
                                $namefile = $fl[1];
                                $typefile = $fl[3];
                                $copied = copy($pathtodir."/upload/tramites/tmp/".$link  , $pathtodir."/upload/tramites/".$link);

                                $pruebas_email[] = array($pathtodir."/upload/tramites/".$link, $namefile, $typefile);
                                
                                if ((!$copied)) 
                                { 
                                    $allfiles=false;
                                }
                            }
                        }
                        $contenidobs = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", ha $d_estado un tramite en la tabla TB_MESA_PARTES COD:".$seg." RUTA:".$ruta_tramite;

                        $e_mensaje=$this->load->view('emails/vw_notificar_tramite', array('ies'=> $iestp,'cuerpo'=>$d_cuerpo,'mensaje'=>$d_mensaje,'footmsg' => $d_mensajefoot ),true);

                        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
                            $rsp_email=$this->f_sendmail_directo($d_enviador,$d_destino,array(),array(),$d_asunto,$e_mensaje,$pruebas_email,$d_responder);
                            if ($rsp_email['estado'] == false) {
                                $this->mcorreos->mInsert_correo_notificaciones(array($ruta_tramite,json_encode($d_enviador),json_encode($d_destino),$d_asunto,$e_mensaje,$acto,"",json_encode($d_responder),$contenidobs,"MESA",json_encode($d_copia),json_encode($d_oculto)));
                            }
                        } else {
                            $this->mcorreos->mInsert_correo_notificaciones(array($ruta_tramite,json_encode($d_enviador),json_encode($d_destino),$d_asunto,$e_mensaje,$acto,"",json_encode($d_responder),$contenidobs,"MESA",json_encode($d_copia),json_encode($d_oculto)));
                        }

                        
                    }
                    if ($allfiles==true){
                        $dataex['status'] = true;
                    }
                }
                else{
                    $dataex['status'] = false;
                }
            }    
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function vw_consultar_expediente()
    {
        $ahead = array('page_title' => 'IESTWEB | MESA DE PARTES - EXPEDIENTE');
        $this->load->view('tramites/mesa_partes/vw_seguimiento_expediente_externo', $ahead);
    }

    public function vw_expediente_solicitud_ruta()
    {
        $dataex['status'] = false;
        $dataex['msg']    = "No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

        if ($this->input->is_ajax_request()) {
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('vw_mp_txt_codseguim', 'Cod. Seguimiento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_anio', 'Año', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = "Existen errores en los campos";
                $errors        = array();
                foreach ($this->input->post() as $key => $value) {
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            } 
            else {
                $seg = $this->input->post('vw_mp_txt_codseguim');
                $anio = $this->input->post('vw_mp_txt_anio');
                $dataex['status'] = true;
                $rptamp = $this->mmesa_partes->m_obtenercodigo_mesa(array($seg, $anio));
                $dataex['tramite'] = $rptamp;
                if(@count($rptamp) > 0) {
                    $arraytip = $this->mmesa_partes->m_solicitud_ruta_x_codigoanio(array($rptamp->codsolicitud, $anio));
                    $dataex['datos'] = $this->load->view('tramites/mesa_partes/vw_result_seguimiento_expediente', $arraytip, true);
                } else {
                    $dataex['datos'] = "<span class='text-danger'>Su busqueda no obtuvo resultados</span>";
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
        $asidebar = array('menu_padre' => 'mn_mesa', 'menu_hijo' => 'mn_mesa');
        $vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        
        $this->load->view($vsidebar, $asidebar);
        $this->load->model("musuario");
        $arraytip = $this->musuario->m_perfil($_SESSION['userActivo']->codpersona);
        $arraytip['tipos'] = $this->mmesa_partes->m_lts_tipo_tramite();

        $arraytip['ciclos'] =$this->mtemporal->m_get_ciclos();
        $arraytip['periodos'] =$this->mperiodo->m_get_periodos();
        $arraytip['secciones'] = $this->mtemporal->m_get_secciones();
        $arraytip['turnos'] =$this->mtemporal->m_get_turnos_activos();
        $arraytip['carreras'] = $this->mcarrera->m_get_carreras_por_sede_tram(array($_SESSION['userActivo']->idsede));
        $arraytip['insc'] = ($_SESSION['userActivo']->tipo == 'AL') ? $this->mmesa_partes->m_datos_inscrito($_SESSION['userActivo']->codentidad) : "";
        
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
        $arraytip['tipos'] = $this->mmesa_partes->m_lts_tipo_tramite();
        $arraytip['sedes'] = $this->msede->m_get_sedes_activos();
        $arraytip['ciclos']=$this->mtemporal->m_get_ciclos();
        $arraytip['periodos']=$this->mperiodo->m_get_periodos();
        $arraytip['secciones'] = $this->mtemporal->m_get_secciones();
        $arraytip['turnos']=$this->mtemporal->m_get_turnos_activos();
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
    
    /*public function fn_insert()
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
            //$this->form_validation->set_rules('vw_mp_txt_folios', 'N° Folios', 'trim|required');
            //$this->form_validation->set_rules('vw_mp_txt_ndocument', 'N° Documento', 'trim|required');
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
               
                $sede = $_SESSION['userActivo']->idsede;
                

                $rpta = $this->mmesa_partes->insert_datos_mesa_partes(array($user, $tramite, $asunto, $folios, $nrodocumento, $tipersona, $tipdoc, $nro_documento, $nombres, $detalle, $domicilio, $telefono, $correo, $vccorporativo,$varea,$anio,$vlugar,$sede));
                 $dataex['status1'] =$rpta;
                if ($rpta->salida=="1"){
                    $data          = json_decode($_POST['vw_mpc_archivos']);
                    
                    $idceros = $rpta->codseg;
                    $pathtodir =  getcwd() ; 
                    $allfiles=true;
                    $pruebas=array();
                    $pruebas_email=array();
                    foreach ($data as $key => $fl) {
                        
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

                        $a_pdf = new stdClass;
                        
                        $a_pdf->id=$rpta->nid;
                        $a_pdf->codseg=$idceros;
                        $a_pdf->fecha=date("Y-m-d H:i:s");
                       
                        $this->load->model('miestp');
                        $iestp=$this->miestp->m_get_datos();
                        
                        //ENVIAR CONSTANCIA A ALUMNO
                        $email_mesa = $this->msede->m_get_sede_config_x_codigo(array($sede));
                        $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                        $d_enviador_solicitante=array('notificaciones@'.getDominio(),$nombres);
                        
                        $arraymail = explode(",", $correo);
                        // $arraymail2 = array($email_mesa->email_mesa, $_SESSION['userActivo']->ecorporativo);
                        // $d_destino= array_merge($arraymail, $arraymail2);
                        $d_destino= $arraymail;
                        $arraymail2 = explode(",", $email_mesa->email_mesa);
                        $d_destino2= $arraymail2;
                        $d_asunto= $asunto;

                        $r_respondera=array($arraymail[0],$nombres);

                        $pdfficha = $this->pdf_ficha_tramite_mail(base64url_encode($rpta->nid));
                        $pruebas_email[]=array($pdfficha, 'attachment',"TRAMITE N°".$idceros.".pdf","application/pdf");

                        // =================================
                        // ENVIO A ESTUDIANTE O SOLICITANTE
                        // =================================
                        if ($d_destino != "") {
                            
                            $d_mensaje=$this->load->view('emails/vw_notificar_envio_tramite', array('tmt' => $a_pdf,'ies'=> $iestp, 'mensaje' => 'Su tramite fue enviado con éxito', 'respuesta' => 'No responder a este correo porque no es monitoreado' ),true);
                            $rsp_iesap=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email,'');
                            sleep(6);
                        }
                        // ================================
                        // ENVIO A MESA DE PARTES
                        // ================================

                        if ($d_destino2 != "") {
                            //ENVIO A MESA DE PARTES
                            //$detalle, $domicilio, $telefono, $correo,
                            $mesaje="Se a ingresado un tramite por mesa de partes:<br><br>Solicitante: <b>$nombres</b><br>
                            Asunto: <b>$d_asunto</b><br>
                            Detalle: <br><br><br>
                            $detalle<br><br>
                            Domicilio: <b>$domicilio</b><br>
                            Teléfono: <b>$telefono</b><br>
                            Correo: <b>$correo</b><br>";
                            $d_mensaje2=$this->load->view('emails/vw_notificar_tramite_a_administrativo', array('tmt' => $a_pdf,'ies'=> $iestp, 'mensaje' => $mesaje, 'respuesta' => '' ),true);
                            $rsp_iesap2=$this->f_sendmail_adjuntos($d_enviador_solicitante,$d_destino2,"PLATAFORMA: ".$d_asunto,$d_mensaje2,$pruebas_email,$r_respondera);
                        }

                        
                        $dataex['msg']='<span class="h5"><i class="far fa-check-circle text-success"></i> Su reporte fue enviado correctamente</span>';
                        $dataex['status'] =true;
                        $dataex['codseg'] =$rpta->codseg;
                        
                        // $dataex['linkpdf']=base_url()."tramites/mesa-de-partes/constancia-pdf?cinc=".base64url_encode($rpta->nid);
                        
                        $dataex['rsm_iesap']=$rsp_iesap;
                        $dataex['rsm_iesap2']=$rsp_iesap2;
                        $dataex['destinos'] = $d_destino;
                        $dataex['destinos2'] = $d_destino2;
                        
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
    }*/
    public function fn_insert()
    {
        $this->form_validation->set_message('required', '* %s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
        $this->form_validation->set_message('valid_email', '* Debes ingresar solo 1 {field} válido.');

        $dataex['status'] = false;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request()) {
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('vw_mp_cb_tramite', 'Tipo trámite', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_asunto', 'Asunto solicitud', 'trim|required');
            $this->form_validation->set_rules('vw_mp_cb_tdoc', 'Tipo documento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_nro_doc', 'N° documento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_apelnom', 'Apellidos y nombres', 'trim|required');
            //$this->form_validation->set_rules('vw_mp_txt_folios', 'N° Folios', 'trim|required');
            //$this->form_validation->set_rules('vw_mp_txt_ndocument', 'N° Documento', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_tippersona', 'Tipo Persona', 'trim|required');
            //$this->form_validation->set_rules('vw_mp_txt_contenido', 'Detalle', 'trim|required');
            //$this->form_validation->set_rules('vw_mp_txt_domicilio', 'domicilio', 'trim|required');
            //$this->form_validation->set_rules('vw_mp_txt_celular', 'Teléfono', 'trim|required');
            $this->form_validation->set_rules('vw_mp_txt_email', 'Email Personal', 'trim|valid_email');
            $this->form_validation->set_rules('vw_mp_txt_email_corporativo', 'Email institucional', 'trim|valid_email');
            $this->form_validation->set_rules('vw_mp_cb_situacion', 'Situación actual', 'trim|required');

            $situacionest = $this->input->post('vw_mp_cb_situacion');
            if (($situacionest == "Soy estudiante Activo")||($situacionest == "Soy Estudiante Retirado")||($situacionest == "Soy Egresado")||($situacionest == "Soy Titulado")) {
                $this->form_validation->set_rules('vw_mp_txt_programa', 'Programa', 'trim|required');
            }
            
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

                $vccorporativo    = $this->input->post('vw_mp_txt_email_corporativo');

                // $situacionest = $this->input->post('vw_mp_cb_situacion');
                $carne = $this->input->post('vw_mp_txt_carne');
                $periodo = $this->input->post('vw_mp_txt_periodo');
                $programa = $this->input->post('vw_mp_txt_programa');
                $semestre = $this->input->post('vw_mp_txt_semestre');
                $turno = $this->input->post('vw_mp_txt_turno');
                $seccion = $this->input->post('vw_mp_txt_seccion');

                $anio=date("Y");
                if (getPermitido("68")=="SI"){
                    $vlugar="MP";
                }
                else{
                    $vlugar="MV";
                }
                // $vccorporativo="";
                $varea=null;
                if (isset($propio)) {
                    $vlugar="MP";
                    if ($vccorporativo == "") {
                        $vccorporativo=$_SESSION['userActivo']->ecorporativo;
                    }
                    
                    $$varea=$_SESSION['userActivo']->idarea;
                }
               
                $sede = $_SESSION['userActivo']->idsede;
                

                $rpta = $this->mmesa_partes->insert_datos_mesa_partes(array($user, $tramite, $asunto, $folios, $nrodocumento, $tipersona, $tipdoc, $nro_documento, $nombres, $detalle, $domicilio, $telefono, $correo, $vccorporativo,$varea,$anio,$vlugar,$sede,$situacionest,$carne,$periodo,$programa,$semestre,$turno,$seccion));
                 $dataex['status1'] =$rpta;
                if ($rpta->salida=="1"){
                    $data          = json_decode($_POST['vw_mpc_archivos']);
                    
                    $idceros = $rpta->codseg;
                    $pathtodir =  getcwd() ; 
                    $allfiles=true;
                    $pruebas=array();
                    $pruebas_email=array();
                    foreach ($data as $key => $fl) {
                        
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

                        $a_pdf = new stdClass;
                        
                        $a_pdf->id=$rpta->nid;
                        $a_pdf->codseg=$idceros;
                        $a_pdf->fecha=date("Y-m-d H:i:s");
                       
                        $this->load->model('miestp');
                        $iestp=$this->miestp->m_get_datos();
                        
                        // ================================
                        // NOTIFICAR A MESA DE PARTES
                        // ================================
                        $sede_conf = $this->msede->m_get_sede_config_x_codigo(array($sede));
                        $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);

                        $d_destino=array();
                        $d_copia=array();
                        $d_oculto=array();
                        $d_asunto= "PLATAFORMA: Se ha ingresado el trámite N° ".$idceros." por mesa de partes";
                        $contenidobs="";

                        // $d_enviador_solicitante=array('notificaciones@'.getDominio(),$nombres);

                        if (isset($sede_conf->email_mesa)){
                            $arraymail = explode(",", $sede_conf->email_mesa);
                            foreach ($arraymail as $key => $d_email) {
                                if (filter_var($d_email, FILTER_VALIDATE_EMAIL)) {
                                    $d_destino[]=$d_email;
                                }
                            }

                            $carnetest = "";
                            $periodoest = "";
                            $carreraest = "";
                            $cicloest = "";
                            $turnoest = "";
                            $seccest = "";
                            $datampt = $this->mmesa_partes->m_solicitud_x_codigo(array($rpta->nid));
                            if (trim($carne)!=""){
                                $carnetest = "<li>Carné&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> $carne</b></li>";
                            }
                            if ($datampt['solicitud']->periodo != null){
                                $periodoest = "<li>Periodo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> ".$datampt['solicitud']->periodo."</b></li>";
                            }
                            if ($datampt['solicitud']->carrera != null){
                                $carreraest = "<li>Programa:<b> ".$datampt['solicitud']->carrera."</b></li>";
                            }
                            if ($datampt['solicitud']->ciclo != null){
                                $cicloest = "<li>Semestre&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> ".$datampt['solicitud']->ciclo."</b></li>";
                            }
                            if ($datampt['solicitud']->turno != null){
                                $turnoest = "<li>Turno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> ".$datampt['solicitud']->turno."</b></li>";
                            }
                            if ($datampt['solicitud']->seccion != null){
                                $seccest = "<li>Sección&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> ".$datampt['solicitud']->seccion."</b></li>";
                            }

                            $mesaje="Se a ingresado un tramite por mesa de partes:<br><br>Solicitante: <b>$nombres</b><br>
                            Situación actual: <b>$situacionest</b><br>
                            <ul>
                                $carnetest
                                $periodoest
                                $carreraest
                                $cicloest
                                $turnoest
                                $seccest
                            </ul>
                            Asunto: <b>$d_asunto</b><br>
                            Detalle: <br><br>
                            $detalle<br><br>
                            Domicilio: <b>$domicilio</b><br>
                            Teléfono: <b>$telefono</b><br>
                            Correo: <b>$correo</b><br>";
                            $d_mensaje2=$this->load->view('emails/vw_notificar_tramite_a_administrativo', array('tmt' => $a_pdf,'ies'=> $iestp, 'mensaje' => $mesaje, 'respuesta' => '' ),true);

                            //PARA MESA DE PARTES
                            $this->mcorreos->mInsert_correo_notificaciones(array($rpta->nid,json_encode($d_enviador),json_encode($d_destino),"PLATAFORMA: ".$d_asunto,$d_mensaje2,"CREADO","","",$contenidobs,"MESA",json_encode($d_copia),json_encode($d_oculto)));
                        }
                        
                        // $arraymail = explode(",", $correo);
                        // $arraymail2 = array($email_mesa->email_mesa, $_SESSION['userActivo']->ecorporativo);
                        // $d_destino= array_merge($arraymail, $arraymail2);
                        // $d_destino= $arraymail;
                        // $arraymail2 = explode(",", $sede_conf->email_mesa);
                        // $d_destino2= $arraymail2;
                        // $d_asunto= $asunto;

                        // $r_respondera=array($arraymail[0],$nombres);

                        // $pdfficha = $this->pdf_ficha_tramite_mail(base64url_encode($rpta->nid));
                        // $pruebas_email[]=array($pdfficha, 'attachment',"TRAMITE N°".$idceros.".pdf","application/pdf");

                        // =================================
                        // NOTIFICAR A ESTUDIANTE O SOLICITANTE
                        // =================================
                        $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                        $d_destino=array();
                        $d_copia=array();
                        $d_oculto=array();
                        $d_asunto= $asunto;

                        $arraymail = array($correo,$vccorporativo);
                        foreach ($arraymail as $key => $d_email) {
                            if (filter_var($d_email, FILTER_VALIDATE_EMAIL)) {
                                $d_destino[]=$d_email;
                            }
                        }

                        if (count($d_destino)>0){
                            $d_mensaje=$this->load->view('emails/vw_notificar_envio_tramite', array('tmt' => $a_pdf,'ies'=> $iestp, 'mensaje' => 'Su tramite fue enviado con éxito', 'respuesta' => 'No responder a este correo porque no es monitoreado' ),true);
                            //PARA SOLICITANTE
                            $this->mcorreos->mInsert_correo_notificaciones(array($rpta->nid,json_encode($d_enviador),json_encode($d_destino),$d_asunto,$d_mensaje,"CREADO","","",$contenidobs,"MESA",json_encode($d_copia),json_encode($d_oculto)));
                        }

                        
                        // $dataex['msg']='<span class="h5"><i class="far fa-check-circle text-success"></i> Su reporte fue enviado correctamente</span>';
                        $dataex['msg']='<div class="row justify-content-center"><div class="col-10"><span class="h5"><i class="far fa-check-circle text-success"></i> Su Trámite fue enviado con éxito</span><br><span class="text-danger font-weight-bold">Si ingresaste un correo válido y actualizado, llegará un mensaje a tu bandeja confirmándote la recepción de tu trámite. En caso no llegue revisa tu bandeja de correo SPAM y desbloquéalo</span><br><br><span>Código de Seguimiento <b class="h5">'.$idceros.'</b> Año <b class="h5">'.$anio.'</b></span></div></div>';
                        $dataex['status'] =true;
                        $dataex['codseg'] =$rpta->codseg;
                        
                        $dataex['linkpdf']=base_url()."tramites/mesa-de-partes/constancia-pdf?cinc=".base64url_encode($rpta->nid);
                        
                        
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
        $this->form_validation->set_message('required', '* %s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
        $this->form_validation->set_message('valid_email', '* Debes ingresar solo 1 {field} valido.');

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
            $this->form_validation->set_rules('vw_mp_txt_email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('vw_mp_txt_email_corporativo', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('vw_mp_cb_situacion', 'Situación actual', 'trim|required');
            $situacionest = $this->input->post('vw_mp_cb_situacion');
            if (($situacionest == "Soy estudiante Activo")||($situacionest == "Soy Estudiante Retirado")||($situacionest == "Soy Egresado")||($situacionest == "Soy Titulado")) {
                $this->form_validation->set_rules('vw_mp_txt_programa', 'Programa', 'trim|required');
            }

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
                $vccorporativo    = $this->input->post('vw_mp_txt_email_corporativo');

                $folios = $this->input->post('vw_mp_txt_folios');
                $nrodocumento = $this->input->post('vw_mp_txt_ndocument');
                $tipersona = $this->input->post('vw_mp_txt_tippersona');

                // $situacionest = $this->input->post('vw_mp_cb_situacion');
                $carne = $this->input->post('vw_mp_txt_carne');
                $periodo = $this->input->post('vw_mp_txt_periodo');
                $programa = $this->input->post('vw_mp_txt_programa');
                $semestre = $this->input->post('vw_mp_txt_semestre');
                $turno = $this->input->post('vw_mp_txt_turno');
                $seccion = $this->input->post('vw_mp_txt_seccion');

                $anio=date("Y");
                
                $vlugar="MV";
                
                // $vccorporativo="";
             
                $sede = $this->input->post('vw_mp_cb_sede');

                $rpta = $this->mmesa_partes->insert_datos_mesa_partes(array($user, $tramite, $asunto, $folios, $nrodocumento, $tipersona, $tipdoc, $nro_documento, $nombres, $detalle, $domicilio, $telefono, $correo, $vccorporativo,2,$anio,$vlugar,$sede,$situacionest,$carne,$periodo,$programa,$semestre,$turno,$seccion));
                 $dataex['status1'] =$rpta;
                if ($rpta->salida=="1"){
                    $idceros=$rpta->codseg;
                    $data          = json_decode($_POST['vw_mpc_archivos']);
                    $pathtodir =  getcwd() ; 
                    $allfiles=true;
                    //$pruebas=array();
                    //$pruebas_email=array();
                    foreach ($data as $key => $fl) {
                        $rptafil = $this->mmesa_partes->insert_archivos_mesa_partes(array($rpta->nid,NULL,$fl[4],$fl[0],$fl[1],$fl[2],$fl[3]));
                        if ($rptafil=="1"){
                            $copied=false;
                            $link=$fl[0];
                            $existefile=is_file($pathtodir."/upload/tramites/tmp/".$link);
                            if ($existefile==true){
                                $copied = copy($pathtodir."/upload/tramites/tmp/".$link  , $pathtodir."/upload/tramites/".$link);
                                $a_ppdf = new stdClass;
                               // $pruebas[]=$a_ppdf;
                                //$pruebas_email[]=array($pathtodir."/upload/tramites/".$link, 'attachment',$fl[1]);
                                $a_ppdf->titulo=$fl[4];
                            }
                           
                            
                            
                            if ((!$copied)) 
                            { 
                                $allfiles=false;
                            }

                        }
                    }
                    if ($allfiles==true){
                        $sede_conf = $this->msede->m_get_sede_config_x_codigo(array($sede));

                        $a_pdf = new stdClass;
                        
                        $a_pdf->id=$rpta->nid;
                        $a_pdf->codseg=$rpta->codseg;
                        $a_pdf->fecha=date("Y-m-d H:i:s"); 
                        
                        //NOTIFICAR A MESA DE PARTES
                        
                        $this->load->model('miestp');
                        $iestp=$this->miestp->m_get_datos();

                        
                        $d_enviador=array('notificaciones@'.getDominio(),$nombres);
                        $d_destino=array();
                        $d_copia=array();
                        $d_oculto=array();
                        $d_asunto= "Se ha ingresado el trámite N° ".$idceros." por mesa de partes";
                        $contenidobs="";
                        if (isset($sede_conf->email_mesa)){
                            $arraymail = explode(",", $sede_conf->email_mesa);
                            foreach ($arraymail as $key => $d_email) {
                                if (filter_var($d_email, FILTER_VALIDATE_EMAIL)) {
                                    $d_destino[]=$d_email;
                                }
                            }
                            $carnetest = "";
                            $periodoest = "";
                            $carreraest = "";
                            $cicloest = "";
                            $turnoest = "";
                            $seccest = "";
                            $datampt = $this->mmesa_partes->m_solicitud_x_codigo(array($rpta->nid));
                            if (trim($carne)!=""){
                                $carnetest = "<li>Carné&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> $carne</b></li>";
                            }
                            if ($datampt['solicitud']->periodo != null){
                                $periodoest = "<li>Periodo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> ".$datampt['solicitud']->periodo."</b></li>";
                            }
                            if ($datampt['solicitud']->carrera != null){
                                $carreraest = "<li>Programa:<b> ".$datampt['solicitud']->carrera."</b></li>";
                            }
                            if ($datampt['solicitud']->ciclo != null){
                                $cicloest = "<li>Semestre&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> ".$datampt['solicitud']->ciclo."</b></li>";
                            }
                            if ($datampt['solicitud']->turno != null){
                                $turnoest = "<li>Turno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> ".$datampt['solicitud']->turno."</b></li>";
                            }
                            if ($datampt['solicitud']->seccion != null){
                                $seccest = "<li>Sección&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b> ".$datampt['solicitud']->seccion."</b></li>";
                            }
                            $mesaje="Se a ingresado un tramite por mesa de partes:<br><br>Solicitante: <b>$nombres</b><br>
                            Situación actual: <b>$situacionest</b><br>
                            <ul>
                                $carnetest
                                $periodoest
                                $carreraest
                                $cicloest
                                $turnoest
                                $seccest
                            </ul>
                            Asunto: <b>$d_asunto</b><br>
                            Detalle: <br><br>
                            $detalle<br><br>
                            Domicilio: <b>$domicilio</b><br>
                            Teléfono: <b>$telefono</b><br>
                            Correo: <b>$correo</b><br>";
                            $d_mensaje2=$this->load->view('emails/vw_notificar_tramite_a_administrativo', array('tmt' => $a_pdf,'ies'=> $iestp, 'mensaje' => $mesaje, 'respuesta' => '' ),true);

                            //PARA MESA DE PARTES
                            $this->mcorreos->mInsert_correo_notificaciones(array($rpta->nid,json_encode($d_enviador),json_encode($d_destino),"PLATAFORMA: ".$d_asunto,$d_mensaje2,"CREADO","","",$contenidobs,"MESA",json_encode($d_copia),json_encode($d_oculto)));
                            
                        }

                        //NOTIFICAR A SOLICITANTE
                        $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                        $d_destino=array();
                        $d_copia=array();
                        $d_oculto=array();
                        $d_asunto= $asunto;
                        
                        $arraymail = array($correo,$vccorporativo);
                        foreach ($arraymail as $key => $d_email) {
                            if (filter_var($d_email, FILTER_VALIDATE_EMAIL)) {
                                $d_destino[]=$d_email;
                            }
                        }
                        
                        if (count($d_destino)>0){
                            $d_mensaje=$this->load->view('emails/vw_notificar_envio_tramite', array('tmt' => $a_pdf,'ies'=> $iestp, 'mensaje' => 'Su tramite fue enviado con éxito', 'respuesta' => 'No responder a este correo porque no es monitoreado' ),true);
                            //PARA SOLICITANTE
                            $this->mcorreos->mInsert_correo_notificaciones(array($rpta->nid,json_encode($d_enviador),json_encode($d_destino),$d_asunto,$d_mensaje,"CREADO","","",$contenidobs,"MESA",json_encode($d_copia),json_encode($d_oculto)));
                        }
                            
                        
                        
                        $dataex['msg']='<div class="row justify-content-center"><div class="col-10"><span class="h5"><i class="far fa-check-circle text-success"></i> Su Trámite fue enviado con éxito</span><br><span class="text-danger font-weight-bold">Si ingresaste un correo válido y actualizado, llegará un mensaje a tu bandeja confirmándote la recepción de tu trámite. En caso no llegue revisa tu bandeja de correo SPAM y desbloquéalo</span><br><br><span>Código de Seguimiento <b class="h5">'.$idceros.'</b> Año <b class="h5">'.$anio.'</b></span></div></div>';
                        $dataex['msgcnst']='<span class="text-danger">Recuerda que puedes consultar el estado de tu trámite aquí </span>
                                    <i class="fas fa-arrow-up fa-2x"></i>';
                        $dataex['status'] =true;
                        $dataex['nid']=$idceros;
                        $dataex['destino']=implode(",", $d_destino);
                        //$dataex['linkpdf']=base_url()."tramites/mesa-de-partes/constancia-pdf?cinc=".base64url_encode($rpta->nid);
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

    public function pdf_ficha_tramite_mail($codmt)
    {

        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

            $codmt=base64url_decode($codmt);
            
            $this->load->model('miestp');
            $ie=$this->miestp->m_get_datos();
            
            $tmp=$this->mmesa_partes->m_solicitud_x_codigo(array($codmt));
            
            $dominio=str_replace(".", "_",getDominio());
            $html1=$this->load->view("tramites/mesa_partes/pdf_formato_externo", array('ies' => $ie,'tmps'=>$tmp),true);
           
            $pdfFilePath = "TRAMITE N°".$tmp['solicitud']->codseg.".pdf";

            $this->load->library('M_pdf');
            $formatoimp="A4";
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]);
            $mpdf->SetTitle( "TRAMITE N°".$tmp['solicitud']->codseg);
            $mpdf->WriteHTML($html1);
            
            return $mpdf->Output($pdfFilePath, "S");
    }

    public function pdf_ficha_tramite($codmt)
    {

        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

            $codmt=base64url_decode($codmt);
            
            $this->load->model('miestp');
            $ie=$this->miestp->m_get_datos();
            
            $tmp=$this->mmesa_partes->m_solicitud_x_codigo(array($codmt));
            
            $dominio=str_replace(".", "_",getDominio());
            $html1=$this->load->view("tramites/mesa_partes/pdf_formato_externo", array('ies' => $ie,'tmps'=>$tmp),true);
           
            $pdfFilePath = "TRAMITE N°".$tmp['solicitud']->codseg.".pdf";

            $this->load->library('M_pdf');
            $formatoimp="A4";
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]);
            $mpdf->SetTitle( "TRAMITE N°".$tmp['solicitud']->codseg);
            $mpdf->WriteHTML($html1);
            
            $mpdf->Output($pdfFilePath, "I");
    }

    public function search_list_tramites()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
    
        $dataex['status'] =FALSE;
        
        $dataex['msg']    = '¿Que Intentas?.';
        $rspreinsc = "";
        $dataex['conteo'] = 0;
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
                $this->form_validation->set_rules('situacion','situación','trim|required');
                $this->form_validation->set_rules('tramite','tramite','trim|required');
            
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
                $situacion = $this->input->post('situacion');
                $tipo = $this->input->post('tramite');
                $tramite = ($tipo === "%") ? $tipo : base64url_decode($tipo);
                $busqueda = $this->input->post('buscar');
                $busqueda=str_replace(" ","%",$busqueda);

                $vperm68 = $this->input->post('vper68');
                
                $sede = $_SESSION['userActivo']->idsede;

                $databuscar=array();

                $inicio = $this->input->post("inicio");
                $limite = $this->input->post("limite");
                
                if ($vperm68 == "SI") {
                    $rsdata = $this->mmesa_partes->m_solicitudes_to_mesa_partes($inicio,$limite,array($tramite,"%".$busqueda."%",$situacion,$sede));
                } else {
                    if ($situacion=="ATENDIDO"){
                        $rsdata = $this->mmesa_partes->m_solicitudes_x_area_origen_finalizado($inicio,$limite,array($_SESSION['userActivo']->idarea,$_SESSION['userActivo']->idusuario,$tramite,"%".$busqueda."%","ENVIADO",$sede));
                    }
                    else{
                        $rsdata = $this->mmesa_partes->m_solicitudes_x_area_destino($inicio,$limite,array($_SESSION['userActivo']->idarea,$_SESSION['userActivo']->idusuario,$tramite,"%".$busqueda."%",$situacion));
                    }
                }
                
                
                $rsdata['inicio'] =$inicio;
                $rsdata['solicitudes'] = $rsdata['items'];

                if ($rsdata['numitems'] > 0) {
                    $dataex['status'] = true;
                    
                    $dataex['numitems'] = $rsdata['numitems'];
                    if ($vperm68 == "SI") {
                        $datos = $this->load->view('tramites/mesa_partes/vw_administrativo_mesa_receptor_detalle', $rsdata, true);
                    } else {
                        $datos = $this->load->view('tramites/mesa_partes/vw_administrativo_mesa_detalle', $rsdata, true);
                    }
                } else {
                    $datos = "<div class='text-danger h6'>No hay datos para mostrar</div>";
                    $dataex['numitems'] = 0;
                }
                
                
            }
        }

        $dataex['vdata'] = $datos;
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function vw_administrativo_envio_correos()
    {
        $ahead = array('page_title' => 'CORREOS | MESA DE PARTES');
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        $asidebar = array('menu_padre' => 'mn_tramites', 'menu_hijo' => 'mn_mesa');
        $vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        $this->load->view($vsidebar, $asidebar);
        $this->load->view('correos_por_borrar');
        $this->load->view('footer');
    }

    public function fn_carreras_sedes()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        $rsoptions="<option value='0'>Sin opciones</option>";
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigosed','Búsqueda','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']=validation_errors();
            }
            else
            {
                $busqueda = $this->input->post('txtcodigosed');

                $carreras = $this->mcarrera->m_get_carreras_por_sede_tram(array($busqueda));

                if (count($carreras)>0) $rsoptions="<option value=''>Seleccione programa</option>";
                foreach ($carreras as $car) {
                    $rsoptions=$rsoptions."<option value='$car->codcarrera'>$car->nombre</option>";
                }
                $dataex['status'] =TRUE;
            }
        }
        $dataex['vdata'] =$rsoptions;
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }
    

    
}

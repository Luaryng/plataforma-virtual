<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Monitoreo_docente extends CI_Controller {
	function __construct() {
		parent::__construct();
//		$this->load->model('macciones');
		}
	
	public function vw_principal(){
        $ahead= array('page_title' =>'IESTWEB - Seguimiento de Docentes'  );
        $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-docentes');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);

        if (getPermitido("38")=='SI'){
            $codperiodo=$this->input->get('pd', TRUE);
            $tab=$this->input->get('tb', TRUE);
            $arraymc['periodo'] = $codperiodo;
            $this->load->model('mdocentes');
            $data['docentes']=array();
            if ($tab=="a"){
                if ($codperiodo!==""){
                    $data['docentes'] = $this->mdocentes->m_docentes_x_periodo(array($codperiodo));
                }
            }
            else if ($tab=="e"){
                if ($codperiodo!==""){
                    //$data['docentes'] = $this->mdocentes->m_docentes_x_periodo(array($codperiodo));
                }
            }
            
            $arraymc['accesos'] = $this->mdocentes->m_monitoreo_accesos();
            
            $this->load->model('mperiodo');
            $data['periodos']=$this->mperiodo->m_get_periodos();    
            $data['periodo'] = $codperiodo;
            $arraymc['resultados']=$this->load->view('monitoreo/docente/vw_docentes_periodo', $data,true);
            $this->load->view('monitoreo/docente/index', $arraymc);
        }
        else{
            $this->load->view('errors/sin-permisos');   
        }
        $this->load->view('footer');
	}

    public function vw_docentes_periodo()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
        $dataex['status'] = false;
        $urlRef           = base_url();
        $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
        $rst              = "";
        $mien             = "";
        $this->form_validation->set_rules('cbperiodo', 'Periodo', 'trim|required');
        //$this->form_validation->set_rules('txtbusca_apellnom', 'Apellidos y nombres', 'trim|required|min_length[6]|max_length[50]');
        $salida="<h4>SIN RESULTADOS</h4>";
        if ($this->form_validation->run() == false) {
            $dataex['msg'] = validation_errors();
        } 
        else {
            $cbper     = $this->input->post('cbperiodo');
            //$tcar      = $this->input->post('txtbusca_apellnom')."%";
            $this->load->model('mdocentes');
            $data['docentes'] = $this->mdocentes->m_docentes_x_periodo(array($cbper));
            $data['periodo'] = $cbper;

            $salida=$this->load->view('monitoreo/docente/vw_docentes_periodo', $data,true);
             
            $dataex['status'] = true;
        }
        $dataex['docentes'] = $salida;
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function vw_cursos_docente($coddocente,$codperiodo){
        $ahead= array('page_title' =>'MONITOREO - DOCENTE | ERP'  );
        $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-docentes');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);
        if (getPermitido("38")=='SI'){
            $codperiodo=base64url_decode($codperiodo);
            $coddocente=base64url_decode($coddocente);
            $this->load->model('mdocentes');
            $resultado=$this->mdocentes->m_cursos_x_docente(array($coddocente,$codperiodo));
            $docente=$resultado['docente'];
            $arraymc['docente'] = $docente;
            $arraymc['cursos'] = $resultado['cursos'];
            $arraymc['vcodperiodo'] =$codperiodo;

            $ses_usuario = $_SESSION['userActivo'];
            $contenido = "$ses_usuario->usuario - $ses_usuario->paterno $ses_usuario->materno $ses_usuario->nombres, monitoreo a $docente->paterno $docente->materno $docente->nombres COD: $coddocente Periodo: $codperiodo";
            $this->mauditoria->insert_datos_auditoria(array($ses_usuario->idusuario, 'SELECT', $contenido, $ses_usuario->idsede));

            $this->load->view('monitoreo/docente/vw_cursos_x_docente', $arraymc);
        }
        else{
            $this->load->view('errors/sin-permisos');   
        }
        
        $this->load->view('footer');

    }

    public function vw_cursos_docente_estadistica($coddocente,$codperiodo){

        if (getPermitido("38")=='SI'){
            $codperiodo=base64url_decode($codperiodo);
            $coddocente=base64url_decode($coddocente);
            $this->load->model('mdocentes');
            $resultado=$this->mdocentes->m_cursos_x_docente(array($coddocente,$codperiodo));
            $estd=$this->mdocentes->m_monitoreo_estadistica(array($coddocente,$codperiodo));

            
            $docente = $resultado['docente'];
            $cursos = $resultado['cursos'];
            $estd['docente']=$docente;
            $estd['cursos']=$cursos;

            $html1=$this->load->view('monitoreo/docente/informes/vw_pg1',$estd ,true);

            $pdfFilePath = "INF_AVAN_CURR_".$codperiodo." ".$docente->paterno."_".$docente->materno."_".$docente->nombres.".pdf";

            $ses_usuario = $_SESSION['userActivo'];
            $contenido = "$ses_usuario->usuario - $ses_usuario->paterno $ses_usuario->materno $ses_usuario->nombres, descargó el reporte estadístico de $docente->paterno $docente->materno $docente->nombres COD: $coddocente Periodo: $codperiodo";
            $this->mauditoria->insert_datos_auditoria(array($ses_usuario->idusuario, 'SELECT', $contenido, $ses_usuario->idsede));

            $this->load->library('M_pdf');
            $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
            $mpdf->shrink_tables_to_fit = 1;
            $mpdf->SetTitle( "$docente->paterno $docente->materno $docente->nombres");
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath,"D");  //TAMBIEN I para en linea*/
        }

    }

    

    public function vw_crear_cuestionario_dd()
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            
            $ahead= array('page_title' =>'MONITOREO - ALUMNO | ERP'  );
            $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-docentes');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            
            $tipo=$this->input->get('tp');
            $codperiodo=$this->input->get('pd');
            $this->load->model('mperiodo');
            $vwarray= array('vcperiodos' => $this->mperiodo->m_get_periodos(),'vcodperiodo'=>$codperiodo);
            
            /*switch ($tipo) {
                case 'V': //EVALUACIÓN
                    $arraymc['varchivos'] =array();
                    $arraymc['agregar'] = $this->load->view('virtual/vw_aula_add_evaluacion',array(),true);
                    break;
                case 'C'://FORO
                    $arraymc['varchivos'] =array();
                    $arraymc['agregar'] = $this->load->view('virtual/vw_',array(),true);
                    break;
            }*/
            

            $this->load->view('sidebar',$asidebar);

            $this->load->view('monitoreo/docente/vw_cuestionario_crear',$vwarray);
            $this->load->view('footer');
            
        }
        else{
            $this->vwh_nopermitido("CURSO - NO AUTORIZADO");
        }
    }

    public function vw_editar_cuestionario_dd($codcuge)
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            $codcuge=base64url_decode($codcuge);
            $this->load->model('mcuestionario_general');
            $vcencuesta=$this->mcuestionario_general->m_get_cuestionario_x_codigo(array($codcuge));
            if (isset($vcencuesta->codigo)){
                $ahead= array('page_title' =>'MONITOREO - ALUMNO | ERP'  );
                $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-docentes');
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $this->load->model('mperiodo');
                $vwarray= array('vcperiodos' => $this->mperiodo->m_get_periodos(),'vcencuesta'=>$vcencuesta);
                $this->load->view('sidebar',$asidebar);
                $this->load->view('monitoreo/docente/vw_cuestionario_crear',$vwarray);
                $this->load->view('footer');
            }
            else{
                $this->vwh_noencontrado();
            }
        }
        else{
            $this->vwh_nopermitido("CURSO - NO AUTORIZADO");
        }
    }

    public function vw_resultados_cuestionario_dd($codcuge)
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            $codcuge_deco=base64url_decode($codcuge);
            $this->load->model('mcuestionario_general');
            $vcencuesta=$this->mcuestionario_general->m_get_cuestionario_x_codigo(array($codcuge_deco));
            if (isset($vcencuesta->codigo)){
                $ahead= array('page_title' =>'MONITOREO - DOCENTES | ERP'  );
                $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-docentes');
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $this->load->model('mdocentes');
                $vwarray= array('vccodencuesta'=>$codcuge,'vcdocentes' => $this->mdocentes->m_get_docentes(),'vcencuesta'=>$vcencuesta);
                $this->load->view('sidebar',$asidebar);
                $this->load->view('monitoreo/docente/vw_cuestionario_resultados',$vwarray);
                $this->load->view('footer');
            }
            else{
                $this->vwh_noencontrado();
            }
        }
        else{
            $this->vwh_nopermitido("CURSO - NO AUTORIZADO");
        }
    }



    public function fn_get_encuesta_resultados()
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
            $rst              = "";
            $mien             = "";
            $this->form_validation->set_rules('cbdocente', 'Docente', 'trim|required');
            $this->form_validation->set_rules('codencuesta', 'Encuesta', 'trim|required');
            //$this->form_validation->set_rules('txtbusca_apellnom', 'Apellidos y nombres', 'trim|required|min_length[6]|max_length[50]');
            $salida="<h4>SIN RESULTADOS</h4>";
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } 
            else {
                $coddoc    = $this->input->post('cbdocente');
                $codenc    = base64url_decode($this->input->post('codencuesta'));
                $this->load->model('mcuestionario_general');
                $this->load->model('mcuestionario_gen_resultados');
                
                $dataex['preguntas'] = $this->mcuestionario_general->m_get_preguntas_x_cuestionario(array($codenc));
                $rps= $this->mcuestionario_general->m_get_respuestas_x_cuestionario(array($codenc));
                $rpsc= $this->mcuestionario_gen_resultados->m_conteo_rpta_x_cuge_docente(array($codenc,$coddoc));
                $esput= $this->mcuestionario_gen_resultados->m_estado_envios_x_cuge_docente(array($codenc,$coddoc));

                $dataex['estado']=$esput['estado'];
                $dataex['puntajes']=$esput['puntajes'];
                $pobtenidos=0;
                $respuestas=array();
                foreach ($rps as $key => $rp) {
                    $rp->total=0;
                    foreach ($rpsc as $key => $rpc) {
                        if (($rpc->codpregunta==$rp->codpregunta) && ($rpc->codrespuesta==$rp->codrpta)){
                            $rp->total=$rpc->total;
                            if (!isset($respuestas[$rp->codpregunta]['total'])) $respuestas[$rp->codpregunta]['total'] = 0;
                            $respuestas[$rp->codpregunta]['total'] = $respuestas[$rp->codpregunta]['total'] + $rp->total;
                            $pobtenidos=$pobtenidos + ($rpc->total * $rpc->puntos);
                            unset($rpsc[$key]);
                        }
                    }
                    $respuestas[$rp->codpregunta]['rpta'][] =$rp;

                }
                $dataex['respuestas']= $respuestas;
                $dataex['ptotal']= $pobtenidos;
                $dataex['status'] = true;
                $dataex['msg']   ="";
            }
        }
        else{
            $dataex['msg']    = 'No Autorizado';
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));

    }

     public function vw_curso_evaluaciones($codcarga,$division)
    {


        if ((getPermitido("51")=='SI') && ($_SESSION['userActivo']->tipo != 'AL')){
             $ahead= array('page_title' =>'Seguimiento de Docentes - Evaluaciones | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);

            $this->load->model('mcargasubseccion');
            $curso= $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $dominio=str_replace(".", "_",getDominio());
            if (isset($curso)) {
                $arraymb['curso'] =$curso;
                //$arraycs['curso'] =$curso;
                $this->load->model('mevaluaciones');
                $this->load->model('masistencias');
                $this->load->model('mmiembros');
                $notas= $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                $evaluaciones_head= $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));

                $fechas=     $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
                
                //$arraymb['asistencias'] =$asistencias;
                $arraymb['evaluaciones']=$evaluaciones_head;
                $arraymb['indicadores']=$indicadores;
                $arraymb['miembros']    =$miembros;
                $idn=0;
                $anota="";
                $arraymb['alumnos']=array();
                $alumno=array();
                if (count($evaluaciones_head)>0){
                    foreach ($miembros as $miembro) {
                            
                        $alumno[$miembro->idmiembro]['eval'] = array();
                        $alumno[$miembro->idmiembro]['eval']['RC']['tipo'] = "M"; 
                        $alumno[$miembro->idmiembro]['eval']['RC']['nota']= $miembro->recuperacion;

                        $alumno[$miembro->idmiembro]['eval']['PI']['tipo'] = "C"; 
                        $alumno[$miembro->idmiembro]['eval']['PI']['nota']= 0;

                        $alumno[$miembro->idmiembro]['eval']['PF']['tipo'] = "C"; 
                        $alumno[$miembro->idmiembro]['eval']['PF']['nota']= "--";

                        foreach ($indicadores as $indicador) {
                            foreach ($evaluaciones_head as $evaluacion) {
                                if ($indicador->codigo==$evaluacion->indicador){
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->evaluacion]=array();
                                    $idn--;
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['nota'] = "";
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['idnota'] = $idn;
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['tipo'] = $evaluacion->tipo; 
                                    $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['peso'] = $evaluacion->peso;
                                    foreach ($notas as $nota) {
                                        if (($miembro->idmiembro==$nota->idmiembro)&&($evaluacion->evaluacion==$nota->evaluacion)){
                                            $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['nota'] =($nota->nota=="")?"":floatval($nota->nota); 
                                            $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['idnota'] = $nota->id;    
                                        }
                                    }
                                }
                            }
                        }

                        $alumno[$miembro->idmiembro]['asis'] = array();
                        $alumno[$miembro->idmiembro]['asis']['faltas'] = 0;  
                        foreach ($fechas as $fecha) {
                            foreach ($asistencias as $asistencia) {
                                if (($miembro->idmiembro==$asistencia->idmiembro)&&($asistencia->sesion==$fecha->sesion)){
                                    $alumno[$miembro->idmiembro]['asis'][$fecha->sesion] = $asistencia->accion;  
                                       if ($asistencia->accion=="F"){
                                            $alumno[$miembro->idmiembro]['asis']['faltas']++;  
                                       }
                                }
                            }
                        }
                    }

                    $funcionhelp="getNotas_alumno_$dominio";
                    $alumno=$funcionhelp($curso->metodo,$alumno,$indicadores);
                    $arraymb['notas']=$alumno;
                }
            /*$arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $arsb['menu_padre']='docevaluaciones';*/
            $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-docentes');
            $this->load->view('sidebar_academico', $asidebar);
            $arraymb['supervisa']="SI";
            $arraymb['tema']="Evaluaciones";
      

            /*$ses_usuario = $_SESSION['userActivo'];
            $contenido = "$ses_usuario->usuario - $ses_usuario->paterno $ses_usuario->materno $ses_usuario->nombres, monitoreo evaluaciones de $docente->paterno $docente->materno $docente->nombres COD: $coddocente Periodo: $codperiodo";
            $this->mauditoria->insert_datos_auditoria(array($ses_usuario->idusuario, 'SELECT', $contenido, $ses_usuario->idsede));*/


            $this->load->view("curso/vw_curso_evaluaciones_{$dominio}_culminado", $arraymb);
            
        }
 
        $this->load->view('footer');
        }
        else{
             $ahead= array('page_title' =>'CURSO - NO AUTORIZADO | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
           
            
            $this->load->view('sidebar');
            $this->load->view('errors/sin-permisos');
            $this->load->view('footer');


           
        }
       
    }

    public function vw_curso_asistencias($codcarga,$division)
    {
        

        if ((getPermitido("53")=='SI') && ($_SESSION['userActivo']->tipo != 'AL')){
            $ahead= array('page_title' =>'Seguimiento de Docentes - Asistencias | IESTWEB'  );
            $asidebar= array('menu_padre' =>'rrhh','menu_hijo' =>'docentes');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);

            //if (($_SESSION['userActivo']->nivelid == 11) || ($_SESSION['userActivo']->nivelid == 12) || ($_SESSION['userActivo']->nivelid == 13)) {
            $this->load->model('mcargasubseccion');
            $curso= $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            
            if (isset($curso)) {
                $arraymb['curso'] =$curso;
                //$arraycs['curso'] =$curso;
                $this->load->model('mevaluaciones');
                $this->load->model('masistencias');
                $this->load->model('mmiembros');
                //$notas= $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                //$evaluaciones= $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));

                $fechas=     $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                //$indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
                
                //$arraymb['asistencias'] =$asistencias;
                $arraymb['fechas']=$fechas;
                $arraymb['miembros']    =$miembros;
                $idn=0;
                $anota="";
                $arraymb['alumnos']=array();
                $alumno=array();
                //if (count($evaluaciones)>0){
                    $n=0;
                    foreach ($miembros as $miembro) {
                        //if ($miembro->eliminado=='NO'){
                            $alumno[$miembro->idmiembro]['asis'] = array();
                            $alumno[$miembro->idmiembro]['asis']['faltas'] = 0;  
                            
                            foreach ($fechas as $fecha) {
                                $n--;
                                $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['idaccion'] = $n;;
                                $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = "";  
                                foreach ($asistencias as $asistencia) {
                                    if (($miembro->idmiembro==$asistencia->idmiembro)&&($asistencia->sesion==$fecha->sesion)){
                                        $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['idaccion'] = $asistencia->id;
                                        $alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'] = $asistencia->accion;  
                                        if ($asistencia->accion=="F"){
                                            $alumno[$miembro->idmiembro]['asis']['faltas']++;  
                                        }
                                    }
                                }
                            }
                        //}
                    }  
                    $arraymb['alumnos']    =$alumno;

                $this->load->view('sidebar');
                $arraymb['supervisa']="SI";
                $arraymb['tema']="Asistencias";
                $this->load->view('docentes/culminado/vw_curso_asistencias', $arraymb);
                
            }

            $this->load->view('footer');
        }
        else{
             $ahead= array('page_title' =>'CURSO - NO AUTORIZADO | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
           
            
            $this->load->view('sidebar');
            $this->load->view('errors/sin-permisos');
            $this->load->view('footer');
           
        }

    }

    public function vw_curso_sesiones($codcarga,$division)
    {

        if ((getPermitido("52")=='SI') && ($_SESSION['userActivo']->tipo != 'AL')){
            $ahead= array('page_title' =>'Admisión | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $arsb['menu_padre']='docsesiones';

            //if (($_SESSION['userActivo']->nivelid == 11) || ($_SESSION['userActivo']->nivelid == 12) || ($_SESSION['userActivo']->nivelid == 13)) {
            $this->load->model('mcargasubseccion');
            $curso = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            if (isset($curso)) {
                $this->load->model('msesiones');
                $arraymb['sesiones'] = $this->msesiones->m_sesiones_x_curso(array($codcarga,$division));
                $arraymb['curso']    = $curso;
                $this->load->view('sidebar');
                $arraymb['supervisa']="SI";
                $arraymb['tema']="Sesiones de clase";
                $this->load->view('docentes/culminado/vw_curso_sesiones', $arraymb);
                
            }
            $this->load->view('footer');
        }
        else{
             $ahead= array('page_title' =>'CURSO - NO AUTORIZADO | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            
            
            $this->load->view('sidebar');
            $this->load->view('errors/sin-permisos');
            $this->load->view('footer');
           
        }
    }

    public function vw_curso_miembros($codcarga,$division)
    {
        if ($_SESSION['userActivo']->codnivel == 3){
            $ahead= array('page_title' =>'CURSO - NO AUTORIZADO | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
           
            
            $this->load->view('sidebar');
            $this->load->view('errors/sin-permisos');
            $this->load->view('footer');
        }
        else{
            $ahead= array('page_title' =>'Admisión | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $arsb['menu_padre']='docmiembros';

            //if (($_SESSION['userActivo']->nivelid == 11) || ($_SESSION['userActivo']->nivelid == 12) || ($_SESSION['userActivo']->nivelid == 13)) {
            $this->load->model('mcargasubseccion');
            $curso = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            if (isset($curso)) {
                $this->load->model('mmiembros');
                $arraymc['miembros'] = $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $arraymc['curso']    = $curso;
                $this->load->view('sidebar');
                $arraymc['supervisa']="SI";
                $arraymc['tema']="Aula Virtual";
                $this->load->view('curso/supervisor/vw_curso_miembros', $arraymc);
                $this->load->view('footer');
            }
            /*} else {
                $this->load->view('errors/noautorizado');
            }*/
            $this->load->view('footer');
        }
    }

    public function vw_curso_virtual($codcarga,$division)
    {
        if ((getPermitido("54")=='SI') && ($_SESSION['userActivo']->tipo != 'AL')){
            $ahead= array('page_title' =>'Admisión | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $this->load->model('mvirtual');
            $arraymc['varchivos'] =$this->mvirtual->m_get_detalles(array($codcarga,$division));
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $arsb['menu_padre']='docconfiguracion';
            $this->load->model('mcargasubseccion');
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $arraymc['material'] = $this->mvirtual->m_get_materiales(array($codcarga,$division));
            $this->load->view('sidebar');
            $arraymc['supervisa']="SI";
            $arraymc['tema']="Aula Virtual";
            $this->load->view('curso/supervisor/vw_curso_aula_virtual', $arraymc);
            $this->load->view('footer');
        }
        else{
             $ahead= array('page_title' =>'CURSO - NO AUTORIZADO | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            
            
            $this->load->view('sidebar');
            $this->load->view('errors/sin-permisos');
            $this->load->view('footer');
           
        }

    }


    public function vw_curso_virtual_tarea($codcarga,$division,$codmaterial)
    {
        if ((getPermitido("54")=='SI') && ($_SESSION['userActivo']->tipo != 'AL')){
            $ahead= array('page_title' =>'Admisión | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $arraymc['vcarga']=$codcarga;
            $arraymc['vdivision']=$division;
            $division=base64url_decode($division);
            $codcarga=base64url_decode($codcarga);
            $codmaterial=base64url_decode($codmaterial);

            $this->load->model('mvirtual');
            $arraymc['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
            $this->load->model('mcargasubseccion');

            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $this->load->model('mmiembros');
            $arraymc['miembros'] = $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
            $this->load->model('mvirtualtarea');
            $arraymc['entregas'] = $this->mvirtualtarea->m_get_tareas_entregadas($codmaterial);
            $arraymc['varchivosentrega'] = $this->mvirtualtarea->m_get_detalles_x_material($codmaterial);
            $arraymc['supervisa']="SI";
            
            $arsb['menu_padre']='docaulavirtual';
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $this->load->view('sidebar',$arsb);
            $arraymc['item_aula']="Tarea";
            $this->load->view('curso/supervisor/vw_aula_tarea_entregas', $arraymc);
            $this->load->view('footer');
        }
        else{
             $ahead= array('page_title' =>'CURSO - NO AUTORIZADO | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            
            
            $this->load->view('sidebar');
            $this->load->view('errors/sin-permisos');
            $this->load->view('footer');
           
        }
    }

    //monitoreo/docente/curso/(:any)/(:any)/aula-virtual/foro/(:any)'
    public function vw_curso_virtual_foro($codcarga,$division,$codmaterial)
    {
        if ((getPermitido("54")=='SI') && ($_SESSION['userActivo']->tipo != 'AL')){
            $ahead= array('page_title' =>'Admisión | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $arraymc['vcarga']=$codcarga;
            $arraymc['vdivision']=$division;
            $division=base64url_decode($division);
            $codcarga=base64url_decode($codcarga);
            $codmaterial=base64url_decode($codmaterial);

            $this->load->model('mvirtual');
            
            $this->load->model('mcargasubseccion');
            $this->load->model('mmiembros');
             $arraymc['miembros'] = $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $arraymc['mat'] = $this->mvirtual->m_get_material(array($codmaterial));
            $arraymc['varchivos'] =$this->mvirtual->m_get_detalle_x_material(array($codmaterial));         
            $arraymc['comment'] = $this->mvirtual->lstcomentariosxforo(array($codmaterial));

            
            $arsb['menu_padre']='docaulavirtual';
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $this->load->view('sidebar',$arsb);
             $arraymc['item_aula']="Foro";
            $this->load->view('curso/supervisor/vw_aula_foro', $arraymc);
            $this->load->view('footer');
        }
        else{
             $ahead= array('page_title' =>'CURSO - NO AUTORIZADO | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            
            
            $this->load->view('sidebar');
            $this->load->view('errors/sin-permisos');
            $this->load->view('footer');
           
        }
    }

}
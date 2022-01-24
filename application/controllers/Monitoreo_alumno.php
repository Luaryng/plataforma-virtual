<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Monitoreo_alumno extends Error_views {
	function __construct() {
		parent::__construct();
//		$this->load->model('macciones');
		}
	
	public function vw_principal(){

		$this->load->model('mperiodo');
		$a_ins['periodos']=$this->mperiodo->m_get_periodos();	
		$ahead= array('page_title' =>'MONITOREO ALUMNO | IESTWEB'  );
		$asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-alumnos');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('monitoreo/alumno/index',$a_ins);
		$this->load->view('footer');
	}

    public function vw_boleta_notas()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
        $dataex['status'] = false;
        $urlRef           = base_url();
        $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
        $rst="";
        $this->form_validation->set_rules('cbperiodo', 'Periodo', 'trim|required');
        $this->form_validation->set_rules('txtbusca_carne', 'Nro Carné', 'trim|required|min_length[6]|max_length[20]');
        if ($this->form_validation->run() == false) {
            $dataex['msg'] = validation_errors();
        } else {
            $this->load->model('mmatricula');
            $cbper     = $this->input->post('cbperiodo');
            $tcar      = $this->input->post('txtbusca_carne');
            $matricula = $this->mmatricula->m_matricula_x_periodo_carne(array($tcar,$cbper));
            $cmat      = $matricula->codigo;
            $cmat64      = base64url_encode($cmat) ;

            $alumno = "
                <div class='col-12'>
                    <h4>$matricula->carne / $matricula->alumno </h4>
                </div>
                <div class='col-sm-3 col-md-2'>Periodo: <b>".$matricula->periodo."</b></div>
                <div class='col-sm-5 col-md-4'>Carrera: <b>".$matricula->carrera."</b></div>
                <div class='col-sm-2 col-md-2'>Ciclo: <b>".$matricula->ciclo."</b></div>
                <div class='col-sm-3 col-md-2'>Turno: <b>".$matricula->codturno."</b></div>
                <div class='col-sm-3 col-md-2'>Sección: <b>".$matricula->codseccion."</b></div>
            ";

            $arraymc['carnet'] = $matricula->carne;
            $arraymc['cperiodo'] = $cbper;
            $arraymc['alumno'] = $matricula->alumno;
            $arraymc['miscursos'] = $this->mmatricula->m_miscursos_x_matricula(array($cmat));
            $arraymc['miscursosesta'] = $this->mmatricula->m_miscursos_x_mat_asist_estadistica(array($cmat));
            $rst = $this->load->view('monitoreo/alumno/vw_mi_boleta', $arraymc,true);
            $abiertos=0;
            
            foreach ($arraymc['miscursos'] as $curso) {
                if ($curso->culminado=="NO") $abiertos++;
            } 
            if ($abiertos>0){
                $msgbol="<span class='border border-danger p-2 d-block'>El estudiante no podrá descargar su boleta de notas todas, debido las unidades deben ser culminadas por su respectivo docente, actualmente existen notas pendientes </span>";
            }
            else{
                $msgbol="";
            }
            $dataex['miboleta']='<a target="_blank" href="'.base_url().'academico/matricula/imprimir/'.$cmat64.'" class="btn btn-primary">Ficha de Matrícula</a>
            <a target="_blank" href="'.base_url().'academico/consulta/boleta-notas/imprimir-one/'.$cmat64.'" class="btn btn-primary">Descargar boleta</a>';
            $dataex['status'] = true;
            $dataex['alumno'] = $alumno;
        }
        $dataex['miscursos'] = $rst;
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function vw_boleta_notas2()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
        $dataex['status'] = false;
        $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
        $rst="";
        $this->form_validation->set_rules('cbmatricula', 'Matrícula', 'trim|required');
        if ($this->form_validation->run() == false) {
            $dataex['msg'] = validation_errors();
        } 
        else {
            $cmat64=$this->input->post('cbmatricula');
            $cmat      = base64url_decode($cmat64) ;
            $this->load->model('mmatricula');
            $ainterno['miscursos'] = $this->mmatricula->m_miscursos_x_matricula(array($cmat));
            $ainterno['miscursosesta'] = $this->mmatricula->m_miscursos_x_mat_asist_estadistica(array($cmat));
            $ainterno['carnet'] = $_SESSION['userActivo']->usuario;
            $ainterno['alumno'] = $_SESSION['userActivo']->paterno;
            $rst = $this->load->view('alumno/vw_mi_boleta', $ainterno,true);
            $abiertos=0;
            
            foreach ($ainterno['miscursos'] as $curso) {
                if ($curso->culminado=="NO") $abiertos++;
            } 
            if ($abiertos>0){
                $dataex['miboleta']="<span class='border border-danger p-2'>Para descargar tu boleta de notas todas las unidades deben ser culminadas por su respectivo docente, actualmente existen notas pendientes </span>";
            }
            else{
                 $dataex['miboleta']='<a target="_blank" href="'.base_url().'alumno/historial/boleta-de-notas?cmt='.$cmat64.'&print" '.' class="btn btn-primary">Descargar boleta</a>';
            }
            $dataex['status'] = true;
        }
        $dataex['miscursos'] = $rst;
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
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

            $salida=$this->load->view('docentes/vw_seg_docentes_periodo', $data,true);
             
            $dataex['status'] = true;
        }
        $dataex['matriculados'] = $salida;
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
    

    public function vw_crear_cuestionario()
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            
            $ahead= array('page_title' =>'MONITOREO - ALUMNO | ERP'  );
            $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-alumnos');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            
            $tipo=$this->input->get('tp');
            $codperiodo=$this->input->get('pd');
            $this->load->model('mperiodo');
            $vwarray= array('vcperiodos' => $this->mperiodo->m_get_periodos());
            
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

            $this->load->view('monitoreo/alumno/vw_cuestionario_crear',$vwarray);
            $this->load->view('footer');
            
        }
        else{
            $this->vwh_nopermitido("CURSO - NO AUTORIZADO");
        }
    }

    public function vw_editar_cuestionario($codcuge)
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            $codcuge=base64url_decode($codcuge);
            $this->load->model('mcuestionario_general');
            $vcencuesta=$this->mcuestionario_general->m_get_cuestionario_x_codigo(array($codcuge));
            if (isset($vcencuesta->codigo)){
                $ahead= array('page_title' =>'MONITOREO - ALUMNO | ERP'  );
                $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-alumnos');
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $this->load->model('mperiodo');
                $vwarray= array('vcperiodos' => $this->mperiodo->m_get_periodos(),'vcencuesta'=>$vcencuesta);
                $this->load->view('sidebar',$asidebar);
                $this->load->view('monitoreo/alumno/vw_cuestionario_crear',$vwarray);
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

    public function vw_encuestas()
    {
        $ahead= array('page_title' =>'ENCUESTAS GENERALES | IESTWEB'  );
        $asidebar= array('menu_padre' =>'economico','menu_hijo' =>'mispagos');
        
        $this->load->view('head',$ahead);
        $this->load->view('nav');

        $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'enc-alumno');
        $this->load->view('sidebar_alumno',$asidebar);
        
        $this->load->model('malumno');
        $mats= $this->malumno->m_matricula_activa(array($_SESSION['userActivo']->idinscripcion));
        $idmat=0;
        foreach ($mats as $key => $mt) {
            $idmat=$mt->codigo;
        }
        if ($idmat!=0){
            $this->load->model('mcuestionario_general');
            $vwarray['encuestas']= $this->mcuestionario_general->m_get_cuestionarios_encuestado(array($idmat));
            $this->load->view('monitoreo/alumno/vw_cuestionario_ls_para_alumno',$vwarray);
        }
        
        $this->load->view('footer');
    }

    public function vw_encuesta($codentrega)
    {
        
        $codentrega=base64url_decode($codentrega);
        $this->load->model('mcuestionario_general');
        $mat= $this->mcuestionario_general->m_get_cuestionario_encuestado(array($codentrega));
        if (isset($mat->codencuestallenar)){
            
            $fvence=$mat->vence;
            $finicia=$mat->inicia;
            date_default_timezone_set('America/Lima');
            $timelocal=time();
            $tvencio="NO";
            if ($fvence!=""){
                $tvencio=(strtotime($fvence)>$timelocal) ? "NO":"SI";
            }
            $tinicio="SI";
            if ($finicia!=""){
                $tinicio=(strtotime($finicia)<$timelocal) ?"SI":"NO";
            }

            if ($tinicio=="NO"){
                /*$urlref=base_url()."alumno/curso/virtual/evaluacion/".$arraymc['vcarga'].'/'.$arraymc['vdivision'].'/'.$codmaterialb64.'/'.$arraymc['vcodmiembro'];
                header("Location: $urlref", FILTER_SANITIZE_URL);*/
                $this->vwh_error_personalizado("ENCUESTA","ENCUESTA NO INICIADA","La escuesta seleccioanda se encuebntar en estado pausado o aun no inicia, por favor esperar e intentarlo mas tarde");
            } 
            elseif ($tvencio=="SI") {
                $this->vwh_error_personalizado("ENCUESTA","ENCUESTA CULMINADA","Ha vencido el plazo para responder esta encuesta");
            }
            else{

                $ahead= array('page_title' =>'ENCUESTAS GENERALES | IESTWEB'  );
                $asidebar= array('menu_padre' =>'enc-alumno');
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                
                $arraymc['mat']=$mat;
                $arraymc['preguntas'] = $this->mcuestionario_general->m_get_preguntas_x_cuestionario(array($mat->codigo));
                $rps= $this->mcuestionario_general->m_get_respuestas_x_cuestionario(array($mat->codigo));
                $respuestas=array();
                foreach ($rps as $key => $rp) {
                    $respuestas[$rp->codpregunta][] =$rp;
                }
                $arraymc['respuestas']=$respuestas;

                $this->load->view('sidebar_alumno',$asidebar);
                $this->load->view('monitoreo/alumno/vw_cuestionario_entregar', $arraymc);
                $this->load->view('footer');
            }
            
        }
        else{
            $this->vwh_noencontrado();
        }
        
    }


/*    public function fn_get_cuestionarios_participante(){
        $dataex['status'] = false;
        $dataex['msg']    = '¿Qué intentas?';
        if ($this->input->is_ajax_request()) {
            $usuario=$_SESSION['userActivo'];
            if ($usuario->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $this->form_validation->set_rules('vw_encu_cbperiodo', 'Periodo', 'trim|required');

                if ($this->form_validation->run() == false) {
                    $errors=array();
                    $dataex['msg2'] = validation_errors();
                    $dataex['msg'] = "Existe error en los campos";
                    
                    foreach ($this->input->post() as $key => $value){
                        $errors[$key] = form_error($key);
                    }
                    $dataex['errors'] = array_filter($errors);
                } 
                else {
                    $dataex['status'] = true;
                    $vcodperiodo= $this->input->post('vw_encu_cbperiodo');
                    $encu=$this->mcuestionario_general->m_get_cuestionarios_creador_observador(array($usuario->idusuario,$usuario->idsede,$vcodperiodo));

                    date_default_timezone_set('America/Lima');
                    $timelocal=time();
                    for ($i=0; $i < count($encu); $i++) { 

                        $fvence=$encu[$i]->vence;
                        $finicia=$encu[$i]->inicia;

                        
                        $fechav = "";
                        $tvencio="NO";
                        if ($fvence!=""){
                            $fechav = date('m-d-Y h:i a',strtotime($fvence));
                            $tvencio=(strtotime($fvence)>$timelocal) ? "NO":"SI";
                        }
                        $fechai = "";
                        $tinicio="SI";
                        if ($finicia!=""){
                            $fechai = date('m-d-Y h:i a',strtotime($finicia));
                            $tinicio=(strtotime($finicia)<$timelocal) ?"SI":"NO";
                        }
                        $estado="";
                        $boton="";
                        if ($tinicio=="NO"){
                            $estado='<span class="bg-secondary tboton d-inline-block mr-1"> En espera</span>
                                     <a class="bg-primary tboton d-inline-block"><i class="fas fa-play"></i></a>';
                        } 
                        elseif ($tvencio=="SI") {
                            $estado='<span class="bg-danger tboton d-inline-block mr-1"> Culminó</span>';
                        }
                        else{
                            $estado='<span class="bg-success tboton d-inline-block mr-1"> Encuestando</span>
                                     <a class="bg-warning tboton d-inline-block"><i class="fas fa-pause"></i></a>
                                     <a class="bg-danger tboton d-inline-block"><i class="fas fa-stop"></i></a>';
                            $boton="";
                        }
                        
                        $encu[$i]->estado=$estado;
                        $encu[$i]->boton=$boton;
                        $encu[$i]->vence=$fechav;
                        $encu[$i]->inicia=$fechai;
                        $encu[$i]->codigo=base64url_encode($encu[$i]->codigo);
                    }
                    $dataex['encucreadas']=$encu;
                    unset($dataex['msg']);
                }
            }
            else{
                $dataex['msg']    = 'No tienes autorización';
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

*/

    public function vw_reporte_alumno_virtual()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        // $codmt=base64url_decode($codmt);
        $tcar = base64url_decode($this->input->get('tcar'));
        $cbper = base64url_decode($this->input->get('cbper'));
        $tund = base64url_decode($this->input->get('tund'));
        
        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();
        
        $this->load->model('mmatricula');
        $matricula = $this->mmatricula->m_matricula_x_periodo_carne(array($tcar,$cbper));
        $this->load->model('mmonitoreo_alumno');
        $curs_und = $this->mmonitoreo_alumno->m_get_cursos_x_matricula_unidad(array($matricula->codigo,$tund));
        $notas = $this->mmonitoreo_alumno->m_get_notas_x_unidad(array($cbper,$tund,$curs_und->idmiembro));

        $this->load->model('mvirtual');
        $this->load->model('masistencias');
        
        $vmaterial = $this->mvirtual->m_get_virtmateriales(array($curs_und->idcarga,$curs_und->subseccion));
        $vmaterialnotas = $this->mvirtual->m_get_notas_materiales(array($curs_und->idcarga,$curs_und->subseccion));

        $fechaasist= $this->masistencias->m_fechas_x_curso(array($curs_und->idcarga,$curs_und->subseccion));
        $asistencias= $this->masistencias->m_asistencias_x_curso(array($curs_und->idcarga,$curs_und->subseccion));

        //MATERIALES
        $alumno[$curs_und->idmiembro]['virtual'] = array();
        
        foreach ($vmaterial as $mat) {
                                  
            $alumno[$curs_und->idmiembro]['virtual'][$mat->codigo]['vnota'] = "0";
                
            foreach ($vmaterialnotas as $nmat) {
                // NOTA EVALUACIÓN
                if (($curs_und->idmiembro==$nmat->miev)&&($nmat->evirtid==$mat->codigo)){
                    
                    $alumno[$curs_und->idmiembro]['virtual'][$mat->codigo]['vnota'] = str_pad($nmat->notev, 2, "0", STR_PAD_LEFT);  
                    
                }

                // NOTA TAREAS
                if (($curs_und->idmiembro==$nmat->mitar)&&($nmat->tvirtid==$mat->codigo)){
                    
                    $alumno[$curs_und->idmiembro]['virtual'][$mat->codigo]['vnota'] = str_pad($nmat->notar, 2, "0", STR_PAD_LEFT);  
                    
                }
            }
            
        }

        //ASISTENCIAS
        $estudiante[$curs_und->idmiembro]['asis'] = array();
        $estudiante[$curs_und->idmiembro]['asis']['faltas'] = 0;  
        //$n=0;
        foreach ($fechaasist as $fecha) {
            
            $estudiante[$curs_und->idmiembro]['asis'][$fecha->sesion]['accion'] = "-";  
            foreach ($asistencias as $asistencia) {
                if (($curs_und->idmiembro==$asistencia->idmiembro)&&($asistencia->sesion==$fecha->sesion)){
                    
                    $estudiante[$curs_und->idmiembro]['asis'][$fecha->sesion]['accion'] = $asistencia->accion;  
                    if (($asistencia->accion=="F") || ($asistencia->accion=="")){
                        $estudiante[$curs_und->idmiembro]['asis']['faltas']++;  
                    }
                }
            }
        }
        
        
        $dominio=str_replace(".", "_",getDominio());
        $html1=$this->load->view("monitoreo/alumno/pdf_reporte_estudiante", array('ies' => $ie,'mat' => $matricula,'notas' => $notas,'curs_und' => $curs_und,'virtual' => $vmaterial,'virtnot' => $alumno,'fechasasis' => $fechaasist, 'asistencias' => $estudiante),true);
       
        $pdfFilePath = "REPORTE ACADÉMICO.pdf";

        $this->load->library('M_pdf');
        $formatoimp="A4";
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]);
        $mpdf->SetTitle( "REPORTE ACADÉMICO");
        $mpdf->WriteHTML($html1);
        
        $mpdf->Output($pdfFilePath, "I");
    }





























}
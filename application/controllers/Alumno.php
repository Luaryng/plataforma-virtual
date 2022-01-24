<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alumno extends CI_Controller
{

    //ESTA CLAS SOLO DEBERÁ CONTENER FUNCIONES QUE DEVUELVAN DATOS DEL ALUMNO LOGEADO
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library('form_validation');
        $this->load->model('malumno');
    }

   

    //Muestra el combo para selccionar el periodo y buscar boleta
    public function historial__mis_boletas_notas()
    {
        $codmat64=$this->input->get("cmt");
        if ((($this->input->get("print")!==null)) && ($codmat64)){
            //Solicita impresion de boleta
            $codmatricula=base64url_decode($codmat64);
            $this->load->model('miestp');
            $ie=$this->miestp->m_get_datos();
            $this->load->model('mmatricula');
            $insc=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
            if (!is_null($insc)){
                $insc1=$insc[0];
                if ($insc1->codinscripcion==$_SESSION['userActivo']->idinscripcion){
                    $cursos=$this->mmatricula->m_miscursos_x_matricula(array($codmatricula));
                
                
                    $dominio=str_replace(".", "_",getDominio());
                    $html1=$this->load->view('matricula/rp_boleta-notas_'.$dominio, array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ),true);
                    
                    $pdfFilePath = "BN-".$insc1->paterno." ".$insc1->materno." ".$insc1->nombres." - ".$insc1->ciclol.".pdf";

                    $this->load->library('M_pdf');
                    //p=normal
                    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [200,200],'orientation' => 'L']); 
                    $mpdf->SetTitle( "BN- $insc1->paterno $insc1->materno $insc1->nombres - $insc1->ciclol");
                    $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.1,array(50,70),array(80,40));
                    $mpdf->showWatermarkImage  = true;
                    $mpdf->shrink_tables_to_fit = 1;
                    $mpdf->WriteHTML($html1);
                    $mpdf->Output($pdfFilePath, "D");
                }
            }
        }
        else{
            $abiertos=0;
            $ahead= array('page_title' =>'Boleta de Notas | ERP'  );
            $asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'campania');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
            $this->load->view($vsidebar,$asidebar);

            $arraymc['mismatriculas'] = $this->malumno->m_matriculasxcarne(array($_SESSION['userActivo']->idinscripcion));
            
            if ($codmat64){
                $cmat      = base64url_decode($codmat64) ;
                $oficial=false;
                foreach ($arraymc['mismatriculas'] as $key => $matric) {
                    if ($matric->codigo==$cmat) $oficial=true;
                }
                if ($oficial==true){
                    $this->load->model('mmatricula');
                    $abiertos=0;
                    $ainterno['miscursos'] = $this->mmatricula->m_miscursos_x_matricula(array($cmat));
                    $ainterno['miscursosesta'] = $this->mmatricula->m_miscursos_x_mat_asist_estadistica(array($cmat));
                    $ainterno['carnet'] = $_SESSION['userActivo']->usuario;
                    $ainterno['alumno'] = $_SESSION['userActivo']->paterno;
                    $arraymc['miscursos'] = $this->load->view('alumno/vw_mi_boleta', $ainterno,true);
                    foreach ($ainterno['miscursos'] as $curso) {
                        if ($curso->culminado=="NO") $abiertos++;
                    } 
                    if ($abiertos>0){
                        $arraymc['miboleta']="<span class='border border-danger p-2'>Para descargar tu boleta de notas todas las unidades deben ser culminadas por su respectivo docente, actualmente existen notas pendientes </span>";
                    }
                    else{
                        $arraymc['miboleta']='<a target="_blank" href="'.base_url().'alumno/historial/boleta-de-notas?cmt='.$codmat64.'&print" '.' class="btn btn-primary">Descargar boleta</a>';
                    }
                }
                
                //$arraymc['mat64']=$codmat64;
            }
            $this->load->view('alumno/historial__boleta_notas', $arraymc);
            $this->load->view('footer');
        }
    }

    
    public function historial__mis_pagos()
    {
        $ahead= array('page_title' =>'Mis Pagos | Plataforma Virtual '.$this->config->item('erp_title'));
        $asidebar= array('menu_padre' =>'mn_pagos','menu_hijo' =>'');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);

        $inicio =0;
        $vuser=$_SESSION['userActivo'];
        $limite =40;
        $arraymc = $this->malumno->m_pagos_xCarnet($inicio,$limite,array($vuser->usuario,$vuser->tipodoc,$vuser->nrodoc));
        
        $this->load->view('alumno/historial_pagos', $arraymc);
        $this->load->view('footer');
    }

    public function historial__mis_deudas()
    {
        $ahead= array('page_title' =>'MIS DEUDAS | IESTWEB'  );
        $asidebar= array('menu_padre' =>'mn_deudas','menu_hijo' =>'');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);
        
        $arraymc['items'] = $this->malumno->m_get_deuda_activa_xpaganteins(array($_SESSION['userActivo']->codentidad));
        $this->load->view('alumno/historial_deudas', $arraymc);
        $this->load->view('footer');
    }

    public function historial__mis_notas()
    {
        //MUETRA LA VIEW PARA DESCARGAR LA BOELTA DE NOTAS
        $codmat64=$this->input->get("cmt");
            $abiertos=0;
            $ahead= array('page_title' =>'Boleta de Notas | ERP'  );
            $asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'campania');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
            $this->load->view($vsidebar,$asidebar);

            $arraymc['mismatriculas'] = $this->malumno->m_matriculasxcarne(array($_SESSION['userActivo']->idinscripcion));
            
            if ($codmat64){
                $cmat      = base64url_decode($codmat64) ;
                $bloqueada=false;
                foreach ($arraymc['mismatriculas'] as $key => $matric) {
                    if ($matric->codigo==$cmat) {
                        //$oficial=true;
                        if ($matric->bloquear_evaluaciones=="SI") {
                            $bloqueada=true;
                            //unset($arraymc['mismatriculas'][$key]);

                        }
                    }

                }
                if ($bloqueada==false){
                    $this->load->model('mmatricula_independiente');
                    $abiertos=0;
                    $this->load->model('mmatricula');
                    $carga_plat = $this->mmatricula->m_cursos_min_x_matricula(array($cmat));
                    //$carga_plat_cerrados = $this->mmatricula->m_cursos_min_x_matricula(array($cmat));
                    $cursos= $this->mmatricula_independiente->m_get_cursos_xmatricula(array($cmat));
                    $dominio=str_replace(".", "_",getDominio());
                    foreach ($cursos as $key => $fila) {
                        $fila->codigo64 = base64url_encode($fila->id);
                        $fila->codmiembro64 = base64url_encode($fila->codmiembro);
                        $fila->nota = (is_null($fila->nota ))? "":floatval($fila->nota);
                        $fila->recuperacion = (is_null($fila->recuperacion ))? "":floatval($fila->recuperacion);
                        $funcionhelp="getNotas_alumnoboleta_$dominio";
                        $fila->final = $funcionhelp($fila->metodo,array('promedio' => $fila->nota, 'recupera'=>$fila->recuperacion));
                    }
                    $ainterno['miscursos'] =$cursos;
                    //$ainterno['miscursosesta'] = $this->mmatricula->m_miscursos_x_mat_asist_estadistica(array($cmat));
                    $ainterno['carnet'] = $_SESSION['userActivo']->usuario;
                    $ainterno['alumno'] = $_SESSION['userActivo']->paterno;
                    $arraymc['miscursos'] = $this->load->view('alumno/vw_mi_boleta_final', $ainterno,true);
                    foreach ($ainterno['miscursos'] as $curso) {
                        if ($curso->culminado=="NO") $abiertos++;
                    }
                    
                    $dif=$abiertos - count($carga_plat);
                    if ($dif<0){
                        $arraymc['miboleta']="<span class='border border-danger p-2'> Aún existen unidades didácticas procesandose</span>";
                    }
                    else{
                        $arraymc['miboleta']='<a target="_blank" href="'.base_url().'alumno/historial/notas/imprimir?cmt='.$codmat64.'" class="btn btn-primary">Descargar boleta</a>';
                    }
                }
                else{
                    $arraymc['miscursos'] = "<h5 class='d-block bg-lightgray border rounded p-1'>Sus evaluaciones están siendo procesadas</h5>";
                    $arraymc['miboleta']="<span class='border border-danger p-2'> Aún existen unidades didácticas procesandose</span>";
                }
            }
            $this->load->view('alumno/historial__boleta_notas_final', $arraymc);
            $this->load->view('footer');
    }

   

    public function historial__mis_notas_xmatricula()
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

            $bloqueada=false;
            $arraymc['mismatriculas'] = $this->malumno->m_matriculasxcarne(array($_SESSION['userActivo']->idinscripcion));
            foreach ($arraymc['mismatriculas'] as $key => $matric) {
                if ($matric->codigo==$cmat) {
                    //$oficial=true;
                    if ($matric->bloquear_evaluaciones=="SI") {
                        $bloqueada=true;
                        //unset($arraymc['mismatriculas'][$key]);

                    }
                }

            }
            if ($bloqueada==false){    
                $this->load->model('mmatricula_independiente');
                $this->load->model('mmatricula');
                
                $carga_plat = $this->mmatricula->m_cursos_min_x_matricula(array($cmat));
                $cursos = $this->mmatricula_independiente->m_get_cursos_xmatricula(array($cmat));
                $dominio=str_replace(".", "_",getDominio());
                foreach ($cursos as $key => $fila) {
                    $fila->codigo64 = base64url_encode($fila->id);
                    $fila->codmiembro64 = base64url_encode($fila->codmiembro);
                    $fila->nota = (is_null($fila->nota ))? "":floatval($fila->nota);
                    $fila->recuperacion = (is_null($fila->recuperacion ))? "":floatval($fila->recuperacion);
                    $funcionhelp="getNotas_alumnoboleta_$dominio";
                    $fila->final = $funcionhelp($fila->metodo,array('promedio' => $fila->nota, 'recupera'=>$fila->recuperacion));
                }
                $ainterno['miscursos'] =$cursos;


                //$ainterno['miscursosesta'] = $this->mmatricula->m_miscursos_x_mat_asist_estadistica(array($cmat));
                $ainterno['carnet'] = $_SESSION['userActivo']->usuario;
                $ainterno['alumno'] = $_SESSION['userActivo']->paterno;
                $rst = $this->load->view('alumno/vw_mi_boleta_final', $ainterno,true);


                
                $dif=count($ainterno['miscursos']) - count($carga_plat);
                if ($dif<0){
                    $dataex['miboleta']="<span class='border border-danger p-2'> Aún existen unidades didácticas procesandose</span>";
                }
                else{
                    $dataex['miboleta']='<a target="_blank" href="'.base_url().'alumno/historial/notas/imprimir?cmt='.$cmat64.'" class="btn btn-primary">Descargar boleta</a>';
                }
            }
            else{
                $rst = "<h5 class='d-block bg-lightgray border rounded p-1'>Sus evaluaciones están siendo procesadas</h5>";
                $dataex['miboleta']="<span class='border border-danger p-2'> Aún existen unidades didácticas procesandose</span>";
            }
            $dataex['status'] = true;
        }
        $dataex['miscursos'] = $rst;
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }


    public function historial__mis_notas_imprimir()
    {
        $codmat64=$this->input->get("cmt");

        $codmatricula=base64url_decode($codmat64);
          
        $this->load->model('mmatricula_independiente');
        $this->load->model('mmatricula');
        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();

        $insc=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
        if (!is_null($insc)){
            $dominio=str_replace(".", "_",getDominio());
            $cursos=$this->mmatricula_independiente->m_miscursos_x_matricula(array($codmatricula));
            foreach ($cursos as $key => $fila) {
                $fila->nota = (is_null($fila->nota ))? "":floatval($fila->nota);
                $fila->recuperacion = (is_null($fila->recuperacion ))? "":floatval($fila->recuperacion);
                $funcionhelp="getNotas_alumnoboleta_$dominio";
                $fila->final = $funcionhelp($fila->metodo,array('promedio' => $fila->nota, 'recupera'=>$fila->recuperacion));


            }
            //$this->load->view('matricula/rp_boleta-notas', array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ));
            $insc1=$insc[0];
            $dominio=str_replace(".", "_",getDominio());
            $html1=$this->load->view('matricula/independiente/reportes/rp_boleta-notas_'.$dominio, array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ),true);
             
            $pdfFilePath = "BN-".$insc1->paterno." ".$insc1->materno." ".$insc1->nombres." - ".$insc1->ciclol.".pdf";

            $this->load->library('M_pdf');
            //p=normal
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [200,200],'orientation' => 'L']); 
            $mpdf->SetTitle( "BN- $insc1->paterno $insc1->materno $insc1->nombres - $insc1->ciclol");
            //$mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.1,array(50,70),array(80,40));
            $mpdf->showWatermarkImage  = true;
            $mpdf->shrink_tables_to_fit = 1;
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath, "I");
        }
    }

    public function historial__mi_registro_matriculas()
    {
        $ahead= array('page_title' =>'Registro Matrícula | ERP'  );
        $asidebar= array('menu_padre' =>'ltmatriculas','menu_hijo' =>'');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);

        $arraymc['mismatriculas'] = $this->malumno->m_matriculas_x_inscripcion(array($_SESSION['userActivo']->codentidad));
        
        $this->load->view('alumno/historial_matriculas', $arraymc);
        $this->load->view('footer');
    }
    
    //Muestra la boleta del ciclo selecionado, en la pagina
    public function historial__mi_boleta_notas()
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
            $colorText="";
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


    public function vwmisdeudas()
    {

        $ahead= array('page_title' =>'Datos Económicos | IESTWEB'  );
        $asidebar= array('menu_padre' =>'economico','menu_hijo' =>'misdeudas');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);

        $arraydeudas['deudas'] = $this->malumno->m_misdeudas_pendientes(array($_SESSION['userActivo']->idinscripcion));
        $this->load->view('header');
        $this->load->view('sidebar',$arraysidebar);
        $this->load->view('alumno/misdeudas', $arraydeudas);
        $this->load->view('footer');
    }

    public function vwmisdeudas_notificar_error()
    {
       $arraydeudas['deudas'] = $this->malumno->m_misdeudas_pendientes(array($_SESSION['userActivo']->idinscripcion));
        $ahead= array('page_title' =>'Datos Económicos | IESTWEB'  );
        $asidebar= array('menu_padre' =>'economico','menu_hijo' =>'misdeudas');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);
        $this->load->view('alumno/misdeudas_notificarerror', $arraydeudas);
        $this->load->view('footer');
    }

    

    public function vwmispagos()
    {
        $arraymc['mismatriculas'] = $this->malumno->m_matriculasxcarne(array($_SESSION['userActivo']->idinscripcion));
        $ahead= array('page_title' =>'Datos Económicos | IESTWEB'  );
        $asidebar= array('menu_padre' =>'economico','menu_hijo' =>'mispagos');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);
        $this->load->view('alumno/mispagos', $arraymc);
        $this->load->view('footer');
    }

    public function vw_micurso($codcursocarga, $division, $idmiembro, $cmat,$carnet,$alumno_apenom)
    {
         $ahead= array('page_title' =>'Datos Académicos | Plataforma Virtual'  );
        $asidebar= array('menu_padre' =>'economico','menu_hijo' =>'mispagos');
        
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        //CARGAR BASE DE DATOS
        $codcursocarga = base64url_decode($codcursocarga);
        $idmiembro = base64url_decode($idmiembro);
        $cmat = base64url_decode($cmat);
        $division = base64url_decode($division);
        $dominio=str_replace(".", "_",getDominio());
        $this->load->model('mmiembros');
        $miembro= $this->mmiembros->m_get_miembro_por_idmiembro(array($idmiembro,$codcursocarga,$division));


        $this->load->model('masistencias');
        $fechas=    $this->masistencias->m_fechas_x_curso(array($codcursocarga,$division));
        $asistencias = $this->malumno->m_asistencias_x_curso_alumno(array($codcursocarga,$division,$idmiembro));
        $this->load->model('mevaluaciones');

        $evaluaciones_head=$this->mevaluaciones->m_eval_head_x_curso(array($codcursocarga,$division));
        $arraymb['evaluaciones'] = $evaluaciones_head;
        $notas=         $this->mevaluaciones->m_notas_x_curso_por_alumno(array($codcursocarga,$division, $idmiembro));
        $arraymb['notas']=$notas;
        $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcursocarga,$division));
        $arraymc['indicadores'] =$indicadores;
        $this->load->model('mcargasubseccion');
        $curso     = $this->mcargasubseccion->m_get_carga_subseccion(array($codcursocarga,$division));
        
        $this->load->model('mmatricula');
        $arraymc['miscursosesta'] = $this->mmatricula->m_miscursos_x_mat_asist_estadistica(array($cmat));
        $arraymc['miscursos'] = $this->mmatricula->m_miscursos_x_matricula(array($cmat));
        $alumno= array();
        $arraymb['curso']=$curso;
        
  
        $idn=0;
        $anota="";
        //$arraymb['alumnos']=array();
        $alumno=array();
        if (count($evaluaciones_head)>0){
            if(isset($miembro->idmiembro)) {
            
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
                                $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]=array();
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
            //$arraymb['notas']=$alumno;
        }


        $arraymc['carnet']=base64url_decode($carnet);
        $arraymc['alumno']=base64url_decode($alumno_apenom);
        $arraymb['fechas'] = $fechas;
        $arraymb['asistencias']= $asistencias;
        $arraymc['idmiembro']=$miembro->idmiembro;
        $arraymb['alumnonotas']=$alumno;
        $arraymb['mascursos'] =$this->load->view('alumno/vw_mi_boleta', $arraymc,true);

        if (isset($arraymb['curso'])) {
            $arraycs['curso'] = $arraymb['curso'];
            $this->load->view('sidebar_alumno', $arraycs);
            $arraymb['acarnet']=base64url_decode($carnet);
            $arraymb['aalumno']=base64url_decode($alumno_apenom);
            $this->load->model('msede');
            $arraymb['config']=$this->msede->m_get_sede_config_x_codigo(array($_SESSION['userActivo']->idsede));
            $this->load->view('alumno/historial__curso_detalle', $arraymb);
        }
        $this->load->view('footer');
    }

    public function vw_mis_cursos_panel()
    {
        $this->load->model('mvirtualalumno');
        $ahead= array('page_title' =>'Mis Cursos | IESTWEB'  );
        $asidebar= array('menu_padre' =>'miscursospanel','menu_hijo' =>'');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);
        $codalumno=$_SESSION['userActivo']->usuario;
        $mcursos= $this->mvirtualalumno->m_get_cursos_visibles_x_carnet(array($codalumno));
        //$arraymc['matriculas']=array();
        /*foreach ($mcursos as $key => $mc) {
            $arraymc['matriculas'] = $this->mvirtualalumno->m_get_matricula_x_carne_periodo(array($codalumno,$mc->codperiodo));
        }*/
        $arraymc['miscursos'] =$mcursos;
        $this->load->view('alumno/miscursos_panel', $arraymc);
        $this->load->view('footer');
    }

    public function vw_panel_cursos($codcarga,$division,$codmiembro)
    {
        $this->load->model('mcargasubseccion');
        $this->load->model('mmiembros');
        $codcarga=base64url_decode($codcarga);
        $division=base64url_decode($division);
        $ahead= array('page_title' =>'Mis Cursos Panel | IESTWEB'  );
        $asidebar= array('menu_padre' =>'miscursospanel','menu_hijo' =>'');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        $arraymc['miembro'] = base64url_decode($codmiembro);
        $this->load->view('alumno/panel_cursos', $arraymc);
        $this->load->view('footer');
    }

    public function vw_sesiones_curso($codcarga,$division,$codmiembro)
    {
        $this->load->model('mcargasubseccion');
        $this->load->model('msesiones');
        $codcarga=base64url_decode($codcarga);
        $division=base64url_decode($division);
        $ahead= array('page_title' =>'Mis Cursos Sesiones | IESTWEB'  );
        $asidebar= array('menu_padre' =>'miscursospanel','menu_hijo' =>'');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);
        $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
        $arraymc['sesiones'] = $this->msesiones->m_sesiones_completa_x_curso(array($codcarga,$division));
        $arraymc['miembro'] = base64url_decode($codmiembro);
        $this->load->view('alumno/cursos_sesiones', $arraymc);
        $this->load->view('footer');
    }

    public function fn_download_file($filename, $filenameruta,$filetype)
    {
        $filename = base64url_decode($filename);
        $filenameruta = base64url_decode($filenameruta);
        $filetype = base64url_decode($filetype);
        $filepath = "upload/docweb/".$filenameruta;
        
        if (!empty($filenameruta) && file_exists($filepath)){
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-type:$filetype");
            header("Content-Transfer-Encoding: binary");
            readfile($filepath);
            exit;
        }
        else{
            header("Location: ".base_url()."no-encontrado");
        }
       
    }
    
    public function rp_deudas_estudiante_pdf()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        $carne = $_SESSION['userActivo']->codentidad;
        $estudiante = $_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres;

        date_default_timezone_set('America/Lima');

        $fecha = date('d/m/Y');
        
        $rstdata = $this->malumno->m_get_deuda_activa_xpaganteins(array($carne));

        //$dominio=str_replace(".", "_",getDominio());
        
        $html1=$this->load->view('alumno/rpdeudas_estudiante_pdf', array('docpagos' => $rstdata),true);
         
        $pdfFilePath = 'DEUDAS PENDIENTES.pdf';

        $this->load->library('M_pdf');
        
        $formatoimp="A4";
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

        $mpdf->SetTitle('DEUDAS PENDIENTES');       

        //$mpdf->AddPage();
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");
        // $mpdf->Output();
    }

}

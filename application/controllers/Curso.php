<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Curso extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('mcargasubseccion');
		
	}

	public function vw_curso_panel($codcarga,$division)
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
            $ahead= array('page_title' =>'CURSO - PANEL DE CONTROL | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $arraymc['curso'] = $this->mcargasubseccion->m_get_subseccion(array($codcarga,$division));
            $this->load->model('msede');
            $arraymc['config']=$this->msede->m_get_sede_config_x_codigo(array($_SESSION['userActivo']->idsede));
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $arsb['menu_padre']='docpanel';
            $this->load->view('docentes/sidebar_curso',$arsb);
            $this->load->view('docentes/vw_curso_panel', $arraymc);
            $this->load->view('footer');
        }
        
    }

    public function vw_curso_configuracion($codcarga,$division)
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
            $arsb['menu_padre']='docconfiguracion';
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $this->load->view('docentes/sidebar_curso',array('vcarga'=>$codcarga,'vdivision'=>$division));
            $this->load->view('docentes/vw_curso_configura', $arraymc);
            $this->load->view('footer');
        }
    }

     public function vw_curso_documentos($codcarga,$division)
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
            $ahead= array('page_title' =>'U.D. - DOCUMENTOS | IESTWEB'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $arsb['menu_padre']='docconfiguracion';
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $this->load->view('docentes/sidebar_curso',array('vcarga'=>$codcarga,'vdivision'=>$division));
            $this->load->view('docentes/vw_curso_documentos', $arraymc);
            $this->load->view('footer');
        }
    }

    public function vw_curso_indicadores($codcarga,$division)
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
            $arsb['menu_padre']='docconfiguracion';
            $this->load->model('mevaluaciones');
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $arraymc['indicadores'] = $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
            $this->load->view('docentes/sidebar_curso',array('vcarga'=>$codcarga,'vdivision'=>$division));
            $this->load->view('docentes/vw_curso_indicadores', $arraymc);
            $this->load->view('footer');
        }
    }

   public function vw_curso_indicadores_only($codcarga,$division)
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
            $arsb['menu_padre']='docconfiguracion';
            $this->load->model('mevaluaciones');
            $arraymc['curso'] = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $arraymc['indicadores'] = $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
            $arraymc['subindicadores'] = $this->mcargasubseccion->m_get_carga_subseccion_indicadores(array($codcarga,$division));
            $this->load->view('docentes/sidebar_curso',array('vcarga'=>$codcarga,'vdivision'=>$division));
            $this->load->view('docentes/vw_curso_indicadores_only', $arraymc);
            $this->load->view('footer');
        }
    }

    public function f_subir_subitems()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $dataex['msg'] = "Ocurrio un error";
                $data          = json_decode($_POST['filas']);
                $dataUpdate    = array();
                $dataInsert    = array();
                foreach ($data as $value) {
                    if ($value[4] > 0) {
                        $dataUpdate[] = array($value[4], $value[1]);
                    } else {
                        $dataInsert[] = array($value[1], $value[0], $value[2], $value[3]);
                    }
                  
                }
                $rpta = 1;
                if ($rpta = 1) {
                  $rpta = $this->mcargasubseccion->m_agregar_sub_indicadores($dataInsert, $dataUpdate);
                  $dataex['status'] = true;
                  $dataex['msg'] = "<span>Se GUARDÓ Correctamente</span>";
                }
                

            
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function vw_curso_sesiones($codcarga,$division)
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
            $arsb['menu_padre']='docsesiones';

            //if (($_SESSION['userActivo']->nivelid == 11) || ($_SESSION['userActivo']->nivelid == 12) || ($_SESSION['userActivo']->nivelid == 13)) {
            $curso = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            if (isset($curso)) {
                $this->load->model('msesiones');
                $arraymb['sesiones'] = $this->msesiones->m_sesiones_completa_x_curso(array($codcarga,$division));
                $arraymb['curso']    = $curso;
                $this->load->view('docentes/sidebar_curso',array('vcarga'=>$codcarga,'vdivision'=>$division));
                if ($curso->culminado=='NO'){
                    $this->load->view('docentes/vw_curso_sesiones', $arraymb);
                }
                else{
                    $this->load->view('docentes/culminado/vw_curso_sesiones', $arraymb);
                }
            }
            $this->load->view('footer');
        }
    }
  

    public function vw_curso_evaluaciones($codcarga,$division)
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
            $ahead= array('page_title' =>'Evaluaciones | Plataforma Virtual '.$this->config->item('erp_title')) ;
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $dominio=str_replace(".", "_",getDominio());
            //if (($_SESSION['userActivo']->nivelid == 11) || ($_SESSION['userActivo']->nivelid == 12) || ($_SESSION['userActivo']->nivelid == 13)) {
               $curso= $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
                
                if (isset($curso)) {
                    $arraymb['curso'] =$curso;
                    //$arraycs['curso'] =$curso;
                    $this->load->model('mevaluaciones');
                    $this->load->model('masistencias');
                    $this->load->model('mmiembros');

                    $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
                    $evaluaciones_head= $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));
                    $notas= $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));

                    $fechas=     $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                    $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                    $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                    


                    $this->load->model('mvirtual');
                    $notas_aula= $this->mvirtual->m_get_notas_x_materiales(array($codcarga,$division,$codcarga,$division));
                    $materiales= $this->mvirtual->m_get_materiales_calificables(array($codcarga,$division));
                    
                    $arraymb['materiales']=$materiales;
                    $arraymb['notas_aula']=$notas_aula;
                    $arraymb['evaluaciones']=$evaluaciones_head;
                    $arraymb['indicadores']=$indicadores;
                    $arraymb['miembros']    =$miembros;
                    $idn=0;
                    $anota="";
                    //$arraymb['alumnos']=array();
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
                                            $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]=array();
                                            $idn--;
                                            $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['nota'] = "";
                                            $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['peso'] = $evaluacion->peso;
                                            $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['idnota'] = $idn;
                                            $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->nombre_calculo]['tipo'] = $evaluacion->tipo; 
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
                    $arsb['vcarga']=$codcarga;
                    $arsb['vdivision']=$division;
                    $arsb['menu_padre']='docevaluaciones';
                    $this->load->view('docentes/sidebar_curso',$arsb);
                    $this->load->model('msede');
                    $arraymb['config']=$this->msede->m_get_sede_config_x_codigo(array($_SESSION['userActivo']->idsede));
                    
                    if ($curso->culminado=='NO'){
                        $this->load->view("curso/vw_curso_evaluaciones_".$dominio, $arraymb);
                    }
                    else{
                        $this->load->view("curso/vw_curso_evaluaciones_{$dominio}_culminado", $arraymb);
                    }
                }
            /*} else {
                $this->load->view('errors/noautorizado');
            }*/
            $this->load->view('footer');
        }
    }

    public function vw_curso_recuperacion($codcarga,$division)
    {
        if ($_SESSION['userActivo']->codnivel == 3){
            $ahead= array('page_title' =>'CURSO - NO AUTORIZADO | ERP'  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
           
            
            $this->load->view('sidebar');
            $this->load->view('errors/sin-permisos');
            $this->load->view('footer');
        }
        else{
            $ahead= array('page_title' =>'Recuperación | ERP' ) ;
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);

            //if (($_SESSION['userActivo']->nivelid == 11) || ($_SESSION['userActivo']->nivelid == 12) || ($_SESSION['userActivo']->nivelid == 13)) {
               $curso= $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
                
                if (isset($curso)) {
                    $arraymb['curso'] =$curso;
                    //$arraycs['curso'] =$curso;
                    $this->load->model('mevaluaciones');
                    $this->load->model('masistencias');
                    $this->load->model('mmiembros');
                    $notas= $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                    $evaluaciones= $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));

                    $fechas=     $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                    $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                    $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                    $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
                    
                    //$arraymb['asistencias'] =$asistencias;
                    $arraymb['evaluaciones']=$evaluaciones;
                    $arraymb['indicadores']=$indicadores;
                    $arraymb['miembros']    =$miembros;
                    $idn=0;
                    $anota="";
                    $arraymb['alumnos']=array();
                    $alumno=array();
                    if (count($evaluaciones)>0){
                        foreach ($miembros as $miembro) {
                            //if ($miembro->eliminado=='NO'){
                        
                                $alumno[$miembro->idmiembro]['eval'] = array();
                                $alumno[$miembro->idmiembro]['eval']['RC']['tipo'] = "M"; 
                                $alumno[$miembro->idmiembro]['eval']['RC']['nota']= $miembro->recuperacion;

                                $alumno[$miembro->idmiembro]['eval']['PI']['tipo'] = "C"; 
                                $alumno[$miembro->idmiembro]['eval']['PI']['nota']= $miembro->final;

                                $alumno[$miembro->idmiembro]['eval']['PF']['tipo'] = "C"; 
                                $alumno[$miembro->idmiembro]['eval']['PF']['nota']= "--";

                                foreach ($indicadores as $indicador) {
                                    foreach ($evaluaciones as $evaluacion) {
                                        if ($indicador->codigo==$evaluacion->indicador){
                                            $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->evaluacion]=array();
                                            $idn--;
                                            $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->abrevia]['nota'] = "";
                                            $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->abrevia]['idnota'] = $idn;
                                            $alumno[$miembro->idmiembro]['eval'][$indicador->codigo][$evaluacion->abrevia]['tipo'] = $evaluacion->tipo; 
                                            foreach ($notas as $nota) {
                                                if (($miembro->idmiembro==$nota->idmiembro)&&($evaluacion->evaluacion==$nota->evaluacion)){
                                                    $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['nota'] =($nota->nota=="")?"":floatval($nota->nota); 
                                                    $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['idnota'] = $nota->id;    
                                                }
                                            }
                                        }
                                    }
                                }
                                $pfi=$alumno[$miembro->idmiembro]['eval']['PI']['nota'];
                                if (!is_numeric($pfi)) $pfi=0;
                                $rc=$alumno[$miembro->idmiembro]['eval']['RC']['nota'];
                                if (!is_numeric($rc)) $rc="";

                                $alumno[$miembro->idmiembro]['eval']['PF']['nota']=($rc!="") ? $rc : $pfi;

                               //$alumno=getNotasAlumnos($miembro,$indicadores,$evaluaciones,$alumno);

                                //ASISTENCIAS
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
                            //}
                        }  
                        $arraymb['notas']=$alumno;
                    }
                    $arsb['vcarga']=$codcarga;
                    $arsb['vdivision']=$division;
                    $arsb['menu_padre']='docevaluaciones';
                    $this->load->view('docentes/sidebar_curso',$arsb);

                    $dominio=str_replace(".", "_",getDominio());
                    //if ($curso->culminado=='NO'){
                        $this->load->view("curso/docentes/vw_curso_recuperacion_$dominio", $arraymb);
                    /*}
                    else{
                        $this->load->view("docentes/culminado/vw_curso_evaluaciones_".$dominio, $arraymb);
                    }*/
                }
            /*} else {
                $this->load->view('errors/noautorizado');
            }*/
            $this->load->view('footer');
        }
    }


    public function vw_curso_asistencias($codcarga,$division)
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
            $asidebar= array('menu_padre' =>'rrhh','menu_hijo' =>'docentes');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);

            //if (($_SESSION['userActivo']->nivelid == 11) || ($_SESSION['userActivo']->nivelid == 12) || ($_SESSION['userActivo']->nivelid == 13)) {
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
                    //}//
                    $arsb['vcarga']=$codcarga;
                    $arsb['vdivision']=$division;
                    $arsb['menu_padre']='docasistencias';
                    $this->load->view('docentes/sidebar_curso',$arsb);
                    if ($curso->culminado=='NO'){
                        $this->load->view('docentes/vw_curso_asistencias', $arraymb);
                    }
                    else{
                        $this->load->view('docentes/culminado/vw_curso_asistencias', $arraymb);
                    }
                }
            /*} else {
                $this->load->view('errors/noautorizado');
            }*/
            $this->load->view('footer');
        }
    }

    public function vw_curso_asistencias_diario($codcarga,$division,$idsesion)
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
            $asidebar= array('menu_padre' =>'rrhh','menu_hijo' =>'docentes');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $idsesion=base64url_decode($idsesion);

            //if (($_SESSION['userActivo']->nivelid == 11) || ($_SESSION['userActivo']->nivelid == 12) || ($_SESSION['userActivo']->nivelid == 13)) {
               $curso= $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
                
                if (isset($curso)) {
                    $arraymb['curso'] =$curso;
                    //$arraycs['curso'] =$curso;
                    $this->load->model('mevaluaciones');
                    $this->load->model('masistencias');
                    $this->load->model('mmiembros');
                    //$notas= $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                    //$evaluaciones= $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));

                    $fechas=     $this->masistencias->m_fechas_x_curso_sesion(array($idsesion));
                    $asistencias= $this->masistencias->m_asistencias_x_curso_sesion(array($idsesion));

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
                    //}//
                    $arsb['vcarga']=$codcarga;
                    $arsb['vdivision']=$division;
                    $arsb['menu_padre']='docasistencias';
                    $this->load->view('docentes/sidebar_curso',$arsb);
                    if ($curso->culminado=='NO'){
                        $this->load->view('docentes/vw_curso_asistencias_diario', $arraymb);
                    }
                    else{
                        $this->load->view('docentes/culminado/vw_curso_asistencias_diario', $arraymb);
                    }
                }
            /*} else {
                $this->load->view('errors/noautorizado');
            }*/
            $this->load->view('footer');
        }
    }
    
    public function fn_curso_culminar()
    {
        if ($_SESSION['userActivo']->codnivel == 3){
            $dataex['status'] = false;
            $dataex['msg']    = '¿Que intentas? .!.';
        }
        else{
            $dataex['status'] = false;
            $dataex['msg']    = '¿Que intentas? .!.';
            if ($this->input->is_ajax_request()) {
            

             $this->form_validation->set_message('required', '%s Requerido');
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('idcarga', 'Carga académica', 'trim|required');
                $this->form_validation->set_rules('division', 'División', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } 
                else {
                    $codcargaenc= $this->input->post('idcarga');
                    $divisionenc=$this->input->post('division');
                    $codcarga=base64url_decode($codcargaenc);
                    $division=base64url_decode($divisionenc);
                    if (($_SESSION['userActivo']->codnivel == 1) || ($_SESSION['userActivo']->codnivel == 2) || ($_SESSION['userActivo']->codnivel == 0)) {
                       $curso= $this->mcargasubseccion->m_get_subseccion(array($codcarga,$division));
                        $dominio=str_replace(".", "_",getDominio());
                        if (isset($curso)) {
                            /*if ($curso->sesiones<$curso->avance){
                                $dataex['status'] = false;
                                $dataex['msg'] = "Los días de clase registrados son mayores a la cantidad declarada en configuración";
                            }
                            else{*/
                                $usuario=$_SESSION['userActivo']->usuario;
                                $this->load->model('mmatricula_independiente');                                
                                $this->load->model('msede');                                
                                $config_sede=$this->msede->m_get_sede_config_x_codigo(array($_SESSION['userActivo']->idsede));
                                $arraymb['curso'] =$curso;
                                //$arraycs['curso'] =$curso;
                                $this->load->model('mevaluaciones');
                                $this->load->model('masistencias');
                                $this->load->model('mmiembros');
                                $notas= $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                                $evaluaciones= $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));

                                $fechas=     $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                                $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                                $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
                                $idn=0;
                                $anota="";
                                $ultind='0';
                                $arraymb['alumnos']=array();
                                if (count($evaluaciones)>0){
                                    foreach ($miembros as $miembro) {
                                        if ($miembro->eliminado=='NO'){
                                            
                                            $alumno[$miembro->idmiembro]['eval'] = array();
                                            $alumno[$miembro->idmiembro]['eval']['RC']['tipo'] = "M"; 
                                            $alumno[$miembro->idmiembro]['eval']['RC']['nota']= $miembro->recuperacion;

                                            $alumno[$miembro->idmiembro]['eval']['PI']['tipo'] = "C"; 
                                            $alumno[$miembro->idmiembro]['eval']['PI']['nota']= 0;

                                            $alumno[$miembro->idmiembro]['eval']['PF']['tipo'] = "C"; 
                                            $alumno[$miembro->idmiembro]['eval']['PF']['nota']= "--";

                                            foreach ($indicadores as $indicador) {
                                                foreach ($evaluaciones as $evaluacion) {
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
                                                 $ultind=$indicador->codigo;
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
                                    }
                                    $funcionhelp="getNotas_alumno_$dominio";
                                    $alumno=$funcionhelp($curso->metodo,$alumno,$indicadores);
                                    foreach ($miembros as $miembro) {
                                        if ($miembro->eliminado=='NO'){
                                            $falp=$alumno[$miembro->idmiembro]['asis']['faltas']/$curso->sesiones * 100;  
                                            if ($falp>=30){
                                                    $this->mmiembros->m_editar_estado(array($miembro->idmiembro,'DPI'));
                                                    $sts="DPI";
                                                    $pnf=0;
                                            }
                                            else{
                                                $pnf=$alumno[$miembro->idmiembro]['eval']['PI']['nota'];
                                                
                                                $sts="APR";
                                                if ($pnf<13){
                                                    $sts="DES";
                                                    if (is_numeric($miembro->recuperacion)){
                                                        if ($miembro->recuperacion>12.5){
                                                            $sts="APR";
                                                        }
                                                    }
                                                }
                                                if ($config_sede->conf_permitir_nsp=='SI'){
                                                    $ef=$alumno[$miembro->idmiembro]['eval'][$ultind]['N3']['nota']; 
                                                    if (!is_numeric($ef)) $sts='NSP'; 
                                                }
                                                $this->mmiembros->m_editar_promedio(array($miembro->idmiembro,$pnf,$sts));
                                            }
                                                
                                                if ($config_sede->conf_migrar_notas=='SI'){
                                                    $miembro_mat=$this->mmatricula_independiente->m_get_mat_final_x_miembro(array($miembro->idmiembro));

                                                    if (count($miembro_mat)==0){
                                                        if ($config_sede->conf_doc_rec=='SI'){
                                                            //var_dump("INSERTA");
                                                            $rpta=$this->mmatricula_independiente->m_insert_mat_culminar_curso(array($miembro->codmatricula,'PLATAFORMA',$codcarga, $division, $curso->doccodigo, $curso->codunidad, $pnf, $miembro->recuperacion,'', $usuario,$_SESSION['userActivo']->idsede,'SI',$sts,$miembro->repitencia,$miembro->idmiembro));  
                                                        }
                                                        else{
                                                            //var_dump("INSERTA");
                                                            $rpta=$this->mmatricula_independiente->m_insert_mat_culminar_curso_sr(array($miembro->codmatricula,'PLATAFORMA',$codcarga, $division, $curso->doccodigo, $curso->codunidad, $pnf,'', $usuario,$_SESSION['userActivo']->idsede,'SI',$sts,$miembro->repitencia,$miembro->idmiembro)); 
                                                        }
                                                    }
                                                    else{
                                                        if ($config_sede->conf_doc_rec=='NO'){
                                                            //var_dump("EDITA");
                                                            $rpta=$this->mmatricula_independiente->m_update_nota_final_recuperacion_sr(array($miembro_mat[0]->codmatfinal,$pnf,$sts));  
                                                        }
                                                        else{
                                                            //var_dump("EDITA");
                                                            $rpta=$this->mmatricula_independiente->m_update_nota_final_recuperacion(array($miembro_mat[0]->codmatfinal,$pnf,$miembro->recuperacion,$sts)); 
                                                        }

                                                    }
                                                   
                                                }

                                            
                                        }
                                    }  
                                }
                                $dataex['status'] = false;
                                $dataex['msg'] = 'El curso ya se encuentra culminado';
                                if ($curso->culminado=='NO'){
                                    $this->mcargasubseccion->m_culminar_curso(array('SI',$codcarga,$division));
                                     $dataex['status'] = true;
                                     $dataex['redirect'] = base_url()."/curso/panel/$codcargaenc/$divisionenc";
                                    $dataex['msg'] = 'Curso culminado con éxito';
                                }
                            //}
                        }
                    } else {
                        $dataex['status'] = false;
                        $dataex['msg'] = 'No tienes el permiso requerido para culminar un curso';
                    }
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_curso_reabrir()
    {
        if ($_SESSION['userActivo']->codnivel == 3){
            $dataex['status'] = false;
            $dataex['msg']    = '¿Que intentas? .!.';
        }
        else{
            $dataex['status'] = false;
            $dataex['msg']    = '¿Que intentas? .!.';
            if ($this->input->is_ajax_request()) {
            

             $this->form_validation->set_message('required', '%s Requerido');
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('idcarga', 'Carga académica', 'trim|required');
                $this->form_validation->set_rules('division', 'División', 'trim|required');

                //$this->form_validation->set_rules('mostrar', 'Mostrar', 'trim|required');
                
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } 
                else {
                    $codcargaenc= $this->input->post('idcarga');
                    $divisionenc=$this->input->post('division');
                    $codcarga=base64url_decode($codcargaenc);
                    $division=base64url_decode($divisionenc);
                    if (getPermitido("66")=="SI") {
                        $this->mcargasubseccion->m_culminar_curso(array('NO',$codcarga,$division));
                        $dataex['status'] = true;
                    } else {
                        $dataex['status'] = false;
                        $dataex['msg'] = 'No tienes el permiso requerido para culminar un curso';
                    }
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_curso_ocultar()
    {
        if ($_SESSION['userActivo']->codnivel == 3){
            $dataex['status'] = false;
            $dataex['msg']    = '¿Que intentas? .!.';
        }
        else{
            $dataex['status'] = false;
            $dataex['msg']    = '¿Que intentas? .!.';
            if ($this->input->is_ajax_request()) {
            

             $this->form_validation->set_message('required', '%s Requerido');
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('idcarga', 'Carga académica', 'trim|required');
                $this->form_validation->set_rules('division', 'División', 'trim|required');
                $this->form_validation->set_rules('accion', 'Ocultar', 'trim|required');

                //$this->form_validation->set_rules('mostrar', 'Mostrar', 'trim|required');
                
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } 
                else {
                    $accion=$this->input->post('accion');
                    //var_dump($accion);
                    $ocultar=(filter_var($accion, FILTER_VALIDATE_BOOLEAN)==true) ? "NO":"SI";
                    $codcarga=base64url_decode($this->input->post('idcarga'));
                    $division=base64url_decode($this->input->post('division'));
                    if (getPermitido("67")=="SI") {
                        $this->mcargasubseccion->m_ocultar_curso(array($ocultar,$codcarga,$division));
                        $dataex['status'] = true;
                    } else {
                        $dataex['status'] = false;
                        $dataex['msg'] = 'No tienes el permiso requerido para culminar un curso';
                    }
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
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
            $curso = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            if (isset($curso)) {
                $this->load->model('mmiembros');
                $arraymb['miembros'] = $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $arraymb['curso']    = $curso;
                $this->load->view('docentes/sidebar_curso',array('vcarga'=>$codcarga,'vdivision'=>$division));
                if ($curso->culminado=='NO'){
                    $this->load->model('msede');
                    $arraymb['config']=$this->msede->m_get_sede_config_x_codigo(array($_SESSION['userActivo']->idsede));
                    $this->load->view('docentes/vw_curso_miembros', $arraymb);
                }
                else{
                    $this->load->view('docentes/culminado/vw_curso_miembros', $arraymb);
                }
            }
            /*} else {
                $this->load->view('errors/noautorizado');
            }*/
            $this->load->view('footer');
        }
    }

    public function f_updatenrosesiones()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .!.';
        if ($_SESSION['userActivo']->codnivel != 3){
            if ($this->input->is_ajax_request()) {
                $this->form_validation->set_message('required', '%s Requerido');
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('idcarga', 'Carga académica', 'trim|required');
                $this->form_validation->set_rules('division', 'División', 'trim|required');
                $this->form_validation->set_rules('nrosesiones', 'NroSesion', 'trim|required');

                //$this->form_validation->set_rules('mostrar', 'Mostrar', 'trim|required');
                
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } 
                else {
                    $codcargaenc= $this->input->post('idcarga');
                    $divisionenc=$this->input->post('division');
                    $division=base64url_decode($this->input->post('division'));
                    $codcarga         = base64url_decode($this->input->post('idcarga'));
                    $nrosesiones         = $this->input->post('nrosesiones');
                     $dataex['msg']    = 'No tienes autorización para esta acción';
                    if (($_SESSION['userActivo']->codnivel == 1) || ($_SESSION['userActivo']->codnivel == 2) || ($_SESSION['userActivo']->codnivel == 0)) {
                            $dataex['msg']    = 'Ocurrio un error, COD: M3CH4S';
                            $this->mcargasubseccion->m_update_nrosesiones(array($nrosesiones,$codcarga,$division));
                            $dataex['msg']    = 'Nro Sesiones actualizados satisfactoriamente';
                            $dataex['status'] = true;
                            $dataex['redirect'] = base_url()."/curso/panel/$codcargaenc/$divisionenc";
                    }

                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    } 

    public function f_subirevaluaciones()
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
                $dataInsert    = array();
                //idmiembro, nota, idnota,idevh

                $this->load->model('mmiembros');
                foreach ($data as $value) {
                    if ($value[1] == "") {
                        $value[1] = null;
                    }
                
                    if ($value[3] == 0) {
                         $this->mmiembros->m_editar_recuperacion(array($value[0],$value[1]));
                    }
                    elseif ($value[2] < 0) {
                        //@`vcca`, @`vsubseccion`, @`vidmiembro`, @`vecu_nota`, @`videvaluacionhead`
                        //[0idmiembro, 1nota, 2idnota, ,3idevh];
                        $dataInsert[] = array($vcca, $vssc, $value[0], $value[1], $value[3],$value[2]);
                    } else {
                        $dataUpdate[] = array($value[2],$value[1]);
                    }
                }
                $this->load->model('mevaluaciones');
                $rpta = $this->mevaluaciones->m_guardar_nota($dataInsert, $dataUpdate);

                $dataex['ids'] = $rpta['idsnew'];
                //var_dump($dataex['ids']);
                $dataex['status'] = true;

            }
            $dataex['destino'] = $urlRef;
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function f_subirasistencia()
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
                $dataInsert    = array();
                foreach ($data as $value) {
                    if ($value[2] < 0) {
                        //[fcha, accn, idacu, idmiembro, idses];
                        $dataInsert[] = array($vcca,$vssc, $value[0], $value[3], $value[1], $value[4],$value[2]);
                    } else {
                        $dataUpdate[] = array($value[2], $value[1]);
                    }
                }
                $rpta = 1;
                $this->load->model('masistencias');
                $rpta = $this->masistencias->m_guardar_asistencia($dataInsert, $dataUpdate);
                $dataex['ids'] = $rpta['idsnew'];
                $dataex['status'] = true;
            }
            $dataex['destino'] = $urlRef;
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }

    public function vw_registro_final_pdf($codcarga,$division)
    {
        if (($_SESSION['userActivo']->codnivel == 0) || ($_SESSION['userActivo']->codnivel == 1) || ($_SESSION['userActivo']->codnivel == 2)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $this->load->model('mevaluaciones');
                $this->load->model('masistencias');
                $this->load->model('mmiembros');
                $this->load->model('msesiones');
                $idn=0;
                $anota="";
                $arraymb['alumnos']=array();
                $areg['curso'] =$curso;
                $dominio=str_replace(".", "_",getDominio());
                $fechas=     $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                $areg['sesiones']= $this->msesiones->m_sesiones_x_curso_reg(array($codcarga,$division));
                $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));
                if ((getDominio()=="iesap.edu.pe")||(getDominio()=="charlesashbee.edu.pe")){
                    $subindicadores= $this->mcargasubseccion->m_get_carga_subseccion_indicadores(array($codcarga,$division));
                    $areg['subindicadores']=$subindicadores;
                }
                
                $evaluaciones_head = $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));
                $notas        = $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $alumno= array();

                $nro=0;
            
   
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
                    

                $areg['notas']      =$notas;
                $areg['miembros']   =$miembros;
                $areg['evaluaciones']=$evaluaciones_head;
                $areg['indicadores']=$indicadores;
                
                $areg['alumno']=$alumno;
                $areg['asistencias'] = $asistencias;
                $areg['fechas'] = $fechas;

                /*$areg['fechas1']=$fecha1;
                $areg['fechas2']=$fecha2;
                $areg['fechas3']=$fecha3;*/

                //$areg['fechas'] 
                //$areg['fechas1']=array();
                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();
                $this->load->model('msede');
                $sede=$this->msede->m_get_sede_activa();

                
                 $dominio=str_replace(".", "_",getDominio());
                //$this->load->view('docentes/registro/hoja3_'.$dominio,$areg);
                $html1=$this->load->view('docentes/registro/hoja1', array('curso' => $curso, 'ies'=>$iestp ,'sede'=>$sede ),true);
                $html2=$this->load->view('docentes/registro/hoja2_'.$dominio,$areg,true);
                
                $tiporegistro=((count($fechas)>58) || (count($indicadores)>8)) ? "registro8":"registro";
                
                $html3=$this->load->view('docentes/'.$tiporegistro.'/hoja3_'.$dominio,$areg,true);
                $html4=$this->load->view('docentes/'.$tiporegistro.'/hoja4_'.$dominio,$areg,true);
                $html5=$this->load->view('docentes/'.$tiporegistro.'/hoja5_'.$dominio,$areg,true);
                $html6=$this->load->view('docentes/'.$tiporegistro.'/hoja6_'.$dominio,$areg,true);
                if ($tiporegistro=="registro8"){
                    $html7=$this->load->view('docentes/registro8/hoja7_'.$dominio,$areg,true);
                    $html8=$this->load->view('docentes/registro8/hoja8_'.$dominio,$areg,true);
                }
                //echo "$html6";
                $pdfFilePath = "RF_".$curso->periodo." ".$curso->unidad.".pdf";
                $this->load->library('M_pdf');
                $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
                $mpdf->shrink_tables_to_fit = 1;
                $mpdf->SetTitle( "$curso->unidad $curso->codseccion $curso->division");
                $mpdf->WriteHTML($html1);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html2);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html3);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html4);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html5);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html6);

                if ($tiporegistro=="registro8"){
                    
                    $mpdf->AddPage();
                    $mpdf->WriteHTML($html7);
                    $mpdf->AddPage();
                    $mpdf->WriteHTML($html8);
                }

                $mpdf->Output($pdfFilePath,"I");  //TAMBIEN I para en linea*/
            }
        }
    }

    public function vw_acta_evaluacion_final_pdf($codcarga,$division)
    {
        if (($_SESSION['userActivo']->codnivel == 0) || ($_SESSION['userActivo']->codnivel == 1) || ($_SESSION['userActivo']->codnivel == 2)) {
            $codcarga=base64url_decode($codcarga);
            $division=base64url_decode($division);
            $curso = $this->mcargasubseccion->m_get_carga_subseccion_todos(array($codcarga,$division));
            if (isset($curso)) {
                $this->load->model('mmiembros');

                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));

                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();
                
                $dominio=str_replace(".", "_",getDominio());
                //$this->load->view('docentes/registro/hoja3_'.$dominio,$areg);
                $html1=$this->load->view('curso/documentos/rp_acta_evaluacion_final_'.$dominio, array('curso' => $curso, 'ies'=>$iestp ,'miembros'=>$miembros ),true);

                //$this->load->view('docentes/registro/hoja3',$areg);
                //$this->load->view('curso/registro/hoja3',$areg);

                $pdfFilePath = "AE_".$curso->periodo." ".$curso->unidad.".pdf";
                $this->load->library('M_pdf');
                $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
                $mpdf->shrink_tables_to_fit = 1;
                $mpdf->SetTitle( "$curso->unidad $curso->codseccion $curso->division");
                $mpdf->WriteHTML($html1);
               
                $mpdf->Output($pdfFilePath,"D");  //TAMBIEN I para en linea*/
            }
        }
    }
}
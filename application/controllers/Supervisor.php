<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Supervisor extends CI_Controller {
	function __construct() {
		parent::__construct();
//		$this->load->model('macciones');
		}
	
	public function alumnos(){
		
		//$resultado=$this->cargaPermisos();	
		$this->load->model('mperiodo');
		$a_ins['periodos']=$this->mperiodo->m_get_periodos();	
		$ahead= array('page_title' =>'IESTWEB - Seguimiento de Alumnos'  );
		$asidebar= array('menu_padre' =>'seguimiento','menu_hijo' =>'seg-alumnos');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('alumno/seguimiento_consulta',$a_ins);
		$this->load->view('footer');
	}


	public function docentes($codperiodo=""){
        $ahead= array('page_title' =>'IESTWEB - Seguimiento de Docentes'  );
        $asidebar= array('menu_padre' =>'seguimiento','menu_hijo' =>'seg-docentes');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);

        if (getPermitido("38")=='SI'){
            $arraymc['periodo'] = $codperiodo;
            $this->load->model('mdocentes');
            $data['docentes']=array();
            if ($codperiodo!==""){
                $data['docentes'] = $this->mdocentes->m_docentes_x_periodo(array($codperiodo));
            }
            
            $this->load->model('mperiodo');
            $data['periodos']=$this->mperiodo->m_get_periodos();    
            $data['periodo'] = $codperiodo;
            $arraymc['resultados']=$this->load->view('docentes/vw_seg_docentes_periodo', $data,true);
            $this->load->view('docentes/vw_seg_docentes', $arraymc);
        }
        else{
            $this->load->view('errors/sin-permisos');   
        }

        $this->load->view('footer');
    }

    public function grupos($codperiodo=""){
        $ahead= array('page_title' =>'IESTWEB - Seguimiento de Grupos'  );
        $asidebar= array('menu_padre' =>'seguimiento','menu_hijo' =>'seg-grupos');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);


        

        if (getPermitido("38")=='SI'){
            $arraymc['periodo'] = $codperiodo;
            $this->load->model('mdocentes');
            $data['docentes'] = $this->mdocentes->m_docentes_x_periodo(array($codperiodo));
            $this->load->model('mperiodo');
            $data['periodos']=$this->mperiodo->m_get_periodos();    
            $data['periodo'] = $codperiodo;
            $arraymc['resultados']=$this->load->view('docentes/vw_seg_docentes_periodo', $data,true);
            $this->load->view('grupos/vw_seg_grupos', $arraymc);
        }
        else{
            $this->load->view('errors/sin-permisos');   
        }

        $this->load->view('footer');
    }


    public function vw_cursos_docente($coddocente,$codperiodo){
    	$ahead= array('page_title' =>'IESTWEB - Seguimiento de Alumnos'  );
		$asidebar= array('menu_padre' =>'seguimiento','menu_hijo' =>'seg-docentes');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
        if (getPermitido("38")=='SI'){
            $codperiodo=base64url_decode($codperiodo);
            $coddocente=base64url_decode($coddocente);
            $this->load->model('mdocentes');
            $resultado=$this->mdocentes->m_cursos_x_docente(array($coddocente,$codperiodo));
            $arraymc['docente'] = $resultado['docente'];
            $arraymc['cursos'] = $resultado['cursos'];
            $arraymc['periodo'] =$codperiodo;
            $this->load->view('docentes/vw_seg_cursos_docente', $arraymc);
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

            $salida=$this->load->view('docentes/vw_seg_docentes_periodo', $data,true);
             
            $dataex['status'] = true;
        }
        $dataex['matriculados'] = $salida;
        
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
        $curso= $this->mcargasubseccion->m_get_subseccion(array($codcarga,$division));
            
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
            if (count($evaluaciones)>0){
                foreach ($miembros as $miembro) {
                    //if ($miembro->eliminado=='NO'){
                        $alumno[$miembro->idmiembro]['eval'] = array();
                        $alumno[$miembro->idmiembro]['eval']['RC']['tipo'] = "M"; 
                        $alumno[$miembro->idmiembro]['eval']['RC']['nota']= $miembro->recuperacion;

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
                                            $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['nota'] = $nota->nota; 
                                            $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['idnota'] = $nota->id;    
                                        }
                                    }
                                }
                            }
                        }

                        //************************* CANCHAQUE
                        //EVALAUCIONES CALCULADAS POR ALUMNO 
                        if (getDominio()=="iestpcanchaque.edu.pe"){
                            foreach ($evaluaciones as $evaluacion) {
                                if ($evaluacion->tipo=="C"){
                                //$nindicador=str_pad($evaluacion->indicador, 2, "0", STR_PAD_LEFT);
                                $pc=$alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador]['PC']['nota'];
                                if (!is_numeric($pc)) $pc=0;
                                $ta=$alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador]['TA']['nota'];
                                if (!is_numeric($ta)) $ta=0;
                                $ei=$alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador]['EI']['nota'];
                                if (!is_numeric($ei)) $ei=0;
                                

                                $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador]['PI']['tipo'] = $evaluacion->tipo; 
                                $alumno[$miembro->idmiembro]['eval'][$evaluacion->indicador]['PI']['nota']= round(($pc * 0.3) + ($ta * 0.3) + ($ei * 0.4),0); 
                                }
                            }
                            //PROMEDIO FINAL
                            $nco=0;
                            $sumapi=0;
                            foreach ($indicadores as $indicador) {
                                $nco++;
                                $ri=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['RI']['nota'];
                                if (!is_numeric($ri)) $ri=0;
                                $pi=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
                                if (!is_numeric($pi)) $pi=0;
                                $sumapi=$sumapi + (($pi>$ri) ? $pi : $ri);

                            }

                            if ($nco==0) $nco=1;
                            $alumno[$miembro->idmiembro]['eval']['PF']['tipo'] = "C"; 
                            $alumno[$miembro->idmiembro]['eval']['PF']['nota']=round($sumapi / $nco,0);
                        }
                        //FIN EVALAUCIONES CALCULADAS POR ALUMNO
                        //************************* FIN CANCHAQUE
                                

                        //************************* HUARMACA
                        //EVALAUCIONES CALCULADAS POR ALUMNO 
                         if (getDominio()=="iestphuarmaca.edu.pe"){
                            $nco=0;
                            
                            //PROMEDIO FINAL
                            $pis=0;

                            foreach ($indicadores as $indicador) {

                                $ep=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['EP']['nota'];
                                if (!is_numeric($ep)) $ep=0;
                                //$eps=$eps + $ep;

                                $ta=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['TA']['nota'];
                                if (!is_numeric($ta)) $ta=0;
                                //$tas=$tas + $ta;

                                $ef=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['EF']['nota'];
                                if (!is_numeric($ef)) $ef=0;
                                //$efs=$efs + $ef;
                                $alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['PI']['tipo'] = $evaluacion->tipo; 
                                $pi=round((($ep * 3) + ($ta * 3) + ($ef * 4))/10,2); 
                                $alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['PI']['nota']= $pi;
                                $pis=$pis + $pi;
                                $nco++;

                            }
                            if ($nco==0) $nco=1;
                            $pfi=round($pis/$nco,0);
                            

                            //$pfi=round(($epp * 0.3) + ($tap * 0.3) + ($efp * 0.4),0); 
                            $alumno[$miembro->idmiembro]['eval']['PI']['tipo'] = "C"; 
                            $alumno[$miembro->idmiembro]['eval']['PI']['nota']=$pfi;
                            
                            $rc=$alumno[$miembro->idmiembro]['eval']['RC']['nota'];
                            if (!is_numeric($rc)) $rc=0;

                            $alumno[$miembro->idmiembro]['eval']['PF']['tipo'] = "C"; 
                            $alumno[$miembro->idmiembro]['eval']['PF']['nota']=($pfi>$rc) ? $pfi : $rc;
                        }
                        //FIN EVALAUCIONES CALCULADAS POR ALUMNO
                        //************************* FIN HUARMACA

                        //************************* CHARLES
                        //EVALAUCIONES CALCULADAS POR ALUMNO 
                        if (getDominio()=="charlesashbee.edu.pe"){
                            $nco=0;
                            $eis=0;
                            $tais=0;
                            foreach ($indicadores as $indicador) {
                                $ep=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['PC']['nota'];
                                if (!is_numeric($ep)) $ep=0;

                                $ta=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['TA']['nota'];
                                if (!is_numeric($ta)) $ta=0;

                                $tai=round(($ep + $ta)/2,0);
                                $alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['TAI']['nota']=$tai;
                                
                                $tais=$tais + $tai;

                                if ($nco<2){
                                    $ei=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['EI']['nota'];
                                    if (!is_numeric($ei)) $ei=0; 
                                    $eis= $eis + $ei;
                                }
                                $ultind=$indicador->codigo;
                                $nco++;

                            }
                            if ($nco==0) $nco=1;
                            
                            $tap=round($tais/$nco,0);
                            $alumno[$miembro->idmiembro]['eval']['PTA']['tipo'] = "C"; 
                            $alumno[$miembro->idmiembro]['eval']['PTA']['nota']=$tap;

                            $nco=$nco - 1;
                            if ($nco<=0) $nco=1;
                            $eip=round($eis/$nco,0);

                            $alumno[$miembro->idmiembro]['eval']['PEI']['tipo'] = "C"; 
                            $alumno[$miembro->idmiembro]['eval']['PEI']['nota']=$eip;

                            $ef=$alumno[$miembro->idmiembro]['eval'][$ultind]['EI']['nota']; 
                            if (!is_numeric($ef)) $ef=0; 


                            $pi=round(($tap * 0.3) + ($eip * 0.3) + ($ef * 0.4),0); 
                            $alumno[$miembro->idmiembro]['eval']['PI']['tipo'] = "C"; 
                            $alumno[$miembro->idmiembro]['eval']['PI']['nota']=$pi;
                            
                            $rc=$alumno[$miembro->idmiembro]['eval']['RC']['nota'];
                            if (!is_numeric($rc)) $rc=0;

                            $alumno[$miembro->idmiembro]['eval']['PF']['tipo'] = "C"; 
                            $alumno[$miembro->idmiembro]['eval']['PF']['nota']=($pi>$rc) ? $pi : $rc;
                        }
                        //FIN EVALAUCIONES CALCULADAS POR ALUMNO
                        //************************* FIN CHARLES
                        
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
            /*$arsb['vcarga']=$codcarga;
            $arsb['vdivision']=$division;
            $arsb['menu_padre']='docevaluaciones';*/
            $this->load->view('sidebar');
            $arraymb['supervisa']="SI";
            $arraymb['tema']="Evaluaciones";
            $dominio=str_replace(".", "_",getDominio());
            $this->load->view("docentes/culminado/vw_curso_evaluaciones_".$dominio, $arraymb);
            
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
            $curso= $this->mcargasubseccion->m_get_subseccion(array($codcarga,$division));
            
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
            $curso = $this->mcargasubseccion->m_get_subseccion(array($codcarga,$division));
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
            $arraymc['curso'] = $this->mcargasubseccion->m_get_subseccion(array($codcarga,$division));
            $arraymc['material'] = $this->mvirtual->m_get_materiales(array($codcarga,$division));
            $this->load->view('sidebar');
            $arraymc['supervisa']="SI";
            $arraymc['tema']="Aula Virtual";
            $this->load->view('docentes/culminado/vw_curso_aula_virtual', $arraymc);
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
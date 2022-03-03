<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargasubseccion extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mcargasubseccion');
		$this->load->model('mmiembros');
	}

	public function vw_carga_subseccion_principal()
    {
		$ahead= array('page_title' =>'Carga Académica | Plataforma Virtual '.$this->config->item('erp_title')) ;
		$asidebar= array('menu_padre' =>'cargaacademica');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
        $this->load->view($vsidebar,$asidebar);
		
        $this->load->model('mcarrera'); 
        $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
		$this->load->model('mbeneficio');		
		$a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();

        $this->load->model('mperiodo');
		$a_ins['periodos']=$this->mperiodo->m_get_periodos();
		$this->load->model('mtemporal');
		$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
		//$this->load->model('mcarrera');
		$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
		//$this->load->model('mcarrera');
		$a_ins['secciones']=$this->mtemporal->m_get_secciones();
        $this->load->model('mplancurricular');
        $a_ins['planes']=$this->mplancurricular->m_get_planes_activos();
        //$a_ins['estados'] = $this->mmatricula->m_filtrar_estadoalumno();
        $this->load->model('mdocentes');
        $docentes=$this->mdocentes->m_get_docentes();
        foreach ($docentes as $key => $doc) {
        	$docentes[$key]->coddocente64=base64url_encode($docentes[$key]->coddocente);
        }
        $a_ins['docentes'] = $docentes;
        /*if (getPermitido("151")=='SI'){
            //PERMISO PARA CAMBIAR DE SEDE A UNA MATRICULA
            
            
        }*/
        $this->load->model('mmetodocalculo');
        $a_ins['metodos'] = $this->mmetodocalculo->m_get_metodos_activos();
        $this->load->model('msede');
        $a_ins['sedes'] = $this->msede->m_get_sedes_activos();
		//$modl=$this->mmodalidad->m_modalidad();
		$this->load->view('cargaacademica/vw_carga_academica',$a_ins);
		$this->load->view('footer');
	}

	public function fn_get_carga_subseccion_datos_completos(){

        //if ((getPermitido("51")=='SI') && ($_SESSION['userActivo']->tipo != 'AL')){
            $codcarga64=$this->input->post('codcarga');
            $division64=$this->input->post('division');
            $codcarga=base64url_decode($codcarga64);
            $division=base64url_decode($division64);

            $this->load->model('mevaluaciones');
            $this->load->model('masistencias');
            
            $dataex['vcurso'] =array();
            $dataex['vmiembros'] =array();
            $curso= $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $dominio=str_replace(".", "_",getDominio());
            if (isset($curso)) {
                $dataex['vcurso'] =$curso;
                
                $notas= $this->mevaluaciones->m_notas_x_curso(array($codcarga,$division));
                $evaluaciones_head= $this->mevaluaciones->m_eval_head_x_curso(array($codcarga,$division));

                $fechas=     $this->masistencias->m_fechas_x_curso(array($codcarga,$division));
                $asistencias= $this->masistencias->m_asistencias_x_curso(array($codcarga,$division));

                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($codcarga,$division));

                $dataex['vmiembros']    =$miembros;
                $idn=0;
                $anota="";
                $dataex['vnotas']=array();
                $dataex['vindicadores']=$indicadores;
                $dataex['vhead']=$evaluaciones_head;
                $dataex['vevaluaciones']=$notas;
                $alumno=array();
                if (count($evaluaciones_head)>0){
                    foreach ($miembros as $kmiembro => $miembro) {
                    	$miembros[$kmiembro]->idmiembro64=base64url_encode($miembros[$kmiembro]->idmiembro);
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
                    //$alumno=$funcionhelp($curso->metodo,$alumno,$indicadores);
                    $dataex['vnotas']=$alumno;
                 }
            } 
       /*}
       else{

       }*/
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


	public function fn_get_carga_subseccion_filtro()
	{
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$fcacbsede=$this->input->post('fmt-cbsede');
			$fcacbperiodo=$this->input->post('fmt-cbperiodo');
			$fcacbcarrera=$this->input->post('fmt-cbcarrera');
			$fcacbplan=$this->input->post('fmt-cbplan');
			$fcacbturno=$this->input->post('fmt-cbturno');
			$fcacbciclo=$this->input->post('fmt-cbciclo');
			$fcacbseccion=$this->input->post('fmt-cbseccion');
			$fcatxtbusqueda=trim($this->input->post('fmt-txtbusqueda'));
			$fmtcbdocente=trim($this->input->post('fmt-cbdocente'));
			
			
			$vcursos=$this->mcargasubseccion->m_get_carga_subseccion_filtro(array($fcacbsede,$fcacbperiodo,$fcacbcarrera,$fcacbplan,$fcacbciclo,$fcacbturno,$fcacbseccion,"%".$fcatxtbusqueda."%",$fmtcbdocente));
			
			//$cursos=$this->load->view('cargaacademica/wa-cacad-grupal-cursos',$vcursos, true);
			foreach ($vcursos as $key => $value) {
				$vcursos[$key]->codcarga64=base64url_encode($vcursos[$key]->codcarga);
				$vcursos[$key]->division64=base64url_encode($vcursos[$key]->division);
				$vcursos[$key]->coddocente64=base64url_encode($vcursos[$key]->coddocente);
			}
			$dataex['status'] =TRUE;
			$dataex['vdata'] =$vcursos;
		

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}




	public function fn_cambiardocente()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('fca-txtcoddocente','Docente','trim|required');
			$this->form_validation->set_rules('fca-txtsubseccion','Grupo','trim|required');
			$this->form_validation->set_rules('fca-txtcodcarga','Grupo','trim|required');
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
				$txtdocente=$this->input->post('fca-txtcoddocente');
				$txtsubseccion=base64url_decode($this->input->post('fca-txtsubseccion'));
				$txtcodcarga=base64url_decode($this->input->post('fca-txtcodcarga'));
				if ($txtdocente=='00000') {
					$txtdocente=null;
				}else{
					$txtdocente=base64url_decode($txtdocente);
				}
				$newcod=$this->mcargasubseccion->m_cambiar_docente(array($txtcodcarga,$txtsubseccion,$txtdocente));
				if ($newcod==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Docente asignado correctamente";
					
				}
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}



	public function fn_cambiar_metodo_calculo()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('codcarga','Carga','trim|required');
			$this->form_validation->set_rules('division','División','trim|required');
			$this->form_validation->set_rules('metodo','Método','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="<b>Existen errores en los campos</b>".validation_errors();;
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$txtmetodo=base64url_decode($this->input->post('metodo'));
				$txtsubseccion=base64url_decode($this->input->post('division'));
				$txtcodcarga=base64url_decode($this->input->post('codcarga'));
				
				$newcod=$this->mcargasubseccion->m_cambiar_metodo_calculo(array($txtcodcarga,$txtsubseccion,$txtmetodo));
				if ($newcod==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Docente asignado correctamente";
					
				}
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_fusionar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('fs-codcarga64_fusion','Carga','trim|required');
			$this->form_validation->set_rules('fs-division64_original','División','trim|required');
			$this->form_validation->set_rules('fs-codcarga64_original','Método','trim|required');
			$this->form_validation->set_rules('fs-division64_fusion','División','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="<b>Existen errores en los campos</b>".validation_errors();;
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$codcarga64_fusion=base64url_decode($this->input->post("fs-codcarga64_fusion"));
				$division64_fusion=base64url_decode($this->input->post("fs-division64_fusion"));
				$codcarga64_original=base64url_decode($this->input->post("fs-codcarga64_original"));
				$division64_original=base64url_decode($this->input->post("fs-division64_original"));
				
				$newcod=$this->mcargasubseccion->m_fusionar(array($codcarga64_original,$division64_original,$codcarga64_fusion,$division64_fusion));
				if ($newcod==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Docente asignado correctamente";
					
				}
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_culminar_carga_subseccion()
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
                        	$curso_principal= $this->mcargasubseccion->m_get_subseccion(array($curso->codcarga_fusion,$curso->division_fusion));
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
                                $arraymb['cursop'] =$curso_principal;
                                //$arraycs['curso'] =$curso;
                                $this->load->model('mevaluaciones');
                                $this->load->model('masistencias');
                                $this->load->model('mmiembros');
                                $notas= $this->mevaluaciones->m_notas_x_curso(array($curso->codcarga_fusion,$curso->division_fusion));
                                $evaluaciones= $this->mevaluaciones->m_eval_head_x_curso(array($curso->codcarga_fusion,$curso->division_fusion));

                                $fechas=     $this->masistencias->m_fechas_x_curso(array($curso->codcarga_fusion,$curso->division_fusion));
                                $asistencias= $this->masistencias->m_asistencias_x_curso(array($curso->codcarga_fusion,$curso->division_fusion));

                                $miembros= $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
                                $indicadores= $this->mevaluaciones->m_get_indicadores_por_carga_division(array($curso->codcarga_fusion,$curso->division_fusion));
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
                                    $alumno=$funcionhelp($curso_principal->metodo,$alumno,$indicadores);
                                    foreach ($miembros as $miembro) {
                                        if ($miembro->eliminado=='NO'){
                                            $falp=$alumno[$miembro->idmiembro]['asis']['faltas']/$curso_principal->sesiones * 100;  
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

                                                    if (!isset($miembro_mat->codmatfinal)){
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
                                                    	if ($miembro_mat->tipo=="PLATAFORMA"){
                                                    		if ($config_sede->conf_doc_rec=='NO'){
                                                            	$rpta=$this->mmatricula_independiente->m_update_nota_final_admin_recuperacion_sr(array($miembro_mat->codmatfinal,$curso->codunidad,$codcarga,$division,$pnf,$sts));  
	                                                        }
	                                                        else{
	                                                            //var_dump("EDITA");
	                                                            $rpta=$this->mmatricula_independiente->m_update_nota_final_admin_recuperacion(array($miembro_mat->codmatfinal,$curso->codunidad,$codcarga,$division,$pnf,$miembro->recuperacion,$sts)); 
	                                                        }
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

	public function fn_filtrar(){
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('periodo','Periodo','trim|required');
			$this->form_validation->set_rules('carrera','Carrera','trim|required');
			$this->form_validation->set_rules('ciclo','Ciclo','trim|required');

			$this->form_validation->set_rules('turno','Turno','trim|required');
			$this->form_validation->set_rules('seccion','Sección','trim|required');
			$this->form_validation->set_rules('plan','Plan','trim|required');

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
				$fcacbperiodo=$this->input->post('periodo');
				$fcacbcarrera=$this->input->post('carrera');
				$fcacbturno=$this->input->post('turno');
				$fcacbciclo=$this->input->post('ciclo');
				$fcacbseccion=$this->input->post('seccion');
				$fcacbplan=$this->input->post('plan');
				if ($fcacbplan==0) $fcacbplan="%";
				$vcursos=$this->mcargasubseccion->m_filtrar(array($_SESSION['userActivo']->idsede,$fcacbperiodo,$fcacbcarrera,$fcacbplan,$fcacbciclo,$fcacbturno,$fcacbseccion));
				
				//$cursos=$this->load->view('cargaacademica/wa-cacad-grupal-cursos',$vcursos, true);
				$dataex['status'] =TRUE;
				$dataex['vdata'] =$vcursos;
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}
	
	public function fn_agregardivision()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('fca-txtsubseccion','División','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fca-txtcodcarga','Grupo','trim|required');
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
				
				$txtsubseccion=$this->input->post('fca-txtsubseccion');
				$txtcodcarga=$this->input->post('fca-txtcodcarga');
				if ($txtsubseccion!=="0"){
					$newcod=$this->mcargasubseccion->m_agregar_division(array($txtcodcarga,$txtsubseccion));
					if ($newcod>0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="División correctamente";
						
					}
				}
				else{
					$dataex['status'] =FALSE;
						$dataex['msg'] ="Debes ingresar un numero de grupo válido";
				}
				
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_cambiardivision()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('fca-txtsubseccionnew','Docente','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fca-txtsubseccion','Grupo','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fca-txtcodcarga','Grupo','trim|required');
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
				$txtsubseccionnew=$this->input->post('fca-txtsubseccionnew');
				$txtsubseccion=$this->input->post('fca-txtsubseccion');
				$txtcodcarga=$this->input->post('fca-txtcodcarga');
				if ($txtsubseccionnew!=="0"){
					$newcod=$this->mcargasubseccion->m_cambiar_division(array($txtcodcarga,$txtsubseccion,$txtsubseccionnew));
					if ($newcod>0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="División correctamente";
						
					}
				}
				else{
					$dataex['status'] =FALSE;
						$dataex['msg'] ="Debes ingresar un numero de grupo válido";
				}
				
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_eliminardivision()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('fca-txtsubseccion','Grupo','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fca-txtcodcarga','Carga','trim|required');
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
				$txtsubseccion=$this->input->post('fca-txtsubseccion');
				$txtcodcarga=$this->input->post('fca-txtcodcarga');

					$newcod=$this->mcargasubseccion->m_eliminar_division(array($txtcodcarga,$txtsubseccion));
					if ($newcod>0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="División Eliminada correctamente";
						
					}
				
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_get_carga_por_docente()
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
			$this->form_validation->set_rules('fdc-cbperiodo','Periodo','trim|required|exact_length[5]');
			$this->form_validation->set_rules('fdc-cbdocente','Docente','trim|required');
			

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
				$fdccbperiodo=$this->input->post('fdc-cbperiodo');
				$fdccbdocente=$this->input->post('fdc-cbdocente');
				
				
				$vcursos['cargas']=$this->mcargasubseccion->m_get_subsecciones_por_docente($fdccbperiodo,$fdccbdocente);
				$cursos=$this->load->view('cargaacademica/docente/vw-cacad-docente-cursos',$vcursos, true);
				$dataex['status'] =TRUE;
				$dataex['vdata'] =$cursos;
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	



	
	


}
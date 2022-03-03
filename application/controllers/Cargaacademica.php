<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargaacademica extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mcargaacademica');

		

		
	}
	
	public function vw_carga_por_grupo(){
		$ahead= array('page_title' =>'Carga Académica por Grupo | Plataforma Virtual'  );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'cargaacademica','menu_nieto'=>'cargaxgrupo');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
        $this->load->view($vsidebar,$asidebar);
		$this->load->model('mubigeo');
				$this->load->model('mperiodo');
		$a_ins['periodos']=$this->mperiodo->m_get_periodos();
		$this->load->model('mcarrera');
		$a_ins['carreras']=$this->mcarrera->m_get_carreras_abiertas_por_sede($_SESSION['userActivo']->idsede);
		
		$this->load->model('mtemporal');
		$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
		//$this->load->model('mcarrera');
		$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
		//$this->load->model('mcarrera');
		$a_ins['secciones']=$this->mtemporal->m_get_secciones();
		$this->load->model('mdocentes');
		$docs=$this->mdocentes->m_get_docentes();
		$adocs=array();
		$adocs['00000']="SIN DOCENTE";
		foreach ($docs as $key => $doc) {
			if ($doc->activo='SI') $adocs[$doc->coddocente]=$doc->paterno." ".$doc->materno." ".$doc->nombres;
		}
		$a_ins['docentes']=$adocs;
		$this->load->view('cargaacademica/wa-cacad-grupal',$a_ins);
		$this->load->view('footer');
	}

	public function vw_carga_por_docente(){
		$ahead= array('page_title' =>'Carga Académica por Docente | Plataforma Virtual'  );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'cargaacademica','menu_nieto' =>'cargaxdocente');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
		$this->load->view($vsidebar,$asidebar);
		$this->load->model('mubigeo');
				$this->load->model('mperiodo');
		$a_ins['periodos']=$this->mperiodo->m_get_periodos();
		$this->load->model('mcarrera');
		$a_ins['carreras']=$this->mcarrera->m_get_carreras_abiertas_por_sede($_SESSION['userActivo']->idsede);
		
		$this->load->model('mtemporal');
		$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
		//$this->load->model('mcarrera');
		$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
		//$this->load->model('mcarrera');
		$a_ins['secciones']=$this->mtemporal->m_get_secciones();
		$this->load->model('mdocentes');
		$docs=$this->mdocentes->m_get_docentes();
		$adocs=array();
		$adocs['00000']="SIN DOCENTE";
		foreach ($docs as $key => $doc) {
			if ($doc->activo='SI') $adocs[$doc->coddocente]=$doc->paterno." ".$doc->materno." ".$doc->nombres;
		}
		$a_ins['docentes']=$adocs;
		$this->load->view('cargaacademica/docente/vw_cacad_docente',$a_ins);
		$this->load->view('footer');
	}


	public function fn_insert()
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
			$this->form_validation->set_rules('fca-cbperiodo','Periodo','trim|required|exact_length[5]');
			$this->form_validation->set_rules('fca-carrera','Carrera','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fca-cbciclo','Ciclo','trim|required|exact_length[2]');

			$this->form_validation->set_rules('fca-cbturno','Turno','trim|required|exact_length[1]');
			$this->form_validation->set_rules('fca-cbseccion','Sección','trim|required|exact_length[1]');

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
				$fcacbperiodo=$this->input->post('fca-cbperiodo');
				$fcacbcarrera=$this->input->post('fca-carrera');
				$fcacbturno=$this->input->post('fca-cbturno');
				$fcacbciclo=$this->input->post('fca-cbciclo');
				$fcacbseccion=$this->input->post('fca-cbseccion');
				$fcatxtunidad=$this->input->post('fca-txtunidad');

				$idsede = $_SESSION['userActivo']->idsede;

				//(( @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vcodigouindidadd
				$rp=$this->mcargaacademica->m_insert(array($fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion,$fcatxtunidad,$idsede));
				if ($rp->salida=='1'){
					
					/*if ($newcod>0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="División correctamente";
						
					}*/
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Carga registrada correctamente";
					$dataex['newcod'] =$rp->nid;
				}
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_activar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('fca-txtcarga','Carrera','trim|required|is_natural_no_zero');
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
				$txtcarga=$this->input->post('fca-txtcarga');
				$fcatxtactivar=$this->input->post('fca-txtactivar');
				
				$newcod=$this->mcargaacademica->m_activar(array($txtcarga, $fcatxtactivar));
				if ($newcod==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Carga activada correctamente";
				}
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_get_carga_por_grupo()
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
			$this->form_validation->set_rules('fca-cbperiodo','Periodo','trim|required|exact_length[5]');
			$this->form_validation->set_rules('fca-carrera','Carrera','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fca-cbciclo','Ciclo','trim|required|exact_length[2]');

			$this->form_validation->set_rules('fca-cbturno','Turno','trim|required|exact_length[1]');
			$this->form_validation->set_rules('fca-cbseccion','Sección','trim|required|exact_length[1]');

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
				$fcacbperiodo=$this->input->post('fca-cbperiodo');
				$fcacbcarrera=$this->input->post('fca-carrera');
				$fcacbturno=$this->input->post('fca-cbturno');
				$fcacbciclo=$this->input->post('fca-cbciclo');
				$fcacbseccion=$this->input->post('fca-cbseccion');
				$fcaplan=$this->input->post('fca-plan');
				$idsede = $_SESSION['userActivo']->idsede;
				$vcursos['cargas']=$this->mcargaacademica->m_get_carga_por_grupo_extendida(array($fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion,$fcaplan,$idsede));
				$this->load->model('mcargasubseccion');

				/*$vcursos['cargas']=$this->mcargaacademica->m_get_carga_por_grupo_extendida(array($fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion,$fcaplan,$idsede));
				$this->load->model('mcargasubseccion');*/
				$this->load->model('mgrupos');
				$grupo=$this->mgrupos->m_matriculas_x_grupo(array($idsede,$fcacbperiodo,$fcacbcarrera,$fcaplan,$fcacbciclo,$fcacbturno,$fcacbseccion));

				$vcursos['divisiones']=$this->mcargasubseccion->m_get_subsecciones_por_grupo(array($fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion,$fcaplan,$idsede));
				
				$cursos=$this->load->view('cargaacademica/wa-cacad-grupal-cursos',$vcursos, true);
				$dataex['status'] =TRUE;
				$dataex['vdata'] =$cursos;
				$dataex['grupo'] =$grupo;
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	/*public function fn_get_carga_filtrar_por_grupo()
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
			$this->form_validation->set_rules('fca-cbperiodo','Periodo','trim|required|exact_length[5]');
			$this->form_validation->set_rules('fca-carrera','Carrera','trim|required|is_natural_no_zero');
			//$this->form_validation->set_rules('fca-cbciclo','Ciclo','trim|required|exact_length[2]');

			//$this->form_validation->set_rules('fca-cbturno','Turno','trim|required|exact_length[1]');
			//$this->form_validation->set_rules('fca-cbseccion','Sección','trim|required|exact_length[1]');

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
				$fcacbperiodo=$this->input->post('fca-cbperiodo');
				$fcacbcarrera=$this->input->post('fca-carrera');
				$fcacbplan=$this->input->post('fca-plan');
				//$fcacbturno=$this->input->post('fca-cbturno');
				//$fcacbciclo=$this->input->post('fca-cbciclo');
				//$fcacbseccion=$this->input->post('fca-cbseccion');
				$vcursos['cargas']=$this->mcargaacademica->m_get_carga_por_grupo_extendida(array($fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion));
				$this->load->model('mcargasubseccion');
				$vcursos['divisiones']=$this->mcargasubseccion->m_get_subsecciones_por_grupo(array($fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion));
				
				$cursos=$this->load->view('cargaacademica/wa-cacad-grupal-cursos',$vcursos, true);
				$dataex['status'] =TRUE;
				$dataex['vdata'] =$cursos;
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}*/

}
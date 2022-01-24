<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plancurricular extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mplancurricular');
		$this->load->model('mperiodo');
		$this->load->model('mcarrera');
	}

	public function fn_get_planes_activos()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$dataex['vdata']  =array();
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodcarrera','Búsqueda','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda=$this->input->post('txtcodcarrera');
				$planes=$this->mplancurricular->m_get_planes_activos_carrera(array($busqueda));
				$dataex['vdata'] =$planes;
				$dataex['status'] =TRUE;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_get_planes_activos_combo()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$planes="<option value='0'>Plan curricular NO DISPONIBLE</option>";
		$dataex['vdata']  =$planes;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodcarrera','Búsqueda','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda=$this->input->post('txtcodcarrera');

				$rsplanes=$this->mplancurricular->m_get_planes_activos_carrera(array($busqueda));
				if (count($rsplanes)>0) $planes="<option value='0'>Selecciona el Plan curricular</option>";
				foreach ($rsplanes as $plan) {
                    $planes=$planes."<option value='$plan->codigo'>$plan->nombre</option>";
				}
				$dataex['vdata'] =$planes;
				$dataex['status'] =TRUE;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_get_cursos_por_plan()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$dataex['vdata']  =array();
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodplan','Búsqueda','trim|required');
			$this->form_validation->set_rules('fca-cbperiodo','Periodo','trim|required|exact_length[5]');
			$this->form_validation->set_rules('fca-carrera','Carrera','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fca-cbciclo','Ciclo','trim|required|exact_length[2]');

			$this->form_validation->set_rules('fca-cbturno','Turno','trim|required|exact_length[1]');
			$this->form_validation->set_rules('fca-cbseccion','Sección','trim|required|exact_length[1]');

			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$txtcodplan=$this->input->post('txtcodplan');
				$fcacbperiodo=$this->input->post('fca-cbperiodo');
				$fcacbcarrera=$this->input->post('fca-carrera');
				$fcacbturno=$this->input->post('fca-cbturno');
				$fcacbciclo=$this->input->post('fca-cbciclo');
				$fcacbseccion=$this->input->post('fca-cbseccion');
				$idsede = $_SESSION['userActivo']->idsede;
				$vcursos['unds']=$this->mplancurricular->m_get_cursos_por_plan(array($txtcodplan));
				$this->load->model('mcargaacademica');
				$vcursos['cargas']=$this->mcargaacademica->m_get_carga_por_grupo(array($fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion, $idsede));
				$cursos=$this->load->view('cargaacademica/vw-cursos-x-plan',$vcursos, true);
				$dataex['vdata'] =$cursos;
				$dataex['status'] =TRUE;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vw_plan_estudios(){
		$ahead= array('page_title' =>'Plan de Estudios | IESTWEB'  );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'planstd');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$arraydts['periodo'] = $this->mperiodo->m_get_periodos();
		$arraydts['carrera'] = $this->mcarrera->m_get_carreras();
		$this->load->view('academico/vwplan_estudios',$arraydts);
		$this->load->view('footer');
	}

	public function fn_filtrar_planes()
	{
		$this->form_validation->set_message('required', '* %s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsplanestud="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$rbgbusqueda=$this->input->post('rbgbusqueda');
			switch ($rbgbusqueda) {
				case 'xperiodo':
					$this->form_validation->set_rules('txtperiodo','periodo','trim|required|min_length[4]');
					break;
				case 'xcarrera':
					$this->form_validation->set_rules('txtbusqueda','carrera','trim|required|min_length[4]');
					break;
			}
			
			
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
				$busqueda=base64url_decode($this->input->post('txtbusqueda'));
				$txtperiodo=$this->input->post('txtperiodo');
				
				switch ($rbgbusqueda) {
					case 'xperiodo':
						$dtsplanes=$this->mplancurricular->m_plan_estudiosxperiodo(array($txtperiodo.'%'));
						break;
					case 'xcarrera':
						$dtsplanes=$this->mplancurricular->m_plan_estudiosxcarrera(array($busqueda.'%'));
						break;
					default:
						$dtsplanes=array();
						break;
				}

				if (isset($dtsplanes)) 
				$rsplanestud=$this->load->view('academico/plan_estudiosdts', $dtsplanes,TRUE);
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rsplanestud;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insert_plan_estudios()
	{
		$this->form_validation->set_message('required', '* %s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$this->form_validation->set_rules('fictxtnombre','nombre','trim|required');
			$this->form_validation->set_rules('cboperiodo','periodo','trim|required');
			$this->form_validation->set_rules('cbocarrera','carrera','trim|required');
			$this->form_validation->set_rules('fictxtdecreto','decreto','trim|required');
			$this->form_validation->set_rules('fictxtresolu','resolucion','trim|required');

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
				
				$codigo = base64url_decode($this->input->post('fictxtid'));
				$nombre = strtoupper($this->input->post('fictxtnombre'));
				$periodo = $this->input->post('cboperiodo');
				$carrera = $this->input->post('cbocarrera');
				$decreto = strtoupper($this->input->post('fictxtdecreto'));
				$resolucion = strtoupper($this->input->post('fictxtresolu'));
				$accion = $this->input->post('fictxtaccion');
				
				if ($accion == 'INSERTAR') {
					$rpta=$this->mplancurricular->insert_datos_plan(array($nombre, $periodo, $carrera, $decreto, $resolucion));
					if ($rpta > 0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos registrados correctamente";
					}
				} else if ($accion == 'EDITAR') {
					$rpta=$this->mplancurricular->update_datos_plan(array($codigo, $nombre, $periodo, $carrera, $decreto, $resolucion));
					if ($rpta == 1){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos actualizados correctamente";
					}
				}

			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwmostrar_datosxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcodigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$arrayhs['periodo'] = $this->mperiodo->m_get_periodos();
			$arrayhs['carrera'] = $this->mcarrera->m_get_carreras();
			$arrayhs['dtsplan'] = $this->mplancurricular->m_plan_estudiosxcodigo(array($txtcodigo));
			$msgrpta=$this->load->view('academico/plan_update', $arrayhs, true);
			
		}
		
		$dataex['planup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_eliminar_plan()
	{
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo plan', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este registro";
                $codigo = base64url_decode($this->input->post('txtcodigo'));
                
                $rpta = $this->mplancurricular->m_elimina_plan(array($codigo));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Plan de Estudios eliminado correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}

}
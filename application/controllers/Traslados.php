<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traslados extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('minscrito');
	}
	
	public function fn_traslados(){
		
			$ahead= array('page_title' =>'Admisión | IESTWEB'  );
			$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'traslado');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);

			if (getPermitido("47")=='SI'){
				$this->load->model('mmodalidad');
				$a_ins['modalidades']=$this->mmodalidad->m_get_modalidades();
				$this->load->model('mperiodo');
				$a_ins['periodos']=$this->mperiodo->m_get_periodos();
				$this->load->model('mcarrera');
				$a_ins['carreras']=$this->mcarrera->m_get_carreras_abiertas_por_sede($_SESSION['userActivo']->idsede);

				$this->load->model('mtemporal');
				$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
				$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
				$a_ins['secciones']=$this->mtemporal->m_get_secciones();
				$a_ins['docs_anexar']=$this->mtemporal->m_get_docs_por_anexar();

				$this->load->view('admision/vw_traslados',$a_ins);
			}
			else{

				$this->load->view('errors/sin-permisos');
			}
			
			
			$this->load->view('footer');
	}

	public function fn_getdocanexados(){
	
		$this->form_validation->set_message('required', '%s Requerido');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$fila= array('idinscripcion' => '0');
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('ce-idins','Carné','trim|required|min_length[4]');
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
				$busqueda=base64url_decode($this->input->post('ce-idins'));
				$rsfila=$this->minscrito->m_get_docsanexados(array($busqueda));
				$dataex['status'] =TRUE;
				$dataex['vdata'] =$rsfila;
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function get_filtrar_basico_sd_traslados(){
		$this->form_validation->set_message('required', '%s Requerido o digite %%%%%%%%');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fbus-txtbuscar','búsqueda','trim|required|min_length[4]');
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
				$busqueda=$this->input->post('fbus-txtbuscar');
				$carrera=$this->input->post('fbus-carrera');
				$periodo=$this->input->post('fbus-periodo');
				$cuentas['historial']=$this->minscrito->m_filtrar_basico_sd_traslados(array($periodo,$carrera,$_SESSION['userActivo']->idsede,'%'.$busqueda.'%',));
				$conteo=count($cuentas['historial']);
				if ($conteo>0)
				{
					$dataex['conteo'] =$conteo;
					$rscuentas=$this->load->view('admision/ltstraslados',$cuentas,TRUE);
				}
				else
				{
					$rscuentas=$this->load->view('errors/sin-resultados',array(),TRUE);
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}


}
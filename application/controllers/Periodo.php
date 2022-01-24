<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periodo extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mperiodo');
		$this->load->model('mdocentes');
	}
	
	public function nuevo_periodo()
	{
		$ahead= array('page_title' =>'Periodo Académico | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'periodo');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$arrayp['periodos'] = $this->mperiodo->m_periodos();
		$docs=$this->mperiodo->m_get_responsables();
		$adocs=array();
		$adocs['00000']="SIN RESPONSABLE";
		foreach ($docs as $key => $doc) {
			if ($doc->activo='SI') $adocs[$doc->coddocente]=$doc->paterno." ".$doc->materno." ".$doc->nombres;
		}
		$arrayp['docentes'] = $adocs;
		$this->load->view('admision/vw_periodos', $arrayp);
		$this->load->view('footer');
	}

	public function fn_insert_periodo()
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
			
			$this->form_validation->set_rules('fictxtidper','Código periodo','trim|required|is_unique[tb_periodo.ped_codigo]');
			$this->form_validation->set_rules('fictxtperiodo','Nombre periodo','trim|required');
			$this->form_validation->set_rules('fictxtestado','Estado','trim|required');
			$this->form_validation->set_rules('fictxtperanio','Año académico','trim|required');

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
				$fictxtidper=$this->input->post('fictxtidper');
				$fictxtperiodo=strtoupper($this->input->post('fictxtperiodo'));
				// $txtact=$this->input->post('txtact');
				$fictxtperanio=$this->input->post('fictxtperanio');
				$estado = $this->input->post('fictxtestado');
				$checkstatus = "NO";

				if ($this->input->post('checkactiva')!==null){
                    $checkstatus = $this->input->post('checkactiva');
                }

                if ($checkstatus=="on"){
                	$checkstatus = "SI";
                }

				$rpta=$this->mperiodo->Insert_datos_periodo(array($fictxtidper, $fictxtperiodo, $checkstatus, $fictxtperanio, $estado));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Periodo académico registrado correctamente";
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_periodo()
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
			
			$this->form_validation->set_rules('fictxtidpered','codigo periodo','trim|required');
			$this->form_validation->set_rules('fictxtperiodoed','nombre periodo','trim|required');
			$this->form_validation->set_rules('fictxtperanioed','año académico','trim|required');

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
				$fictxtidpered=$this->input->post('fictxtidpered');
				$codigantig = $this->input->post('fictxtcodant');
				$fictxtperiodoed=strtoupper($this->input->post('fictxtperiodoed'));
				$fictxtperanioed=$this->input->post('fictxtperanioed');
				$estado = $this->input->post('fictxtestadoed');

				$rpta=$this->mperiodo->Update_datos_periodo(array($codigantig, $fictxtperiodoed, $fictxtperanioed, $estado, $fictxtidpered));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Periodo académico actualizado correctamente";
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminarper()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idperiodo', 'codigo Periodo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta Periodo";
                $idperiodo    = $this->input->post('idperiodo');
                
                $rpta = $this->mperiodo->m_eliminaper(array($idperiodo));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Periodo eliminada correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_update_activo()
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
			
			$this->form_validation->set_rules('idperiodo','codigo periodo','trim|required');
			$this->form_validation->set_rules('activo','valor activo','trim|required');

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
				$idperiodo=$this->input->post('idperiodo');
				$activo=$this->input->post('activo');

				$rpta=$this->mperiodo->Update_activo_periodo(array($idperiodo, $activo));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Se modifico correctamente";
					
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function search_periodo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			$dataex['status']=false;
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$nomper = $this->input->post('txtnom');
			$periodolst = $this->mperiodo->m_get_periodosxnombre('%'.$nomper.'%');
			if ($periodolst > 0) {
                $dataex['status'] = true;
                $dataex['datos'] = $periodolst;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_cambiarresponsable()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('fictxtresponsable','Responsable','trim|required');
			$this->form_validation->set_rules('fictxtperiodo','Periodo','trim|required');

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
				$txtdocente=$this->input->post('fictxtresponsable');
				$txtperiodo=$this->input->post('fictxtperiodo');
				
				if ($txtdocente=='00000') $txtdocente=null;
				$newcod=$this->mperiodo->m_cambiar_responsable(array($txtperiodo,$txtdocente));
				if ($newcod==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Responsable asignado correctamente";
					
				}
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_status_inscripcion()
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
			
			$this->form_validation->set_rules('idperiodo','codigo periodo','trim|required');
			$this->form_validation->set_rules('activo','valor activo','trim|required');

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
				$idperiodo=$this->input->post('idperiodo');
				$activo=$this->input->post('activo');

				$rpta=$this->mperiodo->Update_status_inscripperiodo(array($idperiodo, $activo));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Se modifico correctamente";
					
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}
}
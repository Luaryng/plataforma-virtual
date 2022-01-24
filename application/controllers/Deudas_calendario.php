<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deudas_calendario extends CI_Controller {
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mperiodo');
		$this->load->model('mdeudas_calendario');
		
	}

	public function vw_principal(){
		if (getPermitido("106")=='SI'){
			
			$ahead= array('page_title' =>'Cronogramas - '.$this->ci->config->item('erp_title')  );
			$asidebar= array('menu_padre' =>'mn_deudas','menu_hijo' =>'mh_dd_calendario');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_facturacion',$asidebar);
			$arraydts['periodos'] = $this->mperiodo->m_get_periodos();
			$this->load->model('msede');
			$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
			$this->load->model('mbeneficio');
			$arraydts['beneficios'] = $this->mbeneficio->m_get_beneficios();

			
			$this->load->view('deudas/vw_calendario', $arraydts);
			$this->load->view('footer');
		}
		else{
			//$this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	//
	public function fn_guardar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		/*$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');*/

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			



			$this->form_validation->set_rules('vw_dci_txtcodigo','Código','trim|required');
			$this->form_validation->set_rules('vw_dci_txtnombre','Nombre periodo','trim|required');
			$this->form_validation->set_rules('vw_dci_txtinicia','Inicia','trim|required');
			$this->form_validation->set_rules('vw_dci_txtculmina','Culmina','trim|required');
			$this->form_validation->set_rules('vw_dci_cbperiodo','Periodo','trim|required');

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
				$vw_dci_codigo=$this->input->post('vw_dci_txtcodigo');
				$vw_dci_nombre=strtoupper($this->input->post('vw_dci_txtnombre'));
				$vw_dci_inicia=$this->input->post('vw_dci_txtinicia');
				$vw_dci_culmina=$this->input->post('vw_dci_txtculmina');
				$vw_dci_cbperiodo=$this->input->post('vw_dci_cbperiodo');
				$codsede=$_SESSION['userActivo']->idsede;
				if ($vw_dci_codigo=="0"){
					$rpta=$this->mdeudas_calendario->m_guardar(array($vw_dci_nombre, $vw_dci_inicia, $vw_dci_culmina, $vw_dci_cbperiodo,$codsede));
					
				}
				if ($rpta->salida=="1"){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Conograma registrado correctamente";
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_get_calendarios_xperiodo()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		/*$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');*/

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_dc_cbperiodo','Periodo','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
		        $dataex['msg']=validation_errors();
			}
			else
			{
				$vw_dc_cbperiodo=$this->input->post('vw_dc_cbperiodo');
				$vw_dc_cbsede=$this->input->post('vw_dc_cbsede');
				$filas=$this->mdeudas_calendario->m_get_calendarios_xperiodo_sede(array($vw_dc_cbperiodo,$vw_dc_cbsede));
				foreach ($filas as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->codigo);
				}
				$dataex['vdata']=$filas;
				$dataex['status'] =TRUE;
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	

}
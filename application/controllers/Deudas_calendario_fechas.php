<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deudas_calendario_fechas extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mperiodo');
		$this->load->model('mdeudas_calendario_fecha');
		$this->load->model('mgestion');
	}

	/*public function vw_principal(){
		if (getPermitido("55")=='SI'){
			$this->ci=& get_instance();
			$ahead= array('page_title' =>'Deudas Calendario- '.$this->ci->config->item('erp_title')  );
			$asidebar= array('menu_padre' =>'mn_deudas','menu_hijo' =>'mh_dd_calendario');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_facturacion',$asidebar);
			$arraydts['periodos'] = $this->mperiodo->m_get_periodos();
			$this->load->view('deudas/vw_calendario', $arraydts);
			$this->load->view('footer');
		}
		else{
			//$this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}*/

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
			$this->form_validation->set_rules('vw_cmda_txtcodigo','Código','trim|required');
			$this->form_validation->set_rules('vw_cmda_txtnombre','Nombre periodo','trim|required');
			$this->form_validation->set_rules('vw_cmda_txtinicia','Inicia','trim|required');
			$this->form_validation->set_rules('vw_cmda_txtcalendario','Calendario','trim|required');
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
				$vw_dci_codigo=$this->input->post('vw_cmda_txtcodigo');
				$vw_dci_nombre=strtoupper($this->input->post('vw_cmda_txtnombre'));
				$vw_dci_inicia=$this->input->post('vw_cmda_txtinicia');
				$vw_cmda_txtcalendario=base64url_decode($this->input->post('vw_cmda_txtcalendario'));
				if ($vw_dci_codigo=="0"){
					$rpta=$this->mdeudas_calendario_fecha->m_guardar(array($vw_dci_nombre, $vw_dci_inicia, $vw_cmda_txtcalendario));
				} else {
					$rpta=$this->mdeudas_calendario_fecha->m_update_fecha(array(base64url_decode($vw_dci_codigo),$vw_dci_nombre, $vw_dci_inicia, $vw_cmda_txtcalendario));
				}

				if ($rpta->salida=="1"){
					$fechas=$this->mdeudas_calendario_fecha->m_get_fechas_xcalendario(array($vw_cmda_txtcalendario));
					foreach ($fechas as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->codigo);
					}
					$dataex['status'] =TRUE;
					$dataex['fechas'] =$fechas;
					$dataex['msg'] ="Calendario guardado correctamente";
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	

	public function vw_modal_fechas()
	{
		$this->form_validation->set_message('required', '%s Requerido');

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_dcmd_calendario','Periodo','trim|required');
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
				$vw_dcmd_calendario64=$this->input->post('vw_dcmd_calendario');
				$vw_dcmd_calendario=base64url_decode($vw_dcmd_calendario64);
				$fechas=$this->mdeudas_calendario_fecha->m_get_fechas_xcalendario(array($vw_dcmd_calendario));
				foreach ($fechas as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->codigo);
				}
				$arraydts=array('idcalendario'=> $vw_dcmd_calendario64,'idfecha'=> "0",'fechas'=> $fechas);
				$arraydts['gestion'] =$this->mgestion->m_get_solo_gestion_order_categoria();
				
				$vista=$this->load->view('deudas/vw_calendario_cronograma', $arraydts ,true);

				//$filas=$this->mdeudas_calendario->m_get_calendarios_xperiodo(array($vw_dcmd_calendario));
				
				$dataex['vdata']=$vista;
				$dataex['status'] =TRUE;
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	

}
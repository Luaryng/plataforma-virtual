<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Nivel extends CI_Controller {
	private $ci;
	function __construct()
	{
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mnivel');
	}

	public function nuevo_nivel()
	{
		$ahead= array('page_title' =>'Niveles | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'niveles');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$nivl=$this->mnivel->m_niveles();
		$this->load->view('cuentas/vw_niveles', $nivl);
		$this->load->view('footer');
	}

	public function fn_insert_niveles()
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
			
			$this->form_validation->set_rules('fictxtidnivel','codigo nivel','trim|required');
			$this->form_validation->set_rules('fictxtnivel','nombre nivel','trim|required');

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
				$fictxtidnivel=$this->input->post('fictxtidnivel');
				$fictxtnivel=strtoupper($this->input->post('fictxtnivel'));

				$rpta=$this->mnivel->Insert_datos_nivel(array($fictxtidnivel, $fictxtnivel));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Nivel registrado correctamente";
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_niveles()
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
			
			$this->form_validation->set_rules('fictxtidniveled','codigo nivel','trim|required');
			$this->form_validation->set_rules('fictxtniveled','nombre nivel','trim|required');

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
				$fictxtidniveled = $this->input->post('fictxtidniveled');
				$fictxtniveled=strtoupper($this->input->post('fictxtniveled'));

				$rpta=$this->mnivel->Update_datos_nivel(array($fictxtidniveled, $fictxtniveled));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Nivel actualizado correctamente";
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminarniv()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idnivel', 'codigo Nivel', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta Nivel";
                $idnivel    = base64url_decode($this->input->post('idnivel'));
                
                $rpta = $this->mnivel->m_eliminaniv(array($idnivel));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Nivel eliminada correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function search_nivel()
    {
    	$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			$dataex['status']=false;
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$nomnivel = $this->input->post('nomnivel');
			$nivelst = $this->mnivel->m_nivelesxnombre('%'.$nomnivel.'%');
			if ($nivelst > 0) {
				foreach ($nivelst as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->codigo);
				}
                $dataex['status'] = true;
                $dataex['datos'] = $nivelst;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }

}
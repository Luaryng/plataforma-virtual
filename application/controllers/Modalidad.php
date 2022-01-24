<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modalidad extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mmodalidad');
	}

	public function nueva_modalidad()
	{
		$ahead= array('page_title' =>'Modalidad | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'modalidad');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$modl=$this->mmodalidad->m_modalidad();
		$this->load->view('modalidad/vw_modalidad', $modl);
		$this->load->view('footer');
	}

	public function fn_insert_modal()
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
			
			$this->form_validation->set_rules('fitxtmod','nombre modalidad','trim|required');

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
				$fitxtmod=strtoupper($this->input->post('fitxtmod'));
				$txtacmod=strtoupper($this->input->post('txtacmod'));

				$checkstatus = "NO";
				if ($this->input->post('checkestado')!==null){
                    $checkstatus = $this->input->post('checkestado');
                }

                if ($checkstatus=="on"){
                	$checkstatus = "SI";
                }

				$rpta=$this->mmodalidad->insert_datos_modalidad(array($fitxtmod, $checkstatus));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Modalidad registrada correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_modal()
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
			
			$this->form_validation->set_rules('fictxtidmod','codigo','trim|required');
			$this->form_validation->set_rules('fitxtmoded','nombre modalidad','trim|required');

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
				$fictxtidmod = base64url_decode($this->input->post('fictxtidmod'));
				$fitxtmoded = strtoupper($this->input->post('fitxtmoded'));

				$rpta=$this->mmodalidad->update_datos_modalidad(array($fictxtidmod, $fitxtmoded));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Modalidad actualizada correctamente";
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminarmodal()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idmodal', 'codigo Modalidad', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta Modalidad";
                $idmodal    = base64url_decode($this->input->post('idmodal'));
                
                $rpta = $this->mmodalidad->m_eliminamod(array($idmodal));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Modalidad eliminada correctamente';
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
			
			$this->form_validation->set_rules('idmodal','codigo campaña','trim|required');
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
				$idmodal = base64url_decode($this->input->post('idmodal'));
				$activo = $this->input->post('activo');

				$rpta=$this->mmodalidad->update_activ_modalidad(array($idmodal, $activo));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Se modifico correctamente";
					
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function search_modalidad()
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

			$nomodalidad = $this->input->post('nomodalidad');
			$modalidadlst = $this->mmodalidad->m_get_modalidadessearch('%'.$nomodalidad.'%');
			if ($modalidadlst > 0) {
				foreach ($modalidadlst as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->id);
				}
                $dataex['status'] = true;
                $dataex['datos'] = $modalidadlst;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Editorial extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('meditorial');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Editorial | IESTWEB'  );
		$asidebar= array('menu_padre' =>'biblioteca','menu_hijo' =>'editor');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('editorial/vw_editorial');
		$this->load->view('footer');
	}

	public function fn_insert_editorial()
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
			
			$this->form_validation->set_rules('fictxtnomedit','nombre editorial','trim|required');

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
				
				$codedit = base64url_decode($this->input->post('fictxtcodedit'));
				$fictxtnomedit=$this->input->post('fictxtnomedit');
				$fictxtaccion = $this->input->post('fictxtaccion');

				if ($fictxtaccion == "INSERTAR") {
					$rpta=$this->meditorial->insert_datos_editorial(array($fictxtnomedit));
					if ($rpta > 0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Editorial registrado correctamente";
						
					}
				} else if ($fictxtaccion == "EDITAR") {
					$rpta=$this->meditorial->update_datos_editorial(array($codedit, $fictxtnomedit));
					if ($rpta == 1){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Editorial actualizado correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function search_editorial(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			$dataex['status']=false;
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$this->form_validation->set_rules('txtnom','nombre editorial','trim|required|min_length[4]');

			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$nomed = $this->input->post('txtnom');
				$editorials = $this->meditorial->m_editorialxnombre($nomed.'%');
				if ($editorials > 0) {
                    $dataex['status'] = true;
                    $arrayedt['editor'] = $editorials;
                    $datos = $this->load->view('editorial/editorialdts', $arrayedt, true);
                    $dataex['datos'] = $datos;
                }
								
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_editorxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodedi', 'codigo libro', 'trim|required|min_length[4]');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcodedi = base64url_decode($this->input->post('txtcodedi'));
			$dataex['status'] =true;
			
			$arrayhs['deditorial'] = $this->meditorial->m_editorialxcodigo(array($txtcodedi));
			$msgrpta=$this->load->view('editorial/editorial_update', $arrayhs, true);
			
		}
		
		$dataex['editoup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_editorial()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('ideditor', 'codigo Campaña', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este editorial";
                $ideditor    = base64url_decode($this->input->post('ideditor'));
                
                $rpta = $this->meditorial->m_elimina_editorial(array($ideditor));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Editorial eliminado correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
}
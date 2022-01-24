<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nosotros extends CI_Controller {

	public function __construct()
    {
    	parent::__construct();
        //$this->load->helper("url");
        //$this->load->library('form_validation');
        $this->load->model('mempresa');
    }


	public function index()
	{
		$ahead= array('page_title' =>'NOSOTROS | IESTPWEB'  );
		$asidebar= array('menu_padre' =>'mision-vision','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_portal',$asidebar);
		$amodal = $this->mempresa->m_empresa_index();
		$this->load->view('nosotros/modal_empresa', $amodal);
		$this->load->view('nosotros/mision_vision');
		$this->load->view('footer');
	}

	public function fn_insert_mision()
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
			
			$this->form_validation->set_rules('fictxtcodigo','codigo','trim|required');
			$this->form_validation->set_rules('fictxtmision','descripcion','trim|required');

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
				$fictxtcodigo = base64url_decode($this->input->post('fictxtcodigo'));
				$fictxtmision= $this->input->post('fictxtmision');

            	$rpta=$this->mempresa->fn_update_datosEmpresa(array($fictxtcodigo, $fictxtmision, ''));
				if ($rpta == TRUE){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Misión actualizado correctamente";
				}
               
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_insert_vision()
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
			
			$this->form_validation->set_rules('fictxtcodigo','codigo','trim|required');
			$this->form_validation->set_rules('fictxtvision','descripcion','trim|required');

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
				$fictxtcodigo = base64url_decode($this->input->post('fictxtcodigo'));
				$fictxtvision= $this->input->post('fictxtvision');

            	$rpta=$this->mempresa->fn_update_datosEmpresa(array($fictxtcodigo, $fictxtvision, ''));
				if ($rpta == TRUE){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Visión actualizado correctamente";
				}
               
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}	

	public function fn_insert_organigrama()
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
			
			$this->form_validation->set_rules('fictxtcodigo','codigo','trim|required');

			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$dataex['errimg'] = 'No hay archivo seleccionado';
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$dataex['status'] =FALSE;
				$fictxtcodigo = base64url_decode($this->input->post('fictxtcodigo'));
				$imgexist = $this->input->post('fictxtimageexist');
				$ext = $this->input->post('extimg');
				
				date_default_timezone_set ('America/Lima');
				$nomimage = slugs($fictxtcodigo);
				
				$config = [
                    "upload_path"   => "./resources/img",
                    'allowed_types' => "png|jpg|JPG|jpeg|JPEG",
                    'file_name' => $nomimage.date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext,
                ];

                $this->load->library("upload", $config);
                
            	if ($this->upload->do_upload('fictxtorganigrama')) {
            		if ($imgexist != "") {
            			$registro = $this->mempresa->m_captura_organixcodigo($fictxtcodigo);
                    	unlink("./resources/img/" . $registro->imagen);
            		}
            		
                	$data  = array("upload_data" => $this->upload->data());
                	$portada = $nomimage.date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext;

                	$rpta=$this->mempresa->fn_update_datosEmpresa(array($fictxtcodigo, '', $portada));
					if ($rpta == TRUE){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Organigrama Actualizado correctamente";
						$dataex['errimg'] = '';
						
					}
                } else {
                	// $dataex['errimg'] = $this->upload->display_errors();

                	$rpta=$this->mempresa->fn_update_datosEmpresa(array($fictxtcodigo, '', $imgexist));
					if ($rpta == TRUE){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Organigrama Actualizado correctamente";
						$dataex['errimg'] = '';
						
					}
                }
            } 

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_insert_general()
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
			
			$this->form_validation->set_rules('fictxtcodigo','codigo','trim|required');
			$this->form_validation->set_rules('fictxtobjgen','descripcion','trim|required');

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
				$fictxtcodigo = base64url_decode($this->input->post('fictxtcodigo'));
				$fictxtobjgen= $this->input->post('fictxtobjgen');

            	$rpta=$this->mempresa->fn_update_datosEmpresa(array($fictxtcodigo, $fictxtobjgen, ''));
				if ($rpta == TRUE){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Objetivo general actualizado correctamente";
				}
               
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_insert_fines()
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
			
			$this->form_validation->set_rules('fictxtcodigo','codigo','trim|required');
			$this->form_validation->set_rules('valorFines','descripcion','trim|required');

			for($i = 1; $i < 4; $i++){
				$this->form_validation->set_rules('fictxttitulo'.$i,'titulo','trim|required');
				$this->form_validation->set_rules('fictxtdescripcion'.$i,'detalle','trim|required');
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
				$dataex['status'] =FALSE;
				$fictxtcodigo = base64url_decode($this->input->post('fictxtcodigo'));
				$valorFines= $this->input->post('valorFines');

            	$rpta = $this->mempresa->fn_update_datosEmpresa(array($fictxtcodigo, $valorFines, ''));
				if ($rpta == TRUE){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Fines actualizado correctamente";
				}
               
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}


}

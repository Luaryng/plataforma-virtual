<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Autor extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mautores');
	}
	
	public function index($nomaut = ""){
		$ahead= array('page_title' =>'Autores | IESTWEB'  );
		$asidebar= array('menu_padre' =>'biblioteca','menu_hijo' =>'autor');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('autores/vw_autores');
		$this->load->view('footer');
	}

	public function fn_insert_autor()
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
			
			$this->form_validation->set_rules('fictxtnomaut','nombre autor','trim|required');

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
				
				$codaut = base64url_decode($this->input->post('fictxtcodaut'));
				$fictxtnomaut=$this->input->post('fictxtnomaut');
				$fictxtaccion = $this->input->post('fictxtaccion');

				if ($fictxtaccion == "INSERTAR") {
					$rpta=$this->mautores->insert_datos_autores(array($fictxtnomaut));
					if ($rpta > 0){

						$ses_usuario = $_SESSION['userActivo'];
						$contenido = "$ses_usuario->usuario - $ses_usuario->paterno $ses_usuario->materno $ses_usuario->nombres, está ingresando un Autor en la tabla TB_AUTORES COD.".$rpta;
						$this->mauditoria->insert_datos_auditoria(array($ses_usuario->idusuario, $fictxtaccion, $contenido, $ses_usuario->idsede));

						$dataex['status'] =TRUE;
						$dataex['msg'] ="Autor registrado correctamente";
						
					}
				} else if ($fictxtaccion == "EDITAR") {
					$rpta=$this->mautores->update_datos_autores(array($codaut, $fictxtnomaut));
					if ($rpta == 1){

						$ses_usuario = $_SESSION['userActivo'];
						$contenido = "$ses_usuario->usuario - $ses_usuario->paterno $ses_usuario->materno $ses_usuario->nombres, está editando un Autor en la tabla TB_AUTORES COD.".$codaut;
						$this->mauditoria->insert_datos_auditoria(array($ses_usuario->idusuario, $fictxtaccion, $contenido, $ses_usuario->idsede));

						$dataex['status'] =TRUE;
						$dataex['msg'] ="Autor actualizado correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function search_autores(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			$dataex['status']=false;
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$this->form_validation->set_rules('txtnom','nombre autor','trim|required|min_length[4]');

			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$nomed = $this->input->post('txtnom');
				$editorials = $this->mautores->m_autoresxnombre($nomed.'%');
				if ($editorials > 0) {
                    $dataex['status'] = true;
                    $arrayedt['autores'] = $editorials;
                    $datos = $this->load->view('autores/autoresdts', $arrayedt, true);
                    $dataex['datos'] = $datos;
                }
								
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_autorxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodaut', 'codigo libro', 'trim|required|min_length[4]');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcodaut = base64url_decode($this->input->post('txtcodaut'));
			$dataex['status'] =true;
			
			$arrayhs['dautores'] = $this->mautores->m_autoresxcodigo(array($txtcodaut));
			$msgrpta=$this->load->view('autores/autor_update', $arrayhs, true);
			
		}
		
		$dataex['autorup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_autor()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idautor', 'codigo Campaña', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este autor";
                $idautor    = base64url_decode($this->input->post('idautor'));
                
                $rpta = $this->mautores->m_elimina_autores(array($idautor));
                if ($rpta == 1) {

                	$ses_usuario = $_SESSION['userActivo'];
					$contenido = "$ses_usuario->usuario - $ses_usuario->paterno $ses_usuario->materno $ses_usuario->nombres, está eliminando un Autor en la tabla TB_AUTORES COD.".$idautor;
					$this->mauditoria->insert_datos_auditoria(array($ses_usuario->idusuario, "ELIMINAR", $contenido, $ses_usuario->idsede));

                    $dataex['status'] = true;
                    $dataex['msg']    = 'Editorial eliminado correctamente';
                }
                //11219579 nota de credito
                //11219751 cerveza malograda
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
}
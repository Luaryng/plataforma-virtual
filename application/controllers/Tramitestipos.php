<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tramitestipos extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mauditoria');

		$this->load->model('mtramites_tipo');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Trámites tipos | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'tipostramit');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		
		$arraydts['tipos'] =$this->mtramites_tipo->m_get_tramites_tipos();
		$this->load->view('tramites/tipos/lts_tipos_tramites', $arraydts);
		$this->load->view('footer');
	}

	public function fn_insert_update()
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
			
			$this->form_validation->set_rules('fictxtnombre','nombre area','trim|required');
			

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
				
				$codigo = $this->input->post('fictxtcodigo');
				$nombre = $this->input->post('fictxtnombre');
				
				
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;


				if ($codigo == "0") {
					$rpta=$this->mtramites_tipo->mInsert_tipos(array($nombre));
					if ($rpta > 0){
						$fictxtaccion = "INSERTAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando un tipo trámite en la tabla TB_TRAMITES_TIPOS COD.".$rpta;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Registro ingresado correctamente";
						$dataex['ficaccion'] = $fictxtaccion;
						
					}
				} else {
					$rpta=$this->mtramites_tipo->mUpdate_tipos(array($codigo, $nombre));
					if ($rpta == 1){
						$fictxtaccion = "EDITAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un tipo trámite en la tabla TB_TRAMITES_TIPOS COD.".$codigo;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Registro actualizado correctamente";
						$dataex['ficaccion'] = $fictxtaccion;
						$dataex['idtipo'] = $codigo;
						$dataex['tiponame'] = $nombre;
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwmostrar_registroxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo area', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$msgrpta = $this->mtramites_tipo->m_filtrar_itemxcodigo(array($codigo));
			
		}
		
		$dataex['tiposup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_item()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idtipo', 'codigo tipo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este item";
                $idtipo    = base64url_decode($this->input->post('idtipo'));
                $accion    = $this->input->post('accion');

                $estado = "";

                if ($accion == "Deshabilitar") {
                	$estado ="SI";
                } else {
                	$estado ="NO";
                }
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un tipo trámite en la tabla TB_TRAMITES_TIPOS COD.".$idtipo;
				
                $rpta = $this->mtramites_tipo->m_eliminaitem(array($estado, $idtipo));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Registro actualizado correctamente';
                    $dataex['estado'] = $estado;

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function search_tipostram()
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

			$nomtipo = $this->input->post('nomtipo');
			$tiposlst = $this->mtramites_tipo->m_get_tramites_tiposxnombre('%'.$nomtipo.'%');
			if ($tiposlst > 0) {
				foreach ($tiposlst as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->codigo);
				}
                $dataex['status'] = true;
                $dataex['datos'] = $tiposlst;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }

}
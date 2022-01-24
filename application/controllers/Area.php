<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('marea');
		$this->load->model('mdocentes');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Area | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'area');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$arraydts['areas'] =$this->marea->m_filtrar_area(array($_SESSION['userActivo']->idsede));
		$arraydts['docentes'] =$this->mdocentes->m_get_docentes_administrativos();
		$this->load->view('area/ltsarea', $arraydts);
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
			$this->form_validation->set_rules('fictxtencarg','encargado','trim|required');
			// $this->form_validation->set_rules('fictxtemail','correo','trim|required');

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
				$encargado = $this->input->post('fictxtencarg');
				$correo = $this->input->post('fictxtemail');
				$fictxtaccion = $this->input->post('fictxtaccion');
				$checkstatus = "NO";
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				if ($this->input->post('checkestado')!==null){

                     $checkstatus = $this->input->post('checkestado');

                }

                if ($checkstatus=="on"){

                	$checkstatus = "SI";

                }

				if ($fictxtaccion == "INSERTAR") {
					$rpta=$this->marea->mInsert_area(array($nombre, $checkstatus, $encargado, $correo, $sede));
					if ($rpta > 0){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una área en la tabla TB_AREA COD.".$rpta;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Área registrada correctamente";
						
					}
				} else if ($fictxtaccion == "EDITAR") {
					$rpta=$this->marea->mUpdate_area(array($codigo, $nombre, $checkstatus, $encargado, $correo, $sede));
					if ($rpta == 1){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una área en la tabla TB_AREA COD.".$codigo;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Área actualizado correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwmostrar_areaxcodigo(){
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
			
			$msgrpta = $this->marea->m_filtrar_areaxcodigo(array($codigo));
			
		}
		
		$dataex['areaup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_area()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idarea', 'codigo área', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este área";
                $idarea    = base64url_decode($this->input->post('idarea'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una área en la tabla TB_AREA COD.".$idarea;
				
                $rpta = $this->marea->m_eliminaarea(array($idarea));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Área eliminada correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function search_areas()
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

			$nomarea = $this->input->post('nomarea');
			$sede = $_SESSION['userActivo']->idsede;
			$areaslst = $this->marea->m_get_areasxnombre(array('%'.$nomarea.'%', $sede));
			if ($areaslst > 0) {
				foreach ($areaslst as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->codigo);
				}
                $dataex['status'] = true;
                $dataex['datos'] = $areaslst;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Practicas_modalidad extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mpracticas_modalidad');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		$ahead= array('page_title' =>'MODALIDAD PRÁCTICAS | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'practicas_acad','menu_nieto' => 'mn_acad_modalidad');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
		$this->load->view($vsidebar,$asidebar);
		$this->load->view('practicas/modalidad_practicas/ltsmodalidades');
		$this->load->view('footer');
	}

	public function fn_filtro_modalidades()
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

			$nommodalidad = $this->input->post('nommodalidad');
			
			$modlst = $this->mpracticas_modalidad->m_get_modalidadxnombre(array('%'.$nommodalidad.'%'));
			
			for ($i=0; $i < count($modlst) ; $i++) { 
				$modlst[$i]->codigo_64=base64url_encode($modlst[$i]->codigo);
			}
            $dataex['status'] = true;
            $dataex['datos'] = $modlst;
            
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
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
			$codigo = $this->input->post('fictxtcodigo');
			if ($codigo == "0") {
				$this->form_validation->set_rules('fictxtnombre','nombre modalidad','trim|required|is_unique[tb_practica_modalidad.pm_nombre]');
			} else {
				$this->form_validation->set_rules('fictxtnombre','nombre modalidad','trim|required');
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
				
				$codigo64 = base64url_decode($codigo);
				$nombre = mb_strtoupper($this->input->post('fictxtnombre'));
				
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				if ($codigo == "0") {
					$rpta=$this->mpracticas_modalidad->mInsert_modalidad(array($nombre));
					$fictxtaccion = "INSERTAR";
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una modalidad en la tabla TB_PRACTICA_MODALIDAD COD.".$rpta->newcod;
										
					$mensaje ="Modalidad registrada correctamente";
					
				} else {
					$rpta=$this->mpracticas_modalidad->mUpdate_modalidad(array($codigo64, $nombre));
					$fictxtaccion = "EDITAR";
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una modalidad en la tabla TB_PRACTICA_MODALIDAD COD.".$rpta->newcod;
					
					$mensaje ="Modalidad actualizado correctamente";
					
				}

				if ($rpta->salida == 1){
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					$dataex['status'] =TRUE;
					$dataex['msg'] = $mensaje;
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwmostrar_modalidadxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo modalidad', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$msgrpta = $this->mpracticas_modalidad->m_filtrar_modalidadxcodigo(array($codigo));

			if ($msgrpta) {
				$dataex['status'] =TRUE;
			}
			
		}
		
		$dataex['vdata'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_modalidad()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idmodalidad', 'codigo modalidad', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta modalidad";
                $idmodalidad    = base64url_decode($this->input->post('idmodalidad'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una modalidad en la tabla TB_PRACTICA_MODALIDAD COD.".$idmodalidad;
				
                $rpta = $this->mpracticas_modalidad->m_eliminamodalidad(array($idmodalidad));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Empresa eliminada correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    

}

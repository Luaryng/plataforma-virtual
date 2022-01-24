<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Moduloeducativo extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mmodeducativo');
		$this->load->model('mplancurricular');
		$this->load->model('mcarrera');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Módulo educativo | IESTWEB'  );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'modeduca');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$arraydts['carreras'] = $this->mcarrera->m_get_carreras();
		$arraydts['planes'] = $this->mplancurricular->m_plan_estudiosactivos();
		$arraydts['modulos'] = $this->mmodeducativo->m_get_modulos();
		$this->load->view('moduloeducativo/vw_modulo', $arraydts);
		$this->load->view('footer');
	}

	public function fn_insert_modulos()
	{
		$this->form_validation->set_message('required', '* %s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$this->form_validation->set_rules('fictxtnombre','nombre modulo','trim|required');
			$this->form_validation->set_rules('fictxtmodnum','numero modulo','trim|required');
			$this->form_validation->set_rules('cboplanestud','plan estudios','trim|required');
			$this->form_validation->set_rules('fictxthoras','horas','trim|required');
			$this->form_validation->set_rules('fictxtcreditos','creditos','trim|required');

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
				
				$codigo = base64url_decode($this->input->post('fictxtcodigo'));
				$nombre = $this->input->post('fictxtnombre');
				$numerom = $this->input->post('fictxtmodnum');
				$planes = $this->input->post('cboplanestud');
				$horasm = $this->input->post('fictxthoras');
				$creditosm = $this->input->post('fictxtcreditos');
				$accion = $this->input->post('fictxtaccion');
				
				if ($accion == 'INSERTAR') {
					$rpta=$this->mmodeducativo->insert_datos_modulo(array($nombre, $numerom, $planes, $horasm, $creditosm));
					if ($rpta > 0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Módulo educativo registrados correctamente";
					}
				} else if ($accion == 'EDITAR') {
					$rpta=$this->mmodeducativo->update_datos_modulo(array($codigo, $nombre, $numerom, $planes, $horasm, $creditosm));
					if ($rpta == 1){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Módulo educativo actualizados correctamente";
					}
				}

			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function search_modulos(){
		$this->form_validation->set_message('required', '* %s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rspmodulo="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$rbgbusqueda=$this->input->post('rbgbusqueda');
			switch ($rbgbusqueda) {
				case 'xnombre':
					$this->form_validation->set_rules('txtnombre','nombre módulo','trim|required|min_length[4]');
					break;
				case 'xcarrera':
					$this->form_validation->set_rules('txtbusqueda','carrera','trim|required|min_length[4]');
					break;
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
				$busqueda=base64url_decode($this->input->post('txtbusqueda'));
				$txtnombre=base64url_decode($this->input->post('txtnombre'));
				
				switch ($rbgbusqueda) {
					case 'xnombre':
						$dtsmod=$this->mmodeducativo->m_get_modulosxnombre(array($txtnombre.'%'));
						break;
					case 'xcarrera':
						$dtsmod=$this->mmodeducativo->m_get_modulosxcarrera(array($busqueda.'%'));
						break;
					default:
						$dtsmod=array();
						break;
				}

				if (isset($dtsmod)) 
				$rspmodulo=$this->load->view('moduloeducativo/moduloeducadts', $dtsmod,TRUE);
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rspmodulo;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_datosxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcodigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$arrayhs['planes'] = $this->mplancurricular->m_plan_estudiosactivos();
			$arrayhs['dtsmodulo'] = $this->mmodeducativo->m_get_modulosxcodigo(array($txtcodigo));
			$msgrpta=$this->load->view('moduloeducativo/modulos_update', $arrayhs, true);
			
		}
		
		$dataex['modulup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_eliminar_modulo()
	{
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo modulo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este registro";
                $codigo = base64url_decode($this->input->post('txtcodigo'));
                
                $rpta = $this->mmodeducativo->m_elimina_modulo(array($codigo));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Módulo educativo eliminado correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}
}
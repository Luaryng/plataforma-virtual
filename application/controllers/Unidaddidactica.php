<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Unidaddidactica extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mmodeducativo');
		$this->load->model('mplancurricular');
		$this->load->model('munidaddidactica');
		$this->load->model('mcarrera');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Unidad didáctica | IESTWEB'  );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'unidac');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$arraydts['ciclo'] = $this->munidaddidactica->m_get_ciclo();
		$arraydts['carreras'] = $this->mcarrera->m_get_carreras();
		$arraydts['planes'] = $this->mplancurricular->m_plan_estudios_tabla();
		$arraydts['modulos'] = $this->mmodeducativo->m_get_modulos_tabla();
		$this->load->view('unidades/vw_unidaddidac', $arraydts);
		$this->load->view('footer');
	}

	public function fnmodulo_x_planes()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin opciones</option>";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtplan','plan','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda=$this->input->post('txtplan');

				$modulos=$this->mmodeducativo->m_get_modulosxplanes(array($busqueda));
				if (count($modulos)>0) $rsoptions="<option value=''>Seleccionar modulo</option>";
				foreach ($modulos as $mdls) {
					$rsoptions=$rsoptions."<option value='$mdls->codigo'>$mdls->nombre</option>";
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rsoptions;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_unidad_x_parametros(){
		$this->form_validation->set_message('required', '* %s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rspunidad="";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';			
			
			$txtplan = base64url_decode($this->input->post('txtplan'));
			$txtmodulo = base64url_decode($this->input->post('txtmodulo'));
			$txtcarrera = base64url_decode($this->input->post('txtcarrera'));
			$txtciclo = base64url_decode($this->input->post('txtciclo'));
			$valike = '%';
			
			if ($txtplan == 0) {
				$txtplan = $valike;
			} 
			if ($txtmodulo == 0) {
				$txtmodulo = $valike;
			}
			if ($txtcarrera == 0) {
				$txtcarrera = $valike;
			}
			if ($txtciclo == 0) {
				$txtciclo = $valike;
			}
			$dtsunidad = $this->munidaddidactica->m_get_unidadesxparametros(array($txtplan, $txtmodulo, $txtcarrera, $txtciclo));

			if (isset($dtsunidad)) 
			$rspunidad=$this->load->view('unidades/unididacticadts', $dtsunidad,TRUE);
			$dataex['status'] =TRUE;
		}
		$dataex['vdata'] =$rspunidad;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insert_unidades()
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
			$this->form_validation->set_rules('cbotipound','tipo unidad','trim|required');
			$this->form_validation->set_rules('cbociclo','ciclo','trim|required');
			$this->form_validation->set_rules('cbomodulo','modulo','trim|required');
			$this->form_validation->set_rules('fictxthorter','horas teoria','trim|required');
			$this->form_validation->set_rules('fictxthorprac','horas practica','trim|required');
			$this->form_validation->set_rules('fictxthorcic','horas ciclo','trim|required');
			$this->form_validation->set_rules('fictxtcredter','creditos teoria','trim|required');
			$this->form_validation->set_rules('fictxtcredprac','creditos practica','trim|required');

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
				$tipound = $this->input->post('cbotipound');
				$ciclo = $this->input->post('cbociclo');
				$modulo = $this->input->post('cbomodulo');
				$horter = $this->input->post('fictxthorter');
				$horprac = $this->input->post('fictxthorprac');
				$horcic = $this->input->post('fictxthorcic');
				$creditoteo = $this->input->post('fictxtcredter');
				$creditoprac = $this->input->post('fictxtcredprac');
				$accion = $this->input->post('fictxtaccion');
				
				if ($accion == 'INSERTAR') {
					$rpta=$this->munidaddidactica->insert_datos_unidad(array($nombre, $tipound, $ciclo, $modulo, $horter, $horprac, $horcic, $creditoteo, $creditoprac));
					if ($rpta > 0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Unidad didáctica registrada correctamente";
					}
				} else if ($accion == 'EDITAR') {
					$rpta=$this->munidaddidactica->update_datos_unidad(array($codigo, $nombre, $tipound, $ciclo, $modulo, $horter, $horprac, $horcic, $creditoteo, $creditoprac));
					if ($rpta == 1){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Unidad didáctica actualizada correctamente";
					}
				}

			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_get_unidades_combo()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        $unidades="<option value='0'>Plan curricular NO DISPONIBLE</option>";
        $dataex['vdata']  =$unidades;
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodciclo','ciclo','trim|required');
            $this->form_validation->set_rules('txtcodplan','plan curricular','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']=validation_errors();
            }
            else
            {
                $ciclo = $this->input->post('txtcodciclo');
                $plan = $this->input->post('txtcodplan');
                $sede = $_SESSION['userActivo']->idsede;

                $rsunidades=$this->munidaddidactica->m_get_unidad_x_plan_ciclo(array($plan, $ciclo));
                if (count($rsunidades)>0) $unidades="<option value='0'>Selecciona Unidad</option>";
                foreach ($rsunidades as $und) {
                    $unidades=$unidades."<option value='$und->codunidad'>$und->nombre</option>";
                }
                $dataex['vdata'] =$unidades;
                $dataex['status'] =TRUE;
            }
        }
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
			
			$arrayhs['ciclo'] = $this->munidaddidactica->m_get_ciclo();
			$arrayhs['modulos'] = $this->mmodeducativo->m_get_modulos();
			$arrayhs['dtsunidad'] = $this->munidaddidactica->m_get_unidadxcodigo(array($txtcodigo));
			$msgrpta=$this->load->view('unidades/unidades_update', $arrayhs, true);
			
		}
		
		$dataex['unidup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_eliminar_unidad()
	{
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo unidad didactica', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este registro";
                $codigo = base64url_decode($this->input->post('txtcodigo'));
                
                $rpta = $this->munidaddidactica->m_elimina_unidad(array($codigo));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Unidad didáctica eliminado correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Practicas_etapas_plan extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mpracticas_etapas_plan');
		$this->load->model('mpracticas_etapas');
		$this->load->model('mplancurricular');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		$ahead= array('page_title' =>'PLAN ETAPAS PRÁCTICAS | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'practicas_acad','menu_nieto' => 'mn_acad_etapas_plan');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
		$this->load->view($vsidebar,$asidebar);
		$arraydts['etapas'] = $this->mpracticas_etapas->m_filtrar_etapasxestado();
		$this->load->model('mcarrera'); 
        $arraydts['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
		$this->load->view('practicas/practicas_etapas_plan/ltsetapas_plan', $arraydts);
		$this->load->view('footer');
	}

	public function fn_filtro_etapas_plan()
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

			$nometapa = $this->input->post('nometapa');
			
			$etaplst = $this->mpracticas_etapas_plan->m_get_etapas_planxnombre(array('%'.$nometapa.'%'));
			if ($etaplst > 0) {
				foreach ($etaplst as $key => $fila) {
					$fila->fhoras = number_format($fila->horas, 2, '.', '');
				}
                $dataex['status'] = true;
                $dataex['datos'] = $etaplst;
            }
								
			
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
			
			$this->form_validation->set_rules('fictxtetapa','nombre etapa','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fmt-cbcarrera','programa','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fictxtplan_estudios','plan','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fictxthoras','Horas','trim|required');

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
				
				$codetapa = $this->input->post('fictxtetapa');
				$codplan = $this->input->post('fictxtplan_estudios');
				$horas = $this->input->post('fictxthoras');
				$checkstatus = "NO";

				$codetapaant = $this->input->post('fictxtetapaant');
				$codplanant = $this->input->post('fictxtplan_estudiosant');
				
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				if ($this->input->post('checkestado')!==null){
                    $checkstatus = $this->input->post('checkestado');
                }

                if ($checkstatus=="on"){
                	$checkstatus = "SI";
                }

				if (($codetapaant == '0') && ($codplanant) == '0') {
					$rpta=$this->mpracticas_etapas_plan->mInsert_etapas_plan(array($codetapa, $codplan, $horas, $checkstatus));
					$fictxtaccion = "INSERTAR";
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una etapa plan en la tabla TB_PRACTICA_ETAPAS_PLAN CODETAPA.".$codetapa." - CODPLAN.".$codplan;
										
					$mensaje ="Datos registrados correctamente";
					
				} else {
					$rpta=$this->mpracticas_etapas_plan->mUpdate_etapas_plan(array($codetapa, $codplan, base64url_decode($codetapaant), base64url_decode($codplanant), $horas, $checkstatus));
					$fictxtaccion = "EDITAR";
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una etapa plan en la tabla TB_PRACTICA_ETAPAS_PLAN CODETAPA.".base64url_decode($codetapaant)." - CODPLAN.".base64url_decode($codplanant);
					
					$mensaje ="Datos actualizados correctamente";
					
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

	public function vwmostrar_etapa_planxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo etapa', 'trim|required');
		$this->form_validation->set_rules('txtplan', 'codigo plan', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$txtplan = base64url_decode($this->input->post('txtplan'));
			$dataex['status'] =true;
			
			$msgrpta = $this->mpracticas_etapas_plan->m_get_etapas_plan_codigos(array($codigo, $txtplan));

			if ($msgrpta) {
				$dataex['status'] =TRUE;
				//BUSCAR PLAN
				$rsplan="<option value='0'>Sin opciones</option>";
				$planes=$this->mplancurricular->m_get_planes_activos_carrera(array($msgrpta->idcarrera));
				if (count($planes)>0) $rsplan="<option value='0'>Selecciona el Plan curricular</option>";
				foreach ($planes as $plan) {
					$rsplan=$rsplan."<option value='$plan->codigo'>$plan->nombre</option>";
				}
			}
			
		}
		
		$dataex['vdata'] = $msgrpta;
		$dataex['planes'] = $rsplan;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_etapa_plan()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idetapa', 'codigo etapa', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta etapa";
                $idetapa    = base64url_decode($this->input->post('idetapa'));
                $idplan    = base64url_decode($this->input->post('idplan'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una etapa en la tabla TB_PRACTICA_ETAPAS_PLAN CODETAPA.".$idetapa." - CODPLAN.".$idplan;
				
                $rpta = $this->mpracticas_etapas_plan->m_eliminaetapa_plan(array($idetapa, $idplan));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Dato eliminado correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    

}

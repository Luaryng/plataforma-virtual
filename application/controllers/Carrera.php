<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrera extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mcarrera');
		$this->load->model('mauditoria');
	}
	
	public function vw_sprincipal(){
		$ahead= array('page_title' =>'CARRERA | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'carrera');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$arraydts['carreras'] =$this->mcarrera->m_lts_carreras();
		$this->load->view('carreras/ltscarreras', $arraydts);
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
			
			$this->form_validation->set_rules('fictxtcodigo','codigo','trim|required');
			$this->form_validation->set_rules('fictxtnombre','nombre','trim|required');
			$this->form_validation->set_rules('fictxtsigla','sigla','trim|required');
			$this->form_validation->set_rules('fictxtabrev','abreviatura','trim|required');
			$this->form_validation->set_rules('fictxtnivelf', 'nivel formativo','trim|required');

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
				$antiguo = $this->input->post('fictxtcodantig');
				$nombre = $this->input->post('fictxtnombre');
				$sigla = $this->input->post('fictxtsigla');
				$abrev = $this->input->post('fictxtabrev');
				$nivel = $this->input->post('fictxtnivelf');
				$fictxtaccion = $this->input->post('fictxtaccion');
				$checkabierta = "NO";
				$checkstatus = "NO";
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				if ($this->input->post('checkabierta')!==null){

                     $checkabierta = $this->input->post('checkabierta');

                }

                if ($checkabierta=="on"){

                	$checkabierta = "SI";

                }

				if ($this->input->post('checkestado')!==null){

                     $checkstatus = $this->input->post('checkestado');

                }

                if ($checkstatus=="on"){

                	$checkstatus = "SI";

                }

				if ($fictxtaccion == "INSERTAR") {
					$rpta=$this->mcarrera->mInsert_carrera(array($codigo, $nombre, $sigla, $abrev, $checkabierta, $checkstatus, $nivel));
					if ($rpta > 0){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una carrera en la tabla TB_CARRERA COD.".$rpta;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Carrera registrado correctamente";
						
					}
				} else if ($fictxtaccion == "EDITAR") {
					$rpta=$this->mcarrera->mUpdate_carrera(array($codigo, $nombre, $sigla, $abrev, $checkabierta, $checkstatus, $nivel, $antiguo));
					if ($rpta == 1){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una carrera en la tabla TB_CARRERA COD.".$codigo;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Carrera actualizado correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwmostrar_carreraxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo carrera', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$msgrpta = $this->mcarrera->m_lts_carrerasxcodigo(array($codigo));
			
		}
		
		$dataex['carrup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_carrera()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idcarrera', 'codigo carrera', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este carrera";
                $idcarrera    = base64url_decode($this->input->post('idcarrera'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una carrera en la tabla TB_CARRERA COD.".$idcarrera;
				
                $rpta = $this->mcarrera->m_eliminacarrera(array($idcarrera));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Carrera eliminada correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function search_carrera()
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

			$nomcarrera = $this->input->post('nomcarrera');
			$carreraslst = $this->mcarrera->m_get_carrerasxnombre('%'.$nomcarrera.'%');
			if ($carreraslst > 0) {
				foreach ($carreraslst as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->id);
				}
                $dataex['status'] = true;
                $dataex['datos'] = $carreraslst;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }

}
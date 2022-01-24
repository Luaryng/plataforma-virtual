<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Carrera_sede extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('msede');
		$this->load->model('mcarrera_sede');
		$this->load->model('mauditoria');
		$this->load->model('mcarrera');
	}


	public function vw_ltsprincipal()
	{
		$ahead= array('page_title' =>'CARRERAS POR SEDES | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'carrsed');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$arraydts['activos'] = $this->msede->m_get_sedes_activos();
		$arraydts['carreras'] = $this->mcarrera->m_lts_carreras_activas();
		//)
		$arraydts['carrsed'] = $this->mcarrera_sede->m_get_carreras_xsede(array($_SESSION['userActivo']->idsede));
		$this->load->view('sedes/sedes_carreras', $arraydts);
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
			
			$this->form_validation->set_rules('fictxtnomsed','sede','trim|required');
			$this->form_validation->set_rules('fictxtnomcarr','carrera','trim|required');
			$this->form_validation->set_rules('fictxtcostins','costo inscripción','trim|required');
			$this->form_validation->set_rules('fictxtcostmat','costo matricula','trim|required');
			$this->form_validation->set_rules('fictxtcostotal','costo total','trim|required');
			$this->form_validation->set_rules('fictxtcostcont','costo contado','trim|required');
			$this->form_validation->set_rules('fictxtnrocuotas','nro cuotas','trim|required');

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
				$sedantig = $this->input->post('fictxtcodsedantg');
				$carrantig = $this->input->post('fictxtcodcarantg');
				$codsede = $this->input->post('fictxtnomsed');
				$carrera = $this->input->post('fictxtnomcarr');
				$inscripción = $this->input->post('fictxtcostins');
				$matricula = $this->input->post('fictxtcostmat');
				$total = $this->input->post('fictxtcostotal');
				$contado = $this->input->post('fictxtcostcont');
				$cuotas = $this->input->post('fictxtnrocuotas');

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

					$rpta = $this->mcarrera_sede->mInsert_carrera_sede(array($codsede, $carrera, $inscripción, $matricula, $total, $contado, $cuotas, $checkabierta, $checkstatus));
					$dataex['msg'] =$rpta;
					if ($rpta == 1){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una sede a carrera en la tabla TB_CARRERA_SEDE COD_SEDE.".$codsede.", COD_CARRERA.".$carrera;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Se registro correctamente";
						
					}
				} 
				else if ($fictxtaccion == "EDITAR") {
					$rpta=$this->mcarrera_sede->mUpdate_carrera_sede(array($codsede, $carrera, $inscripción, $matricula, $total, $contado, $cuotas, $checkabierta, $checkstatus, $sedantig, $carrantig));
					if ($rpta == 1){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una sede a carrera en la tabla TB_CARRERA_SEDE COD_SEDE.".$sedantig.", COD_CARRERA.".$carrantig;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Se actualizado correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwmostrar_datoxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtidsede', 'codigo sede', 'trim|required');
		$this->form_validation->set_rules('txtidcarrera', 'codigo carrera', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtidsede'));
			$carrera = base64url_decode($this->input->post('txtidcarrera'));
			$dataex['status'] =true;
			
			$msgrpta = $this->mcarrera_sede->m_get_carrerasedesxcodigo(array($codigo, $carrera));
			
		}
		
		$dataex['sedeup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_registro()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idsede', 'codigo sede', 'trim|required');
            $this->form_validation->set_rules('idcarrera', 'codigo carrera', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este sede";
                $idsedec    = base64url_decode($this->input->post('idsede'));
                $idcarrera    = base64url_decode($this->input->post('idcarrera'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un registro en la tabla TB_CARRERA_SEDE COD_SEDE.".$idsedec.", COD_CARRERA.".$idcarrera;
				
                $rpta = $this->mcarrera_sede->m_eliminasedecarrera(array($idsedec, $idcarrera));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Sede eliminada correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function search_carrerasede()
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

			$nomsede = $this->input->post('nomsede');
			$sedescarlst = $this->mcarrera_sede->m_get_carrerasedesxnombre(array('%'.$nomsede.'%',$_SESSION['userActivo']->idsede));
			if ($sedescarlst > 0) {
				foreach ($sedescarlst as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->idsede);
					$fila->codcarre64=base64url_encode($fila->idcarrera);
				}
                $dataex['status'] = true;
                $dataex['datos'] = $sedescarlst;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }


}
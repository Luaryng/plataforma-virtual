<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deudas_calendario_fechas_item extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mdeudas_calendario_fecha_item');
		$this->load->model('mdeudas_calendario_grupo');
		$this->load->model('mdocentes');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Area | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'deudas','menu_hijo' =>'deudas_items');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		// $this->load->view('area/ltsarea');
		$this->load->view('footer');
	}

	public function fn_get_itemscobro_x_fecha(){
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('vw_cmdi_txtcal64', 'codigo deuda fecha', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error";
                $idcodigo    = base64url_decode($this->input->post('vw_cmdi_txtcalfecha64'));
                $idcalendario   = base64url_decode($this->input->post('vw_cmdi_txtcal64'));
                
                
				$dataex['status'] = true;
                $dataex['vdata'] = $this->mdeudas_calendario_fecha_item->m_get_items_cobro_x_fecha(array($idcodigo));
                $dataex['vgrupos']=$this->mdeudas_calendario_grupo->m_get_grupos_xcalendario(array($idcalendario));
               
            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
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
			
			$this->form_validation->set_rules('fictxtcal_fecha','codigo Calendario fecha','trim|required');
			$this->form_validation->set_rules('fictxtcodgestion','codigo gestion','trim|required');
			$this->form_validation->set_rules('fictxt_repite','repite','trim|required');

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
				
				$codigo64 = $this->input->post('fictxtcodigo');
				
				$cal_fecha = base64url_decode($this->input->post('fictxtcal_fecha'));
				$gestion = $this->input->post('fictxtcodgestion');
				$repite = $this->input->post('fictxt_repite');
				$monto = $this->input->post('fictxt_monto');
				
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				if ($codigo64 == "0") {
					$rpta=$this->mdeudas_calendario_fecha_item->mInsert_deudas_calendario_item(array($cal_fecha, $gestion, $repite, $monto));
					if ($rpta->salida > 0){
						$fictxtaccion = "INSERTAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una deuda item en la tabla TB_DEUDA_CALENDARIO_FECHA_ITEM COD.".$rpta->newcod;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Dato registrado correctamente";
						
					}
				} else {
					$codigo = base64url_decode($codigo64);
					$rpta=$this->mdeudas_calendario_fecha_item->mUpdate_deudas_calendario_item(array($codigo, $cal_fecha, $gestion, $repite, $monto));
					if ($rpta->salida == 1){
						$fictxtaccion = "EDITAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una deuda item en la tabla TB_DEUDA_CALENDARIO_FECHA_ITEM COD.".$codigo;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Dato actualizado correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminar_deuda_item()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idcodigo', 'codigo deuda item', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este área";
                $idcodigo    = base64url_decode($this->input->post('idcodigo'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una deuda item en la tabla TB_DEUDA_CALENDARIO_FECHA_ITEM COD.".$idcodigo;
				
                $rpta = $this->mdeudas_calendario_fecha_item->mDelete_deudas_calendario_item(array($idcodigo));
                if ($rpta->salida == 1) {
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
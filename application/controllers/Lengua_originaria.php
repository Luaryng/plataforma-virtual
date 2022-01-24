<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lengua_originaria extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mlenguas');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		if (getPermitido("133")=='SI') {
			$ahead= array('page_title' =>'LENGUA ORIGINARIA | '.$this->ci->config->item('erp_title') );
			$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'lengua','menu_nieto' => '');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$arraydts['lenguas'] = $this->mlenguas->m_get_lenguas();
			$this->load->view('lenguas/ltslenguas', $arraydts);
			$this->load->view('footer');
		} else {
            $urlref=base_url();
            header("Location: $urlref", FILTER_SANITIZE_URL);
        }
		
	}

	public function fn_search_lenguas()
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

			$nomlengua = $this->input->post('nomlengua');
			
			$lengualst = $this->mlenguas->m_get_lenguasxnombre(array('%'.$nomlengua.'%'));
			if ($lengualst > 0) {
                $dataex['status'] = true;
                $dataex['datos'] = $lengualst;
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
			if ((getPermitido("134")=='SI') || (getPermitido("135")=='SI')) {
				$this->form_validation->set_rules('fictxtnombre','nombre lengua originaria','trim|required');

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
					$codigo64 = base64url_decode($codigo);
					$nombre = $this->input->post('fictxtnombre');
					
					$usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;

					if ($codigo == "0") {
						$rpta=$this->mlenguas->mInsert_lengua(array($nombre));
						$fictxtaccion = "INSERTAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando un registro en la tabla TB_LENGUAS COD.".$rpta->newcod;
											
						$mensaje ="Dato registrado correctamente";
						
					} else {
						$rpta=$this->mlenguas->mUpdate_lengua(array($codigo64, $nombre));
						$fictxtaccion = "EDITAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un registro en la tabla TB_LENGUAS COD.".$rpta->newcod;
						
						$mensaje ="Dato actualizado correctamente";
						
					}

					if ($rpta->salida == 1){
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['accion'] = $fictxtaccion;
						$dataex['msg'] = $mensaje;
					}
					
				}
			} else {
				$dataex['status'] =false;
				$dataex['msg'] = "No tienes acceso para esta acción";
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwmostrar_lenguaxcodigo(){
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
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$msgrpta = $this->mlenguas->m_get_lenguasxcodigo(array($codigo));

			if ($msgrpta) {
				$dataex['status'] =TRUE;
				$dataex['vdata'] = $msgrpta;
			}
			
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_lengua()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            if (getPermitido("136")=='SI') {
	            $this->form_validation->set_rules('idlengua', 'codigo', 'trim|required');
	            if ($this->form_validation->run() == false) {
	                $dataex['msg'] = validation_errors();
	            } else {
	                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta lengua originaria";
	                $idlengua    = base64url_decode($this->input->post('idlengua'));
	                
	                $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
					$fictxtaccion = "ELIMINAR";
	                
	                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un registro en la tabla TB_LENGUAS COD.".$idlengua;
					
	                $rpta = $this->mlenguas->m_eliminalengua(array($idlengua));
	                if ($rpta == 1) {
	                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
	                    $dataex['status'] = true;
	                    $dataex['msg']    = 'Dato eliminado correctamente';

	                }

	            }
	        } else {
				$dataex['status'] =false;
				$dataex['msg'] = "No tienes acceso para esta acción";
			}

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    

}

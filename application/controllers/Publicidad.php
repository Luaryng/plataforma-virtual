<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicidad extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mpublicidad');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		if (getPermitido("129")=='SI') {
			$ahead= array('page_title' =>'PUBLICIDAD | '.$this->ci->config->item('erp_title') );
			$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'publicidad','menu_nieto' => '');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$arraydts['publicidad'] = $this->mpublicidad->m_get_publicidades();
			$this->load->view('publicidad/ltspublicidad', $arraydts);
			$this->load->view('footer');
		} else {
            $urlref=base_url();
            header("Location: $urlref", FILTER_SANITIZE_URL);
        }
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
			if ((getPermitido("130")=='SI') || (getPermitido("131")=='SI')) {
				$this->form_validation->set_rules('fictxtnombre','nombre','trim|required');

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
					$checkstatus = "NO";
					
					$usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;

					if ($this->input->post('checkestado')!==null){
	                    $checkstatus = $this->input->post('checkestado');
	                }

	                if ($checkstatus=="on"){
	                	$checkstatus = "SI";
	                }

					if ($codigo == "0") {
						$rpta=$this->mpublicidad->mInsert_publicidad(array($nombre, $checkstatus));
						$fictxtaccion = "INSERTAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una publicidad en la tabla TB_PUBLICIDAD COD.".$rpta->newcod;
											
						$mensaje ="Dato registrado correctamente";
						
					} else {
						$rpta=$this->mpublicidad->mUpdate_publicidad(array($codigo64, $nombre, $checkstatus));
						$fictxtaccion = "EDITAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una publicidad en la tabla TB_PUBLICIDAD COD.".$rpta->newcod;
						
						$mensaje ="Dato actualizado correctamente";
						
					}

					if ($rpta->salida == 1){
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['accion'] = $fictxtaccion;
						$dataex['newcod'] = base64url_encode($rpta->newcod);
						$dataex['estado'] = $checkstatus;
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

	public function vwmostrar_publicidadxcodigo(){
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
			
			$msgrpta = $this->mpublicidad->m_get_publicidadesxcodigo(array($codigo));

			if ($msgrpta) {
				$dataex['status'] =TRUE;
			}
			
		}
		
		$dataex['vdata'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_publicidad()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            if (getPermitido("132")=='SI') {
	            $this->form_validation->set_rules('idpublic', 'codigo', 'trim|required');
	            if ($this->form_validation->run() == false) {
	                $dataex['msg'] = validation_errors();
	            } else {
	                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este item";
	                $idpublic    = base64url_decode($this->input->post('idpublic'));
	                
	                $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
					$fictxtaccion = "ELIMINAR";
	                
	                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un item en la tabla TB_PUBLICIDAD COD.".$idpublic;
					
	                $rpta = $this->mpublicidad->m_eliminapublicidad(array($idpublic));
	                if ($rpta == 1) {
	                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
	                    $dataex['status'] = true;
	                    $dataex['msg']    = 'item eliminado correctamente';

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

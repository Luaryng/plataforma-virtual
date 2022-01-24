<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discapacidad extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mdiscapacidad');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		$ahead= array('page_title' =>'DISCAPACIDAD | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'discapacidad','menu_nieto' => '');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$arraydts['grupos'] = $this->mdiscapacidad->m_get_discapacidadxgrupo();
		$this->load->view('discapacidad/ltsdiscapacidad', $arraydts);
		$this->load->view('footer');
	}

	public function fn_filtro_discapacidades()
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

			$nomdiscap = $this->input->post('nomdiscap');
			
			$disclst = $this->mdiscapacidad->m_get_discapacidadxnombre(array('%'.$nomdiscap.'%'));
			if ($disclst > 0) {
                $dataex['status'] = true;
                $dataex['datos'] = $disclst;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }

    public function vwmostrar_discapacidadxgrupo()
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

			// $nomdiscap = $this->input->post('nomdiscap');
			
			$disclst = $this->mdiscapacidad->m_get_discapacidadxgrupo();
			if ($disclst > 0) {
                $dataex['status'] = true;
                $dataex['vdata'] = $disclst;
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
			
			$this->form_validation->set_rules('fictxtnombre','nombre','trim|required');
			// $this->form_validation->set_rules('fictxtdetalle','detalle','trim|required');

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
				$detalle = $this->input->post('fictxtdetalle');
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
					$rpta=$this->mdiscapacidad->mInsert_discapacidad(array($nombre, $detalle, $checkstatus));
					$fictxtaccion = "INSERTAR";
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una discapacidad en la tabla TB_DISCAPACIDAD COD.".$rpta->newcod;
										
					$mensaje ="Dato registrado correctamente";
					
				} else {
					$rpta=$this->mdiscapacidad->mUpdate_discapacidad(array($codigo64, $nombre, $detalle, $checkstatus));
					$fictxtaccion = "EDITAR";
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una discapacidad en la tabla TB_DISCAPACIDAD COD.".$rpta->newcod;
					
					$mensaje ="Dato actualizado correctamente";
					
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

	public function vwmostrar_discapacidadxcodigo(){
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
			
			$msgrpta = $this->mdiscapacidad->m_filtrar_discapacidadxcodigo(array($codigo));

			if ($msgrpta) {
				$dataex['status'] =TRUE;
			}
			
		}
		
		$dataex['vdata'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_discapacidad()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('iddiscap', 'codigo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este item";
                $iddiscap    = base64url_decode($this->input->post('iddiscap'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un item en la tabla TB_DISCAPACIDAD COD.".$iddiscap;
				
                $rpta = $this->mdiscapacidad->m_eliminadiscap(array($iddiscap));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Etapa eliminada correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    

}

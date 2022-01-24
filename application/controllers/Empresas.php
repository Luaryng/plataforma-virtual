<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mempresas');
		$this->load->model('mubigeo');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
		$ahead= array('page_title' =>'Empresas | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'practicas_acad','menu_nieto' => 'mn_acad_empresas');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view($vsidebar,$asidebar);
		$arraydts['departamentos'] = $this->mubigeo->m_departamentos();
		$this->load->view('practicas/empresas/ltsempresas', $arraydts);
		$this->load->view('footer');
	}

	public function fn_search_empresas()
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

			$nomempresa = $this->input->post('nomempresa');
			
			$empresalst = $this->mempresas->m_get_empresasxnombre(array('%'.$nomempresa.'%'));
			if ($empresalst > 0) {
                $dataex['status'] = true;
                $dataex['datos'] = $empresalst;
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
			
			$this->form_validation->set_rules('fictxtnombre','nombre empresa','trim|required');
			$this->form_validation->set_rules('fictxtruc','encargado','trim|required');
			$this->form_validation->set_rules('ficbdepartamento','departamento','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbprovincia','provincia','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbdistrito','distrito','trim|required|is_natural_no_zero');

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
				$nombre = mb_strtoupper($this->input->post('fictxtnombre'));
				$ruc = $this->input->post('fictxtruc');
				$direccion = mb_strtoupper($this->input->post('fictxtdireccion'));
				$telefono = $this->input->post('fictxttelefono');
				$distrito = $this->input->post('ficbdistrito');
				$contactapellidos = mb_strtoupper($this->input->post('fictxtcontacapellidos'));
				$contactnombres = mb_strtoupper($this->input->post('fictxtcontacnombres'));
				$contactelefono = $this->input->post('fictxtcontactelefono');
				
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				if ($codigo == "0") {
					$rpta=$this->mempresas->mInsert_empresa(array($nombre, $ruc, $direccion, $telefono, $distrito, $contactapellidos, $contactnombres, $contactelefono));
					$fictxtaccion = "INSERTAR";
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una empresa en la tabla TB_EMPRESAS COD.".$rpta->newcod;
										
					$mensaje ="Empresa registrada correctamente";
					
				} else {
					$rpta=$this->mempresas->mUpdate_empresa(array($codigo64, $nombre, $ruc, $direccion, $telefono, $distrito, $contactapellidos, $contactnombres, $contactelefono));
					$fictxtaccion = "EDITAR";
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una empresa en la tabla TB_EMPRESAS COD.".$rpta->newcod;
					
					$mensaje ="Empresa actualizado correctamente";
					
				}

				if ($rpta->salida == 1){
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					$dataex['status'] =TRUE;
					$dataex['accion'] = $fictxtaccion;
					$dataex['msg'] = $mensaje;
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwmostrar_empresaxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo empresa', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$msgrpta = $this->mempresas->m_filtrar_empresaxcodigo(array($codigo));

			if ($msgrpta) {
				$dataex['status'] =TRUE;
				//BUSCAR UBIGEO
				$rsprov="<option value='0'>Sin opciones</option>";
				$provincias=$this->mubigeo->m_provincias(array($msgrpta->iddepartamento));
				if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
				foreach ($provincias as $provincia) {
					$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
				}

				$rsdistri="<option value='0'>Sin opciones</option>";
				$distritos=$this->mubigeo->m_distritos(array($msgrpta->idprovincia));
				if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
				foreach ($distritos as $distrito) {
					$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
				}
			}
			
		}
		
		$dataex['vdata'] = $msgrpta;
		$dataex['provincias']=$rsprov;
		$dataex['distritos']=$rsdistri;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_empresa()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idempresa', 'codigo empresa', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta empresa";
                $idempresa    = base64url_decode($this->input->post('idempresa'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una empresa en la tabla TB_EMPRESAS COD.".$idempresa;
				
                $rpta = $this->mempresas->m_eliminaempresa(array($idempresa));
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

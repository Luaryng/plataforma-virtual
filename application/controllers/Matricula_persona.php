<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Persona.php';
class Matricula_persona extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mdocentes');
		$this->load->model('mmatricula_persona');
	}

	public function vw_filtrar_persona(){
		$ahead= array('page_title' =>'Admisión | ERP'  );
		$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'searchper');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->model('mubigeo');
		
		$this->load->view('admision/vw_personal_matricula');
		$this->load->view('footer');
	}

	public function fn_filtrar_historial()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtbusqueda','Búsqueda','trim|required|min_length[4]');
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
				$busqueda=$this->input->post('txtbusqueda');
				
				$cuentas=$this->mmatricula_persona->m_filtrar_data_persona(array('%'.$busqueda.'%'));
				$conteo=count($cuentas);
				if ($conteo>0)
				{
					$dataex['conteo'] =$conteo;
					foreach ($cuentas as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->idpersona);
					}
					$rscuentas=$cuentas;
				}
				else
				{
					$rscuentas="";
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_update_data()
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
			
			$this->form_validation->set_rules('fictxtcodigo','Código','trim|required');
			$this->form_validation->set_rules('fictxtnombre','Nombre','trim|required');
			$this->form_validation->set_rules('fictxtapepaterno','Apellido paterno','trim|required');
			$this->form_validation->set_rules('fictxtapematerno','Apellido materno','trim|required');
			$this->form_validation->set_rules('fictxtsexo','sexo','trim|required');

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
				$categoria = "00.00";
				
				$codigo = base64url_decode($this->input->post('fictxtcodigo'));
				$nombre = $this->input->post('fictxtnombre');
				
				$apepaterno = $this->input->post('fictxtapepaterno');
				$apematerno = $this->input->post('fictxtapematerno');
				$sexo = $this->input->post('fictxtsexo');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "EDITAR";

				$rpta=$this->mmatricula_persona->mUpdate_datos(array($codigo, $apepaterno, $apematerno, $nombre, $sexo));

				if ($rpta == 1){
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando datos personales en la tabla TB_PERSONA COD.".$codigo;
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					
					$dataex['status'] =TRUE;
					// $dataex['codigo64'] = base64url_encode($codigo);
					$dataex['msg'] ="Datos actualizados correctamente";
					
				}
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_vwmatriculas()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rsmatriculas="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fictxtcarne','Carne','trim|required|min_length[4]');
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
				$busqueda=$this->input->post('fictxtcarne');
				
				$matriculas=$this->mmatricula_persona->m_filtrar_matriculaxcarne(array($busqueda));
				$conteo=count($matriculas);
				if ($conteo>0)
				{
					$dataex['conteo'] =$conteo;
					foreach ($matriculas as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->codigo);
					}
					$rsmatriculas=$matriculas;
				}
				else
				{
					$rsmatriculas="";
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rsmatriculas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_update_data_matricula()
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
			
			$this->form_validation->set_rules('fictxtcodigo','Código','trim|required');
			$this->form_validation->set_rules('fictxtnombre','Nombre','trim|required');
			$this->form_validation->set_rules('fictxtapepaterno','Apellido paterno','trim|required');
			$this->form_validation->set_rules('fictxtapematerno','Apellido materno','trim|required');
			$this->form_validation->set_rules('fictxtsexo','sexo','trim|required');

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
				$categoria = "00.00";
				
				$codigo = base64url_decode($this->input->post('fictxtcodigo'));
				$nombre = $this->input->post('fictxtnombre');
				
				$apepaterno = $this->input->post('fictxtapepaterno');
				$apematerno = $this->input->post('fictxtapematerno');
				$sexo = $this->input->post('fictxtsexo');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "EDITAR";

				$rpta=$this->mmatricula_persona->mUpdate_datos_matricula(array($codigo, $apepaterno, $apematerno, $nombre, $sexo));

				if ($rpta == 1){
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando datos personales en la tabla TB_MATRICULA COD.".$codigo;
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Datos actualizados correctamente";
					
				}
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}
    

}

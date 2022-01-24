<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admision extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('madmision');
		$this->load->model('mlenguas');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Admisión | IESTWEB'  );
		$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'ficha');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		//$this->load->view('sidebar',$asidebar);
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
        $this->load->view($vsidebar,$asidebar);
		$this->load->model('mubigeo');
		$ubigeo['departamentos'] =$this->mubigeo->m_departamentos();
		$ubigeo['paises'] = $this->mubigeo->m_paises();
		$ubigeo['dlenguas']=$this->mlenguas->m_get_lenguas();
		$this->load->view('admision/ficha-personal',$ubigeo);
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
				
				$cuentas=$this->madmision->m_filtrar_historial(array('%'.$busqueda.'%'));
				$conteo=count($cuentas['historial']);
				if ($conteo>0)
				{
					$dataex['conteo'] =$conteo;
					$rscuentas=$this->load->view('admision/historial-filtro',$cuentas,TRUE);
				}
				else
				{
					$rscuentas=$this->load->view('errors/sin-resultados',array(),TRUE);
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function get_matriculasxpersona()
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
			$this->form_validation->set_rules('txtcodigo','Codigo','trim|required|min_length[4]');
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
				$busqueda = base64url_decode($this->input->post('txtcodigo'));
				
				$matriculas=$this->madmision->m_get_matriculas_x_persona(array($busqueda));
				$conteo=count($matriculas);
				if ($conteo>0)
				{
					$dataex['conteo'] =$conteo;
					foreach ($matriculas as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->codigo);
						$fila->idper64 = base64url_encode($fila->idpersona);
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

	public function fn_update_datosper_matricula()
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
			// $this->form_validation->set_rules('fictxtsexo','sexo','trim|required');

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
				$nombre = mb_strtoupper($this->input->post('fictxtnombre'));
				
				$apepaterno = mb_strtoupper($this->input->post('fictxtapepaterno'));
				$apematerno = mb_strtoupper($this->input->post('fictxtapematerno'));
				// $sexo = $this->input->post('fictxtsexo');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "EDITAR";

				$rpta=$this->madmision->mUpdate_datosper_matricula(array($codigo, $apepaterno, $apematerno, $nombre));

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
	

	public function fn_update_datos_personales()
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
			
			$this->form_validation->set_rules('fidpidup','Código','trim|required');
			$this->form_validation->set_rules('fitxtnombresup','Nombre','trim|required');
			$this->form_validation->set_rules('fitxtapelpaternoup','Apellido paterno','trim|required');
			$this->form_validation->set_rules('fitxtapelmaternoup','Apellido materno','trim|required');

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
				
				$codigo = base64url_decode($this->input->post('fidpidup'));
				$nombre = mb_strtoupper($this->input->post('fitxtnombresup'));
				
				$apepaterno = mb_strtoupper($this->input->post('fitxtapelpaternoup'));
				$apematerno = mb_strtoupper($this->input->post('fitxtapelmaternoup'));

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "EDITAR";

				$rpta=$this->madmision->mUpdate_datos_personales(array($codigo, $apepaterno, $apematerno, $nombre));

				if ($rpta == 1){
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando datos personales en la tabla TB_PERSONA COD.".$codigo;
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
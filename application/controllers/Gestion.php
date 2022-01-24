<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->model('mgestion');

		$this->load->model('mauditoria');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Gestion | IESTWEB'  );
		$asidebar= array('menu_padre' =>'gestion','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_facturacion',$asidebar);
		$arraydts['tipoaf'] =$this->mgestion->m_get_tipo_afectacion();
		$arraydts['unidades'] =$this->mgestion->m_get_unidades();
		$arraydts['gestion'] =$this->mgestion->m_get_gestion();
		$arraydts['categorias'] = $this->mgestion->m_get_gestion_categorias();

		$this->load->view('facturacion/gestion/vw_gestion', $arraydts);
		$this->load->view('footer');
	}

	public function fn_update_estado()
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
			
			$this->form_validation->set_rules('txtcodigo','codigo gestion','trim|required');

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
				$txtcodigo=base64url_decode($this->input->post('txtcodigo'));
				
				$txtestado = $this->input->post('txtestado');

				$rpta=$this->mgestion->m_update_estado_gestion(array($txtestado, $txtcodigo));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Se modifico correctamente";
					
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_insert()
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
			// $this->form_validation->set_rules('fictxtcategoria','Categoria','trim|required');
			$this->form_validation->set_rules('fictxtimporte','Importe','trim|required');
			$this->form_validation->set_rules('fictxtfcomo','Facturar como','trim|required');
			$this->form_validation->set_rules('fictxtafectip','Tipo afectación','trim|required');
			$this->form_validation->set_rules('fictxtund','Tipo afectación','trim|required');
			

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
				
				$codigo = $this->input->post('fictxtcodigo');
				$nombre = $this->input->post('fictxtnombre');
				
				$importe = $this->input->post('fictxtimporte');
				$fcomo = $this->input->post('fictxtfcomo');
				$tipoafect = $this->input->post('fictxtafectip');
				$ficunidad = $this->input->post('fictxtund');
				$afectacion = $this->input->post('fictxtafectacion');

				if ($this->input->post('fictxtcategoria')!=='0'){
                    $categoria = $this->input->post('fictxtcategoria');
                }

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "INSERTAR";

				$rpta=$this->mgestion->m_get_gestion_codigo(array($codigo));
				
				if (!is_null($rpta)){
						
	                $dataex['msg']    = "Ya existe un registro con el código: {$rpta->codigo}, RECOMENDACIÓN: Deberás realizar cambios en los campos";
				}
				else{

					$rpta2=$this->mgestion->mInsert_gestion(array($codigo, $nombre, $categoria, $importe, $fcomo, $tipoafect, $ficunidad, $afectacion));

					if ($rpta2 == 1){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está insertando una gestion en la tabla TB_GESTION COD.".$codigo;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos guardados correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update()
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
			
			$this->form_validation->set_rules('fictxtcodigoup','Código','trim|required');
			$this->form_validation->set_rules('fictxtnombreup','Nombre','trim|required');
			// $this->form_validation->set_rules('fictxtcategoriaup','Categoria','trim|required');
			$this->form_validation->set_rules('fictxtimporteup','Importe','trim|required');
			$this->form_validation->set_rules('fictxtfcomoup','Facturar como','trim|required');
			$this->form_validation->set_rules('fictxtafectipup','Tipo afectación','trim|required');
			$this->form_validation->set_rules('fictxtundup','Unidad','trim|required');
			$this->form_validation->set_rules('fictxtafectacionup','Afectación','trim|required');

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
				
				$codigo = $this->input->post('fictxtcodigoup');
				$nombre = $this->input->post('fictxtnombreup');
				
				$importe = $this->input->post('fictxtimporteup');
				$fcomo = $this->input->post('fictxtfcomoup');
				$tipoafect = $this->input->post('fictxtafectipup');
				$ficunidad = $this->input->post('fictxtundup');
				$afectacion = $this->input->post('fictxtafectacionup');

				if ($this->input->post('fictxtcategoriaup')!=='0'){
                    $categoria = $this->input->post('fictxtcategoriaup');
                }

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "EDITAR";

				$rpta=$this->mgestion->mUpdate_gestion(array($codigo, $nombre, $categoria, $importe, $fcomo, $tipoafect, $ficunidad, $afectacion));

				if ($rpta == 1){
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una gestion en la tabla TB_GESTION COD.".$codigo;
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					$filas=$this->mgestion->m_get_gestionxcodigo(array($codigo));
					$dataex['status'] =TRUE;
					$dataex['codigo64'] = base64url_encode($codigo);
					$dataex['vdata'] = $filas;
					$dataex['msg'] ="Datos actualizados correctamente";
					
				}
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_get_gestion_xcodigo()
	{
		$this->form_validation->set_message('required', '%s Requerido');

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_codigogestion','Código','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
		        $dataex['msg']=validation_errors();
			}
			else
			{
				$fila = "";
				$vw_codigogestion = base64url_decode($this->input->post('vw_codigogestion'));
				$filas=$this->mgestion->m_get_gestionxcodigo(array($vw_codigogestion));
				
				$dataex['vdata']=$filas;
				$dataex['status'] =TRUE;
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_get_gestion_xcategoria()
	{
		$this->form_validation->set_message('required', '%s Requerido');

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_gt_cbcategoria','Categoria','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
		        $dataex['msg']=validation_errors();
			}
			else
			{
				$vw_gt_cbcategoria=$this->input->post('vw_gt_cbcategoria');
				$filas=$this->mgestion->m_get_gestion_xcategorias(array($vw_gt_cbcategoria));
				foreach ($filas as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->codigo);
				}
				$dataex['vtipoaf'] =$this->mgestion->m_get_tipo_afectacion();
				$dataex['vunidades'] =$this->mgestion->m_get_unidades();
				$dataex['vdata']=$filas;
				$dataex['status'] =TRUE;
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}


}
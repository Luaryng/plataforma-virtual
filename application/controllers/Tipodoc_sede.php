<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipodoc_sede extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->model('mtipodoc_sede');
		$this->load->model('msede');
		$this->load->model('mauditoria');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Documento - Sede | IESTWEB'  );
		$asidebar= array('menu_padre' =>'docsede','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_facturacion',$asidebar);
		$arraydts['tipos'] =$this->mtipodoc_sede->m_get_tiposdoc_xsede(array($_SESSION['userActivo']->idsede));
		$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
		$arraydts['tipdocm'] =$this->mtipodoc_sede->m_get_documentos_activas();
		$this->load->view('facturacion/tipodocumento/vw_docum_sede', $arraydts);
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
			
			$this->form_validation->set_rules('txtsede','codigo sede','trim|required');
			$this->form_validation->set_rules('txttipo','codigo tipo','trim|required');

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
				$txtsede=base64url_decode($this->input->post('txtsede'));
				$txttipo=base64url_decode($this->input->post('txttipo'));
				$txtestado = $this->input->post('txtestado');;

				$rpta=$this->mtipodoc_sede->m_update_estado(array($txtestado, $txtsede, $txttipo));
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
			
			$this->form_validation->set_rules('fictxtsede','Sede','trim|required');
			$this->form_validation->set_rules('fictxtdoctip','Tipo documento','trim|required');
			$this->form_validation->set_rules('fictxtruc','Ruc','trim|required');
			$this->form_validation->set_rules('fictxtserie','Serie','trim|required');
			$this->form_validation->set_rules('fictxtcontador','Contador','trim|required');
			// $this->form_validation->set_rules('fictxtcodsunat','Código sunat','trim|required');
			$this->form_validation->set_rules('fictxtoperatip','Tipo operación','trim|required');
			$this->form_validation->set_rules('fictxtigv','Igv','trim|required');

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
				
				$fictxtsede = $this->input->post('fictxtsede');
				$tipodoc = $this->input->post('fictxtdoctip');
				$ruc = $this->input->post('fictxtruc');
				$serie = $this->input->post('fictxtserie');
				$contador = $this->input->post('fictxtcontador');
				$codsunat=($this->input->post('fictxtcodsunat')!="")? $this->input->post('fictxtcodsunat') : "0000";
				// $codsunat = $this->input->post('fictxtcodsunat');
				$tipoperac = $this->input->post('fictxtoperatip');
				$igv = $this->input->post('fictxtigv');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "INSERTAR";

				$rpta=$this->mtipodoc_sede->m_get_tiposdoc_sede_tipo(array($fictxtsede, $tipodoc));
				
				if (!is_null($rpta)){
						
	                $dataex['msg']    = "Ya existe un registro con la sede: {$rpta->sede} , Tipo Doc: {$rpta->tipo}, RECOMENDACIÓN: Deberás realizar cambios en los campos";
				}
				else{

					$rpta2=$this->mtipodoc_sede->mInsert_doctipo_sede(array($fictxtsede, $tipodoc, $ruc, $serie, $contador, $codsunat, $tipoperac, $igv));

					if ($rpta2 == 1){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está insertando un registro en la tabla TB_DOCTIPO_SEDE COD.";
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos actualizados correctamente";
						
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
			
			$this->form_validation->set_rules('txtsede','id sede','trim|required');
			$this->form_validation->set_rules('txttipo','tipo','trim|required');

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
				$txtsede = base64url_decode($this->input->post('txtsede'));
				$tipodoc = base64url_decode($this->input->post('txttipo'));
				$ruc = $this->input->post('txtruc');
				$serie = $this->input->post('txtserie');
				$contador = $this->input->post('txtcontador');
				$codsunat = $this->input->post('txtidsunat');
				$tipoperac = $this->input->post('txttipoop');
				$igv = $this->input->post('txtigv');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "EDITAR";

				$rpta=$this->mtipodoc_sede->mUpdate_doctipo_sede(array($txtsede, $tipodoc, $ruc, $serie, $contador, $codsunat, $tipoperac, $igv));

				if ($rpta == 1){
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un registro en la tabla TB_DOCTIPO_SEDE COD.";
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Persona.php';
class Pagante extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('mauditoria');
		$this->load->model('mpagante');
		$this->load->model('mubigeo');
		$this->load->model('mtramites_tipo');
	}

	public function index(){
		$ahead= array('page_title' =>'PAGANTES | IESTWEB'  );
		$asidebar= array('menu_padre' =>'mn_pagante');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_facturacion',$asidebar);
		$arraydts['departamentos'] =$this->mubigeo->m_departamentos();
		$this->load->view('pagante/vw_genera_pagante', $arraydts);
		$this->load->view('footer');
	}

	public function fn_get_pagantes_deuda()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_fcb_cbtipodoc','Tipo ','trim|required');
			$this->form_validation->set_rules('vw_fcb_txtnrodoc','N° Documento','trim|required');
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
				$nrodoc=$this->input->post('vw_fcb_txtnrodoc');
				
				$tipodoc=$this->input->post('vw_fcb_cbtipodoc');

				$pagantes=$this->mpagante->m_get_pagantes(array($tipodoc,$nrodoc));
				$nrs=count($pagantes);
				if ($nrs==1){
					$dataex['vdata']=$pagantes[0];
					$this->load->model('mdeudas_individual');
					$deudas=$this->mdeudas_individual->m_get_deuda_activa_xpagante(array($pagantes[0]->codpagante));
					$dataex['rscountdeuda']=count($deudas);
					foreach ($deudas as $key => $dd) {
						$dd->monto=$dd->monto;
						$dd->mora=$dd->mora;
						$dd->saldo=$dd->saldo;
						$dd->saldo=$dd->saldo;
					}
					$dataex['vdeudas']=$deudas;
				}
				else{
					//$dataex['vdata']=$pagantes;
					//$nds=0;
				}
				$dataex['rscount']=$nrs;
				

				$dataex['status'] =TRUE;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function get_pagantes()
	{
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rspagant = "";

		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			//$tipodoc = $this->input->post('vw_fcb_cbtipodocs');
			//$nrodoc = $this->input->post('fictxtnrodoc');
			$razon = trim($this->input->post('fictxtnompagante'));
				
			
			$dtpag['historial'] = $this->mpagante->m_filtrar_pagante(array("%".$razon."%"));
			
			$rspagant = $this->load->view('facturacion/dts_pagante',$dtpag,TRUE);
			$dataex['status'] = TRUE;
			
		}
		$dataex['vdata'] = $rspagant;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}
	
	public function fn_get_pagantes()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_fcb_cbtipodoc','Tipo ','trim|required');
			$this->form_validation->set_rules('vw_fcb_txtnrodoc','N° Documento','trim|required');
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
				$nrodoc=$this->input->post('vw_fcb_txtnrodoc');
				
				$tipodoc=$this->input->post('vw_fcb_cbtipodoc');

				$pagantes=$this->mpagante->m_get_pagantes(array($tipodoc,$nrodoc));
				$nrs=count($pagantes);
				if ($nrs==1){
					$dataex['vdata']=$pagantes[0];
					$this->load->model('mdeudas_individual');
					$deudas=$this->mdeudas_individual->m_get_deuda_activa_xpagante(array($pagantes[0]->codpagante));
					$dataex['rscountdeuda']=count($deudas);
					foreach ($deudas as $key => $dd) {
						$dd->monto=$dd->monto;
						$dd->mora=$dd->mora;
						$dd->saldo=$dd->saldo;
						$dd->saldo=$dd->saldo;
					}
					$dataex['vdeudas']=$deudas;
				}
				else{
					//$dataex['vdata']=$pagantes;
					//$nds=0;
				}
				$dataex['rscount']=$nrs;
				

				$dataex['status'] =TRUE;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

   

	public function fn_get_datos_pagante_por_dni()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fitxtdni','DNI','trim|required');

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
				$rsprov=array();
				$rsdistri=array();
				$fidpid=$this->input->post('fitxtdni');
				$fila=$this->mpagante->get_datos_pagante_xdni(array($fidpid));
				if ($fila) {
					$dataex['status'] =TRUE;
				
					//BUSCAR UBIGEO
					$rsprov="<option value='0'>Sin opciones</option>";
					$provincias=$this->mubigeo->m_provincias(array($fila->coddepartamento));
					if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
					foreach ($provincias as $provincia) {
						$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
					}

					$rsdistri="<option value='0'>Sin opciones</option>";
					$distritos=$this->mubigeo->m_distritos(array($fila->codprovincia));
					if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
					foreach ($distritos as $distrito) {
						$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
					}

				}

				$dataex['vdata']=$fila;
				$dataex['provincias']=$rsprov;
				$dataex['distritos']=$rsdistri;
				
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_insert_update()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('valid_email','El campo %s debe ser un email correcto');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			// $this->form_validation->set_rules('fictxtcodpagante','codigo pagante','trim|required');
			$this->form_validation->set_rules('fictipopers','tipo persona','trim|required');
			$this->form_validation->set_rules('fictipopag','tipo pagante','trim|required');
			$this->form_validation->set_rules('ficbtipodoc','tipo doc.','trim|required');
			$this->form_validation->set_rules('fitxtdni','documento','trim|required');
			$this->form_validation->set_rules('fictxtnomrazon','razon social','trim|required');
			$this->form_validation->set_rules('fictxtemailper','email','valid_email|trim');
			

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
				$codpagante = $this->input->post('fictxtcodpagante');
				$tippagante = $this->input->post('fictipopag');
				$tipersona = $this->input->post('fictipopers');
				$tipdoc = $this->input->post('ficbtipodoc');
				$nrodoc = $this->input->post('fitxtdni');
				$rsocial = $this->input->post('fictxtnomrazon');
				$email = $this->input->post('fictxtemailper');
				$email2 = $this->input->post('fictxtemailper2');
				$ecorporat = $this->input->post('fictxtemailcorporat');
				$direccion = $this->input->post('fictxtdireccion');
				$distrito = $this->input->post('ficbdistrito');
				$telefono = $this->input->post('fictxtelefono');
				$celular = $this->input->post('fictxtcelular');
				
				
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;


				if ($codigo == "0") {
					if (trim($codpagante)=="") $codpagante=$nrodoc ;
					$rpta=$this->mpagante->mInsert_pagante(array($codpagante, $tippagante, $tipersona, $tipdoc, $nrodoc, $rsocial, NULL, NULL, $email, $email2, $ecorporat, $direccion, $distrito, $telefono, $celular));
					if ($rpta->salida=='1'){
						$fictxtaccion = "INSERTAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando un pagante en la tabla TB_PAGANTE COD.".$rpta->nid;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Registro ingresado correctamente";
						$dataex['ficaccion'] = $fictxtaccion;
						
					}
				} else {
					$rpta=$this->mpagante->mUpdate_pagante(array(base64url_decode($codigo), $codpagante, $tippagante, $tipersona, $tipdoc, $nrodoc, $rsocial, NULL, NULL, $email, $email2, $ecorporat, $direccion, $distrito, $telefono, $celular));
					if ($rpta->salida == '1'){
						$fictxtaccion = "EDITAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un pagante en la tabla TB_PAGANTE_TIPOS COD.".$rpta->nid;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Registro actualizado correctamente";
						$dataex['ficaccion'] = $fictxtaccion;
						$dataex['idtipo'] = $codigo;
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function get_filtrar_lista()
	{
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rspagant = "";

		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$busqueda = $this->input->post('fictxtdocumento');
			$razon = $this->input->post('fictxtapenom');
				
			
			$dtpag['historial'] = $this->mpagante->m_get_pagante_search(array($busqueda, $razon) );
			
			$rspagant = $this->load->view('pagante/vw_data_pagante',$dtpag,TRUE);
			$dataex['status'] = TRUE;
			
		}
		$dataex['vdata'] = $rspagant;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_registroxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo area', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$msgrpta = $this->mpagante->m_get_pagante_xcodigo(array($codigo));

			if ($msgrpta) {
				$dataex['status'] =TRUE;
				$msgrpta->id = base64url_encode($msgrpta->id);
				//BUSCAR UBIGEO
				$rsprov="<option value='0'>Sin opciones</option>";
				$provincias=$this->mubigeo->m_provincias(array($msgrpta->coddepartamento));
				if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
				foreach ($provincias as $provincia) {
					$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
				}

				$rsdistri="<option value='0'>Sin opciones</option>";
				$distritos=$this->mubigeo->m_distritos(array($msgrpta->codprovincia));
				if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
				foreach ($distritos as $distrito) {
					$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
				}

			}


			$dataex['vdata'] = $msgrpta;
			$dataex['provincias']=$rsprov;
			$dataex['distritos']=$rsdistri;
			
		}
		

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_item()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idtipo', 'codigo tipo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este item";
                $idtipo    = base64url_decode($this->input->post('idtipo'));
                $accion    = $this->input->post('accion');

                $estado = "";

                if ($accion == "Deshabilitar") {
                	$estado ="SI";
                } else {
                	$estado ="NO";
                }
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un tipo trámite en la tabla TB_TRAMITES_TIPOS COD.".$idtipo;
				
                $rpta = $this->mtramites_tipo->m_eliminaitem(array($estado, $idtipo));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Registro actualizado correctamente';
                    $dataex['estado'] = $estado;

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }


}

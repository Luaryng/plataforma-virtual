<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Facturacion_cobros extends Error_views{
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->helper("url"); 
		// $this->load->model("mfacturacion");
		$this->load->model('mauditoria');
		$this->load->model('mfacturacion_cobros');
	}


    /* COBROS MOVER A OTRO CONTROLLER*/
	public function fn_insert_cobros()
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
			
			$this->form_validation->set_rules('vw_fcb_codigopago','Código','trim|required');
			$this->form_validation->set_rules('vw_fcb_cbmedio','Medio pago','trim|required');
			$this->form_validation->set_rules('vw_fcb_monto_cobro','Monto','trim|required');
			

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
				$fechaoper = null;
				$banco = 0;
				$coddocpago = base64url_decode($this->input->post('vw_fcb_codigopago'));

				$medio = $this->input->post('vw_fcb_cbmedio');
				if ($this->input->post('vw_fcb_cbbanco')!=null){
                    $banco = $this->input->post('vw_fcb_cbbanco');
                }
				
				$monto = $this->input->post('vw_fcb_monto_cobro');

				$voucher = $this->input->post('vw_fcb_voucher_cobro');

				if (($this->input->post('vw_fcb_fechav_cobro')!=null) && ($this->input->post('vw_fcb_horav_cobro')!=null)){
                    $fechaoper = $this->input->post('vw_fcb_fechav_cobro')."  ".$this->input->post('vw_fcb_horav_cobro') ;
                }

				date_default_timezone_set ('America/Lima');
				$fcreacion = date('Y-m-d H:i:s');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "INSERTAR";

				$rpta2=$this->mfacturacion_cobros->m_guardar_cobro(array($fcreacion, $medio, $banco, $monto, $coddocpago, $voucher, $fechaoper));

				if ($rpta2 > 0){
					$dtscobros = $this->mfacturacion_cobros->m_get_cobros(array($coddocpago));
					foreach ($dtscobros as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->codigo);
						$fila->idocpg64=base64url_encode($fila->idocpag);

						$datereg =  new DateTime($fila->fecha);
						$fila->fecharegis = $datereg->format('d/m/Y h:i a');
						$fila->fechaoperac = null;
						if ($fila->fechaoper !== null) {
							$dateoper =  new DateTime($fila->fechaoper);
							$fila->fechaoperac = $dateoper->format('d/m/Y h:i a');
						}
					}
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está insertando un cobro en la tabla TB_DOCPAGO_COBROS COD.".$rpta2;
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					$dataex['status'] =TRUE;
					$dataex['vdata'] = $dtscobros;
					$dataex['msg'] ="Datos guardados correctamente";
					
				}
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_insert_cobros_boton()
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
			
			$this->form_validation->set_rules('vw_fcb_codigopago','Código','trim|required');
			$this->form_validation->set_rules('vw_fcb_cbmedio','Medio pago','trim|required');
			$this->form_validation->set_rules('vw_fcb_monto_cobro','Monto','trim|required');
			

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
				$fechaoper = null;
				$banco = $this->input->post('vw_fcb_cbbanco');
				$coddocpago = base64url_decode($this->input->post('vw_fcb_codigopago'));

				$mediop = $this->input->post('vw_fcb_cbmedio');
				$monto = $this->input->post('vw_fcb_monto_cobro');

				$voucher = $this->input->post('vw_fcb_voucher');

				if (($this->input->post('vw_fcb_fecha')!=="") && ($this->input->post('vw_fcb_hora')!=="")){
                    $fechaoper = $this->input->post('vw_fcb_fecha')."  ".$this->input->post('vw_fcb_hora') ;
                }

				$rptamedpag=$this->mfacturacion_cobros->m_get_mediopago_xnombre(array($mediop));

				$medio = $rptamedpag->codigo;
				

				date_default_timezone_set ('America/Lima');
				$fcreacion = date('Y-m-d H:i:s');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "INSERTAR";

				$rpta2=$this->mfacturacion_cobros->m_guardar_cobro(array($fcreacion, $medio, $banco, floatval($monto), $coddocpago, $voucher, $fechaoper));

				if ($rpta2 > 0){
					$dtscobros = $this->mfacturacion_cobros->m_get_cobros(array($coddocpago));
					foreach ($dtscobros as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->codigo);
						$fila->idocpg64=base64url_encode($fila->idocpag);
						$datereg =  new DateTime($fila->fecha);
						$fila->fecharegis = $datereg->format('d/m/Y h:i a');
						$fila->fechaoperac = null;
						if ($fila->fechaoper !== null) {
							$dateoper =  new DateTime($fila->fechaoper);
							$fila->fechaoperac = $dateoper->format('d/m/Y h:i a');
						}
					}
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está insertando un cobro en la tabla TB_DOCPAGO_COBROS COD.".$rpta2;
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					$dataex['status'] =TRUE;
					$dataex['vdata'] = $dtscobros;
					$dataex['msg'] ="Datos guardados correctamente";
					
				}
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_delete_cobros()
	{
		$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('vw_fcb_codigocobro','Id Cobro','trim|required');

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
                $dataex['msg'] ="No se eliminó la Cobro, consulte con Soporte err0 err-1";
                $dataex['status'] =FALSE;
                $codigo = base64url_decode($this->input->post('vw_fcb_codigocobro'));
                $idpago = base64url_decode($this->input->post('vw_fcb_idocpago'));
                                
                $newcod=$this->mfacturacion_cobros->m_eliminar_cobro(array($codigo));
                $dataex['newcod'] =$newcod;
                if ($newcod=='1'){
                	$dtscobros = $this->mfacturacion_cobros->m_get_cobros(array($idpago));
                	if (count($dtscobros) > 0) {
                		foreach ($dtscobros as $key => $fila) {
							$fila->codigo64=base64url_encode($fila->codigo);
							$fila->idocpg64=base64url_encode($fila->idocpag);

							$datereg =  new DateTime($fila->fecha);
							$fila->fecharegis = $datereg->format('d/m/Y h:i a');
							$fila->fechaoperac = null;
							if ($fila->fechaoper !== null) {
								$dateoper =  new DateTime($fila->fechaoper);
								$fila->fechaoperac = $dateoper->format('d/m/Y h:i a');
							}
						}
						$dataex['vdata'] = $dtscobros;
                	} else {
                		$dataex['vdata'] = 0;
                	}
					

                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="Cobro, eliminada";
                }
                

            }

        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
	}

	public function fn_filtrar_cobros()
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
			
			$this->form_validation->set_rules('vw_fcb_codigopago','Código','trim|required');
			

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
				$banco = $this->input->post('vw_fcb_cbbanco');
				$coddocpago = base64url_decode($this->input->post('vw_fcb_codigopago'));

				$dtscobros = $this->mfacturacion_cobros->m_get_cobros(array($coddocpago));
				if (count($dtscobros) > 0) {
					foreach ($dtscobros as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->codigo);
						$fila->idocpg64=base64url_encode($fila->idocpag);
						$datereg =  new DateTime($fila->fecha);
						$fila->fecharegis = $datereg->format('d/m/Y h:i a');
						$fila->fechaoperac = null;
						if ($fila->fechaoper !== null) {
							$dateoper =  new DateTime($fila->fechaoper);
							$fila->fechaoperac = $dateoper->format('d/m/Y h:i a');
						}
						
					}

					$dataex['status'] =TRUE;
					$dataex['vdata'] = $dtscobros;
				} else {
					$dataex['status'] =TRUE;
					$dataex['vdata'] = 0;
				}
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}


}
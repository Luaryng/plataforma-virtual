<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Facturacion_notas extends Error_views{
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->helper("url"); 
		$this->load->model("mfacturacion");

		$this->load->model('mauditoria');
		$this->load->model('mpagante');
		$this->load->model('mubigeo');
		//$this->load->library('pagination');
	}




	public function fn_guardar_nota()
	{
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{	
			$pbol=getPermitido("99");// boleta
			$pfac=getPermitido("100");// boleta
			$cpermitido=false;
			if (($pbol=="SI") || ($pfac=="SI")) $cpermitido=true;
			if ($cpermitido==true){

				$this->form_validation->set_message('required', '%s Requerido');
				
				$this->form_validation->set_rules('vw_fcb_serie','Serie','trim|required');
				$this->form_validation->set_rules('vw_fcb_sernumero','NÚmero','trim|required');
				$this->form_validation->set_rules('vw_fcb_emision','Fecha emision','trim|required');
				//$this->form_validation->set_rules('vw_fcb_vencimiento','Fecha vencimiento','trim|required');
				$this->form_validation->set_rules('vw_fcb_txtnrodoc','Nro documento','trim|required');

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
					$dataex['msg'] ='Ocurrio un error, intente nuevamente o comuniquese con un administrador.';
					$items          = json_decode($_POST['vw_fcb_items'],true);
					$n_items_recibidos=count($items);
					if ($n_items_recibidos>0){
						$tipodoc_cod=$this->input->post('vw_fcb_tipo');
						$pagante_tipodoc=$this->input->post('vw_fcb_cbtipodoc');
						$pagante_nrodoc=$this->input->post('vw_fcb_txtnrodoc');
						$dcp_pagante=$this->input->post('vw_fcb_txtpagante');
						$pagante_cod=$this->input->post('vw_fcb_codpagante');
						$codtipoo_peracion_51=$this->input->post('vw_fcb_cbtipo_operacion51');
						$dcp_serie=$this->input->post('vw_fcb_serie');
						$dcp_total=$this->input->post('vw_fcb_txttotal');

						$tipodoc_cod_afectado=$this->input->post('vw_fcn_tipo');
						$tiponota=$this->input->post('vw_fcb_cbtiponota');
						$dcp_serie_afectado=$this->input->post('vw_fcn_serie');
						$dcp_numero_afectado=$this->input->post('vw_fcn_sernumero');
						$dcp_motivo_afectado=$this->input->post('vw_fcb_motivonota');
						

						$validacion=true;
						if (($codtipoo_peracion_51=="0200") && ($pagante_tipodoc!="SDI")){
							$validacion=false;
								$dataex['msg']="Si es una operación de EXPORTACIÓN, el cliente debe tener como tipo de documento DOC.TRIB.NO.DOM.SIN.RUC (EXPORTACIÓN)";
						}
						
						if (trim($pagante_cod)=="") {
							
								$validacion=false;
								$dataex['msg']="Debes escoger a un Cliente";
							
							
						}
						if (trim($dcp_motivo_afectado)=="") {
							
								$validacion=false;
								$dataex['msg']="Debes ingresar el motivo";
							
							
						}
						
						if ($tipodoc_cod_afectado=="FC") {
							if (substr($dcp_serie, 0, 1)!="F" ){
								$validacion=false;
								$dataex['msg']="Serie debe empezar con F";
							}
							if ($tipodoc_cod!="NF") {
								$validacion=false;
								$dataex['msg']="El Doc. Afectado debe ser una FACTURA";
							}
							
						}
						if ($tipodoc_cod_afectado=="BL") {
							if (substr($dcp_serie, 0, 1)!="B" ){
								$validacion=false;
								$dataex['msg']="Serie debe empezar con B";
							}
							if ($tipodoc_cod!="NB") {
								$validacion=false;
								$dataex['msg']="El Doc. Afectado debe ser una BOLETA";
							}
							
						}
						if (($tipodoc_cod=="NF") && ($pagante_tipodoc!="RUC")){
							$validacion=false;
								$dataex['msg']="DocumeNto de Identidad incorrecto para una Factura";
						}
						if ($pagante_tipodoc=="DNI"){
							if (strlen($pagante_nrodoc)!=8){
								$validacion=false;
								$dataex['msg']="DNI requiere de 8 carácteres";
							}
						}
						else if ($pagante_tipodoc=="RUC"){
							if (strlen($pagante_nrodoc)!=11){
								$validacion=false;
								$dataex['msg']="RUC requiere de 11 carácteres";
							}
						}
						else if ($pagante_tipodoc=="VAR"){
								
								$dcp_pagante="VARIOS";
								$pagante_cod="-";
								$pagante_nrodoc="-";
								if ($dcp_total>=700){
									$validacion=false;
									$dataex['msg']="Para ventas mayores o iguales a 700 debe Indicar un Cliente";
								}

						}
						foreach ($items as $key => $it) {
							if (trim($it['vw_fcb_ai_cbunidad'])==""){
								$validacion=false;
								$dataex['msg']="RUC requiere de 11 carácteres";
								break;
							}
							if ($codtipoo_peracion_51=="0200"){
								if  ($it['vw_fcb_ai_cbafectacion']!="40"){
									$validacion=false;
									$dataex['msg']="Si es una operación de EXPORTACIÓN, el tipo de IGV debe ser:  40  Exportación de Bienes o Servicios";
								}
								
							}
							if ($codtipoo_peracion_51=="0101"){
								if  ($it['vw_fcb_ai_cbafectacion']=="40"){
									$validacion=false;
									$dataex['msg']="Para una Operación de VENTA, el tipo de IGV NO debe ser Exportación";
								}
								
							}
						}

						if ($validacion==true){
							$dcp_numero=$this->input->post('vw_fcb_sernumero_real');
							$femision=$this->input->post('vw_fcb_emision');
							$emishora=$this->input->post('vw_fcb_emishora');
							$dcp_fecha_hora = $femision.' '.$emishora;;
							
							$dcp_direccion=$this->input->post('vw_fcb_txtdireccion');

							//Email
							$email=$this->input->post('vw_fcb_txtemail1');
							$email2=$this->input->post('vw_fcb_txtemail2');
							$email3=$this->input->post('vw_fcb_txtemail3');


							$matricula_cod="";//$this->input->post('vw_fcb_serie');
							$dcp_observacion=$this->input->post('vw_fcb_txtobservaciones');
							$sede_id=$_SESSION['userActivo']->idsede;
							
							$dcp_descuento_general=$this->input->post('vw_fcb_txt_dsct_general');
							$dcp_igv=$this->input->post('vw_fcb_txtigvp');
							
							
							$dcp_mnto_oper_gravadas=$this->input->post('vw_fcb_txtoper_gravada');
							$dcp_mnto_oper_inafecta=$this->input->post('vw_fcb_txtoper_inafecta');
							$dcp_mnto_oper_exonerada=$this->input->post('vw_fcb_txtoper_exonerada');
							$dcp_mnto_oper_exportacion=$this->input->post('vw_fcb_txtoper_exportacion');

							$dcp_descuento_factor=$this->input->post('vw_fcb_txtoper_descfactor');
							$dcp_mnto_dsctos_totales=$this->input->post('vw_fcb_txtoper_desctotal');
							
							$dcp_mnto_oper_gratis=$this->input->post('vw_fcb_txtoper_gratuitas');
							
							
							$dcp_valor_venta=$this->input->post('vw_fcb_txtsubtotal');
							$dcp_subtotal=$this->input->post('vw_fcb_txtsubtotal');

							$dcp_monto_icbper=$this->input->post('vw_fcb_txticbpertotal');

							$dcp_mnto_isc_base= 0;// Sumatoria MtoBaseISC detalles
							$dcp_mnto_isc=$this->input->post('vw_fcb_txtisctotal');

							$dcp_mnto_igv=$this->input->post('vw_fcb_txtigvtotal');
							$dcp_total_impuestos= floatval($dcp_mnto_igv) + floatval($dcp_mnto_isc) + floatval($dcp_monto_icbper);

							//$serie= $this->input->post('vw_fcb_serie');
							
							$dcp_fecha_vence=$this->input->post('vw_fcb_vencimiento');
							if ($dcp_fecha_vence=="") $dcp_fecha_vence=null;
							
				            $usuario = $_SESSION['userActivo'];
							$sede = $_SESSION['userActivo']->idsede;
		                    
							date_default_timezone_set ('America/Lima');
							$rpta=0;
							$rptad=0;
							if (trim($dcp_numero)=="") $dcp_numero="0";
								//INSERTA DOCUMENTO NUEVO E INCREMENTA EL CONTROLADOR
							$datosDocumento=array($codtipoo_peracion_51, $tipodoc_cod, $dcp_serie, $dcp_fecha_hora, $dcp_fecha_vence, $pagante_cod, $dcp_pagante, $pagante_tipodoc, $pagante_nrodoc, $dcp_direccion, $matricula_cod, $dcp_observacion, $sede_id, $dcp_descuento_general, $dcp_igv, $dcp_total, $dcp_mnto_oper_gravadas, $dcp_mnto_oper_inafecta, $dcp_mnto_oper_exonerada, $dcp_mnto_oper_exportacion, $dcp_mnto_dsctos_totales, $dcp_mnto_oper_gratis, $dcp_mnto_igv, $dcp_mnto_isc, $dcp_monto_icbper, $dcp_total_impuestos, $dcp_valor_venta, $dcp_subtotal, $dcp_descuento_factor,$tiponota,$dcp_serie_afectado,$dcp_numero_afectado,$dcp_motivo_afectado,$tipodoc_cod_afectado);
							$this->load->model("mfacturacion_notas");
							$rpta = $this->mfacturacion_notas->m_insert_nota($datosDocumento);	
							
							
							$dataex['error_especial']='DP';
							$dataex['msg'] ='No se pudo guardar el Documento de Pago - Error: DD';
							if ($rpta->salida == '1') {
								$cod_docpago=$rpta->nid;
								$n_items_guardados=0;
								foreach ($items as $key => $item) {
									//RECORRER LOS ITEM DE DOCUMENTO
									$cod_unidad=$item['vw_fcb_ai_cbunidad'];
									$gestion_cod=$item['vw_fcb_ai_cbgestion'];
									$dpd_gestion = $item['vw_fcb_ai_txtgestion'];
									$dpd_cantidad=$item['vw_fcb_ai_txtcantidad'];
									$dpd_mnto_valor_unitario=$item['vw_fcb_ai_txtvalorunitario'];//precio Unit. sin IGV
									$dpd_mnto_precio_unit=$item['vw_fcb_ai_txtpreciounitario']; //Precio Unit. con IGV.
									$dpd_mnto_descuento="";
									$cod_tipoafc_igv=$item['vw_fcb_ai_cbafectacion'];
									$dpd_mnto_igv= floatval($dpd_mnto_precio_unit) - floatval($dpd_mnto_valor_unitario);
									$dpd_mnto_valor_venta=$item['vw_fcb_ai_txtprecioventa'];
									$dpd_mnto_base_sinigv=$dpd_mnto_valor_venta - $dpd_mnto_igv;
									$dpd_porc_igv=$dcp_igv;
									// monto IGV
									$dpd_icbper_factor=0;//$item['vw_fcb_ai_txticbper_factor'];
									$dpd_icbper_mnto=floatval($dpd_cantidad) * floatval($dpd_icbper_factor);
									$dpd_facturar_como="";
									$dpd_facturar_como_cant="";
									$deuda_cod=$item['vw_fcb_ai_txtcoddeuda'];
									$cod_isc="";
									$dpd_isc_factor=$item['vw_fcb_ai_cbiscfactor'];
									$dpd_isc_valor=$item['vw_fcb_ai_txtiscvalor'];
									$dpd_isc_base_imponible=$item['vw_fcb_ai_txtiscbase'];
									$dpd_dscto_factor=$item['vw_fcb_ai_cbdsctfactor'];
									$dpd_dscto_valor=$item['vw_fcb_ai_txtdsctvalor'];
									$dpd_igv_afectado=$item['vw_fcb_ai_cbafectaigv'];//GRAVADO INAFECTO EXONERADO
		  							$dpd_tipoitem=$item['vw_fcb_ai_cbtipoitem']; // BIEN // SERVICIO
		  							$dpd_esgratis=$item['vw_fcb_ai_cbgratis'];
									$dpd_monto_total_impuesto=$dpd_mnto_igv;// IGV + ISC + OTH + ICBPER
									$itemDocumento=array($cod_docpago, $tipodoc_cod, $cod_unidad, $gestion_cod, $dpd_gestion, $dpd_cantidad, $dpd_mnto_valor_unitario, $dpd_mnto_valor_venta, $dpd_mnto_base_sinigv, $dpd_porc_igv, $dpd_mnto_igv, $cod_tipoafc_igv, $dpd_monto_total_impuesto, $dpd_mnto_precio_unit, $dpd_facturar_como, $dpd_facturar_como_cant, $deuda_cod, $cod_isc, $dpd_isc_factor, $dpd_isc_valor, $dpd_isc_base_imponible, $dpd_dscto_factor, $dpd_dscto_valor, $dpd_icbper_factor, $dpd_icbper_mnto, $dpd_igv_afectado, $dpd_tipoitem, $dpd_esgratis, $dpd_mnto_descuento);
									$rptadt = $this->mfacturacion->m_insert_facturacion_detalle($itemDocumento);
									$dataex['error_especial']='DD';
									if ($rptadt->salida=='1'){

										$n_items_guardados++;
									}
									
								}

								$nuevo_id=$rpta->nid;
								
									$dataex['error_especial']='DESIGUAL ENTRE ITEMS RECIBIDOS Y GUARDADOS';
									if ($n_items_guardados==$n_items_recibidos){
										$dataex['error_especial']='ERROR AL ENVIAR JSON';
										$leer_respuesta=$this->fn_enviar_json($nuevo_id);
										
										if (isset($leer_respuesta['errors'])) {
											//Mostramos los errores si los hay
									    	$dataex['error_sunat']=$leer_respuesta['errors'];
									    	//$dataex['respuesta']=$leer_respuesta;
									    	$dcps_error_cod=$leer_respuesta['codigo'];
											$dcps_error_desc=$leer_respuesta['errors'];
											$dataex['error_especial']=' JSON ENVIADO';
											$dataex['msg'] ='Docuemnto Guardado';
											
											$this->mfacturacion->m_insert_facturacion_rpsunat_error(array($nuevo_id, $dcps_error_cod,$dcps_error_desc));
										} 
										else {
											$dataex['respuesta2']=$leer_respuesta;
											$dcps_aceptado=($leer_respuesta['aceptada_por_sunat']==true)?"SI":"NO";
											$dcps_snt_cadenaqr=$leer_respuesta['cadena_para_codigo_qr'];
											
											$dcps_snt_hash=$leer_respuesta['codigo_hash'];
											$dcps_snt_enlace=$leer_respuesta['enlace'];
											$dcps_snt_enlace_cdr=$leer_respuesta['enlace_del_cdr'];
											$dcps_snt_enlace_pdf=$leer_respuesta['enlace_del_pdf'];
											$dcps_snt_enlace_xml=$leer_respuesta['enlace_del_xml'];
											$dcps_numero=$leer_respuesta['numero'];
											
											$dcps_serie=$leer_respuesta['serie'];
											$dcps_snt_descripcion=$leer_respuesta['sunat_description'];
											$dcps_snt_note=$leer_respuesta['sunat_note'];
											$dcps_snt_responsecode=$leer_respuesta['sunat_responsecode'];
											$dcps_snt_soap_error=$leer_respuesta['sunat_soap_error'];
											$dcps_tipodoc_nube=$leer_respuesta['tipo_de_comprobante'];
											$dcps_snt_codigobarras="";
											$dcps_error_cod="";
											$dcps_error_desc="";
											$dataex['error_especial']=' JSON ENVIADO';
											$dataex['msg'] ='Docuemnto Guardado';
											
											$this->mfacturacion->m_insert_facturacion_rpsunat(array($nuevo_id, $dcps_tipodoc_nube, $dcps_serie, $dcps_numero, $dcps_snt_enlace, $dcps_aceptado, $dcps_snt_descripcion, $dcps_snt_note, $dcps_snt_responsecode, $dcps_snt_soap_error, $dcps_snt_cadenaqr, $dcps_snt_hash, $dcps_snt_codigobarras, $dcps_snt_enlace_pdf, $dcps_snt_enlace_xml, $dcps_snt_enlace_cdr,$dcps_error_cod,$dcps_error_desc));
																			
									
										} 	
									}
								
								
								
								
								$accion = "INSERTAR";
			        			$contenido = $usuario->usuario." - ".$usuario->paterno." ".$usuario->materno." ".$usuario->nombres.", está ingresando un documento en la tabla TB_DOCPAGO COD.".$nuevo_id;
			        			$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario->idusuario, $accion, $contenido, $sede));
			        			//$correlativo = $this->mfacturacion->update_correlativo_sede(array($tipodocpago, $sede));
			        			$dataex['status'] =TRUE;
		                		$dataex['numero']=$dcp_serie."-".str_pad($rpta->nrodoc, 8, "0", STR_PAD_LEFT);
		                		$dataex['tickect']=base_url()."tesoreria/facturacion/generar/rpgrafica/".base64url_encode($nuevo_id);
		                		$dataex['pdf']=base_url()."tesoreria/facturacion/generar/pdf/".base64url_encode($nuevo_id);
		                		$dataex['coddocpago'] = base64url_encode($nuevo_id);
		                		$dataex['montodocpago'] = $dcp_total;
							}
							else{
								$dataex['status'] =FALSE;
	                			$dataex['error_especial']=$rpta;
							}
						}
					}
					else{
						$dataex['status'] =FALSE;
	                	$dataex['msg']="Debes registrar 1 item como mínimo";
					}
				}
			}
			else{
				$dataex['msg']    = 'No autorizado';
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_get_doc_afectado(){
		$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('vw_fcb_docafectado','Documento','trim|required');

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
                $codigo = strtoupper($this->input->post('vw_fcb_docafectado'));
                $this->load->model("mfacturacion_notas");
                $rs=$this->mfacturacion_notas->get_docpago_afectado(array($codigo));
                if (isset($rs['docpago']->coddoc)){
                	$dataex['status'] =TRUE;
                	$dataex['existe'] =TRUE;	
                	$dataex['docpago'] =$rs['docpago'];
                	$dataex['docitems'] =$rs['docitems'];
                }
                else{
                	$dataex['status'] =TRUE;	
                	$dataex['existe'] =FALSE;
                	$dataex['msg'] ="El documento $codigo NO existe o aun no ha sido aceptado en SUNAT";
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

				$dtscobros = $this->mfacturacion->m_get_cobros(array($coddocpago));
				if (count($dtscobros) > 0) {
					foreach ($dtscobros as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->codigo);
						$fila->idocpg64=base64url_encode($fila->idocpag);
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

	public function fn_reportar_doc_a_nube()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{

			if (getPermitido("110") == "SI") {
			
				$this->form_validation->set_rules('vw_fcb_codigo','Código','trim|required');
				if ($this->form_validation->run() == FALSE)
				{
					$dataex['msg']="Existen errores en los campos";
					$dataex['msg2'] = validation_errors();
					$errors = array();
			        foreach ($this->input->post() as $key => $value){
			            $errors[$key] = form_error($key);
			        }
			        $dataex['errors'] = array_filter($errors);
				}
				else
				{
					$dataex['status'] =FALSE;
					$nuevo_id = base64url_decode($this->input->post('vw_fcb_codigo'));

					$leer_respuesta=$this->fn_enviar_json($nuevo_id);
					if (isset($leer_respuesta['errors'])) {
						//Mostramos los errores si los hay
				    	$dataex['error_sunat']=$leer_respuesta['errors'];
				    	//$dataex['respuesta']=$leer_respuesta;
				    	$dcps_error_cod=$leer_respuesta['codigo'];
						$dcps_error_desc=$leer_respuesta['errors'];
						$dataex['error_especial']=' JSON ENVIADO';
						$dataex['msg'] ='Documento a Error';
						
						$this->mfacturacion->m_update_facturacion_rpsunat_error(array($nuevo_id, $dcps_error_cod,$dcps_error_desc));
					} 
					else {
						$dataex['respuesta2']=$leer_respuesta;
						$dcps_aceptado=($leer_respuesta['aceptada_por_sunat']==true)?"SI":"NO";
						$dcps_snt_cadenaqr=$leer_respuesta['cadena_para_codigo_qr'];
						
						$dcps_snt_hash=$leer_respuesta['codigo_hash'];
						$dcps_snt_enlace=$leer_respuesta['enlace'];
						$dcps_snt_enlace_cdr=$leer_respuesta['enlace_del_cdr'];
						$dcps_snt_enlace_pdf=$leer_respuesta['enlace_del_pdf'];
						$dcps_snt_enlace_xml=$leer_respuesta['enlace_del_xml'];
						$dcps_numero=$leer_respuesta['numero'];
						
						$dcps_serie=$leer_respuesta['serie'];
						$dcps_snt_descripcion=$leer_respuesta['sunat_description'];
						$dcps_snt_note=$leer_respuesta['sunat_note'];
						$dcps_snt_responsecode=$leer_respuesta['sunat_responsecode'];
						$dcps_snt_soap_error=$leer_respuesta['sunat_soap_error'];
						$dcps_tipodoc_nube=$leer_respuesta['tipo_de_comprobante'];
						$dcps_snt_codigobarras="";
						$dcps_error_cod="";
						$dcps_error_desc="";
						$dataex['error_especial']=' JSON ENVIADO';
						$dataex['msg'] ='Documento Enviado';
						
						$rsrp=$this->mfacturacion->m_update_facturacion_rpsunat(array($nuevo_id, $dcps_tipodoc_nube, $dcps_serie, $dcps_numero, $dcps_snt_enlace, $dcps_aceptado, $dcps_snt_descripcion, $dcps_snt_note, $dcps_snt_responsecode, $dcps_snt_soap_error, $dcps_snt_cadenaqr, $dcps_snt_hash, $dcps_snt_codigobarras, $dcps_snt_enlace_pdf, $dcps_snt_enlace_xml, $dcps_snt_enlace_cdr,$dcps_error_cod,$dcps_error_desc));
						if ($rsrp->salida=="1"){
							$this->mfacturacion->m_update_estado_docpago(array($nuevo_id,"ENVIADO"));
							$dataex['msg'] ='SUNAT actualizado';
							$dataex['status'] =TRUE;
						}
														
				
					} 	
				}
			}
			else{
				$dataex['msg'] ='No cuentas con permiso para esta acción';
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}


	function fn_enviar_json($dc){
		// RUTA para enviar documentos
		$leer_respuesta="";
		$dp= $this->mfacturacion_notas->get_docpago($dc);
		if (isset($dp->nro)){
		$nube= $this->mfacturacion->m_get_conexion_nubefact($_SESSION['userActivo']->idsede);
		$ruta = $nube->ruta;
		$token = $nube->token;


		/*
		#########################################################
		#### PASO 2: GENERAR EL ARCHIVO PARA ENVIAR A NUBEFACT ####
		+++++++++++++++++++++++++++++++++++++++++++++++++++++++
		# - MANUAL para archivo JSON en el link: https://goo.gl/WHMmSb
		# - MANUAL para archivo TXT en el link: https://goo.gl/Lz7hAq
		+++++++++++++++++++++++++++++++++++++++++++++++++++++++
		 */
		//

		
		$items= $this->mfacturacion->get_items_docpago($dc);

		$items_array=array();
		foreach ($items as $key => $it) {
			$item=array(
			    "unidad_de_medida"          => $it->unidad,
			    "codigo"                    => $it->codgestion,
			    "descripcion"               => $it->gestion,
			    "cantidad"                  => $it->cantidad,
			    "valor_unitario"            => $it->v_unitario,
			    "precio_unitario"           => $it->p_unitario,
			    "descuento"                 => $it->m_descuento,
			    "subtotal"                  => $it->subtotal,
			    "tipo_de_igv"               => $it->tipoigv,
			    "igv"                       => $it->igv,
			    "total"                     => $it->total,
			    "anticipo_regularizacion"   => "false",
			    "anticipo_documento_serie"  => "",
			    "anticipo_documento_numero" => ""
			);
			$items_array[]=$item;
		    
		}

		$vcodtiponota_credito="";
		$vcodtiponota_debito="";
		if ($dp->tipodoc_cod=="NB"){
			
			$vcodtiponota_credito=$dp->codtiponota;
		}
		else if ($dp->tipodoc_cod=="NF"){
			
			$vcodtiponota_credito=$dp->codtiponota;
		}
		else if ($dp->tipodoc_cod=="ND"){
			$vcodtiponota_debito=$dp->codtiponota;
		}
		
		$vtipo_afectado=$dp->tipodoc_afectado;
		$vserie_afectado=$dp->serie_afectado;
		$vnro_afectado=$dp->nro_afectado;
		$vmotivo_afectado=$dp->motivo_afectado;
		$data = array(
		    "operacion"							=> "generar_comprobante",
		    "tipo_de_comprobante"               => $dp->tipodoc,
		    "serie"                             => $dp->serie,
		    "numero"							=> $dp->nro,
		    "sunat_transaction"					=> "1",
		    "cliente_tipo_de_documento"			=> $dp->pagtipodoc,
		    "cliente_numero_de_documento"		=> $dp->pagnrodoc,
		    "cliente_denominacion"              => $dp->pagante,
		    "cliente_direccion"                 => $dp->pagdirecion,
		    "cliente_email"                     => "",
		    "cliente_email_1"                   => "",
		    "cliente_email_2"                   => "",
		    "fecha_de_emision"                  => date('d-m-Y', strtotime($dp->fecha)),
		    "fecha_de_vencimiento"              => $dp->vence,
		    "moneda"                            => "1",
		    "tipo_de_cambio"                    => "",
		    "porcentaje_de_igv"                 => $dp->igvporc,
		    "descuento_global"                  => $dp->dsctoglobal,
		    "total_descuento"                   => $dp->dsctototal,
		    "total_anticipo"                    => "",
		    "total_gravada"                     => $dp->opergrav,
		    "total_inafecta"                    => $dp->operinaf,
		    "total_exonerada"                   => $dp->operexon,
		    "total_igv"                         => $dp->igvtotal,
		    "total_gratuita"                    => $dp->opergrat,
		    "total_otros_cargos"                => "",
		    "total"                             => $dp->total,
		    "percepcion_tipo"                   => "",
		    "percepcion_base_imponible"         => "",
		    "total_percepcion"                  => "",
		    "total_incluido_percepcion"         => "",
		    "detraccion"                        => "false",
		    "observaciones"                     => $dp->obs,
		    "documento_que_se_modifica_tipo"    => $vtipo_afectado,
		    "documento_que_se_modifica_serie"   => $vserie_afectado,
		    "documento_que_se_modifica_numero"  => $vnro_afectado,
		    "tipo_de_nota_de_credito"           => $vcodtiponota_credito,
		    "tipo_de_nota_de_debito"            => $vcodtiponota_debito,
		    "enviar_automaticamente_a_la_sunat" => "true",
		    "enviar_automaticamente_al_cliente" => "false",
		    "codigo_unico"                      => "",
		    "condiciones_de_pago"               => "",
		    "medio_de_pago"                     => "",
		    "placa_vehiculo"                    => "",
		    "orden_compra_servicio"             => "",
		    "tabla_personalizada_codigo"        => "",
		    "formato_de_pdf"                    => "",
		    "items" => $items_array
		);
		
		$data_json = json_encode($data);

		//Invocamos el servicio de NUBEFACT
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $ruta);
		curl_setopt(
			$ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Token token="'.$token.'"',
			'Content-Type: application/json',
			)
		);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$respuesta  = curl_exec($ch);
		curl_close($ch);

		$leer_respuesta = json_decode($respuesta, true);
		}
		return  $leer_respuesta;

	}


	public function fn_consultar_doc_a_nube()
    {
    	$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
        	$dataex['msg'] ='No tienes autorización para esta acción';
        	if (getPermitido("111") == "SI") {
	            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

	            $this->form_validation->set_rules('vw_fcb_codigo','codigo','trim|required');
	            

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
	            	date_default_timezone_set ('America/Lima');
	                
	                $dataex['status'] =FALSE;
	                $coddocum64 = $this->input->post('vw_fcb_codigo');
	                $coddocum = base64url_decode($coddocum64);
	              
	                $leer_respuesta="";
	                $dataex['msg'] ="Documento encontrado";
					$dp= $this->mfacturacion->get_docpago($coddocum);
					if (isset($dp->nro)){
						$dataex['msg'] ="Documento NO ENVIADO en SUNAT aun";
						if ($dp->estado=="ENVIADO"){
							$nube= $this->mfacturacion->m_get_conexion_nubefact($_SESSION['userActivo']->idsede);
							$ruta = $nube->ruta;
							$token = $nube->token;
							$data = array(
							    "operacion"							=> "consultar_comprobante",
							    "tipo_de_comprobante"               => $dp->tipodoc,
							    "serie"                             => $dp->serie,
							    "numero"							=> $dp->nro
							);
							//var_dump($data);
							$leer_respuesta=$this->fn_enviar_json_independiente($ruta,$token,$data);
							if (isset($leer_respuesta['errors'])) {
							//Mostramos los errores si los hay
					    	$dataex['error_sunat']=$leer_respuesta['errors'];
					    	//$dataex['respuesta']=$leer_respuesta;
					    	$dcps_error_cod=$leer_respuesta['codigo'];
							$dcps_error_desc=$leer_respuesta['errors'];
							$dataex['error_especial']=' JSON ENVIADO';
							$dataex['msg'] ='Documento a Error';
							
							$this->mfacturacion->m_update_facturacion_rpsunat_error(array($coddocum, $dcps_error_cod,$dcps_error_desc));
							} 
							else {
								$dataex['respuesta2']=$leer_respuesta;
								$dcps_aceptado=($leer_respuesta['aceptada_por_sunat']==true)?"SI":"NO";
								$dcps_snt_cadenaqr=$leer_respuesta['cadena_para_codigo_qr'];
								
								$dcps_snt_hash=$leer_respuesta['codigo_hash'];
								$dcps_snt_enlace=$leer_respuesta['enlace'];
								$dcps_snt_enlace_cdr=$leer_respuesta['enlace_del_cdr'];
								$dcps_snt_enlace_pdf=$leer_respuesta['enlace_del_pdf'];
								$dcps_snt_enlace_xml=$leer_respuesta['enlace_del_xml'];
								$dcps_numero=$leer_respuesta['numero'];
								
								$dcps_serie=$leer_respuesta['serie'];
								$dcps_snt_descripcion=$leer_respuesta['sunat_description'];
								$dcps_snt_note=$leer_respuesta['sunat_note'];
								$dcps_snt_responsecode=$leer_respuesta['sunat_responsecode'];
								$dcps_snt_soap_error=$leer_respuesta['sunat_soap_error'];
								$dcps_tipodoc_nube=$leer_respuesta['tipo_de_comprobante'];
								$dcps_snt_codigobarras="";
								$dcps_error_cod="";
								$dcps_error_desc="";
								$dataex['error_especial']=' JSON ENVIADO';
								$dataex['msg'] ='Documento Enviado';
								
								$rsrp=$this->mfacturacion->m_update_facturacion_rpsunat(array($coddocum, $dcps_tipodoc_nube, $dcps_serie, $dcps_numero, $dcps_snt_enlace, $dcps_aceptado, $dcps_snt_descripcion, $dcps_snt_note, $dcps_snt_responsecode, $dcps_snt_soap_error, $dcps_snt_cadenaqr, $dcps_snt_hash, $dcps_snt_codigobarras, $dcps_snt_enlace_pdf, $dcps_snt_enlace_xml, $dcps_snt_enlace_cdr,$dcps_error_cod,$dcps_error_desc));
								if ($rsrp->salida=="1"){
									//$this->mfacturacion->m_update_estado_docpago(array($nuevo_id,"ENVIADO"));
									$dataex['msg'] ='SUNAT actualizado';
									$dataex['status'] =TRUE;
								}
								////////////////////////////	
							}	
						}
	            	}
	        	}

        	}
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_consultar_doc_enviados_a_nube()
    {
    	$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
        	$dataex['msg'] ='No tienes autorización para esta acción';
        	if (getPermitido("111") == "SI") {
	            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            	date_default_timezone_set ('America/Lima');
                $docs_enviados= $this->mfacturacion->get_simple_docpagos_enviados($_SESSION['userActivo']->idsede);
              	$nube= $this->mfacturacion->m_get_conexion_nubefact($_SESSION['userActivo']->idsede);
				$ruta = $nube->ruta;
				$token = $nube->token;
              	foreach ($docs_enviados as $key => $dp) {
              		# code...
              	
	                $leer_respuesta="";
	                $dataex['msg'] ="Documento encontrado";
					if (isset($dp->nro)){
						$dataex['msg'] ="Documento NO ENVIADO a SUNAT aun";
						if ($dp->estado=="ENVIADO"){
							
							$data = array(
							    "operacion"							=> "consultar_comprobante",
							    "tipo_de_comprobante"               => $dp->tipodoc,
							    "serie"                             => $dp->serie,
							    "numero"							=> $dp->nro
							);
							//var_dump($data);
							$leer_respuesta=$this->fn_enviar_json_independiente($ruta,$token,$data);
							if (isset($leer_respuesta['errors'])) {
								//Mostramos los errores si los hay
						    	$dataex['error_sunat']=$leer_respuesta['errors'];
						    	//$dataex['respuesta']=$leer_respuesta;
						    	$dcps_error_cod=$leer_respuesta['codigo'];
								$dcps_error_desc=$leer_respuesta['errors'];
								$dataex['error_especial']=' JSON ENVIADO';
								$dataex['msg'] ='Documento a Error';
								
								$this->mfacturacion->m_update_facturacion_rpsunat_error(array($dp->coddoc, $dcps_error_cod,$dcps_error_desc));
							} 
							else {
								$dataex['respuesta2']=$leer_respuesta;
								$dcps_aceptado=($leer_respuesta['aceptada_por_sunat']==true)?"SI":"NO";
								$dcps_snt_cadenaqr=$leer_respuesta['cadena_para_codigo_qr'];
								
								$dcps_snt_hash=$leer_respuesta['codigo_hash'];
								$dcps_snt_enlace=$leer_respuesta['enlace'];
								$dcps_snt_enlace_cdr=$leer_respuesta['enlace_del_cdr'];
								$dcps_snt_enlace_pdf=$leer_respuesta['enlace_del_pdf'];
								$dcps_snt_enlace_xml=$leer_respuesta['enlace_del_xml'];
								$dcps_numero=$leer_respuesta['numero'];
								
								$dcps_serie=$leer_respuesta['serie'];
								$dcps_snt_descripcion=$leer_respuesta['sunat_description'];
								$dcps_snt_note=$leer_respuesta['sunat_note'];
								$dcps_snt_responsecode=$leer_respuesta['sunat_responsecode'];
								$dcps_snt_soap_error=$leer_respuesta['sunat_soap_error'];
								$dcps_tipodoc_nube=$leer_respuesta['tipo_de_comprobante'];
								$dcps_snt_codigobarras="";
								$dcps_error_cod="";
								$dcps_error_desc="";
								$dataex['error_especial']=' JSON ENVIADO';
								$dataex['msg'] ='Documento Enviado';
								
								$rsrp=$this->mfacturacion->m_update_facturacion_rpsunat(array($dp->coddoc, $dcps_tipodoc_nube, $dcps_serie, $dcps_numero, $dcps_snt_enlace, $dcps_aceptado, $dcps_snt_descripcion, $dcps_snt_note, $dcps_snt_responsecode, $dcps_snt_soap_error, $dcps_snt_cadenaqr, $dcps_snt_hash, $dcps_snt_codigobarras, $dcps_snt_enlace_pdf, $dcps_snt_enlace_xml, $dcps_snt_enlace_cdr,$dcps_error_cod,$dcps_error_desc));
								if ($rsrp->salida=="1"){
									//$this->mfacturacion->m_update_estado_docpago(array($nuevo_id,"ENVIADO"));
									$dataex['msg'] ='SUNAT actualizado';
									$dataex['status'] =TRUE;
								}
								////////////////////////////	
							}	
						}
	            	}
            	}

        	}
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_enviar_doc_pendientes_a_nube()
    {
    	$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
        	$dataex['msg'] ='No tienes autorización para esta acción';
        	if (getPermitido("111") == "SI") {
	            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            	date_default_timezone_set ('America/Lima');
                $docs_pendientes= $this->mfacturacion->get_docpagos_pendientes($_SESSION['userActivo']->idsede);

                $items= $this->mfacturacion->get_items_docpago_pendientes($_SESSION['userActivo']->idsede);

				$items_array=array();
				foreach ($items as $key => $it) {
					$item=array(
					    "unidad_de_medida"          => $it->unidad,
					    "codigo"                    => $it->codgestion,
					    "descripcion"               => $it->gestion,
					    "cantidad"                  => $it->cantidad,
					    "valor_unitario"            => $it->v_unitario,
					    "precio_unitario"           => $it->p_unitario,
					    "descuento"                 => $it->m_descuento,
					    "subtotal"                  => $it->subtotal,
					    "tipo_de_igv"               => $it->tipoigv,
					    "igv"                       => $it->igv,
					    "total"                     => $it->total,
					    "anticipo_regularizacion"   => "false",
					    "anticipo_documento_serie"  => "",
					    "anticipo_documento_numero" => ""
					);
					$items_array[$it->coddoc][]=$item;
				    
				}
		

              	$nube= $this->mfacturacion->m_get_conexion_nubefact($_SESSION['userActivo']->idsede);
				$ruta = $nube->ruta;
				$token = $nube->token;
              	foreach ($docs_pendientes as $key => $dp) {
              		# code...
              		if (array_key_exists($dp->coddoc,$items_array)){
              			//if (count($items_array[$dp->coddoc]))
              			
		                $leer_respuesta="";
		                $dataex['msg'] ="Documento encontrado";
						//if (isset($dp->nro)){
							$dataex['msg'] ="Documento NO ENVIADO a SUNAT aun";
							if (($dp->estado=="PENDIENTE") || ($dp->estado=="ERROR")){
								
								$data = array(
								    "operacion"							=> "generar_comprobante",
								    "tipo_de_comprobante"               => $dp->tipodoc,
								    "serie"                             => $dp->serie,
								    "numero"							=> $dp->nro,
								    "sunat_transaction"					=> "1",
								    "cliente_tipo_de_documento"			=> $dp->pagtipodoc,
								    "cliente_numero_de_documento"		=> $dp->pagnrodoc,
								    "cliente_denominacion"              => $dp->pagante,
								    "cliente_direccion"                 => $dp->pagdirecion,
								    "cliente_email"                     => $dp->pagcorreo1,
								    "cliente_email_1"                   => $dp->pagcorreo2,
								    "cliente_email_2"                   => $dp->pagcorreo3,
								    "fecha_de_emision"                  => date('d-m-Y', strtotime($dp->fecha)),
								    "fecha_de_vencimiento"              => $dp->vence,
								    "moneda"                            => "1",
								    "tipo_de_cambio"                    => "",
								    "porcentaje_de_igv"                 => $dp->igvporc,
								    "descuento_global"                  => $dp->dsctoglobal,
								    "total_descuento"                   => $dp->dsctototal,
								    "total_anticipo"                    => "",
								    "total_gravada"                     => $dp->opergrav,
								    "total_inafecta"                    => $dp->operinaf,
								    "total_exonerada"                   => $dp->operexon,
								    "total_igv"                         => $dp->igvtotal,
								    "total_gratuita"                    => $dp->opergrat,
								    "total_otros_cargos"                => "",
								    "total"                             => $dp->total,
								    "percepcion_tipo"                   => "",
								    "percepcion_base_imponible"         => "",
								    "total_percepcion"                  => "",
								    "total_incluido_percepcion"         => "",
								    "detraccion"                        => "false",
								    "observaciones"                     => $dp->obs,
								    "documento_que_se_modifica_tipo"    => "",
								    "documento_que_se_modifica_serie"   => "",
								    "documento_que_se_modifica_numero"  => "",
								    "tipo_de_nota_de_credito"           => "",
								    "tipo_de_nota_de_debito"            => "",
								    "enviar_automaticamente_a_la_sunat" => "true",
								    "enviar_automaticamente_al_cliente" => "false",
								    "codigo_unico"                      => "",
								    "condiciones_de_pago"               => "",
								    "medio_de_pago"                     => "",
								    "placa_vehiculo"                    => "",
								    "orden_compra_servicio"             => "",
								    "tabla_personalizada_codigo"        => "",
								    "formato_de_pdf"                    => "",
								    "items" 							=> $items_array[$dp->coddoc]
								);
								//var_dump($data);
								$leer_respuesta=$this->fn_enviar_json_independiente($ruta,$token,$data);
								if (isset($leer_respuesta['errors'])) {
									//Mostramos los errores si los hay
							    	$dataex['error_sunat']=$leer_respuesta['errors'];
							    	//$dataex['respuesta']=$leer_respuesta;
							    	$dcps_error_cod=$leer_respuesta['codigo'];
									$dcps_error_desc=$leer_respuesta['errors'];
									$dataex['error_especial']=' JSON ENVIADO';
									$dataex['msg'] ='Documento a Error';
									
									$this->mfacturacion->m_update_facturacion_rpsunat_error(array($dp->coddoc, $dcps_error_cod,$dcps_error_desc));
								} 
								else {
									$dataex['respuesta2']=$leer_respuesta;
									$dcps_aceptado=($leer_respuesta['aceptada_por_sunat']==true)?"SI":"NO";
									$dcps_snt_cadenaqr=$leer_respuesta['cadena_para_codigo_qr'];
									
									$dcps_snt_hash=$leer_respuesta['codigo_hash'];
									$dcps_snt_enlace=$leer_respuesta['enlace'];
									$dcps_snt_enlace_cdr=$leer_respuesta['enlace_del_cdr'];
									$dcps_snt_enlace_pdf=$leer_respuesta['enlace_del_pdf'];
									$dcps_snt_enlace_xml=$leer_respuesta['enlace_del_xml'];
									$dcps_numero=$leer_respuesta['numero'];
									
									$dcps_serie=$leer_respuesta['serie'];
									$dcps_snt_descripcion=$leer_respuesta['sunat_description'];
									$dcps_snt_note=$leer_respuesta['sunat_note'];
									$dcps_snt_responsecode=$leer_respuesta['sunat_responsecode'];
									$dcps_snt_soap_error=$leer_respuesta['sunat_soap_error'];
									$dcps_tipodoc_nube=$leer_respuesta['tipo_de_comprobante'];
									$dcps_snt_codigobarras="";
									$dcps_error_cod="";
									$dcps_error_desc="";
									$dataex['error_especial']=' JSON ENVIADO';
									$dataex['msg'] ='Documento Enviado';
									
									$rsrp=$this->mfacturacion->m_update_facturacion_rpsunat(array($dp->coddoc, $dcps_tipodoc_nube, $dcps_serie, $dcps_numero, $dcps_snt_enlace, $dcps_aceptado, $dcps_snt_descripcion, $dcps_snt_note, $dcps_snt_responsecode, $dcps_snt_soap_error, $dcps_snt_cadenaqr, $dcps_snt_hash, $dcps_snt_codigobarras, $dcps_snt_enlace_pdf, $dcps_snt_enlace_xml, $dcps_snt_enlace_cdr,$dcps_error_cod,$dcps_error_desc));
									if ($rsrp->salida=="1"){
										$this->mfacturacion->m_update_estado_docpago(array($dp->coddoc,"ENVIADO"));
										$dataex['msg'] ='SUNAT actualizado';
										$dataex['status'] =TRUE;
									}
									////////////////////////////	
								}	
							}
		            	//}
	            	}
            	}

        	}
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


	function fn_enviar_json_independiente($ruta,$token,$data){
		// RUTA para enviar documentos
		$data_json = json_encode($data);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $ruta);
		curl_setopt(
			$ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Token token="'.$token.'"',
			'Content-Type: application/json',
			)
		);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$respuesta  = curl_exec($ch);
		curl_close($ch);
		return json_decode($respuesta, true);	

	}


	public function fn_filtrar_detalle_docpago()
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
				$this->load->model("mfacturacion_impresion");

				$dataex['status'] =FALSE;
								
				$coddocpago = base64url_decode($this->input->post('vw_fcb_codigopago'));
				$pagos=$this->mfacturacion_impresion->m_get_docpagos(array($coddocpago));
				$detalle = $this->mfacturacion_impresion->m_get_pagos_detalle(array($coddocpago));

				if (count($detalle) > 0) {
					foreach ($detalle as $key => $fila) {
						$fila->preunit = number_format($fila->mpunit, 2);
						$fila->igv = number_format($fila->migv, 2);
					}

					$dataex['status'] =TRUE;
					$dataex['vdata'] = $detalle;
					$dataex['subtotal'] = number_format($pagos->subtotal, 2);
					$dataex['igv'] = number_format($pagos->migv, 2);
					$dataex['total'] = number_format($pagos->total, 2);
					$dataex['vdatap'] = $pagos;
				} else {
					$dataex['status'] =false;
					$dataex['vdata'] = 0;
					$dataex['subtotal'] = number_format('0', 2);
					$dataex['igv'] = number_format('0', 2);
					$dataex['total'] = number_format('0', 2);
					$dataex['vdatap'] = 0;
				}
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

}
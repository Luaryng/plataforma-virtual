<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Facturacion extends Error_views{
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->helper("url"); 
		$this->load->model("mfacturacion");
		$this->load->model("mfacturacion_cobros");
		$this->load->model('mauditoria');
		$this->load->model('mpagante');
		$this->load->model('mubigeo');
		//$this->load->library('pagination');
	}


   /* public function vw_virtual_archivos($id)
    {
        $area=base64url_decode($area);
        $id=base64url_decode($id);
        $fila=$this->mdocumentos_pago->m_get_itemdoc(array($id));

        if (isset($fila->ruta)){
            $fileName = $fila->ruta;
            $filePath = 'upload/docpagos/'.$fileName;
            $partes_ruta = pathinfo($fila->ruta);

            $nombre=url_clear($fila->titulo).".".$partes_ruta['extension'];
            if(!empty($fileName) && file_exists($filePath)){
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$nombre");
                header("Content-Type: fila->tipo");
                header("Content-Transfer-Encoding: binary");
                readfile($filePath);
                exit;
            }
            else{
                header("Location: ".base_url()."no-encontrado");
            }
        }
        else{
            header("Location: ".base_url()."no-encontrado2");
        } 
    }*/

    public function vw_documentos_de_pago()
	{
		if (((getPermitido("97") == "SI")) && (($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'AD'))){
			$ahead= array('page_title' =>'Documentos de Pago | ERP'  );
			$asidebar= array('menu_padre' =>'mn_facturaerp');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_facturacion',$asidebar);
			$items=array();
			//$rstdata = $this->mdocumentos_pago->m_get_emitidos_index();
			$rstdata['mediosp'] = $this->mfacturacion_cobros->m_get_medios_pago();
			$rstdata['bancos'] = $this->mfacturacion_cobros->m_get_bancos();
			$rstdata['items'] = $this->mfacturacion->m_get_emitidos_index(array($_SESSION['userActivo']->idsede));
			$this->load->view('facturacion/vw_documentos_pago', $rstdata);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}
	public function vw_documentos_crear()
	{
		if ($_SESSION['userActivo']->codnivel!="3"){
			$vtipo=(null ==$this->input->get('tp'))?"boleta":$this->input->get('tp');
			if ($vtipo=="boleta") {
				$rstdata['tipo'] = "BL";
				$rstdata['tipol'] = "BOLETA ELECTRÓNICA";
			}
			else if ($vtipo=="factura") {
				$rstdata['tipo'] = "FC";
				$rstdata['tipol'] = "FACTURA ELECTRÓNICA";
			}
			
			$serie_sede= $this->mfacturacion->m_get_docserie(array($rstdata['tipo'],$_SESSION['userActivo']->idsede));
			
			if (isset($serie_sede->sede)){


				$rstdata['docserie']=$serie_sede;
				$ahead= array('page_title' =>$rstdata['tipol'].' - '.$this->ci->config->item('erp_title')  );
				$asidebar= array('menu_padre' =>'mn_facturaerp');
				$this->load->view('head',$ahead);
				$this->load->view('nav');
				$this->load->view('sidebar_facturacion',$asidebar);
				$items=array();
				$rstdata['items']="";
				$rstdata['departamentos'] =$this->mubigeo->m_departamentos();
				$rstdata['gestion'] =$this->mfacturacion->m_get_items_gestion_habilitados();
				$rstdata['unidad'] =$this->mfacturacion->m_get_unidades_habilitados();
				$rstdata['iscs'] =$this->mfacturacion->m_get_isc_habilitados();
				$rstdata['afectacion'] =$this->mfacturacion->m_get_afectacion_habilitados();
				$rsdocidentidad =$this->mfacturacion->m_get_tipo_identidad_habilitados();
				$rstdata['mediosp'] = $this->mfacturacion_cobros->m_get_medios_pago();
				$rstdata['bancos'] = $this->mfacturacion_cobros->m_get_bancos();
				foreach ($rsdocidentidad as $key => $di) {
					$pos = strpos($di->docs_permitidos, $rstdata['tipo'] );
					if ($pos === false)  unset($rsdocidentidad[$key]);
				}
				$rstdata['tipoidentidad']=$rsdocidentidad;
				$rstdata['tipoopera51'] =$this->mfacturacion->m_get_tipo_operacion_xtipodoc_habilitados($rstdata['tipo']);
				
				$this->load->view('facturacion/vw_documentos_factura_crear', $rstdata);
				$this->load->view('footer');
			}
			else{
				
				$ahead= array('page_title'=>$rstdata['tipol'].' - '.$this->ci->config->item('erp_title'));
				$avwh= array('msg_title' =>"Sin Habilitación",'msg' =>"Se requiere habilitar la serie correcta para la sede actual: ".$_SESSION['userActivo']->sede);
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                
                $this->load->view("sidebar_facturacion");
                $this->load->view('errors/vwh_error_personalizado',$avwh);
                $this->load->view('footer');

			}
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function fn_filtrar_xsede()
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
			
			$emision = $this->input->post('fictxtfecha_emision');
			$emisionf = $this->input->post('fictxtfecha_emisionf');
			$busqueda = $this->input->post('fictxtpagapenom');

			$databuscar=array();

			if ($emision != "" && $emisionf != "") {
				$horaini = ' 00:00:01';
				$horafin = ' 23:59:59';
				$databuscar[]=$emision.$horaini;
				$databuscar[]=$emisionf.$horafin;
			}
			elseif ($emision == "" && $emisionf == "") {
				/*$emision='1990-01-01 00:00:01';
				$emisionf=date("Y-m-d").' 23:59:59';*/
			}
			elseif ($emision == "") {
				$emision='1990-01-01 00:00:01';
				$emisionf=$emisionf.' 23:59:59';
				$databuscar[]=$emision;
				$databuscar[]=$emisionf;
			}
			else{
				$emision=$emision.' 00:00:01';
				$emisionf=date("Y-m-d").' 23:59:59';
				$databuscar[]=$emision;
				$databuscar[]=$emisionf;
			}
			
			$rstdata = $this->mfacturacion->m_get_emitidos_filtro_xsede($_SESSION['userActivo']->idsede,$busqueda,$databuscar);
			if (@count($rstdata) > 0) {
                $dataex['status'] = true;
                $rsdata['items'] = $rstdata;
                $datos = $this->load->view('facturacion/vw_filtrar_result', $rsdata, true);
            } else {
            	$datos = "Datos no encontrados";
            }
								
			
		}
		$dataex['vdata'] = $datos;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));

	}


	public function get_search_lista()
	{
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rspagant = "";

		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$tipodoc = $this->input->post('vw_fcb_cbtipodocs');
			$nrodoc = $this->input->post('fictxtnrodoc');
			$razon = $this->input->post('fictxtnompagante');
				
			
			$dtpag['historial'] = $this->mpagante->m_get_pagante_lista(array($tipodoc, $nrodoc, $razon) );
			
			$rspagant = $this->load->view('facturacion/dts_pagante',$dtpag,TRUE);
			$dataex['status'] = TRUE;
			
		}
		$dataex['vdata'] = $rspagant;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function get_search_item()
	{
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rspitems = "";

		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$codigo = $this->input->post('fictxtcoditem');
			$nombre = $this->input->post('fictxtnomitem');
			
			$dtpag['items'] = $this->mpagante->m_get_item_lista(array($codigo, $nombre) );
			
			$rspitems = $this->load->view('facturacion/dts_ltsitem',$dtpag,TRUE);
			$dataex['status'] = TRUE;
		}
		$dataex['vdata'] = $rspitems;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	/*public function vw_agregar_items()
	{
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$this->form_validation->set_rules('txtcnt','contador','trim|required');

			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$cnt = $this->input->post('txtcnt');
				$codigo = $this->input->post('txtcodigo');
				$detalle = $this->input->post('txtdescrip');
				$unidad = $this->input->post('txtunidad');
				$valor = $this->input->post('txtvalor');
				if ($cnt != "") {
					$dataex['status'] =true;
					$arrayitem['nro'] = $cnt;
					$arrayitem['codigo'] = $codigo;
					$arrayitem['detalle'] = $detalle;
					$arrayitem['unidad'] = $unidad;
					$arrayitem['valor'] = $valor;
					$dataex['vdata']=$this->load->view('facturacion/add_detalle_item', $arrayitem, true);
				}
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}*/

	

	public function vw_agregar()
	{
		if ($_SESSION['userActivo']->codnivel=="0"){
			$ahead= array('page_title' =>'Documentos pagos - Agregar | ERP'  );
			$asidebar= array('menu_padre' =>'pagos');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$this->load->view('documentopagos/vw_agregar');
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function vw_editar($id)
    {
        
        
		if ($_SESSION['userActivo']->codnivel=="0"){
        	$id=base64url_decode($id);
			$ahead= array('page_title' =>'Documentos pagos - Editar | ERP'  );
			$asidebar= array('menu_padre' =>'pagos');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$fila['mat']=$this->mdocumentos_pago->m_get_itemdoc(array($id));
			
			$this->load->view('documentopagos/vw_agregar', $fila);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}


	public function uploadfile(){
        $dataex['link']="";
        $fileTmpLoc   = $_FILES["file"]["tmp_name"]; // File in the PHP tmp folder
        $fileType     = $_FILES["file"]["type"]; // The type of file it is
        $fileSize     = $_FILES["file"]["size"]; // File size in bytes
        $fileErrorMsg = $_FILES["file"]["error"]; // 0 for false... and 1 for true
        $fileNameExt  = $_FILES["file"]["name"];
        $ext          = explode(".", $fileNameExt);
        $extension    = end($ext);
        $NewfileName  = "adp".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . $_SESSION['userActivo']->codpersona;
        $arc_temp = pathinfo($fileTmpLoc);

        
        $nomb_temp=url_clear($arc_temp['filename']);
        $nro_rand=rand(0,9);
        $link=$NewfileName.$nomb_temp.$nro_rand.".".$extension;
        $dataex['link'] = "";
        $dataex['temp'] = "";
        $directorio = "./upload/docpagos";
	    if (!file_exists($directorio)) {

            mkdir($directorio, 0755);

        }
        if (move_uploaded_file($fileTmpLoc, "upload/docpagos/$link")) {
            $dataex['link'] = $link;
            $dataex['temp'] = $fileTmpLoc;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }


	public function uploadimages(){
		if ($_FILES['file']['name']) {
			if (!$_FILES['file']['error']) {
			    $name = md5(Rand(100, 200));
			    $ext = explode('.', $_FILES['file']['name']);
			    $filename = $name . '.' . $ext[1];
			    $destination = './resources/img/bolsa_trabajo/' . $filename; //change this directory
			    $location = $_FILES["file"]["tmp_name"];
			    move_uploaded_file($location, $destination);
			    echo 'resources/img/bolsa_trabajo/' . $filename;
			} else {
			  echo  $message = 'Se ha producido el siguiente error:  '.$_FILES['file']['error'];
			}
		}
	}

	public function delete_file()
    {
        $src = $this->input->post('src'); 
        // $src = $_POST['src']; 
        $file_name = str_replace(base_url(), '', $src); 
        // link de host para obtener la ruta relativa
        if(unlink($file_name)) { 
            echo 'imagen eliminada correctamente'; 
        }
    }

	

	public function fn_guardar_docpago()
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

						$validacion=true;
						if (($codtipoo_peracion_51=="0200") && ($pagante_tipodoc!="SDI")){
							$validacion=false;
								$dataex['msg']="Si es una operación de EXPORTACIÓN, el cliente debe tener como tipo de documento DOC.TRIB.NO.DOM.SIN.RUC (EXPORTACIÓN)";
						}
						if ($tipodoc_cod=="FC") {
							if (substr($dcp_serie, 0, 1)!="F" )
							$validacion=false;
							$dataex['msg']="Serie debe empezar con F";
						}
						if ($tipodoc_cod=="BL") {
							if (substr($dcp_serie, 0, 1)!="B" )
							$validacion=false;
							$dataex['msg']="Serie debe empezar con B";
						}
						if (($tipodoc_cod=="FC") && ($pagante_tipodoc!="RUC")){
							$validacion=false;
								$dataex['msg']="Documeto de Identidad incorrecto para una Factura";
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

							//$codtipoo_peracion_51=$this->input->post('vw_fcb_cbtipo_operacion51');
						 	
							
							$dcp_numero=$this->input->post('vw_fcb_sernumero');
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

							
							
							$dcp_total=$this->input->post('vw_fcb_txttotal');

							$serie= $this->input->post('vw_fcb_serie');
							
							$dcp_fecha_vence=$this->input->post('vw_fcb_vencimiento');
							if ($dcp_fecha_vence=="") $dcp_fecha_vence=null;
							
				            $usuario = $_SESSION['userActivo'];
							$sede = $_SESSION['userActivo']->idsede;
		                    
							date_default_timezone_set ('America/Lima');
							$rpta=0;
							$rptad=0;
							 

							$datosDocumento=array($codtipoo_peracion_51, $tipodoc_cod, $dcp_serie, $dcp_fecha_hora, $dcp_fecha_vence, $pagante_cod, $dcp_pagante, $pagante_tipodoc, $pagante_nrodoc, $dcp_direccion, $matricula_cod, $dcp_observacion, $sede_id, $dcp_descuento_general, $dcp_igv, $dcp_total, $dcp_mnto_oper_gravadas, $dcp_mnto_oper_inafecta, $dcp_mnto_oper_exonerada, $dcp_mnto_oper_exportacion, $dcp_mnto_dsctos_totales, $dcp_mnto_oper_gratis, $dcp_mnto_igv, $dcp_mnto_isc, $dcp_monto_icbper, $dcp_total_impuestos, $dcp_valor_venta, $dcp_subtotal, $dcp_descuento_factor);
							$rpta = $this->mfacturacion->m_insert_facturacion($datosDocumento);
							$dataex['error_especial']='DP';
							$dataex['msg'] ='No se pudo guardar el Documento de Pago - Error: DD';
							if ($rpta->salida == '1') {
								$cod_docpago=$rpta->nid;
								
								$n_items_guardados=0;
								foreach ($items as $key => $item) {
									
									
									
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

									 //$dpd_mnto_valor_venta=floatval($dpd_mnto_valor_unitario) * floatval($dpd_cantidad);
									 $dpd_mnto_base_sinigv=$dpd_mnto_valor_venta - $dpd_mnto_igv;
									 $dpd_porc_igv=$dcp_igv;
									 // monto IGV
									 

									 $dpd_icbper_factor=0;//$item['vw_fcb_ai_txticbper_factor'];
									 $dpd_icbper_mnto=floatval($dpd_cantidad) * floatval($dpd_icbper_factor);

									 //$dpd_mnto_precio_unit=($dpd_mnto_valor_venta + $dpd_monto_total_impuesto) / floatval($dpd_cantidad) ; 

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
										$dataex['respuesta']=$leer_respuesta;
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
	                			$dataex['msg']="El Nro de Documento ya fue registrado";
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

	public function fn_anula_docpago()
    {
    	$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('ficdocumentcodigo','codigo','trim|required');
            
            $this->form_validation->set_rules('ficmotivanula','Motivo','trim|required');

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
                $dataex['msg'] ="Cambio NO realizado";
                $dataex['status'] =FALSE;
                $coddocum64 = $this->input->post('ficdocumentcodigo');
                $coddocum = base64url_decode($coddocum64);
                $motivo = $this->input->post('ficmotivanula');
                $fechanula = date('Y-m-d H:i:s');
                $cenestado = "ANULADO";
                    
                $newcod=$this->mfacturacion->m_update_anular_docpago(array($coddocum, $fechanula, $cenestado, $motivo));
                if ($newcod==1){
                    $dataex['status'] =TRUE;
                    $dataex['iddocpago'] = $coddocum64;
                    $dataex['estadoc'] = $cenestado;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }



	function fn_enviar_json($dc){
		// RUTA para enviar documentos
		$leer_respuesta="";
		$dp= $this->mfacturacion->get_docpago($dc);
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
		    "items" => $items_array
		);
		//var_dump($data);
		$data_json = json_encode($data);

		/*
		#########################################################
		#### PASO 3: ENVIAR EL ARCHIVO A NUBEFACT ####
		+++++++++++++++++++++++++++++++++++++++++++++++++++++++
		# SI ESTÁS TRABAJANDO CON ARCHIVO JSON
		# - Debes enviar en el HEADER de tu solicitud la siguiente lo siguiente:
		# Authorization = Token token="8d19d8c7c1f6402687720eab85cd57a54f5a7a3fa163476bbcf381ee2b5e0c69"
		# Content-Type = application/json
		# - Adjuntar en el CUERPO o BODY el archivo JSON o TXT
		# SI ESTÁS TRABAJANDO CON ARCHIVO TXT
		# - Debes enviar en el HEADER de tu solicitud la siguiente lo siguiente:
		# Authorization = Token token="8d19d8c7c1f6402687720eab85cd57a54f5a7a3fa163476bbcf381ee2b5e0c69"
		# Content-Type = text/plain
		# - Adjuntar en el CUERPO o BODY el archivo JSON o TXT
		+++++++++++++++++++++++++++++++++++++++++++++++++++++++
		*/

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

		/*
		 #########################################################
		#### PASO 4: LEER RESPUESTA DE NUBEFACT ####
		+++++++++++++++++++++++++++++++++++++++++++++++++++++++
		# Recibirás una respuesta de NUBEFACT inmediatamente lo cual se debe leer, verificando que no haya errores.
		# Debes guardar en la base de datos la respuesta que te devolveremos.
		# Escríbenos a soporte@nubefact.com o llámanos al teléfono: 01 468 3535 (opción 2) o celular (WhatsApp) 955 598762
		# Puedes imprimir el PDF que nosotros generamos como también generar tu propia representación impresa previa coordinación con nosotros.
		# La impresión del documento seguirá haciéndose desde tu sistema. Enviaremos el documento por email a tu cliente si así lo indicas en el archivo JSON o TXT.
		+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		 */

		$leer_respuesta = json_decode($respuesta, true);
		}
		return  $leer_respuesta;

	}


}
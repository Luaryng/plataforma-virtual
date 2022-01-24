<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Facturacion_anulacion extends CI_Controller{
	//private $ci;
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

	public function fn_anula_docpago()
    {
    	$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
        	$dataex['msg'] ='No tienes autorización para esta acción';
        	if (getPermitido("102") == "SI") {
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
	                
	                $dataex['status'] =FALSE;
	                $coddocum64 = $this->input->post('ficdocumentcodigo');
	                $coddocum = base64url_decode($coddocum64);
	                $motivo = $this->input->post('ficmotivanula');
	                //$fechanula = date('Y-m-d H:i:s');
	                $cenestado = "ANULADO";
	                
	                $leer_respuesta="";
	                $dataex['msg'] ="Documento encontrado";
					$dp= $this->mfacturacion->get_docpago($coddocum);
					if (isset($dp->nro)){
						$dataex['msg'] ="Documento no aceptado en SUNAT aun";
						if ($dp->estado=="ACEPTADO"){
							$nube= $this->mfacturacion->m_get_conexion_nubefact($_SESSION['userActivo']->idsede);
							$ruta = $nube->ruta;
							$token = $nube->token;
							$data = array(
							    "operacion"							=> "generar_anulacion",
							    "tipo_de_comprobante"               => $dp->tipodoc,
							    "serie"                             => $dp->serie,
							    "numero"							=> $dp->nro,
							    "motivo"							=> $motivo,
							    "codigo_unico"						=> ""
							);
							//var_dump($data);
							$leer_respuesta=$this->fn_enviar_json($ruta,$token,$data);
							if (isset($leer_respuesta['errors'])) {

								//Mostramos los errores si los hay
						    	$dataex['error_sunat']=$leer_respuesta['errors'];
						    	//$dataex['respuesta']=$leer_respuesta;
						    	$dcps_error_cod=$leer_respuesta['codigo'];
								$dcps_error_desc=$leer_respuesta['errors'];
								$dataex['error_especial']=' JSON ENVIADO';
								$dataex['msg'] =$dcps_error_desc;
								
								$this->mfacturacion->m_insert_facturacion_rpsunat_anulacion_error(array($coddocum, $dcps_error_cod,$dcps_error_desc));
							} 
							else {
								
								$dataex['error_especial']=' JSON ENVIADO';
								
								
								//
								sleep(10);	

								$data = array(
								    "operacion"							=> "consultar_anulacion",
								    "tipo_de_comprobante"               => $dp->tipodoc,
								    "serie"                             => $dp->serie,
								    "numero"							=> $dp->nro
								);
								$leer_respuesta2=$this->fn_enviar_json($ruta,$token,$data);
								if (isset($leer_respuesta2['errors'])) {

									//Mostramos los errores si los hay
							    	$dataex['error_sunat']=$leer_respuesta2['errors'];
							    	//$dataex['respuesta']=$leer_respuesta2;
							    	$dcps_error_cod=$leer_respuesta2['codigo'];
									$dcps_error_desc=$leer_respuesta2['errors'];
									$dataex['error_especial']=' JSON ENVIADO';
									$dataex['msg'] =$dcps_error_desc;
									
									$this->mfacturacion->m_insert_facturacion_rpsunat_anulacion_error(array($coddocum, $dcps_error_cod,$dcps_error_desc));
								} 
								else {
									$dataex['respuesta']=$leer_respuesta2;
									$dcps_aceptado=($leer_respuesta2['aceptada_por_sunat']==true)?"SI":"NO";
									$dcps_snt_enlace=$leer_respuesta2['enlace'];
									$dcps_snt_enlace_cdr=$leer_respuesta2['enlace_del_cdr'];
									$dcps_snt_enlace_pdf=$leer_respuesta2['enlace_del_pdf'];
									$dcps_snt_enlace_xml=$leer_respuesta2['enlace_del_xml'];
									$dcps_numero=$dp->nro;
									$dcps_numero_respuesta=$leer_respuesta2['numero'];
									$dcps_snt_ticket=$leer_respuesta2['sunat_ticket_numero'];
									$dcps_serie=$dp->serie;
									$dcps_snt_descripcion=$leer_respuesta2['sunat_description'];
									$dcps_snt_note=$leer_respuesta2['sunat_note'];
									$dcps_snt_responsecode=$leer_respuesta2['sunat_responsecode'];
									$dcps_snt_soap_error=$leer_respuesta2['sunat_soap_error'];
									$dcps_tipodoc_nube=$dp->tipodoc;
				
									$dcps_error_cod="";
									$dcps_error_desc="";
									$rs=$this->mfacturacion->m_insert_facturacion_anulacion_rpsunat(array($coddocum, $dcps_tipodoc_nube, $dcps_serie, $dcps_numero, $dcps_numero_respuesta, $dcps_snt_enlace, $dcps_snt_ticket, $dcps_aceptado, $dcps_snt_descripcion, $dcps_snt_note, $dcps_snt_responsecode, $dcps_snt_soap_error, $dcps_snt_enlace_pdf, $dcps_snt_enlace_xml, $dcps_snt_enlace_cdr, $dcps_error_cod, $dcps_error_desc, $motivo,date('Y-m-d H:i:s')));
									if($rs->salida==1){
										$dataex['status'] =TRUE;
					                    $dataex['msg'] ="Documento Anulado";
									}
								}
							} 	
							//return  $leer_respuesta;
						}
						
						
					}
	                /*$newcod=$this->mfacturacion->m_update_anular_docpago(array($coddocum, $fechanula, $cenestado, $motivo));
	                if ($newcod==1){
	                    
	                    
	                }*/
	            }
	        }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    function fn_enviar_json($ruta,$token,$data){
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

   
}
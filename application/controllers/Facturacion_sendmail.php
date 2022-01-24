<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Sendmail.php';
class Facturacion_sendmail extends Sendmail
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('mfacturacion_impresion');
		$this->load->model('mfacturacion_sendmail');

	}

	public function fn_enviar_documento_email()
    {
        $this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_fb_codigo','Destino','trim|required');
			$this->form_validation->set_rules('vw_fcb_email','Mensaje','trim|required');

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
				$vuser=$_SESSION['userActivo'];
				$pathtodir =  getcwd();
				$contXML = "";
				$contCDR = "";
				$this->load->model('miestp');
        		$iestp=$this->miestp->m_get_datos();
				$pruebas_email=array();
				$codigo64 = $this->input->post('vw_fb_codigo');
				$codigo=base64url_decode($codigo64);
				
				$d_destino=$this->input->post('vw_fcb_email');

				$rpta = $this->mfacturacion_impresion->m_get_docpagos(array($codigo));
				
				$d_asunto=$rpta->nomimpreso.' '.$rpta->serie."-".$rpta->numero;
				$pdfdoc = $this->doc_pago_impreso($codigo64);

				$rptasunat = $this->mfacturacion_sendmail->m_get_datos_sunat(array($codigo));

				if ($rpta->tdocid == "BL") {
					$contXML = "<p><b>Enlace para descargar el XML  de la ".$rpta->nomimpreso." </b>: <a href='".$rptasunat->enl_xml."'> Descargar XML</a></p>";
					$contCDR = "<p></p>";
				} else if ($rpta->tdocid == "FC") {
					$contXML = "<p><b>Enlace para descargar el XML  de la ".$rpta->nomimpreso." </b>: <a href='".$rptasunat->enl_xml."'> Descargar XML</a></p>";
					$contCDR = "<p><b>Enlace para descargar el CDR  de la ".$rpta->nomimpreso." </b>: <a href='".$rptasunat->enl_cdr."'> Descargar CDR</a></p>";
				}

				$d_mensaje = "<p>Se le ha enviado su ".$rpta->nomimpreso." con Éxito</p>".$contXML.$contCDR;
				$pruebas_email[]=array($pdfdoc, 'attachment',$rpta->nomimpreso.' '.$rpta->serie." - ".$rpta->numero.".pdf","application/pdf");
				 
				$d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
				$r_respondera = $d_enviador;
				$rsp=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email,$r_respondera);
				// $dataex['status'] =true;
				$dataex['status']=$rsp['estado'];
				$dataex['mensaje']=$rsp['mensaje'];
				
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
    }

    public function doc_pago_impreso($coddocpago)
    {
    	$dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';

        $coddocpago=base64url_decode($coddocpago);

        $this->load->model('miestp');

        $pagos=$this->mfacturacion_impresion->m_get_docpagos(array($coddocpago));
        $detalle = $this->mfacturacion_impresion->m_get_pagos_detalle(array($coddocpago));
        $idsede=$pagos->sedeid;
        $dtserie = $this->mfacturacion_impresion->m_get_docserie_sede_tipo(array($pagos->tdocid, $idsede,$pagos->serie));

            $mentero=intval($pagos->total);
            $montotexto=$this->convertir_monto($mentero);
            $dominio=str_replace(".", "_",getDominio());
            
            $html1=$this->load->view('facturacion/impresion/dc_bol_electronica_imp_'.$dominio."_".$dtserie->formato, array('pag' => $pagos,'detalle'=>$detalle, 'dserie'=>$dtserie,'mtexto'=>$montotexto),true);
             
            $pdfFilePath = "DOCPAGO $pagos->serie $pagos->numero ".$pagos->pagante.".pdf";

            $this->load->library('M_pdf');
            // $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
            
            $formatoimp="A4";
            
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

            $mpdf->SetTitle( "TICKET PAGO ".$pagos->pagante);
            
            $mpdf->WriteHTML($html1);

        return $mpdf->Output($pdfFilePath, "S");

    }

    public function convertir_monto($monto) 
    {
        $maximo = pow(10,9);
        $unidad            = array(1=>"uno", 2=>"dos", 3=>"tres", 4=>"cuatro", 5=>"cinco", 6=>"seis", 7=>"siete", 8=>"ocho", 9=>"nueve");
        $decena            = array(10=>"diez", 11=>"once", 12=>"doce", 13=>"trece", 14=>"catorce", 15=>"quince", 20=>"veinte", 30=>"treinta", 40=>"cuarenta", 50=>"cincuenta", 60=>"sesenta", 70=>"setenta", 80=>"ochenta", 90=>"noventa");
        $prefijo_decena    = array(10=>"dieci", 20=>"veinti", 30=>"treinta y ", 40=>"cuarenta y ", 50=>"cincuenta y ", 60=>"sesenta y ", 70=>"setenta y ", 80=>"ochenta y ", 90=>"noventa y ");
        $centena           = array(100=>"cien", 200=>"doscientos", 300=>"trescientos", 400=>"cuantrocientos", 500=>"quinientos", 600=>"seiscientos", 700=>"setecientos", 800=>"ochocientos", 900=>"novecientos");   
        $prefijo_centena   = array(100=>"ciento ", 200=>"doscientos ", 300=>"trescientos ", 400=>"cuantrocientos ", 500=>"quinientos ", 600=>"seiscientos ", 700=>"setecientos ", 800=>"ochocientos ", 900=>"novecientos ");
        $sufijo_miles      = "mil";
        $sufijo_millon     = "un millon";
        $sufijo_millones   = "millones";
        
        $base         = strlen(strval($monto));
        $pren         = intval(floor($monto/pow(10,$base-1)));
        $prencentena  = intval(floor($monto/pow(10,3)));
        $prenmillar   = intval(floor($monto/pow(10,6)));
        $resto        = $monto%pow(10,$base-1);
        $restocentena = $monto%pow(10,3);
        $restomillar  = $monto%pow(10,6);
        
        if (!$monto) return "";
        
        if (is_int($monto) && $monto>0 && $monto < abs($maximo)) 
        {            
            switch ($base) {
                case 1: return $unidad[$monto];
                case 2: return array_key_exists($monto, $decena)  ? $decena[$monto]  : $prefijo_decena[$pren*10]   . $this->convertir_monto($resto);
                case 3: return array_key_exists($monto, $centena) ? $centena[$monto] : $prefijo_centena[$pren*100] . $this->convertir_monto($resto);
                case 4: case 5: case 6: return ($prencentena>1) ? $this->convertir_monto($prencentena). " ". $sufijo_miles . " " . $this->convertir_monto($restocentena) : $sufijo_miles. " " . $this->convertir_monto($restocentena);
                case 7: case 8: case 9: return ($prenmillar>1)  ? $this->convertir_monto($prenmillar). " ". $sufijo_millones . " " . $this->convertir_monto($restomillar)  : $sufijo_millon. " " . $this->convertir_monto($restomillar);
            }
        } else {
            return "ERROR con el numero - $monto<br/> Debe ser un numero entero menor que " . number_format($maximo, 0, ".", ",") . ".";
        }
        return "";
    }


}



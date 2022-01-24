<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Facturacion_impresion extends Error_views{

	function __construct(){
		parent::__construct();
		$this->load->helper("url"); 
		$this->load->model('mfacturacion');		
		$this->load->model('mfacturacion_impresion');
		//$this->load->library('pagination');
	}

    public function doc_pago_pdf($coddocpago)
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
            
            //$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [200,200],'orientation' => 'L']); 
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

            $mpdf->showWatermarkImage = true;

            $mpdf->SetTitle( "DP ".$pagos->pagante);
            
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath, "I");
            // $mpdf->Output();
        
    }

    public function doc_pago_imp($coddocpago)
    {
    	$dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        $coddocpago=base64url_decode($coddocpago);
        //$carne=base64url_decode($carne);

        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();
        
        $pagos=$this->mfacturacion_impresion->m_get_docpagos(array($coddocpago));
        $detalle = $this->mfacturacion_impresion->m_get_pagos_detalle(array($coddocpago));
        $idsede=$pagos->sedeid;
        $dtserie = $this->mfacturacion_impresion->m_get_docserie_sede_tipo(array($pagos->tdocid, $idsede,$pagos->serie));

            $mentero=intval($pagos->total);
            $montotexto=$this->convertir_monto($mentero);
            $dominio=str_replace(".", "_",getDominio());
            
            $html1=$this->load->view('facturacion/impresion/dc_bol_electronica_imp_'.$dominio.'_'.$dtserie->formato_imp, array('ies' => $ie,'pag' => $pagos,'detalle'=>$detalle, 'dserie'=>$dtserie,'mtexto'=>$montotexto),true);
             
            $pdfFilePath = "TICKET PAGO ".$pagos->pagante.".pdf";

            $this->load->library('M_pdf');
            // $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
            
            $formatoimp=$dtserie->formato_imp;
            if ($dtserie->formato_imp=="TK"){
                $formatoimp= [74, 256];   
            }
            else if ($dtserie->formato_imp=="A5P"){
                $formatoimp= "A4";   
            }
            else if ($dtserie->formato_imp=="A5"){
                $formatoimp= "A4";   
            }
            else if ($dtserie->formato_imp=="A5F"){
                $formatoimp= "A4";   
            }
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 
            $mpdf->showWatermarkImage = true;
            $mpdf->SetTitle( "TICKET PAGO ".$pagos->pagante);
            
            //$mpdf->SetWatermarkImage(base_url().'resources/img/matriculado_'.$dominio.'.png',0.6,"D",array(70,35));

            //$mpdf->showWatermarkImage  = true;
            

            //$mpdf->AddPage();
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath, "I");
            // $mpdf->Output();
        

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
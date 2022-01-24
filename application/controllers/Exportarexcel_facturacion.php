<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/phpexcel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
class Exportarexcel_facturacion extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
    //rp_documentospago_emitidos.xlsx
    public function rpsede_documentos_emitidos()
    {
        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");
        //$ei=$emision;
        //$ef=$emisionf;
        $this->load->model('mfacturacion_impresion');

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

        $a_estado=array();
        if (null !== $this->input->get("checkanulado")) {
            $a_estado[]="ANULADO";
        }
        if (null !== $this->input->get("checkenviado")) {
            $a_estado[]="ENVIADO";
        }
        if (null !== $this->input->get("checkrechazado")) {
            $a_estado[]="RECHAZADO";
        }
        if (null !== $this->input->get("checkerror")) {
            $a_estado[]="ERROR";
        }
        if (null !== $this->input->get("checkaceptado")) {
            $a_estado[]="ACEPTADO";
        }
        if (null !== $this->input->get("checkpendiente")) {
            $a_estado[]="PENDIENTE";
        }
        
        if (count($a_estado)==0){
            $a_estado[]="TODOS";
        }
        
        $rstdata = $this->mfacturacion_impresion->m_get_emitidos_filtro_xsede($_SESSION['userActivo']->idsede,$busqueda,$databuscar,$a_estado);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_documentospago_emitidos.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo_docpago');
        $drawing->setDescription('logo_docpago');
        $drawing->setPath('resources/img/logo_facturacion.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('A1');
        $colWidth = $sheet->getColumnDimension('A')->getWidth() +$sheet->getColumnDimension('B')->getWidth() +$sheet->getColumnDimension('C')->getWidth() ;
        if ($colWidth == -1) { //not defined which means we have the standard width
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        //$offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        //$drawing->setOffsetX($offsetX); //p
        $drawing->setWidth($colWidthPixels);

        //$drawing->setHeight(75);
        
        $drawing->setWorksheet($sheet);


        $sheet->setCellValue("A4", "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
        $sheet->setCellValue('B5', $_SESSION['userActivo']->sede);
        $sheet->setCellValue('G1', date("d/m/Y"));
        $sheet->setCellValue('G2', date("h:i:s"));
        $fila=6;
        $nro=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;
        foreach ($rstdata as $mat) {
            $nro++;
            $fila++;
            $vestado="";
            if ($mat->estado=="ANULADO"){
                $mat->total=0;
                $mat->efectivo=0;
                $mat->banco=0;
                $vestado="AN";
            }
            $sheet->setCellValue('A'.$fila, $nro);
            $sheet->setCellValue('B'.$fila, $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT));
            $sheet->setCellValue('C'.$fila, $mat->pagantenrodoc);
            $sheet->setCellValue('D'.$fila, $mat->pagante);
            $sheet->setCellValue('E'.$fila, $vestado);
            $sheet->setCellValue('F'.$fila, date_format(date_create($mat->fecha_hora),"d/m/Y"));
            $sheet->setCellValue('G'.$fila, $mat->total);
            //$sheet->getStyle('E'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
            $mtotal=$mtotal +  $mat->total;
            $mefectivo=$mefectivo + $mat->efectivo;
            $mbanco=$mbanco + $mat->banco;
            
        }
        $sheet->getStyle('A7:G'.$fila)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $fila++;
        $fila++;
        $sheet->getStyle("D".$fila.":G".($fila + 3))->getFont()->setBold(true);
        $sheet->getStyle("D".$fila.":G".($fila + 3))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Total Emitido");
        $sheet->setCellValue('G'.($fila ), $mtotal);
        $fila++;
        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Total Efectivo");
        $sheet->setCellValue('G'.($fila), $mefectivo);
        $fila++;
        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Total Banco");
        $sheet->setCellValue('G'.($fila), $mbanco);
        $fila++;
        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Otros Doc. Valor");
        $sheet->setCellValue('G'.($fila), $mtotal - ($mefectivo + $mbanco));
        $writer = new Xlsx($spreadsheet);
        
        
        $filename = $_SESSION['userActivo']->sede.' Documentos Emitidos';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function rpsede_documentos_detalle_mediodpago()
    {
        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");
        //$ei=$emision;
        //$ef=$emisionf;
        $this->load->model('mfacturacion_impresion');

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
        $a_estado=array();
        if (null !== $this->input->get("checkanulado")) {
            $a_estado[]="ANULADO";
        }
        if (null !== $this->input->get("checkenviado")) {
            $a_estado[]="ENVIADO";
        }
        if (null !== $this->input->get("checkrechazado")) {
            $a_estado[]="RECHAZADO";
        }
        if (null !== $this->input->get("checkerror")) {
            $a_estado[]="ERROR";
        }
        if (null !== $this->input->get("checkaceptado")) {
            $a_estado[]="ACEPTADO";
        }
        if (null !== $this->input->get("checkpendiente")) {
            $a_estado[]="PENDIENTE";
        }
        
        if (count($a_estado)==0){
            $a_estado[]="TODOS";
        }
        
        $rstdata = $this->mfacturacion_impresion->m_get_emitidos_filtro_xsede_medio_pago($_SESSION['userActivo']->idsede,$busqueda,$databuscar,$a_estado);

        

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_documentospago_emitidos_mediospago.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo_docpago');
        $drawing->setDescription('logo_docpago');
        $drawing->setPath('resources/img/logo_facturacion.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('A1');
        $colWidth = $sheet->getColumnDimension('A')->getWidth() +$sheet->getColumnDimension('B')->getWidth() +$sheet->getColumnDimension('C')->getWidth() ;
        if ($colWidth == -1) { //not defined which means we have the standard width
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        //$offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        //$drawing->setOffsetX($offsetX); //p
        $drawing->setWidth($colWidthPixels);

        //$drawing->setHeight(75);
        
        $drawing->setWorksheet($sheet);


        $sheet->setCellValue("A4", "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
        $sheet->setCellValue('B5', $_SESSION['userActivo']->sede);
        $sheet->setCellValue('K1', date("d/m/Y"));
        $sheet->setCellValue('K2', date("h:i:s"));
        $fila=6;
        $nro=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;
        $vdocpagos=$rstdata['docpagos'];
        $vdmp=$rstdata['docpagosmedios'];
        foreach ($vdocpagos as $kdoc => $mat) {
            if (($mat->tipodoc=="FC") || ($mat->tipodoc=="BL")){
                $nro++;
                $fila++;
                $vestado="";
                if ($mat->estado=="ANULADO"){
                    $mat->total=0;
                    $mat->efectivo=0;
                    $mat->banco=0;
                    $vestado="AN";
                }
                $sheet->setCellValue('A'.$fila, $nro);
                $sheet->setCellValue('B'.$fila, $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT));
                $sheet->setCellValue('C'.$fila, $vestado);
                $sheet->setCellValue('D'.$fila, $mat->pagantenrodoc);
                $sheet->setCellValue('E'.$fila, $mat->pagante);

               /* $vmedios="";
                $vvaucher="";
                $vmonto="";*/
                $nmedios=0;
                foreach ($vdmp as $km => $mp) {
                    if ($mat->codigo==$mp->codigo){
                            $sheet->setCellValue('F'.($fila + $nmedios), ($mp->codmedio==2)?$mp->banco:$mp->medio);
                            $sheet->setCellValue('G'.($fila + $nmedios), date_format(date_create($mp->fecha),"d/m/Y h:i a"));
                            $sheet->setCellValue('H'.($fila + $nmedios), $mp->operacion);
                            $sheet->setCellValue('I'.($fila + $nmedios), $mp->monto);
                            unset($vdmp[$km]);
                            $nmedios++;;
                    }
                }
                
                $sheet->setCellValue('J'.$fila, date_format(date_create($mat->fecha_hora),"d/m/Y"));
                $sheet->setCellValue('K'.$fila, $mat->total);
                //$sheet->getStyle('E'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
                $mtotal=$mtotal +  $mat->total;
                $mefectivo=$mefectivo + $mat->efectivo;
                $mbanco=$mbanco + $mat->banco;
                if ($nmedios>0){
                    $fila=$fila + ($nmedios - 1);    
                }
                unset($vdocpagos[$kdoc]);
           } 
        }
        $sheet->getStyle('A7:K'.$fila)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $fila++;
        $fila++;
        $sheet->getStyle("F".$fila.":K".($fila + 3))->getFont()->setBold(true);
        $sheet->getStyle("F".$fila.":K".($fila + 3))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells("F$fila:J$fila");
        $sheet->setCellValue('F'.($fila), "Total Emitido");
        $sheet->setCellValue('K'.($fila ), $mtotal);
        $fila++;
        $sheet->mergeCells("F$fila:J$fila");
        $sheet->setCellValue('F'.($fila), "Total Efectivo");
        $sheet->setCellValue('K'.($fila), $mefectivo);
        $fila++;
        $sheet->mergeCells("F$fila:J$fila");
        $sheet->setCellValue('F'.($fila), "Total Banco");
        $sheet->setCellValue('K'.($fila), $mbanco);
        $fila++;
        $sheet->mergeCells("F$fila:J$fila");
        $sheet->setCellValue('F'.($fila), "Otros Doc. Valor");
        $sheet->setCellValue('K'.($fila), $mtotal - ($mefectivo + $mbanco));

        //NOTAS DE CREDITO
        //////////////////////
        /////////////////////
        if (count($vdocpagos)>0){
            $fila=$fila + 2;
            $sheet->mergeCells("A$fila:K$fila");
            $sheet->setCellValue("A".$fila, "NOTAS DE CRÉDITO EMITIDAS");
            $sheet->getStyle("A$fila")->getFont()->setBold(true);
            $sheet->getStyle("A$fila")->getFont()->setSize(12);
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal('center');
            $fila=$fila + 1;
            $sheet->mergeCells("A$fila:K$fila");
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal('center');
            $sheet->setCellValue("A".$fila, "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
            $fila=$fila + 1;
            $sheet->getStyle("A$fila".":"."B$fila")->getFont()->setBold(true);
            $sheet->setCellValue('A'.$fila, "FILIAL");
            $sheet->setCellValue('B'.$fila, $_SESSION['userActivo']->sede);
            
            $nro=0;
            $mtotal=0;
            
            $filaini=$fila + 1;
            foreach ($vdocpagos as $kdoc => $mat) {
                if (($mat->tipodoc=="NF") || ($mat->tipodoc=="NB")){
                    $nro++;
                    $fila++;
                    $vestado="";
                    if ($mat->estado=="ANULADO"){
                        $mat->total=0;
                        $mat->efectivo=0;
                        $mat->banco=0;
                        $vestado="AN";
                    }
                    $sheet->setCellValue('A'.$fila, $nro);
                    $sheet->setCellValue('B'.$fila, $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT));
                    $sheet->setCellValue('C'.$fila, $vestado);
                    $sheet->setCellValue('D'.$fila, $mat->pagantenrodoc);
                    $sheet->setCellValue('E'.$fila, $mat->pagante);

                   /* $vmedios="";
                    $vvaucher="";
                    $vmonto="";*/
                    $nmedios=0;
                    foreach ($vdmp as $km => $mp) {
                        if ($mat->codigo==$mp->codigo){
                                $sheet->setCellValue('F'.($fila + $nmedios), ($mp->codmedio==2)?$mp->banco:$mp->medio);
                                $sheet->setCellValue('G'.($fila + $nmedios), date_format(date_create($mp->fecha),"d/m/Y h:i a"));
                                $sheet->setCellValue('H'.($fila + $nmedios), $mp->operacion);
                                $sheet->setCellValue('I'.($fila + $nmedios), $mp->monto);
                                unset($vdmp[$km]);
                                $nmedios++;;
                        }
                    }
                    
                    $sheet->setCellValue('J'.$fila, date_format(date_create($mat->fecha_hora),"d/m/Y"));
                    $sheet->setCellValue('K'.$fila, $mat->total);
                    //$sheet->getStyle('E'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
                    $mtotal=$mtotal +  $mat->total;
                    $mefectivo=$mefectivo + $mat->efectivo;
                    $mbanco=$mbanco + $mat->banco;
                    if ($nmedios>0){
                        $fila=$fila + ($nmedios - 1);    
                    }
                    unset($vdocpagos[$kdoc]);
               } 
            }
            $sheet->getStyle('A'.$filaini.':K'.$fila)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $fila++;
            $fila++;
            $sheet->getStyle("F".$fila.":K".($fila))->getFont()->setBold(true);
            $sheet->getStyle("F".$fila.":K".($fila))
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("F$fila:J$fila");
            $sheet->setCellValue('F'.($fila), "Total Emitido");
            $sheet->setCellValue('K'.($fila ), $mtotal);
        }
        
        $writer = new Xlsx($spreadsheet);
        
        
        $filename = $_SESSION['userActivo']->sede.' Documentos Emitidos - Medio Pago';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }


    public function rpsede_docemitidos_detalle_concepto()
    {
        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");

        $this->load->model('mfacturacion_impresion');

        $databuscar=array();

        if ($emision != "" && $emisionf != "") {
            $horaini = ' 00:00:01';
            $horafin = ' 23:59:59';
            $databuscar[]=$emision.$horaini;
            $databuscar[]=$emisionf.$horafin;
        }
        elseif ($emision == "" && $emisionf == "") {

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

        $a_estado=array();
        if (null !== $this->input->get("checkanulado")) {
            $a_estado[]="ANULADO";
        }
        if (null !== $this->input->get("checkenviado")) {
            $a_estado[]="ENVIADO";
        }
        if (null !== $this->input->get("checkrechazado")) {
            $a_estado[]="RECHAZADO";
        }
        if (null !== $this->input->get("checkerror")) {
            $a_estado[]="ERROR";
        }
        if (null !== $this->input->get("checkaceptado")) {
            $a_estado[]="ACEPTADO";
        }
        if (null !== $this->input->get("checkpendiente")) {
            $a_estado[]="PENDIENTE";
        }
        
        if (count($a_estado)==0){
            $a_estado[]="TODOS";
        }
        
        $rstdata = $this->mfacturacion_impresion->m_get_emitidos_filtro_xsede($_SESSION['userActivo']->idsede,$busqueda,$databuscar,$a_estado);
        $detalle = $this->mfacturacion_impresion->m_get_pagos_detalle_sede();
        

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_documentospago_emitidos.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo_docpago');
        $drawing->setDescription('logo_docpago');
        $drawing->setPath('resources/img/logo_facturacion.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('A1');
        $colWidth = $sheet->getColumnDimension('A')->getWidth() +$sheet->getColumnDimension('B')->getWidth() +$sheet->getColumnDimension('C')->getWidth() ;
        if ($colWidth == -1) { //not defined which means we have the standard width
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        //$offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        //$drawing->setOffsetX($offsetX); //p
        $drawing->setWidth($colWidthPixels);

        //$drawing->setHeight(75);
        
        $drawing->setWorksheet($sheet);


        $sheet->setCellValue("A4", "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
        $sheet->setCellValue('B5', $_SESSION['userActivo']->sede);
        $sheet->setCellValue('G1', date("d/m/Y"));
        $sheet->setCellValue('G2', date("h:i:s"));
        $fila=6;
        $fila2=0;
        $nro=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;
        foreach ($rstdata as $mat) {
            $nro++;
            $fila++;
            $vestado="";
            if ($mat->estado=="ANULADO"){
                $mat->total=0;
                $mat->efectivo=0;
                $mat->banco=0;
                $vestado="AN";
            }
            $sheet->setCellValue('A'.$fila, $nro);
            $sheet->setCellValue('B'.$fila, $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT));
            $sheet->setCellValue('C'.$fila, $mat->pagantenrodoc);
            $sheet->setCellValue('D'.$fila, $mat->pagante);
            $sheet->setCellValue('E'.$fila, $vestado);
            $sheet->setCellValue('F'.$fila, date_format(date_create($mat->fecha_hora),"d/m/Y"));
            $sheet->setCellValue('G'.$fila, $mat->total);

            foreach ($detalle as $key => $value) {
                if ($value->iddocp == $mat->codigo) {
                    $fila2 = $fila+1;
                    if ($mat->estado=="ANULADO"){
                        $value->mpunit=0;
                    }
                    $sheet->setCellValue('A'.$fila2, "");
                    $sheet->setCellValue('B'.$fila2, $value->cantidad);
                    $sheet->setCellValue('C'.$fila2, $value->gestid);
                    $sheet->setCellValue('D'.$fila2, $value->gestion);
                    $sheet->setCellValue('E'.$fila2, "");
                    $sheet->setCellValue('F'.$fila2, number_format($value->mpunit, 2, '.', ''));
                    $fila = $fila2;
                }
            }

            //$sheet->getStyle('E'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
            $mtotal=$mtotal +  $mat->total;
            $mefectivo=$mefectivo + $mat->efectivo;
            $mbanco=$mbanco + $mat->banco;
            
        }
        $sheet->getStyle('A7:G'.$fila)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $fila++;
        $fila++;
        $sheet->getStyle("D".$fila.":G".($fila + 3))->getFont()->setBold(true);
        $sheet->getStyle("D".$fila.":G".($fila + 3))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Total Emitido");
        $sheet->setCellValue('G'.($fila ), $mtotal);
        $fila++;
        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Total Efectivo");
        $sheet->setCellValue('G'.($fila), $mefectivo);
        $fila++;
        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Total Banco");
        $sheet->setCellValue('G'.($fila), $mbanco);
        $fila++;
        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Otros Doc. Valor");
        $sheet->setCellValue('G'.($fila), $mtotal - ($mefectivo + $mbanco));
        $writer = new Xlsx($spreadsheet);
        
        
        $filename = $_SESSION['userActivo']->sede.' Documentos Emitidos - Conceptos';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    
public function rpsede_documentos_emitidos_items()
    {
        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $concepto=$this->input->get("ct");
        
        $this->load->model('mfacturacion_impresion');

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
        
        $rstdata = $this->mfacturacion_impresion->m_get_emitidositems_filtro_xsede($_SESSION['userActivo']->idsede,$concepto,$databuscar);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_documentospago_emitidos_items.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo_docpago');
        $drawing->setDescription('logo_docpago');
        $drawing->setPath('resources/img/logo_facturacion.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('A1');
        $colWidth = $sheet->getColumnDimension('A')->getWidth() +$sheet->getColumnDimension('B')->getWidth() +$sheet->getColumnDimension('C')->getWidth() ;
        if ($colWidth == -1) { //not defined which means we have the standard width
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        //$offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        //$drawing->setOffsetX($offsetX); //p
        $drawing->setWidth($colWidthPixels);

        //$drawing->setHeight(75);
        
        $drawing->setWorksheet($sheet);


        $sheet->setCellValue("A4", "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
        $sheet->setCellValue('B5', $_SESSION['userActivo']->sede);
        $sheet->setCellValue('G1', date("d/m/Y"));
        $sheet->setCellValue('G2', date("h:i:s"));
        $fila=6;
        $nro=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;
        foreach ($rstdata as $mat) {
            $nro++;
            $fila++;
            $vestado="";
            if ($mat->estado=="ANULADO"){
                $mat->total=0;
                $mat->efectivo=0;
                $mat->banco=0;
                $vestado="AN";
            }
            $sheet->setCellValue('A'.$fila, $nro);
            $sheet->setCellValue('B'.$fila, $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT));
            $sheet->setCellValue('C'.$fila, $mat->codpagante);
            $sheet->setCellValue('D'.$fila, $mat->pagante);
            $sheet->setCellValue('E'.$fila, $vestado);
            $sheet->setCellValue('F'.$fila, date_format(date_create($mat->fecha_hora),"d/m/Y"));
            $sheet->setCellValue('G'.$fila, $mat->gestion);
            $sheet->setCellValue('H'.$fila, $mat->observacion);
            $sheet->setCellValue('I'.$fila, $mat->punit);
            $sheet->setCellValue('J'.$fila, $mat->carrera);
            $sheet->setCellValue('K'.$fila, $mat->periodo);
            $sheet->setCellValue('L'.$fila, $mat->ciclo);
            
            $mtotal=$mtotal +  $mat->punit;
        }
        
        $sheet->getStyle('A7:L'.$fila)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $fila++;
        $fila++;
        $sheet->getStyle("D".$fila.":G".($fila))->getFont()->setBold(true);
        $sheet->getStyle("D".$fila.":G".($fila))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Total Emitido");
        $sheet->setCellValue('G'.($fila ), $mtotal);
        
        $writer = new Xlsx($spreadsheet);
        
        
        $filename = $_SESSION['userActivo']->sede.' Documentos Emitidos por Conceptos';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function rpsede_documentos_emitidos_filtro_items()
    {
        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $concepto=$this->input->get("ct");
        
        $this->load->model('mfacturacion_impresion');

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
        
        $rstdata = $this->mfacturacion_impresion->m_get_emitidositems_filtro_xsede($_SESSION['userActivo']->idsede,$concepto,$databuscar);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_documentospago_emitidos_items.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo_docpago');
        $drawing->setDescription('logo_docpago');
        $drawing->setPath('resources/img/logo_facturacion.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('A1');
        $colWidth = $sheet->getColumnDimension('A')->getWidth() +$sheet->getColumnDimension('B')->getWidth() +$sheet->getColumnDimension('C')->getWidth() ;
        if ($colWidth == -1) { //not defined which means we have the standard width
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        //$offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        //$drawing->setOffsetX($offsetX); //p
        $drawing->setWidth($colWidthPixels);

        //$drawing->setHeight(75);
        
        $drawing->setWorksheet($sheet);


        $sheet->setCellValue("A4", "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
        $sheet->setCellValue('B5', $_SESSION['userActivo']->sede);
        $sheet->setCellValue('G1', date("d/m/Y"));
        $sheet->setCellValue('G2', date("h:i:s"));
        $fila=6;
        $nro=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;
        foreach ($rstdata as $mat) {
            $nro++;
            $fila++;
            $vestado="";
            if ($mat->estado=="ANULADO"){
                $mat->total=0;
                $mat->efectivo=0;
                $mat->banco=0;
                $vestado="AN";
            }
            $sheet->setCellValue('A'.$fila, $nro);
            $sheet->setCellValue('B'.$fila, $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT));
            $sheet->setCellValue('C'.$fila, $mat->codpagante);
            $sheet->setCellValue('D'.$fila, $mat->pagante);
            $sheet->setCellValue('E'.$fila, $vestado);
            $sheet->setCellValue('F'.$fila, date_format(date_create($mat->fecha_hora),"d/m/Y"));
            $sheet->setCellValue('G'.$fila, $mat->gestion);
            $sheet->setCellValue('H'.$fila, $mat->observacion);
            $sheet->setCellValue('I'.$fila, $mat->punit);
            $sheet->setCellValue('J'.$fila, $mat->carrera);
            $sheet->setCellValue('K'.$fila, $mat->periodo);
            $sheet->setCellValue('L'.$fila, $mat->ciclo);
            
            $mtotal=$mtotal +  $mat->punit;
        }
        
        $sheet->getStyle('A7:L'.$fila)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $fila++;
        $fila++;
        $sheet->getStyle("D".$fila.":G".($fila))->getFont()->setBold(true);
        $sheet->getStyle("D".$fila.":G".($fila))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells("D$fila:F$fila");
        $sheet->setCellValue('D'.($fila), "Total Emitido");
        $sheet->setCellValue('G'.($fila ), $mtotal);
        
        $writer = new Xlsx($spreadsheet);
        
        
        $filename = $_SESSION['userActivo']->sede.' Documentos Emitidos por Conceptos';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }



    public function rpsede_documentos_emitidos_cuadro_x_conceptos()
    {
        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");
        //$ei=$emision;
        //$ef=$emisionf;
        $this->load->model('mfacturacion_impresion');
        $this->load->model('mgestion');
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

        $a_estado=array();
        if (null !== $this->input->get("checkanulado")) {
            $a_estado[]="ANULADO";
        }
        if (null !== $this->input->get("checkenviado")) {
            $a_estado[]="ENVIADO";
        }
        if (null !== $this->input->get("checkrechazado")) {
            $a_estado[]="RECHAZADO";
        }
        if (null !== $this->input->get("checkerror")) {
            $a_estado[]="ERROR";
        }
        if (null !== $this->input->get("checkaceptado")) {
            $a_estado[]="ACEPTADO";
        }
        if (null !== $this->input->get("checkpendiente")) {
            $a_estado[]="PENDIENTE";
        }
        
        if (count($a_estado)==0){
            $a_estado[]="TODOS";
        }
        
        $rstdata = $this->mfacturacion_impresion->m_get_emitidos_filtro_xsede($_SESSION['userActivo']->idsede,$busqueda,$databuscar,$a_estado);
        $rstdata_conceptos = $this->mfacturacion_impresion->m_get_emitidos_filtro_xsede_cuadro_conceptos($_SESSION['userActivo']->idsede,$busqueda,$databuscar,$a_estado);
        $rstdata_gestion=$this->mgestion->m_get_gestion();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_documentospago_emitidos_cuadroporconceptos.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo_docpago');
        $drawing->setDescription('logo_docpago');
        $drawing->setPath('resources/img/logo_facturacion.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('A1');
        $colWidth = $sheet->getColumnDimension('A')->getWidth() +$sheet->getColumnDimension('B')->getWidth() +$sheet->getColumnDimension('C')->getWidth() ;
        if ($colWidth == -1) { //not defined which means we have the standard width
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        //$offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        //$drawing->setOffsetX($offsetX); //p
        $drawing->setWidth($colWidthPixels);

        //$drawing->setHeight(75);
        
        $drawing->setWorksheet($sheet);


        $sheet->setCellValue("A4", "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
        $sheet->setCellValue('B5', $_SESSION['userActivo']->sede);
        $sheet->setCellValue('G1', date("d/m/Y"));
        $sheet->setCellValue('G2', date("h:i:s"));
        $fila=6;
        $nro=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;
        $ncol=7;

        foreach ($rstdata_conceptos as $key => $concepto) {
             $a_conceptos[$concepto->codgestion]=array();
        }

        foreach ($rstdata_gestion as $key => $cc) {
            if (isset($a_conceptos[$cc->codigo])){
                $a_conceptos[$cc->codigo]['nombre']=$cc->nombre;
                $a_conceptos[$cc->codigo]['monto']=0;
                $a_conceptos[$cc->codigo]['col']=$ncol;
                $sheet->setCellValueByColumnAndRow($ncol,6, $cc->nombre);
                $ncol++;
            }

            
        }
        // BOLETAS Y FACTURAS

        foreach ($rstdata as $kdoc => $mat) {
            if (($mat->tipodoc=="FC") || ($mat->tipodoc=="BL")){
                $nro++;
                $fila++;
                $vestado="";
                if ($mat->estado=="ANULADO"){
                    $mat->total=0;
                    $mat->efectivo=0;
                    $mat->banco=0;
                    $vestado="AN";
                }
                $sheet->setCellValue('A'.$fila, $nro);
                $sheet->setCellValue('B'.$fila, $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT));
                $sheet->setCellValue('C'.$fila, $mat->pagantenrodoc);
                $sheet->setCellValue('D'.$fila, $mat->pagante);
                $sheet->setCellValue('E'.$fila, $vestado);
                $sheet->setCellValue('F'.$fila, date_format(date_create($mat->fecha_hora),"d/m/Y"));
               
                foreach ($rstdata_conceptos as $key => $concepto) {
                    if ($mat->codigo==$concepto->codigo){
                        if (isset($a_conceptos[$concepto->codgestion]['col'])){
                            if ($mat->estado=="ANULADO"){
                               $concepto->monto=0;
                            }
                            $sheet->setCellValueByColumnAndRow($a_conceptos[$concepto->codgestion]['col'],$fila, $concepto->monto);
                            $a_conceptos[$concepto->codgestion]['monto']=$a_conceptos[$concepto->codgestion]['monto'] + $concepto->monto;
                        }
                    }
                }


                 $sheet->setCellValueByColumnAndRow($ncol,$fila, $mat->total);
                $mtotal=$mtotal +  $mat->total;
                $mefectivo=$mefectivo + $mat->efectivo;
                $mbanco=$mbanco + $mat->banco;
                unset($rstdata[$kdoc]);
            }
        }
        


        
        $sheet->setCellValueByColumnAndRow($ncol,6, "TOTAL");

        $fila++;
        foreach ($a_conceptos as $key => $cc) {
            if (isset($cc['col'])){
                $sheet->setCellValueByColumnAndRow($cc['col'],$fila, $cc['monto']);
            }
        }

        $sheet->setCellValueByColumnAndRow($ncol,$fila, $mtotal);
        $columnf = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($ncol);
        $sheet->getStyle("G".$fila.":".$columnf.$fila)->getFont()->setBold(true);
        $sheet->getStyle($columnf."6:".$columnf.$fila)->getFont()->setBold(true);
        $sheet->getStyle('A6:'.$columnf.$fila)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $fila++;
        $fila++;
        $sheet->getStyle("D".$fila.":F".($fila + 3))->getFont()->setBold(true);
        $sheet->getStyle("D".$fila.":F".($fila + 3))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells("D$fila:E$fila");
        $sheet->setCellValue('D'.($fila), "Total Emitido");
        $sheet->setCellValue('F'.($fila ), $mtotal);
        $fila++;
        $sheet->mergeCells("D$fila:E$fila");
        $sheet->setCellValue('D'.($fila), "Total Efectivo");
        $sheet->setCellValue('F'.($fila), $mefectivo);
        $fila++;
        $sheet->mergeCells("D$fila:E$fila");
        $sheet->setCellValue('D'.($fila), "Total Banco");
        $sheet->setCellValue('F'.($fila), $mbanco);
        $fila++;
        $sheet->mergeCells("D$fila:E$fila");
        $sheet->setCellValue('D'.($fila), "Otros Doc. Valor");
        $sheet->setCellValue('F'.($fila), $mtotal - ($mefectivo + $mbanco));


        //NOTAS DE CREDITO Y DEBITO

        foreach ($rstdata_conceptos as $key => $concepto) {
             $a_conceptos[$concepto->codgestion]['monto']=0;
        }

        $nro=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;
        $fila=$fila + 3;
            $sheet->mergeCells("A$fila:K$fila");
            $sheet->setCellValue("A".$fila, "NOTAS DE CRÉDITO EMITIDAS");
            $sheet->getStyle("A$fila")->getFont()->setBold(true);
            $sheet->getStyle("A$fila")->getFont()->setSize(12);
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal('center');
            $fila=$fila + 1;
            $sheet->mergeCells("A$fila:K$fila");
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal('center');
            $sheet->setCellValue("A".$fila, "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
            $fila=$fila + 1;
            $sheet->getStyle("A$fila".":"."B$fila")->getFont()->setBold(true);
            $sheet->setCellValue('A'.$fila, "FILIAL");
            $sheet->setCellValue('B'.$fila, $_SESSION['userActivo']->sede);
            $filanota=$fila + 1;
        foreach ($rstdata as $mat) {
            $nro++;
            $fila++;
            $vestado="";
            if ($mat->estado=="ANULADO"){
                $mat->total=0;
                $mat->efectivo=0;
                $mat->banco=0;
                $vestado="AN";
            }
            $sheet->setCellValue('A'.$fila, $nro);
            $sheet->setCellValue('B'.$fila, $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT));
            $sheet->setCellValue('C'.$fila, $mat->pagantenrodoc);
            $sheet->setCellValue('D'.$fila, $mat->pagante);
            $sheet->setCellValue('E'.$fila, $vestado);
            $sheet->setCellValue('F'.$fila, date_format(date_create($mat->fecha_hora),"d/m/Y"));
           
            foreach ($rstdata_conceptos as $key => $concepto) {
                if ($mat->codigo==$concepto->codigo){
                    if (isset($a_conceptos[$concepto->codgestion]['col'])){
                        if ($mat->estado=="ANULADO"){
                           $concepto->monto=0;
                        }
                        $sheet->setCellValueByColumnAndRow($a_conceptos[$concepto->codgestion]['col'],$fila, $concepto->monto);
                        $a_conceptos[$concepto->codgestion]['monto']=$a_conceptos[$concepto->codgestion]['monto'] + $concepto->monto;
                    }
                }
            }


             $sheet->setCellValueByColumnAndRow($ncol,$fila, $mat->total);
            $mtotal=$mtotal +  $mat->total;
            $mefectivo=$mefectivo + $mat->efectivo;
            $mbanco=$mbanco + $mat->banco;
        }
        


        
        $sheet->setCellValueByColumnAndRow($ncol,6, "TOTAL");

        $fila++;
        foreach ($a_conceptos as $key => $cc) {
            if (isset($cc['col'])){
                $sheet->setCellValueByColumnAndRow($cc['col'],$fila, $cc['monto']);
            }
        }



        $sheet->setCellValueByColumnAndRow($ncol,$fila, $mtotal);
        $columnf = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($ncol);
        $sheet->getStyle("G".$fila.":".$columnf.$fila)->getFont()->setBold(true);
        $sheet->getStyle($columnf."6:".$columnf.$fila)->getFont()->setBold(true);
        $sheet->getStyle('A'.$filanota.':'.$columnf.$fila)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $fila++;
        $fila++;
        $sheet->getStyle("D".$fila.":F".($fila + 3))->getFont()->setBold(true);
        $sheet->getStyle("D".$fila.":F".($fila + 3))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->mergeCells("D$fila:E$fila");
        $sheet->setCellValue('D'.($fila), "Total Emitido");
        $sheet->setCellValue('F'.($fila ), $mtotal);
        $fila++;
        $sheet->mergeCells("D$fila:E$fila");
        $sheet->setCellValue('D'.($fila), "Total Efectivo");
        $sheet->setCellValue('F'.($fila), $mefectivo);
        $fila++;
        $sheet->mergeCells("D$fila:E$fila");
        $sheet->setCellValue('D'.($fila), "Total Banco");
        $sheet->setCellValue('F'.($fila), $mbanco);
        $fila++;
        $sheet->mergeCells("D$fila:E$fila");
        $sheet->setCellValue('D'.($fila), "Otros Doc. Valor");
        $sheet->setCellValue('F'.($fila), $mtotal - ($mefectivo + $mbanco));











        $writer = new Xlsx($spreadsheet);
        
        
        $filename = $_SESSION['userActivo']->sede.' Documentos Emitidos';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }


public function rp_deudas_estudiante_individual_excel()
    {
        date_default_timezone_set('America/Lima');

        $fecha = date('d/m/Y');
        $tipo = $this->input->get("tp");
        $documento = $this->input->get("nro");
        $this->load->model('malumno');
        $rstdata = $this->malumno->mget_deudas_xestudiante(array($tipo,$documento));

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_deudas_estudiantes.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo_docpago');
        $drawing->setDescription('logo_docpago');
        $drawing->setPath('resources/img/logo_facturacion.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('A1');
        $colWidth = $sheet->getColumnDimension('A')->getWidth() +$sheet->getColumnDimension('B')->getWidth();
        if ($colWidth == -1) { //not defined which means we have the standard width
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        //$offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        //$drawing->setOffsetX($offsetX); //p
        $drawing->setWidth($colWidthPixels);

        //$drawing->setHeight(75);
        
        $drawing->setWorksheet($sheet);

        
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        $sheet->setCellValue('G1', date("d/m/Y"));
        $sheet->setCellValue('G2', date("h:i:s"));
        $fila=4;
        $nro=0;
        $mtotal=0;
        $grupo = "";
        $final = 0;
        foreach ($rstdata as $doc) {
            $datemis =  new DateTime($doc->fvence);
            $vence = $datemis->format('d/m/Y');
            $vmonto=number_format($doc->monto, 2);
            $vsaldo=number_format($doc->saldo, 2);

            $agrupacion = $doc->dni.$doc->nombres.$doc->carrera;
            if ($agrupacion != $grupo) {

                // $mtotal=0;
                $grupo = $agrupacion;
                $nro = 0;
                $fila++;

                $sheet->getRowDimension($fila)->setRowHeight(36);
                $sheet->getStyle("A".$fila.":A".$fila)->getFont()->setBold(true);
                $sheet->setCellValue('A'.$fila, "ESTUDIANTE:");
                $styletextal= array(
                    'font' => array('size' => 9),
                    'alignment' => array('horizontal' => "center",'vertical' => "center",'wrapText' => "center")
                );
                $sheet->getStyleByColumnAndRow(1, $fila)->applyFromArray($styletextal);
                
                $sheet->mergeCells("B".$fila.":C".$fila);
                $sheet->setCellValue('B'.$fila, $doc->dni." - ".$doc->nombres);
                $styletextnal= array(
                    'font' => array('size' => 9),
                    'alignment' => array('horizontal' => "left",'vertical' => "center",'wrapText' => "center")
                );
                $sheet->getStyleByColumnAndRow(2, $fila)->applyFromArray($styletextnal);

                $sheet->getStyle("D".$fila.":D".$fila)->getFont()->setBold(true);
                $sheet->setCellValue('D'.$fila, "PROGRAMA:");
                $styletextpg= array(
                    'font' => array('size' => 9),
                    'alignment' => array('horizontal' => "right",'vertical' => "center",'wrapText' => "center")
                );
                $sheet->getStyleByColumnAndRow(4, $fila)->applyFromArray($styletextpg);
                
                $sheet->mergeCells("E".$fila.":G".$fila);
                $sheet->setCellValue('E'.$fila, $doc->carrera);
                $styletextnpg= array(
                    'font' => array('size' => 9),
                    'alignment' => array('horizontal' => "center",'vertical' => "center",'wrapText' => "center")
                );
                $sheet->getStyleByColumnAndRow(5, $fila)->applyFromArray($styletextnpg);

                $fila++;

                
                $sheet->setCellValue('A'.$fila, "N°");
                $sheet->setCellValue('B'.$fila, "PER./SEM.");
                $sheet->mergeCells("C".$fila.":D".$fila);
                $sheet->setCellValue('C'.$fila, "CONCEPTO");
                $sheet->setCellValue('E'.$fila, "VENCE");
                $sheet->setCellValue('F'.$fila, "MONTO");
                $sheet->setCellValue('G'.$fila, "SALDO");
                $sheet->getStyle("A".$fila.":G".$fila)->getFont()->setBold(true);
                $sheet->getStyle("A".$fila.":G".$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("A".$fila.":G".$fila)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('F2F3F4');
                
            }
            $nro++;
            $fila++;

            // $mtotal=$mtotal +  $doc->monto;

            $sheet->getStyle("A".$fila.":G".$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            
            $sheet->getStyle("A".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('A'.$fila, $nro);

            $sheet->getStyle("B".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B'.$fila, $doc->codperiodo." / ".$doc->ciclo);

            $sheet->mergeCells("C".$fila.":D".$fila);
            $sheet->setCellValue('C'.$fila, $doc->gestion);

            $sheet->getStyle("E".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E'.$fila, $vence);

            $sheet->getStyle("F".$fila)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('F'.$fila)->getNumberFormat()->setFormatCode("(* #,##0.00);(* \(#,##0.00\);(* \"-\"??);(@_)");
            $sheet->setCellValue('F'.$fila, round($doc->monto,2));

            $sheet->getStyle("G".$fila)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('G'.$fila)->getNumberFormat()->setFormatCode("(* #,##0.00);(* \(#,##0.00\);(* \"-\"??);(@_)");
            $sheet->setCellValue('G'.$fila, round($doc->saldo,2));
            
            $final = $fila;
        }
        
        
        $writer = new Xlsx($spreadsheet);
        
        $filename = 'Deudas pendientes';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }
    
    public function rp_estado_cuenta_individual_excel()
    {
        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $documento=$this->input->get("pg");

        $this->load->model('mfacturacion_impresion');

        $databuscar=array();

        if ($emision != "" && $emisionf != "") {
            $horaini = ' 00:00:01';
            $horafin = ' 23:59:59';
            $databuscar[]=$emision.$horaini;
            $databuscar[]=$emisionf.$horafin;
        }
        elseif ($emision == "" && $emisionf == "") {

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

        $pendiente="NO";
        $a_semest = array();
        $t_semest = array();
        if (null !== $this->input->get("checksem1")) {
            $a_semest[] = "01";
            $t_semest[] = "I SEM";
        }
        if (null !== $this->input->get("checksem2")) {
            $a_semest[] = "02";
            $t_semest[] = "II SEM";
        }
        if (null !== $this->input->get("checksem3")) {
            $a_semest[] = "03";
            $t_semest[] = "III SEM";
        }
        if (null !== $this->input->get("checksem4")) {
            $a_semest[] = "04";
            $t_semest[] = "IV SEM";
        }
        if (null !== $this->input->get("checksem5")) {
            $a_semest[] = "05";
            $t_semest[] = "V SEM";
        }
        if (null !== $this->input->get("checksem6")) {
            $a_semest[] = "06";
            $t_semest[] = "VI SEM";
        }
        if (null !== $this->input->get("checkpend")) {
            $pendiente = $this->input->get("checkpend");
        }

        $rstdata = $this->mfacturacion_impresion->mget_estado_cuenta_deudas($documento, $databuscar, $a_semest, $pendiente);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_estado_cuenta_individual.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo_docpago');
        $drawing->setDescription('logo_docpago');
        $drawing->setPath('resources/img/logo_facturacion.'.getDominio().'.png'); // put your path and image here
        $drawing->setCoordinates('A1');
        $colWidth = $sheet->getColumnDimension('A')->getWidth() +$sheet->getColumnDimension('B')->getWidth();
        if ($colWidth == -1) { //not defined which means we have the standard width
            $colWidthPixels = 64; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
        } else {                  //innner width is 8.43 char units
            $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
        }
        //$offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
        //$drawing->setOffsetX($offsetX); //p
        $drawing->setWidth($colWidthPixels);

        //$drawing->setHeight(75);
        
        $drawing->setWorksheet($sheet);

        
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        $sheet->setCellValue('G1', date("d/m/Y"));
        $sheet->setCellValue('G2', date("h:i:s"));
        
        $sheet->setCellValue('B5', $rstdata['estud']->carnet." - ".$rstdata['estud']->nombres);
        $sheet->setCellValue('B6', $rstdata['estud']->carrera);

        $fila=6;

        $datefl =  new DateTime($emision);
        $dateflf =  new DateTime($emisionf);
        $dateini = $datefl->format('d/m/Y');
        $datefin = $dateflf->format('d/m/Y');
        $nrop = 0;
        if (count($rstdata['items']) > 0) {
            $fila++;
            $fila++;
            $sheet->mergeCells("A".$fila.":G".$fila);
            $sheet->setCellValue('A'.$fila, "PAGOS REALIZADOS      DEL ".$dateini." AL ".$datefin);
            $sheet->getStyle("A".$fila)->getAlignment()->setHorizontal('left');
            $sheet->getStyle("A".$fila)->getFont()->setBold(true)->setSize(10);

            $fila++;
            $sheet->setCellValue('A'.$fila, "N°");
            $sheet->getStyle("A".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B'.$fila, "DOCPAGO");
            $sheet->getStyle("B".$fila)->getAlignment()->setHorizontal('center');
            $sheet->mergeCells("C".$fila.":D".$fila);
            $sheet->setCellValue('C'.$fila, "CONCEPTO");
            $sheet->getStyle("B".$fila)->getAlignment()->setHorizontal('left');
            $sheet->setCellValue('E'.$fila, "FECHA/HORA");
            $sheet->getStyle("E".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('F'.$fila, "MONTO");
            $sheet->getStyle("F".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('G'.$fila, "TOTAL");
            $sheet->getStyle("G".$fila)->getAlignment()->setHorizontal('center');

            $sheet->getStyle("A".$fila.":G".$fila)->getFont()->setBold(true);
            $sheet->getStyle("A".$fila.":G".$fila)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("A".$fila.":G".$fila)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('F2F3F4');            
        }

        foreach ($rstdata['items'] as $pag) {
            $datemisp =  new DateTime($pag->fecha_hora);
            $pago = $datemisp->format('d/m/Y h:s a');
            $pmonto=number_format($pag->p_unitario, 2);
            $ptotal=number_format($pag->total, 2);
            $nrop++;
            $fila++;

            $sheet->getStyle("A".$fila.":G".$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            
            $sheet->getStyle("A".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('A'.$fila, $nrop);

            $sheet->getStyle("B".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B'.$fila, $pag->serie ." - ". $pag->numero);

            $sheet->mergeCells("C".$fila.":D".$fila);
            $sheet->setCellValue('C'.$fila, $pag->gestion);

            $sheet->setCellValue('E'.$fila, $pago);
            $sheet->getStyle("E".$fila)->getAlignment()->setHorizontal('center');

            $sheet->getStyle("F".$fila)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('F'.$fila)->getNumberFormat()->setFormatCode("(* #,##0.00);(* \(#,##0.00\);(* \"-\"??);(@_)");
            $sheet->setCellValue('F'.$fila, round($pag->p_unitario,2));

            $sheet->getStyle("G".$fila)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('G'.$fila)->getNumberFormat()->setFormatCode("(* #,##0.00);(* \(#,##0.00\);(* \"-\"??);(@_)");
            $sheet->setCellValue('G'.$fila, round($pag->total,2));
            
        }

        $nro=0;
        $mtotal=0;
        $grupo = "";
        $final = 0;
        $txtsemestres = implode(" / ", $t_semest);

        if (count($rstdata['deudas']) > 0) {
            $fila++;
            $fila++;
            $sheet->mergeCells("A".$fila.":G".$fila);
            $sheet->setCellValue('A'.$fila, "DEUDAS ASIGNADAS      ".$txtsemestres);
            $sheet->getStyle("A".$fila)->getAlignment()->setHorizontal('left');
            $sheet->getStyle("A".$fila)->getFont()->setBold(true)->setSize(10);

            $fila++;
            $sheet->setCellValue('A'.$fila, "N°");
            $sheet->getStyle("A".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B'.$fila, "PER./SEM.");
            $sheet->getStyle("B".$fila)->getAlignment()->setHorizontal('center');
            $sheet->mergeCells("C".$fila.":D".$fila);
            $sheet->setCellValue('C'.$fila, "CONCEPTO");
            $sheet->setCellValue('E'.$fila, "VENCE");
            $sheet->getStyle("E".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('F'.$fila, "MONTO");
            $sheet->getStyle("F".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('G'.$fila, "SALDO");
            $sheet->getStyle("G".$fila)->getAlignment()->setHorizontal('center');
            $sheet->getStyle("A".$fila.":G".$fila)->getFont()->setBold(true);
            $sheet->getStyle("A".$fila.":G".$fila)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("A".$fila.":G".$fila)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('F2F3F4');
            
        }

        foreach ($rstdata['deudas'] as $doc) {
            $datemis =  new DateTime($doc->fvence);
            $vence = $datemis->format('d/m/Y');
            $vmonto=number_format($doc->monto, 2);
            $vsaldo=number_format($doc->saldo, 2);
            $nro++;
            $fila++;

            // $mtotal=$mtotal +  $doc->monto;

            $sheet->getStyle("A".$fila.":G".$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            
            $sheet->getStyle("A".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('A'.$fila, $nro);

            $sheet->getStyle("B".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('B'.$fila, $doc->codperiodo." / ".$doc->ciclo);

            $sheet->mergeCells("C".$fila.":D".$fila);
            $sheet->setCellValue('C'.$fila, $doc->gestion);

            $sheet->getStyle("E".$fila)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E'.$fila, $vence);

            $sheet->getStyle("F".$fila)->getAlignment()->setHorizontal('right');
            if ($doc->monto != "0.00") {
                $sheet->getStyle('F'.$fila)->getNumberFormat()->setFormatCode("(* #,##0.00);(* \(#,##0.00\);(* \"-\"??);(@_)");
            }
            $sheet->setCellValue('F'.$fila, round($doc->monto,2));

            $sheet->getStyle("G".$fila)->getAlignment()->setHorizontal('right');
            if ($doc->saldo != "0.00") {
                $sheet->getStyle('G'.$fila)->getNumberFormat()->setFormatCode("(* #,##0.00);(* \(#,##0.00\);(* \"-\"??);(@_)");
            }
            
            $sheet->setCellValue('G'.$fila, round($doc->saldo,2));
            
            $final = $fila;
        }
        
        
        $writer = new Xlsx($spreadsheet);
        
        $filename = 'ESTADO DE CUENTA_'.$documento;
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 

    }
}
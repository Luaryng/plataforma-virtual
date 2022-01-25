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
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
//use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Academico_reportes extends CI_Controller{

	private $ci;
    public function __construct()
    {
        parent::__construct();
        $this->ci=& get_instance();
		$this->load->helper("url"); 
		//$this->load->model('mfacturacion');		
		//$this->load->model('mfacturacion_impresion');
		//$this->load->library('pagination');
	}

    public function vw_rp_xsede(){
        $ahead= array('page_title' =>'Reportes | Plataforma Virtual '.$this->ci->config->item('erp_title')  );
        $asidebar= array('menu_nieto' =>'reportes');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar_academico',$asidebar);
        //$arraydts['areas'] =$this->marea->m_filtrar_area(array($_SESSION['userActivo']->idsede));
        $arraydts['docentes'] =array();//$this->mdocentes->m_get_docentes_administrativos();

        $this->load->model('mperiodo');
        $this->load->model('mcarrera');
        $this->load->model('mmatricula');
        $arraydts['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);

        $arraydts['periodos']=$this->mperiodo->m_get_periodos();
        $this->load->model('mtemporal');
        $arraydts['ciclos']=$this->mtemporal->m_get_ciclos();
        
        $arraydts['turnos']=$this->mtemporal->m_get_turnos_activos();
        //$this->load->model('mcarrera');
        $arraydts['secciones']=$this->mtemporal->m_get_secciones();
        $arraydts['estados'] = $this->mmatricula->m_filtrar_estadoalumno();



        //$arraydts['gestion'] =$this->mfacturacion->m_get_items_gestion_habilitados();
        $this->load->view('academico/reportes/vw_reportes', $arraydts);
        $this->load->view('footer');
    }

    public function excel_matriculas_total_carga_filiales()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmsede='%';
        if (null !== $this->input->get("sd")){
            $fmsede=$this->input->get("sd"); 
        }
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");
        $fmcbestado=$this->input->get("es");
        $busqueda=$this->input->get("ap");

        $this->load->model('msede');
        $vsedes=$this->msede->m_get_sedes_activos();

        $this->load->model('mmatricula');
        $vmatriculas=$this->mmatricula->m_matriculas_total_carga_filiales(array($fmsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,$fmcbestado,'%'.$busqueda.'%'),$vsedes);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp-lista-matriculas.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila=0;
        $nro=0;
        $grupo="";
        foreach ($vmatriculas as $mat) {
            //if ($mat->eliminado!="SI"){
                $grupoint=$mat->codperiodo.$mat->codcarrera.$mat->codplan.$mat->codciclo.$mat->codturno.$mat->codseccion;
                if ($grupo!=$grupoint){
                    $grupo=$grupoint;
                    $fila=$fila+4;
                    $sheet->setCellValue("A".$fila, "PERIODO LECTIVO");
                    $sheet->mergeCells("A$fila:B$fila");
                    $sheet->setCellValue("C".$fila, $mat->periodo);
                    $sheet->getStyle("C".$fila)->getFont()->setBold(true);
                    $sheet->setCellValue("D".$fila, "PROGRAMA");
                    $sheet->setCellValue("E".$fila, $mat->carrera);
                    $sheet->getStyle("E".$fila)->getFont()->setBold(true);
                    $sheet->mergeCells("E$fila:G$fila");
                    $fila++;
                    $sheet->setCellValue("A".$fila, "PERIODO ACADEM.");
                    $sheet->mergeCells("A$fila:B$fila");
                    $sheet->setCellValue("C".$fila, $mat->ciclo);
                    $sheet->getStyle("C".$fila)->getFont()->setBold(true);
                    $sheet->setCellValue("D".$fila, "TURNO");
                    $sheet->setCellValue("E".$fila, $mat->codturno);
                    $sheet->getStyle("E".$fila)->getFont()->setBold(true);
                    $sheet->setCellValue("F".$fila, "SECCIÓN");
                    $sheet->setCellValue("G".$fila, $mat->codseccion);
                    $sheet->getStyle("G".$fila)->getFont()->setBold(true);
                    $fila=$fila+2;
                    $sheet->setCellValue("A".$fila, "N°");
                    $sheet->setCellValue("B".$fila, "CARNÉ");
                    $sheet->setCellValue("C".$fila, "APELLIDOS Y NOMBRES");
                    $sheet->setCellValue("F".$fila, "TOTAL");
                    $colsede=7;
                    foreach ($vsedes as $key => $sede) {
                        $idsede=$sede->id;
                        $sheet->setCellValueByColumnAndRow($colsede,$fila, $sede->nombre);
                        $colsede++;
                    }
                    $sheet->getStyle("A$fila:K$fila")->getFont()->setBold(true);
                    $sheet->mergeCells("C$fila:E$fila");
                    $nro=0;
                }
                
                $nro++;
                $fila++;
                
                $sheet->setCellValue("A".$fila, $nro);
              
                //$sheet->setCellValue('D'.$fila, $mat->tdoc);
                //$sheet->setCellValue('E'.$fila, $mat->nro);
                

                $sheet->setCellValue('B'.$fila, $mat->carne);
                $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                $sheet->mergeCells("C$fila:E$fila");
                $sheet->setCellValue('F'.$fila, $mat->ncursos);
                $colsede=7;
                foreach ($vsedes as $key => $sede) {
                    $idsede=$sede->id;
                    $sheet->setCellValueByColumnAndRow($colsede,$fila, $mat->{"s".$idsede});
                    $colsede++;
                }
                //$sheet->mergeCells("F$fila:G$fila");
                /*$edad=($strtimeact - strtotime($mat->fecnac))/31557600;
                $sheet->setCellValue('J'.$fila, $mat->fecnac);

                $sheet->setCellValue('K'.$fila, intval($edad));
                
                $sheet->setCellValue('L'.$fila, $mat->sexo);
                $sheet->setCellValue('M'.$fila, " ".$mat->celular);
                $sheet->setCellValue('N'.$fila, $mat->ecorporativo);
                //AQUI HAY QUE ARREGLAR LO DE DISCAPACIDAD
                $sheet->setCellValue('O'.$fila, date_format(date_create($mat->fecinsc),"d/m/Y"));*/
              

            }
        //}
        /*foreach(range('A','L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }*/
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'Carga academica por estudiante - filial';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function excel_cuadro_horas_docentes()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmsede='%';
        if (null !== $this->input->get("sd")){
            $fmsede=$this->input->get("sd"); 
        }
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");
        $fmcbestado=$this->input->get("es");
        $busqueda=$this->input->get("ap");
    }



    public function rpsede_docemitidos_pdf()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");

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

        //$dominio=str_replace(".", "_",getDominio());
        
        $html1=$this->load->view('facturacion/reportes/rpsede_docemitidos', array('docpagos' => $rstdata,'emision' => $emision, 'emisionf' => $emisionf),true);
         
        $pdfFilePath = $_SESSION['userActivo']->sede.' Documentos Emitidos.pdf';

        $this->load->library('M_pdf');
        
        $formatoimp="A4";
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

        $mpdf->SetTitle( $_SESSION['userActivo']->sede.' Documentos Emitidos');       

        //$mpdf->AddPage();
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");
        // $mpdf->Output();
    }

    public function rpsede_docemitidos_detalle_mediodpago_pdf()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");

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
        

        // $checktodos=(null !== $this->input->get("checktodos")?"TODOS":"");
        // $checkanulado=(null !== $this->input->get("checkanulado")?"ANULADO":"");
        // $checkenviado=(null !== $this->input->get("checkenviado")?"ENVIADO":"");
        // $checkrechazado=(null !== $this->input->get("checkrechazado")?"RECHAZADO":"");
        // $checkerror=(null !== $this->input->get("checkerror")?"ERROR":"");
        // if ($checktodos.$checkanulado.$checkenviado.$checkrechazado.$checkerror==""){
        //     $checktodos="TODOS";
        // }
        // $a_estado=array($checktodos,$checkanulado,$checkenviado,$checkrechazado,$checkerror);
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
        var_dump($a_estado);
        $rstdata = $this->mfacturacion_impresion->m_get_emitidos_filtro_xsede_medio_pago($_SESSION['userActivo']->idsede,$busqueda,$databuscar,$a_estado);

        //$dominio=str_replace(".", "_",getDominio());
        
        $html1=$this->load->view('facturacion/reportes/rpsede_docemitidos_detalle_mediodpago', array('docpagos' => $rstdata['docpagos'],'docpagosmedios' => $rstdata['docpagosmedios'],'emision' => $emision, 'emisionf' => $emisionf),true);
         
        $pdfFilePath = $_SESSION['userActivo']->sede.' Documentos Emitidos-Medio Pago.pdf';

        $this->load->library('M_pdf');
        
        $formatoimp="A4-L";
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

        $mpdf->SetTitle( $_SESSION['userActivo']->sede.' Documentos Emitidos-Medio Pago');       

        //$mpdf->AddPage();
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");
        // $mpdf->Output();
    }

    public function rpsede_docemitidos_detalle_concepto_pdf()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");

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
        $detalle = $this->mfacturacion_impresion->m_get_pagos_detalle_sede();


        
        $html1=$this->load->view('facturacion/reportes/rpsede_docemitidos_detalle_concepto', array('docpagos' => $rstdata,'emision' => $emision, 'emisionf' => $emisionf, 'detalle' => $detalle),true);
         
        $pdfFilePath = $_SESSION['userActivo']->sede.' Documentos Emitidos-conceptos.pdf';

        $this->load->library('M_pdf');
        
        $formatoimp="A4";
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

        $mpdf->SetTitle( $_SESSION['userActivo']->sede.' Documentos Emitidos-conceptos');       

        //$mpdf->AddPage();
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");
        // $mpdf->Output();
    }

    public function dp_docs_emitidos_xdia_xsede_pdf()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");

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
        
        $rstdata = $this->mfacturacion_impresion->m_get_emitidos_filtro_xsede($_SESSION['userActivo']->idsede,$busqueda,$databuscar);

        //$dominio=str_replace(".", "_",getDominio());
        
        $html1=$this->load->view('facturacion/reportes/rp_docemitidos_xsede_xdia', array('docpagos' => $rstdata,'emision' => $emision, 'emisionf' => $emisionf),true);
         
        $pdfFilePath = $_SESSION['userActivo']->sede.' Documentos Emitidos.pdf';

        $this->load->library('M_pdf');
        
        $formatoimp="A4";
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

        $mpdf->SetTitle( $_SESSION['userActivo']->sede.' Documentos Emitidos');       

        //$mpdf->AddPage();
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");
        // $mpdf->Output();
    }

    public function rpsede_documentos_emitidos_filtro_items_pdf()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("ct");

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
        
        $rstdata = $this->mfacturacion_impresion->m_get_emitidositems_filtro_xsede($_SESSION['userActivo']->idsede,$busqueda,$databuscar);
        
        $html1=$this->load->view('facturacion/reportes/rpsede_docemitidos_por_conceptos', array('docpagos' => $rstdata,'emision' => $emision, 'emisionf' => $emisionf),true);
         
        $pdfFilePath = $_SESSION['userActivo']->sede.' Documentos Emitidos-conceptos.pdf';

        $this->load->library('M_pdf');
        
        $formatoimp="A4-L";
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

        $mpdf->SetTitle( $_SESSION['userActivo']->sede.' Documentos Emitidos - conceptos');       

        //$mpdf->AddPage();
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Facturacion_reportes extends Error_views{

	private $ci;
    public function __construct()
    {
        parent::__construct();
        $this->ci=& get_instance();
		$this->load->helper("url"); 
		$this->load->model('mfacturacion');		
		$this->load->model('mfacturacion_impresion');
        $this->load->model('msede');
		//$this->load->library('pagination');
	}

    public function vw_rp_xsede(){
        $ahead= array('page_title' =>'Reportes | Plataforma Virtual '.$this->ci->config->item('erp_title')  );
        $asidebar= array('menu_padre' =>'mn_ts_reportes');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar_facturacion',$asidebar);
        //$arraydts['areas'] =$this->marea->m_filtrar_area(array($_SESSION['userActivo']->idsede));
        $arraydts['docentes'] =array();//$this->mdocentes->m_get_docentes_administrativos();

        $this->load->model('mperiodo');
        $this->load->model('mcarrera');
        $arraydts['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);

        $arraydts['periodos']=$this->mperiodo->m_get_periodos();
        $this->load->model('mtemporal');
        $arraydts['ciclos']=$this->mtemporal->m_get_ciclos();
        
        $arraydts['turnos']=$this->mtemporal->m_get_turnos_activos();
        //$this->load->model('mcarrera');
        $arraydts['secciones']=$this->mtemporal->m_get_secciones();
        
        $arraydts['sedes'] = $this->msede->m_get_sedes_activos();



        $arraydts['gestion'] =$this->mfacturacion->m_get_items_gestion_habilitados();
        $this->load->view('facturacion/reportes/vw_reportes', $arraydts);
        $this->load->view('footer');
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

    public function fn_emitidositems_x_pagante()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $rscuentas="";
        $dataex['conteo'] =0;
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('codpagante','Pagante','trim|required');
            $this->form_validation->set_rules('codgestion','Gestión','trim|required');
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
                $codpagante=$this->input->post('codpagante');
                $codgestion = $this->input->post('codgestion');

                
                $pagos=$this->mfacturacion_impresion->m_get_emitidositems_x_pagante(array($codpagante));
                foreach ($pagos as $key => $pago) {
                    $fecha_hora =  new DateTime($pago->fecha_hora) ;
                    $pago->fecha_hora = $fecha_hora->format('d/m/Y h:i a');  
                    $pago->coddetalle64=base64url_encode($pago->coddetalle);
                }
                $dataex['vdata']=$pagos;
                $dataex['status'] =TRUE;
            }
        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function rp_consolidado_docemitidos_xmes_pdf()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        date_default_timezone_set('America/Lima');

        $fecha = date('d/m/Y');
        $sede = ($this->input->get("sd") != "%") ? base64url_decode($this->input->get("sd")) : $this->input->get("sd");
        $mes = $this->input->get("ms");
        $anio = $this->input->get("year");
        
        $rstdata = $this->mfacturacion_impresion->m_get_consolidado_mes(array($sede, $mes, $anio));

        //$dominio=str_replace(".", "_",getDominio());
        
        $html1=$this->load->view('facturacion/reportes/rpconsolidado_docemitidos_mes', array('docpagos' => $rstdata,'fecha' => $fecha, 'anio'=>$anio),true);
         
        $pdfFilePath = 'CONSOLIDADO DE DOCUMENTOS EMITIDOS POR MES.pdf';

        $this->load->library('M_pdf');
        
        $formatoimp="A4";
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

        $mpdf->SetTitle('CONSOLIDADO DE DOCUMENTOS EMITIDOS POR MES');       

        //$mpdf->AddPage();
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");
        // $mpdf->Output();
    }

    public function rp_deudas_estudiante_individual_pdf()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        date_default_timezone_set('America/Lima');

        $fecha = date('d/m/Y');
        $tipo = $this->input->get("tp");
        $documento = $this->input->get("nro");
        $this->load->model('malumno');
        $rstdata = $this->malumno->mget_deudas_xestudiante(array($tipo,$documento));

        //$dominio=str_replace(".", "_",getDominio());
        
        $html1=$this->load->view('alumno/rpdeudas_estudiante_pdf', array('docpagos' => $rstdata),true);
         
        $pdfFilePath = 'DEUDAS PENDIENTES.pdf';

        $this->load->library('M_pdf');
        
        $formatoimp="A4";
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

        $mpdf->SetTitle('DEUDAS PENDIENTES');       

        //$mpdf->AddPage();
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");
        // $mpdf->Output();
    }

    public function rp_estado_cuenta_individual_pdf()
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        date_default_timezone_set('America/Lima');

        $fecha = date('d/m/Y');
        $documento = $this->input->get("pg");
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");

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

        //$dominio=str_replace(".", "_",getDominio());
        
        $html1=$this->load->view('facturacion/reportes/rpestado_cuenta_individual', array('docpagos' => $rstdata, 'semestres' => $t_semest, 'inicia' => $emision, 'culmina' => $emisionf),true);
         
        $pdfFilePath = 'ESTADO DE CUENTA.pdf';

        $this->load->library('M_pdf');
        
        $formatoimp="A4";
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 

        $mpdf->SetTitle('ESTADO DE CUENTA');       

        //$mpdf->AddPage();
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");
        // $mpdf->Output();
    }

}
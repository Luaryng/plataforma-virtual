<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscrito_reportes extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('minscrito_reporte');
		$this->load->model('mdiscapacidad');
		$this->load->model('mpublicidad');
	}

	public function vw_reportes()
	{
		$ahead= array('page_title' =>'REPORTES | '.$this->ci->config->item('erp_title') );
			$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'insreport');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_admision',$asidebar);

			if (getPermitido("45")=='SI'){
				$this->load->model('mmodalidad');
				$a_ins['modalidades']=$this->mmodalidad->m_get_modalidades();
				$this->load->model('mperiodo');
				$a_ins['periodos']=$this->mperiodo->m_get_periodos();
				$this->load->model('mcarrera');
				$a_ins['carreras']=$this->mcarrera->m_get_carreras_abiertas_por_sede($_SESSION['userActivo']->idsede);

				$this->load->model('mtemporal');
				$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
				//$this->load->model('mcarrera');
				$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
				//$this->load->model('mcarrera');
				$a_ins['secciones']=$this->mtemporal->m_get_secciones();
				$a_ins['dnipostula']= "";
				$a_ins['docs_anexar']=$this->mtemporal->m_get_docs_por_anexar();

				$a_ins['discapacidades']=$this->mdiscapacidad->m_filtrar_discapacidadxestado();
				$a_ins['publicidad'] = $this->mpublicidad->m_get_publicidades();

				$this->load->view('admision/reportes/vw_reportes_inscritos',$a_ins);
			}
			else{

				$this->load->view('errors/sin-permisos');
			}
			
			
			$this->load->view('footer');
	}

	public function get_filtrar_basico_sd_activa_report()
	{
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';

		$busqueda=$this->input->get('bc');
		$carrera=$this->input->get('pg');
		$periodo=$this->input->get('per');
		$turno=$this->input->get('tn');
		$campania=$this->input->get('cp');
		$seccion=$this->input->get('sc');

		$this->load->model('miestp');
		$ie=$this->miestp->m_get_datos();

		$cuentas = $this->minscrito_reporte->m_filtrar_basico_sd_activa_reportes(array($periodo,$campania,$carrera,$turno,$seccion,$_SESSION['userActivo']->idsede,'%'.$busqueda.'%',));
		
		$dominio=str_replace(".", "_",getDominio());
		$html1=$this->load->view("admision/reportes/rp_inscritos_pdf_$dominio", array('ies' => $ie,'ins'=>$cuentas),true);
		$pdfFilePath = "REPORTE INSCRITOS - ".$_SESSION['userActivo']->sede.".pdf";

        $this->load->library('M_pdf');
        $formatoimp="A4-L";
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 
        $mpdf->SetTitle( "REPORTE INSCRITOS - ".$_SESSION['userActivo']->sede);
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");

	}

	public function get_datos_inscritos()
	{
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';

		$busqueda=$this->input->get('bc');
		$carrera=$this->input->get('pg');
		$periodo=$this->input->get('per');
		$turno=$this->input->get('tn');
		$campania=$this->input->get('cp');
		$seccion=$this->input->get('sc');

		$this->load->model('miestp');
		$ie=$this->miestp->m_get_datos();

		$cuentas = $this->minscrito_reporte->m_filtrar_basico_inscritos(array($periodo,$campania,$carrera,$turno,$seccion,$_SESSION['userActivo']->idsede,'%'.$busqueda.'%',));
		
		$dominio=str_replace(".", "_",getDominio());
		$html1=$this->load->view("admision/reportes/rp_datos_inscritos_$dominio", array('ies' => $ie,'ins'=>$cuentas),true);
		$pdfFilePath = "REPORTE DATOS INSCRITOS - ".$_SESSION['userActivo']->sede.".pdf";

        $this->load->library('M_pdf');
        $formatoimp="A4-P";
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 
        $mpdf->SetTitle( "REPORTE DATOS INSCRITOS - ".$_SESSION['userActivo']->sede);
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "I");

	}


}
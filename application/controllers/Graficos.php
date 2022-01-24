<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graficos extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->model('mfacturacion_cobros');
		$this->load->model('mgraficos');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Estadistica | IESTWEB'  );
		$asidebar= array('menu_padre' =>'estadistica','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_facturacion',$asidebar);
		$arraydts['bancos'] = $this->mfacturacion_cobros->m_get_bancos();

		$arraydts['repcobros'] = $this->mgraficos->m_get_emitidos_cobros();
		$arraydts['sumabanco'] = $this->mgraficos->m_suma_por_banco();
		$arraydts['cbsede'] = $this->mgraficos->m_get_emitidos_cobrosxsede();

		$this->load->view('facturacion/graficos/vw_graficos_dia', $arraydts);
		$this->load->view('footer');
	}

	


}
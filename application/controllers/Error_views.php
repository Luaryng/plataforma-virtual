<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Error_views extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	protected function vwh_nopermitido($title){
		$ahead= array('page_title' =>$title  );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
                $this->load->view($vsidebar);
                $this->load->view('errors/vwh_nopermitido');
                $this->load->view('footer');
	}

	protected function vwh_error_personalizado($title,$titlemsg,$msg){
		$ahead= array('page_title' =>$title.' | IESTWEB');
		$avwh= array('msg_title' =>$titlemsg,'msg' =>$msg );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
                $this->load->view($vsidebar);
                $this->load->view('errors/vwh_error_personalizado',$avwh);
                $this->load->view('footer');
	}

	public function vwh_noencontrado(){
	$ahead= array('page_title' =>'404 - Pagina no encontrada'  );
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar);
        $this->load->view('errors/vwh_noencontrado');
        $this->load->view('footer');
	}
}
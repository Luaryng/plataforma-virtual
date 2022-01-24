<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrera_web extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->model('mcarrera_web');
		//$this->load->model('mauditoria');
	}
	
	public function vw_principal(){
		$ahead= array('page_title' =>'PROGRAMA | ERP'  );
		$asidebar= array('menu_padre' =>'mn_programas','menu_hijo' =>'carrera');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_portal',$asidebar);
		$a_datos['carreras'] =$this->mcarrera_web->m_get_carreras(array($_SESSION['userActivo']->idsede));
		$this->load->view('carreras/vw_carw_principal', $a_datos);
		$this->load->view('footer');
	}

	public function vw_editar($vcodcar){
		$ahead= array('page_title' =>'PROGRAMA | ERP'  );
		$asidebar= array('menu_padre' =>'mn_programas','menu_hijo' =>'carrera');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_portal',$asidebar);
		$vcodcar=base64url_decode($vcodcar);
		$vcodsede=$_SESSION['userActivo']->idsede;
		$this->load->model('mcarrera');
		$a_datos['carreras'] =$this->mcarrera->m_get_carreras_activas_por_sede(array($vcodsede));
		$a_datos['carrera'] =$this->mcarrera_web->m_get_carrera(array($vcodcar,$vcodsede));
		$this->load->view('carreras/vw_carw_mantenimiento', $a_datos);
		$this->load->view('footer');
	}

	public function fn_guardar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$this->form_validation->set_rules('vw_ptpe_cb_programa','Programa','trim|required');
			$this->form_validation->set_rules('vw_ptpe_txt_url','URL','trim|required');
			/*$this->form_validation->set_rules('vw_ptpe_txt_presentacion','Presentación','trim|required');
			$this->form_validation->set_rules('vw_ptpe_txt_contenido','Contenido','trim|required');*/

 




			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$dataex['msg2']=validation_errors();
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$dataex['status'] =FALSE;
				$vpprograma= base64url_decode($this->input->post('vw_ptpe_cb_programa'));
				$vpurl = slugs($this->input->post('vw_ptpe_txt_url'));
				$vppresenta=$this->input->post('vw_ptpe_txt_presentacion');
				$vpcontenido=$this->input->post('vw_ptpe_txt_contenido');
				$vpcodigo=$this->input->post('vw_ptpe_txt_codigo');
				$vptitulo=$this->input->post('vw_ptpe_txt_titulo');
				$vpduracion=$this->input->post('vw_ptpe_txt_duracion');
				$vpperfil=$this->input->post('vw_ptpe_txt_perfil');
				$vpcurricula=$this->input->post('vw_ptpe_txt_curricula');
				$vprequisitos=$this->input->post('vw_ptpe_txt_requisitos');
				//$ext = $this->input->post('extimg');
				//m_update($data){
    			//CALL `sp_tb_carrera_web_update`( @vcarw_url, @vcarw_presentacion, @vcarw_contenido, @vcar_id, @vsede_id, @s);

				//date_default_timezone_set ('America/Lima');
				//$nomimage = slugs($fictxttitulo).date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext;;
				if ($vpcodigo=="0"){

				}
				else{
					$rpta=$this->mcarrera_web->m_update(array($vpurl, $vppresenta, $vpcontenido, $vpprograma, $_SESSION['userActivo']->idsede,$vprequisitos, $vpperfil, $vpcurricula,$vptitulo,$vpduracion,base64url_decode($vpcodigo)));
	            	if ($rpta->salida=="1"){
	            		$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos registrados correctamente";
	        		}
				}
				




			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	

	
}
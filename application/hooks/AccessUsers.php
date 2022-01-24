<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccessUsers extends CI_Hooks {
	private $ci;
	function __construct() {
    	$this->ci=& get_instance();
	  	//!$this->ci->load->library('session') ? $this->ci->load->library('session') : FALSE;
    	

	  	if (session_id()=="") {
	  	    //session_set_cookie_params(0, '/', 'localhost', FALSE, FALSE);
	  	    session_set_cookie_params(0, '/', $this->ci->config->item('ses_dominio'), TRUE, TRUE);
	  		session_start();
	  	}	
	  	!$this->ci->load->helper('url') ? $this->ci->load->helper('url') : FALSE;
    }

	public function checkAccess(){

		$classn=$this->ci->router->class;
		$class=strtoupper($classn);
		$method=$this->ci->router->method;
		//$acceso=$this->ci->session->userdata('UserRolActivo');
		$acceso=(isset($_SESSION['islogin']))?$_SESSION['islogin']:NULL;
		
		

		$bloquea=FALSE;
		if ($acceso==NULL){
			$claselibre=array('INDEX','USUARIO','SENDMAIL','PREMATRICULA',"MESA_PARTES","CONVOCATORIAS","UBIGEO","CURSO_WEB");
			if(in_array($class,$claselibre)){
				$methodlibre=array();
				$methodlibre['INDEX']=array('VW_INICIAR_SESION','ERROR404','VW_INICIAR_SESION_EXTERNO');
				$methodlibre['USUARIO']=array('FN_LOGIN','LOGINGOOGLE');
				$methodlibre['SENDMAIL']=array('F_NOTIFICACIONES_AULA_VIRTUAL','F_SENDMAIL_ADJUNTOS');
				$methodlibre['PREMATRICULA']=array('INDEX','FN_INSERT', 'FN_UPLOAD_FILE_EXTERNO','FN_CARRERAS_SEDES','FN_DELETE_FILE','FN_ENVIAR_CONSTANCIA_PREINS_CORREO','PDF_FICHA_PREINSCRIPCION_MAIL','PDF_FICHA_PREINSCRIPCION','VW_PRE_INSCRIPCION_CETPRO');
				$methodlibre['CONVOCATORIAS']=array('VW_CONVOCATORIA_ARCHIVOS');
				$methodlibre['MESA_PARTES']=array('VW_CREAR_EXTERNO','FN_INSERT_EXTERNO','FN_UPLOAD_FILE_EXTERNO','VW_CONSULTAR_EXPEDIENTE','VW_EXPEDIENTE_SOLICITUD_RUTA','PDF_FICHA_TRAMITE_MAIL','PDF_FICHA_TRAMITE','FN_CARRERAS_SEDES');
				$methodlibre['UBIGEO']=array('FN_DISTRITOS_ALL','FN_PROVINCIA_X_DEPARTAMENTO','FN_DISTRITO_X_PROVINCIA');
				$methodlibre['CURSO_WEB']=array('VW_PRE_INSCRIPCION','FN_CURSOS_SEDES','FN_INSERT', 'FN_UPLOAD_FILE_EXTERNO','FN_DELETE_FILE_WEB');
				if(in_array(strtoupper($method),$methodlibre[$class])){
					$bloquea=true;
				}
			}
		}
		else{
			//$bloquea=$this->ci->session->userdata('UserLog');
			$bloquea=$_SESSION['islogin'];

		}
	
		if ($bloquea==FALSE){
			$_SESSION["urlRedirect"]=current_url();
			redirect($this->ci->config->item('login_url'),'refresh');
		}
		
	}
}
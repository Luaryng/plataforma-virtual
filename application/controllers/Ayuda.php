<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ayuda extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('musuario');
		$this->load->model('mayuda');
		$this->load->model('mauditoria');
	}

	public function vw_tutoriales()
	{
		$ahead= array('page_title' =>'Tutoriales y Manual de usuario | IESTWEB');
		$asidebar= array('menu_padre' =>'docvideoayuda');
		$this->load->view('head',$ahead);
		$this->load->view('nav');

		//AL,DC,AD,DA
		$tpuser=strtolower($_SESSION['userActivo']->tipo);
		$vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
		$this->load->view($vsidebar,$asidebar);
		$manuales = $this->mayuda->m_get_manuales();
		$manualgr = $this->mayuda->m_get_manualesxgrupo();
		$arraydts['manuales'] = $manuales;
		$arraydts['manualgr'] = $manualgr;
		$orden = 0;
		$vorden = 0;
		$nmanual = $this->mayuda->m_get_manualesxtipo('manual');
		$nvideo = $this->mayuda->m_get_manualesxtipo('video');
		if (isset($nmanual->orden)) $orden = $nmanual->orden;
		if (isset($nvideo->orden)) $vorden = $nvideo->orden;
		
		$arraydts['orden'] = ($orden+1);
		$arraydts['vorden'] = ($vorden+1);

		if (getPermitido("157")=="SI"){
			$this->load->view("ayuda/ayuda", $arraydts);
		} else {
			$this->load->view("ayuda/vw_ayuda", $arraydts);
		}
		
		$this->load->view('footer');
	}

	public function vw_enviar_sugerencia()
	{
		$ahead= array('page_title' =>'Enviar sugerencias | IESTWEB');
		$asidebar= array('menu_padre' =>'sendsugerencia');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
		$this->load->view($vsidebar,$asidebar);
		$this->load->view('ayuda/vw_enviar_sugerencia');
		$this->load->view('footer');
	}

	public function vw_agregar($tipo,$orden)
	{
		$ahead= array('page_title' =>'Agregar Tutoriales y Manual de usuario | IESTWEB');
		$asidebar= array('menu_padre' =>'docvideoayuda');
		$this->load->view('head',$ahead);
		$this->load->view('nav');

		//AL,DC,AD,DA
		$tpuser=strtolower($_SESSION['userActivo']->tipo);
		$vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
		$this->load->view($vsidebar,$asidebar);
		$manuales = $this->mayuda->m_get_manualesxgrupo();
		$arraydts = array('tipo' => $tipo, 'orden' => $orden, 'manuales' => $manuales);
		$this->load->view("ayuda/vw_agregar_manual", $arraydts);
		$this->load->view('footer');
	}

	public function vw_editar($codigo)
	{
		$ahead= array('page_title' =>'Editar Tutoriales y Manual de usuario | IESTWEB');
		$asidebar= array('menu_padre' =>'docvideoayuda');
		$this->load->view('head',$ahead);
		$this->load->view('nav');

		//AL,DC,AD,DA
		$tpuser=strtolower($_SESSION['userActivo']->tipo);
		$vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
		$this->load->view($vsidebar,$asidebar);
		$manuales = $this->mayuda->m_get_manualesxcodigo(array(base64url_decode($codigo)));
		$arraydts = array('tipo' => "", 'orden' => "", 'manual' => $manuales);
		$this->load->view("ayuda/vw_agregar_manual", $arraydts);
		$this->load->view('footer');
	}

	public function fn_manualxcodigo()
	{
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$manuales="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo manual', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$manuales = $this->mayuda->m_get_manualesxcodigo(array($codigo));
			$manuales->codigo64 = base64url_encode($manuales->codigo);
			$manuales->orden64 = base64url_encode($manuales->orden);
			
		}
		
		$dataex['vdata'] = $manuales;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insert_update()
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
			
			$this->form_validation->set_rules('vw_pw_bt_ad_fictxttitulo','nombre area','trim|required');
			$this->form_validation->set_rules('vw_pw_bt_ad_fictxtenlace','encargado','trim|required');

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
				$dataex['status'] =FALSE;
				
				$codigo = $this->input->post('vw_pw_bt_ad_fictxtcodigo');
				$titulo = $this->input->post('vw_pw_bt_ad_fictxttitulo');
				$enlace = $this->input->post('vw_pw_bt_ad_fictxtenlace');
				$tipo = $this->input->post('vw_pw_bt_ad_fictxttipo');
				$orden = base64url_decode($this->input->post('vw_pw_bt_ad_fictxtorden'));
				$accesos = $this->input->post('fictxtaccesos');
				// $txtgrupo = $this->input->post('vw_pw_bt_ad_fictxtgrupo');
				$grupo = null;
				if ($this->input->post('vw_pw_bt_ad_fictxtgrupo') !== null) {
					$grupo = $this->input->post('vw_pw_bt_ad_fictxtgrupo');
				}
				
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;


				if ($codigo == "0") {
					$rpta=$this->mayuda->mInsert_manual(array($grupo, $titulo, $enlace, $tipo, $orden, $accesos));

					if ($rpta->salida > 0){
						$fictxtaccion = "INSERTAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando un $tipo en la tabla TB_MANUALES COD.".$rpta->newcod;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="$tipo registrado correctamente";
						
					}
				} else {
					$rpta=$this->mayuda->mUpdate_manual(array(base64url_decode($codigo), $grupo, $titulo, $enlace, $tipo, $orden, $accesos));
					if ($rpta->salida == 1){
						$fictxtaccion = "EDITAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un $tipo en la tabla TB_MANUALES COD.".$rpta->newcod;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="$tipo actualizado correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function f_ordenar()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
            if (getPermitido("123")=='SI'){
	            $this->form_validation->set_rules('vaccion', 'accion', 'trim|required');
	            
	            if ($this->form_validation->run() == false) {
	                $dataex['msg'] = validation_errors();
	            } else {
	                $dataex['msg'] = "Ocurrio un error al intentar generar la nueva fecha</a>";
	                
	                $data          = json_decode($_POST['filas']);
	                $dataUpdate    = array();
	                foreach ($data as $value) {
	                    if ($value[1] > 0) {
	                        $dataUpdate[] = array($value[0],$value[1]);
	                    }
	                }
	                $rpta = $this->mayuda->m_ordenar_manual($dataUpdate);
	                //var_dump($dataex['ids']);
	                $dataex['status'] = true;

	            }
	            $dataex['destino'] = $urlRef;
	            header('Content-Type: application/x-json; charset=utf-8');
	            echo (json_encode($dataex));
	        }
            
        }
    }

    public function fneliminar_manual()
    {
    	$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo manual', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este manual";
                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un manual en la tabla TB_MANUALES COD.".$txtcodigo;
				
                $rpta = $this->mayuda->m_elimina_manual(array($txtcodigo));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Manual eliminado correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	
}


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capacitaciones extends CI_Controller{
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->helper("url"); 
		$this->load->model("mbolsa");
		$this->load->model("meventos");

		$this->load->model("mcapacitaciones");
		$this->load->model('mauditoria');
	}

    public function vw_principal()
	{
		$ahead= array('page_title' =>'CAPACITACIONES | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'eventos','menu_hijo' =>'capacitacion');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		if (getPermitido("155")=='SI'){
			$arraydts['capacita'] = $this->mcapacitaciones->lstcapacitaciones();
			$this->load->view('capacitaciones/vw_capacitaciones', $arraydts);
		}
		else{
			$this->load->view('errors/sin-permisos');
		}
		$this->load->view('footer');
	}

	public function vw_agregar()
	{
		$ahead= array('page_title' =>'Agregar capacitación | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'eventos','menu_hijo' =>'capacitacion');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		if (getPermitido("152")=='SI'){
			$this->load->view('capacitaciones/vw_agregar_cap');
		}
		else{
			 $this->load->view('errors/sin-permisos');
		}
		$this->load->view('footer');
	}

	public function vw_editar($codigo)
	{
		$ahead= array('page_title' =>'Editar Capacitación | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'eventos','menu_hijo' =>'capacitacion');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		if (getPermitido("153")=='SI'){
			$txtcod = base64url_decode($codigo);
			$arraydts['capacita'] = $this->mcapacitaciones->lstcapacitaciones_id(array($txtcod));
			$this->load->view('capacitaciones/vw_agregar_cap', $arraydts);
			
		}
		else{
			 $this->load->view('errors/sin-permisos');
		}
		$this->load->view('footer');
	}


	public function uploadimages(){
		if ($_FILES['file']['name']) {
			if (!$_FILES['file']['error']) {
			    $name = md5(Rand(100, 200));
			    $ext = explode('.', $_FILES['file']['name']);
			    $filename = "sm".$name . '.' . $ext[1];
			    $destination = './upload/eventos/' . $filename; //change this directory
			    $location = $_FILES["file"]["tmp_name"];
			    move_uploaded_file($location, $destination);
			    echo 'upload/eventos/' . $filename;
			} else {
			  echo  $message = 'Se ha producido el siguiente error:  '.$_FILES['file']['error'];
			}
		}
	}

	public function delete_file()
    {
        $src = $this->input->post('src'); 
        // $src = $_POST['src']; 
        $file_name = str_replace(base_url(), '', $src); 
        // link de host para obtener la ruta relativa
        if(unlink($file_name)) { 
            echo 'imagen eliminada correctamente'; 
        }
    }

	public function fn_insert_update()
	{
			
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$this->form_validation->set_message('required', '*%s Requerido');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		if ($this->input->is_ajax_request())
		{	
			if (getPermitido("152")=='SI'){

				$this->form_validation->set_rules('vw_pw_bt_ad_fictxttitulo','Título','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxtexpositor','Expositor','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxtfecha','Fecha','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_cbotipo','Tipo','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxthora','Hora','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxtgrabacion','Grabación','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_detalle','Detalle','trim|required');

				if ($this->form_validation->run() == FALSE)
				{ 
					$dataex['msg']="Existen errores en los campos";
					$dataex['errimg'] = 'No hay archivo seleccionado';
					$errors = array();
			        foreach ($this->input->post() as $key => $value){
			            $errors[$key] = form_error($key);
			        }
			        $dataex['errors'] = array_filter($errors);
				}
				else
				{
					$dataex['msg'] ='Ocurrio un error, intente nuevamente o comuniquese con un administrador.';
					$codigo64= $this->input->post('vw_pw_bt_ad_codigo');
					$codigo = base64url_decode($codigo64);
					$titulo= $this->input->post('vw_pw_bt_ad_fictxttitulo');
					$expositor = $this->input->post('vw_pw_bt_ad_fictxtexpositor');
					$fecha = $this->input->post('vw_pw_bt_ad_fictxtfecha');
					$hora = $this->input->post('vw_pw_bt_ad_fictxthora');
					$tipo = $this->input->post('vw_pw_bt_ad_cbotipo');
					$grabacion = $this->input->post('vw_pw_bt_ad_fictxtgrabacion');
					$detalle = $this->input->post('vw_pw_bt_ad_detalle');
					$fecha_hora = $fecha.' '.$hora;
					
					$resumen = substr(strip_tags($detalle),0,100);
					date_default_timezone_set ('America/Lima');

					$usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
					
					if ($codigo64 == "0") {
						$rpta = $this->mcapacitaciones->m_insert_capacitacion(array($titulo, $expositor, $fecha_hora, $grabacion, $detalle, $tipo));
						$fictxtaccion = "INSERTAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una capacitación en la tabla TB_CHARLAS COD.".$rpta->newcod;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					} else {
						$rpta = $this->mcapacitaciones->m_update_capacitacion(array($codigo, $titulo, $expositor, $fecha_hora, $grabacion, $detalle, $tipo));
						$fictxtaccion = "EDITAR";
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando una capacitación en la tabla TB_CHARLAS COD.".$rpta->newcod;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					}
            		
            		if ($rpta->salida > 0){
            			$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos registrados correctamente";
						$dataex['destino'] =base_url()."capacitaciones/lista";
            		}
				}
			}
			else{
				$dataex['status'] =FALSE;
				$dataex['msg']    = 'No autorizado';
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}


	public function fn_view_detalle()
	{
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo capacitacion', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$msgrpta = $this->mcapacitaciones->lstcapacitaciones_id(array($codigo));
			$datecap =  new DateTime($msgrpta->fecha);
			$msgrpta->fechacap = $datecap->format('d/m/Y h:i a');
			
		}
		
		$dataex['vdata'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_capacitacion()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
        	if (getPermitido("154")=='SI'){
	            $this->form_validation->set_message('required', '%s Requerido');
	            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
	            $this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');
	            if ($this->form_validation->run() == false) {
	                $dataex['msg'] = validation_errors();
	            } else {
	                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este registro";
	                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));

	                $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
					$fictxtaccion = "ELIMINAR";

					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una capacitación en la tabla TB_CHARLAS COD.".$txtcodigo;
	                
	                $rpta = $this->mcapacitaciones->m_eliminacapacitacion(array($txtcodigo));
	                if ($rpta == 1) {
	                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
	                    $dataex['status'] = true;
	                    $dataex['msg']    = 'Registro eliminado correctamente';
	                }
	            }
        	}
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
	

}
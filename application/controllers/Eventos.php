<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Eventos extends Error_views{

	function __construct(){
		parent::__construct();
		$this->load->helper("url"); 
		$this->load->model("mbolsa");
		$this->load->model("meventos");
		//$this->load->library('pagination');
	}


	function slugs($string)
    {
        $characters = array(
            "Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u",
            "á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u",
            "à" => "a", "è" => "e", "ì" => "i", "ò" => "o", "ù" => "u",
        );

        $string = strtr($string, $characters);
        $string = strtolower(trim($string));
        $string = preg_replace("/[^a-z0-9-]/", "-", $string);
        $string = preg_replace("/-+/", "-", $string);

        if (substr($string, strlen($string) - 1, strlen($string)) === "-") {
            $string = substr($string, 0, strlen($string) - 1);
        }

        return $string;
    }

    public function vw_principal()
	{
		if (getPermitido("55")=='SI'){
			$ahead= array('page_title' =>'EVENTOS - ERP'  );
			$asidebar= array('menu_padre' =>'eventos','menu_hijo' =>'');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$arraydts['eventos'] = $this->meventos->lsteventos();
			$this->load->view('eventos/index', $arraydts);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function vw_agregar()
	{
		if (getPermitido("56")=='SI'){
			$ahead= array('page_title' =>'Agregar Evento - ERP'  );
			$asidebar= array('menu_padre' =>'eventos','menu_hijo' =>'');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$this->load->view('eventos/frm_add_evento');
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function vw_editar()
	{
		if (getPermitido("57")=='SI'){
			$ahead= array('page_title' =>'Editar Evento - ERP'  );
			$asidebar= array('menu_padre' =>'eventos','menu_hijo' =>'');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$txtcod = base64url_decode($this->input->get('idevt'));
			$arraydts['Devent'] = $this->meventos->lsteventos_id(array($txtcod));
			$this->load->view('eventos/update_evento', $arraydts);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
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

	public function fn_insert_datos()
	{
			
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{	
			if (getPermitido("56")=='SI'){

				$this->form_validation->set_message('required', '%s Requerido');

				$this->form_validation->set_rules('vw_pw_bt_ad_fictxttitulo','Título','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxtdesc','Descripción','trim|required');
				$this->form_validation->set_rules('txtFechaEvento','Fecha','trim|required');
				$this->form_validation->set_rules('txtLugarEvento','Lugar','trim|required');
				$this->form_validation->set_rules('txtHora','Hora','trim|required');

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
					$fictxttitulo= $this->input->post('vw_pw_bt_ad_fictxttitulo');
					$ficslug = $this->slugs($this->input->post('vw_pw_bt_ad_fictxttitulo'));
					$fictxtdesc = $this->input->post('vw_pw_bt_ad_fictxtdesc');
					$fecha = $this->input->post('txtFechaEvento');
					$hora = $this->input->post('txtHora');
					$lugar = $this->input->post('txtLugarEvento');
					
					$resumen = substr(strip_tags($fictxtdesc),0,100);
					date_default_timezone_set ('America/Lima');
					$rpta=0;
	                if ($_FILES['vw_pw_bt_ad_fictxtportada']['name']!="") {
	                	$dataex['msg'] = 'Se intento optimizar';
	                	$cnfimg= array('patch' => "upload/eventos", 'alto'=>400, 'ancho'=>800);
	                	$cnfimgth= array('patch' => "upload/eventos/thumb", 'alto'=>50, 'ancho'=>100);
	                	$imgopt=optimiza_img($_FILES['vw_pw_bt_ad_fictxtportada'],$cnfimg,$cnfimgth);

	                	//var_dump($imgopt);
	                	if ($imgopt['status']=true){
	                		$portada = $imgopt['link'];
	                		$rpta = $this->meventos->m_insert_evento(array($fictxttitulo, $ficslug, $fictxtdesc, $resumen, $fecha, $hora, $lugar, $portada));
	                		if ($rpta->salida > 0){
	                			$dataex['status'] =TRUE;
								$dataex['msg'] ="Datos registrados correctamente";
								$dataex['destino'] =base_url()."portal-web/eventos";
	                		}
	                	}
	                	else{
	                		$dataex['msg'] = $imgopt['msg'];
	                	}
	                }
	                else {
	                	$dataex['status'] = FALSE;
	                	$dataex['errimg'] = 'No hay archivo seleccionado';
						$dataex['errorimg'] = FALSE;
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


	public function fn_update_datos()
	{
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			if (getPermitido("57")=='SI'){
				$this->form_validation->set_message('required', '%s Requerido');
				$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
				$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
				$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		

				$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
				$this->form_validation->set_rules('vw_pw_bt_ed_fictxttitulo','titulo','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ed_fictxtdesc','descripcion','trim|required');
				$this->form_validation->set_rules('txt_ed_FechaEvento','Fecha','trim|required');
				$this->form_validation->set_rules('txt_ed_LugarEvento','Lugar','trim|required');
				$this->form_validation->set_rules('txt_ed_Hora','Hora','trim|required');

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
					$dataex['status'] =FALSE;
					$fictxtcodigo= base64_decode($this->input->post('vw_pw_bt_ed_fictxtcodigo'));
					$fictxttitulo= $this->input->post('vw_pw_bt_ed_fictxttitulo');
					$ficslug = $this->slugs($this->input->post('vw_pw_bt_ed_fictxttitulo'));
					$fictxtdesc = $this->input->post('vw_pw_bt_ed_fictxtdesc');
					$resumen = substr(strip_tags($fictxtdesc),0,150);
					$fecha = $this->input->post('txt_ed_FechaEvento');
					$hora = $this->input->post('txt_ed_Hora');
					$lugar = $this->input->post('txt_ed_LugarEvento');
					$fictxtexist=$this->input->post('vw_pw_bt_ed_fictxtexist');
					$ext = $this->input->post('extimg');
					date_default_timezone_set ('America/Lima');
					$nomimage = $this->slugs($fictxttitulo);

	                if ($_FILES['vw_pw_bt_ed_fictxtportada']['name']!="") {
	                	$dataex['msg'] = 'Se intento optimizar';

	                	$pathtodir =  getcwd() ; 
	                	unlink($pathtodir."/upload/eventos/" . $fictxtexist);
	                	unlink($pathtodir."/upload/eventos/thumb/" . $fictxtexist);

	                	$cnfimg= array('patch' => "upload/eventos", 'alto'=>400, 'ancho'=>800);
	                	$cnfimgth= array('patch' => "upload/eventos/thumb", 'alto'=>50, 'ancho'=>100);
	                	$imgopt=optimiza_img($_FILES['vw_pw_bt_ed_fictxtportada'],$cnfimg,$cnfimgth);

	                	//var_dump($imgopt);
	                	if ($imgopt['status']=true){
	                		$portada=$imgopt['link'];
		                	$rpta=$this->meventos->m_update_eventos(array($fictxtcodigo, $fictxttitulo, $ficslug, $fictxtdesc, $resumen, $fecha, $hora, $lugar, $portada));
							if ($rpta == 1){
								$dataex['status'] =TRUE;
								$dataex['destino'] =base_url()."portal-web/eventos";
								$dataex['msg'] ="Datos actualizados correctamente";
								$dataex['errimg'] = '';
								
							}
						}
						else{
	                		$dataex['msg'] = $imgopt['msg'];
	                	}
	                }
	                else {

	                	$rpta=$this->meventos->m_update_eventos(array($fictxtcodigo, $fictxttitulo, $ficslug, $fictxtdesc, $resumen, $fecha, $hora, $lugar, $fictxtexist));
						if ($rpta == 1){
							$dataex['status'] =TRUE;
							$dataex['destino'] =base_url()."portal-web/eventos";
							$dataex['msg'] ="Datos actualizados correctamente";
							$dataex['errimg'] = '';
							
						}
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

	public function fneliminar_evento()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
        	if (getPermitido("58")=='SI'){
	            $this->form_validation->set_message('required', '%s Requerido');
	            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
	            $this->form_validation->set_rules('idEvento', 'codigo', 'trim|required');
	            if ($this->form_validation->run() == false) {
	                $dataex['msg'] = validation_errors();
	            } else {
	                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este registro";
	                $idEvento    = base64url_decode($this->input->post('idEvento'));
	                $imagen    = base64url_decode($this->input->post('ficimage'));
	                
                	$pathtodir =  getcwd() ; 
                	unlink($pathtodir."/upload/eventos/" . $imagen);
                	unlink($pathtodir."/upload/eventos/thumb/" . $imagen);
	                
	                $rpta = $this->meventos->m_eliminaevento(array($idEvento));
	                if ($rpta == 1) {
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
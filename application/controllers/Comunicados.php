<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Comunicados extends Error_views{

	function __construct(){
		parent::__construct();
		$this->load->helper("url"); 
		$this->load->model("mcomunicados");
		$this->load->model('mauditoria');
		//$this->load->library('pagination');
	}


    public function vw_virtual_archivos($id)
    {
        $id=base64url_decode($id);
        $fila=$this->mcomunicados->m_get_item(array($id));

        if (isset($fila->ruta)){
            $fileName = $fila->ruta;
            $filePath = 'upload/comunicados/'.$fileName;
            $partes_ruta = pathinfo($fila->ruta);

            $nombre=url_clear($fila->titulo).".".$partes_ruta['extension'];
            if(!empty($fileName) && file_exists($filePath)){
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$nombre");
                header("Content-Type: fila->tipo");
                header("Content-Transfer-Encoding: binary");
                readfile($filePath);
                exit;
            }
            else{
                header("Location: ".base_url()."no-encontrado");
            }
        }
        else{
            header("Location: ".base_url()."no-encontrado2");
        } 
    }

    public function vw_principal()
	{
		if (getPermitido("73")=='SI'){
			$tipo=$this->input->get('tp');
			$ahead= array('page_title' =>'Comunicados | ERP'  );
			$asidebar= array('menu_padre' =>'comunicados');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$sede = $_SESSION['userActivo']->idsede;
			$items = $this->mcomunicados->m_get_items($sede);
			$this->load->view('comunicados/index', array('items' => $items ));
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function vw_agregar()
	{
		if (getPermitido("74")=='SI'){
			$ahead= array('page_title' =>'Comunicados - Agregar | ERP'  );
			$asidebar= array('menu_padre' =>'comunicados');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$this->load->view('comunicados/vw_agregar');
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function vw_editar($id)
    {
        
        
		if (getPermitido("75")=='SI'){
        	$id=base64url_decode($id);
			$ahead= array('page_title' =>'Comunicados - Editar | ERP'  );
			$asidebar= array('menu_padre' =>'comunicados');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$fila['comun']=$this->mcomunicados->m_get_item(array($id));
			$this->load->view('comunicados/vw_agregar', $fila);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}


	 public function uploadfile(){
        $dataex['link']="";
        $fileTmpLoc   = $_FILES["file"]["tmp_name"]; // File in the PHP tmp folder
        $fileType     = $_FILES["file"]["type"]; // The type of file it is
        $fileSize     = $_FILES["file"]["size"]; // File size in bytes
        $fileErrorMsg = $_FILES["file"]["error"]; // 0 for false... and 1 for true
        $fileNameExt  = $_FILES["file"]["name"];
        $ext          = explode(".", $fileNameExt);
        $extension    = end($ext);
        $NewfileName  = "c".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . $_SESSION['userActivo']->codpersona;
        $arc_temp = pathinfo($fileTmpLoc);

        
        $nomb_temp=url_clear($arc_temp['filename']);
        $nro_rand=rand(0,9);
        $link=$NewfileName.$nomb_temp.$nro_rand.".".$extension;
        $dataex['link'] = "";
        $dataex['temp'] = "";
        $directorio = "./upload/comunicados";
	    if (!file_exists($directorio)) {

            mkdir($directorio, 0755);

        }
        if (move_uploaded_file($fileTmpLoc, "upload/comunicados/$link")) {
            $dataex['link'] = $link;
            $dataex['temp'] = $fileTmpLoc;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }


	public function uploadimages(){
		if ($_FILES['file']['name']) {
			if (!$_FILES['file']['error']) {
			    $name = md5(Rand(100, 200));
			    $ext = explode('.', $_FILES['file']['name']);
			    $filename = $name . '.' . $ext[1];
			    $directorio = "./upload/comunicados";
			    if (!file_exists($directorio)) {

                    mkdir($directorio, 0755);

                }
			    $destination = './upload/comunicados/' . $filename; //change this directory
			    $location = $_FILES["file"]["tmp_name"];
			    move_uploaded_file($location, $destination);
			    echo 'upload/comunicados/' . $filename;
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

	public function fn_guardar()
	{
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{	
			if ((getPermitido("74")=='SI') || (getPermitido("75")=='SI')){

				$this->form_validation->set_message('required', '%s Requerido');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxttitulo','Título','trim|required');
				
				$this->form_validation->set_rules('fictxtaccesos','accesos','trim|required');

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
					$codigo= $this->input->post('vw_pw_bt_ad_fictxtcodigo');
					$titulo= $this->input->post('vw_pw_bt_ad_fictxttitulo');
					$descripcion=$this->input->post('vw_pw_bt_ad_fictxtdesc');
					
					$accesos = $this->input->post('fictxtaccesos');
					
					$datafile= json_decode($_POST['afiles']);
					$link="";
                    $name="";
                    $peso="";
                    $tipofile="";
                    $validar=false;
                    $checkstatus = "NO";
                    $checknew = "NO";
                    $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
                    if ($this->input->post('checkestado')!==null){

                     	$checkstatus = $this->input->post('checkestado');

                	}
                	if ($checkstatus=="on"){

                		$checkstatus = "SI";

                	}

                	if ($this->input->post('checknuevo')!==null){

                     	$checknew = $this->input->post('checknuevo');

                	}
                	if ($checknew=="on"){

                		$checknew = "SI";

                	}
                    foreach ($datafile as $value) {
                        if ($value[4]=="0"){ //si no hay id de detalle
                            if (trim($value[0])==""){
                                
                            }
                            else{
                                if (file_exists ("upload/comunicados/".$value[0])){
                                    $link=$value[0];
                                    $name=$value[1];
                                    $peso=$value[2];
                                    $tipofile=$value[3];
                                    $validar=true;
                                }
                            }    
                        }
                        else{
                        	$link=$value[0];
                            $name=$value[1];
                            $peso=$value[2];
                            $tipofile=$value[3];
                            $validar=true;
                        }
                    }
					date_default_timezone_set ('America/Lima');
					$rpta=0;
	        		
	        		if ($codigo=="0"){
	        			$rpta=$this->mcomunicados->m_insert(array($titulo, $descripcion, $name, $link, $peso, $tipofile, $checknew, $checkstatus, $sede,$accesos));
	        			$accion = "INSERTAR";
	        			$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando un comunicado en la tabla TB_COMUNICADOS COD.".$rpta->nid;
	        		}
	        		else{
	        			$rpta=$this->mcomunicados->m_update(array(base64url_decode($codigo),$titulo, $descripcion, $name, $link,$peso,$tipofile, $checknew, $checkstatus, $accesos));
	        			$accion = "EDITAR";
	        			$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un comunicado en la tabla TB_COMUNICADOS COD.".base64url_decode($codigo);
	        		}
	        		
	        		if ($rpta->salida==1){

						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
	        			$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos registrados correctamente";
						$dataex['redirect'] =base_url()."gestion/comunicados";
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

	public function fn_delete_file(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                
                $dataex['status'] = false;
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $codigo    = base64url_decode($this->input->post('codigo'));
                $this->mcomunicados->m_update_delfile(array($codigo));
                $dataex['status'] =true;
                if ("" !== $this->input->post('link')){
                    $link    = $this->input->post('link');
                    $pathtodir =  getcwd() ; 
                    if (file_exists($pathtodir."/upload/comunicados/".$link )) unlink($pathtodir."/upload/comunicados/".$link );
                }
            }
            else{
                $dataex['msg']    = 'No estas autorizado';
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_delete()
    {
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
        	$dataex['msg'] = "Sin Permiso";
        	if (getPermitido("76")=='SI'){
	            if ($_SESSION['userActivo']->tipo != 'AL'){
	                
	                $dataex['status'] = false;
	                $urlRef           = base_url();
	                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
	                $codigo    = base64url_decode($this->input->post('codigo'));
	                $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
					$accion = "ELIMINAR";
	        		$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un comunicado en la tabla TB_COMUNICADOS COD.".$codigo;

	                $fila=$this->mcomunicados->m_get_item(array($codigo));
	                if (isset($fila->codigo)){
	                	$this->mcomunicados->m_delete(array($codigo));
	                	$dataex['status'] =true;
		                if ("" !== $fila->ruta){
		                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
		                    $link    = $fila->ruta;
		                    $pathtodir =  getcwd() ; 
		                    if (file_exists($pathtodir."/upload/comunicados/".$link )) unlink($pathtodir."/upload/comunicados/".$link );
		                }
	                }
	                
	                
	            }
	           
	        }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
	

}
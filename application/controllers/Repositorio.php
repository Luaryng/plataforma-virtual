<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';

class Repositorio extends Error_views{

	function __construct(){
		parent::__construct();
		$this->load->helper("url"); 
		$this->load->model("mrepositorio");
		$this->load->model('mcategoria_transparencia');
		//$this->load->library('pagination');
	}


    public function vw_virtual_archivos($area,$id)
    {
        $area=base64url_decode($area);
        $id=base64url_decode($id);
        $fila=$this->mrepositorio->m_get_item(array($id,$area));

        if (isset($fila->ruta)){
            $fileName = $fila->ruta;
            $filePath = 'upload/docweb/'.$fileName;
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
		if (getPermitido("62")=='SI'){
			$tipo=$this->input->get('pi');
			$ahead= array('page_title' =>'Repositorio de proyectos de investigación | ERP'  );
			$asidebar= array('menu_padre' =>'repositorio');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$items=array();
			if ($tipo!="")  $items= $this->mrepositorio->m_get_items(array($tipo,'PI','%'));
			$items = $this->mrepositorio->m_get_items(array($tipo,'PI','%'));
			$categorias = $this->mcategoria_transparencia->m_filtrar_categorias_activasxtipo(array('PI'));
			$this->load->view('repositorio/index', array('items' => $items, 'categorias' => $categorias ));
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function fn_search_data()
	{
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			$dataex['status']=false;
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$busqueda = $this->input->post('cbocategoria');
			$titulo = $this->input->post('fictxttitulo');
			if ($titulo == "") {
				$titulo = "%";
			}
			$rstdata = $this->mrepositorio->m_get_items(array($busqueda,'PI','%'.$titulo.'%'));
			if (count($rstdata) > 0) {
                $dataex['status'] = true;
                $rsdata['items'] = $rstdata;
                $datos = $this->load->view('repositorio/result_data', $rsdata, true);
            } else {
            	$datos = $this->load->view('errors/sin-resultados',array(),TRUE);
            }
								
			
		}
		$dataex['vdata'] = $datos;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));

	}

	public function vw_agregar()
	{
		if (getPermitido("64")=='SI'){
			$ahead= array('page_title' =>'Repositorio de proyectos de investigación - Agregar | ERP'  );
			$asidebar= array('menu_padre' =>'repositorio');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$arraydts['categorias'] =$this->mcategoria_transparencia->m_filtrar_categorias_activasxtipo(array('PI'));
			$this->load->view('repositorio/vw_agregar', $arraydts);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function vw_editar($area,$id)
    {
        
        
		if (getPermitido("63")=='SI'){
			$area=base64url_decode($area);
        	$id=base64url_decode($id);
			$ahead= array('page_title' =>'Repositorio de proyectos de investigación - Editar | ERP'  );
			$asidebar= array('menu_padre' =>'repositorio');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$fila['mat']=$this->mrepositorio->m_get_item(array($id,$area));
			$fila['categorias'] =$this->mcategoria_transparencia->m_filtrar_categorias_activasxtipo(array('PI'));
			$this->load->view('repositorio/vw_agregar', $fila);
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
        $NewfileName  = "t".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . $_SESSION['userActivo']->codpersona;
        $arc_temp = pathinfo($fileTmpLoc);

        
        $nomb_temp=url_clear($arc_temp['filename']);
        $nro_rand=rand(0,9);
        $link=$NewfileName.$nomb_temp.$nro_rand.".".$extension;
        $dataex['link'] = "";
        $dataex['temp'] = "";
        if (move_uploaded_file($fileTmpLoc, "upload/docweb/$link")) {
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
			    $destination = './resources/img/bolsa_trabajo/' . $filename; //change this directory
			    $location = $_FILES["file"]["tmp_name"];
			    move_uploaded_file($location, $destination);
			    echo 'resources/img/bolsa_trabajo/' . $filename;
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
			if (getPermitido("56")=='SI'){

				$this->form_validation->set_message('required', '%s Requerido');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxttitulo','Título','trim|required');
				
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxtorden','N° Orden','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_cbotiposp','Categoría','trim|required');

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
					$titulo= $this->input->post('vw_pw_bt_ad_fictxttitulo');
					$codigo= $this->input->post('vw_pw_bt_ad_fictxtcodigo');
					$categoria = $this->input->post('vw_pw_bt_ad_cbotiposp');
					$torden=$this->input->post('vw_pw_bt_ad_fictxtorden');
					$descripcion=$this->input->post('vw_pw_bt_ad_fictxtdesc');
					$area=base64url_decode($this->input->post('vw_pw_bt_ad_fictxttipo'));
					$datafile= json_decode($_POST['afiles']);
					$link="";
                    $name="";
                    $peso="";
                    $tipofile="";
                    $validar=false;
                    foreach ($datafile as $value) {
                        if ($value[4]=="0"){ //si no hay id de detalle
                            if (trim($value[0])==""){
                                
                            }
                            else{
                                if (file_exists ("upload/docweb/".$value[0])){
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
	        		//@vwd_titulo, @vwd_descripcion, @vwd_ruta, @vwd_peso, @vwd_tipofile, @vwd_categoria, @vwd_orden, @vwd_area
	        		if ($codigo=="0"){
	        			$rpta=$this->mrepositorio->m_insert(array($titulo, $descripcion, $link,$peso,$tipofile, $categoria, $torden,$area));
	        		}
	        		else{
	        			$rpta=$this->mrepositorio->m_update(array(base64url_decode($codigo),$titulo, $descripcion, $link,$peso,$tipofile, $categoria, $torden,$area));
	        		}
	        		
	        		if ($rpta->salida==1){
	        			$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos registrados correctamente";
						$dataex['redirect'] =base_url()."portal-web/repositorio?pi=$categoria";
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
                $this->mrepositorio->m_update_delfile(array($codigo));
                $dataex['status'] =true;
                if ("" !== $this->input->post('link')){
                    $link    = $this->input->post('link');
                    $pathtodir =  getcwd() ; 
                    if (file_exists($pathtodir."/upload/docweb/".$link )) unlink($pathtodir."/upload/docweb/".$link );
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
        	if (getPermitido("65")=='SI'){
	            if ($_SESSION['userActivo']->tipo != 'AL'){
	                
	                $dataex['status'] = false;
	                $urlRef           = base_url();
	                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
	                $codigo    = base64url_decode($this->input->post('codigo'));
	                $area    = base64url_decode($this->input->post('area'));
	                $fila=$this->mrepositorio->m_get_item(array($codigo,$area));
	                if (isset($fila->codigo)){
	                	$this->mrepositorio->m_delete(array($codigo));
	                	$dataex['status'] =true;
		                if ("" !== $fila->ruta){
		                    $link    = $fila->ruta;
		                    $pathtodir =  getcwd() ; 
		                    if (file_exists($pathtodir."/upload/docweb/".$link )) unlink($pathtodir."/upload/docweb/".$link );
		                }
	                }
	                
	                
	            }
	           
	        }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
	

}
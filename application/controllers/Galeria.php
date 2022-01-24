<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';

class Galeria extends Error_views{
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		
		$this->load->helper("url"); 
		$this->load->model("mtransparencia");
		$this->load->model('mcategoria_transparencia');
		$this->load->model("mgaleria");
	}

	public function index()
	{
		if (getPermitido("115")=='SI'){
			$tipo=$this->input->get('tp');
			$ahead= array('page_title' =>'Galeria | '.$this->ci->config->item('erp_title'));
			$asidebar= array('menu_padre' =>'galeria');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$arraydt['album'] = $this->mgaleria->m_get_album();
			$this->load->view('galeria/listado', $arraydt);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function vw_agregar()
	{
		if (getPermitido("116")=='SI'){
			$ahead= array('page_title' =>'Agregar álbum | '.$this->ci->config->item('erp_title'));
			$asidebar= array('menu_padre' =>'galeria');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$fila['fotos'] = array();
			$this->load->view('galeria/vw_agregar_album',$fila);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function vw_editar($id)
    {
		if (getPermitido("117")=='SI'){
        	$id=base64url_decode($id);
			$ahead= array('page_title' =>'Editar álbum - Editar | '.$this->ci->config->item('erp_title'));
			$asidebar= array('menu_padre' =>'galeria');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$fila =$this->mgaleria->m_get_data_albumxcodigo(array($id));
			$this->load->view('galeria/vw_agregar_album', $fila);
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
        $NewfileName  = "gal".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . $_SESSION['userActivo']->codpersona;
        $arc_temp = pathinfo($fileTmpLoc);

        
        $nomb_temp=url_clear($arc_temp['filename']);
        $nro_rand=rand(0,9);
        $link=$NewfileName.$nomb_temp.$nro_rand.".".$extension;
        $dataex['link'] = "";
        $dataex['temp'] = "";

        $dataex['msg'] = 'Se intento optimizar';
	    $cnfimg= array('patch' => "upload/galeria", 'alto'=>400, 'ancho'=>800);
	    $cnfimgth= array('patch' => "upload/galeria/thumb", 'alto'=>200, 'ancho'=>250);
	    $imgopt=optimiza_img($_FILES["file"],$cnfimg,$cnfimgth,$link);
	    $dataex['imagen'] = $imgopt;

	    if ($imgopt['status'] = true) {
	    	$dataex['link'] = $imgopt['link'];
	    	$dataex['temp'] = $fileTmpLoc;
	    }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_delete_file(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                
                $dataex['status'] = false;
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $codigo    = $this->input->post('codigo');
                $this->mgaleria->m_update_delfilefot(array($codigo));
                $dataex['status'] =true;
                if ("" !== $this->input->post('link')){
                    $link    = $this->input->post('link');
                    $pathtodir =  getcwd() ; 
                    if (file_exists($pathtodir."/upload/galeria/".$link )) unlink($pathtodir."/upload/galeria/".$link );
                    if (file_exists($pathtodir."/upload/galeria/thumb/".$link )) unlink($pathtodir."/upload/galeria/thumb/".$link );
                }
            }
            else{
                $dataex['msg']    = 'No estas autorizado';
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_insert_album()
	{
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{	
			if (getPermitido("116")=='SI'){

				$this->form_validation->set_message('required', '%s Requerido');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxttitulo','Título','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxtslug','Url álbum','trim|required');

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
					$url=$this->input->post('vw_pw_bt_ad_fictxtslug');
					$descripcion=$this->input->post('vw_pw_bt_ad_fictxtdesc');
					$datafile= json_decode($_POST['afiles']);
					$link="";
                    $name="";
                    $peso="";
                    $tipofile="";
                    $validar=false;

					date_default_timezone_set ('America/Lima');
					$rpta=0;
	        		
	        		if ($codigo=="0"){
	        			$rpta=$this->mgaleria->m_insert_album(array($titulo, $url, $descripcion));
	        		}
	        		else{
	        			$rpta=$this->mgaleria->m_update_album(array(base64url_decode($codigo),$titulo, $url, $descripcion));
	        		}
	        		
	        		if ($rpta->salida==1){
	        			foreach ($datafile as $value) {
	        				$dataex['valor'] = $value[4] ;
	                        if ($value[4]=="0"){ //si no hay id de detalle
	                            if (trim($value[0])==""){
	                                
	                            }
	                            else{
	                                if (file_exists ("upload/galeria/".$value[0])){
	                                    $link=$value[0];
	                                    $name=$value[1];
	                                    $peso=$value[2];
	                                    $tipofile=$value[3];
	                                    $rpta2 = $this->mgaleria->m_insert_fotos(array($rpta->nid,$value[1],$value[0],$value[2],$value[3]));
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
	        			$dataex['status'] =TRUE;
						$dataex['msg'] ="Álbum registrados correctamente";
						$dataex['redirect'] =base_url()."portal-web/galeria/editar/".base64url_encode($rpta->nid);
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

	public function fn_delete()
    {
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
        	$dataex['msg'] = "Sin Permiso";
        	if (getPermitido("118")=='SI'){
	            if ($_SESSION['userActivo']->tipo != 'AL'){
	                
	                $dataex['status'] = false;
	                $urlRef           = base_url();
	                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
	                $codigo    = base64url_decode($this->input->post('codigo'));
	                $fila=$this->mgaleria->m_get_data_albumxcodigo(array($codigo));
	                $galeria = $fila['fotos'];

                	$rpta = $this->mgaleria->m_deletealbum(array($codigo));
                	if ($rpta == 1) {
                		foreach ($galeria as $key => $value) {
		                	if (isset($value->idfoto)){
			                	
			                	$dataex['status'] =true;
			                	$dataex['msg'] = "Álbum eliminado correctamente";
				                if ("" !== $value->link){
				                    $link    = $value->link;
				                    $pathtodir =  getcwd() ; 
				                    if (file_exists($pathtodir."/upload/galeria/".$link )) unlink($pathtodir."/upload/galeria/".$link );
				                    if (file_exists($pathtodir."/upload/galeria/thumb/".$link )) unlink($pathtodir."/upload/galeria/thumb/".$link );
				                }
			                }
		                }
                	}
	                
	            }
	           
	        }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
	

}
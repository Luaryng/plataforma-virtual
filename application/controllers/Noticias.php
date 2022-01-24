<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noticias extends CI_Controller {

	public function __construct()
    {
    	parent::__construct();
        //$this->load->helper("url");
        $this->load->model('mnoticia');
    }


	public function index()
	{

		if (getPermitido("69")=='SI'){
			$ahead= array('page_title' =>'Noticias - ERP'  );
			$asidebar= array('menu_padre' =>'mn_noticias');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$arraynot['noticias'] = $this->mnoticia->m_lst_noticias();
			$this->load->view('noticias/lista_noticias', $arraynot);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}


	}

	public function vw_crear()
	{

		if (getPermitido("70")=='SI'){
			$ahead= array('page_title' =>'Noticias - ERP'  );
			$asidebar= array('menu_padre' =>'mn_noticias');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			//$arraynot['noticias'] = $this->mnoticia->m_lst_noticias();
			$this->load->view('noticias/nueva_noticia');
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
			    $filename = $name . '.' . $ext[1];
			    $destination = './upload/noticias/' . $filename; //change this directory
			    $location = $_FILES["file"]["tmp_name"];
			    move_uploaded_file($location, $destination);
			    echo './upload/noticias/' . $filename;
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

	public function fn_insert_datosnotic()
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
			
			$this->form_validation->set_rules('fictxttitulo','titulo','trim|required');
			$this->form_validation->set_rules('fictxtdescripcion','descripcion','trim|required');
			$this->form_validation->set_rules('fictxtfecha','fecha','trim|required');
			$this->form_validation->set_rules('fictxthora','hora','trim|required');

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
				$fictxttitulo= $this->input->post('fictxttitulo');
				$ficslug = slugs($this->input->post('fictxttitulo'));
				$fictxtdescripcion=$this->input->post('fictxtdescripcion');
				$resumen = substr(strip_tags($fictxtdescripcion), 0, 400);
				$fictxtfecha=$this->input->post('fictxtfecha');
				$fictxthora=$this->input->post('fictxthora');
				$ext = $this->input->post('extimg');
				date_default_timezone_set ('America/Lima');
				$nomimage = slugs($fictxttitulo).date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext;;

				if ($_FILES['fictxtport']['name']!="") {
                	$dataex['msg'] = 'Se intento optimizar';
                	$cnfimg= array('patch' => "upload/noticias", 'alto'=>400, 'ancho'=>800);
                	$cnfimgth= array('patch' => "upload/noticias/thumb", 'alto'=>200, 'ancho'=>250);
                	$imgopt=optimiza_img($_FILES['fictxtport'],$cnfimg,$cnfimgth,$nomimage);

                	//var_dump($imgopt);
                	if ($imgopt['status']=true){
                		$portada=$imgopt['link'];
                		$dataex['msg'] = 'Se optimizó';
                		$rpta=$this->mnoticia->m_insert_noticias(array($fictxttitulo, $ficslug, $fictxtdescripcion, $resumen, $fictxtfecha, $fictxthora, $portada));
	                	if ($rpta->salida=="1"){
	                		$dataex['status'] =TRUE;
							$dataex['msg'] ="Datos registrados correctamente";
							$dataex['destino'] =base_url()."portal-web/noticias";
	            		}
                	}
                	else{
                		$dataex['msg'] = $imgopt['msg'];
                	}
                }
                else {
                	$dataex['msg'] ="Se requiere una imagen de Portada";
				
                }



			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}


	public function update_noticias()
	{

		if (getPermitido("71")=='SI'){
			$ahead= array('page_title' =>'Noticias - ERP'  );
			$asidebar= array('menu_padre' =>'mn_noticias');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_portal',$asidebar);
			$txtcod = base64url_decode($this->input->get('idnot'));
			$arrayhs['dnoticia'] = $this->mnoticia->m_lst_noticiasxcodigo(array($txtcod));
			$this->load->view('noticias/editar_noticia', $arrayhs);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}


	}

	public function fn_update_datosnotic()
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
			
			$this->form_validation->set_rules('fictxtid','codigo','trim|required');
			$this->form_validation->set_rules('fictxttitulo','titulo','trim|required');
			$this->form_validation->set_rules('fictxtdescripcion','descripcion','trim|required');

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
				$fictxtid = base64url_decode($this->input->post('fictxtid'));
				$fictxttitulo= $this->input->post('fictxttitulo');
				$ficslug = slugs($this->input->post('fictxttitulo'));
				$fictxtdescripcion=$this->input->post('fictxtdescripcion');
				$fictxtimgexist = $this->input->post('fictxtimgexist');
				$resumen = substr(strip_tags($fictxtdescripcion), 0, 100);
				$ext = $this->input->post('extimg');
				date_default_timezone_set ('America/Lima');
				//$nomimage = slugs($fictxttitulo);
				//$rstimage = str_replace(' ', '-', $nomimage);
				$config = [
                    "upload_path"   => "./upload/noticias",
                    'allowed_types' => "png|jpg|JPG|jpeg|JPEG",
                    'file_name' => $ficslug.date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext,
                ];

                $this->load->library("upload", $config);

                if ($this->upload->do_upload('fictxtport')) {
                	$registro = $this->mnoticia->m_captura_imgxcodigo($fictxtid);
                    unlink("./resources/img/noticias/" . $registro->imgp);
                	$data  = array("upload_data" => $this->upload->data());
                	$portada = $ficslug.date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext;
                	$rpta=$this->mnoticia->m_update_noticias(array($fictxtid, $fictxttitulo, $ficslug, $fictxtdescripcion, $resumen, $portada));
					if ($rpta > 0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Noticia actualizada correctamente";
						
					}
                } else {
                	$rpta=$this->mnoticia->m_update_noticias(array($fictxtid, $fictxttitulo, $ficslug, $fictxtdescripcion, $resumen, $fictxtimgexist));
					if ($rpta > 0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Noticia actualizada correctamente";
						
					}
                }

			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminar_noticia()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
        	if (getPermitido("71")=='SI'){
				$this->form_validation->set_message('required', '%s Requerido');
	            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
	            $this->form_validation->set_rules('idnoti', 'codigo noticia', 'trim|required');
	            if ($this->form_validation->run() == false) {
	                $dataex['msg'] = validation_errors();
	            } else {
	                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta noticia";
	                $idnoti    = base64url_decode($this->input->post('idnoti'));
	                $registro = $this->mnoticia->m_captura_imgxcodigo($idnoti);
	                unlink("./upload/noticias/" . $registro->imgp);
	                $rpta = $this->mnoticia->m_delete_noticia(array($idnoti));
	                if ($rpta == 1) {
	                    $dataex['status'] = true;
	                    $dataex['msg']    = 'Noticia eliminada correctamente';
	                }

	            }
			}
			else{
				 $dataex['msg'] = 'No cuenta con el permiso necesario';
			}
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));

        


    }

    /*public function blog_noticias()
	{
		$ahead= array('page_title' =>'Noticias | IESTP - HUARMACA');
		// $asidebar= array('menu_padre' =>'noticias','menu_hijo' =>'newnoti');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		// $this->load->view('admin/sidebar_admin',$asidebar);
		$arraynt['dnoticia'] = $this->mnoticia->m_lst_noticias();
		$arraynt['vermas'] = $this->mnoticia->m_lst_noticiasxmas();
		$this->load->view('noticias/index',$arraynt);
		$this->load->view('footer');
	}*/

	/*public function detalle_not($codigo, $slugnot)
	{
		$dtsnoti = $this->mnoticia->m_lst_noticiasxslug(array(base64url_decode($codigo), $slugnot));
		if (@count($dtsnoti) == 1) {
			$arraynts['dtsnoticia'] = $dtsnoti;
			$arraymeta = array('ruta' =>base_url().'noticias/detalle/'.base64url_encode($dtsnoti->id).'/'.$dtsnoti->slug,'ruta_img' =>'https://erp.iestphuarmaca.edu.pe/resources/img/noticias/'.$dtsnoti->imgp, 'titulo' => $dtsnoti->titulo, 'descripcion' => strip_tags($dtsnoti->detalle), 'dominio' => 'iestphuarmaca.edu.pe');
			$ahead['datosmeta'] = $this->load->view('meta', $arraymeta, true);
			$ahead= $ahead + array('page_title' => $dtsnoti->titulo . ' | IESTP - HUARMACA');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$arrayde['denoticia'] = $dtsnoti;
			$arrayde['vermas'] = $this->mnoticia->m_lst_noticiasxmas();
			$this->load->view('noticias/detalle_noticia',$arrayde);
		} else {
			$ahead= array('page_title' =>'PÁGINA NO ENCONTRADA | IESTP - HUARMACA');
		    $this->load->view('head',$ahead);
		    $this->load->view('nav');
		    $this->load->view('error404');
		}
		
		$this->load->view('footer');
	}*/
}

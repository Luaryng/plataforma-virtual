<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Banner extends CI_Controller {



	public function __construct()

    {

    	parent::__construct();

        $this->load->model('mbanner');
        $this->load->model('mauditoria');

    }





	public function index()

	{

		$ahead= array('page_title' =>'BANNER | ERP'  );

		$asidebar= array('menu_padre' =>'banner','menu_hijo' =>'');

		$this->load->view('head',$ahead);

		$this->load->view('nav');

		$this->load->view('sidebar_portal',$asidebar);

		$datos['banner'] = $this->mbanner->m_dtsbanner();

		$this->load->view('banner/banner_listado', $datos);

		$this->load->view('footer');

	}



	public function vw_agregar()

	{

		$ahead= array('page_title' =>'Agregar banner | ERP'  );

		$asidebar= array('menu_padre' =>'banner','menu_hijo' =>'');

		$this->load->view('head',$ahead);

		$this->load->view('nav');

		$this->load->view('sidebar_portal',$asidebar);

		$this->load->view('banner/add_banner');

		$this->load->view('footer');

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

			

			$this->form_validation->set_rules('fictxtaccion','accion','trim|required');

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

				$fictxtidslide = base64url_decode($this->input->post('fictxtidslide'));

				$fictitulo= $this->input->post('fictitulo');

				$ficdescrip = $this->input->post('fictxtdesc');

				$fictextboton = $this->input->post('fictextboton');

				$ficurlboton = $this->input->post('ficurlboton');

				$fictxtaccion = $this->input->post('fictxtaccion');

				$imgexist = $this->input->post('fictxtimageexist');

				$ext = $this->input->post('extimg');

				date_default_timezone_set ('America/Lima');

				$nomimage = "banner-";//slugs($fictitulo);

				$nomcarp = "banner";

                $directorio = "./upload/".$nomcarp;

                $aleatorio = mt_rand(100,999);

                $checkstatus = "NO";

                $checkboton = "NO";

                $usuario = $_SESSION['userActivo']->idusuario;

				$sede = $_SESSION['userActivo']->idsede;

                if ($this->input->post('checkestado')!==null){

                     $checkstatus = $this->input->post('checkestado');

                }

                if ($this->input->post('checkboton')!==null){

                     $checkboton = $this->input->post('checkboton');

                }

                if ($checkstatus=="on"){

                	$checkstatus = "SI";

                }

                if ($checkboton=="on"){

                	$checkboton = "SI";

                }

                if (!file_exists($directorio)) {

                    mkdir($directorio, 0755);

                }

				$config = [

                    "upload_path"   => "./upload/".$nomcarp,

                    'allowed_types' => "png|jpg|JPG|jpeg|JPEG",

                    'file_name' => $nomimage.$aleatorio.date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext,

                ];



                $this->load->library("upload", $config);



                if ($fictxtaccion == "INSERTAR") {

                	if ($this->upload->do_upload('fictxtimagen')) {

	                	$data  = array("upload_data" => $this->upload->data());

	                	$portada = $nomimage.$aleatorio.date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext;

	                	

	                	$config2['image_library'] = 'gd2';

	                    $config2['source_image'] =  './upload/'.$nomcarp.'/'.$portada;

	                    $config2['new_image'] = './upload/'.$nomcarp.'/'.$portada;

	                    $config2['create_thumb'] = FALSE;

	                    $config2['maintain_ratio'] = FALSE;

	                    $config2['quality'] = '80%';

	                    $config2['width'] = 1280;

	                    $config2['height'] = 450;

	                    $this->load->library('image_lib', $config2);

	                    $this->image_lib->resize();



	                	$rpta = $this->mbanner->mInsert_banner(array($fictitulo, $ficdescrip, $checkboton, $fictextboton, $ficurlboton, $portada, $checkstatus));
						if ($rpta > 0){

							$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando un banner en la tabla TB_BANNER COD.".$rpta;

							$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

							$dataex['status'] =TRUE;

							$dataex['msg'] ="Banner ingresado correctamente";

							$dataex['errimg'] = '';

							

						}

	                } else {

	                	$dataex['errimg'] = "No seleccionaste un archivo para cargar.";

	                }

                } 

                else if ($fictxtaccion == "EDITAR") {

                	if ($this->upload->do_upload('fictxtimagen')) {

                		$registro = $this->mbanner->m_captura_imgxcodigo($fictxtidslide);

                    	unlink("./upload/banner/" . $registro->imagen);

	                	$data  = array("upload_data" => $this->upload->data());

	                	$portada = $nomimage.$aleatorio.date("d") . date("m") . date("Y") . date("H") . date("i") .".".$ext;

	                	

	                	$config3['image_library'] = 'gd2';

	                    $config3['source_image'] =  './upload/'.$nomcarp.'/'.$portada;

	                    $config3['new_image'] = './upload/'.$nomcarp.'/'.$portada;

	                    $config3['create_thumb'] = FALSE;

	                    $config3['maintain_ratio'] = FALSE;

	                    $config3['quality'] = '80%';

	                    $config3['width'] = 1280;

	                    $config3['height'] = 450;

	                    $this->load->library('image_lib', $config3);

	                	$this->image_lib->resize();

	                	$rpta=$this->mbanner->mUpdate_banner(array($fictxtidslide, $fictitulo, $ficdescrip, $checkboton, $fictextboton, $ficurlboton, $portada, $checkstatus));

						if ($rpta == TRUE){

							$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un banner en la tabla TB_BANNER COD.".$fictxtidslide;

							$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

							$dataex['status'] =TRUE;

							$dataex['msg'] ="Banner actualizado correctamente";

							$dataex['errimg'] = '';

							
						}

	                } else {

	                	$rpta=$this->mbanner->mUpdate_banner(array($fictxtidslide, $fictitulo, $ficdescrip, $checkboton, $fictextboton, $ficurlboton, $imgexist, $checkstatus));

						if ($rpta == TRUE){

							$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un banner en la tabla TB_BANNER COD.".$fictxtidslide;

							$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

							$dataex['status'] =TRUE;

							$dataex['msg'] ="Banner actualizado correctamente";

							$dataex['errimg'] = '';

						}

	                }

                }

			}

		}

		header('Content-Type: application/x-json; charset=utf-8');

		echo json_encode($dataex);

	}

	public function vw_editar($codigo)

	{

		$ahead= array('page_title' =>'Editar Banner | ERP'  );

		$asidebar= array('menu_padre' =>'banner','menu_hijo' =>'');

		$this->load->view('head',$ahead);

		$this->load->view('nav');

		$this->load->view('sidebar_portal',$asidebar);

		$arraydts['banner'] = $this->mbanner->m_bannerxcodigo(base64url_decode($codigo));

		$this->load->view('banner/update_banner', $arraydts);

		$this->load->view('footer');

	}



	public function fneliminar_banner()

    {

        $dataex['status'] = false;

        $dataex['msg']    = '¿Que intentas? .|.';

        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');

            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('idBanner', 'codigo banner', 'trim|required');

            if ($this->form_validation->run() == false) {

                $dataex['msg'] = validation_errors();

            } else {

                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este banner";

                $idBanner    = base64url_decode($this->input->post('idBanner'));

                $imagen    = base64url_decode($this->input->post('imgBanner'));

                $usuario = $_SESSION['userActivo']->idusuario;

				$sede = $_SESSION['userActivo']->idsede;

				$fictxtaccion = "ELIMINAR";

                unlink("./upload/banner/".$imagen);

                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un banner en la tabla TB_BANNER COD.".$idBanner;

				

                $rpta = $this->mbanner->m_eliminabanner(array($idBanner));

                if ($rpta == 1) {
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;

                    $dataex['msg']    = 'Banner eliminado correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');

        echo (json_encode($dataex));

    }

	

}


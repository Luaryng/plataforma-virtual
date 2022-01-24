<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';


class Slider extends Error_views {
	private $ci;
	public function __construct()

    {

    	parent::__construct();
    	$this->ci=& get_instance();
        $this->load->model('mbanner');
        $this->load->model('mslider');
        $this->load->model('mauditoria');

    }





	public function index()

	{
		if (getPermitido("119")=='SI'){
			$ahead= array('page_title' =>'SLIDER | '.$this->ci->config->item('erp_title')  );

			$asidebar= array('menu_padre' =>'slider','menu_hijo' =>'');

			$this->load->view('head',$ahead);

			$this->load->view('nav');

			$this->load->view('sidebar_portal',$asidebar);

			$datos['slider'] = $this->mslider->m_slider();

			$this->load->view('sliders/slider_listado', $datos);

			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}

	}



	public function vw_agregar()

	{
		if (getPermitido("120")=='SI'){
			$ahead= array('page_title' =>'Agregar slider | '.$this->ci->config->item('erp_title')  );

			$asidebar= array('menu_padre' =>'slider','menu_hijo' =>'');

			$this->load->view('head',$ahead);

			$this->load->view('nav');

			$this->load->view('sidebar_portal',$asidebar);

			$datos['order'] = $this->mslider->m_slider_orden();

			$this->load->view('sliders/add_slider', $datos);

			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}

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

				$fictxtaccion = $this->input->post('fictxtaccion');

				$imgexist = $this->input->post('fictxtimageexist');

				$orden = $this->input->post('fictxtorden');

				date_default_timezone_set ('America/Lima');

				// $nomimage = "slider-";//slugs($fictitulo);

				$nomcarp = "slider";

                $directorio = "./upload/".$nomcarp;

                $aleatorio = mt_rand(100,999);

                $checkstatus = "NO";

                $usuario = $_SESSION['userActivo']->idusuario;

				$sede = $_SESSION['userActivo']->idsede;

				$exten = explode('.', $_FILES['fictxtimagen']['name']);
		        $ult=count($exten);
		        $nro_rand=rand(0,9);
		        $nro_rand2=rand(0,100);
		        $NewfileName  = "sld".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$nro_rand2;
		        $filename = $NewfileName.".".$exten[$ult-1];//. '.' . $ext[1];

		        

                if ($this->input->post('checkestado')!==null){

                     $checkstatus = $this->input->post('checkestado');

                }

                if ($checkstatus=="on"){

                	$checkstatus = "SI";

                }

                if (!file_exists($directorio)) {

                    mkdir($directorio, 0755);

                }

				$config = [

                    "upload_path"   => "./upload/".$nomcarp,

                    'allowed_types' => "png|jpg|JPG|jpeg|JPEG",

                    'file_name' => $filename,

                ];



                $this->load->library("upload", $config);


                if ($fictxtaccion == "INSERTAR") {

                	if ($this->upload->do_upload('fictxtimagen')) {

	                	$data  = array("upload_data" => $this->upload->data());

	                	$portada = $filename;

	                	$rpta = $this->mslider->mInsert_slider(array($portada, $checkstatus,$orden));
						if ($rpta > 0){

							$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando un slider en la tabla TB_SLIDER COD.".$rpta;

							$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

							$dataex['status'] =TRUE;

							$dataex['msg'] ="Slider ingresado correctamente";

							$dataex['errimg'] = '';
							

						}

	                } else {

	                	$dataex['errimg'] = "No seleccionaste un archivo para cargar.";

	                }

                } 

                else if ($fictxtaccion == "EDITAR") {

                	if ($this->upload->do_upload('fictxtimagen')) {

                		// $registro = $this->mslider->m_captura_imgxcodigo($fictxtidslide);

                    	unlink("./upload/slider/" . $imgexist);

	                	$data  = array("upload_data" => $this->upload->data());

	                	$portada = $filename;

	                	$rpta=$this->mslider->mUpdate_slider(array($fictxtidslide, $portada, $checkstatus));

						if ($rpta == TRUE){

							$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un slider en la tabla TB_SLIDER COD.".$fictxtidslide;

							$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

							$dataex['status'] =TRUE;

							$dataex['msg'] ="Slider actualizado correctamente";

							$dataex['errimg'] = '';

							
						}

	                } else {

	                	$rpta=$this->mslider->mUpdate_slider(array($fictxtidslide, $imgexist, $checkstatus));

						if ($rpta == TRUE){

							$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un slider en la tabla TB_SLIDER COD.".$fictxtidslide;

							$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

							$dataex['status'] =TRUE;

							$dataex['msg'] ="Slider actualizado correctamente";

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
		if (getPermitido("121")=='SI'){
			$ahead= array('page_title' =>'Editar Slider | '.$this->ci->config->item('erp_title')  );

			$asidebar= array('menu_padre' =>'slider','menu_hijo' =>'');

			$this->load->view('head',$ahead);

			$this->load->view('nav');

			$this->load->view('sidebar_portal',$asidebar);

			$arraydts['slider'] = $this->mslider->m_sliderxcodigo(base64url_decode($codigo));

			$this->load->view('sliders/update_slider', $arraydts);

			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}

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
	                $rpta = $this->mslider->m_ordenar_slide($dataUpdate);
	                //var_dump($dataex['ids']);
	                $dataex['status'] = true;

	            }
	            $dataex['destino'] = $urlRef;
	            header('Content-Type: application/x-json; charset=utf-8');
	            echo (json_encode($dataex));
	        }
            
        }
    }



	public function fneliminar_slider()
    {

        $dataex['status'] = false;

        $dataex['msg']    = '¿Que intentas? .|.';

        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');

            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';

            if (getPermitido("122")=='SI'){

	            $this->form_validation->set_rules('idSlider', 'codigo slider', 'trim|required');

	            if ($this->form_validation->run() == false) {

	                $dataex['msg'] = validation_errors();

	            } else {

	                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este slider";

	                $idSlider    = base64url_decode($this->input->post('idSlider'));

	                $imagen    = base64url_decode($this->input->post('imgSlider'));

	                $usuario = $_SESSION['userActivo']->idusuario;

					$sede = $_SESSION['userActivo']->idsede;

					$fictxtaccion = "ELIMINAR";

	                unlink("./upload/slider/".$imagen);

	                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un slider en la tabla TB_SLIDER COD.".$idSlider;

					

	                $rpta = $this->mslider->m_eliminaslider(array($idSlider));

	                if ($rpta == 1) {
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
	                    $dataex['status'] = true;

	                    $dataex['msg']    = 'Slider eliminado correctamente';

	                }

	            }
	        }

        }

        header('Content-Type: application/x-json; charset=utf-8');

        echo (json_encode($dataex));

    }

	

}


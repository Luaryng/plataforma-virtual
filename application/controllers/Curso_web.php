<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curso_web extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mcurso_web');
		$this->load->model('mauditoria');
		$this->load->model("mcarrera");
		$this->load->model("mtemporal");
		$this->load->model("mubigeo");
		$this->load->model("msede");
	}
	
	public function vw_principal(){
		$ahead= array('page_title' =>'PROGRAMA | '.$this->ci->config->item('erp_title')  );
		$asidebar= array('menu_padre' =>'mn_cursos');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_formacion_continua',$asidebar);
		$a_datos['cursos'] =$this->mcurso_web->m_get_cursos(array($_SESSION['userActivo']->idsede));
		$this->load->view('cursosweb/vw_carw_principal', $a_datos);
		$this->load->view('footer');
	}

	public function vw_agregar(){
		$ahead= array('page_title' =>'AGREGAR CURSO | '.$this->ci->config->item('erp_title'));
		$asidebar= array('menu_padre' =>'mn_cursosw','menu_hijo' =>'cursos');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_formacion_continua',$asidebar);
		$vcodsede=$_SESSION['userActivo']->idsede;
		$this->load->view('cursosweb/vw_carw_mantenimiento');
		$this->load->view('footer');
	}

	public function vw_editar($vcodcar){
		$ahead= array('page_title' =>'EDITAR CURSO | '.$this->ci->config->item('erp_title'));
		$asidebar= array('menu_padre' =>'mn_cursosw','menu_hijo' =>'cursos');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_formacion_continua',$asidebar);
		$vcodcar=base64url_decode($vcodcar);
		$vcodsede=$_SESSION['userActivo']->idsede;
		$a_datos['curso'] =$this->mcurso_web->m_get_curso(array($vcodcar,$vcodsede));
		$this->load->view('cursosweb/vw_carw_mantenimiento', $a_datos);
		$this->load->view('footer');
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

	public function uploadfile(){
        $dataex['link']="";
        $fileTmpLoc   = $_FILES["file"]["tmp_name"]; // File in the PHP tmp folder
        $fileType     = $_FILES["file"]["type"]; // The type of file it is
        $fileSize     = $_FILES["file"]["size"]; // File size in bytes
        $fileErrorMsg = $_FILES["file"]["error"]; // 0 for false... and 1 for true
        $fileNameExt  = $_FILES["file"]["name"];
        $ext          = explode(".", $fileNameExt);
        $extension    = end($ext);
        $NewfileName  = "co".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . $_SESSION['userActivo']->codpersona;
        $arc_temp = pathinfo($fileTmpLoc);

        
        $nomb_temp=url_clear($arc_temp['filename']);
        $nro_rand=rand(0,9);
        $link=$NewfileName.$nomb_temp.$nro_rand.".".$extension;
        $dataex['link'] = "";
        $dataex['temp'] = "";
        if (move_uploaded_file($fileTmpLoc, "upload/cursoweb/$link")) {
            $dataex['link'] = $link;
            $dataex['temp'] = $fileTmpLoc;
            $dataex['urlimg'] = "upload/cursoweb/$link";
            $dataex['identif'] = $nomb_temp.$nro_rand;
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
                
                $dataex['status'] =true;
                if ("" !== $this->input->post('image')){
                    $link    = $this->input->post('image');
                    
                    $pathtodir =  getcwd() ; 
                    if (file_exists($pathtodir.'/'.$link )) unlink($pathtodir.'/'.$link );
                    
                }
            }
            else{
                $dataex['msg']    = 'No estas autorizado';
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_guardar()
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
			
			$this->form_validation->set_rules('vw_ptpe_txt_titulo','Titulo','trim|required');
			$this->form_validation->set_rules('vw_ptpe_txt_url','URL','trim|required');
			/*$this->form_validation->set_rules('vw_ptpe_txt_presentacion','Presentación','trim|required');
			$this->form_validation->set_rules('vw_ptpe_txt_contenido','Contenido','trim|required');*/

			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$dataex['msg2']=validation_errors();
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$dataex['status'] =FALSE;
				$vptitulo=$this->input->post('vw_ptpe_txt_titulo');
				$vpurl = slugs($this->input->post('vw_ptpe_txt_url'));
				$vppresenta=$this->input->post('vw_ptpe_txt_presentacion');
				$vpduracion=$this->input->post('vw_ptpe_txt_duracion');
				$vprequisitos=$this->input->post('vw_ptpe_txt_requisitos');
				$vpcontenido=$this->input->post('vw_ptpe_txt_contenido');
				$vpcodigo=$this->input->post('vw_ptpe_txt_codigo');
				$galeria = $this->input->post('vw_galeria');
				$checkstatus = 'NO';

				if ($this->input->post('checkestado')!==null){

                     $checkstatus = $this->input->post('checkestado');

                }

                if ($checkstatus=="on"){

                	$checkstatus = "SI";

                }
				
				if ($vpcodigo=="0"){
					$rpta=$this->mcurso_web->m_insert_curso(array($vptitulo, $vpurl, $vppresenta, $vpduracion, $vprequisitos, $vpcontenido, $galeria, $_SESSION['userActivo']->idsede, $checkstatus));
				}
				else{
					$rpta=$this->mcurso_web->m_update_curso(array(base64url_decode($vpcodigo),$vptitulo, $vpurl, $vppresenta, $vpduracion, $vprequisitos, $vpcontenido, $galeria, $_SESSION['userActivo']->idsede, $checkstatus));
				}
				
				if ($rpta->salida=="1"){
            		$dataex['status'] =TRUE;
					$dataex['msg'] ="Datos registrados correctamente";
        		}

			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminar_curso()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idcurso', 'codigo área', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este área";
                $idcurso    = base64url_decode($this->input->post('idcurso'));
                $vgaleria = $this->input->post('galeria');

                $galeria = json_decode($vgaleria, true);
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un curso en la tabla TB_CURSO_ONLINE COD.".$idcurso;
				
                $rpta = $this->mcurso_web->m_elimina_curso(array($idcurso));
                if ($rpta == 1) {
                	foreach ($galeria as $key => $value) {
                		$pathtodir =  getcwd() ; 
                    	if (file_exists($pathtodir.'/'.$value )) unlink($pathtodir.'/'.$value );
                	}

                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Curso eliminado correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function vw_lista_inscripcion()
    {
    	date_default_timezone_set('America/Lima');
		$ahead= array('page_title' =>'LISTADO PRE-MATRÍCULA | '.$this->ci->config->item('erp_title'));
		$asidebar= array('menu_padre' =>'mn_inscripciones','menu_hijo' =>'preinscripcioncurso');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_formacion_continua', $asidebar);
		$idsede = $_SESSION['userActivo']->idsede;
		$arraydts['cursos'] = $this->mcurso_web->m_get_cursos(array($idsede));
		$databuscar=array('%', '%', '%');
		$arraydts['historial'] = $this->mcurso_web->m_dtsPreinscripcioncursoxfechas( $databuscar );
		$this->load->view('cursosweb/listado',$arraydts);
		$this->load->view('footer');
    }

    public function get_filtrar_historial_curso()
	{
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rspreinsc = "";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
				$busqueda = $this->input->post('txtapenombres');
				$carrera = $this->input->post('cboprograma');
				$estado = $this->input->post('cboestado');

				$fechaini = $this->input->post('txtfecha');
				$fechafin = $this->input->post('txtfechafin');

				
				$databuscar=array('%'.$busqueda.'%', $carrera, $estado);
				if ($fechaini != "" && $fechafin != "") {
					$horaini = ' 00:00:01';
					$horafin = ' 23:59:59';
					$databuscar[]=$fechaini.$horaini;
					$databuscar[]=$fechafin.$horafin;
				}
				elseif ($fechaini == "" && $fechafin == "") {
					/*$fechaini='1990-01-01 00:00:01';
					$fechafin=date("Y-m-d").' 23:59:59';*/
				}
				elseif ($fechaini == "") {
					$fechaini='1990-01-01 00:00:01';
					$fechafin=$fechafin.' 23:59:59';
					$databuscar[]=$fechaini;
					$databuscar[]=$fechafin;
				}
				else{
					$fechaini=$fechaini.' 00:00:01';
					$fechafin=date("Y-m-d").' 23:59:59';
					$databuscar[]=$fechaini;
					$databuscar[]=$fechafin;
				}
			
				$preinsc['historial'] = $this->mcurso_web->m_dtsPreinscripcioncursoxfechas( $databuscar );
				
				$rspreinsc = $this->load->view('cursosweb/dtshistorial_prcur',$preinsc,TRUE);
				
				$dataex['status'] = TRUE;
			
		}
		$dataex['vdata'] = $rspreinsc;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_view_archivos_adjuntos_cursos()
    {
    	$dataex['status'] = false;
        $dataex['msg']    = "No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');

        if ($this->input->is_ajax_request()) {
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'Cod. Pre Inscripción', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } 
            else {
                $seg = base64url_decode($this->input->post('txtcodigo'));
                $dataex['status'] = true;
                $arraytip = $this->mcurso_web->m_get_ficha_preinscripcioncurso($seg);
                $dataex['vdata'] = $this->load->view('cursosweb/vw_ver_ficha_pre_cur_ajax', $arraytip, true);
                $dataex['estado'] = $arraytip['ficha']->estado;
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function vw_aprobar_preinscripcion_curso()
    {
    	date_default_timezone_set('America/Lima');
		
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
        	if (getPermitido("56")=='SI'){

        	}
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede aprobar esta preinscripción";
                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));

                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "EDITAR";
                $estado = "INSCRITO";
                
                $rpta = $this->mcurso_web->fn_update_estado_preinscripcion_curso(array($txtcodigo, $estado, $usuario));

                if ($rpta->salida == '1') {
                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", aprobó una preinscripción en la tabla TB_PRE_INSCRIPCION_CURSOS COD.".$rpta->nid;

                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));

                	$rptasg = $this->mcurso_web->m_insert_seguimiento_curso(array($txtcodigo, $estado, "APROBADO POR: ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres, date("Y-m-d"), date("H:i:s")));

                	if ($auditoria > 0) {
                		
	                    $dataex['status'] = true;
	                    $dataex['msg']    = 'Pre Inscripción aprobado correctamente';
                	}
                }
                
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_search_seguimiento()
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
			
			$codigo = base64url_decode($this->input->post('txtcodigo'));

			$rstdata = $this->mcurso_web->m_filtrar_seguimiento_curso(array($codigo));
			if (@count($rstdata) > 0) {
                $dataex['status'] = true;
                $rsdata['seguimiento'] = $rstdata;
                $datos = $this->load->view('cursosweb/data_seguimiento', $rsdata, true);
            } else {
            	$dataex['status'] = false;
            	$datos = "NO HAY DATOS DEL SEGUIMIENTO";
            }
								
			
		}
		$dataex['vdata'] = $datos;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));

	}

	public function fn_insert_seguimiento()
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
			
			$this->form_validation->set_rules('fictxtcodigo','Codigo','trim|required');
			$this->form_validation->set_rules('cboficestado','Estado','trim|required');
			$this->form_validation->set_rules('fictxtobserv','Observación','trim|required');
			$this->form_validation->set_rules('fictxtfecha','Fecha','trim|required');
			$this->form_validation->set_rules('fictxthora','Hora','trim|required');
			

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
				
				$codigo = base64url_decode($this->input->post('fictxtcodigo'));
				$estado = $this->input->post('cboficestado');
				$observacion = $this->input->post('fictxtobserv');
				$fecha = $this->input->post('fictxtfecha');
				$hora = $this->input->post('fictxthora');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				$rpta = $this->mcurso_web->m_insert_seguimiento_curso(array($codigo, $estado, $observacion, $fecha, $hora));
				if ($rpta->salida==1){
					$accion = "INSERTAR";
	        		$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando un seguimimiento en la tabla TB_DETALLE_PREINSCRIPCION COD.".$rpta->nid;
	        		$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));

					$dataex['status'] = TRUE;
					$dataex['msg'] ="Datos guardados correctamente";
					
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

    public function fn_eliminar()
	{
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta preinscripción";
                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));

                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "ELIMINAR";
                
                $rptfile = $this->mcurso_web->m_archivos_adjuntos_preincursos(array($txtcodigo));

                $rpta = $this->mcurso_web->delete_preinscripcion_cursos(array($txtcodigo));

                if ($rpta->salida == 1) {
                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una preinscripción en la tabla TB_PRE_INSCRIPCION_CURSOS COD.".$rpta->nid;

                	if (count($rptfile) > 0) {
	                	foreach ($rptfile as $key => $value) {
	                		$rptafile = $this->mcurso_web->m_elimina_archivo_preincursos(array($rpta->nid));
	                		
	                		if (file_exists ("upload/cursoweb/tmp/".$value->link)){

		                		unlink("./upload/cursoweb/tmp/".$value->link);
		                		
		                	}

		                	if (file_exists ("upload/cursoweb/".$value->link)) {

		                		unlink("./upload/cursoweb/".$value->link);
		                	}
	                	}
	                }

                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                	if ($auditoria > 0) {
                		
	                    $dataex['status'] = true;
	                    $dataex['msg']    = 'Pre Inscripción eliminado correctamente';
                	}
                	
                    
                }
                
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}

	public function vw_ficha_pre_inscripcion()
	{
		date_default_timezone_set('America/Lima');
		$ahead= array('page_title' =>'Inscripción Formación Continua | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mn_inscripciones','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_formacion_continua', $asidebar);
		
		$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
		$arraydts['departamentos'] = $this->mubigeo->m_departamentos();
		$arraydts['adjuntos'] = "0";
		$this->load->model('miestp');
        $arraydts['ies']=$this->miestp->m_get_datos();
        $dominio=str_replace(".", "_",getDominio());
		$this->load->view("cursosweb/vw_ficha_pre_matricula_web_$dominio", $arraydts);


		
		$this->load->view('footer');
	}

	public function vw_update_ficha_pre_inscripcion($codigo)
	{
		date_default_timezone_set('America/Lima');
		$ahead= array('page_title' =>'Inscripción Formación Continua - EDITAR | '.$this->ci->config->item('erp_title')  );
		$asidebar= array('menu_padre' =>'mn_inscripciones','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_formacion_continua', $asidebar);
		
		$arraydts = $this->mcurso_web->m_get_ficha_preinscripcioncurso(base64url_decode($codigo));
		
		$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
		$arraydts['departamentos'] = $this->mubigeo->m_departamentos();
		
		$this->load->model('miestp');
        $arraydts['ies']=$this->miestp->m_get_datos();
        $dominio=str_replace(".", "_",getDominio());
		$this->load->view("cursosweb/vw_ficha_pre_matricula_web_$dominio", $arraydts);
		
		$this->load->view('footer');
	}

    public function vw_pre_inscripcion()
    {
    	date_default_timezone_set('America/Lima');

		$arraydts= array('page_title' =>'Inscripción Formación Continua | '.$this->ci->config->item('erp_title'));
		$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
		$arraydts['departamentos'] = $this->mubigeo->m_departamentos();
		$arraydts['adjuntos'] = "0";
		$this->load->model('miestp');
        $arraydts['ies']=$this->miestp->m_get_datos();
        //$dominio=str_replace(".", "_",getDominio());
		$this->load->view("cursosweb/vw_ficha_pre_matricula_web_cascara", $arraydts);
    }

    public function fn_cursos_sedes()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin opciones</option>";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodigosed','Búsqueda','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda = $this->input->post('txtcodigosed');

				$cursos = $this->mcurso_web->m_get_cursos(array($busqueda));

				if (count($cursos)>0) $rsoptions="<option value=''>* Seleccione Curso</option>";
				foreach ($cursos as $cur) {
					$rsoptions=$rsoptions."<option value='$cur->codcurso'>$cur->titulo</option>";
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rsoptions;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_upload_file_externo(){
        $dataex['status'] = false;
        $dataex['msg'] = 'Sin Archivo';
        if ($_FILES['vw_mpc_file']['name']) {
            if (!$_FILES['vw_mpc_file']['error']) {
                $name = $_FILES['vw_mpc_file']['name'];//md5(Rand(100, 200));
                $ext = explode('.', $_FILES['vw_mpc_file']['name']);
                $ult=count($ext);
                $nro_rand=rand(0,9);
                $nro_rand2=rand(0,100);
                $NewfileName  = "picw_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$nro_rand2;
                $filename = $NewfileName.".".$ext[$ult-1];//. '.' . $ext[1];
                
                $destination = './upload/cursoweb/tmp/' .$filename ; //change this directory
                $location = $_FILES["vw_mpc_file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                
                $dataex['msg'] = 'Archivo subido correctamente';
                $dataex['link'] = $filename;
                $dataex['status'] = true;

                
            }
            else {
                $dataex['msg'] = 'Se ha producido el siguiente error:  '.$_FILES['vw_mpc_file']['error'];
            }
        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_delete_file_web()
    {
    	$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este banner";
                $codigo64 = $this->input->post('txtcodigo');
                $codigo    = base64url_decode($codigo64);
                $link    = $this->input->post('archivo');

                if ($codigo64 != "0") {
                	$usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
					$fictxtaccion = "ELIMINAR";

	                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un archivo en la tabla TB_PRE_INSCRIPCION_CURSOS_ARCHIVOS COD.".$codigo;
                	$rpta = $this->mcurso_web->m_elimina_archivo_preincursos(array($codigo));
                } else {
                	$rpta = 1;
                }
                
                if ($rpta == 1) {
                	if (file_exists ("upload/cursoweb/tmp/".$link)){

                		unlink("./upload/cursoweb/tmp/".$link);
                		
                	}

                	if (file_exists ("upload/cursoweb/".$link)) {

                		unlink("./upload/cursoweb/".$link);
                	}
                	
                	if ($codigo64 != "0") {
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					}

                    $dataex['status'] = true;
                    $dataex['msg']    = 'archivo eliminado correctamente';
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_insert()
	{
		$this->form_validation->set_message('required', '* {field} Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('regex_match', '* {field} no es válido');
		
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$this->form_validation->set_rules('txt_sede','Sede','trim|required');
			$this->form_validation->set_rules('cbocurso','Programa','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('txtape_paterno','Apellidos paterno','trim|required');
			$this->form_validation->set_rules('txtape_materno','Apellidos materno','trim|required');
			$this->form_validation->set_rules('txtnombres','Nombres','trim|required');
			$this->form_validation->set_rules('txt_tpdoc','Tipo documento','trim|required');
			$this->form_validation->set_rules('txtdni','N° documento','trim|required');
			$this->form_validation->set_rules('txt_fecnac','Fecha de Nacimiento','trim|required|regex_match[/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/]');
			$this->form_validation->set_rules('txt_genero','Género','trim|required');
			$this->form_validation->set_rules('txttelefono','Teléfono','trim|required');
			//$this->form_validation->set_rules('txtcorreo','Correo electrónico','trim|required');
			$this->form_validation->set_rules('txt_departamento','Departamento','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('txt_provincia','Provincia','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('txt_distrito','Distrito','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('txt_direccion','Dirección','trim|required');
			$this->form_validation->set_rules('txtestcivil','Estado Civil','trim|required');
			

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

				$dataex['msg']="No hay errores de campos";
				$dataex['status'] =FALSE;
				

				$codigo64 = $this->input->post('fictxtcodigo_pre');
				$codigo = base64url_decode($codigo64);
				$sede = $this->input->post('txt_sede');
				$curso = $this->input->post('cbocurso');
				$paterno = $this->input->post('txtape_paterno');
				$materno = $this->input->post('txtape_materno');
				$nombres = $this->input->post('txtnombres');
				$tipodoc = $this->input->post('txt_tpdoc');
				$documento = $this->input->post('txtdni');
				$genero = $this->input->post('txt_genero');
				$fecnacim = $this->input->post('txt_fecnac');
				$estadociv = $this->input->post('txtestcivil');
				$telefono = $this->input->post('txttelefono');
				$correo = $this->input->post('txtcorreo');

				$distrito = $this->input->post('txtnomdistrito') . " - " . $this->input->post('txtnomprovin') . " - " . $this->input->post('txtnomdepart');
				$direccion = $this->input->post('txt_direccion');

				$coddistrito = $this->input->post('txt_distrito');
				
				$fecha_explode = explode("/", $fecnacim);

				if (checkdate($fecha_explode[1], $fecha_explode[0], $fecha_explode[2])==true){
					$dataex['msg']="Prueba de fecha superada";
					// $sede = "0";
					
					$fecnacim_mysql=$fecha_explode[2]."-".$fecha_explode[1]."-".$fecha_explode[0];
					
					if ($codigo64 == "0") {
						$rpta = $this->mcurso_web->insert_datos_prematricula_curso(array($paterno, $materno, $nombres, $tipodoc, $documento, $fecnacim_mysql, $genero, $estadociv, $telefono, $correo, $curso, $sede, $distrito, $direccion, $coddistrito));

						$crudaccion = "INSERTAR";
					} else {
						$rpta = $this->mcurso_web->update_datos_prematricula_curso(array($codigo, $paterno, $materno, $nombres, $tipodoc, $documento, $fecnacim_mysql, $genero, $estadociv, $telefono, $correo, $curso, $sede, $distrito, $direccion, $coddistrito));

						$crudaccion = "EDITAR";
					}

					if ($rpta->salida=='1'){
						$data          = json_decode($_POST['vw_mpc_archivos']);
		                $pathtodir =  getcwd() ; 
		                $allfiles=true;
		                foreach ($data as $key => $fl) {

		                	if (!file_exists ("upload/cursoweb/".$fl[0])){
		                		$rptafil = $this->mcurso_web->insert_archivos_curso(array($rpta->nid,$fl[4],$fl[0],$fl[1],$fl[2],$fl[3]));

		                		if ($rptafil->salida=="1"){
			                        $link=$fl[0];
			                        $copied = copy($pathtodir."/upload/cursoweb/tmp/".$link  , $pathtodir."/upload/cursoweb/".$link);
			                        
			                        if ((!$copied)) 
			                        {
			                            $allfiles=false;
			                        }

			                    }
		                	}
		                    
		                    
		                }

		                $enviar_mail=false;
		                if ($enviar_mail==true){
		                    $this->load->model('miestp');
		                    $iestp=$this->miestp->m_get_datos();
		                    $solicitud = $this->mmesa_partes->m_solo_solicitud_x_codigo($seg);
		                    
		                    $rut =$rpta->nid;

		                    $d_destino=array();
		                    $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
		                    //$d_destino=array($iestp->email);
		                    $correo=trim($solicitud->email_personal);
		                    if ($correo!=""){
		                        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
		                            $d_destino[]=$correo;
		                            //$r_respondera=array($correo,$nombres);
		                        }
		                    }
		                    $correo=trim($solicitud->email_corporativo);
		                    if ($correo!=""){
		                        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
		                            $d_destino[]=$correo;
		                            //$r_respondera=array($correo,$nombres);
		                        }
		                    }

		                    $r_respondera=array();
		                    if (count($d_destino)>0){
		                        //$d_destino=array($_SESSION['userActivo']->ecorporativo,"istpublicohuarmaca@hotmail.com");
		                        
		                        $d_mensaje=$this->load->view('emails/vw_notificar_tramite', array('ies'=> $iestp,'mensaje'=>$descp ),true);
		                        
		                         foreach ($data as $key => $fl) {
		                            /*,$('#vw_mpc_txt_filename').html(),1
		                            $('#vw_mpc_txt_size').html(),2
		                            $('#vw_mpc_txt_type').html(),3
		                            $('#vw_mpc_txt_titulo').val()]4*/
		                           $pruebas_email[]=array($pathtodir."/upload/tramites/".$fl[0]  , 'attachment',$fl[1]);    
		                        }
		                    }
		                    //$rsp_denunciante=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email);
		                    //sleep(5);
		                    $rsp_iesap=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email,$r_respondera);
		                    /*foreach ($data as $key => $fl) {
		                        $link=$fl[0];
		                        unlink($pathtodir."/upload/tramites/tmp/".$link );
		                    };*/
		                    $dataex['msg']="Su Trámite fue enviado con éxito";
		                    //$dataex['status'] =true;
		                }

		                if ($allfiles==true){
		                    $dataex['status'] = true;
		                    $dataex['msg'] ="Datos enviados correctamente";
		                    $dataex['accion'] = $crudaccion;
		                }

						//$dataex['status'] = TRUE;
						
						
					}
				}
				else{

					$dataex['errors']= array('txt_fecnac' => 'Fecha incorrecta' );
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function ficha_pdf(){
		
        if ($this->input->get("cmt")!==null){
        	$codmat64=$this->input->get("cmt");
        	$codigo_deco=base64url_decode($codmat64);
	        $this->load->model('miestp');
	        $ie=$this->miestp->m_get_datos();
	        $this->load->model('mcurso_web');
	        $insc1=$this->mcurso_web->m_get_ficha_inscripcion_pdf(array($codigo_deco));
	        if (isset($insc1->codpre)){
	                $dominio=str_replace(".", "_",getDominio());
	                $html1=$this->load->view('cursosweb/impresion/rp_fichainscripcion_'.$dominio, array('ies' => $ie,'ins' => $insc1,),true);
	                
	                $pdfFilePath = "BN-".$insc1->paterno." ".$insc1->materno." ".$insc1->nombres." - ".$insc1->carrera.".pdf";
	                //echo "$html1";
	                $this->load->library('M_pdf');
	                //p=normal
	                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => "A4",'orientation' => 'P']); 
	                $mpdf->SetTitle( "BN- $insc1->paterno $insc1->materno $insc1->nombres - $insc1->ciclol");
	                $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.1,array(50,70),array(80,40));
	                $mpdf->showWatermarkImage  = true;
	                $mpdf->shrink_tables_to_fit = 1;
	                $mpdf->WriteHTML($html1);
	                $mpdf->Output($pdfFilePath, "I");
	           	
	        }
       	}
		
	}
	
}
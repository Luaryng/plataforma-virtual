<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Persona extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mpersona');
	}

	public function index(){
		$ahead= array('page_title' =>'Persona | ERP'  );
		$asidebar= array('menu_padre' =>'rrhh','menu_hijo' =>'mn_rh_ficha');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->model('mubigeo');
		$ubigeo['departamentos'] = $this->mubigeo->m_departamentos();
		$ubigeo['paises'] = $this->mubigeo->m_paises();
		$this->load->view('admision/ficha-personal-docente',$ubigeo);
		$this->load->view('footer');
	}

	public function fn_guardar_foto_propia(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
        	$dataex['msg'] = "Error ";
            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_rules('link','Foto','trim|required');
            if ($this->form_validation->run() == FALSE){
		        $resultado['msg']=validation_errors();
			}
			else{
				$dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
				$codpersona    = $_SESSION['userActivo']->codpersona;
                $link    = base64url_decode($this->input->post('link'));
                $rpta=0;
                $data=array($link,$codpersona);
                if ($codpersona>0){
                    $pathtodir =  getcwd() ; 
                    $copied = copy($pathtodir."/resources/fotos/tmp/".$link  , $pathtodir."/resources/fotos/".$link);
					if ((!$copied)) 
					{
					    $dataex['msg']="No se pudo actualizar la imagen";
					}
					else
					{ 
						
					    $dataex['msg']="Se actualizó su imagen de perfil";
					    
					    $rpta = $this->mpersona->m_cambiar_foto($data);
					    $dataex['msg']=$rpta;
					    //if ($rpta==1){
					    	$dataex['msg']="Se actualizó correctamente su imagen de perfil";
					    	$dataex['status'] =true;
					    	$dataex['link'] =$link;
					    	$_SESSION['userActivo']->foto=$link;
					    	unlink($pathtodir."/resources/fotos/tmp/".$link );
					    //}
					}
                    
                    
                }
			}
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_upload_foto_propia(){
		$dataex['link']="";
		if(isset($_FILES['file'])){
			//Funciones optimizar imagenes
			//Ruta de la carpeta donde se guardarán las imagenes
			$patch='resources/fotos/tmp';
			//Parámetros optimización, resolución máxima permitida
			$max_ancho = 250;
			$max_alto = 300;
			if($_FILES['file']['type']=='image/png' || $_FILES['file']['type']=='image/jpeg' || $_FILES['file']['type']=='image/gif'){
				$dataex['msg'] = "Ocurrio un error al subir la imagen";
				$medidasimagen= getimagesize($_FILES['file']['tmp_name']);

				$fileNameExt  = $_FILES["file"]["name"];
		        $ext          = explode(".", $fileNameExt);
		        $extension    = end($ext);

				$nombrearchivo  = $_SESSION['userActivo']->codpersona.".".$extension;
				//Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
				$copiado=false;
				if($medidasimagen[0] < $max_ancho && $_FILES['file']['size'] < 200000){
					//$nombrearchivo=$_FILES['file']['name'];
					move_uploaded_file($_FILES['file']['tmp_name'], $patch.'/'.$nombrearchivo);
					$copiado=true;
				}
				//Si no, se generan nuevas imagenes optimizadas
				else {
					$dataex['msg'] = "Ocurrio un error al optiizar la imagen";
					//$nombrearchivo=$_FILES['file']['name'];
					//Redimensionar
					$rtOriginal=$_FILES['file']['tmp_name'];
					if($_FILES['file']['type']=='image/jpeg'){
						$original = imagecreatefromjpeg($rtOriginal);
					}
					else if($_FILES['file']['type']=='image/png'){
						$original = imagecreatefrompng($rtOriginal);
					}
					else if($_FILES['file']['type']=='image/gif'){
						$original = imagecreatefromgif($rtOriginal);
					}
					list($ancho,$alto)=getimagesize($rtOriginal);
					$x_ratio = $max_ancho / $ancho;
					$y_ratio = $max_alto / $alto;
					if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
						$ancho_final = $ancho;
						$alto_final = $alto;
					}
					elseif (($x_ratio * $alto) < $max_alto){
						$alto_final = ceil($x_ratio * $alto);
						$ancho_final = $max_ancho;
					}
					else{
						$ancho_final = ceil($y_ratio * $ancho);
						$alto_final = $max_alto;
					}
					$lienzo=imagecreatetruecolor($ancho_final,$alto_final);
					imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
					//imagedestroy($original);
					$cal=8;
					
					if($_FILES['file']['type']=='image/jpeg'){
						$copiado=imagejpeg($lienzo,$patch."/".$nombrearchivo);
					}
					else if($_FILES['file']['type']=='image/png'){
						$copiado=imagepng($lienzo,$patch."/".$nombrearchivo);
					}
					else if($_FILES['file']['type']=='image/gif'){
						$copiado=imagegif($lienzo,$patch."/".$nombrearchivo);
					}
				}
		        
		        if ($copiado) {
		        	$dataex['msg'] = "Imagen en servidor";
		            $dataex['link'] = base64url_encode($nombrearchivo);
		        }
			}
			else {
				$dataex['msg'] = "Solo se aceptan imágenes";
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}

	public function fn_delete_upload_foto(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
          
               if ("" !== $this->input->post('link')){
                        $link    = base64url_decode($this->input->post('link'));
                        $pathtodir =  getcwd() ; 
                        unlink($pathtodir."/resources/fotos/tmp/".$link );
                        $dataex['status'] =true;
                    }
                    else{
                        $dataex['status'] =true;
                    }
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_getdatosminimos_x_dni()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$fila= array('idpersona' => '0');
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('ficodpostulante','Nro Postulante','trim|required|min_length[4]');
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
				$busqueda=$this->input->post('ficodpostulante');
				$rsfila=$this->mpersona->m_get_datosminimos_x_dni(array($busqueda));
				$dataex['status'] =TRUE;
				if (!is_null($rsfila)){
					$rsfila->idpersona=base64url_encode($rsfila->idpersona);
					$fila=$rsfila;
				}
			}
		}
		$dataex['vdata'] =$fila;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_get_datos_personales()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		//$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fidpid','Identifcador','trim|required');

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
				$fidpid=$this->input->post('fidpid');
				$decofidpid=base64url_decode($fidpid);
				$fila=$this->mpersona->get_datos_personales(array($decofidpid));
				if (isset($fila)) {
					$dataex['status'] =TRUE;
					$fila->idpersona=$fidpid;


					//BUSCAR UBIGEO
					$this->load->model('mubigeo');
					$rsprov="<option value='0'>Sin opciones</option>";
					$provincias=$this->mubigeo->m_provincias(array($fila->coddepartamento));
					if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
					foreach ($provincias as $provincia) {
						$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
					}

					$rsdistri="<option value='0'>Sin opciones</option>";
					$distritos=$this->mubigeo->m_distritos(array($fila->codprovincia));
					if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
					foreach ($distritos as $distrito) {
						$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
					}

				}

				$dataex['vdata']=$fila;
				$dataex['provincias']=$rsprov;
				$dataex['distritos']=$rsdistri;
				
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	//00248676


	public function fn_insert_datos_personales()
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
			
			$this->form_validation->set_rules('ficbtipodoc','Tipo Identif.','trim|required|exact_length[3]');

			$this->form_validation->set_rules('fitxtdni','Número','trim|required|min_length[8]|max_length[15]|is_natural|is_unique[tb_persona.per_dni]');
			$this->form_validation->set_rules('fitxtapelpaterno','Ap. Paterno','trim|required|min_length[3]|max_length[80]');
			$this->form_validation->set_rules('fitxtapelmaterno','Ap. Materno','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('fitxtnombres','Nombres','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('ficbsexo','Sexo','trim|required|alpha|in_list[MASCULINO,FEMENINO]');
			//$this->form_validation->set_rules('fitxtfechanac','Fec. Nac.','trim|required');
			$this->form_validation->set_rules('fitxtcelular','Celular','trim|min_length[9]');
			$this->form_validation->set_rules('fitxttelefono','Teléfono','trim|min_length[6]');
			$this->form_validation->set_rules('fitxtdomicilio','Domicilio','trim|required');
			//$this->form_validation->set_rules('fitcbpais','Domicilio','trim|required');
			$this->form_validation->set_rules('ficbdistrito','Distrito','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fitxtdomiciliootro','Domicilio secundario','trim');
			$this->form_validation->set_rules('ficbpais','Pais','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficblenguas','Lengua Originaria','trim|required|is_natural_no_zero');

			$statustrab = $this->input->post('ficbstatrab');
			if ($statustrab == "SI") {
				$this->form_validation->set_rules('fitxtlugartrab','Empresa /Institución donde labora','trim|required');
			}

			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				// $dataex['msg']=validation_errors();
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$dataex['status'] =FALSE;
				
				$ficbtipodoc=$this->input->post('ficbtipodoc');
				$fitxtdni=$this->input->post('fitxtdni');
				$fitxtcodinstitucional=$fitxtdni;
				$fitxtapelpaterno=strtoupper($this->input->post('fitxtapelpaterno'));
				$fitxtapelmaterno=strtoupper($this->input->post('fitxtapelmaterno'));
				$fitxtnombres=strtoupper($this->input->post('fitxtnombres'));
				$ficbsexo=$this->input->post('ficbsexo');
				$ficestadocivil=$this->input->post('ficbestcivil');
				$fitxtfechanac=$this->input->post('fitxtfechanac');
				$fitxtlugarnac=$this->input->post('fitxtlugarnac');
				$fitxtcelular=$this->input->post('fitxtcelular');
				$fitxtcelular2=($this->input->post('fitxtcelular2')!==null)? $this->input->post('fitxtcelular2') : "";
				$fitxttelefono=$this->input->post('fitxttelefono');
				$fitxtemailpersonal=$this->input->post('fitxtemailpersonal');
				$fitxtcolegiosec=$this->input->post('fitxtcolsecund');
				$fitxtlugartrab=$this->input->post('fitxtlugartrab');
				$fitxtappatmatpa=$this->input->post('fitxtapelpatmatpa');
				$fitxtappatmatma=$this->input->post('fitxtapelpatmatma');
				$fictxtpais=$this->input->post('ficbpais');

				$fitxtocupacionpa=$this->input->post('fitxtocupadre');
				$fitxtocupacionma=$this->input->post('fitxtocumadre');

				$fitxtdomicilio=strtoupper($this->input->post('fitxtdomicilio'));
				$ficbdistrito=$this->input->post('ficbdistrito');
				$fitxtdomiciliootro=strtoupper($this->input->post('fitxtdomiciliootro'));

				$lenguaorig = $this->input->post('ficblenguas');
				$otrasleng = $this->input->post('ficbotrlenguas');

				$newcod=$this->mpersona->insert_datos_personales(array($fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtlugarnac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro,$fitxtappatmatpa,$fitxtocupacionpa,$fitxtappatmatma,$fitxtocupacionma,$statustrab,$fitxtlugartrab,$fictxtpais,$ficestadocivil,$fitxtcelular2,$fitxtcolegiosec, $lenguaorig, $otrasleng));

				// $newcod=$this->mpersona->insert_datos_personales(array($fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro,'4'));
				if ($newcod>0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="File aperturado correctamente";
					$dataex['newcod'] =$newcod;
				}
				
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_datos_personales()
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
			
			$this->form_validation->set_rules('fidpid','Identifcador','trim|required');
			//$this->form_validation->set_rules('fitxtcodinstitucional','Cod. Institucional','trim|required');
			$this->form_validation->set_rules('ficbtipodoc','Tipo Identif.','trim|required|exact_length[3]');

			$this->form_validation->set_rules('fitxtdni','Número','trim|required|min_length[8]|max_length[15]|is_natural');
			$this->form_validation->set_rules('fitxtapelpaterno','Ap. Paterno','trim|required|min_length[3]|max_length[80]');
			$this->form_validation->set_rules('fitxtapelmaterno','Ap. Materno','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('fitxtnombres','Nombres','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('ficbsexo','Sexo','trim|required|alpha|in_list[MASCULINO,FEMENINO]');
			//$this->form_validation->set_rules('fitxtfechanac','Fec. Nac.','trim|required');
			$this->form_validation->set_rules('fitxtcelular','Celular','trim|min_length[9]');
			$this->form_validation->set_rules('fitxttelefono','Teléfono','trim|min_length[6]');
			$this->form_validation->set_rules('fitxtdomicilio','Domicilio','trim|required');
			$this->form_validation->set_rules('ficbdistrito','Distrito','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fitxtdomiciliootro','Domicilio secundario','trim');
			$this->form_validation->set_rules('ficbpais','Pais','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficblenguas','Lengua Originaria','trim|required|is_natural_no_zero');

			$statustrab = $this->input->post('ficbstatrab');
			if ($statustrab == "SI") {
				$this->form_validation->set_rules('fitxtlugartrab','Empresa /Institución donde labora','trim|required');
			}

			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$dataex['msg'] ="Ocurrio un error al momento de actualizar la ficha de datos personales";
				$fidpid=base64url_decode($this->input->post('fidpid'));
				$fitxtcodinstitucional=strtoupper($this->input->post('fitxtdni'));
				$ficbtipodoc=$this->input->post('ficbtipodoc');
				$fitxtdni=$fitxtcodinstitucional;
				$fitxtapelpaterno=strtoupper($this->input->post('fitxtapelpaterno'));
				$fitxtapelmaterno=strtoupper($this->input->post('fitxtapelmaterno'));
				$fitxtnombres=strtoupper($this->input->post('fitxtnombres'));
				$ficbsexo=$this->input->post('ficbsexo');
				$ficestadocivil=$this->input->post('ficbestcivil');
				$fitxtfechanac=$this->input->post('fitxtfechanac');
				$fitxtlugarnac=$this->input->post('fitxtlugarnac');
				$fitxtcelular=$this->input->post('fitxtcelular');
				$fitxtcelular2=($this->input->post('fitxtcelular2')!==null)? $this->input->post('fitxtcelular2') : "";
				$fitxttelefono=$this->input->post('fitxttelefono');
				$fitxtemailpersonal=$this->input->post('fitxtemailpersonal');
				$fitxtcolegiosec=$this->input->post('fitxtcolsecund');
				$fitxtlugartrab=$this->input->post('fitxtlugartrab');
				$fitxtappatmatpa=$this->input->post('fitxtapelpatmatpa');
				$fitxtappatmatma=$this->input->post('fitxtapelpatmatma');

				$fitxtocupacionpa=$this->input->post('fitxtocupadre');
				$fitxtocupacionma=$this->input->post('fitxtocumadre');

				$fictxtpais=$this->input->post('ficbpais');

				$fitxtdomicilio=strtoupper($this->input->post('fitxtdomicilio'));
				$ficbdistrito=$this->input->post('ficbdistrito');
				$fitxtdomiciliootro=strtoupper($this->input->post('fitxtdomiciliootro'));

				$lenguaorig = $this->input->post('ficblenguas');
				$otrasleng = $this->input->post('ficbotrlenguas');

				
				$newcod=$this->mpersona->update_datos_personales(array($fidpid,$fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtlugarnac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro,$fitxtappatmatpa,$fitxtappatmatma,$statustrab,$fitxtlugartrab,$fictxtpais,$ficestadocivil,$fitxtcelular2,$fitxtcolegiosec, $fitxtocupacionpa, $fitxtocupacionma, $lenguaorig, $otrasleng));

				// $newcod=$this->mpersona->update_datos_personales(array($fidpid,$fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro));
				if ($newcod==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Ficha de datos personales, actualizada correctamente";
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}






	public function fn_update_dinamico(){
		$dataex['status'] = false;
        $dataex['msg']    = '¿Qué Intentas?';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            
           
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('fitxtpersona', 'Persona', 'trim|required');

            $errors = array();
            $dataex['errors']= array();
            if ($this->form_validation->run() == false) {
                
                $dataex['msg'] = "Existe error en los campos";
                
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            } 
            else {
				$vficbsexo="";
				$vfitxtfechanac=null;
				
				$vfitxtcelular="";
				$vfitxtcelular2="";
				$vfitxttelefono="";
				$vfitxtemailpersonal="";
				$vfitxtdomicilio="";

				$vficbdepartamento="";
				$vficbprovincia="";
				$vficbdistrito="";
				$vfitxtdomiciliootro="";

                $errors=array();
                $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";

                //$vdivision=$this->input->post('vdivision');
                //$vidcurso=$this->input->post('vidcurso');
                $codpersona= base64url_decode($this->input->post('fitxtpersona'));
                if ($this->input->post('ficbsexo')!==null){
                     $vficbsexo= $this->input->post('ficbsexo');
                     $data['per_sexo']=  $vficbsexo ;
                }
                if ($this->input->post('fitxtfechanac')!==null){
                     $vfitxtfechanac= $this->input->post('fitxtfechanac');
                     $data['per_fecha_nacimiento']=  $vfitxtfechanac ;
                }
                if ($this->input->post('fitxtcelular')!==null){
                     $vfitxtcelular= $this->input->post('fitxtcelular');
                     $data['per_celular']=  $vfitxtcelular ;
                }
                if ($this->input->post('fitxtcelular2')!==null){
                     $vfitxtcelular2= $this->input->post('fitxtcelular2');
                     $data['per_celular2']=  $vfitxtcelular2 ;
                }
                if ($this->input->post('fitxttelefono')!==null){
                     $vfitxttelefono= $this->input->post('fitxttelefono');
                     $data['per_telefono']=  $vfitxttelefono ;
                }
                if ($this->input->post('fitxtemailpersonal')!==null){
                     $vfitxtemailpersonal= $this->input->post('fitxtemailpersonal');
                     $data['per_email_personal']=  $vfitxtemailpersonal ;
                }
                if ($this->input->post('fitxtdomicilio')!==null){
                     $vfitxtdomicilio= $this->input->post('fitxtdomicilio');
                     $data['per_domicilio']=  $vfitxtdomicilio ;
                }
                if ($this->input->post('ficbdistrito')!==null){
                     $vficbdistrito= $this->input->post('ficbdistrito');
                     $data['cod_distrito']=  $vficbdistrito ;
                }
                if ($this->input->post('fitxtdomiciliootro')!==null){
                     $vfitxtdomiciliootro= $this->input->post('fitxtdomiciliootro');
                     $data['per_domicilio_secundario']=  $vfitxtdomiciliootro ;
                }

                $rpta = $this->mpersona->m_update_dinamico($data,$codpersona);
                if ($rpta==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Se actualizaron correctamente tus datos";
				}
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

		public function fn_update_mis_contactos()
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
			
			$this->form_validation->set_rules('fimcid','Identifcador','trim|required');

			$this->form_validation->set_rules('fitxtdnip','Número','trim|required|min_length[8]|max_length[15]|is_natural');
			$this->form_validation->set_rules('fitxtapelpaternop','Ap. Paterno','trim|required|min_length[3]|max_length[80]');
			$this->form_validation->set_rules('fitxtapelmaternop','Ap. Materno','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('fitxtnombresp','Nombres','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('fitxtdnim','Número','trim|required|min_length[8]|max_length[15]|is_natural');
			$this->form_validation->set_rules('fitxtapelpaternom','Ap. Paterno','trim|required|min_length[3]|max_length[80]');
			$this->form_validation->set_rules('fitxtapelmaternom','Ap. Materno','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('fitxtnombresm','Nombres','trim|required|min_length[3]|max_length[35]');
			
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
				$dataex['msg'] ="Ocurrio un error al momento de actualizar la ficha de contactos";
				$fidpid=base64url_decode($this->input->post('fimcid'));
				$fitxtdnip=$this->input->post('fitxtdnip');
				$fitxtapelpaternop=strtoupper($this->input->post('fitxtapelpaternop'));
				$fitxtapelmaternop=strtoupper($this->input->post('fitxtapelmaternop'));
				$fitxtnombresp=strtoupper($this->input->post('fitxtnombresp'));
				$fitxtdnim=$this->input->post('fitxtdnim');
				$fitxtapelpaternom=strtoupper($this->input->post('fitxtapelpaternom'));
				$fitxtapelmaternom=strtoupper($this->input->post('fitxtapelmaternom'));
				$fitxtnombresm=strtoupper($this->input->post('fitxtnombresm'));
				

				$newcod=$this->mpersona->update_mis_contactos(array($fidpid,$fitxtdnip,$fitxtapelpaternop,$fitxtapelmaternop,$fitxtnombresp,$fitxtdnim,$fitxtapelpaternom,$fitxtapelmaternom,$fitxtnombresm));
				if ($newcod==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Ficha de datos personales, actualizada correctamente";
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}
	

	public function fn_update_dni()
	{
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg']    = 'Ud. no cuenta con los permisos necesarios';
			if (getPermitido("60")=='SI'){
				$this->form_validation->set_message('required', '%s Requerido');
				$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
				$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
				$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
				
				$this->form_validation->set_rules('jsdni','Nro DNI','trim|required');
				$this->form_validation->set_rules('jscodpersona','Persona','trim|required');
				$this->form_validation->set_rules('jstipodoc','Tipo','trim|required');

				if ($this->form_validation->run() == FALSE)
				{
					$dataex['msg']=validation_errors();
				}
				else
				{
					$dataex['msg'] ="Ocurrio un error al momento de actualizar la ficha de datos personales";
					$jscodpersona=base64url_decode($this->input->post('jscodpersona'));
					$jsdni=$this->input->post('jsdni');
					$jstipodoc=$this->input->post('jstipodoc');
					

					$newcod=$this->mpersona->update_dni(array($jscodpersona,$jstipodoc,$jsdni));
					if ($newcod==1){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Nro DNI, actualizado correctamente";
					}
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	
	/*public function get_datos_reniec(){

		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$datos = array(0 => '¿Que Intentas?.');
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtdni','Búsqueda','trim|required|min_length[8]');
			if ($this->form_validation->run() == FALSE)
			{
				$datos = array(0 => validation_errors());
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$datos = array(0 => 'No salio Nada');
				$dataex['status'] =TRUE;
				$dni=$this->input->post('txtdni');
				//OBTENEMOS EL VALOR
				$consulta = file_get_html('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni)->plaintext;
				//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES
				$partes=array();
				$partes = explode("|", $consulta);
				if (count($partes)==3){
					$datos = array(
							0 => 1,
							1 => $partes[0],
							2 => $partes[1],
							3 => $partes[2],
							);
				}
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($datos);
	}*/
	
	public function fn_get_datos_alumno_por_dni()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fitxtdni','DNI','trim|required');

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
				$rsprov=array();
				$rsdistri=array();
				$fidpid=$this->input->post('fitxtdni');
				$fila=$this->mpersona->get_datos_alumno_xdni(array($fidpid));
				if ($fila) {
					$dataex['status'] =TRUE;
					$fila->idpersona=base64url_encode($fila->idpersona);
					//BUSCAR UBIGEO
					$this->load->model('mubigeo');
					$rsprov="<option value='0'>Sin opciones</option>";
					$provincias=$this->mubigeo->m_provincias(array($fila->coddepartamento));
					if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
					foreach ($provincias as $provincia) {
						$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
					}

					$rsdistri="<option value='0'>Sin opciones</option>";
					$distritos=$this->mubigeo->m_distritos(array($fila->codprovincia));
					if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
					foreach ($distritos as $distrito) {
						$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
					}

				}

				$dataex['vdata']=$fila;
				$dataex['provincias']=$rsprov;
				$dataex['distritos']=$rsdistri;
				
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_insert_datos_personales_docente()
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
			
			$this->form_validation->set_rules('ficbtipodoc','Tipo Identif.','trim|required|exact_length[3]');

			$this->form_validation->set_rules('fitxtdni','Número','trim|required|min_length[8]|max_length[15]|is_natural|is_unique[tb_persona.per_dni]');
			$this->form_validation->set_rules('fitxtapelpaterno','Ap. Paterno','trim|required|min_length[3]|max_length[80]');
			$this->form_validation->set_rules('fitxtapelmaterno','Ap. Materno','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('fitxtnombres','Nombres','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('ficbsexo','Sexo','trim|required|alpha|in_list[MASCULINO,FEMENINO]');
			//$this->form_validation->set_rules('fitxtfechanac','Fec. Nac.','trim|required');
			$this->form_validation->set_rules('fitxtcelular','Celular','trim|min_length[9]');
			$this->form_validation->set_rules('fitxttelefono','Teléfono','trim|min_length[6]');
			$this->form_validation->set_rules('fitxtdomicilio','Domicilio','trim|required');
			//$this->form_validation->set_rules('fitcbpais','Domicilio','trim|required');
			$this->form_validation->set_rules('ficbdistrito','Distrito','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fitxtdomiciliootro','Domicilio secundario','trim');
			$this->form_validation->set_rules('ficbpais','Pais','trim|required|is_natural_no_zero');


			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				// $dataex['msg']=validation_errors();
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$dataex['status'] =FALSE;
				
				$ficbtipodoc=$this->input->post('ficbtipodoc');
				$fitxtdni=$this->input->post('fitxtdni');
				$fitxtcodinstitucional=$fitxtdni;
				$fitxtapelpaterno=strtoupper($this->input->post('fitxtapelpaterno'));
				$fitxtapelmaterno=strtoupper($this->input->post('fitxtapelmaterno'));
				$fitxtnombres=strtoupper($this->input->post('fitxtnombres'));
				$ficbsexo=$this->input->post('ficbsexo');
				$ficestadocivil=$this->input->post('ficbestcivil');
				$fitxtfechanac=$this->input->post('fitxtfechanac');
				$fitxtlugarnac=$this->input->post('fitxtlugarnac');
				$fitxtcelular=$this->input->post('fitxtcelular');
				$fitxtcelular2=($this->input->post('fitxtcelular2')!==null)? $this->input->post('fitxtcelular2') : "";
				$fitxttelefono=$this->input->post('fitxttelefono');
				$fitxtemailpersonal=$this->input->post('fitxtemailpersonal');
				
				$fictxtpais=$this->input->post('ficbpais');


				$fitxtdomicilio=strtoupper($this->input->post('fitxtdomicilio'));
				$ficbdistrito=$this->input->post('ficbdistrito');
				$fitxtdomiciliootro=strtoupper($this->input->post('fitxtdomiciliootro'));

				$newcod=$this->mpersona->insert_datos_personales_docente(array($fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtlugarnac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro,$fictxtpais,$ficestadocivil,$fitxtcelular2));

				if ($newcod>0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Datos guardados correctamente";
					$dataex['newcod'] =$newcod;
				}
				
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_datos_personales_docente()
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
			
			$this->form_validation->set_rules('fidpid','Identifcador','trim|required');
			//$this->form_validation->set_rules('fitxtcodinstitucional','Cod. Institucional','trim|required');
			$this->form_validation->set_rules('ficbtipodoc','Tipo Identif.','trim|required|exact_length[3]');

			$this->form_validation->set_rules('fitxtdni','Número','trim|required|min_length[8]|max_length[15]|is_natural');
			$this->form_validation->set_rules('fitxtapelpaterno','Ap. Paterno','trim|required|min_length[3]|max_length[80]');
			$this->form_validation->set_rules('fitxtapelmaterno','Ap. Materno','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('fitxtnombres','Nombres','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('ficbsexo','Sexo','trim|required|alpha|in_list[MASCULINO,FEMENINO]');
			//$this->form_validation->set_rules('fitxtfechanac','Fec. Nac.','trim|required');
			$this->form_validation->set_rules('fitxtcelular','Celular','trim|min_length[9]');
			$this->form_validation->set_rules('fitxttelefono','Teléfono','trim|min_length[6]');
			$this->form_validation->set_rules('fitxtdomicilio','Domicilio','trim|required');
			$this->form_validation->set_rules('ficbdistrito','Distrito','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fitxtdomiciliootro','Domicilio secundario','trim');
			$this->form_validation->set_rules('ficbpais','Pais','trim|required|is_natural_no_zero');

			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$dataex['msg'] ="Ocurrio un error al momento de actualizar la ficha de datos personales";
				$fidpid=base64url_decode($this->input->post('fidpid'));
				$fitxtcodinstitucional=strtoupper($this->input->post('fitxtdni'));
				$ficbtipodoc=$this->input->post('ficbtipodoc');
				$fitxtdni=$fitxtcodinstitucional;
				$fitxtapelpaterno=strtoupper($this->input->post('fitxtapelpaterno'));
				$fitxtapelmaterno=strtoupper($this->input->post('fitxtapelmaterno'));
				$fitxtnombres=strtoupper($this->input->post('fitxtnombres'));
				$ficbsexo=$this->input->post('ficbsexo');
				$ficestadocivil=$this->input->post('ficbestcivil');
				$fitxtfechanac=$this->input->post('fitxtfechanac');
				$fitxtlugarnac=$this->input->post('fitxtlugarnac');
				$fitxtcelular=$this->input->post('fitxtcelular');
				$fitxtcelular2=($this->input->post('fitxtcelular2')!==null)? $this->input->post('fitxtcelular2') : "";
				$fitxttelefono=$this->input->post('fitxttelefono');
				$fitxtemailpersonal=$this->input->post('fitxtemailpersonal');

				$fictxtpais=$this->input->post('ficbpais');

				$fitxtdomicilio=strtoupper($this->input->post('fitxtdomicilio'));
				$ficbdistrito=$this->input->post('ficbdistrito');
				$fitxtdomiciliootro=strtoupper($this->input->post('fitxtdomiciliootro'));

				
				$newcod=$this->mpersona->update_datos_personales_docente(array($fidpid,$fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtlugarnac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro,$fictxtpais,$ficestadocivil,$fitxtcelular2));

				if ($newcod==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Ficha de datos personales, actualizada correctamente";
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

}
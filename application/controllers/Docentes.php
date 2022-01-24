<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Persona.php';
class Docentes extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mdocentes');
	}

	public function vw_docentes(){
		$ahead= array('page_title' =>'Personal | ERP'  );
		$asidebar= array('menu_padre' =>'rrhh','menu_hijo' =>'docentes');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->model('mubigeo');
		$idsede=$_SESSION['userActivo']->idsede;
		$estado = "%";
		$arr_vwdocentes=$this->mdocentes->m_filtrar_trabajadores(array("%",$idsede,$estado));
		$arr_vwdocentes['departamentos'] =$this->mubigeo->m_departamentos();
		$this->load->model('marea');
		$arr_vwdocentes['areas'] =$this->marea->m_get_areas($idsede);
		$arr_vwdocentes['paises'] = $this->mubigeo->m_paises();

		$this->load->view('docentes/vw_docentes',$arr_vwdocentes);
		$this->load->view('footer');
	}

	public function fn_filtrar_trabajadores()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtestado','estado','trim|required');
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
				$busqueda=$this->input->post('txtbusqueda');
				$estado=$this->input->post('txtestado');
				$idsede=$_SESSION['userActivo']->idsede;
				//$tipo=$this->input->post('txttipo');
				$busqueda=str_replace(" ","%",$busqueda);

				$cuentas=$this->mdocentes->m_filtrar_trabajadores(array("%".$busqueda.'%',$idsede,$estado));
				
				//if (isset($cuentas)) 
				$rscuentas=$this->load->view('docentes/vw_docentes-lista',$cuentas,TRUE);
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vw_miscursos(){
		$ahead= array('page_title' =>'Mis cursos | ERP'  );
		$asidebar= array('menu_padre' =>'docmiscursos');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->model('mcargasubseccion');
		$coddocente=str_pad($_SESSION['userActivo']->codpersona, 5, "0", STR_PAD_LEFT);
		$arraymc['miscursos'] = $this->mcargasubseccion->m_get_subsecciones_visibles_por_docente(array($coddocente));

		$this->load->view('docentes/vw_miscursos',$arraymc);
		$this->load->view('footer');
	}

	public function fn_get_datos_docente_por_dni()
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
				$fila=$this->mdocentes->get_datos_completos_xdni(array($fidpid));
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

	public function fn_guardar_datos_docente()
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

			$this->form_validation->set_rules('fitxtdni','Número','trim|required|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('fitxtapelpaterno','Ap. Paterno','trim|required|min_length[3]|max_length[80]');
			$this->form_validation->set_rules('fitxtapelmaterno','Ap. Materno','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('fitxtnombres','Nombres','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('ficbsexo','Sexo','trim|required|alpha|in_list[MASCULINO,FEMENINO]');
			$this->form_validation->set_rules('fitxtfechanac','Fec. Nac.','trim|required');
			$this->form_validation->set_rules('fitxtcelular','Celular','trim|min_length[9]');
			$this->form_validation->set_rules('fitxttelefono','Teléfono','trim|min_length[6]');
			$this->form_validation->set_rules('fitxtdomicilio','Domicilio','trim|required');
			$this->form_validation->set_rules('ficbpais','pais','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbdistrito','Distrito','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fitxtdomiciliootro','Domicilio secundario','trim');

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
				$dataex['status'] =FALSE;
				$dataex['msg'] ="Ocurrio un error al momento de registrar la ficha de datos personales";
				$ficbtipodoc=$this->input->post('ficbtipodoc');
				$fitxtdni=$this->input->post('fitxtdni');
				$fitxtcodinstitucional=$fitxtdni;
				$fitxtapelpaterno=strtoupper($this->input->post('fitxtapelpaterno'));
				$fitxtapelmaterno=strtoupper($this->input->post('fitxtapelmaterno'));
				$fitxtnombres=strtoupper($this->input->post('fitxtnombres'));
				$ficbsexo=$this->input->post('ficbsexo');
				$fitxtfechanac=$this->input->post('fitxtfechanac');
				$fitxtcelular=$this->input->post('fitxtcelular');
				$fitxtcelular2=$this->input->post('fitxtcelular2');
				$fitxttelefono=$this->input->post('fitxttelefono');
				$ficbestcivil=$this->input->post('ficbestcivil');
				$fitxtemailpersonal=$this->input->post('fitxtemailpersonal');
				$fitxtdomicilio=strtoupper($this->input->post('fitxtdomicilio'));
				$ficbdistrito=$this->input->post('ficbdistrito');
				$fitxtlugarnac=strtoupper($this->input->post('fitxtlugarnac'));
				$fitxtdomiciliootro=strtoupper($this->input->post('fitxtdomiciliootro'));
				$fidpid=$this->input->post('fidpid');

				$ficbpais=$this->input->post('ficbpais');
				
				$lugarnacim = $this->input->post('fidplugnacim');
				
				$celular2 = $this->input->post('fidpcelular2');
				
				$estadocivil = $this->input->post('fidpstadociv');

				$this->load->model('mpersona');	
				if ($fidpid=="0"){
					$dataex['msg'] ="Ocurrio un error al momento de registrar una nueva persona";
					$newcod=$this->mpersona->insert_datos_personales_docente(array($fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac, $fitxtlugarnac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro,$ficbpais, $ficbestcivil, $fitxtcelular2));
					$codper = $newcod;

				}else{
					$dataex['msg'] ="Ocurrio un error al momento de actualizar a una persona";
					$newcod=$this->mpersona->update_datos_personales_docente(array(base64url_decode($fidpid),$fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac, $fitxtlugarnac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro, $ficbpais, $ficbestcivil, $fitxtcelular2));
					$codper = base64url_decode($fidpid);
				}
				
				
				if ($newcod>0){
					$dataex['msg'] ="Ocurrio un error al momento de registrar al docente";
					$dataex['status'] =FALSE;
					$fitxteinstitucional=$this->input->post('fitxteinstitucional');
					$fitxtcoddocente=strtoupper($this->input->post('fitxtcoddocente'));
					$fitxtcargo=strtoupper($this->input->post('fitxtcargo'));
					$ficbtipo=$this->input->post('ficbtipo');
					$ficbtipo_antiguo=$this->input->post('ficbtipo_antiguo');
					$ficbidarea=$this->input->post('fitxtidarea');
					
					if ($fitxtcoddocente=="0"){
						$dataex['msg'] ="Se intenta registrar un docente $fitxtcoddocente";
						$coddocente=str_pad($codper, 5, "0", STR_PAD_LEFT);
						$idsede=$_SESSION['userActivo']->idsede;
						$newcod=$this->mdocentes->m_insert(array($coddocente,$codper,$fitxteinstitucional,$ficbtipo,$fitxtcargo,$idsede,$ficbidarea));
						if ($newcod==1){
							$dataex['status'] =TRUE;
							$dataex['msg'] ="Docente registrado correctamente";
						}
					}
					else{
						$dataex['msg'] ="Se intenta actualizar un docente";
						$newcod=$this->mdocentes->m_update(array($fitxtcoddocente,$fitxteinstitucional,$ficbtipo,$fitxtcargo,$ficbidarea));
						$dataex['mensaje'] = $newcod;
						if ($newcod==1){
							$this->load->model('musuario');
							$this->musuario->m_update_tipo_correo_area_x_codente(array($fitxteinstitucional,$ficbtipo,$ficbidarea,$fitxtcoddocente,$ficbtipo_antiguo));
							$dataex['status'] =TRUE;
							$dataex['msg'] ="Ficha de datos personales, actualizada correctamente";
							
						}
					}
				}
				
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_get_datos_docente_por_codigo()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fitxtcodigo','CODIGO','trim|required');

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
				$fidpid=base64url_decode($this->input->post('fitxtcodigo'));
				$fila=$this->mdocentes->get_datos_docente(array($fidpid));
				if ($fila) {
					$dataex['status'] =TRUE;
					$fila->idpersona = base64url_encode($fila->idpersona);
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

	/*public function fn_update_datos_docente()
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
			$this->form_validation->set_rules('fitxtcodinstitucional','Cod. Institucional','trim|required');
			$this->form_validation->set_rules('ficbtipodoc','Tipo Identif.','trim|required|exact_length[3]');

			$this->form_validation->set_rules('fitxtdni','Número','trim|required|min_length[8]|max_length[15]|is_natural');
			$this->form_validation->set_rules('fitxtapelpaterno','Ap. Paterno','trim|required|min_length[3]|max_length[80]');
			$this->form_validation->set_rules('fitxtapelmaterno','Ap. Materno','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('fitxtnombres','Nombres','trim|required|min_length[3]|max_length[35]');
			$this->form_validation->set_rules('ficbsexo','Sexo','trim|required|alpha|in_list[MASCULINO,FEMENINO]');
			$this->form_validation->set_rules('fitxtfechanac','Fec. Nac.','trim|required');
			$this->form_validation->set_rules('fitxtcelular','Celular','trim|min_length[9]');
			$this->form_validation->set_rules('fitxttelefono','Teléfono','trim|min_length[6]');
			$this->form_validation->set_rules('fitxtdomicilio','Domicilio','trim|required');
			$this->form_validation->set_rules('ficbdistrito','Distrito','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fitxtdomiciliootro','Domicilio secundario','trim');

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
				//DATOS PERSONALES
				$dataex['msg'] ="Ocurrio un error al momento de actualizar la ficha de datos personales";
				$fidpid=$this->input->post('fidpid');
				$fitxtcodinstitucional=strtoupper($this->input->post('fitxtcodinstitucional'));
				$ficbtipodoc=$this->input->post('ficbtipodoc');
				$fitxtdni=$this->input->post('fitxtdni');
				$fitxtapelpaterno=strtoupper($this->input->post('fitxtapelpaterno'));
				$fitxtapelmaterno=strtoupper($this->input->post('fitxtapelmaterno'));
				$fitxtnombres=strtoupper($this->input->post('fitxtnombres'));
				$ficbsexo=$this->input->post('ficbsexo');
				$fitxtfechanac=$this->input->post('fitxtfechanac');
				$fitxtcelular=$this->input->post('fitxtcelular');
				$fitxttelefono=$this->input->post('fitxttelefono');
				$fitxtemailpersonal=$this->input->post('fitxtemailpersonal');
				$fitxtdomicilio=strtoupper($this->input->post('fitxtdomicilio'));
				$ficbdistrito=$this->input->post('ficbdistrito');
				$fitxtdomiciliootro=strtoupper($this->input->post('fitxtdomiciliootro'));
				$this->load->model('mpersona');
				$newcod=$this->mpersona->update_datos_personales(array($fidpid,$fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro));

				if ($newcod==1){
					$dataex['msg'] ="Error al registrar datos, intentalo mas tarde o comucate con el administrador";
					$dataex['status'] =FALSE;
					$fitxteinstitucional=$this->input->post('fitxteinstitucional');
					$fitxtcoddocente=strtoupper($this->input->post('fitxtcoddocente'));
					$fitxtcargo=strtoupper($this->input->post('fitxtcargo'));
					$ficbtipo=$this->input->post('ficbtipo');
					$ficbtipo=$this->input->post('fitxtidarea');
					$coddocente=str_pad($fidpid, 5, "0", STR_PAD_LEFT);
					if ($fitxtcoddocente==""){
						$idsede=$_SESSION['userActivo']->idsede;
						$newcod=$this->mdocentes->m_insert(array($coddocente,$fidpid,$fitxteinstitucional,$ficbtipo,$fitxtcargo,$idsede));
						if ($newcod==1){
							$dataex['status'] =TRUE;
							$dataex['msg'] ="Docente registrado correctamente";
							
						}
					}
					else{
						$newcod=$this->mdocentes->m_update(array($coddocente,$fitxteinstitucional,$ficbtipo,$fitxtcargo));
						if ($newcod==1){
							$dataex['status'] =TRUE;
							$dataex['msg'] ="Ficha de datos personales, actualizada correctamente";
							
						}
					}
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}*/
	/*public function fn_insert_datos_docente()
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
			$this->form_validation->set_rules('fitxtfechanac','Fec. Nac.','trim|required');
			$this->form_validation->set_rules('fitxtcelular','Celular','trim|min_length[9]');
			$this->form_validation->set_rules('fitxttelefono','Teléfono','trim|min_length[6]');
			$this->form_validation->set_rules('fitxtdomicilio','Domicilio','trim|required');
			//$this->form_validation->set_rules('fitcbpais','pais','trim|required');
			$this->form_validation->set_rules('ficbdistrito','Distrito','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fitxtdomiciliootro','Domicilio secundario','trim');

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
				$dataex['status'] =FALSE;
				$dataex['msg'] ="Ocurrio un error al momento de registrar la ficha de datos personales";
				$ficbtipodoc=$this->input->post('ficbtipodoc');
				$fitxtdni=$this->input->post('fitxtdni');
				$fitxtcodinstitucional=$fitxtdni;
				$fitxtapelpaterno=strtoupper($this->input->post('fitxtapelpaterno'));
				$fitxtapelmaterno=strtoupper($this->input->post('fitxtapelmaterno'));
				$fitxtnombres=strtoupper($this->input->post('fitxtnombres'));
				$ficbsexo=$this->input->post('ficbsexo');
				$fitxtfechanac=$this->input->post('fitxtfechanac');
				$fitxtcelular=$this->input->post('fitxtcelular');
				$fitxttelefono=$this->input->post('fitxttelefono');
				$fitxtemailpersonal=$this->input->post('fitxtemailpersonal');
				$fitxtdomicilio=strtoupper($this->input->post('fitxtdomicilio'));
				$ficbdistrito=$this->input->post('ficbdistrito');
				$fitxtdomiciliootro=strtoupper($this->input->post('fitxtdomiciliootro'));
				$this->load->model('mpersona');
				$newcod=$this->mpersona->insert_datos_personales(array($fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro,'4'));
				if ($newcod>0){
					$dataex['msg'] ="Ocurrio un error al momento de registrar al docente";
					$dataex['status'] =FALSE;
					$fitxteinstitucional=$this->input->post('fitxteinstitucional');
					$fitxtcoddocente=strtoupper($this->input->post('fitxtcoddocente'));
					$fitxtcargo=strtoupper($this->input->post('fitxtcargo'));
					$ficbtipo=$this->input->post('ficbtipo');
					$coddocente=str_pad($newcod, 5, "0", STR_PAD_LEFT);
					$idsede=$_SESSION['userActivo']->idsede;
					$idarea=$this->input->post('fitxtidarea');
					$newcod=$this->mdocentes->m_insert(array($coddocente,$newcod,$fitxteinstitucional,$ficbtipo,$fitxtcargo,$idsede,$idarea));
					if ($newcod==1){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Docente registrado correctamente";
						
					}
				}
				
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}*/

	


	public function horario_pdf()
    {
        $codocente=$this->input->get('bcode');
        $nombres=$this->input->get('bnombre');
        $horas     = $this->musuario->m_horas_activas();
        $horarios= $this->musuario->m_cursos_horarios($codocente);
        $resumen= $this->musuario->m_cursos_resumen($codocente);
        $arrayDias = array('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO');

        $horario=array();
        foreach ($arrayDias as $dia) {
            $horario[$dia]=array();
            foreach ($horas as $hora) {
                $horario[$dia][$hora->inicia]["value"]="";
                $horario[$dia][$hora->inicia]["carrera"]="";
                foreach ($horarios as $curso) {
                    if ($curso->hdia==$dia && $hora->inicia==$curso->hini){
                        $horario[$dia][$hora->inicia]["value"]=$curso->nomcurso."<br>".$curso->abrev." ".$curso->ciclo." ".$curso->seccion." - ".$curso->subseccion;
                        $horario[$dia][$hora->inicia]["carrera"]=$curso->nomcarrera;
                        if (($curso->hini==$hora->inicia) &&($curso->hfin==$hora->culmina)){

                        }
                        else{
                            $curso->hini=$hora->culmina;    
                        }
                        
                    }
                }
            }
        }
        $arraydoc['horas'] =$horas;
        $arraydoc['horacurso']  =$horarios;
        $arraydoc['resumenh']  =$resumen;
        $arraydoc['dias']  =$arrayDias;
        $arraydoc['horario'] =$horario;
       
        $arraydoc['titulodocente'] =$nombres;

        $htmlnt      = $this->load->view('cargaacademica/docente/vw-horario-pdf', $arraydoc,true);
        $pdfFilePath = "HORARIO" . ".pdf";
        $this->load->library('M_pdf');
        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
        $mpdf->SetWatermarkImage(base_url().'resources/img/logo-iesap.png',0.2,'F','P');
        $mpdf->showWatermarkImage = true;
        $mpdf->SetHTMLHeader('
        <table width="100%">
            <tr>
                <td width="75%"><span style="font-size:10px;font-weight: normal"></span></td>
                <td width="25%" style="text-align: right;font-size:10px;font-weight: normal">{DATE j/m/Y}</td>
            </tr>
        </table>');
        $mpdf->SetHTMLFooter('
        <table width="100%">
            <<tr>
                <<td width="67%" align="center"></td>
                <<td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
            <</tr>
        </table>');
        $mpdf->WriteHTML($htmlnt);
        $mpdf->Output();//$pdfFilePath, "D");

    }

    public function fn_update_status_docente()
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
			
			$this->form_validation->set_rules('doccod','codigo periodo','trim|required');
			$this->form_validation->set_rules('accion','valor activo','trim|required');

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
				$doccod=base64url_decode($this->input->post('doccod'));
				$accion=$this->input->post('accion');

				$rpta=$this->mdocentes->Update_activo_docente(array($accion, $doccod));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Se modifico correctamente";
					
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
    }
    

}

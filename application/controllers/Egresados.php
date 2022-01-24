<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Egresados extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('megresados');
		$this->load->model('mubigeo');
		$this->load->model('mcarrera');
		$this->load->model('mperiodo');
		$this->load->model("mauditoria");
	}
	
	public function vw_egresados(){
		if (getPermitido("148")=='SI'){
			$ahead= array('page_title' =>'Egresados | '.$this->ci->config->item('erp_title') );
			$asidebar= array('menu_padre' =>'egresados_acad','menu_hijo' =>'seg-egresados');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
			$this->load->view($vsidebar,$asidebar);
			$sede = $_SESSION['userActivo']->idsede;
			$buscar = '%';
			$dataeg['egresados'] = $this->megresados->m_get_egresados(array($buscar, $sede));
			$dataeg['departamentos'] =$this->mubigeo->m_departamentos();
			$dataeg['carreras'] = $this->mcarrera->m_get_todas_carreras_por_sede(array($sede));
			$dataeg['periodos']=$this->mperiodo->m_get_periodos();
			$this->load->model('miestp');
			$dataeg['iest']=$this->miestp->m_get_datos();
			$this->load->view('egresados/vw_egresados', $dataeg);
			$this->load->view('footer');
		} else {
            $urlref=base_url();
            header("Location: $urlref", FILTER_SANITIZE_URL);
        }
	}

	public function fn_seach_estudiante()
	{
		$this->form_validation->set_message('required', '%s Requerido ');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fictxtbusqueda','búsqueda','trim|required');
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
				$busqueda=$this->input->post('fictxtbusqueda');
				$sede = $_SESSION['userActivo']->idsede;
				// $busqueda=str_replace(" ","%",$busqueda);
            
				$cuentas = $this->megresados->m_filtrar_estudiantes(array('%'.$busqueda.'%',$sede));

				foreach ($cuentas as $key => $cnt) {
					$cnt->codins64 = base64url_encode($cnt->codinscripcion);
				}
				
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$cuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vw_inscrito_x_codigo()
	{
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigoins', 'codigo inscrito', 'trim|required');
		$this->form_validation->set_rules('txtperiodo', 'codigo periodo', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigoins'));
			$periodo = $this->input->post('txtperiodo');

			$dataex['status'] =true;
			
			$msgrpta = $this->megresados->m_get_inscripcion_xcodigo(array($periodo, $codigo));

			$msgrpta->codigoins64 = base64url_encode($msgrpta->codinscripcion);

			//BUSCAR UBIGEO
			$rsprov="<option value='0'>Sin opciones</option>";
			$provincias=$this->mubigeo->m_provincias(array($msgrpta->codepartamento));
			if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
			foreach ($provincias as $provincia) {
				$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
			}

			$rsdistri="<option value='0'>Sin opciones</option>";
			$distritos=$this->mubigeo->m_distritos(array($msgrpta->codprovincia));
			if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
			foreach ($distritos as $distrito) {
				$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
			}

			$dataex['dprovincias']=$rsprov;
			$dataex['ddistritos']=$rsdistri;
			
		}
		
		$dataex['vdata'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
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
			if (getPermitido("145")=='SI') {
				$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
				$fictxtcodigo=$this->input->post('fictxtcodigo');
				if ($fictxtcodigo == '0') {
					$this->form_validation->set_rules('fictxtdocumento','Número','trim|required|min_length[8]|max_length[15]|is_natural|is_unique[tb_egresados.eg_dni]');
				} else {
					$this->form_validation->set_rules('fictxtdocumento','Número','trim|required|min_length[8]|max_length[15]|is_natural');
				}

				$this->form_validation->set_rules('fictxtipdocum','Tipo Identif.','trim|required|exact_length[3]');
				$this->form_validation->set_rules('fictxtapepaterno','Ap. Paterno','trim|required|min_length[3]|max_length[80]');
				$this->form_validation->set_rules('fictxtapematerno','Ap. Materno','trim|required|min_length[3]|max_length[35]');
				$this->form_validation->set_rules('fictxtnombres','Nombres','trim|required|min_length[3]|max_length[35]');
				$this->form_validation->set_rules('fictxtsexo','Sexo','trim|required|alpha|in_list[MASCULINO,FEMENINO]');
				//$this->form_validation->set_rules('fitxtfechanac','Fec. Nac.','trim|required');
				$this->form_validation->set_rules('fitxtcelular','Celular','trim|min_length[9]');
				$this->form_validation->set_rules('fitxttelefono','Teléfono','trim|min_length[6]');
				$this->form_validation->set_rules('fitxtdomicilio','Domicilio','trim|required');
				$this->form_validation->set_rules('ficbdistrito','Distrito','trim|required|is_natural_no_zero');

				$this->form_validation->set_rules('fictxtmodular','codigo modular','trim|required');
				$this->form_validation->set_rules('fictxtprograma','Programa','trim|required|is_natural_no_zero');
				$this->form_validation->set_rules('fitxtanioegreso','Año egreso','trim|required');
				$this->form_validation->set_rules('fictxtperiodoeg','Periodo','trim|required|is_natural_no_zero');

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
					
					
					$codigo64 = base64url_decode($fictxtcodigo);
					$ficbtipodoc=$this->input->post('fictxtipdocum');
					$fitxtdni=$this->input->post('fictxtdocumento');
					
					$fitxtapelpaterno=strtoupper($this->input->post('fictxtapepaterno'));
					$fitxtapelmaterno=strtoupper($this->input->post('fictxtapematerno'));
					$fitxtnombres=strtoupper($this->input->post('fictxtnombres'));
					$ficbsexo=$this->input->post('fictxtsexo');
					$fitxtfechanac=$this->input->post('fitxtfechanac');
					$fitxtcelular=$this->input->post('fitxtcelular');
					$fitxttelefono=$this->input->post('fitxttelefono');
					$fitxtemailpersonal=$this->input->post('fitxtemailpersonal');

					$fictxtmodular=$this->input->post('fictxtmodular');
					$fictxtprograma=$this->input->post('fictxtprograma');
					$fitxtanioegreso=$this->input->post('fitxtanioegreso');
					$fictxtperiodoeg=$this->input->post('fictxtperiodoeg');

					$fitxtdomicilio=strtoupper($this->input->post('fitxtdomicilio'));
					$ficbdistrito=$this->input->post('ficbdistrito');

					$codinscrito = $this->input->post('fictxtcodigoinsc');
					$codinscrito64 = null;
					if ($codinscrito != '0') {
						$codinscrito64 = base64url_decode($codinscrito);
					}

					$sede = $_SESSION['userActivo']->idsede;

					if ($fictxtcodigo == '0') {
						$newcod = $this->megresados->mInsert_egresado(array($ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtdomicilio,$fitxttelefono,$fitxtcelular,$fitxtemailpersonal,$ficbdistrito,$fictxtmodular,$fictxtprograma,$fictxtperiodoeg,$fitxtanioegreso,$sede,$codinscrito64));
					} else {
						$newcod = $this->megresados->mUpdate_egresado(array($codigo64,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtdomicilio,$fitxttelefono,$fitxtcelular,$fitxtemailpersonal,$ficbdistrito,$fictxtmodular,$fictxtprograma,$fictxtperiodoeg,$fitxtanioegreso,$sede));
					}
					

					if ($newcod->salida == 1){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos guardados correctamente";
						$dataex['newcod'] = $newcod->newcod;
					}
					
				}
			} else {
				$dataex['status'] = false;
	        	$dataex['msg']    = 'Acceso denegado';
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vw_egresado_x_codigo()
	{
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo egresado', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$msgrpta = $this->megresados->m_filtrar_egresadoxcodigo(array($codigo));

			$msgrpta->codigo64 = base64url_encode($msgrpta->codigo);

			//BUSCAR UBIGEO
			$rsprov="<option value='0'>Sin opciones</option>";
			$provincias=$this->mubigeo->m_provincias(array($msgrpta->codepartamento));
			if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
			foreach ($provincias as $provincia) {
				$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
			}

			$rsdistri="<option value='0'>Sin opciones</option>";
			$distritos=$this->mubigeo->m_distritos(array($msgrpta->codprovincia));
			if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
			foreach ($distritos as $distrito) {
				$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
			}

			$dataex['dprovincias']=$rsprov;
			$dataex['ddistritos']=$rsdistri;
			
		}
		
		$dataex['vdata'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_egresado()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
        	if (getPermitido("147")=='SI') {
	            $this->form_validation->set_message('required', '%s Requerido');
	            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
	            $this->form_validation->set_rules('txtcodigo', 'codigo egresado', 'trim|required');
	            if ($this->form_validation->run() == false) {
	                $dataex['msg'] = validation_errors();
	            } else {
	                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este egresado";
	                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));
	                
	                $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
					$fictxtaccion = "ELIMINAR";
	                
	                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un egresado en la tabla TB_EGRESADOS COD.".$txtcodigo;
					
	                $rpta = $this->megresados->m_elimina_egresado(array($txtcodigo));
	                if ($rpta == 1) {
	                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
	                    $dataex['status'] = true;
	                    $dataex['msg']    = 'Registro eliminado correctamente';

	                }

	            }
	        } else {
	        	$dataex['status'] = false;
	        	$dataex['msg']    = 'Acceso denegado';
	        }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	

}
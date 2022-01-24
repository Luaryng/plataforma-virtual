<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Campania extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mcampania');
		$this->load->model('mperiodo');
		$this->load->model("msede");
		$this->load->model("mauditoria");
	}

	public function vw_principal()
	{
		$ahead= array('page_title' =>'Campaña | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'campania');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->model('mperiodo');
		$dtcamp['datosp'] = $this->mperiodo->m_get_periodos();
		$dtcamp['sedes'] = $this->msede->m_get_sedes_activos();
		$this->load->view('campania/vw_campania', $dtcamp);
		$this->load->view('footer');
	}

	public function fn_campania_por_periodo()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['msg']    = '¿Que Intentas?.';
		$conteo=0;
		$rsoptions="<option value='0'>Sin opciones</option>";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodperiodo','Búsqueda','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda=$this->input->post('txtcodperiodo');
				$campanias=$this->mcampania->m_get_campanias_por_periodo(array($busqueda,$_SESSION['userActivo']->idsede));
				$conteo=count($campanias);
				if ($conteo>0) $rsoptions="<option value='0'>Seleccionar Campaña</option>";
				foreach ($campanias as $campania) {
					$rsoptions=$rsoptions."<option value='$campania->id' data-descripcion='$campania->descripcion'>$campania->codperiodo - $campania->nombre</option>";
				}
			}
		}
		$dataex['count'] =$conteo;
		$dataex['vdata'] =$rsoptions;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	

	public function fn_insert_campania()
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
			
			$this->form_validation->set_rules('ficperiodo','Periodo','trim|required');
			$this->form_validation->set_rules('fitxtnomcampania','nombre campaña.','trim|required');
			$this->form_validation->set_rules('fitxtdescampania','Descripción','trim|required');
			$this->form_validation->set_rules('datinicia','fecha inicio','trim|required');
			$this->form_validation->set_rules('datculmina','fecha finaliza','trim|required');
			$this->form_validation->set_rules('cbosede','Sede','trim|required');

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
				$ficperiodo=$this->input->post('ficperiodo');
				$fitxtnomcampania=strtoupper($this->input->post('fitxtnomcampania'));
				$fitxtdescampania=strtoupper($this->input->post('fitxtdescampania'));
				$datinicia=$this->input->post('datinicia');
				$datculmina=$this->input->post('datculmina');
				$idsede=$this->input->post('cbosede');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				$checkstatus = "NO";
				if ($this->input->post('checkestado')!==null){

                     $checkstatus = $this->input->post('checkestado');

                }

                if ($checkstatus=="on"){

                	$checkstatus = "SI";

                }

				$rpta=$this->mcampania->insert_datos_campania(array($ficperiodo, $idsede, $fitxtnomcampania, $fitxtdescampania, $datinicia, $datculmina, $checkstatus));
				$dataex['prueba'] = $rpta->nid;
				if ($rpta->salida==1){
					$accion = "INSERTAR";
	        		$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando una campaña en la tabla TB_CAMPANIA COD.".$rpta->nid;
	        		$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));

					$dataex['status'] =TRUE;
					$dataex['msg'] ="Campaña registrada correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	/*public function search_campania(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			$dataex['status']=false;
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$this->form_validation->set_rules('txtper','periodo','trim|required|min_length[4]');

			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

				$codper = $this->input->post('txtper');
				$campadts = $this->mcampania->m_search_campanias_por_periodo($codper.'%');
				if ($campadts > 0) {
					foreach ($campadts as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->id);
						$dateini =  new DateTime($fila->fini);
						$fila->fechaini = date($dateini->format('d')).", ".$meses[date($dateini->format('n'))-1]. " ".date($dateini->format('Y'));
						$datefin =  new DateTime($fila->fculm);
						$fila->fechafin = date($datefin->format('d')).", ".$meses[date($datefin->format('n'))-1]. " ".date($datefin->format('Y'));
						// $fila->codcarre64=base64url_encode($fila->idcarrera);
					}
                    $dataex['status'] = true;
                    $dataex['datos'] = $campadts;
                }
								
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}*/

	public function fn_filtar_campania_x_sede_periodo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			$dataex['status']=false;
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$this->form_validation->set_rules('txtper','periodo','trim|required');

			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

				$codper = $this->input->post('txtper');
				$campadts = $this->mcampania->m_search_campanias_x_sede_periodo(array($codper,$_SESSION['userActivo']->idsede));
				if ($campadts > 0) {
					foreach ($campadts as $key => $fila) {
						$fila->codigo64=base64url_encode($fila->id);
						$dateini =  new DateTime($fila->fini);
						$fila->fechaini = date($dateini->format('d')).", ".$meses[date($dateini->format('n'))-1]. " ".date($dateini->format('Y'));
						$datefin =  new DateTime($fila->fculm);
						$fila->fechafin = date($datefin->format('d')).", ".$meses[date($datefin->format('n'))-1]. " ".date($datefin->format('Y'));
						// $fila->codcarre64=base64url_encode($fila->idcarrera);
					}
                    $dataex['status'] = true;
                    $dataex['datos'] = $campadts;
                }
								
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_campaniaxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcod', 'codigo campaña', 'trim|required|min_length[4]');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcod = base64url_decode($this->input->post('txtcod'));
			$dataex['status'] =true;
			$arrayhs['datosp'] = $this->mperiodo->m_get_periodos();
			$arrayhs['dcampania'] = $this->mcampania->m_search_campanias_por_codigo(array($txtcod));
			$arrayhs['sedes'] = $this->msede->m_get_sedes_activos();
			$msgrpta=$this->load->view('campania/campaniaupdate', $arrayhs, true);
			
		}
		
		$dataex['campaup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_update_campania()
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
			
			$this->form_validation->set_rules('ficxtidcamped','Periodo','trim|required');
			$this->form_validation->set_rules('ficperiodoed','Periodo','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fitxtnomcampaniaed','nombre campaña.','trim|required');
			$this->form_validation->set_rules('fitxtdescampaniaed','Descripción','trim|required');
			$this->form_validation->set_rules('datiniciaed','fecha inicio','trim|required');
			$this->form_validation->set_rules('datculminaed','fecha finaliza','trim|required');
			$this->form_validation->set_rules('cbosedeupd','Sede','trim|required');

			// $this->form_validation->set_rules('ficbsexo','Sexo','trim|required|alpha|in_list[MASCULINO,FEMENINO]');

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
				$ficxtidcamped=base64url_decode($this->input->post('ficxtidcamped'));
				$ficperiodoed=$this->input->post('ficperiodoed');
				$fitxtnomcampaniaed=strtoupper($this->input->post('fitxtnomcampaniaed'));
				$fitxtdescampaniaed=strtoupper($this->input->post('fitxtdescampaniaed'));
				$datiniciaed=$this->input->post('datiniciaed');
				$datculminaed=$this->input->post('datculminaed');
				$idsede = $this->input->post("cbosedeupd");

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				$rpta=$this->mcampania->update_datos_campania(array($ficxtidcamped, $ficperiodoed, $idsede, $fitxtnomcampaniaed, $fitxtdescampaniaed, $datiniciaed, $datculminaed));
				if ($rpta->salida == 1){
					$accion = "EDITAR";
	        		$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando una campaña en la tabla TB_CAMPANIA COD.".$rpta->nid;
	        		$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));

					$dataex['status'] =TRUE;
					$dataex['msg'] ="Campaña Actualizada correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminarcamp()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idcampa', 'codigo Campaña', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta Campaña";
                $idcampa    = base64url_decode($this->input->post('idcampa'));

                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$accion = "ELIMINAR";
                
                $rpta = $this->mcampania->delete_campania(array($idcampa));
                if ($rpta->salida == 1) {
                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una campaña en la tabla TB_CAMPANIA COD.".$rpta->nid;

                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Campaña eliminado correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_update_activo()
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
			
			$this->form_validation->set_rules('idcamp','codigo campaña','trim|required');
			$this->form_validation->set_rules('activo','valor activo','trim|required');

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
				$idcamp = base64url_decode($this->input->post('idcamp'));
				$activo = $this->input->post('activo');

				$rpta=$this->mcampania->update_activ_campania(array($idcamp, $activo));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Se modifico correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}
}
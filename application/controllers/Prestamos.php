<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prestamos extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mprestamos');
		$this->load->model('mbiblioteca');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Prestamos Libros | IESTWEB'  );
		$asidebar= array('menu_padre' =>'biblioteca','menu_hijo' =>'prestamo');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('prestamos/vw_prestamos');
		$this->load->view('footer');
	}

	public function fn_get_alumno()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$fila= array('idpersona' => '0');
		$nros= array('prestalib' => '0');
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcarne','Carnet','trim|required|min_length[4]');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda=$this->input->post('txtcarne');
				$rsfila=$this->mprestamos->m_busca_alumno(array($busqueda));
				$dataex['status'] =TRUE;
				$nropres = $this->mprestamos->contar_libros_prestados(array($busqueda));
				
				if (!is_null($rsfila)){
					$rsfila->idins=base64url_encode($rsfila->idins);
					$fila=$rsfila;
					$nros = count($nropres);
				}
			}
		}
		$dataex['vdata'] =$fila;
		$dataex['vnros'] =$nros;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_libros_pres(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtnlib', 'nombre libro', 'trim|required|min_length[4]');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtnlib = $this->input->post('txtnlib');
			$dataex['status'] =true;

			// $rst = $this->mbiblioteca->m_historial_libros(array($txtnlib.'%'));
			$rst = $this->mbiblioteca->m_search_libro(array($txtnlib.'%'));
			$arrayhs['dlibros'] = $rst;
			$msgrpta=$this->load->view('prestamos/vw_detalle_search', $arrayhs, true);
			
		}
		
		$dataex['detallelib'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_ejemplaresxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('idlibro', 'codigo libro', 'trim|required|min_length[4]');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$idlibro = base64url_decode($this->input->post('idlibro'));
			$dataex['status'] =true;
			$arrayhs['dejempl'] = $this->mbiblioteca->m_historial_ejemplares(array($idlibro));
			$msgrpta=$this->load->view('prestamos/vw_ejemplaresxcodigo', $arrayhs, true);
			
		}
		
		$dataex['ejmupd'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insert_prestamo()
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
			
			$this->form_validation->set_rules('fictxtcarne','carne','trim|required');
			$this->form_validation->set_rules('fictxtcodejm','codigo ejemplar','trim|required');
			$this->form_validation->set_rules('fictxtestado','estado','trim|required');
			$this->form_validation->set_rules('ficfeclimit','fecha','trim|required');
			$this->form_validation->set_rules('fichorlimit','hora','trim|required');
			
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
				
				$fictxtidinscrip = base64url_decode($this->input->post('fictxtidinscrip'));
				$carne = $this->input->post('fictxtcarne');
				$fictxtcodejm = base64url_decode($this->input->post('fictxtcodejm'));
				$fictxtestado=$this->input->post('fictxtestado');
				$ficfecentrega = $this->input->post('ficfecentrega');
				$fichorentrega = $this->input->post('fichorentrega');
				$fechaentrega = $ficfecentrega . ' ' . $fichorentrega;
				$ficfeclimit = $this->input->post('ficfeclimit');
				$fichorlimit = $this->input->post('fichorlimit');
				$fechalimit = $ficfeclimit . ' ' . $fichorlimit;
				$fitxtobservaciones = $this->input->post('fitxtobservaciones');
				$rpta=$this->mprestamos->insert_datos_prestamos(array($fictxtidinscrip, $carne, $fictxtcodejm, $fictxtestado, $fechaentrega, $fechalimit, NULL, $fitxtobservaciones, NULL));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Datos registrados correctamente";
						
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function devuelve_libros(){
		$ahead= array('page_title' =>'Devoluciones Libros | IESTWEB'  );
		$asidebar= array('menu_padre' =>'biblioteca','menu_hijo' =>'retorno');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('prestamos/vw_devoluciones');
		$this->load->view('footer');
	}

	public function fn_get_alumnoxprestamo()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$fila= array('idpersona' => '0');
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcardev','Carnet','trim|required|min_length[4]');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda=$this->input->post('txtcardev');
				$rsfila=$this->mprestamos->m_busca_alumno(array($busqueda));
				$dataex['status'] =TRUE;
				if (!is_null($rsfila)){
					// $rsfila->idins=base64url_encode($rsfila->idins);
					$fila=$rsfila;
				}
			}
		}
		$dataex['vdata'] =$fila;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_prestamosxalumno(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcarnet', 'carnet', 'trim|required|min_length[4]');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcarnet = $this->input->post('txtcarnet');
			$dataex['status'] =true;
			$arrayhs['dejempst'] = $this->mprestamos->m_busca_prestamoxcarnet(array($txtcarnet));
			$msgrpta=$this->load->view('prestamos/vw_detalle_prestamos', $arrayhs, true);
			
		}
		
		$dataex['ejmuprs'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_prestamosxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo prestamo', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcodigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			$arrayhs['dprest'] = $this->mprestamos->m_prestamoxcodigo(array($txtcodigo));
			$msgrpta=$this->load->view('prestamos/devoluciones', $arrayhs, true);
			
		}
		
		$dataex['prestd'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_update_prestamo()
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
			
			$this->form_validation->set_rules('fictxtcodpres','codigo prestamo','trim|required');
			$this->form_validation->set_rules('fictxtcodejm','codigo ejemplar','trim|required');
			$this->form_validation->set_rules('ficfecfin','Fecha','trim|required');
			$this->form_validation->set_rules('fichorfin','Hora','trim|required');
			$this->form_validation->set_rules('ficestado','estado','trim|required');
			$this->form_validation->set_rules('ficsituacion','situacion','trim|required');
			
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
				
				$fictxtcodpres = base64url_decode($this->input->post('fictxtcodpres'));
				$ficfecfin = $this->input->post('ficfecfin');
				$fichorfin=$this->input->post('fichorfin');
				$fechafin = $ficfecfin . ' ' . $fichorfin;
				$fictxtcodejm = base64url_decode($this->input->post('fictxtcodejm'));
				$ficestado = $this->input->post('ficestado');
				$ficsituacion = $this->input->post('ficsituacion');
				$fitxtobserfinal = $this->input->post('fitxtobserfinal');
				$rpta=$this->mprestamos->update_datos_prestamos(array($fictxtcodpres, $fechafin, $fitxtobserfinal, $fictxtcodejm, $ficestado, $ficsituacion));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Datos Actualizados correctamente";
						
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

}
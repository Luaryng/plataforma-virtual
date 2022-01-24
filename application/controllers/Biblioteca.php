<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Biblioteca extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mbiblioteca');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Biblioteca | IESTWEB'  );
		$asidebar= array('menu_padre' =>'biblioteca','menu_hijo' =>'libro');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$dtbltc['autores'] = $this->mbiblioteca->m_get_autores();
		$dtbltc['editor'] = $this->mbiblioteca->m_get_editorial();
		$this->load->view('biblioteca/vw_libro', $dtbltc);
		$this->load->view('footer');
	}

	public function fn_insert_libro()
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
			
			$this->form_validation->set_rules('fictxtnomlib','nombre libro','trim|required');
			$this->form_validation->set_rules('ficautor','autor','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficeditorial','editorial','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fictxtlibanio','año libro','trim|required');

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
				$fictxtidlib = base64url_decode($this->input->post('fictxtidlib'));
				$fictxtnomlib=strtoupper($this->input->post('fictxtnomlib'));
				$ficautor=$this->input->post('ficautor');
				$ficeditorial=$this->input->post('ficeditorial');
				$fictxtlibanio=$this->input->post('fictxtlibanio');

				$fictxtaccion = $this->input->post('fictxtaccion');

				if ($fictxtaccion == "INSERTAR") {
					$rpta=$this->mbiblioteca->insert_datos_libros(array($fictxtnomlib, $ficautor, $ficeditorial, $fictxtlibanio));
					if ($rpta > 0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Libro registrado correctamente";
						$dataex['idlib']=$rpta;
						
					}
				} else if ($fictxtaccion == "EDITAR") {
					$rpta=$this->mbiblioteca->update_datos_libros(array($fictxtidlib, $fictxtnomlib, $ficautor, $ficeditorial, $fictxtlibanio));
					if ($rpta == 1){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Libro Actualizado correctamente";
					}
				}

				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwasignar_ejemplar(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$this->form_validation->set_rules('fictxtidlib','codigo libro','trim|required');

			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$idlib = $this->input->post('fictxtidlib');
				$cnt = $this->input->post('txtcnt');
				if ($idlib != "") {
					$dataex['status'] =true;
					$arrayejm['cntfrm'] = $cnt;
					$dataex['vdata']=$this->load->view('biblioteca/vw_ejemplar', $arrayejm, true);
				}
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insert_ejemplares()
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

			$dataex['status'] =FALSE;
			$txtcontreg = $this->input->post('txtcontreg');
			$fictipo = $this->input->post('fictipo');
			$fictiponew = $this->input->post('fictiponew');
			$fictxtidlib = $this->input->post('txtidlibro');
			for ($i=1; $i <= $txtcontreg; $i++) {
				$fictxtlink = $this->input->post('fictxtlink'.$i);
				$fictxtnpag = $this->input->post('fictxtnpag'.$i);
				$ficestado = $this->input->post('ficestado'.$i);
				$fictxtubica = strtoupper($this->input->post('fictxtubica'.$i));
				$ficsituacion = $this->input->post('ficsituacion'.$i);
				$ficproced = $this->input->post('ficproced'.$i);
				$fictxtfecha = $this->input->post('fictxtfecha'.$i);
				$fictxtndoc = strtoupper($this->input->post('fictxtndoc'.$i));
				$fictxtprecio = $this->input->post('fictxtprecio'.$i);
				$fictxtordcom = strtoupper($this->input->post('fictxtordcom'.$i));

				
			}

			if ($fictipo == "Virtual" || $fictiponew == "Virtual") {
				$rpta=$this->mbiblioteca->insert_datos_ejemplares(array($fictxtidlib, $fictxtlink, null, null, null, 'DISPONIBLE', 'NO',NULL,NULL,NULL,NULL,NULL));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Ejemplar registrado correctamente";
					
				}
			} else if ($fictipo == "Fisico" || $fictiponew == "Fisico") {
				$rpta=$this->mbiblioteca->insert_datos_ejemplares(array($fictxtidlib, null, $fictxtnpag, $ficestado, $fictxtubica, $ficsituacion, 'SI',$ficproced,$fictxtfecha,$fictxtndoc,$fictxtprecio,$fictxtordcom));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Ejemplar registrado correctamente";
					
				}
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwhistorial_libro()
	{
		$ahead= array('page_title' =>'Historial Libros | IESTWEB'  );
		$asidebar= array('menu_padre' =>'biblioteca','menu_hijo' =>'historial');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('biblioteca/vw_historial');
		$this->load->view('footer');
	}

	public function vwmostrar_libros(){
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

			$rst = $this->mbiblioteca->m_historial_libros(array($txtnlib.'%'));
			$arrayhs['dlibros'] = $rst;
			$msgrpta=$this->load->view('biblioteca/vw_detalle_libro', $arrayhs, true);
			
		}
		
		$dataex['detallelib'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vwmostrar_librosxcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodib', 'codigo libro', 'trim|required|min_length[4]');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcodib = base64url_decode($this->input->post('txtcodib'));
			$dataex['status'] =true;
			$arrayhs['autores'] = $this->mbiblioteca->m_get_autores();
			$arrayhs['editor'] = $this->mbiblioteca->m_get_editorial();
			$arrayhs['dlibros'] = $this->mbiblioteca->m_librosxcodigo(array($txtcodib));
			$msgrpta=$this->load->view('biblioteca/libros_update', $arrayhs, true);
			
		}
		
		$dataex['libupt'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_libro()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idlibro', 'codigo Libro', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta Libro";
                $idlibro    = base64url_decode($this->input->post('idlibro'));
                
                $rpta = $this->mbiblioteca->m_elimina_lib(array($idlibro));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Libro eliminado correctamente';
                } 
                
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function vwhistorial_ejemplares()
	{
		$ahead= array('page_title' =>'Historial Ejemplares | IESTWEB'  );
		$asidebar= array('menu_padre' =>'biblioteca','menu_hijo' =>'ejemplar');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$codigolib = base64url_decode($this->input->get('code'));
		$nomlib = base64url_decode($this->input->get('book'));
		$arrayejmp['codigolib'] = $codigolib;
		$arrayejmp['nomlib'] = $nomlib;
		$arrayejmp['dejemp'] = $this->mbiblioteca->m_historial_ejemplares(array($codigolib));
		$this->load->view('biblioteca/vw_ejemplaresxlibro', $arrayejmp);
		$this->load->view('footer');
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
		$this->form_validation->set_rules('txtcodejm', 'codigo ejemplar', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcodejm = base64url_decode($this->input->post('txtcodejm'));
			$dataex['status'] =true;
			$arrayhs['dejempl'] = $this->mbiblioteca->m_ejemplaresxcodigo(array($txtcodejm));
			$msgrpta=$this->load->view('biblioteca/ejemplar_update', $arrayhs, true);
			
		}
		
		$dataex['ejmupd'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_update_ejemplares()
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

			$dataex['status'] =FALSE;
			$fictxtcodejm = base64url_decode($this->input->post('fictxtcodejm'));
			$fictipo = $this->input->post('fictipo');
			$fictxtlink = $this->input->post('fictxtlink');
			$fictxtnpag = $this->input->post('fictxtnpag');
			$ficestado = $this->input->post('ficestado');
			$fictxtubica = strtoupper($this->input->post('fictxtubica'));
			$ficsituacion = $this->input->post('ficsituacion');
			// $ficfisico = $this->input->post('ficfisico');
			$ficproced = $this->input->post('ficproced');
			$fictxtfecha = $this->input->post('fictxtfecha');
			$fictxtndoc = strtoupper($this->input->post('fictxtndoc'));
			$fictxtprecio = $this->input->post('fictxtprecio');
			$fictxtordcom = strtoupper($this->input->post('fictxtordcom'));

			if ($fictipo == "Virtual") {
				$rpta=$this->mbiblioteca->update_datos_ejemplares(array($fictxtcodejm, $fictxtlink, null, null, null, 'DISPONIBLE', 'NO',NULL,NULL,NULL,NULL,NULL));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Ejemplar actualizado correctamente";
					
				}
			} else if ($fictipo == "Fisico") {
				$rpta=$this->mbiblioteca->update_datos_ejemplares(array($fictxtcodejm, null, $fictxtnpag, $ficestado, $fictxtubica, $ficsituacion, 'SI',$ficproced,$fictxtfecha,$fictxtndoc,$fictxtprecio,$fictxtordcom));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Ejemplar actualizado correctamente";
					
				}
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminar_ejemplar()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idejmp', 'codigo Ejemplar', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta Ejemplar";
                $idejmp    = base64url_decode($this->input->post('idejmp'));
                
                $rpta = $this->mbiblioteca->m_elimina_ejm(array($idejmp));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Ejemplar eliminado correctamente';
                } 
                
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function search_libro()
    {
    	$ahead= array('page_title' =>'Busqueda de libros | IESTWEB'  );
		$asidebar= array('menu_padre' =>'biblioteca','menu_hijo' =>'busqueda');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
		$this->load->view($vsidebar,$asidebar);
		$this->load->view('biblioteca/vw_search_libro');
		$this->load->view('footer');
    }

    public function fn_search_libro(){
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

			$rst = $this->mbiblioteca->m_search_libro(array('%'.$txtnlib.'%'));
			$arrayhs['dlibros'] = $rst;
			$msgrpta=$this->load->view('biblioteca/result_search', $arrayhs, true);
			
		}
		
		$dataex['detallelib'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_vermas(){
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
			$msgrpta=$this->load->view('biblioteca/detalle_ejms', $arrayhs, true);
			
		}
		
		$dataex['ejmupd'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

}
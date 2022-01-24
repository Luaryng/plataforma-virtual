<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ubigeo extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mubigeo');
	}


	public function fn_distritos_all()
    {
        $dataex['status'] =false;
        $data="";
        if($this->input->is_ajax_request()){
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $dataex['status'] =true;
            $data = "";
            $nombre = $this->input->post('search');
            $distritos = $this->mubigeo->m_distritosxnombre('%'.$nombre.'%');
            foreach ($distritos as $key => $dtrs) {
                
                $data .= "<div><a class='suggest-element' id='$dtrs->codigo' data='$dtrs->nombre - $dtrs->nombreprv - $dtrs->nombredep'>$dtrs->nombre - $dtrs->nombreprv - $dtrs->nombredep</a></div>";
                
            }
            
        }
        $dataex['vdata'] = $data;
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    
    }

	public function fn_departamentos()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin opciones</option>";
		if ($this->input->is_ajax_request())
		{
			
			$busqueda=$this->input->post('txtcoddepa');

			$provincias=$this->mubigeo->m_departamentos();
			if (count($provincias)>0) $rsoptions="<option value='0'>Seleccionar Departamento</option>";
			foreach ($provincias as $provincia) {
				$rsoptions=$rsoptions."<option value='$provincia->codigo'>$provincia->nombre</option>";
			}
			$dataex['status'] =TRUE;
			
		}
		$dataex['vdata'] =$rsoptions;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_get_ubigeo()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin opciones</option>";
		$rsdepartamentos=array();
		$rsprovincias=array();
		$rsdistritos=array();
		if ($this->input->is_ajax_request())
		{
			
			$textdepa=$this->input->post('textdepa');
			$textprov=$this->input->post('textprov');
			$textdist=$this->input->post('textdist');

			$codselect=0;
			
			$departamentos=$this->mubigeo->m_departamentos();
			if (count($departamentos)>0) $rsdepartamentos="<option value='0'>Seleccionar Departamento</option>";
			foreach ($departamentos as $departamento) {
				$textselect="";
				if ($textdepa==$departamento->nombre){
					$codselect=$departamento->codigo;
					$textselect="selected";
				}
				$rsdepartamentos=$rsdepartamentos."<option $textselect value='$departamento->codigo'>$departamento->nombre</option>";
			}

			if ($codselect>0){
				
				$provincias=$this->mubigeo->m_provincias(array($codselect));
				$codselect=0;
				if (count($provincias)>0) $rsprovincias="<option value='0'>Seleccionar Provincia</option>";
				foreach ($provincias as $provincia) {
					$textselect="";
					if ($textprov==$provincia->nombre){
						$codselect=$provincia->codigo;
						$textselect="selected";
					}
					$rsprovincias=$rsprovincias."<option $textselect value='$provincia->codigo'>$provincia->nombre</option>";
				}
			}

			if ($codselect>0){
				
				$distritos=$this->mubigeo->m_distritos(array($codselect));
				$codselect=0;
				if (count($distritos)>0) $rsdistritos="<option value='0'>Seleccionar Provincia</option>";
				foreach ($distritos as $distrito) {
					$textselect="";
					if ($textdist==$distrito->nombre){
						$codselect=$distrito->codigo;
						$textselect="selected";
					}
					$rsdistritos=$rsdistritos."<option $textselect value='$distrito->codigo'>$distrito->nombre</option>";
				}
			}

			$dataex['status'] =TRUE;
			
		}
		$dataex['vdepa'] =$rsdepartamentos;
		$dataex['vprov'] =$rsprovincias;
		$dataex['vdist'] =$rsdistritos;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}


	public function fn_provincia_x_departamento()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin opciones</option>";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcoddepa','Búsqueda','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda=$this->input->post('txtcoddepa');

				$provincias=$this->mubigeo->m_provincias(array($busqueda));
				if (count($provincias)>0) $rsoptions="<option value='0'>Seleccionar Provincia</option>";
				foreach ($provincias as $provincia) {
					$rsoptions=$rsoptions."<option value='$provincia->codigo'>$provincia->nombre</option>";
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rsoptions;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_distrito_x_provincia()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin opciones</option>";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodprov','Búsqueda','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda=$this->input->post('txtcodprov');
				$distritos=$this->mubigeo->m_distritos(array($busqueda));
				if (count($distritos)>0) $rsoptions="<option value='0'>Seleccionar Distrito</option>";
				foreach ($distritos as $distrito) {
					$rsoptions=$rsoptions."<option value='$distrito->codigo'>$distrito->nombre</option>";
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rsoptions;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}
	public function nuevo_ubigeo()
	{
		$ahead= array('page_title' =>'Ubigeo | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'ubigeo');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$data = $this->mubigeo->m_ubigeo();
		$this->load->view('ubigeo/vw_ubigeo', $data);
		$this->load->view('footer');
	}

	public function search_data_ubigeo()
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

			$nomdep = $this->input->post('nomdep');
			$txtubigeo = $this->input->post('txtubigeo');
			$busqueda = "";

			if ($nomdep == "%" || $nomdep == "") {
				$busqueda = '%'.$nomdep.'%';
			} else {
				$busqueda = $nomdep;
			}

			$dataubigeo = $this->mubigeo->m_ubigeoxnombres($busqueda, $txtubigeo);
			if ($dataubigeo > 0) {
				foreach ($dataubigeo as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->codigo);
				}
                $dataex['status'] = true;
                $dataex['datos'] = $dataubigeo;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insert_depart()
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
			
			$this->form_validation->set_rules('fitxtdepart','nombre departamento','trim|required');
			
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
				$fitxtdepart=strtoupper($this->input->post('fitxtdepart'));

				$rpta=$this->mubigeo->insert_datos_departamento(array($fitxtdepart));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Departamento registrada correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_depart()
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
			
			$this->form_validation->set_rules('fitxtidep','codigo departamento','trim|required');
			$this->form_validation->set_rules('fitxtdeped','nombre departamento','trim|required');
			
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
				$fitxtidep=$this->input->post('fitxtidep');
				$fitxtdeped=strtoupper($this->input->post('fitxtdeped'));

				$rpta=$this->mubigeo->update_datos_departamento(array($fitxtidep, $fitxtdeped));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Departamento Actualizado correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminardepart()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('iddepart', 'codigo Departamento', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar el registro";
                $iddepart    = base64url_decode($this->input->post('iddepart'));
                
                $rpta = $this->mubigeo->m_eliminadepart(array($iddepart));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Departamento eliminado correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_insert_provin()
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
			
			$this->form_validation->set_rules('fitxtprovinc','nombre provincia','trim|required');
			$this->form_validation->set_rules('ficdepart','departamento','trim|required|is_natural_no_zero');
			
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
				$fitxtprovinc=strtoupper($this->input->post('fitxtprovinc'));
				$ficdepart=$this->input->post('ficdepart');

				$rpta=$this->mubigeo->insert_datos_provincia(array($fitxtprovinc, $ficdepart));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Provincia registrada correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_prov()
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
			
			$this->form_validation->set_rules('fitxtidpr','codigo provincia','trim|required');
			$this->form_validation->set_rules('fitxtproved','nombre provincia','trim|required');
			$this->form_validation->set_rules('ficdeped','departamento','trim|required|is_natural_no_zero');
			
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
				$fitxtidpr=$this->input->post('fitxtidpr');
				$fitxtproved=strtoupper($this->input->post('fitxtproved'));
				$ficdeped=$this->input->post('ficdeped');

				$rpta=$this->mubigeo->update_datos_provincia(array($fitxtidpr, $fitxtproved, $ficdeped));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Provincia Actualizada correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminarprovc()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idprov', 'codigo Provincia', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar la Provincia";
                $idprov    = base64url_decode($this->input->post('idprov'));
                
                $rpta = $this->mubigeo->m_eliminaprovinc(array($idprov));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Provincia eliminada correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_insert_distrito()
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
			
			$this->form_validation->set_rules('fitxtdistr','nombre distrito','trim|required');
			$this->form_validation->set_rules('ficprovinc','provincia','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficdepartam','Departamento','trim|required|is_natural_no_zero');
			
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
				$fitxtdistr=strtoupper($this->input->post('fitxtdistr'));
				$ficprovinc=$this->input->post('ficprovinc');

				$rpta=$this->mubigeo->insert_datos_distrito(array($fitxtdistr, $ficprovinc));
				if ($rpta > 0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Distrito registrada correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_distr()
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
			
			$this->form_validation->set_rules('fitxtidist','codigo Distrito','trim|required');
			$this->form_validation->set_rules('fitxtdisted','nombre Distrito','trim|required');
			$this->form_validation->set_rules('ficproved','provincia','trim|required|is_natural_no_zero');
			
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
				$fitxtidist=$this->input->post('fitxtidist');
				$fitxtdisted=strtoupper($this->input->post('fitxtdisted'));
				$ficproved=$this->input->post('ficproved');

				$rpta=$this->mubigeo->update_datos_distrito(array($fitxtidist, $fitxtdisted, $ficproved));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Distrito Actualizada correctamente";
					// $dataex['newcod'] =$newcod;
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fneliminardistr()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idistrit', 'codigo Distrito', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar el distrito";
                $idistrit    = base64url_decode($this->input->post('idistrit'));
                
                $rpta = $this->mubigeo->m_eliminadistrit(array($idistrit));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Distrito eliminado correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }
}
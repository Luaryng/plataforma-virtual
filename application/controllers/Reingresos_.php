<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reingresos extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('minscrito');
	}
	
	public function fn_reingresos(){
		
			$ahead= array('page_title' =>'Admisión | IESTWEB'  );
			$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'reingreso');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
        	$this->load->view($vsidebar,$asidebar);

			if (getPermitido("112")=='SI'){
				$this->load->model('mmodalidad');
				$a_ins['modalidades']=$this->mmodalidad->m_get_modalidades();
				$this->load->model('mperiodo');
				$a_ins['periodos']=$this->mperiodo->m_get_periodos();
				$this->load->model('mcarrera');
				$a_ins['carreras']=$this->mcarrera->m_get_carreras_abiertas_por_sede($_SESSION['userActivo']->idsede);

				$this->load->model('mtemporal');
				$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
				$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
				$a_ins['secciones']=$this->mtemporal->m_get_secciones();
				$a_ins['docs_anexar']=$this->mtemporal->m_get_docs_por_anexar();
				$this->load->view('admision/reingresantes',$a_ins);
			}
			else{

				$this->load->view('errors/sin-permisos');
			}
			
			
			$this->load->view('footer');
	}

	public function fn_getdocanexados(){
	
		$this->form_validation->set_message('required', '%s Requerido');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$fila= array('idinscripcion' => '0');
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('ce-idins','Carné','trim|required|min_length[4]');
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
				$busqueda=base64url_decode($this->input->post('ce-idins'));
				$rsfila=$this->minscrito->m_get_docsanexados(array($busqueda));
				$dataex['status'] =TRUE;
				$dataex['vdata'] =$rsfila;
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function get_filtrar_basico_sd_retirados(){
		$this->form_validation->set_message('required', '%s Requerido o digite %%%%%%%%');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fbus-txtbuscar','búsqueda','trim|required|min_length[4]');
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
				$busqueda=$this->input->post('fbus-txtbuscar');
				$carrera=$this->input->post('fbus-carrera');
				$periodo=$this->input->post('fbus-periodo');
				$cuentas['historial']=$this->minscrito->m_filtrar_basico_sd_retirados(array($periodo,$carrera,'%','%'.$busqueda.'%',));
				$conteo=count($cuentas['historial']);
				if ($conteo>0)
				{
					$dataex['conteo'] =$conteo;
					$rscuentas=$this->load->view('admision/reingresos-lts',$cuentas,TRUE);
				}
				else
				{
					$rscuentas=$this->load->view('errors/sin-resultados',array(),TRUE);
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insert_reingreso()
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

			$this->form_validation->set_rules('vw_fcb_codinscripcion','Identifcador','trim|required');
			$this->form_validation->set_rules('vw_fcb_codmodalidad','Modalidad','trim|required');
			$this->form_validation->set_rules('vw_fcb_cbperiodo','Periodo','trim|required');
			$this->form_validation->set_rules('vw_fcb_campania','Campaña','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('vw_fcb_cbciclo','Ciclo','trim|required');
			$this->form_validation->set_rules('vw_fcb_fecha','Fecha','trim|required');
			// $this->form_validation->set_rules('vw_fcb_cbobservacion','Observación','trim|required');

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
				date_default_timezone_set ('America/Lima');

				$fimcid=base64url_decode($this->input->post('vw_fcb_codinscripcion'));
				
				$ficbmodalidad = $this->input->post('vw_fcb_codmodalidad');
				$ficbperiodo = $this->input->post('vw_fcb_cbperiodo');
				$ficbcampania = $this->input->post('vw_fcb_campania');
				$ficbciclo = $this->input->post('vw_fcb_cbciclo');
				$fitxtobservaciones = strtoupper($this->input->post('vw_fcb_cbobservacion'));
				$fecharegistro = date('Y-m-d H:i:s');
				$fitxtfecinscripcion = $this->input->post('vw_fcb_fecha').' '.date('H:i:s');
				$ficbturno=$this->input->post('ficbturno');
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;



				//datos para PROYECTAR MATRICULA
				$ficbcarrera=$this->input->post('ficbcarrera');
				$fmtapepaterno = $this->input->post('txtpaterno');
				$fmtapematerno = $this->input->post('txtmaterno');
				$fmtnombres = $this->input->post('txtnombres');
				$fmtsexo = $this->input->post('txtsexo');

                $accion = "INSERTAR";

				$newcod=$this->minscrito->m_insert_reingreso(array($fimcid,$ficbmodalidad,$ficbperiodo,$sede,$ficbcampania,$ficbciclo,$fitxtobservaciones,$fecharegistro,$fitxtfecinscripcion,'0',$usuario,$ficbturno));
				

				if ($newcod->salida == 1){

					//PROYECTAR MATRICULA
					$this->load->model('mmatricula');
					$rsrow=$this->mmatricula->m_insert(array($fimcid,"O","1",$ficbperiodo,$ficbcarrera,$ficbciclo,$ficbturno,$ficbseccion,0,5,$fitxtfecinscripcion,"",0,$fmtapepaterno,$fmtapematerno,$fmtnombres,$fmtsexo));


					$data          = json_decode($_POST['filas']);
                
					$rsfila=$this->minscrito->m_insertdocs(array($fimcid,$data));

					$dataex['status'] =TRUE;
					$dataex['msg'] ="File aperturado correctamente";
					$dataex['newcod'] =base64url_encode($fimcid);
					
				}
				elseif ($newcod->salida == 0){
					$dataex['newcod'] =base64url_encode($fimcid);
					$dataex['msg'] ="El Alumno ya se encuentra inscrito en el periodo ".$ficbperiodo;
				}
				
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}


}
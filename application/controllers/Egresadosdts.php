<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Egresadosdts extends CI_Controller {
	function __construct() {
		parent::__construct();
//		$this->load->model('macciones');
		}
	
	public function egresados(){

		$ahead= array('page_title' =>'IESTWEB - Seguimiento de Egresados'  );
		$asidebar= array('menu_padre' =>'egresados','menu_hijo' =>'seg-egresados');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('egresados/seguimiento_egresados');
		$this->load->view('footer');
	}

	public function dtsegresados(){
		$this->load->model('megresados');
		$datos = $this->megresados->m_datos_egresados();
		if(count($datos)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($datos as $key => $value) {

	 					/*=============================================
			CARACTERÍSTICAS
			========================================s=====*/	

			$caracteristicas = "";

			$jsonIncluye = json_decode($value->detalle, true);

			foreach ($jsonIncluye as $indice => $valor) {

				$caracteristicas .= "<div class='badge badge-secondary mx-1'>".$valor["item"]."</div> - ";
				$datoscaract = substr($caracteristicas, 0, -2);
			}

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$value->apenom.'",
						"'.$value->dni.'",
						"'.$value->telefono.'",
						"'.$value->email.'",
						"'.$value->carrera.'",
						"'.$value->condicion.'",
						"'.$value->egreso.'",
						"'.$value->contrab.'",
						"'.$value->proced.'",
						"'.$value->cartaller.'",
						"'.$datoscaract.'",
						"'.$value->sugerencia.'",
						"'.$value->testimonio.'",
						"'.$value->autoriza.'"
						
				],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;
	}

	public function estudiantes()
	{
		$ahead= array('page_title' =>'IESTWEB - Seguimiento de Estudiantes'  );
		$asidebar= array('menu_padre' =>'seguimiento','menu_hijo' =>'seg-estudiantes');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('egresados/seguimiento_estudiantes');
		$this->load->view('footer');
	}

	public function dtsestudiantes()
	{
		$this->load->model('megresados');
		$datos = $this->megresados->m_datos_estudiantes();
		if(count($datos)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($datos as $key => $value) {

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$value->apenom.'",
						"'.$value->dni.'",
						"'.$value->telefono.'",
						"'.$value->email.'",
						"'.$value->carrera.'",
						"'.$value->ingreso.'",
						"'.$value->semestre.'",
						"'.$value->modulo.'",
						"'.$value->sugerencia.'"
						
				],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;
	}

}
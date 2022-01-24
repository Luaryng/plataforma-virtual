<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencias_sesiones extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('marea');
		$this->load->model('mdocentes');
		$this->load->model('mauditoria');
		$this->load->model('masistencias_sesiones');
	}

	public function vw_asistencias_docentes()
    {
        $ahead = array('page_title' => 'ADMISIÓN | '.$this->ci->config->item('erp_title'));
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        $asidebar = array('menu_padre' => 'mn_tramites', 'menu_hijo' => 'mn_mesa');
        $vsidebar = ($_SESSION['userActivo']->tipo == 'AL') ? "sidebar_alumno" : "sidebar";
        $this->load->view($vsidebar, $asidebar);
		$docs['docentes']=$this->mdocentes->m_get_docentes();
        $this->load->view('asistencias/vw_docentes',$docs);
        $this->load->view('footer');
    }

    public function fn_filtrar_asistencias()
    {
    	$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$rpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('fictxtfecha_asistencia', 'Fecha', 'trim|required');
		$this->form_validation->set_rules('fictxtfecha_asistenciaf', 'Fecha final', 'trim|required');
		$this->form_validation->set_rules('fictxt_docente', 'Docente', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg']="Existen errores en los campos";
			$errors = array();
	        foreach ($this->input->post() as $key => $value){
	            $errors[$key] = form_error($key);
	        }
	        $dataex['errors'] = array_filter($errors);
		}
		else{
			$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");

			$codigo = base64url_decode($this->input->post('fictxt_docente'));
			$fecha = $this->input->post('fictxtfecha_asistencia');
			$fechafin = $this->input->post('fictxtfecha_asistenciaf');
			$dataex['status'] =true;

			$agrupar = "";
			$agrupar2 = "";
			$divrpta = "<div class='text-danger'><i class='fas fa-exclamation-circle'></i> SIN RESULTADOS</div>";
			
			$rpta = $this->masistencias_sesiones->m_get_asistencias(array($codigo,$codigo,$fecha,$fechafin));
			// $dataex['data'] = $rpta;

			if (count($rpta) > 0) {
				$divrpta = "<div class='col-12 py-1'>
								<div class='btable'>
									<div class='thead col-12 d-none d-md-block'>
			                            <div class='row'>
			                                <div class='col-12 col-md-3 p-2 td'>
			                                    <b class='text-uppercase'>UNIDAD DIDAC.</b>
			                                </div>
			                                <div class='col-12 col-md-2 p-2 td'>
			                                    <b class='text-uppercase'>FECHA SESIÓN</b>
			                                </div>
			                                <div class='col-12 col-md-2 p-2 td'>
			                                    <b class='text-uppercase'>HORA SESIÓN</b>
			                                </div>
			                                <div class='col-12 col-md-2 p-2 td'>
			                                    <b class='text-uppercase'>ASISTIÓ</b>
			                                </div>
			                                <div class='col-12 col-md-2 p-2 td'>
			                                    <b class='text-uppercase'>Hora/Min</b>
			                                </div>
			                                <div class='col-12 col-md-1 p-2 td'>
			                                    <b class='text-uppercase'>Obs.</b>
			                                </div>
			                            </div>
			                        </div>";

				foreach ($rpta as $key => $asist) {
					// $grupoint = $asist->idunidad.$asist->unidad;
					$grupoint = ($asist->unidad != null) ? $asist->unidad : $asist->unidad2;
					$fechass = new DateTime($asist->sesfecha);
					$fechases = $dias[$fechass->format('w')].". ".$fechass->format('d/m/Y');
					$horases = date("h:i a",strtotime($asist->horaini))." - ".date("h:i a",strtotime($asist->horafin));

					$afecha = new DateTime($asist->fecha);
					$fechasist = $dias[$afecha->format('w')].". ".$afecha->format('d/m/Y h:i a');

					$horasist = $afecha->format('H:i');
					$asishora = new DateTime($horasist);
					$seshorini = new DateTime($asist->horaini);
					$seshora = new DateTime($asist->horafin);

					$diferencia = $asishora->diff($seshora);
					$observ = "";

					if ($asishora > $seshorini) {
						$observ = "Tarde";
					}

					if ($asist->fecha == null) {
						$observ = "No asistio";
						$fechasist = "";
						$tiempo = "";
					} else {
						$tiempo = $diferencia->format('%H horas %i minutos');
					}

					if ($grupoint != $agrupar) {
						if($agrupar!="") $divrpta .= "</div><br>";
						$agrupar = $grupoint;
						$divrpta .= "<div class='thead col-12'>
			                            <div class='row'>
			                                <div class='col-12 col-md-12 p-2 bg-lightgray'>
			                                    <b class='text-uppercase'>$agrupar</b>
			                                </div>
			                            </div>
			                            
			                        </div>
			                        <div class='tbody col-12'>";


					}

					$divrpta .= "<div class='row bg-white'>";
					$grupoint2 = $asist->idses.$asist->detalle.$fechases;
					if ($grupoint2 != $agrupar2) {
						$agrupar2 = $grupoint2;
						$divrpta .= "<div class='col-12 col-md-3 td'>
										<span class='text-uppercase'>$asist->detalle</span>
									</div>
									<div class='col-12 col-md-2 td'>
										<span><b class='d-md-none d-sm-block'>Inicia:</b> $fechases</span>
									</div>
									<div class='col-12 col-md-2 td'>
										<span><b class='d-md-none d-sm-block'>Culmina:</b> $horases</span>
									</div>";
						
					} else {
						$divrpta .= "<div class='col-12 col-md-7 td d-none d-md-block'></div>";
					}
							
						$divrpta .= "<div class='col-12 col-md-2 td'>
										<span><b class='d-md-none d-sm-block'>Asistió:</b> $fechasist </span>
									</div>
									<div class='col-12 col-md-2 td'>
										<span><b class='d-md-none d-sm-block'>Hora/min:</b> $tiempo</span>
									</div>
									<div class='col-12 col-md-1 td'>
										<span><b class='d-md-none d-sm-block'>Obs.:</b> $observ</span>
									</div>
								</div>";
				}

				$divrpta .= "
						</div>
					</div>";

			}
			
		}
		
		$dataex['vdata'] = $divrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }
	
    public function vw_asistencias_docentes_pdf()
    {
    	$dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        $cdocente = base64url_decode($this->input->get('dc'));
        $fecha = $this->input->get('fi');
        $fechafin = $this->input->get('ff');
        $docente = base64url_decode($this->input->get('ndc'));
        
        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();
        
        $rpta = $this->masistencias_sesiones->m_get_asistencias(array($cdocente,$cdocente,$fecha,$fechafin));
        
        
        $dominio=str_replace(".", "_",getDominio());
        $html1=$this->load->view("asistencias/pdf_reporte_asistencias_docente", array('ies' => $ie,'cursos' => $rpta,'docente' => $docente),true);
       
        $pdfFilePath = "REPORTE ACADÉMICO_".$docente.".pdf";

        $this->load->library('M_pdf');
        $formatoimp="A4";
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]);
        $mpdf->SetTitle( "REPORTE ACADÉMICO_".$docente);
        $mpdf->WriteHTML($html1);
        
        $mpdf->Output($pdfFilePath, "I");
    }


	

}
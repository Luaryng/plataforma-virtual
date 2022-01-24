<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'libraries/phpexcel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;

class Tesoreria_matricula extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mmatricula');
	}

	public function vw_matricula()
    {
        if (getPermitido("126")=='SI'){
    		$ahead= array('page_title' =>'Matriculas | IESTWEB'  );
    		$asidebar= array('menu_padre' =>'mn_ts_matriculas','menu_hijo' =>'','menu_nieto' =>'');
    		$this->load->view('head',$ahead);
    		$this->load->view('nav');
    		$this->load->view('sidebar_facturacion',$asidebar);
    		
            $this->load->model('mcarrera'); 
            $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
    		$this->load->model('mbeneficio');		
    		$a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();

            $this->load->model('mperiodo');
    		$a_ins['periodos']=$this->mperiodo->m_get_periodos();
    		$this->load->model('mtemporal');
    		$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
    		//$this->load->model('mcarrera');
    		$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
    		//$this->load->model('mcarrera');
    		$a_ins['secciones']=$this->mtemporal->m_get_secciones();
            $this->load->model('mplancurricular');
            $a_ins['planes']=$this->mplancurricular->m_get_planes_activos();
    		//$modl=$this->mmodalidad->m_modalidad();
    		$this->load->view('matricula/vw_matriculas_tesoreria',$a_ins);
	        $this->load->view('footer');
        } else {
            $urlref=base_url();
            header("Location: $urlref", FILTER_SANITIZE_URL);
        }
	}
  //√

    public function fn_filtrar()
    {
        $this->form_validation->set_message('required', '%s Requerido');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $dataex['msg']="jajaajj";
            $fmcbperiodo=$this->input->post('fmt-cbperiodo');
            $fmcbcarrera=$this->input->post('fmt-cbcarrera');
            $fmcbciclo=$this->input->post('fmt-cbciclo');
            $fmcbturno=$this->input->post('fmt-cbturno');
            $fmcbseccion=$this->input->post('fmt-cbseccion');
            $fmcbplan=$this->input->post('fmt-cbplan');
            $fmalumno=$this->input->post('fmt-alumno');

            $cuentas=$this->mmatricula->m_filtrar(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$fmalumno.'%'));
            $dataex['vdata'] =$cuentas;
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_filtrar_cur_ad()
    {
        $this->form_validation->set_message('required', '%s Requerido');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

               $dataex['msg']="jajaajj";
                $fmcbperiodo=$this->input->post('fmt-cbperiodo');
                $fmcbcarrera=$this->input->post('fmt-cbcarrera');
                $fmcbciclo=$this->input->post('fmt-cbciclo');
                $fmcbturno=$this->input->post('fmt-cbturno');
                $fmcbseccion=$this->input->post('fmt-cbseccion');
                $fmalumno=$this->input->post('fmt-alumno');
                
                $cuentas=$this->mmatricula->m_filtrar_cur_ad(array($fmcbperiodo,$fmcbcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$fmalumno.'%'));
                $dataex['vdata'] =$cuentas;
                $dataex['status'] = true;
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_update_bloqueo()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            if (getPermitido("127")=='SI'){
                $dataex['status'] = false;
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('filas', 'datos', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } else {
                    $dataex['msg'] = "Ocurrio un error al intentar actualizar el estado";
                    $data          = json_decode($_POST['filas']);
                    
                    foreach ($data as $value) {
                                        
                        $rpta = $this->mmatricula->m_update_mostrar_evaluaciones(array(base64url_decode($value[0]),$value[1]));
                        
                    }
                    
                    if ($rpta->salida == "1") {
                        $dataex['msg'] = "datos actualizados";
                        $dataex['status'] = true;
                    }
                    

                }
            } else {
                $dataex['msg'] = "No tienes acceso para esta acción";
                $dataex['status'] = false;
            }
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function uploadExcel()
    {
        if ($_FILES['vw_mpc_file']['name']) {
            if (!$_FILES['vw_mpc_file']['error']) {
                $name = $_FILES['vw_mpc_file']['name'];//md5(Rand(100, 200));
                $ext = explode('.', $_FILES['vw_mpc_file']['name']);
                $ult=count($ext);
                $nro_rand=rand(0,9);
                $nro_rand2=rand(0,100);
                $NewfileName  = "mtr_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$nro_rand2;
                $filename = $NewfileName.".".$ext[$ult-1];//. '.' . $ext[1];
                
                $destination = './upload/' .$filename ; //change this directory
                $location = $_FILES["vw_mpc_file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                
                $dataex['msg'] = 'Archivo subido correctamente';
                $dataex['link'] = $filename;

                
            }
            else {
                $dataex['msg'] = 'Se ha producido el siguiente error:  '.$_FILES['vw_mpc_file']['error'];
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_update_datos_personales()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';

        if ($this->input->is_ajax_request()) {
            if (getPermitido("127")=='SI'){
                $this->form_validation->set_message('required', '%s Requerido');
                $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
                $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
                $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
                $this->form_validation->set_rules('file', 'archivo', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } else {
                    $dataex['msg']  = "Ocurrio un error al insertar la Nueva Planilla.";
                    $file   = $this->input->post('file');

                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    $spreadsheet = $reader->load("upload/" . $file);

                    //$spreadsheet = new Spreadsheet();
                    $spreadsheet->setActiveSheetIndex(0);
                    $sheet = $spreadsheet->getActiveSheet();

                    $highestRow = $sheet->getHighestRow(); 
                    $highestColumn = $sheet->getHighestColumn();

                    $dataex['nrofilas'] = $highestRow;

                    $dataex['msg']       = "Tiempo de espera superado,vuelva a intentarlo";
                    if (isset($file)) {
                        
                        $dataex['msg']       = "No se encontro el Archivo de Excel";
                        $datarows = array();
                        $num = 0;
                        for ($row = 2; $row <= $highestRow; $row++){ 
                            $num++;
                            $periodo = $sheet->getCell("A".$row)->getValue();
                            $carne = $sheet->getCell("B".$row)->getValue();
                            $bloqueo = $sheet->getCell("D".$row)->getValue();
                            if (($periodo !== NULL) && ($carne !== NULL) && ($bloqueo !== NULL)) {
                                $arrayName = array($periodo, $carne, $bloqueo);
                                $datarows[$row]=$arrayName;
                            }
                            
                        }

                        if ($highestRow > 401) {
                            $dataex['status'] = false;
                            $dataex['msg'] = "Ha excedido a las 400 matriculas";
                        } else {
                            $dataex['conteo'] = count($datarows);
                            $dataex['datos'] = $datarows;

                            foreach ($datarows as $key => $fila) {
                                $rptarow = $this->mmatricula->m_update_bloquea_evaluaciones($fila);
                            }

                            if ($rptarow->salida == "1") {
                                $dataex['status'] = true;
                                $dataex['msg'] = "Datos actualizados correctamente";
                            }
                        }
                        
                    }

                }
            } else {
                $dataex['msg'] = "No tienes acceso para esta acción";
                $dataex['status'] = false;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }


}

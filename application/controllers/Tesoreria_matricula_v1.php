<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tesoreria_matricula extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mmatricula');
        $this->load->model('mtesoreria_matricula');
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

    /*public function fn_filtrar()
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
            $fmalumno=str_replace(" ","%",$fmalumno);
            $cuentas=$this->mmatricula->m_filtrar(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$fmalumno.'%'));
            $dataex['vdata'] =$cuentas;
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }*/

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

    public function fn_asistencias_alumno()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
        $dataex['status'] = false;
        $urlRef           = base_url();
        $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
        $rst="";
        $this->form_validation->set_rules('cbperiodo', 'Periodo', 'trim|required');
        $this->form_validation->set_rules('txtbusca_carne', 'Nro Carné', 'trim|required|min_length[6]|max_length[20]');
        if ($this->form_validation->run() == false) {
            $dataex['msg'] = validation_errors();
        } else {
            $cbper     = base64url_decode($this->input->post('cbperiodo'));
            $tcar      = $this->input->post('txtbusca_carne');
            $matricula = $this->mmatricula->m_matricula_x_periodo_carne(array($tcar,$cbper));
            $cmat      = $matricula->codigo;
            $cmat64      = base64url_encode($cmat) ;

            $dataex['carnet'] = $matricula->carne;
            $dataex['alumno'] = $matricula->alumno;
            $dataex['miscursos'] = $this->mmatricula->m_miscursos_x_matricula(array($cmat));
            $dataex['miscursosesta'] = $this->mmatricula->m_miscursos_x_mat_asist_estadistica(array($cmat));
            
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_notas_alumno()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
        $dataex['status'] = false;
        $urlRef           = base_url();
        $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
        $rst="";
        $this->form_validation->set_rules('cbperiodo', 'Periodo', 'trim|required');
        $this->form_validation->set_rules('txtbusca_carne', 'Nro Carné', 'trim|required|min_length[6]|max_length[20]');
        if ($this->form_validation->run() == false) {
            $dataex['msg'] = validation_errors();
        } else {
            $cbper     = base64url_decode($this->input->post('cbperiodo'));
            $tcar      = $this->input->post('txtbusca_carne');
            $matricula = $this->mmatricula->m_matricula_x_periodo_carne(array($tcar,$cbper));
            $cmat      = $matricula->codigo;
            $cmat64      = base64url_encode($cmat) ;

            $dataex['carnet'] = $matricula->carne;
            $dataex['alumno'] = $matricula->alumno;
            $dataex['miscursos'] = $this->mmatricula->m_miscursos_x_matricula(array($cmat));
            
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_docpagos_alumno()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
        $dataex['status'] = false;
        $urlRef           = base_url();
        $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
        $rst="";
        $this->form_validation->set_rules('cbperiodo', 'Periodo', 'trim|required');
        $this->form_validation->set_rules('txtbusca_carne', 'Nro Carné', 'trim|required|min_length[6]|max_length[20]');
        if ($this->form_validation->run() == false) {
            $dataex['msg'] = validation_errors();
        } else {
            $cbper     = base64url_decode($this->input->post('cbperiodo'));
            $tcar      = $this->input->post('txtbusca_carne');
            $matricula = $this->mtesoreria_matricula->m_matricula_x_periodo_carnetes(array($tcar,$cbper));
            $cmat      = $matricula->codigo;
            $cmat64      = base64url_encode($cmat) ;

            $dataex['carnet'] = $matricula->carne;
            $dataex['alumno'] = $matricula->alumno;
            $tabody="";
            $rptapagos = $this->mtesoreria_matricula->m_pagos_xcarne(array($matricula->tipodoc, $matricula->dni));
            $rptdetalle = $this->mtesoreria_matricula->m_pagos_detalle_xcarne(array($matricula->tipodoc, $matricula->dni));
            $nro = 0;
            if (count($rptapagos) > 0) {
                
                foreach ($rptapagos as $key => $value) {
                    $nro++;
                    $codigodoc = $value->codigo;
                    $datemis =  new DateTime($value->fecha_hora) ;
                    $emisionf = $datemis->format('d/m/Y h:i a');
                    // $rowcolor = "";
                    $rowcolor = ($nro % 2 == 0) ? 'bg-lightgray' : '';
                    $tabody = $tabody.
                    '<div class="rowsfila row '.$rowcolor.'" data-codigo="'.$codigodoc.'">
                        <div class="col-6 col-md-3 td">'
                            .$value->tipodoc.' '.$value->serie.'-'.$value->numero .'<br>
                            <small>'.$emisionf.'</small>
                        </div>
                        <div class="col-12 col-md-9">
                          <div class="row">
                            <div class=" col-4 col-md-6 td">'.$value->codpagante.' - '.$value->pagante.'</div>
                            <div class=" col-4 col-md-3 td text-right">S/. '.$value->total.'</div>
                            <div class=" col-4 col-md-3 td text-right">S/. '.$value->migv.'</div>
                          </div>
                        </div>
                    </div>';

                    foreach ($rptdetalle as $key => $fila) {
                        $preunit = number_format($fila->mpunit, 2);
                        $igv = number_format($fila->migv, 2);
                        if ($fila->iddoc == $codigodoc) {
                            
                            $tabody = $tabody.
                            '<div class="rowsdetalle row ' . $rowcolor . ' ">
                                <div class="col-6 col-md-3 td"></div>
                                <div class="col-12 col-md-9">
                                  <div class="row">
                                    <div class=" col-4 col-md-6 td">'.$fila->gestion.'</div>
                                    <div class=" col-4 col-md-3 td text-right">S/. '.$preunit.'</div>
                                    <div class=" col-4 col-md-3 td text-right">S/. '.$igv.'</div>
                                  </div>
                                </div>
                            </div>';
                        }
                    }
                }
                $mensaje = count($rptapagos)." documentos de pago encontradas";
                $alto = "300px";
            } else {
                $mensaje = "No se encontraron documentos de pago";
                $alto = "auto";
            }
            
            $dataex['mensaje'] = $mensaje;
            $dataex['alto'] = $alto;
            $dataex['pagos'] = $tabody;
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_update_bloqueo()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            if (getPermitido("127")=='SI'){
                $dataex['status'] = false;
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('idmatricula', 'codigo', 'trim|required');
                $this->form_validation->set_rules('estado', 'estado', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } else {
                    $dataex['msg'] = "Ocurrio un error al intentar actualizar el estado";
                    $codigo          = $this->input->post('idmatricula');
                    $estado          = $this->input->post('estado');
                                        
                    $rpta = $this->mmatricula->m_update_mostrar_evaluaciones(array(base64url_decode($codigo),$estado));
                    
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


}

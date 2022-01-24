<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notas_matricula extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mnotas_descarga');
        $this->load->model('mauditoria');
	}

	public function vw_notas_principal()
    {
        if (getPermitido("128")=='SI'){
    		$ahead= array('page_title' =>'Descargar notas | IESTWEB'  );
    		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'mn_acad_notas','menu_nieto' =>'');
    		$this->load->view('head',$ahead);
    		$this->load->view('nav');
    		$this->load->view('sidebar',$asidebar);
    		
            $this->load->model('mcarrera'); 
            $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
    		$this->load->model('mbeneficio');		
    		$a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();

            $this->load->model('mperiodo');
    		$a_ins['periodos']=$this->mperiodo->m_get_periodos();
    		$this->load->model('mtemporal');
    		$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
    		$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
    		$a_ins['secciones']=$this->mtemporal->m_get_secciones();
            $this->load->model('mplancurricular');
            $a_ins['planes']=$this->mplancurricular->m_get_planes_activos();
    		$this->load->view('descarganotas/vw_notas_descarga',$a_ins);
	        $this->load->view('footer');
        } else {
            $urlref=base_url();
            header("Location: $urlref", FILTER_SANITIZE_URL);
        }
	}

    public function fn_get_carga_por_grupo_notas()
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
            $this->form_validation->set_rules('fmt-cbperiodo','Periodo','trim|required|exact_length[5]');
            $this->form_validation->set_rules('fmt-cbcarrera','Carrera','trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('fmt-cbciclo','Ciclo','trim|required|exact_length[2]');

            $this->form_validation->set_rules('fmt-cbturno','Turno','trim|required|exact_length[1]');
            $this->form_validation->set_rules('fmt-cbseccion','Sección','trim|required|exact_length[1]');

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
                $fcacbperiodo=$this->input->post('fmt-cbperiodo');
                $fcacbcarrera=$this->input->post('fmt-cbcarrera');
                $fcacbturno=$this->input->post('fmt-cbturno');
                $fcacbciclo=$this->input->post('fmt-cbciclo');
                $fcacbseccion=$this->input->post('fmt-cbseccion');
                $fcaplan=$this->input->post('fmt-cbplan');
                $idsede = $_SESSION['userActivo']->idsede;
                $vcursos['cargas']=$this->mnotas_descarga->m_get_carga_por_grupo_extendida_nota(array($fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion,$fcaplan,$idsede));
                $vcursos['divisiones']=$this->mnotas_descarga->m_get_subsecciones_por_grupo_nota(array($fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion,$fcaplan,$idsede));
                
                $cursos = $this->load->view('descarganotas/vw_grupo_result',$vcursos, true);
                $dataex['status'] =TRUE;
                $dataex['vdata'] =$cursos;
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_get_alumnos_notas()
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
            $this->form_validation->set_rules('codcarga','Carga','trim|required');
            $this->form_validation->set_rules('coddivision','division','trim|required');

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
                $codcarga = base64url_decode($this->input->post('codcarga'));
                $coddivision = base64url_decode($this->input->post('coddivision'));
                $idsede = $_SESSION['userActivo']->idsede;

                $valumnos = $this->mnotas_descarga->m_notas_carga_subseccion(array($codcarga,$coddivision,$idsede));
                
                // $cursos = $this->load->view('descarganotas/vw_grupo_result',$vcursos, true);
                $dataex['status'] =TRUE;
                $dataex['vdata'] = $valumnos;
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
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
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            if (getPermitido("128")=='SI')
            {
                $this->form_validation->set_rules('fmt-codmatricula','codigo matricula','trim|required');
                $this->form_validation->set_rules('fmt-cbnperiodo','periodo','trim|required');
                $this->form_validation->set_rules('fmt-cbncarrera','carrera','trim|required');
                $this->form_validation->set_rules('fmt-cbnplan','plan','trim|required');
                $this->form_validation->set_rules('fmt-cbnciclo','ciclo','trim|required');
                $this->form_validation->set_rules('fmt-cbnturno','turno','trim|required');
                $this->form_validation->set_rules('fmt-cbnseccion','sección','trim|required');
                $this->form_validation->set_rules('fmt-cbnunididact','unidad didáctica','trim|required');

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
                    
                    $codmatricula = base64url_decode($this->input->post('fmt-codmatricula'));
                    $codcarga = base64url_decode($this->input->post('fmt-cbncargaacadem'));
                    $codsubseccion = base64url_decode($this->input->post('fmt-cbncargaacadsubsec'));
                    $tipo = "PLATAFORMA";
                    $periodo = base64url_decode($this->input->post('fmt-cbnperiodo'));
                    $carrera = base64url_decode($this->input->post('fmt-cbncarrera'));
                    $plan = base64url_decode($this->input->post('fmt-cbnplan'));
                    $ciclo = base64url_decode($this->input->post('fmt-cbnciclo'));
                    $turno = base64url_decode($this->input->post('fmt-cbnturno'));
                    $seccion = base64url_decode($this->input->post('fmt-cbnseccion'));
                    $fecha = date('Y-m-d H:i:s');
                    $unidad = base64url_decode($this->input->post('fmt-cbnunididact'));
                    $docente = base64url_decode($this->input->post('fmt-cbndocente'));
                    $resolucion = null;
                    $observacion = null;
                    $convalfecha = null;
                    $notafinal = $this->input->post('fmt-cbnnotafinal');
                    $notarecupera = $this->input->post('fmt-cbnnotarecup');
                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    $estado = $this->input->post('fmt-estado');
                    $repitencia = $this->input->post('fmt-repitencia');

                    $matprta = $this->mnotas_descarga->m_getmatriculas_curso_notafinal(array($codmatricula,$periodo,$carrera,$ciclo,$turno,$seccion,$codcarga,$codsubseccion,$unidad));
                    $dataex['matnota'] = $matprta;
                    if (@count($matprta) == 0) {
                        $rpta=$this->mnotas_descarga->m_insert_notas_descarga(array($codmatricula, $tipo, $periodo, $carrera, $plan, $ciclo, $turno, $seccion, $fecha, $codcarga, $codsubseccion, $docente, $unidad, $resolucion, $convalfecha, $notafinal, $notarecupera, $observacion, $usuario, $sede, $estado, $repitencia));

                        $fictxtaccion = "INSERTAR";
                        $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$rpta->newcod;
                    }
                    else {
                        $rpta=$this->mnotas_descarga->m_update_notas_descarga(array($matprta->codigo, $codmatricula, $tipo, $periodo, $carrera, $plan, $ciclo, $turno, $seccion, $fecha, $codcarga, $codsubseccion, $docente, $unidad, $resolucion, $convalfecha, $notafinal, $notarecupera, $observacion, $usuario, $sede, $estado, $repitencia));

                        $fictxtaccion = "EDITAR";
                        $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$rpta->newcod;
                    }
                    $dataex['repsuesta'] = $rpta;
                    if ($rpta->salida == 1){
                        
                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        $dataex['status'] =TRUE;
                        $dataex['msg'] ="datos guardados correctamente";
                        $dataex['idmatricula'] = base64url_encode($codmatricula);
                        
                    }
                }
            } else {
                $dataex['status'] =FALSE;
                $dataex['msg'] ="No tienes autorización para esta acción";
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_insert_update_global()
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
            
            if (getPermitido("128")=='SI')
            {
                $this->form_validation->set_rules('filas', 'datos', 'trim|required');

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
                    $data          = json_decode($_POST['filas']);

                    $tipo = "PLATAFORMA";
                    $fecha = date('Y-m-d H:i:s');
                    $resolucion = null;
                    $observacion = null;
                    $convalfecha = null;
                    
                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;

                    foreach ($data as $value) {
                        $codmatricula = base64url_decode($value[0]);
                        $codcarga = base64url_decode($value[1]);
                        $codsubseccion = base64url_decode($value[2]);
                        $periodo = base64url_decode($value[6]);
                        $carrera = base64url_decode($value[4]);
                        $plan = base64url_decode($value[7]);
                        $ciclo = base64url_decode($value[5]);
                        $turno = base64url_decode($value[9]);
                        $seccion = base64url_decode($value[8]);
                        $unidad = base64url_decode($value[10]);
                        $docente = base64url_decode($value[3]);
                        $notafinal = $value[13];
                        $notarecupera = $value[14];
                        $estado = $value[11];
                        $repitencia = $value[12];

                        $matprta = $this->mnotas_descarga->m_getmatriculas_curso_notafinal(array($codmatricula,$periodo,$carrera,$ciclo,$turno,$seccion,$codcarga,$codsubseccion,$unidad));

                        if (@count($matprta) == 0) {
                            $rpta=$this->mnotas_descarga->m_insert_notas_descarga(array($codmatricula, $tipo, $periodo, $carrera, $plan, $ciclo, $turno, $seccion, $fecha, $codcarga, $codsubseccion, $docente, $unidad, $resolucion, $convalfecha, $notafinal, $notarecupera, $observacion, $usuario, $sede, $estado, $repitencia));

                            $fictxtaccion = "INSERTAR";
                            $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$rpta->newcod;
                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        }
                        else {
                            $rpta=$this->mnotas_descarga->m_update_notas_descarga(array($matprta->codigo, $codmatricula, $tipo, $periodo, $carrera, $plan, $ciclo, $turno, $seccion, $fecha, $codcarga, $codsubseccion, $docente, $unidad, $resolucion, $convalfecha, $notafinal, $notarecupera, $observacion, $usuario, $sede, $estado, $repitencia));

                            $fictxtaccion = "EDITAR";
                            $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$rpta->newcod;
                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        }
                    }
                    
                    $dataex['repsuesta'] = $rpta;
                    if ($rpta->salida == 1){
                        
                        $dataex['status'] =TRUE;
                        $dataex['msg'] ="datos guardados correctamente";
                        $dataex['idmatricula'] = base64url_encode($codmatricula);
                        
                    }
                }
            } else {
                $dataex['status'] =FALSE;
                $dataex['msg'] ="No tienes autorización para esta acción";
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


}

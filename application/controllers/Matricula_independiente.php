<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Matricula_independiente extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mmatricula');
        $this->load->model('mmatricula_independiente');
        $this->load->model('mdocentes');
        $this->load->model('mauditoria');
        $this->load->model('mnotas_descarga');
        
	}

	public function vw_matricula()
    {
		$ahead= array('page_title' =>'Matriculas | IESTWEB'  );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'mn_acad_matriculas','menu_nieto' =>'alumnos');
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
        $a_ins['docentes'] = $this->mdocentes->m_get_docentes();
        
		$this->load->view('matricula/independiente/vw_matriculas',$a_ins);
		$this->load->view('footer');
	}

    public function fn_filtrar_matricula()
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

            $codmatricula = base64url_decode($this->input->post('txtmatricula'));
            $matricula=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
            $dominio=str_replace(".", "_",getDominio());
            $cursos = $this->mmatricula_independiente->m_get_cursos_xmatricula(array($codmatricula));
                foreach ($cursos as $key => $fila) {
                    $fila->codigo64 = base64url_encode($fila->id);
                    $fila->codmiembro64 = base64url_encode($fila->codmiembro);
                    $fila->nota = (is_null($fila->nota ))? "":floatval($fila->nota);
                    $fila->recuperacion = (is_null($fila->recuperacion ))? "":floatval($fila->recuperacion);
                    $funcionhelp="getNotas_alumnoboleta_$dominio";
                    $fila->final = $funcionhelp($fila->metodo,array('promedio' => $fila->nota, 'recupera'=>$fila->recuperacion));
                }
                $dataex['vdata'] =$cursos;
                $dataex['vmatricula'] =$matricula[0];
                $dataex['status'] = true;
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

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

            $sede = $_SESSION['userActivo']->idsede;

            $txtinicio = $this->input->post('txtinicio');
            $txtlimite = $this->input->post('txtlimite');

            $matriculas=$this->mmatricula_independiente->m_filtrar_mat_indiv(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$fmalumno.'%', $sede));

            $cuentas=$this->mmatricula_independiente->m_filtrar_mat_indivxlimit($txtinicio,$txtlimite,array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$fmalumno.'%', $sede));
            $dataex['vdata'] =$cuentas;
            $dataex['items'] = count($matriculas);
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_filtrar_x_pagina()
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

            $fmcbperiodo=$this->input->post('fmt_cbperiodo');
            $fmcbcarrera=$this->input->post('fmt_cbcarrera');
            $fmcbciclo=$this->input->post('fmt_cbciclo');
            $fmcbturno=$this->input->post('fmt_cbturno');
            $fmcbseccion=$this->input->post('fmt_cbseccion');
            $fmcbplan=$this->input->post('fmt_cbplan');
            $fmalumno=$this->input->post('fmt_alumno');

            $sede = $_SESSION['userActivo']->idsede;

            $txtinicio = $this->input->post("inicio");
            $txtlimite = $this->input->post("limite");

            $matriculas=$this->mmatricula_independiente->m_filtrar_mat_indiv(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$fmalumno.'%', $sede));

            $cuentas=$this->mmatricula_independiente->m_filtrar_mat_indivxlimit($txtinicio,$txtlimite,array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,'%'.$fmalumno.'%', $sede));
            
            if (@count($cuentas) > 0) {
                $dataex['status']=true;
                $dataex['items'] = count($matriculas);
                $datos = $cuentas;
                
            } else {
                $datos = "Datos no encontrados";
            }
                                
            
        }
        $dataex['vdata'] = $datos;

        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
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
            
            $this->form_validation->set_rules('fmt-cbncodmatcurso','codigo','trim|required');
            $this->form_validation->set_rules('fmt-cbncodmatricula','codigo matricula','trim|required');
            $this->form_validation->set_rules('fmt-cbtipo','tipo','trim|required');
            $this->form_validation->set_rules('fmt-cbnperiodo','periodo','trim|required');
            $this->form_validation->set_rules('fmt-cbncarrera','carrera','trim|required');
            $this->form_validation->set_rules('fmt-cbnplan','plan','trim|required');
            $this->form_validation->set_rules('fmt-cbnciclo','ciclo','trim|required');
            $this->form_validation->set_rules('fmt-cbnturno','turno','trim|required');
            $this->form_validation->set_rules('fmt-cbnseccion','sección','trim|required');
            $this->form_validation->set_rules('fmt-cbnfecha','fecha','trim|required');
            $this->form_validation->set_rules('fmt-cbnunididact','unidad didáctica','trim|required|is_natural_no_zero');

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
                
                $codmatricurso = $this->input->post('fmt-cbncodmatcurso');
                $codmatricurso64 = base64url_decode($codmatricurso);
                $codmatricula = base64url_decode($this->input->post('fmt-cbncodmatricula'));
                $codcarga = $this->input->post('fmt-cbncargaacadem');
                $codsubseccion = $this->input->post('fmt-cbncargaacadsubsec');
                $tipo = $this->input->post('fmt-cbtipo');
                $periodo = $this->input->post('fmt-cbnperiodo');
                $carrera = $this->input->post('fmt-cbncarrera');
                $plan = $this->input->post('fmt-cbnplan');
                $ciclo = $this->input->post('fmt-cbnciclo');
                $turno = $this->input->post('fmt-cbnturno');
                $seccion = $this->input->post('fmt-cbnseccion');
                $fecha = $this->input->post('fmt-cbnfecha');
                $unidad = $this->input->post('fmt-cbnunididact');
                $docente = $this->input->post('fmt-cbndocente');
                $resolucion = $this->input->post('fmt-cbnresolucion');
                
                $observacion = $this->input->post('fmt-cbnobservacion');

                $convalfecha = null;
                $notafinal = 0;
                $notarecupera = null;
                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;

                if ($this->input->post('fmt-cbnfechaconv')!=null){
                    $convalfecha = $this->input->post('fmt-cbnfechaconv');
                }

                if ($this->input->post('fmt-cbnnotafinal')!=""){
                    $notafinal = $this->input->post('fmt-cbnnotafinal');
                }
                if ($this->input->post('fmt-cbnnotarecup')!=""){
                    $notarecupera = $this->input->post('fmt-cbnnotarecup');
                }

                if ($codmatricurso == '0') {
                    $rpta=$this->mmatricula_independiente->m_insert_mat(array($codmatricula, $tipo, $periodo, $carrera, $plan, $ciclo, $turno, $seccion, $fecha, $codcarga, $codsubseccion, $docente, $unidad, $resolucion, $convalfecha, $notafinal, $notarecupera, $observacion, $usuario, $sede));

                    $fictxtaccion = "INSERTAR";
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$rpta->newcod;
                } else {
                    $rpta=$this->mmatricula_independiente->m_update_mat(array($codmatricurso64, $codmatricula, $tipo, $periodo, $carrera, $plan, $ciclo, $turno, $seccion, $fecha, $codcarga, $codsubseccion, $docente, $unidad, $resolucion, $convalfecha, $notafinal, $notarecupera, $observacion, $usuario, $sede));

                    $fictxtaccion = "EDITAR";
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$rpta->newcod;
                }
                
                if ($rpta->salida == 1){
                    
                    $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="datos guardados correctamente";
                    $dataex['idmatricula'] = base64url_encode($codmatricula);
                    
                }
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_get_matriculacurso_codigo()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo','código','trim|required');
            
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']=validation_errors();
            }
            else
            {
                $dataex['msg'] ='Error de validación superado';
                $codigo = base64url_decode($this->input->post('txtcodigo'));
                
                $sede = $_SESSION['userActivo']->idsede;

                $datosmat=$this->mmatricula_independiente->m_filtrar_matriculacursoxcodigo(array($codigo));
                if (@count($datosmat) > 0) {
                    $dataex['vdata'] = $datosmat;
                    $datosmat->fechaf = date('Y-m-d',strtotime($datosmat->fecha));
                    $datosmat->codigo64 = base64url_encode($datosmat->codigo);
                    $datosmat->codmatric64 = base64url_encode($datosmat->codmatricula);
                    $dataex['status'] =TRUE;
                }
                
                
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_delete_matricula_curso()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('txtcodigo','codigo','trim|required');
            

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
                // $dataex['msg'] ="No se elimino la matrícula, primero compruebe que el alumno no tenga cursos asignados o notas registradas";
                $dataex['status'] =FALSE;
                $idmatcurso=base64url_decode($this->input->post('txtcodigo'));
                $usuario = $_SESSION['userActivo']->idusuario;
                $sede = $_SESSION['userActivo']->idsede;
                    
                $rpta = $this->mmatricula_independiente->m_eliminar_mat(array($idmatcurso));
                if ($rpta->salida == 1){
                    $fictxtaccion = "ELIMINAR";
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$rpta->newcod;
                    $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="registro eliminado correctamente";
                    
                }
            }

        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    /*public function fn_update_notas()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('filas', 'datos', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error al intentar actualizar las notas";
                $data          = json_decode($_POST['filas']);
                //idmat, nota, cmnota
                $nomcampo = "";
                foreach ($data as $value) {
                    if ($value[2] == "NR" && $value[2] == "") {
                        $value[1] = null;
                    }
                    if ($value[2] == "NF" && $value[2] == "") {
                        $value[1] = 0;
                    }
                
                    if ($value[2] == "NF") {
                        // $nomcampo = "mtcf_nota_final";
                        $rpta = $this->mmatricula_independiente->m_editar_nota_final(array(base64url_decode($value[0]),$value[1]));
                    }
                    else {
                        // $nomcampo = "mtcf_nota_recupera";
                        $rpta = $this->mmatricula_independiente->m_editar_nota_recupera(array(base64url_decode($value[0]),$value[1]));
                    }
                }
                
                if ($rpta->salida == "1") {
                    $dataex['idmat'] = base64url_encode($rpta->newcod);
                    $dataex['status'] = true;
                }
                

            }
            
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }*/

    public function fn_update_notas_final_recuperacion()
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
            
            if ((getPermitido("137")=='SI') || (getPermitido("138")=='SI'))
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
                    $dataex['status'] = FALSE;
                    date_default_timezone_set ('America/Lima');
                    $data          = json_decode($_POST['filas']);

                    $tipo = "PLATAFORMA";
                    $fecha = date('Y-m-d H:i:s');
                    $resolucion = null;
                    $observacion = null;
                    $convalfecha = null;
                    
                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;

                    $datos['idorg'][]=array();
                    $datos['idnew'][]=array();
                    $datos['estado'][]=array();
                    $datos['notaf'][]=array();
                    $datos['notarec'][]=array();
                    $todos = true;
                    $dominio=str_replace(".", "_",getDominio());
                    foreach ($data as $value) {
                         //var myvals = [codmat, estado, notfin, notrec, codmiembro];
                        $miembro = base64url_decode($value[1]);
                        $notafinal = $value[2];
                        $notafinal=($notafinal=="") ? NULL : $notafinal;
                        $notarecupera = $value[3];
                        $notarecupera=($notarecupera=="") ? NULL : $notarecupera;
                        $funcionhelp="getNotas_alumnoboleta_$dominio";
                        $final = $funcionhelp($value[5],array('promedio' => $notafinal, 'recupera'=>$notarecupera));
                        


                        $estado = $value[1];
                        
                        if ($estado!="-"){

                        }
                        else{
                            if (is_null($notafinal)){
                               $estado="MTR";
                            }
                            else{
                                if ($final<12.5){
                                    $estado="DES";
                                }
                                else{
                                    $estado="APR";   
                                }
                            }
                            
                        }

                        

                        $datos['idorg']=$value[1];
                        if (intval($value[0]) < 0) {

                            //$rpta=$this->mnotas_descarga->m_insert_notas_descarga(array($codmatricula, $tipo, $periodo, $carrera, $plan, $ciclo, $turno, $seccion, $fechamatricula, $codcarga, $codsubseccion, $docente, $unidad, $resolucion, $convalfecha, $notafinal, $notarecupera, $observacion, $usuario, $sede, $estado, $repitencia, $miembro, $fecha));

                            //$fictxtaccion = "INSERTAR";
                            //$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$rpta->newcod;
                            //$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        }
                        else {
                            $codmatnota = base64url_decode($value[0]);
                            if ($estado=="-"){
                                $rpta=$this->mnotas_descarga->m_update_nota_final_recuperacion_sin_estado(array($codmatnota,$miembro,$notafinal, $notarecupera));
                            }
                            else{
                                $rpta=$this->mnotas_descarga->m_update_nota_final_recuperacion(array($codmatnota,$miembro,$notafinal, $notarecupera,$estado));
                            }


                            $fictxtaccion = "EDITAR";
                            $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$codmatnota ;
                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        }
                        $datos['idnew']=base64url_encode($codmatnota);
                        $datos['notafin'] = $notafinal;
                        $datos['notarec'] = $notarecupera;
                        $datos['estado']=false;
                        if ($rpta->salida == 1){
                            $datos['estado']=true;
                            
                        } else {
                            $todos = false;
                        }
                        $datos_fnal[]=$datos;
                    }

                    /*if ($todos == true) {
                        $rptacg = $this->mnotas_descarga->m_update_fecha_carga(array($fecha, $codcarga, $codsubseccion));
                        if ($rptacg == 1) {
                            $fictxtaccion = "EDITAR";
                            $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", ha migrado las notas del grupo con carga académica COD.".$codcarga.", CODSUBSECCION.".$codsubseccion;
                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        }
                    }*/

                    $dataex['vdata']=$datos_fnal;
                    $dataex['repsuesta'] = $rpta;
                    $dataex['status'] =TRUE;
                }
            } else {
                $dataex['status'] =FALSE;
                $dataex['msg'] ="No tienes autorización para esta acción";
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


    public function pdf_ficha_matricula($codmatricula)
    {

        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        $codmatricula=base64url_decode($codmatricula);

        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();

        $inscs=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
        foreach ($inscs as $insc) {

            $cursos=$this->mmatricula_independiente->m_miscursos_x_matricula(array($codmatricula));
            $dominio=str_replace(".", "_",getDominio());
            $html1=$this->load->view('matricula/independiente/reportes/rp_fichamatricula_'.$dominio, array('ies' => $ie,'mat' => $insc,'curs'=>$cursos ),true);
             
            $pdfFilePath = "FICHA MATRÍCULA ".$insc->carne.".pdf";

            $this->load->library('M_pdf');
            $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
            $mpdf->SetTitle( "FICHA MATRÍCULA ".$insc->carne);
            
            //$mpdf->SetWatermarkImage(base_url().'resources/img/matriculado_'.$dominio.'.png',0.6,"D",array(70,35));

            $mpdf->showWatermarkImage  = true;
            

            //$mpdf->AddPage();
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath, "I");
        }
    }

    public function pdf_boleta_notas($codmatricula)
    {

        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        $codmatricula=base64url_decode($codmatricula);
          
          
        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();
        $dominio=str_replace(".", "_",getDominio());
        $insc=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
        if (!is_null($insc)){
            
            $cursos=$this->mmatricula_independiente->m_miscursos_x_matricula(array($codmatricula));

            foreach ($cursos as $key => $fila) {
                $fila->nota = (is_null($fila->nota ))? "":floatval($fila->nota);
                $fila->recuperacion = (is_null($fila->recuperacion ))? "":floatval($fila->recuperacion);
                $funcionhelp="getNotas_alumnoboleta_$dominio";
                $fila->final = $funcionhelp($fila->metodo,array('promedio' => $fila->nota, 'recupera'=>$fila->recuperacion));
                
            }
            //$this->load->view('matricula/rp_boleta-notas', array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ));
            $insc1=$insc[0];
            
            $html1=$this->load->view('matricula/independiente/reportes/rp_boleta-notas_'.$dominio, array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ),true);
             
            $pdfFilePath = "BN-".$insc1->paterno." ".$insc1->materno." ".$insc1->nombres." - ".$insc1->ciclol.".pdf";

            $this->load->library('M_pdf');
            //p=normal
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [200,200],'orientation' => 'L']); 
            $mpdf->SetTitle( "BN- $insc1->paterno $insc1->materno $insc1->nombres - $insc1->ciclol");
            //$mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.1,array(50,70),array(80,40));
            $mpdf->showWatermarkImage  = true;
            $mpdf->shrink_tables_to_fit = 1;
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath, "I");
        }
    }

    public function pdf_boletas_notas(){
      $matris = stripslashes($_POST['txtmatris']);
      $amatris = explode(",", $matris);
      $dataex['status'] =FALSE;
      //$urlRef=base_url();
      $dataex['msg']    = '¿Que Intentas?.';

      //$codmatricula=base64url_decode($codmatricula);
      //$carne=base64url_decode($carne);
      
      $this->load->model('miestp');
      $ie=$this->miestp->m_get_datos();

      $insc=$this->mmatricula->m_get_matriculas_pdf($amatris);
      if (!is_null($insc)){
          $cursos=$this->mmatricula_independiente->m_miscursos_x_matriculas($amatris);
          //$this->load->view('matricula/rp_boleta-notas', array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ));
          $dominio=str_replace(".", "_",getDominio());
          $html1=$this->load->view('matricula/independiente/reportes/rp_boleta-notas_'.$dominio, array('ies' => $ie,'mats' => $insc,'curs'=>$cursos ),true);
             
          $pdfFilePath = "BOLETA DE NOTAS GRUPO.pdf";
          //echo "$html1";
          $this->load->library('M_pdf');
          //p=normal
          $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [200,200],'orientation' => 'L']); 
          $mpdf->SetTitle( "BOLETA DE NOTAS ");
          $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.1,array(50,70),array(80,40));
          $mpdf->showWatermarkImage  = true;
          $mpdf->WriteHTML($html1);
          $mpdf->Output($pdfFilePath, "D");
      }
     
    }

}

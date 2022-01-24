<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Practicas extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mnotas_descarga');
        $this->load->model('mpracticas');
        $this->load->model('mauditoria');
	}

	public function vw_principal_practicas()
    {
        if (getPermitido("139")=='SI'){
    		$ahead= array('page_title' =>'PRÁCTICAS | IESTWEB'  );
    		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'practicas_acad','menu_nieto' =>'mn_acad_practicas');
    		$this->load->view('head',$ahead);
    		$this->load->view('nav');
    		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
            $this->load->view($vsidebar,$asidebar);
    		
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
    		$this->load->view('practicas/vw_filtro_alumnos',$a_ins);
	        $this->load->view('footer');
        } else {
            $urlref=base_url();
            header("Location: $urlref", FILTER_SANITIZE_URL);
        }
	}

    public function fn_get_filtrar_alumnos()
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
            
            $fmcbplan=$this->input->post('fmt-cbplan');
            $fmalumno=$this->input->post('fmt-alumno');

            $sede = $_SESSION['userActivo']->idsede;

            $cuentas=$this->mpracticas->m_filtrar_alumnos(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,'%'.$fmalumno.'%',$sede));
            for ($i=0; $i < count($cuentas) ; $i++) { 
                $cuentas[$i]->idins_64=base64url_encode($cuentas[$i]->idins);
                $cuentas[$i]->idperiodo_64=base64url_encode($cuentas[$i]->idperiodo);
                $cuentas[$i]->idplan_64=base64url_encode($cuentas[$i]->idplan);
            }
            

            $dataex['vdata'] =$cuentas;
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function vw_detalles_practicas($codinscripcion,$codplan,$codperiodo)
    {
        if (getPermitido("139")=='SI'){
            $ahead= array('page_title' =>'PRÁCTICAS DETALLE | IESTWEB'  );
            $asidebar= array('menu_padre' =>'academico','menu_hijo' =>'practicas_acad','menu_nieto' =>'mn_acad_practicas');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
            $this->load->view($vsidebar,$asidebar);
            $this->load->model('mdocentes');
            $a_ins = $this->mpracticas->m_get_detalle_practicas(array(base64url_decode($codinscripcion),base64url_decode($codperiodo)));
            $a_ins['etapas'] = $this->mpracticas->m_get_etapas(array(base64url_decode($codplan)));
            $a_ins['modalidades'] = $this->mpracticas->m_get_prmodalidades();
            $a_ins['docentes'] =$this->mdocentes->m_get_docentes_administrativos();
            $a_ins['empresas'] = $this->mpracticas->m_get_empresas();

            $this->load->model('mtemporal');
            $a_ins['ciclos']=$this->mtemporal->m_get_ciclos();

            $a_ins['idinscp'] = $codinscripcion;
            $this->load->view('practicas/vw_detalle_practicas',$a_ins);
            $this->load->view('footer');
        } else {
            $urlref=base_url();
            header("Location: $urlref", FILTER_SANITIZE_URL);
        }
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
            if (getPermitido("139")=='SI')
            {
                $this->form_validation->set_rules('fictxtcodetapa','codigo etapa','trim|required');
                $this->form_validation->set_rules('fictxtcodinscrip','periodo','trim|required');
                $this->form_validation->set_rules('fictxtfecinicia','fecha inicia','trim|required');
                $this->form_validation->set_rules('fictxthoras','horas','trim|required');
                $this->form_validation->set_rules('fictxtmodalidadet','modalidad','trim|required');
                $this->form_validation->set_rules('fictxtciclo','Semestre','trim|required');
                
                

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
                    
                    $codigo = $this->input->post('fictxtcodigo');
                    $codetapa = base64url_decode($this->input->post('fictxtcodetapa'));
                    $codins = base64url_decode($this->input->post('fictxtcodinscrip'));
                    $ciclo = $this->input->post('fictxtciclo');
                    $iniciaf = $this->input->post('fictxtfecinicia');
                    $finalizaf = null;
                    $horas = $this->input->post('fictxthoras');
                    $modalidad = $this->input->post('fictxtmodalidadet');
                    $docenteg = $this->input->post('fictxtdocente');
                    $asesorg = $this->input->post('fictxtasesor');
                    $nomproyecto = mb_strtoupper($this->input->post('fictxtproyecto'));
                    $empresa = $this->input->post('fictxtempresa');
                    $estado = "EN PROCESO";
                    
                    if ($this->input->post('fictxtfecfinal')!=null){
                        $finalizaf = $this->input->post('fictxtfecfinal');
                    }

                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;

                    if ($codigo == '0') {
                        $rpta=$this->mpracticas->mInsert_practicas(array($codins, $codetapa, $ciclo, $iniciaf, $finalizaf, $horas, $modalidad, $estado, $docenteg, $asesorg, $nomproyecto, $empresa));

                        $pinscripcion = $this->mpracticas->m_get_practicas_inscripcion(array($codins, $codetapa));

                        if (@count($pinscripcion) == 0) {
                            $rpta2 = $this->mpracticas->mInsert_practicas_inscripcion(array($codins, $codetapa, $estado));
                        }

                        $fictxtaccion = "INSERTAR";
                        $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando un item en la tabla TB_PRACTICAS_ESTUDIANTE COD.".$rpta->newcod;
                    }
                    else {
                        $codigo64 = base64url_decode($codigo);
                        $rpta=$this->mpracticas->mUpdate_practicas(array($codigo64, $codins, $codetapa, $ciclo, $iniciaf, $finalizaf, $horas, $modalidad, $docenteg, $asesorg, $nomproyecto, $empresa));

                        $fictxtaccion = "EDITAR";
                        $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando un item en la tabla TB_PRACTICAS_ESTUDIANTE COD.".$rpta->newcod;
                    }
                    $dataex['repsuesta'] = $rpta;
                    if ($rpta->salida == 1){
                        
                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        $dataex['status'] =TRUE;
                        $dataex['msg'] ="datos guardados correctamente";
                        
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

    public function vwmostrar_practicasxcodigo(){
        $dataex['status']=false;
        $dataex['msg']="No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
            
        $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
        $msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
        $this->form_validation->set_rules('txtcodigo', 'codigo practica', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $dataex['msg'] = validation_errors();
        }
        else{
            $codigo = base64url_decode($this->input->post('txtcodigo'));
            $dataex['status'] =true;
            
            $msgrpta = $this->mpracticas->m_filtrar_practicasxcodigo(array($codigo));
            
        }
        
        $dataex['vdata'] = $msgrpta;

        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fneliminar_practica()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            if (getPermitido("139")=='SI')
            {
                $this->form_validation->set_rules('idpractica', 'codigo practica', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } else {
                    $dataex['msg'] = "Ocurrio un error, no se puede eliminar este item";
                    $idpractica    = base64url_decode($this->input->post('idpractica'));
                    $inscrito    = base64url_decode($this->input->post('txtinsc'));
                    $etapa    = base64url_decode($this->input->post('txtetapa'));
                    
                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    $fictxtaccion = "ELIMINAR";
                    
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un item en la tabla TB_PRACTICAS_ESTUDIANTE COD.".$idpractica;
                    
                    $rpta = $this->mpracticas->m_eliminapractica(array($idpractica));
                    if ($rpta == 1) {
                        $practicas = $this->mpracticas->m_filtrar_practicasall(array($inscrito, $etapa));
                        if (@count($practicas) == 0) {
                            $rpta2 = $this->mpracticas->m_eliminapracticainscripcion(array($inscrito, $etapa));
                        }
                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        $dataex['status'] = true;
                        $dataex['msg']    = 'Item eliminado correctamente';

                    }

                }
            } else {
                $dataex['status'] =FALSE;
                $dataex['msg'] ="No tienes autorización para esta acción";
            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_cambiarestado()
    {
        if (getPermitido("139")=='SI') {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] =FALSE;
            $dataex['msg']    = '¿Que Intentas?.';
            if ($this->input->is_ajax_request())
            {
                $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('ce-idins','Id Inscripción','trim|required');
                
                $this->form_validation->set_rules('ce-nestado','Estado','trim|required');
                $this->form_validation->set_rules('ce-etapa','Etapa','trim|required');

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
                    $dataex['msg'] ="Cambio NO realizado";
                    $dataex['status'] =FALSE;
                    date_default_timezone_set ('America/Lima');
                    $fechacul = null;
                    $usuario = null;

                    $ceidins=base64url_decode($this->input->post('ce-idins'));
                    $cenestado=$this->input->post('ce-nestado');
                    $ceetapa=base64url_decode($this->input->post('ce-etapa'));

                    if ($this->input->post('ce-fechaculmina')!=null){
                        $fechacul = $this->input->post('ce-fechaculmina');
                    }

                    if ($cenestado == "CULMINADO") {
                        // $fechacul = date('Y-m-d');
                        $usuario = $_SESSION['userActivo']->idusuario;
                    }
                        
                    $newcod=$this->mpracticas->m_cambiar_estadop(array($ceidins,$ceetapa,$cenestado, $fechacul, $usuario));
                    if ($newcod->salida==1){
                        $dataex['status'] =TRUE;
                        $dataex['msg'] ="Cambio registrado correctamente";
                        
                    }
                }

            }
        } else {
            $dataex['status'] =FALSE;
            $dataex['msg'] ="No tienes autorización para esta acción";
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_practicas_inscripcionxitem()
    {
        $dataex['status']=false;
        $dataex['msg']="No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
            
        $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
        $msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
        $this->form_validation->set_rules('txtcodigo', 'codigo inscripción', 'trim|required');
        $this->form_validation->set_rules('txtetapa', 'codigo etapa', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $dataex['msg'] = validation_errors();
        }
        else{
            $codigo = base64url_decode($this->input->post('txtcodigo'));
            $etapa = base64url_decode($this->input->post('txtetapa'));
            $dataex['status'] =true;
            
            $msgrpta = $this->mpracticas->m_get_practicas_inscripcion(array($codigo, $etapa));
            
        }
        
        $dataex['vdata'] = $msgrpta;

        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_update_folder_informe()
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
            if (getPermitido("139")=='SI')
            {
                $this->form_validation->set_rules('fictxtcodetapaf','codigo etapa','trim|required');
                $this->form_validation->set_rules('fictxtcodinscripf','codigo inscripcion','trim|required');
                $this->form_validation->set_rules('fictxtfecfolder','fecha','trim|required');
                $this->form_validation->set_rules('fictxtfecinfor','fecha','trim|required');
                $this->form_validation->set_rules('fictxtfeceval','fecha','trim|required');
                $this->form_validation->set_rules('fictxtfecevalnota','Nota','trim|required');

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
                    
                    $codetapa = base64url_decode($this->input->post('fictxtcodetapaf'));
                    $codins = base64url_decode($this->input->post('fictxtcodinscripf'));
                    $fecha = $this->input->post('fictxtfecfolder');
                    $observacion = $this->input->post('fictxtobsfolder');

                    $fechainf = $this->input->post('fictxtfecinfor');
                    $observacioninf = $this->input->post('fictxtobsinform');

                    $fechaeval = $this->input->post('fictxtfeceval');
                    $nota = $this->input->post('fictxtfecevalnota');
                    $observacioneval = $this->input->post('fictxtobseval');

                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;

                    $rpta=$this->mpracticas->sp_tb_practicas_etapa_inscripcion_folder_informe(array($codins, $codetapa, $fecha, $observacion, $fechainf, $observacioninf, $fechaeval, $nota, $observacioneval));

                    $fictxtaccion = "EDITAR";
                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando un item en la tabla TB_PRACTICAS_ETAPAS_INSCRIPCION CODINSC.".$codins.", CODETAPA.".$codetapa;
                    
                    if ($rpta->salida == 1){
                        
                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        $dataex['status'] =TRUE;
                        $dataex['msg'] ="datos actualizados correctamente";
                        
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

    public function fn_update_plan()
    {
        if (getPermitido("139")=='SI') {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] =FALSE;
            $dataex['msg']    = '¿Que Intentas?.';
            if ($this->input->is_ajax_request())
            {
                $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('fictxtcodigoins','Id Inscripción','trim|required');
                $this->form_validation->set_rules('fictxtcodigoper','Id periodo','trim|required');
                $this->form_validation->set_rules('fictxtcicloup','ciclo','trim|required');
                $this->form_validation->set_rules('fictxtplanup','Plan de estudios','trim|required');

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
                    $dataex['msg'] ="Cambio NO realizado";
                    $dataex['status'] =FALSE;

                    $ceidins=base64url_decode($this->input->post('fictxtcodigoins'));
                    $periodo=base64url_decode($this->input->post('fictxtcodigoper'));
                    $ciclo=$this->input->post('fictxtcicloup');
                    $plan=$this->input->post('fictxtplanup');
                        
                    $newcod=$this->mpracticas->m_cambiar_planciclo(array($ceidins,$periodo,$ciclo, $plan));
                    if ($newcod->salida==1){
                        $dataex['status'] =TRUE;
                        $dataex['msg'] ="Cambio registrado correctamente";
                        
                    }
                }

            }
        } else {
            $dataex['status'] =FALSE;
            $dataex['msg'] ="No tienes autorización para esta acción";
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

}

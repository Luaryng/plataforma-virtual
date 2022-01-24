<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Cuestionario_general extends Error_views {
	function __construct() {
		parent::__construct();
		$this->load->model('mcuestionario_general');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Admisión | IESTWEB'  );
		$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'ficha');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->model('mubigeo');
		$ubigeo['departamentos'] =$this->mubigeo->m_departamentos();
		$this->load->view('admision/ficha-personal',$ubigeo);
		$this->load->view('footer');
	}

    public function fn_enviar_encuestas_dd(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_rules('codencu','Respuesta','trim|required');
            $this->form_validation->set_rules('codcg','Respuesta','trim|required');
            $this->form_validation->set_rules('div','Respuesta','trim|required');
            if ($this->form_validation->run() == false) {
                $errors = array();
                //$dataex['msg2'] = validation_errors();
                $dataex['msg'] = "Existe error en los campos";
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            } 
            else {
                $conenc    = base64url_decode($this->input->post('codencu'));
                $codcg    = base64url_decode($this->input->post('codcg'));
                $div    = base64url_decode($this->input->post('div'));
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $rpta = $this->mcuestionario_general->m_send_a_encuestados(array($conenc,$codcg,$div,'PG'));
                if ($rpta=='1'){
                    $dataex['status'] =true;
                }
                else{
                    $dataex['msg'] = 'Ocurrio un error, consulta con el administrador';
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_eliminar_encuestas_dd_enviadas(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_rules('codencu','Respuesta','trim|required');
            $this->form_validation->set_rules('codcg','Respuesta','trim|required');
            $this->form_validation->set_rules('div','Respuesta','trim|required');
            if ($this->form_validation->run() == false) {
                $errors = array();
                //$dataex['msg2'] = validation_errors();
                $dataex['msg'] = "Existe error en los campos";
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
            } 
            else {
                $conenc    = base64url_decode($this->input->post('codencu'));
                $codcg    = base64url_decode($this->input->post('codcg'));
                $div    = base64url_decode($this->input->post('div'));
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $rpta = $this->mcuestionario_general->m_send_a_encuestados(array($conenc,$codcg,$div,'PG'));
                if ($rpta=='1'){
                    $dataex['status'] =true;
                }
                else{
                    $dataex['msg'] = 'Ocurrio un error, consulta con el administrador';
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    
    

    public function vw_encuesta_preguntas($codcuestionario)
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            $codcuestionario=base64url_decode($codcuestionario);
            $vcencuesta=$this->mcuestionario_general->m_get_cuestionario_x_codigo(array($codcuestionario));
            if (isset($vcencuesta->codigo)){
                $ahead= array('page_title' =>'MONITOREO - DOCENTES | ERP'  );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                //$this->load->model('mcuestionario_general');
                $arraymc['tppreguntas'] = $this->mcuestionario_general->m_get_tipo_pregunta();
                $arraymc['vcencuesta']=$vcencuesta;
                $arraymc['preguntas'] = $this->mcuestionario_general->m_get_preguntas_x_cuestionario(array($codcuestionario));
                $rps= $this->mcuestionario_general->m_get_respuestas_x_cuestionario(array($codcuestionario));
                $respuestas=array();
                foreach ($rps as $key => $rp) {
                    $respuestas[$rp->codpregunta][] =$rp;
                }
                $arraymc['respuestas']=$respuestas;
                $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-docentes');
                $this->load->view('sidebar',$asidebar);

                $this->load->view('monitoreo/docente/vw_cuestionario_preguntas', $arraymc);
                $this->load->view('footer');
            }
            else{
                 $this->vwh_noencontrado();
            }
        }
        else{
            $this->vwh_nopermitido("MONITOREO - NO AUTORIZADO");
        }
    }

    public function vw_encuesta_poblacion($codcuestionario)
    {
        if ($_SESSION['userActivo']->tipo != 'AL'){
            $codcuestionario=base64url_decode($codcuestionario);
            $vcencuesta=$this->mcuestionario_general->m_get_cuestionario_x_codigo(array($codcuestionario));
            if (isset($vcencuesta->codigo)){
                $ahead= array('page_title' =>'Admisión | IESTWEB'  );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                //$this->load->model('mcuestionario_general');
                $arraymc= $this->mcuestionario_general->m_get_unidades_didacticas_x_periodo(array($vcencuesta->codperiodo));
                $arraymc['vcencuesta']=$vcencuesta;
                
                /*$arraymc['tppreguntas'] = $this->mcuestionario_general->m_get_tipo_pregunta();
                
                $arraymc['preguntas'] = $this->mcuestionario_general->m_get_preguntas_x_cuestionario(array($codcuestionario));
                $rps= $this->mcuestionario_general->m_get_respuestas_x_cuestionario(array($codcuestionario));
                $respuestas=array();
                foreach ($rps as $key => $rp) {
                    $respuestas[$rp->codpregunta][] =$rp;
                }
                $arraymc['respuestas']=$respuestas;*/
                $asidebar= array('menu_padre' =>'monitoreo','menu_hijo' =>'mon-alumnos');
                $this->load->view('sidebar',$asidebar);

                $this->load->view('monitoreo/docente/vw_cuestionario_poblacion', $arraymc);
                $this->load->view('footer');
            }
            else{
                 $this->vwh_noencontrado();
            }
        }
        else{
            $this->vwh_nopermitido("MONITOREO - NO AUTORIZADO");
        }
    }


	public function fn_insert_update(){
        $dataex['status'] = false;
        $dataex['msg']    = '¿Qué intentas?';
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $dataex['status'] = false;
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('vw_cuge_cbperiodo', 'Periodo', 'trim|required');
                $this->form_validation->set_rules('vw_cuge_nombre', 'Nombre', 'trim|required');
                $this->form_validation->set_rules('vw_cuge_cbobjetivo', 'Objetivo', 'trim|required');
                

                $errors = array();
                $dataex['errors']= array();
                if ($this->form_validation->run() == false) {
                    $dataex['msg2'] = validation_errors();
                    $dataex['msg'] = "Existe error en los campos";
                    
                    foreach ($this->input->post() as $key => $value){
                        $errors[$key] = form_error($key);
                    }
                    $dataex['errors'] = array_filter($errors);
                } 
                else {
                     //@vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion
                    $errors=array();
                    $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                    
					$vdescripcion="";
					$valerta=null;
                    $vnombre          = null;
                    $vtipo          = "C";
                    $vcodigoperiodo=null;
                    $vobjetivo="GN";
                    $vdetalle          = null;
                    
                    $vid          = 0;
                    
                    $vcheckopen="0";
                    $vinicia=null;
                    $vcheckclose="0";
                    $vvence= null;
                    //$checkretraso="0";
                    //$vretraso=  null;
                    $vchecklimite="0";
                    $vmedtiempo=0;
                    $vlimite=0;
                    $vcheckmostrardt="NO";
                    $vcheckopcion1="NO";
                    $vcheckopcion2="NO";
                    $vcheckopcion3="NO";
                    $vcheckopcion4="NO";


                    if ($this->input->post('vw_cuge_nombre')!==null){
                         $vnombre          = $this->input->post('vw_cuge_nombre');
                    }
                    
                    
                    if ($this->input->post('vw_cuge_cbperiodo')!==null){
                         $vcodigoperiodo          = $this->input->post('vw_cuge_cbperiodo');
                    }
                    if ($this->input->post('vtipo')!==null){
                         $vtipo          = $this->input->post('vtipo');
                     }
                    if ($this->input->post('vw_cuge_cbobjetivo')!==null){
                         $vobjetivo          = $this->input->post('vw_cuge_cbobjetivo');
                    }
                    if ($this->input->post('vdescripcion')!==null){
                         $vdescripcion          = $this->input->post('vdescripcion');
                     }
                    

                    if ($this->input->post('textdetalle')!==null){
                         $vdetalle          = $this->input->post('textdetalle');
                     }

                    if ($this->input->post('vid')!==null){
                         $vid          = $this->input->post('vid');
                    }
                    //CAMPO ABRIR
                    if ($this->input->post('checkopen')!==null){
                        $vcheckopen       = $this->input->post('checkopen');
                    }
                    if ($vcheckopen=="SI"){
                        if (($this->input->post('txtopenfecha')!==null) && ($this->input->post('txtopenhora')!==null)){
                         $vinicia         = $this->input->post('txtopenfecha')."  ".$this->input->post('txtopenhora') ;
                        }
                    }
                    //CAMPO VENCE
                    if ($this->input->post('checkclose')!==null){
                        $vcheckclose          = $this->input->post('checkclose');
                    }
                    if ($vcheckclose=="SI"){
                        if (($this->input->post('txtclosefecha')!==null) && ($this->input->post('txtclosehora')!==null)){
                         $vvence          = $this->input->post('txtclosefecha')."  ".$this->input->post('txtclosehora') ;
                        }
                    }
                    //CAMPO RETRASO
                    /*if ($this->input->post('checkretraso')!==null){
                        $checkretraso          = $this->input->post('checkretraso');
                    }
                    if ($checkretraso=="SI"){
                        if (($this->input->post('txtfecharetraso')!==null) && ($this->input->post('txthoraretraso')!==null)){
                            $vretraso          = $this->input->post('txtfecharetraso')."  ".$this->input->post('txthoraretraso') ;
                        }
                    }*/
                    //CAMPO MOSTRAR DETALLE
                    /*if ($this->input->post('checkmostrardt')!==null){
                        $vcheckmostrardt          = $this->input->post('checkmostrardt');
                    }*/
                    //CAMPO LIMITE_TIEMPO
                    if ($this->input->post('checklimite')!==null){
                        $vchecklimite          = $this->input->post('checklimite');
                    }
                    if ($vchecklimite=="SI"){
                        if ($this->input->post('txtlimitnumero')!==null){
                            $vlimite          = $this->input->post('txtlimitnumero');
                        }
                    }
                    if ($this->input->post('vmedtiempo')!==null){
                        $vmedtiempo          = $this->input->post('vmedtiempo');
                    }
                    //CAMPO OPCION 1
                    if ($this->input->post('checkopcion1')!==null){
                        $vcheckopcion1          = $this->input->post('checkopcion1');
                    }
                    //CAMPO OPCION 2
                    if ($this->input->post('checkopcion2')!==null){
                        $vcheckopcion2         = $this->input->post('checkopcion2');
                    }
                    //CAMPO OPCION 3
                    if ($this->input->post('checkopcion3')!==null){
                        $vcheckopcion3          = $this->input->post('checkopcion3');
                    }
                    //CAMPO OPCION 4
                    if ($this->input->post('checkopcion4')!==null){
                        $vcheckopcion4       = $this->input->post('checkopcion4');
                    }
                    if (($this->input->post('valerta')!==null) && ($vcheckopcion1=="SI")){
                         $valerta          = $this->input->post('valerta');
                    }

                    

                    $rpta=array();
                    if ($vid=='-1'){
                        //insert
                        //@vcodigoperiodo, @vcuge_nombre, @vcuge_descripcion, @vcuge_tipo, @vcuge_inicia, @vcuge_vence, @vcuge_tiempo_limite, @vcuge_medida_tiempo, @vcuge_detalle, @vcuge_mostrar_detalle, @vcuge_opcion1, @vcuge_opcion2, @vcuge_opcion3, @vcuge_opcion4, @vcodigousuario, @vcodigosede, @vcuge_horas_alerta,
                        $usuario=$_SESSION['userActivo'];

                        $data=array($vcodigoperiodo,$vnombre,$vdescripcion,$vtipo,$vobjetivo,$vinicia,$vvence,$vlimite,$vmedtiempo,$vdetalle,"SI",$vcheckopcion1,$vcheckopcion2,$vcheckopcion3,$vcheckopcion4,$usuario->codpersona,$usuario->idusuario,$usuario->idsede,$valerta);
                        $rpta = $this->mcuestionario_general->m_insert($data);

                       

                        
                        
                    }
                    else{
                        //@vcodigoperiodo, @vcuge_nombre, @vcuge_descripcion, @vcuge_subtipo, @vcuge_inicia, @vcuge_vence, @vcuge_tiempo_limite, @vcuge_medida_tiempo, @vcuge_detalle, @vcuge_opcion1, @vcuge_opcion2, @vcuge_opcion3, @vcuge_opcion4, @vcuge_horas_alerta, @vcuge_id, @s);
                        //update
                        $data=array($vcodigoperiodo,$vnombre,$vdescripcion,$vobjetivo,$vinicia,$vvence,$vlimite,$vmedtiempo,$vdetalle,$vcheckopcion1,$vcheckopcion2,$vcheckopcion3,$vcheckopcion4,$valerta,$vid);
                        $rpta = $this->mcuestionario_general->m_update($data);
                        
                        
                    }
                    if ($rpta->salida=="1"){
                        $dataex['status'] =true;
                        unset($dataex['msg']);
                        //$dataex['newid'] =$rpta->nid;
                        $dataex['redirect']=base_url()."monitoreo/docentes?tb=e&pd=".$vcodigoperiodo;
                    }
                }
            }
            else{
                $dataex['msg']    = 'No tienes autorización';
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_get_cuestionarios_creador_observador(){
		$dataex['status'] = false;
        $dataex['msg']    = '¿Qué intentas?';
        if ($this->input->is_ajax_request()) {
        	$usuario=$_SESSION['userActivo'];
            if ($usuario->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $this->form_validation->set_rules('vw_encu_cbperiodo', 'Periodo', 'trim|required');

                if ($this->form_validation->run() == false) {
                	$errors=array();
                    $dataex['msg2'] = validation_errors();
                    $dataex['msg'] = "Existe error en los campos";
                    
                    foreach ($this->input->post() as $key => $value){
                        $errors[$key] = form_error($key);
                    }
                    $dataex['errors'] = array_filter($errors);
                } 
                else {
                    $dataex['status'] = true;
                    $vcodperiodo= $this->input->post('vw_encu_cbperiodo');
                    $encu=$this->mcuestionario_general->m_get_cuestionarios_creador_observador(array($usuario->idusuario,$usuario->idsede,$vcodperiodo));

                    date_default_timezone_set('America/Lima');
                    $timelocal=time();
                    for ($i=0; $i < count($encu); $i++) { 

                        $fvence=$encu[$i]->vence;
                        $finicia=$encu[$i]->inicia;
                        $fcreado=$encu[$i]->creado;

                        
                        $fechav = "";
                        $tvencio="NO";
                        if ($fvence!=""){
                            $fechav = date('d-m-Y h:i a',strtotime($fvence));
                            $tvencio=(strtotime($fvence)>$timelocal) ? "NO":"SI";
                        }
                        $fechai = "";
                        $tinicio="SI";
                        if ($finicia!=""){
                            $fechai = date('d-m-Y h:i a',strtotime($finicia));
                            $tinicio=(strtotime($finicia)<$timelocal) ?"SI":"NO";
                        }
                        $fechac = "";
                        if ($fcreado!=""){
                            $fechac = date('d-m-Y h:i a',strtotime($fcreado));
                        }

                        $estado="";
                        $boton="";
                        if ($tinicio=="NO"){
                            $estado='<span class="bg-secondary tboton d-inline-block mr-1"> En espera</span>
                                     <a class="bg-primary tboton d-inline-block"><i class="fas fa-play"></i></a>';
                        } 
                        elseif ($tvencio=="SI") {
                            $estado='<span class="bg-danger tboton d-inline-block mr-1"> Culminó</span>';
                        }
                        else{
                            $estado='<span class="bg-success tboton d-inline-block mr-1"> Encuestando</span>
                                     <a class="bg-warning tboton d-inline-block"><i class="fas fa-pause"></i></a>
                                     <a class="bg-danger tboton d-inline-block"><i class="fas fa-stop"></i></a>';
                            $boton="";
                        }
                        

                        $encu[$i]->estado=$estado;
                        $encu[$i]->boton=$boton;
                        $encu[$i]->vence=$fechav;
                        $encu[$i]->inicia=$fechai;
                        $encu[$i]->creado=$fechac;
                        $encu[$i]->codigo=base64url_encode($encu[$i]->codigo);
                        //var_dump($fechac);
                        //var_dump($encu[$i]);
                    }
                    $dataex['encucreadas']=$encu;
                    unset($dataex['msg']);
                }
            }
            else{
                $dataex['msg']    = 'No tienes autorización';
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}

   /* public function fn_guarda_pegunta()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('pg-enunciado','Enunciado','trim|required');
            $this->form_validation->set_rules('pg-tipo','Tipo','trim|required');
            $this->form_validation->set_rules('pg-codpg','Pregunta','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al Guardar';
               
                $pgpos=$this->input->post('pg-pos');
                $pgenunciado=$this->input->post('pg-enunciado');
                $pgtipo=$this->input->post('pg-tipo');
                $pgdescripcion=$this->input->post('pg-descripcion');
                $pgvalor=$this->input->post('pg-valor');
                $pgcodpg=$this->input->post('pg-codpg');
                $pgobligatoria="NO";
                if ($this->input->post('pg-obligatoria')!==null){
                     $pgobligatoria=$this->input->post('pg-obligatoria');
                }
                $pgvalorada="NO";
                if ($this->input->post('pg-valorada')!==null){
                     $pgvalorada=$this->input->post('pg-valorada');
                }
                $pgvalvacia=$this->input->post('pg-valvacia');
                $pgvalerror=$this->input->post('pg-valerror');
                $pgmaterial=base64url_decode($this->input->post('pg-material'));
                $pgagrupador=$this->input->post('pg-agrupador');
                $respuestas= json_decode($_POST['rptas']);
                
                $filarp="-1";

                if ($pgcodpg=="0"){
                    $filarp=$this->mcuestionario_general->m_insert_pregunta(array( $pgmaterial, $pgagrupador, $pgtipo, $pgpos, $pgenunciado, $pgdescripcion, null, null, $pgvalor, $pgobligatoria, $pgvalvacia, $pgvalerror,$pgvalorada));
                    if ($filarp->salida=='1'){
                        $dataex['status'] =TRUE;
                        $dataex['newid'] =base64url_encode($filarp->nid);
                        $dataex['newrp']=$filarp->rpts;
                    }
                }
                else{
                    $delrpta=array();
                    $delrespuestas= json_decode($_POST['delrptas']);
                    foreach ($delrespuestas as $key => $value) {
                        $delrpta[]=base64url_decode($value);
                    }
                    $pgcodpg=base64url_decode($pgcodpg);
                    $filarp=$this->mcuestionario_general->m_update_pregbunta(array( $pgcodpg,$pgpos, $pgtipo, $pgenunciado, $pgdescripcion, null, null, $pgvalor, $pgobligatoria, $pgvalvacia, $pgvalerror,$pgvalorada));
                    if ($filarp->salida=='1'){
                        $dataex['status'] =TRUE;
                        $dataex['newid'] ="--";
                        $dataex['newrp']=$filarp->rpts;
                    }
                }
                
                
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }*/

    public function fn_clonar_pegunta()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('codclone','Pregunta','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al Guardar';
                //$pgmaterial=base64url_decode($this->input->post('pg-material'));
                $pgcodpg=$this->input->post('codclone');
                //$respuestas= json_decode($_POST['rptas']);
                

                $pgcodpg=base64url_decode($pgcodpg);
                $resrp=$this->mcuestionario_general->m_clone_pregunta(array($pgcodpg));
                if ($resrp->salida=="1"){
                    $dataex['status'] =TRUE;
                    $dataex['newid']=base64url_encode($resrp->nid);
                    unset($dataex['msg']);
                }
               
            //}
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_clonar_encuesta()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('codclone','Encuesta','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al Guardar';
                //$pgmaterial=base64url_decode($this->input->post('pg-material'));
                $pgcodpg=$this->input->post('codclone');
                //$respuestas= json_decode($_POST['rptas']);
                

                $pgcodpg=base64url_decode($pgcodpg);
                $usuario=$_SESSION['userActivo'];
                
                $resrp=$this->mcuestionario_general->m_clone_encuesta(array($pgcodpg,$usuario->codpersona,$usuario->idusuario,$usuario->idsede));
                if ($resrp->salida=="1"){
                    $dataex['status'] =TRUE;
                    //$dataex['newid']=base64url_encode($resrp->nid);
                    unset($dataex['msg']);
                }
               
            //}
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_eliminar_encuesta()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('codclone','Encuesta','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al Guardar';
                //$pgmaterial=base64url_decode($this->input->post('pg-material'));
                $pgcodpg=$this->input->post('codclone');
                $pgcodpg=base64url_decode($pgcodpg);
                $usuario=$_SESSION['userActivo'];
                
                $resrp=$this->mcuestionario_general->m_delete_encuesta(array($pgcodpg,$usuario->codpersona,$usuario->idusuario,$usuario->idsede));
                if ($resrp->salida=="1"){
                    $dataex['status'] =TRUE;
                    //$dataex['newid']=base64url_encode($resrp->nid);
                    unset($dataex['msg']);
                }
               
            //}
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_guardab_pegunta()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('pg-enunciado','Enunciado','trim|required');
            $this->form_validation->set_rules('pg-tipo','Tipo','trim|required');
            $this->form_validation->set_rules('pg-codpg','Pregunta','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al Guardar';
               
                $pgpos=$this->input->post('pg-pos');
                $pgenunciado=$this->input->post('pg-enunciado');
                $pgtipo=$this->input->post('pg-tipo');
                $pgdescripcion=$this->input->post('pg-descripcion');
                $pgvalor=$this->input->post('pg-valor');
                $pgcodpg=$this->input->post('pg-codpg');
                $pgvalorada="NO";
                if ($this->input->post('pg-valorada')!==null){
                     $pgvalorada="SI";//$this->input->post('pg-valorada');
                }
                $pgobligatoria="NO";
                if ($this->input->post('pg-obligatoria')!==null){
                     $pgobligatoria="SI";//$this->input->post('pg-obligatoria');
                }
                $pgvalvacia=$this->input->post('pg-valvacia');
                $pgvalerror=$this->input->post('pg-valerror');
                $pgmaterial=base64url_decode($this->input->post('pg-material'));
                $pgagrupador=$this->input->post('pg-agrupador');
                $respuestas= array();
                
                $filarp="-1";

                if ($pgcodpg=="0"){
                    $filarp=$this->mcuestionario_general->m_insert_pregunta(array( $pgmaterial, $pgagrupador, $pgtipo, $pgpos, $pgenunciado, $pgdescripcion, null, null, $pgvalor, $pgobligatoria, $pgvalvacia, $pgvalerror,$pgvalorada));
                    if ($filarp->salida=='1'){
                        $dataex['status'] =TRUE;
                        $dataex['newid'] =base64url_encode($filarp->nid);
                        //$dataex['newrp']=$filarp->rpts;
                        unset($dataex['msg']);
                    }
                }
                else{
                    $delrpta=array();
                    $pgcodpg=base64url_decode($pgcodpg);
                    $filarp=$this->mcuestionario_general->m_update_pregunta(array( $pgcodpg,$pgpos, $pgtipo, $pgenunciado, $pgdescripcion, null, null, $pgvalor, $pgobligatoria, $pgvalvacia, $pgvalerror,$pgvalorada));
                    if ($filarp->salida=='1'){
                        $dataex['status'] =TRUE;
                        $dataex['newid'] ="--";
                        unset($dataex['msg']);
                    }
                }
                
                
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_guardab_respuesta()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('pg-codpg','Pregunta','trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al Guardar';
                $pgmaterial=base64url_decode($this->input->post('pg-material'));
                $pgcodpg=$this->input->post('pg-codpg');
                $respuestas= json_decode($_POST['rptas']);
                

                $pgcodpg=base64url_decode($pgcodpg);
                $resrp=$this->mcuestionario_general->m_save_respuesta(array($pgmaterial,$pgcodpg),$respuestas);
                if ($resrp->salida=="1"){
                    $dataex['status'] =TRUE;
                    $dataex['newrp']=base64url_encode($resrp->nid);
                    unset($dataex['msg']);
                }
               
            //}
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }
    
    public function fn_delete_respuesta(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_rules('codrpta','Respuesta','trim|required');
            
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
            $codrpta    = base64url_decode($this->input->post('codrpta'));
            if ("0" !==$codrpta ){
                //$link    = $this->input->post('link');
                $data=array($codrpta);
                $rpta = $this->mcuestionario_general->m_delete_respuesta($data);
                /*PARA ELIMINAR LA IMAGEN
                $pathtodir =  getcwd() ; 
                unlink($pathtodir."/upload/".$link );*/
                if ($rpta>0){
                    $dataex['msg'] = "Eliminado";
                }
                else{
                    $dataex['msg'] = "$rpta";
                }
                $dataex['status'] =true;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_delete_respuestas_x_pregunta(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_rules('pg-codpg','Pregunta','trim|required');
            
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
            $codrpta    = base64url_decode($this->input->post('pg-codpg'));
            if ("0" !==$codrpta ){
                //$link    = $this->input->post('link');
                $data=array($codrpta);
                $rpta = $this->mcuestionario_general->m_delete_respuestas_x_pregunta($data);
                /*PARA ELIMINAR LA IMAGEN
                $pathtodir =  getcwd() ; 
                unlink($pathtodir."/upload/".$link );*/
                if ($rpta>0){
                    $dataex['msg'] = "Eliminado";
                }
                else{
                    $dataex['msg'] = "$rpta";
                }
                $dataex['status'] =true;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_delete_pregunta(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_rules('codrpta','Respuesta','trim|required');
            
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
            $codrpta    = base64url_decode($this->input->post('codpgta'));
            if ("0" !==$codrpta ){
                //$link    = $this->input->post('link');
                $data=array($codrpta);
                $rpta = $this->mcuestionario_general->m_delete_pregunta($data);
                /*PARA ELIMINAR LA IMAGEN
                $pathtodir =  getcwd() ; 
                unlink($pathtodir."/upload/".$link );*/
                if ($rpta>0){
                    $dataex['msg'] = "Eliminado";
                }
                else{
                    $dataex['msg'] = "$rpta";
                }
                $dataex['status'] =true;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }



    public function f_ordenar()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['status'] = false;
            /*$urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {*/
                $dataex['msg'] = "Ocurrio un error al intentar generar la nueva fecha</a>";
                $data          = json_decode($_POST['filas']);
                $dataUpdate    = array();
                foreach ($data as $value) {
                    if ($value[1] != '0') {
                        $dataUpdate[] = array($value[0],base64url_decode($value[1]));
                    }
                }
                $rpta = $this->mcuestionario_general->m_ordenar($dataUpdate);
                if ($rpta>0)  $dataex['status'] = true;
                 $dataex['nm'] = $rpta;

            //}
            //$dataex['destino'] = $urlRef;
            header('Content-Type: application/x-json; charset=utf-8');
            echo (json_encode($dataex));
        }
    }


    public function fn_guarda_cuestionario_encuestado()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('ex-codentrega','Examen','trim|required');
            

            if ($this->form_validation->run() == FALSE)
            {
                $dataex['msg']="Existen errores en los campos";
                $errors = array();
                foreach ($this->input->post() as $key => $value){
                    $errors[$key] = form_error($key);
                }
                $dataex['errors'] = array_filter($errors);
                $dataex['msgv']=validation_errors();
            }
            else
            {
                $dataex['msg']    = 'Error al Guardar';

                $excodcuge=base64url_decode($this->input->post('ex-codcuge'));
                $excodentrega=base64url_decode($this->input->post('ex-codentrega'));
                date_default_timezone_set('America/Lima');
                $exfecentrega=date("Y-m-d H:i:s");
                $rptaajax= json_decode($_POST['rptas']);

                $preguntas = $this->mcuestionario_general->m_get_preguntas_x_cuestionario(array($excodcuge));
                $respuestas= $this->mcuestionario_general->m_get_respuestas_x_cuestionario(array($excodcuge));
                $pgconrp=array();
                
                foreach ($preguntas as $key => $pg ){
                    $pgconrp[$pg->codpregunta]['codtipo'] =$pg->codtipo;
                    $pgconrp[$pg->codpregunta]['valor'] =$pg->valor;
                    $pgconrp[$pg->codpregunta]['vacio'] =$pg->vacio;
                    $pgconrp[$pg->codpregunta]['valorv'] =$pg->valorv;
                    $pgconrp[$pg->codpregunta]['valore'] =$pg->valore;
                   
                } 
                foreach ($respuestas as $key => $rp) {
                    $pgconrp[$rp->codpregunta]['rpta'][$rp->codrpta]=$rp;
                    unset($respuestas[$key]);
                }
                $rpajax=array();
                $exnota=0;
                $excompletado="SI";
                $rpenviar=array();
                //$arraypgcheck=array();
                $errorspg=array();
                $pgrespondidas=array();
                foreach ($rptaajax as $key => $rj) {
                    $codpg=base64url_decode($rj[0]);
                    $pgrespondidas[$codpg]=true;
                    
                    if (isset($pgconrp[$codpg])){
                        $rj[2]=trim($rj[2]);
                        $pregunta=$pgconrp[$codpg];
                        //TEXTO
                        if ($pregunta['codtipo']=="7"){
                            if (($pregunta['vacio']=="SI") && ($rj[2]=="")){
                                $errorspg[$rj[0]]="* Respuesta obligatoria";
                            }
                            else{
                                $valinter=$pregunta['valor'];
                                if ($pregunta['valor']>0){
                                    $excompletado="NO";
                                    $valinter=null;
                                }
                                $rpenviar[]=array($codpg,null,$rj[2],$valinter);
                                unset($pgconrp[$codpg]);
                            }
                        }
                        //CHECK
                        elseif ($pregunta['codtipo']=="4"){
                            $idrp=base64url_decode($rj[1]);
                            //$arraypgcheck[$codpg]['rpta'][$idrp]=$rj;
                            $rpenviar[]=array($codpg,$idrp,$rj[2],$pregunta['rpta'][$idrp]->valor);
                        }
                        //RADIO
                        else{
                            $idrp=base64url_decode($rj[1]);
                            if (isset($pregunta['rpta'][$idrp])){
                                $rpenviar[]=array($codpg,$idrp,$rj[2],$pregunta['rpta'][$idrp]->valor);
                                $exnota=$exnota + $pregunta['valor'];
                                unset($pgconrp[$codpg]);
                            }
                            else{
                                $rpenviar[]= array($codpg,$idrp,$rj[2],$pregunta['rpta'][$idrp]->valor);
                                $exnota=$exnota + $pregunta['valore'];
                                unset($pgconrp[$codpg]);
                            }
                        }
                    }
                    else{
                        var_dump("expression");
                    }
                }

                foreach ($pgconrp as $keyprp => $rp) {
                    if (!isset($pgrespondidas[$keyprp])){
                        if ($rp['vacio']=="SI"){
                            $errorspg[base64url_encode($keyprp)]="* Respuesta obligatoria";
                        }
                    }
                }

                
                    //CALL `sp_tb_cuestionario_general_encuestado_entregar`( @vcgen_id, @veditar, @vnota, @vcompleto, @`s`);
                    $filarp=$this->mcuestionario_general->m_guardar_cuestionario_encuestado(array($excodentrega,'NO', null ,'SI',$exfecentrega),$rpenviar);
                    if ($filarp->salida=='1'){
                        $dataex['status'] =TRUE;
                        $urlref=base_url()."alumno/encuestas";
                        $dataex['redirect']=$urlref;
                        //header("Location: $urlref", FILTER_SANITIZE_URL);
                    }
                
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

}
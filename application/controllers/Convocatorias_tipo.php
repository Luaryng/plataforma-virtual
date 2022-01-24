<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';

class Convocatorias_tipo extends Error_views{

	function __construct(){
		parent::__construct();
		$this->load->helper("url");
        $this->load->model('mconvocatorias_tipo');
        $this->load->model('mauditoria');
		
	}

	public function vw_principal()
    {
        if (getPermitido("81")=='SI'){
            $tipo=$this->input->get('tp');
            $ahead= array('page_title' =>'Tipo Convocatorias | ERP'  );
            $asidebar= array('menu_padre' =>'convocatorias', 'menu_hijo' =>'tipos');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar_portal',$asidebar);
            $items = $this->mconvocatorias_tipo->m_get_items_convt();
            $this->load->view('convocatoriatipo/index', array('items' => $items ));
            $this->load->view('footer');
        }
        else{
             $this->vwh_nopermitido("NO AUTORIZADO - ERP");
        }
    }

    public function vw_agregar()
    {
        if (getPermitido("82")=='SI'){
            $ahead= array('page_title' =>'Tipo Convocatorias - Agregar | ERP'  );
            $asidebar= array('menu_padre' =>'convocatorias', 'menu_hijo' =>'tipos');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar_portal',$asidebar);
            $this->load->view('convocatoriatipo/vw_tipos_add');
            $this->load->view('footer');
        }
        else{
             $this->vwh_nopermitido("NO AUTORIZADO - ERP");
        }
    }

    public function vw_editar($id)
    {
        
        if (getPermitido("83")=='SI'){
            $id=base64url_decode($id);
            $ahead= array('page_title' =>'Convocatorias - Editar | ERP'  );
            $asidebar= array('menu_padre' =>'convocatorias', 'menu_hijo' =>'tipos');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar_portal',$asidebar);
            $fila['tipo'] = $this->mconvocatorias_tipo->m_get_items_cont_id(array($id));
            $this->load->view('convocatoriatipo/vw_tipos_add', $fila);
            $this->load->view('footer');
        }
        else{
             $this->vwh_nopermitido("NO AUTORIZADO - ERP");
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

                $this->form_validation->set_rules('vw_pw_bt_ad_fictxttitulo', 'Nombre', 'trim|required');

                $errors = array();
                $dataex['errors']= array();
                if ($this->form_validation->run() == false) {
                    
                    $dataex['msg'] = "Existe error en los campos";
                    
                    foreach ($this->input->post() as $key => $value){
                        $errors[$key] = form_error($key);
                    }
                    $dataex['errors'] = array_filter($errors);
                } 
                else {
                    
                    $errors=array();
                    $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                    $ccodigo = $this->input->post('vw_pw_bt_ad_fictxtcodigo');
                    $ctitulo = $this->input->post('vw_pw_bt_ad_fictxttitulo');
                    $checkstatus = "NO";
                    $vid = 0;

                    if ($this->input->post('checkestado')!==null){

	                    $checkstatus = $this->input->post('checkestado');

	                }

	                if ($checkstatus=="on"){

	                	$checkstatus = "SI";

	                }

                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    
                    $rpta=0;
                    
                    if ($ccodigo=="0"){

                        $rpta = $this->mconvocatorias_tipo->m_insert_convt(array($ctitulo, $checkstatus));
                        $accion = "INSERTAR";
                        // $dataex['msg2'] = $rpta;
                        $vid = $rpta->nid;
                        $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando un tipo de convocatoria en la tabla TB_CONVOCATORIAS_TIPO COD.".$rpta->nid;
                    }
                    else{
                        $vid = base64url_decode($ccodigo);
                        $rpta = $this->mconvocatorias_tipo->m_update_convt(array($vid,$ctitulo, $checkstatus));
                        $accion = "EDITAR";
                        // $dataex['msg2'] = $rpta;
                        
                        $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un tipo de convocatoria en la tabla TB_CONVOCATORIAS_TIPO COD.".$vid;
                    }

                    if ($rpta->salida==1){
                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));

                        $dataex['status'] =TRUE;
                        $dataex['msg'] ="Datos registrados correctamente";
                        $dataex['redirect'] =base_url()."portal-web/convocatorias-tipo";
                            
                    }

                    $dataex['errors'] = $errors;
                }
            }
            else{
                $dataex['msg']    = 'No tienes autorización';
            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_delete(){
        $dataex['status'] = false;
        $dataex['msg']    = '¿Qué intentas?';
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                $this->form_validation->set_message('required', '%s Requerido');
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('codigo', 'Codigo', 'trim|required');
                
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } else {
                    $dataex['msg'] = "No se pudieron guardar los cambios, contacte con el administrador";
                    $codindicador    = base64url_decode($this->input->post('codigo'));
                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;
                    $accion = "ELIMINAR";
                    
                    $rpta=0;
                    $data=array($codindicador);

                    $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una convocatoria en la tabla TB_CONVOCATORIAS COD.".$codindicador;

                    //ELIMINAR TIPO CONVOCATORIA
                    $rpdeleteconvocatoria = $this->mconvocatorias_tipo->m_delete_convt($data);
                    if ($rpdeleteconvocatoria > 0){
                        $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                        $dataex['status'] =true;
                    }
     

                }
            }
            else{
                $dataex['msg']    = 'No estas autorizado';
            }
        }
        $dataex['destino'] = $urlRef;
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }



}
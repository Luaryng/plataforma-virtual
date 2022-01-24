<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deudas_grupo extends CI_Controller {
	function __construct() {
		parent::__construct();
		
	}

	public function vw_principal(){
		if (getPermitido("55")=='SI'){
			$this->ci=& get_instance();
			$ahead= array('page_title' =>'Deudas Individuales- '.$this->ci->config->item('erp_title')  );
			$asidebar= array('menu_padre' =>'mn_deudas','menu_hijo' =>'mh_dd_grupo');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_facturacion',$asidebar);
			$this->load->model('mperiodo');

		    //$this->load->model('mbeneficio');   
		    //$a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();

		    $this->load->model('mcarrera');
		    $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);

		    $a_ins['periodos']=$this->mperiodo->m_get_periodos();
		    $this->load->model('mtemporal');
		    $a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
		    
		    $a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
		    //$this->load->model('mcarrera');
		    $a_ins['secciones']=$this->mtemporal->m_get_secciones();
		    $this->load->model('mdeudas_calendario');

		    /*$npac=0;
		    foreach ($a_ins['periodos'] as $pd) {
		    	if ($pd->estado=="ACTIVO"){
		    		$npac++;
		    		$pac=$pd->codigo;
		    	}
		    }
		    if ($npac==1){
				$a_ins['calendarios']=$this->mdeudas_calendario->m_get_calendarios_xperiodo(array($pac));
		    }*/
		    

		    

			$this->load->view('deudas/grupos/vw_principal', $a_ins);
			$this->load->view('footer');
		}
		else{
			//$this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}



	//$a_ins['calendarios']=$this->mdeudas_calendario->m_get_calendarios_xperiodo(array($pac));

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
            $this->form_validation->set_rules('fm-cbperiodo','periodo','trim|required');
            $this->form_validation->set_rules('fm-cbcarrera','carrera','trim|required');
            $this->form_validation->set_rules('fm-cbciclo','ciclo','trim|required');
            $this->form_validation->set_rules('fm-cbturno','turno','trim|required');
            $this->form_validation->set_rules('fm-cbseccion','seccion','trim|required');
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
                $fmcbperiodo=$this->input->post('fm-cbperiodo');
                $fmcbcarrera=$this->input->post('fm-cbcarrera');
                $fmcbciclo=$this->input->post('fm-cbciclo');
                $fmcbturno=$this->input->post('fm-cbturno');
                $fmcbseccion=$this->input->post('fm-cbseccion');
                
                $cuentas=$this->mgrupos->m_filtrar(array($_SESSION['userActivo']->idsede,$fmcbperiodo,$fmcbcarrera,'%',$fmcbciclo,$fmcbturno,$fmcbseccion));
                $a_ins['calendarios']=$this->mdeudas_calendario->m_get_calendarios_xperiodo(array($fmcbperiodo));
                $dataex['vdata'] =$cuentas;
                $dataex['status'] = true;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

}
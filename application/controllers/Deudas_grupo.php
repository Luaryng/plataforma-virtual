<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deudas_grupo extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mdeudas_calendario_grupo');
		$this->load->model('mperiodo');
		$this->load->model('mcarrera');
		$this->load->model('mtemporal');
		$this->load->model('mmatricula');
		
	}

	public function vw_principal(){
		if (getPermitido("108")=='SI'){
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

	public function vw_modal_grupos()
	{
		$this->form_validation->set_message('required', '%s Requerido');

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_dcmd_grupo','Periodo','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
		        $dataex['msg']=validation_errors();
			}
			else
			{
				$vw_dcmd_grupo64=$this->input->post('vw_dcmd_grupo');
				$vw_dcmd_grupo=base64url_decode($vw_dcmd_grupo64);
				$periodos = $this->mperiodo->m_get_periodos();
				$carreras=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
				$ciclos=$this->mtemporal->m_get_ciclos();
				$turnos=$this->mtemporal->m_get_turnos_activos();
				$secciones=$this->mtemporal->m_get_secciones();
				$grupos=$this->mdeudas_calendario_grupo->m_get_grupos_xcalendario(array($vw_dcmd_grupo));
				
				foreach ($grupos as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->codigo);
				}
				$arraydts=array('idcalendario'=> $vw_dcmd_grupo64,'periodos'=> $periodos,'grupos'=> $grupos,'carreras'=> $carreras,'ciclos'=> $ciclos,'turnos'=> $turnos,'secciones'=> $secciones);
				
				
				$vista=$this->load->view('deudas/vw_grupos_calendario', $arraydts ,true);

				//$filas=$this->mdeudas_calendario->m_get_calendarios_xperiodo(array($vw_dcmd_grupo));
				
				$dataex['vdata']=$vista;
				$dataex['status'] =TRUE;
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_grupos()
	{
		$this->form_validation->set_message('required', '%s Requerido');

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_dcmd_grupo','Periodo','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
		        $dataex['msg']=validation_errors();
			}
			else
			{
				$vw_dcmd_grupo64=$this->input->post('vw_dcmd_grupo');
				$vw_dcmd_grupo=base64url_decode($vw_dcmd_grupo64);
				$vw_dcmd_calendario_fecha=base64url_decode($this->input->post('vw_dcmd_calfecha'));
				/*$periodos = $this->mperiodo->m_get_periodos();
				$carreras=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
				$ciclos=$this->mtemporal->m_get_ciclos();
				$turnos=$this->mtemporal->m_get_turnos_activos();
				$secciones=$this->mtemporal->m_get_secciones();*/
				$grupos=$this->mdeudas_calendario_grupo->m_get_grupos_xcalendario(array($vw_dcmd_calendario_fecha));
				
				foreach ($grupos as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->codigo);
				}
				
				$dataex['vdata']=$grupos;
				$dataex['status'] =TRUE;
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_guardar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		/*$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');*/

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$this->form_validation->set_rules('vw_dg_idcalend','Código','trim|required');
			$this->form_validation->set_rules('vw_dg_cbperiodo','Nombre periodo','trim|required');
			$this->form_validation->set_rules('vw_dg_cbcarrera','Nombre Programa','trim|required');
			$this->form_validation->set_rules('vw_dg_cbciclo','Ciclo','trim|required');
			$this->form_validation->set_rules('vw_dg_cbturno','Turno','trim|required');
			$this->form_validation->set_rules('vw_dg_cbseccion','Seccion','trim|required');

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
				$vw_dc_codigo=base64url_decode($this->input->post('vw_dg_idcalend'));
				$vw_dc_periodo=$this->input->post('vw_dg_cbperiodo');
				$vw_dc_carrera=$this->input->post('vw_dg_cbcarrera');
				$vw_dc_ciclo=$this->input->post('vw_dg_cbciclo');
				$vw_dc_turno=$this->input->post('vw_dg_cbturno');
				$vw_dc_seccion=$this->input->post('vw_dg_cbseccion');
				
				$rpta=$this->mdeudas_calendario_grupo->m_guardar(array($vw_dc_periodo, $vw_dc_carrera, $vw_dc_ciclo, $vw_dc_turno, $vw_dc_seccion, $vw_dc_codigo));
					
				if ($rpta->salida=="1"){
					$filas=$this->mdeudas_calendario_grupo->m_get_grupos_xcalendario(array($vw_dc_codigo));
					$dataex['status'] =TRUE;
					$dataex['vdata']=$filas;
					$dataex['msg'] ="Calendario registrado correctamente";
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
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
                $this->load->model('mgrupos');
                
                $cuentas=$this->mgrupos->m_filtrar(array($_SESSION['userActivo']->idsede,$fmcbperiodo,$fmcbcarrera,'%',$fmcbciclo,$fmcbturno,$fmcbseccion));
                //$a_ins['calendarios']=$this->mdeudas_calendario->m_get_calendarios_xperiodo(array($fmcbperiodo));
                $dataex['vdata'] =$cuentas;
                $dataex['status'] = true;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_matriculados_x_grupo()
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

            	$vw_dc_periodo=$this->input->post('txtcodperiodo');
				$vw_dc_carrera=$this->input->post('txtcodcarrera');
				$vw_dc_ciclo=$this->input->post('txtcodciclo');
				$vw_dc_turno=$this->input->post('txtcodturno');
				$vw_dc_seccion=$this->input->post('txtcodseccion');
				$txtcalfecha=base64url_decode($this->input->post('txtcalfecha'));
				
                $pensiones=array('02.01','02.02','02.03','02.04','02.05');
                $pensiones_contado="02.06";

                $databuscar=array("codperiodo"=>$vw_dc_periodo, "codcarrera"=>$vw_dc_carrera, "codturno"=>$vw_dc_turno, "codciclo"=>$vw_dc_ciclo, "codseccion"=>$vw_dc_seccion,"codgestion"=>$pensiones_contado);

                $matriculados=$this->mmatricula->m_filtrar_xgrupo(array($vw_dc_periodo,$vw_dc_carrera,$vw_dc_ciclo,$vw_dc_turno,$vw_dc_seccion));

                $this->load->model('mfacturacion');
                $pagos_x_matriculas=$this->mfacturacion->m_pagos_detalle_x_grupo_matricula($databuscar);

                $deudas_generadas=$this->mdeudas_calendario_grupo->m_deuda_xgrupo_calendario(array($vw_dc_periodo,$vw_dc_carrera,$vw_dc_ciclo,$vw_dc_turno,$vw_dc_seccion,$txtcalfecha));

                $this->load->model('mdeudas_calendario_fecha_item');
                $itemsCobro= $this->mdeudas_calendario_fecha_item->m_get_items_cobro_x_fecha(array($txtcalfecha));
                
                $coddeuda_negativo=0;
                foreach ($matriculados as $key => $matricula) {
                	$matricula->codigo64=base64url_encode($matricula->codigo);
                	$matricula->contado="";
                	$matricula->items=array();
                	$items=array();
                	$monto=1;
                	foreach ($pagos_x_matriculas as $keypago => $pago) {
						if ($matricula->codigo==$pago->codmatricula){
							$matricula->contado="PC";
							unset($pagos_x_matriculas[$keypago]);
						}
					}
                	foreach ($itemsCobro as $keyitem => $item) {
                		$deuda= new stdClass();
                		$coddeuda_negativo--;

		                $deuda->codigo=$coddeuda_negativo;
		                $deuda->codgestion="00.00";
		                $deuda->saldo=0;
                		$monto=$item->monto;
                		$items[$item->codigo]=array();
                		$es_pension=false;
                		$deuda->codgestion=$item->codgestion;
                		foreach ($pensiones as $keypen => $pen) {
                			if ($item->codgestion==$pen){
                				$es_pension=true;
                			}
                		}
                		if ($es_pension==true){
							$monto=$matricula->cuota;
							if ($matricula->contado=="PC"){
								$monto=0;
							}
                		}
                		$items[$item->codigo]['monto']=round($monto,2);
                		$deuda->saldo=round($monto,2);
                		foreach ($deudas_generadas as $keydeuda_generada => $deuda_generada) {
                			//codfecha_item
                			if (($deuda_generada->codmatricula==$matricula->codigo) &&  ($deuda_generada->codfecha_item==$item
                				->codigo)){
                				$deuda->codigo=$deuda_generada->coddeuda;
		                		$deuda->codgestion=$deuda_generada->codgestion;
		                		$deuda->saldo=$deuda_generada->saldo;
		                		$items[$item->codigo]['monto']=$deuda_generada->monto;
		                		unset($deudas_generadas[$keydeuda_generada]);
                			}
                		}
                		
                		
                		
                		$items[$item->codigo]['deuda']=$deuda;
                	}
                	$matricula->items=$items;
                }
                
                


                $dataex['vdata'] =$matriculados;
                $dataex['items'] =$itemsCobro;
                $dataex['status'] = true;
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_insert_update_deuda_grupo()
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
			
			$this->form_validation->set_rules('vw_cmdi_txtcalfecha64','Calendario','trim|required');
			


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
				$txtcalfecha = base64url_decode($this->input->post('vw_cmdi_txtcalfecha64'));
				$deudas          = json_decode($_POST['filas']);
                $deudasUpdate    = array();
                $deudasInsert    = array();

                $this->load->model('mdeudas_calendario_fecha_item');
                $itemsCobro= $this->mdeudas_calendario_fecha_item->m_get_items_cobro_x_fecha(array($txtcalfecha));
                $this->load->model('mdeudas_individual');
                //$rpta2=$this->mdeudas_individual->m_guardar_deuda(array($pagante, $matricula, $gestion, $monto, $fcreacion, $fvence, $vouchercod, $mora, $fprorroga, $repite, $observacion, $saldo));
                //[coddeuda, carnet, codmat, codgestion,monto,saldo];
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$idnuevos=array();
                foreach ($deudas as $deuda) {
                	$pagante = $deuda[1];
					$matricula = base64url_decode($deuda[2]);

					$gestion = $deuda[3];
					$monto =$deuda[4];
					$fcreacion = date("Y-m-d H:i:s");     
					$repite = "NO";
					$fvence=null;
					foreach ($itemsCobro as $key => $itemc) {
						if ($itemc->codigo==$deuda[6]){
							$repite = $itemc->codigo;
							$fvence = $itemc->vence;
						}
					}
					$mora = 0;
					
					$saldo =$deuda[5];
					$fechaitem=$deuda[6];
					$observacion = "";
					$fprorroga = null;
                
                    if ($deuda[0] < 0) {
                    	if ($monto>0){
	                        $rp_save_deuda=$this->mdeudas_individual->m_guardar_deuda(array($pagante, $matricula, $gestion, $monto, $fcreacion, $fvence, $txtcalfecha, $mora, $fprorroga, $repite, $observacion, $saldo,$fechaitem));
	                        $fictxtaccion = "INSERTAR";
	                        if ($rp_save_deuda->salida =='1'){
	                        	$dataex['status'] =TRUE;
	                        	$idnuevos[$deuda[0]]=base64url_encode($rp_save_deuda->newcod);
								$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", generó una deuda en la tabla TB_DEUDA_INDIVIDUAL COD.".$rp_save_deuda->newcod;
								$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));

							}
						}
						else{
							$dataex['status'] =TRUE;
						}
                    }
                    else {
                    	$dataex['status'] =TRUE;
                        
                    }
                }

				
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	//$a_ins['calendarios']=$this->mdeudas_calendario->m_get_calendarios_xperiodo(array($pac));
}
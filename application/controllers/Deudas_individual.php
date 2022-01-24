<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deudas_individual extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mdeudas_individual');
		$this->load->model('mtemporal');
		$this->load->model('mcarrera');
		$this->load->model('mperiodo');
		$this->load->model('mgestion');
	}

	public function vw_principal(){
		if (getPermitido("107")=='SI'){
			$this->ci=& get_instance();
			$ahead= array('page_title' =>'Deudas Individuales- '.$this->ci->config->item('erp_title')  );
			$asidebar= array('menu_padre' =>'mn_deudas','menu_hijo' =>'mh_dd_individual');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_facturacion',$asidebar);

			$arraydts['turnos'] = $this->mtemporal->m_get_turnos_activos();
			$arraydts['carrera'] = $this->mcarrera->m_lts_carreras_activas();
			$arraydts['ciclo'] = $this->mtemporal->m_get_ciclos();
			
			$arraydts['secciones']=$this->mtemporal->m_get_secciones();
			$arraydts['gestion'] =$this->mgestion->m_get_gestionxestado();

			//////////////////////
			$arraydts['periodos'] = $this->mperiodo->m_get_periodos();
			$this->load->model('msede');
			$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
			$this->load->model('mbeneficio');
			$arraydts['beneficios'] = $this->mbeneficio->m_get_beneficios();
			/////////////////////////
			//$arraydts = $arraydts + $this->mperiodo->m_periodos();

			//$this->load->view('deudas/individual/vw_principal', $arraydts);
			$this->load->view('deudas/vw_principal', $arraydts);
			$this->load->view('footer');
		}
		else{
			//$this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function fn_filtrar_deudas()
	{
		/*$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');*/
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rspreinsc = "";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$busqueda = $this->input->post('txtapenombres');
			$carrera = $this->input->post('cboprograma');
			$periodo = $this->input->post('cboperiodo');

			$turno = $this->input->post('cboturno');
			$ciclo = $this->input->post('cbociclo');
			$seccion = $this->input->post('cboseccion');

			
			$databuscar=array($periodo, $carrera, $turno, $ciclo, $seccion, '%'.$busqueda.'%' );
		
			$dtdeudas = $this->mdeudas_individual->m_get_historial_pagante( $databuscar );
			date_default_timezone_set ('America/Lima');
			$hoy = date('Y-m-d');
			foreach ($dtdeudas as $key => $fila) {
				//$fila->codigose=$fila->codigo;
				$fila->codigo64=base64url_encode($fila->codigo);
				if ($hoy <= $fila->fvence) {
					$fila->vencida="NO";
				}
				else {
					$fila->vencida="SI";
				}

			}

			$dataex['vdatahst'] = $dtdeudas;
			$dataex['status'] = TRUE;
			
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	

	/*public function fn_filtrar_pagantes()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('cboperiodof','Periodo','trim|required|min_length[4]');
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
				$busqueda=$this->input->post('fitxtdniapenomb');

				$carrera = $this->input->post('cboprogramaf');
				$periodo = $this->input->post('cboperiodof');

				$turno = $this->input->post('cboturnof');
				$ciclo = $this->input->post('cbociclof');
				$seccion = $this->input->post('cboseccionf');

				$databuscar=array($periodo, $carrera, $turno, $ciclo, $seccion, '%'.$busqueda.'%' );
				
				$cuentas=$this->mdeudas_individual->m_get_filtrar_pagante($databuscar);
				
				$dataex['vdata']=$cuentas;
				$dataex['status'] =TRUE;
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}*/



	public function fn_insert_deuda_individual()
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
			
			$this->form_validation->set_rules('ficcodpagante','Código pagante','trim|required');
			$this->form_validation->set_rules('ficcodmatricula','Código matricula','trim|required');
			$this->form_validation->set_rules('ficbgestion','Gestion','trim|required');
			$this->form_validation->set_rules('ficmonto','Monto','trim|required');
			

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
				
				$pagante = $this->input->post('ficcodpagante');
				$matricula = $this->input->post('ficcodmatricula');
				$gestion = $this->input->post('ficbgestion');
				$monto = $this->input->post('ficmonto');
				$fcreacion = $this->input->post('ficfechcreacion');
				$vouchercod = $this->input->post('ficvouchcodigo');
				$mora = $this->input->post('ficmora');
				$repite = $this->input->post('ficrepitecic');
				$saldo = $this->input->post('ficsaldo');
				$observacion = $this->input->post('ficobservacion');

				$fvence = null;
				$fprorroga = null;

				if ($this->input->post('ficfechvence')!=null){
                    $fvence = $this->input->post('ficfechvence');
                }

				if ($this->input->post('ficfechprorrog')!=null) {
					$fprorroga = $this->input->post('ficfechprorrog');
				}

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "INSERTAR";


					$rpta2=$this->mdeudas_individual->m_guardar_deuda(array($pagante, $matricula, $gestion, $monto, $fcreacion, $fvence, $vouchercod, $mora, $fprorroga, $repite, $observacion, $saldo));

					if ($rpta2->salida == '1'){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está insertando una deuda en la tabla TB_DEUDA_INDIVIDUAL COD.".$rpta2->newcod;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos guardados correctamente";
						
					}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	

	public function fn_cambiarestado_deuda()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('ce-iddeuda','Id Deuda','trim|required');
            
            $this->form_validation->set_rules('ce-nestado','Estado','trim|required');

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
                $coddeuda = base64url_decode($this->input->post('ce-iddeuda'));
                $cenestado = base64url_decode($this->input->post('ce-nestado'));
                    
                $newcod=$this->mdeudas_individual->m_cambiar_estado_deuda(array($coddeuda,$cenestado));
                if ($newcod==1){
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_anula_deuda_individual()
    {
    	 $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('ficdeudacodigo','Id Deuda','trim|required');
            $this->form_validation->set_rules('ficdeudaestado','Estado','trim|required');
            
            $this->form_validation->set_rules('ficmotivanula','Motivo','trim|required');

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
                $coddeuda64 = $this->input->post('ficdeudacodigo');
                $coddeuda = base64url_decode($coddeuda64);
                $cenestado = base64url_decode($this->input->post('ficdeudaestado'));
                
                $motivo = $this->input->post('ficmotivanula');
                    
                $newcod=$this->mdeudas_individual->m_anula_deuda_individual(array($coddeuda,$motivo,$cenestado));
                if ($newcod==1){
                    $dataex['status'] =TRUE;
                    $dataex['iddeuda'] = $coddeuda64;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_vincular_deuda_con_pago()
    {
    	 $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('coddetalle','Detalle','trim|required');
            $this->form_validation->set_rules('coddeuda','Deuda','trim|required');
            

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
                $coddetalle = base64url_decode($this->input->post('coddetalle'));
                $coddeuda = base64url_decode($this->input->post('coddeuda'));      
                $newcod=$this->mdeudas_individual->m_cambiar_deuda_a_pago(array($coddeuda,$coddetalle));
                if ($newcod==1){
                    $dataex['status'] =TRUE;
                    $dataex['coddeuda'] = $coddeuda ;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_desvincular_deuda_con_pago()
    {
    	 $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('coddetalle','Detalle','trim|required');
            $this->form_validation->set_rules('coddeuda','Deuda','trim|required');
            

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
                $coddetalle = base64url_decode($this->input->post('coddetalle'));
                $coddeuda = base64url_decode($this->input->post('coddeuda'));      
                $newcod=$this->mdeudas_individual->m_desvincular_deuda_a_pago(array($coddeuda,$coddetalle));
                if ($newcod==1){
                    $dataex['status'] =TRUE;
                    $dataex['coddeuda'] = $coddeuda ;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_eliminar()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('id-deuda','Id Deuda','trim|required');

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
                $dataex['msg'] ="No se eliminó la deuda, consulte con Soporte err0 err-1";
                $dataex['status'] =FALSE;
                $codigo = base64url_decode($this->input->post('id-deuda'));
                                
                $newcod=$this->mdeudas_individual->m_eliminar_deuda(array($codigo));
                $dataex['newcod'] =$newcod;
                if ($newcod=='1'){
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="Deuda, eliminada";
                }
                elseif ($newcod=='2'){
                    $dataex['msg'] ="Se ha encontrado pagos relacionados, primero debe desvincular deuda con pagos ";
                }
                

            }

        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


   	public function fn_get_deuda_x_codpagante()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_fcb_txtcodpagante','N° Carné','trim|required');
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
				$mismatriculas=array();
				$vw_fcb_txtcodpagante=$this->input->post('vw_fcb_txtcodpagante');

				$deudas=$this->mdeudas_individual->m_get_deuda_activa_xpagante(array($vw_fcb_txtcodpagante));
				$this->load->model('minscrito');
				$this->load->model('malumno');
				$inscrito = $this->minscrito->m_get_inscrito_por_carne(array($vw_fcb_txtcodpagante));
				if (@count($inscrito) > 0) {
					$mismatriculas = $this->malumno->m_matriculasxcarne(array($inscrito->idinscripcion));
				}
				
				$dataex['rscountdeuda']=count($deudas);
				foreach ($deudas as $key => $dd) {
					$dd->monto=$dd->monto;
					$dd->mora=$dd->mora;
					$dd->saldo=$dd->saldo;
					$dd->saldo=$dd->saldo;
				}
				$dataex['vdeudas']=$deudas;
				$dataex['rscountmatricula']=count($mismatriculas);
				$dataex['vmatriculas']=$mismatriculas;
				$dataex['rscount']=1;
				$dataex['status'] =TRUE;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}


}


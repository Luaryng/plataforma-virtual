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
			$this->load->model('mmatricula');
			$arraydts['estados'] = $this->mmatricula->m_filtrar_estadoalumno();
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
			$sede = $this->input->post('cbosede');
			$turno = $this->input->post('cboturno');
			$ciclo = $this->input->post('cbociclo');
			$seccion = $this->input->post('cboseccion');
			$estado = $this->input->post('cboestado');
			$beneficio = $this->input->post('cbobeneficio');
			$busqueda=str_replace(" ", "%", $busqueda);
			
			$databuscar=array("codsede"=>$sede, "codperiodo"=>$periodo, "codcarrera"=>$carrera, "codturno"=>$turno, "codciclo"=>$ciclo, "codseccion"=>$seccion, "carnet"=>'%',"codbeneficio"=>$beneficio, "codestado"=>$estado, "buscar"=>'%'.$busqueda.'%');
		
			$dtdeudas = $this->mdeudas_individual->m_get_historial_pagante( $databuscar );
			date_default_timezone_set ('America/Lima');
			$hoy = date('Y-m-d');
			foreach ($dtdeudas as $key => $fila) {
				//$fila->codigose=$fila->codigo;
				$fila->codigo64=base64url_encode($fila->codigo);
				$fevence = new DateTime($fila->fvence);
				$fila->fecvence = $fevence->format('d/m/Y');
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

	

	public function fn_filtrar_pagantes()
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
	}

	public function fn_get_deuda_codigo()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin Asignar</option>";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_fcb_txtcodigo','Codigo','trim|required');
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
				$vw_fcb_txtcodigo = base64url_decode($this->input->post('vw_fcb_txtcodigo'));

				$deuda = $this->mdeudas_individual->m_deuda_codigo(array($vw_fcb_txtcodigo));
				$deuda->coddeuda64 = base64url_encode($deuda->codigo);
				$deuda->codmat64 = base64url_encode($deuda->matricula);
				$this->load->model('minscrito');
				$this->load->model('malumno');
				$inscrito = $this->minscrito->m_get_inscrito_por_carne(array($deuda->pagante));
				if (@count($inscrito) > 0) {
					$mismatriculas = $this->malumno->m_matriculasxcarne(array($inscrito->idinscripcion));
					if (count($mismatriculas) > 0) $rsoptions="<option value=''>Sin Asignar</option>";
					foreach ($mismatriculas as $mat) {
						$codmat64 = base64url_encode($mat->codigo);
						$rsoptions=$rsoptions."<option value='$codmat64'>$mat->periodo - $mat->ciclo</option>";
					}
				}
				
				$dataex['rscountmatricula']=count($mismatriculas);
				$dataex['vmatriculas']=$rsoptions;
				$dataex['vdata'] = $deuda;
				$dataex['status'] =TRUE;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

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
				
				$coddeuda = $this->input->post('ficcod_deuda');
				$pagante = $this->input->post('ficcodpagante');
				$nompagante = $this->input->post('ficapenomde');
				$matricula = base64url_decode($this->input->post('ficcodmatricula'));
				$gestion = $this->input->post('ficbgestion');
				$monto = $this->input->post('ficmonto');
				$fcreacion = $this->input->post('ficfechcreacion');
				$vouchercod = $this->input->post('ficvouchcodigo');
				$fechaitem = $this->input->post('ficcodigofecitem');
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
				$textusuario = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres;
				$sede = $_SESSION['userActivo']->idsede;

				if ($coddeuda == "0") {
					$fictxtaccion = "INSERTAR";
					$rpta2=$this->mdeudas_individual->m_guardar_deuda(array($pagante, $matricula, $gestion, $monto, $fcreacion, $fvence, $vouchercod, $mora, $fprorroga, $repite, $observacion, $saldo, $fechaitem));

					$contenido = $textusuario.", está insertando una deuda en la tabla TB_DEUDA_INDIVIDUAL COD.".$rpta2->newcod." PAGANTE: ".$nompagante;
				}
				else
				{
					$fictxtaccion = "EDITAR";
					$rpta2=$this->mdeudas_individual->m_actualizar_deuda(array(base64url_decode($coddeuda), $pagante, $matricula, $gestion, $monto, $fcreacion, $fvence, $vouchercod, $mora, $fprorroga, $repite, $observacion, $saldo, $fechaitem));

					$contenido = $textusuario.", está actualizando una deuda en la tabla TB_DEUDA_INDIVIDUAL COD.".$rpta2->newcod." PAGANTE: ".$nompagante;
				}
				
				if ($rpta2->salida == '1'){
					
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					$dataex['status'] =TRUE;
					$dataex['estado'] = $fictxtaccion;
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

	public function fn_get_matriculas_pagante()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin Asignar</option>";
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
				$vw_fcb_txtcodpagante=$this->input->post('vw_fcb_txtcodpagante');

				$this->load->model('minscrito');
				$this->load->model('malumno');
				$inscrito = $this->minscrito->m_get_inscrito_por_carne(array($vw_fcb_txtcodpagante));
				if (@count($inscrito) > 0) {
					$mismatriculas = $this->malumno->m_matriculasxcarne(array($inscrito->idinscripcion));
					if (count($mismatriculas) > 0) $rsoptions="<option value=''>Sin Asignar</option>";
					foreach ($mismatriculas as $mat) {
						$codmat64 = base64url_encode($mat->codigo);
						$rsoptions=$rsoptions."<option value='$codmat64'>$mat->periodo - $mat->ciclo</option>";
					}
				}
				
				$dataex['rscountmatricula']=count($mismatriculas);
				$dataex['vmatriculas']=$rsoptions;
				$dataex['status'] =TRUE;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}




}


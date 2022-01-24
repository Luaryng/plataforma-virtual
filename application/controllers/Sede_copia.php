<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sede extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('msede');
		$this->load->model('mdocentes');
		$this->load->model('mubigeo');
		$this->load->model('mauditoria');
		$this->load->model('mcarrera');
	}

	public function fn_sede_por_usuario()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$dataex['vdata']  =array();
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcoduser','Búsqueda','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda=base64url_decode($this->input->post('txtcoduser'));

				$sedes=$this->msede->m_get_sedes_por_usuario(array($busqueda));
				$dataex['vdata'] =$sedes;
				$dataex['status'] =TRUE;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vw_principal()
	{
		$ahead= array('page_title' =>'SEDES | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'sede');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$arraydts['departamentos'] = $this->mubigeo->m_departamentos();
		$arraydts['docentes'] = $this->mdocentes->m_get_docentes_administrativos();
		$arraydts['sedes'] = $this->msede->m_get_sedes_all();
		//$arraydts['activos'] = $this->msede->m_get_sedes_activos();
		$arraydts['carreras'] = $this->mcarrera->m_lts_carreras_activas();
		$this->load->view('sedes/sedes_list', $arraydts);
		$this->load->view('footer');
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
			
			$this->form_validation->set_rules('fictxtnombre','nombre sede','trim|required');
			$this->form_validation->set_rules('fictxtcodper','titular','trim|required');
			$this->form_validation->set_rules('ficbdepartamento','departamento','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('vw_ins_cbprovincia','provincia','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('vw_ins_cbdistrito','distrito','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fictxtdireccion','Dirección','trim|required');

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
				
				$codigo = $this->input->post('fictxtcodigo');
				$nombre = mb_strtoupper($this->input->post('fictxtnombre'));
				$titular = $this->input->post('fictxtcodper');
				$distrito = $this->input->post('vw_ins_cbdistrito');
				$local = mb_strtoupper($this->input->post('fictxtlocal'));
				$fictxtaccion = $this->input->post('fictxtaccion');

				$fictxtdireccion = mb_strtoupper($this->input->post('fictxtdireccion'));
				$checkstatus = "NO";
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				if ($this->input->post('checkestado')!==null){

                     $checkstatus = $this->input->post('checkestado');

                }

                if ($checkstatus=="on"){

                	$checkstatus = "SI";

                }

				if ($fictxtaccion == "INSERTAR") {
					$rpta=$this->msede->mInsert_sede(array($nombre, $distrito, $checkstatus, $titular, $local, $fictxtdireccion));
					if ($rpta > 0){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una sede en la tabla TB_SEDE COD.".$rpta;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Sede registrado correctamente";
						
					}
				} else if ($fictxtaccion == "EDITAR") {
					$rpta=$this->msede->mUpdate_sede(array($codigo, $nombre, $distrito, $checkstatus, $titular, $local, $fictxtdireccion));
					if ($rpta == 1){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una sede en la tabla TB_SEDE COD.".$codigo;
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Sede actualizado correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function vwmostrar_sedexcodigo()
	{
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo area', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$msgrpta = $this->msede->m_get_sedesxcodigo(array($codigo));

			//BUSCAR UBIGEO
			$rsprov="<option value='0'>Sin opciones</option>";
			$provincias=$this->mubigeo->m_provincias(array($msgrpta->codep));
			if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
			foreach ($provincias as $provincia) {
				$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
			}

			$rsdistri="<option value='0'>Sin opciones</option>";
			$distritos=$this->mubigeo->m_distritos(array($msgrpta->codprov));
			if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
			foreach ($distritos as $distrito) {
				$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
			}

			$dataex['dprovincias'] = $rsprov;
			$dataex['ddistritos'] = $rsdistri;
			
		}
		
		$dataex['sedeup'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fneliminar_sede()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('idsede', 'codigo sede', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este sede";
                $idsede    = base64url_decode($this->input->post('idsede'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una sede en la tabla TB_SEDE COD.".$idsede;
				
                $rpta = $this->msede->m_eliminasede(array($idsede));
                if ($rpta == 1) {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Sede eliminada correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_insert_carrera_sede()
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
			
			$this->form_validation->set_rules('fictxtnomsed','sede','trim|required');
			$this->form_validation->set_rules('fictxtnomcarr','carrera','trim|required');
			$this->form_validation->set_rules('fictxtcostins','costo inscripción','trim|required');
			$this->form_validation->set_rules('fictxtcostmat','costo matricula','trim|required');
			$this->form_validation->set_rules('fictxtcostotal','costo total','trim|required');
			$this->form_validation->set_rules('fictxtcostcont','costo contado','trim|required');
			$this->form_validation->set_rules('fictxtnrocuotas','nro cuotas','trim|required');

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
				// $codigo = $this->input->post('fictxtcodigo');
				$codsede = $this->input->post('fictxtnomsed');
				$carrera = $this->input->post('fictxtnomcarr');
				$inscripción = $this->input->post('fictxtcostins');
				$matricula = $this->input->post('fictxtcostmat');
				$total = $this->input->post('fictxtcostotal');
				$contado = $this->input->post('fictxtcostcont');
				$cuotas = $this->input->post('fictxtnrocuotas');

				$fictxtaccion = $this->input->post('fictxtaccion');
				$checkabierta = "NO";
				$checkstatus = "NO";
				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				if ($this->input->post('checkabierta')!==null){

                     $checkabierta = $this->input->post('checkabierta');

                }

                if ($checkabierta=="on"){

                	$checkabierta = "SI";

                }

				if ($this->input->post('checkestado')!==null){

                     $checkstatus = $this->input->post('checkestado');

                }

                if ($checkstatus=="on"){

                	$checkstatus = "SI";

                }

				if ($fictxtaccion == "INSERTAR") {

					$rpta = $this->mcarrera->mInsert_carrera_sede(array($codsede, $carrera, $inscripción, $matricula, $total, $contado, $cuotas, $checkabierta, $checkstatus));
					$dataex['msg'] =$rpta;
					if ($rpta == 1){
						$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una sede a carrera en la tabla TB_CARRERA_SEDE";
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Se registro correctamente";
						
					}
				} 
				// else if ($fictxtaccion == "EDITAR") {
				// 	$rpta=$this->msede->mUpdate_sede(array($codigo, $nombre, $distrito, $checkstatus, $titular, $local));
				// 	if ($rpta == 1){
				// 		$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando una sede en la tabla TB_SEDE COD.".$codigo;
				// 		$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
				// 		$dataex['status'] =TRUE;
				// 		$dataex['msg'] ="Sede actualizado correctamente";
						
				// 	}
				// }
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function search_sede()
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

			$nomsede = $this->input->post('nomsede');
			$sedeslst = $this->msede->m_get_sedesxnombre('%'.$nomsede.'%');
			if ($sedeslst > 0) {
				foreach ($sedeslst as $key => $fila) {
					$fila->codigo64=base64url_encode($fila->id);
				}
                $dataex['status'] = true;
                $dataex['datos'] = $sedeslst;
            }
								
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }

    public function fn_update_nfacturacion()
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
			
			$this->form_validation->set_rules('fictxtcodigosed','codigo sede','trim|required');
			$this->form_validation->set_rules('ficbrutanube','ruta','trim|required');
			$this->form_validation->set_rules('ficbtokennube','token','trim|required');

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
				
				$codigo = $this->input->post('fictxtcodigosed');
				$ficbrutanube = $this->input->post('ficbrutanube');
				$ficbtokennube = $this->input->post('ficbtokennube');
				
				$fictxtaccion = 'EDITAR';

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				$rpta=$this->msede->mupdate_confactsede(array($codigo, $ficbrutanube, $ficbtokennube));
				if ($rpta > 0){
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando la configuración de facturacion sede en la tabla TB_SEDE COD.".$rpta;
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Datos actualizados correctamente";
					
				}
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
    }


}
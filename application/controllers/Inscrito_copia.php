<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscrito extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('minscrito');
		$this->load->model('mdiscapacidad');
		$this->load->model('mpublicidad');
		$this->load->model('mauditoria');
	}
	
	public function inscripciones($dnipostula=""){
		
		$ahead= array('page_title' =>'Inscripciones | IESTWEB'  );
		$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'inscripcion');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
    	$this->load->view($vsidebar,$asidebar);

		if (getPermitido("45")=='SI'){
			$this->load->model('mmodalidad');
			$a_ins['modalidades']=$this->mmodalidad->m_get_modalidades();
			$this->load->model('mperiodo');
			$a_ins['periodos']=$this->mperiodo->m_get_periodos();
			$this->load->model('mcarrera');
			$a_ins['carreras']=$this->mcarrera->m_get_carreras_abiertas_por_sede($_SESSION['userActivo']->idsede);
			$this->load->model('mtemporal');
			$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
			//$this->load->model('mcarrera');
			$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
			//$this->load->model('mcarrera');
			$a_ins['secciones']=$this->mtemporal->m_get_secciones();
			$a_ins['dnipostula']=$dnipostula;
			$a_ins['docs_anexar']=$this->mtemporal->m_get_docs_por_anexar();

			$a_ins['discapacidades']=$this->mdiscapacidad->m_filtrar_discapacidadxestado();
			$a_ins['publicidad'] = $this->mpublicidad->m_get_publicidades();

			$this->load->view('admision/inscripciones',$a_ins);
		}
		else{

			$this->load->view('errors/sin-permisos');
		}
		
		
		$this->load->view('footer');
	}

	public function fn_getdocanexados(){
	
		$this->form_validation->set_message('required', '%s Requerido');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$fila= array('idinscripcion' => '0');
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('ce-idins','Carné','trim|required|min_length[4]');
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
				$busqueda=base64url_decode($this->input->post('ce-idins'));
				$rsfila=$this->minscrito->m_get_docsanexados(array($busqueda));
				$dataex['status'] =TRUE;
				$dataex['vdata'] =$rsfila;
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insertdocs(){
	
		$this->form_validation->set_message('required', '%s Requerido');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$fila= array('idinscripcion' => '0');
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('ce-idins','Carné','trim|required|min_length[4]');
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
				$busqueda=base64url_decode($this->input->post('ce-idins'));
				$data          = json_decode($_POST['filas']);

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "EDITAR";
				$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando documentos anexados en la tabla TB_INSCRIPCION_DOCANEXADOS COD INSCRIPCION.".$busqueda;
                
				$rsfila=$this->minscrito->m_insertdocs(array($busqueda,$data));
				$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
				$dataex['status'] =TRUE;
				$dataex['vdata'] =$rsfila;
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_get_datos_carne()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$fila= array('idinscripcion' => '0');
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fgi-txtcarne','Carné','trim|required|min_length[4]');
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
				$planes="<option value='0'>Plan curricular NO DISPONIBLE</option>";
				$busqueda=$this->input->post('fgi-txtcarne');
				$rsfila=$this->minscrito->m_get_inscrito_por_carne(array($busqueda));
				$dataex['status'] =TRUE;
				if (!is_null($rsfila)){
					$rsfila->idinscripcion=base64url_encode($rsfila->idinscripcion);
					$fila=$rsfila;
					if ($fila->estado=="ACTIVO"){
						$this->load->model('mplancurricular');
						$rsplanes=$this->mplancurricular->m_get_planes_activos_carrera(array($fila->codcarrera));
						if (count($rsplanes)>0) $planes="<option value='0'>Selecciona el Plan curricular</option>";
						foreach ($rsplanes as $plan) {
							
	                        $planes=$planes."<option value='$plan->codigo'>$plan->nombre</option>";
	                  
						}
						$dataex['vplanes'] =$planes;
					}
					else{
						$dataex['msg']="La inscripción de $fila->paterno $fila->materno $fila->nombres NO se encuentra ACTIVA, estado actual: $fila->estado";
						$dataex['status'] =FALSE;
					}
					
				}
			}
		}
		$dataex['vdata'] =$fila;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_get_datos_matriculantes()
	{
		$this->form_validation->set_message('required', '%s Requerida');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		//$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rsfila= array();
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('alumno','Búsqueda','trim|required|min_length[4]');
			$this->form_validation->set_rules('periodo','Periodo','trim|required|min_length[4]');
			$this->form_validation->set_rules('carrera','Carrera','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$dataex['msgc'] = validation_errors();
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{	
				//$planes="<option value='0'>Plan curricular NO DISPONIBLE</option>";
				$busqueda=$this->input->post('alumno');
				$periodo=$this->input->post('periodo');
				$carrera=$this->input->post('carrera');
				
				$rsfila=$this->minscrito->m_get_datos_matriculantes(array($periodo,$carrera,"%".$busqueda."%"));
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rsfila;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}


	public function fn_insert()
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

			$this->form_validation->set_rules('fimcid','Identifcador','trim|required');
			//$this->form_validation->set_rules('fiinscripcion','Inscripción','trim|required');
		//$this->form_validation->set_rules('fitxtcarnet','Carnet','trim|required|is_unique[tb_inscripcion.ins_carnet]');
			$this->form_validation->set_rules('ficbcarrera','Carrera','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbmodalidad','Modalidad','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbperiodo','Periodo','trim|required|exact_length[5]');
			$this->form_validation->set_rules('ficbcampania','Campaña','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbciclo','Ciclo','trim|required|exact_length[2]');
			$this->form_validation->set_rules('fitxtfecinscripcion','Fec. Nac.','trim|required');

			$discapacidad = $this->input->post('cbodispacacidad');

			if ($discapacidad == "SI") {
				$this->form_validation->set_rules('ficbdiscapacidad','Discapacidad','trim|required|is_natural_no_zero');
			}

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
				$fimcid=base64url_decode($this->input->post('fimcid'));
				//$fiinscripcion=$this->input->post('fiinscripcion');
				$ficbcarrera=$this->input->post('ficbcarrera');
				$ficbmodalidad=$this->input->post('ficbmodalidad');
				$ficbperiodo=$this->input->post('ficbperiodo');
				$ficbcampania=$this->input->post('ficbcampania');
				$ficbciclo=$this->input->post('ficbciclo');
				$ficbturno=$this->input->post('ficbturno');
				$ficbseccion=$this->input->post('ficbseccion');
				$fitxtobservaciones=strtoupper($this->input->post('fitxtobservaciones'));
				$fitxtfecinscripcion=$this->input->post('fitxtfecinscripcion');

				$ficbcarsigla=$this->input->post('ficbcarsigla');
				$fitxtdni=$this->input->post('fitxtdni');
				$fitxtcarnet=$fitxtdni.$ficbcarsigla;

				$fictxttraslado=$this->input->post('fictxtinstproceden');

				$detadiscapacidad = $this->input->post('txtdetadiscapac');

				$fmtapepaterno = $this->input->post('fimcpaterno');
				$fmtapematerno = $this->input->post('fimcmaterno');
				$fmtnombres = $this->input->post('fimcnombres');
				$fmtsexo = $this->input->post('fimcsexo');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "INSERTAR";

				//if ($fiinscripcion=="0"){
					//INSERTAR NUEVA INSCRIPCIÓN
					$newcod=$this->minscrito->m_insert_inscripcion(array($fimcid,$fitxtcarnet,$ficbcarrera,$ficbmodalidad,$ficbperiodo,$ficbcampania,$ficbciclo,$fitxtobservaciones,$fitxtfecinscripcion,$sede,$fitxtcarnet.'@'.getDominio(),$usuario,$fictxttraslado,$discapacidad,$detadiscapacidad,$ficbturno,$ficbseccion));
					
				//}
				//else{
					//EDITAR INSCRIPCIÓN
				//}

				if ($newcod->salida == 1){
					//PROYECTAR MATRICULA
					/*$this->load->model('mplancurricular');
					$plan_defecto=$this->mplancurricular->m_get_plan_x_defecto_inscipcion_carrera(array($ficbcarrera));;
					$cbplan=(isset($plan_defecto->codigo)) ? $plan_defecto->codigo : "0";
					$this->load->model('mmatricula');
					$rsrow=$this->mmatricula->m_insert(array($newcod->nid,"O","1",$ficbperiodo,$ficbcarrera,$ficbciclo,$ficbturno,$ficbseccion,0,5,$fitxtfecinscripcion,"",$cbplan,$fmtapepaterno,$fmtapematerno,$fmtnombres,$fmtsexo));*/
					if (isset($_POST['doc-anexados'])) {
						$data          = json_decode($_POST['doc-anexados']);
						$rsfila=$this->minscrito->m_insertdocs(array($newcod->nid,$data));
					}

					if (isset($_POST['ficbdiscapacidad']) && ($_POST['ficbdiscapacidad'] != "0")) {
						$cbodiscapacidad = $this->input->post('ficbdiscapacidad');
						$principal = "SI";
						$dsfila = $this->mdiscapacidad->mInsert_inscrit_discapacidad(array($newcod->nid,$cbodiscapacidad,$principal));
					}

					if (isset($_POST['inspublicidad'])) {
						$datapubli          = json_decode($_POST['inspublicidad']);
						foreach ($datapubli as $key => $pb) {
							$pbfila = $this->mpublicidad->mInsert_inscrit_publicidad(array($newcod->nid,$pb));
						}
					}

					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está agregando una inscripción en la tabla TB_INSCRIPCION COD.".$newcod->nid." - ".$fitxtcarnet ;

					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));

					$dataex['status'] =TRUE;
					$dataex['msg'] ="File aperturado correctamente";
					$dataex['newcod'] =$newcod->nid;
					$dataex['newcarnet'] =$fitxtcarnet;
					
				}
				elseif ($newcod->salida == 0){
					$dataex['newcod'] =$newcod->nid;
					$dataex['msg'] ="El Alumno ya se encuentra inscrito";
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
        	if (getPermitido("124")=='SI'){
	            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

	            $this->form_validation->set_rules('ce-idins','Id Inscripción','trim|required');
	            $this->form_validation->set_rules('ce-carne','CARNÉ','trim|required');
	            

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
	                $dataex['msg'] ="No se eliminó la inscripción, consulte con Soporte err0 err-1";
	                $dataex['status'] =FALSE;
	                $ceidmat=base64url_decode($this->input->post('ce-idins'));
	                $carne=trim($this->input->post('ce-carne'));

	                $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
	                $accion = "INSERTAR";
	                
	                $newcod=$this->minscrito->m_eliminar(array($ceidmat,$carne));
	                $dataex['newcod'] =$newcod;
	                if ($newcod=='1'){
	                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una inscripción en la tabla TB_INSCRIPCION COD.".$ceidmat;
	                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
	                    $dataex['status'] =TRUE;
	                    $dataex['msg'] ="Ficha de inscrípción, eliminada";
	                }
	                elseif ($newcod=='2'){
	                    $dataex['msg'] ="Se ha encontrado matrículas relacionadas, primero debe eliminar las matrículas ";
	                }
	                elseif ($newcod=='3'){
	                    $dataex['msg'] ="Se ha encontrado un histrorial de reingresos relacionados, primero debe eliminar estos reingresos";
	                }

	            }
	        }

        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

	public function fn_cambiarestado()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('ce-idmat','Id Matrícula','trim|required');
            
            $this->form_validation->set_rules('ce-nestado','Estado','trim|required');
            $this->form_validation->set_rules('ce-periodo','Estado','trim|required');

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
                $ceidmat=base64url_decode($this->input->post('ce-idmat'));
                $cenestado=base64url_decode($this->input->post('ce-nestado'));
                $ceperiodo=$this->input->post('ce-periodo');

                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "EDITAR";
                    
                $newcod=$this->minscrito->m_cambiar_estado(array($ceidmat,$cenestado,$ceperiodo));
                if ($newcod==1){
                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando el estado de una inscripción a $cenestado en la tabla TB_INSCRIPCION COD.".$ceidmat;
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                    $dataex['status'] =TRUE;
                    $dataex['idinscrip'] = base64url_encode($ceidmat);
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

	/*public function fn_asignar_plan()
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
			
			
			$this->form_validation->set_rules('ficbperiodo','Periodo','trim|required|exact_length[5]');
			$this->form_validation->set_rules('ficbcampania','Campaña','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbciclo','Ciclo','trim|required|exact_length[2]');
			$this->form_validation->set_rules('fitxtfecinscripcion','Fec. Nac.','trim|required');

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
				$fimcid=base64url_decode($this->input->post('fimcid'));
				$ficbcarrera=$this->input->post('ficbcarrera');
				$ficbmodalidad=$this->input->post('ficbmodalidad');
				$ficbperiodo=$this->input->post('ficbperiodo');
				$ficbcampania=$this->input->post('ficbcampania');
				$ficbciclo=$this->input->post('ficbciclo');
				$ficbturno=$this->input->post('ficbturno');
				$ficbseccion=$this->input->post('ficbseccion');
				$fitxtobservaciones=strtoupper($this->input->post('fitxtobservaciones'));
				$fitxtfecinscripcion=$this->input->post('fitxtfecinscripcion');

				$ficbcarsigla=$this->input->post('ficbcarsigla');
				$fitxtdni=$this->input->post('fitxtdni');
				$fitxtcarnet=$fitxtdni.$ficbcarsigla;

					//@vidpersona, @vcarnet, @vcodcarrera, @vcodmodalidad, @vcodperido, @vcodcampania, @vcodciclo, @vobservacion, @vfecinscripcion, @`s`

				$newcod=$this->minscrito->m_insert_inscripcion(array($fimcid,$fitxtcarnet,$ficbcarrera,$ficbmodalidad,$ficbperiodo,$ficbcampania,$ficbciclo,$fitxtobservaciones,$fitxtfecinscripcion,$_SESSION['userActivo']->idsede));
				if ($newcod>0){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="File aperturado correctamente";
					$dataex['newcod'] =$newcod;
					$dataex['newcarnet'] =$fitxtcarnet;
					
				}
				
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}*/

	public function get_filtrar_basico_sd_activa(){
		$this->form_validation->set_message('required', '%s Requerido o digite %%%%%%%%');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fbus-txtbuscar','búsqueda','trim');
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
				$busqueda=$this->input->post('fbus-txtbuscar');
				$carrera=$this->input->post('fbus-carrera');
				$periodo=$this->input->post('fbus-periodo');
				$turno=$this->input->post('fbus-turno');
				$campania=$this->input->post('fbus-campania');
				$seccion=$this->input->post('fbus-seccion');
				$ciclo=$this->input->post('fbus-ciclo');
				$busqueda=str_replace(" ","%",$busqueda);
            
				$cuentas['historial']=$this->minscrito->m_filtrar_basico_sd_activa(array($periodo,$campania,$carrera,$ciclo,$turno,$seccion,$_SESSION['userActivo']->idsede,'%'.$busqueda.'%'));
				$conteo=count($cuentas['historial']);
				if ($conteo>0)
				{
					$dataex['conteo'] =$conteo;
					$rscuentas=$this->load->view('admision/inscripciones-lst',$cuentas,TRUE);
				}
				else
				{
					$rscuentas=$this->load->view('errors/sin-resultados',array(),TRUE);
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_get_inscripciones_x_dni_multisedes(){
		$this->form_validation->set_message('required', '%s Requerido o digite %%%%%%%%');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fbus-txtbuscar','búsqueda','trim');
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
				$dni=$this->input->post('ftxtdni');
				$tipo=$this->input->post('ftxttdoc');
				
            
				$cuentas['historial']=$this->minscrito->m_get_inscripciones_x_dni_multisedes(array($tipo,$dni));
				$conteo=count($cuentas['historial']);
				if ($conteo>0)
				{
					$dataex['conteo'] =$conteo;
					$rscuentas=$this->load->view('admision/historial_inscripciones',$cuentas,TRUE);
				}
				else
				{
					$rscuentas=$this->load->view('errors/sin-resultados',array(),TRUE);
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function pdf_ficha_inscripcion($codperiodo,$codins){

		$dataex['status'] =FALSE;
		//$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';

			$codperiodo=base64url_decode($codperiodo);
			$codins=base64url_decode($codins);
			//$carne=base64url_decode($carne);
			
			$this->load->model('miestp');
			$ie=$this->miestp->m_get_datos();
			//if (!is_null($rsfila)){
			$insc=$this->minscrito->m_get_inscripcion_pdf(array($codperiodo,$codins));
			$adjuntos=$this->minscrito->m_get_docsanexados_fichapdf(array($codins));
			$dominio=str_replace(".", "_",getDominio());
			$html1=$this->load->view("admision/rp_fichainscripcion_$dominio", array('ies' => $ie,'ins'=>$insc, 'adjuntos'=>$adjuntos ),true);
	       
	        $pdfFilePath = "$insc->paterno $insc->materno $insc->nombres FICHA $insc->carnet.pdf";

	        $this->load->library('M_pdf');
	        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
	        $mpdf->SetTitle( "$insc->paterno $insc->materno $insc->nombres FICHA $insc->carnet");
	        $mpdf->WriteHTML($html1);
	        //$mpdf->AddPage();
	        //$mpdf->WriteHTML($html2);
	        $mpdf->Output($pdfFilePath, "D");
	}


	public function fn_retira_inscripcion()
    {
    	$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('fic_inscrip_codigo','Id inscripcion','trim|required');
            $this->form_validation->set_rules('ficinscestado','Estado','trim|required');
            
            $this->form_validation->set_rules('ficmotivretiro','Motivo','trim|required');

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
                $codinscrip64 = $this->input->post('fic_inscrip_codigo');
                $codinscrip = base64url_decode($codinscrip64);
                $cenestado = base64url_decode($this->input->post('ficinscestado'));
                $periodo = $this->input->post('ficinsperiodo');
                
                $motivo = $this->input->post('ficmotivretiro');

                date_default_timezone_set ('America/Lima');
                $fecharetiro = date('Y-m-d');

                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "EDITAR";
                    
                $newcod=$this->minscrito->m_update_estado_retiro(array($codinscrip,$fecharetiro,$motivo,$cenestado,$periodo));
                if ($newcod==1){
                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando el estado de una inscripción a $cenestado en la tabla TB_INSCRIPCION COD.".$codinscrip;
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                    $dataex['status'] =TRUE;
                    $dataex['idinscrip'] = $codinscrip64;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_cambiar_grupo_inscripcion()
    {
    	$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('vw_md_gi_inscrip_codigo','Inscripción','trim|required');
            $this->form_validation->set_rules('vw_md_gi_periodo','Periodo','trim|required');
            $this->form_validation->set_rules('vw_md_gi_campania','Campaña','trim|required');
            $this->form_validation->set_rules('vw_md_gi_ciclo','Ciclo','trim|required');
            $this->form_validation->set_rules('vw_md_gi_turno','Turno','trim|required');
            $this->form_validation->set_rules('vw_md_gi_seccion','Sección','trim|required');

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
                $codinscrip64 = $this->input->post('vw_md_gi_inscrip_codigo');
                $inscripcion = base64url_decode($codinscrip64);
                $periodo = $this->input->post('vw_md_gi_periodo');
                $campania = $this->input->post('vw_md_gi_campania');
                $ciclo = $this->input->post('vw_md_gi_ciclo');
                $turno = $this->input->post('vw_md_gi_turno');
                $seccion = $this->input->post('vw_md_gi_seccion');

                date_default_timezone_set ('America/Lima');
                $fecharetiro = date('Y-m-d');

                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "EDITAR";
                    
                $newcod=$this->minscrito->m_update_grupo_inscripcion(array($inscripcion,$periodo,$campania,$ciclo,$turno,$seccion));
                if ($newcod==1){
                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando el grupo de una inscripción en la tabla TB_INSCRIPCION_DETALLE COD.".$inscripcion;
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                    $dataex['status'] =TRUE;
                    $dataex['idinscrip'] = $codinscrip64;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


	public function fn_insert_reingreso()
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

			$this->form_validation->set_rules('vw_fcb_codinscripcion','Identifcador','trim|required');
			$this->form_validation->set_rules('vw_fcb_codmodalidad','Modalidad','trim|required');
			$this->form_validation->set_rules('vw_fcb_cbperiodo','Periodo','trim|required');
			$this->form_validation->set_rules('vw_fcb_campania','Campaña','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('vw_fcb_cbciclo','Ciclo','trim|required');
			$this->form_validation->set_rules('vw_fcb_fecha','Fecha','trim|required');
			// $this->form_validation->set_rules('vw_fcb_cbobservacion','Observación','trim|required');

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

				$fimcid=base64url_decode($this->input->post('vw_fcb_codinscripcion'));
				
				$ficbmodalidad = $this->input->post('vw_fcb_codmodalidad');
				$ficbperiodo = $this->input->post('vw_fcb_cbperiodo');
				$ficbcampania = $this->input->post('vw_fcb_campania');
				$ficbciclo = $this->input->post('vw_fcb_cbciclo');
				$fitxtobservaciones = strtoupper($this->input->post('vw_fcb_cbobservacion'));
				$fecharegistro = date('Y-m-d H:i:s');
				$fitxtfecinscripcion = $this->input->post('vw_fcb_fecha').' '.date('H:i:s');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "INSERTAR";

				$newcod=$this->minscrito->m_insert_reingreso(array($fimcid,$ficbmodalidad,$ficbperiodo,$sede,$ficbcampania,$ficbciclo,$fitxtobservaciones,$fecharegistro,$fitxtfecinscripcion,'0',$usuario));
				

				if ($newcod->salida == 1){
					$data          = json_decode($_POST['filas']);
                
					$rsfila=$this->minscrito->m_insertdocs(array($fimcid,$data));

					$dataex['status'] =TRUE;
					$dataex['msg'] ="File aperturado correctamente";
					$dataex['newcod'] =base64url_encode($fimcid);
					
				}
				elseif ($newcod->salida == 0){
					$dataex['newcod'] =base64url_encode($fimcid);
					$dataex['msg'] ="El Alumno ya se encuentra inscrito en el periodo ".$ficbperiodo;
				}
				
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_activa_inscripcion()
	{
		$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
        	if (getPermitido("150")=='SI') {
	            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

	            $this->form_validation->set_rules('fic_inscodigo_activa','Id inscripcion','trim|required');
	            $this->form_validation->set_rules('ficinscestado_activa','Estado','trim|required');
	            $this->form_validation->set_rules('ficmotivretiro_activa','Motivo','trim|required');

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
	                $codinscrip64 = $this->input->post('fic_inscodigo_activa');
	                $codinscrip = base64url_decode($codinscrip64);
	                $cenestado = base64url_decode($this->input->post('ficinscestado_activa'));
	                $periodo = $this->input->post('ficinsperiodo_activa');
	                
	                $motivo = $this->input->post('ficmotivretiro_activa');

	                date_default_timezone_set ('America/Lima');
	                $fechactivo = date('Y-m-d H:i:s');

	                $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
	                $accion = "EDITAR";
	                    
	                $rpta=$this->minscrito->m_insert_activa_retirado(array($codinscrip,$usuario,$motivo,$fechactivo));
	                if ($rpta->salida == 1){
	                	$rpta2 = $this->minscrito->m_cambiar_estado(array($codinscrip,$cenestado,$periodo));
	                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando el estado de una inscripción a $cenestado en la tabla TB_INSCRIPCION COD.".$codinscrip;
	                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
	                    $dataex['status'] =TRUE;
	                    $dataex['idinscrip'] = $codinscrip64;
	                    $dataex['msg'] ="Cambio registrado correctamente";
	                    
	                }
	            }
	        } else {
	        	$dataex['status'] =false;
	        	$dataex['msg'] ="Acceso denegado";
	        }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
	}

}
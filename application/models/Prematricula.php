<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Sendmail.php';
class Prematricula extends Sendmail {

	function __construct(){
		parent::__construct();
		$this->load->helper("url"); 
		$this->load->model("mcarrera");
		$this->load->model("mprematricula");
		$this->load->model("mperiodo");
		$this->load->model("mmodalidad");
		$this->load->model("mtemporal");
		$this->load->model("mubigeo");
		$this->load->model("mauditoria");
		$this->load->model("msede");
		$this->load->model("mpublicidad");
		$this->load->model("mdiscapacidad");
		$this->load->model("mlenguas");
		
	}

	public function index()
	{
		date_default_timezone_set('America/Lima');
		$arraydts['modalidad'] = $this->mmodalidad->m_get_modalidades();
		$arraydts['turnos'] = $this->mtemporal->m_get_turnos_activos();
		$arraydts['carrera'] = $this->mcarrera->m_lts_carreras_activas();
		$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
		$arraydts['ciclo'] = $this->msede->m_get_ciclos();
		$arraydts['periodos'] = $this->mperiodo->m_get_periodos_para_inscribir();
		$arraydts['departamentos'] = $this->mubigeo->m_departamentos();
		$arraydts['publicidad'] = $this->mpublicidad->m_get_publicidades();
		$arraydts['dprovincias']="";
		$arraydts['ddistritos']="";
		$arraydts['adjuntos'] = "0";
		$this->load->model('miestp');
        $arraydts['ies']=$this->miestp->m_get_datos();
        //$dominio=str_replace(".", "_",getDominio());
		$this->load->view("prematricula/vw_ficha_pre_matricula_cascara", $arraydts);
		
	}

	public function fn_carreras_sedes()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin opciones</option>";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodigosed','Búsqueda','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda = $this->input->post('txtcodigosed');

				$carreras = $this->mcarrera->m_get_carreras_abiertas_por_sede(array($busqueda));

				if (count($carreras)>0) $rsoptions="<option value=''>Seleccione programa</option>";
				foreach ($carreras as $car) {
					$rsoptions=$rsoptions."<option value='$car->codcarrera'>$car->nombre</option>";
				}
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rsoptions;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vw_ficha_pre_inscripcion()
	{
		date_default_timezone_set('America/Lima');
		$ahead= array('page_title' =>'PRE-MATRÍCULA | IESTWEB'  );
		$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'preinscripcion');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar', $asidebar);
		

		$arraydts['modalidad'] = $this->mmodalidad->m_get_modalidades();
		$arraydts['turnos'] = $this->mtemporal->m_get_turnos_activos();
		$arraydts['carrera'] = $this->mcarrera->m_lts_carreras_activas();
		$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
		$arraydts['ciclo'] = $this->msede->m_get_ciclos();
		$arraydts['periodos'] = $this->mperiodo->m_get_periodosxestado();
		$arraydts['departamentos'] = $this->mubigeo->m_departamentos();
		$arraydts['publicidad'] = $this->mpublicidad->m_get_publicidades();
		$arraydts['dprovincias']="";
		$arraydts['ddistritos']="";
		$arraydts['adjuntos'] = "0";
		$this->load->model('miestp');
        $arraydts['ies']=$this->miestp->m_get_datos();
        $dominio=str_replace(".", "_",getDominio());
		$this->load->view("prematricula/vw_ficha_pre_matricula_$dominio", $arraydts);


		
		$this->load->view('footer');
	}

	public function vw_update_ficha_pre_inscripcion($codigo)
	{
		date_default_timezone_set('America/Lima');
		$ahead= array('page_title' =>'PRE-MATRÍCULA - EDITAR | IESTWEB'  );
		$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'preinscripcion');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar', $asidebar);
		$rptaprem = $this->mprematricula->m_get_ficha_preinscripcion(base64url_decode($codigo));
		$arraydts = $rptaprem;
		// $modalidad = $this->mmodalidad->m_get_modalidades();
		$arraydts['modalidad'] = $this->mmodalidad->m_get_modalidades();
		$arraydts['turnos'] = $this->mtemporal->m_get_turnos_activos();
		$arraydts['carrera'] = $this->mcarrera->m_lts_carreras_activas();
		$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
		$arraydts['ciclo'] = $this->msede->m_get_ciclos();
		$arraydts['periodos'] = $this->mperiodo->m_get_periodosxestado();
		$arraydts['departamentos'] = $this->mubigeo->m_departamentos();
		$arraydts['publicidad'] = $this->mpublicidad->m_get_publicidades();
		
		$this->load->model('miestp');
        $arraydts['ies']=$this->miestp->m_get_datos();
        $dominio=str_replace(".", "_",getDominio());

        //BUSCAR UBIGEO
		$rsprov="<option value='0'>Sin opciones</option>";
		$provincias=$this->mubigeo->m_provincias(array($rptaprem['ficha']->codepartamento));
		if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
		foreach ($provincias as $provincia) {
			$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
		}

		$rsdistri="<option value='0'>Sin opciones</option>";
		$distritos=$this->mubigeo->m_distritos(array($rptaprem['ficha']->codprovincia));
		if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
		foreach ($distritos as $distrito) {
			$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
		}

		$arraydts['dprovincias']=$rsprov;
		$arraydts['ddistritos']=$rsdistri;

		$this->load->view("prematricula/vw_ficha_pre_matricula_$dominio", $arraydts);
		
		$this->load->view('footer');
	}

	public function fn_insert()
	{
		$this->form_validation->set_message('required', '* {field} Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('regex_match', '* {field} no es válido');
		
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$trabaja = $this->input->post('cbtrabaja');
			if ($trabaja == "SI") {
				$this->form_validation->set_rules('txtlugtrabajo','Empresa /Institución donde labora','trim|required');
			}

			$this->form_validation->set_rules('txt_sede','Sede','trim|required');
			$this->form_validation->set_rules('txt_modalidad','Modalidad','trim|required');
			$this->form_validation->set_rules('cbocarrera','Programa de estudios','trim|required');
			$this->form_validation->set_rules('txt_turno','Turno','trim|required');
			$this->form_validation->set_rules('txtape_paterno','Apellidos paterno','trim|required');
			$this->form_validation->set_rules('txtape_materno','Apellidos materno','trim|required');
			$this->form_validation->set_rules('txtnombres','Nombres','trim|required');
			$this->form_validation->set_rules('txt_tpdoc','Tipo documento','trim|required');
			$this->form_validation->set_rules('txtdni','N° documento','trim|required');
			$this->form_validation->set_rules('txt_fecnac','Fecha de Nacimiento','trim|required|regex_match[/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/]');
			$this->form_validation->set_rules('txt_genero','Género','trim|required');
			$this->form_validation->set_rules('txttelefono','Teléfono','trim|required');
			//$this->form_validation->set_rules('txtcorreo','Correo electrónico','trim|required');
			$this->form_validation->set_rules('txt_departamento','Departamento','trim|required');
			$this->form_validation->set_rules('txt_provincia','Provincia','trim|required');
			$this->form_validation->set_rules('txt_distrito','Distrito','trim|required');
			$this->form_validation->set_rules('txt_direccion','Dirección','trim|required');
			$this->form_validation->set_rules('txt_centroestud','Centro de estudios','trim|required');
			$this->form_validation->set_rules('txtlugnac','Lugar Nacimiento','trim|required');
			//$this->form_validation->set_rules('txtinsti_traslado','Instituto','trim|required');
			$this->form_validation->set_rules('txt_periodo','Periodo','trim|required');
			$this->form_validation->set_rules('txtestcivil','Estado Civil','trim|required');
			$this->form_validation->set_rules('cbodispacacidad','Discapacidad','trim|required');
			

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

				$dataex['msg']="No hay errores de campos";
				$dataex['status'] =FALSE;
				
				$codigo64 = $this->input->post('fictxtcodigo_pre');
				$codigo = base64url_decode($codigo64);
				$periodo = $this->input->post('txt_periodo');
				$sede = $this->input->post('txt_sede');
				$modalidad = $this->input->post('txt_modalidad');
				$carrera = $this->input->post('cbocarrera');
				$turno = $this->input->post('txt_turno');
				$ciclo = $this->input->post('txt_ciclo');

				$paterno = mb_strtoupper($this->input->post('txtape_paterno'));
				$materno = mb_strtoupper($this->input->post('txtape_materno'));
				$nombres = mb_strtoupper($this->input->post('txtnombres'));
				$tipodoc = $this->input->post('txt_tpdoc');
				$documento = $this->input->post('txtdni');
				$genero = $this->input->post('txt_genero');
				$lugtrab = mb_strtoupper($this->input->post('txtlugtrabajo'));
				$fecnacim = $this->input->post('txt_fecnac');
				$lugarnac = mb_strtoupper($this->input->post('txtlugnac'));
				$estadociv = $this->input->post('txtestcivil');
				$telefono = $this->input->post('txttelefono');
				$correo = $this->input->post('txtcorreo');
				$apenompa = mb_strtoupper($this->input->post('txtapenompa'));
				$apenomma = mb_strtoupper($this->input->post('txtapenomma'));
				$ocupapadre = mb_strtoupper($this->input->post('txtocupadre'));
				$ocupamadre = mb_strtoupper($this->input->post('txtocumadre'));

				$aniosecundaria = $this->input->post("txt_secuanio");
				$lenguaorig = mb_strtoupper($this->input->post("txtlenguaorig"));
				$publicidad = $this->input->post("vw_mpc_publicidad");

				$distrito = $this->input->post('txtnomdistrito') . " - " . $this->input->post('txtnomprovin') . " - " . $this->input->post('txtnomdepart');
				$direccion = mb_strtoupper($this->input->post('txt_direccion'));
				$centroestd = mb_strtoupper($this->input->post('txt_centroestud'));


				$coddistrito = $this->input->post('txt_distrito');
				
				$instituto = $this->input->post('txt_inst_traslado');

				$discapacidad = $this->input->post('cbodispacacidad');
				$detdiscapacidad = mb_strtoupper($this->input->post('txtdetadiscapac'));
				
				if ($ciclo == "") {
					$ciclo = "01";
				}



				$fecha_explode = explode("/", $fecnacim);

				if (checkdate($fecha_explode[1], $fecha_explode[0], $fecha_explode[2])==true){
					$dataex['msg']="Prueba de fecha superada";
					// $sede = "0";
					// $rptaper = $this->mprematricula->m_get_periodosxestado();
					// $periodo = $rptaper->codigo;
					$fecnacim_mysql=$fecha_explode[2]."-".$fecha_explode[1]."-".$fecha_explode[0];
					
					if ($codigo64 == "0") {
						$rpta = $this->mprematricula->insert_datos_prematricula(array($paterno, $materno, $nombres, $tipodoc, $documento, $fecnacim_mysql, $genero, $estadociv, $telefono, $correo, $apenompa, $ocupapadre, $apenomma, $ocupamadre, $carrera, $sede, $periodo, $modalidad, $turno, $ciclo, $distrito, $direccion, $centroestd, $lugarnac, $coddistrito, $instituto, $trabaja, $lugtrab, $discapacidad, $detdiscapacidad, $aniosecundaria, $lenguaorig, $publicidad));

						$crudaccion = "INSERTAR";
					} else {
						$rpta = $this->mprematricula->update_datos_prematricula(array($codigo, $paterno, $materno, $nombres, $tipodoc, $documento, $fecnacim_mysql, $genero, $estadociv, $telefono, $correo, $apenompa, $ocupapadre, $apenomma, $ocupamadre, $carrera, $sede, $periodo, $modalidad, $turno, $ciclo, $distrito, $direccion, $centroestd, $lugarnac, $coddistrito, $instituto, $trabaja, $lugtrab, $discapacidad, $detdiscapacidad, $aniosecundaria, $lenguaorig, $publicidad));

						$crudaccion = "EDITAR";
					}
					
					if ($rpta->salida=='1'){
						$data          = json_decode($_POST['vw_mpc_archivos']);
		                $pathtodir =  getcwd() ; 
		                $allfiles=true;
		                foreach ($data as $key => $fl) {

		                	if (!file_exists ("upload/tramites/".$fl[0])){
		                		$rptafil = $this->mprematricula->insert_archivos(array($rpta->nid,$fl[4],$fl[0],$fl[1],$fl[2],$fl[3]));

		                		if ($rptafil->salida=="1"){
			                        $link=$fl[0];
			                        $copied = copy($pathtodir."/upload/tramites/tmp/".$link  , $pathtodir."/upload/tramites/".$link);
			                        
			                        if ((!$copied)) 
			                        {
			                            $allfiles=false;
			                        }

			                    }
		                	}
		                    
		                    
		                }
		                $enviar_mail=false;
		                if ($correo != "") {
		                	$enviar_mail=true;
		                }

		                if ($enviar_mail==true){
		                    $this->load->model('miestp');
		                    $iestp=$this->miestp->m_get_datos();
		                    $constancia = $this->mprematricula->m_get_preinscripcion(array($rpta->nid));

		                    $d_destino=array();
		                    $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
		                    
		                    if ($correo!=""){
		                        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
		                            $d_destino[]=$correo;
		                        }
		                    }

		                    $files_mail=array();
		                    $r_respondera=$d_enviador;

		                    if (count($d_destino)>0){
		                        
		                        $d_mensaje="<p>Se le ha enviado su constancia de preinscripción con Éxito</p>";
		                        $d_asunto = "CONSTANCIA PRE INSCRIPCIÓN ".$constancia->numero;

		                        $pdfficha = $this->pdf_ficha_preinscripcion_mail(base64url_encode($rpta->nid));
		                        
		                        foreach ($data as $key => $fl) {
		                            
		                           $files_mail[]=array($pathtodir."/upload/tramites/".$fl[0], 'attachment',$fl[1]);    
		                        }
		                        
		                        $files_mail[]=array($pdfficha, 'attachment',"CONSTANCIA PRE INSCRIPCIÓN ".$constancia->numero.".pdf","application/pdf");
		                        
		                    }
		                    
		                    $rsp_email=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$files_mail,$r_respondera);
		                    $dataex['statusmail'] = $rsp_email['estado'];
		                }

		                if ($allfiles==true){
		                    $dataex['status'] = true;
		                    $codigo64 = base64url_encode($rpta->nid);
		                    $dataex['newid'] = $codigo64;
		                    $urlpdfdw = base_url()."ficha-pre-inscripcion/pdf-descargar/".$codigo64;
		                    $dataex['download'] = $urlpdfdw;
		                    $dataex['msg'] ="Datos enviados correctamente";
		                    $dataex['email'] = $correo;
		                    $dataex['accion'] = $crudaccion;
		                }
						
					}
				}
				else{

					$dataex['errors']= array('txt_fecnac' => 'Fecha incorrecta' );
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function lts_prematricula()
	{
		date_default_timezone_set('America/Lima');
		$ahead= array('page_title' =>'LISTADO PRE-MATRÍCULA | IESTWEB'  );
		$asidebar= array('menu_padre' =>'admision','menu_hijo' =>'preinscripcion');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar', $asidebar);
		$arraydts['carrera'] = $this->mcarrera->m_get_carreras();
		$arraydts['periodo'] = $this->mperiodo->m_get_periodos();
		$databuscar=array('%', '%', '%','%','%');
		$arraydts['historial'] = $this->mprematricula->m_dtsPreinscripcionxfechas( $databuscar );
		$this->load->view('prematricula/listado', $arraydts);
		$this->load->view('footer');
	}

	public function vw_aprobar_preinscripcion()
	{
		date_default_timezone_set('America/Lima');
		
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
        	if (getPermitido("56")=='SI'){

        	}
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede aprobar esta preinscripción";
                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));

                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "ELIMINAR";
                
                $pre = $this->mprematricula->m_get_preinscripcion($txtcodigo);
                $this->load->model("mpersona");
                $persona=$this->mpersona->m_get_datosminimos_x_dni(array($pre->numero));;
                
				if (!is_null($persona)){
					
	                $dataex['msg']    = "El número de DNI: $pre->numero ya se encuentra registrado, RECOMENDACIÓN: Deberás realizar una inscripción de manera tradicional ";
				}
				else{
					$this->load->model("minscrito");
	                $inscrito=$this->minscrito->m_get_inscrito_por_carne(array($pre->numero.$pre->sigla));;
					if (!is_null($inscrito)){
						
		                $dataex['msg']    = "Ya existe una inscripción con el código: {$pre->numero}{$pre->sigla}, RECOMENDACIÓN: Deberás realizar una inscripción de manera tradicional ";
					}
					else{
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
						
						$a_ins['docs_anexar']=$this->mtemporal->m_get_docs_por_anexar();

						$a_ins['discapacidades']=$this->mdiscapacidad->m_filtrar_discapacidadxestado();
						$a_ins['dlenguas']=$this->mlenguas->m_get_lenguas();

						$this->load->model('mcampania');
						$a_ins['campanias']=$this->mcampania->m_get_campanias_por_periodo(array($pre->codperiodo,$_SESSION['userActivo']->idsede));
						
						$a_ins['pre']=$pre;
						$a_ins['estdiscapacidad']=$pre->discapacidad;
						$a_ins['discapacidad']=$pre->nomdiscapacidad;
						$a_ins['lengua']=$pre->lenguaorig;

						$rsform = $this->load->view('prematricula/vw_aprobar_inscripcion',$a_ins,TRUE);
						$dataex['form'] = $rsform;
						$dataex['status'] = true;
					}
				}



                /*if ($rpta->salida == '1') {
                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está aprobó una preinscripción en la tabla TB_PRE_INSCRIPCION COD.".$rpta->nid;

                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                	if ($auditoria > 0) {
                		
	                    $dataex['status'] = true;
	                    $dataex['msg']    = 'Pre Inscripción eliminado correctamente';
                	}
                }*/
                
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}


	public function get_filtrar_historial()
	{
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rspreinsc = "";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
				$busqueda = $this->input->post('txtapenombres');
				$carrera = $this->input->post('cboprograma');
				$periodo = $this->input->post('cboperiodo');

				$tipo = $this->input->post('cbotipo');
				$estado = $this->input->post('cboestado');

				//if ($checkstatus == "on"){
				$fechaini = $this->input->post('txtfecha');
				$fechafin = $this->input->post('txtfechafin');

				
				$databuscar=array('%'.$busqueda.'%', $carrera, $periodo, $tipo, $estado);
				if ($fechaini != "" && $fechafin != "") {
					$horaini = ' 00:00:01';
					$horafin = ' 23:59:59';
					$databuscar[]=$fechaini.$horaini;
					$databuscar[]=$fechafin.$horafin;
				}
				elseif ($fechaini == "" && $fechafin == "") {
					/*$fechaini='1990-01-01 00:00:01';
					$fechafin=date("Y-m-d").' 23:59:59';*/
				}
				elseif ($fechaini == "") {
					$fechaini='1990-01-01 00:00:01';
					$fechafin=$fechafin.' 23:59:59';
					$databuscar[]=$fechaini;
					$databuscar[]=$fechafin;
				}
				else{
					$fechaini=$fechaini.' 00:00:01';
					$fechafin=date("Y-m-d").' 23:59:59';
					$databuscar[]=$fechaini;
					$databuscar[]=$fechafin;
				}
			
				$preinsc['historial'] = $this->mprematricula->m_dtsPreinscripcionxfechas( $databuscar );
				/*} 
				else {
					$preinsc['historial'] = $this->mprematricula->m_dtsPreinscripcion(array('%'.$busqueda.'%', $carrera, $periodo));
				}*/

				
				///$conteo = count($preinsc['historial']);
				//if ($conteo > 0)
				//{
					//$dataex['conteo'] = $conteo;
					$rspreinsc = $this->load->view('prematricula/dtshistorial_pre',$preinsc,TRUE);
				//}
				/*else
				{
					$rspreinsc = $this->load->view('errors/sin-resultados',array(),TRUE);
				}*/
				$dataex['status'] = TRUE;
			
		}
		$dataex['vdata'] = $rspreinsc;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insert_seguimiento()
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
			
			$this->form_validation->set_rules('fictxtcodigo','Codigo','trim|required');
			$this->form_validation->set_rules('cboficestado','Estado','trim|required');
			$this->form_validation->set_rules('fictxtobserv','Observación','trim|required');
			$this->form_validation->set_rules('fictxtfecha','Fecha','trim|required');
			$this->form_validation->set_rules('fictxthora','Hora','trim|required');
			

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
				
				$codigo = base64url_decode($this->input->post('fictxtcodigo'));
				$estado = $this->input->post('cboficestado');
				$observacion = $this->input->post('fictxtobserv');
				$fecha = $this->input->post('fictxtfecha');
				$hora = $this->input->post('fictxthora');

				$usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;

				$rpta = $this->mprematricula->m_insert_seguimiento(array($codigo, $estado, $observacion, $fecha, $hora));
				if ($rpta->salida==1){
					$accion = "INSERTAR";
	        		$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando un seguimimiento en la tabla TB_DETALLE_PREINSCRIPCION COD.".$rpta->nid;
	        		$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));

					$dataex['status'] = TRUE;
					$dataex['msg'] ="Datos guardados correctamente";
					
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_search_seguimiento()
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
			
			$codigo = base64url_decode($this->input->post('txtcodigo'));

			$rstdata = $this->mprematricula->m_filtrar_seguimiento(array($codigo));
			if (@count($rstdata) > 0) {
                $dataex['status'] = true;
                $rsdata['seguimiento'] = $rstdata;
                $datos = $this->load->view('prematricula/data_seguimiento', $rsdata, true);
            } else {
            	$dataex['status'] = false;
            	$datos = $this->load->view('prematricula/sin-resultados',array(),TRUE);
            }
								
			
		}
		$dataex['vdata'] = $datos;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));

	}


	public function fn_aprobar_preinscripcion()
	{
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
        	if (getPermitido("56")=='SI'){

        	}
            $this->form_validation->set_message('required', '%s Requerido');
			$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
			$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
			$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            
			$this->form_validation->set_rules('ficbcarrera','Carrera','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbmodalidad','Modalidad','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbperiodo','Periodo','trim|required|exact_length[5]');
			$this->form_validation->set_rules('ficbcampania','Campaña','trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('ficbciclo','Ciclo','trim|required|exact_length[2]');
			$this->form_validation->set_rules('fitxtfecinscripcion','Fec. Nac.','trim|required');

			$estadiscap = $this->input->post('ficestadodiscap');
			if ($estadiscap == "SI") {
				$this->form_validation->set_rules('ficbdiscapacidad','Discapacidad','trim|required|is_natural_no_zero');
			}
			$this->form_validation->set_rules('ficblenguas','lengua','trim|required|is_natural_no_zero');

            $this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = "Falta completar algunos datos";
                $errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);

            } 
            else {
                $dataex['msg'] = "Ocurrio un error, no se pudo aprobar esta preinscripción";

                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));

                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "ELIMINAR";
                
                $pre = $this->mprematricula->m_get_preinscripcion($txtcodigo);
                $this->load->model("mpersona");
                $persona=$this->mpersona->m_get_datosminimos_x_dni(array($pre->numero));;
				if (!is_null($persona)){
					
	                $dataex['msg']    = "El número de DNI: $pre->numero ya se encuentra registrado, RECOMENDACIÓN: Deberás realizar una inscripción de manera tradicional ";
				}
				else{
					$this->load->model("minscrito");
	                $inscrito=$this->minscrito->m_get_inscrito_por_carne(array($pre->numero.$pre->sigla));;
					if (!is_null($inscrito)){
						
		                $dataex['msg']    = "Ya existe una inscripción con el código: {$pre->numero}{$pre->sigla}, RECOMENDACIÓN: Deberás realizar una inscripción de manera tradicional ";
					}
					else{

						$ficbtipodoc=$pre->tipodoc;
						$fitxtdni=$pre->numero;
						$fitxtcodinstitucional=$pre->numero;
						$fitxtapelpaterno=mb_strtoupper($pre->paterno);
						$fitxtapelmaterno=mb_strtoupper($pre->materno);
						$fitxtnombres=mb_strtoupper($pre->nombres);
						$ficbsexo=$pre->sexo;
						$fitxtfechanac=$pre->fecnac;
						$fitxtcelular=$pre->telefono;
						$fitxtcelular2="";
						$fitxttelefono="";
						$fitxtemailpersonal=$pre->correo;
						$fitxtdomicilio=mb_strtoupper($pre->direccion);
						$ficbdistrito=$pre->coddistrito;
						$fitxtdomiciliootro="";
						$colegio=$pre->centro;
						$lugarnacimiento=$pre->lugnac;
						$nompadre=$pre->padre;
						$ocupapadre=$pre->ocupapadre;
						$nommadre=$pre->madre;
						$ocupamadre=$pre->ocupamadre;
						$estadociv=$pre->estcivil;

						$codlengua = $this->input->post('ficblenguas');
						$otraslenguas = mb_strtoupper($this->input->post('ficbotrlenguas'));

						$rsrpta=$this->mpersona->insert_persona_aprobado(array($fitxtcodinstitucional,$ficbtipodoc,$fitxtdni,$fitxtapelpaterno,$fitxtapelmaterno,$fitxtnombres,$ficbsexo,$fitxtfechanac,$fitxtcelular,$fitxttelefono,$fitxtemailpersonal,$fitxtdomicilio,$ficbdistrito,$fitxtdomiciliootro,'4',$colegio,$lugarnacimiento, $estadociv, $nompadre, $ocupapadre, $nommadre, $ocupamadre, $codlengua, $otraslenguas));
						
						if ($rsrpta->salida=='1'){
							
							$dataex['msg'] ="File aperturado correctamente";
							$fimcidpersona=$rsrpta->nid;
							//$fiinscripcion=$this->input->post('fiinscripcion');
							$ficbcarrera=$this->input->post('ficbcarrera');
							$ficbmodalidad=$this->input->post('ficbmodalidad');
							$ficbperiodo=$this->input->post('ficbperiodo');
							$ficbcampania=$this->input->post('ficbcampania');
							$ficbciclo=$this->input->post('ficbciclo');
							$ficbturno=$this->input->post('ficbturno');
							$ficbseccion=$this->input->post('ficbseccion');
							$fitxtobservaciones=mb_strtoupper($this->input->post('fitxtobservaciones'));
							$fitxtfecinscripcion=$this->input->post('fitxtfecinscripcion');

							$ficbcarsigla=$this->input->post('ficbcarsigla');
							$fitxtdni=$pre->numero;
							$fitxtcarnet=$fitxtdni.$ficbcarsigla;

							$usuario = $_SESSION['userActivo']->idusuario;
							$codpreinsc = $pre->codpre;
							$trasladoinst = $pre->instituto;
							$discapacidad = $pre->discapacidad;
							$detdiscapacidad = $pre->nomdiscapacidad;

							$dtpublicidad = $pre->publicidad;

							//if ($fiinscripcion=="0"){
								//INSERTAR NUEVA INSCRIPCIÓN
							$rptains=$this->minscrito->m_insert_inscripcion2(array($fimcidpersona,$fitxtcarnet,$ficbcarrera,$ficbmodalidad,$ficbperiodo,$ficbcampania,$ficbciclo,$fitxtobservaciones,$fitxtfecinscripcion,$_SESSION['userActivo']->idsede,$fitxtcarnet.'@'.getDominio(), $usuario, $codpreinsc, $trasladoinst,$discapacidad,$detdiscapacidad,$ficbturno,$ficbseccion));
							//}
							//else{
								//EDITAR INSCRIPCIÓN
							//}
							
							$dataex['msgprueba'] = $rptains->salida;

							if ($rptains->salida=='1'){
								if (isset($_POST['doc-anexados'])) {
									
									$data          = json_decode($_POST['doc-anexados']);
									$rsfila=$this->minscrito->m_insertdocs(array($rptains->nid,$data));
									
								}

								if (isset($_POST['discapacidades'])) {
									$datadis = json_decode($_POST['discapacidades']);
									foreach ($datadis as $key => $dsc) {
										$dsfila = $this->mdiscapacidad->mInsert_inscrit_discapacidad(array($rptains->nid,$dsc[0],$dsc[1]));
									}
								}

								if (isset($dtpublicidad) || $dtpublicidad != "") {
									$dtpublic = explode(",",$dtpublicidad);
									
									foreach ($dtpublic as $key => $value) {
										$pbfila = $this->mpublicidad->mInsert_inscrit_publicidad(array($rptains->nid,$value));
									}
									
								}
								
								date_default_timezone_set ('America/Lima');
								
								$sede = $_SESSION['userActivo']->idsede;
								$accion = "INSERTAR";
				        		$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está APROBANDO UNA PREINSCRIPCION COD.".$txtcodigo;
				        		$this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
				        		$rptasg = $this->mprematricula->m_insert_seguimiento(array($txtcodigo, 'INSCRITO', "APROBADO POR: ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres, date("Y-m-d"), date("H:i:s")));
								
								$dataex['status'] =true;
								$dataex['msg'] ="File aperturado correctamente";
								$dataex['newcod'] =$rptains->nid;
								$dataex['newcarnet'] =$fitxtcarnet;
								
							}
						}

						
					}
				}
                
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}

	public function fn_eliminar()
	{
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar esta preinscripción";
                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));

                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
                $accion = "ELIMINAR";
                
                $rptfile = $this->mprematricula->m_archivos_adjuntos(array($txtcodigo));

                $rpta = $this->mprematricula->delete_preinscripcion(array($txtcodigo));

                if ($rpta->salida == 1) {
                	$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando una preinscripción en la tabla TB_PRE_INSCRIPCION COD.".$rpta->nid;

                	if (count($rptfile) > 0) {
	                	foreach ($rptfile as $key => $value) {
	                		$rptafile = $this->mprematricula->m_elimina_archivo(array($rpta->nid));
	                		
	                		if (file_exists ("upload/tramites/tmp/".$value->link)){

		                		unlink("./upload/tramites/tmp/".$value->link);
		                		
		                	}

		                	if (file_exists ("upload/tramites/".$value->link)) {

		                		unlink("./upload/tramites/".$value->link);
		                	}
	                	}
	                }

                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
                	if ($auditoria > 0) {
                		
	                    $dataex['status'] = true;
	                    $dataex['msg']    = 'Pre Inscripción eliminado correctamente';
                	}
                	
                    
                }
                
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}

	public function fn_upload_file_externo(){
        $dataex['status'] = false;
        $dataex['msg'] = 'Sin Archivo';
        if ($_FILES['vw_mpc_file']['name']) {
            if (!$_FILES['vw_mpc_file']['error']) {
                $name = $_FILES['vw_mpc_file']['name'];//md5(Rand(100, 200));
                $ext = explode('.', $_FILES['vw_mpc_file']['name']);
                $ult=count($ext);
                $nro_rand=rand(0,9);
                $nro_rand2=rand(0,100);
                $NewfileName  = "pin_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$nro_rand2;
                $filename = $NewfileName.".".$ext[$ult-1];//. '.' . $ext[1];
                
                $destination = './upload/tramites/tmp/' .$filename ; //change this directory
                $location = $_FILES["vw_mpc_file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                
                $dataex['msg'] = 'Archivo subido correctamente';
                $dataex['link'] = $filename;
                $dataex['status'] = true;

                
            }
            else {
                $dataex['msg'] = 'Se ha producido el siguiente error:  '.$_FILES['vw_mpc_file']['error'];
            }
        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_view_archivos_adjuntos()
    {
    	$dataex['status'] = false;
        $dataex['msg']    = "No se ha podido establecer el origen de esta solicitud";
        $this->form_validation->set_message('required', '%s Requerido');

        if ($this->input->is_ajax_request()) {
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'Cod. Pre Inscripción', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } 
            else {
                $seg = base64url_decode($this->input->post('txtcodigo'));
                $dataex['status'] = true;
                $arraytip = $this->mprematricula->m_get_ficha_preinscripcion($seg);
                $arraytip['publicidad'] = $this->mpublicidad->m_get_publicidades();
                $dataex['estado'] = $arraytip['ficha']->estado;
                $dataex['linkupd'] = base_url()."admision/ficha-pre-inscripcion/editar/".base64url_encode($arraytip['ficha']->codpre);
                $dataex['vdata']      = $this->load->view('prematricula/vw_ver_ficha_pre_ajax', $arraytip, true);
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_delete_file()
    {
    	$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este banner";
                $codigo64 = $this->input->post('txtcodigo');
                $codigo    = base64url_decode($codigo64);
                $link    = $this->input->post('archivo');

                if ($codigo64 != "0") {
                	$usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
					$fictxtaccion = "ELIMINAR";

	                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un archivo en la tabla TB_PRE_INSCRIPCION_ARCHIVOS COD.".$codigo;
                	$rpta = $this->mprematricula->m_elimina_archivo(array($codigo));
                } else {
                	$rpta = 1;
                }
                
                if ($rpta == 1) {
                	if (file_exists ("upload/tramites/tmp/".$link)){

                		unlink("./upload/tramites/tmp/".$link);
                		
                	}

                	if (file_exists ("upload/tramites/".$link)) {

                		unlink("./upload/tramites/".$link);
                	}
                	
                	if ($codigo64 != "0") {
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
					}

                    $dataex['status'] = true;
                    $dataex['msg']    = 'archivo eliminado correctamente';
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_enviar_constancia_preins_correo()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
        $this->form_validation->set_message('is_natural', '* {field} requiere un nímero entero');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('codigo','codigo ficha','trim|required');

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
                $dataex['msg']    = 'Error al enviar';

                $codigofi64 = $this->input->post('codigo');
                $codficha=base64url_decode($codigofi64);
                $files_mail=array();
                // ENVIO DE FICHA AL CORREO
                $constancia = $this->mprematricula->m_get_ficha_preinscripcion(array($codficha));

                $pathtodir =  getcwd() ;
                $this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();
                $d_destino = $constancia['ficha']->correo;
                $d_asunto = "CONSTANCIA PRE INSCRIPCIÓN ".$constancia['ficha']->numero;
                $pdfficha = $this->pdf_ficha_preinscripcion_mail($codigofi64);
                $d_mensaje="<p>Se le ha enviado su constancia de preinscripción con Éxito</p>";
                foreach ($constancia['adjuntos'] as $key => $fl) {
		                            
                   $files_mail[]=array($pathtodir."/upload/tramites/".$fl->link  , 'attachment', $fl->archivo);    
                }

                $files_mail[]=array($pdfficha, 'attachment',"CONSTANCIA PRE INSCRIPCIÓN ".$constancia['ficha']->numero.".pdf","application/pdf");
                $dataex['files'] = $files_mail;
                $dataex['files2'] = $constancia['adjuntos'];
                $d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                $r_respondera = $d_enviador;
                $rsp=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$files_mail,$r_respondera);
                $dataex['statusmail'] = $rsp['estado'];
                // FIN DE ENVIO CORREO
                
                if ($rsp['estado'] == true) {
                    $dataex['status'] = TRUE;
                    $dataex['msg'] = "Constancia enviado correctamente";
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function pdf_ficha_preinscripcion_mail($codins){

		$dataex['status'] =FALSE;
		//$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';

			$codins=base64url_decode($codins);
			
			$this->load->model('miestp');
			$ie=$this->miestp->m_get_datos();
			
			$insc=$this->mprematricula->m_get_ficha_preinscripcion(array($codins));
			$dominio=str_replace(".", "_",getDominio());
			$html1=$this->load->view("prematricula/rp_fichapreinscripcion_$dominio", array('ies' => $ie,'ins'=>$insc ),true);
	       
	        $pdfFilePath = $insc['ficha']->paterno." ".$insc['ficha']->materno." ".$insc['ficha']->nombres ."FICHA". $insc['ficha']->numero.".pdf";

	        $this->load->library('M_pdf');
	        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
	        $mpdf->SetTitle( $insc['ficha']->paterno." ".$insc['ficha']->materno." ".$insc['ficha']->nombres ."FICHA". $insc['ficha']->numero);
	        $mpdf->WriteHTML($html1);
	        
	        return $mpdf->Output($pdfFilePath, "S");
	}

    public function pdf_ficha_preinscripcion($codins){

		$dataex['status'] =FALSE;
		//$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';

			$codins=base64url_decode($codins);
			
			$this->load->model('miestp');
			$ie=$this->miestp->m_get_datos();
			
			$insc=$this->mprematricula->m_get_ficha_preinscripcion(array($codins));
			$dominio=str_replace(".", "_",getDominio());
			$html1=$this->load->view("prematricula/rp_fichapreinscripcion_$dominio", array('ies' => $ie,'ins'=>$insc ),true);
	       
	        $pdfFilePath = $insc['ficha']->paterno." ".$insc['ficha']->materno." ".$insc['ficha']->nombres ."FICHA". $insc['ficha']->numero.".pdf";

	        $this->load->library('M_pdf');
	        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
	        $mpdf->SetTitle( $insc['ficha']->paterno." ".$insc['ficha']->materno." ".$insc['ficha']->nombres ."FICHA". $insc['ficha']->numero);
	        $mpdf->WriteHTML($html1);
	        
	        $mpdf->Output($pdfFilePath, "I");
	}

}
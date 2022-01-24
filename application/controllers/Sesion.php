<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sesion extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper("url"); 
		$this->load->library('form_validation');
		$this->load->model('msesiones');
		$this->load->model('mmiembros');

	}

	
	public function f_agregar_sesion(){
		$dataex['status'] =false;
		$dataex['msg'] ='No se puede establecer el origen de la petición';
		if($this->input->is_ajax_request()){
			$this->form_validation->set_message('required', '%s Requerido');
			$urlRef=base_url();
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtdetalle','Detalle','trim|required');
			$this->form_validation->set_rules('txtfecha','Fecha','trim|required');
			$this->form_validation->set_rules('txthoraini','Hora Inicia','trim|required');
			$this->form_validation->set_rules('txthorafin','Hora fin','trim|required');
			$this->form_validation->set_rules('txtcacad','Carga','trim|required');
			$this->form_validation->set_rules('txtnrosesion','Nro Sesión','trim|required');
			/*$this->form_validation->set_rules('txtssec','Subsección','trim|required');
			$this->form_validation->set_rules('txtcdoc','Docente','trim|required');*/
			$this->form_validation->set_rules('cbtiposesion','Tipo','trim|required');
			if ($this->form_validation->run() == FALSE){
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
				// $dataex['msg']=validation_errors();
			}
			else{

				$dataex['msg']="Ocurrio un error al intentar agregar una sesión de clase";
				$txtdetalle=$this->input->post('txtdetalle');
				$txtfecha=$this->input->post('txtfecha');
				$txthoraini=$this->input->post('txthoraini');
				$txthorafin=$this->input->post('txthorafin');
				$txtcacad=$this->input->post('txtcacad');
				$txtnrosesion=$this->input->post('txtnrosesion');
				$txtssec=$this->input->post('txtssec');
				/*$txtcdoc=$this->input->post('txtcdoc');*/
				$cbtiposesion=$this->input->post('cbtiposesion');
				//@`vses_fecha`, @`vses_horaini`, @`vses_horafin`, @`vacad`, @`vcodsubseccion`, @`vdetalle`, @`vtipo`, @`vses_nrosesion`, @`s`);
				$rpta=$this->msesiones->m_agregar_sesion(array($txtfecha ,$txthoraini,$txthorafin,$txtcacad,$txtssec,$txtdetalle,$cbtiposesion,$txtnrosesion));
				if ($rpta>0){
					$dataex['status'] =true;
					$dataex['msg']="Se guardo Correctamente";
				}
			}
			header('Content-Type: application/x-json; charset=utf-8');
			echo(json_encode($dataex));
		}
	}

	/*public function f_agregar_sesion(){
		$dataex['status'] =false;
		$dataex['msg'] ='No se puede establecer el origen de la petición';
		if($this->input->is_ajax_request()){
			$this->form_validation->set_message('required', '%s Requerido');
			$urlRef=base_url();
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtdetalle','Detalle','trim|required');
			$this->form_validation->set_rules('txtfecha','Fecha','trim|required');
			$this->form_validation->set_rules('txthoraini','Hora Inicia','trim|required');
			$this->form_validation->set_rules('txthorafin','Hora fin','trim|required');
			$this->form_validation->set_rules('txtcacad','Carga','trim|required');
	
			$this->form_validation->set_rules('cbtiposesion','Tipo','trim|required');
			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{

				$dataex['msg']="Ocurrio un error al intentar agregar una sesión de clase";
				$txtdetalle=$this->input->post('txtdetalle');
				$txtfecha=$this->input->post('txtfecha');
				$txthoraini=$this->input->post('txthoraini');
				$txthorafin=$this->input->post('txthorafin');
				$txtcacad=$this->input->post('txtcacad');
	
				$cbtiposesion=$this->input->post('cbtiposesion');
				//@vses_fecha, @vses_horaini, @vses_horafin, @vacad, @vcodtema, @vdetalle, @vssec, @vcdoc
				$rpta=$this->msesiones->m_agregar_sesion(array($txtfecha ,$txthoraini,$txthorafin,$txtcacad,null,$txtdetalle,$cbtiposesion));
				if ($rpta>0){
					$dataex['status'] =true;
					$dataex['msg']="Se guardo Correctamente";
				}
			}
			header('Content-Type: application/x-json; charset=utf-8');
			echo(json_encode($dataex));
		}
	}*/

	public function f_editar_sesion(){
		$dataex['status'] =false;
		$dataex['msg'] ='No se puede establecer el origen de la petición';
		if($this->input->is_ajax_request()){
			$this->form_validation->set_message('required', '%s Requerido');
			$urlRef=base_url();
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fedittxtdetalle','Detalle','trim|required');
			$this->form_validation->set_rules('fedittxtfecha','Fecha','trim|required');
			$this->form_validation->set_rules('fedittxthoraini','Hora Inicia','trim|required');
			$this->form_validation->set_rules('fedittxthorafin','Hora fin','trim|required');
			$this->form_validation->set_rules('fedittxtsesid','Carga','trim|required');
			$this->form_validation->set_rules('fedittxtnrosesion','Nro Sesión','trim|required');
			//$this->form_validation->set_rules('txtcdoc','Docente','trim|required');
			$this->form_validation->set_rules('feditcbtiposesion','Tipo','trim|required');
			if ($this->form_validation->run() == FALSE){
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
				// $dataex['msg']=validation_errors();
			}
			else{

				$dataex['msg']="Ocurrio un error al intentar agregar una sesión de clase";
				$txtdetalle=$this->input->post('fedittxtdetalle');
				$txtfecha=$this->input->post('fedittxtfecha');
				$txthoraini=$this->input->post('fedittxthoraini');
				$txthorafin=$this->input->post('fedittxthorafin');
				$txtsesid=$this->input->post('fedittxtsesid');
				$txtnrosesion=$this->input->post('fedittxtnrosesion');
				/*$txtssec=$this->input->post('txtssec');
				$txtcdoc=$this->input->post('txtcdoc');*/
				$cbtiposesion=$this->input->post('feditcbtiposesion');
				//( @`vses_fecha`, @`vses_horaini`, @`vses_horafin`, @`vsesid`, @`vdetalle`, @`vtipo`, @`vses_nrosesion`, @`s`);
				$rpta=$this->msesiones->m_editar_sesion(array($txtfecha,$txthoraini,$txthorafin,$txtsesid,$txtdetalle,$cbtiposesion,$txtnrosesion));

				if ($rpta==1){
					$dataex['status'] =true;
					$dataex['msg']="Se guardo Correctamente";
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vw_curso_sesiones_duplicar()
    {
    	$dataex['status'] =false;
		$dataex['msg'] ='No se ha podido establecer el origen de esta solicitud.';
		if($this->input->is_ajax_request()){
			$this->form_validation->set_message('required', '%s Requerido');
			$this->form_validation->set_rules('sesion','Sesión','trim|required');
			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$txtdetalle=base64url_decode($this->input->post('sesion'));
				$rpta = $this->msesiones->m_sesion_x_id(array($txtdetalle));
				$dataex['vdata']  = $this->load->view('docentes/vw_curso_sesiones-agregar', null, true);
				$rpta->horaini = date("H:i", strtotime($rpta->horaini));
				$rpta->horafin = date("H:i", strtotime($rpta->horafin));
				$dataex['ses'] = $rpta;
				$dataex['status'] =true;
			}
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));

    }
    
	public function vw_curso_sesiones_editar(){
		$dataex['status'] =false;
		$dataex['msg'] ='No se ha podido establecer el origen de esta solicitud.';
		if($this->input->is_ajax_request()){
			$this->form_validation->set_message('required', '%s Requerido');
			$this->form_validation->set_rules('sesion','Sesión','trim|required');
			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$txtdetalle=base64url_decode($this->input->post('sesion'));
				//$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
				$rpta['ses']=$this->msesiones->m_sesion_x_id(array($txtdetalle));
				$rpta['ses']->horaini = date("H:i", strtotime($rpta['ses']->horaini));
				$rpta['ses']->horafin = date("H:i", strtotime($rpta['ses']->horafin));
				$dataex['vdata']=$this->load->view('docentes/vw_curso_sesiones-editar',$rpta,true);
				$dataex['status'] =true;
			}
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vw_curso_sesiones_agregar()
    {
        $dataex['status'] = false;
        $dataex['msg']    = 'No se ha podido establecer el origen de esta solicitud.';
        if ($this->input->is_ajax_request()) {
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
            $dataex['vdata']  = $this->load->view('docentes/vw_curso_sesiones-agregar', null, true);
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function feliminar(){
		$dataex['status'] =false;
		$dataex['msg'] ='No se ha podido establecer el origen de esta solicitud.';
		if($this->input->is_ajax_request()){
			$this->form_validation->set_message('required', '%s Requerido');
			$this->form_validation->set_rules('sesion','Sesión','trim|required');
			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$dataex['msg']='No se pudo eliminar la Sesión';
				$txtdetalle=base64url_decode($this->input->post('sesion'));
				//$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
				$rpta=$this->msesiones->m_eliminar_sesion(array($txtdetalle));
				if ($rpta==1){
					$dataex['status'] =true;
				}
				
			}
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}
	

	public function fn_crear_videoconferencia(){
		$dataex['status'] =false;
		$dataex['msg'] ='No se ha podido establecer el origen de esta solicitud.';
		if($this->input->is_ajax_request()){
			$this->form_validation->set_message('required', '%s Requerido');
			$this->form_validation->set_rules('txtsesion','Sesión','trim|required');
			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				date_default_timezone_set ('America/Lima');
				$fecha_actual = date("Y-m-d H:i");

				if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

					$dataex['msg']='Validación de campos superada';
					$vrequestid=$this->input->post('txtsesion');
					$vidsesion=base64url_decode($vrequestid);
					$vtitulo=$this->input->post('txttitulo');
					$vdescripcion=$this->input->post('txtdescripcion');
					$vfuera_tiempo = $this->input->post('txtfuetiempo');
					//$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
					

					$result = $this->db->query("SELECT  `ies_nombre` as nombre, `ies_gsuite_cid` as cid, `ies_gsuite_akey` as akey, `ies_gsuite_csc` as csc FROM `tb_institucion` LIMIT 1" );
	    			$gsuite=$result->row();

			        require_once APPPATH . "libraries/google-api-php-client-2.2.2/vendor/autoload.php";
			        include_once APPPATH . "libraries/google-api-php-client-2.2.2/src/Google/Client.php";
			        include_once APPPATH . "libraries/google-api-php-client-2.2.2/src/Google/Service/OAuth2.php";
			        $client_id      = base64_decode($gsuite->cid);
			        $client_secret  =  base64_decode($gsuite->csc);
			        $redirect_uri   = base_url().'iniciar-con-google';
			        $simple_api_key = base64_decode($gsuite->akey);
			        // Create Client Request to access Google API
			        $client = new Google_Client();
			        $client->setApplicationName("ERP ".$gsuite->nombre);
			        $client->setClientId($client_id);
			        $client->setClientSecret($client_secret);
			        $client->setRedirectUri($redirect_uri);
			        $client->setDeveloperKey($simple_api_key);

					$dom=getDominio();
			        $client->setHostedDomain($dom);
			        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
			        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
			        $client->addScope("https://www.googleapis.com/auth/calendar");
			        $client->addScope("https://www.googleapis.com/auth/calendar.events");
	    
					//Google_Service_Calendar  Google_Service_Oauth2
			        // Send Client Request
			        $objOAuthService = new Google_Service_Oauth2($client);
			        // Add Access Token to Session
			        $dataex['msg']='Iniciando Proceso';
			        if (isset($_GET['code'])) {
			            //PRIMERA VEZ
			            $dataex['msg']='no ha inicado sesión';
			            $client->authenticate($_GET['code']);
			            $_SESSION['access_token'] = $client->getAccessToken();
			            //header('Location: ' . filter_var(base_url(), FILTER_SANITIZE_URL));
			            $client->setAccessToken($_SESSION['access_token']);
			        }
			        // Set Access Token to make Request
			        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			            $client->setAccessToken($_SESSION['access_token']);
			            $dataex['msg']='Sesión Iniciada';
			        }
			        // Get User Data from Google and store them in $data
			        if ($client->getAccessToken()) {
			        	$dataex['msg']='Validación de sesión superada';
			        	$service = new Google_Service_Calendar($client);
			        	$userData = $objOAuthService->userinfo->get();

			            $data['userData'] = $userData;
			            $mail             = $userData->email;
			            $userfoto         = $userData->picture;
			            $domain           = substr($mail, strpos($mail, '@'));
			            
			            //if ($domain == "@".$dom) {
			            	$dataex['msg']='Validación de dominio superda';
			                $_SESSION['access_token'] = $client->getAccessToken();

				        	$sesion=$this->msesiones->m_sesion_videoconferiencia_x_id(array($vidsesion));

				        	$validfecha = false;
				        	$hini = new DateTime($sesion->horaini);
							$hfin = new DateTime($sesion->horafin);
							$vhorai = $hini->format('H:i');
							$vhoraf = $hfin->format('H:i');
							$fecha_sesioni = $sesion->fecha.' '.$vhorai;
							$fecha_sesionf = $sesion->fecha.' '.$vhoraf;

							//$fecha_sesioni = strtotime($sesion->fecha.' '.$vhorai);
							//$fecha_sesionf = strtotime($sesion->fecha.' '.$vhoraf);

							if ($fecha_actual <= $fecha_sesioni) {
								$validfecha = true;
							} else {
								if ($fecha_actual < $fecha_sesionf) {
									$validfecha = true;
								} else {
									$validfecha = false;
								}

								
							}

							if ($validfecha == true) {
								
					        	$codcarga = base64url_decode($this->input->post('txtcarga'));
					        	$division = base64url_decode($this->input->post('txtdivision'));
					        	$miembros = $this->mmiembros->m_get_miembros_por_carga_division(array($codcarga,$division));
					        	$arraymiembros_mail=array();
					        	foreach ($miembros as $key => $value) {
					        		$arraymiembros_mail[]= array('email' => $value->einstitucional);
					        	}
					        	$dataex['msg2']= $arraymiembros_mail;
					        	if (isset($sesion->id)){
					        		$dataex['msg']='Validación de id Sesión superada';
									//'2021-04-27T17:00:00-07:00'
									if ($vfuera_tiempo == 'NO') {
										$vinicia=$sesion->fecha."T".$sesion->horaini."-05:00";//DateTime::createFromFormat("AAAA-MM-DDTHH:MM:SS.MMMZ" , $vfini);
										//var_dump($vfini);
										//var_dump($vinicia);
										$vfin=$sesion->fecha."T".$sesion->horafin."-05:00";//DateTime::createFromFormat("AAAA-MM-DDTHH: MM: SS.MMMZ" , "$sesion->fecha $sesion->horaini");
									} else {
										date_default_timezone_set ('America/Lima');
										$hora = strtotime('+5 minutes');
										$hora_actual = date("H:i", $hora);

										$vinicia=$sesion->fecha."T".$hora_actual.":00-05:00";
										$vfin=$sesion->fecha."T".$sesion->horafin."-05:00";
									}
									
									$videvento=$sesion->idevento;
									$vidconferencia=$sesion->idconferencia;
									$vhalink=$sesion->halink;
									$vstatus_evento=$sesion->status_evento;
									$vstatus_conferencia=$sesion->status_conferencia;

									if ($videvento!=""){ //SI HAY EVENTO CREADO
										$dataex['msg']='Si hay evento';
										if ($vstatus_evento=="confirmed"){
											if ($vidconferencia!=""){
												if ($vstatus_conferencia=="success"){
											
												}
												else{
													//
												}
											}
											else{
												//
											}
										}
										else{
											
										}
									}
									else{ //NO HAY EVENTO CREADO

										$dataex['msg']='No hay evento, generando';
										$parametros = array('sendNotifications' => true, 'maxAttendees'=>100, 'conferenceDataVersion'=>1);
					                	$event = new Google_Service_Calendar_Event(array(
										  'summary' => $vtitulo,
										  'description' => $vdescripcion,
										  'start' => array(
										    'dateTime' => $vinicia,
										    'timeZone' => 'America/Lima',
										  ),
										  'end' => array(
										    'dateTime' => $vfin,
										    'timeZone' => 'America/Lima',
										  ),
										  'conferenceData' =>  array(
										  	'createRequest' =>  array('requestId' => $vrequestid),
										  ),

										  'attendees' => $arraymiembros_mail,
										  'sendUpdates'=>'all',
										  'reminders' => array(
										    'useDefault' => FALSE,
										    'overrides' => array(
										      array('method' => 'email', 'minutes' => 15),
										      array('method' => 'popup', 'minutes' => 10),
										    ),
										  ),
										));
					                	$dataex['msg']='Se creo el Objeto';
										$calendarId = $mail;//'primary';
										$event = $service->events->insert($calendarId, $event,$parametros);
										$dataex['msg']='no se';
										$videvento=$event->id;
										$vstatus_evento=$event->status;
										$vidconferencia=$event->conferenceData->conferenceId;							
										$vhalink=$event->hangoutLink;
										
										$vstatus_conferencia=$event->conferenceData->createRequest->status->statusCode;
										$rptaev=$this->msesiones->m_update_sesion_evento(array($videvento,$vidconferencia,$vhalink,$vstatus_evento,$vstatus_conferencia,$vidsesion));
										if ($rptaev->salida=="1"){
											$dataex['status'] =true;
											$dataex['link'] =$vhalink;
										}									
									}
								}
							} else {
								$dataex['status'] = false;
								$dataex['msg'] = 'La fecha y hora de inicio designada ya pasó';
							}
						//}
			            
			        } 
			        else {
			            /*$authUrl         = $client->createAuthUrl();
			            $data['authUrl'] = $authUrl;
			            redirect($authUrl, 'refresh');*/
			        }
			    } else {
			    	$dataex['status'] = false;
			    	$dataex['msg'] ='Para crear el enlace debera de iniciar sesion con su correo institucional';
			    }

			}
			
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

    

    public function fn_upload_file_sesion(){
        $dataex['status'] = false;
        $dataex['msg'] = 'Sin Archivo';
        $vrequestid=$this->input->get('txtsesion');
        $vidsesion=base64url_decode($vrequestid);
        $existfile = $this->input->get('rutafile');
        $directorio = "./upload/docweb/" . $existfile;
        if ($existfile != "") {
        	if (file_exists($directorio)) {
				$pathtodir =  getcwd() ;
				unlink($pathtodir."/upload/docweb/" . $existfile);
			}

			if ($_FILES['vw_mpc_file']['name']) {
	            if (!$_FILES['vw_mpc_file']['error']) {
	                $name = $_FILES['vw_mpc_file']['name'];//md5(Rand(100, 200));
	                $ext = explode('.', $_FILES['vw_mpc_file']['name']);
	                $ult=count($ext);
	                $nro_rand=rand(0,9);
	                $nro_rand2=rand(0,100);
	                $NewfileName  = "fls_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$nro_rand2;
	                $filename = $NewfileName.".".$ext[$ult-1];//. '.' . $ext[1];
	                
	                $destination = './upload/docweb/' .$filename ; //change this directory
	                $location = $_FILES["vw_mpc_file"]["tmp_name"];
	                $pesofile = $_FILES["vw_mpc_file"]["size"];
			        $typefile = $_FILES["vw_mpc_file"]["type"];
	                move_uploaded_file($location, $destination);
	                
	                $dataex['msg'] = 'Archivo subido correctamente';
	                $dataex['link'] = $filename;
	                $dataex['status'] = true;
	                $dataex['codigo'] = $vrequestid;

	                
	            }
	            else {
	                $dataex['msg'] = 'Se ha producido el siguiente error:  '.$_FILES['vw_mpc_file']['error'];
	            }
	        }

	        $rpta=$this->msesiones->m_editar_file(array($vidsesion,$name,$pesofile,$typefile,$filename));

			if ($rpta==1){
				$dataex['status'] =true;
				$dataex['msg']="Se guardo Correctamente";
				$dataex['filedata'] = getIcono('P',$filename).' '.$name .' ('.formatBytes($pesofile).')';
				$dataex['namefile'] = $filename;
				$dataex['rutafile'] = base_url().'upload/docweb/'.$filename;
			}

        } else {
        	if ($_FILES['vw_mpc_file']['name']) {
				if (!$_FILES['vw_mpc_file']['error']) {
					$name = $_FILES['vw_mpc_file']['name'];//md5(Rand(100, 200));
	                $ext = explode('.', $_FILES['vw_mpc_file']['name']);
	                $ult=count($ext);
	                $nro_rand=rand(0,9);
	                $nro_rand2=rand(0,100);
	                $NewfileName  = "fls_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$nro_rand2;
	                $filename = $NewfileName.".".$ext[$ult-1];//. '.' . $ext[1];
	                
	                $destination = './upload/docweb/' .$filename ; //change this directory
	                $location = $_FILES["vw_mpc_file"]["tmp_name"];
	                $pesofile = $_FILES["vw_mpc_file"]["size"];
	                $typefile = $_FILES["vw_mpc_file"]["type"];
	                move_uploaded_file($location, $destination);
				} else {
					$dataex['msg'] = 'Se ha producido el siguiente error:  '.$_FILES['vw_mpc_file']['error'];
				}
			}

			$rpta=$this->msesiones->m_editar_file(array($vidsesion,$name,$pesofile,$typefile,$filename));

			if ($rpta==1){
				$dataex['status'] =true;
				$dataex['msg']="Se guardo Correctamente";
				$dataex['filedata'] = getIcono('P',$filename).' '.$name .' ('.formatBytes($pesofile).')';
				$dataex['namefile'] = $filename;
				$dataex['rutafile'] = base_url().'upload/docweb/'.$filename;
			}
        }
        
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_curso_sesiones_asistencias()
    {
    	$dataex['status'] =false;
		$dataex['msg'] ='No se puede establecer el origen de la petición';
		if($this->input->is_ajax_request()){
			$this->form_validation->set_message('required', '%s Requerido');
			$urlRef=base_url();
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('sesion','sesión','trim|required');
			$this->form_validation->set_rules('carga','carga','trim|required');
			$this->form_validation->set_rules('division','division','trim|required');
			$this->form_validation->set_rules('unidad','unidad','trim|required');
			
			if ($this->form_validation->run() == FALSE){
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
				// $dataex['msg']=validation_errors();
			}
			else{
				date_default_timezone_set('America/Lima');
				$dataex['msg']="Ocurrio un error al intentar agregar una sesión de clase";

				$txtsesion = base64url_decode($this->input->post('sesion'));
				$txtcarga = base64url_decode($this->input->post('carga'));
				$txtdivision = base64url_decode($this->input->post('division'));
				$txtunidad = base64url_decode($this->input->post('unidad'));

				$facceso = date("Y-m-d H:i:s");
				$anombres = $_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres;
				$tipo = $_SESSION['userActivo']->tipo;
				$codigo = $_SESSION['userActivo']->codentidad;

				if (($tipo == "DC") || ($tipo == "AD") || ($tipo == "DA")) {
					$rpta=$this->msesiones->m_Inser_sesion_asistencia(array($txtsesion ,$codigo,null,$anombres,$txtunidad,$txtcarga,$txtdivision,$tipo,$facceso));
				} else {
					$rpta=$this->msesiones->m_Inser_sesion_asistencia(array($txtsesion ,null,$codigo,$anombres,$txtunidad,$txtcarga,$txtdivision,$tipo,$facceso));
				}

				
				if ($rpta->salida > 0){
					$dataex['status'] =true;
					$dataex['msg']="Se guardo Correctamente";
				}
			}

			header('Content-Type: application/x-json; charset=utf-8');
			echo(json_encode($dataex));
		}
		
    }


}

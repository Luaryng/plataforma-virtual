<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Sendmail.php';
class Incidencia extends Sendmail{

	function __construct(){
		parent::__construct();
		$this->load->helper("url"); 
		$this->load->model("mincidencias");
		
		
	}

	public function lstincidencia()
    {
    	$ahead= array('page_title' =>'Mis Incidencias | IESTWEB'  );
        $asidebar= array('menu_padre' =>'mn_tramites','menu_hijo' =>'mn_denuncia');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);
        $user = $_SESSION['userActivo']->idusuario;
        $dtsinc['incidencias'] = $this->mincidencias->m_dtsIncidenciaxid(array($user));
        $this->load->view('tramites/incidencias/ltsincidencia', $dtsinc);
        $this->load->view('footer');
    }
    public function lstincidencia_adm()
    {
    	
    	$ahead= array('page_title' =>'Incidencias | IESTWEB'  );
        $asidebar= array('menu_padre' =>'ltsincidencia');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);
        $user = $_SESSION['userActivo']->idusuario;
        if (getPermitido("85")=='SI'){
			$this->load->view('tramites/incidencias/vw_admin_principal');
		}
        else{
            $this->load->view('errors/sin-permisos');   
        }

        
        $this->load->view('footer');
    }

	public function index()
	{
		$ahead= array('page_title' =>'Incidencia | IESTWEB'  );
        $asidebar= array('menu_padre' =>'mn_tramites','menu_hijo' =>'mn_denuncia');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);
        $this->load->model("musuario");
        $aview = $this->musuario->m_perfil($_SESSION['userActivo']->codpersona);
        $this->load->view('tramites/incidencias/frm_incidencia',$aview);
        $this->load->view('footer');
	}

	public function fn_insert_propio()
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
			
			/*$this->form_validation->set_rules('txtapenombres','Apellidos y nombres','trim|required');
			$this->form_validation->set_rules('txtdni','N° documento','trim|required');
			$this->form_validation->set_rules('txtdomicilio','Domicilio','trim|required');
			$this->form_validation->set_rules('txtdistrito','Distrito','trim|required');
			$this->form_validation->set_rules('txtincidencia','Incidencia','trim|required');*/
			$this->form_validation->set_rules('vw_ric_txt_detalle','Detalle incidencia','trim|required');
			$this->form_validation->set_rules('vw_ric_txt_denunciado','Denunciado','trim|required');

			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
		        $dataex['msg_detalle']= validation_errors();
			}
			else
			{
				$dataex['status'] =FALSE;
				$user = $_SESSION['userActivo']->idusuario;
				$apellidos = $_SESSION['userActivo']->paterno.' '.$_SESSION['userActivo']->materno.' '.$_SESSION['userActivo']->nombres;
				$documento = $_SESSION['userActivo']->nrodoc;
				$tipodoc = 	$_SESSION['userActivo']->tipodoc;
				$domicilio = $this->input->post('vw_ric_txt_domicilio');
				$distrito = $this->input->post('vw_ric_txt_distrito');
				$incidencia = $this->input->post('vw_ric_txt_denunciado');
				$cargo = $this->input->post('vw_ric_txt_cargo');
				$detalle = $this->input->post('vw_ric_txt_detalle');
				$txtdecla = $this->input->post('vw_ric_txt_custodio');
				$data          = json_decode($_POST['vw_mpc_archivos']);

				//var user = "<?php echo $_SESSION['userActivo']->ecorporativo;
				$rpta = $this->mincidencias->insert_datos_incidencia(array($user, $apellidos, $documento, $domicilio, $distrito, $incidencia, $detalle, $txtdecla,$cargo,$tipodoc));
				if ($rpta->salida=="1"){
					$pathtodir =  getcwd() ; 
					$allfiles=true;
					$pruebas=array();
					$pruebas_email=array();
					foreach ($data as $key => $fl) {
						/*[data.link0
						,$('#vw_mpc_txt_filename').html(),1
						$('#vw_mpc_txt_size').html(),2
						$('#vw_mpc_txt_type').html(),3
						$('#vw_mpc_txt_titulo').val()]4*/
						// @vinc_id, @vincp_titulo, @vincp_link, @vincp_archivo, @vincp_peso, @vincp_tipo
						$rptafil = $this->mincidencias->insert_pruebas_incidencia(array($rpta->nid,$fl[4],$fl[0],$fl[1],$fl[2],$fl[3]));
						
						if ($rptafil=="1"){
							
							$link=$fl[0];
		                    $copied = copy($pathtodir."/upload/tramites/tmp/".$link  , $pathtodir."/upload/tramites/".$link);
		                    $a_ppdf = new stdClass;
		                    $pruebas[]=$a_ppdf;
							$pruebas_email[]=array($pathtodir."/upload/tramites/".$link, 'attachment',$fl[1]);
							$a_ppdf->titulo=$fl[4];
							
							if ((!$copied)) 
							{ 
							    $allfiles=false;
							}

						}
					}
					if ($allfiles==true){


						
						$a_pdf = new stdClass;
						
						$a_pdf->id=$rpta->nid;
			            $a_pdf->usuario=$user;
			            $a_pdf->nombres=$apellidos;
			            $a_pdf->documento=$documento;
			            $a_pdf->tipodoc=$tipodoc;
			            $a_pdf->domicilio=$domicilio;
			            $a_pdf->distrito=$distrito;
			            $a_pdf->asunto=$incidencia;
			            $a_pdf->detalle=$detalle;
			            $a_pdf->declara=$txtdecla;
			            $a_pdf->estado="";
			            $a_pdf->fecha=date("Y-m-d H:i:s"); 
			           
			            $this->load->model('miestp');
        				$iestp=$this->miestp->m_get_datos();
						$arrayinc['incidencia'] = $a_pdf;
						$arrayinc['ies'] = $iestp;
						$arrayinc['pruebas'] = $pruebas;

						
				        $htmlnt      = $this->load->view('tramites/incidencias/pdf_formato', $arrayinc,true);

				        $pdfFilePath = "INCIDENCIA IESTWEB" . ".pdf";
				        $this->load->library('M_pdf');
				        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
				        $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.2,array(50, 80),'P');
				        $mpdf->showWatermarkImage = true;
				        
				        $mpdf->WriteHTML($htmlnt);
				        $pdfdoc = $mpdf->Output('','S');
				        $idceros=str_pad($rpta->nid, 4, "0", STR_PAD_LEFT);
				        $pruebas_email[]=array($pdfdoc, 'attachment',"Denuncia Nro".$idceros.".pdf","application/pdf");
				        /*==================================
						 FIN PDF A ENVIAR
						======================================*/
						//ENVIAR CONSTANCIA A ALUMNO
						$d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
						//$d_destino=array($_SESSION['userActivo']->ecorporativo,"janiorjimenezh@gmail.com");
						$d_destino=array($_SESSION['userActivo']->ecorporativo,$iestp->email);
						$d_asunto="Denuncia  Nro: DN".$idceros." reportada con éxito";
						$d_mensaje=$this->load->view('emails/vw_notificar_denuncia', array('incidencia' => $a_pdf,'ies'=> $iestp ),true);
						$r_respondera=array($_SESSION['userActivo']->ecorporativo,$apellidos);
						
						
						 //fsendmail_adjunta($correo_destino,$asunto,$correo_envia,$nombre_envia,$mensaje,$adjunto)
						// $enviador = array($vuser->ecorporativo,$vuser->paterno." ".$vuser->materno." ".$vuser->nombres);
						//$rsp_denunciante=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email);
						//sleep(5);
						$rsp_iesap=$this->f_sendmail_adjuntos($d_enviador,$d_destino,$d_asunto,$d_mensaje,$pruebas_email,$r_respondera);
						foreach ($data as $key => $fl) {
							$link=$fl[0];
							unlink($pathtodir."/upload/tramites/tmp/".$link );
						}
						$dataex['msg']="Su reporte fue enviado correctamente";
					    $dataex['status'] =true;
					    $dataex['linkpdf']=base_url()."tramites/incidencia/constancia-pdf?cinc=".base64url_encode($rpta->nid);
					    
					    $dataex['rsm_iesap']=$rsp_iesap;
					}
					else{
						$dataex['msg']="Ocurio un error, comuniquese con el administrador";
						$dataex['status'] =false;
						$dataex['linkpdf']="";
					}

				}



				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	 public function fn_upload_file_logeado(){
        if ($_FILES['vw_mpc_file']['name']) {
            if (!$_FILES['vw_mpc_file']['error']) {
                $name = $_FILES['vw_mpc_file']['name'];//md5(Rand(100, 200));
                $ext = explode('.', $_FILES['vw_mpc_file']['name']);
                $ult=count($ext);
                $nro_rand=rand(0,9);
                $NewfileName  = "in_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$_SESSION['userActivo']->codpersona;
                $filename = $NewfileName.".".$ext[$ult-1];//. '.' . $ext[1];
                
                $destination = './upload/tramites/tmp/' .$filename ; //change this directory
                $location = $_FILES["vw_mpc_file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                
                $dataex['msg'] = 'Archivo subido correctamente';
                $dataex['link'] = $filename;

                
            } 
            else {
                $dataex['msg'] = 'Se ha producido el siguiente error:  '.$_FILES['vw_mpc_file']['error'];
              
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    
	public function vwasignar_files(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');

		if($this->input->is_ajax_request()){
			
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$this->form_validation->set_rules('txtnro','cantidad','trim|required');

			if ($this->form_validation->run() == FALSE){
				$dataex['msg']=validation_errors();
			}
			else{
				$nrofiles = $this->input->post('txtnro');
				if ($nrofiles != "") {
					$dataex['status'] =true;
					$arrayinc['nrofiles'] = $nrofiles;
					$dataex['vdata']=$this->load->view('tramites/incidencias/add_files', $arrayinc, true);
				}
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function incidencia_pdf()
    {
        $codigo = base64url_decode($this->input->get('cinc'));
        
        $arrayinc    = $this->mincidencias->m_get_incidencia_pdf(array($codigo));
        $this->load->model('miestp');
		$iestp=$this->miestp->m_get_datos();
		$arrayinc['ies'] = $iestp;

        

        
        //$this->load->view('tramites/incidencias/pdf_formato', $arrayinc);
		$htmlnt      = $this->load->view('tramites/incidencias/pdf_formato', $arrayinc,true);
        $pdfFilePath = "INCIDENCIA IESTWEB" . ".pdf";
        $this->load->library('M_pdf');
        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
        $mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="33%">{DATE j-m-Y}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right;">My document</td>
    </tr>
</table>');
        $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.2,array(50, 80),'P');
        $mpdf->showWatermarkImage = true;

        
        $mpdf->WriteHTML($htmlnt);


        $mpdf->Output($pdfFilePath, "D");

    }

   

    public function vwmostrar_respuesta()
    {
    	$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo', 'trim|required|min_length[4]');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$txtcodigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			
			$arrayhs = $this->mincidencias->m_dtsIncid_respuesta(array($txtcodigo));

			if (@count($arrayhs)) {

				$dataex['rptadts'] = $arrayhs->respuesta;
			} else {

				$dataex['rptadts'] = '<div class="alert alert-info alert-dismissible"><i class="fas fa-info"></i> AÚN NO TIENE RESPUESTA SU DENUNCIA POR FAVOR ESPERE.</div>';
			}
			
		}
		
		

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }

    

    public function search_list()
    {
    	$busqueda = $this->input->post('txtapenombres');
		$fechaini = $this->input->post('txtfecha');
		$fechafin = $this->input->post('txtfechafin');
		$denunciado = $this->input->post('txtdenucniado');
		

		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		
		$dataex['msg']    = '¿Que Intentas?.';
		$rspreinsc = "";
		$dataex['conteo'] = 0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			if ($fechaini == "" && $fechafin == "" && $busqueda == "" && $denunciado=="") {
				/*$this->form_validation->set_rules('txtfecha','fecha inicial','trim|required');
        		$this->form_validation->set_rules('txtfechafin','fecha final','trim|required');
        		$this->form_validation->set_rules('txtapenombres','búsqueda','trim|required|min_length[4]');*/
        		$dataex['msg']="Ingrese un criterio de búsqueda";
			}
			else
			{
				if ($fechaini == "" && $fechafin == "") {
					/*$fechaini='1990-01-01 00:00:01';
					$fechafin=date("Y-m-d").' 23:59:59';*/
				}
				elseif ($fechaini == "") {
					$fechaini='1990-01-01 00:00:01';
					$fechafin=$fechafin.' 23:59:59';
				}
				else{
					$fechaini=$fechaini.' 00:00:01';
					$fechafin=date("Y-m-d").' 23:59:59';
				}
				
				$preinsc['historial'] = $this->mincidencias->m_dtsIncid_search(array('%'.$busqueda.'%',"%".$denunciado."%", $fechaini, $fechafin));
				
				$conteo = count($preinsc['historial']);
				if ($conteo > 0)
				{
					$dataex['conteo'] = $conteo;
					$rspreinsc = $this->load->view('tramites/incidencias/vw_admin_listar',$preinsc,TRUE);
				}
				else
				{
					$rspreinsc = $this->load->view('errors/sin-resultados',array(),TRUE);
				}
				$dataex['status'] = TRUE;
			}
		}

		$dataex['vdata'] = $rspreinsc;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }

    public function deta_incidencia($codigo)
    {
    	$ahead= array('page_title' =>'Detalle Incidencias | IESTWEB'  );
        $asidebar= array('menu_padre' =>'ltsincidencia','menu_hijo' =>'');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar,$asidebar);
        $dtsinc= $this->mincidencias->m_dtsIncidencia(array(base64url_decode($codigo)));
        $this->load->view('tramites/incidencias/vw_admin_detalle_incidencia', $dtsinc);
        $this->load->view('footer');
    }

    public function fn_updatestatus()
    {
    	$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin opciones</option>";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtstatus','estado','trim|required');
			$this->form_validation->set_rules('txtcodigo','codigo','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$estado = $this->input->post('txtstatus');
				$codigo = $this->input->post('txtcodigo');
				$rpta = $this->mincidencias->m_updatestatus(array($estado, $codigo));
				if ($rpta == 1) {
					$dataex['status'] =TRUE;
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }


   public function pdf_rp_dncs_general_xfiltro()
    {
    	$busqueda = $this->input->post('txtapenombres');
		$fechaini = $this->input->post('txtfecha');
		$fechafin = $this->input->post('txtfechafin');
		$denunciado = $this->input->post('txtdenucniado');
		

		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		
		$dataex['msg']    = '¿Que Intentas?.';
		$rspreinsc = "";

		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			if ($fechaini == "" && $fechafin == "" && $busqueda == "" && $denunciado=="") {
				/*$this->form_validation->set_rules('txtfecha','fecha inicial','trim|required');
        		$this->form_validation->set_rules('txtfechafin','fecha final','trim|required');
        		$this->form_validation->set_rules('txtapenombres','búsqueda','trim|required|min_length[4]');*/
        		$dataex['msg']="Ingrese un criterio de búsqueda";
			}
			else
			{
				if ($fechaini == "" && $fechafin == "") {
					/*$fechaini='1990-01-01 00:00:01';
					$fechafin=date("Y-m-d").' 23:59:59';*/
				}
				elseif ($fechaini == "") {
					$fechaini='1990-01-01 00:00:01';
					$fechafin=$fechafin.' 23:59:59';
				}
				else{
					$fechaini=$fechaini.' 00:00:01';
					$fechafin=date("Y-m-d").' 23:59:59';
				}
				
				$denuncias = $this->mincidencias->m_dtsIncid_search(array('%'.$busqueda.'%',$denunciado, $fechaini, $fechafin));
	
		        $this->load->model('miestp');
		        $ie=$this->miestp->m_get_datos();

		        ///$inscs=$this->mmatricula->m_get_matricula_pdf(array($codmatricula));
		        $html1=$this->load->view('tramites/incidencias/pdf_rp_dncs_registradas_xfiltro', array('ies' => $ie,'denuncias' => $denuncias),true);
		         $nro_rand=rand(0,9);
                $NewfileName  = "tmp_".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") ."-".$nro_rand.$_SESSION['userActivo']->codpersona;
		        $pdfFilePath = "RP-DENUNCIAS-REG-FILTRO-$NewfileName.pdf";

		        $this->load->library('M_pdf');
		        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
		        $mpdf->SetTitle( "REPORTE DE DENUNCIAS REGISTRADAS");
		        
		        $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.1,array(50,70),array(80,40));

		        $mpdf->showWatermarkImage  = true;

		        $mpdf->WriteHTML($html1);
		        $mpdf->Output("upload/tmp/".$pdfFilePath, "F");
		        $dataex['status'] = TRUE;
		        $dataex['ruta'] = $pdfFilePath;
		        }
		       


        }
        header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
        
    }

    //descarga_archivo($vfilename,$vfilepath,$vfiletype)

    public function fn_descarga_pdf()
    {
       	//$fileName= $this->input->get('fn');
       	$fileName= $this->input->get('fp');
	    if (file_exists("upload/tmp/".$fileName)){
	        header("Cache-Control: public");
	        header("Content-Description: File Transfer");
	        header("Content-Disposition: attachment; filename=$fileName");
	        header("Content-type:application/pdf");
	        header("Content-Transfer-Encoding: binary");
	        readfile("upload/tmp/".$fileName);
	        exit;
	    }
	    else{
	        header("Location: ".base_url()."no-encontrado");
	    }
       
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Documentos_pago extends Error_views{

	function __construct(){
		parent::__construct();
		$this->load->helper("url"); 
		$this->load->model("mdocumentos_pago");
		$this->load->model('mauditoria');
		$this->load->model('mfacturacion');
		//$this->load->library('pagination');
	}


    public function vw_virtual_archivos($id)
    {
        // $area=base64url_decode($area);
        $id=base64url_decode($id);
        $fila=$this->mdocumentos_pago->m_get_itemdoc(array($id));

        if (isset($fila->ruta)){
            $fileName = $fila->ruta;
            $filePath = 'upload/docpagos/'.$fileName;
            $partes_ruta = pathinfo($fila->ruta);

            $nombre=url_clear($fila->titulo).".".$partes_ruta['extension'];
            if(!empty($fileName) && file_exists($filePath)){
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$nombre");
                header("Content-Type: fila->tipo");
                header("Content-Transfer-Encoding: binary");
                readfile($filePath);
                exit;
            }
            else{
                header("Location: ".base_url()."no-encontrado");
            }
        }
        else{
            header("Location: ".base_url()."no-encontrado2");
        } 
    }

    public function vw_principal()
	{
		if ($_SESSION['userActivo']->codnivel!="3"){
			$ahead= array('page_title' =>'Documentos pagos | ERP'  );
			$asidebar= array('menu_padre' =>'mn_facturaerp');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$items=array();
			$rstdata['items'] = $this->mdocumentos_pago->m_get_itemsdocindex();
			$this->load->view('documentopagos/index', $rstdata);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function fn_search_data()
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
			
			$emision = $this->input->post('fictxtfecha_emision');
			$emisionf = $this->input->post('fictxtfecha_emisionf');
			$descripcion = $this->input->post('fictxtdescripcion');
			$horaini = '';
			$horafin = '';

			if ($emision != "" AND $emisionf != "") {
				$horaini = ' 00:00:01';
				$horafin = ' 23:59:59';
			}

			if ($descripcion == "") {
				$descripcion = '%%%%';
			}

			$rstdata = $this->mdocumentos_pago->m_get_itemdocsearch(array('%'.$descripcion.'%', $emision.$horaini, $emisionf.$horafin));
			if (@count($rstdata) > 0) {
                $dataex['status'] = true;
                $rsdata['items'] = $rstdata;
                $datos = $this->load->view('documentopagos/result_data', $rsdata, true);
            } else {
            	$datos = $this->load->view('errors/sin-resultados',array(),TRUE);
            }
								
			
		}
		$dataex['vdata'] = $datos;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));

	}

	public function vw_agregar()
	{
		if ($_SESSION['userActivo']->codnivel=="0"){
			$ahead= array('page_title' =>'Documentos pagos - Agregar | ERP'  );
			$asidebar= array('menu_padre' =>'pagos');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$this->load->view('documentopagos/vw_agregar');
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function vw_editar($id)
    {
        
        
		if ($_SESSION['userActivo']->codnivel=="0"){
        	$id=base64url_decode($id);
			$ahead= array('page_title' =>'Documentos pagos - Editar | ERP'  );
			$asidebar= array('menu_padre' =>'pagos');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar',$asidebar);
			$fila['mat']=$this->mdocumentos_pago->m_get_itemdoc(array($id));
			
			$this->load->view('documentopagos/vw_agregar', $fila);
			$this->load->view('footer');
		}
		else{
			 $this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}


	 public function uploadfile(){
        $dataex['link']="";
        $fileTmpLoc   = $_FILES["file"]["tmp_name"]; // File in the PHP tmp folder
        $fileType     = $_FILES["file"]["type"]; // The type of file it is
        $fileSize     = $_FILES["file"]["size"]; // File size in bytes
        $fileErrorMsg = $_FILES["file"]["error"]; // 0 for false... and 1 for true
        $fileNameExt  = $_FILES["file"]["name"];
        $ext          = explode(".", $fileNameExt);
        $extension    = end($ext);
        $NewfileName  = "adp".date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . $_SESSION['userActivo']->codpersona;
        $arc_temp = pathinfo($fileTmpLoc);

        
        $nomb_temp=url_clear($arc_temp['filename']);
        $nro_rand=rand(0,9);
        $link=$NewfileName.$nomb_temp.$nro_rand.".".$extension;
        $dataex['link'] = "";
        $dataex['temp'] = "";
        $directorio = "./upload/docpagos";
	    if (!file_exists($directorio)) {

            mkdir($directorio, 0755);

        }
        if (move_uploaded_file($fileTmpLoc, "upload/docpagos/$link")) {
            $dataex['link'] = $link;
            $dataex['temp'] = $fileTmpLoc;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }


	public function uploadimages(){
		if ($_FILES['file']['name']) {
			if (!$_FILES['file']['error']) {
			    $name = md5(Rand(100, 200));
			    $ext = explode('.', $_FILES['file']['name']);
			    $filename = $name . '.' . $ext[1];
			    $destination = './resources/img/bolsa_trabajo/' . $filename; //change this directory
			    $location = $_FILES["file"]["tmp_name"];
			    move_uploaded_file($location, $destination);
			    echo 'resources/img/bolsa_trabajo/' . $filename;
			} else {
			  echo  $message = 'Se ha producido el siguiente error:  '.$_FILES['file']['error'];
			}
		}
	}

	public function delete_file()
    {
        $src = $this->input->post('src'); 
        // $src = $_POST['src']; 
        $file_name = str_replace(base_url(), '', $src); 
        // link de host para obtener la ruta relativa
        if(unlink($file_name)) { 
            echo 'imagen eliminada correctamente'; 
        }
    }

	public function fn_guardar()
	{
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{	
			if (getPermitido("56")=='SI'){

				$this->form_validation->set_message('required', '%s Requerido');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxttitulo','Título','trim|required');
				
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxtemision','fecha emisión','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxtimporte','importe','trim|required');
				$this->form_validation->set_rules('vw_pw_bt_ad_fictxtestado','Estado','trim|required');

				if ($this->form_validation->run() == FALSE)
				{ 
					$dataex['msg']="Existen errores en los campos";
					$dataex['errimg'] = 'No hay archivo seleccionado';
					$errors = array();
			        foreach ($this->input->post() as $key => $value){
			            $errors[$key] = form_error($key);
			        }
			        $dataex['errors'] = array_filter($errors);
				}
				else
				{
					$dataex['msg'] ='Ocurrio un error, intente nuevamente o comuniquese con un administrador.';
					
					$codigo= $this->input->post('vw_pw_bt_ad_fictxtcodigo');
					$titulo= $this->input->post('vw_pw_bt_ad_fictxttitulo');
					$descripcion=$this->input->post('vw_pw_bt_ad_fictxtdesc');
					$emision=$this->input->post('vw_pw_bt_ad_fictxtemision');
					$importe=$this->input->post('vw_pw_bt_ad_fictxtimporte');
					$estado=$this->input->post('vw_pw_bt_ad_fictxtestado');

					$datafile= json_decode($_POST['afiles']);
					$link="";
                    $name="";
                    $peso="";
                    $tipofile="";
                    $validar=false;
                    $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
                    foreach ($datafile as $value) {
                        if ($value[4]=="0"){ //si no hay id de detalle
                            if (trim($value[0])==""){
                                
                            }
                            else{
                                if (file_exists ("upload/docpagos/".$value[0])){
                                    $link=$value[0];
                                    $name=$value[1];
                                    $peso=$value[2];
                                    $tipofile=$value[3];
                                    $validar=true;
                                }
                            }    
                        }
                        else{
                        	$link=$value[0];
                            $name=$value[1];
                            $peso=$value[2];
                            $tipofile=$value[3];
                            $validar=true;
                        }
                    }
					date_default_timezone_set ('America/Lima');
					$rpta=0;
	        		
	        		if ($codigo=="0"){
	        			
	        			$rpta=$this->mdocumentos_pago->m_insert_doc(array($titulo, $descripcion, $link,$peso,$tipofile, $emision, $importe, $estado));
	        			$accion = "INSERTAR";
	        			$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está ingresando un documento en la tabla TB_ADMIN_DOC_PAGO COD.".$rpta->nid;
	        		}
	        		else{
	        			$accion = "EDITAR";
	        			$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está editando un documento en la tabla TB_ADMIN_DOC_PAGO COD.".base64url_decode($codigo);
	        			$rpta=$this->mdocumentos_pago->m_update_doc(array(base64url_decode($codigo),$titulo, $descripcion, $link,$peso,$tipofile, $emision, $importe, $estado));
	        		}
	        		
	        		if ($rpta->salida==1){
	        			$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
	        			$dataex['status'] =TRUE;
						$dataex['msg'] ="Datos registrados correctamente";
						$dataex['redirect'] =base_url()."documentos/pagos";
	        		}
	                
				}
			}
			else{
				$dataex['status'] =FALSE;
				$dataex['msg']    = 'No autorizado';
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_delete_file(){
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
            if ($_SESSION['userActivo']->tipo != 'AL'){
                
                $dataex['status'] = false;
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
                $codigo    = base64url_decode($this->input->post('codigo'));
                $this->mdocumentos_pago->m_update_delfiledoc(array($codigo));
                $dataex['status'] =true;
                if ("" !== $this->input->post('link')){
                    $link    = $this->input->post('link');
                    $pathtodir =  getcwd() ; 
                    if (file_exists($pathtodir."/upload/docpagos/".$link )) unlink($pathtodir."/upload/docpagos/".$link );
                }
            }
            else{
                $dataex['msg']    = 'No estas autorizado';
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_delete()
    {
        $dataex['msg'] = "Ey! ¿Que intentas?";
        $dataex['status'] =false;
        if ($this->input->is_ajax_request()) {
        	$dataex['msg'] = "Sin Permiso";
        	if ($_SESSION['userActivo']->codnivel=="0"){
	            if ($_SESSION['userActivo']->tipo != 'AL'){
	                
	                $dataex['status'] = false;
	                $urlRef           = base_url();
	                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';
	                $codigo    = base64url_decode($this->input->post('codigo'));
	                $usuario = $_SESSION['userActivo']->idusuario;
					$sede = $_SESSION['userActivo']->idsede;
					$accion = "ELIMINAR";
					$contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un documento en la tabla TB_ADMIN_DOC_PAGO COD.".$codigo;
	                
	                $fila=$this->mdocumentos_pago->m_get_itemdoc(array($codigo));
	                if (isset($fila->codigo)){
	                	$this->mdocumentos_pago->m_deletedoc(array($codigo));
	                	$dataex['status'] =true;
		                if ("" !== $fila->ruta){
		                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $accion, $contenido, $sede));
		                    $link    = $fila->ruta;
		                    $pathtodir =  getcwd() ; 
		                    if (file_exists($pathtodir."/upload/docpagos/".$link )) unlink($pathtodir."/upload/docpagos/".$link );
		                }
	                }
	                
	                
	            }
	           
	        }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    /*public function pdf_ficha_pagos($coddocpago)
    {

        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        $coddocpago=base64url_decode($coddocpago);
        //$carne=base64url_decode($carne);

        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();

        $pagos=$this->mdocumentos_pago->m_get_docpagos(array($coddocpago));
        $detalle = $this->mdocumentos_pago->m_get_pagos_detalle(array($coddocpago));
        $dtserie = $this->mfacturacion->m_get_docserie_boleta(array($_SESSION['userActivo']->idsede));


            $dominio=str_replace(".", "_",getDominio());
			
            $html1=$this->load->view('documentopagos/dc_fichapagos_'.$dominio, array('ies' => $ie,'pag' => $pagos,'detalle'=>$detalle, 'dserie'=>$dtserie ),true);
             
            $pdfFilePath = "DOCUMENTO PAGO ".$pagos->pagante.".pdf";

            $this->load->library('M_pdf');
            $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
            $mpdf->SetTitle( "DOCUMENTO PAGO ".$pagos->pagante);
            
            $mpdf->SetWatermarkImage(base_url().'resources/img/matriculado_'.$dominio.'.png',0.6,"D",array(70,35));

            $mpdf->showWatermarkImage  = true;
            

            //$mpdf->AddPage();
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath, "I");
            // $mpdf->Output();
        
    }

    public function ticket_ficha_pagos($coddocpago)
    {
    	$dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

        $coddocpago=base64url_decode($coddocpago);
        //$carne=base64url_decode($carne);

        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();

        $pagos=$this->mdocumentos_pago->m_get_docpagos(array($coddocpago));
        $detalle = $this->mdocumentos_pago->m_get_pagos_detalle(array($coddocpago));
        $dtserie = $this->mfacturacion->m_get_docserie_boleta(array($_SESSION['userActivo']->idsede));


            $dominio=str_replace(".", "_",getDominio());
            
            $html1=$this->load->view('documentopagos/dc_ticketpagos_'.$dominio, array('ies' => $ie,'pag' => $pagos,'detalle'=>$detalle, 'dserie'=>$dtserie ),true);
             
            $pdfFilePath = "TICKET PAGO ".$pagos->pagante.".pdf";

            $this->load->library('M_pdf');
            // $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [58, 80]]); 

            $mpdf->SetTitle( "TICKET PAGO ".$pagos->pagante);
            
            $mpdf->SetWatermarkImage(base_url().'resources/img/matriculado_'.$dominio.'.png',0.6,"D",array(70,35));

            $mpdf->showWatermarkImage  = true;
            

            //$mpdf->AddPage();
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath, "I");
            // $mpdf->Output();
        

    }*/
	

}
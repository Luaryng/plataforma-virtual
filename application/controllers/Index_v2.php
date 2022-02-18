<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends CI_Controller {
	private $ci;
	public function __construct()
    {
    	parent::__construct();
    	$this->ci=& get_instance();
        //$this->load->helper("url");
        //$this->load->library('form_validation');
        $this->load->model("mcomunicados");
    }

    public function refrescarsesion(){
        $acceso=(isset($_SESSION['islogin']))?$_SESSION['islogin']:NULL;
        if ($acceso==NULL){
           header('Location: ' . filter_var(base_url() . "iniciar-sesion?caduco=0&email", FILTER_SANITIZE_URL));
        }
    }

	public function index()
	{
		$ahead= array('page_title' =>'IESTWEB - Gestión Administrativa - Académica'  );
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
		$this->load->view($vsidebar);
		$items = $this->mcomunicados->m_get_items_publicados($_SESSION['userActivo']->idsede);
		$this->load->view('index', array('items' => $items ));
		$this->load->view('footer');
	}
	
	
	public function vw_facturacion()
	{
		$ahead= array('page_title' =>'Documentos de Pago | Plataforma Virtual '.$this->ci->config->item('erp_title')  );

		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$asidebar= array('menu_padre' =>'mn_facturaerp');
		$this->load->view("sidebar_facturacion",$asidebar);
		$this->load->model("mfacturacion");
		



		$rstdata = $this->mfacturacion->m_get_emitidos_limit_xsede(0,40,array($_SESSION['userActivo']->idsede),"%");
		$rstdata['mediosp'] = $this->mfacturacion->m_get_medios_pago();
		$rstdata['bancos'] = $this->mfacturacion->m_get_bancos();
		$rstdata['tipdoc'] = $this->mfacturacion->m_get_tiposdoc();
		$rstdata['unidad'] =$this->mfacturacion->m_get_unidades_habilitados();
		// $rstdata['items'] = $this->mfacturacion->m_get_emitidos_index(array($_SESSION['userActivo']->idsede));
		//$rstdata['numitems'] = count($this->mfacturacion->m_get_emitidos_index(array($_SESSION['userActivo']->idsede)));
		
		$this->load->view('facturacion/vw_documentos_pago', $rstdata);

		//$items = $this->mcomunicados->m_get_items();
		//$this->load->view('index', array('items' => $items ));
		$this->load->view('footer');
	}

	public function vw_mantenimiento()
	{
		$ahead= array('page_title' =>'Mantenimiento | Plataforma Virtual '.$this->ci->config->item('erp_title')  );
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view("sidebar_mantenimiento");
		//$items = $this->mcomunicados->m_get_items();
		//$this->load->view('index', array('items' => $items ));
		$this->load->view('footer');
	}

	public function vw_academico()
	{
		$ahead= array('page_title' =>'IESTWEB - Gestión Administrativa - Académica'  );
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view("sidebar_academico");
		//$items = $this->mcomunicados->m_get_items();
		//$this->load->view('index', array('items' => $items ));
		$this->load->view('footer');
	}

	public function index_tramites()
	{
		$ahead= array('page_title' =>'IESTWEB - Gestión Administrativa - Académica'  );
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		
		$asidebar = array('menu_padre' => 'mn_tramites');
        $this->load->view("sidebar", $asidebar);
		$this->load->view('tramites/vw_principal');
		$this->load->view('footer');
	}

	public function index_portal()
	{
		if ($_SESSION['userActivo']->tipo!=="AL"){
			$ahead= array('page_title' =>'Portal Web | Plataforma Virtual '.$this->ci->config->item('erp_title')  );
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			
			$this->load->view('sidebar_portal');
			//$this->load->view('index');
			$this->load->view('footer');
		}
		else{
			$ahead= array('page_title' =>"No Permitido | ERP"  );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
            $this->load->view($vsidebar);
            $this->load->view('errors/vwh_nopermitido');
            $this->load->view('footer');
		}
	}

	

	public function panel()
	{
		$ahead= array('page_title' =>'Plataforma Virtual | '.$this->ci->config->item('erp_title')  );
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$ahead);
		$this->load->view('mantenimiento-panel');
		$this->load->view('footer');
	}
	//vw_iniciar_sesion
	public function vw_iniciar_sesion()
	{
		$acceso=(isset($_SESSION['islogin']))?$_SESSION['islogin']:FALSE;
		if ($acceso===TRUE){
			redirect(base_url(),'refresh');
		}
		else{
			$ahead= array('page_title' =>'Plataforma Virtual '.$this->ci->config->item('erp_title')  );
			$result = $this->db->query("SELECT `ies_nombre` as nombre,ins_acceso_plataforma as plataforma  FROM `tb_institucion` LIMIT 1" );
			$this->load->view('head',$ahead);
			$this->load->view('login',array('inst' => $result->row() ));
		}
	}


	public function vw_iniciar_sesion_externo()
	{
		$acceso=(isset($_SESSION['islogin']))?$_SESSION['islogin']:FALSE;
		if ($acceso===TRUE){
			redirect(base_url(),'refresh');
		}
		else{
			$ahead= array('page_title' =>'Plataforma Virtual '.$this->ci->config->item('erp_title')  );
			$result = $this->db->query("SELECT `ies_nombre` as nombre,ins_acceso_plataforma as plataforma  FROM `tb_institucion` LIMIT 1" );
			$this->load->view('head',$ahead);
			$this->load->view('login_externo',array('inst' => $result->row() ));
		}
	}

	public function listar_recursos_virtual()
	{
		$dataex['status'] =FALSE;
		$this->load->model("mcalendario");
		$tipous = $_SESSION['userActivo']->tipo;
		$carne= $_SESSION['userActivo']->codentidad;
		$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");

		if ($tipous == "AL") {
			$vcargas = $this->mcalendario->m_get_cursos_visibles_x_ccarne(array($carne));
		} else {
			$vcargas = $this->mcalendario->m_get_subsecciones_visibles_x_cdocente(array($carne));
		}

		$arraycar = [];
		$arraydiv = [];
		$arraymiem = [];
		foreach ($vcargas as $key => $vcar) {
			$arraycar[] = $vcar->codcarga;
			$arraydiv[] = $vcar->division;
			if (isset($vcar->codmiembro))  $arraymiem[] = $vcar->codmiembro;
			
		}

		

		$varchivos = $this->mcalendario->m_get_vdetalles_calendario($arraycar,$arraydiv);
		$vmaterialother = $this->mcalendario->m_get_materiales_calendario_others_index($arraycar,$arraydiv,$arraymiem);
		$vmaterial = $this->mcalendario->m_get_materiales_calendario_index($arraycar,$arraydiv,$arraymiem);

		date_default_timezone_set('America/Lima');
		$eventos = [];
		$otherevent = [];
		$arr_arch=array();
		$txtdatefec = new DateTime(date('d-m-Y'));
		$fechasestext = $dias[$txtdatefec->format('w')].". ".$txtdatefec->format('d/m/Y');
		$fechases = $txtdatefec->format('Y-m-d');

		foreach ($varchivos as $karc => $arch) {
            $arr_arch[$arch->codmaterial][] = $arch;
        }
        unset($varchivos);

		

		foreach ($vmaterialother as $key => $virt) {
			date_default_timezone_set('America/Lima');
            $timelocal=time();
            $tmuestra="NO";
            $contarchivos="";
            if ($virt->v_time != NULL){
                $tmuestra=(strtotime($virt->v_time)<$timelocal) ?"SI":"NO";
            }

            if (($virt->visible == "Mostrar") || ($tmuestra == "SI")) {
            	if ($virt->tipo != "E") {
            		
	            	switch ($virt->tipo) {
	            		case 'A':
	            			if ($tipous == "AL") {
	            				$linkvirt = base_url()."alumno/curso/virtual/".base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->miembro);
	            			} else {
	            				$linkvirt = base_url()."curso/virtual/".base64url_encode($virt->carga).'/'.base64url_encode($virt->division);
	            			}

	            			$titulovirt = strip_tags($virt->nombre);
	            			$tipo = "ARCHIVO";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_file.png' alt='Archivo'>";
	            			$iconop = "<img style='width: 30px;height: 30px;' class='mr-1' src='".base_url()."resources/img/icons/p_file.png' alt='Archivo'>";
	            			break;
	            		case 'Y':
	            			$titulovirt=strip_tags($virt->nombre);
	            			$linkvirt="https://www.youtube.com/watch?v=$virt->link";
	            			$tipo = "VIDEO YOUTUBE";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_ytb.png' alt='Youtube'>";
	            			$iconop = "<img style='width: 30px;height: 30px;' class='mr-1' src='".base_url()."resources/img/icons/p_ytb.png' alt='Youtube'>";
	            			break;
	            		case 'L':
	            			$titulovirt=strip_tags($virt->nombre);
	            			$liknko=(strrpos($virt->link, "http")===false) ? 'https://': '';
	                        $linkvirt=$liknko.$virt->link;
	                        $tipo = "LINK";
	                        $icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_url.png' alt='URL'>";
	                        $iconop = "<img style='width: 30px;height: 30px;' class='mr-1' src='".base_url()."resources/img/icons/p_url.png' alt='URL'>";
	                        break;
	                    default:
	                        # code...

	            	}

	            	$idv = $virt->codigo;
					$titulov = $titulovirt;
					$startv = ($virt->inicia != null) ? $virt->inicia : $virt->creacion;
					$endv = ($virt->vence != null) ? $virt->vence : "";
					$linkv = $linkvirt;

					$dateother =  new DateTime($startv);
					$fother= $dias[$dateother->format('w')].". ".$dateother->format('d/m/Y h:i a');
            		// $fother = $dateother->format('d/m/Y h:i a');

					$otherevent[] = [
						"<li class='item'>
							<div class='product-img'>
								$iconop
							</div>
							<div class='product-info'>
								<a href='$linkv' class='text-dark product-title'> 
									$titulovirt
								</a>
								$contarchivos
								<span class='product-description'>
		                        	$fother
		                      	</span>
							</div>
						</li>"
					];

	            }
            }
			
		}

		foreach ($vmaterial as $key => $virt) {
			date_default_timezone_set('America/Lima');
            $timelocal=time();
            $tmuestra="NO";
            
            if ($virt->v_time != NULL){
                $tmuestra=(strtotime($virt->v_time)<$timelocal) ?"SI":"NO";
            }

            if (($virt->visible == "Mostrar") || ($tmuestra == "SI")) {
            	if ($virt->tipo != "E") {
            		
	            	switch ($virt->tipo) {
	            		case 'T':
	            			if ($tipous == "AL") {
	            				$linkvirt=base_url().'alumno/curso/virtual/tarea/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo).'/'.base64url_encode($virt->miembro);
	            			} else {
	            				$linkvirt=base_url().'curso/virtual/tarea/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo);
	            			}

	            			$titulovirt=strip_tags($virt->nombre);
	            			$tipo = "TAREA";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
	            			$iconop = "<img style='width: 30px;height: 30px;' class='mr-1' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
	            			break;
	            		case 'F':
	            			if ($tipous == "AL") {
	            				$linkvirt = base_url().'alumno/curso/virtual/foro-virtual/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo).'/'.base64url_encode($virt->miembro);
	            			} else {
	            				$linkvirt = base_url().'curso/virtual/foro/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo);
	            			}

	            			$titulovirt=strip_tags($virt->nombre);
	            			$tipo = "FORO";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_foro.png' alt='TAREA'>";
	            			$iconop = "<img style='width: 30px;height: 30px;' class='mr-1' src='".base_url()."resources/img/icons/p_foro.png' alt='FORO'>";
	            			break;
	            		case 'V':
	            			if ($tipous == "AL") {
	            				$linkvirt=base_url().'alumno/curso/virtual/evaluacion/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo).'/'.base64url_encode($virt->miembro);
	            			} else {
								$linkvirt=base_url().'curso/virtual/evaluacion/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo);
	            			}

	            			$titulovirt=strip_tags($virt->nombre);
	            			$tipo = "EVALUACIÓN";
	            			$icono = "<img class='mr-1'  src='".base_url()."resources/img/icons/p_cuestionario.png' alt='EVALUACIÓN'>";
	            			$iconop = "<img style='width: 30px;height: 30px;' class='mr-1'  src='".base_url()."resources/img/icons/p_cuestionario.png' alt='EVALUACIÓN'>";
	            			break;
	                    default:
	                        # code...

	            	}

	            	$idv = $virt->codigo;
					$titulov = $titulovirt;
					$startv = ($virt->inicia != null) ? $virt->inicia : $virt->creacion;
					$endv = ($virt->vence != null) ? $virt->vence : "";
					$linkv = $linkvirt;

					if ($virt->inicia != null) {
						$fechavirt = $virt->inicia;
					} elseif ($virt->vence != null) {
						$fechavirt = $virt->vence;
					} else {
						$fechavirt = $virt->creacion;
					}

					$dateother =  new DateTime($fechavirt);
					$fother= $dias[$dateother->format('w')].". ".$dateother->format('d/m/Y h:i a');

            		// $fother = $dateother->format('d/m/Y h:i a');
					
					$eventos[] = [
						"<li class='item'>
							<div class='product-img'>
								$iconop
							</div>
							<div class='product-info'>
								<a href='$linkv' class='text-dark product-title'> 
									$titulovirt
								</a>
								<span class='product-description'>
		                        	$fother
		                      	</span>
							</div>
						</li>"
					];

	            }
            }
			
		}
		if (count($eventos) > 0) {
			$dataex['eventos'] = $eventos;
		} else {
			$dataex['eventos'] = "<li class='item'>Sin eventos para mostrar</li>";
		}

		if (count($otherevent) > 0) {
			$dataex['otherevent'] = $otherevent;
		} else {
			$dataex['otherevent'] = "<li class='item'>Sin eventos para mostrar</li>";
		}

		$dataex['sesfechatext'] = $fechasestext;
		$dataex['sesfecha'] = $fechases;
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
		
	}

	public function listar_recursos_sesiones()
	{
		date_default_timezone_set('America/Lima');
		$dataex['status'] =FALSE;
		$this->load->model("mcalendario");
		$tipous = $_SESSION['userActivo']->tipo;
		$carne= $_SESSION['userActivo']->codentidad;
		$page_num = $this->input->post('eventos');
		$txtfecha = $this->input->post('fecha');
		$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");

		if ($tipous == "AL") {
			$vcargas = $this->mcalendario->m_get_cursos_visibles_x_ccarne(array($carne));
		} else {
			$vcargas = $this->mcalendario->m_get_subsecciones_visibles_x_cdocente(array($carne));
		}

		$arraycar = [];
		$arraydiv = [];
		$arraymiem = [];
		$sesiones = [];
		

		$txtdatefec = new DateTime($txtfecha);
		$dataex['s']=$txtdatefec ;
		if ($page_num == "left") {
			$datefecha = date("d-m-Y",strtotime($txtdatefec->format('d-m-Y')."- 1 days"));
		} 
		elseif ($page_num == "right"){
			$datefecha = date("d-m-Y",strtotime($txtdatefec->format('d-m-Y')."+ 1 days"));
		}
		else {
			$datefecha = date("d-m-Y",strtotime($txtdatefec->format('d-m-Y')));
		}
		$dataex['s2']=$datefecha ;
		$sesdate = new DateTime($datefecha);
		$dataex['s3']=$sesdate ;
		$fechasestext = $dias[$sesdate->format('w')].". ".$sesdate->format('d/m/Y');
		$fechases = $sesdate->format('Y-m-d');

		foreach ($vcargas as $key => $vcar) {
			$arraycar[] = $vcar->codcarga;
			$arraydiv[] = $vcar->division;
			if (isset($vcar->codmiembro))  $arraymiem[] = $vcar->codmiembro;
			
		}

		$vsesiones = $this->mcalendario->m_sesiones_completos_x_fecha_index($arraycar,$arraydiv,array($page_num, $txtfecha));
		$sesiones="";
		foreach ($vsesiones as $key => $value) {

			$link = ($value->hlink != null) ?  $value->hlink : "#";
			$casist = ($value->hlink != null) ?  "btn_ses_asist" : "";

			$dateses =  new DateTime($value->fecha." ".$value->hini);
			$datesesfin =  new DateTime($value->fecha." ".$value->hfin);

			$fsesion= $dateses->format('h:i a')." - ".$datesesfin->format('h:i a');
			$fechasestext = $dias[$dateses->format('w')].". ".$dateses->format('d/m/Y');
			$strike_open="";
			$strike_close="";
			if ($datesesfin< new DateTime()){
				$strike_open="<strike>";
				$strike_close="</strike>";
				$link = "#";
				$casist = "";
			}
			$sesiones =$sesiones."

					<div class='col-12 border-bottom text-1em py-2'>
						<div class='float-left position-absolute mr-1'>
	                        <i class='fas fa-video text-primary'></i>
	                    </div> 
	                    <div class='col-12  pl-2 ml-1 pr-0'>
	                    	<div class='col-12 pr-0'>
								$strike_open 
								<a class=' text-bold $casist' data-link='$link' href='#'  data-sesion='".base64url_encode($value->id)."' data-carga='".base64url_encode($value->codcarga)."' data-division='".base64url_encode($value->division)."' data-unidad='".base64url_encode($value->codunidad)."'> 
									$value->unidad 
								</a>
								$strike_close 
							</div> 
							<div class='col-12'>
	                        	$fsesion
	                      	</div> 
                      	</div>
					</div>";
			
		}

		$dataex['sesiones'] = $sesiones;
		$dataex['sesfechatext'] = $fechasestext;
		$dataex['sesfecha'] = $fechases;
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}
	
	
}


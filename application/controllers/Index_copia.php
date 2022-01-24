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
        $this->load->model("mcalendario");
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

	public function listar_recursos_virtual()
	{
		$dataex['status'] =FALSE;
		$tipo = $_SESSION['userActivo']->tipo;
		$carne= $_SESSION['userActivo']->codentidad;
		$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");

		if ($tipo == "AL") {
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

		$vsesiones = $this->mcalendario->m_sesiones_completos_x_unidad_index($arraycar,$arraydiv);

		$varchivos = $this->mcalendario->m_get_vdetalles_calendario($arraycar,$arraydiv);
		$vmaterialother = $this->mcalendario->m_get_materiales_calendario_others_index($arraycar,$arraydiv,$arraymiem);
		$vmaterial = $this->mcalendario->m_get_materiales_calendario_index($arraycar,$arraydiv,$arraymiem);

		$eventos = [];
		$sesiones = [];
		$otherevent = [];
		$arr_arch=array();
		$arrayfecha = [];

		foreach ($varchivos as $karc => $arch) {
            $arr_arch[$arch->codmaterial][] = $arch;
        }
        unset($varchivos);

		foreach ($vsesiones as $key => $value) {

			$id = $value->id;
			$titulo = $value->detalle;
			$start = $value->fecha." ".$value->hini;
			$end = $value->fecha." ".$value->hfin;
			$link = ($value->hlink != null) ?  $value->hlink : "#";
			$casist = ($value->hlink != null) ?  "btn_ses_asist" : "";

			$dateses =  new DateTime($value->fecha." ".$value->hini);
			$fsesion= $dias[$dateses->format('w')].". ".$dateses->format('d/m/Y h:i a');
            // $fsesion = $dateses->format('d/m/Y h:i a');

			$sesiones[] = [
				"<li class='item'>
					<div class='product-img'>
						<i class='fas fa-video fa-2x text-primary'></i>
					</div>
					<div class='product-info'>
						<a href='$link' class='text-dark product-title $casist' data-sesion='".base64url_encode($value->id)."' data-carga='".base64url_encode($value->codcarga)."' data-division='".base64url_encode($value->division)."' data-unidad='".base64url_encode($value->codunidad)."'> 
							$titulo
						</a>
						<span class='product-description'>
                        	$fsesion
                      	</span>
					</div>
				</li>"
			];
			
		}

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
	            			$titulovirt = strip_tags($virt->nombre);
	            			$linkvirt = base_url()."alumno/curso/virtual/".base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->miembro);
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
	            			// $entrega = $this->mvirtualtarea->m_get_tarea_entregada(array($virt->codigo,$virt->miembro));

	            			$titulovirt=strip_tags($virt->nombre);
	            			$linkvirt=base_url().'alumno/curso/virtual/tarea/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo).'/'.base64url_encode($virt->miembro);
	            			$tipo = "TAREA";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
	            			$iconop = "<img style='width: 30px;height: 30px;' class='mr-1' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
	            			break;
	            		case 'F':
	            			$titulovirt=strip_tags($virt->nombre);
	            			$linkvirt = base_url().'alumno/curso/virtual/foro-virtual/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo).'/'.base64url_encode($virt->miembro);
	            			$tipo = "FORO";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_foro.png' alt='TAREA'>";
	            			$iconop = "<img style='width: 30px;height: 30px;' class='mr-1' src='".base_url()."resources/img/icons/p_foro.png' alt='FORO'>";
	            			break;
	            		case 'V':
	            			$titulovirt=strip_tags($virt->nombre);
	            			$linkvirt=base_url().'alumno/curso/virtual/evaluacion/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo).'/'.base64url_encode($virt->miembro);
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

					$arrayfecha[] = $fother;
					$dataex['vmatfec'] = $arrayfecha;
            		// $fother = $dateother->format('d/m/Y h:i a');
            		// 
					
					// $eventos[] = [
					// 	"<li class='item'>
					// 		<div class='product-img'>
					// 			$iconop
					// 		</div>
					// 		<div class='product-info'>
					// 			<a href='$linkv' class='text-dark product-title'> 
					// 				$titulovirt
					// 			</a>
					// 			<span class='product-description'>
		   //                      	$fother
		   //                    	</span>
					// 		</div>
					// 	</li>"
					// ];

	            }
            }
			
		}

		$longitud = count($arrayfecha);
		for ($i = 0; $i < $longitud; $i++) {
	        for ($j = 0; $j < $longitud - 1; $j++) {
	            if ($arrayfecha[$j] < $arrayfecha[$j + 1]) {
	                $temporal = "<li class='item'>".$arrayfecha[$j]."</li>";
	                $arrayfecha[$j] = "<li class='item'>".$arrayfecha[$j + 1]."</li>";
	                $arrayfecha[$j + 1] = $temporal;
	            }
	        }
	    }

	    $dataex['vmat'] = $arrayfecha;
	    $eventos[] = $arrayfecha;

		if ((count($sesiones)> 0) || (count($eventos)> 0) || (count($otherevent)> 0)) {
			$dataex['status'] =true;
			// $dataex['material'] = $vmaterial;
		}

		if (count($sesiones)> 0) {
			$dataex['sesiones'] = $sesiones;
			
		} else {
			$dataex['sesiones'] = "<li class='item'>Sin videollamadas para mostrar</li>";
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
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
		
	}

	public function vw_facturacion()
	{
		$ahead= array('page_title' =>'Tesorería | Plataforma Virtual '.$this->ci->config->item('erp_title')  );
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view("sidebar_facturacion");
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
	
}


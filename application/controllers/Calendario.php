<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendario extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mcalendario');
		$this->load->model('mmiembros');
	}

	public function vw_principal(){
		$ahead= array('page_title' =>'Calendario | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'calendario','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar = ($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
		$this->load->view($vsidebar,$asidebar);
		$this->load->view('calendario/vw_calendario');
		$this->load->view('footer');
	}

	function randomColor() {
	 	return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
	}

	public function listar_recursos()
	{
		$dataex['status'] =FALSE;
		$tipous = $_SESSION['userActivo']->tipo;
		$carne= $_SESSION['userActivo']->codentidad;

		if ($tipous == "AL") {
			
			$vmaterial = $this->mcalendario->m_get_materiales_calendario_estudiante(array($carne));
			$vsesiones = $this->mcalendario->m_sesiones_completos_x_unidad_estudiante(array($carne));
		} else {
			//$vcargas = $this->mcalendario->m_get_subsecciones_visibles_x_cdocente(array($carne));
			
			$vmaterial = $this->mcalendario->m_get_materiales_calendario_docentes(array($carne));
			$vsesiones = $this->mcalendario->m_sesiones_completos_x_unidad_docentes(array($carne));
			
		}

		/*$arraycar = [];
		$arraydiv = [];
		$arraymiem = [];
		foreach ($vcargas as $key => $vcar) {
			$arraycar[] = $vcar->codcarga;
			$arraydiv[] = $vcar->division;
			if (isset($vcar->codmiembro))  $arraymiem[] = $vcar->codmiembro;
			// $arraymiem[] = $vcar->codmiembro;
			
		}*/
		//$vsesiones = $this->mcalendario->m_sesiones_completos_x_unidad($arraycar,$arraydiv);

		//$varchivos = $this->mcalendario->m_get_vdetalles_calendario($arraycar,$arraydiv);
		//$vmaterial = $this->mcalendario->m_get_materiales_calendario($arraycar,$arraydiv,$arraymiem);

		$eventos = [];
		$eventContent = [];

		foreach ($vsesiones as $key => $value) {

			$id = $value->id;
			$titulo = $value->detalle;
			$start = $value->fecha." ".$value->hini;
			$end = $value->fecha." ".$value->hfin;
			$link = ($value->hlink != null) ?  $value->hlink : "";

			$eventos[] = [
				'id' => $id,
				// 'groupId' => '999',
				'title' => $titulo,
				'description' => "<i class='fas fa-video text-primary'></i> ".$value->tipo. " ".$value->nrosesion." - ".$titulo,
				'tipo' => "SESIÓN",
				'modo' => 'sesion',
				'unidad' => $value->unidad,
				'icono' => "<i class='fas fa-video text-primary'></i> ",
				'start' => $start,
				'end' => $end,
				'inicia' => $start,
				'culmina' => $end,
				'textColor' => '#000000',
				'backgroundColor'=> 'transparent',
          		'borderColor'    => '#0275d8',
				'url' => $link,
				'sesdata' => 'data-sesion="'.base64url_encode($value->id).'" data-carga="'.base64url_encode($value->codcarga).'" data-division="'.base64url_encode($value->division).'" data-unidad="'.base64url_encode($value->codunidad).'"',
			];

			$eventContent[] = [
				'html' => "<i class='fas fa-video text-primary'></i> ".$titulo,
			];
		}
		$calendar_border_color="#292b2c";
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
	            		/*case 'A':
	            			if ($tipous == "AL") {
	            				$linkvirt = base_url()."alumno/curso/virtual/".base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->miembro);
	            			} else {
	            				$linkvirt = base_url()."curso/virtual/".base64url_encode($virt->carga).'/'.base64url_encode($virt->division);
	            			}

	            			$titulovirt=strip_tags($virt->nombre);
	            			$tipo = "ARCHIVO";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_file.png' alt='Archivo'>";
	            			$iconop = "<img style='width: 15px;' class='mr-1' src='".base_url()."resources/img/icons/p_file.png' alt='Archivo'>";
	            			break;*/
	            		/*case 'Y':
	            			$titulovirt=strip_tags($virt->nombre);
	            			$linkvirt="https://www.youtube.com/watch?v=$virt->link";
	            			$tipo = "VIDEO YOUTUBE";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_ytb.png' alt='Youtube'>";
	            			$iconop = "<img style='width: 15px;' class='mr-1' src='".base_url()."resources/img/icons/p_ytb.png' alt='Youtube'>";
	            			break;*/
	            		case 'T':
	            			$calendar_border_color="#f0ad4e";
	            			if ($tipous == "AL") {
	            				$linkvirt=base_url().'alumno/curso/virtual/tarea/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo).'/'.base64url_encode($virt->miembro);
	            			} else {
	            				$linkvirt=base_url().'curso/virtual/tarea/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo);
	            			}

	            			$titulovirt=strip_tags($virt->nombre);
	            			$tipo = "TAREA";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
	            			$iconop = "<img style='width: 15px;' class='mr-1' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
	            			break;
	            		case 'F':
	            			$calendar_border_color="#5bc0de";
	            			if ($tipous == "AL") {
	            				$linkvirt = base_url().'alumno/curso/virtual/foro-virtual/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo).'/'.base64url_encode($virt->miembro);
	            			} else {
	            				$linkvirt = base_url().'curso/virtual/foro/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo);
	            			}

	            			$titulovirt=strip_tags($virt->nombre);
	            			$tipo = "FORO";
	            			$icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_foro.png' alt='TAREA'>";
	            			$iconop = "<img style='width: 15px;' class='mr-1' src='".base_url()."resources/img/icons/p_foro.png' alt='TAREA'>";
	            			break;
	            		case 'V':
	            			$calendar_border_color="#5cb85c";
	            			if ($tipous == "AL") {
	            				$linkvirt=base_url().'alumno/curso/virtual/evaluacion/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo).'/'.base64url_encode($virt->miembro);
	            			} else {
								$linkvirt=base_url().'curso/virtual/evaluacion/'.base64url_encode($virt->carga).'/'.base64url_encode($virt->division).'/'.base64url_encode($virt->codigo);
	            			}

	            			$titulovirt=strip_tags($virt->nombre);
	            			$tipo = "EVALUACIÓN";
	            			$icono = "<img class='mr-1'  src='".base_url()."resources/img/icons/p_cuestionario.png' alt='EVALUACIÓN'>";
	            			$iconop = "<img style='width: 15px;' class='mr-1'  src='".base_url()."resources/img/icons/p_cuestionario.png' alt='EVALUACIÓN'>";
	            			break;
	            		/*case 'L':
	            			$titulovirt=strip_tags($virt->nombre);
	            			$liknko=(strrpos($virt->link, "http")===false) ? 'https://': '';
	                        $linkvirt=$liknko.$virt->link;
	                        $tipo = "LINK";
	                        $icono = "<img class='mr-1' src='".base_url()."resources/img/icons/p_url.png' alt='URL'>";
	                        $iconop = "<img style='width: 15px;' class='mr-1' src='".base_url()."resources/img/icons/p_url.png' alt='URL'>";
	                        break;*/
	                    default:
	                    	$titulovirt=strip_tags($virt->nombre);
	                        # code...

	            	}

	            	$idv = $virt->codigo;
					$titulov = $titulovirt;
					$startv = ($virt->inicia != null) ? $virt->inicia : $virt->creacion;
					if ($virt->vence != null){
						$endv = $virt->vence ;
						$ffinal=(new DateTime($endv))->format("Y-m-d");
					}
					else{
						$endtmp = strtotime ( '+1 hour' , strtotime ($startv) ) ;
						$endv = date ( 'Y-m-d H:i:s' , $endtmp); 
						$ffinal=(new DateTime($endv))->format("Y-m-d");
					}
					$linkv = $linkvirt;
					$finicia=(new DateTime($startv))->format("Y-m-d");
					
					if ($finicia==$ffinal){
						$eventos[] = [
							'id' => $idv."a",
							'groupId' => '999',
							'modo' => 'crea',
							'title' => $titulov,
							'description' => $icono." ".$titulov,
							'tipo' => $tipo,
							'unidad' => $virt->unidad,
							'icono' => $iconop,
							'start' => $startv,
							'end' => $endv,
							'inicia' => $virt->inicia,
							'culmina' => $virt->vence,
							'textColor' => '#000000',
							'backgroundColor'=> 'transparent',
			          		'borderColor'    => $calendar_border_color,//'#3c8dbc',
							'url' => $linkv,
							'sesdata' => '',
						];
					}
					else{
						$finicia1=$startv;
						$ffinaltmp = strtotime ( '+1 hour' , strtotime ($finicia1) ) ;
						$ffinal1 = date ( 'Y-m-d H:i:s' , $ffinaltmp); 
						//$ffinal1=new DateTime($ffinal1);

						$ffinal2=$endv;
						$ffinaltmp2 = strtotime ( '-1 hour' , strtotime ($ffinal2) ) ;
						$finicia2 = date ( 'Y-m-d H:i:s' , $ffinaltmp2); 
						//$finicia2=new DateTime($finicia2);

						$eventos[] = [
							'id' => $idv."a",
							'groupId' => '999',
							'modo' => 'crea',
							'title' => "CREA: ".$titulov,
							'description' => $icono." ".$titulov,
							'tipo' => $tipo,
							'unidad' => $virt->unidad,
							'icono' => $iconop,
							'start' => $finicia1,
							'end' => $ffinal1,
							'inicia' => $virt->inicia ,
							'culmina' => $virt->vence ,
							'textColor' => '#000000',
							'backgroundColor'=> 'transparent',
			          		'borderColor'    => $this->randomColor(),//'#3c8dbc',
							'url' => $linkv,
							'sesdata' => '',
						];
						$eventos[] = [
							'id' => $idv."b",
							'groupId' => '999',
							'modo' => 'vence',
							'title' => "VENCE: ".$titulov,
							'description' => $icono." ".$titulov,
							'tipo' => $tipo,
							'unidad' => $virt->unidad,
							'icono' => $iconop,
							'start' => $finicia2,
							'end' => $ffinal2,
							'inicia' => $virt->inicia ,
							'culmina' => $virt->vence ,
							'textColor' => '#d9534f',
							'backgroundColor'=> 'transparent',
			          		'borderColor'    => $this->randomColor(),//'#3c8dbc',
							'url' => $linkv,
							'sesdata' => '',
						];
					}

	            }
            }

			
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($eventos));
		// echo(json_encode($eventContent));
	}

}

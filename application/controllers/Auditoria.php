<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auditoria extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mauditoria');
		}
	
	public function vw_lstgestion($pagina = false){
		$ahead= array('page_title' =>'IESTWEB - Gestión Auditoria'  );
		$asidebar= array('menu_padre' =>'auditoria','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$dtsus['usuario'] = $this->mauditoria->m_usuarios_gestion();
		$this->load->view('auditoria/lts_auditoria', $dtsus);
		$this->load->view('footer');
	}

	// public function search_list($pagina = false)
 //    {

	// 	$this->form_validation->set_message('required', '%s Requerido');
	// 	$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
	// 	$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
	// 	$dataex['status'] =FALSE;
		
	// 	$dataex['msg']    = '¿Que Intentas?.';
	// 	$rspreinsc = "";
	// 	$dataex['conteo'] = 0;
	// 	if ($this->input->is_ajax_request())
	// 	{
	// 		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
	// 			$this->form_validation->set_rules('fictxtusuario','usuario','trim|required');
 //        		$this->form_validation->set_rules('fictxtaccion','acción','trim|required');
			
	// 		if ($this->form_validation->run() == FALSE)
	// 		{
	// 			$dataex['msg']="Existen errores en los campos";
	// 			$errors = array();
	// 	        foreach ($this->input->post() as $key => $value){
	// 	            $errors[$key] = form_error($key);
	// 	        }
	// 	        $dataex['errors'] = array_filter($errors);
	// 		}
	// 		else
	// 		{
	// 			$busqueda = $this->input->post('fictxtusuario');
	// 			$accion = $this->input->post('fictxtaccion');
	// 			$fechaini = $this->input->post('txtfecha');
	// 			$fechafin = $this->input->post('txtfechafin');
	// 			$contenido = $this->input->post('fictxtcontenido');
	// 			$horaini = '';
	// 			$horafin = '';
	// 			$sede = $_SESSION['userActivo']->idsede;
	// 			if ($fechaini != "" AND $fechafin != "") {
	// 				$horaini = ' 00:00:01';
	// 				$horafin = ' 23:59:59';
	// 			}

	// 			if ($contenido == "") {
	// 				$contenido = '%%%%';
	// 			}
				
				
	// 			$preaudit['historial'] = $this->mauditoria->m_dtsAudit_search(array('%'.$busqueda.'%', '%'.$accion.'%', $fechaini.$horaini, $fechafin.$horafin, '%'.$contenido.'%', $sede));
				
	// 			$conteo = count($preaudit['historial']);
				
	// 			if ($conteo > 0)
	// 			{
	// 				/* PAGINACIÓN */
	// 				$this->load->library('pagination');
	// 				$inicio = 0;
	// 		        $limite = 4;

	// 		        if ($pagina) {
	// 		            $inicio = ($pagina - 1) * $limite;
	// 		        }

	// 		        $config['base_url'] = base_url().'gestion/auditoria';
	// 		        $config['total_rows'] = $conteo;
	// 		        $config['per_page'] = $limite;
	// 		        $config['uri_segment'] = 3;
	// 		        $config['num_links'] = 2;
	// 		        $config['use_page_numbers'] = true;
	// 		        $config['full_tag_open'] = '<ul class="pages">';
	// 		        $config['full_tag_close'] = '</ul>';
	// 		        $config['first_link'] = false;
	// 		        $config['last_link'] = false;
	// 		        $config['first_tag_open'] = '<li>';
	// 		        $config['first_tag_close'] = '</li>';
	// 		        $config['prev_link'] = '<i class="fa fa-angle-double-left"></i>';
	// 		        $config['prev_tag_open'] = '<li class="prev">';
	// 		        $config['prev_tag_close'] = '</li>';
	// 		        $config['next_link'] = '<i class="fa fa-angle-double-right"></i>';
	// 		        $config['next_tag_open'] = '<li>';
	// 		        $config['next_tag_close'] = '</li>';
	// 		        $config['last_tag_open'] = '<li>';
	// 		        $config['last_tag_close'] = '</li>';
	// 		        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	// 		        $config['cur_tag_close'] = '</a></li>';
	// 		        $config['num_tag_open'] = '<li>';
	// 		        $config['num_tag_close'] = '</li>';
	// 		        $this->pagination->initialize($config);
 //        			$result = $this->mauditoria->mlist_search_registros($inicio, $limite, array($busqueda, $accion, $fechaini.$horaini, $fechafin.$horafin, $contenido, $sede));
 //        			$preaudit['historial'] = $result;
 //        			$preaudit['pagination'] = $this->pagination->create_links();
	// 				/* FIN PAGINACIÓN */

	// 				// $dataex['conteo'] = $conteo;
	// 				$dataex['conteo'] = count($preaudit['historial']);
	// 				$rspreaudit = $this->load->view('auditoria/dts_auditoria',$preaudit,TRUE);
	// 			}
	// 			else
	// 			{
	// 				$rspreaudit = $this->load->view('errors/sin-resultados',array(),TRUE);
	// 			}
	// 			$dataex['status'] = TRUE;
	// 		}
	// 	}

	// 	$dataex['vdata'] = $rspreaudit;
	// 	header('Content-Type: application/x-json; charset=utf-8');
	// 	echo(json_encode($dataex));
 //    }
 	
 	public function search_list()
    {

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
				$this->form_validation->set_rules('fictxtusuario','usuario','trim|required');
        		$this->form_validation->set_rules('fictxtaccion','acción','trim|required');
			
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
				$busqueda = $this->input->post('fictxtusuario');
				$accion = $this->input->post('fictxtaccion');
				$fechaini = $this->input->post('txtfecha');
				$fechafin = $this->input->post('txtfechafin');
				$contenido = $this->input->post('fictxtcontenido');
				$contenido=str_replace(" ","%",$contenido);
				// $horaini = '';
				// $horafin = '';
				$sede = $_SESSION['userActivo']->idsede;

				$databuscar=array();

				if ($fechaini != "" && $fechafin != "") {
					$horaini = ' 00:00:01';
					$horafin = ' 23:59:59';
					$databuscar[]=$fechaini.$horaini;
					$databuscar[]=$fechafin.$horafin;
				}
				elseif ($fechaini == "" && $fechafin == "") {
					
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

				// if ($fechaini != "" AND $fechafin != "") {
				// 	$horaini = ' 00:00:01';
				// 	$horafin = ' 23:59:59';
				// }

				// if ($contenido == "") {
				// 	$contenido = '%%%%';
				// }

				$inicio = $this->input->post("inicio");
				$limite = $this->input->post("limite");
				
				$rsdata = $this->mauditoria->m_dtsAudit_search($inicio,$limite,'%'.$busqueda.'%', '%'.$accion.'%', $contenido, $sede, $databuscar);
				// $preaudit['historial'] = $this->mauditoria->m_dtsAudit_search(array('%'.$busqueda.'%', '%'.$accion.'%', $fechaini.$horaini, $fechafin.$horafin, '%'.$contenido.'%', $sede));
				$rsdata['inicio']=$inicio;

				if ($rsdata['numitems'] > 0) {
	                $dataex['status'] = true;
	                
	                $dataex['numitems'] = $rsdata['numitems'] ;
	                $datos = $this->load->view('auditoria/dts_auditoria', $rsdata, true);
	            } else {
	            	$datos = "<div class='text-danger h6'>Datos no encontrados</div>";
	            	$dataex['numitems'] = 0;
	            }
				
				
			}
		}

		$dataex['vdata'] = $datos;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
    }

    public function fneliminar_registro()
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
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este registro";
                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));
                
                $rpta = $this->mauditoria->m_eliminar_data(array("SI", $txtcodigo));
                if ($rpta == 1) {
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Registro eliminado correctamente';
                }

            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

}
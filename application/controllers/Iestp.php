<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Iestp extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('miestp');
		$this->load->model('mubigeo');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Configuracion | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'mantenimiento','menu_hijo' =>'mn_mnt_institucion');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar_mantenimiento',$asidebar);
		$this->load->model('mubigeo');
		$dtsiestp['departamentos'] =$this->mubigeo->m_departamentos();
		$datosiest = $this->miestp->m_get_datos();

		$rsprov="<option value='0'>Sin opciones</option>";
		$provincias=$this->mubigeo->m_provincias(array($datosiest->coddepartamento));
		if (count($provincias)>0) $rsprov="<option value='0'>Seleccionar Provincia</option>";
		foreach ($provincias as $provincia) {
			$rsprov=$rsprov."<option value='$provincia->codigo'>$provincia->nombre</option>";
		}

		$rsdistri="<option value='0'>Sin opciones</option>";
		$distritos=$this->mubigeo->m_distritos(array($datosiest->codprovincia));
		if (count($distritos)>0) $rsdistri="<option value='0'>Seleccionar Distrito</option>";
		foreach ($distritos as $distrito) {
			$rsdistri=$rsdistri."<option value='$distrito->codigo'>$distrito->nombre</option>";
		}

		$dtsiestp['dts'] = $datosiest;

		//$dtsiestp['departamentos'] = $this->mubigeo->m_departamentos();
		$this->load->model('mdocentes');
		$this->load->model('msede');
		$this->load->model('mcarrera');
		$dtsiestp['docentes'] = $this->mdocentes->m_get_docentes_administrativos();
		$dtsiestp['sedes'] = $this->msede->m_get_sedes_all();
		//$arraydts['activos'] = $this->msede->m_get_sedes_activos();
		$dtsiestp['carreras'] = $this->mcarrera->m_lts_carreras_activas();

		$dtsiestp['provincias']=$rsprov;
		$dtsiestp['distritos']=$rsdistri;

		$this->load->view('config_iestp/vw_principal', $dtsiestp);
		$this->load->view('footer');
	}

	public function fn_update_datos()
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
			$this->form_validation->set_rules('fictxtnombre','Nombre','trim|required');
			$this->form_validation->set_rules('fictxtnombre_pre','Nombre','trim|required');
			$this->form_validation->set_rules('fictxtnombre_largo','Nombre largo','trim|required');
			$this->form_validation->set_rules('fictxtnombre_corto','Nombre corto','trim|required');
			$this->form_validation->set_rules('fictxtnombre_solo','Nombre','trim|required');
			$this->form_validation->set_rules('fictxtmodul','Módulo','trim|required');
			$this->form_validation->set_rules('fictxtgestion','Gestion','trim|required');
			$this->form_validation->set_rules('fictxtdre','Dre','trim|required');

			$this->form_validation->set_rules('fictxtcreacion','Creación','trim|required');
			$this->form_validation->set_rules('fictxtresolu','Resolucion','trim|required');
			$this->form_validation->set_rules('fictxtrevali','Revalidacion','trim|required');

			$this->form_validation->set_rules('ficbdepartamento','Departamento','trim|required');
			$this->form_validation->set_rules('vw_ins_cbprovincia','Provincia','trim|required');
			$this->form_validation->set_rules('vw_ins_cbdistrito','Distrito','trim|required');
			$this->form_validation->set_rules('fictxtcpob','Centro poblado','trim|required');
			$this->form_validation->set_rules('fictxtdirec','Direccion','trim|required');

			$this->form_validation->set_rules('fictxtemail_soporte','Email soporte','trim|required');
			$this->form_validation->set_rules('fictxtwhatsoporte','Whatsapp soporte','trim|required');
			$this->form_validation->set_rules('fictxtweb','Web','trim|required');
			$this->form_validation->set_rules('fictxtemail_inst','Email Institución','trim|required');
			$this->form_validation->set_rules('fictxttelefono','Telefono','trim|required');

			$this->form_validation->set_rules('fictxtgsuiteid','Id Gsuite','trim|required');
			$this->form_validation->set_rules('fictxtgsuitekey','Key Gsuite','trim|required');
			$this->form_validation->set_rules('fictxtgsuitecsc','Csc Gsuite','trim|required');
			

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
				$nombre = strtoupper($this->input->post('fictxtnombre'));
				$prenombre = strtoupper($this->input->post('fictxtnombre_pre'));
				$nombrelargo = strtoupper($this->input->post('fictxtnombre_largo'));
				$nombrecorto = strtoupper($this->input->post('fictxtnombre_corto'));
				$nombre_solo = strtoupper($this->input->post('fictxtnombre_solo'));
				$cmodular = $this->input->post('fictxtmodul');
				$gestion = $this->input->post('fictxtgestion');
				$drep = strtoupper($this->input->post('fictxtdre'));

				$creacion = strtoupper($this->input->post('fictxtcreacion'));
				$resolucion = strtoupper($this->input->post('fictxtresolu'));
				$revalidacion = strtoupper($this->input->post('fictxtrevali'));

				$distrito = $this->input->post('vw_ins_cbdistrito');
				$cproblado = strtoupper($this->input->post('fictxtcpob'));
				$direccion = strtoupper($this->input->post('fictxtdirec'));

				$emailsoport = $this->input->post('fictxtemail_soporte');
				$whatsappsoport = $this->input->post('fictxtwhatsoporte');
				$email = $this->input->post('fictxtemail_inst');
				$web = $this->input->post('fictxtweb');
				$telefono = $this->input->post('fictxttelefono');

				$gsuiteid = base64url_encode($this->input->post('fictxtgsuiteid'));
				$gsuitekey = base64url_encode($this->input->post('fictxtgsuitekey'));
				$gsuitecsc = base64url_encode($this->input->post('fictxtgsuitecsc'));

				$checkstatus = "NO";
                $checkplataf = "NO";
                $checkgmail = "NO";

                if ($this->input->post('checkactivains')!==null){
                    $checkstatus = $this->input->post('checkactivains');
                }

                if ($this->input->post('checkopcion1')!==null){
                    $checkplataf = $this->input->post('checkopcion1');
                }

                if ($this->input->post('checkopcion2')!==null){
                    $checkgmail = $this->input->post('checkopcion2');
                }

                if ($checkstatus=="on"){
                	$checkstatus = "SI";
                }

                if ($checkplataf=="on"){
                	$checkplataf = "SI";
                }

                if ($checkgmail=="on"){
                	$checkgmail = "SI";
                }

				$rpta=$this->miestp->update_datos(array($codigo, $nombre, $cmodular, $gestion, $drep, $creacion, $resolucion, $revalidacion, $distrito, $cproblado, $email, $web, $telefono, $direccion, $checkstatus, $nombrelargo, $nombrecorto, $gsuiteid, $gsuitekey, $gsuitecsc, $nombre_solo, $prenombre, $checkplataf, $checkgmail, $emailsoport, $whatsappsoport));
				if ($rpta == 1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Datos actualizados correctamente";
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}
}
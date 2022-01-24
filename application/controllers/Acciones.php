<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Acciones extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('macciones');
		}
	
	public function index(){
		
		$resultado=$this->cargaPermisos();		
		$ahead= array('page_title' =>'IESTWEB - Gestión Administrativa - Académica'  );
		$asidebar= array('menu_padre' =>'control','menu_hijo' =>'acciones');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->view('acciones/index',$resultado);
		$this->load->view('footer');
	}

	public function update(){
		/*$accede = $_SESSION['UserLogin'];
		$resultado['logeo']=($accede==true);
		$resultado['destino']=base_url();
		if ($accede==true){*/
			$resultado['status']=false;
			if (getPermitido("2")=='SI'){
				$resultado['msg']="<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (M3_CCH)";
				$this->form_validation->set_message('required', '%s Requerido');

				$this->form_validation->set_message('numeric', '* Requiere un número');
				$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
				$this->form_validation->set_message('is_unique', '{field} ya está Registrado.');
		
				$this->form_validation->set_rules('actxttipo','Identificación','trim|required');
				$this->form_validation->set_rules('actxtiditem','Identificador','trim|required|is_natural_no_zero');
				$this->form_validation->set_rules('actxtitem','Acción','trim|required');
				$this->form_validation->set_rules('cbpadre','Padre','trim|required|is_natural');
				
				
				
				if ($this->form_validation->run() == FALSE){
					$errors = array();
			        foreach ($this->input->post() as $key => $value){
			            $errors[$key] = form_error($key);
			        }
			        $resultado['errors'] = array_filter($errors);
			        $resultado['msg']=validation_errors();
				}
				else{
					$acckhabil=(is_null($this->input->post('acckhabil')))? 'HABILITADO':'DESHABILITADO';
					$actxttipo=$this->input->post('actxttipo');
					$actxtiditem=$this->input->post('actxtiditem');
					$actxtitem=$this->input->post('actxtitem');
					$cbpadre=$this->input->post('cbpadre');

					
					
					//CALL ``( @vnombre, @vid_modulo, @vdescripcion, @vid_padre, @vestado, @vtipo, @vid, @s);
					$arrayName = array($actxtitem,"01"," ",$cbpadre,$acckhabil,$actxttipo,$actxtiditem);
					
					$rp=$this->macciones->mUpdate($arrayName);
					if ($rp==-1){
						$resultado['status']=false;
						$resultado['msg'] = "<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (D1_M4)";
					}
					else{
						$resultado['status']=true;
						$resultado['msg'] = "<strong>Proceso completado!</strong> Datos del director han sido ACTUALIZADOS.";
					}
				}
			}
		//}	
		header('Content-Type: application/x-json; charset=utf-8');
		exit(json_encode($resultado));
	}
	public function deleteComponent(){
		/*$accede = $_SESSION['UserLogin'];
		$resultado['logeo']=($accede==true);
		$resultado['destino']=base_url();
		if ($accede==true){*/
			$resultado['status']=false;
			$resultado['msg']="<strong>Acción Denegada</strong><br>No tienes los privilegios para ejecutar esta acción";
			if (getPermitido("15")=='SI'){
				$resultado['msg']="<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (M3_CCH)";
				$this->form_validation->set_message('required', '%s Requerido');

				$this->form_validation->set_message('numeric', '* Requiere un número');
				$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
				$this->form_validation->set_message('is_unique', '{field} ya está Registrado.');
				$this->form_validation->set_rules('dctxtiditem','Identificador','trim|required|is_natural_no_zero');
				
				$this->form_validation->set_rules('dctxtidpadre','Padre','trim|required|is_natural');
				if ($this->form_validation->run() == FALSE){
					$errors = array();
			        foreach ($this->input->post() as $key => $value){
			            $errors[$key] = form_error($key);
			        }
			        $resultado['errors'] = array_filter($errors);
			        $resultado['msg']=validation_errors();
				}
				else{



					//$acckhabil=(is_null($this->input->post('acckhabil')))? 'HABILITADO':'DESHABILITADO';
					$iditem=$this->input->post('dctxtiditem');
					$idpadre=$this->input->post('dctxtidpadre');
					

					
					
					//CALL ``( @vnombre, @vid_modulo, @vdescripcion, @vid_padre, @vestado, @vtipo, @vid, @s);
					$arrayName = array($idpadre,$iditem);
					
					$rp=$this->macciones->mDeleteComponent($arrayName);
					if ($rp==-1){
						$resultado['status']=false;
						$resultado['msg'] = "<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (D1_M4)";
					}
					else{
						$resultado['status']=true;
						$resultado['msg'] = "<strong>Proceso completado!</strong> Ítem Eliminado.";
					}
				}
			}
		//}	
		header('Content-Type: application/x-json; charset=utf-8');
		exit(json_encode($resultado));
	}
	public function insert(){
		/*$accede = $_SESSION['UserLogin'];
		$resultado['logeo']=($accede==true);
		$resultado['destino']=base_url();

		if ($accede==true){*/
			$resultado['msg']="<strong>Acción Denegada</strong><br>No tienes los privilegios para ejecutar esta acción";
			$resultado['status']=false;
			if (getPermitido("2")=='SI'){
				$resultado['msg']="<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (M3_CCH)";
				$this->form_validation->set_message('required', '%s Requerido');

				$this->form_validation->set_message('numeric', '* Requiere un número');
				$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
				$this->form_validation->set_message('is_unique', '{field} ya está Registrado.');
				
				
				//$this->form_validation->set_rules('ictxttipo','Identificación','trim|required');
				$this->form_validation->set_rules('icrdtipo','Tipo','trim|required');
				$this->form_validation->set_rules('ictxtitem','Acción','trim|required');
				$this->form_validation->set_rules('icbpadre','Padre','trim|required|is_natural');
				
				
				
				if ($this->form_validation->run() == FALSE){
					$errors = array();
			        foreach ($this->input->post() as $key => $value){
			            $errors[$key] = form_error($key);
			        }
			        $resultado['errors'] = array_filter($errors);
			        $resultado['msg']=validation_errors();
				}
				else{



					$acckhabil=(is_null($this->input->post('icckhabil')))? 'HABILITADO':'DESHABILITADO';
					$actxttipo=$this->input->post('icrdtipo');
					//$actxtiditem=$this->input->post('actxtiditem');
					$actxtitem=$this->input->post('ictxtitem');
					$cbpadre=$this->input->post('icbpadre');

					
					
					//CALL ``( @vnombre, @vid_modulo, @vdescripcion, @vid_padre, @vestado, @vtipo, @vid, @s);
					$arrayName = array($actxtitem,"01"," ",$cbpadre,$acckhabil,$actxttipo,);
					
					$rp=$this->macciones->mInsert($arrayName);
					if ($rp==-1){
						$resultado['status']=false;
						$resultado['msg'] = "<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (D1_M4)";
					}
					else{
						$resultado['status']=true;
						$resultado['msg'] = "<strong>Proceso completado!</strong> Ítem Creado.";
					}
				}
			}
		//}	
		header('Content-Type: application/x-json; charset=utf-8');
		exit(json_encode($resultado));
	}

	public function cargaPermisos(){
		
		/*$accede = $_SESSION['UserLogin'];
		$resultado['logeo']=($accede==true);
		if ($accede==true){*/
			
			$arrayTodos =  $this->macciones->marray_estructura();
			$resultado['nodosPadres']=$arrayTodos;
  			//$_SESSION['upelocal']=$this->musuario->mPermisos($iduser);
			$ap=array('nodeId'=>'0' ,'text' => 'Permisos','href'=>'#','tags'=>array('idpadre'=>'0','id'=>'0','tipo'=>'C'),'state'=>array('expanded'=>true),'nodes'=>array());
			$rpt=$this->getNodos($arrayTodos,$ap);
						
			//$dataex['array'] =array($rpt);
			$resultado['array'] =$rpt['nodes'];

			return $resultado;
			//$resultado['rweb']=$this->load->view('usuarios/vwtreepermisos',$dataex,true);
			
		//}
		//header('Content-Type: application/x-json; charset=utf-8');
		//echo(json_encode($resultado));
	}
	
	public function getNodos($arrayTodos,$nodo){
		//$prms = $_SESSION['upelocal'];		

		$idPadre=$nodo['tags']['id'];
		$tipo=trim($nodo['tags']['tipo']);
		foreach ($arrayTodos as $value => $row) {
			if ("C".$row['v4']==$tipo.$idPadre) {
				//$permitido="NO";
				//if (($row['v5']=="A") && (array_key_exists($row['v2'],$prms))){
				//	$permitido= $prms[$row['v2']]->v3;
				//}
				$isselect=($tipo=="C") ? true : false;
				
				//$ischeck=($permitido=="SI") ? true : false;
				$nHijo=array('nodeId'=>$row['v2'],'text' => $row['v3'],'href'=>'#','icon'=>'glyphicon glyphicon-screenshot','tags'=>array('idpadre'=>$row['v4'],'id'=>$row['v2'],'tipo'=>$row['v5']),'nodes'=>array());
				if ($row['v5']=="C") {
					unset($nHijo['icon']);	
				} 
				/*if ($row['v5']=="A")
				{
					$nHijo['color']="#428bca";
				}*/
				unset($arrayTodos[$row['v5'].$row['v2']]);
				$nHijo=$this->getNodos($arrayTodos,$nHijo);

				if (count($nHijo['nodes'])==0) {
					unset($nHijo['nodes']);
				}

				$nodo['nodes'][]=$nHijo;
			}
		}
		return $nodo;
	}
}
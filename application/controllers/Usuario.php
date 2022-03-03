<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Usuario extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('musuario');
	}

	public function vw_mi_perfil()
	{
		
		$miperfil=$this->musuario->m_perfil($_SESSION['userActivo']->codpersona);
		//$miperfil=$arriniciar['perfil'];
		$ahead= array('page_title' =>'Mi Perfil | IESTWEB');
		$asidebar= array('menu_padre' =>'miperfil');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=($_SESSION['userActivo']->tipo == 'AL')?"sidebar_alumno":"sidebar";
        $this->load->view($vsidebar);
		$this->load->view('cuentas/perfil', $miperfil);
		$this->load->view('footer');
	}

	public function fn_asignar_sedes(){
		$finsertar= json_decode($_POST['finsertar']);
		$feditar= json_decode($_POST['feditar']);
		$feliminar= json_decode($_POST['feliminar']);
		$this->musuario->m_asignar_sedes($finsertar,$feditar,$feliminar);
		$dataex['status'] =TRUE;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}


	//data: {iduser: vidusua,user: vusua, clave: vclave, correo: vcorreo},

	public function fn_cambiar_acceso(){
		$resultado['status']=false;
		$resultado['msg']="<strong>Acción Denegada</strong><br>No tienes los privilegios para ejecutar esta acción";
		if (getPermitido("37")=='SI'){
			$resultado['msg']="<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (M3_CCH)";
			$this->form_validation->set_message('required', '%s Requerido');

			$this->form_validation->set_message('numeric', '* Requiere un número');
			$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
			$this->form_validation->set_message('is_unique', '{field} ya está Registrado.');
			
			//CALL `sp_prm_insert_update`( @vid, @vid_usuarioentidad, @id_accion, @vid_componente, @vestado, @vpermitido, @s);
			$this->form_validation->set_rules('iduser','IdUser','trim|required');
			$this->form_validation->set_rules('user','Usuario','trim|required');
			$this->form_validation->set_rules('correo','Correo','trim|required');
			$resultado['msg']="Ocurrio Un Error";
			if ($this->form_validation->run() == FALSE){
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $resultado['errors'] = array_filter($errors);
		        $resultado['msg']=validation_errors();
			}
			else{
				$acciones=array();
				$iduser=base64url_decode($this->input->post('iduser'));
				$user=$this->input->post('user');
				$clave=$this->input->post('clave');


				//$domimail="@".getDominio();
				$correo=$this->input->post('correo');
				
				
				$this->musuario->m_cambiar_acceso(array($user,$clave,$correo,$iduser));
				$resultado['msg']="TODO OK";
				$resultado['status']=true;
				//}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		exit(json_encode($resultado));
	}	

	public function fn_cambiar_clave(){
		$resultado['status']=false;
		$resultado['msg']="<strong>Acción Denegada</strong><br>No tienes los privilegios para ejecutar esta acción";
		//if (getPermitido("37")=='SI'){
			$resultado['msg']="<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (M3_CCH)";
			$this->form_validation->set_message('required', '%s Requerido');

			$this->form_validation->set_message('numeric', '* Requiere un número');
			$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
			$this->form_validation->set_message('max_length', '* {field} debe tener como máximo {param} caracteres.');
			$this->form_validation->set_message('is_unique', '{field} ya está Registrado.');
			
			//CALL `sp_prm_insert_update`( @vid, @vid_usuarioentidad, @id_accion, @vid_componente, @vestado, @vpermitido, @s);
			$this->form_validation->set_rules('fcctxtclave','Contraseña actual','trim|required|min_length[5]|max_length[20]');
			$this->form_validation->set_rules('fcctxtclavenueva','Nueva contraseña','trim|required|min_length[5]|max_length[20]');
			$this->form_validation->set_rules('fcctxtrpclavenueva','Repite nueva contraseña','trim|required|min_length[5]|max_length[20]');

			$resultado['msg']="Ocurrio Un Error";
			if ($this->form_validation->run() == FALSE){
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $resultado['errors'] = array_filter($errors);
		        $resultado['msg']="Error en los campos";//validation_errors();
			}
			else{
				$resultado['msg']="No se pudo realizar el cambio de contraseña";
				$acciones=array();
				$iduser=$_SESSION["userActivo"]->idusuario;
				
				$clave=$this->input->post('fcctxtclave');
				$claven=$this->input->post('fcctxtclavenueva');
				$claverp=$this->input->post('fcctxtrpclavenueva');
				if ($claven==$claverp){
					$nupdate=$this->musuario->m_cambiar_clave(array(sha1($claven),$iduser,sha1($clave)));
					$resultado['msg']="Su contraseña actual no coincide";
					if ($nupdate>0 ){
						$resultado['status']=true;
					} 
				}
				else{
					$resultado['errors']['fcctxtrpclavenueva'] ="Las contraseñas no coinciden" ;
					$resultado['errors']['fcctxtclavenueva'] ="Las contraseñas no coinciden" ;
				}
			}
		//}
		header('Content-Type: application/x-json; charset=utf-8');
		exit(json_encode($resultado));
	}	

	


	public function fn_eliminar()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('ce-iduser','Id Usuario','trim|required');
            

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
                $dataex['msg'] ="No se eliminó la cuenta, consulte con Soporte err0 err-1";
                $dataex['status'] =FALSE;
                $ceidmat=base64url_decode($this->input->post('ce-iduser'));
                
                $newcod=$this->musuario->m_eliminar(array($ceidmat));
                $dataex['newcod'] =$newcod;
                if ($newcod=='1'){
                    $dataex['status'] =TRUE;
                    $dataex['msg'] ="Cuenta de usuario, eliminada";
                }

            }

        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }



	public function fn_activado(){
		$resultado['status']=false;
		$resultado['msg']="<strong>Acción Denegada</strong><br>No tienes los privilegios para ejecutar esta acción";
		if (getPermitido("166")=='SI'){
			$resultado['msg']="<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (M3_CCH)";
			$this->form_validation->set_message('required', '%s Requerido');

			$this->form_validation->set_message('numeric', '* Requiere un número');
			$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
			$this->form_validation->set_message('is_unique', '{field} ya está Registrado.');
			
			//CALL `sp_prm_insert_update`( @vid, @vid_usuarioentidad, @id_accion, @vid_componente, @vestado, @vpermitido, @s);
			$this->form_validation->set_rules('iduser','IdUser','trim|required');
			$this->form_validation->set_rules('activo','Estado','trim|required');

			$resultado['msg']="Ocurrio Un Error";
			if ($this->form_validation->run() == FALSE){
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $resultado['errors'] = array_filter($errors);
		        $resultado['msg']=validation_errors();
			}
			else{
				$acciones=array();
				$iduser=base64url_decode($this->input->post('iduser'));
				$activo=$this->input->post('activo');
				$this->musuario->m_activado(array($activo,$iduser));
				$resultado['status']=true;
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		exit(json_encode($resultado));
	}	



		public function fn_asignar_permisos(){
			$resultado['status']=false;
			$resultado['msg']="<strong>Acción Denegada</strong><br>No tienes los privilegios para ejecutar esta acción";
			if (getPermitido("113")=='SI'){
				$resultado['msg']="<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (M3_CCH)";
				$this->form_validation->set_message('required', '%s Requerido');

				$this->form_validation->set_message('numeric', '* Requiere un número');
				$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
				$this->form_validation->set_message('is_unique', '{field} ya está Registrado.');
				
				//CALL `sp_prm_insert_update`( @vid, @vid_usuarioentidad, @id_accion, @vid_componente, @vestado, @vpermitido, @s);
				$this->form_validation->set_rules('txtcoduser','Usuario','trim|required');
				$this->form_validation->set_rules('txtcodsede','Usuario','trim|required');
				$resultado['msg']="Ocurrio Un Error";
				if ($this->form_validation->run() == FALSE){
					$errors = array();
			        foreach ($this->input->post() as $key => $value){
			            $errors[$key] = form_error($key);
			        }
			        $resultado['errors'] = array_filter($errors);
			        $resultado['msg']=validation_errors();
				}
				else{
					$acciones=array();
					$idSede=$this->input->post('txtcodsede');
					$idUser=base64url_decode($this->input->post('txtcoduser'));
					$acciones=json_decode($this->input->post('acciones'),true);	
					if ($acciones==null) $acciones=array();
					$arrayItems=array();
					foreach ($acciones as $value) {
						$permitido="NO";
						if ($value['permitido']==true) $permitido="SI";
						$arrayItem=array($value['id'],$idUser,$idSede,$value['idAccion'],"1","1",$permitido);
						$arrayItems[]=$arrayItem;
					}			
					
					$this->load->model('macciones');
					if (count($arrayItems)>0) $this->macciones->mUpdateInsertPermisoUser($arrayItems);
					
					$acuncheck=array();
					$acuncheck=json_decode($this->input->post('uncheck'),true);	
					if ($acuncheck==null) $acuncheck=array();
					/*/$arrayItems=array();
					foreach ($acuncheck as $value) {
						if ($value['permitido']==true) $permitido="SI";
						$arrayItem=array($value['id'],$idUser,$value['idAccion'],"1","1",$permitido);
						$arrayItems[]=$arrayItem;
					}*/		
					if (count($acuncheck)>0) $rp=$this->macciones->mDeletePermisoUser($acuncheck);
					/*if ($rp==-1){
						$resultado['status']=false;
						$resultado['msg'] = "<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (D1_M4)";
					}
					else{*/
						$resultado['status']=true;
						$resultado['msg'] = "<strong>Proceso completado!</strong> Permisos actualizados.";
					//}
				}
			}
		header('Content-Type: application/x-json; charset=utf-8');
		exit(json_encode($resultado));
	}
	public function vw_cuentas()
	{
		$ahead= array('page_title' =>'Usuarios | IESTWEB');
		$asidebar= array('menu_padre' =>'control','menu_hijo' =>'usuarios');
        $this->load->view('head', $ahead);
        $this->load->view('nav');
        $this->load->model('msede');
        $arrcuentas['sedes']=$this->msede->m_get_sedes();
        $arrcuentas['cuentas']=$this->musuario->m_tipo_conteo();
        $this->load->model('msede');
        $arrcuentas['sedes'] = $this->msede->m_get_sedes_activos();
        $this->load->view('sidebar',$asidebar);
        $this->load->view('cuentas/cuentas',$arrcuentas);
        $this->load->view('footer');
	}
	
	public function fn_filtrar_cuentas()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas=array();
		if ($this->input->is_ajax_request())
		{
			$rscuentas['usuarios']=array();
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtadmin','Búsqueda','trim');
			$this->form_validation->set_rules('fictxtsede','sede','trim|required');
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
				$busqueda=$this->input->post('txtadmin');
				$sede = $this->input->post('fictxtsede');
				$activo = $this->input->post('fictxtactivous');
				$checkemail = $this->input->post('actcheckemail');
				/*actcheckemail
				$ = "NO";*/

				/*if ($this->input->post('actcheckemail')!==null){
                    $checkemail = $this->input->post('actcheckemail');
                }

                if ($checkemail=="on"){
                	$checkemail = "SI";
                }*/
				
				$tipo=$this->input->post('txttipo');
				switch ($tipo) {
					case 'ADM':
						$cuentas=$this->musuario->m_filtrar_cuentas_adm_doc(array("%".$busqueda.'%', $sede, $activo, $checkemail));
						break;
					case 'ALU':
						$cuentas=$this->musuario->m_filtrar_cuentas_alum(array("%".$busqueda.'%', $sede, $activo, $checkemail));
						break;
					case 'DOC':
						$cuentas=$this->musuario->m_filtrar_cuentas_adm_doc(array("%".$busqueda.'%', $sede, $activo, $checkemail));
						break;
					default:
						$cuentas=array();
						break;
				}
				if (isset($cuentas)) 
				// $rscuentas=$this->load->view('cuentas/cuentas-lista',$cuentas,TRUE);
				foreach ($cuentas['usuarios'] as $key => $user) {
					$user->vcodigo64 = base64url_encode($user->idusuario);
				}
				$rscuentas = $cuentas;
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] = $rscuentas['usuarios'];
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_email_corporativo_generado()
	{
		$resultado['status']=false;
		$resultado['msg']="<strong>Acción Denegada</strong><br>No tienes los privilegios para ejecutar esta acción";
		if (getPermitido("166")=='SI'){
			$resultado['msg']="<strong>Houston, tenemos un problema!</strong><br>Intente nuevamente o comuniquese con un administrador. (M3_CCH)";
			$this->form_validation->set_message('required', '%s Requerido');

			$this->form_validation->set_message('numeric', '* Requiere un número');
			$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
			$this->form_validation->set_message('is_unique', '{field} ya está Registrado.');
			
			$this->form_validation->set_rules('iduser','IdUser','trim|required');
			$this->form_validation->set_rules('activo','Estado','trim|required');

			$resultado['msg']="Ocurrio Un Error";
			if ($this->form_validation->run() == FALSE){
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $resultado['errors'] = array_filter($errors);
		        $resultado['msg']=validation_errors();
			}
			else{
				$acciones=array();
				$iduser = base64url_decode($this->input->post('iduser'));
				$activo = $this->input->post('activo');
				$rpta = $this->musuario->m_activado_email_generado(array($iduser, $activo));
				if ($rpta->salida == "1") {
					$resultado['status']=true;
				}
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		exit(json_encode($resultado));
	}

	/*CARGAR ARBOL DE PERMISOS*/
	public function vw_permisos_por_usuario(){
		$this->form_validation->set_message('required', '%: Dato Requerido');
	
			$iduser=base64url_decode($this->input->post('txtcoduser'));
			$this->load->model('macciones');
			$arrayTodos =  $this->macciones->marray_estructura();
			$this->load->model('mpermiso');
  			$_SESSION['upelocal']=$this->mpermiso->m_get_permisos_por_usuario(array($iduser,$_SESSION['userActivo']->idsede));
			//var_dump($_SESSION['upelocal']
			$ap=array('idpermiso'=> "",'text' => 'Permisos','href'=>'#','tags'=>array('idpadre'=>'0','id'=>'0','tipo'=>'C'),'selectable'=> false,'state'=>array('checked'=>true),'nodes'=>array());
			$rpt=$this->getNodos($arrayTodos,$ap);
						
			$dataex['array'] =$rpt['nodes'];
			$dataex['txtcoduser'] =$iduser;

			//$resultado['array'] =array($rpt);

			$resultado['rweb']=$this->load->view('cuentas/permisos',$dataex,true);
			unset($_SESSION['upelocal']);
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($resultado));
	}
	
	function getNodos($arrayTodos,$nodo){
		$prms = $_SESSION['upelocal'];		

		$idPadre=$nodo['tags']['id'];
		$tipo=$nodo['tags']['tipo'];
		foreach ($arrayTodos as $value => $row) {
			if ("C".$row['v4']==$tipo.$idPadre) {
				$permitido="NO";
				$idpermiso="";
				if (($row['v5']=="A") && (array_key_exists($row['v2'],$prms))){
					$permitido= $prms[$row['v2']]->v3;
					//echo $row['v2']."--".$prms[$row['v2']]->v3."<br>";
					$idpermiso=$prms[$row['v2']]->v4;
				}

				$isselect=($tipo=="C") ? false : true;
				$showcheckbox=($row['v5']=="C") ? false : true;
				$ischeck=($permitido=="SI") ? true : false;
				
				
				$nHijo=array('idpermiso'=> $idpermiso, 'text' => $row['v3'],'href'=>'#','selectable'=> $isselect,'state'=>array('checked'=>$ischeck,'showcheckbox'=>$showcheckbox),'tags'=>array('idpadre'=>$idPadre,'id'=>$row['v2'],'tipo'=>$row['v5']),'nodes'=>array());
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

	
	public function fn_cambiar_sede(){
		$iduser= $_SESSION['userActivo']->idusuario;
		$idsede=$this->input->post('txtidsede');
		$nombresede=$this->input->post('txtnomsede');
		
		$_SESSION['userActivo']->idsede=$idsede;
		$_SESSION['userActivo']->sede=$nombresede;
		$permisosv=$this->musuario->m_get_permisos_por_usuario_sede($iduser,$idsede);
		$vpermisos=array();
		foreach ($permisosv as $ps) {
			if ($ps->permitido='SI') $vpermisos[$ps->codaccion]= $ps->permitido;
		}
		$_SESSION['userPermisos']=$vpermisos;
		$dataex['status'] =TRUE;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	function getSubdominio($url) {

		$parsedUrl = parse_url($url);

		$host = explode('.', $parsedUrl['host']);


	    $output = array_shift($host);
	    if ($output === 'www') {
	        $output = array_shift($host_array);
	    }
	    return $output;
	}

	public function fn_get_notificaciones_x_user(){
		$dataex['status'] =FALSE;
		$iduser= $_SESSION['userActivo']->idusuario;
		$vpermisos=$this->musuario->m_notificaciones_x_user_ponervisto($iduser);
		$vpermisosc=array();
		$imax=count($vpermisos)-1;
		$subdominio=$this->getSubdominio(base_url()).".".getDominio();
		
		for ($i=$imax; $i>=0  ; $i--) { 

			$value=$vpermisos[$i];

			
			$subdominio_link=$this->getSubdominio($value->link).".".getDominio();

			$link = str_replace($subdominio_link, $subdominio, $value->link);

			$value->linkc=$link."/".base64url_encode($value->codmiembro);
			$vpermisosc[]=$value;
		}

		$_SESSION['userNotifica']=$vpermisosc;
		$dataex['status'] =TRUE;
		$dataex['notifica'] =$vpermisosc;
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_get_total_notifica_x_user(){
		$dataex['status'] =FALSE;
		$dataex['notificat'] =0;
		$acceso=(isset($_SESSION['islogin']))?$_SESSION['islogin']:NULL;
        if ($acceso==NULL){
           	$_SESSION["urlRedirect"]=current_url();
			redirect($this->ci->config->item('login_url'),'refresh');
        }
        else{
			$iduser= $_SESSION['userActivo']->idusuario;
			$vpermisos=$this->musuario->m_total_notifica_x_user($iduser);
			$_SESSION['userNotificaTotal']=$vpermisos;
			$dataex['status'] =TRUE;
			$dataex['notificat'] =$vpermisos;
        }
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}


	public function fn_login()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';

		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtuser','Usuario','trim|required|min_length[5]|max_length[20]');
			$this->form_validation->set_rules('txtclave','Contraseña','trim|required|min_length[5]|max_length[20]');
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
				$dataex['msg']="Usuario y/o contraseña incorrectos ";
				$usu=$this->input->post('txtuser');
				$cla=$this->input->post('txtclave');
				$arriniciar=$this->musuario->m_iniciar_sesion($usu ,$cla);
				$rpta=$arriniciar['login'];
				if (isset($rpta->codpersona))
				{	
					
                	$_SESSION['userNotificaTotal']=$arriniciar['notifica'];
                	
					$rpta->sedes=$arriniciar['sedes'];
					$existe=comprobarFoto('resources/fotos/' . $rpta->foto);
					if ($existe==FALSE)
					{
						$rpta->foto="gg/".$rpta->codpersona.".jpg";
						$existe=comprobarFoto('resources/fotos/' . $rpta->foto);
						if ($existe==FALSE)
						{
							$rpta->foto="user.png";
						}
					}
					$_SESSION['userActivo']=$rpta;
					if ($rpta->tipo=='AL'){
						$_SESSION['userDeudas']=$arriniciar['deudas'];
					}
					$vpermisos=array();
					foreach ($arriniciar['permisos'] as $ps) {
						if ($ps->permitido='SI') $vpermisos[$ps->codaccion]= $ps->permitido;
					}
					$_SESSION['userPermisos']=$vpermisos;
					//COMPROBAR NOTIFICACIONES DE MESA DE PARTES
					if (($rpta->tipo == 'AD') || ($rpta->tipo == 'DA')) {
	        			$_SESSION['userNotificaMP']=$this->musuario->m_get_notifica_mesapartes(getPermitido("68"));
	        			if ($_SESSION['userNotificaMP']==0){
	        				unset($_SESSION['userNotificaMP']);
	        			}
					}
					if (getPermitido("94") == "SI") {
						$_SESSION['userNotificaFC']=$this->musuario->m_get_notifica_facturacionERP();
	        			if ($_SESSION['userNotificaFC']==0){
	        				unset($_SESSION['userNotificaFC']);
	        			}
					}


					$_SESSION['islogin']=TRUE;
					if (isset($_SESSION["urlRedirect"]))
					{
						$urlRef=$_SESSION["urlRedirect"];
						unset($_SESSION["urlRedirect"]);
					}
					$dataex['status'] =TRUE;
					unset($dataex['msg']);
					$this->musuario->m_insert_acceso($rpta->codpersona);
				}
				else{
					$dataex['msg']=$arriniciar['error'].': '.$dataex['msg'];
				}
			}
		}
		$dataex['destino'] =$urlRef;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function logingoogle()
    {
    	$result = $this->db->query("SELECT  `ies_nombre` as nombre, `ies_gsuite_cid` as cid, `ies_gsuite_akey` as akey, `ies_gsuite_csc` as csc FROM `tb_institucion` LIMIT 1" );
        $gsuite=$result->row();

        require_once APPPATH . "libraries/google-api-php-client-2.2.2/vendor/autoload.php";
        include_once APPPATH . "libraries/google-api-php-client-2.2.2/src/Google/Client.php";
        include_once APPPATH . "libraries/google-api-php-client-2.2.2/src/Google/Service/OAuth2.php";
        $client_id      = base64_decode($gsuite->cid);//'966971632890-uquobi8aiddbmbd1cd3h31k3ndva01l8.apps.googleusercontent.com';
        $client_secret  =  base64_decode($gsuite->csc);//'qoeWKwP8MKHyIA3oIZlqQNSv';
        $redirect_uri   = base_url().'iniciar-con-google';
        $simple_api_key = base64_decode($gsuite->akey);//'AIzaSyCA8UiG7hQQdrtF7jADvRh3GxyF20Xv170';
        // Create Client Request to access Google API
        $client = new Google_Client();
        $client->setApplicationName("ERP ".$gsuite->nombre);
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        //
        $client->setAccessType("offline");
		$client->setApprovalPrompt("force"); 
		//
		$client->setPrompt('consent');
        $client->setRedirectUri($redirect_uri);
        $client->setDeveloperKey($simple_api_key);

		$dom=getDominio();
        $client->setHostedDomain($dom);
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        $client->addScope("https://www.googleapis.com/auth/calendar");
        $client->addScope("https://www.googleapis.com/auth/calendar.events");
        $client->addScope("https://www.googleapis.com/auth/gmail.send");
        

        // Send Client Request
        $objOAuthService = new Google_Service_Oauth2($client);
        // Add Access Token to Session
        //https://stackoverflow.com/questions/9241213/how-to-refresh-token-with-google-api-client
        if (isset($_GET['code'])) {
            //PRIMERA VEZ
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $_SESSION['refresh_token'] = $_SESSION['access_token']['refresh_token'];
            //header('Location: ' . filter_var(base_url(), FILTER_SANITIZE_URL));
            $client->setAccessToken($_SESSION['access_token']);
        }
        // Set Access Token to make Request
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);

        }
        // Get User Data from Google and store them in $data
        if ($client->getAccessToken()) {

        	$userData = $objOAuthService->userinfo->get();

            $data['userData'] = $userData;
            $mail             = $userData->email;
            $userfoto         = $userData->picture;
            $domain           = substr($mail, strpos($mail, '@'));
            //var_dump($domain);
            //if ($domain == "@".$dom) {
                $_SESSION['access_token'] = $client->getAccessToken();
                $arriniciar=$this->musuario->m_iniciar_sesion_google(array($userData->email));
                $rpta=$arriniciar['login'];
                
                if (isset($rpta->codpersona)){
                // de auqui
                	
                	$_SESSION['userNotificaTotal']=$arriniciar['notifica'];
                	
					$rpta->sedes=$arriniciar['sedes'];
					$existe=comprobarFoto('resources/fotos/' . $rpta->foto);
					if ($existe==FALSE)
					{
						$rpta->foto="gg/".$rpta->codpersona.".jpg";
						$existe=comprobarFoto('resources/fotos/' . $rpta->foto);
						if ($existe==FALSE)
						{
							$rpta->foto="user.png";
						}
					}
					$_SESSION['userActivo']=$rpta;
					
					if ($rpta->tipo=='AL')
					{
						$_SESSION['userDeudas']=$arriniciar['deudas'];
					}
					$vpermisos=array();
					foreach ($arriniciar['permisos'] as $ps) {
						if ($ps->permitido='SI') $vpermisos[$ps->codaccion]= $ps->permitido;
					}
					$_SESSION['userPermisos']=$vpermisos;
					$_SESSION['islogin']=TRUE;
					
					//COMPROBAR NOTIFICACIONES DE MESA DE PARTES
					if (($rpta->tipo == 'AD') || ($rpta->tipo == 'DA')) {
	        			$_SESSION['userNotificaMP']=$this->musuario->m_get_notifica_mesapartes(getPermitido("68"));
	        			if ($_SESSION['userNotificaMP']==0){
	        				unset($_SESSION['userNotificaMP']);
	        			}
					}
					//FIN COMPROBAR NOTIFICACIONES DE MESA DE PARTES
					if (getPermitido("94") == "SI") {
						$_SESSION['userNotificaFC']=$this->musuario->m_get_notifica_facturacionERP();
	        			if ($_SESSION['userNotificaFC']==0){
	        				unset($_SESSION['userNotificaFC']);
	        			}
					}
					if (isset($_SESSION["urlRedirect"]))
					{
						$urlRef=$_SESSION["urlRedirect"];
						unset($_SESSION["urlRedirect"]);
					}
					$this->musuario->m_insert_acceso($rpta->codpersona);
					header('Location: ' . filter_var(base_url(), FILTER_SANITIZE_URL));
                    exit();
               	// hasta aqui
                } else {
                    unset($_SESSION['access_token']);
                    $client = new Google_Client();
                    $objOAuthService = new Google_Service_Oauth2($client);
                    header('Location: ' . filter_var(base_url() . "iniciar-sesion?google=0&email=" . $userData->email, FILTER_SANITIZE_URL));
                    exit();
                }
            /*} else {
                unset($_SESSION['access_token']);
                $client = new Google_Client();
                $objOAuthService = new Google_Service_Oauth2($client);
                header('Location: ' . base_url() . "iniciar-sesion?google=1&email=" . $userData->email);
                exit();
            }*/
        } else {
            $authUrl         = $client->createAuthUrl();
            $data['authUrl'] = $authUrl;
            //redirect($authUrl, 'refresh');
            //echo $authUrl  ;
            header("Location: $authUrl");
			die();

        }
    }

	public function fn_logout()
    {
        unset($_SESSION['access_token']);
        session_destroy();
        redirect(base_url(), 'refresh');
    }

    public function fn_logout_gmail()
    {
        
        //
        $result = $this->db->query("SELECT  `ies_nombre` as nombre, `ies_gsuite_cid` as cid, `ies_gsuite_akey` as akey, `ies_gsuite_csc` as csc FROM `tb_institucion` LIMIT 1" );
        $gsuite=$result->row();

        require_once APPPATH . "libraries/google-api-php-client-2.2.2/vendor/autoload.php";
        include_once APPPATH . "libraries/google-api-php-client-2.2.2/src/Google/Client.php";
        include_once APPPATH . "libraries/google-api-php-client-2.2.2/src/Google/Service/OAuth2.php";
        $client_id      = base64_decode($gsuite->cid);//'966971632890-uquobi8aiddbmbd1cd3h31k3ndva01l8.apps.googleusercontent.com';
        $client_secret  =  base64_decode($gsuite->csc);//'qoeWKwP8MKHyIA3oIZlqQNSv';
        $redirect_uri   = base_url().'iniciar-con-google';
        $simple_api_key = base64_decode($gsuite->akey);//'AIzaSyCA8UiG7hQQdrtF7jADvRh3GxyF20Xv170';
        $client = new Google_Client();
        $client->setApplicationName("ERP ".$gsuite->nombre);
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        //
        $client->setAccessType("offline");
		$client->setApprovalPrompt("force"); 
		//
        $client->setRedirectUri($redirect_uri);
        $client->setDeveloperKey($simple_api_key);

		$dom=getDominio();
        $client->setHostedDomain($dom);
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        $client->addScope("https://www.googleapis.com/auth/calendar");
        $client->addScope("https://www.googleapis.com/auth/calendar.events");

        // Send Client Request
        $objOAuthService = new Google_Service_Oauth2($client);
		if (isset($_GET['code'])) {
		    $client->authenticate($_GET['code']);
		    $_SESSION['access_token'] = $client->getAccessToken();
		    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		    return;
		}

		if (isset($_SESSION['token'])) {
		    $client->setAccessToken($_SESSION['access_token']);
		}

		
		unset($_SESSION['access_token']);
        unset($_SESSION['userActivo']);
		unset($_SESSION['userPermisos']);
		unset($_SESSION['islogin']);
		$client->revokeToken();
        session_destroy();
		$this->load->view('logoutgmail');
		
        //
        //header('Location: ' . filter_var('https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue='. base_url(), FILTER_SANITIZE_URL));
        //redirect(base_url(),'refresh');

    }


   

}


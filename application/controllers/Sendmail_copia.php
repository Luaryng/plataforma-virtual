<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sendmail extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("email");
	}

	public function vw_ver()
    {
        $this->load->view('emails/vw_notificacion_aula');
    }

	public function f_enviar_sugerencia()
    {
        $this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_es_cbdestino','Destino','trim|required');
			$this->form_validation->set_rules('vw_es_mensaje','Mensaje','trim|required');
			$this->form_validation->set_rules('vw_es_asunto','Mensaje','trim|required');

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
				$vuser=$_SESSION['userActivo'];
				$correo_destino=base64url_decode($this->input->post('vw_es_cbdestino'));
				$asunto=$this->input->post('vw_es_asunto');
				$mensaje=$this->input->post('vw_es_mensaje');
				 //f_sendmail_responder_a($envia,$destino,$responder_a,$asunto,$mensaje,)
				$enviador=array($vuser->ecorporativo,$vuser->paterno." ".$vuser->materno." ".$vuser->nombres);
				$rsp=$this->f_sendmail_responder_a($enviador,$correo_destino,$enviador,$asunto,$mensaje);
				$dataex['status']=$rsp['estado'];
				$dataex['mensaje']=$rsp['mensaje'];
				
			}

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
    }

    public function f_notificaciones_aula_virtual()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que Intentas?.';
        //if ($this->input->is_ajax_request()) {
            $dataex['msg'] = "Ocurrio un error al intentar notificar</a>";
            $this->load->model('miestp');
        	$iestp=$this->miestp->m_get_datos();
            $this->load->model('mnotificaciones');
            $notifica=$this->mnotificaciones->m_get_notificaciones_sin_enviar_email();
            if (count($notifica)>0){
	            $notis_x_user=array();
	            $user=0;
	            $notis_x_users=array();
	            $notis_x_user = new stdClass;
	            foreach ($notifica as $key => $noti) {
	            	if ($user!=$noti->codusuario){
	            		$notis_x_user = new stdClass;
	            		$notis_x_users[]=$notis_x_user;
	            		$user=$noti->codusuario;
	            		$notis_x_user->codusuario=$noti->codusuario;
	            		$notis_x_user->ecorporativo=$noti->ecorporativo;
	            		$notis_x_user->link=$noti->link;
	            	}
	            	$notis_x_user->notificaciones[]=$noti;
	            }
	            $count=0;
	            foreach ($notis_x_users as $key => $notuser) {
		            $mensaje       = $this->load->view('emails/vw_notificacion_aula', array('mensajes' => $notuser,'ies'=> $iestp ),true);
		            $correo_destino=$notuser->ecorporativo;
		            $nombre_remitente="IESTWEB Plataforma Virtual";
		            $correo_remitente="notificaciones@".getDominio();
		            $totaln=count($notuser->notificaciones);
		            $texto=($totaln==1) ? "1 notificación nueva":"$totaln notificaciones nuevas";
		            $rsp=$this->fsendmail($correo_destino,"Tienes $texto en tu Aula Virtual",$correo_remitente,$nombre_remitente,$mensaje);
		            if($rsp['estado']==true){
		                $this->mnotificaciones->m_set_estado_envio_mail_notifica_x_user(array('ENVIADO',$notuser->codusuario));
		            }
		            else{
		                $this->mnotificaciones->m_set_estado_envio_mail_notifica_x_user(array('ERROR',$notuser->codusuario));
		            }

		           	$count++;
			    	if(($count%10)==0)
			    	{
			        	sleep(5);
				    }
		            //echo $rsp['mensaje'];
	            }
        	}
            exit();
            //echo $resultado['msg'];
            //header('Content-Type: application/x-json; charset=utf-8');
            //echo(json_encode($resultado));
        //}
    }

	public function fsendmail($correo_destino,$asunto,$correo_envia,$nombre_envia,$mensaje){
		//configuracion para gmail
		$v=true;
		$rps['estado']=false;
		$rps['mensaje']='Error de envío';
		$variables=array($correo_destino,$nombre_envia,$mensaje);
		foreach ($variables as $variable){
			if (empty($variable)) $v=false;
		}
		if ($v){
			foreach ($variables as $variable){
				if (trim($variable)=="") $v=false;
			}
			if ($v){
				//cargamos la configuración para enviar con gmail
				$configMail = array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_crypto'=> 'ssl',
				'smtp_user' => 'notificaciones@'.getDominio(),
				'smtp_pass' => '@4L3XanD3r42l6',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'validation' => true,
				'smtp_timeout' => '4',
				'newline' => "\r\n"
				);
				$this->email->initialize($configMail);

				$this->email->from($correo_envia, $nombre_envia);
				$this->email->to($correo_destino);
				$this->email->subject($asunto);
				$this->email->message($mensaje);
				//$this->email->AddReplyTo("soportesirecase@gmail.com", "SIRECASE | Soporte");
				//Enviamos el email
				if($this->email->send()){
					$rps['estado']=true; //se envio correctamente
				}
				else{
					$rps['estado']=false; // no se envio
				}
				$rps['mensaje']=$this->email->print_debugger();
			}
		}
		
		return $rps;
	}

	public function f_sendmail_responder_a($envia,$destino,$responder_a,$asunto,$mensaje){
		//configuracion para gmail
		$v=true;
		$rps['estado']=false;
		$rps['mensaje']='Error de envío';
		$variables=array($envia[0], $envia[1],$responder_a[0], $responder_a[1],$mensaje,$asunto);
		foreach ($variables as $variable){
			if (empty($variable)) $v=false;
		}
		if ($v){
			foreach ($variables as $variable){
				if (trim($variable)=="") $v=false;
			}
			if ($v){
				//cargamos la configuración para enviar con gmail
				$configMail = array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_crypto'=> 'ssl',
				'smtp_user' => 'notificaciones@'.getDominio(),
				'smtp_pass' => '@4L3XanD3r42l6',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'validation' => true,
				'smtp_timeout' => '4',
				'newline' => "\r\n"
				);
				$this->email->initialize($configMail);


				$this->email->from($envia[0], $envia[1]);
				$this->email->to($destino);
				$this->email->subject($asunto);
				$this->email->message($mensaje);
				$this->email->reply_to($responder_a[0], $responder_a[1]);
				//Enviamos el email
				if($this->email->send()){
					$rps['estado']=true; //se envio correctamente
				}
				else{
					$rps['estado']=false; // no se envio
				}
				$rps['mensaje']=$this->email->print_debugger();
			}
		}
		
		return $rps;
	}


	public function f_sendmail_adjuntos($array_enviador,$destinos,$asunto,$mensaje,$array_adjuntos,$array_responder_a=array()){
		//configuracion para gmail
		$v=true;
		$rps['estado']=false;
		$rps['mensaje']='Error de envío';
		$variables=array($array_enviador[0], $array_enviador[1],$mensaje,$asunto);
		foreach ($variables as $variable){
			if (empty($variable)) $v=false;
		}
		if ($v){
			foreach ($variables as $variable){
				if (trim($variable)=="") $v=false;
			}
			if ($v){
				//cargamos la configuración para enviar con gmail
				$configMail = array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_crypto'=> 'ssl',
				'smtp_user' => 'notificaciones@'.getDominio(),
				'smtp_pass' => '@4L3XanD3r42l6',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'validation' => true,
				'smtp_timeout' => '4',
				'newline' => "\r\n"
				);
				$this->email->initialize($configMail);


				$this->email->from($array_enviador[0], $array_enviador[1]);
				$this->email->bcc($destinos);
				$this->email->subject($asunto);
				$this->email->message($mensaje);
				if (isset($array_responder_a[0])) {
					$this->email->reply_to($array_responder_a[0], $array_responder_a[1]);
				}
				foreach ($array_adjuntos as $key => $adj) {
					if (count($adj)==4){
						$this->email->attach($adj[0],$adj[1],$adj[2],$adj[3]);
					}
					else{
						$this->email->attach($adj[0],$adj[1],$adj[2]);
					}
						
				}
				
				//Enviamos el email
				if($this->email->send()){
					$rps['estado']=true; //se envio correctamente
				}
				else{
					$rps['estado']=false; // no se envio
				}
				$rps['mensaje']=$this->email->print_debugger();
			}
		}
		
		return $rps;
	}

	public function f_sendmail_completo($array_enviador,$destinos,$destinos_copia,$destinos_oculto,$asunto,$mensaje,$array_adjuntos,$array_responder_a=array()){
		//configuracion para gmail
		$v=true;
		$rps['estado']=false;
		$rps['mensaje']='Error de envío';
		$variables=array($array_enviador[0], $array_enviador[1],$mensaje,$asunto);
		foreach ($variables as $variable){
			if (empty($variable)) $v=false;
		}
		if ($v){
			foreach ($variables as $variable){
				if (trim($variable)=="") $v=false;
			}
			if ($v){
				//cargamos la configuración para enviar con gmail
				$configMail = array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_crypto'=> 'ssl',
				'smtp_user' => 'notificaciones@'.getDominio(),
				'smtp_pass' => '@4L3XanD3r42l6',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'validation' => true,
				'smtp_timeout' => '4',
				'newline' => "\r\n"
				);
				$this->email->initialize($configMail);


				$this->email->from($array_enviador[0], $array_enviador[1]);
				$this->email->to($destinos);
				if (isset($destinos_copia[0])) {
					$this->email->cc($destinos_copia);
				}
				if (isset($destinos_oculto[0])) {
					$this->email->bcc($destinos_oculto);
				}
				$this->email->subject($asunto);
				$this->email->message($mensaje);
				
				if (isset($array_responder_a[0])) {
					$this->email->reply_to($array_responder_a[0], $array_responder_a[1]);
				}
				foreach ($array_adjuntos as $key => $adj) {
					if (count($adj)==4){
						$this->email->attach($adj[0],$adj[1],$adj[2],$adj[3]);
					}
					else{
						$this->email->attach($adj[0],$adj[1],$adj[2]);
					}
						
				}
				
				//Enviamos el email
				if($this->email->send()){
					$rps['estado']=true; //se envio correctamente
				}
				else{
					$rps['estado']=false; // no se envio
				}
				$rps['mensaje']=$this->email->print_debugger();
				$this->email->clear(TRUE);
			}
		}
		
		return $rps;
	}

}
?>
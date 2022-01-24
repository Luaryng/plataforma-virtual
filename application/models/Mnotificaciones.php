<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mnotificaciones extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_total_notificaciones(){
    	$rsntf=$this->db->query("SELECT 
						  COUNT(not_id) AS total
						FROM
						  tb_notifica_usuario
						WHERE
						  usu_id = ? AND 
						  nous_vista = 'NO'",array($rslogin->idusuario));
		$rsnotifica=$rsntf->row()->total;
    }

    public function m_get_notificaciones_sin_enviar_email(){
    	$rsntf=$this->db->query("SELECT 
		  tb_notificaciones.not_detalle AS detalle,
		  tb_notificaciones.not_link AS link,
		  tb_notifica_usuario.usu_id AS codusuario,
		  tb_notifica_usuario.nous_codmiembro as codmiembro,
		  tb_notificaciones.not_fecha_creacion AS creado,
		  tb_usuario.usu_email_corporativo as ecorporativo,
		  tb_notifica_usuario.not_id as codnotifica
		  
		FROM
		  tb_notificaciones
		  INNER JOIN tb_notifica_usuario ON (tb_notificaciones.not_id = tb_notifica_usuario.not_id)
		  INNER JOIN tb_usuario ON (tb_notifica_usuario.usu_id = tb_usuario.id_usuario)
		WHERE
		  tb_notifica_usuario.nous_estado <> 'ENVIADO' AND nous_vista = 'NO'
		ORDER BY
		  codusuario,
		  creado  LIMIT 50");
		return $rsntf->result();
    }



	public function m_set_estado_envio_mail_notifica_x_user($data){
    	$rsntf=$this->db->query("UPDATE `tb_notifica_usuario`  SET `nous_estado` = ?, `nous_fecha_estado` = now()
 			WHERE  `usu_id` = ? ;",$data);
		
    }
    public function m_set_estado_envio_mail_notifica_x_notifica($data){
    	$rsntf=$this->db->query("UPDATE `tb_notifica_usuario`  SET `nous_estado` = ?, `nous_fecha_estado` = now()
 			WHERE  `usu_id` = ? AND not_id=?;",$data);
		
    }
    


}
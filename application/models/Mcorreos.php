<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mcorreos extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    

    /*public function mInsert_datos_correo($items)
    {
        $this->db->query("CALL `sp_tb_mesa_partes_correos`(?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return $res->row();    
    }

    public function mData_correos()
    {
        $result = $this->db->query("SELECT 
          tb_mesa_partes_correos.mpc_id as id,
          tb_mesa_partes_correos.mpt_id as codruta,
          tb_mesa_partes_correos.mpc_correo_envia as cenvia,
          tb_mesa_partes_correos.mpc_correo_destino as cdestino,
          tb_mesa_partes_correos.mpc_asunto as asunto,
          tb_mesa_partes_correos.mpc_mensaje as mensaje,
          tb_mesa_partes_correos.mpc_estado_tramite as trestado,
          tb_mesa_partes_correos.mpc_adjuntos as adjuntos,
          tb_mesa_partes_correos.mpc_responder as cresponder,
          tb_mesa_partes_correos.mpc_observacion as observacion,
          tb_mesa_partes_correos.mpc_enviado as estado,
          tb_mesa_partes_correos.mpc_fecha_hora_envio as henvio,
          tb_mesa_partes_correos.mpc_mensaje_error as merror,
          tb_mesa_partes_correos.mpc_creado as fecha,
          tb_mesa_partes_correos.mpc_tabla AS tabla
        FROM
          tb_mesa_partes_correos
        WHERE
          tb_mesa_partes_correos.mpc_enviado = 'NO' and tb_mesa_partes_correos.mpc_intentos < 4 
        LIMIT 10");
        
        return $result->result();    
    }

    public function mUpdate_items_correos($data)
    {
        $result = $this->db->query("UPDATE
          tb_mesa_partes_correos SET mpc_enviado = ?, mpc_fecha_hora_envio = ?, mpc_mensaje_error = ?, mpc_intentos = mpc_intentos + 1
          WHERE mpc_id = ? ", $data);
        return 1;    
    }*/

    // ================================
    // FUNCIONES CORREO NOTIFICACIONES
    // ================================

    public function mInsert_correo_notificaciones($items)
    {
        $this->db->query("CALL `sp_tb_correo_notificaciones_insert`(?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return $res->row();    
    }

    public function mData_correos_notificaciones()
    {
        $result = $this->db->query("SELECT 
          tb_correo_notificaciones.cntf_id as id,
          tb_correo_notificaciones.mpt_id as codruta,
          tb_correo_notificaciones.cntf_correo_envia as cenvia,
          tb_correo_notificaciones.cntf_correo_destino as cdestino,
          tb_correo_notificaciones.cntf_destino_copia AS descopia,
          tb_correo_notificaciones.cntf_destino_oculto AS desoculto,
          tb_correo_notificaciones.cntf_asunto as asunto,
          tb_correo_notificaciones.cntf_mensaje as mensaje,
          tb_correo_notificaciones.cntf_estado_tramite as trestado,
          tb_correo_notificaciones.cntf_adjuntos as adjuntos,
          tb_correo_notificaciones.cntf_responder as cresponder,
          tb_correo_notificaciones.cntf_observacion as observacion,
          tb_correo_notificaciones.cntf_enviado as estado,
          tb_correo_notificaciones.cntf_fecha_hora_envio as henvio,
          tb_correo_notificaciones.cntf_mensaje_error as merror,
          tb_correo_notificaciones.cntf_intentos AS intentos,
          tb_correo_notificaciones.cntf_tabla AS tabla,
          tb_correo_notificaciones.cntf_creado as fecha
        FROM
          tb_correo_notificaciones
        WHERE
          tb_correo_notificaciones.cntf_enviado = 'NO' and tb_correo_notificaciones.cntf_intentos < 4 
        LIMIT 10");
        
        return $result->result();    
    }

    public function mUpdate_items_correos_notificaciones($data)
    {
        $result = $this->db->query("UPDATE
          tb_correo_notificaciones SET cntf_enviado = ?, cntf_fecha_hora_envio = ?, cntf_mensaje_error = ?, cntf_intentos = cntf_intentos + 1
          WHERE cntf_id = ? ", $data);
        return 1;    
    }


}


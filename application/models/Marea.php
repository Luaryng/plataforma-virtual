<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Marea extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_areas($sede)
    {
        $result = $this->db->query("SELECT 
          tb_area.are_codigo as codigo,
          tb_area.are_nombre as nombre,
          tb_area.are_activo as activo,
          tb_area.cod_sede as codsede,
          tb_area.are_encargado as codencargado,
          tb_area.are_correo as correo
        FROM
          tb_area
          WHERE tb_area.cod_sede = ?
        ORDER BY  tb_area.are_nombre ASC ", $sede);

        return $result->result();
    }

    public function m_get_areas_activas($sede)
    {
        $result = $this->db->query("SELECT 
          tb_area.are_codigo as codarea,
          tb_area.are_nombre as nombre,
          tb_area.are_activo as activo,
          tb_area.cod_sede as codsede,
          tb_area.are_encargado as codencargado,
          tb_area.are_correo as correo
        FROM
          tb_area
          WHERE tb_area.cod_sede = ? AND tb_area.are_activo='SI' 
        ORDER BY  tb_area.are_nombre ASC ", $sede);

        return $result->result();
    }

    public function m_filtrar_area($sede)
    {
        $result = $this->db->query("SELECT 
          tb_area.are_codigo AS codigo,
          tb_area.are_nombre AS nombre,
          tb_area.are_activo AS estado,
          tb_area.are_encargado AS encargado,
          CONCAT(tb_persona.per_apel_paterno,' ',
              tb_persona.per_apel_materno,' ',
              tb_persona.per_nombres) nombres,
          tb_area.are_correo AS correo
        FROM
          tb_area
          LEFT OUTER JOIN tb_docente ON (tb_area.are_encargado = tb_docente.doc_codigo) 
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo) 
          WHERE tb_area.cod_sede = ?
        ORDER BY  tb_area.are_nombre ASC ", $sede);

        return $result->result();
    }

    public function mInsert_area($items)
    {
        $this->db->query("CALL `sp_tb_area_insert`(?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }

    public function mUpdate_area($items)
    {
        $this->db->query("CALL `sp_tb_area_update`(?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_filtrar_areaxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_area.are_codigo AS codigo,
          tb_area.are_nombre AS nombre,
          tb_area.are_activo AS estado,
          tb_area.are_encargado AS encargado,
          tb_area.are_correo AS correo
        FROM
          tb_area
        WHERE tb_area.are_codigo = ? LIMIT 1 ", $codigo);

        return $result->row();
    }

    public function m_eliminaarea($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_area where are_codigo = ? ", $codigo);
        
        return 1;
    }

    public function m_get_areasxnombre($data)
    {
        $result = $this->db->query("SELECT 
          tb_area.are_codigo AS codigo,
          tb_area.are_nombre AS nombre,
          tb_area.are_activo AS estado,
          tb_area.are_encargado AS encargado,
          CONCAT(tb_persona.per_apel_paterno,' ',
              tb_persona.per_apel_materno,' ',
              tb_persona.per_nombres) nombres,
          tb_area.are_correo AS correo
        FROM
          tb_area
          LEFT OUTER JOIN tb_docente ON (tb_area.are_encargado = tb_docente.doc_codigo) 
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo) 
          WHERE tb_area.are_nombre like ? AND tb_area.cod_sede = ?
        ORDER BY  tb_area.are_nombre ASC ", $data);

        return $result->result();
    }


}


<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mconvocatorias_tipo extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_items_convt()
    {
        $result = $this->db->query("SELECT 
        `cvt_id` as codigo,
        `cvt_nombre` as nombre,
        `cvt_activo` as activo,
        `cvt_creado` as creado

      FROM 
        `tb_convocatorias_tipo` 
      ORDER BY cvt_creado DESC");
      return $result->result();
    }

    public function m_get_items_convt_Activo()
    {
        $result = $this->db->query("SELECT 
        `cvt_id` as codigo,
        `cvt_nombre` as nombre,
        `cvt_activo` as activo,
        `cvt_creado` as creado

      FROM 
        `tb_convocatorias_tipo` 
      WHERE cvt_activo = 'SI'
      ORDER BY cvt_creado DESC");
      return $result->result();
    }

    public function m_insert_convt($data){
      
       $this->db->query("CALL `sp_tb_convocatoria_tipo_insert`(?,?,@s,@nid)", $data);
       
      $res = $this->db->query('select @s as salida, @nid as nid');
      return   $res->row(); 
    }

    public function m_update_convt($data){
      $this->db->query("CALL `sp_tb_convocatorias_tipo_update`(?,?,?,@s)", $data);
      $res = $this->db->query('select @s as salida');
      return   $res->row(); 
    }

    public function m_get_items_cont_id($data)
    {
        $result = $this->db->query("SELECT 
        `cvt_id` as codigo,
        `cvt_nombre` as nombre,
        `cvt_activo` as activo,
        `cvt_creado` as creado

      FROM 
        `tb_convocatorias_tipo` 
      WHERE cvt_id = ? ", $data);
      return $result->row();
    }

    public function m_delete_convt($data){
      $this->db->query("DELETE FROM `tb_convocatorias_tipo`  WHERE  `cvt_id` = ?", $data);
      return $this->db->affected_rows();
    } 


}
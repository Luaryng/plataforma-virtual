<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mconvocatorias extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_items_conv()
    {
        $result = $this->db->query("SELECT 
        `cnv_id` as codigo,
        `cnv_titulo` as titulo,
        `cnv_detalle` as detalle,
        `cnv_resumen` as resumen,
        `cnv_tipo` as tipoid,
        `cvt_nombre` as tipo,
        `cnv_anio` as anio,
        `cnv_creado` as creado,
        `cnv_estado` as estado,
        `cnv_publicado` as publicado

      FROM 
        `tb_convocatorias` 
      INNER JOIN tb_convocatorias_tipo ON(tb_convocatorias_tipo.cvt_id = tb_convocatorias.cnv_tipo)
      ORDER BY cnv_creado DESC");
      return $result->result();
    }

    public function m_insert_conv($data){
      
       $this->db->query("CALL `sp_tb_convocatorias_insert`(?,?,?,?,?,?,?,@s,@nid)", $data);
       
      $res = $this->db->query('select @s as salida, @nid as nid');
      return   $res->row(); 
    }

    public function m_update_conv($data){
      $this->db->query("CALL `sp_tb_convocatorias_update`(?,?,?,?,?,?,?,?,@s)", $data);
      $res = $this->db->query('select @s as salida');
      return   $res->row(); 
    }

    public function m_insert_detalle_conv($data){
      $this->db->query("CALL `sp_tb_convocatoria_detalle_insert`(?,?,?,?,?,?,@s,@nid)", $data);
      $res = $this->db->query('select @s as salida, @nid as nid');
      return   $res->row(); 
    }

    public function m_get_items_con_id($data)
    {
        $result = $this->db->query("SELECT 
        `cnv_id` as codigo,
        `cnv_titulo` as titulo,
        `cnv_detalle` as detalle,
        `cnv_resumen` as resumen,
        `cnv_tipo` as tipo,
        `cnv_anio` as anio,
        `cnv_creado` as creado,
        `cnv_estado` as estado,
        `cnv_publicado` as publicado

      FROM 
        `tb_convocatorias` 
      WHERE cnv_id = ? ", $data);
      return $result->row();
    }

    public function m_get_con_archivos($data)
    {
        $result = $this->db->query("SELECT 
        `cvd_id` as coddetalle,
        `cnv_id` as cpadre,
        `cvd_titulo` as titulo,
        `cvd_archivo` as archivo,
        `cvd_ruta` as ruta,
        `cvd_peso` as peso,
        `cvd_tipo` as tipo,
        `cvd_creado` as dcreado

      FROM 
        `tb_convocatoria_detalle` 
      WHERE cnv_id = ? ",$data);
        return $result->result();
    }

    public function m_get_con_archivosxcodigo($data)
    {
        $result = $this->db->query("SELECT 
        `cvd_id` as coddetalle,
        `cnv_id` as cpadre,
        `cvd_titulo` as titulo,
        `cvd_archivo` as archivo,
        `cvd_ruta` as ruta,
        `cvd_peso` as peso,
        `cvd_tipo` as tipo,
        `cvd_creado` as dcreado

      FROM 
        `tb_convocatoria_detalle` 
      WHERE cvd_id = ? ",$data);
        return $result->row();
    }

    public function m_delete_detalle($data){
      $this->db->query("DELETE FROM  `tb_convocatoria_detalle` WHERE  `cvd_id` = ?", $data);
      return $this->db->affected_rows();
      
    }


    public function m_delete_conv($data){
      $this->db->query("DELETE FROM `tb_convocatorias`  WHERE  `cnv_id` = ?", $data);
      return $this->db->affected_rows();
    } 


}
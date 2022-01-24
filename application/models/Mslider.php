<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mslider extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function mInsert_slider($items)
    {
        $this->db->query("CALL `sp_tb_slider_insert`(?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }

    public function mUpdate_slider($items)
    {
        $this->db->query("CALL `sp_tb_slider_update`(?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_slider()
    {
        $result = $this->db->query("SELECT 
            tb_slider.sld_id id,
            tb_slider.sld_imagen imagen,
            tb_slider.sld_activo activo,
            tb_slider.sld_orden orden,
            tb_slider.sld_registro fecha
          FROM
            tb_slider 
          ORDER BY sld_id ");
        return $result->result();
    }

    public function m_slider_orden()
    {
        $result = $this->db->query("SELECT 
            MAX(tb_slider.sld_orden) orden
          FROM
            tb_slider 
          ORDER BY sld_id LIMIT 1");
        return $result->row();
    }


    public function m_sliderxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
            tb_slider.sld_id id,
            tb_slider.sld_imagen imagen,
            tb_slider.sld_activo activo,
            tb_slider.sld_orden orden,
            tb_slider.sld_registro fecha
          FROM
            tb_slider 
          WHERE sld_id = ? LIMIT 1 ", $codigo);
        return $result->row();
    }

    public function m_ordenar_slide($datainsert){
      foreach ($datainsert as $key => $data) {
        $this->db->query("UPDATE `tb_slider`  SET `sld_orden` = ? WHERE  `sld_id` = ?", $data);
      }
      return true;
    }

    public function m_eliminaslider($codigo)
    {
        // $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_slider where sld_id = ? ", $codigo);
        // $this->db->close();
        return 1;
    }

}
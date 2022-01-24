<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbanner extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function mInsert_banner($items)
    {
        $this->db->query("CALL `sp_tb_banner_insert`(?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }

    public function mUpdate_banner($items)
    {
        $this->db->query("CALL `sp_tb_banner_update`(?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_banner()
    {
        $result = $this->db->query("SELECT 
            tb_banner.bnr_id id,
            tb_banner.bnr_titulo titulo,
            tb_banner.bnr_descripcion descripcion,
            tb_banner.bnr_boton statboton,
            tb_banner.bnr_text_boton boton,
            tb_banner.bnr_url_boton urlb,
            tb_banner.bnr_imagen imagen,
            tb_banner.bnr_estado estado,
            tb_banner.bnr_fecha fecha
          FROM
            tb_banner 
          WHERE bnr_estado = 'SI' ORDER BY bnr_id ");
        return $result->result();
    }

    public function m_dtsbanner()
    {
        $result = $this->db->query("SELECT 
            tb_banner.bnr_id id,
            tb_banner.bnr_titulo titulo,
            tb_banner.bnr_descripcion descripcion,
            tb_banner.bnr_boton statboton,
            tb_banner.bnr_text_boton boton,
            tb_banner.bnr_url_boton urlb,
            tb_banner.bnr_imagen imagen,
            tb_banner.bnr_estado estado,
            tb_banner.bnr_fecha fecha
          FROM
            tb_banner 
          ORDER BY bnr_id ");
        return $result->result();
    }

    public function m_bannerxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
            tb_banner.bnr_id id,
            tb_banner.bnr_titulo titulo,
            tb_banner.bnr_descripcion descripcion,
            tb_banner.bnr_boton statboton,
            tb_banner.bnr_text_boton boton,
            tb_banner.bnr_url_boton urlb,
            tb_banner.bnr_imagen imagen,
            tb_banner.bnr_estado estado,
            tb_banner.bnr_fecha fecha
          FROM
            tb_banner 
          WHERE bnr_id = ? LIMIT 1 ", $codigo);
        return $result->row();
    }

    public function m_captura_imgxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
            tb_banner.bnr_imagen imagen
          FROM
            tb_banner
          WHERE
            tb_banner.bnr_id = ? LIMIT 1", $codigo);
        return $result->row();
    }

    public function m_eliminabanner($codigo)
    {
        // $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_banner where bnr_id = ? ", $codigo);
        // $this->db->close();
        return 1;
    }

}
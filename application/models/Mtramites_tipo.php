<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtramites_tipo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_tramites_tipos()
    {
        $result = $this->db->query("SELECT 
          tb_tramites_tipos.tmt_id  as codigo,
          tb_tramites_tipos.tmt_nombre as nombre,
          tb_tramites_tipos.tmt_eliminado as eliminado
        FROM
          tb_tramites_tipos
        ORDER BY  tb_tramites_tipos.tmt_nombre ASC ");

        return $result->result();
    }


    public function mInsert_tipos($items)
    {
        $this->db->query("CALL `sp_tb_tramites_tipos_insert`(?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }

    public function mUpdate_tipos($items)
    {
        $this->db->query("CALL `sp_tb_tramites_tipos_update`(?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_filtrar_itemxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_tramites_tipos.tmt_id  as codigo,
          tb_tramites_tipos.tmt_nombre as nombre,
          tb_tramites_tipos.tmt_eliminado as eliminado
        FROM
          tb_tramites_tipos
        WHERE tb_tramites_tipos.tmt_id = ? LIMIT 1 ", $codigo);

        return $result->row();
    }

    public function m_eliminaitem($data)
    {
        
        $qry = $this->db->query("UPDATE tb_tramites_tipos SET tmt_eliminado = ? WHERE tmt_id = ? ", $data);
        // $qry = $this->db->query("DELETE FROM tb_tramites_tipos WHERE tmt_id = ? ", $codigo);
        
        return 1;
    }

    public function m_get_tramites_tiposxnombre($data)
    {
        $result = $this->db->query("SELECT 
          tb_tramites_tipos.tmt_id  as codigo,
          tb_tramites_tipos.tmt_nombre as nombre,
          tb_tramites_tipos.tmt_eliminado as eliminado
        FROM
          tb_tramites_tipos
        WHERE tb_tramites_tipos.tmt_nombre like ?
        ORDER BY  tb_tramites_tipos.tmt_nombre ASC ", $data);

        return $result->result();
    }


}


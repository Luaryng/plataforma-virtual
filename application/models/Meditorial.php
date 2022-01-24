<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meditorial extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert_datos_editorial($data){

        $this->db->query("CALL `sp_tb_editorial_insert`(?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_editorialxnombre($nomed)
    {
		$result = $this->db->query("SELECT
    		  tb_editorial.edi_id as id,
    		  tb_editorial.edi_nombre as nombre
    		FROM 
    		  tb_editorial
    		WHERE
    		  tb_editorial.edi_nombre like ?
    		ORDER BY tb_editorial.edi_nombre ASC", $nomed);
        
        return $result->result();
    }

    public function m_editorialxcodigo($coded)
    {
        $rsedit = array();
        $result = $this->db->query("SELECT
              tb_editorial.edi_id as id,
              tb_editorial.edi_nombre as nombre
            FROM 
              tb_editorial
            WHERE
              tb_editorial.edi_id = ? ", $coded);
        
        $rsedit = $result->row();
        return array('deditorial' => $rsedit);
    }

    public function update_datos_editorial($data){

        $this->db->query("CALL `sp_tb_editorial_update`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_elimina_editorial($idedit)
    {
        $qry = $this->db->query("DELETE FROM tb_editorial where edi_id=?", $idedit);
        $this->db->close();
        return 1;
    }
}
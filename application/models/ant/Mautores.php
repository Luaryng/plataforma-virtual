<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mautores extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert_datos_autores($data){

        $this->db->query("CALL `sp_tb_autores_insert`(?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_autoresxnombre($nomaut)
    {
    	if ($nomaut != "") {
    		$result = $this->db->query("SELECT
        		  tb_autores.aut_id as id,
        		  tb_autores.aut_nombre as nombre
        		FROM 
        		  tb_autores
        		WHERE
        		  tb_autores.aut_nombre like ?
        		ORDER BY tb_autores.aut_nombre ASC", $nomaut);
    	} else if ($nomaut == "") {
    		$result = $this->db->query("SELECT
        		  tb_autores.aut_id as id,
        		  tb_autores.aut_nombre as nombre
        		FROM 
        		  tb_autores
        		ORDER BY tb_autores.aut_nombre ASC");
    	}
        
        return $result->result();
    }

    public function m_autoresxcodigo($coded)
    {
        $result = $this->db->query("SELECT
              tb_autores.aut_id as id,
              tb_autores.aut_nombre as nombre
            FROM 
              tb_autores
            WHERE
              tb_autores.aut_id = ? ", $coded);
        
        return $result->result();
    }

    public function update_datos_autores($data){

        $this->db->query("CALL `sp_tb_autores_update`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_elimina_autores($idautor)
    {
        $qry = $this->db->query("DELETE FROM tb_autores where aut_id=?", $idautor);
        $this->db->close();
        return 1;
    }
}
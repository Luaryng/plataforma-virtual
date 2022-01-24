<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpublicidad extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_publicidades()
    {
        $result = $this->db->query("SELECT 
          tb_publicidad.pb_id as codigo,
          tb_publicidad.pb_nombre as nombre
        FROM
          tb_publicidad
        ORDER BY tb_publicidad.pb_nombre ASC ");

        return $result->result();
    }

    public function mInsert_inscrit_publicidad($items)
    {   
        $this->db->query("CALL `sp_tb_inscripcion_publicidad_insert`(?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return $res->row();    
    }


}


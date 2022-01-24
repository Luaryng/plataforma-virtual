<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpracticas_modalidad extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_modalidadxnombre($data)
    {
        $result = $this->db->query("SELECT 
          tb_practica_modalidad.pm_id as codigo,
          tb_practica_modalidad.pm_nombre as nombre
        FROM
          tb_practica_modalidad
          WHERE tb_practica_modalidad.pm_nombre LIKE ?
        ORDER BY tb_practica_modalidad.pm_nombre ASC ", $data);
        return $result->result();
    }

    public function mInsert_modalidad($items)
    {
        $this->db->query("CALL `sp_tb_practica_modalidad_insert`(?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return $res->row();    
    }

    public function mUpdate_modalidad($items)
    {
        $this->db->query("CALL `sp_tb_practica_modalidad_update`(?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return   $res->row();    
    }

    public function m_filtrar_modalidadxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_practica_modalidad.pm_id as codigo,
          tb_practica_modalidad.pm_nombre as nombre
        FROM
          tb_practica_modalidad
          WHERE tb_practica_modalidad.pm_id = ? LIMIT 1", $codigo);

        return $result->row();
    }

    public function m_eliminamodalidad($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_practica_modalidad where pm_id = ? ", $codigo);
        
        return 1;
    }


}


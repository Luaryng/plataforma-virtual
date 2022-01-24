<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdiscapacidad extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_discapacidadxnombre($data)
    {
        $result = $this->db->query("SELECT 
          tb_discapacidades.dcd_id as codigo,
          tb_discapacidades.dcd_grupo as grupo,
          tb_discapacidades.dcd_detalle as detalle,
          tb_discapacidades.dcd_habilitado as habilitado
        FROM
          tb_discapacidades
          WHERE tb_discapacidades.dcd_grupo LIKE ?
        ORDER BY tb_discapacidades.dcd_grupo ASC ", $data);
        return $result->result();
    }

    /*public function m_get_discapacidadxgrupo()
    {
        $result = $this->db->query("SELECT 
          tb_discapacidades.dcd_id as codigo,
          tb_discapacidades.dcd_grupo as grupo,
          tb_discapacidades.dcd_detalle as detalle,
          tb_discapacidades.dcd_habilitado as habilitado
        FROM
          tb_discapacidades
        GROUP BY tb_discapacidades.dcd_grupo ");
        return $result->result();
    }*/

    public function m_get_discapacidadxgrupo()
    {
        $result = $this->db->query("SELECT 
          tb_discapacidades.dcd_grupo as grupo
        FROM
          tb_discapacidades
        GROUP BY tb_discapacidades.dcd_grupo ");
        return $result->result();
    }

    public function mInsert_discapacidad($items)
    {
        $this->db->query("CALL `sp_tb_discapacidad_insert`(?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return $res->row();    
    }

    public function mUpdate_discapacidad($items)
    {
        $this->db->query("CALL `sp_tb_discapacidad_update`(?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return   $res->row();    
    }

    public function m_filtrar_discapacidadxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_discapacidades.dcd_id as codigo,
          tb_discapacidades.dcd_grupo as grupo,
          tb_discapacidades.dcd_detalle as detalle,
          tb_discapacidades.dcd_habilitado as habilitado
        FROM
          tb_discapacidades
          WHERE tb_discapacidades.dcd_id = ? LIMIT 1", $codigo);

        return $result->row();
    }

    public function m_eliminadiscap($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_discapacidades where dcd_id = ? ", $codigo);
        
        return 1;
    }

    public function m_filtrar_discapacidadxestado()
    {
        $result = $this->db->query("SELECT 
          tb_discapacidades.dcd_id as codigo,
          tb_discapacidades.dcd_grupo as grupo,
          tb_discapacidades.dcd_detalle as detalle,
          tb_discapacidades.dcd_habilitado as habilitado
        FROM
          tb_discapacidades
          WHERE tb_discapacidades.dcd_habilitado = 'SI' ");

        return $result->result();
    }

    public function mInsert_inscrit_discapacidad($items)
    {   
        $this->db->query("CALL `sp_tb_inscripcion_discapacidad_insert`(?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return $res->row();    
    }


}


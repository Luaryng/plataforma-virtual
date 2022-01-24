<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mayuda extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_manuales()
    {
        // $data = array('manuales' => array(), 'videos' => array());
        $manual = $this->db->query("SELECT 
          tb_manuales.man_id as codigo,
          tb_manuales.man_grupo as grupo,
          tb_manuales.man_nombre as nombre,
          tb_manuales.man_enlace as enlace,
          tb_manuales.man_tipo as tipo,
          tb_manuales.man_norden as orden,
          tb_manuales.man_accesos as accesos,
          tb_manuales.man_creado as fecha
        FROM
          tb_manuales
        ORDER BY tb_manuales.man_norden");

        return $manual->result();
        
    }

    public function m_get_manualesxcodigo($data)
    {
        $result = $this->db->query("SELECT 
          tb_manuales.man_id as codigo,
          tb_manuales.man_grupo as grupo,
          tb_manuales.man_nombre as nombre,
          tb_manuales.man_enlace as enlace,
          tb_manuales.man_tipo as tipo,
          tb_manuales.man_norden as orden,
          tb_manuales.man_accesos as accesos,
          tb_manuales.man_creado as fecha
        FROM
          tb_manuales
        WHERE tb_manuales.man_id = ? LIMIT 1  ", $data);

        return $result->row();
    }

    public function m_get_manualesxtipo($tipo)
    {
        $result = $this->db->query("SELECT 
          tb_manuales.man_norden as orden
        FROM
          tb_manuales
        WHERE tb_manuales.man_tipo = ?
        ORDER BY  tb_manuales.man_norden DESC LIMIT 1", $tipo);

        return $result->row();
    }

    public function m_get_manualesxgrupo()
    {
        $result = $this->db->query("SELECT 
          tb_manuales.man_grupo as grupo
        FROM
          tb_manuales
        GROUP BY tb_manuales.man_grupo");

        return $result->result();
    }


    public function mInsert_manual($items)
    {
        $this->db->query("CALL `sp_tb_manuales_insert`(?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();    
    }

    public function mUpdate_manual($items)
    {
        $this->db->query("CALL `sp_tb_manuales_update`(?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return   $res->row();    
    }

    public function m_ordenar_manual($datainsert){
      foreach ($datainsert as $key => $data) {
        $this->db->query("UPDATE `tb_manuales` SET `man_norden` = ? WHERE  `man_id` = ?", $data);
      }
      return true;
    }  

    public function m_elimina_manual($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_manuales where man_id = ? ", $codigo);
        
        return 1;
    }


}


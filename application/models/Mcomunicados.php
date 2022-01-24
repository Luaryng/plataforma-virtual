<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcomunicados extends CI_Model {

	function __construct() {
           parent::__construct();
    }


    public function m_get_item($data)
    {
        // $dbm = $this->load->database();
        $qry = $this->db->query("SELECT 
                  tb_comunicados.cmd_id  as codigo,
                  tb_comunicados.cmd_titulo as titulo,
                  tb_comunicados.cmd_descripcion as descripcion,
                  tb_comunicados.cmd_archivo as archivo,
                  tb_comunicados.cmd_ruta as ruta,
                  tb_comunicados.cmd_peso as peso,
                  tb_comunicados.cmd_tipo as tipo,
                  tb_comunicados.cmd_nuevo as nuevo,
                  tb_comunicados.cmd_publicado as publicado,
                  tb_comunicados.cmd_accesos as accesos,
                  tb_comunicados.cmd_creado as creado
                FROM 
                  tb_comunicados
                WHERE cmd_id = ? ",$data);
        
        return $qry->row();
    }

    public function m_get_items($data)
    {
        $qry = $this->db->query("SELECT 
                  tb_comunicados.cmd_id  as codigo,
                  tb_comunicados.cmd_titulo as titulo,
                  tb_comunicados.cmd_descripcion as descripcion,
                  tb_comunicados.cmd_archivo as archivo,
                  tb_comunicados.cmd_ruta as ruta,
                  tb_comunicados.cmd_peso as peso,
                  tb_comunicados.cmd_tipo as tipo,
                  tb_comunicados.cmd_nuevo as nuevo,
                  tb_comunicados.cmd_publicado as publicado,
                  tb_comunicados.cmd_accesos as accesos,
                  tb_comunicados.cmd_creado as creado
                FROM 
                  tb_comunicados 
                WHERE tb_comunicados.cod_sede = ?
                order by tb_comunicados.cmd_creado DESC", $data);
        return $qry->result();
    }

    public function m_get_items_publicados($data)
    {
        $qry = $this->db->query("SELECT 
                  tb_comunicados.cmd_id  as codigo,
                  tb_comunicados.cmd_titulo as titulo,
                  tb_comunicados.cmd_descripcion as descripcion,
                  tb_comunicados.cmd_archivo as archivo,
                  tb_comunicados.cmd_ruta as ruta,
                  tb_comunicados.cmd_peso as peso,
                  tb_comunicados.cmd_tipo as tipo,
                  tb_comunicados.cmd_nuevo as nuevo,
                  
                  tb_comunicados.cmd_accesos as accesos,
                  tb_comunicados.cmd_creado as creado
                FROM 
                  tb_comunicados 
                WHERE tb_comunicados.cmd_publicado='SI' AND tb_comunicados.cod_sede = ?
                order by tb_comunicados.cmd_creado DESC", $data);
        return $qry->result();
    }


  public function m_insert($data)
	{
		$this->db->query("CALL `sp_tb_comunicados_insert`(?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as nid');
 		return   $res->row();	
	}
    public function m_update($data)
    {
        $this->db->query("CALL `sp_tb_comunicados_update`(?,?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return   $res->row();    
    }
    public function m_update_delfile($data)
    {
        $this->db->query("CALL `sp_tb_comunicados_update_delfile`(?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return   $res->row();    
    }

    

	public function m_delete($idArchivo)
    {
        $qry = $this->db->query("DELETE FROM  `tb_comunicados` WHERE  `cmd_id` = ?", $idArchivo);
        return 1;
    }

}
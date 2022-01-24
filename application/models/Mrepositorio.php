<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mrepositorio extends CI_Model {

	function __construct() {
           parent::__construct();
    }


    public function m_get_item($data)
    {
        // $dbm = $this->load->database();
        $qry = $this->db->query("SELECT 
                  `wd_id` as codigo,
                  `wd_titulo` as titulo,
                  `wd_descripcion` as descripcion,
                  `wd_ruta` as ruta,
                  `wd_peso` as peso,
                  `wd_tipo` as tipo,
                  `wd_categoria` as categoria,
                  `wd_orden` as orden,
                  `wd_creado` as creado
                FROM 
                  `tb_web_documentos` 
                WHERE wd_id = ? AND wd_area = ? ",$data);
        // $this->db->close();
        return $qry->row();
    }

    public function m_get_items($data)
    {
        $qry = $this->db->query("SELECT 
                  tb_web_documentos.wd_id as codigo,
                  tb_web_documentos.wd_titulo as titulo,
                  tb_web_documentos.wd_descripcion as descripcion,
                  tb_web_documentos.wd_ruta as ruta,
                  tb_web_documentos.wd_peso as peso,
                  tb_web_documentos.wd_tipo as tipo,
                  tb_web_documentos.wd_categoria as categoria,
                  tb_web_documentos_categoria.wdc_nombre as nomcategoria,
                  tb_web_documentos.wd_orden as orden,
                  tb_web_documentos.wd_creado as creado
                FROM 
                  tb_web_documentos 
                  LEFT OUTER JOIN tb_web_documentos_categoria ON (tb_web_documentos.wd_categoria = tb_web_documentos_categoria.wdc_id) 
                WHERE tb_web_documentos.wd_categoria like ? AND tb_web_documentos.wd_area = ? AND tb_web_documentos.wd_titulo like ?
                order by tb_web_documentos.wd_categoria,tb_web_documentos.wd_orden DESC",$data);
        // $this->db->close();
        return $qry->result();
    }


  public function m_insert($data)
	{
        //CALL `sp_tb_web_documentos_insert`( @vwd_titulo, @vwd_descripcion, @vwd_ruta, @vwd_peso, @vwd_tipo, @vwd_categoria, @vwd_orden, @vwd_area, @s, @nid);
		$this->db->query("CALL `sp_tb_web_documentos_insert`(?,?,?,?,?,?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as nid');
 		return   $res->row();	
	}
    public function m_update($data)
    {
        $this->db->query("CALL `sp_tb_web_documentos_update`(?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return   $res->row();    
    }
    public function m_update_delfile($data)
    {
        $this->db->query("CALL `sp_tb_web_documentos_update_delfile`(?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return   $res->row();    
    }

    

	public function m_delete($idArchivo)
    {
        $qry = $this->db->query("DELETE FROM  `tb_web_documentos` WHERE  `wd_id` = ?", $idArchivo);
        return 1;
    }

}
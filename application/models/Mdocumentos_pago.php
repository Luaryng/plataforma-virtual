<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdocumentos_pago extends CI_Model {

	function __construct() {
           parent::__construct();
    }


    public function m_get_itemdoc($data)
    {
        
        $qry = $this->db->query("SELECT 
                  `adp_id` as codigo,
                  `adp_titulo` as titulo,
                  `adp_descripcion` as descripcion,
                  `adp_ruta` as ruta,
                  `adp_peso` as peso,
                  `adp_tipo` as tipo,
                  `adp_emision` as emision,
                  `adp_importe` as importe,
                  `adp_creado` as creado,
                  `adp_estado` as estado
                FROM 
                  `tb_admin_doc_pago` 
                WHERE adp_id=? ",$data);
        
        return $qry->row();
    }

    public function m_get_itemdocfecha($data)
    {
        
        $qry = $this->db->query("SELECT 
                  `adp_id` as codigo,
                  `adp_titulo` as titulo,
                  `adp_descripcion` as descripcion,
                  `adp_ruta` as ruta,
                  `adp_peso` as peso,
                  `adp_tipo` as tipo,
                  `adp_emision` as emision,
                  `adp_importe` as importe,
                  `adp_creado` as creado,
                  `adp_estado` as estado,
                  tb_admin_doc_pago.adp_vence as vence
                FROM 
                  `tb_admin_doc_pago` 
                WHERE adp_emision = ? ",$data);
        
        return $qry->result();
    }

    public function m_get_itemdocsearch($data)
    {
      if ($data[0] != "" && $data[1] == "" && $data[2] == "") {
        $datos = array($data[0]);
        $qry = $this->db->query("SELECT 
                  tb_admin_doc_pago.adp_id as codigo,
                  tb_admin_doc_pago.adp_titulo as titulo,
                  tb_admin_doc_pago.adp_descripcion as descripcion,
                  tb_admin_doc_pago.adp_ruta as ruta,
                  tb_admin_doc_pago.adp_peso as peso,
                  tb_admin_doc_pago.adp_tipo as tipo,
                  tb_admin_doc_pago.adp_importe as importe,
                  tb_admin_doc_pago.adp_emision as emision,
                  tb_admin_doc_pago.adp_creado as creado,
                  tb_admin_doc_pago.adp_estado as estado,
                  tb_admin_doc_pago.adp_vence as vence
                FROM 
                  tb_admin_doc_pago 
                WHERE tb_admin_doc_pago.adp_titulo like ?
                order by tb_admin_doc_pago.adp_emision DESC", $datos);
      } else if ($data[0] != "" && $data[1] != "" && $data[2] != "") {
        $qry = $this->db->query("SELECT 
                  tb_admin_doc_pago.adp_id as codigo,
                  tb_admin_doc_pago.adp_titulo as titulo,
                  tb_admin_doc_pago.adp_descripcion as descripcion,
                  tb_admin_doc_pago.adp_ruta as ruta,
                  tb_admin_doc_pago.adp_peso as peso,
                  tb_admin_doc_pago.adp_tipo as tipo,
                  tb_admin_doc_pago.adp_importe as importe,
                  tb_admin_doc_pago.adp_emision as emision,
                  tb_admin_doc_pago.adp_creado as creado,
                  tb_admin_doc_pago.adp_estado as estado,
                  tb_admin_doc_pago.adp_vence as vence
                FROM 
                  tb_admin_doc_pago
          WHERE tb_admin_doc_pago.adp_titulo like ? AND 
          tb_admin_doc_pago.adp_emision BETWEEN ? AND ? 
          order by tb_admin_doc_pago.adp_emision DESC", $data);
      }

      return $qry->result();
    }

    public function m_get_itemsdocindex()
    {
        $qry = $this->db->query("SELECT 
                  tb_admin_doc_pago.adp_id as codigo,
                  tb_admin_doc_pago.adp_titulo as titulo,
                  tb_admin_doc_pago.adp_descripcion as descripcion,
                  tb_admin_doc_pago.adp_ruta as ruta,
                  tb_admin_doc_pago.adp_peso as peso,
                  tb_admin_doc_pago.adp_tipo as tipo,
                  tb_admin_doc_pago.adp_importe as importe,
                  tb_admin_doc_pago.adp_emision as emision,
                  tb_admin_doc_pago.adp_creado as creado,
                  tb_admin_doc_pago.adp_estado as estado,
                  tb_admin_doc_pago.adp_vence as vence
                FROM 
                  tb_admin_doc_pago 
                order by tb_admin_doc_pago.adp_emision DESC LIMIT 12");
        
        return $qry->result();
    }

    public function m_get_itemsdoc($data)
    {
        $qry = $this->db->query("SELECT 
                  tb_admin_doc_pago.adp_id as codigo,
                  tb_admin_doc_pago.adp_titulo as titulo,
                  tb_admin_doc_pago.adp_descripcion as descripcion,
                  tb_admin_doc_pago.adp_ruta as ruta,
                  tb_admin_doc_pago.adp_peso as peso,
                  tb_admin_doc_pago.adp_tipo as tipo,
                  tb_admin_doc_pago.adp_importe as importe,
                  tb_admin_doc_pago.adp_emision as emision,
                  tb_admin_doc_pago.adp_creado as creado,
                  tb_admin_doc_pago.adp_estado as estado,
                  tb_admin_doc_pago.adp_vence as vence
                FROM 
                  tb_admin_doc_pago 
                WHERE tb_admin_doc_pago.adp_titulo like ?
                order by tb_admin_doc_pago.adp_emision DESC",$data);
        
        return $qry->result();
    }


  public function m_insert_doc($data)
	{
       
		$this->db->query("CALL `sp_admin_doc_pago_insert`(?,?,?,?,?,?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as nid');
 		return   $res->row();	
	}
    public function m_update_doc($data)
    {
        $this->db->query("CALL `sp_admin_doc_pago_update`(?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return   $res->row();    
    }
    public function m_update_delfiledoc($data)
    {
        $this->db->query("CALL `sp_admin_doc_pago_update_file`(?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return   $res->row();    
    }

    

	public function m_deletedoc($idArchivo)
    {
        $qry = $this->db->query("DELETE FROM  `tb_admin_doc_pago` WHERE  `adp_id` = ?", $idArchivo);
        return 1;
    }


 

}
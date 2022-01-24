<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mgaleria extends CI_Model {

	function __construct() {
    parent::__construct();
  }

  public function m_get_data_albumxcodigo($codigo)
  {
        $result = $this->db->query("SELECT 
        tb_album.alb_id AS id,
        tb_album.alb_nombre AS nombre,
        tb_album.alb_slug AS ruta,
        tb_album.alb_descripcion AS detalle,
        tb_album.alb_fecha AS fecha
      FROM
        tb_album
        WHERE tb_album.alb_id = ? limit 1", $codigo);

      $arr_result['album']= $result->row();

        $result = $this->db->query("SELECT 
        tb_album_fotos.alf_id as idfoto,
        tb_album_fotos.alb_id as idalbum,
        tb_album_fotos.alf_nombre as nombre,
        tb_album_fotos.alf_ruta as link,
        tb_album_fotos.alf_peso as peso,
        tb_album_fotos.alf_tipo as tipo,
        tb_album_fotos.alf_creado as creado
      FROM
        tb_album_fotos
        WHERE tb_album_fotos.alb_id = ?", $codigo);

      $arr_result['fotos']= $result->result();
      return $arr_result;
  }


  public function m_get_album()
  {
      
    $result = $this->db->query("SELECT 
      tb_album.alb_id AS id,
      tb_album.alb_nombre AS nombre,
      tb_album.alb_slug AS ruta,
      tb_album.alb_descripcion AS detalle,
      tb_album.alb_fecha AS fecha
    FROM
      tb_album
      ORDER BY tb_album.alb_fecha DESC");
      
      return $result->result();
  }

  public function m_insert_album($data)
	{
		$this->db->query("CALL `sp_tb_album_insert`(?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as nid');
 		return   $res->row();	
	}

  public function m_insert_fotos($data)
  {
    $this->db->query("CALL `sp_tb_album_fotos_insert`(?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }

  public function m_update_delfilefot($data)
  {
      $this->db->query("CALL `sp_tb_album_fotos_delete`(?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return   $res->row();    
  }

  public function m_update_album($data)
  {
      $this->db->query("CALL `sp_tb_album_update`(?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return   $res->row();    
  }
    
	public function m_deletealbum($data)
  {
      $qry = $this->db->query("DELETE FROM `tb_album` WHERE `alb_id` = ?", $data);
      return 1;
  }


 

}
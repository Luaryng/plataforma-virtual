<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mnoticia extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

  public function m_insert_noticias($data)
	{
		$this->db->query("CALL `sp_tb_noticias_insert`(?,?,?,?,?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as nid');
 		return   $res->row();	
	}

	public function m_lst_noticias()
	{
    // $dbm = $this->load->database('iestpweb',true);
  	$result = $this->db->query("SELECT 
  			    tb_noticias.not_id id,
            tb_noticias.not_titulo titulo,
            tb_noticias.not_slug slug,
            tb_noticias.not_detalle detalle,
            tb_noticias.not_resumen resumen,
            tb_noticias.not_fecha fecha,           
            tb_noticias.not_hora hora,
            tb_noticias.not_portada imgp
          FROM
            tb_noticias
            ORDER BY tb_noticias.not_id DESC");
  	return $result->result();
	}

	public function m_lst_noticiasxcodigo($codigo)
	{
  	$result = $this->db->query("SELECT 
  			    tb_noticias.not_id id,
            tb_noticias.not_titulo titulo,
            tb_noticias.not_detalle detalle,
            tb_noticias.not_resumen resumen,
            tb_noticias.not_fecha fecha,           
            tb_noticias.not_hora hora,
            tb_noticias.not_portada imgp
          FROM
            tb_noticias
          WHERE
            tb_noticias.not_id = ?", $codigo);
  	return $result->result();
	}
	public function m_captura_imgxcodigo($codigo)
	{
  	$result = $this->db->query("SELECT 
            tb_noticias.not_portada imgp
          FROM
            tb_noticias
          WHERE
            tb_noticias.not_id = ?", $codigo);
  	return $result->row();
	}

	public function m_update_noticias($data)
	{
		$this->db->query("CALL `sp_tb_noticias_update`(?,?,?,?,?,?,@s)",$data);
		$res = $this->db->query('select @s as out_param');
 		return   $res->row()->out_param;	
	}

	public function m_delete_noticia($codigo)
	{
  	$result = $this->db->query("DELETE 
          FROM
            tb_noticias
          WHERE
            tb_noticias.not_id = ?", $codigo);
  	return 1;
	}

  public function m_lst_noticiasxslug($data)
  {
    $result = $this->db->query("SELECT 
            tb_noticias.not_id id,
            tb_noticias.not_titulo titulo,
            tb_noticias.not_slug slug,
            tb_noticias.not_detalle detalle,
            tb_noticias.not_resumen resumen,
            tb_noticias.not_fecha fecha,           
            tb_noticias.not_hora hora,
            tb_noticias.not_portada imgp
          FROM
            tb_noticias
          WHERE
            tb_noticias.not_id = ? AND tb_noticias.not_slug = ?", $data);
    return $result->row();
  }

  public function m_lst_noticiasxmas()
  {
    $result = $this->db->query("SELECT 
            tb_noticias.not_id id,
            tb_noticias.not_titulo titulo,
            tb_noticias.not_slug slug,
            tb_noticias.not_detalle detalle,
            tb_noticias.not_resumen resumen,
            tb_noticias.not_fecha fecha,           
            tb_noticias.not_hora hora,
            tb_noticias.not_portada imgp
          FROM
            tb_noticias 
          ORDER BY tb_noticias.not_id DESC limit 3");
    return $result->result();
  }

}
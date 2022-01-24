<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcapacitaciones extends CI_Model {

	function __construct() {
           parent::__construct();
           $this->load->helper("url");          
    }

    public function m_insert_capacitacion($data)
	{
		$this->db->query("CALL `sp_tb_charlas_insert`(?,?,?,?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as newcod');
 		return   $res->row();	
	}
    public function m_update_capacitacion($data)
    {
        $this->db->query("CALL `sp_tb_charlas_update`(?,?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        return   $res->row();    
    }

	public function lstcapacitaciones()
    {
    	$qry = $this->db->query("SELECT
                    tb_charlas.ch_id as id,
                    tb_charlas.ch_nombre as nombre,
                    tb_charlas.ch_expositor as expositor,
                    tb_charlas.ch_fecha_hora as fecha,
                    tb_charlas.ch_grabacion as grabacion,
                    tb_charlas.ch_detalle as detalle,
                    tb_charlas.ch_tipo as tipo,
                    tb_charlas.ch_registro as fregistro
                FROM
                    tb_charlas
                order by tb_charlas.ch_fecha_hora DESC");
    	return $qry->result();
    }

    public function lstcapacitaciones_id($data)
    {
        $qry = $this->db->query("SELECT
                    tb_charlas.ch_id as id,
                    tb_charlas.ch_nombre as nombre,
                    tb_charlas.ch_expositor as expositor,
                    tb_charlas.ch_fecha_hora as fecha,
                    tb_charlas.ch_grabacion as grabacion,
                    tb_charlas.ch_detalle as detalle,
                    tb_charlas.ch_tipo as tipo,
                    tb_charlas.ch_registro as fregistro
                FROM
                    tb_charlas
                WHERE
                    tb_charlas.ch_id = ? LIMIT 1", $data);
        return $qry->row();
    }

    

	public function m_eliminacapacitacion($codigo)
    {
        $qry = $this->db->query("DELETE FROM tb_charlas where ch_id = ?", $codigo);
        return 1;
    }

}
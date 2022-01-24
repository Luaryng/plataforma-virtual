<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meventos extends CI_Model {

	function __construct() {
           parent::__construct();
           $this->load->helper("url");          
    }

    public function m_insert_evento($data)
	{
		$this->db->query("CALL `sp_tb_eventos_insert`(?,?,?,?,?,?,?,?,@s)",$data);
		$res = $this->db->query('select @s as salida');
 		return   $res->row();	
	}
    public function m_update_eventos($data)
    {
        $this->db->query("CALL `sp_tb_eventos_update`(?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return   $res->row()->out_param;    
    }

	public function lsteventos()
    {
    	$qry = $this->db->query("SELECT
                    tb_eventos.evt_id as id,
                    tb_eventos.evt_titulo as titulo,
                    tb_eventos.evt_slug as slug,
                    tb_eventos.evt_detalle as detalle,
                    tb_eventos.evt_resumen as resumen,
                    tb_eventos.evt_fecha_evento as fecha,
                    tb_eventos.evt_hora_evento as hora,
                    tb_eventos.evt_lugar as lugar,
                    tb_eventos.evt_portada as imagen,
                    tb_eventos.evt_fecha as fecha_reg
                FROM
                    tb_eventos
                order by tb_eventos.evt_fecha DESC");
    	return $qry->result();
    }

    public function lsteventos_id($data)
    {
        $qry = $this->db->query("SELECT
                    tb_eventos.evt_id as id,
                    tb_eventos.evt_titulo as titulo,
                    tb_eventos.evt_slug as slug,
                    tb_eventos.evt_detalle as detalle,
                    tb_eventos.evt_resumen as resumen,
                    tb_eventos.evt_fecha_evento as fecha,
                    tb_eventos.evt_hora_evento as hora,
                    tb_eventos.evt_lugar as lugar,
                    tb_eventos.evt_portada as imagen,
                    tb_eventos.evt_fecha as fecha_reg
                FROM
                    tb_eventos
                WHERE
                    tb_eventos.evt_id = ? LIMIT 1", $data);
        return $qry->row();
    }

    

	public function m_eliminaevento($codigo)
    {
        $qry = $this->db->query("DELETE FROM tb_eventos where evt_id = ?", $codigo);
        return 1;
    }

}
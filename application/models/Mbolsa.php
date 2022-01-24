<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbolsa extends CI_Model {

	function __construct() {
           parent::__construct();
           $this->load->helper("url");          
    }

    public function m_insert_bolsa($data)
	{
        //CALL `sp_tb_bolsa_trabajo_insert`( @vtitulo_btrabajo, @vslug, @vdetalle_btrab, @vdetalle_html_btrab, @vportada_btrab, @vtipo, @s, @nid);
		$this->db->query("CALL `sp_tb_bolsa_trabajo_insert`(?,?,?,?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as nid');
 		return   $res->row();	
	}
    public function m_update_bolsa($data)
    {
        $this->db->query("CALL `sp_tb_bolsa_trabajo_update`(?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return   $res->row()->out_param;    
    }

	public function lstbolsa_trabajo()
    {
    	// $dbm = $this->load->database();
    	$qry = $this->db->query("SELECT
                    tb_bolsa_trabajo.idBtrabajo as id,
                    tb_bolsa_trabajo.titulo_btrabajo as titulo,
                    tb_bolsa_trabajo.detalle_btrab as detalle,
                    tb_bolsa_trabajo.portada_btrab as imagen,
                    tb_bolsa_trabajo.tipo as tip,
                    tb_bolsa_trabajo.fecha_publicado as fecha
                FROM
                    tb_bolsa_trabajo
                order by tb_bolsa_trabajo.fecha_publicado DESC");
    	// $this->db->close();
    	return $qry->result();
    }

    public function lstbolsa_trabajoid($data)
    {
        $qry = $this->db->query("SELECT
                    tb_bolsa_trabajo.idBtrabajo as id,
                    tb_bolsa_trabajo.titulo_btrabajo as titulo,
                    tb_bolsa_trabajo.detalle_html_btrab as detalle_html,
                    tb_bolsa_trabajo.portada_btrab as imagen,
                    tb_bolsa_trabajo.tipo as tip,
                    tb_bolsa_trabajo.fecha_publicado as fecha
                FROM
                    tb_bolsa_trabajo
                WHERE
                    tb_bolsa_trabajo.idBtrabajo = ? LIMIT 1", $data);
        return $qry->row();
    }

    

	public function m_eliminabolsa($idArchivo)
    {
        $qry = $this->db->query("DELETE FROM tb_bolsa_trabajo where idBtrabajo=?", $idArchivo);
        return 1;
    }

}
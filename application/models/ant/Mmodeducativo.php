<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmodeducativo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert_datos_modulo($data){

        $this->db->query("CALL `sp_tb_modulo_educativo_insert`(?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_get_modulos()
    {
    	$result = $this->db->query("SELECT 
				  tb_modulo_educativo.mod_codigo id,
				  tb_modulo_educativo.mod_nombre modnom,
				  tb_modulo_educativo.mod_nro modnum,
				  tb_modulo_educativo.codigoplan idplan,
				  tb_plan_estudios.pln_nombre nomplan,
				  tb_modulo_educativo.mod_horas modhoras,
				  tb_modulo_educativo.mod_creditos modcred
				FROM
				  tb_plan_estudios
				  INNER JOIN tb_modulo_educativo ON (tb_plan_estudios.pln_id = tb_modulo_educativo.codigoplan)");
    	return $result->result();
    }

    public function m_get_modulosxcodigo($codigo)
    {
    	$result = $this->db->query("SELECT 
				  tb_modulo_educativo.mod_codigo id,
				  tb_modulo_educativo.mod_nombre modnom,
				  tb_modulo_educativo.mod_nro modnum,
				  tb_modulo_educativo.codigoplan idplan,
				  tb_plan_estudios.pln_nombre nomplan,
				  tb_modulo_educativo.mod_horas modhoras,
				  tb_modulo_educativo.mod_creditos modcred
				FROM
				  tb_plan_estudios
				  INNER JOIN tb_modulo_educativo ON (tb_plan_estudios.pln_id = tb_modulo_educativo.codigoplan)
				WHERE
				  tb_modulo_educativo.mod_codigo = ? ", $codigo);
    	return $result->result();
    }

    public function update_datos_modulo($data){

        $this->db->query("CALL `sp_tb_modulo_educativo_update`(?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_elimina_modulo($codigo)
    {
        $qry = $this->db->query("DELETE FROM tb_modulo_educativo where mod_codigo = ?", $codigo);
        $this->db->close();
        return 1;
    }

}
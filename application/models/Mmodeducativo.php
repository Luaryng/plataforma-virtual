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

    public function m_get_modulos_tabla()
    {
      $result = $this->db->query("SELECT 
          tb_modulo_educativo.mod_codigo id,
          tb_modulo_educativo.mod_nombre modnom,
          tb_modulo_educativo.codigoplan idplan
        FROM
          tb_modulo_educativo");
      return $result->result();
    }

    public function m_get_modulosxnombre($modnom)
    {
        $rsmodulo = array();
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
                  tb_modulo_educativo.mod_codigo like ?", $modnom);
        $rsmodulo = $result->result();
        return array('modulos' => $rsmodulo);
    }

    public function m_get_modulosxcarrera($carrera)
    {
        $rsmodulo = array();
        $result = $this->db->query("SELECT 
                  tb_modulo_educativo.mod_codigo id,
                  tb_modulo_educativo.mod_nombre modnom,
                  tb_modulo_educativo.mod_nro modnum,
                  tb_plan_estudios.pln_nombre nomplan,
                  tb_modulo_educativo.mod_horas modhoras,
                  tb_modulo_educativo.mod_creditos modcred
                FROM
                  tb_plan_estudios
                  INNER JOIN tb_modulo_educativo ON (tb_plan_estudios.pln_id = tb_modulo_educativo.codigoplan)
                  INNER JOIN tb_carrera ON (tb_plan_estudios.codigocarrera = tb_carrera.car_id)
                WHERE
                  tb_carrera.car_id LIKE ?", $carrera);
        $rsmodulo = $result->result();
        return array('modulos' => $rsmodulo);
    }

    public function m_get_modulosxplanes($plan)
    {
      $result = $this->db->query("SELECT 
                tb_modulo_educativo.mod_codigo codigo,
                tb_modulo_educativo.mod_nombre nombre
              FROM
                tb_plan_estudios
                INNER JOIN tb_modulo_educativo ON (tb_plan_estudios.pln_id = tb_modulo_educativo.codigoplan)
              WHERE
                tb_plan_estudios.pln_id = ?", $plan);
      return $result->result();
    }

    public function m_get_modulosxcodigo($codigo)
    {
      $rsmod = array();
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
    	$rsmod = $result->row();
      return array('dtsmodulo' => $rsmod);
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mplancurricular extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    public function m_get_planes_activos()
    {
        $result = $this->db->query("SELECT 
              tb_plan_estudios.pln_id  as codigo,
              tb_plan_estudios.pln_nombre as nombre,
              tb_plan_estudios.codigocarrera as codcarrera
            FROM tb_plan_estudios 
            WHERE tb_plan_estudios.pln_activo='SI'
            ORDER BY tb_plan_estudios.pln_nombre;");
        return $result->result();
    }

    public function m_get_planes_activos_carrera($data)
    {
        $result = $this->db->query("SELECT 
              tb_plan_estudios.pln_id  as codigo,
              tb_plan_estudios.pln_nombre as nombre,
              tb_periodo.ped_nombre as periodo
            FROM
              tb_periodo
              INNER JOIN tb_plan_estudios ON (tb_periodo.ped_codigo = tb_plan_estudios.codigoperiodo) 
            WHERE tb_plan_estudios.pln_activo='SI' AND tb_plan_estudios.codigocarrera=?;",$data);
        return $result->result();
    }

    public function m_get_plan_x_defecto_inscipcion_carrera($data)
    {
        $result = $this->db->query("SELECT 
              tb_plan_estudios.pln_id  as codigo,
              tb_plan_estudios.pln_nombre as nombre
            FROM
              tb_plan_estudios 
            WHERE  tb_plan_estudios.codigocarrera=? AND tb_plan_estudios.pln_activo='SI' AND tb_plan_estudios.pnl_defecto_inscripcion='SI';",$data);
        return $result->row();
    }


    public function m_get_cursos_por_plan($data)
    {
      $result = $this->db->query("SELECT 
          tb_modulo_educativo.mod_codigo codmodulo,
          tb_modulo_educativo.mod_nombre modulo,
          tb_modulo_educativo.mod_nro modnro,
          tb_unidad_didactica.undd_nombre unidaddid,
          tb_unidad_didactica.undd_tipo_mod tipo,
          tb_unidad_didactica.codigociclo codciclo,
          tb_unidad_didactica.undd_codigo as codunidad
        FROM
          tb_unidad_didactica
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo) 
        WHERE tb_modulo_educativo.codigoplan=? 
        ORDER BY tb_modulo_educativo.mod_codigo,tb_unidad_didactica.codigociclo,tb_unidad_didactica.undd_nombre;",$data);
      return $result->result();
    }

    public function insert_datos_plan($data){

      $this->db->query("CALL `sp_tb_plan_estudios_insert`(?,?,?,?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;    
    }

    public function m_plan_estudios()
    {
      $result = $this->db->query("SELECT 
                tb_plan_estudios.pln_id id,
                tb_plan_estudios.pln_nombre nombre,
                tb_plan_estudios.codigoperiodo codper,
                tb_periodo.ped_nombre periodo,
                tb_plan_estudios.codigocarrera codcar,
                tb_carrera.car_nombre carrera,
                tb_plan_estudios.pln_decreto_supr decreto,
                tb_plan_estudios.pln_resolucion_dir resolu,
                tb_plan_estudios.pln_activo activo
              FROM
                tb_periodo
                INNER JOIN tb_plan_estudios ON (tb_periodo.ped_codigo = tb_plan_estudios.codigoperiodo)
                INNER JOIN tb_carrera ON (tb_plan_estudios.codigocarrera = tb_carrera.car_id)");
      return $result->result();
    }

    public function m_plan_estudios_tabla()
    {
      $result = $this->db->query("SELECT 
          tb_plan_estudios.pln_id AS id,
          tb_plan_estudios.pln_nombre AS nombre,
          tb_plan_estudios.codigocarrera AS codcar,
          tb_plan_estudios.pln_activo AS activo
        FROM
          tb_plan_estudios");
      return $result->result();
    }


    public function m_plan_estudiosxperiodo($codper)
    {
      $rsplan = array();
      $result = $this->db->query("SELECT 
                tb_plan_estudios.pln_id id,
                tb_plan_estudios.pln_nombre nombre,
                tb_plan_estudios.codigoperiodo codper,
                tb_periodo.ped_nombre periodo,
                tb_plan_estudios.codigocarrera codcar,
                tb_carrera.car_nombre carrera,
                tb_plan_estudios.pln_decreto_supr decreto,
                tb_plan_estudios.pln_resolucion_dir resolu,
                tb_plan_estudios.pln_activo activo
              FROM
                tb_periodo
                INNER JOIN tb_plan_estudios ON (tb_periodo.ped_codigo = tb_plan_estudios.codigoperiodo)
                INNER JOIN tb_carrera ON (tb_plan_estudios.codigocarrera = tb_carrera.car_id)
              WHERE
                tb_plan_estudios.codigoperiodo like ?", $codper);
      $rsplan = $result->result();
      return array('planes' => $rsplan);
    }

    public function m_plan_estudiosxcarrera($carrera)
    {
      $rsplan = array();
      $result = $this->db->query("SELECT 
                tb_plan_estudios.pln_id id,
                tb_plan_estudios.pln_nombre nombre,
                tb_plan_estudios.codigoperiodo codper,
                tb_periodo.ped_nombre periodo,
                tb_plan_estudios.codigocarrera codcar,
                tb_carrera.car_nombre carrera,
                tb_plan_estudios.pln_decreto_supr decreto,
                tb_plan_estudios.pln_resolucion_dir resolu,
                tb_plan_estudios.pln_activo activo
              FROM
                tb_periodo
                INNER JOIN tb_plan_estudios ON (tb_periodo.ped_codigo = tb_plan_estudios.codigoperiodo)
                INNER JOIN tb_carrera ON (tb_plan_estudios.codigocarrera = tb_carrera.car_id)
              WHERE
                tb_carrera.car_id like ?", $carrera);
      $rsplan = $result->result();
      return array('planes' => $rsplan);
    }

    public function m_plan_estudiosactivos()
    {
      $result = $this->db->query("SELECT 
                tb_plan_estudios.pln_id id,
                tb_plan_estudios.pln_nombre nombre,
                tb_plan_estudios.codigoperiodo codper,
                tb_plan_estudios.codigocarrera codcar,
                tb_plan_estudios.pln_decreto_supr decreto,
                tb_plan_estudios.pln_resolucion_dir resolu,
                tb_plan_estudios.pln_activo activo
              FROM
                tb_plan_estudios
              WHERE
                tb_plan_estudios.pln_activo = 'SI' ");
      return $result->result();
    }

    public function m_plan_estudiosxcodigo($codigo)
    {
      $rsplanes = array();
      $result = $this->db->query("SELECT 
                tb_plan_estudios.pln_id id,
                tb_plan_estudios.pln_nombre nombre,
                tb_plan_estudios.codigoperiodo codper,
                tb_plan_estudios.codigocarrera codcar,
                tb_plan_estudios.pln_decreto_supr decreto,
                tb_plan_estudios.pln_resolucion_dir resolu,
                tb_plan_estudios.pln_activo activo
              FROM
                tb_plan_estudios
              WHERE
                tb_plan_estudios.pln_id = ?", $codigo);
      $rsplanes = $result->row();
      return array('dtsplan' => $rsplanes);
    }

    public function update_datos_plan($data){

      $this->db->query("CALL `sp_tb_plan_estudios_update`(?,?,?,?,?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;    
    }

    public function m_elimina_plan($codigo)
    {
        $qry = $this->db->query("DELETE FROM tb_plan_estudios where pln_id = ?", $codigo);
        $this->db->close();
        return 1;
    }

}
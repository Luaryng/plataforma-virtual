<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mplancurricular extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    public function m_get_planes_activos($data)
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

    

}
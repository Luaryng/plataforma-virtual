<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Munidaddidactica extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert_datos_unidad($data){

        $this->db->query("CALL `sp_tb_unidad_didactica`(?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_get_ciclo()
    {
        $result = $this->db->query("SELECT 
                  tb_ciclo.cic_codigo id,
                  tb_ciclo.cic_nombre nomcic,
                  tb_ciclo.cic_anios anio,
                  tb_ciclo.cic_letras letra
                FROM
                  tb_ciclo");
        return $result->result();
    }

    public function m_get_unidades()
    {
    	$result = $this->db->query("SELECT 
                  tb_unidad_didactica.undd_codigo id,
                  tb_unidad_didactica.undd_nombre uninom,
                  tb_unidad_didactica.undd_tipo_mod unitip,
                  tb_unidad_didactica.codigociclo idcic,
                  tb_ciclo.cic_nombre cicnom,
                  tb_unidad_didactica.codigomodulo idmod,
                  tb_modulo_educativo.mod_nombre modnom,
                  tb_unidad_didactica.undd_horas_sema_teor horter,
                  tb_unidad_didactica.undd_horas_sema_pract horprac,
                  tb_unidad_didactica.undd_horas_ciclo horcic,
                  tb_unidad_didactica.undd_creditos_teor credter,
                  tb_unidad_didactica.undd_creditos_pract credprac,
                  tb_unidad_didactica.undd_activo activo
                FROM
                  tb_modulo_educativo
                  INNER JOIN tb_unidad_didactica ON (tb_modulo_educativo.mod_codigo = tb_unidad_didactica.codigomodulo)
                  INNER JOIN tb_ciclo ON (tb_unidad_didactica.codigociclo = tb_ciclo.cic_codigo)
                WHERE 
                  `tb_unidad_didactica`.`undd_activo` = 'SI' 
                ORDER BY tb_unidad_didactica.codigomodulo,tb_unidad_didactica.codigociclo,tb_unidad_didactica.undd_tipo_mod,tb_unidad_didactica.undd_nombre ");
    	return $result->result();
    }

    public function m_get_unidadxcodigo($codigo)
    {
    	$result = $this->db->query("SELECT 
                  tb_unidad_didactica.undd_codigo id,
                  tb_unidad_didactica.undd_nombre uninom,
                  tb_unidad_didactica.undd_tipo_mod unitip,
                  tb_unidad_didactica.codigociclo idcic,
                  tb_ciclo.cic_nombre cicnom,
                  tb_unidad_didactica.codigomodulo idmod,
                  tb_modulo_educativo.mod_nombre modnom,
                  tb_unidad_didactica.undd_horas_sema_teor horter,
                  tb_unidad_didactica.undd_horas_sema_pract horprac,
                  tb_unidad_didactica.undd_horas_ciclo horcic,
                  tb_unidad_didactica.undd_creditos_teor credter,
                  tb_unidad_didactica.undd_creditos_pract credprac,
                  tb_unidad_didactica.undd_activo activo
                FROM
                  tb_modulo_educativo
                  INNER JOIN tb_unidad_didactica ON (tb_modulo_educativo.mod_codigo = tb_unidad_didactica.codigomodulo)
                  INNER JOIN tb_ciclo ON (tb_unidad_didactica.codigociclo = tb_ciclo.cic_codigo)
                WHERE 
                  `tb_unidad_didactica`.`undd_activo` = 'SI' AND tb_unidad_didactica.undd_codigo = ? ", $codigo);
        return $result->result();
    }

    public function update_datos_unidad($data){

        $this->db->query("CALL `sp_tb_unidad_didactica_update`(?,?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_elimina_unidad($codigo)
    {
        $qry = $this->db->query("DELETE FROM tb_unidad_didactica where undd_codigo = ?", $codigo);
        $this->db->close();
        return 1;
    }

}
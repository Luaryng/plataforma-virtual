<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mcarrera extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //POR JANIOR
    public function m_get_carreras_abiertas_por_sede($data)
      {
          $result = $this->db->query("SELECT 
            tb_carrera_sede.cod_carrera as codcarrera,
            tb_carrera.car_nombre as nombre,
            tb_carrera_sede.seca_costo_inscripcion as cinscripcion,
            tb_carrera_sede.seca_costo_matricula as cmatricula,
            tb_carrera_sede.seca_costo_total as ctotal,
            tb_carrera_sede.seca_costo_contado as ccontado,
            tb_carrera_sede.seca_nro_cuotas as ncuotas,
            tb_carrera.car_sigla as sigla,
            tb_carrera.car_abreviatura as nombre_abreviado
          FROM
            tb_carrera
            INNER JOIN tb_carrera_sede ON (tb_carrera.car_id = tb_carrera_sede.cod_carrera) 
          WHERE tb_carrera_sede.cod_sede=? AND tb_carrera_sede.seca_abierta='SI' AND tb_carrera_sede.seca_activo='SI';",$data);
        return $result->result();
    }

    public function m_get_carreras_activas_por_sede($data)
    {
          $result = $this->db->query("SELECT 
            tb_carrera_sede.cod_carrera as codcarrera,
            tb_carrera.car_nombre as nombre,
            tb_carrera_sede.seca_costo_inscripcion as cinscripcion,
            tb_carrera_sede.seca_costo_matricula as cmatricula,
            tb_carrera_sede.seca_costo_total as ctotal,
            tb_carrera_sede.seca_costo_contado as ccontado,
            tb_carrera_sede.seca_nro_cuotas as ncuotas,
            tb_carrera.car_sigla as sigla,
            tb_carrera.car_abreviatura as nombre_abreviado
          FROM
            tb_carrera
            INNER JOIN tb_carrera_sede ON (tb_carrera.car_id = tb_carrera_sede.cod_carrera) 
          WHERE tb_carrera_sede.cod_sede=? AND tb_carrera_sede.seca_activo='SI';",$data);
        return $result->result();
    }

    public function m_get_carreras()
    {
        $result = $this->db->query("SELECT 
                  tb_carrera.car_id as id,
                  tb_carrera.car_nombre as nombre,
                  tb_carrera.car_sigla as sigla,
                  tb_carrera.car_abreviatura as abrev,
                  tb_carrera.car_abierta as abierta,
                  tb_carrera.car_activo as activo,
                  tb_carrera.car_nivel_formativo as nivel
                FROM
                  tb_carrera
                WHERE
                  `tb_carrera`.`car_abierta` = 'SI' AND `tb_carrera`.`car_activo` = 'SI'");
        return $result->result();
    }

}
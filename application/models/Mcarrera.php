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

    public function m_get_carreras_por_sede_tram($data)
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
          WHERE tb_carrera_sede.cod_sede=? ",$data);
        return $result->result();
    }

    public function m_get_carreras_abiertas()
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
          WHERE tb_carrera_sede.seca_abierta='SI' AND tb_carrera_sede.seca_activo='SI';");
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

    public function m_get_todas_carreras_por_sede($data)
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
          WHERE tb_carrera_sede.cod_sede=?;",$data);
        return $result->result();
    }

    public function m_lts_carreras_activas()
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
                  WHERE tb_carrera.car_activo = 'SI'
                ORDER BY car_nombre ASC ");
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


    public function m_get_carreras_completa()
    {
        $result = $this->db->query("SELECT 
                  tb_carrera.car_id as id,
                  tb_carrera.car_nombre as nombre,
                  tb_carrera.car_sigla as sigla,
                  tb_carrera.car_abreviatura as abrev,
                  tb_carrera.car_abierta as abierta,
                  tb_carrera.car_activo as activo,
                  tb_carrera.car_nivel_formativo as nivel,
                  tb_carrera.car_imagen as imagen,
                  tb_carrera.car_presentacion as presentacion 

                FROM
                  tb_carrera
                WHERE
                  `tb_carrera`.`car_activo` = 'SI'");
        return $result->result();
    }

    /*
    =======================
    FUNCIONES CREADAS RECIENTES
    ======================
     */

    public function m_lts_carreras()
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
                ORDER BY car_nombre ASC ");
        return $result->result();
    }

    

    public function m_lts_carrerasxcodigo($codigo)
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
                WHERE tb_carrera.car_id = ? LIMIT 1 ", $codigo);
        return $result->row();
    }

    public function m_get_carrerasxnombre($data)
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
                WHERE tb_carrera.car_nombre like ?
                ORDER BY car_nombre ASC ", $data);
        return $result->result();
    }

    public function mInsert_carrera($items)
    {
        $this->db->query("CALL `sp_tb_carrera_insert`(?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }

    public function mUpdate_carrera($items)
    {
        $this->db->query("CALL `sp_tb_carrera_update`(?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function mInsert_carrera_sede($items)
    {
        $this->db->query("CALL `sp_tb_carrera_sede_insert`(?,?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_eliminacarrera($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_carrera where car_id = ? ", $codigo);
        
        return 1;
    }


    /*
    =======================
    FIN FUNCIONES CREADAS RECIENTES
    ======================
     */

}
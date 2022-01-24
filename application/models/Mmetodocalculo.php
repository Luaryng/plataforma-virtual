<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmetodocalculo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_metodos()
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
          `caev_codigo` as codigo,
          `caev_nombre` as nombre,
          `caev_detalle` as descripcion,
          `caev_habilitada` as habilitada
        FROM 
          `tb_carga_calculo_evaluaciones`");
        return $result->result();
    }
    
    public function m_get_metodos_activos()
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
          `caev_codigo` as codigo,
          `caev_nombre` as nombre,
          `caev_detalle` as descripcion
        FROM 
          `tb_carga_calculo_evaluaciones` 
        WHERE `caev_habilitada`='SI'");
        return $result->result();
    }







}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtemporal extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

   public function m_get_ciclos()
    {
        $result = $this->db->query("SELECT 
              `cic_codigo` codigo,
              `cic_nombre` nombre,
              `cic_anios` anios,
              `cic_letras` letras
            FROM 
              `tb_ciclo`;");
        return $result->result();
    }

    public function m_get_turnos_activos()
    {
        $result = $this->db->query("SELECT 
                  `tur_codigo` codigo,
                  `tur_nombre` nombre,
                  `tur_inicia` inicia,
                  `tur_fin` fin 
                FROM 
                  `tb_turno`
                  WHERE `tur_activo`='SI';");
        return $result->result();
    }

    public function m_get_secciones()
    {
        $result = $this->db->query("SELECT 
              `sec_codigo` codigo,
              `sec_nombre` nombre 
            FROM 
              `tb_seccion`;");
        return $result->result();
    }

    public function m_get_docs_por_anexar()
    {
        $result = $this->db->query("SELECT 
            `doan_id` coddocumento,
            `doan_nombre` nombre,
            `doan_abrevia` abrevia
          FROM 
            `tb_doc_anexar` ORDER BY `doan_nombre`;");
        return $result->result();
    }

    

}
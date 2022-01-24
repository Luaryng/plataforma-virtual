<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpracticas_etapas_plan extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_etapas_planxnombre($data)
    {
        $result = $this->db->query("SELECT 
          tb_practica_etapas_plan.cod_practica_etapa as codigo,
          tb_practica_etapas.pet_nombre as etapa,
          tb_practica_etapas_plan.codigo_plan as idplan,
          tb_plan_estudios.pln_nombre as plan,
          tb_practica_etapas_plan.pep_horas as horas,
          tb_practica_etapas_plan.pep_habilitado as habilitado
        FROM
          tb_practica_etapas_plan
          INNER JOIN tb_practica_etapas ON (tb_practica_etapas_plan.cod_practica_etapa = tb_practica_etapas.pet_id)
          INNER JOIN tb_plan_estudios ON (tb_practica_etapas_plan.codigo_plan = tb_plan_estudios.pln_id)
          WHERE tb_plan_estudios.pln_nombre LIKE ?
        ORDER BY tb_plan_estudios.pln_nombre ASC ", $data);
        return $result->result();
    }

    public function m_get_etapas_plan_codigos($data)
    {
        $result = $this->db->query("SELECT 
          tb_practica_etapas_plan.cod_practica_etapa as codigo,
          tb_practica_etapas_plan.codigo_plan as idplan,
          tb_carrera.car_id as idcarrera,
          tb_practica_etapas_plan.pep_horas as horas,
          tb_practica_etapas_plan.pep_habilitado as habilitado
        FROM
          tb_practica_etapas_plan
          INNER JOIN tb_plan_estudios ON (tb_practica_etapas_plan.codigo_plan = tb_plan_estudios.pln_id)
          INNER JOIN tb_carrera ON (tb_plan_estudios.codigocarrera = tb_carrera.car_id)
          WHERE tb_practica_etapas_plan.cod_practica_etapa = ? AND tb_practica_etapas_plan.codigo_plan = ?
        LIMIT 1 ", $data);
        return $result->row();
    }

    public function mInsert_etapas_plan($items)
    {
        $this->db->query("CALL `sp_tb_practica_etapas_plan_insert`(?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as salida');
        
        return $res->row();    
    }

    public function mUpdate_etapas_plan($items)
    {
        $this->db->query("CALL `sp_tb_practica_etapas_plan_update`(?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as salida');
        
        return   $res->row();    
    }

    public function m_eliminaetapa_plan($data)
    {
        
        $qry = $this->db->query("DELETE FROM tb_practica_etapas_plan where cod_practica_etapa = ? AND `codigo_plan` = ?", $data);
        
        return 1;
    }


}


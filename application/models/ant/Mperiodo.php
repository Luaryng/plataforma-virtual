<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mperiodo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

   public function m_get_periodos()
    {
        $result = $this->db->query("SELECT 
			  `ped_codigo` as codigo,
			  `ped_nombre` as nombre,
			  `ped_anio` as anio
			FROM 
			  `tb_periodo` WHERE `ped_activo`='SI';");
        return $result->result();
    }

     public function Insert_datos_periodo($data){
        $this->db->query("CALL `sp_tb_periodo_insert`(?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_periodos()
    {
        $rsper=array();
        $result = $this->db->query("SELECT  `ped_codigo` as codigo, `ped_nombre` as nombre, `ped_activo` as activ, `ped_anio` as anio
                  FROM `tb_periodo`");
        $rsper=$result->result();
        return array('periodos' => $rsper);
    }

    public function Update_datos_periodo($data){
        $this->db->query("CALL `sp_tb_periodo_update`(?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_eliminaper($idper)
    {
        $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_periodo where ped_codigo=?", $idper);
        $this->db->close();
        return 1;
    }

    public function Update_activo_periodo($data){
        $this->db->query("CALL `sp_tb_periodo_activ_update`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mcampania extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    public function m_get_campanias_por_periodo($data)
    {
        $result = $this->db->query("SELECT 
            `cam_id` as id,
            `cam_nombre` as nombre,
            `cod_periodo` as codperiodo,
            `cam_descripcion` as descripcion            
          FROM 
            `tb_campania`
          WHERE `cod_periodo`=? AND cod_sede=? AND `cam_activo`='SI' ORDER BY `cam_inicia`;",$data);
        return $result->result();
    }

    public function insert_datos_campania($data){

        $this->db->query("CALL `sp_tb_campania_insert`(?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_datos_campanias_por_periodo()
    {
        $result = $this->db->query("SELECT 
            `cam_id` as id,
            `cod_periodo` as codperiodo,
            `cam_nombre` as nombre,
            `cam_descripcion` as descripcion,
            `cam_inicia` as fini,
            `cam_culmina` as fculm,
            `cam_activo` as activ
          FROM 
            `tb_campania`;");
        return $result->result();
    }

    public function update_datos_campania($data){
        $this->db->query("CALL `sp_tb_campania_update`(?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_eliminacamp($idcamp)
    {
        $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_campania where cam_id=?", $idcamp);
        $this->db->close();
        return 1;
    }

    public function update_activ_campania($data){
        $this->db->query("CALL `sp_tb_campania_activ_update`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }
}
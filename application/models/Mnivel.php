<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mnivel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
        public function Insert_datos_nivel($data){
        $this->db->query("CALL `sp_tb_nivel_insert`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_niveles()
    {
        $rsnivl=array();
        $result = $this->db->query("SELECT  `niv_codigo` as codigo, `niv_nombre` as nombre
									FROM `tb_nivel`");
        $rsnivl=$result->result();
        return array('niveles' => $rsnivl);
    }

    public function Update_datos_nivel($data){
        $this->db->query("CALL `sp_tb_nivel_update`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_eliminaniv($idniv)
    {
        $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_nivel where niv_codigo=?", $idniv);
        $this->db->close();
        return 1;
    }

    public function m_nivelesxnombre($data)
    {
        $result = $this->db->query("SELECT  
                  `niv_codigo` as codigo, 
                  `niv_nombre` as nombre
                FROM `tb_nivel`
                WHERE `niv_nombre` like ?", $data);
        return $result->result();
    }

}
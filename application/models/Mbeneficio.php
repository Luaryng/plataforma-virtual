<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbeneficio extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

   public function m_get_beneficios()
    {
        $result = $this->db->query("SELECT ben_id as id, ben_nombre as nombre, ben_sigla as sigla FROM `tb_beneficio` WHERE `ben_activo`='SI';");
        return $result->result();
    }

    public function insert_datos_modalidad($data){

        $this->db->query("CALL `sp_tb_modalidad_insert`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_modalidad()
    {
        $rsmod=array();
        $result = $this->db->query("SELECT  `mod_id` as codigo, `mod_nombre` as nombre, `mod_activo` as actv
									FROM `tb_modalidad`");
        $rsmod=$result->result();
        return array('modalidades' => $rsmod);
    }

    public function update_datos_modalidad($data){

        $this->db->query("CALL `sp_tb_modalidad_update`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_eliminamod($idmod)
    {
        $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_modalidad where mod_id=?", $idmod);
        $this->db->close();
        return 1;
    }

    public function update_activ_modalidad($data){
        $this->db->query("CALL `sp_tb_modalidad_activ_update`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

}
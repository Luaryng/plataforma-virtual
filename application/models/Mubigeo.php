<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mubigeo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_paises()
    {
        $result = $this->db->query("SELECT `pa_id` as codigo, `pa_nombre` as nombre
                                    FROM `tb_pais`");
        return $result->result();
    }

    public function m_departamentos()
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT  `dep_codigo` as codigo,  `dep_nombre` as nombre
									FROM `tb_departamento`");
        return $result->result();
    }
    public function m_provincias($coddepa)
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
			  `prv_codigo` as codigo,
			  `prv_nombre` as nombre 
			FROM 
			  `tb_provincia` 
			WHERE `cod_departamento`=?
			ORDER BY `prv_nombre`;",$coddepa);
        $rsdepa=$result->result();
        return $rsdepa;
    }

    public function m_distritos($codprov)
    {
        $rsdepa=array();
       $result = $this->db->query("SELECT 
		  `dis_codigo` AS codigo,
		  `dis_nombre` as nombre 
		FROM 
		  `tb_distrito` 
			WHERE `cod_provincia`=? 
			ORDER BY `dis_nombre`;",$codprov);
        $rsdepa=$result->result();
        return $rsdepa;
    }
    public function m_ubigeo(){
        $data= array('depart' => array(),'provinc' => array(),'distrit' => array() );
        // $this->load->database();
        $depart = $this->db->query("SELECT `dep_codigo` as codigo,  `dep_nombre` as nombre FROM tb_departamento order by dep_nombre ASC");
        $data['depart']=$depart->result();

        $provinc = $this->db->query("SELECT `prv_codigo` as codigo, `prv_nombre` as nombre, `cod_departamento` as departm FROM tb_provincia order by prv_nombre ASC");
        $data['provinc']=$provinc->result();

        $distrit = $this->db->query("SELECT `dis_codigo` as codigo, `dis_nombre` as nombre, `cod_provincia` as provc FROM tb_distrito order by dis_nombre ASC");
        $data['distrit']=$distrit->result();

        $this->db->close(); 
        return $data;
    }

    public function m_ubigeoxnombres($data,$ubigeo)
    {
        if ($ubigeo == "departamento") {
            $result = $this->db->query("SELECT 
                    tb_departamento.dep_codigo as codigo,  
                    tb_departamento.dep_nombre as nombre 
                    FROM tb_departamento 
                    WHERE tb_departamento.dep_nombre like ? 
                    order by tb_departamento.dep_nombre ASC", $data);
        } else if ($ubigeo == "provincia") {
            $result = $this->db->query("SELECT 
                     tb_provincia.prv_codigo as codigo, 
                     tb_provincia.prv_nombre as nombre, 
                     tb_provincia.cod_departamento as departm,
                     tb_departamento.dep_nombre as nomdepart
                     FROM tb_provincia 
                     INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
                     WHERE tb_provincia.cod_departamento like ? 
                     order by tb_provincia.prv_nombre ASC", $data);
        } else if ($ubigeo == "distrito") {
            $result = $this->db->query("SELECT 
                    tb_distrito.dis_codigo as codigo, 
                    tb_distrito.dis_nombre as nombre, 
                    tb_distrito.cod_provincia as provc,
                    tb_provincia.prv_nombre as nomprovin, 
                    tb_departamento.dep_codigo as codepart, 
                    tb_departamento.dep_nombre as nomdepart
                    FROM tb_distrito 
                    INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
                    INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
                    WHERE tb_distrito.cod_provincia like ?
                    order by tb_distrito.dis_nombre ASC", $data);
        }

        return $result->result();
    }

    public function insert_datos_departamento($data){

        $this->db->query("CALL `sp_tb_departamento_insert`(?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function update_datos_departamento($data){

        $this->db->query("CALL `sp_tb_departamento_update`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_eliminadepart($idepartam)
    {
        $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_departamento where dep_codigo=?", $idepartam);
        $this->db->close();
        return 1;
    }

    public function insert_datos_provincia($data){

        $this->db->query("CALL `sp_tb_provincia_insert`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function update_datos_provincia($data){

        $this->db->query("CALL `sp_tb_provincia_update`(?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_eliminaprovinc($idprovin)
    {
        $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_provincia where prv_codigo=?", $idprovin);
        $this->db->close();
        return 1;
    }

    public function insert_datos_distrito($data){

        $this->db->query("CALL `sp_tb_distrito_insert`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function update_datos_distrito($data){

        $this->db->query("CALL `sp_tb_distrito_update`(?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_eliminadistrit($idistrit)
    {
        $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_distrito where dis_codigo=?", $idistrit);
        $this->db->close();
        return 1;
    }

    public function m_distritosxnombre($data)
    {
        $rsdepa=array();
       $result = $this->db->query("SELECT 
          `dis_codigo` AS codigo,
          `dis_nombre` as nombre,
          `prv_nombre` as nombreprv,
          `dep_nombre` as nombredep 
        FROM 
          `tb_distrito` 
        INNER JOIN tb_provincia ON(tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        INNER JOIN tb_departamento ON(tb_provincia.cod_departamento  = tb_departamento.dep_codigo )
            WHERE `dis_nombre` like ? 
            ORDER BY `dis_nombre` limit 10",$data);
        $rsdepa=$result->result();
        return $rsdepa;
    }
}
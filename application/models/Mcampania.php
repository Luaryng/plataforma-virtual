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

        $this->db->query("CALL `sp_tb_campania_insert`(?,?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return   $res->row();    
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
            `tb_campania` 
          ORDER BY `cam_inicia` ASC;");
        return $result->result();
    }

    public function m_search_campanias_por_periodo($periodo)
    {
        $result = $this->db->query("SELECT 
                `cam_id` as id,
                `cod_periodo` as codperiodo,
                `cod_sede` as codsede,
                `sed_nombre` as sede,
                `cam_nombre` as nombre,
                `cam_descripcion` as descripcion,
                `cam_inicia` as fini,
                `cam_culmina` as fculm,
                `cam_activo` as activ
              FROM 
                `tb_campania`
                INNER JOIN tb_sede ON (tb_campania.cod_sede = tb_sede.id_sede )
              WHERE
                `cod_periodo` like ? 
              ORDER BY tb_campania.cam_inicia ASC", $periodo);
            return $result->result();
    }

    public function m_search_campanias_x_sede_periodo($datos)
    {
        $result = $this->db->query("SELECT 
                `cam_id` as id,
                `cod_periodo` as codperiodo,
                `cod_sede` as codsede,
                `sed_nombre` as sede,
                `cam_nombre` as nombre,
                `cam_descripcion` as descripcion,
                `cam_inicia` as fini,
                `cam_culmina` as fculm,
                `cam_activo` as activ
              FROM 
                `tb_campania`
                INNER JOIN tb_sede ON (tb_campania.cod_sede = tb_sede.id_sede )
              WHERE
                `cod_periodo` like ? AND tb_campania.cod_sede=? 
            ORDER BY tb_campania.cod_periodo DESC, tb_campania.cam_inicia ASC", $datos);
            return $result->result();
    }
    

    public function m_search_campanias_por_codigo($codigo)
    {
        $rscamp = array();
        $result = $this->db->query("SELECT 
                `cam_id` as id,
                `cod_periodo` as codperiodo,
                `cod_sede` as codsede,
                `cam_nombre` as nombre,
                `cam_descripcion` as descripcion,
                `cam_inicia` as fini,
                `cam_culmina` as fculm,
                `cam_activo` as activ
              FROM 
                `tb_campania`
              WHERE
                `cam_id` = ?", $codigo);
        $rscamp = $result->row();
        return array('dcampania' => $rscamp);
    }

    public function update_datos_campania($data){
        $this->db->query("CALL `sp_tb_campania_update`(?,?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida, @nid as nid');
        return   $res->row();    
    }

    public function delete_campania($data)
    {
        $this->db->query("CALL `sp_tb_campania_delete`(?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return   $res->row(); 
    }

    public function update_activ_campania($data){
        $this->db->query("CALL `sp_tb_campania_activ_update`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }
}
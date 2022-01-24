<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpracticas_etapas extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_etapasxnombre($data)
    {
        $result = $this->db->query("SELECT 
          tb_practica_etapas.pet_id as codigo,
          tb_practica_etapas.pet_nombre as nombre,
          tb_practica_etapas.pet_habilitado as habilitado
        FROM
          tb_practica_etapas
          WHERE tb_practica_etapas.pet_nombre LIKE ?
        ORDER BY tb_practica_etapas.pet_nombre ASC ", $data);
        return $result->result();
    }

    public function mInsert_etapas($items)
    {
        $this->db->query("CALL `sp_tb_practica_etapas_insert`(?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return $res->row();    
    }

    public function mUpdate_etapas($items)
    {
        $this->db->query("CALL `sp_tb_practica_etapas_update`(?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return   $res->row();    
    }

    public function m_filtrar_etapasxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_practica_etapas.pet_id as codigo,
          tb_practica_etapas.pet_nombre as nombre,
          tb_practica_etapas.pet_habilitado as habilitado
        FROM
          tb_practica_etapas
          WHERE tb_practica_etapas.pet_id = ? LIMIT 1", $codigo);

        return $result->row();
    }

    public function m_eliminaetapa($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_practica_etapas where pet_id = ? ", $codigo);
        
        return 1;
    }

    public function m_filtrar_etapasxestado()
    {
        $result = $this->db->query("SELECT 
          tb_practica_etapas.pet_id as codigo,
          tb_practica_etapas.pet_nombre as nombre,
          tb_practica_etapas.pet_habilitado as habilitado
        FROM
          tb_practica_etapas
          WHERE tb_practica_etapas.pet_habilitado = 'SI' ");

        return $result->result();
    }


}


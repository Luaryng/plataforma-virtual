<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mindicadores extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    public function m_ordenar($datainsert){
      foreach ($datainsert as $key => $data) {
          //CALL ``( @`vcca`, @`vsubseccion`, @`vidmiembro`, @`vecu_nota`, @`videvaluacionhead`, @`s`);
            $this->db->query("UPDATE `tb_indicador`  SET `ind_nroorden` = ? WHERE  `ind_id` = ?", $data);
            //$res = $this->db->query('select @s as out_param');

            //$idsn[$data[5]] = $res->row()->out_param;
           
        }
         return true;
    }

    public function m_insert($data){
      $this->db->query("CALL `sp_tb_indicadores_insert`(?,?,?,?,@s)", $data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }
    public function m_delete($data){
      $this->db->query("DELETE FROM `tb_indicador`  WHERE  `ind_id` = ?", $data);
      return 1;
    }

    public function m_update($data){
      $this->db->query("CALL `sp_tb_indicadores_update_nombre`(?,?,@s)", $data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }
 
}
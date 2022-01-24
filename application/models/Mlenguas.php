<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mlenguas extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_lenguas()
    {
        $result = $this->db->query("SELECT 
          tb_lenguas.lg_id as codigo,
          tb_lenguas.lg_nombre as nombre
        FROM
          tb_lenguas
        ORDER BY tb_lenguas.lg_nombre ASC ");

        return $result->result();
    }    


}


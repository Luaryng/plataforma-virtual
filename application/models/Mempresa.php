<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mempresa extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_empresa_index()
    {

        $empresa =$this->db->query("SELECT 
            tb_empresa.ep_id id,
            tb_empresa.ep_descripcion descripcion,
            tb_empresa.ep_imagen imagen,
            tb_empresa.ep_fecha fecha
          FROM
            tb_empresa");
        $datos = $empresa->result();

        foreach ($datos as $key => $dt) {
            if ($dt->id=="Misión"){
                 $data['mision'] = $dt;
            }
            elseif ($dt->id=="Visión"){
                 $data['vision'] = $dt;
            }
            elseif ($dt->id=="Organigrama"){
                 $data['organi'] = $dt;
            }
            elseif ($dt->id=="Objetivo general"){
                 $data['ObjGeneral'] = $dt;
            }
            elseif ($dt->id=="Fines"){
                 $data['fines'] = $dt;
            }
        }

        return $data;
    }


    public function fn_update_datosEmpresa($data) {
        $this->db->query("CALL `sp_update_tb_empresa`(?,?,?,@s);", $data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;
    }
    
    public function m_captura_organixcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
            tb_empresa.ep_imagen imagen
          FROM
            tb_empresa
          WHERE
            tb_empresa.ep_id = ? LIMIT 1", $codigo);
        return $result->row();
    }

    

}
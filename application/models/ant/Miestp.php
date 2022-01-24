<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Miestp extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_datos()
    {
        $result = $this->db->query("SELECT 
          tb_institucion.ies_codigo id,
          tb_institucion.ies_nombre nombre,
          tb_institucion.ies_codmodular codmodular,
          tb_institucion.ies_gestion gestion,
          tb_institucion.ies_dre dre,
          tb_institucion.ies_resolucion resolucion,
          tb_institucion.ies_renovacion revalidacion,
          tb_institucion.ies_centro_poblado centropoblado,
          tb_institucion.ies_email email,
          tb_institucion.ies_web web,
          tb_institucion.ies_telefono telefono,
          tb_institucion.ies_direccion direccion,
          tb_distrito.dis_nombre distrito,
          tb_provincia.prv_nombre provincia,
          tb_departamento.dep_nombre departamento
        FROM
          tb_provincia
          INNER JOIN tb_distrito ON (tb_provincia.prv_codigo = tb_distrito.cod_provincia)
          INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
          INNER JOIN tb_institucion ON (tb_distrito.dis_codigo = tb_institucion.cod_distrito) LIMIT 1");
        return   $result->row();
    }

    public function m_get_datosxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_institucion.ies_codigo id,
          tb_institucion.ies_nombre nombre,
          tb_institucion.ies_codmodular codmodular,
          tb_institucion.ies_gestion gestion,
          tb_institucion.ies_dre dre,
          tb_institucion.ies_resolucion resolucion,
          tb_institucion.ies_renovacion revalidacion,
          tb_institucion.ies_centro_poblado centropoblado,
          tb_institucion.ies_email email,
          tb_institucion.ies_web web,
          tb_institucion.ies_telefono telefono,
          tb_institucion.ies_direccion direccion,
          tb_institucion.cod_distrito codist
        FROM
          tb_institucion
        WHERE
          tb_institucion.ies_codigo = ?", $codigo);
        return   $result->result();
    }

    public function update_datos($data){

        $this->db->query("CALL `sp_tb_institucion_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }
}
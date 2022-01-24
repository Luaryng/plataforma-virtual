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
          tb_institucion.ies_creacion creacion,
          tb_institucion.ies_centro_poblado centropoblado,
          tb_institucion.ies_email email,
          tb_institucion.ies_web web,
          tb_institucion.ies_telefono telefono,
          tb_institucion.ies_direccion direccion,
          tb_institucion.ies_activo as activo,
          tb_institucion.cod_distrito as idistrito,
          tb_distrito.dis_nombre distrito,
          tb_provincia.prv_nombre provincia,
          tb_departamento.dep_nombre departamento,
          tb_institucion.ins_denominacion_l as denoml,
          tb_institucion.ins_denominacion_c as denomc,
          tb_institucion.ins_solonombre as snombre,
          tb_institucion.ins_prenombre as pnombre,
          tb_institucion.ies_gsuite_cid as gsuite,
          tb_institucion.ies_gsuite_akey as gsuitekey,
          tb_institucion.ies_gsuite_csc as gsuitecsc,
          tb_institucion.ins_acceso_plataforma as accplataf,
          tb_institucion.ins_acceso_gmail as accgmail,
          tb_institucion.ins_correo_soporte as emailsoport,
          tb_institucion.ins_wstp_soporte as whatsoporte,
          tb_distrito.cod_provincia AS codprovincia,
          tb_provincia.cod_departamento AS coddepartamento

        FROM
          tb_provincia
          INNER JOIN tb_distrito ON (tb_provincia.prv_codigo = tb_distrito.cod_provincia)
          INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
          INNER JOIN tb_institucion ON (tb_distrito.dis_codigo = tb_institucion.cod_distrito) LIMIT 1");
        return   $result->row();
    }

    
    public function update_datos($data){
        $this->db->query("CALL `sp_tb_institucion_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    
}
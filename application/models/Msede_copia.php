<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Msede extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_sedes()
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
                      `id_sede` id,
                      `sed_nombre` nombre,
                      `sed_activo` activo
                    FROM 
                      `tb_sede`;");
        return $result->result();
    }

    public function m_get_sede_activa()
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
          tb_persona.per_dni AS dni,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_sede.sed_nombre AS sede
        FROM
          tb_persona
          INNER JOIN tb_sede ON (tb_persona.per_codigo = tb_sede.cod_persona) 
        WHERE tb_sede.id_sede=?",array($_SESSION['userActivo']->idsede));
        return $result->row();
    }


    public function m_get_sedes_por_usuario($data)
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
                  tb_usuario_sede.cod_sede idsede,
                  tb_usuario_sede.usse_defecto esdefecto,
                  tb_usuario_sede.usse_activo activo              
                FROM
                  tb_usuario_sede  
                WHERE tb_usuario_sede.cod_usuario=?",$data);
        return $result->result();
    }

    public function mInsert_sede($items)
    {
        $this->db->query("CALL `sp_tb_sede_insert`(?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }

    public function mUpdate_sede($items)
    {
        $this->db->query("CALL `sp_tb_sede_update`(?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function mupdate_confactsede($items)
    {
        $this->db->query("CALL `sp_tb_sede_update_facturacion`(?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_get_sedes_all()
    {
        $result = $this->db->query("SELECT 
            tb_sede.id_sede AS id,
            tb_sede.sed_nombre AS nombre,
            tb_sede.cod_distrito AS codist,
            tb_distrito.dis_nombre AS nomdist,
            tb_sede.sed_activo AS activo,
            tb_sede.cod_persona AS percod,
            CONCAT(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS nombres,
            tb_sede.sed_tipo_local AS local
          FROM
            tb_sede
            INNER JOIN tb_distrito ON (tb_sede.cod_distrito = tb_distrito.dis_codigo)
            LEFT OUTER JOIN tb_persona ON (tb_sede.cod_persona = tb_persona.per_codigo)
          ORDER BY
            tb_sede.sed_nombre ");
        return $result->result();
    }

    public function m_get_sedesxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_sede.id_sede  AS id,
          tb_sede.sed_nombre AS nombre,
          tb_sede.cod_distrito  AS codist,
          tb_distrito.dis_nombre AS nomdist,
          tb_provincia.prv_codigo  AS codprov,
          tb_provincia.prv_nombre  AS nomprov,
          tb_departamento.dep_codigo AS codep,
          tb_departamento.dep_nombre AS nomdep,
          tb_sede.sed_activo AS activo,
          tb_sede.cod_persona AS percod,
          CONCAT(tb_persona.per_apel_paterno,' ',
          tb_persona.per_apel_materno,' ',
          tb_persona.per_nombres) AS nombres,
          tb_sede.sed_tipo_local AS local,
          tb_sede.sed_direccion AS direccion,
          tb_sede.sed_ruta_nubefact as ruta,
          tb_sede.sed_token_nubefact as token,
          tb_sede.conf_docente_agrega_estudiante as docest,
          tb_sede.conf_estudiante_ve_notas as estnot,
          tb_sede.conf_docente_recuperacion as docrec,
          tb_sede.conf_alumno_descarga_boleta as aludesnot,
          tb_sede.conf_autobloqueo_pago as bloqueo
        FROM
          tb_sede
          INNER JOIN tb_distrito ON (tb_sede.cod_distrito = tb_distrito.dis_codigo ) 
          LEFT OUTER JOIN tb_persona ON (tb_sede.cod_persona = tb_persona.per_codigo ) 
          INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo ) 
          INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo ) 
        WHERE tb_sede.id_sede = ? LIMIT 1 ", $codigo);
        return $result->row();
    }

    public function m_eliminasede($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_sede where id_sede = ? ", $codigo);
        
        return 1;
    }

    public function m_get_sedes_activos()
    {
        $result = $this->db->query("SELECT 
          tb_sede.id_sede  AS id,
          tb_sede.sed_nombre AS nombre,
          tb_sede.cod_distrito  AS codist,
          tb_sede.sed_activo AS activo,
          tb_sede.cod_persona AS percod,
          tb_sede.sed_tipo_local AS local
        FROM
          tb_sede
          WHERE tb_sede.sed_activo = 'SI'
        ORDER BY tb_sede.sed_nombre ASC ");
        return $result->result();
    }

    public function m_get_ciclos()
    {
        $result = $this->db->query("SELECT 
          tb_ciclo.cic_codigo   AS id,
          tb_ciclo.cic_nombre AS nombre,
          tb_ciclo.cic_anios  AS anios,
          tb_ciclo.cic_letras AS letras
        FROM
          tb_ciclo
        ORDER BY tb_ciclo.cic_nombre ASC ");
        return $result->result();
    }

    public function m_get_sedesxnombre($data)
    {
        $result = $this->db->query("SELECT 
            tb_sede.id_sede AS id,
            tb_sede.sed_nombre AS nombre,
            tb_sede.cod_distrito AS codist,
            tb_distrito.dis_nombre AS nomdist,
            tb_sede.sed_activo AS activo,
            tb_sede.cod_persona AS percod,
            CONCAT(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS nombres,
            tb_sede.sed_tipo_local AS local
          FROM
            tb_sede
            INNER JOIN tb_distrito ON (tb_sede.cod_distrito = tb_distrito.dis_codigo)
            LEFT OUTER JOIN tb_persona ON (tb_sede.cod_persona = tb_persona.per_codigo)
          WHERE tb_sede.sed_nombre like ?
          ORDER BY
            tb_sede.sed_nombre ", $data);
        return $result->result();
    }


}
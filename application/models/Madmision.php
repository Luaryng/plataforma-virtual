<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Madmision extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_filtrar_historial($data)
    {
        $rscuentas=array();
        //$rsdeudas=array();
        $result = $this->db->query("SELECT 
          tb_persona.per_codigo AS idpersona,
          tb_persona.per_codigo_sec AS codpersona,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_tipodoc AS tipodoc,
          tb_persona.per_dni AS numero,
          tb_persona.per_sexo AS sexo,
          tb_persona.per_fechacreacion visita 
        FROM
          tb_persona
        WHERE  concat(tb_persona.per_dni,' ',tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno ,' ',tb_persona.per_nombres) like ? 
        ORDER BY  tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres LIMIT 20", $data);

        $rscuentas=$result->result();
        return array('historial' => $rscuentas);
    }



    public function m_get_inscripciones_por_dni($data)
    {
        $result = $this->db->query("SELECT 
            tb_persona.per_codigo AS idpersona,
            tb_inscripcion.ins_identificador AS idinscripcion,
            tb_inscripcion.ins_carnet AS carnet,
            tb_inscripcion.cod_carrera AS codcarrera,
            tb_carrera.car_nombre AS carrera,
            concat(tb_persona.per_tipodoc,'-',tb_persona.per_dni) AS dni,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_sexo AS sexo,
            tb_inscripcion.ins_estado AS estado
          FROM
            tb_persona
            INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
            INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
            INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id) 
          WHERE tb_persona.per_dni=? LIMIT 1", $data);
        return   $result->result();
    }

    public function m_get_inscripciones_por_carne($data)
    {
        $result = $this->db->query("SELECT 
            tb_persona.per_codigo AS idpersona,
            tb_inscripcion.ins_identificador AS idinscripcion,
            tb_inscripcion.ins_carnet AS carnet,
            tb_inscripcion.cod_carrera AS codcarrera,
            tb_carrera.car_nombre AS carrera,
            concat(tb_persona.per_tipodoc,'-',tb_persona.per_dni) AS dni,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_sexo AS sexo,
            tb_inscripcion.ins_estado AS estado
          FROM
            tb_persona
            INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
            INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
            INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id) 
          WHERE tb_inscripcion.ins_carnet=?", $data);
        return   $result->result();
    }

    public function m_get_inscripciones_buscar($tipo,$data)
    {
        $sql="SELECT 
            tb_persona.per_codigo AS idpersona,
            tb_inscripcion.ins_identificador AS idinscripcion,
            tb_inscripcion.ins_carnet AS carnet,
            tb_inscripcion.cod_carrera AS codcarrera,
            tb_carrera.car_nombre AS carrera,
            concat(tb_persona.per_tipodoc,'-',tb_persona.per_dni) AS dni,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_sexo AS sexo,
            tb_inscripcion.ins_estado AS estado
          FROM
            tb_persona
            INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
            INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
            INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)";
        $carrera="";
        if ($tipo=='txt'){
          $sqlw="WHERE concat(tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno,' ',tb_persona.per_nombres)=?";
        }
        $result = $this->db->query($sql." ".$sqlw, $data);
        return   $result->result();
    }

    public function m_get_matriculas_x_persona($codigo)
    {
        $result = $this->db->query("SELECT 
              tb_matricula.mtr_id AS codigo,
              tb_matricula.codigoinscripcion AS codinscripcion,
              tb_inscripcion.ins_carnet AS carne,
              tb_matricula.mtr_apel_paterno AS paterno,
              tb_matricula.mtr_apel_materno AS materno,
              tb_matricula.mtr_nombres AS nombres,
              tb_matricula.codigoperiodo AS codperiodo,
              tb_periodo.ped_nombre AS periodo,
              tb_matricula.codigocarrera AS codcarrera,
              tb_carrera.car_nombre AS carrera,
              tb_carrera.car_sigla AS sigla,
              tb_matricula.codigociclo AS codciclo,
              tb_ciclo.cic_nombre AS ciclo,
              tb_persona.per_codigo AS idpersona
            FROM
              tb_persona
              INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
              INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
              INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
              INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
              INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
            WHERE
              tb_persona.per_codigo = ?", $codigo);
        return   $result->result();
    }

    public function mUpdate_datos_personales($data)
    {
        $this->db->query("CALL `sp_tb_persona_update_personales2`(?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return   $res->row()->out_param;
    }

    public function mUpdate_datosper_matricula($data)
    {
        $this->db->query("CALL `sp_tb_matricula_update_personales_datos`(?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return   $res->row()->out_param;
    }
    
   

}


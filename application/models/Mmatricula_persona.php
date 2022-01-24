<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmatricula_persona extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_filtrar_data_persona($data)
    {
        $result = $this->db->query("SELECT 
          tb_persona.per_codigo AS idpersona,
          tb_persona.per_codigo_sec AS codpersona,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_tipodoc AS tipodoc,
          tb_persona.per_dni AS numero,
          tb_persona.per_sexo AS sexo,
          tb_persona.per_fechacreacion visita,
          tb_inscripcion.ins_carnet as carne
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
        WHERE  concat(tb_persona.per_dni,' ',tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno ,' ',tb_persona.per_nombres) like ? 
        ORDER BY  tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres LIMIT 20", $data);

        return $result->result();
    }

    public function mUpdate_datos($data){

        $this->db->query("CALL `sp_tb_persona_update_personales`(?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return   $res->row()->out_param;    
    }

    public function m_filtrar_matriculaxcarne($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
          tb_matricula.mtr_id AS codigo,
          tb_matricula.codigoinscripcion AS codinscripcion,
          tb_inscripcion.ins_carnet AS carne,
          tb_matricula.mtr_apel_paterno AS paterno,
          tb_matricula.mtr_apel_materno AS materno,
          tb_matricula.mtr_nombres AS nombres,
          tb_matricula.codigoperiodo as codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_matricula.codigocarrera as codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla as sigla,
          tb_matricula.codigociclo as codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_matricula.codigoturno AS codturno,
          tb_matricula.codigoseccion AS codseccion,
          tb_matricula.codigoplan as codplan,
          substr(tb_estadoalumno.esal_nombre,1,3) AS estado,
           tb_persona.per_celular as celular1,
           tb_persona.per_celular2 as celular2,
           tb_persona.per_telefono as telefono
        FROM
          tb_periodo
          INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
          INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
          INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
          INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
        WHERE 
          tb_inscripcion.ins_carnet = ?
        ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigoplan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data);
        return $resultmiembro->result();
    }

    public function mUpdate_datos_matricula($data)
    {
        $this->db->query("CALL `sp_tb_matricula_update_personales`(?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return   $res->row()->out_param;
    }
   

}


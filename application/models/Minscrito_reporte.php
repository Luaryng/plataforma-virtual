<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Minscrito_reporte extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_filtrar_basico_sd_activa_reportes($data)
    {
      if ($data[1]=="0") $data[1]="%";
      $result = $this->db->query("SELECT 
          tb_inscripcion_detalle.cod_periodo AS codperiodo,
          tb_inscripcion_detalle.cod_ciclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_identificador AS codinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS carsigla,
          tb_inscripcion.id_plan AS codplan,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_inscripcion_detalle.inde_estado AS estado,
          tb_inscripcion_detalle.cod_turno AS codturno,
          tb_turno.tur_nombre AS turno,
          tb_inscripcion_detalle.cod_campania AS codcampania,
          tb_campania.cam_nombre AS campania,
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_persona.per_email_personal AS epersonal,
          tb_usuario.usu_email_corporativo AS ecorporativo,
          tb_inscripcion_detalle.cod_seccion as codseccion,
          tb_seccion.sec_nombre as seccion,
          tb_inscripcion_detalle.inde_observacion as observacion
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
          LEFT OUTER JOIN tb_turno ON (tb_inscripcion_detalle.cod_turno = tb_turno.tur_codigo)
          INNER JOIN tb_campania ON (tb_inscripcion_detalle.cod_campania = tb_campania.cam_id)
          LEFT OUTER JOIN tb_usuario ON (tb_inscripcion.ins_identificador = tb_usuario.usu_codente)
          INNER JOIN tb_ciclo ON (tb_inscripcion_detalle.cod_ciclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_seccion ON (tb_inscripcion_detalle.cod_seccion = tb_seccion.sec_codigo)
              WHERE tb_inscripcion_detalle.cod_periodo like ? AND tb_inscripcion_detalle.cod_campania LIKE ? AND tb_inscripcion.cod_carrera like ? AND tb_inscripcion_detalle.cod_turno LIKE ? AND tb_inscripcion_detalle.cod_seccion LIKE ? AND tb_inscripcion_detalle.cod_sede=? AND 
                    concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) LIKE ? 
        ORDER BY tb_inscripcion_detalle.cod_periodo DESC,tb_inscripcion_detalle.cod_campania,tb_inscripcion.cod_carrera,tb_inscripcion_detalle.cod_turno,tb_inscripcion_detalle.cod_seccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres", $data);
      
      return   $result->result();
    }

    public function m_filtrar_basico_inscritos($data)
    {
      if ($data[1]=="0") $data[1]="%";
      $result = $this->db->query("SELECT 
          tb_inscripcion_detalle.cod_periodo AS codperiodo,
          tb_inscripcion_detalle.cod_ciclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_identificador AS codinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS carsigla,
          tb_inscripcion.id_plan AS codplan,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_persona.per_celular AS celular,
          tb_persona.per_telefono AS telefono,
          tb_persona.per_celular2 AS celular2,
          tb_inscripcion_detalle.inde_estado AS estado,
          tb_inscripcion_detalle.cod_turno AS codturno,
          tb_turno.tur_nombre AS turno,
          tb_inscripcion_detalle.cod_campania AS codcampania,
          tb_campania.cam_nombre AS campania,
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_persona.per_email_personal AS epersonal,
          tb_usuario.usu_email_corporativo AS ecorporativo,
          tb_inscripcion_detalle.cod_seccion as codseccion,
          tb_seccion.sec_nombre as seccion,
          tb_inscripcion_detalle.inde_observacion as observacion
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
          LEFT OUTER JOIN tb_turno ON (tb_inscripcion_detalle.cod_turno = tb_turno.tur_codigo)
          INNER JOIN tb_campania ON (tb_inscripcion_detalle.cod_campania = tb_campania.cam_id)
          LEFT OUTER JOIN tb_usuario ON (tb_inscripcion.ins_identificador = tb_usuario.usu_codente)
          INNER JOIN tb_ciclo ON (tb_inscripcion_detalle.cod_ciclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_seccion ON (tb_inscripcion_detalle.cod_seccion = tb_seccion.sec_codigo)
              WHERE tb_inscripcion_detalle.cod_periodo like ? AND tb_inscripcion_detalle.cod_campania LIKE ? AND tb_inscripcion.cod_carrera like ? AND tb_inscripcion_detalle.cod_turno LIKE ? AND tb_inscripcion_detalle.cod_seccion LIKE ? AND tb_inscripcion_detalle.cod_sede=? AND 
                    concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) LIKE ? 
        ORDER BY tb_inscripcion_detalle.cod_periodo DESC,tb_inscripcion_detalle.cod_campania,tb_inscripcion.cod_carrera,tb_inscripcion_detalle.cod_turno,tb_inscripcion_detalle.cod_seccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres", $data);
      
      return   $result->result();
    }

}

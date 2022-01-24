<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mvirtualalumno extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }

     public function m_get_matricula_x_carne_periodo($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
      tb_inscripcion.ins_carnet AS carne,
      tb_persona.per_apel_paterno AS paterno,
      tb_persona.per_apel_materno AS materno,
      tb_persona.per_nombres AS nombres,
      tb_periodo.ped_nombre AS periodo,
      tb_inscripcion.id_plan AS codplan,
      tb_carrera.car_nombre AS carrera,
      tb_carrera.car_nivel_formativo as  nivel,
      tb_ciclo.cic_codigo AS ciclo,
      tb_turno.tur_nombre AS turno,
      tb_matricula.codigoseccion AS codseccion,
      tb_matricula.mtr_fecha as fecha,
      tb_periodo.ped_anio as anio,
      tb_persona.per_tipodoc as tipodoc,
      tb_persona.per_dni as dni,
      tb_matricula.mtr_id as matricula
    FROM
      tb_periodo
      INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
      INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
      INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
      INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
      INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
      INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
    WHERE tb_inscripcion.ins_carnet=? AND  tb_matricula.codigoperiodo=? LIMIT 1", $data);
        ////$this->db->close();
        return $resultmiembro->row();
    }

    public function m_get_cursos_visibles_x_carnet($data){
        $result = $this->db->query("SELECT 
          tb_carga_academica.cac_id AS codcarga,
          tb_carga_academica.codigoperiodo AS codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_carga_academica.codigocarrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS sigla,
          tb_carga_academica.codigociclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_carga_academica.codigoturno AS codturno,
          tb_carga_academica.codigoseccion AS codseccion,
          tb_carga_academica_subseccion.codigosubseccion AS division,
          tb_unidad_didactica.undd_nombre AS unidad,
          tb_carga_academica.cac_activo AS activo,
          tb_unidad_didactica.codigomodulo AS codmodulo,
          tb_modulo_educativo.mod_nombre AS modulo,
          tb_carga_academica_subseccion.cas_nrosesiones AS sesiones,
          tb_carga_academica_subseccion.cas_avance_ses AS avance,
          tb_carga_academica_subseccion.cas_activo AS mostrar,
          tb_carga_academica_subseccion.cas_culminado AS culminado,
          tb_inscripcion.ins_carnet AS carnet,
          tb_carga_subseccion_miembros.csm_eliminado AS eliminado,
          tb_carga_subseccion_miembros.csm_id AS codmiembro,
          tb_persona.per_apel_paterno AS docpaterno,
          tb_persona.per_apel_materno AS docmaterno,
          tb_persona.per_nombres AS docnombres,
          tb_sede.sed_nombre as carga_sede
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
          AND (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
          INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
          INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
          LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
          INNER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede)
        WHERE tb_inscripcion.ins_carnet=?
        ORDER BY tb_carga_academica.codigoperiodo DESC,tb_carga_academica.codigocarrera,tb_carga_academica.codigociclo,tb_unidad_didactica.undd_nombre", $data);
        return   $result->result();
    }

   

    

    


    

    


     public function m_get_detalle_x_tarea($data)
    {
      $result = $this->db->query("SELECT 
        `vdet_nombre` as nombre,
        `vdet_link` as link,
        `vdet_peso` as peso,
        `vdet_tipo` as tipo
      FROM 
        `tb_virtual_tarea_detalle` 
      WHERE virt_id=? and vdet_id=? limit 1",$data);
        return $result->row();
    }


}
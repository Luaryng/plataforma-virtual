<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmonitoreo_alumno extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function m_get_cursos_x_matricula_unidad($data)
	{
		$result = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_periodo.ped_nombre AS periodo,
			  tb_carrera.car_sigla AS sigla,
			  tb_carrera.car_nombre AS carrera,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_carga_academica.codigoturno AS codturno,
			  tb_turno.tur_nombre AS turno,
			  tb_carga_academica.codigoseccion AS codseccion,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_unidad_didactica.undd_nombre AS curso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_carga_academica_subseccion.cas_culminado AS culminado
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
			  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
			  INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
			  INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
			  INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
			  LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
			WHERE
			  tb_carga_subseccion_miembros.cod_matricula = ? AND tb_carga_academica.codigouindidadd = ? AND tb_carga_subseccion_miembros.csm_eliminado = 'NO' order by tb_unidad_didactica.undd_nombre", $data);
		
      return   $result->row();
	}

	public function m_get_notas_x_unidad($data)
	{
      $result = $this->db->query("SELECT 
		  tb_indicador.ind_nombre as indicador,
		  tb_indicador.ind_nroorden as orden,
		  tb_unidad_didactica.undd_nombre as unidad,
		  tb_carga_evaluaciones_head.evh_nombre as head,
		  tb_carga_evaluaciones_head.evh_nombrecorto as chead,
		  tb_carga_evaluaciones.ecu_nota as nota
		FROM
		  tb_carga_evaluaciones_head
		  INNER JOIN tb_carga_evaluaciones ON (tb_carga_evaluaciones_head.evh_id = tb_carga_evaluaciones.idevaluacionhead)
		  INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_evaluaciones.codigocarga)
		  INNER JOIN tb_indicador ON (tb_carga_evaluaciones_head.codigoindicador = tb_indicador.ind_id)
		  INNER JOIN tb_unidad_didactica ON (tb_unidad_didactica.undd_codigo = tb_carga_academica.codigouindidadd)
		WHERE
		  tb_carga_academica.codigoperiodo = ? AND 
		  tb_carga_academica.codigouindidadd = ? AND 
		  tb_carga_evaluaciones.idmiembro = ?", $data);
      return   $result->result();
 	}




}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mpracticas extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function m_filtrar_alumnos($data)
	{
		$result = $this->db->query("SELECT 
		  tb_inscripcion.ins_identificador AS idins,
		  tb_inscripcion.ins_carnet AS carne,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_inscripcion_detalle.cod_periodo AS idperiodo,
		  tb_periodo.ped_nombre AS periodo,
		  tb_inscripcion.cod_carrera AS idcarrera,
		  tb_carrera.car_nombre AS carrera,
		  tb_carrera.car_sigla AS sigla,
		  tb_inscripcion_detalle.cod_ciclo AS idciclo,
		  tb_ciclo.cic_nombre AS ciclo,
		  tb_inscripcion_detalle.cod_plpan AS idplan,
		  tb_plan_estudios.pln_nombre AS plan,
		  tb_modalidad.mod_nombre as modalidad
		FROM
		  tb_persona
		  INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
		  LEFT OUTER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
		  LEFT OUTER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
		  INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
		  LEFT OUTER JOIN tb_plan_estudios ON (tb_inscripcion_detalle.cod_plpan = tb_plan_estudios.pln_id)
		  LEFT OUTER JOIN tb_ciclo ON (tb_inscripcion_detalle.cod_ciclo = tb_ciclo.cic_codigo)
		  LEFT OUTER JOIN tb_modalidad ON (tb_inscripcion_detalle.cod_modalidad = tb_modalidad.mod_id)
		WHERE
		  tb_inscripcion_detalle.cod_periodo LIKE ? AND tb_inscripcion.cod_carrera LIKE ? 
		  AND tb_inscripcion_detalle.cod_plpan LIKE ? AND 
		  CONCAT(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno,' ',tb_persona.per_apel_materno,' ',tb_persona.per_nombres) LIKE ?
		  AND tb_inscripcion.ins_sede = ?
		ORDER BY
		  tb_inscripcion.cod_carrera,
		  tb_persona.per_apel_paterno,
		  tb_persona.per_apel_materno,
		  tb_persona.per_nombres,
		  tb_inscripcion_detalle.cod_periodo
		 LIMIT 100", $data);
		return   $result->result();
	}

	public function m_get_detalle_practicas($data)
  {
      $result = $this->db->query("SELECT 
			  tb_inscripcion.ins_identificador AS idins,
			  tb_inscripcion.ins_carnet AS carne,
			  tb_inscripcion_detalle.cod_plpan AS idplan,
			  tb_plan_estudios.pln_nombre AS plan,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres
			FROM
			  tb_persona
			  INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
			  INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
			  INNER JOIN tb_plan_estudios ON (tb_inscripcion_detalle.cod_plpan = tb_plan_estudios.pln_id)
			WHERE
			  tb_inscripcion.ins_identificador = ? AND tb_inscripcion_detalle.cod_periodo = ? limit 1", $data);

    $arr_result['inscrito']= $result->row();

      $result = $this->db->query("SELECT 
      tb_practicas_etapa_inscripcion.cod_inscripcion AS codins,
		  tb_practicas_etapa_inscripcion.cod_practica_etapa AS codpraet,
		  tb_practicas_etapa_inscripcion.pei_estado AS estado,
		  tb_practicas_etapa_inscripcion.pei_fecha_culminado AS culminado,
		  tb_practicas_etapa_inscripcion.id_usuario_culmina AS usculmina,
		  tb_practicas_etapa_inscripcion.pei_fecha_presentacion_folder AS folder,
		  tb_practicas_etapa_inscripcion.pei_fecha_presentacion_informe AS informe,
		  tb_practicas_etapa_inscripcion.pei_observaciones AS observacion,
		  tb_practicas_etapa_inscripcion.pei_fecha_evaluacion AS evaluacion,
		  tb_practicas_etapa_inscripcion.pei_nota AS nota,
		  tb_practica_etapas.pet_nombre AS etapa
    FROM
      tb_practicas_etapa_inscripcion
      RIGHT OUTER JOIN tb_practica_etapas ON (tb_practica_etapas.pet_id = tb_practicas_etapa_inscripcion.cod_practica_etapa)
     WHERE tb_practicas_etapa_inscripcion.cod_inscripcion = ?", array($data[0]));

      $arr_result['etains']= $result->result();

      $result = $this->db->query("SELECT 
			  tb_practicas_estudiante.pest_id AS codigo,
			  tb_practicas_estudiante.cod_inscripcion AS isncod,
			  tb_practicas_estudiante.cod_practicas_etapa AS praetcod,
			  tb_practicas_estudiante.cod_ciclo AS idciclo,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_practicas_estudiante.pest_fecha_inicia AS inicia,
			  tb_practicas_estudiante.pest_fecha_finaliza AS finaliza,
			  tb_practicas_estudiante.pest_horas_acumuladas AS horasacu,
			  tb_practicas_estudiante.cod_practicas_modalidad AS modalidad,
			    tb_practica_modalidad.pm_nombre as nom_modalidad,
			  tb_practicas_estudiante.pest_estado AS estadop,
			  tb_practicas_estudiante.pest_docente_guia AS docenteg,
			  tb_practicas_estudiante.pest_asesor_guia AS asesorg,
			  tb_practicas_estudiante.pest_nombre_proyecto AS proyecto,
			  tb_practicas_estudiante.cod_empresa AS codempresa,
			  tb_practica_etapas.pet_nombre AS etnombre,
			  tb_empresas.emp_razon_social AS empresa
			FROM
			  tb_practicas_estudiante
			  RIGHT OUTER JOIN tb_practica_etapas ON (tb_practica_etapas.pet_id = tb_practicas_estudiante.cod_practicas_etapa)
			  LEFT OUTER JOIN tb_ciclo ON (tb_ciclo.cic_codigo = tb_practicas_estudiante.cod_ciclo)
			  LEFT OUTER JOIN tb_empresas ON (tb_practicas_estudiante.cod_empresa = tb_empresas.emp_id)
			  INNER JOIN tb_practica_modalidad ON (tb_practicas_estudiante.cod_practicas_modalidad = tb_practica_modalidad.pm_id)
    	WHERE tb_practicas_estudiante.cod_inscripcion = ?", array($data[0]));

      $arr_result['practicas']= $result->result();

      return $arr_result;
  }

  public function m_get_etapas($data)
  {
    $result = $this->db->query("SELECT 
      tb_practica_etapas.pet_id as codigo,
      tb_practica_etapas.pet_nombre as nombre,
      tb_practica_etapas.pet_habilitado as habilitado,
      tb_practica_etapas_plan.codigo_plan as idplan,
      tb_plan_estudios.pln_nombre as plan,
      tb_practica_etapas_plan.pep_horas as horas
    FROM
      tb_practica_etapas
      LEFT OUTER JOIN tb_practica_etapas_plan ON (tb_practica_etapas_plan.cod_practica_etapa = tb_practica_etapas.pet_id)
      LEFT OUTER JOIN tb_plan_estudios ON (tb_plan_estudios.pln_id = tb_practica_etapas_plan.codigo_plan)
     WHERE tb_practica_etapas_plan.codigo_plan = ? AND tb_practica_etapas_plan.pep_habilitado = 'SI'
    ORDER BY tb_practica_etapas.pet_id ASC ", $data);
    return $result->result();
  }

	public function m_get_prmodalidades()
  {
    $result = $this->db->query("SELECT 
      tb_practica_modalidad.pm_id as codigo,
      tb_practica_modalidad.pm_nombre as nombre
    FROM
      tb_practica_modalidad
    ORDER BY tb_practica_modalidad.pm_id ASC ");
    return $result->result();
  }

  public function m_get_empresas()
  {
    $result = $this->db->query("SELECT 
      tb_empresas.emp_id as codigo,
      tb_empresas.emp_razon_social as nombre,
      tb_empresas.emp_ruc as ruc,
      tb_empresas.emp_direccion as direccion,
      tb_empresas.emp_telefono as telefono,
      tb_empresas.cod_distrito as codistrito,
      tb_empresas.emp_contacto_apellidos as capellidos,
      tb_empresas.emp_contacto_nombres as cnombres,
      tb_empresas.emp_contacto_celular as ctelefeno
    FROM
      tb_empresas
    ORDER BY tb_empresas.emp_razon_social ASC ");
    return $result->result();
  }

  public function m_get_practicas_inscripcion($data)
  {
  	$result = $this->db->query("SELECT 
      tb_practicas_etapa_inscripcion.cod_inscripcion AS codins,
		  tb_practicas_etapa_inscripcion.cod_practica_etapa AS codpraet,
		  tb_practicas_etapa_inscripcion.pei_estado AS estado,
		  tb_practicas_etapa_inscripcion.pei_fecha_culminado AS culminado,
		  tb_practicas_etapa_inscripcion.id_usuario_culmina AS usculmina,
		  tb_practicas_etapa_inscripcion.pei_fecha_presentacion_folder AS folder,
		  tb_practicas_etapa_inscripcion.pei_observacion_folder AS obsfolder,
		  tb_practicas_etapa_inscripcion.pei_fecha_presentacion_informe AS informe,
		  tb_practicas_etapa_inscripcion.pei_observaciones AS observacion,
		  tb_practicas_etapa_inscripcion.pei_fecha_evaluacion AS evaluacion,
		  tb_practicas_etapa_inscripcion.pei_nota AS nota,
		  tb_practicas_etapa_inscripcion.pei_observacion_evaluacion AS obsevaluacion
    FROM
      tb_practicas_etapa_inscripcion
     WHERE tb_practicas_etapa_inscripcion.cod_inscripcion = ? AND tb_practicas_etapa_inscripcion.cod_practica_etapa = ? LIMIT 1", $data);
  	return $result->row();
  }

  public function mInsert_practicas($items)
  {
      $this->db->query("CALL `sp_tb_practicas_estudiante_insert`(?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
      $res = $this->db->query('select @s as salida,@nid as newcod');
      
      return $res->row();    
  }

  public function mInsert_practicas_inscripcion($items)
  {
      $this->db->query("CALL `sp_tb_practicas_etapa_inscripcion_insert`(?,?,?,@s,@nid)",$items);
      $res = $this->db->query('select @s as salida,@nid as newcod');
      
      return $res->row();    
  }

  public function mUpdate_practicas($items)
  {
      $this->db->query("CALL `sp_tb_practicas_estudiante_update`(?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
      $res = $this->db->query('select @s as salida,@nid as newcod');
      
      return $res->row();    
  }

  public function m_filtrar_practicasxcodigo($data)
  {
  	$result = $this->db->query("SELECT 
      tb_practicas_estudiante.pest_id AS codigo,
		  tb_practicas_estudiante.cod_inscripcion AS isncod,
		  tb_practicas_estudiante.cod_practicas_etapa AS praetcod,
		  tb_practicas_estudiante.cod_ciclo AS idciclo,
		  tb_practicas_estudiante.pest_fecha_inicia AS inicia,
		  tb_practicas_estudiante.pest_fecha_finaliza AS finaliza,
		  tb_practicas_estudiante.pest_horas_acumuladas AS horasacu,
		  tb_practicas_estudiante.cod_practicas_modalidad AS modalidad,
		  tb_practicas_estudiante.pest_estado AS estadop,
		  tb_practicas_estudiante.pest_docente_guia AS docenteg,
		  tb_practicas_estudiante.pest_asesor_guia AS asesorg,
		  tb_practicas_estudiante.pest_nombre_proyecto AS proyecto,
		  tb_practicas_estudiante.cod_empresa AS codempresa
    FROM
      tb_practicas_estudiante
     WHERE tb_practicas_estudiante.pest_id = ? LIMIT 1", $data);
  	return $result->row();
  }

  public function m_filtrar_practicasall($data)
  {
  	$result = $this->db->query("SELECT 
      tb_practicas_estudiante.pest_id AS codigo,
		  tb_practicas_estudiante.cod_inscripcion AS isncod,
		  tb_practicas_estudiante.cod_practicas_etapa AS praetcod,
		  tb_practicas_estudiante.cod_ciclo AS idciclo,
		  tb_practicas_estudiante.pest_fecha_inicia AS inicia,
		  tb_practicas_estudiante.pest_fecha_finaliza AS finaliza,
		  tb_practicas_estudiante.pest_horas_acumuladas AS horasacu,
		  tb_practicas_estudiante.cod_practicas_modalidad AS modalidad,
		  tb_practicas_estudiante.pest_estado AS estadop,
		  tb_practicas_estudiante.pest_docente_guia AS docenteg,
		  tb_practicas_estudiante.pest_asesor_guia AS asesorg,
		  tb_practicas_estudiante.pest_nombre_proyecto AS proyecto,
		  tb_practicas_estudiante.cod_empresa AS codempresa
    FROM
      tb_practicas_estudiante
     WHERE tb_practicas_estudiante.cod_inscripcion = ? AND tb_practicas_estudiante.cod_practicas_etapa = ?", $data);
  	return $result->result();
  }

  public function m_eliminapractica($data)
  {
  	$qry = $this->db->query("DELETE FROM tb_practicas_estudiante where pest_id = ? ", $data);
        
    return 1;
  }

  public function m_eliminapracticainscripcion($items)
  {
  	$qry = $this->db->query("DELETE FROM tb_practicas_etapa_inscripcion where cod_inscripcion = ? AND cod_practica_etapa = ?", $items);
        
    return 1;
  }

  public function m_cambiar_estadop($items)
  {
  	$this->db->query("CALL `sp_tb_practicas_estudiante_update_estado`(?,?,?,?,?,@s,@nid)",$items);
    $res = $this->db->query('select @s as salida,@nid as newcod');
      
    return $res->row(); 
  }

  public function sp_tb_practicas_etapa_inscripcion_folder_informe($items)
  {
      $this->db->query("CALL `sp_tb_practicas_etapa_inscripcion_folder_informe`(?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
      $res = $this->db->query('select @s as salida,@nid as newcod');
      
      return $res->row();    
  }

  public function m_cambiar_planciclo($items)
  {
  	$this->db->query("CALL `sp_tb_inscripcion_detalle_update_plan`(?,?,?,?,@s,@nid)",$items);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    
    return $res->row();
  }
    
}
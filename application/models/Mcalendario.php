<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mcalendario extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function m_get_cursos_visibles_x_ccarne($data){
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
          tb_carga_academica.cac_activo AS activo,
          tb_inscripcion.ins_carnet AS carnet,
          tb_carga_subseccion_miembros.csm_eliminado AS eliminado,
          tb_carga_subseccion_miembros.csm_id AS codmiembro,
          tb_carga_academica_subseccion.cas_activo AS mostrar
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
          AND (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
          INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
          INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
        WHERE tb_inscripcion.ins_identificador=? AND tb_carga_academica_subseccion.cas_activo = 'SI'
        ORDER BY tb_carga_academica.codigoperiodo DESC,tb_carga_academica.codigocarrera,tb_carga_academica.codigociclo", $data);
        return $result->result();
  }

  public function m_get_subsecciones_visibles_x_cdocente($data){
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
          tb_carga_academica_subseccion.cas_culminado AS culminado,
          tb_carga_academica_subseccion.cas_activo AS mostrar,
          tb_sede.sed_nombre as sede
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_sede ON (tb_carga_academica.cod_sede  = tb_sede.id_sede )
      WHERE tb_carga_academica_subseccion.codigodocente = ? AND tb_carga_academica_subseccion.cas_activo = 'SI'
      ORDER BY tb_periodo.ped_nombre desc,tb_carga_academica.codigocarrera,tb_carga_academica.codigociclo", $data);
      return   $result->result();
  }

  

  public function m_get_vdetalles_calendario($carga,$division)
  {
    $cargas = implode("','", $carga);
    $divisiones = implode("','", $division);

    $result = $this->db->query("SELECT 
      `vdet_id` as coddetalle,
      `virt_id` as codmaterial,
      `vdet_nombre` as nombre,
      `vdet_link` as link
    FROM 
      `tb_virtual_detalle`
    WHERE codigocarga IN ('$cargas') and codigosubseccion IN ('$divisiones') ");
      return $result->result();
  }

  public function m_get_materiales_calendario_docentes($coddocente)
  {
    

    $result = $this->db->query("SELECT 
        tb_virtual_material.virt_id AS codigo,
        tb_virtual_material.virt_nombre AS nombre,
        tb_virtual_material.virt_tipo AS tipo,
        tb_virtual_material.virt_norden AS orden,
        tb_virtual_material.virt_id_padre AS padre,
        tb_virtual_material.virt_link AS link,
        tb_virtual_material.virt_inicia AS inicia,
        tb_virtual_material.virt_vence AS vence,
        tb_virtual_material.virt_fechacreacion AS creacion,
        tb_virtual_material.virt_detalle AS detalle,
        tb_virtual_material.virt_espacio AS esp,
        tb_virtual_material.vit_mostrar_detalle AS mostrardt,
        tb_virtual_material.virt_visible AS visible,
        tb_virtual_material.virt_visible_time AS v_time,
        tb_virtual_material.codigocarga AS carga,
        tb_virtual_material.codigosubseccion AS division,
        tb_unidad_didactica.undd_nombre AS unidad
      FROM
        tb_carga_academica
        INNER JOIN tb_virtual_material ON (tb_carga_academica.cac_id = tb_virtual_material.codigocarga)
        INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
        INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
        AND (tb_carga_academica_subseccion.codigosubseccion = tb_virtual_material.codigosubseccion) 
      WHERE
        tb_carga_academica_subseccion.codigodocente = ? AND tb_virtual_material.virt_tipo IN ('C','F','V','T')",$coddocente);
      return $result->result();
  }
  public function m_sesiones_completos_x_unidad_docentes($coddocente)
  {

      $resultdoce = $this->db->query("SELECT 
        tb_carga_sesiones.ses_id AS id,
        tb_carga_sesiones.ses_nombre AS nombre,
        tb_carga_sesiones.ses_fecha AS fecha,
        tb_carga_sesiones.ses_horaini AS hini,
        tb_carga_sesiones.ses_horafin AS hfin,
        tb_carga_sesiones.ses_detalle AS detalle,
        tb_carga_sesiones.ses_tipo AS tipo,
        tb_carga_sesiones.ses_nrosesion AS nrosesion,
        tb_carga_sesiones.sese_idevento AS idevento,
        tb_carga_sesiones.sese_idconferencia AS idconferencia,
        tb_carga_sesiones.sese_hangout_link AS hlink,
        tb_carga_sesiones.sese_status_evento AS status_evento,
        tb_carga_sesiones.sese_status_conferencia AS status_conferencia,
        tb_carga_sesiones.codigocarga AS codcarga,
        tb_carga_sesiones.codigosubseccion AS division,
        tb_unidad_didactica.undd_codigo AS codunidad,
        tb_unidad_didactica.undd_nombre AS unidad
      FROM
        tb_carga_sesiones
        INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_sesiones.codigocarga)
        INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
        INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
        AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_sesiones.codigosubseccion)
      WHERE
        tb_carga_academica_subseccion.codigodocente = ?  
      ORDER BY
      ses_fecha,
      ses_horaini",$coddocente);
            return $resultdoce->result();
  }

   public function m_get_materiales_calendario_estudiante($coddocente)
  {
    

    $result = $this->db->query("SELECT 
        tb_virtual_material.virt_id AS codigo,
        tb_virtual_material.virt_nombre AS nombre,
        tb_virtual_material.virt_tipo AS tipo,
        tb_virtual_material.virt_norden AS orden,
        tb_virtual_material.virt_id_padre AS padre,
        tb_virtual_material.virt_link AS link,
        tb_virtual_material.virt_inicia AS inicia,
        tb_virtual_material.virt_vence AS vence,
        tb_virtual_material.virt_fechacreacion AS creacion,
        tb_virtual_material.virt_detalle AS detalle,
        tb_virtual_material.virt_espacio AS esp,
        tb_virtual_material.vit_mostrar_detalle AS mostrardt,
        tb_virtual_material.virt_visible AS visible,
        tb_virtual_material.virt_visible_time AS v_time,
        tb_virtual_material.codigocarga AS carga,
        tb_virtual_material.codigosubseccion AS division,
        tb_unidad_didactica.undd_nombre AS unidad,
        tb_carga_subseccion_miembros.csm_id as miembro
      FROM
        tb_carga_academica
        INNER JOIN tb_virtual_material ON (tb_carga_academica.cac_id = tb_virtual_material.codigocarga)
        INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
        INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
        INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
      WHERE
        tb_matricula.codigoinscripcion = ? AND 
        tb_carga_subseccion_miembros.csm_eliminado = 'NO' AND tb_virtual_material.virt_tipo IN ('C','F','V','T')",$coddocente);
      return $result->result();
  }
  public function m_sesiones_completos_x_unidad_estudiante($coddocente)
  {

      $resultdoce = $this->db->query("SELECT 
            tb_carga_sesiones.ses_id AS id,
            tb_carga_sesiones.ses_nombre AS nombre,
            tb_carga_sesiones.ses_fecha AS fecha,
            tb_carga_sesiones.ses_horaini AS hini,
            tb_carga_sesiones.ses_horafin AS hfin,
            tb_carga_sesiones.ses_detalle AS detalle,
            tb_carga_sesiones.ses_tipo AS tipo,
            tb_carga_sesiones.ses_nrosesion AS nrosesion,
            tb_carga_sesiones.sese_idevento AS idevento,
            tb_carga_sesiones.sese_idconferencia AS idconferencia,
            tb_carga_sesiones.sese_hangout_link AS hlink,
            tb_carga_sesiones.sese_status_evento AS status_evento,
            tb_carga_sesiones.sese_status_conferencia AS status_conferencia,
            tb_carga_sesiones.codigocarga AS codcarga,
            tb_carga_sesiones.codigosubseccion AS division,
            tb_unidad_didactica.undd_codigo AS codunidad,
            tb_unidad_didactica.undd_nombre AS unidad,
            tb_carga_subseccion_miembros.csm_id as miembro
          FROM
            tb_carga_sesiones
            INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_sesiones.codigocarga)
            INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
            INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica.cac_id)
            AND (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_sesiones.codigosubseccion)
            INNER JOIN tb_matricula ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
          WHERE
            tb_matricula.codigoinscripcion = ? AND 
            tb_carga_subseccion_miembros.csm_eliminado = 'NO' 
          ORDER BY
            ses_fecha,
            ses_horaini",$coddocente);
        return $resultdoce->result();
  }
  //DE LUIS YNGA COMENTADO POR JANIOR
  /*public function m_get_materiales_calendario($carga,$division,$miembro)
  {
    $cargas = implode("','", $carga);
    $divisiones = implode("','", $division);
    $sqlmiembros = "";
    if (count($miembro) > 0) {
      $miembros = implode("','", $miembro);
      $sqlmiembros = "AND tb_carga_subseccion_miembros.csm_id IN ('$miembros')";
    }

    $result = $this->db->query("SELECT 
      tb_virtual_material.virt_id as codigo,
      tb_virtual_material.virt_nombre as nombre,
      tb_virtual_material.virt_tipo as tipo,
      tb_virtual_material.virt_norden as orden,
      tb_virtual_material.virt_id_padre as padre,
      tb_virtual_material.virt_link as link,
      tb_virtual_material.virt_inicia as inicia,
      tb_virtual_material.virt_vence as vence,
      tb_virtual_material.virt_fechacreacion as creacion,
      tb_virtual_material.virt_detalle as detalle,
      tb_virtual_material.virt_espacio as esp,
      tb_virtual_material.vit_mostrar_detalle as mostrardt,
      tb_virtual_material.virt_visible as visible,
      tb_virtual_material.virt_visible_time as v_time,
      tb_virtual_material.codigocarga as carga,
      tb_virtual_material.codigosubseccion as division,
      tb_carga_subseccion_miembros.csm_id as miembro,
      tb_unidad_didactica.undd_nombre AS unidad
    FROM 
      tb_carga_academica
      INNER JOIN tb_virtual_material ON (tb_carga_academica.cac_id = tb_virtual_material.codigocarga)
      INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
      INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
    WHERE tb_virtual_material.codigocarga IN ('$cargas') AND  
          tb_virtual_material.codigosubseccion IN ('$divisiones') AND tb_virtual_material.virt_tipo IN ('C','F','V','T')
          $sqlmiembros
      ORDER BY tb_virtual_material.virt_norden,tb_virtual_material.virt_id_padre");
      return $result->result();
  }*/

  //POR LUYS YNGA, COMENTADO POR JANIOR
 /*public function m_sesiones_completos_x_unidad($carga,$division)
  {
    $cargas = implode("','", $carga);
    $divisiones = implode("','", $division);
      $resultdoce = $this->db->query("SELECT 
          tb_carga_sesiones.ses_id AS id,
          tb_carga_sesiones.ses_nombre AS nombre,
          tb_carga_sesiones.ses_fecha AS fecha,
          tb_carga_sesiones.ses_horaini AS hini,
          tb_carga_sesiones.ses_horafin AS hfin,
          tb_carga_sesiones.ses_detalle AS detalle,
          tb_carga_sesiones.ses_tipo AS tipo,
          tb_carga_sesiones.ses_nrosesion AS nrosesion,
          tb_carga_sesiones.sese_idevento as  idevento,
          tb_carga_sesiones.sese_idconferencia as  idconferencia,
          tb_carga_sesiones.sese_hangout_link as  hlink,
          tb_carga_sesiones.sese_status_evento as  status_evento,
          tb_carga_sesiones.sese_status_conferencia as status_conferencia,
          tb_carga_sesiones.codigocarga as codcarga,
          tb_carga_sesiones.codigosubseccion as division,
          tb_unidad_didactica.undd_codigo as codunidad,
          tb_unidad_didactica.undd_nombre AS unidad
        FROM
          tb_carga_sesiones
          INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_sesiones.codigocarga)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
        WHERE
           tb_carga_sesiones.codigocarga IN ('$cargas') AND  tb_carga_sesiones.codigosubseccion IN ('$divisiones') 
        ORDER BY
          ses_fecha,
          ses_horaini");
        return $resultdoce->result();
  }*/

  public function m_sesiones_completos_x_unidad_index($carga,$division)
  {
    $cargas = implode("','", $carga);
    $divisiones = implode("','", $division);
      $resultdoce = $this->db->query("SELECT 
          tb_carga_sesiones.ses_id AS id,
          tb_carga_sesiones.ses_nombre AS nombre,
          tb_carga_sesiones.ses_fecha AS fecha,
          tb_carga_sesiones.ses_horaini AS hini,
          tb_carga_sesiones.ses_horafin AS hfin,
          tb_carga_sesiones.ses_detalle AS detalle,
          tb_carga_sesiones.ses_tipo AS tipo,
          tb_carga_sesiones.ses_nrosesion AS nrosesion,
          tb_carga_sesiones.sese_idevento as  idevento,
          tb_carga_sesiones.sese_idconferencia as  idconferencia,
          tb_carga_sesiones.sese_hangout_link as  hlink,
          tb_carga_sesiones.sese_status_evento as  status_evento,
          tb_carga_sesiones.sese_status_conferencia as status_conferencia,
          tb_carga_sesiones.codigocarga as codcarga,
          tb_carga_sesiones.codigosubseccion as division,
          tb_unidad_didactica.undd_codigo as codunidad,
          tb_unidad_didactica.undd_nombre AS unidad
        FROM
          tb_carga_sesiones
          INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_sesiones.codigocarga)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
        WHERE
           tb_carga_sesiones.codigocarga IN ('$cargas') AND  tb_carga_sesiones.codigosubseccion IN ('$divisiones') AND 
           tb_carga_sesiones.ses_fecha = CURDATE()
        ORDER BY
          ses_fecha DESC,
          ses_horaini DESC");
        return $resultdoce->result();
  }

  public function m_get_materiales_calendario_index($carga,$division,$miembro)
  {
    $cargas = implode("','", $carga);
    $divisiones = implode("','", $division);
    $sqlmiembros = "";
    if (count($miembro) > 0) {
      $miembros = implode("','", $miembro);
      $sqlmiembros = "tb_carga_subseccion_miembros.csm_id IN ('$miembros') AND ";
    }

    $result = $this->db->query("SELECT 
      tb_virtual_material.virt_id as codigo,
      tb_virtual_material.virt_nombre as nombre,
      tb_virtual_material.virt_tipo as tipo,
      tb_virtual_material.virt_norden as orden,
      tb_virtual_material.virt_id_padre as padre,
      tb_virtual_material.virt_link as link,
      tb_virtual_material.virt_inicia as inicia,
      tb_virtual_material.virt_vence as vence,
      tb_virtual_material.virt_fechacreacion as creacion,
      tb_virtual_material.virt_detalle as detalle,
      tb_virtual_material.virt_espacio as esp,
      tb_virtual_material.vit_mostrar_detalle as mostrardt,
      tb_virtual_material.virt_visible as visible,
      tb_virtual_material.virt_visible_time as v_time,
      tb_virtual_material.codigocarga as carga,
      tb_virtual_material.codigosubseccion as division,
      tb_carga_subseccion_miembros.csm_id as miembro,
      tb_unidad_didactica.undd_nombre AS unidad
    FROM 
      tb_carga_academica
      INNER JOIN tb_virtual_material ON (tb_carga_academica.cac_id = tb_virtual_material.codigocarga)
      INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
      INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
    WHERE tb_virtual_material.codigocarga IN ('$cargas') AND  
          tb_virtual_material.codigosubseccion IN ('$divisiones') AND
          $sqlmiembros
          tb_virtual_material.virt_tipo IN ('F','V','T') AND
          CASE WHEN tb_virtual_material.virt_inicia IS NOT NULL THEN 
            tb_virtual_material.virt_inicia BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY 
          WHEN tb_virtual_material.virt_vence IS NOT NULL THEN
            tb_virtual_material.virt_vence BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY 
          ELSE 
            tb_virtual_material.virt_fechacreacion BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY 
          END
      ORDER BY CASE WHEN tb_virtual_material.virt_inicia IS NOT NULL THEN 
            tb_virtual_material.virt_inicia
          WHEN tb_virtual_material.virt_vence IS NOT NULL THEN
            tb_virtual_material.virt_vence
          ELSE 
            tb_virtual_material.virt_fechacreacion
          END DESC");
      return $result->result();
  }


  public function m_get_materiales_calendario_others_index($carga,$division,$miembro)
  {
    $cargas = implode("','", $carga);
    $divisiones = implode("','", $division);
    $sqlmiembros = "";
    if (count($miembro) > 0) {
      $miembros = implode("','", $miembro);
      $sqlmiembros = "tb_carga_subseccion_miembros.csm_id IN ('$miembros') AND ";
    }

    $result = $this->db->query("SELECT 
      tb_virtual_material.virt_id as codigo,
      tb_virtual_material.virt_nombre as nombre,
      tb_virtual_material.virt_tipo as tipo,
      tb_virtual_material.virt_norden as orden,
      tb_virtual_material.virt_id_padre as padre,
      tb_virtual_material.virt_link as link,
      tb_virtual_material.virt_inicia as inicia,
      tb_virtual_material.virt_vence as vence,
      tb_virtual_material.virt_fechacreacion as creacion,
      tb_virtual_material.virt_detalle as detalle,
      tb_virtual_material.virt_espacio as esp,
      tb_virtual_material.vit_mostrar_detalle as mostrardt,
      tb_virtual_material.virt_visible as visible,
      tb_virtual_material.virt_visible_time as v_time,
      tb_virtual_material.codigocarga as carga,
      tb_virtual_material.codigosubseccion as division,
      tb_carga_subseccion_miembros.csm_id as miembro,
      tb_unidad_didactica.undd_nombre AS unidad
    FROM 
      tb_carga_academica
      INNER JOIN tb_virtual_material ON (tb_carga_academica.cac_id = tb_virtual_material.codigocarga)
      INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
      INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
    WHERE tb_virtual_material.codigocarga IN ('$cargas') AND  
          tb_virtual_material.codigosubseccion IN ('$divisiones') AND
          $sqlmiembros
          tb_virtual_material.virt_tipo NOT IN ('F','V','T') AND
          tb_virtual_material.virt_fechacreacion BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY
      ORDER BY tb_virtual_material.virt_fechacreacion DESC");
      return $result->result();
  }

	public function m_sesiones_completos_x_fecha_index($carga,$division,$data)
  {
    $cargas = implode("','", $carga);
    $divisiones = implode("','", $division);
    if ($data[0] == "left") {
      $interfechas = "AND tb_carga_sesiones.ses_fecha = '$data[1]' - INTERVAL 1 DAY";
    } elseif ($data[0] == "right") {
      $interfechas = "AND tb_carga_sesiones.ses_fecha = '$data[1]' + INTERVAL 1 DAY";
    } else {
      $interfechas = "AND tb_carga_sesiones.ses_fecha = '$data[1]'";
    }

    $resultdoce = $this->db->query("SELECT 
        tb_carga_sesiones.ses_id AS id,
        tb_carga_sesiones.ses_nombre AS nombre,
        tb_carga_sesiones.ses_fecha AS fecha,
        tb_carga_sesiones.ses_horaini AS hini,
        tb_carga_sesiones.ses_horafin AS hfin,
        tb_carga_sesiones.ses_detalle AS detalle,
        tb_carga_sesiones.ses_tipo AS tipo,
        tb_carga_sesiones.ses_nrosesion AS nrosesion,
        tb_carga_sesiones.sese_idevento as  idevento,
        tb_carga_sesiones.sese_idconferencia as  idconferencia,
        tb_carga_sesiones.sese_hangout_link as  hlink,
        tb_carga_sesiones.sese_status_evento as  status_evento,
        tb_carga_sesiones.sese_status_conferencia as status_conferencia,
        tb_carga_sesiones.codigocarga as codcarga,
        tb_carga_sesiones.codigosubseccion as division,
        tb_unidad_didactica.undd_codigo as codunidad,
        tb_unidad_didactica.undd_nombre AS unidad
      FROM
        tb_carga_sesiones
        INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_sesiones.codigocarga)
        INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
      WHERE
         tb_carga_sesiones.codigocarga IN ('$cargas') AND  tb_carga_sesiones.codigosubseccion IN ('$divisiones') 
         $interfechas
      ORDER BY
        ses_fecha ASC,
        ses_horaini ASC");
      return $resultdoce->result();
  }

}
 
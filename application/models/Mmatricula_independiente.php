<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmatricula_independiente extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    

    public function m_get_mat_final_x_miembro($data)
    {
        $result = $this->db->query("SELECT `mtcf_codigo` as codmatfinal FROM `tb_matricula_cursos_nota_final` WHERE cod_miembro=? LIMIT 1", $data);

        return $result->result();
    }


    public function m_pdf_boleta_x_matricula($data)
    {
        $result = $this->db->query("SELECT 
          tb_matricula.mtr_id AS matricula,
          tb_matricula.codigoinscripcion AS codinscripcion,
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
          tb_matricula.codigoturno AS codturno,
          tb_matricula.codigoseccion AS codseccion,
          tb_matricula.codigoplan AS codplan,
          substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
          tb_unidad_didactica.undd_codigo AS codcurso,
          tb_unidad_didactica.undd_nombre AS curso,
          tb_unidad_didactica.undd_horas_sema_teor AS hts,
          tb_unidad_didactica.undd_horas_sema_pract AS hps,
          tb_unidad_didactica.undd_creditos_teor AS ct,
          tb_unidad_didactica.undd_creditos_pract AS cp,
          tb_matricula_cursos_nota_final.mtcf_nota_final AS nota,
          tb_matricula_cursos_nota_final.mtcf_nota_recupera AS recuperacion,
          tb_modulo_educativo.mod_nro AS nromodulo,
          tb_modulo_educativo.mod_nombre AS modulo,
          tb_matricula_cursos_nota_final.mtcf_culminado as culminado,
          tb_matricula_cursos_nota_final.mtcf_estado as estado
        FROM
          tb_inscripcion
          INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
          INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
          INNER JOIN tb_matricula_cursos_nota_final ON (tb_matricula_cursos_nota_final.mtr_id = tb_matricula.mtr_id)
          INNER JOIN tb_unidad_didactica ON (tb_unidad_didactica.undd_codigo = tb_matricula_cursos_nota_final.cod_unidad_didactica)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
        WHERE tb_matricula_cursos_nota_final.mtr_id=? 
        ORDER BY tb_matricula_cursos_nota_final.codigociclo,tb_unidad_didactica.undd_nombre ", $data);

        return $result->result();
    }

    public function m_get_cursos_xmatricula($sede)
    {
        $result = $this->db->query("SELECT 
            tb_matricula_cursos_nota_final.mtcf_codigo AS id,
            tb_matricula_cursos_nota_final.mtcf_tipo as tipo,
            tb_periodo.ped_nombre AS periodo,
            tb_matricula_cursos_nota_final.cod_plan_estudios as codplan,
            tb_plan_estudios.pln_nombre as plan,
            tb_carrera.car_sigla AS sigla,
            tb_carrera.car_nombre AS carrera,
            tb_ciclo.cic_nombre AS ciclo,
            tb_matricula_cursos_nota_final.codigoturno AS codturno,
            tb_turno.tur_nombre AS turno,
            tb_matricula_cursos_nota_final.codigoseccion AS codseccion,
            tb_matricula_cursos_nota_final.cod_subseccion AS subseccion,
            tb_matricula_cursos_nota_final.cod_unidad_didactica AS codcurso,
            tb_unidad_didactica.undd_nombre AS curso,
            tb_matricula_cursos_nota_final.mtr_id AS matricula,
            tb_matricula_cursos_nota_final.mtcf_nota_final AS nota,
            tb_matricula_cursos_nota_final.mtcf_nota_recupera AS recuperacion,
            tb_matricula_cursos_nota_final.mtcf_culminado AS culminado,
            tb_matricula_cursos_nota_final.cod_carga_academica AS idcarga,
            tb_matricula_cursos_nota_final.mtcf_estado AS estado,
            tb_matricula_cursos_nota_final.cod_docente,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_matricula_cursos_nota_final.cod_miembro as codmiembro,
            tb_matricula_cursos_nota_final.codigometodocalculo as metodo
          FROM
            tb_matricula_cursos_nota_final
            INNER JOIN tb_periodo ON (tb_matricula_cursos_nota_final.codigoperiodo = tb_periodo.ped_codigo)
            INNER JOIN tb_turno ON (tb_matricula_cursos_nota_final.codigoturno = tb_turno.tur_codigo)
            INNER JOIN tb_ciclo ON (tb_matricula_cursos_nota_final.codigociclo = tb_ciclo.cic_codigo)
            INNER JOIN tb_carrera ON (tb_matricula_cursos_nota_final.codigocarrera = tb_carrera.car_id)
            INNER JOIN tb_unidad_didactica ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
            LEFT OUTER JOIN tb_docente ON (tb_matricula_cursos_nota_final.cod_docente = tb_docente.doc_codigo)
            LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
            INNER JOIN tb_plan_estudios ON (tb_matricula_cursos_nota_final.cod_plan_estudios = tb_plan_estudios.pln_id)
          WHERE tb_matricula_cursos_nota_final.mtr_id=? 
          ORDER BY tb_matricula_cursos_nota_final.codigociclo,tb_unidad_didactica.undd_nombre ", $sede);

        return $result->result();
    }

  public function m_insert_mat($items)
  {
    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    return   $res->row(); 
  }

  public function m_insert_mat_culminar_curso($items)
  {
    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_insert_culminar`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    return   $res->row(); 
  }

  public function m_insert_mat_culminar_curso_sr($items)
  {
    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_insert_culminar_sr`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    return   $res->row(); 
  }

  public function m_update_nota_final_recuperacion($items)
  {
    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_update_min_culmina`(?,?,?,?,@s)",$items);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    return   $res->row(); 
  }

  public function m_update_nota_final_recuperacion_sr($items)
  {
    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_update_min_culmina_sr`(?,?,?,@s)",$items);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    return   $res->row(); 
  }


  public function m_update_mat($items)
  {
    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    return   $res->row(); 
  }

  public function m_eliminar_mat($items)
  {
    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_delete`(?,@s,@nid)",$items);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    return   $res->row(); 
  }

  public function m_editar_nota_final($data)
  {

      $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_update_nota_final`(?,?,@s,@nid)", $data);
      $res = $this->db->query('select @s as salida,@nid as newcod');
      return $res->row();
  }

  public function m_editar_nota_recupera($data)
  {

      $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_update_nota_recupera`(?,?,@s,@nid)", $data);
      $res = $this->db->query('select @s as salida,@nid as newcod');
      return $res->row();
  }

  public function m_filtrar_matriculacurso($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
          tb_matricula_cursos_nota_final.mtcf_codigo AS codigo,
          tb_matricula_cursos_nota_final.mtr_id AS codmatricula,
          tb_matricula_cursos_nota_final.mtcf_tipo AS tipo,
          tb_matricula_cursos_nota_final.codigoperiodo AS idperiodo,
          tb_matricula_cursos_nota_final.codigocarrera AS idcarrera,
          tb_matricula_cursos_nota_final.cod_plan_estudios AS codplan,
          tb_matricula_cursos_nota_final.codigociclo AS idciclo,
          tb_matricula_cursos_nota_final.codigoturno AS idturno,
          tb_matricula_cursos_nota_final.codigoseccion AS idseccion,
          tb_matricula_cursos_nota_final.mtcf_fecha AS fecha,
          tb_matricula_cursos_nota_final.cod_carga_academica AS idcarga,
          tb_matricula_cursos_nota_final.cod_subseccion AS codsubsec,
          tb_matricula_cursos_nota_final.cod_docente AS codocente,
          tb_matricula_cursos_nota_final.cod_unidad_didactica AS idunidad,
          tb_matricula_cursos_nota_final.mtcf_convalida_resolucion AS valida,
          tb_matricula_cursos_nota_final.mtcf_covalida_fecha AS vfecha,
          tb_matricula_cursos_nota_final.mtcf_nota_final AS notaf,
          tb_matricula_cursos_nota_final.mtcf_nota_recupera AS notar,
          tb_matricula_cursos_nota_final.mtr_observacion AS observacion,
          tb_matricula_cursos_nota_final.id_usuario AS idusuario,
          tb_matricula_cursos_nota_final.cod_sede AS idsede,
          tb_carrera.car_nombre AS carnombre,
          tb_ciclo.cic_nombre AS cicnombre,
          tb_periodo.ped_nombre AS penombre,
          tb_unidad_didactica.undd_nombre AS undnombre,
          tb_plan_estudios.pln_nombre AS planombre
        FROM
          tb_ciclo
          INNER JOIN tb_matricula_cursos_nota_final ON (tb_ciclo.cic_codigo = tb_matricula_cursos_nota_final.codigociclo)
          INNER JOIN tb_carrera ON (tb_matricula_cursos_nota_final.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_periodo ON (tb_matricula_cursos_nota_final.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_unidad_didactica ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
          LEFT OUTER JOIN tb_plan_estudios ON (tb_matricula_cursos_nota_final.cod_plan_estudios = tb_plan_estudios.pln_id)

        WHERE 
          tb_matricula_cursos_nota_final.mtr_id = ? 
        ORDER BY
          tb_matricula_cursos_nota_final.codigoperiodo,
          tb_matricula_cursos_nota_final.codigocarrera,
          tb_matricula_cursos_nota_final.codigociclo,
          tb_matricula_cursos_nota_final.codigoturno,
          tb_matricula_cursos_nota_final.codigoseccion", $data);
        
        return $resultmiembro->result();
    }

    public function m_filtrar_matriculacursoxcodigo($data)
    {
       
      $resultmiembro = $this->db->query("SELECT 
      tb_matricula_cursos_nota_final.mtcf_codigo as codigo,
      tb_matricula_cursos_nota_final.mtr_id as codmatricula,
      tb_matricula_cursos_nota_final.mtcf_tipo as tipo,
      tb_matricula_cursos_nota_final.codigoperiodo as idperiodo,
      tb_matricula_cursos_nota_final.codigocarrera as idcarrera,
      tb_matricula_cursos_nota_final.cod_plan_estudios as codplan,
      tb_matricula_cursos_nota_final.codigociclo as idciclo,
      tb_matricula_cursos_nota_final.codigoturno as idturno,
      tb_matricula_cursos_nota_final.codigoseccion as idseccion,
      tb_matricula_cursos_nota_final.mtcf_fecha as fecha,
      tb_matricula_cursos_nota_final.cod_carga_academica as idcarga,
      tb_matricula_cursos_nota_final.cod_subseccion as codsubsec,
      tb_matricula_cursos_nota_final.cod_docente as codocente,
      tb_matricula_cursos_nota_final.cod_unidad_didactica as idunidad,
      tb_matricula_cursos_nota_final.mtcf_convalida_resolucion as valida,
      tb_matricula_cursos_nota_final.mtcf_covalida_fecha as vfecha,
      tb_matricula_cursos_nota_final.mtcf_nota_final as notaf,
      tb_matricula_cursos_nota_final.mtcf_nota_recupera as notar,
      tb_matricula_cursos_nota_final.mtr_observacion as observacion,
      tb_matricula_cursos_nota_final.id_usuario as idusuario,
      tb_matricula_cursos_nota_final.cod_sede as idsede,
      tb_carrera.car_nombre as carnombre,
      tb_carrera.car_sigla as carsigla,
      tb_ciclo.cic_nombre as cicnombre,
      tb_periodo.ped_nombre as penombre,
      tb_unidad_didactica.undd_nombre as undnombre,
      tb_plan_estudios.pln_nombre as planombre
      FROM
        tb_ciclo
        INNER JOIN tb_matricula_cursos_nota_final ON (tb_ciclo.cic_codigo = tb_matricula_cursos_nota_final.codigociclo)
        INNER JOIN tb_carrera ON (tb_matricula_cursos_nota_final.codigocarrera = tb_carrera.car_id)
        INNER JOIN tb_periodo ON (tb_matricula_cursos_nota_final.codigoperiodo = tb_periodo.ped_codigo)
        INNER JOIN tb_unidad_didactica ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
        LEFT OUTER JOIN tb_plan_estudios ON (tb_matricula_cursos_nota_final.cod_plan_estudios = tb_plan_estudios.pln_id)
      WHERE 
        tb_matricula_cursos_nota_final.mtcf_codigo = ? 
      LIMIT 1", $data);
        
        return $resultmiembro->row();
    }

    public function m_filtrar_mat_indiv($data)
    {
       
      $resultmiembro = $this->db->query("SELECT 
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
        tb_matricula.codigoturno AS codturno,
        tb_matricula.codigoseccion AS codseccion,
        tb_matricula.codigoplan AS codplan,
        substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
        tb_persona.per_celular AS celular1,
        tb_persona.per_celular2 AS celular2,
        tb_persona.per_telefono AS telefono,
        tb_inscripcion.ins_sede as codsede
      FROM
        tb_periodo
        INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
        INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
        INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
        INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
        INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
        INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
    WHERE 
      tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND tb_matricula.codigoplan like ? AND 
        tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
      tb_matricula.codigoseccion LIKE ? AND 
      concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? and tb_inscripcion.ins_sede=? 
    ORDER BY
      tb_matricula.codigoperiodo,
      tb_matricula.codigocarrera,
      tb_matricula.codigoplan,
      tb_matricula.codigociclo,
      tb_matricula.codigoturno,
      tb_matricula.codigoseccion,
      tb_persona.per_apel_paterno,
      tb_persona.per_apel_materno,
      tb_persona.per_nombres", $data);
          ////$this->db->close();
        return $resultmiembro->result();
    }

  public function m_filtrar_mat_indivxlimit($inicio, $limite, $data)
  {
    if ($inicio == 0) {
        $limitado = "limit $limite";
      } else {
        $limitado = "limit $inicio, $limite";
      }
     
      $resultmiembro = $this->db->query("SELECT 
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
        tb_matricula.codigoturno AS codturno,
        tb_matricula.codigoseccion AS codseccion,
        tb_matricula.codigoplan AS codplan,
        substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
        tb_persona.per_celular AS celular1,
        tb_persona.per_celular2 AS celular2,
        tb_persona.per_telefono AS telefono,
        tb_inscripcion.ins_sede as codsede
      FROM
        tb_periodo
        INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
        INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
        INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
        INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
        INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
        INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
      WHERE 
        tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND tb_matricula.codigoplan like ? AND 
          tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
        tb_matricula.codigoseccion LIKE ? AND 
        concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? AND tb_inscripcion.ins_sede = ?
      ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigoplan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres $limitado", $data);
      ////$this->db->close();
      return $resultmiembro->result();
  }

  public function m_get_carga_por_grupo_matric($data){
      $result = $this->db->query("SELECT 
            tb_carga_academica.cac_id AS codcarga,
            tb_carga_academica.codigouindidadd as codunidad,
            tb_unidad_didactica.undd_nombre AS unidad,
            tb_unidad_didactica.codigociclo as codciclo,
            tb_unidad_didactica.undd_horas_sema_teor AS hst,
            tb_unidad_didactica.undd_horas_sema_pract AS hsp,
            tb_unidad_didactica.undd_horas_ciclo AS hc,
            tb_unidad_didactica.undd_creditos_teor AS ct,
            tb_unidad_didactica.undd_creditos_pract AS cp,
            tb_carga_academica.cac_activo AS activo,
            tb_modulo_educativo.codigoplan as codplan
          FROM
            tb_carga_academica
            INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
            INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo) 
          WHERE tb_carga_academica.codigociclo = ? AND tb_modulo_educativo.codigoplan = ? AND tb_carga_academica.cod_sede = ?
          GROUP BY  tb_unidad_didactica.undd_nombre ", $data);
      return   $result->result();
  }

  public function m_miscursos_x_matricula($data)
  {

      /*$resultdoce = $this->db->query("SELECT 
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
        tb_matricula_cursos_nota_final.mtcf_nota_final AS nota,
        tb_matricula_cursos_nota_final.mtcf_nota_recupera AS recuperacion,
        'miembro-alumno' AS miembro,
        tb_matricula_cursos_nota_final.mtr_id AS matricula,
        (case when(tb_matricula_cursos_nota_final.mtcf_nota_recupera > tb_matricula_cursos_nota_final.mtcf_nota_final) then 
         tb_matricula_cursos_nota_final.mtcf_nota_recupera else tb_matricula_cursos_nota_final.mtcf_nota_final end) AS final,
        tb_carga_subseccion_miembros.csm_estado AS dpi,
        tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
        tb_persona.per_apel_paterno AS paterno,
        tb_persona.per_apel_materno AS materno,
        tb_persona.per_nombres AS nombres,
        tb_unidad_didactica.undd_horas_sema_teor AS hts,
        tb_unidad_didactica.undd_horas_sema_pract AS hps,
        tb_unidad_didactica.undd_creditos_teor AS ct,
        tb_unidad_didactica.undd_creditos_pract AS cp,
        tb_carga_subseccion_miembros.csm_repitencia AS repite,
        tb_modulo_educativo.mod_nro AS nromodulo,
        tb_modulo_educativo.codigoplan AS codplan,
        tb_modulo_educativo.mod_nombre AS modulo,
        tb_carga_academica_subseccion.cas_culminado AS culminado
      FROM
        tb_carga_academica
        INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
        INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
        AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
        LEFT OUTER JOIN tb_matricula_cursos_nota_final ON (tb_carga_academica.cac_id = tb_matricula_cursos_nota_final.cod_carga_academica)
        LEFT OUTER JOIN tb_docente ON (tb_matricula_cursos_nota_final.cod_docente = tb_docente.doc_codigo)
        LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
        INNER JOIN tb_modulo_educativo ON (tb_matricula_cursos_nota_final.cod_plan_estudios = tb_modulo_educativo.mod_codigo)
        INNER JOIN tb_periodo ON (tb_periodo.ped_codigo = tb_matricula_cursos_nota_final.codigoperiodo)
        INNER JOIN tb_carrera ON (tb_matricula_cursos_nota_final.codigocarrera = tb_carrera.car_id)
        INNER JOIN tb_ciclo ON (tb_matricula_cursos_nota_final.codigociclo = tb_ciclo.cic_codigo)
        INNER JOIN tb_turno ON (tb_matricula_cursos_nota_final.codigoturno = tb_turno.tur_codigo)
        INNER JOIN tb_unidad_didactica ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
        WHERE
              tb_matricula_cursos_nota_final.mtr_id = ? AND tb_carga_subseccion_miembros.csm_eliminado = 'NO' order by 
              tb_unidad_didactica.undd_nombre", $data);*/
        //////$this->db->close();
        $resultdoce = $this->db->query("SELECT 
            tb_periodo.ped_nombre AS periodo,
            tb_carrera.car_sigla AS sigla,
            tb_carrera.car_nombre AS carrera,
            tb_ciclo.cic_nombre AS ciclo,
            tb_turno.tur_nombre AS turno,
            tb_unidad_didactica.undd_nombre AS curso,
            tb_matricula_cursos_nota_final.mtcf_nota_final AS nota,
            tb_matricula_cursos_nota_final.mtcf_nota_recupera AS recuperacion,
            tb_matricula_cursos_nota_final.mtr_id AS matricula,
           
            tb_unidad_didactica.undd_horas_sema_teor AS hts,
            tb_unidad_didactica.undd_horas_sema_pract AS hps,
            tb_unidad_didactica.undd_creditos_teor AS ct,
            tb_unidad_didactica.undd_creditos_pract AS cp,
            tb_modulo_educativo.mod_nro AS nromodulo,
            tb_matricula_cursos_nota_final.mtcf_estado AS estado,
            tb_matricula_cursos_nota_final.codigometodocalculo as metodo
          FROM
            tb_matricula_cursos_nota_final
            INNER JOIN tb_periodo ON (tb_periodo.ped_codigo = tb_matricula_cursos_nota_final.codigoperiodo)
            INNER JOIN tb_carrera ON (tb_matricula_cursos_nota_final.codigocarrera = tb_carrera.car_id)
            INNER JOIN tb_ciclo ON (tb_matricula_cursos_nota_final.codigociclo = tb_ciclo.cic_codigo)
            INNER JOIN tb_turno ON (tb_matricula_cursos_nota_final.codigoturno = tb_turno.tur_codigo)
            INNER JOIN tb_unidad_didactica ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
            INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          WHERE
            tb_matricula_cursos_nota_final.mtr_id = ?
          ORDER BY
            tb_unidad_didactica.undd_nombre", $data);
        return $resultdoce->result();
  }

  public function m_miscursos_x_matriculas($data)
    {

        $signos=implode("','", $data);
        $resultdoce = $this->db->query("SELECT 
            tb_periodo.ped_nombre AS periodo,
            tb_carrera.car_sigla AS sigla,
            tb_carrera.car_nombre AS carrera,
            tb_ciclo.cic_nombre AS ciclo,
            tb_turno.tur_nombre AS turno,
            tb_unidad_didactica.undd_nombre AS curso,
            tb_matricula_cursos_nota_final.mtcf_nota_final AS nota,
            tb_matricula_cursos_nota_final.mtcf_nota_recupera AS recuperacion,
            tb_matricula_cursos_nota_final.mtr_id AS matricula,
            (case when(tb_matricula_cursos_nota_final.mtcf_nota_recupera > tb_matricula_cursos_nota_final.mtcf_nota_final) then tb_matricula_cursos_nota_final.mtcf_nota_recupera else tb_matricula_cursos_nota_final.mtcf_nota_final end) AS final,
            tb_unidad_didactica.undd_horas_sema_teor AS hts,
            tb_unidad_didactica.undd_horas_sema_pract AS hps,
            tb_unidad_didactica.undd_creditos_teor AS ct,
            tb_unidad_didactica.undd_creditos_pract AS cp,
            tb_modulo_educativo.mod_nro AS nromodulo,
            tb_matricula_cursos_nota_final.mtcf_estado AS estado
          FROM
            tb_matricula_cursos_nota_final
            INNER JOIN tb_periodo ON (tb_periodo.ped_codigo = tb_matricula_cursos_nota_final.codigoperiodo)
            INNER JOIN tb_carrera ON (tb_matricula_cursos_nota_final.codigocarrera = tb_carrera.car_id)
            INNER JOIN tb_ciclo ON (tb_matricula_cursos_nota_final.codigociclo = tb_ciclo.cic_codigo)
            INNER JOIN tb_turno ON (tb_matricula_cursos_nota_final.codigoturno = tb_turno.tur_codigo)
            INNER JOIN tb_unidad_didactica ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
            INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          WHERE
            tb_matricula_cursos_nota_final.mtr_id IN ('$signos') order by tb_unidad_didactica.undd_nombre");
        //////$this->db->close();
        return $resultdoce->result();
    }


  /*public function m_miscursos_x_matriculas($data)
    {

        $signos=implode("','", $data);
        $resultdoce = $this->db->query("SELECT 
        tb_carga_subseccion_miembros.csm_id AS idmiembro,
        tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
        tb_periodo.ped_nombre AS periodo,
        tb_carrera.car_sigla AS sigla,
        tb_carrera.car_nombre AS carrera,
        tb_ciclo.cic_nombre AS ciclo,
        tb_carga_academica.codigoturno as codturno,
        tb_turno.tur_nombre AS turno,
        tb_carga_academica.codigoseccion AS codseccion,
        tb_carga_academica.codigouindidadd AS codcurso,
        tb_unidad_didactica.undd_nombre AS curso,
        tb_carga_academica_subseccion.codigosubseccion AS subseccion,
        tb_carga_subseccion_miembros.csm_nota_final AS nota,
        tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
        'miembro-alumno' AS miembro,
        tb_carga_subseccion_miembros.cod_matricula AS matricula,
        (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
        tb_carga_subseccion_miembros.csm_estado AS dpi,
        tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
        tb_persona.per_apel_paterno as paterno,
        tb_persona.per_apel_materno as materno,
        tb_persona.per_nombres AS nombres,
        tb_carga_academica.cac_horas_sema_teor AS hts,
        tb_carga_academica.cac_horas_sema_pract AS hps,
        tb_carga_academica.cac_creditos_teor AS ct,
        tb_carga_academica.cac_creditos_pract AS cp,
        tb_carga_subseccion_miembros.csm_repitencia AS repite,
        tb_modulo_educativo.mod_nro as nromodulo ,
        tb_modulo_educativo.codigoplan AS codplan,
            tb_modulo_educativo.mod_nombre AS modulo
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
        INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
        LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
        LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
      WHERE
        tb_carga_subseccion_miembros.cod_matricula IN ('$signos') order by tb_unidad_didactica.undd_nombre");
    
        return $resultdoce->result();
    }*/

}
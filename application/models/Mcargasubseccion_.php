<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mcargasubseccion extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function m_cambiar_docente($data){   
      //(( @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vcodigouindidadd, @s);
      $this->db->query("CALL `sp_tb_cargasubseccion_docente_update`(?,?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function m_cambiar_division($data){   
      //(( @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vcodigouindidadd, @s);
      $this->db->query("CALL `sp_tb_cargasubseccion_division_update`(?,?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }
    public function m_eliminar_division($data){   
      //(( @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vcodigouindidadd, @s);
      $this->db->query("CALL `sp_tb_cargasubseccion_delete`(?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }
    public function m_agregar_division($data){   
      //(( @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vcodigouindidadd, @s);
      $this->db->query("CALL `sp_tb_cargasubseccion_division_insert`(?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function m_update_nrosesiones($data)
    {
        /////$this->load->database();
        $resultmiembro = $this->db->query("UPDATE `tb_carga_academica_subseccion`  SET 
          `cas_nrosesiones` = ?  
          WHERE `codigocargaacademica` = ? AND `codigosubseccion` = ?;", $data);
        ////$this->db->close();
        return 1;
    }


    

    //PARA SUPERVISOR
    public function m_culminar_curso($data)
    {
        /////$this->load->database();
        $resultmiembro = $this->db->query("UPDATE  `tb_carga_academica_subseccion`  SET  `cas_culminado` = ? 
             WHERE `codigocargaacademica` = ? AND `codigosubseccion` = ?;", $data);
        ////$this->db->close();
        return 1;
    }

    public function m_ocultar_curso($data)
    {
        /////$this->load->database();
        $resultmiembro = $this->db->query("UPDATE  `tb_carga_academica_subseccion`  SET  `cas_activo` = ?
            WHERE `codigocargaacademica` = ? AND `codigosubseccion` = ?;", $data);
        ////$this->db->close();
        return 1;
    }


    public function m_filtrar($data){
        $result = $this->db->query("SELECT 
          tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
          tb_carga_academica_subseccion.codigosubseccion AS subseccion,
          tb_periodo.ped_nombre AS periodo,
          tb_carrera.car_nombre as carrera,
          tb_carga_academica.codigouindidadd AS codcurso,
          tb_unidad_didactica.undd_nombre AS curso,
          tb_unidad_didactica.codigomodulo as codmodulo,
          tb_modulo_educativo.mod_nro AS nromodulo,
          tb_carga_academica.cac_horas_sema_teor AS hts,
          tb_carga_academica.cac_horas_sema_pract AS hps,
          tb_carga_academica.cac_creditos_teor AS ct,
          tb_carga_academica.cac_creditos_pract AS cp,
          tb_modulo_educativo.codigoplan AS codplan,
          tb_modulo_educativo.mod_nombre AS modulo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_carga_academica.codigoturno AS codturno,
          tb_carga_academica.codigoseccion AS codseccion,
           tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
        WHERE tb_carga_academica.codigoperiodo LIKE ? AND tb_carga_academica.codigocarrera LIKE ? AND tb_modulo_educativo.codigoplan LIKE ? AND tb_carga_academica.codigociclo LIKE ? AND tb_carga_academica.codigoturno LIKE ? AND tb_carga_academica.codigoseccion LIKE ? 
        ORDER BY tb_modulo_educativo.codigoplan,tb_modulo_educativo.mod_codigo,tb_carga_academica.codigociclo,tb_unidad_didactica.undd_nombre,tb_carga_academica_subseccion.codigosubseccion", $data);
        return   $result->result();
    }


    public function m_get_subsecciones_por_grupo($data){
        $result = $this->db->query("SELECT 
          tb_carga_academica.cac_id AS codcarga,
          tb_carga_academica_subseccion.codigosubseccion AS division,
          tb_carga_academica_subseccion.codigodocente AS coddocente,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_carga_academica_subseccion.cas_avance_ses AS avance,
          tb_carga_academica_subseccion.cas_nrosesiones AS sesiones,
          tb_carga_academica_subseccion.cas_culminado AS culminado,
          SUM(case tb_carga_subseccion_miembros.csm_eliminado when 'NO' then 1 else 0 end) AS nalum,
          tb_modulo_educativo.codigoplan as codplan
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
          LEFT OUTER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
          AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
        WHERE tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=? AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND tb_carga_academica.codigoseccion=? AND tb_modulo_educativo.codigoplan=? AND tb_carga_academica.cod_sede = ?
        GROUP BY
          tb_carga_academica.cac_id,
          tb_carga_academica_subseccion.codigosubseccion,
          tb_carga_academica_subseccion.codigodocente,
          tb_persona.per_apel_paterno,
          tb_persona.per_apel_materno,
          tb_persona.per_nombres,
          tb_persona.per_sexo,
          tb_carga_academica_subseccion.cas_avance_ses,
          tb_carga_academica_subseccion.cas_nrosesiones,
          tb_carga_academica_subseccion.cas_culminado,
          tb_modulo_educativo.codigoplan", $data);
        return   $result->result();
    }

    /*public function m_get_carga_subsecciones_por_grupo($data){
        $result = $this->db->query("SELECT 
          tb_carga_academica.cac_id AS codcarga,
          tb_carga_academica_subseccion.codigosubseccion AS division,
          tb_carga_academica_subseccion.codigodocente AS coddocente,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_carga_academica_subseccion.cas_avance_ses AS avance,
          tb_carga_academica_subseccion.cas_nrosesiones AS sesiones,
          tb_carga_academica_subseccion.cas_culminado AS culminado,
          COUNT(tb_carga_subseccion_miembros.csm_id) AS nalum,
          tb_carga_academica_subseccion.cas_activo AS activo
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
          LEFT OUTER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
          AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
        WHERE tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=? AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND tb_carga_academica.codigoseccion=?
        GROUP BY
          tb_carga_academica.cac_id,
          tb_carga_academica_subseccion.codigosubseccion,
          tb_carga_academica_subseccion.codigodocente,
          tb_persona.per_apel_paterno,
          tb_persona.per_apel_materno,
          tb_persona.per_nombres,
          tb_carga_academica_subseccion.cas_avance_ses,
          tb_carga_academica_subseccion.cas_nrosesiones,
          tb_carga_academica_subseccion.cas_culminado,
          tb_carga_academica_subseccion.cas_activo", $data);
        return   $result->result();
    }*/

     public function m_get_subsecciones_por_docente($codperiodo,$coddocente){
      if ($coddocente=="00000"){
        $textdocente=" AND tb_carga_academica_subseccion.codigodocente is null";
        $data=array($codperiodo);
      }
      else{
        $textdocente=" AND tb_carga_academica_subseccion.codigodocente=?";
        $data=array($codperiodo,$coddocente);
      }
        $result = $this->db->query("SELECT 
            tb_carga_academica.cac_id AS codcarga,
            tb_carga_academica.codigoperiodo AS codperiodo,
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
              SUM(case tb_carga_subseccion_miembros.`csm_eliminado` when 'NO' then 1 else 0 end) AS nalum
          FROM
            tb_carga_academica_subseccion
            INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
            INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
            INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
            INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
            INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
            LEFT OUTER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
            AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
          WHERE tb_carga_academica.codigoperiodo=? ".$textdocente."    
          GROUP BY
            tb_carga_academica.cac_id,
            tb_carga_academica.codigoperiodo,
            tb_carga_academica.codigocarrera,
            tb_carrera.car_nombre,
            tb_carrera.car_sigla,
            tb_carga_academica.codigociclo,
            tb_ciclo.cic_nombre,
            tb_carga_academica.codigoturno,
            tb_carga_academica.codigoseccion,
            tb_carga_academica_subseccion.codigosubseccion,
            tb_unidad_didactica.undd_nombre,
            tb_carga_academica.cac_activo,
            tb_unidad_didactica.codigomodulo,
            tb_modulo_educativo.mod_nombre,
            tb_carga_academica_subseccion.cas_nrosesiones,
            tb_carga_academica_subseccion.cas_avance_ses,
            tb_carga_academica_subseccion.cas_activo,
            tb_carga_academica_subseccion.cas_culminado", $data);
        return   $result->result();
    }
    public function m_get_subsecciones_visibles_por_docente($data){
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
        WHERE tb_carga_academica_subseccion.codigodocente=? 
        ORDER BY tb_periodo.ped_nombre desc,tb_carga_academica.codigocarrera,tb_carga_academica.codigociclo", $data);
        return   $result->result();
    }

    
    
    public function m_get_subseccion($data){
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
          SUM(CASE WHEN tb_carga_subseccion_miembros.csm_eliminado = 'NO' then 1 else 0 end) AS nalum,
          tb_persona.per_apel_paterno AS docpaterno,
          tb_persona.per_apel_materno as docmaterno,
          tb_persona.per_nombres as docnombres,
          tb_carga_academica_subseccion.codigodocente  as doccodigo,
          tb_docente.doc_emailc as docemail 
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
          LEFT OUTER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
          AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
          INNER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
          INNER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)

        WHERE tb_carga_academica.cac_id=? AND tb_carga_academica_subseccion.codigosubseccion=? 
        GROUP BY
          tb_carga_academica.cac_id,
          tb_carga_academica.codigoperiodo,
          tb_periodo.ped_nombre,
          tb_carga_academica.codigocarrera,
          tb_carrera.car_nombre,
          tb_carrera.car_sigla,
          tb_carga_academica.codigociclo,
          tb_ciclo.cic_nombre,
          tb_carga_academica.codigoturno,
          tb_carga_academica.codigoseccion,
          tb_carga_academica_subseccion.codigosubseccion,
          tb_unidad_didactica.undd_nombre,
          tb_carga_academica.cac_activo,
          tb_unidad_didactica.codigomodulo,
          tb_modulo_educativo.mod_nombre,
          tb_carga_academica_subseccion.cas_nrosesiones,
          tb_carga_academica_subseccion.cas_avance_ses,
          tb_carga_academica_subseccion.cas_activo,
          tb_carga_academica_subseccion.cas_culminado,
          tb_persona.per_apel_paterno,
          tb_persona.per_apel_materno,
          tb_persona.per_nombres,
          tb_carga_academica_subseccion.codigodocente
        LIMIT 1", $data);
        return   $result->row();
    }

    public function m_get_carga_subseccion($data){

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
          tb_turno.tur_nombre AS turno,
          tb_carga_academica.codigoseccion AS codseccion,
          tb_carga_academica_subseccion.codigosubseccion AS division,
          tb_carga_academica_subseccion.cas_avance_ses AS avance,
          tb_unidad_didactica.undd_nombre AS unidad,
          tb_carga_academica.cac_activo AS activo,
          tb_unidad_didactica.codigomodulo AS codmodulo,
          tb_modulo_educativo.mod_nombre AS modulo,
          tb_modulo_educativo.codigoplan AS codplan,
          tb_plan_estudios.pln_nombre AS plan,
          tb_carga_academica_subseccion.codigodocente AS coddocente,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_docente.doc_emailc as ecorporativo,
          tb_persona.per_celular as celular,
          tb_carga_academica_subseccion.cas_nrosesiones AS sesiones,
          tb_carga_academica_subseccion.cas_culminado AS culminado
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
          INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
        WHERE tb_carga_academica.cac_id=? AND tb_carga_academica_subseccion.codigosubseccion=? LIMIT 1", $data);
        return   $result->row();
    }

    public function m_get_nro_alumnos_carga_subseccion($data){

        $result = $this->db->query(" SELECT 
        COUNT(tb_carga_subseccion_miembros.csm_id) AS miembros
      FROM
        tb_carga_subseccion_miembros
        INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
      WHERE
        tb_carga_subseccion_miembros.cod_cargaacademica = ? AND 
        tb_carga_subseccion_miembros.cod_subseccion = ? AND 
        tb_carga_subseccion_miembros.csm_eliminado = 'NO'", $data);
        return   $result->row()->miembros;
    }

   


    public function m_get_carga_subseccion_todos($data){
        $result = $this->db->query("SELECT 
          tb_carga_academica.cac_id AS codcarga,
          tb_carga_academica.codigoperiodo AS codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_carga_academica.codigocarrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS sigla,
          tb_carga_academica.codigociclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_ciclo.cic_letras AS ciclol,
          tb_carga_academica.codigoturno AS codturno,
          tb_turno.tur_nombre AS turno,
          tb_carga_academica.codigoseccion AS codseccion,
          tb_carga_academica_subseccion.codigosubseccion AS division,
          tb_unidad_didactica.undd_nombre AS unidad,
          tb_carga_academica.cac_activo AS activo,
          tb_unidad_didactica.codigomodulo AS codmodulo,
          tb_modulo_educativo.mod_nombre AS modulo,
          tb_modulo_educativo.codigoplan AS codplan,
          tb_plan_estudios.pln_nombre AS plan,
          tb_carga_academica_subseccion.codigodocente AS coddocente,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_carga_academica_subseccion.cas_nrosesiones AS sesiones,
          tb_modulo_educativo.mod_nro AS modulonro,
          tb_unidad_didactica.undd_creditos_teor as cred_teo,
          tb_unidad_didactica.undd_creditos_pract as cred_pra,
            tb_unidad_didactica.undd_horas_ciclo  as horas_ciclo
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
          INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
          INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
        WHERE tb_carga_academica.cac_id=? AND tb_carga_academica_subseccion.codigosubseccion=? LIMIT 1", $data);
        return   $result->row();
    }

    public function m_get_carga_subseccion_indicadores($data){
      $result = $this->db->query("SELECT 
          tb_sub_indicadores.sind_id AS codigo,
          tb_sub_indicadores.sind_descripcion AS descripción,
          tb_sub_indicadores.ind_id AS indicador,
          tb_sub_indicadores.cac_id AS idcarga,
          tb_sub_indicadores.cod_subsec AS idcasub
        FROM
          tb_sub_indicadores
        WHERE tb_sub_indicadores.cac_id = ? AND tb_sub_indicadores.cod_subsec = ? ", $data);
        return   $result->result();
    }

    public function m_agregar_sub_indicadores($datainsert, $dataupdate){   
      
      foreach ($datainsert as $key => $data) {

        $this->db->query("CALL `sp_tb_sub_indicadores_insert`(?,?,?,?,@s)",$data);

      }

      
      foreach ($dataupdate as $key => $data) {

          $this->db->query("CALL `sp_tb_sub_indicadores_update`(?,?,@s)", $data);

      }
      
      return 1;

    }
    
    
   
}
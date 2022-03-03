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

    public function m_cambiar_metodo_calculo($data){   
      //(( @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vcodigouindidadd, @s);
      $this->db->query("CALL `sp_tb_cargasubseccion_metodo_update`(?,?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }
    public function m_fusionar($data){   
      //(( @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vcodigouindidadd, @s);
      $this->db->query("CALL `sp_tb_cargasubseccion_fusionar_update`(?,?,?,?,@s)",$data);
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
          tb_persona.per_nombres AS nombres,
          tb_sede.sed_nombre AS carga_sede,
          tb_carga_academica.cod_sede as carga_codsede 
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
          INNER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede)
        WHERE tb_carga_academica.cod_sede=? AND tb_carga_academica.codigoperiodo LIKE ? AND tb_carga_academica.codigocarrera LIKE ? AND tb_modulo_educativo.codigoplan LIKE ? AND tb_carga_academica.codigociclo LIKE ? AND tb_carga_academica.codigoturno LIKE ? AND tb_carga_academica.codigoseccion LIKE ? 
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
          tb_carga_academica_subseccion.cas_activo AS activo,
          SUM(case tb_carga_subseccion_miembros.csm_eliminado when 'NO' then 1 else 0 end) AS nalum,
          tb_modulo_educativo.codigoplan AS codplan,
          tb_carga_academica_subseccion.codigocargaacademica_aula AS codcarga_aula,
          tb_carga_academica_subseccion.codigosubseccion_aula AS division_aula
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
          tb_carga_academica_subseccion.cas_activo,
          tb_modulo_educativo.codigoplan,
          tb_carga_academica_subseccion.codigocargaacademica_aula,
          tb_carga_academica_subseccion.codigosubseccion_aula", $data);
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
          tb_turno.tur_nombre as turno,
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
          tb_sede.sed_nombre AS sede,
          tb_carga_academica_subseccion.codigocargaacademica_aula AS codcarga_fusion,
          tb_carga_academica_subseccion.codigosubseccion_aula AS division_fusion
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede)
          INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
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
          tb_carga_academica.codigouindidadd as codunidad,
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
          tb_docente.doc_emailc as docemail,
          tb_carga_academica_subseccion.codigo_calculo_evaluacion as metodo,
          tb_carga_academica_subseccion.codigocargaacademica_aula as codcarga_fusion,
          tb_carga_academica_subseccion.codigosubseccion_aula as division_fusion
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
          tb_carga_academica_subseccion.codigodocente,
          tb_docente.doc_emailc,
          tb_carga_academica_subseccion.codigo_calculo_evaluacion,
          tb_carga_academica_subseccion.codigocargaacademica_aula,
          tb_carga_academica_subseccion.codigosubseccion_aula 
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
          tb_carga_academica.codigouindidadd as codunidad,
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
          tb_carga_academica_subseccion.cas_culminado AS culminado,
          tb_carga_academica_subseccion.codigo_calculo_evaluacion as metodo
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
          tb_unidad_didactica.undd_horas_ciclo  as horas_ciclo,
          tb_unidad_didactica.undd_horas_sema_teor   as hsem_teo,
          tb_unidad_didactica.undd_horas_sema_pract as hsem_pra,
          tb_carga_academica_subseccion.codigo_calculo_evaluacion as metodo
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

    public function m_get_carga_subseccion_filtro($data){
      //$fcacbsede,$fcacbperiodo,$fcacbcarrera,$fcacbplan,$fcacbciclo,$fcacbturno,$fcacbseccion,$fcatxtbusqueda)
        $sqltext_array=array();
        $data_array=array();
        if ($data[0]!="%") {
          $sqltext_array[]="tb_sede.id_sede = ?";
          $data_array[]=$data[0];
        } 
        if ($data[1]!="%") {
          $sqltext_array[]="tb_carga_academica.codigoperiodo = ?";
          $data_array[]=$data[1];
        } 
        if ($data[2]!="%")  {
          $sqltext_array[]="tb_carga_academica.codigocarrera = ?";
          $data_array[]=$data[2];
        }
        if ($data[3]!="%")  {
          $sqltext_array[]="tb_modulo_educativo.codigoplan = ?";
          $data_array[]=$data[3];
        }
        if ($data[4]!="%")  {
          $sqltext_array[]="tb_carga_academica.codigociclo = ?";
          $data_array[]=$data[4];
        }
        if ($data[5]!="%")  {
          $sqltext_array[]="tb_carga_academica.codigoturno = ?";
          $data_array[]=$data[5];
        }
        if ($data[6]!="%")  {
          $sqltext_array[]="tb_carga_academica.codigoseccion = ?";
          $data_array[]=$data[6];
        }
        if ($data[7]!="%%")  {
          $sqltext_array[]="concat(CONVERT(tb_carga_academica.cac_id, CHAR(10)),tb_unidad_didactica.undd_nombre) like ?";
          $data_array[]=$data[7];
        }
        if ($data[8]!="%")  {
          $sqltext_array[]="tb_carga_academica_subseccion.codigodocente = ?";
          $data_array[]=$data[8];
        }
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;


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
            tb_carga_academica.codigouindidadd as codunidad,
            tb_unidad_didactica.undd_nombre AS unidad,
            tb_carga_academica.cac_activo AS carga_activo,
            tb_unidad_didactica.codigomodulo AS codmodulo,
            tb_modulo_educativo.mod_nombre AS modulo,
            tb_modulo_educativo.codigoplan AS codplan,
            tb_plan_estudios.pln_nombre AS plan,
            tb_carga_academica_subseccion.codigodocente AS coddocente,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_carga_academica_subseccion.cas_nrosesiones AS sesiones,
            tb_carga_academica_subseccion.cas_activo as activo,
            tb_carga_academica_subseccion.cas_culminado as culminado,
            tb_modulo_educativo.mod_nro AS modulonro,
            tb_unidad_didactica.undd_creditos_teor AS cred_teo,
            tb_unidad_didactica.undd_creditos_pract AS cred_pra,
            tb_unidad_didactica.undd_horas_ciclo AS horas_ciclo,
            tb_unidad_didactica.undd_horas_sema_teor AS hsem_teo,
            tb_unidad_didactica.undd_horas_sema_pract AS hsem_pra,
            tb_sede.sed_nombre as sede,
            tb_sede.sed_abreviatura as sede_abrevia,
            tb_carga_academica_subseccion.codigocargaacademica_aula as codcarga_fusion,
            tb_carga_academica_subseccion.codigosubseccion_aula as division_fusion,
            COUNT(tb_carga_subseccion_miembros.csm_id) AS enrolados
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
            INNER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede)
            LEFT OUTER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
            AND (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
          $sqltext 
          GROUP BY
            tb_carga_academica.cac_id,
            tb_carga_academica.codigoperiodo,
            tb_periodo.ped_nombre,
            tb_carga_academica.codigocarrera,
            tb_carrera.car_nombre,
            tb_carrera.car_sigla,
            tb_carga_academica.codigociclo,
            tb_ciclo.cic_nombre,
            tb_ciclo.cic_letras,
            tb_carga_academica.codigoturno,
            tb_turno.tur_nombre,
            tb_carga_academica.codigoseccion,
            tb_carga_academica_subseccion.codigosubseccion,
            tb_unidad_didactica.undd_nombre,
            tb_carga_academica.cac_activo,
            tb_unidad_didactica.codigomodulo,
            tb_modulo_educativo.mod_nombre,
            tb_modulo_educativo.codigoplan,
            tb_plan_estudios.pln_nombre,
            tb_carga_academica_subseccion.codigodocente,
            tb_persona.per_apel_paterno,
            tb_persona.per_apel_materno,
            tb_persona.per_nombres,
            tb_carga_academica_subseccion.cas_nrosesiones,
            tb_modulo_educativo.mod_nro,
            tb_unidad_didactica.undd_creditos_teor,
            tb_unidad_didactica.undd_creditos_pract,
            tb_unidad_didactica.undd_horas_ciclo,
            tb_unidad_didactica.undd_horas_sema_teor,
            tb_unidad_didactica.undd_horas_sema_pract,
            tb_sede.sed_nombre,
            tb_sede.sed_abreviatura,
            tb_carga_academica_subseccion.codigocargaacademica_aula,
          tb_carga_academica_subseccion.codigosubseccion_aula 
          ORDER BY
            codperiodo desc,
            codcarrera,
            codciclo,
            codturno,
            codseccion,unidad,
            division",$data_array);
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
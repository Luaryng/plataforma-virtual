<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmatricula extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function m_insert($items)
	{
		$this->db->query("CALL `sp_tb_matricula_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nc)",$items);
		$res = $this->db->query('select @s as rs,@nc as newcod');
 		return   $res->row();	
	}

	public function m_update_mat($items)
	{
		$this->db->query("CALL `sp_tb_matricula_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nc)",$items);
		$res = $this->db->query('select @s as rs,@nc as newcod');
 		return   $res->row();	
	}

	public function m_cambiar_estado($items)
	{
		//CALL ``( @vniv_codigo, @vniv_estado, @`s`);
		$this->db->query("CALL `sp_tb_matricula_update_estado`(?,?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
 		return   $res->row()->out_param;	
	}

	public function m_eliminar($items)
	{
		//CALL ``( @vniv_codigo, @vniv_estado, @`s`);
		$this->db->query("CALL `sp_tb_matricula_delete`(?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
 		return   $res->row()->out_param;	
	}

	public function m_filtrar($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
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
		  tb_matricula.mtr_bloquear_evaluaciones as bloqueo,
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
		  tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND tb_matricula.codigoplan like ? AND 
  		  tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
		  tb_matricula.codigoseccion LIKE ? AND 
		  concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? 
		ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigoplan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data);
        ////$this->db->close();
        return $resultmiembro->result();
    }

	public function m_filtrar_cur_ad($data)
    {
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_matricula.codigoperiodo AS codperiodo,
		  tb_periodo.ped_nombre AS periodo,
		  tb_matricula.codigocarrera AS codcarrera,
		  tb_carrera.car_nombre AS carrera,
		  tb_carrera.car_sigla AS sigla,
		  tb_matricula.codigociclo AS codciclo,
		  tb_ciclo.cic_nombre AS ciclo,
		  tb_matricula.codigoturno AS codturno,
		  tb_matricula.codigoseccion AS codseccion,
		  tb_inscripcion.id_plan AS codplan,
		  substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
		  COUNT(tb_carga_subseccion_miembros.csm_id) AS cursos,
		  sum(case when `tb_carga_subseccion_miembros`.csm_estado='DES' THEN 1 else 0 end) AS DES,
		  sum(case when `tb_carga_subseccion_miembros`.csm_estado='APR' THEN 1 else 0 end) AS APR,
		  sum(case when `tb_carga_subseccion_miembros`.csm_estado='DPI' THEN 1 else 0 end) AS DPI,
		  sum(case when `tb_carga_subseccion_miembros`.csm_estado='NSP' THEN 1 else 0 end) AS NSP
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
		  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
		WHERE 
		  tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND
			  tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
		  tb_matricula.codigoseccion LIKE ? AND 
		  concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? AND tb_carga_subseccion_miembros.csm_eliminado = 'NO' 
		GROUP BY
		  tb_matricula.mtr_id,
		  tb_matricula.codigoinscripcion,
		  tb_inscripcion.ins_carnet,
		  tb_persona.per_apel_paterno,
		  tb_persona.per_apel_materno,
		  tb_persona.per_nombres,
		  tb_matricula.codigoperiodo,
		  tb_periodo.ped_nombre,
		  tb_matricula.codigocarrera,
		  tb_carrera.car_nombre,
		  tb_carrera.car_sigla,
		  tb_matricula.codigociclo,
		  tb_ciclo.cic_nombre,
		  tb_matricula.codigoturno,
		  tb_matricula.codigoseccion,
		  tb_inscripcion.id_plan,
		  substr(tb_estadoalumno.esal_nombre, 1, 3)", $data);
        ////$this->db->close();
        return $resultmiembro->result();
    }

     /*public function m_miscursos_x_matricula($data)
    {

        //////$this->load->database();
		  $resultdoce = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_periodo.ped_nombre AS periodo,
			  tb_carrera.car_sigla AS sigla,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_turno.tur_nombre AS turno,
			  tb_seccion.sec_nombre AS seccion,
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
			  concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS docente
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
			  INNER JOIN tb_seccion ON (tb_carga_academica.codigoseccion = tb_seccion.sec_codigo)
			  LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
			  LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
			WHERE
			  tb_carga_subseccion_miembros.cod_matricula = ? AND 
			  tb_carga_subseccion_miembros.csm_eliminado = 'NO'", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }*/
    public function m_cursos_x_matricula($data)
    {

		  $resultdoce = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_periodo.ped_nombre AS periodo,
			  tb_carrera.car_sigla AS sigla,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_turno.tur_nombre AS turno,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_unidad_didactica.undd_nombre AS curso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_subseccion_miembros.csm_nota_final AS nota,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  'miembro-alumno' AS miembro,
			  tb_carga_subseccion_miembros.cod_matricula AS matricula,
			  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
			  tb_carga_subseccion_miembros.csm_estado AS dpi,
			  tb_modulo_educativo.mod_nro as nromodulo,
			  tb_unidad_didactica.undd_horas_sema_teor AS hts,
			  tb_unidad_didactica.undd_horas_sema_pract AS hps,
			  tb_unidad_didactica.undd_creditos_teor AS ct,
			  tb_unidad_didactica.undd_creditos_pract AS cp,
			  tb_carga_subseccion_miembros.csm_repitencia AS repite 
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
			WHERE
			  tb_carga_subseccion_miembros.cod_matricula = ? AND 
			  tb_carga_subseccion_miembros.csm_eliminado = 'NO'", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }
	public function m_matriculas_x_grupo_enrolar($data)
    {
      $result = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codmatricula,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carnet,
		  tb_persona.per_dni as dni,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_persona.per_sexo as sexo,
  		  tb_persona.per_fecha_nacimiento as fecnac
		FROM
		  tb_inscripcion
		  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
        WHERE  tb_matricula.codigoperiodo=? AND tb_matricula.codigocarrera=?  AND tb_matricula.codigociclo=? AND tb_matricula.codigoturno=? 
        ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_inscripcion.id_plan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres", $data);
        return   $result->result();
    }
    public function m_matriculas_x_grupo($data)
    {
      $result = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codmatricula,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carnet,
		  tb_persona.per_dni as dni,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_persona.per_sexo as sexo,
  		  tb_persona.per_fecha_nacimiento as fecnac,
  		  tb_matricula.codigoestado as codestado 
		FROM
		  tb_inscripcion
		  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
        WHERE  tb_matricula.codigoperiodo=? AND tb_matricula.codigocarrera=? AND tb_inscripcion.id_plan=? AND tb_matricula.codigociclo=? AND tb_matricula.codigoturno=? AND  tb_matricula.codigoseccion=? 
        ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_inscripcion.id_plan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres", $data);
        return   $result->result();
    }

     public function m_miscursos_x_matricula($data)
    {

        //////$this->load->database();
		  $resultdoce = $this->db->query("SELECT 
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
			  tb_carga_subseccion_miembros.csm_nota_final AS nota,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  'miembro-alumno' AS miembro,
			  tb_carga_subseccion_miembros.cod_matricula AS matricula,
			  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
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
			  tb_carga_subseccion_miembros.cod_matricula = ? AND tb_carga_subseccion_miembros.csm_eliminado = 'NO' order by tb_unidad_didactica.undd_nombre", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }


    public function m_miscursos_x_matriculas($data)
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
        //////$this->db->close();
        return $resultdoce->result();
    }

    public function m_miscursos_x_mat_asist_estadistica($data)
    {

        //////$this->load->database();
		        $resultdoce = $this->db->query("SELECT 
				  tb_carga_asistencia.codigocarga idcarga,
				  tb_carga_asistencia.idmiembro idmiembro,
				  sum(case when tb_carga_asistencia.acu_accion = 'A' then 1 else 0 end) AS asiste,
				  sum(case when tb_carga_asistencia.acu_accion = 'F' then 1 else 0 end) AS falta,
				  sum(case when tb_carga_asistencia.acu_accion = 'T' then 1 else 0 end) AS tarde,
				  sum(case when tb_carga_asistencia.acu_accion = 'J' then 1 else 0 end) AS justif
				FROM
				  tb_carga_sesiones
				  INNER JOIN tb_carga_asistencia ON (tb_carga_sesiones.ses_id = tb_carga_asistencia.idsesion)
				  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_asistencia.idmiembro = tb_carga_subseccion_miembros.csm_id)
				   WHERE tb_carga_subseccion_miembros.cod_matricula =? and tb_carga_subseccion_miembros.csm_eliminado='NO' 
				GROUP BY
				  tb_carga_asistencia.codigocarga,
				  tb_carga_asistencia.idmiembro", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }

    public function m_matricula_x_periodo_alumno($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS alumno,
		  tb_periodo.ped_nombre AS periodo,
		  tb_carrera.car_nombre AS carrera,
		  tb_ciclo.cic_nombre AS ciclo,
		  tb_matricula.codigoturno as codturno,
		  tb_matricula.codigoseccion as codseccion
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		WHERE concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? AND tb_periodo.ped_codigo=?", $data);
        ////$this->db->close();
        return $resultmiembro->result();
    }

    public function m_matricula_x_periodo_carne($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS alumno,
		  tb_periodo.ped_nombre AS periodo,
		  tb_carrera.car_nombre AS carrera,
		  tb_ciclo.cic_nombre AS ciclo,
		  tb_matricula.codigoturno as codturno,
		  tb_matricula.codigoseccion as codseccion
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		WHERE tb_inscripcion.ins_carnet=? AND tb_periodo.ped_codigo=? LIMIT 1", $data);
        ////$this->db->close();
        return $resultmiembro->row();
    }


    public function m_get_matricula_pdf($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
		  tb_inscripcion.ins_carnet AS carne,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_periodo.ped_nombre AS periodo,
		  tb_inscripcion.id_plan AS codplan,
		  tb_matricula.codigocarrera as codcarrera,
		  tb_carrera.car_nombre AS carrera,
		  tb_carrera.car_nivel_formativo as  nivel,
		  tb_ciclo.cic_nombre AS ciclo,
		  tb_ciclo.cic_letras AS ciclol,
		  tb_turno.tur_nombre AS turno,
		  tb_matricula.codigoseccion AS codseccion,
		  tb_matricula.mtr_fecha as fecha,
		  tb_periodo.ped_anio as anio,
		  tb_persona.per_tipodoc as tipodoc,
		  tb_persona.per_dni as dni,
		  tb_matricula.mtr_id as matricula,
		  tb_inscripcion.ins_identificador as codinscripcion
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
		WHERE tb_matricula.mtr_id=? LIMIT 1", $data);
        ////$this->db->close();
        return $resultmiembro->result();
    }

    


     public function m_get_matriculas_pdf($data)
    {
    	$signos=implode("','", $data);
        $resultmiembro = $this->db->query("SELECT 
		  tb_inscripcion.ins_carnet AS carne,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_periodo.ped_nombre AS periodo,
		  tb_inscripcion.id_plan AS codplan,
		  tb_carrera.car_nombre AS carrera,
		  tb_ciclo.cic_nombre AS ciclo,
		  tb_turno.tur_nombre AS turno,
		  tb_matricula.codigoseccion AS codseccion,
		  tb_matricula.mtr_fecha as fecha,
		  tb_periodo.ped_anio as anio,
		  tb_persona.per_tipodoc as tipodoc,
		  tb_persona.per_dni as dni,
		  tb_matricula.mtr_id as matricula,
		  tb_matricula.codigocarrera as codcarrera,
 		  tb_ciclo.cic_letras AS ciclol
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
		WHERE tb_matricula.mtr_id IN ('$signos')");
        ////$this->db->close();
        return $resultmiembro->result();
    }

    public function m_update_mostrar_evaluaciones($data)
    {
    	$this->db->query("CALL `sp_tb_matricula_update_bloquear`(?,?,@s,@nid)", $data);
      	$res = $this->db->query('select @s as salida,@nid as newcod');
      	return $res->row();
    }

    public function m_update_bloquea_evaluaciones($data)
    {
    	$this->db->query("CALL `sp_tb_matricula_update_bloquea_evaluaciones`(?,?,?,@s,@nid)", $data);
      	$res = $this->db->query('select @s as salida,@nid as newcod');
      	return $res->row();
    }

    public function m_filtrar_estadoalumno()
    {
    	$resultmiembro = $this->db->query("SELECT 
		  tb_estadoalumno.esal_id AS codigo,
		  tb_estadoalumno.esal_nombre AS nombre
		FROM
		  tb_estadoalumno");
    	return $resultmiembro->result();
    }

    public function m_filtrar_matriculaxcodigo($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_matricula.mt_tipo AS tipo,
		  tb_matricula.codigobeneficio AS beneficio,
		  tb_matricula.codigoperiodo as codperiodo,
		  tb_matricula.codigocarrera as codcarrera,
		  tb_carrera.car_nombre AS carrera,
		  tb_matricula.codigociclo as codciclo,
		  tb_matricula.codigoturno AS codturno,
		  tb_matricula.codigoseccion AS codseccion,
		  tb_matricula.mtr_cuotapension AS pension,
		  tb_matricula.codigoestado AS estado,
		  tb_matricula.codigoplan as codplan,
		  tb_matricula.mtr_fecha as fecha,
		  tb_matricula.mtr_observacion as observacion,
		  tb_matricula.mtr_apel_paterno as paterno,
		  tb_matricula.mtr_apel_materno as materno,
		  tb_matricula.mtr_nombres as nombres,
		  tb_matricula.mtr_bloquear_evaluaciones as bloqueo
		FROM
		  tb_matricula
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  -- INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		WHERE 
		  tb_matricula.mtr_id = ?
		LIMIT 1", $data);
        return $resultmiembro->row();
    }

    public function m_update_matricula_manual($data)
    {
    	$this->db->query("CALL `sp_tb_matricula_update_manual`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nc)", $data);
      	$res = $this->db->query('select @s as rs,@nc as newcod');
      	return $res->row();
    }

    
}
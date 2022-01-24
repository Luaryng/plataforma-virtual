<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mnotas_descarga extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function m_get_carga_por_grupo_extendida_nota($data)
	{
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
            WHERE tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=?  AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND tb_carga_academica.codigoseccion=? AND tb_modulo_educativo.codigoplan=? AND tb_carga_academica.cod_sede = ?
            ORDER BY  tb_unidad_didactica.undd_nombre ", $data);
        return   $result->result();
	}

	public function m_get_subsecciones_por_grupo_nota($data){
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

   /* public function m_notas_carga_subseccion($data)
    {
    	$result = $this->db->query("SELECT 
				  tb_matricula.mtr_apel_paterno as paterno,
				  tb_matricula.mtr_apel_materno as materno,
				  tb_matricula.mtr_nombres as nombres,
				  tb_inscripcion.ins_carnet as carne,
				  tb_carga_subseccion_miembros.csm_nota_final as notafin,
				  tb_carga_subseccion_miembros.csm_nota_recuperacion as notarec,
				  tb_carga_subseccion_miembros.cod_matricula as idmat,
				  tb_carga_subseccion_miembros.cod_cargaacademica as idcarga,
				  tb_carga_subseccion_miembros.cod_subseccion as iddivision,
				  tb_carga_academica_subseccion.codigodocente as coddocente,
				  tb_carga_academica.codigocarrera as idcarrera,
				  tb_carga_academica.codigociclo as idciclo,
				  tb_carga_academica.codigoturno as idturno,
				  tb_carga_academica.codigoseccion as idseccion,
				  tb_carga_academica.codigouindidadd as idunidad,
				  tb_carga_academica.codigoperiodo as idperiodo,
				  tb_inscripcion.id_plan as idplan,
				  tb_carga_subseccion_miembros.csm_estado as estado,
				  tb_carga_subseccion_miembros.csm_repitencia as repitencia
				FROM
				  tb_matricula
				  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
				  INNER JOIN tb_carga_academica ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica.cac_id)
				  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
				  INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
				WHERE
				  tb_carga_subseccion_miembros.cod_cargaacademica = ? AND 
				  tb_carga_subseccion_miembros.cod_subseccion = ? AND
				  tb_carga_academica.cod_sede = ? AND
				  tb_carga_academica_subseccion.cas_culminado = 'SI' 
				  ORDER BY 
				  tb_matricula.codigoperiodo,
		      tb_matricula.codigocarrera,
		      tb_matricula.codigoplan,
		      tb_matricula.codigociclo,
		      tb_matricula.codigoturno,
		      tb_matricula.codigoseccion,
		      tb_matricula.mtr_apel_paterno,
		      tb_matricula.mtr_apel_materno,
		      tb_matricula.mtr_nombres", $data);
    	return $result->result();
    }*/

    public function m_notas_carga_subseccion($data)
    {
    	$result = $this->db->query("SELECT 
				  tb_matricula.mtr_apel_paterno AS paterno,
				  tb_matricula.mtr_apel_materno AS materno,
				  tb_matricula.mtr_nombres AS nombres,
				  tb_matricula.mtr_fecha AS fechamat,
				  tb_inscripcion.ins_carnet AS carne,
				  tb_carga_subseccion_miembros.csm_nota_final AS notafin,
				  tb_carga_subseccion_miembros.csm_nota_recuperacion AS notarec,
				  tb_carga_subseccion_miembros.cod_matricula AS idmat,
				  tb_carga_subseccion_miembros.csm_id as idmiembro,
				  tb_carga_subseccion_miembros.cod_cargaacademica AS idcarga,
				  tb_carga_subseccion_miembros.cod_subseccion AS iddivision,
				  tb_matricula.codigoperiodo AS idperiodo,
				  tb_matricula.codigocarrera AS idcarrera,
				  tb_matricula.codigoplan AS idplan,
				  tb_matricula.codigociclo AS idciclo,
				  tb_matricula.codigoturno AS idturno,
				  tb_matricula.codigoseccion AS idseccion,
				  tb_carga_subseccion_miembros.csm_estado AS estado,
				  tb_carga_subseccion_miembros.csm_repitencia AS repitencia,
				  tb_carga_academica_subseccion.codigodocente AS coddocente,
				  tb_matricula_cursos_nota_final.mtcf_codigo as codmatnota,
				  tb_matricula_cursos_nota_final.mtcf_nota_final AS nota_his,
				  tb_matricula_cursos_nota_final.mtcf_nota_recupera AS nota_rec_his
				FROM
				  tb_matricula
				  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
				  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
				  INNER JOIN tb_carga_academica_subseccion ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica_subseccion.codigocargaacademica)
				  AND (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
				  LEFT OUTER JOIN tb_matricula_cursos_nota_final ON (tb_carga_subseccion_miembros.csm_id = tb_matricula_cursos_nota_final.cod_miembro)

				WHERE
				  tb_carga_subseccion_miembros.cod_cargaacademica = ? AND 
				  tb_carga_subseccion_miembros.cod_subseccion = ? AND
				  tb_carga_academica_subseccion.cas_culminado = 'SI' AND 
				  tb_carga_subseccion_miembros.csm_eliminado='NO' 
				ORDER BY
				  tb_matricula.codigoperiodo,
				  tb_matricula.codigocarrera,
				  tb_matricula.codigoplan,
				  tb_matricula.codigociclo,
				  tb_matricula.codigoturno,
				  tb_matricula.codigoseccion,
				  tb_matricula.mtr_apel_paterno,
				  tb_matricula.mtr_apel_materno,
				  tb_matricula.mtr_nombres", $data);
    	return $result->result();
    }

    /*public function m_getmatriculas_curso_notafinal($data)
    {
    	$result = $this->db->query("SELECT 
						  tb_matricula_cursos_nota_final.mtcf_codigo as codigo,
						  tb_matricula_cursos_nota_final.mtr_id as idmat,
						  tb_matricula_cursos_nota_final.mtcf_tipo as tipo,
						  tb_matricula_cursos_nota_final.codigoperiodo as idperiodo,
						  tb_matricula_cursos_nota_final.codigocarrera as idcarrera,
						  tb_matricula_cursos_nota_final.cod_plan_estudios as idplan,
						  tb_matricula_cursos_nota_final.codigociclo as idciclo,
						  tb_matricula_cursos_nota_final.codigoturno as idturno,
						  tb_matricula_cursos_nota_final.codigoseccion as idseccion,
						  tb_matricula_cursos_nota_final.mtcf_fecha as fecha,
						  tb_matricula_cursos_nota_final.cod_carga_academica as idcarga,
						  tb_matricula_cursos_nota_final.cod_subseccion as iddivision,
						  tb_matricula_cursos_nota_final.cod_docente as iddocente,
						  tb_matricula_cursos_nota_final.cod_unidad_didactica as idunidad,
						  tb_matricula_cursos_nota_final.mtcf_convalida_resolucion as resolucion,
						  tb_matricula_cursos_nota_final.mtcf_covalida_fecha as fechaconv,
						  tb_matricula_cursos_nota_final.mtcf_nota_final as notafin,
						  tb_matricula_cursos_nota_final.mtcf_nota_recupera as notarec,
						  tb_matricula_cursos_nota_final.mtr_observacion as observacion,
						  tb_matricula_cursos_nota_final.id_usuario as usuario,
						  tb_matricula_cursos_nota_final.cod_sede as sede,
						  tb_matricula_cursos_nota_final.mtcf_culminado as culminado,
						  tb_matricula_cursos_nota_final.mtcf_estado as estado,
						  tb_matricula_cursos_nota_final.mtcf_repitencia as repitencia
						FROM
						  tb_matricula_cursos_nota_final
						WHERE 
						  tb_matricula_cursos_nota_final.mtr_id = ? AND tb_matricula_cursos_nota_final.codigoperiodo = ?
						  AND tb_matricula_cursos_nota_final.codigocarrera = ? AND tb_matricula_cursos_nota_final.codigociclo = ?
						  AND tb_matricula_cursos_nota_final.codigoturno = ? AND tb_matricula_cursos_nota_final.codigoseccion = ?
						  AND tb_matricula_cursos_nota_final.cod_carga_academica = ? AND tb_matricula_cursos_nota_final.cod_subseccion = ?
						  AND tb_matricula_cursos_nota_final.cod_unidad_didactica = ? LIMIT 1", $data);
    	return $result->row();
    }*/

    public function m_insert_notas_descarga($items)
	  {
	    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_insert_descarga`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
	    $res = $this->db->query('select @s as salida,@nid as newcod');
	    return   $res->row(); 
	  }

	  public function m_update_notas_descarga($items)
	  {
	    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_update_descarga`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
	    $res = $this->db->query('select @s as salida,@nid as newcod');
	    return   $res->row(); 
	  }

	  public function m_update_nota_final_recuperacion_sin_estado($items)
	  {
	    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_update_min_sin_estado`(?,?,?,?,@s)",$items);
	    $res = $this->db->query('select @s as salida,@nid as newcod');
	    return   $res->row(); 
	  }
	  public function m_update_nota_final_recuperacion($items)
	  {
	    $this->db->query("CALL `sp_tb_matricula_cursos_nota_final_update_min`(?,?,?,?,?,@s)",$items);
	    $res = $this->db->query('select @s as salida,@nid as newcod');
	    return   $res->row(); 
	  }

	  public function m_update_fecha_carga($data)
	  {
	  	$this->db->query("UPDATE tb_carga_academica_subseccion SET cas_fecha_migra_nota = ? WHERE codigocargaacademica = ? AND codigosubseccion = ?", $data);
	  	return 1;
	  }


    
}
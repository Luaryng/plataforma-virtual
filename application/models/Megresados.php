<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Megresados extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
    }

    public function m_get_egresados($data)
    {
    	$resultdoce = $this->db->query("SELECT 
			  tb_egresados.eg_id AS codigo,
			  tb_egresados.eg_tipodoc AS tipodoc,
			  tb_egresados.eg_dni AS dni,
			  tb_egresados.eg_apel_paterno AS paterno,
			  tb_egresados.eg_apel_materno AS materno,
			  tb_egresados.eg_nombres AS nombres,
			  tb_egresados.eg_sexo AS sexo,
			  tb_egresados.eg_fecha_nacimiento AS fecnacimiento,
			  tb_egresados.eg_domicilio AS domicilio,
			  tb_egresados.eg_telefono AS telefono,
			  tb_egresados.eg_celular AS celular,
			  tb_egresados.eg_email_personal AS email,
			  tb_egresados.cod_distrito AS iddistrito,
			  tb_egresados.eg_cod_modular AS codmodular,
			  tb_egresados.cod_carrera AS idcarrera,
			  tb_carrera.car_nombre AS carrera,
			  tb_egresados.eg_periodo_egreso AS periodoeg,
			  tb_egresados.eg_anio_egreso AS anioeg,
			  tb_egresados.cod_sede AS idsede,
			  tb_egresados.eg_registro AS fecha
			FROM
			  tb_egresados
			  INNER JOIN tb_carrera ON (tb_egresados.cod_carrera = tb_carrera.car_id)
			  WHERE CONCAT(tb_egresados.eg_dni,' ',tb_egresados.eg_apel_paterno,' ',tb_egresados.eg_apel_materno,' ',tb_egresados.eg_nombres) like ? AND tb_egresados.cod_sede = ? ", $data);
        
        return $resultdoce->result();
    }

    public function m_filtrar_egresadoxcodigo($data)
    {
    	$resultdoce = $this->db->query("SELECT 
    		  tb_egresados.eg_id AS codigo,
			  tb_egresados.eg_tipodoc AS tipodoc,
			  tb_egresados.eg_dni AS dni,
			  tb_egresados.eg_apel_paterno AS paterno,
			  tb_egresados.eg_apel_materno AS materno,
			  tb_egresados.eg_nombres AS nombres,
			  tb_egresados.eg_sexo AS sexo,
			  tb_egresados.eg_fecha_nacimiento AS fecnacimiento,
			  tb_egresados.eg_domicilio AS domicilio,
			  tb_egresados.eg_telefono AS telefono,
			  tb_egresados.eg_celular AS celular,
			  tb_egresados.eg_email_personal AS email,
			  tb_provincia.prv_codigo AS codprovincia,
        	  tb_departamento.dep_codigo AS codepartamento,
			  tb_egresados.cod_distrito AS iddistrito,
			  tb_egresados.eg_cod_modular AS codmodular,
			  tb_egresados.cod_carrera AS idcarrera,
			  tb_carrera.car_nombre AS carrera,
			  tb_egresados.eg_periodo_egreso AS periodoeg,
			  tb_egresados.eg_anio_egreso AS anioeg,
			  tb_egresados.cod_sede AS idsede,
			  tb_egresados.eg_registro AS fecha
			FROM
			  tb_egresados
			  LEFT OUTER JOIN tb_distrito ON (tb_egresados.cod_distrito = tb_distrito.dis_codigo)
			  LEFT OUTER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        	  LEFT OUTER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
			  INNER JOIN tb_carrera ON (tb_egresados.cod_carrera = tb_carrera.car_id)
			  WHERE tb_egresados.eg_id = ? LIMIT 1 ", $data);
        
        return $resultdoce->row();
    }

    public function mInsert_egresado($items)
    {
        $this->db->query("CALL `sp_tb_egresados_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();    
    }

    public function mUpdate_egresado($items)
    {
        $this->db->query("CALL `sp_tb_egresados_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();    
    }

    public function m_elimina_egresado($data)
    {
    	$qry = $this->db->query("DELETE FROM tb_egresados where eg_id = ? ", $data);
        
        return 1;
    }

    public function m_filtrar_estudiantes($data)
    {
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
	        tb_persona.per_domicilio AS domicilio,
	        tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
	        tb_persona.per_email_personal AS epersonal,
	        tb_usuario.usu_email_corporativo AS ecorporativo,
	        tb_inscripcion_detalle.cod_seccion as codseccion
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
	              WHERE concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) LIKE ? AND tb_inscripcion.ins_sede = ?
	        ORDER BY tb_inscripcion_detalle.cod_periodo DESC,tb_inscripcion.cod_carrera,tb_inscripcion_detalle.cod_turno,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres", $data);
      
      	return   $result->result();
    }

    public function m_get_inscripcion_xcodigo($data)
    {
      $result = $this->db->query("SELECT 
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_identificador as codinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_inscripcion.ins_estado AS estado,
          tb_sede.sed_nombre AS sede,
          tb_sede.sed_tipo_local AS sedetipo,
          tb_carrera.car_nivel_formativo AS nivelformativo,
          tb_persona.per_sexo AS sexo,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_tipodoc AS tipodoc,
          tb_persona.per_dni AS nrodoc,
          tb_persona.per_lugar_nacimiento AS lugarnac,
          tb_pais.pa_nombre AS pais,
          tb_distrito.dis_nombre AS distrito,
          tb_provincia.prv_codigo AS codprovincia,
          tb_provincia.prv_nombre AS provincia,
          tb_departamento.dep_codigo AS codepartamento,
          tb_departamento.dep_nombre AS departamento,
          tb_persona.per_domicilio AS domicilio,
          tb_persona.per_email_personal AS email,
          tb_persona.per_telefono AS telefono,
          tb_persona.per_celular AS celular,
          tb_persona.cod_distrito AS iddistrito,
          tb_periodo.ped_anio AS anio,
          tb_ciclo.cic_nombre as ciclo,
          tb_turno.tur_nombre as turno,
          tb_inscripcion_detalle.cod_seccion as seccion
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
          INNER JOIN tb_sede ON (tb_inscripcion.ins_sede = tb_sede.id_sede)
          INNER JOIN tb_pais ON (tb_persona.cod_pais = tb_pais.pa_id)
          INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
          INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
          INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
          LEFT OUTER JOIN tb_ciclo ON (tb_inscripcion_detalle.cod_ciclo = tb_ciclo.cic_codigo)
          LEFT OUTER JOIN tb_turno ON (tb_inscripcion_detalle.cod_turno = tb_turno.tur_codigo)
        WHERE
          tb_inscripcion_detalle.cod_periodo = ? AND tb_inscripcion.ins_identificador=?  LIMIT 1", $data);
      return   $result->row();
    }


    // FUNCIONES DE EGRESADOS ANTERIORES

    public function m_datos_egresados(){
    	$dbp = $this->load->database('iestp',true);
    	$resultdoce = $dbp->query("SELECT 
					  tb_egresados.eg_id AS codigo,
					  tb_egresados.apenom_eg AS apenom,
					  tb_egresados.dni_eg AS dni,
					  tb_egresados.telefono_eg AS telefono,
					  tb_egresados.email_eg AS email,
					  tb_egresados.programa_eg AS carrera,
					  tb_egresados.condicion_eg AS condicion,
					  tb_egresados.anioing_eg AS egreso,
					  tb_egresados.condtrab_eg AS contrab,
					  tb_egresados.cod_depart AS proced,
					  tb_egresados.prog_taller AS cartaller,
					  tb_egresados.deta_taller AS detalle,
					  tb_egresados.sugerencia_eg AS sugerencia,
					  tb_egresados.comentario AS testimonio,
					  tb_egresados.autoriza AS autoriza,
					  tb_egresados.fecha_registro AS fecha
					FROM
					  tb_egresados");
        
        return $resultdoce->result();
    }

    public function m_datos_estudiantes(){
    	$dbp = $this->load->database('iestp',true);
    	$resultdoce = $dbp->query("SELECT 
					  tb_datos_estudiantes.id_es AS codigo,
					  tb_datos_estudiantes.apenom AS apenom,
					  tb_datos_estudiantes.dni_es AS dni,
					  tb_datos_estudiantes.telefono_es AS telefono,
					  tb_datos_estudiantes.email_es AS email,
					  tb_datos_estudiantes.carrera_es AS carrera,
					  tb_datos_estudiantes.anio_ingreso AS ingreso,
					  tb_datos_estudiantes.semestre_es AS semestre,
					  tb_datos_estudiantes.modulo_es AS modulo,
					  tb_datos_estudiantes.sugerencia_es AS sugerencia,
					  tb_datos_estudiantes.fecha_reg AS fecha
					FROM
					  tb_datos_estudiantes");
        
        return $resultdoce->result();
    }

}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Malumno extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
    }
	
	public function m_matricula_activa($data)
    {

        $resultdoce = $this->db->query("SELECT 
			  mtr_id AS codigo,
			  codigoestado as estado
			FROM
			  tb_matricula
			WHERE codigoinscripcion =? AND codigoestado='1';", $data);
        return $resultdoce->result();
    }

	public function m_matriculasxcarne($data)
    {
        //$this->load->database();
        //COMO DOCENTE
        //$resultado=array('docente'=>array(),'alumno'=>array());
        $resultdoce = $this->db->query("SELECT
					  tb_matricula.mtr_id AS codigo,
					  tb_periodo.ped_nombre AS periodo,
					  tb_carrera.car_nombre AS carrera,
					  tb_ciclo.cic_nombre AS ciclo,
					  tb_turno.tur_nombre AS turno,
					  tb_seccion.sec_nombre AS seccion,
					  tb_matricula.mtr_bloquear_evaluaciones as bloquear_evaluaciones 
					FROM
					  tb_matricula
					  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
					  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
					  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
					  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
					  INNER JOIN tb_seccion ON (tb_matricula.codigoseccion = tb_seccion.sec_codigo)
					WHERE tb_matricula.codigoinscripcion =? 
					ORDER BY tb_matricula.codigoperiodo DESC;", $data);
        //COMO ALUMNO
        //$this->db->close();
        return $resultdoce->result();
    }


    public function m_misdeudas($data)
    {
        //$this->load->database();
        $resultdoce = $this->db->query("SELECT 
					  tbdeudas.deu_id AS id,
					  tbdeudas.deu_codgestion AS codgestion,
					  tbdeudas.deu_gestion AS gestion,
					  tbdeudas.deu_creacion AS creacion,
					  tbdeudas.deu_vence AS vence,
					  tbdeudas.deu_voucher AS voucher,
					  tbdeudas.deu_prorroga AS prorroga,
					  tbdeudas.deu_monto AS monto,
					  tbdeudas.deu_observacion AS obs,
					  tbdeudas.deu_saldo AS saldo,
					  tbdeudas.deu_matricula AS matricula,
					  
					  tb_periodo.per_nombre as periodo,
					  tb_ciclo.cic_nombre as ciclo
					FROM
					  tb_matricula
					  RIGHT OUTER JOIN tbdeudas ON (tb_matricula.mtr_id = tbdeudas.deu_matricula)
					  LEFT OUTER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.per_codigo)
					  LEFT OUTER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo) 
					WHERE tbdeudas.deu_carne =?;", $data);
        //$this->db->close();
        return $resultdoce->result();
    }
    
    public function m_misdeudas_vencidas($data)
    {
        //$this->load->database();
        $resultdoce = $this->db->query("SELECT 
					  tbdeudas.deu_id AS id,
					  tbdeudas.deu_codgestion AS codgestion,
					  tbdeudas.deu_gestion AS gestion,
					  tbdeudas.deu_creacion AS creacion,
					  tbdeudas.deu_vence AS vence,
					  tbdeudas.deu_voucher AS voucher,
					  tbdeudas.deu_prorroga AS prorroga,
					  tbdeudas.deu_monto AS monto,
					  tbdeudas.deu_observacion AS obs,
					  tbdeudas.deu_saldo AS saldo,
					  tbdeudas.deu_matricula AS matricula,
					  
					  tb_periodo.per_nombre as periodo,
					  tb_ciclo.cic_nombre as ciclo
					FROM
					  tb_matricula
					  RIGHT OUTER JOIN tbdeudas ON (tb_matricula.mtr_id = tbdeudas.deu_matricula)
					  LEFT OUTER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.per_codigo)
					  LEFT OUTER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo) 
					WHERE tbdeudas.deu_carne =? AND tbdeudas.deu_saldo>0 AND tbdeudas.deu_vence<now();", $data);
        //$this->db->close();
        return $resultdoce->result();
    }

     public function m_misdeudas_pendientes($data)
    {
        //$this->load->database();
        $resultdoce = $this->db->query("SELECT 
					  tbdeudas.deu_id AS id,
					  tbdeudas.deu_codgestion AS codgestion,
					  tbdeudas.deu_gestion AS gestion,
					  tbdeudas.deu_creacion AS creacion,
					  tbdeudas.deu_vence AS vence,
					  tbdeudas.deu_voucher AS voucher,
					  tbdeudas.deu_prorroga AS prorroga,
					  tbdeudas.deu_monto AS monto,
					  tbdeudas.deu_observacion AS obs,
					  tbdeudas.deu_saldo AS saldo,
					  tbdeudas.deu_matricula AS matricula,
					  
					  tb_periodo.per_nombre as periodo,
					  tb_ciclo.cic_nombre as ciclo
					FROM
					  tb_matricula
					  RIGHT OUTER JOIN tbdeudas ON (tb_matricula.mtr_id = tbdeudas.deu_matricula)
					  LEFT OUTER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.per_codigo)
					  LEFT OUTER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo) 
					WHERE tbdeudas.deu_carne =? AND tbdeudas.deu_saldo>0;", $data);
        //$this->db->close();
        return $resultdoce->result();
    }


    public function m_get_deuda_activa_xpaganteins($data)
    {
      	$result = $this->db->query("SELECT 
            tb_deuda_individual.di_codigo AS codigo,
                tb_persona.per_dni AS dni,
                CONCAT(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS nombres,
                tb_deuda_individual.di_monto AS monto,
                tb_deuda_individual.di_fecha_vencimiento AS fvence,
                tb_deuda_individual.di_saldo AS saldo,
                tb_deuda_individual.di_estado AS estado,
                tb_carrera.car_nombre AS carrera,
                tb_ciclo.cic_nombre AS ciclo,
                tb_gestion.gt_nombre as gestion,
                tb_matricula.codigoperiodo as codperiodo,
                tb_carrera.car_sigla as sigla
              FROM
                tb_matricula
                INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
                INNER JOIN tb_inscripcion ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
                INNER JOIN tb_persona ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
                INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
                INNER JOIN tb_gestion ON (tb_deuda_individual.cod_gestion = tb_gestion.gt_codigo)
        WHERE tb_matricula.codigoinscripcion = ? AND tb_deuda_individual.di_saldo > 0 AND tb_deuda_individual.di_estado='ACTIVO'",$data);
        return $result->result();
    }

    public function m_asistencias_x_curso_alumno($data)
    {

        ///////$this->load->database();
        $resultdoce = $this->db->query("SELECT
          tb_carga_asistencia.acu_id id,
          tb_carga_asistencia.idmiembro  idmiembro,
          tb_carga_asistencia.acu_fecha fecha,
          tb_carga_asistencia.acu_accion accion,
          tb_carga_asistencia.idsesion sesion
        FROM
          tb_carga_asistencia
        WHERE
          tb_carga_asistencia.codigocarga = ?  AND tb_carga_asistencia.codigosubseccion=? and tb_carga_asistencia.idmiembro=?
         order by tb_carga_asistencia.acu_fecha,tb_carga_asistencia.idmiembro", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }

    /*public function m_matriculasxcarnelts($data)
    {
        
        $resultdoce = $this->db->query("SELECT
					  tb_matricula.mtr_id AS codigo,
					  tb_matricula.mtr_fecha AS fecha,
					  tb_periodo.ped_nombre AS periodo,
					  tb_carrera.car_nombre AS carrera,
					  tb_ciclo.cic_nombre AS ciclo,
					  tb_turno.tur_nombre AS turno,
					  tb_seccion.sec_nombre AS seccion,
					  tb_inscripcion.ins_carnet AS carnet,
					  tb_inscripcion.ins_estado AS estado
					FROM
					  tb_matricula
					  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
					  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
					  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
					  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
					  INNER JOIN tb_seccion ON (tb_matricula.codigoseccion = tb_seccion.sec_codigo)
					  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
					WHERE tb_inscripcion.ins_carnet = ?;", $data);
		
        return $resultdoce->result();
    }*/

    public function m_matriculas_x_inscripcion($data)
    {
        
        $resultdoce = $this->db->query("SELECT 
				  tb_matricula.mtr_id AS codigo,
				  tb_matricula.mtr_fecha AS fecha,
				  tb_periodo.ped_nombre AS periodo,
				  tb_carrera.car_nombre AS carrera,
				  tb_ciclo.cic_nombre AS ciclo,
				  tb_turno.tur_nombre AS turno,
				  tb_seccion.sec_nombre AS seccion,
				  tb_inscripcion.ins_carnet AS carnet,
				  tb_inscripcion.ins_estado AS estado,
				  tb_estadoalumno.esal_nombre as estado_matricula
				FROM
				  tb_matricula
				  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
				  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
				  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
				  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
				  INNER JOIN tb_seccion ON (tb_matricula.codigoseccion = tb_seccion.sec_codigo)
				  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
				  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
					WHERE tb_matricula.codigoinscripcion = ?;", $data);
		
        return $resultdoce->result();
    }

    public function m_pagos_xdocIdentidad($inicio, $limite,$pagante=array(),$fechas=array())
    {
        if ($inicio == 0) {
          $limitado = "limit $limite";
        } else {
          $limitado = "limit $inicio, $limite";
        }
        
        $sqltext="";
        //if (count($pagante)>0){
          
        $data=$pagante;
        //}
        if (count($fechas)>0){
          $sqltext=" AND tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
          $data[]=$fechas[0];
          $data[]=$fechas[1];

        }
        
        $qry = $this->db->query("SELECT 
			  tb_docpago.dcp_id AS codigo,
			  tb_docpago.dcp_serie AS serie,
			  tb_docpago.dcp_numero AS numero,
			  tb_docpago.dcp_fecha_hora AS fecha_hora,
			  tb_docpago.pagante_cod AS codpagante,
			  tb_docpago.tipodoc_cod AS tipodoc,
			  tb_docpago.dcp_estado AS estado,
			  tb_docpago.dcp_total AS total,
			  tb_docpago.sede_id AS sede,
			  tb_docpago.dcp_mnto_igv AS migv,
			  tb_docpago_sunat.dcps_aceptado AS s_aceptado,
			  tb_docpago_sunat.dcps_snt_descripcion AS s_descripcion,
			  tb_docpago_sunat.dcps_snt_note AS s_note,
			  tb_docpago_sunat.dcps_snt_responsecode AS s_response,
			  tb_docpago_sunat.dcps_snt_soap_error AS s_soap,
			  tb_docpago_sunat.dcps_snt_enlace_xml AS enl_xml,
			  tb_docpago_sunat.dcps_snt_enlace_cdr AS enl_cdr,
			  tb_docpago_sunat.dcps_snt_enlace_pdf AS enl_pdf,
			  tb_docpago_sunat.dcps_error_cod AS error_cod,
			  tb_docpago_sunat.dcps_error_desc AS error_desc,
			  tb_docpago.dcp_anulacion_motivo AS anul_motivo,
			  tb_docpago.dcp_fecha_anulacion AS anul_fecha
			FROM
			  tb_docpago_sunat
			  RIGHT OUTER JOIN tb_docpago ON (tb_docpago_sunat.dcps_id = tb_docpago.dcp_id)
          	WHERE  tb_docpago.pagante_tipodoc=? AND tb_docpago.pagante_nrodoc=? AND tb_docpago.dcp_estado='ACEPTADO' $sqltext 
          	ORDER BY
             tb_docpago.dcp_serie,tb_docpago.dcp_numero DESC $limitado", $data);
        
        $rs['items'] =$qry->result();
        $qryc = $this->db->query("SELECT 

            count(tb_docpago.dcp_id) AS conteo
          FROM
            tb_docpago
          WHERE tb_docpago.pagante_tipodoc=? AND tb_docpago.pagante_nrodoc=? AND tb_docpago.dcp_estado='ACEPTADO' $sqltext", $data);
        $rs['numitems']= $qryc->row()->conteo;
        return $rs;
    }

    public function m_pagos_xCarnet($inicio, $limite,$pagante=array(),$fechas=array())
    {
        if ($inicio == 0) {
          $limitado = "limit $limite";
        } else {
          $limitado = "limit $inicio, $limite";
        }
        
        $sqltext="";
        //if (count($pagante)>0){
          
        $data=$pagante;
        //}
        if (count($fechas)>0){
          $sqltext=" AND tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
          $data[]=$fechas[0];
          $data[]=$fechas[1];

        }
        
        $qry = $this->db->query("SELECT 
			  tb_docpago.dcp_id AS codigo,
			  tb_docpago.dcp_serie AS serie,
			  tb_docpago.dcp_numero AS numero,
			  tb_docpago.dcp_fecha_hora AS fecha_hora,
			  tb_docpago.pagante_cod AS codpagante,
			  tb_docpago.tipodoc_cod AS tipodoc,
			  tb_docpago.dcp_estado AS estado,
			  tb_docpago.dcp_total AS total,
			  tb_docpago.sede_id AS sede,
			  tb_docpago.dcp_mnto_igv AS migv,
			  tb_docpago_sunat.dcps_aceptado AS s_aceptado,
			  tb_docpago_sunat.dcps_snt_descripcion AS s_descripcion,
			  tb_docpago_sunat.dcps_snt_note AS s_note,
			  tb_docpago_sunat.dcps_snt_responsecode AS s_response,
			  tb_docpago_sunat.dcps_snt_soap_error AS s_soap,
			  tb_docpago_sunat.dcps_snt_enlace_xml AS enl_xml,
			  tb_docpago_sunat.dcps_snt_enlace_cdr AS enl_cdr,
			  tb_docpago_sunat.dcps_snt_enlace_pdf AS enl_pdf,
			  tb_docpago_sunat.dcps_error_cod AS error_cod,
			  tb_docpago_sunat.dcps_error_desc AS error_desc,
			  tb_docpago.dcp_anulacion_motivo AS anul_motivo,
			  tb_docpago.dcp_fecha_anulacion AS anul_fecha
			FROM
			  tb_docpago_sunat
			  RIGHT OUTER JOIN tb_docpago ON (tb_docpago_sunat.dcps_id = tb_docpago.dcp_id)
          	WHERE  (tb_docpago.pagante_cod=? OR (tb_docpago.pagante_tipodoc=? AND tb_docpago.pagante_nrodoc=?) ) AND  tb_docpago.dcp_estado='ACEPTADO' $sqltext 
          	ORDER BY
             tb_docpago.dcp_serie,tb_docpago.dcp_numero DESC $limitado", $data);
        
        $rs['items'] =$qry->result();
        $qryc = $this->db->query("SELECT 

            count(tb_docpago.dcp_id) AS conteo
          FROM
            tb_docpago
          WHERE  (tb_docpago.pagante_cod=? OR (tb_docpago.pagante_tipodoc=? AND tb_docpago.pagante_nrodoc=?) ) AND  tb_docpago.dcp_estado='ACEPTADO' $sqltext", $data);
        $rs['numitems']= $qryc->row()->conteo;
        return $rs;
    }


    public function mget_deudas_xestudiante($data)
    {
    	$data2 = array();
    	if ($data[0] == "DNI") {
    		$sqltext = " AND tb_persona.per_dni = ?";
    		$data2[] = $data[1];
    	} else if($data[0] == "CARNET"){
    		$sqltext = " AND tb_inscripcion.ins_carnet = ?";
    		$data2[] = $data[1];
    	}

      	$result = $this->db->query("SELECT 
            	tb_deuda_individual.di_codigo AS codigo,
                tb_persona.per_dni AS dni,
                CONCAT(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS nombres,
                tb_deuda_individual.di_monto AS monto,
                tb_deuda_individual.di_fecha_vencimiento AS fvence,
                tb_deuda_individual.di_saldo AS saldo,
                tb_deuda_individual.di_estado AS estado,
                tb_carrera.car_nombre AS carrera,
                tb_ciclo.cic_nombre AS ciclo,
                tb_gestion.gt_nombre as gestion,
                tb_matricula.codigoperiodo as codperiodo,
                tb_carrera.car_sigla as sigla
              FROM
                tb_matricula
                INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
                INNER JOIN tb_inscripcion ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
                INNER JOIN tb_persona ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
                INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
                INNER JOIN tb_gestion ON (tb_deuda_individual.cod_gestion = tb_gestion.gt_codigo)
        WHERE tb_deuda_individual.di_saldo > 0 AND tb_deuda_individual.di_estado='ACTIVO' $sqltext",$data2);
        return $result->result();
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mtesoreria_matricula extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function m_matricula_x_periodo_carnetes($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS alumno,
		  tb_persona.per_tipodoc AS tipodoc,
		  tb_persona.per_dni AS dni,
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

	public function m_pagos_xcarne($data)
    {
        $qry = $this->db->query("SELECT 
			  tb_docpago.dcp_id AS codigo,
			  tb_docpago.dcp_serie AS serie,
			  tb_docpago.dcp_numero AS numero,
			  tb_docpago.dcp_fecha_hora AS fecha_hora,
			  tb_docpago.pagante_cod AS codpagante,
			  tb_docpago.dcp_pagante AS pagante,
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
          	WHERE  tb_docpago.pagante_tipodoc = ? AND tb_docpago.pagante_nrodoc = ? AND tb_docpago.dcp_estado='ACEPTADO' 
          	ORDER BY
             tb_docpago.dcp_serie,tb_docpago.dcp_numero DESC ", $data);
        
        return $qry->result();
        
    }

    public function m_pagos_detalle_xcarne($data)
    {
        $qry = $this->db->query("SELECT 
			  tb_docpago.dcp_id AS codpago,
			  tb_docpago.dcp_serie AS serie,
			  tb_docpago.dcp_numero AS numero,
			  tb_docpago_detalle.cod_docpago as iddoc,
			  tb_docpago_detalle.dpd_gestion as gestion,
			  tb_docpago_detalle.dpd_cantidad as cantidad,
			  tb_docpago_detalle.dpd_mnto_igv as migv,
			  tb_docpago_detalle.dpd_mnto_precio_unit as mpunit
			FROM
			  tb_docpago_detalle
			  INNER JOIN tb_docpago ON (tb_docpago_detalle.cod_docpago = tb_docpago.dcp_id)
          	WHERE  tb_docpago.pagante_tipodoc = ? AND tb_docpago.pagante_nrodoc = ? AND tb_docpago.dcp_estado='ACEPTADO' 
          	ORDER BY
             tb_docpago.dcp_serie,tb_docpago.dcp_numero DESC ", $data);
        
        return $qry->result();
        
    }

}
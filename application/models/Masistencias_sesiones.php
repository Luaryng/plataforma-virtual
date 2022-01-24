<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masistencias_sesiones extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_asistencias_copia($data)
    {
        $result = $this->db->query("SELECT 
              tb_carga_sesiones_asistencias.sesa_id as codigp,
              tb_carga_sesiones_asistencias.cod_docente as codocente,
              tb_carga_sesiones_asistencias.sesa_nombres as docente,
              tb_carga_sesiones_asistencias.cod_unidad as idunidad,
              tb_unidad_didactica.undd_nombre as unidad,
              tb_carga_sesiones_asistencias.sesa_fecha as fecha,
              tb_carga_sesiones_asistencias.ses_id as idses,
              tb_carga_sesiones.ses_detalle as detalle,
              tb_carga_sesiones.ses_fecha as sesfecha,
              tb_carga_sesiones.ses_horaini as horaini,
              tb_carga_sesiones.ses_horafin horafin
            FROM
              tb_carga_sesiones_asistencias
              LEFT OUTER JOIN tb_carga_sesiones ON (tb_carga_sesiones_asistencias.ses_id = tb_carga_sesiones.ses_id)
              LEFT OUTER JOIN tb_unidad_didactica ON (tb_carga_sesiones_asistencias.cod_unidad = tb_unidad_didactica.undd_codigo)
            WHERE
              tb_carga_sesiones_asistencias.cod_docente = ? AND 
              tb_carga_sesiones.ses_fecha BETWEEN ? AND ? 
              ORDER BY tb_carga_sesiones_asistencias.sesa_fecha DESC", $data);

        return $result->result();
    }

    public function m_get_asistencias($data)
    {
        $result = $this->db->query("SELECT 
              tb_carga_sesiones.ses_detalle AS detalle,
              tb_carga_sesiones.ses_fecha AS sesfecha,
              tb_carga_sesiones.ses_horaini AS horaini,
              tb_carga_sesiones.ses_horafin AS horafin,
              tb_carga_sesiones_asistencias.sesa_id AS codigp,
              tb_carga_sesiones_asistencias.cod_docente AS codocente,
              tb_carga_sesiones_asistencias.sesa_nombres AS docente,
              tb_carga_sesiones_asistencias.cod_unidad AS idunidad,
              tb_unidad_didactica.undd_nombre AS unidad,
              unid2.undd_nombre AS unidad2,
              tb_carga_sesiones_asistencias.sesa_fecha AS fecha,
              tb_carga_sesiones_asistencias.ses_id AS idses
            FROM
              tb_carga_sesiones_asistencias
              RIGHT OUTER JOIN tb_carga_sesiones ON (tb_carga_sesiones_asistencias.ses_id = tb_carga_sesiones.ses_id)
              LEFT OUTER JOIN tb_unidad_didactica ON (tb_carga_sesiones_asistencias.cod_unidad = tb_unidad_didactica.undd_codigo)
              INNER JOIN tb_carga_academica ON (tb_carga_sesiones.codigocarga = tb_carga_academica.cac_id)
              INNER JOIN tb_unidad_didactica AS unid2 ON (tb_carga_academica.codigouindidadd = unid2.undd_codigo)
              INNER JOIN tb_carga_academica_subseccion ON (tb_carga_sesiones.codigocarga = tb_carga_academica_subseccion.codigocargaacademica)
              AND (tb_carga_sesiones.codigosubseccion = tb_carga_academica_subseccion.codigosubseccion)
            WHERE
              tb_carga_academica_subseccion.codigodocente = ? AND 
              (tb_carga_sesiones_asistencias.cod_docente = ? OR 
              tb_carga_sesiones_asistencias.cod_docente IS NULL) AND 
              tb_carga_sesiones_asistencias.cod_estudiante IS NULL AND 
              tb_carga_sesiones.ses_fecha BETWEEN ? AND ?
            ORDER BY
              tb_carga_sesiones_asistencias.sesa_fecha DESC", $data);

        return $result->result();
    }

    


}


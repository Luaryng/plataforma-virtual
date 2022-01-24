<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mgraficos extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_emitidos_cobros()
    {
      $qry = $this->db->query("SELECT 
            tb_docpago.dcp_id AS codigo,
            tb_docpago.dcp_serie AS serie,
            tb_docpago.dcp_numero AS numero,
            tb_docpago.dcp_fecha_hora AS fecha_hora,
            tb_docpago.pagante_cod AS codpagante,
            tb_docpago.dcp_pagante AS pagante,
            tb_docpago.pagante_tipodoc AS pagantetipodoc,
            tb_docpago.pagante_nrodoc AS pagantenrodoc,
            tb_docpago.tipodoc_cod AS tipodoc,
            tb_docpago.dcp_estado AS estado,
            tb_docpago.dcp_total AS total,
            tb_docpago.sede_id AS sede,
            tb_sede.sed_nombre AS sednombre,
            tb_docpago.dcp_anulacion_motivo AS anul_motivo,
            tb_docpago.dcp_fecha_anulacion AS anul_fecha,
            SUM(case when tb_docpago_cobros.medio_cod = 1 then tb_docpago_cobros.dpc_monto else 0 end) AS efectivo,
            SUM(case when tb_docpago_cobros.medio_cod = 2 then tb_docpago_cobros.dpc_monto else 0 end) AS banco
          FROM
            tb_docpago
            LEFT OUTER JOIN tb_docpago_cobros ON (tb_docpago.dcp_id = tb_docpago_cobros.docpago_cod)
            INNER JOIN tb_sede ON (tb_docpago.sede_id = tb_sede.id_sede)
          GROUP BY
            tb_docpago.dcp_id,
            tb_docpago.dcp_serie,
            tb_docpago.dcp_numero,
            tb_docpago.dcp_fecha_hora,
            tb_docpago.pagante_cod,
            tb_docpago.dcp_pagante,
            tb_docpago.pagante_tipodoc,
            tb_docpago.pagante_nrodoc,
            tb_docpago.tipodoc_cod,
            tb_docpago.dcp_estado,
            tb_docpago.dcp_total,
            tb_docpago.sede_id,
            tb_docpago.dcp_anulacion_motivo,
            tb_docpago.dcp_fecha_anulacion
          ORDER BY tb_docpago.dcp_fecha_hora DESC ");
        
        return $qry->result();
    }

    public function m_get_emitidos_cobrosxsede()
    {
      $qry = $this->db->query("SELECT 
            tb_docpago.dcp_id AS codigo,
            tb_docpago.dcp_serie AS serie,
            tb_docpago.dcp_numero AS numero,
            tb_docpago.dcp_fecha_hora AS fecha_hora,
            tb_docpago.pagante_cod AS codpagante,
            tb_docpago.dcp_pagante AS pagante,
            tb_docpago.pagante_tipodoc AS pagantetipodoc,
            tb_docpago.pagante_nrodoc AS pagantenrodoc,
            tb_docpago.tipodoc_cod AS tipodoc,
            tb_docpago.dcp_estado AS estado,
            tb_docpago.dcp_total AS total,
            tb_docpago.sede_id AS sede,
            tb_sede.sed_nombre AS sednombre,
            tb_docpago.dcp_anulacion_motivo AS anul_motivo,
            tb_docpago.dcp_fecha_anulacion AS anul_fecha,
            tb_docpago_medio.dm_nombre as medio,
            SUM(case when tb_docpago.sede_id IN (SELECT tb_sede.id_sede FROM tb_sede) then tb_docpago.dcp_total else 0 end) AS totalsede,
            SUM(case when tb_docpago_cobros.medio_cod = 1 then tb_docpago_cobros.dpc_monto else 0 end) AS efectivo,
            SUM(case when tb_docpago_cobros.medio_cod = 2 then tb_docpago_cobros.dpc_monto else 0 end) AS banco
          FROM
            tb_docpago
            LEFT OUTER JOIN tb_docpago_cobros ON (tb_docpago.dcp_id = tb_docpago_cobros.docpago_cod)
            INNER JOIN tb_sede ON (tb_docpago.sede_id = tb_sede.id_sede)
            INNER JOIN tb_docpago_medio ON (tb_docpago_cobros.medio_cod = tb_docpago_medio.dm_codigo)
          GROUP BY
            sede
          ORDER BY tb_docpago.dcp_fecha_hora DESC ");
        
        return $qry->result();
    }

    public function m_suma_por_banco()
    {
      $qry = $this->db->query("SELECT 
            tb_docpago_cobros.dpc_id AS codigo,
            tb_docpago_cobros.dpc_fecha AS fecha,
            tb_docpago_cobros.medio_cod AS idmedio,
            tb_docpago_medio.dm_nombre AS nommedio,
            tb_docpago_cobros.banco_cod AS idbanco,
            tb_banco.bn_nombre AS nombanco,
            tb_docpago_cobros.dpc_monto AS montocob,
            tb_docpago_cobros.docpago_cod AS idocpag,
            SUM(case when tb_docpago_cobros.banco_cod = 1 then tb_docpago_cobros.dpc_monto else 0 end) AS banbcp,
            SUM(case when tb_docpago_cobros.banco_cod = 2 then tb_docpago_cobros.dpc_monto else 0 end) AS baninterb
          FROM
            tb_docpago_cobros
            INNER JOIN tb_docpago_medio ON (tb_docpago_cobros.medio_cod = tb_docpago_medio.dm_codigo)
            LEFT JOIN tb_banco ON (tb_docpago_cobros.banco_cod = tb_banco.bn_codigo)
            INNER JOIN tb_docpago ON (tb_docpago_cobros.docpago_cod = tb_docpago.dcp_id)
          WHERE tb_docpago_cobros.medio_cod = 2
          GROUP BY
            tb_docpago_cobros.dpc_id,
            tb_docpago_medio.dm_nombre");
        
        return $qry->result();
    }


}


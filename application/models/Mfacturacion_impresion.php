<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfacturacion_impresion extends CI_Model {

	function __construct() {
           parent::__construct();
    }



  public function m_get_docpagos($data)
  {
      $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id AS id,
          tb_docpago.codtipoo_peracion_51 AS opera51,
          tb_docpago.tipodoc_cod AS tdocid,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS numero,
          tb_docpago.dcp_fecha_hora AS fecha,
          tb_docpago.pagante_cod AS pagante,
          tb_docpago.dcp_pagante AS pagantenom,
          tb_docpago.pagante_tipodoc AS ptipodoc,
          tb_docpago.pagante_nrodoc AS pnrodoc,
          tb_docpago.dcp_direccion AS direccion,
          tb_docpago.matricula_cod AS matriculaid,
          tb_docpago.dcp_guia AS guia,
          tb_docpago.dcp_observacion AS observacion,
          tb_docpago.dcp_fecha_anulacion AS fanulacion,
          tb_docpago.dcp_estadoSunat AS estadosunat,
          tb_docpago.sede_id AS sedeid,
          tb_docpago.dcp_estado AS estado,
          tb_docpago.dcp_descuento_general AS descgeneral,
          tb_docpago.dcp_descuento_factor AS descfactor,
          tb_docpago.dcp_igv AS igv,
          tb_docpago.dcp_total AS total,
          tb_docpago.dcp_mnto_oper_gravadas AS opgravadas,
          tb_docpago.dcp_mnto_oper_inafecta AS opinafec,
          tb_docpago.dcp_mnto_oper_exonerada AS opexone,
          tb_docpago.dcp_mnto_oper_exportacion AS opexport,
          tb_docpago.dcp_mnto_dsctos_totales AS desctotales,
          tb_docpago.dcp_mnto_oper_gratis AS opgratis,
          tb_docpago.dcp_mnto_igv AS migv,
          tb_docpago.dcp_monto_icbper AS micbper,
          tb_docpago.dcp_mnto_isc AS misc,
          tb_docpago.dcp_total_impuestos AS totalimpuesto,
          tb_docpago.dcp_valor_venta AS valventa,
          tb_docpago.dcp_subtotal AS subtotal,
          tb_docpago.dcp_fecha_vence AS fvence,
          tb_docpago.dcp_fecha_creacion AS fcreacion,
         
          
          tb_doctipo.dt_nombre AS nomtipo,
          tb_doctipo.dt_nombre_impresion AS nomimpreso,
          tb_doc_identidad.ti_codigo_sunat AS codtipsnt,
          tb_doctipo.dt_codsunat AS codtpdcsnt,
          tb_docpago_sunat.dcps_snt_cadenaqr AS cadena_qr,
          tb_doc_tiponota_cd.tn_descripcion as tiponota,
          tb_docpago.dcp_serie_afectado as serie_afectado,
          tb_docpago.dcp_numero_afectado as nro_afectado,
          tb_docpago.dcp_motivo_afectado as motivo,
          tb_doctipo1.dt_nombre as tipo_afectado
        FROM
          tb_docpago
          
          INNER JOIN tb_doctipo ON (tb_docpago.tipodoc_cod = tb_doctipo.dt_id)
          
          INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
          INNER JOIN tb_docpago_sunat ON (tb_docpago.dcp_id = tb_docpago_sunat.dcps_id)
          LEFT OUTER JOIN tb_doc_tiponota_cd ON (tb_docpago.tiponota_cod = tb_doc_tiponota_cd.tn_codigo)
          LEFT OUTER JOIN tb_doctipo tb_doctipo1 ON (tb_docpago.tipodoc_cod_afectado = tb_doctipo1.dt_id)
      WHERE
        tb_docpago.dcp_id = ?
      LIMIT 1", $data);
      
      return $qry->row();
  }

  public function m_get_pagos_detalle($data)
  {
    $qry = $this->db->query("SELECT 
          tb_docpago_detalle.dpd_id as id,
          tb_docpago_detalle.cod_docpago as iddocp,
          tb_docpago_detalle.tipodoc_cod as tdocid,
          tb_docpago_detalle.cod_unidad as undid,
          tb_docpago_detalle.gestion_cod as gestid,
          tb_docpago_detalle.dpd_gestion as gestion,
          tb_docpago_detalle.dpd_cantidad as cantidad,
          tb_docpago_detalle.dpd_mnto_valor_unitario as vunitario,
          tb_docpago_detalle.dpd_mnto_valor_venta as valventa,
          tb_docpago_detalle.dpd_mnto_base_sinigv as mbigv,
          tb_docpago_detalle.dpd_porc_igv as pigv,
          tb_docpago_detalle.dpd_mnto_igv as migv,
          tb_docpago_detalle.cod_tipoafc_igv as tafigv,
          tb_docpago_detalle.dpd_monto_total_impuesto as mtimpuesto,
          tb_docpago_detalle.dpd_mnto_precio_unit as mpunit,
          tb_docpago_detalle.dpd_facturar_como as fcomo,
          tb_docpago_detalle.dpd_facturar_como_cant as fcomocant,
          tb_docpago_detalle.deuda_cod as deudaid,
          tb_docpago_detalle.dpd_fecha_creacion as fcreacion,
          tb_docpago_detalle.cod_isc as iscid,
          tb_docpago_detalle.dpd_isc_factor as iscfac,
          tb_docpago_detalle.dpd_isc_valor as iscvalor,
          tb_docpago_detalle.dpd_isc_base_imponible as iscbimp,
          tb_docpago_detalle.dpd_dscto_factor as dfactor,
          tb_docpago_detalle.dpd_dscto_valor as dvalor,
          tb_docpago_detalle.dpd_icbper_factor as icbfactor,
          tb_docpago_detalle.dpd_icbper_mnto as icbmonto,
          tb_docpago_detalle.dpd_igv_afectado as igvafect,
          tb_docpago_detalle.dpd_tipoitem as tipoitem,
          tb_docpago_detalle.dpd_esgratis as esgratis
        FROM
          tb_docpago_detalle
            WHERE cod_docpago = ? ", $data);
    return $qry->result();
  }

  public function m_get_pagos_detalle_sede()
  {
    $qry = $this->db->query("SELECT 
          tb_docpago_detalle.dpd_id as id,
          tb_docpago_detalle.cod_docpago as iddocp,
          tb_docpago_detalle.tipodoc_cod as tdocid,
          tb_docpago_detalle.cod_unidad as undid,
          tb_docpago_detalle.gestion_cod as gestid,
          tb_docpago_detalle.dpd_gestion as gestion,
          tb_docpago_detalle.dpd_cantidad as cantidad,
          tb_docpago_detalle.dpd_mnto_valor_unitario as vunitario,
          tb_docpago_detalle.dpd_mnto_valor_venta as valventa,
          tb_docpago_detalle.dpd_mnto_base_sinigv as mbigv,
          tb_docpago_detalle.dpd_porc_igv as pigv,
          tb_docpago_detalle.dpd_mnto_igv as migv,
          tb_docpago_detalle.cod_tipoafc_igv as tafigv,
          tb_docpago_detalle.dpd_monto_total_impuesto as mtimpuesto,
          tb_docpago_detalle.dpd_mnto_precio_unit as mpunit,
          tb_docpago_detalle.dpd_facturar_como as fcomo,
          tb_docpago_detalle.dpd_facturar_como_cant as fcomocant,
          tb_docpago_detalle.deuda_cod as deudaid,
          tb_docpago_detalle.dpd_fecha_creacion as fcreacion,
          tb_docpago_detalle.cod_isc as iscid,
          tb_docpago_detalle.dpd_isc_factor as iscfac,
          tb_docpago_detalle.dpd_isc_valor as iscvalor,
          tb_docpago_detalle.dpd_isc_base_imponible as iscbimp,
          tb_docpago_detalle.dpd_dscto_factor as dfactor,
          tb_docpago_detalle.dpd_dscto_valor as dvalor,
          tb_docpago_detalle.dpd_icbper_factor as icbfactor,
          tb_docpago_detalle.dpd_icbper_mnto as icbmonto,
          tb_docpago_detalle.dpd_igv_afectado as igvafect,
          tb_docpago_detalle.dpd_tipoitem as tipoitem,
          tb_docpago_detalle.dpd_esgratis as esgratis,
          tb_gestion.gt_nombre as nombregest
        FROM
          tb_docpago_detalle
            INNER JOIN tb_gestion ON (tb_gestion.gt_codigo = tb_docpago_detalle.gestion_cod)
            ");
    return $qry->result();
  }

  public function m_get_docserie_sede($data)
  {
        $qry = $this->db->query("SELECT 
                  tb_doctipo_sede.cod_sede AS sede,
                  tb_doctipo_sede.cod_doctipo AS tipo,
                  tb_doctipo_sede.dtse_ruc AS ruc,
                  tb_doctipo_sede.dtse_serie AS serie,
                  tb_doctipo_sede.dtse_contador_nro AS contador,
                  tb_doctipo_sede.dtse_codlocal_sunat AS codsunat,
                  tb_doctipo_sede.cod_tipo_operacion51 AS codoperacion51,
                  tb_doctipo_sede.dtse_igv_porcentaje AS igvpr,
                  tb_sede.sed_direccion as direccion,
                  tb_distrito.dis_nombre AS distrito,
                  tb_provincia.prv_nombre AS provincia,
                  tb_departamento.dep_nombre AS departamento,
                  tb_doctipo_sede.dtse_tamanio_hoja as formato
                FROM
                  tb_sede
                  INNER JOIN tb_doctipo_sede ON (tb_sede.id_sede = tb_doctipo_sede.cod_sede)
                  INNER JOIN tb_distrito ON (tb_sede.cod_distrito = tb_distrito.dis_codigo)
                  INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
                  INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
                 WHERE tb_doctipo_sede.cod_doctipo = ? AND tb_doctipo_sede.cod_sede = ? and  tb_doctipo_sede.dtse_predeterminado='SI' AND tb_doctipo_sede.dtse_habilitado='SI'
                LIMIT 1", $data);
        
        return $qry->row();
  }


  public function m_get_docserie_sede_tipo($data)
  {
        $qry = $this->db->query("SELECT 
              tb_doctipo_sede.cod_sede AS sede,
              tb_doctipo_sede.cod_doctipo AS tipo,
              tb_doctipo_sede.dtse_ruc AS ruc,
              tb_doctipo_sede.dtse_contador_nro AS contador,
              tb_doctipo_sede.dtse_codlocal_sunat AS codsunat,
              tb_doctipo_sede.cod_tipo_operacion51 AS codoperacion51,
              tb_doctipo_sede.dtse_igv_porcentaje AS igvpr,
              tb_sede.sed_direccion AS direccion,
              tb_distrito.dis_nombre AS distrito,
              tb_provincia.prv_nombre AS provincia,
              tb_departamento.dep_nombre AS departamento,
              tb_doctipo_sede.dtse_tamanio_hoja AS formato,
              tb_doctipo_sede.dtse_tamanio_hoja_imp AS formato_imp,
              tb_doctipo_sede.dtse_predeterminado AS prede,
              tb_doctipo_sede.dtse_razonsocial AS razon
            FROM
              tb_sede
              INNER JOIN tb_doctipo_sede ON (tb_sede.id_sede = tb_doctipo_sede.cod_sede)
              INNER JOIN tb_distrito ON (tb_sede.cod_distrito = tb_distrito.dis_codigo)
              INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
              INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
            WHERE tb_doctipo_sede.cod_doctipo = ? AND tb_doctipo_sede.cod_sede = ? and tb_doctipo_sede.dtse_serie=? 
                LIMIT 1", $data);
        
        return $qry->row();
  }

    public function m_get_emitidos_filtro_xsede($sede,$pagante,$fechas,$estado)
    {
      $data=array($sede);
      $sqltext="";
      if (count($fechas)>0){
        $sqltext=" AND tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
        $data[]=$fechas[0];
        $data[]=$fechas[1];

      }
      if (trim($pagante)!=""){
        $sqltext= $sqltext." AND concat(tb_docpago.pagante_cod,' ',tb_docpago.dcp_pagante)  like ? ";
        $data[]="%".$pagante."%";
      }

      $sqltext_estado="";
      if ($estado[0]=="TODOS"){

      }
      else{
          $sqltext_estado=" AND tb_docpago.dcp_estado IN ('".implode("','", $estado)."')";
         
      }
      //$idsede = $_SESSION['userActivo']->idsede;
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
            tb_docpago.dcp_serie_afectado as serie_afectado,
            tb_docpago.dcp_numero_afectado as nro_afectado,
            tb_docpago.tipodoc_cod_afectado as tipodoc_afectado,
            tb_docpago.dcp_anulacion_motivo AS anul_motivo,
            tb_docpago.dcp_fecha_anulacion AS anul_fecha,
            SUM(case when tb_docpago_cobros.medio_cod = 1 then tb_docpago_cobros.dpc_monto else 0 end) AS efectivo,
            SUM(case when tb_docpago_cobros.medio_cod = 2 then tb_docpago_cobros.dpc_monto else 0 end) AS banco
          FROM
            tb_docpago
            LEFT OUTER JOIN tb_docpago_cobros ON (tb_docpago.dcp_id = tb_docpago_cobros.docpago_cod)
          WHERE tb_docpago.sede_id=? $sqltext $sqltext_estado
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
            tb_docpago.dcp_serie_afectado,
            tb_docpago.dcp_numero_afectado,
            tb_docpago.dcp_serie_afectado,
            tb_docpago.dcp_anulacion_motivo,
            tb_docpago.dcp_fecha_anulacion
          ORDER BY tb_docpago.dcp_serie, tb_docpago.dcp_numero ", $data);
        
        return $qry->result();
    }

     public function m_get_emitidos_filtro_xsede_cuadro_conceptos($sede,$pagante,$fechas,$estado)
    {
      $data=array($sede);
      $sqltext="";
      if (count($fechas)>0){
        $sqltext=" AND tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
        $data[]=$fechas[0];
        $data[]=$fechas[1];

      }
      if (trim($pagante)!=""){
        $sqltext= $sqltext." AND concat(tb_docpago.pagante_cod,' ',tb_docpago.dcp_pagante)  like ? ";
        $data[]="%".$pagante."%";
      }

      $sqltext_estado="";
      if ($estado[0]=="TODOS"){

      }
      else{
          $sqltext_estado=" AND tb_docpago.dcp_estado IN ('".implode("','", $estado)."')";
         
      }
      //$idsede = $_SESSION['userActivo']->idsede;
      $qry = $this->db->query("SELECT 
            tb_docpago_detalle.cod_docpago as codigo,
            tb_docpago_detalle.gestion_cod as codgestion,
            SUM(tb_docpago_detalle.dpd_mnto_valor_venta) AS monto
          FROM
            tb_docpago
            INNER JOIN tb_docpago_detalle ON (tb_docpago.dcp_id = tb_docpago_detalle.cod_docpago)

          WHERE tb_docpago.sede_id=? $sqltext $sqltext_estado
          GROUP BY
            tb_docpago_detalle.cod_docpago,
            tb_docpago_detalle.gestion_cod
          ORDER BY tb_docpago.dcp_serie, tb_docpago.dcp_numero,tb_docpago_detalle.gestion_cod", $data);
        
        return $qry->result();
    }


    public function m_get_emitidos_filtro_xsede_medio_pago($sede,$pagante,$fechas,$estado)
    {
      $data=array($sede);
      $sqltext="";
      if (count($fechas)>0){
        $sqltext=" AND tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
        $data[]=$fechas[0];
        $data[]=$fechas[1];

      }
      if (trim($pagante)!=""){
        $sqltext= $sqltext." AND concat(tb_docpago.pagante_cod,' ',tb_docpago.dcp_pagante)  like ? ";
        $data[]="%".$pagante."%";
      }

      $sqltext_estado="";
      if ($estado[0]=="TODOS"){

      }
      else{
          $sqltext_estado=" AND tb_docpago.dcp_estado IN ('".implode("','", $estado)."')";
         
      }

      $rs=array();
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
            tb_docpago.dcp_serie_afectado as serie_afectado,
            tb_docpago.dcp_numero_afectado as nro_afectado,
            tb_docpago.tipodoc_cod_afectado as tipodoc_afectado,
            tb_docpago.dcp_anulacion_motivo AS anul_motivo,
            tb_docpago.dcp_fecha_anulacion AS anul_fecha,
            SUM(case when tb_docpago_cobros.medio_cod = 1 then tb_docpago_cobros.dpc_monto else 0 end) AS efectivo,
            SUM(case when tb_docpago_cobros.medio_cod = 2 then tb_docpago_cobros.dpc_monto else 0 end) AS banco
          FROM
            tb_docpago
            LEFT OUTER JOIN tb_docpago_cobros ON (tb_docpago.dcp_id = tb_docpago_cobros.docpago_cod)
          WHERE tb_docpago.sede_id=? $sqltext $sqltext_estado 
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
            tb_docpago.dcp_serie_afectado,
            tb_docpago.dcp_numero_afectado,
            tb_docpago.tipodoc_cod_afectado,
            tb_docpago.dcp_anulacion_motivo,
            tb_docpago.dcp_fecha_anulacion
          ORDER BY tb_docpago.dcp_serie, tb_docpago.dcp_numero ", $data);

      $qry2 = $this->db->query("SELECT 
          tb_docpago.dcp_id as codigo,
          tb_docpago_cobros.medio_cod AS codmedio,
          tb_docpago_medio.dm_nombre AS medio,
          tb_docpago_cobros.banco_cod AS codbanco,
          tb_banco.bn_banco_sigla AS banco,
          tb_docpago_cobros.dpc_monto AS monto,
          tb_docpago_cobros.dcp_nro_operacion AS operacion,
          tb_docpago_cobros.dcp_fecha_operacion AS fecha
        FROM
          tb_docpago_cobros
          INNER JOIN tb_docpago_medio ON (tb_docpago_cobros.medio_cod = tb_docpago_medio.dm_codigo)
          INNER JOIN tb_banco ON (tb_docpago_cobros.banco_cod = tb_banco.bn_codigo)
          INNER JOIN tb_docpago ON (tb_docpago_cobros.docpago_cod = tb_docpago.dcp_id)
                  WHERE tb_docpago.sede_id=? $sqltext $sqltext_estado
          ", $data);

      
        
        $rs['docpagos']=$qry->result();
        $rs['docpagosmedios']=$qry2->result();
        return $rs;
    }

    public function m_get_emitidositems_filtro_xsede($sede,$concepto,$fechas)
    {
      $data=array($sede);
      $sqltext="";
      if (count($fechas)>0){
        $sqltext=" AND tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
        $data[]=$fechas[0];
        $data[]=$fechas[1];

      }
      if (trim($concepto)!=""){
        $sqltext= $sqltext." AND tb_docpago_detalle.gestion_cod = ? ";
        $data[]= $concepto;
      }

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
            tb_docpago.dcp_observacion AS observacion,
            tb_docpago.dcp_estado AS estado,
            tb_docpago.dcp_total AS total,
            tb_docpago.sede_id AS sede,
            tb_docpago.dcp_serie_afectado as serie_afectado,
            tb_docpago.dcp_numero_afectado as nro_afectado,
            tb_docpago.tipodoc_cod_afectado as tipodoc_afectado,
            tb_docpago.dcp_anulacion_motivo AS anul_motivo,
            tb_docpago.dcp_fecha_anulacion AS anul_fecha,
            tb_docpago_detalle.dpd_gestion AS gestion,
            tb_docpago_detalle.dpd_mnto_precio_unit AS punit,
            tb_periodo.ped_nombre AS periodo,
            tb_carrera.car_nombre AS carrera,
            tb_ciclo.cic_nombre AS ciclo
          FROM
            tb_docpago
            INNER JOIN tb_docpago_detalle ON (tb_docpago.dcp_id = tb_docpago_detalle.cod_docpago)
            LEFT OUTER JOIN tb_matricula ON (tb_docpago.matricula_cod = tb_matricula.mtr_id)
            LEFT OUTER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
            LEFT OUTER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
            LEFT OUTER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
          WHERE tb_docpago.sede_id = ? $sqltext
          
          ORDER BY tb_docpago.dcp_serie, tb_docpago.dcp_numero ", $data);
        
        return $qry->result();
    }

    public function m_get_emitidositems_x_pagante($data)
    {

      $qry = $this->db->query("SELECT 
            tb_docpago.tipodoc_cod AS codtipo,
            tb_docpago.dcp_serie AS serie,
            tb_docpago.dcp_numero AS numero,
            tb_docpago.dcp_fecha_hora AS fecha_hora,
            tb_docpago.pagante_cod AS pagante,
            tb_docpago_detalle.dpd_id AS coddetalle,
            tb_docpago_detalle.gestion_cod as codgestion, 
            tb_docpago_detalle.dpd_gestion as gestion,
            tb_docpago_detalle.dpd_mnto_valor_venta as monto,
            tb_docpago_detalle.deuda_cod as coddeuda
          FROM
            tb_docpago_detalle
            INNER JOIN tb_docpago ON (tb_docpago_detalle.cod_docpago = tb_docpago.dcp_id) 
          WHERE
            tb_docpago.pagante_cod=?  
          ORDER BY tb_docpago.dcp_fecha_hora DESC", $data);
        
        return $qry->result();
    }

    public function m_get_consolidado_mes($data)
    {
      $result = $this->db->query("SELECT 
          tb_docpago.sede_id AS codsede,
          tb_sede.sed_nombre AS sede,
          MONTH(tb_docpago.dcp_fecha_hora) AS mes,
          tb_docpago_cobros.medio_cod AS codmedio,
          tb_docpago_medio.dm_nombre AS medio,
          tb_docpago.tipodoc_cod AS codtipodoc,
          tb_doctipo.dt_nombre AS tipodoc,
          tb_docpago.dcp_serie AS serie,
          SUM(tb_docpago_cobros.dpc_monto) AS monto
        FROM
          tb_docpago_cobros
          INNER JOIN tb_docpago ON (tb_docpago_cobros.docpago_cod = tb_docpago.dcp_id)
          INNER JOIN tb_docpago_medio ON (tb_docpago_cobros.medio_cod = tb_docpago_medio.dm_codigo)
          INNER JOIN tb_doctipo ON (tb_docpago.tipodoc_cod = tb_doctipo.dt_id)
          INNER JOIN tb_sede ON (tb_docpago.sede_id = tb_sede.id_sede)
        WHERE tb_docpago.sede_id LIKE ? AND MONTH(tb_docpago.dcp_fecha_hora) LIKE ? AND YEAR(tb_docpago.dcp_fecha_hora) = ?
        GROUP BY
          tb_docpago.sede_id,
          tb_sede.sed_nombre,
          MONTH(tb_docpago.dcp_fecha_hora),
          tb_docpago_cobros.medio_cod,
          tb_docpago_medio.dm_nombre,
          tb_docpago.tipodoc_cod,
          tb_doctipo.dt_nombre,
          tb_docpago.dcp_serie
        ORDER BY
          codsede,
          mes,
          codtipodoc,
          codmedio", $data);
      return $result->result();
    }
    

    public function mget_estado_cuenta_deudas($pagante, $fechas, $semestre, $pendiente)
    {
      $semestres = implode("','", $semestre);
      $documento = '%'.$pagante.'%';
      $sqltxt = "";
      $data = array();
      if (count($fechas)>0){
          $sqltext=" AND tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
          $data[]=$fechas[0];
          $data[]=$fechas[1];
      }

      if ($pendiente == "SI") {
        $sqltxt = " AND tb_deuda_individual.di_saldo > 0";
      }

      $qy = $this->db->query("SELECT 
                tb_persona.per_dni AS dni,
                CONCAT(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS nombres,
                tb_inscripcion.ins_carnet as carnet,
                tb_carrera.car_nombre AS carrera,
                tb_carrera.car_sigla as sigla
            FROM
                tb_persona
                LEFT OUTER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                LEFT OUTER JOIN tb_matricula ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
                LEFT OUTER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
          WHERE (tb_persona.per_dni = '$pagante' OR tb_inscripcion.ins_carnet = '$pagante') ");
        $rs['estud'] =$qy->row();

        $result = $this->db->query("SELECT 
                tb_deuda_individual.di_codigo AS codigo,
                tb_deuda_individual.di_monto AS monto,
                tb_deuda_individual.di_fecha_vencimiento AS fvence,
                tb_deuda_individual.di_saldo AS saldo,
                tb_deuda_individual.di_estado AS estado,
                tb_ciclo.cic_nombre AS ciclo,
                tb_gestion.gt_nombre as gestion,
                tb_matricula.codigoperiodo as codperiodo
            FROM
                tb_matricula
                INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
                INNER JOIN tb_inscripcion ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
                INNER JOIN tb_persona ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
                INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
                INNER JOIN tb_gestion ON (tb_deuda_individual.cod_gestion = tb_gestion.gt_codigo)
          WHERE tb_deuda_individual.di_estado='ACTIVO' 
            AND (tb_persona.per_dni = '$pagante' OR tb_inscripcion.ins_carnet = '$pagante') 
            AND tb_matricula.codigociclo IN ('$semestres') $sqltxt
            ORDER BY tb_deuda_individual.di_fecha_vencimiento ASC");
        $rs['deudas'] =$result->result();

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
        tb_docpago_detalle.dpd_gestion AS gestion,
        tb_docpago_detalle.dpd_cantidad AS cantidad,
        tb_docpago_detalle.dpd_mnto_valor_unitario AS p_unitario,
        tb_docpago.dcp_anulacion_motivo AS anul_motivo,
        tb_docpago.dcp_fecha_anulacion AS anul_fecha
      FROM
        tb_docpago_detalle
        INNER JOIN tb_docpago ON (tb_docpago_detalle.cod_docpago = tb_docpago.dcp_id)
            WHERE  (tb_docpago.pagante_cod = '$pagante' OR tb_docpago.pagante_nrodoc = '$pagante') AND  tb_docpago.dcp_estado='ACEPTADO' $sqltext 
            ORDER BY
             tb_docpago.dcp_serie,tb_docpago.dcp_numero DESC ", $data);
        
        $rs['items'] =$qry->result();

        return $rs;
    }
}
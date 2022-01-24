<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfacturacion_notas extends CI_Model {

	function __construct() {
           parent::__construct();
    }

  public function get_docpago_afectado($data) {
    $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id as coddoc,
          tb_docpago.tipodoc_cod as codtipodoc,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS nro,
          tb_docpago.pagante_tipodoc as tipodocidentidad,
          tb_docpago.pagante_cod as codpagante,
          tb_docpago.pagante_nrodoc AS pagnrodoc,
          tb_docpago.dcp_pagante AS pagante,
          tb_docpago.dcp_direccion AS pagdirecion,
          tb_pagante.pg_correo1 AS pagcorreo1,
          tb_pagante.pg_correo2 AS pagcorreo2,
          tb_pagante.pg_correo_corp AS pagcorreo3,
          tb_docpago.dcp_fecha_hora AS fecha,
          tb_docpago.dcp_fecha_vence AS vence,
          tb_docpago.dcp_igv AS igvporc,
          tb_docpago.dcp_descuento_general AS dsctoglobal,
          tb_docpago.dcp_mnto_dsctos_totales AS dsctototal,
          tb_docpago.dcp_mnto_oper_gravadas AS opergrav,
          tb_docpago.dcp_mnto_oper_inafecta AS operinaf,
          tb_docpago.dcp_mnto_oper_exonerada AS operexon,
          tb_docpago.dcp_mnto_igv AS igvtotal,
          tb_docpago.dcp_mnto_oper_gratis AS opergrat,
          tb_docpago.dcp_total AS total,
          tb_docpago.dcp_observacion AS obs,
          tb_docpago.dcp_estado as estado
        FROM
          tb_doctipo
          INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
          INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
          INNER JOIN tb_pagante ON (tb_docpago.pagante_cod = tb_pagante.pg_codpagante)
        WHERE concat(tb_docpago.dcp_serie,'-',tb_docpago.dcp_numero)  = ?  LIMIT 1", $data);
        $afectado['docitems']=array();
        $afectado['docpago']=$qry->row();
        if (isset($afectado['docpago']->coddoc)){
            $qry2 = $this->db->query("SELECT 
                tb_docpago_detalle.cod_unidad AS unidad,
                tb_docpago_detalle.gestion_cod AS codgestion,
                tb_docpago_detalle.dpd_gestion AS gestion,
                tb_docpago_detalle.dpd_cantidad AS cantidad,
                tb_docpago_detalle.dpd_mnto_valor_unitario AS v_unitario,
                tb_docpago_detalle.dpd_mnto_precio_unit AS p_unitario,
                tb_docpago_detalle.dpd_mnto_descuento AS m_descuento,
                tb_docpago_detalle.dpd_mnto_base_sinigv AS subtotal,
                tb_doc_tipoafectacion.ta_codigo_nubefact AS tipoigv,
                tb_docpago_detalle.dpd_mnto_igv AS igv,
                tb_docpago_detalle.dpd_mnto_valor_venta AS total,
                tb_docpago_detalle.cod_tipoafc_igv as codtipoafectacion,
                tb_docpago_detalle.dpd_tipoitem as tipoitem,
                tb_docpago_detalle.dpd_igv_afectado as afectado,
                tb_docpago_detalle.dpd_esgratis as esgratis,
                tb_docpago_detalle.cod_isc as codisc,
                tb_docpago_detalle.dpd_isc_base_imponible as iscbase,
                tb_docpago_detalle.dpd_isc_factor as iscfactor,
                tb_docpago_detalle.dpd_isc_valor as iscvalor,
                tb_docpago_detalle.dpd_dscto_factor as dsctofactor,
                tb_docpago_detalle.dpd_dscto_valor as dsctovalor
                
              FROM
                tb_doc_tipoafectacion
                INNER JOIN tb_docpago_detalle ON (tb_doc_tipoafectacion.ta_codigo = tb_docpago_detalle.cod_tipoafc_igv)
              WHERE tb_docpago_detalle.cod_docpago  = ? ", array($afectado['docpago']->coddoc));
          $afectado['docitems']=$qry2->result();
        }
        return $afectado;
  }

  public function m_get_tipo_notas($data){
    $qry = $this->db->query("SELECT 
        tb_doc_tiponota_cd.tn_codigo as codigo,
        tb_doc_tiponota_cd.tn_descripcion as nombre
      FROM
        tb_doc_tiponota_cd
      WHERE
        tb_doc_tiponota_cd.cod_tipodoc = ? AND tb_doc_tiponota_cd.tn_habilitado='SI'",$data);
    return $qry->result();
  }

  public function m_insert_nota($data)
  {
    $this->db->query("CALL  `sp_tb_docpago_nota_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid,@nrodoc)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid,@nrodoc as nrodoc');
    return   $res->row(); 
  }
  //ELIMINAR DE AQUI HACIA ABAJJO
  
    
    
    
    public function m_get_conexion_nubefact($data)
    {
        $qry = $this->db->query("SELECT 
                  sed_token_nubefact as token,
                  sed_ruta_nubefact as ruta
                FROM 
                  tb_sede 
                WHERE id_sede = ? LIMIT 1", $data);
        
        return $qry->row();
    }

    public function m_get_docserie($data)
    {
        $qry = $this->db->query("SELECT 
                  tb_doctipo_sede.cod_sede as sede,
                  tb_doctipo_sede.cod_doctipo as tipo,
                  tb_doctipo_sede.dtse_ruc as ruc,
                  tb_doctipo_sede.dtse_serie as serie,
                  tb_doctipo_sede.dtse_contador_nro as contador,
                  tb_doctipo_sede.dtse_codlocal_sunat as codsunat,
                  tb_doctipo_sede.cod_tipo_operacion51 as codoperacion51,
                  tb_doctipo_sede.dtse_igv_porcentaje as igvpr
                FROM 
                  tb_doctipo_sede 
                WHERE tb_doctipo_sede.cod_doctipo = ? AND tb_doctipo_sede.cod_sede = ?
                LIMIT 1", $data);
        
        return $qry->row();
    }

    public function update_correlativo_sede($data)
    {
      $qry = $this->db->query("UPDATE tb_doctipo_sede 
                  SET tb_doctipo_sede.dtse_contador_nro = tb_doctipo_sede.dtse_contador_nro + 1 
                  WHERE tb_doctipo_sede.cod_doctipo = ? AND tb_doctipo_sede.cod_sede = ?", $data );
      return 1;
    }


  
  public function m_insert_facturacion_reemplazo($data)
  {
    $this->db->query("CALL  `sp_tb_docpago_boleta_reemp_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid,@nrodoc)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid,@nrodoc as nrodoc');
    return   $res->row(); 
  }

  public function m_insert_facturacion_rpsunat($data)
  {
  
    $this->db->query("CALL  `sp_tb_docpago_sunat_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }
  public function m_insert_facturacion_rpsunat_error($data)
  {
  
    $this->db->query("CALL  `sp_tb_docpago_sunat_error_insert`(?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }

  public function m_update_facturacion_rpsunat($data)
  {
  
    $this->db->query("CALL  `sp_tb_docpago_sunat_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }
  public function m_update_facturacion_rpsunat_error($data)
  {
  
    $this->db->query("CALL  `sp_tb_docpago_sunat_error_update`(?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }


  public function m_insert_facturacion_anulacion_rpsunat($data)
  {
    $this->db->query("CALL  `sp_tb_docpago_sunat_anulacion_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }
  public function m_insert_facturacion_rpsunat_anulacion_error($data)
  {
  
    $this->db->query("CALL  `sp_tb_docpago_sunat_error_anulacion_insert`(?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }
  


  public function m_insert_facturacion_detalle($data)
  {
    $this->db->query("CALL `sp_tb_docpago_detalle_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }


  public function get_docpago($data) {
    $qry = $this->db->query("SELECT 
            tb_docpago.tipodoc_cod AS tipodoc_cod,
            tb_doctipo.dt_codnubefact AS tipodoc,
            tb_docpago.dcp_serie AS serie,
            tb_docpago.dcp_numero AS nro,
            tb_doc_identidad.ti_codigo_sunat AS pagtipodoc,
            tb_docpago.pagante_nrodoc AS pagnrodoc,
            tb_docpago.dcp_pagante AS pagante,
            tb_docpago.dcp_direccion AS pagdirecion,
            tb_docpago.dcp_fecha_hora AS fecha,
            tb_docpago.dcp_fecha_vence AS vence,
            tb_docpago.dcp_igv AS igvporc,
            tb_docpago.dcp_descuento_general AS dsctoglobal,
            tb_docpago.dcp_mnto_dsctos_totales AS dsctototal,
            tb_docpago.dcp_mnto_oper_gravadas AS opergrav,
            tb_docpago.dcp_mnto_oper_inafecta AS operinaf,
            tb_docpago.dcp_mnto_oper_exonerada AS operexon,
            tb_docpago.dcp_mnto_igv AS igvtotal,
            tb_docpago.dcp_mnto_oper_gratis AS opergrat,
            tb_docpago.dcp_total AS total,
            tb_docpago.dcp_observacion AS obs,
            tb_docpago.dcp_estado AS estado,
            tb_doc_tiponota_cd.tn_codigo_nubefact AS codtiponota,
            tb_docpago.dcp_serie_afectado AS serie_afectado,
            tb_docpago.dcp_numero_afectado AS nro_afectado,
            tb_docpago.dcp_motivo_afectado as motivo_afectado,
            tb_doctipo1.dt_codnubefact AS tipodoc_afectado
          FROM
            tb_doctipo
            INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
            INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
            INNER JOIN tb_doc_tiponota_cd ON (tb_docpago.tiponota_cod = tb_doc_tiponota_cd.tn_codigo)
            INNER JOIN tb_doctipo tb_doctipo1 ON (tb_docpago.tipodoc_cod_afectado = tb_doctipo1.dt_id)
                  WHERE tb_docpago.dcp_id  = ?  LIMIT 1", $data);
    
        return $qry->row();

  }

  public function get_docpagos_pendientes($data) {
    $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id as coddoc,
          tb_doctipo.dt_codnubefact AS tipodoc,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS nro,
          tb_doc_identidad.ti_codigo_sunat AS pagtipodoc,
          tb_docpago.pagante_nrodoc AS pagnrodoc,
          tb_docpago.dcp_pagante AS pagante,
          tb_docpago.dcp_direccion AS pagdirecion,
          tb_pagante.pg_correo1 AS pagcorreo1,
          tb_pagante.pg_correo2 AS pagcorreo2,
          tb_pagante.pg_correo_corp AS pagcorreo3,
          tb_docpago.dcp_fecha_hora AS fecha,
          tb_docpago.dcp_fecha_vence AS vence,
          tb_docpago.dcp_igv AS igvporc,
          tb_docpago.dcp_descuento_general AS dsctoglobal,
          tb_docpago.dcp_mnto_dsctos_totales AS dsctototal,
          tb_docpago.dcp_mnto_oper_gravadas AS opergrav,
          tb_docpago.dcp_mnto_oper_inafecta AS operinaf,
          tb_docpago.dcp_mnto_oper_exonerada AS operexon,
          tb_docpago.dcp_mnto_igv AS igvtotal,
          tb_docpago.dcp_mnto_oper_gratis AS opergrat,
          tb_docpago.dcp_total AS total,
          tb_docpago.dcp_observacion AS obs,
          tb_docpago.dcp_estado as estado
        FROM
          tb_doctipo
          INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
          INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
          INNER JOIN tb_pagante ON (tb_docpago.pagante_cod = tb_pagante.pg_codpagante)
        WHERE tb_docpago.sede_id  = ? AND (tb_docpago.dcp_estado='PENDIENTE' OR tb_docpago.dcp_estado='ERROR')
        ORDER BY
              tb_docpago.dcp_serie,tb_docpago.dcp_numero ASC", $data);
    
        return $qry->result();

  }
  public function get_items_docpago_pendientes($data) {
    $qry = $this->db->query("SELECT 
          tb_docpago_detalle.cod_docpago as coddoc,
          tb_docpago_detalle.cod_unidad AS unidad,
          tb_docpago_detalle.gestion_cod AS codgestion,
          tb_docpago_detalle.dpd_gestion AS gestion,
          tb_docpago_detalle.dpd_cantidad AS cantidad,
          tb_docpago_detalle.dpd_mnto_valor_unitario AS v_unitario,
          tb_docpago_detalle.dpd_mnto_precio_unit AS p_unitario,
          tb_docpago_detalle.dpd_mnto_descuento AS m_descuento,
          tb_docpago_detalle.dpd_mnto_base_sinigv AS subtotal,
          tb_doc_tipoafectacion.ta_codigo_nubefact AS tipoigv,
          tb_docpago_detalle.dpd_mnto_igv AS igv,
          tb_docpago_detalle.dpd_mnto_valor_venta AS total
        FROM
          tb_doc_tipoafectacion
          INNER JOIN tb_docpago_detalle ON (tb_doc_tipoafectacion.ta_codigo = tb_docpago_detalle.cod_tipoafc_igv)
          INNER JOIN tb_docpago ON (tb_docpago_detalle.cod_docpago = tb_docpago.dcp_id)
       WHERE tb_docpago.sede_id  = ? AND (tb_docpago.dcp_estado='PENDIENTE' OR tb_docpago.dcp_estado='ERROR')", $data);
    
        return $qry->result();

  }

  public function get_simple_docpagos_enviados($data) {
    $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id as coddoc,
          tb_doctipo.dt_codnubefact AS tipodoc,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS nro,
          tb_docpago.dcp_estado AS estado
        FROM
          tb_doctipo
          INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
        WHERE tb_docpago.sede_id  = ? AND tb_docpago.dcp_estado='ENVIADO'", $data);
    
        return $qry->result();

  }



  public function m_update_anular_docpago($data)
  {
    $this->db->query("CALL `sp_tb_docpago_update_anular`(?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row()->salida; 
  }
  public function m_update_estado_docpago($data)
  {
    $this->db->query("CALL `sp_tb_docpago_update_estado`(?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row()->salida; 
  }

  /* COBROS PASAR A OTRO MODEL */
  public function m_get_medios_pago()
  {
      $qry = $this->db->query("SELECT 
          tb_docpago_medio.dm_codigo AS codigo,
          tb_docpago_medio.dm_nombre AS nombre
        FROM
          tb_docpago_medio
        ORDER BY
          tb_docpago_medio.dm_nombre");
      
      return $qry->result();
  }

  public function m_get_bancos()
  {
      $qry = $this->db->query("SELECT 
          tb_banco.bn_codigo AS codigo,
          tb_banco.bn_nombre AS nombre
        FROM
          tb_banco
        ORDER BY
          tb_banco.bn_nombre");
      
      return $qry->result();
  }


  public function m_eliminar_documento($data)
  {
    $this->db->query("CALL `sp_tb_docpago_delete`(?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row();
  }
}
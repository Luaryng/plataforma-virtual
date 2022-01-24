<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfacturacion extends CI_Model {

	function __construct() {
           parent::__construct();
    }

    public function m_get_emitidos_index($data)
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
            tb_docpago_sunat.dcps_aceptado as s_aceptado,
            tb_docpago_sunat.dcps_snt_descripcion as s_descripcion,
            tb_docpago_sunat.dcps_snt_note as s_note,
            tb_docpago_sunat.dcps_snt_responsecode as s_response,
            tb_docpago_sunat.dcps_snt_soap_error as s_soap,
            tb_docpago_sunat.dcps_snt_enlace_xml enl_xml,
            tb_docpago_sunat.dcps_snt_enlace_cdr enl_cdr,
            tb_docpago_sunat.dcps_snt_enlace_pdf enl_pdf,
            tb_docpago_sunat.dcps_error_cod as error_cod,
            tb_docpago_sunat.dcps_error_desc as error_desc,
            tb_docpago.dcp_anulacion_motivo as anul_motivo,
            tb_docpago.dcp_fecha_anulacion as anul_fecha
          FROM
            tb_docpago_sunat
            INNER JOIN tb_docpago ON (tb_docpago_sunat.dcps_id = tb_docpago.dcp_id) 
          WHERE tb_docpago.sede_id=? 
          ORDER BY
            tb_docpago.dcp_fecha_hora DESC", $data);
        
        return $qry->result();
    }

    public function m_get_emitidos_filtro_xsede($sede,$pagante,$fechas)
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
            tb_docpago_sunat.dcps_aceptado as s_aceptado,
            tb_docpago_sunat.dcps_snt_descripcion as s_descripcion,
            tb_docpago_sunat.dcps_snt_note as s_note,
            tb_docpago_sunat.dcps_snt_responsecode as s_response,
            tb_docpago_sunat.dcps_snt_soap_error as s_soap,
            tb_docpago_sunat.dcps_snt_enlace_xml enl_xml,
            tb_docpago_sunat.dcps_snt_enlace_cdr enl_cdr,
            tb_docpago_sunat.dcps_snt_enlace_pdf enl_pdf,
            tb_docpago_sunat.dcps_error_cod as error_cod,
            tb_docpago_sunat.dcps_error_desc as error_desc,
            tb_docpago.dcp_anulacion_motivo as anul_motivo,
            tb_docpago.dcp_fecha_anulacion as anul_fecha
          FROM
            tb_docpago_sunat
            INNER JOIN tb_docpago ON (tb_docpago_sunat.dcps_id = tb_docpago.dcp_id) 
            WHERE tb_docpago.sede_id=? $sqltext 
            ORDER BY
              tb_docpago.dcp_fecha_hora DESC ", $data);
        
        return $qry->result();
    }


    

    public function m_get_items_gestion_habilitados()
    {
        $qry = $this->db->query("SELECT 
        tb_gestion.gt_codigo AS codigo,
        tb_gestion.gt_nombre AS gestion,
        tb_gestion.cod_tipoafectacion AS codtipafecta,
        tb_gestion.cod_unidad AS codunidad,
        tb_gestion.gt_facturar_como AS facturar_cod,
        tb_categoria.gt_nombre AS facturar_como,
        tb_gestion.gt_afectacion AS afecta 
      FROM
        tb_gestion
        INNER JOIN tb_gestion tb_categoria ON (tb_categoria.gt_codigo = tb_gestion.gt_facturar_como)
      WHERE
        tb_gestion.gt_categoria <> '00.00' AND 
        tb_categoria.gt_habilitado = 'SI'");
        
        return $qry->result();
    }

    public function m_get_unidades_habilitados()
    {
        $qry = $this->db->query("SELECT 
            tb_doc_unidades.un_codigo as codigo,
            tb_doc_unidades.un_descripcion as nombre
          FROM
            tb_doc_unidades
          WHERE
            tb_doc_unidades.un_habilitada = 'SI'");
        
        return $qry->result();
    }

    public function m_get_afectacion_habilitados()
    {
        $qry = $this->db->query("SELECT 
            tb_doc_tipoafectacion.ta_codigo as codigo,
            tb_doc_tipoafectacion.ta_descripcion as nombre,
            tb_doc_tipoafectacion.ta_info as info
          FROM
            tb_doc_tipoafectacion
          WHERE
            tb_doc_tipoafectacion.ta_habilitado = 'SI'");
        
        return $qry->result();
    }

    public function m_get_isc_habilitados()
    {
        $qry = $this->db->query("SELECT 
            tb_doc_isc.isc_codigo as codigo,
            tb_doc_isc.isc_descripcion as nombre
          FROM
            tb_doc_isc
          WHERE
            tb_doc_isc.isc_habilitado = 'SI'
          ORDER BY isc_codigo_sunat");
        
        return $qry->result();
    }

    public function m_get_tipo_operacion_xtipodoc_habilitados($data)
    {
        $qry = $this->db->query("SELECT 
          tb_doc_tipo_operacion51_tipodoc.cod_codtipo as codtipodoc,
          tb_doc_tipo_operacion_51.to_codigo as codopera51,
          tb_doc_tipo_operacion_51.to_descripcion as nombre
        FROM
          tb_doc_tipo_operacion51_tipodoc
          INNER JOIN tb_doc_tipo_operacion_51 ON (tb_doc_tipo_operacion51_tipodoc.cod_tipo_operacion51 = tb_doc_tipo_operacion_51.to_codigo)
        WHERE
          tb_doc_tipo_operacion_51.to_habilitado = 'SI' AND tb_doc_tipo_operacion51_tipodoc.cod_codtipo = ?",$data);
        
        return $qry->result();
    }


    public function m_get_tipo_identidad_habilitados()
    {
        $qry = $this->db->query("SELECT 
            tb_doc_identidad.ti_codigo AS codigo,
            tb_doc_identidad.ti_descripcion AS nombre,
            tb_doc_identidad.ti_longitud AS longitud,
            tb_doc_identidad.ti_docpermitidos AS docs_permitidos
          FROM
            tb_doc_identidad
          WHERE
            tb_doc_identidad.ti_habilitado = 'SI'
          ORDER BY
            tb_doc_identidad.ti_nroorden");
        
        return $qry->result();
    }
    
    



   /* public function m_get_itemdoc($data)
    {
        
        $qry = $this->db->query("SELECT 
                  `adp_id` as codigo,
                  `adp_titulo` as titulo,
                  `adp_descripcion` as descripcion,
                  `adp_ruta` as ruta,
                  `adp_peso` as peso,
                  `adp_tipo` as tipo,
                  `adp_emision` as emision,
                  `adp_importe` as importe,
                  `adp_creado` as creado,
                  `adp_estado` as estado
                FROM 
                  `tb_admin_doc_pago` 
                WHERE adp_id=? ",$data);
        
        return $qry->row();
    }*/

   

   
    

    /*public function m_get_docserie_boleta($data)
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
                WHERE tb_doctipo_sede.cod_doctipo = 'BL' AND tb_doctipo_sede.cod_sede = ?
                LIMIT 1", $data);
        
        return $qry->row();
    }*/

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




    

  public function m_insert_facturacion($data)
  {
    $this->db->query("CALL  `sp_tb_docpago_boleta_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid,@nrodoc)",$data);
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


  public function m_insert_facturacion_detalle($data)
  {
    $this->db->query("CALL `sp_tb_docpago_detalle_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }


  public function get_docpago($data) {
    $qry = $this->db->query("SELECT 
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
          tb_docpago.dcp_observacion AS obs
        FROM
          tb_doctipo
          INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
          INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
          INNER JOIN tb_pagante ON (tb_docpago.pagante_cod = tb_pagante.pg_codpagante)
        WHERE tb_docpago.dcp_id  = ?  LIMIT 1", $data);
    
        return $qry->row();

  }

  public function get_items_docpago($data) {
    $qry = $this->db->query("SELECT 
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
        WHERE tb_docpago_detalle.cod_docpago  = ? ", $data);
    
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

}
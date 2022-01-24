<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtipodoc_sede extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_tiposdoc()
    {
        $result = $this->db->query("SELECT 
          tb_doctipo_sede.cod_sede as idsede,
          tb_sede.sed_nombre as sede,
          tb_doctipo_sede.cod_doctipo as idtipo,
          tb_doctipo.dt_nombre as tipo,
          tb_doctipo_sede.dtse_ruc as ruc,
          tb_doctipo_sede.dtse_serie as serie,
          tb_doctipo_sede.dtse_contador_nro as contador,
          tb_doctipo_sede.dtse_codlocal_sunat as codsunat,
          tb_doctipo_sede.cod_tipo_operacion51 as tipopera,
          tb_doctipo_sede.dtse_igv_porcentaje as igv,
          tb_doctipo_sede.dtse_habilitado as estado
        FROM
          tb_doctipo_sede
          INNER JOIN tb_sede ON (tb_doctipo_sede.cod_sede = tb_sede.id_sede)
          INNER JOIN tb_doctipo ON (tb_doctipo_sede.cod_doctipo = tb_doctipo.dt_id)
        ORDER BY  tb_sede.sed_nombre ASC,tb_doctipo_sede.cod_doctipo ");

        return $result->result();
    }

    public function m_get_tiposdoc_xsede($data)
    {
        $result = $this->db->query("SELECT 
          tb_doctipo_sede.cod_sede as idsede,
          tb_sede.sed_nombre as sede,
          tb_doctipo_sede.cod_doctipo as idtipo,
          tb_doctipo.dt_nombre as tipo,
          tb_doctipo_sede.dtse_ruc as ruc,
          tb_doctipo_sede.dtse_serie as serie,
          tb_doctipo_sede.dtse_contador_nro as contador,
          tb_doctipo_sede.dtse_codlocal_sunat as codsunat,
          tb_doctipo_sede.cod_tipo_operacion51 as tipopera,
          tb_doctipo_sede.dtse_igv_porcentaje as igv,
          tb_doctipo_sede.dtse_habilitado as estado
        FROM
          tb_doctipo_sede
          INNER JOIN tb_sede ON (tb_doctipo_sede.cod_sede = tb_sede.id_sede)
          INNER JOIN tb_doctipo ON (tb_doctipo_sede.cod_doctipo = tb_doctipo.dt_id)
        WHERE  tb_doctipo_sede.cod_sede = ? 
        ORDER BY  tb_sede.sed_nombre ASC,tb_doctipo_sede.cod_doctipo",$data);

        return $result->result();
    }

    public function m_update_estado($data)
    {
      $qry = $this->db->query("UPDATE tb_doctipo_sede SET dtse_habilitado = ?  where cod_sede = ? AND cod_doctipo = ?", $data);
        
      return 1;
    }

    public function mInsert_doctipo_sede($items)
    {
        $this->db->query("CALL `sp_tb_doctipo_sede_insert`(?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }


    public function mUpdate_doctipo_sede($items)
    {
        $this->db->query("CALL `sp_tb_doctipo_sede_update`(?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }


    public function m_get_documentos_activas()
    {
        $result = $this->db->query("SELECT 
          tb_doctipo.dt_id as id,
          tb_doctipo.dt_nombre as nombre,
          tb_doctipo.dt_codsunat as codsunat,
          tb_doctipo.dt_nombre_impresion as nomimpres
        FROM
          tb_doctipo
        ORDER BY  tb_doctipo.dt_nombre ASC ");

        return $result->result();
    }

    public function m_get_tiposdoc_sede_tipo($data)
    {
        $result = $this->db->query("SELECT 
          tb_doctipo_sede.cod_sede as idsede,
          tb_sede.sed_nombre as sede,
          tb_doctipo_sede.cod_doctipo as idtipo,
          tb_doctipo.dt_nombre as tipo,
          tb_doctipo_sede.dtse_ruc as ruc,
          tb_doctipo_sede.dtse_serie as serie,
          tb_doctipo_sede.dtse_contador_nro as contador,
          tb_doctipo_sede.dtse_codlocal_sunat as codsunat,
          tb_doctipo_sede.cod_tipo_operacion51 as tipopera,
          tb_doctipo_sede.dtse_igv_porcentaje as igv,
          tb_doctipo_sede.dtse_habilitado as estado
        FROM
          tb_doctipo_sede
          INNER JOIN tb_sede ON (tb_doctipo_sede.cod_sede = tb_sede.id_sede)
          INNER JOIN tb_doctipo ON (tb_doctipo_sede.cod_doctipo = tb_doctipo.dt_id)
        WHERE tb_doctipo_sede.cod_sede = ? AND tb_doctipo_sede.cod_doctipo = ?
        LIMIT 1", $data);

        return $result->row();
    }



}


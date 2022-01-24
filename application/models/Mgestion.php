<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mgestion extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_gestion()
    {
        $result = $this->db->query("SELECT 
          tb_gestion.gt_codigo as codigo,
          tb_gestion.gt_nombre as nombre,
          tb_gestion.gt_categoria as categoria,
          tb_gestion.gt_importe as importe,
          tb_gestion.gt_facturar_como as fcomo,
          tb_gestion.cod_tipoafectacion as tipafec,
          tb_doc_tipoafectacion.ta_descripcion as nomtipafec,
          tb_gestion.gt_habilitado as estado,
          tb_gestion.cod_unidad as unidad,
          tb_doc_unidades.un_descripcion as undnombre,
          tb_gestion.gt_afectacion as afectacion
        FROM
          tb_gestion
          LEFT JOIN tb_doc_tipoafectacion ON (tb_gestion.cod_tipoafectacion = tb_doc_tipoafectacion.ta_codigo)
          LEFT JOIN tb_doc_unidades ON (tb_gestion.cod_unidad = tb_doc_unidades.un_codigo)
        ORDER BY tb_gestion.gt_codigo ASC");

        return $result->result();
    }

    public function m_get_solo_gestion_order_categoria()
    {
        $result = $this->db->query("SELECT 
          tb_gestion.gt_codigo AS codigo,
          tb_gestion.gt_nombre AS nombre,
          tb_gestion.gt_categoria AS codcategoria,
          tb_gestion.gt_importe AS importe,
          tb_gestion.gt_facturar_como AS fcomo,
          tb_gestion.cod_tipoafectacion AS tipafec,
          tb_gestion.gt_habilitado AS estado,
          tb_gestion.cod_unidad AS unidad,
          tb_gestion.gt_afectacion AS afectacion,
          tb_categoria.gt_nombre as categoria
        FROM
          tb_gestion tb_categoria
          INNER JOIN tb_gestion ON (tb_categoria.gt_codigo = tb_gestion.gt_categoria)
        ORDER BY
          tb_gestion.gt_categoria,
          tb_gestion.gt_nombre");

        return $result->result();
    }


    public function m_update_estado_gestion($data)
    {
      $qry = $this->db->query("UPDATE tb_gestion SET gt_habilitado = ?  where gt_codigo = ? ", $data);
        
      return 1;
    }

    public function mInsert_gestion($items)
    {
        $this->db->query("CALL `sp_tb_gestion_insert`(?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }


    public function mUpdate_gestion($items)
    {
        $this->db->query("CALL `sp_tb_gestion_update`(?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_get_tipo_afectacion()
    {
        $result = $this->db->query("SELECT 
          tb_doc_tipoafectacion.ta_codigo as id,
          tb_doc_tipoafectacion.ta_descripcion as nombre,
          tb_doc_tipoafectacion.ta_codigo_de_tributo as codtrib,
          tb_doc_tipoafectacion.ta_habilitado as estado
        FROM
          tb_doc_tipoafectacion
        WHERE tb_doc_tipoafectacion.ta_habilitado = 'SI'
        ORDER BY  tb_doc_tipoafectacion.ta_descripcion ASC ");

        return $result->result();
    }

    public function m_get_gestion_xcategorias($data)
    {
      $result = $this->db->query("SELECT 
          tb_gestion.gt_codigo as codigo,
          tb_gestion.gt_nombre as nombre,
          tb_gestion.gt_categoria as categoria,
          tb_gestion.gt_importe as importe,
          tb_gestion.gt_facturar_como as fcomo,
          tb_gestion.cod_tipoafectacion as tipafec,
          tb_doc_tipoafectacion.ta_descripcion as nomtipafec,
          tb_gestion.gt_habilitado as estado,
          tb_gestion.cod_unidad as unidad,
          tb_doc_unidades.un_descripcion as undnombre,
          tb_gestion.gt_afectacion as afectacion
        FROM
          tb_gestion
          LEFT JOIN tb_doc_tipoafectacion ON (tb_gestion.cod_tipoafectacion = tb_doc_tipoafectacion.ta_codigo)
          LEFT JOIN tb_doc_unidades ON (tb_gestion.cod_unidad = tb_doc_unidades.un_codigo)
        WHERE tb_gestion.gt_categoria = ? ORDER BY tb_gestion.gt_codigo ASC", $data);

        return $result->result();
    }
    
    public function m_get_unidades()
    {
        $result = $this->db->query("SELECT 
          tb_doc_unidades.un_codigo as id,
          tb_doc_unidades.un_descripcion as nombre,
          tb_doc_unidades.un_habilitada as codtrib
        FROM
          tb_doc_unidades
        WHERE tb_doc_unidades.un_habilitada = 'SI'
        ORDER BY  tb_doc_unidades.un_descripcion ASC ");

        return $result->result();
    }

    



    public function m_get_gestion_categorias()
    {
        $result = $this->db->query("SELECT 
          tb_gestion.gt_codigo as codigo,
          tb_gestion.gt_nombre as nombre
        FROM
          tb_gestion
        WHERE tb_gestion.gt_habilitado = 'SI' AND tb_gestion.gt_categoria = '00.00' ORDER BY tb_gestion.gt_categoria ASC");

        return $result->result();
    }

    public function m_get_gestionxestado()
    {
        $result = $this->db->query("SELECT 
          tb_gestion.gt_codigo as codigo,
          tb_gestion.gt_nombre as nombre,
          tb_gestion.gt_categoria as categoria,
          tb_gestion.gt_importe as importe,
          tb_gestion.gt_facturar_como as fcomo,
          tb_gestion.cod_tipoafectacion as tipafec,
          tb_doc_tipoafectacion.ta_descripcion as nomtipafec,
          tb_gestion.gt_habilitado as estado,
          tb_gestion.cod_unidad as unidad,
          tb_doc_unidades.un_descripcion as undnombre
        FROM
          tb_gestion
          LEFT JOIN tb_doc_tipoafectacion ON (tb_gestion.cod_tipoafectacion = tb_doc_tipoafectacion.ta_codigo)
          LEFT JOIN tb_doc_unidades ON (tb_gestion.cod_unidad = tb_doc_unidades.un_codigo)
          WHERE tb_gestion.gt_habilitado = 'SI'
        ORDER BY tb_gestion.gt_codigo ASC");

        return $result->result();
    }

     public function m_get_gestionxcodigo($data)
    {
        $result = $this->db->query("SELECT 
          tb_gestion.gt_codigo as codigo,
          tb_gestion.gt_nombre as nombre,
          tb_gestion.gt_categoria as categoria,
          tb_gestion.gt_importe as importe,
          tb_gestion.gt_facturar_como as fcomo,
          tb_gestion.cod_tipoafectacion as tipafec,
          tb_doc_tipoafectacion.ta_descripcion as nomtipafec,
          tb_gestion.gt_habilitado as estado,
          tb_gestion.cod_unidad as unidad,
          tb_doc_unidades.un_descripcion as undnombre,
          tb_gestion.gt_afectacion as afectacion
        FROM
          tb_gestion
          LEFT JOIN tb_doc_tipoafectacion ON (tb_gestion.cod_tipoafectacion = tb_doc_tipoafectacion.ta_codigo)
          LEFT JOIN tb_doc_unidades ON (tb_gestion.cod_unidad = tb_doc_unidades.un_codigo)
        WHERE tb_gestion.gt_codigo = ?
        LIMIT 1", $data);

        return $result->row();
    }

    public function m_get_gestion_codigo($data)
    {
        $result = $this->db->query("SELECT 
          tb_gestion.gt_codigo as codigo,
          tb_gestion.gt_nombre as nombre,
          tb_gestion.gt_categoria as categoria,
          tb_gestion.gt_importe as importe,
          tb_gestion.gt_facturar_como as fcomo,
          tb_gestion.cod_tipoafectacion as tipafec,
          tb_gestion.gt_habilitado as estado
        FROM
          tb_gestion
        WHERE tb_gestion.gt_codigo = ? LIMIT 1", $data);

        return $result->row();
    }

}


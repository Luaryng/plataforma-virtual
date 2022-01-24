<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mcategoria_transparencia extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_filtrar_categorias()
    {
        $result = $this->db->query("SELECT 
          tb_web_documentos_categoria.wdc_id  AS codigo,
          tb_web_documentos_categoria.wdc_nombre AS nombre,
          tb_web_documentos_categoria.wdc_activo AS activo,
          tb_web_documentos_categoria.wdc_orden AS orden,
          tb_web_documentos_categoria.wdc_tipo AS area
        FROM
          tb_web_documentos_categoria
        ORDER BY  tb_web_documentos_categoria.wdc_nombre ASC ");

        return $result->result();
    }

    public function m_filtrar_categorias_activasxtipo($data)
    {
        $result = $this->db->query("SELECT 
          tb_web_documentos_categoria.wdc_id  AS codigo,
          tb_web_documentos_categoria.wdc_nombre AS nombre,
          tb_web_documentos_categoria.wdc_activo AS activo,
          tb_web_documentos_categoria.wdc_orden AS orden,
          tb_web_documentos_categoria.wdc_tipo AS area
        FROM
          tb_web_documentos_categoria
          WHERE tb_web_documentos_categoria.wdc_activo = 'SI' AND tb_web_documentos_categoria.wdc_tipo = ?
        ORDER BY  tb_web_documentos_categoria.wdc_nombre ASC ", $data);

        return $result->result();
    }

    public function mInsert_categoria($items)
    {
        $this->db->query("CALL `sp_tb_web_documentos_categoria_insert`(?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }

    public function mUpdate_categoria($items)
    {
        $this->db->query("CALL `sp_tb_web_documentos_categoria_update`(?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_filtrar_categoriaxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_web_documentos_categoria.wdc_id  AS codigo,
          tb_web_documentos_categoria.wdc_nombre AS nombre,
          tb_web_documentos_categoria.wdc_activo AS activo,
          tb_web_documentos_categoria.wdc_orden AS orden,
          tb_web_documentos_categoria.wdc_tipo AS area
        FROM
          tb_web_documentos_categoria
        WHERE tb_web_documentos_categoria.wdc_id = ? LIMIT 1 ", $codigo);

        return $result->row();
    }

    public function m_eliminacategoria($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_web_documentos_categoria where wdc_id = ? ", $codigo);
        
        return 1;
    }


}


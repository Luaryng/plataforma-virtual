<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdeudas_calendario_fecha_item extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_items_cobro_x_fecha($data)
    {
        $result = $this->db->query("SELECT 
              tb_deuda_calendario_fecha_item.dcfi_codigo AS codigo,
              tb_deuda_calendario_fecha_item.codigo_calfecha AS codcal_fecha,
              tb_deuda_calendario_fecha_item.codigogestion AS codgestion,
              tb_deuda_calendario_fecha_item.dcfi_repite AS repite,
              tb_deuda_calendario_fecha_item.dcfi_monto AS monto,
              tb_gestion.gt_nombre AS gestion,
              tb_deuda_calendario_fecha.dcf_fecha as vence
            FROM
              tb_gestion
              INNER JOIN tb_deuda_calendario_fecha_item ON (tb_gestion.gt_codigo = tb_deuda_calendario_fecha_item.codigogestion)
              INNER JOIN tb_deuda_calendario_fecha ON (tb_deuda_calendario_fecha_item.codigo_calfecha = tb_deuda_calendario_fecha.dcf_codigo)
            WHERE tb_deuda_calendario_fecha_item.codigo_calfecha=? 
            ORDER BY
              tb_deuda_calendario_fecha_item.dcfi_codigo DESC",$data);

        return $result->result();
    }

    public function mInsert_deudas_calendario_item($items)
    {
        $this->db->query("CALL `sp_tb_deuda_calendario_fecha_item_insert`(?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();    
    }

    public function mUpdate_deudas_calendario_item($items)
    {
        $this->db->query("CALL `sp_tb_deuda_calendario_fecha_item_update`(?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return   $res->row();    
    }

    public function mDelete_deudas_calendario_item($codigo)
    {
        
        $this->db->query("CALL `sp_tb_deuda_calendario_fecha_item_delete`(?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return   $res->row(); 
    }


}


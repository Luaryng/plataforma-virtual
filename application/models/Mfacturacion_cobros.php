<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfacturacion_cobros extends CI_Model {

	function __construct() {
           parent::__construct();
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

  public function m_guardar_cobro($data)
  {
    $this->db->query("CALL `sp_tb_docpago_cobros_insert`(?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row()->salida; 
  }

  public function m_get_cobros($data)
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
          tb_docpago_cobros.dcp_nro_operacion AS voucher,
          tb_docpago_cobros.dcp_fecha_operacion AS fechaoper
        FROM
          tb_docpago_cobros
          INNER JOIN tb_docpago_medio ON (tb_docpago_cobros.medio_cod = tb_docpago_medio.dm_codigo)
          LEFT JOIN tb_banco ON (tb_docpago_cobros.banco_cod = tb_banco.bn_codigo)
        WHERE tb_docpago_cobros.docpago_cod = ?
        ORDER BY
          tb_docpago_cobros.dpc_id ASC", $data);
      
      return $qry->result();
  }

  public function m_get_mediopago_xnombre($data)
  {
      $qry = $this->db->query("SELECT 
          tb_docpago_medio.dm_codigo AS codigo,
          tb_docpago_medio.dm_nombre AS nombre
        FROM
          tb_docpago_medio
        WHERE tb_docpago_medio.dm_nombre = ?
        LIMIT 1", $data);
      
      return $qry->row();
  }

  public function m_eliminar_cobro($data)
  {
    $this->db->query("CALL `sp_tb_docpago_cobros_delete`(?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row()->salida;
  }
}
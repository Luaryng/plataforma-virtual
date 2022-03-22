<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mdeudas_calendario_fecha extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //POR JANIOR
    public function m_get_fechas_xcalendario($data)
    {
          $result = $this->db->query("SELECT 
            tb_deuda_calendario_fecha.dcf_codigo as codigo,
            tb_deuda_calendario_fecha.dcf_descripcion as descripcion,
            tb_deuda_calendario_fecha.dcf_fecha as fecha,
            tb_deuda_calendario_fecha.cod_calendario as calendario
          FROM
            tb_deuda_calendario_fecha
          WHERE
            tb_deuda_calendario_fecha.cod_calendario = ?
          ORDER BY
            tb_deuda_calendario_fecha.dcf_fecha",$data);
        return $result->result();
    }


  public function m_guardar($data){
        //CALL `sp_tb_deuda_calendario_insert`( @vdc_nombre, @vdc_fec_inicia, @vdc_fec_culmina, @s, @nid);
    $this->db->query("CALL `sp_tb_deuda_calendario_fecha_insert`(?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    //$this->db->close(); 
    return   $res->row();
  }

  public function m_update_fecha($data){
        //CALL `sp_tb_deuda_calendario_insert`( @vdc_nombre, @vdc_fec_inicia, @vdc_fec_culmina, @s, @nid);
    $this->db->query("CALL `sp_tb_deuda_calendario_fecha_update`(?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    //$this->db->close(); 
    return   $res->row();
  }
}
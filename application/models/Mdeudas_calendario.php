<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mdeudas_calendario extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //POR JANIOR
    public function m_get_calendarios_xperiodo_sede($data)
    {
          $result = $this->db->query("SELECT 
              tb_deuda_calendario.dc_codigo AS codigo,
              tb_deuda_calendario.dc_nombre AS nombre,
              tb_deuda_calendario.dc_fec_inicia AS inicia,
              tb_deuda_calendario.dc_fec_culmina AS culmina,
              tb_deuda_calendario.cod_periodo AS codperiodo,
              tb_periodo.ped_nombre AS periodo,
              tb_periodo.ped_estado AS estado,
              tb_deuda_calendario.cod_sede as codsede,
              tb_sede.sed_nombre as sede
            FROM
              tb_periodo
              INNER JOIN tb_deuda_calendario ON (tb_periodo.ped_codigo = tb_deuda_calendario.cod_periodo)
              INNER JOIN tb_sede ON (tb_deuda_calendario.cod_sede = tb_sede.id_sede)
            WHERE
              tb_deuda_calendario.cod_periodo = ? and tb_deuda_calendario.cod_sede=?",$data);
        return $result->result();
    }


  public function m_guardar($data){
        //CALL `sp_tb_deuda_calendario_insert`( @vdc_nombre, @vdc_fec_inicia, @vdc_fec_culmina, @s, @nid);
    $this->db->query("CALL `sp_tb_deuda_calendario_insert`(?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    //$this->db->close(); 
    return   $res->row();
  }

  
}
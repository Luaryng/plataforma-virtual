<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mdeudas_calendario_grupo extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //POR JANIOR
    public function m_get_grupos_xcalendario($data)
    {
          $result = $this->db->query("SELECT 
            tb_deuda_calendario_grupoacad.cga_id as codigo,
            tb_deuda_calendario_grupoacad.codigoperiodo as periodo,
            tb_periodo.ped_nombre as nomperiodo,
            tb_deuda_calendario_grupoacad.codigocarrera as carrera,
            tb_carrera.car_abreviatura as nomcarrera,
            tb_deuda_calendario_grupoacad.codigociclo as ciclo,
            tb_ciclo.cic_nombre as nomciclo,
            tb_deuda_calendario_grupoacad.codigoturno as turno,
            tb_turno.tur_nombre as nomturno,
            tb_deuda_calendario_grupoacad.codigoseccion as seccion,
            tb_seccion.sec_nombre as nomseccion,
            tb_deuda_calendario_grupoacad.cod_deuda_calendario as dcalendarioid
          FROM
            tb_deuda_calendario_grupoacad
            INNER JOIN tb_periodo ON (tb_deuda_calendario_grupoacad.codigoperiodo = tb_periodo.ped_codigo)
            INNER JOIN tb_carrera ON (tb_deuda_calendario_grupoacad.codigocarrera = tb_carrera.car_id)
            INNER JOIN tb_ciclo ON (tb_deuda_calendario_grupoacad.codigociclo = tb_ciclo.cic_codigo)
            INNER JOIN tb_turno ON (tb_deuda_calendario_grupoacad.codigoturno = tb_turno.tur_codigo)
            INNER JOIN tb_seccion ON (tb_deuda_calendario_grupoacad.codigoseccion = tb_seccion.sec_codigo)
          WHERE
            tb_deuda_calendario_grupoacad.cod_deuda_calendario = ?
          ORDER BY
            tb_deuda_calendario_grupoacad.codigocarrera,tb_deuda_calendario_grupoacad.codigociclo",$data);
        return $result->result();
    }

  public function m_deuda_xgrupo_calendario($data)
    {
      $codsede=$_SESSION['userActivo']->idsede;
      $resultmiembro = $this->db->query("
        SELECT  tb_matricula.mtr_id AS codmatricula,
          tb_matricula.codigoinscripcion AS codinscripcion,
          tb_matricula.codigoperiodo AS codperiodo,
          tb_matricula.codigocarrera AS codcarrera,
          tb_matricula.codigociclo AS codciclo,
          tb_matricula.codigoturno AS codturno,
          tb_matricula.codigoseccion AS codseccion,
          tb_matricula.codigoplan AS codplan,
          tb_matricula.mtr_bloquear_evaluaciones AS bloqueo,
          tb_matricula.mtr_cuotapension AS cuota,
          tb_matricula.codigobeneficio AS codbeneficio,
          tb_deuda_individual.di_codigo as coddeuda,
          tb_deuda_individual.cal_fecha_item_cod as codfecha_item,
          tb_deuda_individual.cod_gestion as codgestion,
          tb_deuda_individual.di_saldo as saldo,
          tb_deuda_individual.di_monto as monto 
        FROM
          tb_matricula
          LEFT OUTER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
        WHERE 
          tb_matricula.codigosede = $codsede AND tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND 
          tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
          tb_matricula.codigoseccion LIKE ?  AND (tb_deuda_individual.voucher_cod IS NULL OR tb_deuda_individual.voucher_cod=?)", $data);
        return $resultmiembro->result();
    }



  public function m_guardar($data){
        //CALL `sp_tb_deuda_calendario_insert`( @vdc_nombre, @vdc_fec_inicia, @vdc_fec_culmina, @s, @nid);
    $this->db->query("CALL `sp_tb_deuda_calendario_grupoacad_insert`(?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    //$this->db->close(); 
    return   $res->row();
  }
}
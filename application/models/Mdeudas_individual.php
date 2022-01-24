<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mdeudas_individual extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //POR JANIOR
    public function m_get_filtrar_pagante($data)
    {
      $result = $this->db->query("SELECT 
                tb_matricula.mtr_id as idmat,
                tb_inscripcion.ins_carnet as carne,
                tb_persona.per_apel_paterno as apepaterno,
                tb_persona.per_apel_materno as apematerno,
                tb_persona.per_nombres as nombre,
                tb_persona.per_dni as dni
              FROM
                tb_persona
                INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
              WHERE
                tb_matricula.codigoperiodo LIKE ? AND tb_matricula.codigocarrera LIKE ? 
                AND tb_matricula.codigoturno LIKE ? AND tb_matricula.codigociclo LIKE ?
                AND tb_matricula.codigoseccion LIKE ? AND
                CONCAT(tb_persona.per_dni,' ',tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno ,' ',tb_persona.per_nombres) LIKE ? ",$data);
        return $result->result();
    }


  public function m_guardar_deuda($data){
        
    $this->db->query("CALL `sp_tb_deuda_individual_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    //$this->db->close(); 
    return   $res->row();
  }

  public function m_get_historial_pagante($data)
  {
    $sqltext_array=array();
      $data_array=array();
      if ($data[0]!="%") {
        $sqltext_array[]="tb_matricula.codigoperiodo = ?";
        $data_array[]=$data[0];
      } 
      if ($data[1]!="%") {
        $sqltext_array[]="tb_matricula.codigocarrera = ?";
        $data_array[]=$data[1];
      } 
      if ($data[2]!="%")  {
        $sqltext_array[]="tb_matricula.codigoturno = ?";
        $data_array[]=$data[2];
      }
      if ($data[3]!="%")  {
        $sqltext_array[]="tb_matricula.codigociclo = ?";
        $data_array[]=$data[3];
      }
      if ($data[4]!="%")  {
        $sqltext_array[]="tb_matricula.codigoseccion = ?";
        $data_array[]=$data[4];
      }
      if ($data[5]!="%%")  {
        $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ?";
        $data_array[]=$data[5];
      }
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

      $result = $this->db->query("SELECT 
                tb_deuda_individual.di_codigo AS codigo,
                tb_persona.per_dni AS dni,
                tb_inscripcion.ins_carnet as carnet,
                tb_persona.per_apel_paterno as paterno,
                tb_persona.per_apel_materno as materno,
                tb_persona.per_nombres AS nombres,
                tb_deuda_individual.di_monto AS monto,
                tb_deuda_individual.di_fecha_vencimiento AS fvence,
                tb_deuda_individual.di_saldo AS saldo,
                tb_deuda_individual.di_estado AS estado,
                tb_carrera.car_nombre AS carrera,
                tb_ciclo.cic_nombre AS ciclo,
                tb_deuda_individual.cod_gestion as codgestion,
                tb_gestion.gt_nombre as gestion,
                tb_matricula.codigoperiodo as codperiodo,
                tb_carrera.car_sigla as sigla
              FROM
                tb_matricula
                INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
                INNER JOIN tb_inscripcion ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
                INNER JOIN tb_persona ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
                INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
                INNER JOIN tb_gestion ON (tb_deuda_individual.cod_gestion = tb_gestion.gt_codigo)
              $sqltext
              ORDER BY tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres,tb_deuda_individual.di_fecha_vencimiento DESC",$data_array);
        return $result->result();
  }

    public function m_get_deuda_activa_xpagante($data)
    {
      $result = $this->db->query("SELECT 
            tb_deuda_individual.di_codigo AS codigo,
            tb_deuda_individual.pagante_cod AS codpagante,
            tb_deuda_individual.matricula_cod AS codmatricula,
            tb_deuda_individual.cod_gestion AS codgestion,
            tb_gestion.gt_nombre AS gestion,
            tb_deuda_individual.di_monto AS monto,
            tb_deuda_individual.di_fecha_vencimiento AS vence,
            tb_deuda_individual.di_mora AS mora,
            tb_deuda_individual.di_fecha_prorroga AS prorroga,
            tb_deuda_individual.di_saldo AS saldo,
            tb_matricula.codigoperiodo codperiodo,
            tb_matricula.codigociclo as codciclo
          FROM
            tb_gestion
            INNER JOIN tb_deuda_individual ON (tb_gestion.gt_codigo = tb_deuda_individual.cod_gestion)
            INNER JOIN tb_matricula ON (tb_deuda_individual.matricula_cod = tb_matricula.mtr_id)
        WHERE tb_deuda_individual.pagante_cod=? AND tb_deuda_individual.di_saldo>0 AND tb_deuda_individual.di_estado='ACTIVO'",$data);
        return $result->result();
    }



    public function m_cambiar_estado_deuda($data)
    {
      $this->db->query("CALL `sp_tb_deuda_individual_update_estado`(?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function m_anula_deuda_individual($data)
    {
      $this->db->query("CALL `sp_tb_deuda_individual_update_anulado`(?,?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function m_cambiar_deuda_a_pago($data)
    {
      $this->db->query("CALL `sp_tb_deuda_individual_update_asigna_pago`(?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function m_desvincular_deuda_a_pago($data)
    {
      $this->db->query("CALL `sp_tb_deuda_individual_update_desvincula_pago`(?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }
    
    

    public function m_eliminar_deuda($data){   
      $this->db->query("CALL `sp_tb_deuda_individual_delete`(?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function m_deudas_xgrupo_matriculado($data,$vencido="NO")
    {
      $sqltext_vencido="";
      if ($vencido=="SI"){
        $sqltext_vencido=" AND   tb_deuda_individual.di_fecha_vencimiento < CURDATE() ";
      }
      $result = $this->db->query("SELECT 
          tb_inscripcion.ins_carnet AS carne,
          tb_matricula.mtr_apel_paterno AS paterno,
          tb_matricula.mtr_apel_materno AS materno,
          tb_matricula.mtr_nombres AS nombres,
          tb_matricula.codigoperiodo AS codperiodo,
          tb_matricula.codigocarrera AS codcarrera,
          tb_matricula.codigociclo AS codciclo,
          tb_matricula.codigoturno AS codturno,
          tb_matricula.codigoseccion AS codseccion,
          SUM(CASE WHEN tb_deuda_individual.cod_gestion = '02.01' THEN tb_deuda_individual.di_saldo ELSE 0 END) AS cuota1,
          SUM(CASE WHEN tb_deuda_individual.cod_gestion = '02.02' THEN tb_deuda_individual.di_saldo ELSE 0 END) AS cuota2,
          SUM(CASE WHEN tb_deuda_individual.cod_gestion = '02.03' THEN tb_deuda_individual.di_saldo ELSE 0 END) AS cuota3,
          SUM(CASE WHEN tb_deuda_individual.cod_gestion = '02.04' THEN tb_deuda_individual.di_saldo ELSE 0 END) AS cuota4,
          SUM(CASE WHEN tb_deuda_individual.cod_gestion = '02.05' THEN tb_deuda_individual.di_saldo ELSE 0 END) AS cuota5,
          tb_periodo.ped_nombre AS periodo,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_nombre AS carrera,
          tb_ciclo.cic_nombre AS ciclo,
          tb_turno.tur_nombre AS turno
        FROM
          tb_inscripcion
          INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
          INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
          INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)

        WHERE
              tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND 
                tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
              tb_matricula.codigoseccion LIKE ? AND  tb_deuda_individual.di_saldo>0 AND tb_deuda_individual.di_estado='ACTIVO' 
             $sqltext_vencido 
             GROUP BY
          tb_inscripcion.ins_carnet,
          tb_matricula.mtr_apel_paterno,
          tb_matricula.mtr_apel_materno,
          tb_matricula.mtr_nombres,
          tb_matricula.codigoperiodo,
          tb_matricula.codigocarrera,
          tb_matricula.codigociclo,
          tb_matricula.codigoturno,
          tb_matricula.codigoseccion,
          tb_periodo.ped_nombre,
          tb_carrera.car_nombre,
          tb_carrera.car_nombre,
          tb_ciclo.cic_nombre,
          tb_turno.tur_nombre
          order by tb_matricula.codigoperiodo,
          tb_matricula.codigocarrera,
          tb_matricula.codigociclo,
          tb_matricula.codigoturno,
          tb_matricula.codigoseccion,tb_matricula.mtr_apel_paterno,
          tb_matricula.mtr_apel_materno,
          tb_matricula.mtr_nombres",$data);
        return $result->result();
    }

    public function m_get_historial_deudas_carnet($data)
    {
      $result = $this->db->query("SELECT 
                tb_deuda_individual.di_codigo AS codigo,
                tb_persona.per_dni AS dni,
                tb_inscripcion.ins_carnet as carnet,
                tb_persona.per_apel_paterno as paterno,
                tb_persona.per_apel_materno as materno,
                tb_persona.per_nombres AS nombres,
                tb_deuda_individual.di_monto AS monto,
                tb_deuda_individual.di_fecha_vencimiento AS fvence,
                tb_deuda_individual.di_saldo AS saldo,
                tb_deuda_individual.di_estado AS estado,
                tb_carrera.car_nombre AS carrera,
                tb_ciclo.cic_nombre AS ciclo,
                tb_deuda_individual.cod_gestion as codgestion,
                tb_gestion.gt_nombre as gestion,
                tb_matricula.codigoperiodo as codperiodo,
                tb_carrera.car_sigla as sigla
              FROM
                tb_matricula
                INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
                INNER JOIN tb_inscripcion ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
                INNER JOIN tb_persona ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
                INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
                INNER JOIN tb_gestion ON (tb_deuda_individual.cod_gestion = tb_gestion.gt_codigo)
              WHERE
                tb_deuda_individual.pagante_cod = ?
              ORDER BY tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres,tb_deuda_individual.di_fecha_vencimiento DESC",$data);
        return $result->result();
    }


}
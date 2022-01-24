<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mprematricula extends CI_Model {

	function __construct() {
           parent::__construct();
           $this->load->helper("url");          
    }

    public function m_get_periodosxestado()
    {
        $result = $this->db->query("SELECT 
              `ped_codigo` as codigo,
              `ped_nombre` as nombre,
              `ped_anio` as anio
            FROM 
              `tb_periodo` WHERE `ped_estado`='ACTIVO' LIMIT 1;");
        return $result->row();
    }

    public function insert_datos_prematricula($data){

        $this->db->query("CALL `sp_tb_pre_inscripcion_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return $res->row();    
    }

    public function update_datos_prematricula($data){

        $this->db->query("CALL `sp_tb_pre_inscripcion_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return $res->row();    
    }

    public function insert_archivos($data){
      
      //CALL `sp_tb_pre_inscripcion_archivos_insert`( @vinc_id, @vincp_titulo, @vincp_link, @vincp_archivo, @vincp_peso, @vincp_tipo, @s);
        $this->db->query("CALL `sp_tb_pre_inscripcion_archivos_insert`(?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return $res->row();    
    }

    /*public function m_dtsPreinscripcion($data)
    {
      $result = $this->db->query("SELECT 
            tb_pre_inscripcion.preins_id id,
            tb_pre_inscripcion.preins_apepat ape_paterno,
            tb_pre_inscripcion.preins_apemat ape_materno,
            tb_pre_inscripcion.preins_nombres nombres,
            tb_pre_inscripcion.preins_documento documento,
            tb_pre_inscripcion.preins_telefono telefono,
            tb_pre_inscripcion.preins_correo correo,
            tb_pre_inscripcion.car_id carid,
            tb_carrera.car_nombre carrera,
            tb_pre_inscripcion.id_sede sedeid,
            tb_pre_inscripcion.ped_codigo perid,
            tb_periodo.ped_nombre periodo,
            tb_pre_inscripcion.preins_fecha fecha
          FROM
            tb_pre_inscripcion
          INNER JOIN tb_carrera ON (tb_pre_inscripcion.car_id = tb_carrera.car_id) 
          INNER JOIN tb_periodo ON (tb_pre_inscripcion.ped_codigo = tb_periodo.ped_codigo) 
          WHERE concat(tb_pre_inscripcion.preins_apepat,' ',tb_pre_inscripcion.preins_apemat,' ',tb_pre_inscripcion.preins_nombres) LIKE ? AND tb_pre_inscripcion.car_id LIKE ? AND tb_pre_inscripcion.ped_codigo LIKE ? ORDER BY preins_id ASC", $data);
        return $result->result();
    }*/

    public function m_dtsPreinscripcionxfechas($data)
    {
      $sqlfecha="";
      if (count($data)>5){
        $sqlfecha=" AND tb_pre_inscripcion.preins_fecha BETWEEN ? AND ?";
      }
      $idsede = $_SESSION['userActivo']->idsede;
      $result = $this->db->query("SELECT 
            tb_pre_inscripcion.preins_id id,
            tb_pre_inscripcion.preins_apepat ape_paterno,
            tb_pre_inscripcion.preins_apemat ape_materno,
            tb_pre_inscripcion.preins_nombres nombres,
            tb_pre_inscripcion.preins_tipdoc as tipodoc,
            tb_pre_inscripcion.preins_documento documento,
            tb_pre_inscripcion.preins_telefono telefono,
            tb_pre_inscripcion.preins_correo correo,
            tb_pre_inscripcion.car_id carid,
            tb_carrera.car_nombre carrera,
            tb_pre_inscripcion.id_sede sedeid,
            tb_sede.sed_nombre sedenom,
            tb_pre_inscripcion.ped_codigo perid,
            tb_periodo.ped_nombre periodo,
            tb_pre_inscripcion.preins_fecha fecha,
            tb_pre_inscripcion.preins_estado estado,
            tb_pre_inscripcion.preins_tipo tipo,
            tb_pre_inscripcion.preins_fechanac as fechanac 
          FROM
            tb_pre_inscripcion
          INNER JOIN tb_carrera ON (tb_pre_inscripcion.car_id = tb_carrera.car_id) 
          INNER JOIN tb_periodo ON (tb_pre_inscripcion.ped_codigo = tb_periodo.ped_codigo) 
          INNER JOIN tb_sede ON (tb_pre_inscripcion.id_sede = tb_sede.id_sede ) 
          WHERE concat(tb_pre_inscripcion.preins_apepat,' ',tb_pre_inscripcion.preins_apemat,' ',tb_pre_inscripcion.preins_nombres) LIKE ? AND tb_pre_inscripcion.car_id LIKE ? AND tb_pre_inscripcion.ped_codigo LIKE ? AND tb_pre_inscripcion.preins_tipo LIKE ? AND tb_pre_inscripcion.preins_estado LIKE ? $sqlfecha AND tb_pre_inscripcion.id_sede = $idsede ORDER BY preins_id desc ", $data);
        return $result->result();
    }

  public function m_filtrar_seguimiento($codigo)
  {
      $result = $this->db->query("SELECT 
        tb_pre_inscripcion_detalle.dpreins_id AS codigo,
        tb_pre_inscripcion_detalle.preins_id AS idpre,
        tb_pre_inscripcion_detalle.dpreins_estado AS estado,
        tb_pre_inscripcion_detalle.dpreins_observacion AS observacion,
        tb_pre_inscripcion_detalle.dpreins_fecha AS fecha,
        tb_pre_inscripcion_detalle.dpreins_hora AS hora,
        tb_pre_inscripcion_detalle.dpreins_creado AS creado
      FROM
        tb_pre_inscripcion_detalle
        WHERE tb_pre_inscripcion_detalle.preins_id = ?
      ORDER BY  tb_pre_inscripcion_detalle.dpreins_creado DESC ", $codigo);

      return $result->result();
  }



  public function m_insert_seguimiento($data)
  {
    $this->db->query("CALL `sp_tb_pre_inscripcion_detalle_insert`(?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }

  public function delete_preinscripcion($data)
  {
    $this->db->query("CALL `sp_tb_pre_inscripcion_delete`(?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }

  public function m_get_ficha_preinscripcion($codigo)
  {
        $result = $this->db->query("SELECT 
        tb_pre_inscripcion.preins_id AS codpre,
        tb_pre_inscripcion.preins_apepat AS paterno,
        tb_pre_inscripcion.preins_apemat AS materno,
        tb_pre_inscripcion.preins_nombres AS nombres,
        tb_pre_inscripcion.preins_tipdoc AS tipodoc,
        tb_pre_inscripcion.preins_documento AS numero,
        tb_pre_inscripcion.preins_fechanac AS fecnac,
        tb_pre_inscripcion.preins_lugarnac AS lugnac,
        tb_pre_inscripcion.cic_codigo AS ciclo,
        tb_pre_inscripcion.preins_sexo AS sexo,
        tb_pre_inscripcion.preins_estado_civil AS estcivil,
        tb_pre_inscripcion.preins_telefono AS telefono,
        tb_pre_inscripcion.preins_correo AS correo,
        tb_pre_inscripcion.car_id AS codcarrera,
        tb_pre_inscripcion.id_sede as sede,
        tb_pre_inscripcion.ped_codigo AS codperiodo,
        tb_pre_inscripcion.mod_id AS codmodalidad,
        tb_pre_inscripcion.tur_id AS codturno,
        tb_pre_inscripcion.preins_cod_distrito as coddistrito,
        tb_pre_inscripcion.preins_distrito AS distrito,
        tb_pre_inscripcion.preins_direccion AS direccion,
        tb_pre_inscripcion.preins_centro_est_anterior AS centro,
        tb_pre_inscripcion.preins_instituto_traslado AS instituto,
        tb_pre_inscripcion.preins_trabaja AS trabaja,
        tb_pre_inscripcion.preins_lugar_trabaja AS lugtrabaja,
        tb_pre_inscripcion.preins_estado AS estado,
        tb_pre_inscripcion.preins_tipo AS tipo,
        tb_pre_inscripcion.preins_fecha AS fecha,
        tb_pre_inscripcion.preins_cod_distrito,
        tb_provincia.prv_codigo AS codprovincia,
        tb_departamento.dep_codigo AS codepartamento,
        tb_distrito.dis_nombre AS nomdistrito,
        tb_provincia.prv_nombre AS provincia,
        tb_departamento.dep_nombre AS departamento,
        tb_pre_inscripcion.preins_apenom_padre AS nompadre,
        tb_pre_inscripcion.preins_ocupacion_padre AS ocuppadre,
        tb_pre_inscripcion.preins_apenom_madre AS nommadre,
        tb_pre_inscripcion.preins_ocupacion_madre AS ocupmadre,
        tb_turno.tur_nombre AS turno,
        tb_modalidad.mod_nombre AS modalidad,
        tb_periodo.ped_nombre AS periodo,
        tb_periodo.ped_anio as anio,
        tb_carrera.car_nombre as carrera,
        tb_pre_inscripcion.preins_discapacidad as discapacidad,
        tb_pre_inscripcion.preins_detalle_discapacidad as nomdiscapacidad,
        tb_pre_inscripcion.preins_anio_secundaria as aniosecundaria,
        tb_pre_inscripcion.preins_lengua_originaria as lenguaorig,
        tb_pre_inscripcion.preins_publicidad as publicidad

      FROM
        tb_modalidad
        RIGHT OUTER JOIN tb_pre_inscripcion ON (tb_modalidad.mod_id = tb_pre_inscripcion.mod_id)
        LEFT OUTER JOIN tb_periodo ON (tb_pre_inscripcion.ped_codigo = tb_periodo.ped_codigo)
        LEFT OUTER JOIN tb_turno ON (tb_pre_inscripcion.tur_id = tb_turno.tur_codigo)
        INNER JOIN tb_carrera ON (tb_pre_inscripcion.car_id = tb_carrera.car_id)
        LEFT OUTER JOIN tb_distrito ON (tb_pre_inscripcion.preins_cod_distrito = tb_distrito.dis_codigo)
        LEFT OUTER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        LEFT OUTER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
              WHERE tb_pre_inscripcion.preins_id = ? limit 1", $codigo);

      $arr_result['ficha']= $result->row();

        $result = $this->db->query("SELECT 
        tb_pre_inscripcion_archivos.piar_id as codigo,
        tb_pre_inscripcion_archivos.prei_id as codpreins,
        tb_pre_inscripcion_archivos.piar_titulo as titulo,
        tb_pre_inscripcion_archivos.piar_archivo as archivo,
        tb_pre_inscripcion_archivos.piar_peso as peso,
        tb_pre_inscripcion_archivos.piar_tipo as tipo,
        tb_pre_inscripcion_archivos.piar_fecha_creado as creado,
        tb_pre_inscripcion_archivos.piar_link as link
      FROM
        tb_pre_inscripcion_archivos
        WHERE tb_pre_inscripcion_archivos.prei_id = ?", $codigo);

      $arr_result['adjuntos']= $result->result();
      return $arr_result;
  }

  public function m_get_preinscripcion($codigo)
  {
        $result = $this->db->query("SELECT 
        tb_pre_inscripcion.preins_id AS codpre,
        tb_pre_inscripcion.preins_apepat AS paterno,
        tb_pre_inscripcion.preins_apemat AS materno,
        tb_pre_inscripcion.preins_nombres AS nombres,
        tb_pre_inscripcion.preins_tipdoc AS tipodoc,
        tb_pre_inscripcion.preins_documento AS numero,
        tb_pre_inscripcion.preins_fechanac AS fecnac,
        tb_pre_inscripcion.preins_lugarnac AS lugnac,
        
        tb_pre_inscripcion.preins_sexo AS sexo,
        tb_pre_inscripcion.preins_telefono AS telefono,
        tb_pre_inscripcion.preins_correo AS correo,
        tb_pre_inscripcion.car_id AS codcarrera,
        tb_pre_inscripcion.id_sede,
        tb_pre_inscripcion.ped_codigo AS codperiodo,
        tb_pre_inscripcion.mod_id AS codmodalidad,
        tb_pre_inscripcion.tur_id AS codturno,
        tb_pre_inscripcion.preins_cod_distrito as coddistrito,
        tb_pre_inscripcion.preins_distrito AS distrito,
        tb_pre_inscripcion.preins_direccion AS direccion,
        tb_pre_inscripcion.preins_centro_est_anterior AS centro,
        tb_pre_inscripcion.preins_instituto_traslado AS instituto,
        tb_pre_inscripcion.preins_trabaja AS trabaja,
        tb_pre_inscripcion.preins_estado AS estado,
        tb_pre_inscripcion.preins_tipo AS tipo,
        tb_pre_inscripcion.preins_fecha AS fecha,
        tb_pre_inscripcion.preins_cod_distrito,
        tb_pre_inscripcion.preins_apenom_padre as padre,
        tb_pre_inscripcion.preins_ocupacion_padre as ocupapadre,
        tb_pre_inscripcion.preins_apenom_madre as madre,
        tb_pre_inscripcion.preins_ocupacion_madre as ocupamadre,
        tb_pre_inscripcion.preins_estado_civil as estcivil,
        tb_turno.tur_nombre AS turno,
        tb_pre_inscripcion.cic_codigo AS codciclo,
        tb_modalidad.mod_nombre AS modalidad,
        tb_periodo.ped_nombre AS periodo,
        tb_carrera.car_nombre as carrera,
        tb_carrera.car_sigla as sigla,
        tb_pre_inscripcion.preins_discapacidad as discapacidad,
        tb_pre_inscripcion.preins_detalle_discapacidad as nomdiscapacidad,
        tb_pre_inscripcion.preins_anio_secundaria as aniosecundaria,
        tb_pre_inscripcion.preins_lengua_originaria as lenguaorig,
        tb_pre_inscripcion.preins_publicidad as publicidad

      FROM
        tb_modalidad
        RIGHT OUTER JOIN tb_pre_inscripcion ON (tb_modalidad.mod_id = tb_pre_inscripcion.mod_id)
        LEFT OUTER JOIN tb_periodo ON (tb_pre_inscripcion.ped_codigo = tb_periodo.ped_codigo)
        LEFT OUTER JOIN tb_turno ON (tb_pre_inscripcion.tur_id = tb_turno.tur_codigo)
        INNER JOIN tb_carrera ON (tb_pre_inscripcion.car_id = tb_carrera.car_id)
              WHERE tb_pre_inscripcion.preins_id = ? limit 1", $codigo);

      return $result->row();
  }

   public function m_archivos_adjuntos($codigo)
  {
      $result = $this->db->query("SELECT 
        tb_pre_inscripcion_archivos.piar_id as codigo,
        tb_pre_inscripcion_archivos.prei_id as codpreins,
        tb_pre_inscripcion_archivos.piar_titulo as titulo,
        tb_pre_inscripcion_archivos.piar_archivo as archivo,
        tb_pre_inscripcion_archivos.piar_peso as peso,
        tb_pre_inscripcion_archivos.piar_tipo as tipo,
        tb_pre_inscripcion_archivos.piar_fecha_creado as creado,
        tb_pre_inscripcion_archivos.piar_link as link
      FROM
        tb_pre_inscripcion_archivos
        WHERE tb_pre_inscripcion_archivos.prei_id = ?", $codigo);

      return $result->result();
  }

  public function m_elimina_archivo($codigo)
  {
      $qry = $this->db->query("DELETE FROM tb_pre_inscripcion_archivos where piar_id = ? ", $codigo);
      return 1;
  }

  // public function delete_preinscripcion($codigo)
  // {
  //   $qry = $this->db->query("DELETE FROM tb_pre_inscripcion where preins_id = ?", $codigo);
  //   return $codigo;
  // }

}
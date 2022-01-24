<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mcurso_web extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

  public function m_get_cursos($data)
  {
    $result = $this->db->query("SELECT 
          tb_curso_online.co_id AS codcurso,
          tb_curso_online.co_titulo AS titulo,
          tb_curso_online.co_url AS url,
          tb_curso_online.co_presentacion AS presentacion,
          tb_curso_online.co_duracion AS duracion,
          tb_curso_online.co_requisitos AS requisitos,
          tb_curso_online.co_contenido AS contenido,
          tb_curso_online.co_galeria AS galeria,
          tb_curso_online.id_sede AS codsede,
          tb_curso_online.co_activo AS activo,
          tb_curso_online.co_registro as fecha
      FROM
          tb_curso_online
            WHERE tb_curso_online.co_activo='SI' AND tb_curso_online.id_sede = ?;",$data);
    return $result->result();
  }

  public function m_get_curso($data)
  {
    $result = $this->db->query("SELECT 
          tb_curso_online.co_id AS codcurso,
          tb_curso_online.co_titulo AS titulo,
          tb_curso_online.co_url AS url,
          tb_curso_online.co_presentacion AS presentacion,
          tb_curso_online.co_duracion AS duracion,
          tb_curso_online.co_requisitos AS requisitos,
          tb_curso_online.co_contenido AS contenido,
          tb_curso_online.co_galeria AS galeria,
          tb_curso_online.id_sede AS codsede,
          tb_curso_online.co_activo AS activo,
          tb_curso_online.co_registro as fecha
      FROM
          tb_curso_online
            WHERE tb_curso_online.co_activo='SI' AND tb_curso_online.co_id=? AND tb_curso_online.id_sede=?;",$data);
    return $result->row();
  }

  public function m_dtsPreinscripcioncursoxfechas($data)
  {
    $sqlfecha="";
    if (count($data)>3){
      $sqlfecha=" AND tb_pre_inscripcion_cursos.pico_fecha BETWEEN ? AND ?";
    }
    $idsede = $_SESSION['userActivo']->idsede;
    $result = $this->db->query("SELECT 
          tb_pre_inscripcion_cursos.pico_id  id,
          tb_pre_inscripcion_cursos.pico_apepat ape_paterno,
          tb_pre_inscripcion_cursos.pico_apemat ape_materno,
          tb_pre_inscripcion_cursos.pico_nombres nombres,
          tb_pre_inscripcion_cursos.pico_tipdoc as tipodoc,
          tb_pre_inscripcion_cursos.pico_documento documento,
          tb_pre_inscripcion_cursos.pico_telefono telefono,
          tb_pre_inscripcion_cursos.pico_correo correo,
          tb_pre_inscripcion_cursos.cur_id carid,
          tb_curso_online.co_titulo carrera,
          tb_pre_inscripcion_cursos.id_sede sedeid,
          tb_sede.sed_nombre sedenom,          
          tb_pre_inscripcion_cursos.pico_fecha fecha,
          tb_pre_inscripcion_cursos.pico_estado estado,
          tb_pre_inscripcion_cursos.pico_fechanac as fechanac 
        FROM
          tb_pre_inscripcion_cursos
        INNER JOIN tb_curso_online ON (tb_pre_inscripcion_cursos.cur_id = tb_curso_online.co_id) 
        INNER JOIN tb_sede ON (tb_pre_inscripcion_cursos.id_sede = tb_sede.id_sede ) 
        WHERE concat(tb_pre_inscripcion_cursos.pico_apepat,' ',tb_pre_inscripcion_cursos.pico_apemat,' ',tb_pre_inscripcion_cursos.pico_nombres) LIKE ? AND tb_pre_inscripcion_cursos.cur_id LIKE ? AND tb_pre_inscripcion_cursos.pico_estado LIKE ? $sqlfecha AND tb_pre_inscripcion_cursos.id_sede = $idsede ORDER BY pico_id desc ", $data);
      return $result->result();
  }

  public function m_get_ficha_preinscripcioncurso($codigo)
  {
        $result = $this->db->query("SELECT 
        tb_pre_inscripcion_cursos.pico_id AS codpre,
        tb_pre_inscripcion_cursos.pico_apepat AS paterno,
        tb_pre_inscripcion_cursos.pico_apemat AS materno,
        tb_pre_inscripcion_cursos.pico_nombres AS nombres,
        tb_pre_inscripcion_cursos.pico_tipdoc AS tipodoc,
        tb_pre_inscripcion_cursos.pico_documento AS numero,
        tb_pre_inscripcion_cursos.pico_fechanac AS fecnac,
        tb_pre_inscripcion_cursos.pico_sexo AS sexo,
        tb_pre_inscripcion_cursos.pico_estado_civil AS estcivil,
        tb_pre_inscripcion_cursos.pico_telefono AS telefono,
        tb_pre_inscripcion_cursos.pico_correo AS correo,
        tb_pre_inscripcion_cursos.cur_id AS codcarrera,
        tb_pre_inscripcion_cursos.id_sede as sede,
        tb_pre_inscripcion_cursos.cod_distrito as coddistrito,
        tb_pre_inscripcion_cursos.pico_distrito AS distrito,
        tb_pre_inscripcion_cursos.pico_direccion AS direccion,
        tb_pre_inscripcion_cursos.pico_estado AS estado,
        tb_pre_inscripcion_cursos.pico_fecha AS fecha,
        tb_pre_inscripcion_cursos.cod_distrito,
        tb_provincia.prv_codigo AS codprovincia,
        tb_departamento.dep_codigo AS codepartamento,
        tb_curso_online.co_titulo as carrera
      FROM
        tb_pre_inscripcion_cursos
        INNER JOIN tb_curso_online ON (tb_pre_inscripcion_cursos.cur_id = tb_curso_online.co_id) 
        LEFT OUTER JOIN tb_distrito ON (tb_pre_inscripcion_cursos.cod_distrito = tb_distrito.dis_codigo)
        LEFT OUTER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        LEFT OUTER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
              WHERE tb_pre_inscripcion_cursos.pico_id = ? limit 1", $codigo);

      $arr_result['ficha']= $result->row();

        $result = $this->db->query("SELECT 
        tb_pre_inscripcion_cursos_archivos.picar_id as codigo,
        tb_pre_inscripcion_cursos_archivos.pic_id as codpreins,
        tb_pre_inscripcion_cursos_archivos.picar_titulo as titulo,
        tb_pre_inscripcion_cursos_archivos.picar_archivo as archivo,
        tb_pre_inscripcion_cursos_archivos.picar_peso as peso,
        tb_pre_inscripcion_cursos_archivos.picar_tipo as tipo,
        tb_pre_inscripcion_cursos_archivos.picar_fecha_creado as creado,
        tb_pre_inscripcion_cursos_archivos.picar_link as link
      FROM
        tb_pre_inscripcion_cursos_archivos
        WHERE tb_pre_inscripcion_cursos_archivos.pic_id = ?", $codigo);

      $arr_result['adjuntos']= $result->result();
      return $arr_result;
  }

  public function m_get_ficha_inscripcion_pdf($codigo)
  {
        $result = $this->db->query("SELECT 
        tb_pre_inscripcion_cursos.pico_id AS codpre,
        tb_pre_inscripcion_cursos.pico_apepat AS paterno,
        tb_pre_inscripcion_cursos.pico_apemat AS materno,
        tb_pre_inscripcion_cursos.pico_nombres AS nombres,
        tb_pre_inscripcion_cursos.pico_tipdoc AS tipodoc,
        tb_pre_inscripcion_cursos.pico_documento AS numero,
        tb_pre_inscripcion_cursos.pico_fechanac AS fecnac,
        tb_pre_inscripcion_cursos.pico_sexo AS sexo,
        tb_pre_inscripcion_cursos.pico_estado_civil AS estcivil,
        tb_pre_inscripcion_cursos.pico_telefono AS telefono,
        tb_pre_inscripcion_cursos.pico_correo AS correo,
        tb_pre_inscripcion_cursos.cur_id AS codcarrera,
        tb_pre_inscripcion_cursos.id_sede as sede,
        tb_pre_inscripcion_cursos.cod_distrito as coddistrito,
        
        tb_pre_inscripcion_cursos.pico_direccion AS direccion,
        tb_pre_inscripcion_cursos.pico_estado AS estado,
        tb_pre_inscripcion_cursos.pico_fecha AS fecha,
        tb_provincia.prv_codigo AS codprovincia,
        tb_departamento.dep_codigo AS codepartamento,
        tb_curso_online.co_titulo as carrera,
        tb_provincia.prv_nombre as provincia,
        tb_departamento.dep_nombre as departamento,
        tb_distrito.dis_nombre as distrito
      FROM
        tb_pre_inscripcion_cursos
        INNER JOIN tb_curso_online ON (tb_pre_inscripcion_cursos.cur_id = tb_curso_online.co_id) 
        LEFT OUTER JOIN tb_distrito ON (tb_pre_inscripcion_cursos.cod_distrito = tb_distrito.dis_codigo)
        LEFT OUTER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        LEFT OUTER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
              WHERE tb_pre_inscripcion_cursos.pico_id = ? limit 1", $codigo);

      return $result->row();


  }

  public function fn_update_estado_preinscripcion_curso($data)
  {
    $this->db->query("CALL `sp_tb_pre_inscripcion_cursos_update_estado`(?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row();
  }

  public function m_insert_curso($data){
    $this->db->query("CALL `sp_tb_curso_online_insert`(?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row();    
  }

  public function m_update_curso($data){
    $this->db->query("CALL `sp_tb_curso_online_update`(?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row();    
  }

  public function m_elimina_curso($codigo)
  {
      
      $qry = $this->db->query("DELETE FROM tb_curso_online where co_id = ? ", $codigo);
      
      return 1;
  }

  public function insert_datos_prematricula_curso($data){

      $this->db->query("CALL `sp_tb_pre_inscripcion_cursos_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return $res->row();    
  }

  public function update_datos_prematricula_curso($data){

      $this->db->query("CALL `sp_tb_pre_inscripcion_cursos_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return $res->row();    
  }

  public function insert_archivos_curso($data){
      
    //CALL `sp_tb_pre_inscripcion_archivos_insert`( @vinc_id, @vincp_titulo, @vincp_link, @vincp_archivo, @vincp_peso, @vincp_tipo, @s);
      $this->db->query("CALL `sp_tb_pre_inscripcion_cursos_archivos_insert`(?,?,?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return $res->row();    
  }

  public function delete_preinscripcion_cursos($data)
  {
    $this->db->query("CALL `sp_tb_pre_inscripcion_cursos_delete`(?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }

  public function m_insert_seguimiento_curso($data)
  {
    $this->db->query("CALL `sp_tb_pre_inscripcion_curso_detalle_insert`(?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }

  public function m_archivos_adjuntos_preincursos($codigo)
  {
      $result = $this->db->query("SELECT 
        tb_pre_inscripcion_cursos_archivos.picar_id as codigo,
        tb_pre_inscripcion_cursos_archivos.pic_id as codpreins,
        tb_pre_inscripcion_cursos_archivos.picar_titulo as titulo,
        tb_pre_inscripcion_cursos_archivos.picar_archivo as archivo,
        tb_pre_inscripcion_cursos_archivos.picar_peso as peso,
        tb_pre_inscripcion_cursos_archivos.picar_tipo as tipo,
        tb_pre_inscripcion_cursos_archivos.picar_fecha_creado as creado,
        tb_pre_inscripcion_cursos_archivos.picar_link as link
      FROM
        tb_pre_inscripcion_cursos_archivos
        WHERE tb_pre_inscripcion_cursos_archivos.pic_id = ?", $codigo);

      return $result->result();
  }

  public function m_elimina_archivo_preincursos($codigo)
  {
      $qry = $this->db->query("DELETE FROM tb_pre_inscripcion_cursos_archivos where picar_id = ? ", $codigo);
      return 1;
  }

  public function m_filtrar_seguimiento_curso($codigo)
  {
      $result = $this->db->query("SELECT 
        tb_pre_inscripcion_curso_detalle.dpreinsc_id AS codigo,
        tb_pre_inscripcion_curso_detalle.pic_id AS idpre,
        tb_pre_inscripcion_curso_detalle.dpreinsc_estado AS estado,
        tb_pre_inscripcion_curso_detalle.dpreinsc_observacion AS observacion,
        tb_pre_inscripcion_curso_detalle.dpreinsc_fecha AS fecha,
        tb_pre_inscripcion_curso_detalle.dpreinsc_hora AS hora,
        tb_pre_inscripcion_curso_detalle.dpreinsc_creado AS creado
      FROM
        tb_pre_inscripcion_curso_detalle
        WHERE tb_pre_inscripcion_curso_detalle.pic_id = ?
      ORDER BY  tb_pre_inscripcion_curso_detalle.dpreinsc_creado DESC ", $codigo);

      return $result->result();
  }


}

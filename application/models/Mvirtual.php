<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mvirtual extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_materiales($data)
    {
         $result = $this->db->query("SELECT 
        `virt_id` as codigo,
        `virt_nombre` as nombre,
        `virt_tipo` as tipo,
        `virt_norden` as orden,
        `virt_id_padre` as padre,
        `virt_link` as link,
        `virt_vence` as vence,
        `virt_detalle` as detalle,
        `virt_espacio` as esp,
        vit_mostrar_detalle as mostrardt,
        virt_visible as visible,
        virt_visible_time as v_time,
        cod_carga_eval_head as codevalhead

      FROM 
        `tb_virtual_material` 
      WHERE codigocarga=? AND  codigosubseccion=?  ORDER BY virt_id_padre,virt_norden,virt_fechacreacion",$data);
        return $result->result();
    }

    public function m_get_materiales_calificables($data)
    {
         $result = $this->db->query("SELECT 
        `virt_id` as codigo,
        `virt_nombre` as nombre,
        `virt_tipo` as tipo,
        `virt_norden` as orden,
        `virt_id_padre` as padre,
        `virt_link` as link,
        `virt_vence` as vence,
        `virt_detalle` as detalle,
        `virt_espacio` as esp,
        vit_mostrar_detalle as mostrardt,
        virt_visible as visible,
        virt_visible_time as v_time,
        cod_carga_eval_head as codevalhead

      FROM 
        `tb_virtual_material` 
      WHERE codigocarga=? AND  codigosubseccion=? AND virt_tipo IN ('T','V')  ORDER BY virt_norden,virt_id_padre",$data);
        return $result->result();
    }

    public function m_get_material($data)
    {
        $result = $this->db->query("SELECT 
        `virt_id` as codigo,
        `virt_nombre` as nombre,
        `virt_tipo` as tipo,
        `virt_link` as link,
        `virt_inicia` as inicia,
        `virt_vence` as vence,
        `virt_detalle` as detalle,
        `virt_nro_archivos` as nfiles,
        `virt_retraso` as retraso,
        vit_mostrar_detalle as mostrardt,
        virt_tiempo_limite as limite,
        `virt_opcion1` as opc1,
        `virt_opcion2` as opc2,
        `virt_opcion3` as opc3,
        `virt_opcion4` as opc4,
        `virt_opcion5` as opc5
      FROM 
        `tb_virtual_material` 
      WHERE virt_id=? limit 1",$data);
        return $result->row();
    }

    public function m_get_detalle_x_material($data)
    {
      $result = $this->db->query("SELECT
        vdet_id as coddetalle, 
        `vdet_nombre` as nombre,
        `vdet_link` as link,
        `vdet_peso` as peso,
        `vdet_tipo` as tipo
      FROM 
        `tb_virtual_detalle` 
      WHERE virt_id=?",$data);
        return $result->result();
    }
     public function m_get_detalle($data)
    {
      $result = $this->db->query("SELECT 
        `vdet_nombre` as nombre,
        `vdet_link` as link,
        `vdet_peso` as peso,
        `vdet_tipo` as tipo
      FROM 
        `tb_virtual_detalle` 
      WHERE virt_id=? and vdet_id=? limit 1",$data);
        return $result->row();
    }
    public function m_get_detalles($data)
    {
      $result = $this->db->query("SELECT 
        `vdet_id` as coddetalle,
        `virt_id` as codmaterial,
        `vdet_nombre` as nombre,
        `vdet_link` as link
      FROM 
        `tb_virtual_detalle`
      WHERE codigocarga=? and codigosubseccion=? ",$data);
        return $result->result();
    }

    public function m_get_count_entregas_x_material($data)
    {
        $result = $this->db->query("SELECT 
            COUNT(vita_id) AS total
          FROM
            tb_virtual_tarea_alumno
          WHERE
            virt_id = ? AND  vita_entrega IS NOT NULL",$data);
        return $result->row()->total;
    }

    public function m_update_virtual_data($data){

       $this->db->query("CALL `sp_tb_virtual_material_title_update`(?,?,?,@s)", $data);
       
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }
    public function m_update_virtual_file($data){

       $this->db->query("CALL `sp_tb_virtual_detalle_file_update`(?,?,?,@s)", $data);
       
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }

    public function m_insert($data){
      $this->db->query("CALL `sp_tb_virtual_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)", $data);
      $res = $this->db->query('select @s as salida,@nid as newcode');
      return $res->row();
    }

    public function m_update($data){
      $this->db->query("CALL `sp_tb_virtual_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)", $data);
      $res = $this->db->query('select @s as salida');
      return $res->row();
    }


    public function m_delete($data){
      $this->db->query("DELETE FROM `tb_virtual_material`  WHERE  `virt_id` = ?", $data);
      return $this->db->affected_rows();
    }

    public function m_delete_detalle($data){
      $this->db->query("DELETE FROM  `tb_virtual_detalle` WHERE  `vdet_id` = ?", $data);
      return $this->db->affected_rows();
      
    }

    
    public function m_update_espacio($data){
      $this->db->query("CALL `sp_tb_virtual_update_espacio`(?,?,@s)", $data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }

    public function m_insert_duplicar($data){
      $this->db->query("CALL `sp_tb_virtual_insert_duplicar`(?,?,@s)", $data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }

    public function m_ordenar($datainsert){
      foreach ($datainsert as $key => $data) {
          //CALL ``( @`vcca`, @`vsubseccion`, @`vidmiembro`, @`vecu_nota`, @`videvaluacionhead`, @`s`);
        $this->db->query("UPDATE `tb_virtual_material`  SET `virt_norden` = ? WHERE  `virt_id` = ?", $data);
      }
      return true;
    }

    public function m_insert_detalle($data){
      //CALL ``( @virt_id, @vvirt_link, @vvirt_nombre, @vcodigocarga, @vcodigosubseccion, @`s`);
      $this->db->query("CALL `sp_tb_virt_detalle_insert`(?,?,?,?,?,?,?,@s)", $data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }

    //FUNCIONES DE YNGA-- REVISAR
    public function m_codigo_miembro($codigo)
    {
      $result = $this->db->query("SELECT 
                tb_carga_subseccion_miembros.csm_id AS codigo
              FROM
                tb_carga_subseccion_miembros
                INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
                INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
              WHERE
                tb_inscripcion.ins_carnet = ? AND tb_carga_subseccion_miembros.cod_cargaacademica=? 
                AND tb_carga_subseccion_miembros.cod_subseccion=? LIMIT 1", $codigo);
      if ($result){
        return $result->row()->codigo;  
      }
      else{
        return 0;
      }
      
    }

    public function m_insert_comentario($data){
      $this->db->query("CALL `sp_insert_tb_comentarios`(?,?,?,?,?,?,@s)", $data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }

    public function lstcomentariosxforo($codigo)
    {
      $result = $this->db->query("SELECT 
                tb_comentarios.com_id AS codigo,
                tb_comentarios.id_miembro AS idmiem,
                tb_comentarios.id_foro AS idfor,
                tb_comentarios.com_id_padre AS idpadre,
                tb_comentarios.comentario,
                tb_comentarios.com_fecha AS fecha,
                tb_comentarios.com_apelnombres AS comentador,
                tb_comentarios.com_foto AS foto,
                tb_virtual_material.codigocarga AS codcarga,
                tb_virtual_material.codigosubseccion AS codsub
              FROM
                tb_comentarios
                INNER JOIN tb_virtual_material ON (tb_comentarios.id_foro = tb_virtual_material.virt_id)
              WHERE 
                tb_comentarios.id_foro = ? ORDER BY tb_comentarios.com_id_padre ASC,tb_comentarios.com_fecha ", $codigo);
      return $result->result();
    }


public function m_update_mostrar_ocultar($data)
    {
      $result = $this->db->query("UPDATE tb_virtual_material SET virt_visible = ?, virt_visible_time = ? WHERE virt_id = ?", $data);
      return 1;
    }

    public function m_update_programar_status($data)
    {
      $result = $this->db->query("UPDATE tb_virtual_material SET virt_visible = ?, virt_visible_time = ? WHERE virt_id = ?", $data);
      return 1;
    }

    public function m_get_virtmateriales($data)
    {
         $result = $this->db->query("SELECT 
        `virt_id` as codigo,
        `virt_nombre` as nombre,
        `virt_tipo` as tipo,
        `virt_norden` as orden,
        `virt_id_padre` as padre,
        `virt_link` as link,
        `virt_vence` as vence,
        `virt_detalle` as detalle,
        `virt_espacio` as esp,
        vit_mostrar_detalle as mostrardt,
        virt_visible as visible,
        virt_visible_time as v_time

      FROM 
        `tb_virtual_material` 
      WHERE codigocarga=? AND  codigosubseccion=? AND virt_tipo IN ('V','T') 
      ORDER BY virt_norden,virt_id_padre,virt_fechacreacion",$data);
        return $result->result();
    }

    public function m_get_notas_x_materiales($data)
    {
         $result = $this->db->query("SELECT 
            tb_virtual_material.virt_id as codmaterial,
            tb_virtual_material.virt_nombre AS material,
            tb_virtual_evaluacion_alumno.miembro_id AS codmiembro,
            tb_virtual_evaluacion_alumno.virt_id AS entrega,
            tb_virtual_evaluacion_alumno.vita_nota AS nota,
            tb_virtual_material.virt_id_padre AS padre,
            tb_virtual_material.virt_norden as orden
          FROM
            tb_virtual_material
            INNER JOIN tb_virtual_evaluacion_alumno ON (tb_virtual_material.virt_id = tb_virtual_evaluacion_alumno.virt_id)
          WHERE
            tb_virtual_material.codigocarga = ? AND 
            tb_virtual_material.codigosubseccion = ?

          UNION ALL

          SELECT 
            tb_virtual_material.virt_id as codmaterial,
            tb_virtual_material.virt_nombre AS material,
            tb_virtual_tarea_alumno.miembro_id AS codmiembro,
            tb_virtual_tarea_alumno.virt_id AS entrega,
            tb_virtual_tarea_alumno.vita_nota AS nota,
            tb_virtual_material.virt_id_padre AS padre,
            tb_virtual_material.virt_norden as orden
          FROM
            tb_virtual_material
            INNER JOIN tb_virtual_tarea_alumno ON (tb_virtual_material.virt_id = tb_virtual_tarea_alumno.virt_id)
          WHERE
            tb_virtual_material.codigocarga = ? AND 
            tb_virtual_material.codigosubseccion = ?
            
          order by padre, orden",$data);
        return $result->result();
    
  }

    public function m_get_notas_materiales($data)
    {
         $result = $this->db->query("SELECT 
            tb_virtual_evaluacion_alumno.vita_nota as notev,
            tb_virtual_evaluacion_alumno.miembro_id as miev,
            tb_virtual_tarea_alumno.vita_nota as notar,
            tb_virtual_tarea_alumno.miembro_id as mitar,
            tb_virtual_material.virt_nombre as material,
            tb_virtual_evaluacion_alumno.virt_id as evirtid,
            tb_virtual_tarea_alumno.virt_id as tvirtid
          FROM
            tb_virtual_material
            LEFT OUTER JOIN tb_virtual_evaluacion_alumno ON (tb_virtual_material.virt_id = tb_virtual_evaluacion_alumno.virt_id)
            LEFT OUTER JOIN tb_virtual_tarea_alumno ON (tb_virtual_material.virt_id = tb_virtual_tarea_alumno.virt_id)
          WHERE
            tb_virtual_material.codigocarga = ? AND 
            tb_virtual_material.codigosubseccion = ? AND 
            tb_virtual_material.virt_tipo IN ('V','T')

            ORDER BY
              tb_virtual_material.virt_norden,
              tb_virtual_material.virt_id_padre,
              tb_virtual_material.virt_fechacreacion",$data);
        return $result->result();
    }

    public function m_enlazar_update_aula_evaluacion($data)
    {
        $result = $this->db->query("UPDATE 
            `tb_virtual_material`  
          SET 
            `cod_carga_eval_head` = ? 
          WHERE 
            `virt_id` = ?
          ;",$data);
        return true;
    }

    
    /*public function lstcomentariosxforo_respuesta($codigo)
    {
      $result = $this->db->query("SELECT 
                tb_comentarios.com_id AS codigo,
                tb_comentarios.id_miembro AS idmiem,
                tb_comentarios.id_foro AS idfor,
                tb_comentarios.com_id_padre AS idpadre,
                tb_comentarios.comentario AS comentario,
                tb_comentarios.com_fecha AS fecha,
                tb_persona.per_apel_paterno AS apepat,
                tb_persona.per_apel_materno AS apemat,
                tb_persona.per_nombres AS nombres,
                tb_persona.per_foto AS foto,
                tb_virtual_material.codigocarga AS codcarga,
                tb_virtual_material.codigosubseccion AS codsub
              FROM
                tb_persona
                INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
                INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
                INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
                INNER JOIN tb_comentarios ON (tb_carga_subseccion_miembros.csm_id = tb_comentarios.id_miembro)
                INNER JOIN tb_virtual_material ON (tb_comentarios.id_foro = tb_virtual_material.virt_id)
                INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
              WHERE
                tb_comentarios.com_id_padre <> 0 AND tb_comentarios.id_foro = ? ORDER BY tb_comentarios.com_id ASC", $codigo);
      return $result->result();
    }*/

   /* public function lstcomentariosforoxcodigo($codigo){
      $result = $this->db->query("SELECT 
                tb_comentarios.com_id AS codigo,
                tb_comentarios.id_miembro AS idmiem,
                tb_comentarios.id_foro AS idfor,
                tb_comentarios.com_id_padre AS idpadre,
                tb_comentarios.comentario AS comentario,
                tb_comentarios.com_fecha AS fecha,
                tb_persona.per_apel_paterno AS apepat,
                tb_persona.per_apel_materno AS apemat,
                tb_persona.per_nombres AS nombres,
                tb_persona.per_foto AS foto,
                tb_virtual_material.codigocarga AS codcarga,
                tb_virtual_material.codigosubseccion AS codsub
              FROM
                tb_persona
                INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
                INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
                INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
                INNER JOIN tb_comentarios ON (tb_carga_subseccion_miembros.csm_id = tb_comentarios.id_miembro)
                INNER JOIN tb_virtual_material ON (tb_comentarios.id_foro = tb_virtual_material.virt_id)
                INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
              WHERE
                tb_comentarios.com_id = ? ORDER BY tb_comentarios.com_id_padre ASC,tb_comentarios.com_fecha", $codigo);
      return $result->result();
    }*/
}
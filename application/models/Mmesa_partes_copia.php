<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmesa_partes extends CI_Model {

	function __construct() {
           parent::__construct();
           $this->load->helper("url");          
    }


    public function m_solicitudes_to_mesa_partes($data)
    {
        $result = $this->db->query("SELECT 
          tb_mesa_partes.mpt_id AS codsolicitud,
          tb_mesa_partes.tmt_id AS codtramite,
          tb_tramites_tipos.tmt_nombre AS tramite,
          tb_mesa_partes.mpt_asunto AS asunto,
          tb_mesa_partes.mpt_tipo_documento AS tipodoc,
          tb_mesa_partes.mpt_ndocumento AS nrodoc,
          tb_mesa_partes.mpt_nombres AS solicitante,
          tb_mesa_partes.mpt_email AS email_personal,
          tb_mesa_partes.mpt_email_corporativo AS email_corporativo,
          tb_mesa_partes.mpt_telefono AS telefono,
          tb_mesa_partes.mpt_situacion AS situacion,
          tb_mesa_partes.mpt_fecha AS fecha,
          tb_mesa_partes.mpr_id_actual AS codruta,
          tb_mesa_partes_ruta.destino_area_id as codarea_actual,
          tb_area.are_nombre AS area_actual,
          tb_mesa_partes_ruta.mpr_situacion AS situacion_actual,
          tb_mesa_partes_ruta.destino_usuario_id as codusuario_destino,
          tb_mesa_partes.mpt_anio as anio,
          tb_mesa_partes.mpt_lugar as lugar,
          tb_mesa_partes.mpt_codseguimiento as codseg

        FROM
          tb_tramites_tipos
          INNER JOIN tb_mesa_partes ON (tb_tramites_tipos.tmt_id = tb_mesa_partes.tmt_id)
          LEFT OUTER JOIN tb_mesa_partes_ruta ON (tb_mesa_partes.mpr_id_actual = tb_mesa_partes_ruta.mpr_codigo)
          LEFT OUTER JOIN tb_area ON (tb_mesa_partes_ruta.destino_area_id = tb_area.are_codigo)
        WHERE tb_mesa_partes.tmt_id LIKE ? 
        AND CONCAT(tb_mesa_partes.mpt_ndocumento,tb_mesa_partes.mpt_nombres) LIKE ? AND tb_mesa_partes.mpt_situacion =?
        AND tb_mesa_partes.sede_id = ?
        ORDER BY tb_mesa_partes.mpt_id desc",$data);
        return $result->result();
    }
    
    /*public function m_solicitudes_to_mesa_partes($data)
    {
        $result = $this->db->query("SELECT 
          tb_mesa_partes.mpt_id AS codsolicitud,
          tb_mesa_partes_ruta.mpr_codigo as codruta,
          tb_mesa_partes.tmt_id AS codtramite,
          tb_tramites_tipos.tmt_nombre AS tramite,
          tb_mesa_partes.mpt_asunto AS asunto,
          tb_mesa_partes.mpt_tipo_documento AS tipodoc,
          tb_mesa_partes.mpt_ndocumento AS nrodoc,
          tb_mesa_partes.mpt_nombres AS solicitante,
          tb_mesa_partes.mpt_email AS email_personal,
          tb_mesa_partes.mpt_email_corporativo AS email_corporativo,
          tb_mesa_partes.mpt_telefono AS telefono,
          tb_mesa_partes_ruta.mpr_fecha AS fecha,
          tb_mesa_partes_ruta.mpr_fecha_procesado AS fecha_p,
          tb_mesa_partes.mpt_situacion AS situacion,
          tb_mesa_partes_ruta.destino_area_id AS idarea_destino,
          tb_mesa_partes_ruta.origen_area_id AS idarea_origen,
          tb_area.are_nombre AS area_origen,
          tb_mesa_partes_ruta.mpr_situacion AS situacion_ruta
        FROM
          tb_tramites_tipos
          INNER JOIN tb_mesa_partes ON (tb_tramites_tipos.tmt_id = tb_mesa_partes.tmt_id)
          INNER JOIN tb_mesa_partes_ruta ON (tb_mesa_partes.mpt_id = tb_mesa_partes_ruta.mpt_codigo)
          LEFT OUTER JOIN tb_area ON (tb_mesa_partes_ruta.origen_area_id = tb_area.are_codigo)
        WHERE (tb_mesa_partes_ruta.destino_area_id=? OR tb_mesa_partes_ruta.destino_area_id=1)
        AND tb_mesa_partes_ruta.mpr_situacion=? AND tb_mesa_partes.tmt_id LIKE ? 
        AND CONCAT(tb_mesa_partes.mpt_ndocumento,tb_mesa_partes.mpt_nombres) LIKE ?",$data);
        return $result->result();
    }*/

    public function m_solicitudes_x_area_destino($data)
    {
        $result = $this->db->query("SELECT 
          tb_mesa_partes.mpt_id AS codsolicitud,
          tb_mesa_partes.tmt_id AS codtramite,
          tb_tramites_tipos.tmt_nombre AS tramite,
          tb_mesa_partes.mpt_asunto AS asunto,
          tb_mesa_partes.mpt_tipo_documento AS tipodoc,
          tb_mesa_partes.mpt_ndocumento AS nrodoc,
          tb_mesa_partes.mpt_nombres AS solicitante,
          tb_mesa_partes.mpt_email AS email_personal,
          tb_mesa_partes.mpt_email_corporativo AS email_corporativo,
          tb_mesa_partes.mpt_telefono AS telefono,
          tb_mesa_partes.mpt_situacion AS situacion,
          tb_mesa_partes.mpt_fecha AS fecha,
          tb_mesa_partes.mpr_id_actual AS codruta,
          tb_mesa_partes_ruta.destino_area_id as codarea_actual,
          tb_area.are_nombre AS area_actual,
          tb_mesa_partes_ruta.mpr_situacion AS situacion_actual,
          tb_mesa_partes_ruta.destino_usuario_id as codusuario_destino,
          tb_mesa_partes.mpt_anio as anio,
          tb_mesa_partes.mpt_lugar as lugar,
          tb_mesa_partes.mpt_codseguimiento as codseg
        FROM
          tb_tramites_tipos
          INNER JOIN tb_mesa_partes ON (tb_tramites_tipos.tmt_id = tb_mesa_partes.tmt_id)
          INNER JOIN tb_mesa_partes_ruta ON (tb_mesa_partes.mpr_id_actual = tb_mesa_partes_ruta.mpr_codigo)
          INNER JOIN tb_area ON (tb_mesa_partes_ruta.destino_area_id = tb_area.are_codigo)
        WHERE (tb_mesa_partes_ruta.destino_area_id = ? OR tb_mesa_partes_ruta.destino_usuario_id=? )
        AND tb_mesa_partes.tmt_id LIKE ? 
        AND CONCAT(tb_mesa_partes.mpt_ndocumento,tb_mesa_partes.mpt_nombres) LIKE ? AND tb_mesa_partes.mpt_situacion =? 
        AND tb_mesa_partes.sede_id = ?
        ORDER BY tb_mesa_partes.mpt_id desc",$data);
        return $result->result();
    }

    
    public function m_solicitudes_x_user($data)
    {
        $result = $this->db->query("SELECT 
              tb_mesa_partes.mpt_id AS codsolicitud,
              tb_mesa_partes.id_usuario AS codusuario,
              tb_mesa_partes.tmt_id AS codtramite,
              tb_tramites_tipos.tmt_nombre AS tramite,
              tb_mesa_partes.mpt_asunto AS asunto,
              tb_mesa_partes.mpt_tipo_documento AS tipodoc,
              tb_mesa_partes.mpt_ndocumento AS nrodoc,
              tb_mesa_partes.mpt_nombres AS solicitante,
              tb_mesa_partes.mpt_email AS email_personal,
              tb_usuario.usu_email_corporativo as email_corporativo,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_fecha AS fecha,
              tb_mesa_partes.mpt_situacion AS situacion
            FROM
              tb_tramites_tipos
              INNER JOIN tb_mesa_partes ON (tb_tramites_tipos.tmt_id = tb_mesa_partes.tmt_id)
              INNER JOIN tb_usuario ON (tb_mesa_partes.id_usuario = tb_usuario.id_usuario)
            WHERE tb_mesa_partes.id_usuario=?",$data);
        return $result->result();
    }

    public function m_solo_solicitud_x_codigo($data)
    {
        $result = $this->db->query("SELECT 
              tb_mesa_partes.mpt_id AS codsolicitud,
              tb_mesa_partes.id_usuario AS codusuario,
              tb_mesa_partes.tmt_id AS codtramite,
              tb_tramites_tipos.tmt_nombre AS tramite,
              tb_mesa_partes.mpt_asunto AS asunto,
              tb_mesa_partes.mpt_contenido as contenido,
              tb_mesa_partes.mpt_tipo_documento AS tipodoc,
              tb_mesa_partes.mpt_ndocumento AS nrodoc,
              tb_mesa_partes.mpt_nombres AS solicitante,
              tb_mesa_partes.mpt_email AS email_personal,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_domicilio as domicilio,
              tb_usuario.usu_email_corporativo as email_corporativo,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_fecha AS fecha,
              tb_mesa_partes.mpt_situacion AS situacion,
              tb_mesa_partes.mpt_codseguimiento as codseg
            FROM
              tb_tramites_tipos
              INNER JOIN tb_mesa_partes ON (tb_tramites_tipos.tmt_id = tb_mesa_partes.tmt_id)
              LEFT OUTER JOIN tb_usuario ON (tb_mesa_partes.id_usuario = tb_usuario.id_usuario)
            WHERE tb_mesa_partes.mpt_id=?",$data);
        

        return $result->row();
    }

    public function m_solicitud_x_codigo($data)
    {
        $result = $this->db->query("SELECT 
              tb_mesa_partes.mpt_id AS codsolicitud,
              tb_mesa_partes.id_usuario AS codusuario,
              tb_mesa_partes.tmt_id AS codtramite,
              tb_tramites_tipos.tmt_nombre AS tramite,
              tb_mesa_partes.mpt_asunto AS asunto,
              tb_mesa_partes.mpt_contenido as contenido,
              tb_mesa_partes.mpt_tipo_documento AS tipodoc,
              tb_mesa_partes.mpt_ndocumento AS nrodoc,
              tb_mesa_partes.mpt_nombres AS solicitante,
              tb_mesa_partes.mpt_email AS email_personal,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_domicilio as domicilio,
              tb_usuario.usu_email_corporativo as email_corporativo,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_fecha AS fecha,
              tb_mesa_partes.mpt_situacion AS situacion,
              tb_mesa_partes.mpt_codseguimiento as codseg
            FROM
              tb_tramites_tipos
              INNER JOIN tb_mesa_partes ON (tb_tramites_tipos.tmt_id = tb_mesa_partes.tmt_id)
              LEFT OUTER JOIN tb_usuario ON (tb_mesa_partes.id_usuario = tb_usuario.id_usuario)
            WHERE tb_mesa_partes.mpt_id=?",$data);
        $rs['solicitud']=$result->row();

        $result = $this->db->query("SELECT 
                `incp_id` as codadjunto,
                `inc_id` as codruta,
                `incp_titulo` as titulo,
                `incp_archivo` as archivo,
                `incp_peso` as peso,
                `incp_tipo` as tipo,
                `incp_fecha_creado` as creado,
                `incp_link` as link,
                `inc_mpcod` as codsolicitud
              FROM 
                `tb_mesa_partes_archivos` 
              WHERE inc_mpcod=? AND inc_id IS NULL",$data);
        $rs['adjuntos']=$result->result();

        return $rs;
    }

    public function m_solicitud_ruta_x_codigo($data)
    {
        $result = $this->db->query("SELECT 
              tb_mesa_partes.mpt_id AS codsolicitud,
              tb_mesa_partes.id_usuario AS codusuario,
              tb_mesa_partes.tmt_id AS codtramite,
              tb_tramites_tipos.tmt_nombre AS tramite,
              tb_mesa_partes.mpt_asunto AS asunto,
              tb_mesa_partes.mpt_contenido as contenido,
              tb_mesa_partes.mpt_tipo_documento AS tipodoc,
              tb_mesa_partes.mpt_ndocumento AS nrodoc,
              tb_mesa_partes.mpt_nombres AS solicitante,
              tb_mesa_partes.mpt_email AS email_personal,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_domicilio as domicilio,
              tb_usuario.usu_email_corporativo as email_corporativo,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_fecha AS fecha,
              tb_mesa_partes.mpt_situacion AS situacion
            FROM
              tb_tramites_tipos
              INNER JOIN tb_mesa_partes ON (tb_tramites_tipos.tmt_id = tb_mesa_partes.tmt_id)
              INNER JOIN tb_usuario ON (tb_mesa_partes.id_usuario = tb_usuario.id_usuario)
            WHERE tb_mesa_partes.mpt_id=?",$data);
        $rs['solicitud']=$result->row();
        $result = $this->db->query("SELECT 
            tb_mesa_partes_ruta.mpr_codigo AS codruta,
            tb_mesa_partes_ruta.mpt_codigo AS codsolicitud,
            tb_mesa_partes_ruta.origen_area_id AS codarea_origen,
            tb_area.are_nombre AS area_origen,
            tb_mesa_partes_ruta.origen_usuario_id AS codusuario_origen,
            tb_usuario.usu_nick AS usuario_origen,
            tb_mesa_partes_ruta.destino_area_id AS codarea_destino,
            tb_area1.are_nombre AS area_destino,
            tb_mesa_partes_ruta.destino_usuario_id AS codusuario_destino,
            tb_usuario1.usu_nick as usuario_destino ,
            tb_mesa_partes_ruta.mpr_descripcion AS descripcion,
            tb_mesa_partes_ruta.mpr_situacion AS situacion_ruta,
            tb_mesa_partes_ruta.mpr_fecha AS fecha,
            tb_mesa_partes_ruta.mpr_fecha_procesado AS fecha_p
          FROM
            tb_area
            INNER JOIN tb_mesa_partes_ruta ON (tb_area.are_codigo = tb_mesa_partes_ruta.origen_area_id)
            LEFT OUTER JOIN tb_usuario ON (tb_mesa_partes_ruta.origen_usuario_id = tb_usuario.id_usuario)
            LEFT OUTER JOIN tb_area tb_area1 ON (tb_mesa_partes_ruta.destino_area_id = tb_area1.are_codigo)
            LEFT OUTER JOIN tb_usuario tb_usuario1 ON (tb_mesa_partes_ruta.destino_usuario_id = tb_usuario1.id_usuario)
            WHERE tb_mesa_partes_ruta.mpt_codigo=? ORDER BY tb_mesa_partes_ruta.mpr_fecha asc",$data);
        $rs['ruta']=$result->result();
        $result = $this->db->query("SELECT 
                `incp_id` as codadjunto,
                `inc_id` as codruta,
                `incp_titulo` as titulo,
                `incp_archivo` as archivo,
                `incp_peso` as peso,
                `incp_tipo` as tipo,
                `incp_fecha_creado` as creado,
                `incp_link` as link,
                `inc_mpcod` as codsolicitud
              FROM 
                `tb_mesa_partes_archivos` 
              WHERE inc_mpcod=? AND inc_id  IS NOT NULL",$data);
        $rs['adjuntos']=$result->result();

        return $rs;
    }

    public function m_ruta_recibir($data){
      //CALL `sp_tb_mesa_partes_rechazar`( @vid_usuario, @vmpt_id, @vmpr_id, @vmpr_fecha_procesado, @s);
        $this->db->query("CALL `sp_tb_mesa_partes_recibir`(?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return $res->row();    
    }
    public function m_ruta_rechazar($data){
      //CALL `sp_tb_mesa_partes_rechazar`( @vid_usuario, @vmpt_id, @vmpr_id, @vmpr_fecha_procesado, @s);
        $this->db->query("CALL `sp_tb_mesa_partes_rechazar`(?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return $res->row();    
    }
    public function m_ruta_derivar($data){
      //CALL `sp_tb_mesa_partes_rechazar`( @vid_usuario, @vmpt_id, @vmpr_id, @vmpr_fecha_procesado, @s);
        $this->db->query("CALL `sp_tb_mesa_partes_derivar`(?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return $res->row();    
    }
    public function m_ruta_finalizar($data){
      //CALL `sp_tb_mesa_partes_rechazar`( @vid_usuario, @vmpt_id, @vmpr_id, @vmpr_fecha_procesado, @s);
        $this->db->query("CALL `sp_tb_mesa_partes_finalizar`(?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
         $res = $this->db->query('select @s as salida,@nid as nid');
        return $res->row();    
    }


    public function m_adjuntos_x_solicitud($data)
    {
        $result = $this->db->query("SELECT 
              tb_mesa_partes.mpt_id AS codsolicitud,
              tb_mesa_partes.id_usuario AS codusuario,
              tb_mesa_partes.tmt_id AS codtramite,
              tb_tramites_tipos.tmt_nombre AS tramite,
              tb_mesa_partes.mpt_asunto AS asunto,
              tb_mesa_partes.mpt_contenido as contenido,
              tb_mesa_partes.mpt_tipo_documento AS tipodoc,
              tb_mesa_partes.mpt_ndocumento AS nrodoc,
              tb_mesa_partes.mpt_nombres AS solicitante,
              tb_mesa_partes.mpt_email AS email_personal,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_domicilio as domicilio,
              tb_usuario.usu_email_corporativo as email_corporativo,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_fecha AS fecha,
              tb_mesa_partes.mpt_situacion AS situacion,
              tb_mesa_partes.mpt_codseguimiento as codseg
            FROM
              tb_tramites_tipos
              INNER JOIN tb_mesa_partes ON (tb_tramites_tipos.tmt_id = tb_mesa_partes.tmt_id)
              LEFT OUTER JOIN tb_usuario ON (tb_mesa_partes.id_usuario = tb_usuario.id_usuario)
            WHERE tb_mesa_partes.mpt_id=? LIMIT 1",$data);
        return $result->row();
    }

    public function m_lts_tipo_tramite()
    {
      $result = $this->db->query("SELECT 
            tb_tramites_tipos.tmt_id id,
            tb_tramites_tipos.tmt_nombre nombre,
            tb_tramites_tipos.tmt_eliminado eliminado
          FROM
            tb_tramites_tipos
          WHERE tb_tramites_tipos.tmt_eliminado = 'NO' ");
        return $result->result();
    }

    public function insert_datos_mesa_partes($data){
        //$this->db->query('SET time_zone="-05:00"');
        $this->db->query("CALL `sp_tb_mesa_partes_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid,@vseguimiento)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid,@vseguimiento as codseg');
        return $res->row();    
    }


    public function insert_archivos_mesa_partes($data){
        //CALL `sp_tb_incidencia_pruebas_insert`( @vinc_id, @vincp_titulo, @vincp_link, @vincp_archivo, @vincp_peso, @vincp_tipo, @s);
        $this->db->query("CALL `sp_tb_mesa_parte_archivos_insert`(?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }


    // public function m_dtsIncidencia($data)
    // {
    //   $result = $this->db->query("SELECT 
    //         tb_incidencias.inc_id id,
    //         tb_incidencias.id_usuario usuario,
    //         tb_incidencias.inc_nombres nombres,
    //         tb_incidencias.inc_dni documento,
    //         tb_incidencias.inc_domicilio domicilio,
    //         tb_incidencias.inc_distrito distrito,
    //         tb_incidencias.inc_incidencia asunto,
    //         tb_incidencias.inc_detalle detalle,
    //         tb_incidencias.inc_declara declara,
    //         tb_incidencias.inc_estado estado,
    //         tb_incidencias.inc_fecha fecha,
    //         tb_incidencia_pruebas.incp_id idprb,
    //         tb_incidencia_pruebas.incp_titulo titulo,
    //         tb_incidencia_pruebas.incp_archivo archivo
    //       FROM
    //         tb_incidencias
    //       LEFT JOIN tb_incidencia_pruebas ON (tb_incidencias.inc_id = tb_incidencia_pruebas.inc_id) 
    //       WHERE tb_incidencias.inc_id = ? ORDER BY tb_incidencias.inc_nombres ", $data);
    //     return $result->result();
    // }

    // public function m_dtsIncidenciaxid($data)
    // {
    //   $result = $this->db->query("SELECT 
    //         tb_incidencias.inc_id id,
    //         tb_incidencias.id_usuario usuario,
    //         tb_incidencias.inc_nombres nombres,
    //         tb_incidencias.inc_dni documento,
    //         tb_incidencias.inc_domicilio domicilio,
    //         tb_incidencias.inc_distrito distrito,
    //         tb_incidencias.inc_incidencia asunto,
    //         tb_incidencias.inc_detalle detalle,
    //         tb_incidencias.inc_declara declara,
    //         tb_incidencias.inc_estado estado,
    //         tb_incidencias.inc_fecha fecha
    //       FROM
    //         tb_incidencias
    //       -- LEFT JOIN tb_incidencia_pruebas ON (tb_incidencias.inc_id = tb_incidencia_pruebas.inc_id) 
    //       WHERE tb_incidencias.id_usuario = ? ORDER BY tb_incidencias.inc_fecha DESC", $data);
    //     return $result->result();
    // }

    // public function m_dtsIncid_respuesta($data)
    // {
    //   $result = $this->db->query("SELECT 
    //         tb_incidencias_respuesta.rpt_id id,
    //         tb_incidencias_respuesta.rpt_respuesta respuesta,
    //         tb_incidencias_respuesta.inc_id id_inc,
    //         tb_incidencias_respuesta.rpt_fecha fecha
    //       FROM
    //         tb_incidencias_respuesta
    //       WHERE tb_incidencias_respuesta.inc_id = ? LIMIT 1", $data);
    //     return $result->row();
    // }

    // public function m_dtsIncid_search($data)
    // {
    //   if ($data[0] != "" && $data[1] == "" && $data[2] == "") {
    //     $result = $this->db->query("SELECT 
    //         tb_incidencias.inc_id id,
    //         tb_incidencias.id_usuario usuario,
    //         tb_incidencias.inc_nombres nombres,
    //         tb_incidencias.inc_dni documento,
    //         tb_incidencias.inc_domicilio domicilio,
    //         tb_incidencias.inc_distrito distrito,
    //         tb_incidencias.inc_incidencia asunto,
    //         tb_incidencias.inc_detalle detalle,
    //         tb_incidencias.inc_declara declara,
    //         tb_incidencias.inc_estado estado,
    //         tb_incidencias.inc_fecha fecha
    //       FROM
    //         tb_incidencias
    //       WHERE tb_incidencias.inc_nombres LIKE ? ORDER BY tb_incidencias.inc_id DESC", $data[0]);
    //   } else if ($data[0] != "" && $data[1] != "" && $data[2] != "") {
    //     $result = $this->db->query("SELECT 
    //         tb_incidencias.inc_id id,
    //         tb_incidencias.id_usuario usuario,
    //         tb_incidencias.inc_nombres nombres,
    //         tb_incidencias.inc_dni documento,
    //         tb_incidencias.inc_domicilio domicilio,
    //         tb_incidencias.inc_distrito distrito,
    //         tb_incidencias.inc_incidencia asunto,
    //         tb_incidencias.inc_detalle detalle,
    //         tb_incidencias.inc_declara declara,
    //         tb_incidencias.inc_estado estado,
    //         tb_incidencias.inc_fecha fecha
    //       FROM
    //         tb_incidencias
    //       WHERE tb_incidencias.inc_nombres LIKE ? 
    //       AND tb_incidencias.inc_fecha BETWEEN ? AND ? 
    //       ORDER BY tb_incidencias.inc_fecha DESC", $data);
    //   }

    //   return $result->result();
    // }

    // public function m_emailuser($data)
    // {
    //   $result = $this->db->query("SELECT 
    //         tb_usuario.usu_email_corporativo AS ecorporativo,
    //         tb_usuario.id_usuario AS idusuario
    //       FROM
    //         tb_usuario
    //       WHERE tb_usuario.id_usuario = ? LIMIT 1 ", $data);
    //   return $result->row();
    // }

    // public function insert_respuesta_incidencia($data){

    //     $this->db->query("CALL `sp_tb_incidencias_respuesta_insert`(?,?,@s)",$data);
    //     $res = $this->db->query('select @s as out_param');
    //     return $res->row()->out_param;    
    // }
    
    // public function m_updatestatus($data)
    // {
    //   $result = $this->db->query("UPDATE tb_incidencias SET inc_estado = ? WHERE inc_id = ?", $data);
    //   return 1;
    // }
    public function m_obtenercodigo_mesa($data)
    {
      $result = $this->db->query("SELECT 
              tb_mesa_partes.mpt_id AS codsolicitud
            FROM
            tb_mesa_partes
            WHERE tb_mesa_partes.mpt_codseguimiento = ? LIMIT 1",$data);
            return $result->row();
    }

    public function m_solicitud_ruta_x_codigoanio($data)
    {
        $codigo = $data[0];
        $result = $this->db->query("SELECT 
              tb_mesa_partes.mpt_id AS codsolicitud,
              tb_mesa_partes.id_usuario AS codusuario,
              tb_mesa_partes.tmt_id AS codtramite,
              tb_tramites_tipos.tmt_nombre AS tramite,
              tb_mesa_partes.mpt_asunto AS asunto,
              tb_mesa_partes.mpt_contenido as contenido,
              tb_mesa_partes.mpt_tipo_documento AS tipodoc,
              tb_mesa_partes.mpt_ndocumento AS nrodoc,
              tb_mesa_partes.mpt_nombres AS solicitante,
              tb_mesa_partes.mpt_email AS email_personal,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_domicilio as domicilio,
              tb_usuario.usu_email_corporativo as email_corporativo,
              tb_mesa_partes.mpt_telefono AS telefono,
              tb_mesa_partes.mpt_fecha AS fecha,
              tb_mesa_partes.mpt_situacion AS situacion
            FROM
              tb_tramites_tipos
              INNER JOIN tb_mesa_partes ON (tb_tramites_tipos.tmt_id = tb_mesa_partes.tmt_id)
              INNER JOIN tb_usuario ON (tb_mesa_partes.id_usuario = tb_usuario.id_usuario)
            WHERE tb_mesa_partes.mpt_id = ? AND tb_mesa_partes.mpt_anio = ? ",$data);
        $rs['solicitud']=$result->row();
        $result = $this->db->query("SELECT 
            tb_mesa_partes_ruta.mpr_codigo AS codruta,
            tb_mesa_partes_ruta.mpt_codigo AS codsolicitud,
            tb_mesa_partes_ruta.origen_area_id AS codarea_origen,
            tb_area.are_nombre AS area_origen,
            tb_mesa_partes_ruta.origen_usuario_id AS codusuario_origen,
            tb_usuario.usu_nick AS usuario_origen,
            tb_mesa_partes_ruta.destino_area_id AS codarea_destino,
            tb_area1.are_nombre AS area_destino,
            tb_mesa_partes_ruta.destino_usuario_id AS codusuario_destino,
            tb_usuario1.usu_nick as usuario_destino ,
            tb_mesa_partes_ruta.mpr_descripcion AS descripcion,
            tb_mesa_partes_ruta.mpr_situacion AS situacion_ruta,
            tb_mesa_partes_ruta.mpr_fecha AS fecha,
            tb_mesa_partes_ruta.mpr_fecha_procesado AS fecha_p
          FROM
            tb_mesa_partes_ruta
            LEFT OUTER JOIN tb_area ON (tb_area.are_codigo = tb_mesa_partes_ruta.origen_area_id)
            LEFT OUTER JOIN tb_usuario ON (tb_mesa_partes_ruta.origen_usuario_id = tb_usuario.id_usuario)
            LEFT OUTER JOIN tb_area tb_area1 ON (tb_mesa_partes_ruta.destino_area_id = tb_area1.are_codigo)
            LEFT OUTER JOIN tb_usuario tb_usuario1 ON (tb_mesa_partes_ruta.destino_usuario_id = tb_usuario1.id_usuario)
            WHERE tb_mesa_partes_ruta.mpt_codigo=$codigo ORDER BY tb_mesa_partes_ruta.mpr_fecha asc");
        $rs['ruta']=$result->result();
        $result = $this->db->query("SELECT 
                `incp_id` as codadjunto,
                `inc_id` as codruta,
                `incp_titulo` as titulo,
                `incp_archivo` as archivo,
                `incp_peso` as peso,
                `incp_tipo` as tipo,
                `incp_fecha_creado` as creado,
                `incp_link` as link,
                `inc_mpcod` as codsolicitud
              FROM 
                `tb_mesa_partes_archivos` 
              WHERE inc_mpcod=$codigo AND inc_id  IS NOT NULL");
        $rs['adjuntos']=$result->result();

        return $rs;
    }

    public function getusuarioxcodigo($codigo)
    {
      $result = $this->db->query("SELECT 
                tb_usuario.usu_email_corporativo as emailus,
                tb_persona.per_apel_paterno as paterno,
                tb_persona.per_apel_materno as materno,
                tb_persona.per_nombres as nombres
                FROM tb_usuario
                INNER JOIN tb_persona ON (tb_usuario.cod_persona = tb_persona.per_codigo)
                WHERE tb_usuario.id_usuario = ? LIMIT 1",$codigo);
      return $result->row();
    }

}
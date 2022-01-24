<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mincidencias extends CI_Model {

	function __construct() {
           parent::__construct();
           $this->load->helper("url");          
    }

    public function insert_datos_incidencia($data){

        $this->db->query("CALL `sp_tb_incidencias_insert`(?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return $res->row();    
    }

    public function insert_pruebas_incidencia($data){
        //CALL `sp_tb_incidencia_pruebas_insert`( @vinc_id, @vincp_titulo, @vincp_link, @vincp_archivo, @vincp_peso, @vincp_tipo, @s);
        $this->db->query("CALL `sp_tb_incidencia_pruebas_insert`(?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_dtsIncidencia($data)
    {
      $result = $this->db->query("SELECT 
            tb_incidencias.inc_id id,
            tb_incidencias.id_usuario usuario,
            tb_incidencias.inc_nombres nombres,
            tb_incidencias.inc_dni documento,
            tb_incidencias.inc_domicilio domicilio,
            tb_incidencias.inc_distrito distrito,
            tb_incidencias.inc_incidencia asunto,
            tb_incidencias.inc_detalle detalle,
            tb_incidencias.inc_declara declara,
            tb_incidencias.inc_estado estado,
            tb_incidencias.inc_fecha fecha
          FROM
            tb_incidencias 
         
          WHERE tb_incidencias.inc_id = ? ", $data);
          $arrayName['detalle']= $result->row();
          $result = $this->db->query("SELECT 
            `incp_id` as codprueba,
            `inc_id` as codincidencia,
            `incp_titulo` as titulo,
            `incp_archivo` as archivo,
            `incp_peso` as peso,
            `incp_tipo` as tipo,
            `incp_link` as link
          FROM 
            `tb_incidencia_pruebas` 
          WHERE inc_id = ? ", $data);
         $arrayName['pruebas']= $result->result();
         return $arrayName;
    }

    public function m_get_incidencia_pdf($data)
    {
      $result = $this->db->query("SELECT 
            tb_incidencias.inc_id id,
            tb_incidencias.id_usuario usuario,
            tb_incidencias.inc_nombres nombres,
            tb_incidencias.inc_dni documento,
            tb_incidencias.inc_tipodoc as tipodoc,
            tb_incidencias.inc_domicilio domicilio,
            tb_incidencias.inc_distrito distrito,
            tb_incidencias.inc_incidencia asunto,
            tb_incidencias.inc_detalle detalle,
            tb_incidencias.inc_declara declara,
            tb_incidencias.inc_fecha fecha
          FROM
            tb_incidencias 
         
          WHERE tb_incidencias.inc_id = ? ", $data);
        $arrayName['incidencia'] =$result->row();
        $result = $this->db->query("SELECT 
            `incp_titulo` as titulo
          FROM 
            `tb_incidencia_pruebas` 
          WHERE inc_id = ? ", $data);
        $arrayName['pruebas'] =$result->result();
        return $arrayName;
    }


    public function m_dtsIncidenciaxid($data)
    {
      $result = $this->db->query("SELECT 
            tb_incidencias.inc_id id,
            tb_incidencias.id_usuario usuario,
            tb_incidencias.inc_nombres nombres,
            tb_incidencias.inc_dni documento,
            tb_incidencias.inc_domicilio domicilio,
            tb_incidencias.inc_distrito distrito,
            tb_incidencias.inc_incidencia asunto,
            tb_incidencias.inc_detalle detalle,
            tb_incidencias.inc_declara declara,
            tb_incidencias.inc_estado estado,
            tb_incidencias.inc_fecha fecha
          FROM
            tb_incidencias
          -- LEFT JOIN tb_incidencia_pruebas ON (tb_incidencias.inc_id = tb_incidencia_pruebas.inc_id) 
          WHERE tb_incidencias.id_usuario = ? ORDER BY tb_incidencias.inc_fecha DESC", $data);
        return $result->result();
    }

    public function m_dtsIncid_respuesta($data)
    {
      $result = $this->db->query("SELECT 
            tb_incidencias_respuesta.rpt_id id,
            tb_incidencias_respuesta.rpt_respuesta respuesta,
            tb_incidencias_respuesta.inc_id id_inc,
            tb_incidencias_respuesta.rpt_fecha fecha
          FROM
            tb_incidencias_respuesta
          WHERE tb_incidencias_respuesta.inc_id = ? LIMIT 1", $data);
        return $result->row();
    }

    public function m_dtsIncid_search($data)
    {
      /*if ($data[0] != "" && $data[1] == "" && $data[2] == "") {
        $result = $this->db->query("SELECT 
            tb_incidencias.inc_id id,
            tb_incidencias.id_usuario usuario,
            tb_incidencias.inc_nombres nombres,
            tb_incidencias.inc_dni documento,
            tb_incidencias.inc_domicilio domicilio,
            tb_incidencias.inc_distrito distrito,
            tb_incidencias.inc_incidencia asunto,
            tb_incidencias.inc_detalle detalle,
            tb_incidencias.inc_declara declara,
            tb_incidencias.inc_estado estado,
            tb_incidencias.inc_fecha fecha
          FROM
            tb_incidencias
          WHERE tb_incidencias.inc_nombres LIKE ? ORDER BY tb_incidencias.inc_id DESC", $data[0]);
      } 
      else if ($data[0] != "" && $data[1] != "" && $data[2] != "") {*/
        $result = $this->db->query("SELECT 
            tb_incidencias.inc_id id,
            tb_incidencias.id_usuario usuario,
            tb_incidencias.inc_nombres nombres,
            tb_incidencias.inc_dni documento,
            tb_incidencias.inc_domicilio domicilio,
            tb_incidencias.inc_distrito distrito,
            tb_incidencias.inc_incidencia asunto,
            tb_incidencias.inc_detalle detalle,
            tb_incidencias.inc_declara declara,
            tb_incidencias.inc_estado estado,
            tb_incidencias.inc_fecha fecha
          FROM
            tb_incidencias
          WHERE tb_incidencias.inc_nombres LIKE ? AND tb_incidencias.inc_incidencia like ? AND tb_incidencias.inc_fecha BETWEEN ? AND ? 
          ORDER BY tb_incidencias.inc_fecha DESC", $data);
      //}

      return $result->result();
    }

    public function m_emailuser($data)
    {
      $result = $this->db->query("SELECT 
            tb_usuario.usu_email_corporativo AS ecorporativo,
            tb_usuario.id_usuario AS idusuario
          FROM
            tb_usuario
          WHERE tb_usuario.id_usuario = ? LIMIT 1 ", $data);
      return $result->row();
    }

    public function insert_respuesta_incidencia($data){

        $this->db->query("CALL `sp_tb_incidencias_respuesta_insert`(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }
    
    public function m_updatestatus($data)
    {
      $result = $this->db->query("UPDATE tb_incidencias SET inc_estado = ? WHERE inc_id = ?", $data);
      return 1;
    }


}
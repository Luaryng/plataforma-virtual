<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpagante extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
    }
	
	public function m_get_pagantes($data){
        $resultdoce = $this->db->query("SELECT 
              tb_pagante.pg_id AS id,
              tb_pagante.pg_codpagante AS codpagante,
              tb_pagante.pg_tipopag AS tipo,
              tb_pagante.pg_personeria AS personeria,
              tb_pagante.pg_tipo_doc AS tipodoc,
              tb_pagante.pg_dni_ruc AS nrodoc,
              tb_pagante.pg_razon_social AS razonsocial,
              tb_pagante.pg_correo1 AS correo1,
              tb_pagante.pg_correo2 AS correo2,
              tb_pagante.pg_correo_corp AS correo_corp,
              tb_pagante.pg_direccion AS direccion,
              tb_pagante.coddistrito,
              tb_distrito.dis_nombre AS distrito,
              tb_provincia.prv_nombre AS provincia,
              tb_departamento.dep_nombre AS departamento
            FROM
              tb_distrito
              INNER JOIN tb_pagante ON (tb_distrito.dis_codigo = tb_pagante.coddistrito)
              INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
              INNER JOIN tb_departamento ON (tb_departamento.dep_codigo = tb_provincia.cod_departamento)
            WHERE tb_pagante.pg_habilitado='SI' AND tb_pagante.pg_tipo_doc =? AND tb_pagante.pg_dni_ruc=? 
            ORDER BY razonsocial ASC LIMIT 6 ", $data);
        return $resultdoce->result();
    }

    


    public function m_filtrar_pagante($data){
        $result = $this->db->query("SELECT 
        tb_pagante.pg_id AS id,
        tb_pagante.pg_codpagante AS codpagante,
        tb_pagante.pg_tipopag AS tipo,
        tb_pagante.pg_personeria AS personeria,
        tb_pagante.pg_tipo_doc AS tipodoc,
        tb_pagante.pg_dni_ruc AS nrodoc,
        tb_pagante.pg_razon_social AS razonsocial,
        tb_pagante.pg_correo1 AS correo1,
        tb_pagante.pg_correo2 AS correo2,
        tb_pagante.pg_correo_corp AS correo_corp,
        tb_pagante.pg_direccion AS direccion,
        tb_pagante.coddistrito,
        tb_distrito.dis_nombre AS distrito,
        tb_provincia.prv_nombre AS provincia,
        tb_departamento.dep_nombre AS departamento
      FROM
        tb_distrito
        INNER JOIN tb_pagante ON (tb_distrito.dis_codigo = tb_pagante.coddistrito)
        INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        INNER JOIN tb_departamento ON (tb_departamento.dep_codigo = tb_provincia.cod_departamento)
      WHERE CONCAT(tb_pagante.pg_dni_ruc,tb_pagante.pg_razon_social) like ? 
      ORDER BY razonsocial ASC LIMIT 6 ",$data);

        return $result->result();
    }

    public function get_datos_pagante_xdni($data){
        $result=$this->db->query("SELECT 
            tb_persona.per_codigo AS idpersona,
            tb_persona.per_codigo_sec AS codpersona,
            tb_persona.per_tipodoc AS tipodoc,
            tb_persona.per_dni AS numero,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_estadocivil as estadocivil,
            tb_persona.per_sexo AS sexo,
            tb_persona.per_fecha_nacimiento AS fecnac,
            tb_persona.per_celular AS celular,
            tb_persona.per_telefono AS telefono,
            tb_persona.per_celular2 as celular2,
            tb_persona.per_email_personal AS epersonal,
            tb_persona.per_domicilio AS domicilio,
            tb_persona.cod_distrito AS coddistrito,
            tb_distrito.cod_provincia AS codprovincia,
            tb_provincia.cod_departamento AS coddepartamento,
            tb_persona.per_domicilio_secundario AS domiciliosecu,
            tb_persona.per_foto AS foto,
            tb_persona.per_trabaja as statrab,
            tb_persona.per_lugar_trabaja as lugar_trab,
            tb_persona.ins_colegio_5to_sec as colsecund,
            tb_persona.per_padre_apel_paterno as apepapa,
            tb_persona.per_madre_apel_paterno as apemama,
            tb_persona.cod_pais as pais,
            tb_usuario.usu_nick as usuario,
            tb_usuario.usu_email_corporativo as einstitucional,
            tb_usuario.usu_nivel as nivel,
            tb_usuario.area_id as codarea,
            tb_usuario.usu_tipo as tipo
          FROM
            tb_persona
            INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
            INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
            LEFT OUTER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
          WHERE
            tb_persona.per_dni = ?;",$data);
        $rsdata=$result->row();
        return   $rsdata;  
    }

    public function m_get_pagante_search($data){
      $result = $this->db->query("SELECT 
        tb_pagante.pg_id AS id,
        tb_pagante.pg_codpagante AS codpagante,
        tb_pagante.pg_tipopag AS tipo,
        tb_pagante.pg_personeria AS personeria,
        tb_pagante.pg_tipo_doc AS tipodoc,
        tb_pagante.pg_dni_ruc AS nrodoc,
        tb_pagante.pg_razon_social AS razonsocial,
        tb_pagante.pg_correo1 AS correo1,
        tb_pagante.pg_correo2 AS correo2,
        tb_pagante.pg_correo_corp AS correo_corp,
        tb_pagante.pg_direccion AS direccion,
        tb_pagante.pg_telefono as telefono,
        tb_pagante.pg_celular as celular,
        tb_pagante.coddistrito,
        tb_distrito.dis_nombre AS distrito,
        tb_provincia.prv_nombre AS provincia,
        tb_departamento.dep_nombre AS departamento
      FROM
        tb_distrito
        INNER JOIN tb_pagante ON (tb_distrito.dis_codigo = tb_pagante.coddistrito)
        INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        INNER JOIN tb_departamento ON (tb_departamento.dep_codigo = tb_provincia.cod_departamento)
      WHERE CONCAT(tb_pagante.pg_dni_ruc,tb_pagante.pg_razon_social) like ? LIMIT 30",$data);

        return $result->result();
    }


 

    public function m_get_pagante_xcodigo($data){
        $result = $this->db->query("SELECT 
                  tb_pagante.pg_id as id,
                  tb_pagante.pg_codpagante as usuario,
                  tb_pagante.pg_tipopag as tipag,
                  tb_pagante.pg_personeria as personeria,
                  tb_pagante.pg_tipo_doc as tipdoc,
                  tb_pagante.pg_dni_ruc as ruc,
                  tb_pagante.pg_razon_social as rsocial,
                  tb_pagante.pg_apellidos as apellidos,
                  tb_pagante.pg_nombres as nombres,
                  tb_pagante.pg_correo1 as epersonal,
                  tb_pagante.pg_correo2 as email2,
                  tb_pagante.pg_correo_corp as einstitucional,
                  tb_pagante.pg_direccion as domicilio,
                  tb_pagante.coddistrito as coddistrito,
                  tb_distrito.dis_nombre AS distrito,
                  tb_pagante.pg_telefono as telefono,
                  tb_pagante.pg_celular as celular,
                  tb_distrito.cod_provincia AS codprovincia,
                  tb_provincia.cod_departamento AS coddepartamento
                FROM
                  tb_pagante
                  INNER JOIN tb_distrito ON (tb_pagante.coddistrito = tb_distrito.dis_codigo)
                  INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
                WHERE tb_pagante.pg_id = ? LIMIT 1", $data);

        return $result->row();
    }

    public function m_get_item_lista($data)
    {
      $items = "";
        if ($data[0] != "" AND $data[1] == "") {
            $items = "WHERE tb_gestion.gt_codigo like '$data[0]%'";
        } else if ($data[0] == "" AND $data[1] != "") {
            $items = "WHERE tb_gestion.gt_nombre like '%$data[1]%'";
        } else if ($data[0] != "" AND $data[1] != "") {
            $items = "WHERE tb_gestion.gt_codigo like '$data[0]%' AND tb_gestion.gt_nombre like '%$data[1]%'";
        }

        $result = $this->db->query("SELECT 
                  tb_gestion.gt_codigo as codigo,
                  tb_gestion.gt_nombre as nombre,
                  tb_gestion.gt_categoria as categoria,
                  tb_gestion.gt_importe as importe,
                  tb_gestion.gt_tipo as tipo,
                  tb_gestion.gt_facturar_como as fcomo
                FROM
                  tb_gestion
                $items ORDER BY tb_gestion.gt_codigo DESC");

        return $result->result();
    }

    public function mInsert_pagante($data){
        $this->db->query("CALL `sp_tb_pagante_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return $res->row();
    }

    public function mUpdate_pagante($items){
        $this->db->query("CALL `sp_tb_pagante_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return   $res->row();    
    }

    public function m_filtrar_itemxcodigo($codigo){
        $result = $this->db->query("SELECT 
          tb_tramites_tipos.tmt_id  as codigo,
          tb_tramites_tipos.tmt_nombre as nombre,
          tb_tramites_tipos.tmt_eliminado as eliminado
        FROM
          tb_tramites_tipos
        WHERE tb_tramites_tipos.tmt_id = ? LIMIT 1 ", $codigo);

        return $result->row();
    }

    public function m_eliminaitem($data){
        
        $qry = $this->db->query("UPDATE tb_tramites_tipos SET tmt_eliminado = ? WHERE tmt_id = ? ", $data);
        // $qry = $this->db->query("DELETE FROM tb_tramites_tipos WHERE tmt_id = ? ", $codigo);
        
        return 1;
    }

    public function m_eliminacliente($data)
    {
        
        $qry = $this->db->query("DELETE FROM tb_pagante WHERE pg_id = ? ", $data);
        return 1;
    }

}
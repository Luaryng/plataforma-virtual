<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbiblioteca extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

   public function m_get_autores()
    {
        $result = $this->db->query("SELECT `aut_id` as id, `aut_nombre` as nombre FROM `tb_autores` ORDER BY `aut_nombre` ASC");
        return $result->result();
    }

    public function m_get_editorial()
    {
        $result = $this->db->query("SELECT `edi_id` as id, `edi_nombre` as nombre FROM `tb_editorial` ORDER BY `edi_nombre` ASC");
        return $result->result();
    }

    public function insert_datos_libros($data){

        $this->db->query("CALL `sp_tb_libros_insert`(?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function insert_datos_ejemplares($data){

        $this->db->query("CALL `sp_tb_ejemplares_insert`(?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_historial_libros($nomlib)
    {
        $result = $this->db->query("SELECT
                  tb_libros.lib_id as codigo, 
                  tb_libros.lib_nombre as nombre,
                  tb_autores.aut_nombre as aunom,
                  tb_editorial.edi_nombre as ednom,
                  tb_libros.lib_anio as anio,
                  COUNT(tb_ejemplares.ejem_id) AS nroejem
                FROM
                  tb_libros
                  INNER JOIN tb_ejemplares ON (tb_libros.lib_id = tb_ejemplares.lib_id)
                  INNER JOIN tb_autores ON (tb_libros.aut_id = tb_autores.aut_id)
                  INNER JOIN tb_editorial ON (tb_libros.edi_id = tb_editorial.edi_id)
                WHERE
                  tb_libros.lib_nombre like ?
                GROUP BY
                  tb_libros.lib_id,
                  tb_libros.lib_nombre,
                  tb_libros.aut_id,
                  tb_autores.aut_nombre,
                  tb_libros.edi_id,
                  tb_editorial.edi_nombre,
                  tb_libros.lib_anio
                ORDER BY 
                  tb_libros.lib_nombre ASC", $nomlib);
        return $result->result();
    }

    public function m_librosxcodigo($codlib)
    {
      $rslib = array();
      $result = $this->db->query("SELECT
                tb_libros.lib_id as codigo, 
                tb_libros.lib_nombre as nombre,
                tb_libros.aut_id as idaut,
                tb_autores.aut_nombre as aunom,
                tb_libros.edi_id as idedi,
                tb_editorial.edi_nombre as ednom,
                tb_libros.lib_anio as anio
              FROM
                tb_editorial
                INNER JOIN tb_libros ON (tb_editorial.edi_id = tb_libros.edi_id)
                INNER JOIN tb_autores ON (tb_libros.aut_id = tb_autores.aut_id)
              WHERE
                tb_libros.lib_id = ?", $codlib);
      $rslib = $result->row();
      return array('dlibros' => $rslib);
    }

    public function update_datos_libros($data){

        $this->db->query("CALL `sp_tb_libros_update`(?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_elimina_lib($idlibr)
    {
        $qry = $this->db->query("DELETE FROM tb_libros where lib_id=?", $idlibr);
        $this->db->close();
        return 1;
    }

    public function m_historial_ejemplares($codlib)
    {
        $result = $this->db->query("SELECT
                  tb_libros.lib_nombre as nombre,
                  tb_ejemplares.ejem_id as codigo,
                  tb_ejemplares.lib_id as codilib,
                  tb_ejemplares.lib_link as link,
                  tb_ejemplares.lib_paginas as pag,
                  tb_ejemplares.estado as est,
                  tb_ejemplares.ubicacion as ubic,
                  tb_ejemplares.situacion as situa,
                  tb_ejemplares.fisico as fisc
                FROM
                  tb_ejemplares
                  INNER JOIN tb_libros ON (tb_ejemplares.lib_id = tb_libros.lib_id)
                WHERE
                  tb_ejemplares.lib_id = ?
                ORDER BY 
                  tb_ejemplares.ejem_id ASC", $codlib);
        return $result->result();
    }

    public function m_ejemplaresxcodigo($codejm)
    {
      $rsejm = array();
      $result = $this->db->query("SELECT
                tb_ejemplares.ejem_id as codigo,
                tb_ejemplares.lib_id as codilib,
                tb_ejemplares.lib_link as link,
                tb_ejemplares.lib_paginas as pag,
                tb_ejemplares.estado as est,
                tb_ejemplares.ubicacion as ubic,
                tb_ejemplares.situacion as situa,
                tb_ejemplares.fisico as fisc,
                tb_ejemplares.procedencia as proc,
                tb_ejemplares.fechacompra as fecom,
                tb_ejemplares.Nro_Documento as ndoc,
                tb_ejemplares.precio_unit as prec,
                tb_ejemplares.orden_compra as comp
              FROM
                tb_ejemplares
              WHERE
                tb_ejemplares.ejem_id = ?", $codejm);
      $rsejm = $result->row();
      return array('dejempl' => $rsejm);
    }

    public function update_datos_ejemplares($data){

        $this->db->query("CALL `sp_tb_ejemplares_update`(?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_elimina_ejm($idejm)
    {
        $qry = $this->db->query("DELETE FROM tb_ejemplares where ejem_id=?", $idejm);
        $this->db->close();
        return 1;
    }

    public function m_search_libro($nomlib)
    {
      $result = $this->db->query("SELECT 
                tb_libros.lib_id as id,
                tb_libros.lib_nombre as nombre,
                tb_autores.aut_nombre as autor,
                tb_editorial.edi_nombre as editorial,
                tb_libros.lib_anio as anio,
                tb_ejemplares.lib_link as link,
                tb_ejemplares.lib_paginas as npag,
                tb_ejemplares.estado as estado,
                tb_ejemplares.ubicacion as ubic,
                tb_ejemplares.situacion as situa,
                tb_ejemplares.fisico as fisc,
                tb_ejemplares.procedencia as proced,
                tb_ejemplares.fechacompra as compra,
                tb_ejemplares.Nro_Documento as doc,
                tb_ejemplares.precio_unit as precio,
                tb_ejemplares.orden_compra as orcomp
              FROM
                tb_editorial
                INNER JOIN tb_libros ON (tb_editorial.edi_id = tb_libros.edi_id)
                INNER JOIN tb_autores ON (tb_libros.aut_id = tb_autores.aut_id)
                INNER JOIN tb_ejemplares ON (tb_libros.lib_id = tb_ejemplares.lib_id)
              WHERE
                tb_ejemplares.situacion='DISPONIBLE' AND tb_libros.lib_nombre LIKE ? 
              ORDER BY
                tb_libros.lib_nombre ASC", $nomlib);
      return $result->result();
    }
    
}
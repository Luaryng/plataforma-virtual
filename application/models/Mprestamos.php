<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mprestamos extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_busca_alumno($carnet)
    {
        $result = $this->db->query("SELECT 
                  tb_inscripcion.ins_identificador as idins,
                  tb_inscripcion.ins_carnet as carnet,
                  tb_persona.per_codigo as idpersona,
                  tb_persona.per_apel_paterno as paterno,
                  tb_persona.per_apel_materno as materno,
                  tb_persona.per_nombres as nombres
                FROM
                  tb_persona
                  INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                WHERE
                  tb_inscripcion.ins_carnet = ? limit 1", $carnet);
        
        return $result->row();
    }

    public function insert_datos_prestamos($data){

        $this->db->query("CALL `sp_tb_prestamos_insert`(?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_busca_prestamoxcarnet($carnet)
    {
        $result = $this->db->query("SELECT 
                  tb_persona.per_apel_paterno as paterno,
                  tb_persona.per_apel_materno as materno,
                  tb_persona.per_nombres as nombres,
                  tb_persona.per_codigo as idpersona,
                  tb_prestamo_libro.pre_id as idpre,
                  tb_prestamo_libro.carnet as carnet,
                  tb_prestamo_libro.ejem_id as idejm,
                  tb_prestamo_libro.estado as estado,
                  tb_prestamo_libro.fecha_prestamo as fecpres,
                  tb_prestamo_libro.fecha_devolucion_limite as feclim,
                  tb_prestamo_libro.fecha_devolucion as fecdev,
                  tb_prestamo_libro.obs_entrega as obsent,
                  tb_prestamo_libro.obs_devolucion as obsdev,
                  tb_libros.lib_nombre as nombre
                FROM
                  tb_persona
                  INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
                  INNER JOIN tb_prestamo_libro ON (tb_inscripcion.ins_identificador = tb_prestamo_libro.ins_cod)
                  INNER JOIN tb_ejemplares ON (tb_prestamo_libro.ejem_id = tb_ejemplares.ejem_id)
                  INNER JOIN tb_libros ON (tb_ejemplares.lib_id = tb_libros.lib_id)
                WHERE
                  tb_inscripcion.ins_carnet = ? ", $carnet);
        return $result->result();
    }

    public function contar_libros_prestados($carnet)
    {
        $result = $this->db->query("SELECT
                  * FROM 
                   tb_prestamo_libro 
                  WHERE 
                   carnet=? AND fecha_devolucion IS NUll", $carnet);
        return $result->result();
    }

    public function m_prestamoxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
                  tb_prestamo_libro.pre_id as idpre,
                  tb_prestamo_libro.carnet as carnet,
                  tb_prestamo_libro.ejem_id as idejm,
                  tb_prestamo_libro.estado as estado,
                  tb_prestamo_libro.fecha_prestamo as fecpres,
                  tb_prestamo_libro.fecha_devolucion_limite as feclim,
                  tb_prestamo_libro.fecha_devolucion as fecdev,
                  tb_prestamo_libro.obs_entrega as obsent,
                  tb_prestamo_libro.obs_devolucion as obsdev
                FROM
                  tb_prestamo_libro
                WHERE
                  tb_prestamo_libro.pre_id = ? ", $codigo);
        return $result->result();
    }

    public function update_datos_prestamos($data){

        $this->db->query("CALL `sp_tb_prestamos_update`(?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

}
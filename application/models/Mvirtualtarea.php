<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mvirtualtarea extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_tarea_entregada($data)
    {
        $result = $this->db->query("SELECT 
            vita_id as codtarea,
            vita_entrega as fentrega,
            vita_detalle as detalle,
            vita_nro_archivos as narchivos,
            vita_editar as editar,
            vita_nota  as nota ,
            vita_observacion as observacion 
          FROM
            tb_virtual_tarea_alumno
            WHERE virt_id=? AND miembro_id=? LIMIT 1",$data);
        return $result->row();
    }

    public function m_get_tareas_entregadas($data)
    {
        $result = $this->db->query("SELECT 
            vita_id as codtarea,
            vita_entrega as fentrega,
            vita_detalle as detalle,
            vita_nro_archivos as narchivos,
            vita_editar as editar,
            vita_nota  as nota,
            miembro_id as codmiembro,
            vita_observacion as observacion 
          FROM
            tb_virtual_tarea_alumno
            WHERE virt_id=?",$data);
        return $result->result();
    }

    


    public function m_get_detalles_x_tarea($data)
    {
      $result = $this->db->query("SELECT
        vdet_id as coddetalle, 
        `vdet_nombre` as nombre,
        `vdet_link` as link,
        `vdet_peso` as peso,
        `vdet_tipo` as tipo
      FROM 
        `tb_virtual_tarea_detalle` 
      WHERE virt_id=?",$data);
        return $result->result();
    }

    public function m_get_detalles_x_material($data)
    {
      $result = $this->db->query("SELECT 
        tb_virtual_tarea_alumno.virt_id AS codmaterial,
        tb_virtual_tarea_alumno.vita_id AS codentrega,
        tb_virtual_tarea_detalle.vdet_id AS coddetalle,
        tb_virtual_tarea_alumno.miembro_id as codmiembro,
        tb_virtual_tarea_detalle.vdet_nombre AS nombre,
        tb_virtual_tarea_detalle.vdet_link AS link,
        tb_virtual_tarea_detalle.vdet_peso AS peso,
        tb_virtual_tarea_detalle.vdet_tipo AS tipo
      FROM
        tb_virtual_tarea_alumno
        INNER JOIN tb_virtual_tarea_detalle ON (tb_virtual_tarea_alumno.vita_id = tb_virtual_tarea_detalle.virt_id)
      WHERE tb_virtual_tarea_alumno.virt_id=?",$data);
        return $result->result();
    }
    

     public function m_insert($data){
      //CALL ``( @vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion, @s);
      $this->db->query("CALL `sp_tb_virtual_tarea_alum_insert`(?,?,?,?,?,?,?,@s,@nid)", $data);
      $res = $this->db->query('select @s as salida, @nid as nid');
      return $res->row();
    }
    
    public function m_update($data){
      $this->db->query("CALL `sp_tb_virtual_tarea_alum_update`(?,?,?,?,?,?,@s)", $data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }

    
    public function m_delete($data){
      $this->db->query("DELETE FROM `tb_virtual_tarea_alumno`  WHERE  `vita_id` = ?", $data);
      return 1;
    }

    public function m_tarea_entregada_delete_detalle($data){
      $this->db->query("DELETE FROM  `tb_virtual_tarea_detalle` WHERE  `vdet_id` = ?", $data);
      return 1;
    }

    public function m_insert_detalle($data){
      //CALL ``( @virt_id, @vvirt_link, @vvirt_nombsre, @vcodigocarga, @vcodigosubseccion, @`s`);
      $this->db->query("CALL `sp_tb_virt_detalle_tarea_insert`(?,?,?,?,?,?,?,@s)", $data);
      $res = $this->db->query('select @s as out_param');
      return $res->row()->out_param;
    }

    public function m_calificar($data){
      $this->db->query("CALL `sp_tb_virtual_tarea_alum_calificar`(?,?,?,?,?,?,?,@s,@nid)", $data);
      $res = $this->db->query('select @s as salida, @nid as nid');
      return $res->row();
    }
    


}
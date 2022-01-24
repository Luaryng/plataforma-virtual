<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mcarrera_web extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

  /*public function m_lst_iconos()
  {
        $result = $this->db->query("SELECT 
            tb_iconos.ico_id id,
                tb_iconos.ico_desc deta
              FROM
                tb_iconos");
        return $result->result();
  }*/
  public function m_get_carreras($data)
  {
    $result = $this->db->query("SELECT 
        tb_carrera_web.carw_id AS codcarweb,
        tb_carrera_web.car_id AS codcarrera,
        tb_carrera_web.carw_presentacion AS presentacion,
        tb_carrera_web.carw_contenido AS contenido,
        tb_carrera_web.carw_url as url,
        tb_carrera_web.sede_id AS codsede,
        tb_carrera.car_nombre as nombre,
        tb_carrera.car_abierta as abierta,
        tb_carrera.car_nivel_formativo as nivel
      FROM
        tb_carrera
        INNER JOIN tb_carrera_web ON (tb_carrera.car_id = tb_carrera_web.car_id)
            WHERE tb_carrera.car_activo='SI' AND tb_carrera_web.sede_id=?;",$data);
    return $result->result();
  }

  public function m_get_carrera($data)
  {
    $result = $this->db->query("SELECT 
        tb_carrera_web.carw_id AS codcarweb,
        tb_carrera_web.car_id AS codcarrera,
        tb_carrera_web.carw_url AS url,
        tb_carrera_web.carw_presentacion AS presentacion,
        tb_carrera_web.carw_contenido AS contenido,
        tb_carrera_web.carw_titulo AS titulo,
        tb_carrera_web.carw_duracion AS duracion,
          tb_carrera_web.carw_perfil AS perfil,
  tb_carrera_web.carw_curricula AS curricula,
  tb_carrera_web.carw_requisitos AS requisitos,
        tb_carrera_web.sede_id AS codsede,
        tb_carrera.car_nombre as nombre,
        tb_carrera.car_abierta as abierta,
        tb_carrera.car_nivel_formativo as nivel
      FROM
        tb_carrera
        INNER JOIN tb_carrera_web ON (tb_carrera.car_id = tb_carrera_web.car_id)
            WHERE tb_carrera.car_activo='SI' AND tb_carrera_web.carw_id=? AND tb_carrera_web.sede_id=?;",$data);
    return $result->row();
  }

  public function m_update($data){
    //CALL `sp_tb_carrera_web_update`( @vcarw_url, @vcarw_presentacion, @vcarw_contenido, @vcar_id, @vsede_id, @s);
    $this->db->query("CALL `sp_tb_carrera_web_update`(?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row();    
  }

}

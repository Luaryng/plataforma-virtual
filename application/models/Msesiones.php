<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Msesiones extends CI_Model
{
	function __construct()
	{
	   parent::__construct();
	}
	 public function m_sesiones_x_curso($data)
    {
        /////$this->load->database();
        $resultdoce = $this->db->query("SELECT 
          tb_carga_sesiones.ses_id AS id,
          tb_carga_sesiones.ses_nombre AS nombre,
          tb_carga_sesiones.ses_fecha AS fecha,
          tb_carga_sesiones.ses_horaini AS hini,
          tb_carga_sesiones.ses_horafin AS hfin,
          tb_carga_sesiones.ses_nombrecorto AS nombrec,
          tb_carga_sesiones.ses_detalle AS detalle,
          tb_carga_sesiones.ses_tipo AS tipo,
          tb_carga_sesiones.ses_nrosesion AS nrosesion,
          tb_carga_sesiones.sese_idevento as  idevento,
          tb_carga_sesiones.sese_idconferencia as  idconferencia,
          tb_carga_sesiones.sese_hangout_link as  hlink,
          tb_carga_sesiones.sese_status_evento as  status_evento,
          tb_carga_sesiones.sese_status_conferencia as status_conferencia,
          tb_carga_sesiones.sese_archivo as archivo, 
          tb_carga_sesiones.sese_peso as pesof,
          tb_carga_sesiones.sese_tipo as tipof,
          tb_carga_sesiones.sese_link as linkf
        FROM
          tb_carga_sesiones
        WHERE
           tb_carga_sesiones.codigocarga=? AND  tb_carga_sesiones.codigosubseccion=? 
        ORDER BY
          ses_fecha,
          ses_horaini", $data);
        ////$this->db->close();
        return $resultdoce->result();
    }
    public function m_sesiones_x_curso_reg($data)
    {
        /////$this->load->database();
        $resultdoce = $this->db->query("SELECT 
          tb_carga_sesiones.ses_id AS id,
          tb_carga_sesiones.ses_nombre AS nombre,
          tb_carga_sesiones.ses_fecha AS fecha,
          tb_carga_sesiones.ses_horaini AS hini,
          tb_carga_sesiones.ses_horafin AS hfin,
          tb_carga_sesiones.ses_nombrecorto AS nombrec,
          tb_carga_sesiones.ses_detalle AS detalle,
          tb_carga_sesiones.ses_tipo AS tipo,
          tb_carga_sesiones.ses_nrosesion AS nrosesion
        FROM
          tb_carga_sesiones
        WHERE
           tb_carga_sesiones.codigocarga=? AND  tb_carga_sesiones.codigosubseccion=? 
        ORDER BY
          ses_fecha,
          ses_horaini", $data);
        ////$this->db->close();
        return $resultdoce->result();
    }


  public function m_agregar_sesion($data){
    //$this->load->database();    
     //@`vses_fecha`, @`vses_horaini`, @`vses_horafin`, @`vacad`, @`vcodsubseccion`, @`vdetalle`, @`vtipo`, @`vses_nrosesion`, @`s`);
    $this->db->query("CALL `sp_tb_carga_sesion_insert`(?,?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as out_param');
    //$this->db->close(); 
    return   $res->row()->out_param;  
  }

  public function m_editar_sesion($data){
    //$this->load->database();    
    //CALL `paeditar_sesionclase`( @vses_fecha, @vses_horaini, @vses_horafin, @vsesid, @vdetalle, @vtipo, @s);
    $this->db->query("CALL `sp_tb_carga_sesion_update`(?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as out_param');
    //$this->db->close(); 
    return   $res->row()->out_param;
  }

  public function m_eliminar_sesion($data){
    //$this->load->database();    
    //CALL `paeditar_sesionclase`( @vses_fecha, @vses_horaini, @vses_horafin, @vsesid, @vdetalle, @vtipo, @s);
    $this->db->query("CALL `sp_tb_carga_sesiones_delete`(?,@s)",$data);
    $res = $this->db->query('select @s as out_param');
    //$this->db->close(); 
    return   $res->row()->out_param;  
  }


  public function m_update_sesion_evento($data){
    //$this->load->database();    
    //CALL `sp_tb_carga_sesion_evento_update`( @vsese_idevento, @vsese_idconferencia, @vsese_hangout_link, @vsese_status_evento, @vsese_status_conferencia, @vses_id, @`s`);
    $this->db->query("CALL `sp_tb_carga_sesion_evento_update`(?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    //$this->db->close(); 
    return   $res->row();  
  }

  public function m_editar_file($data)
  {
    $this->db->query("CALL `sp_tb_carga_sesion_file_update`(?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as out_param');
    //$this->db->close(); 
    return   $res->row()->out_param;
  }



  public function m_sesion_videoconferiencia_x_id($data){
    //$this->load->database();    
    $resultdoce = $this->db->query("SELECT 
          tb_carga_sesiones.ses_id AS id,
          tb_carga_sesiones.ses_fecha AS fecha,
          tb_carga_sesiones.ses_horaini AS horaini,
          tb_carga_sesiones.ses_horafin AS horafin,
          tb_carga_sesiones.ses_detalle AS detalle,
          tb_carga_sesiones.ses_tipo AS tipo,
          tb_carga_sesiones.ses_nrosesion AS nrosesion,
          tb_carga_sesiones.sese_idevento as  idevento,
          tb_carga_sesiones.sese_idconferencia as  idconferencia,
          tb_carga_sesiones.sese_hangout_link as  halink,
          tb_carga_sesiones.sese_status_evento as  status_evento,
          tb_carga_sesiones.sese_status_conferencia as status_conferencia 
      FROM 
        `tb_carga_sesiones` WHERE `ses_id`=? ;",$data);
    //$this->db->close(); 
    return $resultdoce->row();
  }



  public function m_sesion_x_id($data){
    //$this->load->database();    
    $resultdoce = $this->db->query("SELECT 
      `ses_id`as  id,
        `ses_fecha` as fecha,
        `ses_horaini` as horaini,
        `ses_horafin` as horafin ,
        `ses_detalle` as detalle,
        `ses_tipo` as tipo,
        ses_nrosesion as nrosesion 
      FROM 
        `tb_carga_sesiones` WHERE `ses_id`=? ;",$data);
    //$this->db->close(); 
    return $resultdoce->row();
  }

  public function m_sesiones_completa_x_curso($data)
    {
        /////$this->load->database();
        $resultdoce = $this->db->query("SELECT 
          tb_carga_sesiones.ses_id AS id,
          tb_carga_sesiones.ses_nombre AS nombre,
          tb_carga_sesiones.ses_fecha AS fecha,
          tb_carga_sesiones.ses_horaini AS hini,
          tb_carga_sesiones.ses_horafin AS hfin,
          tb_carga_sesiones.ses_nombrecorto AS nombrec,
          tb_carga_sesiones.ses_detalle AS detalle,
          tb_carga_sesiones.ses_tipo AS tipo,
          tb_carga_sesiones.ses_nrosesion AS nrosesion,
          tb_carga_sesiones.sese_idevento as  idevento,
          tb_carga_sesiones.sese_idconferencia as  idconferencia,
          tb_carga_sesiones.sese_hangout_link as  hlink,
          tb_carga_sesiones.sese_status_evento as  status_evento,
          tb_carga_sesiones.sese_status_conferencia as status_conferencia,
          tb_carga_sesiones.sese_archivo as archivo, 
          tb_carga_sesiones.sese_peso as pesof,
          tb_carga_sesiones.sese_tipo as tipof,
          tb_carga_sesiones.sese_link as linkf
        FROM
          tb_carga_sesiones
        WHERE
           tb_carga_sesiones.codigocarga=? AND  tb_carga_sesiones.codigosubseccion=? 
        ORDER BY
          ses_fecha,
          ses_horaini", $data);
        ////$this->db->close();
        return $resultdoce->result();
    }
  /*public function m_sesion_completa_x_id($data){
  
    $resultdoce = $this->db->query("SELECT 
          tb_carga_sesiones.ses_id AS id,
          tb_carga_sesiones.ses_fecha AS fecha,
          tb_carga_sesiones.ses_horaini AS horaini,
          tb_carga_sesiones.ses_horafin AS horafin,
          tb_carga_sesiones.ses_detalle AS detalle,
          tb_carga_sesiones.ses_tipo AS tipo,
          tb_carga_sesiones.ses_nrosesion AS nrosesion,
          tb_carga_sesiones.sese_idevento as  idevento,
          tb_carga_sesiones.sese_idconferencia as  idconferencia,
          tb_carga_sesiones.sese_hangout_link as  halink,
          tb_carga_sesiones.sese_status_evento as  status_evento,
          tb_carga_sesiones.sese_status_conferencia as status_conferencia 
      FROM 
        `tb_carga_sesiones` WHERE `ses_id`=? ;",$data);
    //$this->db->close(); 
    return $resultdoce->row();
  }*/

    public function m_Inser_sesion_asistencia($data)
    {
      $this->db->query("CALL `sp_tb_carga_sesiones_asistencias_insert`(?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida, @nid as newcod');
      return   $res->row();
    }

	}
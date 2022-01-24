<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Masistencias extends CI_Model
{
	function __construct()
	{
	parent::__construct();
	}
	public function m_fechas_x_curso($data)
    {
        ///////$this->load->database();
        $resultdoce = $this->db->query("SELECT
                  tb_carga_sesiones.ses_fecha fecha,
                  tb_carga_sesiones.ses_horaini inicia,
                  tb_carga_sesiones.ses_id sesion
                FROM
                  tb_carga_sesiones
                WHERE
                  tb_carga_sesiones.codigocarga=? AND  tb_carga_sesiones.codigosubseccion=? 
                 order by tb_carga_sesiones.ses_fecha,tb_carga_sesiones.ses_horaini", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }

    public function m_fechas_x_curso_sesion($data)
    {
        ///////$this->load->database();
        $resultdoce = $this->db->query("SELECT
                  tb_carga_sesiones.ses_fecha fecha,
                  tb_carga_sesiones.ses_horaini inicia,
                  tb_carga_sesiones.ses_id sesion
                FROM
                  tb_carga_sesiones
                WHERE
                  tb_carga_sesiones.ses_id =? ", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }



	 public function m_asistencias_x_curso($data)
    {

        /////$this->load->database();
        $resultdoce = $this->db->query("SELECT
                  tb_carga_asistencia.acu_id id,
                  tb_carga_asistencia.idmiembro  idmiembro,
                  tb_carga_asistencia.acu_fecha fecha,
                  tb_carga_asistencia.acu_accion accion,
                  tb_carga_asistencia.idsesion sesion
                FROM
                  tb_carga_asistencia
                WHERE
                  tb_carga_asistencia.codigocarga=? AND  tb_carga_asistencia.codigosubseccion=? 
                 order by tb_carga_asistencia.acu_fecha,tb_carga_asistencia.idmiembro", $data);
        ////$this->db->close();
        return $resultdoce->result();
    }

     public function m_asistencias_x_curso_sesion($data)
    {
        $resultdoce = $this->db->query("SELECT
                  tb_carga_asistencia.acu_id id,
                  tb_carga_asistencia.idmiembro  idmiembro,
                  tb_carga_asistencia.acu_fecha fecha,
                  tb_carga_asistencia.acu_accion accion,
                  tb_carga_asistencia.idsesion sesion
                FROM
                  tb_carga_asistencia
                WHERE
                  tb_carga_asistencia.idsesion=? ", $data);
        ////$this->db->close();
        return $resultdoce->result();
    }

     public function m_guardar_asistencia($datainsert, $dataupdate)
    {
        /////$this->load->database();
        //CALL `painsertar_asistencia_accion`( @vcca, @vssc, @vfecha, @vidmiembro, @vaccion, @s);
      $idsn=array();
        foreach ($datainsert as $key => $data) {
            //CALL `painsertar_asistencia_accion`( @`vcca`, @`vfecha`, @`vidmiembro`, @`vaccion`, @vidsesion, @`s`);
            $this->db->query("CALL `sp_tb_carga_asistencia_insert`(?,?,?,?,?,?,@s)", array($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]));
            $res = $this->db->query('select @s as out_param');

            $idsn[$data[6]] = $res->row()->out_param;
        }
        $ar['idsnew'] = $idsn;
        foreach ($dataupdate as $key => $data) {
            $this->db->query("CALL `sp_tb_carga_asistencia_accion_update`(?,?,@s)", $data);
        }

        //$res = $this->db->query('select @s as out_param');
        ////$this->db->close();
        return $ar;
    }

	}
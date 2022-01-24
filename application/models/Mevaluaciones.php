<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mevaluaciones extends CI_Model
{
	function __construct()
	{
	parent::__construct();
	}

	public function m_get_indicadores_por_carga_division($data){
        $result = $this->db->query("SELECT 
      `ind_id` as codigo,
      `ind_nroorden` as norden,
      `ind_nombre` as nombre,
      `ind_abierto` as abierto
    FROM 
      `tb_indicador`
     WHERE codigocarga=? AND  codigosubseccion=? ORDER BY ind_nroorden;", $data);
            return   $result->result();
    }


	public function m_eval_head_x_curso($data)
	{
	///////$this->load->database();
	$resultdoce = $this->db->query("SELECT 
				  tb_carga_evaluaciones_head.evh_nombrecorto AS abrevia,
				  tb_carga_evaluaciones_head.evh_id AS evaluacion,
				  tb_carga_evaluaciones_head.evh_tipo AS tipo,
				  tb_carga_evaluaciones_head.evh_formula AS formula,
				  tb_carga_evaluaciones_head.evh_orden AS orden,
				  tb_carga_evaluaciones_head.codigoindicador AS indicador,
				  tb_carga_evaluaciones_head.evh_nombre AS nombre, 
				  tb_carga_evaluaciones_head.evh_nombre_calculo as nombre_calculo,
				  tb_carga_evaluaciones_head.evh_peso_porcentaje as peso 
				FROM 
				  tb_carga_evaluaciones_head 
				WHERE 
				  tb_carga_evaluaciones_head.codigocarga=? AND  tb_carga_evaluaciones_head.codigosubseccion=?  
				ORDER BY tb_carga_evaluaciones_head.codigoindicador,tb_carga_evaluaciones_head.evh_orden", $data);
	//////$this->db->close();
				return $resultdoce->result();
	}
	public function m_notas_x_curso($data)
	{
	/////$this->load->database();
	$resultdoce = $this->db->query("SELECT 
					  tb_carga_evaluaciones.ecu_id AS id,
					  tb_carga_evaluaciones.idmiembro,
					  tb_carga_evaluaciones.ecu_nota AS nota,
					  tb_carga_evaluaciones.idevaluacionhead evaluacion
					FROM
					  tb_carga_evaluaciones
					WHERE
						tb_carga_evaluaciones.codigocarga=? AND  tb_carga_evaluaciones.codigosubseccion=? 
					order by tb_carga_evaluaciones.idmiembro, tb_carga_evaluaciones.idevaluacionhead", $data);
	////$this->db->close();
	return $resultdoce->result();
	}

	public function m_notas_x_curso_por_alumno($data)
	{
	/////$this->load->database();
		$resultdoce = $this->db->query("SELECT 
					  tb_carga_evaluaciones.ecu_id AS id,
					  tb_carga_evaluaciones.idmiembro,
					  tb_carga_evaluaciones.ecu_nota AS nota,
					  tb_carga_evaluaciones.idevaluacionhead evaluacion
					FROM
					  tb_carga_evaluaciones
					WHERE
						tb_carga_evaluaciones.codigocarga=? AND  tb_carga_evaluaciones.codigosubseccion=? and tb_carga_evaluaciones.idmiembro=?  
					order by tb_carga_evaluaciones.idmiembro, tb_carga_evaluaciones.idevaluacionhead", $data);
		return $resultdoce->result();
	}

	public function m_guardar_nota($datainsert, $dataupdate)
    {
        /////$this->load->database();
        $ar['rpta']   = array();
        $ar['idsnew'] = array();
        $idsn[] = array();
        foreach ($datainsert as $key => $data) {
        	//CALL ``( @`vcca`, @`vsubseccion`, @`vidmiembro`, @`vecu_nota`, @`videvaluacionhead`, @`s`);
            $this->db->query("CALL `sp_tb_carga_evaluaciones_insert`(?,?,?,?,?,@s)", array($data[0], $data[1], $data[2], $data[3], $data[4]));
            $res = $this->db->query('select @s as out_param');

            $idsn[$data[5]] = $res->row()->out_param;
        }
        $ar['idsnew'] = $idsn;
        foreach ($dataupdate as $key => $data1) {
            $this->db->query("CALL `sp_tb_carga_evaluaciones_update`(?,?,@s)", $data1);
            $res = $this->db->query('select @s as out_param');

            //$idsn[$data1[0]] = $res->row()->out_param;
            /*$res = $this->db->query('select @s as out_param');
        $res->row()->out_param*/
        }
        //
        ////$this->db->close();
        return $ar;
    }

	}
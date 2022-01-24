<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mcuestionario_gen_resultados extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    

   public function m_estado_envios_x_cuge_docente($data)
    {
    $result = $this->db->query("SELECT DISTINCT 
          COUNT(tb_cuestionario_general_encuestado.cgen_id) AS enviadas,
          SUM(CASE WHEN tb_cuestionario_general_encuestado.cgen_completado = 'SI' THEN 1 ELSE 0 END) AS respondidas
        FROM
          tb_cuestionario_general_encuestado
        WHERE
          tb_cuestionario_general_encuestado.codigocuge = ? AND 
          tb_cuestionario_general_encuestado.coddocente = ?
        GROUP BY
          tb_cuestionario_general_encuestado.codigocuge,
          tb_cuestionario_general_encuestado.coddocente", $data);
              
      $arrayrs['estado']=  $result->row();


      $result2 = $this->db->query("select t1.codcuge,MAX(t1.puntos) AS mayor,MIN(t1.puntos) as menor from (SELECT 
            tb_cuestionario_general_encuestado.codigocuge AS codcuge,
            tb_cuestionario_general_encuestado.cgen_id AS codcuge_encuestado,
            SUM(tb_cuestionario_general_respuesta.evrp_valor_max) AS puntos
          FROM
            tb_cuestionario_general_encuestado
            INNER JOIN tb_cuestionario_general_encuestado_respuesta cger ON (tb_cuestionario_general_encuestado.cgen_id = cger.codigocuge)
            INNER JOIN tb_cuestionario_general_respuesta ON (cger.codigorespuesta = tb_cuestionario_general_respuesta.evrp_id)
            AND (cger.codigopregunta_cuge = tb_cuestionario_general_respuesta.codigopreguntacuge)
          WHERE
            tb_cuestionario_general_encuestado.codigocuge = ? AND 
            tb_cuestionario_general_encuestado.coddocente = ?
          GROUP BY
            tb_cuestionario_general_encuestado.codigocuge,
            tb_cuestionario_general_encuestado.cgen_id) as t1
          GROUP BY t1.codcuge", $data);
              
      $arrayrs['puntajes']= $result2->row();
      return $arrayrs;
    }

    public function m_conteo_rpta_x_cuge_docente($data)
    {
		$result = $this->db->query("SELECT 
          cger.codigopregunta_cuge AS codpregunta,
          cger.codigorespuesta AS codrespuesta,
          COUNT(cger.codigorespuesta) AS total,
          tb_cuestionario_general_respuesta.evrp_valor_max AS puntos
        FROM
          tb_cuestionario_general_encuestado
          INNER JOIN tb_cuestionario_general_encuestado_respuesta cger ON (tb_cuestionario_general_encuestado.cgen_id = cger.codigocuge)
          INNER JOIN tb_cuestionario_general_respuesta ON (cger.codigorespuesta = tb_cuestionario_general_respuesta.evrp_id)
          AND (cger.codigopregunta_cuge = tb_cuestionario_general_respuesta.codigopreguntacuge)
        WHERE
          tb_cuestionario_general_encuestado.codigocuge = ? AND 
          tb_cuestionario_general_encuestado.coddocente = ? 
        GROUP BY
          cger.codigopregunta_cuge,
          cger.codigorespuesta,
          tb_cuestionario_general_respuesta.evrp_valor_max", $data);
    	        
        return $result->result();
    }
}
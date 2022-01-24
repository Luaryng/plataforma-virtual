<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mvirtualevaluacion extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_tipo_pregunta()
    {
        $result = $this->db->query("SELECT 
            `tppg_id` as codtipo,
            `tppg_nombre` as tipo,
            tppg_nro_opci as nroopc
          FROM 
            `tb_virtual_evalua_tipo_pregunta`");
        return $result->result();
    }

    public function m_get_preguntas_x_evaluacion($data)
    {
        $result = $this->db->query("SELECT 
            `evpg_id` as codpregunta,
            `codmaterial` as codmaterial,
            `codagrupador` as codagrupador,
            `codtipopreg` as codtipo,
            `evpg_posicion` as pos,
            `evpg_enunciado` as enunciado,
            `evpg_enunciado_extra` as enunciadox,
            `evpg_imagen` as imagen,
            `evpg_rpta` as rpta,
            `evpg_valor_max` as valor,
            `evpg_nro_opcrpts` as nroopc,
            `evpg_permite_vacio` as vacio,
            `evpg_penalidad_vacio_pts` as valorv,
            `evpg_penalidad_error_pts` as valore
          FROM 
            `tb_virtual_evaluacion_pregunta` 
          WHERE codmaterial=? ORDER BY evpg_posicion ASC",$data);
        return $result->result();
    }


    public function m_get_respuestas_x_evaluacion($data)
    {
        $result = $this->db->query("SELECT 
            evrp_id as codrpta,
            codmaterial as codmaterial,
            evrp_posicion as pos,
            id_pregunta as codpregunta,
            evrp_valor_max as valor,
            evrp_enunciado as enunciado,
            evrp_escorrecta as correcta,
            evrp_imagen as imagen
          FROM
            tb_virtual_evaluacion_respuesta 
          WHERE codmaterial=? ORDER BY  evrp_posicion asc",$data);
        return $result->result();
    }

    public function m_get_respuestas_entregadas_x_evaluacion($data)
    {
        $result = $this->db->query("SELECT 
            tb_virtual_evaluacion_alumno_respuesta.vear_id AS codrptaentregada,
            tb_virtual_evaluacion_alumno_respuesta.codigoevaluacion AS codevaluacion,
            tb_virtual_evaluacion_alumno_respuesta.codigopregunta AS codpregunta,
            tb_virtual_evaluacion_alumno_respuesta.codigomiembro AS codmiembro,
            tb_virtual_evaluacion_alumno_respuesta.vear_rpta_texto AS texto,
            tb_virtual_evaluacion_alumno_respuesta.codigorespuesta as codrpta,
            tb_virtual_evaluacion_alumno_respuesta.vear_puntos as puntos
            
          FROM
            tb_virtual_evaluacion_alumno_respuesta
          WHERE tb_virtual_evaluacion_alumno_respuesta.codigoevaluacion=? AND tb_virtual_evaluacion_alumno_respuesta.codigomiembro=?",$data);
        return $result->result();
    }

    public function m_get_respuestas_x_revisar_x_evaluacion($data)
    {
        $result = $this->db->query("SELECT 
            tb_virtual_evaluacion_alumno_respuesta.vear_id as codrptaentregada,
            tb_virtual_evaluacion_alumno_respuesta.codigoevaluacion as codevaluacion,
            tb_virtual_evaluacion_alumno_respuesta.codigopregunta as codpregunta,
            tb_virtual_evaluacion_alumno_respuesta.codigomiembro as codmiembro,
            tb_virtual_evaluacion_alumno_respuesta.vear_rpta_texto as texto,
            tb_virtual_evaluacion_pregunta.evpg_enunciado as enunciado,
            tb_virtual_evaluacion_pregunta.evpg_valor_max as valor,
            tb_virtual_evaluacion_pregunta.evpg_enunciado_extra as enunciado_extra,
            tb_virtual_evaluacion_pregunta.evpg_posicion as pos 
          FROM
            tb_virtual_evaluacion_pregunta
            INNER JOIN tb_virtual_evaluacion_alumno_respuesta ON (tb_virtual_evaluacion_pregunta.evpg_id = tb_virtual_evaluacion_alumno_respuesta.codigopregunta)
          WHERE tb_virtual_evaluacion_alumno_respuesta.codigoevaluacion=? AND tb_virtual_evaluacion_alumno_respuesta.vear_puntos is null",$data);
        return $result->result();
    }
    

    public function m_get_count_entregas_x_evaluacion($data)
    {
        $result = $this->db->query("SELECT 
          COUNT(DISTINCT vita_id) AS total,
          SUM(CASE WHEN tb_virtual_evaluacion_alumno_respuesta.vear_puntos IS NULL tHEN 1 ELSE 0 END) AS pendientes
        FROM
          tb_carga_subseccion_miembros
          INNER JOIN tb_virtual_evaluacion_alumno ON (tb_carga_subseccion_miembros.csm_id = tb_virtual_evaluacion_alumno.miembro_id)
          INNER JOIN tb_virtual_evaluacion_alumno_respuesta ON (tb_virtual_evaluacion_alumno.virt_id = tb_virtual_evaluacion_alumno_respuesta.codigoevaluacion)
            AND (tb_virtual_evaluacion_alumno_respuesta.codigomiembro = tb_carga_subseccion_miembros.csm_id)
        WHERE
          virt_id = ? AND 
          tb_carga_subseccion_miembros.csm_eliminado = 'NO'",$data);
        return $result->row();
    }

    public function m_get_evaluaciones_entregadas($data)
    {
        $result = $this->db->query("SELECT 
            vita_id as codentrega,
            vita_entrega as fentrega,
            vita_editar as editar,
            vita_nota  as nota,
            miembro_id as codmiembro,
            vita_completado as completo 
          FROM
            tb_virtual_evaluacion_alumno
            WHERE virt_id=?",$data);
        return $result->result();
    }

    public function m_get_preguntas_x_evaluacion_revisar($data)
    {
        $result = $this->db->query("SELECT 
            `evpg_id` as codpregunta,
            `codtipopreg` as codtipo,
            `evpg_valor_max` as valor,
            `evpg_permite_vacio` as vacio,
            `evpg_penalidad_vacio_pts` as valorv,
            `evpg_penalidad_error_pts` as valore
          FROM 
            `tb_virtual_evaluacion_pregunta` 
          WHERE codmaterial=? ORDER BY evpg_posicion ASC",$data);
        return $result->result();
    }

    public function m_get_respuestas_x_evaluacion_revisar($data)
    {
        $result = $this->db->query("SELECT 
            evrp_id as codrpta,
            id_pregunta as codpregunta,
            evrp_valor_max as valor,
            evrp_escorrecta as correcta
          FROM
            tb_virtual_evaluacion_respuesta 
          WHERE codmaterial=? AND evrp_escorrecta='SI'",$data);
        return $result->result();
    }


    public function m_get_respuestas_x_evaluacion_a_ciegas($data)
    {
        $result = $this->db->query("SELECT 
            evrp_id as codrpta,
            codmaterial as codmaterial,
            evrp_posicion as pos,
            id_pregunta as codpregunta,
            evrp_enunciado as enunciado,
            evrp_imagen as imagen
          FROM
            tb_virtual_evaluacion_respuesta 
          WHERE codmaterial=? ORDER BY  evrp_posicion asc",$data);
        return $result->result();
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

    public function m_delete_detalle($data){
      $this->db->query("DELETE FROM  `tb_virtual_tarea_detalle` WHERE  `vdet_id` = ?", $data);
      return 1;
    }


    public function m_get_evaluacion_entregada($data)
    {
        $result = $this->db->query("SELECT 
            vita_id as codtarea,
            vita_entrega as fentrega,
            vita_editar as editar,
            vita_nota  as nota,
            vita_completado as completo 
          FROM
            tb_virtual_evaluacion_alumno
            WHERE virt_id=? AND miembro_id=? LIMIT 1",$data);
        return $result->row();
    }

    public function m_get_evaluacion_entregada_x_id($data)
    {
        $result = $this->db->query("SELECT 
            vita_id as codtarea,
            vita_entrega as fentrega,
            vita_editar as editar,
            vita_nota  as nota,
            vita_completado as completo 
          FROM
            tb_virtual_evaluacion_alumno
            WHERE vita_id=? AND miembro_id=? LIMIT 1",$data);
        return $result->row();
    }

    public function m_insert_pregunta($datapgta,$datarpta){
      $this->db->query("CALL `sp_tb_virtual_pregunta_insert`(?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)", $datapgta);
      $res = $this->db->query('select @s as salida, @nid as nid');
      $fila=$res->row();
      $nw=$fila->nid;
      $fila->rpts=array();
      $indices=array();
      if ($nw>0){
        $rptas=array();
        foreach ($datarpta as $key => $rp) {
            $indices[$rp[0]]['nid']="";
            $indices[$rp[0]]['img']="";
            $indices[$rp[0]]['status']=false;
            $rpta = array($datapgta[0] ,$rp[0],$nw,$rp[1], $rp[2],$rp[3],$rp[7]);
            $this->db->query("CALL `sp_tb_virtual_respuesta_insert`(?,?,?,?,?,?,?,@s,@nid)", $rpta);
            $resrp = $this->db->query('select @s as salida, @nid as nid')->row();
            if ($resrp->salida=="1"){
                  $indices[$rp[0]]['nid']=base64url_encode($resrp->nid);
                  $indices[$rp[0]]['img']=$rp[7];
                  $indices[$rp[0]]['status']=true;
            }
        }
        $fila->rpts=$indices;
        return $fila;
      }
    }

    public function m_update_pregunta($datapgta,$datarpta,$pgmaterial,$datadel){
      $this->db->query("CALL `sp_tb_virtual_pregunta_update`(?,?,?,?,?,?,?,?,?,?,?,@s)", $datapgta);
      $fila = $this->db->query('select @s as salida')->row();
      
      $nw=$fila->salida;
      $fila->rpts=array();
      $indices=array();
      if ($nw=='1'){
        $rptas=array();
        foreach ($datarpta as $key => $rp) {
            $indices[$rp[0]]['nid']="";
            $indices[$rp[0]]['img']="";
            $indices[$rp[0]]['status']=false;
            if ($rp[5]=='0'){
                $rpta = array($pgmaterial ,$rp[0],$datapgta[0],$rp[1], addslashes($rp[2]),$rp[3],$rp[7]);
                $this->db->query("CALL `sp_tb_virtual_respuesta_insert`(?,?,?,?,?,?,?,@s,@nid)", $rpta);
                $resrp = $this->db->query('select @s as salida, @nid as nid')->row();
                if ($resrp->salida=="1"){
                  $indices[$rp[0]]['nid']=base64url_encode($resrp->nid);
                  $indices[$rp[0]]['img']=$rp[7];
                  $indices[$rp[0]]['status']=true;
                }
            }
            else{
                $decorp5=base64url_decode($rp[5]);
                $rpta = array($rp[0],$rp[1], addslashes($rp[2]),$rp[3],$rp[7],$decorp5);
                $this->db->query("CALL `sp_tb_virtual_respuesta_update`(?,?,?,?,?,?,@s)", $rpta);
                $resrp = $this->db->query('select @s as salida')->row();
                if ($resrp->salida=="1"){
                    $indices[$rp[0]]['nid']=$rp[5];
                    $indices[$rp[0]]['img']=$rp[7];
                    $indices[$rp[0]]['status']=true;
                }
            }
            
        }
        $fila->rpts=$indices;
        if (count($datadel)>0){
          $eliminar=implode(",", $datadel);
          $this->db->query("DELETE FROM  `tb_virtual_evaluacion_respuesta` WHERE  `evrp_id` in ($eliminar);");
        }
        
        return $fila;
      }
    }

    public function m_alumno_guardar_exameneditable_respuesta($dataexamen,$datarpta){
      //CALL `sp_tb_virtual_evalua_alum_insert`( @vvita_entrega, @vvita_detalle, @vcodigocarga, @vcodigosubseccion, @vmiembro_id, @vid_material, @`s`, @nid);
      $this->db->query("CALL `sp_tb_virtual_evalua_alum_insert`(?,?,?,@s,@nid)", $dataexamen);
      $res = $this->db->query('select @s as salida, @nid as nid');
      $fila=$res->row();
      $nw=$fila->nid;
      $fila->rpts=array();
      $indices=array();
      if ($nw>0){
        $rptas=array();
        foreach ($datarpta as $key => $rp) {
          //CALL `sp_tb_virtual_evalua_rpta_alum_insert`( @vcodigoevaluacion, @vcodigopregunta, @vcodigomiembro, @vcodigorespuesta, @vvear_rpta_texto, @vvear_esborrador, @`s`, @nid);
            $rpta = array($dataexamen[0] ,$rp[0],$nw,$rp[1], $rp[2],$rp[3],$rp[4]);
            //$this->db->query("CALL `sp_tb_virtual_evalua_rpta_alum_insert`(?,?,?,?,?,?,@s,@nid)", $rpta);
            $resrp = $this->db->query('select @s as salida, @nid as nid')->row();
            if ($resrp->salida=="1"){
              $indices[$rp[0]]=base64url_encode($resrp->nid);
            }
        }
        $fila->rpts=$indices;
        return $fila;
      }
    }

    public function m_alumno_guardar_examen_respuesta($dataexamen,$datarpta){
      //CALL `sp_tb_virtual_evalua_alum_insert`( @vid_material, @vvita_entrega, @vmiembro_id, @vita_nota, @`s`, @nid);
      $this->db->query("CALL `sp_tb_virtual_evalua_alum_insert`(?,?,?,?,?,@s,@nid)", $dataexamen);
      $res = $this->db->query('select @s as salida, @nid as nid');
      $fila=$res->row();
      $nw=$fila->nid;
      
      
      if ($nw>0){
        $rptas=array();
        foreach ($datarpta as $key => $rp) {
            $arrayName = array('codigoevaluacion' =>$dataexamen[0] , 'codigopregunta' => $rp[0], 'codigorespuesta' => $rp[1], 'vear_rpta_texto' => addslashes($rp[2]), 'codigomiembro' => $dataexamen[2] , 'vear_puntos' => $rp[3] );
            $rptas[] = $arrayName;
        }
        if (count($rptas)>0){
          $this->db->insert_batch('tb_virtual_evaluacion_alumno_respuesta', $rptas); 
        }
        
        //$fila->rpts=$indices;
      }
      return $fila;
    }

    public function m_alumno_revaluar_examen_respuesta($dataexamen,$datarpta){
      //CALL `sp_tb_virtual_evalua_alum_insert`( @vid_material, @vvita_entrega, @vmiembro_id, @vita_nota, @`s`, @nid);
      /*$this->db->query("CALL `sp_tb_virtual_evalua_alum_insert`(?,?,?,?,?,@s,@nid)", $dataexamen);
      $res = $this->db->query('select @s as salida, @nid as nid');
      $fila=$res->row();*/
      $nw=$dataexamen[0];//Codigo Entrega
      
      //array($codpg,$idrp,null,$pregunta['valore'],$rj->codrptaentregada);
      $nota=-1;
      if ($nw>0){
        $rptas=array();
        foreach ($datarpta as $key => $rp) {
            $arrayName = array('vear_id'=> $rp[4],'codigopregunta' => $rp[0], 'codigorespuesta' => $rp[1], 'vear_rpta_texto' => $rp[2], 'codigomiembro' => $dataexamen[1] , 'vear_puntos' => $rp[3] );
            $rptas[] = $arrayName;
        }
        if (count($rptas)>0){
          $this->db->update_batch('tb_virtual_evaluacion_alumno_respuesta', $rptas,"vear_id"); 
        }
        //OBTENER NUEVA NOTA
        //var_dump($rptas);
        $result = $this->db->query("SELECT 
            SUM(tb_virtual_evaluacion_alumno_respuesta.vear_puntos) AS nota
            FROM
                tb_virtual_evaluacion_alumno_respuesta
            WHERE
                tb_virtual_evaluacion_alumno_respuesta.codigoevaluacion = ? AND 
                tb_virtual_evaluacion_alumno_respuesta.codigomiembro = ?
            GROUP BY
                tb_virtual_evaluacion_alumno_respuesta.codigoevaluacion,
                tb_virtual_evaluacion_alumno_respuesta.codigomiembro",array($dataexamen[2],$dataexamen[1]));
        $nota=$result->row()->nota;
        //GUARDAR NUEVA NOTA
        $this->db->query("UPDATE `tb_virtual_evaluacion_alumno`  SET  `vita_nota` = ?  
            WHERE  `vita_id` = ?;", array($nota,$nw));   

      }
      return $nota;
    }


    public function m_delete_respuesta($data){
      $this->db->query("DELETE FROM  `tb_virtual_evaluacion_respuesta` WHERE  `evrp_id` = ?;", $data);
      return $this->db->affected_rows();
    }
    
    public function m_delete_pregunta($data){
      $this->db->query("DELETE FROM  `tb_virtual_evaluacion_pregunta` WHERE  `evpg_id` = ?;", $data);
      return $this->db->affected_rows();
    }

    public function m_delete_evaluacion_alumno($data){
      $this->db->query("CALL `sp_tb_virtual_evalua_alum_delete`( ?, ?, ?, @`s`);", $data);
      $res = $this->db->query('select @s as salida');
      return $res->row();
    }

    public function m_calificar_respuesta($data){
      //CALL ``( @codrpalum, @codpg, @codevalum, @vpuntos, @s, @nid);
      $this->db->query("CALL `sp_tb_virtual_evaluacion_alum_calificar_rpt`(?,?,?,?,@s,@nid)", $data);
      $res = $this->db->query('select @s as salida, @nid as nid');
      return $res->row();
    }

    public function m_recalificar_respuesta($data){
      //CALL ``( @codrpalum, @codpg, @codevalum, @vpuntos, @s, @nid);
      $this->db->query("CALL `sp_tb_virtual_evaluacion_alum_recalificar_rpt`(?,?,?,?,@s,@notaeval)", $data);
      $res = $this->db->query('select @s as salida, @notaeval as nota');
      return $res->row();
    }



    public function m_ordenar($datainsert){
      $row=0;
      foreach ($datainsert as $key => $data) {
        $this->db->query("UPDATE `tb_virtual_evaluacion_pregunta`  SET `evpg_posicion` = ? WHERE  `evpg_id` = ?", $data);   
         $row=$row + $this->db->affected_rows();
      }
      return $row;
    }

    public function m_eliminar_imagen_pregunta($data)
    {
        $this->db->query("UPDATE `tb_virtual_evaluacion_pregunta` SET evpg_imagen = ?  WHERE  `evpg_id` = ?", $data);
        return 1;
    }

    public function m_eliminar_imagen_respuesta($data)
    {
        $this->db->query("UPDATE `tb_virtual_evaluacion_respuesta` SET evrp_imagen = ?  WHERE  `evrp_id` = ?", $data);
        return 1;
    }
    

}
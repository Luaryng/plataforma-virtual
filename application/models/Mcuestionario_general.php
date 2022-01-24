<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mcuestionario_general extends CI_Model
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
            tppg_icon as icon
          FROM 
            `tb_virtual_evalua_tipo_pregunta`");
        return $result->result();
    }

    public function m_get_preguntas_x_cuestionario($data)
    {
        $result = $this->db->query("SELECT 
            `cugp_codigo` as codpregunta,
            `codigocuge` as codmaterial,
            `codagrupador` as codagrupador,
            `codtipopreg` as codtipo,
            `evpg_posicion` as pos,
            `evpg_enunciado` as enunciado,
            `evpg_enunciado_extra` as enunciadox,
            `evpg_rpta` as rpta,
            `evpg_valor_max` as valor,
            `evpg_nro_opcrpts` as nroopc,
            `evpg_permite_vacio` as vacio,
            `evpg_penalidad_vacio_pts` as valorv,
            `evpg_penalidad_error_pts` as valore,
            `cugp_esvalorada` as valorada 
          FROM 
            `tb_cuestionario_general_pregunta` 
          WHERE codigocuge=? ORDER BY evpg_posicion ASC",$data);
        return $result->result();
    }

    public function m_get_respuestas_x_cuestionario($data)
    {
        $result = $this->db->query("SELECT 
            evrp_id as codrpta,
            codigocuge as codmaterial,
            evrp_posicion as pos,
            codigopreguntacuge as codpregunta,
            evrp_valor_max as valor,
            evrp_enunciado as enunciado,
            evrp_escorrecta as correcta,
            evrp_imagen as imagen
          FROM
            tb_cuestionario_general_respuesta 
          WHERE codigocuge=? ORDER BY  evrp_posicion asc",$data);
        return $result->result();
    }

    public function m_get_cuestionarios_encuestado($data)
    {
        
        $result = $this->db->query("SELECT 
            cuge.cuge_id AS codigo,
            cuge.cuge_nombre AS nombre,
            cuge.cuge_tipo AS tipo,
            cuge.cuge_subtipo AS objetivo,
            cuge.cuge_fechacreacion AS creado,
            cuge.cuge_vence AS vence,
            cuge.cuge_inicia AS inicia,
            cuge.codigopersona AS codpersona,
            tb_cuestionario_general_encuestado.cgen_completado AS completado,
            tb_cuestionario_general_encuestado.cgen_entrega AS entregado,
            tb_cuestionario_general_encuestado.cgen_id AS codencuestallenar,
            tb_cuestionario_general_encuestado.miembro_id AS codmiembro,
            tb_carga_subseccion_miembros.cod_matricula AS codmatricula,
            tb_persona.per_apel_paterno as paterno,
            tb_persona.per_apel_materno as materno,
            tb_persona.per_nombres as nombres,
            tb_unidad_didactica.undd_nombre as curso
          FROM
            tb_cuestionario_general cuge
            INNER JOIN tb_cuestionario_general_encuestado ON (cuge.cuge_id = tb_cuestionario_general_encuestado.codigocuge)
            INNER JOIN tb_carga_subseccion_miembros ON (tb_cuestionario_general_encuestado.miembro_id = tb_carga_subseccion_miembros.csm_id)
            INNER JOIN tb_docente ON (tb_cuestionario_general_encuestado.coddocente = tb_docente.doc_codigo)
            INNER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
            INNER JOIN tb_carga_academica ON (tb_cuestionario_general_encuestado.codigocarga = tb_carga_academica.cac_id)
            INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          WHERE tb_carga_subseccion_miembros.cod_matricula=?",$data);
        return $result->result();
    }

    public function m_get_cuestionario_encuestado($data)
    {
        
        $result = $this->db->query("SELECT 
            cuge.cuge_id AS codigo,
            cuge.cuge_nombre AS nombre,
            cuge.cuge_tipo AS tipo,
            cuge.cuge_subtipo AS objetivo,
            cuge.cuge_fechacreacion AS creado,
            cuge.cuge_vence AS vence,
            cuge.cuge_inicia AS inicia,
            cuge.codigopersona AS codpersona,
            tb_cuestionario_general_encuestado.cgen_completado AS completado,
            tb_cuestionario_general_encuestado.cgen_entrega AS entregado,
            tb_cuestionario_general_encuestado.cgen_id AS codencuestallenar,
            tb_cuestionario_general_encuestado.miembro_id AS codmiembro,
            tb_carga_subseccion_miembros.cod_matricula AS codmatricula,
            tb_persona.per_apel_paterno as paterno,
            tb_persona.per_apel_materno as materno,
            tb_persona.per_nombres as nombres,
            tb_unidad_didactica.undd_nombre as curso
          FROM
            tb_cuestionario_general cuge
            INNER JOIN tb_cuestionario_general_encuestado ON (cuge.cuge_id = tb_cuestionario_general_encuestado.codigocuge)
            INNER JOIN tb_carga_subseccion_miembros ON (tb_cuestionario_general_encuestado.miembro_id = tb_carga_subseccion_miembros.csm_id)
            INNER JOIN tb_docente ON (tb_cuestionario_general_encuestado.coddocente = tb_docente.doc_codigo)
            INNER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
            INNER JOIN tb_carga_academica ON (tb_cuestionario_general_encuestado.codigocarga = tb_carga_academica.cac_id)
            INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          WHERE tb_cuestionario_general_encuestado.cgen_id=?",$data);
        return $result->row();
    }

    
    public function m_get_cuestionarios_creador_observador($data)
    {
        
        $result = $this->db->query("SELECT 
              tb_cuestionario_general.cuge_id AS codigo,
              tb_periodo.ped_nombre AS periodo,
              tb_cuestionario_general.cuge_nombre AS nombre,
              tb_cuestionario_general.cuge_descripcion AS descripcion,
              tb_cuestionario_general.cuge_tipo AS tipo,
              tb_cuestionario_general.cuge_subtipo as objetivo,
              tb_cuestionario_general.cuge_fechacreacion AS creado,
              tb_cuestionario_general.cuge_vence AS vence,
              tb_cuestionario_general.cuge_inicia AS inicia,
              tb_cuestionario_general.codigopersona AS codpersona,
              tb_persona.per_apel_paterno AS paterno,
              tb_persona.per_nombres AS nombres
            FROM
              tb_persona
              INNER JOIN tb_cuestionario_general ON (tb_persona.per_codigo = tb_cuestionario_general.codigopersona)
              INNER JOIN tb_periodo ON (tb_cuestionario_general.codigoperiodo = tb_periodo.ped_codigo) 
            WHERE tb_cuestionario_general.codigousuario=? AND tb_cuestionario_general.codigosede=? AND tb_cuestionario_general.codigoperiodo=?",$data);
        return $result->result();
    }

    public function m_get_cuestionario_x_codigo($data)
    {
        
        $result = $this->db->query("SELECT 
                cuge_id AS codigo,
                codigoperiodo as codperiodo,
                cuge_nombre as nombre,
                cuge_descripcion as descripcion,
                cuge_subtipo as objetivo,
                cuge_inicia as inicia,
                cuge_vence as vence,
                cuge_tiempo_limite as tiempo,
                cuge_medida_tiempo as medtiempo,
                cuge_detalle as detalle,
                cuge_opcion1 as opc1,
                cuge_opcion2 as opc2,
                cuge_opcion3 as opc3,
                cuge_opcion4 as opc4,
                cuge_horas_alerta as halerta,
                cuge_puntaje_max as puntos_max
              FROM
                tb_cuestionario_general
            WHERE cuge_id=?",$data);
        return $result->row();
    }

    public function m_get_unidades_didacticas_x_periodo($data){
        $arrdata = array('vcploblacion' => array() ,'vcnromiembros' => array() , 'vcencgeneradas' => array() );
        $result = $this->db->query("SELECT 
          tb_carga_academica.cac_id AS codcarga,
          tb_carga_academica.codigoperiodo AS codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_carga_academica.codigocarrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS sigla,
          tb_carga_academica.codigociclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_carga_academica.codigoturno AS codturno,
          tb_turno.tur_nombre AS turno,
          tb_carga_academica.codigoseccion AS codseccion,
          tb_carga_academica_subseccion.codigosubseccion AS division,
          tb_unidad_didactica.undd_nombre AS unidad,
          tb_unidad_didactica.codigomodulo AS codmodulo,
          tb_modulo_educativo.mod_nombre AS modulo,
          tb_modulo_educativo.codigoplan AS codplan,
          tb_plan_estudios.pln_nombre AS plan,
          tb_carga_academica_subseccion.codigodocente AS coddocente,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
          INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
          INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
        WHERE tb_carga_academica.codigoperiodo=? AND tb_carga_academica.cac_activo='SI' 
        ORDER BY 
          tb_carga_academica.codigocarrera,
          tb_carga_academica.codigociclo,
          tb_carga_academica.codigoturno,
          tb_carga_academica.codigoseccion,
          tb_carga_academica_subseccion.codigosubseccion", $data);
        $arrdata['vcpoblacion']= $result->result();

        $result = $this->db->query("SELECT 
            tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga,
            tb_carga_subseccion_miembros.cod_subseccion as division,
            COUNT(tb_carga_subseccion_miembros.csm_id) AS miembros
          FROM
            tb_carga_subseccion_miembros
            INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
            INNER JOIN tb_carga_academica ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica.cac_id)
          WHERE
            tb_carga_academica.codigoperiodo=? AND 
            tb_carga_subseccion_miembros.csm_eliminado = 'NO'
          GROUP BY
            tb_carga_subseccion_miembros.cod_cargaacademica,
            tb_carga_subseccion_miembros.cod_subseccion", $data);
        $arrdata['vcnromiembros']= $result->result();

        $result = $this->db->query("SELECT 
            ge.codigocarga AS codcarga,
            ge.codigosubseccion AS division,
            COUNT(cgen_id) AS enviadas,
            SUM(CASE WHEN ge.cgen_completado='SI' THEN 1 ELSE 0 END) AS contestadas
          FROM
            tb_carga_academica
            INNER JOIN tb_cuestionario_general_encuestado ge ON (tb_carga_academica.cac_id = ge.codigocarga)
          WHERE
            tb_carga_academica.codigoperiodo = ? 
          GROUP BY
            ge.codigocarga,
            ge.codigosubseccion", $data);
        $arrdata['vcencgeneradas']= $result->result();

        return $arrdata;
    }

    //CALL ``( @vcodencuesta, @vmiembro_id, @vcodcarga, @vdivision, @`s`);
    public function m_send_a_encuestados($data){
        $this->db->query("CALL `sp_tb_cuestionario_general_encuestado_insert_ms`(?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return   $res->row()->salida;    
    }

    

    public function m_insert($data){
        /*CALL ``( @vcodigoperiodo, @vcuge_nombre, @vcuge_descripcion, @vcuge_tipo, @vcuge_inicia, @vcuge_vence, @vcuge_tiempo_limite, @vcuge_medida_tiempo, @vcuge_detalle, @vcuge_mostrar_detalle, @vcuge_opcion1, @vcuge_opcion2, @vcuge_opcion3, @vcuge_opcion4, @vcodigousuario, @vcodigosede, @vcuge_horas_alerta, @s, @nid);*/
        $this->db->query("CALL `sp_tb_cuestionario_gen_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as nid');
        return   $res->row();    
    }
    public function m_update($data){
      //CALL `sp_tb_cuestionario_gen_update`( @vcodigoperiodo, @vcuge_nombre, @vcuge_descripcion, @vcuge_subtipo, @vcuge_inicia, @vcuge_vence, @vcuge_tiempo_limite, @vcuge_medida_tiempo, @vcuge_detalle, @vcuge_opcion1, @vcuge_opcion2, @vcuge_opcion3, @vcuge_opcion4, @vcuge_horas_alerta, @vcuge_id, @s);
        $this->db->query("CALL `sp_tb_cuestionario_gen_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as salida');
        return   $res->row();    
    }

    public function m_insert_pregunta($datapgta){
      $this->db->query("CALL `sp_tb_cuestionario_general_pregunta_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)", $datapgta);
      $res = $this->db->query('select @s as salida, @nid as nid');
      $fila=$res->row();
      return $fila;
      
    }

    public function m_update_pregunta($datapgta){
      $this->db->query("CALL `sp_tb_cuestionario_general_pregunta_update`(?,?,?,?,?,?,?,?,?,?,?,?,@s)", $datapgta);
      $fila = $this->db->query('select @s as salida')->row();
      return $fila;
      
    }

    public function m_clone_pregunta($datapgta){
      $this->db->query("CALL `sp_tb_cuestionario_general_pregunta_clone`(?,@s,@nid)", $datapgta);
      $res = $this->db->query('select @s as salida, @nid as nid');
      $fila=$res->row();
      return $fila;
      
    }

    public function m_clone_encuesta($datapgta){
      $this->db->query("CALL `sp_tb_cuestionario_general_clone`(?,?,?,?,@s)", $datapgta);
      $res = $this->db->query('select @s as salida');
      $fila=$res->row();
      return $fila;
      
    }

    public function m_delete_encuesta($datapgta){
      $this->db->query("CALL `sp_tb_cuestionario_general_delete`(?,?,?,?,@s)", $datapgta);
      $res = $this->db->query('select @s as salida');
      $fila=$res->row();
      return $fila;
      
    }


    public function m_save_respuestas($datapgta,$datarpta,$datadel){
      $fila = new stdClass;
      $fila->rpts=array();
      $indices=array();
      $rptas=array();
      foreach ($datarpta as $key => $rp) {
          if ($rp[5]=='0'){
              //codcuestionadrio y luego codpregunta
              $rpta = array($datapgta[0],$rp[0],$datapgta[1],$rp[1], $rp[2],$rp[3],$rp[4]);
              $this->db->query("CALL `sp_tb_cuestionario_general_respuesta_insert`(?,?,?,?,?,?,?,@s,@nid)", $rpta);
              $resrp = $this->db->query('select @s as salida, @nid as nid')->row();
              if ($resrp->salida=="1"){
                $indices[$rp[0]]=base64url_encode($resrp->nid);
              }
          }
          else{
              $decorp5=base64url_decode($rp[5]);
              $rpta = array($rp[0],$rp[1], $rp[2],$rp[3],$rp[4],$decorp5);
              $this->db->query("CALL `sp_tb_cuestionario_general_respuesta_update`(?,?,?,?,?,?,@s)", $rpta);
              $resrp = $this->db->query('select @s as salida')->row();
              if ($resrp->salida=="1"){
              }
          }
          
      }
      $fila->rpts=$indices;
      if (count($datadel)>0){
        $eliminar=implode(",", $datadel);
        $this->db->query("DELETE FROM  `tb_cuestionario_general_respuesta` WHERE  `evrp_id` in ($eliminar);");
      }
      return $fila;
      
    }

    public function m_save_respuesta($datapgta,$rp){
      $resrp =array();
          if ($rp[5]=='0'){
              //codcuestionadrio y luego codpregunta
              $rpta = array($datapgta[0],$rp[0],$datapgta[1],$rp[1], $rp[2],$rp[3],$rp[4]);
              $this->db->query("CALL `sp_tb_cuestionario_general_respuesta_insert`(?,?,?,?,?,?,?,@s,@nid)", $rpta);
              $resrp = $this->db->query('select @s as salida, @nid as nid')->row();
              
          }
          else{
              $decorp5=base64url_decode($rp[5]);
              $rpta = array($rp[0],$rp[1], $rp[2],$rp[3],$rp[4],$decorp5);
              $this->db->query("CALL `sp_tb_cuestionario_general_respuesta_update`(?,?,?,?,?,?,@s)", $rpta);
              $resrp = $this->db->query('select @s as salida')->row();
              $resrp->nid="--";
          }
      
      return $resrp;
      
    }



    


    public function m_delete_respuestas_x_pregunta($data){
      $this->db->query("DELETE FROM  `tb_cuestionario_general_respuesta` WHERE  `codigopreguntacuge` = ?;", $data);
      return $this->db->affected_rows();
    }

    public function m_delete_respuesta($data){
      $this->db->query("DELETE FROM  `tb_cuestionario_general_respuesta` WHERE  `evrp_id` = ?;", $data);
      return $this->db->affected_rows();
    }
    public function m_delete_pregunta($data){
      $this->db->query("DELETE FROM  `tb_cuestionario_general_pregunta` WHERE  `cugp_codigo` = ?;", $data);
      return $this->db->affected_rows();
    }

    /*public function m_calificar_respuesta($data){
      //CALL ``( @codrpalum, @codpg, @codevalum, @vpuntos, @s, @nid);
      $this->db->query("CALL `sp_tb_virtual_evaluacion_alum_calificar_rpt`(?,?,?,?,@s,@nid)", $data);
      $res = $this->db->query('select @s as salida, @nid as nid');
      return $res->row();
    }*/

    public function m_ordenar($datainsert){
      $row=0;
      foreach ($datainsert as $key => $data) {
        $this->db->query("UPDATE `tb_cuestionario_general_pregunta`  SET `evpg_posicion` = ? WHERE  `cugp_codigo` = ?", $data);   
         $row=$row + $this->db->affected_rows();
      }
      return $row;
    }

    
    public function m_guardar_cuestionario_encuestado($dataexamen,$datarpta){
      //CALL `sp_tb_cuestionario_general_encuestado_entregar`( @vcgen_id, @veditar, @vnota, @vcompleto, @`s`);
      $this->db->query("CALL `sp_tb_cuestionario_general_encuestado_entregar`(?,?,?,?,?,@s)", $dataexamen);
      $res = $this->db->query('select @s as salida');
      $fila=$res->row();
      $nw=$fila->salida;
      
      if ($nw=='1'){
        $rptas=array();
        //``
        foreach ($datarpta as $key => $rp) { 
            $arrayName = array('codigocuge' =>$dataexamen[0] , 'codigopregunta_cuge' => $rp[0], 'codigorespuesta' => $rp[1], 'cure_rpta_texto' => $rp[2] , 'cure_puntos' => $rp[3] );
            $rptas[] = $arrayName;
        }

        if (count($rptas)>0){
          //var_dump($rptas);
          $this->db->insert_batch('tb_cuestionario_general_encuestado_respuesta', $rptas); 
        }
        
        //$fila->rpts=$indices;
      }
      return $fila;
    }

}
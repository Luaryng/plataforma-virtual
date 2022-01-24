<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mauditoria extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	 public function insert_datos_auditoria($data){

        $this->db->query("CALL `sp_tb_registrar_sucesos_insert`(?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function update_datos_auditoria($data){

        $this->db->query("CALL `sp_tb_registrar_sucesos_update`(?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

	public function m_usuarios_gestion()
    {
        $result = $this->db->query("SELECT
					  CONCAT(tb_persona.per_apel_paterno,' ',
					  tb_persona.per_apel_materno,' ',
					  tb_persona.per_nombres) AS nombres,
					  tb_usuario.id_usuario AS codigous,
					  tb_usuario.usu_nick AS usuario
					FROM
					  tb_persona
					  INNER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
					WHERE tb_usuario.usu_tipo <> 'AL';");
        return $result->result();
    }

    public function m_dtsAudit_search($inicio, $limite,$usuario,$accion,$contenido,$sede,$fechas=array())
    {
      if ($inicio == 0) {
        $limitado = "limit $limite";
      } else {
        $limitado = "limit $inicio, $limite";
      }

      $data=array($usuario,$accion,$sede);
      $sqltext="";
      if (count($fechas)>0){
        $sqltext=" AND tb_registrar_sucesos.rs_fecha BETWEEN ? AND ? ";
        $data[]=$fechas[0];
        $data[]=$fechas[1];

      }
      if (trim($contenido)!=""){
        $sqltext= $sqltext." AND tb_registrar_sucesos.rs_descripcion like ? ";
        $data[]="%".$contenido."%";
      }

      $qry = $this->db->query("SELECT 
          tb_registrar_sucesos.rs_codigo id,
          tb_registrar_sucesos.cod_usuario usuario,
          tb_usuario.usu_nick AS nick,
          tb_registrar_sucesos.rs_fecha fecha,
          tb_registrar_sucesos.rs_accion accion,
          tb_registrar_sucesos.rs_descripcion descripcion,
          tb_registrar_sucesos.cod_sede sede,
          tb_sede.sed_nombre nomsede
        FROM
          tb_registrar_sucesos
          INNER JOIN tb_usuario ON (tb_registrar_sucesos.cod_usuario = tb_usuario.id_usuario)
          INNER JOIN tb_sede ON (tb_registrar_sucesos.cod_sede = tb_sede.id_sede)
        WHERE tb_registrar_sucesos.cod_usuario LIKE ? AND 
        tb_registrar_sucesos.rs_accion LIKE ? AND 
        tb_registrar_sucesos.cod_sede = ? AND
        tb_registrar_sucesos.rs_eliminado = 'NO' $sqltext
        ORDER BY tb_registrar_sucesos.rs_codigo DESC $limitado", $data);
      $rs['items'] =$qry->result();

      $qryc = $this->db->query("SELECT 
            count(tb_registrar_sucesos.rs_codigo) AS conteo
          FROM
            tb_registrar_sucesos
          WHERE tb_registrar_sucesos.cod_usuario like ? AND 
                tb_registrar_sucesos.rs_accion like ? AND 
                tb_registrar_sucesos.cod_sede = ? AND
                tb_registrar_sucesos.rs_eliminado = 'NO' $sqltext", $data);
        $rs['numitems']= $qryc->row()->conteo;
        return $rs;
    }

    public function mlist_search_registros($inicio = false, $limite = false, $data)
    {
      $fecha1 = $data[2];
      $fecha2 = $data[3];
      if ($data[0] != "" && $data[2] == "" && $data[3] == "") {
        $this->db->order_by('tb_registrar_sucesos.rs_codigo', 'DESC');
        if ($inicio !== false && $limite !== false) {

            $this->db->limit($limite, $inicio);
        }
        
        $this->db->select('
                    tb_registrar_sucesos.rs_codigo id,
                    tb_registrar_sucesos.cod_usuario usuario,
                    tb_usuario.usu_nick AS nick,
                    tb_registrar_sucesos.rs_fecha fecha,
                    tb_registrar_sucesos.rs_accion accion,
                    tb_registrar_sucesos.rs_descripcion descripcion,
                    tb_registrar_sucesos.cod_sede sede,
                    tb_sede.sed_nombre nomsede', FALSE);
        $this->db->join('tb_usuario', 'tb_registrar_sucesos.cod_usuario = tb_usuario.id_usuario');
        $this->db->join('tb_sede', 'tb_registrar_sucesos.cod_sede = tb_sede.id_sede');

        if ($data[0] != "%%%%" AND $data[1] != "%%%%") {
          $this->db->like("tb_registrar_sucesos.cod_usuario", $data[0]);
          $this->db->like("tb_registrar_sucesos.rs_accion", $data[1]);
        }
        if ($data[4] != "%%%%") {
          $this->db->like("tb_registrar_sucesos.rs_descripcion", $data[4]);
        }
        
        $this->db->where("tb_registrar_sucesos.cod_sede", $data[5]);
        $this->db->where("tb_registrar_sucesos.rs_eliminado", "NO");
        $result = $this->db->get("tb_registrar_sucesos");

      } else if ($data[0] != "" && $data[2] != "" && $data[3] != "") {
        $this->db->order_by('tb_registrar_sucesos.rs_fecha', 'DESC');
        if ($inicio !== false && $limite !== false) {

            $this->db->limit($limite, $inicio);
        }
        
        $this->db->select('
                    tb_registrar_sucesos.rs_codigo id,
                    tb_registrar_sucesos.cod_usuario usuario,
                    tb_usuario.usu_nick AS nick,
                    tb_registrar_sucesos.rs_fecha fecha,
                    tb_registrar_sucesos.rs_accion accion,
                    tb_registrar_sucesos.rs_descripcion descripcion,
                    tb_registrar_sucesos.cod_sede sede,
                    tb_sede.sed_nombre nomsede', FALSE);
        $this->db->join('tb_usuario', 'tb_registrar_sucesos.cod_usuario = tb_usuario.id_usuario');
        $this->db->join('tb_sede', 'tb_registrar_sucesos.cod_sede = tb_sede.id_sede');
        if ($data[0] != "%%%%" AND $data[1] != "%%%%") {
          $this->db->like("tb_registrar_sucesos.cod_usuario", $data[0]);
          $this->db->like("tb_registrar_sucesos.rs_accion", $data[1]);
        }
        $this->db->where("tb_registrar_sucesos.rs_fecha BETWEEN '$fecha1' AND '$fecha2'");
        if ($data[4] != "%%%%") {
          $this->db->like("tb_registrar_sucesos.rs_descripcion", $data[4]);
        }
        $this->db->where("tb_registrar_sucesos.cod_sede", $data[5]);
        $this->db->where("tb_registrar_sucesos.rs_eliminado", "NO");
        $result = $this->db->get("tb_registrar_sucesos");
      }
        
        
        return $result->result();
        
    }

    public function m_eliminar_data($data)
    {
      	$result = $this->db->query("UPDATE tb_registrar_sucesos SET rs_eliminado = ? WHERE rs_codigo = ?", $data);
      	return 1;
    }

}
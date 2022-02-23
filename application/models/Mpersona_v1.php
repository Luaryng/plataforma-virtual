<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpersona extends CI_Model {

	function __construct() {
     	   parent::__construct();
       	   $this->load->helper("url");         	
    }


	

    public function m_get_datosminimos_x_dni($data)
    {
        //$rsdeudas=array();
        $result = $this->db->query("SELECT 
          tb_persona.per_codigo AS idpersona,   
          tb_persona.per_codigo_sec AS codpersona,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_dni AS dni ,
          tb_persona.per_sexo as sexo
        FROM
          tb_persona
        WHERE  tb_persona.per_dni=? limit 1", $data);
        return   $result->row();
    }
	public function get_datos_personales($data){
	$result=$this->db->query("SELECT 
			  tb_persona.per_codigo AS idpersona,
			  tb_persona.per_codigo_sec AS codpersona,
			  tb_persona.per_tipodoc AS tipodoc,
			  tb_persona.per_dni as numero,
			  tb_persona.per_apel_paterno as paterno,
			  tb_persona.per_apel_materno as materno,
			  tb_persona.per_nombres as nombres,
			  tb_persona.per_estadocivil as estadocivil,
			  tb_persona.per_sexo as sexo,
			  tb_persona.per_fecha_nacimiento as fecnac,
			  tb_persona.per_lugar_nacimiento as lugnac,
			  tb_persona.per_celular as celular,
			  tb_persona.per_telefono as telefono,
			  tb_persona.per_celular2 as celular2,
			  tb_persona.per_email_personal as epersonal,
			  tb_persona.per_domicilio as domicilio,
			  tb_persona.cod_distrito as coddistrito,
			  tb_distrito.cod_provincia as codprovincia,
			  tb_provincia.cod_departamento as coddepartamento,
			  tb_persona.per_domicilio_secundario as domiciliosecu,
			  tb_persona.per_foto as foto,
			  tb_persona.per_trabaja as statrab,
			  tb_persona.per_lugar_trabaja as lugar_trab,
			  tb_persona.ins_colegio_5to_sec as colsecund,
			  tb_persona.per_padre_apel_paterno as apepapa,
			  tb_persona.per_padre_ocupacion as ocupapadre,
			  tb_persona.per_madre_apel_paterno as apemama,
			  tb_persona.per_madre_ocupacion as ocupamadre,
			  tb_persona.cod_pais as pais,
			  tb_persona.cod_lengua as lengua,
			  tb_persona.per_otras_lenguas as otlengua

			FROM
			  tb_persona
			  INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
			  INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
			WHERE tb_persona.per_codigo=?;",$data);
		$rslogin=$result->row();
 		return   $rslogin;	
	}

	public function get_datos_alumno_xdni($data){
	    $result=$this->db->query("SELECT 
	        tb_persona.per_codigo AS idpersona,
	        tb_persona.per_codigo_sec AS codpersona,
	        tb_persona.per_tipodoc AS tipodoc,
	        tb_persona.per_dni AS numero,
	        tb_persona.per_apel_paterno AS paterno,
	        tb_persona.per_apel_materno AS materno,
	        tb_persona.per_nombres AS nombres,
	        tb_persona.per_estadocivil as estadocivil,
	        tb_persona.per_sexo AS sexo,
	        tb_persona.per_fecha_nacimiento AS fecnac,
	        tb_persona.per_lugar_nacimiento as lugnac,
	        tb_persona.per_celular AS celular,
	        tb_persona.per_telefono AS telefono,
	        tb_persona.per_celular2 as celular2,
	        tb_persona.per_email_personal AS epersonal,
	        tb_persona.per_domicilio AS domicilio,
	        tb_persona.cod_distrito AS coddistrito,
	        tb_distrito.cod_provincia AS codprovincia,
	        tb_provincia.cod_departamento AS coddepartamento,
	        tb_persona.per_domicilio_secundario AS domiciliosecu,
	        tb_persona.per_foto AS foto,
	        tb_persona.per_trabaja as statrab,
	        tb_persona.per_lugar_trabaja as lugar_trab,
	        tb_persona.ins_colegio_5to_sec as colsecund,
	        tb_persona.per_padre_apel_paterno as apepapa,
	        tb_persona.per_padre_ocupacion as ocupapadre,
	        tb_persona.per_madre_apel_paterno as apemama,
	        tb_persona.per_madre_ocupacion as ocupamadre,
	        tb_persona.cod_pais as pais,
			  	tb_persona.cod_lengua as lengua,
			  	tb_persona.per_otras_lenguas as otlengua,
	        tb_usuario.usu_nick as usuario,
	        tb_usuario.usu_email_corporativo as einstitucional,
	        tb_usuario.usu_nivel as mivel,
	        tb_usuario.area_id as codarea,
	        tb_usuario.usu_tipo as tipo
	      FROM
	        tb_persona
	        INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
	        INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
	        LEFT OUTER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
	      WHERE
	        tb_persona.per_dni = ?;",$data);
	    $rslogin=$result->row();
	    return   $rslogin;  
	}

    public function insert_datos_personales($data){

		// $this->db->query("CALL `sp_tb_persona_basico_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
		$this->db->query("CALL `sp_tb_persona_insert_manual`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
		$res = $this->db->query('select @s as out_param');
		//$this->db->close();	
 		return   $res->row()->out_param;	
	}

	public function insert_persona_aprobado($data){

		$this->db->query("CALL `sp_tb_persona_insert_aprobado`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as nid');
		//$this->db->close();	
 		return   $res->row();	
	}

	public function insert_persona($data){

		$this->db->query("CALL `sp_tb_persona_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as nid');
		//$this->db->close();	
 		return   $res->row();	
	}

	public function update_datos_personales($data){

		// $this->db->query("CALL `sp_tb_persona_basico_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
		$this->db->query("CALL `sp_tb_persona_update_manual`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
		$res = $this->db->query('select @s as out_param');
		//$this->db->close();	
 		return   $res->row()->out_param;	
	}

	public function insert_datos_personales_docente($data){

		// $this->db->query("CALL `sp_tb_persona_basico_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
		$this->db->query("CALL `sp_tb_persona_insert_docente`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
		$res = $this->db->query('select @s as out_param');
		//$this->db->close();	
 		return   $res->row()->out_param;	
	}

	public function update_datos_personales_docente($data){

		// $this->db->query("CALL `sp_tb_persona_basico_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
		$this->db->query("CALL `sp_tb_persona_update_docente`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
		$res = $this->db->query('select @s as out_param');
		//$this->db->close();	
 		return   $res->row()->out_param;	
	}

	public function m_update_dinamico($data,$codpersona){
		$this->db->where('per_codigo', $codpersona);
		$this->db->update('tb_persona', $data);
		$error  = $this->db->error ();
		if ( $error['code'] === 0 )
		{ // almost surely SUCCESS
			return true;
		}
		else{
			return false;
		}
	}

	public function update_dni($data){

		$this->db->query("CALL `sp_tb_persona_dni_update`(?,?,?,@s)",$data);
		$res = $this->db->query('select @s as out_param');
		//$this->db->close();	
 		return   $res->row()->out_param;	
	}


	public function update_mis_contactos($data){

		$this->db->query("CALL `sp_tb_persona_contactos_update`(?,?,?,?,?,?,?,?,?,@s)",$data);
		$res = $this->db->query('select @s as out_param');
		//$this->db->close();	
 		return   $res->row()->out_param;	
	}

	public function m_cambiar_foto($data)
    {
    	//user,$clave,$correo,$iduser
    	
    	$this->db->query("UPDATE `tb_persona`  SET `per_foto` = ? WHERE `per_codigo` = ? ;", $data);
        return $this->db->affected_rows();
    }

  public function insert_persona_contacto($data)
  {
  	
		$this->db->query("CALL `sp_tb_persona_contacto_insert`(?,?,?,?,@s,@nid)",$data);
		$res = $this->db->query('select @s as salida,@nid as nid');
 		return   $res->row();
			
	}

	public function m_delete_data_cotacto($data)
	{
		$result = $this->db->query("DELETE FROM `tb_persona_contacto` WHERE per_codigo = ?", $data);
		return 1;
	}

}
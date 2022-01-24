<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpermiso extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
	
	public function m_get_permisos_por_usuario($data)
	{
		$qry=$this->db->query("SELECT 
		  uspe_id ,
		  cod_usuario,
		  cod_sede,
		  cod_componente,
		  cod_accion,
		  uspe_permitido
		FROM
		  tb_usuario_permiso
			WHERE cod_usuario=? AND cod_sede=? ;",$data);

		$perms=$qry->result();
		
		$permsFinal=array();

		foreach ($perms as $value) {
			$permsArray = new stdClass;
			$permsArray->v1 =$value->cod_accion;
			$permsArray->v3 =$value->uspe_permitido;
			$permsArray->v4 =$value->uspe_id;
			$permsFinal[$value->cod_accion]=$permsArray;
		}
		return $permsFinal;
	}
}
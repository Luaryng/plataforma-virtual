<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Macciones extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	public function mUpdate($items)
	{
		//CALL `sp_lk_genera`( @vid_usuario, @vemail, @vkey, @s);
		
		//$this->load->database();  
		//CALL ``( @vnombre, @vid_modulo, @vdescripcion, @vid_padre, @vestado, @vtipo, @vid, @s);
		$this->db->query("CALL `sp_ac_editar`(?,?,?,?,?,?,?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
		
 		return   $res->row()->out_param;	
	}
	public function mInsert($items)
	{
		//CALL `sp_lk_genera`( @vid_usuario, @vemail, @vkey, @s);
		
		//$this->load->database();  
		//CALL ``( @vnombre, @vid_modulo, @vdescripcion, @vid_padre, @vestado, @vtipo, @vid, @s);
		$this->db->query("CALL `sp_ac_insert`(?,?,?,?,?,?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
		
 		return   $res->row()->out_param;	
	}

	public function mDeleteComponent($items)
	{
		//CALL `sp_lk_genera`( @vid_usuario, @vemail, @vkey, @s);
		
		//$this->load->database();  
		//CALL ``( @vnombre, @vid_modulo, @vdescripcion, @vid_padre, @vestado, @vtipo, @vid, @s);
		$this->db->query("CALL `sp_com_eliminar`(?,?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
		
 		return   $res->row()->out_param;	
	}

	public function mDeletePermisoUser($items)
	{
		//CALL `sp_lk_genera`( @vid_usuario, @vemail, @vkey, @s);
		
		$this->db->where_in('uspe_id', $items);
		$this->db->delete('tb_usuario_permiso');
		$rt=$this->db->affected_rows();
		
 		return   $rt;	
	}
	
	public function mUpdatePermisoUser($items)
	{
		//CALL `sp_lk_genera`( @vid_usuario, @vemail, @vkey, @s);
		
		$rt=$this->db->update_batch('tpermisosusuario', $items, 'id');
		
		
		
 		return   $rt;	
	}

	public function mUpdateInsertPermisoUser($items)
	{
		

		//CALL `sp_prm_insert_update`( @vid, @vid_usuarioentidad, @id_accion, @vid_componente, @vestado, @vpermitido, @s);
		
		foreach ($items as $value) {
			$this->db->query("CALL `sp_prm_insert_update`(?,?,?,?,?,?,?,@s)",$value);
			$res = $this->db->query('select @s as out_param');
			$res->row()->out_param;
		}
		
 			
	}
	public function marray_estructura()
	{
		$bscn = $this->load->database('scanchaquepm', TRUE);
		$qry=$bscn->query("SELECT 
					  tcomponente.id_modulo AS v1,
					  tcomponente.id AS v2,
					  tcomponente.nombre AS v3,
					  tcomponente.id_padre AS v4,
					  'C' AS v5
					FROM
					  tcomponente WHERE eliminado='NO' 
					UNION ALL
					SELECT 
					  tcodaccion.id_modulo as v1,
					  tcodaccion.id as v2,
					  tcodaccion.nombre v3,
					  tcodaccion.id_componente as v4,
					    'A' AS v5
					FROM
					  tcodaccion ORDER BY v3
					");
		$bscn->close();
		//return $qry->result_array();
		$arrayName=array();
		foreach ($qry->result_array() as $row){
	        $arrayName[$row['v5'].$row['v2']]=$row;
		}	
		return $arrayName;
	}

	
	
}

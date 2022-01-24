<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Acciones extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		}
		$errores['E101']='Usuario y/o contraseña incorrecta';
		$errores['E102']='Usuario sin SEDE asignada';
		$errores['E103']='Usuario BLOQUEADO';
		function get_msgerror($cod_error){
$arrayPermisos= array('permiso1' =>true, 'permiso2' =>true, 'permiso3' =>false);
$arrayConfig  = array('config1' =>'rojo', 'config2' =>’23’, 'config3' =>’false’);
$userdatos 	  = array('apellidos' =>'gomez', 'nombres' =>'alex', 'permisos' =>$arrayPermisos, 'config'=>$arrayConfig);
$_SESSION['userDatos']= $userdatos;

VS

$_SESSION['userPermisos']= array('permiso1' =>true, 'permiso2' =>true, 'permiso3' =>false);
$_SESSION['userConfig']  = array('config1' =>'rojo', 'config2' =>’23’, 'config3' =>’false’);
$_SESSION['userDatos'] 	  = array('apellidos' =>'gomez', 'nombres' =>'alex');


		}
}

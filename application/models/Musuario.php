<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Musuario extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_permisos_por_usuario_sede($idusuario=0,$idsede=0){
		if (($idsede!=0)&&($idusuario!=0)){
    		$error="";
    		$resultps = $this->db->query("SELECT 
				  `cod_accion` codaccion,
				  `uspe_permitido` permitido 
				FROM 
				  `tb_usuario_permiso`
			 	WHERE cod_usuario=? AND cod_sede=?", array($idusuario,$idsede));
    		return $resultps->result();
    	}
    	else{
    		return array();
    	}
    }
    
    public function m_get_notifica_facturacionERP()
    {
    		
			
			$result = $this->db->query("SELECT 
			  COUNT(tb_admin_doc_pago.adp_id) AS fac_pendientes
			FROM
			  tb_admin_doc_pago
			WHERE
			  tb_admin_doc_pago.adp_estado = 'PENDIENTE';");

			return $result->row()->fac_pendientes;
			
		
    }
    public function m_get_notifica_mesapartes($permitido="NO")
    {
    		$idsede=$_SESSION['userActivo']->idsede;
    		$arr_buscar = array($_SESSION['userActivo']->idarea);
    		$adsql=" tb_mesa_partes.sede_id=$idsede AND (tb_mesa_partes_ruta.destino_area_id = 1 OR tb_mesa_partes_ruta.destino_area_id =?)";
    		if ($permitido=="NO"){
				$arr_buscar[]=$_SESSION['userActivo']->idusuario;
    			$adsql="(tb_mesa_partes_ruta.destino_area_id = ? OR tb_mesa_partes_ruta.destino_usuario_id=? )";
    		}
			$result = $this->db->query("SELECT 
			  COUNT(tb_mesa_partes.mpt_id) AS sol_pendientes
			FROM
			  tb_mesa_partes
			  LEFT OUTER JOIN tb_mesa_partes_ruta ON (tb_mesa_partes.mpr_id_actual = tb_mesa_partes_ruta.mpr_codigo)
			WHERE
			  tb_mesa_partes_ruta.mpr_situacion = 'PENDIENTE' AND  $adsql;", $arr_buscar);

			return $result->row()->sol_pendientes;
			
		
    }
    public function m_iniciar_sesion($user,$clave)
    {

        //$this->load->database();
        $rslogin=array();
        $rsdeudas=array();
        $rspermisos=array();
        $rssedes=array();
        $rsnotifica=0;
        $error="E100";
        $result = $this->db->query("SELECT 
					  tb_usuario.cod_persona AS codpersona,
					  tb_usuario.usu_nick AS usuario,
					  tb_usuario.usu_clave_sha AS clave,
					  tb_persona.per_apel_paterno AS paterno,
					  tb_persona.per_apel_materno AS materno,
					  tb_persona.per_nombres AS nombres,
					  tb_persona.per_tipodoc AS tipodoc,
					  tb_persona.per_dni AS nrodoc,
					  tb_usuario.usu_email_corporativo AS ecorporativo,
					  tb_usuario.usu_nivel AS codnivel,
					  tb_usuario.usu_tipo AS tipo,
					  tb_persona.per_sexo AS sexo,
					  tb_persona.per_fecha_nacimiento AS fecnacimiento,
					  tb_persona.per_foto AS foto,
					  tb_usuario.usu_activo AS activo,
					  tb_usuario.id_usuario AS idusuario,
					  tb_usuario.usu_notif_encuestas as encuestas,
					  tb_usuario.area_id as idarea,
					  tb_usuario.usu_codente as codentidad 
					FROM
					  tb_persona
					  INNER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
					WHERE  tb_usuario.usu_nick= ?;", array($user));
        //$this->db->close();
        $rslogin=$result->row();
        
        if (isset($rslogin))
        {
        	$clave=sha1($clave);
        	$error='E101';
        	if (($rslogin->clave===$clave) && ($rslogin->activo==='SI'))
        	{
        		//COPROBAR MENSAJES DE MESA DE PARTES
        		

        		$rslogin->idsede=0;
			   	$rslogin->sede="";
			   	$rslogin->nsedes=0;
			   	$rslogin->idinscripcion=0;
        		$resultsd = $this->db->query("SELECT 
				  tb_usuario_sede.cod_sede idsede,
				  tb_usuario_sede.usse_defecto esdefecto,
				  tb_sede.sed_nombre nombre,
				  tb_usuario_sede.usse_activo activo 			  
				FROM
				  tb_sede
				  INNER JOIN tb_usuario_sede ON (tb_sede.id_sede = tb_usuario_sede.cod_sede) 
				  WHERE tb_usuario_sede.cod_usuario=?", array($rslogin->idusuario));
			    if ($rslogin->codnivel=="3"){
			    	$resultins = $this->db->query("SELECT 
					  `ins_identificador` AS idinscripcion,
					  `ins_estado` as estado
					FROM 
					  `tb_inscripcion` WHERE tb_inscripcion.ins_carnet=? limit 1;", array($user));
			    	 $rowins=$resultins->row();
			    	 if ($rowins){
			    	 	$rslogin->idinscripcion=$rowins->idinscripcion;
			    	 }
			    }
			    $iter=$resultsd->num_rows();
			    $error='E102';
			    if ($iter> 0){
				    $rssedes=$resultsd->result();
				    $error='E103';
				    foreach ($rssedes as $keysd => $sede) {
				    	if ($sede->activo=='SI'){
				    		$rslogin->idsede=$sede->idsede;
				    		$rslogin->sede=$sede->nombre;
				    		
				    		if ($sede->esdefecto=='SI'){
					    		$rslogin->idsede=$sede->idsede;
					    		$rslogin->sede=$sede->nombre;
					    		break;
				    		}
				    	}
				    	else{
			    			unset($rssedes[$keysd]);
			    		}
				    }
			    	$rslogin->nsedes=$iter;
			    	if ($rslogin->idsede!=0){
			    		$error="";
			    		$resultps = $this->db->query("SELECT 
							  `cod_accion` codaccion,
							  `uspe_permitido` permitido 
							FROM 
							  `tb_usuario_permiso`
						 	WHERE cod_usuario=? AND cod_sede=?", array($rslogin->idusuario,$rslogin->idsede));
			    		$rspermisos=$resultps->result();
			    	}
				}
				if ($rslogin->tipo=="AL"){
					$rsntf=$this->db->query("SELECT 
						  COUNT(not_id) AS total
						FROM
						  tb_notifica_usuario
						WHERE
						  usu_id = ? AND 
						  nous_vista = 'NO'",array($rslogin->idusuario));
					$rsnotifica=$rsntf->row()->total;
				
	        		$resultdoce = $this->db->query("SELECT 
						  tb_deuda_individual.di_codigo AS coddeuda,
						  tb_deuda_individual.cod_gestion as codgestion,
						  tb_gestion.gt_nombre as gestion,
						  tb_deuda_individual.di_fecha_creacion as creado,
						  tb_deuda_individual.di_fecha_vencimiento as vence,
						  tb_deuda_individual.di_fecha_prorroga as prorroga,
						  tb_deuda_individual.di_monto as monto,
						  tb_deuda_individual.di_saldo as saldo,
						  tb_deuda_individual.matricula_cod as codmatricula,
						  tb_deuda_individual.di_estado as estado,
						  tb_periodo.ped_nombre as periodo,
						  tb_ciclo.cic_nombre as ciclo
						FROM
						  tb_gestion
						  INNER JOIN tb_deuda_individual ON (tb_gestion.gt_codigo = tb_deuda_individual.cod_gestion)
						  LEFT OUTER JOIN tb_matricula ON (tb_deuda_individual.matricula_cod = tb_matricula.mtr_id)
						  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
						  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
						WHERE tb_deuda_individual.pagante_cod=? AND tb_deuda_individual.di_saldo > 0 AND tb_deuda_individual.di_fecha_vencimiento < now() AND tb_deuda_individual.di_estado = 'ACTIVO' ",array($rslogin->usuario));
	        		$rsdeudas=$resultdoce->result();
	        	}
        		
        	}
        }
        if ($error!=='') $rslogin=array();
        return array('login' => $rslogin,'deudas' => $rsdeudas,'permisos' => $rspermisos,'error'=>$error,'sedes'=>$rssedes,'notifica'=> $rsnotifica );
    }

    public function m_iniciar_sesion_google($data)
    {

        //$this->load->database();
        $rslogin=array();
        $rsdeudas=array();
        $rspermisos=array();
        $rssedes=array();
        $rsnotifica=0;
        $error="E100";
        $result = $this->db->query("SELECT 
					 tb_usuario.cod_persona AS codpersona,
					  tb_usuario.usu_nick AS usuario,
					  tb_usuario.usu_clave_sha AS clave,
					  tb_persona.per_apel_paterno AS paterno,
					  tb_persona.per_apel_materno AS materno,
					  tb_persona.per_nombres AS nombres,
					  tb_persona.per_tipodoc AS tipodoc,
					  tb_persona.per_dni AS nrodoc,
					  tb_usuario.usu_email_corporativo AS ecorporativo,
					  tb_usuario.usu_nivel AS codnivel,
					  tb_usuario.usu_tipo AS tipo,
					  tb_persona.per_sexo AS sexo,
					  tb_persona.per_fecha_nacimiento AS fecnacimiento,
					  tb_persona.per_foto AS foto,
					  tb_usuario.usu_activo AS activo,
					  tb_usuario.id_usuario AS idusuario,
					  tb_usuario.usu_notif_encuestas as encuestas,
					  tb_usuario.area_id as idarea,
					  tb_usuario.usu_codente as codentidad 
					FROM
					  tb_persona
					  INNER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
					WHERE  tb_usuario.usu_email_corporativo= ?;", array($data));
        //$this->db->close();
        $rslogin=$result->row();
        
        if (isset($rslogin))
        {
        
        	$error='E101';
        	if (($rslogin->activo==='SI'))
        	{
        		$rslogin->idsede=0;
			   	$rslogin->sede="";
			   	$rslogin->nsedes=0;
			   	$rslogin->idinscripcion=0;
        		$resultsd = $this->db->query("SELECT 
				  tb_usuario_sede.cod_sede idsede,
				  tb_usuario_sede.usse_defecto esdefecto,
				  tb_sede.sed_nombre nombre,
				  tb_usuario_sede.usse_activo activo 			  
				FROM
				  tb_sede
				  INNER JOIN tb_usuario_sede ON (tb_sede.id_sede = tb_usuario_sede.cod_sede) 
				  WHERE tb_usuario_sede.cod_usuario=?", array($rslogin->idusuario));
			    if ($rslogin->codnivel=="3"){
			    	$resultins = $this->db->query("SELECT 
					  `ins_identificador` AS idinscripcion,
					  `ins_estado` as estado
					FROM 
					  `tb_inscripcion` WHERE tb_inscripcion.ins_carnet=? limit 1;", array($rslogin->usuario));
			    	 $rowins=$resultins->row();
			    	 if ($rowins){
			    	 	$rslogin->idinscripcion=$rowins->idinscripcion;
			    	 }
			    }
			    $iter=$resultsd->num_rows();
			    $error='E102';
			    if ($iter> 0){
				    $rssedes=$resultsd->result();
				    $error='E103';
				    foreach ($rssedes as $keysd => $sede) {
				    	if ($sede->activo=='SI'){
				    		$rslogin->idsede=$sede->idsede;
				    		$rslogin->sede=$sede->nombre;
				    		
				    		if ($sede->esdefecto=='SI'){
					    		$rslogin->idsede=$sede->idsede;
					    		$rslogin->sede=$sede->nombre;
					    		break;
				    		}
				    	}
				    	else{
			    			unset($rssedes[$keysd]);
			    		}
				    }
			    	$rslogin->nsedes=$iter;
			    	if ($rslogin->idsede!=0){
			    		$error="";
			    		$resultps = $this->db->query("SELECT 
							  `cod_accion` codaccion,
							  `uspe_permitido` permitido 
							FROM 
							  `tb_usuario_permiso`
						 	WHERE cod_usuario=? AND cod_sede=?", array($rslogin->idusuario,$rslogin->idsede));
			    		$rspermisos=$resultps->result();
			    	}
				}

				if ($rslogin->tipo=="AL"){
					$rsntf=$this->db->query("SELECT 
						  COUNT(not_id) AS total
						FROM
						  tb_notifica_usuario
						WHERE
						  usu_id = ? AND 
						  nous_vista = 'NO'",array($rslogin->idusuario));
					$rsnotifica=$rsntf->row()->total;
					
					$resultdoce = $this->db->query("SELECT 
						  tb_deuda_individual.di_codigo AS coddeuda,
						  tb_deuda_individual.cod_gestion as codgestion,
						  tb_gestion.gt_nombre as gestion,
						  tb_deuda_individual.di_fecha_creacion as creado,
						  tb_deuda_individual.di_fecha_vencimiento as vence,
						  tb_deuda_individual.di_fecha_prorroga as prorroga,
						  tb_deuda_individual.di_monto as monto,
						  tb_deuda_individual.di_saldo as saldo,
						  tb_deuda_individual.matricula_cod as codmatricula,
						  tb_deuda_individual.di_estado as estado,
						  tb_periodo.ped_nombre as periodo,
						  tb_ciclo.cic_nombre as ciclo
						FROM
						  tb_gestion
						  INNER JOIN tb_deuda_individual ON (tb_gestion.gt_codigo = tb_deuda_individual.cod_gestion)
						  LEFT OUTER JOIN tb_matricula ON (tb_deuda_individual.matricula_cod = tb_matricula.mtr_id)
						  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
						  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
						WHERE tb_deuda_individual.pagante_cod=? AND tb_deuda_individual.di_saldo > 0 AND tb_deuda_individual.di_fecha_vencimiento < now()",array($rslogin->usuario));
					$rsdeudas=$resultdoce->result();
	        	}
        		
        	}
        }
        if ($error!=='') $rslogin=array();
        return array('login' => $rslogin,'deudas' => $rsdeudas,'permisos' => $rspermisos,'error'=>$error,'sedes'=>$rssedes,'notifica'=> $rsnotifica );
    }

 	public function m_perfil($data)
    {
        $rsperfil=array();
        //$rsdeudas=array();
        $result = $this->db->query("SELECT 
		  tb_usuario.cod_persona AS codpersona,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_usuario.usu_email_corporativo AS ecorporativo,
		  tb_persona.per_sexo AS sexo,
		  tb_persona.per_fecha_nacimiento AS fecnacimiento,
		  tb_persona.per_foto AS foto,
		  tb_usuario.usu_activo AS activo,
		  tb_persona.cod_distrito AS coddistrito,
		  tb_distrito.dis_nombre AS distrito,
		  tb_provincia.prv_nombre AS provincia,
		  tb_departamento.dep_nombre AS departamento,
		  tb_persona.per_tipodoc AS tipodoc,
		  tb_persona.per_dni AS numero,
		  tb_persona.per_celular AS celular,
		  tb_persona.per_celular2 AS celular2,
		  tb_persona.per_email_personal AS epersonal,
		  tb_persona.per_domicilio AS domicilio,
		  tb_persona.per_domicilio_secundario AS domicilio2,
		  tb_persona.per_telefono AS telefono,
		  tb_nivel.niv_nombre AS nivel
		FROM
		  tb_persona
		  INNER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
		  INNER JOIN tb_nivel ON (tb_usuario.usu_nivel = tb_nivel.niv_codigo)
		  INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
		  INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
		  INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
		 WHERE tb_persona.per_codigo=?", $data);
        //$this->db->close();
        $rsperfil=$result->row();
        return array('perfil' => $rsperfil);
    }

   public function m_tipo_conteo()
    {
        //$rsdeudas=array();
        $result = $this->db->query("SELECT usu_tipo as tipo, count(`id_usuario`) as conteo FROM `tb_usuario` group by usu_tipo");
        //$this->db->close();
        return $result->result();
    }

    
    public function m_filtrar_cuentas_alum($data)
    {
        $rscuentas=array();
        
        $sqltext_array=array();
	    $data_array=array();
	    if ($data[0]!="%%") {
        	$sqltext_array[]="concat(tb_usuario.usu_nick, ' ',tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno ,' ',tb_persona.per_nombres) like ?";
        	$data_array[]=$data[0];
      	}
	    
      	if ($data[1]!="%")  {
        	$sqltext_array[]="tb_inscripcion.ins_sede = ?";
        	$data_array[]=$data[1];
      	}
      	if ($data[2]!="%")  {
        	$sqltext_array[]="tb_usuario.usu_activo = ?";
        	$data_array[]=$data[2];
      	}
      	if ($data[3]!="%")  {
        	$sqltext_array[]="tb_usuario.usu_email_corp_generado = ?";
        	$data_array[]=$data[3];
      	}
      	$sqltext_array[]="tb_usuario.usu_tipo = 'AL'";

      	$sqltext=implode(' AND ', $sqltext_array);
      	if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
		  tb_usuario.cod_persona AS codpersona,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_usuario.usu_email_corporativo AS ecorporativo,
		  tb_usuario.usu_nick AS usuario,
		  tb_persona.per_foto AS foto,
		  tb_usuario.usu_activo AS activo,
		  tb_nivel.niv_nombre AS nivel,
		  tb_usuario.id_usuario as idusuario,
		  tb_usuario.usu_nivel  as codnivel,
		  tb_usuario.usu_email_corp_generado as email_generado,
		  tb_inscripcion.ins_sede as idsede
		FROM
		  tb_persona
		  INNER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
		  INNER JOIN tb_nivel ON (tb_usuario.usu_nivel = tb_nivel.niv_codigo)
		  INNER JOIN tb_inscripcion ON (tb_usuario.usu_codente = tb_inscripcion.ins_identificador)
		$sqltext
		ORDER BY tb_persona.per_apel_paterno, tb_persona.per_apel_materno ,tb_persona.per_nombres  " , $data_array);

        $rscuentas=$result->result();
        return array('usuarios' => $rscuentas);
    }
    
    public function m_filtrar_cuentas_adm_doc($data)
    {
        $rscuentas=array();

        $sqltext_array=array();
	    $data_array=array();
	    if ($data[0]!="%%") {
        	$sqltext_array[]="concat(tb_usuario.usu_nick, ' ',tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno ,' ',tb_persona.per_nombres) like ?";
        	$data_array[]=$data[0];
      	}
      	if ($data[1]!="%")  {
        	$sqltext_array[]="tb_docente.ins_sede = ?";
        	$data_array[]=$data[1];
      	}
      	if ($data[2]!="%")  {
        	$sqltext_array[]="tb_usuario.usu_activo = ?";
        	$data_array[]=$data[2];
      	}
      	if ($data[3]!="%")  {
        	$sqltext_array[]="tb_usuario.usu_email_corp_generado = ?";
        	$data_array[]=$data[3];
      	}
      	$sqltext_array[]="tb_usuario.usu_tipo <> 'AL'";

      	$sqltext=implode(' AND ', $sqltext_array);
      	if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

        $result = $this->db->query("SELECT 
		  tb_usuario.cod_persona AS codpersona,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_usuario.usu_email_corporativo AS ecorporativo,
		  tb_usuario.usu_nick AS usuario,
		  tb_persona.per_foto AS foto,
		  tb_usuario.usu_activo AS activo,
		  tb_nivel.niv_nombre AS nivel,
		  tb_usuario.id_usuario as idusuario,
		  tb_usuario.usu_nivel  as codnivel,
		  tb_usuario.usu_email_corp_generado as email_generado,
		  tb_docente.ins_sede as idsede
		FROM
		  tb_persona
		  INNER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
		  INNER JOIN tb_nivel ON (tb_usuario.usu_nivel = tb_nivel.niv_codigo)
		  INNER JOIN tb_docente ON (tb_usuario.usu_codente = tb_docente.doc_codigo)
		$sqltext
		ORDER BY tb_persona.per_apel_paterno, tb_persona.per_apel_materno ,tb_persona.per_nombres  " , $data_array);
        $rscuentas=$result->result();
        return array('usuarios' => $rscuentas);
    }

    public function m_activado_email_generado($data)
    {
    	$this->db->query("CALL `sp_tb_usuario_update_email_generado`(?,?,@s,@nid)",$data);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        return $res->row();
        
    }


    public function m_get_usuarios_administrativos()
    {
        $result = $this->db->query("SELECT 
		  tb_usuario.cod_persona AS codpersona,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_usuario.usu_email_corporativo AS ecorporativo,
		  tb_usuario.usu_nick AS usuario,
		  tb_persona.per_foto AS foto,
		  tb_usuario.usu_activo AS activo,
		  tb_nivel.niv_nombre AS nivel,
		  tb_usuario.id_usuario as idusuario,
		  tb_usuario.usu_nivel  as codnivel,
		  tb_usuario.usu_codente as codtrabajador
		FROM
		  tb_persona
		  INNER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
		  INNER JOIN tb_nivel ON (tb_usuario.usu_nivel = tb_nivel.niv_codigo)
		WHERE  tb_usuario.usu_tipo='AD' OR   tb_usuario.usu_tipo='DA' 
		ORDER BY tb_persona.per_apel_paterno, tb_persona.per_apel_materno ,tb_persona.per_nombres" );

        return $result->result();
    }

    public function m_update_tipo_correo_area_x_codente($data)
    {
        
        $result = $this->db->query("UPDATE  `tb_usuario`  
        	SET 	
		  `usu_email_corporativo` = ?,
		  `usu_tipo` = ?,
		  `area_id` = ? 
		WHERE  `usu_codente` = ? AND usu_tipo=?;",$data);

        return true;
        
    }

    public function m_get_areas()
    {
        $rscuentas=array();
        //$rsdeudas=array();
        $result = $this->db->query("SELECT 
		  `are_codigo` as codarea,
		  `are_nombre` as nombre 
		FROM 
		  `tb_area`
		 WHERE `are_activo`='SI';");

        return $result->result();
        
    }


    public function m_notificaciones_x_user_ponervisto($data)
    {
        $result = $this->db->query("SELECT 
			  tb_notificaciones.not_detalle as detalle,
			  tb_notificaciones.not_link as  link,
			  tb_notificaciones.not_fecha_creacion as fecha,
			  tb_notifica_usuario.nous_codmiembro as codmiembro
			FROM
			  tb_notifica_usuario
			  INNER JOIN tb_notificaciones ON (tb_notifica_usuario.not_id = tb_notificaciones.not_id) 
			 WHERE tb_notifica_usuario.usu_id=? ORDER BY tb_notificaciones.not_fecha_creacion DESC LIMIT 15" , $data);
        $filas=$result->result();
        if (count($filas)>0) {
        	$this->db->query("UPDATE `tb_notifica_usuario`  SET `nous_vista` = 'SI' WHERE `usu_id` =?" , $data);
       	}
       	return $filas;
    }

    public function m_total_notifica_x_user($data)
    {
        $rsntf=$this->db->query("SELECT COUNT(not_id) AS total FROM  tb_notifica_usuario WHERE	  usu_id = ? AND  nous_vista = 'NO'",$data);
		return $rsntf->row()->total;

    }


    	
    public function m_asignar_sedes($dinsert,$dedit,$ddelete)
    {
        $rscuentas=array();
        //$rsdeudas=array();
        foreach ($dinsert as $ins) {
        	$ins[1]=base64url_decode($ins[1]);
        	$result = $this->db->query("INSERT INTO `tb_usuario_sede` (`cod_sede`,`cod_usuario`,`usse_defecto`) 
				VALUE ( ?, ?, ?);", $ins);
        }
        foreach ($dedit as $edi) {
        	$edi[1]=base64url_decode($edi[1]);
        	$result = $this->db->query("UPDATE `tb_usuario_sede`  SET  `usse_defecto` = ? 
				WHERE 
				  `cod_usuario` = ? AND `cod_sede` = ?;", $edi);
        }
		foreach ($ddelete as $del) {
			$del[1]=base64url_decode($del[1]);
        	$result = $this->db->query("DELETE FROM `tb_usuario_sede` WHERE `cod_sede` = ? AND `cod_usuario` = ?  ;", $del);
        }

        return true;
        
    }

    public function m_cambiar_acceso($data)
    {
    	//user,$clave,$correo,$iduser
    	if ($data[1]==""){
    		$result = $this->db->query("UPDATE  `tb_usuario`  SET  `usu_nick` = ?, `usu_email_corporativo` = ? WHERE  `id_usuario` = ?;", array($data[0],$data[2],$data[3]));
    	}
    	else{
    		$data[1]=sha1($data[1]);
    		$result = $this->db->query("UPDATE  `tb_usuario`  SET  `usu_nick` = ?, `usu_clave_sha` = ?, `usu_email_corporativo` = ? WHERE  `id_usuario` = ?;", $data);
    	}

        return true;
        
    }
    public function m_cambiar_clave($data)
    {
    	//user,$clave,$correo,$iduser
    	
    	$this->db->query("UPDATE  `tb_usuario`  SET  `usu_clave_sha` = ? WHERE  `id_usuario` = ? AND `usu_clave_sha` = ?;", $data);
        return $this->db->affected_rows();
    }



    public function m_activado($data)
    {
	 	$this->db->query("UPDATE  `tb_usuario`  SET  `usu_activo` = ? WHERE  `id_usuario` = ?;",$data);
        return true;
        
    }

     public function m_eliminar($data)
    {
	 	$this->db->query("DELETE FROM `tb_usuario` WHERE  `id_usuario` = ?;",$data);
        return true;
        
    }

    public function m_insert_acceso($data)
    {
	 	$this->db->query("INSERT INTO  `tb_usuario_accesos`( `per_codigo`) VALUE (?);",$data);
        return true;
        
    }
//CALL ``( @vcarga, @vsubseccion, @vdetalle, @vlink, @vusuario, @`s`);
    public function m_insert_notificacion($data)
    {
	 	$this->db->query("CALL `sp_tb_notificacion_insert`(?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;
    }




}
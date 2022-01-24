<style>
	@import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@1,500&display=swap');
	@page {
		margin: 0;
		
	}
	.div_logo{
		float: left;
	
		border:0;
		width: 70%;
	}
	.logo-ies{
		height:  40px;
	}
	.div_datedoc {
		padding: 5px;
		float: right;
		width: 20%;
		font-size: 16px;
		font-weight: bold;
		/*text-align: right;*/
		border: solid 1px gray;
		border: none;
		-moz-border: none;
		-webkit-border: none;
	}

	.div_titledoc {
		margin-top: -55px;
		float: left;
		width: 100%;
		text-align: center;
	}

	.div_fechareport {
		margin-top: -10px;
		float: left;
		width: 100%;
		text-align: center;
	}

	.div_emisor{
		padding: 5px;
		float: right;
		width: 30%;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		font-size: 16px;
		font-weight: bold;
		text-align: center;
		border: solid 1px gray;

	}
	.div_filial{
		margin-top: 5px;
		float: left;
		width: 62%;
		border: 0px;
		-moz-border: 0px;
		-webkit-border: 0px;
		font-size: 16px;
		font-weight: bold;
		padding: 5px;
		margin-bottom: -20px;

	}

	.div_grupo{
		margin-top: 5px;
		float: left;
		width: 100%;
		border: 0px;
		-moz-border: 0px;
		-webkit-border: 0px;
		font-size: 16px;
		font-weight: bold;
		padding: 5px;
		margin-top: 20px;

	}

	.div_detalle{
		
		margin-top: 5px;
		width: 100%;
		font-size: 10px;

	}

	.div_detalle_header {
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border: solid 1px gray;
	}

	.mb{
		margin-bottom: 5px;
	}
	.encabezado{
		width: 100%;
		border-collapse: collapse;

	}
	
	.margin-top{
		margin-top: 5px;
	}
	.text-small-5 {
		font-size: 10px;
	}
	.text-small-4 {
		font-size: 9px;
	}
	
	
	.celda-lados{
		height: 15px;
		font-size: 11px;
	}
	
	.cleft-nobold {
		text-align: left;
		padding-left: 20px;
	}
	
	.ccenter-nobold{
		text-align: center;
	}
	.right-nobold{
		text-align: right;
		padding-right: 3px;
	}
	.w25p{
		width: 5cm;
	}
	.text-footer {
		font-style: italic;
		font-size: 11px;
	}
	.bg-detalle {
		background-color: #BDC3C7;
		color: #fff;
		font-size: 11px;
		height: 25px;
		/*border-radius: 10pt;*/
	}

	.bg_detalle {
		/*background-color: #BDC3C7;*/
		/*color: #fff;*/
		font-size: 11px;
		height: 25px;
		/*border-radius: 10pt;*/
	}

	.border-top{
		border-top: 0.5px solid gray;
	}

	.border-bottom {
		/*border-top: #000 1px dotted;*/
		border-bottom: #000 2px dotted;
		padding: 2px 0;
	}

	.margin-top {
		margin-top: 1px;
	}

	.padding {
		padding: 5px 0;
	}


</style>
<?php
	date_default_timezone_set ('America/Lima');
	$fechahoy = date("d/m/Y");
	$horahoy = date("h:i:s a");
	
?>
<div class="div_logo">
	<img class="logo-ies mb" src="<?php echo base_url().'resources/img/logo_facturacion.'.getDominio().'.png' ?>" alt="Logo"><br>
</div>

<div class="div_datedoc">
	<table width="100%" class="text-small-4" cellpadding="0" >
		<tr>
			<td><b>Fecha </b></td>
			<td><b>:</b></td>
			<td align="right"><?php echo $fechahoy ?></td>
		</tr>
		<tr>
			<td><b>Hora </b></td>
			<td><b>:</b></td>
			<td align="right"><?php echo $horahoy ?></td>
		</tr>
	</table>
</div>

<div class="div_titledoc">
	<h5>REPORTE DE DOCUMENTOS ANEXADOS</h5>
</div>

<div class="div_filial">
	<table class="text-small-5" cellpadding="0">
		<tr>
			<td colspan="2"><b><?php echo $ies->denoml ?> - FILIAL</b></td>
			<td>: <?php echo $_SESSION['userActivo']->sede ?></td>
		</tr>			
		
	</table>
</div>

<?php
	$nro = 0;
	$grupo = "";
	foreach ($ins as $key => $value) {
		$nro++;
		$codins = $value->codinscripcion;
		$grupoint=$value->codperiodo.$value->codcarrera.$value->codciclo.$value->codturno.$value->codseccion.$value->codcampania;
		if ($grupo!=$grupoint) {
            $grupo=$grupoint;
?>
	<div class="div_grupo">
		<table class="text-small-5" cellpadding="0">
			<tr>
				<td><b>PERIODO</b></td>
				<td>: <?php echo $value->periodo ?></td>
				<td width="50px"></td>
				<td><b>PROGRAMA PROFESIONAL</b></td>
				<td>: <?php echo $value->carrera ?></td>
			</tr>			
			<tr>
				<td><b>SEMESTRE ACADÉMICO</b></td>
				<td>: <?php echo $value->ciclo ?></td>
				<td width="50px"></td>
				<td><b>TURNO</b></td>
				<td>: <?php echo $value->turno ?></td>
				<td width="50px"></td>
				<td><b>SECCIÓN</b></td>
				<td>: <?php echo $value->seccion ?></td>
				<td width="50px"></td>
				<td><b>CAMPAÑA</b></td>
				<td>: <?php echo $value->campania ?></td>
			</tr>
		</table>
	</div>
	<div class="div_detalle div_detalle_header">
		<table class="encabezado celda-lados" cellpadding="0" cellspacing="0" >
			<tr>
				<td class="ccenter-nobold bg_detalle" width="50px">
					<b>N°</b>
				</td>
				<td class="cleft-nobold bg_detalle" width="360px">
					<b>ALUMNO</b>
				</td>
				
				<td class="bg_detalle cleft-nobold" width="360px"><b>DOCUMENTOS ANEXADOS</b></td>
				<td class="bg_detalle cleft-nobold" width="300px"><b>OBSERVACIONES</b></td>
			</tr>
		</table>
	</div>
<?php
			$nro=0;
        }
        $nro++;
?>
	<div class="div_detalle mb margin-top">
		<table class="encabezado celda-lados" cellpadding="0" cellspacing="0" >
			<tr>
				<td class="border-bottom text-small-5 ccenter-nobold" width="50px"><?php echo $nro ?></td>
				<td class="border-bottom text-small-5 ccenter-nobold" width="60px"><?php echo $value->carnet ?></td>
				<td class="border-bottom text-small-5 cleft-nobold" width="300px">
					<?php echo $value->paterno." ".$value->materno." ".$value->nombres ?>
				</td>
				<td class="border-bottom text-small-5 cleft-nobold" width="360px">
					<?php
						$anexos = "";
						$anexos = $this->db->query("SELECT 
							tb_inscripcion_docanexados.doan_id as idanexa,
							tb_doc_anexar.doan_nombre as anexanombre
							FROM tb_inscripcion_docanexados
							INNER JOIN tb_doc_anexar ON (tb_inscripcion_docanexados.doan_id = tb_doc_anexar.doan_id)
							WHERE tb_inscripcion_docanexados.ins_identificador = $codins");
						$docadjunto = "";
						foreach ($anexos->result() as $key => $anx) {
							$docadjunto = $docadjunto."$anx->anexanombre, ";
						}
						echo substr($docadjunto,0,-2);
					?>
				</td>
				<td class="border-bottom text-small-5 cleft-nobold" width="300px"><?php echo $value->observacion ?></td>
			</tr>
		</table>
	</div>
<?php
	}
?>



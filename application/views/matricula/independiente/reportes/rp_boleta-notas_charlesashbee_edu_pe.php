<!--$fechas
$asistencias
$sesiones
$evaluaciones
$notas
$miembros
$curso-->
<style>
	@page {
		margin-top: 1.0cm;
		margin-bottom: 1.0cm;
		margin-left: 1.0cm;
		margin-right: 1.0cm;
	}
	
	.encabezado{
		width: 100%;
		border-collapse: collapse;
		margin-bottom: 8px;
	}
	.tabla-sm{
		width: 100%;
		border-collapse: collapse;
		margin-bottom: 0px;
	}
	.p-0{
		padding: 0px !important;
	}
	.logo-minedu{
		width: 200px;
		height: 60px;
	}
	.logo-ies{
		height: 70px;
	}
	.td-drep{
		background-color: #808080;
		padding-top: 8px;
		padding-bottom: 0px;
		color: white;
		width: 140px;
		height: 60px;
		font-size: 12px;
		font-weight: bold;
	}
	.td-iesname{
		/*background-color: #548DD4;color: white;*/
		color:black;
		padding-top: 8px;
		padding-bottom: 0px;
		
		width: 260px;
		height: 60px;
		font-size: 11px;
		font-weight: bold;
	}
	.celda{
		height: 15px;
		padding: 2px;
		border: solid 1px black;
		font-size: 10px;
	}
	.td-rd{
		height: 15px;
		font-size: 10px;
		text-align: left;
	}
	.texto{
		height: 20px;
		padding: 5px;
		font-size: 11px;
	}
	.firmas{
		height: 20px;
		padding: 5px;
		font-size: 10px;
	}
	.cverde{
		background-color: #00B050;
		color: white;
	}
	.cceleste{
		background-color: #00B0F0;
		color: white;
	}
	
	.ccenter{
		text-align: center;
		font-weight: bold;
	}
	.ccenter-nobold{
		text-align: center;
	}

</style>

<?php
$reg=count($mats);
foreach ($mats as $mat) { 
	$reg--;
?>

<table class="tabla-sm" border="0">
	<tr>
		
		<td colspan="4" class="td-rd">
			<span>R.M.N° 0568 – 94 ED | </span>
			<span>Revadilación: R.D.N° 079 – 2005 – ED</span>
			<hr style="margin-top: 2px">
		</td>
		
	</tr>
	<tr>
		<td style="width: 200px" valign="top" align="right" class="p-0">
			<img class="logo-minedu" src="<?php echo base_url().'resources/img/minedu_logo_sb.png' ?>" alt="MINEDU">
		</td>
		<td valign="top" align="center" class="td-drep">
			<span>Dirección Regional <br>
				de Educaión <br>
			PIURA</span>
		</td>
		<td valign="top" align="center" class="td-iesname">
			<b>INSTITUTO DE EDUCACIÓN
				SUPERIOR TECNOLÓGICO PRIVADO<br>
				<h2>"CHARLES ASHBEE"</h2>
			</b>
		</td>
		<td rowspan="2" valign="top" align="center" class="p-0">
		
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h110.charlesashbee.edu.pe.jpg' ?>" alt="IESTP">
		</td>
		
	</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td colspan="4" valign="top" align="center">
			 
		</td>
	</tr>
</table>
<table class="encabezado">
	

	<tr>
		<td  valign="top" align="center">
			<br>
			<h3><b>BOLETA DE NOTAS PERIODO LECTIVO <?php echo $mat->periodo ?></b></h3>
		</td>
	</tr>
</table>
<?php 
	$colorbg="";//($mat->codcarrera==3)?"cverde":"cceleste";
 ?>
<table class="encabezado">
	<tr>
		<td class="celda texto <?php echo $colorbg ?>">
			APELLIDOS Y NOMBRES:
		</td>
		<td colspan="2" class="celda texto">
			<span><?php echo "<b>$mat->paterno $mat->materno $mat->nombres</b>" ?></span>
		</td>
		<td class="celda texto <?php echo $colorbg ?>">
			DNI:
		</td>
		<td class="celda texto">
			<span><?php echo "<b>$mat->dni</b>" ?></span>
		</td>
		
	</tr>
	
	<tr>
		<td class="celda texto <?php echo $colorbg ?>">
			<span>PROGRAMA DE ESTUDIOS:</span>
		</td>
		<td class="celda texto">
			<span><?php echo "<b>$mat->carrera</b>" ?></span>
		</td>
		<td class="celda texto <?php echo $colorbg ?>">
			<span>SEMESTRE ACADÉMICO</span>
		</td>
		<td colspan="2" class="celda texto">
			<span><b><?php echo strtoupper($mat->ciclol)." ".$mat->codseccion ?></b></span>
		</td>
	</tr>
</table>

<table class="encabezado">

	<tr>
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>N°</small>
		</td>
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>UNIDADES DIDÁCTICAS</small>
		</td>
		
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>CRÉDITOS</small>
		</td>
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>NOTA</small>
		</td>
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>PUNTAJE</small>
		</td>
	</tr>
	<?php
	$nro=0;
	$isrepite=false;
	$vhoras=0;
	$vcre=0;
	foreach ($curs as $kc => $cur) {
		$nro++;
		$pxc=0;
		
		if ($cur->matricula==$mat->matricula){

	?>
	
	<tr>
		<td class="celda ccenter-nobold">
			<span><?php echo $nro ?></span>
		</td>
		<td class="celda">
			<span><?php echo $cur->curso ?></span>
		</td>

		<td class="celda ccenter-nobold">
			<span><?php 
			$vcre= $vcre + $cur->cp + $cur->ct;
			echo $cur->cp + $cur->ct; ?></span>
		</td>
		<?php 
			if (($cur->estado=='DPI') || ($cur->estado=='NSP')){
		?>
			<td class="celda ccenter-nobold">
				<span><?php echo "--" ?></span>
			</td>
			<td class="celda ccenter-nobold">
				<span><?php echo "--" ?></span>
			</td>
			
			
		<?php }
		else { ?>
			<td class="celda ccenter-nobold">
				<span><?php echo $cur->final ?></span>
			</td>
			<td class="celda ccenter-nobold">
				<span><?php 
				$pt=$cur->final * ($cur->cp + $cur->ct);
				$pxc= $pt  + $pxc; 
				echo  $pt ?></span>
			</td>
		<?php } ?>
	</tr>
	<?php 
		unset($curs[$kc]);
		/*}
		else{
			$isrepite=true;
		}*/
	} 
	} ?>
	

</table>

<br>
<table class="encabezado">
	<tr>
		
		<td class="firmas ccenter-nobold">
			<img src="<?php echo base_url().'resources/img/firma_sec_academico.charlesashbee.edu.pe.jpg' ?>" alt="MINEDU"><br>
			------------------------------------------------------ <br>
			SECRETARÍA ACADÉMICA 	<br>
		</td>
		<td class="firmas" align="right">
			<?php 
			date_default_timezone_set('America/Lima');
			$fecha = date('m/d/Y h:i:s a', time());
			$hora=date('h:i A');
			  //$fecha=time();
			  $fecha = substr($fecha, 0, 10);
			  $numeroDia = date('d', strtotime($fecha));
			  $dia = date('l', strtotime($fecha));
			  $mes = date('F', strtotime($fecha));
			  $anio = date('Y', strtotime($fecha));
			  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
			  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
			  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
			  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
			 ?>
			<?php echo "$ies->distrito , $nombredia $numeroDia de $nombreMes de $anio <br> Hora: $hora"; ?>
		</td>
	</tr>
	
</table>


<?php
	if ($reg>0) {
		echo "<pagebreak>";

	};
 } ?>
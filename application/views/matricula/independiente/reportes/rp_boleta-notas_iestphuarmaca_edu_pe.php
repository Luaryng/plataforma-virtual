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
		background-color: #548DD4;
		padding-top: 8px;
		padding-bottom: 0px;
		color: white;
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
		font-size: 12px;
		text-align: center;
	}
	.texto{
		height: 20px;
		padding: 3px;
		font-size: 12px;
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
				SUPERIOR TECNOLÓGICO PÚBLICO<br>"HUARMACA"
			</b>
		</td>
		<td rowspan="2" valign="top" align="center" class="p-0">
		
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_esp.iestphuarmaca.edu.pe.jpg' ?>" alt="IESTP">
		</td>
		
	</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td colspan="4" valign="top" align="center">
			<b>ESFUERZO, SACRIFICIO Y DECISIÓN</b>
		</td>
	</tr>
</table>
<table class="encabezado">
	<tr>
		<td class="td-rd">
			<u>R.E.R.N° 197-91-RGP;06/05/1991</u>
		</td>
		<td class="td-rd">
			<u>R.M.N° 0296-94-ED;07/04/1994</u>
		</td>
		<td class="td-rd">
			<u>R.D. ° 0525-2006-D;21/07/2006</u>
		</td>
	</tr>
	<tr>
		<td class="td-rd">
			<b>CREACIÓN</b>	
		</td>
		<td class="td-rd">
			<b>RECONOCIMIENTO</b>
		</td>
		<td class="td-rd">
			<b>REVALIDACIÓN</b>
		</td>
	</tr>
	<tr>
		<td colspan="3" valign="top" align="center">
			<hr style="margin-top: 2px">
			<h3><b>BOLETA DE NOTAS PERIODO LECTIVO <?php echo $mat->periodo ?></b></h3>
		</td>
	</tr>
</table>
<?php 
	$colorbg=($mat->codcarrera==3)?"cverde":"cceleste";
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
			<span>PERÍODO ACADÉMICO</span>
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
			<small>N° HORAS</small>
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
	$pxc=0;
	foreach ($curs as $kc => $cur) {
		$nro++;
		
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
			$vhoras= $vhoras + $cur->hts + $cur->hps;
			echo $cur->hts + $cur->hps; ?></span>
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
	<tr>
		<td></td>
		<td class="celda ccenter">
			<span>TOTAL</span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $vhoras ?></span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $vcre ?></span>
		</td>

		
		<td class="celda ccenter">
			<span><?php echo round($pxc / $vcre, 2)  ?></span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $pxc ?></span>
		</td>

	</tr>

</table>






<table class="encabezado">
	<tr>
		
		<td class="firmas ccenter-nobold">
			<img src="<?php echo base_url().'resources/img/firma_dir_general.iestphuarmaca.edu.pe.png' ?>" alt="DIRECTOR"><br>
			------------------------------------------------------ <br>
			DIRECTOR GENERAL<br>
		</td>
		<td class="firmas ccenter-nobold">
			<img src="<?php echo base_url().'resources/img/firma_sec_academico.iestphuarmaca.edu.jpg' ?>" alt="SEC. ACADÉMICO"><br>
			------------------------------------------------------ <br>
			SECRETARÍA ACADÉMICA<br>
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
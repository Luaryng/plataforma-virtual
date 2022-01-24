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
	.logo-minedu{
		width: 200px;
	}

	.logo-ies{
		height:  70px;
	}
	.celda{
		height: 15px;
		padding: 2px;
		border: solid 1px black;
		font-size: 10px;
	}
	.texto{
		height: 20px;
		padding: 5px;
		font-size: 10px;
	}
	.firmas{
		height: 20px;
		padding: 5px;
		font-size: 10px;
	}
	.cgris{
		background-color: lightgray;
	}
	.ccenter{
		text-align: center;
		font-weight: bold;
	}
	.ccenter-nobold{
		text-align: center;
	}
	.w25p{
		width: 5cm;
	}
</style>

<?php
$reg=count($mats);
foreach ($mats as $mat) { 
	$reg--;
?>

<table class="encabezado">

	<tr>
		<td width="100px">
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h110.'.getDominio().'.png' ?>" alt="iestcanchaque">
		</td>
		<td colspan="2" valign="top" align="center">
			<b><?php echo $ies->denoml ?></b><br><br>
			<h3><b>BOLETA DE NOTAS</b></h3>
		</td>
		
	</tr>
</table>
<table class="encabezado">
	<tr>
		<td class="texto">
			ALUMNO :
		</td>
		<td class="texto">
			<span><?php echo "$mat->carne / <b>$mat->paterno $mat->materno $mat->nombres</b>" ?></span>
		</td>
		
	</tr>
	
	<tr>
		<td class="texto">
			<span><?php echo "PERIODO: <b>$mat->periodo</b>" ?></span>
		</td>
		<td class="texto">
			<span><?php echo "PROG. ACAD.: <b>$mat->carrera</b>" ?></span>
		</td>
		<td class="texto">
			<span><?php echo "CICLO: <b>$mat->ciclo</b>" ?></span>
		</td>
		<td class="texto">
			<span><?php echo "TURNO: <b>$mat->turno</b>" ?></span>
		</td>
	</tr>
</table>

<table class="encabezado">

	<tr>
		<td  class="celda ccenter">
			<small>N°</small>
		</td>
		<td  class="celda ccenter">
			<small>UNIDADES DIDACTICAS</small>
		</td>
		<td  class="celda ccenter">
			<small>V°B°</small>
		</td>
		<td  class="celda ccenter">
			<small>MÓD.</small>
		</td>
		<td  class="celda ccenter">
			<small>HORAS</small>
		</td>
		<td  class="celda ccenter">
			<small>CRÉD.</small>
		</td>
		<td  class="celda ccenter">
			<small>PROM.</small>
		</td>
		<td  class="celda ccenter">
			<small>REC.</small>
		</td>
		<td  class="celda ccenter">
			<small>P.F.</small>
		</td>
		<td  class="celda ccenter">
			<small>PTJ.</small>
		</td>
		<td  class="celda ccenter">
			<small>EST.</small>
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
			<span></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $cur->nromodulo ?></span>
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
			if (($cur->dpi=='DPI') || ($cur->dpi=='NSP')){
		?>
			<td class="celda ccenter-nobold">
				<span><?php echo "--" ?></span>
			</td>
			<td class="celda ccenter-nobold">
				<span><?php echo "--" ?></span>
			</td>
			<td class="celda ccenter-nobold">
				<span><?php echo "--" ?></span>
			</td>
			<td class="celda ccenter-nobold">
				<span><?php echo "--" ?></span>
			</td>
			
			
		<?php }
		else { ?>
			<td class="celda ccenter-nobold">
				<span><?php echo $cur->nota ?></span>
			</td>
			<td class="celda ccenter-nobold">
				<span><?php echo $cur->recuperacion ?></span>
			</td>
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
		<td class="celda ccenter-nobold">
			<span><?php echo $cur->dpi ?></span>
		</td>
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
		<td colspan="3"></td>
		<td class="celda ccenter">
			<span>TOTAL</span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $vhoras ?></span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $vcre ?></span>
		</td>

		<td colspan="3" class="celda ccenter">
			<span>PONDERADO</span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $pxc ?></span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $pxc / $vcre ?></span>
		</td>

	</tr>

</table>

<table class="encabezado">
	<tr>
		<td class="firmas">
			OBSERVACIONES: ________________________________________________________________________________________________________________________________	<br><br>	
			____________________________________________________________________________________________________________________________________________________
		</td>
		
	</tr>
</table>
<br>
<table class="encabezado">
	<tr>
		
		<td class="firmas ccenter-nobold">
			<br>
			------------------------------------------------------ <br>
			SECRETARÍA ACADÉMICA 	<br>
		</td>
		<td class="texto" align="right">
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
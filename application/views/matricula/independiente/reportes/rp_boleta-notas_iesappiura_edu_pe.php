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
		height: 50px;
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
		
		width: 500px;
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
$unidades = array('CERO','UNO ','DOS ','TRES ','CUATRO ','CINCO ','SEIS ','SIETE ','OCHO ','NUEVE ','DIEZ ','ONCE ','DOCE ','TRECE ','CATORCE ','QUINCE ','DIECISEIS ','DIECISIETE ','DIECIOCHO ','DIECINUEVE ','VEINTE ');

$sede = $_SESSION['userActivo']->sede;
foreach ($mats as $mat) { 
	$reg--;
?>

<watermarkimage src="<?php echo base_url().'resources/img/logo_h110.iesappiura.edu.pe.png' ?>" alpha="0.1" position="50,70"  size="D" />
<table class="tabla-sm" border="0">
	<tr>
		<td style="width: 20px;" align="center" class="p-0">
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h110.iesappiura.edu.pe.png' ?>" alt="IESTP">

		</td>
		<td  align="center" class="td-iesname">
			<h2>
				<b><?php echo $ies->pnombre ?><br>
					<?php echo $ies->snombre . " - " .$sede ?>
				</b>
			</h2>
			
		</td>
		
	</tr>
	<tr>
		<td colspan="2" align="center">
			<h3><b>BOLETA DE INFORMACIÓN DE NOTAS <?php //echo $mat->periodo ?></b></h3>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			 
		</td>
	</tr>
</table>

<hr style="margin-top: 2px;color: #000;">
<?php 
	$colorbg="";//($mat->codcarrera==3)?"cverde":"cceleste";
 ?>
<table class="encabezado">
	<tr>
		<td class="texto <?php echo $colorbg ?>">
			ALUMNO:
		</td>
		<td></td>
		<td colspan="3" class="texto">
			<span><?php echo "$mat->carne / <b>$mat->paterno $mat->materno $mat->nombres</b>" ?></span>
		</td>
		
		
	</tr>
	
	<tr>
		<td class="texto <?php echo $colorbg ?>">
			<span>PERIODO:</span> <span><?php echo "<b>$mat->periodo</b>" ?></span>
		</td>
		<td class="texto">
			<span><?php //echo "<b>$mat->periodo</b>" ?></span>
		</td>
		<td class="texto <?php echo $colorbg ?>">
			<span>PROG. ACAD.:</span> <span><?php echo "<b>$mat->carrera</b>" ?></span>
		</td>
		
		<td class="texto <?php echo $colorbg ?>">
			<span>CICLO:</span> <span><b><?php echo strtoupper($mat->ciclo) ?></b></span>
		</td>
		
		<td class="texto <?php echo $colorbg ?>">
			<span>TURNO:</span> <span><b><?php echo strtoupper($mat->turno) ?></b></span>
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
			<small>V°B°</small>
		</td>
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>HORAS</small>
		</td>
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>CRÉD.</small>
		</td>
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>PROM.</small>
		</td>
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>REC.</small>
		</td>
		<td  class="celda ccenter <?php echo $colorbg ?>">
			<small>P.F.</small>
		</td>
		<td  class="celda ccenter <?php echo $colorbg ?>" style="width: 120px;">
			<small>P.F. LETRAS</small>
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
			<span><?php echo ($cur->hts + $cur->hps); ?></span>
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
			<td class="celda ccenter-nobold">
				<span><?php echo "--" ?></span>
			</td>
			
		<?php }
		else { 
			$vfinal=intval(($cur->nota>$cur->recuperacion)?$cur->nota:$cur->recuperacion);?>
			<td class="celda ccenter-nobold">
				<span><?php echo floatval($cur->nota) ?></span>
			</td>
			<td class="celda ccenter-nobold">
				<span><?php echo ($cur->recuperacion==0) ? "" : floatval($cur->recuperacion); ?></span>
			</td>
			<td class="celda ccenter-nobold">
				<span><?php echo $vfinal ?></span>
			</td>
			<td class="celda ccenter-nobold">
				<span><?php echo $unidades[$vfinal] ?></span>
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
		<td class="firmas">
			<br>
			* En el Sistema MODULAR, la nota mínima aprobatoria es 13<br>
		</td>
		<td class="firmas" align="right">
			<!-- <img src="<?php //echo base_url().'resources/img/firma_sec_academico.iesappiura.edu.pe.jpg' ?>" alt="MINEDU"><br> -->
			------------------------------------------------------ <br>
			SECRETARÍA ACADÉMICA
			<br>
			<?php 
			date_default_timezone_set('America/Lima');
			$dias_ES = array( "Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
			$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

			$fechahoy = date('Y/m/d');
			$datehoy = new DateTime($fechahoy);
			$nombredia = $dias_ES[date($datehoy->format('w'))];
			$nombreMes = $meses_ES[date($datehoy->format('n'))-1];
			$anio = date($datehoy->format('Y'));
			$dianumero = date($datehoy->format('d'));
			$hora=date('h:i A');
			
			echo "$ies->distrito , $nombredia $dianumero de $nombreMes de $anio <br> Hora: $hora";
			
			?>
			
		</td>
	</tr>
	
</table>


<?php
	if ($reg>0) {
		echo "<pagebreak>";

	};
 } ?>
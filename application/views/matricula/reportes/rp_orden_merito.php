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
		padding: 2px 2px 2px 5px;
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



<table class="encabezado">

	<tr>
		<td width="100px">
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h110.'.getDominio().'.png' ?>" alt="iestcanchaque">
		</td>
		<td colspan="2" valign="top" align="center">
			<b><?php echo $ies->denoml ?></b><br><br>
			<h3><b>ORDEN DE MÉRITO</b></h3>
		</td>
		
	</tr>
</table>
<?php
$grupo="";
$nro=0;
foreach ($mats as $mat) {
	$nro++;
	if ($grupo!=$mat->codperiodo.$mat->codcarrera.$mat->codciclo.$mat->codturno.$mat->codseccion){
		$grupo=$mat->codperiodo.$mat->codcarrera.$mat->codciclo.$mat->codturno;
		$grupo=$grupo.$mat->codseccion;
	?>
	<table class="encabezado">
	
	<tr>
		<td class="texto">
			<span><?php echo "PERIODO: <b>$mat->periodo</b>" ?></span>
		</td>
		<td class="texto">
			<span><?php echo "PROG. ESTUDIOS.: <b>$mat->carrera</b>" ?></span>
		</td>
		<td class="texto">
			<span><?php echo "CICLO: <b>$mat->ciclo</b>" ?></span>
		</td>
		<td class="texto">
			<span><?php echo "TURNO: <b>$mat->codturno</b>" ?></span>
		</td>
		<td class="texto">
			<span><?php echo "SECC.: <b>$mat->codseccion</b>" ?></span>
		</td>
	</tr>
	</table>
	<table class="encabezado">

	<tr>
		<td  class="celda ccenter">
			<small>N°</small>
		</td>
		<td  class="celda ccenter">
			<small>ESTUDIANTE</small>
		</td>
		
		<td  class="celda ccenter">
			<small>PUNT.</small>
		</td>
		<td  class="celda ccenter">
			<small>CRED.</small>
		</td>
		<td  class="celda ccenter">
			<small>POND.</small>
		</td>
		
	</tr>
	<?php 
	}
	?>

	<tr>
		<td class="celda ccenter-nobold">
			<span><?php echo $nro ?></span>
		</td>
		<td class="celda">
			<span><?php echo "$mat->paterno $mat->materno $mat->nombres" ?></span>
		</td>
		
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->puntaje ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->creditos ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo round($mat->final,3) ?></span>
		</td>
		
			
	</tr>



<?php } ?>
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



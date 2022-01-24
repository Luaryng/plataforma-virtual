<!--$fechas
$asistencias
$sesiones
$evaluaciones
$notas
$miembros
$curso-->
<style>
	@page {
		margin-top: 2cm;
		margin-bottom: 2cm;
		margin-left: 2.5cm;
		margin-right: 2cm;
		header: html_otherpageheader;
    	footer: html_otherpagesfooter;
	}

	@page :first {    
	    header: html_firstpageheader;
	    footer: html_firstpagefooter;
	}
	body { 
    	font-family: serif; 
    	font-size: 10pt; 
	}
	.tbcuadro, .tbsinborde{
		border-collapse: collapse;
		overflow: wrap;
		width: 100%;
	}
	.tbcuadro th,td{
		padding-right: 5px;
		padding-left: 5px;
	}
	.tbsinborde th,td{
		padding-right: 5px;
		padding-left: 5px;
	}
	.text-right{
		text-align: right;
	}
	.text-simple{
		font-size: 10.5px;
	}
	
</style>
<htmlpageheader name="firstpageheader" style="display:none">
    <div style="text-align:center"></div>
</htmlpageheader>

<htmlpagefooter name="firstpagefooter" style="display:none">
    <div style="text-align:center;border-top: 1px solid black;">{PAGENO}</div>
</htmlpagefooter>

<htmlpageheader name="otherpageheader" style="display:none">
    <div style="border-bottom: 1px solid black;"> <?php echo "$docente->paterno $docente->materno $docente->nombres" ?></div>
</htmlpageheader>

<htmlpagefooter name="otherpagesfooter" style="display:none">
    <div style="text-align:center">{PAGENO}</div>
</htmlpagefooter>
<table class='tbsinborde'>
	<tr>
		<td><h1>Avance curricular en Aula Virtual</h1></td>
		<td rowspan="2"><img style='float: right;' src="<?php echo base_url().'resources/img/logo_h110.'.getDominio().'.png' ?>" alt="MINEDU"></td>
	</tr>
	<tr>
		<td><h2><?php echo "$docente->paterno $docente->materno $docente->nombres" ?></h2></td>
	</tr>
	
</table>



<?php 
	$nmiembros=0;
	//$vtipo['E']="Etiquetas";
	$vtipo['A']="Archivos";
	$vtipo['L']="Enlaces";
	$vtipo['Y']="Videos Youtube";
	$vtipo['C']="Cuestionarios";
	$vtipo['F']="Foros";
	//$vtipo['V']="Evaluaciones";
	$ttcursos=count($cursos);
	$nroc=0;
	foreach ($cursos as $key => $cs) {
		$nroc++;
		foreach ($c_miembros as $keycm => $nm) {
			if (($cs->codcarga==$nm->codcarga) && ($cs->division==$nm->division)){
				$nmiembros=$nm->miembros;
				unset($c_miembros[$keycm]);
				break;
			}
		}
		echo
		"Unidad Didactica: 
		<h3 style='margin:0px'>$cs->curso</h3> 
		<table class='tbsinborde'>
			<tr>
				<td>Periodo:</td>
				<td>$cs->periodo</td>
				<td>Programa:</td>
				<td colspan='3'>$cs->programa</td>
			</tr>
			<tr>
				<td>Semestre:</td>
				<td>$cs->ciclo</td>
				<td>Turno:</td>
				<td>$cs->turno</td>
				<td>Sección:</td>
				<td>$cs->seccion$cs->subseccion</td>
			</tr>
			
		</table>
		<hr>
		<table class='tbcuadro' border='1'>
			<tr>
				<th colspan='3' style='padding:5px;'><h4>EVALUACIONES</h4></th>
			</tr>";
		$gind="";
		foreach ($e_eval as $key2 => $ee) {
			if (($cs->codcarga==$ee->codcarga) && ($cs->division==$ee->division)){
				if ($gind!=$ee->codind){
				$gind=$ee->codind;
				echo "
					<tr>
						<td class='text-simple'><b>$ee->indicador</b></td>
						<td class='text-simple' colspan='2'><b>PROGRESO</b></td>
					</tr>";
				}
				$pg_porc=round($ee->total / $nmiembros  * 100,2)." %";
				echo 
				"<tr>
					<td class='text-simple '> - $ee->evh_nombre $ee->ind_orden</td>
					<td class='text-simple text-right'>$ee->total / $nmiembros</td>
					<td class='text-simple text-right'>$pg_porc</td>
				</tr>";
			}
			
		}
		echo
		"</table>
		<br>
		<table class='tbcuadro' border='1'>
			<tr>
				<th colspan='5' style='padding:5px;'><h4>ASISTENCIAS</h4></th>
			</tr>
			<tr>
				<td class='text-simple'><b>N°</b></td>
				<td class='text-simple'><b>FECHA / HORA</b></td>
				<td class='text-simple'><b>SESIÓN</b></td>
				<td class='text-simple' colspan='2'><b>PROGRESO</b></td>
			</tr>";
		$nro=0;
		foreach ($e_asiste as $key2 => $ea) {
			if (($cs->codcarga==$ea->codcarga) && ($cs->division==$ea->division)){
				$pg_porc=round($ea->total / $nmiembros  * 100,2)." %";
				$nro++;
				$fh=date('d-m-Y h:i a',strtotime($ea->fecha." ". $ea->hora));
				echo 
				"<tr>
					<td class='text-simple '>$nro</td>
					<td class='text-simple '>$fh</td>
					<td class='text-simple '>$ea->sesion</td>
					<td class='text-simple text-right'>$ea->total / $nmiembros</td>
					<td class='text-simple text-right'>$pg_porc</td>
				</tr>";
			}
		}

		echo
		"</table>
		<br>
		<table class='tbcuadro' border='1'>
			<tr>
				<th colspan='2' style='padding:5px;'><h4>AULA VIRTUAL</h4></th>
			</tr>
			<tr>
				<td class='text-simple'><b>TIPO</b></td>
				
				<td class='text-simple'><b>CANTIDAD</b></td>
			</tr>";
			foreach ($vtipo as $keytp => $vtp) {
				$tptotal=0;
				foreach ($e_virtual as $key2 => $ev) {
					if (($cs->codcarga==$ev->codcarga) && ($cs->division==$ev->division) && ($keytp==$ev->tipo)){
						$tptotal=$ev->total;
					}
				}
				echo 
					"<tr>
						<td class='text-simple '>$vtp</td>
						<td class='text-simple text-right'>$tptotal</td>
					</tr>";
			}
		
		echo
		"</table>";
		if ($nroc<$ttcursos) echo "<page_break> ";

	}

 ?>
<!--$fechas
$asistencias
$sesiones
$evaluaciones
$notas
$miembros
$curso-->
<style>
	@page {
		margin-top: 1.5cm;
		margin-bottom: 1cm;
		margin-left: 2.0cm;
		margin-right: 1.5cm;
	}
	.tabla{
		border-collapse: collapse;
		width: 100%;
	}
	.tabla th,td{
		border-collapse: collapse;
	}


	.titulo1{
		font-size: 12px;
		font-weight: bold;

	}
	.titulo2{
		font-size: 11px;
		font-weight: bold;
	}
	.grupo{
		font-size: 11px;
		height: 0.4cm;
	}


	.head-nro{
		font-size: 10px;
		font-weight: normal;
		height: 0.7cm;
		width: 0.6cm;
	}
	.head-carne{
		font-size: 10px;
		font-weight: normal;
		height: 0.7cm;
		width: 1.5cm;
	}
	.head-alumno{
		font-size: 10px;
		font-weight: normal;
		height: 0.7cm;
		width: 9cm;
	}
	.head{
		font-size: 10px;
		font-weight: normal;
		
	}
	.head-letras{
		font-size: 10px;
		font-weight: normal;
		width: 3cm;
	}
	.celda{
		font-size: 9px;
		font-weight: normal;
		height: 0.45cm;
		padding-left: 3px;
		padding-right: 2px;
	}
	.celda-nro{
		font-size: 9px;
		font-weight: normal;
		height: 0.45cm;
		text-align: center;
	}
	.text-danger{
		color: red;
 	}
	
</style>

<div style="width: 100%;">
	<table class="tabla" autosize="1">
		<tr>
			<td valign="top">
				<img height="50px" src="<?php echo base_url().'resources/img/minedu_logo_sb.png' ?>" alt="MINEDU">
			</td>
			<td class="titulo1" align="center" >
				<span ><?php echo $ies->denoml ?><br><br><br></span>
				
			</td>
			
			<td valign="top" align="right" valign="bottom" >
				<img height="60px" src="<?php echo base_url().'resources/img/logo_h110.'.getDominio().'.png' ?>" alt="MINEDU"><br>
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				<br>
				<span class="titulo1" >ACTA DE EVALUACIÓN FINAL DE LA UNIDAD DIDÁCTICA <br><br></span>
			</td>
		</tr>
	</table>
	<br>
	<table class="tabla" border="0" autosize="1" >
		
		
		<tr>
			<td width="4.5cm" class="grupo">PROGRAMA DE ESTUDIOS</td>
			<td class="grupo" colspan="5"><b><?php echo $curso->carrera ?></b></td>
		</tr>
		<tr>
			<td class="grupo">UNIDAD DIDÁCTICA</td>
			<td class="grupo" colspan="5"><b><?php echo $curso->unidad ?></b></td>
		</tr>
		<tr>
			<td class="grupo">SEMESTRE ACADÉMICO</td>
			<td class="grupo"><b><?php echo $curso->ciclol ?></b></td>
			<td class="grupo">TURNO</td>
			<td class="grupo"><b><?php echo $curso->turno ?></b></td>
			<td class="grupo">SECCIÓN</td>
			<td class="grupo"><b><?php echo $curso->codseccion.$curso->division ?></b></td>
		</tr>
		<tr>
			<td class="grupo">DOCENTE</td>
			<td class="grupo" colspan="5"><?php echo "$curso->paterno $curso->materno $curso->nombres" ?></td>
		</tr>
	</table>
	<br>
	<table class="tabla" border="1" autosize="1" >
		<tr>
			<th rowspan="3" class="head-nro">				
				<span>N°</span>
			</th>
			<th rowspan="3" class="head-carne">
				<span>DNI</span>
			</th>
			<th rowspan="3" class="head-alumno">
				<span>APELLIDOS Y NOMBRES</span>
			</th>
			<th class="head" colspan="3">
				<span>EVALUACIÓN FINAL</span>
			</th>
		</tr>
		<tr>
			<th class="head" colspan="2">
				<span>LOGRO FINAL</span>
			</th>
			<th class="head" rowspan="2">
				<span>PUNTAJE</span>
			</th>
		</tr>
		<tr>
			<th class="head">
				<span>EN NÚMEROS</span>
			</th>
			<th class="head-letras">
				<span>EN LETRAS</span>
			</th>
		</tr>
		<?php 
			$numero=0;
			$ntotreg=40;
			$unidades = array(
		        'DPI',
		        'UNO ',
		        'DOS ',
		        'TRES ',
		        'CUATRO ',
		        'CINCO ',
		        'SEIS ',
		        'SIETE ',
		        'OCHO ',
		        'NUEVE ',
		        'DIEZ ',
		        'ONCE ',
		        'DOCE ',
		        'TRECE ',
		        'CATORCE ',
		        'QUINCE ',
		        'DIECISEIS ',
		        'DIECISIETE ',
		        'DIECIOCHO ',
		        'DIECINUEVE ',
		        'VEINTE '
		    );
		    $creditos=$curso->cred_teo + $curso->cred_pra;
			foreach ($miembros as $miembro) {
				$numero++;
				$nota=($miembro->final>=$miembro->recuperacion)? $miembro->final: $miembro->recuperacion;
				/*if ($nota==""){
					$letras="";
					$puntaje="";
				}
				else{*/
					if ($miembro->estado=="DPI"){
						$letras="DPI";
						$puntaje="00";
						$nota="00";
						$colordp="text-danger";
					}
					else{
						$letras=$unidades[$nota];
						$puntaje=str_pad($nota*$creditos, 2, "0", STR_PAD_LEFT);
						$nota=str_pad($nota, 2, "0", STR_PAD_LEFT);
						$colordp=($nota<13)?"text-danger":"";
					}
				/*}*/
				
				echo "<tr>
						<td class='celda-nro'>
							<span>".str_pad($numero, 2, "0", STR_PAD_LEFT)."</span>
						</td>
						<td class='celda'><span>$miembro->dni</span></td>
						<td class='celda'><span>$miembro->paterno $miembro->materno $miembro->nombres </span></td>
						<td class='celda-nro $colordp'><span>$nota</span></td>
						<td class='celda $colordp'><span>$letras </span></td>
						<td class='celda-nro $colordp'><span>$puntaje </span></td>
					</tr>
				";
			}
			for ($i=$numero + 1; $i <= $ntotreg; $i++) { 
				echo "<tr>
						<td class='celda-nro'>".str_pad($i, 2, "0", STR_PAD_LEFT)."</td>
						<td class='celda'></td>
						<td class='celda'></td>
						<td class='celda'></td>
						<td class='celda'></td>
						<td class='celda'></td>
					</tr>
				";	
			}

		 ?>
	</table>
</div>
<?php 
	$dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    date_default_timezone_set('America/Lima');
    $fecha = date('m/d/Y h:i:s a', time());
    $hora=date('h:i A');
      //$fecha=time();
    $fecha = substr($fecha, 0, 10);

    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));

    $numeroDia = date('d', strtotime($fecha));
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

?>
<div style="width: 100%;">
	<br>
	<br>
	<br>
	<table class="tabla" border="0" autosize="1" >
		<tr>
			<td colspan="6" align="center">
				<span >______________________________</span><br>
				<span class="grupo" >Firma</span>
			</td>
			<td align="right">
				<span class="grupo"><?php echo strtoupper($ies->distrito).", $nombredia $numeroDia de $nombreMes de $anio" ?>
					
				</span>
			</td>
		</tr>
	</table>
	
</div>
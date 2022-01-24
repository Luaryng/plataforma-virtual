<!--$fechas
$asistencias
$sesiones
$evaluaciones
$notas
$miembros
$curso-->
<style>
	@page {
		margin-top: 0.5cm;
		margin-bottom: 0.5cm;
		margin-left: 0.5cm;
		margin-right: 0.5cm;
	}
	.horario-celda{
		border: 1px solid black;
		text-align: center;
	}
	.cellreg{
		padding-top: 3px;
		padding-bottom: 3px;
		padding-left: 5px;
		padding-right: 3px;
	}
	.tr-etq1{
		height: 45px;
	}
	.etq1{
		font-size: 15px;
		font-weight: bold;
	}
	.retp1{
		font-size: 16px;
		padding: 10px;
	}
	.etq2{
		font-size: 13px;
		font-weight: bold;
	}
	.cfhead{
		text-rotate:90;
		width: 0.5cm;
		padding-bottom: 2px;
	}
	.cfheadrs{
		text-rotate:90;
		width: 0.6cm;
		padding-bottom: 2px;
	}
	.tr-normal{
		height: 0.5cm;
	}
	
	.instruc{
		border: 1px solid black;
		 border-collapse: separate;
  		border-spacing: 10px;
	}
	.instruc th,td{
		border: 0px ;
	}
	.instruc .titulo{
		font-size: 17px;
		font-weight: bold;
		height: 1.3cm;
		text-align: center;
	}

	.instruc .celda-texto{
		text-align: justify;
		vertical-align: top;
		font-size: 16px;
		
		width: 8.3cm;
	}
	.instruc .celda-subtexto{
		text-align: justify;
		vertical-align: top;
		font-size: 16px;
		
		width: 7.8cm;
	}
	
	.instruc .celda-nro{
		text-align: center;
		font-size: 16px;
		
		width: 1cm;
		vertical-align: top;
	}
	.instruc .celda-vin{
		text-align: center;
		font-size: 16px;
		
		width: 0.5cm;
		vertical-align: top;
	}
	.instruc .celda-firma{
		text-align: right;
		font-size: 16px;
		font-weight: bold;
	}
</style>
<div style="width: 47%; float: left;">
	<table class="instruc">
		<tr>
			<td colspan="3" class="titulo">
				INSTRUCCIONES
			</td>
		</tr>
		<tr>
			<td colspan="3" class="celda-texto">Señor Profesor:</td>
		</tr>
		<tr>
			<td class="celda-nro">1.</td>
			<td colspan="2" class="celda-texto">El Presente registro de Evaluación y Control constituye un documento oficial de nuestra Institución, los datos requeridos en él, van a permitir obtener el resultado de las evaluaciones y efectuar el tratamiento de éstas.<br></td>
		</tr>
		<tr>
			<td class="celda-nro">2.</td>
			<td colspan="2" class="celda-texto">Escriba lo requerido con el cuidado que exige una adecuada administración del proceso educativo (sin borrones ni enmendaduras). <br>	
			Llenar con letra imprenta los apellidos y nombres de los alumnos, siguiendo el orden alfabético.<br></td>
		</tr>
		<tr>
			<td class="celda-nro">3.</td>
			<td colspan="2" class="celda-texto">El control de asistencias debe realizarse por cada sesión y anotarse con indicación de fecha en los casilleros respectivos sujetándose a lo siguiente:

			</td>
		</tr>
		<tr>
			<td></td>
			<td class="celda-vin"><b>»</b></td>
			<td class="celda-subtexto">
			Asistencia se indicará con la letra (<b>F</b>). La falta se indicará con la letra (<b>F</b>).
			
			<br></td>
		</tr>
		<tr>
			<td></td>
			<td class="celda-nro"><b>»</b></td>
			<td class="celda-subtexto">
			
			Al final de la unidad didáctica se debe totalizar el numero de asistencias, recordando que el 30% de estas determinara la inhabilitación de la U.D debiendo anotar en el Registro RLI (Retirado por Limite de Inasistencias)
			<br></td>
		</tr>
		<tr>
			<td class="celda-nro">4.</td>
			<td colspan="2" class="celda-texto">La escala de calificación es vigesimal. El calificativo mínimo aprobatorio es 13. <br>
			El los promedios de Unidad, la fracción 0.5 no se considera como unidad a favor del estudiante. Al obtener el promedio final de la Unidad Didáctica, la fracción 0.5 o mas debe ser considerada como unidad a favor del educando.
			</td>
		</tr>
		<tr>
			<td class="celda-nro">5.</td>
			<td colspan="2" class="celda-texto">ES OBLIGACIÓN DEL DOCENTE, comunicar los resultados de las evaluaciones de proceso y final a los alumnos, en un plazo de 05 días, luego de haber aplicado la prueba de unidad.
			<br></td>
		</tr>
		<tr>
			<td class="celda-nro">6.</td>
			<td colspan="2" class="celda-texto">En cada clase el docente debe portar el presente registro, concluida la misma, el registro permanecerá en el casillero asignado a cada docente, en Registro Académico.
			<br></td>
		</tr>
		<tr>
			<td colspan="3" class="celda-firma">LA DIRECCIÓN</td>
		</tr>

	</table>
</div>
<div style="width: 6%; float: left;">
	&nbsp;
</div>
<div style="width: 47%; float: left;">
	<table border="0" width="100%">
		<tr>
			<td width="50%">
				<img src="<?php echo base_url().'resources/img/minedu_logo.png' ?>" alt="MINEDU">
			</td>
			<td width="50%" align="right">
				<span style="font-size:11px;letter-spacing: 0 ">REVALIDADO<br>R.D.N° 0555-06-ED</span>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<br><br>
				<img src="<?php echo base_url().'resources/img/logo_h110.'.getDominio().'.png' ?>" alt="MINEDU"><br>
				<span style="font-size: 12px">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO</span><br>
				<span style="font-size: 30px">CANCHAQUE</span><br>
				<span style="font-size: 11px">R.M.N° 0290-94-ED</span><br>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<br>
				<span style="font-weight: bold;font-size: 23px">REGISTRO DE EVALUACIÓN Y APRENDIZAJES AÑO <?php echo  $curso->periodo ?></span>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<br>
				<br>
				<span class="etq1" >CARRERA PROFESIONAL:</span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="retp1"><?php echo $curso->carrera ?></span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="etq1" >MÓDULO EDUCATIVO N°: <?php echo  $curso->modulonro ?></span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="etq1" >DENOMINACIÓN:</span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="retp1"><?php echo $curso->modulo ?></span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="etq1" >UNIDAD DIDÁCTICA</span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="retp1"><?php echo $curso->unidad ?></span><br>
			</td>
		</tr>
	</table>
	<br>
	<table border="1" width="100%">
		<tr>
			<td colspan="6" align="center">
				<h3>HORARIO:</h3>
			</td>
		</tr>
		<tr>
			<td class="horario-celda">Lun.</td><td class="horario-celda">Mar.</td><td class="horario-celda">Mie.</td><td class="horario-celda">Jue.</td><td class="horario-celda">Vie.</td><td class="horario-celda">Sab.</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>

	</table>
	<br>
	<table >
		<tr>
			<td width="50%" class="etq1">
				HORAS SEMESTRALES<br>
			</td>
			<td width="2%">
				:
			</td>
			<td width="48%">
				<?php echo $curso->horas_ciclo ?>
			</td>
		</tr>
		<tr>
			<td><span class="etq1">CRÉDITOS</span></td><td>:</td><td><?php echo ($curso->cred_teo + $curso->cred_pra) ?></td>
		</tr>
		<tr>
			<td><span class="etq1">SECCIÓN</span></td><td>:</td><td><?php echo $curso->codseccion."-".$curso->division ?></td>
		</tr>
		<tr>
			<td><span class="etq1">TURNO</span></td><td>:</td><td><?php echo $curso->turno ?></td>
		</tr>
		<tr>
			<td><span class="etq1"></span></td><td></td><td></td>
		</tr>
		<tr>
			<td><span class="etq1">SEMESTRE ACADÉMICO</span></td><td>:</td><td><?php echo $curso->periodo ?></td>
		</tr>
		<tr>
			<td><span class="etq1">SEMESTRE DE ESTUDIOS</span></td><td>:</td><td><?php echo $curso->ciclo ?></td>
		</tr>
		<tr>
			<td><span class="etq1">DOCENTE</span></td><td>:</td><td><?php echo $curso->paterno.' '.$curso->materno.' '.$curso->nombres ?></td>
		</tr>
		<tr>
			<td><span class="etq1">DIRECTOR</span></td><td>:</td><td>AGNES CAROLINA CUEVA ROSALES</td>
		</tr>
		<tr>
			<td colspan="3" align="right">
				<br>
				<br>
				<br>
				_______________________________ <br>
				Firma del docente
			</td>
		</tr>
	</table>
</div>
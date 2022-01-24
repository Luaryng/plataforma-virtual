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
	.tblista{
		border-collapse: collapse;
		/*width: 100%;*/
	}
	.tblista th,td{
		border: 1px solid black;
		border-collapse: collapse;
	}
	.tblista .titulo{
		font-size: 12px;
		font-weight: bold;
		height: 0.9cm;
		max-height: 0.9cm;
		min-height:  0.9cm;
	}
	.tblista .head{
		font-size: 10px;
		font-weight: normal;
		height: 1.8cm;
	}
	.tblista .head-nro{
		font-size: 10px;
		font-weight: normal;
		height: 1.8cm;
		width: 0.5cm;
	}
	.tblista .head-carne{
		font-size: 10px;
		font-weight: normal;
		height: 0.7cm;
		width: 1.8cm;
	}
	.tblista .head-alumno{
		font-size: 10px;
		font-weight: normal;
		height: 0.7cm;
		width: 7cm;
	}
	.tblista .celda{
		font-size: 9px;
		font-weight: normal;
		height: 0.5cm;
		padding-left: 2px;
		padding-right: 2px;
	}
	.tblista .celda-nro{
		font-size: 8px;
		font-weight: normal;
		height: 0.5cm;
		text-align: center;
	}

	.tbguia{
		width: 100%;
		border-collapse: separate;
  		border-spacing: 10px;
	}

	.tbguia .titulo{
		font-size: 17px;
		font-weight: bold;
		height: 1cm;
		text-align: center;
		border: 0px;
	}
	.tbguia .titulo2{
		font-size: 14px;
		font-weight: bold;
		height: 0.9cm;
		text-align: left;
		border: 0px;
	}

	.tbguia .celda-texto{
		text-align: justify;
		vertical-align: top;
		font-size: 14px;
		border: 0px;
		width: 8.3cm;
		border: 0px;
	}
	.tbguia .celda-subtexto{
		text-align: justify;
		vertical-align: top;
		font-size: 14px;
		border: 0px;
		width: 7.8cm;
	}
	
	.tbguia .celda-vin{
		text-align: center;
		font-size: 14px;
		border: 0px;
		width: 0.5cm;
		vertical-align: top;
	}

	.tbguia2{
		border-collapse: collapse;
		border-spacing: 0px;
		/*width: 100%;*/
	}
	.textog2{
		font-size: 12px;
		text-align: center;
	}
	.textogj{
		font-size: 12px;
		text-align: justify;
		padding: 8px;
	}
</style>
<div style="width: 47%; float: left;">
	<table class="tblista" autosize="1"; >
		<tr>
			<th class="titulo" colspan="3">
				<span >LISTA DE ALUMNOS</span>
			</th>
		</tr>
		<tr>
			<th class="head-nro">				
				<span>N°</span>
			</th>
			<th class="head-carne">
				<span>CARNÉ</span>
			</th>
			<th class="head-alumno">
				<span>APELLIDOS Y NOMBRES</span>
			</th>
		</tr>
		<?php 
			$numero=0;
			$ntotreg=50;
			foreach ($miembros as $miembro) {
				$numero++;
				echo "<tr>
						<td class='celda-nro'>
							<span>".str_pad($numero, 2, "0", STR_PAD_LEFT)."</span>
						</td>
						<td class='celda'><span>$miembro->carnet</span></td>
						<td class='celda'><span>$miembro->paterno $miembro->materno $miembro->nombres </span></td>
					</tr>
				";
			}
			for ($i=$numero + 1; $i <= $ntotreg; $i++) { 
				echo "<tr>
						<td class='celda'>".str_pad($i, 2, "0", STR_PAD_LEFT)."</td>
						<td class='celda'></td>
						<td class='celda'></td>
					</tr>
				";	
			}

		 ?>
	</table>
</div>
<div style="width: 6%; float: left;">
	&nbsp;
</div>
<div style="width: 47%; float: left;">
	<table class="tbguia" autosize="1" >
		<tr>
			<th class="titulo">
				<span >GUÍA PARA LOS ALUMNOS</span>
			</th>
		</tr>
		<tr>
			<td class="titulo2">EVALUACIÓN </td>
		</tr>
	</table>
	<table class="tbguia2" autosize="1" >
		<tr>
			<th style="font-size: 8px;width: 1cm;border: 1px solid black">
				<span >EJECUCIÓN DEL PROGRAMA</span>
			</th>
			<th style="font-size: 8px;width: 5cm;border: 1px solid black">
				<span >¿PARA QUÉ,CÓMO Y CUANOD SE REALIZARÁ?</span>
			</th>
			<th style="font-size: 8px;width: 1.8cm;border: 1px solid black">
				<span >APLICACIÓN</span>
			</th>
			<th style="font-size: 8px;width: 0.8cm;border: 1px solid black">
				<span >PONDERADO</span>
			</th>
		</tr>
		<tr>
			<td class="textog2">Tarea Académica </td>
			<td class="textogj">Están distribuidas a lo largo de cada Unidad de aprendizaje mediante los indicadores de logro. Se aplicarán instrumentos para cada indicador como investigaciones, proyectos, exposiciones, resúmenes, mapa conceptual, portafolio del alumno, etc.</td>
			<td class="textog2">En Cada Indicador</td>
			<td class="textog2">30%</td>
		</tr>
		<tr>
			<td class="textog2">Evaluación Intermedia </td>
			<td class="textogj">El docente evidencia el logro de los aprendizajes mediante la aplicación de una evaluación que se realizará al final de la 1ra y 2da Unidad de Aprendizaje de desarrollo curricular planificado.</td>
			<td class="textog2">6ta y 11ava Semana</td>
			<td class="textog2">30%</td>
		</tr>
		<tr>
			<td class="textog2">Evaluación de Resultado </td>
			<td class="textogj">El docente aplica una evaluación final para evidenciar los logros académicos de cada aprendizaje y se realizará al final de la 3ra Unidad de Aprendizaje del desarrollo curricular planificado.</td>
			<td class="textog2">17ava semana</td>
			<td class="textog2">40%</td>
		</tr>
		<tr>
			<td class="textog2">Recuperación </td>
			<td class="textogj">Recuperación de alumnos desaprobados (alumnos con nota menor a 13)</td>
			<td class="textog2">18ava semana</td>
			<td class="textog2"></td>
		</tr>
	</table>
	<table class="tbguia">
		<tr>
			<td colspan="2" class="titulo2">
				METODOLOGÍA
			</td>
		</tr>
		<tr>
			<td colspan="2" class="celda-texto">En el desarrollo de la Unidad Didáctica se aplicará la metodología activa para el logro de los aprendizajes. <br><br>
				<ul>
				<li>Aprendizaje por proyectos</li>
				<li>Aprendizaje por casos</li>
				<li>Aprendizaje por problemas</li></ul>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="titulo2">
				EVALUACIÓN
			</td>
		</tr>
		<tr>
			<td class="celda-vin">
				*
			</td>
			<td class="celda-subtexto">
				La escala der calificación es vigesimal y el calificativo mínimo aprobatorio es trece (13). En el promedio final la fracción 0.5 o más se considera como unidad a favor del estudiante.
			</td>
		</tr>
		<tr>
			<td class="celda-vin">
				*
			</td>
			<td class="celda-subtexto">
				El 30% de inasistencias injustificadas se considera desaprobado por inasistencias (DPI).
			</td>
		</tr>
		<tr>
			<td colspan="2" class="titulo2">
				FÓRMULA DE CÁLCULO DE LA EVALUACIÓN
			</td>
		</tr>
		<tr>
			<td colspan="2">
				FÓRMULA PR= (3EI + 3TA + 4EF)/10
			</td>
		</tr>
		<tr>
			<td colspan="2" class="celda-texto">
				EI = Evaluación Intermedia<br>
				TA = Tareas Académicas<br>
				EF = Evaluación final.<br>
				PR = Promedio<br>
				RC = Recuperación <br>
				PF = Promedio Final <br>
			</td>
		</tr>
	</table>
</div>
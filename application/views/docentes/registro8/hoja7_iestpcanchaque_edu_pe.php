
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

	.tbsesiones{
		border-collapse: collapse;
		width: 100%;
	}

	.tbsesiones th,td{
		border: 1px solid black;
		border-collapse: collapse;
	}
	.tbsesiones .titulo{
		font-size: 12px;
		font-weight: bold;
		height: 0.9cm;
		max-height: 0.9cm;
		min-height:  0.9cm;
	}
	.tbsesiones .head-fecha{
		font-size: 10px;
		font-weight: normal;
		width: 1.2cm;
		height: 0.9cm;
	}
	.tbsesiones .head-nombre{
		font-size: 10px;
		font-weight: normal;
		width: 8.1cm;
		height: 0.9cm;
	}
	.tbsesiones .head-nro{
		font-size: 10px;
		font-weight: normal;
		width: 0.5cm;
	}

	.tbsesiones .celda{
		font-size: 10px;
		
		padding-left: 2px;
		padding-right: 2px;
		text-align: left;
		height: 0.4cm;
	}
	.tbsesiones .celdanro{
		font-size: 10px;
		
		padding-left: 2px;
		padding-right: 2px;
		text-align: center;
		height: 0.4cm;
	}
	.tbsesiones .evaluacion{
		font-weight: bold;
	}
	
	.tbasistencia th,td{
		border: 1px solid black;
		border-collapse: collapse;
	}
	.tbasistencia .titulo{
		font-size: 12px;
		font-weight: bold;
		height: 0.9cm;
		max-height: 0.9cm;
		min-height:  0.9cm;
	}
	
	.tbasistencia .titulo2{
		font-size: 8px;
		font-weight: normal;
		height: 0.7cm;
		max-height: 0.7cm;
		min-height: 0.7cm;
	}
	.tbasistencia .tituloef{
		font-size: 8px;
		font-weight: bold;
		max-height: 0.7cm;
		min-height: 0.7cm;
	}
	.tbasistencia .head{
		font-size: 8px;
		font-weight: normal;
		height: 1.1cm;
		width: 0.44cm;
	}
	.tbasistencia .head-nro{
		font-size: 10px;
		font-weight: normal;
		width: 0.5cm;
	}
	.tbasistencia .celda{
		font-size: 8px;
		font-weight: normal;
		height: 0.5cm;
		/*padding-left: 2px;
		padding-right: 2px;*/
		text-align: center;
	}
	
	.tbasistencia .celda-nro{
		font-size: 8px;
		font-weight: normal;
		height: 0.5cm;
		text-align: center;
	}
	.rotar90{
		text-rotate:90;
	}

	.rotar90{
		text-rotate:90;
	}
	.rojo{
		color: red;
	}
	.negro{
		color: black;
	}
</style>





<div style="width: 47%; float: left; ">
	<table class="tbsesiones" autosize="1" cellpadding="0">
		<tr>
			<th  class="titulo" colspan="3">
				<span >EJECUCIÓN CURRICULAR</span>
			</th>
		</tr>
		<tr>
		
				<th class='head-nro'>N°</th>
				<th class='head-fecha'>FECHA</th>
				<th class='head-nombre'>SESIÓN</th>
			 ?>
		</tr>
		<?php 
		$numero=51;
		$maxses=count($sesiones);
		if ($maxses>100) $maxses=100;
		for ($numero=51; $numero <= $maxses; $numero++) { 
			$sesion=$sesiones[$numero - 1];
			echo "<tr>";
				$fechass=date("d/m/y", strtotime($sesion->fecha));
				echo "<td class='celdanro'>$numero</td>";
				echo "<td class='celda'>$fechass</td>";
				$sieval=($sesion->tipo=="EVALUACIÓN") ? "evaluacion":"";
				echo "<td class='celda $sieval'>$sesion->detalle</td>";
			echo "</tr>";
			
		}

		for ($fil=$numero; $fil <= 100; $fil++) { 
				echo "<tr>";
				echo "<td class='celdanro'></td>
						<td class='celda'></td>
						<td class='celda'></td>";
				echo "</tr>";
			}
		 ?>
	</table>
</div>
<div style="width: 6%; float: left;">
	&nbsp;
</div>
<div style="width: 47%; float: left; ">
	<table class="tbasistencia" autosize="1" cellpadding="0">
		<tr>
			<th  class="titulo" colspan="21">
				<span >CONTROL DE ASISTENCIA</span>
			</th>
		</tr>
		<tr>
			<th rowspan="2" class="head-nro rotar90">
				<span>N°</span>
			</th>
			<?php 
				$fini=60;
				$ffin=80;
				$nro=$fini;
				$maxses=count($sesiones);
				if ($maxses>$ffin) $maxses=$ffin;
				foreach ($fechas1 as $fecha) {
					if ($nro<$ffin) {
						echo "<th align='center' class='titulo2 rotar90'><span>".($nro + 1)."</span></th>";
					}
					$nro++;
				}
				for ($i=$nro; $i < $ffin ; $i++) { 
					echo "<th class='titulo2  rotar90'>".($i + 1)."</th>";
				}
				//echo "<th rowspan='2' class='titulo2 rotar90'>T</th>";
				//echo "<th rowspan='2' class='titulo2 rotar90'>%</th>";
			 ?>
		</tr>
		<tr >
			<?php
				$fanterior="01/01/90";
				$nro=$fini;
				for ($nro=$fini; $nro < $maxses; $nro++) { 
					$fecha=$fechas[$nro];
					if ($nro<$ffin) {
						$fechaslt=date("d/m/y", strtotime($fecha->fecha));
						echo "<th align='center' class='head rotar90'><span>".$fechaslt."</span></th>";
						$fanterior=$fechaslt;
					}
				}
				for ($i=$nro; $i < $ffin ; $i++) { 
					echo "<th class='head'></th>";
				}
				
			?>
		</tr>
		<?php 
			$numero=0;
			$ntotreg=50;
			foreach ($miembros as $miembro) {
				$numero++;
				echo "<tr role='row' >";
				echo "<td class='celda-nro'>".str_pad($numero, 2, "0", STR_PAD_LEFT)."</td>";
				$nro=$fini;
				for ($nro=$fini; $nro < $maxses; $nro++) { 
					$fecha=$fechas[$nro];
					if (array_key_exists($fecha->sesion,$alumno[$miembro->idmiembro]['asis'])){
							$asi=$alumno[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'];	
					}
					else{
						$asi="";;	
					}
					$color = ($asi=="F") ? "rojo":"negro";
					echo "<td class='celda ".$color."'><span>$asi</span></td>";
				}
				for ($i=$nro; $i < $ffin ; $i++) { 
					echo "<td><span></span></td>";
				}
				echo "</tr>";
			}
			for ($i=$numero + 1; $i <= $ntotreg; $i++) { 
				echo "<tr role='row' >
						<td class='celda-nro'>".str_pad($i, 2, "0", STR_PAD_LEFT)."</td>";
				$nro=$fini;
				for ($pi=$nro; $pi < $ffin ; $pi++) { 
					echo "<td><span></span></td>";
				}

				echo "</tr>";
			}
			
		 ?>
	</table>
</div>

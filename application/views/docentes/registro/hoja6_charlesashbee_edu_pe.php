
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

	
	.tbnotas, .tbindicadores{
		border-collapse: collapse;

		/*width: 100%;*/
	}
	
	.tbnotas th,td{
		border: 1px solid black;
		border-collapse: collapse;
	}
	.tbnotas .titulo{
		font-size: 12px;
		font-weight: bold;
		height: 0.9cm;
		max-height: 0.9cm;
		min-height:  0.9cm;
	}
	.tbnotas .titulo2{
		font-size: 11px;
		font-weight: bold;
		height: 0.9cm;
		max-height: 0.9cm;
		min-height: 0.9cm;
	}
	.tbnotas .head{
		font-size: 8px;
		font-weight: normal;
		height: 0.9cm;
		width: 0.72cm;
	}
	.tbnotas .head-nro{
		font-size: 10px;
		font-weight: normal;
		width: 0.5cm;
	}
	.tbnotas .celda{
		font-size: 10px;
		font-weight: normal;
		height: 0.5cm;
		/*padding-left: 2px;
		padding-right: 2px;*/
		text-align: center;
	}
	
	.tbnotas .celda-nro{
		font-size: 9px;
		font-weight: normal;
		height: 0.5cm;
		text-align: center;
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
				$fini=40;
				$ffin=58;
				$nro=$fini;
				$maxses=count($sesiones);
				if ($maxses>$ffin) $maxses=$ffin;
				for ($nro=$fini; $nro < $maxses; $nro++) { 
					$fecha=$fechas[$nro];
					if ($nro<$ffin) {
						echo "<th align='center' class='titulo2 rotar90'><span>".($nro + 1)."</span></th>";
					}
					$nro++;
				}
				for ($i=$nro; $i < $ffin ; $i++) { 
					echo "<th class='titulo2  rotar90'>".($i + 1)."</th>";
				}
				echo "<th rowspan='2' class='titulo2 rotar90'>T</th>";
				echo "<th rowspan='2' class='titulo2 rotar90'>%</th>";
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
			$nses=$curso->sesiones;
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
				$fal=$alumno[$miembro->idmiembro]['asis']['faltas'];
					$falp=$fal/$nses * 100;
					$color = ($falp>=30) ? "rojo":"negro";
					echo "<td class='celda ".$color."'><span>$fal</span></td>";
					echo "<td class='celda ".$color."'><span>".intval($falp)."</span></td>";

				echo "</tr>";
			}
			for ($i=$numero + 1; $i <= $ntotreg; $i++) { 
				echo "<tr role='row' >
						<td class='celda-nro'>".str_pad($i, 2, "0", STR_PAD_LEFT)."</td>";
				$nro=$fini;
				for ($pi=$nro; $pi < $ffin ; $pi++) { 
					echo "<td><span></span></td>";
				}
									echo "<td class='celda'><span></span></td>";
				echo "<td class='celda'><span></span></td>";

				echo "</tr>";
			}
			
		 ?>
	</table>
</div>
<div style="width: 6%; float: left;">
	&nbsp;
</div>
<div style="width: 47%; float: left; ">
	<table class="tbnotas"  autosize="1"  cellpadding="0">
				<tr>
			<th  class="titulo" colspan="13">
				<span >UNIDADES DE APRENDIZAJE</span>
			</th>
		</tr>
		<tr>
			<th rowspan="2" class="head-nro rotar90"><span>N°</span></th>
			<th  class="titulo2" colspan="4" align="center">
				<span>UA1</span>
			</th>
			<th  class="titulo2" colspan="4" align="center">
				<span>UA2</span>
			</th>
			<th  class="titulo2" colspan="3" align="center">
				<span>UA3</span>
			</th>
			<th  class="tituloef" rowspan="2" align="center">
				<span>EF</span>
			</th>

		</tr>
		<tr >
			
			<th align="center" class="head rotar90">PC</th>
			<th align="center" class="head rotar90">TA</th>
			<th align="center" class="head rotar90"><b>TA1</b></th>
			<th align="center" class="head rotar90"><b>EI</b></th>
			<th align="center" class="head rotar90">PC</th>
			<th align="center" class="head rotar90">TA</th>
			<th align="center" class="head rotar90"><b>TA2</b></th>
			<th align="center" class="head rotar90"><b>EI</b></th>
			<th align="center" class="head rotar90">PC</th>
			<th align="center" class="head rotar90">TA</th>
			<th align="center" class="head rotar90"><b>TA3</b></th>
			


		</tr>
		<?php 
			$numero=0;
			$ntotreg=50;
			
			foreach ($miembros as $miembro) {
				
					$numero++;

					echo '<tr role="row">';
						echo "<td class='celda-nro'>".str_pad($numero, 2, "0", STR_PAD_LEFT)."</td>";
						$nind=0;
						foreach ($indicadores as $key => $indicador) {
							$nota=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['PC']['nota'];
                            $color = ($nota>=12.5) ? "negro":"rojo";
							echo "<td class='celda ".$color."'>".str_pad(intval($nota), 2, "0", STR_PAD_LEFT)."</td>";

							$nota=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['TA']['nota'];
                            $color = ($nota>=12.5) ? "negro":"rojo";
							echo "<td class='celda ".$color."'>".str_pad(intval($nota), 2, "0", STR_PAD_LEFT)."</td>";

							$nota=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['TAI']['nota'];
                            $color = ($nota>=12.5) ? "negro":"rojo";
							echo "<td class='celda ".$color."'>".str_pad(intval($nota), 2, "0", STR_PAD_LEFT)."</td>";

							if ($nind<2){
								$nota=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['EI']['nota'];
                            	$color = ($nota>=12.5) ? "negro":"rojo";
								echo "<td class='celda ".$color."'>".str_pad(intval($nota), 2, "0", STR_PAD_LEFT)."</td>";
							}
							$nind++;

						}
						$nota=$alumno[$miembro->idmiembro]['eval'][$indicadores[2]->codigo]['EI']['nota'];
                            	$color = ($nota>=12.5) ? "negro":"rojo";
								echo "<td class='celda ".$color."'>".str_pad(intval($nota), 2, "0", STR_PAD_LEFT)."</td>";
						//$alumno[$miembro->idmiembromiembro]['eval'][$evaluacion->indicador]['PC']['nota']
																
						

						
				echo '</tr>';
				
			} 
			for ($i=$numero + 1; $i <= $ntotreg; $i++) { 
				echo "<tr class='tr-normal'>
						<td class='celda-nro'>".str_pad($i, 2, "0", STR_PAD_LEFT)."</td>";
				$nro=40;
				echo '<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>
						<td class="celda"></td>';
				echo "</tr>";
			}
		 ?>
	</table>
	
</div>
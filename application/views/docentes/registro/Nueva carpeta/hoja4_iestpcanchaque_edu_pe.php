
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
	
	.tbnotas{
		border-collapse: collapse;
		width: 100%;
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
		height: 1.1cm;
		width: 0.53cm;
	}
	.tbnotas .head-nro{
		font-size: 10px;
		font-weight: normal;
		width: 0.5cm;
	}
	.tbnotas .celda{
		font-size: 8.5px;
		font-weight: normal;
		height: 0.508cm;
		text-align: center;
	}
	
	.tbnotas .celda-nro{
		font-size: 8px;
		font-weight: normal;
		height: 0.508cm;
		text-align: center;
	}

	
	/*TBASISTENCIA01*/

	.tbasistencia{
		border-collapse: collapse;

		/*width: 100%;*/
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
		height: 0.9cm;
		width: 0.4cm;
		max-height: 0.9cm;
		min-height: 0.9cm;
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
	.rojo{
		color: red;
	}
	.negro{
		color: black;
	}

</style>


<!--ASISTENCIA 01-->
<div style="width: 47%; float: left;">
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
				$fini=0;
				$ffin=20;
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
<div style="width: 6%; float: left;">
	&nbsp;
</div>

<div style="width: 47%; float: right;">
	<!--INDICADORES-->
	<table class="tbnotas"  autosize="1"  cellpadding="0">
		<tr>
			<th  class="titulo" colspan="18">
				<span >INDICADORES DE LOGRO</span>
			</th>
		</tr>
		<tr>
			<th rowspan="2" class="head-nro rotar90"><span>N°</span></th>
			<th  class="titulo2" colspan="4" align="center">
				<span>IND5</span>
			</th>
			<th  class="titulo2" colspan="4" align="center">
				<span>IND6</span>
			</th>
			<th  class="titulo2" colspan="4" align="center">
				<span>IND7</span>
			</th>
			<th  class="titulo2" colspan="4" align="center">
				<span>IND8</span>
			</th>
			<th align="center">
				
			</th>
		</tr>
		<tr >
			
			<th align="center" class="head rotar90">EP</th>
			<th align="center" class="head rotar90">TA</th>
			<th align="center" class="head rotar90">EF</th>
			<th align="center" class="head rotar90">RC</th>
			<th align="center" class="head rotar90">EP</th>
			<th align="center" class="head rotar90">TA</th>
			<th align="center" class="head rotar90">EF</th>
			<th align="center" class="head rotar90">RC</th>
			<th align="center" class="head rotar90">EP</th>
			<th align="center" class="head rotar90">TA</th>
			<th align="center" class="head rotar90">EF</th>
			<th align="center" class="head rotar90">RC</th>
			<th align="center" class="head rotar90">EP</th>
			<th align="center" class="head rotar90">TA</th>
			<th align="center" class="head rotar90">EF</th>
			<th align="center" class="head rotar90">RC</th>
			<th align="center" class="head rotar90"><b>PI</b></th>
			
			


		</tr>
		<?php 
			$numero=0;
			$ntotreg=50;
			
			foreach ($miembros as $miembro) {
				
					$numero++;

					echo '<tr role="row">';
						echo "<td class='celda-nro'>".str_pad($numero, 2, "0", STR_PAD_LEFT)."</td>";
						$nind=5;
						$tind=count($indicadores);
						//$tind=($tind<0) ? 0 : $tind;
						for ($i=4; $i <$tind ; $i++) { 
							
							$indicador=$indicadores[$i];
						//foreach ($indicadores as $key => $indicador) {
								# code...
							$nind++;
							//if ($nind<5){
								$n1=intval($alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['EP']['nota']);  
								$color = ($n1>=12.5) ? "negro":"rojo";
								echo "<td class='celda ".$color."'>".str_pad($n1, 2, "0", STR_PAD_LEFT)."</td>";  

								$t1=intval($alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['TA']['nota']); 
								$color = ($t1>=12.5) ? "negro":"rojo";
								echo "<td class='celda ".$color."'>".str_pad($t1, 2, "0", STR_PAD_LEFT)."</td>"; 


								$e1=intval($alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['EF']['nota']); 
								$color = ($e1>=12.5) ? "negro":"rojo";
								echo "<td class='celda ".$color."'>".str_pad($e1, 2, "0", STR_PAD_LEFT)."</td>"; 

								$r1=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['RC']['nota']; 
								if ($r1==""){
									echo "<td class='celda'>-</td>";
								}
								else{
									$color = ($r1>=12.5) ? "negro":"rojo";
									echo "<td class='celda ".$color."'>".str_pad(intval($r1), 2, "0", STR_PAD_LEFT)."</td>"; 
								}

							//}
						}
						for ($i=$nind; $i <9 ; $i++) { 
							
							$nind++;
								
								echo "<td class='celda'>-</td>";  
								echo "<td class='celda'>-</td>";  
								echo "<td class='celda'>-</td>"; 
								echo "<td class='celda'>-</td>";  

								  
								
							
						}
						$pi=intval($alumno[$miembro->idmiembro]['eval']['PI']['nota']);  
						$color = ($pi>=12.5) ? "negro":"rojo";
						echo "<td class='celda ".$color."'>".str_pad($pi, 2, "0", STR_PAD_LEFT)."</td>";
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
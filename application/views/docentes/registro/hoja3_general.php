
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
	.tbresumen, .tbsupervisa{
		border-collapse: collapse;

		/*width: 100%;*/
	}
	.tbresumen th,td{
		border: 1px solid black;
		border-collapse: collapse;
	}
	.tbresumen .titulo{
		font-size: 12px;
		font-weight: bold;
		height: 0.9cm;
		max-height: 0.9cm;
		min-height:  0.9cm;
	}
.tbresumen .titulo2{
		font-size: 11px;
		font-weight: bold;
		height: 0.9cm;
		max-height: 0.9cm;
		min-height: 0.9cm;
	}
.tbresumen .head{
		font-size: 8px;
		font-weight: normal;
		height: 0.9cm;
		width: 0.8cm;
	}
.tbresumen .head-nro{
		font-size: 10px;
		font-weight: normal;
		width: 0.5cm;
	}
.tbresumen .celda{
		font-size: 10px;
		font-weight: normal;
		height: 0.5cm;
		/*padding-left: 2px;
		padding-right: 2px;*/
		text-align: center;
	}
.tbresumen .celda-nro{
		font-size: 9px;
		font-weight: normal;
		height: 0.5cm;
		text-align: center;
	}
	.tbsupervisa th,td{
		border: 1px solid black;
		border-collapse: collapse;
	}
.tbsupervisa .titulo{
		font-size: 12px;
		font-weight: bold;
		height: 0.9cm;
		max-height: 0.9cm;
		min-height:  0.9cm;
	}
.tbsupervisa .head-firma{
		font-size: 10px;
		font-weight: normal;
		width: 3cm;
		height: 0.9cm;
	}
.tbsupervisa .head-observa{
		font-size: 10px;
		font-weight: normal;
		width: 6.3cm;
		height: 0.9cm;
	}
.tbsupervisa .celda{
		font-size: 8px;
		font-weight: normal;
		height: 0.6cm;
		/*padding-left: 2px;
		padding-right: 2px;*/
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
<!--SUPERVISIÓN-->
<div style="width: 47%; float: left;">
	<table class="tbsupervisa" autosize="1" cellpadding="0">
		<tr>
			<th  class="titulo" colspan="21">
				<span >SUPERVISIÓN INTERNA</span>
			</th>
		</tr>
		<tr>
			<th  class="head-firma">
				<span>FECHA/FIRMA</span>
			</th>
			<th  class="head-observa">
				<span>OBSERVACIONES Y RECOMENDACIONES</span>
			</th>
		</tr>
		<?php 

		for ($i=01; $i <=6 ; $i++) { ?>
			<tr>
				<td rowspan="7">
					
				</td>
				<td class="celda"></td>
			</tr>
			<tr>
				<td class="celda"></td>
			</tr>
			<tr>
				<td class="celda"></td>
			</tr>
			<tr>
				<td class="celda"></td>
			</tr>
			<tr>
				<td class="celda"></td>
			</tr>
			<tr>
				<td class="celda"></td>
			</tr>
			<tr>
				<td class="celda"></td>
			</tr>
		<?php 
		}

		 ?>
	</table>
</div>

<div style="width: 6%; float: left;">
	&nbsp;
</div>
<!-- RESUMEN -->
<div style="width: 47%; float: left; ">
	<table class="tbresumen"  autosize="1"  cellpadding="0">
		<tr>
			<th  class="titulo" colspan="12">
				<span >HOJA RESUMEN</span>
			</th>
		</tr>
		<tr>
			<th  class="titulo2" colspan="12" align="center">
				<span>FÓRMULA PF= 3EI + 3TA + 4TA</span>
			</th>
		</tr>
		<tr >
			<th class="head-nro  rotar90"><span>N°</span></th>
			<th align="center" class="head rotar90">X̅EP</th>
			<th align="center" class="head rotar90">X̅TA</th>
			<th align="center" class="head rotar90">X̅EF</th>
			<th align="center" class="head rotar90">PI</th>
			<th align="center" class="head rotar90">RC</th>
			<th align="center" class="head rotar90">PF</th>
		</tr>
		<?php 
			$numero=0;
			$ntotreg=50;
			$nses=$curso->sesiones;
			$nindmax=8;
			
			foreach ($miembros as $miembro) {
				
					$numero++;

					echo '<tr role="row">';
						echo "<td class='celda-nro'>".str_pad($numero, 2, "0", STR_PAD_LEFT)."</td>";
						$nind=0;
						$sumapi=0;
						foreach ($indicadores as $key => $indicador) {
							# code...
							echo "$miembro->carnet";
							$nind++;
							$nota=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
                            $sumapi=$sumapi + $nota;
                            $color = ($nota>=12.5) ? "negro":"rojo";
							echo "<td class='celda ".$color."'>".str_pad(intval($nota), 2, "0", STR_PAD_LEFT)."</td>";
						}
						for ($i=$nind + 1; $i <= $nindmax; $i++) { 
							echo "<td class='celda'>--</td>";
						}
						$pf=round($sumapi/$nind ,0);
						$color = ($pf>=12.5) ? "negro":"rojo";
						echo "<td class='celda ".$color."'>".str_pad(intval($pf), 2, "0", STR_PAD_LEFT)."</td>";
						
						//COLUMNA DE RECUPERACIÓN
						echo "<td class='celda $color'><b>--</b></td>";
						
						$fal=$alumno[$miembro->idmiembro]['asis']['faltas'];						
						
						$falp=$fal/$nses * 100;
						if ($falp>=30){
							echo "<td class='celda ".$color."'><b>DPI</b></td>";
						}
						else{

						    echo "<td class='celda ".$color."'><b>".str_pad($pf, 2, "0", STR_PAD_LEFT)."</b></td>";
						    
							
						}

				echo '</tr>';
				
			}
			 
			for ($i=$numero + 1; $i <= $ntotreg; $i++) { 
				echo "<tr class='tr-normal'>
						<td class='celda-nro'>".str_pad($i, 2, "0", STR_PAD_LEFT)."</td>";
				$nro=0;
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
						<td class="celda"></td>';
				echo "</tr>";
			}
		 ?>
	</table>
</div>

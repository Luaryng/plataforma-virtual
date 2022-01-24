
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

	.tbresumen, .tbsupervisa, .tbindicadores{
		border-collapse: collapse;
		
		width: 100%;
	}
	.tbindicadores th,td{
		border: 1px solid black;
		border-collapse: collapse;
	}
	.tbindicadores .ititulo{
		font-size: 12px;
		font-weight: bold;
		height: 0.9cm;
		
	}
	.tbindicadores .ihead-nro{
		font-size: 10px;
		font-weight: normal;
		width: 0.8cm;
		height: 0.7cm;
	}
	.tbindicadores .ihead-nombre{
		font-size: 10px;
		font-weight: normal;
		width: 8.0cm;
		height: 0.7cm;
	}

	.tbindicadores .icelda{
		font-size: 10px;
		
		padding: 4px;
		text-align: left;
		/*min-height:  3cm;*/
		height: 1cm;
		text-align: justify;
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
			font-size: 10px;
			font-weight: normal;
			height: 0.9cm;
			width: 0.8cm;
		}

	.tbresumen .head-final{
			font-size: 10px;
			font-weight: normal;
			height: 0.9cm;
			width: 0.6cm;
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

	.tbresumen .small-celda-nro{
		font-size: 9px;
		font-weight: normal;
		height: 0.5cm;
		text-align: center;
		padding: 0px;
	}

	.tbresumen .small-celda{
		font-size: 9px;
		font-weight: normal;
		height: 0.5cm;
		text-align: center;
		padding: 0px;
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
		/*width: 6.3cm;*/
		height: 0.9cm;
	}
.tbsupervisa .celda{
		font-size: 8px;
		font-weight: normal;
		height: 0.53cm;
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
	<table class="tbindicadores" autosize="1" cellpadding="0">
		<tr>
			<th  class="ititulo" colspan="2">
				<span >INDICADORES DE LOGRO</span>
			</th>
		</tr>
		<tr>
		
				<th class='ihead-nro'>N°</th>
				<th class='ihead-nombre'>Nombre</th>
			 ?>
		</tr>
		<?php 
		$numero=1;
		foreach ($indicadores as $ind) {
			echo "<tr>";
			//$fechass=date("d/m/y", strtotime($sesion->fecha));
				echo "<td class='icelda'>$numero</td>";
				//$sieval=($sesion->tipo=="EVALUACIÓN") ? "evaluacion":"";
				echo "<td class='icelda'>$ind->nombre</td>";
			echo "</tr>";
			$numero++;
		}

		for ($fil=$numero; $fil <= 8; $fil++) { 
				echo "<tr>";
				echo "<td class='icelda'>$fil</td>
						<td class='icelda'></td>";
				echo "</tr>";
			}
		 ?>
	</table>
	<br><br>

	<table class="tbsupervisa" autosize="1" cellpadding="0">
		<tr>
			<th  class="titulo" colspan="2">
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

		for ($i=01; $i <=4 ; $i++) { ?>
			<tr>
				<td rowspan="6">
					
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
				<span>FÓRMULA PR= (3EP + 3TA + 4EF)/10</span>
			</th>
		</tr>
		<tr >
			<tr >
			<th class="head-nro  rotar90"><span>N°</span></th>
			<th align="center" class="head rotar90">Ind1</th>
			<th align="center" class="head rotar90">Ind2</th>
			<th align="center" class="head rotar90">Ind3</th>
			<th align="center" class="head rotar90">Ind4</th>
			<th align="center" class="head rotar90">Ind5</th>
			<th align="center" class="head rotar90">Ind6</th>
			<th align="center" class="head rotar90">Ind7</th>
			<th align="center" class="head rotar90">Ind8</th>
			<th align="center" class="head-final rotar90">PI</th>
			<th align="center" class="head-final rotar90">R</th>
			<th align="center" class="head-final rotar90">PF</th>
		</tr>

		<?php 
			$numero=0;
			$ntotreg=50;
			$nses=$curso->sesiones;
			$nindmax=8;
			
			$numero=0;
			$ntotreg=50;
			$nses=$curso->sesiones;
			$nindmax=8;
			
			foreach ($miembros as $miembro) {
				
					$numero++;

					echo '<tr role="row">';
						echo "<td class='small-celda-nro'>".str_pad($numero, 2, "0", STR_PAD_LEFT)."</td>";
						$nind=0;
						$sumapi=0;
						foreach ($indicadores as $key => $indicador) {
							# code...
							echo "$miembro->carnet";
							$nind++;
							$nota=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['PI']['nota'];
							$notar=$alumno[$miembro->idmiembro]['eval'][$indicador->codigo]['RI']['nota'];
							$notaid=($nota>$notar) ? $nota : $notar;
                            //$sumapi=$sumapi + $nota;
                            $color = ($notaid>=12.5) ? "negro":"rojo";
							echo "<td class='small-celda ".$color."'>".str_pad(floatval($notaid), 2, "0", STR_PAD_LEFT)."</td>";
						}
						for ($i=$nind + 1; $i <= $nindmax; $i++) { 
							echo "<td class='small-celda'>--</td>";
						}
						$notapi=$alumno[$miembro->idmiembro]['eval']['PI']['nota'];//round($sumapi/$nind ,0);
						$color = ($notapi>=12.5) ? "negro":"rojo";
						echo "<td class='small-celda ".$color."'>".str_pad(floatval($notapi), 2, "0", STR_PAD_LEFT)."</td>";
						
						//COLUMNA DE RECUPERACIÓN
						$notarc=$alumno[$miembro->idmiembro]['eval']['RC']['nota'];
                        $color = ($notarc>=12.5) ? "negro":"rojo";
                        if ($notarc==""){
							echo "<td class='small-celda'>--</td>";
                        }
                        else{
							echo "<td class='small-celda ".$color."'>".str_pad(intval($notarc), 2, "0", STR_PAD_LEFT)."</td>";
                        }


						$notapf=$alumno[$miembro->idmiembro]['eval']['PF']['nota'];
                        $color = ($notapf>=12.5) ? "negro":"rojo";
						
						$fal=$alumno[$miembro->idmiembro]['asis']['faltas'];						
						
						$falp=$fal/$nses * 100;
						if ($falp>=30){
							echo "<td class='small-celda ".$color."'><b>00</b></td>";
						}
						else{

						    echo "<td class='small-celda ".$color."'><b>".str_pad($notapf, 2, "0", STR_PAD_LEFT)."</b></td>";
						    
							
						}

				echo '</tr>';
				
			}
			 
			for ($i=$numero + 1; $i <= $ntotreg; $i++) { 
				echo "<tr class='tr-normal'>
						<td class='small-celda-nro'>".str_pad($i, 2, "0", STR_PAD_LEFT)."</td>";
				$nro=0;
				echo '<td class="small-celda"></td>
						<td class="small-celda"></td>
						<td class="small-celda"></td>
						<td class="small-celda"></td>
						<td class="small-celda"></td>
						<td class="small-celda"></td>
						<td class="small-celda"></td>
						<td class="small-celda"></td>
						<td class="small-celda"></td>
						<td class="small-celda"></td>
						<td class="small-celda"></td>';
				echo "</tr>";
			}
		 ?>
	</table>
</div>

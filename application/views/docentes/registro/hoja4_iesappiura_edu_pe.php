
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
	.tbindicadores, .tbasistencia{
		border-collapse: collapse;

		/*width: 100%;*/
	}
	.tbindicadores th,td{
		border: 1px solid black;
		border-collapse: collapse;
	}
	

	.tbindicadores .titulo{
		font-size: 12px;
		font-weight: bold;
		height: 0.9cm;
		max-height: 0.9cm;
		min-height:  0.9cm;
	}
	
	.tbindicadores .head-nro{
		font-size: 11px;
		font-weight: bold;
		width: 1cm;
		height: 0.9cm;
		text-align: center;
	}
	.tbindicadores .head-indicador{
		font-size: 11px;
		font-weight: bold;
		width: 8.3cm;
		height: 0.9cm;
		text-align: center;
	}
	.tbindicadores .celda{
		font-size: 11px;
		font-weight: normal;
		height: 1.3cm;
		/*padding-left: 2px;
		padding-right: 2px;*/
		text-align: center;
	}
	.tbindicadores .celda-indicador{
		font-size: 11px;
		font-weight: normal;
		height: 1.3cm;
		padding-left: 3px;
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

	/*TBASISTENCIA01*/
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
		width: 0.4cm;
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
		text-align: center;
	}
	
	.tbasistencia .celda-nro{
		font-size: 8px;
		font-weight: normal;
		height: 0.5cm;
		text-align: center;
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
				foreach ($fechas as $fecha) {
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

<div style="width: 47%; float: left;">
	<!--INDICADORES-->
	<table class="tbindicadores" autosize="1" cellpadding="0">
		<tr>
			<th  class="titulo" colspan="21">
				<span >INDICADORES DE LOGRO</span>
			</th>
		</tr>
		
		<?php 

 		foreach ($indicadores as $ind) {
                                    
		        $contador = 0;
		        $codigo = $ind->codigo;
		        echo "
		        <tr>
					<td  class='head-nro'>
						<span>N°</span>
					</td>
					<td  class='head-indicador'>
						<span>UNIDAD DE APRENDIZAJE 0$ind->norden</span>
					</td>
				</tr>";
		        foreach ($subindicadores as $sub) {
		            if ($codigo == $sub->indicador) {
		                $contador ++;
		                $descripcion = $sub->descripción;
		            echo "
		            <tr>
						<td class='celda'>0$contador</td>
						<td class='celda-indicador'>$descripcion</td>
					</tr>";

		            }
		            
		        }
		        for($f=$contador + 1 ; $f < 6; $f++) {
		            echo "
		            <tr>
						<td class='celda'>0$f</td>
						<td class='celda-indicador'></td>
					</tr>";
		        }
		}


		

		 ?>
	</table>
</div>
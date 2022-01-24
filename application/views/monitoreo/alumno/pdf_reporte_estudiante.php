<style>
	@page {
		margin-top: 1.0cm;
		margin-bottom: 1.0cm;
		margin-left: 1.5cm;
		margin-right: 1.5cm;
	}
	
	.encabezado{
		width: 100%;
		border-collapse: collapse;
	}
	.logo-minedu{
		width: 200px;
		height: 50px;
	}

	.logo-ies{
		height:  40px;
		width: 200px;
	}
	.celda{
		height: 15px;
		padding: 5px;
		border: solid 1px gray;
		font-size: 10px;
	}
	.texto{
		height: 20px;
		padding: 5px;
		font-size: 11px;
	}
	.firmas{
		height: 20px;
		padding: 5px;
		font-size: 10px;
	}
	.cgris{
		background-color: #E9E4E4;
	}
	.ccenter{
		text-align: center;
		font-weight: bold;
	}
	.ccenter-nobold{
		text-align: center;
	}
	.w25p{
		width: 5cm;
	}

	.text-small-9 {
		font-size: 10px;
	}

	.text-13 {
		font-size: 13px;
	}

	.rotar90{
		text-rotate:90;
	}
</style>

<table class="encabezado" style="margin-bottom: 5px;">
	<tr>
		<td>
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h80.'.getDominio().'.png' ?>" alt="iestcanchaque">
		</td>
		<td class="" width="200px">
			
		</td>
		<td valign="bottom" class="ccenter-nobold">
			<!-- <img class="logo-minedu" src="<?php //echo base_url().'resources/img/minedu_logo.png' ?>" alt="minedu" > -->
		</td>
		
	</tr><br><br>
	<tr>
		<td colspan="3" class="ccenter-nobold">
			<b>REPORTE ACADÉMICO ESTUDIANTE</b>
		</td>
		
	</tr>
</table>

<table class="encabezado">
	<tr>
		<td class="texto <?php echo $colorbg ?>">
			ALUMNO:
		</td>
		<td></td>
		<td colspan="4" class="texto">
			<span><?php echo "$mat->carne / <b>$mat->alumno</b>" ?></span>
		</td>
		
	</tr>
	
	<tr>
		<td class="texto <?php echo $colorbg ?>">
			<span>PERIODO:</span> <span><?php echo "<b>$mat->periodo</b>" ?></span>
		</td>
		<td class="texto">
			<span></span>
		</td>
		<td class="texto <?php echo $colorbg ?>">
			<span>PROG. ACAD.:</span> <span><?php echo "<b>$mat->carrera</b>" ?></span>
		</td>
		
		<td class="texto <?php echo $colorbg ?>">
			<span>CICLO:</span> <span><b><?php echo strtoupper($mat->ciclo) ?></b></span>
		</td>
		
		<td class="texto <?php echo $colorbg ?>">
			<span>TURNO:</span> <span><b><?php echo strtoupper($mat->codturno) ?></b></span>
		</td>
		
	</tr>
	<tr>
		<td class="texto" colspan="5">
			<span>PROGRAMA:</span> <span><b><?php echo strtoupper($curs_und->curso) ?></b></span>
		</td>
	</tr>
</table>
<hr>

<table class="encabezado" style="margin-bottom: 5px;">
	<tr>
		<td colspan="4" class="ccenter-nobold texto">
			<b>NOTAS ACADEMICAS</b>
		</td>
	</tr>
	
</table>
<hr style="margin-top: 0;">
<table class="encabezado" style="margin-bottom: 15px;">
	
	<?php

		$grupo = "";
		$unidades = array('CERO','UNO ','DOS ','TRES ','CUATRO ','CINCO ','SEIS ','SIETE ','OCHO ','NUEVE ','DIEZ ','ONCE ','DOCE ','TRECE ','CATORCE ','QUINCE ','DIECISEIS ','DIECISIETE ','DIECIOCHO ','DIECINUEVE ','VEINTE ');
		
		echo "<tr>
				<th colspan='2' class='texto celda'>EVALUACIÓN</th>
				<th class='texto celda'>NOTA</th>
				<th class='texto celda'>LETRAS</th>
			</tr>";
		foreach ($notas as $key => $not) {
			$grupogen = $not->indicador;
			if ($grupo!=$grupogen) {
				$grupo = $grupogen;
				echo "<tr>
						<td rowspan='4' class='celda ccenter-nobold'>
							<b>$grupo</b>
						</td>
						
					</tr>";
			}
			echo "<tr>
					<td class='celda'><b>$not->chead $not->orden</b></td>
					<td class='celda'>$not->nota</td>
					<td class='celda'>".$unidades[$not->nota]."</td>
				</tr>";
			// unset($notas[$key]);
		}

	?>
	
</table>

<table class="encabezado" style="margin-bottom: 5px;">
	<tr>
		<td colspan="3" class="ccenter-nobold texto">
			<b>ASISTENCIA</b>
		</td>
		
	</tr>
	
</table>
<hr style="margin-top: 0;">
<table class="encabezado" style="margin-bottom: 5px;">
	<?php
		$fini=24;
		$ffin=48;
		$nrofec = count($fechasasis);

		echo "<tr>";
		for ($i=0; $i <$fini ; $i++) {
            if (isset($fechasasis[$i])){
                $fecha=$fechasasis[$i];
                $fechaslt=date("d/m/y", strtotime($fecha->fecha));
                echo "<th class='celda rotar90' width='3px'>$fechaslt</th>";
            }

        }

        for ($i=$nrofec; $i < $fini ; $i++) { 
			echo "<th class='celda rotar90' width='3px'></th>";
		}
        echo "</tr>
        <tr>";

        for ($i=0; $i <$fini ; $i++) {

            if (isset($fechasasis[$i])){
                $fecha=$fechasasis[$i];
                $asistfec = $asistencias[$curs_und->idmiembro]['asis'][$fecha->sesion]['accion'];
                echo "<td class='celda ccenter-nobold' width='3px'>$asistfec</td>";
            }
            else{
                $i=$fini;
            }

        }

        for ($i=$nrofec; $i < $fini ; $i++) { 
			echo "<th class='celda ccenter-nobold' width='3px'></th>";
		}

        echo "</tr>";
		
	?>

</table>

<table class="encabezado" style="margin-bottom: 5px;">
	<?php
	if ($nrofec > $fini) {
		
		echo "<tr>";
		for ($i=$fini; $i <$ffin ; $i++) {
            if (isset($fechasasis[$i])){
                $fecha=$fechasasis[$i];

                $fechaslt=date("d/m/y", strtotime($fecha->fecha));
                echo "<th class='celda rotar90' width='3px'>$fechaslt</th>";
                
            }
            
        }

        for ($i=$nrofec ; $i < $ffin ; $i++) { 
			echo "<th class='celda rotar90' width='3px'></th>";
		}
        echo "</tr>
        <tr>";
        for ($i=$fini; $i <$ffin ; $i++) {

            if (isset($fechasasis[$i])){
                $fecha=$fechasasis[$i];
                $asistfec = $asistencias[$curs_und->idmiembro]['asis'][$fecha->sesion]['accion'];
                echo "<td class='celda ccenter-nobold' width='3px'>$asistfec</td>";
            }
            else{
                $i=$ffin;
            }

        }

        for ($i=$nrofec; $i < $ffin ; $i++) { 
			echo "<th class='celda ccenter-nobold' width='3px'></th>";
		}

        echo "</tr>";
    }
	?>
</table>

<table class="encabezado" style="margin-bottom: 5px;">
	<tr>
		<td colspan="3" class="ccenter-nobold texto">
			<b>AULA VIRTUAL</b>
		</td>
		
	</tr>
	
</table>
<hr style="margin-top: 0;">
<table class="encabezado" style="margin-bottom: 5px;">
	<?php
	
		foreach ($virtual as $key => $mat) {
			$vnotas = $virtnot[$curs_und->idmiembro]['virtual'][$mat->codigo]['vnota'];
			if (($vnotas != "00") || ($vnotas != "")) {
				$vnotletras = $vnotas;
			} else {
				$vnotletras = "0";
			}

			$vnotletras = ($vnotas != "00") ? $vnotas : "0";
			if ($mat->tipo == "T") {
				$tipov = "TAREA";
			} else {
				$tipov = "EVALUACIÓN";
			}
			echo "<tr>
					<td class='celda'>$mat->nombre ( $tipov )</td>
					<td class='celda'>$vnotletras</td>
					<td class='celda'>".$unidades[$vnotletras]."</td>
				</tr>";
		}
	
	?>
</table>
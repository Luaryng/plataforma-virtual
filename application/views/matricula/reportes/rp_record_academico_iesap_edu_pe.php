<style>
	@page {
		margin-top: 0.5cm;
		margin-bottom: 0.5cm;
		margin-left: 1.0cm;
		margin-right: 1.0cm;
	}
	
	.encabezado{
		width: 100%;
		border-collapse: collapse;
	}
	.logo-minedu{
		width: 200px;
	}

	.logo-ies{
		height:  40px;
		width: 200px;
	}
	.celda{
		height: 20px;
		padding: 5px;
		border: solid 1px black;
		font-size: 10px;
	}

	.celda-detalle{
		/*height: 20px;*/
		padding: 2px;
		border: solid 1px black;
		font-size: 11px;
	}

	.celda-top {
		padding: 2px;
		border-top: solid 1px black;
		font-size: 11px;
	}

	.celda-bottom {
		padding: 2px;
		border-bottom: solid 1px black;
		font-size: 11px;
	}

	.celda-left-bottom {
		padding: 2px;
		border-bottom: solid 1px black;
		border-left: solid 1px black;
		font-size: 11px;
	}

	.celda-right-bottom {
		padding: 2px;
		border-bottom: solid 1px black;
		border-right: solid 1px black;
		font-size: 11px;
	}

	.texto{
		height: 20px;
		padding: 5px;
		font-size: 12px;
	}
	.firmas{
		height: 20px;
		padding: 5px;
		font-size: 10px;
	}
	.cgris{
		background-color: lightgray;
	}
	.ccenter{
		text-align: center;
		font-weight: bold;
	}
	.ccenter-nobold{
		text-align: center;
	}

	.cright{
		text-align: right;
		font-weight: bold;
	}
	.w25p{
		width: 5cm;
	}
</style>

<table class="encabezado">

	<tr>
		<td>
			<img class="logo-minedu" src="<?php echo base_url().'resources/img/minedu_logo.png' ?>" alt="minedu">
		</td>
		<td valign="bottom"><b></b></td>
		<td width="100px">
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h80.'.getDominio().'.png' ?>" alt="iesap">
		</td>
	</tr>
	
	<tr>
		<td colspan="3" valign="bottom" align="center">
			<b><?php echo $ies->pnombre ?></b><br><b><?php echo $ies->nombre." - $sede" ?></b>
		</td>
	</tr>
	<tr>
		<td colspan="3" valign="bottom" align="center">
			<br><b>RECORD ACADÉMICO</b>
		</td>
	</tr>
</table>

<table class="encabezado" style="margin-top: 10px;">
	<tr>
		<td class="celda-top" colspan="1" width="200px">
			<b><span>PROGRAMA DE ESTUDIOS</span></b>
		</td>
		<td class="celda-top" colspan="3">
			<span><?php echo ": ".$insc->carrera ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda-bottom" colspan="1" width="200px">
			<b><span>ESTUDIANTE</span></b>
		</td>
		<td class="celda-bottom" colspan="3">
			<span><?php echo ": ".$insc->paterno." ".$insc->materno." ".$insc->nombres ?></span>
		</td>
	</tr>
</table>
<br>
<table class="encabezado">
	<tr>
		<td colspan="1" class="celda" width="25px">
			<b><span>N°</span></b>
		</td>
		<td colspan="1" class="celda ccenter-nobold" width="350px">
			<b><span>UNIDAD DIDÁCTICA</span></b>
		</td>
		<td colspan="1" class="celda ccenter-nobold" width="60px">
			<b><span>SEMESTRE</span></b>
		</td>
		<td colspan="1" class="celda ccenter-nobold" width="70px">
			<b><span>TUR / SEC</span></b>
		</td>
		<td colspan="1" class="celda ccenter-nobold" width="50px">
			<b><span>HORAS</span></b>
		</td>
		<td colspan="1" class="celda ccenter-nobold" width="50px">
			<b><span>CRD</span></b>
		</td>
		<td colspan="1" class="celda ccenter-nobold" width="50px">
			<b><span>NF</span></b>
		</td>
		<td colspan="1" class="celda ccenter-nobold" width="50px">
			<b><span>NR</span></b>
		</td>
		<td colspan="1" class="celda ccenter-nobold" width="50px">
			<b><span>PF</span></b>
		</td>
		<td colspan="1" class="celda ccenter-nobold" width="60px">
			<b><span>CONVALIDA</span></b>
		</td>
	</tr>
	<?php
		$grupo = "";
        $nro=0;
        $creAcumulada=0;
        $puntaje=0;
        
		foreach ($curs as $key => $cur) {
			$grupoint=$cur->codperiodo;
            if ($grupo!=$grupoint) {
            	if ($creAcumulada > 0){

            		echo "<tr>
			        	<td colspan='8' class='celda-left-bottom cright'>
							<b><span>PONDERADO:</span></b>
						</td>
						<td colspan='1' class='celda-right-bottom ccenter-nobold' width='60px'>
							".round($puntaje/$creAcumulada,2)."
						</td>
					</tr>";
            		$puntaje=0;
                    $creAcumulada=0;
                    $grupo=$grupoint;
                    $nro=0;
            	}
                $grupo=$grupoint;
                $nro=0;
                
                echo "<tr>
                	<td class='celda ccenter-nobold' colspan='9'><b><span>$cur->periodo</span></b></td>
                </tr>";
            }

            $nro++;
            $horast = $cur->hts + $cur->hps;
            $creditos=$cur->ct + $cur->cp;

            $creAcumulada=$creAcumulada + $creditos; 
            $nff=(is_numeric($cur->final))?$cur->final:0;
            $puntaje =$puntaje + ($nff * $creditos);

            echo "<tr>
                	<td colspan='1' class='celda-detalle' width='25px'>
						<span>$nro</span>
					</td>
					<td colspan='1' class='celda-detalle' width='350px'>
						<span>$cur->idunidad $cur->curso</span>
					</td>
					<td colspan='1' class='celda-detalle ccenter-nobold' width='60px'>
						<span>$cur->ciclo</span>
					</td>
					<td colspan='1' class='celda-detalle ccenter-nobold' width='70px'>
						<span>".substr($cur->turno,0,3)." / $cur->codseccion</span>
					</td>
					<td colspan='1' class='celda-detalle ccenter-nobold' width='50px'>
						<span>$horast</span>
					</td>
					<td colspan='1' class='celda-detalle ccenter-nobold' width='50px'>
						<span>$creditos</span>
					</td>
					<td colspan='1' class='celda-detalle ccenter-nobold' width='50px'>
						<span>$cur->nota</span>
					</td>
					<td colspan='1' class='celda-detalle ccenter-nobold' width='50px'>
						<span>$cur->recuperacion</span>
					</td>
					<td colspan='1' class='celda-detalle ccenter-nobold' width='50px'>
						<span>$cur->final</span>
					</td>
					<td colspan='1' class='celda-detalle ccenter-nobold' width='60px'>
						<span></span>
					</td>
                </tr>";


		}

		if ($creAcumulada > 0){
			echo "<tr>
	        	<td colspan='8' class='celda-left-bottom cright'>
					<b><span>PONDERADO:</span></b>
				</td>
				<td colspan='1' class='celda-right-bottom ccenter-nobold' width='60px'>
					".round($puntaje/$creAcumulada,2)."
				</td>
			</tr>";
		}
	?>
</table>

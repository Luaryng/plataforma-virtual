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
		padding: 7px 5px;
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

	.uppercase {
		text-transform: uppercase !important;
	}

	.text-group {
		background-color: #f4f4f4;
	}

	.div_detalle{
		
		margin-top: 5px;
		width: 100%;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border: solid 1px gray;
		font-size: 10px;

	}

	.celda-lados{
		height: 15px;
		font-size: 11px;
	}

	.encabeza_detalle{
		border-bottom: 1px solid black;
		padding-top: 5px;
		padding-bottom: 5px;
		margin-bottom: 1px;
	}

	.group-title {
		padding-top: 8px;
		padding-bottom: 8px;
		margin-bottom: 1px;
	}

	.border-right {
		border-right: 1px solid gray;
	}

	.border-none {
		border-right: 0;
		border-left: 0;
	}

	.text-left {
		text-align: left;
		padding-left: 10px;
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
			<b>REPORTE ACADÉMICO ASISTENCIAS</b>
			<hr>
		</td>
		
	</tr>
</table>

<table class="encabezado">
	<tr>
		<td class="texto">
			DOCENTE:
		</td>
		<td colspan="2" class="texto">
			<span><?php echo "<b>$docente</b>" ?></span>
		</td>
		
	</tr>
	
</table>
<!-- <br> -->

<hr style="margin-top: -5px;border: 0;height: 0;color: #fff;">
<div class="div_detalle mb">
	<table class="encabezado celda-lados" cellpadding="0" cellspacing="0">
		<tr>
			<th class='ccenter-nobold encabeza_detalle border-right uppercase'>UNIDAD DIDAC.</th>
			<th class='ccenter-nobold encabeza_detalle border-right uppercase'>FEC. SESIÓN</th>
			<th class='ccenter-nobold encabeza_detalle border-right uppercase'>HORA SESIÓN</th>
			<th class='ccenter-nobold encabeza_detalle border-right uppercase'>ASISTIÓ</th>
			<th class='ccenter-nobold encabeza_detalle border-right uppercase'>HORA/MIN</th>
			<th class='ccenter-nobold encabeza_detalle uppercase'>OBS.</th>
		</tr>
		<?php
			$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
			$agrupar = "";
			$agrupar2 = "";
			foreach ($cursos as $key => $asist) {
				// $grupoint = $asist->idunidad.$asist->unidad;
				$grupoint = ($asist->unidad != null) ? $asist->unidad : $asist->unidad2;
				$fechass = new DateTime($asist->sesfecha);
				$fechases = $dias[$fechass->format('w')].". ".$fechass->format('d/m/Y');
				$horases = date("h:i a",strtotime($asist->horaini))." - ".date("h:i a",strtotime($asist->horafin));

				$fecha = new DateTime($asist->fecha);
				$fechasist = $dias[$fecha->format('w')].". ".$fecha->format('d/m/Y h:i a');
				$detalle = $asist->detalle;

				$horasist = $fecha->format('H:i');
				$asishora = new DateTime($horasist);
				$seshorini = new DateTime($asist->horaini);
				$seshora = new DateTime($asist->horafin);

				$diferencia = $asishora->diff($seshora);
				$observ = "";

				if ($asishora > $seshorini) {
					$observ = "Tarde";
				}

				if ($asist->fecha == null) {
					$observ = "No asistio";
					$fechasist = "";
					$tiempo = "";
				} else {
					$tiempo = $diferencia->format('%H hor. %i min.');
				}

				if ($grupoint != $agrupar) {
					if($agrupar!="") echo "<tr><td colspan='6' style='padding:7px 0;border-bottom:1px solid gray;background:#fff'></td></tr>";
					$agrupar = $grupoint;
					echo "<tr>
						<th colspan='6' class='ccenter-nobold group-title uppercase text-group'>$agrupar</th>
					</tr>";
				}

				echo "<tr>";
				$grupoint2 = $asist->idses.$detalle.$fechases;
				if ($grupoint2 != $agrupar2) {
					$agrupar2 = $grupoint2;

					echo "<td class='celda uppercase border-none'><b>$detalle</b></td>
						<td class='celda'>$fechases</td>
						<td class='celda'>$horases</td>";
				} else {
					echo "<td class='celda uppercase border-none border-right' colspan='3'></td>";
				}

				echo "<td class='celda'>$fechasist</td>
						<td class='celda'>$tiempo</td>
						<td class='celda border-none'>$observ</td>
					</tr>";
			}
			

		?>
		
	</table>
</div>


	<table style="border: solid; border-color: gray;border-spacing:0px 0px;margin-top: 10px" width="100%" border="1" align="center">
		<caption style="color:#000;font-weight: 700;">HORARIO DE CLASES - <?php echo $titulodocente ?></caption>
		<thead>
			<tr>
				<th style="font-size: 8.5px;width: 10%">Hora</th>
				<th style="font-size: 8.5px;width: 15%">LUNES</th>
				<th style="font-size: 8.5px;width: 15%">MARTES</th>
				<th style="font-size: 8.5px;width: 15%">MIÉRCOLES</th>
				<th style="font-size: 8.5px;width: 15%">JUEVES</th>
				<th style="font-size: 8.5px;width: 15%">VIERNES</th>
				<th style="font-size: 8.5px;width: 15%">SÁBADO</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$arrayDias = array('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO');
		foreach ($horas as $key => $hora) {
			$date = new DateTime($hora->inicia);
			$vhorai= $date->format('h:ia');
			$date = new DateTime($hora->culmina);
			$vhoraf= $date->format('h:ia');?>
			<tr>
				<td style="font-size: 9px;font-weight: 600;text-align: center;"><?php echo $vhorai."<br>".$vhoraf ?></td>
				<?php foreach ($arrayDias as $key => $dia) { ?>
				<td style="font-size: 9px;text-align: center;">
					<span><?php echo $horario[$dia][$hora->inicia]["value"];?></span>
				</td>
				<?php } ?>					
			</tr>
		<?php } ?>
		</tbody>
	</table><br>
	<?php if ($_SESSION['userActivo']->nivelid==10) {
		
	}else{ ?>
	<table style="border: solid; border-color: gray;border-spacing:0px 0px;margin-top: 10px" width="100%" border="1" align="center">
		<caption>RESUMEN</caption>
		<thead>
			<tr>
				<th style="font-size: 10px;width: 50%">CURSOS / ESPECIALIDAD</th>
				<th style="font-size: 10px;width: 10%">SEMESTRE</th>
				<th style="font-size: 10px;width: 15%">TURNO</th>
				<th style="font-size: 10px;width: 15%">AULA</th>
				<th style="font-size: 10px;width: 10%">N° HORAS</th>
			</tr>
		</thead>
		<tbody>
			<?php
		foreach ($resumenh as $key => $curso) { ?>
			<tr>
				<td style="font-size: 9.5px;padding-left: 2px">
					<span><?php echo $curso->abrev." - ".$curso->nomcurso;?></span>
				</td>
				<td style="font-size: 9.5px;text-align: center;">
					<span><?php echo $curso->ciclo." ".$curso->seccion;?></span>
				</td>
				<td style="font-size: 9.5px;text-align: center;">
					<span><?php echo $curso->turno;?></span>
				</td>
				<td style="font-size: 9.5px;text-align: center;">
					<span><?php echo $curso->haula;?></span>
				</td>
				<td style="font-size: 9.5px;text-align: center;">
					<span><?php echo $curso->horas;?></span>
				</td>
			</tr>
		<?php } ?>
			<tr>
				<td colspan="4" style="font-size: 9.5px;text-align: center;">TOTAL DE HORAS</td>
				<td style="font-size: 9.5px;text-align: center;"></td>
			</tr>
		</tbody>
	</table>
<?php } ?>

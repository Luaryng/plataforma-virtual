<table class="tbportada">
		<tr>
			<td width="50%">
				<img src="<?php echo base_url().'resources/img/minedu_logo.png' ?>" alt="MINEDU">
			</td>
			<td width="50%" align="right">
				<span style="font-size:11px;letter-spacing: 0 ">REVALIDADO<br>R.D.N° 0555-06-ED</span>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<br><br>
				<img src="<?php echo base_url().'resources/img/logo_h110.'.getDominio().'.png' ?>" alt="MINEDU"><br>
				<span style="font-size: 12px">DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO</span><br>
				<span style="font-size: 30px">CANCHAQUE</span><br>
				<span style="font-size: 11px">R.M.N° 0290-94-ED</span><br>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<br>
				<span style="font-weight: bold;font-size: 23px">REGISTRO DE EVALUACIÓN Y APRENDIZAJES AÑO <?php echo  $curso->periodo ?></span>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<br>
				<br>
				<span class="etq1" >CARRERA PROFESIONAL:</span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="retp1"><?php echo $curso->carrera ?></span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="etq1" >MÓDULO EDUCATIVO N°: <?php echo  $curso->modulonro ?></span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="etq1" >DENOMINACIÓN:</span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="retp1"><?php echo $curso->modulo ?></span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="etq1" >UNIDAD DIDÁCTICA</span><br>
			</td>
		</tr>
		<tr class="tr-etq1">
			<td colspan="2">
				<span class="retp1"><?php echo $curso->unidad ?></span><br>
			</td>
		</tr>
	</table>
	<br>
	<table border="1" width="100%">
		<tr>
			<td colspan="6" align="center">
				<h3>HORARIO:</h3>
			</td>
		</tr>
		<tr>
			<td class="horario-celda">Lun.</td><td class="horario-celda">Mar.</td><td class="horario-celda">Mie.</td><td class="horario-celda">Jue.</td><td class="horario-celda">Vie.</td><td class="horario-celda">Sab.</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>
		<tr>
			<td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td><td class="horario-celda">&nbsp;</td>
		</tr>

	</table>
	<br>
	<table >
		<tr>
			<td width="50%" class="etq1">
				HORAS SEMESTRALES<br>
			</td>
			<td width="2%">
				:
			</td>
			<td width="48%">
				<?php echo $curso->horas_ciclo ?>
			</td>
		</tr>
		<tr>
			<td><span class="etq1">CRÉDITOS</span></td><td>:</td><td><?php echo ($curso->cred_teo + $curso->cred_pra) ?></td>
		</tr>
		<tr>
			<td><span class="etq1">SECCIÓN</span></td><td>:</td><td><?php echo $curso->codseccion."-".$curso->division ?></td>
		</tr>
		<tr>
			<td><span class="etq1">TURNO</span></td><td>:</td><td><?php echo $curso->turno ?></td>
		</tr>
		<tr>
			<td><span class="etq1"></span></td><td></td><td></td>
		</tr>
		<tr>
			<td><span class="etq1">SEMESTRE ACADÉMICO</span></td><td>:</td><td><?php echo $curso->periodo ?></td>
		</tr>
		<tr>
			<td><span class="etq1">SEMESTRE DE ESTUDIOS</span></td><td>:</td><td><?php echo $curso->ciclo ?></td>
		</tr>
		<tr>
			<td><span class="etq1">DOCENTE</span></td><td>:</td><td><?php echo $curso->paterno.' '.$curso->materno.' '.$curso->nombres ?></td>
		</tr>
		<tr>
			<td><span class="etq1">DIRECTOR</span></td><td>:</td><td>AGNES CAROLINA CUEVA ROSALES</td>
		</tr>
		<tr>
			<td colspan="3" align="right">
				<br>
				<br>
				<br>
				_______________________________ <br>
				Firma del docente
			</td>
		</tr>
	</table>
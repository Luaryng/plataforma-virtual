<style>
	@page {
	margin-top: 1cm;
	margin-bottom: 1cm;
	margin-left: 1.0cm;
	margin-right: 1.5cm;
	}
	.text-dinamico{
		border-bottom: 1px solid black;
		padding: 0 5px 0 5px; 
	}
	
</style>
<?php
	
	date_default_timezone_set('America/Lima');
	$vbaseurl = base_url();
	$vfecha=date('d/m/Y', strtotime($tmps['solicitud']->fecha));
	$fechahoy = date('d/m/Y');

?>
	
	<table border="0" width="100%">
		<tr>
			<td width="10%">
				<img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png'?>" alt="Logo" style="width: 200px;height: 40px;margin-left: 20px;">
			</td>
			
			<td width="90%" style="text-align: center;">
				<span><?php echo $ies->pnombre ?></span><br>
				<span style="font-size: 30px">"<?php echo $ies->snombre ?>"</span><br>
				<span style="font-size: 10px">RESOLUCIÓN: <?php echo $ies->resolucion ?> </span><br>
				
			</td>
		</tr>
		<tr>
			<td colspan="2" style="border-top: 1px solid #000;"></td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%">
		<tr>
			<td valign="top" colspan="2" style="text-align: center;">
				<span style="font-size: 20px">TRAMITE N°<?php echo $tmps['solicitud']->codseg; ?></span>
			</td>
			<td valign="top" style="text-align: center;">
				<span style="font-size: 20px;">FECHA : <?php echo $vfecha; ?></span>
			</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%">
		<tr>
			<td style="text-align: justify; font-size: 14px;line-height: 25px;">
				TRAMITE : <?php echo $tmps['solicitud']->tramite ?>
			</td>
			<td style="text-align: justify; font-size: 14px;line-height: 25px;">
				ASUNTO: <?php echo $tmps['solicitud']->asunto ?>
			</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" style="border: 1px solid #ced4da;">
		<tr style="background-color: #ced4da;">
			<td valign="top" width="100%" style="padding: 8px;text-align: center">
				<span style="font-size: 13px;">DATOS DEL SOLICITANTE</span>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td valign="top" width="50%" style="padding: 8px;">
				<span style="font-size: 13px;">
					SOLICITANTE: <?php echo $tmps['solicitud']->tipodoc." - ".$tmps['solicitud']->nrodoc." / ".$tmps['solicitud']->solicitante ?>
				</span>
			</td>
			<td valign="top" width="50%" style="padding: 8px;">
				<span style="font-size: 13px;">
					DOMICILIO: <?php echo $tmps['solicitud']->domicilio ?>
				</span>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td valign="top" width="100%" style="padding: 8px;">
				<span style="font-size: 13px;">
					EMAIL: <?php echo $tmps['solicitud']->email_personal ?>
				</span>
			</td>
		</tr>
		<tr>
			<td valign="top" width="50%" style="padding: 8px;">
				<span style="font-size: 13px;">
					TELÉFONO / CELULAR: <?php echo $tmps['solicitud']->telefono ?>
				</span>
			</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" style="border: 1px solid #ced4da;">
		<tr style="background-color: #ced4da;">
			<td valign="top" width="100%" style="padding: 8px;text-align: center">
				<span style="font-size: 13px;">CONTENIDO</span>
			</td>
		</tr>
		<tr>
			<td valign="top" width="100%" style="padding: 8px; height: 200px">
				<span style="font-size: 12px;text-align: justify;"> <?php echo $tmps['solicitud']->contenido ?></span>
			</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" style="border: 1px solid #ced4da; ">
		<tr style="background-color: #ced4da;border-bottom: 1px solid #ced4da;">
			<td valign="top" colspan="8" style="padding: 8px;">
				<span style="font-size: 15px;text-align: justify;">Adjunto como medios probatorios copia simple de lo siguiente:</span>
			</td>
		</tr>
		<?php
		$nro=0;
			foreach ($tmps['adjuntos'] as $tms) {
				
			$nro++;
		?>
		<tr>
			<td valign="top"  colspan="1" style="border-right: 1px solid #ced4da;border-bottom: 1px solid #ced4da;width: 40px;">
				<span style="font-size: 13px;"><?php echo str_pad($nro, 2, "0", STR_PAD_LEFT); ?>.</span>
			</td>
			<td valign="top"  colspan="7" style="border-bottom: 1px solid #ced4da;">
				<span style="font-size: 13px;text-align: justify;"> <?php echo $tms->titulo ?></span>
			</td>
		</tr>
		<?php
			}
		for ($i=$nro; $i <6 ; $i++) { ?>
			<tr>
			<td valign="top"  colspan="1" style="border-right: 1px solid #ced4da;border-bottom: 1px solid #ced4da;width: 40px;">
				
			</td>
			<td valign="top"  colspan="7" style="border-bottom: 1px solid #ced4da;">
				<span style="font-size: 13px;text-align: justify;"> &nbsp;&nbsp;</span>
			</td>
		</tr>
		<?php }	?>


		<tr>
			<td colspan="8"></td>
		</tr>
		<tr>
			<td colspan="8"></td>
		</tr>
	</table>

	<br>
	<table border="0" width="100%">
		<tr>
			<td colspan="2" style="border-top: 2px solid #000;"></td>
		</tr>
		<tr>
			<td valign="bottom" style="text-align: left">
				<span style="font-size: 12px;margin-left: 20px;"></span>
			</td>
			<td valign="bottom" style="text-align: right;">
				<span style="font-size: 12px;margin-right: 20px;"> <?php echo $fechahoy ?></span>
			</td>
		</tr>
	</table>
	
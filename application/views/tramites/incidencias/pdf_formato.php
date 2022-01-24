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
$vbaseurl = base_url();
if (isset($incidencia->id)) {
	
	$vfecha=date('d/m/Y', strtotime($incidencia->fecha));
	$nroinc=str_pad($incidencia->id, 4, "0", STR_PAD_LEFT);

?>
	
	<table border="0" width="100%">
		<tr>
			<td width="10%">
				<img src="<?php echo $vbaseurl.'resources/img/logo_h110.'.getDominio().'.png'?>" alt="Logo" style="width: 60px;height: 80px;margin-left: 20px;">
			</td>
			
			<td width="90%" style="text-align: center;">
				<span><?php echo $ies->pnombre ?></span><br>
				<span style="font-size: 30px">"<?php echo $ies->snombre ?>"</span><br>
				<span style="font-size: 10px">RESOLUCIÓN: <?php echo $ies->resolucion ?> REVALIDADO: <?php echo $ies->revalidacion ?></span><br>
				
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
				<span style="font-size: 20px">INCIDENCIA DN<?php echo $nroinc; ?></span>
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
				<?php
					echo
					"Yo, <span class='text-dinamico'>&nbsp;&nbsp;&nbsp;$incidencia->nombres &nbsp;&nbsp;&nbsp;</span> identificado(a) con <span class='text-dinamico'>&nbsp;&nbsp;&nbsp;$incidencia->tipodoc &nbsp;&nbsp;&nbsp;</span> N° <span class='text-dinamico'>&nbsp;&nbsp;&nbsp;$incidencia->documento &nbsp;&nbsp;&nbsp;</span> y con domicilio en <span class='text-dinamico'>&nbsp;&nbsp;&nbsp;$incidencia->domicilio &nbsp;&nbsp;&nbsp;</span> distrito de <span class='text-dinamico'>&nbsp;&nbsp;&nbsp;$incidencia->distrito &nbsp;&nbsp;&nbsp;</span> me presento con finalidad de dejar constancia de una incidencia contra  <span class='text-dinamico'>&nbsp;&nbsp;&nbsp;$incidencia->asunto &nbsp;&nbsp;&nbsp;</span> , conforme a los hechos que a continuación expongo:";
				?>
			</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" style="border: 1px solid #ced4da;">
		<tr style="background-color: #ced4da;">
			<td valign="top" width="100%" style="padding: 8px;">
				<span style="font-size: 10px;text-align: justify;">(realizar una exposición clara y precisa de la relación de los hechos de la incidencia, las circunstancias de tiempo, lugar y modo, la indicación de sus presuntos autores y participantes y el aporte de alguna evidencia o su descripción, asi como cualquier otro elemento que permita su comprobación)</span>
			</td>
		</tr>
		<tr>
			<td valign="top" width="100%" style="padding: 8px; height: 350px">
				<span style="font-size: 15px;text-align: justify;"> <?php echo $incidencia->detalle ?></span>
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
			foreach ($pruebas as $incd) {
				
			$nro++;
		?>
		<tr>
			<td valign="top"  colspan="1" style="border-right: 1px solid #ced4da;border-bottom: 1px solid #ced4da;width: 40px;">
				<span style="font-size: 13px;"><?php echo str_pad($nro, 2, "0", STR_PAD_LEFT); ?>.</span>
			</td>
			<td valign="top"  colspan="7" style="border-bottom: 1px solid #ced4da;">
				<span style="font-size: 13px;text-align: justify;"> <?php echo $incd->titulo ?></span>
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
			<td valign="top" colspan="8" style="text-align: justify;">
				<span style="font-size: 13px;">
					<br>
					En caso no se cuente con la prueba física, declaro bajo juramento que la autoridad / empresa / entidad:
				</span>
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="4"  style="border-bottom: 1px solid #000;text-align: center;">
				<span style="font-size: 14px;">
					<?php echo $incidencia->declara ?>
				</span>
			</td>
			<td valign="top" colspan="4" >
				<span style="font-size: 14px;text-align: left;">la tiene en su poder.</span>
			</td>
		</tr>
		<tr>
			<td colspan="8"></td>
		</tr>
		<tr>
			<td colspan="8"></td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" style="border: 1px solid #ced4da;">
		<tr>
			<td valign="top" width="50%" style="border-bottom: 1px solid #ced4da;text-align: center;border-right: 1px solid #ced4da;">
				<span style="font-size: 13px;"> <?php echo $incidencia->nombres ?></span>
			</td>
			<td valign="top" width="50%" style="border-bottom: 1px solid #ced4da;text-align: center;">
				<span style="font-size: 13px;"> <?php echo $incidencia->documento ?></span>
			</td>
		</tr>
		<tr>
			<td valign="top" width="50%" colspan="1" style="text-align: center;border-right: 1px solid #ced4da;">
				<span style="font-size: 10px;"> APELLIDOS Y NOMBRES DEL DENUNCIANTE</span>
			</td>
			<td valign="top" width="50%" colspan="1" style="text-align: center;">
				<span style="font-size: 10px;"> DOCUMENTO NACIONAL DE IDENTIDAD</span>
			</td>
		</tr>
		
	</table>
	<br>
	<table border="0" width="100%">
		<tr>
			<td colspan="2" style="border-top: 2px solid #000;"></td>
		</tr>
		<tr>
			<td valign="top" style="text-align: left">
				<span style="font-size: 12px;margin-left: 20px;"><?php echo $ies->direccion ?></span>
			</td>
			<td valign="top" style="text-align: right;">
				<span style="font-size: 12px;margin-right: 20px;"> TELÉFONO <?php echo $ies->telefono ?></span>
			</td>
		</tr>
	</table>
	<?php
	}
	?>
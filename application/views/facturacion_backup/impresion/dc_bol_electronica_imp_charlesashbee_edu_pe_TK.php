<style>
	@page {
		margin-top: 0.2cm;
		margin-bottom: 0.5cm;
		margin-left: 0.5cm;
		margin-right: 0.5cm;
		/*margin: 0;*/
	}
	
	.encabezado{
		width: 100%;
		border-collapse: collapse;
	}
	.logo-minedu{
		width: 200px;
	}

	.logo-ies{
		height:  80px;
	}
	.celda{
		height: 20px;
		padding: 5px;
		border: solid 1px black;
		font-size: 11px;
	}
	.celda-lados{
		height: 20px;
		padding: 5px;
		border-left: solid 1px black;
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
	.right-nobold{
		text-align: right;
	}
	.w25p{
		width: 5cm;
	}

	.text-footer {
		font-style: italic;
		font-size: 10px;
	}

	.text-small-8 {
		font-size: 10px;
	}

	.text-small-5 {
		font-size: 10px;
	}
	.text-small-4 {
		font-size: 9px;
	}

	.logo-ies2 {
		height: : 30px;
	}

	.border-top {
		border-top: #000 1px dotted;
	}

	.margin-top {
		margin-top: 5px;
	}
	.padding-top {
		padding-top: 5px;
	}

	.border-bottom {
		border-bottom: #000 1px dotted;
	}

	.border-top-bottom {
		border-top: #000 1px dotted;
		/*border-bottom: #000 1px dotted;*/
	}

	
</style>
<?php if ($pag->estado=='ANULADO'): ?>
<watermarkimage src="<?php echo base_url().'resources/img/anulado.png' ?>" alpha="0.1" position="0,30"  size="D" />	
<?php endif ?>
<table class="encabezado">
	
	<tr>
		<td class="ccenter-nobold padding-top" colspan="4">
			
			<b><h4>IESTP CHARLES ASHBEE</h4></b>
		</td>
	</tr>
	<tr>
		<td class="ccenter-nobold " colspan="4">
			<?php echo "
			<span class='text-small-5' >$dserie->direccion</span><br>
			<span class='text-small-5' >{$dserie->distrito}, {$dserie->provincia}, {$dserie->departamento}</span><br>
			<span class='text-small-5' ><b>RUC $dserie->ruc</b></span><br>";
			
			 ?>
		</td>
	</tr>
	<tr>
		<td class="ccenter-nobold" colspan="4">
			<b class="text-small-5"><?php 
			$nrocorrel=str_pad($pag->numero, 6, "0", STR_PAD_LEFT);
			echo $pag->nomimpreso.'<br> '.$pag->serie.'-'.$nrocorrel ?>
				
			</b>
		</td>
	</tr>
</table>
<br>
<table class="encabezado">
	<tr>
		<td>
			<span class="text-small-5">EMISIÓN: <?php echo date("d/m/Y h:i a", strtotime($pag->fecha)) ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<span class="text-small-5">CÓD: <?php echo $pag->pagante ?></span>
		</td>
		
		
	</tr>
	<tr>
		
		<td>
			<span class="text-small-5"><?php echo "{$pag->ptipodoc}: $pag->pnrodoc <br>
			PAGANTE: $pag->pagantenom <br>
			<br>
			MONEDA: soles<br>
			IGV: {$pag->igv}%" ?></span>
		</td>
		
	</tr>
</table>

<table class="encabezado margin-top">
	<tr>
		
		<td class="border-top-bottom"><span class="text-small-4"><b>[CANT.]</b> CONCEPTO</span></td>
		<td class="border-top-bottom"><span class="text-small-4">P.U</span></td>
		<td class="border-top-bottom"><span class="text-small-4">TOTAL</span></td>
	</tr>
	<?php
	$total = 0;
		foreach ($detalle as $key => $det) {
			$total +=$det->valventa;
	?>
		<tr>
			
			
			<td width="150px" ><span class="text-small-4"><?php echo "<b>[$det->cantidad]</b> $det->gestid $det->gestion" ?></span></td>
			<td ><span class="text-small-4"><?php echo "$det->vunitario" ?></span></td>
			<td class="right-nobold"><span class="text-small-4"><?php echo $det->valventa ?></span></td>
		</tr>
	<?php } ?>
	<tr><td colspan="3" class="border-top-bottom"></td></tr>
	<?php 
	if ($pag->opinafec>0): ?>
	<tr>
		<td  align="right" class="text-small-4">INAFECTA</td>
		<td align="right" class="right-nobold"><span class="text-small-4">S/.</span></td>
		<td align="right" class="right-nobold">
			<span class="text-small-5"><?php echo number_format($pag->opinafec, 2, '.', '');?></span>
		</td>
	</tr>
	<?php endif ?>
	<?php if ($pag->opexone>0): ?>
	<tr>
		<td  align="right" class="text-small-4">EXONERADA</td>
		<td align="right" class="right-nobold"><span class="text-small-4">S/.</span></td>
		<td align="right" class="right-nobold">
			<span class="text-small-5"><?php echo number_format($pag->opexone, 2, '.', '');?></span>
		</td>
	</tr>
	<?php endif ?>
	<?php if ($pag->opexport>0): ?>
	<tr>
		<td  align="right" class="text-small-4">EXPORTACIÓN</td>
		<td align="right" class="right-nobold"><span class="text-small-4">S/.</span></td>
		<td align="right" class="right-nobold">
			<span class="text-small-5"><?php echo number_format($pag->opexport, 2, '.', '');?></span>
		</td>
	</tr>
	<?php endif ?>
	<?php if ($pag->opgratis>0): ?>
	<tr>
		<td  align="right" class="text-small-4">GRATUITAS</td>
		<td align="right" class="right-nobold"><span class="text-small-4">S/.</span></td>
		<td align="right" class="right-nobold">
			<span class="text-small-5"><?php echo number_format($pag->opgratis, 2, '.', '');?></span>
		</td>
	</tr>
	<?php endif ?>
	<tr>
		<td align="right" class="border-bottom text-small-4">IGV</td>
		<td class="border-bottom right-nobold"><span class="text-small-4">S/.</span></td>
		<td class="border-bottom right-nobold">
			<span class="text-small-5"><?php echo number_format($pag->migv, 2, '.', '');?></span>
		</td>
	</tr>
	<tr>
		<td align="right" class="border-bottom text-small-4">ICBPER</td>
		<td class="border-bottom right-nobold"><span class="text-small-4">S/.</span></td>
		<td class="border-bottom right-nobold">
			<span class="text-small-5"><?php echo number_format($pag->micbper, 2, '.', '');?></span>
		</td>
	</tr>
	<tr>
		<td align="right" class="border-bottom text-small-4">TOTAL</td>
		<td class="border-bottom right-nobold"><span class="text-small-4">S/.</span></td>
		<td class="border-bottom right-nobold">
			<span class="text-small-5"><?php echo number_format($pag->total, 2, '.', '');?></span>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="text-small-5">

			<b>MONTO EN LETRAS: </b>
			<?php 
			$ndecimal=$pag->total - intval($pag->total);
			$tdecimal=explode('.', number_format($ndecimal, 2))[1];
			
			echo strtoupper($mtexto)." CON ".$tdecimal."/100 SOLES"; 
			?>
		</td>
	</tr>
	
	
</table>

<?php 
	
	
	
	if (trim($pag->cadena_qr)==""){
		$nrocorrel=str_pad($pag->numero, 6, "0", STR_PAD_LEFT);
		$migv=number_format($pag->migv, 2);
		$mtotal=number_format($pag->total, 2);
		$fechaemision = date('d/m/Y', strtotime($pag->fecha));
		$contenidoqr ="{$dserie->ruc}|{$pag->codtpdcsnt}|{$pag->serie}|{$nrocorrel}|{$migv}|{$mtotal}|{$fechaemision}|{$pag->codtipsnt}|{$pag->pnrodoc}|";
	}
	else{
		$contenidoqr = $pag->cadena_qr ;
	}
	
?>
<table class="encabezado">
	<tr>
		<td>
			<span class="text-small-5"><?php echo $pag->observacion ?></span>
		</td>
		
	</tr>
	<tr>
		<td>
			<span class="text-small-4"><?php echo "Representación impresa de la {$pag->nomimpreso}, para ver el documento visita <b>https://merakitd.pse.pe/{$dserie->ruc}</b>";?><br>
				Emitido mediante un <b>PROVEEDOR Autorizado por la SUNAT</b> mediante Resolución de Intendencia No.<b>034-005-0005315</b> <br>
			</span>
		</td>
		
	</tr>
	<tr>
		<td align="center" class="padding-top">
			<barcode code="<?php echo $contenidoqr ?>" type="QR" size="1" error="M" disableborder="1" />
		</td>
	</tr>
	<tr>
		<td align="center" class="padding-top">
			<span class="text-small-5">Soportado por MERAKI TD</span>
		</td>
	</tr>
	
</table>
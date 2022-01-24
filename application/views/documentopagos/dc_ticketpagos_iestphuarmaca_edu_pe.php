<style>
	@page {
		margin-top: 0.2cm;
		margin-bottom: 0.5cm;
		margin-left: 0.5cm;
		margin-right: 0.5cm;
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
		font-size: 11px;
	}

	.text-small-8 {
		font-size: 8px;
	}

	.text-small-5 {
		font-size: 5px;
	}

	.logo-ies2 {
		width: 25px;
	}

	.border-top {
		border-top: #000 1px dotted;
	}

	.margin-top {
		margin-top: 5px;
	}

	.border-bottom {
		border-bottom: #000 1px dotted;
	}

	.border-top-bottom {
		border-top: #000 1px dotted;
		border-bottom: #000 1px dotted;
	}

	
</style>

<table class="encabezado">
	<tr>
		<td class="ccenter-nobold" colspan="4">
			<img class="logo-ies2" src="<?php echo base_url().'resources/img/logo_h80.'.getDominio().'.png' ?>" alt="charlesashbee">
		</td>
	</tr>
	<tr>
		<td class="ccenter-nobold" colspan="4">
			<b class="text-small-8"><?php echo $ies->denomc ?></b>
		</td>
	</tr>
	<tr>
		<td class="ccenter-nobold" colspan="4">
			<span class="text-small-5" >RUC: <?php echo $dserie->ruc ?></span><br>
			<span class="text-small-5" ><?php echo $ies->direccion ?></span><br>
			<span class="text-small-5" ><?php echo $ies->distrito.' - '.$ies->provincia ?></span>
		</td>
	</tr>
	<tr>
		<td class="ccenter-nobold" colspan="4">
			<b class="text-small-5"><?php echo $pag->nomimpreso.' '.$pag->serie.' - 0000'.$pag->numero ?></b>
		</td>
	</tr>
	<tr>
		<td>
			<span class="text-small-5">FECHA DE EMISIÓN:</span>
		</td>
		<td colspan="3">
			<span class="text-small-5"><?php echo date("d/m/Y h:i a", strtotime($pag->fecha)) ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<span class="text-small-5">CÓDIGO:</span>
		</td>
		<td>
			<span class="text-small-5"><?php echo $pag->pagante ?></span>
		</td>
		<td>
			<span class="text-small-5">RUC - DNI:</span>
		</td>
		<td>
			<span class="text-small-5"><?php echo $pag->pnrodoc ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<span class="text-small-5">PAGANTE:</span>
		</td>
		<td colspan="3">
			<span class="text-small-5"><?php echo $pag->nompagante ?></span>
		</td>
		
	</tr>
	<tr>
		<td>
			<span class="text-small-5">OBSERVACIONES:</span>
		</td>
		<td colspan="3">
			<span class="text-small-5">CAJA</span>
		</td>
	</tr>
</table>
<table class="encabezado margin-top">
	<tr>
		<td class="border-top-bottom"><span class="text-small-5">CANTIDAD</span></td>
		<td class="border-top-bottom"><span class="text-small-5">CÓDIGO</span></td>
		<td class="border-top-bottom"><span class="text-small-5">CONCEPTO</span></td>
		<td class="border-top-bottom"><span class="text-small-5">IMPORTE</span></td>
	</tr>
	<?php
	$total = 0;
		foreach ($detalle as $key => $det) {
			$total +=$det->monto;
	?>
		<tr>
			<td class=""><span class="text-small-5"><?php echo $det->cantidad.'.00' ?></span></td>
			<td class=""><span class="text-small-5"><?php echo $det->gestionid ?></span></td>
			<td class=""><span class="text-small-5"><?php echo $det->nombregest ?></span></td>
			<td class="right-nobold"><span class="text-small-5"><?php echo $det->monto ?></span></td>
		</tr>
	<?php
		}
	?>
	<tr>
		<td colspan="2" class="border-top"></td>
		<td class="border-top right-nobold"><span class="text-small-5">IGV-18%: S/.</span></td>
		<td class="border-top right-nobold">
			<span class="text-small-5"><?php echo $pag->igv ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="border-bottom"></td>
		<td class="border-bottom right-nobold"><span class="text-small-5">IMPORTE TOTAL: S/.</span></td>
		<td class="border-bottom right-nobold">
			<span class="text-small-5"><?php echo number_format($pag->total, 2, '.', '');?></span>
		</td>
	</tr>
</table>

<?php 
	
	$fechaemision = date('d/m/Y h:i a', strtotime($pag->fecha));
	$totalimp = number_format($total, 2, '.', '');
	$contenidoqr = "$pag->nomimpreso $pag->serie - 0000$pag->numero, FECHA DE EMISIÓN: {$fechaemision}, CODIGO: {$pag->pagante},
					PAGANTE: {$pag->nompagante}, RUC / DNI: {$pag->pnrodoc},
					TOTAL: S/.{$totalimp}";
?>
<table class="encabezado text-footer margin-top ccenter-nobold">
	<tr>
		<td><barcode code="<?php echo $contenidoqr ?>" type="QR" size="0.4" error="M" disableborder="1" /></td>
	</tr>
	<tr>
		<td><span class="text-small-8">Gracias por confiar en nosotros!</span></td>
	</tr>
	<tr>
		<td><span class="text-small-5">Autorizado mediante resolución N°</span></td>
	</tr>
	<tr>
		<td><span class="text-small-5">Presentación impresa de la Boleta Electrónica</span></td>
	</tr>
	<tr>
		<td><span class="text-small-5">Para Consultar ingrese a: www---------</span></td>
	</tr>
</table>
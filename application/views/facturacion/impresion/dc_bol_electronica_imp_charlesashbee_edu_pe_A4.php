<style>
	@import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@1,500&display=swap');
	@page {
		margin: 0;
		
	}
	.div_logo{
		float: left;
	
		border:0;
		width: 50%;
	}
	.logo-ies{
		height:  60px;
	}
	.div_emisor{
		padding: 5px;
		float: right;
		width: 40%;
		border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
font-size: 13px;
font-weight: bold;
text-align: center;
border: solid 1px gray;

	}
	.div_cliente{
		margin-top: 5px;
		float: left;
		width: 62%;
		border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
font-size: 16px;
font-weight: bold;
border: solid 1px gray;
padding: 5px;

	}
	.div_cliente2{
		
		float: right;
		width: 33%;
		border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
font-size: 16px;
font-weight: bold;
border: solid 1px gray;
padding: 5px;

	}
	.div_observacion{
		margin-top: 5px;
		float: left;
		width: 78%;
		border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
font-size: 16px;
border: solid 1px gray;
padding: 5px;

	}
	.div_qr{
		
		float: right;
		width: 15%;
		border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
font-size: 16px;
font-weight: bold;
border: solid 1px gray;
padding: 5px;
text-align: center;

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
	.mb{
		margin-bottom: 5px;
	}
	.encabezado{
		width: 100%;
		border-collapse: collapse;

	}
	/*.celda{
		height: 20px;
		padding: 3px;
		border: solid 1px #BDC3C7;
		font-size: 11px;
		font-family: 'Ubuntu', sans-serif;
	}*/
	.margin-top{
		margin-top: 5px;
	}
	.text-small-5 {
		font-size: 10px;
	}
	.text-small-4 {
		font-size: 9px;
	}
	
	
	.celda-lados{
		height: 15px;
		font-size: 11px;
	}
	
	
	.ccenter-nobold{
		text-align: center;
	}
	.right-nobold{
		text-align: right;
		padding-right: 3px;
	}
	.w25p{
		width: 5cm;
	}
	.text-footer {
		font-style: italic;
		font-size: 11px;
	}
	.bg-detalle {
		background-color: #BDC3C7;
		color: #fff;
		font-size: 9px;
		height: 15px;
		/*border-radius: 10pt;*/
	}
	.border-top{
		border-top: 0.5px solid gray;
	}


</style>
<?php
	
	$dateemis =  new DateTime($pag->fecha) ;
	$femision= date($dateemis->format('d/m/Y'));
	$fvencido="";
	if ($pag->fvence!=""){
		$datevenc =  new DateTime($pag->fvence) ;
		$fvencido= date($datevenc->format('d/m/Y'));
	}
	$nrocorrel=str_pad($pag->numero, 6, "0", STR_PAD_LEFT);
?>
<?php if ($pag->estado=='ANULADO'): ?>
<watermarkimage src="<?php echo base_url().'resources/img/anulado.png' ?>" alpha="0.1" position="40,10"  size="D" />
<?php endif ?>
<div class="div_logo">
	<table>
		<tr>
			<td>
				<img class="logo-ies mb" src="<?php echo base_url().'resources/img/logo_facturacion.'.getDominio().'.png' ?>" alt="Logo de Facturación">
			</td>
			<td>
				<b class="text-small-5 ">IESTP CHARLES ASHBEE</b><br>
			<?php echo "
			<span class='text-small-5' >$dserie->direccion</span><br>
			<span class='text-small-5' >{$dserie->distrito}, {$dserie->provincia}, {$dserie->departamento}</span>";
	?></td>
		</tr>
	</table>
	
</div>
<div class="div_emisor">
	<span>
		RUC: <?php echo $dserie->ruc ?><br>
		<?php echo $pag->nomimpreso ?><br>
		<?php echo $pag->serie.'-'.$nrocorrel ?>
	</span>
</div>
<div class="div_cliente">
	<table class="text-small-4" cellpadding="0">
		<tr>
			<td colspan="2"><b>CLIENTE</b></td>
			
		</tr>
		<tr>
			<td><b><?php echo $pag->ptipodoc ?></b></td>
			<td>: <?php echo $pag->pnrodoc ?></td>
		</tr>
		<tr>
			<td><b>DENOMINACIÓN</b></td>
			<td>: <?php echo $pag->pagantenom ?></td>
		</tr>
		<tr>
			<td><b>DIRECCIÓN</b></td>
			<td>: <?php echo $pag->direccion ?></td>
		</tr>
		
		
	</table>
</div>
<div class="div_cliente2 ">
	<table class="text-small-4" cellpadding="0">
		
		<tr>
			
			<td width="120px"><b>FECHA EMISIÓN</b></td>
			<td>: <?php echo $femision ?></td>

		</tr>
		<tr>
			<td><b>FECHA DE VENC.</b></td>
			<td>: <?php echo $fvencido ?></td>
		</tr>
		
		<tr>
			<td><b>MONEDA</b></td>
			<td>: SOLES</td>
		</tr>
		<tr>
			<td colspan="2"><b> &nbsp;</b></td>
			
		</tr>
		
	</table>
</div>
<div class="div_detalle mb">
<table class="encabezado celda-lados" cellpadding="0" cellspacing="0" >
	<tr>
		<td class="ccenter-nobold bg-detalle" width="70px">
			<b>CÓDIGO</b>
		</td>
		<td class="ccenter-nobold bg-detalle" width="80px">
			<b>CANTIDAD</b>
		</td>
		<td class="ccenter-nobold bg-detalle" width="70px">
			<b>UNID.</b>
		</td>
		<td class="ccenter-nobold bg-detalle">
			<b>DESCRIPCIÓN</b>
		</td>
		<td class="ccenter-nobold bg-detalle" width="70px">
			<b>V.UNT</b>
		</td>
		<td class="ccenter-nobold right-nobold bg-detalle" width="70px">
			<b>V.VENTA</b>
		</td>
	</tr>
	<?php
	$total = 0;
	$itemd=0;
	foreach ($detalle as $key => $det) {
		$total +=$det->vunitario;
		$itemd++;
	?>
	<tr>
		<td class="celda-lados ccenter-nobold"><?php echo $det->gestid ?></td>
		<td class="celda-lados ccenter-nobold"><?php echo $det->cantidad.'.00' ?></td>
		<td class="celda-lados ccenter-nobold"><?php echo $det->undid ?></td>
		<td class="celda-lados"><?php echo $det->gestion ?></td>
		<td class="celda-lados right-nobold"><?php echo $det->vunitario ?></td>
		<td class="celda-lados right-nobold"><?php echo $det->valventa ?></td>
	</tr>
	<?php }	
	for ($i=$itemd; $i < 6; $i++) { ?>
		<tr>
		<td class="celda-lados ccenter-nobold"></td>
			<td class="celda-lados ccenter-nobold"></td>
			<td class="celda-lados ccenter-nobold"></td>
			<td class="celda-lados"></td>
			<td class="celda-lados right-nobold"></td>
			<td class="celda-lados right-nobold"></td>
		</tr>
	<?php } ?>
	

	<tr>
		<td cla colspan="3" class="border-top"></td>
		<td cla width="70%"  align="right" class=" border-top">GRAVADA</td>
		<td cla align="right" class="right-nobold border-top"><span class="">S/.</span></td>
		<td cla align="right" class="right-nobold border-top">
			<span class=""><?php echo number_format($pag->opgravadas, 2, '.', '');?></span>
		</td>
	</tr>
	<?php
		
	if ($pag->opinafec>0): ?>
	<tr>
		<td colspan="3"></td>
		<td  align="right" class="">INAFECTA</td>
		<td align="right" class="right-nobold"><span class="">S/.</span></td>
		<td align="right" class="right-nobold ">
			<span class=""><?php echo number_format($pag->opinafec, 2, '.', '');?></span>
		</td>
	</tr>
	<?php endif ?>
	<?php if ($pag->opexone>0): ?>
	<tr>
		<td colspan="3"></td>
		<td  align="right" class="">EXONERADA</td>
		<td align="right" class="right-nobold"><span class="">S/.</span></td>
		<td align="right" class="right-nobold ">
			<span class=""><?php echo number_format($pag->opexone, 2, '.', '');?></span>
		</td>
	</tr>
	<?php endif ?>
	<?php if ($pag->opexport>0): ?>
	<tr>
		<td colspan="3"></td>
		<td  align="right" class="">EXPORTACIÓN</td>
		<td align="right" class="right-nobold"><span class="">S/.</span></td>
		<td align="right" class="right-nobold ">
			<span class=""><?php echo number_format($pag->opexport, 2, '.', '');?></span>
		</td>
	</tr>
	<?php endif ?>
	<?php if ($pag->opgratis>0): ?>
	<tr>
		<td colspan="3"></td>
		<td  align="right" class="">GRATUITAS</td>
		<td align="right" class="right-nobold"><span class="">S/.</span></td>
		<td align="right" class="right-nobold ">
			<span class=""><?php echo number_format($pag->opgratis, 2, '.', '');?></span>
		</td>
	</tr>
	<?php endif ?>
	
	<tr>
		<td colspan="3"></td>
		<td align="right" class="border-bottom ">ICBPER</td>
		<td class="border-bottom right-nobold"><span class="">S/.</span></td>
		<td class="border-bottom right-nobold ">
			<span class=""><?php echo number_format($pag->micbper, 2, '.', '');?></span>
		</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td align="right" class="border-bottom ">IGV</td>
		<td class="border-bottom right-nobold"><span class="">S/.</span></td>
		<td class="border-bottom right-nobold ">
			<span class=""><?php echo number_format($pag->migv, 2, '.', '');?></span>
		</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td align="right" class="border-bottom ">TOTAL</td>
		<td class="border-bottom right-nobold"><span class="">S/.</span></td>
		<td class="border-bottom right-nobold ">
			<span class=""><?php echo number_format($pag->total, 2, '.', '');?></span>
		</td>
	</tr>
	
</table>
</div>

<div class="div_observacion">
	<span class="text-small-5"><?php echo $pag->observacion ?></span><br>
	<span class="text-small-5"><b>MONTO EN LETRAS: </b>
			<?php 
			$ndecimal=$pag->total - intval($pag->total);
			$tdecimal=explode('.', number_format($ndecimal, 2))[1];
			
			echo strtoupper($mtexto)." CON ".$tdecimal."/100 SOLES"; 
			?></span><br>
	<span class="text-small-4"><?php echo "Representación impresa de la {$pag->nomimpreso}, para ver el documento visita <b>https://merakitd.pse.pe/{$dserie->ruc}</b>";?><br>
				Emitido mediante un <b>PROVEEDOR Autorizado por la SUNAT</b> mediante Resolución de Intendencia No.<b>034-005-0005315</b> <br>
		<span class="text-small-5">Soportado por MERAKI TD</span>
	</span>
</div>
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
<div class="div_qr">
	<barcode code="<?php echo $contenidoqr ?>" type="QR" size="1" error="M" disableborder="1" />
</div>

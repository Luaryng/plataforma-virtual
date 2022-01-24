<style>
	@page {
		margin-top: 1.0cm;
		margin-bottom: 1.5cm;
		margin-left: 1.5cm;
		margin-right: 1.5cm;
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
</style>

<table class="encabezado">

	<tr>
		<td width="15%">
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h110.'.getDominio().'.png' ?>" alt="charlesashbee">
		</td>
		
		<td class="ccenter-nobold" width="50%">
			<b class="firmas"><?php echo $ies->denoml ?></b><br>
			<b class="firmas" ><?php echo $ies->direccion ?></b><br>
			<b class="firmas" ><?php echo $ies->distrito.' - '.$ies->provincia ?></b>
		</td>
		<td valign="bottom"><b></b></td>
		<td width="200px">
			<table class="celda ccenter-nobold" width="100%">
				<tr>
					<td>RUC: <?php echo $dserie->ruc ?></td>
				</tr>
				<tr>
					<td><?php echo $pag->nomimpreso ?></td>
				</tr>
				<tr>
					<td><?php echo $pag->serie.' - 0000'.$pag->numero ?></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<br><br>
<table class="encabezado celda">
	<tr>
		<td>Pagante : </td>
		<td><?php echo $pag->nompagante ?></td>
		<td>Fecha emisión : </td>
		<td><?php echo date("d/m/Y h:i a", strtotime($pag->fecha)) ?></td>
		<td>Moneda : </td>
		<td>SOLES</td>
	</tr>
	<tr>
		<td>Programa : </td>
		<td><?php echo $pag->carrera ?></td>
		<td>RUC - DNI : </td>
		<td><?php echo $pag->pnrodoc ?></td>
		<td> Observaciones : </td>
		<td>CAJA</td>
	</tr>
	<tr>
		<td>Modalidad : </td>
		<td>CONTADO</td>
		<td>Código : </td>
		<td><?php echo $pag->pagante ?></td>
		
	</tr>
	<tr>
		<td>Fecha pago : </td>
		<td><?php echo date("d/m/Y h:i a", strtotime($pag->fecha)) ?></td>
	</tr>
</table>
<br>
<table class="encabezado celda">
	<tr>
		<td class="celda" width="80px">
			CANTIDAD
		</td>
		<td class="celda" width="100px">
			CÓDIGO
		</td>
		<td class="celda">
			CONCEPTO
		</td>
		<td class="celda right-nobold" width="100px">
			MONTO
		</td>
	</tr>
	<?php
	$total = 0;
		foreach ($detalle as $key => $det) {
			$total +=$det->monto;
	?>
		<tr>
			<td class="celda-lados"><?php echo $det->cantidad.'.00' ?></td>
			<td class="celda-lados"><?php echo $det->gestionid ?></td>
			<td class="celda-lados"><?php echo $det->nombregest ?></td>
			<td class="celda-lados right-nobold"><?php echo $det->monto ?></td>
		</tr>
	<?php
		}
	?>
	
	<tr>
		<td colspan="3" class="celda"></td>
		<td class="celda"></td>
	</tr>
</table>
<br>
<table class="encabezado">
	<tr>
		<td></td>
		<td class="celda right-nobold" width="100px">IGV - 18.00%</td>
		<td class="celda right-nobold" width="100px">Importe Total</td>
	</tr>
	<tr>
		<td></td>
		<td class="celda right-nobold" width="100px">
			S/. <b class="right-nobold">0.00</b>
		</td>
		<td class="celda right-nobold" width="100px">
			S/. <b class="right-nobold"><?php echo number_format($pag->total, 2, '.', '');?></b>
		</td>
	</tr>
</table>
<br>
<table class="encabezado text-footer">
	<tr>
		<td>Autorizado mediante resolución N°</td>
	</tr>
	<tr>
		<td>Presentación impresa de la <?php echo $pag->nomimpreso ?></td>
	</tr>
	<tr>
		<td>Para Consultar ingrese a: www---------</td>
	</tr>
</table>
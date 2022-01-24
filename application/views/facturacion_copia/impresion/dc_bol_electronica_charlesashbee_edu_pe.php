<style>
	@import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@1,500&display=swap');
	@page {
		margin-top: 0.7cm;
		margin-bottom: 1.5cm;
		margin-left: 1.5cm;
		margin-right: 1.5cm;
		font-family: 'Ubuntu', sans-serif;
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
		border: solid 1px #BDC3C7;
		font-size: 11px;
		font-family: 'Ubuntu', sans-serif;
	}
	.celda-border {
		height: 20px;
		padding: 5px;
		border: solid 1px black;
		font-size: 11px;
    	border-radius: 8mm / 8mm;
	}
	
	.celda-lados{
		height: 20px;
		padding: 5px;
		border-left: solid 1px #BDC3C7;
		border-right: solid 1px #BDC3C7;
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

	.bg-detalle {
		background-color: #BDC3C7;
		color: #fff;
		font-size: 11px;
		/*border-radius: 10pt;*/
	}

	.bg-total {
		background-color: #17a2b8;
		color: #fff;
		font-size: 11px;
	}

	.separate {
		border-collapse: separate;
        border-spacing: 5;
	}

	.separate-5 {
		border-collapse: separate;
        border-spacing: 5;
	}

	.round_table {                   
        border-collapse: separate;
        border-spacing: 10;
        padding: 2px;
        border-radius: 15pt;
        -moz-border-radius: 20pt;
        -webkit-border-radius: 5pt;
        font-family: 'Ubuntu', sans-serif;
    	font-size: 9pt; 
    }

    .border-subtot {
    	border-collapse: separate;
        border-spacing: 5;
        border: 1px solid #BDC3C7;
        padding: 2px;
        border-radius: 15pt;
        -moz-border-radius: 20pt;
        -webkit-border-radius: 5pt;
        font-family: 'Ubuntu', sans-serif;
    	font-size: 9pt;
    }

    .color-totalbr {
    	border-collapse: separate;
        border-spacing: 5;
        border: 1px solid #17a2b8;
        padding: 2px;
        border-radius: 15pt;
        -moz-border-radius: 20pt;
        -webkit-border-radius: 5pt;
        font-family: 'Ubuntu', sans-serif;
    	font-size: 9pt;
    	
    }

</style>
<?php
	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); 
	$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
	$dateemis =  new DateTime($pag->fecha) ;
	$datevenc =  new DateTime($pag->fvence) ;
	$femision= $dias[$dateemis->format('w')].". ".date($dateemis->format('d'))." ".$meses[$dateemis->format('n')]. ", ".date($dateemis->format('Y'));
	$fvencimiento= $dias[$datevenc->format('w')].". ".date($datevenc->format('d'))." ".$meses[$datevenc->format('n')]. ", ".date($datevenc->format('Y'));
	$nrocorrel=str_pad($pag->numero, 8, "0", STR_PAD_LEFT);
?>
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
					<td><?php echo $pag->serie.' - '.$nrocorrel ?></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<br><br>
<table class="celda encabezado separate-5">
	<tr>
		<td><b>Cliente:</b></td>
		<td><?php echo $pag->pagantenom ?></td>
		<td><b>Moneda:</b></td>
		<td>SOLES</td>
		<td><b>IGV:</b></td>
		<td><?php echo number_format($dserie->igvpr, 2, '.', '') ?>%</td>
	</tr>
	<tr>
		<td><b><?php echo $pag->ptipodoc ?>: </b></td>
		<td><?php echo $pag->pnrodoc ?></td>
	</tr>
	<tr>
		<td><b>Dirección : </b></td>
		<td><?php echo $pag->direccion ?></td>
	</tr>
	<tr>
		<td><b>Ciudad : </b></td>
		<td><?php echo $pag->distrito.' - '.$pag->provincia.' - '.$pag->departamento ?></td>
	</tr>
						
</table><br>

<table class="encabezado celda">
	<tr>
		<td class="celda ccenter-nobold"><b>Fecha de Emisión:</b><br><?php echo $femision ?></td>
		<td class="celda ccenter-nobold"><b>Fecha de Vencimiento:</b><br><?php echo $fvencimiento ?></td>
	</tr>
</table>

<br>
<table class="encabezado celda">
	<tr>
		<td class="celda ccenter-nobold bg-detalle" width="70px">
			<b>CÓDIGO</b>
		</td>
		<td class="celda ccenter-nobold bg-detalle" width="80px">
			<b>CANTIDAD</b>
		</td>
		<td class="celda ccenter-nobold bg-detalle" width="70px">
			<b>UNID.</b>
		</td>
		<td class="celda ccenter-nobold bg-detalle">
			<b>DESCRIPCIÓN</b>
		</td>
		<td class="celda ccenter-nobold bg-detalle" width="70px">
			<b>V.UNT</b>
		</td>
		<td class="celda ccenter-nobold right-nobold bg-detalle" width="7px">
			<b>V.VENTA</b>
		</td>
	</tr>
	<?php
	$total = 0;
		foreach ($detalle as $key => $det) {
			$total +=$det->vunitario;
	?>
		<tr>
			<td class="celda-lados ccenter-nobold"><?php echo $det->gestid ?></td>
			<td class="celda-lados ccenter-nobold"><?php echo $det->cantidad.'.00' ?></td>
			<td class="celda-lados ccenter-nobold"><?php echo $det->undid ?></td>
			<td class="celda-lados"><?php echo $det->gestion ?></td>
			<td class="celda-lados right-nobold"><?php echo $det->vunitario ?></td>
			<td class="celda-lados right-nobold"><?php echo $det->valventa ?></td>
		</tr>
	<?php
		}
	?>
	
</table>
<br>
<table class="encabezado separate">
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">OP. GRAVADAS</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->opgravadas, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">OP. INAFECTA</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->opinafec, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">OP. EXONERADA</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->opexone, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">OP. EXPORTACIÓN</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->opexport, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">TOTAL OP. GRATUITAS</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->opgratis, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">DSCTOS TOTALES</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->desctotales, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">SUB TOTAL</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->subtotal, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">ICBPER</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->micbper, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">ISC</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->misc, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-detalle round_table ccenter-nobold" width="150px">IGV</td>
		<td class="right-nobold border-subtot" width="100px">S/. <?php echo number_format($pag->igv, 2, '.', '') ?></td>
	</tr>
	<tr>
		<td></td>
		<td class="right-nobold bg-total round_table ccenter-nobold" width="150px">TOTAL</td>
		<td class="right-nobold color-totalbr" width="100px">S/. <?php echo number_format($pag->total, 2, '.', '') ?></td>
	</tr>

</table>



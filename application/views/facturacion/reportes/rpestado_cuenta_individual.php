<style>
	@import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@1,500&display=swap');
	@page {
		margin: 0;
		
	}
	.div_logo{
		float: left;
	
		border:0;
		width: 70%;
	}
	.logo-ies{
		height:  40px;
	}
	.div_datedoc {
		padding: 5px;
		float: right;
		width: 20%;
		font-size: 16px;
		font-weight: bold;
		/*text-align: right;*/
		border: solid 1px gray;
		border: none;
		-moz-border: none;
		-webkit-border: none;
	}

	.div_titledoc {
		margin-top: 5px;
		float: left;
		width: 100%;
		text-align: center;
	}

	.div_fechareport {
		
		margin-top: -7px;
		float: left;
		width: 100%;
		text-align: center;
	}

	.div_emisor{
		padding: 5px;
		float: right;
		width: 30%;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		font-size: 16px;
		font-weight: bold;
		text-align: center;
		border: solid 1px gray;

	}
	.div_filial{
		margin-top: 0px;
		float: left;
		width: 62%;
		border: 0px;
		-moz-border: 0px;
		-webkit-border: 0px;
		font-size: 16px;
		font-weight: bold;
		padding: 5px;

	}

	.div_detalle{
		
		margin-top: -15px;
		width: 100%;
		font-size: 10px;

	}

	.div_detalle_header {
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border: solid 1px gray;
	}

	.mb{
		margin-bottom: 5px;
	}
	.encabezado{
		width: 100%;
		border-collapse: collapse;

	}
	
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
	
	.cleft-nobold {
		text-align: left;
		padding-left: 20px;
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
		font-size: 11px;
		height: 25px;
		/*border-radius: 10pt;*/
	}
	.border-top{
		border-top: 0.5px solid gray;
	}

	.border-bottom {
		/*border-top: #000 1px dotted;*/
		border-bottom: #000 2px dotted;
		padding: 2px 0;
	}

	.margin-top {
		margin-top: 1px;
	}

	.padding {
		padding: 5px 0;
	}
	.text-danger{
		color:red;
	}

	.div_grupo {
		padding: 10px 0;
	}

	.divider {
		color: #000;
		margin-top: 0px;
	}


</style>
<?php
	$fechahoy = date("d/m/Y");
	$horahoy = date("h:i:s a");

	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$txtsemestres = implode(" / ", $semestres);

	$datefl =  new DateTime($inicia);
	$dateflf =  new DateTime($culmina);
       $dateini = $datefl->format('d/m/Y');
       $datefin = $dateflf->format('d/m/Y');
?>
<div class="div_logo">
	<img class="logo-ies mb" src="<?php echo base_url().'resources/img/logo_facturacion.'.getDominio().'.png' ?>" alt="Logo de Facturación"><br>
</div>

<div class="div_datedoc">
	<table width="100%" class="text-small-4" cellpadding="0" >
		<tr>
			<td><b>Fecha </b></td>
			<td><b>:</b></td>
			<td align="right"><?php echo $fechahoy ?></td>
		</tr>
		<tr>
			<td><b>Hora </b></td>
			<td><b>:</b></td>
			<td align="right"><?php echo $horahoy ?></td>
		</tr>
	</table>
</div>

<div class="div_titledoc">
	<h5>ESTADO DE CUENTA</h5>
</div>


<div class="div_detalle mb">
<table class="encabezado celda-lados" cellpadding="0" cellspacing="0" >
	<?php
		echo "<tr>
    			<td class='div_grupo' colspan='7'><b>ESTUDIANTE : </b>".$docpagos['estud']->carnet." - ".$docpagos['estud']->nombres."</td>
    		</tr>
    		<tr>
    			<td class='' colspan='7'><b>PROGRAMA : </b>".$docpagos['estud']->carrera ."</td>
    		</tr>";
    	?>
</table>
</div>

<div class="div_detalle mb">
<table class="encabezado celda-lados" cellpadding="0" cellspacing="0" >
	<?php
		
    		if (count($docpagos['items']) > 0) {
    			echo "<tr>
	    			<td class='div_grupo' colspan='7'>
	    				<b>PAGOS REALIZADOS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    				<small>DEL $dateini AL $datefin</small><b><hr class='divider'>
	    			</td>
	    			</tr>
	    			<div class='div_detalle div_detalle_header'>
					<tr>
						<td class='ccenter-nobold bg-detalle' width='50px'>
							<b>N°</b>
						</td>
						<td class='ccenter-nobold bg-detalle' width='100px'>
							<b>DOCPAGO</b>
						</td>
						<td colspan='2' class='ccenter-nobold bg-detalle'>
							<b>FECHA/HORA</b>
						</td>
						<td  class='ccenter-nobold bg-detalle' >
							<b>CONCEPTO</b>
						</td>
						<td  class='ccenter-nobold bg-detalle' >
							<b>MONTO</b>
						</td>
						<td class='ccenter-nobold bg-detalle' >
							<b>TOTAL</b>
						</td>
					</tr>
				</div>";
    		}

    		$nrop = 0;
		$grupo = "";
		foreach ($docpagos['items'] as $key => $pag) {
			$datemisp =  new DateTime($pag->fecha_hora);
            		$pago = $datemisp->format('d/m/Y h:s a');
			$pmonto=number_format($pag->p_unitario, 2);
            		$ptotal=number_format($pag->total, 2);
            
            		$nrop++;
			echo "<tr>
				<td class='border-bottom text-small-5 ccenter-nobold' width='50px'>$nrop</td>
				<td class='border-bottom text-small-5 ccenter-nobold' width='100px'>$pag->serie - $pag->numero</td>
				<td class='border-bottom text-small-5 ccenter-nobold' colspan='2'>$pago</td>
				<td class='border-bottom text-small-5 cleft-nobold' >$pag->gestion</td>
				<td class='border-bottom text-small-5 ccenter-nobold' >($pag->cantidad) $pmonto</td>
				<td class='border-bottom text-small-5 ccenter-nobold' >$ptotal</td>
			</tr>";
		}
    	?>
</table>
</div>

<div class="div_detalle mb">
<table class="encabezado celda-lados" cellpadding="0" cellspacing="0" >
	<?php
		
    		if (count($docpagos['deudas']) > 0) {
    			echo "<tr>
	    			<td class='div_grupo' colspan='7'>
	    				<b>DEUDAS ASIGNADAS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    				<small>$txtsemestres</small><b><hr class='divider'>
	    			</td>
	    			</tr>
	    			<div class='div_detalle div_detalle_header'>
					<tr>
						<td class='ccenter-nobold bg-detalle' width='50px'>
							<b>N°</b>
						</td>
						<td class='ccenter-nobold bg-detalle' width='100px'>
							<b>PER./SEM.</b>
						</td>
						<td colspan='2' class='ccenter-nobold bg-detalle'>
							<b>CONCEPTO</b>
						</td>
						<td  class='ccenter-nobold bg-detalle' >
							<b>VENCE</b>
						</td>
						<td  class='ccenter-nobold bg-detalle' >
							<b>MONTO</b>
						</td>
						<td class='ccenter-nobold bg-detalle' >
							<b>SALDO</b>
						</td>
					</tr>
				</div>";	
    		}

		$nro = 0;
		$grupo = "";
		foreach ($docpagos['deudas'] as $key => $doc) {
			
			$datemis =  new DateTime($doc->fvence);
            		$vence = $datemis->format('d/m/Y');
			$vmonto=number_format($doc->monto, 2);
            		$vsaldo=number_format($doc->saldo, 2);
            
            		$nro++;
			echo "<tr>
				<td class='border-bottom text-small-5 ccenter-nobold' width='50px'>$nro</td>
				<td class='border-bottom text-small-5 ccenter-nobold' width='100px'>$doc->codperiodo / $doc->ciclo</td>
				<td class='border-bottom text-small-5 ccenter-nobold' colspan='2'>$doc->gestion</td>
				<td class='border-bottom text-small-5 ccenter-nobold' >$vence</td>
				<td class='border-bottom text-small-5 ccenter-nobold' >$vmonto</td>
				<td class='border-bottom text-small-5 ccenter-nobold' >$vsaldo</td>
			</tr>";
		}
	?>
	
	
</table>
</div>

<!-- <pagebreak>  -->


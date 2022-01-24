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
		margin-top: -10px;
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
		margin-top: 5px;
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
		
		margin-top: 5px;
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


</style>
<?php
	$fechahoy = date("d/m/Y");
	$horahoy = date("h:i:s a");
	
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
	<h5>COMPROBANTE DE VENTA EMITIDOS</h5>
</div>

<div class="div_fechareport">
	<span class="text-small-5"><?php echo "del ".date_format(date_create($emision),"d/m/Y")."   al ".date_format(date_create($emisionf),"d/m/Y"); ?></span>
</div>

<div class="div_filial">
	<table class="text-small-5" cellpadding="0">
		<tr>
			<td colspan="2"><b>FILIAL</b></td>
			<td>: <?php echo $_SESSION['userActivo']->sede ?></td>
		</tr>			
		
	</table>
</div>

<div class="div_detalle div_detalle_header">
<table class="encabezado celda-lados" cellpadding="0" cellspacing="0" >
	<tr>
		<td class="ccenter-nobold bg-detalle" width="50px">
			<b>N°</b>
		</td>
		<td class="ccenter-nobold bg-detalle" width="80px">
			<b>COMPROB</b>
		</td>
		<td class="ccenter-nobold bg-detalle" width="40px">
			<b>EST</b>
		</td>
		<td colspan="2" class="cleft-nobold bg-detalle" width="200px">
			<b>CLIENTE</b>
		</td>
		<td class="cleft-nobold bg-detalle" width="70px">EMISIÓN</td>
		<td class="ccenter-nobold bg-detalle" width="150px">CONCEPTO</td>
		<td class="cleft-nobold bg-detalle">MONTO</td>
		<td class="cleft-nobold bg-detalle" width="150px">PROGRAMA</td>
		
		<td class="ccenter-nobold bg-detalle" width="70px">
			<b>PERIODO</b>
		</td>
		<td class="ccenter-nobold right-nobold bg-detalle" width="70px">
			<b>CICLO</b>
		</td>
	</tr>
</table>
</div>
<div class="div_detalle mb margin-top">
<table class="encabezado celda-lados" cellpadding="0" cellspacing="0" >
	<?php
		$nro=0;
		$itemd=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;

        foreach ($docpagos as $mat) {
        	$nro++;
        	$itemd++;
        	$vestado="";
        	if ($mat->estado=="ANULADO"){
				$mat->total=0;
           		$mat->efectivo=0;
            	$mat->banco=0;
            	$vestado="AN";
			}
	?>
	<tr>
		<td class="border-bottom text-small-5 ccenter-nobold" width="50px"><?php echo $nro ?></td>
		<td class="border-bottom text-small-5 ccenter-nobold" width="80px"><?php echo $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT) ?></td>
		<td class="border-bottom text-small-5 ccenter-nobold" width="40px"><?php echo $vestado ?></td>
		<td width="65px" class="border-bottom text-small-5 cleft-nobold"><?php echo $mat->pagantenrodoc ?></td>
		<td class="border-bottom text-small-5 cleft-nobold" width="200px"><?php echo $mat->pagante ?></td>
		<td class="border-bottom text-small-5 ccenter-nobold" width="70px"><?php echo date_format(date_create($mat->fecha_hora),"d/m/Y") ?></td>
		<td class="border-bottom text-small-5 ccenter-nobold" width="150px"><?php echo $mat->gestion ?></td>
		<td class="border-bottom text-small-5 cleft-nobold"><?php echo number_format ($mat->punit,2) ?></td>
		<td class="border-bottom text-small-5 cleft-nobold" align="right" width="150px"><?php echo $mat->carrera ?></td>
		<td class="border-bottom text-small-5 right-nobold" width="70px"><?php echo $mat->periodo ?></td>
		<td class="border-bottom text-small-5 right-nobold" align="center" width="70px"><?php echo $mat->ciclo ?></td>
	</tr>
	<?php 
			$mtotal=$mtotal +  $mat->punit;
   //          $mefectivo=$mefectivo + $mat->efectivo;
   //          $mbanco=$mbanco + $mat->banco;
		}	
	?>
	
</table>
</div>

<div class="div_detalle div_detalle_header mb padding">
	<table class="encabezado celda-lados" cellpadding="0" cellspacing="0">
		<tr>
			<td cla colspan="2"></td>
			<td cla width="70%"  align="right">Total Emitido</td>
			<td cla align="right" class="right-nobold"><span class="">S/.</span></td>
			<td cla align="right" class="right-nobold">
				<span class=""><?php echo number_format($mtotal, 2, '.', '');?></span>
			</td>
		</tr>
	</table>
</div>


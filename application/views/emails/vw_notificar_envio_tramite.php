<div style="background-color: white; padding: 15px;">
	<br>
	<table>
		<tr>
			<td width="82px">
				<img src="<?php echo base_url().'resources/img/logo_h80.'.getDominio().'.png' ?>" alt="LOGO">
			</td>
			<td><h2 style="margin: 0px;"><?php echo $ies->nombre ?></h2>Plataforma Virtual</td>
		</tr>
	</table>
	
	
	<hr>
	<br>
	<div style="padding: 20px 10px; margin-bottom:10px; background-color: #ededed;
		border-radius: 10px 10px 10px 10px;
		-moz-border-radius: 10px 10px 10px 10px;
		-webkit-border-radius: 10px 10px 10px 10px;
		border: 0px solid #000000;">
		<div style="margin-bottom: 5px;">
			<?php echo "$mensaje<br><br>
			Código de Seguimiento:
			<h3>$tmt->codseg</h3>
			<br>
			Para verificar el estado del mismo puede visitar nuestra página web.<br>
			<a href='".base_url()."tramites/consultar/expediente'>Consultar Estado</a>.
			";?>
		</div>
		
	</div>
	
	Gracias. <br>
	Atte. Equipo de Plataforma Virtual <br><br>
	<hr>
	
	Usted está recibiendo este mensaje para informar eventos y/o cambios en su cuenta <br></small>
	<b style="text-align: center;"><?php echo $respuesta ?></b>
	
	<br>
	
</div>
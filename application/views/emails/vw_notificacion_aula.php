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

	<?php 
	$correo="";
	foreach ($mensajes->notificaciones as $key => $msj): ?>
		<div style="padding: 20px 10px; margin-bottom:10px; background-color: #ededed;
				 border-radius: 10px 10px 10px 10px;
			-moz-border-radius: 10px 10px 10px 10px;
			-webkit-border-radius: 10px 10px 10px 10px;
			border: 0px solid #000000;">
			<div style="margin-bottom: 5px;">
				<?php echo $msj->detalle;?>
			</div> <br>
			<a href="<?php echo $msj->link.'/'.base64url_encode($msj->codmiembro) ?>" style="color:white; border-collapse:collapse;border-radius:2px;text-align:center;text-decoration: none; border:solid 1px #344c80;background:#4c649b;padding:7px 16px 11px 16px"><b>Ir a la Plataforma</b></a>	
		</div>
	<?php endforeach ?>
	
	
	
	Gracias. <br>
	Atte. Equipo de Soporte Virtual <br><br>
	<hr>
	<small>Este mensaje se envió de manera automática a <b><?php echo $mensajes->ecorporativo ?></b> por favor no responder <br>
	Usted está recibiendo este mensaje por para informar cambios en tu cuenta <br></small>
	
</div>
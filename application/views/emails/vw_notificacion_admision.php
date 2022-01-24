<?php
	$vbaseurl = base_url();
?>
<style type="text/css">
	.circle-icon {
		width: 250px;
     	height: 250px;
     	-moz-border-radius: 50%;
     	-webkit-border-radius: 50%;
     	border-radius: 50%;
     	background: #17a2b8;
     	padding: 5px 8px;
     	color: #fff;
	}

</style>
<div class="content-wrapper">
<div style="background-color: white; padding: 15px;width: 100%;padding-right: 7.5px;padding-left: 7.5px;margin-right: auto;margin-left: auto;">
	<br>
	<table width="100%" border="0">
		<tr>
			<td width="50%" style="padding: 10px;">
				<img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png' ?>" alt="LOGO" style="width: 100%;">
			</td>
			<td width="50%">
				<h2 style="margin: 0px;"><?php echo $ies->nombre ?></h2>Plataforma Virtual
			</td>
		</tr>
	</table>

	<hr>
	<br>
	<table width="100%" border="0">
		<tr width="100%">
			<td colspan="2" style="text-align: center;background: #f8f9fa;padding: 10px;">
				<h2><img src="<?php echo $vbaseurl.'resources/img/icons/check_green_icon.png' ?>" alt="check" style="width: 50px;"><br>Felicitaciones tu Inscripción ha sido aprobada</h2>
			</td>
		</tr>
		<tr width="100%">
			<td colspan="2" style="text-align: center;padding: 10px;">
				<h5>Sus credenciales para acceder a la plataforma son:</h5>
			</td>
		</tr>
		<tr width="100%">
			<td colspan="2">
				<img src="<?php echo $vbaseurl.'resources/img/icons/icon_email.png' ?>" alt="email" style="width: 28px;"> <b>Correo: <?php echo $emailus ?></b>
			</td>
		</tr>
		<tr width="100%">
			<td colspan="2">
				<img src="<?php echo $vbaseurl.'resources/img/icons/lock_icon.png' ?>" alt="email" style="width: 30px;"> <b>Contraseña: <?php echo $password ?></b>
			</td>
		</tr>
		<tr width="100%">
			<td colspan="2" style="text-align: left;padding: 10px;">
				<span>Recuerde que la contraseña es en mayúsculas</span><br>
				<span>Para acceder a la plataforma debe ingresar a: <a href="<?php echo $vbaseurl ?>"><?php echo $vbaseurl ?></a></span>
			</td>
		</tr>
		<tr width="100%">
			<td colspan="2" style="text-align: left;padding: 10px;">
				<span>Te adjuntamos el video y el manual de usuario</span><br>
				<ul>
					<li>
						<a href="https://www.youtube.com/watch?v=9jp_duWP9Gs">Video de como acceder a su plataforma virtual</a>
					</li>
					<li>
						<a href="https://youtu.be/qpkUUZGLjsI">Uso de plataforma virtual</a>
					</li>
					<li>
						<a href="https://drive.google.com/file/d/1TXS2NLVUu6tJUW9GQMqSlbMnNw8EghvV/view?usp=sharing">Manual de usuario plataforma</a>
					</li>
					<li>
						<a href="https://drive.google.com/file/d/1WV1CjDo0xrWx7PWIc2iWrYkktfUqNn08/view?usp=sharing">Manual uso de correo institucional</a>
					</li>
				</ul>
				<span>Para más información o duda que presente al ingresar a la plataforma virtual comunicarse al:</span><br>
				<ul>
					<li><b>Celular / Whatsapp :</b> 983136078</li>
					<li><b>Correo soporte :</b> soporte@iesap.edu.pe</li>
					<li><b>Horario de atención soporte:</b> Lunes a viernes de 08:00 am - 08:00 pm / Sábado de 08:00 am - 02:00 pm</li>
				</ul>
			</td>
		</tr>
	</table>
	<br>
	Gracias. <br>
	Atte. Equipo de Soporte Virtual <br>
	<b>Celular :</b> 983136078<br>
	<hr>
	<small>Este mensaje se envió de manera automática a <b><?php echo $emailper ?></b> por favor no responder <br>
	Usted está recibiendo este mensaje para informar cambios en tu cuenta <br></small>
</div>
</div>
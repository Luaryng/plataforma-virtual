<!--$fechas
$asistencias
$sesiones
$evaluaciones
$notas
$miembros
$curso-->
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
		height:  100px;
	}
	.celda{
		height: 20px;
		padding: 5px;
		border: solid 1px black;
		font-size: 12px;
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
		background-color: #E9E4E4;
	}
	.ccenter{
		text-align: center;
		font-weight: bold;
	}
	.ccenter-nobold{
		text-align: center;
	}
	.w25p{
		width: 5cm;
	}

	.text-small-9 {
		font-size: 9px;
	}
</style>

<table class="encabezado">
	<tr>
		<td>
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h110.'.getDominio().'.png' ?>" alt="iestcanchaque">
		</td>
		<td valign="bottom" class="ccenter-nobold">
			<img class="logo-minedu" src="<?php echo base_url().'resources/img/minedu_logo.png' ?>" alt="minedu"><br><br>
			<b>FICHA DE INSCRIPCIÓN DEL POSTULANTE</b>
		</td>
		<!-- <td>
			<img class="logo-minedu" src="<?php echo base_url().'resources/img/minedu_logo.png' ?>" alt="minedu">
		</td> -->
		<td class="celda" width="100px">
			
		</td>
		
	</tr>
</table>
<br>
<table class="encabezado">
	<tr>
		<td class="celda cgris">
			<b><span>AÑO</span></b>
		</td>
		<td class="celda">
			<b><span><?php echo $ins->anio ?></span></b>
		</td>
		<td align="right" style="width: 40%">
		</td>
		<td class="celda cgris">
			<b><span>CÓDIGO DE INSCRIPCIÓN</span></b>
		</td>
		<td class="celda">
			<b><span><?php echo $ins->carnet ?></span></b>
		</td>
	</tr>
</table>
<br>
<table class="encabezado">
	<tr>
		<td colspan="2" class="celda cgris w25p">
			<span>Nombre del IES/EIEST</span>
		</td>
		<td colspan="2" class="celda ccenter w25p">
			<span><?php echo $ies->nombre ?></span>
		</td>
		<td colspan="2" class="celda cgris w25p">
			<span>Código modular</span>
		</td>
		<td colspan="2" class="celda ccenter w25p">
			<span><?php echo $ies->codmodular ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Tipo gestión</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->gestion ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>DRE/GRE</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->dre ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda cgris">
			<span>Resolución de licenciamiento y/o autorización</span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ies->resolucion ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda cgris">
			<span>Resolución de renovación y/o revalidación</span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ies->revalidacion ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda cgris">
			<span>Lugar donde se presenta el servicio educativo:</span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ins->sedetipo ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Departamento:</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->departamento ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>DRE/GRE</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->dre ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Provincia:</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->provincia ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>Distrito: </span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->distrito ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Centro Poblado:</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->centropoblado ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>Telefono: </span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->telefono ?></span>
		</td>
	</tr>
	<tr>
		
		<td colspan="4" class="celda cgris ccenter-nobold">
			<span>Correo Electrónico:</span>
		</td>
		<td colspan="4" class="celda cgris ccenter-nobold">
			<span>Página Web</span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ies->email ?></span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ies->web ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda cgris">
			<span>Programa de estudio o carrera: </span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ins->carrera ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda cgris">
			<span>Nivel formativo: </span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ins->nivelformativo ?></span>
		</td>
		
	</tr>
</table>
<br>
<table class="encabezado">
	<tr>
		<td colspan="8" class="celda cgris ccenter">
			<span>DATOS DEL POSTULANTE</span>
		</td>

	</tr>
	<tr>
		<td colspan="2" class="celda cgris ccenter">
			<span>APELIDO PATERNO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>APELIDO MATERNO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>NOMBRES</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>SEXO</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->paterno ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->materno ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->nombres ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->sexo ?></span>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="celda cgris ccenter">
			<span>FECHA DE NACIMIENTO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>DOCUMENTO DE IDENTIDAD</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>EDAD</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>LUGAR DE NACIMIENTO</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda ccenter-nobold">
			<span>
				<?php 
				$tiempo = strtotime($ins->fecnac); 
				echo date("d | m  | Y", $tiempo); ?>
					
				</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->tipodoc." - ".$ins->nrodoc ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span>
				<?php 
				    $ahora = time(); 
				    $edad = ($ahora-$tiempo)/(60*60*24*365.25); 
				    $edad = floor($edad); 
				    echo $edad;
				 ?>
			</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->lugarnac ?></span>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="celda cgris ccenter">
			<span>PAIS</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>DISTRITO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>PROVINCIA</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>REGIÓN</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->pais ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->distrito ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->provincia ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->departamento ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="6" class="celda cgris ccenter">
			<span>DOMICILIO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter">
			<span>TRABAJA</span>
		</td>

	</tr>
	<tr>
		<td colspan="6" class="celda ccenter-nobold">
			<span><?php echo $ins->domicilio ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->trabaja ?></span>
		</td>
	</tr>

	<tr>
		
		<td colspan="2" class="celda cgris ccenter">
			<span>ESTADO CIVIL</span>
		</td>
		<td colspan="3" class="celda cgris ccenter">
			<span>TELEFONO</span>
		</td>
		<td colspan="3" class="celda cgris ccenter">
			<span>CORREO ELECTRÓNICO</span>
		</td>
	</tr>
	<tr>
		
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->estadocivil ?></span>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span>
			<?php

			 echo trim($ins->telefono." ".$ins->celular) ?></span>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span><?php echo $ins->email ?></span>
		</td>
	</tr>
	<tr>
		
		<td colspan="2" class="celda cgris ccenter">
			<span>COLEGIO 5° SEC.</span>
		</td>
		<td colspan="6" class="celda ccenter-nobold">
			<span><?php echo $ins->colegio5to ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>APELLIDOS Y NOMBRES PADRE</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold text-small-9">
			<span><?php echo $ins->padre ?></span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>APELLIDOS Y NOMBRES MADRE</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold text-small-9">
			<span><?php echo $ins->madre ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>OCUPACIÓN PADRE</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold text-small-9">
			<span><?php echo $ins->ocupapadre ?></span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>OCUPACIÓN MADRE</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold text-small-9">
			<span><?php echo $ins->ocupamadre ?></span>
		</td>
	</tr>
</table>
<br>
<br>
<table class="encabezado">
	<tr>
		<td class="texto" align="right">
			<?php 
			  $fecha=$ins->fecinsc;
			  $fecha = substr($fecha, 0, 10);
			  $numeroDia = date('d', strtotime($fecha));
			  $dia = date('l', strtotime($fecha));
			  $mes = date('F', strtotime($fecha));
			  $anio = date('Y', strtotime($fecha));
			  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
			  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
			  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
			  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
			  

			 ?>
			<?php echo $ies->distrito ?>, <?php echo $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio; ?>
		</td>
	</tr>
</table>
<br>
<br>
<br>
<br>
<table class="encabezado">
	<tr>
		<td class="firmas ccenter-nobold">
			____________________________________
		</td>
		<td class="firmas ccenter-nobold">
			____________________________________
		</td>
		<td class="firmas ccenter-nobold">
			____________________________________
		</td>
	</tr>
	<tr>
		<td class="firmas ccenter-nobold">
			Director general	<br>
			Sello, Firma, Posfirma
		</td>
		<td class="firmas ccenter-nobold">
			Secretario académico 	<br>
			Sello, Firma, Posfirma
		</td>
		<td class="firmas ccenter-nobold">
			Postulante 	<br>
			
		</td>
	</tr>
</table>
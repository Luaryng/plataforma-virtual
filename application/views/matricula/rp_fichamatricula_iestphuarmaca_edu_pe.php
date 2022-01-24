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
		margin-bottom: 8px;
	}
	.tabla-sm{
		width: 100%;
		border-collapse: collapse;
		margin-bottom: 0px;
	}
	.p-0{
		padding: 0px !important;
	}
	.logo-minedu{
		width: 200px;
		height: 60px;
	}
	.logo-ies{
		height: 70px;
	}
	.td-drep{
		background-color: #808080;
		padding-top: 8px;
		padding-bottom: 0px;
		color: white;
		width: 140px;
		height: 60px;
		font-size: 12px;
		font-weight: bold;
	}
	.td-iesname{
		background-color: #548DD4;
		padding-top: 8px;
		padding-bottom: 0px;
		color: white;
		width: 260px;
		height: 60px;
		font-size: 11px;
		font-weight: bold;
	}
	.celda{
		height: 20px;
		padding: 5px;
		border: solid 1px black;
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
	.{
		background-color: lightgray;
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
	.sello_matricula{		
		position: fixed;
	}
</style>
<watermarkimage src="<?php echo base_url().'resources/img/matriculado_iestphuarmaca_edu_pe.png' ?>" alpha="0.6" position="70,35"  size="D" />
<table class="tabla-sm" border="0">

	<tr>
		<td style="width: 200px" valign="top" align="right" class="p-0">
			<img class="logo-minedu" src="<?php echo base_url().'resources/img/minedu_logo_sb.png' ?>" alt="MINEDU">
		</td>
		<td valign="top" align="center" class="td-drep">
			<span>Dirección Regional <br>
				de Educaión <br>
			PIURA</span>
		</td>
		<td valign="top" align="center" class="td-iesname">
			<b>INSTITUTO DE EDUCACIÓN
				SUPERIOR TECNOLÓGICO PÚBLICO<br>"HUARMACA"
			</b>
		</td>
		<td rowspan="2" valign="top" align="center" class="p-0">
		
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_esp.iestphuarmaca.edu.pe.jpg' ?>" alt="IESTP">
		</td>
		
	</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td colspan="4" valign="top" align="center">
			<b>ESFUERZO, SACRIFICIO Y DECISIÓN</b>
		</td>
	</tr>
</table>
<table class="encabezado">
	<tr>
		<td class="td-rd">
			<u>R.E.R.N° 197-91-RGP;06/05/1991</u>
		</td>
		<td class="td-rd">
			<u>R.M.N° 0296-94-ED;07/04/1994</u>
		</td>
		<td class="td-rd">
			<u>R.D. ° 0525-2006-D;21/07/2006</u>
		</td>
	</tr>
	<tr>
		<td class="td-rd">
			<b>CREACIÓN</b>	
		</td>
		<td class="td-rd">
			<b>RECONOCIMIENTO</b>
		</td>
		<td class="td-rd">
			<b>REVALIDACIÓN</b>
		</td>
	</tr>
	<tr>
		<td colspan="3" valign="top" align="center">
			<hr style="margin-top: 2px">
			<h3><b>FICHA DE REGISTRO DE MATRICULA</b></h3>
		</td>
	</tr>
</table>

<br>
<table class="encabezado">
	<tr>
		<td class="celda ">
			<b><span>Nombre del IESTP</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->nombre ?></span>
		</td>
		<td class="celda ">
			<b><span>DRE</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->dre ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda ">
			<b><span>Código modular</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->codmodular ?></span>
		</td>
		<td class="celda ">
			<b><span>Tipo de Gestión</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->gestion ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda ">
			<b><span>Departamento</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->departamento ?></span>
		</td>
		<td class="celda ">
			<b><span>Provincia</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->provincia ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda ">
			<b><span>Distrito</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->distrito ?></span>
		</td>
		<td class="celda ">
			<b><span>Periodo lectivo</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->periodo ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda ">
			<b><span>Programa de estudios</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->carrera ?></span>
		</td>
		<td class="celda ">
			<b><span>Periodo académico</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->ciclo ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda ">
			<b><span>Plan del programa de estudios</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span></span>
		</td>
		<td class="celda ">
			<b><span>Nivel formativo</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->nivel ?></span>
		</td>
	</tr>

	<tr>
		<td class="celda ">
			<b><span>Tipo de plan de estudios</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span></span>
		</td>
		<td class="celda ">
			<b><span>Periodo de clases</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span></span>
		</td>
	</tr>
	<tr>
		<td class="celda ">
			<b><span>DNI N°</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->dni ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda ">
			<b><span>Apellidos y nombres</span></b>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span><b><?php echo $mat->paterno." ".$mat->materno." ".$mat->nombres ?></b></span>
		</td>
	</tr>
	
</table>
<br>

<table class="encabezado">

	<tr>
		<td  class="celda ccenter">
			<small>N°</small>
		</td>
		<td  class="celda ccenter">
			<small>UNIDADES DIDACTICAS</small>
		</td>
		
		<td  class="celda ccenter">
			<small>MÓDULO</small>
		</td>
		<td  class="celda ccenter">
			<small>HORAS</small>
		</td>
		<td  class="celda ccenter">
			<small>CRÉDITOS</small>
		</td>
		<td  class="celda ccenter">
			<small>CONDICIÓN</small>
		</td>
	</tr>
	<?php
	$nro=0;
	$isrepite=false;
	$vhoras=0;
	$vcre=0;
	foreach ($curs as $kc => $cur) {
		if ($cur->repite=='NO'){
		$nro++;
		# code...
		
	?>
	<tr>
		<td class="celda ccenter-nobold">
			<span><?php echo $nro ?></span>
		</td>
		<td class="celda">
			<span><?php echo $cur->curso ?></span>
		</td>
		
		<td class="celda ccenter-nobold">
			<span><?php echo $cur->nromodulo ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php 
			$vhoras= $vhoras + $cur->hts + $cur->hps;
			echo $cur->hts + $cur->hps; ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php 
			$vcre= $vcre + $cur->cp + $cur->ct;
			echo $cur->cp + $cur->ct; ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span></span>
		</td>
	</tr>
	<?php 
		unset($curs[$kc]);
		}
		else{
			$isrepite=true;
		}
	} ?>
	<tr>
		<td colspan="2"></td>
		<td class="celda ccenter">
			<span>TOTAL</span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $vhoras ?></span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $vcre ?></span>
		</td>
		<td class="celda ccenter">
			<span></span>
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<?php if ($isrepite==true){ ?>
	<tr>
		<td class="texto">REPITENCIA:</td>
	</tr>
	<tr>
		<td  class="celda ccenter">
			<small>N°</small>
		</td>
		<td  class="celda ccenter">
			<small>UNIDADES DIDACTICAS</small>
		</td>
		
		<td  class="celda ccenter">
			<small>MÓDULO</small>
		</td>
		<td  class="celda ccenter">
			<small>HORAS</small>
		</td>
		<td  class="celda ccenter">
			<small>CRÉDITOS</small>
		</td>
		<td  class="celda ccenter">
			<small>CONDICIÓN</small>
		</td>
	</tr>
	<?php
	}
	$nro=0;
	foreach ($curs as $key => $cur) {

		$nro++;
		# code...
	?>
	<tr>
		<td class="celda ccenter-nobold">
			<span><?php echo $nro ?></span>
		</td>
		<td class="celda">
			<span><?php echo $cur->curso ?></span>
		</td>

		<td class="celda ccenter-nobold">
			<span><?php echo $cur->nromodulo ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php 
			echo $cur->hts + $cur->hps; ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php 
			echo $cur->cp + $cur->ct; ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span></span>
		</td>
	</tr>
	<?php } ?>
</table>
<br>
<table class="encabezado">
	<tr>
		<td class="texto" align="right">
			<?php 
			  $fecha=$mat->fecha;
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


<table class="encabezado">
	<tr>
		
		<td class="firmas ccenter-nobold">
			<img src="<?php echo base_url().'resources/img/firma_dir_general.iestphuarmaca.edu.pe.png' ?>" alt="MINEDU"><br>
			____________________________________
		</td>
		<td class="firmas ccenter-nobold">
			<img src="<?php echo base_url().'resources/img/firma_sec_academico.iestphuarmaca.edu.jpg' ?>" alt="MINEDU"><br>
			____________________________________
		</td>
		<td class="firmas ccenter-nobold">
			<br><br><br><br><br><br><br>
			____________________________________
		</td>
	</tr>
	<tr>
		<td class="firmas ccenter-nobold">
			Director General 	<br>
			Sello, Firma, Posfirma
		</td>
		<td class="firmas ccenter-nobold">
			SECRETARÍA ACADÉMICO 	<br>
			Sello, Firma, Posfirma
		</td>
		<td class="firmas ccenter-nobold">
			ALUMNO(A) 	<br>
			
		</td>
	</tr>
</table>
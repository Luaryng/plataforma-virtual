<!-- Content Wrapper. Contains page content -->
<?php $ncol = 0;?>
<link href="<?php echo base_url(); ?>resources/bootstrap/bootstrap-slider.css" rel="stylesheet">
<div class="content-wrapper">
	<section class="content-header">
		<h1>
		<?php echo $curso->curso ?>
		<small><?php echo $curso->seccion . $curso->subseccion; ?></small>
		</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div id="divboxasistencia" class="box box-success">
			<div class="box-header with-border no-padding">
				<div class="col-md-8 no-padding margin-top-10px">
					<input type="hidden" name="txtcarne" value="<?php echo $alumno->carne; ?>" id="txtcarne">
					<!--<div id="divdocente" class="col-md-12">Docente: <b><?php echo $curso->docente; ?></b></div>-->
					<div id="divcarne" class="col-md-4">Carné: <b><?php echo $alumno->carne; ?></b></div>
					<div id="div-miembro" class="col-md-8">Alumno: <b><?php echo $alumno->alumno; ?></b></div><br>
					<div id="divperiodo" class="col-md-4">Periodo: <b><?php echo $curso->periodo; ?></b></div>
					<div id="divcarrera" class="col-md-8">Carrera: <b><?php echo $curso->carrera; ?></b></div>
					<div id="divciclo" class="col-md-4">Ciclo: <b><?php echo $curso->ciclo; ?></b></div>
					<div id="divturno" class="col-md-4">Turno: <b><?php echo $curso->turno; ?></b></div>
					<div id="divseccion" class="col-md-4 text-right">Sección: <b><?php echo $curso->seccion . $curso->subseccion; ?></b></div>
					<div class="clearfix"></div>

				</div>

			</div>
			<div class="box-body ">
				<h3>ASISTENCIAS</h3>
				<table class="table-mobile" id="tbasistencia" role="table">
					<thead role="rowgroup">
						<tr role="row">
							<?php
							$dias      = array("Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb");
							$fanterior = "01/01/90";
							foreach ($fechas as $key => $fecha) {
							$fechaslt = date("d/m/y", strtotime($fecha->fecha));
							//echo $fechaslt."--".$fanterior."";
							$inicia = ($fechaslt == $fanterior) ? $fecha->inicia . "<br>" : "";
							echo "<th class='text-center'><span class='rotar'>" . $inicia . $dias[date("w", strtotime($fecha->fecha))] . " " . $fechaslt . "</span></th>";
							$fanterior = $fechaslt;
							}
							?>
						</tr>
					</thead>
					<tbody role="rowgroup">
						<tr role="row">
							<?php
							foreach ($fechas as $key => $fecha) {
							$aid      = "0";
							$aaccion  = " ";
							$colorbtn = "btn-default";
							foreach ($asistencias as $key => $ast) {
							if ($fecha->sesion == $ast->sesion) {
							$aid      = $ast->id;
							$aaccion  = $ast->accion;
							$colorbtn = "btn-default";
							switch ($ast->accion) {
							case 'A':
							$colorbtn = "btn-success";
							break;
							case 'T':
							$colorbtn = "btn-warning";
							break;
							case 'F':
							$colorbtn = "btn-danger";
							break;
							}
							}
							}
							echo "<td><span class='btn btn-flat btn-block " . $colorbtn . "'>" . $aaccion . "</span></td>";
							}
							?>
						</tr>
					</tbody>
				</table>
				<div class="col-md-8" id="divmsgError">
				</div>
				<h3>EVALUACIONES</h3>
				<table class="table-mobile" id="tbasistencia" role="table">
					<thead role="rowgroup">
						<tr role="row">
							<?php
							foreach ($evaluaciones as $key => $evaluacion) {
							echo "<th><span class='rotar'>" . $evaluacion->abrevia . "</span></th>";
							}
							?>
						</tr>
					</thead>
					<tbody role="rowgroup">
						<?php
						$numero = 0;
						$idn    = 0;
						echo '<tr role="row">';
								foreach ($evaluaciones as $key => $evaluacion) {
								$anota    = "--";
								$colorbtn = "btn-default";
								foreach ($notas as $key => $nota) {
								if ($evaluacion->abrevia == $nota->abrevia) {
								$aid        = $nota->id;
								$aidmiembro = $nota->idmiembro;
								$anota      = $nota->nota;
								$colorbtn   = "btn-default";
								if ($nota->nota > 12) {
								$colorbtn = "text-primary";
								} else {
								$colorbtn = "text-danger";
								}
								}
								}
								echo "<td class='cellnota'>" . $anota . "</td>";
								}
						echo '</tr>';
						?>
					</tbody>
				</table>
			</div>
			<!--contenedor cursos -->
			<div class="box-body">
				<div class="clearfix"></div>
				<div class="row">
					<h5>
					<div id="divperiodo" class="col-md-2"></div>
					<div id="divcarrera" class="col-md-4"></div>
					<div id="divciclo" class="col-md-2"></div>
					<div id="divturno" class="col-md-2"></div>
					<div id="divseccion" class="col-md-2"></div>
					<div id="divmiembro" class="col-md-12">MAS CURSOS</div></h5>
				</div>
				<div  class="panel panel-primary margin-top-10px ">
					<div id="divmiscursos" class="panel-body margin-top-10px no-padding">
						<?php
						
						$tabla = '<table class="table-responsive margin-top-10px" id="tr-cursos" role="table">
							<thead role="rowgroup">
								<tr role="row">
									<th role="columnheader">COD</th>
									<th role="columnheader">CURSO</th>
									<th role="columnheader"> </th>
									<th role="columnheader">DOCENTE</th>
									<th role="columnheader">NL</th>
									<th role="columnheader">NR</th>
									<th role="columnheader">NF</th>
								</tr>
							</thead>
							<tbody role="rowgroup">';
								foreach ($miscursos as $curso) {
								
								$capr = ($curso->final >= 13) ? "text-success" : "text-danger";
								$tabla  = $tabla . '<tr role="row">
									<td role="cell"> <a class="hidden-print" href="#"><i class="fa fa-circle ' . $capr . '"></i> </a>' . $curso->codcurso . '</td>
									<td role="cell">' . $curso->curso . '</td>
									<td role="cell"><a title="Ver detalles" href="' . base_url() . 'consejeria/alumno/' . base64url_encode($curso->idcarga) . '/' . base64url_encode($curso->idmiembro) . '/' . base64url_encode($curso->matricula) . '"><i class="fa fa-2x fa-eye"></i></a></td>
									<td role="cell">' . $curso->docente . '</td>
									<td role="cell">' . $curso->nota . '</td>
									<td role="cell">' . $curso->recuperacion . '</td>
									<td role="cell">' . $curso->final . '</td>
								</tr>';
								
								}
							$tabla= $tabla . "</tbody></table>";
							if (count($miscursos)==0){
								$tabla  = $tabla ."<h4>-- SIN CURSOS REGISTRADOS</h4>";
							}
							
							$salida=$tabla;
							
							echo $salida;
							?>
						</div>
					</div>
				</div>
				<!--fin de contenedor cursos-->
			</div>
		</section>
	</div>
	<script src="<?php echo base_url(); ?>resources/jquery/pages.js"></script>
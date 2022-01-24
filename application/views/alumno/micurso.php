<!-- Content Wrapper. Contains page content -->
<?php $ncol = 0;?>
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<h1>
			<?php echo $curso->unidad ?>
			<small><?php echo $curso->codseccion . $curso->division; ?></small>
			</h1>
		</div>
	</section>
	<!-- Main content -->
	<section class="content">
		<div id="divboxasistencia" class="card">
			<div class="card-header with-border">
				
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12 p-0"><h2 class="no-padding"><b><?php echo $acarnet." / ".$aalumno ?></b></h2></div>
						<div id="divperiodo" class="col-md-4">Periodo: <b><?php echo $curso->codperiodo; ?></b></div>
						<div id="divcarrera" class="col-md-8">Carrera: <b><?php echo $curso->carrera; ?></b></div>
						<div id="divciclo" class="col-md-4">Ciclo: <b><?php echo $curso->ciclo; ?></b></div>
						<div id="divturno" class="col-md-4">Turno: <b><?php echo $curso->codturno; ?></b></div>
						<div id="divseccion" class="col-md-4">Sección: <b><?php echo $curso->codseccion . $curso->division; ?></b></div>
						<div id="divdocente" class="col-md-12">Docente: <b><?php echo $curso->paterno.' '.$curso->materno.' '.$curso->nombres ; ?></b></div>
					</div>
				</div>
				
			</div>
			<div class="card-body ">
				
				<h4 class="no-padding"><b>ASISTENCIAS</b></h4>
				<hr class="no-margin no-padding">
				<br>
				<div class="col-12">
					<div class="row">
						<?php
							$nfechas=$curso->sesiones;
							$arasist=  array('A' => 0,'T' => 0,'F' => 0,'J' => 0,'E' => 0,'N'=>0 );
							$fanterior = "01/01/90";
							$dias      = array("Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb");
							$iterador=0;
							foreach ($fechas as $key => $fecha) {
								$iterador++;
							$aid      = "0";
							$aaccion  = " ";
							$colorbtn = "label-default";
							$fechaslt = date("d/m/y", strtotime($fecha->fecha));
							//echo $fechaslt."--".$fanterior."";
							$inicia = ($fechaslt == $fanterior) ? $fecha->inicia  : "";
							
							$fanterior = $fechaslt;
									
							foreach ($asistencias as $key => $ast) {
							if ($fecha->sesion == $ast->sesion) {
							$aid      = $ast->id;
							$aaccion  = $ast->accion;
							if ($ast->accion==""){
								$ast->accion="N";
								$aaccion  = "-";
							}
							
							$colorbtn = "badge-default";
							switch ($ast->accion) {
							case 'A':
							$colorbtn = "badge-success";
							break;
							case 'T':
							$colorbtn = "badge-warning";
							break;
							case 'F':
							$colorbtn = "badge-danger";
							break;
							case 'J':
							$colorbtn = "badge-info";
							break;
							}
							$arasist[$ast->accion]++;
							}
							}
							echo "<div class='col-6 col-md-3'>
											<div class='row border-gray'>
														<div class='col-2 text-right no-padding'>
																	<span class='text-right'>".$iterador.".- </span>
														</div>
														<div class='col-8'>
																	<span> " .$inicia . $dias[date("w", strtotime($fecha->fecha))] . " " . $fechaslt . "</span>
														</div>
														<div class='col-2 no-padding'>
																	<span class='badge " . $colorbtn . "'>" . $aaccion . "</span>
														</div>
													
											</div>
								</div>";
							}
						?>
					</div>
				</div>
				<br>
				
				<!--<div class='col-6 col-md-3'>
							<div class='row border-gray'>
										<div class='col-7'>
													<span>Exoneraciones</span>
										</div>
										<div class='col-2 no-padding'>
							<span><?php echo $arasist['E'] ?></span>
						</div>
						<div class='col-3 no-padding'>
							<span><?php echo round($arasist['E']/$nfechas*100,2) ?>%</span>
						</div>
						
					</div>
				</div>-->
				<section>
					<h4  class=" ">ASISTENCIAS - RESUMEN</h4>
					<hr class="no-margin no-padding">
					<br>
					<div class='col-6 col-md-3'>
						<div class='row border-gray'>
							<div class='col-9'>
								<span>Total Sesiones</span>
							</div>
							<div class='col-3 no-padding'>
								<span><?php echo $nfechas ?></span>
							</div>
						</div>
					</div>
					<?php
					$pa=round($arasist['A']/$nfechas*100,0);
					$pf=round($arasist['F']/$nfechas*100,0);
					$pt=round($arasist['T']/$nfechas*100,0);
					$pj=round($arasist['J']/$nfechas*100,0);
					?>
					<div class="col-12">
						<div class="row">
							<div class='col-6 col-md-3 bg-success'>
								<div class='row border-gray'>
									<div class='col-7'>
										<span>Asistencias</span>
									</div>
									<div class='col-2 no-padding'>
										<span><?php echo $arasist['A'] ?></span>
									</div>
									<div class='col-3 no-padding'>
										<span><?php echo $pa?>%</span>
									</div>
									
								</div>
							</div>
							
							<div class='col-6 col-md-3 bg-danger'>
								<div class='row border-gray'>
									<div class='col-7'>
										<span>Faltas</span>
									</div>
									<div class='col-2 no-padding'>
										<span><?php echo $arasist['F'] ?></span>
									</div>
									<div class='col-3 no-padding'>
										<span><?php echo $pf ?>%</span>
									</div>
									
								</div>
							</div>
							<div class='col-6 col-md-3 bg-warning'>
								<div class='row border-gray'>
									<div class='col-7'>
										<span>Tardanza</span>
									</div>
									<div class='col-2 no-padding'>
										<span><?php echo $arasist['T'] ?></span>
									</div>
									<div class='col-3 no-padding'>
										<span><?php echo $pt ?>%</span>
									</div>
									
								</div>
							</div>
							<div class='col-6 col-md-3 bg-info'>
								<div class='row border-gray'>
									<div class='col-7'>
										<span>Justificado</span>
									</div>
									<div class='col-2 no-padding'>
										<span><?php echo $arasist['J'] ?></span>
									</div>
									<div class='col-3 no-padding'>
										<span ><?php echo $pj ?>%</span>
									</div>
									
								</div>
							</div>
							<div class="col-12 pt-1 px-0">
								<div class="progress">
									<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $pa ?>%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"><?php echo $pa  ?>%</div>
									<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $pf ?>%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"><?php echo $pf ?>%</div>
									<div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $pt ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"><?php echo $pt ?>%</div>
									<div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $pj ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"><?php echo $pj ?>%</div>
								</div>
							</div>
						</div>
						
					</div>
				</section>
				<br>
				<h4><b>EVALUACIONES</b></h4>
				<hr class="no-margin no-padding">
				<br>
				<div class='col-12'>
					<div class="row">
						<?php
						$iterador=0;
						$codindicador=0;
						foreach ($indicadores as $indicador) {
							$iterador++;
							foreach ($evaluaciones as $key => $evaluacion) {
								if ($indicador->codigo==$evaluacion->indicador){
								if($codindicador!=$evaluacion->indicador){
									if ($codindicador!= $indicador->codigo){
								echo "</div>";
								$codindicador=$indicador->codigo;
							}
							echo "<div class='row pb-2'>";
										echo "<div class='col-12 pt-2 bg-primary'>
													<b>INDICADOR $iterador</b><br>
											</div>";
										echo "<div class='col-12 py-2 border-gray'>
													<span >$indicador->nombre</span>
										</div>";
								}
							$anota    = "--";
							$colorbtn = "text-default";
							$headtext=$evaluacion->nombre;
							
							foreach ($notas as $key => $nota) {
							if ($evaluacion->evaluacion == $nota->evaluacion) {
							$anota      = $nota->nota;
							$colorbtn   = "text-default";
							if ($nota->nota > 12) {
							$colorbtn = "text-primary";
							} else {
							$colorbtn = "text-danger";
							}
							}
							}
						?>
						<div class='col-6 col-sm-4 col-md-3'>
							<div class='row border-gray'>
								<div class='col-10'>
									<span> <?php echo $headtext ?></span>
								</div>
								<div class='col-2 no-padding'>
									<?php echo "<span class='$colorbtn'><b>$anota</b></span>" ?>
								</div>
							</div>
						</div>
						<?php }
						}
						} ?>
					</div>
				</div>
				<br>
				<h3 class=" "><b>MAS CURSOS</b></h3>
				
				<br>
				<div class="table-responsive">
					<?php echo $mascursos; ?>
				</div>
				
			</div>
			<!--contenedor cursos -->
			<!--<div class="card-body">
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
						</div>
			</div>-->
			<!--fin de contenedor cursos-->
		</div>
	</section>
</div>
<!--<script type="text/javascript" charset="utf-8">
	$('#divboxasistencia').ready(function() {
		var tcar=$('#txtcarne').val();
		$('#divboxasistencia').append('<div id="divoverlay" class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$.ajax({
					url: base_url + 'consejeria/vwcursoXmatricula'	,
			type: 'post',
			dataType: 'json',
			data: {txtbusca_carne: tcar},
			success: function(e) {
				$('#divboxasistencia #divoverlay').remove();
				if (e.status == false) {
					var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
					$('#divmiscursos').html(msgf);
				}
				else {
					$('#divmiscursos').html(e.miscursos);
					//$('#divmiembro').html(e.miembro);
				}
			},
		error: function (jqXHR, exception) {
			var msgf=errorAjax(jqXHR, exception,'div');
		$('#divboxnotas #divoverlay').remove();
		$('#divmiscursos').html(msgf);
	},
		});
	return false;
});
</script>-->
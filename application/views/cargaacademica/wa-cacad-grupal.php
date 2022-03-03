<?php $vbaseurl=base_url() ?>
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content-wrapper">

	<div class="modal fade" id="md-plan" tabindex="-1" role="dialog" aria-labelledby="md-plan" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Terminar</button>
				</div>
			</div>
		</div>
	</div>
	<!--<div class="modal fade" id="md-listadocente" tabindex="-1" role="dialog" aria-labelledby="md-listadocente" aria-hidden="true">
			<div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
				
				<div class="modal-header">
					<h4 class="modal-title">Asignar docente</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<div class="modal-body">
					
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>-->
	<div class="modal fade" id="modviewnotas" tabindex="-1" role="dialog" aria-labelledby="modviewnotas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
			<div class="modal-content" id="divmodaladd">
				<div class="modal-header">
					<h5 class="modal-title">Notas grupo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<small id="fmt-conteo" class="form-text text-primary">
					
					</small>
					<div class="btable" id="div_filtro_head">
						<div class="thead col-12  d-none d-md-block">
							<div class="row">
								<div class="col-md-3">
									<div class="row">
										<div class="col-md-3 td small text-bold">NRO</div>
										<div class="col-md-9 td small text-bold">CARNÉ</div>
									</div>
								</div>
								<div class="col-md-4 td small text-bold">ESTUDIANTE</div>
								<div class="col-md-1 td small text-bold">NOTA FIN</div>
								<div class="col-md-1 td small text-bold">NOTA REC.</div>
								<div class="col-md-1 td small text-bold"></div>
								<div class="col-md-2 td small text-bold"></div>
							</div>
						</div>
						<div id="div_filtro_alumno" class="tbody col-12">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<?php if (getPermitido("128")=='SI'){ ?>
					<button type="button" id="vw_mpc_btn_subirnotas" class="btn btn-primary">Migrar a Historial</button>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modguardarnotas" tabindex="-1" role="dialog" aria-labelledby="modguardarnotas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
			<div class="modal-content" id="divmodaladd_nf">
				<div class="modal-header">
					<h5 class="modal-title">Modificar notas finales</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<small id="fmt-conteo" class="form-text text-primary">
					
					</small>
					<div class="btable" id="div_filtro_head">
						<div class="thead col-12  d-none d-md-block">
							<div class="row">
								<div class="col-md-3">
									<div class="row">
										<div class="col-md-3 td small text-bold">NRO</div>
										<div class="col-md-9 td small text-bold">CARNÉ</div>
									</div>
								</div>
								<div class="col-md-4 td small text-bold">ESTUDIANTE</div>
								<div class="col-md-1 td small text-bold">NOTA FIN</div>
								<div class="col-md-1 td small text-bold">NOTA REC.</div>
								<div class="col-md-1 td small text-bold"></div>
								<div class="col-md-2 td small text-bold"></div>
							</div>
						</div>
						<div id="div_notas_alumnos" class="tbody col-12">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<?php if (getPermitido("128")=='SI'){ ?>
					<button type="button" id="vw_mpc_btn_subirnotas_final" class="btn btn-primary">Guardar</button>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_grupo" class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Carga Académica por grupo</h3>
			</div>
			<div class="card-body">
				
				<b class="text-danger"><i class="fas fa-user-circle mr-1"></i> Selecciona el grupo</b>
				
				<form id="frm-grupo" name="frm-grupo" action="#" method="post" accept-charset='utf-8'>
					<div class="row mt-2">
						<div class="form-group has-float-label col-12  col-sm-2">
							<select data-currentvalue='' class="form-control" id="fca-cbperiodo" name="fca-cbperiodo" placeholder="Periodo" required >
								<option value="0">Periodo</option>
								<?php foreach ($periodos as $periodo) {?>
								<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
								<?php } ?>
							</select>
							<label for="fca-cbperiodo"> Periodo</label>
						</div>
						<div class="form-group has-float-label col-12  col-sm-4">
							<select class="form-control" id="fca-carrera" name="fca-carrera" placeholder="Programa">
								<option value="0">Selecciona un Programa Acad.</option>
								<?php foreach ($carreras as $carrera) {?>
								<option value="<?php echo $carrera->codcarrera ?>" data-sigla="<?php echo $carrera->sigla ?>"><?php echo $carrera->nombre ?></option>
								<?php } ?>
							</select>
							<label for="fca-carrera"> Programa</label>
						</div>
						<div class="form-group has-float-label col-12  col-md-4">
							<select class="form-control" id="fca-plan" name="fca-plan" placeholder="Plan curricular">
								<option value="0">Selecciona Plan curricular</option>
								<?php foreach ($planes as $plan) {?>
								<option value="<?php echo $plan->codigo ?>"><?php echo $plan->nombre ?></option>
								<?php } ?>
							</select>
							<label for="fca-plan"> Plan curricular</label>
						</div>
						
						<div class="form-group has-float-label col-12  col-md-2">
							<select data-currentvalue='' class="form-control" id="fca-cbciclo" name="fca-cbciclo" placeholder="Ciclo" required >
								<option value="0">Ciclo</option>
								<?php foreach ($ciclos as $ciclo) {?>
								<option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
								<?php } ?>
							</select>
							<label for="fca-cbciclo"> Ciclo</label>
						</div>
						<div class="form-group has-float-label col-12  col-md-2">
							<select data-currentvalue='' class="form-control" id="fca-cbturno" name="fca-cbturno" placeholder="Turno" required >
								<option value="0">Turno</option>
								<?php foreach ($turnos as $turno) {?>
								<option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
								<?php } ?>
							</select>
							<label for="fca-cbturno"> Turno</label>
						</div>
						<div class="form-group has-float-label col-12  col-md-2">
							<select data-currentvalue='' class="form-control" id="fca-cbseccion" name="fca-cbseccion" placeholder="Sección" required >
								<option value="0">Sección</option>
								<?php foreach ($secciones as $seccion) {?>
								<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
								<?php } ?>
							</select>
							<label for="fca-cbseccion"> Sección</label>
						</div>
						<div class="col-md-1 mb-2">
							<input id="fca-checkgrupo" type="checkbox" data-toggle="toggle"
							data-on="<i class='fa fa-check'></i>" data-off="<i class='fas fa-arrow-alt-circle-right'></i>"
							data-onstyle="success" data-offstyle="danger">
						</div>
						<div class="col-12 col-md-3">
							<button type="button" id="btn-vercurricula" class="btn btn-primary">
								<i class="fas fa-eye"></i> Currícula
							</button>
						</div>
						<div class="col-12 col-md-3">
							Matrículas : <span id="vw_cg_spn_nmatriculas"></span>
						</div>


					</div>
				</form>
			</div>
		</div>
		<div id="divcard_cursos" class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Registro de carga académica por grupo</h3>
			</div>
			<div class="card-body">
				<b class="text-danger"></i> Selecciona el grupo</b>
			</div>
		</div>
	</section>
</div>
<?php
?>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/grupo_carga_academica.js"></script>
<script>
var btn_editdocente=null;
var vdocentes = <?php echo json_encode($docentes, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
var vpermiso128= '<?php echo getPermitido("128"); ?>';
const Toast = Swal.mixin({
toast: true,
position: 'top-end',
showConfirmButton: false,
timer: 5000
})
$("#btn-vercurricula").hide();

</script>
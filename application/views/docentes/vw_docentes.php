<?php 
	$vbaseurl=base_url();
	$vsede = $_SESSION['userActivo']->idsede;
?>
<style>
	.text-title{
		margin-top: 20px;
		margin-bottom: 12px;
		
		color: #dc3545 !important;
		font-size: 1.5em;
		font-weight: 500;
	}
</style>
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
			<div class="card-header p-2">
				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link active" href="#busqueda" data-toggle="tab">
							<i class="fas fa-user"></i> Búsqueda
						</a>
					</li>
					<li id="tabli-aperturafile" class="nav-item">
						<a class="nav-link" href="#ficha-personal" data-toggle="tab">
							<i class="fas fa-user-plus mr-1"></i> Registrar
						</a>
					</li>
				</ul>
			</div>
			<!-- /.card-header -->
			<div class="card-body pt-sm-1">
				<div class="tab-content">
					<div class="tab-pane active pt-2" id="busqueda">
						<!--<div class="card-header">-->
						<form id="frm-filtro-historial"  name="frm-filtro-historial" action="<?php echo $vbaseurl ?>docentes/fn_filtrar_trabajadores" method="post" accept-charset='utf-8'>
							<div class="row">
								<div class="form-group has-float-label col-8 col-sm-5">
									<input autocomplete="off" id="txtbusqueda" name="txtbusqueda" class="form-control form-control-sm " type="text" placeholder="DNI, Apellidos y nombres"/>
									<label id="txtbusqueda">DNI, Apellidos y nombres</label>
								</div>
								<div class="form-group has-float-label col-4 col-sm-2">
									<select id="txtestado" name="txtestado" class="form-control form-control-sm">
										<option value="%">Todos</option>
										<option value="SI">Habilitado</option>
										<option value="NO">Deshabilitado</option>
									</select>
									<label id="txtestado">Estado</label>
								</div>
								<div class="col-2 col-sm-1">
									<button type="submit" class="btn btn-primary btn-sm">
									<i class="fas fa-search"></i>
									</button>
								</div>
								<div class="col-2 col-sm-2">
									<a id="vw_dct-btn_ficha_link" href="#" class="btn btn-success btn-sm">
									<i class="fas fa-user-plus"></i> <span class="d-none d-sm-inline-block">Nuevo</span>
									</a>
								</div>
								<div class="col-6 col-sm-2">
				                  	<a href="#" class="btn-excel btn btn-outline-secondary btn-sm"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Exportar</a>
				                </div>
							</div>
							<div class="row p-2">
								
							</div>
							
						</form>
						<!--</div>-->
						
						
						<div class="py-1" id="divres-historial">
							<?php include ("vw_docentes-lista.php") ?>
						</div>
						
					</div>
					<div class="tab-pane" id="ficha-personal">
						<!-- MultiStep Form -->
						
							<div class="col-md-12">
								<div id="div-inscripcion">
									<div id="divmsg_sede"></div>
									<form id="frmins-personales"action="#" method="post" accept-charset='utf-8' data-action='insert'>
										<!--ITEM HIDDEN-->
										<input data-currentvalue='' id="fitxtcodinstitucional" name="fitxtcodinstitucional" type="hidden" required />
										<input data-currentvalue='' id="fitxtcoddocente" name="fitxtcoddocente" type="hidden" />
										<input data-currentvalue='' id="fidpid" name="fidpid" type="hidden" />
										<input data-currentvalue='' id="fidpstadociv" name="fidpstadociv" type="hidden" />
										<input data-currentvalue='' id="fidplugnacim" name="fidplugnacim" type="hidden" />
										<input data-currentvalue='' id="fidpcelular2" name="fidpcelular2" type="hidden" />
										<!-- FIN ITEM HIDDEN-->
										<div class="row text-title">
											<span><i class="fas fa-user-circle"></i> DATOS PERSONALES</span>
										</div>
										<div class="row mt-3">
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-2">

												<select class="form-control form-control-sm" id="ficbtipodoc" name="ficbtipodoc" placeholder="Tipo " >
													<option value="DNI">DNI</option>
													<option value="CEX">Carné de Extranjería</option>
													<option value="PSP">Pasaporte</option>
													<option value="PTP">Permiso Temporal de Permanencia</option>
													<option value="RUC">RUC</option>
												</select>
												<label for="ficbtipodoc"> Tipo</label>
											</div>
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-2">
												<input data-currentvalue='' autocomplete="off" class="form-control form-control-sm text-uppercase" id="fitxtdni" name="fitxtdni" type="text" placeholder="DNI"  minlength="8" />
												<label for="fitxtdni"> DNI</label>
											</div>
											<div class="col-12 col-xs-3 col-sm-3 d-none">
												<button id="fibtnvalida-dni" type="button" class="btn btn-primary btn-block">
												Validar DNI
												</button>
											</div>
											<div class="input-group mb-3 col-12 col-xs-12 col-sm-5 d-none">
												<input data-currentvalue='' type="text" class="form-control form-control-sm" id="fitxtreniec" disabled>
												<div class="input-group-append">
													<button id="fibtnaplica-reniec" disabled="true" data-paterno='' data-materno='' data-nombres='' class="btn btn-info" type="button" ><i class="fas fa-check-double"></i></button>
												</div>
											</div>

										</div>
										
										<div id="vw_rrhh-div_ficha">
										<div class="row">
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-4">
												<input autocomplete="off" data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtapelpaterno" name="fitxtapelpaterno" type="text" placeholder="Ap. Paterno"  required />
												<label for="fitxtapelpaterno">Ap. Paterno</label>
											</div>
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-4">
												<input autocomplete="off" data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtapelmaterno" name="fitxtapelmaterno" type="text" placeholder="Ap. Materno"  required />
												<label for="fitxtapelmaterno">Ap. Materno</label>
											</div>
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-4">
												<input autocomplete="off" data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtnombres" name="fitxtnombres" type="text" placeholder="Nombres"  required />
												<label for="fitxtnombres">Nombres</label>
											</div>
										</div>
										<div class="row">
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-2">
												<select class="form-control form-control-sm" id="ficbsexo" name="ficbsexo" placeholder="Sexo" >
													<option value=""></option>
													<option value="MASCULINO">MASCULINO</option>
													<option value="FEMENINO">FEMENINO</option>
												</select>
												<label for="ficbsexo"> Sexo</label>
											</div>
											<div class="form-group has-float-label col-12  col-sm-2">
												<select class="form-control form-control-sm" id="ficbestcivil" name="ficbestcivil">
													<option value="SOLTERO">SOLTERO(A)</option>
													<option value="CASADO">CASADO(A)</option>
													<option value="DIVORCIADO">DIVORCIADO(A)</option>
													<option value="VIUDO">VIUDO(A)</option>
													<option value="CONVIVIENTE">CONVIVIENTE</option>
												</select>
												<label for="ficbestcivil"> Estado Civil</label>
											</div>
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
												<input data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtfechanac" name="fitxtfechanac" type="date" placeholder="Fec. Nacimiento"   />
												<label for="fitxtfechanac">Fec. Nacimiento</label>
											</div>
											<div class="form-group has-float-label col-12  col-sm-5">
												<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtlugarnac" name="fitxtlugarnac" type="text" placeholder="Lugar Nacimiento"/>
												<label for="fitxtlugarnac">Lugar Nacimiento</label>
											</div>
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-2">
												<input autocomplete="off" data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtcelular" name="fitxtcelular" type="text" placeholder="Celular" />
												<label for="fitxtcelular">Celular</label>
											</div>
											<div class="form-group has-float-label col-12  col-sm-2">
												<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtcelular2" name="fitxtcelular2" type="text" placeholder="Celular" />
												<label for="fitxtcelular2">Otro Celular </label>
											</div>
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
												<input autocomplete="off" data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxttelefono" name="fitxttelefono" type="text" placeholder="Teléfono" />
												<label for="fitxttelefono">Teléfono</label>
											</div>
											<div class="form-group has-float-label col-12 col-sm-5">
												<input autocomplete="off" data-currentvalue='' class="form-control form-control-sm" id="fitxtemailpersonal" name="fitxtemailpersonal" type="text" placeholder="Email Personal"  required />
												<label for="fitxtemailpersonal">Email personal</label>
											</div>
										</div>
										<b class="text-danger"><i class="fas fa-map-marker-alt"></i> UBICACIÓN</b>
										<div class="row mt-3">
											<div class="form-group has-float-label col-12 ">
												<input autocomplete="off" data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtdomicilio" name="fitxtdomicilio" type="text" placeholder="Domicilio"  required />
												<label for="fitxtdomicilio">Domicilio</label>
											</div>
											<div class="form-group has-float-label col-12  col-sm-3">
												<select data-currentvalue='' class="form-control form-control-sm" id="ficbpais" name="ficbpais" required >
													<option value="0">Selecciona Pais</option>
													<?php foreach ($paises as $key => $ps) {?>
													<option value="<?php echo $ps->codigo ?>"><?php echo $ps->nombre ?></option>
													<?php } ?>
												</select>
												<label for="ficbpais"> Pais</label>
											</div>
											<div class="form-group has-float-label col-12  col-md-3">
												<select onchange='fn_combo_ubigeo($(this));' data-tubigeo='departamento' data-cbprovincia='ficbprovincia' data-cbdistrito='ficbdistrito' data-dvcarga='divboxhistorial' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required >
													<option value="0">Selecciona Departamento</option>
													<?php foreach ($departamentos as $key => $depa) {?>
													<option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
													<?php } ?>
												</select>
												<label for="ficbdepartamento"> Departamento</label>
											</div>
											<div class="form-group has-float-label col-12 col-md-3">
												<select onchange='fn_combo_ubigeo($(this));' data-tubigeo='provincia' data-cbdistrito='ficbdistrito' data-dvcarga='divboxhistorial' class="form-control form-control-sm" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" required >
													<option value="0">Sin opciones</option>
												</select>
												<label for="ficbprovincia"> Provincia</label>
											</div>
											<div class="form-group has-float-label col-12 col-md-3">
												<select name="ficbdistrito" id="ficbdistrito"  class="form-control form-control-sm text-uppercase">
													
													
												</select>
												<label for="ficbdistrito">Distrito</label>
											</div>
											<div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
												<input autocomplete="off" data-currentvalue='0' class="form-control form-control-sm text-uppercase" id="fitxtdomiciliootro" name="fitxtdomiciliootro" type="text" placeholder="Otro domicilio"  required />
												<label for="fitxtdomiciliootro"> Otro domicilio</label>
											</div>
										</div>
										<b class="text-danger"><i class="fas fa-map-marker-alt"></i> DATOS LABORALES</b>
										<div class="row mt-3">
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
												
												<input data-currentvalue='' id="ficbtipo_antiguo" name="ficbtipo_antiguo" type="hidden" />
												
												
												<select class="form-control form-control-sm" id="ficbtipo" name="ficbtipo" placeholder="Tipo Doc." >
													<option value=""></option>
													<option value="AD">Administrativo</option>
													<option value="DA">Docente Administrativo</option>
													<option value="DC">Docente</option>
												</select>
												<label for="ficbtipo"> Tipo Doc.</label>
											</div>
											<div class="form-group has-float-label col-12 col-sm-4">
												<input data-currentvalue='' class="form-control form-control-sm" id="fitxtcargo" name="fitxtcargo" type="text" placeholder="Cargo"  required />
												<label for="fitxtcargo">Cargo</label>
											</div>
											<div class="form-group has-float-label col-12 col-sm-5">
												<input data-currentvalue='' class="form-control form-control-sm" id="fitxteinstitucional" name="fitxteinstitucional" type="text" placeholder="Email Institucional"  required />
												<label for="fitxteinstitucional">Email Institucional</label>
											</div>
											<div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
												<select data-currentvalue='' class="form-control form-control-sm" id="fitxtidarea" name="fitxtidarea" placeholder="Área" required >
													<option value="">Selecciona Área</option>
													<?php foreach ($areas as $key => $area) {?>
													<option value="<?php echo $area->codigo ?>"><?php echo $area->nombre ?></option>
													<?php } ?>
												</select>
												<label for="fitxtidarea"> Área</label>
											</div>
											
										</div>
										</div>
									</form>
									<div id="vw_rrhh-div_botones" class="row">
										<div class="col-12"><span id="fispedit" class="text-danger"></span></div>
										<div class="col-12">
											
											<button id="vw_rrhh-btn_nuevo" class="btn btn-success btn-lg float-right ml-2" data-sugerencia='openfile'><i class="fas fa-user-plus"></i> Nuevo</button>

											<button id="vw_rrhh-btn_cancelar" class="btn btn-danger btn-lg " data-sugerencia='cancelfile'><i class="fas fa-undo"></i> Cancelar</button>

											<button id="vw_rrhh-btn_editar" class="btn btn-warning btn-lg float-right ml-2" data-sugerencia='editfile'><i class="fas fa-user-edit"></i> Editar</button>

											<button id="vw_rrhh-btn_guardar" type="button" class="btn btn-primary btn-lg float-right"><i class="fas fa-save"></i> Guardar</button>
										</div>
									</div>
									
									
								</div>
							</div>
						
						<!-- /.MultiStep Form -->
					</div>
					
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- /.card-body -->
		</div>
	</section>
</div>
<!--content-wrapper -->
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/rrhh-v2.js"></script>
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/ubigeo_uni.js"></script>

<script>
	var sedeuser = '<?php echo $vsede ?>';
</script>
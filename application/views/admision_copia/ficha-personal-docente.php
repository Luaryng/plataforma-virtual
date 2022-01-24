<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/form-multi-steps/form-ms.css">
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<!-- Main content -->
	<section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>Datos Personales (Prospecto)</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
			<div class="card-header p-2">
				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link active" href="#busqueda" data-toggle="tab">
							<i class="fas fa-search"></i> Búsqueda
						</a>
					</li>
					<li id="tabli-aperturafile" class="nav-item">
						<a class="nav-link" href="#ficha-personal" data-toggle="tab">
							<i class="fas fa-user"></i> Ficha Personal
						</a>
					</li>
				</ul>
			</div>
			<!-- /.card-header -->
			<div class="card-body p-2">
				<div class="tab-content">
					<div class="active tab-pane pt-3" id="busqueda">
						<!--<div class="card-header">-->
						
						<form id="frm-filtro-historial" name="frm-filtro-historial" action="<?php echo $vbaseurl ?>admision/fn_filtrar_historial" method="post" accept-charset='utf-8'>
							
							<div class="row">
								


								<div class="form-group input-group  no-flex col-12 col-sm-11">
									<div class="input-group-prepend">
										<span class="input-group-text">Buscar: </span>
										<label class="has-float-label">
											<input autocomplete='off' id="txtbusqueda" name="txtbusqueda" class="form-control " type="text" placeholder="DNI, Apellidos y nombres"/>
											<span>DNI, Apellidos y nombres</span>
										</label>
									</div>
								</div>


								<div class="col-12  col-sm-1">
									<button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
								</div>
								
							</div>
							
						</form>
						<!--</div>-->
						<div class="card-body no-padding">
							<div class="row">
								<div class="col-12 py-1" id="divres-historial">
									<div class="card">
										<div class="card-body">
											<span class='text-danger'>Utiliza los cuadros de búsqueda ubicados arriba para encontrar el historial existente de los estudiantes registrados</span>
										</div>
									</div>
								</div>
								
								
							</div>
						</div>
					</div>
					<div class="tab-pane" id="ficha-personal">
						<!-- MultiStep Form -->
						<div class="row">
							<div class="col-md-12">
								<div class="multi-steps" id="div-inscripcion">
									
									<!-- progressbar -->
									<div class="progress progress-xs">
										<div class="progress-bar bg-warning progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="4" style="width: 25%">
										</div>
									</div>
									<ul class="steps">
										<li class="active"><a href="#">DATOS PERSONALES</a></li>
										<!--<li>Contactos</li>
										<li>Datos académicos</li>
										<li>Datos Económicos</li>-->
										<li><a href="#">Postular</a></li>
									</ul>
									<!-- fieldsets -->
									<div class="step">
										<form id="frmins-personales"action="#" method="post" accept-charset='utf-8' data-action='insert'>
											<b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> DATOS PERSONALES</b>
											<div class="row margin-top-20px">
												<div class="form-group has-float-label col-12  col-sm-2">
													<input autocomplete='off' data-currentvalue='' class="fitxtidentificador" id="fidpid" name="fidpid" type="hidden" />
													<select class="form-control form-control-sm" id="ficbtipodoc" name="ficbtipodoc" placeholder="Tipo Doc." >
														<option value="DNI">DNI</option>
									                    <option value="CEX">Carné de Extranjería</option>
									                    <option value="PSP">Pasaporte</option>
									                    <option value="PTP">Permiso Temporal de Permanencia</option>
													</select>
													<label for="ficbtipodoc"> Tipo Doc.</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-2">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtdni" name="fitxtdni" type="text" placeholder="DNI"  minlength="8" />
													<label for="fitxtdni"> DNI</label>
												</div>
												<div class="col-12  col-sm-3">
													<button id="fibtnvalida-dni" type="button" class="btn btn-primary btn-block btn-sm">
													Validar DNI
													</button>
												</div>
												<div class="input-group mb-3 col-12  col-sm-5 input-group-sm">
													<input autocomplete='off' data-currentvalue='' type="text" class="form-control form-control-sm" id="fitxtreniec" disabled>
													<div class="input-group-append">
														<button id="fibtnaplica-reniec" disabled="true" data-paterno='' data-materno='' data-nombres='' class="btn btn-info" type="button" ><i class="fas fa-check-double"></i></button>
													</div>
												</div>
											</div>
											<hr>
											<!--<div class="row">
												<div class="form-group has-float-label col-12  col-sm-4">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase form-control form-control-sm-lg" id="fitxtcodinstitucional" name="fitxtcodinstitucional" type="text" placeholder="Cod. Institucional"  required />
													<label for="fitxtcodinstitucional">Cod. Institucional</label>
												</div>
											</div>-->
											<div class="row">
												
												
												<div class="form-group has-float-label col-12  col-sm-4">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtapelpaterno" name="fitxtapelpaterno" type="text" placeholder="Ap. Paterno"  required />
													<label for="fitxtapelpaterno">Ap. Paterno</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-4">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtapelmaterno" name="fitxtapelmaterno" type="text" placeholder="Ap. Materno"  required />
													<label for="fitxtapelmaterno">Ap. Materno</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-4">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtnombres" name="fitxtnombres" type="text" placeholder="Nombres"  required />
													<label for="fitxtnombres">Nombres</label>
												</div>
											</div>
											<div class="row">
												<div class="form-group has-float-label col-12  col-sm-2">
													<select class="form-control form-control-sm" id="ficbsexo" name="ficbsexo" placeholder="Sexo" >
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
												<div class="form-group has-float-label col-12  col-sm-3">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtfechanac" name="fitxtfechanac" type="date" placeholder="Fec. Nacimiento"   />
													<label for="fitxtfechanac">Fec. Nacimiento</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-5">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtlugarnac" name="fitxtlugarnac" type="text" placeholder="Lugar Nacimiento"/>
													<label for="fitxtlugarnac">Lugar Nacimiento</label>
												</div>

												<div class="form-group has-float-label col-12  col-sm-2">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtcelular" name="fitxtcelular" type="text" placeholder="Celular" />
													<label for="fitxtcelular">Celular</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-2">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtcelular2" name="fitxtcelular2" type="text" placeholder="Celular" />
													<label for="fitxtcelular2">Otro Celular </label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-2">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxttelefono" name="fitxttelefono" type="text" placeholder="Teléfono" />
													<label for="fitxttelefono">Teléfono</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-6">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm" id="fitxtemailpersonal" name="fitxtemailpersonal" type="text" placeholder="Email Personal"  required />
													<label for="fitxtemailpersonal">Email personal</label>
												</div>
												
											</div>

											<b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-map-marker-alt"></i> UBICACIÓN</b>
											<div class="row margin-top-20px">
												<div class="form-group has-float-label col-12  col-sm-12">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtdomicilio" name="fitxtdomicilio" type="text" placeholder="Domicilio"  required />
													<label for="fitxtdomicilio">Domicilio</label>
												</div>
											</div>
											<div class="row">
												<div class="form-group has-float-label col-12  col-sm-3">
													<select data-currentvalue='' class="form-control form-control-sm" id="ficbpais" name="ficbpais" required >
														<option value="0">Selecciona Pais</option>
														<?php foreach ($paises as $key => $ps) {?>
														<option value="<?php echo $ps->codigo ?>"><?php echo $ps->nombre ?></option>
														<?php } ?>
													</select>
													<label for="ficbpais"> Pais</label>
												</div>

												<div class="form-group has-float-label col-12  col-sm-3">
													<select data-currentvalue='' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required >
														<option value="0">Selecciona Departamento</option>
														<?php foreach ($departamentos as $key => $depa) {?>
														<option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
														<?php } ?>
													</select>
													<label for="ficbdepartamento"> Departamento</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-3">
													<select data-currentvalue='0' class="form-control form-control-sm" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" required >
														<option value="0">Sin opciones</option>
													</select>
													<label for="ficbprovincia"> Provincia</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-3">
													<select data-currentvalue='0'  class="form-control form-control-sm" id="ficbdistrito" name="ficbdistrito" placeholder="Distrito" required >
														<option value="0">Sin opciones</option>
													</select>
													<label for="ficbdistrito"> Distrito</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-12">
													<input autocomplete='off' data-currentvalue='0' class="form-control form-control-sm text-uppercase" id="fitxtdomiciliootro" name="fitxtdomiciliootro" type="text" placeholder="Otro domicilio"  required />
													<label for="fitxtdomiciliootro"> Otro domicilio</label>
												</div>
											</div>
											
										</form>

										<div class="row">
											<div class="col-12">
												<span id="fispedit" class="text-danger"></span>
											</div>
											<div class="col-12">
												<button id="btn-sugerecia-open" class="btn btn-primary btn-lg float-right ml-2" data-sugerencia='openfile'><i class="fas fa-user-plus"></i> Nuevo</button>
												<button id="btn-sugerecia-edit" class="btn btn-success btn-lg float-right ml-2" data-sugerencia='editfile'><i class="fas fa-user-edit"></i> Editar</button>
												<button id="btn-sugerecia-cancel" class="btn btn-danger btn-lg " data-sugerencia='cancelfile'><i class="fas fa-undo"></i> Cancelar</button>
												
												<button data-step='ins' type="button" class="btn btn-primary btn-lg float-right next ml-2"><i class="fas fa-save"></i> Guardar</button>
											</div>
										</div>
									</div>
									
									<!--INSCRIPCIONES-->
									<div class="step">
										<div class="row">
											<!--<span id="fispmcedit" class="text-danger"></span>-->
											<div class="col-12 text-center pb-2">
												<div class="card">
													<div class="card-body">
														<b class='text-danger'>
														Felcicitaciones, los datos personales fueron registrados correctamente.
														</b>
														<br>
														
													</div>
													
												</div>
												
											</div>
											
											<div class="col-12">
												<button  type="button" class="btn btn-primary btn-lg float-left msprevious-step">
												<i class="fas fa-arrow-circle-left"></i> Anterior
												</button>
												
											</div>
										</div>
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
<script src="<?php echo $vbaseurl ?>resources/plugins/form-multi-steps/form-ms.js"></script>

<script>
	$('#ficbstatrab').change(function(){
		var combo = $(this);
		var item = combo.val();
		var valor = $('#fitxtlugartrab').val();
		if (item =='SI') {
			$('#divcard_lugartrab').removeClass('d-none');
		} else {
			$('#divcard_lugartrab').addClass('d-none');
			$('#fitxtlugartrab').val("");
		}
	});
</script>
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/ficha-personal-docente.js"></script>
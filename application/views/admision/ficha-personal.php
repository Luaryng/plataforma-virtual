<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/form-multi-steps/form-ms.css">
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<!-- Main content -->
	<section class="content-header">
		
		<div class="modal fade" id="vw_md_search_reniec" tabindex="-1" role="dialog" aria-labelledby="vw_md_search_reniec" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	        <div class="modal-dialog modal-xl" role="document">
	            <div class="modal-content" id="vw_dp_mc_reniec">
	                <div class="modal-header">
	                    <h5 class="modal-title" id="divcard_title">Reniec</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    	<span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	                    <form id="frm_update_datosper" action="#" method="post" accept-charset="utf-8">
	                    	<div class="row">
								<div class="form-group has-float-label col-12  col-sm-2">
									<input autocomplete='off' data-currentvalue='' id="fidpidup" name="fidpidup" type="hidden" />
									<select class="form-control form-control-sm" id="ficbtipodocup" name="ficbtipodocup" placeholder="Tipo Doc." >
										<option value="DNI">DNI</option>
					                    <option value="CEX">Carné de Extranjería</option>
					                    <option value="PSP">Pasaporte</option>
					                    <option value="PTP">Permiso Temporal de Permanencia</option>
									</select>
									<label for="ficbtipodocup"> Tipo Doc.</label>
								</div>
								<div class="form-group has-float-label col-12  col-sm-2">
									<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtdniup" name="fitxtdniup" type="text" placeholder="DNI"  minlength="8" />
									<label for="fitxtdniup"> DNI</label>
								</div>
								<div class="col-12  col-sm-3">
									<button id="fibtnvalida-dniup" type="button" class="btn btn-primary btn-block btn-sm">
									Validar DNI
									</button>
								</div>
								<div class="input-group mb-3 col-12  col-sm-5 input-group-sm">
									<input autocomplete='off' data-currentvalue='' type="text" class="form-control form-control-sm" id="fitxtreniecup" disabled>
									<div class="input-group-append">
										<button id="fibtnaplica-reniecup" disabled="true" data-paterno='' data-materno='' data-nombres='' class="btn btn-info" type="button" ><i class="fas fa-check-double"></i></button>
									</div>
								</div>
							</div>
	                    	<hr>
	                    	<div class="row">
								<div class="form-group has-float-label col-12  col-sm-4">
									<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtapelpaternoup" name="fitxtapelpaternoup" type="text" placeholder="Ap. Paterno"  required />
									<label for="fitxtapelpaternoup">Ap. Paterno</label>
								</div>
								<div class="form-group has-float-label col-12  col-sm-4">
									<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtapelmaternoup" name="fitxtapelmaternoup" type="text" placeholder="Ap. Materno"  required />
									<label for="fitxtapelmaternoup">Ap. Materno</label>
								</div>
								<div class="form-group has-float-label col-12  col-sm-4">
									<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtnombresup" name="fitxtnombresup" type="text" placeholder="Nombres"  required />
									<label for="fitxtnombresup">Nombres</label>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<button type="button" id="vw_dp_mc_btn_actualizadatos" class="btn btn-primary float-right">Guardar</button>
								</div>
							</div>
	                    </form>
	                    <div class="row">
	                    	<div class="col-12 py-1">
								<small id="fmt_conteo_matriculas" class="form-text text-primary">
			            
				                </small>
				            </div>
			                <div class="col-12 py-1">
			                    <div class="btable">
			                        <div class="thead col-12  d-none d-md-block">
			                            <div class="row">
			                                <div class='col-12 col-md-6'>
			                                    <div class='row'>
			                                        <div class='col-2 col-md-2 td'>N°</div>
			                                        <div class='col-4 col-md-4 td'>CARNÉ</div>
			                                        <div class='col-6 col-md-6 td'>ALUMNO</div>
			                                    </div>
			                                </div>
			                                <div class='col-12 col-md-4'>
			                                    <div class='row'>
			                                        <div class='col-4 col-md-4 td'>PER.</div>
			                                        <div class='col-4 col-md-4 td'>PROG</div>
			                                        <div class='col-4 col-md-4 td'>CIC.</div>
			                                    </div>
			                                </div>
			                                <div class='col-12 col-md-2 text-center'>
			                                    <div class='row'>
			                                        <div class='col-12 col-md-12 td'>
			                                            <span></span>
			                                        </div>

			                                    </div>
			                                </div>
			                            </div>
			                            
			                        </div>
			                        <div class="tbody col-12" id="divres_matriculas">
			                            
			                        </div>
			                    </div>
			                </div>
		                </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	                </div>
	            </div>
	        </div>
	    </div>

		<div class="modal fade" id="vw_md_historial" tabindex="-1" role="dialog" aria-labelledby="vw_md_historial" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	        <div class="modal-dialog modal-xl" role="document">
	            <div class="modal-content" id="vw_dp_mc_inscripciones">
	                <div class="modal-header">
	                    <h5 class="modal-title" id="divcard_title">Historial de Inscripciones</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body" id="vw_dp_divHistorial_inscripciones">
	                    
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	                    <a id="vw_dp_mc_btn_nuevacarrrera" href="#" class="btn btn-primary">Nueva Inscripción</a>
	                </div>
	            </div>
	        </div>
	    </div>

    	<div class="modal fade" id="modretirainsc" tabindex="-1" role="dialog" aria-labelledby="modretirainsc" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		    <div class="modal-dialog modal-lg" role="document">
		        <div class="modal-content" id="divmodalretirar">
		            <div class="modal-header">
		                <h5 class="modal-title" id="divcard_title">INGRESE EL MOTIVO DEL RETIRO</h5>
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">&times;</span>
		                </button>
		            </div>
		            <div class="modal-body">
		                <form id="form_retira_insc" action="<?php echo $vbaseurl ?>inscrito/fn_retira_inscripcion" method="post" accept-charset="utf-8">
		                    <div class="row">
		                        <input type="hidden" name="fic_inscrip_codigo" id="fic_inscrip_codigo" value="">
		                        <input type="hidden" name="ficinscestado" id="ficinscestado" value="">
		                        <input type="hidden" name="ficinsperiodo" id="ficinsperiodo" value="">
		                        <div class="form-group has-float-label col-12">
		                            <textarea name="ficmotivretiro" id="ficmotivretiro" class="form-control form-control-sm" rows="3" placeholder="Motivo Retirado"></textarea>
		                            <label for="ficmotivretiro">Motivo Retirado</label>
		                        </div>
		                    </div>
		                </form>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		                <button data-tipodoc='' data-numero="" type="button" id="lbtn_retira_insc" data-coloran="" class="btn btn-primary">Retirar</button>
		            </div>
		        </div>
		    </div>
		</div>

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
												<div class="form-group has-float-label col-12 col-sm-12">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm" id="fitxtcolsecund" name="fitxtcolsecund" type="text" placeholder="Email Personal"  required />
													<label for="fitxtcolsecund">Colegio Secundario</label>
												</div>

												<div class="form-group has-float-label col-12  col-sm-2">
													<select class="form-control form-control-sm" id="ficbstatrab" name="ficbstatrab" >
														<option value="NO">NO</option>
														<option value="SI">SI</option>
													</select>
													<label for="ficbstatrab"> Trabaja</label>
												</div>
												<div class="form-group has-float-label col-12 col-sm-10 d-none" id="divcard_lugartrab">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm" id="fitxtlugartrab" name="fitxtlugartrab" type="text" placeholder="Empresa /Institución donde labora" />
													<label for="fitxtlugartrab">Empresa /Institución donde labora</label>
												</div>
												<div class="form-group has-float-label col-12 col-sm-3">
							                        <select data-currentvalue='' class="form-control form-control-sm" id="ficblenguas" name="ficblenguas" required="">
							                          	<option value="0">Selecciona</option>
							                          	<?php foreach ($dlenguas as $lg) { ?>
							                          	<option value="<?php echo $lg->codigo ?>"><?php echo $lg->nombre ?></option>
							                          	<?php } ?>
							                        </select>
							                        <label for="ficblenguas"> Lengua Originaria</label>
							                    </div>
							                    <div class="form-group has-float-label col-12 col-sm-7">
							                        <input type="text" name="ficbotrlenguas" id="ficbotrlenguas" placeholder="Otras lenguas" class="form-control form-control-sm">
							                        <label for="ficbotrlenguas"> Otras Lenguas</label>
							                    </div>
											</div>

											<b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> DATOS PADRES</b>
											<div class="row">
												<div class="form-group has-float-label col-12  col-sm-6">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtapelpatmatpa" name="fitxtapelpatmatpa" type="text" placeholder="Ap. Paterno"  required />
													<label for="fitxtapelpatmatpa">Apellidos y nombres (Padre)</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-6">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtocupadre" name="fitxtocupadre" type="text" placeholder="Ap. Paterno"  required />
													<label for="fitxtocupadre">Ocupación (Padre)</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-6">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtapelpatmatma" name="fitxtapelpatmatma" type="text" placeholder="Ap. Materno"  required />
													<label for="fitxtapelpatmatma">Apellidos y nombres (Madre)</label>
												</div>
												<div class="form-group has-float-label col-12  col-sm-6">
													<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtocumadre" name="fitxtocumadre" type="text" placeholder="Ap. Paterno"  required />
													<label for="fitxtocumadre">Ocupación (Madre)</label>
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

											<b class="pt-2 pb-3 text-danger d-block"><i class="fas fa-user-circle	"></i> DATOS DE CONTACTO</b>
											<div id="divdata_contacto">
												<div id="vw_fcb_rowitem0" class="row rowcolors vw_fcb_class_rowitem" data-arraypos="0">
													<input type="hidden" name="fictxtcodigo" value="0">
													<div class="form-group has-float-label col-12 col-sm-3">
														<select class="form-control form-control-sm" name="fictxttiporela">
															<option value="Tio">Tio</option>
															<option value="Mama">Mamá</option>
														</select>
														<label for="fictxttiporela"> Tipo relación</label>
													</div>
													<div class="form-group has-float-label col-12 col-sm-4">
														<input type="text" name="fictxtapenomcontac" placeholder="Apellidos y nombres" class="form-control form-control-sm">
														<label for="fictxtapenomcontac"> Apellidos y nombres</label>
													</div>
													<div class="form-group has-float-label col-12 col-sm-3">
														<input type="text" name="fictxtnumerocontac" placeholder="Apellidos y nombres" class="form-control form-control-sm">
														<label for="fictxtnumerocontac"> N° contacto</label>
													</div>
													<div class="col-12 col-sm-2">
														<button type="button" class="btn btn-sm btn-outline-primary btn_additem" onclick="fn_agrega_contacto($(this));return false;">
															<i class="fas fa-plus"></i>
														</button>
														<button type="button" class="btn btn-sm btn-outline-danger btn_deleteitem" onclick="fn_delete_values($(this));return false;">
															<i class="fas fa-trash-alt"></i>
														</button>
													</div>
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
														Felicitaciones, los datos personales fueron registrados correctamente.
														</b>
														<br>
														<button id="btn-agregar-prog" data-step='ins' type="button" class="btn btn-primary btn-lg">
														<i class="fas fa-address-card"></i> Agregar Programa
														</button>
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
<div id="vw_fcb_rowitem" class="row rowcolors vw_fcb_class_rowitem" data-arraypos="-1">
	<input type="hidden" name="fictxtcodigo" value="0">
	<div class="form-group has-float-label col-12 col-sm-3">
		<select class="form-control form-control-sm" name="fictxttiporela">
			<option value="Tio">Tio</option>
			<option value="Mama">Mamá</option>
		</select>
		<label for="fictxttiporela"> Tipo relación</label>
	</div>
	<div class="form-group has-float-label col-12 col-sm-4">
		<input type="text" name="fictxtapenomcontac" placeholder="Apellidos y nombres" class="form-control form-control-sm">
		<label for="fictxtapenomcontac"> Apellidos y nombres</label>
	</div>
	<div class="form-group has-float-label col-12 col-sm-3">
		<input type="text" name="fictxtnumerocontac" placeholder="Apellidos y nombres" class="form-control form-control-sm">
		<label for="fictxtnumerocontac"> N° contacto</label>
	</div>
	<div class="col-12 col-sm-2">
		<button type="button" class="btn btn-sm btn-outline-danger btn_deleteitem" onclick="fn_delete_contacto($(this));return false;">
			<i class="fas fa-trash-alt"></i>
		</button>
	</div>
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

	function cargar_historial_inscripciones(dni,tipo) {
			$('#vw_md_historial').modal('show') ;
	    $('#vw_dp_mc_inscripciones').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    //var fila=boton.closest('.rowcolor');
	    //var dni=fila.data('numero');
	    //var tipo=fila.data('tipodoc');
	    $("#vw_dp_divHistorial_inscripciones").html("");
	    $.ajax({
	        url: base_url + "inscrito/fn_get_inscripciones_x_dni_multisedes",
	        type: 'post',
	        dataType: 'json',
	        data: {
	        	ftxtdni: dni ,
	        	ftxttdoc: tipo},
	        success: function(e) {
	            $('#vw_dp_mc_inscripciones #divoverlay').remove();
	            if (e.status == false) {
	                
	                $("#vw_dp_divHistorial_inscripciones").html("Ocurrio un error");
	            } 
	            else {
	            	if (e.conteo>0){
	                $("#vw_dp_divHistorial_inscripciones").html(e.vdata);
	                $("#vw_dp_mc_btn_nuevacarrrera").attr('href', base_url + "admision/inscripciones/" + dni);
	            	}
	            	else{
	            		$('#vw_dp_mc_inscripciones').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	            			window.location.href =base_url + "admision/inscripciones/" + dni;
	            	}
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#vw_dp_mc_inscripciones #divoverlay').remove();
	            $("#divres-vw_dp_divHistorial_inscripciones").html("");
	            Swal.fire({
	                type: 'error',
	                title: 'Error, no se pudo mostrar los resultados',
	                text: msgf,
	                backdrop: false,
	            })
	        }
	    });
	}

	$('#modretirainsc').on('show.bs.modal', function (e) {
      var rel = $(e.relatedTarget);
      var div = rel.closest('.cfila');
      var codigo = div.data('ci');
      var periodo = div.data('cp');
      var estado = rel.data('ie');
      var color = rel.data('color');
      var dni=div.data('numero');
	    var tipo=div.data('tipodoc');
      //var fila=boton.closest('.rowcolor');
	    
      
      $('#fic_inscrip_codigo').val(codigo);

      $('#ficinscestado').val(estado);
      $('#lbtn_retira_insc').data('coloran', color);
      $('#lbtn_retira_insc').data("tipodoc",tipo);
      $('#lbtn_retira_insc').data("numero",dni);
      $('#ficinsperiodo').val(periodo);

  	});

  	$('#lbtn_retira_insc').click(function() {
      var color = $(this).data('coloran');
      var tipo=$('#lbtn_retira_insc').data("tipodoc");
      var dni=$('#lbtn_retira_insc').data("numero");

      $('#form_retira_insc input,select,textarea').removeClass('is-invalid');
      $('#form_retira_insc .invalid-feedback').remove();
      $('#divmodalretirar').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: $('#form_retira_insc').attr("action"),
          type: 'post',
          dataType: 'json',
          data: $('#form_retira_insc').serialize(),
          success: function(e) {
              $('#divmodalretirar #divoverlay').remove();
              if (e.status == false) {
                  $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                  });

                  Swal.fire({
                      title: e.msg,
                      // text: "",
                      type: 'error',
                      icon: 'error',
                  })
                  
              } else {
                  $('#modretirainsc').modal('hide');
                  cargar_historial_inscripciones(dni,tipo);


                  /*var btnret = $('#btnretira_inscrip'+e.idinscrip);
                  var btdt = btnret.parents(".btn-group").find('.dropdown-toggle');
                  var textoan = btnret.html();

                  btdt.removeClass('btn-danger');
                  btdt.removeClass('btn-success');
                  btdt.removeClass('btn-warning');
                  btdt.removeClass('btn-secondary');
                  btdt.removeClass('btn-info');

                  btdt.addClass(color);
                  btdt.html(textoan);

                  $('#btn-group-'+e.idinscrip+' .btn-cestado').hide();
                  $('#btn-group-'+e.idinscrip+' #btnretira_inscrip'+e.idinscrip).hide();
                  //btn-cestado
                  // $('#btn-group-'+e.idinscrip).hide();
                  // $('#btn-group-'+e.idinscrip).after('<button class="btn '+color+' btn-sm py-0" type="button"> '+
                  //     textoan+
                  //   '</button>');
                  
                  Swal.fire({
                      type: 'success',
                      icon: 'success',
                      title: 'Felicitaciones, inscripción cambio a retirado',
                      text: 'Se ha retirado la inscripción',
                      backdrop: false,
                  })*/
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'text');
              $('#divmodalretirar #divoverlay').remove();
              Swal.fire({
                  title: msgf,
                  // text: "",
                  type: 'error',
                  icon: 'error',
              })
          }
      });
      return false;
  	});

  	$('#vw_dp_mc_btn_actualizadatos').click(function(e) {
  		$('#frm_update_datosper input,select').removeClass('is-invalid');
        $('#frm_update_datosper .invalid-feedback').remove();
        $('#vw_dp_mc_reniec').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "admision/fn_update_datos_personales",
            type: 'post',
            dataType: 'json',
            data: $('#frm_update_datosper').serialize(),
            success: function(e) {
                $('#vw_dp_mc_reniec #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    // $('#modaddarea').modal('hide');
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            $('#divres_matriculas .btn_updpersonales').each(function () {
						        var boton = $(this);
						        boton.attr('disabled', false);
						    });
                        }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#vw_dp_mc_reniec #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
  	});

  	function get_data_matriculas(codigo, activo) {
  		$('#vw_dp_mc_reniec').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		
		$.ajax({
        	data: {
            	"txtcodigo": codigo
        	},
        	type: "POST",
        	dataType: "json",
        	url: base_url +  "admision/get_matriculasxpersona",
        	success: function(e) {
           		$('#vw_dp_mc_reniec #divoverlay').remove();
		        $('#vw_md_search_reniec').modal();

		        if (e.status == false) {
		            Swal.fire({
		                title: 'Error!',
		                text: "No se encontraron matriculas",
		                type: 'error',
		                icon: 'error',
		            })
		            
		        } else {
		            $('#divres_matriculas').html("");
		            var nro=0;
		            var tabla="";
		            if (e.vdata.length !== 0) {
		            	$('#fmt_conteo_matriculas').html('');
		                $.each(e.vdata, function(index, val) {
		                	nro++;
		                	tabla=tabla + 
		                        "<div class='row rowcolor cfila'>"+
		                            "<div class='col-12 col-md-6'>"+
		                                "<div class='row'>"+
		                                    "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
		                                    "<div class='col-4 col-md-4 td'>"+
		                                    	val['carne']+
		                                    "</div>"+
		                                    "<div class='col-6 col-md-6 td'>"+
		                                    	val['paterno'] + " " + val['materno'] + " " + val['nombres']+
		                                    "</div>"+
		                                "</div>"+
		                            "</div>"+
		                            "<div class='col-12 col-md-4'>"+
		                                "<div class='row'>"+
		                                	"<div class='col-4 col-md-4 td'>"+
		                                		val['periodo']+
		                                	"</div>"+
		                                    "<div class='col-4 col-md-4 td'>"+
		                                    	val['sigla']+
		                                    "</div>"+
		                                    "<div class='col-4 col-md-4 td'>"+
		                                    	val['ciclo']+
		                                    "</div>"+
		                                "</div>"+
		                            "</div>"+
		                            "<div class='col-12 col-md-2 text-center'>"+
		                                "<div class='row'>"+
		                                    "<div class='col-12 col-sm-12 td'>"+
		                                        "<button "+activo+" type='button' class='btn btn-success btn-sm px-3 btn_updpersonales' data-codmat='"+val['codigo64']+"' data-carne='"+val['carne']+"' data-persona='"+val['idper64']+"'>"+
			                            			"<i class='fas fa-edit text-white'></i>"+
			                            		"</button>"+
		                                    "</div>"+
		                                "</div>"+
		                            "</div>"+
		                        "</div>";
		                });

		                $('#divres_matriculas').html(tabla);

		                $('#fmt_conteo_matriculas').html('Se encontraron '+e.conteo+' matriculas');

		            } else {
		                $('#fmt_conteo_matriculas').html('No se encontraron matriculas');
		                $('#divres_matriculas').html("");
		            }
		            
		        }
        	},
        	error: function(jqXHR, exception) {
            	var msgf = errorAjax(jqXHR, exception,'text');
	          	$('#vw_dp_mc_reniec #divoverlay').remove();
	            Swal.fire({
	                title: msgf,
	                // text: "",
	                type: 'error',
	                icon: 'error',
	          	})
	        }
  		});
  		return false;
  	}

  	$(document).on('click', '.btn_updpersonales', function() {
		var btn = $(this);
        var apepaterno = $('#fitxtapelpaternoup').val();
        var apematerno = $('#fitxtapelmaternoup').val();
        var nombre = $('#fitxtnombresup').val();
        var codigo = btn.data('codmat');
        var carne = btn.data('carne');
        var persona = btn.data('persona');
        
        $('#vw_dp_mc_reniec').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        $.ajax({
            url: base_url + "admision/fn_update_datosper_matricula",
            type: 'post',
            dataType: "json",
            data: {
                fictxtcodigo:codigo, 
                fictxtnombre:nombre, 
                fictxtapepaterno:apepaterno,
                fictxtapematerno:apematerno,
            },
            success: function(e) {
                $('#vw_dp_mc_reniec #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        title: 'Error!',
                        text: "No se guardaron los cambios",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    
                    Swal.fire({
                    	title: 'ÉXITO!',
                        text: e.msg,
                        type: 'success',
                        icon: 'success',
                        allowOutsideClick: false,
                    }).then((result) => {
                      	if (result.value) {
                        	
                        	get_data_matriculas(persona, '');
                        	
                      	}
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#vw_dp_mc_reniec #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
	});

	var itemsDocumento = {};
	var itemsNro = 1;

	$(document).ready(function() {
		$("#vw_fcb_rowitem").hide();
	})

	function fn_agrega_contacto(btn) {
		var row = $("#vw_fcb_rowitem").clone();
		row.attr('id', 'vw_fcb_rowitem' + itemsNro);
	    row.data('arraypos', itemsNro);
	    itemsNro++;
	    
	    row.show();

	    $('#divdata_contacto').append(row);
	}

	function fn_delete_contacto(btn) {
		var fila = btn.closest('.rowcolors');
    	var pos = fila.data('arraypos');
    	fila.remove();
	}

	function fn_delete_values(btn) {
		var fila = btn.closest('.rowcolors');
		fila.find('input,select').val("");
	}

</script>
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/ficha-personal_1008.js"></script>
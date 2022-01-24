<?php
	$vbaseurl=base_url();
	date_default_timezone_set ('America/Lima');
	$codigo = "0";
	$sede="";
	$curso = "";
	$apepaterno="";
	$apematerno="";
	$nombres="";
	$tipodoc="";
	$nrodocum="";
	$genero="";
	$estadociv="";
	$fechanac="";
	$telefono="";
	$correoper="";
	$departam="";
	$provincia="";
	$distrito="";
	$direccion="";

	if (isset($ficha->codpre))  $codigo = base64url_encode($ficha->codpre);
	if (isset($ficha->sede))  $sede = $ficha->sede;
	if (isset($ficha->codcarrera))  $curso = $ficha->codcarrera;
	if (isset($ficha->paterno))  $apepaterno = $ficha->paterno;
	if (isset($ficha->materno))  $apematerno = $ficha->materno;
	if (isset($ficha->nombres))  $nombres = $ficha->nombres;
	if (isset($ficha->tipodoc))  $tipodoc = $ficha->tipodoc;
	if (isset($ficha->numero))  $nrodocum = $ficha->numero;
	if (isset($ficha->sexo))  $genero = $ficha->sexo;
	if (isset($ficha->estcivil))  $estadociv = $ficha->estcivil;
	if (isset($ficha->fecnac))  $fechanac = date("d/m/Y", strtotime($ficha->fecnac));
	if (isset($ficha->telefono))  $telefono = $ficha->telefono;
	if (isset($ficha->correo))  $correoper = $ficha->correo;
	if (isset($ficha->codepartamento))  $departam = $ficha->codepartamento;
	if (isset($ficha->codprovincia))  $provincia = $ficha->codprovincia;
	if (isset($ficha->coddistrito))  $distrito = $ficha->coddistrito;
	if (isset($ficha->direccion))  $direccion = $ficha->direccion;
	

?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/preinscripcion.css">
<script src="<?php echo $vbaseurl ?>resources/plugins/inputmask/jquery.inputmask.min.js"></script>
		<?php echo
		"<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>"; ?>
<div class="content-wrapper ">
<style type="text/css">
	.text-iesap {
		color: #ac1a25!important;
	}
	
</style>
	<!-- /.content-header -->
	<!-- Main content -->
	<div class="content">
		<div class="container">
			<div class="row">
				
				<div class="col-12 pt-2 ">
					<div class="card" id="divcard_prematricula">
						
						<div class="card-body px-4">
							<form id="form_prematricula" action="<?php echo $vbaseurl ?>curso_web/fn_insert" method="post" accept-charset="utf-8">
								<input type="hidden" name="fictxtcodigo_pre" id="fictxtcodigo_pre" value="<?php echo $codigo ?>">
								<div class="row">
									<div class="col-md-9">
										<h2 class="title-seccion text-iesap"><i class="fas fa-graduation-cap mr-1"></i> Inscripción para cursos cortos de Cocina</h2>
										
										<div class="row my-4">
											<div class="form-group col-md-5">
												<label class="m-0 " for="txt_sede">Sedes</label>
												<select name="txt_sede" id="txt_sede" class="form-control-plaintext border-bottom" data-dvcarga='divcard_datos'>
													<!-- <option value="">Elige una sede</option> -->
													<?php
													foreach ($sedes as $sed) {
														$selsed = ($sed->id == $sede) ? "selected" : "";
													echo '<option '.$selsed.' value="'.$sed->id.'">'.$sed->nombre.'</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group col-md-7">
												<label class="m-0 " for="cbocurso">Curso</label>
												<select name="cbocurso" id="cbocurso" class="form-control-plaintext border-bottom">
													<option value="">* Seleccione Curso</option>
													
												</select>
											</div>
										</div>
										
										<h2 class="title-seccion text-iesap"><i class="fas fa-user-check mr-1"></i> Acerca de ti</h2>
										<div class="row my-4">
											<div class="form-group col-md-4">
												<label class="m-0 " for="txtape_paterno">Apellido Paterno</label>
												<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtape_paterno" id="txtape_paterno" value="<?php echo $apepaterno ?>">
											</div>
											<div class="form-group col-md-4">
												<label class="m-0 " for="txtape_materno">Apellido Materno</label>
												<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtape_materno" id="txtape_materno" value="<?php echo $apematerno ?>">
											</div>
											<div class="form-group col-md-4">
												<label class="m-0 " for="txtnombres">Nombres</label>
												<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtnombres" id="txtnombres" value="<?php echo $nombres ?>">
											</div>
										</div>
										
										<div class="row mb-3">
											<div class="form-group col-md-3">
												<label class="m-0 " for="txt_tpdoc">Doc. Identidad</label>
												<select name="txt_tpdoc" id="txt_tpdoc" class="form-control-plaintext border-bottom">
													<option <?php echo ($tipodoc == "DNI") ? "selected" : ""; ?> value="DNI">DNI</option>
													<option <?php echo ($tipodoc == "CEX") ? "selected" : ""; ?> value="CEX">Carné de Extranjería</option>
													<option <?php echo ($tipodoc == "PSP") ? "selected" : ""; ?> value="PSP">Pasaporte</option>
												</select>
											</div>
											<div class="form-group col-md-3">
												<label class="m-0 " for="txtdni">Nro</label>
												<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" id="txtdni" name="txtdni" placeholder="45744627" value="<?php echo $nrodocum ?>">
											</div>
											
											<div class="form-group col-md-3">
												<label class="m-0 " for="txt_genero">Género</label>
												<select name="txt_genero" id="txt_genero" class="form-control-plaintext border-bottom">
													<option value="">Selecciona tu género</option>
													<option <?php echo ($genero == "MASCULINO") ? "selected" : ""; ?> value="MASCULINO">Masculino</option>
													<option <?php echo ($genero == "FEMENINO") ? "selected" : ""; ?> value="FEMENINO">Femenino</option>
												</select>
											</div>
											<div class="form-group col-md-3">
												<label class="m-0 " for="txtestcivil">Estado Civil</label>
												<select name="txtestcivil" id="txtestcivil" class="form-control-plaintext border-bottom">
													<option value="">Selecciona estado civil</option>
													<option <?php echo ($estadociv == "SOLTERO") ? "selected" : ""; ?> value="SOLTERO">SOLTERO(A)</option>
													<option <?php echo ($estadociv == "VIUDO") ? "selected" : ""; ?> value="CASADO">CASADO(A)</option>
													<option <?php echo ($estadociv == "VIUDO") ? "selected" : ""; ?> value="VIUDO">VIUDO(A)</option>
													<option <?php echo ($estadociv == "DIVORSIADO") ? "selected" : ""; ?> value="DIVORSIADO">DIVORSIADO(A)</option>
													<option <?php echo ($estadociv == "CONVIVIENTE") ? "selected" : ""; ?> value="CONVIVIENTE">CONVIVIENTE</option>
												</select>
											</div>
											
										</div>
										
									</div>
									<div class="col-md-3">
										<img src="<?php echo $vbaseurl ?>resources/img/estudiante.png" alt="student" class="img-fluid mt-5 d-none d-md-block">
									</div>
									<div class="col-12">
										<div class="row mb-3 mt-2">
											<div class="form-group col-md-3">
												<label class="m-0 " for="txt_fecnac">Fecha Nacimiento</label>
												<input autocomplete="off" class="form-control-plaintext border-bottom" id="txt_fecnac" name="txt_fecnac" maxlength="10" value="<?php echo $fechanac ?>">
											</div>

											<div class="form-group col-md-4">
												<label class="m-0 " for="txttelefono">Telefono/Celular</label>
												<input class="form-control-plaintext border-bottom" autocomplete="off" type="text" name="txttelefono" id="txttelefono" value="<?php echo $telefono ?>">
											</div>
											<div class="form-group col-md-5">
												<label class="m-0 " for="txtcorreo">Correo electrónico</label>
												<input class="form-control-plaintext border-bottom" autocomplete="off" type="email" name="txtcorreo" id="txtcorreo" placeholder="" value="<?php echo $correoper ?>">
											</div>
											
										</div>
										<h2 class="title-seccion text-iesap"><i class="fas fa-map-marker-alt mr-2"></i> ¿Donde Vives?</h2>
										<div class="row mb-3 my-4">
											<div class="form-group col-md-4">
												<input type="hidden" id="txtnomdepart" name="txtnomdepart">
												<label class="m-0 " for="txt_departamento">Departamento</label>
												<select onchange='fn_combo_ubigeo($(this));' name="txt_departamento" id="txt_departamento" class="form-control-plaintext border-bottom" data-tubigeo='departamento' data-cbprovincia='txt_provincia' data-cbdistrito='txt_distrito' data-dvcarga='divcard_data'>
													<option value="">Seleccione departamento</option>
													<?php
														foreach ($departamentos as $key => $dep) {
															$seldepart = ($dep->codigo == $departam) ? "selected" : "";
															echo '<option '.$seldepart.' value="'.$dep->codigo.'">'.$dep->nombre.'</option>';
														}
													?>
												</select>
											</div>

											<div class="form-group col-md-4">
												<input type="hidden" id="txtnomprovin" name="txtnomprovin">
												<label class="m-0 " for="txt_provincia">Provincia</label>
												<select onchange='fn_combo_ubigeo($(this));' name="txt_provincia" id="txt_provincia" class="form-control-plaintext border-bottom" data-tubigeo='provincia' data-cbdistrito='txt_distrito' data-dvcarga='divcard_data'>
													<option value="">Seleccione provincia</option>}
												</select>
											</div>

											<div class="form-group col-md-4">
												<input type="hidden" id="txtnomdistrito" name="txtnomdistrito">
												<label class="m-0 " for="txt_distrito">Distrito</label>
												<select onchange='fn_combo_ubigeo($(this));' name="txt_distrito" id="txt_distrito" class="form-control-plaintext border-bottom" data-tubigeo='distrito'>
													<option value="">Seleccione distrito</option>}
												</select>
											</div>
											
											<div class="form-group col-md-12">
												<label class="m-0 " for="txt_direccion">Dirección</label>
												<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txt_direccion" id="txt_direccion"  placeholder="Tacna 436" value="<?php echo $direccion ?>">
											</div>
										</div>

										<section id="vw_mpae_sec_adjuntar">
											<h2 class="title-seccion text-iesap"><i class="fas fa-paperclip mr-1"></i> Adjuntar Documentos</h2>
											<div class="row">
												
												<div class="col-lg-12">
													<div class="row">
														<div class="col-md-4">
															<h4>Requisitos</h4>
															<ul>
																<li>Copia de DNI</li>
															</ul>
														</div>
														<div class="col-md-5 mb-2">
															<label for="vw_mpc_txt_titulo">Paso 1: Describe el archivo antes de adjuntarlo.</label>
															<input type="text" autocomplete="off" name="vw_mpc_txt_titulo" id="vw_mpc_txt_titulo" class="form-control" placeholder="Ejemplo: Copia DNI" maxlength="200" autocomplete="off" >
														</div>
														<div class="col-md-3">
															<label class="d-block ">Paso 2: Adjunta el archivo</label>
															<button id="vw_mpc_btn_selecionar" role="button" class="btn btn-info"><i class="fas fa-paperclip mr-1"></i>
															Seleccionar archivo
															</button>
															<small class="d-block pt-2" id="vw_mpc_txt_filename"></small>
															<input type="file" class="form-control" name="vw_mpc_file" id="vw_mpc_file">
														</div>
														
													</div>
													<div class="row">
														<div class="col-12">
															<div id="vw_mpc_txt_progress"></div>
															<div id="vw_mpc_txt_size"></div>
															<div id="vw_mpc_txt_type"></div>
															<div id="vw_mpc_pgBar"></div>
														</div>
														<div class="col-12">
															<b>(Se permite adjuntar 1 archivo, con un máximo de 10 Mb) <br>
															* Solo se permiten los siguientes tipos de archivo: pdf,doc,docx,jpg,jpeg,png,txt.</b>
														</div>
													</div>
												</div>
												
												<div id="divcard_items" class="col-12"></div>
											</div>
											<div class="row text-bold border-bottom">
												<div class="col-5">
													Archivo
												</div>
												<div class="col-2">
													Tamaño
												</div>
												<div class="col-5">
													Descripción
												</div>
											</div>
											<div class="clearfix"></div>
											<div id="vw_mpc_lista">
												<?php 
												if ($codigo != "0") {
													foreach ($adjuntos as $key => $varch) {
														$pesoadj = number_format($varch->peso, 0);
														$codfile = base64url_encode($varch->codigo);
													echo "<div class='row border-bottom rowcolor p-2'>
			                								<div class='col-5'>$varch->archivo</div>
			                								<div class='col-2'>$pesoadj kb</div>
			                								<div class='col-5'>
			                									$varch->titulo
			                									<a href='#' class='float-right' data-link='$varch->link' data-codfile='$codfile' onclick='vw_mpa_fn_delfile($(this));event.preventDefault();' >
			                										<i class='far fa-trash-alt'></i>
			                									</a>
			                								</div>
			                							</div>";
			                						}
												}
												?>											
											</div>
											<div class="row mt-3">
												<div class="col-12 text-danger" >
													<small id="div_msjerror">
													
													</small>
												</div>
											</div>
											
											
										</section>
										
										
									</div>
									
									
								</div>
								<div class="row mt-3">
									<?php 
										if ($codigo !== "0"){ 
											$classcolum = "col-md-6 col-6";
									?>
									<div class="<?php echo $classcolum ?>">
										<small class="form-text text-muted">
											Para cancelar la actualización presiona el boton "Cancelar"
										</small>
										<button type="button" class="btn btn-danger btn-flat float-left btn-lg" id="btn_updatecancel"><i class="fa fa-times"></i> Cancelar</button>
									</div>
									<?php } else {
										$classcolum = "col-md-12 col-12";
									} ?>
									<div class="<?php echo $classcolum ?> text-right">
										<small class="form-text text-muted">
										Para finalizar tu ficha presiona el boton "Inscribirme"
										</small>
										<button type="submit" class="btn btn-primary btn-flat float-right btn-lg"><i class="fa fa-save"></i> Inscribirme</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#txt_sede').change();	
		if ('<?php echo $codigo ?>' != "0") {

			setTimeout(function() {
		        $('#cbocurso').val('<?php echo $curso ?>');
		        fn_combo_ubigeo($('#txt_departamento'));
		    },1000);

		    setTimeout(function() {
		        $('#txt_provincia').val('<?php echo $provincia ?>');
		        fn_combo_ubigeo($('#txt_provincia'));
		    },1500);

		    setTimeout(function() {
		        $('#txt_distrito').val('<?php echo $distrito ?>');
		        $('#txtnomdistrito').val($('select[name="txt_distrito"] option:selected').text());
		    },1700);

		    var vadjuntos = <?php echo json_encode($adjuntos, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
		    if (vadjuntos.length !== 0) {
		    	
		        $.each(vadjuntos, function(index, val) {
		        	var newarchivo = [val['link'], val['archivo'], val['peso'], val['tipo'], val['titulo']];
		        	arrayarchivos.push(newarchivo);
		        });
		    }

		}
	});

	$('#btn_updatecancel').click(function() {
		window.location = base_url +"formacion-continua/cursos/inscripciones";
	});

	$('#txt_sede').change(function(){
		var combo = $(this);
		var idsede = combo.val();
		var nmdiv=combo.data('dvcarga');
		$.ajax({
            url: base_url + 'curso_web/fn_cursos_sedes',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodigosed: idsede
            },
            success: function(e) {
                $('#' + nmdiv + ' #divoverlay').remove();
                $('#form_prematricula #cbocurso').html(e.vdata);
            },
            error: function(jqXHR, exception) {
                $('#' + nmdiv + ' #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#form_prematricula #cbocurso').html("<option value='0'>" + msgf + "</option>");
            }
        });
        return false;
	});

	function fn_combo_ubigeo(combo){
        if (combo.data('tubigeo') == "departamento") {
            var nmprov=combo.data('cbprovincia');
            var nmdist=combo.data('cbdistrito');
            var nmdiv=combo.data('dvcarga');
            $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $('#' + nmprov).html("<option value='0'>Sin opciones</option>");
            $('#form_prematricula #' + nmdist).html("<option value='0'>Sin opciones</option>");
            var coddepa = combo.val();
            
            if (coddepa == '0') return;
            $.ajax({
                url: base_url + 'ubigeo/fn_provincia_x_departamento',
                type: 'post',
                dataType: 'json',
                data: {
                    txtcoddepa: coddepa
                },
                success: function(e) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    $('#form_prematricula #' + nmprov).html(e.vdata);
                    $('#txtnomdepart').val($('select[name="txt_departamento"] option:selected').text());
                    
                },
                error: function(jqXHR, exception) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#form_prematricula #' + nmprov).html("<option value='0'>" + msgf + "</option>");
                }
            });
        } 
        else if (combo.data('tubigeo') == "provincia") {
            var nmdist=combo.data('cbdistrito');
            var nmdiv=combo.data('dvcarga');
            $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $('#form_prematricula #' + nmdist).html("<option value='0'>Sin opciones</option>");
            var codprov = combo.val();
            if (codprov == '0') return;
            $.ajax({
                url: base_url + 'ubigeo/fn_distrito_x_provincia',
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodprov: codprov
                },
                success: function(e) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    $('#form_prematricula #' + nmdist).html(e.vdata);
                    $('#txtnomprovin').val($('select[name="txt_provincia"] option:selected').text());
                    
                },
                error: function(jqXHR, exception) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#form_prematricula #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
                }
            });
        } 
        else if (combo.data('tubigeo') == "distrito") {
        	$('#txtnomdistrito').val($('select[name="txt_distrito"] option:selected').text());
        }
        return false;
    }

	$(document).ready(function() {
	    $("#vw_mpc_file").hide();
	    $("#vw_mpc_txt_size").hide();
	    $("#vw_mpc_txt_type").hide();
	    $("#txt_fecnac").inputmask("99/99/9999", {
	        "placeholder": "dd/mm/yyyy"
	    });
	});


	$('#form_prematricula').submit(function() {
	    $('#form_prematricula input,select').removeClass('is-invalid');
	    $('#form_prematricula .invalid-feedback').remove();
	    $('#divcard_prematricula').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    var formData = new FormData($("#form_prematricula")[0]);
	    formData.append('vw_mpc_archivos', JSON.stringify(arrayarchivos));
	    $.ajax({
	        url: $(this).attr("action"),
	        type: "post",
	        dataType: 'json',
	        data: formData,
	        cache: false,
	        contentType: false,
	        processData: false,
	        success: function(e) {
	            $('#divcard_prematricula #divoverlay').remove();
	            if (e.status == false) {
	                msjinput = "<b>Datos Incompletos</b>" + "<br>";
	                $.each(e.errors, function(key, val) {
	                    msjinput = msjinput + val;
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                    $('#' + key).focus();
	                });
	                $('#div_msjerror').html(msjinput)
	            } else {
	                /*var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgautores').html(msgf);*/
	                Swal.fire({
	                    title: e.msg,
	                    // text: "Por favor Agregue Ejemplares!",
	                    icon: 'success',
	                }).then((result) => {
	                    if (result.value) {
	                    	if (e.accion == "INSERTAR") {
	                    		location.reload();
	                    	} else {
	                    		window.location = base_url +"formacion-continua/cursos/inscripciones";
	                    	}
	                        
	                    }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divcard_prematricula #divoverlay').remove();
	            Swal.fire({
	                title: "Error",
	                text: msgf,
	                icon: 'error',
	            })
	        }
	    });
	    return false;
	});

	var arrayarchivos = [];
	$('#vw_mpc_file').change(function() {
	    if (arrayarchivos.length >= 1) {
	        Swal.fire({
	            icon: 'error',
	            title: 'Límite de 1 archivo',
	            text: 'Solo se puede adjuntar como máximo 1 archivo',
	            backdrop: false,
	        });
	        return;
	    }
	    $('#vw_mpc_txt_titulo').removeClass('is-invalid');
	    $('.invalid-feedback').remove();

	    $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $("#vw_mpc_file").simpleUpload(base_url + "curso_web/fn_upload_file_externo", {
	        allowedExts: ["jpg", "jpeg", "png", "txt", "pdf", "doc", "docx"],
	        //allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
	        maxFileSize: 10485760, //10MB in bytes
	        start: function(file) {
	            //upload started
	            $('#vw_mpc_txt_filename').html(file.name);
	            $('#vw_mpc_txt_size').html(file.size);
	            $('#vw_mpc_txt_type').html(file.type);
	            $('#vw_mpc_txt_progress').html("");
	            $('#vw_mpc_pgBar').width(0);
	            $('#vw_mpc_txt_progress').show();
	            $('#vw_mpc_pgBar').show();
	        },
	        progress: function(progress) {
	            //received progress
	            $('#vw_mpc_txt_progress').html("Progress: " + Math.round(progress) + "%");
	            $('#vw_mpc_pgBar').width(progress + "%");
	        },
	        success: function(data) {
	            //upload successful
	            //$('#progress').html("Success!<br>Data: " + JSON.stringify(data));
	            $('#vw_mpc_txt_progress').hide();
	            $('#vw_mpc_pgBar').hide();
	            //AGREGAR ARCVO A LA LISTA
	            //i.link,i.name,i.size,i.type,i.fileid
	            $('#divcard-general #divoverlay').remove();
	            var newarchivo = [data.link, $('#vw_mpc_txt_filename').html(), $('#vw_mpc_txt_size').html(), $('#vw_mpc_txt_type').html(), $('#vw_mpc_txt_titulo').val()];
	            arrayarchivos.push(newarchivo);
	            " "
	            $('#vw_mpc_lista').append("<div class='row border-bottom rowcolor p-2'>" +
	                "<div class='col-5'> " + $('#vw_mpc_txt_filename').html() + "</div>" +
	                "<div class='col-2'> " + $('#vw_mpc_txt_size').html() + " kb</div>" +
	                "<div class='col-5'> " + $('#vw_mpc_txt_titulo').val() + "<a href='#' class='float-right' data-link='" + data.link + "' data-codfile='0' onclick='vw_mpa_fn_delfile($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i></a></div>");
	            $('#vw_mpc_txt_titulo').val("");
	            $('#vw_mpc_txt_filename').html("");
	            $('#vw_mpc_txt_titulo').focus();
	        },
	        error: function(error) {
	            //upload failed
	            switch (error.name) {
	                case 'InvalidFileExtensionError':
	                    vmsg = "Este tipo de archivo no es admitido";
	                    break;
	                case 'MaxFileSizeError':
	                    vmsg = "El peso máximo permitido es de 10MB";
	                    break;
	                default:
	                    vmsg = error.message;
	            }
	            Swal.fire({
	                icon: 'error',
	                title: "Error! " + error.name,
	                text: vmsg,
	                backdrop: false,
	            });
	            $('#vw_mpc_txt_filename').html("");
	            $('#vw_mpc_txt_size').html("");
	            $('#vw_mpc_txt_type').html("");
	            $('#divcard-general #divoverlay').remove();
	        }
	    });
	});

	function vw_mpa_fn_delfile(btn) {
	    var link = btn.data('link');
	    var codigo = btn.data('codfile');
	    var n = 0;
    	$.ajax({
            url: base_url + 'curso_web/fn_delete_file_web',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodigo: codigo,
                archivo:link
            },
            success: function(e) {
                if (e.status == true) {
                	const Toast = Swal.mixin({
			          	toast: true,
			          	position: 'top-end',
			          	showConfirmButton: false,
			          	timer: 5000,
			        })

					Toast.fire({
					  	icon: 'success',
					  	type: 'success',
					  	title: e.msg,
					})
                }
                
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divcard_prematricula #divoverlay').remove();
	            Swal.fire({
	                title: "Error",
	                text: msgf,
	                icon: 'error',
	            })
            }
        });

	    arrayarchivos.forEach(function(afile) {
	        if (afile[0] === link) {
	            arrayarchivos.splice(n, 1);
	            btn.closest('.rowcolor').remove();
	        }
	        n++;
	    });

	}

	$('#vw_mpc_btn_selecionar').click(function(event) {
	    event.preventDefault();
	    $("#vw_mpc_file").trigger('click');
	});
</script>
<?php $vbaseurl=base_url(); ?>
<!-- /.navbar -->
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/preinscripcion.css">
<script src="<?php echo $vbaseurl ?>resources/plugins/inputmask/jquery.inputmask.min.js"></script>
		<?php echo
		"<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>"; ?>
<div class="content-wrapper ">

	<!-- /.content-header -->
	<!-- Main content -->
	<div class="content">
		<div class="container">
			<div class="row">
				
				<div class="col-12 pt-2 ">
					<div class="card" id="divcard_prematricula">
						
						<div class="card-body px-4">
							<form id="form_prematricula" action="<?php echo $vbaseurl ?>prematricula/fn_insert" method="post" accept-charset="utf-8">
								<div class="row">
									<div class="col-md-9">
										
										<h2 class="title-seccion"><i class="fas fa-graduation-cap mr-1"></i> Ficha de inscripción</h2>
										<div class="row my-4">
											<div class="form-group col-md-5">
												<label class="m-0 font-weight-normal" for="txt_periodo">Periodo</label>
												<select name="txt_periodo" id="txt_periodo" class="form-control-plaintext border-bottom">
													<option value="">Elige un periodo</option>
													<?php
													foreach ($periodos as $per) {
													echo '<option value="'.$per->codigo.'">'.$per->nombre.'</option>';
													}
													?>
												</select>
											</div>
										</div>
										<div class="row my-4">
											<div class="form-group col-md-5">
												<label class="m-0 font-weight-normal" for="txt_sede">Sedes</label>
												<select name="txt_sede" id="txt_sede" class="form-control-plaintext border-bottom" data-dvcarga='divcard_datos'>
													<option value="">Elige una sede</option>
													<?php
													foreach ($sedes as $sed) {
													echo '<option value="'.$sed->id.'">'.$sed->nombre.'</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group col-md-7">
												<label class="m-0 font-weight-normal" for="cbocarrera">Programa de estudios</label>
												<select name="cbocarrera" id="cbocarrera" class="form-control-plaintext border-bottom">
													<option value="">Seleccione programa</option>
													<?php
														// foreach ($carrera as $carr) {
														// 	echo '<option value="'.$carr->id.'">'.$carr->nombre.'</option>';
														// }
													?>
												</select>
											</div>
										</div>
										<div class="row my-4">
											<div class="form-group col-md-6">
												<label class="m-0 font-weight-normal" for="txt_modalidad">Modalidad</label>
												<select name="txt_modalidad" id="txt_modalidad" class="form-control-plaintext border-bottom">
													<option value="">Elige la modalidad</option>
													<?php
													foreach ($modalidad as $mod) {
													echo '<option value="'.$mod->id.'">'.$mod->nombre.'</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group col-md-3 d-none" id="divcard_ciclo">
												<label class="m-0 font-weight-normal" for="txt_ciclo">Ciclo</label>
												<select name="txt_ciclo" id="txt_ciclo" class="form-control-plaintext border-bottom">
													<option value="">Elige ciclo</option>
													<?php
													foreach ($ciclo as $cic) {
													echo '<option value="'.$cic->id.'">'.$cic->nombre.'</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group col-md-3">
												<label class="m-0 font-weight-normal" for="txt_turno">Turno</label>
												<select name="txt_turno" id="txt_turno" class="form-control-plaintext border-bottom">
													<option value="">Elige turno</option>
													<?php
													foreach ($turnos as $trn) {
													echo '<option value="'.$trn->codigo.'">'.$trn->nombre.'</option>';
													}
													?>
												</select>
											</div>
										</div>
										<div class="row mb-3 d-none" id="divcardinstituto">
											<div class="form-group col-md-12">
												<label class="m-0 font-weight-normal" for="txt_inst_traslado">Instituto de Traslado</label>
												<input class="form-control-plaintext border-bottom" type="text" name="txt_inst_traslado" id="txt_inst_traslado" placeholder="Instituto de Traslado">
											</div>
										</div>
										<h2 class="title-seccion"><i class="fas fa-user-check mr-1"></i> Acerca de ti</h2>
										<div class="row my-4">
											<div class="form-group col-md-4">
												<label class="m-0 font-weight-normal" for="txtape_paterno">Apellido Paterno</label>
												<input type="text" class="form-control-plaintext border-bottom" name="txtape_paterno" id="txtape_paterno"  placeholder="Ejemplo: Pérez">
											</div>
											<div class="form-group col-md-4">
												<label class="m-0 font-weight-normal" for="txtape_materno">Apellido Materno</label>
												<input type="text" class="form-control-plaintext border-bottom" name="txtape_materno" id="txtape_materno"  placeholder="Ejemplo: Gómez">
											</div>
											<div class="form-group col-md-4">
												<label class="m-0 font-weight-normal" for="txtnombres">Nombres</label>
												<input type="text" class="form-control-plaintext border-bottom" name="txtnombres" id="txtnombres"  placeholder="Ejemplo: Luis">
											</div>
										</div>
										
										<div class="row mb-3">
											<div class="form-group col-md-3">
												<label class="m-0 font-weight-normal" for="txt_tpdoc">Tipo Documento</label>
												<select name="txt_tpdoc" id="txt_tpdoc" class="form-control-plaintext border-bottom">
													<option value="">Elige tu tipo de doc.</option>
													<option value="CEX">Carnet de extranjería</option>
													<option value="DNI">DNI</option>
													<option value="PSP">Pasaporte</option>
												</select>
											</div>
											<div class="form-group col-md-3">
												<label class="m-0 font-weight-normal" for="txtdni">N° Documento</label>
												<input type="text" class="form-control-plaintext border-bottom" id="txtdni" name="txtdni" placeholder="Ejemplo: 45744627">
											</div>
											
											<div class="form-group col-md-3">
												<label class="m-0 font-weight-normal" for="txt_genero">Género</label>
												<select name="txt_genero" id="txt_genero" class="form-control-plaintext border-bottom">
													<option value="">Selecciona tu género</option>
													<option value="MASCULINO">Masculino</option>
													<option value="FEMENINO">Femenino</option>
												</select>
											</div>
											<div class="form-group col-md-3">
												<label class="m-0 font-weight-normal" for="txtestcivil">Estado Civil</label>
												<select name="txtestcivil" id="txtestcivil" class="form-control-plaintext border-bottom">
													<option value="">Selecciona estado civil</option>
													<option value="SOLTERO(A)">SOLTERO(A)</option>
													<option value="CASADO(A)">CASADO(A)</option>
													<option value="DIVORSIADO(A)">DIVORSIADO(A)</option>
													<option value="OTRO">OTRO</option>
												</select>
											</div>
											
										</div>
										<div class="row mb-3">
											<div class="form-group col-md-3">
												<label class="m-0 font-weight-normal" for="cbtrabaja">Trabaja</label>
												<select name="cbtrabaja" id="cbtrabaja" class="form-control-plaintext border-bottom">
													
													<option value="NO">NO</option>
													<option value="SI">SI</option>
												</select>
											</div>

											<div class="form-group col-md-9 d-none" id="divcard_empresa">
												<label class="m-0 font-weight-normal" for="txtlugtrabajo">Empresa /Institución donde labora</label>
												<input class="form-control-plaintext border-bottom" type="text" name="txtlugtrabajo" id="txtlugtrabajo" placeholder="Empresa /Institución donde labora">
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<img src="<?php echo $vbaseurl ?>resources/img/estudiante.png" alt="student" class="img-fluid mt-5 d-none d-md-block">
									</div>
									<div class="col-12">
										<div class="row mb-3 mt-2">
											<div class="form-group col-md-3">
												<label class="m-0 font-weight-normal" for="txt_fecnac">Fecha Nacimiento</label>
												<input autocomplete="off" class="form-control-plaintext border-bottom" id="txt_fecnac" name="txt_fecnac" maxlength="10" placeholder="Ejemplo: 31/05/1988">
											</div>
											<div class="form-group col-md-9">
												<label class="m-0 font-weight-normal" for="txtlugnac">Lugar de Nacimiento</label>
												<input class="form-control-plaintext border-bottom" type="text" name="txtlugnac" id="txtlugnac" placeholder="Ejemplo: Castilla">
											</div>
											

											<div class="form-group col-md-4">
												<label class="m-0 font-weight-normal" for="txttelefono">Telefono/Celular</label>
												<input class="form-control-plaintext border-bottom" type="text" name="txttelefono" id="txttelefono" placeholder="Ejemplo: 950730726">
											</div>
											<div class="form-group col-md-8">
												<label class="m-0 font-weight-normal" for="txtcorreo">Correo electrónico</label>
												<input class="form-control-plaintext border-bottom" type="email" name="txtcorreo" id="txtcorreo" placeholder="Ejemplo: luisgomez@gmail.com">
											</div>

											<div class="form-group col-md-6">
												<label class="m-0 font-weight-normal" for="txtapenompa">Apellidos y nombres (Padre)</label>
												<input class="form-control-plaintext border-bottom" type="text" name="txtapenompa" id="txtapenompa" placeholder="Apellidos y nombres (Padre)">
											</div>

											<div class="form-group col-md-6">
												<label class="m-0 font-weight-normal" for="txtapenomma">Apellidos y nombres (Madre)</label>
												<input class="form-control-plaintext border-bottom" type="text" name="txtapenomma" id="txtapenomma" placeholder="Apellidos y nombres (Madre)">
											</div>
											
										</div>
										<h2 class="title-seccion"><i class="fas fa-map-marker-alt mr-1"></i> ¿Donde Vives?</h2>
										<div class="row mb-3 mt-2">
											<div class="form-group col-md-4">
												<input type="hidden" id="txtnomdepart" name="txtnomdepart">
												<label class="m-0 font-weight-normal" for="txt_departamento">Departamento</label>
												<select onchange='fn_combo_ubigeo($(this));' name="txt_departamento" id="txt_departamento" class="form-control-plaintext border-bottom" data-tubigeo='departamento' data-cbprovincia='txt_provincia' data-cbdistrito='txt_distrito' data-dvcarga='divcard_data'>
													<option value="">Seleccione departamento</option>
													<?php
														foreach ($departamentos as $key => $dep) {
															echo '<option value="'.$dep->codigo.'">'.$dep->nombre.'</option>';
														}
													?>
												</select>
											</div>

											<div class="form-group col-md-4">
												<input type="hidden" id="txtnomprovin" name="txtnomprovin">
												<label class="m-0 font-weight-normal" for="txt_provincia">Provincia</label>
												<select onchange='fn_combo_ubigeo($(this));' name="txt_provincia" id="txt_provincia" class="form-control-plaintext border-bottom" data-tubigeo='provincia' data-cbdistrito='txt_distrito' data-dvcarga='divcard_data'>
													<option value="">Seleccione provincia</option>}
												</select>
											</div>

											<div class="form-group col-md-4">
												<input type="hidden" id="txtnomdistrito" name="txtnomdistrito">
												<label class="m-0 font-weight-normal" for="txt_distrito">Distrito</label>
												<select onchange='fn_combo_ubigeo($(this));' name="txt_distrito" id="txt_distrito" class="form-control-plaintext border-bottom" data-tubigeo='distrito'>
													<option value="">Seleccione distrito</option>}
												</select>
											</div>
											
											<div class="form-group col-md-12">
												<label class="m-0 font-weight-normal" for="txt_direccion">Dirección</label>
												<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txt_direccion" id="txt_direccion" placeholder="Ejemplo: Av. Tacna 436">
											</div>
										</div>

										<h2 class="title-seccion"><i class="fas fa-school mr-1"></i> ¿Donde estudiaste 5to de Secundaria?</h2>
										<div class="row my-4">
											<div class="form-group col-md-12">
												<label class="m-0 font-weight-normal" for="txt_centroestud">Último Colegio donde estudiaste 5to de Secundaria</label>
												<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txt_centroestud" id="txt_centroestud" placeholder="Ejemplo: I.E. Nuestra Señora de Fátima">
											</div>
										</div>
										<section id="vw_mpae_sec_adjuntar">
											<h2 class="title-seccion"><i class="fas fa-paperclip mr-1"></i> Adjuntar Documentos</h2>
											<div class="row">
												
												<div class="col-lg-12">
													<div class="row">
														<div class="col-md-4">
															<h4>Requisitos</h4>
															<ul>
																<li>Partida de Nacimiento</li>
																<li>Certificado original de Secundaria</li>
																<li>02 fotos</li>
																<li>Copia de DNI</li>
																<li>Voucher de pago del Derecho de Inscripción</li>
															</ul>
														</div>
														<div class="col-md-5 mb-2">
															<label for="vw_mpc_txt_titulo">Paso 1: Describe el archivo antes de adjuntarlo.</label>
															<input type="text" name="vw_mpc_txt_titulo" id="vw_mpc_txt_titulo" class="form-control" placeholder="Ejemplo: Foto de Partida de Nacimiento" maxlength="200" autocomplete="off" >
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
															<b>(Se permite adjuntar hasta 10 archivos, de 1 en 1, con un máximo de 10 Mb por cada uno) <br>
															* Solo se permiten los siguientes tipos de archivo: pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,txt.</b>
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
									<div class="col-md-12 text-right">
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
	$('#txt_sede').change(function(){
		var combo = $(this);
		var idsede = combo.val();
		var nmdiv=combo.data('dvcarga');
		$.ajax({
            url: base_url + 'prematricula/fn_carreras_sedes',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodigosed: idsede
            },
            success: function(e) {
                $('#' + nmdiv + ' #divoverlay').remove();
                $('#form_prematricula #cbocarrera').html(e.vdata);
            },
            error: function(jqXHR, exception) {
                $('#' + nmdiv + ' #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#form_prematricula #cbocarrera').html("<option value='0'>" + msgf + "</option>");
            }
        });
        return false;
	});

	$('#txt_modalidad').change(function(){
		var combo = $(this);
		var item = combo.val();
		if (item == "" || item == 1) {
			$('#divcard_ciclo').addClass('d-none');
			$("#txt_ciclo").prop("required",false);
			$('#divcardinstituto').addClass('d-none');
			$("#txt_inst_traslado").prop("required",false);
		} else if (item == 2) {
			$('#divcard_ciclo').removeClass('d-none');
			$("#txt_ciclo").prop("required",true);
			$('#divcardinstituto').removeClass('d-none');
			$("#txt_inst_traslado").prop("required",true);
			
			
		} else if (item == 3) {
			$('#divcard_ciclo').removeClass('d-none');
			$("#txt_ciclo").prop("required",true);
			$('#divcardinstituto').addClass('d-none');
			$("#txt_inst_traslado").prop("required",false);
		}
		
	});

	$('#cbtrabaja').change(function(){
		var combo = $(this);
		var item = combo.val();
		if (item =='SI') {
			$('#divcard_empresa').removeClass('d-none');
		} else {
			$('#divcard_empresa').addClass('d-none');
		}
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
	                        location.reload();
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
	    if (arrayarchivos.length >= 10) {
	        Swal.fire({
	            icon: 'error',
	            title: 'Límite de 10 archivos',
	            text: 'Solo se puede adjuntar como máximo 10 archivos',
	            backdrop: false,
	        });
	        return;
	    }
	    $('#vw_mpc_txt_titulo').removeClass('is-invalid');
	    $('.invalid-feedback').remove();

	    $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $("#vw_mpc_file").simpleUpload(base_url + "prematricula/fn_upload_file_externo", {
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
	                "<div class='col-5'> " + $('#vw_mpc_txt_titulo').val() + "<a href='#' class='float-right' data-link='" + data.link + "' onclick='vw_mpa_fn_delfile($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i></a></div>");
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
	    var n = 0;
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

<!-- Main Footer -->

<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->


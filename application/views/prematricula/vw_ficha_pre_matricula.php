<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>PRE-INSCRIPCIÓN | ERP</title>
		<?php $vbaseurl=base_url(); ?>
		<link rel="icon" type="image/png" href="<?php echo $vbaseurl.'resources/img/favicon.'.getDominio().'.png'?>" />
		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/fontawesome-free/css/all.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/adminlte.min.css">
		<!-- Google Font: Source Sans Pro -->
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.css">
		<script>
		var base_url = '<?php echo $vbaseurl; ?>';
		var getUrlParameter = function getUrlParameter(sParam,sDefault) {
		var params = new window.URLSearchParams(window.location.search);
		var param =params.get(sParam);
		return (param===null) ? sDefault : param;
		};
		function errorAjax(jqXHR, exception,msgtype) {
		var msg = '';
		if (jqXHR.status === 0) {
		msg = 'Conexión perdida.\n Verifica tu red y conexión al Servidor.';
		} else if (jqXHR.status == 404) {
		msg = 'Página no encontrada. [404]';
		} else if (jqXHR.status == 500) {
		msg = 'Internal Server Error [500].';
		} else if (exception === 'parsererror') {
		msg = 'Requested JSON parse failed1.';
		} else if (exception === 'timeout') {
		msg = 'Time out error.';
		} else if (exception === 'abort') {
		msg = 'Ajax request aborted.';
		} else {
		msg = 'Uncaught Error.\n' + jqXHR.responseText;
		}
		if (msgtype=='div'){
		return '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + msg + '</div>';
		}
		else
		{
		return msg;
		}
		
		
		}
		</script>
	</head>
	<style type="text/css">
		#div_msjerror p{
			margin: 0px;
		}
		input:focus, input:active {
			outline: none;
			}
		.title-seccion{
			font-weight:500;
			font-size: 2em;
			padding-top: 20px;
			color: gray;
		}
		.form-control-plaintext.is-invalid {
			border-bottom-color: #dc3545 !important;
		padding-right: 2.25rem;
		background-repeat: no-repeat;
		background-position: right calc(.375em + .1875rem) center;
		background-size: calc(.75em + .375rem) calc(.75em + .375rem);
		}
		#suggestions {
		box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
		height: auto;
		position: absolute;
		/*top: 45px;*/
		z-index: 9999;
		width: 300px;
		}
		
		#suggestions .suggest-element {
		background-color: #fff;
		/*border-top: 1px solid #d6d4d4;*/
		cursor: pointer;
		padding: 8px;
		width: 100%;
		float: left;
		}
		#suggestions .suggest-element:hover {
		background-color: #007bff;
		color: #fff;
		}
		#vw_mpc_pgBar {
			background-color: #3E6FAD;
			width: 0px;
			height: 10px;
			margin-top: 10px;
			margin-bottom: 10px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			-o-border-radius: 5px;
			border-radius: 5px;
			-moz-transition: .25s ease-out;
			-webkit-transition: .25s ease-out;
			-o-transition: .25s ease-out;
			transition: .25s ease-out;
		}
		#form_prematricula .progressBar {
			background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
			background-size: 1rem 1rem;
			background-color: #007bff!important;
		}
	</style>
	<body class="hold-transition layout-top-nav layout-navbar-fixxed ">
		
		<div class="wrapper ">
			<!-- Navbar -->
			
			<div class="container text-center text-lg-left">
				<img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png'?>" alt="AdminLTE Logo" class="img-fluid mr-3">
				<h3 class="d-inline-block"><?php echo $ies->denoml ?></h3>
				
			</div>
			
			<!-- /.navbar -->
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
														<div class="form-group col-md-6">
															<label class="m-0 font-weight-normal" for="cbocarrera">Programa de estudios</label>
															<select name="cbocarrera" id="cbocarrera" class="form-control-plaintext border-bottom">
																<option value="">Seleccione programa</option>
																<?php
																	foreach ($carrera as $carr) {
																		echo '<option value="'.$carr->id.'">'.$carr->nombre.'</option>';
																	}
																?>
															</select>
														</div>
													</div>
													<div class="row mb-3">
														<div class="form-group col-md-4">
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
															<label class="m-0 font-weight-normal" for="txt_fecnac">Fecha Nacimiento</label>
															<input type="date" class="form-control-plaintext border-bottom" id="txt_fecnac" name="txt_fecnac" placeholder="Ejemplo: 31/05/1988">
														</div>
														<div class="form-group col-md-3">
															<label class="m-0 font-weight-normal" for="txt_genero">Género</label>
															<select name="txt_genero" id="txt_genero" class="form-control-plaintext border-bottom">
																<option value="">Selecciona tu género</option>
																<option value="M">Masculino</option>
																<option value="F">Femenino</option>
															</select>
														</div>
													</div>
													<div class="row">
														<div class="form-group col-md-3">
															<label class="m-0 font-weight-normal" for="txttelefono">Telefono/Celular</label>
															<input class="form-control-plaintext border-bottom" type="text" name="txttelefono" id="txttelefono" placeholder="Ejemplo: 950730726">
														</div>
														<div class="form-group col-md-4">
															<label class="m-0 font-weight-normal" for="txtcorreo">Correo electrónico</label>
															<input class="form-control-plaintext border-bottom" type="email" name="txtcorreo" id="txtcorreo" placeholder="Ejemplo: luisgomez@gmail.com">
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<img src="<?php echo $vbaseurl ?>resources/img/estudiante.png" alt="student" class="img-fluid mt-5 d-none d-md-block">
												</div>
												<div class="col-12">
													<h2 class="title-seccion"><i class="fas fa-map-marker-alt mr-1"></i> ¿Donde Vives?</h2>
													<div class="row mb-3 mt-2">
														<div class="form-group col-md-12">
															<label class="m-0 font-weight-normal" for="txt_distrito">Distrito</label>
															<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txt_distrito" id="txt_distrito" placeholder="Ejemplo: Castilla - Piura - Piura">
															<div id="suggestions"></div>
														</div>
														
														<div class="form-group col-md-12">
															<label class="m-0 font-weight-normal" for="txt_direccion">Dirección</label>
															<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txt_direccion" id="txt_direccion" placeholder="Ejemplo: Av. Tacna 436">
														</div>
													</div>
													<h2 class="title-seccion"><i class="fas fa-school mr-1"></i> ¿Cuál es tu centro de estudios anterior?</h2>
													<div class="row my-4">
														<div class="form-group col-md-12">
															<label class="m-0 font-weight-normal" for="txt_centroestud">Último Colegio o Instituto en el que estudiaste</label>
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
  													Para fnalizar tu ficha presiona el boton "Inscribirme"
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
			<!-- Main Footer -->
			<footer class="main-footer">
				<!-- To the right -->
				<div class="float-right d-none d-sm-block">
					<b>Version</b> 1.0.0
				</div>
				<!-- Default to the left -->
				<strong>Copyright &copy; 2019 <a href="https://activaclic.com">activaclic.com</a>.</strong>
			</footer>
		</div>
		<!-- ./wrapper -->
		<!-- REQUIRED SCRIPTS -->
		<!-- jQuery -->
		<script src="<?php echo $vbaseurl ?>resources/plugins/jquery/jquery.min.js"></script>
		<!-- <script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.js"></script> -->
		<!-- Bootstrap 4 -->
		<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo $vbaseurl ?>resources/dist/js/adminlte.min.js"></script>
		<script src="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.js"></script>
		<?php echo
		"<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>"; ?>
		<script type="text/javascript">
			$(document).ready(function() {
			    $("#vw_mpc_file").hide();
			});
			$('#txt_distrito').on('keyup', function(ev) {
			    var key = $(this).val();
			    if ($("#txt_distrito").val().length >= 3) {
			        $.ajax({
			            url: base_url + "ubigeo/fn_distritos_all",
			            type: "POST",
			            dataType: 'json',
			            data: {
			                search: key
			            },
			            success: function(e) {

			                $('#suggestions').show();
			                $('#suggestions').html(e.vdata);
			                $('.suggest-element').on('click', function() {
			                    //Obtenemos la id unica de la sugerencia pulsada
			                    var id = $(this).attr('id');
			                    //Editamos el valor del input con data de la sugerencia pulsada
			                    $('#txt_distrito').val($('#' + id).attr('data'));
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(1000);
			                    $('#suggestions').html("")
			                });
			            },
			            error: function(jqXHR, exception) {
			                var msgf = errorAjax(jqXHR, exception, 'text');
			                //$('#divcard_prematricula #divoverlay').remove();
			                Swal.fire({
			                    title: "Error",
			                    text: msgf,
			                    icon: 'error',
			                });
			            }
			        });
			    } else if ($("#txt_distrito").val().length < 3) {
			        $('#suggestions').fadeOut(1000);
			        $('#suggestions').html("")
			    }
			    return false;
			});
			$('#form_prematricula').submit(function() {
			    $('#form_prematricula input,select').removeClass('is-invalid');
			    $('#form_prematricula .invalid-feedback').remove();
			    $('#divcard_prematricula').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			    var formData = new FormData($("#form_prematricula")[0]);
		   
		    	formData.append('vw_mpc_archivos', JSON.stringify(arrayarchivos));
			    $.ajax({
			        url: $(this).attr("action"),
			        type:"post",
			        dataType: 'json',
			        data: formData,
			        cache: false,
			        contentType: false,
			        processData: false,
			        success: function(e) {
			            $('#divcard_prematricula #divoverlay').remove();
			            if (e.status == false) {
			            	msjinput="<b>Datos Incompletos</b>" + "<br>";
			                $.each(e.errors, function(key, val) {
			                	msjinput= msjinput  + val;
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
			    /*if ($.trim($('#vw_mpc_txt_titulo').val())==""){
			    alert("Ingresa la descripción o nombre del archivo");
			    $('#vw_mpc_txt_titulo').addClass('is-invalid');
			    $('#vw_mpc_txt_titulo').parent().append("<div class='invalid-feedback'>Ingresa una descripción del archivo</div>");
			    $('#vw_mpc_txt_titulo').focus();
			    }
			    else{*/
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
		</body>
	</html>
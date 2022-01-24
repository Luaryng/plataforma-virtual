<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>MESA DE PARTES | Plataforma Virtual</title>
		<?php $vbaseurl=base_url() ?>
		<link rel="icon" type="image/png" href="<?php echo $vbaseurl.'resources/img/favicon.'.getDominio().'.png'?>" />
		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/fontawesome-free/css/all.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/adminlte.min.css">
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/private-v5.css">
		<!-- Google Font: Source Sans Pro -->
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.css">
		<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
	<style>
	.form-title{
	background-color: black;
	color: white;
	padding: 5px 0px 5px 10px;
	margin: 25px -10px 25px -10px;
	font-size: 16px;
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
	#frm-add-mesa .progressBar {
	background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
	background-size: 1rem 1rem;
	background-color: #007bff!important;
	}
	.title-mesa {
		font-size: calc(1rem + 1vw) !important;
	}

	#msgerrors p {
	    margin: 0px;
	}
	</style>
	<body class="hold-transition layout-top-nav">
		<div class="wrapper">
			<div class="container">
				<nav class="main-d navbar navbar-expand navbar-white navbar-light">
	    
				    <ul class="navbar-nav">
				      <li class="nav-item">
				        <img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png'?>" alt="AdminLTE Logo" class="img-fluid">
				      </li>
				    </ul>
				    <!-- <ul class="navbar-nav ml-auto">
				      <li class="nav-item">
				        <a href="<?php //echo base_url() ?>tramites/consultar/expediente" class="nav-link">Consultar Expendiente</a>
				      </li>
				      
				    </ul> -->
				</nav>

			
				<!-- Content Wrapper. Contains page content -->
				<?php $vbaseurl=base_url(); ?>
				<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
				<div class="content-wrapper">

					<div class="modal fade" id="modfiliales" role="dialog" aria-modal="true" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog">
							<div class="modal-content" id="divmodfilial">
								<div class="modal-header">
									<h6 class="modal-title text-secondary">Selecciona la oficina a donde enviaras tu tramite:</h6>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>
								<div class="modal-body" id="msgcuerpo">
									<div id="divcard_filial" class="mb-3 text-center">
										<?php
											foreach ($sedes as $sed) {
												echo "<div class='row mb-2 justify-content-center'>
														<div class='col-5'>
															<button class='btn btn-outline-info btn-block btn-filial' data-id='$sed->id'>$sed->nombre</button>
														</div>
													</div>";
											}
										?>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									<!-- <button type="button" class="btn btn-primary float-right" id="btn_select">Seleccionar</button> -->
								</div>
							</div>
						</div>
					</div>

					<section class="content-header">
						<div class="container-fluid">
							<div class="row">
								<div class="col-6 col-sm-6">
									<h1 class="title-mesa">MESA DE PARTES
									<small></small></h1>
								</div>
								<div class="col-6 col-sm-6 text-right">
									<a href="<?php echo base_url() ?>tramites/consultar/expediente" class="btn btn-tool btn-sm text-secondary">
										<i class="fas fa-eye"></i> Consultar Expendiente
									</a>
								</div>
							</div>
						</div>
					</section>
					<section class="content">
						<div id="divcard-general" class="card">
							<div class="card-header ">
								<h3 class="card-title">Nuevo Trámite</h3>
								<div class="card-tools text-right" id="divmsg_recuerda">
									
								</div>
							</div>
							
							<div class="card-body">
								<form id="frm-add-mesa" action="<?php echo $vbaseurl ?>mesa_partes/fn_insert_externo" method="post" accept-charset="utf-8">
									<div class="row">
										<label class="col-form-label-sm col-md-2" for="vw_mp_cb_sede">Sede / Filial</label>
										<select name="vw_mp_cb_sede" id="vw_mp_cb_sede" class="form-control form-control-sm col-md-4" data-dvcarga='vw_mp_txt_programa'>
											<?php
											foreach ($sedes as $sed) {
												echo '<option '.$selsed.' value="'.$sed->id.'">'.$sed->nombre.'</option>';
											}
											?>
										</select>
										<label class="col-md-2 col-form-label-sm ">Trámite:</label>
										<select class="form-control col-md-4 form-control-sm" name="vw_mp_cb_tramite" id="vw_mp_cb_tramite">
											<option value="">[--Seleccionar--]</option>
											<?php
											foreach ($tipos as $value) {
											echo '<option value="'.$value->id.'">'.$value->nombre.'</option>';
											}
											?>
										</select>
									</div>
									<div class="row">
										<label class=" col-md-2 col-form-label-sm">Asunto de la solicitud:</label>
										<input id="vw_mp_txt_asunto" name="vw_mp_txt_asunto" type="text" class="form-control form-control-sm col-md-10 " autocomplete="off" maxlength="200" minlength="5">
										<small class="col-md-12 text-primary text-right">Caracteres restantes: <span id="vw_mp_sm_conteo" >200</span></small>
									</div>

									<div class="row mt-2">
							            <div class="form-group col-md-4">
							              	<div class="row">
							                	<label class=" col-md-6 col-form-label-sm">Oficio N°:</label>
							                	<input id="vw_mp_txt_ndocument" name="vw_mp_txt_ndocument" type="text" class="form-control form-control-sm col-md-5">
							              	</div>
							            </div>
							            <div class="form-group col-md-3">
							              	<div class="row">
							                	<label class=" col-md-5 col-form-label-sm">N° Folios:</label>
							                	<input id="vw_mp_txt_folios" name="vw_mp_txt_folios" type="number" class="form-control form-control-sm col-md-6">
							              	</div>
							              
							            </div>
						            	
						          	</div>

									<section>
										<h5 class="form-title">Datos del Solicitante</h5>
										<div class="row">
											<div class="col-12">
												<div class="row">
													<label class="col-md-2 col-form-label-sm">Situación actual:</label>
													<select class="form-control col-md-10 form-control-sm" name="vw_mp_cb_situacion" id="vw_mp_cb_situacion">
														<option data-msg="" value="">[--Seleccionar--]</option>
														<option data-msg="Ingrese sus datos de estudiante" value="Soy estudiante Activo">Soy estudiante Activo</option>
														<option data-msg="Ingresar los datos del ultimo periodo y semestre que realizo" value="Soy Estudiante Retirado">Soy Estudiante Retirado</option>
														<option data-msg="" value="Soy Egresado">Soy Egresado</option>
														<option data-msg="" value="Soy Titulado">Soy Titulado</option>
														<option data-msg="" value="Otros">Otros</option>	
													</select>
												</div>
											</div>
											<div class="form-group col-md-4">
							              		<div class="row">
							                		<label class=" col-md-6 col-form-label-sm">Persona:</label>
							                		<select class="form-control col-md-5 form-control-sm" name="vw_mp_txt_tippersona" id="vw_mp_txt_tippersona">
									                  	<!-- <option value="">[--Seleccionar--]</option> -->
									                  	<option value="NATURAL">NATURAL</option>
									                  	<option value="JURIDICA">JURÍDICA</option>
									                </select>
							              		</div>
							            	</div>
											<div class="col-md-4">
												<div class="row">
													<label class="col-md-5 col-form-label-sm">Tipo de Doc.:</label>
													<select class="form-control col-md-6 form-control-sm" name="vw_mp_cb_tdoc" id="vw_mp_cb_tdoc">
														<?php
														echo
														"<option value='DNI'>DNI</option>
														<option value='CEX'>Carné de Extranjería</option>
														<option value='PSP'>Pasaporte</option>
														<option value='PTP'>Permiso Temporal de Permanencia</option>
														<option value='RUC'>RUC</option> ";
														?>
														
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<label class="col-md-5 col-form-label-sm">Número de Doc:</label>
													<input autocomplete="off" id="vw_mp_txt_nro_doc" name="vw_mp_txt_nro_doc" type="text" class="form-control col-md-7 form-control-sm" maxlength="20" minlength="5" >
													
												</div>
											</div>
										</div>
										<div class="row border-bottom border-top border-dark py-2 my-2" id="divdata_estud">
											<div class="col-12" id="divmsg_datos"></div>
											<div class="form-group col-md-4 divcarne">
							              		<div class="row">
							                		<label class=" col-md-6 col-form-label-sm">Carné:</label>
							                		<input autocomplete="off" id="vw_mp_txt_carne" name="vw_mp_txt_carne" type="text" class="form-control col-md-5 form-control-sm" maxlength="20" minlength="5" >
							                	</div>
							                </div>
							                <div class="col-md-4 divcampos">
												<div class="row">
													<label class="col-md-5 col-form-label-sm">Periodo:</label>
													<select class="form-control col-md-6 form-control-sm" name="vw_mp_txt_periodo" id="vw_mp_txt_periodo">
														<option value="">[--Seleccionar--]</option>
													<?php
														foreach ($periodos as $per) {
														echo "<option value='$per->codigo'>$per->nombre</option>";
														}
													?>
							                		</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<label class="col-md-5 col-form-label-sm">Programa:</label>
													<select class="form-control col-md-7 form-control-sm" name="vw_mp_txt_programa" id="vw_mp_txt_programa">
														<option value="">[--Seleccionar--]</option>
							                		</select>
												</div>
											</div>
											<div class="form-group col-md-4 divcampos">
							              		<div class="row">
							                		<label class=" col-md-6 col-form-label-sm">Semestre:</label>
													<select class="form-control col-md-5 form-control-sm" name="vw_mp_txt_semestre" id="vw_mp_txt_semestre">
														<option value="">[--Seleccionar--]</option>
													<?php
														foreach ($ciclos as $cic) {
														echo "<option value='$cic->codigo'>$cic->nombre</option>";
														}
													?>
							                		</select>
							                	</div>
							                </div>
							                <div class="col-md-4 divcampos">
												<div class="row">
													<label class="col-md-5 col-form-label-sm">Turno:</label>
													<select class="form-control col-md-6 form-control-sm" name="vw_mp_txt_turno" id="vw_mp_txt_turno">
														<option value="">[--Seleccionar--]</option>
													<?php
														foreach ($turnos as $tur) {
														echo "<option value='$tur->codigo'>$tur->nombre</option>";
														}
													?>
							                		</select>
												</div>
											</div>
											<div class="col-md-4 divcampos">
												<div class="row">
													<label class="col-md-5 col-form-label-sm">Sección:</label>
													<select class="form-control col-md-7 form-control-sm" name="vw_mp_txt_seccion" id="vw_mp_txt_seccion">
														<option value="">[--Seleccionar--]</option>
													<?php
														foreach ($secciones as $sec) {
														echo "<option value='$sec->codigo'>$sec->nombre</option>";
														}
													?>
							                		</select>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-md-2 col-form-label-sm">Apellidos y Nombres</label>
											<input autocomplete="off" id="vw_mp_txt_apelnom" name="vw_mp_txt_apelnom" type="text" class="form-control form-control-sm col-md-10 " maxlength="200" minlength="5">
										</div>
										<div class="form-group ">
											<label class="col-form-label-sm ">Contenido</label>
											<textarea name="vw_mp_txt_contenido" id="vw_mp_txt_contenido" class="form-control form-control-sm vw_mpae_txt_summernote"  rows="8" maxlength="2000"></textarea>
											<small class="text-primary">Caracteres restantes: <span id="vw_mp_sm_conteo_con" >2000</span></small>
										</div>
										<div class="row">
											<label class="col-md-2 col-form-label-sm">Domicilio:</label>
											<input autocomplete="off"  id="vw_mp_txt_domicilio" name="vw_mp_txt_domicilio" type="text" class="form-control col-md-10 form-control-sm" maxlength="200" minlength="5">
										</div>
										<div class="row">
											<span class="col-12 mb-1">
												Autorizo que las respuestas se remitan a esta dirección de correo (en caso no cuente con Cuenta en la Plataforma Virtual)
											</span>
											<label class="col-md-2 col-form-label-sm">Correo Personal:</label>
											<input autocomplete="off" id="vw_mp_txt_email" name="vw_mp_txt_email" type="text" class="form-control col-md-5 form-control-sm" maxlength="200" minlength="5" >
											<span class="col-12 col-md-5 font-weight-bold">* Puede ser de Gmail, Hotmail, Outlook, etc</span>
											
										</div>
										<div class="row">
											<label class="col-md-2 col-form-label-sm">Correo Institucional:</label>
											<input autocomplete="off" id="vw_mp_txt_email_corporativo" name="vw_mp_txt_email_corporativo" type="text" class="form-control col-md-5 form-control-sm" maxlength="200" minlength="5" >
											<span class="col-12 col-md-5 font-weight-bold">* Si eres estudiante activo del presente periodo también puedes ingresar tu correo <span class="text-primary">@<?php echo getDominio(); ?></span></span>
										</div>
										<div class="row">
											<label class="col-md-2 col-form-label-sm">Telefono/ Celular:</label>
											<input autocomplete="off" id="vw_mp_txt_celular" name="vw_mp_txt_celular" type="text" class="form-control col-md-10 form-control-sm" maxlength="200" minlength="5">
										</div>
										
									</section>
									
									<section id="vw_mpae_sec_adjuntar">
										<h5 class="form-title">Archivos a Adjuntar</h5>
										<div class="row">
											<div class="form-group col-lg-9">
												<div class="row">
													
													<div class="col-md-9 mb-2">
														<label for="vw_mpc_txt_titulo">Paso 1: Describe el archivo antes de adjuntarlo.</label>
														<input type="text" name="vw_mpc_txt_titulo" id="vw_mpc_txt_titulo" class="form-control" placeholder="Describe el archivo adjunto" maxlength="200" autocomplete="off" >
													</div>
													<div class="col-md-3">
														<label class="d-block ">Paso 2: Adjunta el archivo</label>
														<button id="vw_mpc_btn_selecionar" role="button" class="btn btn-info"><i class="fas fa-paperclip mr-1"></i>
														Seleccionar archivo
														</button>
														<small class="d-block pt-2" id="vw_mpc_txt_filename"></small>
														<input type="file" class="form-control" name="vw_mpc_file" id="vw_mpc_file">
													</div>
													<!--<div class="col-md-2">
														<div class="btn btn-success" id="vw_mpc_btn_adjuntar">
															<i class="fas fa-upload"></i> Adjuntar Prueba
														</div>
													</div>-->
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
											<div class="form-group col-lg-3 text-danger">
												<small  id="msgerrors"></small>
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
											<div class="col-12" id="divmsjinc">
												
											</div>
										</div>
										<div class="row mt-3">
											<div class="col-12">
												<a type="button" href="<?php echo $vbaseurl ?>tramites/mesa-de-partes" class="btn btn-danger btn-md float-left" ><i class="fas fa-undo"></i> Cancelar</a>
												<button type="submit" class="btn btn-primary btn-md float-right"><i class="far fa-paper-plane"></i> Enviar</button>
											</div>
										</div>
										
									</section>
								</form>
								<div id="divcard_msg" class="text-center">
									
								</div>
							</div>
							
						</div>
					</section>
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
		</div>
		<!-- ./wrapper -->
		<!-- REQUIRED SCRIPTS -->
		<!-- jQuery -->
		<script src="<?php echo $vbaseurl ?>resources/plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo $vbaseurl ?>resources/dist/js/adminlte.min.js"></script>
		<script src="<?php echo $vbaseurl ?>resources/plugins/sweetalert2/sweetalert2.min.js"></script>
		<script type="text/javascript" src="<?php echo $vbaseurl ?>resources/plugins/simpleUpload/simpleUpload.min.js"></script>
		<?php echo
		"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
		<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>
		<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>"; ?>
		<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
		    $('#vw_mpc_txt_progress').hide();
		    $('#vw_mpc_txt_size').hide();
		    $('#vw_mpc_txt_type').hide();
			$('#divdata_estud').hide();
			$('#vw_mp_cb_sede').change();

		    $('#vw_mpc_pgBar').hide();
		    $("#vw_mpc_file").hide();
		    $("#vw_mpae_div_descripcion").hide();
		    $("#vw_mpae_div_derivar").hide();
		    $.summernote.dom.emptyPara = "<div><br></div>"
		    $('.vw_mpae_txt_summernote').summernote({
		        height: 150,
		        placeholder: 'Escriba Aquí ...!',
		        dialogsFade: true,
		        lang: 'es-ES',
		        toolbar: [
		            ['font', ['bold', 'italic', 'underline', 'clear']],
		            ['insert', ['link', 'hr']],
		            ['view', ['codeview']],
		        ],
		        callbacks: {
		            onKeydown: function(e) {
		                var t = e.currentTarget.innerText;
		                if (t.trim().length >= 2000) {
		                    if (e.keyCode != 8)
		                        e.preventDefault();
		                }
		            },
		            onKeyup: function(e) {
		                var t = e.currentTarget.innerText;
		                $('.vw_mpae_txt_summernote').text(2000 - t.trim().length);
		                $("#vw_mp_sm_conteo_con").html(2000 - t.trim().length)
		            },
		            onPaste: function(e) {
		                var t = e.currentTarget.innerText;
		                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
		                e.preventDefault();
		                var all = t + bufferText;
		                if (all.length > 2000) {
		                    document.execCommand('insertText', false, bufferText.trim().substring(0, 2000 - t.length));
		                    $('.vw_mpae_txt_summernote').text(all.trim().substring(0, 2000));
		                } else {
		                    document.execCommand('insertText', false, bufferText);
		                    $('.vw_mpae_txt_summernote').text(all);
		                }
		            }
		        }
		    });

		    var lengthsedes = $('#vw_mp_cb_sede').children('option').length;
		    if (lengthsedes > 1) {
		    	$('#modfiliales').modal();
		    }
		    

		});

		$('.btn-filial').click(function(e) {
			var boton = $(this);
			var codigo = boton.data('id');
			$('#vw_mp_cb_sede').val(codigo);
			$('#modfiliales').modal('hide');
			$('#vw_mp_cb_sede').change();
		});
		
		$("#vw_mp_txt_asunto").keyup(function(event) {
		    $("#vw_mp_sm_conteo").html(200 - $(this).val().length);
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
		    $("#vw_mpc_file").simpleUpload(base_url + "mesa_partes/fn_upload_file_externo", {
		        allowedExts: ["jpg", "jpeg", "png", "txt", "pdf", "doc", "docx", "xls", "xlsx", "xlsm", "ppt", "pptx"],
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

		$("#frm-add-mesa").submit(function(event) {
		    var items = $('.activefile').length;
		    $('#frm-add-mesa input,select,textarea').removeClass('is-invalid');
		    $('#frm-add-mesa .invalid-feedback').remove();
		    $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		    var formData = new FormData($("#frm-add-mesa")[0]);
		   
		    formData.append('vw_mpc_archivos', JSON.stringify(arrayarchivos));
		    //formData.append('nrofiles',items);
		    $.ajax({
		        url: $("#frm-add-mesa").attr("action"), //$(this).attr("action"),
		        type: $("#frm-add-mesa").attr("method"), //'post',
		        dataType: 'json',
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function(e) {
		            $('#divcard-general #divoverlay').remove();
		            if (e.status == false) {
		            	msjinput = "<b>Datos Incompletos</b>" + "<br>";
		                $.each(e.errors, function(key, val) {
		                	msjinput = msjinput + val;
		                    $('#' + key).addClass('is-invalid');
		                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
		                });

		                $('#msgerrors').html(msjinput);
		                

		            } else {
		                var msgf = e.msg;
		                $("#frm-add-mesa").addClass('d-none');
		                $('#divmsg_recuerda').html(e.msgcnst);
		                $("#divcard_msg").html(msgf);

		            }
		        },
		        error: function(jqXHR, exception) {
		            var msgf = errorAjax(jqXHR, exception, 'text');
		            $('#divcard-general #divoverlay').remove();

		            Swal.fire({
		                icon: 'error',
		                title: 'Error',
		                text: msgf,
		                backdrop: false,
		            })
		        }
		    });
		    return false;
		});

		$('#vw_mp_cb_situacion').change(function(e){
			var combo = $(this);
			var item = combo.val();
			var mensaje = combo.children("option:selected").data('msg');

			if(item == "" || item =="Otros"){
				$('#divdata_estud').hide();
			} else {
				$('#divdata_estud').show();
				if(mensaje != "") {
					$('#divmsg_datos').html("<div class='my-2'><span class='text-primary font-weight-bold'>"+mensaje+"</span></div>");
					$('.divcampos').show();
				} else {
					$('#divmsg_datos').html("");
					$('.divcampos').hide();
					$('.divcampos .form-control').val("");
				}
				
			}
			
		});

		$('#vw_mp_cb_sede').change(function(e){
			var combo = $(this);
			var idsede = combo.val();
			var nmdiv=combo.data('dvcarga');
			$.ajax({
				url: base_url + 'mesa_partes/fn_carreras_sedes',
				type: 'post',
				dataType: 'json',
				data: {
					txtcodigosed: idsede
				},
				success: function(e) {
					$('#' + nmdiv + ' #divoverlay').remove();
					$('#frm-add-mesa #vw_mp_txt_programa').html(e.vdata);
				},
				error: function(jqXHR, exception) {
					$('#' + nmdiv + ' #divoverlay').remove();
					var msgf = errorAjax(jqXHR, exception, 'text');
					$('#frm-add-mesa #vw_mp_txt_programa').html("<option value='0'>" + msgf + "</option>");
				}
			});
			return false;
		})
		</script>
	</body>
</html>
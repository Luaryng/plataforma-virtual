<?php $vbaseurl=base_url() ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">
<!--<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">-->
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<style type="text/css">
	.tb_seguim::-webkit-scrollbar {
		width: 4px;
		/*height: 6px;*/
		background: #eee;
	border-radius: 4px;
	}
	.tb_seguim::-webkit-scrollbar-thumb {
	background: #ccc;
	border-radius: 4px;
	}
</style>
<div class="content-wrapper">
	<div class="modal fade" id="modseguimiento" role="dialog" aria-modal="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" id="divmodseguim">
				<div class="modal-header">
					<h4 class="modal-title">Seguimiento</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body" id="msgcuerpo">
					<div id="divcard_seguimiento" class="mb-3">
						
					</div><hr>
					<form id="frm_add_seguim" class="d-none" action="<?php echo $vbaseurl ?>prematricula/fn_insert_seguimiento" method="post" accept-charset='utf-8'>
						<b class="text-danger h6"><i class="fas fa-user-clock"></i> Ingresar seguimiento</b>
						<div class="row mt-3">
							<?php date_default_timezone_set ('America/Lima'); $fecha = date('Y-m-d'); $hora = date('H:i'); ?>
							<div class="form-group has-float-label col-6 col-sm-6">
								<input data-currentvalue='' class="form-control" id="fictxtfecha" name="fictxtfecha" type="date" placeholder="Fecha" value="<?php echo $fecha ?>" />
								<label for="fictxtfecha">Fecha</label>
							</div>
							<div class="form-group has-float-label col-6 col-sm-6">
								<input data-currentvalue='' class="form-control" id="fictxthora" name="fictxthora" type="time" placeholder="Hora" value="<?php echo $hora ?>" />
								<label for="fictxthora">Hora</label>
							</div>
						</div>
						<div class="row mt-2">
							<div class="form-group has-float-label col-12 col-sm-12">
								<textarea name="fictxtobserv" id="fictxtobserv" class="form-control" placeholder="Observación" rows="3"></textarea>
								<label for="fictxtobserv">Observación</label>
							</div>
						</div>
						<div class="row mt-3">
							<input id="fictxtcodigo" name="fictxtcodigo" type="hidden" value="" />
							<div class="form-group has-float-label col-12">
								<select name="cboficestado" id="cboficestado" class="form-control">
									<option value="">Seleccione estado</option>
									<option value="PENDIENTE">PENDIENTE</option>
									<option value="INSCRITO">INSCRITO</option>
									<option value="PROSPECTO">PROSPECTO</option>
									<option value="ANULADO">ANULADO</option>
								</select>
								<label for="cboficestado">Estado</label>
							</div>
							
						</div>
						
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary d-none float-right" id="btn_addseguim">Guardar</button>
					<button type="button" class="btn btn-primary float-right" id="btn_newseg">Nuevo</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="mod_archivos" role="dialog" aria-modal="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			

			<div id="modalc-archivos" class="modal-content">
				<div class="modal-header">
					
					<h3 class="modal-title"><i class="fas fa-graduation-cap mr-1"></i> Ficha de Pre Inscripción</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body" >
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button data-codpre='' id="vw_ppm_btn_form_aprobar" type="button" class="btn btn-primary" >Aprobar Inscripción</button>
				</div>
			</div>
			<div id="modalc-loading" class="modal-content">
				<
				<div class="modal-body text-center" >
					<h3 class="text-primary">Procesando</h3>
					<br>
					<span class="fa fa-spinner fa-spin fa-3x"></span>
					<br>
					<h3 class="text-primary">Espere un momento</h3>
					
				</div>
				
			</div>
		
			<div id="modalc-aprobar" class="modal-content">
				<div class="modal-header">
					
					<h3 class="modal-title"><i class="fas fa-graduation-cap mr-1"></i> Aprobar Pre Inscripción</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
				</div>
				<form id="frmins-inscripcion" action="<?php echo $vbaseurl ?>inscrito/fn_insert" method="post" accept-charset='utf-8'>
					<div class="modal-body">
					
					
					</div>
				</form>

				<div class="modal-footer ">
			
						<div class="col-12 text-danger" >
							<small id="div_msjerror">
							
							</small>
						</div>
						<div class="col-12 text-right">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button data-codpre='' id="vw_ppm_btn_aprobar" type="button" class="btn btn-primary" >Inscribir</button>
						</div>
					
					
					
				</div>
			</div>
		</div>
	</div>
	<!--<div class="modal fade" id="mod_aprobar" role="dialog" aria-modal="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
					
			</div>
	</div>-->
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-list mr-1"></i> BÚSQUEDA DE PRE INSCRIPCIONES</h3><br>
				<span><?php echo $vbaseurl."pre-inscripcion" ?></span>
			</div>
			<div class="card-body">
				<form id="frm-filtro-pre-inscritos" action="<?php echo $vbaseurl ?>prematricula/get_filtrar_historial" method="post" accept-charset="utf-8">
					<div class="row">
						<div class="form-group has-float-label col-lg-4 col-md-6 col-sm-6">
							<input autocomplete="off" class="form-control" type="text" placeholder="Apellidos y nombres" name="txtapenombres" id="txtapenombres">
							<label for="txtapenombres">Apellidos y nombres</label>
						</div>
						<div class="form-group has-float-label col-lg-8 col-md-6 col-sm-6">
							<select name="cboprograma" id="cboprograma" class="form-control">
								<option value="%">Todos</option>
								<?php
									foreach ($carrera as $carr) {
										echo '<option value="'.$carr->id.'">'.$carr->nombre.'</option>';
									}
								?>
							</select>
							<label for="cboprograma">Programa de estudios</label>
						</div>
						<div class="form-group has-float-label col-lg-4 col-md-4 col-sm-4 col-6">
							<select name="cboperiodo" id="cboperiodo" class="form-control">
								<option value="%">Todos</option>
								<?php
									foreach ($periodo as $per) {
										echo '<option value="'.$per->codigo.'">'.$per->nombre.'</option>';
									}
								?>
							</select>
							<label for="cboperiodo">Periodo</label>
						</div>
						<div class="form-group has-float-label col-lg-4 col-md-4 col-sm-4 col-6">
							<select name="cbotipo" id="cbotipo" class="form-control">
								<option value="%">Todos</option>
								<option value="PREINSCRIPCION">PREINSCRIPCION</option>
								<option value="INFORMES">INFORMES</option>
								
							</select>
							<label for="cbotipo">Tipo</label>
						</div>
						<div class="form-group has-float-label col-lg-4 col-md-4 col-sm-4">
							<select name="cboestado" id="cboestado" class="form-control">
								<option value="%">Todos</option>
								<option value="PENDIENTE">PENDIENTE</option>
								<option value="INSCRITO">INSCRITO</option>
								<option value="PROSPECTO">PROSPECTO</option>
								<option value="ANULADO">ANULADO</option>
							</select>
							<label for="cboestado">Estado</label>
						</div>
					</div>
					<div class="row">
						
						<div class="form-group has-float-label col-lg-4 col-md-4 col-sm-6 col-6">
							<input class="form-control" type="date" name="txtfecha" id="txtfecha">
							<label for="txtfecha">Desde</label>
						</div>
						<div class="form-group has-float-label col-lg-4 col-md-4 col-sm-6 col-6">
							<input class="form-control" type="date" name="txtfechafin" id="txtfechafin" >
							<label for="txtfechafin">Hasta</label>
						</div>
						<div class="col-sm-4">
							<button class="btn btn-flat btn-info" type="submit" >
							<i class="fas fa-search"></i>
							Buscar
							</button>
							<a href="#" class="btn-excel btn btn-outline-secondary float-rsight"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" class="float-left" alt=""> Exportar</a>
							
						</div>
					</div>
					<div class="row">
						<div class="col-12">
						<a href="<?php echo $vbaseurl."admision/ficha-pre-inscripcion" ?>" class="btn btn-primary float-right"><i class="fas fa-user-plus mr-1"></i> Agregar</a>
						</div>
					</div>
				</form>

				<div class="card-body pt-2 px-0 pb-0">
					<div class="row">
						<div class="col-12 py-1" id="divres-historial">
							
							
							<?php include 'dtshistorial_pre.php' ?>
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
</div>
<!--<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>-->
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script type="text/javascript">

	$("#modalc-loading").hide();
	$("#frm-filtro-pre-inscritos").submit(function(event) {
	    $('#frm-filtro-pre-inscritos input,select').removeClass('is-invalid');
	    $('#frm-filtro-pre-inscritos .invalid-feedback').remove();
	    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divboxhistorial #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                $("#divres-historial").html("");
	            } else {
	                $("#divres-historial").html(e.vdata);
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divboxhistorial #divoverlay').remove();
	            $("#divres-historial").html("");
	            Swal.fire({
	                icon: 'error',
	                title: 'Error, no se pudo mostrar los resultados',
	                text: msgf,
	                backdrop: false,
	            })
	        }
	    });
	    return false;
	});
	$(".btn-excel").click(function(e) {
	    e.preventDefault();
	    $('#frm-filtro-pre-inscritos input,select').removeClass('is-invalid');
	    $('#frm-filtro-pre-inscritos .invalid-feedback').remove();
	    var accion = "";
	    if (($("#txtfecha").val() != "") || ($("#txtfechafin").val() != "")) {
	        accion = 'SI';
	        var url = base_url + 'admision/pre-inscripciones/excel?cp=' + $("#cboperiodo").val() + '&cc=' + $("#cboprograma").val() + '&ap=' + $("#txtapenombres").val() + '&tip=' + $("#cbotipo").val() + '&status=' + $("#cboestado").val() + '&fec1=' + $("#txtfecha").val() + '&fec2=' + $("#txtfechafin").val() + '&acc=' + accion;
	        var ejecuta = false;
	        if (($("#txtfecha").val() != "") || ($("#txtfechafin").val() != "")) {
	            ejecuta = true;
	        } else {
	            $('#txtfecha').addClass('is-invalid');
	            $('#txtfecha').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
	            $('#txtfechafin').addClass('is-invalid');
	            $('#txtfechafin').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
	        }
	    } else {
	        accion = 'NO';
	        var url = base_url + 'admision/pre-inscripciones/excel?cp=' + $("#cboperiodo").val() + '&cc=' + $("#cboprograma").val() + '&ap=' + $("#txtapenombres").val() + '&tip=' + $("#cbotipo").val() + '&status=' + $("#cboestado").val() + '&acc=' + accion;
	        var ejecuta = false;
	        if ($.trim($("#txtapenombres").val()) == '%%%%') {
	            if (($("#cboperiodo").val() != "%") || ($("#cboprograma").val() != "%")) {
	                ejecuta = true;
	            } else {
	                $('#cboprograma').addClass('is-invalid');
	                $('#cboprograma').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
	                $('#cboperiodo').addClass('is-invalid');
	                $('#cboperiodo').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
	            }
	        } else if ($.trim($("#txtapenombres").val()).length > 3) {
	            ejecuta = true;
	        } 
	        else {
	            // $('#txtapenombres').addClass('is-invalid');
	            // $('#txtapenombres').parent().append("<div class='invalid-feedback'> Ingrese mínimo 4 caracteres o %%%%</div>");
	            ejecuta = true;
	        }
	    }
	    if (ejecuta == true) window.open(url, '_blank');
	});
	//  	$('#modseguimiento').on('show.bs.modal', function (e) {
	//     var rel=$(e.relatedTarget);
	//     $("#fictxtcodigo").val(rel.data("id"));
	// });
	$('#modseguimiento').on('hidden.bs.modal', function(e) {
	    $('#frm_add_seguim input,select,textarea').removeClass('is-invalid');
	    $('#frm_add_seguim .invalid-feedback').remove();
	    $('#frm_add_seguim')[0].reset();
	    $('#frm_add_seguim').addClass('d-none');
	    $('#btn_addseguim').addClass('d-none');
	    $('#btn_newseg').removeClass('d-none');
	})

	$("#vw_ppm_btn_form_aprobar").click(function(event) {
	    event.preventDefault();
	    var codpre = $(this).data('codpre')
	    //$('#divcard_seguimiento').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $('#modalc-archivos').hide();
	    $("#modalc-loading").show();
	    $.ajax({
	        url: base_url + 'prematricula/vw_aprobar_preinscripcion',
	        type: 'post',
	        dataType: 'json',
	        data: {
	            txtcodigo: codpre
	        },
	        success: function(e) {
	            $("#modalc-loading").hide();
	            if (e.status == true) {
	                //location.href = base_url + "admision/inscripciones";


	                //$('#mod_archivos').modal('show');
	                
	                $('#modalc-aprobar').show();
	                $('#modalc-aprobar .modal-body').html(e.form);
	                $('#div_msjerror').html("");
	            } else {
	            	$('#modalc-archivos').show();
	                Swal.fire({
	                    title: e.msg,
	                    type: 'warning',
	                    icon: 'warning',
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	        	$("#modalc-loading").hide();
	            $('#modalc-archivos').show();
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            Swal.fire({
	                    title: msgf,
	                    type: 'warning',
	                    icon: 'warning',
	                })
	        }
	    });
	    return false;
	    /* Act on the event */
	});
	$("#vw_ppm_btn_aprobar").click(function(event) {
		$("#modalc-loading").show();
		$("#modalc-aprobar").hide();
	    $('#frmins-inscripcion input,select').removeClass('is-invalid');
		$('#frmins-inscripcion .invalid-feedback').remove();
	    var codpre = $(this).data('codpre');

	    Arrdocs = [];
	    $.each($("#ficbsdocanexados option:selected"), function() {
	        Arrdocs.push($(this).val());
	    });

	    adocs= JSON.stringify(Arrdocs);
	    //var formData = new FormData($("#frmins-inscripcion")[0]);
	    var fdata = $("#frmins-inscripcion").serializeArray() 
	    fdata.push({name: 'txtcodigo', value: codpre},{name: 'doc-anexados', value: adocs});
      	
	    
	    $.ajax({
	        url: base_url + 'prematricula/fn_aprobar_preinscripcion',
	        type: 'post',
	        dataType: 'json',
	        data: fdata,
	        success: function(e) {
	        	$("#modalc-loading").hide();
	            if (e.status == true) {
	                location.href = base_url + "admision/inscripciones?fcarnet="+e.newcarnet;
	            } else {
	            	$("#modalc-aprobar").show();
	                Swal.fire({
	                    title: e.msg,
	                    type: 'warning',
	                    icon: 'warning',
	                });
	                 msjinput = "<b>Datos Incompletos</b>" + "<br>";
	                $.each(e.errors, function(key, val) {
	                    msjinput = msjinput + val;
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                    $('#' + key).focus();
	                });
	                $('#div_msjerror').html(msjinput)
	            }
	        },
	        error: function(jqXHR, exception) {
	            $("#modalc-loading").hide();
				$("#modalc-aprobar").show();
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#div_msjerror').html(msgf);
	            Swal.fire({
	                    title: msgf,
	                    type: 'error',
	                    icon: 'error',
	                });
	        }
	    });
	    return false;
	    /* Act on the event */
	});

	function viewseguimiento(codigo, estado) {
	    $('#divcard_seguimiento').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    // var codigo = $(this).data('id');
	    // var estado = $(this).data('estado');
	    $.ajax({
	        url: base_url + 'prematricula/fn_search_seguimiento',
	        type: 'post',
	        dataType: 'json',
	        data: {
	            txtcodigo: codigo
	        },
	        success: function(e) {
	            $('#divcard_seguimiento #divoverlay').remove();
	            $('#modseguimiento').modal('show');
	            $("#fictxtcodigo").val(codigo);
	            $('#cboficestado').val(estado);
	            if (e.status == true) {
	                $('#divcard_seguimiento').html(e.vdata);
	            } else {
	                $('#divcard_seguimiento').html(e.vdata);
	            }
	        },
	        error: function(jqXHR, exception) {
	            $('#divcard_seguimiento #divoverlay').remove();
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divcard_seguimiento').html(msgf);
	        }
	    });
	    return false;
	}

	function viewarchivos(codigo) {
	    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + 'prematricula/fn_view_archivos_adjuntos',
	        type: 'post',
	        dataType: 'json',
	        data: {
	            txtcodigo: codigo
	        },
	        success: function(e) {
	            $('#divboxhistorial #divoverlay').remove();
	            $('#mod_archivos').modal('show');
	            if (e.status == true) {
	                $('#modalc-archivos').show();
	                $('#modalc-aprobar').hide();
	                $('#modalc-archivos .modal-body').html(e.vdata);
	                $('#vw_ppm_btn_aprobar').data('codpre', codigo);
	                $('#vw_ppm_btn_form_aprobar').data('codpre', codigo);

	            } else {
	                $('#modalc-archivos .modal-body').html(e.msg);
	                $('#vw_ppm_btn_aprobar').data('codpre', "");
	                $('#vw_ppm_btn_form_aprobar').data('codpre', "");
	            }
	        },
	        error: function(jqXHR, exception) {
	            $('#mod_archivos').modal('show');
	            $('#divboxhistorial #divoverlay').remove();
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divcard_archivos').html(msgf);
	        }
	    });
	    return false;
	}
	$('#btn_newseg').click(function() {
	    $('#btn_newseg').addClass('d-none');
	    $('#btn_addseguim').removeClass('d-none');
	    $('#frm_add_seguim')[0].reset();
	    $('#frm_add_seguim').removeClass('d-none');
	});
	$('#btn_addseguim').click(function() {
	    $('#frm_add_seguim input,select,textarea').removeClass('is-invalid');
	    $('#frm_add_seguim .invalid-feedback').remove();
	    $('#divmodseguim').append('<div id="divoverlay" class="overlay "><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $('#frm_add_seguim').attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_add_seguim').serialize(),
	        success: function(e) {
	            $('#divmodseguim #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	            } else {
	                $('#modseguimiento').modal('hide');
	                var btn = $('#btn-' + $('#fictxtcodigo').val());
	                var eli = btn.parents('#parent-' + $('#fictxtcodigo').val());
	                eli.find('.text-status').html($('#cboficestado').val());
	                eli.find('.text-status').removeClass('bg-info');
	                eli.find('.text-status').removeClass('bg-success');
	                eli.find('.text-status').removeClass('bg-primary');
	                eli.find('.text-status').removeClass('bg-danger');
	                if ($('#cboficestado').val() == "PENDIENTE") {
	                    eli.find('.text-status').addClass('bg-info');
	                } else if ($('#cboficestado').val() == "INSCRITO") {
	                    eli.find('.text-status').addClass('bg-success');
	                } else if ($('#cboficestado').val() == "PROSPECTO") {
	                    eli.find('.text-status').addClass('bg-primary');
	                } else if ($('#cboficestado').val() == "ANULADO") {
	                    eli.find('.text-status').addClass('bg-danger');
	                }
	                $('#frm_add_seguim')[0].reset();
	                Swal.fire({
	                    title: e.msg,
	                    type: 'success',
	                    icon: 'success',
	                }).then((result) => {
	                    if (result.value) {}
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divmodseguim #divoverlay').remove();
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
</script>
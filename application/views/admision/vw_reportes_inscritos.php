<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<h1>Estadistica
					<small>Panel</small></h1>
				</div>
				
			</div>
		</div>
	</section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_ls_reportes" class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-5">
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Inscripciones - Documentos Anexados' type="radio" data-view='ts_div_vwreportes' data-urlpdf='admision/inscripcion-reportes/pdf' data-urlexcel='admision/inscripcion-reportes/excel' name="exampleRadios" id="r301" value="301" checked>
							<label class="form-check-label" for="r301">
								Inscripciones - Documentos Anexados
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Inscripciones - Resumen por grupos' data-view='ts_div_vwreportes' data-urlpdf='admision/reportes-inscritos/pdf' data-urlexcel='' type="radio" name="exampleRadios" id="r302" value="302">
							<label class="form-check-label" for="r302">
								Inscripciones - Resumen por grupos
							</label>
						</div>
					</div>
					<div class="col-7" id="ts_div_vwreportes">
						<div class="row">
							<div class="col-12 mb-2">
								<h4 id="vw_exp_title">Inscripciones - Documentos Anexados</h4>
							</div>
							<div class="col-12">
								<form id="frm_search_inscritos" action="<?php echo base_url() ?>inscrito_reportes/get_filtrar_basico_sd_activa_report" method="post" accept-charset="utf-8">
									<div class="row my-2">
						                <div class="form-group has-float-label col-12 col-sm-3 col-md-4">
						                  	<select class="form-control" id="fbus-periodo" name="fbus-periodo" placeholder="Periodo lectivo">
						                    	<option value="%">Todos</option>
						                    	<?php foreach ($periodos as $key => $periodo) {
						                    		echo "<option value='$periodo->codigo'>$periodo->nombre</option>";
						                    	} ?>       
						                    </select>
						                  	<label for="fbus-carrera">Periodo lectivo</label>
						                </div>
						                <div class="form-group has-float-label col-12 col-sm-8">
						                  	<select data-currentvalue="" class="form-control" id="fbus-campania" name="fbus-campania" placeholder="Campaña" required="">
						                    	<option value="%">Todas</option>
						                  	</select>
						                  	<label for="fbus-campania"> Campaña</label>
						                </div>

						                <div class="form-group has-float-label col-12 col-sm-8 col-md-8">
						                  	<select class="form-control" id="fbus-carrera" name="fbus-carrera" placeholder="Programa">
						                    	<option value="%">Todos</option>
						                    	<?php foreach ($carreras as $carrera) {
						                    		echo "<option value='$carrera->codcarrera' data-sigla='$carrera->sigla'>$carrera->nombre</option>";
						                    	} ?>
						                    </select>
						                  	<label for="fbus-carrera"> Programa</label>
						                </div>
						                <div class="form-group has-float-label col-12 col-sm-4 col-md-4">
						                  	<select data-currentvalue="" class="form-control" id="fbus-turno" name="fbus-turno" placeholder="Turno" required="">
						                    	<option value="%">Todos</option>
						                    	<?php foreach ($turnos as $turno) {
						                    		echo "<option value='$turno->codigo'>$turno->nombre</option>";
						                    	} ?>
						                    </select>
						                  	<label for="fbus-turno"> Turno</label>
						                </div>
						                <div class="form-group has-float-label col-12 col-sm-4">
						                  	<select data-currentvalue="" class="form-control" id="fbus-seccion" name="fbus-seccion" placeholder="Sección" required="">
						                    	<option value="%">Todas</option>
						                    	<?php foreach ($secciones as $key => $sec) {
						                    		echo "<option value='$sec->codigo'>$sec->nombre</option>";
						                    	} ?>
											</select>
						                  	<label for="fbus-seccion"> Sección</label>
						                </div>
						                <div class="form-group has-float-label col-12 col-sm-8 col-md-8">
						                  	<input autocomplete="off" class="form-control text-uppercase" id="fbus-txtbuscar" name="fbus-txtbuscar" type="text" placeholder="Carné o Apellidos y nombres">
						                  	<label for="fbus-txtbuscar">Carné o Apellidos y nombres</label>
						                </div>
						            </div>
						            <div class="row">
						            	<div class="col-12 text-right">
						                  	<button id='vw_exp_pdf' type="button" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> pdf</button>
						                  	<button id='vw_exp_excel' type="button" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Excel</button>
						                </div>
						            </div>
								</form>
								<div class="row">
									<div class="col-12 py-1" id="divres-historial">

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
	$(".rd_reportes").change(function(event) {
	    $("#vw_exp_title").html($("#divcard_ls_reportes input[type='radio']:checked").data('title'));
	    var jsview = $(this).data('view');
	    var btnexcel = $(this).data('urlexcel');
	    $(".ts_div_reportes").hide();
	    if (jsview != "") {
	        $("#" + jsview).show();
	    }

	    if (btnexcel == "") {
	    	$('#vw_exp_excel').hide();
	    } else {
	    	$('#vw_exp_excel').show();
	    }
	});

	$("#fbus-periodo").change(function(event) {
      	cbcmp = $('#fbus-campania');
      	cbcmp.html("");
      	cbcmp.html("<option value='%'>Todas</option>");
      	var codperiodo = $(this).val();
      	if (codperiodo == '%') return;
      	$.ajax({
          	url: base_url + 'campania/fn_campania_por_periodo',
          	type: 'post',
          	dataType: 'json',
          	data: {
              	txtcodperiodo: codperiodo
          	},
          	success: function(e) {
              	cbcmp.html(e.vdata);
          	},
          	error: function(jqXHR, exception) {
              	var msgf = errorAjax(jqXHR, exception, 'text');
              	cbcmp.html("<option value='0'>" + msgf + "</option>");
          	}
      	});
  	});

  	$('#vw_exp_pdf').click(function() {
  		$('#frm_search_inscritos input,select').removeClass('is-invalid');
      	$('#frm_search_inscritos .invalid-feedback').remove();
      	// $('#divcard_ls_reportes').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      	var llenos=0;
      	if ($("#fbus-txtbuscar").val()!=="") llenos=llenos + 2;
      	if ($("#fbus-periodo").val()!=="%") llenos++;
      	if ($("#fbus-campania").val()!=="%") llenos++;
      	if ($("#fbus-seccion").val()!=="%") llenos++;
      	if ($("#fbus-carrera").val()!=="%") llenos++;
      	if ($("#fbus-turno").val()!=="%") llenos++;
    	if (llenos>1) {
    		var buscar = $("#fbus-txtbuscar").val();
    		var periodo = $("#fbus-periodo").val();
    		var campania = $("#fbus-campania").val();
    		var seccion = $("#fbus-seccion").val();
    		var carrera = $("#fbus-carrera").val();
    		var turno = $("#fbus-turno").val();
    		var url_pdf = $("#divcard_ls_reportes input[type='radio']:checked").data('urlpdf');

    		var url = base_url + url_pdf + '?bc=' + buscar + '&per=' + periodo + '&cp=' + campania + '&sc=' + seccion + '&pg=' + carrera + '&tn=' + turno;
    		window.open(url, '_blank');
	      	$("#divres-historial").html("");
	    }
    	else{
      		// $('#divcard_ls_reportes #divoverlay').remove();
      		$("#divres-historial").html("<span class='text-danger'>Indicar como minimo 2 parametros de búsqueda</span>");    
    	}
    	return false;
  	});

  	$('#vw_exp_excel').click(function(e) {
  		$('#frm_search_inscritos input,select').removeClass('is-invalid');
      	$('#frm_search_inscritos .invalid-feedback').remove();
      	// $('#divcard_ls_reportes').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      	var llenos=0;
      	if ($("#fbus-txtbuscar").val()!=="") llenos=llenos + 2;
      	if ($("#fbus-periodo").val()!=="%") llenos++;
      	if ($("#fbus-campania").val()!=="%") llenos++;
      	if ($("#fbus-seccion").val()!=="%") llenos++;
      	if ($("#fbus-carrera").val()!=="%") llenos++;
      	if ($("#fbus-turno").val()!=="%") llenos++;
    	if (llenos>1) {
    		var buscar = $("#fbus-txtbuscar").val();
    		var periodo = $("#fbus-periodo").val();
    		var campania = $("#fbus-campania").val();
    		var seccion = $("#fbus-seccion").val();
    		var carrera = $("#fbus-carrera").val();
    		var turno = $("#fbus-turno").val();
    		var url_pdf = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');

    		var url = base_url + url_pdf + '?bc=' + buscar + '&per=' + periodo + '&cp=' + campania + '&sc=' + seccion + '&pg=' + carrera + '&tn=' + turno;
    		window.open(url, '_blank');
	      	$("#divres-historial").html("");
	    }
    	else{
      		// $('#divcard_ls_reportes #divoverlay').remove();
      		$("#divres-historial").html("<span class='text-danger'>Indicar como minimo 2 parametros de búsqueda</span>");    
    	}
    	return false;
  	});
</script>
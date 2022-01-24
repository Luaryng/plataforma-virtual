<div class="card-body">
	<div class="row">
		<div class="col-12" id="divcard_lista">
			<?php //if (count($grupos) > 0): ?>
			<div class="col-12 btable">
                <div class="col-md-12 thead d-none d-md-block">
                    <div class="row">
                        <div class="col-sm-1 col-md-1 td hidden-xs">N°</div>
                        <div class="col-sm-2 col-md-2 td">PERIODO</div>
                        <div class="col-sm-2 col-md-4 td">CARRERA</div>
                        <div class="col-sm-2 col-md-2 td">CIC./SECCIÓN</div>
                        <div class="col-sm-2 col-md-2 td">TURNO</div>
                        <div class="col-sm-1 col-md-1 td text-center"></div>
                    </div>
                </div>
                <div class="col-md-12 tbody" id="vw_dc_divdata">
                	<?php
                	$nro = 0;
                	foreach ($grupos as $key => $dcg) {
                		$nro++;
                		echo "<div class='row rowcolor' data-codperiodo='{$dcg->periodo}' data-codcarrera='{$dcg->carrera}' data-codciclo='{$dcg->ciclo}' data-codturno='{$dcg->turno}' data-codseccion='{$dcg->seccion}'>
                				<div class='col-4 col-md-1 td'><span><b>{$nro}</b></span></div>
                				<div class='col-8 col-md-2 td'><span>{$dcg->nomperiodo}</span></div>
		                    	<div class='col-8 col-md-4 td'><span>{$dcg->nomcarrera}</span></div>
		                    	<div class='col-4 col-md-2 td'><span>{$dcg->nomciclo} - {$dcg->nomseccion}</span></div>
		                    	<div class='col-6 col-md-2 td'><span>{$dcg->nomturno}</span></div>
		                    	<div class='col-6 col-md-1 td text-right'>
		                    		<a href='#' onclick='fn_vw_view_deudas($(this));return false;' class='btn btn-primary btn-sm vw_gc_btndeudas'>Deudas</a>
		                    	</div>
                			</div>";
                	}

                	?>
                    
                </div>
            </div>
            <?php //else: ?>
            	<!-- <h6>No se encontaron datos</h6> -->
            <?php //endif ?>
            <br>
            <button type="button" class="btn bt-sm btn-primary my-2" id="btnadd_grupo">Agregar Grupo</button>
		</div>
		<div class="col-12" id="divcard_form">
			<form id="frm_add_grupo" action="" method="post" accept-charset="utf-8">
				<input type="hidden" name="vw_dg_idcalend" id="vw_dg_idcalend" value="<?php echo $idcalendario ?>">
				<div class="row">
					<div class="form-group col-md-6 has-float-label">
						<select name="vw_dg_cbperiodo" id="vw_dg_cbperiodo" class="form-control form-control-sm text-sm">
                        	<option value="0">Selecciona periodo</option>
                        	<?php foreach ($periodos as $periodo) {
                        		echo "<option value='$periodo->codigo'>$periodo->nombre </option>";
                        	} ?>
                    	</select>
                    	<label for="vw_dg_cbperiodo">Periodo</label>
					</div>
					<div class="form-group col-md-6 has-float-label">
						<select name="vw_dg_cbcarrera" id="vw_dg_cbcarrera" class="form-control form-control-sm text-sm">
                        	<option value="0">Selecciona programa</option>
                        	<?php foreach ($carreras as $car) {
                        		echo "<option value='$car->codcarrera'>$car->nombre </option>";
                        	} ?>
                    	</select>
                    	<label for="vw_dg_cbcarrera">Programa</label>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 has-float-label">
						<select name="vw_dg_cbciclo" id="vw_dg_cbciclo" class="form-control form-control-sm text-sm">
                        	<option value="0">Selecciona ciclo</option>
                        	<?php foreach ($ciclos as $ciclo) {
                        		echo "<option value='$ciclo->codigo'>$ciclo->nombre </option>";
                        	} ?>
                    	</select>
                    	<label for="vw_dg_cbciclo">Ciclo</label>
					</div>
					<div class="form-group col-md-4 has-float-label">
						<select name="vw_dg_cbturno" id="vw_dg_cbturno" class="form-control form-control-sm text-sm">
                        	<option value="0">Selecciona turno</option>
                        	<?php foreach ($turnos as $tur) {
                        		echo "<option value='$tur->codigo'>$tur->nombre </option>";
                        	} ?>
                    	</select>
                    	<label for="vw_dg_cbturno">Turno</label>
					</div>
					<div class="form-group col-md-4 has-float-label">
						<select name="vw_dg_cbseccion" id="vw_dg_cbseccion" class="form-control form-control-sm text-sm">
                        	<option value="0">Selecciona seccion</option>
                        	<?php foreach ($secciones as $sec) {
                        		echo "<option value='$sec->codigo'>$sec->nombre </option>";
                        	} ?>
                    	</select>
                    	<label for="vw_dg_cbseccion">Sección</label>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<button type="button" class="btn bt-sm btn-danger my-2" id="btncancel_grupo">Cancelar</button>
					</div>
					<div class="col-6">
						<button type="submit" class="btn bt-sm btn-primary my-2 float-right" id="btnsave_grupo">Guardar Grupo</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#divcard_form').hide();
	});

	$('#btnadd_grupo').click(function() {
		$('#divcard_lista').hide();
		$('#divcard_form').show();
	});

	$('#btncancel_grupo').click(function() {
		$('#divcard_lista').show();
		$('#divcard_form').hide();
	});

	$('#frm_add_grupo').submit(function(e) {
		$('#div_Grupos input,select').removeClass('is-invalid');
	    $('#div_Grupos .invalid-feedback').remove();
	    $('#div_Grupos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    
	    $.ajax({
	        url: base_url + "deudas_grupo/fn_guardar" ,
	        type: 'post',
	        dataType: 'json',
	        data: $('#div_Grupos #frm_add_grupo').serialize(),
	        success: function(e) {
	            $('#div_Grupos #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	            } else {
	                $("#div_Grupos #divcard_lista").show();
	                $("#div_Grupos #divcard_form").hide();
	                var nro=0;
	                var tabla="";
	                $.each(e.vdata, function(index, val) {
	                	nro++;
	                	tabla=tabla + 
	                    "<div class='row rowcolor'>"+
	                        "<div class='col-4 col-md-1 td'>" +
	                              "<span><b>" + nro + "</b></span>" +
	                        "</div>" + 
	                        "<div class='col-8 col-md-2 td'>" +
	                          "<span>" + val['nomperiodo'] + "</span>" +
	                        "</div> " +
	                        "<div class='col-8 col-md-4 td'>" +
	                        	"<span>" + val['nomcarrera'] + "</span>" +
	                        "</div> " +
	                        "<div class='col-4 col-md-2 td'>" +
	                          "<span>" + val['nomciclo'] + " - "+val['nomseccion']+"</span>" +
	                        "</div> " + 
	                        "<div class='col-6 col-md-2 td'>" +
	                          "<span>" + val['nomturno'] + "</span>" +
	                        "</div> " +
	                        '<div class="col-6 col-md-1 td text-right">' + 
	                            
	                        '</div>' +
	                    '</div>';
	                })
	                $('#vw_dc_divdata').html(tabla);
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#div_Grupos #divoverlay').remove();
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
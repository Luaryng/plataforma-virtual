<div class="card mt-2 bg-light">
	<div class="card-header">
		<h3 class="card-title text-bold">EDITAR: <?php echo $ses->detalle ?></h3>
	</div>
	<div class="card-body">
		<form id='frmsesionedit' name='frmsesionedit'  action='<?php echo base_url();?>sesion/f_editar_sesion' method='post' accept-charset='utf-8'>
			<input type="hidden" id="fedittxtsesid" name="fedittxtsesid" value="<?php echo $ses->id ?>">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group has-float-label">
						<input class="form-control" id="fedittxtnrosesion" name="fedittxtnrosesion" type="text" placeholder="Sesión N°" minlength="6" autocomplete="off"  value="<?php echo $ses->nrosesion ?>" required/>
						<label for="fedittxtnrosesion">Sesión N°</label>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group has-float-label">
						<input class="form-control" id="fedittxtdetalle" name="fedittxtdetalle" type="text" placeholder="Descripción" minlength="6" autocomplete="off" value="<?php echo $ses->detalle ?>" required/>
						<label for="fedittxtdetalle">Descripción</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group has-float-label">
						<input class="form-control" id="fedittxtfecha" name="fedittxtfecha" value="<?php echo $ses->fecha ?>" type="date" placeholder="Fecha" autocomplete="off" required />
						<label for="fedittxtfecha">Fecha</label>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group has-float-label">
						<input class="form-control fictxthoradfini" id="fedittxthoraini" name="fedittxthoraini" value="<?php echo $ses->horaini ?>" type="time" placeholder="Fecha" autocomplete="off" required onchange="calculardiferencia('#frmsesionedit');return false" />
						<label for="fedittxthoraini">Hora Inicio</label>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group has-float-label">
						<input class="form-control fictxthoradffin" id="fedittxthorafin" name="fedittxthorafin"  value="<?php echo $ses->horafin ?>" type="time" placeholder="Fecha" autocomplete="off" required onchange="calculardiferencia('#frmsesionedit');return false" />
						<label for="fedittxthorafin">Hora Fin</label>
					</div>
				</div>
				<div class="col-md-2">
					<span id="horas_justificacion_real" class="border-left-0 border-right-0 border-top-0 border-bottom border-secondary form-control"></span>
				</div>
				<div class="col-md-4">
					<div class="form-group has-float-label">
						<select class="form-control" name="feditcbtiposesion" id="feditcbtiposesion"  placeholder="Tipo" required>
							<option <?php echo ($ses->tipo=="CLASE") ? "selected":""; ?> value="CLASE">SESIÓN DE CLASE</option>
							<option <?php echo ($ses->tipo=="EVALUACIÓN") ? "selected":""; ?> value="EVALUACIÓN">EVALUACIÓN</option>
						</select>
						<label for="feditcbtiposesion">Tipo</label>
					</div>
				</div>
			</div>
		</form>
		<div class="row">
			
			<div class="col-3 ">
				<button type="button" id="feditbtnfrmcancel" class="btn btn-default btn-block ">Cancel</button>
			</div>
			<div class="col-3 float-right">
				<button type="button" id="frmssbtnedit" class="btn btn-primary btn-block ">Guardar</button>
			</div>
		</div>
		
	</div>
</div>
<script>
	
	$('cbtiposesion').val("");
	$('#feditbtnfrmcancel').click(function(event) {
		$('#divsesioneditar').html('');
		$('#divsesioneditar').hide();
	});
	$('#frmssbtnedit').click(function(event) {
		//$('#frmsesionedit #fedittxtcacad').val($('#btncalladdsesion').data('carga'));
		/*$('#frmsesionedit #fedittxtssec').val($('#btncalladdsesion').data('ssc'));
		$('#frmsesionedit #fedittxtcdoc').val($('#btncalladdsesion').data('cdc'));*/
		$('#frmsesionedit').submit();
		return false;
	});
	$('#frmsesionedit').submit(function(event) {
		//@vses_fecha, @vses_horaini, @vses_horafin, @vacad, @vcodtema, @vdetalle, @vssec, @vcdoc
		$('#divboxmissesiones').append('<div id="divoverlay" class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$.ajax({
				url:  $(this).attr("action"),
			type: 'post',
			dataType: 'json',
			data: $(this).serialize(),
			success: function(e) {
				$('#divboxmissesiones #divoverlay').remove();
				if (e.status == false) {
					$.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
					var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
					// $('#divsesioneditar').append(msgf);
				}
				else {
					
					$('#divsesioneditar').append(e.msg);
					location.reload();
				}
			},
		error: function (jqXHR, exception) {
			var msgf=errorAjax(jqXHR, exception,'div');
		$('#divboxmissesiones #divoverlay').remove();
		$('#divsesioneditar').html(msgf);
	},
		});
		return false;
	});
</script>
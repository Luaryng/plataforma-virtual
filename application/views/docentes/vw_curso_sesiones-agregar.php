<div class="panel panel-primary">
	<div class="panel-body">
		<h3 class="text-primary" id="divcard_titleadd">AGREGAR SESIÓN DE CLASE</h3>
		<form id='frmsesionadd' name='frmsesionadd'  action='<?php echo base_url();?>sesion/f_agregar_sesion' method='post' accept-charset='utf-8'>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group has-float-label">
						<input class="form-control" id="txtnrosesion" name="txtnrosesion" type="text" placeholder="Sesión N°" minlength="6" autocomplete="off" required/>
						<label for="txtnrosesion">Sesión N°</label>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group has-float-label">
						<input class="form-control" id="txtdetalle" name="txtdetalle" type="text" placeholder="Descripción" minlength="6" autocomplete="off" required/>
						<label for="txtdetalle">Descripción</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group has-float-label">
						<input class="form-control" id="txtfecha" name="txtfecha" type="date" placeholder="Fecha" autocomplete="off" required />
						<label for="txtfecha">Fecha</label>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group has-float-label">
						<input class="form-control fictxthoradfini" id="txthoraini" name="txthoraini" type="time" placeholder="Fecha" autocomplete="off" required onchange="calculardiferencia('#frmsesionadd');return false" />
						<label for="txthoraini">Hora Inicio</label>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group has-float-label">
						<input class="form-control fictxthoradffin" id="txthorafin" name="txthorafin" type="time" placeholder="Fecha" autocomplete="off" required onchange="calculardiferencia('#frmsesionadd');return false" />
						<label for="txthorafin">Hora Fin</label>
					</div>
				</div>
				<div class="col-md-2">
					<span id="horas_justificacion_real" class="border-left-0 border-right-0 border-top-0 border-bottom border-secondary form-control"></span>
				</div>
				<div class="col-md-4">
					<div class="form-group has-float-label">
						<select class="form-control" name="cbtiposesion" id="cbtiposesion" placeholder="Tipo" required>
							<option value="CLASE">SESIÓN DE CLASE</option>
							<option value="EVALUACIÓN">EVALUACIÓN</option>
						</select>
						<label for="cbtiposesion">Tipo</label>
					</div>
				</div>
			</div>
			<div class="row">
				<input id="txtcacad" name="txtcacad" type="hidden">
				<input id="txtssec" name="txtssec" type="hidden">
				<!--<input id="txtcdoc" name="txtcdoc" type="hidden">-->
				</form>
				<div class="col-3 ">
					<button type="button" id="btnfrmcancel" class="btn btn-default btn-block">Cancel</button>
				</div>
				<div class="col-3 float-right">
					<button type="button" id="frmssbtnadd" class="btn btn-primary btn-block">Guardar</button>
				</div>
			</div>
		
	</div>
</div>
<script>
	$('cbtiposesion').val("");
	$('#btnfrmcancel').click(function(event) {
		$('#divsesionprocesos').html('');
		$('#divsesionprocesos').hide();
	});

	$('#frmssbtnadd').click(function(event) {
		$('#frmsesionadd #txtcacad').val($('#btncalladdsesion').data('carga'));
		$('#frmsesionadd #txtssec').val($('#btncalladdsesion').data('ssc'));
		/*$('#frmsesionadd #txtcdoc').val($('#btncalladdsesion').data('cdc'));*/
		$('#frmsesionadd').submit();
		return false;
	});

	$('#frmsesionadd').submit(function(event) {
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
					// $('#divsesionprocesos').append(msgf);
				}
				else {
					
					$('#divsesionprocesos').append(e.msg);
					location.reload();
				}
			},
	    	error: function (jqXHR, exception) {
	    		var msgf=errorAjax(jqXHR, exception,'div');
		        $('#divboxmissesiones #divoverlay').remove();
		        $('#divsesionprocesos').html(msgf);
	        },
		});
		return false;
	});
</script>
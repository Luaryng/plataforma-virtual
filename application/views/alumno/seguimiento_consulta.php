<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>ALUMNOS
					<small> Seguimiento</small></h1>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<div id="divboxpagos" class="card card-success">
			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<select placeholder="Periodo" class="form-control" name="cbperiodo" id="cbperiodo">
							<option value="">PERIODO</option>
							<?php foreach ($periodos as $lsperiodo) {?>
							<option	value="<?php echo $lsperiodo->codigo ?>"><?php echo $lsperiodo->nombre ?></option>
							<?php }?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 margin-top-10px">
						<div class="input-group">
							<input type="text" name="txtbusca_carne" id="txtbusca_carne" class="form-control" placeholder="Carné">
							<span class="input-group-btn">
								<button class="btn btn-primary btn-md" type="button" id="busca_alumno">BUSCAR</button>
							</span>
						</div>
						<!-- /input-group -->
					</div>
					<div class="col-lg-8 margin-top-10px">
						<div class="input-group">
							<input type="text" name="txtbusca_apellnom" id="txtbusca_apellnom" class="form-control" placeholder="Apellidos y Nombres">
							<span class="input-group-btn">
								<button class="btn btn-primary btn-md" type="button" id="busca_apellnom">BUSCAR
								</button>
							</span>
						</div>
						
					</div>
				</div>
				<hr>
				
				<div id="divmatriculados" class="no-padding">
					
				</div>
				<div class="col-12" id="divdatosmat">
					
				</div>
				<div class="table-responsive" id="divmiscursos">
					<h4 class="text-primary"><center></center></h4>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->

	<script type="text/javascript" charset="utf-8">
		$('#busca_alumno').click(function() {
			var tcarc=$('#txtbusca_carne').val();
			
			searchc(tcarc);
			return false;
		});
		$('#txtbusca_carne').keypress(function(event) {
			var keycode = event.keyCode || event.which;
		    if(keycode == '13') {
		        searchc($('#txtbusca_carne').val()); 
		    }
		});
		$('#txtbusca_apellnom').keypress(function(event) {
			var keycode = event.keyCode || event.which;
		    if(keycode == '13') {
		        $('#busca_apellnom').click();
		    }
		});
		function searchc(tcar){
			$('#divmatriculados').html("");
			$('#divdatosmat').html("");
			var cbper=$('#cbperiodo').val();
			$('#divboxpagos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			$.ajax({
				url: base_url + 'matricula/vwcurso_x_periodo_carne'	,
				type: 'post',
				dataType: 'json',
				data: {txtbusca_carne: tcar,cbperiodo: cbper},
				success: function(e) {
					$('#divboxpagos #divoverlay').remove();
					if (e.status == false) {
						var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
						$('#divmiscursos').html(msgf);
					}
					else {
						$('#divdatosmat').html(e.alumno);
						$('#divmiscursos').html(e.miscursos);
					}
				},
				error: function (jqXHR, exception) {
				var msgf=errorAjax(jqXHR, exception,'div');
				$('#divboxpagos #divoverlay').remove();
				$('#divmiscursos').html(msgf);
				},
			});
			return false;
		}

		$('#busca_apellnom').click(function() {
			$('#divmiscursos').html("");
			$('#divdatosmat').html("");
			
			var tcar=$('#txtbusca_apellnom').val();
			var cbper=$('#cbperiodo').val();
			
			$('#divboxpagos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			$.ajax({
				url: base_url + 'matricula/vw_matriculados'	,
				type: 'post',
				dataType: 'json',
				data: {txtbusca_apellnom: tcar,cbperiodo: cbper},
				success: function(e) {
					$('#divboxpagos #divoverlay').remove();
					if (e.status == false) {
						var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
						$('#divmatriculados').html(msgf);
					}
					else {
						$('#divmatriculados').html(e.matriculados);
					}
				},
			error: function (jqXHR, exception) {
				var msgf=errorAjax(jqXHR, exception,'div');
			$('#divboxpagos #divoverlay').remove();
			$('#divmatriculados').html(msgf);
		},
			});
			return false;
		});
	</script>
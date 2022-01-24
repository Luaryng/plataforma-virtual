<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content-wrapper">

	<div class="modal fade" id="md-plan" tabindex="-1" role="dialog" aria-labelledby="md-plan" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-scrollable" role="document">
	    <div class="modal-content">

	      <!-- Modal Header -->
	      <div class="modal-header">
	        <h4 class="modal-title"></h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>

	      <!-- Modal body -->
	      <div class="modal-body">
	        
	      </div>

	      <!-- Modal footer -->
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>

	    </div>
	  </div>
	</div>

	<!--<div class="modal fade" id="md-listadocente" tabindex="-1" role="dialog" aria-labelledby="md-listadocente" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-scrollable" role="document">
	    <div class="modal-content">

	      <div class="modal-header">
	        <h4 class="modal-title">Asignar docente</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>

	      <div class="modal-body">
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>

	    </div>
	  </div>
	</div>-->

	<section id="s-cargado" class="content pt-2">
		<div id="divcard_grupo" class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Carga Académica por docente</h3>
			</div>
			<div class="card-body">
				<b class="text-danger"><i class="fas fa-user-circle mr-1"></i> Selecciona el periodo y docente</b>
				<form id="frm-docente" name="frm-docente" action="#" method="post" accept-charset='utf-8'>
					<div class="row mt-2">
						<div class="form-group has-float-label col-12 col-xs-4 col-sm-2">
							<select data-currentvalue='' class="form-control" id="fdc-cbperiodo" name="fdc-cbperiodo" placeholder="Periodo" required >
								<option value="0">Periodo</option>
								<?php foreach ($periodos as $periodo) {?>
								<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
								<?php } ?>
							</select>
							<label for="fdc-cbperiodo"> Periodo</label>
						</div>
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-9">
							<select class="form-control" id="fdc-cbdocente" name="fdc-cbdocente" placeholder="Docente">
								<option value="0">Selecciona un Docente</option>
								<?php foreach ($docentes as $kdoc => $docente) {?>
								<option value="<?php echo $kdoc ?>"><?php echo $docente ?></option>
								<?php } ?>
							</select>
							<label for="fdc-cbdocente"> Docente</label>
						</div>
						<div class="col-md-1">
							<input id="fdc-checkdocente" type="checkbox" data-toggle="toggle" 
							data-on="<i class='fa fa-check'></i>" data-off="<i class='fas fa-arrow-alt-circle-right'></i>" 
							data-onstyle="success" data-offstyle="danger">
						</div>
					</div>
				</form>
				
			</div>
		</div>
		<div id="divcard_cursos" class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Carga académica por docente</h3>
			</div>
			<div class="card-body">
				
				
			</div>
		</div>
	</section>
</div>
<?php 
 ?>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
<script>
	var vdocentes = <?php echo json_encode($docentes, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
		const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    })
	$("#fdc-checkdocente").change(function(event) {
		if ($(this).prop('checked')==true){
			
			var vacio=0;
			$("#frm-docente select").each(function(index, el) {
				if ($(el).val()=="0") vacio++;
			});

			if (vacio>0){
				$(this).bootstrapToggle('off');
				    Toast.fire({
				      type: 'warning',
				      title: 'Aviso: Selecciona todos los Items disponibles: Periodo y Docente'
				    })
			}
			else{
				$('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				$("#btn-vercurricula").show();
				$('#divcard_cursos .card-body').html("");
				$("#divcard_grupo select").prop('disabled', false);
		        var fdata=$("#frm-docente").serializeArray();
		        $.ajax({
		            url: base_url + 'cargasubseccion/fn_get_carga_por_docente',
		            type: 'post',
		            dataType: 'json',
		            data: fdata,
		            success: function(e) {
		                $('#divcard_cursos .card-body').html(e.vdata);
		                $("#divcard_grupo select").prop('disabled', true);
		                $('#divcard_grupo #divoverlay').remove();
		            },
		            error: function(jqXHR, exception) {
		            	$('#divcard_grupo #divoverlay').remove();
		            	$(this).bootstrapToggle('off');
		            	$("#divcard_grupo select").prop('disabled', true);
		                var msgf = errorAjax(jqXHR, exception, 'text');
		               	Toast.fire({
					      type: 'warning',
					      title: 'Aviso: '  + msgf
					    })
		               	$('#divcard_cursos .card-body').html("");
		            }
		        });

			}
		}
		else{
			$("#btn-vercurricula").hide();
			$('#divcard_cursos .card-body').html("");
			$("#frm-docente select").prop('disabled', false);
		}

	});
</script>
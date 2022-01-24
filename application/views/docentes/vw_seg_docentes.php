<div class="content-wrapper">
	 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DOCENTES
            <small> Seguimiento</small></h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

	<section class="content">
		
			<div id="divboxlistadocentes" class="card card-primary">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 margin-top-10px">
							<div class="input-group">
								<select placeholder="Periodo" class="form-control" name="cbperiodo" id="cbperiodo">
									<option value="">PERIODO</option>
									<?php foreach ($periodos as $lsperiodo) {?>
									<option <?php echo ($lsperiodo->codigo==$periodo) ? "selected": ""; ?>	value="<?php echo $lsperiodo->codigo ?>"><?php echo $lsperiodo->nombre ?></option>
									<?php }?>
								</select>
								<span class="input-group-btn">
									<button class="btn btn-primary btn-md" type="button" id="busca_docente">BUSCAR</button>
								</span>
							</div>
							<!-- /input-group -->
						</div>
						
					</div>
					<hr>
					<div id="divmatriculados" class="no-padding">
						<?php 
						if ($periodo==""){
							$resultados="<h4>SELECCIONA UN PERIODO</h4>" ;
						}
						echo $resultados;
						?>
					</div>
					<!--<div id="divmiscursos" class="no-padding">
							<h4 class="text-primary"><center></center></h4>
					</div>-->
					
				</div>
			</div>
		
	</section>
</div>
<script>
$("#busca_docente").click(function(event) {
    $('#divmiscursos').html("");
    var tcar = $('#txtbusca_apellnom').val();
    var cbper = $('#cbperiodo').val();
    $('#divboxlistadocentes').append('<div id="divoverlay" class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.ajax({
        url: base_url + 'supervisor/vw_docentes_periodo',
        type: 'post',
        dataType: 'json',
        data: {
            cbperiodo: cbper
        },
        success: function(e) {
            if (e.status == false) {
                var msgf = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg + '</div>';
                $('#divmatriculados').html(msgf);
            } else {
                $('#divmatriculados').html(e.matriculados);
            }
            $('#divboxlistadocentes #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#divboxlistadocentes #divoverlay').remove();
            $('#divmatriculados').html(msgf);
        },
    });
    return false;
});
</script>
<!-- Content Wrapper. Contains page content -->
<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<h1>
			Descargar Boleta de Notas
			
			</h1>
		</div>
	</section>
	<!-- Main content -->
	<section class="content">
		<div id="divboxnotas" class="card">
			
			<div class="card-body">
				<div class="callout callout-info py-1">
                  <span>Aqui podras DESCARGAR tus <b>BOLETAS DE NOTAS</b> una vez <b>culminado</b> el semestre academico<br>
                  	Si deseas ver tus asistencias y notas de periodo actual ve  tu boleta ve al Menú <a href="<?php echo $vbaseurl ?>alumno/historial/boleta-de-notas">Notas y Asistencias</a></span>
                </div>
                <div class="row">
                	<div class="col-md-3">
                		<div class="input-group">
						  <select class="custom-select" name="fcbmatriculas" id="fcbmatriculas">
						    <option value="0">* Periodo</option>
								
							<?php 
							foreach ($mismatriculas as $mat) {
								//if ($mat->bloquear_evaluaciones=="NO"){
									$mat64local=base64url_encode($mat->codigo);
									echo
									"<option data-periodo='$mat->periodo' data-carrera='$mat->carrera'	data-ciclo='$mat->ciclo' data-seccion='$mat->seccion' data-turno='$mat->turno' value='$mat64local'>$mat->periodo  - $mat->ciclo</option>";
								//}
							}?>
						  </select>
						  <div class="input-group-append">
						    <button class="btn btn-primary" id="hbn_btn_buscar_boleta" type="button">
						    	<i class="fa fa-arrow-circle-right"></i> Mostrar
						    </button>
						  </div>
						</div>

					</div>
                </div>
				<div class="col-12 border rounded my-2 py-2">
					<div class="row">
						
						<div id="divperiodo" class="col-md-2"></div>
						<div id="divcarrera" class="col-md-4"></div>
						<div id="divciclo" class="col-md-2"></div>
						<div id="divturno" class="col-md-2"></div>
						<div id="divseccion" class="col-md-2"></div>
						<div id="divmiembro" class="col-md-12"></div>
						
					</div>
				</div>
				
				<div class="table-responsive margin-top-10px no-padding">
					
					<table class="table-registro table table-bordered table-striped table-hover table-condensed" id="tr-cursos" role="table">
						<thead role="rowgroup">
							<tr role="row">
								<th role="columnheader">COD</th>
								<th role="columnheader">CARGA</th>
								<th role="columnheader">UNIDAD DIDÁCTICA</th>
								
								<th role="columnheader">DOCENTE</th>
								<th role="columnheader">PROM.</th>
								<th role="columnheader">RECUP.</th>
								<th role="columnheader">FINAL</th>
								<th role="columnheader">Est.</th>
								
	
							</tr>
						</thead>
						<tbody role="rowgroup" id="hbn_div_boleta">
							<?php if (isset($miscursos)): ?>
							<?php
								echo $miscursos;
							?>
							<?php else: ?>
							<tr role=rowgroup>
								<td colspan="13"><h5 class="text-primary">--- SELECCIONA UN PERIODO</h5></td>
							</tr>
							<?php endif ?>
						</tbody>
					</table>
					
					
					
				</div>
				<div class="row">
					<div id="hbn_div_pie_descarga" class='col-12 text-right mb-2'>
					<?php
						if (isset($miboleta)) echo $miboleta;
					?>
					</div>
					
					
				</div>
				
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url(); ?>resources/jquery/pages.js"></script>!-->
<script type="text/javascript">
	
$('#hbn_btn_buscar_boleta').click(function(event) {
	$('#hbn_div_boleta').html("");
	$('#divperiodo').html('');
	$('#divcarrera').html('');
	$('#divciclo').html('');
	$('#divturno').html('');
	$('#divseccion').html('');
	var cmat=$("#fcbmatriculas").val();
	if (cmat!='0'){
		if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?cmt=' + cmat;
            window.history.pushState({path: newurl}, '', newurl);
        }
		$('#divperiodo').html('Periodo: <b>' + $("#fcbmatriculas").find('option:selected').data('periodo') +'</b>');
		$('#divcarrera').html('Programa: <b>' + $("#fcbmatriculas").find('option:selected').data('carrera') +'</b>');
		$('#divciclo').html('Semestre: <b>' + $("#fcbmatriculas").find('option:selected').data('ciclo') +'</b>');
		$('#divturno').html('Turno: <b>' + $("#fcbmatriculas").find('option:selected').data('turno') +'</b>');
		$('#divseccion').html('Sección: <b>' + $("#fcbmatriculas").find('option:selected').data('seccion') +'</b>');
		$('#divboxnotas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$.ajax({
					url: base_url + 'alumno/historial__mis_notas_xmatricula'	,
			type: 'post',
			dataType: 'json',
			data: {cbmatricula: cmat},
			success: function(e) {
				$('#divboxnotas #divoverlay').remove();
				if (e.status == false) {
					
					var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4> ' + e.msg +'</div>';
					$('#hbn_div_boleta').html(msgf);
				}
				else {
					if (e.miscursos!=""){
						$('#hbn_div_boleta').html(e.miscursos);
						$("#hbn_div_pie_descarga").html(e.miboleta);
					}
				}
			},
		error: function (jqXHR, exception) {
			var msgf=errorAjax(jqXHR, exception,'div');
		$('#divboxnotas #divoverlay').remove();
		$('#hbn_div_boleta').html(msgf);
	},
		});
	}
	else{
		$('#hbn_div_boleta').html("<tr role='rowgroup'><td colspan='13'><h5 class='text-primary'>--- SELECCIONA UN PERIODO</h5></td></tr>");
		$("#hbn_div_pie_descarga").html("");
		if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname ;
            window.history.pushState({path: newurl}, '', newurl);
        }
	}
	return false;
});
$(document).ready(function() {

	var cmat=getUrlParameter("cmt",0);
	
	$("#fcbmatriculas").val(cmat);
	if (cmat!='0'){
		$('#divperiodo').html('Periodo: <b>' + $("#fcbmatriculas").find('option:selected').data('periodo') +'</b>');
		$('#divcarrera').html('Programa: <b>' + $("#fcbmatriculas").find('option:selected').data('carrera') +'</b>');
		$('#divciclo').html('Semestre: <b>' + $("#fcbmatriculas").find('option:selected').data('ciclo') +'</b>');
		$('#divturno').html('Turno: <b>' + $("#fcbmatriculas").find('option:selected').data('turno') +'</b>');
		$('#divseccion').html('Sección: <b>' + $("#fcbmatriculas").find('option:selected').data('seccion') +'</b>');
	}
});
</script>
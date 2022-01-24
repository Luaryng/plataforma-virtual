<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		Mis Unidades didácticas
		<small>Activos</small>
		</h1>
		<!--<ol class="breadcrumb">
			<li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
			<li >Mis Cursos</li>
			<li class="active">Carrera</li>
		</ol>-->
	</section>
	<!-- Main content -->
	<section class="content">
		<div id="divboxnotas" class="card">
			<div class="card-header with-border">
				<div class="col-md-3 margin-top-10px no-padding">
					<div class="input-group">
						<select class="form-control" name="fcbmatriculas" id="fcbmatriculas">
							<option value="0">Selecciona un Periodo</option>
							<?php foreach ($mismatriculas as $mat) {?>
							<option data-periodo='<?php echo $mat->periodo ?>'
								data-carrera='<?php echo $mat->carrera ?>'
								data-ciclo='<?php echo $mat->ciclo ?>'
								data-seccion='<?php echo $mat->seccion ?>'
								data-turno='<?php echo $mat->turno ?>'
							value="<?php echo $mat->codigo ?>"><?php echo $mat->periodo . " - " . $mat->ciclo ?></option>
							<?php }?>
						</select>
						<span class="input-group-btn">
							<button class="btn btn-primary btn-md" type="button" id="buscacursos_mat"> Ir <i class="fa fa-arrow-circle-right"></i></button>
						</span>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="col-12">
					<div class="row">
						
						<div id="divperiodo" class="col-md-2"></div>
						<div id="divcarrera" class="col-md-4"></div>
						<div id="divciclo" class="col-md-2"></div>
						<div id="divturno" class="col-md-2"></div>
						<div id="divseccion" class="col-md-2"></div>
						<div id="divmiembro" class="col-md-12"></div>
						
						<hr>
					</div>
				</div>
				
				<div id="divmiscursos" class="table-responsive margin-top-10px no-padding">
					<h4 class="text-primary"><center>--- SELECCIONA UN PERIODO ---</center></h4>
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
	
$('#buscacursos_mat').click(function(event) {
	$('#divmiscursos').html("");
	$('#divperiodo').html('');
	$('#divcarrera').html('');
	$('#divciclo').html('');
	$('#divturno').html('');
	$('#divseccion').html('');
	var cmat=$("#fcbmatriculas").val();
	if (cmat!='0'){
		
		$('#divperiodo').html('Periodo: <b>' + $("#fcbmatriculas").find('option:selected').data('periodo') +'</b>');
		$('#divcarrera').html('Carrera: <b>' + $("#fcbmatriculas").find('option:selected').data('carrera') +'</b>');
		$('#divciclo').html('Ciclo: <b>' + $("#fcbmatriculas").find('option:selected').data('ciclo') +'</b>');
		$('#divturno').html('Turno: <b>' + $("#fcbmatriculas").find('option:selected').data('turno') +'</b>');
		$('#divseccion').html('Sección: <b>' + $("#fcbmatriculas").find('option:selected').data('seccion') +'</b>');
		$('#divboxnotas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$.ajax({
						url: base_url + 'matricula/vwcursoXmatricula'	,
			type: 'post',
			dataType: 'json',
			data: {cbmatricula: cmat},
			success: function(e) {
				$('#divboxnotas #divoverlay').remove();
				if (e.status == false) {
					
					var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg +'</div>';
					$('#divmiscursos').html(msgf);
				}
				else {
					$('#divmiscursos').html(e.miscursos);
				}
			},
		error: function (jqXHR, exception) {
			var msgf=errorAjax(jqXHR, exception,'div');
		$('#divboxnotas #divoverlay').remove();
		$('#divmiscursos').html(msgf);
	},
		});
	}
	return false;
});
</script>
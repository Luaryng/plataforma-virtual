<!--<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">-->
<div class="content-wrapper">
	 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1><?php echo $docente->paterno." ".$docente->materno." ".$docente->nombres; ?>
								
            <small> Seguimiento</small></h1>
          </div>
          <div class="col-sm-4">
          	<?php
				$nombres=$docente->paterno.' '.$docente->materno.' '.$docente->nombres;
				echo '<a href="'.base_url().'docente/horario/descargar?bcode='.$docente->coddocente.'&bnombre='.$nombres.'" target="_blank" title="Descargar" class="pull-right btn btn-success"><span class="fa fa-download"></span> Horario</a>' ?>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

	<section class="content">

		<!--<div id="divboxcxd" class="box">-->
			<div id="divboxcxd"  class="card card-primary">
				<div class="card-body p-2">
					<a class="btn btn-primary btn-flat" href="<?php echo base_url().'seguimiento/docentes/'.$periodo ?>">
						Otros docentes
					</a>
					<hr>
					<?php
					if (!isset($docente)){
						echo "<h4>-- DOCENTE NO REGISTRADO</h4>";
					}
					else{
					?>
					<div id="divmatriculados" class="no-padding">
						<div id="divcursos" class="col-12 col-md-12 btable">
							<div class="col-md-12 thead d-none d-md-block ">
								<div class="row text-bold"  role="rowgroup" >
									<div class="col-md-3">
										<div class="row">
											<div class="col-md-3 td">
												COD.
											</div>
											<div class="col-md-9 td">
												UNID. DIDÁC.
											</div>
										</div>
									</div>
									<div class="col-md-2 td">
										GRUPO
									</div>
									<div class="col-md-2">
										<div class="row">
											<div class="col-md-3 td">
												ALUM
											</div>
											
											<div class="col-md-9 td text-center">
												SESIONES
											</div>
										</div>
									</div>
									<div class="col-12 col-md-3 ">
										<div class="row">
											<div class="col-md-3 td text-center">
												SES.
											</div>
											<div class="col-md-3 td text-center">
												EVA.
											</div>
											<div class="col-md-3 td text-center">
												ASI.
											</div>
											<div class="col-md-3 td text-center">
												VIR.
											</div>
										</div>
									</div>
									
									<div class="col-md-2 text-center">
										<div class="row">
											<div class=" col-md-4 td">
												<i class="fa fa-hourglass-end" aria-hidden="true"></i>
												<br>
												<small>Abierto</small>
											</div>
											<div class="col-md-4 td">
												<i class="fa fa-eye"></i><br>
												<small>Mostrar</small>
											</div>
											<div class="col-md-4 td">
												REG.
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 tbody">
								<?php
								$nro=0;
								foreach ($cursos as $curso) {
								$ses_colortext="";
								if ($curso->nsesavance > $curso->nsesiones) $ses_colortext="text-danger text-bold";
								$codcurso64=base64url_encode($curso->codcarga);
								$division64=base64url_encode($curso->division);

								$nro++;?>
								<div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>" role="row" data-idcarga='<?php echo $codcurso64 ?>'>
									<div class="col-12 col-md-3">
										<div class="row">
											<div class="col-3 col-md-3 td">
												<b><?php echo $curso->codcarga."G".$curso->division ?></b>
											</div>
											<div class="col-9 col-md-9 td">
												<?php echo "$curso->codcurso  $curso->curso" ?>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-2 td">
										<span class="d-inline-block d-md-none"><b>Grupo:</b> </span> <?php echo $curso->periodo.' - '.$curso->carrera.' - <b>'.$curso->ciclo."</b> ".$curso->turno.' - <b>'.$curso->seccion.$curso->subseccion."</b>" ?>
									</div>
									<div class="col-12 col-md-2">
										<div class="row">
											<div class="col-5 col-md-3 td">
												<span class="d-inline-block d-md-none"><b>Alumnos:</b> </span> <?php echo $curso->alumnos; ?>
											</div>
											
											<div class="col-7 col-md-9 td text-center">
												<span class="d-inline-block d-md-none"><b>Sesiones:</b> </span> <?php echo $curso->nsesavance." / ".$curso->nsesiones." <b>(".round($curso->nsesavance/$curso->nsesiones*100,0).'%)</b>' ?>
												
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-12 col-md-3">
										<div class="row">
											<div class="col-6 col-md-3 td text-center">
												<a href="<?php echo base_url().'seguimiento/docente/curso/'.$codcurso64.'/'.$division64.'/sesiones' ?>" data-toggle="tooltip" title="Sesiones" class="d-block bg-primary text-white tboton" title="Ver detalles" ><i class="far fa-eye"></i> <span class="d-inline-block d-md-none"> SESIONES</span>
												</a>
											</div>

											<div class="col-6 col-md-3 td text-center">
												<a href="<?php echo base_url().'seguimiento/docente/curso/'.$codcurso64.'/'.$division64.'/evaluaciones' ?>" data-toggle="tooltip" title="Evaluaciones" class="d-block bg-primary text-white tboton" title="Ver detalles"  title>
												<i class="fa fa-calculator"></i> <span class="d-inline-block d-md-none"> EVALUACIONES</span>
												</a>
											</div>

										
											<div class="col-6 col-md-3 td text-center">
												<a href="<?php echo base_url().'seguimiento/docente/curso/'.$codcurso64.'/'.$division64.'/asistencias' ?>" data-toggle="tooltip" title="Asistencias" class="d-block bg-primary text-white tboton" title="Ver detalles" ><i class="far fa-calendar-check"></i> <span class="d-inline-block d-md-none"> ASISTENCIAS</span>
												</a>
											</div>

											<div class="col-6 col-md-3 td text-center">
												<a href="<?php echo base_url().'seguimiento/docente/curso/'.$codcurso64.'/'.$division64.'/aula-virtual' ?>" data-toggle="tooltip" title="Aula Virtual" class="d-block bg-primary text-white tboton" title="Ver detalles" ><i class="fas fa-cubes"></i> <span class="d-inline-block d-md-none"> AULA VIRTUAL</span>
												</a>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-2">
										<div class="row">
											<div class="col-4 col-md-4 td text-center">
												<?php 
												$cbgcolor=($curso->activo=='NO') ? "bg-danger": "bg-success";
												?>
												<span class="d-inline-block d-md-none text-bold">Abierto: </span> 
												<span title="Abierto" class="d-inline-block text-white tboton <?php echo $cbgcolor ?>"><?php echo $curso->activo ?></span>
											</div>
											<div class="col-4 col-md-4 td text-center">
												<?php 
												$mbgcolor=($curso->activo=='NO') ? "bg-danger": "bg-success";
												?>
												<span class="d-inline-block d-md-none text-bold">Mostrar: </span> 
												<span title="Mostrar" class="d-inline-block text-white tboton <?php echo $mbgcolor ?>"><?php echo $curso->activo ?></span>
											</div>
											<div class="col-4 col-md-4 td text-center">
												<?php if ($curso->activo=='NO'): ?>
													<span class="d-block bg-gray text-dark tboton"><i class="fa fa-download"></i><i class="far fa-file-pdf"></i></span>
												<?php else: ?>
													<a target="_blank" href="<?php echo base_url().'curso/registro-final-pdf/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="d-block bg-warning text-dark tboton"><i class="fa fa-download"></i><i class="far fa-file-pdf"></i></a>
												<?php endif ?>
												 

											</div>
										</div>
									</div>
								</div>
								
								<?php } ?>
							</div>
							
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		<!--</div>-->
	</section>
</div>
<!--<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>-->
<script>

var btntoggle;
$("#modalPregunta").on('show.bs.modal', function(e) {
    button = $(e.relatedTarget);
    btntoggle = $(e.relatedTarget);
    idcarga = button.data('idcarga');
    flat = button.data('flat');
    $("#btnculminar").data('idcarga', idcarga);
    $("#btnculminar").data('flat', flat);
    var msj = "<h3>¿Deseas Culminar el curso Seleccionado?</h3>"
    if (flat == "activarcurso") {
        msj = "<h3>¿Deseas Activar el curso Seleccionado?</h3>"
    }
    $("#divmsgpregunta").html(msj);
});
$("#btnculminar").click(function(event) {
    $('#modalPregunta').modal('hide');
    var idcurso = $(this).data('idcarga');
    var flat = $(this).data('flat');
    $('#divboxcxd').append('<div id="divoverlay" class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    var acto = base_url + 'curso/' + flat;
    $.ajax({
        url: acto,
        type: 'post',
        dataType: 'json',
        data: {
            idcarga: idcurso,
            mostrar: 'NO'
        },
        success: function(e) {
            $('#divboxcxd #divoverlay').remove();
            if (e.status == false) {
                var msgf = '<div class="alert alert-danger"><h4><i class="icon fa fa-check"></i> Alert!</h4>' + e.msg + '</div>';
                showmsg("Error!", msgf);
            } else {
                var msgf = '<div class="alert alert-success"><h4><i class="icon fa fa-ban"></i> Exito!</h4>' + e.msg + '</div>';
                if (flat == "culminarcurso") {
                    btntoggle.data('flat', "activarcurso");
                    btntoggle.removeClass('btn-success');
                    btntoggle.addClass('btn-danger');
                    btntoggle.html("<i class='fa fa-toggle-off'></i>");
                    btntoggle.parent().attr('data-original-title', 'Activar Curso');
                } else {
                    btntoggle.data('flat', "culminarcurso");
                    btntoggle.removeClass('btn-danger');
                    btntoggle.addClass('btn-success');
                    btntoggle.html("<i class='fa fa-toggle-on'></i>");
                    btntoggle.parent().attr('data-original-title', 'Culminar Curso');
                }
                showmsg("Exito!", msgf);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#divboxcxd #divoverlay').remove();
            showmsg("Error!", msgf);
        },
    });
    return false;
});
</script>
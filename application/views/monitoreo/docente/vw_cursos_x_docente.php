<!--<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">-->
<?php $vbaseurl=base_url(); 
$p66=getPermitido("66");
$p67=getPermitido("67");
?>
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content-wrapper">
	 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>MONITOREO
            	<br>
								
            <small> <?php echo $docente->paterno." ".$docente->materno." ".$docente->nombres; ?></small></h1>
          </div>
          <!--<div class="col-sm-4">
          	<?php
				/*$nombres=$docente->paterno.' '.$docente->materno.' '.$docente->nombres;
				echo '<a href="'.$vbaseurl.'docente/horario/descargar?bcode='.$docente->coddocente.'&bnombre='.$nombres.'" target="_blank" title="Descargar" class="pull-right btn btn-success"><span class="fa fa-download"></span> Horario</a>' */?>
          </div>-->
          <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><i class="fas fa-compass"></i> Monitoreo</li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'monitoreo/docentes?tb=a&pd='.$vcodperiodo ?>">Docentes</a>
                        </li>
                        <li class="breadcrumb-item active">Encuesta</li>
                        <li class="breadcrumb-item active">Población</li>
                    </ol>
                </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

	<section class="content">

		<!--<div id="divboxcxd" class="box">-->
			<div id="divboxcxd"  class="card card-primary">
				<div class="card-body p-2">
					<a class="btn btn-primary btn-flat" href="<?php echo $vbaseurl.'monitoreo/docentes?pd='.$vcodperiodo ?>">
						Otros docentes
					</a>
					<a class="btn btn-primary btn-flat" href="<?php echo $vbaseurl.'monitoreo/docente/'.base64url_encode($docente->coddocente).'/'.base64url_encode($vcodperiodo).'/cursos/estadistica' ?>">
						Estadísticas
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
											<div class="col-md-4 td">
												ESTUD.
											</div>
											
											<div class="col-md-8 td text-center">
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
								<div class="row rowcolor" role="row" <?php echo "data-idcarga='$codcurso64' data-division='$division64'"; ?>>
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
											<!-- 
											<div class="col-5 col-md-4 td">
												<span class="d-inline-block d-md-none"><b>Lista:</b> </span> <?php //echo $curso->alumnos; ?>
												<a class="tboton bg-success d-inline-block" href='<?php echo "{$vbaseurl}monitoreo/docente/curso/miembros/excel/$codcurso64/$division64" ?>'><i class="fas fa-user-graduate"></i><i class="fas fa-bars"></i></a>
											</div>
											-->
											<div class="col-5 col-md-4 td">
												<span class="d-inline-block d-md-none"><b>Lista:</b> </span> <?php //echo $curso->alumnos; ?>
												<a class="tboton bg-success d-inline-block" href='<?php echo "{$vbaseurl}monitoreo/docente/curso/miembros/$codcurso64/$division64" ?>'><i class="fas fa-user-graduate"></i><i class="fas fa-bars"></i></a>
											</div>
											
											<div class="col-7 col-md-8 td text-center">
												<span class="d-inline-block d-md-none"><b>Sesiones:</b> </span> <?php echo $curso->nsesavance." / ".$curso->nsesiones." <b>(".round($curso->nsesavance/$curso->nsesiones*100,0).'%)</b>' ?>
												
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-12 col-md-3">
										<div class="row">
											<div class="col-6 col-md-3 td text-center">
												<a href="<?php echo $vbaseurl.'monitoreo/docente/curso/'.$codcurso64.'/'.$division64.'/sesiones' ?>"  title="Sesiones" class="d-block bg-primary text-white tboton" title="Ver detalles" ><i class="far fa-eye"></i> <span class="d-inline-block d-md-none"> SESIONES</span>
												</a>
											</div>

											<div class="col-6 col-md-3 td text-center">
												<a href="<?php echo $vbaseurl.'monitoreo/docente/curso/'.$codcurso64.'/'.$division64.'/evaluaciones' ?>"  title="Evaluaciones" class="d-block bg-primary text-white tboton" title="Ver detalles"  title>
												<i class="fa fa-calculator"></i> <span class="d-inline-block d-md-none"> EVALUACIONES</span>
												</a>
											</div>

										
											<div class="col-6 col-md-3 td text-center">
												<a href="<?php echo $vbaseurl.'monitoreo/docente/curso/'.$codcurso64.'/'.$division64.'/asistencias' ?>"  title="Asistencias" class="d-block bg-primary text-white tboton" title="Ver detalles" ><i class="far fa-calendar-check"></i> <span class="d-inline-block d-md-none"> ASISTENCIAS</span>
												</a>
											</div>

											<div class="col-6 col-md-3 td text-center">
												<a href="<?php echo $vbaseurl.'monitoreo/docente/curso/'.$codcurso64.'/'.$division64.'/aula-virtual' ?>"  title="Aula Virtual" class="d-block bg-primary text-white tboton" title="Ver detalles" ><i class="fas fa-cubes"></i> <span class="d-inline-block d-md-none"> AULA VIRTUAL</span>
												</a>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-2">
										<div class="row">
											<div class="col-4 col-md-4 td text-center">
												<?php 
												if ($curso->culmino=='SI'){
													$cbgcolor="bg-danger";
													$checked="";
													$culminotext="NO";
												}
												else{
													$cbgcolor="bg-success";
													$checked="checked";
													$culminotext="SI";
												}
												?>
												<span class="d-inline-block d-md-none text-bold">Abierto: </span> 
												<?php if ($p66=="NO"){
													echo 
													"<span title='Abierto' class='d-inline-block text-white tboton $cbgcolor '>$culminotext</span>";
												}
												else{
													echo 
													"<span class='mt-1 d-block'>
														<input $checked  class='checktoggle' data-size='xs' type='checkbox' data-toggle='toggle' data-on='SI' data-off='NO' data-onstyle='success' data-offstyle='danger'>
													</span>";
												}
												?>
											</div>
											<div class="col-4 col-md-4 td text-center">
												<?php 
												if ($curso->activo=='NO'){
													$cbgcolor="bg-danger";
													$checked="";
													
												}
												else{
													$cbgcolor="bg-success";
													$checked="checked";
													
												}
												?>
												<span class="d-inline-block d-md-none text-bold">Mostrar: </span> 
												<?php if ($p67=="NO"){
													echo 
													"<span title='Mostrar' class='d-inline-block text-white tboton $cbgcolor '>$curso->activo</span>";
												}
												else{
													echo 
													"<span class='mt-1 d-block'>
														<input $checked  class='checkOcultar' data-size='xs' type='checkbox' data-toggle='toggle' data-on='SI' data-off='NO' data-onstyle='success' data-offstyle='danger' value='$curso->activo'>
													</span>";
												}
												?>
											</div>
											<div class="col-4 col-md-4 td text-center">
												<div class="btn-group ">  
													<button class="btn btn-warning btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
													<i class="fa fa-download"></i>
													</button> 
													<div class="dropdown-menu  dropdown-menu-right"> 
														<?php if ((getDominio()=="iesap.edu.pe") || (getDominio()=="charlesashbee.edu.pe")){ ?>
														<a target="_blank" href="<?php echo $vbaseurl.'curso/registro-final-pdf/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn-cestado dropdown-item"><i class="far fa-file-pdf mr-1"></i> Registro PDF</a> 
														<a target="_blank" href="<?php echo $vbaseurl.'curso/registro-final-clasico-excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn-cestado dropdown-item" ><i class="far fa-file-pdf mr-1"></i> Registro Clásico Excel</a> 
													<?php } 
													else{  ?>
														<a target="_blank" href="<?php echo $vbaseurl.'curso/registro-final-clasico-excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn-cestado dropdown-item" ><i class="far fa-file-pdf mr-1"></i> Registro Clásico Excel</a> 
													<?php } ?>
														<a target="_blank" href="<?php echo $vbaseurl.'curso/documentos/acta-final-evaluacion-pdf/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn-cestado dropdown-item" ><i class="far fa-file-pdf mr-1"></i> Acta Final PDF</a> 
														<a target="_blank" href="<?php echo $vbaseurl.'curso/documentos/acta-final-evaluacion-excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn-cestado dropdown-item" ><i class="far fa-file-excel mr-1"></i> Acta Final XLS</a> 
														
														<div class="dropdown-divider"></div> 
														 
													</div> 
												</div> 

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
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>-->
<script>

var btntoggle;

<?php if ($p66 == "SI"): ?>
	$('.checktoggle').bootstrapToggle();
	$(".checktoggle").change(function(event) {
	btn=$(this);
    fila=btn.closest('.rowcolor');
    var vdivision =fila.data('division');
    var vcarga = fila.data('idcarga');
    if ($(this).prop('checked') == false) {

        $('#divboxcxd').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'curso/fn_curso_culminar',
            type: 'post',
            dataType: 'json',
            data: {"idcarga": vcarga,"division":vdivision},
            success: function(e) {
                $('#divboxcxd #divoverlay').remove();
                if (e.status == true) {
                    
                } else {
                    btn.bootstrapToggle('destroy');
	                btn.prop('checked', true);
	                btn.bootstrapToggle();
                    Toast.fire({
                        type: 'danger',
                        title: 'Error: ' + e.msg
                    });
                }
            },
            error: function(jqXHR, exception) {
            	//alert("dd");
                btn.bootstrapToggle('destroy');
                btn.prop('checked', true);
                btn.bootstrapToggle();
                $('#divboxcxd #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se pudo culminar',
                    text: msgf,
                    backdrop:false,
                });
            }
        });
    } else {
        $('#divboxcxd').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'curso/fn_curso_reabrir',
            type: 'post',
            dataType: 'json',
            data: {"idcarga": vcarga,"division":vdivision},
            success: function(e) {
                $('#divboxcxd #divoverlay').remove();
                if (e.status == true) {

                } else {
                    btn.bootstrapToggle('destroy');
	                btn.prop('checked', false);
	                btn.bootstrapToggle();
                    Toast.fire({
                        type: 'danger',
                        title: 'Error: ' + e.msg
                    });
                }
            },
            error: function(jqXHR, exception) {
                 btn.bootstrapToggle('destroy');
                btn.prop('checked', false);
                btn.bootstrapToggle();
                $('#divboxcxd #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se pudo culminar',
                    text: msgf,
                    backdrop:false,
                });
            }
        });
    }
});
<?php endif ?>


<?php if ($p67 == "SI"): ?>
	$('.checkOcultar').bootstrapToggle();
	$(".checkOcultar").change(function(event) {
	btn=$(this);
    fila=btn.closest('.rowcolor');
    var vdivision =fila.data('division');
    var vcarga = fila.data('idcarga');
    var chekear=btn.prop('checked') 
    

        $('#divboxcxd').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'curso/fn_curso_ocultar',
            type: 'post',
            dataType: 'json',
            data: {"idcarga": vcarga,"division":vdivision,"accion":!chekear},
            success: function(e) {
                $('#divboxcxd #divoverlay').remove();
                if (e.status == true) {
                    
                } else {
                    btn.bootstrapToggle('destroy');
	                btn.prop('checked', !chekear);
	                btn.bootstrapToggle();
                    Toast.fire({
                        type: 'danger',
                        title: 'Error: ' + e.msg
                    });
                }
            },
            error: function(jqXHR, exception) {
            	//alert("dd");
                btn.bootstrapToggle('destroy');
                btn.prop('checked', !chekear);
                btn.bootstrapToggle();
                $('#divboxcxd #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se pudo culminar',
                    text: msgf,
                    backdrop:false,
                });
            }
        });
  
});
<?php endif ?>


</script>
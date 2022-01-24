<?php $vbaseurl=base_url() ?>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content-wrapper">
<div class="modal fade" id="modal-addalumno" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Buscar Estudiante</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				
				<input id="vidperiodo" name="vidperiodo" type="hidden" class="form-control" value="<?php echo  $carga->codperiodo ?>">
				<input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  $carga->division ?>">
				<input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  base64url_encode($carga->codcarga) ?>">

				<div class="row mt-2">
						<div class="form-group has-float-label col-10 col-sm-10  col-md-3">
	                        <select name="vw_ee_md_cbsede" id="vw_ee_md_cbsede" class="form-control form-control-sm">
	                            
	                            <?php 
	                            $codsede=$_SESSION['userActivo']->idsede;
	                            foreach ($sedes as $sede) {
	                                $selsede=($codsede==$sede->id)?"selected":"";
	                                echo "<option $selsede value='$sede->id'>$sede->nombre </option>";
	                            } ?>
	                        </select>
	                         <label for="vw_ee_md_cbsede">Filial</label>
	                    </div>
						<!--<div class="form-group has-float-label col-12  col-sm-2">
							<select data-currentvalue='' class="form-control form-control-sm" id="vw_ee_md_cbperiodo" name="vw_ee_md_cbperiodo" placeholder="Periodo" required >
								<option value="0">Periodo</option>
								<?php foreach ($periodos as $periodo) {?>
								<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
								<?php } ?>
							</select>
							<label for="vw_ee_md_cbperiodo"> Periodo</label>
						</div>-->
						<div class="form-group has-float-label col-12  col-sm-6">
							<select class="form-control form-control-sm" id="vw_ee_md_cbcarrera" name="vw_ee_md_cbcarrera" placeholder="Programa">
								<option value="%">Todos</option>
								<?php foreach ($carreras as $carrera) {?>
								<option value="<?php echo $carrera->id ?>" data-sigla="<?php echo $carrera->sigla ?>"><?php echo $carrera->nombre ?></option>
								<?php } ?>
							</select>
							<label for="vw_ee_md_cbcarrera"> Programa</label>
						</div>
						<div class="form-group has-float-label col-12  col-md-3">
							<select class="form-control form-control-sm" id="vw_ee_md_cbplan" name="vw_ee_md_cbplan" placeholder="Plan curricular">
								<option value="%">Todos</option>
								<?php foreach ($planes as $plan) {?>
								<option value="<?php echo $plan->codigo ?>"><?php echo $plan->nombre ?></option>
								<?php } ?>
							</select>
							<label for="vw_ee_md_cbplan"> Plan curricular</label>
						</div>
						
						<div class="form-group has-float-label col-12  col-md-2">
							<select data-currentvalue='' class="form-control form-control-sm" id="vw_ee_md_cbciclo" name="vw_ee_md_cbciclo" placeholder="Semestre" required >
								<option value="%">Todos</option>
								<?php foreach ($ciclos as $ciclo) {?>
								<option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
								<?php } ?>
							</select>
							<label for="vw_ee_md_cbciclo"> Semestre</label>
						</div>
						<div class="form-group has-float-label col-12  col-md-2">
							<select data-currentvalue='' class="form-control form-control-sm" id="vw_ee_md_cbturno" name="vw_ee_md_cbturno" placeholder="Turno" required >
								<option value="%">Todos</option>
								<?php foreach ($turnos as $turno) {?>
								<option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
								<?php } ?>
							</select>
							<label for="vw_ee_md_cbturno"> Turno</label>
						</div>
						<div class="form-group has-float-label col-12  col-md-2">
							<select data-currentvalue='' class="form-control form-control-sm" id="vw_ee_md_cbseccion" name="vw_ee_md_cbseccion" placeholder="Sección" required >
								<option value="%">Todas</option>
								<?php foreach ($secciones as $seccion) {?>
								<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
								<?php } ?>
							</select>
							<label for="vw_ee_md_cbseccion"> Sección</label>
						</div>
			


					</div>



				<label for="txtbus-alum">Apellidos y nombres</label>
				<div class="input-group">
					<input id="txt-buscaralumnos" name="txtbus-alum" type="text" class="form-control form-control-sm" value="">
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="button" id="btn-buscaralumnos">
						Ir <i class="fa fa-search" aria-hidden="true"></i></button>
					</span>
				</div>
				<div class="" id="lista-alumnos">
					
				</div>
				
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="button" class="btn pull-right" data-dismiss="modal">Terminar
				</button>
			</div>
		</div>
	</div>
</div>
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
							<input type="text" class="form-control" readonly value="<?php echo $carga->codperiodo ?>">
							<label for="fdc-cbperiodo"> Periodo</label>
						</div>
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
							<?php  $docente=(is_null($carga->coddocente)) ?"SIN DOCENTE": "$carga->paterno $carga->materno $carga->nombres"
							 ?>
							<input type="text" class="form-control" value="<?php echo $docente ?>" readonly>
							<label for="fdc-cbdocente"> Docente</label>
						</div>
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
							<input type="text" class="form-control" value="<?php echo $carga->carrera ?>" readonly >
							<label for="fca-carrera"> Programa</label>
						</div>
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-4">
							<input type="text" class="form-control"  value="<?php echo $carga->codplan.' - '.$carga->plan ?>" readonly>
							<label for="fca-plan"> Plan curricular</label>
						</div>
						
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
							<input type="text" class="form-control"  value="<?php echo $carga->ciclo ?>"readonly>
							<label for="fca-cbciclo"> Ciclo</label>
						</div>
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
							<input type="text" class="form-control"  value="<?php echo $carga->codturno ?>"readonly>
							<label for="fca-cbturno"> Turno</label>
						</div>
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-1">
							<input type="text" class="form-control"  value="<?php echo $carga->codseccion ?>"readonly>
							<label for="fca-cbseccion"> Sección</label>
						</div>
						<div class="form-group has-float-label col-12 col-xs-12 col-sm-1">
							<input type="text" class="form-control"  value="<?php echo $carga->division ?>"readonly>
							<label for="fca-cbseccion"> División</label>
						</div>
						<div class="col-sm-2">
							<a href="#" class="btn btn-primary btn-block" data-carga='<?php echo $carga->codcarga ?>' data-toggle="modal" data-target="#modal-addalumno">
								<i class="fas fa-user-plus mr-2"></i> Enrolar
							</a>
						</div>
						
					</div>

				</form>
			</div>
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Registro de carga académica por grupo</h3>
			</div>
			<div class="card-body">
				
				<select id="cbenrolar" multiple="multiple">
					<?php foreach ($miembros as $key => $mb) {
						$vcheck='';
						if (($mb->idmiembro!='0') && ($mb->eliminado=='NO') && ($carga->division==$mb->division)){
							$vcheck="selected";
						}
					?>
						<option <?php echo $vcheck ?> data-eliminado='<?php echo $mb->eliminado ?>' data-idmiembro='<?php echo base64url_encode($mb->idmiembro) ?>' data-division='<?php echo $mb->division ?>' value="<?php echo base64url_encode($mb->codmatricula) ?>"><?php echo $mb->carnet.' '.$mb->paterno.' '.$mb->materno.' '.$mb->nombres ?></option>
					<?php 

					} ?>
				</select>
			</div>
		</div>
		
	</section>
</div>
<?php
?>
<link rel="stylesheet" type="text/css" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.css">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script>
	var vcodcarga = '<?php echo base64url_encode($carga->codcarga); ?>';
	var vdivision = '<?php echo $carga->division; ?>';
	var vnm='<?php echo base64url_encode("0"); ?>';
	const Toast = Swal.mixin({
	    toast: true,
	    position: 'top-end',
	    showConfirmButton: false,
	    timer: 5000
	})
	var demo2=$('#cbenrolar').bootstrapDualListbox({
	    nonSelectedListLabel: 'Disponibles',
	    selectedListLabel: 'Miembros',
	    preserveSelectionOnMove: 'moved',
	    moveOnSelect: false,
	    nonSelectedFilter: '',
	    selectorMinimalHeight: 460
	});
	var lastState = $('#cbenrolar').val();
	$(function() {
	  var customSettings = $('#cbenrolar').bootstrapDualListbox('getContainer');
	  customSettings.find('.moveall').remove();
	  customSettings.find('.removeall').remove();
	});
	$('#cbenrolar').on('change', function(ef) {
		

	        var newState = $(this).val();
	        var vquitar = $(lastState).not(newState).get();
	        var vagregar = $(newState).not(lastState).get();
	        lastState = newState;
	        //AJAX PARA AGREGAR MIEMBROS
	        $.each(vagregar, function(indice, elemento) {
	            var codmatricula = elemento;
	            $("#cbenrolar option").each(function(index) {
	            	if ($(this).attr('value')==elemento){
	            		var option = $(this);
		                var veliminado = $(this).data('eliminado');
		                var vidmiembro = $(this).data('idmiembro');
		                 $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		                $.ajax({
		                    url: base_url + 'miembros/fn_insert',
		                    type: 'post',
		                    dataType: 'json',
		                    data: {
		                        "fm-codcarga": vcodcarga,
		                        "fm-division": vdivision,
		                        "fm-codmatricula": elemento,
		                        "fm-idmiembro": vidmiembro
		                    },
		                    success: function(e) {
		                        if (e.status == true) {
		                        	texto=option.text();
		                        	option.remove();
		                        	optiont="<option selected data-eliminado='NO' data-idmiembro='"+e.newcod+"' data-division='"+vdivision+"' value='"+elemento+"'>"+texto+"</option>";
		                            $('#cbenrolar').append(optiont);
		                            //demo2.bootstrapDualListbox('refresh', true);
		                        }
		                        $('#divcard_grupo #divoverlay').remove();
		                    },
		                    error: function(jqXHR, exception) {

		                        $('#divcard_grupo #divoverlay').remove();
		                        return 0;
		                    },
		                });
	            	}
	                
	            });
	        })
	     	//demo2.bootstrapDualListbox('refresh', true);
	        $.each(vquitar, function(indice, elemento) {
	            var codmatricula = elemento;
	            $("#cbenrolar option").each(function(index) {
	            	if ($(this).attr('value')==elemento){
	            		var option = $(this);
		                var vidmiembro = $(this).data('idmiembro');
		                var vdivision = $(this).data('divsiion');
		                $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		                $.ajax({
		                    url: base_url + 'miembros/fn_retirar',
		                    type: 'post',
		                    dataType: 'json',
		                    data: {
		                        "fm-idmiembro": vidmiembro
		                    },
		                    success: function(e) {
		                        if (e.status == true) {
		                        	texto=option.text();
		                        	option.remove();
		                        	optiont="<option data-eliminado='SI' data-idmiembro='"+vidmiembro+"' data-division='"+vdivision+"' value='"+elemento+"'>"+texto+"</option>";
		                            $('#cbenrolar').append(optiont);
		                            //demo2.bootstrapDualListbox('refresh', true);
		                        }
		                        $('#divcard_grupo #divoverlay').remove();
		                    },
		                    error: function(jqXHR, exception) {

		                        $('#divcard_grupo #divoverlay').remove();
		                        return 0;
		                    },
		                });
	            	}
	                
	            });
	        })

	        demo2.bootstrapDualListbox('refresh', true);
	        
	    });

	$('#modal-addalumno').on('hide.bs.modal', function () {
		location.reload();
// do something…
	});
		$('#txt-buscaralumnos').keypress(function(event) {
			var keycode = event.keyCode || event.which;
		if(keycode == '13') {
		$('#btn-buscaralumnos').click();
		}
		});
	$("#btn-buscaralumnos").click(function(event) {
		$('#lista-alumnos').html('<center><h4 class="text-primary">Buscando</h4><br /><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span><center>');
		
		var vcarga=$("#vidcurso").val();
		var valumno=$("#txt-buscaralumnos").val();
		var vperiodo=$("#vidperiodo").val();
		var vdivision=$("#vdivision").val();

		var cbsede=$("#vw_ee_md_cbsede").val();
		var cbcarrera=$("#vw_ee_md_cbcarrera").val();
		var cbplan=$("#vw_ee_md_cbplan").val();
		var cbciclo=$("#vw_ee_md_cbciclo").val();
		var cbturno=$("#vw_ee_md_cbturno").val();
		var cbseccion=$("#vw_ee_md_cbseccion").val();
		$.ajax({
							url: base_url + 'miembros/vw_lista_posibles_miembros_grupo'	,
				type: 'post',
				dataType: 'json',
				data: {carga: vcarga,
						periodo:vperiodo,
						alumno:valumno,
						division:vdivision,
						sede: cbsede,
						carrera: cbcarrera,
						plan: cbplan,
						ciclo: cbciclo,
						turno: cbturno,
						seccion: cbseccion},
				success: function(e) {
					if (e.status==true){
						$('#lista-alumnos').html(e.vdata);
					}
					else{
						$('#lista-alumnos').html(e.msg);
					}
					
				},
			error: function (jqXHR, exception) {
				var msgf=errorAjax(jqXHR, exception,'div');
			$('#lista-alumnos').html(msgf);
		},
			});
		return false;
	});

	$("#vw_ee_md_cbcarrera").change(function(event) {
   		/* Act on the event */
	    if ($(this).val() != "%") {
	        $('#vw_ee_md_cbplan').html("<option value='%'>Sin opciones</option>");
	        var codcar = $(this).val();
	        if (codcar == '%') return;
	        $.ajax({
	            url: base_url + 'plancurricular/fn_get_planes_activos_combo',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtcodcarrera: codcar
	            },
	            success: function(e) {
	                $('#vw_ee_md_cbplan').html(e.vdata);
	            },
	            error: function(jqXHR, exception) {
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#vw_ee_md_cbplan').html("<option value='%'>" + msgf + "</option>");
	            }
	        });
	    } else {
	        $('#vw_ee_md_cbplan').html("<option value='%'>Seleciona un carrera<option>");
	    }
	});

	</script>
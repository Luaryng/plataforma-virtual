<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<h1>MONITOREO
					<small>DOCENTES</small></h1>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<div id="divcard-general" class="card">
			<div class="card-header p-2">
				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link active" href="#tab-academico" data-vartab="a" data-toggle="tab">
							<i class="fas fa-user-tag mr-1"></i>Curricular
						</a>
					</li>
					<li id="tabli-aperturafile" class="nav-item">
						<a class="nav-link" href="#tab-encuestas" data-vartab="e" data-toggle="tab">
							<i class="fas fa-chart-bar mr-1"></i>Encuesta a Estudiante
						</a>
					</li>
					<li id="tabli-aperturafile" class="nav-item">
						<a class="nav-link" href="#tab-actividad" data-vartab="c" data-toggle="tab">
							<i class="fas fa-chart-bar mr-1"></i>Actividad
						</a>
					</li>
				</ul>
			</div>
			<!-- /.card-header -->
			<div class="card-body p-3">
				<div class="tab-content ">
					<div class="active tab-pane" id="tab-academico">
						<div class="col-md-4 form-group row ">
							<div class="input-group border-bottom   input-group-sm ">
							  	<div class="input-group-prepend">
							    	<span class="input-group-text bg-transparent  border-0 pr-0"><i class="fas fa-chart-pie"></i></span>
							  	</div>
							  	<select placeholder="Periodo" class="form-control border-0" name="vw_md_acad_cbperiodo" id="vw_md_acad_cbperiodo">
									<option value="">PERIODO</option>
									<?php foreach ($periodos as $lsperiodo) {?>
									<option	value="<?php echo $lsperiodo->codigo ?>"><?php echo $lsperiodo->nombre ?></option>
									<?php }?>
								</select>
								<div class="input-group-append">
									<button class="btn btn-success" type="button" id="vw_md_busca_curricular"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</div>
						<hr>
						<div id="vw_md_cur_div_docentes">
							<?php 
							if ($periodo==""){
								$resultados="<h4>SELECCIONA UN PERIODO</h4>" ;
							}
							echo $resultados;
							?>
						</div>
					</div>
					<div class="tab-pane" id="tab-encuestas">
						<div class="row">
							<div class="col-10 col-md-4 form-group ">
								<div class="input-group border-bottom input-group-sm">
								  	<div class="input-group-prepend">
								    	<span class="input-group-text bg-transparent  border-0 pr-0"><i class="fas fa-chart-pie"></i></span>
								  	</div>
								  	<select placeholder="Periodo" class="form-control border-0" name="vw_encu_cbperiodo" id="vw_encu_cbperiodo">
										<option value="">PERIODO</option>
										<?php foreach ($periodos as $lsperiodo) {?>
										<option	value="<?php echo $lsperiodo->codigo ?>"><?php echo $lsperiodo->nombre ?></option>
										<?php }?>
									</select>
									<div class="input-group-append">
										<button class="btn btn-success" type="button" id="vw_md_busca_encuestas"><i class="fas fa-search"></i></button>
									</div>
								</div>
							</div>
							<div class="col-2 col-md-5 form-group text-right ">
								<a href="<?php echo $vbaseurl ?>monitoreo/docentes/encuesta-dd/crear" class="btn btn-primary text-white btn-sm" role="button" id="vw_moal_btncrear">
									<i class="fas fa-plus"></i> Crear
								</a>
							</div>
							<div class="col-12">
								<h5 class="text-primary">CREADAS</h5>
								<div class="btable">
									<div class="thead col-12  d-none d-md-block">
										<div class="row">
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-2 td">N°</div>
													<div class="col-md-4 td">PERIODO</div>
													<div class="col-md-6 td">NOMBRE</div>
												</div>
											</div>
											<div class="col-md-2 td">DESCRIPCIÓN.</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-4 td">CREADO</div>
													<div class="col-md-4 td">INICIO</div>
													<div class="col-md-4 td">CIERRE</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-6 td">ESTADO</div>
												</div>
											</div>
										</div>
									</div>
									<div id="div-encucreadas" class="tbody col-12">
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab-actividad">
						<div class="row">
							<div class="col-12">
								<h5 class="text-primary">Creadas</h5>
								<div class="btable">
									<div class="thead col-12  d-none d-md-block">
										<div class="row">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-1 td">N°</div>
													<div class="col-md-11 td">DOCENTE</div>
												</div>
											</div>								
											<div class="col-md-2 td">USUARIO</div>
											<div class="col-md-2 td">ULT. ACCESO</div>
											
										</div>
									</div>
									<div id="div-accesos" class="tbody col-12">
										<?php 
										$nroac=0;
										foreach ($accesos as $keya => $acc) {
											$nroac++;
											$sexicon=($acc->sexo=='MASCULINO') ? '<i class="fas fa-male fa-lg text-primary"></i>':'<i class="fas fa-female  fa-lg text-danger"></i>';
											$fcult= date('d-m-Y h:i a',strtotime($acc->ultimo));
											echo 
											"<div class='row'>
												<div class='col-md-4'>
													<div class='row'>
														<div class='col-md-1 td'>
															$nroac
														</div>
														<div class='col-md-11 td'>
															<b class='mr-2'>$sexicon</b>
															$acc->paterno $acc->materno $acc->nombres 
														</div>
													</div>
												</div>
												<div class='col-md-2 td'>
													$acc->usuario
												</div>
												<div class='col-md-2 td'>
													$fcult
												</div>
											</div>"
											;


										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				
			</div>
			
		</div>

		<div id="divboxpagos" class="card card-success">
			
		</div>
	</section>
</div>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->

	<script type="text/javascript" charset="utf-8">
		$("#vw_md_busca_curricular").click(function(event) {
			var cbper=$("#vw_md_acad_cbperiodo").val();
			if (cbper==""){
        		$('#vw_md_cur_div_docentes').html("<div class='card card-outline card-secondary'>" +
					"<div class='card-body text-danger'>" +
						"No hay suficientes datos para realizar un análisis	" +
				   	"</div>" + 
		   		"</div>" );
        		$('#divcard-general #divoverlay').remove();
        		return;
        	}
		    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fa fa-refresh fa-spin"></i></div>');
		    var active= getUrlParameter('tb', "a");
		    $.ajax({
		        url: base_url + 'monitoreo_docente/vw_docentes_periodo',
		        type: 'post',
		        dataType: 'json',
		        data: {
		            cbperiodo: cbper
		        },
		        success: function(e) {
		            if (e.status == false) {
		                var msgf = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg + '</div>';
		                $('#vw_md_cur_div_docentes').html(msgf);
		            } else {
		            	if (history.pushState) {
				        	var urlpd="";
				        	var pd=cbper;
				        	
				        	if (pd!="") urlpd='&pd=' + pd;
				            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tb=' + active + urlpd;
				            window.history.pushState({
				                path: newurl
				            }, '', newurl);
				        }
		                $('#vw_md_cur_div_docentes').html(e.docentes);
		            }
		            $('#divcard-general #divoverlay').remove();
		        },
		        error: function(jqXHR, exception) {
		            var msgf = errorAjax(jqXHR, exception,'div');
		            $('#divcard-general #divoverlay').remove();
		            $('#vw_md_cur_div_docentes').html(msgf);
		        },
		    });
		    return false;
		});

		function duplicarEncuesta(btn) {
			codencu=btn.data('encu');
			
		    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fa fa-refresh fa-spin"></i></div>');
		    $.ajax({
		        url: base_url + 'cuestionario_general/fn_clonar_encuesta',
		        type: 'post',
		        dataType: 'json',
		        data: {
		            codclone: codencu
		        },
		        success: function(e) {
		        	$('#divcard-general #divoverlay').remove();
		            if (e.status == false) {
		                Swal.fire(
		                    'Error!',
		                    e.msg,
		                    'error'
		                )
		            } else {
		                $("#vw_md_busca_encuestas").click();
		            }
		            
		        },
		        error: function(jqXHR, exception) {
		        	$('#divcard-general #divoverlay').remove();
		            var msgf = errorAjax(jqXHR, exception,'text');
		            Swal.fire(
	                    'Error!',
	                    msgf,
	                    'error'
	                )
		        },
		    });
		    return false;
		}

		function EliminarEncuesta(btn) {
			codencu=btn.data('encu');
			fila=btn.closest('.cfila');
		    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fa fa-refresh fa-spin"></i></div>');
		    $.ajax({
		        url: base_url + 'cuestionario_general/fn_eliminar_encuesta',
		        type: 'post',
		        dataType: 'json',
		        data: {
		            codclone: codencu
		        },
		        success: function(e) {
		        	$('#divcard-general #divoverlay').remove();
		            if (e.status == false) {
		                Swal.fire(
		                    'Error!',
		                    e.msg,
		                    'error'
		                )
		            } else {
		                //$("#vw_md_busca_encuestas").click();
		                fila.remove();
		            }
		            
		        },
		        error: function(jqXHR, exception) {
		        	$('#divcard-general #divoverlay').remove();
		            var msgf = errorAjax(jqXHR, exception,'text');
		            Swal.fire(
	                    'Error!',
	                    msgf,
	                    'error'
	                )
		        },
		    });
		    return false;
		}
		
		$("#vw_md_busca_encuestas").click(function(event) {
			$('input:text,select').removeClass('is-invalid');
		    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		    $("#div-encucreadas").html("");
		    var codper=$("#vw_encu_cbperiodo").val();
		    $.ajax({
		        url: base_url + 'cuestionario_general/fn_get_cuestionarios_creador_observador'	,
		        type: 'post',
		        dataType: 'json',
		        data: {"vw_encu_cbperiodo":codper} ,
		        success: function(e) {
		            if (e.status == false) {
		            	$.each(e.errors, function(key, val) {  
		                    $('#' + key).addClass('is-invalid');
		                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
		                });
		            }
		            else {
		            	var nro=0;
		                $.each(e.encucreadas, function(index, v) {
		                    /* iterate through array or object */
		                    nro++;

		                    var btn_editar='<a class="dropdown-item" href="' + base_url + 'monitoreo/docentes/encuesta-dd/editar/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-edit"></i> Editar</a>';
		                    var btn_poblacion='<a class="dropdown-item" href="' + base_url + 'monitoreo/docentes/encuesta-dd/poblacion/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-user-friends"></i> Población</a>';
		                    var btn_preguntas='<a class="dropdown-item" href="' + base_url + 'monitoreo/docentes/encuesta-dd/preguntas/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="far fa-question-circle"></i> Preguntas</a>';
							//
		                    var btn_duplicar='<a class="dropdown-item" data-encu="' + v['codigo'] + '"  onclick="duplicarEncuesta($(this));event.preventDefault();" href="#"><i class="fas fa-th-large"></i> Duplicar</a>';
		                    var btn_eliminar='<a class="dropdown-item text-danger" data-encu="' + v['codigo'] + '"  onclick="EliminarEncuesta($(this));event.preventDefault();" href="#"><i class="fas fa-trash"></i> Eliminar</a>';
		                    //btnord_merito='<a  href="' + base_url + 'academico/consulta/orden-merito/imprimir?' + params + '&at=1'+'"><i class="fas fa-sort-numeric-up-alt mr-1"></i> Mérito</a>';
		                    var btn_resultados='<a href="' + base_url + 'monitoreo/docentes/encuesta-dd/resultados/' + v['codigo'] + '"><u><i class="fas fa-chart-bar"></i> Resultados</u></a>';
		                    $("#div-encucreadas").append(

		                        '<div class="cfila row">' +
		                          '<div class="col-12 col-md-4">' +
		                            '<div class="row">' +
		                              '<div class="col-1 col-md-1 td">' + nro + '</div>' +
		                              '<div class="col-3 col-md-3 td">' + v['periodo'] + '</div>' +
		                              '<div class="col-8 col-md-8 td">' + v['nombre'] + '<br><small>Creado: ' + v['creado'] + '</small></div>' +
		                            '</div>' +
		                          '</div>' +
		                          '<div class="col-8 col-md-2 td">' + v['descripcion'] + '</div>' +
		                          '<div class="col-12 col-md-2">' +
		                            '<div class="row">' +
		                              '<div class="col-6 col-md-6 text-right td">' + v['inicia'] + '</div>' +
		                              '<div class="col-6 col-md-6 text-right td">' + v['vence'] + '</div>' +
		                            '</div>' +
		                          '</div>' +
		                          '<div class="col-12 col-md-4">' +
		                            '<div class="row">' +
		                              '<div class="col-4 col-md-4 td">' +
		                               	v['estado'] + 
		                              '</div>' +
		                              '<div class="col-4 col-md-4 td text-right">' + 
				                        '<div class="btn-group btn-group-sm" role="group">' + 
				                          '<button class="bg-primary p-1 text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
				                              ' Opciones' +
				                          '</button>' +
				                          '<div class="dropdown-menu dropdown-menu-right">' +
				                              btn_editar +
				                              '<div class="dropdown-divider"></div>' + 
				                              btn_preguntas +
				                              btn_poblacion +
				                              btn_duplicar +
				                              '<div class="dropdown-divider"></div>' + 
				                              btn_eliminar + 
				                          ' </div>' +
				                        '</div>' +
			                      	  '</div>' +
			                      	  '<div class="col-8 col-md-4 td">' + btn_resultados + '</div>' +
		                            '</div>' +
		                          '</div>' +
		                           
		                        '</div>');
		                }); 
		            }
		            $('#divcard-general #divoverlay').remove();
		        },
		        error: function(jqXHR, exception) {
		            var msgf = errorAjax(jqXHR, exception, 'text');
		            $('#divcard-general #divoverlay').remove();
		        }
		    });
		    return false;
		});
		
		$(document).ready(function() {
		    var vtab = getUrlParameter('tb', "a");
		    var pd=getUrlParameter('pd', "");
		    if (vtab == "e") {
		        $('.nav-pills a[href="#tab-encuestas"]').tab('show');
		        $("#vw_encu_cbperiodo").val(pd);
		        if (pd!="") $("#vw_md_busca_encuestas").click();
		    } 
		    else if (vtab == "c") {
		    	$('.nav-pills a[href="#tab-actividad"]').tab('show');

		    } 
		    else {
		        $('.nav-pills a[href="#tab-academico"]').tab('show');
		        $("#vw_md_acad_cbperiodo").val(pd);
		        if (pd!="") $("#vw_md_busca_curricular").click();

		    }

		    $('.nav-pills a').on('shown.bs.tab', function(event) {
		        if (history.pushState) {
		        	var urlpd="";
		        	var pd=getUrlParameter('pd', "");
		        	if (pd!="") urlpd='&pd=' + pd;
		            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tb=' + $(event.target).data('vartab') + urlpd;
		            window.history.pushState({
		                path: newurl
		            }, '', newurl);


		        }
		    });
		});

	</script>
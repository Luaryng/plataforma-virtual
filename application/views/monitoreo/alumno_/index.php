<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<h1>MONITOREO
					<small>ALUMNOS</small></h1>
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
							<u><i class="fas fa-user-tag mr-1"></i>Académico</u>
						</a>
					</li>
					<li id="tabli-aperturafile" class="nav-item">
						<a class="nav-link" href="#tab-encuestas" data-vartab="e" data-toggle="tab">
							<u><i class="fas fa-chart-bar mr-1"></i>Encuestas</u>
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
							  	<select placeholder="Periodo" class="form-control border-0" name="vw_acad_cbperiodo" id="vw_acad_cbperiodo">
									<option value="">PERIODO</option>
									<?php foreach ($periodos as $lsperiodo) {?>
									<option	value="<?php echo $lsperiodo->codigo ?>"><?php echo $lsperiodo->nombre ?></option>
									<?php }?>
								</select>
							</div>
						</div>

							
						
						<div class="row">
							<div class="col-lg-4">
								<div class="input-group border-bottom  input-group-sm ">
									<div class="input-group-prepend">
							    		<span class="input-group-text bg-transparent border-0 pr-0"><i class="far fa-address-card"></i></span>
							  		</div>
									<input title="Carné" type="text" name="txtbusca_carne" id="txtbusca_carne" class="form-control border-0" placeholder="Carné">
									<div class="input-group-append">
										<button class="btn btn-success btn-md" type="button" id="busca_alumno"><i class="fas fa-search"></i></button>
									</div>
								</div>
								<!-- /input-group -->
							</div>
							<div class="col-lg-8">
								<div class="input-group border-bottom  input-group-sm ">
									<div class="input-group-prepend">
							    		<span class="input-group-text bg-transparent border-0 pr-0"><i class="fas fa-user-tag"></i></span>
							  		</div>
									<input title="Apellidos y Nombres" type="text" name="txtbusca_apellnom" id="txtbusca_apellnom" class="form-control border-0" placeholder="Apellidos y Nombres">
									<div class="input-group-append">
										<button class="btn btn-success" type="button" id="busca_apellnom"><i class="fas fa-search"></i></button>
									</div>
								</div>
								
							</div>
						</div>
						<hr>
						
						<div id="divmatriculados" class="p-0">
							
						</div>
						<div class="col-12" id="divdatosmat">
							
						</div>
						<div class="table-responsive" id="divmiscursos">
							<h4 class="text-primary"><center></center></h4>
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
										<button class="btn btn-success" type="button" id="busca_encuestas"><i class="fas fa-search"></i></button>
									</div>
								</div>
							</div>
							<div class="col-2 col-md-5 form-group text-right ">
								<a href="<?php echo $vbaseurl ?>monitoreo/estudiantes/encuesta/crear" class="btn btn-primary text-white btn-sm" role="button" id="vw_moal_btncrear">
									<i class="fas fa-plus"></i> Crear
								</a>
							</div>
						</div>
						<div class="col-12">
							<h5 class="text-primary">Creadas</h5>
							<div class="btable">
								<div class="thead col-12  d-none d-md-block">
									<div class="row">
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-3 td">N°</div>
												<div class="col-md-9 td">PERIODO</div>
											</div>
										</div>
										<div class="col-md-3 td">NOMBRE</div>
										<div class="col-md-3">
											<div class="row">
												<div class="col-md-4 td">CREADO</div>
												<div class="col-md-4 td">INICIO</div>
												<div class="col-md-4 td">CIERRE</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="row">
												<div class="col-md-6 td">CREADOR</div>
												<div class="col-md-6 td">DESCRIPCIÓN.</div>
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
				<!-- /.tab-content -->
			</div>
			<!-- /.card-body -->
		</div>




		<div id="divboxpagos" class="card card-success">
			
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
			var cbper=$('#vw_acad_cbperiodo').val();
			$('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			$.ajax({
				url: base_url + 'matricula/vwcurso_x_periodo_carne'	,
				type: 'post',
				dataType: 'json',
				data: {txtbusca_carne: tcar,cbperiodo: cbper},
				success: function(e) {
					$('#divcard-general #divoverlay').remove();
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
				$('#divcard-general #divoverlay').remove();
				$('#divmiscursos').html(msgf);
				},
			});
			return false;
		}

		$('#busca_apellnom').click(function() {
			$('#divmiscursos').html("");
			$('#divdatosmat').html("");
			
			var tcar=$('#txtbusca_apellnom').val();
			var cbper=$('#vw_acad_cbperiodo').val();
			
			$('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
			$.ajax({
				url: base_url + 'matricula/vw_matriculados'	,
				type: 'post',
				dataType: 'json',
				data: {txtbusca_apellnom: tcar,cbperiodo: cbper},
				success: function(e) {
					$('#divcard-general #divoverlay').remove();
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
				$('#divcard-general #divoverlay').remove();
				$('#divmatriculados').html(msgf);
		},
			});
			return false;
		});
		$(document).ready(function() {
		    var vtab = getUrlParameter('tb', "a");
		    if (vtab == "e") {
		        $('.nav-pills a[href="#tab-encuestas"]').tab('show');
		    } else {
		        $('.nav-pills a[href="#tab-academico"]').tab('show');

		    }

		    $('.nav-pills a').on('shown.bs.tab', function(event) {
		        if (history.pushState) {
		            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tb=' + $(event.target).data('vartab');
		            window.history.pushState({
		                path: newurl
		            }, '', newurl);


		        }
		    });
		});
		$("#busca_encuestas").click(function(event) {
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
		                    /*mt = mt + parseInt(v['mat']);
		                    ac = ac + parseInt(v['act']);
		                    rt = rt + parseInt(v['ret']);
		                    cl = cl + parseInt(v['cul']);
		                    var vcm = base64url_encode(v['codigo']);
		                    var url = base_url + "academico/matricula/imprimir/" + vcm;
		                    var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
		                    var btnscolor="";
		                    switch(v['estado']) {
		                      case "ACT":
		                          btnscolor="btn-success";
		                        break;
		                      case "CUL":
		                        btnscolor="btn-secondary";
		                        break;
		                      case "RET":
		                        btnscolor="btn-danger";
		                        break;
		                      default:
		                        btnscolor="btn-warning";
		                    }*/
		                    var btn_editar='<a class="dropdown-item" href="' + base_url + 'monitoreo/estudiantes/encuesta/editar/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-edit"></i> Editar</a>';
		                    var btn_poblacion='<a class="dropdown-item" href="' + base_url + 'monitoreo/estudiantes/encuesta/poblacion/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-user-friends"></i> Población</a>';
		                     var btn_preguntas='<a class="dropdown-item" href="' + base_url + 'monitoreo/estudiantes/encuesta/preguntas/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="far fa-question-circle"></i> Preguntas</a>';
		                    //btnord_merito='<a  href="' + base_url + 'academico/consulta/orden-merito/imprimir?' + params + '&at=1'+'"><i class="fas fa-sort-numeric-up-alt mr-1"></i> Mérito</a>';
		                    $("#div-encucreadas").append(

		                        '<div class="cfila row">' +
		                          '<div class="col-12 col-md-3">' +
		                            '<div class="row">' +
		                              '<div class="col-2 col-md-2 td">' + nro + '</div>' +
		                              '<div class="col-4 col-md-4 td">' + v['periodo'] + '</div>' +
		                              '<div class="col-6 col-md-6 td">' + v['nombre'] + '</div>' +
		                            '</div>' +
		                          '</div>' +
		                          '<div class="col-12 col-md-3">' +
		                            '<div class="row">' +
		                              '<div class="col-4 col-md-4 td">' + v['objetivo'] + '</div>' +
		                              '<div class="col-8 col-md-8 td">' + v['descripcion'] + '</div>' +
		                            '</div>' +
		                          '</div>' +

		                          
		                          '<div class="col-12 col-md-3">' +
		                            '<div class="row">' +
		                              '<div class="col-4 col-md-4 td">' + v['creado'] + '</div>' +
		                              '<div class="col-4 col-md-4 td">' + v['inicia'] + '</div>' +
		                              '<div class="col-4 col-md-4 td">' + v['vence'] + '</div>' +
		                            '</div>' +
		                          '</div>' +
		                          '<div class="col-12 col-md-3">' +
		                            '<div class="row">' +
		                              '<div class="col-4 col-md-6 td">' +
		                               	v['estado'] + 
		                              '</div>' +
		                              '<div class="col-4 col-md-6 td text-right">' + 
				                        '<div class="btn-group btn-group-sm" role="group">' + 
				                          '<button class="bg-primary p-1 text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
				                              ' Opciones' +
				                          '</button>' +
				                          '<div class="dropdown-menu dropdown-menu-right">' +
				                              btn_editar +
				                              '<div class="dropdown-divider"></div>' + 
				                              btn_preguntas +
				                              btn_poblacion +

				                          ' </div>' +
				                        '</div>' +
			                      '</div>' +
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
		            //$('#divError').show();
		            //$('#msgError').html(msgf);
		        }
		    });
		    return false;
		});

	</script>
<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<h1>MONITOREO
					<small>RESULTADOS</small></h1>
				</div>
				<div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><i class="fas fa-compass"></i> Monitoreo</li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'monitoreo/docentes?tb=e&pd='.$vcencuesta->codperiodo ?>">Docentes</a>
                        </li>
                        <li class="breadcrumb-item active">Encuesta</li>
                        <li class="breadcrumb-item active">Resultados</li>
                    </ol>
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
							<i class="fas fa-user-tag mr-1"></i>Por Docente
						</a>
					</li>
					<!--<li id="tabli-aperturafile" class="nav-item">
						<a class="nav-link" href="#tab-encuestas" data-vartab="e" data-toggle="tab">
							<i class="fas fa-chart-bar mr-1"></i>Desempeño Docente
						</a>
					</li>-->
				</ul>
				<input id="vw_md_encuesta" type="hidden" value="<?php echo $vccodencuesta ?>">
				<input id="vw_md_encuesta_pmax" type="hidden" value="<?php echo floatval($vcencuesta->puntos_max) ?>">
				
			</div>
			<!-- /.card-header -->
			<div class="card-body p-3">
				<div class="tab-content ">
					<div class="active tab-pane" id="tab-academico">
						<div class="form-group ">
							<div class="input-group border-bottom   input-group-sm ">
							  	<div class="input-group-prepend">
							    	<span class="input-group-text bg-transparent  border-0 pr-0"><i class="fas fa-chart-pie"></i></span>
							  	</div>
							  	<select placeholder="Docente" class="form-control border-0" name="vw_md_acad_cbdocente" id="vw_md_acad_cbdocente">
									<option value="">Selecciona docente</option>
									<?php foreach ($vcdocentes as $lsdocente) {?>
									<option	value="<?php echo $lsdocente->coddocente ?>"><?php echo "$lsdocente->paterno $lsdocente->materno $lsdocente->nombres" ?></option>
									<?php }?>
								</select>
								<div class="input-group-append">
									<button class="btn btn-success" type="button" id="vw_md_busca_curricular"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</div>
						
						<div id="vw_md_cur_div_resultados" class="col-12 p-0">

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
								<a href="<?php echo $vbaseurl ?>monitoreo/docentes/encuesta-dd/crear" class="btn btn-primary text-white btn-sm" role="button" id="vw_moal_btncrear">
									<i class="fas fa-plus"></i> Crear
								</a>
							</div>
						</div>
						<div class="col-12">
							<h5 class="text-primary">Creadas</h5>
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
				<!-- /.tab-content -->
			</div>
			<!-- /.card-body -->
		</div>

		<div id="divboxpagos" class="card card-success">
			
		</div>
	</section>
</div>
<!-- /.content-wrapper -->
<script src="<?php echo $vbaseurl ?>resources/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/jquery-knob/jquery.knob.min.js"></script>
<!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->

	<script type="text/javascript" charset="utf-8">
		var ctx= new Array();
		$("#vw_md_busca_curricular").click(function(event) {
			var cbdocente=$("#vw_md_acad_cbdocente").val();
			if (cbdocente==""){
				$('#vw_md_cur_div_resultados').html("<div class='card card-outline card-secondary'>" +
					"<div class='card-body text-danger'>" +
						"Debes seleccionar un docente para iniciar el análisis	" +
				   	"</div>" + 
		   		"</div>" );
        		$('#divcard-general #divoverlay').remove();
        		return;
			}
			var codencuesta=$("#vw_md_encuesta").val();
			$('#vw_md_cur_div_resultados').html("");
		    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		    $.ajax({
		        url: base_url + 'monitoreo_docente/fn_get_encuesta_resultados',
		        type: 'post',
		        dataType: 'json',
		        data: {
		            cbdocente: cbdocente,
		            codencuesta: codencuesta
		        },
		        success: function(e) {
		            if (e.status == false) {
		                var msgf = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg + '</div>';
		                $('#vw_md_cur_div_docentes').html(msgf);
		            } else {
		            	if (e.ptotal==0){
		            		$('#vw_md_cur_div_resultados').html("<div class='card card-outline card-secondary'>" +
								"<div class='card-body text-danger'>" +
									"No hay suficientes datos para realizar un análisis	" +
							   	"</div>" + 
					   		"</div>" );
		            		$('#divcard-general #divoverlay').remove();
		            		return;
		            	}
		            	var pmax=$("#vw_md_encuesta_pmax").val();
		            	var estadohtml="";
		            	var vhtml="";
		            	var num=0;
		            	var colors=['red', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
		            	var vpe=(e.estado['respondidas'] * 100 / e.estado['enviadas']).toFixed(1);
		            	var vpromtotal=(e.ptotal/e.estado['respondidas']).toFixed(1);;
		            	var vpromtotalp=e.ptotal;
		            	var vnotavg=(vpromtotal/pmax * 20).toFixed(1);
						estadohtml=
						"<div class='card-deck mb-3'>" +
							"<div class='card  card-outline card-secondary'>" +
								"<div class='card-body'>" +
									"<div class='row'>" +
										"<div class='col-12 text-center'>" +
											"<div class='knob-label text-bold'>ENCUESTAS AL:</div>" +
						                    "<input type='text' class='knob-porc' data-thickness='0.3' data-angleArc='250' data-angleOffset='-125' value='" + vpe + "' disabled data-width='150' data-height='150' data-fgColor='#1505D6' data-readonly='true'>" +
						                "</div>" +
						                "<div class='col-12'>" +
							                "<div class='row'>" +
												"<div class='col-8 td'><i class='fas fa-circle fa-xs mr-1'></i>Enviadas</div>" + 
					   							"<div class='col-4 td text-right'>" + 
					   								e.estado['enviadas'] +
					   							"</div>" + 
					   						
												"<div class='col-8 td'><i class='fas fa-circle fa-xs mr-1'></i>Respondidas</div>" + 
					   							"<div class='col-4 td text-right'>" + 
					   								+ e.estado['respondidas'] + " (" + vpe + "%)" +
					   							"</div>" + 
					   					
												"<div class='col-8 td'><i class='fas fa-circle fa-xs mr-1'></i>Pendientes</div>" + 
					   							"<div class='col-4 td text-right'>" + 
					   								+ (e.estado['enviadas'] - e.estado['respondidas']) + " (" + (100-vpe) + "%)" + 
					   							"</div>" + 
					   						"</div>" +
					   					"</div>" + 
			   						"</div>" + 
								"</div>" + 
							"</div>" + 

							"<div class='card card-outline card-secondary'>" +
								"<div class='card-body'>" +
									"<div class='row'>" +
										"<div class='col-12 col-md-6 text-center'>" +
											"<div class='knob-label text-bold'>PUNTAJE<br>PROMEDIO</div>" +
						                    "<input type='text' class='knob' data-min='0' data-max='"+ pmax + "' data-thickness='0.3' data-angleArc='250' data-angleOffset='-125' value='" + vpromtotal + "' disabled data-width='80%'  data-fgColor='#00a65a' data-readonly='true'>" +
						                "</div>" +
						                "<div class='col-12 col-md-6 text-center'>" +
											"<div class='knob-label text-bold'>ESCALA<br>VIGESIMAL</div>" +
						                    "<input type='text' class='knob' data-min='0' data-max='20' data-thickness='0.3' data-angleArc='250' data-angleOffset='-125' value='" + vnotavg + "' disabled data-width='80%'  data-fgColor='#00a65a' data-readonly='true'>" +
						                "</div>" +
						                "<div class='col-12'>" +
							                "<div class='row'>" +
												"<div class='col-8 td'><i class='fas fa-circle fa-xs mr-1'></i>Puntaje Promedio</div>" + 
					   							"<div class='col-4 td text-right'>" + 
					   								vpromtotal + ' de ' + pmax +
					   							"</div>" + 
					   			
												"<div class='col-8 td'><i class='fas fa-circle fa-xs mr-1'></i>Puntaje máximo</div>" + 
					   							"<div class='col-4 td text-right'>" + 
					   								+ e.puntajes['mayor'] +
					   							"</div>" + 
					 
												"<div class='col-8 td'><i class='fas fa-circle fa-xs mr-1'></i>Puntaje mínimo</div>" + 
					   							"<div class='col-4 td text-right'>" + 
					   								+ e.puntajes['menor'] +
					   							"</div>" + 
					   						"</div>" +
					   					"</div>" + 
			   						"</div>" + 
							   	"</div>" + 
					   		"</div>" + 

					   		"<div class='card card-outline card-secondary'>" +
								"<div class='card-body'>" +
							        "<div class='row'>" +
										"<div class='col-12 text-center'>" +
											"<span class='text-bold'>EVOLUCIÓN DE DESEMPEÑO</span><br><br>" +

											"<div class='chart-container'  style='position: relative; height:100%'>" +
		   										"<canvas id='myChartHisto'></canvas>" +
											"</div>" + 
										"</div>" + 
			   						"</div>" + 
							   	"</div>" + 
					   		"</div>" + 

						"</div>" + 


						"<!--<div class='card card-outline card-secondary p-0'>" +
							"<div class='card-header px-2 px-sm-3 py-2 text-sm'>" +
								"<h4 class='card-title'>ESTADÍSTICAS GENERALES</h4>" +
							"</div>" + 
							"<div class='card-body'>" +
								"<div class='row'>" +

								"</div>" + 
							"</div>" + 
						"</div>-->" ;
							

						$('#vw_md_cur_div_resultados').append(estadohtml);
						new Chart($("#myChartHisto"),{
							"type":"line",
							"data":{
								"labels":["20181","20191","20192","20201","20202"],
								"datasets":[{
									"label":"Historial",
									"data":[65,59,80,81,56],
									"fill":false,
									"borderColor":"rgb(75, 192, 192)",
									"lineTension":0.1
								}]
							},
							options: {
						        legend: {
						            display: false,
						        }
						    }});
						$('.knob-porc').knob({
							'format' : function (value) {
						     	return value + '%';
						  	}
						});
						/*$('.knob-vig').knob({
							'format' : function (value) {
						     	return value + ' /' + pmax;
						  	}
						});*/
						$('.knob').knob();
		            	$.each(e.preguntas, function(key, pg) {
		            		num++;
		            		vlabels=[];
		            		vconteo=[];
		            		vcolors=[];
		            		vporcentajes=[];
		            		var codpg=pg['codpregunta'];
		            		var idcol=0;
		            		var tbhtml="";
							$.each(e.respuestas[codpg]['rpta'], function(key, rp) {
								//vhtml= vhtml + "<small>"+ rp['enunciado'] + "</small>";
								vporc=(rp['total'] * 100 / e.respuestas[codpg]['total']).toFixed(1);
								vlabels.push(rp['enunciado'] );
								vporcentajes.push(vporc);
								vconteo.push(rp['total'] );
								vcolors.push(colors[idcol]);
								idcol++;
								tbhtml= tbhtml + 
								"<div class='row'>" +
									"<div class='col-6 td'>" + 
		   								rp['enunciado'] +
		   							"</div>" + 
		   							"<div class='col-3 td text-right'>" + 
		   								rp['total'] +
		   							"</div>" + 
		   							"<div class='col-3 td text-right'>" + 
		   								vporc + " %" +
		   							"</div>" + 
		   						"</div>";
								
							});
		            		vhtml= 
			            	"<div class='card card-outline card-secondary px-0'>" +
								"<div class='card-header px-2 px-sm-3 py-2 text-sm'>" +
									"<h4 class='card-title'>Pregunta " + num + ". " + pg['enunciado'] + "</h4>" +
								"</div>" + 
								"<div class='card-body px-1'>" +
									"<div class='row'>" +
										"<div class='col-12 col-md-7'>" +
											"<div class='chart-container'  style='position: relative; width:100%'>" +
		   										"<canvas id='myChart" + pg['codpregunta'] + "'></canvas>" +
											"</div>" + 
										"</div>" + 
										"<div class='col-12 col-md-4 mt-2 pt-sm-3 pt-md-5'>" +
											"<div class='btable'>" +
		   										"<div class='col-12 thead'>" + 
		   											"<div class='row'>" +
														"<div class='col-6 td'>RESPUESTAS</div>" + 
							   							"<div class='col-3 td text-right'>TOTAL</div>" + 
							   							"<div class='col-3 td text-right'>%</div>" + 
							   						"</div>" + 
		   										"</div>" + 
		   										"<div class='col-12 tbody'>" + 
		   											
		   												tbhtml + 
		   											
		   										"</div>" + 
											"</div>" + 
										"</div>" + 
									"</div>" +
								"</div>" + 
			            	"</div>";
			            	$('#vw_md_cur_div_resultados').append(vhtml);

			            	ctx[codpg];
			            	ctx[codpg]= $('#myChart' + codpg);
			            	var myChart = new Chart(ctx[codpg], {
							    type: 'pie',
							    data: {
							        labels: vlabels,
							        datasets: [{
							            data: vconteo,
							            datalabel: vporcentajes,
							            backgroundColor : vcolors ,
							            datalabels: {
											align: 'start',
											anchor: 'end',
											clamp: true,
											color:'white'
										}
							            
							        }]
							    },
							    options: {
							    	layout: {
							            padding: {
							                left: 0,
							                right: 0,
							                top: 0,
							                bottom: 0
							            }
							        },
							    	legend: {
							    		position:'right',
							            labels: {
							                // This more specific font property overrides the global property
							                fontColor: 'black'
							            },
							        },
							        plugins: {
							            datalabels: {
							                formatter: (value, ctxt) => {
							                	 return ctxt.dataset.datalabel[ctxt.dataIndex] + "%";
								                
								            },
								            font:{
								            	weight:'bold',
								            	size:11,
								            },
								            
								            backgroundColor:'b lack',
								            padding:1,

							            }
							        }
							    }
							});

		            	});
		            	
		            	/*$.each(e.preguntas, function(key, pg) {
		            		var codpg=pg['codpregunta'];
		            		
		            	});*/
		            	
		                
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

		                    var btn_editar='<a class="dropdown-item" href="' + base_url + 'monitoreo/docentes/encuesta-dd/editar/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-edit"></i> Editar</a>';
		                    var btn_poblacion='<a class="dropdown-item" href="' + base_url + 'monitoreo/docentes/encuesta-dd/poblacion/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="fas fa-user-friends"></i> Población</a>';
		                     var btn_preguntas='<a class="dropdown-item" href="' + base_url + 'monitoreo/docentes/encuesta-dd/preguntas/' + v['codigo'] + '" class="bg-primary tboton d-block"><i class="far fa-question-circle"></i> Preguntas</a>';
		                    //btnord_merito='<a  href="' + base_url + 'academico/consulta/orden-merito/imprimir?' + params + '&at=1'+'"><i class="fas fa-sort-numeric-up-alt mr-1"></i> Mérito</a>';
		                    var btn_resultados='<a href="' + base_url + 'monitoreo/docentes/encuesta-dd/resultados/' + v['codigo'] + '"><u><i class="fas fa-chart-bar"></i> Resultados</u></a>';
		                    $("#div-encucreadas").append(

		                        '<div class="cfila row">' +
		                          '<div class="col-12 col-md-3">' +
		                            '<div class="row">' +
		                              '<div class="col-2 col-md-2 td">' + nro + '</div>' +
		                              '<div class="col-4 col-md-4 td">' + v['periodo'] + '</div>' +
		                              '<div class="col-6 col-md-6 td">' + v['nombre'] + '</div>' +
		                            '</div>' +
		                          '</div>' +
		                          '<div class="col-8 col-md-2 td">' + v['descripcion'] + '</div>' +
		                          '<div class="col-12 col-md-3">' +
		                            '<div class="row">' +
		                              '<div class="col-4 col-md-4 td">' + v['creado'] + '</div>' +
		                              '<div class="col-4 col-md-4 td">' + v['inicia'] + '</div>' +
		                              '<div class="col-4 col-md-4 td">' + v['vence'] + '</div>' +
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
		    if (vtab == "e") {
		        $('.nav-pills a[href="#tab-encuestas"]').tab('show');
		        var pd=getUrlParameter('pd', "")
		        $("#vw_encu_cbperiodo").val(pd);
		        if (pd!="") $("#busca_encuestas").click();
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

	</script>
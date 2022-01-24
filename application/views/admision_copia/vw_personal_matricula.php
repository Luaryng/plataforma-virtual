<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">
	<!-- MODAL MATRICULAS -->
	<div class="modal fade" id="modmatriculas" tabindex="-1" role="dialog" aria-labelledby="modmatriculas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title">MATRICULAS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                	<input type="hidden" id="fictxtmatapepaterno" value="">
                	<input type="hidden" id="fictxtmatapematerno" value="">
                	<input type="hidden" id="fictxtmatnombres" value="">
                	<input type="hidden" id="fictxtmatsexo" value="">
                    <div class="row">
                    	<div class="col-12 py-1">
							<small id="fmt_conteo_matriculas" class="form-text text-primary">
		            
			                </small>
			            </div>
		                <div class="col-12 py-1">
		                    <div class="btable">
		                        <div class="thead col-12  d-none d-md-block">
		                            <div class="row">
		                                <div class='col-12 col-md-6'>
		                                    <div class='row'>
		                                        <div class='col-2 col-md-2 td'>N°</div>
		                                        <div class='col-4 col-md-4 td'>CARNÉ</div>
		                                        <div class='col-6 col-md-6 td'>ALUMNO</div>
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-4'>
		                                    <div class='row'>
		                                        <div class='col-4 col-md-4 td'>PER.</div>
		                                        <div class='col-4 col-md-4 td'>PROG</div>
		                                        <div class='col-4 col-md-4 td'>CIC.</div>
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-2 text-center'>
		                                    <div class='row'>
		                                        <div class='col-12 col-md-12 td'>
		                                            <span></span>
		                                        </div>

		                                    </div>
		                                </div>
		                            </div>
		                            
		                        </div>
		                        <div class="tbody col-12" id="divres_matriculas">
		                            
		                        </div>
		                    </div>
		                </div>
	                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <!-- <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button> -->
                </div>
            </div>
        </div>
    </div>
	<!-- FIN MODAL MATRICULAS -->

	<section class="content-header">
      	<div class="container-fluid">
        	<div class="row">
          		<div class="col-sm-6">
            		<h1>Datos Personales</h1>
          		</div>
        	</div>
      	</div>
    </section>
    <section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-search"></i> Filtrar datos</h3>
			</div>
			<div class="card-body">
				<form id="frm-filtro-historial" name="frm-filtro-historial" action="<?php echo $vbaseurl ?>matricula_persona/fn_filtrar_historial" method="post" accept-charset='utf-8'>
					<div class="row">
						<div class="form-group input-group  no-flex col-12 col-sm-11">
							<div class="input-group-prepend">
								<span class="input-group-text">Buscar: </span>
								<label class="has-float-label">
									<input autocomplete='off' id="txtbusqueda" name="txtbusqueda" class="form-control " type="text" placeholder="DNI, Apellidos y nombres"/>
									<span>DNI, Apellidos y nombres</span>
								</label>
							</div>
						</div>

						<div class="col-12  col-sm-1">
							<button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
						</div>
					</div>
				</form>

				<div class="card-body no-padding">
					<div class="row">
						<small id="fmt_conteo" class="form-text text-primary">
	            
		                </small>
		                <div class="col-12 py-1">
		                    <div class="btable">
		                        <div class="thead col-12  d-none d-md-block">
		                            <div class="row">
		                                <div class='col-12 col-md-4'>
		                                    <div class='row'>
		                                        <div class='col-2 col-md-2 td'>N°</div>
		                                        <div class='col-4 col-md-4 td'>DNI/CARNÉ</div>
		                                        <div class='col-6 col-md-6 td'>AP. PATERNO</div>
		                                        
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-6'>
		                                    <div class='row'>
		                                    	<div class='col-4 col-md-4 td'>AP. MATERNO</div>
		                                        <div class='col-4 col-md-4 td'>NOMBRES</div>
		                                        <div class='col-4 col-md-4 td'>SEXO</div>
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-2 text-center'>
		                                    <div class='row'>
		                                        <div class='col-12 col-md-12 td'>
		                                            <span>ACCIONES</span>
		                                        </div>

		                                    </div>
		                                </div>
		                            </div>
		                            
		                        </div>
		                        <div class="tbody col-12" id="divres_historial">
		                            
		                        </div>
		                    </div>
		                </div>
	                </div>
					<div class="row">
						<div class="col-12 py-1" id="divres-historial">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		const Toast = Swal.mixin({
	      	toast: true,
	      	position: 'top-end',
	      	showConfirmButton: false,
	      	timer: 5000
	    })

	    Toast.fire({
	      	type: 'info',
	      	icon: 'info',
	      	title: 'Aviso: Utiliza los cuadros de búsqueda ubicados arriba para encontrar el historial existente de los estudiantes registrados'
	    })

	    $("#txtbusqueda").focus();
	    
	})

	$('#frm-filtro-historial').submit(function() {
	    $('#divres-historial').html("");
	    $('#frm-filtro-historial input:text').removeClass('is-invalid');
	    $('#frm-filtro-historial .invalid-feedback').remove();
	    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divboxhistorial #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().parent().after("<div class='invalid-feedback btn-block'>" + val + "</div>");
	                });
	            } else {
	            	$('#divres_historial').html("");
                    var nro=0;
                    var tabla="";
                    var selector = "";
                    var codigo64 = "";
                    if (e.vdata.length !== 0) {
                    	$('#fmt_conteo').html('');
                        $.each(e.vdata, function(index, val) {
                        	nro++;

                        	tabla=tabla + 
                                "<div class='row rowcolor cfila' id='divrowper_"+val['codigo64']+"'>"+
                                    "<div class='col-12 col-md-4'>"+
                                        "<div class='row'>"+
                                            "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                            "<div class='col-4 col-md-4 text-center td'>"+val['numero']+"<br><b>"+val['carne']+"</b></div>"+
                                            "<div class='col-6 col-md-6 td'>"+
                                            	"<input type='text' value='"+val['paterno']+"' class='form-control form-control-sm fictxtapepaterno'>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-6'>"+
                                        "<div class='row'>"+
                                        	"<div class='col-6 col-md-4 td'>"+
                                            	"<input type='text' value='"+val['materno']+"' class='form-control form-control-sm fictxtapematerno'>"+
                                            "</div>"+
                                        	"<div class='col-6 col-md-4 td'>"+
                                        		"<input type='text' value='"+val['nombres']+"' class='form-control form-control-sm fictxtnombres'>"+
                                        	"</div>"+
                                            "<div class='col-12 col-md-4 td'>"+
                                            	"<select class='form-control form-control-sm fictxtsexo'>"+
			                                        "<option value=''>Seleccione item</option>"+
			                                        "<option value='MASCULINO'>MASCULINO</option>"+
			                                        "<option value='FEMENINO'>FEMENINO</option>"+
			                                    "</select>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-2 text-center'>"+
                                        "<div class='row'>"+
                                            "<div class='col-6 col-sm-6 col-md-6 td'>"+
                                                "<button type='button' class='btn btn-info btn-sm px-3 btn_editdata' data-codigo='"+val['codigo64']+"'>"+
			                            			"<i class='fas fa-pencil-alt text-white'></i>"+
			                            		"</button>"+
			                                    "<button type='button' class='btn btn-info btn-sm px-3 btn_updatedata d-none' data-codigo='"+val['codigo64']+"' >"+
			                                        "<i class='fas fa-save text-white'></i>"+
			                                    "</button>"+
                                            "</div>"+
                                            "<div class='col-6 col-sm-6 col-md-6 td'>"+
                                                "<button type='button' class='btn btn-primary btn-sm px-3 btn_viewmat' data-carne='"+val['carne']+"'>"+
			                            			"<i class='fas fa-eye text-white'></i>"+
			                            		"</button>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                        });

                        $('#divres_historial').html(tabla);
                        $("#divres_historial input").attr('disabled', true);
        				$("#divres_historial select").attr('disabled', true);

                        $('#fmt_conteo').html('Se encontraron '+e.conteo+' resultados');
                        $.each(e.vdata, function(index, val) {
                        	selector = val['sexo'];
                        	$("#divrowper_"+val['codigo64']+" .fictxtsexo option[value='"+ selector +"']").attr("selected",true);
                        })

                    } else {
                        $('#fmt_conteo').html('No se encontraron resultados');
                        $('#divres_historial').html("");
                    }
	                
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'div');
	            $('#divboxhistorial #divoverlay').remove();
	            $('#divres-historial').html(msgf);
	        }
	    });
	    return false;
	});

	$(document).on("click", ".btn_editdata", function() {
        var btn=$(this);
        var codigo = btn.data("codigo");
        $("#divrowper_"+codigo+" input").attr('disabled', false);
        $("#divrowper_"+codigo+" select").attr('disabled', false);

        $('#divrowper_'+codigo+' .btn_editdata').addClass('d-none');
        $('#divrowper_'+codigo+' .btn_updatedata').removeClass('d-none');
    })

    $(document).on("click", ".btn_updatedata", function() {
        var btn=$(this);
        var div=btn.parents('.cfila');

        var apepaterno = div.find('.fictxtapepaterno').val();
        var apematerno = div.find('.fictxtapematerno').val();
        var nombre = div.find('.fictxtnombres').val();
        var sexo = div.find('.fictxtsexo').val();

        var codigo = btn.data('codigo');
        
        
        $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        $.ajax({
            url: base_url + "matricula_persona/fn_update_data",
            type: 'post',
            dataType: "json",
            data: {
                fictxtcodigo:codigo, 
                fictxtnombre:nombre, 
                fictxtapepaterno:apepaterno,
                fictxtapematerno:apematerno,
                fictxtsexo:sexo,
            },
            success: function(e) {
                $('#divboxhistorial #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        title: 'Error!',
                        text: "No se guardaron los cambios",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    
                    Swal.fire({
                    	title: 'ÉXITO!',
                        text: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      	if (result.value) {
                        	// location.reload();
                        	$('#frm-filtro-historial').submit();
                      	}
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divboxhistorial #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });

    $(document).on('click', '.btn_viewmat', function() {
    	var btn=$(this);
        var codigo = btn.data('carne');
        var div=btn.parents('.cfila');

        var apepaterno = div.find('.fictxtapepaterno').val();
        var apematerno = div.find('.fictxtapematerno').val();
        var nombre = div.find('.fictxtnombres').val();
        var sexo = div.find('.fictxtsexo').val();

        $("#fictxtmatapepaterno").val(apepaterno);
		$("#fictxtmatapematerno").val(apematerno);
		$("#fictxtmatnombres").val(nombre);
		$("#fictxtmatsexo").val(sexo);

        get_data_matriculas(codigo);
        
        return false;
    });

	function get_data_matriculas(codigo) {
		$('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        $.ajax({
            url: base_url + "matricula_persona/fn_vwmatriculas",
            type: 'post',
            dataType: "json",
            data: {
                fictxtcarne:codigo
            },
            success: function(e) {
                $('#divboxhistorial #divoverlay').remove();
                $('#modmatriculas').modal('show');

                if (e.status == false) {
                    Swal.fire({
                        title: 'Error!',
                        text: "No se encontraron matriculas",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    $('#divres_matriculas').html("");
                    var nro=0;
                    var tabla="";
                    if (e.vdata.length !== 0) {
                    	$('#fmt_conteo_matriculas').html('');
                        $.each(e.vdata, function(index, val) {
                        	nro++;
                        	tabla=tabla + 
                                "<div class='row rowcolor cfila'>"+
                                    "<div class='col-12 col-md-6'>"+
                                        "<div class='row'>"+
                                            "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                            "<div class='col-4 col-md-4 td'>"+
                                            	val['carne']+
                                            "</div>"+
                                            "<div class='col-6 col-md-6 td'>"+
                                            	val['paterno'] + " " + val['materno'] + " " + val['nombres']+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-4'>"+
                                        "<div class='row'>"+
                                        	"<div class='col-4 col-md-4 td'>"+
                                        		val['periodo']+
                                        	"</div>"+
                                            "<div class='col-4 col-md-4 td'>"+
                                            	val['sigla']+
                                            "</div>"+
                                            "<div class='col-4 col-md-4 td'>"+
                                            	val['ciclo']+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-2 text-center'>"+
                                        "<div class='row'>"+
                                            "<div class='col-12 col-sm-12 td'>"+
                                                "<button type='button' class='btn btn-success btn-sm px-3 btn_updpersonales' data-codmat='"+val['codigo64']+"' data-carne='"+val['carne']+"'>"+
			                            			"<i class='fas fa-edit text-white'></i>"+
			                            		"</button>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                        });

                        $('#divres_matriculas').html(tabla);

                        $('#fmt_conteo_matriculas').html('Se encontraron '+e.conteo+' matriculas');

                    } else {
                        $('#fmt_conteo_matriculas').html('No se encontraron matriculas');
                        $('#divres_matriculas').html("");
                    }
                    
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divboxhistorial #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
	}

	$(document).on('click', '.btn_updpersonales', function() {
		var btn = $(this);
        var apepaterno = $('#fictxtmatapepaterno').val();
        var apematerno = $('#fictxtmatapematerno').val();
        var nombre = $('#fictxtmatnombres').val();
        var sexo = $('#fictxtmatsexo').val();
        var codigo = btn.data('codmat');
        var carne = btn.data('carne');
        
        $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        $.ajax({
            url: base_url + "matricula_persona/fn_update_data_matricula",
            type: 'post',
            dataType: "json",
            data: {
                fictxtcodigo:codigo, 
                fictxtnombre:nombre, 
                fictxtapepaterno:apepaterno,
                fictxtapematerno:apematerno,
                fictxtsexo:sexo,
            },
            success: function(e) {
                $('#divboxhistorial #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        title: 'Error!',
                        text: "No se guardaron los cambios",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    
                    Swal.fire({
                    	title: 'ÉXITO!',
                        text: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      	if (result.value) {
                        	// location.reload();
                        	get_data_matriculas(carne);
                      	}
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divboxhistorial #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
	});

	$("#modmatriculas").on('hidden.bs.modal', function (e) {
		var rel=$(e.relatedTarget);
        $("#fictxtmatapepaterno").val('');
		$("#fictxtmatapematerno").val('');
		$("#fictxtmatnombres").val('');
		$("#fictxtmatsexo").val('');
    })

	

</script>
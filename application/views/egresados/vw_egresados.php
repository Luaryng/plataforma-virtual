<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">

	<div class="modal fade" id="modaddegresado" tabindex="-1" role="dialog" aria-labelledby="modaddegresado" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleegresado">REGISTRAR EGRESADO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addegresado" action="<?php echo $vbaseurl ?>egresados/fn_insert_update" method="post" accept-charset="utf-8">
                    	<button class="btn btn-primary" id="btn_search_est" type="button">
                			<i class="fas fa-search"></i> Buscar alumno
                		</button>
                    	<b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> DATOS PERSONALES</b>
                        <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                        <input type="hidden" id="fictxtcodigoinsc" name="fictxtcodigoinsc" value="0">
                        <div class="row">
                            <div class="form-group has-float-label col-md-4">
                                <input autocomplete='off' type="text" name="fictxtapepaterno" id="fictxtapepaterno" placeholder="Apellido Paterno" class="form-control form-control-sm">
                                <label for="fictxtapepaterno">Apellido Paterno</label>
                            </div>
                            <div class="form-group has-float-label col-md-4">
                                <input autocomplete='off' type="text" name="fictxtapematerno" id="fictxtapematerno" placeholder="Apellido Materno" class="form-control form-control-sm">
                                <label for="fictxtapematerno">Apellido Materno</label>
                            </div>
                            <div class="form-group has-float-label col-md-4">
                                <input autocomplete='off' type="text" name="fictxtnombres" id="fictxtnombres" placeholder="Nombres" class="form-control form-control-sm">
                                <label for="fictxtnombres">Nombres</label>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group has-float-label col-md-3">
                                <select name="fictxtipdocum" id="fictxtipdocum" class="form-control form-control-sm">
                                	<option value="DNI">DNI</option>
				                    <option value="CEX">Carné de Extranjería</option>
				                    <option value="PSP">Pasaporte</option>
				                    <option value="PTP">Permiso Temporal de Permanencia</option>
                                </select>
                                <label for="fictxtipdocum">Tipo Documento</label>
                            </div>
                            <div class="form-group has-float-label col-md-3">
                                <input autocomplete='off' type="text" name="fictxtdocumento" id="fictxtdocumento" placeholder="Nro Documento" class="form-control form-control-sm">
                                <label for="fictxtdocumento">Nro Documento</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-3">
								<select class="form-control form-control-sm" id="fictxtsexo" name="fictxtsexo" placeholder="Sexo" >
									<option value="MASCULINO">MASCULINO</option>
									<option value="FEMENINO">FEMENINO</option>
								</select>
								<label for="fictxtsexo"> Sexo</label>
							</div>
							<div class="form-group has-float-label col-12  col-sm-3">
								<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtfechanac" name="fitxtfechanac" type="date" placeholder="Fec. Nacimiento"   />
								<label for="fitxtfechanac">Fec. Nacimiento</label>
							</div>
                        </div>

                        <b class="pt-2 pb-4 text-danger d-block">
                        	<i class="fas fa-map-marker-alt"></i> DATOS DE LA DIRECCIÓN ACTUAL DEL EGRESADO
                        </b>
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-sm-4">
								<select data-currentvalue='' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" >
									<option value="0">Selecciona Departamento</option>
									<?php foreach ($departamentos as $key => $depa) {?>
									<option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
									<?php } ?>
								</select>
								<label for="ficbdepartamento"> Departamento</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-4">
								<select data-currentvalue='0' class="form-control form-control-sm" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" >
									<option value="0">Sin opciones</option>
								</select>
								<label for="ficbprovincia"> Provincia</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-4">
								<select data-currentvalue='0'  class="form-control form-control-sm" id="ficbdistrito" name="ficbdistrito" placeholder="Distrito" >
									<option value="0">Sin opciones</option>
								</select>
								<label for="ficbdistrito"> Distrito</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-12">
								<input autocomplete='off' data-currentvalue='0' class="form-control form-control-sm text-uppercase" id="fitxtdomicilio" name="fitxtdomicilio" type="text" placeholder="Domicilio" />
								<label for="fitxtdomicilio"> Domicilio</label>
							</div>
                        </div>
                        <div class="row">
                        	<div class="form-group has-float-label col-12 col-sm-6">
								<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm" id="fitxtemailpersonal" name="fitxtemailpersonal" type="text" placeholder="Email Personal" />
								<label for="fitxtemailpersonal">Email personal</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-3">
								<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxttelefono" name="fitxttelefono" type="text" placeholder="Teléfono" />
								<label for="fitxttelefono">Teléfono</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-3">
								<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtcelular" name="fitxtcelular" type="text" placeholder="Celular" />
								<label for="fitxtcelular">Celular</label>
							</div>
                        </div>
                        <b class="pt-2 pb-4 text-danger d-block">
                        	<i class="fas fa-graduation-cap"></i> DATOS ACADÉMICOS
                        </b>
                        <div class="row">
                        	<div class="form-group has-float-label col-md-3">
                                <input autocomplete='off' type="text" name="fictxtmodular" id="fictxtmodular" placeholder="Cod. Modular" class="form-control form-control-sm" value="<?php echo $iest->codmodular ?>">
                                <label for="fictxtmodular">Cod. Modular</label>
                            </div>
                        	<div class="form-group has-float-label col-12 col-sm-4">
								<select class="form-control form-control-sm" id="fictxtprograma" name="fictxtprograma" >
									<option value="0">Programa</option>
									<?php foreach ($carreras as $key => $car) {?>
									<option value="<?php echo $car->codcarrera ?>"><?php echo $car->nombre ?></option>
									<?php } ?>
								</select>
								<label for="fictxtprograma"> Programa</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-2">
								<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm" id="fitxtanioegreso" name="fitxtanioegreso" type="text" placeholder="Año de egreso" />
								<label for="fitxtanioegreso">Año de egreso</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-3">
								<select class="form-control form-control-sm" id="fictxtperiodoeg" name="fictxtperiodoeg" >
									<option value="0">Periodo</option>
									<?php foreach ($periodos as $key => $per) {?>
									<option value="<?php echo $per->codigo ?>"><?php echo $per->nombre ?></option>
									<?php } ?>
								</select>
								<label for="fictxtperiodoeg"> Periodo egreso</label>
							</div>
                        </div>
                        <div class="row">
							<div class="col-12">
								<span id="fispedit" class="text-danger"></span>
							</div>
						</div>
                    </form>
                    <div id="div_search">
                    	<form id="frm_search_estud" action="<?php echo $vbaseurl ?>egresados/fn_seach_estudiante" method="post" accept-charset="utf-8">
                    		<div class="row">
                    			<div class="form-group has-float-label col-md-8">
	                                <input autocomplete='off' type="text" name="fictxtbusqueda" id="fictxtbusqueda" placeholder="Carné o Apellidos y nombres" class="form-control form-control-sm">
	                                <label for="fictxtbusqueda">Carné o Apellidos y nombres</label>
	                            </div>
	                            <div class="col-md-4">
	                            	<button class="btn btn-primary btn-sm" type="submit">
	                            		<i class="fas fa-search"></i>
	                            	</button>
	                            </div>
                    		</div>
                    		<div id="divcard_result">
                    			
                    		</div>
                    	</form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>EGRESADOS
					<small> Panel</small></h1>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<div id="divcard_listado" class="card">
			<div class="card-header">
				<h3 class="card-title">
					<i class="fas fa-list-ul"></i> Listado
				</h3>
				<?php if (getPermitido("145")=='SI') { ?>
				<div class="card-tools">
					<button class="btn btn-outline-dark" id="btn_modal_add">
						<i class="fas fa-plus"></i> Agregar
					</button>
				</div>
				<?php } ?>
			</div>
			<div class="card-body">
				<small id="fmt_conteo" class="form-text text-primary">
            
                </small>
                <div class="col-12 py-1">
                    <div class="btable">
                        <div class="thead col-12  d-none d-md-block">
                            <div class="row">
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-1 col-md-1 td'>N°</div>
                                        <div class='col-3 col-md-3 td text-center'>CÓDIGO MODULAR</div>
                                        <div class='col-8 col-md-8 td'>NOMBRE</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-6'>
                                    <div class='row'>
                                        <div class='col-7 col-md-6 td'>PROGRAMA</div>
                                        <div class='col-3 col-md-3 td text-center'>PERIODO EGRESO</div>
                                        <div class='col-2 col-md-3 td text-center'>AÑO EGRESO</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-1 td text-center'>
                                    
                                </div>
                            </div>
                            
                        </div>
                        <div class="tbody col-12" id="divcard_datax1">
                        <?php 
                        	$nro = 0;
                        	foreach ($egresados as $key => $eg) {
                        		$nro++;
                        		$codigo64 = base64url_encode($eg->codigo);
                        ?>
                            <div class='row rowcolor cfila' data-egresado=''>
                            	<div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-1 col-md-1 td'><?php echo $nro ?></div>
                                        <div class='col-3 col-md-3 td text-center'><?php echo $eg->codmodular ?></div>
                                        <div class='col-8 col-md-8 td'>
                                        	<?php echo $eg->dni.' - '.$eg->paterno.' '.$eg->paterno.' '.$eg->nombres ?>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-6'>
                                    <div class='row'>
                                        <div class='col-6 col-md-6 td'><?php echo $eg->carrera ?></div>
                                        <div class='col-3 col-md-3 td'><?php echo $eg->periodoeg ?></div>
                                        <div class='col-3 col-md-3 td'><?php echo $eg->anioeg ?></div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-1 td text-center'>
                                	<div class='btn-group'>
                                        <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            <i class='fas fa-cog'></i>
                                        </a>
                                        <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                        	<?php if (getPermitido("146")=='SI') { ?>
                                        	<a class='dropdown-item' href='#' title='Editar' onclick='vw_data_egresado("<?php echo $codigo64 ?>")'>
                                                <i class='fas fa-edit mr-1'></i> Editar
                                            </a>
                                        	<?php } 
                                        	if (getPermitido("147")=='SI') { ?>
                                            <a class='dropdown-item text-danger deletegres' href='#' title='Eliminar' data-codigo='<?php echo $codigo64 ?>'>
                                                <i class='fas fa-trash mr-1'></i> Eliminar
                                            </a>
                                        	<?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
</div>

<script>
	$(document).ready(function() {
		$('#div_search').hide();
	});

	$('#btn_modal_add').click(function(e) {
		e.preventDefault();
		$('#modaddegresado').modal('show');
	});

	$('#btn_search_est').click(function(e) {
		$('#frm_addegresado').hide();
		$('#div_search').show();
		$('#lbtn_guardar').hide();
	});

	$('#frm_search_estud').submit(function(e) {
		$('#frm_search_estud input,select').removeClass('is-invalid');
        $('#frm_search_estud .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_search_estud').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_search_estud').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#divcard_result').html("");
                    var nro=0;
                    var tabla="";
                    var codbase64 = "";
                    if (e.vdata.length !== 0) {
                    	tabla=tabla +
                    		"<div class='col-12 py-1'>"+
			                    "<div class='btable'>"+
			                        "<div class='thead col-12  d-none d-md-block'>"+
			                            "<div class='row'>"+
			                                "<div class='col-12 col-md-5'>"+
			                                    "<div class='row'>"+
			                                        "<div class='col-2 col-md-2 td'>N°</div>"+
			                                        "<div class='col-10 col-md-10 td'>NOMBRES</div>"+
			                                    "</div>"+
			                                "</div>"+
			                                "<div class='col-12 col-md-6'>"+
			                                    "<div class='row'>"+
			                                        "<div class='col-9 col-md-9 td'>PROGRAMA</div>"+
			                                        "<div class='col-3 col-md-3 td text-center'>PERIODO</div>"+
			                                    "</div>"+
			                                "</div>"+
			                                "<div class='col-12 col-md-1 td text-center'>"+
			                                    
			                                "</div>"+
			                            "</div>"+
			                            
			                        "</div>"+
			                        "<div class='tbody col-12' id='divcard_dataest'>";
                    	$.each(e.vdata, function(index, val) {
                    		nro++;
                    		tabla=tabla +
                    			"<div class='row rowcolor cfilaest' data-inscrito=''>"+
                    				"<div class='col-12 col-md-5'>"+
	                                    "<div class='row'>"+
	                                        "<div class='col-2 col-md-2 td'>"+nro+"</div>"+
	                                        "<div class='col-10 col-md-10 td'>"+val['carnet']+" - "+val['paterno']+" "+val['materno']+" "+val['nombres']+"</div>"+
	                                    "</div>"+
	                                "</div>"+
	                                "<div class='col-12 col-md-6'>"+
	                                    "<div class='row'>"+
	                                        "<div class='col-9 col-md-9 td'>"+val['carrera']+"</div>"+
	                                        "<div class='col-3 col-md-3 td text-center'>"+val['periodo']+"</div>"+
	                                    "</div>"+
	                                "</div>"+
	                                "<div class='col-12 col-md-1 td text-center'>"+
			                        	"<button type='button' class='btn btn-info btn-sm btn_select_estud' data-codigo='"+val['codins64']+"' data-periodo='"+val['codperiodo']+"'>"+
			                        		"<i class='fas fa-share'></i>"+
			                        	"</button>"+    
			                        "</div>"+
                    			"</div>";
                    	})

                    	tabla=tabla+
		                    	"</div>"+
		                    "</div>"+
		                "</div>";
                    } else {
                    	tabla=tabla+"<span class='text-danger'>Sin resultados</span>";
                    }

                    $('#divcard_result').html(tabla);

                    $(".btn_select_estud").on("click", function() {
                		var codigo = $(this).data('codigo');
                		var periodo = $(this).data('periodo');
                		$('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                		$.ajax({
				            url: base_url + "egresados/vw_inscrito_x_codigo",
				            type: 'post',
				            dataType: 'json',
				            data: {
				            	'txtcodigoins' : codigo,
				            	'txtperiodo' : periodo
				            },
				            success: function(e) {
				                $('#divmodaladd #divoverlay').remove();
				                if (e.status == false) {
				                    Swal.fire({
				                        title: 'Error!',
				                        text: e.msg,
				                        type: 'error',
				                        icon: 'error',
				                    })
				                    
				                } else {
				                	$('#frm_search_estud')[0].reset();
				                	$('#divcard_result').html("");

				                	$('#fictxtcodigoinsc').val(e.vdata['codigoins64']);
				                	$('#fictxtapepaterno').val(e.vdata['paterno']);
				                	$('#fictxtapematerno').val(e.vdata['materno']);
				                	$('#fictxtnombres').val(e.vdata['nombres']);
				                	$('#fictxtipdocum').val(e.vdata['tipodoc']);
				                	$('#fictxtdocumento').val(e.vdata['nrodoc']);
				                	$('#fictxtsexo').val(e.vdata['sexo']);
				                	$('#fitxtfechanac').val(e.vdata['fecnac']);

				                	$('#ficbdepartamento').val(e.vdata['codepartamento']);
				                	$('#ficbprovincia').html(e.dprovincias);
				                	$('#ficbprovincia').val(e.vdata['codprovincia']);
				                	$('#ficbdistrito').html(e.ddistritos);
				                	$('#ficbdistrito').val(e.vdata['iddistrito']);

				                	$('#fitxtdomicilio').val(e.vdata['domicilio']);
				                	$('#fitxtemailpersonal').val(e.vdata['email']);
				                	$('#fitxttelefono').val(e.vdata['telefono']);
				                	$('#fitxtcelular').val(e.vdata['celular']);

				                	$('#fictxtprograma').val(e.vdata['codcarrera']);

				                	$('#frm_addegresado').show();
									$('#div_search').hide();
									$('#lbtn_guardar').show();
				                }
				            },
				            error: function(jqXHR, exception) {
				                var msgf = errorAjax(jqXHR, exception,'text');
				                $('#divmodaladd #divoverlay').remove();
				                Swal.fire({
				                    title: msgf,
				                    // text: "",
				                    type: 'error',
				                    icon: 'error',
				                })
				            }
				        })
				        return false;
                	});
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladd #divoverlay').remove();
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

	var frmdp_edit = new Array();
	$('#frm_addegresado input,select').change(function() {
	    // Do something interesting here
	    //alert($(this).data('currentvalue'));
	    if ($(this).data('currentvalue') !== $(this).val()) {
	        if (frmdp_edit.indexOf($(this).attr('id')) == -1) frmdp_edit.push($(this).attr('id'));
	    } else {
	        var i = frmdp_edit.indexOf($(this).attr('id'));
	        i !== -1 && frmdp_edit.splice(i, 1);
	    }
	    if (frmdp_edit.length > 0) {
	        $("#fispedit").html("* modificado");
	    } else {
	        $("#fispedit").html("");
	    }
	    if ($(this).attr('id') == "ficbdepartamento") {
	        $('#frm_addegresado #ficbprovincia').html("<option value='0'>Sin opciones</option>");
	        $('#frm_addegresado #ficbdistrito').html("<option value='0'>Sin opciones</option>");
	        var coddepa = $(this).val();
	        if (coddepa == '0') return;
	        $.ajax({
	            url: base_url + 'ubigeo/fn_provincia_x_departamento',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtcoddepa: coddepa
	            },
	            success: function(e) {
	                $('#frm_addegresado #ficbprovincia').html(e.vdata);
	            },
	            error: function(jqXHR, exception) {
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#frm_addegresado #ficbprovincia').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
	    } else if ($(this).attr('id') == "ficbprovincia") {
	        $('#frm_addegresado #ficbdistrito').html("<option value='0'>Sin opciones</option>");
	        var codprov = $(this).val();
	        if (codprov == '0') return;
	        $.ajax({
	            url: base_url + 'ubigeo/fn_distrito_x_provincia',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtcodprov: codprov
	            },
	            success: function(e) {
	                $('#frm_addegresado #ficbdistrito').html(e.vdata);
	            },
	            error: function(jqXHR, exception) {
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#frm_addegresado #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
	        return false;
	    }
	    return false;
	});

	$('#lbtn_guardar').click(function(e) {
		$('#frm_addegresado input,select').removeClass('is-invalid');
        $('#frm_addegresado .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addegresado').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addegresado').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddegresado').modal('hide');
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            location.reload();
                        }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladd #divoverlay').remove();
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

	$("#modaddegresado").on('hidden.bs.modal', function () {
        $('#frm_addegresado')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#titleegresado').html("REGISTRAR EGRESADO");
        $('#frm_addegresado').show();
        $('#div_search').hide();
        $('#btn_search_est').show();
        $('#lbtn_guardar').show();
    });

	function vw_data_egresado(codigo) {
		$('#divcard_listado').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "egresados/vw_egresado_x_codigo",
            type: 'post',
            dataType: 'json',
            data: {
            	'txtcodigo' : codigo
            },
            success: function(e) {
                $('#divcard_listado #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        title: 'Error!',
                        text: e.msg,
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {

                	$('#modaddegresado').modal('show');
                	$('#titleegresado').html("ACTUALIZAR EGRESADO");
                	$('#fictxtcodigo').val(e.vdata['codigo64']);

                	$('#fictxtapepaterno').val(e.vdata['paterno']);
                	$('#fictxtapematerno').val(e.vdata['materno']);
                	$('#fictxtnombres').val(e.vdata['nombres']);
                	$('#fictxtipdocum').val(e.vdata['tipodoc']);
                	$('#fictxtdocumento').val(e.vdata['dni']);
                	$('#fictxtsexo').val(e.vdata['sexo']);
                	$('#fitxtfechanac').val(e.vdata['fecnacimiento']);
                	
                	$('#ficbdepartamento').val(e.vdata['codepartamento']);
                	$('#ficbprovincia').html(e.dprovincias);
                	$('#ficbprovincia').val(e.vdata['codprovincia']);
                	$('#ficbdistrito').html(e.ddistritos);
                	$('#ficbdistrito').val(e.vdata['iddistrito']);

                	$('#fitxtdomicilio').val(e.vdata['domicilio']);
                	$('#fitxtemailpersonal').val(e.vdata['email']);
                	$('#fitxttelefono').val(e.vdata['telefono']);
                	$('#fitxtcelular').val(e.vdata['celular']);

                	$('#fictxtmodular').val(e.vdata['codmodular']);
                	$('#fictxtprograma').val(e.vdata['idcarrera']);
                	$('#fitxtanioegreso').val(e.vdata['anioeg']);
                	$('#fictxtperiodoeg').val(e.vdata['periodoeg']);
                    
                    $('#btn_search_est').hide();
                    // Swal.fire({
                    //     title: e.msg,
                    //     type: 'success',
                    //     icon: 'success',
                    // }).then((result) => {
                    //     if (result.value) {
                    //         location.reload();
                    //     }
                    // })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard_listado #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
	}

	$(document).on("click", ".deletegres", function(){
		var codigo = $(this).data("codigo");
		var fila = $(this).closest('.rowcolor');  
  		
		Swal.fire({
			title: '¿Está seguro de eliminar el registro seleccionado?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar!'
		}).then(function(result){
			if(result.value){
				$('#divcard_listado').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                $.ajax({
                  	url: base_url + "egresados/fneliminar_egresado",
                  	method: "POST",
                  	dataType: 'json',
                  	data: {
                  		'txtcodigo':codigo
                  	},
                  	success:function(e){
                    	$('#divcard_listado #divoverlay').remove();
                    	if (e.status == true) {
                    		Swal.fire({
	                          	type: "success",
	                          	icon: 'success',
	                          	title: "¡CORRECTO!",
	                          	text: e.msg,
	                          	showConfirmButton: true,
	                          	allowOutsideClick: false,
	                          	confirmButtonText: "Cerrar"
	                        }).then(function(result){
	                            if(result.value){
	                               fila.remove();
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divcard_listado #divoverlay').remove();
			            Swal.fire({
	              			title: "Error",
	              			text: e.msgf,
	              			type: "error",
	              			icon: "error",
	              			allowOutsideClick: false,
	              			confirmButtonText: "¡Cerrar!"
	            		});
			        }
            	})
			}
    	});  		
	        
	    return false;
	});

</script>
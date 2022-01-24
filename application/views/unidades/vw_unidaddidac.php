<style>
  .form-neo{
    /*border: solid 1px lightgray;*/
    padding: 25px 15px 15px 15px;
    margin: 5px 5px 15px 5px;
    border-radius: 5px;
    background-color:white;
    -webkit-box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.5);
    -moz-box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.5);
    box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.5);
  }
</style>
<?php 
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
	<div class="modal fade" id="modupdaunidad" tabindex="-1" role="dialog" aria-labelledby="modupdaunidad" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered" role="document">
      		<div class="modal-content" id="divmodalupd">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle">ACTUALIZAR DATOS</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body">
	          		<div id="divdatosunidad">
	            
	          		</div>
	        	</div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		          	<button type="button" id="btn_upunidad" class="btn btn-primary">Guardar</button>
		        </div>
      		</div>
    	</div>
  	</div>
  	<div class="modal fade" id="modal_danger_unidad" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content bg-danger" id="div_danger">
	            <div class="modal-header">
		            <h4 class="modal-title">Alerta de Eliminación</h4>
	    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		    <span aria-hidden="true">×</span>
	              	</button>
	            </div>
	            <div class="modal-body">
	            	<h4>Esta seguro de eliminar esta unidad didáctica ?....!</h4>
	            </div>
	            <div class="modal-footer justify-content-between">
	              	<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
	              	<button type="button" class="btn btn-outline-light" id="btnelimina_unidad" data-idmod=''>Eliminar</button>
	            </div>
	        </div>
	    </div>
	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_unidad" class="card">
		    <div class="card-header p-2">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-unidad" data-toggle="tab"><b><i class="fas fa-search mr-1"></i>Búsqueda</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-unidad" data-toggle="tab"><b><i class="fas fa-graduation-cap mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
	      	<div class="card-body p-2">
	      		<div class="tab-content">
			    	<div class="tab-pane" id="registrar-unidad">
	      				<div class="alert alert-dark alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si la UNIDAD DIDÁCTICA no ha sido registrado anteriormente
							<button type="button" class="close" data-dismiss="alert">×</button>
						</div>
						<form class="form-neo" id="frm_unidad" action="<?php echo $vbaseurl ?>unidaddidactica/fn_insert_unidades" method="post" accept-charset="utf-8">
							<div class="row mt-2">
								<div class="form-group has-float-label col-12 col-sm-6">
									<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="INSERTAR">
									<input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre unidad" />
									<label for="fictxtnombre">Nombre unidad</label>
								</div>
								<div class="form-group has-float-label col-6 col-sm-3">
									<select name="cbotipound" id="cbotipound" data-currentvalue='' class="form-control text-uppercase">
										<option value="">Seleccione tipo unidad</option>
										<option value="C">COMP. ESPECÍFICA</option>
										
										<option value="E">COMP. PARA LA EMPLEABILIDAD</option>
									</select>
									<label for="cbotipound">Tipo</label>
								</div>
								<div class="form-group has-float-label col-6 col-sm-3">
									<select name="cbociclo" id="cbociclo" data-currentvalue='' class="form-control text-uppercase">
										<option value="">Seleccione ciclo</option>
										<?php foreach ($ciclo as $dts) {
											echo "<option value='$dts->id'>$dts->nomcic</option>";
										} ?>
									</select>
									<label for="cbociclo">ciclo</label>
								</div>
							</div>
							<div class="row mt-2">
								<div class="form-group has-float-label col-12 col-sm-5">
									<select name="cboplan" id="cboplan" data-currentvalue='' class="form-control text-uppercase">
										<option value="">Seleccione plan estudios</option>
										<?php foreach ($planes as $pln) {
											echo "<option value='$pln->id'>$pln->nombre</option>";
										} ?>
									</select>
									<label for="cboplan">plan estudios</label>
								</div>
								<div class="form-group has-float-label col-12 col-sm-4">
									<select name="cbomodulo" id="cbomodulo" data-currentvalue='' class="form-control text-uppercase">
										<option value="">Sin opciones</option>
									</select>
									<label for="cbomodulo">Módulo</label>
								</div>
								<div class="form-group has-float-label col-12 col-sm-3">
									<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxthorter" name="fictxthorter" type="number" placeholder="Horas teoria" />
									<label for="fictxthorter">Horas teoria</label>
								</div>
							</div>
							<div class="row mt-2">
								<div class="form-group has-float-label col-6 col-sm-3">
									<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxthorprac" name="fictxthorprac" type="number" placeholder="Horas práctica" />
									<label for="fictxthorprac">Horas práctica</label>
								</div>
								<div class="form-group has-float-label col-6 col-sm-3">
									<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxthorcic" name="fictxthorcic" type="number" placeholder="Horas ciclo" />
									<label for="fictxthorcic">Horas ciclo</label>
								</div>
								<div class="form-group has-float-label col-6 col-sm-3">
									<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxtcredter" name="fictxtcredter" type="number" placeholder="Créditos teoria" />
									<label for="fictxtcredter">Créditos teoria</label>
								</div>
								<div class="form-group has-float-label col-6 col-sm-3">
									<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxtcredprac" name="fictxtcredprac" type="number" placeholder="Créditos práctica" />
									<label for="fictxtcredprac">Créditos práctica</label>
								</div>
							</div>
							<div class="row mt-1">
					        	<div class="col-6">
					        		<div id="divmsgunidad" class="float-left">
										
									</div>
								</div>
								<div class="col-6">
									<button type="submit" class="btn btn-primary float-right" id="btn_modulo"><i class="fas fa-save"></i> Registrar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="active tab-pane" id="search-unidad">
						<form id="frm-filtro-unidad" name="frm-filtro-unidad" action="<?php echo $vbaseurl ?>unidaddidactica/fn_unidad_x_parametros" method="post" accept-charset='utf-8'>
							<div class="row">
								<div class="form-group has-float-label col-6 col-xs-6 col-sm-3 col-md-3">
									<select name="txtcarrera" id="txtcarrera" class="form-control">
										<option value="0">Seleccione carrera</option>
										<?php foreach ($carreras as $car) {
											$codcar = base64url_encode($car->id);
											echo "<option value='$codcar'>$car->nombre</option>";
										} ?>
									</select>
									<label for="txtcarrera">Carrera</label>
								</div>
								<div class="form-group has-float-label col-6 col-xs-3 col-sm-3 col-md-3">
									<select name="txtplan" id="txtplan" class="form-control">
										<option data-carrera='0' value="0">Seleccione plan estudios</option>
										<?php foreach ($planes as $pln) {
											$codpl = base64url_encode($pln->id);
											$codcar = base64url_encode($pln->codcar);
											echo "<option class='ocultar' data-carrera='$codcar' value='$codpl'>$pln->nombre</option>";
										} ?>
									</select>
									<label for="txtplan">Nombre Plan</label>
								</div>
								<div class="form-group has-float-label col-6 col-xs-6 col-sm-3 col-md-3">
									<select data-plan='0' name="txtmodulo" id="txtmodulo" class="form-control">
										<option value="0">Seleccione módulo</option>
										<?php foreach ($modulos as $mdls) {
											$codmod = base64url_encode($mdls->id);
											$idplan = base64url_encode($mdls->idplan);
											echo "<option class='ocultar' data-plan='$idplan' value='$codmod'>$mdls->modnom</option>";
										} ?>
									</select>
									<label for="txtmodulo">Nombre Módulo</label>
								</div>
								
								<div class="form-group has-float-label col-6 col-xs-6 col-sm-2 col-md-2">
									<select name="txtciclo" id="txtciclo" class="form-control">
										<option value="0">ciclo</option>
										<?php foreach ($ciclo as $dts) {
											$codcic = base64url_encode($dts->id);
											echo "<option value='$codcic'>$dts->nomcic</option>";
										} ?>
									</select>
									<label for="txtciclo">Ciclo</label>
								</div>
								<div class="col-12 col-xs-3 col-sm-1 col-md-1">
									<button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
						<div class="card-body no-padding">
				            <div class="row">
				                <div class="col-12 py-1" id="divdata-unidad">
				            	    <div class="card">
				                	    <div class="card-body">
				                      		<span class="text-danger">Utiliza el cuadro de búsqueda ubicado arriba para encontrar el historial existente de las unidades didácticas</span>
				                    	</div>
				                  	</div>
				                </div>
				            </div>
				        </div>
					</div>
				</div>
	      	</div>
	    </div>
	</section>
</div>

<script type="text/javascript">

	
	$('#frm-filtro-unidad').submit(function() {
	    $('#divdata-unidad').html("");
	    $('#frm-filtro-unidad input:text, select').removeClass('is-invalid');
	    $('#frm-filtro-unidad .invalid-feedback').remove();
	    $('#divcard_unidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divcard_unidad #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().parent().after("<div class='invalid-feedback btn-block'>" + val + "</div>");
	                });
	            } else {
	                $('#divdata-unidad').html(e.vdata);
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'div');
	            $('#divcard_unidad #divoverlay').remove();
	            $('#divdata-unidad').html(msgf);
	        }
	    });
	    return false;
	});
	
	$('#frm-filtro-unidad select').change(function(event) {
	    if ($(this).attr('id') == "txtcarrera") {
	        $('#frm-filtro-unidad #txtplan').val("0");
	        $('#frm-filtro-unidad #txtmodulo').val("0");
	        var codcar = $(this).val();
	       	$("#frm-filtro-unidad #txtplan option").each(function(i){
		        
		        if ($(this).data('carrera')=='0'){

		        }
		        else if ($(this).data('carrera')==codcar){
		        	$(this).removeClass('ocultar');
		        }
		        else{
		        	if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
		        }
		    });
	    }
	    if ($(this).attr('id') == "txtplan") {
	        $('#frm-filtro-unidad #txtmodulo').val("0");
	        var codplan = $(this).val();
	       	$("#frm-filtro-unidad #txtmodulo option").each(function(i){
		        if ($(this).data('plan')=='0'){

		        }
		        else if ($(this).data('plan')==codplan){
		        	$(this).removeClass('ocultar');
		        }
		        else{
		        	if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
		        }
		    });
	    }
	});

	$('#frm_unidad input,select').change(function(event) {
	    if ($(this).attr('id') == "cboplan") {
	        $('#divcard_unidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $('#frm_unidad #cbomodulo').html("<option value='0'>Sin opciones</option>");
	        var plan = $(this).val();
	        $.ajax({
	            url: base_url + 'unidaddidactica/fnmodulo_x_planes',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtplan: plan
	            },
	            success: function(e) {
	                $('#divcard_unidad #divoverlay').remove();
	                $('#frm_unidad #cbomodulo').html(e.vdata);
	            },
	            error: function(jqXHR, exception) {
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#frm_unidad #cbomodulo').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
	    }
	});

	$('#frm_unidad').submit(function() {
	    $('#frm_unidad input,select').removeClass('is-invalid');
	    $('#frm_unidad .invalid-feedback').remove();
	    $('#divcard_unidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divcard_unidad #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgunidad').html(msgf);
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                }).then((result) => {
	                  if (result.value) {
	                    //location.reload();
	                  }
	                })
	                $("#fictxtnombre").val("");
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_unidad #divoverlay').remove();
	            $('#divmsgunidad').show();
	            $('#divmsgunidad').html(msgf);
	        }
	    });
	    return false;
	});

	function viewupdaunidad(codigo) {
		$('#divcard_unidad_detalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
 		$("#divdatosunidad").html("");
	  	$.ajax({
	      	url: base_url + "unidaddidactica/vwmostrar_datosxcodigo",
	      	type: 'post',
	     	dataType: "json",
	      	data: {txtcodigo: codigo},
	      	success: function(e) {
	        	$('#divcard_unidad_detalle #divoverlay').remove();
	        	$("#divdatosunidad").html(e.unidup);
	        	$("#modupdaunidad").modal("show");
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception, 'div');
	          	$('#divcard_unidad_detalle #divoverlay').remove();
	          	$("#modupdaunidad modal-body").html(msgf);
	      	} 
	  	});
  		return false;
	}

	$('#btn_upunidad').click(function() {
	    $('#frm_unidad_ed input,select').removeClass('is-invalid');
	    $('#frm_unidad_ed .invalid-feedback').remove();
	    $('#divmodalupd').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + "unidaddidactica/fn_insert_unidades",
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_unidad_ed').serialize(),
	        success: function(e) {
	            $('#divmodalupd #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgunidaded').html(msgf);
	                $('#modupdaunidad').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                }).then((result) => {
	                  if (result.value) {
	                    //location.reload();
	                  }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divmodalupd #divoverlay').remove();
	            $('#divmsgunidaded').show();
	            $('#divmsgunidaded').html(msgf);
	        }
	    });
	    return false;
	});

	$('#modal_danger_unidad').on('show.bs.modal', function (e) {
	    var rel=$(e.relatedTarget);
	    $("#btnelimina_unidad").data('idund', rel.data("idund"));
	});

	$('#btnelimina_unidad').click(function() {
	    var codigo=$(this).data("idund");
	    $('#div_danger').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + 'unidaddidactica/fn_eliminar_unidad',
	        type: 'post',
	        dataType: 'json',
	        data: {txtcodigo:codigo},
	        success: function(e) {
	        	$('#div_danger #divoverlay').remove();
	            if (e.status == false) {
	            	var msgf = '<span class="text-danger"><i class="fa fa-close"></i> No se pudo eliminar</span>';
	                Swal.fire({
	                    title: msgf,
	                    // text: "",
	                    type: 'error',
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	            } else {
	                $('#btnelimina_unidad').prop('disabled', true);
	                $('#modal_danger_unidad').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                }).then((result) => {
	                  if (result.value) {
	                    location.reload();
	                  }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#div_danger #divoverlay').remove();
	            $('#divmsgeditorial').show();
	            $('#divmsgeditorial').html(msgf);
	        }
	    });
	});
</script>
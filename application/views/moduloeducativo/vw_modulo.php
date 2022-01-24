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
	<div class="modal fade" id="modupdamodulo" tabindex="-1" role="dialog" aria-labelledby="modupdamodulo" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered" role="document">
      		<div class="modal-content" id="divmodalupd">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle">ACTUALIZAR DATOS</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body">
	          		<div id="divdatosmodulo">
	            
	          		</div>
	        	</div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		          	<button type="button" id="btn_upmodulo" class="btn btn-primary">Guardar</button>
		        </div>
      		</div>
    	</div>
  	</div>
  	<div class="modal fade" id="modal_danger_modulo" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content bg-danger" id="div_danger">
	            <div class="modal-header">
		            <h4 class="modal-title">Alerta de Eliminación</h4>
	    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		    <span aria-hidden="true">×</span>
	              	</button>
	            </div>
	            <div class="modal-body">
	            	<h4>Esta seguro de eliminar este módulo educativo?....!</h4>
	            </div>
	            <div class="modal-footer justify-content-between">
	              	<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
	              	<button type="button" class="btn btn-outline-light" id="btnelimina_modulo" data-idmod=''>Eliminar</button>
	            </div>
	        </div>
	    </div>
	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_modulo" class="card">
		    <div class="card-header p-2">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-modulo" data-toggle="tab"><b><i class="fas fa-search mr-1"></i>Búsqueda</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-modulo" data-toggle="tab"><b><i class="fas fa-user-plus mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
	      	<div class="card-body p-2">
	      		<div class="tab-content">
			    	<div class="tab-pane" id="registrar-modulo">
	      				<div class="alert alert-dark alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si el MÓDULO no ha sido registrado anteriormente
							<button type="button" class="close" data-dismiss="alert">×</button>
						</div>
						<form class="form-neo" id="frm_modulo" action="<?php echo $vbaseurl ?>moduloeducativo/fn_insert_modulos" method="post" accept-charset="utf-8">
							<div class="row mt-2">
								<div class="form-group has-float-label col-12 col-sm-4">
									<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="INSERTAR">
									<input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre módulo" />
									<label for="fictxtnombre">Nombre módulo</label>
								</div>
								<div class="form-group has-float-label col-12 col-sm-3">
									<input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtmodnum" name="fictxtmodnum" type="number" placeholder="Número módulo" />
									<label for="fictxtmodnum">Número módulo</label>
								</div>
								<div class="form-group has-float-label col-12 col-sm-5">
									<select name="cboplanestud" id="cboplanestud" data-currentvalue='' class="form-control text-uppercase">
										<option value="">Seleccione plan estudios</option>
										<?php foreach ($planes as $dts) {
											echo "<option value='$dts->id'>$dts->nombre</option>";
										} ?>
									</select>
									<label for="cboplanestud">Plan estudios</label>
								</div>
							</div>
							<div class="row mt-2">
								<div class="form-group has-float-label col-12 col-sm-4">
									<input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxthoras" name="fictxthoras" type="number" placeholder="Horas módulo" />
									<label for="fictxthoras">Horas módulo</label>
								</div>
								<div class="form-group has-float-label col-12 col-sm-4">
									<input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtcreditos" name="fictxtcreditos" type="number" placeholder="Créditos módulo" />
									<label for="fictxtcreditos">Créditos módulo</label>
								</div>
							</div>
							<div class="row mt-1">
					        	<div class="col-6">
					        		<div id="divmsgmodulo" class="float-left">
										
									</div>
								</div>
								<div class="col-6">
									<button type="submit" class="btn btn-primary float-right" id="btn_modulo"><i class="fas fa-save"></i> Registrar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="active tab-pane" id="search-modulo">
						<form id="frm-filtro-modulo" name="frm-filtro-modulo" action="<?php echo $vbaseurl ?>moduloeducativo/search_modulos" method="post" accept-charset='utf-8'>
							<div class="row">
								<div class="form-group input-group no-flex col-12 col-xs-3 col-sm-5 col-md-5">
									<div class="input-group-prepend">
										<div class="input-group-text radiobusqueda">
											<input  value="xnombre" name="rbgbusqueda" type="radio">
										</div>
										<label class="has-float-label">
											<select name="txtnombre" id="txtnombre" class="form-control" disabled>
												<option value="">Seleccione módulo</option>
												<?php foreach ($modulos as $mod) {
													$codmod = base64url_encode($mod->id);
													echo "<option value='$codmod'>$mod->modnom</option>";
												} ?>
											</select>
											<span>Nombre Módulo</span>
										</label>
									</div>
								</div>
								<div class="form-group input-group no-flex col-12 col-xs-6 col-sm-5 col-md-5">
									<div class="input-group-prepend">
										<div class="input-group-text bg-primary radiobusqueda">
											<input value="xcarrera" checked="true" name="rbgbusqueda"  type="radio">
										</div>
										<label class="has-float-label">
											<select name="txtbusqueda" id="txtbusqueda" class="form-control">
												<option value="">Seleccione carrera</option>
												<?php foreach ($carreras as $car) {
													$codcar = base64url_encode($car->id);
													echo "<option value='$codcar'>$car->nombre</option>";
												} ?>
											</select>
											<span>Carrera</span>
										</label>
									</div>
								</div>
								<div class="col-12 col-xs-3 col-sm-2 col-md-2">
									<button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
						<div class="card-body no-padding">
				            <div class="row">
				                <div class="col-12 py-1" id="divdata-modulo">
				            	    <div class="card">
				                	    <div class="card-body">
				                      		<b class="text-danger">Utiliza el cuadro de búsqueda ubicado arriba para encontrar el historial existente de los módulos</b>
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
	$('#frm-filtro-modulo input[type=radio][name=rbgbusqueda]').change(function() {
	    // Do something interesting here
	    var rd = $(this);
	    $('input[type=radio][name=rbgbusqueda]').parent().removeClass('bg-primary');
	    $('input[type=radio][name=rbgbusqueda]').parent().parent().find('select').attr('disabled', true);
	    rd.parent().addClass('bg-primary');
	    rd.parent().parent().find('select').attr('disabled', false);
	});
	$('#frm-filtro-modulo .radiobusqueda').click(function(event) {
	    $(this).find('input').change();
	    $(this).find('input').prop('checked', true)
	});
	$('#frm-filtro-modulo').submit(function() {
	    $('#divdata-modulo').html("");
	    $('#frm-filtro-modulo input:text,select').removeClass('is-invalid');
	    $('#frm-filtro-modulo .invalid-feedback').remove();
	    $('#divcard_modulo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divcard_modulo #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().parent().after("<div class='invalid-feedback btn-block'>" + val + "</div>");
	                });
	            } else {
	                $('#divdata-modulo').html(e.vdata);
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'div');
	            $('#divcard_modulo #divoverlay').remove();
	            $('#divdata-modulo').html(msgf);
	        }
	    });
	    return false;
	});

	$('#frm_modulo').submit(function() {
	    $('#frm_modulo input,select').removeClass('is-invalid');
	    $('#frm_modulo .invalid-feedback').remove();
	    $('#divcard_modulo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divcard_modulo #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgmodulo').html(msgf);
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
	            $('#divcard_modulo #divoverlay').remove();
	            $('#divmsgmodulo').show();
	            $('#divmsgmodulo').html(msgf);
	        }
	    });
	    return false;
	});

	// $('#fictxtbuscar').keyup(function(event) {
	// 	var nautor = $('#fictxtbuscar').val();

	// 	var keycode = event.keyCode || event.which;
	//     if(keycode == '13') {       
	//          search_modulos(nautor);
	//     }
	// });

	// $('#btn_busca_mod').click(function(event) {
	// 	var nautor = $('#fictxtbuscar').val();
	// 	search_modulos(nautor);
	// });

	

	function viewupdamodulo(codigo) {
		$('#divcard_modulo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
 		$("#divdatosmodulo").html("");
	  	$.ajax({
	      	url: base_url + "moduloeducativo/vwmostrar_datosxcodigo",
	      	type: 'post',
	     	dataType: "json",
	      	data: {txtcodigo: codigo},
	      	success: function(e) {
	        	$('#divcard_modulo #divoverlay').remove();
	        	$("#divdatosmodulo").html(e.modulup);
	        	$("#modupdamodulo").modal("show");
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception,'div' );
	          	$('#divcard_modulo #divoverlay').remove();
	          	$("#modupdamodulo modal-body").html(msgf);
	      	} 
	  	});
  		return false;
	}

	$('#btn_upmodulo').click(function() {
	    $('#frm_modulo_ed input,select').removeClass('is-invalid');
	    $('#frm_modulo_ed .invalid-feedback').remove();
	    $('#divmodalupd').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + "moduloeducativo/fn_insert_modulos",
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_modulo_ed').serialize(),
	        success: function(e) {
	            $('#divmodalupd #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgmoduloed').html(msgf);
	                $('#modupdamodulo').modal('hide');
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
	            $('#divmodalupd #divoverlay').remove();
	            $('#divmsgmoduloed').show();
	            $('#divmsgmoduloed').html(msgf);
	        }
	    });
	    return false;
	});
	$('#modal_danger_modulo').on('show.bs.modal', function (e) {
	    var rel=$(e.relatedTarget);
	    $("#btnelimina_modulo").data('idmod', rel.data("idmod"));
	});

	$('#btnelimina_modulo').click(function() {
	    var codigo=$(this).data("idmod");
	    $('#div_danger').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + 'moduloeducativo/fn_eliminar_modulo',
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
	                $('#btnelimina_modulo').prop('disabled', true);
	                $('#modal_danger_modulo').modal('hide');
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
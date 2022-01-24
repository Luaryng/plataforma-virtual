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
	<div class="modal fade" id="modupdaplan" tabindex="-1" role="dialog" aria-labelledby="modupdaplan" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered" role="document">
      		<div class="modal-content" id="divmodalupd">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle">ACTUALIZAR DATOS</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body">
	          		<div id="divdatosplan">
	            
	          		</div>
	        	</div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		          	<button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
		        </div>
      		</div>
    	</div>
  	</div>
  	<div class="modal fade" id="modal_danger_plan" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content bg-danger" id="div_danger">
	            <div class="modal-header">
		            <h4 class="modal-title">Alerta de Eliminación</h4>
	    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		    <span aria-hidden="true">×</span>
	              	</button>
	            </div>
	            <div class="modal-body">
	            	<h4>Esta seguro de eliminar este plan de estudios?....!</h4>
	            </div>
	            <div class="modal-footer justify-content-between">
	              	<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
	              	<button type="button" class="btn btn-outline-light" id="btnelimina_plan" data-idplan=''>Eliminar</button>
	            </div>
	        </div>
	    </div>
	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_plan" class="card">
			<div class="card-header p-2">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-plan" data-toggle="tab"><b><i class="fas fa-search mr-1"></i>Búsqueda</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-plan" data-toggle="tab"><b><i class="fas fa-graduation-cap mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
	      	<div class="card-body p-2">
	      		<div class="tab-content">
			    	<div class="tab-pane" id="registrar-plan">
	      				<div class="alert alert-dark alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si el PLAN DE ESTUDIOS no ha sido registrado anteriormente
							<button type="button" class="close" data-dismiss="alert">×</button>
						</div>
						<form class="form-neo" id="frm_plan" action="<?php echo $vbaseurl ?>plancurricular/fn_insert_plan_estudios" method="post" accept-charset="utf-8">
							<div class="row mt-2">
								<div class="form-group has-float-label col-12 col-sm-4">
									<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="INSERTAR">
									<input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre" />
									<label for="fictxtnombre">Nombre</label>
								</div>
								<div class="form-group has-float-label col-12 col-sm-4">
									<select name="cboperiodo" id="cboperiodo" data-currentvalue='' class="form-control text-uppercase">
										<option value="">Seleccione periodo</option>
										<?php foreach ($periodo as $prd) {
											echo "<option value='$prd->codigo'>$prd->nombre</option>";
										} ?>
									</select>
									<label for="cboperiodo">Periodo</label>
								</div>
								<div class="form-group has-float-label col-12 col-sm-4">
									<select name="cbocarrera" id="cbocarrera" data-currentvalue='' class="form-control text-uppercase">
										<option value="">Seleccione carrera</option>
										<?php foreach ($carrera as $cra) {
											echo "<option value='$cra->id'>$cra->nombre</option>";
										} ?>
									</select>
									<label for="cbocarrera">Carrera</label>
								</div>
							</div>
							<div class="row mt-2">
								<div class="form-group has-float-label col-12 col-sm-4">
									<input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtdecreto" name="fictxtdecreto" type="text" placeholder="Decreto supremo" />
									<label for="fictxtdecreto">Decreto supremo</label>
								</div>
								<div class="form-group has-float-label col-12 col-sm-4">
									<input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtresolu" name="fictxtresolu" type="text" placeholder="Resolución" />
									<label for="fictxtresolu">Resolución</label>
								</div>
							</div>
							<div class="row mt-1">
					        	<div class="col-6">
					        		<div id="divmsgplan" class="float-left">
										
									</div>
								</div>
								<div class="col-6">
									<button type="submit" class="btn btn-primary float-right" id="btn_plan"><i class="fas fa-save"></i> Registrar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="active tab-pane" id="search-plan">
						<form id="frm-filtro-plan" name="frm-filtro-plan" action="<?php echo $vbaseurl ?>plancurricular/fn_filtrar_planes" method="post" accept-charset='utf-8'>
							<div class="row">
								<div class="form-group input-group no-flex col-12 col-xs-3 col-sm-3 col-md-3">
									<div class="input-group-prepend">
										<div class="input-group-text radiobusqueda">
											<input  value="xperiodo" name="rbgbusqueda" type="radio">
										</div>
										<label class="has-float-label">
											<input  id="txtperiodo" name="txtperiodo" class="form-control" type="text" placeholder="Periodo" disabled />
											<span>Periodo</span>
										</label>
									</div>
								</div>
								<div class="form-group input-group no-flex col-12 col-xs-6 col-sm-6 col-md-7">
									<div class="input-group-prepend">
										<div class="input-group-text bg-primary radiobusqueda">
											<input value="xcarrera" checked="true" name="rbgbusqueda"  type="radio">
										</div>
										<label class="has-float-label">
											<select name="txtbusqueda" id="txtbusqueda" class="form-control">
												<option value="">Seleccione carrera</option>
												<?php foreach ($carrera as $car) {
													$codcar = base64url_encode($car->id);
													echo "<option value='$codcar'>$car->nombre</option>";
												} ?>
											</select>
											<span>Carrera</span>
										</label>
									</div>
								</div>
								<div class="col-12 col-xs-3 col-sm-3 col-md-2">
									<button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
						<div class="card-body no-padding">
							<div class="row">
								<div class="col-12 py-1" id="divres-plan">
									<div class="card">
										<div class="card-body">
											<b class='text-danger'>Utiliza los cuadros de búsqueda ubicados arriba para encontrar el historial existente del plan de estudios</b>
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
	$('#frm-filtro-plan input[type=radio][name=rbgbusqueda]').change(function() {
	    // Do something interesting here
	    var rd = $(this);
	    $('input[type=radio][name=rbgbusqueda]').parent().removeClass('bg-primary');
	    $('input[type=radio][name=rbgbusqueda]').parent().parent().find('input[type=text]').attr('disabled', true);
	    $('input[type=radio][name=rbgbusqueda]').parent().parent().find('select').attr('disabled', true);
	    rd.parent().addClass('bg-primary');
	    rd.parent().parent().find('input[type=text]').attr('disabled', false);
	    rd.parent().parent().find('select').attr('disabled', false);
	    rd.parent().parent().find('input[type=text]').focus();
	});
	$('#frm-filtro-plan .radiobusqueda').click(function(event) {
	    $(this).find('input').change();
	    $(this).find('input').prop('checked', true)
	});
	$('#frm-filtro-plan').submit(function() {
	    $('#divres-plan').html("");
	    $('#frm-filtro-plan input:text,select').removeClass('is-invalid');
	    $('#frm-filtro-plan .invalid-feedback').remove();
	    $('#divcard_plan').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divcard_plan #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().parent().after("<div class='invalid-feedback btn-block'>" + val + "</div>");
	                });
	            } else {
	                $('#divres-plan').html(e.vdata);
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'div');
	            $('#divcard_plan #divoverlay').remove();
	            $('#divres-plan').html(msgf);
	        }
	    });
	    return false;
	});
	$('#frm_plan').submit(function() {
	    $('#frm_plan input,select').removeClass('is-invalid');
	    $('#frm_plan .invalid-feedback').remove();
	    $('#divcard_plan').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divcard_plan #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgplan').html(msgf);
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
	            $('#divcard_plan #divoverlay').remove();
	            $('#divmsgplan').show();
	            $('#divmsgplan').html(msgf);
	        }
	    });
	    return false;
	});

	function viewupdaplan(codigo) {
		$('#divcard_plan').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
 		$("#divdatosplan").html("");
	  	$.ajax({
	      	url: base_url + "plancurricular/vwmostrar_datosxcodigo",
	      	type: 'post',
	     	dataType: "json",
	      	data: {txtcodigo: codigo},
	      	success: function(e) {
	        	$('#divcard_plan #divoverlay').remove();
	        	$("#divdatosplan").html(e.planup);
	        	$("#modupdaplan").modal("show");
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception, 'div');
	          	$('#divcard_plan #divoverlay').remove();
	          	$("#modupdaplan modal-body").html(msgf);
	      	} 
	  	});
  		return false;
	}

	$('#lbtn_guardar').click(function() {
	    $('#frm_plan_update input,select').removeClass('is-invalid');
	    $('#frm_plan_update .invalid-feedback').remove();
	    $('#divmodalupd').append('<div id="divoverlay" class="overlay" style="background: #fff;"><i class="fas fa-spinner fa-pulse fa-3x" style="margin-left: 46%;margin-top: 30%;"></i></div>');
	    $.ajax({
	        url: base_url + "plancurricular/fn_insert_plan_estudios",
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_plan_update').serialize(),
	        success: function(e) {
	            $('#divmodalupd #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgplanupd').html(msgf);
	                $('#modupdaplan').modal('hide');
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
	            $('#divmsgplanupd').show();
	            $('#divmsgplanupd').html(msgf);
	        }
	    });
	    return false;
	});
	$('#modal_danger_plan').on('show.bs.modal', function (e) {
	    var rel=$(e.relatedTarget);
	    $("#btnelimina_plan").data('idplan', rel.data("idplan"));
	});

	$('#btnelimina_plan').click(function() {
	    var codigo=$(this).data("idplan");
	    $('#div_danger').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + 'plancurricular/fn_eliminar_plan',
	        type: 'post',
	        dataType: 'json',
	        data: {txtcodigo:codigo},
	        success: function(e) {
	        	$('#div_danger #divoverlay').remove();
	            if (e.status == false) {
	                $('#divmsgeditorial').html('<span class="text-danger"><i class="fa fa-close"></i> No se pudo eliminar</span>');
	            } else {
	                $('#btnelimina_plan').prop('disabled', true);
	                $('#modal_danger_plan').modal('hide');
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
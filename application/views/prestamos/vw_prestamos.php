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
    <div class="modal fade" id="modal_prestamos" tabindex="-1" role="dialog" aria-labelledby="modal_prestamos" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="divmodalupd">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">DATOS DE LIBROS PRESTADOS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="divprestamosup">
                
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="lbtn-guardar" class="btn btn-primary">Guardar</button>
                </div> -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_devolver" tabindex="-1" role="dialog" aria-labelledby="modal_devolver" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="divmodalupdev">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">DEVOLUCIONES</h5>
                    <button type="button" class="close btn_regresar" data-dismiss="modal" aria-label="Close" id="">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="divprestamosupdev">
                
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_regresar" data-dismiss="modal" id="">Cancel</button>
                    <button type="button" id="btn_actdatos" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="modupdatlibro" tabindex="-1" role="dialog" aria-labelledby="modupdatlibro" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      		<div class="modal-content" id="divmodalupd">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle"> BUSCAR LIBRO</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body" id="divmodalbody">
	          		<div id="divlibrooup">
	            		<div class="row">
			      			<div class="form-group has-float-label col-md-8 col-sm-8">
					        	<input class="form-control" type="text" placeholder="Nombre Libro" name="txtnomlibro" id="txtnomlibro">
					        	<label for="txtnomlibro">Nombre Libro</label>
					      	</div>
					      	<div class="col-md-4 col-sm-4">
					        	<button class="btn btn-block btn-info" type="button" id="busca_libro">
					        		<i class="fas fa-search"></i>
					        	</button>
					      	</div>
					      	<div class="col-md-4">
					      		<div id="divmsg_historial"></div>
					      	</div>
			      		</div>
			      		<div class="row">
					    	<div id="divhistorial_libros" class="no-padding col-sm-12">
					    		<h4 class="ml-3">---- INGRESA NOMBRE DEL LIBRO ----</h4>
					    	</div>
					    </div>
	          		</div>
	        	</div>
		        <!-- <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		          	<button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
		        </div> -->
      		</div>
    	</div>
  	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_prestamo" class="card bg-light text-dark">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#search-prestamo" data-toggle="tab"><b><i class="fas fa-search mr-1"></i>Búsqueda</b></a></li>
                    <li class="nav-item"><a class="nav-link" href="#registrar-prestamo" data-toggle="tab"><b><i class="fas fa-book-open mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
	      	<div class="card-body p-2">
                <div class="tab-content">
                    <div class="tab-pane" id="registrar-prestamo">
                        <div class="alert alert-dark alert-dismissible fade show bordered">
                            <strong>Aviso:</strong> Antes de ingresar los datos, verifica si el ALUMNO no tiene libros prestados
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
        				<form class="form-neo" id="frm_prestamo" action="<?php //echo $vbaseurl ?>" method="post" accept-charset='utf-8'>
        					<b class="margin-top-10px text-danger"><i class="fas fa-user"></i> Alumno</b>
        					<div class="row mt-2">
        						<div class="input-group mb-3 col-12 col-sm-3">
        							<input class="form-control text-uppercase" id="fictxtcarne" name="fictxtcarne" type="text" placeholder="Carnet" />
        							<div class="input-group-append">
        				                <button class="btn btn-info" id="btn_alumsearch" type="button">
        				                	<i class="fas fa-arrow-alt-circle-right"></i>
        				                </button>
                      				</div>
        						</div>
        						<div class="form-group col-12 col-sm-9">
        							<input type="hidden" name="fictxtidinscrip" id="fictxtidinscrip" value="">
        							<span id="fictxtnombres" class=" form-control bg-light"></span>
        						</div>
        						<div class="ml-3 mb-3" id="divmsgnros"></div>
        					</div>
        					<div class="div_libro_search">
        						<b class="margin-top-10px text-danger"><i class="fas fa-book"></i> Libro</b>
        						<div class="row mt-2">
        							<div class="form-group col-12 col-sm-2">
        								<button type="button" class="btn btn-info btn-block btn_searchlib" disabled="" data-toggle="modal" data-target="#modupdatlibro">Buscar Libro</button>
        							</div>
        							<div class="form-group col-12 col-sm-2">
        								<input type="text" name="fictxtcodejm" id="fictxtcodejm" value="" placeholder="" readonly="" class="form-control bg-light">
        							</div>
        							<div class="form-group col-12 col-sm-6">
        								<span id="fictxtlibro" class=" form-control bg-light"></span>
        							</div>
        							<div class="form-group col-12 col-sm-2">
        								<input type="text" name="fictxtestado" id="fictxtestado" value="" placeholder="" readonly="" class="form-control bg-light">
        							</div>
        						</div>
        					</div>
        					<div class="div_prestamo">
        						<div class="row mt-2">
        							<div class="form-group has-float-label col-12 col-sm-3">
        								<?php date_default_timezone_set ('America/Lima'); $fecha = date('Y-m-d'); $hora = date('H:i'); ?>
        								<input data-currentvalue='' value="<?php echo $fecha ?>" class="form-control text-uppercase" id="ficfecentrega" name="ficfecentrega" type="date" placeholder="Fecha Entrega" />
        								<label for="ficfecentrega">Fecha Entrega</label>
        							</div>
        							<div class="form-group has-float-label col-12 col-sm-3">
        								<input data-currentvalue='' value="<?php echo $hora ?>" class="form-control text-uppercase" id="fichorentrega" name="fichorentrega" type="time" placeholder="Hora Entrega" />
        								<label for="fichorentrega">Hora Entrega</label>
        							</div>
        							<div class="form-group has-float-label col-12 col-sm-3">
        								<input data-currentvalue='' class="form-control text-uppercase" id="ficfeclimit" name="ficfeclimit" type="date" placeholder="Fecha Devolución" />
        								<label for="ficfeclimit">Fecha Devolución</label>
        							</div>
        							<div class="form-group has-float-label col-12 col-sm-3">
        								<input data-currentvalue='' class="form-control text-uppercase" id="fichorlimit" name="fichorlimit" type="time" placeholder="Hora Devolución" />
        								<label for="fichorlimit">Hora Devolución</label>
        							</div>
        						</div>
        						<div class="row mt-2">
        							<div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
        					            <textarea class="form-control" id="fitxtobservaciones" name="fitxtobservaciones" placeholder="Observaciones" rows="3"></textarea>
        					            <label for="fitxtobservaciones"> Observaciones</label>
        					        </div>
        						</div>
        					</div>
        					<div class="row mt-1">
        			        	<div class="col-6">
        			        		<div id="divmsgprestamo" class="float-left">
        								
        							</div>
        						</div>
        						<div class="col-6">
        							<button type="button" class="btn btn-primary float-right" id="btn_prestamo" disabled=""><i class="fas fa-save"></i> Registrar</button>
        						</div>
        					</div>
        				</form>
                    </div>
                    <div class="active tab-pane" id="search-prestamo">
                        <div class="row mt-2">
                            <div class="form-group has-float-label col-md-4 col-sm-4 col-8">
                                <input class="form-control text-uppercase" type="text" placeholder="Carnet" name="fictxtcarnedev" id="fictxtcarnedev">
                                <label for="fictxtcarnedev">Carnet</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-4">
                                <button class="btn btn-block btn-info" type="button" id="btn_alumsearchdev">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row mt-3" id="divdatospres">
                            <div class="form-group col-md-9 col-sm-9 col-12">
                                <span id="fictxtnombresearch" class="form-control bg-light text-center"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-12">
                                <button class="btn btn-info btn-block d-none" id="btn_ver" data-cart=''><span class="fas fa-eye"></span> Ver Historial</button>
                            </div>
                        </div>
                        <div class="card-body no-padding">
                            <div class="row">
                                <div class="col-12 py-1" id="divdata-autor">
                                    <div class="card">
                                        <div class="card-body">
                                            <b class="text-danger">Utiliza el cuadro de búsqueda ubicado arriba para encontrar el historial existente de los libros prestados por alumno</b>
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
$("#btn_alumsearch").click(function(event) {
    var carne = $('#fictxtcarne').val();
    search_alumno(carne);
    return false;
});

function search_alumno(carne){
    $('#divcard_prestamo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'prestamos/fn_get_alumno',
        type: 'post',
        dataType: 'json',
        data: {txtcarne:carne},
        success: function(e) {
            $('#divcard_prestamo #divoverlay').remove();
            if (e.status == false) {
            	$('#fictxtnombres').html(e.msg);
            } else {
                if (e.vdata['idpersona'] == '0') {
                    $('#fictxtnombres').html('ALUMNO NO ENCONTRADO');
                    $('.btn_searchlib').prop('disabled', true);
                    $('#divmsgnros').html('');
                } 
                else {
                	$('#fictxtidinscrip').val(e.vdata['idins']);
                    $('#fictxtnombres').html(e.vdata['paterno'] + ' ' + e.vdata['materno'] + ' ' + e.vdata['nombres']);
                    $('.btn_searchlib').prop('disabled', false);
                    
                    if (e.vnros > 0) {
                    	$('#divmsgnros').html('<span class="text-danger">*Este alumno tiene ' + e.vnros + ' libros prestados</span>');
                    } else {
                    	$('#divmsgnros').html('<span class="text-success">*Alumno no registra libros prestados</span>');
                    	
                    }
                    
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard_prestamo #divoverlay').remove();
            $('#divmsgprestamo').show();
            $('#divmsgprestamo').html(msgf);
        }
    });
}

$('#txtnomlibro').keypress(function(event) {
    var keycode = event.keyCode || event.which;
    if(keycode == '13') {            
         search_libro($('#txtnomlibro').val());
    }
});

$('#busca_libro').click(function() {
    var nomlb = $('#txtnomlibro').val();
    search_libro(nomlb);
    return false;
});

function search_libro(nomlb){
    $('#divhistorial_libros').html("");
    $('#divmodalbody').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'prestamos/vwmostrar_libros_pres',
            type: 'post',
            dataType: 'json',
            data: {txtnlib : nomlb},
            success: function(e) {
                if (e.status == true) {
                    $('#divhistorial_libros').html(e.detallelib);
                    $('#divmsg_historial').html('');
                } else {
                	
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divhistorial_libros').html(msgf);
                }

                $('#divmodalbody #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divmodalbody #divoverlay').remove();
                $('#divhistorial_libros').html(msgf);
            },
        });
}

$('#btn_prestamo').click(function() {
	$('#frm_prestamo input,select').removeClass('is-invalid');
    $('#frm_prestamo .invalid-feedback').remove();
    $('#divcard_prestamo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'prestamos/fn_insert_prestamo',
        type: 'post',
        dataType: 'json',
        data: $('#frm_prestamo').serialize(),
        success: function(e) {
            $('#divcard_prestamo #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
              // $('#ejbtn-guardar').prop('disabled', true);
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                $('#divmsgprestamo').html(msgf);
                Swal.fire({
                    title: e.msg,
                    // text: "Por favor Agregue Ejemplares!",
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
            $('#divcard_prestamo #divoverlay').remove();
            $('#divmsgprestamo').show();
            $('#divmsgprestamo').html(msgf);
        }
    });
    return false;
});

    $('#divdatospres').hide();
    $('#fictxtcarnedev').keypress(function(event) {
        var keycode = event.keyCode || event.which;
        if(keycode == '13') {            
             search_alumnoxprestamo($('#fictxtcarnedev').val());
        }
    });

    $('#btn_alumsearchdev').click(function() {
        var carne = $('#fictxtcarnedev').val();
        search_alumnoxprestamo(carne);
        return false;
    });
    function search_alumnoxprestamo(carne){
    $('#divcard_prestamo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'prestamos/fn_get_alumnoxprestamo',
        type: 'post',
        dataType: 'json',
        data: {txtcardev:carne},
        success: function(e) {
            $('#divcard_prestamo #divoverlay').remove();
            $('#divdatospres').show();
            if (e.status == false) {
                $('#fictxtnombresearch').html(e.msg);
                $('#btn_ver').addClass('d-none');
            } else {
               if (e.vdata['idpersona'] == '0') {
                    $('#fictxtnombresearch').html('ALUMNO NO ENCONTRADO');
                    $('#btn_ver').addClass('d-none');
                } 
                else {
                    $('#fictxtnombresearch').html(e.vdata['paterno'] + ' ' + e.vdata['materno'] + ' ' + e.vdata['nombres']);
                    $('#btn_ver').removeClass('d-none');
                    $("#btn_ver").data('cart', e.vdata['carnet']);
                    
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard_prestamo #divoverlay').remove();
            $('#divmsgprestamo').show();
            $('#divmsgprestamo').html(msgf);
        }
    });
}

$('#btn_ver').click(function(event) {
    var carnet=$(this).data("cart");
    $('#divcard_prestamo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#divprestamosup").html("");
        $.ajax({
            url: base_url + "prestamos/vwmostrar_prestamosxalumno",
            type: 'post',
            dataType: "json",
            data: {txtcarnet: carnet},
            success: function(e) {
                $('#divcard_prestamo #divoverlay').remove();
                $("#divprestamosup").html(e.ejmuprs);
                $("#modal_prestamos").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'div');
                $('#divcard_prestamo #divoverlay').remove();
                $("#modal_prestamos modal-body").html(msgf);
            } 
        });
    return false;
});

$('.btn_regresar').click(function(event) {
    $("#modal_prestamos").modal("show");
});

$('#btn_actdatos').click(function() {
    $('#frm_devolucion input,select').removeClass('is-invalid');
    $('#frm_devolucion .invalid-feedback').remove();
    $('#modal_devolver').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'prestamos/fn_update_prestamo',
        type: 'post',
        dataType: 'json',
        data: $('#frm_devolucion').serialize(),
        success: function(e) {
            $('#modal_devolver #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                $('#btn_actdatos').prop('disabled', true);
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                $('#divmsgdevolver').html(msgf);
                $('#modal_devolver').modal('hide');
                Swal.fire({
                    title: e.msg,
                    // text: "Por favor Agregue Ejemplares!",
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
            $('#modal_devolver #divoverlay').remove();
            $('#divmsgdevolver').show();
            $('#divmsgdevolver').html(msgf);
        }
    });
    return false;
});
</script>
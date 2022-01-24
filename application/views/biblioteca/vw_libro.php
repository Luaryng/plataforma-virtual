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
	<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
	<div class="modal fade" id="modupdatelib" tabindex="-1" role="dialog" aria-labelledby="modupdatelib" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered" role="document">
      		<div class="modal-content" id="divmodalupd">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle">EDITAR LIBRO</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body">
	          		<div id="divlibrosup">
	            
	          		</div>
	        	</div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		          	<button type="button" id="lbtn-guardar" class="btn btn-primary">Guardar</button>
		        </div>
      		</div>
    	</div>
  	</div>

  	<div class="modal fade" id="modal-danger-lib" style="display: none;" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content bg-danger">
	            <div class="modal-header">
		            <h4 class="modal-title">Alerta de Eliminación</h4>
	    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		    <span aria-hidden="true">×</span>
	              	</button>
	            </div>
	            <div class="modal-body">
	            	<h4>Esta seguro de eliminar este libro?....!</h4>
	            </div>
	            <div class="modal-footer justify-content-between">
	              	<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
	              	<button type="button" class="btn btn-outline-light" id="btnelimlib" data-idlib=''>Eliminar</button>
	            </div>
	        </div>
	    </div>
	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard-biblioteca" class="card bg-light text-dark">
			<div class="card-header p-2">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-libro" data-toggle="tab"><b><i class="fas fa-search mr-1"></i>Búsqueda</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-libro" data-toggle="tab"><b><i class="fas fa-book-open mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
	      	<div class="card-body p-2">
	      		<div class="tab-content">
	      			<div class="tab-pane" id="registrar-libro">
	      				<div class="alert alert-dark alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si el LIBRO no ha sido registrado anteriormente
							<button type="button" class="close" data-dismiss="alert">×</button>
						</div>
						<form class="form-neo" id="frm_libro" action="<?php echo $vbaseurl ?>biblioteca/fn_insert_libro" method="post" accept-charset='utf-8'>
							<b class="text-danger"><i class="fas fa-book"></i> Libro</b>
							<div class="row mt-2">
								<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
									<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="INSERTAR">
									<input data-currentvalue='' class="form-control text-uppercase" id="fictxtnomlib" name="fictxtnomlib" type="text" placeholder="Nombre Libro" />
									<label for="fictxtnomlib">Nombre Libro</label>
								</div>
								<div class="form-group col-12 has-float-label col-xs-12 col-sm-6">
					            	<select data-currentvalue='' class="form-control select-lib" id="ficautor" name="ficautor" placeholder="autor" required data-live-search="true">
					              		<option value="0">Selecciona autor</option>
					              		<?php foreach ($autores as $atrs) { ?>
					              		<option value="<?php echo $atrs->id ?>"><?php echo $atrs->nombre ?></option>
					              		<?php } ?>
					            	</select>
					            	<label for="ficautor"> autor</label>
					          	</div>
							</div>
							<div class="row mt-1">
								<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
					            	<select data-currentvalue='' class="form-control select-lib" id="ficeditorial" name="ficeditorial" placeholder="editorial" required data-live-search="true">
					              		<option value="0">Selecciona editorial</option>
					              		<?php foreach ($editor as $edtr) { ?>
					              		<option value="<?php echo $edtr->id ?>"><?php echo $edtr->nombre ?></option>
					              		<?php } ?>
					            	</select>
					            	<label for="ficeditorial"> editorial</label>
					          	</div>
								<div class="form-group has-float-label col-12 col-xs-12 col-sm-6">
									<input data-currentvalue='' class="form-control text-uppercase" id="fictxtlibanio" name="fictxtlibanio" type="text" placeholder="Año Libro" />
									<label for="fictxtlibanio">Año Libro</label>
								</div>
							</div>
							<div class="row mt-1">
					        	<div class="col-6">
					        		<div id="divmsglib" class="float-left">
									</div>
									<input type="hidden" name="fictxtidlib" id="fictxtidlib" value="">
					        	</div>
								<div class="col-6">
									<!-- d-none -->
									<button type="submit" class="btn btn-primary float-right" id="btnregis"><i class="fas fa-save"></i> Registrar</button>
									<button type="button" class="btn btn-primary d-none float-right" id="btnejemp"><i class="fas fa-plus"></i> Agregar Ejemplares</button>
								</div>
							</div>
						</form>
						<div id="divcard_ejemplar">
					
						</div>
					</div>
					<div class="active tab-pane" id="search-libro">
						<div class="row mt-2">
			      			<div class="form-group has-float-label col-md-6 col-sm-8">
					        	<input class="form-control" type="text" placeholder="Nombre Libro" name="txtnomlibro" id="txtnomlibro">
					        	<label for="txtnomlibro">Nombre Libro</label>
					      	</div>
					      	<div class="col-md-2 col-sm-4">
					        	<button class="btn btn-block btn-info" type="button" id="busca_libro">
					        		<i class="fas fa-search"></i>
					        	</button>
					      	</div>
					      	<div class="col-md-4">
					      		<div id="divmsg_historial"></div>
					      	</div>
			      		</div>
			      		<div class="card-body no-padding">
				      		<div class="row">
						    	<div id="divhistorial_libros" class="col-12 py-1">
						    		<div class="card">
				                	    <div class="card-body">
				                      		<b class="text-danger">Utiliza el cuadro de búsqueda ubicado arriba para encontrar el historial existente de los libros</b>
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

<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/biblioteca.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>

<script>
	$('.select-lib').selectpicker();

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
	    $('#divcard-biblioteca').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'biblioteca/vwmostrar_libros',
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

                $('#divcard-biblioteca #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard-biblioteca #divoverlay').remove();
                $('#divhistorial_libros').html(msgf);
            },
        });
	}
	function viewupdatelib(icod){
	 	$('#divcard-biblioteca').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	 	$("#divlibrosup").html("");
		  	$.ajax({
		      	url: base_url + "biblioteca/vwmostrar_librosxcodigo",
		      	type: 'post',
		     	dataType: "json",
		      	data: {txtcodib: icod},
		      	success: function(e) {
		        	$('#divcard-biblioteca #divoverlay').remove();
		        	$("#divlibrosup").html(e.libupt);
		        	$("#modupdatelib").modal("show");
		      	},
		      	error: function(jqXHR, exception) {
		          	var msgf = errorAjax(jqXHR, exception,'div' );
		          	$('#divcard-biblioteca #divoverlay').remove();
		          	$("#modupdatelib modal-body").html(msgf);
		      	} 
		  	});
	  	return false;
	}

	$('#lbtn-guardar').click(function() {
		$('#frm_libro input,select').removeClass('is-invalid');
	    $('#frm_libro .invalid-feedback').remove();
	    $('#divmodalupd').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: base_url + 'biblioteca/fn_insert_libro',
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_libro').serialize(),
	        success: function(e) {
	            $('#divmodalupd #divoverlay').remove();
	            
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	            	// $('#lbtn-guardar').prop('disabled', true);
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                // $('#divmsglibup').html(msgf);
	                $('#modupdatelib').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    type:'success'
	                }).then((result) => {
	                  if (result.value) {
	                    search_libro($("#txtnomlibro").val());
	                  }
	                })
	                
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divmodalupd #divoverlay').remove();
	            $('#divmsglibup').show();
	            $('#divmsglibup').html(msgf);
	        }
	    });
	    return false;
	});

	$('#modal-danger-lib').on('show.bs.modal', function (e) {
	    var rel=$(e.relatedTarget);
	    $("#btnelimlib").data('idlib', rel.data("idlib"));
	});

	$('#btnelimlib').click(function() {
	    var idlib=$(this).data("idlib");
	    $.ajax({
	        url: base_url + 'biblioteca/fneliminar_libro',
	        type: 'post',
	        dataType: 'json',
	        data: {idlibro:idlib},
	        success: function(e) {

	            if (e.status == false) {
	                $('#divmsg_historial').html('<span class="text-danger"><i class="fa fa-close"></i> No se pudo eliminar</span>');
	            } else {
	                // $('#btnelimlib').prop('disabled', true);
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                // $('#divmsg_historial').html(msgf);
	                $('#modal-danger-lib').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    type:'success'
	                }).then((result) => {
	                  if (result.value) {
	                    search_libro($("#txtnomlibro").val());
	                  }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard-campania #divoverlay').remove();
	            $('#divmsg_historial').show();
	            $('#divmsg_historial').html(msgf);
	        }
	    });
	});
</script>

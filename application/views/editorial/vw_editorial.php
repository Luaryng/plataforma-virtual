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
	<div class="modal fade" id="modupdatedito" tabindex="-1" role="dialog" aria-labelledby="modupdatedito" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered" role="document">
      		<div class="modal-content" id="divmodalupd">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle">ACTUALIZAR EDITORIAL</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body">
	          		<div id="diveditoup">
	            
	          		</div>
	        	</div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		          	<button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
		        </div>
      		</div>
    	</div>
  	</div>

  	<div class="modal fade" id="modal-danger-editor" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog">
	        <div class="modal-content bg-danger">
	            <div class="modal-header">
		            <h4 class="modal-title">Alerta de Eliminación</h4>
	    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		    <span aria-hidden="true">×</span>
	              	</button>
	            </div>
	            <div class="modal-body">
	            	<h4>Esta seguro de eliminar este editorial?....!</h4>
	            </div>
	            <div class="modal-footer justify-content-between">
	              	<button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
	              	<button type="button" class="btn btn-outline-light" id="btnelimeditor" data-idedit=''>Eliminar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<section id="s-cargado" class="content pt-2">
		<div id="divcard-editor" class="card bg-light text-dark">
			<div class="card-header p-2">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-editorial" data-toggle="tab"><b><i class="fas fa-search mr-1"></i>Búsqueda</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-editorial" data-toggle="tab"><b><i class="fas fa-book-open mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
	      	<div class="card-body p-2">
	      		<div class="tab-content">
	      			<div class="tab-pane" id="registrar-editorial">
	      				<div class="alert alert-dark alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si la EDITORIAL no ha sido registrada anteriormente
							<button type="button" class="close" data-dismiss="alert">×</button>
						</div>
						<form class="form-neo" id="frm_editorial" action="<?php echo $vbaseurl ?>editorial/fn_insert_editorial" method="post" accept-charset='utf-8'>
							<b class="margin-top-10px text-danger"><i class="fas fa-book"></i> Editorial</b>
							<div class="row mt-2">
								<div class="form-group has-float-label col-12 col-sm-8">
									<input type="hidden" name="fictxtaccion" id="fictxtaccion" value="INSERTAR">
									<input data-currentvalue='' class="form-control text-uppercase" id="fictxtnomedit" name="fictxtnomedit" type="text" placeholder="Nombre Editorial" />
									<label for="fictxtnomedit">Nombre Editorial</label>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary float-left" id="btn_editorial"><i class="fas fa-save"></i> Registrar</button>
								</div>
							</div>
							<div class="row mt-1">
					        	<div class="col-6">
					        		<div id="divmsgeditorial" class="float-left">
										
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="active tab-pane" id="search-editorial">
						<div class="row mt-2">
							<div class="form-group has-float-label col-md-6 col-sm-8">
								<input type="text" name="fictxtbuscar" id="fictxtbuscar" class="form-control float-right" placeholder="Nombre editorial">
								<label for="fictxtbuscar">Nombre editorial</label>
							</div>
							<div class="col-md-2 col-sm-4">
					        	<button class="btn btn-block btn-info" type="button" id="btn_busca_ed">
					        		<i class="fas fa-search"></i>
					        	</button>
					      	</div>
						</div>
						<div class="card-body no-padding">
				            <div class="row">
				                <div class="col-12 py-1" id="divdata-editorial">
				            	    <div class="card">
				                	    <div class="card-body">
				                      		<b class="text-danger">Utiliza el cuadro de búsqueda ubicado arriba para encontrar el historial existente de los editoriales</b>
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
	$('#frm_editorial').submit(function() {
	    $('#frm_editorial input,select').removeClass('is-invalid');
	    $('#frm_editorial .invalid-feedback').remove();
	    $('#divcard-editor').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divcard-editor #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                /*var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgeditorial').html(msgf);*/
	                Swal.fire({
	                    title: e.msg,
	                    // text: "Por favor Agregue Ejemplares!",
	                    type: 'success',
	                }).then((result) => {
	                  if (result.value) {
	                  	$("#fictxtnomedit").val("");
	                    //location.reload();
	                  }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard-editor #divoverlay').remove();
	            $('#divmsgeditorial').show();
	            $('#divmsgeditorial').html(msgf);
	        }
	    });
	    return false;
	});

	$('#fictxtbuscar').keyup(function(event) {
		var neditor = $('#fictxtbuscar').val();

		var keycode = event.keyCode || event.which;
	    if(keycode == '13') {       
	         search_editorial(neditor);
	    }
	});
	$('#btn_busca_ed').click(function(event) {
		var neditor = $('#fictxtbuscar').val();
		search_editorial(neditor);
	});
function search_editorial(nomed){
    $('#divcard-editor').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'editorial/search_editorial',
            type: 'post',
            dataType: 'json',
            data: {txtnom : nomed},
            success: function(e) {
                if (e.status == true) {
                    $('#divdata-editorial').html(e.datos);
                } else {
                	
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divdata-editorial').html(msgf);
                }

                $('#divcard-editor #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard-editor #divoverlay').remove();
                $('#divmsgeditorial').html(msgf);
            },
        });
}
function viewupdatedit(icod){
 	$('#divcard-editor').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
 	$("#diveditoup").html("");
	  	$.ajax({
	      	url: base_url + "editorial/vwmostrar_editorxcodigo",
	      	type: 'post',
	     	dataType: "json",
	      	data: {txtcodedi: icod},
	      	success: function(e) {
	        	$('#divcard-editor #divoverlay').remove();
	        	$("#diveditoup").html(e.editoup);
	        	$("#modupdatedito").modal("show");
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception, 'div');
	          	$('#divcard-editor #divoverlay').remove();
	          	$("#modupdatedito modal-body").html(msgf);
	      	} 
	  	});
  	return false;
}

$('#lbtn_guardar').click(function() {
	$('#frm_editorial_edit input,select').removeClass('is-invalid');
    $('#frm_editorial_edit .invalid-feedback').remove();
    $('#divmodalupd').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'editorial/fn_insert_editorial',
        type: 'post',
        dataType: 'json',
        data: $('#frm_editorial_edit').serialize(),
        success: function(e) {
            $('#divmodalupd #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                // $('#divmsgeditorialed').html(msgf);
                $('#modupdatedito').modal('hide');
                Swal.fire({
                    title: e.msg,
                    // text: "Por favor Agregue Ejemplares!",
                    type: 'success',
                }).then((result) => {
                  if (result.value) {
                    //location.reload();
                    var neditor = $('#fictxtbuscar').val();
					search_editorial(neditor);
                  }
                })
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodalupd #divoverlay').remove();
            $('#divmsgeditorialed').show();
            $('#divmsgeditorialed').html(msgf);
        }
    });
    return false;
});
$('#modal-danger-editor').on('show.bs.modal', function (e) {
    var rel=$(e.relatedTarget);
    $("#btnelimeditor").data('idedit', rel.data("idedit"));
});
$('#btnelimeditor').click(function() {
    var codigo=$(this).data("idedit");
    var trow=$(this).closest('.rowcolor');
    $.ajax({
        url: base_url + 'editorial/fneliminar_editorial',
        type: 'post',
        dataType: 'json',
        data: {ideditor:codigo},
        success: function(e) {

            if (e.status == false) {
                $('#divmsgeditorial').html('<span class="text-danger"><i class="fa fa-close"></i> No se pudo eliminar</span>');
            } else {
                $('#btnelimeditor').prop('disabled', true);
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                // $('#divmsgeditorial').html(msgf);
                $('#modal-danger-editor').modal('hide');
                Swal.fire({
                    title: e.msg,
                    // text: "Por favor Agregue Ejemplares!",
                    type: 'success',
                }).then((result) => {
                  if (result.value) {
                    trow.remove();
                    // search_editorial($('#fictxtbuscar').val());
                  }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard-campania #divoverlay').remove();
            $('#divmsgeditorial').show();
            $('#divmsgeditorial').html(msgf);
        }
    });
});
</script>
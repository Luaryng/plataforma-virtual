<?php 
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
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
		<div id="divcard-historial" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-search mr-1"></i> Buscar Libro</h3>
		    </div>
	      	<div class="card-body">
	      		<div class="row">
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
			    	
			    <div class="row mt-3">
			    	<div id="divhistorial_libros" class="no-padding col-sm-12">
			    		<h4 class="ml-3">---- INGRESA NOMBRE DEL LIBRO ----</h4>
			    	</div>
			    </div>
	      	</div>
	    </div>
	</section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
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
    $('#divcard-historial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
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

                $('#divcard-historial #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard-historial #divoverlay').remove();
                $('#divhistorial_libros').html(msgf);
            },
        });
}

function viewupdatelib(icod){
 	$('#divcard-historial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
 	$("#divlibrosup").html("");
	  	$.ajax({
	      	url: base_url + "biblioteca/vwmostrar_librosxcodigo",
	      	type: 'post',
	     	dataType: "json",
	      	data: {txtcodib: icod},
	      	success: function(e) {
	        	$('#divcard-historial #divoverlay').remove();
	        	$("#divlibrosup").html(e.libupt);
	        	$("#modupdatelib").modal("show");
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception, 'div');
	          	$('#divcard-historial #divoverlay').remove();
	          	$("#modupdatelib modal-body").html(msgf);
	      	} 
	  	});
  	return false;
}

$('#lbtn-guardar').click(function() {
	$('#frm_libro input,select').removeClass('is-invalid');
    $('#frm_libro .invalid-feedback').remove();
    $('#divmodalupd').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
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

<?php 
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
	<div class="modal fade" id="modal_prestamos" tabindex="-1" role="dialog" aria-labelledby="modal_prestamos" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      		<div class="modal-content" id="divmodalupd">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle">PRESTAMOS</h5>
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
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_devolucion" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-book mr-1"></i> Devolucion de Libros</h3>
		    </div>
	      	<div class="card-body">
				<b class="margin-top-10px text-danger"><i class="fas fa-user"></i> Alumno</b>
				<div class="row mt-2">
					<div class="form-group has-float-label col-md-4 col-sm-4">
			        	<input class="form-control text-uppercase" type="text" placeholder="Carnet" name="fictxtcarnedev" id="fictxtcarnedev">
			        	<label for="fictxtcarnedev">Carnet</label>
			      	</div>
			      	<div class="col-md-2 col-sm-2">
			        	<button class="btn btn-block btn-info" type="button" id="btn_alumsearchdev">
			        		<i class="fas fa-search"></i>
			        	</button>
			      	</div>
				</div>
				<div class="row mt-3" id="divdatospres">
					<div class="form-group col-md-9 col-sm-9">
						<span id="fictxtnombres" class="form-control bg-light text-center"></span>
					</div>
					<div class="col-md-3 col-sm-3">
						<button class="btn btn-info d-none" id="btn_ver" data-cart=''><span class="fas fa-eye"></span> Ver Historial</button>
					</div>
				</div>
	      	</div>
	    </div>
	</section>
</div>

<script type="text/javascript">
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
    $('#divcard_devolucion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'prestamos/fn_get_alumnoxprestamo',
        type: 'post',
        dataType: 'json',
        data: {txtcardev:carne},
        success: function(e) {
            $('#divcard_devolucion #divoverlay').remove();
            $('#divdatospres').show();
            if (e.status == false) {
            	$('#fictxtnombres').html(e.msg);
            	$('#btn_ver').addClass('d-none');
            } else {
               if (e.vdata['idpersona'] == '0') {
                    $('#fictxtnombres').html('ALUMNO NO ENCONTRADO');
                    $('#btn_ver').addClass('d-none');
                } 
                else {
                    $('#fictxtnombres').html(e.vdata['paterno'] + ' ' + e.vdata['materno'] + ' ' + e.vdata['nombres']);
                    $('#btn_ver').removeClass('d-none');
                    $("#btn_ver").data('cart', e.vdata['carnet']);
                    
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard_devolucion #divoverlay').remove();
            $('#divmsgprestamo').show();
            $('#divmsgprestamo').html(msgf);
        }
    });
}
$('#btn_ver').click(function(event) {
	var carnet=$(this).data("cart");
	$('#divcard_devolucion').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
 	$("#divprestamosup").html("");
	  	$.ajax({
	      	url: base_url + "prestamos/vwmostrar_prestamosxalumno",
	      	type: 'post',
	     	dataType: "json",
	      	data: {txtcarnet: carnet},
	      	success: function(e) {
	        	$('#divcard_devolucion #divoverlay').remove();
	        	$("#divprestamosup").html(e.ejmuprs);
	        	$("#modal_prestamos").modal("show");
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception,'div' );
	          	$('#divcard_devolucion #divoverlay').remove();
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
    $('#modal_devolver').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
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
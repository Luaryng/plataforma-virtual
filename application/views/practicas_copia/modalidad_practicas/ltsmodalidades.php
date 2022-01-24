<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">

	<div class="modal fade" id="modaddmodalidad" tabindex="-1" role="dialog" aria-labelledby="modaddmodalidad" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlemodalidad">AGREGAR MODALIDAD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addmodalidad" action="<?php echo $vbaseurl ?>practicas_modalidad/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-12">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                                <input type="text" name="fictxtnombre" id="fictxtnombre" placeholder="Nombre modalidad" class="form-control form-control-sm">
                                <label for="fictxtnombre">Nombre modalidad</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Modalidades Prácticas</h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content">
  		<div id="divcard_modalidad" class="card">
  			<div class="card-header">
  				<h3 class="card-title"><i class="fas fa-list-ul"></i> Lista de modalidades</h3>
  				<div class="card-tools">
  					<button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modaddmodalidad"><i class="fas fa-plus"></i> Agregar</button>
  				</div>
  			</div>
  			<div class="card-body">

	  			<small id="fmt-conteo" class="form-text text-primary">
            
            	</small>
  				<div class="col-12 px-0 pt-2">
	              	<div class="btable">
		                <div class="thead col-12  d-none d-md-block">
		                  	<div class="row">
			                    
		                    	<div class="col-md-1 td">NRO</div>
		                    	
			                    <div class="col-md-10 td">
			                      	CÓD / MODALIDAD
			                    </div>
			                    <div class="col-md-1">
			                      	<div class="row">
				                        <div class="col-md-12 td text-center">
				                          	
				                        </div>
			                      	</div>
			                    </div>
		                  	</div>
		                </div>
		                <div id="div_filtro_modalidad" class="tbody col-12">
		                  
		                </div>
	              	</div>
	            </div>
  			</div>
  		</div>
  	</section>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        filtrar_modalidad('');
    });

    function filtrar_modalidad(nommodalidad){
    	$('#divcard_modalidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    	$.ajax({
            url: base_url + 'practicas_modalidad/fn_filtro_modalidades',
            type: 'post',
            dataType: 'json',
            data: {nommodalidad : nommodalidad},
            success: function(e) {
                if (e.status == true) {
                    $('#div_filtro_modalidad').html("");
                    var nro=0;
                    var tabla="";
                    var codbase64 = "";
                    if (e.datos.length !== 0) {
                        
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codbase64 = 'viewupdatemodal("'+ val['codigo_64']+'")';

                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-modalidad='"+val['nombre']+"'>"+
                                    "<div class='col-2 col-md-1 td'>"+nro+"</div>"+
                                    "<div class='col-10 col-md-10 td'>("+ val['codigo'] + ") " +val['nombre']+"</div>"+
                                    "<div class='col-12 col-md-1 td text-center'>"+
                                        "<div class='btn-group'>"+
                                            "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                "<i class='fas fa-cog'></i>"+
                                            "</a>"+
                                            "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"'>"+
                                                    "<i class='fas fa-edit mr-1'></i> Editar"+
                                                "</a>"+
                                                    "<a class='dropdown-item text-danger deletemodalidad' href='#' title='Eliminar' idmodalidad='"+val['codigo_64']+"'>"+
                                                        "<i class='fas fa-trash mr-1'></i> Eliminar"+
                                                    "</a>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                                    
                        })
                        $('#fmt-conteo').html(nro + ' Datos encontrados');
                    } else {
                        $('#fmt-conteo').html('No se encontraron resultados');
                    }

                    $('#div_filtro_modalidad').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#div_filtro_modalidad').html(msgf);
                }

                $('#divcard_modalidad #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_modalidad #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
    }

	$('#lbtn_guardar').click(function() {
        $('#frm_addmodalidad input,select').removeClass('is-invalid');
        $('#frm_addmodalidad .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addmodalidad').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addmodalidad').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddmodalidad').modal('hide');
                    
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            filtrar_modalidad('');
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

    $("#modaddmodalidad").on('hidden.bs.modal', function () {
        $('#frm_addmodalidad')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#titlemodalidad').html("AGREGAR MODALIDAD");
        $('#frm_addmodalidad input,select').removeClass('is-invalid');
        $('#frm_addmodalidad .invalid-feedback').remove();
    });

    function viewupdatemodal(codigo) {
    	$('#divcard_modalidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "practicas_modalidad/vwmostrar_modalidadxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_modalidad #divoverlay').remove();
                
                $("#fictxtcodigo").val(base64url_encode(e.vdata['codigo']));
                $("#fictxtnombre").val(e.vdata['nombre']);
                $('#titlemodalidad').html("EDITAR MODALIDAD");

                $("#modaddmodalidad").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_modalidad #divoverlay').remove();
                $("#modaddmodalidad modal-body").html(msgf);
            } 
        });
        return false;
    }

    $(document).on("click", ".deletemodalidad", function(){
		var idmodalidad = $(this).attr("idmodalidad");
		var modalidad = $(this).closest('.rowcolor').data('modalidad');  
  		
		Swal.fire({
			title: '¿Está seguro de eliminar la modalidad '+modalidad+'?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar!'
		}).then(function(result){
			if(result.value){
				$('#divcard_modalidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("idmodalidad", idmodalidad);
                
                $.ajax({
                  	url: base_url + "practicas_modalidad/fneliminar_modalidad",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divcard_modalidad #divoverlay').remove();
                    	
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
	                               filtrar_modalidad('');
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divcard_modalidad #divoverlay').remove();
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
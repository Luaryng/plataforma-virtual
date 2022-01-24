<?php $vbaseurl=base_url() ?>
<div class="content-wrapper">

	<div class="modal fade" id="modaddlengua" tabindex="-1" role="dialog" aria-labelledby="modaddlengua" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlelengua">AGREGAR LENGUA ORIGINARIA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addlengua" action="<?php echo $vbaseurl ?>lengua_originaria/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-12">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                                <input type="text" name="fictxtnombre" autocomplete="off" id="fictxtnombre" placeholder="Nombre" class="form-control form-control-sm">
                                <label for="fictxtnombre">Nombre</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

	<section class="content-header">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-sm-6">
          			<h1>Lenguas Originarias</h1>
        		</div>
      		</div>
    	</div>
  	</section>
  	<section id="s-cargado" class="content">
  		<div id="divcard_filtro" class="card">
  			<div class="card-header">
  				<h3 class="card-title"><i class="fas fa-list-ul"></i> Lista de Lenguas Originarias</h3>
  				<div class="card-tools">
                    <?php if (getPermitido("134")=='SI') { ?>
  					<button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modaddlengua"><i class="fas fa-plus"></i> Agregar</button>
                    <?php } ?>
  				</div>
  			</div>
  			<div class="card-body">
				<div class="row">
					<div class="form-group has-float-label col-12 col-sm-6 col-md-9">
	                	<input class="form-control text-uppercase" autocomplete="off" id="lng_nombre" name="lng_nombre" placeholder="Nombre" >
	                    <label for="lng_nombre"> Nombre
	                    </label>
	                </div>
	                <div class="col-6 col-sm-2 col-md-1">
	                	<button type="button" id="btn_filtrar" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
	              	</div>
				</div>

	  			<small id="fmt-conteo" class="form-text text-primary">
                    <?php 
                    if(count($lenguas) > 0){
                        echo count($lenguas)." Datos encontrados";
                    } else {
                        echo "No se encontraron resultados";
                    }

                    ?> 
            	</small>
  				<div class="col-12 px-0 pt-2">
	              	<div class="btable">
		                <div class="thead col-12  d-none d-md-block">
		                  	<div class="row">
			                    <div class="col-md-1 td">N°</div>
		                    	<div class="col-md-10 td">NOMBRE</div>
			                    <div class="col-md-1">
			                      	<div class="row">
				                        <div class="col-md-12 td text-center">
				                          	
				                        </div>
			                      	</div>
			                    </div>
		                  	</div>
		                </div>
		                <div id="div_filtro_lengua" class="tbody col-12">
                            <?php 
                            $nro = 0;
                            $btnupdate = "";
                            $btndelete = "";
                            foreach ($lenguas as $key => $lg) {
                                $nro++;
                                $codigo64 = base64url_encode($lg->codigo);
                                if (getPermitido("135")=='SI') {
                                    $btnupdate = "<a class='dropdown-item' href='#' title='Editar' onclick='viewupdatelengua(`$codigo64`)'>
                                                <i class='fas fa-edit mr-1'></i> Editar
                                            </a>";
                                }
                                if (getPermitido("136")=='SI') {
                                    $btndelete = "<a class='dropdown-item text-danger deletelengua' href='#' title='Eliminar' idlengua='$codigo64'>
                                                <i class='fas fa-trash mr-1'></i> Eliminar
                                            </a>";
                                }
                            echo "<div class='row rowcolor cfila' data-lengua='$lg->nombre'>
                                <div class='col-2 col-md-1 td'>$nro</div>
                                <div class='col-8 col-md-10 td'>$lg->nombre</div>
                                <div class='col-2 col-md-1 td text-center'>
                                    <div class='btn-group'>
                                        <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            <i class='fas fa-cog'></i>
                                        </a>
                                        <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                                            $btnupdate
                                            $btndelete
                                        </div>
                                    </div>
                                </div>
                            </div>";
                            } ?>
		                </div>
	              	</div>
	            </div>
  			</div>
  		</div>
  	</section>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000,
          // timerProgressBar: true,
        })

        Toast.fire({
          type: 'info',
          icon: 'info',
          title: 'Aviso: Antes de agregar una lengua originaria, verifica si no ha sido registrado anteriormente'
        })

    });

    $('#lng_nombre').keyup(function(event) {
		var campo = $(this).val();

		var keycode = event.keyCode || event.which;
	    if(keycode == '13') {       
	         filtrar_lenguas(campo);
	    }
	});

    $('#btn_filtrar').click(function() {
    	var campo = $('#lng_nombre').val();
    	filtrar_lenguas(campo);
    });

    function filtrar_lenguas(nomlengua){
    	$('#divcard_filtro').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    	$.ajax({
            url: base_url + 'lengua_originaria/fn_search_lenguas',
            type: 'post',
            dataType: 'json',
            data: {nomlengua : nomlengua},
            success: function(e) {
                if (e.status == true) {
                    $('#div_filtro_lengua').html("");
                    var nro=0;
                    var tabla="";
                    var codigo64 = "";
                    var codbase64 = "";
                    var btneditar = "";
                    var btneliminar = "";
                    if (e.datos.length !== 0) {
                        
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codigo64 = base64url_encode(val['codigo']);
                            codbase64 = 'viewupdatelengua("'+codigo64+'")';
                            if ('<?php echo getPermitido("135") ?>' == 'SI') {
                                btneditar = "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"'>"+
                                                    "<i class='fas fa-edit mr-1'></i> Editar"+
                                                "</a>";
                            }

                            if ('<?php echo getPermitido("136") ?>' == 'SI') {
                                btneliminar = "<a class='dropdown-item text-danger deletelengua' href='#' title='Eliminar' idlengua='"+codigo64+"'>"+
                                                    "<i class='fas fa-trash mr-1'></i> Eliminar"+
                                                "</a>";
                            }
                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-lengua='"+val['nombre']+"'>"+
                                    "<div class='col-2 col-md-1 td'>"+nro+"</div>"+
                                    "<div class='col-8 col-md-10 td'>"+val['nombre']+"</div>"+
                                    "<div class='col-2 col-md-1 td text-center'>"+
                                        "<div class='btn-group'>"+
                                            "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                "<i class='fas fa-cog'></i>"+
                                            "</a>"+
                                            "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                btneditar+
                                                btneliminar+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                                    
                        })
                        $('#fmt-conteo').html(nro + ' Datos encontrados');
                    } else {
                        $('#fmt-conteo').html('No se encontraron resultados');
                    }

                    $('#div_filtro_lengua').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#div_filtro_lengua').html(msgf);
                }

                $('#divcard_filtro #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_filtro #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
    }

	$('#lbtn_guardar').click(function() {
        $('#frm_addlengua input,select').removeClass('is-invalid');
        $('#frm_addlengua .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addlengua').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addlengua').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddlengua').modal('hide');
                    var campo = "";
                    if (e.accion == "EDITAR") {
                    	campo = $('#lng_nombre').val();
                    } else {
                    	campo = "";
                        $('#lng_nombre').val("");
                    }
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            filtrar_lenguas(campo);
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

    $("#modaddlengua").on('hidden.bs.modal', function () {
        $('#frm_addlengua')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#titlelengua').html("AGREGAR LENGUA ORIGINARIA");
    });

    function viewupdatelengua(codigo) {
    	$('#divcard_filtro').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "lengua_originaria/vwmostrar_lenguaxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_filtro #divoverlay').remove();
                
                $("#fictxtcodigo").val(base64url_encode(e.vdata['codigo']));
                $("#fictxtnombre").val(e.vdata['nombre']);

                $('#titlelengua').html("EDITAR LENGUA ORIGINARIA");

                $("#modaddlengua").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_filtro #divoverlay').remove();
                $("#modaddlengua modal-body").html(msgf);
            } 
        });
        return false;
    }

    $(document).on("click", ".deletelengua", function(){
		var idlengua = $(this).attr("idlengua");
		var lengua = $(this).closest('.rowcolor').data('lengua');  
  		
		Swal.fire({
			title: '¿Está seguro de eliminar la lengua originaria '+lengua+'?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar!'
		}).then(function(result){
			if(result.value){
				$('#divcard_filtro').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("idlengua", idlengua);
                
                $.ajax({
                  	url: base_url + "lengua_originaria/fneliminar_lengua",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divcard_filtro #divoverlay').remove();
                    	var campo = $('#lng_nombre').val();
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
	                               filtrar_lenguas(campo);
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divcard_filtro #divoverlay').remove();
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
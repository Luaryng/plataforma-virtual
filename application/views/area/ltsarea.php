<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

    <div class="modal fade" id="modaddarea" tabindex="-1" role="dialog" aria-labelledby="modaddarea" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlearea">AGREGAR ÁREA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addarea" action="<?php echo $vbaseurl ?>area/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-8">
                                <input type="hidden" id="fictxtaccion" name="fictxtaccion" value="INSERTAR">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="">
                                <input type="text" name="fictxtnombre" id="fictxtnombre" value="" placeholder="Nombre Área" class="form-control">
                                <label for="fictxtnombre">Nombre Área</label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="checkestado">Activo:</label>
                                <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div> 
                        <div class="row">
                            <div class="form-group has-float-label col-12">
                                <select name="fictxtencarg" id="fictxtencarg" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($docentes as $key => $value) {
                                            echo "<option value='$value->coddocente'>$value->nombres</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtencarg">Encargado</label>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="fictxtemail" id="fictxtemail" value="" placeholder="Email" class="form-control">
                                <label for="fictxtemail">Email</label>
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
          			<h1>Área
          			<small>Panel</small></h1>
        		</div>
        
      		</div>
    	</div>
  	</section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_area" class="card">
			<div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de áreas</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#modaddarea"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
		    <div class="card-body">
                <small id="fmt_conteo" class="form-text text-primary">
            
                </small>
                <div class="col-12 py-1">
                    <div class="btable">
                        <div class="thead col-12  d-none d-md-block">
                            <div class="row">
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td'>N°</div>
                                        <div class='col-10 col-md-10 td'>NOMBRE</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-5'>
                                    <div class='row'>
                                        <div class='col-3 col-md-3 td'>ESTADO</div>
                                        <div class='col-9 col-md-9 td'>ENCARGADO</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-2 text-center'>
                                    <div class='row'>
                                        <div class='col-12 col-md-12 td'>
                                            <span>ACCIONES</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tbody col-12" id="divcard_data_area">
                            
                        </div>
                    </div>
                </div>
		    </div>
		</div>
	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
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
          title: 'Aviso: Antes de agregar un área, verifica si no ha sido registrado anteriormente'
        })

        filtro_areas('');
    });

    $("#modaddarea").on('hidden.bs.modal', function () {
        $('#frm_addarea')[0].reset();
        $("#fictxtcodigo").val("");
        $('#fictxtaccion').val("INSERTAR");
        $('#titlearea').html("AGREGAR ÁREA");
    });

    $('#lbtn_guardar').click(function() {
        $('#frm_addarea input,select').removeClass('is-invalid');
        $('#frm_addarea .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addarea').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addarea').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddarea').modal('hide');
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            filtro_areas('');
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

    function viewupdatarea(codigo){
        $('#divcard_area').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "area/vwmostrar_areaxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_area #divoverlay').remove();
                $('#fictxtaccion').val("EDITAR");
                $("#fictxtcodigo").val(e.areaup['codigo']);
                $("#fictxtnombre").val(e.areaup['nombre']);
                if (e.areaup['estado'] == 'SI') {
                    $("#checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#checkestado").bootstrapToggle('off');
                }

                $('#fictxtencarg').val(e.areaup['encargado']);

                $("#fictxtemail").val(e.areaup['correo']);
                $('#titlearea').html("EDITAR ÁREA");

                $("#modaddarea").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_area #divoverlay').remove();
                $("#modaddarea modal-body").html(msgf);
            } 
        });
        return false;
    }

    $('#lbtn_editar').click(function(event) {
        $('#frm_updatearea input,select').removeClass('is-invalid');
        $('#frm_updatearea .invalid-feedback').remove();
        $('#divmodalupd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_updatearea').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_updatearea').serialize(),
            success: function(e) {
                $('#divmodalupd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modupdarea').modal('hide');
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            filtro_areas('');
                        }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodalupd #divoverlay').remove();
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

	$(document).on("click", ".deletearea", function(){
		var idarea = $(this).attr("idarea");
		var area=$(this).closest('.rowcolor').data('area');  
  		
		Swal.fire({
			title: '¿Está seguro de eliminar el área '+area+'?',
			text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, eliminar!'
		}).then(function(result){
			if(result.value){
				$('#divcard_area').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
				var datos = new FormData();
                datos.append("idarea", idarea);
                
                $.ajax({
                  	url: base_url + "area/fneliminar_area",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divcard_area #divoverlay').remove();
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
	                               filtro_areas('');
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divcard_area #divoverlay').remove();
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

    function filtro_areas(nomarea) {
        $('#divcard_area').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'area/search_areas',
            type: 'post',
            dataType: 'json',
            data: {nomarea : nomarea},
            success: function(e) {
                if (e.status == true) {
                    $('#divcard_data_area').html("");
                    var nro=0;
                    var tabla="";
                    var activo = "";
                    var encargado = "";
                    var codbase64 = "";
                    if (e.datos.length !== 0) {
                        $('#fmt_conteo').html('');
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codbase64 = 'viewupdatarea("'+val['codigo64']+'")';

                            if (val['estado']==="SI"){
                                activo = "<span class='badge bg-success p-2'> ACTIVO </span>";
                            } else {
                                activo = "<span class='badge bg-danger p-2'> INACTIVO </span>";
                            }

                            if (val['nombres'] !== null && val['nombres'] !== "") {
                                encargado = val['nombres'];
                            } else {
                                encargado = "SIN ENCARGADO";
                            }

                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-area='"+val['nombre']+"'>"+
                                    "<div class='col-12 col-md-5'>"+
                                        "<div class='row'>"+
                                            "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                            "<div class='col-10 col-md-10 td'>"+val['nombre']+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-5'>"+
                                        "<div class='row'>"+
                                            "<div class='col-3 col-md-3 td'>"+activo+"</div>"+
                                            "<div class='col-9 col-md-9 td'>"+encargado+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-2 text-center'>"+
                                        "<div class='row'>"+
                                            "<div class='col-12 col-sm-12 col-md-12 td'>"+
                                                "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                    "<div class='btn-group'>"+
                                                        "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                            "<i class='fas fa-cog'></i>"+
                                                        "</a>"+
                                                        "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                            "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"'>"+
                                                                "<i class='fas fa-edit mr-1'></i> Editar"+
                                                            "</a>"+
                                                                "<a class='dropdown-item text-danger deletearea' href='#' title='Eliminar' idarea='"+val['codigo64']+"'>"+
                                                                    "<i class='fas fa-trash mr-1'></i> Eliminar"+
                                                                "</a>"+
                                                        "</div>"+
                                                    "</div>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                                    
                        })
                    } else {
                        $('#fmt_conteo').html('No se encontraron resultados');
                    }

                    $('#divcard_data_area').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divcard_data_area').html(msgf);
                }

                $('#divcard_area #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_area #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
    }
</script>
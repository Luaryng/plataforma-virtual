<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

    <div class="modal fade" id="modupcarrera" aria-modal="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="divmodcarrera">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Carrera</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="msgcuerpo">
                    <form id="frm_updacarrera" action="<?php echo $vbaseurl ?>carrera/fn_insert_update" method="post" accept-charset='utf-8'>
                            <b class="text-danger"><i class="fas fa-graduation-cap"></i> Carrera</b>
                            <div class="row mt-2">
                                <div class="form-group has-float-label col-12 col-sm-3">
                                    <input type="hidden" name="fictxtcodantig" id="fictxtcodantig" value="">
                                    <input data-currentvalue='' class="form-control" id="fictxtcodigo" name="fictxtcodigo" type="text" placeholder="Codigo" />
                                    <label for="fictxtcodigo">Codigo Carrera</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-sm-9">
                                    <input type="hidden" name="fictxtaccion" id="fictxtaccion" value="EDITAR">
                                    <input data-currentvalue='' class="form-control" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre Carrera" />
                                    <label for="fictxtnombre">Nombre Carrera</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-sm-3">
                                    <input data-currentvalue='' class="form-control" id="fictxtsigla" name="fictxtsigla" type="text" placeholder="Sigla Carrera" />
                                    <label for="fictxtsigla">Sigla Carrera</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-sm-9">
                                    <input data-currentvalue='' class="form-control" id="fictxtabrev" name="fictxtabrev" type="text" placeholder="Abreviatura Carrera" />
                                    <label for="fictxtabrev">Abreviatura Carrera</label>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="form-group col-6 col-md-6">
                                    <label for="checkabierta">Abierta:</label>
                                    <input  id="checkabierta" name="checkabierta" class="checkabierta" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                </div>
                                <div class="form-group col-6 col-md-6">
                                    <label for="checkestado">Activo:</label>
                                    <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                </div>
                                <div class="form-group has-float-label col-12 col-sm-12">
                                    <input data-currentvalue='' class="form-control" id="fictxtnivelf" name="fictxtnivelf" type="text" placeholder="Nivel Formativo" value="PROFESIONAL TÉCNICO" />
                                    <label for="fictxtnivelf">Nivel Formativo</label>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div id="divmsgcarr" class="float-left">

                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn_updcarrera">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

	<section id="s-cargado" class="content pt-2">
		<div id="divcard_carrera" class="card text-dark">
			<div class="card-header">
                <ul class="nav nav-pills">
                	<li class="nav-item"><a class="nav-link active" href="#search-carrera" data-toggle="tab"><b><i class="fas fa-list mr-1"></i>Datos</b></a></li>
                  	<li class="nav-item"><a class="nav-link" href="#registrar-carrera" data-toggle="tab"><b><i class="fas fa-user-plus mr-1"></i>Registrar</b></a></li>
                </ul>
            </div>
		    <div class="card-body">
		    	<div class="tab-content">
			    	<div class="tab-pane" id="registrar-carrera">
	      				<div class="alert alert-secondary alert-dismissible fade show bordered">
							<strong>Aviso:</strong> Antes de ingresar los datos, verifica si la CARRERA no ha sido registrada anteriormente
						</div>
                        <div class="border border-secondary rounded p-2">
                            <form class="" id="frm_addcarrera" action="<?php echo $vbaseurl ?>carrera/fn_insert_update" method="post" accept-charset='utf-8'>
                                <b class="text-danger"><i class="fas fa-graduation-cap"></i> Carrera</b>
                                <div class="row mt-2">
                                    <div class="form-group has-float-label col-12 col-sm-2">
                                        <input class="form-control" id="fictxtcodigo" name="fictxtcodigo" type="text" placeholder="Codigo" />
                                        <label for="fictxtcodigo">Codigo</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-sm-8">
                                        <input type="hidden" name="fictxtaccion" id="fictxtaccion" value="INSERTAR">
                                        <input class="form-control" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre Carrera" />
                                        <label for="fictxtnombre">Nombre Carrera</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-sm-2">
                                        <input class="form-control" id="fictxtsigla" name="fictxtsigla" type="text" placeholder="Sigla Carrera" />
                                        <label for="fictxtsigla">Sigla Carrera</label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group has-float-label col-12 col-sm-12">
                                        <input class="form-control" id="fictxtabrev" name="fictxtabrev" type="text" placeholder="Abreviatura Carrera" />
                                        <label for="fictxtabrev">Abreviatura Carrera</label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group col-md-2">
                                        <label for="checkabierta">Abierta:</label>
                                        <input  id="checkabierta" name="checkabierta" class="checkabierta" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="checkestado">Activo:</label>
                                        <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                    </div>
                                    <div class="form-group has-float-label col-12 col-sm-8">
                                        <input class="form-control" id="fictxtnivelf" name="fictxtnivelf" type="text" placeholder="Nivel Formativo" value="PROFESIONAL TÉCNICO" />
                                        <label for="fictxtnivelf">Nivel Formativo</label>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div id="divmsgcarr" class="float-left">

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary btn-md float-right" id="btn_add_carr"><i class="fas fa-save"></i> Registrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    <div class="active tab-pane" id="search-carrera">
                        <small id="fmt_conteo" class="form-text text-primary">
            
                        </small>
                        <div class="col-12 py-1">
                            <div class="btable">
                                <div class="thead col-12  d-none d-md-block">
                                    <div class="row">
                                        <div class='col-12 col-md-4'>
                                            <div class='row'>
                                                <div class='col-1 col-md-2 td'>N°</div>
                                                <div class='col-3 col-md-7 td'>NOMBRE</div>
                                                <div class='col-3 col-md-3 td text-center'>SIGLA</div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-4'>
                                            <div class='row'>
                                                <div class='col-9 col-md-6 td'>ABREVIATURA</div>
                                                <div class='col-9 col-md-3 td'>ABIERTA</div>
                                                <div class='col-9 col-md-3 td'>ACTIVA</div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-4 text-center'>
                                            <div class='row'>
                                                <div class='col-sm-3 col-md-8 td'>
                                                    <span>N.FORMATIVO</span>
                                                </div>
                                                <div class='col-sm-4 col-md-4 td'>
                                                    <span>ACCIONES</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tbody col-12" id="divcard_data_carrera">
                                    
                                </div>
                            </div>
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
          title: 'Aviso: Antes de agregar una carrera, verifica si no ha sido registrado anteriormente'
        })

        filtro_carreras('');
    });

    $('#frm_addcarrera').submit(function() {
        $('#frm_addcarrera input,select').removeClass('is-invalid');
        $('#frm_addcarrera .invalid-feedback').remove();
        $('#divcard_carrera').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $(this).attr("action"),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(e) {
                $('#divcard_carrera #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#frm_addcarrera #' + key).addClass('is-invalid');
                        $('#frm_addcarrera #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

                    Swal.fire({
                        title: 'Existen errores en los campos',
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {

                    // var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                    // $('#divmsgcarr').html(msgf);
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      if (result.value) {
                        $('#frm_addcarrera')[0].reset();
                        $('.nav-pills a[href="#search-carrera"]').tab('show');
                        filtro_carreras('');
                      }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard_carrera #divoverlay').remove();
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

    function viewupdatcarr(codigo) {
        $('#divcard_carrera').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "carrera/vwmostrar_carreraxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_carrera #divoverlay').remove();

                $("#modupcarrera").modal("show");
                
                $('#modupcarrera #fictxtcodantig').val(e.carrup['id']);

                $("#modupcarrera #fictxtcodigo").val(e.carrup['id']);

                $("#modupcarrera #fictxtnombre").val(e.carrup['nombre']);

                $("#modupcarrera #fictxtsigla").val(e.carrup['sigla']);

                $("#modupcarrera #fictxtabrev").val(e.carrup['abrev']);

                if (e.carrup['abierta'] == 'SI') {
                    $("#modupcarrera #checkabierta").bootstrapToggle('on');
                    
                } else {
                    $("#modupcarrera #checkabierta").bootstrapToggle('off');
                }

                if (e.carrup['activo'] == 'SI') {
                    $("#modupcarrera #checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#modupcarrera #checkestado").bootstrapToggle('off');
                }

                $('#modupcarrera #fictxtnivelf').val(e.carrup['nivel']);

            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_carrera #divoverlay').remove();
                $("#modupcarrera modal-body").html(msgf);
            } 
        });
        return false;
    }

    $('#btn_updcarrera').click(function(event) {
        $('#frm_updacarrera input,select').removeClass('is-invalid');
        $('#frm_updacarrera .invalid-feedback').remove();
        $('#divmodcarrera').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_updacarrera').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_updacarrera').serialize(),
            success: function(e) {
                $('#divmodcarrera #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#frm_updacarrera #' + key).addClass('is-invalid');
                        $('#frm_updacarrera #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

                    Swal.fire({
                        title: 'Existen errores en los campos',
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    $('#modupcarrera').modal('hide');
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      if (result.value) {
                        filtro_carreras('');
                      }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodcarrera #divoverlay').remove();
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

    $(document).on("click", ".deletecarrera", function(){
        var idcarrera = $(this).attr("idcarrera");
        var carrera=$(this).closest('.rowcolor').data('carrera');  
        Swal.fire({
            title: '¿Está seguro de eliminar la carrera '+carrera+'?',
            text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar carrera!'
        }).then(function(result){
            if(result.value){
                $('#divcard_carrera').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                var datos = new FormData();
                datos.append("idcarrera", idcarrera);
                
                $.ajax({
                    url: base_url + "carrera/fneliminar_carrera",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(e){
                        $('#divcard_carrera #divoverlay').remove();
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

                                  filtro_carreras();

                                }
                            })
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception,'text');
                        $('#divcard_carrera #divoverlay').remove();
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

    function filtro_carreras(nomcarrera) {
        $('#divcard_carrera').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'carrera/search_carrera',
            type: 'post',
            dataType: 'json',
            data: {nomcarrera : nomcarrera},
            success: function(e) {
                if (e.status == true) {
                    $('#divcard_data_carrera').html("");
                    var nro=0;
                    var tabla="";
                    var abierta = "";
                    var activo = "";
                    var codbase64 = "";
                    if (e.datos.length !== 0) {
                        $('#fmt_conteo').html('');
                        $.each(e.datos, function(index, val) {
                            nro++;
                            codbase64 = 'viewupdatcarr("'+val['codigo64']+'")';

                            if (val['activo']==="SI"){
                                activo = "<span class='badge bg-success p-2'> ACTIVO </span>";
                            } else {
                                activo = "<span class='badge bg-danger p-2'> INACTIVO </span>";
                            }

                            if (val['abierta'] === "SI") {
                                abierta = "<span class='badge bg-success p-2'> ACTIVA </span>";
                            } else {
                                abierta = "<span class='badge bg-danger p-2'> INACTIVA </span>";
                            }


                            tabla=tabla + 
                                "<div class='row rowcolor cfila' data-carrera='"+val['nombre']+"'>"+
                                    "<div class='col-12 col-md-4'>"+
                                        "<div class='row'>"+
                                            "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                            "<div class='col-8 col-md-7 td'>"+val['id']+" - "+val['nombre']+"</div>"+
                                            "<div class='col-2 col-md-3 td text-center '>"+val['sigla']+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-4'>"+
                                        "<div class='row'>"+
                                            "<div class='col-12 col-md-6 td'>"+val['abrev']+"</div>"+
                                            "<div class='col-6 col-md-3 td'>"+abierta+"</div>"+
                                            "<div class='col-6 col-md-3 td'>"+activo+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-4 text-center'>"+
                                        "<div class='row'>"+
                                            "<div class='col-9 col-sm-8 col-md-8 td'>"+
                                                "<span>"+val['nivel']+"</span>"+
                                            "</div>"+
                                            "<div class='col-4 col-sm-4 col-md-4 td'>"+
                                                "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                    "<div class='btn-group'>"+
                                                        "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                            "<i class='fas fa-cog'></i>"+
                                                        "</a>"+
                                                        "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                            "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"'>"+
                                                                "<i class='fas fa-edit mr-1'></i> Editar"+
                                                            "</a>"+
                                                                "<a class='dropdown-item text-danger deletecarrera' href='#' title='Eliminar' idcarrera='"+val['codigo64']+"'>"+
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

                    $('#divcard_data_carrera').html(tabla);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divcard_data_carrera').html(msgf);
                }

                $('#divcard_carrera #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_carrera #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
    }

</script>
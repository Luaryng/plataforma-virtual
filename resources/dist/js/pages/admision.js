
$('#frm_periodos').submit(function() {
    $('#frm_periodos input,select').removeClass('is-invalid');
    $('#frm_periodos .invalid-feedback').remove();
    $('#divcard_periodo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard_periodo #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
                Swal.fire({
                    title: 'Existen errores en los campos',
                    type: 'error',
                    icon: 'error',
                })

            } else {
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        $('#frm_periodos')[0].reset();
                        $('.nav-pills a[href="#search-periodo"]').tab('show');
                        search_periodo("");
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_periodo #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$('#modal-edit-per').on('show.bs.modal', function(e) {
    var rel=$(e.relatedTarget);
    var codigo = rel.data('codigo');
    var nombre = rel.data('nombre');
    var anio = rel.data('anio');
    var estado = rel.data('estado');

    $('#fictxtidpered').val(codigo);
    $('#fictxtperiodoed').val(nombre);
    $('#fictxtperanioed').val(anio);
    $('#fictxtestadoed').val(estado);
    $('#fictxtcodant').val(codigo);
});

$('#btnactper').click(function() {
    $('#frm_edit_periodo input,select').removeClass('is-invalid');
    $('#frm_edit_periodo .invalid-feedback').remove();
    $('#divmodalpered').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'periodo/fn_update_periodo',
        type: 'post',
        dataType: 'json',
        data: $('#frm_edit_periodo').serialize(),
        success: function(e) {
            $('#divmodalpered #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    title: 'Existen errores en los campos',
                    type: 'error',
                    icon: 'error',
                })
                
            } else {
                // $('#btnactper').prop('disabled', true);
                
                $('#modal-edit-per').modal('hide');
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                  if (result.value) {
                    search_periodo($('#fictxtbuscar').val());
                  }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodalpered #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$(document).on("click", ".deleteperiodo", function(){
    var idper = $(this).data("idpr");
    var datos = new FormData();
    $(".btn-group").find('.dropdown-toggle').attr("aria-expanded", "false");
    $(".acc_dropdown").removeClass('show');
    Swal.fire({
        title: '¿Está seguro de eliminar este periodo?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar periodo!'
    }).then(function(result){
        if(result.value){
            $('#divboxdatos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var datos = new FormData();
            datos.append("idperiodo", idper);
            
            $.ajax({
                url: base_url + 'periodo/fneliminarper',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(e){
                    $('#divboxdatos #divoverlay').remove();
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

                              search_periodo($('#fictxtbuscar').val());

                            }
                        })
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divboxdatos #divoverlay').remove();
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

$(document).on("click", ".updateactiv", function(){
    btn = $(this);
    idpr = btn.data('idpr');
    flat = btn.data('flat');
    act = btn.data('act');

    var estado = "desactivar";
    var titulo="¿Deseas desactivar las inscripciones para el periodo Seleccionado?";
    if (flat=="activarinscripcion"){
        titulo="¿Deseas activar las inscripciones para el periodo Seleccionado?";
        estado = "activar";
    }
    Swal.fire({
        title: titulo,
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, '+estado+'!'
    }).then(function(result){
        if(result.value){
            $('#divboxdatos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var datos = new FormData();
            datos.append("idperiodo", idpr);
            datos.append("activo", act);
            
            $.ajax({
                url: base_url + 'periodo/fn_update_status_inscripcion',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(e){
                    $('#divboxdatos #divoverlay').remove();
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

                              search_periodo($('#fictxtbuscar').val());

                            }
                        })
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: 'No se pudo actualizar',
                            type: "error",
                            icon: "error",
                            allowOutsideClick: false,
                            confirmButtonText: "¡Cerrar!"
                        });
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divboxdatos #divoverlay').remove();
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


$('#fictxtbuscar').keyup(function(event) {
    var nper = $('#fictxtbuscar').val();

    var keycode = event.keyCode || event.which;
    if(keycode == '13') {       
         search_periodo(nper);
    }
});

$('#btn_busca_per').click(function(event) {
    var nper = $('#fictxtbuscar').val();
    search_periodo(nper);
});

function search_periodo(nomper){
    $('#divcard_periodo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'periodo/search_periodo',
        type: 'post',
        dataType: 'json',
        data: {txtnom : nomper},
        success: function(e) {
            if (e.status == true) {
                $('#divcard_data_periodo').html("");
                var nro=0;
                var tabla="";
                var encargado = "";
                var vflat="";
                var vtitle="";
                var vicon="";
                var btncolor="";
                var accion= "";
                var estado="";
                var bgstatus = "";
                if (e.datos.length !== 0) {
                    $('#fmt_conteo').html('');
                    $.each(e.datos, function(index, val) {
                        nro++;
                        if (val['inscrip']==="SI"){
                            vflat="desactivarinscripcion";
                            vtitle="Desactivar";
                            vicon="fa fa-toggle-on";
                            btncolor="btn-success btn-sm";
                            accion= "NO";
                            estado="Habilitado";
                        } else {
                            vflat="activarinscripcion";
                            vtitle="Activar";
                            vicon="fa fa-toggle-off";
                            btncolor="btn-danger btn-sm";
                            accion= "SI";
                            estado="Inhabilitado";
                        }

                        if (val['estado'] === "ACTIVO") {
                            bgstatus = "badge badge-success";
                        }else if (val['estado'] === "CERRADO") {
                            bgstatus = "badge badge-danger";
                        } else if (val['estado'] === "RESERVA") {
                            bgstatus = "badge badge-warning";
                        }

                        if (val['encargado'] !== null && val['encargado'] !== "") {
                            encargado = val['encargado'] + " " + val['paterno'] + " " + val['materno'] + " " + val['nombres'];
                        } else {
                            encargado = "SIN RESPONSABLE";
                        }

                        tabla=tabla + 
                            "<div class='row rowcolor cfila'>"+
                                "<div class='col-12 col-md-4'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                        "<div class='col-3 col-md-3 td'>"+val['codigo']+"</div>"+
                                        "<div class='col-5 col-md-4 td'>"+val['nombre']+"</div>"+
                                        "<div class='col-2 col-md-3 td text-center '>"+val['anio']+"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-4 td'>"+
                                    "<span>"+encargado+"</span>"+
                                    "<a class='fd-editrespons' data-periodo='"+val['nombre']+"' href='#' title='Cambiar responsable' data-codper='"+val['codigo']+"'>"+
                                        "<i class='fas fa-pen ml-2'></i><i class='fas fa-user-tie'></i>"+
                                    "</a>"+
                                "</div>"+
                                "<div class='col-12 col-md-4 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-md-4 td'>"+
                                            "<span data-toggle='tooltip' title='"+vtitle+"' class='msgtooltip'>"+
                                                "<a data-flat='"+vflat+"' data-idpr='"+val['codigo']+"' data-act='"+accion+"' class='btn "+btncolor+" updateactiv' href='#'>"+
                                                    "<i class='"+vicon+"'></i>"+
                                                "</a>"+
                                            "</span>"+
                                        "</div>"+
                                        "<div class='col-4 col-sm-4 col-md-4 td'>"+
                                            "<span title='"+val['estado']+"'>"+
                                                "<span class='small "+bgstatus+" p-2'>"+val['estado']+"</span>"+
                                            "</span>"+
                                        "</div>"+
                                        "<div class='col-4 col-sm-4 col-md-4 td'>"+
                                            "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                "<div class='btn-group'>"+
                                                    "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                        "<i class='fas fa-cog'></i>"+
                                                    "</a>"+
                                                    "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                        "<a class='dropdown-item' href='#' title='Editar' data-toggle='modal' data-target='#modal-edit-per' data-codigo='"+val['codigo']+"' data-nombre='"+val['nombre']+"' data-anio='"+val['anio']+"' data-estado='"+val['estado']+"'>"+
                                                            "<i class='fas fa-edit mr-2'></i> Editar"+
                                                        "</a>"+
                                                        "<a class='dropdown-item text-danger deleteperiodo' href='#' title='Eliminar' data-idpr='"+val['codigo']+"'>"+
                                                            "<i class='fas fa-trash mr-2'></i> Eliminar"+
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

                $('#divcard_data_periodo').html(tabla);
                // $('.msgtooltip').tooltip();
            } else {
                
                var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                $('#divcard_data_periodo').html(msgf);
            }

            $('#divcard_periodo #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#divcard_periodo #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        },
    });
}

$(document).on("click", ".fd-editrespons", function() {
    var btn=$(this);
    var periodo=$(this).data('periodo');
    var codigo=$(this).data('codper');

    (async () => {const { value: vdocente } = await Swal.fire({
        title: periodo,
        input: 'select',
        inputOptions:vdocentes,
        inputPlaceholder: 'Selecciona un responsable',
        showCancelButton: true,
        confirmButtonText:
        '<i class="fa fa-thumbs-up"></i> Guardar!',
        inputValidator: (value) => {
            return new Promise((resolve) => {
                if (!value) {
                    resolve('Para guardar, debes seleccionar un item de la lista');
                }
                else{
                    $.ajax({
                        url: base_url + 'periodo/fn_cambiarresponsable',
                        type: 'POST',
                        data: {"fictxtresponsable": value ,"fictxtperiodo": codigo},
                        dataType: 'json',
                        success: function(e) {
                            
                            if (e.status==true){
                                
                                if (value=='00000'){
                                    btn.parent().find('span').html("SIN RESPONSABLE");
                                }
                                else{
                                    btn.parent().find('span').html(value + " " + vdocentes[value]);
                                }
                                resolve();
                            }
                            else{
                                Toast.fire({
                                  type: 'danger',
                                  title: 'Error: ' + e.msg
                                });

                            }
                        },
                        error: function(jqXHR, exception) {
                            $(this).bootstrapToggle('off');
                            //$('#divcard_grupo #divoverlay').remove();
                            var msgf = errorAjax(jqXHR, exception, 'text');
                            Swal.fire({
                                title: msgf,
                                type: 'error',
                                icon: 'error',
                            })
                            
                        }
                    })
                }
            })
        },

        allowOutsideClick: false
    })

    })()
});
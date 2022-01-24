$(document).ready(function() {
    $('#lbtn_guardar').attr('disabled', false);
});
$("#modaddpagante").on('hidden.bs.modal', function () {
    $('#frm_addpagante')[0].reset();
    $("#fictxtcodigo").val("0");
    $('#divcard_title').html('AGREGAR NUEVO REGISTRO');
});

function get_datos_dni(e){
    
    $('#frm_addpagante #fictxtcodpagante').val(e.vdata['usuario']);
    if (e.vdata['nivel'] && e.vdata['nivel'] == 3) {
        $('#frm_addpagante #fictipopag').val("ESTUDIANTE");
    } else {
        $('#frm_addpagante #fictipopag').val(e.vdata['tipag']);
    }

    if (e.vdata['personeria']) {
        $('#frm_addpagante #fictipopers').val(e.vdata['personeria']);
    }

    if (e.vdata['paterno'] && e.vdata['materno'] && e.vdata['nombres']) {
        $('#frm_addpagante #fictxtnomrazon').val(e.vdata['paterno']+' '+e.vdata['materno']+' '+e.vdata['nombres']);
    } else {
        $('#frm_addpagante #fictxtnomrazon').val(e.vdata['rsocial']);
    }

    if (e.vdata['email2']) {
        $('#frm_addpagante #fictxtemailper2').val(e.vdata['email2']);
    }

    if (e.vdata['tipdoc'] && e.vdata['ruc']) {
        $('#frm_addpagante #ficbtipodoc').val(e.vdata['tipdoc']);
        $('#frm_addpagante #fitxtdni').val(e.vdata['ruc']);
    }
    
    
    $('#frm_addpagante #fictxtemailper').val(e.vdata['epersonal']);
    $('#frm_addpagante #fictxtemailcorporat').val(e.vdata['einstitucional']);
    $('#frm_addpagante #fictxtdireccion').val(e.vdata['domicilio']);
    $('#frm_addpagante #ficbdepartamento').val(e.vdata['coddepartamento']);
    $('#frm_addpagante #ficbprovincia').html(e.provincias);
    $('#frm_addpagante #ficbprovincia').val(e.vdata['codprovincia']);
    $('#frm_addpagante #ficbdistrito').html(e.distritos);
    $('#frm_addpagante #ficbdistrito').val(e.vdata['coddistrito']);
    $('#frm_addpagante #fictxtelefono').val(e.vdata['telefono']);
    $('#frm_addpagante #fictxtcelular').val(e.vdata['celular']);

    // //CURRENTVALUE
    $('#frm_addpagante input,select').each(function() {
        $(this).data('currentvalue', $(this).val());
    })
    

    $('#lbtn_guardar').attr('disabled', false);


}

$('#frm_addpagante #fibtnsearch-dni').on('click', function() {
    var dni = $('#frm_addpagante #fitxtdni').val();
    $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    // if ((dni.length!=8) || (!$.isNumeric(dni))){
    //     Swal.fire({
    //         type: 'error',
    //         icon: 'error',
    //         title: "DNI incorrecto",
    //         text: "Un N° de DNI correcto presenta 8 números",
    //         backdrop:false,
    //     });
    //     $('#divmodaladd #divoverlay').remove();
    //     return;
    // }
    $.ajax({
        url: base_url + 'pagante/fn_get_datos_pagante_por_dni',
        type: 'post',
        dataType: 'json',
        data: {
            fitxtdni: dni
        },
        success: function(e) {
            if (e.status==true){
                get_datos_dni(e);
                
                $('#divmodaladd #divoverlay').remove();
            }
            else{
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: "ADVERTENCIA",
                    text: "No se encontro registro, puedes registrar MANUALMENTE o comunícate con SOPORTE",
                    backdrop:false,
                });
                $('#lbtn_guardar').attr('disabled', false);
                $('#divmodaladd #divoverlay').remove();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: "Existe un error en la búsqueda de DNI, comunícate con SOPORTE",
                text: msgf,
                backdrop:false,
            });
            $('#divmodaladd #divoverlay').remove();
        }
    });
    return false;
});

$('#lbtn_guardar').click(function() {
    $('#frm_addpagante input,select').removeClass('is-invalid');
    $('#frm_addpagante .invalid-feedback').remove();
    $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $('#frm_addpagante').attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#frm_addpagante').serialize(),
        success: function(e) {
            $('#divmodaladd #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                $('#modaddpagante').modal('hide');
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                  if (result.value) {

                    if (e.ficaccion == "INSERTAR") {
                        location.reload();
                        
                    } else if (e.ficaccion == "EDITAR") {
                        $('#frmsearch_pagante').submit();
                    }
                     
                    
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

$('#frmsearch_pagante').submit(function() {
    $('#frmsearch_pagante input,select').removeClass('is-invalid');
    $('#frmsearch_pagante .invalid-feedback').remove();
    $('#divcard_pagante').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'pagante/get_filtrar_lista',
        type: 'post',
        dataType: 'json',
        data: $('#frmsearch_pagante').serialize(),
        success: function(e) {
            $('#divcard_pagante #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });

                $("#divres-pagante").html("");
            } else {

                $("#divres-pagante").html(e.vdata);
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_pagante #divoverlay').remove();
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

function viewupdpagante(codigo){
    $('#divcard_pagante').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#divrstarea").html("");
    $.ajax({
        url: base_url + "pagante/vwmostrar_registroxcodigo",
        type: 'post',
        dataType: "json",
        data: {txtcodigo: codigo},
        success: function(e) {
            $('#divcard_pagante #divoverlay').remove();
            $('#divcard_title').html('ACTUALIZAR REGISTRO');
            $("#frm_addpagante #fictxtcodigo").val(e.vdata['id']);

            get_datos_dni(e);

            $("#modaddpagante").modal("show");
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div' );
            $('#divcard_pagante #divoverlay').remove();
            $("#modaddpagante modal-body").html(msgf);
        } 
    });
    return false;
}

function fn_combo_ubigeo(combo){
    if (combo.data('tubigeo') == "departamento") {
        var nmprov=combo.data('cbprovincia');
        var nmdist=combo.data('cbdistrito');
        var nmdiv=combo.data('dvcarga');
        $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#' + nmprov).html("<option value='0'>Sin opciones</option>");
        $('#frm_addpagante #' + nmdist).html("<option value='0'>Sin opciones</option>");
        var coddepa = combo.val();
        
        if (coddepa == '0') return;
        $.ajax({
            url: base_url + 'ubigeo/fn_provincia_x_departamento',
            type: 'post',
            dataType: 'json',
            data: {
                txtcoddepa: coddepa
            },
            success: function(e) {
                $('#' + nmdiv + ' #divoverlay').remove();
                $('#frm_addpagante #' + nmprov).html(e.vdata);
                
            },
            error: function(jqXHR, exception) {
                $('#' + nmdiv + ' #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#frm_addpagante #' + nmprov).html("<option value='0'>" + msgf + "</option>");
            }
        });
    } 
    else if (combo.data('tubigeo') == "provincia") {
        var nmdist=combo.data('cbdistrito');
        var nmdiv=combo.data('dvcarga');
        $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#frm_addpagante #' + nmdist).html("<option value='0'>Sin opciones</option>");
        var codprov = combo.val();
        if (codprov == '0') return;
        $.ajax({
            url: base_url + 'ubigeo/fn_distrito_x_provincia',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodprov: codprov
            },
            success: function(e) {
                $('#' + nmdiv + ' #divoverlay').remove();
                $('#frm_addpagante #' + nmdist).html(e.vdata);
                
            },
            error: function(jqXHR, exception) {
                $('#' + nmdiv + ' #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#frm_addpagante #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
            }
        });
    } 
    // else if (combo.data('tubigeo') == "distrito") {
        
    // }
    return false;
}

$(document).on("click", ".deletepgt", function(e){
    e.preventDefault();
    var boton = $(this);
    var fila = boton.closest('.cfila');
    var cliente = fila.data('cliente');
    var codigo = boton.data('id');
    Swal.fire({
        title: '¿Está seguro de eliminar el cliente '+cliente+'?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar!'
    }).then(function(result){
        if(result.value){
            $('#divcard_pagante').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + "pagante/fneliminar_cliente",
                method: "POST",
                dataType: 'json',
                data: {
                    'c-codigo':codigo,
                },
                success:function(e){
                    $('#divcard_pagante #divoverlay').remove();
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
                               fila.remove();
                            }
                        })
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divcard_pagante #divoverlay').remove();
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

$("#modaddpagante").on('hidden.bs.modal', function (e) {
    $('#frm_addpagante input,select').removeClass('is-invalid');
    $('#frm_addpagante .invalid-feedback').remove();
})
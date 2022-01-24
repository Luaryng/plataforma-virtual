function get_datos_dni(e){
        $("#frmins-personales input").val("");
    $("#frmins-personales select").val("");
    $('#frmins-personales #fidpid').val(e.vdata['idpersona']);
    $('#frmins-personales #fitxtcodinstitucional').val(e.vdata['codpersona']);
    $('#frmins-personales #ficbtipodoc').val(e.vdata['tipodoc']);
    $('#frmins-personales #fitxtdni').val(e.vdata['numero']);
    $('#frmins-personales #fitxtapelpaterno').val(e.vdata['paterno']);
    $('#frmins-personales #fitxtapelmaterno').val(e.vdata['materno']);
    $('#frmins-personales #fitxtnombres').val(e.vdata['nombres']);
    $('#frmins-personales #ficbsexo').val(e.vdata['sexo']);
    $('#frmins-personales #fitxtfechanac').val(e.vdata['fecnac']);
    $('#frmins-personales #fitxtcelular').val(e.vdata['celular']);
    $('#frmins-personales #fitxttelefono').val(e.vdata['telefono']);
    $('#frmins-personales #fitxtemailpersonal').val(e.vdata['epersonal']);
    $('#frmins-personales #fitxtdomicilio').val(e.vdata['domicilio']);
    $('#frmins-personales #ficbdepartamento').val(e.vdata['coddepartamento']);
    $('#frmins-personales #ficbprovincia').html(e.provincias);
    $('#frmins-personales #ficbprovincia').val(e.vdata['codprovincia']);
    $('#frmins-personales #ficbdistrito').html(e.distritos);
    $('#frmins-personales #ficbdistrito').val(e.vdata['coddistrito']);
    $('#frmins-personales #fitxtdomiciliootro').val(e.vdata['domiciliosecu']);

    $('#frmins-personales #ficbestcivil').val(e.vdata['estadocivil']);
    $('#frmins-personales #fitxtlugarnac').val(e.vdata['lugnac']);
    $('#frmins-personales #fitxtcelular2').val(e.vdata['celular2']);
    // $('#frmins-personales #fitxtcolsecund').val(e.vdata['colsecund']);
    // $('#frmins-personales #ficbstatrab').val(e.vdata['statrab']);
    // $('#frmins-personales #fitxtlugartrab').val(e.vdata['lugar_trab']);
    // $('#frmins-personales #fitxtapelpatmatpa').val(e.vdata['apepapa']);
    // $('#frmins-personales #fitxtapelpatmatma').val(e.vdata['apemama']);

    // $('#frmins-personales #fitxtocupadre').val(e.vdata['ocupapadre']);
    // $('#frmins-personales #fitxtocumadre').val(e.vdata['ocupamadre']);

    $('#frmins-personales #ficbpais').val(e.vdata['pais']);
    //CURRENTVALUE
    $('#frmins-personales input,select').each(function() {
        $(this).data('currentvalue', $(this).val());
    })
    //
    $('.nav-pills a[href="#ficha-personal"]').tab('show');
    $('#btn-sugerecia-edit').show();
    $('#btn-sugerecia-open').show();
    $('#btn-sugerecia-cancel').show();
    $('#frmins-personales').data('action', 'view');




    $("#frmins-personales input").attr('disabled', true);
    $("#frmins-personales select").attr('disabled', true);
    $("#btn-sugerecia-open").show();
    $("#btn-sugerecia-cancel").hide();
    $('#div-inscripcion .next').hide();
    $('#btn-sugerecia-edit').show();

        
    if ($('#frmins-personales #ficbstatrab').val() =='SI') {
        $('#divcard_lugartrab').removeClass('d-none');
    } else {
        $('#divcard_lugartrab').addClass('d-none');
    }
    


}

function get_ficha(vtxtidentificador) {
    $.ajax({
        url: base_url + 'persona/fn_get_datos_personales',
        type: 'post',
        dataType: 'json',
        data: {
            fidpid: vtxtidentificador
        },
        success: function(e) {
            //tb_persona.per_foto as foto,
            //VALUES
            get_datos_dni(e);
            

        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#frmins-personales #ficbprovincia').html("<option value='0'>" + msgf + "</option>");
            $('#frmins-personales #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
            $('#frmins-personales #ficbdepartamento').html("<option value='0'>" + msgf + "</option>");
        }
    });
    return false;
}

$('#frm-filtro-historial').submit(function() {
    $('#divres-historial').html("");
    $('#frm-filtro-historial input:text').removeClass('is-invalid');
    $('#frm-filtro-historial .invalid-feedback').remove();
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divboxhistorial #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().parent().after("<div class='invalid-feedback btn-block'>" + val + "</div>");
                });
            } else {
                $('#divres-historial').html(e.vdata);
                if (e.conteo == 0) {
                    $("#panel-acciones").fadeIn('fast');
                } else {}
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#divboxhistorial #divoverlay').remove();
            $('#divres-historial').html(msgf);
        }
    });
    return false;
});


// $("#btn-agregar-prog").click(function(event) {
//     $("#frmins-personales #fitxtdni").attr('disabled', false);
//     location.href = base_url + 'admision/inscripciones/' + $('#frmins-personales #fitxtdni').val();
//     $("#frmins-personales #fitxtdni").attr('disabled', true);
// });

$('#frmins-personales #fibtnvalida-dni').on('click', function() {
    var dni = $('#frmins-personales #fitxtdni').val();
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    if ((dni.length!=8) || (!$.isNumeric(dni))){
        Swal.fire({
            type: 'error',
            title: "DNI incorrecto",
            text: "Un N° de DNI correcto presenta 8 números",
            backdrop:false,
        });
        $('#divboxhistorial #divoverlay').remove();
        return;
    }
    $.ajax({
        url: base_url + 'docentes/fn_get_datos_docente_por_dni',
        type: 'post',
        dataType: 'json',
        data: {
            fitxtdni: dni
        },
        success: function(e) {
            //tb_persona.per_foto as foto,
            //VALUES
            if (e.status==true){
                get_datos_dni(e);

                $('#divboxhistorial #divoverlay').remove();
            }
            else{
                $.ajax({
                    data: {
                        "dni": dni
                    },
                    type: "POST",
                    dataType: "json",
                    url: base_url +  "cnrnc/consulta_reniec.php",
                    success: function(datos_dni) {
                        var datos = eval(datos_dni);
                        if (datos['status'] == true) {
                            $("#fitxtreniec").val(datos['paterno'] + ' ' + datos['materno'] + ' ' + datos['nombres']);
                            $("#fibtnaplica-reniec").attr('disabled', false);
                            txtrnc = $("#fitxtreniec");
                            txtrnc.data('paterno', datos['paterno']);
                            txtrnc.data('materno', datos['materno']);
                            txtrnc.data('nombres', datos['nombres']);
                        } else {
                            $("#fitxtreniec").val(datos['msg']);
                            $("#fibtnaplica-reniec").attr('disabled', true);
                            txtrnc = $("#fitxtreniec");
                            txtrnc.data('paterno', '');
                            txtrnc.data('materno', '');
                            txtrnc.data('nombres', '');
                            $('#frmins-personales #fitxtdni').focus();
                        }
                        $('#divboxhistorial #divoverlay').remove();
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        Swal.fire({
                            type: 'error',
                            title: "No pudimos conectar a RENIEC, puedes registrar MANUALMENTE o comunícate con SOPORTE",
                            text: msgf,
                            backdrop:false,
                        });
                        $('#divboxhistorial #divoverlay').remove();
                    }
                });
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: "Existe un error en la búsqueda de DNI, comunícate con SOPORTE",
                text: msgf,
                backdrop:false,
            });
            $('#divboxhistorial #divoverlay').remove();
        }
    });
    return false;
});

$('#frmins-personales #fibtnaplica-reniec').on('click', function() {
    var txtrnc = $("#fitxtreniec");
    $('#frmins-personales #fitxtapelpaterno').val(txtrnc.data('paterno'));
    $('#frmins-personales #fitxtapelmaterno').val(txtrnc.data('materno'));
    $('#frmins-personales #fitxtnombres').val(txtrnc.data('nombres'));
    return false;
});

$('#frm-filtro-historial input[type=radio][name=rbgbusqueda]').change(function() {
    // Do something interesting here
    var rd = $(this);
    $('input[type=radio][name=rbgbusqueda]').parent().removeClass('bg-primary');
    $('input[type=radio][name=rbgbusqueda]').parent().parent().find('input[type=text]').attr('disabled', true);
    rd.parent().addClass('bg-primary');
    rd.parent().parent().find('input[type=text]').attr('disabled', false);
    rd.parent().parent().find('input[type=text]').focus();
});
$('#frm-filtro-historial .radiobusqueda').click(function(event) {
    $(this).find('input').change();
    $(this).find('input').prop('checked', true)
});

var frmmc_edit = new Array();
var frmdp_edit = new Array();
$('#frmins-personales input,select').change(function() {
    // Do something interesting here
    //alert($(this).data('currentvalue'));
    if ($(this).data('currentvalue') !== $(this).val()) {
        if (frmdp_edit.indexOf($(this).attr('id')) == -1) frmdp_edit.push($(this).attr('id'));
    } else {
        var i = frmdp_edit.indexOf($(this).attr('id'));
        i !== -1 && frmdp_edit.splice(i, 1);
    }
    if (frmdp_edit.length > 0) {
        $("#fispedit").html("* modificado");
    } else {
        $("#fispedit").html("");
    }
    if ($(this).attr('id') == "ficbdepartamento") {
        $('#frmins-personales #ficbprovincia').html("<option value='0'>Sin opciones</option>");
        $('#frmins-personales #ficbdistrito').html("<option value='0'>Sin opciones</option>");
        var coddepa = $(this).val();
        if (coddepa == '0') return;
        $.ajax({
            url: base_url + 'ubigeo/fn_provincia_x_departamento',
            type: 'post',
            dataType: 'json',
            data: {
                txtcoddepa: coddepa
            },
            success: function(e) {
                $('#frmins-personales #ficbprovincia').html(e.vdata);
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#frmins-personales #ficbprovincia').html("<option value='0'>" + msgf + "</option>");
            }
        });
    } else if ($(this).attr('id') == "ficbprovincia") {
        $('#frmins-personales #ficbdistrito').html("<option value='0'>Sin opciones</option>");
        var codprov = $(this).val();
        if (codprov == '0') return;
        $.ajax({
            url: base_url + 'ubigeo/fn_distrito_x_provincia',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodprov: codprov
            },
            success: function(e) {
                $('#frmins-personales #ficbdistrito').html(e.vdata);
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#frmins-personales #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
            }
        });
        return false;
    }
    return false;
});

$('#frmins-contactos input,select').change(function() {
    // Do something interesting here
    //alert($(this).data('currentvalue'));
    if ($(this).data('currentvalue') !== $(this).val()) {
        if (frmmc_edit.indexOf($(this).attr('id')) == -1) frmmc_edit.push($(this).attr('id'));
    } else {
        var i = frmmc_edit.indexOf($(this).attr('id'));
        i !== -1 && frmmc_edit.splice(i, 1);
    }
    if (frmmc_edit.length > 0) {
        $("#fispmcedit").html("* modificado");
    } else {
        $("#fispmcedit").html("");
    }
    return false;
});

$('#frm-filtro-historial .radiobusqueda').click(function(event) {
    $(this).find('input').change();
    $(this).find('input').prop('checked', true)
});

$("#div-inscripcion").loadsteps();
$('#div-inscripcion .next').click(function(event) {
    var btn = $(this);
    var paso = btn.data('step');
    if (paso == 'ins') {
        if (frmdp_edit.length > 0) {
            $("#frmins-personales").submit();
        } else {
            if ($(this).data('action')=='view'){
                $("#div-inscripcion").next_step();
            }
        }
    } /*else if (paso == 'con') {
        if (frmmc_edit.length > 0) {
            $("#frmins-contactos").submit();
        } else {
            $("#div-inscripcion").next_step();
        }

    }*/
});
$("#frmins-personales").submit(function(event) {
    /* Act on the event */
    $('#frmins-personales input,select').removeClass('is-invalid');
    $('#frmins-personales .invalid-feedback').remove();

    $("#frmins-personales #fitxtdni").attr('disabled', false);
    $("#frmins-personales #ficbtipodoc").attr('disabled', false);

    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    urlpersonales = base_url + 'persona/fn_update_datos_personales_docente';
    if ($(this).data('action') == 'insert') urlpersonales = base_url + 'persona/fn_insert_datos_personales_docente';
    $.ajax({
        url: urlpersonales,
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {

            $('#divboxhistorial #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: "No se pudieron guardar datos",
                    text: e.msg,
                    backdrop:false,
                });
            } else {
                $("#frmins-personales input").attr('disabled', true);
                $("#frmins-personales select").attr('disabled', true);
                if ($(this).data('action')=='edit'){
                    $("#frmins-personales #fitxtdni").attr('disabled', true);
                    $("#frmins-personales #ficbtipodoc").attr('disabled', true);
                }
                

                $('#frmins-personales input,select').each(function() {
                    $(this).data('currentvalue', $(this).val());
                })
                $(this).data('action', 'view');
                $("#div-inscripcion").next_step();
                frmdp_edit = new Array();
                $("#fispedit").html("");
                Swal.fire({
                    type: 'success',
                    title: "Datos GUARDADOS CORRECTAMENTE",
                    text: e.msg,
                    backdrop:false,
                });
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: "Datos GUARDADOS CORRECTAMENTE",
                text: msgf,
                backdrop:false,
            });
        }
    });
    return false;
});

$('#div-inscripcion .previous').click(function(event) {
    $("#div-inscripcion").previous();
});
//PANEL DE MAS ACCIONES

$('#btn-sugerecia-open').click(function(event) {
    $("#tabli-aperturafile").show();
    $('.nav-pills a[href="#ficha-personal"]').tab('show');
    $('#frmins-contactos input,select').each(function() {
        $(this).data('currentvalue', "");
    })
    $("#frmins-personales input").val("");
    $("#frmins-personales select").val("0");
    $("#frmins-personales").data('action', 'insert');
    $("#frmins-personales input").attr('disabled', false);
    $("#frmins-personales select").attr('disabled', false);
    $("#frmins-personales #fitxtreniec").attr('disabled', true);
    $('#fibtnvalida-dni').attr('disabled', false);
    $("#btn-sugerecia-open").hide();
    $("#btn-sugerecia-cancel").show();
    $('#div-inscripcion .next').show();
});

$('#btn-sugerecia-edit').click(function(event) {
    $("#tabli-aperturafile").show();
    $('.nav-pills a[href="#ficha-personal"]').tab('show');

   
    $("#frmins-personales").data('action', 'edit');
    $("#frmins-personales input").attr('disabled', false);
    $("#frmins-personales select").attr('disabled', false);
    $("#frmins-personales #fitxtreniec").attr('disabled', true);
    $("#frmins-personales #ficbtipodoc").attr('disabled', true);
    $("#frmins-personales #fitxtdni").attr('disabled', true);
    $("#btn-sugerecia-open").hide();

    $("#btn-sugerecia-cancel").show();
    $('#div-inscripcion .next').show();
    $('#btn-sugerecia-edit').hide();
});

$('#btn-sugerecia-cancel').click(function(event) {
    $('.nav-pills a[href="#ficha-personal"]').tab('show');
    $('#frmins-contactos input,select').each(function() {
        $(this).data('currentvalue', "");
    })
    $("#frmins-personales input").val("");
    $("#frmins-personales select").val("");
    $("#frmins-personales").data('action', 'insert');
    $("#frmins-personales input").attr('disabled', true);
    $("#frmins-personales select").attr('disabled', true);
    $("#btn-sugerecia-open").show();
    $("#btn-sugerecia-cancel").hide();
    $('#div-inscripcion .next').hide();
    $('#btn-sugerecia-edit').hide();
    
});

$(".multi-steps .steps a").click(function(event) {
    var step=$(".steps li").index($(this).parent());
    if ($("#frmins-personales").data('action')=='view'){
        $("#div-inscripcion").go_step(step);
    }
    return false;
});

$(document).ready(function() {
    $("#div-inscripcion").loadsteps();
    $("#frmins-personales input").attr('disabled', true);
    $("#frmins-personales select").attr('disabled', true);
    $("#btn-sugerecia-open").show();
    $("#btn-sugerecia-cancel").hide();
    $('#div-inscripcion .next').hide();
    $('#btn-sugerecia-edit').hide();
    $('#fibtnvalida-dni').attr('disabled', true);

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    })

    Toast.fire({
      type: 'info',
      title: 'Aviso: Antes de aperturar una ficha, verifica si el postulante no ha sido registrado anteriormente'
    })
    $("#txtbusqueda").focus();
});

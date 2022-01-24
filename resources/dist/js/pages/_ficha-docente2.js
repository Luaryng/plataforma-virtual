$(document).ready(function() {
    $("#frmins-personales input").attr('disabled', true);
    $("#frmins-personales select").attr('disabled', true);
    $("#btn-sugerecia-edit").hide();
    $("#btn-sugerecia-cancel").hide();
    $('#dvw_rrhh-btn_nuevo').hide();
    
    const Toast2 = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    })

    Toast2.fire({
      type: 'info',
      title: 'Aviso: Antes de aperturar una ficha, verifica si el postulante no ha sido registrado anteriormente'
    })
});
const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000}
      );

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
function llenarDatosPersona(e){
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
     $('#frmins-personales #fitxtidarea').val(e.vdata['idarea']);

    //CURRENTVALUE
    $('#frmins-personales input,select').each(function() {
        $(this).data('currentvalue', $(this).val());
    })
    $('#frmins-personales').data('action', 'edit');
    $('.nav-pills a[href="#ficha-personal"]').tab('show');
}

function cargaDatosDocente(btn){
     var vtxtdni = btn.data('coddocente');
     $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'docentes/fn_get_datos_docente_por_codigo',
        type: 'post',
        dataType: 'json',
        data: {
            fitxtcodigo: vtxtdni
        },
        success: function(e) {
            //tb_persona.per_foto as foto,
            //VALUES
            $('#divboxhistorial #divoverlay').remove();
            if (e.status==true){
                llenarDatosPersona(e);
                $('#frmins-personales #fitxtcoddocente').val(e.vdata['codtrabajador']);
                $('#frmins-personales #ficbtipo').val(e.vdata['tipo']);
                $('#frmins-personales #fitxtcargo').val(e.vdata['cargo']);
                $('#frmins-personales #fitxteinstitucional').val(e.vdata['ecorporativo']);

                $("#frmins-personales").data('action', 'edit');
                $("#frmins-personales input").attr('disabled', false);
                $("#frmins-personales select").attr('disabled', false);
                $("#frmins-personales #fitxtreniec").attr('disabled', true);
                $("#btn-sugerecia-open").hide();
                $("#btn-sugerecia-cancel").show();
                $('#dvw_rrhh-btn_nuevo').show();
            }
            else{

            }
            
        },
        error: function(jqXHR, exception) {
            $('#divboxhistorial #divoverlay').remove();
            //var msgf = errorAjax(jqXHR, exception, 'text');
            //$('#frmins-personales #ficbprovincia').html("<option value='0'>" + msgf + "</option>");
        }
    });
    return false;
};

/*$('#frmins-personales #fibtnvalida-dni').on('click', function() {
     var vtxtdni = $('#frmins-personales #fitxtdni').val();
     $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'docentes/fn_get_datos_docente_por_dni',
        type: 'post',
        dataType: 'json',
        data: {
            fitxtdni: vtxtdni
        },
        success: function(e) {
            //tb_persona.per_foto as foto,
            //VALUES
            if (e.status==true){
                cargaDatosDocente(e);
                $('#divboxhistorial #divoverlay').remove();
            }
            else{
                $.ajax({
                    data: {
                        "dni": vtxtdni
                    },
                    type: "POST",
                    dataType: "json",
                    url: "http://localhost/cnrnc/consulta_reniec.php",
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
                    }
                });
            }
            
        },
        error: function(jqXHR, exception) {
            $('#divboxhistorial #divoverlay').remove();
            //var msgf = errorAjax(jqXHR, exception, 'text');
            //$('#frmins-personales #ficbprovincia').html("<option value='0'>" + msgf + "</option>");
        }
    });
    return false;
});*/


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
    
});


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
/*var sugerencias = {
    newsearch: "<b>Realizar búsqueda</b><br> Realiza una nueva búsqueda, con nuevos parámetros",
    openfile: "<b>Crea un nuevo historial para un alumno</b><br> Usa esta opción cuando no se tenga registro del alumno en la institución "
};
$(".btn-sugerencias").mouseover(function(event) {
    $("#div-consejo").html(sugerencias[$(this).data('sugerencia')]);
});*/


function getdominio(url) {
    var hostName =url.replace('http://','').replace('https://','').replace('www.','').split(/[/?#]/)[0];
    var domain = hostName;
    if (hostName != null) {
        var parts = hostName.split('.').reverse();
        
        if (parts != null && parts.length > 1) {
            domain = parts[1] + '.' + parts[0];
                
            if (hostName.toLowerCase().indexOf('.edu.pe') != -1 && parts.length > 2) {
              domain = parts[2] + '.' + domain;
            }
            else if (hostName.toLowerCase().indexOf('.net.pe') != -1 && parts.length > 2) {
              domain = parts[2] + '.' + domain;
            }
        }
    }
    
    return domain;
}

$('#frmins-personales #fibtnaplica-reniec').on('click', function() {
    var txtrnc = $("#fitxtreniec");
    $('#frmins-personales #fitxtapelpaterno').val(txtrnc.data('paterno'));
    $('#frmins-personales #fitxtapelmaterno').val(txtrnc.data('materno'));
    $('#frmins-personales #fitxtnombres').val(txtrnc.data('nombres'));

    var dominiomail=getdominio(location.hostname);
    $('#frmins-personales #fitxteinstitucional').val( (txtrnc.data('nombres').charAt(0) + txtrnc.data('paterno')).toLowerCase() + "@" + dominiomail)
    return false;
});
$("#frmins-personales #fitxtapelpaterno, #frmins-personales #fitxtnombres").blur(function(){
        var pat=$('#frmins-personales #fitxtapelpaterno').val();
        var nom=$('#frmins-personales #fitxtnombres').val();
   

        var dominiomail=getdominio(location.hostname);

        $('#frmins-personales #fitxteinstitucional').val( (nom.charAt(0) + pat).toLowerCase() + "@" + dominiomail)
     
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

$('#frm-filtro-historial .radiobusqueda').click(function(event) {
    $(this).find('input').change();
    $(this).find('input').prop('checked', true)
});
$('#dvw_rrhh-btn_nuevo').click(function(event) {
    var btn = $(this);
    var paso = btn.data('step');
    if (paso == 'ins') {
        if (frmdp_edit.length > 0) {
            $("#frmins-personales").submit();
        } 
    } 
});
$("#frmins-personales").submit(function(event) {
    /* Act on the event */
    $('#frmins-personales input,select').removeClass('is-invalid');
    $('#frmins-personales .invalid-feedback').remove();
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    urlpersonales = base_url + 'docentes/fn_update_datos_docente';
    if ($(this).data('action') == 'insert') urlpersonales = base_url + 'docentes/fn_insert_datos_docente';
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
                    title: 'NO SE REGISTRO LOS DATOS',
                    text: e.msg,
                    backdrop:false,
                })
            } else {
                $('#frmins-personales input,select').each(function() {
                    $(this).data('currentvalue', $(this).val());
                })
                $(this).data('action', 'edit');
                 Swal.fire({
                    type: 'success',
                    title: 'SE REGISTRO LOS DATOS',
                    text: e.msg,
                    backdrop:false,
                })
                frmdp_edit = new Array();
                $("#fispedit").html("");
                   $("#frmins-personales input").attr('disabled', true);
                    $("#frmins-personales select").attr('disabled', true);
                    $("#btn-sugerecia-open").show();
                    $("#btn-sugerecia-cancel").hide();
                    $('#dvw_rrhh-btn_nuevo').hide();
            }
        },
        error: function(jqXHR, exception) {
            $('#divboxhistorial #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                    type: 'error',
                    title: 'NO SE REGISTRO LOS DATOS',
                    text: e.msgf,
                    backdrop:false,
                })
        }
    });
    return false;
});

$('#div-inscripcion .previous').click(function(event) {
    $("#div-inscripcion").previous();
});
//PANEL DE MAS ACCIONES
$('#btn-sugerecia-open').click(function(event) {
    
    
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
    $('#dvw_rrhh-btn_nuevo').hide();
    
});



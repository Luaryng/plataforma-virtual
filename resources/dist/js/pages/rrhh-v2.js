$(document).ready(function() {
    $("#frmins-personales input").attr('disabled', true);
    $("#frmins-personales select").attr('disabled', true);
    $('#vw_rrhh-btn_nuevo').show();
    $('#vw_rrhh-btn_editar').hide();
    $('#vw_rrhh-btn_guardar').hide();
    $('#vw_rrhh-btn_cancelar').hide();

    //DIV
    $('#vw_rrhh-div_ficha').hide();
    $('#vw_rrhh-div_botones').show();
    
    /*const Toast2 = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    })

    Toast2.fire({
      type: 'info',
      title: 'Aviso: Antes de aperturar una ficha, verifica si el postulante no ha sido registrado anteriormente'
    })*/
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
                    $('#' + key).parent().append("<div class='invalid-feedback btn-block'>" + val + "</div>");
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

function validardni(vdni){
  var isdni=true;
  if (($.trim(vdni).length!=8) ){
        /*Swal.fire({
            type: 'error',
            title: "DNI incorrecto",
            text: "Un N° de DNI correcto presenta 8 números",
            backdrop:false,
        });
        $('#divboxhistorial #divoverlay').remove();*/
        isdni=false;
    }
    return isdni;
}
function llenar_datos_dni(e){
   $('#vw_rrhh-div_ficha').show();
    $('#vw_rrhh-div_botones').show();
    $("#frmins-personales input[name!='fitxtdni']").val("");
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

    //DATOS DE TRABAJADOR
    
    $('#frmins-personales #fitxtcoddocente').val(e.vdata['codtrabajador']);

    $('#frmins-personales #fitxtcargo').val(e.vdata['cargo']);
    $('#frmins-personales #fitxteinstitucional').val(e.vdata['ecorporativo']);

    // $('#frmins-personales #fidptrabaja').val(e.vdata['statrab']);
    // $('#frmins-personales #fidplugtrab').val(e.vdata['lugar_trab']);
    $('#frmins-personales #fidpstadociv').val(e.vdata['estadocivil']);
    $('#frmins-personales #ficbestcivil').val(e.vdata['estadocivil']);

    $('#frmins-personales #fidplugnacim').val(e.vdata['lugnac']);
    $('#frmins-personales #fitxtlugarnac').val(e.vdata['lugnac']);
    // $('#frmins-personales #fidpnompadre').val(e.vdata['apepapa']);
    // $('#frmins-personales #fidpnommadre').val(e.vdata['apemama']);
    $('#frmins-personales #fidpcelular2').val(e.vdata['celular2']);
    $('#frmins-personales #fitxtcelular2').val(e.vdata['celular2']);
    // $('#frmins-personales #fidpsecundaria').val(e.vdata['colsecund']);
    
    $('#frmins-personales #ficbpais').val(e.vdata['pais']);

    //DATOS DE USUARIO
    
    $('#frmins-personales #fitxtidarea').val(e.vdata['codarea']);
    $('#frmins-personales #ficbtipo').val(e.vdata['tipo']);
    $('#frmins-personales #ficbtipo_antiguo').val(e.vdata['tipo']);
    
    //CURRENTVALUE
    $('#frmins-personales input,select').each(function() {
        $(this).data('currentvalue', $(this).val());
    })
    //

    //72637340
    //alert(e.vdata['usuario']);
    //alert(e.vdata['codtrabajador']);
    if (e.vdata['codtrabajador']!=null){
      //$('#frmins-personales').data('action', 'view');
      $("#frmins-personales input").attr('disabled', true);
      $("#frmins-personales select").attr('disabled', true);


      
      $('#vw_rrhh-btn_nuevo').show();
      $('#vw_rrhh-btn_editar').show();
      $('#vw_rrhh-btn_guardar').hide();
      $('#vw_rrhh-btn_cancelar').hide();
    }
    else {
       //$('#frmins-personales').data('action', 'view');
        $('#vw_rrhh-btn_nuevo').hide();
        $('#vw_rrhh-btn_editar').hide();
        $('#vw_rrhh-btn_guardar').show();
        $('#vw_rrhh-btn_cancelar').show();
        $('#frmins-personales #fitxtidarea').val("");
        $('#frmins-personales #fitxtcoddocente').val("0");
        $('#frmins-personales #fitxtdni,#frmins-personales #fitxtapelpaterno,#frmins-personales #fitxtapelmaterno,#frmins-personales #fitxtnombres,#frmins-personales #ficbtipodoc').attr('disabled', true);

    }
    

    /*$('.nav-pills a[href="#ficha-personal"]').tab('show');
    $('#btn-sugerecia-edit').show();
    $('#btn-sugerecia-open').show();
    $('#btn-sugerecia-cancel').show();
    




    $("#frmins-personales input").attr('disabled', true);
    $("#frmins-personales select").attr('disabled', true);
    $("#btn-sugerecia-open").show();
    $("#btn-sugerecia-cancel").hide();
    $('#vw_rrhh-btn_nuevo').hide();
    $('#btn-sugerecia-edit').show();*/
}


function get_datos_dni(vdni){

  $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
        url: base_url + 'docentes/fn_get_datos_docente_por_dni',
        type: 'post',
        dataType: 'json',
        data: {
            fitxtdni: vdni
        },
        success: function(e) {
            //tb_persona.per_foto as foto,
            //VALUES
            $('#divboxhistorial #divoverlay').remove();
            if (e.status==true){
                
                llenar_datos_dni(e);

                if ((sedeuser == e.vdata['sede']) || (e.vdata['sede'] == null)) {
                    $('#divmsg_sede').html("");
                } else {
                    $('#divmsg_sede').html('<div class="alert alert-secondary alert-dismissible fade show">'+
                            '<strong>Aviso:</strong> Este personal pertenece a la SEDE '+e.vdata['nomsede']+
                        '</div>');
                    $('#vw_rrhh-btn_editar').hide();
                }

            }
            else{
                $('#vw_rrhh-div_ficha').show();
                $('#vw_rrhh-div_botones').show();
                $("#frmins-personales input[name!='fitxtdni']").val("");
                $("#frmins-personales select").val("");
                $('#frmins-personales input,select').each(function() {
                      $(this).data('currentvalue', $(this).val());
                })
                $("#frmins-personales #ficbtipodoc").val("DNI");
                $("#frmins-personales #fitxtdni").focus();
                
                $('#frmins-personales #fitxtcoddocente').val("0");
                $('#frmins-personales #ficbpais').val("0");
                $('#frmins-personales #ficbdepartamento').val("0");
                $('#frmins-personales #ficbtipo').val("");
                $('#frmins-personales #fidpid').val("0");
                $('#frmins-personales #fitxtcodinstitucional').val($("#frmins-personales #fitxtdni").val());

                // $('#frmins-personales #fidpid').val("");
                $('#vw_rrhh-btn_nuevo').hide();
                $('#vw_rrhh-btn_editar').hide();
                $('#vw_rrhh-btn_guardar').show();
                $('#vw_rrhh-btn_cancelar').show();
                $('#frmins-personales #fitxtidarea').val("");

                /*$.ajax({
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
                });*/
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
    
}
$("#frmins-personales #fitxtdni").keyup(function(event) {
    if ($("#frmins-personales #ficbtipodoc").val()=="DNI"){
        //if ($.trim($(this).val()).length==8 ){
        if (validardni($(this).val())){
            get_datos_dni($(this).val());
        }
        //buscar()
        
    }
   
});

$("#vw_rrhh-btn_nuevo, #vw_dct-btn_ficha_link").click(function(event) {
  //$("#tabli-aperturafile").show();
    $('.nav-pills a[href="#ficha-personal"]').tab('show');
    $('#frmins-contactos input,select').each(function() {
        $(this).data('currentvalue', "");
    });
    $("#frmins-personales input").val("");
    $("#frmins-personales select").val("");

    $("#frmins-personales").data('action', 'insert');
    $("#frmins-personales input").attr('disabled', false);
    $("#frmins-personales select").attr('disabled', false);
    //$("#frmins-personales #fitxtreniec").attr('disabled', true);
    $("#frmins-personales #ficbtipodoc").val("DNI");
    $("#frmins-personales #fitxtdni").focus();

    $('#vw_rrhh-btn_nuevo').hide();
    $('#vw_rrhh-btn_editar').hide();
    $('#vw_rrhh-btn_guardar').show();
    $('#vw_rrhh-btn_cancelar').show();
    $('#vw_rrhh-div_ficha').hide();
    $('#vw_rrhh-div_botones').hide();
    $('#divmsg_sede').html('');
    

});

$('#vw_rrhh-btn_guardar').click(function(event) {
    /*var btn = $(this);
    var paso = btn.data('step');
    if (paso == 'ins') {
        if (frmdp_edit.length > 0) {*/
            $("#frmins-personales").submit();
        /*} 
    } */
});

$('#vw_rrhh-btn_cancelar').click(function(event) {
  $("#frmins-personales input").attr('disabled', true);
  $("#frmins-personales select").attr('disabled', true);
  $('#vw_rrhh-btn_nuevo').show();
  $('#vw_rrhh-btn_editar').hide();
  $('#vw_rrhh-btn_guardar').hide();
  $('#vw_rrhh-btn_cancelar').hide();
  $("#frmins-personales input").val("");
  $("#frmins-personales select").val("");
  $('.nav-pills a[href="#busqueda"]').tab('show');
  $('#divmsg_sede').html('');
});



$('#vw_rrhh-btn_editar').click(function(event) {
    $('#vw_rrhh-btn_nuevo').hide();
    $('#vw_rrhh-btn_editar').hide();
    $('#vw_rrhh-btn_guardar').show();
    $('#vw_rrhh-btn_cancelar').show();
    $("#frmins-personales input").attr('disabled', false);
    $("#frmins-personales select").attr('disabled', false);
    $('#frmins-personales #fitxtdni,#frmins-personales #fitxtapelpaterno,#frmins-personales #fitxtapelmaterno,#frmins-personales #fitxtnombres,#frmins-personales #ficbtipodoc').attr('disabled', true);
   
});

function call_editar(vidtrabajador) {
   $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
        url: base_url + 'docentes/fn_get_datos_docente_por_codigo',
        type: 'post',
        dataType: 'json',
        data: {
            fitxtcodigo: vidtrabajador
        },
        success: function(e) {
            //tb_persona.per_foto as foto,
            //VALUES
            $('#divboxhistorial #divoverlay').remove();
            if (e.status==true){
                $('.nav-pills a[href="#ficha-personal"]').tab('show');
                llenar_datos_dni(e);
                $('#vw_rrhh-btn_editar').click();
            }
            else{
                $("#frmins-personales input[name!='fitxtdni']").val("");
                $("#frmins-personales select").val("");
                $('#frmins-personales input,select').each(function() {
                      $(this).data('currentvalue', $(this).val());
                })
                $("#frmins-personales #ficbtipodoc").val("DNI");
                $("#frmins-personales #fitxtdni").focus();
                
                $('#frmins-personales #fitxtcoddocente').val("");
                $('#frmins-personales #fidpid').val("");
                $('#vw_rrhh-btn_nuevo').hide();
                $('#vw_rrhh-btn_editar').hide();
                $('#vw_rrhh-btn_guardar').show();
                $('#vw_rrhh-btn_cancelar').show();
                $('#frmins-personales #fitxtidarea').val("");
                /*$.ajax({
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
                });*/
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
}

 

$("#frmins-personales").submit(function(event) {
    /* Act on the event */
    $('#frmins-personales #fitxtdni,#frmins-personales #fitxtapelpaterno,#frmins-personales #fitxtapelmaterno,#frmins-personales #fitxtnombres,#frmins-personales #ficbtipodoc').attr('disabled', false);
    $('#frmins-personales input,select').removeClass('is-invalid');
    $('#frmins-personales .invalid-feedback').remove();
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    /*urlpersonales = base_url + 'docentes/fn_update_datos_docente';
    if ($(this).data('action') == 'insert') urlpersonales = base_url + 'docentes/fn_guardar_datos_docente';*/
    $.ajax({
        url: base_url + 'docentes/fn_guardar_datos_docente',
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
                    title: 'NO SE REGISTRO LOS DATOS',
                    text: "Existen errores en los campos",
                    backdrop:false,
                })
            } else {
                $('#frmins-personales input,select').each(function() {
                    $(this).data('currentvalue', $(this).val());
                })
                $(this).data('action', 'edit');
                 Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'SE REGISTRO LOS DATOS',
                    text: e.msg,
                    backdrop:false,
                })
                frmdp_edit = new Array();
                $("#fispedit").html("");
                   $("#frmins-personales input").attr('disabled', true);
                    $("#frmins-personales select").attr('disabled', true);
                $('#vw_rrhh-btn_nuevo').show();
                $('#vw_rrhh-btn_editar').hide();
                $('#vw_rrhh-btn_guardar').hide();
                $('#vw_rrhh-btn_cancelar').hide();
            }
        },
        error: function(jqXHR, exception) {
            $('#divboxhistorial #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'NO SE REGISTRO LOS DATOS',
                    text: e.msgf,
                    backdrop:false,
                })
        }
    });
    return false;
});

$('.btn-excel').click(function(e) {
    e.preventDefault();
    var vdata = $('#divcard_adminis').find('.rowcolor').length;

    var url = base_url + 'gestion/rrhh/docentes/excel?ap=' + $("#txtbusqueda").val() + '&est=' + $("#txtestado").val();
    
    if (vdata > 0) {
        window.open(url, '_blank');
    }
    
});

$(document).on('click', '.updateactiv', function(e) {
    e.preventDefault();
    btn = $(this);
    fila = btn.closest('.rowcolor');
    codigo = btn.data('codigo');
    flat = btn.data('flat');
    act = btn.data('act');

    var estado = "desactivar";
    var titulo="¿Deseas desactivar este administrativo Seleccionado?";
    if (flat=="activardocente"){
        titulo="¿Deseas activar este administrativo Seleccionado?";
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
            
            $.ajax({
                url: base_url + 'docentes/fn_update_status_docente',
                method: "POST",
                dataType: 'json',
                data: {
                    doccod : codigo,
                    accion: act,
                },
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
                        })

                        btn.removeClass('btn-danger');
                        btn.removeClass('btn-success');

                        if (act == "SI") {
                            fila.find('.msgtooltip').attr('title','Desactivar');
                            btn.addClass('btn-success');
                            btn.data('flat','desactivardocente');
                            btn.data('act','NO');
                            btn.html('<i class="fa fa-toggle-on"></i>');
                        } else {
                            fila.find('.msgtooltip').attr('title','Activar');
                            btn.addClass('btn-danger');
                            btn.data('flat','activardocente');
                            btn.data('act','SI');
                            btn.html('<i class="fa fa-toggle-off"></i>');
                        }
                                                
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
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
      title: 'Aviso: Antes de ingresar una campaña, verifica si no ha sido registrado anteriormente'
    })

    $('#fictxtbuscar').focus();
    var codper = getUrlParameter('cper',"");
    
    if (codper!=""){
        $('#fictxtbuscar').val(codper);
        filtar_campania(codper );
    }
    
});

$('#frm_campania').submit(function() {
    $('#frm_campania input,select').removeClass('is-invalid');
    $('#frm_campania .invalid-feedback').remove();
    $('#divcard-campania').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard-campania #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {

                Swal.fire({
                    title: e.msg,
                    // text: "Por favor Agregue Ejemplares!",
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        $('.nav-pills a[href="#search-campania"]').tab('show');
                        var periodo = $('#ficperiodo').val();
                        $('#fictxtbuscar').val(periodo);
                        filtar_campania($('#fictxtbuscar').val());
                        $('#frm_campania')[0].reset();
                    }
                })
               
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard-campania #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "Por favor Agregue Ejemplares!",
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$('#fictxtbuscar').change(function(event) {
    var ncamp = $('#fictxtbuscar').val();

    var keycode = event.keyCode || event.which;
     
         filtar_campania(ncamp);
    
});
/*$('#btn_busca_cmp').click(function(event) {
    var ncamp = $('#fictxtbuscar').val();
    filtar_campania(ncamp);
});*/

function filtar_campania(codper){
    $('#divcard-campania').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    if (history.pushState) {
          var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?cper=' + codper;
          window.history.pushState({path:newurl},'',newurl);     
    }


    $.ajax({
        url: base_url + 'campania/fn_filtar_campania_x_sede_periodo',
        type: 'post',
        dataType: 'json',
        data: {txtper : codper},
        success: function(e) {
            if (e.status == true) {
                mostrar_resultados(e.datos);
            } else {
                
                var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                $('#divdata-campania').html(msgf);
            }

            $('#divcard-campania #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#divcard-campania #divoverlay').remove();
            $('#divmsgcamp').html(msgf);
        },
    });
}

function mostrar_resultados(datos){
    $('#divcard_data_campania').html("");
                var nro=0;
                var tabla="";
                var vflat="activarcampaña";
                var vtitle="Activar Campaña";
                var vicon="fa fa-toggle-off";
                var btncolor="btn-danger btn-sm";
                var accion= "SI";
                var estado="Inhabilitado";

                var codbase64 = "";
                if (datos.length !== 0) {
                    $('#fmt_conteo').html('');
                    $('#divdata-campania').removeClass('d-none');
                    $.each(datos, function(index, val) {
                        nro++;
                        codbase64 = 'viewupdate("'+val['codigo64']+'")';

                        if (val['activ']==="SI"){
                            vflat = "desactivarcampaña";
                            vtitle = "Desactivar Campaña";
                            vicon = "fa fa-toggle-on";
                            btncolor = "btn-success btn-sm";
                            accion =  "NO";
                            estado = "Habilitado";
                        } else {
                            vflat="activarcampaña";
                            vtitle="Activar Campaña";
                            vicon="fa fa-toggle-off";
                            btncolor="btn-danger btn-sm";
                            accion= "SI";
                            estado="Inhabilitado";
                        }

                        tabla=tabla + 
                            "<div class='row rowcolor cfila' data-campania='"+val['nombre']+"'>"+
                                "<div class='col-12 col-md-4'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                        "<div class='col-4 col-md-4 td'>"+val['codperiodo']+"</div>"+
                                        "<div class='col-6 col-md-6 td'> ("+ val['id'] +") "+ val['nombre']+"<br><span class='small'>("+val['sede']+")</span></div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-4'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-md-8 td'>"+val['descripcion']+"</div>"+
                                        "<div class='col-4 col-md-4 td'>"+val['fechaini']+"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-4 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-sm-4 col-md-4 td'>"+
                                            "<span>"+val['fechafin']+"</span>"+
                                        "</div>"+
                                        "<div class='col-4 col-sm-4 col-md-4 td'>"+
                                            "<span data-toggle='tooltip' title='"+vtitle+"'>"+
                                                "<a data-flat='"+vflat+"' data-idc='"+val['codigo64']+"' data-act='"+accion+"' class='btn "+btncolor+" updateactivcamp' href='#'>"+
                                                    "<i class='"+vicon+"'></i><span class='d-block d-md-none'>"+estado+"</span>"+
                                                "</a>"+
                                            "</span>"+
                                        "</div>"+
                                        "<div class='col-4 col-sm-4 col-md-4 td'>"+
                                            "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                "<div class='btn-group'>"+
                                                    "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                        "<i class='fas fa-cog'></i>"+
                                                    "</a>"+
                                                    "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                        "<a class='dropdown-item' href='#' title='Editar' onclick='"+codbase64+"'>"+
                                                            "<i class='fas fa-edit mr-2'></i> Editar"+
                                                        "</a>"+
                                                            "<a class='dropdown-item text-danger deletecampania' href='#' title='Eliminar' data-idcamp='"+val['codigo64']+"'>"+
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

                $('#divcard_data_campania').html(tabla);
}

function viewupdate(codigo){
    $('#divcad_campania').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#msgcuerpo").html("");
        $.ajax({
            url: base_url + "campania/vwmostrar_campaniaxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcod: codigo},
            success: function(e) {
                $('#divcad_campania #divoverlay').remove();
                $("#msgcuerpo").html(e.campaup);
                $("#modal-lg").modal("show");
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcad_campania #divoverlay').remove();
                $("#modal-lg modal-body").html(msgf);
            } 
        });
    return false;
}

$('#btnactcam').click(function() {
    $('#frm_edit_campania input,select').removeClass('is-invalid');
    $('#frm_edit_campania .invalid-feedback').remove();
    $('#divmodalcamp').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'campania/fn_update_campania',
        type: 'post',
        dataType: 'json',
        data: $('#frm_edit_campania').serialize(),
        success: function(e) {
            $('#divmodalcamp #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                $('#modal-lg').modal('hide');
                
                Swal.fire({
                    title: e.msg,
                    // text: "Por favor Agregue Ejemplares!",
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        filtar_campania($('#fictxtbuscar').val());
                    }
                })

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodalcamp #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "Por favor Agregue Ejemplares!",
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$(document).on("click", ".updateactivcamp", function(){
    btn = $(this);
    idcamp = btn.data('idc');
    flat = btn.data('flat');
    act = btn.data('act');

    var estado = "desactivar";
    var titulo="¿Deseas desactivar la campaña Seleccionada?";
    if (flat=="activarcampaña"){
        titulo="¿Deseas activar la campaña Seleccionada?";
        estado = "activar";
    }

    Swal.fire({
        title: titulo,
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, '+estado+' campaña!'
    }).then(function(result){
        if(result.value){
            $('#divcard-campania').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var datos = new FormData();
            datos.append("idcamp", idcamp);
            datos.append("activo", act);
            
            $.ajax({
                url: base_url + 'campania/fn_update_activo',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(e){
                    $('#divcard-campania #divoverlay').remove();
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

                              filtar_campania($('#fictxtbuscar').val());

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
                    $('#divcard-campania #divoverlay').remove();
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

$(document).on("click", ".deletecampania", function(){
    btn = $(this);
    idcamp = btn.data('idcamp');
    var campania = $(this).closest('.rowcolor').data('campania');  
    Swal.fire({
        title: "¿Deseas eliminar la campaña "+campania+"?",
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar campaña!'
    }).then(function(result){
        if(result.value){
            $('#divcard-campania').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var datos = new FormData();
            datos.append("idcampa", idcamp);
            
            $.ajax({
                url: base_url + 'campania/fneliminarcamp',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(e){
                    $('#divcard-campania #divoverlay').remove();
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

                                filtar_campania($('#fictxtbuscar').val());

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
                    $('#divcard-campania #divoverlay').remove();
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
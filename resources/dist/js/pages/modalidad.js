
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
      title: 'Aviso: Antes de agregar una modalidad, verifica si no ha sido registrado anteriormente'
    })

    filtro_modalidades('');
});

$('#frm_modalidad').submit(function() {
    $('#frm_modalidad input,select').removeClass('is-invalid');
    $('#frm_modalidad .invalid-feedback').remove();
    $('#divcard_modalidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard_modalidad #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        $('#frm_modalidad')[0].reset();
                        $('.nav-pills a[href="#search-modalidad"]').tab('show');
                        filtro_modalidades('');
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_modalidad #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$('#modal-edit-mod').on('show.bs.modal', function (e) {
    var rel=$(e.relatedTarget);
    var idmod=rel.data('idmod');
    var nomod=rel.data('nom');
    
    $('#fictxtidmod').val(idmod);
    $('#fitxtmoded').val(nomod);
});

$('#btnactmod').click(function() {
    $('#frm_edit_modalidad input,select').removeClass('is-invalid');
    $('#frm_edit_modalidad .invalid-feedback').remove();
    $('#divmodalcamped').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'modalidad/fn_update_modal',
        type: 'post',
        dataType: 'json',
        data: $('#frm_edit_modalidad').serialize(),
        success: function(e) {
            $('#divmodalcamped #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                
                $('#modal-edit-mod').modal('hide');
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        filtro_modalidades('');
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodalcamped #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$(document).on("click", ".updateactiv", function(){
    btn = $(this);
    codmod = btn.data('idmod');
    flat = btn.data('flat');
    act = btn.data('act');

    var estado = "desactivar";
    var titulo="¿Deseas desactivar la modalidad Seleccionada?";
    if (flat=="activarmodalidad"){
        titulo="¿Deseas activar la modalidad Seleccionada?";
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
            $('#divcard_modalidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var datos = new FormData();
            datos.append("idmodal", codmod);
            datos.append("activo", act);
            
            $.ajax({
                url: base_url + 'modalidad/fn_update_activo',
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

                              filtro_modalidades("");

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

$(document).on("click", ".deletemodalidad", function(){
    btn = $(this);
    codmod = btn.data('idmod');
    var modalidad=$(this).closest('.rowcolor').data('modalidad');  
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
            datos.append("idmodal", codmod);
            
            $.ajax({
                url: base_url + 'modalidad/fneliminarmodal',
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

                              filtro_modalidades("");

                            }
                        })
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: 'No se pudo eliminar',
                            type: "error",
                            icon: "error",
                            allowOutsideClick: false,
                            confirmButtonText: "¡Cerrar!"
                        });
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

function filtro_modalidades(nomodalidad) {
    $('#divcard_modalidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'modalidad/search_modalidad',
        type: 'post',
        dataType: 'json',
        data: {nomodalidad : nomodalidad},
        success: function(e) {
            if (e.status == true) {
                $('#divcard_data_modalidad').html("");
                var nro=0;
                var tabla="";
                var vflat="activarmodalidad";
                var vtitle="Activar Modalidad";
                var vicon="fa fa-toggle-off";
                var btncolor="btn-danger btn-sm btn-block";
                var accion= "SI";
                var estado="Inhabilitado";
                var codbase64 = "";
                if (e.datos.length !== 0) {
                    $('#fmt_conteo').html('');
                    $.each(e.datos, function(index, val) {
                        nro++;
                        codbase64 = 'viewupdatcarr("'+val['codigo64']+'")';

                        if (val['activo']==="SI"){
                            vflat = "desactivarmodalidad";
                            vtitle = "Desactivar Modalidad";
                            vicon = "fa fa-toggle-on";
                            btncolor = "btn-success btn-sm";
                            accion =  "NO";
                            estado = "Habilitado";
                        } else {
                            vflat="activarmodalidad";
                            vtitle="Activar Modalidad";
                            vicon="fa fa-toggle-off";
                            btncolor="btn-danger btn-sm";
                            accion= "SI";
                            estado="Inhabilitado";
                        }


                        tabla=tabla + 
                            "<div class='row rowcolor cfila' data-modalidad='"+val['nombre']+"'>"+
                                "<div class='col-12 col-md-8'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                        "<div class='col-10 col-md-10 td'>"+val['nombre']+"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-4 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-6 col-sm-6 col-md-6 td'>"+
                                            "<span data-toggle='tooltip' title='"+vtitle+"'>"+
                                                "<a data-flat='"+vflat+"' data-idmod='"+val['codigo64']+"' data-act='"+accion+"' class='btn "+btncolor+" updateactiv' href='#'>"+
                                                    "<i class='"+vicon+"'></i>"+
                                                "</a>"+
                                            "</span>"+
                                        "</div>"+
                                        "<div class='col-6 col-sm-6 col-md-6 td'>"+
                                            "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                "<div class='btn-group'>"+
                                                    "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                        "<i class='fas fa-cog'></i>"+
                                                    "</a>"+
                                                    "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                        "<a class='dropdown-item' href='#' title='Editar' data-idmod='"+val['codigo64']+"' data-nom='"+val['nombre']+"' data-toggle='modal' data-target='#modal-edit-mod'>"+
                                                            "<i class='fas fa-pencil-alt mr-2'></i> Editar"+
                                                        "</a>"+
                                                            "<a class='dropdown-item text-danger deletemodalidad' href='#' title='Eliminar' data-idmod='"+val['codigo64']+"'>"+
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

                $('#divcard_data_modalidad').html(tabla);
                
            } else {
                
                var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                $('#divcard_data_modalidad').html(msgf);
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

$(document).ready(function() {

    // const Toast = Swal.mixin({
    //   toast: true,
    //   position: 'top-end',
    //   showConfirmButton: false,
    //   timer: 5000,
    //   // timerProgressBar: true,
    // })

    // Toast.fire({
    //   type: 'info',
    //   icon: 'info',
    //   title: 'Aviso: Antes de ingresar una campaña, verifica si no ha sido registrado anteriormente'
    // })
    get_data_departamentos('','departamento');
    
});

// SCRIPT DEPARTAMENTO
$('#frm_departam').submit(function() {
    $('#frm_departam input,select').removeClass('is-invalid');
    $('#frm_departam .invalid-feedback').remove();
    $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard_ubigeo #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#frm_departam #' + key).addClass('is-invalid');
                    $('#frm_departam #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        $('.nav-pills a[href="#datos-dep"]').tab('show');
                        get_data_departamentos('','departamento');
                        $('#frm_departam')[0].reset();
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_ubigeo #divoverlay').remove();
            Swal.fire({
                title: e.msg,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$('#modal-edita').on('show.bs.modal', function (e) {
    var rel=$(e.relatedTarget);
    var idub=rel.data('id');
    var nomub=rel.data('nom');
    $("#fitxtidep").val(idub);
    $("#fitxtdeped").val(nomub);
})

$('#btnactdep').click(function() {
    $('#frm_edit_depar input,select').removeClass('is-invalid');
    $('#frm_edit_depar .invalid-feedback').remove();
    $('#divmodaldepa').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'ubigeo/fn_update_depart',
        type: 'post',
        dataType: 'json',
        data: $('#frm_edit_depar').serialize(),
        success: function(e) {
            $('#divmodaldepa #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#frm_edit_depar #' + key).addClass('is-invalid');
                    $('#frm_edit_depar #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                $('#modal-edita').modal('hide');
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        get_data_departamentos('','departamento');
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodaldepa #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$(document).on("click", ".deletedepart", function(){
    btn = $(this);
    iddept = btn.data('iddepart');
    var nombre = $(this).closest('.rowcolor').data('departam');  
    Swal.fire({
        title: "¿Deseas eliminar el departamento "+nombre+"?",
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar!'
    }).then(function(result){
        if(result.value){
            $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var datos = new FormData();
            datos.append("iddepart", iddept);
            
            $.ajax({
                url: base_url + 'ubigeo/fneliminardepart',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(e){
                    $('#divcard_ubigeo #divoverlay').remove();
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
                                get_data_departamentos('','departamento');
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
                    $('#divcard_ubigeo #divoverlay').remove();
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

// FIN SCRIPT DEPARTAMENTO

// SCRIPT PROVINCIA
$('#frm_provinc').submit(function() {
    $('#frm_provinc input,select').removeClass('is-invalid');
    $('#frm_provinc .invalid-feedback').remove();
    $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard_ubigeo #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#frm_provinc #' + key).addClass('is-invalid');
                    $('#frm_provinc #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        $('.nav-pills a[href="#datos-prov"]').tab('show');
                        var departamento = $('#ficdepart').val();
                        $('#ficfiltprovin').val(departamento);
                        get_data_provincia(departamento,'provincia');
                        $('#frm_provinc')[0].reset();
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_ubigeo #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$('#btn_filprov').click(function(event) {
    var nprovin = $('#ficfiltprovin').val();
    get_data_provincia(nprovin,'provincia');
})

$('#modal-edita-prov').on('show.bs.modal', function (e) {
    var rel=$(e.relatedTarget);
    var idpr=rel.data('id');
    var nompr=rel.data('nom');
    var codep=rel.data('dpt');
    $("#fitxtidpr").val(idpr);
    $("#fitxtproved").val(nompr);
    $('#ficdeped').val(codep);
})

$('#btnactprov').click(function() {
    $('#frm_edit_provinc input,select').removeClass('is-invalid');
    $('#frm_edit_provinc .invalid-feedback').remove();
    $('#divmodalprov').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'ubigeo/fn_update_prov',
        type: 'post',
        dataType: 'json',
        data: $('#frm_edit_provinc').serialize(),
        success: function(e) {
            $('#divmodalprov #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#frm_edit_provinc #' + key).addClass('is-invalid');
                    $('#frm_edit_provinc #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                $('#modal-edita-prov').modal('hide');
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        get_data_provincia($('#ficfiltprovin').val(),'provincia');
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodaldepa #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$(document).on("click", ".deleteprovin", function(){
    btn = $(this);
    idprovin = btn.data('idprov');
    var nombre = $(this).closest('.rowcolor').data('provincia');  
    Swal.fire({
        title: "¿Deseas eliminar la provincia "+nombre+"?",
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar!'
    }).then(function(result){
        if(result.value){
            $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var datos = new FormData();
            datos.append("idprov", idprovin);
            
            $.ajax({
                url: base_url + 'ubigeo/fneliminarprovc',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(e){
                    $('#divcard_ubigeo #divoverlay').remove();
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
                                get_data_provincia($('#ficfiltprovin').val(),'provincia');
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
                    $('#divcard_ubigeo #divoverlay').remove();
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

// FIN SCRIPT PROVINCIA

// SCRIPT DISTRITO
$('#frm_distr').submit(function() {
    $('#frm_distr input,select').removeClass('is-invalid');
    $('#frm_distr .invalid-feedback').remove();
    $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard_ubigeo #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#frm_distr #' + key).addClass('is-invalid');
                    $('#frm_distr #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        $('.nav-pills a[href="#datos-dist"]').tab('show');
                        var provincia = $('#ficprovinc').val();
                        $('#ficfiltdistrito').val(provincia);
                        get_data_distrito(provincia,'distrito');
                        $('#frm_distr')[0].reset();
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_ubigeo #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$('#btn_fildistrito').click(function(event) {
    var ndistrit = $('#ficfiltdistrito').val();
    get_data_distrito(ndistrit,'distrito');
})

$('#frm_distr input,select').change(function(event) {
    if ($(this).attr('id') == "ficdepartam") {
        $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#frm_distr #ficprovinc').html("<option value='0'>Sin opciones</option>");
        var coddepa = $(this).val();
        $.ajax({
            url: base_url + 'ubigeo/fn_provincia_x_departamento',
            type: 'post',
            dataType: 'json',
            data: {
                txtcoddepa: coddepa
            },
            success: function(e) {
                $('#divcard_ubigeo #divoverlay').remove();
                $('#frm_distr #ficprovinc').html(e.vdata);
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#frm_distr #ficprovinc').html("<option value='0'>" + msgf + "</option>");
            }
        });
    }
});

$('#modal-edita-dist').on('show.bs.modal', function (e) {
    var rel=$(e.relatedTarget);
    var idist=rel.data('id');
    var nomist=rel.data('nom');
    var codprv=rel.data('prvc');
    var codepart = rel.data('depart');
    $('#divmodaldist').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('#ficdepedist').val(codepart);
    fn_combo_ubigeo_modal($('#modal-edita-dist #ficdepedist'), "modal-edita-dist");
    setTimeout(function() {
        $('#modal-edita-dist #ficproved').val(codprv);
        $("#fitxtidist").val(idist);
        $("#fitxtdisted").val(nomist);
        fn_combo_ubigeo_modal($('#modal-edita-dist #ficproved'), "modal-edita-dist");
        $("#modal-edita-dist #divmodaldist #divoverlay").remove();

    },1000);
    
})

$('#btnactdist').click(function() {
    $('#frm_edit_distrit input,select').removeClass('is-invalid');
    $('#frm_edit_distrit .invalid-feedback').remove();
    $('#divmodaldist').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'ubigeo/fn_update_distr',
        type: 'post',
        dataType: 'json',
        data: $('#frm_edit_distrit').serialize(),
        success: function(e) {
            $('#divmodaldist #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#frm_edit_distrit #' + key).addClass('is-invalid');
                    $('#frm_edit_distrit #' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                
                $('#modal-edita-dist').modal('hide');
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        get_data_distrito($('#ficfiltdistrito').val(),'distrito');
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodaldepa #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$(document).on("click", ".deletedistrito", function(){
    btn = $(this);
    iddistri = btn.data('idistr');
    var nombre = $(this).closest('.rowcolor').data('distrito');  
    Swal.fire({
        title: "¿Deseas eliminar el distrito "+nombre+"?",
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar!'
    }).then(function(result){
        if(result.value){
            $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var datos = new FormData();
            datos.append("idistrit", iddistri);
            
            $.ajax({
                url: base_url + 'ubigeo/fneliminardistr',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(e){
                    $('#divcard_ubigeo #divoverlay').remove();
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
                                get_data_distrito($('#ficfiltdistrito').val(),'distrito');
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
                    $('#divcard_ubigeo #divoverlay').remove();
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

// FIN SCRIPT DISTRITO

function get_data_departamentos(nombre, ubigeo) {
    $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'ubigeo/search_data_ubigeo',
        type: 'post',
        dataType: 'json',
        data: {nomdep : nombre, txtubigeo:ubigeo},
        success: function(e) {
            if (e.status == true) {
                $('#divcard_data_departam').html("");
                var nro=0;
                var tabla="";
                if (e.datos.length !== 0) {
                    $('#fmt_conteo').html('');
                    $.each(e.datos, function(index, val) {
                        nro++;

                        tabla=tabla + 
                            "<div class='row rowcolor cfila' data-departam='"+val['nombre']+"'>"+
                                "<div class='col-12 col-md-9'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                        "<div class='col-4 col-md-10 td'>"+val['nombre']+"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-sm-12 col-md-12 td'>"+
                                            "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                "<div class='btn-group'>"+
                                                    "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                        "Acciones <i class='fas fa-cog'></i>"+
                                                    "</a>"+
                                                    "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                        "<a class='dropdown-item' href='#' title='Editar' data-id='"+val['codigo']+"' data-nom='"+val['nombre']+"' "+
                                                        "data-acc='depart' data-toggle='modal' data-target='#modal-edita'>"+
                                                            "<i class='fas fa-edit mr-2'></i> Editar"+
                                                        "</a>"+
                                                            "<a class='dropdown-item text-danger deletedepart' href='#' title='Eliminar' data-iddepart='"+val['codigo64']+"'>"+
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

                $('#divcard_data_departam').html(tabla);
            } else {
                
                var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                $('#datos-dep').html(msgf);
            }

            $('#divcard_ubigeo #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#divcard_ubigeo #divoverlay').remove();
            $('#datos-dep').html(msgf);
        },
    });
}

function get_data_provincia(nombre, ubigeo) {
    $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'ubigeo/search_data_ubigeo',
        type: 'post',
        dataType: 'json',
        data: {nomdep : nombre, txtubigeo:ubigeo},
        success: function(e) {
            if (e.status == true) {
                $('#divcard_data_provincia').html("");
                var nro=0;
                var tabla="";
                if (e.datos.length !== 0) {
                    $('#fmt_conteoprov').html('');
                    $.each(e.datos, function(index, val) {
                        nro++;

                        tabla=tabla + 
                            "<div class='row rowcolor cfila' data-provincia='"+val['nombre']+"'>"+
                                "<div class='col-12 col-md-8'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                        "<div class='col-10 col-md-10 td'>"+val['nombre']+"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-4 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-6 col-md-6 td'>"+val['nomdepart']+"</div>"+
                                        "<div class='col-6 col-sm-6 col-md-6 td'>"+
                                            "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                "<div class='btn-group'>"+
                                                    "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                        "Acciones <i class='fas fa-cog'></i>"+
                                                    "</a>"+
                                                    "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                        "<a class='dropdown-item' href='#' title='Editar' data-id='"+val['codigo']+"' data-nom='"+val['nombre']+"' "+
                                                        "data-dpt='"+val['departm']+"' data-acc='depart' data-toggle='modal' data-target='#modal-edita-prov'>"+
                                                            "<i class='fas fa-edit mr-2'></i> Editar"+
                                                        "</a>"+
                                                            "<a class='dropdown-item text-danger deleteprovin' href='#' title='Eliminar' data-idprov='"+val['codigo64']+"'>"+
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
                    $('#fmt_conteoprov').html('No se encontraron resultados');
                }

                $('#divcard_data_provincia').html(tabla);
            } else {
                
                var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                $('#divdata-provincia').html(msgf);
            }

            $('#divcard_ubigeo #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#divcard_ubigeo #divoverlay').remove();
            $('#divdata-provincia').html(msgf);
        },
    });
}

function get_data_distrito(nombre, ubigeo) {
    $('#divcard_ubigeo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'ubigeo/search_data_ubigeo',
        type: 'post',
        dataType: 'json',
        data: {nomdep : nombre, txtubigeo:ubigeo},
        success: function(e) {
            if (e.status == true) {
                $('#divcard_data_distrito').html("");
                var nro=0;
                var tabla="";
                if (e.datos.length !== 0) {
                    $('#fmt_conteodist').html('');
                    $.each(e.datos, function(index, val) {
                        nro++;

                        tabla=tabla + 
                            "<div class='row rowcolor cfila' data-distrito='"+val['nombre']+"'>"+
                                "<div class='col-12 col-md-8'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-2 text-right td'>"+nro+"</div>"+
                                        "<div class='col-10 col-md-5 td'>"+val['nombre']+"</div>"+
                                        "<div class='col-12 col-md-5 td'>"+val['nomprovin']+"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-4 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-6 col-md-6 td'>"+val['nomdepart']+"</div>"+
                                        "<div class='col-6 col-md-6 td'>"+
                                            "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                "<div class='btn-group'>"+
                                                    "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                        "Acciones <i class='fas fa-cog'></i>"+
                                                    "</a>"+
                                                    "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                        "<a class='dropdown-item' href='#' title='Editar' data-id='"+val['codigo']+"' data-nom='"+val['nombre']+"' "+
                                                        "data-prvc='"+val['provc']+"' data-depart='"+val['codepart']+"' data-toggle='modal' data-target='#modal-edita-dist'>"+
                                                            "<i class='fas fa-edit mr-2'></i> Editar"+
                                                        "</a>"+
                                                            "<a class='dropdown-item text-danger deletedistrito' href='#' title='Eliminar' data-idistr='"+val['codigo64']+"'>"+
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
                    $('#fmt_conteodist').html('No se encontraron resultados');
                }

                $('#divcard_data_distrito').html(tabla);
            } else {
                
                var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                $('#divdata-distrito').html(msgf);
            }

            $('#divcard_ubigeo #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#divcard_ubigeo #divoverlay').remove();
            $('#divdata-distrito').html(msgf);
        },
    });
}

function fn_combo_ubigeo_modal(combo,contenedor){
    if (combo.data('tubigeo') == "departamento") {
        var nmprov=combo.data('cbprovincia');
        var nmdist=combo.data('cbdistrito');
        var nmdiv=combo.data('dvcarga');
        $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#' + nmprov).html("<option value='0'>Sin opciones</option>");
        // $('#'+contenedor+' #' + nmdist).html("<option value='0'>Sin opciones</option>");
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
                $('#'+contenedor+' #' + nmprov).html(e.vdata);
            },
            error: function(jqXHR, exception) {
                $('#' + nmdiv + ' #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#'+contenedor+' #' + nmprov).html("<option value='0'>" + msgf + "</option>");
            }
        });
    } 
    
    return false;
}
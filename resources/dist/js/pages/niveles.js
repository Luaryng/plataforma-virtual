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
      title: 'Aviso: Antes de agregar un nivel, verifica si no ha sido registrado anteriormente'
    })

    get_filtro_niveles("");
});

function get_filtro_niveles(nomnivel) {
    $('#divcard_niveles').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'nivel/search_nivel',
        type: 'post',
        dataType: 'json',
        data: {nomnivel : nomnivel},
        success: function(e) {
            if (e.status == true) {
                $('#divcard_data_nivel').html("");
                var nro=0;
                var tabla="";
                if (e.datos.length !== 0) {
                    $('#fmt_conteo').html('');
                    $.each(e.datos, function(index, val) {
                        nro++;

                        tabla=tabla + 
                            "<div class='row rowcolor cfila' data-nivel='"+val['nombre']+"'>"+
                                "<div class='col-12 col-md-9'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-2 text-center td'>"+nro+"</div>"+
                                        "<div class='col-10 col-md-10 td'>"+val['codigo']+" - "+val['nombre']+"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-12 col-sm-12 col-md-12 td'>"+
                                            "<div class='col-12 pt-1 pr-3 text-center'>"+
                                                "<div class='btn-group'>"+
                                                    "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                                        "<i class='fas fa-cog'></i>"+
                                                    "</a>"+
                                                    "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                                                        "<a class='dropdown-item' href='#' title='Editar' data-idniv='"+val['codigo']+"' data-nom='"+val['nombre']+"' data-toggle='modal' data-target='#modal-edit-niv'>"+
                                                            "<i class='fas fa-edit mr-2'></i> Editar"+
                                                        "</a>"+
                                                            "<a class='dropdown-item text-danger deletenivel' href='#' title='Eliminar' data-idniv='"+val['codigo64']+"'>"+
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

                $('#divcard_data_nivel').html(tabla);
            } else {
                
                var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                $('#divcard_data_nivel').html(msgf);
            }

            $('#divcard_niveles #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#divcard_niveles #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        },
    });
}

$('#frm_niveles').submit(function() {
    $('#frm_niveles input,select').removeClass('is-invalid');
    $('#frm_niveles .invalid-feedback').remove();
    $('#divcard_niveles').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard_niveles #divoverlay').remove();
            
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
                        get_filtro_niveles("");
                        $('#frm_niveles')[0].reset();
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_niveles #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$('#modal-edit-niv').on('show.bs.modal', function (e) {
    var rel=$(e.relatedTarget);
    var idniv=rel.data('idniv');
    var nomniv=rel.data('nom');
    
    $('#fictxtidniveled').val(idniv);
    $('#fictxtniveled').val(nomniv);
});

$('#btnactniv').click(function() {
    $('#frm_edit_niveles input,select').removeClass('is-invalid');
    $('#frm_edit_niveles .invalid-feedback').remove();
    $('#divmodalnived').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'nivel/fn_update_niveles',
        type: 'post',
        dataType: 'json',
        data: $('#frm_edit_niveles').serialize(),
        success: function(e) {
            $('#divmodalnived #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {

                $('#modal-edit-niv').modal('hide');

                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                }).then((result) => {
                    if (result.value) {
                        get_filtro_niveles("");
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodalnived #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});

$(document).on("click", ".deletenivel", function(){
    var idnivel = $(this).data("idniv");
    var nivel = $(this).closest('.rowcolor').data('nivel');  
    Swal.fire({
        title: '¿Está seguro de eliminar el nivel '+nivel+'?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar!'
    }).then(function(result){
        if(result.value){
            $('#divcard_niveles').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var datos = new FormData();
            datos.append("idnivel", idnivel);
            
            $.ajax({
                url: base_url + 'nivel/fneliminarniv',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(e){
                    $('#divcard_niveles #divoverlay').remove();
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

                              get_filtro_niveles("");

                            }
                        })
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divcard_niveles #divoverlay').remove();
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

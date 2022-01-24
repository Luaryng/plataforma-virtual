function vw_pw_cm_pr_fn_eliminar_conv(btn) {
    vinid = btn.data('codigo');
    fila=btn.closest('.cfila');

    Swal.fire({
        title: "Precaución",
        text: "¿Deseas eliminar este registro ?",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            $('#divcard_convocatorias').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'convocatorias/fn_delete',
                type: 'POST',
                data: {
                    "codigo": vinid
                },
                dataType: 'json',
                success: function(e) {
                    $('#divcard_convocatorias #divoverlay').remove();
                    if (e.status == true) {
                        Swal.fire(
                            'Eliminado!',
                            'El archivo fue eliminado correctamente.',
                            'success'
                        )
                        fila.remove();
                    } else {
                        Swal.fire(
                            'Error!',
                            e.msg,
                            'error'
                        )
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire(
                        'Error!',
                        msgf,
                        'error'
                    );
                    $('#divcard_convocatorias #divoverlay').remove();
                }
            });
        } else {
            $('#divcard_convocatorias #divoverlay').remove();
        }
    });



    
}


$('#frm_ejempl input,select').change(function(event) {
	rela=$(this);
	var cnt = rela.data('cnt');
	var condic = 'fictipo' + cnt;
    if ($(this).attr('id') == condic) {
        $('#divcard-biblioteca').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');        
        var tip = $(this).val();
        if (tip == 'Virtual') {
            $('#divcard-biblioteca #divoverlay').remove();
            $('#divcar_virtual'+cnt).removeClass('d-none');
            $('#divcar_fisico'+cnt).addClass('d-none');
            $('#divcar_fisico2-'+cnt).addClass('d-none');
            $('#divcar_fisico3-'+cnt).addClass('d-none');
        } else if (tip == 'Fisico') {
            $('#divcard-biblioteca #divoverlay').remove();
            $('#divcar_virtual'+cnt).addClass('d-none');
            $('#divcar_fisico'+cnt).removeClass('d-none');
            $('#divcar_fisico2-'+cnt).removeClass('d-none');
            $('#divcar_fisico3-'+cnt).removeClass('d-none');
        }
    }
});

$('#btnregisejm'+cnt).click(function() {
	
    $('#frm_ejempl input,select').removeClass('is-invalid');
    $('#frm_ejempl .invalid-feedback').remove();
    $('#divcard-biblioteca').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var idlib = $('#fictxtidlib').val();
    $.ajax({
        url: base_url + 'biblioteca/fn_insert_ejemplares',
        type: 'post',
        dataType: 'json',
        data: $('#frm_ejempl'+cnt).serialize() + '&txtidlibro=' + idlib,
        success: function(e) {
            $('#divcard-biblioteca #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
            	$('#btnregisejm'+cnt).addClass('d-none');
                var vltip = $('#fictipo'+cnt).val();
                var vlnk = $('#fictxtlink'+cnt).val();
                var npag = $('#fictxtnpag'+cnt).val();
                var vstd = $('#ficestado'+cnt).val();
                var vubc = $('#fictxtubica'+cnt).val();
                var vsic = $('#ficsituacion'+cnt).val();
                var vproc = $('#ficproced'+cnt).val();
                var vfech = $('#fictxtfecha'+cnt).val();
                var vdoc = $('#fictxtndoc'+cnt).val();
                var vprec = $('#fictxtprecio'+cnt).val();
                var vcom = $('#fictxtordcom'+cnt).val();
                if (vltip == 'Virtual') {
                    $('#divcar_virtual'+cnt).html('<h6>Link: <span class="mt-1">'+vlnk+'</span></h6>');
                } else if (vltip == 'Fisico') {
                    $('#divspanpgn'+cnt).html('<h6>NPag: <span class="mt-1">'+npag+'</span></h6>');
                    $('#divspanest'+cnt).html('<h6>Estado: <span class="mt-1">'+vstd+'</span></h6>');
                    $('#divspanubic'+cnt).html('<h6>Ubicación: <span class="mt-1">'+vubc+'</span></h6>');
                    $('#divspanstcn'+cnt).html('<h6>Situación: <span class="mt-1">'+vsic+'</span></h6>');
                    $('#divspanproc'+cnt).html('<h6>Procedencia: <span class="mt-1">'+vproc+'</span></h6>');
                    $('#divspanfecha'+cnt).html('<h6>Fecha: <span class="mt-1">'+vfech+'</span></h6>');
                    $('#divspandoc'+cnt).html('<h6>N° Doc: <span class="mt-1 text-uppercase">'+vdoc+'</span></h6>');
                    $('#divspanprec'+cnt).html('<h6>Precio: S/. <span class="mt-1">'+vprec+'</span></h6>');
                    $('#divspancomp'+cnt).html('<h6>Ord. Compra: <span class="mt-1 text-uppercase">'+vcom+'</span></h6>');
                }
                $('#divspantip'+cnt).html('<h6>Tipo: <span class="mt-1">'+vltip+'</span></h6>');
                $('#fictipo'+cnt).addClass('d-none');
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000
                })

                Toast.fire({
                  type: 'success',
                  title: e.msg
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard-biblioteca #divoverlay').remove();
            $('#divmsgejmp'+cnt).show();
            $('#divmsgejmp'+cnt).html(msgf);
        }
    });
    return false;
});

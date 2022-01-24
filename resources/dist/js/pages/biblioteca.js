$('#frm_libro').submit(function() {
    $('#frm_libro input,select').removeClass('is-invalid');
    $('#frm_libro .invalid-feedback').remove();
    $('#divcard-biblioteca').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard-biblioteca #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                $('#btnregis').addClass('d-none');
                $('#btnejemp').removeClass('d-none');
                var idlb = e.idlib;
                $('#fictxtidlib').val(idlb);
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                $('#divmsglib').html(msgf);
                Swal.fire(
                  e.msg,
                  'Por favor Agregue Ejemplares!',
                  'success'
                )
                
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard-biblioteca #divoverlay').remove();
            $('#divmsglib').show();
            $('#divmsglib').html(msgf);
        }
    });
    return false;
});

var cnt = 0;
$('#btnejemp').click(function() {
    $('#divcard_ejemplar').html("");
    cnt = cnt + 1;
    var btn = document.getElementById("btnejemp");
    
    $('#divcard-biblioteca').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'biblioteca/vwasignar_ejemplar',
            type: 'post',
            dataType: 'json',
            data: $('#frm_libro').serialize() + '&txtcnt=' + cnt,
            success: function(e) {
                if (e.status == true) {
                    $('#divcard-biblioteca #divoverlay').remove();
                    $('#divcard_ejemplar').before(e.vdata);
                } else {
                    $('#divcard-biblioteca #divoverlay').remove();
                    var msgf = '<span class="text-danger"><i class="fa fa-ban"></i>'+ e.msg +'</span>';
                    $('#divcard_ejemplar').html(msgf);
                }
                
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception);
                $('#divcard-biblioteca #divoverlay').remove();
                $('#divcard_ejemplar').html(msgf);
            },
        });
        return false;
});

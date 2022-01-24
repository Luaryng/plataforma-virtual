$('#divError').hide();
$('#frmlogin').submit(function() {
    $('#divboxlogin').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            if (e.status == false) {
                $('#divboxlogin #divoverlay').remove();
                 $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).after("<div class='invalid-feedback'>" + val +"</div>");
                  });
                $('#divError').show();
                $('#msgError').html(e.msg);
            } else {
                $(location).attr('href', e.destino);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divboxlogin #divoverlay').remove();
            $('#divError').show();
            $('#msgError').html(msgf);
        }
    });
    return false;
});
$(document).ready(function() {
   $("#s-cargando").hide();
   $("#txtuser").focus();
});
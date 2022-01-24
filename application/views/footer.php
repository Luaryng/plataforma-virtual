<?php $vbaseurl=base_url() ?>
<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 1.0.0
  </div>
  <strong>Copyright &copy; 2019 <a href="https://activaclic.com">activaclic.com</a>.</strong>
</footer>

<aside class="control-sidebar control-sidebar-light ">
  <div>
    
  </div>
  <div id="divnotifica" class="p-1">
    
  </div>
</aside>

</div>

<!-- ./wrapper -->
<!-- jQuery -->
<!-- Bootstrap 4 -->
<!-- overlayScrollbars -->
<script src="<?php echo $vbaseurl ?>resources/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $vbaseurl ?>resources/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $vbaseurl ?>resources/dist/js/adminlte.min.js"></script>
<script>
  
$(document).ready(function() {
$('[data-toggle="tooltip"]').tooltip()
$("#s-cargando").hide();
});
$("#md_rpta_documents").on('hidden.bs.modal', function () {
    $('#md_rpta_documents #divfile_view').removeAttr('src');
})
$("#md_rpta_documents").on('show.bs.modal', function (e) {
    //e.preventDefault();
    boton=$(e.relatedTarget);
    //var boton = $(this);
    var archivo = boton.data('file');

    $('#md_en_estudiante').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('#md_rpta_documents').modal();
    //$('#md_rpta_documents #divfile_view').html('<iframe src="http://docs.google.com/gview?url=https://erp.iesap.edu.pe/upload/'+archivo+'&embedded=true" style="width:100%; height:450px;" frameborder="0"></iframe>');
    $('#md_rpta_documents #divfile_view').attr('src', 'https://docs.google.com/gview?url='+base_url+'upload/'+archivo+'&embedded=true');
    setTimeout(function() {
        $('#md_en_estudiante #divoverlay').remove();
        
    },4000);
})

$(".btn-cambiarsede").click(function(event) {

  
    var vidsede=$(this).data("idsede");
    var vnomsede=$(this).data("sede");
    $.ajax({
        url: base_url + 'usuario/fn_cambiar_sede',
        type: 'post',
        dataType: 'json',
        data: {txtidsede:vidsede,txtnomsede:vnomsede},
        success: function(e) {
            if (e.status == false) {
                Swal.fire('Error!',e.msg,'error');
            } else {
                location.reload();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_depart #divoverlay').remove();
            $('#divmsgdepart').show();
            $('#divmsgdepart').html(msgf);
        }
    });

});


//NOTIFICACIONES
var refreshTime = 600000; // every 10 minutes in milliseconds // = 10 minutos
//var urlRefreshv=base_url + "index/refrescarsesion";
function getTotalNotifica(){
    $.ajax({
        url: base_url + 'usuario/fn_get_total_notifica_x_user',
        type: 'post',
        dataType: 'json',        
        success: function(e) {
            if (e.status == true) {
              var vspan='<span class="badge badge-danger navbar-badge">' + e.notificat + '</span>'
              if (e.notificat==0) vspan="";
              if (parseInt($("#btncontrolbar").data('total'))!=e.notificat){
                $("#btncontrolbar").data('total', e.notificat);
                $("#btncontrolbar").data('sincro', 'SI' );
              }
              $("#btncontrolbar").html('<i class="far fa-bell"></i>' + vspan);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_depart #divoverlay').remove();
            $('#divmsgdepart').show();
            $('#divmsgdepart').html(msgf);
        }
    });
}

window.setInterval( function() {
    getTotalNotifica();
}, refreshTime ); 

var controlsidebarstatus=false;
$("#btncontrolbar").click(function(event) {
    event.preventDefault();
    $(this).ControlSidebar('toggle');
    controlsidebarstatus=(controlsidebarstatus===true) ? false: true;
    if ((controlsidebarstatus==true) && ($(this).data('sincro')=='SI')){
        $("#divnotifica").html('<br><span class="d-block text-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></span>')
        $.ajax({
            url: base_url + 'usuario/fn_get_notificaciones_x_user',
            type: 'post',
            dataType: 'json',        
            success: function(e) {
                
                if (e.status == false) {
                    $("#divnotifica").html("");
                } else {
                    $("#divnotifica").html("");
                    $.each(e.notifica, function(index, v) {
                        $("#divnotifica").prepend("<div class=' p-2 rowcolor'>" +
                                                "<a href='" + v['linkc'] +  "''>" +
                                                "<small><i class='fas fa-envelope mr-2'></i>" + v['detalle'] +   
                                                "<span class='d-block text-right text-muted'>" + v['fecha'] + "</span></small></a></div>");


                    });
                    if ($("#divnotifica").html()=="")  $("#divnotifica").html("<span>No hay nuevas notificaciones</span>");
                    $("#btncontrolbar").data('sincro','NO');
                    $("#btncontrolbar").data('total','0');
                    $("#btncontrolbar").html('<i class="far fa-bell"></i>');
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard_depart #divoverlay').remove();
                $('#divmsgdepart').show();
                $('#divmsgdepart').html(msgf);
            }
        });
    }
});


</script>
</body>
</html>

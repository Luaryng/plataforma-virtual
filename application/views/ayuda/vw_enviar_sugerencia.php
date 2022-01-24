<style>
    ol li{
        padding-left: 10px;
    }
    .enlace-img{
        float: left;
        margin-right: 20px;
    }
</style>
<?php $vbaseurl=base_url();
?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">-->
<div class="content-wrapper">
    
     <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enviar sugerencia
            <small> a soporte</small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Contacto</a>
                </li>
              <li class="breadcrumb-item active">Enviar sugerencia</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
       <div class="card" id="divcard-send">
            <div class="card-body px-2 px-md-3">
                    <form id="vw_frm_esug" action="" method="post" accept-charset="utf-8">
                        <div class="form-group has-float-label ">
                            <select name="vw_es_cbdestino" id="vw_es_cbdestino" class="form-control">
                                <option data-span="Acerca del funcionamiento de la plataforma virtual, sugerencia de mejoras, reporte de problemas, notificar errores" value="<?php echo base64url_encode("janiorjimenezh@gmail.com") ?>">Soporte Virtual</option>
                               
                            </select>
                            <label for="vw_es_cbdestino">Destino</label>
                            <div id="vw_es_spandestino" class="form-text text-muted border-bottom p-2">
                              Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                            </div>
                        </div>
                        <div class="form-group has-float-label ">
                            <input name="vw_es_asunto" id="vw_es_asunto" class="form-control">
                            <label for="vw_es_cbdestino">Asunto</label>
                        </div>
                        
                        <div class="form-group has-float-label ">
                            <textarea name="vw_es_mensaje" id="vw_es_mensaje" cols="30" rows="10" class="form-control"></textarea>
                            <label for="vw_es_mensaje">Mensaje</label>
                        </div>
                       
                    
                    </form>
                    <div class="form-group">
                        <button id="vw_as_btnenviar" role="button" class="btn btn-primary float-right">
                            Enviar
                        </button>
                    </div>
                    
      
            </div>
        </div>


       
    </section>
</div>
<script>
    $(document).ready(function() {
        $("#vw_es_cbdestino").change(function(event) {
            $("#vw_es_spandestino").html($(this).children("option:selected").data('span'));
        });
        $("#vw_es_cbdestino").change();
    });

    $('#vw_as_btnenviar').click(function() {
        $('#divcard-send').append('<div id="divoverlay" class="overlay" style="background: #fff;"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "sendmail/f_enviar_sugerencia",
            type: 'post',
            dataType: 'json',
            data: $('#vw_frm_esug').serialize(),
            success: function(e) {
                $('#divcard-send #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        title: e.msg,
                        type: 'error',
                    });
                } else {
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                    });
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard-send #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                });
            }
        });
        return false;
    });

    
</script>
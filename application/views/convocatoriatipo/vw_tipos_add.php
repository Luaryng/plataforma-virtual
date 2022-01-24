<?php $vbaseurl=base_url(); 
$ccodigo="0";
$ctitulo="";
$cactivo = "";

if (isset($tipo->codigo))  $ccodigo=base64url_encode($tipo->codigo);
if (isset($tipo->nombre))  $ctitulo=$tipo->nombre;
if (isset($tipo->activo))  $cactivo=$tipo->activo;

?>

<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">
	<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>TIPO CONVOCATORIAS
                    <small>Mantenimiento</small></h1>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>portal-web/convocatorias">Convocatorias</a>
                        </li>
                        <li class="breadcrumb-item active">Mantenimiento</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content">
        <div id="vw_pw_bt_ad_div_principal" class="card">
            <div class="card-body">
                <form id="vw_pw_ad_form_addtip" action="<?php echo $vbaseurl ?>convocatorias_tipo/fn_insert_update" method="post" accept-charset="utf-8">
                    <div class="row mt-2">
                        <input id="vw_pw_bt_ad_fictxtcodigo" name="vw_pw_bt_ad_fictxtcodigo" type="hidden" value="<?php echo $ccodigo ?>">
                        
                        <div class="form-group has-float-label col-12 col-sm-7">
                            <input data-currentvalue='' autocomplete="off" class="form-control" id="vw_pw_bt_ad_fictxttitulo" name="vw_pw_bt_ad_fictxttitulo" type="text" placeholder="Nombre" value="<?php echo $ctitulo ?>" />
                            <label for="vw_pw_bt_ad_fictxttitulo">Nombre</label>
                        </div>
                        <div class="form-group col-12 col-md-5">
                            <label for="checkestado" class="mr-3">Activo:</label>
                            <input  id="checkestado" <?php echo ($cactivo=="SI")?"checked":"" ?> name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                        </div>
                   	</div>
                   	<div class="row mt-2">
                        
                        <div class="col-12 py-2">
                            <div id="vw_pw_bt_ad_divmsgconvoc" class="">
                            </div>
                        </div>
                        <div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>portal-web/convocatorias-tipo" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
                            <button type="submit" id="vw_pw_bt_ad_btn_guardar" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script type="text/javascript">
	$('#vw_pw_ad_form_addtip').submit(function() {
        $('#vw_pw_ad_form_addtip input,select').removeClass('is-invalid');
        $('#vw_pw_ad_form_addtip .invalid-feedback').remove();
        $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#vw_pw_ad_form_addtip').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#vw_pw_ad_form_addtip').serialize(),
            success: function(e) {
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                    $('#vw_pw_bt_ad_divmsgconvoc').html(msgf);

                    Swal.fire(
                        'Exito!',
                        'Los datos fueron guardados correctamente.',
                        'success'
                    );

                    window.location.href = e.redirect;
                     
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });
</script>
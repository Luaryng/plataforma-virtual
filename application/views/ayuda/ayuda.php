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
$tpuser=$_SESSION['userActivo']->tipo;
$tnivel = $_SESSION['userActivo']->codnivel;
?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">-->
<style>
    .divideo p:nth-child(even) {
        margin: 0px;
    }
</style>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
    <div class="modal fade" id="modaddmanual" tabindex="-1" role="dialog" aria-labelledby="modaddmanual" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlemanual">AGREGAR MANUAL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="vw_pw_bt_ad_form_addmanual" action="" method="post" accept-charset="utf-8">
                        <div class="row mt-2">
                            <input id="vw_pw_bt_ad_fictxtcodigo" name="vw_pw_bt_ad_fictxtcodigo" type="hidden" value="0">
                            <input id="vw_pw_bt_ad_fictxttipo" name="vw_pw_bt_ad_fictxttipo" type="hidden" value="">
                            <input id="vw_pw_bt_ad_fictxtorden" name="vw_pw_bt_ad_fictxtorden" type="hidden" value="">
                            <div class="form-group has-float-label col-12 col-sm-12" id="divtitulo">
                                <label for="vw_pw_bt_ad_fictxttitulo">Titulo</label>
                                <textarea data-currentvalue='' autocomplete="off" class="form-control form-control-sm" id="vw_pw_bt_ad_fictxttitulo" name="vw_pw_bt_ad_fictxttitulo" placeholder="Titulo" rows="1"></textarea>
                            </div>

                            <div class="form-group has-float-label col-12 col-sm-6">
                                <label for="vw_pw_bt_ad_fictxtgrupo">Grupo:</label>
                                <input list="ltsgrupos" name="vw_pw_bt_ad_fictxtgrupo" id="vw_pw_bt_ad_fictxtgrupo" class="form-control form-control-sm" placeholder="Grupo" value="">
                                <datalist id="ltsgrupos">
                                    <?php foreach ($manualgr as $key => $grp) {
                                        echo "<option value='$grp->grupo'>";
                                    } ?>
                                </datalist>
                            </div>
                            
                            <div class="form-group has-float-label col-12 col-sm-6">
                                <input data-currentvalue='' autocomplete="off" class="form-control form-control-sm" id="vw_pw_bt_ad_fictxtenlace" name="vw_pw_bt_ad_fictxtenlace" type="text" placeholder="Enlace" value="" />
                                <label for="vw_pw_bt_ad_fictxtenlace">Enlace </label>
                            </div>

                            <div class="col-12 col-md-12">
                                <span class="font-weight-bold h6"><u>¿Quienes pueden visualizarlo?</u></span>
                                <div class="row mt-2" id="itemsacc">
                                    <div class="form-group col-12 col-md-3">
                                        <div  class="icheck-primary ml-2">
                                            <input type="checkbox" value="AD" name="checktipo1" id="checktipo1" class="selectitem">
                                            <label for="checktipo1" class="text">Administrativos</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-2">
                                        <div  class="icheck-primary ml-2">
                                            <input type="checkbox" value="DC" name="checktipo2" id="checktipo2" class="selectitem">
                                            <label for="checktipo2" class="text">Docentes</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-4">
                                        <div  class="icheck-primary ml-2">
                                            <input type="checkbox" value="DA" name="checktipo3" id="checktipo3" class="selectitem">
                                            <label for="checktipo3" class="text">Docentes Administrativos</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-3">
                                        <div  class="icheck-primary ml-2">
                                            <input type="checkbox" value="AL" name="checktipo4" id="checktipo4" class="selectitem">
                                            <label for="checktipo4" class="text">Estudiantes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="vw_pw_bt_ad_btn_guardar" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manuales y Tutoriales
            <small>Docentes</small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><i class="fas fa-compass mr-1"></i> Ayuda</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="card" id="divcard_manuales">
            <div class="card-header">
                <h3 class="card-title text-bold">Manuales</h3>
                <div class="card-tools">
                    <a href="#" data-orden='<?php echo base64url_encode($orden) ?>' data-tipo="MANUAL" class="btn btn-outline-secondary btn_addmanual" id="">
                        <i class="fas fa-plus"></i> Agregar
                    </a>

                    <button id="btn-a-order" data-status='f' type="button" class="btn btn-outline-secondary py-0">
                        <i class="fas fa-sort"></i>
                    </button>
                    <button id="btn-d-order" data-status='f' type="button" class="btn btn-secondary py-0">
                        <i class="fas fa-sort"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php 

                $dominio=str_replace(".", "_",getDominio());

                    echo "<ul class='order-list' id='list-manual'>";

                    $nro = 0;
                    $grupom = "";
                    foreach ($manuales as $key => $tut) {
                        
                        if ($tut->tipo == "MANUAL") {
                            $nro++;
                            $color = ($nro % 2==0) ? "bg-lightgray border border-left-0 border-right-0":"";
                            $codigo64 = base64url_encode($tut->codigo);
                            $arrayAccs = explode(",", $tut->accesos);
                            $btnupdate = "";
                            $btndelete = "";
                            $grupointm = $tut->grupo;
                            if (getPermitido("158")=="SI"){
                                
                                $btnupdate = "<a href='#' data-codigo='$codigo64' data-tipo='$tut->tipo' class='text-dark btn_updatemanual'>
                                                    <i class='fas fa-pencil-alt ml-3'></i>
                                                </a>";
                            }

                            $btndelete = "<a href='#' data-codigo='$codigo64' data-tipo='$tut->tipo' class='text-danger btn_deletemanual'>
                                            <i class='fas fa-trash-alt ml-3'></i>
                                        </a>";

                            for ($i = 0; $i < count($arrayAccs); $i++) {
                                if (($arrayAccs[$i] == $tpuser) || ($arrayAccs[$i] == $tnivel)) {
                                    if ($grupointm != $grupom) {
                                        // if ($grupo != "") echo "</div>";
                                        $grupom = $grupointm;
                                        echo "<div class='row mt-2'>
                                                    <span class='text-bold'>$grupom</span>
                                                </div>
                                            ";
                                    }
                                    
                                echo "<li data-id='$tut->codigo' class='$color mfila'>
                                    <div class='col-12 px-0 py-2'>
                                        <div class='row p-0'>
                                            <div class='col-md-12 col-12 pt-1 ml-2'>
                                                <i class='icon-move fas fa-arrows-alt move mr-2 text-dark'></i>
                                                <a target='_blank' href='$tut->enlace'>
                                                    <img class='mr-1' src='{$vbaseurl}resources/img/icons/p_pdf.png' alt='PDF'>
                                                    <span class='titmanual'>$tut->nombre</span>
                                                </a>
                                                $btnupdate
                                                $btndelete
                                            </div>
                                        </div>
                                    </div>
                                </li>";
                                }
                            }

                        }
                    }
                    echo "</ul>";
                ?> 

            </div>
        </div>

        <div class="card" id="divcard_videos">
            <div class="card-header">
                <h3 class="card-title text-bold">Video Tutoriales</h3>
                <div class="card-tools">
                    <a href="#" data-orden='<?php echo base64url_encode($vorden) ?>' data-tipo="VIDEO" class="btn btn-outline-secondary btn_addmanual">
                        <i class="fas fa-plus"></i> Agregar
                    </a>
                    
                    <button id="btn-a-orderv" data-status='f' type="button" class="btn btn-outline-secondary py-0">
                        <i class="fas fa-sort"></i>
                    </button>
                    <button id="btn-d-orderv" data-status='f' type="button" class="btn btn-secondary py-0">
                        <i class="fas fa-sort"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

            <?php
            echo "<ul class='order-list order-list-vid' id='list-video'>";
            $nro = 0;
            $grupo = "";
            foreach ($manuales as $key => $vid) {
                if ($vid->tipo == "VIDEO") {
                    $nro++;
                    $colorv = ($nro % 2==0) ? "bg-lightgray border border-left-0 border-right-0":"";
                    $codigo64v = base64url_encode($vid->codigo);
                    $arrayAccsv = explode(",", $vid->accesos);
                    $grupoint = $vid->grupo;
                    $nombrevid = strip_tags($vid->nombre);
                    $btnupdatev = "";
                    $btndelete = "";
                    if (getPermitido("158")=="SI"){
                        $btnupdatev = "<a href='#' data-codigo='$codigo64v' data-tipo='$vid->tipo' class='text-dark btn_updatemanual'>
                                        <i class='fas fa-pencil-alt ml-3'></i>
                                    </a>";
                    }

                    $btndelete = "<a href='#' data-codigo='$codigo64v' data-tipo='$vid->tipo' class='text-danger btn_deletemanual'>
                                    <i class='fas fa-trash-alt ml-3'></i>
                                </a>";

                    for ($i = 0; $i < count($arrayAccsv); $i++) {
                        if (($arrayAccsv[$i] == $tpuser) || ($arrayAccsv[$i] == $tnivel)) {
                            if ($grupoint != $grupo) {
                                // if ($grupo != "") echo "</div>";
                                $grupo = $grupoint;
                                echo "<div class='row mt-2'>
                                            <span class='text-bold'>$grupo</span>
                                        </div>
                                    ";
                            }
                           
                        echo "<li data-id='$vid->codigo' class='$colorv mfila'>
                                <div class='col-12 px-0 py-2'>
                                    <div class='row p-0'>
                                        <div class='col-md-12 col-12 pt-1 ml-2'>
                                            <i class='icon-move-vid fas fa-arrows-alt move mr-2 text-dark'></i>
                                            <a target='_blank' href='$vid->enlace'>
                                                <img class='img-fluid mr-2' src='{$vbaseurl}resources/img/icons/p_ytb.png' alt=''>
                                                <span class='titmanual'>$nombrevid</span>
                                            </a>
                                            $btnupdatev
                                            $btndelete
                                        </div>
                                    </div>
                                </div>
                            </li>";
                        }
                    }
                } 
            }
            echo "</ul>";
            ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold">Contáctanos</h3>
            </div>
            <div class="card-body">
                <span class="d-block mb-2">Comunicate con Soporte Virtual usando:</span>
                <a class="btn btn-success" href="https://api.whatsapp.com/send?phone=51983136078&text=Hola%20soporte%20virtual%20ERP,%20pertenezco%20al%20instituto%20%20y%20tengo%20una%20consulta%20%C2%BFpodr%C3%ADas%20ayudarme%3F" target="_blank">
                    <i class="fab fa-whatsapp fa-1x mr-1"></i> WhatsApp
                </a>
               
                <a class="btn btn-warning" href='<?php echo "{$vbaseurl}ayuda/ticket" ?>' target="_blank">
                    <i class="fas fa-ticket-alt mr-1"></i> Ticket
                </a>
                
                <span class="d-block mt-3">Tambien puedes contactarnos al:</span>
                <span class="d-block mt-2 pl-1"><b>Correo:</b> soporte@<?php echo getDominio(); ?></span>
                <span class="d-block mt-2 pl-1"><b>Celular:</b>  983136078</span>
            </div>
        </div>
    </section>
</div>

<?php
echo
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>";
?>
<script type="text/javascript">
    var accion = "ordenar";

    $('.btn_addmanual').click(function(e) {
        e.preventDefault();
        var boton = $(this);
        var orden = boton.data('orden');
        var tipo = boton.data('tipo');
        $('#vw_pw_bt_ad_fictxttipo').val(tipo);
        $('#vw_pw_bt_ad_fictxtorden').val(orden);
        $('#titlemanual').html("AGREGAR "+tipo);
        if (tipo == "VIDEO") {
            $('#vw_pw_bt_ad_fictxttitulo').addClass('vw_pw_bt_textmanual_summer');
            $('#divtitulo').removeClass('has-float-label');
            summertextarea($('.vw_pw_bt_textmanual_summer'));
        } else {
            $('#vw_pw_bt_ad_fictxttitulo').removeClass('vw_pw_bt_textmanual_summer');
            $('#divtitulo').addClass('has-float-label');
        }
        $('#modaddmanual').modal();
    });

    $("#modaddmanual").on('hidden.bs.modal', function () {
        $('.vw_pw_bt_textmanual_summer').summernote('destroy');
        $('.vw_pw_bt_textmanual_summer').text('');
        $('.selectitem').prop('checked', false);

        $('#vw_pw_bt_ad_fictxtcodigo').val('0');
        $('#vw_pw_bt_ad_fictxttipo').val("");
        $('#vw_pw_bt_ad_fictxtorden').val("");
        $('#vw_pw_bt_ad_fictxttitulo').val("");
        $('#vw_pw_bt_ad_fictxtgrupo').val("");
        $('#vw_pw_bt_ad_fictxtenlace').val("");
        $('#titlemanual').html("ACTUALIZAR ");
    })

    values = [];
    accesos = "";
    $('#vw_pw_bt_ad_btn_guardar').click(function() {
        $('#vw_pw_bt_ad_form_addmanual input,select').removeClass('is-invalid');
        $('#vw_pw_bt_ad_form_addmanual .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        
        $("#itemsacc .selectitem").each(function() {
            if (this.checked) {
                items = $(this).val();
                values.push(items)
            }
        });

        if ($('#checktipo1').prop('checked')) {

        } else {
            values.push(0);
        }
        accesos = $.trim(values.join(","));

        fdata=$("#vw_pw_bt_ad_form_addmanual").serializeArray();
        fdata.push({name: 'fictxtaccesos', value: accesos});
        
        $.ajax({
            url: base_url + "ayuda/fn_insert_update",
            type: 'post',
            dataType: 'json',
            data: fdata,
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddmanual').modal('hide');
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    })
                    location.reload();
                    // window.location.href = base_url + "ayuda/tutoriales";
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladd #divoverlay').remove();
                Swal.fire({
                    title: "Error!",
                    text: msgf,
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });

    $('.btn_updatemanual').click(function(e) {
        e.preventDefault();
        var boton = $(this);
        var codigo = boton.data('codigo');
        var tipo = boton.data('tipo');
        // var div = "";
        if (tipo == "MANUAL") {
            div = 'divcard_manuales';
        } else {
            div = 'divcard_videos';
        }
        $("#"+div).append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        
        $.ajax({
            url: base_url + "ayuda/fn_manualxcodigo",
            type: 'post',
            dataType: 'json',
            data: {
                txtcodigo: codigo
            },
            success: function(e) {
                $("#"+div+' #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        title: "Error!",
                        text: "Existen errores",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    $('#vw_pw_bt_ad_fictxtcodigo').val(e.vdata['codigo64']);
                    $('#vw_pw_bt_ad_fictxttipo').val(e.vdata['tipo']);
                    $('#vw_pw_bt_ad_fictxtorden').val(e.vdata['orden64']);
                    $('#vw_pw_bt_ad_fictxttitulo').val(e.vdata['nombre']);
                    $('#vw_pw_bt_ad_fictxtgrupo').val(e.vdata['grupo']);
                    $('#vw_pw_bt_ad_fictxtenlace').val(e.vdata['enlace']);
                    $('#titlemanual').html("ACTUALIZAR "+e.vdata['tipo']);
                    vaccesos = e.vdata['accesos'];
                    daccesos = vaccesos.split(',');
                    
                    $("#itemsacc .selectitem").each(function() {
                        check = $(this);
                        elemento = check.val();
                        for (var i=0; i < daccesos.length; i++) {
                            if (daccesos[i] == elemento) {
                                check.prop('checked', true)
                            }
                        }
                    });

                    if (e.vdata['tipo'] == "VIDEO") {
                        $('#vw_pw_bt_ad_fictxttitulo').addClass('vw_pw_bt_textmanual_summer');
                        $('#divtitulo').removeClass('has-float-label');
                        summertextarea($('.vw_pw_bt_textmanual_summer'));
                    } else {
                        $('#vw_pw_bt_ad_fictxttitulo').removeClass('vw_pw_bt_textmanual_summer');
                        $('#divtitulo').addClass('has-float-label');
                    }
                    
                    $('#modaddmanual').modal();
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $("#"+div+' #divoverlay').remove();
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

    function summertextarea(valor) {
        valor.summernote({
            height: 70,
            placeholder: valor.attr('placeholder'),
            dialogsFade: true,
            lang: 'es-ES',
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                // ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
            ],
            
        });
    }

    $(".order-list").sortable({
        placeholder: "sortable-select",
        cursor: 'crosshair',
        items: "> li",
        cursorAt: { left: 5 },
        delay: 150,
        //containment: "parent",
        start: function(event, ui) {
            ui.item.startPos = ui.item.index();
        },
        stop: function(event, ui) {
            //console.log("Start position: " + ui.item.startPos);
            //console.log("New position: " + ui.item.index());
        },
        update: function(event, ui) {
            arrdata = [];
            $(".order-list li").each(function(index, el) {
                var codind = $(this).data("id");
                var norden = index + 1;
                var myvals = [norden, codind];
                arrdata.push(myvals);
            });
            $('#divcard_manuales').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'ayuda/f_ordenar',
                type: 'post',
                dataType: 'json',
                data: {
                    vaccion: accion,
                    filas: JSON.stringify(arrdata),
                },
                success: function(e) {
                    $('#divcard_manuales #divoverlay').remove();
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: msgf,
                        backdrop: false,
                    });
                },
            });
        },
    });

    $(".order-list").sortable( "disable" );
    $("#list-manual .icon-move").hide();
    $("#btn-d-order").hide();
    $("#list-video .icon-move-vid").hide();
    $("#btn-d-orderv").hide();

    $("#btn-a-order").click(function(event) {
        /* Act on the event */
        $('#divcard_manuales').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        setTimeout(function(){
            var btno=$(this);
            $(".order-list" ).sortable( "enable");
            $("#btn-a-order").hide();
            $("#btn-d-order").show();
            $(".icon-move").show();
            $('#divcard_manuales #divoverlay').remove();
            }, 300);
        
        return false;
    });

    $("#btn-d-order").click(function(event) {
        /* Act on the event */
        $('#divcard_manuales').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        setTimeout(function(){
            $( ".order-list" ).sortable( "disable" );
            $("#btn-d-order").hide();
            $("#btn-a-order").show();
            $(".icon-move").hide();
            $('#divcard_manuales #divoverlay').remove();
        }, 300);
        return false;
    });

    $(".order-list-vid").sortable({
        placeholder: "sortable-select",
        cursor: 'crosshair',
        items: "> li",
        cursorAt: { left: 5 },
        delay: 150,
        //containment: "parent",
        start: function(event, ui) {
            ui.item.startPos = ui.item.index();
        },
        stop: function(event, ui) {
            //console.log("Start position: " + ui.item.startPos);
            //console.log("New position: " + ui.item.index());
        },
        update: function(event, ui) {
            arrdata = [];
            $(".order-list-vid li").each(function(index, el) {
                var codind = $(this).data("id");
                var norden = index + 1;
                var myvals = [norden, codind];
                arrdata.push(myvals);
            });
            $('#divcard_videos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'ayuda/f_ordenar',
                type: 'post',
                dataType: 'json',
                data: {
                    vaccion: accion,
                    filas: JSON.stringify(arrdata),
                },
                success: function(e) {
                    $('#divcard_videos #divoverlay').remove();
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: msgf,
                        backdrop: false,
                    });
                },
            });
        },
    });

    $("#btn-a-orderv").click(function(event) {
        /* Act on the event */
        $('#divcard_videos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        setTimeout(function(){
            var btno=$(this);
            $(".order-list-vid" ).sortable( "enable");
            $("#btn-a-orderv").hide();
            $("#btn-d-orderv").show();
            $(".icon-move-vid").show();
            $('#divcard_videos #divoverlay').remove();
            }, 300);
        
        return false;
    });

    $("#btn-d-orderv").click(function(event) {
        /* Act on the event */
        $('#divcard_videos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        setTimeout(function(){
            $( ".order-list-vid" ).sortable( "disable" );
            $("#btn-d-orderv").hide();
            $("#btn-a-orderv").show();
            $(".icon-move-vid").hide();
            $('#divcard_videos #divoverlay').remove();
        }, 300);
        return false;
    });

    $('.btn_deletemanual').click(function(e) {
        e.preventDefault();
        var boton = $(this);
        var fila = boton.closest('.mfila');
        var codigo = boton.data('codigo');
        var tipo = boton.data('tipo');
        var item = fila.find('.titmanual').html();

        if (tipo == "MANUAL") {
            div = 'divcard_manuales';
        } else {
            div = 'divcard_videos';
        }
        $("#"+div).append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        Swal.fire({
            title: '¿Está seguro de eliminar el item '+item+'?',
            text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'
        }).then(function(result){
            if(result.value){
                $.ajax({
                    url: base_url + "ayuda/fneliminar_manual",
                    type: "POST",
                    dataType: 'json',
                    data: {txtcodigo: codigo},
                    success:function(e){
                        $('#'+div+' #divoverlay').remove();
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
                                   fila.remove()
                                }
                            })
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception,'text');
                        $('#'+div+' #divoverlay').remove();
                        Swal.fire({
                            title: "Error!",
                            text: e.msgf,
                            type: "error",
                            icon: "error",
                            allowOutsideClick: false,
                            confirmButtonText: "¡Cerrar!"
                        });
                    }
                })
            } else {
                $('#'+div+' #divoverlay').remove();
            }
        })
    });

</script>
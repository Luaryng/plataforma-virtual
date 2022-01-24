<?php $vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.css">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>ENCUESTA
                    <small>CREAR</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>monitoreo/estudiantes?tb=e"><i class="fas fa-compass"></i> Monitoreo estudiante</a>
                        </li>
                        
                        <li class="breadcrumb-item active">Crear encuesta</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div id="divcard-listado" class="card border-light">
            <?php
            $vid="-1";
            if (isset($vcencuesta->codigo))  $vid=base64url_encode($vcencuesta->codigo);
            $vcodperiodo="";
            $vnombre="";
            $vdescripcion="";
            $vtipo="C";
            $vobjetivo="C";
            $fvence="";
            $finicia="";
            $vtiempo=0;
            $vmedtiempo=0;
            $vdetalle="";
            $vopcion1="NO";
            $vopcion2="NO";
            $vopcion3="NO";
            $vopcion4="NO";
            $vhalerta= 48;
            if (isset($vcencuesta->detalle))  $vcodperiodo=$vcencuesta->codperiodo;
            if (isset($vcencuesta->nombre))  $vnombre=$vcencuesta->nombre;
            if (isset($vcencuesta->descripcion))  $vdescripcion=$vcencuesta->descripcion;
            if (isset($vcencuesta->detalle))  $vdetalle=$vcencuesta->detalle;
            if (isset($vcencuesta->tipo))  $vtipo=$vcencuesta->tipo;
            if (isset($vcencuesta->objetivo))  $vobjetivo=$vcencuesta->objetivo;
            if (isset($vcencuesta->vence))  $fvence=$vcencuesta->vence;
            if (isset($vcencuesta->inicia))  $finicia=$vcencuesta->inicia;
            if (isset($vcencuesta->tiempo))  $vtiempo=$vcencuesta->tiempo;
            if (isset($vcencuesta->medtiempo))  $vmedtiempo=$vcencuesta->medtiempo;
            if (isset($vcencuesta->opc1))  $vopcion1=$vcencuesta->opc1;
            if (isset($vcencuesta->opc2))  $vopcion2=$vcencuesta->opc2;
            if (isset($vcencuesta->opc3))  $vopcion2=$vcencuesta->opc3;
            if (isset($vcencuesta->opc4))  $vopcion2=$vcencuesta->opc4;
            if (isset($vcencuesta->halerta))  $vopcion2=$vcencuesta->halerta;
            ?>
            <input id="vid" name="vid" type="hidden" value="<?php echo  $vid ?>">
            <div class="card-body px-2 px-sm-3">
                <div class="btable">
                    <div class="thead col-12  d-none d-md-block">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col-md-3 td">N°</div>
                                    <div class="col-md-9 td">PERIODO</div>
                                </div>
                            </div>
                            <div class="col-md-3 td">NOMBRE</div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-4 td">CREADO</div>
                                    <div class="col-md-4 td">INICIO</div>
                                    <div class="col-md-4 td">CIERRE</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6 td">CREADOR</div>
                                    <div class="col-md-6 td">DESCRIPCIÓN.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbody col-12">
                        <?php
                        $agrupacion="";
                        
                        $btnenviar="<i class='far fa-paper-plane'></i>";
                        foreach ($vcpoblacion as $keypc => $vcpb){

                        $ccg=base64url_encode($vcpb->codcarga);
                        $cdv=base64url_encode($vcpb->division);
                        $ng="$vcpb->carrera $vcpb->ciclo Cic. $vcpb->turno $vcpb->codseccion";
                        if ($agrupacion!=$ng){
                        $agrupacion=$ng;
                        echo
                        "<div class='row pt-2'>
                            <h5 class='text-bold text-primary'> <i class='fas fa-users px-1'></i> $agrupacion</h5>
                        </div>"  ;
                        }
                        $nmiembros=0;
                        foreach ($vcnromiembros as $keynm => $vcnm) {
                             if (($vcpb->codcarga==$vcnm->codcarga) && ($vcpb->division==$vcnm->division)){
                                $nmiembros=$vcnm->miembros;
                                unset($vcnromiembros[$keynm]);
                                break;
                            }
                        }
                        $nengeneradas=0;
                        $nencontestadas=0;
                        foreach ($vcencgeneradas as $keynm => $vcge) {
                            if (($vcpb->codcarga==$vcge->codcarga) && ($vcpb->division==$vcge->division)){
                                $nengeneradas=$vcge->enviadas;
                                $nencontestadas=$vcge->contestadas;
                                unset($vcencgeneradas[$keynm]);
                                break;
                            }
                        } 
                        if ($nengeneradas==0){
                            $btnenviar="<a class='vw_cupb_btn_enviar_encu ml-2 text-bold' href='#' data-toggle='tooltip' data-placement='right' title='Enviar encuestas'><i class='far fa-paper-plane fa-lg'></i></a>";
                        }
                        else if ($nmiembros>$nengeneradas){
                            $btnenviar="<a class='vw_cupb_btn_enviar_encu ml-2 text-bold text-danger' data-toggle='tooltip' data-placement='right' href='#' title='Enviar encuestas faltantes'><i class='fas fa-retweet fa-lg'></i></a>";
                        }
                        else{
                         $btnenviar="<span data-toggle='tooltip' data-placement='right'  title='Envio completado' class='ml-2 text-bold text-success'><i class='fas fa-check-circle fa-lg'></i></span>";   
                        }
                        ?>

                        <div class="row cfila" <?php echo "data-cg='$ccg' data-dv='$cdv' data-nm='$nmiembros'"?> >
                            <div class="col-md-2 td">
                                <?php echo $vcpb->plan ?>
                            </div>
                            
                            <div class="col-md-1 td">
                                <?php echo "$vcpb->ciclo - <b>$vcpb->codturno</b> - $vcpb->codseccion$vcpb->division"; ?>
                            </div>
                            <div class="col-md-3 td">
                                <?php echo '<small>'.$vcpb->codcarga.'G'.$vcpb->division.'</small> '.$vcpb->unidad ?>
                            </div>
                            <div class="col-md-2 td text-right">
                                <?php echo "$nencontestadas / <span class='vwcg_sp_generadas'>$nengeneradas</span> / $nmiembros <span class='vwcg_sp_boton'>$btnenviar</span>"?>
                            </div>
                            <div class="col-md-3 td">
                                <?php echo "$vcpb->paterno $vcpb->materno $vcpb->nombres" ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery.ui.touch-punch.min.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script>

$(document).ready(function() {
   $('[data-toggle="tooltip"]').tooltip(); 
});

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
$(".vw_cupb_btn_enviar_encu").click(function(event) {
    var btn=$(this);
    btn.tooltip('dispose');
    event.preventDefault();
    
    var row=btn.closest('.cfila');
    codencu=$("#vid").val();
    codcg=row.data('cg');
    div=row.data('dv');
    row.find('.vwcg_sp_boton').html("<span title='Enviando' class='ml-2 text-bold'><i class='fas fa-spinner fa-pulse'></i></span>");
        $.ajax({
        url: base_url + 'cuestionario_general/fn_enviar_encuestas_dd',
        type: 'POST',
        data: {
            "codencu":codencu,
            "codcg":codcg,
            "div":div,
        } ,
        dataType: 'json',
        success: function(e) {
            
            if (e.status==true){
                Toast.fire({
                    icon: 'success',
                    title: 'Encuestas enviadas correctamente'
                })
                row.find('.vwcg_sp_generadas').html(row.data('nm'));
                row.find('.vwcg_sp_boton').html("<span data-toggle='tooltip' data-placement='right'  title='Envio completado' class='ml-2 text-bold text-success'><i class='fas fa-check-circle fa-lg'></i></span>");
            }
            else{
                /*$.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });*/
                row.find('.vwcg_sp_boton').html("<a class='vw_cupb_btn_enviar_encu ml-2 text-bold text-danger' data-toggle='tooltip' data-placement='right' href='#' title='Enviar encuestas faltantes'><i class='fas fa-retweet fa-lg'></i></a>");
                Swal.fire(
                  'Error!',
                  e.msg,
                  'error'
                )
            }
            
        },
        error: function(jqXHR, exception) {
            $('#divcard-body #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
        }
    })
    return false;
});

$('.checkstiempo').change(function(event) {
    var habilita=$(this).is(':checked');
    var filatiempo=$(this).closest(".row");
    filatiempo.find('.inputstiempo').prop("disabled", !habilita);
    
});

$('.clcheckmostrar').bootstrapToggle();
</script>
<script>

$('#vtextdetalle').summernote({
    height: 200,
    minHeight: 200, // set minimum height of editor
    maxHeight: 800, // set maximum height of editor
    focus: true,
    toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear', 'style']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['list', ['ul', 'ol']],
        ['para', ['paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture']],
        ['otros', ['help', 'codeview']],
    ],
    dialogsFade: true,
    callbacks: {
        onImageUpload: function(image) {
            var txtrt = $(this);
            uploadImage(image[0], txtrt);
        },
        onMediaDelete: function(target) {
            deleteFile(target[0].src);
        }
    }
});
$.summernote.dom.emptyPara = "<div><br></div>"

function uploadImage(image, tarea) {
    var data = new FormData();
    data.append("file", image);
    $.ajax({
        url: base_url + "virtualalumno/uploadimages",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "post",
        success: function(url) {
            var image = $('<img>').attr('src', base_url + url);
            tarea.summernote("insertNode", image[0]);
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function deleteFile(src) {
    $.ajax({
        data: {
            src: src
        },
        type: "POST",
        url: base_url + "virtualalumno/delete_file", // replace with your url
        cache: false,
        success: function(resp) {
            console.log(resp);
        }
    });
}


$("#vw_cuge_btn-guardarcuestionario").click(function(event) {
    $('#divcard-body').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    fdata=$("#frm-insertupdate").serializeArray();
    var html = $('#vtextdetalle').summernote('code');
    fdata.push({name: 'textdetalle', value: html});
    $.ajax({
        url: base_url + 'cuestionario_general/fn_insert_update',
        type: 'POST',
        data: fdata ,
        dataType: 'json',
        success: function(e) {
            $('#divcard-body #divoverlay').remove();
            if (e.status==true){
                Swal.fire(
                  'Exito!',
                  'Los datos fueron guardados correctamente.',
                  'success'
                );
                window.location.href = e.redirect;
            }
            else{
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire(
                  'Error!',
                  e.msg,
                  'error'
                )

            }
        },
        error: function(jqXHR, exception) {
            $('#divcard-body #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
        }
    })
    return false;
});
</script>
   
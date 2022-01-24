<style>

.form-title{
    background-color: #17a2b8;
    color: white;
    padding: 5px 0px 5px 10px;
    margin: 25px -10px 25px -10px;
    font-size: 16px;
}
#vw_mpc_pgBar {
    background-color: #3E6FAD;
    width: 0px;
    height: 15px;
    margin-top: 10px;
    margin-bottom: 10px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -o-border-radius: 5px;
    border-radius: 1px;
    -moz-transition: .25s ease-out;
    -webkit-transition: .25s ease-out;
    -o-transition: .25s ease-out;
    transition: .25s ease-out;
    background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
    background-size: 1rem 1rem;
}
</style>
<?php $vbaseurl=base_url(); 
$vcodigo="0";
$vtitulo="";
$vdescripcion="";
$vtipo = "";
$vanio = "";
$vestado = "";
$vpublicado = "";


if (isset($convocatoria->codigo))  $vcodigo=base64url_encode($convocatoria->codigo);
if (isset($convocatoria->titulo))  $vtitulo=$convocatoria->titulo;
if (isset($convocatoria->detalle))  $vdescripcion=$convocatoria->detalle;
if (isset($convocatoria->tipo))  $vtipo=$convocatoria->tipo;
if (isset($convocatoria->anio))  $vanio=$convocatoria->anio;
if (isset($convocatoria->estado))  $vestado=$convocatoria->estado;
if (isset($convocatoria->publicado))  $vpublicado=$convocatoria->publicado;


?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>CONVOCATORIAS
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
                <form id="vw_pw_ad_form_addCvt" action="<?php echo $vbaseurl ?>convocatorias/fn_insert_update" method="post" accept-charset="utf-8">
                    <div class="row mt-2">
                        <input id="vw_pw_bt_ad_fictxtcodigo" name="vw_pw_bt_ad_fictxtcodigo" type="hidden" value="<?php echo $vcodigo ?>">
                        
                        <div class="form-group has-float-label col-12 col-sm-7">
                            <input data-currentvalue='' autocomplete="off" class="form-control" id="vw_pw_bt_ad_fictxttitulo" name="vw_pw_bt_ad_fictxttitulo" type="text" placeholder="Titulo de publicación" value="<?php echo $vtitulo ?>" />
                            <label for="vw_pw_bt_ad_fictxttitulo">Titulo</label>
                        </div>

                        <div class="form-group has-float-label col-12 col-sm-5">
                            <select name="vw_pw_bt_ad_fictxttipo" id="vw_pw_bt_ad_fictxttipo" class="form-control">
                                <option value="">Selecciones tipo</option>
                                <?php
                                    foreach ($tipos as $key => $value) {
                                        $selectip = ($vtipo == $value->codigo) ? "selected" : "";
                                        echo "<option $selectip value='$value->codigo'>$value->nombre</option>";
                                    }
                                ?>
                                
                            </select>
                            <label for="vw_pw_bt_ad_fictxttipo">Tipo</label>
                        </div>

                        <div class="form-group has-float-label col-12 col-sm-4">
                            <input data-currentvalue='' autocomplete="off" class="form-control" id="vw_pw_bt_ad_fictxtanio" name="vw_pw_bt_ad_fictxtanio" type="text" placeholder="Año" value="<?php echo $vanio ?>" />
                            <label for="vw_pw_bt_ad_fictxtanio">Año</label>
                        </div>

                        <div class="form-group has-float-label col-12 col-sm-4">
                            <select name="vw_pw_bt_ad_fictxtestado" id="vw_pw_bt_ad_fictxtestado" class="form-control">
                                <option <?php echo ($vestado == "VIGENTE") ? "selected" : ""; ?> value="VIGENTE">VIGENTE</option>
                                <option <?php echo ($vestado == "CERRADO") ? "selected" : ""; ?> value="CERRADO">CERRADO</option>
                            </select>
                            <label for="vw_pw_bt_ad_fictxtestado">Estado</label>
                        </div>

                        <div class="form-group has-float-label col-12 col-sm-4">
                            <input type="date" name="vw_pw_bt_ad_fictxtpublicado" id="vw_pw_bt_ad_fictxtpublicado" value="<?php echo $vpublicado ?>" class="form-control">
                            <label for="vw_pw_bt_ad_fictxtpublicado">Fecha Publicado</label>
                        </div>

                        <div class="form-group col-12 col-sm-12">
                            <label for="vw_pw_bt_ad_fictxtdesc">Descripción</label>
                            <textarea data-currentvalue='' class="form-control vw_pw_bt_textarea_summer_conv" id="vw_pw_bt_ad_fictxtdesc" name="vw_pw_bt_ad_fictxtdesc" placeholder="Descripción"><?php echo $vdescripcion ?></textarea>
                        </div>
                    </div>


                    <section id="vw_mpae_sec_adjuntar">
                        <h5 class="form-title">Archivos a Adjuntar</h5>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <div class="col-md-7 has-float-label mb-2">
                                        <input type="text" name="vw_mpc_txt_titulo" id="vw_mpc_txt_titulo" class="form-control" placeholder="Describe el archivo adjunto" maxlength="200" autocomplete="off" >
                                        <label for="vw_mpc_txt_titulo">Describe el archivo adjunto</label>
                                    </div>
                                    <div class="col-md-3">
                                        <button id="vw_mpc_btn_selecionar" role="button" class="btn btn-info"><i class="fas fa-paperclip mr-1"></i>
                                        Seleccionar archivo
                                        </button>
                                        <small class="d-block pt-2" id="vw_mpc_txt_filename"></small>
                                        <input type="file" class="" name="vw_mpc_file" id="vw_mpc_file">
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="vw_mpc_txt_progress"></div>
                                    <div id="vw_mpc_txt_size"></div>
                                    <div id="vw_mpc_txt_type"></div>
                                    <div id="vw_mpc_pgBar"></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <b>(Se permite adjuntar hasta 10 archivos, de 1 en 1, con un máximo de 10 Mb por cada uno) <br>
                                        * Solo se permiten los siguientes tipos de archivo: pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,txt.</b>
                                    </div>
                                    
                                </div>
                            </div>
                            <div id="divcard_items" class="col-12"></div>
                        </div>
                        <div class="row text-bold border-bottom">
                            <div class="col-5">
                                Archivo
                            </div>
                            <div class="col-2">
                                Tamaño
                            </div>
                            <div class="col-5">
                                Descripción
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="vw_mpc_lista">
                          <?php
                            if (count($varchivos) > 0) {
                                // $this->load->view('convocatorias/dtsarchivos', $varchivos);
                                
                                foreach ($varchivos as $key => $value) {
                                    $codigo = base64url_encode($value->coddetalle);
                                    $peso = trim(trim($value->peso,0),'.');
                                    
                                    echo "<div class='row border-bottom rowcolor p-2'>
                                            <div class='col-5'><a class='text-dark' href='{$vbaseurl}portal-web/convocatorias/archivos/$codigo'>$value->archivo <i class='fas fa-download text-success'></i></a></div>
                                            <div class='col-2'>$peso kb</div>
                                            <div class='col-5'>
                                                $value->titulo
                                                <a href='#' class='float-right text-danger' data-id='$codigo' data-link='$value->ruta' onclick='vw_cvt_fn_delfile($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i></a>
                                            </div>
                                        </div>";
                                }
                                
                            }
                          ?>
                        </div>
                        
                    </section>
                    
                    <div class="row mt-2">
                        
                        <div class="col-12 py-2">
                            <div id="vw_pw_bt_ad_divmsgconvoc" class="text-danger">
                            </div>
                        </div>
                        <div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>portal-web/convocatorias" class="btn btn-danger btn-md float-left" >
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
<?php
echo
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>
<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>";
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#vw_mpc_txt_progress').hide();
        $('#vw_mpc_txt_size').hide();
        $('#vw_mpc_txt_type').hide();
      
        $('#vw_mpc_pgBar').hide();
        $("#vw_mpc_file").hide();
    });

    var arrayarchivos=[];
    $('#vw_mpc_file').change(function(){
        if (arrayarchivos.length>=10){
            Swal.fire({
                icon: 'error',
                title: 'Límite de 10 archivos',
                text: 'Solo se puede adjuntar como máximo 10 archivos',
                backdrop: false,
            });
            return;
        }
        $('#vw_mpc_txt_titulo').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        if ($.trim($('#vw_mpc_txt_titulo').val())==""){
            Swal.fire({
                icon: 'warning',
                title: 'Aviso',
                text: 'Ingresa la descripción o nombre del archivo',
                backdrop: false,
                position: 'top-end',
                toast: true,
                background:'#f8f9fa',
                timer: 3000,
                timerProgressBar : true,
                showConfirmButton: false,
            });
            $('#vw_mpc_txt_titulo').addClass('is-invalid');
            $('#vw_mpc_txt_titulo').parent().append("<div class='invalid-feedback'>Ingresa una descripción del archivo</div>");
            $('#vw_mpc_txt_titulo').focus();
        } 
        else {
            $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $("#vw_mpc_file").simpleUpload(base_url+"/convocatorias/fn_upload_file_conv", {
                allowedExts: ["jpg", "jpeg", "png", "txt","pdf","doc","docx","xls","xlsx","xlsm","ppt","pptx"],
                
                maxFileSize: 10485760, //10MB in bytes
                start: function(file){
                    //upload started
                    $('#vw_mpc_txt_filename').html(file.name);
                    $('#vw_mpc_txt_size').html(file.size);
                    $('#vw_mpc_txt_type').html(file.type);

                    $('#vw_mpc_txt_progress').html("");
                    $('#vw_mpc_pgBar').width(0);
                    $('#vw_mpc_txt_progress').show();
                    $('#vw_mpc_pgBar').show();
                },

                progress: function(progress){
                    //received progress
                    $('#vw_mpc_txt_progress').html("Progress: " + Math.round(progress) + "%");
                    $('#vw_mpc_pgBar').width(progress + "%");
                },

                success: function(data){
                    //upload successful
                  
                    $('#vw_mpc_txt_progress').hide();
                    $('#vw_mpc_pgBar').hide();

                    //AGREGAR ARCHIVO A LA LISTA
                    
                    $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                    var newarchivo=[data.link,$('#vw_mpc_txt_filename').html(),$('#vw_mpc_txt_size').html(),$('#vw_mpc_txt_type').html(),$('#vw_mpc_txt_titulo').val()];
                    arrayarchivos.push(newarchivo);
                    " "
                    $('#vw_mpc_lista').append("<div class='row border-bottom rowcolor p-2'>"+
                      "<div class='col-5'> " + $('#vw_mpc_txt_filename').html() +"</div>" + 
                      "<div class='col-2'> " + $('#vw_mpc_txt_size').html() +" kb</div>" + 
                      "<div class='col-5'> " + $('#vw_mpc_txt_titulo').val() +"<a href='#' class='float-right text-danger' data-id='0' data-link='" + data.link + "' onclick='vw_cvt_fn_delfile($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i></a></div>");
                    $('#vw_mpc_txt_titulo').val("");
                    $('#vw_mpc_txt_filename').html("");
                    $('#vw_mpc_txt_titulo').focus();
                },

                error: function(error){
                    //upload failed
                  
                    switch (error.name) {
                        case 'InvalidFileExtensionError':
                            vmsg="Este tipo de archivo no es admitido";
                            break;
                        case 'MaxFileSizeError':
                            vmsg="El peso máximo permitido es de 10MB";
                            break;
                        default:
                            vmsg=error.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: "Error! " + error.name,
                        text: vmsg,
                        backdrop: false,
                    });
                    $('#vw_mpc_txt_filename').html("");
                    $('#vw_mpc_txt_size').html("");
                    $('#vw_mpc_txt_type').html("");
                    $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                }

            });
        }
    });

    function vw_cvt_fn_delfile(btn) {
        var link = btn.data('link');
        var codigo = btn.data('id');
        var n = 0;
        if (codigo == 0) {
            arrayarchivos.forEach(function(afile) {
                if (afile[0] === link) {
                    arrayarchivos.splice(n, 1);
                    btn.closest('.rowcolor').remove();
                    $.ajax({
                        url: base_url + 'convocatorias/fn_delete_file',
                        type: 'POST',
                        data: {
                            "coddetalle": codigo,
                            "link": link 
                        },
                        dataType: 'json',
                        success: function(e) {
                            if (e.status == true) {

                                Swal.fire({
                                    title:'Eliminado!',
                                    text:'El archivo fue eliminado correctamente.',
                                    icon:'success',
                                    backdrop: false,
                                    position: 'bottom-end',
                                    toast: true,
                                    background:'#f8f9fa',
                                    timer: 2000,
                                    timerProgressBar : true,
                                    showConfirmButton: false,
                                });

                            } 
                            else {
                                Swal.fire(
                                    'Error!',
                                    e.msg,
                                    'error'
                                );
                            }
                        },
                        error: function(jqXHR, exception) {
                            var msgf = errorAjax(jqXHR, exception, 'text');
                            Swal.fire(
                                'Error!',
                                msgf,
                                'success'
                            )
                        }
                    });
                }
                n++;
            });
        } else {

            $.ajax({
                url: base_url + 'convocatorias/fn_delete_file',
                type: 'POST',
                data: {
                    "coddetalle": codigo,
                    "link": link 
                },
                dataType: 'json',
                success: function(e) {
                    if (e.status == true) {
                        btn.closest('.rowcolor').remove();
                        Swal.fire({
                            title:'Eliminado!',
                            text:'El archivo fue eliminado correctamente.',
                            icon:'success',
                            backdrop: false,
                            position: 'bottom-end',
                            toast: true,
                            background:'#f8f9fa',
                            timer: 2000,
                            timerProgressBar : true,
                            showConfirmButton: false,
                        });

                    } 
                    else {
                        Swal.fire(
                            'Error!',
                            e.msg,
                            'error'
                        );
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire(
                        'Error!',
                        msgf,
                        'success'
                    )
                }
            });
        }
        

    }

    $('#vw_mpc_btn_selecionar').click(function(event) {
        event.preventDefault();
        $("#vw_mpc_file").trigger('click');
    });

    $('.vw_pw_bt_textarea_summer_conv').summernote({
        height: 180,
        placeholder: 'Escriba Aquí ...!',
        dialogsFade: true,
        lang: 'es-ES',
        toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['list', ['ul', 'ol']],
                    ['para', ['paragraph']],
                    // ['insert', ['link', 'picture', 'video']],
                ],
    });
    
    $("#vw_pw_ad_form_addCvt").submit(function(event) {
        var items = $('.activefile').length;
        $('#vw_pw_ad_form_addCvt input,select,textarea').removeClass('is-invalid');
        $('#vw_pw_ad_form_addCvt .invalid-feedback').remove();
        $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var formData = new FormData($("#vw_pw_ad_form_addCvt")[0]);
         
        formData.append('vw_mpc_archivos', JSON.stringify(arrayarchivos));
        
        $.ajax({
            url: $("#vw_pw_ad_form_addCvt").attr("action"),//$(this).attr("action"),
            type: $("#vw_pw_ad_form_addCvt").attr("method"),//'post',
            dataType: 'json',
            data: formData,
            cache:false,
            contentType:false,
            processData:false,
            success: function(e) {
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    Swal.fire(
                        'Exito!',
                        'Los datos fueron guardados correctamente.',
                        'success'
                    );
                    window.location.href = e.redirect;
                  
                }
            },
            error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
              })
            }
        });
        return false;
    });



</script>
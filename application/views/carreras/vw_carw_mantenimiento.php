<?php
	$vbaseurl=base_url();
    $vppresenta=(isset($carrera->presentacion))?$carrera->presentacion:"";
    $vpcontenido=(isset($carrera->contenido))?$carrera->contenido:"";
    $vpcodcarrera=(isset($carrera->codcarrera))?$carrera->codcarrera:"";
    $vpurl=(isset($carrera->url))?$carrera->url:"";
    $vpcodigo=(isset($carrera->codcarweb))?base64url_encode($carrera->codcarweb):"0";
    $vpduracion=(isset($carrera->duracion))?$carrera->duracion:"";
    $vptitulo=(isset($carrera->titulo))?$carrera->titulo:"";
    $vprequisitos=(isset($carrera->requisitos))?$carrera->requisitos:"";
    $vpperfil=(isset($carrera->perfil))?$carrera->perfil:"";
    $vpcurricula=(isset($carrera->curricula))?$carrera->curricula:"";
    
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_noticias" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-globe mr-1"></i> Programa de Estudio - Portal Web</h3>
		    </div>
		    <div class="card-body">
				<form id="vw_ptpe_frm_programa" method="post" accept-charset='utf-8' role="form" enctype="multipart/form-data">
					
					<div class="row mt-2">
                        <input  class="form-control" id="vw_ptpe_txt_codigo" name="vw_ptpe_txt_codigo" type="hidden" value="<?php echo $vpcodigo ?>"   />
                        <div class="form-group has-float-label col-12 col-sm-6">
                            <select class="form-control" id="vw_ptpe_cb_programa" name="vw_ptpe_cb_programa" type="text" placeholder="Programa" >
                                <?php 
                                    foreach ($carreras as $key => $car) {
                                        $vcodcar64=base64url_encode($car->codcarrera);
                                        $isselcar=($car->codcarrera==$vpcodcarrera)?"selected":"";
                                        echo "<option $isselcar value='$vcodcar64'>$car->nombre</option>";
                                    }
                                ?>
                            </select>
                            <label for="vw_ptpe_cb_programa">Programa</label>
                        </div>

			          	<div class="form-group has-float-label col-12 col-sm-6">
                            <input  class="form-control" id="vw_ptpe_txt_url" name="vw_ptpe_txt_url" type="text" placeholder="URL" value="<?php echo $vpurl ?>"   />
                            <label for="vw_ptpe_txt_url">URL</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-sm-6">
                            <input  class="form-control" id="vw_ptpe_txt_duracion" name="vw_ptpe_txt_duracion" type="text" placeholder="Duración" value="<?php echo $vpduracion ?>"   />
                            <label for="vw_ptpe_txt_duracion">Duración</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-sm-6">
                            <input  class="form-control" id="vw_ptpe_txt_titulo" name="vw_ptpe_txt_titulo" type="text" placeholder="Título" value="<?php echo $vptitulo ?>"   />
                            <label for="vw_ptpe_txt_titulo">Título</label>
                        </div>
			        </div>
			        <div class="row mt-2">
                        <div class="form-group col-12 col-md-12">
                            <label for="vw_ptpe_txt_presentacion">Presentación </label>
                            <textarea  class="form-control" name="vw_ptpe_txt_presentacion" id="vw_ptpe_txt_presentacion" placeholder="Presenta la Carrera"><?php echo  $vppresenta  ?></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col-12 col-md-12">
                            <label for="vw_ptpe_txt_contenido">Contenido </label>
                            <textarea  class="txt_summernote form-control" name="vw_ptpe_txt_contenido" id="vw_ptpe_txt_contenido" placeholder="Contenido"><?php echo  $vpcontenido  ?></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col-12 col-md-12">
                            <label for="vw_ptpe_txt_requisitos">Requisitos </label>
                            <textarea  class="txt_summernote form-control" name="vw_ptpe_txt_requisitos" id="vw_ptpe_txt_requisitos" placeholder="Contenido"><?php echo  $vprequisitos  ?></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col-12 col-md-12">
                            <label for="vw_ptpe_txt_perfil">Perfil </label>
                            <textarea  class="txt_summernote form-control" name="vw_ptpe_txt_perfil" id="vw_ptpe_txt_perfil" placeholder="Contenido"><?php echo  $vpperfil  ?></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col-12 col-md-12">
                            <label for="vw_ptpe_txt_curricula">Curricula </label>
                            <textarea  class="txt_summernote form-control" name="vw_ptpe_txt_curricula" id="vw_ptpe_txt_curricula" placeholder="Contenido"><?php echo  $vpcurricula  ?></textarea>
                        </div>
                    </div>
                   
			        <!--<div class="row mt-2">
						<div class="form-group has-float-label col-12 col-sm-4">
							<input  class="form-control text-uppercase" id="fictxtport" name="fictxtport" type="file" placeholder="Portada" accept="image/x-png,image/gif,image/jpeg" />
							<label for="fictxtport">Portada</label>
						</div>
			        </div>-->
			        <div class="row mt-2">
			        	<div class="col-6">
			        		<div id="divmsgnotic" class="float-left">

							</div>
			        	</div>
			        	<div class="col-6">
			        		<button type="submit" class="btn btn-primary btn-md float-right" id="vw_ptpe_btn_guardar"><i class="fas fa-save">
                            </i> Guardar</button>
			        	</div>
			        </div>
				</form>
		    </div>
		</div>
	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/lang/summernote-es-ES.js"></script>

<script>
$(document).ready(function() {
    $.summernote.dom.emptyPara = "<div><br></div>"
    $('.txt_summernote').summernote({
        height: 200,
        minHeight: 200, // set minimum height of editor
        maxHeight: 800, // set maximum height of editor
        focus: true,
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36'],
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['list', ['ul', 'ol']],
            ['para', ['paragraph']],
            ['insert', ['link', 'picture', 'video']],
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
    

    function uploadImage(image) {
        var data = new FormData();
        data.append("file", image);
        $.ajax({
            url: base_url + "noticias/uploadimages",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "post",
            success: function(url) {
                var image = $('<img>').attr('src', base_url + url);
                $('#fictxtdescripcion').summernote("insertNode", image[0]);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function deleteFile(src) { 
        $.ajax({ 
            data: {src : src}, 
            type: "POST", 
            url: base_url + "noticias/delete_file", // replace with your url 
            cache: false, 
            success: function(resp) { 
                console.log(resp); 
            } 
        }); 
    } 

});
    

$('#vw_ptpe_frm_programa').submit(function() {
    $('#frm_noticias input,select').removeClass('is-invalid');
    $('#frm_noticias .invalid-feedback').remove();
    $('#divcard_noticias').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var formData = new FormData($("#vw_ptpe_frm_programa")[0]);
    //var imgn = $('#fictxtport').val();
    // var desc = $('.divdescripcion').summernote('code');
    //var extension = imgn.split('.').pop();
    //formData.append('extimg',extension);
    //formData.append('fictxtdescripcion',desc);
    $.ajax({
        url: base_url + "carrera_web/fn_guardar",
        type:'post',
        dataType: 'json',
        data: formData,
        cache:false,
        contentType:false,
        processData:false,
        success: function(e) {
            $('#divcard_noticias #divoverlay').remove();
            
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
               /*var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                $('#divmsgnotic').html(msgf);*/
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                });
                //window.location = base_url +"portal-web/noticias";
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divcard_noticias #divoverlay').remove();
            $('#divmsgnotic').show();
            $('#divmsgnotic').html(msgf);
        }
    });
    return false;
});
</script>
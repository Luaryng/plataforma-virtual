<?php
	$vbaseurl=base_url();

?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_noticias" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-globe mr-1"></i> Registro de Noticias</h3>
		    </div>
		    <div class="card-body">
				<form id="frm_noticias" action="<?php echo $vbaseurl ?>noticias/fn_insert_datosnotic" method="post" accept-charset='utf-8' role="form" enctype="multipart/form-data">
					<b class="margin-top-10px text-danger"><i class="fas fa-globe"></i> Noticias</b>
					<div class="row mt-2">
			          	<div class="form-group has-float-label col-12 col-sm-12">
							<input data-currentvalue='' class="form-control" id="fictxttitulo" name="fictxttitulo" type="text" placeholder="Titulo Noticia" />
							<label for="fictxttitulo">Titulo Noticia</label>
						</div>
			        </div>
			        <div class="row mt-2">
			        	<div class="form-group col-12 col-md-12">
			        		<label for="fictxtdescripcion">Descripcion noticia</label>
			        		<textarea data-currentvalue='' class="divdescripcion form-control" name="fictxtdescripcion" id="fictxtdescripcion" placeholder="Escriba el contenido aquí!"></textarea>
			        	</div>
			        </div>
			        <div class="row mt-2">
			        	<?php date_default_timezone_set ('America/Lima'); $fecha = date('Y-m-d'); $hora = date('H:i'); ?>
			        	<div class="form-group has-float-label col-12 col-sm-4">
							<input data-currentvalue='' value="<?php echo $fecha ?>" class="form-control text-uppercase" id="fictxtfecha" name="fictxtfecha" type="date" placeholder="Fecha" />
							<label for="fictxtfecha">Fecha</label>
						</div>
						<div class="form-group has-float-label col-12 col-sm-4">
							<input data-currentvalue='' value="<?php echo $hora ?>" class="form-control text-uppercase" id="fictxthora" name="fictxthora" type="time" placeholder="Hora" />
							<label for="fictxthora">Hora</label>
						</div>
						<div class="form-group has-float-label col-12 col-sm-4">
							<input data-currentvalue='' class="form-control text-uppercase" id="fictxtport" name="fictxtport" type="file" placeholder="Portada" accept="image/x-png,image/gif,image/jpeg" />
							<label for="fictxtport">Portada</label>
						</div>
			        </div>
			        <div class="row mt-2">
			        	<div class="col-6">
			        		<div id="divmsgnotic" class="float-left">

							</div>
			        	</div>
			        	<div class="col-6">
			        		<button type="submit" class="btn btn-primary btn-md float-right" id="btnregisnot"><i class="fas fa-save">
                            </i> Registrar</button>
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
    $('#fictxtdescripcion').summernote({
        height: 200,
        placeholder: 'Escriba Aquí ...!',
        dialogsFade: true,
        lang: 'es-ES',
        callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            }, 
            onMediaDelete : function(target) {
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
    

$('#frm_noticias').submit(function() {
    $('#frm_noticias input,select').removeClass('is-invalid');
    $('#frm_noticias .invalid-feedback').remove();
    $('#divcard_noticias').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var formData = new FormData($("#frm_noticias")[0]);
    var imgn = $('#fictxtport').val();
    // var desc = $('.divdescripcion').summernote('code');
    var extension = imgn.split('.').pop();
    formData.append('extimg',extension);
    // formData.append('fictxtdescripcion',desc);
    $.ajax({
        url:$("#frm_noticias").attr("action"),
        type:$("#frm_noticias").attr("method"),
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
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                $('#divmsgnotic').html(msgf);
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                });
                window.location = base_url +"portal-web/noticias";
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
<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_noticias_edit" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-globe mr-1"></i> Editar Noticia</h3>
		    </div>
		    <div class="card-body">
				<form id="frm_noticias_ed" action="<?php echo $vbaseurl ?>noticias/fn_update_datosnotic" method="post" accept-charset='utf-8' role="form" enctype="multipart/form-data">
					<b class="margin-top-10px text-danger"><i class="fas fa-globe"></i> Noticias</b>
					<?php foreach ($dnoticia as $nted) { ?>
					<div class="row mt-2">
			          	<div class="form-group has-float-label col-12 col-sm-12">
			          		<input type="hidden" name="fictxtid" value="<?php echo base64url_encode($nted->id) ?>">
							<input data-currentvalue='' class="form-control" id="fictxttitulo" name="fictxttitulo" type="text" placeholder="Titulo Noticia" value="<?php echo $nted->titulo ?>" />
							<label for="fictxttitulo">Titulo Noticia</label>
						</div>
			        </div>
			        <div class="row mt-2">
			        	<div class="form-group col-12 col-md-12">
			        		<label for="fictxtdescripcion">Descripcion noticia</label>
			        		<textarea class="divdescripcionedit" name="fictxtdescripcion" id="fictxtdescripcion" placeholder="Descripcion noticia"><?php echo $nted->detalle ?></textarea>
			        	</div>
			        </div>
			        <div class="row mt-2 w-50">
			        	<img class="previsualizarPortada img-fluid mx-auto mb-3" src="<?php echo $vbaseurl ?>upload/noticias/<?php echo $nted->imgp ?>">
			        </div>
			        <div class="row mt-2">
				    	<span class="text-secondary mb-1 ml-2 mb-3">Si no va a cambiar la imagen puede dejar este campo vacío</span>
				    	<div class="form-group has-float-label col-12 col-sm-12">
				    		<input type="hidden" name="fictxtimgexist" value="<?php echo $nted->imgp ?>">
							<input data-currentvalue='' class="form-control text-uppercase" id="fictxtport" name="fictxtport" type="file" placeholder="Portada" accept="image/x-png,image/gif,image/jpeg" />
							<label for="fictxtport">Portada</label>
						</div>
				    </div>
			        <div class="row mt-2">
			        	<div class="col-12">
			        		<div id="divmsgnotic" class="float-left">

							</div>
			        	</div>
			        	<div class="col-12">
			        		<a type="button" href="<?php echo base_url() ?>portal-web/noticias" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
			        		<button type="submit" class="btn btn-primary btn-md float-right" id="btneditnot"><i class="fas fa-save"></i> Guardar</button>
			        	</div>
			        </div>
			    <?php } ?>
			    </form>
		    </div>
		</div>
	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/lang/summernote-es-ES.js"></script>

<script>

$(document).ready(function() {
    $('.divdescripcionedit').summernote({
        height: 250,
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
                $('.divdescripcionedit').summernote("insertNode", image[0]);
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

  	$("input[name='fictxtport']").change(function(){

  		var imagen = this.files[0];

  		var datosImagen = new FileReader;
	    datosImagen.readAsDataURL(imagen);

	    $(datosImagen).on("load", function(event){

	      var rutaImagen = event.target.result;

	      $(".previsualizarPortada").attr("src", rutaImagen);

	    })
	})

	$('#frm_noticias_ed').submit(function() {
	    $('#frm_noticias_ed input,select').removeClass('is-invalid');
	    $('#frm_noticias_ed .invalid-feedback').remove();
	    $('#divcard_noticias_edit').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    var formData = new FormData($("#frm_noticias_ed")[0]);
	    var imgn=$('#fictxtport').val();
	    var desc = $('.divdescripcionedit').summernote('code');
	    var extension = imgn.split('.').pop();
	    formData.append('extimg',extension);
	    formData.append('fictxtdescripcion',desc);
	    $.ajax({
	        url:$("#frm_noticias_ed").attr("action"),
	        type:$("#frm_noticias_ed").attr("method"),
	        dataType: 'json',
	        data: formData,
	        cache:false,
	        contentType:false,
	        processData:false,
	        success: function(e) {
	            $('#divcard_noticias_edit #divoverlay').remove();
	            
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgnotic').html(msgf);
	                $('#modedinot').modal('hide');
	                Swal.fire({
	                    title: e.msg,
	                    type: 'success',
	                }).then((result) => {
	                  if (result.value) {
	                    // location.reload();
	                    window.location = base_url +"administrador/noticias/listado";
	                  }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_noticias_edit #divoverlay').remove();
	            $('#divmsgnotic').show();
	            $('#divmsgnotic').html(msgf);
	        }
	    });
	    return false;
	});
</script>
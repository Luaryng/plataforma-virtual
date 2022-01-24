<link rel="stylesheet" href="<?php echo base_url() ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">
  	<section id="s-cargado" class="content pt-2">
    	<div id="divcard_slide" class="card">
			<div class="card-header">
  				<h3 class="card-title">
  					<i class="fas fa-image"></i>
  					Editar Slider
  				</h3>
			</div>
			<div class="card-body">
              	<form id="frm_updateslider" name="frm_updateslider" action="<?php echo base_url() ?>banner/fn_insert_update" method="post" accept-charset='utf-8'>
                	<input id="fictxtaccion" name="fictxtaccion" type="hidden" value="EDITAR">
                	<input id="fictxtidslide" name="fictxtidslide" type="hidden" value="<?php echo base64url_encode($banner->id) ?>">
                	<div class="row">
                  		<div class="form-group has-float-label col-12 col-sm-12 col-md-12">
                    		<input class="form-control" id="fictitulo" name="fictitulo" type="text" placeholder="Titulo" minlength="3" maxlength="150" value="<?php echo $banner->titulo ?>" />
                    		<label for="fictitulo"> Titulo Slider</label>
                  		</div>
                  		
                	</div>
                	<div class="row">
                		<div class="form-group has-float-label col-12 col-sm-12 col-md-12">
                			<textarea name="fictxtdesc" id="fictxtdesc" class="form-control" placeholder="descripción" rows="4" maxlength="300"><?php echo $banner->descripcion ?></textarea>
                			<label for="fictxtdesc"> Descripción (opcional) </label>
                		</div>
                	</div>
                	<div class="row">
                		<div class="form-group has-float-label col-12 col-sm-12 col-md-12">
                    		<input class="form-control" id="ficurlboton" name="ficurlboton" type="text" placeholder="Url" minlength="3" value="<?php echo $banner->urlb ?>" />
                    		<label for="ficurlboton"> Url </label>
                  		</div>
                		<div class="col-md-4">
                  			<span><b>Mostrar link como boton</b></span>
                  			<div class="form-group mt-2">
								<input  id="checkboton" <?php echo ($banner->statboton=="SI")?"checked":"" ?> name="checkboton" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
							</div>
                  		</div>
                	</div>
                	<div class='row <?php echo ($banner->statboton=="NO") ? "d-none" : "" ?>' id="divboton">
                		<div class="form-group has-float-label col-12 col-sm-12 col-md-12">
                    		<input class="form-control" id="fictextboton" name="fictextboton" type="text" placeholder="texto en boton" minlength="3" value="<?php echo $banner->boton ?>" />
                    		<label for="fictextboton"> Texto en boton </label>
                  		</div>
                	</div>
                	<div class="row mt-2">
						<div class="col-md-12 mb-3">
							<span>
								<b>Tamaño recomendado</b><br>
								  	Ancho: 1280px <br>
									Alto: 450px <br>
									<b>Formatos aceptados</b><br>
								  	JPG: Es mas liviano y permite una carga veloz de la página <br>
									PNG: Suelen ser mas pesadas
							</span>
						</div>
					</div>
					<div class="row mt-2">
						<div class="form-group has-float-label col-12 col-sm-8">
							<input type="hidden" name="fictxtimageexist" id="fictxtimageexist" value="<?php echo $banner->imagen ?>">
							<input type="file" name="fictxtimagen" id="fictxtimagen" class="border p-2 w-100" accept="image/png, .jpeg, .jpg, image/gif">
							<label for="fictxtimagen">imagen</label>
						</div>
						<div class="form-group col-md-4">
							<label for="checkestado">Publicar:</label>
							<input  id="checkestado" <?php echo ($banner->estado == "SI")?"checked":"" ?> name="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 mb-3">
							<div class="my-3">
								<img class="previsualizarslide bg-light" src="<?php echo base_url() ?>upload/banner/<?php echo $banner->imagen ?>" style="width: 350px;height: 150px;">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-5 col-md-6" id="msgslide">
							
						</div>
						<div class="col-12 col-sm-7 col-md-6">
                    		<button type="submit" class="btn btn-primary btn-flat float-right ml-3"><i class="fas fa-save"></i> Guardar</button>
                    		<button type="button" class="btn btn-danger btn-flat float-right" id="btn_cancelslide"><i class="fas fa-times"></i> Cancelar</button>
                  		</div>
					</div>
              	</form>
			</div>
		</div>
  	</section>
</div>

<script src="<?php echo base_url();?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script type="text/javascript">
	$('#btn_cancelslide').click(function(){
		$(location).attr('href', base_url + 'portal-web/banner');
	});

	$('#checkboton').change(function(event) {
	    var habilita = $(this).is(':checked');
	    $("#fictextboton").prop("required", habilita);
	    $("#fictextboton").val("");
	    $('#divboton').toggleClass('d-none');
	    
	});

	$('#fictxtimagen').change(function(){
		var imagen = this.files[0];
		var datosImagen = new FileReader;
    	datosImagen.readAsDataURL(imagen);

    	$(datosImagen).on("load", function(event){

      		var rutaImagen = event.target.result;

      		$(".previsualizarslide").attr("src", rutaImagen);

    	})
	});

	$('#frm_updateslider').submit(function() {
	    $('#frm_updateslider input,select').removeClass('is-invalid');
	    $('#frm_updateslider .invalid-feedback').remove();
	    $('#divcard_slide').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    
	    var formData = new FormData($("#frm_updateslider")[0]);
	    var imgn = $('#fictxtimagen').val();
	    var extension = imgn.split('.').pop();
	    formData.append('extimg',extension);
	    $.ajax({
	        url:$("#frm_updateslider").attr("action"),
	        type:$("#frm_updateslider").attr("method"),
	        dataType: 'json',
	        data: formData,
	        cache:false,
	        contentType:false,
	        processData:false,
	        success: function(e) {
	            $('#divcard_slide #divoverlay').remove();
	            
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });

	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#msgslide').html(msgf);
	                Swal.fire({
	                    title: e.msg,
	                    type: 'success',
	                    icon: 'success',
	                    allowOutsideClick: false,
                      	showConfirmButton: true,
	                }).then((result) => {
	                  	if (result.value) {
	                    	$(location).attr('href', base_url + 'portal-web/banner');
	                  	}
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_slide #divoverlay').remove();
	            $('#msgslide').show();
	            $('#msgslide').html(msgf);
	        }
	    });
	    return false;
	});
</script>
<?php $vbaseurl=base_url(); ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>EVENTOS
                    <small>Agregar</small></h1>
                </div>
            
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>portal-web/eventos">Eventos</a>
                        </li>
                        <li class="breadcrumb-item active">Agregar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
	<section id="s-cargado" class="content">
		<div id="vw_pw_bt_ad_div_principal" class="card">

		    <div class="card-body">
				<form id="vw_pw_bt_ad_form_addevento" action="<?php echo $vbaseurl ?>eventos/fn_insert_datos" method="post" accept-charset="utf-8">
					<div class="row mt-2">
			          	<div class="form-group has-float-label col-12 col-sm-12">
							<input data-currentvalue='' autocomplete="off" class="form-control" id="vw_pw_bt_ad_fictxttitulo" name="vw_pw_bt_ad_fictxttitulo" type="text" placeholder="Titulo de publicación" />
							<label for="vw_pw_bt_ad_fictxttitulo">Titulo</label>
						</div>
					</div>
					<div class="row mt-2">
						<div class="form-group col-12 col-sm-12">
							<label for="vw_pw_bt_ad_fictxtdesc">Descripción</label>
							<textarea data-currentvalue='' class="form-control" id="vw_pw_bt_ad_fictxtdesc" name="vw_pw_bt_ad_fictxtdesc" placeholder="Descripción"></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="form-group has-float-label col-12">
                                <input type="date" name="txtFechaEvento" id="txtFechaEvento" class="form-control" placeholder="Fecha de Evento">
                                <label for="txtFechaEvento">Fecha de Evento</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="txtLugarEvento" id="txtLugarEvento" placeholder="Lugar de Evento" class="form-control">
                                <label for="txtLugarEvento">Lugar de Evento</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-float-label col-12">
                                <input type="time" name="txtHora" id="txtHora" placeholder="Hora de Evento" class="form-control">
                                <label for="txtHora">Hora de Evento</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
    						<div class="form-group has-float-label col-12">
    							<input data-currentvalue='' class="form-control" id="vw_pw_bt_ad_fictxtportada" name="vw_pw_bt_ad_fictxtportada" type="file" accept="image/png, .jpeg, .jpg, image/gif">
    							<label for="vw_pw_bt_ad_fictxtportada">Seleccionar Portada</label>
    						</div>
                        </div>
                        <div class="col-md-6">
                         
                            <img id="fxviewimg" style="width:100%;" class="img-responsive" src="">
                           
                        </div>

			        	<div class="col-12 py-2">
			        		<div id="vw_pw_bt_ad_divmsgevento" class="text-danger">
							</div>
			        	</div>
			        	<div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>portal-web/eventos" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
			        		<button type="submit" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Registrar</button>
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
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>";
?>

<script type="text/javascript">
    $('#vw_pw_bt_ad_fictxtdesc').summernote({
        height: 250,
        placeholder: 'Escriba Aquí ...!',
        dialogsFade: true,
        lang: 'es-ES',
        callbacks: {
            onImageUpload: function(image) {
                vw_pw_bt_ad_fn_uploadImage(image[0]);
            },
            onMediaDelete: function(target) {
                vw_pw_bt_ad_deleteFile(target[0].src);
            }
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#fxviewimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#vw_pw_bt_ad_fictxtportada").change(function(event) {
        readURL(this);
    });

    function vw_pw_bt_ad_fn_uploadImage(image) {
        var data = new FormData();
        data.append("file", image);
        $.ajax({
            url: base_url + "eventos/uploadimages",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "post",
            success: function(url) {
                var image = $('<img>').attr('src', base_url + url);
                $('#vw_pw_bt_ad_fictxtdesc').summernote("insertNode", image[0]);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function vw_pw_bt_ad_deleteFile(src) {
        $.ajax({
            data: {
                src: src
            },
            type: "POST",
            url: base_url + "eventos/delete_file", // replace with your url 
            cache: false,
            success: function(resp) {
                console.log(resp);
            }
        });
    }

    //EVENTOS AGREGAR
    $('#vw_pw_bt_ad_form_addevento').submit(function() {
        $('#vw_pw_bt_ad_divmsgevento').html("");
        $('#vw_pw_bt_ad_form_addevento input,select').removeClass('is-invalid');
        $('#vw_pw_bt_ad_form_addevento .invalid-feedback').remove();
        $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var formData = new FormData($("#vw_pw_bt_ad_form_addevento")[0]);
        $.ajax({
            url: $("#vw_pw_bt_ad_form_addevento").attr("action"),
            type: $("#vw_pw_bt_ad_form_addevento").attr("method"),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(e) {
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

                    if (e.errorimg == false) {
                        $('#vw_pw_bt_ad_fictxtportada').addClass('is-invalid');
                        $('#vw_pw_bt_ad_fictxtportada').parent().append("<div class='invalid-feedback'>" + e.errimg + "</div>");
                    }
                    $('#vw_pw_bt_ad_divmsgevento').html("* " + e.msg);
                } else {
                    var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                    $('#vw_pw_bt_ad_divmsgevento').html(msgf);
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        icon: 'success',
                    }).then((result) => {
                        if (result.value) {
                            location.href = e.destino;
                        }
                    })
                    
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                $('#vw_pw_bt_ad_divmsgevento').show();
                $('#vw_pw_bt_ad_divmsgevento').html(msgf);
            }
        });
        return false;
    })

</script>
<?php 
$vbaseurl=base_url();
 ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>EVENTOS
                    <small>Editar</small></h1>
                </div>
            
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>portal-web/bolsa-de-trabajo">Eventos</a>
                        </li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    
	<section id="s-cargado" class="content pt-2">
		<div id="vw_pw_bt_ed_divcard_principal" class="card">
		    <div class="card-body">
				<form id="vw_pw_bt_ed_form_updateEvent" action="<?php echo $vbaseurl ?>eventos/fn_update_datos" method="post" accept-charset="utf-8">
					<div class="row mt-2">
			          	<div class="form-group has-float-label col-12 col-sm-12">
                            <input type="hidden" name="vw_pw_bt_ed_fictxtcodigo" id="vw_pw_bt_ed_fictxtcodigo" value="<?php echo base64url_encode($Devent->id) ?>">
							<input data-currentvalue='' class="form-control" id="vw_pw_bt_ed_fictxttitulo" name="vw_pw_bt_ed_fictxttitulo" type="text" placeholder="Titulo de publicación" value="<?php echo $Devent->titulo ?>" />
							<label for="vw_pw_bt_ed_fictxttitulo">Titulo</label>
						</div>
					</div>
                    <div class="row mt-2">
						<div class="form-group col-12 col-sm-12">
							<label for="vw_pw_bt_ed_fictxtdesc">Descripción</label>
							<textarea data-currentvalue='' class="form-control" id="vw_pw_bt_ed_fictxtdesc" name="vw_pw_bt_ed_fictxtdesc" placeholder="Descripción" style="height: 100px; line-height: 18px;"><?php echo $Devent->detalle ?></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="form-group has-float-label col-12">
                                <input type="date" value="<?php echo $Devent->fecha ?>" name="txt_ed_FechaEvento" id="txtFechaEvento" class="form-control" placeholder="Fecha de Evento">
                                <label for="txtFechaEvento">Fecha de Evento</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-float-label col-12">
                                <input type="text" value="<?php echo $Devent->lugar ?>" name="txt_ed_LugarEvento" id="txtLugarEvento" placeholder="Lugar de Evento" class="form-control">
                                <label for="txtLugarEvento">Lugar de Evento</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-float-label col-12">
                                <input type="time" value="<?php echo $Devent->hora ?>" name="txt_ed_Hora" id="txtHora" placeholder="Hora de Evento" class="form-control">
                                <label for="txtHora">Hora de Evento</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
    					<div class="col-md-6">
                            <div class="form-group has-float-label col-12">
                                <input type="hidden" name="vw_pw_bt_ed_fictxtexist" id="vw_pw_bt_ed_fictxtexist" value="<?php echo $Devent->imagen ?>">
                                <input data-currentvalue='' class="form-control" id="vw_pw_bt_ed_fictxtportada" name="vw_pw_bt_ed_fictxtportada" type="file" accept="image/png, .jpeg, .jpg, image/gif">
                                <label for="vw_pw_bt_ed_fictxtportada">* Portada / imagen</label>
                                <p class="small text-secondary">Si no va a cambiar la imagen puede dejar vacio este campo</p>
                            </div>
    					</div>
                        <div class="col-md-6">
                            <img id="fxviewimg" style="width:100%;" class="img-responsive" src="<?php echo base_url().'upload/eventos/'.$Devent->imagen ?>">
                        </div>
			        
			        	<div class="col-12 text-danger">
			        		<div id="vw_pw_bt_ed_divmsgevento" >

							</div>
			        	</div>
                    </div>
                    <div class="row mt-2">
			        	<div class="col-12">
                            <a type="button" href="<?php echo base_url() ?>portal-web/eventos" class="btn btn-danger btn-md float-left" ><i class="fas fa-undo"></i> Cancelar</a>
			        		<button type="submit" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Guardar</button>
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
<script>
$(document).ready(function() {
    
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#fxviewimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
    $("#vw_pw_bt_ed_fictxtportada").change(function(event) {
        readURL(this);
    });

    $('#vw_pw_bt_ed_fictxtdesc').summernote({
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
            url: base_url + "eventos/uploadimages",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "post",
            success: function(url) {
                var image = $('<img>').attr('src', base_url + url);
                $('#vw_pw_bt_ed_fictxtdesc').summernote("insertNode", image[0]);
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
    		url: base_url + "eventos/delete_file", // replace with your url 
    		cache: false, 
    		success: function(resp) { 
    			console.log(resp); 
    		} 
    	}); 
    } 

});

//EVENTOS EDITAR
$('#vw_pw_bt_ed_form_updateEvent').submit(function() {
    $('#vw_pw_bt_ed_form_updateEvent input,select').removeClass('is-invalid');
    $('#vw_pw_bt_ed_form_updateEvent .invalid-feedback').remove();
    $('#vw_pw_bt_ed_divcard_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var formData = new FormData($("#vw_pw_bt_ed_form_updateEvent")[0]);
    $.ajax({
        url: $("#vw_pw_bt_ed_form_updateEvent").attr("action"),
        type: $("#vw_pw_bt_ed_form_updateEvent").attr("method"),
        dataType: 'json',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(e) {
            $('#vw_pw_bt_ed_divcard_principal #divoverlay').remove();

            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });

            } else {
                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                $('#vw_pw_bt_ed_divmsgevento').html(msgf);
                Swal.fire({
                    title: e.msg,
                    type: 'success',
                    icon: 'success',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                });
                window.location = e.destino;
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_pw_bt_ed_divcard_principal #divoverlay').remove();
            $('#vw_pw_bt_ed_divmsgevento').show();
            $('#vw_pw_bt_ed_divmsgevento').html(msgf);
        }
    });
    return false;
})

</script>
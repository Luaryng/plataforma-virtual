<?php
	$vbaseurl=base_url();
	$vcodigo="0";
	$vtitulo="";
	$vexpositor="";
	$vfecha="";
	$vhora="";
	$vtipo="";
	$vgrabacion="";
	$vdetalle="";

	if (isset($capacita->id))  $vcodigo=base64url_encode($capacita->id);
	if (isset($capacita->nombre))  $vtitulo=$capacita->nombre;
	if (isset($capacita->expositor))  $vexpositor=$capacita->expositor;
	if (isset($capacita->fecha)) {
		$cfecha= new DateTime($capacita->fecha);
		$vfecha = $cfecha->format('Y-m-d');
		$vhora = $cfecha->format('H:i:s');
	}

	if (isset($capacita->tipo))  $vtipo=$capacita->tipo;
	if (isset($capacita->grabacion))  $vgrabacion=$capacita->grabacion;
	if (isset($capacita->detalle))  $vdetalle=$capacita->detalle;
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">
	<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Capacitación
                    <small>Agregar</small></h1>
                </div>
            
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>capacitaciones/lista">Capacitaciones</a>
                        </li>
                        <li class="breadcrumb-item active">Agregar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content">
		<div id="vw_div_principal" class="card">
		    <div class="card-body">
		    	<form id="vw_pw_bt_ad_form_addcap" action="<?php echo $vbaseurl ?>capacitaciones/fn_insert_update" method="post" accept-charset="utf-8">
		    		<input type="hidden" name="vw_pw_bt_ad_codigo" id="vw_pw_bt_ad_codigo" value="<?php echo $vcodigo ?>">
		    		<div class="row mt-2">
			          	<div class="form-group has-float-label col-12 col-sm-12">
							<input data-currentvalue='' autocomplete="off" class="form-control form-control-sm" id="vw_pw_bt_ad_fictxttitulo" name="vw_pw_bt_ad_fictxttitulo" type="text" placeholder="Titulo de capacitación" value="<?php echo $vtitulo ?>" />
							<label for="vw_pw_bt_ad_fictxttitulo">Titulo</label>
						</div>
						<div class="form-group col-12 col-sm-12">
							<label for="vw_pw_bt_ad_fictxtexpositor">Expositor</label>
							<textarea name="vw_pw_bt_ad_fictxtexpositor" id="vw_pw_bt_ad_fictxtexpositor" class="form-control form-control-sm textsummernote"><?php echo $vexpositor ?></textarea>
						</div>
						<div class="form-group has-float-label col-12 col-sm-4">
							<input data-currentvalue='' autocomplete="off" class="form-control form-control-sm" id="vw_pw_bt_ad_fictxtfecha" name="vw_pw_bt_ad_fictxtfecha" type="date" placeholder="Fecha" value="<?php echo $vfecha ?>" />
							<label for="vw_pw_bt_ad_fictxtfecha">Fecha</label>
						</div>
						<div class="form-group has-float-label col-12 col-sm-4">
							<input data-currentvalue='' autocomplete="off" class="form-control form-control-sm" id="vw_pw_bt_ad_fictxthora" name="vw_pw_bt_ad_fictxthora" type="time" placeholder="Hora" value="<?php echo $vhora ?>" />
							<label for="vw_pw_bt_ad_fictxthora">Hora</label>
						</div>
						<div class="form-group has-float-label col-12 col-sm-4">
							<select data-currentvalue='' autocomplete="off" class="form-control form-control-sm" id="vw_pw_bt_ad_cbotipo" name="vw_pw_bt_ad_cbotipo" placeholder="Tipo">
								<option <?php echo ($vtipo == "") ? "selected" : "" ?> value="">Seleccione</option>
								<option <?php echo ($vtipo == "AL") ? "selected" : "" ?> value="AL">Estudiantes</option>
								<option <?php echo ($vtipo == "DC") ? "selected" : "" ?> value="DC">Docente</option>
								<option <?php echo ($vtipo == "DA") ? "selected" : "" ?> value="DA">Docente Administrativo</option>
								<option <?php echo ($vtipo == "AD") ? "selected" : "" ?> value="AD">Administrativo</option>
							</select>
							<label for="vw_pw_bt_ad_cbotipo">Tipo</label>
						</div>
						<div class="form-group col-12 col-sm-12">
							<label for="vw_pw_bt_ad_fictxtgrabacion">Grabación</label>
                            <textarea name="vw_pw_bt_ad_fictxtgrabacion" id="vw_pw_bt_ad_fictxtgrabacion" class="form-control form-control-sm textsummernote"><?php echo $vgrabacion ?></textarea>
						</div>
						
						<div class="form-group col-12 col-sm-12">
							<label for="vw_pw_bt_ad_detalle">Detalle</label>
							<textarea name="vw_pw_bt_ad_detalle" id="vw_pw_bt_ad_detalle" class="form-control form-control-sm textsummernote"><?php echo $vdetalle ?></textarea>
						</div>
						<div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>capacitaciones/lista" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
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
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>
<script src='{$vbaseurl}resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js'></script>
<script src='{$vbaseurl}resources/plugins/dropzone/dropzone.min.js'></script>";
?>

<script>
	$('.textsummernote').summernote({
        height: 150,
        placeholder: 'Escriba Aquí ...!',
        dialogsFade: true,
        lang: 'es-ES',
        toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['table', ['table']],
                    ['list', ['ul', 'ol']],
                    ['para', ['paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                ],
        callbacks: {
            onImageUpload: function(image) {
                var caja = $(this);
                vw_pw_bt_ad_fn_uploadImage(image[0],caja);
            },
            onMediaDelete: function(target) {
                vw_pw_bt_ad_deleteFile(target[0].src);
            }
        }
    });

    function vw_pw_bt_ad_fn_uploadImage(image,objeto) {
        var data = new FormData();
        data.append("file", image);
        $.ajax({
            url: base_url + "capacitaciones/uploadimages",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "post",
            success: function(url) {
                var image = $('<img>').attr('src', base_url + url);
                objeto.summernote("insertNode", image[0]);
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
            url: base_url + "capacitaciones/delete_file", // replace with your url 
            cache: false,
            success: function(resp) {
                console.log(resp);
            }
        });
    }

    $('#vw_pw_bt_ad_form_addcap').submit(function() {
        $('#vw_pw_bt_ad_divmsgevento').html("");
        $('#vw_pw_bt_ad_form_addcap input,select').removeClass('is-invalid');
        $('#vw_pw_bt_ad_form_addcap .invalid-feedback').remove();
        $('#vw_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $("#vw_pw_bt_ad_form_addcap").attr("action"),
            type: "post",
            dataType: 'json',
            data: $('#vw_pw_bt_ad_form_addcap').serialize(),
            success: function(e) {
                $('#vw_div_principal #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

                } else {
					
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
                $('#vw_div_principal #divoverlay').remove();
                Swal.fire({
                    title: "ERROR!",
                    text:msgf,
                    type: 'error',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    icon: 'error',
                })
            }
        });
        return false;
    })
</script>
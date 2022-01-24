<style>
    .text-titulog {
        color: #ac1a25!important;
    }
</style>
<?php
	$vbaseurl=base_url();

    $vptitulo=(isset($curso->titulo))?$curso->titulo:"";
    $vpurl=(isset($curso->url))?$curso->url:"";
    $vpduracion=(isset($curso->duracion))?$curso->duracion:"";
    $vppresenta=(isset($curso->presentacion))?$curso->presentacion:"";
    $vprequisitos=(isset($curso->requisitos))?$curso->requisitos:"";
    $vpcontenido=(isset($curso->contenido))?$curso->contenido:"";    
    $vpcodigo=(isset($curso->codcurso))?base64url_encode($curso->codcurso):"0";
    $vestado = (isset($curso->activo)) ? $curso->activo : "";
    $vgaleria = (isset($curso->galeria)) ? $curso->galeria : "0";
    $galeria = '0';
    
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_noticias" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-globe mr-1"></i> Cursos - Portal Web</h3>
		    </div>
		    <div class="card-body">
				<form id="vw_ptpe_frm_curso" method="post" accept-charset='utf-8' role="form" enctype="multipart/form-data">
					
					<div class="row mt-2">
                        <input  class="form-control" id="vw_ptpe_txt_codigo" name="vw_ptpe_txt_codigo" type="hidden" value="<?php echo $vpcodigo ?>"   />
                        <div class="form-group has-float-label col-12 col-sm-6">
                            <input  class="form-control" id="vw_ptpe_txt_titulo" name="vw_ptpe_txt_titulo" type="text" placeholder="Título" value="<?php echo $vptitulo ?>"   />
                            <label for="vw_ptpe_txt_titulo">Título</label>
                        </div>

			          	<div class="form-group has-float-label col-12 col-sm-6">
                            <input  class="form-control" id="vw_ptpe_txt_url" name="vw_ptpe_txt_url" type="text" placeholder="URL" value="<?php echo $vpurl ?>"   />
                            <label for="vw_ptpe_txt_url">URL</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-sm-9">
                            <input  class="form-control" id="vw_ptpe_txt_duracion" name="vw_ptpe_txt_duracion" type="text" placeholder="Duración" value="<?php echo $vpduracion ?>"   />
                            <label for="vw_ptpe_txt_duracion">Duración</label>
                        </div>
                        <div class="form-group col-md-3 mt-1">
                            <label for="checkestado">Activo:</label>
                            <input  id="checkestado" <?php echo ($vestado=="SI")?"checked":"" ?> name="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                        </div>
			        </div>
			        <div class="row mt-2">
                        <div class="form-group col-12 col-md-12">
                            <label for="vw_ptpe_txt_presentacion">Presentación </label>
                            <textarea  class="txt_summernote form-control" name="vw_ptpe_txt_presentacion" id="vw_ptpe_txt_presentacion" placeholder="Presenta la Carrera"><?php echo  $vppresenta  ?></textarea>
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
                            <label for="vw_ptpe_txt_contenido">Contenido </label>
                            <textarea  class="txt_summernote form-control" name="vw_ptpe_txt_contenido" id="vw_ptpe_txt_contenido" placeholder="Contenido"><?php echo  $vpcontenido  ?></textarea>
                        </div>
                    </div>

                    <div class="row-mt-2">
                        <div class="col-12">
                            <ul class="row p-0 vistaGaleria">
                                <?php
                                    if ($vpcodigo != '0') {
                                        $galeria = json_decode($vgaleria, true);
                                        foreach ($galeria as $key => $valor) {
                            
                                ?>
                                    <li class="col-12 col-md-2 col-lg-2 card px-3 rounded-0 shadow-none">
                                        <img class="card-img-top" src='<?php echo $vbaseurl.$valor ?>'>
                                        <div class="card-img-overlay p-0 pr-3">
                                           <button type="button" class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNueva" temporal="<?php echo $valor ?>">
                                             <i class="fas fa-times"></i>
                                           </button>
                                        </div>
                                    </li>
                                <?php
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                        <input type="hidden" class="inputNuevaGaleria" name="inputNuevaGaleria" value='<?php echo $vgaleria ?>'>
                        <div class="col-12">
                            <input type="file" multiple="" id="galeria" name="galeria" class="d-none form-control">
                            <label for="galeria" class="text-dark text-center py-5 border rounded bg-white w-100 subirGaleria">
                                Haz clic aquí o arrastrar las imágenes <br>
                                <span class="help-block small">Peso Max. 2MB | Formato: JPG</span>
                            </label>
                        </div>
                    </div>
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
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script>
    arraydata = [];
    $(document).ready(function() {
        
        if ('<?php echo $vpcodigo ?>' != "0") {
            var vgaleria = <?php echo json_encode($galeria, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
            if (vgaleria.length !== 0) {
                
                $.each(vgaleria, function(index, val) {
                    var newimage = [val].toString();
                    arraydata.push(newimage);
                    // $('.inputNuevaGaleria').val(JSON.stringify(arraydata));
                });
                
            }    
        }

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

        $.summernote.dom.emptyPara = "<div><br></div>"

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
    })


    /*=============================================
    ARRASTRAR VARIAS IMAGENES GALERÍA
    =============================================*/

    $(".subirGaleria").on("dragenter", function(e){

        e.preventDefault();
        e.stopPropagation();

        $(".subirGaleria").css({"background":"url(../../resources/img/nube.png)"});
        $('.subirGaleria').css({'background-repeat':'no-repeat'});
        $('.subirGaleria').css({"background-position":"center"});

    })

    $(".subirGaleria").on("dragleave", function(e){

      e.preventDefault();
      e.stopPropagation();

      $(".subirGaleria").css({"background":""})

    })

    $(".subirGaleria").on("dragover", function(e){

      e.preventDefault();
      e.stopPropagation();

    })

    $("#galeria").change(function(){

        var archivos = this.files;

        multiplesArchivos(archivos);

    })

    $(".subirGaleria").on("drop", function(e){

      e.preventDefault();
      e.stopPropagation();

      $(".subirGaleria").css({"background":""})

      var archivos = e.originalEvent.dataTransfer.files;
      
      multiplesArchivos(archivos);

    })

    function multiplesArchivos(archivos){

        for(var i = 0; i < archivos.length; i++){

            var imagen = archivos[i];
            
            if(imagen["type"] != "image/jpeg"){

                Swal.fire({
                    title: "Error al subir la imagen",
                    text: "¡La imagen debe estar en formato JPG!",
                    allowOutsideClick: false,
                    type: "error",
                    confirmButtonText: "¡Cerrar!"
                });

                return;

            }else if(imagen["size"] > 2000000){

                Swal.fire({
                    title: "Error al subir la imagen",
                    text: "¡La imagen no debe pesar más de 2MB!",
                    allowOutsideClick: false,
                    type: "error",
                    confirmButtonText: "¡Cerrar!"
                });

                return;

            }else{

                var datosImagen = new FileReader;
                var data = new FormData();
                data.append("file", imagen);
                $.ajax({
                    url: base_url + "curso_web/uploadfile",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: "post",
                    success: function(url) {

                        $(".vistaGaleria").append(`
                            <li class="col-12 col-md-2 col-lg-2 card px-3 rounded-0 shadow-none">
                                <img class="card-img-top" src="`+base_url + url.urlimg+`">
                                <div class="card-img-overlay p-0 pr-3">
                                   <button type="button" class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNueva" temporal="`+url.urlimg+`">
                                     <i class="fas fa-times"></i>
                                   </button>
                                </div>
                            </li>
                        `)
                        
                        arraydata.push(url.urlimg)
                        $('.inputNuevaGaleria').val(JSON.stringify(arraydata));
                        
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });

            }   
        }   

    }

    /*=============================================
    QUITAR IMAGEN DE LA GALERÍA
    =============================================*/

    $(document).on("click", ".quitarFotoNueva", function(){
        // var listaTemporales = JSON.parse($(".inputNuevaGaleria").val());
        
        var listaFotos = $(".quitarFotoNueva"); 

        for(var i = 0; i < listaFotos.length; i++){

            quitarImagen = $(this).attr("temporal");
            
            if(quitarImagen == arraydata[i]){
                arraydata.splice(i, 1);

                $(".inputNuevaGaleria").val(JSON.stringify(arraydata));

                $(this).parent().parent().remove();

            }

        }

        if (quitarImagen != "") {
            var imagen = quitarImagen;
            $.ajax({ 
                data: {image : imagen}, 
                type: "POST", 
                url: base_url + "curso_web/fn_delete_file",
                cache: false, 
                success: function(e) { 
                    if (e.status == true) {
                        console.log('exito');
                    }
                }
            })
        }
    
        
    })
    

    $('#vw_ptpe_frm_curso').submit(function() {
        if (($.isEmptyObject(arraydata)) || (arraydata.length==0)){
            Swal.fire(
                'Advertencia!',
                "Debe de agregar al menos una imagen en la galeria",
                'warning'
            );
            return false;
        }
        $('#frm_noticias input,select').removeClass('is-invalid');
        $('#frm_noticias .invalid-feedback').remove();
        $('#divcard_noticias').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var formData = new FormData($("#vw_ptpe_frm_curso")[0]);
        formData.append('vw_galeria', JSON.stringify(arraydata));
        $.ajax({
            url: base_url + "curso_web/fn_guardar",
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
                   
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    });

                    window.location = base_url +"formacion-continua/cursos";
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
<style>
#previews {
	min-height: 250px;
	padding-top: 25px;
	padding-bottom: 15px;
	font-size: 18px;
	border: dashed 3px green;
	cursor: pointer ;
	background-repeat: no-repeat;
	background-position: center center;
}

.dropzone-here {
	text-align: center;
	font-size: 18px;
	font-weight: bold;
}

#previews .delete {
	display: none;
}

#previews .dz-success .start,
#previews .dz-success .cancel {
	display: none;
}

#previews .dz-success .delete {
	display: block;
}
#template{
	border:solid red 1px;
}
#previews .name {
	font-size: 12px
	border: solid 1px red;
	white-space: nowrap;
	text-overflow: ellipsis;
	overflow: hidden;
	background-color: white;
}
#previews .name:hover {
	font-size: 12px
	border: solid 1px red;
	white-space: nowrap;
	text-overflow: ellipsis;
	overflow: visible;
	border: solid 1px gray;
	z-index: 100;
	position: absolute;
}

.preview {
	background: #fff;
}

.preview img {
	cursor: pointer;
	width: 100%;
	/*height: 140px;*/
}

</style>
<?php 
	$vbaseurl = base_url();
	$vcodigo="0";
	$vtitulo="";
	$vurl="";
	$vdescripcion="";

	if (isset($album->id))  $vcodigo=base64url_encode($album->id);
	if (isset($album->nombre))  $vtitulo=$album->nombre;
	if (isset($album->detalle))  $vdescripcion=$album->detalle;
	if (isset($album->ruta))  $vurl=$album->ruta;
	
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.css">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Álbum
                    <small>Mantenimiento</small></h1>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>portal-web/transparencia">Álbum</a>
                        </li>
                        <li class="breadcrumb-item active">Mantenimiento</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content">
		<div id="divcard_album" class="card">
			<div class="card-body">
				<form id="vw_pw_bt_ad_form_album" action="<?php //echo $vbaseurl ?>galeria/fn_insert_album" method="post" accept-charset="utf-8">
                    <div class="row mt-2">
                        <input id="vw_pw_bt_ad_fictxtcodigo" name="vw_pw_bt_ad_fictxtcodigo" type="hidden" value="<?php echo $vcodigo ?>">
                        <div class="form-group has-float-label col-12 col-sm-12">
                            <input data-currentvalue='' autocomplete="off" class="form-control" id="vw_pw_bt_ad_fictxttitulo" name="vw_pw_bt_ad_fictxttitulo" type="text" placeholder="Titulo de álbum" value="<?php echo $vtitulo ?>" />
                            <label for="vw_pw_bt_ad_fictxttitulo">Titulo</label>
                        </div>
                        
                        <div class="form-group has-float-label col-10 col-sm-10">
                            <input data-currentvalue='' autocomplete="off" class="form-control" id="vw_pw_bt_ad_fictxtslug" name="vw_pw_bt_ad_fictxtslug" type="text" placeholder="url álbum" value="<?php echo $vurl ?>" readonly="readonly" />
                            <label for="vw_pw_bt_ad_fictxtslug">URL</label>
                        </div>
                        <div class="form-group col-2 col-md-2">
	                        <div class="input-group-append">
	                            <button id="vw_fcb_btnedit_url" data-accion="auto" class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt"></i></button>
	                        </div>
	                    </div>

                        <div class="form-group has-float-label col-12 col-sm-12">
                            <textarea data-currentvalue='' class="form-control" id="vw_pw_bt_ad_fictxtdesc" name="vw_pw_bt_ad_fictxtdesc" placeholder="Descripción" rows="5"><?php echo $vdescripcion ?></textarea>
                            <label for="vw_pw_bt_ad_fictxtdesc">Descripción</label>
                        </div>
                        <div id="actions" class="col-12">
                            <div class="row">
                                <div class="col-lg-7">
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    
                                    <button type="submit" class="btn btn-primary start" style="display: none;">
                                    <i class="fas fa-upload"></i>
                                    <span>Upload</span>
                                    </button>
                                    <button type="reset" class="btn btn-warning cancel" style="display: none;">
                                    <i class="fas fa-ban"></i>
                                    <span>Cancel</span>
                                    </button>
                                </div>
                                
                                <div class="col-lg-5">
                                    <!-- The global file processing state -->
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-12 dropzone-here">
                            
                        </div>
                        <div class="col-12 px-3 text-center">
                            <span class="fileupload-process" style="display: none">
                                <div id="total-progress" class="progress " role="progressbar">
                                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
                                    </div>
                                </div>
                            </span>
                            <h5> Arrastra aquí tus fotos (10 fotos máx. - Peso 5 MB máx. c/u - Formatos: JPG, JPEG, PNG)</h5>
                            <div class="row" id="previews">
                                
                                <div id="template" class="col-6 col-sm-4 col-md-2 px-2 mt-2" >
                                    <div  class="row">
                                        <!-- This is used as the file preview template -->
                                        
                                        <div class="col-12 mx-auto preview ">
                                            <img data-dz-thumbnail />
                                            
                                            
                                            <a class="text-primary start" style="display: none">
                                                <i class="fas fa-upload"></i>
                                                <span>Empezar</span>
                                            </a>
                                            <a data-dz-remove class="text-warning cancel">
                                                <i class="fas fa-ban"></i>
                                                <span>Cancelar</span>
                                            </a>
                                            <a data-dz-remove class=" text-danger delete">
                                                <i class="fas fa-trash"></i>
                                                <span>Eliminar</span>
                                            </a>
                                            <div class="progress">
                                                <div class="progress-bar pb-private progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
                                                </div>
                                            </div>
                                            <div>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                            <p class="size m-0" data-dz-size></p>
                                            <p class="name m-0" data-dz-name></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                 
                        <div class="col-12 py-2 mt-3">
                            <ul class="row p-0 vistaGaleria">
                            	 <?php
                                    if ($vcodigo != '0') {
                                        foreach ($fotos as $key => $value) {
                            
                                ?>
                                    <li class="col-6 col-md-2 col-lg-2 card px-3 rounded-0 shadow-none">
                                        <img class="card-img-top" src='<?php echo $vbaseurl."upload/galeria/".$value->link ?>'>
                                        <div class="card-img-overlay p-0 pr-3">
                                           <button type="button" class="btn btn-danger btn-sm float-right shadow-sm quitarFoto" data-codigo="<?php echo $value->idfoto ?>" data-image="<?php echo $value->link ?>" data-nombre="<?php echo $value->nombre ?>">
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
                        <div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>portal-web/galeria-institucional" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
                            <button type="button" id="vw_pw_bt_ad_btn_guardar" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</section>
</div>

<?php
echo
"<script src='{$vbaseurl}resources/plugins/dropzone/dropzone.min.js'></script>
<script src='{$vbaseurl}resources/dist/js/pages/galeria.js'></script>";
?>

<script type="text/javascript">
	var vfotos = <?php echo json_encode($fotos) ?>;
	var myDropzone;

	/*=============================================
	Ruta álbum
	=============================================*/

	function limpiarUrlalbum(texto){

		var texto = texto.toLowerCase();
		texto = texto.replace(/[á]/g, 'a');
		texto = texto.replace(/[é]/g, 'e');
		texto = texto.replace(/[í]/g, 'i');
		texto = texto.replace(/[ó]/g, 'o');
		texto = texto.replace(/[ú]/g, 'u');
		texto = texto.replace(/[ñ]/g, 'n');
		texto = texto.replace(/ /g, '-');

		return texto;

	}

	$('#vw_pw_bt_ad_fictxttitulo').keyup(function() {
		$('#vw_pw_bt_ad_fictxtslug').val(
			limpiarUrlalbum($('#vw_pw_bt_ad_fictxttitulo').val())
		)
	});

	$('#vw_fcb_btnedit_url').click(function() {
		if ($(this).data('accion')=="auto"){
			$(this).data('accion',"");
			$('#vw_pw_bt_ad_fictxtslug').attr('readonly', false);
			$(this).html('<i class="fas fa-undo-alt"></i>');
		} else {
			$(this).data('accion',"auto");
			$('#vw_pw_bt_ad_fictxtslug').attr('readonly', true);
			$(this).html('<i class="fas fa-pencil-alt"></i>');
		}
	});

	$("#vw_pw_bt_ad_btn_guardar").click(function(event) {

	    $('#divcard_album').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $('input:text,select').removeClass('is-invalid');
	    $('.invalid-feedback').remove();
	    link="";
	    fdata=$("#vw_pw_bt_ad_form_album").serializeArray();
	    arrdata = [];
	    for(var si in myDropzone.files){
	      i=myDropzone.files[si];
	      var myvals = [i.link,i.name,i.size,i.type,i.fileid];
	      arrdata.push(myvals);
	    }
	    fdata.push({name: 'afiles', value: JSON.stringify(arrdata)});
	    // if (($.isEmptyObject(arrdata)) || (arrdata.length==0)){
     //        Swal.fire(
     //            'Advertencia!',
     //            "Debe de agregar al menos una imagen en la galeria",
     //            'warning'
     //        );
     //        $('#divcard_album #divoverlay').remove();
     //        return false;
     //    }
	    $.ajax({
	        url: base_url + 'galeria/fn_insert_album',
	        type: 'POST',
	        data: fdata,
	        dataType: 'json',
	        success: function(e) {
	            $('#divcard_album #divoverlay').remove();
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
	            $('#divcard_album #divoverlay').remove();
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

	$(document).on("click", ".quitarFoto", function(){
		var btn = $(this);
		var codigo = btn.data('codigo');
		var image = btn.data('image');
		var name = btn.data('nombre');
		Swal.fire({
            title: '¿Deseas eliminar la imagen ?',
            text: "Al eliminar, se perdera " + name + " y no podrá recuperarse",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.value) {
            	$.ajax({
                    url: base_url + 'galeria/fn_delete_file',
                    type: 'POST',
                    data: {
                        "codigo": codigo,
                        "link": image
                    },
                    dataType: 'json',
                    success: function(e) {

                        if (e.status == true) {
                        	btn.parent().parent().remove();
                            Swal.fire(
                                'Eliminado!',
                                'La imagen fue eliminado correctamente.',
                                'success'
                            )
                            
                        } else {
                            Swal.fire(
                                'Error!',
                                e.msg,
                                'error'
                            )
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
        })
        return false;
	});

	
</script>
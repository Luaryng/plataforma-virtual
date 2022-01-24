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
 
/*.dz-image-preview {
    min-height: 160px;
}*/
 
.preview {
    background: #fff;
    

}
 
.preview img {
    cursor: pointer;
}
</style>
<?php $vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
$varchivostarea = (isset($varchivostarea)) ? $varchivostarea : array() ;
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">
<div class="content-wrapper">

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $curso->unidad ?>
                <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="<?php echo $vbaseurl ?>alumno/aula-virtual"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
                    </li>
                    <li class="breadcrumb-item">
                        
                        <a href="<?php echo $vbaseurl.'alumno/curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.$vcodmiembro; ?>"><?php echo $curso->unidad ?>
                        </a>
                    </li>
                    
                    <li class="breadcrumb-item active">Tarea</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <!-- Main content -->
<section class="content">
    <?php include 'vw_aula_encabezado.php'; ?>
    <form id='frm-insertupdate' name='frm-insertupdate'   method='post' accept-charset='utf-8'>
       <?php

        $vid="-1";
        if (isset($tentregada->codtarea))  $vid=$tentregada->codtarea;
        ?>
        <!-- @vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion-->
        
        <input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->division) ?>">
        <input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->codcarga) ?>">
        <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo $mat->codigo ?>">
        <input id="vid" name="vid" type="hidden" class="form-control" value="<?php echo  $vid?>">
        <input id="vidmiembro" name="vidmiembro" type="hidden" class="form-control" value="<?php echo  $vcodmiembro?>">
        
        <div class="card" id="divcard-body">
            <?php $vbaseurl=base_url();
            $detalle="";
            $link="";
            $nombre="";
            $fvence="";
            $nfiles=1;
            $fretraso="";
            $finicia="";

            $tdetalle="";
            if (isset($mat->detalle))  $detalle=$mat->detalle;
            if (isset($mat->link))  $link=$mat->link;
            if (isset($mat->nombre))  $nombre=$mat->nombre;
            if (isset($mat->vence))  $fvence=$mat->vence;
            if (isset($mat->inicia))  $finicia=$mat->inicia;
            if (isset($mat->nfiles))  $nfiles=$mat->nfiles;
            if (isset($mat->retraso))  $fretraso=$mat->retraso;

            if (isset($tentregada->detalle))  $tdetalle=$tentregada->detalle;
            ?>
            <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">
            <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.css">
            <div class="card-header">
                <h3 class="card-title text-bold"> <?php echo $nombre ?></h3>
            </div>
            <div class="card-body">
                <div class="row p-0">
                    <div class="col-12">
                        
                        
                        <?php echo $detalle ?>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php
                        $n=count($varchivos);
                        if ($n>0){
                        //$detalle_arc="";
                        foreach ($varchivos as $file) {
                        $codmat=base64url_encode($mat->codigo);
                        $coddet=base64url_encode($file->coddetalle);
                        $archivo=base_url()."curso/virtual/archivos/$codmat/$coddet";
                        
                        $icon=getIcono('P',$file->nombre);
                        echo "<span class='text-danger py-1 d-block'><a target='_blank'  href='$archivo'> $icon $file->nombre</a></span>";
                        }
                        //$nombre="<span class='text-danger'><i class='fas fa-download mr-2'></i> $mat->nombre</span>";
                        //$detalle=$detalle_arc. $mat->detalle;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
            <div class="card border-light">
                <div class="card-header">
                    <h3 class="card-title text-bold">Entrega</h3>
                    
                </div>
                <?php
                date_default_timezone_set('America/Lima');
                $fechav = "";
                $horav = "";
                if ($fvence!=""){
                    $fechav = fechaCastellano($fvence,$meses_ES,$dias_ES);
                    $horav = date('h:i a',strtotime($fvence));
                }

                $fechai = "";
                $horai = "";
                $tiniciar=true;
                if ($finicia!=""){
                    $fechai = fechaCastellano($finicia,$meses_ES,$dias_ES);
                    $horai = date('h:i a',strtotime($finicia));
                    $tiniciar=false;
                    if (strtotime($finicia)<time()) $tiniciar=true;
                }

                $fechar = "";
                $horar = "";
                $tretraso=true;
                
                if ($fretraso!=""){
                    $fechar = date('Y-m-d',strtotime($fretraso));
                    $horar = date('h:i a',strtotime($fretraso));
                    $tretraso=false;
                    if (strtotime($fretraso)>time()) $tretraso=true;
                }
                ?>
                <div class="card-body px-0 px-sm-3">
                    <!--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>-->
                    <div class="row p-2 bg-lightgray">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Fecha límite" data-content="Fecha límite permitida para el envío de tareas"> ? </a> Fecha límite: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo $fechav ?></span>
                        </div>
                        
                    </div>
                    <div class="row p-2">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Hora límite permitida para el envío de tareas"> ? </a> Hora límite: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo $horav ?></span>
                        </div>
                    </div>
                    <div class="row p-2 bg-lightgray">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Cantidad de archivos que puedes enviar">? </a> Archivos Máximos:</span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo $nfiles ?></span>
                        </div>
                    </div>

                 
                    <div class="row p-2">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Tiempo restante: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo hms_restantes($fvence) ?></span>
                        </div>
                    </div>

    
                    <?php if  (($tiniciar==true) && ($tretraso==true)) { ?>
                      
                    
                    <div class="row p-2 mt-3">
                        <div class="col-12 ">
                            <textarea id="vtextdetalle" name="vtextdetalle" class="form-control" rows="10">
                            <?php echo $tdetalle ?>
                            </textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <form method="post" enctype="multipart/form-data">
                            <div class="col-12 fallback">
                                <input name="file" type="file" multiple />
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
                            <div class="col-12 px-4 text-center">
                                <span class="fileupload-process" style="display: none">
                                    <div id="total-progress" class="progress " role="progressbar">
                                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
                                        </div>
                                    </div>
                                </span>
                                <h5> Arrastra aquí tus archivos (5 archivos máx. - Peso 30 MB máx. c/u)</h5>
                                <div class="row" id="previews">
                                    
                                    <div id="template" class="col-6 col-sm-4 col-md-2 mt-2" >
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
                        </form>
                    </div>
                    
                    <div class="alert alert-danger alert-dismissible mt-2" style="display: none">
                        
                        <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
                        <ul>
                            <li>Se encontraron algunos archivos con error </li>
                            <li>Verifique si alguno de ellos tenga un peso superior a los 30 Mb (30720 kb)</li>
                            <li>Solo se acepta un máximo de <?php echo $nfiles ?> archivo(s)</li>
                        </ul>
                    </div>
                    <?php } 
                    if ($tiniciar==false) { ?>


                        <div class="row p-2 bg-lightgray">
                            <div class="col-6 col-md-3">
                                <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Podrás entregar tu tarea después del:  </span>
                            </div>
                            <div class="col-6 col-md-4">
                                <b><?php echo fechaCastellano($finicia,$meses_ES,$dias_ES)." - ".$horai ?></b>
                            </div>
                        </div>

                    <?php } ?>
                    <?php if ($tretraso==false) { ?>
                    <div class="row p-2 bg-lightgray">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Las entregas con retraso vencieron:  </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <b><?php echo fechaCastellano($fretraso,$meses_ES,$dias_ES)." - ".$horar ?></b>
                        </div>
                    </div>
                    <?php } ?>

                </div>
                <div class="card-footer">
                    <a href="<?php echo  base_url().'alumno/curso/virtual/tarea/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo).'/'.$vcodmiembro; ?>" class="btn btn-secondary">Cancelar</a>
                     <?php if (($tiniciar==true) && ($tretraso==true)) { ?>
                    <button id="btn-guardararchivo" class="btn btn-primary float-right" type="button" >Entregar tarea</button>
                    <?php } ?>
                </div>
            </div>
            
        
    </form>
</section>
            </div>
<?php if  (($tiniciar==true) && ($tretraso==true)) { ?>
<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.js"></script>
<script>
//var myDropzone;
var varchivostarea  = <?php echo json_encode($varchivostarea) ?>;
var nfiles=<?php echo $nfiles ?>;
$('#vtextdetalle').summernote({
      height: 200,
      minHeight: 200, // set minimum height of editor
      maxHeight: 800, // set maximum height of editor
      focus: true,
      toolbar: [
      // [groupName, [list of button]]
      ['style', ['bold', 'italic', 'underline', 'clear','style']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['color', ['color']],
      ['list', ['ul', 'ol']],
      ['para', ['paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['otros', ['help','codeview']],
    ]
  });

$(document).ready(function() {
    var imageUrl = base_url + "resources/img/nube.png";
    $('#previews').css('background-image', 'url(' + imageUrl + ')');
    $('#previews').css('background-repeat', 'url(' + imageUrl + ')');


    // Get the template HTML and remove it from the doument

    Dropzone.prototype.getErroredFiles = function () {
       var file, _i, _len, _ref, _results;
       _ref = this.files;
       _results = [];
       for (_i = 0, _len = _ref.length; _i < _len; _i++) {
           file = _ref[_i];
           if (file.status === Dropzone.ERROR) {
               _results.push(file);
           }
       }
       return _results;
    };

    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    myDropzone = new Dropzone(document.body, {
        url: base_url + "virtualalumno/uploadfile",
        paramName: "file",
        maxFilesize: 30,
        maxFiles: nfiles,
        thumbnailWidth: 100,
        thumbnailHeight: 100,
        thumbnailMethod: 'crop',
        timeout: 0,
        parallelUploads: 1,
        previewTemplate: previewTemplate,
        autoQueue: true,
        previewsContainer: "#previews",
        clickable: "#previews",
        init: function() {
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0 && this.getErroredFiles().length === 0) {
   
                    $(".alert").hide();
                    $("#btn-guardararchivo").prop("disabled", false);
                }
                else{
                    $(".alert").show();
                    $("#btn-guardararchivo").prop("disabled", true);
                }
            });
            

            este = this;
            $.each(varchivostarea, function(k, v) {
                //alert( "Key: " + k + ", Value: " + v );
                var mockFile = {
                    name: v.nombre,
                    size: v.peso,
                    type: v.tipo
                };
                este.options.addedfile.call(este, mockFile);

                var ext = v.nombre.split('.').pop();
                var ico = "";
                if (ext == "pdf") {
                    ico = "resources/img/icons/pdf.png";
                } else if (ext.indexOf("doc") != -1) {
                    ico = "resources/img/icons/word.png";
                } else if (ext.indexOf("xls") != -1) {
                    ico = "resources/img/icons/excel.png";
                } else if ((ext.indexOf("jpg") != -1) || (ext.indexOf("png") != -1)) {
                    ico = "resources/img/icons/img.png";
                } else if ((ext.indexOf("mp4") != -1) || (ext.indexOf("mpg") != -1)) {
                    ico = "resources/img/icons/vdo.png";
                } else {
                    ico = "resources/img/icons/file.png";
                }

                este.options.thumbnail.call(este, mockFile, base_url + ico);

                mockFile.previewElement.classList.add('dz-success');
                mockFile.previewElement.classList.add('dz-complete');
                mockFile.previewElement.querySelector(".pb-private").style.width = "100%"
                mockFile.fileid = v.coddetalle;
                mockFile.link = v.link;
            });


            this.on("success", function(file, response) {
                var obj = jQuery.parseJSON(response)
                file.link = obj.link;
                file.fileid=0;
                //console.log(file);
            })

        },
        removedfile: function(file) {
            var vinid=(typeof file.fileid === "undefined") ? "":file.fileid ;
            var vilink=(typeof file.link === "undefined") ? "":file.link ;
            var este=this;
            Swal.fire({
                title: '¿Deseas eliminar el ARCHIVO ?',
                text: "Al eliminar, se perdera " + file.name + " y no podrá recuperarse",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.value) {
                        $.ajax({
                            url: base_url + 'virtualtarea/fn_tarea_entregada_delete_detalle',
                            type: 'POST',
                            data: {
                                "coddetalle": vinid,
                                "link": vilink 
                            },
                            dataType: 'json',
                            success: function(e) {
                                if (e.status == true) {
                                    Swal.fire(
                                        'Eliminado!',
                                        'El archivo fue eliminado correctamente.',
                                        'success'
                                    )
                                    file.previewElement.remove();
                                    if (este.getUploadingFiles().length === 0 && este.getQueuedFiles().length === 0 && este.getErroredFiles().length === 0) {
                                        $(".alert").hide();
                                        $("#btn-guardararchivo").prop("disabled", false);
                                    }
                                     else{
                                        $(".alert").show();
                                        $("#btn-guardararchivo").prop("disabled", true);
                                    }

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


        }

    });

    myDropzone.on("addedfile", function(file) {
        file.previewElement.querySelector(".start").onclick = function() {
            myDropzone.enqueueFile(file);
        };
        var ext = file.name.split('.').pop();
        $("#btn-guardararchivo").prop("disabled", true);
        if (ext == "pdf") {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/pdf.png");
        } else if (ext.indexOf("doc") != -1) {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/word.png");
        } else if (ext.indexOf("xls") != -1) {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/excel.png");
        } else if ((ext.indexOf("jpg") != -1) || (ext.indexOf("png") != -1)) {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/img.png");
        } else {
            myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/file.png");
        }


    });


    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
    });

    myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1";
        // And disable the start button

        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0";

    });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
    };


});
//CON DROPZONE
$("#btn-guardararchivo").click(function(event) {
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    link="";
    fdata=$("#frm-insertupdate").serializeArray();
    var html = $('#vtextdetalle').summernote('code');
    fdata.push({name: 'textdetalle', value: html});
    arrdata = [];
    for(var si in myDropzone.files){
      i=myDropzone.files[si];
      var myvals = [i.link,i.name,i.size,i.type,i.fileid];
      arrdata.push(myvals);
    }
    fdata.push({name: 'afiles', value: JSON.stringify(arrdata)});
    $.ajax({
        url: base_url + 'virtualtarea/fn_insert_update',
        type: 'POST',
        data: fdata,
        dataType: 'json',
        success: function(e) {
            if (e.status==true){
                var anu = e.filesnoup.toString();
                if ($.trim(anu)==""){
                    Swal.fire(
                      'Exito!',
                      'Los datos fueron guardados correctamente.',
                      'success'
                    );
                    window.location.href = e.redirect;
                }
                else{
                    Swal.fire({
                        title: 'Error! Archivos no subidos',
                        text: "Los siguientes archivos no fueron subidos al servidor: " + anu + " intente nuevamente",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        window.location.href = e.redirect;
                    })
                }
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
            //$('#divcard_grupo #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
        }
    })
});
</script>
<?php } ?>

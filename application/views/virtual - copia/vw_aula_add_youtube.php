<?php $vbaseurl=base_url();

$link="";
$nombre="";

$mostrardt="NO";
$tiempol=0;
if (isset($mat->nombre))  $nombre=$mat->nombre;
if (isset($mat->mostrardt))  $mostrardt=$mat->mostrardt;

$link="";
if (isset($mat->link))  $link="https://www.youtube.com/watch?v=".$mat->link;

 ?>

<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">

<input id="vtipo" name="vtipo" type="hidden" class="form-control" value="<?php echo  $_GET['type'] ?>">
<div class="card-header">
    <h3 class="card-title text-bold">Agregar Enlace de Youtube</h3>
</div>
<div class="card-body">
    <div class="row">
         <div class="form-group has-float-label col-12 col-sm-9">
            <input data-currentvalue='' class="form-control" id="vnombre" name="vnombre" type="text" placeholder="Fec. Inscripción" value="<?php echo $nombre ?>"   />
            <label for="vnombre">Nombre</label>
          </div>
          <div class="form-group has-float-label col-12 col-sm-12">
            <input data-currentvalue='' class="form-control" id="vlinka" type="url" placeholder="Fec. Inscripción" value="<?php echo $link ?>"  />
            <label for="vlink">Link/ Enlace</label>
          </div>
           <div class="col-12 text-left">          
            <span class="badge badge-pill badge-secondary" tabindex="0" role="button" data-toggle="popover" data-content="Si se activa, la descripción anterior se mostrará en la página del curso justo debajo del enlace a la actividad o recurso" data-trigger="focus" title="">?</span>
            <label for="checkmostrardt">Mostrar vista previa del vídeo </label>
            <input class="clcheckmostrar" id="checkmostrardt" <?php echo ($mostrardt=="SI")?"checked":"" ?> name="checkmostrardt" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger" value="SI">
        </div>
    </div>
</div>
<div class="card-footer">
    <button id="btn-cancel-all" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    <button id="btn-guardaryoutube" class="btn btn-primary float-right" type="button" >Guardar</button>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.js"></script>

<script>

$(document).ready(function() {

});

</script>

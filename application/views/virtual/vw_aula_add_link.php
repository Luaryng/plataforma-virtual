<?php $vbaseurl=base_url();
$detalle="";
$link="";
$nombre="";
$fvence="";
$finicia="";
$nfiles=3;
$fretraso="";
$vopcion1="NO";
$vopcion2="NO";
$mostrardt="NO";
$tiempol=0;
if (isset($mat->detalle))  $detalle=$mat->detalle;
if (isset($mat->link))  $link=$mat->link;
if (isset($mat->nombre))  $nombre=$mat->nombre;
if (isset($mat->vence))  $fvence=$mat->vence;
if (isset($mat->inicia))  $finicia=$mat->inicia;
if (isset($mat->nfiles))  $nfiles=$mat->nfiles;
if (isset($mat->retraso))  $fretraso=$mat->retraso;
if (isset($mat->mostrardt))  $mostrardt=$mat->mostrardt;
if (isset($mat->opc1))  $vopcion1=$mat->opc1;
if (isset($mat->opc2))  $vopcion2=$mat->opc2;
if (isset($mat->limite))  $tiempol=$mat->limite;
?>
<input id="vtipo" name="vtipo" type="hidden" class="form-control" value="<?php echo  $_GET['type'] ?>">
<div class="card-header">
    <h3 class="card-title text-bold">Agregar Link / URL</h3>
</div>
<div class="card-body">
    <div class="row">
        <div class="form-group has-float-label col-12 col-sm-9">
            <input data-currentvalue='' class="form-control" id="vnombre" name="vnombre" type="text" placeholder="Nombre" value="<?php echo $nombre ?>"   />
            <label for="vnombre">Nombre</label>
        </div>
        <div class="form-group has-float-label col-12 col-sm-12">
            <input data-currentvalue='' class="form-control" id="vlink" name="vlink" type="url" placeholder="Link/ Enlace" value="<?php echo $link ?>"  />
            <label for="vlink">Link/ Enlace</label>
        </div>
    </div>
    <textarea id="vtextdetalle" name="vtextdetalle" class="form-control" style="height: 700px">
    <?php echo $detalle ?>
    </textarea>
    <div class="col-12 text-left">
        <span class="badge badge-pill badge-secondary" tabindex="0" role="button" data-toggle="popover" data-content="Si se activa, la descripción anterior se mostrará en la página del curso justo debajo del enlace a la actividad o recurso" data-trigger="focus" title="">?</span>
        <label for="checkmostrardt">Muestra la descripción en la página del curso</label>
        <input class="clcheckmostrar" id="checkmostrardt" <?php echo ($mostrardt=="SI")?"checked":"" ?> name="checkmostrardt" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger" value="SI">
    </div>
    
</div>
<div class="card-footer">
    <button id="btn-cancel-all" type="button" class="btn btn-secondary">Cancelar</button>
    <button id="btn-guardarenlace" class="btn btn-primary float-right" type="button" >Guardar</button>
</div>

<?php $vbaseurl=base_url();
$detalle="";
if (isset($mat->detalle))  $detalle=$mat->detalle;
$mostrardt="NO";
if (isset($mat->mostrardt))  $mostrardt=$mat->mostrardt;

 ?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.css">

<input id="vtipo" name="vtipo" type="hidden" class="form-control" value="<?php echo  $_GET['type'] ?>">
<div class="card-header">
    <h3 class="card-title text-bold">Agregar Etiqueta</h3>
</div>
<div class="card-body">
    <textarea id="vtextdetalle" name="vtextdetalle" class="form-control" style="height: 700px">
        <?php echo $detalle ?>
    </textarea>
</div>
<input name="checkmostrardt" id="checkmostrardt" type="hidden" value="<?php echo $mostrardt ?>">
<div class="card-footer">
    <button id="btn-cancel-all" type="button" class="btn btn-secondary">Cancelar</button>
    <button id="btn-guardarenlace" class="btn btn-primary float-right" type="button" >Guardar</button>
</div>


<?php $vbaseurl=base_url();
$getmaxsize=getMaxSizeUpload();
$getmaxcount= getMaxCountFileUpload();
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
<input id="vlink" name="vlink" type="hidden" class="form-control" value="">
<div class="card-header">
    <h3 class="card-title text-bold">Agregar Archivo</h3>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group has-float-label">
                <input value="<?php echo $nombre ?>" data-currentvalue='' class="form-control" id="vnombre" name="vnombre" type="text" placeholder="Nombre"   />
                <label for="vnombre">Nombre</label>
            </div>
            <textarea id="vtextdetalle" name="vtextdetalle" class="form-control" rows="10">
            <?php echo $detalle ?>
            </textarea>
        </div>
        <div class="col-12 text-left">          
            <span class="badge badge-pill badge-secondary" tabindex="0" role="button" data-toggle="popover" data-content="Si se activa, la descripción anterior se mostrará en la página del curso justo debajo del enlace a la actividad o recurso" data-trigger="focus" title="">?</span>
            <label for="checkmostrardt">Muestra la descripción en la página del curso</label>
            <input class="clcheckmostrar"  id="checkmostrardt" <?php echo ($mostrardt=="SI")?"checked":"" ?> name="checkmostrardt" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger" value="SI">
        </div>

        <form class="mt-5" method="post" enctype="multipart/form-data">
            <div class="col-12">
                <div class="row">
                    
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
                    <?php include 'vw_include_dropzone.php'; ?>
                    
                </div>
            </div>
        </form>
    </div>
    <div class="alert alert-danger alert-dismissible mt-2" style="display: none">
      
      <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
      <ul>
          <li>Se encontraron algunos archivos con error </li>
          <li>Verifique si alguno de ellos tenga un peso superior a los <?php echo $getmaxsize ?>MB</li>
          <li>Solo se acepta un máximo de <?php echo $getmaxcount ?> archivos</li>
      </ul>
    </div>
</div>
<div class="card-footer">
    <button id="btn-cancel-all" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    <button id="btn-guardararchivo" class="btn btn-primary float-right" type="button" >Guardar</button>

</div>
<script>
    var getmfsup=<?php echo $getmaxsize ?>;
    var getmfcup=<?php echo $getmaxcount ?>;
</script>

<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/virtual_dropzone-v5.js"></script>

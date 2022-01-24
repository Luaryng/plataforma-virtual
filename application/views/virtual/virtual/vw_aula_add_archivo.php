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
    <h3 class="card-title text-bold">Nuevo Archivo</h3>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group has-float-label col-12 col-sm-9">
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
    </div>
    <div class="row mt-3">
        <form method="post" enctype="multipart/form-data">
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
                    <div class="col-12 dropzone-here">
                        
                    </div>
                    <div class="col-12 px-3 text-center">
                        <span class="fileupload-process" style="display: none">
                            <div id="total-progress" class="progress " role="progressbar">
                                <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
                                </div>
                            </div>
                        </span>
                        <h5> Arrastra aquí tus archivos (5 archivos máx. - Peso 5 MB máx. c/u)</h5>
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
                    
                </div>
            </div>
        </form>
    </div>
    <div class="alert alert-danger alert-dismissible mt-2" style="display: none">
      
      <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
      <ul>
          <li>Se encontraron algunos archivos con error </li>
          <li>Verifique si alguno de ellos tenga un peso superior a los 5 Mb (5120 kb)</li>
          <li>Solo se acepta un máximo de 5 archivos</li>
      </ul>
    </div>
</div>
<div class="card-footer">
    <button id="btn-cancel-all" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    <button id="btn-guardararchivo" class="btn btn-primary float-right" type="button" >Guardar</button>

</div>


<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/virtual_dropzone-v3.js"></script>

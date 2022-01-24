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
$detalle="";
$link="";
$nombre="";
$fvence="";
$finicia="";
$nfiles=1;
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
    <h3 class="card-title text-bold">Nueva Tarea</h3>
</div>
<div class="card-body">
    <div class="row p-0">
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
            <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Si se activa, la descripción anterior se mostrará en la página del curso justo debajo del enlace a la actividad o recurso" data-trigger="focus" title="">?</a>
            <label for="checkmostrardt">Muestra la descripción en la página del curso</label>
            <input  class="clcheckmostrar"  id="checkmostrardt" <?php echo ($mostrardt=="SI")?"checked":"" ?> name="checkmostrardt" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger" value="SI">
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
                    <div class="col-12 mt-5">
                        <div class="row">                           
                            <div class="col-12 p-0">
                                 <div class="card border-light">
                                    <div class="card-header px-3">
                                        <h3> Fecha y hora de entrega</h3>
                                        
                                    </div>
                                    <?php 
                                        date_default_timezone_set('America/Lima');
                                        $fechai = date('Y-m-d');
                                        $horai = date('H:i');
                                        $checi="";
                                        $enabledi="disabled";
                                        if ($finicia!=""){
                                            $fechai = date('Y-m-d',strtotime($finicia));
                                            $horai = date('H:i',strtotime($finicia)); 
                                            $checi="checked";
                                            $enabledi="";
                                        }
                                        $fechav= date('Y-m-d');;
                                        $horav = date('H:i');;
                                        $checv="";
                                        $enabledv="disabled";
                                        if ($fvence!=""){
                                            $fechav = date('Y-m-d',strtotime($fvence));
                                            $horav = date('H:i',strtotime($fvence)); 
                                            $checv="checked";
                                            $enabledv="";
                                        }

                                        $fechar= date('Y-m-d');;
                                        $horar = date('H:i');;
                                        $checr="";
                                        $enabledr="disabled";
                                        if ($fretraso!=""){
                                            $fechar = date('Y-m-d',strtotime($fretraso));
                                            $horar = date('H:i',strtotime($fretraso)); 
                                            $checr="checked";
                                            $enabledr="";
                                        }

                                        $tiempol = 0;
                                        $chect="";
                                        if ($tiempol>0){
                                            $chect="checked";
                                        }
                                    ?>
                                    <div class="card-body px-3">
                                        <!--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>-->

                                        <div class="row">
                                            <div class="col-2 pt-2">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Indica la fecha y hora en que se empezará a recibir las entregas, si no se activa la entrega puede empezar ahora mismo" data-trigger="focus" title="">?</a>
                                                Abrir entrega
                                            </div>
                                            <div class="col-3">
                                                <input id="txtopenfecha" name="txtopenfecha" class="inputstiempo form-control" type="date" autocomplete="off" required value="<?php echo $fechai ?>" <?php echo $enabledi ?>/>
                                            </div>
                                            <div class="col-3">
                                                <input id="txtopenhora" name="txtopenhora" class="inputstiempo form-control" type="time" autocomplete="off" required value="<?php echo $horai ?>" <?php echo $enabledi ?>/>
                                            </div>
                                            <div class="col-2 pt-2">
                                                <input <?php echo $checi ?>  class="checkstiempo" type="checkbox" id="checkopen" name="checkopen" value="SI">
                                                <label  for="checkopen"> Habilitar</label>
                                            </div>
                                        </div>
                                        <div class="row pt-2">
                                            <div class="col-2 pt-2">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Indica la fecha y hora en que se considera una tarea entregada a tiempo" data-trigger="focus" title="">?</a>
                                                Fecha de entrega
                                            </div>
                                            <div class="col-3">
                                                <input id="txtclosefecha" name="txtclosefecha" class="inputstiempo form-control" type="date" autocomplete="off" required value="<?php echo $fechav ?>" <?php echo $enabledv ?>/>
                                            </div>
                                            <div class="col-3">
                                                <input id="txtclosehora" name="txtclosehora" class="inputstiempo form-control" type="time" autocomplete="off" required value="<?php echo $horav ?>" <?php echo $enabledv ?>/>
                                            </div>
                                            <div class="col-2 pt-2">
                                                <input <?php echo $checv ?>  class="checkstiempo" type="checkbox" id="checkclose" name="checkclose" value="SI">
                                                <label  for="checkclose"> Habilitar</label>
                                            </div>
                                        </div>

                                        <div class="row pt-2">
                                            <div class="col-2 pt-2">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Indica la fecha y hora en que aún se recibirá entregas pero serán consideradas como atrasadas.  Si no se activa se podrá recibir hasta el final del curso" data-trigger="focus" title="">?</a>
                                                Fuera de plazo
                                            </div>

                                            <div class="col-3">
                                                <input id="txtfecharetraso" name="txtfecharetraso" class="inputstiempo form-control" type="date" autocomplete="off" required value="<?php echo $fechar ?>" <?php echo $enabledr ?>/>
                                            </div>
                                            <div class="col-3">
                                                <input id="txthoraretraso" name="txthoraretraso" class="inputstiempo form-control" type="time" autocomplete="off" required value="<?php echo $horar ?>" <?php echo $enabledr ?>/>
                                            </div>
                                            <div class="col-2 pt-2">
                                                <input <?php echo $checr ?>  class="checkstiempo" type="checkbox" id="checkretraso" name="checkretraso" value="SI">
                                                <label  for="checkretraso"> Habilitar</label>
                                            </div>
                                        </div>
                                        <div class="row pt-2">
                                            <div class="col-2 pt-2">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Cantidad de archivos que puede enviar el estudiante" data-trigger="focus" title="">?</a>
                                                Nro de archivos
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control" name="cbnroarchivos" id="cbnroarchivos" placeholder="Tipo" required>
                                                    <option <?php echo ($nfiles==1)?"selected":"" ?> value="1">1</option>
                                                    <option <?php echo ($nfiles==2)?"selected":"" ?> value="2">2</option>
                                                    <option <?php echo ($nfiles==3)?"selected":"" ?> value="3">3</option>
                                                    <option <?php echo ($nfiles==4)?"selected":"" ?> value="4">4</option>
                                                    <option <?php echo ($nfiles==5)?"selected":"" ?> value="5">5</option>
                                                </select>
                                            </div>
                                        </div>

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
<script>
//$('#checkretraso').bootstrapToggle();
$(function () {
  $('[data-toggle="popover"]').popover()
})
$('.checkstiempo').change(function(event) {
    var habilita=$(this).is(':checked');
    var filatiempo=$(this).closest(".row");
    filatiempo.find('.inputstiempo').prop("disabled", !habilita);
    
});


</script>

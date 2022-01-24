
<?php $vbaseurl=base_url();
$detalle="";
$link="";
$nombre="";
$fvence="";
$finicia="";
$nfiles=3;
$fretraso="";
$vopcion1="SI";
$vopcion2="SI";
$vopcion3="NO";
$vopcion4="NO";
$vopcion5="SI";
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
if (isset($mat->opc3))  $vopcion3=$mat->opc3;
if (isset($mat->opc4))  $vopcion4=$mat->opc4;
if (isset($mat->opc5))  $vopcion5=$mat->opc5;
if (isset($mat->limite))  $tiempol=$mat->limite;


 ?>


<input id="vtipo" name="vtipo" type="hidden" class="form-control" value="<?php echo  $_GET['type'] ?>">
<input id="vlink" name="vlink" type="hidden" class="form-control" value="">
<div class="card-header">
    <h3 class="card-title text-bold">Nueva Evaluación</h3>
</div>
<div class="card-body px-2 px-sm-3">
    <div class="row p-0">
        <div class="col-12">
            <div class="row">
            <div class="form-group has-float-label col-12 col-sm-9">
                <input value="<?php echo $nombre ?>" data-currentvalue='' autocomplete="off" class="form-control" id="vnombre" name="vnombre" type="text" placeholder="Nombre"   />
                <label for="vnombre">Nombre</label>
            </div>
            </div>
            <textarea id="vtextdetalle" name="vtextdetalle" class="form-control" rows="10">
            <?php echo $detalle ?>
            </textarea>
        </div>
       <div class="col-12 text-left">          
            <span class="badge badge-pill badge-secondary" tabindex="0" role="button" data-toggle="popover" data-content="Si se activa, la descripción anterior se mostrará en la página del curso justo debajo del enlace a la actividad o recurso" data-trigger="focus" title="">?</span>
            <label for="checkmostrardt">Muestra la descripción en la página del curso</label>
            <input  class="clcheckmostrar"  id="checkmostrardt" <?php echo ($mostrardt=="SI")?"checked":"" ?> name="checkmostrardt" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger" value="SI">
        </div>
    </div>
    <div class="row mt-3">
        <form method="post" enctype="multipart/form-data">
                    <div class="col-12">
                                <div class="card border-light">
                                    <div class="card-header px-2 pb-1">
                                        <h4>Tiempo</h4>
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

                                        $chect="";
                                        $enabledl="disabled";
                                        if ($tiempol>0){
                                            $chect="checked";
                                            $enabledl="";
                                        }
                                    ?>
                                    <div class="card-body px-2 px-sm-3">
                                        <div class="row">
                                            <div class="col-12 col-md-3 pt-2">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Indica la fecha y hora en que se empezará a recibir las entregas, si no se activa la entrega puede empezar ahora mismo" data-trigger="focus" title="">?</a>
                                                Iniciar evaluación
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input id="txtopenfecha" name="txtopenfecha" class="inputstiempo form-control" type="date" autocomplete="off" required value="<?php echo $fechai ?>" <?php echo $enabledi ?>/>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input id="txtopenhora" name="txtopenhora" class="inputstiempo form-control" type="time" autocomplete="off" required value="<?php echo $horai ?>" <?php echo $enabledi ?>/>
                                            </div>
                                            <div class="col-12 col-md-2 pt-2">
                                                <input <?php echo $checi ?>  class="checkstiempo" type="checkbox" id="checkopen" name="checkopen" value="SI">
                                                <label  for="checkopen"> Habilitar</label>
                                            </div>
                                        </div>
                                        <div class="row pt-2">
                                            <div class="col-12 col-md-3 pt-2">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Indica la fecha y hora en que se considera una tarea entregada a tiempo" data-trigger="focus" title="">?</a>
                                                Culminar
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input id="txtclosefecha" name="txtclosefecha" class="inputstiempo form-control" type="date" autocomplete="off" required value="<?php echo $fechav ?>" <?php echo $enabledv ?>/>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input id="txtclosehora" name="txtclosehora" class="inputstiempo form-control" type="time" autocomplete="off" required value="<?php echo $horav ?>" <?php echo $enabledv ?>/>
                                            </div>
                                            <div class="col-12 col-md-2 pt-2">
                                                <input <?php echo $checv ?>  class="checkstiempo" type="checkbox" id="checkclose" name="checkclose" value="SI">
                                                <label  for="checkclose"> Habilitar</label>
                                            </div>
                                        </div>
                                        <!--<div class="row pt-2">
                                            <div class="col-12 col-md-3 pt-2">
                                                <a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary" tabindex="0" data-toggle="popover" data-content="Indica cuanto dura la evaluación" data-trigger="focus" title="">?</a>
                                                Límite de tiempo
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <input id="txtlimitnumero" name="txtlimitnumero" class="inputstiempo form-control" type="number" autocomplete="off" required value="<?php //echo $tiempol ?>" <?php //echo $enabledl ?>/>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <select name="cbnroarchivos" id="cbnroarchivos" class=" inputstiempo form-control" <?php //echo $enabledl ?>>
                                                    <option <?php //echo ($nfiles==1) ? "selected":"" ?> value="1">días</option>
                                                    <option <?php //echo ($nfiles==2) ? "selected":"" ?> value="2">horas</option>
                                                    <option <?php //echo ($nfiles==3) ? "selected":"" ?> value="3">minutos</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-2 pt-2">
                                                <input <?php //echo $chect ?> class="checkstiempo" type="checkbox" id="checklimite" name="checklimite" value="SI">
                                                <label  for="checklimite"> Habilitar</label>
                                            </div>
                                        </div>-->
                                        
                                    </div>
                                    <div class="card ">
                                        <div class="card-header px-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <a href="#" onclick="event.preventDefault();"  class="badge badge-pill badge-secondary" tabindex="0" role="button" data-toggle="popover" data-content="El participante podrá ver las respuestas correctas del examen despues de culminado el tiempo" data-trigger="focus" title="">?</a>
                                                    <span for="checkopcion1">  Mostrar las respuestas correctas del examen despues de culminado el tiempo </span>
                                                    <input value="SI" id="checkopcion1" <?php echo ($vopcion1=="SI")?"checked":"" ?> name="checkopcion1" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                                </div>

                                                 <div class="col-12">
                                                    <a href="#" onclick="event.preventDefault();"  class="badge badge-pill badge-secondary" tabindex="0" role="button" data-toggle="popover" data-content="El participante podrá visualizar su puntaje al entregar su evaluación o despues de haberse completado el tiempo de la evaluación" data-trigger="focus" title="">?</a>
                                                    <span for="checkopcion2">  Mostrar puntaje obtenido inmediatamente al entregar evaluación (SI=Inmediatamente / NO=Al completar el tiempo )</span>
                                                    <input value="SI" id="checkopcion2" <?php echo ($vopcion2=="SI")?"checked":"" ?> name="checkopcion2" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                                <div class="col-12">
                                                    <a href="#" onclick="event.preventDefault();"  class="badge badge-pill badge-secondary" tabindex="0" role="button" data-toggle="popover" data-content="Las preguntas aparecerán de manera Aleatoria" data-trigger="focus" title="">?</a>
                                                    <span for="checkopcion3">  Mostrar PREGUNTAS en orden Aleatorio</span>
                                                    <input value="SI" id="checkopcion3" <?php echo ($vopcion3=="SI")?"checked":"" ?> name="checkopcion3" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                                 <div class="col-12">
                                                    <a href="#" onclick="event.preventDefault();"  class="badge badge-pill badge-secondary" tabindex="0" role="button" data-toggle="popover" data-content="Las respuestas de cada pregunta aparecerán de manera Aleatoria" data-trigger="focus" title="">?</a>
                                                    <span for="checkopcion4">  Mostrar RESPUESTAS en orden Aleatorio</span>
                                                    <input value="SI" id="checkopcion4" <?php echo ($vopcion4=="SI")?"checked":"" ?> name="checkopcion4" data-size="xs" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                               
                                            </div>
                                                   
                                        </div>
                                    </div>
                                </div>
                    </div>
        </form>
    </div>
</div>
<div class="card-footer">
    <button id="btn-cancel-all" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    <button id="btn-guardarcuestionario" class="btn btn-primary float-right" type="button" >Guardar</button>
</div>

<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
$('.checkstiempo').change(function(event) {
    var habilita=$(this).is(':checked');
    var filatiempo=$(this).closest(".row");
    filatiempo.find('.inputstiempo').prop("disabled", !habilita);
    
});

</script>

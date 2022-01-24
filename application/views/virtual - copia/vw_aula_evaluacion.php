<?php 
$vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
$division64=base64url_encode($curso->division);
$codcarga64=base64url_encode($curso->codcarga);
$codmaterial64=base64url_encode($mat->codigo);
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1><?php echo $curso->unidad ?>
                    <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
                </div>
                 <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fas fa-caret-right"></i> Mis Unidades didácticas</a>
                        </li>
                        
                        <li class="breadcrumb-item">
                            
                            <a href="<?php echo $vbaseurl.'curso/panel/'.$codcarga64.'/'.$division64; ?>">Panel
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/'.$codcarga64.'/'.$division64; ?>">Aula Virtual
                            </a>
                        </li>
                      <li class="breadcrumb-item active">Evaluación</li>
                    </ol>
                  </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content">
        <?php include 'vw_aula_encabezado.php'; ?>
        <form id='frm-insertupdate' name='frm-insertupdate'   method='post' accept-charset='utf-8'>
            <?php
            $vid=-1;
            if (isset($tentregada->codtarea))  $vid=$tentregada->codtarea;
            ?>
            <!-- @vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion-->
            
            <input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  $division64 ?>">
            <input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  $codcarga64 ?>">
            <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo $mat->codigo ?>">
            <input id="vid" name="vid" type="hidden" class="form-control" value="<?php echo  $vid?>">
            <div class="card" id="divcard-body">
                <?php $vbaseurl=base_url();
                $detalle="";
                $nombre="";
                $fvence="";
                $nfiles=1;
                $finicia="";
                $tiempol=0;
                if (isset($mat->detalle))  $detalle=$mat->detalle;
                
                if (isset($mat->nombre))  $nombre=$mat->nombre;
                if (isset($mat->vence))  $fvence=$mat->vence;
                if (isset($mat->inicia))  $finicia=$mat->inicia;
                if (isset($mat->nfiles))  $nfiles=$mat->nfiles;
                
                if (isset($mat->limite))  $tiempol=$mat->limite;
                ?>
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
                            $coddet=base64url_encode($file->coddetalle);
                            $archivo=base_url()."curso/virtual/archivos/$codmaterial64/$coddet";
                            
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
                    <h3 class="card-title text-bold">Datos de entrega</h3>
                    <div class="card-tools">
                      <a href="<?php echo $vbaseurl.'curso/virtual/editar/'.$codcarga64.'/'.$division64.'/'.$codmaterial64.'?type=V' ?>" class="badge badge-primary px-2 py-1">
                        <i class="fas fa-edit mr-1"></i> Editar
                      </a>
                     
                    </div>
                </div>
                <?php
                date_default_timezone_set('America/Lima');
                $fechav = "Sin límite";
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
                
                ?>
                <div class="card-body px-0 px-sm-3">
                    <!--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>-->
                    
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">

                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Fecha límite" data-content="N° de estudiantes enrolados al curso"> ? </a> N° estudiantes: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo str_pad($nmiembros, 2, "0", STR_PAD_LEFT) ; ?></span>
                        </div>
                        
                    </div>
                     <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Inicia" data-content="Fecha y hora que inicia la evaluación"> ? </a> Inicia: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo "$fechai $horai" ?></span>
                        </div>
                    </div>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Finaliza" data-content="Fecha y hora limite para la entrega de la evaluación"> ? </a> Finaliza: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo "$fechav $horav" ?></span>
                        </div>
                    </div>
                    <?php 
                    if ($vid==-1){
                    ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3 ">
                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Tiempo restante: </span>
                        </div>
                        <div class="col-6 col-md-9">
                            <span>
                                <?php
                                if  ($fvence=="") {
                                    echo "Sin límite";
                                }
                                else{
                                    echo (strtotime($fvence)<time()) ? "Tiempo completado" : hms_restantes($fvence);
                                } ?></span>
                        </div>
                    </div>
                    
                    <?php }
                    else{ ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Tarea entregada: </span>
                        </div>
                        <div class="col-6 col-md-9 text-success text-bold">
                            <span><?php echo fechaCastellano($tentregada->fentrega,$meses_ES,$dias_ES)." - ".date('h:i a',strtotime($tentregada->fentrega)); ?></span>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Fecha límite" data-content="Fecha límite permitida para el envío de tareas"> ? </a> Entregados: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo str_pad($conteos->total, 2, "0", STR_PAD_LEFT) ?></span>
                        </div>
                    </div>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Pendientes de entregar" data-content="N° de estudiantes sin entregar evaluación"> ? </a> Sin Entregar: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            
                            <span> <?php echo str_pad($nmiembros - $conteos->total, 2, "0", STR_PAD_LEFT) ?></span>
                        </div>
                    </div>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Fecha límite" data-content="Fecha límite permitida para el envío de tareas"> ? </a> Por revisar: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="<?php echo ($conteos->pendientes==0)?"":"text-danger" ?>" ><?php echo str_pad($conteos->pendientes, 2, "0", STR_PAD_LEFT) ; ?></span>
                        </div>
                        
                    </div>
                    
                    <!--<div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo que dura la evaluación, una vez iniciada">? </a> Duración:</span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php 
                            $tmedida[0]="";
                            $tmedida[1]="Día";
                            $tmedida[2]="Hora";
                            $tmedida[3]="Minuto";
                            echo $tiempol." ".$tmedida[$nfiles].(($tiempol==1) ? "" : "s");
                            unset($tmedida); ?></span>
                        </div>
                    </div>-->
                    <?php
                    if ($tiniciar==false) { ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a href="#" onclick="event.preventDefault();" class="badge badge-pill badge-secondary mr-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Podrás iniciar tu evaluación después del:  </span>
                        </div>
                        <div class="col-6 col-md-9">
                            <b><?php echo fechaCastellano($finicia,$meses_ES,$dias_ES)." - ".$horai ?></b>
                        </div>
                    </div>
                    <?php } ?>

                </div>
                <div class="card-footer text-center">
                    <a href="<?php echo  base_url().'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-secondary float-left">Volver</a>
                   
                    <a href="<?php echo $vbaseurl.'curso/virtual/evaluacion/revisar/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo); ?>" class="btn btn-primary" >Ver Evaluaciones</a>
                    <a href="<?php echo $vbaseurl.'curso/virtual/evaluacion/preguntas/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo); ?>" class="btn btn-info float-right" >Ver Preguntas</a>
                    
                </div>
            </div>
            
            
        </form>
    </section>
</div>
<script>
    $(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
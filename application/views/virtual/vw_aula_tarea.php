<?php 
$vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
$division64=base64url_encode($curso->division);
$codcarga64=base64url_encode($curso->codcarga);
$codmaterial64=base64url_encode($mat->codigo);
?>
<div class="content-wrapper">
    <?php print_vpd_modal() ?>

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
                            <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><i class="fas fa-caret-right"></i> Panel</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><i class="fas fa-caret-right"></i> Aula virtual
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
            $vid=-1;
            if (isset($tentregada->codtarea))  $vid=$tentregada->codtarea;
            ?>
            <!-- @vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion-->
            
            <input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->division) ?>">
            <input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->codcarga) ?>">
            <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo $mat->codigo ?>">
            <input id="vid" name="vid" type="hidden" class="form-control" value="<?php echo  $vid?>">
            <div class="card" id="divcard-body">
                <?php
                $detalle="";
                $link="";
                $nombre="";
                $fvence="";
                $nfiles=1;
                $fretraso="";
                $finicia="";
                if (isset($mat->detalle))  $detalle=$mat->detalle;
                if (isset($mat->link))  $link=$mat->link;
                if (isset($mat->nombre))  $nombre=$mat->nombre;
                if (isset($mat->vence))  $fvence=$mat->vence;
                if (isset($mat->inicia))  $finicia=$mat->inicia;
                if (isset($mat->nfiles))  $nfiles=$mat->nfiles;
                if (isset($mat->retraso))  $fretraso=$mat->retraso;
                ?>
                <div class="card-header">
                    <h3 class="card-title text-bold"> <?php echo $nombre ?></h3>
                </div>
                <div class="card-body">
                    <div class="row p-0">
                        <div class="col-12">
                            
                            
                            <?php echo $detalle ?>
                            
                        </div>
                    
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
                                // echo "<span class='text-danger py-1 d-block'><a target='_blank'  href='$archivo'> $icon $file->nombre</a></span>";
                                echo print_vpd_link($icon,$file->nombre,$archivo,$file->link);
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
                    <div class="card-tools">
                      <a href="<?php echo $vbaseurl.'curso/virtual/editar/'.$codcarga64.'/'.$division64.'/'.$codmaterial64.'?type=T' ?>" class="badge badge-primary px-2 py-1">
                        <i class="fas fa-edit mr-1"></i> Editar
                      </a>
                     
                    </div>
                    <h3 class="card-title text-bold">Datos de entrega</h3>
                    
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
                $fechar = "No se permiten";
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
                    
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Fecha límite" data-content="N° de estudiantes enrolados al curso"> ? </a> N° de estudiantes: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo $nmiembros?></span>
                        </div>
                        
                    </div>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Fecha límite" data-content="Fecha límite permitida para el envío de tareas"> ? </a> Fecha de entrega: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo "$fechav $horav" ?></span>
                        </div>
                        
                    </div>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Fecha límite" data-content="Fecha límite permitida para el envío de tareas"> ? </a> Entregados: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo "$nroentregas" ?></span>
                        </div>
                        
                    </div>
                    
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Cantidad de archivos que puedes enviar">? </a> Archivos Máximos:</span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo $nfiles ?></span>
                        </div>
                    </div>
                    <?php
                    
                    
                    if ($vid==-1){
                    ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3 ">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Tiempo restante: </span>
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
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Tarea entregada: </span>
                        </div>
                        <div class="col-6 col-md-9 text-success text-bold">
                            <span><?php echo fechaCastellano($tentregada->fentrega,$meses_ES,$dias_ES)." - ".date('h:i a',strtotime($tentregada->fentrega)); ?></span>
                        </div>
                    </div>
                    <?php }
                    if ($tiniciar==false) { ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Podrás entregar tu tarea después del:  </span>
                        </div>
                        <div class="col-6 col-md-9">
                            <b><?php echo fechaCastellano($finicia,$meses_ES,$dias_ES)." - ".$horai ?></b>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($tretraso==false) { ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Entregas fuera de plazo  :  </span>
                        </div>
                        <div class="col-6 col-md-9">
                            <b><?php echo ($fretraso=="") ? $fechar: fechaCastellano($fretraso,$meses_ES,$dias_ES)." - ".$horar ?></b>
                        </div>
                    </div>
                    <?php } ?>

                </div>
                <div class="card-footer text-center">
                    <a href="<?php echo  base_url().'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-secondary float-left">Volver</a>
                   
                    <a href="<?php echo $vbaseurl.'curso/virtual/tarea/revisar/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo); ?>" class="btn btn-primary" >Revisar entregas</a>
                    
                </div>
            </div>
            
            
        </form>
    </section>
</div>

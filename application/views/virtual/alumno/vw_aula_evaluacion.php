<?php 
$vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
?>
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
                            <a href="<?php echo $vbaseurl.'alumno/aula-virtual'; ?>"><i class="fas fa-compass"></i> Unidades Didacticas</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'alumno/curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.$vcodmiembro; ?>"><i class="fas fa-caret-right"></i> Aula virtual
                            </a>
                        </li>
                        
                        <li class="breadcrumb-item active">Evaluación</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content ">
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
                <?php $vbaseurl=base_url();
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
                </div>
            </div>
            
            <div class="card border-light">
                <div class="card-header">
                    <h3 class="card-title text-bold">Datos de entrega</h3>
                    
                </div>
                <?php
                date_default_timezone_set('America/Lima');

                $timelocal=time();
                $fechav = "";
                $horav = "";
                $tvencio="NO";
                if ($fvence!=""){
                    $fechav = fechaCastellano($fvence,$meses_ES,$dias_ES);
                    $horav = date('h:i a',strtotime($fvence));
                    $tvencio=(strtotime($fvence)>$timelocal) ? "NO":"SI";
                }
                $fechai = "";
                $horai = "";
                $tinicio="SI";
                if ($finicia!=""){
                    $fechai = fechaCastellano($finicia,$meses_ES,$dias_ES);
                    $horai = date('h:i a',strtotime($finicia));
                    $tinicio=(strtotime($finicia)<$timelocal) ?"SI":"NO";
                }
 
                
                
                ?>
                <div class="card-body px-0 px-sm-3">
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3 ">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Estado: </span>
                        </div>
                        <div class="col-6 col-md-9">

                            <span><?php 
                                //echo "ini:$tinicio ven:$tvencio";
                                if ($tinicio=="NO"){
                                    echo "Aún no inicia";
                                } 
                                elseif ($tvencio=="SI") {
                                    echo "<span class='d-block mb-2'>Culminó</span>";
                                    if ($vid>0){
                                       echo "<a class='tboton bg-primary' href='{$vbaseurl}alumno/curso/virtual/evaluacion/revisado/".base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo).'/'.$vcodmiembro."'>Ver Evaluación</a>";

                                    }
                                }
                                else{
                                    echo "<span class='d-block mb-2'>En desarrollo</span>";
                                    if ($vid>0){
                                        

                                         echo "<a class='tboton bg-primary' href='{$vbaseurl}alumno/curso/virtual/evaluacion/revisado/".base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo).'/'.$vcodmiembro."'>Ver Evaluación</a>";
                                    }
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                    <?php 
                    if ($tinicio=="NO") { ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Podrás iniciar tu evaluación después del:  </span>
                        </div>
                        <div class="col-6 col-md-9">
                            <b><?php echo fechaCastellano($finicia,$meses_ES,$dias_ES)."<br>".$horai ?></b>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Fecha límite" data-content="Fecha límite permitida para el envío de tareas"> ? </a> Límite de entrega: </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span><?php echo $fechav."<br>".$horav ?></span>
                        </div>
                        
                    </div>
                    
                    <?php
                    
                    if ($vid==-1){
                        if (($tinicio=="SI") && ($tvencio=="NO")){
                    ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3 ">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Inició: </span>
                        </div>
                        <div class="col-6 col-md-9">
                            <span><?php echo $fechai."<br>".$horai ?></span>
                        </div>
                    </div>


                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3 ">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Tiempo restante: </span>
                        </div>
                        <div class="col-6 col-md-9">
                            <span><?php echo hms_restantes($fvence) ?></span>
                        </div>
                    </div>
                    
                    <?php }
                    }
                    else{ ?>
                    <div class="row p-2 rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Evaluación entregada: </span>
                        </div>
                        <div class="col-6 col-md-9 text-success text-bold">
                            <?php if ($tentregada->fentrega==""): ?>
                                 <span class="text-danger">Sin entregar</span>        
                            <?php else: ?>
                                <span><?php echo fechaCastellano($tentregada->fentrega,$meses_ES,$dias_ES)."<br>".date('h:i a',strtotime($tentregada->fentrega)); ?></span> <br>
                                
                            <?php endif ?>
                            
                            
                        </div>
                    </div>
                    <?php } ?>

                     
                    <?php if (($tvencio=="SI") && ($vid==-1))  { ?>
                    <div class="row p-2  rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Observación: </span>
                        </div>
                        <div class="col-6 col-md-9 text-danger">
                            <span>Sin entregar</span>
                        </div>
                    </div>
                    <?php  } ?>

                    <div class="row p-2  rowcolor">
                        <div class="col-6 col-md-3">
                            <span><a class="badge badge-pill badge-info" tabindex="0" data-toggle="popover" data-trigger="focus" title="Hora límite" data-content="Tiempo restante "> ? </a> Calificación: </span>
                        </div>
                        <div class="col-6 col-md-9 text-bold">
                            <span><?php
                             if  ($vid==-1){
                                echo "";
                             }
                             else{
                                if ($tentregada->completo=="SI"){
                                    echo str_pad($tentregada->nota, 2, "0", STR_PAD_LEFT) ;
                                }
                                else{
                                    echo "Pendiente";
                                }
                             }
                             ?></span>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-center">
                    <a href="<?php echo  base_url().'alumno/curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.$vcodmiembro; ?>" class="btn btn-secondary float-left">Volver</a>
                    <?php 
                    
                    if (($tinicio=="SI") && ($tvencio=="NO"))  {
                        if (($vid==-1)){ ?>
                            <a href="<?php echo $vbaseurl.'alumno/curso/virtual/evaluacion/entregar/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo).'/'.$vcodmiembro; ?>" class="btn btn-primary" >Iniciar Evaluación</a>
                            <?php }
                        else{ ?>
                        
                    <?php }
                    } ?>
                </div>
            </div>
            
            
        </form>
    </section>
</div>
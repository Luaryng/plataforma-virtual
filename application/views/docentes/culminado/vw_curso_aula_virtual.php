<?php $vbaseurl=base_url();
?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">-->
<div class="content-wrapper">
    
    <?php include 'vw_curso_encabezado.php'; ?>
        
            <div class="card-body p-2">
                <ul class="order-list no-fondo" >
                    <?php
                    $nindicadores=0;
                    $norden=1;
                    $arr_arch=array();
                    foreach ($varchivos as $karc => $arch) {
                        $arr_arch[$arch->codmaterial][] = $arch;
                    }
                    unset($varchivos);
                    foreach ($material as $key => $mat) {
                        
                    $nindicadores++;
                    //$bcolor=($mat->abierto=='SI') ? "badge-info" : "badge-danger";
                    $detalle="";
                    $nombre="";
                    $norden=$mat->orden;
                    $esp=$mat->esp;
                    $contarchivos="";
                    switch ($mat->tipo) {
                        case 'E':
                            # code...
                            $esp=$esp ;
                            $nombre="$mat->detalle";;
                            $detalle="";
                            break;
                        case 'A':
                            if (isset($arr_arch[$mat->codigo])){
                                $files=$arr_arch[$mat->codigo];
                                $n=count($files);
                                if ($n>1){
                                    $detalle_arc="";
                                    foreach ($files as $file) {
                                        $codmat=base64url_encode($file->codmaterial);
                                        $coddet=base64url_encode($file->coddetalle);
                                        $archivo=base_url()."curso/virtual/archivos/$codmat/$coddet";
                                       
                                        
                                        $icon=getIcono('P',$file->nombre);
                                        $detalle_arc=$detalle_arc."<span class='text-danger py-1 d-block'><a target='_blank'  href='$archivo'> $icon $file->nombre</a></span>";
                                    }
                                    $nombre="<span class='text-danger'><i class='fas fa-download mr-2'></i> $mat->nombre</span>";
                                    $contarchivos="<div class='col-12 ml-2 pl-3 pb-4'>".$detalle_arc."</div>";
                                    $detalle=$mat->detalle;
                                }
                                else if($n==1)
                                {
                                    foreach ($files as $file) {
                                        $codmat=base64url_encode($file->codmaterial);
                                        $coddet=base64url_encode($file->coddetalle);
                                        $archivo=base_url()."curso/virtual/archivos/$codmat/$coddet";
                                        $icon=getIcono('P',$file->nombre);
                                    }
                                    $nombre="<a target='_blank' class='text-danger' href='$archivo'>$icon $mat->nombre</a>";
                                    $detalle=$mat->detalle;
                                }
                                unset($files);
                                unset($arr_arch[$mat->codigo]);
                            }
                            else{
                                $nombre="<span target='_blank' class='text-warning' ><i class='fas fa-download mr-2'></i> $mat->nombre (sin archivos)</span>";
                                $detalle=$mat->detalle;
                            }
                            break;
                        case 'Y':
                            $icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_ytb.png' alt='Youtube'>";
                            $nombre="$icon <span style='vertical-align: middle;display: inline-block'>$mat->nombre</span>";


                            $detalle='<div class="col-12 col-sm-8 offset-sm-2  col-md-6 offset-md-3 align-self-center"><div class="embed-responsive embed-responsive-16by9">
                              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$mat->link.'" allowfullscreen></iframe>
                            </div></div>';
                            //$detalle="<p class='text-center  pt-3'><iframe frameborder='0' allowfullscreen='true' src='//www.youtube.com/embed/$mat->link' height='200' class=note-video-clip'></iframe></p>";
                            break;
                        case 'T':
                            $icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
                            //$archivo=$mat->link;
                            $ira=base_url().'alumno/curso/virtual/tarea/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo);
                            $nombre="<a class='text-danger' href='$ira'>$icon <span>$mat->nombre</span></a>";
                            $detalle=$mat->detalle;
                            break;
                        case 'F':
                            $icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
                            $archivo=$mat->link;
                            $ira = base_url().'alumno/curso/virtual/foro-virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo);
                            $nombre="<a class='text-danger' href='$ira'>$icon <span>$mat->nombre</span></a>";
                            $detalle=$mat->detalle;
                            break;
                        case 'L':
                            $icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_url.png' alt='URL'>";
                            $archivo=$mat->link;
                            $nombre="<a target='_blank' class='text-danger' href='$archivo'>$icon <span>$mat->nombre</span></a>";
                            $detalle=$mat->detalle;
                            break;
                        default:
                            # code...
                    }
                    ?>
                    <li data-id="<?php echo $mat->codigo ?>" data-espacio='<?php echo $esp ?>' class="espaciol-<?php echo $esp  ?>">
                        
                        <div class="col-12 px-0 py-0">
                            <div class="row p-0">
                                
                                <?php echo "<div class='col-12 pt-1'>$nombre</div>";
                                echo $contarchivos;
                                
                                if ($mat->tipo!="E") {
                                    if ($mat->mostrardt=="NO") $detalle="";
                                    echo "<div class='col-12 ml-2 pl-3 pb-4'>$detalle</div>" ;
                                }
                                ?>                                
                            </div>
                        </div>
                        <!--<small class="badge <?php //echo //$bcolor ?>"><i class="far fa-clock"></i> Abierto</small>-->
                        

                    </li>
                    <?php } ?>
           
                </ul>
                
            </div>
            
        </div>
        
    </section>
</div>
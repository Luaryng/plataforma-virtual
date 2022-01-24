<?php $vbaseurl=base_url();
?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">-->
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
                    <a href="<?php echo $vbaseurl ?>alumno/aula-virtual"><i class="fas fa-compass"></i> Unidades Didacticas</a>
                </li>
                
                
              <li class="breadcrumb-item active">Aula Virtual</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <?php include 'vw_aula_encabezado.php'; ?>

        
        <div class="card" id="divcard-indicadores">
            <div class="card-header">
                <h3 class="card-title">Aula Virtual</h3>
            </div>
            <div  class="card-body px-1 px-sm-2">
                <ul id="accordion" class="order-list no-fondo" >
                    <?php

                    $norden=1;
                    $arr_arch=array();
                    foreach ($varchivos as $karc => $arch) {
                        $arr_arch[$arch->codmaterial][] = $arch;
                    }
                    unset($varchivos);
                    $abrigrupo=false;
                    $abrili=false;
                    foreach ($material as $key => $mat) {
                        
                    //$bcolor=($mat->abierto=='SI') ? "badge-info" : "badge-danger";
                    $detalle="";
                    $nombre="";
                    $norden=$mat->orden;
                    $esp=$mat->esp;
                    $contarchivos="";
                    date_default_timezone_set('America/Lima');
                    $timelocal=time();
                    $tmuestra="NO";
                    if ($mat->v_time != NULL){
                        $tmuestra=(strtotime($mat->v_time)<$timelocal) ?"SI":"NO";
                    }

                    if (($mat->visible == "Mostrar") || ($tmuestra == "SI")) {
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
                                    //$n=count($files);
                                    //if ($n>1){
                                        $detalle_arc="";
                                        foreach ($files as $file) {
                                            $codmat=base64url_encode($file->codmaterial);
                                            $coddet=base64url_encode($file->coddetalle);
                                            $archivo=base_url()."curso/virtual/archivos/$codmat/$coddet/";
                                           
                                            $icon=getIcono('P',$file->link);
                                            $detalle_arc=$detalle_arc."<span class='text-danger py-1 d-block'><a target='_blank'  href='$archivo'> $icon $file->nombre</a></span>";
                                        }
                                        $nombre="<span class='text-danger'><i class='fas fa-download mr-2'></i> $mat->nombre</span>";
                                        $contarchivos="<div class='col-12 ml-sm-2 pl-sm-3 pb-2'>".$detalle_arc."</div>";
                                        $detalle=$mat->detalle;
                                    //}
                                    /*else if($n==1)
                                    {
                                        foreach ($files as $file) {
                                            $codmat=base64url_encode($file->codmaterial);
                                            $coddet=base64url_encode($file->coddetalle);
                                            $archivo=base_url()."curso/virtual/archivos/$codmat/$coddet";
                                            $icon=getIcono('P',$file->nombre);
                                        }
                                        $nombre="<a target='_blank' class='text-danger' href='$archivo'>$icon $mat->nombre</a>";
                                        $detalle=$mat->detalle;
                                    }*/
                                    unset($files);
                                    unset($arr_arch[$mat->codigo]);
                                }
                                else{
                                    $nombre="<span target='_blank' class='text-warning' ><i class='fas fa-download mr-2'></i> $mat->nombre (sin archivos)</span>";
                                    $detalle=$mat->detalle;
                                }
                                break;
                            case 'Y':
                                $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_ytb.png' alt='Youtube'>";
                                $archivo="https://www.youtube.com/watch?v=$mat->link";
                                $nombre="<a target='_blank' class='text-danger' href='$archivo'>$icon <span>$mat->nombre</span></a>";


                                $detalle='<div class="col-12 mt-3 col-sm-8 offset-sm-2  col-md-6 offset-md-3 align-self-center">
                                    <div class="embed-responsive embed-responsive-16by9">
                                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$mat->link.'" allowfullscreen></iframe>
                                </div></div>';
                                //$detalle="<p class='text-center  pt-3'><iframe frameborder='0' allowfullscreen='true' src='//www.youtube.com/embed/$mat->link' height='200' class=note-video-clip'></iframe></p>";
                                break;
                            case 'T':
                                $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
                                //$archivo=$mat->link;
                                $ira=base_url().'alumno/curso/virtual/tarea/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo).'/'.$vcodmiembro;
                                $nombre="<a class='text-danger' href='$ira'>$icon <span>$mat->nombre</span></a>";
                                $detalle=$mat->detalle;
                                break;
                            case 'F':
                                $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_foro.png' alt='TAREA'>";
                                $archivo=$mat->link;
                                $ira = base_url().'alumno/curso/virtual/foro-virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo).'/'.$vcodmiembro;
                                $nombre="<a class='text-danger' href='$ira'>$icon <span>$mat->nombre</span></a>";
                                $detalle=$mat->detalle;
                                break;
                            case 'V':
                                $icon="<img class='mr-1'  src='".base_url()."resources/img/icons/p_cuestionario.png' alt='TAREA'>";
                                $archivo=base_url().'alumno/curso/virtual/evaluacion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo).'/'.$vcodmiembro;
                                $nombre="<a class='text-danger' href='$archivo'>$icon <span>$mat->nombre</span></a>";
                                $detalle=$mat->detalle;
                                break;
                            case 'L':
                                $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_url.png' alt='URL'>";
                                $liknko=(strrpos($mat->link, "http")===false) ? 'https://': '';
                                $archivo=$liknko.$mat->link;
                                $nombre="<a target='_blank' class='text-danger' href='$archivo'>$icon <span>$mat->nombre</span></a>";
                                $detalle=$mat->detalle;
                                break;
                            default:
                                # code...
                        }
                        
                        if (($mat->tipo=="E") && ($mat->mostrardt=="SI")){ 
                            if ($abrigrupo==true){
                                echo "</ul></li>";
                                $abrigrupo==false;
                            }
                            
                           
                                
                                echo "<li data-id='$mat->codigo' data-espacio='$esp' class='espaciol-$esp mt-2'>";
                                    echo "<a data-toggle='collapse' data-parent='#accordion'  href='#acdn$mat->codigo'  class='d-block p-1 text-decoration-none border-lightgray rounded'>
                                         <i class='far fa-lg fa-plus-square float-right'></i>$nombre </a> ";
                                
                                echo "<ul id='acdn$mat->codigo' class='collapse pt-2'>";
                                $abrigrupo=true;
                            
                        }                                
                        else{
                            if ($abrili==true){
                                echo "</li>";
                                $abrili=false;
                            }
                            
                                echo "<li data-id='$mat->codigo' data-espacio='$esp' class='espaciol-$esp'>";
                                $abrili=true;
                            
                            ?>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <?php 
                                   echo "<div class='col-12 pt-1'>$nombre</div>";
                                        echo $contarchivos;
                                        if ($mat->tipo!="E") {
                                            if ($mat->mostrardt=="NO") $detalle="";
                                            echo "<div class='col-12 ml-sm-2 pl-sm-3 pb-4'>$detalle</div>" ;
                                        }
                                    ?>                                
                                </div>
                            </div>

                            <?php 

                        }
                    }

                    ?>
                        
                        
                   
                    <?php } ?>
           
                </ul>
                
            </div>
            
        </div>
        
    </section>
</div>

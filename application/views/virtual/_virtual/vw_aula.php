<?php $vbaseurl=base_url();
function getIconoMaterial($nombre){
    $icon="<i class='fas fa-download mr-2'></i>";
    $ext          = explode(".", $nombre);
    $exten    = end($ext);
    if ($exten=="pdf"){
        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'>";
    }
    else if(($exten=="mp4")||$exten=="mpg"){
        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_vdo.png' alt='VÍDEO'>";
    }
    else if(($exten=="jpg")||$exten=="png"){
        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_img.png' alt='IMAGEN'>";
    }
    else if(($exten=="doc")||$exten=="docx"){
        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_word.png' alt='WORD'>";
    }
    return $icon;
}
?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.css">-->
<div class="content-wrapper">
     <div class="modal fade" id="modal-selecttipo" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <input id="vdv" name="vdv" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->division) ?>">
                <input id="vcc" name="vcc" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->codcarga) ?>">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Agregar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id='frm-settype' name='frm-settype'  action='<?php echo base_url().'curso/virtual/agregar/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division);?>' method='get' accept-charset='utf-8'>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <input id="pad" name="pad" type="hidden" class="form-control" value="">
                                <input id="num" name="num" type="hidden" class="form-control" value="">

                                
                                <div class="brcheck">
                                    <input data-texto="Agrupación" data-msj="Identifica distintos ítems como partes de un solo grupo o tema" class="check" type="radio" name="type" id="rbetiquetaes" value="ES" checked/>
                                    <label class="check__label" for="rbetiquetaes">
                                        <i class="fas fa-check"></i>
                                        <span class="texto">Agrupación</span>
                                    </label>
                                </div>
                                <div class="brcheck">
                                    <input data-texto="Archivo" data-msj="Permite a los profesores proveer un Archivo como un recurso del curso" class="check" type="radio" name="type" id="rbetiquetaa" value="A" />
                                    <label class="check__label" for="rbetiquetaa">
                                        <i class="fas fa-check"></i>
                                        <span class="texto">Archivo</span>
                                    </label>
                                </div>
                                <div class="brcheck">
                                    <input data-texto="Video Youtube" data-msj="Permite al profesor mostrar videos de la plataforma YOUTUBE" class="check" type="radio" name="type" id="rbetiquetavy" value="Y" />
                                    <label class="check__label" for="rbetiquetavy">
                                        <i class="fas fa-check"></i>
                                        <span class="texto">Video Youtube</span>
                                    </label>
                                </div>
                                <div class="brcheck">
                                    <input data-texto="Link / URL" data-msj="Permite que el profesor pueda proporcionar un enlace de Internet como un recurso del curso" class="check" type="radio" name="type" id="rbetiquetaurl" value="L"  />
                                    <label class="check__label" for="rbetiquetaurl">
                                        <i class="fas fa-check"></i>
                                        <span class="texto">Link / URL</span>
                                    </label>
                                </div>
                                <div class="brcheck">
                                    <input data-texto="Tarea" data-msj="Las tareas permite al docente asignar trabajos encargados, ademas los estudiantes pueden presentar cualquier contenido digital, como documentos de texto, hojas de cálculo, imágenes, audio y vídeos entre otros" class="check" type="radio" name="type" id="rbetiquetatarea" value="T"  />
                                    <label class="check__label" for="rbetiquetatarea">
                                        <i class="fas fa-check"></i>
                                        <span class="texto">Tarea</span>
                                    </label>
                                </div>
                                
                                
                                <div class="brcheck">
                                    <input data-texto="Foro" data-msj="El foro permite a los participantes tener discusiones y debates, exponiendo sus ideas y respondiendo a las opiniones de sus compañeros." class="check" type="radio" name="type" id="rbforo" value="F"  />
                                    <label class="check__label" for="rbforo">
                                        <i class="fas fa-check"></i>
                                        <span class="texto">Foro</span>
                                    </label>
                                </div>
                                <div class="brcheck">
                                    <input data-texto="Etiqueta" data-msj="Las etiquetas son muy versátiles, permite insertar texto y elementos multimedia en las páginas del curso entre los enlaces a otros recursos" class="check" type="radio" name="type" id="rbetiquetae" value="E" />
                                    <label class="check__label" for="rbetiquetae">
                                        <i class="fas fa-check"></i>
                                        <span class="texto">Etiqueta</span>
                                    </label>
                                </div>
                                 <div class="brcheck">
                                    <input data-texto="Evaluación" data-msj="Permite al docente realizar una determinada cantidad de preguntas en un limite de tiempo, y asignar una puntuación" class="check" type="radio" name="type" id="rbevalua" value="V" />
                                    <label class="check__label" for="rbevalua">
                                        <i class="fas fa-check"></i>
                                        <span class="texto">Evaluación</span>
                                    </label>
                                </div>
                                <!--<div class="brcheck">
                                    <input class="check" type="radio" name="type" id="rbcuestionario" value="V"  />
                                    <label class="check__label" for="rbcuestionario">
                                        <i class="fas fa-check"></i>
                                        <span class="texto">Cuestionario</span>
                                    </label>
                                </div>-->
                            </div>
                            <div class="col-12 col-md-6 ">
                                <div class="row">
                                    <h4 id="mdtitulo" class="col-12 text-bold">
                                       Agrupación
                                    </h4>
                                    <div id="mddescripcion" class="col-12 bg-lightgray text-justify">
                                        Identifica distintos ítems como partes de un solo grupo o tema
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary float-right" type="submit" >Agregar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
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
                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Mis cursos</a>
                </li>
                <li class="breadcrumb-item">
                    
                    <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
                    </a>
                </li>
                
              <li class="breadcrumb-item active">Aula Virtual</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div id="divcard-evaluaciones" class="card card-success">
            
            <div class="card-header with-border">
                <div class="row">
                    <div id="divperiodo" class="col-12 col-md-4">Periodo: <b><?php echo $curso->periodo; ?></b></div>
                    <div id="divcarrera" class="col-12 col-md-8">Carrera: <b><?php echo $curso->carrera; ?></b></div>
                    <div id="divciclo" class="col-6 col-md-4">Ciclo: <b><?php echo $curso->codciclo; ?></b></div>
                    <div id="divturno" class="col-6 col-md-4">Turno: <b><?php echo $curso->codturno; ?></b></div>
                    <div id="divseccion" class="col-6 col-md-4">Sección: <b><?php echo $curso->codseccion.$curso->division; ?></b></div>
                </div>
            </div>
        </div>
        
        <div class="card" id="divcard-indicadores">
            <div class="card-header">
                <h3 class="card-title text-bold">Aula Virtual</h3>
                <div class="card-tools">
                  <button id="btn-a-order" data-status='f' type="button" class="btn btn-outline-secondary py-0"><i class="fas fa-sort"></i></button>
                  <button id="btn-d-order" data-status='f' type="button" class="btn btn-secondary py-0"><i class="fas fa-sort"></i></button>
                </div>
            </div>
            <div class="card-body p-2">
                <ul class="order-list" >
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
                                        $archivo=base_url()."curso/virtual/archivos/$codmat/$coddet/".url_clear($file->nombre);
                                       
                                        $icon=getIconoMaterial($file->nombre);
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
                                        $archivo=base_url()."curso/virtual/archivos/$codmat/$coddet/$file->nombre";
                                        $icon=getIconoMaterial($file->nombre);
                                    }
                                    $nombre="
                                                <a target='_blank' class='text-danger' href='$archivo'>$icon $mat->nombre</a>";
                                    $detalle=$mat->detalle;
                                }
                                unset($files);
                                unset($arr_arch[$mat->codigo]);
                            }
                            else{
                                $nombre="
                                                <span target='_blank' class='text-warning'><i class='fas fa-download mr-2'></i> $mat->nombre (sin archivos)</span>";
                                $detalle=$mat->detalle;
                            }
                            break;
                        case 'Y':
                            $icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_ytb.png' alt='Youtube'>";
                            $nombre="$icon <span class='text-danger' style='vertical-align: middle;display: inline-block'>$mat->nombre</span>";
                            $detalle='<div class="col-12 col-sm-8 offset-sm-2  col-md-6 offset-md-3 align-self-center py-3">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$mat->link.'" allowfullscreen></iframe>
                                        </div>
                                    </div>';
                            //$detalle="<p class='text-center'><iframe frameborder='0' allowfullscreen='true' src='//www.youtube.com/embed/$mat->link' height='200' class=note-video-clip'></iframe></p>";
                            break;
                        case 'T':
                            $icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_tarea.png' alt='TAREA'>";
                            $archivo=base_url().'curso/virtual/tarea/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo);
                            $nombre="<a class='text-danger' href='$archivo'>$icon <span>$mat->nombre</span></a>";
                            $detalle=$mat->detalle;
                            break;
                         case 'F':
                            $icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_foro.png' alt='TAREA'>";
                            $archivo=$mat->link;
                            $ira = base_url().'curso/virtual/foro/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo);
                            $nombre="<a class='text-danger' href='$ira'>$icon <span>$mat->nombre</span></a>";
                            $detalle=$mat->detalle;
                            break;
                        case 'V':
                            $icon="<img class='mr-1' style='vertical-align: middle;display: inline-block' src='".base_url()."resources/img/icons/p_cuestionario.png' alt='TAREA'>";
                            $archivo=base_url().'curso/virtual/evaluacion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo);
                            $nombre="<a class='text-danger' href='$archivo'>$icon <span>$mat->nombre</span></a>";
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
                    <li data-tipo='<?php echo $mat->tipo ?>' data-id="<?php echo $mat->codigo ?>" data-espacio='<?php echo $esp ?>' class="espaciol-<?php echo $esp  ?>">
                        
                        <div class="col-12 px-0 py-2">
                            <div class="row p-0">
                                
                                <?php echo "<div class='col-9 pt-1'>
                                    <i class='icon-move fas fa-arrows-alt move mr-2 text-dark'></i> $nombre
                                </div>";
                                $textxolor="text-primary";
                                if (($mat->tipo=="E") && ($mat->mostrardt=="SI")) $textxolor="text-bold"
                                 ?>
                                <div class="col-3 pt-1 pr-3 text-right">
                                    <!-- Example single danger button -->
                                    <div class="btn-group">
                                      <a type="button" class="<?php echo $textxolor ?> dropdown-toggle pl-0 pr-2 py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                      </a>
                                      <div class="dropdown-menu dropdown-menu-right">
                                        
                                        <?php if (($mat->tipo=="E") && ($mat->mostrardt=="SI")){ ?>
                                            <a class="dropdown-item btn-anexar" data-padre='0' data-norden='<?php echo ($norden + 1) ?>' href="#" data-toggle="modal" data-target="#modal-selecttipo"><i class="fa fa-plus mr-1"></i> Añade una actividad o un recurso</a>
                                        <?php } ?>
                                        <a class="dropdown-item" href="<?php echo base_url().'curso/virtual/editar/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo).'?type='.$mat->tipo;?>">
                                            <i class='btn-editar fas fa-edit mr-2'></i> Editar 
                                        </a>
                                        
                                        <?php $mdr=($esp<5)? "":"disabled" ?>
                                        <a class="btn-espacio dropdown-item <?php echo $mdr ?>" data-dir='1' href="#"><i class="fas fa-arrow-right mr-2"></i> Mover a la derecha</a>
                                        <?php $miz=($esp>0)? "":"disabled" ?>
                                        <a class="btn-espacio dropdown-item <?php echo $miz ?>" data-dir='-1' href="#"><i class="fas fa-arrow-left mr-2"></i> Mover a la izquierda</a>
                                       
                                        <!--<a class="dropdown-item" href="#"><i class="fas fa-eye mr-2"></i> Ocultar</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-eye-slash mr-2"></i> Mostrar</a>-->
                                        
                                        <a class="btn-duplicar dropdown-item" href="#"><i class="far fa-copy mr-2"></i> Duplicar</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btn-eliminar  text-danger" href="#">
                                            <i class='fas fa-trash mr-3'></i> Borrar
                                        </a>
                                      </div>
                                    </div>
                                </div>
                                <?php echo $contarchivos ?>
                                <?php 
                                if ($mat->tipo!="E") {
                                    if ($mat->mostrardt=="SI"){
                                        echo "<div class='col-12 ml-2 pl-3 pb-3'>$detalle</div>" ;
                                    } 
                                   
                                }
                                ?>
                            </div>
                        </div>
                        <!--<small class="badge <?php //echo //$bcolor ?>"><i class="far fa-clock"></i> Abierto</small>-->
                        

                    </li>
                    <?php } ?>
           
                </ul>
                <a class="float-right mt-2 btn-anexar" data-padre='0' data-norden='<?php echo ($norden + 1) ?>' href="#" data-toggle="modal" data-target="#modal-selecttipo"><i class="fa fa-plus mr-1"></i> Añade una actividad o un recurso</a>
            </div>
            
        </div>
        
    </section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/virtual-v6.js"></script>
<script>
var vccaj = '<?php echo $curso->codcarga ?>';
var vsscj = '<?php echo $curso->division ?>';
var vccajcode = '<?php echo base64url_encode($curso->codcarga) ?>';
var vsscjcode = '<?php echo base64url_encode($curso->division) ?>';
</script>
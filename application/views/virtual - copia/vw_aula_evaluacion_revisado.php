<?php $vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
function echocard($vnum,$pgta){

        $colorcard=($pgta->codpregunta==0)?"card-danger":"card-primary";
        $codpregunta=base64url_encode($pgta->codpregunta);
        $pgvalor=floatval($pgta->valor);
        $pgpuntos=floatval($pgta->puntos);
        if ($pgta->correcta=="SI"){
            $pgestado="<span class='text-success fa-lg'><i class='fas fa-check-circle'></i></span>";
        }
        elseif ($pgta->correcta=="NO"){
            $pgestado="<span class='text-danger fa-lg'><i class='fas fa-times-circle'></i></span>";
        }
        else{
            $pgestado="";
        }
        
        //$oblcheck=($pgta->vacio=="SI")?"checked":"";
        echo "<div name='ancla$codpregunta'  id='ancla$codpregunta' class='card-pregunta pregunta card card-outline ml-sm-2 ml-md-3 $colorcard' data-numero='$vnum' data-codpg='$codpregunta' data-tipopg='$pgta->codtipo' data-obligatoria='$pgta->vacio' >
                
                <div class='card-header px-sm-3 text-sm'>
                    <h4 class='card-title'>Pregunta $vnum $pgestado</h4>
                 
                    <div class='card-tools'>
                      Puntaje: <span data-toggle='tooltip' title='$pgvalor puntos' class='tboton bg-primary'>$pgpuntos / $pgvalor</span>
                      
                    </div>
                </div>
                <div class='card-body px-2 px-sm-3 py-2'>
                    <div class='row'>
                        <div class='col-12 col-sm-12'>
                            <div class='row text-sm'>
                                <div class='col-12 col-md-12 mt-1'>
                                    $pgta->enunciado
                                </div>
                                
                                <div class='col-12 mt-1'>
                                    <small>$pgta->enunciadox</small>
                                </div>
                            </div>

                            <div class='divrptas row text-sm pt-3' data-contador='0'>";
                                $nro=0;
                                $tipocheck="radio";
                                if ($pgta->codtipo==4){
                                    $tipocheck="checkbox";
                                }
                                if ($pgta->codtipo==7){
                                    $rptexto=$pgta->texto;
                                    echo "<div class='rpta-radio col-12' data-idrp='0' data-pos='$nro' >
                                        <div class='row text-sm'>
                                            <div class='col-12 col-md-12 mt-1'>
                                               $rptexto
                                            </div>
                                        </div>
                                    </div>";

                                }
                                else
                                {
                                    foreach ($pgta->rpts as $key => $rp) {
                                        $nro++;
                                        $codrp=base64url_encode($rp->codrpta);
                                        $rpcolor="";
                                        $rpicon="far fa-square";
                                        $rpbgcolor="bg-white";
                                        if ($rp->marcada=="SI"){
                                           $rpicon="fas fa-check";
                                           if ($rp->correcta=="NO"){
                                                $rpcolor="text-white";
                                                $rpbgcolor="bg-danger";
                                                $rpicon="fas fa-times";
                                            }
                                        }
                                        if ($rp->correcta=="SI"){
                                            $rpcolor="text-white";
                                            $rpbgcolor="bg-success";
                                        }
                                        //echo $rp->marcada;
                                        
                                        echo "<div class='rpta-radio col-12' data-idrp='$codrp' >
                                            <div class='input-group input-group-sm mb-1'>
                                              <div class='input-group-prepend'>
                                                <div class='input-group-text $rpbgcolor'>
                                                  <span ><i class='$rpicon $rpcolor'></i></span>

                                                </div>
                                              </div>
                                              <span class='form-control '>$rp->enunciado</span>
                                              
                                            </div>
                                        </div>"; 
                                    }

                                }
                           echo "</div>";
                    echo "</div>
                    <div class='diverror col-12 text-danger'>
                
                    </div>

                    </div>";
                    
                    
                    echo "<hr>

                </div>
            </div>";
}
?>
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $curso->unidad ?>
                    <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
                </div>
                 <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fas fa-caret-right"></i> Mis Unidades didácticas</a>
                        </li>
                        
                        <li class="breadcrumb-item">
                            
                            <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>">Panel
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>">Aula Virtual
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/evaluacion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo); ?>">Evaluación
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/evaluacion/revisar/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo); ?>">Entregas
                            </a>
                        </li>
                      <li class="breadcrumb-item active">Revisar</li>
                    </ol>
                  </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content ">
        <?php include 'vw_aula_encabezado.php'; ?>
            <input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->division) ?>">
            <input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->codcarga) ?>">
            <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo base64url_encode($mat->codigo) ?>">
            <input id="vcodmiembro" name="vcodmiembro" type="hidden" class="form-control" value="<?php echo $vcodmiembro ?>">
            <input id="vcodentrega" name="vcodentrega" type="hidden" class="form-control" value="0">
            
            <div class="card border-light">
                <?php
                
                $nombre="";
                $fvence="";
               
                $finicia="";
                $ptsmax=20;
                if (isset($mat->nombre))  $nombre=$mat->nombre;
                if (isset($mat->vence))  $fvence=$mat->vence;
                if (isset($mat->inicia))  $finicia=$mat->inicia;
                if (isset($mat->ptsmax))  $ptsmax=$mat->ptsmax;
                

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
                <div class="card-header border px-2 px-sm-3">
                    <h3 class="card-title text-bold"> <?php echo $nombre ?></h3>
                    <div class='card-tools'>
                       <h3>Total: <span class='badge badge-primary'><?php echo $ntotal ?> / <span class="vw_aee_spn_ptotal"></span></span></h3>
                      
                    </div>
                    <br>
                    Culmina: <?php echo $fechav." - ".$horav ?>
                    
                </div>
            </div>
        <div class="container-fluid">
            <?php 
            $nropregunta=0;
            $ptotal=0;
            foreach ($preguntas as $key => $pregunta) {
                $nropregunta++;
                $rp=array();
                if (isset($respuestas[$pregunta->codpregunta])) $rp=$respuestas[$pregunta->codpregunta];
                //var_dump($rp);
                $ptotal=$ptotal + $pregunta->valor;
                echocard($nropregunta,$pregunta);
            }
            ?>
            <!--AQUI TERMINA EL DIV DE PREGUNTA INDIVIDUAL
            <div class="rpta-radio col-12 ocultar" data-idrp="0" data-delete="0" data-pos="">
                <div class="input-group mb-1">
                  <div class="input-group-prepend">
                    <div class="input-group-text" onclick="clickradio($(this));">
                      <input class="vw_aep_rptacheck" type="radio">
                    </div>
                  </div>
                  <input type="text" class="form-control rp-enunciado" >
                  <div class="input-group-append">
                    <a href='#' class='btn btn-default' onclick='delrpta($(this));event.preventDefault();'> <i class='far fa-trash-alt text-danger'></i></a>
                  </div>
                </div>
            </div>-->


            
            <div class="card border-light">
                <div class="card-footer text-center">
                    <a href="<?php echo $vbaseurl.'curso/virtual/evaluacion/revisar/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'. base64url_encode($mat->codigo); ?>" class="btn btn-secondary float-left">Volver</a>
                   
                </div>
            </div>
            
            
       <!-- </form>-->
        </div>
    </section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script>
    $(document).ready(function() {
        $(".vw_aee_spn_ptotal").html('<?php echo $ptotal ?>')
    });
</script>
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
                        <a href="<?php echo $vbaseurl ?>docnete/mis-cursos"><i class="fas fa-compass"></i> Mis cursos</a>
                    </li>
                    <li class="breadcrumb-item">
                        
                        <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        
                        <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>">Aula Virtual
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
        <div id="divcard-evaluaciones" class="card card-success">
            
            <div class="card-header">
                <h3 class="card-title text-bold"><a href="#">Tarea</a></h3>
            </div>
            <div class="card-header with-border bg-light">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <span class="col-4">Periodo:</span>
                            <span id="divperiodo" class="col-8"><b><?php echo $curso->periodo; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <span class="col-4 col-md-3">Prog. Académico:</span>
                            <span id="divcarrera" class="col-8 col-md-9"><b><?php echo $curso->carrera; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <span class="col-4">Ciclo:</span>
                            <span id="divciclo" class="col-8"><b><?php echo $curso->codciclo; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <span class="col-4 col-md-6">Turno:</span>
                            <span id="divturno" class="col-8 col-md-6"><b><?php echo $curso->codturno; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <span class="col-4">Sección:</span>
                            <span id="divseccion" class="col-8"><b><?php echo $curso->codseccion.$curso->division; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <span class="col-4 col-md-2">Docente:</span>
                            <span id="divdocente" class="col-8 col-md-10"><b><?php echo "$curso->docpaterno $curso->docmaterno $curso->docnombres"; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <span class="col-4 col-md-2">Correo:</span>
                            <span id="divdocente" class="col-8 col-md-10"><b><?php echo "$curso->docemail"; ?></b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id='frm-insertupdate' name='frm-insertupdate'   method='post' accept-charset='utf-8'>
            <?php
            $vid=0;
            if (isset($tentregada->codtarea))  $vid=$tentregada->codtarea;
            $vbaseurl=base_url();
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
            <!-- @vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion-->
            
            <input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->division) ?>">
            <input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->codcarga) ?>">
            <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo base64url_encode($mat->codigo) ?>">
            <input id="vid" name="vid" type="hidden" class="form-control" value="<?php echo  $vid?>">

            
            <div class="card border-light">
                 <?php
                date_default_timezone_set('America/Lima');
                $fechav = "Sin límite";
                $horav = "";
                if ($fvence!=""){
                $fechav = fechaCastellano($fvence);
                $horav = date('h:i a',strtotime($fvence));
                }
                $fechai = "";
                $horai = "";
                $tiniciar=true;
                if ($finicia!=""){
                $fechai = fechaCastellano($finicia);
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
                <div class="card-header border px-2 px-sm-3">
                    <h3 class="card-title text-bold"> <?php echo $nombre ?></h3>
                    Vence: <?php echo $fechav." - ".$horav ?>
                </div>
               
                <div class="card-body px-1 px-sm-3">
                    
                    <div class="btable">
                      <div class="thead d-none d-md-block col-12">
                        <div class="row">
                            <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4 td">Carné</div>
                                        <div class="col-md-8 td">Alumno</div>
                                    </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-8 col-md-9 td">Entregó</div>
                                        <div class="col-4 col-md-3 td text-center">
                                           Nota
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-3 td">
                                    Archivos
                            </div>

                        </div>
                      </div>
                        <div id="div-filtro" class="tbody col-12">
                            <?php 
                            $cdfecentrega="<span class='text-danger'>Tarea sin entregar</span>";
                            $cdnota="Calificar";
                            $cdmiembro="0";
                            $cdcodentrega="0";
                            $cdarchivos="";

                            foreach ($miembros as $keymb => $mb){
                            if ($mb->eliminado=="NO"){
                                $cdmiembro= base64url_encode($mb->idmiembro); ?>
                            <div data-centrega="" class="row rowcolor">
                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="ccarne col-12 col-sm-3 col-md-4 td"><?php echo $mb->carnet ?> </div>
                                        <div class="calumno col-12 col-sm-9 col-md-8 td"><?php echo "$mb->paterno $mb->materno $mb->nombres" ?></div>
                                    </div>
                                </div>
                                <?php foreach ($entregas as $keyet => $et){
                                    if ($mb->idmiembro==$et->codmiembro){
                                        $cdnota= ($et->nota=="") ? "Calificar" : str_pad($et->nota, 2, "0", STR_PAD_LEFT);
                                        $cdcodentrega=base64url_encode($et->codtarea);
                                        if ($et->fentrega!=""){
                                            $cdfecentrega="<span class='d-block d-sm-none'>Entregado:</span>".fechaCastellano($et->fentrega)." ".date("h:i a",strtotime($et->fentrega));
                                            if (($fvence!="") && (strtotime($et->fentrega)>strtotime($fvence))) $cdfecentrega=$cdfecentrega."<br>".hms_restantes($fvence,$et->fentrega);
                                        }
                                        unset($entregas[$keyet]);
                                    }
                                } ?>
                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="ccarne col-8 col-md-9 td"> <?php echo $cdfecentrega ?> </div>
                                        <div class="calumno col-4 col-md-3 td text-center">
                                            <a data-miembro="<?php echo $cdmiembro ?>" data-entrega="<?php echo $cdcodentrega ?>" class="btn-calificar bg-primary py-1 px-2 d-block rounded" href="#">
                                                <?php echo $cdnota ?> <i class="fas fa-pencil-alt ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <?php foreach ($varchivosentrega as $keyae => $ae){
                                        if ($mb->idmiembro==$ae->codmiembro){
                                            $codmat=base64url_encode($ae->codentrega);
                                            $coddet=base64url_encode($ae->coddetalle);
                                            $archivo=base_url()."alumno/curso/virtual/archivos/$codmat/$coddet/".url_clear($ae->nombre);
                                        
                                            $icon=getIcono('P',$ae->nombre);
                                            $cdarchivos=$cdarchivos."<span class='py-1 d-block'><a href='$archivo' class='text-danger' target='_blank'>$icon $ae->nombre </a></span>";
                                        }
                                     } ?>
                                <div class="col-12 col-md-3 td">
                                    <?php echo ($cdarchivos=="") ? "Sin archivos" : $cdarchivos ?>
                                </div>
                               

                            </div>
                            <?php   }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-secondary float-left">Volver</a>
                   
                    
                    
                </div>
            </div>
            
            
        </form>
    </section>
</div>

<script>
    //var jsmiembros = <?php echo json_encode($miembros) ?>;
    //var jsentregas = <?php echo json_encode($entregas) ?>;

    $(".btn-calificar").click(function(event) {
        var btn=$(this);
        var ajcodtarea=$("#vidmaterial").val();
        var ajcodcarga=$("#vidcurso").val();
        var ajcoddivision=$("#vdivision").val();
        var ajnota=0;
        var ajcodmiembro=btn.data('miembro');
        var ajcodentrega=btn.data('entrega');

        (async () => {const { value: vdocente } = await Swal.fire({
        title: 'Nota',
        input: 'text',
        inputPlaceholder: 'Ingresa un Número',
        showCancelButton: true,
        confirmButtonText:
        '<i class="fa fa-thumbs-up"></i> Guardar!',
         inputValidator: (value) => {
            return new Promise((resolve) => {
              if ((value<0)|| (value>20)) {
                resolve('Para guardar, debes ingresar una calificación entre 0 y 20');
              }
              else{
                $.ajax({
                        url: base_url + 'virtualtarea/fn_calificar',
                        type: 'POST',
                        data: {"ajcodtarea": ajcodtarea,
                            "ajcodcarga": ajcodcarga,
                            "ajcoddivision":ajcoddivision,
                            "ajnota":value,
                            "ajcodmiembro":ajcodmiembro,
                            "ajcodentrega": ajcodentrega },
                        dataType: 'json',
                        success: function(e) {
                            //$('#divcard_grupo #divoverlay').remove();
                            if (e.status==true){
                                if (value=="") value="Calificar "
                                btn.html(value + '<i class="fas fa-pencil-alt ml-2"></i>');
                                if (ajcodentrega==0){
                                    btn.data('entrega',e.newid);
                                }
                                resolve();
                            }
                            else{
                                resolve(e.msg);
                            }
                        },
                        error: function(jqXHR, exception) {
                            //$('#divcard_grupo #divoverlay').remove();
                            var msgf = errorAjax(jqXHR, exception, 'text');
                            $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
                        }
                    })
              }
            })
          },

        allowOutsideClick: false
        })

        })()
    });

</script>


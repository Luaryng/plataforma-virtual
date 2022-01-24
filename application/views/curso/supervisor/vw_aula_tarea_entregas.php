<?php 
$vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
$codcarga64=base64url_encode($curso->codcarga);
$coddivision64=base64url_encode($curso->division);
?>
<div class="content-wrapper">
    <!-- Modal -->
    <div class="modal fade" id="md_rpta_entrega" tabindex="-1" role="dialog" aria-labelledby="md_rpta_entregaLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="md_rpta_entregaLabel">Respuesta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-12 text-bold" id="md_title_estudiante">
                </div>
                <div class="col-12" id="md_rpta">
                </div>
                <div class="col-12" id="md_archivos">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar </button>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <?php include 'vw_curso_encabezado_items_aula.php'; ?>
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
            
            <input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  $coddivision64 ?>">
            <input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  $codcarga64 ?>">
            <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo base64url_encode($mat->codigo) ?>">
            <input id="vid" name="vid" type="hidden" class="form-control" value="<?php echo  $vid?>">

            
            <div class="card ">
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
                <div class="card-header border px-2 px-sm-3">
                    <h3 class="card-title text-bold"> <?php echo $nombre ?></h3><br>
                    Vence: <?php echo $fechav." - ".$horav ?><br>
                    <?php echo $detalle ?>
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
                            $cdnota="--";
                            $cdmiembro="0";
                            $cdcodentrega="0";
                            $cdarchivos="";

                            foreach ($miembros as $keymb => $mb){
                                $trdetalle="";
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
                                        $trdetalle=$et->detalle;
                                        $cdnota= ($et->nota=="") ? "--" : str_pad($et->nota, 2, "0", STR_PAD_LEFT);
                                        $cdcodentrega=base64url_encode($et->codtarea);
                                        if ($et->fentrega!=""){
                                            $cdfecentrega="<span class='d-block d-sm-none'>Entregado:</span>".fechaCastellano($et->fentrega,$meses_ES,$dias_ES)." ".date("h:i a",strtotime($et->fentrega));
                                            if (($fvence!="") && (strtotime($et->fentrega)>strtotime($fvence))) $cdfecentrega=$cdfecentrega."<br>".hms_restantes($fvence,$et->fentrega);
                                        }
                                        unset($entregas[$keyet]);
                                    }
                                } ?>
                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="col-8 col-md-9 td"> <?php echo $cdfecentrega ?> </div>
                                        <div class="col-4 col-md-3 td text-center">
                                            <span >
                                                <?php echo $cdnota ?> 
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <?php 
                                $cdarchivos="";
                                foreach ($varchivosentrega as $keyae => $ae){
                                    if ($mb->idmiembro==$ae->codmiembro){

                                        $codmat=base64url_encode($ae->codentrega);
                                        $coddet=base64url_encode($ae->coddetalle);
                                        $archivo=base_url()."alumno/curso/virtual/archivos/$codmat/$coddet";
                                    
                                        $icon=getIcono('P',$ae->nombre);
                                        $cdarchivos=$cdarchivos."<span class='py-1 d-block'><a href='$archivo' class='text-danger' target='_blank'>$icon $ae->nombre </a></span>";
                                    }
                                } ?>
                                <div class="col-12 col-md-3 td vw_vte_div_archivos">
                                   <?php echo ($cdarchivos=="") ? "Sin archivos" : $cdarchivos ?>
                                </div>
                                <div class="col-1 col-md-1 td">
                                    <a href="#" data-detalle='<?php echo $trdetalle ?>' class="tboton bg-primary vw_vte_btn-verentrega" data-toggle="modal" data-target="#md_rpta_entrega">
                                      Ver
                                    </a>

                                </div>
                               
 
                            </div>
                            <?php   }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="<?php echo $vbaseurl.'monitoreo/docente/curso/'.$codcarga64.'/'.$coddivision64.'/aula-virtual'; ?>" class="btn btn-secondary float-left">Volver</a>
                </div>
            </div>
            
            
        </form>
    </section>
</div>

<script>
    //var jsmiembros = <?php echo json_encode($miembros) ?>;
    //var jsentregas = <?php echo json_encode($entregas) ?>;
    $('.vw_vte_btn-verentrega').click(function(event) {
        event.preventDefault();
        $('#md_rpta_entrega').modal('show');
        var row=$(this).closest('.rowcolor');
        $('#md_rpta_entrega #md_title_estudiante').html(row.find('.calumno').html());
        $('#md_rpta_entrega #md_rpta').html($(this).data('detalle'));
        $('#md_rpta_entrega #md_archivos').html(row.find('.vw_vte_div_archivos').html());
    });
    
   

</script>


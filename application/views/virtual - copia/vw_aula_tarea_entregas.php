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
        <div class="modal fade" id="md_rpta_entrega" tabindex="-1" role="dialog" aria-modal="true" data-backdrop="static" data-keyboard="false" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="md_en_content">
              <div class="modal-header">
                <h5 class="modal-title border rounded bg-lightgray px-1" id="md_title_estudiante">Respuesta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group row">
                    <label for="md_en_nota" class="col-md-1 col-form-label">Nota:</label>
                    <div class="col-md-5">
                      <input data-value="" id="md_en_nota" type="text" class="form-control form-control-sm" value="">
                    </div>
                    <label for="md_en_observacion" class="col-md-12 col-form-label">Observaciones:</label>
                    <div class="col-md-12">
                      <textarea data-value="" id="md_en_observacion" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    
                    <div class="col-12" id="md_archivos">
                    </div>
                    <div class="col-12 pt-2 text-bold">
                            Mensaje:
                    </div>
                    <div class="col-12 py-2">
                        <div class="col-12 border rounded py-2" id="md_rpta">
                        </div>
                    </div>
                    
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="md_ent_btn-calificar" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Guardar</button>
                
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $curso->unidad ?>
                    <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/panel/'.$codcarga64.'/'.$division64; ?>"><i class="fas fa-caret-right"></i> Panel</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/'.$codcarga64.'/'.$division64; ?>"><i class="fas fa-caret-right"></i> Aula virtual
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/tarea/'.$codcarga64.'/'.$division64.'/'.$codmaterial64; ?>"><i class="fas fa-caret-right"></i> Tarea
                            </a>
                        </li>
                        
                        <li class="breadcrumb-item active">Revisar</li>
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

                $codigocarga = base64url_encode($curso->codcarga);
                $codigodivision = base64url_encode($curso->division);
                $codigomaterial = base64url_encode($mat->codigo);

                ?>
                <div class="card-header border px-2 px-sm-3">
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm dropdown-toggle py-1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                            Exportar
                            <i class="fa fa-download"></i>
                        </button> 
                        <div class="dropdown-menu  dropdown-menu-right"> 
                            <a target="_blank" href="<?php echo $vbaseurl.'curso/virtual/tarea/pdf/'.$codigocarga.'/'.$codigodivision.'/'.$codigomaterial ?>" class="btn-cestado dropdown-item"><i class="far fa-file-pdf mr-1"></i> Pdf</a>
                            <a target="_blank" href="<?php echo $vbaseurl.'curso/virtual/tarea/excel/'.$codigocarga.'/'.$codigodivision.'/'.$codigomaterial ?>" class="btn-cestado dropdown-item"><i class="far fa-file-excel mr-1"></i> Excel</a>
                        </div>
                    </div>
                    <h3 class="card-title text-bold"> <?php echo $nombre ?></h3><br>
                    Vence: <?php echo $fechav." - ".$horav ?>
                    
                </div>
               
                <div class="card-body px-1 px-sm-3">
                    
                    <div class="btable">
                      <div class="thead d-none d-md-block col-12">
                        <div class="row">
                            <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4 td">Carné</div>
                                        <div class="col-md-8 td">Estudiante</div>
                                    </div>
                            </div>
                            <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-8 col-md-10 td">Entregó</div>
                                        <div class="col-4 col-md-2 td text-center">
                                           Nota
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-3 td">
                                    Observaciones
                            </div>

                        </div>
                      </div>
                        <div id="div-filtro" class="tbody col-12">
                            <?php 
                            
                            $cdnota="00";
                            $cdmiembro="0";
                            $cdcodentrega="0";
                            $cdarchivos="";

                            foreach ($miembros as $keymb => $mb){
                                $cdcodentrega="0";
                                $cdnota="00";
                                $cdfecentrega="<span class='text-danger'>Tarea sin entregar</span>";
                                 $trdetalle="";
                                 $trobservacion="";
                            if ($mb->eliminado=="NO"){
                                $cdmiembro= base64url_encode($mb->idmiembro);
                                foreach ($entregas as $keyet => $et){
                                    if ($mb->idmiembro==$et->codmiembro){
                                        $trobservacion=(is_null($et->observacion))? "": trim($et->observacion);
                                        $trdetalle=$et->detalle;
                                        $cdnota= ($et->nota=="") ? "00" : str_pad($et->nota, 2, "0", STR_PAD_LEFT);
                                        $cdcodentrega=base64url_encode($et->codtarea);
                                        if ($et->fentrega!=""){
                                            $cdfecentrega="<span class='d-block d-sm-none'>Entregado:</span>".fechaCastellano($et->fentrega,$meses_ES,$dias_ES)." ".date("h:i a",strtotime($et->fentrega));
                                            if (($fvence!="") && (strtotime($et->fentrega)>strtotime($fvence))) $cdfecentrega=$cdfecentrega."<br>".hms_restantes($fvence,$et->fentrega);
                                        }
                                        unset($entregas[$keyet]);
                                    }
                                }
                                $cdarchivos="";
                                foreach ($varchivosentrega as $keyae => $ae){
                                    if ($mb->idmiembro==$ae->codmiembro){
                                        
                                        $codmat=base64url_encode($ae->codentrega);
                                        $coddet=base64url_encode($ae->coddetalle);
                                        $archivo=base_url()."alumno/curso/virtual/archivos/$codmat/$coddet";
                                    
                                        $icon=getIcono('P',$ae->nombre);
                                        $cdarchivos=$cdarchivos."<span class='py-1 d-block'><a href='$archivo' class='text-danger' target='_blank'>$icon $ae->nombre </a></span>";
                                    }
                                }
                                ?>
                            <div data-centrega="" class="row rowcolor" data-nota="<?php echo $cdnota ?>" data-miembro="<?php echo $cdmiembro ?>" data-entrega="<?php echo $cdcodentrega ?>">
                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-3 col-md-4 td"><?php echo $mb->carnet ?> </div>
                                        <div class="calumno col-12 col-sm-9 col-md-8 td"><?php echo "$mb->paterno $mb->materno $mb->nombres" ?></div>
                                    </div>
                                </div>
                               
                                <div class="col-12 col-md-5">
                                    <div class="row">
                                        <div class=" col-8 col-md-10 td vw_vte_div_archivos">
                                            <?php echo $cdfecentrega ?> 
                                            <?php echo ($cdarchivos=="") ? "" : $cdarchivos ?>
                                        </div>
                                        <div class="col-4 col-md-2 td text-center">

                                            <a href="#"  data-detalle='' class="tboton bg-primary vw_vte_btn-verentrega" >
                                               <?php echo $cdnota ?> <i class="fas fa-pencil-alt ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 td cobservacion"><?php echo $trobservacion ?></div>
                               

                            </div>
                            <?php   }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="<?php echo $vbaseurl.'curso/virtual/tarea/'.$codcarga64.'/'.$division64.'/'.$codmaterial64; ?>" class="btn btn-secondary float-left">Volver</a>
                   
                    
                    
                </div>
            </div>
            
            
        </form>
    </section>
</div>

<script>
    //var jsmiembros = <?php echo json_encode($miembros) ?>;
    //var jsentregas = <?php echo json_encode($entregas) ?>;
    var fila=null;
    $('#md_rpta_entrega').on('hidden.bs.modal', function (e) {
        fila=null;
    })

    $('.vw_vte_btn-verentrega').click(function(event) {
        event.preventDefault();
        
        var row=$(this).closest('.rowcolor');
        ajcodentrega=row.data('cdcodentrega');
        detalle="";
        fila=row;
        obs=row.find('.cobservacion').html();
        nota=row.data('nota');
        ajcodmiembro=row.data('miembro');
        $.ajax({
            url: base_url + 'virtualtarea/fn_get_tarea_entregada',
            type: 'POST',
            data: {
                "ajcodmiembro":ajcodmiembro,
                "ajcodentrega": ajcodentrega},
            dataType: 'json',
            success: function(e) {
                $('#md_en_content #divoverlay').remove();
                if (e.status==true){
                    detalle=e.entrega['detalle'];
                    
                }
                
            },
            error: function(jqXHR, exception) {
                $('#md_en_content #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                    'Error Ajax!',
                    msgf,
                    'error'
                )
            }
        });




        $('#md_rpta_entrega #md_en_observacion').val(obs);
        $('#md_rpta_entrega #md_en_nota').val(nota);
        $('#md_rpta_entrega #md_en_observacion').data('value',obs);
        $('#md_rpta_entrega #md_en_nota').data('value',nota);
        $('#md_rpta_entrega #md_title_estudiante').html(row.find('.calumno').html());
        
        $('#md_rpta_entrega #md_rpta').html(detalle);

        $('#md_rpta_entrega #md_archivos').html(row.find('.vw_vte_div_archivos').html());
        $('#md_rpta_entrega').modal('show');
    });
    $("#md_ent_btn-calificar").click(function(event) {
        event.preventDefault();
        var ajcodtarea=$("#vidmaterial").val();
        var ajcodcarga=$("#vidcurso").val();
        var ajcoddivision=$("#vdivision").val();
        var ajnota=0;
        var ajcodmiembro=fila.data('miembro');
        var ajcodentrega=fila.data('entrega');
        btn=fila.find(".vw_vte_btn-verentrega");
        var value= $('#md_rpta_entrega #md_en_nota').val();
        var obs= $('#md_rpta_entrega #md_en_observacion').val();
        $('#md_en_content').append('<div id="divoverlay" class="overlay "><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        // $('#md_rpta_entrega #md_en_nota').data('value',nota);
        $.ajax({
            url: base_url + 'virtualtarea/fn_calificar',
            type: 'POST',
            data: {"ajcodtarea": ajcodtarea,
                "ajcodcarga": ajcodcarga,
                "ajcoddivision":ajcoddivision,
                "ajnota":value,
                "ajcodmiembro":ajcodmiembro,
                "ajcodentrega": ajcodentrega,
                "ajobs": obs },
            dataType: 'json',
            success: function(e) {
                $('#md_en_content #divoverlay').remove();
                if (e.status==true){
                    if (value=="") value="00 ";
                    btn.html(value + '<i class="fas fa-pencil-alt ml-2"></i>');
                    if (ajcodentrega==0){
                        fila.data('entrega',e.newid);
                    }
                    fila.find(".cobservacion").html(obs);
                    fila.data("nota",value);
                    fila=null;
                    $('#md_rpta_entrega').modal('hide');
                    
                }
                else{
                    Swal.fire(
                        'Error!',
                        e.msg,
                        'error'
                    )
                }
            },
            error: function(jqXHR, exception) {
                $('#md_en_content #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                    'Error Ajax!',
                    msgf,
                    'error'
                )
            }
        })
        return false;
    });
    /*$(".btn-calificar").click(function(event) {
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
                
              }
            })
          },

        allowOutsideClick: false
        })

        })()
    });*/

</script>


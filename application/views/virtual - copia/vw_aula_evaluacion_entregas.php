<?php $vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
$codigocarga64 = base64url_encode($curso->codcarga);
$codigodivision64 = base64url_encode($curso->division);
$codigomaterial64 = base64url_encode($mat->codigo);

?>
<div class="content-wrapper">

    <section class="content-header">
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
                            
                            <a href="<?php echo $vbaseurl.'curso/panel/'.$codigocarga64.'/'.$codigodivision64; ?>">Panel
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/'.$codigocarga64.'/'.$codigodivision64; ?>">Aula Virtual
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/evaluacion/'.$codigocarga64.'/'.$codigodivision64.'/'.$codigomaterial64; ?>">Evaluación
                            </a>
                        </li>
                      <li class="breadcrumb-item active">Entregas</li>
                    </ol>
                  </div>
            </div>

    </section>
    <!-- Main content -->
    <section class="content">
        <?php include 'vw_aula_encabezado.php'; ?>
        <form id='frm-insertupdate' name='frm-insertupdate'   method='post' accept-charset='utf-8'>
            <?php
            $vid=0;
            if (isset($tentregada->codentrega))  $vid=$tentregada->codentrega;
            
                /*$detalle="";
                $link="";*/
                $nombre="";
                $fvence="";
                //$nfiles=1;
                $fretraso="";
                $finicia="";
                /*if (isset($mat->detalle))  $detalle=$mat->detalle;
                if (isset($mat->link))  $link=$mat->link;*/
                if (isset($mat->nombre))  $nombre=$mat->nombre;
                if (isset($mat->vence))  $fvence=$mat->vence;
                if (isset($mat->inicia))  $finicia=$mat->inicia;
                //if (isset($mat->nfiles))  $nfiles=$mat->nfiles;
                if (isset($mat->retraso))  $fretraso=$mat->retraso;
                
            ?>
            <!-- @vvirt_nombre, @vvirt_tipo, @vvirt_id_padre, @vvirt_link, @vvirt_vence, @vvirt_detalle, @vvirt_norden, @vcodigocarga, @vcodigosubseccion-->
            
            <input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  $codigodivision64 ?>">
            <input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  $codigocarga64 ?>">
            <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo $codigomaterial64 ?>">
            <input id="vid" name="vid" type="hidden" class="form-control" value="<?php echo  $vid?>">

            
            <div id="vw_aee_div_card" class="card border-light">
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
                

                echo 
                "<div class='card-header border px-2 px-sm-3'>
                    <div class='card-tools'>
                        <button class='btn btn-success btn-sm dropdown-toggle py-1' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> 
                            Exportar
                            <i class='fa fa-download'></i>
                        </button> 
                        <div class='dropdown-menu  dropdown-menu-right'> 
                            <a target='_blank' href='{$vbaseurl}curso/virtual/evaluaciones/pdf/$codigocarga64/$codigodivision64/$codigomaterial64' class='btn-cestado dropdown-item'><i class='far fa-file-pdf mr-1'></i> Pdf</a>
                            <a target='_blank' href='{$vbaseurl}curso/virtual/evaluacion/excel/$codigocarga64/$codigodivision64/$codigomaterial64' class='btn-cestado dropdown-item'><i class='far fa-file-excel mr-1'></i> Excel</a>
                        </div>
                    </div>
                    <h3 class='card-title text-bold'>$nombre</h3>
                    <br>Vence: $fechav $horav 
                
                    
                </div>
                ";


                ?>
                
               
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
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-8 col-md-5 td">Entregó</div>
                                    <div cl
                                    ass="col-4 col-md-3 td text-center">
                                       Nota
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                      </div>

                        <div id="div-filtro" class="tbody col-12">
                            <?php 
                            $cdfecentrega="<span class='text-danger'>Tarea sin entregar</span>";
                            $cdnota="";
                            $cdmiembro="0";
                            $cdcodentrega="0";
                            $cdarchivos="";

                            foreach ($miembros as $keymb => $mb){
                                if ($mb->eliminado=="NO"){
                                    $cdmiembro= base64url_encode($mb->idmiembro);

                                    $cdnota="";
                                    $btn_reset_eval="";
                                    $btn_revaluar="";
                                    $cdfecentrega="- Sin entregar";
                                    $cdcodentrega="0";
                                    $clentrega="text-danger";
                                    foreach ($entregas as $keyet => $et){
                                        if ($mb->idmiembro==$et->codmiembro){
                                            $btn_reset_eval="<a class='btn_reset_eval tboton bg-primary ml-1' data-centrega='$cdcodentrega' href='#'><i class='fas fa-undo-alt fa-fw'></i> Reiniciar</a>";

                                            $btn_revaluar="<a class='btn_revaluar tboton bg-primary ml-1' data-centrega='$cdcodentrega' href='#'><i class='fas fa-magic fa-fw'></i> Revaluar</a>";

                                            $cdnota= ($et->nota=="") ? "Calificar" : str_pad(floatval($et->nota), 2, "0", STR_PAD_LEFT);
                                            $cdcodentrega=base64url_encode($et->codentrega);
                                            if ($et->fentrega!=""){
                                                $clentrega="text-success";
                                                $cdfecentrega="<span class='d-block d-sm-none'>Entregado:</span>".fechaCastellano($et->fentrega,$meses_ES,$dias_ES)." ".date("h:i a",strtotime($et->fentrega));
                                                if (($fvence!="") && (strtotime($et->fentrega)>strtotime($fvence))) {
                                                    $clentrega="text-danger";
                                                    $cdfecentrega=$cdfecentrega."<br>".hms_restantes($fvence,$et->fentrega);
                                                }
                                            }
                                            unset($entregas[$keyet]);
                                        }
                                    } ?>
                                <div data-codmiembro='<?php echo $cdmiembro ?>' data-codentrega="<?php echo $cdcodentrega ?>" class="row rowcolor">
                                    <div class="col-12 col-md-4">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 td"><?php echo $mb->carnet ?> </div>
                                            <div class="col-12 col-sm-8 col-md-8 td td-alumno"><?php echo "$mb->paterno $mb->materno $mb->nombres" ?></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-8">
                                        <div class="row">
                                            <?php echo "<div class='col-6 col-md-5 $clentrega td'> {$cdfecentrega} </div>"; ?>
                                            <div class="col-md-1 td text-center bg-info">
                                                <span class="spannota" data-cdevalum='<?php echo $cdcodentrega ?>'><?php echo $cdnota ?></span> 
                                            </div>
                                            <div class="col-2 col-md-2 td text-center">
                                                
                                                <a class='tboton bg-primary' href='<?php echo base_url()."curso/virtual/evaluacion/revisado/$codigocarga64/$codigodivision64/$codigomaterial64/$cdmiembro";?>'>Ver</a>
                                            </div>
                                            <div class="col-4 col-md-2 td text-center">
                                                
                                                <?php echo "$btn_reset_eval"; ?>
                                                
                                            </div>
                                            <div class="col-4 col-md-2 td text-center">
                                                
                                                   <?php echo "$btn_revaluar"; ?>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <?php foreach ($rptxrev as $keyae => $ae){
                                            if ($mb->idmiembro==$ae->codmiembro){
                                                $codrptaentregada=base64url_encode($ae->codrptaentregada);
                                                $codpregunta=base64url_encode($ae->codpregunta);
                                                $en_extra="";
                                                if (trim($ae->enunciado_extra)!=""){
                                                       $en_extra="<i>&nbsp;&nbsp;".htmlspecialchars(stripslashes($ae->enunciado_extra))."</i><br>";
                                                }
                                                
                                                echo "<div class='col-12 divrespuesta'>";
                                                echo "<div class='row'>";
                                                    echo "<div class='col-9 col-md-10 td'>";
                                                        echo "<span><b>> ".str_pad($ae->pos, 2, "0", STR_PAD_LEFT)."- ".htmlspecialchars(stripslashes($ae->enunciado))."</b></span><br>";
                                                        echo $en_extra;
                                                        echo "<span class='text-primary'>* ".htmlspecialchars(stripslashes($ae->texto))."</span><br>";
                                                    echo "</div>";

                                                    echo "<div class='col-3 col-md-2 td text-center'>";
                                                        echo "<span><b>0 / ".floatval($ae->valor)." pts</b></span><br>";
                                                        echo "<a href='#' data-cdrpalum='$codrptaentregada' data-cdpg='$codpregunta' class='btn-calificar-rpta'>Calificar</a>";
                                                    echo "</div>";
                                                echo "</div>";
                                                echo "</div>";
                                                
                                                unset($rptxrev[$keyae]);
                                            }
                                        } ?>
                                </div>
                            <?php   }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href='<?php echo "{$vbaseurl}curso/virtual/evaluacion/$codigocarga64/$codigodivision64/$codigomaterial64"; ?>' class="btn btn-secondary float-left">Volver</a>
                </div>
            </div>
            
            
        </form>
    </section>
</div>

<script>
    //var jsmiembros = <?php echo json_encode($miembros) ?>;
    //var jsentregas = <?php echo json_encode($entregas) ?>;

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
                $.ajax({
                        url: base_url + 'virtualevaluacion/fn_calificar',
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
    });*/

    $(".btn-calificar-rpta").click(function(event) {
        
        event.preventDefault();
        var btn=$(this);
        var rowalumno=btn.closest('.rowcolor');
        var spannota=rowalumno.find('.spannota');
        var cdrpalum=btn.data('cdrpalum');
        var cdpg=btn.data('cdpg');
        var cdeva=spannota.data('cdevalum');


        (async () => {const { } = await Swal.fire({
        title: 'Nota',
        input: 'text',
        inputPlaceholder: 'Ingresa un Número',
        showCancelButton: true,
        confirmButtonText:
        '<i class="fa fa-thumbs-up"></i> Guardar!',
         inputValidator: (value) => {
            return new Promise((resolve) => {
              /*if ((value<0)|| (value>20)) {
                resolve('Para guardar, debes ingresar una calificación numérica');
              }
              else{*/
                $.ajax({
                        url: base_url + 'virtualevaluacion/fn_calificar_respuesta',
                        type: 'POST',
                        data: {"crcodrpalum": cdrpalum,
                            "crcodpg": cdpg,
                            "crcodevalalum":cdeva,
                            "crpuntos":value },
                        dataType: 'json',
                        success: function(e) {
                            //$('#divcard_grupo #divoverlay').remove();
                            if (e.status==true){
                                nota=Number(spannota.html()) + Number(value);
                                spannota.html(nota);
                                btn.closest('.divrespuesta').remove();
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
              //}
            })
          },

        allowOutsideClick: false
        })

        })()
        return false;
    });

    $(".btn_reset_eval").click(function(event) {

        event.preventDefault();
        var btn = $(this);
        var rowalumno = btn.closest('.rowcolor');
        var jsv_codevaluacion = $("#vidmaterial").val();
        var jsv_codentrega = rowalumno.data('codentrega');
        var jsv_codmiembro = rowalumno.data('codmiembro');
        var jsv_alumno = rowalumno.find('.td-alumno').html();
        var jsv_nota = rowalumno.find('.spannota').html();



        Swal.fire({
            title: '¿Deseas RESETEAR la entrega de ' + jsv_alumno + '?',
            text: "Al reiniciar, se eliminará la nota " + jsv_nota + " y el estudiante deberá volver a rendir su evalaución",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, resetear!'
        }).then((result) => {
            if (result.value) {
                $('#vw_aee_div_card').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                $.ajax({
                    url: base_url + 'virtualevaluacion/fn_delete_evaluacion_alumno',
                    type: 'POST',
                    data: {
                        "codevaluacion": jsv_codevaluacion,
                        "codentrega": jsv_codentrega,
                        "codmiembro": jsv_codmiembro
                    },
                    dataType: 'json',
                    success: function(e) {
                        $('#vw_aee_div_card #divoverlay').remove();
                        if (e.status == true) {
                            Swal.fire(
                                'Exito!',
                                'Reseteo  exitoso',
                                'success'
                            )
                            location.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                e.msg,
                                'error'
                            )
                        }
                    },
                    error: function(jqXHR, exception) {
                        $('#vw_aee_div_card #divoverlay').remove();
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        Swal.fire(
                            'Error!',
                            msgf,
                            'success'
                        )
                    }
                })
            }
        })
        return false;
    });

    $(".btn_revaluar").click(function(event) {

        event.preventDefault();
        var btn = $(this);
        var rowalumno = btn.closest('.rowcolor');
        var jsv_codevaluacion = $("#vidmaterial").val();
        var jsv_codentrega = rowalumno.data('codentrega');
        var jsv_codmiembro = rowalumno.data('codmiembro');
        var jsv_alumno = rowalumno.find('.td-alumno').html();
        var jsv_nota = rowalumno.find('.spannota');
        



        Swal.fire({
            title: '¿Deseas Calcular nuevamente la evaluación de ' + jsv_alumno + '?',
            text: "Al revaluar, se eliminará la nota " + jsv_nota.html() + " y se guardará la nueva nota calculada",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, revaluar!'
        }).then((result) => {
            if (result.value) {
                $('#vw_aee_div_card').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                $.ajax({
                    url: base_url + 'virtualevaluacion/fn_revaluar_examen_alumno',
                    type: 'POST',
                    data: {
                        "codevaluacion": jsv_codevaluacion,
                        "codentrega": jsv_codentrega,
                        "codmiembro": jsv_codmiembro
                    },
                    dataType: 'json',
                    success: function(e) {
                        $('#vw_aee_div_card #divoverlay').remove();
                        if (e.status == true) {
                            Swal.fire(
                                'Exito!',
                                'Revaluación  exitosa',
                                'success'
                            )
                            nota=e.nota;
                            jsv_nota.html(nota);
                            //li.remove();
                        } else {
                            Swal.fire(
                                'Error!',
                                e.msg,
                                'error'
                            )
                        }
                    },
                    error: function(jqXHR, exception) {
                        $('#vw_aee_div_card #divoverlay').remove();
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        Swal.fire(
                            'Error!',
                            msgf,
                            'success'
                        )
                    }
                })
            }
        })
        return false;
    });

</script>


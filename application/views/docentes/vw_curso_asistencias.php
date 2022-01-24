<?php  $nfechas=$curso->sesiones;
$vbaseurl=base_url(); ?>
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
                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
                </li>
                <li class="breadcrumb-item">
                    
                    <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
                    </a>
                </li>
                
              <li class="breadcrumb-item active">Asistencias</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section id="s-cargado" class="content">
        
        <?php include 'vw_curso_encabezado.php'; ?>
        <div id="divboxevaluaciones" class="card">
            
            
            <?php
            
             if (!$alumnos){  ?>
                <div class="card-body ">
                    <center>
                    <br><br><br><br>
                    <h2>Evaluaciones no disponibles, comuniquese con el administrador</h>
                    <br>
                </center>
                </div>
            <?php }
            else { ?>
            <div class="card-header">
                <div class="card-tools">
                    <a href="<?php echo $vbaseurl.'curso/asistencias/excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division) ?>" class="btn-excel btn btn-outline-secondary float-rsight"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" class="float-left" alt=""> Exportar</a>
                </div>
            </div>
            <div class="card-body px-2">
                <div class="form-group">
                    <input type="range" class="custom-range" id="ex1" min="0" max="<?php echo count($fechas) ?>">
                </div>
                <table class="table-registro" id="tbasistencia" role="table">
                    <thead role="rowgroup">
                        <tr role="row">
                           <th role="columnheader">CARNÉ</th>
                            <th role="columnheader">ALUMNO</th>
                            <?php
                            $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
                                $fanterior="01/01/90";
                                $nfechas=$curso->sesiones;
                                foreach ($fechas as $key => $fecha) {
                                    $fechaslt=date("d/m/y", strtotime($fecha->fecha));
                                    $inicia=($fechaslt==$fanterior) ? $fecha->inicia."<br>" : "";
                                    echo "<th class='text-center'><a class='rotar' href='".base_url().'curso/asistencia-sesion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($fecha->sesion)."' >".$inicia.$dias[date("w", strtotime($fecha->fecha))]." ".$fechaslt."</a></th>";
                                    $fanterior=$fechaslt;
                                }
                                echo "<th><b>F(%)</b></th>";
                            ?>
                        </tr>
                    </thead>
                    <tbody role="rowgroup">
                        <?php
                            $numero=0;
                            
                            $anota="";
                            $valor=0;

                            foreach ($miembros as $miembro) {
                                if (($miembro->eliminado=='NO') && ($miembro->ocultar=='NO')){
                                    $numero++;
                                    $colormat=($miembro->codestadomat=="1") ? "black":"red";
                                    echo '<tr role="row" data-idmiembro="'.$miembro->idmiembro.'">
                                            <td class="cell" role="cell">
                                                <span class="d-none d-sm-block">
                                                <b>'.str_pad($numero, 2, "0", STR_PAD_LEFT).'.- </b>'.$miembro->carnet.
                                                '</span>
                                                 <span class="d-block d-sm-none">
                                                <b>'.str_pad($numero, 2, "0", STR_PAD_LEFT).'</b>
                                                </span>
                                            </td>
                                            <td class="cell" role="cell">
                                                <span style="color:'.$colormat.'">'.$miembro->paterno.' '.$miembro->materno.' '.$miembro->nombres.'</span>
                                            </td>';
                                            $aidmiembro=$miembro->idmiembro;
                                            foreach ($fechas as $key => $fecha) {
                                                //var_dump($fecha);
                                                //var_dump($alumnos[$miembro->idmiembro]['asis']);
                                                //if (isset($alumnos[$miembro->idmiembro]['asis'][$fecha->sesion])){
                                                $aaccion=$alumnos[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'];
                                                $aid= $alumnos[$miembro->idmiembro]['asis'][$fecha->sesion]['idaccion'] ;
                                                $colorbtn="btn-default";
                                                switch ($aaccion) {
                                                    case 'A':
                                                        $colorbtn="btn-success";
                                                        break;
                                                    case 'T':
                                                        $colorbtn="btn-warning";
                                                        break;
                                                    case 'F':
                                                        $colorbtn="btn-danger";
                                                        break;
                                                    case 'J':
                                                        $colorbtn="btn-info";
                                                }
                                                
                                                echo "<td class='cell' >
                                                    <a data-sesion='".$fecha->sesion."' data-edit='0' data-idacu='".$aid."' data-fecha='".$fecha->fecha."' data-miembro='".$aidmiembro."' class='txtnota btn btn-flat btn-block ".$colorbtn."' href='#'>".$aaccion."</a>
                                                    </td>";
                                            }
                                            
                                            $pfaltas=round($alumnos[$miembro->idmiembro]['asis']['faltas']/$nfechas*100,0);
                                            $isdpi=($pfaltas>=30) ? "DPI" : "";
                                            if ($isdpi==""){
                                                echo "<td class='text-center'>$pfaltas</td>";
                                            }
                                            else{
                                                echo "<td class='bg-red text-center'>$isdpi</td>";  
                                            }
                                
                                echo '</tr>';
                                }
                        } ?>
                    </tbody>
                </table>
                <div class="col-md-8" id="divmsgError">
                    
                </div>
                <div class="col-md-4 no-padding float-right margin-top-10px">
                    <button id="btnguardareg" class="btn btn-lg btn-flat btn-primary btn-block">
                    Guardar
                    </button>
                </div>
            </div>
            <?php } ?>
        
        </div>
    </section>
</div>

<script>
    var vccaj = '<?php echo $curso->codcarga ?>';
    var vsscj = '<?php echo $curso->division ?>';

    var showCols = 2;
    var nrocol = <?php echo count($fechas) ?>;
    function obtenerAncho(){
        var ancho=$(window).width();
        if (ancho > 1023) {
            showCols = 20;
        } else if (ancho > 767) {
            showCols = 13;
        } else if (ancho > 479) {
            showCols = 5;
        } else {
            showCols = 2;
        }
    }
    obtenerAncho();
    $(window).resize(function(){
        //var alto=$(window).height();
        obtenerAncho();
        var newVal = $('#ex1').data('slider').getValue();
        mostrarcols(newVal);
    });
    

    $("#mdcancel").click(function(event) {
        $("#mdmsg").html("");
        $("#mdfecha").val("");
    });

    /*$("#mdagregar").click(function(event) {
        $('#divmsgError').html("");
        var vfecha = $("#mdfecha").val();
        if (!moment(vfecha).isValid()) {
            $("#mdmsg").html("<div id='divError' class='alert alert-danger' role='alert'>La fecha ingresada no es valida</div>")
            return false;
        } else {
            $('#modal-fecha').modal('hide');
            $('#divboxasistencia').append('<div id="divoverlay" class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

            $.ajax({
                url: base_url + 'curso/f_agregafecha',
                type: 'post',
                dataType: 'json',
                data: {
                    fecha: vfecha,
                    vcca: vccaj,
                    vssc: vsscj
                },
                success: function(e) {
                    $('#divboxasistencia #divoverlay').remove();
                    if (e.status == false) {

                        var msgf = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + e.msg + '</div>';
                        $('#divmsgError').html(msgf);
                    } else {
                        $('#divmisdeudas').html(e.vdata);
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'div');
                    $('#divboxasistencia #divoverlay').remove();
                    $('#divmisdeudas').html(msgf);
                },
            });
            moment.locale('es');
            var dateTime = moment(vfecha);
            var full = dateTime.format('ddd D/MM/YY');
            nrocol++;
            addColumn('tbasistencia', nrocol, 0, full, );
            $("#mdmsg").html("");
            //$("#mdfecha").val(""); +
            $("#ex1").slider('setAttribute', 'max', nrocol);
            $("#ex1").slider('refresh');
            //ESTO NO VA -- LO DE ABAJO
            location.reload();
        }
    });*/

    function mostrarcols(ncol) {
        /*var maxc = ncol + 2;
        var minc = (ncol - showCols) + 2;
        if (minc < 0) minc = 2;
        alert(showCols + "-" + maxc + "-" + minc);*/
        nrocol2=nrocol+2;
        if (ncol==1){
            minc= 3;
            maxc= 2 + showCols;
        }
        else if(ncol==nrocol){
            minc= 3 + (nrocol - showCols) ;
            maxc= 2 + nrocol;   
        }
        else{
            mit= Math.round(showCols / 2)
            minc= 3 + (ncol - (mit));
            maxc= 2 + (ncol + (mit));
            //alert(minc);
            if (minc < 2) {
                minc = 3;
                maxc = ncol + showCols - minc;

            }
        }
        //alert(nrocol+"-"+showCols + "-" + maxc + "-" + minc);
        if (nrocol > showCols) {
            for (var i = 3; i <= nrocol2; i++) {
                if ((i >= minc) && (i <= maxc)) {
                    $("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").removeClass("ocultar");
                } else {
                    $("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").addClass("ocultar");
                }
            }
        }
    }

    var originalVal;
    /*$('#ex1').slider().on('slideStart', function(ev) {
        originalVal = $('#ex1').data('slider').getValue();
    });
    $('#ex1').slider().on('slideStop', function(ev) {
        var newVal = $('#ex1').data('slider').getValue();
        if (originalVal != newVal) {
            mostrarcols(newVal);
        }
    });*/
    $("#ex1").change(function(event) {
        /* Act on the event */
        mostrarcols($(this).val());
    });
    $("#tbasistencia td a").click(function(event) {
        var accion = $.trim($(this).html());
        if (accion == "") {
            accion = "A";
            $(this).removeClass("btn-default");
            $(this).addClass("btn-success");
        } else if (accion == "A") {
            accion = "T";
            $(this).removeClass("btn-success");
            $(this).addClass("btn-warning");
        } else if (accion == "T") {
            accion = "F";
            $(this).removeClass("btn-warning");
            $(this).addClass("btn-danger");
        } else if (accion == "F") {
            accion = "J";
            $(this).removeClass("btn-danger");
            $(this).addClass("btn-info");
        } else if (accion == "J") {
            accion = "E";
            $(this).removeClass("btn-info");
            $(this).addClass("btn-default");
        } else if (accion == "E") {
            accion = "A";
             $(this).removeClass("btn-default");
            $(this).addClass("btn-success");
        }
        $(this).data('edit', '1')
        $(this).html(accion);
        return false;
    });
    $('#btnguardareg').click(function(event) {
        $('#divboxevaluaciones').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        arrdata = [];
        var edits=0;
        $('#tbasistencia td a').each(function() {
            // <a data-sesion='".$fecha->sesion."' data-edit='$esedit' data-idacu='".$aid."' data-fecha='".$fecha->fecha."' data-miembro='".$aidmiembro."' class='txtnota btn btn-flat btn-block ".$colorbtn."' href='#'>".$aaccion."</a>
                                                   
            var isedit = $(this).data("edit");
            var idacu = $(this).data("idacu");
            var fcha = $(this).data("fecha");
            var accn = $(this).html();
            var idmiembro = $(this).data("miembro");
            var idses = $(this).data("sesion");
            //dataString = {fecha: fcha, accion: accn ,idmiembro: idacu};
            if (isedit == "1") {
                var myvals = [fcha, accn, idacu, idmiembro, idses];
                arrdata.push(myvals);
                    edits++;
            }

        });
         if (edits>0){
        $.ajax({
            url: base_url + 'curso/f_subirasistencia',
            type: 'post',
            dataType: 'json',
            data: {
                vcca: vccaj,
                vssc: vsscj,
                filas: JSON.stringify(arrdata),
            },
            success: function(e) {
                
                if (e.status == false) {
                    $('#divboxevaluaciones #divoverlay').remove();
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: e.msg,
                        backdrop:false,
                    });
                } else {
                    //location.reload();
                     $('.txtnota').each(function() {
                            if ($(this).data('edit')=='1') {
                                if ($(this).data('idacu')<0){
                                    $(this).data('idacu',  e.ids[$(this).data('idacu')]);
                                    $(this).data('edit',  '0');
                                }
                            }
                            });
                        Swal.fire({
                            type: 'success',
                            title: 'ÉXITO, Se guardó cambios',
                            text: "Lo cambios fueron guardados correctamente",
                            backdrop:false,
                        });
                         $('#divboxevaluaciones #divoverlay').remove();
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: msgf,
                        backdrop:false,
                    });
                $('#divboxevaluaciones #divoverlay').remove();
            },
        });
            }
     else{
            Swal.fire({
                type: 'success',
                title: 'ÉXITO, Se guardó cambios (M)',
                text: "Lo cambios fueron guardados correctamente",
                backdrop:false,
            });
            $('#divboxevaluaciones #divoverlay').remove();
        }
    });

    $(document).ready(function() {
        mostrarcols(nrocol);
    });




</script>
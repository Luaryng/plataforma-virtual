<?php $vbaseurl=base_url();
$nfechas=$curso->sesiones; ?>
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
                
              <li class="breadcrumb-item active">Asistencia</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section id="s-cargado" class="content">
        <?php include 'vw_curso_encabezado.php'; ?>
        <div id="divboxevaluaciones" class="card card-success">
            
           
            <?php if (!$alumnos){  ?>
                <div class="card-body ">
                <center>
                    <br><br><br><br>
                    <h2>Evaluaciones no disponibles, comuniquese con el administrador</h>
                    <br>
                </center>
                </div>
            <?php }
            else { ?>
            <div class="card-body px-2">
                <?php 
                    $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
                    $fanterior="01/01/90";
                    foreach ($fechas as $key => $fecha) {
                        $fechaslt=date("d/m/y", strtotime($fecha->fecha));
                        $inicia=date("h:i a", strtotime($fecha->inicia));
                        echo "<h4>".$dias[date("w", strtotime($fecha->fecha))]." - ".$fechaslt." ".$inicia."</h4>";
                        
                    }
                ?>
                <table class="table-registro" id="tbasistencia" role="table">
                    <thead role="rowgroup">
                        <tr role="row">
                           <th role="columnheader"><span class="d-none">  CARNÉ </span></th>
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
                            ?>
                            <th class="bg-green" role="columnheader">
                                
                                <div class='checkround'>
                                    <input value='A' type='radio' name='radiocol' class='radiocolbox' id='acheckboxcol' />
                                    <label for='acheckboxcol'></label>
                                </div>
                                <span class='rotar'>Asitió&nbsp;&nbsp;</span>
                            </th>
                            
                            <th class="bg-red" role="columnheader">

                                <div class='checkround'>
                                    <input value='F' type='radio' name='radiocol' class='radiocolbox' id='fcheckboxcol' />
                                    <label for='fcheckboxcol'></label>
                                </div>
                                <span class='rotar'>Faltó&nbsp;&nbsp;</span>
                            </th>
                            <th class="bg-yellow" role="columnheader">

                                <div class='checkround'>
                                    <input value='T' type='radio' name='radiocol' class='radiocolbox' id='tcheckboxcol' />
                                    <label for='tcheckboxcol'></label>
                                </div>
                                <span class='rotar'>Tarde&nbsp;&nbsp;</span>
                            </th>
                            <th class="bg-aqua" role="columnheader">

                                <div class='checkround'>
                                    <input value='J' type='radio' name='radiocol' class='radiocolbox' id='jcheckboxcol' />
                                    <label for='jcheckboxcol'></label>
                                </div>
                                <span class='rotar'>Justif.&nbsp;&nbsp;</span>
                            </th>
                            <th class="" role="columnheader">

                                <div class='checkround'>
                                    <input value='E' type='radio' name='radiocol' class='radiocolbox' id='echeckboxcol' />
                                    <label for='echeckboxcol'></label>
                                </div>
                                <span class='rotar'>Exoner.&nbsp;&nbsp;</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody role="rowgroup">
                        <?php
                            $numero=0;
                            
                            $anota="";
                            $valor=0;
                            $va=0;
                                                $vf=0;
                                                $vt=0;
                                                $vj=0;
                                                $ve=0;
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
                                               
                                                $vacheckbox="";
                                                $vfcheckbox="";
                                                $vtcheckbox="";
                                                $vjcheckbox="";
                                                $vecheckbox="";
                                                

                                                switch ($aaccion) {
                                                    case 'A':
                                                        $colorbtn="btn-success";
                                                        $vacheckbox="checked";
                                                        $va++;
                                                        break;
                                                    case 'T':
                                                        $colorbtn="btn-warning";
                                                        $vtcheckbox="checked";
                                                        $vt++;
                                                        break;
                                                    case 'F':
                                                        $colorbtn="btn-danger";
                                                        $vfcheckbox="checked";
                                                        $vf++;
                                                        break;
                                                    case 'J':
                                                        $colorbtn="btn-info";
                                                        $vjcheckbox="checked";
                                                        $vj++;
                                                        break;
                                                    case 'E':
                                                        $colorbtn="btn-default";
                                                        $vecheckbox="checked";
                                                        $ve++;
                                                        break;
                                                }
                                                //$valor= $aaccion;
                                                
                                                //$anota=$valor;
                                                //$esedit=($aid<0)?"1":"0";
                                                  //}
                                                echo "<td class='cell' >
                                                    <a data-sesion='".$fecha->sesion."' data-edit='0' data-idacu='".$aid."' data-fecha='".$fecha->fecha."' data-miembro='".$aidmiembro."' class='txtnota btn btn-flat btn-block ".$colorbtn."' href='#'>".$aaccion."</a>
                                                    </td>";
                                                    echo "<td class='bg-green disabled p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vacheckbox." value='A' type='radio' name='radio".$aid."' class='radiobox acheckbox' id='acheckbox".$aid."' />
                                                            <label for='acheckbox".$aid."'></label>
                                                        </div>
                                                      </td>";
                                                echo "<td class='bg-red disabled p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vfcheckbox." value='F' type='radio' name='radio".$aid."' class='radiobox fcheckbox' id='fcheckbox".$aid."' />
                                                            <label for='fcheckbox".$aid."'></label>
                                                        </div>
                                                      </td>";

                                                echo "<td class='bg-yellow disabled p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vtcheckbox." value='T' type='radio' name='radio".$aid."' class='radiobox tcheckbox' id='tcheckbox".$aid."' />
                                                            <label for='tcheckbox".$aid."'></label>
                                                        </div>
                                                    </td>";
                                                echo "<td class='bg-info disabled p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vjcheckbox." value='J' type='radio' name='radio".$aid."' class='radiobox jcheckbox' id='jcheckbox".$aid."' />
                                                            <label for='jcheckbox".$aid."'></label>
                                                        </div>
                                                    </td>";
                                                echo "<td class='p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vecheckbox." value='E' type='radio' name='radio".$aid."' class='radiobox echeckbox' id='echeckbox".$aid."' />
                                                            <label for='echeckbox".$aid."'></label>
                                                        </div>
                                                    </td>";
                                            }
                                            
                                
                                echo '</tr>';
                                }
                        } ?>
                        <tr role="row">
                                <td class="cell" role="cell"></td>
                                <td class="cell" role="cell"></td>
                                <td class="cell" role="cell"></td>
                                <td id="conteova" class="cell text-center" role="cell"><?php echo $va ?></td>
                                <td id="conteovf" class="cell text-center" role="cell"><?php echo $vf ?></td>
                                <td id="conteovt" class="cell text-center" role="cell"><?php echo $vt ?></td>
                                <td id="conteovj" class="cell text-center" role="cell"><?php echo $vj ?></td>
                                <td id="conteove" class="cell text-center" role="cell"><?php echo $ve ?></td>
                                
                            </tr>
                    </tbody>
                </table>
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
    
    $("table tr td:nth-child(3), table tr th:nth-child(3)").hide();
$("#chkretirados").change(function(event) {
        MORetirados();
    });
    function MORetirados(){
        
        var checka=$("#chkretirados").prop('checked');
        $('#tbasistencia tr').each(function() {
            if (($(this).data("estado")=="2")&&(checka==true)){
                $(this).removeClass('ocultar');
            }
            else if(($(this).data("estado")=="2")&&(checka==false)){
                $(this).addClass('ocultar');
            }
            
        });
    }
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
    function conteo(valor,num){

        if (valor == "A") {
            $("#conteova").html(parseInt($("#conteova").html()) + num);
        } else if (valor == "T") {
            $("#conteovt").html(parseInt($("#conteovt").html()) + num);
        } else if (valor == "F") {
            $("#conteovf").html(parseInt($("#conteovf").html()) + num);
        } else if (valor == "J") {
            $("#conteovj").html(parseInt($("#conteovj").html()) + num);
        } else if (valor == "E") {
            $("#conteove").html(parseInt($("#conteove").html()) + num);

        }
    }
    obtenerAncho();
    $(window).resize(function(){
        //var alto=$(window).height();
        //obtenerAncho();
        //var newVal = $('#ex1').data('slider').getValue();
        //mostrarcols(newVal);
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
    $(".radiocolbox").change(function(event) {
        var valor=$(this).val();
        $(".txtnota").html(valor);
        $("#conteova").html(0);
        $("#conteovt").html(0);
        $("#conteovf").html(0);
        $("#conteovj").html(0);
        $("#conteove").html(0);
        var nrow=$('#tbasistencia tr').length - 2;
        
        if (valor == "A") {
            $("#conteova").html(nrow);
            $(".acheckbox").prop("checked", true);
        } else if (valor == "T") {
            $(".tcheckbox").prop("checked", true);
            $("#conteovt").html(nrow);
        } else if (valor == "F") {
            $(".fcheckbox").prop("checked", true);
            $("#conteovf").html(nrow);
        } else if (valor == "J") {
           $(".jcheckbox").prop("checked", true);
           $("#conteovj").html(nrow);
        } else if (valor == "E") {
           $(".echeckbox").prop("checked", true);
           $("#conteove").html(nrow);
        }
        $(".txtnota").data('edit', '1')

       

    });
    $(".radiobox").change(function(event) {
        
        var cuadro=$(this).parent().parent().parent().find('a');
        conteo(cuadro.html(),-1);
        cuadro.html($(this).val());
        conteo(cuadro.html(),1);
        var accion = $.trim(cuadro.html());

        /*cuadro.removeClass("btn-default");
        cuadro.removeClass("btn-success");
        cuadro.removeClass("btn-warning");
        cuadro.removeClass("btn-danger");
        cuadro.removeClass("btn-info");
        if (accion == "A") {
         
            cuadro.addClass("btn-success");
        } else if (accion == "T") {
            
            cuadro.addClass("btn-warning");
        } else if (accion == "F") {
            
            cuadro.addClass("btn-danger");
        } else if (accion == "J") {
            
            cuadro.addClass("btn-info");
        } else if (accion == "E") {
            
            cuadro.addClass("btn-default");
        } else if (accion == "") {
        }*/
        cuadro.data('edit', '1')
        $(this).html(accion);

    });

    $("#tbasistencia td a").click(function(event) {
        var accion = $.trim($(this).html());
        if (accion == "A") {
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
                   Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios ',
                        text: "Lo cambios NO fueron guardados correctamente",
                        backdrop:false,
                    });
                     $('#divboxevaluaciones #divoverlay').remove();
                } else {
                    //location.reload();
                    $('#divboxevaluaciones #divoverlay').remove();
                     $('.txtnota').each(function() {
                            //alert($(this).data('edit'));
                            //alert($(this).data('idaccion'));
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

                }
               
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios ',
                        text: msgf,
                        backdrop:false,
                    });
                    $('#divboxevaluaciones #divoverlay').remove();
            },
        });}
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
        //mostrarcols(nrocol);
    });



</script>
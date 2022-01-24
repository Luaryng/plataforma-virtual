<?php $vbaseurl=base_url();
$nfechas=$curso->sesiones; 
$codcarga64=base64url_encode($curso->codcarga);
$division64=base64url_encode($curso->division);


?>
<div class="content-wrapper">

<input type="hidden" id="vw_eva_carga" value="<?php echo $codcarga64?>">
<input type="hidden" id="vw_eva_division" value="<?php echo $division64 ?>">

<div class="modal " id="md_enlazar_aula" tabindex="-1" role="dialog" aria-labelledby="md_enlazar_aula" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Conectar Aula virtual</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 id="vw_md_eav_encabezado"></h5>
        <div class="row">
            <div class="col-12 text-bold">
                <div class="row">
                    <div class="col-7">Recursos enlazados</div>
                    <div class="col-5"></div>
                </div>
            </div>
            <div class="col-12" id="vw_md_eav_divrecursos">
                
            </div>
        </div>
        <input type="hidden" id="vw_md_eav_codencabezado">

        <div class="row mt-2">
            <div class="col-7 text-bold">Enlazar recurso</div>
            <div class="col-10">
                <select class="form-control form-control-sm" name="vw_md_eav_recurso" id="vw_md_eav_recurso">

                </select>
            </div>
            <div class="col-2">
                <a id="vw_btn_update_enlazar" class="btn btn-sm btn-primary" href="#">Enlazar</a>
            </div>
            <div class="col-12">
                <?php 
                    /*$numero=0;
                    foreach ($miembros as $miembro) {
                        if (($miembro->eliminado=='NO') && ($miembro->ocultar=='NO')){
                            $numero++;
                            $colormat=($miembro->codestadomat=="1") ? "":"text-danger";
                            echo "<div class='cfila row' data-idmiembro='$miembro->idmiembro'>";
                                echo "<div class='col-3'>";
                                    echo "<span class='$colormat'>$miembro->paterno $miembro->materno $miembro->nombres</span>";
                                echo "</div>";
                                $nota_aula="";
                                foreach ($materiales as $key => $material) {
                                    foreach ($notas_aula as $key => $ntaula) {
                                        if (($miembro->idmiembro==$ntaula->codmiembro) && ($material->codigo==$ntaula->codmaterial)){
                                            $nota_aula=floatval($ntaula->nota);
                                        }
                                    }
                                    echo "<div class='col-1'>";
                                        echo "<span>$nota_aula</span>";
                                    echo "</div>";
                                    $nota_aula="";
                                }
                                
                               
                            echo "</div>";
                                       
                        }
                    } */

                 ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
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
                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
                </li>
                <li class="breadcrumb-item">
                    
                    <a href="<?php echo $vbaseurl.'curso/panel/'.$codcarga64.'/'.$division64; ?>"><?php echo $curso->unidad ?>
                    </a>
                </li>
                
              <li class="breadcrumb-item active">Evaluaciones</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section id="s-cargado" class="content">
        <?php include 'vw_curso_encabezado.php'; ?>
        <div id="divboxevaluaciones" class="card ">
            <?php if (!isset($notas)){  ?>
                <div class="card-body ">
                    <div>
                    <h2 class="text-bold">SIN ESTUDIANTES</h2> 
                    <h3 class="text-danger">Compruebe que han sido declarados los <b>Indicadores</b></h3>
                    <br>
                    <br>
                    </div>
                </div>
            <?php }
            else { ?>
            <div class="card-header">
                <div class="card-tools">
                    <a href="<?php echo $vbaseurl.'curso/evaluaciones/excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division) ?>" class="btn-excel btn btn-outline-secondary float-rsight"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" class="float-left" alt=""> Exportar</a>
                </div>
            </div>
            <div class="card-body px-2">
                <div class="col-12 d-block d-md-none">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input " id="switchpf">
                        <label class="custom-control-label" for="switchpf">Ver promedio Final</label>
                    </div>
                  <br>
                </div>
                <div class="text-danger col-12 mb-2">Selecciona en el Combo la Unidad <br></div>
                <div class="has-float-label col-4 p-0 mb-2">
                        
                        <select data-currentvalue='' class="form-control text-bold text-primary" id="cbindicador" name="cbindicador" placeholder="Selecciona la unidad" required >
                            <?php foreach ($indicadores as $indicador) {
                                $nindi++;?>
                            <option value="<?php echo $indicador->codigo ?>"><?php echo $indicador->norden.' - '.$indicador->nombre ?></option>
                            <?php } ?>
                            <option value="0">Todos los indicadores</option>
                        </select>
                        <label for="cbindicador"> Selecciona la unidad</label>
                </div>
                <table class="table-registro" id="tbasistencia" role="table">
                    <thead role="rowgroup">
                        <tr role="row">
                            <th class="cell" data-indicador='0' role="columnheader"><span class="d-none d-sm-block">CARNÉ</span></th>
                            <th class="cell" data-indicador='0' role="columnheader">ALUMNO</th>
                             <?php
                                foreach ($indicadores as $indicador) {
                                    foreach ($evaluaciones as $evaluacion) {
                                        if ($evaluacion->indicador==$indicador->codigo){
                                            if ($evaluacion->abrevia!="RC"){
                                            $color=($evaluacion->tipo=="C") ? "text-primary" : "";
                                            $codencabezado=base64url_encode($evaluacion->evaluacion);
                                            /*if (($indicador->norden==3) && ($evaluacion->orden==3)){
                                                echo "<th  class='cell' data-indicador='$indicador->codigo' data-toggle='tooltip' data-placement='top' title='Evaluación Final'>
                                                    <span  class='mt-1 rotar $color'>EF</span></th>";
                                            }
                                            else{*/
                                                echo "<th  class='cell' data-indicador='$indicador->codigo' data-toggle='tooltip' data-placement='top' title='$evaluacion->nombre $indicador->norden'>
                                                    <a data-codencabezado='$codencabezado' data-encabezado='$evaluacion->nombre $indicador->norden' href='#' class='vw_btn_enlazar mt-1 rotar $color'>".$evaluacion->abrevia.$indicador->norden."</a></th>";
                                            //}
                                                    }
                                        }
                                    }
                                }
                            ?>
                            <th data data-indicador='-1' role="columnheader">
                                
                            </th>
                            <th class="cell" data-toggle='tooltip' data-placement='top' title='Promedio'  data-indicador='-1' role="columnheader">
                                <span class='mt-1 rotar text-success'>PR</span>
                            </th>
                            <th class="cell" data-toggle='tooltip' data-placement='top' title='Recuperación'  data-indicador='-1' role="columnheader">
                                <span class='mt-1 rotar text-success'>RC</span>
                            </th>
                            <th class="cell" data-toggle='tooltip' data-placement='top' title='Promedio Final'  data-indicador='-1' role="columnheader">
                                <span class='mt-1 rotar text-success'>PF</span>
                            </th>

                            
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
                                            
                                            foreach ($indicadores as $indicador) {
                                                foreach ($evaluaciones as $evaluacion) {
                                                    if ($evaluacion->indicador==$indicador->codigo){
                                                        if ($evaluacion->abrevia!="RC"){
                                                        $aidmiembro=$miembro->idmiembro;
                                                        
                                                        $anota="";
                                                        $valor=0;
                                                        $colorbtn="text-default";
                                                        //foreach ($asistencias as $key => $ast) {
                                                            //if (($evaluacion->nombre_calculo==$ast->abrevia)&&($miembro->idmiembro==$ast->idmiembro)){
                                                        
                                                        $valor= $notas[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['nota'] ;

                                                        $tipo= $notas[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['tipo'] ;
                                                        $anota=$valor;
                                                         $colorbtn="text-danger";
                                                        if ($valor>=12.5) $colorbtn="text-primary";
                                                        
                                                          //}
                                                        //}
                                                        if ($tipo=="M"){
                                                            $aid= $notas[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['idnota'] ;
                                                             echo "<td class='cellnota' >
                                                                <input id='".$aidmiembro.$indicador->codigo.$evaluacion->nombre_calculo."' type='number' data-indicador='".$evaluacion->indicador."' data-valor='".$valor."' max='20' min='0' data-edit='0' data-ideval='".$evaluacion->evaluacion."' data-idnota='".$aid."' data-miembro='".$aidmiembro."' class='txtnota ".$colorbtn."' data-ntsaved='".$anota."' value='".$anota."'>
                                                            </td>";
                                                        }
                                                        else{
                                                            //var_dump($anota);
                                                             echo "<td class='cell text-right' >
                                                                <span id='".$aidmiembro.$indicador->codigo.$evaluacion->nombre_calculo."' class='$colorbtn'>$anota</span>
                                                            </td>";
                                                        }
                                                        }
                                                    }
                                                }
                                            }

                                            echo "<td class='text-right' >
                                                    <span >
                                                    </span>
                                                </td>";
                                            $nt=$notas[$aidmiembro]['eval']['PI']['nota'];
                                            $colornt="text-danger";
                                            if ($nt>=12.5) $colornt="text-primary";
                                            echo "<td class='cell text-right' >
                                                    <span id='".$aidmiembro."PI' class='$colornt'>
                                                    $nt</span>
                                                </td>";

                                            

                                            $anota=$notas[$aidmiembro]['eval']['RC']['nota'];;
                                            echo "<td class='cellnota' >
                                                    <input id='".$aidmiembro."RC' type='number' data-ideval='0' data-indicador='0' data-valor='".$anota."' max='20' min='0' data-edit='0' data-idnota='0' data-miembro='".$aidmiembro."' class='txtnota ".$colorbtn."' data-ntsaved='".$anota."' value='".$anota."'>
                                                </td>";

                                            $pf=$notas[$aidmiembro]['eval']['PF']['nota'];
                                            $colorpf="text-danger";
                                            if ($pf>=12.5) $colorpf="text-primary";
                                            $pfaltas=round($notas[$miembro->idmiembro]['asis']['faltas']/$nfechas*100,0);
                                            $isdpi=($pfaltas>30) ? "DPI" : "";
                                            if ($isdpi==""){
                                                echo "<td data-dpi='NO' class='text-center p-0 text-bold $colorpf'><span id='".$aidmiembro."PF'>$pf</span></td>";
                                            }
                                            else{
                                                echo "<td data-dpi='SI' class='bg-red text-center p-0'><span id='".$aidmiembro."PF'>$isdpi</span></td>";  
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
    var vindicadores = <?php echo json_encode($indicadores, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;

    $("#cbindicador").change(function(event) {
        var ind=$(this).val();
        mostrarcols(ind);
    });

    function mostrarcols(nindicador) {
        var i=1;
        if (nindicador=='0'){
             //$("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").show();
              $("table tr td, table tr th").show();
        }
        else{
            $('.table-registro th').each(function () {
                var ind = $(this).data("indicador");
                if (ind>"0"){
                    $("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").hide();
                    if (ind==nindicador){
                         $("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").show();
                    }
                }
                i++;  
            });
        }
        
    }
    $("#switchpf").change(function(event) {
        /* Act on the event */
        var  chk=$(this).prop('checked');
        var i=$("table tr th:last-child").index() + 1;
        if (chk==true){
            $("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").show();
        }
        else{
            $("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").hide();
        }
    });
    $(".table-registro td input").blur(function(event) {
    if ($(this).data('ntsaved') != $(this).val()) {

        $(this).data('edit', '1');
        if (($(this).val() < 0)||($(this).val() > 20)) {
            $(this).parent().addClass('cellerror');
        } else {
                
            $(this).parent().removeClass('cellerror');
            $(this).parent().addClass('celleditada');
        }
    }
    else{
        $(this).data('edit', '0');
        $(this).parent().removeClass('celleditada');
    }

    if ($(this).val() > 12) {
        $(this).removeClass('text-danger');
        $(this).addClass('text-primary');
    } else {
        $(this).removeClass('text-primary');
        $(this).addClass('text-danger');
    }
});

$('#btnguardareg').click(function(event) {
    $('#divmsgError').html("");
    $('#divboxevaluaciones').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    arrdata = [];
    var nerror=0;
    var edits=0;
    $('#tbasistencia td input').each(function() {
        var isedit = $(this).data("edit");
        var idnota = $(this).data("idnota");
        var fcha = $(this).data("fecha");
        var nota = $(this).val();
        var idmiembro = $(this).data("miembro");
        var idevh = $(this).data("ideval");
        //dataString = {fecha: fcha, accion: accn ,idmiembro: idacu};
        
        if (isedit == "1") {
            if (($(this).val() < 0)||($(this).val() > 20)) {
                nerror++    
            }
            else{
                  //@`vcca`, @`vsubseccion`, @`vidmiembro`, @`vecu_nota`, @`videvaluacionhead`
                var myvals = [idmiembro, nota, idnota,idevh];
                arrdata.push(myvals);
            }
            edits++;
        }      
    });
    if (nerror==0){
        if (edits>0){
            $.ajax({
                url: base_url + 'curso/f_subirevaluaciones',
                type: 'post',
                dataType: 'json',
                data: {
                    vcca: vccaj,
                    vssc: vsscj,
                    filas: JSON.stringify(arrdata),
                },
                success: function(e) {
                    $('#divboxevaluaciones #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            type: 'error',
                            title: 'ERROR, NO se guardó cambios',
                            text: e.msg,
                            backdrop:false,
                        });
                    } else {
                            $('.txtnota').each(function() {
                                if (($(this).data('edit')=='1') && ($(this).data('idnota')<0)){
                                    $(this).data('idnota',  e.ids[$(this).data('idnota')]);
                                    $(this).data('edit',  '0');
                                }
                                
                            });
                        $('#tbasistencia .cellnota').removeClass('celleditada');
                        $('#tbasistencia .cellnota').removeClass('cellerror');
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
                        title: 'ERROR, NO se guardó cambios',
                        text: msgf,
                        backdrop:false,
                    });
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
    }
    else{

        Swal.fire({
            type: 'error',
            title: 'ERROR, Notas Invalidas',
            text: "Existen " + nerror + " error(es): NOTA NO VÁLIDA (Rojo)",
            backdrop:false,
        });
        $('#divboxevaluaciones #divoverlay').remove();
    }
});


$(document).ready(function() {
    mostrarcols($("#cbindicador").val());
     var ancho=$(window).width();
        if (ancho > 479) {
            $("#switchpf").attr('checked', true);
        } else {
            $("#switchpf").attr('checked', false);
        }
    
    $("#switchpf").change();
    $('[data-toggle="tooltip"]').tooltip()
});
$(".txtnota").change(function(event) {
    /* Act on the event */
    var miembroid=$(this).data('miembro');
    promediar(miembroid);
});
function promediar(vidmiembro){
    var i=0;
    

    var suma=0;
    var nindicadores=0;
    var pi=0;
    for (i = 0; i < vindicadores.length ; i++) {
        var ind=vindicadores[i]['codigo'];
       
        var n1=$("#" + vidmiembro + ind + "N1").val();
        var n2=$("#" + vidmiembro + ind + "N2").val();
        var n3=$("#" + vidmiembro + ind + "N3").val();

        pindicador= Math.round((Number(n1) + Number(n2) + Number(n3)) /3);
        $("#" + vidmiembro + ind + "C1").html("<span>" + pindicador + "</span>");
        suma = suma + pindicador;
        nindicadores++;        
    }
    if (nindicadores==0){
        pi=0;
    }
    else{
        pi=Math.round(suma/nindicadores);
    }
    $("#" + vidmiembro + "PI").html("<span>" + pi + "</span>")
    var rc=$.trim($("#" + vidmiembro +  "RC").val());
    if (rc!=""){
        
        pi=Math.round((Number(pi) + Number(rc) )/2);
    }

    
    $("#" + vidmiembro + "PF").html("<span>" + pi + "</span>")
}

/**/
$(".vw_btn_enlazar").click(function(event) {
    event.preventDefault();
    var btn=$(this);
    $("#md_enlazar_aula").modal("show");
    var encabezado=btn.data("encabezado");
    var codencabezado=btn.data("codencabezado");
    $("#vw_md_eav_encabezado").html(encabezado);
    $("#vw_md_eav_codencabezado").val(codencabezado);
    
    jscodcarga=$("#vw_eva_carga").val();
    jsdivision=$("#vw_eva_division").val();
    $.ajax({
        

        url: base_url + 'virtual/fn_get_recursos_calificables',
        type: 'post',
        dataType: 'json',
        data: {
            codcarga: jscodcarga,
            division: jsdivision,
        },
        success: function(e) {
            $('#divboxevaluaciones #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se guardó cambios',
                    text: e.msg,
                    backdrop:false,
                });
            }
            else {
                var combo="";
                var agregados="";
                $.each(e.materiales, function(index, val) {
                    if (val['codevalhead']==null){
                        combo=combo + "<option data-codevalhead='" + val['codevalhead64'] + "' value='" + val['codigo64'] + "'>[" + val['tiponombre']  + "] " + val['nombre'] +"</option>";
                    }
                    else{    
                        if (val['codevalhead64']==codencabezado){
                            nrecursos++;
                            agregados=agregados + "<div class='cfila col-12 border'><div class='row'><div class='col-7 '>[" + val['tiponombre']  + "] " + val['nombre']  + "</div><div class='col-5'><a onclick='quitar_enlace($(this))' data-codrecurso64='" + val['codigo64'] + "' href='#' class='btn btn-danger btn-sm'>Quitar</a></div></div></div>";    
                        }
                        
                    }
 
                    

                });
                $("#vw_md_eav_recurso").html(combo);
                if (agregados=="") agregados="<div class='col-12 border'>Ninguno</div>";
                $("#vw_md_eav_divrecursos").html(agregados);
                


            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop:false,
            });
        },
    });

});

var nrecursos=0;
$("#vw_btn_update_enlazar ").click(function(event) {
    event.preventDefault();
    var btn=$(this);
    var jsencabezado64=$("#vw_md_eav_codencabezado").val();;
    var jscodmaterial64=$("#vw_md_eav_recurso").val();
    $.ajax({
        

        url: base_url + 'virtual/fn_update_enlazar_aula_evaluacion',
        type: 'post',
        dataType: 'json',
        data: {
            codmaterial: jscodmaterial64,
            codheadeval: jsencabezado64,
        },
        success: function(e) {
            $('#divboxevaluaciones #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se guardó cambios',
                    text: e.msg,
                    backdrop:false,
                });
            }
            else {
               
                $("#vw_md_eav_recurso option[value='" + jscodmaterial64 + "']").remove();
                "<div class='cfila col-12 border'><div class='row'><div class='col-7 '>[" + val['tiponombre']  + "] " + val['nombre']  + "</div><div class='col-5'><a onclick='quitar_enlace($(this))' data-codrecurso64='" + val['codigo64'] + "' href='#' class='btn btn-danger btn-sm'>Quitar</a></div></div></div>"; 

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop:false,
            });
        },
    });
    return false;

});

function quitar_enlace(btn){
    event.preventDefault();
    var fila=btn.closest(".cfila");
    
    var jscodmaterial64=btn.data('codrecurso64');
    
    $.ajax({
        

        url: base_url + 'virtual/fn_update_enlazar_aula_evaluacion',
        type: 'post',
        dataType: 'json',
        data: {
            codmaterial: jscodmaterial64,
            codheadeval: '---',
        },
        success: function(e) {
            $('#divboxevaluaciones #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    title: 'ERROR, NO se guardó cambios',
                    text: e.msg,
                    backdrop:false,
                });
            }
            else {
                nrecursos--;
                fila.remove();
                

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop:false,
            });
        },
    });
    return false;

};



</script>
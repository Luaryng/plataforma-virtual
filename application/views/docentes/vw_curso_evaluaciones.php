<?php $vbaseurl=base_url();$nfechas=$curso->sesiones; ?>
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
                
              <li class="breadcrumb-item active">Evaluaciones</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section id="s-cargado" class="content">
        <?php include 'vw_curso_encabezado.php'; ?>
        <div id="divboxevaluaciones" class="card card-success">
            

            <?php if (!isset($notas)){  ?>
                <div class="card-body ">
                    <center>
                    <br><br>
                    <h3 class="text-danger">Compruebe que existan <b>Alumnos matriculados</b></h3> 
                    <h3 class="text-danger">Compruebe que han sido declarados los <b>Indicadores</b></h3>
                    <br>
                    <br>
                  
                </center>
                </div>
            <?php }
            else { ?>
            <div class="card-body px-2">
                <div class="col-12 d-block d-md-none">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input " id="switchpf">
                        <label class="custom-control-label" for="switchpf">Ver promedio Final</label>
                    </div>
                  <br>
                </div>
                <div class="has-float-label col-12 p-0 mb-2">
                        <select data-currentvalue='' class="form-control text-bold text-primary" id="cbindicador" name="cbindicador" placeholder="Indicador" required >
                            <?php foreach ($indicadores as $indicador) {
                                $nindi++;?>
                            <option value="<?php echo $indicador->codigo ?>">Ind. <?php echo $indicador->norden.' - '.$indicador->nombre ?></option>
                            <?php } ?>
                            <option value="0">Todos los indicadores</option>
                        </select>
                        <label for="cbindicador"> Indicador</label>
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
                                        
                                            $color=($evaluacion->tipo=="C") ? "text-primary" : "";
                                            echo "<th  class='cell' data-indicador='$indicador->codigo'><span class='rotar $color'>".$evaluacion->abrevia.$indicador->norden."</span></th>";
                                        }
                                    }
                                }
                            ?>
                            <th class="cell"  data-indicador='-1' role="columnheader"><span class='rotar text-success'>PF</span></th>
                            
                        </tr>
                    </thead>
                    <tbody role="rowgroup">
                        <?php
                            $numero=0;
                            
                            $anota="";
                            $valor=0;
                            foreach ($miembros as $miembro) {
                                if ($miembro->eliminado=='NO'){
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
             
                                                        $aidmiembro=$miembro->idmiembro;
                                                        
                                                        $anota="";
                                                        $valor=0;
                                                        $colorbtn="text-default";
                                                        //foreach ($asistencias as $key => $ast) {
                                                            //if (($evaluacion->abrevia==$ast->abrevia)&&($miembro->idmiembro==$ast->idmiembro)){
                                                        
                                                        $valor= $notas[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['nota'] ;
                                                        
                                                        $tipo= $notas[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['tipo'] ;
                                                        $anota=$valor;
                                                         $colorbtn="text-danger";
                                                        if ($valor>=12.5) $colorbtn="text-primary";
                                                        
                                                          //}
                                                        //}
                                                        if ($tipo=="M"){
                                                            $aid= $notas[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->abrevia]['idnota'] ;
                                                             echo "<td class='cellnota' >
                                                                <input id='".$aidmiembro.$indicador->codigo.$evaluacion->abrevia."' type='number' data-indicador='".$evaluacion->indicador."' data-valor='".$valor."' max='20' min='0' data-edit='0' data-ideval='".$evaluacion->evaluacion."' data-idnota='".$aid."' data-miembro='".$aidmiembro."' class='txtnota ".$colorbtn."' data-ntsaved='".$anota."' value='".$anota."'>
                                                            </td>";
                                                        }
                                                        else{
                                                            //var_dump($anota);
                                                             echo "<td class='cell text-right' >
                                                                <span id='".$aidmiembro.$indicador->codigo.$evaluacion->abrevia."' class='$colorbtn'>$anota</span>
                                                            </td>";
                                                        }
                                                    }
                                                }
                                            }
                                            $pf=$notas[$aidmiembro]['eval']['PF']['nota'];
                                            $colorpf="text-danger";
                                            if ($pf>=12.5) $colorpf="text-primary";
                                                
                                            //echo "<td class='cell text-right text-bold $colorpf' id='".$aidmiembro."PF'>$pf</td>";
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
});
$(".txtnota").change(function(event) {
    /* Act on the event */
    var miembroid=$(this).data('miembro');
    promediar(miembroid);
});
function promediar(vidmiembro){
    var i=0;
    var spf=0;
    //alert(vindicadores.length);
    for (i = 0; i < vindicadores.length ; i++) {
        //alert(vindicadores);
        var ind=vindicadores[i]['codigo'];
       
        var pc=($("#" + vidmiembro + ind + "PC").val() * 0.3);
        var ta=($("#" + vidmiembro + ind + "TA").val() * 0.3);
        var ei=($("#" + vidmiembro + ind + "EI").val() * 0.4);
        var pi=Math.round((pc + ta + ei));
        var ri=($("#" + vidmiembro + ind + "RI").val() * 1);
        var pif= ((pi>ri) ? pi : ri);
        $("#" + vidmiembro + ind + "PI").html(pi);
        spf= spf + pif
        //alert($("#" + vidmiembro + "PC01").data('valor') + "/" + ta1 + "-" + ta2 + "-" + ta3 + "-" + pta);
        
        //var pf= Math.round(pta + ppc + peu)//
    }

    if (i==0) i=1;
    var pf=Math.round(spf/i);
    $("#" + vidmiembro + "PF").html("<span>" + pf + "</span>")
}


</script>
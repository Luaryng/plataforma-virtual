<?php $vbaseurl=base_url();$nfechas=$curso->sesiones; ?>
<div class="content-wrapper">
 <?php 
            include 'vw_curso_encabezado.php';
             if (!isset($notas)){  ?>
                <div class="card-body ">

                <div class="callout callout-danger">
                        <h4>Aviso!</h4>
                        <h5>Evaluaciones no disponibles, comuniquese con el administrador</h5>
                        <h5>Compruebe que existan <b>estudiante matriculados</b></h5>
                        <h5>Compruebe que han sido declarados los <b>Indicadores</b></h5>
                    </div>
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
                            <?php foreach ($indicadores as $indicador) {?>
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
                            <th class="cell" data-indicador='0' role="columnheader">ESTUDIANTE</th>
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
                                //if ($miembro->eliminado=='NO'){
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
                                                             echo "<td class='cellnota text-center' >
                                                                <span>$anota</span>
                                                            </td>";
                                                        }
                                                        else{
                                                            //var_dump($anota);
                                                             echo "<td class='cell text-right' >
                                                                <span class='$colorbtn'>$anota</span>
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
                                            $isdpi=($pfaltas>=30) ? "DPI" : "";
                                            if ($isdpi==""){
                                                echo "<td class='text-center p-0 text-bold $colorpf'>$pf</td>";
                                            }
                                            else{
                                                echo "<td class='bg-red text-center p-0'>$isdpi </td>";  
                                            }
                                
                                echo '</tr>';
                                //}
                        } ?>
                    </tbody>
                </table>
                
            </div>
            <?php } ?>
        
        </div>
    </section>
</div>
<script>
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
$(document).ready(function() {
    mostrarcols($("#cbindicador").val());

});
</script>
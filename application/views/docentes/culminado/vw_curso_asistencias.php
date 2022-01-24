<?php  $nfechas=$curso->sesiones;
$vbaseurl=base_url(); ?>
<div class="content-wrapper">
        
            <?php 
            include 'vw_curso_encabezado.php';
            if (!$alumnos){  ?>
                <div class="card-body ">
                    <div class="callout callout-danger">
                        <h4>Aviso!</h4>
                        <h5>Asistencia no disponibles, comuniquese con el administrador</h5>
                    </div>
                </div>
            <?php }
            else { ?>
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
                                    echo "<th class='text-center pt-1'><span class='rotar text-success' >".$inicia.$dias[date("w", strtotime($fecha->fecha))]." ".$fechaslt."</span></th>";
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
                                            $aidmiembro=$miembro->idmiembro;
                                            foreach ($fechas as $key => $fecha) {
                                                //var_dump($fecha);
                                                //var_dump($alumnos[$miembro->idmiembro]['asis']);
                                                //if (isset($alumnos[$miembro->idmiembro]['asis'][$fecha->sesion])){
                                                $aaccion=$alumnos[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'];
                                                $aid= $alumnos[$miembro->idmiembro]['asis'][$fecha->sesion]['idaccion'] ;
                                                $colorbtn="text-default";
                                                switch ($aaccion) {
                                                    case 'A':
                                                        $colorbtn="text-success";
                                                        break;
                                                    case 'T':
                                                        $colorbtn="text-warning";
                                                        break;
                                                    case 'F':
                                                        $colorbtn="text-danger";
                                                        break;
                                                    case 'J':
                                                        $colorbtn="text-info";
                                                }
                                                
                                                //$valor= $aaccion;
                                                
                                                //$anota=$valor;
                                                
                                                  //}
                                                echo "<td class='cell' >
                                                    <span class='txtnota $colorbtn text-bold' href='#'>".$aaccion."</span>
                                                    </td>";
                                            }
                                            
                                            $pfaltas=round($alumnos[$miembro->idmiembro]['asis']['faltas']/$nfechas*100,0);
                                            $isdpi=($pfaltas>=30) ? "DPI" : "";
                                            if ($isdpi==""){
                                                echo "<td class='text-center'>$pfaltas</td>";
                                            }
                                            else{
                                                echo "<td class='bg-red text-center'>$isdpi".$alumnos[$miembro->idmiembro]['asis']['faltas']."</td>";  
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


    $("#ex1").change(function(event) {
        /* Act on the event */
        mostrarcols($(this).val());
    });


    $(document).ready(function() {
        mostrarcols(nrocol);
    });




</script>
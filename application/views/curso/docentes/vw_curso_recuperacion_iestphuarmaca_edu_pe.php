<?php $vbaseurl=base_url();$nfechas=$curso->sesiones; ?>
<style>

    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }

    input[type=number] { -moz-appearance:textfield; }

    
    .txtnotadecimal {
        font-size: 11.5px;
        max-width: 40px;
        text-align: right;
    }
@media only screen and (max-width: 600px) {
    .txtnotadecimal {
        max-width: 35px;
        text-align: right;
    }
}
</style>
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
            <div class="card-body px-3">
                
                <table class="table-registro" id="tbasistencia" role="table">
                    <thead role="rowgroup">
                        <tr role="row">
                            
                            <th class="cell" data-indicador='-1' rowspan="2" role="columnheader">
                                <span class="d-none d-sm-block">CARNÉ</span>
                            </th>
                            <th class="cell" data-indicador='-1' rowspan="2" role="columnheader">ALUMNO</th>

                            <td colspan="4" class="text-center text-bold ind-headfinal">FINALES</td>
                        </tr>
                        <tr role="row">
                            
                            
                            <th data-indicador='0' role="columnheader"></th>
                            <th class="cell "  data-indicador='0' role="columnheader"data-toggle='tooltip' data-placement='top' title='Promedio de Indicadores'>
                                <span class='mt-1 rotar text-success'>PI</span></th>
                            <th class="cell " data-toggle='tooltip' data-placement='top' title='Recuperación Final'  data-indicador='0' role="columnheader">
                                <span class='mt-1 rotar text-success'>RC</span>
                            </th>
                            <th class="cell cellfinal" data-toggle='tooltip' data-placement='top' title='Promedio Final'  data-indicador='0' role="columnheader">
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
                                            $aidmiembro=$miembro->idmiembro;
                                            
                                             echo "<td ></td>";
                                            $nt=$notas[$aidmiembro]['eval']['PI']['nota'];
                                            $colornt="text-danger";
                                            if ($nt>=13) $colornt="text-primary";
                                            echo "<td class='cell text-right' >
                                                    <span id='".$aidmiembro."PI' class='$colornt'>
                                                    $nt</span>
                                                </td>";

                                            $anota=$notas[$aidmiembro]['eval']['RC']['nota'];;
                                            $colorbtn="text-danger";
                                                        if ($anota>=13) $colorbtn="text-primary";
                                            echo "<td class='cellnota' >
                                                    <input step='0.1' id='".$aidmiembro."RC' type='number' data-ideval='0' data-indicador='0' data-valor='".$anota."' max='20' min='0' data-edit='0' data-idnota='0' data-miembro='".$aidmiembro."' class='txtnotadecimal ".$colorbtn."' data-ntsaved='".$anota."' value='".$anota."'>
                                                </td>";

                                            $pf=$notas[$aidmiembro]['eval']['PF']['nota'];
                                            $colorpf="text-danger";
                                            if ($pf>=13) $colorpf="text-primary";
                                            $pfaltas=round($notas[$miembro->idmiembro]['asis']['faltas']/$nfechas*100,0);
                                            $isdpi=($pfaltas>30) ? "DPI" : "";
                                            if ($isdpi==""){
                                                echo "<td data-dpi='NO' class='cellfinal text-center p-0 text-bold $colorpf'><span id='".$aidmiembro."PF'>$pf</span></td>";
                                            }
                                            else{
                                                echo "<td data-dpi='SI' class='cellfinal bg-red text-center p-0'><span id='".$aidmiembro."PF'>$isdpi</span></td>";  
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
    var ancho=$(window).width();
    var vccaj = '<?php echo $curso->codcarga ?>';
    var vsscj = '<?php echo $curso->division ?>';
    var vindicadores = <?php echo json_encode($indicadores, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;


$(".table-registro td input").blur(function(event) {
    if ($(this).data('ntsaved') != $(this).val()) {

        $(this).data('edit', '1');
        if (($(this).val() < 0)||($(this).val() > 20)) {
            $(this).parent().addClass('cellerror');
        } else {
            if (Number.isNaN(Number($(this).val()))){
                $(this).parent().addClass('cellerror');
            }
            else{
                $(this).parent().removeClass('cellerror');
                $(this).parent().addClass('celleditada');
            }
        }
    }
    else{
        $(this).data('edit', '0');
        $(this).parent().removeClass('celleditada');
    }

    if ($(this).val() >= 13) {
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
            if (Number.isNaN(Number($(this).val()))){
                 nerror++    
            }
            else{
               if (($(this).val() < 0)||($(this).val() > 20)) {
                    nerror++    
                }
                else{
                      //@`vcca`, @`vsubseccion`, @`vidmiembro`, @`vecu_nota`, @`videvaluacionhead`
                    var myvals = [idmiembro, nota, idnota,idevh];
                    arrdata.push(myvals);
                }
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
                            $('.txtnotadecimal').each(function() {
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


$(window).on('resize', function(){
      ancho=$(this).width();
});

$(document).ready(function() {
 
    if (ancho <= 479) {
        $(".txtnotadecimal").attr('type', 'text' );
    } else {
        $(".txtnotadecimal").attr('type', 'number' );
    }
    
    //$("#switchpf").change();
    $('[data-toggle="tooltip"]').tooltip()
});

$(".txtnotadecimal").change(function(event) {
    /* Act on the event */
    var miembroid=$(this).data('miembro');
    promediar(miembroid);
});
function promediar(vidmiembro){
    var i=0;
    

    var pfs=0;
    var tas=0;
    var efs=0;


    
    if (i==0) i=1;
    var prf=pfs/i;
    var pfi=$("#" + vidmiembro + "PI").html();
    var ri=($("#" + vidmiembro +  "RC").val() * 1);
    var pif= ((pfi>ri) ? pfi : ri);

    
    


    
    spanpf=$("#" + vidmiembro + "PF");
    spanpf.html(pif)
    if (pif >= 13) {
        spanpf.removeClass('text-danger');
        spanpf.addClass('text-primary');
    } else {
        spanpf.removeClass('text-primary');
        spanpf.addClass('text-danger');
    }
}

/*function redondeo(n,exp){
    Math.round(Math.round(0.145 * Math.pow(10,exp)) / 10) / 100 // 0.15
}*/

</script>
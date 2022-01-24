<?php $vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
function echocard($vnum,$pgta,$resp){

        $colorcard=($pgta->codpregunta==0)?"card-danger":"card-primary";
        $codpregunta=base64url_encode($pgta->codpregunta);
        $pgvalor=floatval($pgta->valor);
        //$oblcheck=($pgta->vacio=="SI")?"checked":"";
        echo "<div name='ancla$codpregunta'  id='ancla$codpregunta' class='card-pregunta pregunta card card-outline ml-sm-2 ml-md-3 $colorcard' data-numero='$vnum' data-codpg='$codpregunta' data-tipopg='$pgta->codtipo' data-obligatoria='$pgta->vacio' >
                
                <div class='card-header px-sm-3 text-sm'>
                    <h4 class='card-title'>Pregunta $vnum</h4>
                 
                    <div class='card-tools'>
                      Puntaje: <span data-toggle='tooltip' title='$pgvalor puntos' class='badge badge-primary'>$pgvalor / <span class='vw_aee_spn_ptotal'>0</span></span>
                      
                    </div>
                </div>
                <div class='card-body px-2 px-sm-3 py-2'>
                    <div class='row'>
                        <div class='col-12 col-sm-12'>
                            <div class='row text-sm'>
                                <div class='col-12 col-md-12 mt-1'>
                                    $pgta->enunciado
                                </div>
                                
                                <div class='col-12 mt-1'>
                                    <small>$pgta->enunciadox</small>
                                </div>
                            </div>

                            <div class='divrptas row text-sm pt-3' data-contador='0'>";
                                $nro=0;
                                $tipocheck="radio";
                                if ($pgta->codtipo==4){
                                    $tipocheck="checkbox";
                                }
                                if ($pgta->codtipo==7){
                                    echo "<div class='rpta-radio col-12' data-idrp='0' data-pos='$nro' >
                                        <div class='row text-sm'>
                                            <div class='col-12 col-md-12 mt-1'>
                                                <textarea onkeyup='setaltura($(this));' rows='1' cols='80' class='form-control' placeholder='Tu respuesta'></textarea>
                                            </div>
                                        </div>
                                    </div>";

                                }
                                else
                                {
                                    foreach ($resp as $key => $rp) {
                                        $nro++;
                                        $codrp=base64url_encode($rp->codrpta);
                                        echo "<div class='rpta-radio col-12' data-idrp='$codrp' >
                                            <div class='input-group input-group-sm mb-1'>
                                              <div class='input-group-prepend'>
                                                <div class='input-group-text'>
                                                  <input class='vw_aep_rptacheck' type='$tipocheck' name='checkrpta$vnum' >
                                                </div>
                                              </div>
                                              <span class='form-control '>$rp->enunciado</span>
                                              
                                            </div>
                                        </div>"; 
                                    }

                                }
                           echo "</div>";
                    echo "</div>
                    <div class='diverror col-12 text-danger'>
                
                    </div>

                    </div>";
                    
                    
                    echo "<hr>

                </div>
            </div>";
}
?>
<style>
    textarea{ overflow:hidden; }
</style>
    <link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
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
                            <a href="<?php echo $vbaseurl.'alumno/aula-virtual'; ?>"><i class="fas fa-compass"></i> Unidades Didacticas</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'alumno/curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.$vcodmiembro; ?>"><i class="fas fa-caret-right"></i> Aula virtual
                            </a>
                        </li>
                        
                        <li class="breadcrumb-item active">Evaluación</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content ">
        <?php include 'vw_aula_encabezado.php'; ?>
            <input id="vdivision" name="vdivision" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->division) ?>">
            <input id="vidcurso" name="vidcurso" type="hidden" class="form-control" value="<?php echo  base64url_encode($curso->codcarga) ?>">
            <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo base64url_encode($mat->codigo) ?>">
            <input id="vcodmiembro" name="vcodmiembro" type="hidden" class="form-control" value="<?php echo $vcodmiembro ?>">
            <input id="vcodentrega" name="vcodentrega" type="hidden" class="form-control" value="0">
            
            <div class="card border-light">
                <?php
                
                $nombre="";
                $fvence="";
               
                $finicia="";
                $ptsmax=20;
                if (isset($mat->nombre))  $nombre=$mat->nombre;
                if (isset($mat->vence))  $fvence=$mat->vence;
                if (isset($mat->inicia))  $finicia=$mat->inicia;
                if (isset($mat->ptsmax))  $ptsmax=$mat->ptsmax;
                

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
                
                ?>
                <div class="card-header border px-2 px-sm-3">
                    <h3 class="card-title text-bold"> <?php echo $nombre ?></h3>
                    <div class='card-tools'>
                       <h3>Max.: <span class='vw_aee_spn_ptotal badge badge-primary'>0</span></h3>
                      
                    </div>
                    <br>
                    Culmina: <?php echo $fechav." - ".$horav ?>
                    
                </div>
            </div>
        <div class="container-fluid card" id="divcard_preguntas" style="background-color: transparent;box-shadow: none;">
            
            <?php 
            $nropregunta=0;
            $ptotal=0;
            foreach ($preguntas as $key => $pregunta) {
                $nropregunta++;
                $rp=array();
                if (isset($respuestas[$pregunta->codpregunta])) $rp=$respuestas[$pregunta->codpregunta];
                //var_dump($rp);
                $ptotal=$ptotal + $pregunta->valor;
                echocard($nropregunta,$pregunta,$rp);
            }
            ?>
            <!--AQUI TERMINA EL DIV DE PREGUNTA INDIVIDUAL-->
            <div class="card border-light">
                <div class="card-footer text-center">
                    <a href="<?php echo $vbaseurl.'alumno/curso/virtual/evaluacion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo).'/'.$vcodmiembro; ?>" class="btn btn-secondary float-left">Volver</a>
                    <a id="vw_aep_btn_enviar" href="#" class="btn btn-primary float-right">Enviar</a>
                </div>
            </div>
            
            
       <!-- </form>-->
        </div>
        <div class="card col-12 text-center" id="divcard_evamensaje">
            <div class="card-body text-center">
                <br>
                <span>Su exámen se envio correctamente, se envio una copia de su exámen a su correo institucional</span><br><br>
                <div class="row justify-content-center mt-2">
                    <div class="col-11 col-md-4">
                        <a id="vw_eval_btn_download" target="_blank" class="btn btn-primary btn-lg  d-block" href="#">
                            <i class="far fa-file-pdf mr-1"></i> Descargar Evaluación (Pdf)
                        </a>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-11 col-md-4">
                        <a id="vw_eval_btn_regresar" class="btn btn-secondary btn-lg d-block" href="#">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script>
    $(document).ready(function() {
        $(".vw_aee_spn_ptotal").html('<?php echo $ptotal ?>');
        $('#divcard_evamensaje').hide();
    });
function setaltura(ta){
     ta.height(1);
     ta.height(ta.prop('scrollHeight')-12);
}

function clickradio(btn){
    
    /*var opc= btn.find('.vw_aep_rptacheck');
    opc.prop('checked', true);
    var divrptas= btn.closest(".divrptas");
    divrptas.find('.input-group-text').css("background-color","#e9ecef");
    btn.css("background-color","#7DD643");
    return false;*/
}
$("#vw_aep_btn_enviar").click(function(event) {
    /* Act on the event */
    event.preventDefault();
    /*$(".card-pregunta.pregunta").find('textarea').removeClass('is-invalid');
    $(".card-pregunta.pregunta").find('.invalid-feedback').remove();*/
    $('.diverror').html('');
    // $(".card-pregunta.pregunta").append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('#divcard_preguntas').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    
    
    var codeval = $('#vidmaterial').val();
    var codmiembro = $('#vcodmiembro').val();
    var codentrega = $('#vcodentrega').val();
    var coddivision= $('#vdivision').val();
    var codcarga= $('#vidcurso').val();
    

    
    //Recopilamos respuestas
    arrdata = [];
    codspgerror = [];
    fdata=[];
    /*arrdeldata = [];

    var rppos=0;
    var radiook=0;
    vartcheck=card.find('input:checked').length;
    
    vartcheck= (vartcheck<1) ? 1:vartcheck;
    valrpta=Number(card.find("input[name='pg-valor']").val())/vartcheck;*/
    codpgerror="";
    enviar=true;
    texto="";
    $(".card-pregunta.pregunta").each(function() {
        codpg=$(this).data('codpg');
        tipopg=$(this).data('tipopg');
        num=$(this).data('numero');
        obligado=$(this).data('obligatoria');
        idrp=0;
        
        if (tipopg=='4'){
            checkeados=$(this).find("input[name='checkrpta" + num + "']:checked");
            if (checkeados.length==0){
                if (obligado=="SI"){
                    codspgerror.push(codpg);
                    $(this).find('.diverror').html('* Respuesta obligatoria');
                }
            }
            else{
                $(this).find(".rpta-radio").each(function() {
                    if ($(this).find('.vw_aep_rptacheck').prop('checked')==true){
                        idrp=$(this).data('idrp');
                        var myvals = [codpg,idrp,texto,tipopg];
                        arrdata.push(myvals);
                    }
                });
            }
        }
        else if (tipopg=='7'){
            texto=$(this).find('textarea').val();
            if (($.trim(texto)=="") && (obligado=="SI")){
                codspgerror.push(codpg);
                $(this).find('.diverror').html('* Respuesta obligatoria');
            }
            else{
                var myvals = [codpg,idrp,texto,tipopg];
                arrdata.push(myvals);
            }
        }
        else{
            checkeados=$(this).find("input[name='checkrpta" + num + "']:checked");
            if (checkeados.length==0){
                if (obligado=="SI"){
                    codspgerror.push(codpg);
                    $(this).find('.diverror').html('* Respuesta obligatoria');
                }
            }
            else if (checkeados.length==1){
                idrp=checkeados.closest('.rpta-radio').data('idrp');
                var myvals = [codpg,idrp,texto,tipopg];
                arrdata.push(myvals);
            }
            else{
                codspgerror.push(codpg);
                (this).find('.diverror').html('* Solo puedes escoger una opción');
            }
        }
    });
    if (codspgerror.length>0) codpgerror=codspgerror[0];
    if (codpgerror==""){
        $(".card-pregunta.pregunta").find('#divoverlay').remove();
        fdata.push({name: 'ex-cod', value: codeval});
        fdata.push({name: 'ex-carga', value: codcarga});
        fdata.push({name: 'ex-division', value: coddivision});
        fdata.push({name: 'ex-miembro', value:codmiembro});
        fdata.push({name: 'ex-codentrega', value: codentrega});
        fdata.push({name: 'rptas', value: JSON.stringify(arrdata)});

        $.ajax({
            url: base_url + 'virtualevaluacion/fn_guarda_examen_alumno',
            type: 'POST',
            data: fdata,
            dataType: 'json',
            success: function(e) {
                // $(".card-pregunta.pregunta").find('#divoverlay').remove();
                $('#divcard_preguntas #divoverlay').remove();
                if (e.status == true) {
                    $('#divcard_preguntas').hide();
                    $('#vw_eval_btn_download').attr('href', e.download);
                    $('#vw_eval_btn_regresar').attr('href', e.redirect);
                    $('#divcard_evamensaje').show();
                    // Swal.fire({
                    //     type: 'success',
                    //     icon: 'success',
                    //     title: 'Éxito',
                    //     text: 'Su exámen se envio correctamente, se envio una copia de su exámen a su correo institucional',
                    //     backdrop: true,
                    //     allowOutsideClick: false,
                    //     showCancelButton: true,
                    //     confirmButtonText: 'Descargar PDF',
                    //     cancelButtonText: 'Cerrar'
                    // }).then((result) => {
                    //     if (result.value) {

                    //     }
                    //     else if (result.dismiss === Swal.DismissReason.cancel) {
                                // window.location.href = e.redirect
                    //     }
                    // });
                    
                }
                else{
                    /*$.each(e.errors, function(key, val) {
                        control=form.find("[name='" + key + "']");
                        control.addClass('is-invalid');
                    });*/
                    alert("Error");
                }
            },
            error: function(jqXHR, exception) {
                // $(".card-pregunta.pregunta").find('#divoverlay').remove();
                $('#divcard_preguntas #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
            }
        });
    }
    else{
        arrdata = [];
        var ir = "ancla" + codpgerror;
        var new_position = jQuery('#'+ir).offset();
        window.scrollTo(new_position.left,new_position.top-150);
        // $(".card-pregunta.pregunta").find('#divoverlay').remove();
        $('#divcard_preguntas #divoverlay').remove();
    }


    return false;
});
</script>
<?php $vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
function echocard($vnum,$pgta,$resp){

        $colorcard=($pgta->codpregunta==0)?"card-danger":"card-primary";
        $codpregunta=base64url_encode($pgta->codpregunta);
        //$oblcheck=($pgta->vacio=="SI")?"checked":"";
        echo "<div name='ancla$codpregunta'  id='ancla$codpregunta' class='card-pregunta pregunta card card-outline ml-sm-2 ml-md-3 $colorcard' data-numero='$vnum' data-codpg='$codpregunta' data-tipopg='$pgta->codtipo' data-obligatoria='$pgta->vacio' >
                
                <div class='card-header px-2 px-sm-3 py-2 text-sm'>
                    <h4 class='card-title'>Pregunta $vnum</h4>
                 

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
                                                <div class='input-group-text'  onclick='clickradio($(this));'>
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
                    <h1><?php echo $mat->nombre ?>
                    <small> <?php echo $mat->curso; ?></small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'alumno/encuestas'; ?>"><i class="fas fa-compass"></i> Mis encuestas</a>
                        </li>
                       
                        
                        <li class="breadcrumb-item active">Revisar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content ">
        
           
           

            
            <input id="vcodentrega" name="vcodentrega" type="hidden" class="form-control" value="<?php echo base64url_encode($mat->codencuestallenar) ?>">
            <input id="vcodcuge" name="vcodcuge" type="hidden" class="form-control" value="<?php echo base64url_encode($mat->codigo) ?>">
            
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
                
                if ($finicia!=""){
                $fechai = fechaCastellano($finicia,$meses_ES,$dias_ES);
                $horai = date('h:i a',strtotime($finicia));


                }
                
                ?>
                <div class="card-header border px-2 px-sm-3">
                    <h3 class="card-title text-bold"> 
                    <?php echo "$mat->paterno $mat->materno $mat->nombres"  ?></h3><br>
                    Vence: <?php echo $fechav." - ".$horav ?>
                </div>
            </div>
        <div class="container-fluid">
            <?php 
            $nropregunta=0;
            foreach ($preguntas as $key => $pregunta) {
                $nropregunta++;
                $rp=array();
                if (isset($respuestas[$pregunta->codpregunta])) $rp=$respuestas[$pregunta->codpregunta];
                //var_dump($rp);
                echocard($nropregunta,$pregunta,$rp);
            }
            ?>
            <!--AQUI TERMINA EL DIV DE PREGUNTA INDIVIDUAL
            <div class="rpta-radio col-12 ocultar" data-idrp="0" data-delete="0" data-pos="">
                <div class="input-group mb-1">
                  <div class="input-group-prepend">
                    <div class="input-group-text" onclick="clickradio($(this));">
                      <input class="vw_aep_rptacheck" type="radio">
                    </div>
                  </div>
                  <input type="text" class="form-control rp-enunciado" >
                  <div class="input-group-append">
                    <a href='#' class='btn btn-default' onclick='delrpta($(this));event.preventDefault();'> <i class='far fa-trash-alt text-danger'></i></a>
                  </div>
                </div>
            </div>-->


            
            <div class="card border-light">
                <div class="card-footer text-center">
                    <a href="<?php echo $vbaseurl.'alumno/encuestas' ?>" class="btn btn-secondary float-left">Volver</a>
                    <a id="vw_aep_btn_enviar" href="#" class="btn btn-primary float-right">Enviar</a>
                </div>
            </div>
            
            
       <!-- </form>-->
        </div>
    </section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script>
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
    $(".card-pregunta.pregunta").append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    
    

    var codentrega = $('#vcodentrega').val();
    var codcuge = $('#vcodcuge').val();
   
    

    
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

        fdata.push({name: 'ex-codentrega', value: codentrega});
        fdata.push({name: 'ex-codcuge', value: codcuge});
        fdata.push({name: 'rptas', value: JSON.stringify(arrdata)});

        $.ajax({
            url: base_url + 'cuestionario_general/fn_guarda_cuestionario_encuestado',
            type: 'POST',
            data: fdata,
            dataType: 'json',
            success: function(e) {
                $(".card-pregunta.pregunta").find('#divoverlay').remove();
                if (e.status == true) {
                    window.location.href = e.redirect;
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
                $(".card-pregunta.pregunta").find('#divoverlay').remove();
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
        $(".card-pregunta.pregunta").find('#divoverlay').remove();
    }


    return false;
});
</script>
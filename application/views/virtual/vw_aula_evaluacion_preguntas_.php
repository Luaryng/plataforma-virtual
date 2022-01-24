<?php 
$vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
function echocard($vnum,$vclase,$tipospg,$pgta,$resp){

        $colorcard=($pgta->codpregunta==0)?"card-danger":"card-primary";
        $codpregunta=($pgta->codpregunta==0)? 0 :base64url_encode($pgta->codpregunta);
        $oblcheck=($pgta->vacio=="SI")?"checked":"";
        $verror=floatval($pgta->valore);
        $vmax=floatval($pgta->valor);
        $vvacio=floatval($pgta->valorv);
        echo "<div class='card-pregunta $vclase card  ml-sm-2 ml-md-3 card-outline $colorcard' data-numero='$vnum' >
                <form class='frm-pregunta' method='post' accept-charset='utf-8'>
                <div class='card-header px-2 px-sm-3 py-2 text-sm'>
                    <h4 class='card-title'>Pregunta $vnum</h4>
                    <div class='card-tools'>
                            <select data-currentvalue='$pgta->codtipo' name='pg-tipo' class='form-control-plaintext form-control-sm' title='Selecciona' required onchange='changeform($(this));'>";

                                foreach($tipospg as $pr){
                                    $sldtipo=($pgta->codtipo==$pr->codtipo)?"selected":"";
                                    echo "<option value='$pr->codtipo' $sldtipo   data-nroalterna='$pr->nroopc' >$pr->tipo</option>";
                                 }

                            echo "</select>
                    </div>

                </div>
                <input onchange='changeform($(this));' value='$codpregunta' type='hidden' data-currentvalue='$codpregunta' name='pg-codpg' min='1' >
                <input onchange='changeform($(this));' value='$pgta->pos' type='hidden' data-currentvalue='$pgta->pos' name='pg-pos' min='1' >
                <div class='card-body px-2 px-sm-3 py-2'>
                    <div class='row'>
                        <div class='col-12 col-sm-11'>
                            <div class='row text-sm'>
                                <div class='col-12 col-md-12 mt-1'>
                                    <textarea onchange='changeform($(this));' data-currentvalue='$pgta->enunciado' name='pg-enunciado' onkeyup='setaltura($(this));' rows='1' cols='80' class='form-control' placeholder='Enunciado'>$pgta->enunciado</textarea>
                                </div>
                                
                                <div class='col-12 mt-2'>
                                    <textarea onchange='changeform($(this));' data-currentvalue='$pgta->enunciadox' name='pg-descripcion' onkeyup='setaltura($(this));' class='form-control' rows='1' placeholder='Descripción'>$pgta->enunciadox</textarea>
                                </div>
                            </div>

                            <div class='divrptas row text-sm pt-3' data-contador='0'>";
                                $nro=0;
                                $tipocheck="radio";
                                if ($pgta->codtipo==4){
                                    $tipocheck="checkbox";
                                }
                                foreach ($resp as $key => $rp) {
                                    $nro++;
                                    $correcta=($rp->correcta=="SI")?"checked":"";
                                    $codrp=base64url_encode($rp->codrpta);
                                    echo "<div class='rpta-radio col-12' data-idrp='$codrp' data-pos='$nro' data-delete='0'>
                                        <div class='input-group mb-1'>
                                          <div class='input-group-prepend'>
                                            <div class='input-group-text' onclick='clickradio($(this));'>
                                              <input class='vw_aep_rptacheck' type='$tipocheck' $correcta name='checkrpta$vnum'>
                                            </div>
                                          </div>
                                          <input type='text' class='form-control rp-enunciado' value='$rp->enunciado' >
                                          <div class='input-group-append'>
                                            <a href='#' class='btn btn-default' onclick='delrpta($(this));event.preventDefault();'> <i class='far fa-trash-alt text-danger'></i></a>
                                          </div>
                                        </div>
                                    </div>";
                                }
                            $hideaddrpta=($pgta->codtipo==7)? "ocultar":"" ;
                            echo "<div class='rpta-add col-12 mt-2 $hideaddrpta'>
                                    <a class='ml-3' href='#'  onclick='addrpta($(this));event.preventDefault();'>Agregar opción</a>
                                </div>
                            </div>";
                    echo "</div>
                        <div class='col-1 d-none d-sm-block'>
                                <a role='button'  href='#' class='btn-apregunta btn btn-sm btn-primary m-1' onclick='addpreg($(this));event.preventDefault();'>
                                        <i class='fas fa-plus fa-xs'></i><i class='fas fa-question'></i>
                                </a> 
                                <a  href='#' class='btn-aseccion btn btn-sm btn-outline-secondary m-1'>
                                    <i class='fas fa-th-large'></i>
                                </a>
                                <a role='button'  href='#' class='btn btn-sm btn-outline-danger m-1'  onclick='delpreg($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i>
                                </a>
                        </div>

                    </div>";
                    
                    
                    echo "<hr>
                    <div class='row text-sm'>
                        <div class='col-12 col-md-2'>
                            <span class='vw_aep_editp'></span>
                        </div>
                        <div class='col-6 col-md-2 mt-2'>
                            <div class='form-group has-float-label'>
                                <input onchange='changeform($(this));' type='number' data-currentvalue='$pgta->valor' name='pg-valor' min='0' class='form-control form-control-sm' placeholder='Valor' value='$vmax' step='1'>
                                <label for='pg-valor'>Puntos</label>
                            </div>
                        </div>
                        <div class='col-6 col-sm-3 col-md-2 mt-2'>
                            
                            <input onchange='changeform($(this));' class='clcheckmostrar' value='SI' $oblcheck  data-currentvalue='$pgta->vacio' name='pg-obligatoria' type='checkbox' data-on='Obligatoria' data-off='Obligatoria?' data-size='small' data-onstyle='success' data-offstyle='default'>
                        </div>
                        <div class='col-6 col-md-2 mt-2'>
                            <div class='form-group has-float-label'>
                                <input onchange='changeform($(this));' type='number' data-currentvalue='$pgta->valorv' name='pg-valvacia' class='form-control form-control-sm' value='$vvacio' step='1' >
                                <label for='pg-valvacia'> Valor vacia</label>
                            </div>
                        </div>
                        <div class='col-6 col-md-2 mt-2'>
                            <div class='form-group has-float-label'>
                                <input onchange='changeform($(this));' type='number' data-currentvalue='$pgta->valorv' name='pg-valerror' class='form-control form-control-sm' value='$verror' step='1'>
                                <label for='pg-valerror'> Valor error</label>
                            </div>
                        </div>
                        <div class='col-6 col-md-2 mt-2 d-block d-sm-none'>
                            
                                <a role='button'  href='#' class='btn-apregunta btn btn-sm btn-primary m-1' onclick='addpreg($(this));event.preventDefault();'>
                                        <i class='fas fa-plus fa-xs'></i><i class='fas fa-question'></i></a> 
                                <a  href='#' class='btn-aseccion btn btn-sm btn-outline-secondary m-1'><i class='fas fa-th-large'></i></a>
                                <a role='button'  href='#' class='btn btn-sm btn-outline-danger m-1'  onclick='delpreg($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i></a>
                            
                        </div>
                        <div class='col-6 col-sm-12 col-md-2 mt-2 text-right'>
                            <a disabled class='btn btn-primary btn-pg-guardar' href='#' onclick='savepreg($(this));event.preventDefault();'>Guardar</a>
                        </div>
                    </div>

                </div>
                </form>
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
                            <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><i class="fas fa-caret-right"></i> Panel</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><i class="fas fa-caret-right"></i> Aula virtual
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
                $letraopciones=array("a","b","c","d","e","f","g","h");
                ?>
                <div class="card-header border px-2 px-sm-3">
                    <h3 class="card-title text-bold"> <?php echo $nombre ?></h3>
                    Vence: <?php echo $fechav." - ".$horav ?>
                     <div class="card-tools">
                      <button role="button" class="btn-apregunta btn btn-primary" onclick="addpreg_cero();event.preventDefault();">+?</button>
                    </div>
                </div>
            </div>
        <div class="container-fluid connectedSortable">
        
        <!--<form id='frm-insertupdate' name='frm-insertupdate'   method='post' accept-charset='utf-8'>-->
            
                
            <?php 
            $pg = new stdClass;
            $pg->codpregunta=0;
            $pg->codmaterial="";
            $pg->codagrupador="";
            $pg->codtipo="";
            $pg->pos="";
            $pg->enunciado="";
            $pg->enunciadox="";
            $pg->rpta="";
            $pg->valor=1;
            $pg->nroopc=1;
            $pg->vacio='NO';
            $pg->valorv=0;
            $pg->valore=0;

            foreach($tppreguntas as $key => $pr){
                if ($pr->codtipo==4){
                    unset($tppreguntas[$key]);
                }
            }
            

            echocard(0,"ocultar",$tppreguntas,$pg,array());
            $nropregunta=0;
            
            foreach ($preguntas as $key => $pregunta) {
                $nropregunta++;
                $rp=array();
                if (isset($respuestas[$pregunta->codpregunta])) $rp=$respuestas[$pregunta->codpregunta];
                //var_dump($rp);
                echocard($nropregunta,"pregunta",$tppreguntas,$pregunta,$rp);
            }
            ?>
            <!--AQUI TERMINA EL DIV DE PREGUNTA INDIVIDUAL-->
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
            </div>


            <div class="col-12">
                
            </div>
            <div class="card border-light">
                <div class="card-footer text-center">
                    <a href="<?php echo $vbaseurl.'curso/virtual/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>" class="btn btn-secondary float-left">Volver</a>
                </div>
            </div>
            
            
       <!-- </form>-->
        </div>
    </section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script>
var arrayorden = [];
var frmdp_edit = new Array();
var checkid=<?php echo $nropregunta  ; ?>;
jQuery(document).ready(function($) {
    $('.clcheckmostrar').bootstrapToggle();
    //checkidu=<?php echo $nropregunta - 1 ; ?>;
    for (var i = 0; i <= checkid; i++) {
        frmdp_edit[i] = new Array();
    }

    $(".card-pregunta.pregunta textarea").each(function(index, ta) {
        $(this).height(1);
        $(this).height($(this).prop('scrollHeight')-12);
    });
    $('.connectedSortable').sortable({
        placeholder         : 'sort-highlight',
        connectWith         : '.connectedSortable',
        handle              : '.card-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex              : 999999,
        update: function(event, ui) {
            
            /*$(".order-list li").each(function(index, el) {
                $(this).find('.norden').html(index + 1);
                var codind = $(this).data("id");
                var norden = index + 1;
                //dataString = {fecha: fcha, accion: accn ,idmiembro: idacu};
                var myvals = [norden, codind];
                arrdata.push(myvals);
            });*/
            ordpreg();
            saveorden();
        },
    });
    $('.connectedSortable .card-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

});

function saveorden(){
    $('.card-pregunta.pregunta').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'virtualevaluacion/f_ordenar',
                type: 'post',
                dataType: 'json',
                data: {
                    filas: JSON.stringify(arrayorden),
                },
                success: function(e) {
                    $('.card-pregunta.pregunta #divoverlay').remove();
                },
                error: function(jqXHR, exception) {
                    $('.card-pregunta.pregunta #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: msgf,
                        backdrop: false,
                    });
                },
            });
}
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


//$('input,select,textarea').change(function() {
function changeform(btn){
    //alert("cambio");
    var card= btn.closest(".card-pregunta.pregunta");
    var crd=card.data('numero');
    var isedit=false;
    if (btn.attr('type')=="number"){
        isedit=(parseFloat(btn.data('currentvalue')) !== parseFloat(btn.val()));
    }
    else if (btn.attr('type')=="checkbox"){
        trad=(btn.prop('checked')==true)?"SI":"NO";
        isedit=(btn.data('currentvalue') !== trad);
    }
    else{
        isedit=(btn.data('currentvalue') != btn.val());
    }

    if (isedit) {
        if (frmdp_edit[crd].indexOf(btn.attr('name')) == -1) frmdp_edit[crd].push(btn.attr('name'));
    } else {
        var i = frmdp_edit[crd].indexOf(btn.attr('name'));
        i !== -1 && frmdp_edit[crd].splice(i, 1);
    }

    //Preguntar si hay cambios
    if (frmdp_edit[crd].length > 0) {
        card.find(".vw_aep_editp").html("* modificado");
        card.addClass('card-danger');
        card.removeClass('card-primary');
    } else {
        card.find(".vw_aep_editp").html("");
        card.removeClass('card-danger');
        card.addClass('card-primary');
    }
    
    // SOLO SI ES EL COMBO "TIPO DE PREGUNTA"
    if (btn.prop('name') == "pg-tipo") {
        card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        card.find(".rpta-radio").each(function() {
            if($(this).data('idrp')=="0"){
                $(this).remove();
            } 
            else{
                if(btn.val()==btn.data('currentvalue')){
                    $(this).data('delete', '0');
                    $(this).show();
                }
                else{
                    $(this).data('delete', '1');
                    $(this).hide();
                }
               
            }
        });
        if(btn.val()!=btn.data('currentvalue')){
            if (btn.val()=="1"){  
                addrpta_card(card,"Respuesta 1");
                addrpta_card(card,"Respuesta 2");
                addrpta_card(card,"Respuesta 3");
                card.find(".rpta-add").show();
            }
            else  if (btn.val()=="2"){  
                addrpta_card(card,"Verdadero");
                addrpta_card(card,"Falso");
                card.find(".rpta-add").show();
            }
            else if (btn.val()=="3"){  
                addrpta_card(card,"SI");
                addrpta_card(card,"NO");
                card.find(".rpta-add").show();
            }
            else if (btn.val()=="7"){  
                card.find(".rpta-add").hide();
                /*addrpta_card(card,"SI");
                addrpta_card(card,"NO");*/
            }
        }
        
        card.find('#divoverlay').remove();
    }

};



function addpreg_cero(){
    $('.clcheckmostrar').bootstrapToggle('destroy');
    var card= $(".card-pregunta.ocultar");
    var newcard= $(".card-pregunta.ocultar").clone();
    checkid++;
    newcard.removeClass('ocultar');
    frmdp_edit[checkid] = new Array();
    newcard.data('numero', checkid);
    newcard.addClass('pregunta');
    card.after(newcard);
    ordpreg();
    //newcard.find('.clcheckmostrar').prop('id', 'checko' + checkid)
    $('.clcheckmostrar').bootstrapToggle();
    saveorden();
    //rpadd.find('input:text').focus();
    

    addrpta_card(newcard,"Respuesta 1");
    addrpta_card(newcard,"Respuesta 2");
    addrpta_card(newcard,"Respuesta 3");
    newcard.find('textarea[name="pg-enunciado"]').focus();
    //$('#checko' + checkid).bootstrapToggle();
    return false;
}

function addpreg(btn){
    $('.clcheckmostrar').bootstrapToggle('destroy');
    var card= btn.closest(".card-pregunta.pregunta");
    var newcard= $(".card-pregunta.ocultar").clone();
    newcard.removeClass('ocultar');
    newcard.addClass('pregunta');

    card.after(newcard);
    
    checkid++;
    frmdp_edit[checkid] = new Array();
    newcard.data('numero', checkid);
    ordpreg();
    $('.clcheckmostrar').bootstrapToggle();
    saveorden();
    addrpta_card(newcard,"Respuesta 1");
    addrpta_card(newcard,"Respuesta 2");
    addrpta_card(newcard,"Respuesta 3");
    newcard.find('textarea[name="pg-enunciado"]').focus();

    return false;
}
//$('#my-card').on('expanded.lte.cardwidget', handleExpandedEvent)
$('.card-pregunta.eliminada').on('removed.lte.cardwidget', function() {
    $(this).remove();
    //ordpreg();
    //
});

function delpreg(btn){
    //alert("addpreg");
    var card= btn.closest(".card-pregunta.pregunta");
    card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var idpg= card.find("input[name='pg-codpg']").val();
    
    if (idpg=='0'){
        card.removeClass('pregunta');
        card.addClass('eliminada');
        card.CardWidget('remove');
        ordpreg();
    }
    else{
        $.ajax({
            url: base_url + 'virtualevaluacion/fn_delete_pregunta',
            type: 'POST',
            data: {
                "codpgta": idpg
            },
            dataType: 'json',
            success: function(e) {
                
                if (e.status == true) {
                    card.removeClass('pregunta');
                    card.addClass('eliminada');
                    card.CardWidget('remove');
                    ordpreg();
                }
                else{
                    Swal.fire(
                      'Error!',
                      e.msg,
                      'error'
                    )
                }
                card.find('#divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                card.find('#divoverlay').remove();
                //$('#divcard_grupo #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
            }
        });
    }
    return false;
}

function ordpreg(){
    var pos=0;
    arrayorden = [];
    $( ".card-pregunta.pregunta" ).each(function( index ) {
        pos++;
        $(this).find('.card-title') .html("Pregunta " + pos);
        $(this).find('input[name="pg-pos"]').val(pos);
        codind=$(this).find('input[name="pg-codpg"]').val();
        var myvals = [pos, codind];
        arrayorden.push(myvals);
    });
    

}

function delrpta(btn){
    //alert("addpreg");
    var card= btn.closest(".card-pregunta.pregunta");
    card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var rpta= btn.closest(".rpta-radio");
    var idrp= rpta.data('idrp');
    if (idrp=='0'){
        rpta.remove();
        card.find('#divoverlay').remove();
    }
    else{
        $.ajax({
            url: base_url + 'virtualevaluacion/fn_delete_respuesta',
            type: 'POST',
            data: {
                "codrpta": idrp
            },
            dataType: 'json',
            success: function(e) {
                card.find('#divoverlay').remove();
                if (e.status == true) {
                    rpta.remove();
                }
                else{
                    Swal.fire(
                      'Error!',
                      e.msg,
                      'error'
                    )
                }
            },
            error: function(jqXHR, exception) {
                card.find('#divoverlay').remove();
                //$('#divcard_grupo #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
            }
        });
    }
    return false;
}

function addrpta(btn){
    //alert("addpreg");
    var card= btn.closest(".card-pregunta.pregunta");
    var tipoPreg=card.find('select').val();
    if ((tipoPreg=="1") || (tipoPreg=="2") || (tipoPreg=="3")){
        var divbtn= btn.closest(".rpta-add");
        var newrpta= $(".rpta-radio.ocultar").clone();
        newrpta.removeClass('ocultar');
        divbtn.before(newrpta);
        newrpta.find('.vw_aep_rptacheck').prop('name', 'checkrpta' + card.data('numero'))
        newrpta.find(".rp-enunciado").focus();
    }
    else if (tipoPreg=="4"){
        var divbtn= btn.closest(".rpta-add");
        var newrpta= $(".rpta-radio.ocultar").clone();
        newrpta.removeClass('ocultar');
        divbtn.before(newrpta);
        //newrpta.find('.vw_aep_rptacheck').prop('name', 'checkrpta' + card.data('numero'))
        newrpta.find('.vw_aep_rptacheck').attr('type', 'checkbox' );
        newrpta.find(".rp-enunciado").focus();

    }
    return false;
}


function addrpta_card(card,texto,tipo){
    var tipoPreg=card.find('select').val();
    if ((tipoPreg=="1") || (tipoPreg=="2") || (tipoPreg=="3")){
        var divbtn= card.find(".rpta-add");
        var newrpta= $(".rpta-radio.ocultar").clone();
        newrpta.removeClass('ocultar');
        divbtn.before(newrpta);
        newrpta.find('.vw_aep_rptacheck').prop('name', 'checkrpta' + card.data('numero'))
        enu=newrpta.find(".rp-enunciado");
        enu.val(texto);
        enu.focus();
    }
    else if (tipoPreg=="4"){
        var divbtn= card.find(".rpta-add");
        var newrpta= $(".rpta-radio.ocultar").clone();
        newrpta.removeClass('ocultar');
        divbtn.before(newrpta);
        //newrpta.find('.vw_aep_rptacheck').prop('name', 'checkrpta' + card.data('numero'))
        newrpta.find('.vw_aep_rptacheck').attr('type', 'checkbox' );
        enu=newrpta.find(".rp-enunciado");
        enu.val(texto);
        enu.focus();
    }
    return false;
}

function savepreg(btn){
    var card= btn.closest(".card-pregunta.pregunta");
    card.find('textarea').removeClass('is-invalid');
    card.find('.invalid-feedback').remove();
    var crd=card.data('numero');
    card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var form=btn.closest('.frm-pregunta');
    var fdata=form.serializeArray();
    var codeval = $('#vidmaterial').val();
    fdata.push({name: 'pg-material', value: codeval});
    fdata.push({name: 'pg-agrupador', value: 1});
    //Recopilamos respuestas
    arrdata = [];
    arrdeldata = [];

    var rppos=0;
    var radiook=0;
    vartcheck=card.find('input:checked').length;
    
    vartcheck= (vartcheck<1) ? 1:vartcheck;
    valrpta=Number(card.find("input[name='pg-valor']").val())/vartcheck;
    
    card.find(".rpta-radio").each(function() {
        if ($(this).data('delete')=="1"){
            arrdeldata.push($(this).data('idrp'));
        }
        else{
            rppos++;
            $(this).data('pos', rppos);
            isok="NO";
            pmax=0;
            if ($(this).find('.vw_aep_rptacheck').prop('checked')==true){
                isok="SI";
                pmax=valrpta;
                radiook++;
            }
            var myvals = [rppos, pmax ,$(this).find(".rp-enunciado").val(), isok ,"",$(this).data('idrp')];
            arrdata.push(myvals);
        }
    });
    fdata.push({name: 'rptas', value: JSON.stringify(arrdata)});
    fdata.push({name: 'delrptas', value: JSON.stringify(arrdeldata)});

    $.ajax({
        url: base_url + 'virtualevaluacion/fn_guarda_pegunta',
        type: 'POST',
        data: fdata,
        dataType: 'json',
        success: function(e) {
            card.find('#divoverlay').remove();
            if (e.status == true) {
                if (e.newid!=="--"){
                    form.find("[name='pg-codpg']").val(e.newid);
                }
                card.find('input,textarea,select').each(function() {
                    $(this).data('currentvalue', $(this).val());
                });
                var cheh=card.find("[name='pg-obligatoria']");
                trad=(cheh.prop('checked')==true)?"SI":"NO";
                cheh.data('currentvalue', trad);
                frmdp_edit[crd] = new Array();
                card.find(".vw_aep_editp").html("");

                card.removeClass('card-danger');
                card.addClass('card-primary');

                card.find(".rpta-radio").each(function() {
                    if($(this).data('idrp')=="0") $(this).data('idrp',e.newrp[$(this).data('pos')]);
                });
                
            }
            else{
                $.each(e.errors, function(key, val) {
                    control=form.find("[name='" + key + "']");
                    control.addClass('is-invalid');
                });
            }
        },
        error: function(jqXHR, exception) {
            card.find('#divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
              'Error!',
              msgf,
              'error'
            )
        }
    })
    return false;
}


$(".btn-calificar").click(function(event) {
    var btn = $(this);
    var ajcodtarea = $("#vidmaterial").val();
    var ajcodcarga = $("#vidcurso").val();
    var ajcoddivision = $("#vdivision").val();
    var ajnota = 0;
    var ajcodmiembro = btn.data('miembro');
    var ajcodentrega = btn.data('entrega');
    (async() => {
        const {
            value: vdocente
        } = await Swal.fire({
            title: 'Nota',
            input: 'text',
            inputPlaceholder: 'Ingresa un Número',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Guardar!',
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if ((value < 0) || (value > 20)) {
                        resolve('Para guardar, debes ingresar una calificación entre 0 y 20');
                    } else {
                        $.ajax({
                            url: base_url + 'virtualtarea/fn_calificar',
                            type: 'POST',
                            data: {
                                "ajcodtarea": ajcodtarea,
                                "ajcodcarga": ajcodcarga,
                                "ajcoddivision": ajcoddivision,
                                "ajnota": value,
                                "ajcodmiembro": ajcodmiembro,
                                "ajcodentrega": ajcodentrega
                            },
                            dataType: 'json',
                            success: function(e) {
                                //$('#divcard_grupo #divoverlay').remove();
                                if (e.status == true) {
                                    if (value == "") value = "Calificar "
                                    btn.html(value + '<i class="fas fa-pencil-alt ml-2"></i>');
                                    if (ajcodentrega == 0) {
                                        btn.data('entrega', e.newid);
                                    }
                                    resolve();
                                } else {
                                    resolve(e.msg);
                                }
                            },
                            error: function(jqXHR, exception) {
                                card.find('#divoverlay').remove();
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
});
</script>
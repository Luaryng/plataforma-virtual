<style>
.rp-enunciado{
  flex: 1 1 180px !important;
}
.rp-valoracion{
  flex: 0 1 60px !important;
}

</style>
<?php 
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
$vbaseurl=base_url();
function echocard($vnum,$vclase,$tipospg,$pgta,$resp){

        $colorcard=($pgta->codpregunta==0)?"card-danger":"card-primary";
        $codpregunta=($pgta->codpregunta==0)? 0 :base64url_encode($pgta->codpregunta);
        $oblcheck=($pgta->vacio=="SI")?"checked":"";
        $valcheck=($pgta->valorada=="SI")?"checked":"";
        $verror=floatval($pgta->valore);
        $vmax=floatval($pgta->valor);
        $vvacio=floatval($pgta->valorv);
        $rpicon="";
        echo "<div class='card-pregunta $vclase card  ml-sm-2 ml-md-3 card-outline $colorcard' data-numero='$vnum' >
                <form class='frm-pregunta' method='post' accept-charset='utf-8'>
                <div class='card-header px-2 px-sm-3 py-2 text-sm'>
                    <h4 class='card-title'>Pregunta $vnum</h4>
                    <div class='card-tools'>
                            <select data-currentvalue='$pgta->codtipo' name='pg-tipo' class='form-control-plaintext form-control-sm' title='Selecciona' required  onchange='changeform($(this));saveblurpg($(this));' data-tpcn='pg'>";

                                foreach($tipospg as $pr){
                                    $sldtipo="";
                                    if ($pgta->codtipo==$pr->codtipo){
                                        $sldtipo="selected";
                                        $rpicon=$pr->icon;
                                    }
                                    echo "<option data-icon='$pr->icon' value='$pr->codtipo' $sldtipo >$pr->tipo</option>";
                                }

                            echo "</select>
                    </div>

                </div>
                <input data-tpcn='pg' value='$codpregunta' type='hidden' data-currentvalue='$codpregunta' name='pg-codpg' >
                <input data-tpcn='pg' value='$pgta->pos' type='hidden' data-currentvalue='$pgta->pos' name='pg-pos' min='1' >
                <div class='card-body px-2 px-sm-3 py-2'>
                    <div class='row'>
                        <div class='col-12 col-sm-11'>
                            <div class='row text-sm'>
                                <div class='col-12 col-md-12 mt-1'>
                                    <textarea onblur='saveblurpg($(this));' data-tpcn='pg' data-currentvalue='$pgta->enunciado' name='pg-enunciado' onkeyup='setaltura($(this));' rows='1' cols='80' class='form-control' placeholder='Enunciado'>$pgta->enunciado</textarea>
                                </div>
                                
                                <div class='col-12 mt-2'>
                                    <textarea onblur='saveblurpg($(this));' data-tpcn='pg' data-currentvalue='$pgta->enunciadox' name='pg-descripcion' onkeyup='setaltura($(this));' class='form-control' rows='1' placeholder='Descripción'>$pgta->enunciadox</textarea>
                                </div>
                            </div>

                            <div class='divrptas row text-sm pt-3'>";
                                $nro=1;
                                foreach ($resp as $key => $rp) {
                                   
                                    $correcta=($rp->correcta=="SI")?"checked":"";
                                    $codrp=base64url_encode($rp->codrpta);
                                    $valrp=floatval($rp->valor);
                                    $oculvalorada=($pgta->valorada=="NO")?"ocultar":"";
                                    echo "<div class='rpta-radio col-12' data-idrp='$codrp' data-pos='$rp->pos' data-delete='0'>
                                        <div class='input-group mb-1'>
                                          <div class='input-group-prepend'>
                                            <span class='input-group-text'>
                                             <i class='$rpicon'></i>
                                            </span>
                                          </div>
                                          <input data-currentvalue='$rp->enunciado' type='text' class='form-control rp-enunciado' value='$rp->enunciado' onblur='saveblurrp($(this));' >
                                          <input data-currentvalue='$valrp' type='text' class='form-control rp-valoracion $oculvalorada' placeholder='pts' value='$valrp' onblur='saveblurrp($(this));' >
                                         
                                          <div class='input-group-append'>
                                            <a tabindex='-1' href='#' class='btn btn-default' onclick='delrpta($(this));event.preventDefault();'> <i class='far fa-trash-alt text-danger'></i></a>
                                          </div>
                                        </div>
                                    </div>";
                                     $nro=$rp->pos;
                                }
                            $hideaddrpta=($pgta->codtipo==7)? "ocultar":"" ;
                            echo "<div class='rpta-add col-12 mt-2 $hideaddrpta'>
                                    <a class='ml-3' data-contador='$nro' href='#'  onclick='addrpta($(this));event.preventDefault();'>Agregar opción</a>
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
                        
                        
                        <div class='col-6 col-sm-3 col-md-2'>
                            
                            <input onchange='saveblurpg($(this));'  data-tpcn='pg' class='clcheckmostrar' value='' $oblcheck  data-currentvalue='$pgta->vacio' name='pg-obligatoria' type='checkbox' data-on='Obligatoria' data-off='Obligatoria?' data-size='small' data-onstyle='success' data-offstyle='default'>
                        </div>
                        <div class='col-6 col-sm-3 col-md-2'>
                            <input onchange='camvaloracion($(this));saveblurpg($(this));'  data-tpcn='pg' class='clcheckmostrar' value='' $valcheck  data-currentvalue='$pgta->valorada' name='pg-valorada' type='checkbox' data-on='Valorada' data-off='Valorada?' data-size='small' data-onstyle='success' data-offstyle='default'>
                        </div>
                        <div class='col-6 col-md-2  d-block d-sm-none'>
                            
                                <a role='button'  href='#' class='btn-apregunta btn btn-sm btn-primary m-1' onclick='addpreg($(this));event.preventDefault();'>
                                        <i class='fas fa-plus fa-xs'></i><i class='fas fa-question'></i>
                                </a> 
                                <a  href='#' class='btn-aseccion btn btn-sm btn-outline-secondary m-1'>
                                    <i class='fas fa-th-large'></i>
                                </a>
                                <a role='button'  href='#' class='btn btn-sm btn-outline-danger m-1'  onclick='delpreg($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i>
                                </a>
                            
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
                    <h1>PANEL DE PREGUNTAS
                    <small> <?php //echo $curso->codseccion.$curso->division; ?></small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>monitoreo/estudiantes?tb=e"><i class="fas fa-compass"></i> Monitoreo estudiante</a>
                        </li>
                     
                      <li class="breadcrumb-item active">Preguntas</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content ">
        
            <input id="vidmaterial" name="vidmaterial" type="hidden" class="form-control" value="<?php echo base64url_encode($vcencuesta->codigo) ?>">
            
            <div class="card border-light">
                <?php
                
                $nombre="";
                $fvence="";
               
                $finicia="";
                $ptsmax=20;
                if (isset($vcencuesta->nombre))  $nombre=$vcencuesta->nombre;
                if (isset($vcencuesta->vence))  $fvence=$vcencuesta->vence;
                if (isset($vcencuesta->inicia))  $finicia=$vcencuesta->inicia;
                if (isset($vcencuesta->ptsmax))  $ptsmax=$vcencuesta->ptsmax;
                

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
            $pg->valorada='NO';
            $pg->valorv=0;
            $pg->valore=0;

            /*foreach($tppreguntas as $key => $pr){
                //if ($pr->codtipo==4){
                    unset($tppreguntas[$key]);
                }
            }*/
            

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
            <div class="rpta-radio col-12 ocultar" data-idrp="0" data-delete="0" data-pos="" >
                <div class="input-group mb-1">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class='fas fa-dot-circle'></i>
                    </div>
                  </div>
                  <input data-currentvalue=""  data-tpcn='rp' type="text" class="form-control rp-enunciado" onblur='saveblurrp($(this));' >
                  <input data-currentvalue="0" data-tpcn='rp' type='text' class='form-control rp-valoracion' placeholder='pts' value='0' onblur='saveblurrp($(this));'  >
                  <div class="input-group-append">
                    <a tabindex='-1'  href='#' class='btn btn-default' onclick='delrpta($(this));event.preventDefault();'> <i class='far fa-trash-alt text-danger'></i></a>
                  </div>
                </div>
            </div>

            <div class="col-12">
                
            </div>
            <div class="card border-light">
                <div class="card-footer text-center">
                    <a href="<?php echo $vbaseurl ?>monitoreo/estudiantes?tb=e" class="btn btn-secondary float-left">Volver</a>
                </div>
            </div>
            
            
       <!-- </form>-->
        </div>
    </section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script>
var arrayorden = [];
var checkid = <?php echo $nropregunta  ; ?>;
jQuery(document).ready(function($) {
    $('.clcheckmostrar').bootstrapToggle();
    //checkidu=<?php echo $nropregunta - 1 ; ?>;
    $(".card-pregunta.pregunta textarea").each(function(index, ta) {
        $(this).height(1);
        $(this).height($(this).prop('scrollHeight') - 12);
    });
    $('.connectedSortable').sortable({
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.card-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex: 999999,
        update: function(event, ui) {
            ordpreg();
            saveorden();
        },
    });
    $('.connectedSortable .card-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');
});

function saveorden() {
    $('.card-pregunta.pregunta').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cuestionario_general/f_ordenar',
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

function setaltura(ta) {
    ta.height(1);
    ta.height(ta.prop('scrollHeight') - 12);
}
//$('input,select,textarea').change(function() {
function changeform(btn) {
    // SOLO SI ES EL COMBO "TIPO DE PREGUNTA"
    if (btn.prop('name') == "pg-tipo") {
        var card = btn.closest(".card-pregunta.pregunta");
        card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        icon = btn.find(':selected').data('icon')
        if ((btn.val() == "1") || (btn.val() == "4")) {
            card.find(".rpta-radio").each(function() {
                var check = $(this).find('.input-group-text').html("<i class='" + icon + "'></i>");
            });
            card.find(".rpta-add").show();
            //saveblurrps(btn);
        } else if (btn.val() == "7") {
            card.find(".rpta-radio").each(function() {
                if ($(this).data('idrp') == "0") {
                    $(this).remove();
                } else {
                    if (btn.val() == btn.data('currentvalue')) {
                        $(this).data('delete', '0');
                        $(this).show();
                    } else {
                        $(this).data('delete', '1');
                        $(this).hide();
                    }
                }
            });
            deleteblurrps(btn);
            card.find(".rpta-add").hide();

        }
        card.find('#divoverlay').remove();
    }
};

function addpreg_cero() {
    $('.clcheckmostrar').bootstrapToggle('destroy');
    var card = $(".card-pregunta.ocultar");
    var newcard = $(".card-pregunta.ocultar").clone();
    checkid++;
    newcard.removeClass('ocultar');
    newcard.data('numero', checkid);
    newcard.addClass('pregunta');
    card.after(newcard);
    ordpreg();
    $('.clcheckmostrar').bootstrapToggle();
    saveorden();
    newcard.find("[name='pg-enunciado']").focus();
    return false;
}

function addpreg(btn) {
    $('.clcheckmostrar').bootstrapToggle('destroy');
    var card = btn.closest(".card-pregunta.pregunta");
    var newcard = $(".card-pregunta.ocultar").clone();
    newcard.removeClass('ocultar');
    newcard.addClass('pregunta');
    card.after(newcard);

    checkid++;
    newcard.data('numero', checkid);
    ordpreg();
    $('.clcheckmostrar').bootstrapToggle();
    saveorden();
    newcard.find("[name='pg-enunciado']").focus();
    return false;
}
$('.card-pregunta.eliminada').on('removed.lte.cardwidget', function() {
    $(this).remove();
});

function delpreg(btn) {
    //alert("addpreg");
    var card = btn.closest(".card-pregunta.pregunta");
    card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var idpg = card.find("input[name='pg-codpg']").val();

    if (idpg == '0') {
        card.removeClass('pregunta');
        card.addClass('eliminada');
        card.CardWidget('remove');
        ordpreg();
    } else {
        $.ajax({
            url: base_url + 'cuestionario_general/fn_delete_pregunta',
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
                } else {
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

function ordpreg() {
    var pos = 0;
    arrayorden = [];
    $(".card-pregunta.pregunta").each(function(index) {
        pos++;
        $(this).find('.card-title').html("Pregunta " + pos);
        $(this).find('input[name="pg-pos"]').val(pos);
        codind = $(this).find('input[name="pg-codpg"]').val();
        var myvals = [pos, codind];
        arrayorden.push(myvals);
    });

}

function delrpta(btn) {
    var card = btn.closest(".card-pregunta.pregunta");
    card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var rpta = btn.closest(".rpta-radio");
    var idrp = rpta.data('idrp');
    if (idrp == '0') {
        rpta.remove();
        card.find('#divoverlay').remove();
    } else {
        $.ajax({
            url: base_url + 'cuestionario_general/fn_delete_respuesta',
            type: 'POST',
            data: {
                "codrpta": idrp
            },
            dataType: 'json',
            success: function(e) {
                card.find('#divoverlay').remove();
                if (e.status == true) {
                    rpta.remove();
                } else {
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

function addrpta(btn) {
    var card = btn.closest(".card-pregunta.pregunta");
    var txtenunciado = card.find("[name='pg-enunciado']");
    txtenunciado.removeClass('is-invalid');
    if ($.trim(txtenunciado.val()) == "") {
        txtenunciado.addClass('is-invalid');
        card.removeClass('card-primary');
        card.addClass('card-danger');
        txtenunciado.focus();
        return false;
    }
    var chvalorada = card.find("[name='pg-valorada']").prop('checked');
    var tipoPreg = card.find('select');


    var divbtn = btn.closest(".rpta-add");
    var newrpta = $(".rpta-radio.ocultar").clone();

    newrpta.removeClass('ocultar');
    divbtn.before(newrpta);
    icon = tipoPreg.find(':selected').data('icon');
    contador = Number(btn.data('contador')) + 1;
    newrpta.data('pos', contador)
    btn.data('contador', contador);
    saveautorp(newrpta, card.find("[name='pg-codpg']").val(),card);
    newrpta.find('.input-group-text').html("<i class='" + icon + "'></i>");
    //valoracion
    txtval = newrpta.find(".rp-valoracion");

    if (chvalorada == false) txtval.addClass('ocultar');
    //enunciado
    

    return false;
}

function saveblurpg(btn) {
    if (btn.val() == btn.data('currentvalue')) return false;
    var card = btn.closest(".card-pregunta.pregunta");
    var txtenunciado = card.find("[name='pg-enunciado']");
    btn.removeClass('is-invalid');
    if ($.trim(txtenunciado.val()) == "") {
        txtenunciado.addClass('is-invalid');
        card.removeClass('card-primary');
        card.addClass('card-danger');
        return false;
    }
    var form = btn.closest('.frm-pregunta');
    var fdata = form.serializeArray();
    var codeval = $('#vidmaterial').val();
    fdata.push({
        name: 'pg-material',
        value: codeval
    });
    fdata.push({
        name: 'pg-agrupador',
        value: 1
    });
    //Recopilamos respuestas
    $.ajax({
        url: base_url + 'cuestionario_general/fn_guardab_pegunta',
        type: 'POST',
        data: fdata,
        dataType: 'json',
        success: function(e) {
            //card.find('#divoverlay').remove();
            if (e.status == true) {
                if (e.newid !== "--") {
                    form.find("[name='pg-codpg']").val(e.newid);
                }
                card.find('input,textarea,select').each(function() {
                    $(this).data('currentvalue', $(this).val());
                });
                var cheh = card.find("[name='pg-obligatoria']");
                trad = (cheh.prop('checked') == true) ? "SI" : "NO";
                cheh.data('currentvalue', trad);
                var chev = card.find("[name='pg-valorada']");
                trad = (chev.prop('checked') == true) ? "SI" : "NO";
                chev.data('currentvalue', trad);
                card.removeClass('card-danger');
                card.addClass('card-primary');
            } else {
                $.each(e.errors, function(key, val) {
                    control = form.find("[name='" + key + "']");
                    control.addClass('is-invalid');
                });
            }
        },
        error: function(jqXHR, exception) {
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

function saveblurrp(btn) {
    if ($.trim(btn.val()) == "") btn.val(btn.data('currentvalue'));
    if (btn.val() == btn.data('currentvalue')) return false;
    var card = btn.closest(".card-pregunta.pregunta");
    var txtenunciado = card.find("[name='pg-enunciado']");
    btn.removeClass('is-invalid');
    if ($.trim(txtenunciado.val()) == "") {
        txtenunciado.addClass('is-invalid');
        card.removeClass('card-primary');
        card.addClass('card-danger');
        txtenunciado.focus();
        return false;
    }
    var form = btn.closest('.frm-pregunta');
    var fdata = [];
    var codeval = $('#vidmaterial').val();
    var codpg = form.find("[name='pg-codpg']").val();
    fdata.push({
        name: 'pg-material',
        value: codeval
    });
    fdata.push({
        name: 'pg-codpg',
        value: codpg
    });
    //Recopilamos respuestas
    arrdata = [];

    var rp = btn.closest('.rpta-radio');
    var rppos = rp.data('pos');
    var enunc = rp.find(".rp-enunciado");
    if ($.trim(enunc.val()) != "") {
        var myvals = [rppos, rp.find(".rp-valoracion").val(), enunc.val(), "NO", "", rp.data('idrp')];
        fdata.push({
            name: 'rptas',
            value: JSON.stringify(myvals)
        });
        $.ajax({
            url: base_url + 'cuestionario_general/fn_guardab_respuesta',
            type: 'POST',
            data: fdata,
            dataType: 'json',
            success: function(e) {
                if (e.status == true) {
                    /*card.find('input,textarea,select').each(function() {
                    $(this).data('currentvalue', $(this).val());
                    });*/
                    var cheh = card.find("[name='pg-obligatoria']");
                    trad = (cheh.prop('checked') == true) ? "SI" : "NO";
                    cheh.data('currentvalue', trad);
                    card.removeClass('card-danger');
                    card.addClass('card-primary');
                    card.find(".rpta-radio").each(function() {
                        if ($(this).data('idrp') == "0") $(this).data('idrp', e.newrp[$(this).data('pos')]);
                    });

                } else {
                    $.each(e.errors, function(key, val) {
                        control = form.find("[name='" + key + "']");
                        control.addClass('is-invalid');
                    });
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                    'Error!',
                    msgf,
                    'error'
                )
            }
        })
    }
    return false;
}

function saveautorp(rp, codpg,card) {
    card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var fdata = [];
    var codeval = $('#vidmaterial').val();
    fdata.push({
        name: 'pg-material',
        value: codeval
    });
    fdata.push({
        name: 'pg-codpg',
        value: codpg
    });
    //Recopilamos respuestas
    var rppos = rp.data('pos');
    isok = "NO";
    var enunc = $.trim(rp.find(".rp-enunciado").val());
    var myvals = [rppos, rp.find(".rp-valoracion").val(), enunc, isok, "", rp.data('idrp')];
    fdata.push({
        name: 'rptas',
        value: JSON.stringify(myvals)
    });
    $.ajax({
        url: base_url + 'cuestionario_general/fn_guardab_respuesta',
        type: 'POST',
        data: fdata,
        dataType: 'json',
        success: function(e) {

            if (e.status == true) {

                if (rp.data('idrp') == "0") rp.data('idrp', e.newrp);
                rp.find(".rp-enunciado").focus();

            } else {

            }
            card.find('#divoverlay').remove();
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

function deleteblurrps(btn) {
    var card = btn.closest(".card-pregunta.pregunta");
    var fdata = [];
    var codpg = card.find("[name='pg-codpg']").val();
    $.ajax({
        url: base_url + 'cuestionario_general/fn_delete_respuestas_x_pregunta',
        type: 'POST',
        data: {
            name: 'pg-codpg',
            value: codpg
        },
        dataType: 'json',
        success: function(e) {

        },
        error: function(jqXHR, exception) {
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

function camvaloracion(btn) {
    //alert(btn.prop('checked'));
    var card = btn.closest(".card-pregunta.pregunta");
    if (btn.prop('checked') == true) {
        card.find(".rp-valoracion").removeClass("ocultar");
    } else {
        card.find(".rp-valoracion").addClass("ocultar");
    }

}
</script>
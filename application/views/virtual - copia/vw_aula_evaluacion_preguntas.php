<?php 
$vbaseurl=base_url();
$dias_ES = array("Dom","Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", );
$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
$pgmaterialConCeros="m".str_pad($mat->codigo, 11, "0", STR_PAD_LEFT);
function echocard($vnum,$vclase,$tipospg,$pgta,$resp,$carpeta){

        $colorcard=($pgta->codpregunta==0)?"card-danger":"card-primary";
        $codpregunta=($pgta->codpregunta==0)? 0 :base64url_encode($pgta->codpregunta);
        $oblcheck=($pgta->vacio=="SI")?"checked":"";
        $verror=floatval($pgta->valore);
        $vmax=floatval($pgta->valor);
        $vvacio=floatval($pgta->valorv);
        $venunciado=stripslashes($pgta->enunciado);
        $venunciadox=stripslashes($pgta->enunciadox);
        $vimagen = ($pgta->imagen != null) ? $pgta->imagen : "";

        $vbaseurlpg = base_url();
        $drowopt = "";
        $imgpreg = ($pgta->imagen != null) ? "src='{$vbaseurlpg}upload/aulavirtual/evaluaciones/{$carpeta}/thumb/{$vimagen}'" : "";
        if ($imgpreg != "") {
            $drowopt = "<div class='dropdown down-image bg-light'>
                            <button class='btn dropdown-toggle' type='button' data-toggle='dropdown' style='background: transparent;' aria-expanded='false'>
                                <i class='fas fa-ellipsis-v' style='color: #000;'></i>
                            </button>
                            <ul class='dropdown-menu'>
                              <li><a href='#' class='itemdeleteimg' onclick='delimgpreg($(this));event.preventDefault();'>Eliminar</a></li>
                            </ul>
                        </div>";
        }

        echo "<div class='card-pregunta $vclase card  ml-sm-2 ml-md-3 card-outline $colorcard' data-numero='$vnum' data-imagen='$vimagen' data-imagendelete='NO'>
                <form class='frm-pregunta' method='post' accept-charset='utf-8' enctype='multipart/form-data'>
                <div class='card-header px-2 px-sm-3 py-2 text-sm'>
                    <h4 class='card-title'>Pregunta $vnum</h4>
                    <div class='card-tools'>
                            <select data-currentvalue='$pgta->codtipo' name='pg-tipo' class='form-control-plaintext form-control-sm' title='Selecciona' required onchange='changeform($(this));'>";

                                foreach($tipospg as $pr){
                                    $sldtipo=($pgta->codtipo==$pr->codtipo)?"selected":"";
                                    echo "<option value='$pr->codtipo' $sldtipo data-nroalterna='$pr->nroopc' >$pr->tipo</option>";
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
                                <div class='col-10 col-md-11 mt-1'>
                                    <textarea onchange='changeform($(this));'";
                                    echo ' data-currentvalue="'.htmlspecialchars($venunciado).'"';
                                    echo " name='pg-enunciado' onkeyup='setaltura($(this));' rows='1' cols='80' class='form-control' placeholder='Enunciado'>";
                                    echo htmlspecialchars($venunciado);
                                    echo"</textarea>
                                </div>

                                <div class='col-2 col-md-1 mt-1'>
                                    <a type='button' class='bg-light image-btn' onclick='addimagepreg($(this));event.preventDefault();'>
                                        <i class='fas fa-image'></i>
                                    </a>
                                    <input type='file' onchange='previewFile($(this));'' name='pg-image' style='display:none' accept='image/png, image/jpeg'>
                                </div>
                                
                                <div class='col-12 mt-2'>
                                    <textarea onchange='changeform($(this));' data-currentvalue='$venunciadox' name='pg-descripcion' onkeyup='setaltura($(this));' class='form-control' rows='1' placeholder='Descripción'>$venunciadox</textarea>
                                </div>

                                <div class='col-12 mt-2'>
                                    <div class='group_image'>
                                        <img class='preview_image_preg mt-2 img-fluid mx-auto mb-3' $imgpreg>
                                        $drowopt
                                    </div>
                                    
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
                                    $rpenunciado=stripslashes($rp->enunciado);
                                    
                                    $drowrpta = "";
                                    $hidegroup = "style='display:none'";
                                    $hidegroupbtn = "";

                                    $imgrpta = ($rp->imagen != "") ? "src='{$vbaseurlpg}upload/aulavirtual/evaluaciones/{$carpeta}/thumb/{$rp->imagen}'" : "";
                                    if ($imgrpta != "") {
                                        $hidegroup = "";
                                        $hidegroupbtn = "style='display:none'";
                                        $drowrpta = "<a type='button' href='#' class='imgrptadel' onclick='delimgrpta($(this));event.preventDefault();'><i class='fas fa-times'></i></a>";
                                        
                                    }
                                    echo "<div class='rpta-radio col-12' data-imagen='$rp->imagen' data-imagentemp='' data-imagendelete='NO' data-idrp='$codrp' data-pos='$nro' data-delete='0'>
                                        <div class='input-group mb-1'>
                                          <div class='input-group-prepend'>
                                            <div class='input-group-text' onclick='clickradio($(this));'>
                                              <input class='vw_aep_rptacheck' type='$tipocheck' $correcta name='checkrpta$vnum'>
                                            </div>
                                          </div>";
                                          echo '<input type="text" class="form-control rp-enunciado" value="'.htmlspecialchars($rpenunciado).'" >';
                                          echo "<div class='input-group-append'>
                                            <a href='#' class='btn btn-default' onclick='delrpta($(this));event.preventDefault();'> <i class='far fa-trash-alt text-danger'></i></a>
                                          </div>
                                          <div class='input-group-append'>
                                            <a type='button' class='bg-light image-btn-rpta' onclick='addimagerpta($(this));event.preventDefault();' $hidegroupbtn>
                                                <i class='fas fa-image'></i>
                                            </a>
                                            <input class='input_file_imgrpta'  onchange='fn_preview_image_rpta($(this),event);event.preventDefault();' type='file' name='rpta-image' style='display:none' accept='image/png, image/jpeg'>
                                          </div>
                                        </div>
                                        <div class='col-12'>
                                            <div class='vw_mpc_txt_progress'></div>
                                            <div class='vw_mpc_txt_size'></div>
                                            <div class='vw_mpc_txt_type'></div>
                                            <div class='vw_mpc_pgBar'></div>
                                            <div class='group_image_rpta' $hidegroup>
                                                <img class='preview_image_rpta img-fluid mx-auto mb-3 mt-2' $imgrpta>
                                                $drowrpta
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
                        <div class='col-12 col-md-2 text-bold text-danger'>
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
    .image-btn, .image-btn-rpta {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        align-items: center;
        display: flex;
        justify-content: center;
        text-align: center;
    }

    .image-btn-rpta {
        margin-left: 10px;
    }

    .dropdown-toggle::after {
        display: inline-block;
        margin-left: .255em;
        vertical-align: .255em;
        content: "";
        border-top: .3em solid;
        border-right: .3em solid transparent;
        border-bottom: 0;
        border-left: .3em solid transparent;
        color: transparent;
    }

    .group_image, .group_image_rpta {
        position: relative;
    }

    .group_image .down-image {
        position: absolute;
        top: 5px;
        width: 34px;
        height: 34px;
        border-radius: 50%;

    }

    .group_image .down-image:hover {
        background-color: #dae0e5 !important;
    }

    .group_image .down-image button > i {
        text-align: center;
        margin-left: 2px;
    }

    .dropdown-menu>li>a {
        display: block;
        padding: 3px 20px;
        clear: both;
        font-weight: 400;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
    }

    .group_image_rpta .imgrptadel {
        position: absolute;
        top: 3px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        align-items: center;
        display: flex;
        justify-content: center;
        text-align: center;
        font-size: 9px;
        background-color: #dc3545;
        color: white;
    }

    .group_image_rpta .imgrptadel:hover {
        background-color: #dae0e5 !important;
    }


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
            $pg->imagen=null;
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
            

            echocard(0,"ocultar",$tppreguntas,$pg,array(),$pgmaterialConCeros);
            $nropregunta=0;
            
            foreach ($preguntas as $key => $pregunta) {
                $nropregunta++;
                $rp=array();
                if (isset($respuestas[$pregunta->codpregunta])) $rp=$respuestas[$pregunta->codpregunta];
                //var_dump($rp);
                echocard($nropregunta,"pregunta",$tppreguntas,$pregunta,$rp,$pgmaterialConCeros);
            }
            ?>
            <!--AQUI TERMINA EL DIV DE PREGUNTA INDIVIDUAL-->
            <div class="rpta-radio col-12 ocultar" data-imagen='' data-imagentemp='' data-imagendelete='NO' data-idrp="0" data-delete="0" data-pos="" >
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text" onclick="clickradio($(this));">
                            <input class="vw_aep_rptacheck" type="radio">
                        </div>
                    </div>
                    <input type="text" class="form-control rp-enunciado" >
                    <div class="input-group-append">
                        <a href='#' class='btn btn-default' onclick='delrpta($(this));event.preventDefault();'>
                            <i class='far fa-trash-alt text-danger'></i>
                        </a>
                    </div>

                    <div class='input-group-append'>
                        <a type='button' class='bg-light image-btn-rpta' onclick='addimagerpta($(this));event.preventDefault();' $hidegroupbtn>
                            <i class='fas fa-image'></i>
                        </a>
                        <input type='file'  class='input_file_imgrpta'  onchange='fn_preview_image_rpta($(this),event);event.preventDefault();'  name='rpta-image' style='display:none' accept='image/png, image/jpeg'>
                        <input type='hidden' name='rpta-image-link' value='0'>
                    </div>
                </div>
                <div class='col-12'>
                    <div class='vw_mpc_txt_progress'></div>
                    <div class='vw_mpc_txt_size'></div>
                    <div class='vw_mpc_txt_type'></div>
                    <div class='vw_mpc_pgBar'></div>
                    <div class='group_image_rpta' style="display: none;">
                        <img class='preview_image_rpta img-fluid mx-auto mb-3 mt-2'>
                    </div>
                </div>
            </div>


            <div class="col-12">
                
            </div>
            <div class="card border-light">
                <div class="card-footer text-center">
                    
                    <a href="<?php echo $vbaseurl.'curso/virtual/evaluacion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($mat->codigo); ?>" class="btn btn-secondary float-left">Volver</a>
                </div>
            </div>
            
            
       <!-- </form>-->
        </div>
    </section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script src='<?php echo $vbaseurl ?>resources/plugins/simpleUpload/simpleUpload.min.js'></script>

<script>
var arrayorden = [];
var frmdp_edit = new Array();
var vcarpeta="<?php echo $pgmaterialConCeros ?>";
var checkid=<?php echo $nropregunta  ; ?>;
jQuery(document).ready(function($) {
    $(".vw_mpc_txt_size").hide();
    $(".vw_mpc_txt_type").hide();
    // $('.group_image_rpta').hide();
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
        card.find(".vw_aep_editp").html("* Sin Guardar");
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
    var imgvrpta = rpta.find("input[name='rpta-image-link']").val();
    // if (idrp=='0'){
    //     rpta.remove();
    //     card.find('#divoverlay').remove();
    // }
    // else{
        $.ajax({
            url: base_url + 'virtualevaluacion/fn_delete_respuesta',
            type: 'POST',
            data: {
                "codrpta": idrp,
                "imgrpta": imgvrpta
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
    // }
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
    //var prev_img = card.find(".preview_image_preg");
    //var dropprev_img = card.find(".down-image");

    var form=btn.closest('.frm-pregunta');
    // var fdata=form.serializeArray();
    var fdata = new FormData(form[0]);

    var codeval = $('#vidmaterial').val();
    fdata.append('pg-material',codeval);
    fdata.append('pg-agrupador',1);

    var imgactual=card.data('imagen');
    var imgeliminar=card.data('imagendelete');
    fdata.append('pg-imgactual',imgactual);
    fdata.append('pg-imgeliminar',imgeliminar);
    // fdata.push({name: 'pg-material', value: codeval});
    // fdata.push({name: 'pg-agrupador', value: 1});
    //Recopilamos respuestas
    arrdata = [];
    arrdeldata = [];

    var rppos=0;
    var radiook=0;
    vartcheck=card.find('input:checked').length;
    
    vartcheck= (vartcheck<1) ? 1:vartcheck;
    valrpta=Number(card.find("input[name='pg-valor']").val())/vartcheck;
    
    //RECORRER RESPUESTAS
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
            var rptaimage = $(this).data('imagen');
            var imgrptadel = $(this).data('imagendelete');
            var imgtemprpta = $(this).data('imagentemp');
            //var imgguardada = (rptaimage == "0") ? "" : rptaimage;
            // var myvals = [rppos, pmax ,$(this).find(".rp-enunciado").val(), isok ,"",$(this).data('idrp')];
            var myvals = [rppos, pmax ,$(this).find(".rp-enunciado").val(), isok ,rptaimage,$(this).data('idrp'),imgrptadel,imgtemprpta];

            arrdata.push(myvals);
        }
    });


    fdata.append('rptas',JSON.stringify(arrdata));
    fdata.append('delrptas',JSON.stringify(arrdeldata));
    // fdata.push({name: 'rptas', value: JSON.stringify(arrdata)});
    // fdata.push({name: 'delrptas', value: JSON.stringify(arrdeldata)});

    $.ajax({
        url: base_url + 'virtualevaluacion/fn_guarda_pegunta',
        type: 'POST',
        data: fdata,
        dataType: 'json',
        contentType: false,
        processData: false,
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
                    if($(this).data('idrp')=="0") $(this).data('idrp',e.newrp[$(this).data('pos')]['nid']);
                    
                    $(this).data('imagen',e.newrp[$(this).data('pos')]['img']);
                    $(this).data('imagentemp',"");
                    $(this).data('imagendelete',"NO");
                });

                //if (e.newimg!== "") {
                card.data('imagen',e.newimg);
                var imgvpg = card.find("input[name='pg-image']");
                imgvpg.val('');
                    /*dropprev_img.html("");
                    dropprev_img.append("<button class='btn dropdown-toggle' type='button' data-toggle='dropdown' style='background: transparent;' aria-expanded='false'>"+
                                "<i class='fas fa-ellipsis-v' style='color: #000;'></i>"+
                            "</button>"+
                            "<ul class='dropdown-menu'>"+
                              "<li><a href='#' class='itemdeleteimg' data-image='"+e.newimg+"' onclick='delimgpreg($(this));event.preventDefault();'>Eliminar</a></li>"+
                            "</ul>");*/
                //}
                
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




 function previewFile(input){
        var card= input.closest(".card-pregunta.pregunta");
        
        var prev_img = card.find(".preview_image_preg");
        var file = input.get(0).files[0];
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                prev_img.addClass('img-fluid mx-auto mb-3');
                prev_img.attr("src", reader.result);
                
                //var crd=card.data('numero');
             //Preguntar si hay cambios
               
                card.find(".vw_aep_editp").html("* Sin Guardar");
                card.addClass('card-danger');
                card.removeClass('card-primary');
                card.data('imagendelete', 'NO')
                
                
                prev_img.after("<div class='dropdown down-image bg-danger'>"+
                                "<button class='btn dropdown-toggle' type='button' data-toggle='dropdown' style='background: transparent;' aria-expanded='false'>"+
                                    "<i class='fas fa-ellipsis-v' style='color: #000;'></i>"+
                                "</button>"+
                                "<ul class='dropdown-menu'>"+
                                  "<li><a href='#' class='itemdeleteimg'  onclick='delimgpreg($(this));event.preventDefault();'>Eliminar</a></li>"+
                                "</ul>"+
                            "</div>");
            }
 
            reader.readAsDataURL(file);
        }
    }

function addimagepreg(btn) {
    var card= btn.closest(".card-pregunta.pregunta");
    var imgpg= card.find("input[name='pg-image']").trigger('click');
    
}

function delimgpreg(btn) {
    var card= btn.closest(".card-pregunta.pregunta");
    card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var idpg= card.find("input[name='pg-codpg']").val();
    var imgvpg = card.find("input[name='pg-image']");
    var prev_img = card.find(".preview_image_preg");
    var dropdow = card.find('.down-image');
    //var imagen = btn.data('imagen');
    var btnimgvpg = card.find(".image-btn");
    
        imgvpg.val('');
        prev_img.removeAttr('src');
        dropdow.remove();
        card.find('#divoverlay').remove();
        btnimgvpg.show();
        card.data('imagendelete',"SI");

    return false;
}

function addimagerpta(btn) {
    var card= btn.closest(".card-pregunta.pregunta");
    card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var rpta= btn.closest(".rpta-radio");
    // var idrp= rpta.data('idrp');
    //var previmgrpta = rpta.find('.preview_image_rpta');
    var imgrpta= rpta.find("input[name='rpta-image']").trigger('click');
    var imgvrpta = rpta.find("input[name='rpta-image']");
    
    card.find('#divoverlay').remove();

    /*imgvrpta.change(function(e) {
        var imagen = this.files[0];
        card.find('#divoverlay').remove();

        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);

        $(datosImagen).on("load", function(event){

            var rutaImagen = event.target.result;

            imgvrpta.simpleUpload(base_url + "virtualevaluacion/fn_upload_file_image", {
                allowedExts: ["jpg", "jpeg", "png"],
                maxFileSize: 10485760, //10MB in bytes
                start: function(file) {
                    //upload started
                    // $('#vw_mpc_txt_filename').html(file.name);
                    rpta.find('.vw_mpc_txt_size').html(file.size);
                    rpta.find('.vw_mpc_txt_type').html(file.type);
                    rpta.find('.vw_mpc_txt_progress').html("0%");
                    rpta.find('.vw_mpc_pgBar').width(0);
                    rpta.find('.vw_mpc_txt_progress').show();
                    rpta.find('.vw_mpc_pgBar').show();
                },
                progress: function(progress) {
                    //received progress
                    rpta.find('.vw_mpc_txt_progress').html("Progress: " + Math.round(progress) + "%");
                    rpta.find('.vw_mpc_pgBar').width(progress + "%");
                },
                success: function(data) {
                    rpta.find('.vw_mpc_txt_progress').hide();
                    rpta.find('.vw_mpc_pgBar').hide();

                    var newarchivo = data.link;
                    alert(data.link);
                    rpta.find('.group_image_rpta').show();
                    rpta.data('imagentemp',newarchivo);
                    rpta.data('.imagendelete',"SI");

                    alert(rpta.data('imagentemp'));
                    previmgrpta.addClass('img-fluid mx-auto mb-3 mt-2');
                    previmgrpta.attr("src", rutaImagen);
                    
                    previmgrpta.after("<a type='button' href='#' class='imgrptadel' onclick='delimgrpta($(this));event.preventDefault();'><i class='fas fa-times'></i></a>");
                    btnimgvrpta.hide();

                    rpta.find("input[name='rpta-image-link']").val("");
                },
                error: function(error) {
                    //upload failed
                    switch (error.name) {
                        case 'InvalidFileExtensionError':
                            vmsg = "Este tipo de archivo no es admitido";
                            break;
                        case 'MaxFileSizeError':
                            vmsg = "El peso máximo permitido es de 10MB";
                            break;
                        default:
                            vmsg = error.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: "Error! " + error.name,
                        text: vmsg,
                        backdrop: false,
                    });
                    rpta.find('.vw_mpc_txt_size').html("");
                    rpta.find('.vw_mpc_txt_type').html("");
                    card.find('#divoverlay').remove();
                }
            })
            

        })
        
    });*/
}

function fn_preview_image_rpta(btn,evento){
    var card= btn.closest(".card-pregunta.pregunta");
    card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var rpta= btn.closest(".rpta-radio");
    var previmgrpta = rpta.find('.preview_image_rpta');
    var btn_agrega_imgrpta = rpta.find(".image-btn-rpta");

        /*var imagen = btn.files[0];
        card.find('#divoverlay').remove();

        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);

        $(datosImagen).on("load", function(event){*/

            //var rutaImagen = event.target.result;

            btn.simpleUpload(base_url + "virtualevaluacion/fn_upload_file_image", {
                allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif"],
                allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
                maxFileSize: 10485760, //10MB in bytes
                start: function(file) {
                    //upload started
                    // $('#vw_mpc_txt_filename').html(file.name);
                    rpta.find('.vw_mpc_txt_size').html(file.size);
                    rpta.find('.vw_mpc_txt_type').html(file.type);
                    rpta.find('.vw_mpc_txt_progress').html("0%");
                    rpta.find('.vw_mpc_pgBar').width(0);
                    rpta.find('.vw_mpc_txt_progress').show();
                    rpta.find('.vw_mpc_pgBar').show();
                },
                progress: function(progress) {
                    //received progress
                    rpta.find('.vw_mpc_txt_progress').html("Progress: " + Math.round(progress) + "%");
                    rpta.find('.vw_mpc_pgBar').width(progress + "%");
                },
                success: function(data) {
                    rpta.find('.vw_mpc_txt_progress').hide();
                    rpta.find('.vw_mpc_pgBar').hide();

                    var newarchivo = data.link;
                    rpta.find('.group_image_rpta').show();
                    rpta.data('imagentemp',newarchivo);
                    rpta.data('.imagendelete',"SI");

                    previmgrpta.addClass('img-fluid mx-auto mb-3 mt-2');
                    previmgrpta.attr("src", URL.createObjectURL(evento.target.files[0]));
                    
                    previmgrpta.after("<a type='button' href='#' class='imgrptadel' onclick='delimgrpta($(this));event.preventDefault();'><i class='fas fa-times'></i></a>");
                    btn_agrega_imgrpta.hide();

                    rpta.find("input[name='rpta-image-link']").val("");
                    card.find('#divoverlay').remove();
                },
                error: function(error) {
                    //upload failed
                    switch (error.name) {
                        case 'InvalidFileExtensionError':
                            vmsg = "Este tipo de archivo no es admitido";
                            break;
                        case 'MaxFileSizeError':
                            vmsg = "El peso máximo permitido es de 10MB";
                            break;
                        default:
                            vmsg = error.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: "Error! " + error.name,
                        text: vmsg,
                        backdrop: false,
                    });
                    rpta.find('.vw_mpc_txt_size').html("");
                    rpta.find('.vw_mpc_txt_type').html("");
                    card.find('#divoverlay').remove();
                }
            })
            

        //})
        
    };

function delimgrpta(btn) {
    var card= btn.closest(".card-pregunta.pregunta");
    //var respuesta=btn.closest('rpta-radio');
    //card.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var rpta= btn.closest(".rpta-radio");
    var idrp= rpta.data('idrp');
    var imgvpg = rpta.find("input[name='rpta-image']");
    var prev_imgrpta = rpta.find(".preview_image_rpta");
    //var dropdow = rpta.find('.imgrptadel');
    //var imagen = btn.data('imagerpta');

    //rpta.data('imagerptadel',"SI");
    rpta.data('imagendelete',"SI")
    rpta.data('imagentemp',"")
    var btnimgvpg = rpta.find(".image-btn-rpta");

    // if (idrp=='0'){
    imgvpg.val('');
    prev_imgrpta.removeAttr('src');
    rpta.find('.group_image_rpta').hide();
    //card.find('#divoverlay').remove();
    btnimgvpg.show();

    return false;

}
</script>
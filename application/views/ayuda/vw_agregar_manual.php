<?php
	$vbaseurl = base_url();
	$mcodigo="0";
	$mtipo = $tipo;
	$morden = $orden;
	$mtitulo = "";
	$menlace = "";
	$vaccesos="";
    $mgrupo = "";

	if (isset($manual->codigo))  $mcodigo = base64url_encode($manual->codigo);
	if (isset($manual->tipo))  $mtipo = $manual->tipo;
	if (isset($manual->orden))  $morden = base64url_encode($manual->orden);
	if (isset($manual->nombre))  $mtitulo = $manual->nombre;
	if (isset($manual->enlace))  $menlace = $manual->enlace;
	if (isset($manual->accesos))  $vaccesos=$manual->accesos;
    if (isset($manual->grupo))  $mgrupo=$manual->grupo;

	$arrayAccs = explode(",", $vaccesos);

	function obtienevalor($array, $valor)
	{

	    for ($i = 0; $i < count($array); $i++) {
	        if ($array[$i] == $valor) {
	            return $array[$i];
	        }
	    }
	    
	}
?>

<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
	<section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Manual
                    <small>Mantenimiento</small></h1>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>ayuda/tutoriales">Manual</a>
                        </li>
                        <li class="breadcrumb-item active">Mantenimiento</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content">
    	<div id="vw_pw_bt_ad_div_principal" class="card">
    		<div class="card-body">
    			<form id="vw_pw_bt_ad_form_addmanual" action="" method="post" accept-charset="utf-8">
    				<div class="row mt-2">
                        <input id="vw_pw_bt_ad_fictxtcodigo" name="vw_pw_bt_ad_fictxtcodigo" type="hidden" value="<?php echo $mcodigo ?>">
                        <input id="vw_pw_bt_ad_fictxttipo" name="vw_pw_bt_ad_fictxttipo" type="hidden" value="<?php echo $mtipo ?>">
                        <input id="vw_pw_bt_ad_fictxtorden" name="vw_pw_bt_ad_fictxtorden" type="hidden" value="<?php echo $morden ?>">
                        <?php 
                            $columna = (($mtipo == "video") || ($mtipo == "VIDEO")) ? "col-sm-6" : "col-sm-12";
                            $textsummer = (($mtipo == "video") || ($mtipo == "VIDEO")) ? "vw_pw_bt_textmanual_summer" : "";
                            $textfloat = (($mtipo == "video") || ($mtipo == "VIDEO")) ? "" : "has-float-label";
                        ?>
                        <div class="form-group <?php echo $textfloat ?> col-12 col-sm-12">
                            <label for="vw_pw_bt_ad_fictxttitulo">Titulo</label>
                            <textarea data-currentvalue='' autocomplete="off" class="form-control form-control-sm <?php echo $textsummer ?>" id="vw_pw_bt_ad_fictxttitulo" name="vw_pw_bt_ad_fictxttitulo" placeholder="Titulo <?php echo $mtipo ?>" rows="1"><?php echo $mtitulo ?></textarea>
                        </div>

                        <?php if (($mtipo == "video") || ($mtipo == "VIDEO")): ?>
                        <div class="form-group has-float-label col-12 col-sm-6">
                            <label for="vw_pw_bt_ad_fictxtgrupo">Grupo:</label>
                            <input list="ltsgrupos" name="vw_pw_bt_ad_fictxtgrupo" id="vw_pw_bt_ad_fictxtgrupo" class="form-control form-control-sm" placeholder="Grupo" value="<?php echo $mgrupo ?>">
                            <datalist id="ltsgrupos">
                                <?php foreach ($manuales as $key => $grp) {
                                    echo "<option value='$grp->grupo'>";
                                } ?>
                            </datalist>
                        </div>
                        <?php endif ?>
                        <div class="form-group has-float-label col-12 <?php echo $columna ?>">
                            <input data-currentvalue='' autocomplete="off" class="form-control form-control-sm" id="vw_pw_bt_ad_fictxtenlace" name="vw_pw_bt_ad_fictxtenlace" type="text" placeholder="Enlace <?php echo $mtipo ?>" value="<?php echo $menlace ?>" />
                            <label for="vw_pw_bt_ad_fictxtenlace">Enlace <?php echo $mtipo ?></label>
                        </div>

                        <div class="col-12 col-md-12">
                            <span class="font-weight-bold h6"><u>¿Quienes pueden visualizarlo?</u></span>
                            <div class="row mt-2" id="itemsacc">
                                <div class="form-group col-12 col-md-3">
                                    <div  class="icheck-primary ml-2">
                                        <input type="checkbox" <?php echo (obtienevalor($arrayAccs, "AD") == "AD") ? "checked": "" ?> value="AD" name="checktipo1" id="checktipo1" class="selectitem">
                                        <label for="checktipo1" class="text">Administrativos</label>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-2">
                                    <div  class="icheck-primary ml-2">
                                        <input type="checkbox" <?php echo (obtienevalor($arrayAccs, "DC") == "DC") ? "checked": "" ?> value="DC" name="checktipo2" id="checktipo2" class="selectitem">
                                        <label for="checktipo2" class="text">Docentes</label>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div  class="icheck-primary ml-2">
                                        <input type="checkbox" <?php echo (obtienevalor($arrayAccs, "DA") == "DA") ? "checked": "" ?> value="DA" name="checktipo3" id="checktipo3" class="selectitem">
                                        <label for="checktipo3" class="text">Docentes Administrativos</label>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <div  class="icheck-primary ml-2">
                                        <input type="checkbox" <?php echo (obtienevalor($arrayAccs, "AL") == "AL") ? "checked": "" ?> value="AL" name="checktipo4" id="checktipo4" class="selectitem">
                                        <label for="checktipo4" class="text">Estudiantes</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>ayuda/tutoriales" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
                            <button type="button" id="vw_pw_bt_ad_btn_guardar" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </div>
    			</form>
    		</div>
    	</div>
    </section>
</div>

<?php
echo
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>";
?>
<script>
	values = [];
	accesos = "";
	$('#vw_pw_bt_ad_btn_guardar').click(function() {
        $('#vw_pw_bt_ad_form_addmanual input,select').removeClass('is-invalid');
        $('#vw_pw_bt_ad_form_addmanual .invalid-feedback').remove();
        $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        
        $("#itemsacc .selectitem").each(function() {
	        if (this.checked) {
	            items = $(this).val();
	            values.push(items)
	        }
	    });

        if ($('#checktipo1').prop('checked')) {

	    } else {
	    	values.push(0);
	    }
	    accesos = $.trim(values.join(","));

	    fdata=$("#vw_pw_bt_ad_form_addmanual").serializeArray();
	    fdata.push({name: 'fictxtaccesos', value: accesos});
	    
        $.ajax({
            url: base_url + "ayuda/fn_insert_update",
            type: 'post',
            dataType: 'json',
            data: fdata,
            success: function(e) {
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    })
                    window.location.href = base_url + "ayuda/tutoriales";
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                Swal.fire({
                    title: "Error!",
                    text: msgf,
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });

    $('.vw_pw_bt_textmanual_summer').summernote({
        height: 70,
        placeholder: $('.vw_pw_bt_textmanual_summer').attr('placeholder'),
        dialogsFade: true,
        lang: 'es-ES',
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            // ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
        ],
        
    });

    
</script>
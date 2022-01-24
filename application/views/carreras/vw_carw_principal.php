
<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

	<section id="s-cargado" class="content pt-2">
		<div id="divcard_carrera" class="card bg-light text-dark">
			<div class="card-header p-2">
                <h1 class="card-title">Programas de Estudio</h1>
            </div>
		    <div class="card-body p-2">
                <div id="divtabl-sede" class="form-neo neo-table">
                            <div class="col-md-12 header d-none d-md-block">
                                <div class="row">
                                    <div class="col-sm-1 col-md-1 cell hidden-xs"><b>CÓDIGO</b></div>
                                    <div class="col-sm-2 col-md-2 cell"><b>CARRERA</b></div>
                                    <div class="col-sm-2 col-md-1 cell"><b>SIGLA</b></div>
                                    <div class="col-sm-2 col-md-2 cell"><b>ABREVIATURA</b></div>
                                    <div class="col-sm-2 col-md-1 cell"><b>ABIERTA</b></div>
                                    <div class="col-sm-2 col-md-2 cell"><b>N. FORMATIVO</b></div>
                                    <div class="col-sm-1 col-md-2 cell text-center"></div>
                                </div>
                            </div>
                            <div class="col-md-12 body">
                            <?php
                                $nro = 0;
                                foreach ($carreras as $carr) {
                                    $nro ++;
                                    if ($carr->abierta == 'SI') {
                                        $abierta = "<span class='badge bg-success p-2'> ACTIVA </span>";
                                    } else {
                                        $abierta = "<span class='badge bg-danger p-2'> INACTIVA </span>";
                                    }
                            ?>
                                <div class="row cfila <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>">
                                    <div class="col-12 col-md-3 group">
                                        <div class="col-4 col-md-4 cell">
                                            <span><?php echo $carr->codcarrera ;?></span>
                                        </div>
                                        <div class="col-8 col-md-8 cell">
                                            <span><?php echo $carr->nombre ;?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 group">
                                        <div class='col-4 col-md-4 cell text-center'>
                                            <?php echo $carr->url ?>
                                        </div>
                                        
                                    </div>
                                    <div class="col-12 col-md-2 group">
                                        <div class='col-6 col-md-6 cell text-center'>
                                            <?php echo $abierta ?>
                                        </div>
            
                                    </div>
                                    <div class="col-12 col-md-2 group">
                                        <div class='col-12 col-md-12 cell'>
                                            <span><?php echo $carr->nivel ;?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 group">
                                        <div class='col-6 col-md-6 cell text-center'>
                                            <a type="button" href='<?php echo "{$vbaseurl}portal-web/programa-estudios/editar/".base64url_encode($carr->codcarweb)."/".base64url_encode($carr->codsede) ?>' class='btn btn-info btn-sm px-3'>
                                                <i class='fas fa-pencil-alt text-white'></i>
                                                <span class="d-block d-md-none text-white">Editar </span>
                                            </a>
                                        </div>
                                        <div class='col-6 col-md-6 cell text-center'>
                                            <button class='btn btn-danger btn-sm  px-3' idcarrera="<?php echo base64url_encode($carr->codcarrera) ?>">
                                                <i class='fas fa-trash-alt'></i>
                                                <span class="d-block d-md-none">Eliminar </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php    
                                }
                            ?>
                            </div>
                        </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script type="text/javascript">
    $('#frm_addcarrera').submit(function() {
        $('#frm_addcarrera input,select').removeClass('is-invalid');
        $('#frm_addcarrera .invalid-feedback').remove();
        $('#divcard_carrera').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $(this).attr("action"),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(e) {
                $('#divcard_carrera #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {

                    var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                    $('#divmsgcarr').html(msgf);
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      if (result.value) {
                        location.reload();
                      }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard_carrera #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });

    function viewupdatcarr(codigo) {
        $('#divcard_carrera').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $("#divrstarea").html("");
        $.ajax({
            url: base_url + "carrera/vwmostrar_carreraxcodigo",
            type: 'post',
            dataType: "json",
            data: {txtcodigo: codigo},
            success: function(e) {
                $('#divcard_carrera #divoverlay').remove();

                $("#modupcarrera").modal("show");
                
                $('#modupcarrera #fictxtcodantig').val(e.carrup['id']);

                $("#modupcarrera #fictxtcodigo").val(e.carrup['id']);

                $("#modupcarrera #fictxtnombre").val(e.carrup['nombre']);

                $("#modupcarrera #fictxtsigla").val(e.carrup['sigla']);

                $("#modupcarrera #fictxtabrev").val(e.carrup['abrev']);

                if (e.carrup['abierta'] == 'SI') {
                    $("#modupcarrera #checkabierta").bootstrapToggle('on');
                    
                } else {
                    $("#modupcarrera #checkabierta").bootstrapToggle('off');
                }

                if (e.carrup['activo'] == 'SI') {
                    $("#modupcarrera #checkestado").bootstrapToggle('on');
                    
                } else {
                    $("#modupcarrera #checkestado").bootstrapToggle('off');
                }

                $('#modupcarrera #fictxtnivelf').val(e.carrup['nivel']);

            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div' );
                $('#divcard_carrera #divoverlay').remove();
                $("#modupcarrera modal-body").html(msgf);
            } 
        });
        return false;
    }

    $('#btn_updcarrera').click(function(event) {
        $('#frm_updacarrera input,select').removeClass('is-invalid');
        $('#frm_updacarrera .invalid-feedback').remove();
        $('#divmodcarrera').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_updacarrera').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_updacarrera').serialize(),
            success: function(e) {
                $('#divmodcarrera #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modupcarrera').modal('hide');
                    var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
                    $('#divmsgcarr').html(msgf);
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    }).then((result) => {
                      if (result.value) {
                        location.reload();
                      }
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodcarrera #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });

   

</script>
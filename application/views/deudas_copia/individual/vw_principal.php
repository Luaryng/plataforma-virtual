<?php
    $vbaseurl=base_url();
    date_default_timezone_set ('America/Lima');
    $f_hoy = date('Y-m-d');
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

    <div class="modal fade" id="modadddeuda" tabindex="-1" role="dialog" aria-labelledby="modadddeuda" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">AGREGAR NUEVO REGISTRO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="divcardform_adddeuda">
                        <form id="frm_addpagante" action="<?php echo $vbaseurl ?>deudas_individual/fn_insert_deuda_individual" method="post" accept-charset="utf-8">
                            <div class="row">
                                <div class="form-group has-float-label col-lg-2 col-md-6 col-sm-6">
                                    <input autocomplete="off" class="form-control form-control-sm" type="text" placeholder="Cod. Pagante" name="ficcodpagante" id="ficcodpagante">
                                    <label for="ficcodpagante">Cod. Pagante</label>
                                </div>
                                <div class="form-group has-float-label col-lg-2 col-md-6 col-sm-6">
                                    <input autocomplete="off" class="form-control form-control-sm" type="text" placeholder="Cod. Matricula" name="ficcodmatricula" id="ficcodmatricula">
                                    <label for="ficcodmatricula">Cod. Matricula</label>
                                </div>
                                <div class="form-group has-float-label col-lg-5 col-md-8 col-sm-8">
                                    <input autocomplete="off" class="form-control form-control-sm" type="text" placeholder="Apellidos y Nombres" name="ficapenomde" id="ficapenomde">
                                    <label for="ficapenomde">Apellidos y Nombres</label>
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-3">
                                    <button type="button" class="btn btn-primary btn-sm" id="btn_show_frm_search">
                                        <i class="fas fa-search"></i> Buscar Pagante
                                    </button>
                                </div>

                                <div class="form-group has-float-label col-lg-4 col-sm-6">
                                    <select class="form-control form-control-sm" id="ficbgestion" name="ficbgestion" >
                                        <option value="">Seleccione item</option>
                                        <?php
                                            foreach ($gestion as $gest) {
                                                echo '<option value="'.$gest->codigo.'">'.$gest->nombre.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="ficbgestion"> Gestión</label>
                                </div>
                                <div class="form-group has-float-label col-lg-4 col-sm-6">
                                    <input autocomplete="off" class="form-control form-control-sm" type="number" placeholder="Monto" name="ficmonto" id="ficmonto" value="">
                                    <label for="ficmonto">Monto</label>
                                </div>
                                <div class="form-group has-float-label col-lg-4 col-sm-6">
                                    <input autocomplete="off" class="form-control form-control-sm" type="date" name="ficfechcreacion" id="ficfechcreacion" value="<?php echo $f_hoy ?>">
                                    <label for="ficfechcreacion">Fecha</label>
                                </div>
                                <div class="form-group has-float-label col-lg-4 col-sm-6">
                                    <input class="form-control form-control-sm" type="date" name="ficfechvence" id="ficfechvence">
                                    <label for="ficfechvence">Fecha vencimiento</label>
                                </div>
                                <div class="form-group has-float-label col-lg-4 col-sm-6">
                                    <input autocomplete="off" class="form-control form-control-sm" type="number" placeholder="Cod.Voucher" name="ficvouchcodigo" id="ficvouchcodigo">
                                    <label for="ficvouchcodigo">Cod.Voucher</label>
                                </div>
                                <div class="form-group has-float-label col-lg-4 col-sm-6">
                                    <input autocomplete="off" class="form-control form-control-sm" type="number" placeholder="Mora" name="ficmora" id="ficmora" value="0.00">
                                    <label for="ficmora">Mora</label>
                                </div>
                                <div class="form-group has-float-label col-lg-4 col-sm-6">
                                    <input class="form-control form-control-sm" type="date" name="ficfechprorrog" id="ficfechprorrog">
                                    <label for="ficfechprorrog">Fecha Prorroga</label>
                                </div>
                                <div class="form-group has-float-label col-lg-4 col-sm-3">
                                    <select name="ficrepitecic" id="ficrepitecic" class="form-control form-control-sm">
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                    <label for="ficrepitecic">Repite ciclo</label>
                                </div>
                                <div class="form-group has-float-label col-lg-4 col-sm-3">
                                    <input autocomplete="off" class="form-control form-control-sm" type="number" name="ficsaldo" id="ficsaldo" placeholder="Saldo" value="0.00">
                                    <label for="ficsaldo">Saldo</label>
                                </div>
                                <div class="form-group has-float-label col-12">
                                    <textarea name="ficobservacion" id="ficobservacion" class="form-control form-control-sm" rows="3" placeholder="Observación"></textarea>
                                    <label for="ficobservacion">Observación</label>
                                </div>
                                
                            </div>
                            
                        </form>
                    </div>

                    <div id="divcardform_search_pagante">
                        <form id="form_search_pagante" action="<?php echo $vbaseurl ?>deudas_individual/fn_filtrar_pagantes" method="post" accept-charset="utf-8">
                            <div class="row">
                                <div class="form-group has-float-label col-lg-3 col-md-4 col-sm-4">
                                    <select name="cboperiodof" id="cboperiodof" class="form-control form-control-sm">
                                        <option value="">Seleecione periodo</option>
                                        <?php
                                            foreach ($periodos as $per) {
                                                echo '<option value="'.$per->codigo.'">'.$per->nombre.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="cboperiodof">Periodo</label>
                                </div>
                                <div class="form-group has-float-label col-lg-6 col-md-4 col-sm-8">
                                    <select name="cboprogramaf" id="cboprogramaf" class="form-control form-control-sm">
                                        <option value="%">Todos</option>
                                        <?php
                                            foreach ($carrera as $carr) {
                                                echo '<option value="'.$carr->id.'">'.$carr->nombre.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="cboprogramaf">Programa de estudios</label>
                                </div>
                                <div class="form-group has-float-label col-lg-3 col-md-4 col-sm-4">
                                    <select name="cboturnof" id="cboturnof" class="form-control form-control-sm">
                                        <option value="%">Todos</option>
                                        <?php
                                            foreach ($turnos as $turn) {
                                                echo '<option value="'.$turn->codigo.'">'.$turn->nombre.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="cboturnof">Turno</label>
                                </div>
                                <div class="form-group has-float-label col-lg-2 col-md-2 col-sm-4">
                                    <select name="cbociclof" id="cbociclof" class="form-control form-control-sm">
                                        <option value="%">Todos</option>
                                        <?php
                                            foreach ($ciclo as $cic) {
                                                echo '<option value="'.$cic->codigo.'">'.$cic->nombre.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="cbociclof">Ciclo</label>
                                </div>
                                <div class="form-group has-float-label col-lg-2 col-md-2 col-sm-4">
                                    <select name="cboseccionf" id="cboseccionf" class="form-control form-control-sm">
                                        <option value="%">Todos</option>
                                        <?php
                                            foreach ($secciones as $sec) {
                                                echo '<option value="'.$sec->codigo.'">'.$sec->nombre.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="cboseccionf">Sección</label>
                                </div>
                                <div class="form-group has-float-label col-9 col-lg-6 col-sm-9">
                                    <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtdniapenomb" name="fitxtdniapenomb" type="text" placeholder="DNI, Apellidos y nombres" />
                                    <label for="fitxtdniapenomb"> DNI, Apellidos y nombres</label>
                                </div>
                                <div class="col-3 col-lg-2 col-sm-3">
                                    <button id="fibtnsearch_dniapenom" type="submit" class="btn btn-primary btn-block btn-sm">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12" id="divcard_tabpagant">
                                <div class="col-12 btable">
                                    <div class="col-md-12 thead d-none d-md-block">
                                        <div class="row">
                                            <div class="col-sm-1 col-md-1 td hidden-xs"><b>N°</b></div>
                                            <div class="col-sm-2 col-md-2 td"><b>DOC. IDENTIDAD</b></div>
                                            <div class="col-sm-2 col-md-7 td"><b>APELLIDOS Y NOMBRES</b></div>
                                            <div class="col-sm-1 col-md-2 td text-center"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 tbody" id="divres_paghistorial">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardar_deuda" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modanuladeuda" tabindex="-1" role="dialog" aria-labelledby="modanuladeuda" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodalanulad">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">ESTÁ SEGURO DE ANULAR DEUDA?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_anuladeuda" action="<?php echo $vbaseurl ?>deudas_individual/fn_anula_deuda_individual" method="post" accept-charset="utf-8">
                        <div class="row">
                            <input type="hidden" name="ficdeudacodigo" id="ficdeudacodigo" value="">
                            <input type="hidden" name="ficdeudaestado" id="ficdeudaestado" value="">
                            
                            <div class="form-group has-float-label col-12">
                                <textarea name="ficmotivanula" id="ficmotivanula" class="form-control form-control-sm" rows="3" placeholder="Motivo Anulación"></textarea>
                                <label for="ficmotivanula">Motivo Anulación</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_anula_deuda" data-coloran="" class="btn btn-primary">Anular</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modPagos_asignar" tabindex="-1" role="dialog" aria-labelledby="modPagos_asignar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modPagos_asignar_content">
                <div class="modal-header">
                    <h5 class="modal-title" >Pagos Realizados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 border rounded p-1 bg-lightgray" >
                        <h4 id="vw_md_pagos_estudiante"></h4>
                    </div>
                    <div class="col-12 border rounded p-1 bg-lightgray" >
                        <h4 id="vw_md_pagos_gestion"></h4>
                    </div>
                    <hr>
                    <input type="text" value="0" id="vw_mdp_txtcoddeuda">
                    <div class="col-12 btable">
                        <div class="col-md-12 thead d-none d-md-block">
                            <div class="row">
                                <div class="col-sm-1 col-md-1 td hidden-xs">N°</div>
                                <div class="col-sm-2 col-md-2 td">PERIODO</div>
                                <div class="col-sm-2 col-md-4 td">CARRERA</div>
                                <div class="col-sm-2 col-md-2 td">CIC./SECCIÓN</div>
                                <div class="col-sm-2 col-md-2 td">TURNO</div>
                                <div class="col-sm-1 col-md-1 td text-center"></div>
                            </div>
                        </div>
                        <div class="col-md-12 tbody" id="div_Pagos_Asignar">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                   
                </div>
            </div>
        </div>
    </div>

    <section id="s-cargado" class="content pt-2">
        <div id="divcard_deudas" class="card text-dark">
            <div class="card-header">
                <h3 class="card-title">Deudas Individual</h3>
                <div class="no-padding card-tools">
                    <a type="button" class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modadddeuda"><i class="fa fa-plus"></i> Agregar</a>
                </div>
            </div>
            <div class="card-body">
                <div id="divcar_form_historial mb-2">
                    <form id="form_search_historial" action="<?php echo $vbaseurl ?>deudas_individual/fn_filtrar_deudas" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-md-2">
                                <select name="cboperiodo" id="cboperiodo" class="form-control">
                                    <option value="%">Todos</option>
                                    <?php
                                        foreach ($periodos as $per) {
                                            echo '<option value="'.$per->codigo.'">'.$per->nombre.'</option>';
                                        }
                                    ?>
                                </select>
                                <label for="cboperiodo">Periodo</label>
                            </div>
                            <div class="form-group has-float-label col-md-3">
                                <select name="cboprograma" id="cboprograma" class="form-control">
                                    <option value="%">Todos</option>
                                    <?php
                                        foreach ($carrera as $carr) {
                                            echo '<option value="'.$carr->id.'">'.$carr->nombre.'</option>';
                                        }
                                    ?>
                                </select>
                                <label for="cboprograma">Programa de estudios</label>
                            </div>
                            <div class="form-group has-float-label col-md-2">
                                <select name="cboturno" id="cboturno" class="form-control">
                                    <option value="%">Todos</option>
                                    <?php
                                        foreach ($turnos as $turn) {
                                            echo '<option value="'.$turn->codigo.'">'.$turn->nombre.'</option>';
                                        }
                                    ?>
                                </select>
                                <label for="cboturno">Turno</label>
                            </div>
                            <div class="form-group has-float-label col-md-2">
                                <select name="cbociclo" id="cbociclo" class="form-control">
                                    <option value="%">Todos</option>
                                    <?php
                                        foreach ($ciclo as $cic) {
                                            echo '<option value="'.$cic->codigo.'">'.$cic->nombre.'</option>';
                                        }
                                    ?>
                                </select>
                                <label for="cbociclo">Ciclo</label>
                            </div>
                            <div class="form-group has-float-label col-md-2">
                                <select name="cboseccion" id="cboseccion" class="form-control">
                                    <option value="%">Todos</option>
                                    <?php
                                        foreach ($secciones as $sec) {
                                            echo '<option value="'.$sec->codigo.'">'.$sec->nombre.'</option>';
                                        }
                                    ?>
                                </select>
                                <label for="cboseccion">Sección</label>
                            </div>
                            <div class="form-group has-float-label col-lg-6 col-md-6 col-sm-8">
                                <input autocomplete="off" class="form-control" type="text" placeholder="Apellidos y nombres" name="txtapenombres" id="txtapenombres">
                                <label for="txtapenombres">Apellidos y nombres</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-12 btable">
                    <div class="col-md-12 thead d-none d-md-block">
                        <div class="row">
                            <div class="col-sm-1 col-md-1 td hidden-xs">COD</div>
                            <div class="col-sm-2 col-md-3 td">DEUDOR</div>
                            <div class="col-sm-2 col-md-3 td">CONCEPTO</div>
                            <div class="col-sm-2 col-md-1 td">SALDO</div>
                            <div class="col-sm-2 col-md-3 td">GRUPO</div>
                            <div class="col-sm-1 col-md-1 td text-center"></div>
                        </div>
                    </div>
                    <div class="col-md-12 tbody" id="divres_historialdeuda">

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#divcardform_search_pagante').hide();
        $('#divcard_tabpagant').hide();
    });

    $('#btn_show_frm_search').click(function() {
        $('#divcardform_adddeuda').hide();
        $('#divcardform_search_pagante').show();
        $('#fitxtdniapenomb').focus();
    });

    $("#modadddeuda").on('hidden.bs.modal', function () {
        $('#divcardform_adddeuda').show();
        $('#divcardform_search_pagante').hide();
        $('#frm_addpagante')[0].reset();
    });

    $('#form_search_pagante').submit(function() {
        $('#divres_paghistorial').html("");
        $('#form_search_pagante input,select').removeClass('is-invalid');
        $('#form_search_pagante .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $(this).attr("action"),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                } else {
                    $('#divres_paghistorial').html("");
                    $('#divcard_tabpagant').show();
                    
                    var nro=0;
                    var tabla="";
                    $.each(e.vdata, function(index, val) {
                        nro++;
                        tabla=tabla + 
                        "<div class='row rowcolor' data-matric='"+val['idmat']+"' data-codpag='"+val['carne']+"' >"+
                            "<div class='col-4 col-md-1 td'>" +
                                  "<span><b>" + nro + "</b></span>" +
                            "</div>" + 
                            "<div class='col-8 col-md-2 td'>" +
                              "<span>" + val['dni'] + "</span>" +
                            "</div> " +
                            "<div class='col-8 col-md-7 td'>" +
                                "<span class='nompagante'>" + val['apepaterno'] + " "+ val['apematerno'] + " " + val['nombre'] + "</span>" +
                            "</div> " +
                            '<div class="col-4 col-md-2 td text-center">' + 
                                '<button class="btn btn-info btn_select_pag"><i class="fas fa-paper-plane"></i></button>'+
                            '</div>' +
                        '</div>';
                    })
                    $('#divres_paghistorial').html(tabla);

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divmodaladd #divoverlay').remove();
                $('#divres_paghistorial').html(msgf);
            }
        });
        return false;
    });


    $(document).on("click", ".btn_select_pag", function() {
        var btn=$(this);
        var div=btn.parents('.rowcolor');
        var codmat = div.data("matric");
        var codpag = div.data("codpag");
        dnompagant=div.find('.nompagante');
        $('#ficcodpagante').val(codpag);
        $('#ficcodmatricula').val(codmat);
        $('#ficapenomde').val(dnompagant.html());
        $('#divcardform_search_pagante').hide();
        // $('#divcard_tabpagant').hide();
        $('#divcardform_adddeuda').show();
        // $('#form_search_pagante')[0].reset();
        
    })

    $('#lbtn_guardar_deuda').click(function() {
        $('#frm_addpagante input,select,textarea').removeClass('is-invalid');
        $('#frm_addpagante .invalid-feedback').remove();
        $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#frm_addpagante').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#frm_addpagante').serialize(),
            success: function(e) {
                $('#divmodaladd #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

                    Swal.fire({
                        title: e.msg,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    // $('#modadddeuda').modal('hide');
                    $('#ficcodpagante').val("");
                    $('#ficcodmatricula').val("");
                    $('#ficapenomde').val("");
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: e.msg,
                        // text: 'Se ha actualizado el estado',
                        backdrop: false,
                    })

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladd #divoverlay').remove();
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

    $('#form_search_historial').submit(function() {
        $('#form_search_historial input,select,textarea').removeClass('is-invalid');
        $('#form_search_historial .invalid-feedback').remove();
        $('#divcard_deudas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#form_search_historial').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#form_search_historial').serialize(),
            success: function(e) {
                $('#divcard_deudas #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

                    Swal.fire({
                        title: e.msg,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                   
                    $('#divres_historialdeuda').html("");
                    var nro=0;
                    var tabla="";
                    var bgcolor = "";
                    
                    var cd1 = "<?php echo base64url_encode("ACTIVO") ?>";
                    var cd2 = "<?php echo base64url_encode("ANULADO") ?>";
                    $.each(e.vdatahst, function(index, val) {
                        var bgsaldo = (val['saldo']>0) ? "text-danger":"";
                        nro++;
                        switch(val['estado']) {
                            case "ACTIVO":
                                bgcolor = "btn-success";
                                break;
                            case "ANULADO":
                                bgcolor = "btn-danger";
                                break;
                            default:
                                bgcolor = "btn-success";
                        }


                        tabla=tabla + 
                        "<div class='row cfila' data-cdeuda='"+ val['codigo64']+ "' data-alumno='"+ val['nombres']+ "' data-codgestion='"+ val['codgestion']+ "' data-gestion='"+ val['gestion']+ "' data-carnet='"+ val['carnet']+ "' >"+
                            "<input type='radio' class='d-none'>" + 
                            "<div class='col-2 col-md-4'>" +
                                "<div class='row'>" +
                                    "<div class='col-2 col-md-1 td text-center'>" +
                                      "<span><b>" + nro+ "</b></span>" +
                                    "</div>" + 
                                    "<div class='col-2 col-md-1 td text-center'>" +
                                      "<span><b>" + val['codigo'] + "</b></span>" +
                                    "</div>" + 
                               
                                    "<div class='col-6 col-md-10 td'>" +
                                        "<span class=''>" + val['carnet'] + " - " + val['nombres'] + "</span>" +
                                    "</div> " +
                                "</div> " +
                            "</div> " +
                            "<div class='col-2 col-md-4'>" +
                                "<div class='row'>" +
                                    "<div class='col-4 col-md-8 td'>" +
                                        "<span class=''>" + val['gestion']  + "</span> " +
                                    "</div> " +
                                    "<div class='col-4 col-md-2 td text-right'>" +
                                        "<span class=''>" + parseFloat(val['monto']).toFixed(2)  + "</span> " +
                                    "</div> " +
                                    "<div class='col-4 col-md-2 td text-right'>" +
                                        "<span class='"+ bgsaldo + "'>" + parseFloat(val['saldo']).toFixed(2) + "</span> " +
                                    "</div> " +
                                "</div> " +
                            "</div> " +
                            "<div class='col-4 col-md-1 td'>" +
                                "<span class=''>" + val['fvence'] + "</span>" +
                            "</div> " +
                            "<div class='col-4 col-md-1 td'>" +
                                '<a href="#" onclick="fn_vw_vincular_pagos($(this));return false;" title="Vincular Pagos" >Pagos</a>' +
                            "</div> " +
                            "<div class='col-4 col-md-1 td'>" +
                                "<span class=''>" + val['codperiodo'] + " " + val['sigla'] + " - " + val['ciclo'] + "</span>" +
                            "</div> " +
                            '<div class="col-4 col-md-1 td text-center">' + 
                                '<div class="btn-group dropleft">'+
                                    '<button class="btn '+bgcolor+' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" '+
                                        'aria-haspopup="true" aria-expanded="false">'+ 
                                        val['estado']+
                                    '</button> '+
                                    '<div class="dropdown-menu">'+
                                        '<a href="#" class="btn-cestado dropdown-item" data-color="btn-success" data-ie="'+cd1+'">ACTIVO</a>'+
                                        '<a href="#" class="dropdown-item" data-color="btn-danger" data-ie="'+cd2+'" data-coddeuda="'+val['codigo64']+'" id="btn_stanul'+val['codigo64']+'" data-toggle="modal" data-target="#modanuladeuda">ANULADO</a>'+
                                        '<div class="dropdown-divider"></div>'+
                                        '<a href="#" data-cdeudad="'+val['codigo64']+'" class="btn-deletedeuda dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>'+
                                    '</div>'+
                                '</div>'+
                            '</div>' +
                        '</div>';
                    })
                    $('#divres_historialdeuda').html(tabla);
                    
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard_deudas #divoverlay').remove();
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
    
    $(document).on("click", ".btn-cestado", function() {

        var iddeuda = $(this).parents(".cfila").data('cdeuda');
        var ie = $(this).data('ie');
        var color = $(this).data('color');

        var btdt = $(this).parents(".btn-group").find('.dropdown-toggle');
        var texto = $(this).html();
        
        $('#divcard_deudas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'deudas_individual/fn_cambiarestado_deuda',
            type: 'post',
            dataType: 'json',
            data: {
                'ce-iddeuda': iddeuda,
                'ce-nestado': ie
            },
            success: function(e) {
                $('#divcard_deudas #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error!',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                    
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones, estado actualizado',
                        text: 'Se ha actualizado el estado',
                        backdrop: false,
                    })

                    btdt.removeClass('btn-danger');
                    btdt.removeClass('btn-success');

                    btdt.addClass(color);
                    btdt.html(texto);
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divcard_deudas #divoverlay').remove();
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Error',
                    text: msgf,
                    backdrop: false,
                })
            }
        });
        return false;
    });

    $("#modanuladeuda").on('show.bs.modal', function (e) {
        var rel=$(e.relatedTarget);
        var coddeuda = rel.data('coddeuda');
        var estado = rel.data('ie');
        var color = rel.data('color');
        
        $('#ficdeudacodigo').val(coddeuda);
        $('#ficdeudaestado').val(estado);
        $('#lbtn_anula_deuda').data('coloran', color);
    });

    $('#lbtn_anula_deuda').click(function() {
        var color = $(this).data('coloran');
        alert("Mensaje");
        $('#form_anuladeuda input,select,textarea').removeClass('is-invalid');
        $('#form_anuladeuda .invalid-feedback').remove();
        $('#divmodalanulad').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#form_anuladeuda').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#form_anuladeuda').serialize(),
            success: function(e) {
                $('#divmodalanulad #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

                    Swal.fire({
                        title: e.msg,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    $('#modanuladeuda').modal('hide');
                    var btdtan = $('#btn_stanul'+e.iddeuda).parents(".btn-group").find('.dropdown-toggle');
                    var textoan = $('#btn_stanul'+e.iddeuda).html();

                    btdtan.removeClass('btn-danger');
                    btdtan.removeClass('btn-success');

                    btdtan.addClass(color);
                    btdtan.html(textoan);
                    
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones, deuda anulada',
                        text: 'Se ha anulado la deuda',
                        backdrop: false,
                    })
                    
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodalanulad #divoverlay').remove();
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

    $(document).on("click", ".btn-deletedeuda", function(event) {

        event.preventDefault();
        $('#divcard_deudas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var cdeuda = $(this).data("cdeudad");
        var fila=$(this).parents(".cfila");
        // var carne=fila.find('.cell-carne').html();
        //************************************
        Swal.fire({
          title: "Precaución",
          text: "Se eliminarán todos los datos con respecto a este DEUDA ",
          type: 'warning',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.value) {
                  //var codc=$(this).data('im');
                $.ajax({
                  url: base_url + 'deudas_individual/fn_eliminar',
                  type: 'post',
                  dataType: 'json',
                  data: {
                          'id-deuda': cdeuda
                      },
                  success: function(e) {
                      $('#divcard_deudas #divoverlay').remove();
                      if (e.status == false) {
                          Swal.fire({
                              type: 'error',
                              icon: 'error',
                              title: 'Error!',
                              text: e.msg,
                              backdrop: false,
                          })
                      } else {
                          
                          Swal.fire({
                              type: 'success',
                              icon: 'success',
                              title: 'Eliminación correcta',
                              text: 'Se ha eliminado la deuda',
                              backdrop: false,
                          })
                          
                          fila.remove();
                      }
                  },
                  error: function(jqXHR, exception) {
                      var msgf = errorAjax(jqXHR, exception, 'text');
                      $('#divcard_deudas #divoverlay').remove();
                      Swal.fire({
                          type: 'error',
                          icon: 'error',
                          title: 'Error',
                          text: msgf,
                          backdrop: false,
                      })
                  }
                });
            }
            else{
                $('#divcard_deudas #divoverlay').remove();
            }
        });
        return false;
                //***************************************
    });

function fn_vw_vincular_pagos(btn){

    $("#modPagos_asignar").modal('show');
    $("#divres_historialdeuda .cfila").removeClass("btn-warning");
    $('#modPagos_asignar .modPagos_asignar_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    //vw_md_pagos_estudiante
    fila=btn.closest(".cfila");
    fila.addClass("btn-warning");

    var cgestion=fila.data('codgestion');
    var gestion=fila.data('gestion');
    var carnet=fila.data('carnet');
    var cdeuda=fila.data('cdeuda');
    var alumno=fila.data('alumno');

    $("#vw_mdp_txtcoddeuda").val(cdeuda);
    $("#vw_md_pagos_estudiante").html("(" + carnet + ") " + alumno);
    $("#vw_md_pagos_gestion ").html("(" + cgestion + ") " + gestion);
    
    $.ajax({
        url: base_url + "facturacion_reportes/fn_emitidositems_x_pagante" ,
        type: 'post',
        dataType: 'json',
        data: {codpagante:carnet,
                codgestion:cgestion},
        success: function(e) {
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {

                var nro=0;
                var tabla="";
                var boton="";
                $.each(e.vdata, function(index, v) {
                        nro++;
                        if (v['coddeuda']==0){
                            boton="<a href='#' onclick='fn_vw_vincular_pago($(this));return false;' class='badge badge-primary'>Vincular</a>";
                        }
                        else{
                            boton="<a href='#' onclick='fn_vw_desvincular_pago($(this));return false;' class='badge badge-secondary'>Desvincular</a>";
                        }
                        monto=Number.parseFloat(v['monto']).toFixed(2);
                        tabla = tabla + 
                            "<div class='row rowcolor' data-coddetalle='" + v['coddetalle64'] + "'>" + 

                                "<div class='col-6 col-md-4 text-right'>" +
                                    "<div class='row'>" + 
                                        "<div class='col-4 col-md-2 td'><span><b>" + nro + "</b></span></div>" +
                                        "<div class='col-8 col-md-4 td'><span>" + v['serie'] + "-" + v['numero']  + "</span>" +
                                        "</div>" +
                                         "<div class='col-8 col-md-6 td'><span>" + v['fecha_hora'] + "</span>" +
                                        "</div>" +
                                    "</div>"+
                                "</div>"+
                                "<div class='col-4 col-md-4 td'><span>" + v['gestion'] + "</span></div>" +
                                "<div class='col-6 col-md-4 text-right'>" +
                                    "<div class='row'>" + 
                                        "<div class='col-6 col-md-4 td text-right'><span>" + monto+ "</span></div>" +
                                        "<div class='col-6 col-md-4 td'><span class='vw_mdp_spcoddeuda'>" + v['coddeuda'] + "</span></div>" +
                                        "<div class='col-6 col-md-4 td text-right'>" +
                                            boton+ 
                                        "</div>" +
                                    "</div>" +
                                "</div>" +
                            "</div>";
                });
                $("#div_Pagos_Asignar").html(tabla);



            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
    

}

function fn_vw_vincular_pago(btn){
    $("#modPagos_asignar").modal('show');
    $('#modPagos_asignar .modPagos_asignar_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    //vw_md_pagos_estudiante
    fila=btn.closest(".rowcolor");
    var cdetalle=fila.data('coddetalle');
    var cdeuda=$("#vw_mdp_txtcoddeuda").val();
    
    $.ajax({
        url: base_url + "deudas_individual/fn_vincular_deuda_con_pago" ,
        type: 'post',
        dataType: 'json',
        data: {coddetalle:cdetalle,
                coddeuda:cdeuda},
        success: function(e) {
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "Ocurrio un error",
                    text: e.msg,
                    type: 'error',
                    icon: 'error',
                })
            } 
            else {
                fila.find(".vw_mdp_spcoddeuda").html(e.coddeuda);
                //$('#form_search_historial').submit();

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
}

function fn_vw_desvincular_pago(btn){
    $("#modPagos_asignar").modal('show');
    $('#modPagos_asignar .modPagos_asignar_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    //vw_md_pagos_estudiante
    fila=btn.closest(".rowcolor");
    var cdetalle=fila.data('coddetalle');
    var cdeuda=$("#vw_mdp_txtcoddeuda").val();
    
    $.ajax({
        url: base_url + "deudas_individual/fn_desvincular_deuda_con_pago" ,
        type: 'post',
        dataType: 'json',
        data: {coddetalle:cdetalle,
                coddeuda:cdeuda},
        success: function(e) {
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "Ocurrio un error",
                    text: e.msg,
                    type: 'error',
                    icon: 'error',
                })
            } 
            else {
                fila.find(".vw_mdp_spcoddeuda").html(0);
                //$('#form_search_historial').submit();

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
}



</script>
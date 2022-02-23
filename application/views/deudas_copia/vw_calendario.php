<?php
$vbaseurl=base_url();
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

<!--<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">-->

<div class="content-wrapper">
    <div class="modal fade" id="modMantCalendario" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cronograma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card" id="div_frmcalendario">
                        <div class="card-body">
                            <form id="vw_dci_frmcalendario" accept-charset="utf-8">
                                <div class="row">
                                    <input type="hidden" id="vw_dci_txtcodigo" name="vw_dci_txtcodigo" value="0">
                                    <div class="form-group has-float-label col-6  col-md-12">
                                        <select name="vw_dci_cbperiodo" id="vw_dci_cbperiodo" class="form-control inputsb">
                                            <option value="0">Selecciona periodo</option>
                                            <?php foreach ($periodos as $periodo) {
                                            echo "<option  value='$periodo->codigo'>$periodo->nombre </option>";
                                            } ?>
                                        </select>
                                        <label for="vw_dci_cbperiodo">Periodo</label>
                                    </div>
                                    <div class="form-group has-float-label col-6  col-md-12">
                                        <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtnombre" name="vw_dci_txtnombre" type="text" placeholder="Nombre"  minlength="8" />
                                        <label for="vw_dci_txtnombre">Nombre</label>
                                    </div>
                                    <div class="form-group has-float-label col-6  col-md-6">
                                        <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtinicia" name="vw_dci_txtinicia" type="date" placeholder="Inicia"  minlength="8" />
                                        <label for="vw_dci_txtinicia">Inicia</label>
                                    </div>
                                    <div class="form-group has-float-label col-6  col-md-6">
                                        <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtculmina" name="vw_dci_txtculmina" type="date" placeholder="Culmina"  minlength="8" />
                                        <label for="vw_dci_txtculmina">Culmina</label>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="vw_dci_btnguardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modCronogramas" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Calendario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                   <div class="card" id="div_cronogramas">
                        <br>
                        <br><br>
                        <br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modGrupos" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Grupos Académicos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                   <div class="card" id="div_Grupos">
                        <br>
                        <br><br>
                        <br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                   
                </div>
            </div>
        </div>
    </div>

    

    <div class="modal fade" id="modGrupos_deudas" tabindex="-1" role="dialog" aria-labelledby="modGrupos_deudas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content modGrupos_deudas_content">
                <div class="modal-header">
                    <h5 class="modal-title" >Grupos Académicos Asignar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                        <div class="col-md-12 tbody" id="div_GruposDeudas">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modDeudas" tabindex="-1" role="dialog" aria-labelledby="modDeudas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content" id="modDeudas_content">
                <div class="modal-header">
                    <h5 class="modal-title" >Generar Deudas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div class="col-12 btable" >
                        <div class="col-md-12 thead d-none d-md-block">
                            <div class="row" id="vw_mdd_estudiantes_head">
                                
                                
                            </div>
                        </div>
                        <div class="col-md-12 tbody" id="vw_mdd_estudiantes">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="vw_mdd_btnguardar" class="btn btn-primary">Guardar</button>
                   
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modPlanEconomico" tabindex="-1" role="dialog" aria-labelledby="modPlanEconomico" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content" id="modPlanEconomico_content">
                <div class="modal-header">
                    <h5 class="modal-title" >Plan Ecónomico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="vw_mdpe_codmat">
                        <div class="form-group has-float-label col-12">
                            <select name="vw_mdpe_cbbeneficio" id="vw_mdpe_cbbeneficio" class="form-control form-control-sm">
                                <option value="0">Seleccionar</option>
                                <?php foreach ($beneficios as $bene) {
                                echo "<option data-sigla='$bene->sigla'  value='$bene->id'>$bene->nombre </option>";
                                } ?>
                            </select>
                             <label for="vw_mdpe_cbbeneficio">Beneficio</label>
                        </div>
                        <div class="form-group has-float-label col-12">
                            <input type="text" class="form-control form-control-sm" name="vw_mdpe_monto" id="vw_mdpe_monto">
                            <label for="vw_mdpe_monto">Monto</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="vw_mdpe_btnguardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <section id="s-cargado" class="content pt-3">
        <div id="vw_dc_divCalpanel" class="card">
            <div class="card-header">
                <h1 class="card-title text-bold">Calendario de Pagos (Cronograma)</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group has-float-label col-10 col-sm-10  col-md-3">
                        <select name="vw_dc_cbsede" id="vw_dc_cbsede" class="form-control form-control-sm">
                            
                            <?php 
                            $codsede=$_SESSION['userActivo']->idsede;
                            foreach ($sedes as $sede) {
                                $selsede=($codsede==$sede->id)?"selected":"";
                                echo "<option $selsede value='$sede->id'>$sede->nombre </option>";
                            } ?>
                        </select>
                         <label for="vw_dc_cbsede">Filial</label>
                    </div>
                    <div class="form-group has-float-label col-10 col-sm-10  col-md-3">
                        <select name="vw_dc_cbperiodo" id="vw_dc_cbperiodo" class="form-control form-control-sm">
                            <option value="0">Selecciona periodo</option>
                            <?php foreach ($periodos as $periodo) {
                            echo "<option  value='$periodo->codigo'>$periodo->nombre </option>";
                            } ?>
                        </select>
                         <label for="vw_dc_cbperiodo">Periodo</label>
                    </div>
                    
                    
                    <div class="col-2 col-sm-2 col-md-1">
                        <button id="vw_dc_btnbuscar" type="button" class="btn btn-block btn-sm btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="col-12 col-md-5 text-right">
                        <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modMantCalendario">
                            <i class="fas fa-plus mr-1"></i>  Crear
                        </a>
                    </div>
                </div>
                <div class="col-12 btable">
            
                    <div class="col-md-12 thead d-none d-md-block">
                        <div class="row">
                            <div class="col-12 col-md-2">
                                <div class="row">
                                    <div class="col-2 td">
                                        N°
                                    </div>
                                    <div class="col-5 td">
                                        FILIAL
                                    </div>
                                    <div class="col-5 td">
                                        PERIODO
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 col-md-5 td">CRONOGRAMA</div>
                            <div class="col-2 col-md-1 td">INICIA</div>
                            <div class="col-2 col-md-1 td">CULMINA</div>
                            <div class="col-1 col-md-1 td text-center"></div>
                        </div>
                    </div>
                    <div class="col-md-12 tbody" id="vw_dc_divcalendarios">
                        <br>
                        <br><br>
                        <br>
                    </div>
                </div>
                   
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!--<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">

$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});
$('#vw_dci_btnguardar').click(function(event) {
    $('#div_frmcalendario input,select').removeClass('is-invalid');
    $('#div_frmcalendario .invalid-feedback').remove();
    $('#div_frmcalendario').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    
    $.ajax({
        url: base_url + "deudas_calendario/fn_guardar" ,
        type: 'post',
        dataType: 'json',
        data: $('#vw_dci_frmcalendario').serialize(),
        success: function(e) {
            $('#div_frmcalendario #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $('#modMantCalendario').modal('hide');
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_frmcalendario #divoverlay').remove();
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

$('#modCronogramas').on('shown.bs.modal', function (e) {
  
    $('#div_cronogramas input,select').removeClass('is-invalid');
    $('#div_cronogramas .invalid-feedback').remove();
    $('#div_cronogramas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var btn=$(e.relatedTarget); 
    var calendario=btn.closest('.rowcolor').data('calendario');
     $.ajax({
        url: base_url + "deudas_calendario_fechas/vw_modal_fechas" ,
        type: 'post',
        dataType: 'json',
        data: {vw_dcmd_calendario:calendario},
        success: function(e) {
            $('#div_cronogramas #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $('#div_cronogramas').html(e.vdata);
                $("#div_cronogramas #vw_cmd_crono_view #vw_cmd_crono_btnasignar").data('calendario',calendario);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_cronogramas #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
})

$('#modGrupos').on('shown.bs.modal', function (e) {
  
    $('#div_Grupos input,select').removeClass('is-invalid');
    $('#div_Grupos .invalid-feedback').remove();
    $('#div_Grupos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var btn=$(e.relatedTarget); 
    var grupo=btn.closest('.rowcolor').data('calendario');
    
    $.ajax({
        url: base_url + "deudas_grupo/vw_modal_grupos" ,
        type: 'post',
        dataType: 'json',
        data: {vw_dcmd_grupo:grupo},
        success: function(e) {
            $('#div_Grupos #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $('#div_Grupos').html(e.vdata);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_Grupos #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
})


$('#vw_dc_btnbuscar').click(function(event) {
    
    var periodo=$('#vw_dc_cbperiodo').val();
    var sede=$('#vw_dc_cbsede').val();
    
    $('#vw_dc_divCalpanel input,select').removeClass('is-invalid');
    $('#vw_dc_divCalpanel .invalid-feedback').remove();
    if (periodo=="0"){
        $("#vw_dc_divcalendarios").html("");
        $('#vw_dc_cbperiodo').addClass('is-invalid');
        $('#vw_dc_cbperiodo').parent().append("<div class='invalid-feedback'>Periodo Requerido</div>");
        return;
    }

    $('#vw_dc_divCalpanel').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "deudas_calendario/fn_get_calendarios_xperiodo" ,
        type: 'post',
        dataType: 'json',
        data: {"vw_dc_cbperiodo":periodo,
                "vw_dc_cbsede":sede},
        success: function(e) {
            $('#vw_dc_divCalpanel #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $("#vw_dc_divcalendarios").html("");
                $('#modMantCalendario').modal('hide');
                var nro=0;
                var tabla="";                
                $.each(e.vdata, function(index, val) {
                    nro++;
                    btnFechas='<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modCronogramas"><i class="far fa-calendar-alt"></i> Fechas</a>';
                    btnGrupos='<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modGrupos"><i class="fas fa-user-friends"></i> Grupos</a>';
                    tabla=tabla + 
                    "<div class='row rowcolor' data-calendario='"+ val['codigo64'] + "'>"+
                        "<div class='col-4 col-md-2'>" +
                            "<div class='row'>" +
                                "<div class='col-4 col-md-2 td'>" +
                                    "<span>" + nro + "</span>" +
                                "</div>" + 
                                "<div class='col-4 col-md-5 td'>" +
                                    "<span><b>" + val['sede'] + "</b></span>" +
                                "</div>" + 
                                "<div class='col-4 col-md-5 td'>" +
                                    "<span>" + val['periodo'] + "</span>" +
                                "</div>" + 
                            "</div>" + 
                        "</div>" + 
                        "<div class='col-8 col-md-4 td'>" +
                        "<span data-toggle='tooltip' title='" + val['codigo'] +  "'>" + val['nombre'] + "</span>" +
                        "</div> " +
                        "<div class='col-12 col-md-2 td'>" +
                          "<span>" + val['inicia'] + "</span>" +
                        "</div> " + 
                        "<div class='col-6 col-md-2 td'>" +
                          "<span>" + val['culmina'] + "</span>" +
                        "</div> " +
                        '<div class="col-4 col-md-1 td text-right">' + 
                            '<div class="btn-group btn-group-sm p-0 " role="group">' + 
                                '<button class="bg-primary text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                  'Opciones' +
                                '</button>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                      btnGrupos +  
                                      btnFechas +
                                      
                                      '<div class="dropdown-divider"></div>' + 
                                      
                                ' </div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
                });
                $("#vw_dc_divcalendarios").html(tabla);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_dc_divCalpanel #divoverlay').remove();
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

function fn_vw_add_fecha(btn){
    
    $("#div_cronogramas #vw_cmd_crono_add").show();
    $("#div_cronogramas #vw_cmd_crono_view").hide();
}

//var items_cobro;
function fn_vw_view_fecha(btn){

    if(btn.is(':checked')) {
        $('#div_cronogramas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        //items_cobro;
        $('#nav-fechas-tab').tab('show')

        
        $("#div_cronogramas #vw_cmdv_spnfecha").html(btn.data('fecha'));
        $("#div_cronogramas #vw_cmdv_spndescripcion").html(btn.data('descripcion'));
         $("#div_cronogramas #vw_cmd_crono_add").hide();
        $("#div_cronogramas #vw_cmd_crono_view").show();

        
        $("#div_cronogramas #vw_cmd_crono_view #vw_cmdv_item_agregar #vw_cmdi_txtcalfecha").val(btn.val())
        var vidcalendario=$("#vw_cmda_txtcalendario").val();
        $.ajax({
            url: base_url + "Deudas_calendario_fechas_item/fn_get_itemscobro_x_fecha" ,
            type: 'post',
            dataType: 'json',
            data: {vw_cmdi_txtcalfecha64:btn.val(),vw_cmdi_txtcal64: vidcalendario},
            success: function(e) {
                $('#div_cronogramas #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                } else {
                    //PESTAÑA CONCEPTOS
                    items_cobro=e.vdata;
                    var nro=0;
                    var tabla="";
                    $.each(e.vdata, function(index, v) {
                        nro++;
                        tabla = tabla +
                            '<div class="row cfila rowcolor ">' +
                                '<div class="col-md-1 td">' + nro + '</div>' +
                                '<div class="col-md-7 td">' + v['gestion'] + '</div>' +
                                '<div class="col-md-2 td">' + v['monto'] + '</div>' +
                                '<div class="col-md-1 td">' + v['repite'] + '</div>' +
                                '<div class="col-md-1 td"></div>' +
                            '</div>';
                    });
                    $("#vw_cmdv_items").html(tabla);
                    //PESTAÑA GRUPOS
                    nro=0;
                    tabla="";
                    $.each(e.vgrupos, function(index, v) {
                        nro++;
                        tabla = tabla + 
                            "<div class='row rowcolor' data-codperiodo='" + v['periodo'] + 
                                "' data-codcarrera='" + v['carrera'] + "' data-codciclo='" + v['ciclo'] + 
                                "' data-codturno='" + v['turno'] + "' data-codseccion='" + v['seccion'] + "'>" + 
                                "<div class='col-4 col-md-2'>" +
                                    "<div class='row'>" +
                                        "<div class='col-8 col-md-4 td'><span>" + nro + "</span></div>" +
                                        "<div class='col-8 col-md-8 td'><span>" + v['nomperiodo'] + "</span></div>" +
                                    "</div>" +
                                "</div>" +
                                "<div class='col-8 col-md-4 td'><span>" + v['nomcarrera'] + "</span></div>" +
                                "<div class='col-4 col-md-2 td'><span>" + v['nomturno']  + " " + v['nomciclo'] + " - " + v['nomseccion'] + "</span></div>" +
                                "<div class='col-6 col-md-2 td'><span>" + v['generadas'] + "/" + v['matriculas'] + "</span></div>" +
                                "<div class='col-6 col-md-1 td text-right'>" +
                                    "<a href='#' onclick='fn_vw_view_deudas($(this));return false;' class='btn btn-primary btn-sm vw_gc_btndeudas'>Deudas</a>" + 
                                "</div>" +
                            "</div>";
                    });
                    $("#div_fechas_GruposDeudas").html(tabla);
        
                        
                        
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#div_cronogramas #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
    }
    return false;
    
}

function fn_vw_save_fecha(btn){
    $('#div_cronogramas input,select').removeClass('is-invalid');
    $('#div_cronogramas .invalid-feedback').remove();
    $('#div_cronogramas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    
    $.ajax({
        url: base_url + "deudas_calendario_fechas/fn_guardar" ,
        type: 'post',
        dataType: 'json',
        data: $('#div_cronogramas #vw_cmda_frmcalendario').serialize(),
        success: function(e) {
            $('#div_cronogramas #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $("#div_cronogramas #vw_cmd_crono_add").hide();
                $("#div_cronogramas #vw_cmd_crono_view").hide();

                $("#vw_cmd_cronograma_rdfechas").html("");
                var rdtext="";
                $.each(e.fechas, function(index, fc) {
                    rdtext=rdtext + "<div class='form-check'>" + 
                                        "<input onchange='fn_vw_view_fecha($(this));' class='form-check-input vw_rbfecha_cobro'" + 
                                        " data-descripcion='" + fc['descripcion'] + "' data-fecha='" + fc['fecha'] + "' type='radio'" + 
                                        " name='rbfechas' id='rbfecha" + fc['codigo'] + "' value='" + fc['codigo64'] + "' > " +
                                        "<label class='form-check-label' for='rbfecha" + fc['codigo'] + "'> " + 
                                            "<small>" + fc['descripcion'] + " (" + fc['fecha'] + ")</small>" + 
                                        "</label>" + 
                                    "</div>"
                });
                $("#vw_cmd_cronograma_rdfechas").html(rdtext);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_cronogramas #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;


}

function fn_vw_add_itemfac(btn){
    $("#vw_cmdv_item_agregar").show();
    $("#vw_cmdv_item").hide();

}

function fn_vw_save_itemfac(){
    var vw_cmdi_cbgestion=$("#vw_cmdi_cbgestion").val();
    var vw_cmdi_txtcodigo=$("#vw_cmdi_txtcodigo").val();
    var vw_cmdi_chkrepite=($("#vw_cmdi_chkrepite").prop('checked')==true) ? "SI": "NO";
    var vw_cmdi_txtcalfecha=$("#vw_cmdi_txtcalfecha").val();
    var vw_cmdi_txtmonto=$("#vw_cmdi_txtmonto").val();

    
    $.ajax({
        url: base_url + "deudas_calendario_fechas_item/fn_insert_update" ,
        type: 'post',
        dataType: 'json',
        //data: $('#div_cronogramas #vw_cmda_frmcalendario').serialize(),
        data: {
            fictxtcodigo:vw_cmdi_txtcodigo,
            fictxtcal_fecha:vw_cmdi_txtcalfecha,
            fictxtcodgestion:vw_cmdi_cbgestion,
            fictxt_repite:vw_cmdi_chkrepite,
            fictxt_monto:vw_cmdi_txtmonto
        },
        success: function(e) {
            $('#div_cronogramas #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                
                $(".vw_rbfecha_cobro").change();
                $("#vw_cmdv_item_agregar").hide();
                $("#vw_cmdv_item").show();

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_cronogramas #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
}

function fn_vw_view_deudas(btn){
    $("#modDeudas").modal('show');

    $('#modDeudas_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var fila=btn.closest('.rowcolor');
    //var grupo=btn.closest('.rowcolor').data('calendario');
    var codperiodo=fila.data('codperiodo');
    var codcarrera=fila.data('codcarrera');
    var codciclo=fila.data('codciclo');
    var codturno=fila.data('codturno');
    var codseccion=fila.data('codseccion');
    var vw_cmdi_txtcalfecha=$("#vw_cmdi_txtcalfecha").val();

    $.ajax({
        url: base_url + "deudas_grupo/fn_matriculados_x_grupo" ,
        type: 'post',
        dataType: 'json',
        data: {
            txtcodperiodo:codperiodo,
            txtcodcarrera:codcarrera,
            txtcodciclo:codciclo,
            txtcodturno:codturno,
            txtcodseccion:codseccion,
            txtcalfecha:vw_cmdi_txtcalfecha
        },
        success: function(e) {
            $('#modDeudas_content #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                var nro=0;
                var tabla="";
                var cuota=0;
                var inputhead="";
                $.each(e.items, function(index2, it) {
                        
                        inputhead = inputhead +
                            
                                '<div class="col-md-2 text-center">' + 
                                    it['gestion'] + 
                                '</div>' ;
                               
                });

                
                thead=  '<div class="col-md-5">' + 
                            '<div class="row">' + 
                                '<div class="col-md-1 td">N°</div>' +
                                '<div class="col-md-7 td">ESTUDIANTE</div>' +
                                '<div class="col-md-4 td">PLAN ECON. / CUOTA</div>' +
                                
                            '</div>' +
                        '</div>' +

                        '<div class="col-md-7">' + 
                            '<div class="row">' + 
                               inputhead + 
                            '</div>' +
                        '</div>';
                var coddeuda_negativo=0;
                $.each(e.vdata, function(index, v) {
                    nro++;
                    cuota=Number.parseFloat(v['cuota']).toFixed(2);

                    inputtext="";
                    $.each(e.items, function(index2, it) {
                            itmat=v['items'][it['codigo']];
                            monto=itmat['monto'];
                            deuda=itmat['deuda'];
                            if (deuda['codigo']<0) {
                                edit="1";
                            }
                            else{
                                edit="0";
                            }
                            inputtext = inputtext +
                                
                                    '<div class="col-md-2">' + 
                                        '<input type="number" step="0.01" class="form-control form-control-sm" data-edit="' + edit + '" data-codgestion="' + deuda['codgestion'] + '" data-saldo="' + deuda['saldo'] + '" data-itemcobro="' + it['codigo'] + '" data-coddeuda="' + deuda['codigo'] + '" value="' + monto + '" >' + 
                                    '</div>' ;
                                   
                    });

                    tabla = tabla +
                        '<div class="row cfila rowcolor"   data-codbeneficio="' + v['codbeneficio'] + '"  data-carnet="' + v['carne'] + '"  data-codmat="' + v['codigo64'] + '">' +
                            '<div class="col-md-5">' + 
                                '<div class="row">' + 
                                    '<div class="col-md-1 td">' + nro + '</div>' +
                                    '<div class="col-md-7 td">' + v['paterno']  + ' ' + v['materno']  + ' ' + v['nombres'] + '</div>' +
                                    '<div class="col-md-2 td"><a class="vw_lm_lbplan" onclick="fn_vw_change_plan_eco($(this));return false;" title="Plan Económico" href="#">' + v['bene_sigla'] + '</a></div>' +
                                    '<div class="col-md-2 td"><a class="vw_lm_lbplancuota" onclick="fn_vw_change_plan_eco($(this));return false;" title="Plan Económico" href="#">' + cuota + '</a></div>' +
                                '</div>' +
                            '</div>' +

                            '<div class="col-md-7">' + 
                                '<div class="row">' + 
                                    inputtext + 
                                '</div>' +
                            '</div>' +

                            
                            
                        '</div>';
                });
                $("#vw_mdd_estudiantes_head").html(thead);
                $("#vw_mdd_estudiantes").html(tabla);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modDeudas_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });

}

function fn_vw_deuda_asignar_grupo(btn){
    $("#modGrupos_deudas").modal('show');
    $('#modGrupos_deudas .modGrupos_deudas_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var grupo=btn.data('calendario');
    
    var calfecha=$("#vw_cmdi_txtcalfecha").val();
    
    
    $.ajax({
        url: base_url + "deudas_grupo/fn_grupos" ,
        type: 'post',
        dataType: 'json',
        data: {vw_dcmd_grupo:grupo,
                vw_dcmd_calfecha:calfecha},
        success: function(e) {
            $('#modGrupos_deudas .modGrupos_deudas_content #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {

                var nro=0;
                var tabla="";
                $.each(e.vdata, function(index, v) {
                        nro++;

                        tabla = tabla + 
                            "<div class='row rowcolor' data-codperiodo='" + v['periodo'] + "' data-codcarrera='" + v['carrera'] + "' data-codciclo='" + v['ciclo'] + "' data-codturno='" + v['turno'] + "' data-codseccion='" + v['seccion'] + "'>" + 
                                "<div class='col-4 col-md-1 td'><span><b>" + nro + "</b></span></div>" +
                                "<div class='col-8 col-md-2 td'><span>" + v['nomperiodo'] + "</span></div>" +
                                "<div class='col-8 col-md-4 td'><span>" + v['nomcarrera'] + "</span></div>" +
                                "<div class='col-4 col-md-2 td'><span>" + v['nomturno']  + " " + v['nomciclo'] + " - " + v['nomseccion'] + "</span></div>" +
                                "<div class='col-6 col-md-2 td'><span>" + v['generadas'] + "/" + v['matriculas'] + "</span></div>" +
                                "<div class='col-6 col-md-1 td text-right'>" +
                                    "<a href='#' onclick='fn_vw_view_deudas($(this));return false;' class='btn btn-primary btn-sm vw_gc_btndeudas'>Deudas</a>" + 
                                "</div>" +
                            "</div>";
                });
                $("#div_GruposDeudas").html(tabla);



            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modGrupos_deudas .modGrupos_deudas_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
    
    

}

var vw_lm_filaplan;
function fn_vw_change_plan_eco(btn){
    vw_lm_filaplan=btn.closest(".rowcolor");

    btn_cuota=vw_lm_filaplan.find(".vw_lm_lbplancuota");
    btn_plan=vw_lm_filaplan.find(".vw_lm_lbplan");
    codmat=vw_lm_filaplan.data("codmat");
    codbene=vw_lm_filaplan.data("codbeneficio");

    cuota=btn_cuota.html();

    $("#vw_mdpe_cbbeneficio").val(codbene);
    $("#vw_mdpe_monto").val(cuota);
    $("#vw_mdpe_codmat").val(codmat);
    $("#modPlanEconomico").modal("show");


}

$('#modPlanEconomico').on('hidden.bs.modal', function (e) {
  vw_lm_filaplan=null;
})

$("#vw_mdpe_btnguardar").click(function(event) {

     $('#modPlanEconomico .modPlanEconomico_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    vcodigo64=$("#vw_mdpe_codmat").val();
    vcodbeneficio=$("#vw_mdpe_cbbeneficio").val();
    vbeneficio=$("#vw_mdpe_cbbeneficio").find(':selected').data('sigla');
    vmonto=$("#vw_mdpe_monto").val();
    $.ajax({
        url: base_url + "matricula/fn_cambiar_plan_economico" ,
        type: 'post',
        dataType: 'json',
        data: {
            vw_mdpe_codmat:vcodigo64,
            vw_mdpe_cbbeneficio:vcodbeneficio,
            vw_mdpe_monto:vmonto
        },
        success: function(e) {
            $('#modPlanEconomico .modPlanEconomico_content #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {

                btn_cuota=vw_lm_filaplan.find(".vw_lm_lbplancuota");
                btn_plan=vw_lm_filaplan.find(".vw_lm_lbplan");
                vw_lm_filaplan.data("codbeneficio",vcodbeneficio);

                cuota=Number.parseFloat($("#vw_mdpe_monto").val()).toFixed(2);
                btn_plan.html(vbeneficio);
                btn_cuota.html(cuota);

               
                
                $("#modPlanEconomico").modal("hide");


            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modGrupos_deudas .modGrupos_deudas_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
});

$("#vw_mdd_btnguardar").click(function(event) {
    event.preventDefault();
    $('#modDeudas_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    var vw_cmdi_txtcalfecha=$("#vw_cmdi_txtcalfecha").val();


    array_deudas = [];
    var nerror=0;
    var edits=0;
    
    var rc=0;
    $('#vw_mdd_estudiantes input').each(function() {
        rc++;
        fila=$(this).closest('.cfila');


        var isedit = $(this).data("edit");
        var carnet = fila.data("carnet");
        var codmat = fila.data("codmat");
        var codgestion = $(this).data("codgestion");
        var monto = $(this).val();
        var coddeuda = $(this).data("coddeuda");
        var saldo = $(this).data("saldo");
        var itemcobro=$(this).data("itemcobro");
        
        if (isedit == "1") {
        /*if (($(this).val() < 0)||($(this).val() > 20)) {
            nerror++    
        }
        else{*/
            //$pagante, $matricula, $gestion, $monto, $fcreacion, $fvence, $vouchercod, $mora, $fprorroga, $repite, $observacion, $saldo
            var myvals = [coddeuda, carnet, codmat, codgestion,monto,saldo,itemcobro];
            array_deudas.push(myvals);
            edits++;
        }
        
    });      
    if (edits>0){
        $.ajax({
            url: base_url + 'deudas_grupo/fn_insert_update_deuda_grupo',
            type: 'post',
            dataType: 'json',
            data: {
                vw_cmdi_txtcalfecha64: vw_cmdi_txtcalfecha,
                filas: JSON.stringify(array_deudas),
            },
            success: function(e) {
                $('#modDeudas_content #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: e.msg,
                        backdrop:false,
                    });
                } else {
                        $('#vw_mdd_estudiantes input').each(function() {
                            if (($(this).data('edit')=='1') && ($(this).data('coddeuda')<0)){
                                $(this).data('coddeuda',  e.ids[$(this).data('coddeuda')]);
                                $(this).data('edit',  '0');
                            }
                            
                        });
                        Swal.fire({
                            type: 'success',
                            title: 'ÉXITO, Se guardó cambios',
                            text: "Lo cambios fueron guardados correctamente",
                            backdrop:false,
                        });

                }
            },
            error: function(jqXHR, exception) {
                $('#modDeudas_content #divoverlay').remove();
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
        $('#modDeudas_content #divoverlay').remove();
    }
    /*}
    else{

        Swal.fire({
            type: 'error',
            title: 'ERROR, Notas Invalidas',
            text: "Existen " + nerror + " error(es): NOTA NO VÁLIDA (Rojo)",
            backdrop:false,
        });
        $('#divboxevaluaciones #divoverlay').remove();
    }*/




    return false;
});

</script>
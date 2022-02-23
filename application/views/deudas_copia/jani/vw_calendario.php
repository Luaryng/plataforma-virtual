<?php
$vbaseurl=base_url();
?>
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
                                            echo "<option $persel value='$periodo->codigo'>$periodo->nombre </option>";
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="vw_dci_btnguardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modCronogramas" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                   
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modGrupos" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
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
    <section id="s-cargado" class="content pt-3">
        <div id="vw_dc_divCalpanel" class="card">
            <div class="card-header">
                <h1 class="card-title">Calendario de Pagos</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <select name="vw_dc_cbperiodo" id="vw_dc_cbperiodo" class="form-control form-control-sm text-sm inputsb">
                                <option value="0">Selecciona periodo</option>
                                <?php foreach ($periodos as $periodo) {
                                echo "<option $persel value='$periodo->codigo'>$periodo->nombre </option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <button id="vw_dc_btnbuscar" type="button" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="col-6 text-right">
                        <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modMantCalendario">
                            <i class="fas fa-plus mr-1"></i>  Crear
                        </a>
                    </div>
                </div>
                <div class="col-12 btable">
            
                    <div class="col-md-12 thead d-none d-md-block">
                        <div class="row">
                            <div class="col-sm-1 col-md-1 td hidden-xs"><b>N°</b></div>
                            <div class="col-sm-2 col-md-2 td"><b>NOMBRE</b></div>
                            <div class="col-sm-2 col-md-1 td"><b>INICIA</b></div>
                            <div class="col-sm-2 col-md-2 td"><b>CULMINA</b></div>
                            <div class="col-sm-1 col-md-2 td text-center"></div>
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
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
    
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


$('#vw_dc_btnbuscar').click(function(event) {
    
    var periodo=$('#vw_dc_cbperiodo').val();
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
        data: {"vw_dc_cbperiodo":periodo},
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
                        "<div class='col-4 col-md-1 td'>" +
                              "<span><b>" + nro + "</b></span>" +
                        "</div>" + 
                        "<div class='col-12 col-md-2 td'>" +
                          "<span>" + val['periodo'] + "</span>" +
                        "</div> " +
                        "<div class='col-8 col-md-4 td'>" +
                        "<span data-toggle='tooltip' title='Se requiere iniciar sesión con su correo institucional para generar una reunión Meet'>" + val['nombre'] + "</span>" +
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
function fn_vw_view_fecha(btn){


    $("#div_cronogramas #vw_cmdv_spnfecha").html(btn.data('fecha'));
    $("#div_cronogramas #vw_cmdv_spndescripcion").html(btn.data('descripcion'));
     $("#div_cronogramas #vw_cmd_crono_add").hide();
    $("#div_cronogramas #vw_cmd_crono_view").show();
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
</script>
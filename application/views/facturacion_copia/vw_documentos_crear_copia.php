<?php 
    $vbaseurl=base_url();

?>

<style type="text/css">

    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
    }
</style>
<div class="content-wrapper">
    <!-- MODAL AGREGAR PAGANTE -->
    <div class="modal fade" id="modaddpagante" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">AGREGAR NUEVO REGISTRO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addpagante" action="<?php echo $vbaseurl ?>pagante/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-6 col-sm-4">
                                <select class="form-control form-control-sm" id="ficbtipodoc" name="ficbtipodoc" placeholder="Tipo Doc." >
                                    <option value="DNI">DNI</option>
                                    <option value="CEX">Carné de Extranjería</option>
                                    <option value="PSP">Pasaporte</option>
                                    <option value="PTP">Permiso Temporal de Permanencia</option>
                                </select>
                                <label for="ficbtipodoc"> Tipo Doc.</label>
                            </div>
                            <div class="form-group has-float-label col-6  col-sm-4">
                                <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtdni" name="fitxtdni" type="text" placeholder="DNI"  minlength="8" />
                                <label for="fitxtdni"> DNI</label>
                            </div>
                            <div class="col-12  col-sm-3">
                                <button id="fibtnsearch-dni" type="button" class="btn btn-primary btn-block btn-sm">
                                <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                                <input type="hidden" id="fictxtcodpagante" name="fictxtcodpagante">
                                <select name="fictipopag" id="fictipopag" class="form-control form-control-sm">
                                    <option value="CLIENTE">CLIENTE</option>
                                    <option value="ESTUDIANTE">ESTUDIANTE</option>
                                    <option value="LIBRE">LIBRE</option>
                                </select>
                                <label for="fictipopag">Tipo Pagante</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <select name="fictipopers" id="fictipopers" class="form-control form-control-sm">
                                    <option value="NATURAL">NATURAL</option>
                                    <option value="JURIDICA">JURIDICA</option>
                                </select>
                                <label for="fictipopers">Tipo Persona</label>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="fictxtnomrazon" id="fictxtnomrazon" placeholder="Nombres/Razon Social" class="form-control form-control-sm">
                                <label for="fictxtnomrazon">Nombres/Razon Social</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtemailper" id="fictxtemailper" placeholder="Correo Electrónico" class="form-control form-control-sm">
                                <label for="fictxtemailper">Correo Electrónico</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtemailper2" id="fictxtemailper2" placeholder="Otro Correo Electrónico" class="form-control form-control-sm">
                                <label for="fictxtemailper2">Otro Correo Electrónico</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtemailcorporat" id="fictxtemailcorporat" placeholder="Correo Corporativo" class="form-control form-control-sm">
                                <label for="fictxtemailcorporat">Correo Corporativo</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtdireccion" id="fictxtdireccion" placeholder="Dirección" class="form-control form-control-sm">
                                <label for="fictxtdireccion">Dirección</label>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select data-currentvalue='' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required >
                                    <option value="0">Selecciona Departamento</option>
                                    <?php foreach ($departamentos as $key => $depa) {?>
                                    <option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="ficbdepartamento"> Departamento</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select data-currentvalue='0' class="form-control form-control-sm" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" required >
                                    <option value="0">Sin opciones</option>
                                </select>
                                <label for="ficbprovincia"> Provincia</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select data-currentvalue='0'  class="form-control form-control-sm" id="ficbdistrito" name="ficbdistrito" placeholder="Distrito" required >
                                    <option value="0">Sin opciones</option>
                                </select>
                                <label for="ficbdistrito"> Distrito</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtelefono" id="fictxtelefono" placeholder="Teléfono" class="form-control form-control-sm">
                                <label for="fictxtelefono">Teléfono</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtcelular" id="fictxtcelular" placeholder="Celular" class="form-control form-control-sm">
                                <label for="fictxtcelular">Celular</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FIN MODAL AGREGAR PAGANTE -->

    <!-- BUSCAR MODAL PAGANTE -->
    <div class="modal fade" id="modsearchpagante" tabindex="-1" role="dialog" aria-labelledby="modsearchpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" id="divmodalsearch">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_titles">BUSCAR PAGANTE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_searchpag" action="" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-2">
                                <select name="vw_fcb_cbtipodocs" id="vw_fcb_cbtipodocs" class="form-control control form-control-sm text-sm">
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CEXT">Carné Extranjeria</option>
                                    <option value="PSP">PASAPORTE</option>
                                    <option value="OTDC">OTRO</option>
                                    
                                </select>
                                <label for="vw_fcb_cbtipodocs">Tipo Documento</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-3">
                                <input type="text" name="fictxtnrodoc" id="fictxtnrodoc" placeholder="N° Documento" class="form-control form-control-sm">
                                <label for="fictxtnrodoc">N° Documento</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-4">
                                <input type="text" name="fictxtnompagante" id="fictxtnompagante" placeholder="Pagante" class="form-control form-control-sm">
                                <label for="fictxtnompagante">Pagante</label>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-flat btn-info" type="submit" >
                                    <i class="fas fa-search"></i>
                                    Buscar
                                </button>
                                
                            </div>
                        </div>
                        
                    </form>
                    <div class="row">
                        <div class="col-12 py-1"  id="divcard_ltspagante">
                        
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL BUSCAR PAGANTE -->

    <!-- BUSCAR MODAL ITEM -->
    <div class="modal fade" id="modsearchitem" tabindex="-1" role="dialog" aria-labelledby="modsearchitem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="divmodalitem">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_tititem">BUSCAR ITEM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_searchitem" action="" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-3">
                                <input type="text" name="fictxtcoditem" id="fictxtcoditem" placeholder="Código" class="form-control form-control-sm">
                                <label for="fictxtcoditem">Código</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtnomitem" id="fictxtnomitem" placeholder="Nombre" class="form-control form-control-sm">
                                <label for="fictxtnomitem">Nombre</label>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-flat btn-info" type="submit" >
                                    <i class="fas fa-search"></i>
                                    Buscar
                                </button>
                                
                            </div>
                        </div>
                        
                    </form>
                    <div class="row">
                        <div class="col-12 py-1"  id="divcard_ltsitems">
                        
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL BUSCAR ITEM -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>DOCUMENTOS
                    <small>Mantenimiento</small></h1>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>documentos/pagos">Documentos</a>
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
                <form id="vw_fcb_frmboleta" action="" method="post" accept-charset="utf-8">
                    <div class="row mt-2">
                        
                        <div class="input-group input-group-sm col-md-3">
                            <input type="hidden" name="vw_fcb_tipo" value="<?php echo $tipo ?>">
                            <input type="text" class="form-control" placeholder="Serie" name="vw_fcb_serie" id="vw_fcb_serie">
                            <input type="text" class="form-control" placeholder="N°" name="vw_fcb_sernumero" id="vw_fcb_sernumero">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt"></i></button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            
                        </div>
                        <div class="input-group input-group-sm col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Emisión: </span>
                            </div>
                            <input type="date" class="form-control" name="vw_fcb_emision" id="vw_fcb_emision">
                            <input type="time" class="form-control" name="vw_fcb_emishora" id="vw_fcb_emishora">
                        </div>
                    </div>
                    <div class="row mt-2">
                        
                        
                        <div class="col-md-8">
                            
                        </div>
                        <div class="input-group input-group-sm col-md-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Vencimiento: </span>
                            </div>
                            <input type="date" class="form-control" name="vw_fcb_vencimiento" id="vw_fcb_vencimiento">

                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        
                        <div class="form-group has-float-label col-12 col-md-2">
                            <select name="vw_fcb_cbtipodoc" id="vw_fcb_cbtipodoc" class="form-control control form-control-sm text-sm">
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                                <option value="CEXT">Carné Extranjeria</option>
                                <option value="PSP">PASAPORTE</option>
                                <option value="OTDC">OTRO</option>
                                
                            </select>
                            <label for="vw_fcb_cbtipodoc">Tipo Documento</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <input autocomplete="off"  name="vw_fcb_txtnrodoc" id="vw_fcb_txtnrodoc" type="text" class="form-control form-control-sm text-sm" placeholder="N° Documento">
                            <label for="vw_fcb_txtnrodoc">N° Documento</label>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="hidden" name="vw_fcb_codpagante" id="vw_fcb_codpagante">
                                <input name="vw_fcb_txtpagante" id="vw_fcb_txtpagante" type="text" class="form-control form-control-sm text-sm" placeholder="Pagante">
                                
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group dropleft">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user"></i> opciones
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modaddpagante">
                                        <i class="fas fa-plus"></i> Agregar Pagante
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modsearchpagante">
                                        <i class="fas fa-search"></i> Buscar Pagante
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-12">
                            <input name="vw_fcb_txtdireccion" id="vw_fcb_txtdireccion" type="text" class="form-control form-control-sm text-sm" placeholder="Dirección">
                            <label for="vw_fcb_txtdireccion">Dirección</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail1" id="vw_fcb_txtemail1" type="text" class="form-control form-control-sm text-sm" placeholder="Correo 1">
                            <label for="vw_fcb_txtemail1">Correo 1</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail2" id="vw_fcb_txtemail2" type="text" class="form-control form-control-sm text-sm" placeholder="Correo 2">
                            <label for="vw_fcb_txtemail2">Correo 2</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail3" id="vw_fcb_txtemail3" type="text" class="form-control form-control-sm text-sm" placeholder="Correo 3">
                            <label for="vw_fcb_txtemail3">Correo 3</label>
                        </div>
                    </div>
                
                <div class="row mt-3" id="divcard_detalle">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Detalle

                                <div class="no-padding card-tools">
                                    <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modsearchitem">
                                        <i class="fas fa-plus"></i> Agregar item
                                    </a>
                                </div>
                            </div>
                            <div class="card-body pt-0" id="divdata_detalle">
                                <div class="row text-bold">
                                    <span class="text-sm col-1">Item</span>
                                    <span class="text-sm col-1">Cód.</span>
                                    <span class="text-sm col-1">Cant.</span>
                                    <span class="text-sm col-1">Und.</span>
                                    <span class="text-sm col-4">Descripción</span>
                                    <span class="text-sm col-2">Valor</span>
                                </div>
                                <div class="row" >
                                    <span type="text" name="" id="fictxtnro" class="form-control form-control-sm text-sm col-1">1</span>
                                    <input type="text" name="fictxtcodigo1" id="fictxtcodigo1" class="form-control form-control-sm text-sm col-1">
                                    <input type="text" name="fictxtcantidad1" id="fictxtcantidad1" class="form-control form-control-sm text-sm col-1">
                                    <input type="text" name="fictxtunidad1" id="fictxtunidad1" class="form-control form-control-sm text-sm col-1">
                                    <input type="text" name="fictxtdescrip1" id="fictxtdescrip1" class="form-control form-control-sm text-sm col-4">
                                    <input type="number" name="fictxtvalor1" id="fictxtvalor1" class="form-control form-control-sm text-sm col-2 importe">
                                    <span class="col-2">
                                        <button class="add_detitem btn btn-outline-secondary btn-circle" type="button" disabled="">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        
                                    </span>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="text-sm col-8"><b class="float-right">Igv(18%)</b></div>
                                    <div class="text-sm col-2"><input type="text" name="fictxtigv" id="fictxtigv" class="form-control form-control-sm text-sm" readonly="" value="0.00"></div>
                                </div>
                                <div class="row">
                                    <div class="text-sm col-8"><b class="float-right">Total</b></div>
                                    <div class="text-sm col-2"><input type="text" name="fictxtotal" id="fictxtotal" class="form-control form-control-sm text-sm" readonly="" value="0.00"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 py-2">
                        <div id="vw_pw_bt_ad_divmsgbolsa" class="text-danger">
                        </div>
                    </div>
                    <div class="col-12">
                        <a type="button" href="<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago" class="btn btn-danger btn-md float-left" >
                            <i class="fas fa-undo"></i> Cancelar
                        </a>
                        <button id="vw_pw_bt_ad_btn_guardar" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>resources/dist/js/pages/pagante.js"></script>
<script type="text/javascript">

$('#frm_searchpag').submit(function() {
    $('#frm_searchpag input,select').removeClass('is-invalid');
    $('#frm_searchpag .invalid-feedback').remove();
    $('#divmodalsearch').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'facturacion/get_search_lista',
        type: 'post',
        dataType: 'json',
        data: $('#frm_searchpag').serialize(),
        success: function(e) {
            $('#divmodalsearch #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });

                $("#divcard_ltspagante").html("");
            } else {

                $("#divcard_ltspagante").html(e.vdata);
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodalsearch #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
})

$("#modsearchpagante").on('hidden.bs.modal', function () {
    $('#frm_searchpag')[0].reset();
    $('#divcard_ltspagante').html('');
});

$('#frm_searchitem').submit(function() {
    $('#frm_searchitem input,select').removeClass('is-invalid');
    $('#frm_searchitem .invalid-feedback').remove();
    $('#divmodalitem').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'facturacion/get_search_item',
        type: 'post',
        dataType: 'json',
        data: $('#frm_searchitem').serialize(),
        success: function(e) {
            $('#divmodalitem #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });

                $("#divcard_ltsitems").html("");
            } else {

                $("#divcard_ltsitems").html(e.vdata);
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodalitem #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
})

$("#modsearchitem").on('hidden.bs.modal', function () {
    $('#frm_searchitem')[0].reset();
    $('#divcard_ltsitems').html('');
});

$("#vw_pw_bt_ad_btn_guardar").click(function(event) {
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    var form = $(this).parents("#divcard_detalle");
    var check = checkCampos(form);
    
    if(check) {
        $.ajax({
            url: base_url + 'facturacion/fn_guardar',
            type: 'POST',
            data: $('#vw_fcb_frmboleta').serialize()+ '&txtcontador=' + cnt,
            dataType: 'json',
            success: function(e) {
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                if (e.status == true) {
                    Swal.fire(
                        'Exito!',
                        'Los datos fueron guardados correctamente.',
                        'success'
                    );
                    window.location.href = e.redirect;
                } else {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    Swal.fire(
                        'Error!',
                        e.msg,
                        'error'
                    )
                }
            },
            error: function(jqXHR, exception) {
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                    'Error!',
                    msgf,
                    'error'
                )
            }
        })
    } else {
        $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
        Swal.fire(
            'Error!',
            'No hay datos en el detalle o hay campos vacios',
            'error'
        )
    }
    
    return false;
});

$("#vw_fcb_txtnrodoc").blur(function(event) {
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    


    var jvnrodoc=$('#vw_fcb_txtnrodoc').val();
    var jvtipodoc=$('#vw_fcb_cbtipodoc').val();
    
    $.ajax({
        url: base_url + 'pagante/fn_get_pagantes',
        type: 'POST',
        data: {vw_fcb_txtnrodoc:jvnrodoc,vw_fcb_cbtipodoc:jvtipodoc},
        dataType: 'json',
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == true) {
                $('#vw_fcb_txtpagante').val(e.vdata.razonsocial);
                $('#vw_fcb_txtdireccion').val(e.vdata.direccion + " - " + e.vdata.distrito + " - " + e.vdata.provincia + " - " + e.vdata.departamento);
                $('#vw_fcb_txtemail1').val(e.vdata.correo1);
                $('#vw_fcb_txtemail2').val(e.vdata.correo2);
                $('#vw_fcb_txtemail3').val(e.vdata.correo_corp);
                $('#vw_fcb_codpagante').val(e.vdata.codpagante);
                
                
            } else {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire(
                    'Error!',
                    e.msg,
                    'error'
                )
            }
        },
        error: function(jqXHR, exception) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                'Error!',
                msgf,
                'error'
            )
        }
    })
    return false;
});

$("#divdata_detalle input").keyup(function() {
    var form = $(this).parents("#divdata_detalle");
    var check = checkCampos(form);
    if(check) {
        $(".add_detitem").attr('disabled', false);
    }
    else {
        $(".add_detitem").attr('disabled', true);
    }
});

var cnt = 1;
$('.add_detitem').click(function(){
    cnt = cnt + 1;
    $('#divdata_detalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'facturacion/vw_agregar_items',
        type: 'post',
        dataType: 'json',
        data: {txtcnt: cnt},
        success: function(e) {
            if (e.status == true) {
                $('#divdata_detalle #divoverlay').remove();
                $('#divdata_detalle').append(e.vdata);
                $(".add_detitem").attr('disabled', true);
            } else {
                $('#divdata_detalle #divoverlay').remove();
                var msgf = '<span class="text-danger"><i class="fa fa-ban"></i>'+ e.msg +'</span>';
                $('#divdata_detalle').html(msgf);
            }
            
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception);
            $('#divdata_detalle #divoverlay').remove();
            $('#divdata_detalle').html(msgf);
        },
    });
    return false;
});

$(document).on("keyup", ".importe", function(){
    var suma = 0;
    $('.importe').each(function(){
        
        if ($(this).val() == "") {
            $(this).val(0);
            suma += parseFloat($(this).val());
        } else {
            suma += parseFloat($(this).val());
        }
        $('#fictxtotal').val(suma);
           
    });
})

function removeitem(boton) {
    var div = boton.parents('.cfila');
    div.remove();
    cnt = cnt - 1;
    if (cnt == 1) {
        $(".add_detitem").attr('disabled', false);
    }
    
}


//Función para comprobar los campos de texto
function checkCampos(obj) {
    var camposRellenados = true;
    obj.find("input").each(function() {
    var $this = $(this);
        if( $this.val().length <= 0 ) {
            camposRellenados = false;
            return false;
        }
    });
    if(camposRellenados == false) {
        return false;
    }
    else {
        return true;
    }
}

</script>
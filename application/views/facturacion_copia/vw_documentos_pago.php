<?php
	$vbaseurl=base_url();
    $vuser=$_SESSION['userActivo'];
?>
<div class="content-wrapper">
    <!-- MODAL COBROS -->
    <div class="modal fade" id="modaddcobros" tabindex="-1" role="dialog" aria-labelledby="modaddcobros" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladdcob">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">COBROS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_addcobros" action="<?php echo $vbaseurl ?>facturacion_cobros/fn_insert_cobros" method="post" accept-charset="utf-8">
                        <input type="hidden" name="vw_fcb_codigopago" id="vw_fcb_codigopago" value="">
                        <input type="hidden" name="vw_fcb_montopago" id="vw_fcb_montopago" value="">
                        <div class="row">
                            <div class="col-6">
                                <b class="h5">MONTO: <span id="ficmontopag">0.00</span></b>
                            </div>
                            <div class="col-6 text-right">
                                <b class="h5">PAGADO: <span id="ficmontocobrado">0.00</span></b>
                            </div>
                        </div><hr>
                        <div class="row mt-2" id="divcard_itemcobros">
                            <div class="form-group has-float-label col-12 col-md-4">
                                <select name="vw_fcb_cbmedio" id="vw_fcb_cbmedio" class="form-control control form-control-sm text-sm">
                                    <option value=''>Seleccione medio</option>"
                                    <?php
                                    foreach ($mediosp as $key => $mpg) {
                                        echo "<option value='$mpg->codigo' data-medio='$mpg->nombre'>$mpg->nombre</option>";
                                    }
                                    ?>
                                    
                                </select>
                                <label for="vw_fcb_cbmedio">Medio pago</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-4 d-none" id="cbobanco">
                                <select name="vw_fcb_cbbanco" id="vw_fcb_cbbanco" class="form-control control form-control-sm text-sm">
                                    <option value=''>Seleccione banco</option>"
                                    <?php
                                    foreach ($bancos as $key => $bnc) {
                                    echo "<option value='$bnc->codigo'>$bnc->nombre</option>";
                                    }
                                    ?>
                                    
                                </select>
                                <label for="vw_fcb_cbbanco">Banco</label>
                            </div>
                            <div class="form-group has-float-label col-8 col-md-2">
                                <input type="number" name="vw_fcb_monto_cobro" id="vw_fcb_monto_cobro" placeholder="Monto" class="form-control control form-control-sm text-sm">
                                <label for="vw_fcb_monto_cobro">Monto</label>
                            </div>
                            <div class="form-group col-4 col-md-2">
                                <button type="submit" class="btn btn-info btn-sm" id="btncobadd"><i class="fas fa-plus"></i> Agregar</button>
                            </div> 
                        </div>
                        <div id="divcard_form_vouchercobro" class="d-none">
                            <span class="h5 d-none" id="divtitle_banco">PAGO EN BANCO: </span>
                            <div class="row mt-2">
                                
                                <div class="d-none col-6 col-md-4" id="divcard_espacio">

                                </div>
                                <div class="form-group has-float-label col-12 col-md-3" id="divcol_itemoper">
                                    <input type="text" name="vw_fcb_voucher_cobro" id="vw_fcb_voucher_cobro" placeholder="N° Voucher" class="form-control control form-control-sm text-sm">
                                    <label for="vw_fcb_voucher_cobro">N° Voucher</label>
                                </div>
                                <div class="form-group has-float-label col-6 col-md-3" id="divcol_itemfec">
                                    <input type="date" name="vw_fcb_fechav_cobro" id="vw_fcb_fechav_cobro" placeholder="Fecha Operación" class="form-control control form-control-sm text-sm">
                                    <label for="vw_fcb_fechav_cobro">Fecha Operación</label>
                                </div>
                                <div class="form-group has-float-label col-6 col-md-2" id="divcol_itemhor">
                                    <input type="time" name="vw_fcb_horav_cobro" id="vw_fcb_horav_cobro" placeholder="Hora Operación" class="form-control control form-control-sm text-sm">
                                    <label for="vw_fcb_horav_cobro">Hora Operación</label>
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    
                                    <button type="button" class="btn btn-secondary btn-sm float-right ml-2" id="btnopercancel">
                                        Cancelar
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm float-right" id="btnopercob" data-montopg='' data-idocp='' data-modpag='Banco' data-bancopg=''>
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <div id="divcard_lstcobros" class="d-none">
                        <div class="col-12 btable">
                            <div class="col-md-12 thead d-none d-md-block">
                                <div class="row">
                                    <div class="col-sm-1 col-md-1 td hidden-xs"><b>N°</b></div>
                                    <div class="col-sm-2 col-md-3 td"><b>FECHA</b></div>
                                    <div class="col-sm-2 col-md-2 td"><b>MEDIO</b></div>
                                    <div class="col-sm-2 col-md-3 td"><b>BANCO</b></div>
                                    <div class="col-sm-2 col-md-2 td"><b>MONTO</b></div>
                                    <div class="col-sm-1 col-md-1 td text-center"></div>
                                </div>
                            </div>
                            <div class="col-md-12 tbody" id="divres_historialcobros">

                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6 col-lg-3 col-md-4">
                            <button type="button" class="btn btn-primary btn-sm btnaddcobr" data-montopg='' data-idocp='' data-modpag='Efectivo' data-bancopg='0'>
                                <i class='far fa-credit-card mr-1'></i> <span class="txtmonpg"></span> Efectivo
                            </button>
                        </div>
                        <div class="col-6 col-lg-3 col-md-4">
                            <div class='btn-group'>
                                <button class="btn btn-success btn-sm dropdown-toggle py-1 btnbnccobr" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class='far fa-credit-card mr-1'></i> <span class="txtmonpg"></span> Banco
                                </button>
                                <div class='dropdown-menu dropdown-menu-right bancos-dropdown'>
                                <?php
                                foreach ($bancos as $key => $bnc) {
                                    echo "<a class='dropdown-item btnaddoperacioncob' href='#' title='$bnc->nombre' data-montopg='' data-idocp='' data-modpag='Banco' data-bancopg='$bnc->codigo' data-nombanco='$bnc->nombre'>
                                        <i class='far fa-credit-card mr-1'></i> $bnc->nombre
                                    </a>";
                                }
                                ?>

                                </div>
                            </div>
                            <!-- <button type="button" class="btn btn-primary btn-sm">Banco</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL COBROS -->

    <div class="modal fade" id="modenviarmail" tabindex="-1" role="dialog" aria-labelledby="modenviarmail" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodalsendemail">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">Enviar a Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="form-group has-float-label col-12">
                            <input type="text" name="vw_dp_em_txtemail" id="vw_dp_em_txtemail" placeholder="Email" class="form-control form-control-sm">
                            <label for="vw_dp_em_txtemail">Email</label>
                        </div>
                        <div class="col-12 text-right" id="vw_dp_em_divoverlay" >
                            
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" id="vw_dp_em_btnenviar" data-codigo='' class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modanuladoc" tabindex="-1" role="dialog" aria-labelledby="modanuladoc" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodalanulad">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">ESTÁ SEGURO DE ANULAR DOCUMENTO?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_anuladocpago" action="<?php echo $vbaseurl ?>facturacion/fn_anula_docpago" method="post" accept-charset="utf-8">
                        <div class="row">
                            <input type="hidden" name="ficdocumentcodigo" id="ficdocumentcodigo" value="">
                            
                            <div class="form-group has-float-label col-12">
                                <textarea name="ficmotivanula" id="ficmotivanula" class="form-control form-control-sm" rows="3" placeholder="Motivo Anulación"></textarea>
                                <label for="ficmotivanula">Motivo Anulación</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_anula_doc" data-coloran="" class="btn btn-primary">Anular</button>
                </div>
            </div>
        </div>
    </div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>DOCUMENTOS
          <small>Panel</small></h1>
        </div>
        
        
      </div>
    </div>
  </section>
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_bolsa" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de Documentos</h3>
                
		    	<div class="no-padding card-tools">
                	<div class="btn-group dropleft">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Crear
                      </button> 
                      <div class="dropdown-menu">
                        <?php 
                            if (getPermitido("99") == "SI")  {
                                echo "<a class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=boleta'>Boleta</a>";
                            }
                            if (getPermitido("98") == "SI")  {
                                echo "<a class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=factura'>Factura</a>";
                            }
                         ?>
                        <div class="dropdown-divider"></div>
                        <?php 
                            if (getPermitido("100") == "SI")  {
                                echo "<a class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=notacredito'>Nota de Crédito</a>";
                            }
                            if (getPermitido("101") == "SI")  {
                                echo "<a class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=notadebito'>Nota de Débito</a>";
                            }
                         ?>
                      </div>
                    </div>
              	</div>
                
		    </div>
            <div class="card-body">
                <form id="frm_search_docpago" action="" method="post" accept-charset="utf-8">
                    <div class="row">
                        <div class="form-group has-float-label col-6 col-md-3 col-sm-6">
                            <input type="date" name="fictxtfecha_emision" id="fictxtfecha_emision" class="form-control form-control-sm">
                            <label for="fictxtfecha_emision">Fecha Inicio</label>
                        </div>
                        <div class="form-group has-float-label col-6 col-md-3 col-sm-6">
                            <input type="date" name="fictxtfecha_emisionf" id="fictxtfecha_emisionf" class="form-control form-control-sm">
                            <label for="fictxtfecha_emisionf">Fecha Final</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4 col-sm-6">
                            <input type="text" autocomplete="off" name="fictxtpagapenom" id="fictxtpagapenom" class="form-control form-control-sm" placeholder="Cliente">
                            <label for="fictxtpagapenom">Cliente</label>
                        </div>
                        <div class="col-md-2 col-sm-2 text-right">
                            <button type="submit" class="btn btn-sm btn-info">
                                <i class="fas fa-search"></i> 
                            </button>
                            
                            <div class="btn-group dropleft">
                              <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Exportar
                              </button> 
                              <div class="dropdown-menu">
                                <?php 
                                    if (getPermitido("104") == "SI")  {
                                        echo "<a id='vw_exp_pdf' class='dropdown-item' href='#'>PDF</a>";
                                    }
                                    if (getPermitido("103") == "SI")  {
                                        echo "<a id='vw_exp_excel' class='dropdown-item' href='#'>Excel</a>";
                                    }
                                 ?>
                                
                              </div>
                            </div>
                            
                        </div>
                    </div>
                </form>
                <?php $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); ?>
                <div class="btable mt-3">
                    <div class="thead col-12  d-none d-md-block">
                        <div class="row">
                            <div class='col-12 col-md-4'>
                                <div class='row'>
                                    <div class='col-1 col-md-2 td'>N°</div>
                                    <div class='col-3 col-md-3 td'>TIPO / NRO</div>
                                    <div class='col-3 col-md-5 td'>EMISIÓN</div>
                                    <div class='col-3 col-md-2 td text-center'>PSE</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-4'>
                                <div class='row'>
                                    <div class='col-9 col-md-9 td'>PAGANTE</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-4 text-center'>
                                <div class='row'>
                                    <div class='col-sm-3 col-md-3 td'>
                                        <span>MONTO</span>
                                    </div>
                                    <div class='col-sm-3 col-md-3 td'>
                                        <span>ESTADO</span>
                                    </div>
                                    <div class='col-sm-2 col-md-2 td'>
                                        <i class='fas fa-download'></i>
                                    </div>
                                    <div class='col-sm-4 col-md-4 td'>
                                        <span>ACCIONES</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbody col-12" id="divresult">
                        <?php
                        include "vw_filtrar_result.php";
                    ?>
                    </div>
                </div>
            </div>
		</div>
	</section>
</div>
<?php  
echo 
"<script src='{$vbaseurl}resources/plugins/summernote/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/dist/js/pages/documentospago.js'></script>";
?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#vw_dp_em_divoverlay").hide();
    });
    $('#frm_search_docpago').submit(function() {
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'facturacion/fn_filtrar_xsede',
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(e) {
                $('#divcard_bolsa #divoverlay').remove();
                if (e.status== true) {
                    $('#divresult').html(e.vdata);
                } else {
                    $('#divresult').html(e.vdata);
                }
                
            },
            error: function(jqXHR, exception) {
                $('#divcard_bolsa #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divresult').html(msgf);
            }
        });
        return false;
    })

    $("#modenviarmail").on('show.bs.modal', function (e) {
        var rel=$(e.relatedTarget);
        var codigo = rel.data('codigo');
        $('#vw_dp_em_btnenviar').data('codigo', codigo)
    })

    $("#modenviarmail").on('hidden.bs.modal', function (e) {
        $("#vw_dp_em_divoverlay").hide();
        $("#vw_dp_em_divoverlay").removeClass('text-danger');
        $("#vw_dp_em_divoverlay").html('');
        $("#vw_dp_em_txtemail").val('');
        $('#vw_dp_em_btnenviar').show();
    })

    $("#vw_dp_em_btnenviar").click(function(event) {
        if ($.trim($("#vw_dp_em_txtemail").val())==""){
            $("#vw_dp_em_divoverlay").show();
            $("#vw_dp_em_divoverlay").addClass('text-danger');
            $("#vw_dp_em_divoverlay").html('Ingresa un Email Válido');
        }
        else{
            $('#divmodalsendemail').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center bg-white"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $("#vw_dp_em_divoverlay").show();
            $("#vw_dp_em_divoverlay").html('Enviando <i class="fas fa-spinner fa-pulse"> </i>');
            var emailsend = $("#vw_dp_em_txtemail").val();
            var codigo = $(this).data('codigo');
            $.ajax({
                url: base_url + "facturacion_sendmail/fn_enviar_documento_email",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_email:emailsend,
                    vw_fb_codigo: codigo,
                },
                success: function(e) {
                    $('#divmodalsendemail #divoverlay').remove();
                    if (e.status == false) {
                        
                        Swal.fire({
                            title: e.msg,
                            // text: "",
                            type: 'error',
                            icon: 'error',
                        })
                        
                    } else {
                        
                        $("#vw_dp_em_divoverlay").html('Enviado <i class="fas fa-check"></i>');
                        $('#vw_dp_em_btnenviar').hide();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divmodalsendemail #divoverlay').remove();
                    $("#vw_dp_em_divoverlay").hide();
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
    });

    $('#lbtn_anula_doc').click(function(event) {
        $('#form_anuladocpago input,select,textarea').removeClass('is-invalid');
        $('#form_anuladocpago .invalid-feedback').remove();
        $('#divmodalanulad').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: $('#form_anuladocpago').attr("action"),
            type: 'post',
            dataType: 'json',
            data: $('#form_anuladocpago').serialize(),
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
                    $('#modanuladoc').modal('hide');
                    var btdtan = $('#btn_stanul'+e.iddocpago);
                    var div = btdtan.parents('.cfila');
                    var dstatus = div.find('.text-status');
                    dstatus.html(e.estadoc);
                    
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones, documento anulado',
                        text: 'Se ha anulado el documento',
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

    $("#modanuladoc").on('show.bs.modal', function (e) {
        var rel=$(e.relatedTarget);
        var codigo = rel.data('codigo');
        
        $('#ficdocumentcodigo').val(codigo);
        
    });


    // SCRIPT COBROS

    $("#modaddcobros").on('show.bs.modal', function (e) {
        var rel=$(e.relatedTarget);
        var codigo = rel.data('codigo');
        var montopg = rel.data('pgmonto');
        
        $('#vw_fcb_codigopago').val(codigo);
        $('#vw_fcb_montopago').val(montopg);
        $('#ficmontopag').html(montopg);
        $('.btnaddcobr').data('montopg', montopg);
        $('.btnaddcobr').data('idocp', codigo);
        $('.txtmonpg').html(montopg);

        $('.btnaddoperacioncob').data('montopg', montopg);
        $('.btnaddoperacioncob').data('idocp', codigo);

        $.ajax({
            url: base_url + "facturacion_cobros/fn_filtrar_cobros",
            type: 'post',
            dataType: 'json',
            data: {
                vw_fcb_codigopago:codigo,
            },
            success: function(e) {
                // $('#divmodaladdcob #divoverlay').remove();
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
                    // $('#modaddcobros').modal('hide');
                    $(".btn-group").find('.dropdown-toggle').attr("aria-expanded", "false");
                    $(".bancos-dropdown").removeClass('show');
                    
                    $('#form_addcobros')[0].reset();
                    $('#cbobanco').addClass('d-none');
                    
                    $('#divres_historialcobros').html("");
                    var nro=0;
                    var tabla="";
                    var montototalc = 0;
                    var banco = "";
                    var operbanco = "";
                    
                    if (e.vdata !== 0) {
                        $.each(e.vdata, function(index, val) {
                            nro++;
                            montototalc += parseFloat(val['montocob']);

                            if (val['nombanco']!==null) {
                                banco = val['nombanco'];
                            } else {
                                banco = "";
                            }

                            if (val['fechaoper']!==null) {
                                operbanco = "<b>Operación nro: </b>"+val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                            } else {
                                operbanco = "";
                            }

                            tabla=tabla + 
                            "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
                                "<div class='col-2 col-md-1 td'>" +
                                      "<span><b>" + nro + "</b></span>" +
                                "</div>" + 
                                "<div class='col-4 col-md-3 td'>" +
                                  "<span>" + val['fecharegis'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td'>" +
                                    "<span class=''>" + val['nommedio'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-3 td'>" +
                                    "<span class=''>" + banco + "</span> <br>" +
                                    "<span class=''>" + operbanco + "</span>" +
                                "</div> " +
                                "<div class='col-3 col-md-2 td'>" +
                                    "<span class=''>" + val['montocob'] + "</span>" +
                                "</div> " +
                                '<div class="col-3 col-md-1 td text-center">' + 
                                    "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='"+val['codigo64']+"' data-idocpg='"+val['idocpg64']+"'>"+
                                        "<i class='fas fa-trash-alt'></i>"+
                                    "</button>"+
                                '</div>' +
                            '</div>';
                        })

                        $('#divcard_lstcobros').removeClass('d-none');
                        $('#divres_historialcobros').html(tabla);
                        $('#ficmontocobrado').html(montototalc);

                        $('.btnaddcobr').attr('disabled', true);
                        $('.btnbnccobr').attr('disabled', true);

                    } else {
                        $('#divcard_lstcobros').addClass('d-none');
                        $('#divres_historialcobros').html("");
                        $('#ficmontocobrado').html("0");

                        $('.btnaddcobr').attr('disabled', false);
                        $('.btnbnccobr').attr('disabled', false);
                    }

                    var totalporcob = parseFloat($('#ficmontopag').html());
                    var totalcobrado = parseFloat($('#ficmontocobrado').html());

                    if (totalcobrado == totalporcob) {
                        $('#btncobadd').attr('disabled', true);
                        $('#form_addcobros select').attr('disabled', true);
                    } else {
                        $('#btncobadd').attr('disabled', false);
                        $('#form_addcobros select').attr('disabled', false);
                    }

                    // if (totalporcob == '0.000') {
                    //     $('.btnaddcobr').attr('disabled', true);
                    //     $('.btnbnccobr').attr('disabled', true);
                    // }


                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                // $('#divmodaladdcob #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        // return false;
    });

    $('#vw_fcb_cbmedio').change(function(event) {
        var item = $(this);
        var medio = item.find(':selected').data('medio');
        $('#divcard_form_vouchercobro').removeClass('border border-dark rounded p-2');
        $('#divtitle_banco').addClass('d-none');
        $('#divcol_itemoper').addClass('col-12 col-md-3');
        $('#divcol_itemoper').removeClass('col-12 col-md-4');

        $('#divcol_itemfec').addClass('col-6 col-md-3');
        $('#divcol_itemfec').removeClass('col-12 col-md-4');

        $('#divcol_itemhor').addClass('col-6 col-md-2');
        $('#divcol_itemhor').removeClass('col-12 col-md-4');

        if (medio === "Banco") {
            $('#cbobanco').removeClass('d-none');
            $('#divcard_form_vouchercobro').removeClass('d-none');
            $('#btnopercob').addClass('d-none');
            $('#divcard_espacio').removeClass('d-none');
            $('#btnopercancel').addClass('d-none');
            // $('#vw_fcb_fechav_cobro').attr('required', true);
            // $('#vw_fcb_horav_cobro').attr('required', true);
            // $('#vw_fcb_voucher_cobro').attr('required', true);
        } else {
            $('#cbobanco').addClass('d-none');
            $('#divcard_form_vouchercobro').addClass('d-none');
            $('#btnopercob').removeClass('d-none');
            $('#divcard_espacio').addClass('d-none');
            $('#btnopercancel').addClass('d-none');
            // $('#vw_fcb_fechav_cobro').attr('required', false);
            // $('#vw_fcb_horav_cobro').attr('required', false);
            // $('#vw_fcb_voucher_cobro').attr('required', false);
        }
    });


    $('#form_addcobros').submit(function() {
        var totalporcob = parseFloat($('#ficmontopag').html());
        var totalcobrado = parseFloat($('#ficmontocobrado').html());
        var montoinsertado = parseFloat($('#vw_fcb_monto_cobro').val());
        var totalinsertado = (totalcobrado + montoinsertado);

        if (totalinsertado > totalporcob) {
            Swal.fire({
                title: 'Error',
                text: "El monto insertado supera la Cantidad a pagar",
                type: 'error',
                icon: 'error',
            })
        } else {
            $('#form_addcobros input,select,textarea').removeClass('is-invalid');
            $('#form_addcobros .invalid-feedback').remove();
            $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: $('#form_addcobros').attr("action"),
                type: 'post',
                dataType: 'json',
                data: $('#form_addcobros').serialize(),
                success: function(e) {
                    $('#divmodaladdcob #divoverlay').remove();
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
                        // $('#modaddcobros').modal('hide');
                        
                        $('#form_addcobros')[0].reset();
                        $('#cbobanco').addClass('d-none');

                        $('#divcard_form_vouchercobro').addClass('d-none');
                        $('#divcard_espacio').addClass('d-none');
                        $('#btnopercob').removeClass('d-none');
                        
                        $('#divres_historialcobros').html("");
                        var nro=0;
                        var tabla="";
                        var montototalc = 0;
                        var banco = "";
                        var operbanco = "";
                        
                        $.each(e.vdata, function(index, val) {
                            nro++;
                            montototalc += parseFloat(val['montocob']);

                            if (val['nombanco']!==null) {
                                banco = val['nombanco'];
                            } else {
                                banco = "";
                            }

                            if (val['fechaoper']!==null) {
                                operbanco = "<b>Operación nro: </b>"+val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                            } else {
                                operbanco = "";
                            }

                            tabla=tabla + 
                            "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
                                "<div class='col-2 col-md-1 td'>" +
                                      "<span><b>" + nro + "</b></span>" +
                                "</div>" + 
                                "<div class='col-4 col-md-3 td'>" +
                                  "<span>" + val['fecharegis'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td'>" +
                                    "<span class=''>" + val['nommedio'] + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-3 td'>" +
                                    "<span class=''>" + banco + "</span><br>" +
                                    "<span class=''>" + operbanco + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-2 td'>" +
                                    "<span class=''>" + val['montocob'] + "</span>" +
                                "</div> " +
                                '<div class="col-4 col-md-1 td text-center">' + 
                                    "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='"+val['codigo64']+"' data-idocpg='"+val['idocpg64']+"'>"+
                                        "<i class='fas fa-trash-alt'></i>"+
                                    "</button>"+
                                '</div>' +
                            '</div>';
                        })
                        $('#divcard_lstcobros').removeClass('d-none');
                        $('#divres_historialcobros').html(tabla);

                        $('#ficmontocobrado').html(montototalc);

                        var totalporcobfn = parseFloat($('#ficmontopag').html());
                        var totalcobradofn = parseFloat($('#ficmontocobrado').html());

                        if (totalcobradofn == totalporcobfn) {
                            $('#btncobadd').attr('disabled', true);
                            $('#form_addcobros select').attr('disabled', true);
                        } else {
                            $('#btncobadd').attr('disabled', false);
                            $('#form_addcobros select').attr('disabled', false);
                        }

                        $('.btnaddcobr').attr('disabled', true);
                        $('.btnbnccobr').attr('disabled', true);

                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divmodaladdcob #divoverlay').remove();
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
    });

    $('.btnaddcobr').click(function() {
        var btn = $(this);
        var codigo = btn.data('idocp');
        var monto = btn.data('montopg');
        var medio = btn.data('modpag');
        var banco = btn.data('bancopg');
        $('#form_addcobros input,select,textarea').removeClass('is-invalid');
        $('#form_addcobros .invalid-feedback').remove();
        $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "facturacion_cobros/fn_insert_cobros_boton",
            type: 'post',
            dataType: 'json',
            data: {
                vw_fcb_codigopago:codigo,
                vw_fcb_cbmedio:medio,
                vw_fcb_monto_cobro:monto,
                vw_fcb_cbbanco:banco,
            },
            success: function(e) {
                $('#divmodaladdcob #divoverlay').remove();
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
                    // $('#modaddcobros').modal('hide');
                    $(".btn-group").find('.dropdown-toggle').attr("aria-expanded", "false");
                    $(".bancos-dropdown").removeClass('show');
                    
                    $('#form_addcobros')[0].reset();
                    $('#cbobanco').addClass('d-none');
                    
                    $('#divres_historialcobros').html("");
                    var nro=0;
                    var tabla="";
                    var montototalc = 0;
                    var banco = "";
                    
                    $.each(e.vdata, function(index, val) {
                        nro++;
                        montototalc += parseFloat(val['montocob']);

                        if (val['nombanco']!==null) {
                            banco = val['nombanco'];
                        } else {
                            banco = "";
                        }

                        tabla=tabla + 
                        "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
                            "<div class='col-2 col-md-1 td'>" +
                                  "<span><b>" + nro + "</b></span>" +
                            "</div>" + 
                            "<div class='col-4 col-md-3 td'>" +
                              "<span>" + val['fecharegis'] + "</span>" +
                            "</div> " +
                            "<div class='col-6 col-md-2 td'>" +
                                "<span class=''>" + val['nommedio'] + "</span>" +
                            "</div> " +
                            "<div class='col-4 col-md-3 td'>" +
                                "<span class=''>" + banco + "</span> " +
                            "</div> " +
                            "<div class='col-4 col-md-2 td'>" +
                                "<span class=''>" + val['montocob'] + "</span>" +
                            "</div> " +
                            '<div class="col-4 col-md-1 td text-center">' + 
                                "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='"+val['codigo64']+"' data-idocpg='"+val['idocpg64']+"'>"+
                                    "<i class='fas fa-trash-alt'></i>"+
                                "</button>"+
                            '</div>' +
                        '</div>';
                    })
                    $('#divcard_lstcobros').removeClass('d-none');
                    $('#divres_historialcobros').html(tabla);

                    $('#ficmontocobrado').html(montototalc);

                    var totalporcob = parseFloat($('#ficmontopag').html());
                    var totalcobrado = parseFloat($('#ficmontocobrado').html());

                    if (totalcobrado == totalporcob) {
                        $('#btncobadd').attr('disabled', true);
                        $('#form_addcobros select').attr('disabled', true);
                    } else {
                        $('#btncobadd').attr('disabled', false);
                        $('#form_addcobros select').attr('disabled', false);
                    }

                    $('.btnaddcobr').attr('disabled', true);
                    $('.btnbnccobr').attr('disabled', true);


                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladdcob #divoverlay').remove();
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

    $(document).on("click", ".btndeletecobro", function() {
        var btn = $(this);
        var codigo = btn.data('idcobro');
        var idocpago = btn.data('idocpg');
        $('#form_addcobros input,select,textarea').removeClass('is-invalid');
        $('#form_addcobros .invalid-feedback').remove();
        $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "facturacion_cobros/fn_delete_cobros",
            type: 'post',
            dataType: 'json',
            data: {
                vw_fcb_codigocobro:codigo,
                vw_fcb_idocpago : idocpago,
            },
            success: function(e) {
                $('#divmodaladdcob #divoverlay').remove();
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
                    // $('#modaddcobros').modal('hide');
                    $(".btn-group").find('.dropdown-toggle').attr("aria-expanded", "false");
                    $(".bancos-dropdown").removeClass('show');
                    
                    $('#form_addcobros')[0].reset();
                    $('#cbobanco').addClass('d-none');

                    $('#divcard_form_vouchercobro').addClass('d-none');
                    $('#divcard_espacio').addClass('d-none');
                    $('#btnopercob').removeClass('d-none');
                    
                    $('#divres_historialcobros').html("");
                    var nro=0;
                    var tabla="";
                    var montototalc = 0;
                    var banco = "";
                    var operbanco = "";

                    if (e.vdata !== 0) {
                        $.each(e.vdata, function(index, val) {
                            nro++;
                            montototalc += parseFloat(val['montocob']);

                            if (val['nombanco']!==null) {
                                banco = val['nombanco'];
                            } else {
                                banco = "";
                            }

                            if (val['fechaoper']!==null) {
                                operbanco = "<b>Operación nro: </b>"+val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                            } else {
                                operbanco = "";
                            }

                            tabla=tabla + 
                            "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
                                "<div class='col-2 col-md-1 td'>" +
                                      "<span><b>" + nro + "</b></span>" +
                                "</div>" + 
                                "<div class='col-4 col-md-3 td'>" +
                                  "<span>" + val['fecharegis'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td'>" +
                                    "<span class=''>" + val['nommedio'] + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-3 td'>" +
                                    "<span class=''>" + banco + "</span><br>" +
                                    "<span class=''>" + operbanco + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-2 td'>" +
                                    "<span class=''>" + val['montocob'] + "</span>" +
                                "</div> " +
                                '<div class="col-4 col-md-1 td text-center">' + 
                                    "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='"+val['codigo64']+"' data-idocpg='"+val['idocpg64']+"'>"+
                                        "<i class='fas fa-trash-alt'></i>"+
                                    "</button>"+
                                '</div>' +
                            '</div>';
                        })

                        $('#divcard_lstcobros').removeClass('d-none');
                        $('#divres_historialcobros').html(tabla);
                        $('#ficmontocobrado').html(montototalc);

                        $('.btnaddcobr').attr('disabled', true);
                        $('.btnbnccobr').attr('disabled', true);

                    } else {
                        $('#divcard_lstcobros').addClass('d-none');
                        $('#divres_historialcobros').html("");
                        $('#ficmontocobrado').html("0");

                        $('.btnaddcobr').attr('disabled', false);
                        $('.btnbnccobr').attr('disabled', false);
                        $('.btnaddcobr').removeClass('d-none');
                        $('.btnbnccobr').removeClass('d-none');
                    }

                    var totalporcob = parseFloat($('#ficmontopag').html());
                    var totalcobrado = parseFloat($('#ficmontocobrado').html());

                    if (totalcobrado == totalporcob) {
                        $('#btncobadd').attr('disabled', true);
                        $('#form_addcobros select').attr('disabled', true);
                    } else {
                        $('#btncobadd').attr('disabled', false);
                        $('#form_addcobros select').attr('disabled', false);
                    }
                    

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladdcob #divoverlay').remove();
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

    $('.vw_btn_msjsunat').popover({
      trigger: 'focus'
    })

    $("#vw_exp_excel").click(function(e) {
    
        e.preventDefault();
        
        $('#frm_search_docpago input,select').removeClass('is-invalid');
        $('#frm_search_docpago .invalid-feedback').remove();

        var fi=$("#fictxtfecha_emision").val();
        var ff=$("#fictxtfecha_emisionf").val();
        var pg=$("#fictxtpagapenom").val();
        var url=base_url + 'tesoreria/facturacion/reportes/documentos-emitidos/excel?fi=' + fi + '&ff=' + ff + '&pg=' + pg;
        var ejecuta=false;
        if ($.trim(fi)!=''){
            ejecuta=true;
        }
        else if($.trim(ff)!=''){
          ejecuta=true;
        }
        else if($.trim(pg)!=''){
          ejecuta=true;
        }
        if (ejecuta==true){
            window.open(url, '_blank');
        }
        else{
            Swal.fire({
                title: "Parametros requeridos",
                text: "Ingresa al menos un parametro de búsqueda",
                type: 'error',
                icon: 'error',
            })
        }
    });

    $("#vw_exp_pdf").click(function(e) {
    
        e.preventDefault();
        
        $('#frm_search_docpago input,select').removeClass('is-invalid');
        $('#frm_search_docpago .invalid-feedback').remove();

        var fi=$("#fictxtfecha_emision").val();
        var ff=$("#fictxtfecha_emisionf").val();
        var pg=$("#fictxtpagapenom").val();
        var url=base_url + 'tesoreria/facturacion/reportes/documentos-emitidos/pdf?fi=' + fi + '&ff=' + ff + '&pg=' + pg;
        var ejecuta=false;
        if ($.trim(fi)!=''){
            ejecuta=true;
        }
        else if($.trim(ff)!=''){
          ejecuta=true;
        }
        else if($.trim(pg)!=''){
          ejecuta=true;
        }
        if (ejecuta==true){
            window.open(url, '_blank');
        }
        else{
            Swal.fire({
                title: "Parametros requeridos",
                text: "Ingresa al menos un parametro de búsqueda",
                type: 'error',
                icon: 'error',
            })
        }
    });

    $("#modaddcobros").on('hidden.bs.modal', function (e) {
        $('#divcard_itemcobros').removeClass('d-none');
        $('#divcard_form_vouchercobro').addClass('d-none');
        $('.btnaddcobr').removeClass('d-none');
        $('.btnbnccobr').removeClass('d-none');
    })

    $('.btnaddoperacioncob').click(function() {
        var btn=$(this);
        var montopg = btn.data('montopg');
        var idocpg = btn.data('idocp');
        var bancopg = btn.data('bancopg');
        var nombanco = btn.data('nombanco');

        // AGREGAMOS DATOS A LOS DATA
        $('#btnopercob').data('montopg', montopg);
        $('#btnopercob').data('idocp', idocpg);
        $('#btnopercob').data('bancopg', bancopg);

        // AGREGAMOS Y QUITAMOS CLASES
        $('#divcard_itemcobros').addClass('d-none');
        $('#divcard_form_vouchercobro').removeClass('d-none');
        $('#divcard_form_vouchercobro').addClass('border border-dark rounded p-2');
        $('#divcard_espacio').addClass('d-none');
        $('#btnopercob').removeClass('d-none');
        $('#btnopercancel').removeClass('d-none');

        $('.btnaddcobr').addClass('d-none');
        $('.btnbnccobr').addClass('d-none');

        $('#divcol_itemoper').removeClass('col-12 col-md-3');
        $('#divcol_itemoper').addClass('col-12 col-md-4');

        $('#divcol_itemfec').removeClass('col-6 col-md-3');
        $('#divcol_itemfec').addClass('col-12 col-md-4');

        $('#divcol_itemhor').removeClass('col-6 col-md-2');
        $('#divcol_itemhor').addClass('col-12 col-md-4');

        $('#form_addcobros input,select').removeClass('is-invalid');
        $('#form_addcobros .invalid-feedback').remove();

        // MOSTRAR TITULO
        $('#divtitle_banco').removeClass('d-none');
        $('#divtitle_banco').html("PAGO EN BANCO: "+nombanco);
    });

    $('#btnopercancel').click(function() {

        // AGREGAMOS Y QUITAMOS CLASES
        $('#divcard_itemcobros').removeClass('d-none');
        $('#divcard_form_vouchercobro').addClass('d-none');
        $('#divcard_form_vouchercobro').removeClass('border border-dark rounded p-2');
        $('#divcard_espacio').addClass('d-none');
        $('#btnopercob').addClass('d-none');
        $('#btnopercancel').addClass('d-none');

        $('.btnaddcobr').removeClass('d-none');
        $('.btnbnccobr').removeClass('d-none');

        $('#divcol_itemoper').addClass('col-12 col-md-3');
        $('#divcol_itemoper').removeClass('col-12 col-md-4');

        $('#divcol_itemfec').addClass('col-6 col-md-3');
        $('#divcol_itemfec').removeClass('col-12 col-md-4');

        $('#divcol_itemhor').addClass('col-6 col-md-2');
        $('#divcol_itemhor').removeClass('col-12 col-md-4');

        // OCULTAR TITULO
        $('#divtitle_banco').addClass('d-none');
    });

    $('#btnopercob').click(function() {
        var btn=$(this);
        var monto = btn.data('montopg');
        var codigo = btn.data('idocp');
        var banco = btn.data('bancopg');
        var medio = btn.data('modpag');
        var fecha = $('#vw_fcb_fechav_cobro').val();
        var hora = $('#vw_fcb_horav_cobro').val();
        var voucher = $('#vw_fcb_voucher_cobro').val();
        // if (($("#vw_fcb_voucher_cobro").val() != "") || ($("#vw_fcb_fechav_cobro").val() != "") || ($("#vw_fcb_horav_cobro").val() != "")) {
            $('#form_addcobros input,select,textarea').removeClass('is-invalid');
            $('#form_addcobros .invalid-feedback').remove();
            $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + "facturacion_cobros/fn_insert_cobros_boton",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_codigopago:codigo,
                    vw_fcb_cbmedio:medio,
                    vw_fcb_monto_cobro:monto,
                    vw_fcb_cbbanco:banco,
                    vw_fcb_voucher:voucher,
                    vw_fcb_fecha:fecha,
                    vw_fcb_hora:hora
                },
                success: function(e) {
                    $('#divmodaladdcob #divoverlay').remove();
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
                        // $('#modaddcobros').modal('hide');
                        $(".btn-group").find('.dropdown-toggle').attr("aria-expanded", "false");
                        $(".bancos-dropdown").removeClass('show');
                        
                        $('#form_addcobros')[0].reset();
                        $('#cbobanco').addClass('d-none');
                        
                        $('#divres_historialcobros').html("");
                        var nro=0;
                        var tabla="";
                        var montototalc = 0;
                        var banco = "";
                        var operbanco = "";

                        $.each(e.vdata, function(index, val) {
                            nro++;
                            montototalc += parseFloat(val['montocob']);

                            if (val['nombanco']!==null) {
                                banco = val['nombanco'];
                            } else {
                                banco = "";
                            }

                            if (val['fechaoper']!==null) {
                                operbanco = "<b>Operación nro: </b>"+val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                            } else {
                                operbanco = "";
                            }

                            tabla=tabla + 
                            "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
                                "<div class='col-2 col-md-1 td'>" +
                                      "<span><b>" + nro + "</b></span>" +
                                "</div>" + 
                                "<div class='col-4 col-md-3 td'>" +
                                  "<span>" + val['fecharegis'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td'>" +
                                    "<span class=''>" + val['nommedio'] + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-3 td'>" +
                                    "<span class=''>" + banco + "</span><br>" +
                                    "<span class=''>" + operbanco + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-2 td'>" +
                                    "<span class=''>" + val['montocob'] + "</span>" +
                                "</div> " +
                                '<div class="col-4 col-md-1 td text-center">' + 
                                    "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='"+val['codigo64']+"' data-idocpg='"+val['idocpg64']+"'>"+
                                        "<i class='fas fa-trash-alt'></i>"+
                                    "</button>"+
                                '</div>' +
                            '</div>';
                        })
                        $('#divcard_lstcobros').removeClass('d-none');
                        $('#divres_historialcobros').html(tabla);

                        $('#ficmontocobrado').html(montototalc);

                        var totalporcob = parseFloat($('#ficmontopag').html());
                        var totalcobrado = parseFloat($('#ficmontocobrado').html());

                        if (totalcobrado == totalporcob) {
                            $('#btncobadd').attr('disabled', true);
                            $('#form_addcobros select').attr('disabled', true);
                        } else {
                            $('#btncobadd').attr('disabled', false);
                            $('#form_addcobros select').attr('disabled', false);
                        }

                        $('.btnaddcobr').attr('disabled', true);
                        $('.btnbnccobr').attr('disabled', true);

                        $('#divcard_itemcobros').removeClass('d-none');
                        $('#divcard_form_vouchercobro').addClass('d-none');
                        $('#vw_fcb_fechav_cobro').val("");
                        $('#vw_fcb_horav_cobro').val("");
                        $('#vw_fcb_voucher_cobro').val("");

                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divmodaladdcob #divoverlay').remove();
                    Swal.fire({
                        title: msgf,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
        // } else {
        //     $('#vw_fcb_voucher_cobro').addClass('is-invalid');
        //     $('#vw_fcb_voucher_cobro').parent().append("<div class='invalid-feedback'>Nro Voucher requerido</div>");
        //     $('#vw_fcb_fechav_cobro').addClass('is-invalid');
        //     $('#vw_fcb_fechav_cobro').parent().append("<div class='invalid-feedback'>Fecha Operación requerido</div>");
        //     $('#vw_fcb_horav_cobro').addClass('is-invalid');
        //     $('#vw_fcb_horav_cobro').parent().append("<div class='invalid-feedback'>Hora Operación requerido</div>");
        // }
        return false;
    });
</script>

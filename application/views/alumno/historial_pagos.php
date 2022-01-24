<style> 
.text-strike{
    text-decoration: line-through;
}

.not-active { 
    pointer-events: none; 
    cursor: default;
}


</style>
<?php
	$vbaseurl=base_url();
    $vuser=$_SESSION['userActivo'];
?>
<link rel="stylesheet" type="text/css" href="<?php echo $vbaseurl ?>resources/dist/css/paginador.css">

<div class="content-wrapper vh-100">
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
                    <h5 class="modal-title" id="divcard_title">Enviar a email personalisado</h5>
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


	<section id="s-cargado" class="content pt-1">
		<div id="divcard_bolsa" class="card h-100 my-0">
		    <div class="card-header">
		    	<h3 class="card-title text-bold"><i class="fas fa-list-ul mr-1"></i> Mis Documentos de Pago</h3>
                
		 
                
		    </div>
            <div class="card-body">
                
                <?php $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); ?>
                <div class="btable mt-0">
                    <div class="thead col-12  d-none d-md-block">
                        <div class="row">
                            <div class='col-12 col-md-5'>
                                <div class='row'>
                                    <div class='col-1 col-md-2 td'>N°</div>
                                    <div class='col-3 col-md-2 td'>TIPO / NRO</div>
                                    <div class='col-3 col-md-4 td'>EMISIÓN</div>
                                    <div class='col-3 col-md-4 td text-center'>PSE</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-4'>
                                
                                <div class='col-9 col-md-9 td'>PAGANTE</div>
                               
                            </div>
                            <div class='col-12 col-md-3 text-center'>
                                <div class='row'>
                                    <div class='col-md-4  td'>
                                        <span>MONTO</span>
                                    </div>
                                    <div class='col-md-4  td'>
                                        <span>IGV</span>
                                    </div>
                                    
                                    <div class='col-md-4  td'>
                                        <span>ACCIONES</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbody col-12 vh-75" id="divresult">
                        <?php
                        //$this->load->view("documentopagos/result_data",array('items' => $docpago ));
                        include "historial_pagos_detalle.php";
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 my-0">
                        <div class="border mt-1 mb-1 p-1 text-primary font-weight-bold " id="divcantfiltro">
                            Cantidad: <?php echo $numitems ?>
                        </div>
                    </div>
                    <div class="col-8 py-0">
                        <div id="page-selection" class="text-right pagination-page">
                        </div>
                    </div>
                </div>
                

                
                
            </div>
		</div>
	</section>
</div>
<?php  
echo 
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/dist/js/pages/documentospago.js'></script>
<script src='{$vbaseurl}resources/dist/js/jquery.bootpag.min.js'></script>";
?>

<script type="text/javascript">
    //var cantidad = 0;
    valto=0;
    $(document).ready(function() {
       
        $("#vw_dp_em_divoverlay").hide();

        $('.vw_btn_msjsunat').popover({
          trigger: 'focus'
        });
        //

        
        

    });
    
    

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
                    $("#frm_search_docpago").submit();
                    
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
        $('#divres_historialcobros').html('<i class="fas fa-spinner fa-pulse fa-3x"></i>');
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

                    

                    // if (totalporcob == '0.000') {
                    //     $('.btnaddcobr').attr('disabled', true);
                    //     $('.btnbnccobr').attr('disabled', true);
                    // }


                }
            },
            error: function(jqXHR, exception) {
                $('#divres_historialcobros').html('');
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
           
        } else {
            $('#cbobanco').addClass('d-none');
            $('#divcard_form_vouchercobro').addClass('d-none');
            $('#btnopercob').removeClass('d-none');
            $('#divcard_espacio').addClass('d-none');
            $('#btnopercancel').addClass('d-none');
            
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
       
        return false;
    });
    
function fn_eliminar_documento(btn){
    var codigo=btn.data('codigo');
    var fila=btn.closest('.rowcolor');
    var docsn=fila.data('docsn');
    //************************************
    Swal.fire({
      title: "Precaución",
      text: "¿Deseas eliminar de forma permanente el documento " + docsn + "?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
      if (result.value) {
          //var codc=$(this).data('im');
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
                url: base_url + "facturacion/fn_delete_documento",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_codigo:codigo
                },
                success: function(e) {
                    $('#divcard_bolsa #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR! DATA",
                             text: e.msg,
                            type: 'error',
                            icon: 'error',
                        })
                        
                    } else {
                        // $('#modaddcobros').modal('hide');
                        Swal.fire({
                            title: docsn,
                             text: "Se eliminó con éxito",
                            type: 'success',
                            icon: 'success',
                        });
                        fila.remove();
                        

                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divcard_bolsa #divoverlay').remove();
                    Swal.fire({
                        title: "ERROR!",
                        text:  msgf,
                        type: 'error',
                        icon: 'error',
                    })
                }
        });
        return false;
      }
      else{
         $('#divcard-matricular #divoverlay').remove();
      }
    });
    //***************************************
    
}


function fn_enviar_documento_ose(btn){
    var codigo=btn.data('codigo');
    var fila=btn.closest('.rowcolor');
    var docsn=fila.data('docsn');
    //************************************
    Swal.fire({
      title: "ENVIO A SUNAT",
      text: "¿Deseas enviar el documento " + docsn + "?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, enviar!'
    }).then((result) => {
      if (result.value) {
          //var codc=$(this).data('im');
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
                url: base_url + "facturacion/fn_reportar_doc_a_nube",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_codigo:codigo
                },
                success: function(e) {
                    $('#divcard_bolsa #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR! DATA",
                             text: e.msg,
                            type: 'error',
                            icon: 'error',
                        })
                        
                    } else {
                        Swal.fire({
                            title: docsn,
                             text: "Se envió con éxito",
                            type: 'success',
                            icon: 'success',
                        });
                        $('#frm_search_docpago').submit();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divcard_bolsa #divoverlay').remove();
                    Swal.fire({
                        title: "ERROR!",
                        text:  msgf,
                        type: 'error',
                        icon: 'error',
                    })
                }
        });
        return false;
      }
      else{
         //$('#divcard-matricular #divoverlay').remove();
      }
    });
}

function fn_consultar_documento_ose(btn){
    var codigo=btn.data('codigo');
    var fila=btn.closest('.rowcolor');
    var docsn=fila.data('docsn');
    //************************************
    Swal.fire({
      title: "CONSULTA A SUNAT",
      text: "¿Deseas CONSULTAR el documento " + docsn + "?",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, consultar!'
    }).then((result) => {
      if (result.value) {
          //var codc=$(this).data('im');
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
                url: base_url + "facturacion/fn_consultar_doc_a_nube",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_codigo:codigo
                },
                success: function(e) {
                    $('#divcard_bolsa #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR! DATA",
                             text: e.msg,
                            type: 'error',
                            icon: 'error',
                        })
                        
                    } else {
                        Swal.fire({
                            title: docsn,
                             text: "Se envió con éxito",
                            type: 'success',
                            icon: 'success',
                        });
                        $('#frm_search_docpago').submit();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divcard_bolsa #divoverlay').remove();
                    Swal.fire({
                        title: "ERROR!",
                        text:  msgf,
                        type: 'error',
                        icon: 'error',
                    })
                }
        });
        return false;
      }
      else{
         //$('#divcard-matricular #divoverlay').remove();
      }
    });
}
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



    $("#frm_search_docpago").submit(function(event) {
        fn_filtrar_xsede(1);
        //paginaciondocum(1);
        return false;
    });
    function fn_filtrar_xsede(pagina){

        var limite = "40";
        var inicio = (pagina - 1) * limite;
        $('.divhide').hide();
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'facturacion/fn_filtrar_xsede',
            type: 'post',
            dataType: 'json',
            data: $("#frm_search_docpago").serialize() + "&inicio="+ inicio +"&limite="  + limite,
            success: function(e) {
                $('#divcard_bolsa #divoverlay').remove();
                if (e.status== true) {
                    $('#divresult').html(e.vdata);
                    $('.vw_btn_msjsunat').popover({
                      trigger: 'focus'
                    })

                    $('#divcantfiltro').html("Cantidad: "+ e.numitems);
                    
                    //$('.divhide').addClass('d-none');
                    
                    paginaciondocum(e.numitems,pagina);
                    
                } else {
                    $('#divresult').html(e.vdata);
                    $('#divcantfiltro').html("Cantidad: 0");
                    //$('.divhide').addClass('d-none');
                    paginaciondocum(0);
                }
                
            },
            error: function(jqXHR, exception) {
                $('#divcard_bolsa #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divresult').html(msgf);
            }
        });
        return false;
    }

    function paginaciondocum(cantidad,total=1) {
        var pagtotal = Math.round(cantidad / 40);
        $('#page-selection').html('');
        if (pagtotal > 0) {
            $('#page-selection').bootpag({
                total: pagtotal,
                page: total,
                maxVisible: 4,
                wrapClass: "pages",
                disabledClass: "not-active"
            }).on("page", function(event, num){
                var limite = "40";
                var inicio = (num - 1) * limite;
                $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                $.ajax({
                    url: base_url + 'facturacion/fn_filtrar_xsede',
                    type: 'post',
                    dataType: 'json',
                    data: $("#frm_search_docpago").serialize() + "&inicio="+ inicio +"&limite="  + limite,
                    success: function(e) {
                        $('#divcard_bolsa #divoverlay').remove();
                        if (e.status== true) {
                            $('#divresult').html(e.vdata);
                            $('.vw_btn_msjsunat').popover({
                              trigger: 'focus'
                            })

                            $('#divcantfiltro').html("Cantidad: "+ e.numitems);
                            
                            //$('.divhide').addClass('d-none');
                            
                            
                            
                        } else {
                            $('#divresult').html(e.vdata);
                            $('#divcantfiltro').html("Cantidad: 0");
                            //$('.divhide').addClass('d-none');
                            
                        }
                        
                    },
                    error: function(jqXHR, exception) {
                        $('#divcard_bolsa #divoverlay').remove();
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        $('#divresult').html(msgf);
                    }
                });

            });
        } else {
            $('#page-selection').html('');
        }
    }
    


    
</script>
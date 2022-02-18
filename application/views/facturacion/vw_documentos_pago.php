<style> 
.text-strike{
    text-decoration: line-through;
}

.not-active { 
    pointer-events: none; 
    cursor: default;
}

#divresult::-webkit-scrollbar {
    width: 6px;
    height: 4px;
}

#divresult::-webkit-scrollbar-track {
    box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.3);
    border-radius: 10px;
}

#divresult::-webkit-scrollbar-thumb {
    background: rgba(229, 231, 233, 1);
    border-radius: 10px;
    box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.5);
}

@media screen and (max-width: 767px) {
    #divresult::-webkit-scrollbar {
        width: 8px;
        height: 6px;
    }
}

#divresult {
    overflow-x: auto;
    overflow-y: auto;
    
}
.drop-menu-index{
    z-index: 2500;
    position: relative;
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
                                <input type="text" name="vw_fcb_monto_cobro" id="vw_fcb_monto_cobro" placeholder="Monto" class="form-control control form-control-sm text-sm">
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
                    <h5 class="modal-title" id="divcard_title">Enviar a email personalizado</h5>
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
                    <form id="form_anuladocpago" action="<?php echo $vbaseurl ?>facturacion_anulacion/fn_anula_docpago" method="post" accept-charset="utf-8">
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

    <div class="modal fade" id="modasgmatricula" tabindex="-1" role="dialog" aria-labelledby="modasgmatricula" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" id="divmodaladdmat">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">MATRICULAR ESTUDIANTE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 tex-primary">
                            
                            <div class="col-12 p-0">
                                <h5 id="fgi-apellidos" class="d-block p-1 bg-lightgray border rounded"></h5>
                                <b class="d-block text-danger pt-3"><i class="fas fa-user-graduate mr-1"></i> HISTORIAL DE MATRÍCULAS</b>
                            </div>
                            <div class="col-12 btable">
                                <div class="col-md-12 thead d-none d-md-block">
                                    <div class="row">
                                        <div class="col-6 col-md-7">
                                            <div class="row">
                                                <div class="cperiodo col-2 col-md-2 td"> PER. </div>
                                                <div class="col-2 col-md-5 td text-center">PLAN</div>
                                                <div class="ccarrera col-2 col-md-5 td" >PROGRAMA.</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <div class="row">
                                                <div class="cciclo td col-2 col-md-4 text-center " >CC.</div>
                                                <div class="cturno td col-2 col-md-4 text-center ">TR.</div>
                                                <div class="cseccion td col-2 col-md-4 text-center ">SC.</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 td">
                                            EST.
                                        </div>
                                        <div class="col-6 col-md-1 td">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 tbody" id="vw_fcb_div_Hmatriculas">
                                </div>
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

    <div class="modal fade" id="modupdatepagante" tabindex="-1" role="dialog" aria-labelledby="modupdatepagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodalupdatepag">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">Actualizar Pagante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_update_pagante" action="" method="post" accept-charset="utf-8">
                        <input type="hidden" name="vw_dp_txt_codocument" id="vw_dp_txt_codocument">
                        <div class="row">
                            <div class="form-group has-float-label col-4">
                                <input type="text" name="vw_dp_txt_codigpagante" id="vw_dp_txt_codigpagante" placeholder="Cod. Pagante" class="form-control form-control-sm">
                                <label for="vw_dp_txt_codigpagante">Cod. Pagante</label>
                            </div>
                            <div class="form-group has-float-label col-4">
                                <select name="vw_dp_txt_tipdocpagante" id="vw_dp_txt_tipdocpagante" class="form-control form-control-sm">
                                    
                                </select>
                                <label for="vw_dp_txt_tipdocpagante">Tipo doc.</label>
                            </div>
                            <div class="form-group has-float-label col-4">
                                <input type="text" name="vw_dp_txt_dnipagante" id="vw_dp_txt_dnipagante" placeholder="N° documento" class="form-control form-control-sm">
                                <label for="vw_dp_txt_dnipagante">N° documento</label>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="vw_dp_txt_dpagante" id="vw_dp_txt_dpagante" placeholder="Cliente" class="form-control form-control-sm">
                                <label for="vw_dp_txt_dpagante">Cliente</label>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="vw_dp_txt_direccion_pag" id="vw_dp_txt_direccion_pag" placeholder="Dirección" class="form-control form-control-sm">
                                <label for="vw_dp_txt_direccion_pag">Dirección</label>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" id="vw_dp_em_btnupdate_pag" data-codigo='' class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modupdatedocumento" tabindex="-1" role="dialog" aria-labelledby="modupdatedocumento" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content" id="divmodalupdatedocum">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">Actualizar Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_update_documento" action="" method="post" accept-charset="utf-8">
                        <input type="hidden" name="vw_dp_txt_codocument" id="vw_dp_txt_codocument">
                        <input name="vw_fcb_txtigvp_up" id="vw_fcb_txtigvp_up" type="hidden" value="">
                        <div class="row mt-2">
                            <div class="input-group input-group-sm col-md-3">
                                <input type="hidden" name="vw_fcb_tipo_up" id="vw_fcb_tipo_up" value="">
                                <input readonly="" type="text" class="form-control" placeholder="Serie" name="vw_fcb_serie_up" id="vw_fcb_serie_up" value="">
                                <input type="text" class="form-control" placeholder="N°" name="vw_fcb_sernumero_up" id="vw_fcb_sernumero_up" value="">
                            </div>
                            <div class="col-md-3"></div>
                            <div class="input-group input-group-sm col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Emisión: </span>
                                </div>
                                <input type="date" class="form-control " name="vw_fcb_emision_up" id="vw_fcb_emision_up" value="">
                                <input type="time" class="form-control " name="vw_fcb_emishora_up" id="vw_fcb_emishora_up" value="">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group has-float-label col-6 col-md-2">
                                <select name="vw_dp_txt_tipdocpagante_up" id="vw_dp_txt_tipdocpagante_up" class="form-control form-control-sm">
                                    
                                </select>
                                <label for="vw_dp_txt_tipdocpagante_up">Tipo doc.</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-3">
                                <input type="text" name="vw_dp_txt_dnipagante_up" id="vw_dp_txt_dnipagante_up" placeholder="N° documento" class="form-control form-control-sm">
                                <label for="vw_dp_txt_dnipagante_up">N° documento</label>
                            </div>
                            <div class="form-group has-float-label col-4 col-sm-2">
                                <input type="text" name="vw_dp_txt_codigpagante_up" id="vw_dp_txt_codigpagante_up" placeholder="Cod. Pagante" class="form-control form-control-sm">
                                <label for="vw_dp_txt_codigpagante_up">Cod. Pagante</label>
                            </div>
                            <div class="form-group has-float-label col-8 col-md-5">
                                <input type="text" name="vw_dp_txt_dpagante_up" id="vw_dp_txt_dpagante_up" placeholder="Cliente" class="form-control form-control-sm">
                                <label for="vw_dp_txt_dpagante_up">Cliente</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-8">
                                <input type="text" name="vw_dp_txt_direccion_pag_up" id="vw_dp_txt_direccion_pag_up" placeholder="Dirección" class="form-control form-control-sm">
                                <label for="vw_dp_txt_direccion_pag_up">Dirección</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-4">
                                <select name="vw_fcb_ai_txtcodmatricula" id="vw_fcb_ai_txtcodmatricula" class="form-control control form-control-sm text-sm text-danger">

                                </select>
                            </div>      
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card border border-secondary ">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h4>Detalle</h4>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0" id="divcard_detail_doc">
                                        <div class="row text-bold">
                                            <span class="text-sm col-1">Und.</span>
                                            <span class="text-sm col-1">Cód.</span>
                                            <span class="text-sm col-4">Concepto</span>
                                            <span class="text-sm col-1">Cant.</span>
                                            <span class="text-sm col-1">P.U</span>
                                            <span class="text-sm col-1">Monto</span>
                                            <span class="text-sm col-1">Cod.Deud</span>
                                            <span class="text-sm col-1">Cod.Mat</span>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row mb-2">
                                            <label for="vw_fcb_txtobservaciones">Mas Información</label>
                                            <textarea name="vw_fcb_txtobservaciones" id="vw_fcb_txtobservaciones" class="form-control " rows="2"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-6">
                                                <div class="form-check d-none">
                                                    <input class="form-check-input " type="checkbox" value="" id="vw_fcb_chk_dsct_global">
                                                    <label class="form-check-label" for="vw_fcb_chk_dsct_global">
                                                        Descuento Global
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="text-sm col-4"><span class="float-right">Operación Gravada</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_gravada" id="vw_fcb_txtoper_gravada" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-2 ">
                                                <input type="text" name="vw_fcb_txt_dsct_general" id="vw_fcb_txt_dsct_general" class="form-control  form-control-sm text-sm div_dctoglobal" value="0.00">
                                            </div>
                                            <div class="form-group has-float-label col-12 col-md-2 ">
                                                <select name="vw_fcb_cbdsctglobalfactor" id="vw_fcb_cbdsctglobalfactor" class="form-control  control form-control-sm text-sm div_dctoglobal">
                                                    <option  value='1'>Soles</option>
                                                    <option  value='100'>%</option>
                                                    
                                                </select>
                                                <input type="hidden" name="vw_fcb_cbdsctglobalmontobase_final" id="vw_fcb_cbdsctglobalmontobase_final" placeholder="mb" >
                                                <input type="hidden" name="vw_fcb_cbdsctglobalfactor_final" id="vw_fcb_cbdsctglobalfactor_final" placeholder="factor" >
                                            </div>
                                            <div class="text-sm col-6"><span class="float-right">Operación Inafecta</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_inafecta" id="vw_fcb_txtoper_inafecta" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Operación Exonerada</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_exonerada" id="vw_fcb_txtoper_exonerada" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Operación Exportación</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_exportacion" id="vw_fcb_txtoper_exportacion" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Descuentos Totales</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_desctotal" id="vw_fcb_txtoper_desctotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Total de Op. Gratuitas</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_gratuitas" id="vw_fcb_txtoper_gratuitas" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Subtotal</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtsubtotal" id="vw_fcb_txtsubtotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">ICBPER</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txticbpertotal" id="vw_fcb_txticbpertotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">ISC Total</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtisctotal" id="vw_fcb_txtisctotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">IGV Total</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtigvtotal" id="vw_fcb_txtigvtotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">TOTAL</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txttotal" id="vw_fcb_txttotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" id="vw_dp_em_btnupdate_docum" data-codigo='' class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

	<section id="s-cargado" class="content pt-1">
		<div id="divcard_bolsa" class="card h-100 my-0">
		    <div class="card-header">
		    	<h3 class="card-title text-bold"><i class="fas fa-list-ul mr-1"></i> Documentos de Pago Emitidos ( <?php echo $vuser->sede ?> )</h3>
                
		    	<div class="p-0 card-tools">
                	<div class="btn-group dropleft">
                      <button class="btn btn-secondary btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                echo "<a class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=notaboleta'>Nota de Crédito - BOLETA</a>";
                                echo "<a class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=notafactura'>Nota de Crédito - FACTURA</a>";
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
                        <div class="form-group has-float-label col-12 col-md-3 col-sm-6">
                            <select name="fictxttipodoc" id="fictxttipodoc" class="form-control form-control-sm">
                                <option value='%'>Todos</option>
                                <?php
                                foreach ($tipdoc as $key => $doc) {
                                    echo "<option value='$doc->codigo'>$doc->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="fictxttipodoc">Tipo</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-9 col-sm-6">
                            <input type="text" autocomplete="off" name="fictxtpagapenom" id="fictxtpagapenom" class="form-control form-control-sm" placeholder="Cliente">
                            <label for="fictxtpagapenom">Cliente</label>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-12 col-md-4 ">
                            <div class="row ">
                                <div class="col-md-3 col-3 form-group">
                                    <div class="form-check">
                                        <input checked="" class="form-check-input checkradio" value="todo" type="radio" name="radio1" id="radioall">
                                        <label class="form-check-label" for="radioall">Todo</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 form-group">
                                    <div class="form-check">
                                        <input class="form-check-input checkradio" value="hoy" type="radio" name="radio1" id="radiohoy">
                                        <label class="form-check-label" for="radiohoy">Hoy</label>
                                    </div>
                                </div>
                                <!--<div class="form-group col-md-1 col-3">
                                    <div class="form-check">
                                        <input class="form-check-input checkradio" value="ayer" type="radio" name="radio1" id="radioayer">
                                        <label class="form-check-label" for="radioayer">Ayer</label>
                                    </div>
                                </div>-->
                                <div class="col-md-3 col-3 form-group">
                                    <div class="form-check">
                                        <input class="form-check-input checkradio" value="mes" type="radio" name="radio1" id="radiomes">
                                        <label class="form-check-label" for="radiomes">Mes</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 form-group">
                                    <div class="form-check">
                                        <input class="form-check-input checkradio" value="entre" type="radio" name="radio1" id="radioentre">
                                        <label class="form-check-label" for="radioentre">Entre</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-float-label col-6 col-md-3 col-sm-6">
                            <input type="date" name="fictxtfecha_emision" id="fictxtfecha_emision" class="form-control form-control-sm">
                            <label for="fictxtfecha_emision">Fecha Inicio</label>
                        </div>
                        <div class="form-group has-float-label col-6 col-md-3 col-sm-6">
                            <input type="date" name="fictxtfecha_emisionf" id="fictxtfecha_emisionf" class="form-control form-control-sm">
                            <label for="fictxtfecha_emisionf">Fecha Final</label>
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
                                    <div class='col-md-4 td'>
                                        <span></span>
                                    </div>
                                    <div class='col-md-3 td'>
                                        <span>MONTO</span>
                                    </div>
                                    <div class='col-md-3 td'>
                                        <span>IGV</span>
                                    </div>
                                    
                                    <div class='col-md-2 td'>
                                        <span></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbody col-12 vh-75" id="divresult">
                        <?php
                        //$this->load->view("documentopagos/result_data",array('items' => $docpago ));
                        include "vw_filtrar_result.php";
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 my-0">
                        <div class="border mt-1 mb-1 p-1 text-primary font-weight-bold " id="divcantfiltro">
                            Cantidad: <?php echo $numitems ?>
                        </div>
                    </div>
                    <div class="col-5 py-1 ">
                        <?php  if (getPermitido("110") == "SI"): ?>
                            <a id="vw_dp_em_btn_enviar_docs_sunat" class="btn btn-warning btn-sm" href="#">Enviar Pendientes a Sunat</a>
                        <?php endif ?>
                        <?php  if (getPermitido("111") == "SI"): ?>
                            <a id="vw_dp_em_btn_consultar_docs_sunat" class="btn btn-primary btn-sm " href="#">Consultar Enviados a Sunat</a>
                        <?php endif ?>
                        
                    </div>
                    <div class="col-5 py-0">
                        <div id="page-selection" class="text-right pagination-page">
                        </div>
                    </div>
                </div>
                <div class="row divhide d-block">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="p-1 border text-center font-weight-bold" id="divdocserie"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-1 border text-center font-weight-bold" id="divpagante"></div>
                            </div>
                            <div class="col-md-3">
                                <button id="vw_dp_em_btn_close" type="button" class="btn btn-primary btn-sm float-right" aria-label="Close">x</button>
                                <div class="p-1 border text-center font-weight-bold" id="divestado"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                             <div class="col-md-9" id="divcard_details"></div>
                            <div class="col-md-3  ">
                                <div class="col-12 border">
                                    <div class="row">
                                    <div class="col-6 h6 text-muted font-weight-bold">SubTotal:</div>
                                    <div class="col-6 h6 text-muted text-right font-weight-bold" id="divsubtotal"></div>
                                
                                    <div class="col-6 h6 text-muted font-weight-bold">IGV:</div>
                                    <div class="col-6 h6 text-muted text-right font-weight-bold" id="divIgv"></div>
                                
                                    <div class="col-6 h6 font-weight-bold">TOTAL:</div>
                                    <div class="col-6 h5 text-right font-weight-bold" id="divTotal"></div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-1">
                        <div class="border p-1">
                            <span><b>Observaciones:</b></span> 
                            <span id="divobserva"></span>
                        </div>
                    </div>
                </div>
                
            </div>
		</div>
	</section>

    <div id="vw_fcb_rowitem" class="row rowcolor vw_fcb_class_rowitem" data-arraypos="-1">
        <div class="col-12 col-md-1 p-0">
            <input type="hidden" name="vw_fcb_ai_cod_detalle" >
            <select readonly name="vw_fcb_ai_cbunidad"  class="form-control control form-control-sm text-sm">
                <?php
                foreach ($unidad as $key => $und) {
                echo "<option  value='$und->codigo' >$und->nombre</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-12 col-md-1 p-0">
            <input readonly type="text"  name="vw_fcb_ai_cbgestion" class="form-control form-control-sm text-sm">
        </div>
        <div class="col-12 col-md-4 p-0">
            <input autocomplete="off" type="text"  onchange="fn_update_concepto($(this));return false" name="vw_fcb_ai_txtgestion" placeholder="Gestion" class="form-control form-control-sm text-sm divcard_campos_read">
        </div>
        <div class="col-12 col-md-1 p-0">
            <input autocomplete="off" onkeyup="fn_update_precios($(this));return false" onchange="fn_update_precios($(this));return false" type="number" name="vw_fcb_ai_txtcantidad"  placeholder="Cantidad" class="form-control form-control-sm text-sm text-right divcard_campos_read">
        </div>
        <div class="col-12 col-md-1 p-0">
            <input autocomplete="off" onkeyup="fn_update_precios($(this));return false" onchange="fn_update_precios($(this));return false" type="number" name="vw_fcb_ai_txtpreciounitario"  placeholder="pu" class="form-control form-control-sm text-sm text-right divcard_campos_read">
        </div>
        <div class="col-12 col-md-1 p-0">
            <input readonly type="text" name="vw_fcb_ai_txtprecioventa"  placeholder="pv" class="form-control form-control-sm text-sm text-right">
        </div>
        <div class="col-12 col-md-1 p-0">
            <input type="text" onkeyup="fn_update_cod_deuda($(this));return false" onchange="fn_update_cod_deuda($(this));return false" name="vw_fcb_ai_txtcoddeuda" class="form-control form-control-sm text-sm">
        </div>
        <div class="col-12 col-md-1 p-0">
            <select onchange="fn_update_cod_matricula_deta($(this));return false;" name="vw_fcb_ai_txtcodmatricula_det" class="form-control control form-control-sm text-sm text-danger form_select_mat" data-prb="hola">

            </select>
        </div>
        <div class="row">
            <input readonly type="hidden" name="vw_fcb_ai_txtvalorunitario"  >
            <div class="col-12 col-md-3">
                <input  type="hidden" name="vw_fcb_ai_cbisc"  >
            </div>
            <div class="col-12 col-md-2">
                <input  type="hidden" name="vw_fcb_ai_txtiscvalor"  placeholder="Impuesto" >
            </div>
            <div class="col-12 col-md-3">
                <input  type="hidden" name="vw_fcb_ai_cbiscfactor" >
            </div>
            <div  class="col-12 col-md-2">
                <input  type="hidden" name="vw_fcb_ai_txtiscbase"  placeholder="Base Imponible" >
            </div>
            <div class="col-12 col-md-2">
                <input  type="hidden" name="vw_fcb_ai_txtdsctvalor"  placeholder="Impuesto">
            </div>
            <div class="col-12 col-md-3" name="vw_fcb_ai_cbdsctfactor">
                <input  type="hidden">
                
            </div>
            <div class="col-12 col-md-4">
                <input  type="hidden"  name="vw_fcb_ai_cbafectacion">
            </div>
            <div class="col-12 col-md-4">
                <input  type="hidden"  name="vw_fcb_ai_cbafectaigv">
            </div>
            
        </div>
    </div>
    
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
        $('#vw_fcb_rowitem').hide();
        $(".div_dctoglobal").hide();

        $('.vw_btn_msjsunat').popover({
          trigger: 'focus'
        });
        //

        //$("#fictxtfecha_emisionf").val("01/" + mes + "/" + anio);
        //alert("ddd");
        
        paginaciondocum('<?php echo $numitems ?>');
        $("#s-cargado").height($(".content-wrapper").height()-30);
        cssh=$("#divcard_bolsa .card-body ").height() - $("#frm_search_docpago").height() - 100;

        
        //alert(cssh );
        $("#divresult").height(cssh);
        valto=cssh;
        $(".divhide").removeClass("d-block");
        $(".divhide").addClass("d-none");

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
        var fila=btn.closest('.cfila');
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
        var fila=btn.closest('.cfila');
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
        var fila=btn.closest('.cfila');
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

    function fn_showdetail(btn,codigo) {
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        //alert($("#divresult").height());
        //alert($(".divhide").height());
        $("#divresult .cfila").removeClass("bg-warning");
        var fila=btn.closest(".cfila");
        fila.addClass("bg-warning");
        $(".divhide").removeClass("d-none");
        $(".divhide").addClass("d-block");
        $("#divresult").height(valto - $('.divhide').height());
        
        $.ajax({
            url: base_url + 'facturacion/fn_filtrar_detalle_docpago',
            type: 'post',
            dataType: 'json',
            data: {vw_fcb_codigopago : codigo},
            success: function(e) {
                if (e.status == true) {
                    $('#divcard_details').html("");
                    var nro=0;
                    var tabla="";

                    tabla = tabla + 
                        "<div class='btable mt-0'>"+
                            "<div class='thead col-12  d-none d-md-block'>"+
                                "<div class='row'>"+
                                    "<div class='col-12 col-md-5'>"+
                                        "<div class='row'>"+
                                            "<div class='col-4 col-md-4 td'>CODGEST</div>"+
                                            "<div class='col-8 col-md-8 td'>CONCEPTO</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='col-12 col-md-4 text-center'>"+
                                        
                                        "<div class='row'>"+
                                            "<div class='col-4 col-md-4 td'>CANT.</div>"+
                                            "<div class='col-4 col-md-4 td'>PREC.</div>"+
                                            "<div class='col-4 col-md-4 td'>CODEU.</div>"+
                                        "</div>"+
                                       
                                    "</div>"+
                                    "<div class='col-12 col-md-3 text-center'>"+
                                        "<div class='row'>"+
                                            "<div class='col-md-6  td'>"+
                                                "<span>IGV.</span>"+
                                            "</div>"+
                                            "<div class='col-md-6  td'>"+
                                                "<span>FACT.</span>"+
                                            "</div>"+

                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                            "<div class='tbody col-12'>";
                                
                    $.each(e.vdata, function(index, val) {
                        nro++;

                        tabla = tabla + 
                            "<div class='row rowcolor cfila'>"+
                                "<div class='col-12 col-md-5'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-md-4 text-right td'><b>"+val['gestid']+"</b></div>"+
                                        "<div class='col-8 col-md-8 td'>"+val['gestion']+"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-4 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-md-4 td'>"+val['cantidad']+"</div>"+
                                        "<div class='col-4 col-md-4 td'>"+val['preunit']+"</div>"+
                                        "<div class='col-4 col-md-4 td'>"+val['deudaid']+"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3 text-center'>"+
                                    "<div class='row'>"+
                                        "<div class='col-6 col-md-6 td'>"+val['igv']+"</div>"+
                                        "<div class='col-6 col-md-6 td'>"+val['gestid']+"</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                                
                    })
                    tabla = tabla + 
                            "</div>"+
                        "</div>";

                    $('#divdocserie').html(e.vdatap['serie']+' - '+e.vdatap['numero']);
                    $('#divpagante').html(e.vdatap['pagantenom']);
                    $('#divestado').html(e.vdatap['estado']);
                    $('#divsubtotal').html(e.subtotal);
                    $('#divIgv').html(e.igv);
                    $('#divTotal').html(e.total);
                    //$('.divhide').removeClass('d-none');

                    $('#divcard_details').html(tabla);
                    $('#divobserva').html(e.vdatap['observacion']);
                    
                } else {
                    
                    var msgf = '<span class="text-danger">'+ e.msg +'</span>';
                    $('#divcard_details').html(msgf);
                }

                $('#divcard_bolsa #divoverlay').remove();
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                $('#divcard_bolsa #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    type: 'error',
                    icon: 'error',
                })
            },
        });
        return false;
    }

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
    

    /*function documentospages(pagina){
        var limite = "40";
        var inicio = (pagina - 1) * limite;
        $("#divresult").html('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url :   base_url + "facturacion/fn_filtrar_xsede",
            method: "POST",
            data    :   {inicio:inicio, limite:limite},
            success :   function(e){
                
                $("#divresult").html(e.vdata);
                
            },
            error: function(jqXHR, exception) {
                $("#divresult").html('Ocurrio un error');
            }
        });
        
    }*/
    $("#vw_dp_em_btn_close").click(function(event) {
        $("#divresult").height($("#divresult").height() + $('.divhide').height());
        $(".divhide").removeClass("d-block");
        $(".divhide").addClass("d-none");
    });

    $("#vw_dp_em_btn_consultar_docs_sunat").click(function(event) {
       
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'facturacion/fn_consultar_doc_enviados_a_nube',
            type: 'post',
            dataType: 'json',
            success: function(e) {
                $('#divcard_bolsa #divoverlay').remove();
                $("#frm_search_docpago").submit();
                
            },
            error: function(jqXHR, exception) {
                $('#divcard_bolsa #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divresult').html(msgf);
            }
        });
        return false;
    });

    $("#vw_dp_em_btn_enviar_docs_sunat").click(function(event) {
       
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'facturacion/fn_enviar_doc_pendientes_a_nube',
            type: 'post',
            dataType: 'json',
            success: function(e) {
                $('#divcard_bolsa #divoverlay').remove();
                $("#frm_search_docpago").submit();
                
            },
            error: function(jqXHR, exception) {
                $('#divcard_bolsa #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divresult').html(msgf);
            }
        });
        return false;
    });

    
    $("#modasgmatricula").on('show.bs.modal', function (e) {
        var rel=$(e.relatedTarget);
        var codigo = rel.data('codigo');
        var pagante = rel.data('pagante');
        if (pagante !== "") {

            $('#divmodaladdmat').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + "matricula/fn_get_inscripcion_y_matriculas_x_carne",
                type: 'post',
                dataType: 'json',
                data: {
                    'fgi-txtcarne' : pagante,
                },
                success: function(e) {
                    $('#divmodaladdmat #divoverlay').remove();
                    if (e.existe_inscrito == false) {
                        $('#fgi-apellidos').html('NO ENCONTRADO');

                    } else {
                        $('#fgi-apellidos').html(pagante + "<br>" + e.vdata['paterno'] + ' ' + e.vdata['materno'] + ' ' +  e.vdata['nombres']);
                        var nro=0;
                        $("#vw_fcb_div_Hmatriculas").html("");
                        $.each(e.vmatriculas, function(index, v) {

                            nro++;
                            var btnasignamat = '';
                            var js_estado = v['estado'];

                            btnasignamat = "<button data-periodo='" + v['periodo']  + "' data-semestre='" + v['ciclo']  + "' class='btn btn-sm btn-info btnasignamat' data-codigo='"+codigo+"' data-mat='"+v['codmatricula64']+"'><i class='fas fa-mouse-pointer'></i></button>";

                            $("#vw_fcb_div_Hmatriculas").append(
                                '<div data-idm="' + v['codmatricula64'] + '" class="row cfila rowcolor ">' +
                                '<div class="col-12 col-md-7">' +
                                    '<div class="row">' +
                                        '<div data-cp="' + v['codperiodo'] + '" class="cperiodo col-2 col-md-2 td">' + v['periodo'] + '</div>' +
                                        '<div class="col-5 col-md-5 td text-center">' + v['plan'] + '</div>' +
                                        '<div class="ccarrera col-5 col-md-5 td" data-cod="' + v['codcarrera'] + '">' + v['carrera'] + '</div>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-12 col-md-2">' +
                                    '<div class="row">' +
                                        '<div class="cciclo td col-4 col-md-4 text-center " data-cod="' + v['codciclo'] + '">' + v['ciclo'] + '</div>' +
                                        '<div class="cturno td col-4 col-md-4 text-center ">' + v['codturno'] + '</div>' +
                                        '<div class="cseccion td col-4 col-md-4 text-center ">' + v['codseccion'] + '</div>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-6 col-md-2 td">' +
                                    js_estado +
                                '</div>' +
                                '<div class="col-6 col-md-1 td text-center">' +
                                    btnasignamat +
                                '</div>' +
                            '</div>');
                        });
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divmodaladdmat #divoverlay').remove();
                    $('#divError').show();
                    $('#msgError').html(msgf);
                }
            })
        }
        // return false;
    })

    $("#modasgmatricula").on('hidden.bs.modal', function (e) {
        $('#fgi-apellidos').html('NO ENCONTRADO');
        $("#vw_fcb_div_Hmatriculas").html("");
    })

    $(document).on('click', '.btnasignamat', function(e) {
        e.preventDefault();
        var boton = $(this);
        var codigo = boton.data('codigo');
        var jssemestre = boton.data('semestre');
        
        var jsperiodo = boton.data('periodo');
        var codmat = boton.data('mat');
        $('#divmodaladdmat').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "facturacion/fn_asignar_matricula_doc",
            type: 'post',
            dataType: 'json',
            data: {
                'fgi-txtcodigo' : codigo,
                'fgi-txtmat' : codmat,
            },
            success: function(e) {
                $('#divmodaladdmat #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        title: 'Error!',
                        text: e.msg,
                        type: 'error',
                        icon: 'error',
                        backdrop: false,
                    })
                } else {
                    $('#modasgmatricula').modal('hide');
                    
                    var fila = $('#btnasigmat_'+ codigo).closest('.cfila');
                    fila.find('.txtperiodo').html(jsperiodo +" / "+ jssemestre);
                    Swal.fire({
                        title: 'Éxito!',
                        text: e.msg,
                        type: 'success',
                        icon: 'success',
                        backdrop: false,
                    })
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divmodaladdmat #divoverlay').remove();
                Swal.fire({
                    title: 'Error!',
                    text: msgf,
                    type: 'error',
                    icon: 'error',
                    backdrop: false,
                })
                
            }
        })
    });

    $('.checkradio').on('change', function(e) {
        e.preventDefault();
        var check = "";
        var fecha = new Date();
        var anio = fecha.getFullYear();
        var mes = fecha.getMonth()+1;
        var dia = fecha.getDate();
        var hoy = anio + "-" + ((''+mes).length<2 ? '0' : '') + mes + "-" + ((''+dia).length<2 ? '0' : '') + dia;
        $(".checkradio").each(function(index, el) {
            if ($(this).prop('checked') == true) {
                check = $(this).val();
                if (check == "todo") {
                    $("#fictxtfecha_emision").val("");
                    $("#fictxtfecha_emisionf").val("");
                } else if (check == "hoy") {
                    $("#fictxtfecha_emision").val(hoy);
                    $("#fictxtfecha_emisionf").val(hoy);
                } else if (check == "ayer") {
                    var mesant = ((''+dia) == "1" ? mes-1 : mes);
                    var diant = new Date(anio,mes,dia-1).getDate();
                    var ayer = anio + "-" + ((''+mesant).length<2 ? '0' : '') + mesant + "-" + ((''+diant).length<2 ? '0' : '') + diant;
                    
                    $("#fictxtfecha_emision").val(ayer);
                    $("#fictxtfecha_emisionf").val(ayer);
                }
                else if (check == "mes") {

                    //
                    var factual = new Date();
                    var anio = factual.getFullYear();
                    var mes = ("0"+ (factual.getMonth() + 1) ).slice(-2);
                    var udia= new Date(anio, mes, 0).getDate();
                    $("#fictxtfecha_emision").val(anio + "-" + mes + "-01");
                    $("#fictxtfecha_emisionf").val(anio + "-" + mes + "-" + udia);
                } else if (check == "entre") {
                    /*var uldia= new Date(anio, mes, 0).getDate();
                    var ultimo = anio + "-" + ((''+mes).length<2 ? '0' : '') + mes + "-" + ((''+uldia).length<2 ? '0' : '') + uldia;
                    $("#fictxtfecha_emision").val(anio + "-" + ((''+mes).length<2 ? '0' : '') + mes + "-01");
                    $("#fictxtfecha_emisionf").val(ultimo);*/
                }
            }
        });
        
    });

    function fn_update_pagante_doc(btn) {
        var codigo=btn.data('codigo');
        var fila=btn.closest('.cfila');
        // var docsn=fila.data('docsn');
        //************************************
            
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
                url: base_url + "facturacion/fn_datos_doc_cliente",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_codigo:codigo
                },
                success: function(e) {
                    $('#divcard_bolsa #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR!",
                             text: "SIN RESULTADOS",
                            type: 'error',
                            icon: 'error',
                        })
                        
                    } else {
                        $('#vw_dp_txt_codocument').val(e.vdata['codigo64']);
                        $('#vw_dp_txt_codigpagante').val(e.vdata['pagcod']);
                        $('#vw_dp_txt_tipdocpagante').html(e.tiposdoc);
                        $('#vw_dp_txt_tipdocpagante').val(e.vdata['pgtipodoc']);
                        $('#vw_dp_txt_dnipagante').val(e.vdata['pagnrodoc']);
                        $('#vw_dp_txt_dpagante').val(e.vdata['pagante']);
                        $('#vw_dp_txt_direccion_pag').val(e.vdata['pagdirecion'])
                        $('#modupdatepagante').modal();

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

    $('#vw_dp_em_btnupdate_pag').click(function(e) {
        e.preventDefault();
        $('#frm_update_pagante input,select').removeClass('is-invalid');
        $('#frm_update_pagante .invalid-feedback').remove();
        $('#divmodalupdatepag').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        $.ajax({
            url: base_url + "facturacion/fn_update_datos_pagante",
            type: 'post',
            dataType: 'json',
            data: $('#frm_update_pagante').serialize(),
            success: function(e) {
                $('#divmodalupdatepag #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });

                    Swal.fire({
                        title: 'Error!',
                        text: "Existen errores en los campos",
                        type: 'error',
                        icon: 'error',
                        backdrop: false,
                    })
                } else {
                    Swal.fire({
                        title: 'Éxito!',
                        text: e.msg,
                        type: 'success',
                        icon: 'success',
                        backdrop: false,
                    })
                    $('#modupdatepagante').modal('hide');
                    $("#frm_search_docpago").submit();
                    
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divmodalupdatepag #divoverlay').remove();
                Swal.fire({
                    title: 'Error!',
                    text: msgf,
                    type: 'error',
                    icon: 'error',
                    backdrop: false,
                })
                
            }
        })
        return false;
    });

    var itemsDocumento = {};
    itemsNro = 0;
    function mostrar_montos() {
        //var itemsNro = 0;
        var ops_grav = 0;
        var ops_inaf = 0;
        var ops_exon = 0;
        var ops_expo = 0;
        var dsctos_globales = 0;
        var dsctos_detalles = 0;
        var ops_grat = 0;
        var js_subtotal = 0;
        var js_icbper = 0;
        var js_isc = 0;
        var js_igv = 0;
        //var pigv = 0;
        var js_total = 0;
        // console.log("itemsDocumento", itemsDocumento);
        $.each(itemsDocumento, function(ind, elem) {
            var pu = Number(elem['vw_fcb_ai_txtpreciounitario']);
            var valorventa = Number(elem['vw_fcb_ai_txtcantidad']) * pu;
            if (elem['vw_fcb_ai_cbafectacion'] == "10") {
                //GRAVADO
                valorventa_sinigv = Number(elem['vw_fcb_ai_txtvalorunitario']) * Number(elem['vw_fcb_ai_txtcantidad']);
                ops_grav = ops_grav + valorventa_sinigv;
                js_total = js_total + valorventa;
            } else if (elem['vw_fcb_ai_cbafectacion'] == "30") {
                //INAFECTO
                ops_inaf = ops_inaf + valorventa;
                js_total = js_total + valorventa;
            } else if (elem['vw_fcb_ai_cbafectacion'] == "20") {
                //EXONERADO
                ops_exon = ops_exon + valorventa;
                js_total = js_total + valorventa;
            } else if (elem['vw_fcb_ai_cbafectacion'] == "40") {
                //EXONERADO
                elem['vw_fcb_ai_txtvalorunitario'] = pu;
                elem['vw_fcb_ai_txtprecioventa'] = valorventa;
                ops_inaf = ops_inaf + valorventa;
                js_total = js_total + valorventa;
            } else {
                //GRATUITA
                ops_grat = ops_grat + valorventa;
                //js_total=js_total + valorventa;
            }
        });
        //SUBTOTAL
        js_subtotal = ops_grav + ops_exon + ops_inaf - (dsctos_globales + dsctos_detalles);
        //IGV
        js_igv = Math.round((js_total - js_subtotal - js_isc - js_icbper) * 100) / 100;
        $("#vw_fcb_txtoper_gravada").val(ops_grav);
        $("#vw_fcb_txtoper_inafecta").val(ops_inaf);
        $("#vw_fcb_txtoper_exonerada").val(ops_exon);
        $("#vw_fcb_txtoper_exportacion").val(ops_expo);
        $("#vw_fcb_txtoper_desctotal").val(dsctos_globales + dsctos_detalles);
        $("#vw_fcb_txtoper_gratuitas").val(ops_grat);
        $("#vw_fcb_txtsubtotal").val(js_subtotal);
        $("#vw_fcb_txticbpertotal").val(js_icbper);
        $("#vw_fcb_txtisctotal").val(js_isc);
        $("#vw_fcb_txtigvtotal").val(js_igv);
        $("#vw_fcb_txtsubtotal").val(js_subtotal);
        $("#vw_fcb_txttotal").val(js_total);
        $(".vw_fcb_frmcontrols").each(function() {
            $(this).val(parseFloat($(this).val()).toFixed(2));
        });
    }

    function fn_view_data_doc(btn) {
        var codigo=btn.data('codigo');
        var fila=btn.closest('.cfila');
            
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
                url: base_url + "facturacion/fn_datos_documento_facturacion",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_codigo:codigo
                },
                success: function(e) {
                    $('#divcard_bolsa #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR!",
                             text: "SIN RESULTADOS",
                            type: 'error',
                            icon: 'error',
                        })
                        
                    } else {
                        var estado = e.vdata['estado'];
                        inputstatus = true;
                        if (estado == "PENDIENTE") {
                            inputstatus = false;
                        } else {
                            inputstatus = true;
                        }
                        $('#modupdatedocumento #vw_dp_txt_codocument').val(e.vdata['codigo64']);
                        $('#modupdatedocumento #vw_fcb_txtigvp_up').val(e.vdata['igv']);
                        $('#modupdatedocumento #vw_fcb_serie_up').val(e.vdata['serie']);
                        $('#modupdatedocumento #vw_fcb_tipo_up').val(e.vdata['tdocid']);
                        $('#modupdatedocumento #vw_fcb_sernumero_up').val(e.vdata['numero']).attr('readonly', inputstatus);
                        $('#modupdatedocumento #vw_fcb_emision_up').val(e.vdata['fechaem']).attr('readonly', inputstatus);
                        $('#modupdatedocumento #vw_fcb_emishora_up').val(e.vdata['horaem']).attr('readonly', inputstatus);

                        $('#modupdatedocumento #vw_dp_txt_codigpagante_up').val(e.vdata['pagante']).attr('readonly', inputstatus);
                        $('#modupdatedocumento #vw_dp_txt_tipdocpagante_up').html(e.tiposdoc);
                        $('#modupdatedocumento #vw_dp_txt_tipdocpagante_up').val(e.vdata['ptipodoc']).attr('readonly', inputstatus);
                        $('#modupdatedocumento #vw_dp_txt_dnipagante_up').val(e.vdata['pnrodoc']).attr('readonly', inputstatus);
                        $('#modupdatedocumento #vw_dp_txt_dpagante_up').val(e.vdata['pagantenom']).attr('readonly', inputstatus);
                        $('#modupdatedocumento #vw_dp_txt_direccion_pag_up').val(e.vdata['direccion']).attr('readonly', inputstatus);
                        $('#modupdatedocumento #vw_fcb_txtobservaciones').val(e.vdata['observacion']).attr('readonly', inputstatus);

                        if (e.rscountmatricula > 0) {
                            var matricula = "";
                            matricula = "<option value=''>Sin Asignar</option>";
                            $.each(e.vmatriculas, function(key, mt) {
                                if (mt['estado'] !== '2') {
                                    matricula = matricula + "<option value='" + mt['codigo'] + "'>" + mt['periodo'] + " - " + mt['ciclo'] + "</option>";
                                }

                            });

                        } else {
                            matricula = "<option value=''>Sin Asignar</option>";
                        }

                        $('#modupdatedocumento #vw_fcb_ai_txtcodmatricula').html(matricula);
                        $('#modupdatedocumento #vw_fcb_ai_txtcodmatricula').val(e.vdata['matriculaid']);

                        pigv = e.vseries['igvpr'];
                        pigv = Number(pigv) / 100;
                        itemsNro = 0;
                        $.each(e.vdetail, function(index, v) {
                            var itemd = {};
                            itemd['vw_fcb_ai_cbunidad'] = v['undid']

                            //llenar gestion
                            itemd['vw_fcb_ai_cbgestion'] = v['gestid'];
                            itemd['vw_fcb_ai_txtgestion'] = v['gestion'];
                            // console.log(itemd)
                            
                            itemd['vw_fcb_ai_txtcantidad'] = v['cantidad'];
                            itemd['vw_fcb_ai_txtpreciounitario'] = v['unitariov'];
                            itemd['vw_fcb_ai_txtprecioventa'] = v['ventaval'];
                            itemd['vw_fcb_ai_txtcoddeuda'] = v['deudaid'];
                            itemd['vw_fcb_ai_txtcodmatricula_det'] = v['codmat'];
                            itemd['vw_fcb_ai_cod_detalle'] = v['cod64det'];

                            itemd['vw_fcb_ai_cbiscfactor'] = v['dfactor'];
                            itemd['vw_fcb_ai_cbafectaigv'] = v['igvafect'];

                            itemd['vw_fcb_ai_txtiscvalor'] = v['iscvalor'];
                            itemd['vw_fcb_ai_txtiscbase'] = v['iscbimp'];
                            itemd['vw_fcb_ai_txtdsctvalor'] = v['dvalor'];
                            itemd['vw_fcb_ai_cbdsctfactor'] = v['dfactor'];
                            itemd['vw_fcb_ai_cbtipoitem'] = v['tipoitem'];
                            itemd['vw_fcb_ai_cbgratis'] = v['esgratis'];

                            itemd['vw_fcb_ai_cbafectacion'] = v['tafigv'];

                            var pu = Number(itemd['vw_fcb_ai_txtpreciounitario']);
                            var valorventa = Number(itemd['vw_fcb_ai_txtcantidad']) * pu;
                            if (itemd['vw_fcb_ai_cbafectacion'] == "10") {
                                //GRAVADO
                                itemd['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
                                itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                                
                            } else if (itemd['vw_fcb_ai_cbafectacion'] == "30") {
                                //INAFECTO
                                itemd['vw_fcb_ai_txtvalorunitario'] = pu;
                                itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                                
                            } else if (itemd['vw_fcb_ai_cbafectacion'] == "20") {
                                //EXONERADO
                                itemd['vw_fcb_ai_txtvalorunitario'] = pu;
                                itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                                
                            } else if (itemd['vw_fcb_ai_cbafectacion'] == "40") {
                                //EXONERADO
                                itemd['vw_fcb_ai_txtvalorunitario'] = pu;
                                itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                                
                            } else {
                                //GRATUITA
                                itemd['vw_fcb_ai_txtvalorunitario'] = pu;
                                itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                                
                            }

                            var row = $("#vw_fcb_rowitem").clone();
                            row.attr('id', 'vw_fcb_rowitem' + itemsNro);
                            row.data('arraypos', itemsNro);
                            itemsDocumento[itemsNro] = itemd;
                            itemsNro++;
                            row.find('input,select').each(function(index, el) {
                                if ($(this).attr('name') == "vw_fcb_ai_txtcodmatricula_det") {
                                    $(this).html(matricula);
                                }
                                if ($(this).hasClass('divcard_campos_read')) {
                                    $(this).attr('readonly', inputstatus);
                                }

                                $(this).val(itemd[$(this).attr('name')]);
                            });

                            row.show();
                            $('#divcard_detail_doc').append(row);
                            
                        })
                        mostrar_montos();
                        $('#modupdatedocumento').modal();

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

    $("#modupdatedocumento").on('hidden.bs.modal', function (e) {
        $('#divcard_detail_doc .rowcolor').remove();
        $.each(itemsDocumento, function(ind, elem) {
            delete itemsDocumento[ind];
            mostrar_montos();
        })
        
    })

    function fn_update_concepto(txt) {

        var fila = txt.closest('.rowcolor');
        var pos = fila.data('arraypos');
        var concepto = fila.find('input[name="vw_fcb_ai_txtgestion"]').val();
        itemsDocumento[pos]['vw_fcb_ai_txtgestion'] = concepto;
        // console.log("itemsDocumento", itemsDocumento);
    }

    function fn_update_precios(txt) {

        var fila = txt.closest('.rowcolor');
        var pos = fila.data('arraypos');

        var pu = Number(fila.find('input[name="vw_fcb_ai_txtpreciounitario"]').val());
        itemsDocumento[pos]['vw_fcb_ai_txtpreciounitario'] = pu;
        var vcnt = fila.find('input[name="vw_fcb_ai_txtcantidad"]').val();
        var valorventa = Number(vcnt) * pu;
        itemsDocumento[pos]['vw_fcb_ai_txtcantidad'] = vcnt;

        var afectacion = itemsDocumento[pos]['vw_fcb_ai_cbafectacion'];
        console.log("IGV",pigv);
        if (afectacion == "10") {
            //GRAVADO
            itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
            itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
        } else if (afectacion == "30") {
            //INAFECTO
            itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
            itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
        } else if (afectacion == "20") {
            //EXONERADO
            itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
            itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
        } else if (afectacion == "40") {
            //EXONERADO
            itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
            itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
        } else {
            //GRATUITA
            itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
            itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
        }

        fila.find('input[name="vw_fcb_ai_txtprecioventa"]').val(valorventa);
        console.log("itemsDocumento", itemsDocumento)

        mostrar_montos();
    }

    function fn_update_cod_deuda(txt) {

        var fila = txt.closest('.rowcolor');
        var pos = fila.data('arraypos');
        var coddeuda = fila.find('input[name="vw_fcb_ai_txtcoddeuda"]').val();
        itemsDocumento[pos]['vw_fcb_ai_txtcoddeuda'] = coddeuda;
    }

    function fn_update_cod_matricula_deta(txt) {

        var fila = txt.closest('.rowcolor');
        var pos = fila.data('arraypos');
        // var codigomat = fila.find('input[name="vw_fcb_ai_txtcodmatricula_det"] option:selected').val();
        var codigomat = txt.val();
        console.log("codigomat", codigomat);
        itemsDocumento[pos]['vw_fcb_ai_txtcodmatricula_det'] = codigomat;
        console.log("itemsDocumento", itemsDocumento);
    }

    $("#vw_dp_em_btnupdate_docum").click(function(e) {
        e.preventDefault();
        // modmatricula = false;
        // $('#divdata_detalle input[name="vw_fcb_ai_cbgestion"]').each(function() {
        //     campo = $(this).val();
        //     if ((campo == "01.01") || (campo == "01.02") || (campo == "01.03")) {
        //         modmatricula = true;
        //     }
        // })
        if ($('#vw_dp_txt_dnipagante_up').val() == "") {
            Swal.fire(
                'Cliente!',
                "Debes indicar un cliente registrado",
                'warning'
            );
            return false;
        }
        //alert(itemsDocumento.size();)
        if (($.isEmptyObject(itemsDocumento)) || (itemsDocumento.length == 0)) {
            Swal.fire(
                'Items!',
                "Se necesitan Items para generar un documento de pago",
                'warning'
            );
            return false;
        }
        $('#divmodalupdatedocum').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('input:text,select').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        // $('.vw_fcb_frmcontrols').attr('readonly', false);
        // $('.vw_fcb_class_rowitem input,select').attr('readonly', false);
        
        var formData = new FormData($("#frm_update_documento")[0]);
        formData.append('vw_fcb_items', JSON.stringify(itemsDocumento));
        
        $.ajax({
            url: base_url + 'facturacion/fn_actualizar_docpago',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(e) {
                $('#divmodalupdatedocum #divoverlay').remove();
                if (e.status == true) {
                    // if (modmatricula == true) {
                        
                    //     datos_carne($('#vw_fcb_codpagante').val(), e.coddocpago);
                    // }
                    Swal.fire(
                        'Exito!',
                        'Los datos fueron actualizados correctamente.',
                        'success'
                    );
                    $("#modupdatedocumento").modal('hide');

                } else {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                    // $('.vw_fcb_frmcontrols').attr('readonly', true);
                    // $('.vw_fcb_class_rowitem input,select').attr('readonly', true);

                    Swal.fire(
                        'Error!',
                        e.msg,
                        'error'
                    )
                }
            },
            error: function(jqXHR, exception) {
                $('#divmodalupdatedocum #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                    'Error!',
                    msgf,
                    'error'
                )
            }
        });
        return false;
    });
        
</script>
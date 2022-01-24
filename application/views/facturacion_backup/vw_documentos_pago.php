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

	<section id="s-cargado" class="content pt-1">
		<div id="divcard_bolsa" class="card h-100 my-0">
		    <div class="card-header">
		    	<h3 class="card-title text-bold"><i class="fas fa-list-ul mr-1"></i> Documentos de Pago Emitidos</h3>
                
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
                        <div class="form-group col-md-1 col-3">
                            <div class="form-check">
                                <input class="form-check-input checkradio" value="todo" type="radio" name="radio1" id="radioall">
                                <label class="form-check-label" for="radioall">Todo</label>
                            </div>
                        </div>
                        <div class="form-group col-md-1 col-3">
                            <div class="form-check">
                                <input checked="" class="form-check-input checkradio" value="hoy" type="radio" name="radio1" id="radiohoy">
                                <label class="form-check-label" for="radiohoy">Hoy</label>
                            </div>
                        </div>
                        <!-- <div class="form-group col-md-1 col-3">
                            <div class="form-check">
                                <input class="form-check-input checkradio" value="ayer" type="radio" name="radio1" id="radioayer">
                                <label class="form-check-label" for="radioayer">Ayer</label>
                            </div>
                        </div> -->
                        <div class="form-group col-md-1 col-3">
                            <div class="form-check">
                                <input class="form-check-input checkradio" value="entre" type="radio" name="radio1" id="radioentre">
                                <label class="form-check-label" for="radioentre">Entre</label>
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
        var factual = new Date();
        var anio = factual.getFullYear();
        var mes = ("0"+ (factual.getMonth() + 1) ).slice(-2);
        var udia= new Date(anio, mes, 0).getDate();
        $("#fictxtfecha_emision").val(anio + "-" + mes + "-01");
        $("#fictxtfecha_emisionf").val(anio + "-" + mes + "-" + udia);
        //$("#fictxtfecha_emisionf").val("01/" + mes + "/" + anio);
        //alert("ddd");
        $(".checkradio").each(function(index, el) {
            if ($(this).prop('checked') == true) {
                check = $(this).val();
                var dia = factual.getDate();
                var hoy = anio + "-" + mes + "-" + ((''+dia).length<2 ? '0' : '') + dia;
                if (check == "hoy") {
                    $("#fictxtfecha_emision").val(hoy);
                    $("#fictxtfecha_emisionf").val(hoy);
                }
            }
        })
        paginaciondocum('<?php echo $numitems ?>');
        $("#s-cargado").height($(".content-wrapper").height()-30);
        cssh=$("#divcard_bolsa .card-body ").height() - $("#frm_search_docpago").height() - 100;

        
        //alert(cssh );
        $("#divresult").height(cssh);
        valto=cssh;
        $(".divhide").removeClass("d-block");
        $(".divhide").addClass("d-none");

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
                } else if (check == "entre") {
                    var uldia= new Date(anio, mes, 0).getDate();
                    var ultimo = anio + "-" + ((''+mes).length<2 ? '0' : '') + mes + "-" + ((''+uldia).length<2 ? '0' : '') + uldia;
                    $("#fictxtfecha_emision").val(anio + "-" + ((''+mes).length<2 ? '0' : '') + mes + "-01");
                    $("#fictxtfecha_emisionf").val(ultimo);
                }
            }
        });
        
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

    function fn_showdetail(codigo) {
        $('#divcard_bolsa').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        //alert($("#divresult").height());
        //alert($(".divhide").height());
        
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
    
    
</script>
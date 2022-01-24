<?php
$vbaseurl=base_url();
date_default_timezone_set ('America/Lima');
$fecha = date('Y-m-d');
$hora = date('H:i');
?>
<style type="text/css">

.vw_fcb_frmcontrols{
    text-align: right;
}
/*.inputsb{
border-width:  0 0 1px 0;
padding-bottom: 0px !important;
}*/
</style>
<div class="content-wrapper">




    <!-- FIN MODAL BUSCAR PAGANTE -->
    <!-- AGREGAR MODAL ITEM -->
    <div class="modal fade" id="modadditem" tabindex="-1" role="dialog" aria-labelledby="modadditem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodalitem">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_tititem">Agregar detalle</h5>

                    <button type="button"class="close"  data-toggle="collapse" href="#vw_fcb_ai_divconfiguraciones" role="button" aria-expanded="false" aria-controls="vw_fcb_ai_divconfiguraciones">
                    <span aria-hidden="true"><i class="fas fa-cog"></i></span>
                    </button>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="vw_fcb_ai_divbody">
                    
                    
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-5">
                            <select name="vw_fcb_ai_cbgestion" id="vw_fcb_ai_cbgestion" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='0'>Seleccionar</option>
                                <?php
                                foreach ($gestion as $key => $gs) {
                                echo "<option data-unidad='$gs->codunidad' data-afectacion='$gs->codtipafecta' data-afecta='$gs->afecta' value='$gs->codigo' >$gs->gestion</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbgestion">Gestión</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbunidad" id="vw_fcb_ai_cbunidad" class="form-control control form-control-sm text-sm inputsb">
                                <?php
                                foreach ($unidad as $key => $und) {
                                echo "<option  value='$und->codigo' >$und->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbunidad">Unidad</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input autocomplete="off" type="text" name="vw_fcb_ai_txtcantidad" id="vw_fcb_ai_txtcantidad" placeholder="Cantidad" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtcantidad">Cantidad</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input autocomplete="off" type="text" name="vw_fcb_ai_txtpreciounitario" id="vw_fcb_ai_txtpreciounitario" placeholder="Monto" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtpreciounitario">Monto</label>
                        </div>
                        <!--AFECTACIÓN-->
                    </div>
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-4">
                            <select name="vw_fcb_ai_cbafectacion" id="vw_fcb_ai_cbafectacion" class="form-control control form-control-sm text-sm inputsb">
                                
                                <?php
                                foreach ($afectacion as $key => $af) {
                                echo "<option  value='$af->codigo' >$af->info $af->codigo  $af->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbafectacion">Tipo de Afectación</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input readonly autocomplete="off" type="text" name="vw_fcb_ai_txtcoddeuda" id="vw_fcb_ai_txtcoddeuda" placeholder="Monto" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtcoddeuda">Cod. Deuda</label>
                        </div>
                        
                    </div>
                    <div class="collapse d-none" id="vw_fcb_ai_divconfiguraciones">
                      <div class="card card-body">
                        <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-5">
                            <select name="vw_fcb_ai_cbtipoitem" id="vw_fcb_ai_cbtipoitem" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='SERVICIO'>Servicio</option>
                                <option  value='BIEN'>Bien</option>
                            </select>
                            <label for="vw_fcb_ai_cbtipoitem">Tipo</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbafectaigv" id="vw_fcb_ai_cbafectaigv" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='GRAVADO'>GRAVADO</option>
                                <option  value='EXONERADO'>EXONERADO</option>
                                <option  value='INAFECTO'>INAFECTO</option>
                            </select>
                            <label for="vw_fcb_ai_cbafectaigv">Afectación</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbgratis" id="vw_fcb_ai_cbgratis" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='NO'>NO</option>
                                <option  value='SI'>SI</option>
                                
                                
                            </select>
                            <label for="vw_fcb_ai_cbgratis">Operación Gratuita</label>
                        </div>
                        
                    </div>
                    <hr>
                    <!--ISC-->
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbisc" id="vw_fcb_ai_cbisc" class="form-control control form-control-sm text-sm inputsb">
                                <option  value=''>Seleccionar</option>
                                <?php
                                foreach ($iscs as $key => $isc) {
                                echo "<option  value='$isc->codigo' >$isc->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbisc">ISC</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input type="text" name="vw_fcb_ai_txtiscvalor" id="vw_fcb_ai_txtiscvalor" placeholder="Impuesto" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtiscvalor">Impuesto</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbiscfactor" id="vw_fcb_ai_cbiscfactor" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='1'>Soles</option>
                                <option  value='100'>%</option>
                                
                            </select>
                        </div>
                        <div id="vw_fcb_ai_diviscbase" class="form-group has-float-label col-12 col-md-2">
                            <input type="text" name="vw_fcb_ai_txtiscbase" id="vw_fcb_ai_txtiscbase" placeholder="Base Imponible" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtiscbase">Base Imponible</label>
                        </div>
                    </div>
                    
                    <!--DESCUENTO-->
                    <div class="row pt-2 d-none">
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input type="text" name="vw_fcb_ai_txtdsctvalor" id="vw_fcb_ai_txtdsctvalor" placeholder="Impuesto" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtdsctvalor">Descuento</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbdsctfactor" id="vw_fcb_ai_cbdsctfactor" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='1'>Soles</option>
                                <option  value='100'>%</option>
                                
                            </select>
                        </div>
                        
                    </div>
                    
                    
                      </div>
                    </div>
                    <hr>
                    
                    <div class="row pt-2">
                        
                        <div class="form-group has-float-label col-12">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button id="vw_fcb_ai_btnagregar" type="button" class="btn btn-primary float-right">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL AGREGAR ITEM -->
    <!-- BUSCAR MODAL ITEM -->

    <!-- FIN MODAL BUSCAR ITEM -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    
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
                <h3 class="text-primary"><?php echo $tipol; ?></h3>
                <form id="vw_fcb_frmboleta" action="" method="post" accept-charset="utf-8">
                    <div class="row mt-2">
                        
                        <div class="input-group input-group-sm col-md-3">
                            <input type="hidden" name="vw_fcb_tipo" id="vw_fcb_tipo" value="<?php echo trim($docserie->tipo) ?>">
                            <input readonly type="text" class="form-control " placeholder="Serie" name="vw_fcb_serie" id="vw_fcb_serie" value="<?php echo $docserie->serie ?>">
                            <input readonly type="text" class="form-control " placeholder="N°" name="vw_fcb_sernumero" id="vw_fcb_sernumero" value="<?php echo $docserie->contador ?>">
                            <input type="text" class="form-control " placeholder="N°" name="vw_fcb_sernumero_real" id="vw_fcb_sernumero_real" value="0">
                            <div class="input-group-append">
                                <button id="vw_fcb_btnedit_numero" data-accion="auto" class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt"></i></button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            
                        </div>
                        <div class="input-group input-group-sm col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Emisión: </span>
                            </div>
                            <input type="date" class="form-control " name="vw_fcb_emision" id="vw_fcb_emision" value="<?php echo $fecha ?>">
                            <input type="time" class="form-control " name="vw_fcb_emishora" id="vw_fcb_emishora" value="<?php echo $hora ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-2">
                         <input type="hidden" name="vw_fcn_tipo" id="vw_fcn_tipo" value="">
                            <input readonly type="hidden" class="form-control " placeholder="Serie" name="vw_fcn_serie" id="vw_fcn_serie" value="">
                            <input readonly type="hidden" class="form-control " placeholder="N°" name="vw_fcn_sernumero" id="vw_fcn_sernumero" value="">
                        <div class="form-group has-float-label col-12 col-md-2">
                            <select name="vw_fcb_cbtipo_operacion51" id="vw_fcb_cbtipo_operacion51" class="form-control  control form-control-sm text-sm inputsb">
                                <?php
                                foreach ($tipoopera51 as $key => $tpop51) {
                                $opera51sel=($docserie->codoperacion51==$tpop51->codopera51)?"selected":"";
                                echo "<option $opera51sel value='$tpop51->codopera51' >$tpop51->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_cbtipo_operacion51">Operación</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <input autocomplete="off"  name="vw_fcb_txtigvp" id="vw_fcb_txtigvp" type="text" class="form-control  form-control-sm text-sm inputsb" placeholder="IGV %" value="<?php echo $docserie->igvpr ?>">
                            <label for="vw_fcb_txtigvp">IGV %</label>
                        </div>
                        
                        <div class="form-group has-float-label col-md-3">
                            <select name="vw_fcb_cbtiponota" id="vw_fcb_cbtiponota" class="form-control  control form-control-sm text-sm inputsb">
                                <?php
                                foreach ($tiponota as $key => $tpnt) {
                                echo "<option value='$tpnt->codigo' data-lgt='$tpnt->longitud'>$tpnt->nombre</option>";
                                }
                                ?>
                                
                            </select>
                            <label for="vw_fcb_cbtiponota">Tipo Nota</label>
                        </div>
                        
                      
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary" id="">Doc. Afectado: </span>
                                </div>
                                <input type="text" class="form-control  text-uppercase text-bold" name="vw_fcb_docafectado" id="vw_fcb_docafectado">
                                <div class="input-group-append">
                                    <button id="vw_fnt_btnbuscardoc" class="btn btn-outline-primary " type="button" id="button-addon2">
                                    Aplicar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <div class="row mt-3 vw_fcb_divdatosfactura">
                        <div class="form-group has-float-label col-12">
                            <input type="text" name="vw_fcb_motivonota" id="vw_fcb_motivonota" placeholder="Motivo o Sustento" class="form-control control form-control-sm text-sm text-uppercase inputsb">
                            <label for="vw_fcb_motivonota">Motivo o Sustento</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input type="text" name="vw_fcb_cbtipodoc" id="vw_fcb_cbtipodoc" readonly class="form-control  control form-control-sm text-sm inputsb">
                                
                                
                            
                            <label for="vw_fcb_cbtipodoc">Tipo doc.</label>
                        </div>
                        
                        <div class="form-group has-float-label col-12 col-md-3">
                            <input autocomplete="off"  readonly name="vw_fcb_txtnrodoc" id="vw_fcb_txtnrodoc" type="text" class="form-control  form-control-sm text-sm inputsb" placeholder="N° Documento">
                            <label for="vw_fcb_txtnrodoc">N° Documento</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="row">
                                <input readonly autocomplete="off" type="text" name="vw_fcb_codpagante" id="vw_fcb_codpagante" class="col-3 form-control form-control-sm text-sm inputsb">
                                <input readonly autocomplete="off" name="vw_fcb_txtpagante" id="vw_fcb_txtpagante" type="text" class="col-9 form-control form-control-sm text-sm inputsb" placeholder="Cliente">
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group has-float-label col-12 col-md-12">
                            <input readonly name="vw_fcb_txtdireccion" id="vw_fcb_txtdireccion" type="text" class="form-control  form-control-sm text-sm inputsb" placeholder="Dirección">
                            <label for="vw_fcb_txtdireccion">Dirección</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input readonly name="vw_fcb_txtemail1" id="vw_fcb_txtemail1" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 1">
                            <label for="vw_fcb_txtemail1">Correo 1</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input readonly name="vw_fcb_txtemail2" id="vw_fcb_txtemail2" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 2">
                            <label for="vw_fcb_txtemail2">Correo 2</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input readonly name="vw_fcb_txtemail3" id="vw_fcb_txtemail3" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 3">
                            <label for="vw_fcb_txtemail3">Correo 3</label>
                        </div>
                    </div>
                    <div class="row mt-3 vw_fcb_divdatosfactura" id="divcard_detalle">
                        <div class="col-12">
                            <div class="card border border-secondary ">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h4>Detalle</h4>
                                    </div>
                                    <div class="no-padding card-tools">
                                       
                                        <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modadditem">
                                            <i class="fas fa-plus mr-1"></i>  item
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body pt-0" id="divdata_detalle">
                                    <div class="row text-bold">
                                        <span class="text-sm col-1">Und.</span>
                                        <span class="text-sm col-1">Cód.</span>
                                        <span class="text-sm col-4">Concepto</span>
                                        <span class="text-sm col-1">Cant.</span>
                                        <span class="text-sm col-1">P.U</span>
                                        <span class="text-sm col-1">Monto</span>
                                        <span class="text-sm col-1">Cod.Deud</span>
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
                        
                        <div class="col-12 py-2">
                            <div id="vw_pw_bt_ad_divmsgbolsa" class="text-danger">
                            </div>
                        </div>
                        <div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
                            <a role='button' type="button" href="#" id="vw_pw_bt_ad_btn_guardar" class="btn btn-primary btn-md float-right">
                                <i class="fas fa-save"></i> Guardar
                            </a>
                        </div>
                    </div>
                </form>
                <div class="card col-12 text-center" id="divcard_resultfin">
                    <div class="card-body text-center">
                        <br>
                        <span>Se ha generado un nuevo documento identifcado con:</span><br><br>
                        <h2 id="vw_fcb_fin_numero">F001-00000003</h2><br>
                        
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                <a id="vw_fcb_fin_ticket" target="_blank" class="btn btn-primary btn-lg  d-block" href="#">
                                    <i class="fas fa-print mr-1"></i> Impresión
                                </a>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                <a id="vw_fcb_fin_pdf" target="_blank" class="btn btn-info btn-lg d-block" href="#">
                                    <i class="far fa-file-pdf mr-1"></i> Representación Digital (PDF)
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                <a class='btn btn-info btn-lg d-block d-primary' href='<?php echo $vbaseurl ?>tesoreria/facturacion/crear-documento?tp=boleta'>Nueva Boleta</a>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                
                                <a class='btn btn-info btn-lg d-block d-primary' href='<?php echo $vbaseurl ?>tesoreria/facturacion/crear-documento?tp=boleta'>Nueva Factura</a>
                            </div>
                            
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                <a class='btn btn-info btn-lg d-block d-primary' href='<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago'>Ir a documentos de Pago</a>
                            </div>
                            </div>
                        </div>
                        <br>
                        

                       
                        <br>
                        
                        <br><br>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</div>
<div id="vw_fcb_rowitem" class="row rowcolor vw_fcb_class_rowitem" data-arraypos="-1">
    <div class="col-12 col-md-1 p-0">
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
        <input autocomplete="off" type="text"  onchange="fn_update_concepto($(this));return false" name="vw_fcb_ai_txtgestion" placeholder="Gestion" class="form-control form-control-sm text-sm">
    </div>
    <div class="col-12 col-md-1 p-0">
        <input autocomplete="off" onkeyup="fn_update_precios($(this));return false" onchange="fn_update_precios($(this));return false" type="number" name="vw_fcb_ai_txtcantidad"  placeholder="Cantidad" class="form-control form-control-sm text-sm text-right">
    </div>

    <div class="col-12 col-md-1 p-0">
        <input autocomplete="off" onkeyup="fn_update_precios($(this));return false" onchange="fn_update_precios($(this));return false" type="number" name="vw_fcb_ai_txtpreciounitario"  placeholder="pu" class="form-control form-control-sm text-sm text-right">
    </div>
    <div class="col-12 col-md-1 p-0">
        <input readonly type="text" name="vw_fcb_ai_txtprecioventa"  placeholder="pv" class="form-control form-control-sm text-sm text-right">
    </div>
    <div class="col-12 col-md-1 p-0">
        <input readonly type="text"  name="vw_fcb_ai_txtcoddeuda" class="form-control form-control-sm text-sm">
    </div>
    <div class="col-12 col-md-1 p-0">
        <a class="btn btn-danger btn-sm" onclick="fn_removeitem($(this));return false" href="#"><i class="fas fa-minus-circle"></i></a>
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
<script type="text/javascript" src="<?php echo base_url() ?>resources/dist/js/pages/pagante_21_07_16.js"></script>
<script type="text/javascript">
var itemsDocumento =  {};
var itemsNro = 0;
/*var ops_grav = 0;
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
var pigv = 0;
var js_total=0;*/
//Math.round((data / 1.19 * 100 )) / 100
$(document).ready(function() {
    $('#vw_fcb_ai_diviscbase').hide();
    $(".div_dctoglobal").hide();
    $(".vw_fcb_divdatosfactura").hide();
    $("#divcard_resultfin").hide();
    $("#vw_fcb_rowitem").hide();
    
    $("#vw_fcb_sernumero_real").hide();
    
    if ($("#vw_fcb_tipo").val()=="BL"){
        $("#vw_fcb_btnedit_numero").show();    
    }
    else{
        $("#vw_fcb_btnedit_numero").hide();    
    }
    


    $("#vw_fcb_txtnrodoc").focus();
    pigv = <?php echo $docserie->igvpr ?>;
    pigv = Number(pigv) / 100;
});
//vw_fcb_chk_dsct_global
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
    var js_total=0;
    
    $.each(itemsDocumento, function (ind, elem) { 
        var pu = Number(elem['vw_fcb_ai_txtpreciounitario']);
        var valorventa=Number(elem['vw_fcb_ai_txtcantidad']) * pu;

        if (elem['vw_fcb_ai_cbafectacion'] == "10") {
            //GRAVADO
            //elem['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
            valorventa_sinigv=Number(elem['vw_fcb_ai_txtvalorunitario']) * Number(elem['vw_fcb_ai_txtcantidad']);
            //elem['vw_fcb_ai_txtprecioventa'] = valorventa;
            ops_grav = ops_grav + valorventa_sinigv;
            js_total=js_total + valorventa;

        } else if (elem['vw_fcb_ai_cbafectacion'] == "30") {
            //INAFECTO
            //elem['vw_fcb_ai_txtvalorunitario'] = pu;
            //elem['vw_fcb_ai_txtprecioventa'] = valorventa;
            ops_inaf = ops_inaf + valorventa;
            js_total=js_total + valorventa;

        } else if (elem['vw_fcb_ai_cbafectacion'] == "20") {
            //EXONERADO
            //elem['vw_fcb_ai_txtvalorunitario'] = pu;
            //elem['vw_fcb_ai_txtprecioventa'] =valorventa;
            ops_exon = ops_exon +  valorventa;
            js_total=js_total + valorventa;

        } else if (elem['vw_fcb_ai_cbafectacion'] == "40") {
            //EXONERADO
            elem['vw_fcb_ai_txtvalorunitario'] = pu;
            elem['vw_fcb_ai_txtprecioventa'] =valorventa;
            ops_inaf = ops_inaf +  valorventa;
            js_total=js_total + valorventa;

        } else {
            //GRATUITA
            //elem['vw_fcb_ai_txtvalorunitario'] = pu;
            //elem['vw_fcb_ai_txtprecioventa'] =valorventa;
            ops_grat = ops_grat +  valorventa;
            //js_total=js_total + valorventa;

        }
    });
    //OPERACION GRAVADA, INAFECTA Y EXONERADA

    //DESCUENTO GLOBAL
    /*if ($("#vw_fcb_chk_dsct_global").is(':checked')) {
        $(".div_dctoglobal").show();
        var jvdctofactor = $("#vw_fcb_cbdsctglobalfactor").val();
        var jvdctovalor = $("#vw_fcb_txt_dsct_general").val();
        jvdctofactor = Number(jvdctofactor);
        jvdctovalor = Number(jvdctovalor);
        //alert(jvdctofactor);
        if (jvdctofactor == "1") {
            dsctos_globales = jvdctovalor;
            //$("#vw_fcb_cbdsctglobalmontobase_final").val(jvdctovalor);
        } else {
            //comprobar si la afectacion es a la base imponible
            //para este caso asumire que es no afecto a la base imponible
            jvdctofactor = Number(jvdctovalor) / 100;
            dsctos_globales = Math.round((ops_grav * jvdctofactor) * 100) / 100;
            //$("#vw_fcb_cbdsctglobalmontobase_final").val(ops_grav);
        }
        dsctos_globales_igv=dsctos_globales * 
        $("#vw_fcb_cbdsctglobalfactor_final").val(jvdctofactor);
        $("#vw_fcb_txtoper_desctotal").val(dsctos_globales + dsctos_detalles);
        //js_subtotal=ops_grav + ops_exon + ops_inaf - dsctos_globales;
        js_total=js_total - (dsctos_globales)
        

    } else {
        $(".div_dctoglobal").hide();
        dsctos_globales = 0;
    }*/

    //SUBTOTAL
    js_subtotal = ops_grav + ops_exon + ops_inaf - (dsctos_globales + dsctos_detalles);
    //IGV
    js_igv = Math.round((js_total - js_subtotal - js_isc - js_icbper) * 100) / 100;
    //js_igv = Math.round(((ops_grav - dsctos_globales - dsctos_detalles) * pigv * 100)) / 100

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
    $(".vw_fcb_frmcontrols").each(function(){
        $(this).val(parseFloat($(this).val()).toFixed(2));
    });
}
$("#vw_fcb_chk_dsct_global,#vw_fcb_cbdsctglobalfactor").change(function(event) {
    mostrar_montos();
});

$("#vw_fcb_ai_btnagregar").click(function(event) {
    event.preventDefault();
    $('#vw_fcb_ai_divbody .modal-body input,select').removeClass('is-invalid');
    $('#vw_fcb_ai_divbody .modal-body .invalid-feedback').remove();
    
 
    if ($('#vw_fcb_ai_cbgestion').val()=="0"){
        $('#vw_fcb_ai_cbgestion').addClass('is-invalid');
        $('#vw_fcb_ai_cbgestion').parent().append("<div class='invalid-feedback'>Selecciona un Item</div>");
        return false;
    }
    //var txtcnt=Number($("#vw_fcb_ai_txtcantidad").val())
    if (!$.isNumeric($("#vw_fcb_ai_txtcantidad").val())){
        $("#vw_fcb_ai_txtcantidad").addClass('is-invalid');
        $("#vw_fcb_ai_txtcantidad").parent().append("<div class='invalid-feedback'>Corregir</div>");
        return false;
    }
    //var txtpu=Number($("#vw_fcb_ai_txtpreciounitario").val())
    if (!$.isNumeric( $("#vw_fcb_ai_txtpreciounitario").val() )){
        $("#vw_fcb_ai_txtpreciounitario").addClass('is-invalid');
        $("#vw_fcb_ai_txtpreciounitario").parent().append("<div class='invalid-feedback'>Corregir</div>");
        return false;
    }
    //TERMINA LA VALIDACIÓN
    var itemd = {};
    $("#vw_fcb_ai_divbody input,select").each(function() {
        itemd[$(this).attr('id')] = $(this).val();
    });
 

    //llenar gestion
    itemd['vw_fcb_ai_txtgestion'] = $("#vw_fcb_ai_cbgestion option:selected").text();

    var pu = Number(itemd['vw_fcb_ai_txtpreciounitario']);
    var valorventa=Number(itemd['vw_fcb_ai_txtcantidad']) * pu;

        if (itemd['vw_fcb_ai_cbafectacion'] == "10") {
            //GRAVADO
            itemd['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
            //valorventa_sinigv=Number(itemd['vw_fcb_ai_txtvalorunitario']) * Number(itemd['vw_fcb_ai_txtcantidad']);
            itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
            //ops_grav = ops_grav + valorventa_sinigv;
            //js_total=js_total + valorventa;

        } else if (itemd['vw_fcb_ai_cbafectacion'] == "30") {
            //INAFECTO
            itemd['vw_fcb_ai_txtvalorunitario'] = pu;
            itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
            //ops_inaf = ops_inaf + valorventa;
            //js_total=js_total + valorventa;

        } else if (itemd['vw_fcb_ai_cbafectacion'] == "20") {
            //EXONERADO
            itemd['vw_fcb_ai_txtvalorunitario'] = pu;
            itemd['vw_fcb_ai_txtprecioventa'] =valorventa;
            //ops_exon = ops_exon +  valorventa;
            //js_total=js_total + valorventa;

        } else if (itemd['vw_fcb_ai_cbafectacion'] == "40") {
            //EXONERADO
            itemd['vw_fcb_ai_txtvalorunitario'] = pu;
            itemd['vw_fcb_ai_txtprecioventa'] =valorventa;
            //ops_inaf = ops_inaf +  valorventa;
            //js_total=js_total + valorventa;

        } else {
            //GRATUITA
            itemd['vw_fcb_ai_txtvalorunitario'] = pu;
            itemd['vw_fcb_ai_txtprecioventa'] =valorventa;
            //ops_grat = ops_grat +  valorventa;
            //js_total=js_total + valorventa;

        }
    
    

    

    var row = $("#vw_fcb_rowitem").clone();
    row.attr('id', 'vw_fcb_rowitem' + itemsNro);
    row.data('arraypos', itemsNro);
    itemsDocumento[itemsNro]=itemd;
    itemsNro++;
    row.find('input,select').each(function(index, el) {
        $(this).val(itemd[$(this).attr('name')]);
    });
    row.show();

    

    $('#divdata_detalle').append(row);
    
    mostrar_montos();
    $('#vw_fcb_ai_cbgestion').val("0");
    $('#vw_fcb_ai_txtcantidad').val("1");
    $('#vw_fcb_ai_txtpreciounitario').val("");
    $("#modadditem").modal("hide");

});
$("#vw_fcb_txt_dsct_general").blur(function(event) {
    mostrar_montos();
});

$('#vw_fcb_ai_cbgestion').change(function(event) {
    if ($('#vw_fcb_ai_cbgestion').val()=="0"){
        return false;
    }
    var jvunidad = $(this).find(':selected').data('unidad');
    var jvafectacion = $(this).find(':selected').data('afectacion');
    var jvafecta = $(this).find(':selected').data('afecta');
    if (jvunidad!="") $('#vw_fcb_ai_cbunidad').val(jvunidad);
    if (jvafecta!="") $('#vw_fcb_ai_cbafectaigv').val(jvafecta);
    
    if (jvafectacion!="") $('#vw_fcb_ai_cbafectacion').val(jvafectacion);
    $('#vw_fcb_ai_txtcantidad').val("1");
    $('#vw_fcb_ai_txtpreciounitario').val("");
    $('#vw_fcb_ai_txtcantidad').focus();

});


$('#vw_fcb_ai_cbisc').change(function(event) {
    //var jvunidad=$(this).find(':selected').data('unidad');
    var jvcod_isc = $(this).val();
    $('#vw_fcb_ai_diviscbase').hide();
    switch (jvcod_isc) {
        case "SAV":
            $("#vw_fcb_ai_cbiscfactor option").each(function(i) {
                $(this).show();
            });
            break;
        case "AMF":
            $("#vw_fcb_ai_cbiscfactor option").each(function(i) {
                if ($(this).val() == "1") {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $("#vw_fcb_ai_cbiscfactor").val("1");
            break;
        case "PVP":
            $('#vw_fcb_ai_diviscbase').show();
            $("#vw_fcb_ai_cbiscfactor option").each(function(i) {
                if ($(this).val() == "100") {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $("#vw_fcb_ai_cbiscfactor").val("100");
            break;
    }
    /*$('#vw_fcb_ai_cbunidad').val(jvunidad);
    $('#vw_fcb_ai_txtcantidad').val(1);
    $('#vw_fcb_ai_txtpreciounitario').focus();*/
});



$("#modadditem").on('hidden.bs.modal', function() {
    $('#vw_fcb_ai_cbgestion').val("0");
    $('#vw_fcb_ai_txtcantidad').val("1");
    $('#vw_fcb_ai_txtpreciounitario').val("");
    $('#vw_fcb_ai_txtcoddeuda').val("");
});
/*$(document).on("keyup", ".unidad", function() {
    var btn = $(this).parents('.cfila');
    if ($(this).val() == "") {
        btn.data('unidad', $(this).val(''));
    } else {
        btn.data('unidad', $(this).val());
    }
})
$(document).on("keyup", ".valor", function() {
    var btn = $(this).parents('.cfila');
    if ($(this).val() == "") {
        btn.data('valor', $(this).val(''));
    } else {
        btn.data('valor', $(this).val());
    }
})*/
var cnt = 0;

$("#vw_pw_bt_ad_btn_guardar").click(function(event) {
    event.preventDefault();
    //var form = $(this).parents("#divcard_detalle");
    //var check = checkCampos(form);
    //if(check) {
    if ($('#vw_fcb_txtnrodoc').val()==""){
        Swal.fire(
            'Cliente!',
            "Debes indicar un cliente registrado",
            'warning'
        );
        return false;
    }
    //alert(itemsDocumento.size();)
    if (($.isEmptyObject(itemsDocumento)) || (itemsDocumento.length==0)){
        Swal.fire(
            'Items!',
            "Se necesitan Items para generar un documento de pago",
            'warning'
        );
        return false;
    }
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    $('.vw_fcb_frmcontrols').attr('readonly', false);
    $('.vw_fcb_class_rowitem input,select').attr('readonly', false);
    //$('#vw_fcb_frmboleta select').attr('readonly', false);
    var formData = new FormData($("#vw_fcb_frmboleta")[0]);
    formData.append('vw_fcb_items', JSON.stringify(itemsDocumento));
    //alert($('#vw_fcb_tipo').val());
    //var js_ruta=($.trim($('#vw_fcb_tipo').val())=="FC")?"fn_guardar_factura":"fn_guardar_boleta";
    $.ajax({
        url: base_url + 'facturacion_notas/fn_guardar_nota',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == true) {
                Swal.fire(
                    'Exito!',
                    'Los datos fueron guardados correctamente.',
                    'success'
                );
                $('#vw_fcb_frmboleta').hide();
                $('#divcard_resultfin').show();

                $('#vw_fcb_fin_numero').html(e.numero);
                $('#vw_fcb_fin_ticket').attr('href', e.tickect);
                $('#vw_fcb_fin_pdf').attr('href', e.pdf);
                
                
                
                
                
            } else {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                /*$('#vw_fcb_codpagante').attr('readonly', true);
                $('#vw_fcb_txtpagante').attr('readonly', true);
                $('#vw_fcb_txtpagante').attr('readonly', true);*/
                $('.vw_fcb_frmcontrols').attr('readonly', true);
                $('.vw_fcb_class_rowitem input,select').attr('readonly', true);
                
                                /*$("#vw_fcb_txtoper_gravada").attr('readonly', true);
                $("#vw_fcb_txtoper_inafecta").attr('readonly', true);
                $("#vw_fcb_txtoper_exonerada").attr('readonly', true);
                $("#vw_fcb_txtoper_exportacion").attr('readonly', true);
                $("#vw_fcb_txtoper_desctotal").attr('readonly', true);
                $("#vw_fcb_txtoper_gratuitas").attr('readonly', true);
                $("#vw_fcb_txtsubtotal").attr('readonly', true);
                $("#vw_fcb_txticbpertotal").attr('readonly', true);
                $("#vw_fcb_txtisctotal").attr('readonly', true);
                $("#vw_fcb_txtigvtotal").attr('readonly', true);
                $("#vw_fcb_txttotal").attr('readonly', true);*/
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
    });
    /*} else {
    $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
    Swal.fire(
    'Error!',
    'No hay datos en el detalle o hay campos vacios',
    'error'
    )
    }*/
    return false;
});

$("#vw_fcb_docafectado").keyup(function(e) {
    
    if(e.keyCode == 13)
    {
        $("#vw_fnt_btnbuscardoc").click();
    }
});

$('#vw_fnt_btnbuscardoc').click(function(event) {
    //REINICIAR
    $(".vw_fcb_divdatosfactura").hide();
    itemsDocumento =  {};
    itemsNro = 0;
    $('#divdata_detalle').html("");
    var docafectado = $.trim($('#vw_fcb_docafectado').val());
   
    if (docafectado==""){
        Swal.fire({
            title: "Falta documento afectado",
            type: 'warning',
            icon: 'warning',
        })
    }
    else{
        $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "facturacion_notas/fn_get_doc_afectado",
            type: 'post',
            dataType: 'json',
            data: {vw_fcb_docafectado:docafectado},
            success: function(e) {
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
                if (e.status == false) {
                   

                    Swal.fire({
                        title: e.msg,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                    
                } else {
                    if (e.existe==true){
                        $(".vw_fcb_divdatosfactura").show();
                    
                        $("#vw_fcn_tipo").val(e.docpago['codtipodoc']);
                        $("#vw_fcn_serie").val(e.docpago['serie']);
                        $("#vw_fcn_sernumero").val(e.docpago['nro']);

                        $("#vw_fcb_cbtipodoc").val(e.docpago['tipodocidentidad']);
                        $("#vw_fcb_txtnrodoc").val(e.docpago['pagnrodoc']);
                        $("#vw_fcb_txtpagante").val(e.docpago['pagante']);
                        $("#vw_fcb_codpagante").val(e.docpago['codpagante']);
                        $("#vw_fcb_txtdireccion").val(e.docpago['pagdirecion']);
                        $("#vw_fcb_txtemail1").val(e.docpago['pagcorreo1']);
                        $("#vw_fcb_txtemail2").val(e.docpago['pagcorreo2']);
                        $("#vw_fcb_txtemail3").val(e.docpago['pagcorreo3']); 
                        //$("#vw_fcb_txtobservaciones").val(e.docpago['obs']); 
                        
                        $.each(e.docitems, function(index, val) {

                            var itemd = {};
                            itemd['vw_fcb_ai_txtgestion'] = val['gestion'];
                            itemd['vw_fcb_ai_txtpreciounitario']=val['p_unitario'];
                            itemd['vw_fcb_ai_txtvalorunitario']=val['p_unitario'];
                            itemd['vw_fcb_ai_txtcantidad']=val['cantidad'];
                            itemd['vw_fcb_ai_txtprecioventa']=val['p_unitario'] * val['cantidad'];
                            itemd['vw_fcb_ai_cbafectacion']=val['codtipoafectacion'];
                            itemd['vw_fcb_ai_cbgestion']=val['codgestion'];
                            itemd['vw_fcb_ai_cbunidad']=val['unidad'];
                            itemd['vw_fcb_ai_txtcoddeuda']="";
                            itemd['vw_fcb_ai_cbtipoitem']=val['tipoitem'];
                            itemd['vw_fcb_ai_cbafectaigv']=val['afectado'];
                            itemd['vw_fcb_ai_cbgratis']=val['esgratis'];
                            itemd['vw_fcb_ai_cbisc']=val['codisc'];
                            itemd['vw_fcb_ai_txtiscvalor']=val['iscvalor'];
                            itemd['vw_fcb_ai_cbiscfactor']=val['iscfactor'];
                            itemd['vw_fcb_ai_txtiscbase']=val['iscbase'];
                            itemd['vw_fcb_ai_txtdsctvalor']=val['dsctovalor'];
                            itemd['vw_fcb_ai_cbdsctfactor']=val['dsctofactor'];

                            var row = $("#vw_fcb_rowitem").clone();
                            row.attr('id', 'vw_fcb_rowitem' + itemsNro);
                            row.data('arraypos', itemsNro);
                            itemsDocumento[itemsNro]=itemd;
                            itemsNro++;
                            row.find('input,select').each(function(index, el) {
                                $(this).val(itemd[$(this).attr('name')]);
                            });
                            row.show();

                            

                            $('#divdata_detalle').append(row);
                            
                            mostrar_montos();
                            
                        });
                        $('#vw_fcb_motivonota').focus();
                        
                    }
                    else{
                        Swal.fire({
                            title: e.msg,
                            // text: "",
                            type: 'warning',
                            icon: 'warning',
                        })
                    }

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
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


function fn_removeitem(boton) {
    //event.preventDefault();
    
    var fila=boton.closest('.rowcolor');
    var pos=fila.data('arraypos');
    var rvalorventa=Number(fila.find('#vw_fcb_ai_txtvalorunitario').val()) * Number(fila.find('#vw_fcb_ai_txtcantidad').val());
    fila.remove();
    //itemsDocumento[pos].re
    //js_total=js_total - rvalorventa;
    delete itemsDocumento[pos];
    mostrar_montos();
}


function fn_update_concepto(txt) {
    
    var fila=txt.closest('.rowcolor');
    var pos=fila.data('arraypos');
    var concepto = fila.find('input[name="vw_fcb_ai_txtgestion"]').val();
    itemsDocumento[pos]['vw_fcb_ai_txtgestion'] = concepto;

}

function fn_update_precios(txt) {
    
    var fila=txt.closest('.rowcolor');
    var pos=fila.data('arraypos');
   
    var pu = Number(fila.find('input[name="vw_fcb_ai_txtpreciounitario"]').val());
    itemsDocumento[pos]['vw_fcb_ai_txtpreciounitario']=pu;

    var vcnt=fila.find('input[name="vw_fcb_ai_txtcantidad"]').val();
    var valorventa=Number(vcnt) * pu;
    itemsDocumento[pos]['vw_fcb_ai_txtcantidad']=vcnt;



    /*itemsDocumento[pos].vw_fcb_ai_txtpreciounitario = pu;
    itemsDocumento[pos].vw_fcb_ai_txtprecioventa = Number(newvalue);
    itemsDocumento[pos].vw_fcb_ai_txtvalorunitario = Number(newvalue);*/


    

    var afectacion=itemsDocumento[pos]['vw_fcb_ai_cbafectacion'];
    
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
        itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] =valorventa;

    } else if (afectacion == "40") {
        //EXONERADO
        itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
        itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] =valorventa;

    } else {
        //GRATUITA
        itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
        itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] =valorventa;

    }
    
    fila.find('input[name="vw_fcb_ai_txtprecioventa"]').val(valorventa);

console.log("itemsDocumento", itemsDocumento)
    /*var row = $("#vw_fcb_rowitem"+pos);
    $("#vw_fcb_rowitem"+pos+" input[name='vw_fcb_ai_txtprecioventa']").val(Number(newvalue));

    ;*/
   
    mostrar_montos();
}
</script>
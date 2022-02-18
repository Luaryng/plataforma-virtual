<?php
$vbaseurl=base_url();
date_default_timezone_set ('America/Lima');
$fecha = date('Y-m-d');
$hora = date('H:i');
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
.vw_fcb_frmcontrols{
text-align: right;
}
/*.inputsb{
border-width:  0 0 1px 0;
padding-bottom: 0px !important;
}*/
</style>
<div class="content-wrapper">
    <div class="modal fade" id="modaddmatricula" tabindex="-1" role="dialog" aria-labelledby="modaddmatricula" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                        <div class="col-12 col-md-6 tex-primay">
                            
                            <div class="col-12">
                                <h4 id="fgi-apellidos" class=""></h4>
                                <b class="d-block text-danger pt-3"><i class="fas fa-user-graduate mr-1"></i> HISTORIAL DE MATRÍCULAS</b>
                            </div>
                            <div class="col-12 btable">
                                <div class="col-md-12 thead d-none d-md-block">
                                    <div class="row">
                                        <div class="col-6 col-md-4">
                                            <div class="row">
                                                <div class="cperiodo col-2 col-md-4 td"> PER. </div>
                                                <div class="col-2 col-md-5 td text-center">PLAN</div>
                                                <div class="ccarrera col-2 col-md-3 td" >PRG.</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <div class="row">
                                                <div class="cciclo td col-2 col-md-4 text-center " >CC.</div>
                                                <div class="cturno td col-2 col-md-4 text-center ">TR.</div>
                                                <div class="cseccion td col-2 col-md-4 text-center ">SC.</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="row">
                                                <div class="cciclo td col-2 col-md-3 text-center " >+</div>
                                                <div class="cciclo td col-2 col-md-3 text-center " >-</div>
                                                <div class="cturno td col-2 col-md-3 text-center ">DPI</div>
                                                <div class="cseccion td col-2 col-md-3 text-center ">NSP</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 td">
                                            EST.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 tbody" id="vw_fcb_div_Hmatriculas">
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-2">
                                <a class="float-right btn btn-sm btn-primary" data-carne="" id="btn_newmatricula" href="#"> + Nueva</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="col-12" id="vw_dp_divmatricular">
                                <form id="frm-matricular" action="<?php echo $vbaseurl ?>matricula/fn_insert_update_matricula" method="post" accept-charset='utf-8'>
                                    <b class="d-block text-danger"><i class="fas fa-user-graduate mr-1"></i> PROCESO DE MATRÍCULA</b>
                                    <input data-currentvalue='' id="fm-txtidmatriculaup" name="fm-txtidmatriculaup" value="0" type="hidden" />
                                    <input data-currentvalue='' id="fm-txtidup" name="fm-txtidup" type="hidden" />
                                    <input data-currentvalue='' id="fm-txtcarreraup" name="fm-txtcarreraup" type="hidden" />
                                    <input id="fm-txtplanup" name="fm-txtplanup" type="hidden" />
                                    <input data-currentvalue="" id="fm-txtperiodoup" name="fm-txtperiodoup" type="hidden">
                                    <input id="fm-txtmapepatup" name="fm-txtmapepatup" type="hidden" />
                                    <input id="fm-txtmapematup" name="fm-txtmapematup" type="hidden" />
                                    <input id="fm-txtmnombresup" name="fm-txtmnombresup" type="hidden" />
                                    <input id="fm-txtmsexoup" name="fm-txtmsexoup" type="hidden" />
                                    <input type="hidden" name="fm-txtcodpago" id="fm-txtcodpago" value="">
                                    
                                    <div class="row mt-3">
                                        <div class="form-group col-12 col-sm-12">
                                            <span id="fm-carreraup" class="d-block p-2 bg-light border rounded">PROGRAMA ACADÉMICO</span>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbtipoup" name="fm-cbtipoup" placeholder="Condición" required >
                                                <option value="O">Ordinaria</option>
                                                <option value="E">Extemporánea</option>
                                            </select>
                                            <label for="fm-cbtipoup"> Matrícula</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-md-3">
                                            <select data-currentvalue='' class="form-control" id="fm-cbperiodoup" name="fm-cbperiodoup" placeholder="Periodo" required >
                                                <option value="0"></option>
                                                <?php foreach ($periodos as $periodo) {?>
                                                <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbperiodoup"> Periodo</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-xs-4 col-md-5">
                                            <select data-currentvalue='' class="form-control" id="fm-cbplanup" name="fm-cbplanup" placeholder="Plan de Estudio" required>
                                                
                                            </select>
                                            <label for="fm-cbplanup"> Plan de Estudio</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-xs-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbcicloup" name="fm-cbcicloup" placeholder="Ciclo" required >
                                                <option value="0"></option>
                                                <?php foreach ($ciclos as $ciclo) {?>
                                                <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbcicloup"> Ciclo</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-xs-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbturnoup" name="fm-cbturnoup" placeholder="Turno" required >
                                                <option value="0"></option>
                                                <?php foreach ($turnos as $turno) {?>
                                                <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbturnoup"> Turno</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-xs-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbseccionup" name="fm-cbseccionup" placeholder="Sección" required >
                                                <option value="0"></option>
                                                <?php foreach ($secciones as $seccion) {?>
                                                <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbseccionup"> Sección</label>
                                        </div>
                                       
                                        <div class="form-group has-float-label col-12 col-md-6">
                                            <select data-currentvalue='' class="form-control" id="fm-cbbeneficioup" name="fm-cbbeneficioup" placeholder="Periodo" required >
                                                <?php foreach ($beneficios as $beneficio) {?>
                                                <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbbeneficioup"> Beneficio</label>
                                        </div>

                                        <div class="form-group has-float-label col-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbestadoup" name="fm-cbestadoup" placeholder="Periodo" required >
                                                <option value="0"></option>
                                                <?php foreach ($estados as $est) {?>
                                                <option <?php echo ($est->id=="1") ? "selected" : ""  ?> value="<?php echo $est->id ?>"><?php echo $est->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbestadoup"> Estado</label>
                                        </div>

                                        <div class="form-group has-float-label col-6 col-md-4">
                                            <input data-currentvalue='' class="form-control text-uppercase" value="<?php echo $fecha; ?>" id="fm-txtfecmatriculaup" name="fm-txtfecmatriculaup" type="date" placeholder="Fec. Matrícula"   />
                                            <label for="fm-txtfecmatriculaup">Fec. Matrícula</label>
                                        </div>
                                        <div class="form-group has-float-label col-6 col-md-6">
                                            <input data-currentvalue='' class="form-control" type="number" step="0.01"  value='0.00' id="fm-txtcuotaup" name="fm-txtcuotaup" placeholder="Cuota"   />
                                            <label for="fm-txtcuotaup">Cuota</label>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
                                            <textarea class="form-control text-uppercase" id="fm-txtobservacionesup" name="fm-txtobservacionesup" placeholder="Observaciones"  rows="3"></textarea>
                                            <label for="fm-txtobservacionesup"> Observaciones</label>
                                        </div>
                                        
                                    </div>
                                </form>
                                <button type="button" id="lbtn_guardarmat" class="btn btn-primary">Guardar</button>
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

    <!-- MODAL AGREGAR PAGANTE -->
    <div class="modal fade" id="modaddpagante" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">NUEVO CLIENTE</h5>
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
                                    <option value="RUC">RUC</option>
                                    <option value="CEX">Carné de Extranjería</option>
                                    <option value="PSP">Pasaporte</option>
                                    <option value="PTP">Permiso Temporal de Permanencia</option>
                                </select>
                                <label for="ficbtipodoc"> Tipo Doc.</label>
                            </div>
                            <div class="form-group has-float-label col-6  col-sm-4">
                                <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtdni" name="fitxtdni" type="text" placeholder="N° documento"  minlength="8" />
                                <label for="fitxtdni"> N° documento</label>
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
                                <select onchange='fn_combo_ubigeo($(this));' data-currentvalue='' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required data-tubigeo='departamento' data-cbprovincia='ficbprovincia' data-cbdistrito='ficbdistrito' data-dvcarga='divcard_data'>
                                    <option value="0">Selecciona Departamento</option>
                                    <?php foreach ($departamentos as $key => $depa) {?>
                                    <option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="ficbdepartamento"> Departamento</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select onchange='fn_combo_ubigeo($(this));' data-currentvalue='0' class="form-control form-control-sm" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" required data-tubigeo='provincia' data-cbdistrito='ficbdistrito' data-dvcarga='divcard_data'>
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
        <div class="modal-dialog  modal-xl" role="document">
            <div class="modal-content" id="divmodalsearch">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_titles">Buscar Pagantes </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_searchpag" action="" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-11">
                                <input autocomplete="off" type="text" name="fictxtnompagante" id="fictxtnompagante" placeholder="Cliente" class="form-control form-control-sm">
                                <label for="fictxtnompagante">Cliente</label>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-sm btn-info" type="submit" >
                                <i class="fas fa-search"></i>
                                </button>
                                
                            </div>
                        </div>
                        
                    </form>
                    
                    <div class="col-12 py-1 btable"  id="divcard_ltspagante">
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
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
                        <li class="breadcrumb-item active"><a id="btn_prueba" href="#">matricular</a></li>
                        
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
                    
                    <div class="row mt-2">
                        <div class="input-group input-group-sm  mb-3 col-12 col-md-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Operación: </span>
                            </div>
                            <select name="vw_fcb_cbtipo_operacion51" id="vw_fcb_cbtipo_operacion51" class="form-control custom-select inputsb text-sm">
                                <?php
                                foreach ($tipoopera51 as $key => $tpop51) {
                                $opera51sel=($docserie->codoperacion51==$tpop51->codopera51)?"selected":"";
                                echo "<option $opera51sel value='$tpop51->codopera51' >$tpop51->nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group input-group-sm  mb-3 col-12 col-md-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">IGV %: </span>
                            </div>
                            <input autocomplete="off"  name="vw_fcb_txtigvp" id="vw_fcb_txtigvp" type="text" class="form-control text-sm inputsb" placeholder="IGV %" value="<?php echo $docserie->igvpr ?>">
                        </div>


                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Vencimiento: </span>
                                </div>
                                <input type="date" class="form-control " name="vw_fcb_vencimiento" id="vw_fcb_vencimiento">
                            </div>
                        </div>
                    </div>
                    
                    
                    <hr>
                    <div class="row mt-3">
                        
                        <div class="form-group has-float-label col-12 col-md-2">
                            <select name="vw_fcb_cbtipodoc" id="vw_fcb_cbtipodoc" class="form-control  control form-control-sm text-sm inputsb">
                                <?php
                                foreach ($tipoidentidad as $key => $tpid) {
                                echo "<option value='$tpid->codigo' data-lgt='$tpid->longitud'>$tpid->nombre</option>";
                                }
                                ?>
                                
                            </select>
                            <label for="vw_fcb_cbtipodoc">Tipo doc.</label>
                        </div>
                        
                        <div class="form-group has-float-label col-12 col-md-3">
                            <input autocomplete="off"  name="vw_fcb_txtnrodoc" id="vw_fcb_txtnrodoc" type="text" class="form-control  form-control-sm text-sm inputsb" placeholder="N° Documento">
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
                        <div class="col-md-1">
                            <div class="btn-group dropleft float-right">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-tie"></i> Cliente
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modaddpagante">
                                        <i class="fas fa-plus mr-1"></i> Agregar
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modsearchpagante">
                                        <i class="fas fa-search mr-1"></i> Buscar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-8">
                            <input readonly name="vw_fcb_txtdireccion" id="vw_fcb_txtdireccion" type="text" class="form-control  form-control-sm text-sm inputsb" placeholder="Dirección">
                            <label for="vw_fcb_txtdireccion">Dirección</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <select name="vw_fcb_cbmatricula" id="vw_fcb_cbmatricula" class="form-control  control form-control-sm text-sm border border-primary text-danger">
                                      <option value='0'>Sin Asignar</option>                         
                            </select>
                            <label for="vw_fcb_cbmatricula">Matrícula</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail1" id="vw_fcb_txtemail1" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 1">
                            <label for="vw_fcb_txtemail1">Correo 1</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail2" id="vw_fcb_txtemail2" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 2">
                            <label for="vw_fcb_txtemail2">Correo 2</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail3" id="vw_fcb_txtemail3" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 3">
                            <label for="vw_fcb_txtemail3">Correo 3</label>
                        </div>
                    </div>
                    <div class="row mt-3" id="divcard_detalle_deuda">
                        <div class="col-12">
                            <div class="card card-danger border border-danger">
                                <div class="card-header text-bold ">
                                    <h4>Deudas del Cliente</h4>
                                </div>
                                <div class="card-body pt-0" id="">
                                    <div class="col-12 btable">
                                        <div class="col-md-12 thead d-none d-md-block bg-lightgray">
                                            <div class="row text-bold">
                                                <div class='col-8 col-md-4 td'>
                                                    Concepto
                                                </div>
                                                <div class='col-4 col-md-1 td'>
                                                    Monto
                                                </div>
                                                <div class='col-4 col-md-1 td'>
                                                    Mora
                                                </div>
                                                <div class='col-6 col-md-2 td'>
                                                    Vence
                                                </div>
                                                <div class='col-6 col-md-1 td'>
                                                    Saldo
                                                </div>
                                                <div class='col-6 col-md-2 td'>
                                                    Periodo / Ciclo
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 tbody" id="divdata_detalle_deuda">
                                            
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="row mt-3" id="divcard_detalle">
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
                                <a id="btn_addmodcobros" class="btn btn-success btn-lg d-block" href="#" data-toggle='modal' data-target='#modaddcobros' data-iddocp="" data-montodocp="">
                                    <i class="far fa-credit-card mr-1"></i> Agregar Cobros
                                </a>
                            </div>
                        </div>
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
var cd1 = '<?php echo base64url_encode("1"); ?>';
var itemsDocumento = {};
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
    $('#vw_dp_divmatricular').hide();

    $(".div_dctoglobal").hide();
    // $("#divcard_resultfin").show();
    $("#divcard_resultfin").hide();
    $("#vw_fcb_rowitem").hide();
    $("#divcard_detalle_deuda").hide();
    $("#vw_fcb_sernumero_real").hide();

    if ($("#vw_fcb_tipo").val() == "BL") {
        $("#vw_fcb_btnedit_numero").show();
    } else {
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
    var js_total = 0;

    $.each(itemsDocumento, function(ind, elem) {
        var pu = Number(elem['vw_fcb_ai_txtpreciounitario']);
        var valorventa = Number(elem['vw_fcb_ai_txtcantidad']) * pu;
        if (elem['vw_fcb_ai_cbafectacion'] == "10") {
            //GRAVADO
            //elem['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
            valorventa_sinigv = Number(elem['vw_fcb_ai_txtvalorunitario']) * Number(elem['vw_fcb_ai_txtcantidad']);
            //elem['vw_fcb_ai_txtprecioventa'] = valorventa;
            ops_grav = ops_grav + valorventa_sinigv;
            js_total = js_total + valorventa;
        } else if (elem['vw_fcb_ai_cbafectacion'] == "30") {
            //INAFECTO
            //elem['vw_fcb_ai_txtvalorunitario'] = pu;
            //elem['vw_fcb_ai_txtprecioventa'] = valorventa;
            ops_inaf = ops_inaf + valorventa;
            js_total = js_total + valorventa;
        } else if (elem['vw_fcb_ai_cbafectacion'] == "20") {
            //EXONERADO
            //elem['vw_fcb_ai_txtvalorunitario'] = pu;
            //elem['vw_fcb_ai_txtprecioventa'] =valorventa;
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
            //elem['vw_fcb_ai_txtvalorunitario'] = pu;
            //elem['vw_fcb_ai_txtprecioventa'] =valorventa;
            ops_grat = ops_grat + valorventa;
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
    $(".vw_fcb_frmcontrols").each(function() {
        $(this).val(parseFloat($(this).val()).toFixed(2));
    });
}
$("#vw_fcb_chk_dsct_global,#vw_fcb_cbdsctglobalfactor").change(function(event) {
    mostrar_montos();
});
/*$("#vw_fcb_ai_btnagregar").click(function(event) {
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
//console.log(itemd)
var pu = Number(itemd['vw_fcb_ai_txtpreciounitario']);
var valorventa=Number(itemd['vw_fcb_ai_txtcantidad']) * pu;
if afectacion == "10") {
//GRAVADO
itemd['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
valorventa_sinigv=Number(itemd['vw_fcb_ai_txtvalorunitario']) * Number(itemd['vw_fcb_ai_txtcantidad']);
itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
ops_grav = ops_grav + valorventa_sinigv;
js_total=js_total + valorventa;
} else if (itemd['vw_fcb_ai_cbafectacion'] == "30") {
//INAFECTO
itemd['vw_fcb_ai_txtvalorunitario'] = pu;
itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
ops_inaf = ops_inaf + valorventa;
js_total=js_total + valorventa;
} else if (itemd['vw_fcb_ai_cbafectacion'] == "20") {
//EXONERADO
itemd['vw_fcb_ai_txtvalorunitario'] = pu;
itemd['vw_fcb_ai_txtprecioventa'] =valorventa;
ops_exon = ops_exon +  valorventa;
js_total=js_total + valorventa;
} else if (itemd['vw_fcb_ai_cbafectacion'] == "40") {
//EXONERADO
itemd['vw_fcb_ai_txtvalorunitario'] = pu;
itemd['vw_fcb_ai_txtprecioventa'] =valorventa;
ops_inaf = ops_inaf +  valorventa;
js_total=js_total + valorventa;
} else {
//GRATUITA
itemd['vw_fcb_ai_txtvalorunitario'] = pu;
itemd['vw_fcb_ai_txtprecioventa'] =valorventa;
ops_grat = ops_grat +  valorventa;
//js_total=js_total + valorventa;
}



var row = $("#vw_fcb_rowitem").clone();
row.attr('id', 'vw_fcb_rowitem' + itemsNro);
row.data('arraypos', itemsNro);
itemsDocumento[itemsNro]=itemd;
console.log(itemsDocumento);
itemsNro++;
row.find('input,select').each(function(index, el) {
$(this).val(itemd[$(this).attr('name')]);
});
row.show();
$('#divdata_detalle').append(row);
$("#modadditem").modal("hide");
mostrar_montos();
$('#vw_fcb_ai_cbgestion').val("0");
$('#vw_fcb_ai_txtcantidad').val("1");
$('#vw_fcb_ai_txtpreciounitario').val("");
});*/
$("#vw_fcb_ai_btnagregar").click(function(event) {
    event.preventDefault();
    $('#vw_fcb_ai_divbody .modal-body input,select').removeClass('is-invalid');
    $('#vw_fcb_ai_divbody .modal-body .invalid-feedback').remove();


    if ($('#vw_fcb_ai_cbgestion').val() == "0") {
        $('#vw_fcb_ai_cbgestion').addClass('is-invalid');
        $('#vw_fcb_ai_cbgestion').parent().append("<div class='invalid-feedback'>Selecciona un Item</div>");
        return false;
    }
    //var txtcnt=Number($("#vw_fcb_ai_txtcantidad").val())
    if (!$.isNumeric($("#vw_fcb_ai_txtcantidad").val())) {
        $("#vw_fcb_ai_txtcantidad").addClass('is-invalid');
        $("#vw_fcb_ai_txtcantidad").parent().append("<div class='invalid-feedback'>Corregir</div>");
        return false;
    }
    //var txtpu=Number($("#vw_fcb_ai_txtpreciounitario").val())
    if (!$.isNumeric($("#vw_fcb_ai_txtpreciounitario").val())) {
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
    //console.log(itemd)
    /*itemsDocumento.each(function(index, el) {
    });*/
    var pu = Number(itemd['vw_fcb_ai_txtpreciounitario']);
    var valorventa = Number(itemd['vw_fcb_ai_txtcantidad']) * pu;
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
        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
        //ops_exon = ops_exon +  valorventa;
        //js_total=js_total + valorventa;
    } else if (itemd['vw_fcb_ai_cbafectacion'] == "40") {
        //EXONERADO
        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
        //ops_inaf = ops_inaf +  valorventa;
        //js_total=js_total + valorventa;
    } else {
        //GRATUITA
        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
        //ops_grat = ops_grat +  valorventa;
        //js_total=js_total + valorventa;
    }



    var row = $("#vw_fcb_rowitem").clone();
    row.attr('id', 'vw_fcb_rowitem' + itemsNro);
    row.data('arraypos', itemsNro);
    itemsDocumento[itemsNro] = itemd;
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
    if ($('#vw_fcb_ai_cbgestion').val() == "0") {
        return false;
    }
    var jvunidad = $(this).find(':selected').data('unidad');
    var jvafectacion = $(this).find(':selected').data('afectacion');
    var jvafecta = $(this).find(':selected').data('afecta');
    if (jvunidad != "") $('#vw_fcb_ai_cbunidad').val(jvunidad);
    if (jvafecta != "") $('#vw_fcb_ai_cbafectaigv').val(jvafecta);

    if (jvafectacion != "") $('#vw_fcb_ai_cbafectacion').val(jvafectacion);
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
$('#frm_searchpag').submit(function() {
    $('#frm_searchpag input,select').removeClass('is-invalid');
    $('#frm_searchpag .invalid-feedback').remove();
    $('#divmodalsearch').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'pagante/get_pagantes',
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
            var msgf = errorAjax(jqXHR, exception, 'text');
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
$("#modsearchpagante").on('hidden.bs.modal', function() {
    $('#frm_searchpag')[0].reset();
    $('#divcard_ltspagante').html('');
});
$("#modsearchpagante").on('shown.bs.modal', function() {

    $('#fictxtnompagante').focus();
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
    modmatricula = false;
    $('#divdata_detalle input[name="vw_fcb_ai_cbgestion"]').each(function() {
        campo = $(this).val();
        if ((campo == "01.01") || (campo == "01.02") || (campo == "01.03")) {
            modmatricula = true;
        }
    })
    if ($('#vw_fcb_txtnrodoc').val() == "") {
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
        url: base_url + 'facturacion/fn_guardar_docpago',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == true) {
                if (modmatricula == true) {
                    //$('#fm-txtidmatricula').val(e.codmat);
                    //if (e.matestado == "AGREGAR") {
                    datos_carne($('#vw_fcb_codpagante').val(), e.coddocpago);

                    //}
                    //else if (e.matestado == "EDITAR") {
                    //datos_matricula(e.codmat,e.coddocpago);
                    // $('#modaddmatricula').modal('show');
                    //}
                }
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

                $('#btn_addmodcobros').data('iddocp', e.coddocpago);
                $('#btn_addmodcobros').data('montodocp', e.montodocpago);



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

function datos_carne(carne, codpago) {
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "matricula/fn_get_inscripcion_y_matriculas_x_carne",
        type: 'post',
        dataType: 'json',
        data: {
            'fgi-txtcarne': carne,
        },
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'warning',
                    title: 'ADVERTENCIA',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                $('#modaddmatricula').modal('show');
                $('#fm-txtid').val(e.vdata['idinscripcion64']);
                $('#fm-txtcodpago').val(codpago);
                $("#frm-matricular")[0].reset();
                if (e.existe_inscrito == false) {
                    $('#fgi-apellidos').html('NO ENCONTRADO');

                    $('#fm-txtcarrera').val("");
                    $('#fm-carrera').val("PROGRAMA ACADÉMICO");
                    $('#fm-cbplan').html("<option value='0'>Plán curricular NO DISPONIBLE</option>");
                    //$("#frm-matricular").hide();
                } else {
                    //$('#fitxtdni').val(e.vdata['dni']);
                    $('#fgi-apellidos').html(carne + "<br>" + e.vdata['paterno'] + ' ' + e.vdata['materno'] + ' ' + e.vdata['nombres']);
                    $('#fm-txtcarrera').val(e.vdata['codcarrera']);
                    $('#fm-carrera').html(e.vdata['carrera']);
                    $('#btn_newmatricula').data('carne', e.vdata['carnet']);
                    var planes = "";
                    $.each(e.vplanes, function(key, val) {
                        planes = planes + "<option value='" + val['codigo'] + "'>" + val['nombre'] + "</option>";

                    });
                    $('#fm-cbplan').html(planes);
                    $('#fm-cbplan').val(e.vdata['codplan']);
                    $('#fm-txtplan').val(e.vdata['codplan']);
                    $('#fm-txtmapepat').val(e.vdata['paterno']);
                    $('#fm-txtmapemat').val(e.vdata['materno']);
                    $('#fm-txtmnombres').val(e.vdata['nombres']);
                    $('#fm-txtmsexo').val(e.vdata['sexo']);
                    var nro = 0;
                    $("#vw_fcb_div_Hmatriculas").html("");
                    $.each(e.vmatriculas, function(index, v) {

                        nro++;
                        var btnscolor = "";
                        switch (v['estado']) {
                            case "ACT":
                                btnscolor = "btn-success";
                                break;
                            case "CUL":
                                btnscolor = "btn-secondary";
                                break;
                            case "RET":
                                btnscolor = "btn-danger";
                                break;
                            default:
                                btnscolor = "btn-warning";
                        }
                        var js_estado = v['estado'];
                        var js_update = "";
                        if ((v['codestado'] == "6") || (v['codestado'] == "5")) {
                            js_estado = '<div class="btn-group btn-group-sm p-0 ">' +
                                '<button class="btn ' + btnscolor + ' btn-sm dropdown-toggle py-0 rounded border-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                v['estado'] +
                                '</button>' +
                                '<div class="dropdown-menu">' +
                                '<a href="#" class="btn-cestado dropdown-item" data-ie="' + cd1 + '">Activo</a>' +
                                '</div>' +
                                '</div>'
                        }

                        if ((v['codestado'] == "6") || (v['codestado'] == "5") || (v['codestado'] == "1")) {
                            js_update = '<a onclick="fn_matricula_update($(this))" href="#">' +
                                '<i class="far fa-edit ml-2"></i>' +
                                '</a> ';
                        }
                        $("#vw_fcb_div_Hmatriculas").append(
                            '<div data-idm="' + v['codmatricula64'] + '" class="row cfila rowcolor ">' +
                            '<div class="col-12 col-md-4">' +
                            '<div class="row">' +
                            '<div data-cp="' + v['codperiodo'] + '" class="cperiodo col-2 col-md-4 td">' + v['codperiodo'] + '</div>' +
                            '<div class="col-8 col-md-5 td text-center">' + v['plan'] + '</div>' +
                            '<div class="ccarrera col-2 col-md-3 td" data-cod="' + v['codcarrera'] + '">' + v['sigla'] + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-12 col-md-2">' +
                            '<div class="row">' +
                            '<div class="cciclo td col-4 col-md-4 text-center " data-cod="' + v['codciclo'] + '">' + v['codciclo'] + '</div>' +
                            '<div class="cturno td col-4 col-md-4 text-center ">' + v['codturno'] + '</div>' +
                            '<div class="cseccion td col-4 col-md-4 text-center ">' + v['codseccion'] + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-12 col-md-3">' +
                            '<div class="row">' +
                            '<div class="td col-3 col-md-3 text-center text-primary">' + v['aprobados'] + '</div>' +
                            '<div class="td col-3 col-md-3 text-center text-danger">' + v['desaprobados'] + '</div>' +
                            '<div class="td col-3 col-md-3 text-center text-danger">' + v['dpi'] + '</div>' +
                            '<div class="td col-3 col-md-3 text-center text-danger">' + v['nsp'] + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-12 col-md-3 td">' +
                            js_update +
                            js_estado +
                            '</div>' +
                            '</div>');
                    });

                    $(".btn-cestado").click(function(event) {
                        var im = $(this).closest(".cfila").data('idm');
                        var ie = $(this).data('ie');
                        var btdt = $(this).parents(".btn-group").find('.dropdown-toggle');
                        //var btdt=$(this).parents(".dropdown-toggle");
                        var texto = $(this).html();
                        //alert(btdt.html());
                        $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                        $.ajax({
                            url: base_url + 'matricula/fn_cambiarestado',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                'ce-idmat': im,
                                'ce-nestado': ie
                            },
                            success: function(e) {
                                $('#divcard-matricular #divoverlay').remove();
                                if (e.status == false) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Error!',
                                        text: e.msg,
                                        backdrop: false,
                                    })
                                } else {
                                    /*$("#fm-txtidmatricula").html(e.newcod);*/
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Felicitaciones, estado actualizado',
                                        text: 'Se ha actualizado el estado',
                                        backdrop: false,
                                    })
                                    btdt.removeClass('btn-danger');
                                    btdt.removeClass('btn-success');
                                    btdt.removeClass('btn-warning');
                                    btdt.removeClass('btn-secondary');
                                    switch (texto) {
                                        case "Activo":
                                            btdt.addClass('btn-success');
                                            btdt.html("ACT");
                                            break;
                                            /*case "CUL":
                                            btnscolor="btn-secondary";
                                            break;*/
                                        case "Retirado":
                                            btdt.addClass('btn-danger');
                                            btdt.html("RET");
                                            break;
                                        default:
                                            btnscolor = "btn-warning";
                                    }
                                    //btdt.addClass('class_name');
                                    //mostrarCursos("div-cursosmat", "", e.vdata);
                                }
                            },
                            error: function(jqXHR, exception) {
                                var msgf = errorAjax(jqXHR, exception, 'text');
                                $('#divcard-matricular #divoverlay').remove();
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error',
                                    text: msgf,
                                    backdrop: false,
                                })
                            }
                        });
                        return false;
                    });
                    /*'<div class="td col-2 col-md-1 p-2"><a class="bg-primary text-white py-1 px-2 mt-2 rounded btn-editar" data-cm=' + vcm + '  href="#" title="Carga académica"><i class="fas fa-book"></i> Editar</a></div>' +
                    '</div>' +*/
                    //academico/matricula/ficha/excel/
                    //$("#fmt-conteo").html(nro + ' matriculas encontradas');
                    //$("#frm-matricular").show();
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            $('#divError').show();
            $('#msgError').html(msgf);
        }
    });
    return false;
}
$('#vw_fcb_cbtipodoc').change(function(event) {
    $('#vw_fcb_txtnrodoc').removeClass('is-invalid');
    $('#vw_fcb_txtnrodoc').parent().find('.invalid-feedback').remove();
    if ($(this).val() == "VAR") {
        $('#vw_fcb_txtnrodoc').val("00000000");


    } else {
        $('#vw_fcb_txtnrodoc').val("");
        $('#vw_fcb_txtnrodoc').focus();
    }
    $('#vw_fcb_txtpagante').val("VARIOS");
    $('#vw_fcb_txtdireccion').val("");
    $('#vw_fcb_txtemail1').val("");
    $('#vw_fcb_txtemail2').val("");
    $('#vw_fcb_txtemail3').val("");
    $('#vw_fcb_codpagante').val("");

});
$("#vw_fcb_txtnrodoc").keyup(function(e) {

    if (e.keyCode == 13) {
        $("#vw_fcb_txtnrodoc").blur();
    }
});
$("#vw_fcb_txtnrodoc").blur(function(event) {
    $(this).removeClass('is-invalid');
    $(this).parent().find('.invalid-feedback').remove();
    var jvnrodoc = $('#vw_fcb_txtnrodoc').val();
    var jvtipodoc = $('#vw_fcb_cbtipodoc').val();
    var jvlongitud = $('#vw_fcb_cbtipodoc').find(':selected').data('lgt');
    if (jvlongitud == 0) {} else {
        if (jvlongitud == jvnrodoc.length) {
            /*if (jvtipodoc=="RUC"){
            }*/

            mostrar_pagante_deudas();
        } else {
            $(this).addClass('is-invalid');
            $(this).parent().append("<div class='invalid-feedback'> El n° de tener como mínimo " + jvlongitud + " dígitos</div>");
        }
    }
    return false;
});

function fn_removeitem(boton) {
    //event.preventDefault();

    var fila = boton.closest('.rowcolor');
    var pos = fila.data('arraypos');
    var rvalorventa = Number(fila.find('#vw_fcb_ai_txtvalorunitario').val()) * Number(fila.find('#vw_fcb_ai_txtcantidad').val());
    fila.remove();
    //itemsDocumento[pos].re
    //js_total=js_total - rvalorventa;
    delete itemsDocumento[pos];
    mostrar_montos();
}

function fn_additemdeduda(boton) {
    var fila = boton.closest('.cfila');
    var coddeuda = fila.data('coddeuda');
    var coditem = fila.data('coditem');
    var monto = fila.data('monto');
    $("#modadditem").modal('show');
    $("#vw_fcb_ai_txtcoddeuda").val(coddeuda);
    $("#vw_fcb_ai_cbgestion").val(coditem);
    $("#vw_fcb_ai_cbgestion").change();
    $("#vw_fcb_ai_txtpreciounitario").val(parseFloat(monto).toFixed(2));
    $("#vw_fcb_ai_txtpreciounitario").focus();
    return false;
}

function mostrar_pagante_deudas() {
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('#vw_fcb_txtpagante').val("");
    $('#vw_fcb_txtdireccion').val("" );
    $('#vw_fcb_txtemail1').val("");
    $('#vw_fcb_txtemail2').val("");
    $('#vw_fcb_txtemail3').val("");
    $('#vw_fcb_codpagante').val("");
    $('#vw_fcb_cbmatricula').html("<option value='0'>Sin Asignar</option>");
    $("#divdata_detalle_deuda").html("");

    var jvnrodoc = $('#vw_fcb_txtnrodoc').val();
    var jvtipodoc = $('#vw_fcb_cbtipodoc').val();
    $.ajax({
        url: base_url + 'pagante/fn_get_pagantes_deuda',
        type: 'POST',
        data: {
            vw_fcb_txtnrodoc: jvnrodoc,
            vw_fcb_cbtipodoc: jvtipodoc
        },
        dataType: 'json',
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == true) {
                if (e.rscount == 1) {
                    $('#vw_fcb_txtpagante').val(e.vdata.razonsocial);
                    $('#vw_fcb_txtdireccion').val(e.vdata.direccion + " - " + e.vdata.distrito + " - " + e.vdata.provincia + " - " + e.vdata.departamento);
                    $('#vw_fcb_txtemail1').val(e.vdata.correo1);
                    $('#vw_fcb_txtemail2').val(e.vdata.correo2);
                    $('#vw_fcb_txtemail3').val(e.vdata.correo_corp);
                    $('#vw_fcb_codpagante').val(e.vdata.codpagante);
                    $('#vw_fcb_cbmatricula').html("<option value='0'>Sin Asignar</option>");
                    if (e.rscountmatricula > 0) {
                        var matricula = "";
                        matricula = "<option value=''>Sin Asignar</option>";
                        $.each(e.vmatriculas, function(key, mt) {
                            if (mt['estado'] !== '2') {
                                matricula = matricula + "<option value='" + mt['codigo'] + "'>" + mt['periodo'] + " - " + mt['ciclo'] + "</option>";
                            }

                        });

                        $('#vw_fcb_cbmatricula').html(matricula);
                    } else {
                        $('#vw_fcb_cbmatricula').html("<option value='0'>Sin Asignar</option>");
                    }

                    if (e.rscountdeuda > 0) {
                        $("#divcard_detalle_deuda").show();
                        var tbdeudas = "";
                        var nro = 0;
                        $.each(e.vdeudas, function(index, dd) {
                            //prorroga
                            nro++;
                            bgsaldo=(dd['estado']=="VENCIDO")? "bg-danger": "";
                            tbdeudas = tbdeudas +

                                "<div class='row cfila rowcolor' data-coditem=" + dd['codgestion'] + " data-monto=" + dd['saldo'] + " data-coddeuda='" + dd['codigo'] + "'>" +

                                "<div class='col-8 col-md-4 td'>" +
                                "<span>" + dd['codgestion'] + " " + dd['gestion'] + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-1 td text-right'>" +
                                "<span>" + parseFloat(dd['monto']).toFixed(2) + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-1 td text-right'>" +
                                "<span>" + parseFloat(dd['mora']).toFixed(2) + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td text-center'>" +
                                "<span>" + dd['vence'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-1 td text-right " + bgsaldo + "'>" +
                                "<span>" + parseFloat(dd['saldo']).toFixed(2) + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td text-center'>" +
                                "<span>" + dd['codperiodo'] + " / " + dd['codciclo'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-1 td'>" +
                                "<a onclick='fn_additemdeduda($(this));return false' class='badge badge-primary' href='#'><i class='fas fa-plus'></i></a>" +
                                "</div> " +
                                '</div>';
                        });

                        $("#divdata_detalle_deuda").html(tbdeudas);
                    } else {
                        $("#divcard_detalle_deuda").hide();
                        $("#divdata_detalle_deuda").html("");
                    }

                } else {
                    
                    $("#modsearchpagante").modal("show");
                    $("#divcard_ltspagante").html(e.vpagantes);
                }

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
}


function mostrar_deudas(codpagante) {
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $.ajax({
        url: base_url + 'deudas_individual/fn_get_deuda_x_codpagante',
        type: 'POST',
        data: {
            vw_fcb_txtcodpagante: codpagante
        },
        dataType: 'json',
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == true) {
                
                    /*$('#vw_fcb_txtpagante').val(e.vdata.razonsocial);
                    $('#vw_fcb_txtdireccion').val(e.vdata.direccion + " - " + e.vdata.distrito + " - " + e.vdata.provincia + " - " + e.vdata.departamento);
                    $('#vw_fcb_txtemail1').val(e.vdata.correo1);
                    $('#vw_fcb_txtemail2').val(e.vdata.correo2);
                    $('#vw_fcb_txtemail3').val(e.vdata.correo_corp);
                    $('#vw_fcb_codpagante').val(e.vdata.codpagante);*/
                    $('#vw_fcb_cbmatricula').html("<option value='0'>Sin Asignar</option>");
                    if (e.rscountmatricula > 0) {
                        var matricula = "";
                        matricula = "<option value=''>Sin Asignar</option>";
                        $.each(e.vmatriculas, function(key, mt) {
                            if (mt['estado'] !== '2') {
                                matricula = matricula + "<option value='" + mt['codigo'] + "'>" + mt['periodo'] + " - " + mt['ciclo'] + "</option>";
                            }

                        });

                        $('#vw_fcb_cbmatricula').html(matricula);
                    } else {
                        $('#vw_fcb_cbmatricula').html("<option value='0'>Sin Asignar</option>");
                    }

                    if (e.rscountdeuda > 0) {
                        $("#divcard_detalle_deuda").show();
                        var tbdeudas = "";
                        var nro = 0;
                        $.each(e.vdeudas, function(index, dd) {
                            //prorroga
                            nro++;
                            tbdeudas = tbdeudas +
                                "<div class='row cfila rowcolor' data-coditem=" + dd['codgestion'] + " data-monto=" + dd['saldo'] + " data-coddeuda='" + dd['codigo'] + "'>" +

                                "<div class='col-8 col-md-4 td'>" +
                                "<span>" + dd['codgestion'] + " " + dd['gestion'] + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-1 td text-right'>" +
                                "<span>" + parseFloat(dd['monto']).toFixed(2) + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-1 td text-right'>" +
                                "<span>" + parseFloat(dd['mora']).toFixed(2) + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td text-center'>" +
                                "<span>" + dd['vence'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-1 td text-right'>" +
                                "<span>" + parseFloat(dd['saldo']).toFixed(2) + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td text-center'>" +
                                "<span>" + dd['codperiodo'] + " / " + dd['codciclo'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-1 td'>" +
                                "<a onclick='fn_additemdeduda($(this));return false' class='badge badge-primary' href='#'><i class='fas fa-plus'></i></a>" +
                                "</div> " +
                                '</div>';
                        });

                        $("#divdata_detalle_deuda").html(tbdeudas);
                    } else {
                        $("#divcard_detalle_deuda").hide();
                        $("#divdata_detalle_deuda").html("");
                    }

                

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
}

function fn_select_pagante(boton) {
    //e.preventDefault();
    var btn = boton.parents('.cfila');
    var codpagante = btn.data('codpag');
    var documento = btn.data('docum');
    var pagante = btn.data('pagante');
    var direccion = btn.data('direccion');
    var email = btn.data('email');
    var email2 = btn.data('email2');
    var email3 = btn.data('ecorp');
    var tipodocum = btn.data('tipdoc');
    $('#vw_fcb_cbtipodoc').val(tipodocum);
    $('#vw_fcb_txtnrodoc').val(documento);
    $('#vw_fcb_txtpagante').val(pagante);
    $('#vw_fcb_txtdireccion').val(direccion);
    $('#vw_fcb_txtemail1').val(email);
    $('#vw_fcb_txtemail2').val(email2);
    $('#vw_fcb_txtemail3').val(email3);
    $('#vw_fcb_codpagante').val(codpagante);
    $("#modsearchpagante").modal('hide');
    mostrar_deudas(codpagante);
};
//Función para comprobar los campos de texto
/*function checkCampos(obj) {
var camposRellenados = true;
obj.find("input").each(function() {
var $this = $(this);
if ($this.val().length <= 0) {
camposRellenados = false;
return false;
}
});
if (camposRellenados == false) {
return false;
} else {
return true;
}
}*/
// SCRIPT COBROS
$("#modaddcobros").on('show.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var codigo = rel.data('iddocp');
    var montopg = rel.data('montodocp');

    $('#vw_fcb_codigopago').val(codigo);
    $('#vw_fcb_montopago').val(montopg);
    $('#ficmontopag').html(montopg);
    $('.btnaddcobr').data('montopg', montopg);
    $('.btnaddcobr').data('idocp', codigo);
    $('.txtmonpg').html(montopg);
    $('.btnaddoperacioncob').data('montopg', montopg);
    $('.btnaddoperacioncob').data('idocp', codigo);
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
                    var nro = 0;
                    var tabla = "";
                    var montototalc = 0;
                    var banco = "";
                    var operbanco = "";

                    $.each(e.vdata, function(index, val) {
                        nro++;
                        montototalc += parseFloat(val['montocob']);
                        if (val['nombanco'] !== null) {
                            banco = val['nombanco'];
                        } else {
                            banco = "";
                        }
                        if (val['fechaoper'] !== null) {
                            operbanco = "<b>Operación nro: </b>" + val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                        } else {
                            operbanco = "";
                        }
                        tabla = tabla +
                            "<div class='row rowcolor cfila' data-codcobro='" + val['codigo64'] + "' >" +
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
                            "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='" + val['codigo64'] + "' data-idocpg='" + val['idocpg64'] + "'>" +
                            "<i class='fas fa-trash-alt'></i>" +
                            "</button>" +
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
                var msgf = errorAjax(jqXHR, exception, 'text');
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
            vw_fcb_codigopago: codigo,
            vw_fcb_cbmedio: medio,
            vw_fcb_monto_cobro: monto,
            vw_fcb_cbbanco: banco,
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
                var nro = 0;
                var tabla = "";
                var montototalc = 0;
                var banco = "";

                $.each(e.vdata, function(index, val) {
                    nro++;
                    montototalc += parseFloat(val['montocob']);
                    if (val['nombanco'] !== null) {
                        banco = val['nombanco'];
                    } else {
                        banco = "";
                    }
                    tabla = tabla +
                        "<div class='row rowcolor cfila' data-codcobro='" + val['codigo64'] + "' >" +
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
                        "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='" + val['codigo64'] + "' data-idocpg='" + val['idocpg64'] + "'>" +
                        "<i class='fas fa-trash-alt'></i>" +
                        "</button>" +
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
            var msgf = errorAjax(jqXHR, exception, 'text');
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
            vw_fcb_codigocobro: codigo,
            vw_fcb_idocpago: idocpago,
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
                var nro = 0;
                var tabla = "";
                var montototalc = 0;
                var banco = "";
                var operbanco = "";
                if (e.vdata !== 0) {
                    $.each(e.vdata, function(index, val) {
                        nro++;
                        montototalc += parseFloat(val['montocob']);
                        if (val['nombanco'] !== null) {
                            banco = val['nombanco'];
                        } else {
                            banco = "";
                        }
                        if (val['fechaoper'] !== null) {
                            operbanco = "<b>Operación nro: </b>" + val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                        } else {
                            operbanco = "";
                        }
                        tabla = tabla +
                            "<div class='row rowcolor cfila' data-codcobro='" + val['codigo64'] + "' >" +
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
                            "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='" + val['codigo64'] + "' data-idocpg='" + val['idocpg64'] + "'>" +
                            "<i class='fas fa-trash-alt'></i>" +
                            "</button>" +
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
            var msgf = errorAjax(jqXHR, exception, 'text');
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
$("#modaddcobros").on('hidden.bs.modal', function(e) {
    $('#divcard_itemcobros').removeClass('d-none');
    $('#divcard_form_vouchercobro').addClass('d-none');
    $('.btnaddcobr').removeClass('d-none');
    $('.btnbnccobr').removeClass('d-none');
})
$('.btnaddoperacioncob').click(function() {
    var btn = $(this);
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
    $('#divtitle_banco').html("PAGO EN BANCO: " + nombanco);
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
    var btn = $(this);
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
            vw_fcb_codigopago: codigo,
            vw_fcb_cbmedio: medio,
            vw_fcb_monto_cobro: monto,
            vw_fcb_cbbanco: banco,
            vw_fcb_voucher: voucher,
            vw_fcb_fecha: fecha,
            vw_fcb_hora: hora
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
                var nro = 0;
                var tabla = "";
                var montototalc = 0;
                var banco = "";
                var operbanco = "";
                $.each(e.vdata, function(index, val) {
                    nro++;
                    montototalc += parseFloat(val['montocob']);
                    if (val['nombanco'] !== null) {
                        banco = val['nombanco'];
                    } else {
                        banco = "";
                    }
                    if (val['fechaoper'] !== null) {
                        operbanco = "<b>Operación nro: </b>" + val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                    } else {
                        operbanco = "";
                    }
                    tabla = tabla +
                        "<div class='row rowcolor cfila' data-codcobro='" + val['codigo64'] + "' >" +
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
                        "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='" + val['codigo64'] + "' data-idocpg='" + val['idocpg64'] + "'>" +
                        "<i class='fas fa-trash-alt'></i>" +
                        "</button>" +
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
            var msgf = errorAjax(jqXHR, exception, 'text');
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
$("#vw_fcb_btnedit_numero").click(function(event) {
    if ($(this).data('accion') == "auto") {
        $("#vw_fcb_sernumero_real").show();
        $("#vw_fcb_sernumero").hide();
        $(this).data('accion', "");
        $("#vw_fcb_sernumero_real").val("0")
        $(this).html('<i class="fas fa-undo-alt"></i>');
        $("#vw_fcb_sernumero_real").focus();
    } else {
        $("#vw_fcb_sernumero_real").hide();
        $("#vw_fcb_sernumero").show();
        $(this).data('accion', "auto");
        $("#vw_fcb_sernumero_real").val("0")
        $(this).html('<i class="fas fa-pencil-alt"></i>');
    }
});
fn_update_concepto

function fn_update_concepto(txt) {

    var fila = txt.closest('.rowcolor');
    var pos = fila.data('arraypos');
    var concepto = fila.find('input[name="vw_fcb_ai_txtgestion"]').val();
    itemsDocumento[pos]['vw_fcb_ai_txtgestion'] = concepto;
}

function fn_update_precios(txt) {

    var fila = txt.closest('.rowcolor');
    var pos = fila.data('arraypos');

    var pu = Number(fila.find('input[name="vw_fcb_ai_txtpreciounitario"]').val());
    itemsDocumento[pos]['vw_fcb_ai_txtpreciounitario'] = pu;
    var vcnt = fila.find('input[name="vw_fcb_ai_txtcantidad"]').val();
    var valorventa = Number(vcnt) * pu;
    itemsDocumento[pos]['vw_fcb_ai_txtcantidad'] = vcnt;
    /*itemsDocumento[pos].vw_fcb_ai_txtpreciounitario = pu;
    itemsDocumento[pos].vw_fcb_ai_txtprecioventa = Number(newvalue);
    itemsDocumento[pos].vw_fcb_ai_txtvalorunitario = Number(newvalue);*/

    var afectacion = itemsDocumento[pos]['vw_fcb_ai_cbafectacion'];

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
        /*var row = $("#vw_fcb_rowitem"+pos);
        $("#vw_fcb_rowitem"+pos+" input[name='vw_fcb_ai_txtprecioventa']").val(Number(newvalue));
        ;*/

    mostrar_montos();
}
$("#btn_prueba").click(function(event) {
    event.preventDefault();
    datos_carne($('#vw_fcb_codpagante').val(), "");
    return false;
});

function fn_matricula_update(boton) {
    var fila = boton.closest('.rowcolor');
    var idmat = fila.data('idm');
    $('#divmodaladdmat').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula/fn_matricula_x_codigo',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-idmat': idmat,
        },
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
            $('#divmodaladdmat #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Error!',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                $('#vw_dp_divmatricular').show();
                $('#titlemodal').html(e.matdata['nomalu']);

                $('#fm-txtidmatriculaup').val(e.matdata['id64']);
                $('#fm-txtidup').val(e.matdata['idins64']);
                $('#fm-txtcarreraup').val(e.matdata['codcarrera']);
                $('#fm-txtperiodoup').val(e.matdata['codperiodo'])
                $('#fm-txtplanup').val(e.matdata['codplan']);

                $('#fm-cbplanup').html(e.vplanes);
                $('#fm-cbplanup').val(e.matdata['codplan']);

                $('#fm-cbestadoup').html(e.vestados);
                $('#fm-cbestadoup').val(e.matdata['estado']);

                $('#fm-cbtipoup').val(e.matdata['tipo']);
                $('#fm-cbbeneficioup').val(e.matdata['beneficio']);
                $('#fm-txtfecmatriculaup').val(e.matdata['fecha']);
                $('#fm-txtcuotaup').val(e.matdata['pension']);

                $('#fm-cbperiodoup').attr('disabled', true);
                $('#fm-cbperiodoup').val(e.matdata['codperiodo']);
                $('#fm-carreraup').html(e.matdata['carrera']);
                $('#fm-cbcicloup').val(e.matdata['codciclo']);
                $('#fm-cbturnoup').val(e.matdata['codturno']);
                $('#fm-cbseccionup').val(e.matdata['codseccion']);

                $('#fm-txtobservacionesup').val(e.matdata['observacion']);

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            $('#divmodaladdmat #divoverlay').remove();
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
}

$("#modaddmatricula").on('hidden.bs.modal', function(e) {
    $('#vw_dp_divmatricular').hide();
    $("#frm-matricular")[0].reset();
    $('#fm-txtidmatriculaup').val('0');
    $('#fm-carreraup').html('PROGRAMA ACADÉMICO');
    $('#fm-cbperiodoup').attr('disabled', false);
    $('#fm-txtidup').val('');
    $('#fm-txtcarreraup').val('');
    $('#fm-txtperiodoup').val('')
    $('#fm-txtplanup').val('');
    $('#fm-cbplanup').html('');
    $('#btn_newmatricula').data('carne', '')
})

$('#btn_newmatricula').click(function(e) {
    var boton = $(this);
    var carne = boton.data('carne');
    $('#divmodaladdmat').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "inscrito/fn_get_datos_carne",
        type: 'post',
        dataType: 'json',
        data: {
            'fgi-txtcarne': carne,
        },
        success: function(e) {
            $('#divmodaladdmat #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'warning',
                    icon: 'warning',
                    title: 'ADVERTENCIA',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                $('#vw_dp_divmatricular').show();
                $('#fm-txtidup').val(e.vdata['idinscripcion']);
                $('#fm-txtidmatriculaup').val('0');
                $("#frm-matricular")[0].reset();
                $('#frm-matricular input,select').removeClass('is-invalid');
                $('#frm-matricular .invalid-feedback').remove();
                $('#fm-cbperiodoup').attr('disabled', false);

                if (e.vdata['idinscripcion'] == '0') {
                    $('#fm-txtcarreraup').val("");
                    $('#fm-carreraup').val("PROGRAMA ACADÉMICO");
                    $('#fm-cbplanup').html("<option value='0'>Plán curricular NO DISPONIBLE</option>");

                } else {

                    $('#fm-txtcarreraup').val(e.vdata['codcarrera']);
                    $('#fm-carreraup').html(e.vdata['carrera']);
                    $('#fm-cbplanup').html(e.vplanes);
                    $('#fm-cbplanup').val(e.vdata['codplan']);
                    $('#fm-txtplanup').val(e.vdata['codplan']);

                    $('#fm-txtmapepatup').val(e.vdata['paterno']);
                    $('#fm-txtmapematup').val(e.vdata['materno']);
                    $('#fm-txtmnombresup').val(e.vdata['nombres']);
                    $('#fm-txtmsexoup').val(e.vdata['sexo']);

                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodaladdmat #divoverlay').remove();
            $('#divError').show();
            $('#msgError').html(msgf);
        }
    })

    return false;
});

$('#lbtn_guardarmat').click(function(e) {
    $('#frm-matricular input,select').removeClass('is-invalid');
    $('#frm-matricular .invalid-feedback').remove();
    $('#divmodaladdmat').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $("#frm-matricular").attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#frm-matricular').serialize(),
        success: function(e) {
            $('#divmodaladdmat #divoverlay').remove();
            if (e.status == false) {
                if (e.newcod == 0) {
                    Swal.fire({
                        type: 'warning',
                        icon: 'warning',
                        title: 'Matrícula DUPLICADA',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error, matrícula NO actualizada',
                        text: e.msg,
                        backdrop: false,
                    })
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                }
            } else {

                $("#modaddmatricula").modal('hide');
                if (e.matstatus == "INSERTAR") {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones, matrícula registrada',
                        text: 'Se han registrado cursos',
                        backdrop: false,
                    })

                } else {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones, Matrícula actualizada correctamente',
                        text: 'verificar sus unidades didácticas de ser necesario',
                        backdrop: false,
                    })

                    $("#frmfiltro-matriculas").submit();
                }


            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodaladdmat #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error, matrícula NO actualizada',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
});
</script>
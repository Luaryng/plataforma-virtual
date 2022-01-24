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
                                    <option value="">Seleccione periodo</option>
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
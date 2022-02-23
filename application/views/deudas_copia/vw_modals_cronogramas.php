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
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
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >
                    <span id="md_crono_sede"></span> | <span id="md_crono_periodo"></span> | <span id="md_crono_nombre"></span> 
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="col-12">
                    <input type="hidden" id="md_crono_txt_codperiodo">
                    <input type="hidden" id="md_crono_txt_codsede">
                </div>
                
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
<div class="modal fade" id="modGrupos_matriculados" tabindex="-1" role="dialog" aria-labelledby="modGrupos_matriculados" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modGrupos_matriculados_content">
            <div class="modal-header">
                <h5 class="modal-title" >Grupos Académicos Asignar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <input type="hidden" name="vw_id_calendario_grp" id="vw_id_calendario_grp">
                <form id="frmfiltro-grupos" name="frmfiltro-grupos" action="<?php echo $vbaseurl ?>grupos/fn_filtrar" method="post" accept-charset='utf-8'>
                  <div class="row">
                    <div class="form-group has-float-label col-12 col-sm-4 col-md-2">
                      <select  class="form-control form-control-sm" id="fm-cbsede" name="fm-cbsede" placeholder="Filial">
                        <?php 
                          foreach ($sedes as $filial) {
                            $select=($vuser->idsede==$filial->id) ? "selected":"";
                            echo "<option $select value='$filial->id'>$filial->nombre</option>";
                          } 
                        ?>
                      </select>
                      <label for="fm-cbsede"> Filial</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbperiodo" name="fm-cbperiodo" placeholder="Periodo" required >
                        <?php foreach ($periodos as $periodo) {?>
                        <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fm-cbperiodo"> Periodo</label>
                    </div>
                    
                    <div class="form-group has-float-label col-12 col-sm-3">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbcarrera" name="fm-cbcarrera" placeholder="Programa Académico" required >
                        <option value="%">Todos</option>
                        <?php
                        foreach ($carrera as $carr) {
                        echo '<option value="'.$carr->id.'">'.$carr->nombre.'</option>';
                        }
                        ?>
                      </select>
                      <label for="fm-cbcarrera"> Prog. de Estudios</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                      <select name="fm-cbplan" id="fm-cbplan"class="form-control form-control-sm">
                        <option data-carrera="0" value="%">Todos</option>
                        <option data-carrera="0" value="0">Sin Plan</option>
                        <?php foreach ($planes as $pln) {
                        echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                        } ?>
                      </select>
                      <label for="fm-cbplan">Plan estudios</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbciclo" name="fm-cbciclo" placeholder="Ciclo" required >
                       <option value="%">Todos</option>
                        <?php
                        foreach ($ciclo as $cic) {
                        echo '<option value="'.$cic->codigo.'">'.$cic->nombre.'</option>';
                        }
                        ?>
                      </select>
                      <label for="fm-cbciclo"> Semestre</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbturno" name="fm-cbturno" placeholder="Turno" required >
                        <option value="%"></option>
                        <?php foreach ($turnos as $turno) {?>
                        <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fm-cbturno"> Turno</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbseccion" name="fm-cbseccion" placeholder="Sección" required >
                        <option value="%"></option>
                        <?php foreach ($secciones as $seccion) {?>
                        <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fm-cbseccion"> Sección</label>
                    </div>
                    <div class="col-12  col-sm-1">
                      <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
                </div>
                

                <div class="btable">
              <div class="thead col-12">
                <div class="row">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-2 td">N°</div>
                      <div class="col-md-4 td">PERIODO</div>
                      <div class="col-md-6 td">PLAN</div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-8 td">PROG. ACAD.</div>
                      <div class="col-md-4 td">GRUPO</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-3 td">MAT.</div>
                      <div class="col-md-3 td">ACT.</div>
                      <div class="col-md-3 td">RET.</div>
                      <div class="col-md-3 td">CUL.</div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="row">
                     
                      
                    </div>
                  </div>

                </div>
              </div>
              <div id="div-filtro" class="tbody col-12">
                
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
<?php 
  $vbaseurl=base_url();
  date_default_timezone_set ('America/Lima');
  $fecha = date("Y-m-d");
?>
<style type="text/css">
  .not-active { 
      pointer-events: none; 
      cursor: default; 
  }

  .drop-menu-index{
    z-index: 2500;
    position: relative;
  }

  table.dataTable tbody tr.selected a:not(.bg-danger,.bg-primary,.bg-info,.bg-success,.bg-warning,.bg-secondary, a.dropdown-item) {
    color: #007bff !important;
  }

</style>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>

<?php if (getPermitido("150")=='SI') { ?>
<!-- MODAL ACTIVAR -->
<div class="modal fade" id="modactiva" tabindex="-1" role="dialog" aria-labelledby="modactiva" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="divmodalactivar">
            <div class="modal-header">
                <h5 class="modal-title" id="divcard_title">INGRESE EL MOTIVO DE LA ACTIVACIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_activa_insc" action="<?php echo $vbaseurl ?>inscrito/fn_activa_inscripcion" method="post" accept-charset="utf-8">
                    <div class="row">
                        <input type="hidden" name="fic_inscodigo_activa" id="fic_inscodigo_activa" value="">
                        <input type="hidden" name="ficinscestado_activa" id="ficinscestado_activa" value="">
                        <input type="hidden" name="ficinsperiodo_activa" id="ficinsperiodo_activa" value="">
                        <div class="form-group has-float-label col-12">
                            <textarea name="ficmotivretiro_activa" id="ficmotivretiro_activa" class="form-control form-control-sm" rows="3" placeholder="Motivo"></textarea>
                            <label for="ficmotivretiro_activa">Motivo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="lbtn_activa_insc" data-coloran="" class="btn btn-primary">Activar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- MODAL RETIRAR -->
<div class="modal fade" id="modretirainsc" tabindex="-1" role="dialog" aria-labelledby="modretirainsc" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="divmodalretirar">
            <div class="modal-header">
                <h5 class="modal-title" id="divcard_title">INGRESE EL MOTIVO DEL RETIRO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_retira_insc" action="<?php echo $vbaseurl ?>inscrito/fn_retira_inscripcion" method="post" accept-charset="utf-8">
                    <div class="row">
                        <input type="hidden" name="fic_inscrip_codigo" id="fic_inscrip_codigo" value="">
                        <input type="hidden" name="ficinscestado" id="ficinscestado" value="">
                        <input type="hidden" name="ficinsperiodo" id="ficinsperiodo" value="">
                        <div class="form-group has-float-label col-12">
                            <textarea name="ficmotivretiro" id="ficmotivretiro" class="form-control form-control-sm" rows="3" placeholder="Motivo Retirado"></textarea>
                            <label for="ficmotivretiro">Motivo Retirado</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="lbtn_retira_insc" data-coloran="" class="btn btn-primary">Retirar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modgrupoingreso" tabindex="-1" role="dialog" aria-labelledby="modgrupoingreso" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="vw_md_gi_content">
      <div class="modal-header">
        <h5 class="modal-title" id="divcard_title">Grupo de Ingreso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="vw_md_gi_frmcambiargrupo" action="<?php echo $vbaseurl ?>inscrito/fn_cambiar_grupo_inscripcion" method="post" accept-charset="utf-8">
          <input type="hidden" name="vw_md_gi_inscrip_codigo" id="vw_md_gi_inscrip_codigo" value="">
            <input type="hidden" name="vw_md_gi_periodo" id="vw_md_gi_periodo" value="">
          <div class="row">
            <div class="col-12 col-md-12">
              Periodo: <span class="text-bold" id="vw_md_gi_spperiodo"></span>
            </div>
            <div class="col-12 col-md-12 mb-2">
              <span class="text-bold" id="vw_md_gi_carrera"></span>
            </div>
          </div>
          <div class="row mt-2">
            <div class="form-group has-float-label col-12 col-sm-4">
              <select data-currentvalue='' class="form-control" id="vw_md_gi_campania" name="vw_md_gi_campania" placeholder="Campaña" required >
                <option value="0">Selecciona</option>
                <?php foreach ($campanias as $campania) {?>
                <option value="<?php echo $campania->id ?>"><?php echo $campania->nombre ?></option>
                <?php } ?>
              </select>
              <label for="vw_md_gi_campania"> Campaña</label>
            </div>

            <div class="form-group has-float-label col-12 col-sm-2">
              <select data-currentvalue='' class="form-control" id="vw_md_gi_ciclo" name="vw_md_gi_ciclo" placeholder="Semestre Acad." required >
                <option value="0">Selecciona</option>
                <?php foreach ($ciclos as $ciclo) {?>
                <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                <?php } ?>
              </select>
              <label for="vw_md_gi_ciclo"> Semestre Acad.</label>
            </div>
            <div class="form-group has-float-label col-12 col-sm-3">
              <select data-currentvalue='' class="form-control" id="vw_md_gi_turno" name="vw_md_gi_turno" placeholder="Turno" required >
                <option value="0">Selecciona</option>
                <?php foreach ($turnos as $turno) {?>
                <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                <?php } ?>
              </select>
              <label for="vw_md_gi_turno"> Turno</label>
            </div>
            <div class="form-group has-float-label col-12 col-sm-2">
              <select data-currentvalue='' class="form-control" id="vw_md_gi_seccion" name="vw_md_gi_seccion" placeholder="Sección" required >
                <option value="0">Selecciona</option>
                <?php foreach ($secciones as $seccion) {?>
                <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                <?php } ?>
              </select>
              <label for="vw_md_gi_seccion"> Sección</label>
            </div>
            
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="vw_md_gi_btnguardar" data-coloran="" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- FIN MODAL RETIRAR -->

<div class="modal fade" id="modal-docporanexar" role="dialog" tabindex="-1" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">DOCUMENTOS ANEXADOS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='frm-docanexar' name='frm-docanexar' method='post' accept-charset='utf-8'>
                <div class="modal-body">
                  <span id="spn-carne"></span> <span id="spn_carrera" class="text-primary text-bold"></span><br>  
                  <b><span id="spn-alumno"></span></b>
                  <hr>
                  <input id="fdacodins" name="fdacodins" type="hidden" class="form-control" value="">
                  <div id="lista-no" class="col-12 text-center ocultar">
                    <div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>
                  </div>
                  <div id="lista-ok" class="row ocultar">
                    <div class="col-12">
                      <div class="d-none d-md-block">
                        <div class="row mt-3">
                          <div class="col-6">
                            <span class="h6"><b>Documentos</b></span>
                          </div>
                          <div class="col-2">
                            <span class="h6"><b>Periodo</b></span>
                          </div>
                          <div class="col-4">
                            <span class="h6"><b>Fecha de entrega / Observaciones</b></span>
                          </div>
                        </div>
                        <hr>
                      </div>
                    <?php foreach ($docs_anexar as $doc_anexar) {?>
                      <div class="row mb-2">
                        <div class="col-12 col-md-6">
                          <div class="brcheck">
                            <input class="check" type="checkbox" name="it<?php echo $doc_anexar->coddocumento ?>" id="it<?php echo $doc_anexar->coddocumento ?>" value="<?php echo $doc_anexar->coddocumento ?>" />
                            <label class="check__label" for="it<?php echo $doc_anexar->coddocumento ?>">
                                <i class="fas fa-check"></i>
                                <span class="texto"><?php echo $doc_anexar->nombre ?></span>
                            </label>
                          </div>
                        </div>
                        <div class="col-6 col-md-2">
                          <select class="form-control form-control-sm" id="period_it<?php echo $doc_anexar->coddocumento ?>" name="period_it<?php echo $doc_anexar->coddocumento ?>" disabled="">
                              <option value=""></option>
                              <?php foreach ($periodos as $periodo) {?>
                              <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                              <?php } ?>
                            </select>
                        </div>
                        <div class="col-6 col-md-4">
                          <input type="text" name="txt_it<?php echo $doc_anexar->coddocumento ?>" id="txt_it<?php echo $doc_anexar->coddocumento ?>" class="form-control form-control-sm" disabled="">
                        </div>
                      </div>
                      
                      <?php } ?> 
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Cerrar</button>
                    <?php if (getPermitido("143")=='SI') { ?>
                    <button class="btn btn-primary float-right" type="submit" > Guardar</button>
                    <?php } ?>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modanexadocs" tabindex="-1" role="dialog" aria-labelledby="modanexadocs" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="divmodanexar">
      <div class="modal-header">
        <h4 class="modal-title">Documentos anexados</h4>
        <button type="button" class="close anexclose" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="">
        <div class="col-12">
          <div class="row">
            <span class="text-primary text-bold" id="msgcarrera"></span>
          </div>
          <hr>
          <div class="d-none d-md-block">
            <div class="row mt-3">
              <div class="col-6">
                  <span class="h6"><b>Documentos</b></span>
              </div>
              <div class="col-2">
                <span class="h6"><b>Periodo</b></span>
              </div>
              <div class="col-4">
                  <span class="h6"><b>Fecha de entrega / Observaciones</b></span>
              </div>
            </div>
            <hr>
          </div>
          <?php foreach ($docs_anexar as $doc_anexar) {?>
            <div class="row mb-2">
              <div class="col-12 col-md-6">
                  <div class="brcheck">
                    <input class="check checkman" type="checkbox" name="itm<?php echo $doc_anexar->coddocumento ?>" id="itm<?php echo $doc_anexar->coddocumento ?>" value="<?php echo $doc_anexar->coddocumento ?>" data-abrev="<?php echo $doc_anexar->abrevia ?>" />
                    <label class="check__label" for="itm<?php echo $doc_anexar->coddocumento ?>">
                        <i class="fas fa-check"></i>
                        <span class="texto"><?php echo $doc_anexar->nombre ?></span>
                    </label>
                  </div>
              </div>
              <div class="col-6 col-md-2">
                <select class="form-control form-control-sm" id="period_itm<?php echo $doc_anexar->coddocumento ?>" name="period_itm<?php echo $doc_anexar->coddocumento ?>" disabled="">
                    <option value=""></option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
              </div>
              <div class="col-6 col-md-4">
                  <input type="text" name="txt_itm<?php echo $doc_anexar->coddocumento ?>" id="txt_itm<?php echo $doc_anexar->coddocumento ?>" class="form-control form-control-sm" disabled="">
              </div>
            </div>
            
            <?php } ?> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary anexclose" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary anexclose" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-sendemail" tabindex="-1" role="dialog" aria-labelledby="modal-sendemail" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content" id="divmodalsend">
      <div class="modal-header">
        <h5 class="modal-title" >ENVIAR MENSAJE</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="fictxtperiodo" id="fictxtperiodo" value="">
          <input type="hidden" name="fictxtcarnet" id="fictxtcarnet" value="">
          <input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="">
          <div class="form-group has-float-label col-12">
            <input autocomplete="off" class="form-control" id="fictxtemailper" name="fictxtemailper" type="email" placeholder="Email">
            <label for="fictxtemailper">Email</label>
          </div>
          
          <div class="col-12">
            <div class="form-check">
              <input checked="" class="form-check-input" type="checkbox" id="checksaludo">
              <label for="checksaludo">Saludo de aprobación</label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check">
              <input checked="" class="form-check-input" type="checkbox" id="checkcredenciales">
              <label for="checkcredenciales">Credenciales (incluye enclace de erp)</label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check">
              <input checked="" class="form-check-input" type="checkbox" id="checkmanuales">
              <label for="checkmanuales">Manuales y videotutoriales</label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check">
              <input checked="" class="form-check-input" type="checkbox" id="checkficha">
              <label for="checkficha">Ficha inscripción</label>
            </div>
          </div>
          <div class="col-12" id="vw_md_em_aviso"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="lbtn_send" class="btn btn-primary"> Enviar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="vw_md_historial_mat" tabindex="-1" role="dialog" aria-labelledby="vw_md_historial_mat" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="vw_dp_mc_matriculas">
            <div class="modal-header">
                <h5 class="modal-title" id="divcard_title">Historial de Matricula</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="vw_dp_divHistorial_inscripciones">
              <div class="col-12" id="tabdivres-matriculas">
                  <table id="tbmt_dtmatriculas" class="tbdatatable table table-sm table-hover table-bordered table-condensed" style="width:100%">
                    <thead>
                      <tr class="bg-lightgray">
                        <th>N°</th>
                        <th>Filial</th>
                        <th>Carné</th>
                        <th>Estudiante / Edad</th>
                        <th>Fec.Mat.</th>
                        <th>Cuota</th>
                        <th>Plan</th>
                        <th>Grupo</th>
                        <th>Est</th>
                      </tr>
                    </thead>
                    <tbody>
                                  
                    </tbody>
                  </table>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a id="vw_dp_mc_btn_nuevamatricula" href="#" class="btn btn-primary">Nueva Matricula</a>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Inscripciones</h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <section id="s-cargado" class="content pt-2">

    <div id="divboxhistorial" class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link active" href="#busqueda" data-toggle="tab">
              <i class="fas fa-search"></i> Búsqueda
            </a>
          </li>
          <?php if (getPermitido("44")=='SI') { ?>
          <li id="tabli-aperturafile" class="nav-item">
            <a class="nav-link" href="#ficha-personal" data-toggle="tab">
              <i class="fas fa-user-plus"></i> Inscripciones
            </a>
          </li>
          <?php } ?>
        </ul>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-2">
        <div class="tab-content">
          <div class="active tab-pane pt-3" id="busqueda">
            <!--<div class="card-header">-->
            
            <form id="frm-filtro-inscritos" name="frm-filtro-inscritos" action="<?php echo $vbaseurl ?>inscrito/get_filtrar_basico_sd_activa" method="post" accept-charset='utf-8'>
              
              <div class="row my-2">
                <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                  <select class="form-control form-control-sm" id="fbus-periodo" name="fbus-periodo" placeholder="Periodo lectivo">
                    <option value="%">Todos</option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-carrera">Periodo lectivo</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fbus-campania" name="fbus-campania" placeholder="Campaña" required >
                    <option value="%">Todas</option>
                  </select>
                  <label for="fbus-campania"> Campaña</label>
                </div>

                <div class="form-group has-float-label col-12 col-sm-3 col-md-3">
                  <select class="form-control form-control-sm" id="fbus-carrera" name="fbus-carrera" placeholder="Programa">
                    <option value="%">Todos</option>
                    <?php foreach ($carreras as $carrera) {?>
                    <option value="<?php echo $carrera->codcarrera ?>" data-sigla="<?php echo $carrera->sigla ?>"><?php echo $carrera->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-carrera"> Programa</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fbus-ciclo" name="fbus-ciclo" placeholder="Semestre Acad." required >
                    <option value="%">Selecciona</option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-ciclo"> Semestre</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fbus-turno" name="fbus-turno" placeholder="Turno" required >
                    <option value="%">Todos</option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-turno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fbus-seccion" name="fbus-seccion" placeholder="Sección" required >
                    <option value="%">Todas</option>
                    <?php foreach ($secciones as $seccion) {?>
                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-seccion"> Sección</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-6 col-md-4">
                  <input autocomplete="off"  class="form-control form-control-sm text-uppercase" id="fbus-txtbuscar" name="fbus-txtbuscar" type="text" placeholder="Carné o Apellidos y nombres"   />
                  <label for="fbus-txtbuscar">Carné o Apellidos y nombres</label>
                </div>
                
                <div class="col-4 col-sm-3 col-md-1">
                  <button type="submit" class="btn btn-primary btn-block btn-sm"><i class="fas fa-search"></i></button>
                </div>

                <div class="col-6 col-sm-3 col-md-2">
                  <a href="#" class="btn-excel btn btn-outline-secondary btn-sm">
                    <img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt="" style="height: 20px"> Exportar
                  </a>
                </div>


              </div>
              
            </form>
            <!--</div>-->
            <div class="card-body no-padding">
              <div class="row">
                <div class="col-12 py-1" id="divres-historial">
                  <div class="row div-resultados">
                    <div class="col-12" id="tabdivres-inscritos">
                      <table id="tbmt_dtinscritos" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                        <thead>
                          <tr class="bg-lightgray">
                            <th>N°</th>
                            <th>Periodo</th>
                            <th>Campaña</th>
                            <th>Programa</th>
                            <th>Carné</th>
                            <th>Estudiante</th>
                            <th>Fec. Insc.</th>
                            <th>Estado</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                                      
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-12 py-1" id="divres-historial-msg"></div>
                
              </div>
            </div>
          </div>
          <?php if (getPermitido("44")=='SI') { ?>
          <div class="tab-pane" id="ficha-personal">
            <!-- MultiStep Form -->

                <div class="card-body p-2">
                  
                  <form id="frmins-postulante" action="<?php echo $vbaseurl ?>persona/fn_getdatosminimos_x_dni" method="post" accept-charset='utf-8'>
                    <b class="d-block pt-2 pb-4 text-danger"><i class="fas fa-user-circle"></i> POSTULANTE</b>
                    <!--<label for="ficodpostulante">Nro Postulante:</label>-->

                    <div class="row margin-top-20px">
                      <div class="input-group mb-3 col-12 col-sm-3">
                        <input placeholder="DNI" type="text" class="form-control" id="ficodpostulante" name="ficodpostulante">
                        <div class="input-group-append">
                          <button data-paterno='' data-materno='' data-nombres='' class="btn btn-info" type="submit" >
                          <i class="fas fa-arrow-alt-circle-right"></i>
                          </button>
                        </div>
                      </div>
                      <div class="form-group col-12 col-sm-5">
                        <span id="fipos-apellidos" class="form-control bg-light"></span>
                      </div>
                      <div class="form-group col-12 col-sm-4">
                        <span id="fipos-nombres" class="form-control bg-light"></span>
                      </div>
                    </div>
                  </form>

                  <form id="frmins-inscripcion" action="<?php echo $vbaseurl ?>inscrito/fn_insert" method="post" accept-charset='utf-8'>
                    <div class="row mt-2">
                      <div class="form-group has-float-label col-12 col-sm-3">
                        <select name="cbodispacacidad" id="cbodispacacidad" class="form-control">
                          <option value="NO">NO</option>
                          <option value="SI">SI</option>
                        </select>
                        <label for="cbodispacacidad">¿Tiene alguna discapacidad?</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-4 d-none divcard_detdiscap">
                        <select data-currentvalue='' class="form-control" id="ficbdiscapacidad" name="ficbdiscapacidad" >
                          <option value="0">Selecciona discapacidad</option>
                          <?php 
                          foreach ($discapacidades as $disc) {
                            $grupod = "";
                            if ($disc->detalle != "" || $disc->detalle != null) {
                              $grupod = $disc->grupo." - ".$disc->detalle;
                            } else {
                              $grupod = $disc->grupo;
                            }
                          ?>
                          <option value="<?php echo $disc->codigo ?>"><?php echo $grupod ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbdiscapacidad"> Discapacidad</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-5 d-none divcard_detdiscap" id="">
                        <input class="form-control" type="text" name="txtdetadiscapac" id="txtdetadiscapac" placeholder="Especificar ¿Cúal es su discapacidad?">
                        <label for="txtdetadiscapac">Especificar ¿Cúal es su discapacidad?</label>
                      </div>
                      
                    </div>
                    <b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> PROCESO DE ADMISIÓN</b>
                    <input data-currentvalue='' id="fimcid" name="fimcid" type="hidden" />

                    <input data-currentvalue='' id="fimcpaterno" name="fimcpaterno" type="hidden" />
                    <input data-currentvalue='' id="fimcmaterno" name="fimcmaterno" type="hidden" />
                    <input data-currentvalue='' id="fimcnombres" name="fimcnombres" type="hidden" />
                    <input data-currentvalue='' id="fimcsexo" name="fimcsexo" type="hidden" />

                    <input data-currentvalue='' id="fitxtdni" name="fitxtdni" type="hidden" />
                    <input data-currentvalue='' id="ficbcarsigla" name="ficbcarsigla" type="hidden" />
                    
                    <div class="row margin-top-20px">
                      <div class="form-group has-float-label col-12 col-sm-5">
                        <select data-currentvalue='' class="form-control" id="ficbmodalidad" name="ficbmodalidad" placeholder="Modalidad" required >
                          <option value="0">Selecciona modalidad</option>
                          <?php foreach ($modalidades as $modalidad) {?>
                          <option value="<?php echo $modalidad->id ?>"><?php echo $modalidad->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbmodalidad"> Modalidad</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-3">
                        <select data-currentvalue='' class="form-control" id="ficbperiodo" name="ficbperiodo" placeholder="Periodo lectivo" required >
                          <option value="0">Selecciona periodo</option>
                          <?php foreach ($periodos as $periodo) {?>
                          <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbperiodo"> Periodo lectivo</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-4">
                        <select data-currentvalue='' class="form-control" id="ficbcampania" name="ficbcampania" placeholder="Campaña" required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($campanias as $campania) {?>
                          <option value="<?php echo $campania->id ?>"><?php echo $campania->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbcampania"> Campaña</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-12 d-none" id="divcard_traslado">
                        <input type="text" name="fictxtinstproceden" id="fictxtinstproceden" placeholder="Instituto de Traslado" class="form-control">
                        <label for="fictxtinstproceden">Instituto de Traslado</label>
                      </div>

                      <div class="form-group col-12 col-sm-12">
                        <span id="fiins-spcampania" class=" form-control bg-light"></span>
                      </div>
                    </div>
                    <b class="pt-2 pb-4 text-danger d-block"><i class="fas fa-user-circle"></i> DATOS ACADÉMICOS</b>
                    <div class="row margin-top-20px">
                      <div class="form-group has-float-label col-12 col-sm-5">
                        <select data-currentvalue='' class="form-control" id="ficbcarrera" name="ficbcarrera" placeholder="Programa de estudios" required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($carreras as $carrera) {?>
                          <option value="<?php echo $carrera->codcarrera ?>" data-sigla="<?php echo $carrera->sigla ?>" data-nombre="<?php echo $carrera->nombre ?>"><?php echo $carrera->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbcarrera"> Programa de estudios</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-2">
                        <select data-currentvalue='' class="form-control" id="ficbciclo" name="ficbciclo" placeholder="Semestre Acad." required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($ciclos as $ciclo) {?>
                          <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbciclo"> Semestre Acad.</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-3">
                        <select data-currentvalue='' class="form-control" id="ficbturno" name="ficbturno" placeholder="Turno" required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($turnos as $turno) {?>
                          <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbturno"> Turno</label>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-2">
                        <select data-currentvalue='' class="form-control" id="ficbseccion" name="ficbseccion" placeholder="Sección" required >
                          <option value="0">Selecciona</option>
                          <?php foreach ($secciones as $seccion) {?>
                          <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                          <?php } ?>
                        </select>
                        <label for="ficbseccion"> Sección</label>
                      </div>
                      <div class="form-group col-12 col-sm-12">
                        <!-- <label for="ficbsdocanexados">Documentos anexados</label>
                        <select id="ficbsdocanexados" title='Selecciona documentos anexados' data-actions-box="true" multiple class="selectpicker form-control" multiple data-live-search="true">
                          <?php foreach ($docs_anexar as $doc_anexar) {?>
                          <option value="<?php echo $doc_anexar->coddocumento ?>" title="<?php echo $doc_anexar->abrevia ?>"><?php echo $doc_anexar->nombre ?></option>
                          <?php } ?>
                        </select> -->
                        <button type="button" class="btn btn-outline-secondary btn-block text-left" id="btn_docanex" data-toggle="modal" data-target="#modanexadocs">Documentos anexados</button>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-12">
                        <textarea class="form-control" id="fitxtobservaciones" name="fitxtobservaciones" placeholder="Observaciones"  rows="3"></textarea>
                        <label for="fitxtobservaciones"> Observaciones</label>
                      </div>
                      <div class="col-12 mb-3" id="divcard_publicidad">
                        <h4 class="title-seccion text-danger">¿Como se enteró de nuestros programas?</h4>
                        <div class="row ml-3">
                          <?php
                            $nro = 0;
                            foreach ($publicidad as $key => $pb) {
                              $nro ++;
                          ?>
                          <div class="col-12 divcheck">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checkpublicidad" id="checkpub<?php echo $nro ?>" data-codigo="<?php echo $pb->codigo ?>">
                                <label class="custom-control-label" for="checkpub<?php echo $nro ?>"><?php echo $pb->nombre ?></label>
                            </div>
                          </div>
                          <?php
                            }
                          ?>
                          
                        </div>
                      </div>
                      <div class="form-group has-float-label col-12 col-sm-3">
                        <input data-currentvalue='' class="form-control text-uppercase" value="<?php echo date("Y-m-d"); ?>" id="fitxtfecinscripcion" name="fitxtfecinscripcion" type="date" placeholder="Fec. Inscripción"   />
                        <label for="fitxtfecinscripcion">Fec. Inscripción</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <span id="fispedit" class="text-danger"></span>
                        <button id="btn-inscribir" data-step='ins' type="submit" class="btn btn-primary btn-lg float-right"><i class="fas fa-arrow-circle-right"></i> Inscribir</button>
                        <button type="button" id="btn-cancelar" class="btn btn-danger btn-lg float-right mr-3"><i class="fas fa-undo"></i> Cancelar</button>
                      </div>
                    </div>
                  </form>
                  
                </div>
              <!--</div>
            
             /.MultiStep Form -->
          </div>
          <?php } ?>
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.card-body -->
    </div>
    
  </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>

<script>
  var cd1 = '<?php echo base64url_encode("1") ?>';
  var cd2 = '<?php echo base64url_encode("2") ?>';
  var cd7 = '<?php echo base64url_encode("7") ?>';

  $('.tbdatatable tbody').on('click', 'tr', function() {
    tabla = $(this).closest("table").DataTable();
    if ($(this).hasClass('selected')) {
        //Deseleccionar
        //$(this).removeClass('selected');
    } else {
        //Seleccionar
        tabla.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
  });

  $(document).ready(function() {
    if (vdnipostulante!==""){
      $('.nav-pills a[href="#ficha-personal"]').tab('show');
      $("#frmins-postulante #ficodpostulante").val(vdnipostulante);
      $("#frmins-postulante").submit();
    }
    else{
      var jscarnet=getUrlParameter("fcarnet","");
      $("#fbus-txtbuscar").val(jscarnet);

      setTimeout(function(){
          $("#frm-filtro-inscritos").submit();
      }, 1000);
      
    }

    $('#divres-historial').hide();
    var table = $('#tbmt_dtinscritos, #tbmt_dtmatriculas').DataTable({
        "autoWidth": false,
        "pageLength": 50,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, // your case first column
            "className": "text-right rowhead",
            "width": "8px"
        }],
        'searching': false,
        dom: "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

    });
  });

  $('#ficbmodalidad').change(function(){
    var combo = $(this);
    var item = combo.val();
    if (item == "0" || item == 1) {
      $('#divcard_traslado').addClass('d-none');
      $("#fictxtinstproceden").prop("required",false);
    } else if (item == 2) {
      $('#divcard_traslado').removeClass('d-none');
      $("#fictxtinstproceden").prop("required",true);
      
    } else if (item == 3) {
      $('#divcard_traslado').addClass('d-none');
      $("#fictxtinstproceden").prop("required",false);
    }
    
  });

  $('#cbodispacacidad').change(function() {
    var combo = $(this);
    var item = combo.val();
    if (item =='SI') {
      $('.divcard_detdiscap').removeClass('d-none');
    } else {
      $('.divcard_detdiscap').addClass('d-none');
    }
  });

  var vdnipostulante='<?php echo $dnipostula; ?>';
  $('.selectpicker').selectpicker({
      iconBase: 'fa',
      tickIcon: 'fa-check',
  });

  $("#frmins-inscripcion").hide();
  $("#frmins-postulante").submit(function(event) {
      /* Act on the event */
      $('#frmins-postulante input,select').removeClass('is-invalid');
      $('#frmins-postulante .invalid-feedback').remove();
      $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

     
      $.ajax({
          url: $(this).attr("action"),
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(e) {
              $('#divboxhistorial #divoverlay').remove();
              if (e.status == false) {
                  $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                  });
              } else {
                  $('#fimcid').val(e.vdata['idpersona']);
                  $("#frmins-inscripcion")[0].reset();
                  if (e.vdata['idpersona'] == '0') {
                      $('#fipos-apellidos').html('NO ENCONTRADO');
                      $('#fipos-nombres').html('NO ENCONTRADO');
                      $("#frmins-inscripcion").hide();
                      $('#fimcpaterno').val("");
                      $('#fimcmaterno').val("");
                      $('#fimcnombres').val("");
                      $('#fimcsexo').val("");
                      
                  } else {
                      $('#fitxtdni').val(e.vdata['dni']);

                      $('#fimcpaterno').val(e.vdata['paterno']);
                      $('#fimcmaterno').val(e.vdata['materno']);
                      $('#fimcnombres').val(e.vdata['nombres']);
                      $('#fimcsexo').val(e.vdata['sexo']);

                      



                      $('#fipos-apellidos').html(e.vdata['paterno'] + ' ' + e.vdata['materno']);
                      $('#fipos-nombres').html(e.vdata['nombres']);
                      $("#frmins-inscripcion").show();

                  }
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#divboxhistorial #divoverlay').remove();
              $('#divError').show();
              $('#msgError').html(msgf);
          }
      });
      return false;
  });

  $("#btn-cancelar").click(function(event) {
    /* Act on the event */
    $("#frmins-inscripcion").hide();
    $("#frmins-inscripcion")[0].reset();
  });

  $("#frmins-inscripcion").submit(function(event) {
      /* Act on the event */
      $('#frmins-inscripcion input,select').removeClass('is-invalid');
      $('#frmins-inscripcion .invalid-feedback').remove();
      $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      var carrera=$("#ficbcarrera option:selected").text();
     

      Arrdocs = [];
      arraypublic = [];
      arraydocs = []; 
      // $.each($("#ficbsdocanexados option:selected"), function() {
      //     Arrdocs.push($(this).val());
      // });
      
      $('#divcard_publicidad .divcheck .checkpublicidad').each(function() {
        var check = $(this);
        var idpub = "";
        if (check.prop('checked') == true) {
          var idpub = check.data('codigo');
        }

        if (idpub !== "") {
          // var myvals = [idpub];
          arraypublic.push(idpub);
        }
        
      })

      $('#modanexadocs input[type=checkbox]').each(function () {
        if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(3);
            var detalle = $('#txt_'+check.attr('id')).val();
            var periodo = $('#period_'+check.attr('id')).val();

            var myvals = [valor,detalle, periodo];
            arraydocs.push(myvals);
        }
      });

      adocs= JSON.stringify(arraydocs);
      apublic = JSON.stringify(arraypublic);

      fdata=$(this).serializeArray();
      fdata.push({name: 'doc-anexados', value: adocs});
      fdata.push({name: 'inspublicidad', value: apublic});

      $.ajax({
          url: $(this).attr("action"),
          type: 'post',
          dataType: 'json',
          data: fdata,
          success: function(e) {
              $('#divboxhistorial #divoverlay').remove();
              if (e.status == false) {
                 if (e.newcod==0){
                  Swal.fire({
                      type: 'warning',
                      icon: 'warning',
                      title: 'INSCRIPCIÓN DUPLICADA: ' + carrera,
                      text: e.msg,
                      backdrop:false,
                  })
                }else{
                   $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                  });
                  Swal.fire({
                      type: 'error',
                      icon: 'error',
                      title: 'Error, INSCRIPCIÓN NO registrada',
                      text: e.msg,
                      backdrop:false,
                  })
                }
              } 
              else {
                var sb=(getUrlParameter("sb","")=="") ? "":"&sb=admision";
                location.href = base_url + "admision/inscripciones?fcarnet=" + e.newcarnet + sb;
                Swal.fire({
                  type: 'success',
                  icon: 'success',
                  title: 'Felicitaciones, inscripción registrada',
                  text: e.newcarnet,
                  backdrop:false,
                })
                /*$("#frmins-inscripcion").hide();
                $("#frmins-inscripcion")[0].reset();
                $('.divcard_detdiscap').addClass('d-none');*/

              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#divboxhistorial #divoverlay').remove();
              $('#divError').show();
              $('#msgError').html(msgf);
          }
      });
      return false;
  });

  $("#frmins-inscripcion #ficbperiodo").change(function(event) {
      var cbcmp = $('#frmins-inscripcion #ficbcampania');
      $('#frmins-inscripcion #fiins-spcampania').html("");
      cbcmp.html("<option value='0'>Sin opciones</option>");
      var codperiodo = $(this).val();
      if (codperiodo == '0') return;
      $.ajax({
          url: base_url + 'campania/fn_campania_por_periodo',
          type: 'post',
          dataType: 'json',
          data: {
              txtcodperiodo: codperiodo
          },
          success: function(e) {
              cbcmp.html(e.vdata);
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              cbcmp.html("<option value='0'>" + msgf + "</option>");
          }
      });
  });

  $("#fbus-periodo").change(function(event) {
      cbcmp = $('#fbus-campania');
      cbcmp.html("");
      cbcmp.html("<option value='%'>Todas</option>");
      var codperiodo = $(this).val();
      if (codperiodo == '%') return;
      $.ajax({
          url: base_url + 'campania/fn_campania_por_periodo',
          type: 'post',
          dataType: 'json',
          data: {
              txtcodperiodo: codperiodo
          },
          success: function(e) {
              cbcmp.html(e.vdata);
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              cbcmp.html("<option value='0'>" + msgf + "</option>");
          }
      });
  });
  $("#frmins-inscripcion #ficbcampania").change(function(event) {
      var cbcmp = $('#frmins-inscripcion #fiins-spcampania');
      cbcmp.html("");
      if ($(this).val !== "0") cbcmp.html($('option:selected', this).data('descripcion'))
  });
  $("#frmins-inscripcion #ficbcarrera").change(function(event) {
      var cbcmp = $('#frmins-inscripcion #ficbcarsigla');
      cbcmp.html("");
      if ($(this).val !== "0") cbcmp.val($('option:selected', this).data('sigla'))
  });
//<option value='0'>Seleccionar Campaña</option>

  $("#frm-filtro-inscritos").submit(function(event) {
    $('#frm-filtro-inscritos input,select').removeClass('is-invalid');
    $('#frm-filtro-inscritos .invalid-feedback').remove();
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var llenos=0;
    var tb_head_ins = "";
    if ($("#fbus-txtbuscar").val()!=="") llenos=llenos + 2;
    if ($("#fbus-periodo").val()!=="%") llenos++;
    if ($("#fbus-campania").val()!=="%") llenos++;
    if ($("#fbus-seccion").val()!=="%") llenos++;
    if ($("#fbus-carrera").val()!=="%") llenos++;
    if ($("#fbus-turno").val()!=="%") llenos++;
    if ($("#fbus-ciclo").val()!=="%") llenos++;
    if (llenos>1) {
      tbinscritos = $('#tbmt_dtinscritos').DataTable();
      tbinscritos.clear();
      $('#divres-historial').show();
      $("#divres-historial-msg").hide();
      $.ajax({
          url: $(this).attr("action"),
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(e) {
              $('#divboxhistorial #divoverlay').remove();
              if (e.status == false) {
                  $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                  });
                  $("#divres-historial").html("");
              } else {
                  
                  var nro = 0;
                  $.each(e.vdata, function(index, v) {
                    nro++;
                    var btnscolor = "";
                    var classbtndis = "";
                    var dropdown_op = '';
                    var btndelete = "";
                    var btnupdgrupo = "";
                    var btnupdatein = "";
                    switch (v['estado']) {
                        case "ACTIVO":
                            btnscolor = "btn-success";
                            classbtndis = "not-active";
                            break;
                        case "POSTULA":
                            btnscolor = "btn-warning";
                            classbtndis = "";
                            break;
                        case "EGRESADO":
                            btnscolor = "btn-secondary";
                            classbtndis = "not-active";
                            break;
                        case "RETIRADO":
                            btnscolor = "btn-danger";
                            classbtndis = "";
                            break;
                        case "TITULADO":
                            btnscolor = "btn-info";
                            classbtndis = "not-active";
                            break;
                        default:
                            btnscolor = "btn-warning";
                            classbtndis = "not-active";
                    }

                    urlprint = base_url + "admision/postulante/imprimir/"+v['codper64']+"/"+v['idins64'];

                    if (e.vpermiso140 == "SI") {
                      btnupdatein = "<a class='dropdown-item' href='#' title='Editar Inscripción'><i class='fas fa-edit mr-2'></i> Editar Inscripción</a>";
                    }

                    if (e.vpermiso141 == "SI") {
                      btnupdgrupo = "<a onclick='grupo_inscripcion($(this))' href='#'><i class='far fa-edit ml-2'></i></a>";
                    }

                    if (e.vpermiso124 == "SI") {
                      btndelete = "<a href='#' onclick='fn_eliminar_ins($(this));return false;' data-ci='"+v['idins64']+"' class='btn-delete dropdown-item text-danger text-bold'><i class='fas fa-trash-alt'></i> Eliminar</a>";
                    }

                    if (v['estado'] !== "RETIRADO") {
                      if (e.vpermiso142 == "SI") {
                        dropdown_op = dropdown_op +'<a href="#" onclick="fn_cambiarestado($(this));return false;" class="btn-cestado dropdown-item" data-color="btn-success" data-ie="'+e.cd1+'">Activo</a>'+ 
                      '<a href="#" class="dropdown-item" data-color="btn-danger" data-ie="'+e.cd2+'" data-toggle="modal" data-target="#modretirainsc" id="btnretira_inscrip'+v['idins64']+'">Retirado</a> '+
                      '<a href="#" onclick="fn_cambiarestado($(this));return false;" class="btn-cestado dropdown-item" data-color="btn-secondary" data-ie="'+e.cd3+'">Egresado</a> '+
                      '<a href="#" onclick="fn_cambiarestado($(this));return false;" class="btn-cestado dropdown-item" data-color="btn-info" data-ie="'+e.cd4+'">Titulado</a> '+
                      '<a href="#" onclick="fn_cambiarestado($(this));return false;" class="btn-cestado dropdown-item" data-color="btn-warning" data-ie="'+e.cd5+'">Postula</a> '+
                      '<div class="dropdown-divider"></div>';
                      }
                    } else {
                      if (e.vpermiso150 == "SI") {
                        dropdown_op = dropdown_op + '<a href="#" onclick="fn_modactiva($(this));return false;" class="btn_actestado dropdown-item" data-color="btn-success" data-ie="'+e.cd1+'" id="btnactiva_ins_'+v['idins64']+'">Activo</a> ';
                      }
                    }
                    
                    dropdown_estado = '<div class="btn-group " id="btn-group-'+v['idins64']+'">' +
                            '<button class="btn ' + btnscolor + ' btn-sm text-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                              (v['estado'].toLowerCase()).charAt(0).toUpperCase() + (v['estado'].toLowerCase()).slice(1) +
                            '</button>' +
                            '<div class="dropdown-menu dropdown-menu-right drop-menu-index">' +
                              dropdown_op +
                              btndelete+
                            '</div>' +
                          '</div>';

                    dropdown_acc = "<div class='btn-group'>"+
                            "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1 rounded' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                "<i class='fas fa-cog'></i>"+
                            "</a>"+
                            "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                              btnupdatein+
                              "<a class='dropdown-item btn-anexados' href='#' title='Documentos Anexados' data-ci='"+v['idins64']+"' data-toggle='modal' data-target='#modal-docporanexar' data-carrera='"+v['carrera']+"'>"+
                                "<i class='fas fa-edit mr-2'></i> Documentos Anexados"+
                              "</a>"+
                              "<a class='dropdown-item' href='#' title='Enviar mensaje' data-ci='"+v['idins64']+"' data-emailper='"+v['epersonal']+"' data-carnet='"+v['carnet']+"' data-toggle='modal' data-target='#modal-sendemail'>"+
                                "<i class='fas fa-envelope mr-2'></i> Enviar mensaje"+
                              "</a>"+
                            "</div>"+
                          "</div>";

                    imprficha = "<a class='bg-info py-1 px-2 rounded ml-1' target='_blank' href='"+urlprint+"' title='Imprimir ficha'>"+
                                  "<i class='fas fa-print'></i> "+
                                "</a>";

                    btnmatric = "<a onclick='cargar_historial_matriculas($(this));return false;' data-carnet='"+v['carnet']+"' data-estado='"+v['estado']+"' class='bg-secondary py-1 px-2 rounded ml-1 histo_mat' target='_blank' href='#' title='Matricular'>"+
                                  "<i class='fas fa-graduation-cap'></i> "+
                                "</a>";

                    icongen = (v['sexo'] =='MASCULINO') ? '<i class="fas fa-male fa-lg text-primary"></i>':'<i class="fas fa-female  fa-lg text-danger"></i>'

                    vcarnet = "<div class='cell-carne' title='"+v['codinscripcion']+"'>"+v['carnet']+"</div>";

                    nombres = "<div class='cell-estudiante d-inline-block'>"+v['paterno']+' '+v['materno']+' '+v['nombres']+"</div>";

                    grupo = "<div title='"+v['carrera']+"'>" + v['carsigla']+' / '+v['codturno']+' - '+v['ciclo']+' - '+v['codseccion'] +btnupdgrupo+ "</div>";

                    var fila = tbinscritos.row.add([index + 1, v['periodo'], v['campania'], grupo, vcarnet, icongen+" "+nombres, v['fechains'], dropdown_estado, dropdown_acc + " " + imprficha + " " + btnmatric]).node();

                    $(fila).attr('data-ci', v['idins64']);
                    $(fila).attr('data-cp', v['codperiodo']);
                    $(fila).attr('data-codcampania', v['codcampania']);
                    $(fila).attr('data-cic', v['codciclo']);
                    $(fila).attr('data-codciclo', v['codciclo']);
                    $(fila).attr('data-codturno', v['codturno']);
                    $(fila).attr('data-codseccion', v['codseccion']);
                    $(fila).attr('data-carrera', v['carrera']);

                    $(fila).attr('class', "cfila");
                  })

                  tbinscritos.draw();

              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#divboxhistorial #divoverlay').remove();
              $("#divres-historial").html("");
              Swal.fire({
                  type: 'error',
                  title: 'Error, no se pudo mostrar los resultados',
                  text: msgf,
                  backdrop: false,
              })
          }
      });
    }
    else{
      $('#divboxhistorial #divoverlay').remove();
      $("#divres-historial-msg").show();
      $('#divres-historial').hide();
      $('.tbdatatable tbody').html("");
      $("#divres-historial-msg").html("<span class='text-danger'>Indicar como minimo 2 parametros de búsqueda</span>");      
    }
    return false;
  });
  
  $('.check').change(function(e) {
    $('#frm-docanexar input[type=checkbox]').each(function () {
          if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(2);
            $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', false);
            $('#frm-docanexar #txt_'+check.attr('id')).attr('disabled', false);
            $('#frm-docanexar #txt_'+check.attr('id')).focus();
            
          } else {
            var check=$(this);
            $('#frm-docanexar #period_'+check.attr('id')).val('');
            $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', true);
            $('#frm-docanexar #txt_'+check.attr('id')).attr('disabled', true);
            $('#frm-docanexar #txt_'+check.attr('id')).val("");
          }
    });
  });

  $("#frm-docanexar").submit(function(event) {
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var cins=$("#fdacodins").val();
    var arrdata = [];

    $('#frm-docanexar input[type=checkbox]').each(function () {
          if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(2);
            var detalle = $('#frm-docanexar #txt_'+check.attr('id')).val();
            var periodo = $('#frm-docanexar #period_'+check.attr('id')).val();

            var myvals = [valor, detalle, periodo];
            arrdata.push(myvals);
          }
    });
    //************************************
    $.ajax({
      url: base_url + 'inscrito/fn_insertdocs',
      type: 'post',
      dataType: 'json',
      data: {
              'ce-idins': cins,
              'filas': JSON.stringify(arrdata),
          },
      success: function(e) {
          $('#divboxhistorial #divoverlay').remove();
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'Error!',
                  text: e.msg,
                  backdrop: false,
              })
          } else {
              /*$("#fm-txtidmatricula").html(e.newcod);*/
              $('#modal-docporanexar').modal('hide')
              Swal.fire({
                  type: 'success',
                  icon: 'success',
                  title: 'Actualización correcta',
                  text: 'Se ha actualizaron los datos de la inscripción',
                  backdrop: false,
              })

              
              
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divboxhistorial #divoverlay').remove();
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
    //***************************************
  });

  $(".btn-excel").click(function(e) {
    e.preventDefault();
    
    $('#frm-filtro-inscritos input,select').removeClass('is-invalid');
    $('#frm-filtro-inscritos .invalid-feedback').remove();

    var url=base_url + 'admision/inscripciones/excel?cp=' + $("#fbus-periodo").val() + '&cc=' + $("#fbus-carrera").val()  + '&tn=' +  $("#fbus-turno").val()  + '&cl=' +  $("#fbus-ciclo").val() + '&ccp=' + $("#fbus-campania").val() + '&cs=' + $("#fbus-seccion").val() +'&ap=' + $("#fbus-txtbuscar").val();
    var llenos=0;
    if ($("#fbus-txtbuscar").val()!=="") llenos=llenos + 2;
    if ($("#fbus-periodo").val()!=="%") llenos++;
    if ($("#fbus-campania").val()!=="%") llenos++;
    if ($("#fbus-seccion").val()!=="%") llenos++;
    if ($("#fbus-carrera").val()!=="%") llenos++;
    if ($("#fbus-turno").val()!=="%") llenos++;
    if ($("#fbus-ciclo").val()!=="%") llenos++;
    //var ejecuta=false;
    /*if ($.trim($("#fbus-txtbuscar").val())=='%%%%'){
      if (($("#fbus-periodo").val()!="%") || ($("#fbus-carrera").val()!="%")){
        ejecuta=true;
      }
      else{
        $('#fbus-carrera').addClass('is-invalid');
        $('#fbus-carrera').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
        $('#fbus-periodo').addClass('is-invalid');
        $('#fbus-periodo').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
      }
    }else if($.trim($("#fbus-txtbuscar").val()).length>3){
      ejecuta=true;
    }
    else{
        $('#fbus-txtbuscar').addClass('is-invalid');
        $('#fbus-txtbuscar').parent().append("<div class='invalid-feedback'> Ingrese mínimo 4 caracteres o %%%%</div>");
    }*/
    if (llenos>1) {
      window.open(url, '_blank');
    }
    else{
      $("#divres-historial").html("");
      $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $('#divboxhistorial #divoverlay').remove();
      
      $("#divres-historial").html("<span class='text-danger'>Recuerda: Indicar como minimo 2 parametros de búsqueda</span>");      
    }
  });

  $('#modretirainsc').on('show.bs.modal', function (e) {
      var rel = $(e.relatedTarget);
      tbinscritos = $('#tbmt_dtinscritos').DataTable();
      div = tbinscritos.$('tr.selected');
      // var div = rel.parents('.cfila');
      var codigo = div.data('ci');
      var periodo = div.data('cp');
      var estado = rel.data('ie');
      var color = rel.data('color');
      
      $('#fic_inscrip_codigo').val(codigo);
      $('#ficinscestado').val(estado);
      $('#lbtn_retira_insc').data('coloran', color);
      $('#ficinsperiodo').val(periodo);

  });

  $('#lbtn_retira_insc').click(function() {
      var color = $(this).data('coloran');
      
      $('#form_retira_insc input,select,textarea').removeClass('is-invalid');
      $('#form_retira_insc .invalid-feedback').remove();
      $('#divmodalretirar').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: $('#form_retira_insc').attr("action"),
          type: 'post',
          dataType: 'json',
          data: $('#form_retira_insc').serialize(),
          success: function(e) {
              $('#divmodalretirar #divoverlay').remove();
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
                  $('#modretirainsc').modal('hide');
                  
                  var btnret = $('#btnretira_inscrip'+e.idinscrip);
                  var btdt = btnret.parents(".btn-group").find('.dropdown-toggle');
                  var textoan = btnret.html();

                  btdt.removeClass('btn-danger');
                  btdt.removeClass('btn-success');
                  btdt.removeClass('btn-warning');
                  btdt.removeClass('btn-secondary');
                  btdt.removeClass('btn-info');

                  btdt.addClass(color);
                  btdt.html(textoan);

                  $('#btn-group-'+e.idinscrip+' .btn-cestado').hide();
                  $('#btn-group-'+e.idinscrip+' #btnretira_inscrip'+e.idinscrip).hide();
                  //btn-cestado
                  // $('#btn-group-'+e.idinscrip).hide();
                  // $('#btn-group-'+e.idinscrip).after('<button class="btn '+color+' btn-sm py-0" type="button"> '+
                  //     textoan+
                  //   '</button>');
                  
                  Swal.fire({
                      type: 'success',
                      icon: 'success',
                      title: 'Felicitaciones, inscripción cambio a retirado',
                      text: 'Se ha retirado la inscripción',
                      backdrop: false,
                  })
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'text');
              $('#divmodalretirar #divoverlay').remove();
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

  function grupo_inscripcion(btn){
    // tbinscritos = $('#tbmt_dtinscritos').DataTable();
    // fila = tbinscritos.$('tr.selected');
    var fila=btn.closest(".cfila");
    var codinscripcion=fila.data("ci");
    var codperiodo=fila.data("cp");
    var carrera=fila.data("carrera");
    var codturno=fila.data("codturno");
    var codseccion=fila.data("codseccion");
    var codciclo=fila.data("codciclo");
    var codcampania=fila.data("codcampania");
    //TRAER LAS CAMPAÑIAS
    $("#modgrupoingreso").modal("show");
    $('#vw_md_gi_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'campania/fn_campania_por_periodo',
        type: 'post',
        dataType: 'json',
        data: {
                'txtcodperiodo': codperiodo
            },
        success: function(e) {
            $('#vw_md_gi_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    title: 'Error!',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                if (e.count==0){
                   Swal.fire({
                      type: 'warning',
                      title: 'ADVERTENCIA!',
                      text: "No existe campaña registrada para el periodo " + codperiodo + ", contacte al administrador",
                      backdrop: false,
                  });
                   $("#modgrupoingreso").modal("hide");
                }
                else{
                  $("#vw_md_gi_campania").html(e.vdata);
                  $("#vw_md_gi_inscrip_codigo").val(codinscripcion);
                  $("#vw_md_gi_spperiodo").html(codperiodo);
                  $("#vw_md_gi_periodo").val(codperiodo);
                  $("#vw_md_gi_carrera").html(carrera);
                  $("#vw_md_gi_turno").val(codturno);
                  $("#vw_md_gi_seccion").val(codseccion);
                  $("#vw_md_gi_ciclo").val(codciclo);
                  $("#vw_md_gi_campania").val(codcampania);
                  
                  
                }
                
            }
        },
        error: function(jqXHR, exception) {
          $("#modgrupoingreso").modal("hide");
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_md_gi_content #divoverlay').remove();
            Swal.fire({
                type: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
            })
        }
      });
      //FIN TRAER CAMAPANIAS
  }

  $('#vw_md_gi_btnguardar').click(function() {
      
      $('#vw_md_gi_frmcambiargrupo input,select,textarea').removeClass('is-invalid');
      $('#vw_md_gi_frmcambiargrupo .invalid-feedback').remove();
      $('#vw_md_gi_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: $('#vw_md_gi_frmcambiargrupo').attr("action"),
          type: 'post',
          dataType: 'json',
          data: $('#vw_md_gi_frmcambiargrupo').serialize(),
          success: function(e) {
              $('#vw_md_gi_content #divoverlay').remove();
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
                  $("#modgrupoingreso").modal("hide");
                  $("#frm-filtro-inscritos").submit();
                  
                  
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'text');
              $('#vw_md_gi_content #divoverlay').remove();
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

  $('#modactiva').on('hidden.bs.modal', function (e) {
    $('#form_activa_insc')[0].reset();
  })

  $('#lbtn_activa_insc').click(function() {
      var color = $(this).data('coloran');
      
      $('#form_activa_insc input,select,textarea').removeClass('is-invalid');
      $('#form_activa_insc .invalid-feedback').remove();
      $('#divmodalactivar').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: $('#form_activa_insc').attr("action"),
          type: 'post',
          dataType: 'json',
          data: $('#form_activa_insc').serialize(),
          success: function(e) {
              $('#divmodalactivar #divoverlay').remove();
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
                  $('#modactiva').modal('hide');
                  $("#frm-filtro-inscritos").submit();

                  
                  Swal.fire({
                      type: 'success',
                      icon: 'success',
                      title: 'Felicitaciones, inscripción ha sido actualizado',
                      text: 'Se ha actualizado la inscripción',
                      backdrop: false,
                  })
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'text');
              $('#divmodalactivar #divoverlay').remove();
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

  $('.checkman').change(function(e) {
    docarray = [];
    $('#modanexadocs input[type=checkbox]').each(function () {
        if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(3);
            var abrev = check.data('abrev');
            $('#period_'+check.attr('id')).attr('disabled', false);
            $('#txt_'+check.attr('id')).attr('disabled', false);
            $('#txt_'+check.attr('id')).focus();

            docarray.push(abrev);
            
        } else {
            var check=$(this);
            $('#period_'+check.attr('id')).val('');
            $('#period_'+check.attr('id')).attr('disabled', true);
            $('#txt_'+check.attr('id')).attr('disabled', true);
            $('#txt_'+check.attr('id')).val("");
        }
    });
    docsanex = JSON.stringify(docarray);
    if (docarray.length > 0) {
      $('#btn_docanex').html("Documentos anexados: "+docsanex);
    } else {
      $('#btn_docanex').html("Documentos anexados");
    }
    
  });

  $('#modanexadocs').on('show.bs.modal', function (e) {
    $('#msgcarrera').html('');
    if ($('#ficbcarrera').val !== "0") $('#msgcarrera').html($('option:selected', $('#ficbcarrera')).data('nombre'));
  })

  $('#lbtn_send').click(function(e) {
    $("#vw_md_em_aviso").html("");
    checksaludo = ($("#checksaludo").prop('checked') == true ? "SI" : "NO");
    checkcreden = ($("#checkcredenciales").prop('checked') == true ? "SI" : "NO");
    checkmanuales = ($("#checkmanuales").prop('checked') == true ? "SI" : "NO");
    checkficha = ($("#checkficha").prop('checked') == true ? "SI" : "NO");
    email = $('#fictxtemailper').val();
    periodo = $('#fictxtperiodo').val();
    carnet = $('#fictxtcarnet').val();
    codigo = $('#fictxtcodigo').val();
    $('#divmodalsend').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#lbtn_send").hide();
    $.ajax({
      url: base_url + "inscrito/fn_send_mensaje",
      type: 'post',
      dataType: 'json',
      data: {
        checksaludo: checksaludo,
        checkcreden: checkcreden,
        checkmanuales: checkmanuales,
        checkficha: checkficha,
        email: email,
        periodo: periodo,
        carnet: carnet,
        txtcodigo: codigo
      },
      success: function(e) {
          $('#divmodalsend #divoverlay').remove();
          if (e.status == false) {
            $("#vw_md_em_aviso").html("<h4 class='text-danger'>Error al enviar</h4>" + e.msg);
            $("#lbtn_send").show();
          } else {
            if (e.mail_status==true){
              $("#vw_md_em_aviso").html("<h4 class='text-success'>Enviado correctamente</h4>" + e.mail_msg);
            }
            else{
               $("#vw_md_em_aviso").html("<h4 class='text-danger'>Error al enviar</h4>" + e.mail_msg);
               $("#lbtn_send").show();
            }
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception,'text');
          $('#divmodalsend #divoverlay').remove();
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

  function fn_cambiarestado(btn) {
    var fila = btn.parents(".cfila");
    var im = fila.data('ci');
    var cp = fila.data('cp');
    var ie = btn.data('ie');
    var color = btn.data('color');
    var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
    var texto = btn.html();
    var btnmat = fila.find('.histo_mat');
    //alert(btdt.html());
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'inscrito/fn_cambiarestado',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-idmat': im,
            'ce-nestado': ie,
            'ce-periodo': cp
        },
        success: function(e) {
            $('#divboxhistorial #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    icon: 'error',
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
                    icon: 'success',
                })

                $('#lbtn_mreing'+e.idinscrip).addClass('not-active');

                btdt.removeClass('btn-danger');
                btdt.removeClass('btn-success');
                btdt.removeClass('btn-warning');
                btdt.removeClass('btn-secondary');
                btdt.removeClass('btn-info');

                btdt.addClass(color);
                btdt.html(texto);

                btnmat.data('estado', texto.toUpperCase());
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divboxhistorial #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
            })
        }
    });
  }

  function fn_eliminar_ins(btn) {
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var cins = btn.data("ci");
    var fila = btn.parents(".cfila");
    var carne = fila.find('.cell-carne').html();
    //************************************
    Swal.fire({
      title: "Precaución",
      text: "Se eliminarán todos los datos con respecto a este INSCRIPCIÓN ",
      type: 'warning',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
              //var codc=$(this).data('im');
            $.ajax({
              url: base_url + 'inscrito/fn_eliminar',
              type: 'post',
              dataType: 'json',
              data: {
                      'ce-idins': cins,
                      'ce-carne': carne
                  },
              success: function(e) {
                  $('#divboxhistorial #divoverlay').remove();
                  if (e.status == false) {
                      Swal.fire({
                          type: 'error',
                          icon: 'error',
                          title: 'Error!',
                          text: e.msg,
                          backdrop: false,
                      })
                  } else {
                      /*$("#fm-txtidmatricula").html(e.newcod);*/
                      Swal.fire({
                          type: 'success',
                          icon: 'success',
                          title: 'Eliminación correcta',
                          text: 'Se ha eliminado la inscripción',
                          backdrop: false,
                      })
                      
                      fila.remove();
                  }
              },
              error: function(jqXHR, exception) {
                  var msgf = errorAjax(jqXHR, exception, 'text');
                  $('#divboxhistorial #divoverlay').remove();
                  Swal.fire({
                      type: 'error',
                      icon: 'error',
                      title: 'Error',
                      text: msgf,
                      backdrop: false,
                  })
              }
          });
        }
        else{
          $('#divboxhistorial #divoverlay').remove();
        }
    });
  }

  $('#modal-docporanexar').on('show.bs.modal', function (e) {
    $("#lista-ok").addClass('ocultar');
    $("#lista-no").removeClass('ocultar');
    btn= $(e.relatedTarget);
    var cins=btn.data('ci');
    var carrera = btn.data('carrera');
    $("#fdacodins").val(cins);
    var fila=btn.parents(".cfila");
    var carne=fila.find('.cell-carne').html();
    var alumno=fila.find('.cell-alumno').html();
      //$('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $("#frm-docanexar #spn-carne").html(carne);
      $("#frm-docanexar #spn-alumno").html(alumno);
      $("#frm-docanexar #spn_carrera").html(carrera);
      $('#frm-docanexar input[type=checkbox]').prop('checked', false);
    $.ajax({
          url: base_url + 'inscrito/fn_getdocanexados',
          type: 'post',
          dataType: 'json',
          data: {
                  'ce-idins': cins
              },
          success: function(e) {
              //$('#divboxhistorial #divoverlay').remove();
              $("#lista-ok").removeClass('ocultar');
              $("#lista-no").addClass('ocultar');
              if (e.status == false) {
                  Swal.fire({
                      type: 'error',
                      title: 'Error!',
                      text: e.msg,
                      backdrop: false,
                  })
              } else {
                  /*$("#fm-txtidmatricula").html(e.newcod);*/
                
                $('#frm-docanexar input[type=checkbox]').each(function () {
               //if (this.checked) {
                var check=$(this);
                var valor=check.attr('id').substring(2);
                $('#frm-docanexar #period_'+check.attr('id')).val('');
                $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', true);
                $('#frm-docanexar #txt_'+check.attr('id')).val('');
                $('#frm-docanexar #txt_'+check.attr('id')).prop('disabled', true);
                $.each(e.vdata, function(index, v) {
                  if (v['coddoc']==valor){
                    check.prop('checked', true);
                    $('#frm-docanexar #period_'+check.attr('id')).val(v['periodo']);
                    $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', false);
                    $('#frm-docanexar #txt_'+check.attr('id')).val(v['detalle']);
                    $('#frm-docanexar #txt_'+check.attr('id')).prop('disabled', false);
                    
                  }
                });

        });
                  
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              //$('#divboxhistorial #divoverlay').remove();
              Swal.fire({
                  type: 'error',
                  title: 'Error',
                  text: msgf,
                  backdrop: false,
              })
          }
      });
  })

  $('#modal-sendemail').on('show.bs.modal', function (e) {
    btn= $(e.relatedTarget);
    div = btn.parents('.cfila');
    periodo = div.data('cp');
    email = btn.data('emailper');
    carnet = btn.data('carnet');
    codigo = btn.data('ci');
    $('#fictxtemailper').val(email);
    $('#fictxtperiodo').val(periodo);
    $('#fictxtcarnet').val(carnet);
    $('#fictxtcodigo').val(codigo);
  })

  $('#modal-sendemail').on('hidden.bs.modal', function (e) {
    $("#vw_md_em_aviso").html("");
    $("#lbtn_send").show();
  })

  function fn_modactiva (btn) {
    var div = btn.parents('.cfila');
    var codigo = div.data('ci');
    var periodo = div.data('cp');
    var estado = btn.data('ie');
    console.log("estado", estado);
    var color = btn.data('color');

    $('#fic_inscodigo_activa').val(codigo);
    $('#ficinscestado_activa').val(estado);
    $('#ficinsperiodo_activa').val(periodo)
    $('#lbtn_activa_insc').data('coloran', color);

    $('#modactiva').modal('show');
  }

  function cargar_historial_matriculas(btn) {
    var fila = btn.closest('.cfila');
    var carnet = btn.data('carnet');
    var insestado = btn.data('estado');
    var vestudiante = fila.find('.cell-estudiante').html();
    $('#vw_dp_mc_matriculas').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('#msghistorial_estudiante').html("");
    $('#vw_md_historial_mat').modal();
    tblhistorial = "";
    $.ajax({
        url: base_url + 'matricula/fn_historial_matricula',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-carne': carnet
        },
        success: function(e) {
            $('#vw_dp_mc_matriculas #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Error!',
                    text: e.msg,
                    backdrop: false,
                })
                
            } 
            else {
                var estado = "";
                codciclo = "";
                nro = 0;
                conteo = e.vdata.length;
                
                if (conteo > 0){
                  tbmatriculados = $('#tbmt_dtmatriculas').DataTable();
                  tbmatriculados.clear();
                  $.each(e.vdata, function(index, v) {
                    nro++;
                    var vcm = v['codmatricula64'];
                    var btnscolor = "";
                    var textobs = (v['observacion']!= "") ? v['observacion'] : "Ninguna";
                    var observacion = "<br><b>Observación:</b><br>"+textobs;
                    if (v['estado'] != "RES") {
                      estado = v['estado'];
                    }
                    
                    codciclo = v['codciclo'];
                    switch (v['estado']) {
                        case "ACT":
                            btnscolor = "btn-success";
                            break;
                        case "CUL":
                            btnscolor = "btn-secondary";
                            break;
                        case "DES":
                            btnscolor = "btn-danger";
                            break;
                        case "RET":
                            btnscolor = "btn-danger";
                            break;
                        default:
                            btnscolor = "btn-warning";
                    }

                    dropdown_estado = '<div class="btn-group">' +
                        '<button class="btn ' + btnscolor + ' btn-sm text-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="estado'+vcm+'">' +
                        v['estado'] +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<a href="#" onclick="fn_cambiarestado_mat($(this))" class="dropdown-item" data-campo="tabla" data-ie="' + cd1 + '">Activo</a>' +
                        '<a href="#" onclick="fn_cambiarestado_mat($(this))" class="dropdown-item" data-campo="tabla" data-ie="' + cd2 + '">Retirado</a>' +
                        '<a href="#" onclick="fn_cambiarestado_mat($(this))" class="dropdown-item" data-campo="tabla" data-ie="' + cd7 + '">Desaprobado</a>' +
                        '<div class="dropdown-divider"></div>' +
                        '<a href="#" onclick="fn_eliminar_matricula($(this))" class="btn-ematricula dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
                        '</div>' +
                        '</div>';
                    sexo = (v['codsexo'] == "FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
                    estudiante = sexo + v['paterno'] + " " + v['materno'] + " " + v['nombres'] + " " + v['edad'];
                    fecharegistro = v['registro'] + " <a href='#' class='view_user_reg' tabindex='0' role='button' data-toggle='popover' data-trigger='hover' title='Matriculado por: ' data-content='"+v['usuario']+observacion+"'><i class='fas fa-info-circle fa-lg'></i></a>";
                    vcuota = v['vpension'] + " ("+v['beneficio']+")";
                    grupo = v['periodo'] + " " + v['sigla'] + " " + v['codturno'] + " " + v['ciclo'] + " " + v['codseccion'];

                    var fila = tbmatriculados.row.add([index + 1, v['sede_abrevia'], v['carne'], estudiante, fecharegistro, vcuota, v['plan'], grupo, dropdown_estado]).node();
                    $(fila).attr('data-codmatricula64', v['codmatricula64']);
                    $(fila).attr('data-estudiante', v['paterno'] + " " + v['materno'] + " " + v['nombres']);
                      
                  })
                  
                  // $('#msghistorial_estudiante').html(tblhistorial);
                  tbmatriculados.draw();
                  // $('#vw_dp_mc_matriculas #divoverlay').remove();
                  $('.view_user_reg').popover({
                    trigger: 'hover',
                    html: true
                  })
                  $("#vw_dp_mc_btn_nuevamatricula").attr('href', base_url + "gestion/academico/matriculas?sb=academico&fcarnet=" + carnet);
                } else {
                  if (insestado == "ACTIVO") {
                    $('#vw_dp_mc_matriculas').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                    window.location.href =base_url + "gestion/academico/matriculas?sb=academico&fcarnet=" + carnet;
                  } else {
                    
                    Swal.fire({
                        type: 'warning',
                        icon: 'warning',
                        title: 'Aviso!',
                        text: "El estado del estudiante no esta activo",
                        backdrop: false,
                    }).then(function(result){
                        if(result.value){
                           $('#vw_md_historial_mat').modal('hide');
                        }
                    })
                    
                  }
                  
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_dp_mc_matriculas #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
            })
        }
    });
  }

  $('#vw_md_historial_mat').on('hidden.bs.modal', function (e) {
    $('#vw_md_historial_mat .tbdatatable tbody').html("");
  })

  function fn_cambiarestado_mat(btn) {
    tbmatriculados = $('#tbmt_dtmatriculas').DataTable();
    fila = tbmatriculados.$('tr.selected');
    im = fila.data('codmatricula64');
    var ie = btn.data('ie');
    var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
    var texto = btn.html();
    var contenedor = btn.data('campo');
    $('#vw_dp_mc_matriculas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    
    $.ajax({
        url: base_url + 'matricula/fn_cambiarestado',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-idmat': im,
            'ce-nestado': ie
        },
        success: function(e) {
            $('#vw_dp_mc_matriculas #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Error!',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                /*$("#fm-txtidmatricula").html(e.newcod);*/
                Swal.fire({
                    type: 'success',
                    icon: 'success',
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
                    case "Retirado":
                        btdt.addClass('btn-danger');
                        btdt.html("RET");
                        break;
                    case "Desaprobado":
                        btdt.addClass('btn-danger');
                        btdt.html("DES");
                        break;
                    default:
                        btdt.addClass("btn-warning");
                }
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_dp_mc_matriculas #divoverlay').remove();
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

</script>